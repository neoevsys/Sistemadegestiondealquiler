<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // La clave primaria real es 'id', no 'id_propietario'
    protected $table = 'propietarios'; // Especifica el nombre de la tabla
    protected $fillable = [
        'usuario_id',
        'estado_id',
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
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    /**
     * Un propietario puede tener muchos centros deportivos.
     */
    public function centrosDeportivos()
    {
        return $this->hasMany(CentroDeportivo::class, 'propietario_id', 'id');
    }
}
