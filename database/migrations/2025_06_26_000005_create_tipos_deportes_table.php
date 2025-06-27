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
        Schema::create('tipos_deportes', function (Blueprint $table) {
            $table->id('id_tipo_deporte');
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->text('equipamiento_requerido')->nullable();
            $table->string('icono_imagen', 255)->nullable(); // Nueva columna para un ícono o imagen representativa del deporte
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_deportes');
    }
};
