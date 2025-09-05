<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Test Dashboard Data</title>
    <style>
        body { font-family: system-ui; margin: 2rem; }
        .section { margin: 2rem 0; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; }
        .risk-high { background: #fee2e2; }
        .risk-medium { background: #fef3c7; }
        .risk-low { background: #dcfce7; }
        .risk-none { background: #f1f5f9; }
    </style>
</head>
<body>
    <h1>🔍 Test Dashboard Data</h1>
    <p><strong>Fecha actual:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>

    <?php 
        use Carbon\Carbon; 
        $todayEval = \App\Models\RiskEvaluation::today() ?? \App\Models\RiskEvaluation::orderBy('evaluation_date','desc')->first();
        $map = config('risk.percentages');
        $riskLevel = $todayEval?->risk_level ?? null;
        if (!$riskLevel) {
            $latestMonth = \App\Models\MonthlyRiskData::orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->first();
            $riskLevel = $latestMonth?->risk_level ?? 'No procede';
        }
        $riskPercent = $map[$riskLevel] ?? 0;
        
        $riskClass = match($riskLevel) {
            'Alto', 'Crítico' => 'risk-high',
            'Moderado' => 'risk-medium', 
            'Bajo', 'Muy Bajo' => 'risk-low',
            default => 'risk-none'
        };
    ?>

    <div class="section {{ $riskClass }}">
        <h2>📊 Dashboard Result</h2>
        <p><strong>Nivel de Riesgo:</strong> {{ $riskLevel }}</p>
        <p><strong>Porcentaje:</strong> {{ $riskPercent }}%</p>
    </div>

    <div class="section">
        <h2>📅 Evaluación del Día Actual</h2>
        @if($todayEval)
            <p><strong>Fecha:</strong> {{ $todayEval->evaluation_date->format('Y-m-d') }}</p>
            <p><strong>Nivel:</strong> {{ $todayEval->risk_level }}</p>
            <p><strong>Horario:</strong> {{ $todayEval->start_time }} - {{ $todayEval->end_time }}</p>
        @else
            <p>❌ No hay evaluación para hoy</p>
        @endif
    </div>

    <div class="section">
        <h2>📈 Últimos Datos Mensuales</h2>
        <?php $recentMonthly = \App\Models\MonthlyRiskData::orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->take(5)->get(); ?>
        
        @foreach($recentMonthly as $data)
            <p>{{ $data->year }}-{{ $data->month }}-{{ $data->day }}: <strong>{{ $data->risk_level }}</strong> ({{ $data->status }})</p>
        @endforeach
    </div>

    <div class="section">
        <h2>📊 Calendario de Agosto 2025</h2>
        <?php $augustData = \App\Models\MonthlyRiskData::where('year', 2025)->where('month', 8)->orderBy('day')->get(); ?>
        
        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.5rem; margin-top: 1rem;">
            @foreach($augustData as $day)
                <?php 
                    $dayClass = match($day->risk_level) {
                        'Alto', 'Crítico' => 'risk-high',
                        'Moderado' => 'risk-medium', 
                        'Bajo', 'Muy Bajo' => 'risk-low',
                        default => 'risk-none'
                    };
                ?>
                <div style="padding: 0.5rem; text-align: center; border: 1px solid #ddd; border-radius: 4px;" class="{{ $dayClass }}">
                    <div style="font-weight: bold;">{{ $day->day }}</div>
                    <div style="font-size: 0.8rem;">{{ $day->risk_level }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section">
        <h2>🔄 Última Actualización</h2>
        <?php $lastUpload = \App\Models\ExcelUpload::latest()->first(); ?>
        
        @if($lastUpload)
            <p><strong>Archivo:</strong> {{ $lastUpload->file_name }}</p>
            <p><strong>Fecha:</strong> {{ $lastUpload->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>Estado:</strong> {{ $lastUpload->status }}</p>
        @else
            <p>❌ No hay uploads registrados</p>
        @endif
    </div>

    <div style="margin-top: 2rem;">
        <a href="{{ route('cliente.dashboard') }}" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">Ver Dashboard Cliente</a>
        <a href="{{ route('demo.dashboard') }}" style="background: #10b981; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; margin-left: 0.5rem;">Ver Dashboard Demo</a>
    </div>
</body>
</html>
