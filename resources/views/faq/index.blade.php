@extends('layouts.main')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-purple-600 pt-20 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Preguntas Frecuentes</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">Encuentra respuestas a las preguntas más comunes sobre nuestros servicios</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Buscador -->
    <div class="mb-12">
        <div class="relative max-w-md mx-auto">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="searchFaq" placeholder="Buscar preguntas..." class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    <!-- Categorías -->
    <div class="mb-8">
        <div class="flex flex-wrap justify-center gap-2 mb-8">
            <button onclick="filterCategory('all')" class="category-filter px-4 py-2 rounded-full bg-blue-600 text-white font-medium hover:bg-blue-700 transition-colors" data-category="all">
                Todas
            </button>
            @foreach($groupedFaqs as $category => $faqs)
                <button onclick="filterCategory('{{ $category }}')" class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition-colors" data-category="{{ $category }}">
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- FAQ Items -->
    <div class="space-y-4">
        @foreach($groupedFaqs as $category => $faqs)
            @foreach($faqs as $faq)
                <div class="faq-item bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-xl" data-category="{{ $category }}">
                    <button class="faq-question w-full px-6 py-4 text-left focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-inset" onclick="toggleFaq({{ $faq['id'] }})">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">{{ $category }}</span>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $faq['question'] }}</h3>
                            </div>
                            <svg class="faq-icon w-6 h-6 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div id="faq-{{ $faq['id'] }}" class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-out">
                        <div class="px-6 pb-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 leading-relaxed">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>

    <!-- Mensaje cuando no hay resultados -->
    <div id="noResults" class="text-center py-12 hidden">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.5-.935-6.072-2.455M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-600 mb-2">No se encontraron preguntas</h3>
        <p class="text-gray-500">Prueba con otros términos de búsqueda</p>
    </div>

    <!-- Contacto -->
    <div class="mt-16 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">¿No encontraste lo que buscabas?</h2>
        <p class="text-gray-600 mb-6">Nuestro equipo de soporte está aquí para ayudarte</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="mailto:soporte@ctmundial.com" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Enviar Email
            </a>
            <a href="tel:+51234567890" class="inline-flex items-center justify-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Llamar Ahora
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchFaq');
    const faqItems = document.querySelectorAll('.faq-item');
    const noResults = document.getElementById('noResults');
    const categoryFilters = document.querySelectorAll('.category-filter');

    // Función para filtrar por categoría
    window.filterCategory = function(category) {
        // Actualizar botones activos
        categoryFilters.forEach(btn => {
            if (btn.dataset.category === category) {
                btn.classList.remove('bg-gray-200', 'text-gray-700');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            }
        });

        // Filtrar items
        let visibleCount = 0;
        faqItems.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Mostrar/ocultar mensaje de no resultados
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        
        // Limpiar búsqueda
        searchInput.value = '';
    };

    // Función para toggle FAQ
    window.toggleFaq = function(id) {
        const answer = document.getElementById(`faq-${id}`);
        const icon = answer.previousElementSibling.querySelector('.faq-icon');
        
        if (answer.style.maxHeight && answer.style.maxHeight !== '0px') {
            answer.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
        } else {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        }
    };

    // Búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer p').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Mostrar/ocultar mensaje de no resultados
        noResults.style.display = visibleCount === 0 && searchTerm !== '' ? 'block' : 'none';
        
        // Resetear filtros de categoría si hay búsqueda
        if (searchTerm) {
            categoryFilters.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
        }
    });
});
</script>

@endsection
