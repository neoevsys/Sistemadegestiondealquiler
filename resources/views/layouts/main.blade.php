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
</head>

<body class="font-sans antialiased min-h-screen flex flex-col">
    <!-- Barra de Navegación Global -->
    <nav class="bg-black border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo y Nombre de la Plataforma -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <!-- Añadimos 'flex items-center' aquí -->
                            <!-- Tu Logo -->
                            <img src="{{ asset('images/logo.webp') }}"
                                alt="{{ config('app.name', 'Mi Plataforma') }} Logo" class="block h-10 w-auto">
                            <!-- Ajusta h-10 según el tamaño deseado -->
                            <!-- Nombre de la Plataforma -->
                            <span class="ml-3 text-2xl font-bold text-white">
                                <!-- Ajusta ml-3 y text-2xl según el tamaño deseado -->
                                {{ config('app.name', 'Mi Plataforma') }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Menú de Navegación (Alineado a la derecha) -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                        <!-- Enlaces para usuarios autenticados -->
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Inicio') }}
                        </x-nav-link>
                        @if (Auth::user()->tipo_usuario === 'cliente')
                            <x-nav-link :href="route('cliente.dashboard')" :active="request()->routeIs('cliente.dashboard')">
                                {{ __('Mi Dashboard') }}
                            </x-nav-link>
                        @elseif(Auth::user()->tipo_usuario === 'propietario')
                            <x-nav-link :href="route('propietario.dashboard')" :active="request()->routeIs('propietario.dashboard')">
                                {{ __('Mi Negocio') }}
                            </x-nav-link>
                        @elseif(Auth::user()->tipo_usuario === 'administrador')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Administración') }}
                            </x-nav-link>
                        @endif
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            {{ __('Perfil') }}
                        </x-nav-link>

                        <!-- Dropdown de Usuario (Logout) -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->nombre }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <!-- Enlaces para usuarios no autenticados -->
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Iniciar Sesión') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Registrarse') }}
                        </x-nav-link>
                    @endauth
                </div>

                <!-- Hamburger (para móviles) -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menú Responsivo (para móviles) -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Inicio') }}
                    </x-responsive-nav-link>
                    @if (Auth::user()->tipo_usuario === 'cliente')
                        <x-responsive-nav-link :href="route('cliente.dashboard')" :active="request()->routeIs('cliente.dashboard')">
                            {{ __('Mi Dashboard') }}
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->tipo_usuario === 'propietario')
                        <x-responsive-nav-link :href="route('propietario.dashboard')" :active="request()->routeIs('propietario.dashboard')">
                            {{ __('Mi Negocio') }}
                        </x-responsive-nav-link>
                    @elseif(Auth::user()->tipo_usuario === 'administrador')
                        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Administración') }}
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Iniciar Sesión') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Registrarse') }}
                    </x-responsive-nav-link>
                @endauth
            </div>

            @auth
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->nombre }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Contenido Principal de la Página -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Global -->
    <footer class="bg-black text-white py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Mi Plataforma') }}. Todos los derechos reservados.
            </p>
            <div class="mt-2 text-sm">
                <a href="#" class="text-gray-400 hover:text-white mx-2">Política de Privacidad</a>
                <span class="text-gray-500">|</span>
                <a href="#" class="text-gray-400 hover:text-white mx-2">Términos de Servicio</a>
            </div>
        </div>
    </footer>
</body>

</html>
