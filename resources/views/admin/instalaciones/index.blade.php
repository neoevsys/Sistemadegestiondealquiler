@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Instalaciones</h1>
                    <p class="mt-1 text-sm text-gray-600">Administra todas las instalaciones del sistema</p>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Total Instalaciones</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $instalaciones->total() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Instalaciones Activas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $instalaciones->where('estado_id', 1)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Instalaciones Inactivas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $instalaciones->where('estado_id', 2)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de instalaciones -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Lista de Instalaciones</h2>
            </div>

            @if($instalaciones->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instalación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Centro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Propietario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($instalaciones as $instalacion)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-green-200 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-green-700">{{ substr($instalacion->nombre, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $instalacion->nombre }}</div>
                                                <div class="text-sm text-gray-500">{{ $instalacion->dimensiones }} - {{ $instalacion->superficie }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $instalacion->centroDeportivo->nombre }}</div>
                                        <div class="text-sm text-gray-500">{{ $instalacion->centroDeportivo->direccion }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $instalacion->centroDeportivo->propietario->usuario->nombre }}</div>
                                        <div class="text-sm text-gray-500">{{ $instalacion->centroDeportivo->propietario->usuario->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">S/{{ number_format($instalacion->precio_por_hora, 2) }}</div>
                                        <div class="text-sm text-gray-500">por hora</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($instalacion->estado_id == 1) bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            @if($instalacion->estado_id == 1)
                                                ✓ Activa
                                            @else
                                                ❌ Inactiva
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('admin.instalaciones.toggle', $instalacion) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="@if($instalacion->estado_id == 1) text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 @else text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 @endif px-3 py-1 rounded text-xs font-semibold transition-colors"
                                                        onclick="return confirm('@if($instalacion->estado_id == 1) ¿Desactivar esta instalación? @else ¿Activar esta instalación? @endif')">
                                                    @if($instalacion->estado_id == 1)
                                                        🚫 Desactivar
                                                    @else
                                                        ✅ Activar
                                                    @endif
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.reservas.index') }}?instalacion={{ $instalacion->id }}" 
                                               class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded text-xs font-semibold transition-colors">
                                                📅 Ver Reservas
                                            </a>
                                            <button onclick="viewInstalacionDetails({{ json_encode($instalacion) }})" 
                                                    class="text-purple-600 hover:text-purple-900 bg-purple-50 hover:bg-purple-100 px-3 py-1 rounded text-xs font-semibold transition-colors">
                                                👁️ Ver Detalles
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $instalaciones->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sin instalaciones</h3>
                    <p class="mt-1 text-sm text-gray-500">No hay instalaciones registradas en el sistema.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de Detalles de Instalación -->
<div id="instalacionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header del Modal -->
            <div class="flex items-center justify-between pb-3 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Detalles de la Instalación</h3>
                <button onclick="closeInstalacionModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Contenido del Modal -->
            <div class="mt-4" id="instalacion-details">
                <!-- Contenido será llenado por JavaScript -->
            </div>
            
            <!-- Footer del Modal -->
            <div class="flex justify-end pt-4 border-t mt-4">
                <button onclick="closeInstalacionModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewInstalacionDetails(instalacion) {
    const modal = document.getElementById('instalacionModal');
    const content = document.getElementById('instalacion-details');
    
    // Crear el contenido del modal
    content.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Información General</h4>
                <div class="space-y-2">
                    <div><strong>Nombre:</strong> ${instalacion.nombre}</div>
                    <div><strong>Descripción:</strong> ${instalacion.descripcion || 'Sin descripción'}</div>
                    <div><strong>Capacidad:</strong> ${instalacion.capacidad_maxima} personas</div>
                    <div><strong>Precio:</strong> S/${parseFloat(instalacion.precio_por_hora).toFixed(2)} por hora</div>
                </div>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Características Físicas</h4>
                <div class="space-y-2">
                    <div><strong>Dimensiones:</strong> ${instalacion.dimensiones}</div>
                    <div><strong>Superficie:</strong> ${instalacion.superficie}</div>
                    <div><strong>Equipamiento:</strong> ${instalacion.equipamiento_incluido || 'Sin equipamiento'}</div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-800 mb-3">Información del Centro</h4>
            <div class="space-y-2">
                <div><strong>Centro:</strong> ${instalacion.centro_deportivo.nombre}</div>
                <div><strong>Dirección:</strong> ${instalacion.centro_deportivo.direccion}</div>
                <div><strong>Propietario:</strong> ${instalacion.centro_deportivo.propietario.usuario.nombre}</div>
                <div><strong>Email:</strong> ${instalacion.centro_deportivo.propietario.usuario.email}</div>
            </div>
        </div>
        
        <div class="mt-4 bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-800 mb-3">Detalles Adicionales</h4>
            <div class="space-y-2">
                <div><strong>ID:</strong> ${instalacion.id}</div>
                <div><strong>Fecha de Creación:</strong> ${new Date(instalacion.created_at).toLocaleString('es-PE')}</div>
                <div><strong>Estado:</strong> ${instalacion.estado_id == 1 ? 'Activa' : 'Inactiva'}</div>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
}

function closeInstalacionModal() {
    document.getElementById('instalacionModal').classList.add('hidden');
}

// Cerrar modal con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeInstalacionModal();
    }
});
</script>
@endsection
