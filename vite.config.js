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
        rollupOptions: {
            output: {
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]'
            }
        }
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
