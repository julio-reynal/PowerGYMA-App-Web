@props([
  'elementId' => 'riskLine',
  'labels' => [],
  'series' => [],
  'datasetLabel' => 'Nivel de Riesgo',
  'yMin' => 0,
  'yMax' => 100,
])

@php($aria = $datasetLabel . ' por hora (00:00–23:00)')
<canvas id="{{ $elementId }}" role="img" aria-label="{{ $aria }}">Evolución del riesgo (gráfico de líneas)</canvas>

<script>
(function() {
  function init() {
    try {
      if (window.applyChartDarkTheme) window.applyChartDarkTheme();
      const el = document.getElementById(@json($elementId));
      if (!el || typeof Chart === 'undefined') return false;
      const chart = new Chart(el, {
        type: 'line',
        data: {
          labels: @json(array_values($labels)),
          datasets: [{
            label: @json($datasetLabel),
            data: @json(array_values($series)),
            borderColor: window.ACCENT_COLOR || '#FA8C16',
            backgroundColor: 'rgba(250,140,22,.2)',
            tension: .3,
            fill: true,
            pointRadius: 3,
          }]
        },
        options: {
          responsive: true,
          scales: { y: { min: @json($yMin), max: @json($yMax), ticks: { callback: v => v + '%' } } },
          plugins: { legend: { display: false } }
        }
      });
      // Exponer instancia globalmente para actualizaciones dinámicas
      el.__chartInstance = chart;
      window.__charts = window.__charts || {};
      window.__charts[@json($elementId)] = chart;
      return true;
    } catch (e) { return false; }
  }
  function ready(fn){ if (document.readyState !== 'loading') fn(); else document.addEventListener('DOMContentLoaded', fn); }
  ready(() => {
    let tries = 0;
    const t = setInterval(() => {
      if (init() || ++tries > 40) clearInterval(t);
    }, 50);
  });
})();
</script>
