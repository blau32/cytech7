import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/login.css',
                'resources/css/register.css',
                'resources/css/index.css',
                'resources/css/create.css',
                'resources/css/show.css',
            ],
            refresh: true,
        }),
    ],
});
