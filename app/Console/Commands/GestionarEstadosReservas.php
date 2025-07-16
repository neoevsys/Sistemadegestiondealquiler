<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use Carbon\Carbon;

class GestionarEstadosReservas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservas:gestionar-estados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gestiona automáticamente los estados de las reservas (cancelar pendientes, completar confirmadas)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando gestión automática de estados de reservas...');

        $canceladas = $this->cancelarReservasPendientes();
        $completadas = $this->completarReservasConfirmadas();

        $this->info("Proceso completado:");
        $this->info("- Reservas canceladas automáticamente: {$canceladas}");
        $this->info("- Reservas completadas automáticamente: {$completadas}");

        return 0;
    }

    /**
     * Cancel pending reservations that are older than 24 hours without payment.
     */
    private function cancelarReservasPendientes()
    {
        $hace24Horas = Carbon::now()->subHours(24);
        
        $reservasPendientes = Reserva::where('estado_id', 1) // Pendiente
            ->where('fecha_creacion', '<=', $hace24Horas)
            ->whereDoesntHave('pago') // Sin pago exitoso
            ->get();

        $canceladas = 0;
        foreach ($reservasPendientes as $reserva) {
            $reserva->update([
                'estado_id' => 3, // Cancelada
                'fecha_modificacion' => now(),
                'observaciones' => ($reserva->observaciones ?? '') . 
                    ' [Sistema: Cancelada automáticamente por falta de pago tras 24 horas]'
            ]);
            $canceladas++;
            
            $this->line("Cancelada: Reserva #{$reserva->id} - {$reserva->instalacion->nombre} - {$reserva->fecha_reserva}");
        }

        return $canceladas;
    }

    /**
     * Complete confirmed reservations that have passed their end time.
     */
    private function completarReservasConfirmadas()
    {
        $ahora = Carbon::now();
        
        $reservasConfirmadas = Reserva::where('estado_id', 2) // Confirmada
            ->whereRaw("CONCAT(fecha_reserva, ' ', hora_fin) <= ?", [$ahora])
            ->get();

        $completadas = 0;
        foreach ($reservasConfirmadas as $reserva) {
            $reserva->update([
                'estado_id' => 4, // Completada
                'fecha_modificacion' => now(),
                'observaciones' => ($reserva->observaciones ?? '') . 
                    ' [Sistema: Completada automáticamente al finalizar el horario]'
            ]);
            $completadas++;
            
            $this->line("Completada: Reserva #{$reserva->id} - {$reserva->instalacion->nombre} - {$reserva->fecha_reserva}");
        }

        return $completadas;
    }
}
