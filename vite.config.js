import path from 'path';
import { defineConfig } from 'vite';
import vue from "@vitejs/plugin-vue";
import laravel from 'laravel-vite-plugin';

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
    }
});
