<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tipos_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tipos_usuario');
    }
};
