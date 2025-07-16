<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacion extends Model
{
    use HasFactory;

    protected $table = 'instalaciones';
    protected $primaryKey = 'id';

    protected $fillable = [
        'centro_id',
        'nombre',
        'descripcion',
        'capacidad_maxima',
        'precio_por_hora',
        'superficie',
        'dimensiones',
        'equipamiento_incluido',
        'estado_id',
        'foto_principal',
        'fotos_adicionales',
        'fecha_creacion',
    ];

    protected $casts = [
        'fotos_adicionales' => 'array',
        'fecha_creacion' => 'datetime',
    ];

    // --- Relaciones ---

    /**
     * Una instalación pertenece a un centro deportivo.
     */
    public function centroDeportivo()
    {
        return $this->belongsTo(CentroDeportivo::class, 'centro_id', 'id');
    }

    /**
     * Una instalación pertenece a un estado.
     */
    public function estadoInstalacion()
    {
        return $this->belongsTo(\App\Models\EstadoInstalacion::class, 'estado_id', 'id');
    }

    /**
     * Una instalación puede tener muchos tipos de deporte (relación muchos a muchos).
     */
    public function tiposDeporte()
    {
        return $this->belongsToMany(TipoDeporte::class, 'instalacion_tipo_deporte', 'instalacion_id', 'tipo_deporte_id');
    }

    /**
     * Una instalación tiene muchos horarios de disponibilidad.
     */
    public function horariosDisponibilidad()
    {
        return $this->hasMany(HorarioDisponibilidad::class, 'instalacion_id', 'id');
    }

    /**
     * Una instalación puede tener muchas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'instalacion_id', 'id');
    }
}
