<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Instalacion;

class MigrateFotosInstalaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:fotos-instalaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra las fotos existentes del campo fotos a foto_principal y fotos_adicionales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando migración de fotos...');
        
        $instalaciones = Instalacion::whereNotNull('fotos')->get();
        
        $this->info("Encontradas {$instalaciones->count()} instalaciones con fotos.");
        
        $migrated = 0;
        $errors = 0;
        
        foreach ($instalaciones as $instalacion) {
            try {
                if ($instalacion->fotos && is_array($instalacion->fotos) && count($instalacion->fotos) > 0) {
                    $fotos = $instalacion->fotos;
                    
                    // Asignar la primera foto como principal
                    $instalacion->foto_principal = $fotos[0];
                    
                    // Asignar el resto como adicionales
                    if (count($fotos) > 1) {
                        $instalacion->fotos_adicionales = array_slice($fotos, 1);
                    }
                    
                    $instalacion->save();
                    
                    $this->line("✓ Migrado: {$instalacion->nombre}");
                    $migrated++;
                }
            } catch (\Exception $e) {
                $this->error("✗ Error en {$instalacion->nombre}: {$e->getMessage()}");
                $errors++;
            }
        }
        
        $this->info("Migración completada:");
        $this->info("- Migradas: {$migrated}");
        $this->info("- Errores: {$errors}");
        
        return 0;
    }
}
