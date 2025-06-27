<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeporte extends Model
{
    use HasFactory;

    protected $table = 'tipos_deportes';
    protected $primaryKey = 'id_tipo_deporte';

    protected $fillable = [
        'nombre',
        'descripcion',
        'equipamiento_requerido',
        'icono_imagen', // Nueva columna para un ícono o imagen representativa del deporte
    ];

    // --- Relaciones ---

    /**
     * Un tipo de deporte puede estar asociado a muchas instalaciones.
     */
    public function instalaciones()
    {
        return $this->hasMany(Instalacion::class, 'id_tipo_deporte', 'id_tipo_deporte');
    }
}
