import path from 'path';
import { defineConfig, loadEnv } from 'vite';
import vue from "@vitejs/plugin-vue";
import laravel from 'laravel-vite-plugin';

const env = loadEnv('', process.cwd(), '');

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/vue/app.ts'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, './resources/vue'),
        }
    },
    server: {
        proxy: {
            '/api': 'http://127.0.0.1:8000/api'
        }
    },
    env
});
