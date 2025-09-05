<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardSnapshotService;

class DemoDashboardController extends Controller
{
    protected DashboardSnapshotService $snapshotService;

    public function __construct(DashboardSnapshotService $snapshotService)
    {
        $this->snapshotService = $snapshotService;
    }
    public function index(Request $request)
    {
        $user = $request->user();
        $daysLeft = $user->expires_at ? now()->diffInDays($user->expires_at) : null;
        $snapshot = $this->snapshotService->getCachedOrBuild();
        return view('dashboard.demo', compact('user', 'daysLeft', 'snapshot'));
    }

    /**
     * API JSON (read-only) para consumir el snapshot actual.
     */
    public function apiSnapshot(Request $request)
    {
        return response()->json($this->snapshotService->getCachedOrBuild());
    }
}
