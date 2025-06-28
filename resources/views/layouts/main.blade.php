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
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
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
                <div class="flex items-center space-x-4">
                    @guest
                    <a href="{{ route('login') }}"
                        class="bg-white text-blue-600 border border-blue-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-50 transition-colors">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        Registrarse
                    </a>
                    @else
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button" class="flex items-center bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg text-sm font-medium text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Hola, {{ Auth::user()->nombre }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Perfil</a>
                            @if(Auth::user()->tipo_usuario === 'cliente')
                                <a href="{{ route('reservas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mis Reservas</a>
                            @elseif(Auth::user()->tipo_usuario === 'propietario')
                                <a href="{{ route('propietario.centros.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mis Centros</a>
                                <a href="{{ route('propietario.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Panel Propietario</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal de la Página -->
    <main class="mt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12" id="contacto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/logo.webp') }}" alt="{{ config('app.name', 'Mi Plataforma') }} Logo"
                            class="w-8 h-8 rounded-lg">
                        <span class="ml-2 text-lg font-bold">
                            {{ config('app.name', 'Mi Plataforma') }}
                        </span>
                    </div>
                    <p class="text-gray-400">
                        La plataforma líder en gestión y alquiler de centros deportivos.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Plataforma</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('centros.index') }}"
                                class="hover:text-white transition-colors">Buscar Canchas</a></li>
                        <li><a href="{{ route('propietario.dashboard') }}"
                                class="hover:text-white transition-colors">Gestión</a></li>
                        <li><a href="#"
                                class="hover:text-white transition-colors">Precios</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Soporte</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#"
                                class="hover:text-white transition-colors">Centro de Ayuda</a></li>
                        <li><a href="#contacto"
                                class="hover:text-white transition-colors">Contacto</a></li>
                        <li><a href="#"
                                class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>📧 info@tusitio.com</li>
                        <li>📞 +51 900 123 456</li>
                        <li>📍 Lima, Perú</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Mi Plataforma') }}. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>
