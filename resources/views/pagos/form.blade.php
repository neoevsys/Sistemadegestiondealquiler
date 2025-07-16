@extends('layouts.main')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<script
    type="text/javascript"
    src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
    kr-public-key="{{ config('services.izipay.public_key') }}"
    kr-post-url-success="{{ route('pagos.process') }}"
    kr-language="es-ES">
</script>
<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-blue-700 mb-6">Pagar Reserva</h1>
            
            <!-- Resumen de la reserva -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Resumen de la Reserva</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Instalación:</span>
                                <span class="font-semibold">{{ $reserva->instalacion->nombre }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Centro:</span>
                                <span class="font-semibold">{{ $reserva->instalacion->centroDeportivo->nombre }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Fecha:</span>
                                <span class="font-semibold">{{ Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Horario:</span>
                                <span class="font-semibold">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duración:</span>
                                <span class="font-semibold">{{ $reserva->duracion_horas }} {{ $reserva->duracion_horas == 1 ? 'hora' : 'horas' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Precio por hora:</span>
                                <span class="font-semibold">S/{{ number_format($reserva->instalacion->precio_por_hora, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-lg font-bold text-gray-800">Total a pagar:</span>
                                <span class="text-2xl font-bold text-blue-600">S/{{ number_format($reserva->precio_total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario nativo de pago Izipay -->
            <div class="bg-white rounded-lg border-2 border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Información de Pago</h3>

                @php
                    // Puedes obtener el formToken en el controlador y pasarlo a la vista
                    // $formToken = ... (esto lo generas en tu controlador y lo envías con compact())
                @endphp

                @if(isset($formToken) && $formToken)
                    <!-- === ESTE DIV ES LO ÚNICO QUE NECESITAS PARA QUE IZIPAY FUNCIONE NATIVO === -->
                    <div class="kr-embedded" kr-popin kr-form-token="{{ $formToken }}">
                        <div class="kr-pan"></div>
                        <div class="kr-expiry"></div>
                        <div class="kr-security-code"></div>
                        <button class="kr-payment-button">Pagar con Tarjeta</button>
                        <div class="kr-form-error"></div>
                    </div>
                @else
                    <div class="text-red-600 font-bold">No se pudo inicializar el sistema de pago. Intenta más tarde.</div>
                @endif

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('reservas.show', $reserva->id) }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        Volver a la Reserva
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de procesamiento -->
<div id="processing-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-8 max-w-md mx-4">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Procesando pago...</h3>
            <p class="text-gray-600">Por favor, espera mientras procesamos tu pago.</p>
        </div>
    </div>
</div>

<!-- Modal de éxito -->
<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-8 max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">¡Pago exitoso!</h3>
            <p class="text-gray-600 mb-4">Tu pago ha sido procesado correctamente. Serás redirigido a tu reserva en unos segundos.</p>
            <div class="flex justify-center">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de error -->
<div id="error-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-8 max-w-md mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Error en el pago</h3>
            <p id="error-message" class="text-gray-600 mb-4">Ocurrió un error al procesar el pago. Por favor, intenta nuevamente.</p>
            <button onclick="closeErrorModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                Cerrar
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar SweetAlert si hay mensaje de error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session('error') }}',
            confirmButtonText: 'Intentar nuevamente',
            confirmButtonColor: '#dc3545',
            showCancelButton: true,
            cancelButtonText: 'Volver a mi reserva',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = '{{ route('reservas.show', $reserva->id) }}';
            }
        });
    @endif

    // Configuración mínima según documentación de Izipay
    KR.onFormReady(function() {
        console.log('Payment form ready');
    });

    // Solo mostrar modal de procesamiento al hacer clic en pagar
    KR.onSubmit(function() {
        showProcessingModal();
        return true; // Permitir el envío
    });

    // Manejar errores de validación
    KR.onError(function(error) {
        hideProcessingModal();
        Swal.fire({
            icon: 'error',
            title: 'Error en el pago',
            text: error.message,
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#dc3545'
        });
    });
});

function showProcessingModal() {
    document.getElementById('processing-modal').classList.remove('hidden');
}

function hideProcessingModal() {
    document.getElementById('processing-modal').classList.add('hidden');
}

function showErrorModal(message) {
    document.getElementById('error-message').textContent = message;
    document.getElementById('error-modal').classList.remove('hidden');
}

function closeErrorModal() {
    document.getElementById('error-modal').classList.add('hidden');
}
</script>

@endsection
