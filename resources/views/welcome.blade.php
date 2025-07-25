@extends('layouts.main')
@section('content')
    <!-- Hero Section Moderno y Atractivo (altura reducida, centrado vertical y horizontal, textos mejorados) -->
    <section class="hero-gradient min-h-[45vh] flex items-center justify-center relative overflow-hidden py-8 md:py-12">
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none select-none">
            <svg class="absolute top-0 left-0 w-1/2 h-64 opacity-30" viewBox="0 0 400 400" fill="none"><circle cx="200" cy="200" r="200" fill="#a78bfa"/></svg>
            <svg class="absolute bottom-0 right-0 w-1/3 h-48 opacity-20" viewBox="0 0 300 300" fill="none"><circle cx="150" cy="150" r="150" fill="#facc15"/></svg>
        </div>
        <div class="relative w-full max-w-5xl px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center text-center gap-8">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-2 leading-tight drop-shadow-lg tracking-tight">
                <span class="block">Reserva tu <span class="text-yellow-300">Campo Deportivo</span></span>
                <span class="block text-2xl md:text-4xl font-semibold text-blue-100 mt-2">Fácil, Rápido y Seguro</span>
            </h1>
            <p class="text-2xl md:text-3xl text-blue-100 mb-2 max-w-3xl mx-auto font-medium leading-relaxed drop-shadow">
                Descubre y asegura tu espacio ideal para practicar tu deporte favorito. Filtra por disciplina, ciudad y fecha, compara opciones y reserva en solo unos clics.
            </p>
            <p class="text-lg text-blue-200 mb-6 max-w-2xl mx-auto font-normal">
                Disfruta de una experiencia 100% online, con disponibilidad en tiempo real, pagos protegidos y la confianza de miles de usuarios. ¡Vive el deporte como nunca antes!
            </p>
            <div class="flex flex-col gap-4 sm:flex-row sm:gap-4 justify-center w-full">
                <a href="{{ route('centros.index') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-xl text-lg font-bold hover:bg-yellow-300 transition-colors shadow-xl ring-2 ring-yellow-200/60">
                    🏟️ Ver Centros Deportivos
                </a>
                <a href="{{ route('instalaciones.index') }}" class="bg-white text-blue-600 px-8 py-4 rounded-xl text-lg font-bold hover:bg-blue-50 transition-colors shadow-xl ring-2 ring-blue-200/60">
                    ⚽ Ver Instalaciones Disponibles
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Search Moderno -->
    <section class="bg-white shadow-2xl mt-8 md:-mt-8 mx-4 md:mx-8 rounded-2xl relative z-10 border border-blue-100 transition-all duration-300">
        <div class="max-w-6xl mx-auto p-8 md:p-12">
            <div class="text-center mb-10">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-3">Encuentra tu campo deportivo ideal</h2>
                <p class="text-gray-600 text-lg">Busca y reserva en segundos</p>
            </div>
            
            <form method="GET" action="{{ route('centros.index') }}">
                <!-- Primera fila: Ubicación -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Departamento</label>
                        <select id="departamento_id" name="departamento_id" class="w-full p-4 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-blue-50 transition-colors">
                            <option value="">Seleccionar departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Provincia</label>
                        <select id="provincia_id" name="provincia_id" class="w-full p-4 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-blue-50 transition-colors" disabled>
                            <option value="">Seleccionar provincia</option>
                            @foreach($provincias as $provincia)
                                <option value="{{ $provincia->id }}" data-departamento="{{ $provincia->departamento_id }}">{{ $provincia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Distrito / Ciudad</label>
                        <select id="distrito_id" name="distrito_id" class="w-full p-4 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-blue-50 transition-colors" disabled>
                            <option value="">Seleccionar distrito</option>
                            @foreach($distritos as $distrito)
                                <option value="{{ $distrito->id }}" data-provincia="{{ $distrito->provincia_id }}">{{ $distrito->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Segunda fila: Deporte, Fecha y Botón -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Deporte</label>
                        <select class="w-full p-4 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-blue-50 transition-colors" name="deporte">
                            <option value="">Todos los deportes</option>
                            @foreach($tiposDeportes as $deporte)
                                <option value="{{ $deporte->nombre }}">{{ $deporte->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Fecha</label>
                        <input type="date" class="w-full p-4 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-blue-50 transition-colors" name="fecha" min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-xl font-bold hover:from-blue-700 hover:to-purple-700 shadow-lg transition-all duration-300 transform hover:scale-105 text-lg">
                            🔍 Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Features Section Moderno -->
    <section class="py-24 bg-gray-50 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
                    ¿Por qué reservar con nosotros?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Te ayudamos a encontrar el espacio deportivo ideal, con disponibilidad en tiempo real y reservas 100% online.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-white p-10 rounded-2xl shadow-xl card-hover border border-blue-100">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">📱</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Reserva Online</h3>
                    <p class="text-gray-600">
                        Elige tu deporte, fecha y hora, y reserva tu espacio en segundos desde cualquier dispositivo.
                    </p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-xl card-hover border border-green-100">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">💳</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Pago Seguro</h3>
                    <p class="text-gray-600">
                        Realiza el pago de tu reserva de forma segura y recibe confirmación inmediata.
                    </p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-xl card-hover border border-purple-100">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <span class="text-3xl">⭐</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Opiniones Reales</h3>
                    <p class="text-gray-600">
                        Consulta las valoraciones de otros usuarios antes de reservar y comparte tu experiencia.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section Moderno -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
                <div>
                    <div class="text-5xl font-extrabold text-white mb-2 drop-shadow">500+</div>
                    <div class="text-blue-200 text-lg font-medium">Centros Deportivos</div>
                </div>
                <div>
                    <div class="text-5xl font-extrabold text-white mb-2 drop-shadow">10K+</div>
                    <div class="text-blue-200 text-lg font-medium">Usuarios Activos</div>
                </div>
                <div>
                    <div class="text-5xl font-extrabold text-white mb-2 drop-shadow">50K+</div>
                    <div class="text-blue-200 text-lg font-medium">Reservas Realizadas</div>
                </div>
                <div>
                    <div class="text-5xl font-extrabold text-white mb-2 drop-shadow">25</div>
                    <div class="text-blue-200 text-lg font-medium">Ciudades</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
    </style>
    <script>
        // Select dependientes en el frontend (sin AJAX, solo filtrado en el cliente)
        document.addEventListener('DOMContentLoaded', function() {
            const departamentoSelect = document.getElementById('departamento_id');
            const provinciaSelect = document.getElementById('provincia_id');
            const distritoSelect = document.getElementById('distrito_id');

            // Inicialmente bloquea provincia y distrito
            provinciaSelect.disabled = true;
            distritoSelect.disabled = true;

            departamentoSelect.addEventListener('change', function() {
                const selectedDepartamento = this.value;
                // Filtra provincias
                Array.from(provinciaSelect.options).forEach(opt => {
                    opt.style.display = !opt.value || opt.getAttribute('data-departamento') === selectedDepartamento ? '' : 'none';
                });
                provinciaSelect.value = '';
                // Bloquea o desbloquea provincia
                provinciaSelect.disabled = !selectedDepartamento;
                // Reinicia y bloquea distrito
                Array.from(distritoSelect.options).forEach(opt => { opt.style.display = !opt.value ? '' : 'none'; });
                distritoSelect.value = '';
                distritoSelect.disabled = true;
            });

            provinciaSelect.addEventListener('change', function() {
                const selectedProvincia = this.value;
                // Filtra distritos
                Array.from(distritoSelect.options).forEach(opt => {
                    opt.style.display = !opt.value || opt.getAttribute('data-provincia') === selectedProvincia ? '' : 'none';
                });
                distritoSelect.value = '';
                // Bloquea o desbloquea distrito
                distritoSelect.disabled = !selectedProvincia;
            });
        });
    </script>
@endsection
