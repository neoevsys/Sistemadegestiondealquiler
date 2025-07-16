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
        Schema::table('instalaciones', function (Blueprint $table) {
            $table->string('foto_principal')->nullable()->after('fotos');
            $table->json('fotos_adicionales')->nullable()->after('foto_principal');
            $table->timestamp('fecha_creacion')->nullable()->after('fotos_adicionales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instalaciones', function (Blueprint $table) {
            $table->dropColumn(['foto_principal', 'fotos_adicionales', 'fecha_creacion']);
        });
    }
};
