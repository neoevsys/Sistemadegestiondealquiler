<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_reserva',
        'monto',
        'metodo_pago',
        'estado_pago',
        'fecha_pago',
        'referencia_transaccion',
        'comprobante', // Columna para la ruta o URL del comprobante (imagen/PDF)
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
    ];

    // --- Relaciones ---

    /**
     * Un pago corresponde a una sola reserva.
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }
}
