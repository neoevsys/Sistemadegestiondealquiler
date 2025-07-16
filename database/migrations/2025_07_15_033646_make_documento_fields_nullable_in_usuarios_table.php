<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Hacer campos nullable directamente
            $table->unsignedBigInteger('tipo_documento_id')->nullable()->change();
            $table->string('numero_documento', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Revertir campos a required
            $table->unsignedBigInteger('tipo_documento_id')->nullable(false)->change();
            $table->string('numero_documento', 20)->nullable(false)->change();
        });
    }
};
