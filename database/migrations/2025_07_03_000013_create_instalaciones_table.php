<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('instalaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('centro_id')->constrained('centros_deportivos')->onDelete('cascade');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->integer('capacidad_maxima')->nullable();
            $table->decimal('precio_por_hora', 8, 2)->nullable();
            $table->string('superficie', 50)->nullable();
            $table->string('dimensiones', 100)->nullable();
            $table->text('equipamiento_incluido')->nullable();
            $table->foreignId('estado_id')->constrained('estados_instalacion');
            $table->json('fotos')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('instalaciones');
    }
};
