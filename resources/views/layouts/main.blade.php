<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased min-h-screen flex flex-col justify-between">
    <!-- Barra de Navegación Global -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <img src="{{ asset('images/logo.webp') }}" alt="{{ config('app.name', 'Mi Plataforma') }} Logo"
                                class="block h-10 w-auto">
                            <span class="ml-3 text-xl font-bold text-gray-800">
                                {{ config('app.name', 'Mi Plataforma') }}
                            </span>
                        </a>
                    </div>
                </div>
                <!-- Menú Desktop -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="{{ route('home') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Inicio
                        </a>
                        <a href="{{ route('centros.index') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Centros Deportivos
                        </a>
                        <a href="{{ route('instalaciones.index') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Instalaciones
                        </a>
                        <a href="{{ route('tipos_deportes.index') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Deportes
                        </a>
                        <a href="#contacto"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                            Contacto
                        </a>
                    </div>
                </div>
                <!-- Menú Responsive -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 p-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <!-- Botones de sesión SIEMPRE fuera del menú hamburguesa -->
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="bg-white text-blue-600 border border-blue-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 transition-colors">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">Registrarse</a>
                    @else
                        <div x-data="{ openUser: false }" class="relative">
                            @php
                                $user = Auth::user();
                                $color = 'bg-blue-50 hover:bg-blue-100 text-blue-700 focus:ring-blue-400';
                                if ($user && $user->tipoUsuario) {
                                    if ($user->tipoUsuario->nombre === 'propietario') {
                                        $color = 'bg-green-500 hover:bg-green-600 text-white focus:ring-green-400';
                                    } elseif ($user->tipoUsuario->nombre === 'administrador') {
                                        $color = 'bg-yellow-400 hover:bg-yellow-500 text-gray-900 focus:ring-yellow-400';
                                    } elseif ($user->tipoUsuario->nombre === 'cliente') {
                                        $color = 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-400';
                                    }
                                }
                            @endphp
                            <button @click="openUser = !openUser" type="button" class="flex items-center px-4 py-2 rounded-lg text-sm font-semibold shadow focus:outline-none transition-colors duration-200 {{ $color }}">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Hola, <span class="font-bold ml-1">{{ $user->nombre }}</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openUser" x-cloak @click.away="openUser = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Perfil</a>
                                @if($user->tipoUsuario && $user->tipoUsuario->nombre === 'cliente')
                                    <a href="{{ route('reservas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mis Reservas</a>
                                @elseif($user->tipoUsuario && $user->tipoUsuario->nombre === 'propietario')
                                    <a href="{{ route('propietario.centros.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50">Mis Centros</a>
                                    <a href="{{ route('propietario.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50">Panel Propietario</a>
                                @elseif($user->tipoUsuario && $user->tipoUsuario->nombre === 'administrador')
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-yellow-50">Panel Admin</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50">Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
            <!-- Menú desplegable responsive SOLO links de navegación, nunca botones de sesión ni menú de usuario -->
            <div x-show="open" x-cloak class="md:hidden bg-white shadow-lg rounded-b-xl mt-2 py-4 px-4 space-y-2 transition-all duration-200">
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-blue-600 px-3 py-2 text-base font-medium transition-colors">Inicio</a>
                <a href="{{ route('centros.index') }}" class="block text-gray-700 hover:text-blue-600 px-3 py-2 text-base font-medium transition-colors">Centros Deportivos</a>
                <a href="{{ route('instalaciones.index') }}" class="block text-gray-700 hover:text-blue-600 px-3 py-2 text-base font-medium transition-colors">Instalaciones</a>
                <a href="{{ route('tipos_deportes.index') }}" class="block text-gray-700 hover:text-blue-600 px-3 py-2 text-base font-medium transition-colors">Deportes</a>
                <a href="#contacto" class="block text-gray-700 hover:text-blue-600 px-3 py-2 text-base font-medium transition-colors">Contacto</a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal de la Página -->
    <main class="mt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-10 pb-6" id="contacto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center md:text-left">
                <div>
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <img src="{{ asset('images/logo.webp') }}" alt="{{ config('app.name', 'Mi Plataforma') }} Logo"
                            class="w-10 h-10 rounded-lg">
                        <span class="ml-2 text-lg font-bold">
                            {{ config('app.name', 'Mi Plataforma') }}
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm md:text-base">
                        La plataforma líder en gestión y alquiler de centros deportivos.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Plataforma</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('centros.index') }}" class="hover:text-white transition-colors">Buscar Canchas</a></li>
                        <li><a href="{{ route('propietario.dashboard') }}" class="hover:text-white transition-colors">Gestión</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Precios</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Soporte</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Centro de Ayuda</a></li>
                        <li><a href="#contacto" class="hover:text-white transition-colors">Contacto</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center justify-center md:justify-start gap-2"><span>📧</span> <span>info@tusitio.com</span></li>
                        <li class="flex items-center justify-center md:justify-start gap-2"><span>📞</span> <span>+51 900 123 456</span></li>
                        <li class="flex items-center justify-center md:justify-start gap-2"><span>📍</span> <span>Lima, Perú</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-xs md:text-sm">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Mi Plataforma') }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>

</html>
