@extends('layouts.main')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $centro->nombre }}</h1>
                    <p class="mt-2 text-gray-600">{{ $centro->direccion }}, {{ $centro->distrito ? $centro->distrito->nombre : 'N/A' }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('propietario.centros.edit', $centro) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('propietario.centros.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
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

        <!-- Estado del Centro -->
        <div class="mb-6">
            <div class="flex items-center justify-between bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-700 mr-3">Estado del Centro:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if($centro->estadoCentro && $centro->estadoCentro->nombre === 'activo') bg-green-100 text-green-800
                        @elseif($centro->estadoCentro && $centro->estadoCentro->nombre === 'inactivo') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $centro->estadoCentro ? ucfirst($centro->estadoCentro->nombre) : 'N/A' }}
                    </span>
                </div>
                <form action="{{ route('propietario.centros.toggle-status', $centro) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200
                                @if($centro->estadoCentro && $centro->estadoCentro->nombre === 'activo') bg-red-600 hover:bg-red-700 text-white
                                @else bg-green-600 hover:bg-green-700 text-white @endif">
                        @if($centro->estadoCentro && $centro->estadoCentro->nombre === 'activo')
                            Desactivar Centro
                        @else
                            Activar Centro
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- Galería de Fotos -->
        @if($centro->fotos && count($centro->fotos) > 0)
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Galería de Fotos</h2>
                    
                    <!-- Foto principal -->
                    <div class="mb-4">
                        @php
                            $firstPhoto = $centro->fotos[0];
                            $mainPhotoUrl = (filter_var($firstPhoto, FILTER_VALIDATE_URL)) 
                                ? $firstPhoto 
                                : Storage::url($firstPhoto);
                        @endphp
                        <img id="main-photo" 
                             src="{{ $mainPhotoUrl }}" 
                             alt="{{ $centro->nombre }}" 
                             class="w-full h-96 object-cover rounded-lg"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\' viewBox=\'0 0 400 300\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23e5e7eb\'/%3E%3Cg fill=\'%239ca3af\'%3E%3Cpath d=\'M200 120h-40v80h80v-80h-40zm20 60h-40v-40h40v40z\'/%3E%3Cpath d=\'M160 100h80l20 20v80l-20 20h-80l-20-20v-80l20-20zm80 20l-10-10h-60l-10 10v60l10 10h60l10-10v-60z\'/%3E%3C/g%3E%3C/svg%3E'">
                    </div>
                    
                    <!-- Miniaturas -->
                    @if(count($centro->fotos) > 1)
                        <div class="grid grid-cols-4 md:grid-cols-8 gap-2">
                            @foreach($centro->fotos as $index => $foto)
                                @php
                                    $photoUrl = (filter_var($foto, FILTER_VALIDATE_URL)) 
                                        ? $foto 
                                        : Storage::url($foto);
                                @endphp
                                <img src="{{ $photoUrl }}" 
                                     alt="Foto {{ $index + 1 }}" 
                                     class="w-full h-16 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity duration-200 photo-thumbnail {{ $index === 0 ? 'ring-2 ring-blue-500' : '' }}"
                                     onclick="changeMainPhoto('{{ $photoUrl }}', this)"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%23e5e7eb\'/%3E%3Cg fill=\'%239ca3af\'%3E%3Cpath d=\'M50 30h-20v40h40v-40h-20zm10 30h-20v-20h20v20z\'/%3E%3C/g%3E%3C/svg%3E'">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Información del Centro -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información Básica -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información Básica</h2>
                    
                    @if($centro->descripcion)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Descripción</h3>
                            <p class="text-gray-600">{{ $centro->descripcion }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Calificación</h3>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $centro->calificacion_promedio ? 'text-yellow-400' : 'text-gray-300' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">{{ $centro->evaluaciones_avg_calificacion ? number_format($centro->evaluaciones_avg_calificacion, 1) : '0.0' }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Fecha de Registro</h3>
                            <p class="text-gray-600">{{ $centro->fecha_registro->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Servicios Adicionales -->
                @if($centro->servicios_adicionales)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Servicios Adicionales</h2>
                        <p class="text-gray-600 whitespace-pre-line">{{ $centro->servicios_adicionales }}</p>
                    </div>
                @endif

                <!-- Políticas del Centro -->
                @if($centro->politicas)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Políticas del Centro</h2>
                        <p class="text-gray-600 whitespace-pre-line">{{ $centro->politicas }}</p>
                    </div>
                @endif
            </div>

            <!-- Panel Lateral -->
            <div class="space-y-6">
                <!-- Información de Ubicación -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubicación</h2>
                    
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="text-gray-900 font-medium">{{ $centro->direccion }}</p>
                                <p class="text-gray-600 text-sm">{{ $centro->distrito ? $centro->distrito->nombre : 'N/A' }}</p>
                                @if($centro->codigo_postal)
                                    <p class="text-gray-600 text-sm">CP: {{ $centro->codigo_postal }}</p>
                                @endif
                            </div>
                        </div>

                        @if($centro->latitud && $centro->longitud)
                            <div class="pt-2">
                                <p class="text-xs text-gray-500">
                                    Coordenadas: {{ $centro->latitud }}, {{ $centro->longitud }}
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Mapa -->
                    @if($centro->latitud && $centro->longitud)
                        <div class="mt-4">
                            <div id="map" style="height: 250px; width: 100%; border-radius: 0.5rem; overflow: hidden;" class="shadow-sm"></div>
                        </div>
                    @endif
                </div>

                <!-- Información de Contacto -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Contacto</h2>
                    
                    <div class="space-y-3">
                        @if($centro->telefono)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-gray-900">{{ $centro->telefono }}</span>
                            </div>
                        @endif

                        @if($centro->email)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-900">{{ $centro->email }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Estadísticas Rápidas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Estadísticas</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Instalaciones</span>
                            <span class="font-semibold text-gray-900">{{ $centro->instalaciones->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Reservas Totales</span>
                            <span class="font-semibold text-gray-900">
                                {{ $centro->instalaciones->sum(function($instalacion) { return $instalacion->reservas->count(); }) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Evaluaciones</span>
                            <span class="font-semibold text-gray-900">{{ $centro->evaluaciones->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Acciones</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('propietario.centros.instalaciones.index', $centro) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                            </svg>
                            Gestionar Instalaciones
                        </a>
                        
                        <a href="{{ route('propietario.centros.reservas', $centro) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Ver Reservas
                        </a>
                        
                        <a href="{{ route('propietario.centros.evaluaciones', $centro) }}" 
                           class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Ver Evaluaciones
                        </a>
                        
                        <form action="{{ route('propietario.centros.destroy', $centro) }}" method="POST" 
                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar este centro deportivo? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                Eliminar Centro
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
function changeMainPhoto(src, thumbnail) {
    // Cambiar la foto principal
    document.getElementById('main-photo').src = src;
    
    // Remover el anillo de selección de todas las miniaturas
    document.querySelectorAll('.photo-thumbnail').forEach(img => {
        img.classList.remove('ring-2', 'ring-blue-500');
    });
    
    // Agregar el anillo de selección a la miniatura clickeada
    thumbnail.classList.add('ring-2', 'ring-blue-500');
}

// Inicializar mapa si existen coordenadas
@if($centro->latitud && $centro->longitud)
document.addEventListener('DOMContentLoaded', function() {
    // Coordenadas del centro
    var lat = {{ $centro->latitud }};
    var lng = {{ $centro->longitud }};
    
    // Inicializar el mapa
    var map = L.map('map', {
        center: [lat, lng],
        zoom: 16,
        scrollWheelZoom: false, // Deshabilitar zoom con scroll
        dragging: false, // Deshabilitar arrastre
        touchZoom: false, // Deshabilitar zoom táctil
        doubleClickZoom: false, // Deshabilitar zoom con doble click
        boxZoom: false, // Deshabilitar zoom con caja
        keyboard: false, // Deshabilitar controles de teclado
        zoomControl: true // Mantener controles de zoom
    });
    
    // Agregar capa de tiles de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Crear icono personalizado
    var customIcon = L.icon({
        iconUrl: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDMyIDQwIiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTE2IDBDOS4zNzI1OCAwIDQgNS4zNzI1OCA0IDEyQzQgMTkuNSAxNiA0MCAxNiA0MFMyOCAxOS41IDI4IDEyQzI4IDUuMzcyNTggMjIuNjI3NCAwIDE2IDBaIiBmaWxsPSIjMjU2M0VCIi8+CjxjaXJjbGUgY3g9IjE2IiBjeT0iMTIiIHI9IjYiIGZpbGw9IndoaXRlIi8+Cjwvc3ZnPg==',
        iconSize: [32, 40],
        iconAnchor: [16, 40],
        popupAnchor: [0, -40]
    });
    
    // Agregar marcador con icono personalizado
    var marker = L.marker([lat, lng], {
        icon: customIcon,
        draggable: false // Asegurar que no se pueda arrastrar
    }).addTo(map);
    
    // Agregar popup con el nombre del centro
    marker.bindPopup('<strong>{{ $centro->nombre }}</strong><br>{{ $centro->direccion }}').openPopup();
    
    // Forzar el redimensionamiento del mapa después de un pequeño retraso
    setTimeout(function() {
        map.invalidateSize();
    }, 100);
});
@endif
</script>
@endsection
