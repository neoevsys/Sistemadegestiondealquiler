@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $instalacion->nombre }}</h1>
                    <p class="mt-2 text-gray-600">{{ $centro->nombre }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('propietario.centros.instalaciones.edit', [$centro, $instalacion]) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('propietario.centros.instalaciones.index', $centro) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a Instalaciones
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

        <!-- Estado de la Instalación -->
        <div class="mb-6">
            <div class="flex items-center justify-between bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-700 mr-3">Estado:</span>
                    @if($instalacion->estadoInstalacion)
                        @php
                            $estadoClasses = [
                                'activo' => 'bg-green-100 text-green-800',
                                'inactivo' => 'bg-red-100 text-red-800',
                                'mantenimiento' => 'bg-yellow-100 text-yellow-800',
                            ];
                            $estadoClass = $estadoClasses[$instalacion->estadoInstalacion->nombre] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $estadoClass }}">
                            {{ ucfirst($instalacion->estadoInstalacion->nombre) }}
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Sin estado
                        </span>
                    @endif
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Precio por hora:</span>
                    <span class="text-lg font-bold text-gray-900">S/. {{ number_format($instalacion->precio_por_hora, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Galería de Fotos -->
        @if($instalacion->foto_principal || ($instalacion->fotos_adicionales && count($instalacion->fotos_adicionales) > 0))
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Galería de Fotos</h2>
                    
                    <!-- Foto principal -->
                    @if($instalacion->foto_principal)
                        <div class="mb-4">
                            @php
                                $fotoUrl = (filter_var($instalacion->foto_principal, FILTER_VALIDATE_URL)) 
                                    ? $instalacion->foto_principal 
                                    : Storage::url($instalacion->foto_principal);
                            @endphp
                            <img id="main-photo" 
                                 src="{{ $fotoUrl }}" 
                                 alt="{{ $instalacion->nombre }}" 
                                 class="w-full h-96 object-cover rounded-lg"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\' viewBox=\'0 0 400 300\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23e5e7eb\'/%3E%3Cg fill=\'%239ca3af\'%3E%3Cpath d=\'M200 120h-40v80h80v-80h-40zm20 60h-40v-40h40v40z\'/%3E%3Cpath d=\'M160 100h80l20 20v80l-20 20h-80l-20-20v-80l20-20zm80 20l-10-10h-60l-10 10v60l10 10h60l10-10v-60z\'/%3E%3C/g%3E%3C/svg%3E'">
                        </div>
                    @endif
                    
                    <!-- Fotos adicionales -->
                    @if($instalacion->fotos_adicionales && count($instalacion->fotos_adicionales) > 0)
                        <div class="grid grid-cols-4 md:grid-cols-8 gap-2">
                            @foreach($instalacion->fotos_adicionales as $index => $foto)
                                @php
                                    $photoUrl = (filter_var($foto, FILTER_VALIDATE_URL)) 
                                        ? $foto 
                                        : Storage::url($foto);
                                @endphp
                                <img src="{{ $photoUrl }}" 
                                     alt="Foto {{ $index + 1 }}" 
                                     class="w-full h-16 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity duration-200 photo-thumbnail"
                                     onclick="changeMainPhoto('{{ $photoUrl }}', this)"
                                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'%3E%3Crect width=\'100\' height=\'100\' fill=\'%23e5e7eb\'/%3E%3Cg fill=\'%239ca3af\'%3E%3Cpath d=\'M50 30h-20v40h40v-40h-20zm10 30h-20v-20h20v20z\'/%3E%3C/g%3E%3C/svg%3E'">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Información de la Instalación -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Información Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información Básica -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información Básica</h2>
                    
                    @if($instalacion->descripcion)
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Descripción</h3>
                            <p class="text-gray-600">{{ $instalacion->descripcion }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Capacidad Máxima</h3>
                            <p class="text-gray-900 font-semibold">{{ $instalacion->capacidad_maxima }} personas</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-1">Superficie</h3>
                            <p class="text-gray-900">{{ $instalacion->superficie ?? 'No especificado' }}</p>
                        </div>

                        @if($instalacion->dimensiones)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">Dimensiones</h3>
                                <p class="text-gray-900">{{ $instalacion->dimensiones }}</p>
                            </div>
                        @endif

                        @if($instalacion->equipamiento_incluido)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-1">Equipamiento</h3>
                                <p class="text-gray-900">{{ $instalacion->equipamiento_incluido }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tipos de Deporte -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deportes Disponibles</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($instalacion->tiposDeporte as $deporte)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ $deporte->nombre }}
                            </span>
                        @empty
                            <p class="text-gray-500">No hay deportes asignados</p>
                        @endforelse
                    </div>
                </div>

                <!-- Reservas Recientes -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Reservas Recientes</h2>
                    @if($instalacion->reservas->count() > 0)
                        <div class="space-y-3">
                            @foreach($instalacion->reservas->take(5) as $reserva)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $reserva->usuario->nombre ?? 'Usuario' }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $reserva->fecha_reserva->format('d/m/Y') }} - 
                                            {{ $reserva->hora_inicio }} a {{ $reserva->hora_fin }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">S/. {{ number_format($reserva->precio_total, 2) }}</p>
                                        @if($reserva->estadoReserva)
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                @if($reserva->estadoReserva->nombre === 'confirmada') bg-green-100 text-green-800
                                                @elseif($reserva->estadoReserva->nombre === 'pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($reserva->estadoReserva->nombre === 'cancelada') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($reserva->estadoReserva->nombre) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No hay reservas registradas</p>
                    @endif
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="space-y-6">
                <!-- Estadísticas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Estadísticas</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Reservas</span>
                            <span class="font-semibold text-gray-900">{{ $instalacion->reservas->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Reservas Este Mes</span>
                            <span class="font-semibold text-gray-900">
                                {{ $instalacion->reservas->where('fecha_reserva', '>=', now()->startOfMonth())->count() }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Ingresos Este Mes</span>
                            <span class="font-semibold text-gray-900">
                                S/. {{ number_format($instalacion->reservas->where('fecha_reserva', '>=', now()->startOfMonth())->sum('precio_total'), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Acciones</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('propietario.centros.instalaciones.edit', [$centro, $instalacion]) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 text-center block flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Instalación
                        </a>
                        
                        <form action="{{ route('propietario.centros.instalaciones.destroy', [$centro, $instalacion]) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta instalación? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                                Eliminar Instalación
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
    const mainPhoto = document.getElementById('main-photo');
    if (mainPhoto) {
        mainPhoto.src = src;
    }
    
    // Remover el anillo de selección de todas las miniaturas
    document.querySelectorAll('.photo-thumbnail').forEach(img => {
        img.classList.remove('ring-2', 'ring-blue-500');
    });
    
    // Agregar el anillo de selección a la miniatura clickeada
    thumbnail.classList.add('ring-2', 'ring-blue-500');
}
</script>
@endsection
