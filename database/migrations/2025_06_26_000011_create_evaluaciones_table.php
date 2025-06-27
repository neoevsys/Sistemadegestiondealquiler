<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id('id_evaluacion');
                $table->foreignId('id_usuario')
                      ->constrained('usuarios', 'id_usuario')
                      ->onDelete('cascade');
                $table->foreignId('id_centro')
                      ->constrained('centros_deportivos', 'id_centro')
                      ->onDelete('cascade');
                $table->foreignId('id_reserva')
                      ->constrained('reservas', 'id_reserva')
                      ->onDelete('cascade');
                $table->integer('calificacion'); // Calificación numérica
                $table->text('comentario')->nullable();
                $table->timestamp('fecha_evaluacion')->useCurrent();
                $table->timestamps();
                // ¡Línea eliminada! La validación se hará a nivel de aplicación.
                // Una reserva solo puede tener una evaluación
                $table->unique('id_reserva');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
