@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-purple-600 py-12" style="min-height:calc(100vh - 8rem);">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl px-8 py-8">
            <div class="flex flex-col items-center mb-6">
                <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2H7v-2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">¿Olvidaste tu contraseña?</h1>
                <p class="text-gray-500 text-sm text-center">No te preocupes, te enviaremos un enlace para restablecer tu contraseña</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-600 mb-2">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 rounded-lg font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                    Enviar enlace de recuperación
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">¿Recordaste tu contraseña? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Iniciar sesión</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
