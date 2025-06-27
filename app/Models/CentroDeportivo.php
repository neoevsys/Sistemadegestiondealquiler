<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroDeportivo extends Model
{
    use HasFactory;

    protected $table = 'centros_deportivos';
    protected $primaryKey = 'id_centro';

    protected $fillable = [
        'id_propietario',
        'nombre',
        'descripcion',
        'direccion',
        'ciudad',
        'distrito',
        'codigo_postal',
        'telefono',
        'email',
        'latitud',
        'longitud',
        'servicios_adicionales',
        'politicas',
        'calificacion_promedio',
        'estado',
        'fecha_registro',
        'fotos', // Nueva columna para múltiples fotos del centro deportivo (JSON)
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'calificacion_promedio' => 'decimal:2', // Castear a decimal con 2 decimales
        'fotos' => 'array', // Importante: Laravel convertirá automáticamente el JSON a un array PHP
    ];

    // --- Relaciones ---

    /**
     * Un centro deportivo pertenece a un propietario.
     */
    public function propietario()
    {
        // belongsTo(ModeloRelacionado::class, 'clave_foranea_en_esta_tabla', 'clave_local_en_tabla_relacionada')
        return $this->belongsTo(Propietario::class, 'id_propietario', 'id_propietario');
    }

    /**
     * Un centro deportivo puede tener muchas instalaciones.
     */
    public function instalaciones()
    {
        return $this->hasMany(Instalacion::class, 'id_centro', 'id_centro');
    }

    /**
     * Un centro deportivo puede tener muchas evaluaciones.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'id_centro', 'id_centro');
    }
}
