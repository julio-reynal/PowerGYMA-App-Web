@props([
  'title' => 'Ahorro estimado',
  'currency' => '$',
  'monthlySavings' => null, // número o null
  'annualSavings' => null,  // número o null
  'energySavedKwh' => null, // número o null
  'tips' => [],             // array<string>
])
@php
  $fmt = function($n) use ($currency) {
    if ($n === null) return 'N/A';
    return $currency . number_format((float)$n, 2, '.', ',');
  };
  $fmtKwh = function($n) {
    if ($n === null) return 'N/A';
    return number_format((float)$n, 0, '.', ',') . ' kWh';
  };
@endphp
@php($compId = 'sv_'.uniqid())
<div class="card" role="region" aria-labelledby="{{ $compId }}_title" style="padding:1rem;border:1px solid var(--border-soft);border-radius:12px;background:var(--panel);">
  <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.5rem;">
    <span id="{{ $compId }}_title" style="font-weight:600;">{{ $title }}</span>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;">
    <div>
      <div class="text-muted" style="font-size:.85rem;">Mensual</div>
      <div style="font-size:1.15rem;font-weight:700;">{{ $fmt($monthlySavings) }}</div>
    </div>
    <div>
      <div class="text-muted" style="font-size:.85rem;">Anual</div>
      <div style="font-size:1.15rem;font-weight:700;">{{ $fmt($annualSavings) }}</div>
    </div>
    <div>
      <div class="text-muted" style="font-size:.85rem;">Energía ahorrada</div>
      <div style="font-size:1.15rem;font-weight:700;">{{ $fmtKwh($energySavedKwh) }}</div>
    </div>
  </div>
  @if(!empty($tips))
    <ul style="margin-top:1rem;color:var(--text-muted);padding-left:1rem;list-style:disc;">
      @foreach($tips as $t)
        <li>{{ $t }}</li>
      @endforeach
    </ul>
  @endif
</div>
