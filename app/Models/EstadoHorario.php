<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoHorario extends Model
{
    use HasFactory;

    protected $table = 'estados_horario';
    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Un estado de horario puede tener muchos horarios de disponibilidad.
     */
    public function horariosDisponibilidad()
    {
        return $this->hasMany(HorarioDisponibilidad::class, 'estado_id', 'id');
    }
}
