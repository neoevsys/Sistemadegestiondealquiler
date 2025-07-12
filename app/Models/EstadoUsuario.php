<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoUsuario extends Model
{
    protected $table = 'estados_usuario';
    public $timestamps = false;
    protected $fillable = ['nombre'];
}
