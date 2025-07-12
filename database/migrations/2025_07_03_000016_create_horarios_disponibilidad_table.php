<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('horarios_disponibilidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instalacion_id')->constrained('instalaciones')->onDelete('cascade');
            $table->string('dia_semana', 20);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->foreignId('estado_id')->constrained('estados_horario');
            $table->timestamps();
            $table->unique(['instalacion_id', 'dia_semana', 'hora_inicio', 'hora_fin'], 'hd_instalacion_dia_hora_unique');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('horarios_disponibilidad');
    }
};
