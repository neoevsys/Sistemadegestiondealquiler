<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Propietario;
use App\Models\TipoDocumento;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $tiposDocumento = TipoDocumento::all();
        return view('auth.register', compact('tiposDocumento'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validationRules = [
            'name' => ['required', 'string', 'max:100'],
            'apellido' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['nullable', 'string', 'max:20'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'tipo_usuario' => ['required', 'in:cliente,propietario'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        // Validaciones condicionales para propietarios
        if ($request->tipo_usuario === 'propietario') {
            $validationRules['tipo_documento_id'] = ['required', 'exists:tipos_documento,id'];
            $validationRules['numero_documento'] = ['required', 'string', 'max:20', 'unique:usuarios,numero_documento,NULL,id,numero_documento,NULL'];
            $validationRules['razon_social'] = ['nullable', 'string', 'max:200'];
            $validationRules['logo_negocio'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
        }

        $request->validate($validationRules);

        $fotoPerfilPath = null;
        // Lógica para guardar la foto de perfil personal (si se subió)
        if ($request->hasFile('foto_perfil')) {
            $fotoPerfilPath = $request->file('foto_perfil')->store('fotos_perfil', 'public');
        }

        // Obtener el ID del tipo de usuario
        $tipoUsuarioId = DB::table('tipos_usuario')->where('nombre', $request->tipo_usuario)->value('id');
        // Estado activo por defecto
        $estadoId = DB::table('estados_usuario')->where('nombre', 'activo')->value('id');

        // Preparar datos del usuario
        $userData = [
            'nombre' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_usuario_id' => $tipoUsuarioId,
            'estado_id' => $estadoId,
            'fecha_registro' => now(),
            'foto_perfil' => $fotoPerfilPath,
        ];

        // Agregar datos específicos para propietarios
        if ($request->tipo_usuario === 'propietario') {
            $userData['tipo_documento_id'] = $request->tipo_documento_id;
            $userData['numero_documento'] = $request->numero_documento;
            $userData['razon_social'] = $request->razon_social;
        }

        // Crear el usuario en la tabla 'usuarios'
        $user = User::create($userData);

        // Si el usuario es un propietario, crear un registro en la tabla 'propietarios'
        if ($request->tipo_usuario === 'propietario') {
            $logoNegocioPath = null;
            // Lógica para guardar el logo del negocio (solo si se subió uno en el registro)
            if ($request->hasFile('logo_negocio')) {
                $logoNegocioPath = $request->file('logo_negocio')->store('logos_negocio', 'public');
            }

            Propietario::create([
                'usuario_id' => $user->id,
                'estado_id' => 1, // pendiente o aprobado según lógica
                'logo_negocio' => $logoNegocioPath, // Guardar la ruta del logo del negocio (puede ser null)
                'nombre_negocio' => 'Negocio de ' . $user->nombre,
                'descripcion_negocio' => null,
                'telefono_negocio' => $user->telefono,
                'email_negocio' => $user->email,
                'direccion_negocio' => null,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('welcome')->with('status', 'Registro exitoso.');
    }
}
