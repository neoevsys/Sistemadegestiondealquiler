@extends('layouts.main')
@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-blue-700 mb-2">{{ $centro->nombre }}</h1>
        <p class="text-gray-600 mb-4">{{ $centro->descripcion }}</p>
        <div class="flex flex-col md:flex-row gap-6 mb-6">
            @if($centro->fotos && is_array($centro->fotos) && count($centro->fotos) > 0)
                @php
                    $foto = $centro->fotos[0];
                    $isUrl = Str::startsWith($foto, ['http://', 'https://']);
                @endphp
                <img src="{{ $isUrl ? $foto : asset('storage/' . $foto) }}" alt="Foto Centro" class="w-full md:w-80 h-56 object-cover rounded">
            @endif
            <div class="flex-1">
                <div class="mb-2"><span class="font-semibold">Dirección:</span> {{ $centro->direccion }}</div>
                <div class="mb-2"><span class="font-semibold">Departamento:</span> {{ $centro->departamento->nombre ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Provincia:</span> {{ $centro->provincia->nombre ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Distrito:</span> {{ $centro->distrito->nombre ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Teléfono:</span> {{ $centro->telefono }}</div>
                <div class="mb-2"><span class="font-semibold">Email:</span> {{ $centro->email }}</div>
                <div class="mb-2"><span class="font-semibold">Calificación:</span> {{ $centro->calificacion_promedio ?? 'N/A' }}</div>
            </div>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mt-8 mb-4">Instalaciones</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($centro->instalaciones as $instalacion)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    @if($instalacion->foto_principal)
                        @php
                            $isUrl = Str::startsWith($instalacion->foto_principal, ['http://', 'https://']);
                        @endphp
                        <img src="{{ $isUrl ? $instalacion->foto_principal : asset('storage/' . $instalacion->foto_principal) }}" 
                             alt="Foto de {{ $instalacion->nombre }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-blue-600 mb-2">{{ $instalacion->nombre }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ $instalacion->descripcion }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Capacidad: {{ $instalacion->capacidad_maxima }} personas</span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $instalacion->dimensiones }} - {{ $instalacion->superficie }}</span>
                            </div>
                            
                            @if($instalacion->equipamiento_incluido)
                                <div class="flex items-center text-sm text-gray-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>{{ $instalacion->equipamiento_incluido }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($instalacion->tiposDeporte as $deporte)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ $deporte->nombre }}</span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-lg font-bold text-gray-900">
                                S/{{ number_format($instalacion->precio_por_hora, 2) }}
                                <span class="text-sm text-gray-500 font-normal">/hora</span>
                            </div>
                            @auth
                                @if(auth()->user()->tipo_usuario_id == 2) <!-- Solo clientes pueden reservar -->
                                    <a href="{{ route('reservas.create', ['instalacion_id' => $instalacion->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold transition-colors inline-block text-center">
                                        Reservar
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold transition-colors inline-block text-center">
                                    Reservar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-8">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <p>No hay instalaciones registradas.</p>
                </div>
            @endforelse
        </div>
        <a href="{{ route('centros.index') }}" class="inline-block mt-8 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Volver al listado</a>
    </div>
</div>
@endsection
