@extends('layouts.main')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $centro->nombre }}</h1>
                    <p class="mt-2 text-gray-600">{{ $centro->direccion }}, {{ $centro->ciudad }}</p>
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
                        @if($centro->estado === 'activo') bg-green-100 text-green-800
                        @elseif($centro->estado === 'inactivo') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($centro->estado) }}
                    </span>
                </div>
                <form action="{{ route('propietario.centros.toggle-status', $centro) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200
                                @if($centro->estado === 'activo') bg-red-600 hover:bg-red-700 text-white
                                @else bg-green-600 hover:bg-green-700 text-white @endif">
                        @if($centro->estado === 'activo')
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
                        <img id="main-photo" 
                             src="{{ Storage::url($centro->fotos[0]) }}" 
                             alt="{{ $centro->nombre }}" 
                             class="w-full h-96 object-cover rounded-lg">
                    </div>
                    
                    <!-- Miniaturas -->
                    @if(count($centro->fotos) > 1)
                        <div class="grid grid-cols-4 md:grid-cols-8 gap-2">
                            @foreach($centro->fotos as $index => $foto)
                                <img src="{{ Storage::url($foto) }}" 
                                     alt="Foto {{ $index + 1 }}" 
                                     class="w-full h-16 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity duration-200 photo-thumbnail {{ $index === 0 ? 'ring-2 ring-blue-500' : '' }}"
                                     onclick="changeMainPhoto('{{ Storage::url($foto) }}', this)">
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
                                <span class="ml-2 text-sm text-gray-600">{{ number_format($centro->calificacion_promedio, 1) }}</span>
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
                                <p class="text-gray-600 text-sm">{{ $centro->ciudad }}@if($centro->distrito), {{ $centro->distrito }}@endif</p>
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
                        <a href="#" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Gestionar Instalaciones
                        </a>
                        
                        <a href="#" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
                            Ver Reservas
                        </a>
                        
                        <a href="#" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block">
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
</script>
@endsection
