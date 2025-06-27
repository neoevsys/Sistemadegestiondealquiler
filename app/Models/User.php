<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Fortify\TwoFactorAuthenticatable; // Si usas Fortify
    use Laravel\Sanctum\HasApiTokens; // Si usas Sanctum
    class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Especifica el nombre de la tabla si no sigue la convención de Laravel (plural del nombre del modelo)
    protected $table = 'usuarios';
    // Especifica la clave primaria si no es 'id'
    protected $primaryKey = 'id_usuario';

    /**
     * Los atributos que son asignables masivamente.
     * Esto es una medida de seguridad para prevenir la asignación masiva de atributos no deseados.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'fecha_nacimiento',
        'ruc_dni',
        'tipo_usuario',
        'estado',
        'fecha_registro',
        'foto_perfil', // Añadido
    ];

    /**
     * Los atributos que deben ser ocultados para la serialización (ej. al convertir a JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // Ocultar el hash de la contraseña
    ];

    /**
     * Los atributos que deben ser "casteados" a tipos de datos nativos de PHP.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_registro' => 'datetime', // Convertir a objeto DateTime
        'fecha_nacimiento' => 'date',   // Convertir a objeto Date
    ];

    // --- Relaciones ---

    /**
     * Un usuario puede tener muchas reservas.
     */
    public function reservas()
    {
        // hasMany(ModeloRelacionado::class, 'clave_foranea_en_tabla_relacionada', 'clave_local_en_esta_tabla')
        return $this->hasMany(Reserva::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Un usuario puede hacer muchas evaluaciones.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Un usuario puede ser un propietario.
     */
    public function propietario()
    {
        return $this->hasOne(Propietario::class, 'id_propietario', 'id_usuario');
    }
}
