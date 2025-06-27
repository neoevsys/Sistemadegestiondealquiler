@extends('layouts.main')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Dashboard del Propietario') }}
                    </h2>
                    <p class="text-xl font-semibold text-indigo-600">¡Hola, {{ Auth::user()->nombre }}!</p>
                    <p>{{ __('¡Bienvenido! Aquí podrás gestionar tus centros e instalaciones.') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
