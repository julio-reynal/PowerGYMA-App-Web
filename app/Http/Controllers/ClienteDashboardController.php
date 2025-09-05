<?php

namespace App\Http\Controllers;

use App\Models\MonthlyRiskData;
use App\Models\RiskEvaluation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Services\DashboardSnapshotService;

class ClienteDashboardController extends Controller
{
    protected DashboardSnapshotService $snapshotService;

    public function __construct(DashboardSnapshotService $snapshotService)
    {
        $this->snapshotService = $snapshotService;
    }
    public function index(Request $request)
    {
        $user = $request->user();
        // Obtener snapshot desde servicio (usa caché interna)
        $snapshot = $this->snapshotService->getCachedOrBuild();
        // Flag: hay actualización pendiente (CSV procesado pero sin aplicar en dashboard)
        $pendingUpdateSince = Cache::get('cliente_dashboard_pending_update');
        return view('dashboard.cliente', compact('user', 'snapshot', 'pendingUpdateSince'));
    }

    /**
     * Actualizar manualmente la información del dashboard (bajo demanda).
     */
    public function refresh(Request $request)
    {
        // Refrescar caché bajo demanda (también se refresca desde Admin al subir CSV)
        $this->snapshotService->refreshCache();
        // Limpiar flag de actualización pendiente (ya aplicada)
        Cache::forget('cliente_dashboard_pending_update');
        return redirect()->route('cliente.dashboard')->with('success', 'Información del dashboard actualizada.');
    }

    /**
     * API JSON: Snapshot del dashboard actual (desde caché).
     */
    public function apiSnapshot(Request $request)
    {
        $snapshot = $this->snapshotService->getCachedOrBuild();
        return response()->json($snapshot);
    }

    /**
     * API JSON: Metadatos de estado (actualización pendiente y último build del snapshot).
     */
    public function apiMeta(Request $request)
    {
        $snapshot = $this->snapshotService->getCachedOrBuild();
        return response()->json([
            'pendingUpdateSince' => Cache::get('cliente_dashboard_pending_update'),
            'snapshotUpdatedAt' => $snapshot['updatedAt'] ?? null,
        ]);
    }

    /**
     * Construir el snapshot del dashboard para clientes usando los datos actuales.
     */
    private function buildDashboardSnapshot(): array
    {
        // Lógica tomada de la vista anterior para mantener consistencia
        $todayEval = RiskEvaluation::today() ?? RiskEvaluation::orderBy('evaluation_date', 'desc')->first();
        $map = config('risk.percentages'); // Usar configuración centralizada
        $riskLevel = $todayEval?->risk_level ?? null;
        $latestMonth = null;
        if (!$riskLevel) {
            $latestMonth = MonthlyRiskData::orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->first();
            $riskLevel = $latestMonth?->risk_level ?? 'No procede';
        }
        $riskPercent = $map[$riskLevel] ?? 0;

        $labels = [];
        $series = [];
        $startH = $todayEval?->start_time ? (int) Carbon::parse($todayEval->start_time)->format('H') : null;
        $endH = $todayEval?->end_time ? (int) Carbon::parse($todayEval->end_time)->format('H') : null;
        $hourly = $todayEval?->hourly_data ?? null;
        $low=20; $mid=50; $high=80;
        for ($h=0; $h<24; $h++) {
            $key = sprintf('%02d:00', $h);
            $labels[] = $key;
            if (is_array($hourly) && isset($hourly[$key])) {
                $series[] = (int)$hourly[$key];
            } elseif ($startH!==null && $endH!==null) {
                if ($h < $startH) $series[]=$low;
                elseif ($h == $startH) $series[]=$mid;
                elseif ($h >= $startH+1 && $h <= $endH+1) $series[]=$high;
                elseif ($h == $endH+2) $series[]=$mid;
                else $series[]=$low;
            } else {
                $series[] = $riskPercent;
            }
        }
        $peakFrom = $startH!==null ? sprintf('%02d:00',$startH+1) : null;
        $peakTo = $endH!==null ? sprintf('%02d:00',$endH+1) : null;

        // Datos del mes actual para el calendario (día -> nivel)
        $year = now()->year; $month = now()->month;
        $monthItems = MonthlyRiskData::getMonth($year, $month);
        $monthData = [];
        foreach ($monthItems as $m) {
            $monthData[(int)$m->day] = $m->risk_level; // puede ser null (pendiente)
        }

        return [
            'todayEvalDate' => $todayEval?->evaluation_date ? Carbon::parse($todayEval->evaluation_date)->toDateString() : null,
            'riskLevel' => $riskLevel,
            'riskPercent' => $riskPercent,
            'labels' => $labels,
            'series' => $series,
            'peakFrom' => $peakFrom,
            'peakTo' => $peakTo,
            'hasToday' => $todayEval !== null,
            'hasMonthly' => $monthItems->count() > 0,
            'monthYear' => ['year' => $year, 'month' => $month],
            'monthData' => $monthData,
        ];
    }

