<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display the cliente dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Verificar que el usuario sea cliente
        if ($user->tipo_usuario !== 'cliente') {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
        }

        return view('cliente.dashboard');
    }
}
