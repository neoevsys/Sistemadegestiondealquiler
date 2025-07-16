@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Reservas</h1>
                    <p class="mt-1 text-sm text-gray-600">Administra todas las reservas del sistema</p>
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
        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Total Reservas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $reservas->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Pendientes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $reservas->where('estado_id', 1)->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Confirmadas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $reservas->where('estado_id', 2)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Completadas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $reservas->where('estado_id', 4)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de reservas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Lista de Reservas</h2>
            </div>

            @if($reservas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instalación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha y Hora</th>
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
                                        <div class="text-sm text-gray-900">{{ $reserva->instalacion->nombre }}</div>
                                        <div class="text-sm text-gray-500">{{ $reserva->instalacion->centroDeportivo->nombre }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reserva->fecha_reserva }}</div>
                                        <div class="text-sm text-gray-500">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($reserva->estado_id == 1) bg-yellow-100 text-yellow-800
                                            @elseif($reserva->estado_id == 2) bg-green-100 text-green-800
                                            @elseif($reserva->estado_id == 3) bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            @if($reserva->estado_id == 1)
                                                ⏳ Pendiente
                                            @elseif($reserva->estado_id == 2)
                                                ✓ Confirmada
                                            @elseif($reserva->estado_id == 3)
                                                ❌ Cancelada
                                            @else
                                                ✅ Completada
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($reserva->pago)
                                            <div class="text-sm text-gray-900">S/{{ number_format($reserva->pago->monto, 2) }}</div>
                                            <div class="text-sm text-gray-500">
                                                @if($reserva->pago->estado_id == 1) ✓ Pagado
                                                @elseif($reserva->pago->estado_id == 2) ⏳ Pendiente
                                                @else ❌ Fallido
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">Sin pago</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button onclick="viewReservaDetails({{ json_encode($reserva) }})" 
                                                    class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded text-xs font-semibold transition-colors">
                                                👁️ Ver Detalles
                                            </button>
                                            @if($reserva->pago)
                                                <a href="{{ route('admin.pagos.index') }}" 
                                                   class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded text-xs font-semibold transition-colors">
                                                    💳 Ver Pago
                                                </a>
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
                    <p class="mt-1 text-sm text-gray-500">No hay reservas registradas en el sistema.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Detalles de Reserva -->
<div id="reservaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between pb-3 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Detalles de la Reserva</h3>
                <button onclick="closeReservaModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Contenido del Modal -->
            <div class="mt-4" id="reserva-details">
                <!-- Contenido será llenado por JavaScript -->
            </div>
            
            <!-- Footer del Modal -->
            <div class="flex justify-end pt-4 border-t mt-4">
                <button onclick="closeReservaModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewReservaDetails(reserva) {
    const modal = document.getElementById('reservaModal');
    const content = document.getElementById('reserva-details');
    
    // Crear el contenido del modal
    content.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Información del Cliente</h4>
                <div class="space-y-2">
                    <div><strong>Nombre:</strong> ${reserva.usuario.nombre}</div>
                    <div><strong>Email:</strong> ${reserva.usuario.email}</div>
                    <div><strong>Teléfono:</strong> ${reserva.usuario.telefono || 'N/A'}</div>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Información de la Reserva</h4>
                <div class="space-y-2">
                    <div><strong>Instalación:</strong> ${reserva.instalacion.nombre}</div>
                    <div><strong>Centro:</strong> ${reserva.instalacion.centro_deportivo.nombre}</div>
                    <div><strong>Fecha:</strong> ${reserva.fecha_reserva}</div>
                    <div><strong>Horario:</strong> ${reserva.hora_inicio} - ${reserva.hora_fin}</div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-800 mb-3">Detalles Adicionales</h4>
            <div class="space-y-2">
                <div><strong>ID Reserva:</strong> ${reserva.id}</div>
                <div><strong>Fecha de Creación:</strong> ${new Date(reserva.created_at).toLocaleString('es-PE')}</div>
                <div><strong>Observaciones:</strong> ${reserva.observaciones || 'Sin observaciones'}</div>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
}

function closeReservaModal() {
    document.getElementById('reservaModal').classList.add('hidden');
}

// Cerrar modal con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReservaModal();
    }
});
</script>
@endsection
