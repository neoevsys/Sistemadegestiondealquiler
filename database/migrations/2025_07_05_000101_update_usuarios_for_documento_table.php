<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_documento_id')->after('fecha_nacimiento');
            $table->string('numero_documento', 20)->unique()->after('tipo_documento_id');
            $table->string('razon_social', 200)->nullable()->after('numero_documento');
            $table->foreign('tipo_documento_id')->references('id')->on('tipos_documento');
            $table->dropColumn('ruc_dni');
        });
    }
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('ruc_dni', 20)->unique()->after('fecha_nacimiento');
            $table->dropForeign(['tipo_documento_id']);
            $table->dropColumn(['tipo_documento_id', 'numero_documento', 'razon_social']);
        });
    }
};
