<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Asegúrate de importar SoftDeletes

class CentroDeportivo extends Model
{
    use HasFactory, SoftDeletes; // Usar SoftDeletes

    protected $table = 'centros_deportivos';

    protected $fillable = [
        'propietario_id',
        'nombre',
        'descripcion',
        'direccion',
        'departamento_id',
        'provincia_id',
        'distrito_id',
        'codigo_postal',
        'telefono',
        'email',
        'latitud',
        'longitud',
        'servicios_adicionales',
        'politicas',
        'calificacion_promedio',
        'estado_id', // Cambiado de 'estado' a 'estado_id'
        'fecha_registro',
        'fotos',
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
        return $this->belongsTo(Propietario::class, 'propietario_id', 'id');
    }

    /**
     * Un centro deportivo puede tener muchas instalaciones.
     */
    public function instalaciones()
    {
        return $this->hasMany(Instalacion::class, 'centro_id', 'id');
    }

    /**
     * Un centro deportivo puede tener muchas evaluaciones.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'centro_id', 'id');
    }

    /**
     * Relación con departamento
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    /**
     * Relación con provincia
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    /**
     * Relación con distrito
     */
    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    /**
     * Relación con el estado del centro
     */
    public function estadoCentro() // Nuevo método para la relación con estados_centro
    {
        return $this->belongsTo(EstadoCentro::class, 'estado_id');
    }
}
