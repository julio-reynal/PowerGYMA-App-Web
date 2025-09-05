<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reporte del día - Cliente</title>
  <style>
    body{font-family:system-ui, sans-serif; background:#f8fafc; color:#0f172a; margin:0}
    .container{max-width:1000px;margin:2rem auto;padding:0 1.25rem}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:1.5rem}
    a{color:#1d4ed8;text-decoration:none}
  </style>
</head>
<body>
<div class="container">
  <div class="card">
    <h1 style="margin-top:0">Detalle del Día: {{ $fecha }}</h1>
    <p>Resumen: Riesgo {{ $riskLevel ?? 'N/D' }} ({{ $riskPercent ?? 0 }}%).</p>
    @if(isset($hasData) && !$hasData)
      <div style="padding:.75rem; background:#fef2f2; color:#991b1b; border:1px solid #fecaca; border-radius:6px; margin-bottom:1rem;">
        No hay datos registrados para esta fecha.
      </div>
    @endif

    <div style="margin:1rem 0;padding:1rem;border:1px solid #e5e7eb;border-radius:8px;">
      <div style="font-weight:600;margin-bottom:.5rem;">Medidor de Riesgo</div>
      <?php 
        $cx=200; $cy=200; $needle=140; 
        $theta = deg2rad(-180 + ($riskPercent ?? 0)*1.8);
        $nx = $cx + cos($theta)*$needle;
        $ny = $cy + sin($theta)*$needle;
      ?>
      <svg width="400" height="220" viewBox="0 0 400 220" aria-label="Medidor de riesgo">
        <path d="M 40 200 A 160 160 0 0 1 360 200" fill="none" stroke="#e5e7eb" stroke-width="22" stroke-linecap="round" />
        <path d="M 40 200 A 160 160 0 0 1 70.56 105.95" fill="none" stroke="#10B981" stroke-width="22" stroke-linecap="round"/>
        <path d="M 70.56 105.95 A 160 160 0 0 1 200 40" fill="none" stroke="#F59E0B" stroke-width="22" stroke-linecap="round"/>
        <path d="M 200 40 A 160 160 0 0 1 294.05 70.56" fill="none" stroke="#F97316" stroke-width="22" stroke-linecap="round"/>
        <path d="M 294.05 70.56 A 160 160 0 0 1 360 200" fill="none" stroke="#EF4444" stroke-width="22" stroke-linecap="round"/>
        <line x1="200" y1="200" x2="{{ $nx }}" y2="{{ $ny }}" stroke="#111827" stroke-width="3" />
        <circle cx="200" cy="200" r="6" fill="#111827" />
      </svg>
    </div>

    <div style="margin:1rem 0;padding:1rem;border:1px solid #e5e7eb;border-radius:8px;">
      <div style="font-weight:600;margin-bottom:.5rem;">Evolución (17:00–23:00)</div>
      <canvas id="riskLine"></canvas>
      <div style="margin-top:.5rem;">
        <button id="btnExportDayPng" style="padding:.5rem 1rem;border:1px solid #cbd5e1;border-radius:6px;background:#e2e8f0;">Exportar PNG</button>
        <a href="{{ route('cliente.reportes.pdf', $fecha) }}" style="margin-left:.5rem;">Exportar PDF (cache)</a>
      </div>
    </div>

    <p>
      <a href="{{ route('cliente.reportes.csv', $fecha) }}">Descargar CSV del día</a>
      &nbsp;|&nbsp;
      <a href="{{ route('cliente.reportes') }}">Volver al listado</a>
    </p>
  </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script>
    const ctx = document.getElementById('riskLine');
    let chartDay;
    if (ctx) {
      chartDay = new Chart(ctx, {
        type: 'line',
        data: {
          labels: @json($labels ?? []),
          datasets: [{
            label: 'Nivel de Riesgo',
            data: @json($series ?? []),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,.2)',
            tension: .3,
            fill: true,
            pointRadius: 3,
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true, suggestedMax: 100, ticks: { callback: v => v + '%' } }
          },
          plugins: { legend: { display: false } }
        }
      });
    }

    const btnDay = document.getElementById('btnExportDayPng');
    if (btnDay && ctx) {
      btnDay.addEventListener('click', async () => {
        try {
          const url = ctx.toDataURL('image/png');
          const res = await fetch("{{ route('cliente.reportes.png', $fecha) }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ image: url })
          });
          const data = await res.json();
          if (data.saved) alert('PNG guardado en storage/app/' + data.path);
          else alert('No se pudo guardar PNG');
        } catch (e) { alert('Error exportando PNG'); }
      });
    }
  </script>
</body>
</html>
