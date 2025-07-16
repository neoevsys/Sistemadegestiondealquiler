@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Nueva Instalación</h1>
                    <p class="mt-2 text-gray-600">Crear una nueva instalación para {{ $centro->nombre }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('propietario.centros.instalaciones.index', $centro) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancelar
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('propietario.centros.instalaciones.store', $centro) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Información Básica -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información Básica</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Instalación</label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('nombre') }}" 
                                   required>
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="precio_por_hora" class="block text-sm font-medium text-gray-700 mb-2">Precio por Hora (S/.)</label>
                            <input type="number" 
                                   name="precio_por_hora" 
                                   id="precio_por_hora" 
                                   step="0.01" 
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('precio_por_hora') }}" 
                                   required>
                            @error('precio_por_hora')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="capacidad_maxima" class="block text-sm font-medium text-gray-700 mb-2">Capacidad Máxima</label>
                            <input type="number" 
                                   name="capacidad_maxima" 
                                   id="capacidad_maxima" 
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('capacidad_maxima') }}" 
                                   required>
                            @error('capacidad_maxima')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="superficie" class="block text-sm font-medium text-gray-700 mb-2">Superficie</label>
                            <select name="superficie" 
                                    id="superficie"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Seleccionar superficie</option>
                                @foreach($superficies as $superficie)
                                    <option value="{{ $superficie }}" {{ old('superficie') == $superficie ? 'selected' : '' }}>
                                        {{ $superficie }}
                                    </option>
                                @endforeach
                            </select>
                            @error('superficie')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dimensiones" class="block text-sm font-medium text-gray-700 mb-2">Dimensiones</label>
                            <input type="text" 
                                   name="dimensiones" 
                                   id="dimensiones" 
                                   placeholder="Ej: 40m x 20m"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('dimensiones') }}">
                            @error('dimensiones')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="estado_id" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select name="estado_id" 
                                    id="estado_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="">Seleccionar estado</option>
                                @foreach($estadosInstalacion as $estado)
                                    <option value="{{ $estado->id }}" {{ old('estado_id') == $estado->id ? 'selected' : '' }}>
                                        {{ ucfirst($estado->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="4"
                                  placeholder="Describe las características de la instalación..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tipos de Deporte -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deportes Disponibles</h2>
                    <p class="text-sm text-gray-600 mb-4">Selecciona los deportes que se pueden practicar en esta instalación</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="deportes-container">
                        @foreach($tiposDeporte as $deporte)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="tipos_deporte[]" 
                                       value="{{ $deporte->id }}"
                                       id="deporte_{{ $deporte->id }}"
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded deporte-checkbox"
                                       {{ in_array($deporte->id, old('tipos_deporte', [])) ? 'checked' : '' }}>
                                <label for="deporte_{{ $deporte->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $deporte->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div id="deportes-error" class="mt-1 text-sm text-red-600 hidden">
                        Debes seleccionar al menos un deporte
                    </div>
                    @error('tipos_deporte')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fotos -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Fotos</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="foto_principal" class="block text-sm font-medium text-gray-700 mb-2">Foto Principal</label>
                            <input type="file" 
                                   name="foto_principal" 
                                   id="foto_principal" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-sm text-gray-500">Máximo 5MB. Formatos: JPG, PNG, GIF</p>
                            @error('foto_principal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fotos_adicionales" class="block text-sm font-medium text-gray-700 mb-2">Fotos Adicionales</label>
                            <input type="file" 
                                   name="fotos_adicionales[]" 
                                   id="fotos_adicionales" 
                                   accept="image/*"
                                   multiple
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-sm text-gray-500">Puedes seleccionar múltiples archivos</p>
                            @error('fotos_adicionales.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('propietario.centros.instalaciones.index', $centro) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                        Crear Instalación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para mostrar errores
    function showError(input, message) {
        const errorDiv = input.parentNode.querySelector('.error-message') || document.createElement('div');
        errorDiv.className = 'error-message mt-1 text-sm text-red-600';
        errorDiv.textContent = message;
        
        if (!input.parentNode.querySelector('.error-message')) {
            input.parentNode.appendChild(errorDiv);
        }
        
        input.classList.add('border-red-500');
        input.classList.remove('border-gray-300');
    }
    
    // Función para ocultar errores
    function hideError(input) {
        const errorDiv = input.parentNode.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300');
    }
    
    // Validación del nombre
    document.getElementById('nombre').addEventListener('blur', function() {
        const value = this.value.trim();
        if (value === '') {
            showError(this, 'El nombre es requerido');
        } else if (value.length < 3) {
            showError(this, 'El nombre debe tener al menos 3 caracteres');
        } else if (value.length > 255) {
            showError(this, 'El nombre no puede tener más de 255 caracteres');
        } else {
            hideError(this);
        }
    });
    
    // Validación del precio por hora
    document.getElementById('precio_por_hora').addEventListener('blur', function() {
        const value = parseFloat(this.value);
        if (isNaN(value) || value <= 0) {
            showError(this, 'El precio debe ser un número mayor a 0');
        } else if (value > 10000) {
            showError(this, 'El precio no puede ser mayor a 10,000');
        } else {
            hideError(this);
        }
    });
    
    // Validación de capacidad máxima
    document.getElementById('capacidad_maxima').addEventListener('blur', function() {
        const value = parseInt(this.value);
        if (isNaN(value) || value < 1) {
            showError(this, 'La capacidad debe ser al menos 1 persona');
        } else if (value > 1000) {
            showError(this, 'La capacidad no puede ser mayor a 1,000 personas');
        } else {
            hideError(this);
        }
    });
    
    // Validación de superficie
    document.getElementById('superficie').addEventListener('change', function() {
        if (this.value === '') {
            showError(this, 'Debes seleccionar una superficie');
        } else {
            hideError(this);
        }
    });
    
    // Validación de estado
    document.getElementById('estado_id').addEventListener('change', function() {
        if (this.value === '') {
            showError(this, 'Debes seleccionar un estado');
        } else {
            hideError(this);
        }
    });
    
    // Validación de deportes disponibles
    function validateDeportes() {
        const checkboxes = document.querySelectorAll('.deporte-checkbox');
        const checked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        const errorDiv = document.getElementById('deportes-error');
        
        if (!checked) {
            errorDiv.classList.remove('hidden');
            return false;
        } else {
            errorDiv.classList.add('hidden');
            return true;
        }
    }
    
    // Agregar eventos a los checkboxes de deportes
    document.querySelectorAll('.deporte-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', validateDeportes);
    });
    
    // Validación de archivos de imagen
    function validateImageFile(input, maxSize = 5 * 1024 * 1024) { // 5MB por defecto
        const files = input.files;
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        
        if (files.length === 0) return true;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            // Validar tipo de archivo
            if (!validTypes.includes(file.type)) {
                showError(input, `El archivo "${file.name}" no es una imagen válida. Formatos permitidos: JPG, PNG, GIF, WEBP`);
                input.value = '';
                return false;
            }
            
            // Validar tamaño de archivo
            if (file.size > maxSize) {
                showError(input, `El archivo "${file.name}" es demasiado grande. Tamaño máximo: 5MB`);
                input.value = '';
                return false;
            }
        }
        
        hideError(input);
        return true;
    }
    
    // Validación de foto principal
    document.getElementById('foto_principal').addEventListener('change', function() {
        validateImageFile(this);
    });
    
    // Validación de fotos adicionales
    document.getElementById('fotos_adicionales').addEventListener('change', function() {
        const files = this.files;
        
        // Validar número máximo de archivos
        if (files.length > 10) {
            showError(this, 'No puedes subir más de 10 fotos adicionales');
            this.value = '';
            return;
        }
        
        validateImageFile(this);
    });
    
    // Validación al enviar el formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validar nombre
        const nombre = document.getElementById('nombre');
        if (nombre.value.trim() === '') {
            showError(nombre, 'El nombre es requerido');
            isValid = false;
        }
        
        // Validar precio
        const precio = document.getElementById('precio_por_hora');
        if (precio.value === '' || parseFloat(precio.value) <= 0) {
            showError(precio, 'El precio debe ser un número mayor a 0');
            isValid = false;
        }
        
        // Validar capacidad
        const capacidad = document.getElementById('capacidad_maxima');
        if (capacidad.value === '' || parseInt(capacidad.value) < 1) {
            showError(capacidad, 'La capacidad debe ser al menos 1 persona');
            isValid = false;
        }
        
        // Validar superficie
        const superficie = document.getElementById('superficie');
        if (superficie.value === '') {
            showError(superficie, 'Debes seleccionar una superficie');
            isValid = false;
        }
        
        // Validar estado
        const estado = document.getElementById('estado_id');
        if (estado.value === '') {
            showError(estado, 'Debes seleccionar un estado');
            isValid = false;
        }
        
        // Validar deportes
        if (!validateDeportes()) {
            isValid = false;
        }
        
        // Validar archivos de imagen
        const fotoPrincipal = document.getElementById('foto_principal');
        if (fotoPrincipal.files.length > 0) {
            if (!validateImageFile(fotoPrincipal)) {
                isValid = false;
            }
        }
        
        const fotosAdicionales = document.getElementById('fotos_adicionales');
        if (fotosAdicionales.files.length > 0) {
            if (!validateImageFile(fotosAdicionales)) {
                isValid = false;
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            // Scroll al primer error
            const firstError = document.querySelector('.border-red-500, .error-message');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>
@endsection
