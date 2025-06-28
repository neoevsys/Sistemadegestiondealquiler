@extends('layouts.main')
@section('content')
<div class="bg-gradient-to-r from-blue-600 to-purple-600 pt-20 pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow">Editar Perfil</h1>
        <p class="text-blue-100 text-xl mb-4 font-medium">Actualiza tu información personal y mantén tu cuenta al día</p>
    </div>
</div>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col gap-10 items-center">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full max-w-2xl space-y-6">
            @csrf
            @method('patch')
            @if(session('status') === 'profile-updated')
                <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-800 text-center font-semibold shadow">
                    ¡Perfil actualizado correctamente!
                </div>
            @endif
            <div class="flex flex-col items-center gap-4 mb-6">
                @if(Auth::user()->foto_perfil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Foto de perfil" class="w-40 h-40 rounded-full object-cover border-8 border-blue-500 shadow-lg">
                @else
                    <div class="w-40 h-40 rounded-full bg-blue-100 flex items-center justify-center text-6xl text-blue-400 border-8 border-blue-200 shadow-lg">
                        <span>{{ strtoupper(substr(Auth::user()->nombre,0,1)) }}</span>
                    </div>
                @endif
                <label for="foto_perfil" class="block text-sm font-semibold text-blue-700 cursor-pointer hover:underline">Cambiar foto de perfil</label>
                <input id="foto_perfil" name="foto_perfil" type="file" accept="image/*" class="hidden">
                @error('foto_perfil')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                    <input id="nombre" name="nombre" type="text" value="{{ old('nombre', Auth::user()->nombre) }}" required class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('nombre')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-1">Apellido</label>
                    <input id="apellido" name="apellido" type="text" value="{{ old('apellido', Auth::user()->apellido) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('apellido')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                    <input id="telefono" name="telefono" type="text" value="{{ old('telefono', Auth::user()->telefono) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('telefono')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Nacimiento</label>
                    <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" value="{{ old('fecha_nacimiento', Auth::user()->fecha_nacimiento ? Auth::user()->fecha_nacimiento->format('Y-m-d') : '') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('fecha_nacimiento')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="ruc_dni" class="block text-sm font-semibold text-gray-700 mb-1">RUC / DNI</label>
                    <input id="ruc_dni" name="ruc_dni" type="text" value="{{ old('ruc_dni', Auth::user()->ruc_dni) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" @if(Auth::user()->tipo_usuario !== 'propietario') readonly onclick="this.removeAttribute('readonly');this.blur();" @endif>
                    @error('ruc_dni')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            @if(Auth::user()->tipo_usuario === 'propietario' && Auth::user()->propietario)
            <div class="mt-8 p-6 bg-purple-50 rounded-2xl shadow w-full">
                <div class="text-lg font-bold text-purple-700 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01.88 7.903A4.992 4.992 0 0112 21a4.992 4.992 0 01-4.88-6.097A4 4 0 118 7h8z" /></svg>
                    Datos del Negocio
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre_negocio" class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Negocio</label>
                        <input id="nombre_negocio" name="nombre_negocio" type="text" value="{{ old('nombre_negocio', Auth::user()->propietario->nombre_negocio ?? '') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('nombre_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="telefono_negocio" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono del Negocio</label>
                        <input id="telefono_negocio" name="telefono_negocio" type="text" value="{{ old('telefono_negocio', Auth::user()->propietario->telefono_negocio ?? '') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('telefono_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="email_negocio" class="block text-sm font-semibold text-gray-700 mb-1">Correo del Negocio</label>
                        <input id="email_negocio" name="email_negocio" type="email" value="{{ old('email_negocio', Auth::user()->propietario->email_negocio ?? '') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('email_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="direccion_negocio" class="block text-sm font-semibold text-gray-700 mb-1">Dirección del Negocio</label>
                        <input id="direccion_negocio" name="direccion_negocio" type="text" value="{{ old('direccion_negocio', Auth::user()->propietario->direccion_negocio ?? '') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('direccion_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="descripcion_negocio" class="block text-sm font-semibold text-gray-700 mb-1">Descripción del Negocio</label>
                        <textarea id="descripcion_negocio" name="descripcion_negocio" rows="3" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('descripcion_negocio', Auth::user()->propietario->descripcion_negocio ?? '') }}</textarea>
                        @error('descripcion_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="logo_negocio" class="block text-sm font-semibold text-gray-700 mb-1">Logo del Negocio</label>
                        @if(Auth::user()->propietario->logo_negocio)
                            <img src="{{ asset('storage/' . Auth::user()->propietario->logo_negocio) }}" alt="Logo del negocio" class="w-24 h-24 object-contain rounded-xl border-4 border-purple-300 mb-2">
                        @endif
                        <input id="logo_negocio" name="logo_negocio" type="file" accept="image/*" class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('logo_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            @endif
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('profile.show') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-semibold transition-colors shadow">Cancelar</a>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-xl font-bold shadow hover:from-blue-700 hover:to-purple-700 transition-colors">Guardar Cambios</button>
            </div>
        </form>
        <div class="w-full max-w-2xl mt-10">
            @include('profile.partials.update-password-form')
        </div>
        <div class="w-full max-w-2xl mt-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
