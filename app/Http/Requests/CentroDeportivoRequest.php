<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Importa el modelo User para la validación de email
use App\Models\CentroDeportivo; // Importa el modelo CentroDeportivo para la validación de email

class CentroDeportivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::info('Intentando autorizar CentroDeportivoRequest.');

        $isAuth = auth()->check();
        Log::info('Usuario autenticado: ' . ($isAuth ? 'Sí' : 'No'));

        if ($isAuth) {
            $user = auth()->user();
            // Acceder al nombre del tipo de usuario a través de la relación
            $userTypeName = $user->tipoUsuario?->nombre ?? 'N/A';
            Log::info('Tipo de usuario: ' . $userTypeName);
            Log::info('¿Es propietario? ' . ($userTypeName === 'propietario' ? 'Sí' : 'No'));

            if ($userTypeName !== 'propietario') {
                Log::warning('Intento de guardar centro por usuario no propietario: ID ' . ($user->id ?? 'N/A') . ' - Tipo: ' . $userTypeName);
            }

            return $isAuth && $userTypeName === 'propietario';
        }

        Log::warning('Intento de guardar centro sin autenticación.');
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Obtener el ID del CentroDeportivo si estamos actualizando uno existente
        // La clave primaria de 'centros_deportivos' es 'id', según tu migración.
        $centroId = $this->route('centro') ? $this->route('centro')->id : null;

        // Obtener el ID del propietario autenticado
        $propietarioId = auth()->user()->propietario?->id;

        return [
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:2000',
            'direccion' => 'required|string|max:500',
            'departamento_id' => 'required|exists:departamentos,id',
            'provincia_id' => [
                'required',
                'exists:provincias,id',
                Rule::exists('provincias', 'id')->where('departamento_id', $this->departamento_id),
            ],
            'distrito_id' => [
                'required',
                'exists:distritos,id',
                Rule::exists('distritos', 'id')->where('provincia_id', $this->provincia_id),
            ],
            'codigo_postal' => 'nullable|string|max:10',
            'telefono' => 'required|string|max:20',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:150',
                // Lógica de validación personalizada para el campo 'email'
                function ($attribute, $value, $fail) use ($propietarioId, $centroId) {
                    $userPersonalEmail = auth()->user()->email;

                    // Condición 1: Si el email enviado ES el email personal del propietario autenticado.
                    if ($value === $userPersonalEmail) {
                        // Verifica si este email personal ya está siendo utilizado por un centro deportivo de *otro* propietario.
                        $existsInOtherProprietorCenters = CentroDeportivo::where('email', $value)
                                                          ->where('propietario_id', '!=', $propietarioId)
                                                          ->when($centroId, function ($query) use ($centroId) {
                                                              $query->where('id', '!=', $centroId); // Excluir el centro actual si estamos editando
                                                          })
                                                          ->exists();
                        if ($existsInOtherProprietorCenters) {
                            $fail("El email personal de tu cuenta ('$value') ya está siendo utilizado por un centro deportivo de otro propietario.");
                            return; // Detener la validación si se encuentra el error
                        }
                        // Si el email es el personal del propietario y no está en centros de OTROS propietarios, es válido para los centros de ESTE propietario.
                    } else {
                        // Condición 2: El email enviado *NO ES* el email personal del propietario autenticado.
                        // En este caso, este email debe ser único a nivel GLOBAL entre todos los centros.
                        // Y NO debe ser el email personal de NINGÚN otro usuario.

                        // 2a: Verificar unicidad en TODOS los centros deportivos (globalmente).
                        $existsInAnyCenter = CentroDeportivo::where('email', $value)
                                             ->when($centroId, function ($query) use ($centroId) {
                                                 $query->where('id', '!=', $centroId); // Excluir el centro actual si estamos editando
                                             })
                                             ->exists();
                        if ($existsInAnyCenter) {
                            $fail("El email ('$value') ya está registrado por otro centro deportivo.");
                            return;
                        }

                        // 2b: Verificar unicidad contra los emails personales de TODOS los usuarios (excluyendo al usuario actual).
                        $existsInUsers = User::where('email', $value)
                                         ->where('id', '!=', auth()->id()) // Excluir el email personal del usuario actual
                                         ->exists();
                        if ($existsInUsers) {
                            $fail("El email ('$value') ya está registrado como email personal de otro usuario.");
                            return;
                        }
                    }
                },
            ],
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'servicios_adicionales' => 'nullable|string|max:2000',
            'politicas' => 'nullable|string|max:2000',
            'estado_id' => 'required|exists:estados_centro,id', // Cambiado a estado_id
            'fotos' => 'nullable|array|max:10',
            'fotos.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
            'provincia_id.exists' => 'La provincia seleccionada no es válida o no pertenece al departamento.',
            'distrito_id.exists' => 'El distrito seleccionado no es válido o no pertenece a la provincia.',
            // Los mensajes de error para 'email' se gestionan dentro de la closure de validación personalizada
            'email.email' => 'El formato del email no es válido.',
            'email.max' => 'El email no puede tener más de 150 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 2000 caracteres.',
            'servicios_adicionales.max' => 'Los servicios adicionales no pueden tener más de 2000 caracteres.',
            'politicas.max' => 'Las políticas no pueden tener más de 2000 caracteres.',
            'estado_id.required' => 'El estado es obligatorio.', // Mensaje corregido
            'estado_id.exists' => 'El estado seleccionado no es válido.', // Mensaje corregido
            'fotos.array' => 'Las fotos deben ser enviadas como una lista.',
            'fotos.max' => 'No puedes subir más de 10 fotos.',
            'fotos.*.image' => 'Cada archivo debe ser una imagen.',
            'fotos.*.mimes' => 'Las imágenes deben ser de tipo: jpeg, jpg, png o webp.',
            'fotos.*.max' => 'Cada imagen no puede ser mayor a 5MB.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre del centro',
            'descripcion' => 'descripción',
            'direccion' => 'dirección',
            'departamento_id' => 'departamento',
            'provincia_id' => 'provincia',
            'distrito_id' => 'distrito',
            'codigo_postal' => 'código postal',
            'telefono' => 'teléfono',
            'email' => 'email',
            'latitud' => 'latitud',
            'longitud' => 'longitud',
            'servicios_adicionales' => 'servicios adicionales',
            'politicas' => 'políticas',
            'estado_id' => 'estado', // Atributo corregido
        ];
    }
}
