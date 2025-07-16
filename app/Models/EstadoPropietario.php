<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPropietario extends Model
{
    use HasFactory;

    protected $table = 'estados_propietario';
    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Un estado de propietario puede tener muchos propietarios.
     */
    public function propietarios()
    {
        return $this->hasMany(Propietario::class, 'estado_id', 'id');
    }
}
