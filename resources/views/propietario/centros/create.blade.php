@extends('layouts.main')

@section('content')
    <div class="py-8 min-h-screen bg-blue-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-blue-900 drop-shadow mb-1">Agregar Centro Deportivo</h1>
                        <p class="mt-2 text-blue-700 text-lg">Completa la información de tu nuevo centro deportivo</p>
                    </div>
                    <a href="{{ route('propietario.centros.index') }}"
                        class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-4 py-2 rounded-xl font-semibold transition duration-200 flex items-center border border-blue-200 shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('propietario.centros.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Información Básica -->
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-blue-900 mb-6">Información Básica</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Nombre (fila completa) -->
                        <div class="col-span-2">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Centro <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nombre') border-red-500 @enderror"
                                placeholder="Ej: Centro Deportivo Los Pinos" required>
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción (fila completa) -->
                        <div class="col-span-2">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea id="descripcion" name="descripcion" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('descripcion') border-red-500 @enderror"
                                placeholder="Describe tu centro deportivo, instalaciones y servicios que ofreces...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deportes (checkboxes) -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deportes habilitados
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @foreach($tiposDeportes as $deporte)
                                    <label class="flex items-center bg-white border border-blue-200 rounded-xl px-4 py-3 shadow hover:shadow-lg hover:bg-blue-50 transition cursor-pointer w-full">
                                        <input type="checkbox" name="deportes[]" value="{{ $deporte->nombre }}" class="form-checkbox h-5 w-5 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-3 text-blue-800 font-semibold tracking-wide">{{ $deporte->nombre }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Dirección (fila completa) -->
                        <div class="col-span-2">
                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                                Dirección <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('direccion') border-red-500 @enderror bg-white"
                                placeholder="Ej: Av. Los Deportes 123" required>
                            @error('direccion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mapa (fila completa) -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ubicación en el Mapa
                            </label>
                            <div id="map" style="height: 300px !important; width: 100% !important; border: 2px solid #2563eb !important; border-radius: 0.5rem; overflow: hidden; position: relative; z-index: 10;"></div>
                            <input type="hidden" id="latitud" name="latitud" value="{{ old('latitud') }}">
                            <input type="hidden" id="longitud" name="longitud" value="{{ old('longitud') }}">
                            <p class="text-xs text-gray-500 mt-2">Haz clic en el mapa para seleccionar la ubicación del
                                centro. La latitud y longitud se llenarán automáticamente.</p>
                            @error('latitud')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('longitud')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Departamento -->
                        <div class="col-span-1">
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Departamento <span class="text-red-500">*</span>
                            </label>
                            <select id="departamento_id" name="departamento_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('departamento_id') border-red-500 @enderror"
                                required>
                                <option value="">Seleccione un departamento</option>
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}"
                                        {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                        {{ $departamento->nombre }}</option>
                                @endforeach
                            </select>
                            @error('departamento_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Provincia -->
                        <div class="col-span-1">
                            <label for="provincia_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Provincia <span class="text-red-500">*</span>
                            </label>
                            <select id="provincia_id" name="provincia_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('provincia_id') border-red-500 @enderror"
                                required disabled>
                                <option value="">Seleccione una provincia</option>
                                @foreach ($provincias as $provincia)
                                    <option value="{{ $provincia->id }}" data-departamento="{{ $provincia->departamento_id }}"
                                        {{ old('provincia_id') == $provincia->id ? 'selected' : '' }}>
                                        {{ $provincia->nombre }}</option>
                                @endforeach
                            </select>
                            @error('provincia_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Distrito -->
                        <div class="col-span-1">
                            <label for="distrito_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Distrito <span class="text-red-500">*</span>
                            </label>
                            <select id="distrito_id" name="distrito_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('distrito_id') border-red-500 @enderror"
                                required disabled>
                                <option value="">Seleccione un distrito</option>
                                @foreach ($distritos as $distrito)
                                    <option value="{{ $distrito->id }}" data-provincia="{{ $distrito->provincia_id }}"
                                        {{ old('distrito_id') == $distrito->id ? 'selected' : '' }}>
                                        {{ $distrito->nombre }}</option>
                                @endforeach
                            </select>
                            @error('distrito_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Código Postal (toma la posición de estado) -->
                        <div class="col-span-1">
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-2">
                                Código Postal
                            </label>
                            <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('codigo_postal') border-red-500 @enderror bg-white"
                                placeholder="Ej: 15047">
                            @error('codigo_postal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Estado oculto: siempre activo (id=1) -->
                        <input type="hidden" name="estado_id" value="1">
                    </div>
                </div>

                <!-- Contacto -->
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-blue-900 mb-6">Información de Contacto</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Teléfono -->
                        <div class="col-span-1">
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono
                            </label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('telefono') border-red-500 @enderror"
                                placeholder="Ej: +51 123 456 789">
                            @error('telefono')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                placeholder="Ej: info@centrolospinos.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Servicios y Políticas -->
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-blue-900 mb-6">Servicios y Políticas</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Servicios Adicionales -->
                        <div class="col-span-2">
                            <label for="servicios_adicionales" class="block text-sm font-medium text-gray-700 mb-2">
                                Servicios Adicionales
                            </label>
                            <textarea id="servicios_adicionales" name="servicios_adicionales" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('servicios_adicionales') border-red-500 @enderror"
                                placeholder="Ej: Estacionamiento gratuito, Vestuarios, Duchas, Cafetería, WiFi, etc.">{{ old('servicios_adicionales') }}</textarea>
                            @error('servicios_adicionales')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Políticas -->
                        <div class="col-span-2">
                            <label for="politicas" class="block text-sm font-medium text-gray-700 mb-2">
                                Políticas del Centro
                            </label>
                            <textarea id="politicas" name="politicas" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('politicas') border-red-500 @enderror"
                                placeholder="Ej: Horarios de funcionamiento, reglas de uso, políticas de cancelación, etc.">{{ old('politicas') }}</textarea>
                            @error('politicas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Fotos -->
                <div class="bg-white rounded-2xl shadow-xl border border-blue-100 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-blue-900 mb-6">Fotos del Centro</h2>
                    <p class="text-blue-700 mb-4">Agrega hasta 10 fotos de tu centro deportivo (máximo 5MB por imagen)</p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <div class="flex items-center justify-center w-full">
                                <label for="fotos"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Haz clic para
                                                subir</span> o arrastra y suelta</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG o WEBP (máx. 5MB cada una)</p>
                                    </div>
                                    <input id="fotos" name="fotos[]" type="file" class="hidden" multiple
                                        accept="image/jpeg,image/jpg,image/png,image/webp">
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
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('propietario.centros.index') }}"
                        class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-6 py-3 rounded-xl font-semibold border border-blue-200 shadow transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow transition duration-200">
                        Guardar Centro
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    // Serializar provincias y distritos para JS
    const PROVINCIAS = @json($provincias);
    const DISTRITOS = @json($distritos);
    document.addEventListener('DOMContentLoaded', function() {
        // Al enviar el formulario, concatena los deportes seleccionados a la descripción
        document.querySelector('form').addEventListener('submit', function(e) {
            var desc = document.getElementById('descripcion').value.trim();
            var deportes = Array.from(document.querySelectorAll('input[name="deportes[]"]:checked')).map(cb => cb.value);
            if (deportes.length > 0) {
                desc += (desc ? '\n' : '') + 'Habilitado para los siguientes deportes:\n' + deportes.join(', ');
                document.getElementById('descripcion').value = desc;
            }
        });

        // Ubigeo dependiente
        const departamentoSelect = document.getElementById('departamento_id');
        const provinciaSelect = document.getElementById('provincia_id');
        const distritoSelect = document.getElementById('distrito_id');

        function resetSelect(select, placeholder) {
            select.innerHTML = `<option value="">${placeholder}</option>`;
            select.disabled = true;
        }

        departamentoSelect.addEventListener('change', function() {
            resetSelect(provinciaSelect, 'Seleccione una provincia');
            resetSelect(distritoSelect, 'Seleccione un distrito');
            if (this.value) {
                const provincias = PROVINCIAS.filter(p => p.departamento_id == this.value);
                provincias.forEach(p => {
                    provinciaSelect.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
                });
                provinciaSelect.disabled = false;
            }
        });
        provinciaSelect.addEventListener('change', function() {
            resetSelect(distritoSelect, 'Seleccione un distrito');
            if (this.value) {
                const distritos = DISTRITOS.filter(d => d.provincia_id == this.value);
                distritos.forEach(d => {
                    distritoSelect.innerHTML += `<option value="${d.id}">${d.nombre}</option>`;
                });
                distritoSelect.disabled = false;
            }
        });
        // Si hay valores previos (edición o error de validación), inicializar selects
        if (departamentoSelect.value) {
            departamentoSelect.dispatchEvent(new Event('change'));
            if (provinciaSelect.value) {
                provinciaSelect.value = '{{ old('provincia_id') }}';
                provinciaSelect.dispatchEvent(new Event('change'));
                if (distritoSelect.value) {
                    distritoSelect.value = '{{ old('distrito_id') }}';
                }
            }
        }

        // Foto preview
        const photoInput = document.getElementById('fotos');
        const preview = document.getElementById('photo-preview');
        if (photoInput) {
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
        }

        // Leaflet Map
        requestAnimationFrame(function() {
            var mapDiv = document.getElementById('map');
            if (mapDiv) {
                mapDiv.style.minHeight = '300px';
                mapDiv.style.height = '300px';
                mapDiv.style.width = '100%';
                var defaultLat = parseFloat('{{ old('latitud', '-9.189967') }}');
                var defaultLng = parseFloat('{{ old('longitud', '-75.015152') }}');
                var map = L.map('map').setView([defaultLat, defaultLng], 6);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                var marker;
                if ('{{ old('latitud') }}' && '{{ old('longitud') }}') {
                    marker = L.marker([defaultLat, defaultLng]).addTo(map);
                }
                // Forzar resize tras inicialización y tras 1 segundo
                setTimeout(function() { map.invalidateSize(); }, 100);
                setTimeout(function() { map.invalidateSize(); }, 1000);
                map.on('click', function(e) {
                    console.log('Mapa clicado', e);
                    var lat = e.latlng.lat.toFixed(8);
                    var lng = e.latlng.lng.toFixed(8);
                    document.getElementById('latitud').value = lat;
                    document.getElementById('longitud').value = lng;
                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng]).addTo(map);
                    }
                });
                map.on('zoomend', function() { map.invalidateSize(); });
            }
        });
    });
    </script>
@endsection
