import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'Modules/**/Resources/assets/css/module.css',
                'Modules/**/Resources/assets/js/module.js',
            ],
            refresh: true,
        }),
    ],
});
