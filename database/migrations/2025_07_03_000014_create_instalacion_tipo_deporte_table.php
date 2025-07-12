<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('instalacion_tipo_deporte', function (Blueprint $table) {
            $table->foreignId('instalacion_id')->constrained('instalaciones')->onDelete('cascade');
            $table->foreignId('tipo_deporte_id')->constrained('tipos_deportes')->onDelete('cascade');
            $table->primary(['instalacion_id', 'tipo_deporte_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('instalacion_tipo_deporte');
    }
};
