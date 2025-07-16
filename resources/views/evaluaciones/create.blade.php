@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Evaluar Reserva</h1>
                <p class="mt-2 text-gray-600">Comparte tu experiencia para ayudar a otros usuarios</p>
            </div>

            <!-- Detalles de la reserva -->
            <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles de la Reserva</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Centro Deportivo</p>
                        <p class="font-medium">{{ $reserva->instalacion->centroDeportivo->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Instalación</p>
                        <p class="font-medium">{{ $reserva->instalacion->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fecha</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Horario</p>
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Duración</p>
                        <p class="font-medium">{{ $reserva->duracion_horas }} hora(s)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pagado</p>
                        <p class="font-medium">S/. {{ number_format($reserva->precio_total, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Formulario de evaluación -->
            <form method="POST" action="{{ route('evaluaciones.store', $reserva) }}">
                @csrf
                
                <!-- Calificación -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Calificación <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-2">
                        <div class="flex" id="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" 
                                        class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition-colors"
                                        data-rating="{{ $i }}">
                                    ★
                                </button>
                            @endfor
                        </div>
                        <span id="rating-text" class="text-sm text-gray-500 ml-3">Selecciona una calificación</span>
                    </div>
                    <input type="hidden" name="calificacion" id="calificacion" value="">
                    @error('calificacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comentario -->
                <div class="mb-6">
                    <label for="comentario" class="block text-sm font-medium text-gray-700 mb-2">
                        Comentario (opcional)
                    </label>
                    <textarea name="comentario" id="comentario" rows="4" 
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Comparte tu experiencia: ¿Qué te gustó? ¿Qué se podría mejorar?">{{ old('comentario') }}</textarea>
                    @error('comentario')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Máximo 1000 caracteres</p>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('reservas.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200"
                            id="submit-btn" disabled>
                        Enviar Evaluación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-btn');
    const calificacionInput = document.getElementById('calificacion');
    const ratingText = document.getElementById('rating-text');
    const submitBtn = document.getElementById('submit-btn');
    
    const ratingTexts = {
        1: 'Muy malo',
        2: 'Malo',
        3: 'Regular',
        4: 'Bueno',
        5: 'Excelente'
    };
    
    let currentRating = 0;
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            currentRating = parseInt(this.dataset.rating);
            updateStars();
            calificacionInput.value = currentRating;
            ratingText.textContent = ratingTexts[currentRating];
            submitBtn.disabled = false;
        });
        
        star.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.dataset.rating);
            highlightStars(hoverRating);
        });
    });
    
    document.getElementById('rating-stars').addEventListener('mouseleave', function() {
        updateStars();
    });
    
    function updateStars() {
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }
    
    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }
});
</script>
@endsection
