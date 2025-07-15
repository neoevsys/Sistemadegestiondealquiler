<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the user's reservations.
     */
    public function index()
    {
        // Aquí puedes obtener las reservas del usuario autenticado
        $reservas = auth()->user()->reservas;
        return view('reservas.index');
    }
}