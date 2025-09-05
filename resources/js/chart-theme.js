/* Chart.js dark theme and risk palette helpers */
(function(){
  const palette = {
    text: '#9CA3AF',
    grid: 'rgba(255,255,255,.06)',
    border: 'rgba(255,255,255,.08)',
    tooltipBg: '#1F2937',
    tooltipBorder: 'rgba(255,255,255,.12)',
    font: "Inter, system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif",
    accent: '#FA8C16',
    risk: {
      low: '#22C55E',
      low200: '#4ADE80',
      medium: '#EAB308',
      medium200: '#FACC15',
      high: '#FA8C16',
      critical: '#EF4444',
      gray: '#6B7280'
    }
  };

  function applyTheme(){
    if (!window.Chart) return;
    const C = window.Chart;
    C.defaults.color = palette.text;
    C.defaults.font.family = palette.font;
    C.defaults.borderColor = palette.border;
    C.defaults.responsive = true;

    // Scales
    C.defaults.scale.grid.color = palette.grid;
    C.defaults.scale.ticks.color = palette.text;

    // Elements
    C.defaults.elements.line.borderWidth = 2;
    C.defaults.elements.point.radius = 3;

    // Plugins
    C.defaults.plugins.legend.labels.color = palette.text;
    C.defaults.plugins.tooltip.backgroundColor = palette.tooltipBg;
    C.defaults.plugins.tooltip.titleColor = '#FFFFFF';
    C.defaults.plugins.tooltip.bodyColor = palette.text;
    C.defaults.plugins.tooltip.borderColor = palette.tooltipBorder;
    C.defaults.plugins.tooltip.borderWidth = 1;
  }

  // Expose helpers
  window.applyChartDarkTheme = function(){ try { applyTheme(); } catch(_){} };
  window.RISK_PALETTE = palette.risk;
  window.ACCENT_COLOR = palette.accent;

  // Try to apply on DOM ready if Chart is already present
  document.addEventListener('DOMContentLoaded', function(){ if (window.Chart) applyTheme(); });
})();
