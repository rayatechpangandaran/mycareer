import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/auth/login.css',
                'resources/js/auth/login.js',
                'resources/css/auth/register.css',
                'resources/js/auth/register.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        host: true,
        hmr: {
            protocol: 'wss',
            host: 'unvictorious-nonregeneratively-samara.ngrok-free.dev',
        },
    },
});