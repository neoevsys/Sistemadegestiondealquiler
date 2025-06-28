@extends('layouts.main')
@section('content')
<div class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-purple-600" style="min-height:calc(100vh - 4rem - 12rem);">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-2xl px-6 py-6">
            <div class="flex flex-col items-center mb-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center mb-2 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-1">Bienvenido de nuevo</h1>
                <p class="text-gray-500 text-xs">Inicia sesión para continuar</p>
            </div>
            @if (session('status'))
                <div class="mb-3 text-green-600 font-semibold text-center text-sm">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="space-y-3">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600 mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-600 mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center text-xs">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-gray-600">Recuérdame</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs text-blue-600 hover:underline" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-2 rounded-lg font-semibold shadow transition-colors">Iniciar Sesión</button>
                <div class="text-center mt-2 text-xs text-gray-600">
                    ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Regístrate</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
