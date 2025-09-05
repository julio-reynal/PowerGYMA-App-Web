<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard - PDF</title>
  <style>
    body{ font-family: DejaVu Sans, sans-serif; color:#111827; }
    .h1{ font-size:22px; font-weight:700; margin-bottom:6px; }
    .muted{ color:#6b7280; font-size:12px; }
    .section{ margin:14px 0; padding:10px; border:1px solid #e5e7eb; border-radius:6px; }
    table{ width:100%; border-collapse:collapse; }
    th, td{ border:1px solid #e5e7eb; padding:6px; font-size:12px; }
    th{ background:#f3f4f6; text-align:left; }
  </style>
  </head>
<body>
  <div class="h1">Power GYMA - Dashboard</div>
  <div class="muted">Fecha: {{ $fecha }} | Riesgo: {{ $riskLevel }} ({{ $riskPercent }}%)</div>

  <div class="section">
    <div style="font-weight:600; margin-bottom:6px;">Serie Horaria (00:00–23:00)</div>
    <table>
      <thead>
        <tr><th>Hora</th><th>Porcentaje</th><th>Nivel</th></tr>
      </thead>
      <tbody>
        @foreach($rows as $r)
          <tr>
            <td>{{ $r[0] }}</td>
            <td>{{ $r[1] }}%</td>
            <td>{{ $r[2] }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="muted">Generado automáticamente por el sistema.</div>
</body>
</html>
