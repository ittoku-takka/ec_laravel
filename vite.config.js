import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',   // ← Tailwind 用 CSS に変更
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});