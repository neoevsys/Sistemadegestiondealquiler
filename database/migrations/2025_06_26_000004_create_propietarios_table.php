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
        Schema::create('propietarios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_propietario')->primary();
            $table->foreign('id_propietario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente'); // Estado de aprobación del rol de propietario
            $table->string('logo_negocio', 255)->nullable(); // Campo para la ruta del logo del negocio (nullable)
            // Aquí podrías añadir otros campos relacionados con el negocio que no sean personales del propietario,
            // y que también serían nullable para que se puedan añadir después. Ej:
            $table->string('nombre_negocio', 200)->nullable();
            $table->text('descripcion_negocio')->nullable();
            $table->string('telefono_negocio', 20)->nullable();
            $table->string('email_negocio', 150)->nullable();
            $table->text('direccion_negocio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propietarios');
    }
};
