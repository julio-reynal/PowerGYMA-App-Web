<?php
return [
    // Mapping of risk levels to percentages used in gauge and evolution baselines
    'percentages' => [
        'Muy Bajo'   => 10,  // Muy bajo empieza desde 10%
        'Bajo'       => 20,  // Bajo = 20% (CORREGIDO según solicitud)
        'Moderado'   => 50,  // Moderado = 50%
        'Alto'       => 80,  // Alto = 80% (CORREGIDO según solicitud)
        'Crítico'    => 95,  // Crítico = 95% (máximo)
        'No procede' => 0,   // Sin riesgo = 0%
    ],

    // Hex colors for UI usage (cards, dots, calendar, legends)
    'colors' => [
        'Muy Bajo'   => '#22C55E',
        'Bajo'       => '#22C55E',
        'Moderado'   => '#EAB308',
        'Alto'       => '#FA8C16',
        'Crítico'    => '#EF4444',
        'No procede' => '#6B7280',
    ],

    // Order for sorting or comparison if needed
    'order' => [
        'Muy Bajo'   => 1,
        'Bajo'       => 2,
        'Moderado'   => 3,
        'Alto'       => 4,
        'Crítico'    => 5,
        'No procede' => 0,
    ],

    'labels' => ['Muy Bajo', 'Bajo', 'Moderado', 'Alto', 'Crítico', 'No procede'],
];
