<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeporte extends Model
{
    use HasFactory;

    protected $table = 'tipos_deportes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'descripcion',
        'equipamiento_requerido',
        'icono_imagen', // Nueva columna para un ícono o imagen representativa del deporte
    ];

    // --- Relaciones ---

    /**
     * Un tipo de deporte puede estar asociado a muchas instalaciones (relación many-to-many).
     */
    public function instalaciones()
    {
        return $this->belongsToMany(Instalacion::class, 'instalacion_tipo_deporte', 'tipo_deporte_id', 'instalacion_id');
    }
}
