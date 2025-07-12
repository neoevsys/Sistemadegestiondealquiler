<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('telefono', 20)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('ruc_dni', 20)->nullable()->unique();
            $table->foreignId('tipo_usuario_id')->constrained('tipos_usuario');
            $table->foreignId('estado_id')->constrained('estados_usuario');
            $table->string('foto_perfil', 255)->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->boolean('es_admin')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
