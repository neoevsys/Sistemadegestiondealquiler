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
        Schema::create('instalaciones', function (Blueprint $table) {
            $table->id('id_instalacion');
            $table->foreignId('id_centro')
                  ->constrained('centros_deportivos', 'id_centro')
                  ->onDelete('cascade');
            $table->foreignId('id_tipo_deporte')
                  ->constrained('tipos_deportes', 'id_tipo_deporte')
                  ->onDelete('restrict');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->integer('capacidad_maxima');
            $table->decimal('precio_por_hora', 8, 2);
            $table->string('superficie', 50)->nullable();
            $table->string('dimensiones', 100)->nullable();
            $table->text('equipamiento_incluido')->nullable();
            $table->enum('estado', ['disponible', 'mantenimiento', 'fuera_servicio'])->default('disponible');
            $table->json('fotos')->nullable(); // Ya existía para múltiples fotos de la instalación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instalaciones');
    }
};
