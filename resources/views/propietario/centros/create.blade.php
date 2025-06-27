@extends('layouts.main')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Agregar Centro Deportivo</h1>
                    <p class="mt-2 text-gray-600">Completa la información de tu nuevo centro deportivo</p>
                </div>
                <a href="{{ route('propietario.centros.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Formulario -->
        <form action="{{ route('propietario.centros.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
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
                               value="{{ old('nombre') }}"
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
                                  placeholder="Describe tu centro deportivo, instalaciones y servicios que ofreces...">{{ old('descripcion') }}</textarea>
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
                            <option value="activo" {{ old('estado', 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="mantenimiento" {{ old('estado') === 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
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
                               value="{{ old('direccion') }}"
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
                               value="{{ old('ciudad') }}"
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
                               value="{{ old('distrito') }}"
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
                               value="{{ old('codigo_postal') }}"
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
                               value="{{ old('latitud') }}"
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
                               value="{{ old('longitud') }}"
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
                               value="{{ old('telefono') }}"
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
                               value="{{ old('email') }}"
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
                                  placeholder="Ej: Estacionamiento gratuito, Vestuarios, Duchas, Cafetería, WiFi, etc.">{{ old('servicios_adicionales') }}</textarea>
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
                                  placeholder="Ej: Horarios de funcionamiento, reglas de uso, políticas de cancelación, etc.">{{ old('politicas') }}</textarea>
                        @error('politicas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Fotos -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Fotos del Centro</h2>
                <p class="text-gray-600 mb-4">Agrega hasta 10 fotos de tu centro deportivo (máximo 5MB por imagen)</p>
                
                <div class="space-y-4">
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

                    <!-- Preview de fotos seleccionadas -->
                    <div id="photo-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden">
                        <!-- Las previsualizaciones se mostrarán aquí -->
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('propietario.centros.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg font-medium transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                    Guardar Centro
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endsection
