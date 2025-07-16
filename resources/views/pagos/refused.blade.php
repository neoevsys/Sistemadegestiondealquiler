@extends('layouts.main')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <!-- Icono de error -->
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <!-- Título -->
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Pago Rechazado
            </h2>
            
            <!-- Mensaje -->
            <p class="text-lg text-gray-600 mb-8">
                Tu pago no pudo ser procesado. Por favor, verifica los datos de tu tarjeta e intenta nuevamente.
            </p>
            
            <!-- Detalles de la reserva -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8 text-left">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles de la Reserva</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Instalación:</span>
                        <span class="font-medium">{{ $reserva->instalacion->nombre }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Centro:</span>
                        <span class="font-medium">{{ $reserva->instalacion->centroDeportivo->nombre }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Fecha:</span>
                        <span class="font-medium">{{ Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Horario:</span>
                        <span class="font-medium">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</span>
                    </div>
                    <div class="flex justify-between border-t pt-3">
                        <span class="text-gray-600">Total a pagar:</span>
                        <span class="font-bold text-red-600">S/{{ number_format($reserva->precio_total, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Posibles causas -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8 text-left">
                <h4 class="font-semibold text-yellow-800 mb-2">Posibles causas del rechazo:</h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• Fondos insuficientes en la tarjeta</li>
                    <li>• Datos de la tarjeta incorrectos</li>
                    <li>• Tarjeta vencida o bloqueada</li>
                    <li>• Problemas con la entidad bancaria</li>
                    <li>• Límites de compra excedidos</li>
                </ul>
            </div>
            
            <!-- Botones de acción -->
            <div class="space-y-4">
                <a href="{{ route('pagos.form', $reserva->id) }}" 
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors inline-block">
                    Intentar Nuevamente
                </a>
                
                <a href="{{ route('reservas.show', $reserva->id) }}" 
                   class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg transition-colors inline-block">
                    Ver Mi Reserva
                </a>
                
                <a href="{{ route('reservas.index') }}" 
                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium py-3 px-6 rounded-lg transition-colors inline-block">
                    Ver Todas Mis Reservas
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Mostrar notificación de error
document.addEventListener('DOMContentLoaded', function() {
    // Crear notificación toast
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    toast.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Pago rechazado. Intenta nuevamente.</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animar entrada
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Animar salida después de 5 segundos
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 5000);
});
</script>
@endsection
