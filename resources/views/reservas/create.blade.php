@extends('layouts.main')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-blue-700 mb-6">Crear Reserva</h1>
            
            <!-- Información de la instalación -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-6">
                    @if($instalacion->fotos && is_array($instalacion->fotos) && count($instalacion->fotos) > 0)
                        @php
                            $foto = $instalacion->fotos[0];
                            $isUrl = Str::startsWith($foto, ['http://', 'https://']);
                        @endphp
                        <img src="{{ $isUrl ? $foto : asset('storage/' . $foto) }}" alt="Foto Instalación" class="w-full md:w-80 h-48 object-cover rounded">
                    @endif
                    
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $instalacion->nombre }}</h2>
                        <p class="text-gray-600 mb-2">{{ $instalacion->descripcion }}</p>
                        <div class="text-sm text-gray-500 mb-2">
                            <strong>Centro:</strong> {{ $instalacion->centroDeportivo->nombre }}
                        </div>
                        <div class="text-sm text-gray-500 mb-2">
                            <strong>Capacidad:</strong> {{ $instalacion->capacidad_maxima }} personas
                        </div>
                        <div class="text-sm text-gray-500 mb-2">
                            <strong>Dimensiones:</strong> {{ $instalacion->dimensiones }} - {{ $instalacion->superficie }}
                        </div>
                        <div class="flex flex-wrap gap-1 mb-2">
                            @foreach($instalacion->tiposDeporte as $deporte)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{{ $deporte->nombre }}</span>
                            @endforeach
                        </div>
                        <div class="text-lg font-bold text-blue-600">
                            S/{{ number_format($instalacion->precio_por_hora, 2) }} por hora
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de reserva -->
            <form method="POST" action="{{ route('reservas.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="instalacion_id" value="{{ $instalacion->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="fecha_reserva" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Reserva</label>
                        <select name="fecha_reserva" id="fecha_reserva" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecciona una fecha</option>
                            @foreach($fechasDisponibles as $fecha => $fechaFormateada)
                                <option value="{{ $fecha }}" {{ old('fecha_reserva') == $fecha ? 'selected' : '' }}>
                                    {{ $fechaFormateada }}
                                </option>
                            @endforeach
                        </select>
                        @error('fecha_reserva')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="hora_inicio" class="block text-sm font-medium text-gray-700 mb-2">Hora de Inicio</label>
                        <select name="hora_inicio" id="hora_inicio" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecciona una hora</option>
                        </select>
                        @error('hora_inicio')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="duracion_horas" class="block text-sm font-medium text-gray-700 mb-2">Duración (horas)</label>
                        <select name="duracion_horas" id="duracion_horas" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecciona duración</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ old('duracion_horas') == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i == 1 ? 'hora' : 'horas' }}
                                </option>
                            @endfor
                        </select>
                        @error('duracion_horas')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Precio Total</label>
                        <div id="precio_total" class="text-2xl font-bold text-blue-600 py-2">
                            S/0.00
                        </div>
                    </div>
                </div>

                <div>
                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">Observaciones (Opcional)</label>
                    <textarea name="observaciones" id="observaciones" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('centros.show', $instalacion->centroDeportivo->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-semibold transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold transition-colors">
                        Crear Reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fechaSelect = document.getElementById('fecha_reserva');
    const horaSelect = document.getElementById('hora_inicio');
    const duracionSelect = document.getElementById('duracion_horas');
    const precioTotal = document.getElementById('precio_total');
    const precioPorHora = {{ $instalacion->precio_por_hora }};
    
    fechaSelect.addEventListener('change', function() {
        if (this.value) {
            cargarHorarios(this.value);
        } else {
            horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';
        }
    });
    
    duracionSelect.addEventListener('change', calcularPrecioTotal);
    
    function cargarHorarios(fecha) {
        fetch(`{{ route('reservas.horarios') }}?instalacion_id={{ $instalacion->id }}&fecha=${fecha}`)
            .then(response => response.json())
            .then(horarios => {
                horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';
                horarios.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora;
                    option.textContent = hora;
                    horaSelect.appendChild(option);
                });
            });
    }
    
    function calcularPrecioTotal() {
        const duracion = parseInt(duracionSelect.value) || 0;
        const total = precioPorHora * duracion;
        precioTotal.textContent = `S/${total.toFixed(2)}`;
    }
});
</script>
@endsection
