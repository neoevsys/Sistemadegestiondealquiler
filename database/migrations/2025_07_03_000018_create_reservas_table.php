<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('instalacion_id')->constrained('instalaciones')->onDelete('cascade');
            $table->date('fecha_reserva');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->decimal('duracion_horas', 3, 1)->nullable();
            $table->decimal('precio_total', 8, 2)->nullable();
            $table->foreignId('estado_id')->constrained('estados_reserva');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('fecha_modificacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['instalacion_id', 'fecha_reserva', 'hora_inicio', 'hora_fin'], 'reserva_instalacion_fecha_hora_unique');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
