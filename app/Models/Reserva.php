<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'id_usuario',
        'id_instalacion',
        'fecha_reserva',
        'hora_inicio',
        'hora_fin',
        'duracion_horas',
        'precio_total',
        'estado',
        'fecha_creacion',
        'fecha_modificacion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
        'hora_inicio' => 'datetime', // O 'time'
        'hora_fin' => 'datetime',    // O 'time'
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
    ];

    // --- Relaciones ---

    /**
     * Una reserva es realizada por un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Una reserva es para una instalación específica.
     */
    public function instalacion()
    {
        return $this->belongsTo(Instalacion::class, 'id_instalacion', 'id_instalacion');
    }

    /**
     * Una reserva tiene un pago asociado (relación 1:1).
     */
    public function pago()
    {
        return $this->hasOne(Pago::class, 'id_reserva', 'id_reserva');
    }

    /**
     * Una reserva puede tener una evaluación asociada (relación 1:1).
     */
    public function evaluacion()
    {
        return $this->hasOne(Evaluacion::class, 'id_reserva', 'id_reserva');
    }
}
