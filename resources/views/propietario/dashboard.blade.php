@extends('layouts.main')
@section('content')
    <section class="hero-gradient min-h-[35vh] flex items-center justify-center relative overflow-hidden py-8 md:py-12">
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none select-none">
            <svg class="absolute top-0 left-0 w-1/2 h-64 opacity-30" viewBox="0 0 400 400" fill="none"><circle cx="200" cy="200" r="200" fill="#a78bfa"/></svg>
            <svg class="absolute bottom-0 right-0 w-1/3 h-48 opacity-20" viewBox="0 0 300 300" fill="none"><circle cx="150" cy="150" r="150" fill="#facc15"/></svg>
        </div>
        <div class="relative w-full max-w-4xl px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center text-center gap-6">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 leading-tight drop-shadow-lg tracking-tight">
                <span class="block">Panel de <span class="text-yellow-300">Propietario</span></span>
                <span class="block text-2xl md:text-3xl font-semibold text-blue-100 mt-2">Gestión de Centros y Reservas</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-2 max-w-2xl mx-auto font-medium leading-relaxed drop-shadow">
                ¡Hola, {{ Auth::user()->nombre }}! Administra tus centros deportivos, instalaciones y reservas desde un solo lugar.
            </p>
        </div>
    </section>
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8 flex flex-col items-center">
                        <div class="p-4 rounded-full bg-blue-100 mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $centros->count() }}</h3>
                        <p class="text-blue-700 font-medium">Centros Deportivos</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl border border-green-100 p-8 flex flex-col items-center">
                        <div class="p-4 rounded-full bg-green-100 mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $centrosActivos }}</h3>
                        <p class="text-green-700 font-medium">Centros Activos</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl border border-purple-100 p-8 flex flex-col items-center">
                        <div class="p-4 rounded-full bg-purple-100 mb-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalInstalaciones }}</h3>
                        <p class="text-purple-700 font-medium">Instalaciones</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl border border-yellow-100 p-8 flex flex-col items-center">
                        <div class="p-4 rounded-full bg-yellow-100 mb-3">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalReservas }}</h3>
                        <p class="text-yellow-700 font-medium">Reservas Totales</p>
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">
                <div class="bg-white p-10 rounded-2xl shadow-xl card-hover border border-blue-100 flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">🏟️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Gestiona tus Centros</h3>
                    <p class="text-gray-600 mb-4 text-center">
                        Agrega, edita y administra la información y fotos de tus centros deportivos.
                    </p>
                    <a href="{{ route('propietario.centros.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 w-full text-center">Ver Mis Centros</a>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-xl card-hover border border-green-100 flex flex-col items-center">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">🏗️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Administra Instalaciones</h3>
                    <p class="text-gray-600 mb-4 text-center">
                        Controla las instalaciones, precios, horarios y disponibilidad de tus centros.
                    </p>
                    <a href="#" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 w-full text-center">Ver Instalaciones</a>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-xl card-hover border border-purple-100 flex flex-col items-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">📅</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Gestiona Reservas</h3>
                    <p class="text-gray-600 mb-4 text-center">
                        Monitorea y gestiona las reservas de tus instalaciones y horarios disponibles.
                    </p>
                    <a href="#" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 w-full text-center">Ver Reservas</a>
                </div>
            </div>
            @if(Auth::user()->propietario && $centros->count() > 0)
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8">
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
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8 text-center">
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
    </section>
    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
    </style>
@endsection
