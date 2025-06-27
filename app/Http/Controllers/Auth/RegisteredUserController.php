<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Propietario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'apellido' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['nullable', 'string', 'max:20'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'tipo_usuario' => ['required', 'in:cliente,propietario'],
            'ruc_dni' => ['nullable', 'string', 'max:20', 'unique:usuarios,ruc_dni', 'required_if:tipo_usuario,propietario'],
            // Validación para la foto_perfil: opcional para todos
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            // Validación para el logo_negocio: opcional para propietarios, no requerido en el registro
            'logo_negocio' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $fotoPerfilPath = null;
        // Lógica para guardar la foto de perfil personal (si se subió)
        if ($request->hasFile('foto_perfil')) {
            $fotoPerfilPath = $request->file('foto_perfil')->store('fotos_perfil', 'public');
        }

        // Crear el usuario en la tabla 'usuarios' con todos los datos personales y la foto de perfil
        $user = User::create([
            'nombre' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'ruc_dni' => $request->ruc_dni,
            'tipo_usuario' => $request->tipo_usuario,
            'estado' => 'activo',
            'fecha_registro' => now(),
            'foto_perfil' => $fotoPerfilPath, // Guardar la ruta de la foto de perfil personal
        ]);

        // Si el usuario es un propietario, crear un registro en la tabla 'propietarios'
        if ($user->tipo_usuario === 'propietario') {
            $logoNegocioPath = null;
            // Lógica para guardar el logo del negocio (solo si se subió uno en el registro)
            if ($request->hasFile('logo_negocio')) {
                $logoNegocioPath = $request->file('logo_negocio')->store('logos_negocio', 'public');
            }

            Propietario::create([
                'id_propietario' => $user->id_usuario,
                'estado' => 'pendiente',
                'logo_negocio' => $logoNegocioPath, // Guardar la ruta del logo del negocio (puede ser null)
                // Otros campos de negocio si los añadiste en la migración, también serían null aquí
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($user->tipo_usuario === 'propietario') {
            return redirect()->intended(route('home'))->with('status', 'Registro de propietario exitoso. Su cuenta está pendiente de aprobación.');
        } elseif ($user->tipo_usuario === 'cliente') {
            return redirect()->intended(route('home'))->with('status', 'Registro de cliente exitoso.');
        }

        return redirect()->intended(route('home')); // Redirección por defecto si no coincide con los anteriores

    }
}
