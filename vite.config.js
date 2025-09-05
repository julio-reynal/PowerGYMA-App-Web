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
                // Dashboard dark theme assets
                'resources/css/dashboard.css',
                'resources/js/chart-theme.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
