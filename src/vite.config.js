import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/stylesheets/app.scss', 'resources/js/App.ts'],
            refresh: true,
        }),
    ],
});