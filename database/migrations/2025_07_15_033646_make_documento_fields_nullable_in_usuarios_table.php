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
        Schema::table('usuarios', function (Blueprint $table) {
            // Eliminar constraint unique del numero_documento
            $table->dropUnique(['numero_documento']);
            
            // Hacer campos nullable
            $table->unsignedBigInteger('tipo_documento_id')->nullable()->change();
            $table->string('numero_documento', 20)->nullable()->change();
            
            // Agregar unique constraint que permita nulls
            $table->unique(['numero_documento'], 'usuarios_numero_documento_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Eliminar unique constraint
            $table->dropUnique('usuarios_numero_documento_unique');
            
            // Revertir campos a required
            $table->unsignedBigInteger('tipo_documento_id')->nullable(false)->change();
            $table->string('numero_documento', 20)->nullable(false)->change();
            
            // Restaurar unique constraint original
            $table->unique(['numero_documento']);
        });
    }
};
