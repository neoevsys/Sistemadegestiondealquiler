<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('centros_deportivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propietario_id')->constrained('propietarios')->onDelete('cascade');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->text('direccion')->nullable();
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->foreignId('provincia_id')->constrained('provincias');
            $table->foreignId('distrito_id')->constrained('distritos');
            $table->string('codigo_postal', 10)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->text('servicios_adicionales')->nullable();
            $table->text('politicas')->nullable();
            $table->decimal('calificacion_promedio', 3, 2)->nullable();
            $table->foreignId('estado_id')->constrained('estados_centro');
            $table->timestamp('fecha_registro')->nullable();
            $table->json('fotos')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['latitud', 'longitud']);
            $table->index('departamento_id');
            $table->index('provincia_id');
            $table->index('distrito_id');
            $table->index('codigo_postal');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('centros_deportivos');
    }
};
