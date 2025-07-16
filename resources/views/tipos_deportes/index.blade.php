@extends('layouts.main')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Deportes Disponibles</h1>
        <p class="text-gray-600 mb-8">Encuentra instalaciones deportivas para tu deporte favorito</p>
        
        @if($deportes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($deportes as $deporte)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-gray-900">{{ $deporte->nombre }}</h2>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">
                                    {{ $deporte->instalaciones_count }} {{ $deporte->instalaciones_count == 1 ? 'instalación' : 'instalaciones' }}
                                </span>
                            </div>
                            
                            @if($deporte->descripcion)
                                <p class="text-gray-600 text-sm mb-4">{{ $deporte->descripcion }}</p>
                            @endif
                            
                            <!-- Información de precios -->
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700">Rango de precios:</span>
                                </div>
                                <div class="text-lg font-bold text-gray-900">
                                    @if($deporte->precio_min == $deporte->precio_max)
                                        S/{{ number_format($deporte->precio_min, 2) }}/hora
                                    @else
                                        S/{{ number_format($deporte->precio_min, 2) }} - S/{{ number_format($deporte->precio_max, 2) }}/hora
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">
                                    Promedio: S/{{ number_format($deporte->precio_promedio, 2) }}/hora
                                </div>
                            </div>
                            
                            <!-- Ubicaciones disponibles -->
                            @if($deporte->ubicaciones->count() > 0)
                                <div class="mb-4">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-700">Disponible en:</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($deporte->ubicaciones->take(3) as $ubicacion)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">{{ $ubicacion }}</span>
                                        @endforeach
                                        @if($deporte->ubicaciones->count() > 3)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                                +{{ $deporte->ubicaciones->count() - 3 }} más
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Botón para ver instalaciones -->
                            <div class="mt-6">
                                <a href="{{ route('instalaciones.index', ['deporte' => $deporte->nombre]) }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 inline-block text-center">
                                    Ver Instalaciones
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="max-w-sm mx-auto">
                    <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay deportes disponibles</h3>
                    <p class="text-gray-600">Actualmente no hay deportes con instalaciones disponibles.</p>
                </div>
            </div>
        @endif
        
        <!-- Información adicional -->
        <div class="mt-12 bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">¿No encuentras tu deporte?</h3>
            <p class="text-blue-800 mb-4">
                Estamos constantemente agregando nuevos deportes y centros deportivos a nuestra plataforma. 
                Si tienes un centro deportivo y quieres unirte, ¡contáctanos!
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('centros.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-center">
                    Ver Todos los Centros
                </a>
                <a href="{{ route('instalaciones.index') }}" 
                   class="bg-white border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-center">
                    Ver Todas las Instalaciones
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
