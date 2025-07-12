<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipos_usuario';
    protected $fillable = ['nombre'];

    // Si también necesitas la relación inversa (opcional, para conveniencia)
    public function usuarios()
    {
        return $this->hasMany(User::class, 'tipo_usuario_id', 'id');
    }
}
