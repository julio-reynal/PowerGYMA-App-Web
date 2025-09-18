<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardSnapshotService;
use App\Services\DemoDashboardSnapshotService;

class DemoDashboardController extends Controller
{
    protected DashboardSnapshotService $snapshotService;
    protected DemoDashboardSnapshotService $demoSnapshotService;

    public function __construct(
        DashboardSnapshotService $snapshotService,
        DemoDashboardSnapshotService $demoSnapshotService
    ) {
        $this->snapshotService = $snapshotService;
        $this->demoSnapshotService = $demoSnapshotService;
    }
    public function index(Request $request)
    {
        $user = $request->user();
        $daysLeft = $user->expires_at ? now()->diffInDays($user->expires_at) : null;
        
        // Usar el servicio de demo que busca datos del mes pasado
        $snapshot = $this->demoSnapshotService->getCachedOrBuild();
        
        return view('dashboard.demo', compact('user', 'daysLeft', 'snapshot'));
    }

    /**
     * API JSON (read-only) para consumir el snapshot demo del mes pasado.
     */
    public function apiSnapshot(Request $request)
    {
        return response()->json($this->demoSnapshotService->getCachedOrBuild());
    }

    /**
     * Refrescar cache del snapshot demo del mes pasado
     */
    public function refreshDemoCache(Request $request)
    {
        $snapshot = $this->demoSnapshotService->refreshCache();
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Datos de demo del mes pasado actualizados exitosamente',
                'snapshot' => $snapshot
            ]);
        }
        
        return redirect()->back()->with('success', 'Datos de demo actualizados exitosamente');
    }
}
