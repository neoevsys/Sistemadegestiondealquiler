<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('estado_id')->constrained('estados_propietario');
            $table->string('logo_negocio', 255)->nullable();
            $table->string('nombre_negocio', 200)->nullable();
            $table->text('descripcion_negocio')->nullable();
            $table->string('telefono_negocio', 20)->nullable();
            $table->string('email_negocio', 150)->nullable();
            $table->text('direccion_negocio')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('propietarios');
    }
};
