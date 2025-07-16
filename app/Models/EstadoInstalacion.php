<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoInstalacion extends Model
{
    use HasFactory;

    protected $table = 'estados_instalacion';
    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Una estado de instalación puede tener muchas instalaciones.
     */
    public function instalaciones()
    {
        return $this->hasMany(Instalacion::class, 'estado_id', 'id');
    }
}
