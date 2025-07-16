@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Pagos</h1>
                    <p class="mt-1 text-sm text-gray-600">Administra todas las transacciones del sistema</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                        ← Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Resumen de pagos -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Total Pagos</p>
                        <p class="text-2xl font-bold text-gray-900">S/{{ number_format($resumen_pagos['total_pagos'], 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Pagos Hoy</p>
                        <p class="text-2xl font-bold text-gray-900">S/{{ number_format($resumen_pagos['pagos_hoy'], 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Pagos este Mes</p>
                        <p class="text-2xl font-bold text-gray-900">S/{{ number_format($resumen_pagos['pagos_mes'], 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Pagos este Año</p>
                        <p class="text-2xl font-bold text-gray-900">S/{{ number_format($resumen_pagos['pagos_año'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de pagos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Historial de Pagos</h2>
            </div>

            @if($pagos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instalación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transacción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pagos as $pago)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700">{{ substr($pago->reserva->usuario->nombre, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $pago->reserva->usuario->nombre }}</div>
                                                <div class="text-sm text-gray-500">{{ $pago->reserva->usuario->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $pago->reserva->instalacion->nombre }}</div>
                                        <div class="text-sm text-gray-500">{{ $pago->reserva->instalacion->centroDeportivo->nombre ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">S/{{ number_format($pago->monto, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($pago->estado_id == 1) bg-green-100 text-green-800
                                            @elseif($pago->estado_id == 2) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            @if($pago->estado_id == 1)
                                                ✓ Completado
                                            @elseif($pago->estado_id == 2)
                                                ⏳ Pendiente
                                            @else
                                                ❌ Fallido
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div>{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $pago->fecha_pago ? $pago->fecha_pago->format('H:i') : '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $pago->numero_transaccion ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ $pago->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="openPaymentModal({{ json_encode($pago) }}, '{{ $pago->reserva->usuario->nombre }}', '{{ $pago->reserva->instalacion->nombre }}')" 
                                                class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded text-xs font-semibold transition-colors">
                                            👁️ Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pagos->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sin pagos</h3>
                    <p class="mt-1 text-sm text-gray-500">No hay pagos registrados en el sistema.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Información de Pago -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between pb-3 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Información Detallada del Pago</h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Contenido del Modal -->
            <div class="mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Información General -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Información General</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Cliente:</span>
                                <span class="font-medium text-gray-900" id="modal-cliente">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Instalación:</span>
                                <span class="font-medium text-gray-900" id="modal-instalacion">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Estado:</span>
                                <span class="font-medium" id="modal-estado">-</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detalles del Pago -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Detalles del Pago</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Monto:</span>
                                <span class="font-medium text-gray-900" id="modal-monto">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Fecha:</span>
                                <span class="font-medium text-gray-900" id="modal-fecha">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Método:</span>
                                <span class="font-medium text-gray-900" id="modal-metodo">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Información de Transacción -->
                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">Información de Transacción</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Número de Transacción:</span>
                            <span class="font-mono text-sm text-gray-900" id="modal-transaccion">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID de Pago:</span>
                            <span class="font-mono text-sm text-gray-900" id="modal-pago-id">-</span>
                        </div>
                    </div>
                </div>
                
                <!-- Datos de Transacción (JSON) -->
                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">Datos de la Transacción</h4>
                    <div class="bg-white rounded border p-3">
                        <pre class="text-xs text-gray-600 whitespace-pre-wrap max-h-40 overflow-y-auto" id="modal-datos-transaccion">-</pre>
                    </div>
                </div>
            </div>
            
            <!-- Footer del Modal -->
            <div class="flex justify-end pt-4 border-t mt-4">
                <button onclick="closePaymentModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Función para abrir el modal de pago
function openPaymentModal(pago, cliente, instalacion) {
    document.getElementById('modal-cliente').textContent = cliente;
    document.getElementById('modal-instalacion').textContent = instalacion;
    
    // Estado del pago
    const estadoElement = document.getElementById('modal-estado');
    if (pago.estado_id == 1) {
        estadoElement.innerHTML = '<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">✓ Completado</span>';
    } else if (pago.estado_id == 2) {
        estadoElement.innerHTML = '<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Pendiente</span>';
    } else {
        estadoElement.innerHTML = '<span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">❌ Fallido</span>';
    }
    
    // Detalles del pago
    document.getElementById('modal-monto').textContent = 'S/' + parseFloat(pago.monto).toFixed(2);
    document.getElementById('modal-fecha').textContent = pago.fecha_pago ? new Date(pago.fecha_pago).toLocaleString('es-PE') : 'N/A';
    document.getElementById('modal-metodo').textContent = pago.metodo_pago_id == 1 ? 'Tarjeta/Online' : 'Otro';
    
    // Información de transacción
    document.getElementById('modal-transaccion').textContent = pago.numero_transaccion || 'N/A';
    document.getElementById('modal-pago-id').textContent = pago.id || 'N/A';
    
    // Datos de transacción (JSON)
    let datosTransaccion = 'N/A';
    if (pago.datos_transaccion) {
        try {
            if (typeof pago.datos_transaccion === 'string') {
                datosTransaccion = JSON.stringify(JSON.parse(pago.datos_transaccion), null, 2);
            } else {
                datosTransaccion = JSON.stringify(pago.datos_transaccion, null, 2);
            }
        } catch (e) {
            datosTransaccion = pago.datos_transaccion;
        }
    }
    document.getElementById('modal-datos-transaccion').textContent = datosTransaccion;
    
    // Mostrar el modal
    document.getElementById('paymentModal').classList.remove('hidden');
}

// Función para cerrar el modal de pago
function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

// Eventos del documento
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar modal al hacer clic fuera de él
    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePaymentModal();
        }
    });
});

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentModal();
    }
});
</script>
@endsection
