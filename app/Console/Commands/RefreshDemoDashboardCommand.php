<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DemoDashboardSnapshotService;

class RefreshDemoDashboardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:refresh-dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refrescar la caché del dashboard de demostración';

    /**
     * Execute the console command.
     */
    public function handle(DemoDashboardSnapshotService $service)
    {
        $this->info('Refrescando la caché del dashboard de demostración...');
        
        // Refrescar la caché
        $snapshot = $service->refreshCache();
        
        $this->info('¡Caché del dashboard de demostración refrescada exitosamente!');
        
        // Mostrar información sobre los datos
        $isSimulated = $snapshot['demoInfo']['is_simulated'] ?? true;
        $monthName = $snapshot['demoInfo']['month_spanish'] ?? 'Desconocido';
        
        if ($isSimulated) {
            $this->line("Datos simulados para {$monthName}");
        } else {
            $this->line("Datos reales para {$monthName}");
        }
        
        $this->line("Nivel de riesgo: {$snapshot['riskLevel']}");
        $this->line("Porcentaje de riesgo: {$snapshot['riskPercent']}%");
        
        return 0;
    }
}
