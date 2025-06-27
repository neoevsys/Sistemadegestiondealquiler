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
        Schema::create('horarios_disponibilidad', function (Blueprint $table) {
            $table->id('id_horario'); // Clave primaria auto-incremental
            // Clave foránea a la tabla 'instalaciones'
            $table->foreignId('id_instalacion')
                  ->constrained('instalaciones', 'id_instalacion')
                  ->onDelete('cascade'); // Si se elimina una instalación, se eliminan sus horarios
            $table->enum('dia_semana', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->enum('estado', ['disponible', 'ocupado', 'bloqueado'])->default('disponible');
            $table->timestamps();
            // Añadir una restricción única para evitar horarios duplicados para la misma instalación en el mismo día y hora
            $table->unique(['id_instalacion', 'dia_semana', 'hora_inicio', 'hora_fin'], 'unique_horario_instalacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_disponibilidad');
    }
};
