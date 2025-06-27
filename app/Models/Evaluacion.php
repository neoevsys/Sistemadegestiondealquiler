<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_evaluacion';

    protected $fillable = [
        'id_usuario',
        'id_centro',
        'id_reserva',
        'calificacion',
        'comentario',
        'fecha_evaluacion',
    ];

    protected $casts = [
        'fecha_evaluacion' => 'datetime',
    ];

    // --- Relaciones ---

    /**
     * Una evaluación es hecha por un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Una evaluación es para un centro deportivo.
     */
    public function centroDeportivo()
    {
        return $this->belongsTo(CentroDeportivo::class, 'id_centro', 'id_centro');
    }

    /**
     * Una evaluación corresponde a una sola reserva.
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }
}
