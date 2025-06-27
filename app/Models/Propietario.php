<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_propietario'; // Especifica la clave primaria
    protected $table = 'propietarios'; // Especifica el nombre de la tabla
    protected $fillable = [
        'id_propietario',
        'estado',
        'logo_negocio', // Añadido
        // Si los añades en la migración, inclúyelos aquí
        'nombre_negocio',
        'descripcion_negocio',
        'telefono_negocio',
        'email_negocio',
        'direccion_negocio',
    ];
    // Si no quieres que Laravel maneje automáticamente created_at y updated_at
    // public $timestamps = false; // Pero tu migración los tiene, así que déjalo por defecto
    // Define la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_propietario', 'id_usuario');
    }

    /**
     * Un propietario puede tener muchos centros deportivos.
     */
    public function centrosDeportivos()
    {
        return $this->hasMany(CentroDeportivo::class, 'id_propietario', 'id_propietario');
    }
}
