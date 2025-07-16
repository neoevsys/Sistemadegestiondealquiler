@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Reservas de {{ $centro->nombre }}</h1>
                    <p class="mt-2 text-gray-600">Gestiona todas las reservas de tu centro deportivo</p>
                </div>
                <a href="{{ route('propietario.centros.show', $centro) }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Centro
                </a>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Reservas</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $estadisticas['total'] }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pendientes</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-2">{{ $estadisticas['pendientes'] }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Confirmadas</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $estadisticas['confirmadas'] }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Canceladas</p>
                        <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $estadisticas['canceladas'] }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-red-100">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Completadas</p>
                        <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $estadisticas['completadas'] }}</h3>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Reservas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900">Lista de Reservas</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Instalación
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Horario
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reservas as $reserva)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reserva->usuario->nombre ?? 'Usuario' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $reserva->usuario->email ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reserva->instalacion->nombre }}</div>
                                    <div class="text-sm text-gray-500">{{ $reserva->instalacion->tiposDeporte->pluck('nombre')->join(', ') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $reserva->duracion_horas }} hora(s)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reserva->estadoReserva)
                                        @php
                                            $estadoClasses = [
                                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'confirmada' => 'bg-green-100 text-green-800',
                                                'cancelada' => 'bg-red-100 text-red-800',
                                                'completada' => 'bg-blue-100 text-blue-800',
                                            ];
                                            $estadoClass = $estadoClasses[$reserva->estadoReserva->nombre] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estadoClass }}">
                                            {{ ucfirst($reserva->estadoReserva->nombre) }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Desconocido
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    S/. {{ number_format($reserva->precio_total, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900"
                                                onclick="mostrarDetallesReserva({{ json_encode($reserva) }})">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        
                                        @if($reserva->estado_id == 1) {{-- Pendiente --}}
                                            <form method="POST" action="{{ route('propietario.centros.reservas.confirmar', [$centro, $reserva]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Confirmar"
                                                        onclick="return confirm('¿Estás seguro de confirmar esta reserva?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('propietario.centros.reservas.cancelar', [$centro, $reserva]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Cancelar"
                                                        onclick="return confirm('¿Estás seguro de cancelar esta reserva?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @elseif($reserva->estado_id == 2) {{-- Confirmada --}}
                                            <form method="POST" action="{{ route('propietario.centros.reservas.cancelar', [$centro, $reserva]) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Cancelar"
                                                        onclick="return confirm('¿Estás seguro de cancelar esta reserva confirmada?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay reservas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Este centro aún no tiene reservas registradas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($reservas->hasPages())
            <div class="mt-8">
                {{ $reservas->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de detalles de reserva -->
<div id="modalDetallesReserva" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-lg font-medium text-gray-900">Detalles de la Reserva</h3>
            <button onclick="cerrarModalDetalles()" class="text-gray-400 hover:text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="detallesReservaContent" class="space-y-3">
            <!-- El contenido se llenará dinámicamente -->
        </div>
    </div>
</div>

<script>
function mostrarDetallesReserva(reserva) {
    const modal = document.getElementById('modalDetallesReserva');
    const content = document.getElementById('detallesReservaContent');
    
    content.innerHTML = `
        <div>
            <p class="text-sm text-gray-500">Cliente</p>
            <p class="font-medium">${reserva.usuario?.nombre || 'Usuario'}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="font-medium">${reserva.usuario?.email || 'No disponible'}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Instalación</p>
            <p class="font-medium">${reserva.instalacion.nombre}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Fecha y Hora</p>
            <p class="font-medium">${new Date(reserva.fecha_reserva).toLocaleDateString('es-PE')} ${reserva.hora_inicio} - ${reserva.hora_fin}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Duración</p>
            <p class="font-medium">${reserva.duracion_horas} hora(s)</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total</p>
            <p class="font-medium text-lg">S/. ${parseFloat(reserva.precio_total).toFixed(2)}</p>
        </div>
        ${reserva.observaciones ? `
        <div>
            <p class="text-sm text-gray-500">Observaciones</p>
            <p class="font-medium">${reserva.observaciones}</p>
        </div>
        ` : ''}
    `;
    
    modal.classList.remove('hidden');
}

function cerrarModalDetalles() {
    document.getElementById('modalDetallesReserva').classList.add('hidden');
}
</script>
@endsection
