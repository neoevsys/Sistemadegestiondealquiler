<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'reserva_id',
        'monto',
        'metodo_pago_id',
        'estado_id',
        'fecha_pago',
        'numero_transaccion',
        'datos_transaccion',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'datos_transaccion' => 'array',
    ];

    // --- Relaciones ---

    /**
     * Un pago corresponde a una sola reserva.
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }

    /**
     * Un pago tiene un método de pago.
     */
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id', 'id');
    }

    /**
     * Un pago tiene un estado.
     */
    public function estadoPago()
    {
        return $this->belongsTo(EstadoPago::class, 'estado_id', 'id');
    }
}
