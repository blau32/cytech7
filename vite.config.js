import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/register.css',
                'resources/css/login.css',
                'resources/css/index.css',
                'resources/css/create.css',
                'resources/css/show.css',
                'resources/css/edit.css',
                'resources/css/components.css',
            ],
            refresh: true,
        }),
    ],
});
