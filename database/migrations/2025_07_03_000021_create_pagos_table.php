<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained('reservas')->unique()->onDelete('cascade');
            $table->decimal('monto', 8, 2);
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago');
            $table->foreignId('estado_id')->constrained('estados_pago');
            $table->timestamp('fecha_pago')->nullable();
            $table->string('referencia_transaccion', 100)->unique()->nullable();
            $table->string('comprobante', 255)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
