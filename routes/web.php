<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación generadas por Breeze (login, register, etc.)
require __DIR__ . '/auth.php';
// Esta será tu página de inicio unificada
Route::get('/', function () {
    return view('welcome'); // O el nombre de tu vista de inicio, por ejemplo 'home'
})->name('home'); // Dale un nombre a la ruta para referenciarla fácilmente

// Ruta del dashboard general (por defecto de Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// --- Nuevas rutas para dashboards específicos de rol ---
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard para clientes
    Route::get('/cliente/dashboard', function () {
        // Aquí puedes cargar una vista específica para clientes
        return view('cliente.dashboard');
    })->name('cliente.dashboard');
    // Dashboard para propietarios
    Route::get('/propietario/dashboard', function () {
        // Aquí puedes cargar una vista específica para propietarios
        return view('propietario.dashboard');
    })->name('propietario.dashboard');
    // Rutas de perfil (generadas por Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
