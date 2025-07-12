<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('centro_id')->constrained('centros_deportivos')->onDelete('cascade');
            $table->foreignId('reserva_id')->constrained('reservas')->unique()->onDelete('cascade');
            $table->integer('calificacion');
            $table->text('comentario')->nullable();
            $table->timestamp('fecha_evaluacion')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
