import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/assets/stylesheets/app.scss', 'resources/assets/js/App.ts'],
            refresh: true,
        }),
    ],
});