    public function reportes(Request $request)
    {
        $user = $request->user();
    // Filtros por rango opcionales: start y end (YYYY-MM-DD)
    $start = $request->query('start');
    $end = $request->query('end');
    $year = (int)($request->query('year', now()->year));
    $month = (int)($request->query('month', now()->month));

        // Construir query base para evaluaciones
        $evalQuery = RiskEvaluation::query();
        if ($start && $end) {
            $evalQuery->whereBetween('evaluation_date', [$start, $end]);
        } else {
            $evalQuery->whereYear('evaluation_date', $year)->whereMonth('evaluation_date', $month);
        }
        $evals = $evalQuery->orderBy('evaluation_date', 'desc')->get()
            ->groupBy(fn($e) => Carbon::parse($e->evaluation_date)->toDateString());

        // Cargar MonthlyRiskData según filtros
        if ($start && $end) {
            $from = Carbon::parse($start); $to = Carbon::parse($end);
            $mr = MonthlyRiskData::query()
                ->where(function($q) use ($from, $to) {
                    $q->whereBetween('year', [$from->year, $to->year]);
                })
                ->get()
                ->filter(function($m) use ($from, $to) {
                    $d = Carbon::create($m->year, $m->month, $m->day);
                    return $d->betweenIncluded($from, $to);
                });
        } else {
            $mr = MonthlyRiskData::getMonth($year, $month);
        }
        $mrMap = [];
        foreach ($mr as $m) {
            $mrMap[Carbon::create($m->year, $m->month, $m->day)->toDateString()] = $m->risk_level;
        }

        // Construir lista de fechas a partir de ambas fuentes
        $dateSet = collect(array_keys($mrMap))
            ->merge($evals->keys())
            ->unique()
            ->sortDesc()
            ->values();

        $items = [];
        foreach ($dateSet as $d) {
            $level = null;
            if (isset($evals[$d]) && $evals[$d]->first()) {
                $level = $evals[$d]->first()->risk_level;
            }
            if (!$level && isset($mrMap[$d])) {
                $level = $mrMap[$d];
            }
            $items[] = ['date' => $d, 'risk_level' => $level ?? 'No procede'];
        }

    return view('cliente.reportes.index', compact('user', 'year', 'month', 'items', 'start', 'end'));
    }

