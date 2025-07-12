@extends('layouts.main')
@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-blue-700 mb-2">{{ $centro->nombre }}</h1>
        <p class="text-gray-600 mb-4">{{ $centro->descripcion }}</p>
        <div class="flex flex-col md:flex-row gap-6 mb-6">
            @if($centro->fotos && is_array($centro->fotos) && count($centro->fotos) > 0)
                @php
                    $foto = $centro->fotos[0];
                    $isUrl = Str::startsWith($foto, ['http://', 'https://']);
                @endphp
                <img src="{{ $isUrl ? $foto : asset('storage/' . $foto) }}" alt="Foto Centro" class="w-full md:w-80 h-56 object-cover rounded">
            @endif
            <div class="flex-1">
                <div class="mb-2"><span class="font-semibold">Dirección:</span> {{ $centro->direccion }}</div>
                <div class="mb-2"><span class="font-semibold">Departamento:</span> {{ $centro->departamento->nombre ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Provincia:</span> {{ $centro->provincia->nombre ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Distrito:</span> {{ $centro->distrito->nombre ?? '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Teléfono:</span> {{ $centro->telefono }}</div>
                <div class="mb-2"><span class="font-semibold">Email:</span> {{ $centro->email }}</div>
                <div class="mb-2"><span class="font-semibold">Calificación:</span> {{ $centro->calificacion_promedio ?? 'N/A' }}</div>
            </div>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mt-8 mb-4">Instalaciones</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($centro->instalaciones as $instalacion)
                <div class="bg-gray-50 rounded-lg p-4 shadow">
                    <div class="font-semibold text-blue-600 mb-1">{{ $instalacion->nombre }}</div>
                    <div class="text-sm text-gray-700 mb-1">{{ $instalacion->descripcion }}</div>
                    <div class="text-xs text-gray-500 mb-1">Deporte: {{ $instalacion->tipoDeporte->nombre ?? 'N/A' }}</div>
                    <div class="text-xs text-gray-500 mb-1">Precio: {{ $instalacion->precio_por_hora }} €/hora</div>
                </div>
            @empty
                <div class="col-span-2 text-gray-400">No hay instalaciones registradas.</div>
            @endforelse
        </div>
        <a href="{{ route('centros.index') }}" class="inline-block mt-8 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Volver al listado</a>
    </div>
</div>
@endsection
