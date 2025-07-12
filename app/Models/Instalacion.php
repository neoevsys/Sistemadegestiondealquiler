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
        'id_tipo_deporte',
        'nombre',
        'descripcion',
        'capacidad_maxima',
        'precio_por_hora',
        'superficie',
        'dimensiones',
        'equipamiento_incluido',
        'estado_id',
        'fotos', // Columna para múltiples fotos de la instalación (JSON)
    ];

    protected $casts = [
        'fotos' => 'array', // Laravel convertirá automáticamente el JSON a un array PHP
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
     * Una instalación está dedicada a un tipo de deporte.
     */
    public function tipoDeporte()
    {
        return $this->belongsTo(TipoDeporte::class, 'id_tipo_deporte', 'id_tipo_deporte');
    }

    /**
     * Una instalación tiene muchos horarios de disponibilidad.
     */
    public function horariosDisponibilidad()
    {
        return $this->hasMany(HorarioDisponibilidad::class, 'id_instalacion', 'id_instalacion');
    }

    /**
     * Una instalación puede tener muchas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_instalacion', 'id_instalacion');
    }
}
