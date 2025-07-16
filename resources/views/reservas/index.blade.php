@extends('layouts.main')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-blue-700 mb-6">Mis Reservas</h1>
            
            @if($reservas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($reservas as $reserva)
                        <div class="bg-white border rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            @if($reserva->instalacion->foto_principal)
                                @php
                                    $isUrl = Str::startsWith($reserva->instalacion->foto_principal, ['http://', 'https://']);
                                @endphp
                                <img src="{{ $isUrl ? $reserva->instalacion->foto_principal : asset('storage/' . $reserva->instalacion->foto_principal) }}" 
                                     alt="Foto de {{ $reserva->instalacion->nombre }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-lg text-gray-800">{{ $reserva->instalacion->nombre }}</h3>
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($reserva->estado_id == 2) bg-green-100 text-green-700
                                        @elseif($reserva->estado_id == 1) bg-yellow-100 text-yellow-700
                                        @elseif($reserva->estado_id == 3) bg-red-100 text-red-700
                                        @elseif($reserva->estado_id == 4) bg-blue-100 text-blue-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        @if($reserva->estado_id == 1) Pendiente
                                        @elseif($reserva->estado_id == 2) Confirmada
                                        @elseif($reserva->estado_id == 3) Cancelada
                                        @elseif($reserva->estado_id == 4) Completada
                                        @else Desconocido
                                        @endif
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 text-sm mb-3">{{ $reserva->instalacion->centroDeportivo->nombre }}</p>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</span>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</span>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        <span>{{ $reserva->duracion_horas }} {{ $reserva->duracion_horas == 1 ? 'hora' : 'horas' }}</span>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($reserva->instalacion->tiposDeporte as $deporte)
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ $deporte->nombre }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-lg font-bold text-gray-900">
                                        S/{{ number_format($reserva->precio_total, 2) }}
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        <a href="{{ route('reservas.show', $reserva->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs font-semibold transition-colors">
                                            Ver
                                        </a>
                                        
                                        @if($reserva->estado_id == 1)
                                            <form action="{{ route('reservas.cancel', $reserva->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs font-semibold transition-colors" onclick="return confirm('¿Estás seguro de que quieres cancelar esta reserva?')">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                        
                                        {{-- Las reservas se completan automáticamente cuando pasa la fecha/hora --}}
                                        
                                        @if($reserva->estado_id == 4)
                                            @php
                                                $evaluacionExistente = $reserva->evaluaciones()->where('usuario_id', Auth::id())->exists();
                                            @endphp
                                            @if(!$evaluacionExistente)
                                                <a href="{{ route('evaluaciones.create', $reserva) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-2 py-1 rounded text-xs font-semibold transition-colors">
                                                    Evaluar
                                                </a>
                                            @else
                                                <span class="bg-gray-300 text-gray-700 px-2 py-1 rounded text-xs font-semibold">
                                                    Evaluado
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $reservas->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No tienes reservas</h3>
                    <p class="text-gray-500 mb-6">Comienza explorando nuestros centros deportivos y haz tu primera reserva.</p>
                    <a href="{{ route('centros.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold transition-colors">
                        Explorar Centros
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
