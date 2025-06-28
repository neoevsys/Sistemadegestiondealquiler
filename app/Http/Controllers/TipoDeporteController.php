<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipoDeporteController extends Controller
{
    public function index()
    {
        // Aquí puedes obtener los deportes desde la base de datos si lo deseas
        return view('tipos_deportes.index');
    }
}
