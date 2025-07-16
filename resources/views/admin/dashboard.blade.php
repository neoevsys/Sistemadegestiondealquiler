@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
                    <p class="mt-1 text-sm text-gray-600">Bienvenido, {{ Auth::user()->nombre }}</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.reportes.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                        📊 Reportes
                    </a>
                    <form action="{{ route('admin.comandos.ejecutar') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="comando" value="gestionar-estados">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                            🔄 Gestionar Estados
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Navegación rápida -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-8">
            <a href="{{ route('admin.usuarios.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">👥</div>
                <div class="text-sm font-medium text-gray-900">Usuarios</div>
            </a>
            <a href="{{ route('admin.propietarios.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">🏢</div>
                <div class="text-sm font-medium text-gray-900">Propietarios</div>
            </a>
            <a href="{{ route('admin.centros.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">🏟️</div>
                <div class="text-sm font-medium text-gray-900">Centros</div>
            </a>
            <a href="{{ route('admin.instalaciones.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">🏒</div>
                <div class="text-sm font-medium text-gray-900">Instalaciones</div>
            </a>
            <a href="{{ route('admin.reservas.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">📅</div>
                <div class="text-sm font-medium text-gray-900">Reservas</div>
            </a>
            <a href="{{ route('admin.pagos.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">💳</div>
                <div class="text-sm font-medium text-gray-900">Pagos</div>
            </a>
            <a href="{{ route('admin.reportes.index') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">📊</div>
                <div class="text-sm font-medium text-gray-900">Reportes</div>
            </a>
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-center">
                <div class="text-2xl mb-2">⚙️</div>
                <div class="text-sm font-medium text-gray-900">Sistema</div>
            </div>
        </div>

        <!-- Estadísticas principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Total Usuarios</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total_usuarios'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="text-green-600">{{ $estadisticas_estados['usuarios_activos'] }}</span>
                        <span class="mx-2">activos</span>
                        <span class="text-red-600">{{ $estadisticas_estados['usuarios_inactivos'] }}</span>
                        <span class="ml-2">inactivos</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-5 0H3m2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Centros Deportivos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total_centros'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="text-green-600">{{ $estadisticas_estados['centros_activos'] }}</span>
                        <span class="mx-2">activos</span>
                        <span class="text-red-600">{{ $estadisticas_estados['centros_inactivos'] }}</span>
                        <span class="ml-2">inactivos</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Total Reservas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $estadisticas['total_reservas'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="text-yellow-600">{{ $estadisticas_estados['reservas_pendientes'] }}</span>
                        <span class="mx-2">pendientes</span>
                        <span class="text-green-600">{{ $estadisticas_estados['reservas_completadas'] }}</span>
                        <span class="ml-2">completadas</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-medium text-gray-500">Ingresos Mes</p>
                        <p class="text-2xl font-bold text-gray-900">S/{{ number_format($estadisticas['ingresos_mes'], 2) }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <span class="text-green-600">{{ $estadisticas['total_pagos'] }}</span>
                        <span class="ml-2">pagos exitosos</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actividad reciente -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Reservas recientes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Reservas Recientes</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($actividad_reciente['reservas_recientes'] as $reserva)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-600">{{ substr($reserva->usuario->nombre, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $reserva->usuario->nombre }}</p>
                                    <p class="text-sm text-gray-500">{{ $reserva->instalacion->nombre }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ $reserva->fecha_reserva }}</p>
                                <p class="text-sm text-gray-500">{{ $reserva->hora_inicio }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pagos recientes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Pagos Recientes</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($actividad_reciente['pagos_recientes'] as $pago)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-green-600">S/</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $pago->reserva->usuario->nombre }}</p>
                                    <p class="text-sm text-gray-500">{{ $pago->reserva->instalacion->nombre }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">S/{{ number_format($pago->monto, 2) }}</p>
                                <p class="text-sm text-gray-500">{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Comandos del sistema -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Comandos del Sistema</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <form action="{{ route('admin.comandos.ejecutar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="comando" value="gestionar-estados">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                            🔄 Gestionar Estados de Reservas
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.comandos.ejecutar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="comando" value="cache-clear">
                        <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                            🧹 Limpiar Cache
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.comandos.ejecutar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="comando" value="config-cache">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-200">
                            ⚡ Optimizar Sistema
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
