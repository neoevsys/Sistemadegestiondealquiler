@extends('layouts.main')
@section('content')
<div class="bg-gradient-to-r from-purple-600 to-blue-600 pt-20 pb-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">¡Conviértete en Propietario!</h1>
        <p class="text-purple-100 text-lg mb-4">Publica tus centros deportivos, gestiona reservas y accede a herramientas exclusivas para propietarios.</p>
    </div>
</div>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col gap-8">
        <div class="text-center">
            <h2 class="text-xl font-bold text-purple-700 mb-2">Beneficios de ser propietario</h2>
            <ul class="text-gray-700 text-left list-disc list-inside mx-auto max-w-md mb-6">
                <li>Publica y promociona tus centros deportivos fácilmente.</li>
                <li>Gestiona reservas y disponibilidad en tiempo real.</li>
                <li>Accede a estadísticas y reportes de tus instalaciones.</li>
                <li>Incrementa tus ingresos y visibilidad en la plataforma.</li>
                <li>Soporte prioritario y herramientas exclusivas.</li>
            </ul>
        </div>
        <form method="POST" action="{{ route('propietario.solicitar.enviar') }}" class="space-y-6">
            @csrf
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Completa tus datos para ser propietario</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ Auth::user()->nombre }}" class="w-full border-gray-300 rounded-lg" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                    <input type="text" name="apellido" value="{{ Auth::user()->apellido }}" class="w-full border-gray-300 rounded-lg" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full border-gray-300 rounded-lg" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="telefono" value="{{ Auth::user()->telefono }}" class="w-full border-gray-300 rounded-lg">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">¿Por qué quieres ser propietario?</label>
                <textarea name="motivo" rows="3" class="w-full border-gray-300 rounded-lg" placeholder="Cuéntanos brevemente..."></textarea>
            </div>
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-semibold transition-colors">Enviar Solicitud</button>
        </form>
    </div>
</div>
@endsection
