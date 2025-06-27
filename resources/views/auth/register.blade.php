@extends('layouts.main')

@section('content')
    <x-guest-layout>
        {{-- Importante: Para subir archivos, el formulario debe tener enctype="multipart/form-data" --}}
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nombre -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Apellido -->
            <div class="mt-4">
                <x-input-label for="apellido" :value="__('Apellido (Opcional)')" />
                <x-text-input id="apellido" class="block mt-1 w-full" type="text" name="apellido" :value="old('apellido')"
                    autocomplete="family-name" />
                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Teléfono -->
            <div class="mt-4">
                <x-input-label for="telefono" :value="__('Teléfono (Opcional)')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')"
                    autocomplete="tel" />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="mt-4">
                <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento (Opcional)')" />
                <x-text-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento"
                    :value="old('fecha_nacimiento')" />
                <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Tipo de Usuario (Modificado con Alpine.js) -->
            <div class="mt-4" x-data="{ userType: '{{ old('tipo_usuario', 'cliente') }}' }">
                <x-input-label for="tipo_usuario" :value="__('Tipo de Usuario')" />
                <select id="tipo_usuario" name="tipo_usuario"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    x-model="userType" required>
                    <option value="cliente">Cliente</option>
                    <option value="propietario">Propietario</option>
                </select>
                <x-input-error :messages="$errors->get('tipo_usuario')" class="mt-2" />

                <!-- Campo RUC/DNI (Condicional) -->
                <div x-show="userType === 'propietario'" class="mt-4">
                    <x-input-label for="ruc_dni" :value="__('RUC / DNI (Requerido para Propietarios)')" />
                    <x-text-input id="ruc_dni" class="block mt-1 w-full" type="text" name="ruc_dni"
                        :value="old('ruc_dni')" />
                    <x-input-error :messages="$errors->get('ruc_dni')" class="mt-2" />
                </div>

                <!-- Campo Foto de Perfil Personal (Opcional para todos) -->
                <div class="mt-4">
                    <x-input-label for="foto_perfil" :value="__('Foto de Perfil Personal (Opcional)')" />
                    <input id="foto_perfil"
                        class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        type="file" name="foto_perfil" accept="image/*" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
                        2MB).</p>
                    <x-input-error :messages="$errors->get('foto_perfil')" class="mt-2" />
                </div>

                <!-- Campo Logo de Negocio (Condicional para Propietarios, Opcional) -->
                <div x-show="userType === 'propietario'" class="mt-4">
                    <x-input-label for="logo_negocio" :value="__('Logo del Negocio (Opcional)')" />
                    <input id="logo_negocio"
                        class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        type="file" name="logo_negocio" accept="image/*" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help_negocio">SVG, PNG, JPG or
                        GIF (MAX. 2MB).</p>
                    <x-input-error :messages="$errors->get('logo_negocio')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('¿Ya estás registrado?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
@endsection
