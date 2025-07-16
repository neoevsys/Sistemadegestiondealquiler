<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPago extends Model
{
    use HasFactory;

    protected $table = 'estados_pago';
    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Un estado de pago puede tener muchos pagos.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'estado_id', 'id');
    }
}
