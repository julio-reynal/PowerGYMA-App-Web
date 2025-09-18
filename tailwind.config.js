/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/**/*.html",
        "./app/**/*.php", // Incluir archivos PHP del app
    ],
    darkMode: 'class', // Importante: configurar dark mode como 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
    // Optimizaciones de rendimiento
    corePlugins: {
        // Deshabilitar plugins no utilizados para reducir tamaño
        preflight: true,
        container: true,
        accessibility: false, // Solo si no usas clases de accesibilidad
        backgroundOpacity: true,
        borderOpacity: true,
        textOpacity: true,
        placeholderOpacity: true,
        divideOpacity: true,
    },
    // Purgar CSS no utilizado más agresivamente
    safelist: [
        // Mantener clases críticas que se generan dinámicamente
        'dark',
        'bg-white',
        'bg-gray-900',
        'text-gray-900',
        'text-white',
        /^bg-(red|green|blue|yellow|indigo|purple|pink)-(100|200|300|400|500|600|700|800|900)$/,
        /^text-(red|green|blue|yellow|indigo|purple|pink)-(100|200|300|400|500|600|700|800|900)$/,
    ]
}