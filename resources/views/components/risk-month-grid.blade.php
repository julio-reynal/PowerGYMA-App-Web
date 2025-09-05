@props(['monthData' => null, 'elementId' => 'monthGrid'])
@php($colors = config('risk.colors'))
<div id="{{ $elementId }}" style="display:grid;grid-template-columns:repeat(7,1fr);gap:.5rem;" role="grid" aria-label="Riesgo del mes">
  @for($d=1; $d<=31; $d++)
    @php(
      $level = is_array($monthData)
        ? ($monthData[$d] ?? null)
        : (method_exists($monthData, 'firstWhere') ? optional($monthData->firstWhere('day', $d))->risk_level : null)
    )
    @if($level)
      <div id="{{ $elementId }}-day-{{ $d }}" data-day="{{ $d }}" data-level="{{ $level }}" role="gridcell" aria-label="Día {{ $d }}: {{ $level }}" style="padding:.75rem;border:1px solid var(--border-subtle);border-radius:6px;background:{{ $colors[$level] ?? '#6B7280' }};color:#fff;">
        <div style="font-weight:700;">{{ $d }}</div>
        <div class="level" style="font-size:.9rem;">{{ $level }}</div>
      </div>
    @else
      <div id="{{ $elementId }}-day-{{ $d }}" data-day="{{ $d }}" data-level="" role="gridcell" aria-label="Día {{ $d }}: sin dato" style="padding:.75rem;border:1px solid var(--border-subtle);border-radius:6px;background:#202938;color:#9CA3AF;">
        <div style="font-weight:700;">{{ $d }}</div>
        <div class="level" style="font-size:.9rem;">—</div>
      </div>
    @endif
  @endfor
</div>
