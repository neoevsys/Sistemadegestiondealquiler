@extends('layouts.main')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-center mb-6">¡Bienvenido a {{ config('app.name', 'Mi Plataforma') }}!</h1>
                    <p class="text-lg text-center text-gray-700">
                        Tu destino para encontrar y reservar las mejores instalaciones deportivas.
                    </p>
                    <div class="mt-8 text-center">
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Regístrate Ahora
                            </a>
                            <a href="{{ route('login') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Iniciar Sesión
                            </a>
                        @else
                            <p class="text-xl font-semibold text-indigo-600">¡Hola, {{ Auth::user()->nombre }}!</p>
                            <p class="mt-2 text-gray-700">Explora las opciones disponibles o gestiona tus reservas.</p>
                            @if(Auth::user()->tipo_usuario === 'cliente')
                                <a href="{{ route('cliente.dashboard') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Ir a mi Dashboard
                                </a>
                            @elseif(Auth::user()->tipo_usuario === 'propietario')
                                <a href="{{ route('propietario.dashboard') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Gestionar mi Negocio
                                </a>
                            @elseif(Auth::user()->tipo_usuario === 'administrador')
                                <a href="{{ route('admin.dashboard') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Panel de Administración
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
