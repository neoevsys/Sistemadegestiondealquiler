<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario_id',
        'instalacion_id',
        'fecha_reserva',
        'hora_inicio',
        'hora_fin',
        'duracion_horas',
        'precio_total',
        'estado_id',
        'fecha_creacion',
        'fecha_modificacion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
        'fecha_creacion' => 'datetime',
        'fecha_modificacion' => 'datetime',
        'duracion_horas' => 'decimal:1',
        'precio_total' => 'decimal:2',
    ];

    // --- Relaciones ---

    /**
     * Una reserva es realizada por un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    /**
     * Una reserva es para una instalación específica.
     */
    public function instalacion()
    {
        return $this->belongsTo(Instalacion::class, 'instalacion_id', 'id');
    }

    /**
     * Una reserva tiene un estado.
     */
    public function estadoReserva()
    {
        return $this->belongsTo(EstadoReserva::class, 'estado_id', 'id');
    }

    /**
     * Una reserva puede tener múltiples intentos de pago.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'reserva_id', 'id');
    }

    /**
     * Una reserva tiene un pago exitoso (el último completado).
     */
    public function pago()
    {
        return $this->hasOne(Pago::class, 'reserva_id', 'id')
            ->where('estado_id', 1) // Solo pagos completados
            ->latest();
    }

    /**
     * Una reserva puede tener múltiples evaluaciones.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'reserva_id', 'id');
    }

    /**
     * Una reserva tiene una evaluación del usuario (relación específica).
     */
    public function evaluacion()
    {
        return $this->hasOne(Evaluacion::class, 'reserva_id', 'id');
    }

    // Accessor para obtener el estado como string
    public function getEstadoAttribute()
    {
        return $this->estadoReserva ? $this->estadoReserva->nombre : 'desconocido';
    }
}
