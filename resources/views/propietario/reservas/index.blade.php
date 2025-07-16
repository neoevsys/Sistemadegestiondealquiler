@extends('layouts.main')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Reservas</h1>
                    <p class="mt-1 text-gray-500">Administra todas las reservas de tus centros deportivos</p>
                </div>
                <a href="{{ route('propietario.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                    Volver al Dashboard
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-yellow-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendientes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['pendientes'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Confirmadas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['confirmadas'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Canceladas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['canceladas'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Completadas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['completadas'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Reservas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Todas las Reservas</h2>
            </div>

            @if($reservas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Centro / Instalación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha y Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pago</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reservas as $reserva)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700">{{ substr($reserva->usuario->nombre, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $reserva->usuario->nombre }}</div>
                                                <div class="text-sm text-gray-500">{{ $reserva->usuario->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reserva->instalacion->centroDeportivo->nombre }}</div>
                                        <div class="text-sm text-gray-500">{{ $reserva->instalacion->nombre }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $reserva->duracion_horas }} {{ $reserva->duracion_horas == 1 ? 'hora' : 'horas' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        S/{{ number_format($reserva->precio_total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($reserva->estado_id == 1) bg-yellow-100 text-yellow-800
                                            @elseif($reserva->estado_id == 2) bg-green-100 text-green-800
                                            @elseif($reserva->estado_id == 3) bg-red-100 text-red-800
                                            @elseif($reserva->estado_id == 4) bg-blue-100 text-blue-800
                                            @endif">
                                            @if($reserva->estado_id == 1) Pendiente
                                            @elseif($reserva->estado_id == 2) Confirmada
                                            @elseif($reserva->estado_id == 3) Cancelada
                                            @elseif($reserva->estado_id == 4) Completada
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reserva->pago && $reserva->pago->estado_id == 1)
                                            <!-- Pago completado -->
                                            <div class="flex flex-col items-center space-y-1">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    ✓ Pagado
                                                </span>
                                                <button onclick="openPaymentModal({{ json_encode($reserva->pago) }}, '{{ $reserva->usuario->nombre }}', '{{ $reserva->instalacion->nombre }}')" 
                                                        class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs font-semibold transition-colors">
                                                    Ver Pago
                                                </button>
                                            </div>
                                        @elseif($reserva->pago && $reserva->pago->estado_id == 2)
                                            <!-- Pago pendiente -->
                                            <div class="flex flex-col items-center space-y-1">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    ⏳ Pendiente
                                                </span>
                                                <button onclick="openPaymentModal({{ json_encode($reserva->pago) }}, '{{ $reserva->usuario->nombre }}', '{{ $reserva->instalacion->nombre }}')" 
                                                        class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs font-semibold transition-colors">
                                                    Ver Pago
                                                </button>
                                            </div>
                                        @else
                                            <!-- Sin pago -->
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                ❌ Sin pago
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($reserva->estado_id == 1)
                                                <!-- Reserva pendiente - puede confirmar o cancelar -->
                                                <form action="{{ route('propietario.reservas.confirmar', $reserva) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded text-xs font-semibold transition-colors" onclick="return confirm('¿Confirmar esta reserva?')">
                                                        Confirmar
                                                    </button>
                                                </form>
                                                <form action="{{ route('propietario.reservas.cancelar', $reserva) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded text-xs font-semibold transition-colors" onclick="return confirm('¿Cancelar esta reserva?')">
                                                        Cancelar
                                                    </button>
                                                </form>
                                            @elseif($reserva->estado_id == 2)
                                                <!-- Reserva confirmada - solo puede cancelar -->
                                                <form action="{{ route('propietario.reservas.cancelar', $reserva) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded text-xs font-semibold transition-colors" onclick="return confirm('¿Cancelar esta reserva confirmada?')">
                                                        Cancelar
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Reserva cancelada o completada - sin acciones -->
                                                <span class="text-gray-400 text-xs">Sin acciones</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $reservas->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sin reservas</h3>
                    <p class="mt-1 text-sm text-gray-500">Aún no hay reservas en tus centros deportivos.</p>
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
                <h3 class="text-lg font-semibold text-gray-900">Información del Pago</h3>
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

<!-- Scripts -->
<script>
// Función para abrir el modal de pago
function openPaymentModal(pago, cliente, instalacion) {
    // Llenar la información del modal
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

// Función para mostrar notificaciones
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Animar salida después de 5 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}

// Eventos del documento
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar notificaciones si existen
    @if(session('success'))
        showNotification('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showNotification('{{ session('error') }}', 'error');
    @endif
    
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
