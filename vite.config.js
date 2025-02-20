import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue()
    ],
    server: {
        host: '127.0.0.1'
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "noty/src/noty.scss"; @import "noty/src/themes/mint.scss";`
            }
        }
    }
});
