<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CentroDeportivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->tipo_usuario === 'propietario';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $centroId = $this->route('centro') ? $this->route('centro')->id_centro : null;
        $propietarioId = auth()->user()->propietario?->id_propietario;

        return [
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:2000',
            'direccion' => 'required|string|max:500',
            'ciudad' => 'required|string|max:100',
            'distrito' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
            'telefono' => 'nullable|string|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('centros_deportivos', 'email')
                    ->ignore($centroId, 'id_centro')
                    ->where('id_propietario', $propietarioId)
            ],
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'servicios_adicionales' => 'nullable|string|max:2000',
            'politicas' => 'nullable|string|max:2000',
            'estado' => 'required|in:activo,inactivo,mantenimiento',
            'fotos' => 'nullable|array|max:10',
            'fotos.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max por imagen
            'fotos_eliminar' => 'nullable|array',
            'fotos_eliminar.*' => 'string'
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
            'nombre.required' => 'El nombre del centro deportivo es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 200 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 2000 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede tener más de 500 caracteres.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'ciudad.max' => 'La ciudad no puede tener más de 100 caracteres.',
            'distrito.max' => 'El distrito no puede tener más de 100 caracteres.',
            'codigo_postal.max' => 'El código postal no puede tener más de 10 caracteres.',
            'telefono.regex' => 'El formato del teléfono no es válido.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'email.email' => 'El formato del email no es válido.',
            'email.unique' => 'Ya tienes un centro con este email.',
            'email.max' => 'El email no puede tener más de 150 caracteres.',
            'latitud.numeric' => 'La latitud debe ser un número válido.',
            'latitud.between' => 'La latitud debe estar entre -90 y 90 grados.',
            'longitud.numeric' => 'La longitud debe ser un número válido.',
            'longitud.between' => 'La longitud debe estar entre -180 y 180 grados.',
            'servicios_adicionales.max' => 'Los servicios adicionales no pueden tener más de 2000 caracteres.',
            'politicas.max' => 'Las políticas no pueden tener más de 2000 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: activo, inactivo o mantenimiento.',
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
            'ciudad' => 'ciudad',
            'distrito' => 'distrito',
            'codigo_postal' => 'código postal',
            'telefono' => 'teléfono',
            'email' => 'email',
            'latitud' => 'latitud',
            'longitud' => 'longitud',
            'servicios_adicionales' => 'servicios adicionales',
            'politicas' => 'políticas',
            'estado' => 'estado',
            'fotos' => 'fotos',
        ];
    }
}
