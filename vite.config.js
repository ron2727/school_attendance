import { defineConfig } from 'vite';
import vue from "@vitejs/plugin-vue"; 
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        vue({
            template: {
              compilerOptions: {
                isCustomElement: (tag) => ['box-icon'].includes(tag),
              }
            }
          }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
