import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/index.css',
                'resources/js/index.js',
                'resources/css/auth.css',
                'resources/js/auth.js',
                'resources/css/login.css',
                'resources/js/login.js',
                // Main site assets
                'resources/css/main.css',
                'resources/css/components.css',
                'resources/js/main.js',
                'resources/js/components.js',
                'resources/js/contact-form.js',
                // Servicios page assets
                'resources/css/servicios.css',
                'resources/js/servicios.js',
                // Clientes page assets
                'resources/css/clientes.css',
                'resources/js/clientes.js',
                // Contacto page assets
                'resources/css/contacto.css',
                'resources/css/contacto-figma.css',
                'resources/js/contacto-figma.js',
                // Footer component assets
                'resources/css/footer.css',
                // Dashboard dark theme assets
                'resources/css/dashboard.css',
                'resources/js/chart-theme.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        manifest: true,
        // Optimizaciones de rendimiento
        minify: 'terser',
        cssMinify: true,
        sourcemap: false, // Desactivar sourcemaps en producción
        target: 'es2018', // Soporte para navegadores modernos
        rollupOptions: {
            output: {
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]',
                // Optimización de chunks
                manualChunks: {
                    'vendor': ['axios'],
                    'utils': ['resources/js/components.js'],
                }
            },
            // Tree shaking más agresivo
            treeshake: {
                preset: 'smallest',
                moduleSideEffects: false
            }
        },
        // Compresión y optimización adicional
        terserOptions: {
            compress: {
                drop_console: true, // Eliminar console.log en producción
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug', 'console.warn'],
                passes: 2, // Múltiples pasadas de optimización
            },
            mangle: {
                safari10: true,
            },
            format: {
                comments: false, // Eliminar comentarios
            }
        },
        // Optimización de CSS
        cssCodeSplit: true,
        chunkSizeWarningLimit: 1000, // Advertencia para chunks grandes
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    // Optimizaciones adicionales
    optimizeDeps: {
        include: ['axios'],
        esbuildOptions: {
            target: 'es2018'
        }
    },
    esbuild: {
        target: 'es2018',
        legalComments: 'none', // Eliminar comentarios legales
    }
});
