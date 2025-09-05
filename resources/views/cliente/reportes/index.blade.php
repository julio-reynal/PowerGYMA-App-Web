<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reportes - Cliente</title>
  <style>
    body{font-family:system-ui, sans-serif; background:#f8fafc; color:#0f172a; margin:0}
    .container{max-width:1000px;margin:2rem auto;padding:0 1.25rem}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:1.5rem}
    a{color:#1d4ed8;text-decoration:none}
  table{width:100%;border-collapse:collapse;margin-top:1rem}
    th,td{border-bottom:1px solid #e2e8f0;padding:.75rem;text-align:left}
    th{background:#f1f5f9}
    .actions a{margin-right:.75rem}
  </style>
</head>
<body>
<div class="container">
  <div class="card">
  <h1 style="margin-top:0">Reportes de Días Anteriores</h1>
  <p>Mes: {{ sprintf('%04d-%02d', $year, $month) }}</p>
  <form method="GET" action="{{ route('cliente.reportes') }}" style="display:flex; gap:.5rem; align-items:end; margin:.5rem 0 1rem;">
    <div>
      <label for="start" style="display:block;font-size:.9rem;color:#334155;">Desde</label>
      <input type="date" id="start" name="start" value="{{ $start ?? '' }}" />
    </div>
    <div>
      <label for="end" style="display:block;font-size:.9rem;color:#334155;">Hasta</label>
      <input type="date" id="end" name="end" value="{{ $end ?? '' }}" />
    </div>
    <div>
      <button type="submit" style="padding:.5rem 1rem;border:1px solid #cbd5e1;border-radius:6px;background:#e2e8f0;">Filtrar</button>
    </div>
  </form>
    <table>
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Nivel</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $it)
        <tr>
          <td>{{ $it['date'] }}</td>
          <td>{{ $it['risk_level'] }}</td>
          <td class="actions">
            <a href="{{ route('cliente.reportes.show', $it['date']) }}">Ver detalle</a>
            <a href="{{ route('cliente.reportes.csv', $it['date']) }}">Descargar CSV</a>
            <a href="{{ route('cliente.reportes.pdf', $it['date']) }}">Descargar PDF</a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="3">No hay datos disponibles para este mes.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <p style="margin-top:1rem"><a href="{{ route('cliente.dashboard') }}">Volver al dashboard</a></p>
  </div>
</div>
</body>
</html>
