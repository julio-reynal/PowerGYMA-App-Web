<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Mostrar la página principal de casos de éxito de clientes
     */
    public function index()
    {
        // Datos de los casos de éxito
        $casosExito = [
            [
                'id' => 1,
                'sector' => 'Sector Industrial',
                'titulo' => 'Reducción del 30% en costos energéticos',
                'desafio' => 'Una planta industrial con altos consumos en horas punta y penalizaciones por factor de potencia buscaba reducir sus costos operativos sin afectar la producción.',
                'solucion' => 'Implementamos un sistema inteligente de monitoreo en tiempo real con algoritmos predictivos que optimizan el consumo según las necesidades de producción, junto con un banco de capacitores automáticos para corregir el factor de potencia.',
                'resultado_descripcion' => 'La implementación logró una reducción significativa en costos y mejoró la eficiencia operativa.',
                'resultado_porcentaje' => '30%',
                'resultado_texto' => 'Reducción de costos',
                'resultado_monto' => '300k',
                'resultado_monto_texto' => 'Dólares de Ahorro en el 2024',
                'resultado_circular' => '-30%',
                'logo_cliente' => null
            ],
            [
                'id' => 2,
                'sector' => 'Sector Retail',
                'titulo' => '40% de ahorro en climatización',
                'desafio' => 'Una cadena de tiendas con altos costos en climatización necesitaba mantener el confort térmico para clientes mientras reducía su huella energética y costos operativos.',
                'solucion' => 'Instalamos un sistema de control inteligente con sensores IoT que ajusta automáticamente la climatización según la ocupación, condiciones externas y horarios, complementado con un análisis predictivo de consumo.',
                'resultado_descripcion' => 'Optimización significativa del sistema de climatización manteniendo los niveles de confort.',
                'resultado_porcentaje' => '40%',
                'resultado_texto' => 'Ahorro energético',
                'resultado_monto' => '6',
                'resultado_monto_texto' => 'Meses de ROI',
                'resultado_extra' => '28%',
                'resultado_extra_texto' => 'Menos mantenimiento',
                'resultado_circular' => '-40%',
                'logo_cliente' => null
            ]
        ];

        // Testimonios
        $testimonios = [
            [
                'texto' => 'Gracias a POWERGYMA, reducimos nuestros costos de energía en un 30% en el primer año. Su sistema de predicción nos permite planificar nuestra producción de manera mucho más eficiente.',
                'autor' => 'Elihai, Director',
                'empresa' => 'FISA',
                'logo' => 'f59f86aaa76bd4c34cb4c9d0224a69fb706e596f.png'
            ]
        ];

        // Estadísticas generales
        $estadisticas = [
            'ahorro_promedio' => '30%',
            'empresas_confian' => '200+'
        ];

        // Beneficios
        $beneficios = [
            [
                'icono' => 'f8104ead69904ccbdb00a5d5af89510f7bd0c280.svg',
                'titulo' => 'Ahorro Garantizado',
                'descripcion' => 'Resultados medibles en reducción de costes energéticos'
            ],
            [
                'icono' => '12490fea1aba40e94e3508d05460e33a1f56bafb.svg',
                'titulo' => 'Tecnología de Precisión',
                'descripcion' => 'Sistemas de monitoreo y gestión con IA avanzada'
            ],
            [
                'icono' => '58d2af4f2a5d8c65e9d6bb843133a6ed323d76e5.svg',
                'titulo' => 'Asesoría Estratégica',
                'descripcion' => 'Consultoría especializada para tu sector específico'
            ],
            [
                'icono' => '8e207c308db4ee0bce00e0d0aa9ff20b6da868d1.svg',
                'titulo' => 'Implementación Rápida',
                'descripcion' => 'Mínima interrupción en tus operaciones diarias'
            ]
        ];

        return view('clientes.index', compact('casosExito', 'testimonios', 'estadisticas', 'beneficios'));
    }
}