    public function show(Request $request, string $fecha)
    {
        $user = $request->user();
        $date = Carbon::parse($fecha)->startOfDay();
        $eval = RiskEvaluation::whereDate('evaluation_date', $date)->first();

        // Calcular variables para la vista
        $map = config('risk.percentages');
        $riskLevel = $eval?->risk_level;
        $mrd = null;
        if (!$riskLevel) {
            $mrd = MonthlyRiskData::where('year', $date->year)
                ->where('month', $date->month)
                ->where('day', $date->day)
                ->first();
            $riskLevel = $mrd?->risk_level ?? 'No procede';
        }
        $riskPercent = $map[$riskLevel] ?? 0;
        $hasData = ($eval !== null) || ($mrd !== null);

        // Serie horaria 17..23
        $labels = [];
        $series = [];
        $startH = $eval?->start_time ? (int)Carbon::parse($eval->start_time)->format('H') : null;
        $endH = $eval?->end_time ? (int)Carbon::parse($eval->end_time)->format('H') : null;
        $hourly = $eval?->hourly_data ?? null;
        $low=20; $mid=50; $high=80;
        for ($h=17; $h<=23; $h++) {
            $key = sprintf('%02d:00', $h);
            $labels[] = $key;
            if (is_array($hourly) && isset($hourly[$key])) {
                $series[] = (int)$hourly[$key];
            } elseif ($startH!==null && $endH!==null) {
                if ($h < $startH) $series[]=$low;
                elseif ($h == $startH) $series[]=$mid;
                elseif ($h >= $startH+1 && $h <= $endH+1) $series[]=$high;
                elseif ($h == $endH+2) $series[]=$mid;
                else $series[]=$low;
            } else {
                $series[] = $riskPercent;
            }
        }
        $peakFrom = $startH!==null ? sprintf('%02d:00',$startH+1) : null;
        $peakTo = $endH!==null ? sprintf('%02d:00',$endH+1) : null;

        return view('cliente.reportes.show', [
            'user' => $user,
            'fecha' => $date->toDateString(),
            'riskLevel' => $riskLevel,
            'riskPercent' => $riskPercent,
            'labels' => $labels,
            'series' => $series,
            'peakFrom' => $peakFrom,
            'peakTo' => $peakTo,
            'hasData' => $hasData,
        ]);
    }

