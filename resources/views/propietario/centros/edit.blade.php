@extends('layouts.main')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Centro Deportivo</h1>
                    <p class="mt-2 text-gray-600">Actualiza la información de {{ $centro->nombre }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('propietario.centros.show', $centro) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver
                    </a>
                    <a href="{{ route('propietario.centros.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('propietario.centros.update', $centro) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PATCH')
            
            <!-- Información Básica -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Información Básica</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Centro <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $centro->nombre) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
                               placeholder="Ej: Centro Deportivo Los Pinos"
                               required>
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="md:col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea id="descripcion" 
                                  name="descripcion" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('descripcion') border-red-500 @enderror"
                                  placeholder="Describe tu centro deportivo, instalaciones y servicios que ofreces...">{{ old('descripcion', $centro->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select id="estado" 
                                name="estado"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('estado') border-red-500 @enderror"
                                required>
                            <option value="activo" {{ old('estado', $centro->estado) === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $centro->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="mantenimiento" {{ old('estado', $centro->estado) === 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Ubicación -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubicación</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dirección -->
                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="direccion" 
                               name="direccion" 
                               value="{{ old('direccion', $centro->direccion) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('direccion') border-red-500 @enderror"
                               placeholder="Ej: Av. Los Deportes 123"
                               required>
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ciudad -->
                    <div>
                        <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-2">
                            Ciudad <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="ciudad" 
                               name="ciudad" 
                               value="{{ old('ciudad', $centro->ciudad) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ciudad') border-red-500 @enderror"
                               placeholder="Ej: Lima"
                               required>
                        @error('ciudad')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Distrito -->
                    <div>
                        <label for="distrito" class="block text-sm font-medium text-gray-700 mb-2">
                            Distrito
                        </label>
                        <input type="text" 
                               id="distrito" 
                               name="distrito" 
                               value="{{ old('distrito', $centro->distrito) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('distrito') border-red-500 @enderror"
                               placeholder="Ej: San Isidro">
                        @error('distrito')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Código Postal -->
                    <div>
                        <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-2">
                            Código Postal
                        </label>
                        <input type="text" 
                               id="codigo_postal" 
                               name="codigo_postal" 
                               value="{{ old('codigo_postal', $centro->codigo_postal) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('codigo_postal') border-red-500 @enderror"
                               placeholder="Ej: 15047">
                        @error('codigo_postal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Coordenadas -->
                    <div>
                        <label for="latitud" class="block text-sm font-medium text-gray-700 mb-2">
                            Latitud
                        </label>
                        <input type="number" 
                               id="latitud" 
                               name="latitud" 
                               value="{{ old('latitud', $centro->latitud) }}"
                               step="0.00000001"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('latitud') border-red-500 @enderror"
                               placeholder="Ej: -12.046374">
                        @error('latitud')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="longitud" class="block text-sm font-medium text-gray-700 mb-2">
                            Longitud
                        </label>
                        <input type="number" 
                               id="longitud" 
                               name="longitud" 
                               value="{{ old('longitud', $centro->longitud) }}"
                               step="0.00000001"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('longitud') border-red-500 @enderror"
                               placeholder="Ej: -77.042794">
                        @error('longitud')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Información de Contacto</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="text" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $centro->telefono) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('telefono') border-red-500 @enderror"
                               placeholder="Ej: +51 123 456 789">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $centro->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="Ej: info@centrolospinos.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Servicios y Políticas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Servicios y Políticas</h2>
                
                <div class="space-y-6">
                    <!-- Servicios Adicionales -->
                    <div>
                        <label for="servicios_adicionales" class="block text-sm font-medium text-gray-700 mb-2">
                            Servicios Adicionales
                        </label>
                        <textarea id="servicios_adicionales" 
                                  name="servicios_adicionales" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('servicios_adicionales') border-red-500 @enderror"
                                  placeholder="Ej: Estacionamiento gratuito, Vestuarios, Duchas, Cafetería, WiFi, etc.">{{ old('servicios_adicionales', $centro->servicios_adicionales) }}</textarea>
                        @error('servicios_adicionales')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Políticas -->
                    <div>
                        <label for="politicas" class="block text-sm font-medium text-gray-700 mb-2">
                            Políticas del Centro
                        </label>
                        <textarea id="politicas" 
                                  name="politicas" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('politicas') border-red-500 @enderror"
                                  placeholder="Ej: Horarios de funcionamiento, reglas de uso, políticas de cancelación, etc.">{{ old('politicas', $centro->politicas) }}</textarea>
                        @error('politicas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Fotos -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Fotos del Centro</h2>
                
                <!-- Fotos existentes -->
                @if($centro->fotos && count($centro->fotos) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Fotos Actuales</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($centro->fotos as $index => $foto)
                                <div class="relative group">
                                    <img src="{{ Storage::url($foto) }}" 
                                         alt="Foto {{ $index + 1 }}" 
                                         class="w-full h-24 object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                        <label class="cursor-pointer">
                                            <input type="checkbox" 
                                                   name="fotos_eliminar[]" 
                                                   value="{{ $foto }}"
                                                   class="sr-only foto-eliminar">
                                            <div class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs font-medium">
                                                Eliminar
                                            </div>
                                        </label>
                                    </div>
                                    <div class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold opacity-0 foto-selected">
                                        ✓
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Haz clic en "Eliminar" para marcar las fotos que deseas quitar</p>
                    </div>
                @endif
                
                <!-- Agregar nuevas fotos -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Agregar Nuevas Fotos</h3>
                    <p class="text-gray-600 mb-4">Agrega más fotos de tu centro deportivo (máximo 5MB por imagen)</p>
                    
                    <div class="flex items-center justify-center w-full">
                        <label for="fotos" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Haz clic para subir</span> o arrastra y suelta</p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG o WEBP (máx. 5MB cada una)</p>
                            </div>
                            <input id="fotos" name="fotos[]" type="file" class="hidden" multiple accept="image/jpeg,image/jpg,image/png,image/webp">
                        </label>
                    </div>
                    
                    @error('fotos')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @error('fotos.*')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview de nuevas fotos seleccionadas -->
                    <div id="photo-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden">
                        <!-- Las previsualizaciones se mostrarán aquí -->
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('propietario.centros.show', $centro) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                    Actualizar Centro
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de preview de nuevas fotos
    const photoInput = document.getElementById('fotos');
    const preview = document.getElementById('photo-preview');
    
    photoInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        preview.innerHTML = '';
        
        if (files.length > 0) {
            preview.classList.remove('hidden');
            
            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="w-full h-24 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                <p class="text-white text-xs text-center px-2">${file.name}</p>
                            </div>
                        `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            preview.classList.add('hidden');
        }
    });

    // Manejo de eliminación de fotos existentes
    const fotosEliminar = document.querySelectorAll('.foto-eliminar');
    fotosEliminar.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.relative');
            const selectedIcon = container.querySelector('.foto-selected');
            
            if (this.checked) {
                container.classList.add('opacity-50');
                selectedIcon.classList.remove('opacity-0');
            } else {
                container.classList.remove('opacity-50');
                selectedIcon.classList.add('opacity-0');
            }
        });
    });
});
</script>
@endsection
