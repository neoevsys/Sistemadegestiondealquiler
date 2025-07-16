@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Propietarios</h1>
                    <p class="mt-1 text-sm text-gray-600">Administra todos los propietarios del sistema</p>
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
                        <p class="text-sm font-medium text-gray-500">Total Propietarios</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $propietarios->total() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Propietarios Activos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $propietarios->where('estado_id', 1)->count() }}</p>
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
                        <p class="text-sm font-medium text-gray-500">Propietarios Pendientes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $propietarios->where('estado_id', 2)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de propietarios -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Lista de Propietarios</h2>
            </div>

            @if($propietarios->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Propietario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Centros</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($propietarios as $propietario)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-blue-700">{{ substr($propietario->usuario->nombre, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $propietario->usuario->nombre }}</div>
                                                <div class="text-sm text-gray-500">{{ $propietario->usuario->apellido }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $propietario->usuario->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $propietario->usuario->telefono }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $propietario->centrosDeportivos->count() }} centros
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $propietario->centrosDeportivos->where('estado_id', 1)->count() }} activos
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($propietario->estado_id == 1) bg-green-100 text-green-800
                                            @elseif($propietario->estado_id == 2) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            @if($propietario->estado_id == 1)
                                                ✓ Activo
                                            @elseif($propietario->estado_id == 2)
                                                ⏳ Pendiente
                                            @else
                                                ❌ Suspendido
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $propietario->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('admin.propietarios.toggle', $propietario) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="@if($propietario->estado_id == 1) text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 @else text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 @endif px-3 py-1 rounded text-xs font-semibold transition-colors"
                                                        onclick="return confirm('@if($propietario->estado_id == 1) ¿Suspender este propietario? @else ¿Activar este propietario? @endif')">
                                                    @if($propietario->estado_id == 1)
                                                        🚫 Suspender
                                                    @else
                                                        ✅ Activar
                                                    @endif
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.centros.index') }}?propietario={{ $propietario->id }}" 
                                               class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded text-xs font-semibold transition-colors">
                                                👁️ Ver Centros
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $propietarios->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sin propietarios</h3>
                    <p class="mt-1 text-sm text-gray-500">No hay propietarios registrados en el sistema.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