    public function exportDashboardPdf(Request $request)
    {
        $date = now()->startOfDay();
        $eval = RiskEvaluation::whereDate('evaluation_date', $date)->first();
        $map = config('risk.percentages');
        $riskLevel = $eval?->risk_level ?? 'No procede';
        $riskPercent = $map[$riskLevel] ?? 0;

        // Construir filas 00..23
        $rows = [];
        $hourly = $eval?->hourly_data ?? null;
        $startH = $eval?->start_time ? (int)Carbon::parse($eval->start_time)->format('H') : null;
        $endH = $eval?->end_time ? (int)Carbon::parse($eval->end_time)->format('H') : null;
        $low=20; $mid=50; $high=80;
        for ($h=0; $h<24; $h++) {
            $key = sprintf('%02d:00', $h);
            if (is_array($hourly) && isset($hourly[$key])) {
                $val = (int)$hourly[$key];
            } elseif ($startH!==null && $endH!==null) {
                if ($h < $startH) $val=$low;
                elseif ($h == $startH) $val=$mid;
                elseif ($h >= $startH+1 && $h <= $endH+1) $val=$high;
                elseif ($h == $endH+2) $val=$mid;
                else $val=$low;
            } else {
                $val = $riskPercent;
            }
            $rows[] = [$key, $val, $riskLevel];
        }

        // Render PDF usando dompdf
        $html = view('export.dashboard_pdf', [
            'fecha' => $date->toDateString(),
            'riskLevel' => $riskLevel,
            'riskPercent' => $riskPercent,
            'rows' => $rows,
        ])->render();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="dashboard_'.now()->toDateString().'.pdf"'
        ]);
    }

    /**
     * Recibir el dataURL PNG del gráfico del dashboard y guardarlo.
     */
    public function exportDashboardPng(Request $request)
    {
        $dataUrl = $request->input('image');
        if (!$dataUrl || !str_starts_with($dataUrl, 'data:image/png;base64,')) {
            return response()->json(['error' => 'Formato inválido'], 422);
        }
        $pngData = base64_decode(explode(',', $dataUrl, 2)[1]);
        $path = 'exports/dashboard_'.now()->format('Ymd').'.png';
        Storage::disk('local')->put($path, $pngData);
        return response()->json(['saved' => true, 'path' => $path]);
    }

    /**
     * Recibir el dataURL PNG de un día específico y guardarlo.
     */
    public function exportDayPng(Request $request, string $fecha)
    {
        $dataUrl = $request->input('image');
        if (!$dataUrl || !str_starts_with($dataUrl, 'data:image/png;base64,')) {
            return response()->json(['error' => 'Formato inválido'], 422);
        }
        $pngData = base64_decode(explode(',', $dataUrl, 2)[1]);
        $path = 'exports/reporte_'.$fecha.'.png';
        Storage::disk('local')->put($path, $pngData);
        return response()->json(['saved' => true, 'path' => $path]);
    }

    /**
     * Exportar PDF del día con caché en storage/app/exports.
     */
    public function exportDayPdf(Request $request, string $fecha)
    {
        $date = Carbon::parse($fecha)->startOfDay();
        $cachePath = 'exports/reporte_'.$date->toDateString().'.pdf';
        if (Storage::disk('local')->exists($cachePath)) {
            return response(Storage::disk('local')->get($cachePath), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="reporte_'.$date->toDateString().'.pdf"'
            ]);
        }

        $eval = RiskEvaluation::whereDate('evaluation_date', $date)->first();
        $map = config('risk.percentages');
        $riskLevel = $eval?->risk_level ?? 'No procede';
        $riskPercent = $map[$riskLevel] ?? 0;

        $rows = [];
        $hourly = $eval?->hourly_data ?? null;
        $startH = $eval?->start_time ? (int)Carbon::parse($eval->start_time)->format('H') : null;
        $endH = $eval?->end_time ? (int)Carbon::parse($eval->end_time)->format('H') : null;
        $low=20; $mid=50; $high=80;
        for ($h=0; $h<24; $h++) {
            $key = sprintf('%02d:00', $h);
            if (is_array($hourly) && isset($hourly[$key])) {
                $val = (int)$hourly[$key];
            } elseif ($startH!==null && $endH!==null) {
                if ($h < $startH) $val=$low;
                elseif ($h == $startH) $val=$mid;
                elseif ($h >= $startH+1 && $h <= $endH+1) $val=$high;
                elseif ($h == $endH+2) $val=$mid;
                else $val=$low;
            } else {
                $val = $riskPercent;
            }
            $rows[] = [$key, $val, $riskLevel];
        }

        $html = view('export.dashboard_pdf', [
            'fecha' => $date->toDateString(),
            'riskLevel' => $riskLevel,
            'riskPercent' => $riskPercent,
            'rows' => $rows,
        ])->render();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdf = $dompdf->output();

        Storage::disk('local')->put($cachePath, $pdf);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reporte_'.$date->toDateString().'.pdf"'
        ]);
    }

    public function exportCsv(Request $request, string $fecha)
    {
        $date = Carbon::parse($fecha)->startOfDay();
        $eval = RiskEvaluation::whereDate('evaluation_date', $date)->first();
        $map = config('risk.percentages');
        $riskLevel = $eval?->risk_level ?? 'No procede';
        $riskPercent = $map[$riskLevel] ?? 0;

        $rows = [];
        $rows[] = ['Hora','Porcentaje','Nivel'];
        $hourly = $eval?->hourly_data ?? null;
        $startH = $eval?->start_time ? (int)Carbon::parse($eval->start_time)->format('H') : null;
        $endH = $eval?->end_time ? (int)Carbon::parse($eval->end_time)->format('H') : null;
        $low=20; $mid=50; $high=80;
        for ($h=0; $h<24; $h++) {
            $key = sprintf('%02d:00', $h);
            if (is_array($hourly) && isset($hourly[$key])) {
                $val = (int)$hourly[$key];
            } elseif ($startH!==null && $endH!==null) {
                if ($h < $startH) $val=$low;
                elseif ($h == $startH) $val=$mid;
                elseif ($h >= $startH+1 && $h <= $endH+1) $val=$high;
                elseif ($h == $endH+2) $val=$mid;
                else $val=$low;
            } else {
                $val = $riskPercent;
            }
            $rows[] = [$key, $val, $riskLevel];
        }

        $callback = function() use ($rows) {
            $FH = fopen('php://output', 'w');
            foreach ($rows as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        $filename = 'riesgo_'.$date->toDateString().'.csv';
        return Response::streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
