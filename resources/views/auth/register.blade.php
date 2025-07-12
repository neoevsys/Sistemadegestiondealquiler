@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-purple-600 py-12" style="min-height:calc(100vh - 8rem);">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-2xl px-8 py-8">
            <div class="flex flex-col items-center mb-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center mb-2 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-1">Crear cuenta</h1>
                <p class="text-gray-500 text-xs">Regístrate para reservar o administrar centros deportivos</p>
            </div>
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-semibold text-gray-600 mb-1">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="apellido" class="block text-xs font-semibold text-gray-600 mb-1">Apellido (Opcional)</label>
                    <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}" autocomplete="family-name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('apellido')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600 mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="telefono" class="block text-xs font-semibold text-gray-600 mb-1">Teléfono (Opcional)</label>
                    <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" autocomplete="tel" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('telefono')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="fecha_nacimiento" class="block text-xs font-semibold text-gray-600 mb-1">Fecha de Nacimiento (Opcional)</label>
                    <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('fecha_nacimiento')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-600 mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 mb-1">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password_confirmation')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div x-data="{ userType: '{{ old('tipo_usuario', 'cliente') }}', tipoDoc: '{{ old('tipo_documento_id') }}' }">
                    <label for="tipo_usuario" class="block text-xs font-semibold text-gray-600 mb-1">Tipo de Usuario</label>
                    <select id="tipo_usuario" name="tipo_usuario" x-model="userType" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="cliente">Cliente</option>
                        <option value="propietario">Propietario</option>
                    </select>
                    @error('tipo_usuario')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div x-show="userType === 'propietario'" class="mt-3">
                        <label for="tipo_documento_id" class="block text-xs font-semibold text-gray-600 mb-1">Tipo de Documento</label>
                        <select id="tipo_documento_id" name="tipo_documento_id" x-model="tipoDoc" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecciona un tipo</option>
                            @foreach($tiposDocumento as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_documento_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div x-show="userType === 'propietario'">
                        <label for="numero_documento" class="block text-xs font-semibold text-gray-600 mb-1">Número de Documento</label>
                        <input id="numero_documento" type="text" name="numero_documento" value="{{ old('numero_documento') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('numero_documento')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div x-show="userType === 'propietario' && tipoDoc == '2'" class="mt-3">
                        <label for="razon_social" class="block text-xs font-semibold text-gray-600 mb-1">Razón Social (solo para RUC)</label>
                        <input id="razon_social" type="text" name="razon_social" value="{{ old('razon_social') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('razon_social')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-3">
                        <label for="foto_perfil" class="block text-xs font-semibold text-gray-600 mb-1">Foto de Perfil Personal (Opcional)</label>
                        <input id="foto_perfil" type="file" name="foto_perfil" accept="image/*" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500" id="file_input_help">SVG, PNG, JPG o GIF (MAX. 2MB).</p>
                        @error('foto_perfil')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div x-show="userType === 'propietario'" class="mt-3">
                        <label for="logo_negocio" class="block text-xs font-semibold text-gray-600 mb-1">Logo del Negocio (Opcional)</label>
                        <input id="logo_negocio" type="file" name="logo_negocio" accept="image/*" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500" id="file_input_help_negocio">SVG, PNG, JPG o GIF (MAX. 2MB).</p>
                        @error('logo_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-2 rounded-lg font-semibold shadow transition-colors mt-2">Registrarse</button>
                <div class="text-center mt-2 text-xs text-gray-600">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
