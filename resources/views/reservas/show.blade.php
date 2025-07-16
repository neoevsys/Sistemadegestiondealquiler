@extends('layouts.main')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-blue-700">Detalle de Reserva</h1>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Información de la instalación -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Instalación</h2>
                    
                    @if($reserva->instalacion->foto_principal)
                        @php
                            $isUrl = Str::startsWith($reserva->instalacion->foto_principal, ['http://', 'https://']);
                        @endphp
                        <img src="{{ $isUrl ? $reserva->instalacion->foto_principal : asset('storage/' . $reserva->instalacion->foto_principal) }}" 
                             alt="Foto de {{ $reserva->instalacion->nombre }}" 
                             class="w-full h-48 object-cover rounded mb-4">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400 rounded mb-4">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <h3 class="font-bold text-lg text-blue-600 mb-2">{{ $reserva->instalacion->nombre }}</h3>
                    <p class="text-gray-600 mb-2">{{ $reserva->instalacion->descripcion }}</p>
                    
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span><strong>Centro:</strong> {{ $reserva->instalacion->centroDeportivo->nombre }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span><strong>Capacidad:</strong> {{ $reserva->instalacion->capacidad_maxima }} personas</span>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span><strong>Dimensiones:</strong> {{ $reserva->instalacion->dimensiones }} - {{ $reserva->instalacion->superficie }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($reserva->instalacion->tiposDeporte as $deporte)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ $deporte->nombre }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Detalles de la reserva -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detalles de la Reserva</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-800">Fecha</p>
                                <p class="text-gray-600">{{ Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-green-50 rounded-lg">
                            <svg class="w-8 h-8 text-green-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-800">Horario</p>
                                <p class="text-gray-600">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                            <svg class="w-8 h-8 text-purple-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-800">Duración</p>
                                <p class="text-gray-600">{{ $reserva->duracion_horas }} {{ $reserva->duracion_horas == 1 ? 'hora' : 'horas' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                            <svg class="w-8 h-8 text-yellow-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-800">Precio Total</p>
                                <p class="text-2xl font-bold text-gray-900">S/{{ number_format($reserva->precio_total, 2) }}</p>
                            </div>
                        </div>
                        
                        @if($reserva->observaciones)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="font-semibold text-gray-800 mb-2">Observaciones</p>
                                <p class="text-gray-600">{{ $reserva->observaciones }}</p>
                            </div>
                        @endif
                        
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="font-semibold text-gray-800 mb-2">Fecha de Creación</p>
                            <p class="text-gray-600">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ route('reservas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-semibold transition-colors">
                    Volver a Mis Reservas
                </a>
                
                <div class="flex space-x-4">
                    @php
                        $tienePago = $reserva->pago && $reserva->pago->estado_id == 1;
                    @endphp
                    
                    @if($reserva->estado_id == 1)
                        <!-- Reserva pendiente - mostrar pago y cancelar -->
                        @if(!$tienePago)
                            <a href="{{ route('pagos.form', $reserva->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-semibold transition-colors">
                                Pagar Reserva
                            </a>
                        @endif
                        
                        <form action="{{ route('reservas.cancel', $reserva->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-semibold transition-colors" onclick="return confirm('¿Estás seguro de que quieres cancelar esta reserva?')">
                                Cancelar Reserva
                            </button>
                        </form>
                    @elseif($reserva->estado_id == 2)
                        <!-- Reserva confirmada - solo mostrar estado de pago -->
                        @if($tienePago)
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-md font-semibold">
                                ✓ Pagado
                            </span>
                        @endif
                        
                        <div class="text-sm text-gray-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Reserva confirmada - No se puede cancelar
                        </div>
                    @elseif($reserva->estado_id == 3)
                        <!-- Reserva cancelada -->
                        <span class="bg-red-100 text-red-800 px-4 py-2 rounded-md font-semibold">
                            ✗ Cancelada
                        </span>
                    @elseif($reserva->estado_id == 4)
                        <!-- Reserva completada -->
                        <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-md font-semibold">
                            ✓ Completada
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
