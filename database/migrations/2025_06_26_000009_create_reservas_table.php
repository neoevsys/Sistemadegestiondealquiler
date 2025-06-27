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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id_reserva'); // Clave primaria auto-incremental
            // Clave foránea a la tabla 'usuarios'
            $table->foreignId('id_usuario')
                  ->constrained('usuarios', 'id_usuario')
                  ->onDelete('cascade'); // Si se elimina un usuario, se eliminan sus reservas
            // Clave foránea a la tabla 'instalaciones'
            $table->foreignId('id_instalacion')
                  ->constrained('instalaciones', 'id_instalacion')
                  ->onDelete('cascade'); // Si se elimina una instalación, se eliminan sus reservas
            $table->date('fecha_reserva');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->decimal('duracion_horas', 3, 1); // Duración en horas, con un decimal
            $table->decimal('precio_total', 8, 2);
            $table->enum('estado', ['pendiente', 'confirmada', 'completada', 'cancelada'])->default('pendiente');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_modificacion')->useCurrent()->useCurrentOnUpdate(); // Se actualiza automáticamente
            $table->text('observaciones')->nullable();
            $table->timestamps(); // created_at y updated_at (adicionales a fecha_creacion/modificacion)
            // Índice compuesto para optimizar búsquedas de reservas por fecha y hora
            $table->index(['fecha_reserva', 'hora_inicio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
