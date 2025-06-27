<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioDisponibilidad extends Model
{
    use HasFactory;

    protected $table = 'horarios_disponibilidad';
    protected $primaryKey = 'id_horario';

    protected $fillable = [
        'id_instalacion',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime', // O 'time' si solo necesitas la hora
        'hora_fin' => 'datetime',    // O 'time'
    ];

    // --- Relaciones ---

    /**
     * Un horario de disponibilidad pertenece a una instalación.
     */
    public function instalacion()
    {
        return $this->belongsTo(Instalacion::class, 'id_instalacion', 'id_instalacion');
    }
}
