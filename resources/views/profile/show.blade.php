@extends('layouts.main')
@section('content')
<div class="bg-gradient-to-r from-blue-600 to-purple-600 pt-20 pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow">Mi Perfil</h1>
        <p class="text-blue-100 text-xl mb-4 font-medium">Gestiona tu información personal y accede a beneficios exclusivos</p>
    </div>
</div>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col md:flex-row gap-10 items-center md:items-start">
        <div class="flex flex-col items-center md:w-1/3">
            @if(Auth::user()->foto_perfil)
                <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Foto de perfil" class="w-48 h-48 rounded-full object-cover border-8 border-blue-500 shadow-lg mb-6">
            @else
                <div class="w-48 h-48 rounded-full bg-blue-100 flex items-center justify-center text-7xl text-blue-400 mb-6 border-8 border-blue-200 shadow-lg">
                    <span>{{ strtoupper(substr(Auth::user()->nombre,0,1)) }}</span>
                </div>
            @endif
            <div class="text-2xl font-bold text-gray-800 mb-1">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</div>
            <div class="text-gray-500 text-base mb-2">{{ Auth::user()->email }}</div>
            <div class="flex flex-col gap-3 w-full mt-6">
                <a href="{{ route('profile.edit') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition-colors text-center shadow">Editar Perfil</a>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-semibold transition-colors shadow">Eliminar Usuario</button>
                </form>
            </div>
        </div>
        <div class="flex-1 flex flex-col gap-6 justify-center w-full">
            <div class="bg-blue-50 rounded-2xl p-6 shadow">
                <div class="font-semibold text-blue-700 mb-2 text-lg flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Datos Personales
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 text-base">
                    <div><span class="font-medium">Nombre:</span> {{ Auth::user()->nombre }}</div>
                    <div><span class="font-medium">Apellido:</span> {{ Auth::user()->apellido }}</div>
                    <div><span class="font-medium">Email:</span> {{ Auth::user()->email }}</div>
                    <div><span class="font-medium">Teléfono:</span> {{ Auth::user()->telefono ?? 'No registrado' }}</div>
                    <div><span class="font-medium">Fecha de Nacimiento:</span> {{ Auth::user()->fecha_nacimiento ? Auth::user()->fecha_nacimiento->format('d/m/Y') : 'No registrada' }}</div>
                    <div><span class="font-medium">Tipo de Usuario:</span> {{ ucfirst(Auth::user()->tipo_usuario) }}</div>
                </div>
            </div>
            @if(Auth::user()->tipo_usuario !== 'propietario')
            <div class="bg-purple-50 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow">
                <div>
                    <div class="font-semibold text-purple-700 mb-1 text-lg">¿Quieres ser propietario?</div>
                    <div class="text-gray-700 text-base mb-2">Accede a beneficios como publicar tus centros deportivos, gestionar reservas y aumentar tus ingresos.</div>
                </div>
                <a href="{{ route('propietario.solicitar') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors shadow">Convertirme en Propietario</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
