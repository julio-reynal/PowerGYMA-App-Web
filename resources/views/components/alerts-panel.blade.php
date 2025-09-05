@props([
  'title' => 'Alertas',
  'alerts' => [], // cada alerta: ['level' => 'info|warning|danger', 'title' => string, 'message' => string, 'time' => string|null]
])
@php
  $color = function($level) {
    return match($level) {
      'danger' => '#EF4444',
      'warning' => '#F59E0B',
      default => '#60A5FA', // info
    };
  };
@endphp
@php($compId = 'al_'.uniqid())
<div class="card" role="region" aria-live="polite" aria-labelledby="{{ $compId }}_title" style="padding:1rem;border:1px solid var(--border-soft);border-radius:12px;background:var(--panel);">
  <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.5rem;">
    <span id="{{ $compId }}_title" style="font-weight:600;">{{ $title }}</span>
  </div>
  @if(empty($alerts))
    <div class="text-muted">Sin alertas activas</div>
  @else
    <ul style="display:flex;flex-direction:column;gap:.5rem;list-style:none;padding:0;margin:0;">
      @foreach($alerts as $a)
        <li style="display:flex;gap:.75rem;align-items:flex-start;padding:.75rem;border:1px solid var(--border-soft);border-radius:10px;background:var(--panel-2);" aria-label="{{ ($a['level'] ?? 'info') }}: {{ $a['title'] ?? 'Notificación' }}">
          <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:{{ $color($a['level'] ?? 'info') }};margin-top:.3rem;"></span>
          <div>
            <div style="font-weight:600;">{{ $a['title'] ?? 'Notificación' }}</div>
            @if(!empty($a['message']))
              <div class="text-muted" style="font-size:.9rem;">{{ $a['message'] }}</div>
            @endif
            @if(!empty($a['time']))
              <div class="text-muted" style="font-size:.8rem;margin-top:.25rem;">{{ $a['time'] }}</div>
            @endif
          </div>
        </li>
      @endforeach
    </ul>
  @endif
</div>
