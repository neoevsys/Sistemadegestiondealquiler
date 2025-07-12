<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstalacionController extends Controller
{
    public function index()
    {
        // Aquí puedes obtener las instalaciones desde la base de datos si lo deseas
        return view('instalaciones.index');
    }
}
