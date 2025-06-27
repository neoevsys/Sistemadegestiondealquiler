@extends('layouts.main')
@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Dashboard del Propietario</h1>
                <p class="mt-2 text-gray-600">¡Hola, {{ Auth::user()->nombre }}! Gestiona tu negocio deportivo desde aquí</p>
            </div>

            <!-- Estadísticas Rápidas -->
            @if(Auth::user()->propietario)
                @php
                    $centros = Auth::user()->propietario->centrosDeportivos ?? collect();
                    $centrosActivos = $centros->where('estado', 'activo')->count();
                    $totalInstalaciones = $centros->sum(function($centro) { return $centro->instalaciones->count(); });
                    $totalReservas = $centros->sum(function($centro) { 
                        return $centro->instalaciones->sum(function($instalacion) { 
                            return $instalacion->reservas->count(); 
                        }); 
                    });
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-semibold text-gray-900">{{ $centros->count() }}</h3>
                                <p class="text-gray-600">Centros Deportivos</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-semibold text-gray-900">{{ $centrosActivos }}</h3>
                                <p class="text-gray-600">Centros Activos</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-semibold text-gray-900">{{ $totalInstalaciones }}</h3>
                                <p class="text-gray-600">Instalaciones</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-semibold text-gray-900">{{ $totalReservas }}</h3>
                                <p class="text-gray-600">Reservas Totales</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acciones Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Gestión de Centros Deportivos -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 ml-3">Centros Deportivos</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Gestiona tus centros deportivos, agrega información, fotos y mantén actualizada su información.</p>
                    <div class="space-y-2">
                        <a href="{{ route('propietario.centros.index') }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Ver Mis Centros
                        </a>
                        <a href="{{ route('propietario.centros.create') }}" 
                           class="w-full bg-blue-100 hover:bg-blue-200 text-blue-800 px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Agregar Nuevo Centro
                        </a>
                    </div>
                </div>

                <!-- Gestión de Instalaciones -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-green-100">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 ml-3">Instalaciones</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Administra las instalaciones de tus centros, precios, horarios y disponibilidad.</p>
                    <div class="space-y-2">
                        <a href="#" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Ver Instalaciones
                        </a>
                        <a href="#" class="w-full bg-green-100 hover:bg-green-200 text-green-800 px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Agregar Instalación
                        </a>
                    </div>
                </div>

                <!-- Reservas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-purple-100">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 ml-3">Reservas</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Monitorea las reservas de tus instalaciones y gestiona los horarios disponibles.</p>
                    <div class="space-y-2">
                        <a href="#" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Ver Reservas
                        </a>
                        <a href="#" class="w-full bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Gestionar Horarios
                        </a>
                    </div>
                </div>
            </div>

            @if(Auth::user()->propietario && $centros->count() > 0)
                <!-- Centros Recientes -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Centros Deportivos Recientes</h2>
                        <a href="{{ route('propietario.centros.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            Ver todos
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($centros->take(3) as $centro)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-medium text-gray-900">{{ $centro->nombre }}</h3>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                                        @if($centro->estado === 'activo') bg-green-100 text-green-800
                                        @elseif($centro->estado === 'inactivo') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($centro->estado) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($centro->direccion, 50) }}</p>
                                <div class="flex space-x-2">
                                    <a href="{{ route('propietario.centros.show', $centro) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Ver detalles
                                    </a>
                                    <a href="{{ route('propietario.centros.edit', $centro) }}" 
                                       class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                                        Editar
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Estado sin centros -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">¡Comienza tu negocio deportivo!</h3>
                    <p class="text-gray-600 mb-6">Aún no tienes centros deportivos registrados. Agrega tu primer centro para comenzar a recibir reservas.</p>
                    <a href="{{ route('propietario.centros.create') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar Primer Centro
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
