/// <reference types="vitest/config" />
import path from 'path';
import { defineConfig } from 'vitest/config'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin';
import { loadEnv } from 'vite';

const env = loadEnv('', process.cwd(), '');

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ['resources/vue/app.ts'],
    }),
  ],
  test: {
    setupFiles: ['vitest-browser-vue'],
    include: [
      'resources/vue/**/*.test.ts',
    ],
    browser: {
      enabled: true,
      headless: false,
      provider: 'playwright',
      name: 'chromium',
    },
    alias: {
      "@": path.resolve(__dirname, './resources/vue'),
    },
    env,
  }
})