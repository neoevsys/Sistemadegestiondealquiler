@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Mis Centros Deportivos</h1>
                        <p class="text-lg text-gray-600">Gestiona tus centros deportivos y su información</p>
                    </div>
                    <a href="{{ route('propietario.centros.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar Centro
                    </a>
                </div>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Centros Activos</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $centros->filter(function($centro) { return $centro->estadoCentro && $centro->estadoCentro->nombre === 'activo'; })->count() }}</h3>
                    </div>
                    <div class="p-4 rounded-full bg-green-100">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Centros Inactivos</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $centros->filter(function($centro) { return $centro->estadoCentro && $centro->estadoCentro->nombre === 'inactivo'; })->count() }}</h3>
                    </div>
                    <div class="p-4 rounded-full bg-red-100">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Centros</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $centros->total() }}</h3>
                    </div>
                    <div class="p-4 rounded-full bg-blue-100">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de centros -->
        @if($centros->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($centros as $centro)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
                        <!-- Imagen del centro -->
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                            @if($centro->fotos && count($centro->fotos) > 0)
                                @php
                                    $firstPhoto = $centro->fotos[0];
                                    $photoUrl = (filter_var($firstPhoto, FILTER_VALIDATE_URL)) 
                                        ? $firstPhoto 
                                        : Storage::url($firstPhoto);
                                @endphp
                                <img src="{{ $photoUrl }}" 
                                     alt="{{ $centro->nombre }}" 
                                     class="w-full h-48 object-cover"
                                     onerror="this.parentElement.innerHTML='<div class=\'w-full h-48 bg-gray-300 flex items-center justify-center\'><svg class=\'w-12 h-12 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2\'></path></svg></div>'">
                            @else
                                <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Contenido de la tarjeta -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-900 truncate flex-1 mr-2">{{ $centro->nombre }}</h3>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($centro->estadoCentro && $centro->estadoCentro->nombre === 'activo') bg-green-100 text-green-800
                                    @elseif($centro->estadoCentro && $centro->estadoCentro->nombre === 'inactivo') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $centro->estadoCentro ? ucfirst($centro->estadoCentro->nombre) : 'N/A' }}
                                </span>
                            </div>
                            
                            <div class="flex items-start mb-3">
                                <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="text-gray-600 text-sm">
                                    {{ $centro->direccion }}, {{ $centro->distrito ? $centro->distrito->nombre : 'N/A' }}
                                </p>
                            </div>
                            
                            @if($centro->descripcion)
                                <p class="text-gray-600 text-sm mb-6 line-clamp-2">{{ Str::limit($centro->descripcion, 100) }}</p>
                            @else
                                <div class="mb-6"></div>
                            @endif

                            <!-- Botones de acción -->
                            <div class="grid grid-cols-3 gap-2 pt-4 border-t border-gray-100">
                                <a href="{{ route('propietario.centros.show', $centro) }}" 
                                   class="col-span-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2.5 rounded-lg text-sm font-medium text-center transition-all duration-200 flex items-center justify-center hover:shadow-md">
                                    <span class="hidden sm:inline">Ver</span>
                                    <svg class="w-4 h-4 sm:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                
                                <a href="{{ route('propietario.centros.edit', $centro) }}" 
                                   class="col-span-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center hover:shadow-md"
                                   title="Editar">
                                    <span class="hidden sm:inline">Editar</span>
                                    <svg class="w-4 h-4 sm:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('propietario.centros.toggle-status', $centro) }}" method="POST" class="col-span-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full h-full px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center hover:shadow-md
                                                @if($centro->estadoCentro && $centro->estadoCentro->nombre === 'activo') bg-red-600 hover:bg-red-700 text-white
                                                @else bg-green-600 hover:bg-green-700 text-white @endif"
                                            title="@if($centro->estadoCentro && $centro->estadoCentro->nombre === 'activo') Desactivar @else Activar @endif">
                                        @if($centro->estadoCentro && $centro->estadoCentro->nombre === 'activo')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $centros->links() }}
            </div>
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes centros deportivos</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza agregando tu primer centro deportivo.</p>
                <div class="mt-6">
                    <a href="{{ route('propietario.centros.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar Centro
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
