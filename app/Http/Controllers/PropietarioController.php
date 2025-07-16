<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PropietarioController extends Controller
{
    /**
     * Display the propietario dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Verificar que el usuario sea propietario (tipo_usuario_id = 3)
        if ($user->tipo_usuario_id !== 3) {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
        }

        return view('propietario.dashboard');
    }

    /**
     * Mostrar la página para solicitar ser propietario.
     */
    public function solicitar()
    {
        return view('propietario.solicitar');
    }

    /**
     * Procesar la solicitud para convertirse en propietario.
     */
    public function solicitarEnviar(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'telefono' => 'nullable|string|max:30',
            'motivo' => 'nullable|string|max:500',
        ]);
        
        // Actualizar información del usuario
        if ($request->filled('telefono')) {
            $user->telefono = $request->telefono;
        }
        
        // Cambiar tipo de usuario a propietario (3 = propietario)
        $user->tipo_usuario_id = 3;
        $user->save();
        
        // Crear registro de propietario si no existe
        if (!$user->propietario) {
            \App\Models\Propietario::create([
                'usuario_id' => $user->id,
                'estado_id' => 1, // 1 = aprobado
            ]);
        }
        
        return redirect()->route('propietario.dashboard')->with('success', '¡Ahora eres propietario!');
    }
}
