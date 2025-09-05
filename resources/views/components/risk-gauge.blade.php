@props(['riskPercent' => 0, 'riskLevel' => 'No procede', 'todayEvalDate' => null, 'peakFrom' => null, 'peakTo' => null, 'elementId' => 'riskGauge'])
@php(
    $riskPercent = (int)($riskPercent ?? 0)
)
<div class="gauge-wrapper" id="{{ $elementId }}">
    @php($ariaGauge = 'Medidor de riesgo: ' . ($riskLevel ?? 'N/A') . (($peakFrom && $peakTo) ? ('. Hora de mayor riesgo: ' . $peakFrom . ' a ' . $peakTo) : ''))
    <svg id="{{ $elementId }}-svg" class="gauge-svg" width="400" height="220" viewBox="0 0 400 220" role="img" aria-label="{{ $ariaGauge }}">
        <!-- Fondo del arco -->
        <path d="M 40 200 A 160 160 0 0 1 360 200" fill="none" stroke="#e5e7eb" stroke-width="22" stroke-linecap="round" />
        <!-- Segmentos de color -->
        <path d="M 40 200 A 160 160 0 0 1 70.56 105.95" fill="none" stroke="#10B981" stroke-width="22" stroke-linecap="round"/>
        <path d="M 70.56 105.95 A 160 160 0 0 1 200 40" fill="none" stroke="#F59E0B" stroke-width="22" stroke-linecap="round"/>
        <path d="M 200 40 A 160 160 0 0 1 294.05 70.56" fill="none" stroke="#F97316" stroke-width="22" stroke-linecap="round"/>
        <path d="M 294.05 70.56 A 160 160 0 0 1 360 200" fill="none" stroke="#EF4444" stroke-width="22" stroke-linecap="round"/>
        <!-- Aguja -->
        <line id="{{ $elementId }}-needle" x1="200" y1="200"
              x2="{{ 200 + cos(deg2rad(-180 + ((int)($riskPercent ?? 0)) * 1.8)) * 140 }}"
              y2="{{ 200 + sin(deg2rad(-180 + ((int)($riskPercent ?? 0)) * 1.8)) * 140 }}"
              stroke="#111827" stroke-width="3" />
        <circle cx="200" cy="200" r="6" fill="#111827" />
        <!-- Marcas LOW/HIGH -->
        <text x="40" y="210" font-size="10" fill="#64748b">LOW</text>
        <text x="350" y="210" text-anchor="end" font-size="10" fill="#64748b">HIGH</text>
    </svg>
    <div style="margin-top:.5rem;font-weight:700;">RISK <span id="{{ $elementId }}-label" style="margin-left:.5rem;">{{ $riskLevel }}</span></div>
    <div id="{{ $elementId }}-date" style="margin-top:.25rem;color:#64748b;">
        @if(!empty($todayEvalDate))
            Fecha: {{ \Carbon\Carbon::parse($todayEvalDate)->format('d/m/Y') }}
        @endif
    </div>
    <div class="gauge-legend">
        <span><span class="legend-dot" style="background:#10B981"></span>Muy Bajo 10%</span>
        <span><span class="legend-dot" style="background:#10B981"></span>Bajo 20%</span>
        <span><span class="legend-dot" style="background:#F59E0B"></span>Moderado 50%</span>
        <span><span class="legend-dot" style="background:#F97316"></span>Alto 80%</span>
        <span><span class="legend-dot" style="background:#EF4444"></span>Crítico 95%</span>
    </div>
    <div id="{{ $elementId }}-peak" style="color:#f59e0b;font-weight:800;margin-top:.75rem;">
        @if($peakFrom && $peakTo)
            HORA DE MAYOR RIESGO: {{ $peakFrom }} A {{ $peakTo }}
        @endif
    </div>
</div>
