<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable; // Si usas Fortify
use Laravel\Sanctum\HasApiTokens; // Si usas Sanctum
use App\Models\TipoUsuario;
use App\Models\EstadoUsuario;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

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
        'tipo_documento_id',
        'numero_documento',
        'razon_social',
        'tipo_usuario_id',
        'estado_id',
        'fecha_registro',
        'foto_perfil',
        'es_admin',
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
        'es_admin' => 'boolean',
    ];

    // --- Relaciones ---

    /**
     * Un usuario puede tener muchas reservas.
     */
    public function reservas()
    {
        // hasMany(ModeloRelacionado::class, 'clave_foranea_en_tabla_relacionada', 'clave_local_en_esta_tabla')
        return $this->hasMany(Reserva::class, 'usuario_id', 'id');
    }

    /**
     * Un usuario puede hacer muchas evaluaciones.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'usuario_id', 'id');
    }

    /**
     * Un usuario puede ser un propietario.
     */
    public function propietario()
    {
        return $this->hasOne(Propietario::class, 'id', 'id'); // id del propietario es el mismo id del usuario
    }

    /**
     * Un usuario pertenece a un tipo de usuario.
     */
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_usuario_id', 'id');
    }

    /**
     * Un usuario tiene un estado.
     */
    public function estadoUsuario()
    {
        return $this->belongsTo(EstadoUsuario::class, 'estado_id');
    }

    /**
     * Relación con tipo de documento
     */
    public function tipoDocumento()
    {
        return $this->belongsTo(\App\Models\TipoDocumento::class, 'tipo_documento_id');
    }
}
