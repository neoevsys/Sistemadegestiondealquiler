<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    /**
     * Crear un token de pago para Izipay
     */
    public function createPaymentToken(Request $request)
    {
        try {
            $reserva = Reserva::where('id', $request->reserva_id)
                ->where('usuario_id', Auth::id())
                ->firstOrFail();

            // Verificar que la reserva esté pendiente o confirmada
            if (!in_array($reserva->estado_id, [1, 2])) {
                return response()->json(['error' => 'La reserva no está disponible para pago'], 400);
            }

            // Crear el payload para Izipay
            $payload = [
                'amount' => (int)($reserva->precio_total * 100), // Convertir a centavos
                'currency' => 'PEN',
                'orderId' => 'RESERVA-' . $reserva->id . '-' . time(),
                'customer' => [
                    'email' => Auth::user()->email
                ]
            ];

            // Hacer la petición a Izipay
            $response = Http::withBasicAuth(
                config('services.izipay.username'),
                config('services.izipay.password')
            )->post(config('services.izipay.url'), $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'SUCCESS') {
                    return response()->json([
                        'success' => true,
                        'formToken' => $data['answer']['formToken'],
                        'publicKey' => config('services.izipay.public_key'),
                        'popupUrl' => config('services.izipay.popup_url')
                    ]);
                }
            }

            Log::error('Izipay payment token creation failed', [
                'response' => $response->body(),
                'reserva_id' => $reserva->id
            ]);

            return response()->json(['error' => 'Error al crear el token de pago'], 500);

        } catch (\Exception $e) {
            Log::error('Payment token creation error', [
                'error' => $e->getMessage(),
                'reserva_id' => $request->reserva_id
            ]);

            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Procesar la respuesta del pago
     */
    public function processPayment(Request $request)
    {
        try {
            Log::info('Payment processing request received', [
                'method' => $request->method(),
                'all_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            // Izipay envía los datos en diferentes formatos dependiendo del método
            $krAnswer = $request->input('kr-answer');
            $krAnswerType = $request->input('kr-answer-type');
            
            // Si no hay kr-answer, intentar obtener directamente los campos
            if (!$krAnswer) {
                // Buscar en todos los datos de la request
                $allData = $request->all();
                foreach ($allData as $key => $value) {
                    if (str_contains($key, 'answer') || str_contains($key, 'kr-')) {
                        Log::info("Found potential answer field: $key", ['value' => $value]);
                    }
                }
                
                Log::error('No kr-answer found in payment response', [
                    'all_request_data' => $allData,
                    'method' => $request->method()
                ]);
                
                return redirect()->route('reservas.index')
                    ->with('error', 'Respuesta de pago inválida. Por favor, intenta nuevamente.');
            }

            // Decodificar kr-answer si viene como string
            if (is_string($krAnswer)) {
                $krAnswer = json_decode($krAnswer, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('Error decoding kr-answer JSON', [
                        'kr_answer' => $krAnswer,
                        'json_error' => json_last_error_msg()
                    ]);
                    return redirect()->route('reservas.index')
                        ->with('error', 'Error al procesar la respuesta de pago.');
                }
            }

            Log::info('Decoded kr-answer', ['kr_answer' => $krAnswer]);

            // Extraer información del pago
            $orderId = $krAnswer['orderDetails']['orderId'] ?? null;
            $orderStatus = $krAnswer['orderStatus'] ?? null;
            $orderTotalAmount = $krAnswer['orderDetails']['orderTotalAmount'] ?? null;
            $transactionId = $krAnswer['transactions'][0]['uuid'] ?? null;
            $transactionStatus = $krAnswer['transactions'][0]['transactionStatusLabel'] ?? null;

            if (!$orderId) {
                Log::error('No orderId found in kr-answer', ['kr_answer' => $krAnswer]);
                return redirect()->route('reservas.index')
                    ->with('error', 'No se encontró el ID de la orden en la respuesta.');
            }

            // Extraer el ID de la reserva del orderId (formato: RESERVA-{id}-{timestamp})
            if (preg_match('/RESERVA-(\d+)-/', $orderId, $matches)) {
                $reservaId = $matches[1];
            } else {
                Log::error('Invalid orderId format', ['orderId' => $orderId]);
                return redirect()->route('reservas.index')
                    ->with('error', 'Formato de orden inválido.');
            }

            $reserva = Reserva::find($reservaId);
            if (!$reserva) {
                Log::error('Reserva not found', ['reserva_id' => $reservaId]);
                return redirect()->route('reservas.index')
                    ->with('error', 'Reserva no encontrada.');
            }

            // Verificar si ya existe un pago exitoso para esta reserva
            $pagoExistente = Pago::where('reserva_id', $reserva->id)
                ->where('estado_id', 1) // Completado
                ->first();

            if ($pagoExistente) {
                Log::info('Payment already exists for reservation', [
                    'reserva_id' => $reserva->id,
                    'existing_payment_id' => $pagoExistente->id
                ]);
                return redirect()->route('pagos.success', $reserva->id);
            }

            // Crear el registro de pago
            $pago = Pago::create([
                'reserva_id' => $reserva->id,
                'monto' => $orderTotalAmount ? ($orderTotalAmount / 100) : $reserva->precio_total, // Convertir de centavos
                'metodo_pago_id' => 1, // Tarjeta/online
                'estado_id' => $orderStatus === 'PAID' ? 1 : 2, // 1=completado, 2=pendiente
                'fecha_pago' => now(),
                'numero_transaccion' => $transactionId ?: 'TXN-' . time(),
                'datos_transaccion' => $request->all()
            ]);

            Log::info('Payment record created', [
                'pago_id' => $pago->id,
                'reserva_id' => $reserva->id,
                'order_status' => $orderStatus,
                'transaction_status' => $transactionStatus
            ]);

            // Actualizar el estado de la reserva si el pago fue exitoso
            if ($orderStatus === 'PAID') {
                $reserva->update([
                    'estado_id' => 2, // Confirmada
                    'fecha_modificacion' => now()
                ]);

                Log::info('Payment successful - reservation confirmed', [
                    'reserva_id' => $reserva->id,
                    'transaction_id' => $transactionId,
                    'amount' => $orderTotalAmount
                ]);

                return redirect()->route('pagos.success', $reserva->id);
            }

            Log::info('Payment not successful', [
                'reserva_id' => $reserva->id,
                'order_status' => $orderStatus,
                'transaction_status' => $transactionStatus
            ]);

            return redirect()->route('pagos.refused', $reserva->id);

        } catch (\Exception $e) {
            Log::error('Payment processing error', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('reservas.index')
                ->with('error', 'Error al procesar el pago. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Mostrar el formulario de pago
     */
    public function showPaymentForm($reservaId)
    {
        $reserva = Reserva::with(['instalacion.centroDeportivo', 'instalacion.tiposDeporte', 'pago'])
            ->where('id', $reservaId)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        // Verificar si la reserva ya está pagada
        $pagoExistente = $reserva->pago && $reserva->pago->estado_id == 1;
        if ($pagoExistente) {
            return redirect()->route('pagos.success', $reserva->id)
                ->with('success', 'Esta reserva ya está pagada.');
        }

        // Verificar que la reserva esté en estado válido para pago
        if (!in_array($reserva->estado_id, [1, 2])) {
            return redirect()->route('reservas.show', $reserva->id)
                ->with('error', 'Esta reserva no está disponible para pago');
        }

        $formToken = null;
        
        try {
            // Crear el payload para Izipay
            $payload = [
                'amount' => (int)($reserva->precio_total * 100), // Convertir a centavos
                'currency' => 'PEN',
                'orderId' => 'RESERVA-' . $reserva->id . '-' . time(),
                'customer' => [
                    'email' => Auth::user()->email,
                    'reference' => (string)Auth::id()
                ]
            ];

            // Hacer la petición a Izipay
            $response = Http::withBasicAuth(
                config('services.izipay.username'),
                config('services.izipay.password')
            )->post(config('services.izipay.url'), $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'SUCCESS') {
                    $formToken = $data['answer']['formToken'];
                }
            }

            if (!$formToken) {
                Log::error('Izipay form token creation failed', [
                    'response' => $response->body(),
                    'reserva_id' => $reserva->id,
                    'payload' => $payload
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Payment form token creation error', [
                'error' => $e->getMessage(),
                'reserva_id' => $reserva->id
            ]);
        }

        return view('pagos.form', compact('reserva', 'formToken'));
    }

    /**
     * Página de éxito del pago (redirección GET de Izipay)
     */
    public function paymentSuccess($reservaId)
    {
        $reserva = Reserva::with(['instalacion.centroDeportivo', 'instalacion.tiposDeporte'])
            ->where('id', $reservaId)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        return view('pagos.success', compact('reserva'));
    }

    /**
     * Página de pago rechazado (redirección GET de Izipay)
     */
    public function paymentRefused($reservaId)
    {
        $reserva = Reserva::with(['instalacion.centroDeportivo', 'instalacion.tiposDeporte'])
            ->where('id', $reservaId)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        return view('pagos.refused', compact('reserva'));
    }

}
