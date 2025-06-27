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
        Schema::create('centros_deportivos', function (Blueprint $table) {
            $table->id('id_centro');
            $table->foreignId('id_propietario')
                  ->constrained('propietarios', 'id_propietario')
                  ->onDelete('cascade');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->text('direccion');
            $table->string('ciudad', 100);
            $table->string('distrito', 100)->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->text('servicios_adicionales')->nullable();
            $table->text('politicas')->nullable();
            $table->decimal('calificacion_promedio', 3, 2)->default(0.00);
            $table->enum('estado', ['activo', 'inactivo', 'mantenimiento'])->default('activo');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->json('fotos')->nullable(); // Nueva columna para múltiples fotos del centro deportivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centros_deportivos');
    }
};
