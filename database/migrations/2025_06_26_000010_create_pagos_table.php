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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->foreignId('id_reserva')
                  ->constrained('reservas', 'id_reserva')
                  ->onDelete('cascade');
            $table->decimal('monto', 8, 2);
            $table->enum('metodo_pago', ['efectivo', 'tarjeta', 'transferencia', 'yape', 'plin']);
            $table->enum('estado_pago', ['pendiente', 'completado', 'fallido', 'reembolsado'])->default('pendiente');
            $table->timestamp('fecha_pago')->useCurrent();
            $table->string('referencia_transaccion', 100)->unique()->nullable();
            $table->string('comprobante', 255)->nullable(); // Ya existía para la ruta o URL del comprobante
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
