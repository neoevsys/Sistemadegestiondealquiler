@extends('layouts.main')
@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Encuentra tu Centro Deportivo</h1>
        <!-- Filtros -->
        <form method="GET" action="{{ route('centros.index') }}" class="mb-8 bg-white rounded-lg shadow p-4 flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-1">
                <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                <select name="ciudad" id="ciudad" class="w-full border-gray-300 rounded">
                    <option value="">Todas</option>
                    @foreach($ciudades as $ciudad)
                        <option value="{{ $ciudad }}" @if(request('ciudad') == $ciudad) selected @endif>{{ $ciudad }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label for="deporte" class="block text-sm font-medium text-gray-700 mb-1">Deporte</label>
                <select name="deporte" id="deporte" class="w-full border-gray-300 rounded">
                    <option value="">Todos</option>
                    @foreach($tiposDeportes as $deporte)
                        <option value="{{ $deporte->nombre }}" @if(request('deporte') == $deporte->nombre) selected @endif>{{ $deporte->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="w-full border-gray-300 rounded" min="{{ date('Y-m-d') }}" value="{{ request('fecha') }}">
            </div>
            <div class="flex-1">
                <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Rango de Precio</label>
                <select name="precio" id="precio" class="w-full border-gray-300 rounded">
                    <option value="">Todos</option>
                    <option value="1" @if(request('precio')=='1') selected @endif>Menos de 20€/hora</option>
                    <option value="2" @if(request('precio')=='2') selected @endif>20€ - 40€/hora</option>
                    <option value="3" @if(request('precio')=='3') selected @endif>Más de 40€/hora</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="valoracion" class="block text-sm font-medium text-gray-700 mb-1">Valoración</label>
                <select name="valoracion" id="valoracion" class="w-full border-gray-300 rounded">
                    <option value="">Todas</option>
                    <option value="4.5" @if(request('valoracion')=='4.5') selected @endif>4.5+ estrellas</option>
                    <option value="4.0" @if(request('valoracion')=='4.0') selected @endif>4.0+ estrellas</option>
                    <option value="3.5" @if(request('valoracion')=='3.5') selected @endif>3.5+ estrellas</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">Filtrar</button>
            </div>
        </form>
        <!-- Grid de centros deportivos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($centros as $centro)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover flex flex-col transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl">
                    <div class="relative">
                        @if($centro->fotos && is_array($centro->fotos) && count($centro->fotos) > 0)
                            <img src="{{ asset('storage/' . $centro->fotos[0]) }}" alt="Foto Centro" class="h-48 w-full object-cover">
                        @else
                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400">Sin imagen</div>
                        @endif
                        @if($centro->calificacion_promedio)
                            <div class="absolute top-4 right-4 bg-yellow-400 text-white px-3 py-1 rounded-full text-xs font-bold shadow">
                                ⭐ {{ number_format($centro->calificacion_promedio, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h2 class="text-lg font-bold mb-1 text-blue-700 truncate">{{ $centro->nombre }}</h2>
                        <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $centro->descripcion }}</p>
                        <div class="flex flex-wrap gap-2 mb-2">
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs">{{ $centro->ciudad }}</span>
                            @php
                                $deportes = $centro->instalaciones->pluck('tipoDeporte.nombre')->unique()->take(3);
                            @endphp
                            @foreach($deportes as $dep)
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">{{ $dep }}</span>
                            @endforeach
                            @if($centro->instalaciones->count() > 3)
                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs">+{{ $centro->instalaciones->count() - 3 }} más</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2 mb-2">
                            @if($centro->servicios_adicionales)
                                @foreach(explode(',', $centro->servicios_adicionales) as $servicio)
                                    <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded text-xs">{{ trim($servicio) }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="flex items-center justify-between mt-auto pt-3">
                            @php
                                $precios = $centro->instalaciones->pluck('precio_por_hora')->filter();
                                $precioMin = $precios->min();
                            @endphp
                            <span class="text-lg font-bold text-gray-900">{{ $precioMin ? number_format($precioMin, 2) . '€' : 'S/N' }}<span class="text-xs text-gray-500">/hora</span></span>
                            <a href="{{ route('centros.show', $centro->id_centro) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded transition-colors">Ver detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">No hay centros deportivos que coincidan con los filtros.</div>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $centros->links() }}
        </div>
    </div>
@endsection
