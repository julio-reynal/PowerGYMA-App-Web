@props([
  'title' => 'Acciones rápidas',
  'actions' => [], // cada acción: ['text'=>string, 'url'=>string, 'method'=>'GET'|'POST']
])
@php($compId = 'qa_'.uniqid())
<div class="card" role="region" aria-labelledby="{{ $compId }}_title" style="padding:1rem;border:1px solid var(--border-soft);border-radius:12px;background:var(--panel);">
  <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.5rem;">
    <span id="{{ $compId }}_title" style="font-weight:600;">{{ $title }}</span>
  </div>
  @if(empty($actions))
    <div class="text-muted">No hay acciones disponibles.</div>
  @else
    <nav aria-label="Acciones rápidas">
    <div style="display:flex;flex-wrap:wrap;gap:.5rem;">
      @foreach($actions as $a)
        @php($method = strtoupper($a['method'] ?? 'GET'))
        @if($method === 'POST')
          <form method="POST" action="{{ $a['url'] ?? '#' }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn" title="{{ $a['text'] }}">{{ $a['text'] }}</button>
          </form>
        @else
          <a class="btn" href="{{ $a['url'] ?? '#' }}" title="{{ $a['text'] }}">{{ $a['text'] }}</a>
        @endif
      @endforeach
    </div>
    </nav>
  @endif
</div>
