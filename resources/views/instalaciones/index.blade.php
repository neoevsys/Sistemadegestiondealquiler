@extends('layouts.main')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Encuentra tu Instalación Deportiva</h1>
    
    <!-- Filtros -->
    <form method="GET" action="{{ route('instalaciones.index') }}" class="mb-8 bg-white rounded-lg shadow p-4 flex flex-col md:flex-row md:items-end gap-4">
        <div class="flex-1">
            <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
            <select name="departamento_id" id="departamento_id" class="w-full border-gray-300 rounded">
                <option value="">Todos</option>
                @foreach($departamentos as $departamento)
                    <option value="{{ $departamento->id }}" @if(request('departamento_id') == $departamento->id) selected @endif>{{ $departamento->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex-1">
            <label for="provincia_id" class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
            <select name="provincia_id" id="provincia_id" class="w-full border-gray-300 rounded">
                <option value="">Todas</option>
                @foreach($provincias as $provincia)
                    <option value="{{ $provincia->id }}" data-departamento="{{ $provincia->departamento_id }}" @if(request('provincia_id') == $provincia->id) selected @endif>{{ $provincia->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex-1">
            <label for="distrito_id" class="block text-sm font-medium text-gray-700 mb-1">Distrito</label>
            <select name="distrito_id" id="distrito_id" class="w-full border-gray-300 rounded">
                <option value="">Todos</option>
                @foreach($distritos as $distrito)
                    <option value="{{ $distrito->id }}" data-provincia="{{ $distrito->provincia_id }}" @if(request('distrito_id') == $distrito->id) selected @endif>{{ $distrito->nombre }}</option>
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
            <label for="superficie" class="block text-sm font-medium text-gray-700 mb-1">Superficie</label>
            <select name="superficie" id="superficie" class="w-full border-gray-300 rounded">
                <option value="">Todas</option>
                @foreach($superficies as $superficie)
                    <option value="{{ $superficie }}" @if(request('superficie') == $superficie) selected @endif>{{ $superficie }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex-1">
            <label for="capacidad" class="block text-sm font-medium text-gray-700 mb-1">Capacidad</label>
            <select name="capacidad" id="capacidad" class="w-full border-gray-300 rounded">
                <option value="">Todas</option>
                <option value="1" @if(request('capacidad')=='1') selected @endif>Hasta 10 personas</option>
                <option value="2" @if(request('capacidad')=='2') selected @endif>11-20 personas</option>
                <option value="3" @if(request('capacidad')=='3') selected @endif>Más de 20 personas</option>
            </select>
        </div>
        
        <div class="flex-1">
            <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio por hora</label>
            <select name="precio" id="precio" class="w-full border-gray-300 rounded">
                <option value="">Todos</option>
                <option value="1" @if(request('precio')=='1') selected @endif>Menos de S/20</option>
                <option value="2" @if(request('precio')=='2') selected @endif>S/20 - S/40</option>
                <option value="3" @if(request('precio')=='3') selected @endif>Más de S/40</option>
            </select>
        </div>
        
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">Filtrar</button>
        </div>
    </form>
    
    <!-- Grid de instalaciones -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($instalaciones as $instalacion)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover flex flex-col transition-transform duration-300 hover:-translate-y-2 hover:shadow-2xl">
                <div class="relative">
                    @if($instalacion->foto_principal)
                        @php
                            $isUrl = Str::startsWith($instalacion->foto_principal, ['http://', 'https://']);
                        @endphp
                        <img src="{{ $isUrl ? $instalacion->foto_principal : asset('storage/' . $instalacion->foto_principal) }}" 
                             alt="Foto de {{ $instalacion->nombre }}" 
                             class="h-48 w-full object-cover">
                    @else
                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold mb-2 text-blue-600">{{ $instalacion->nombre }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ $instalacion->descripcion }}</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span><strong>Centro:</strong> {{ $instalacion->centroDeportivo->nombre }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $instalacion->centroDeportivo->distrito->nombre ?? 'Sin ubicación' }}</span>
                        </div>
                        
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
                    
                    <div class="flex items-center justify-between mt-auto">
                        <div class="text-lg font-bold text-gray-900">
                            S/{{ number_format($instalacion->precio_por_hora, 2) }}
                            <span class="text-sm text-gray-500 font-normal">/hora</span>
                        </div>
                        @auth
                            @if(auth()->user()->tipo_usuario_id == 2) <!-- Solo clientes pueden reservar -->
                                <a href="{{ route('reservas.create', ['instalacion_id' => $instalacion->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold transition-colors">
                                    Reservar
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold transition-colors">
                                Reservar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16">
                <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay instalaciones disponibles</h3>
                <p class="text-gray-500">Ajusta los filtros para encontrar instalaciones que coincidan con tus criterios.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $instalaciones->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departamentoSelect = document.getElementById('departamento_id');
    const provinciaSelect = document.getElementById('provincia_id');
    const distritoSelect = document.getElementById('distrito_id');
    
    provinciaSelect.addEventListener('change', function() {
        const selectedProvincia = this.value;
        Array.from(distritoSelect.options).forEach(opt => {
            opt.style.display = !opt.value || opt.getAttribute('data-provincia') === selectedProvincia ? '' : 'none';
        });
        distritoSelect.value = '';
    });
    
    departamentoSelect.addEventListener('change', function() {
        const selectedDepartamento = this.value;
        Array.from(provinciaSelect.options).forEach(opt => {
            opt.style.display = !opt.value || opt.getAttribute('data-departamento') === selectedDepartamento ? '' : 'none';
        });
        provinciaSelect.value = '';
        Array.from(distritoSelect.options).forEach(opt => { 
            opt.style.display = !opt.value ? '' : 'none'; 
        });
        distritoSelect.value = '';
    });
});
</script>
@endsection
