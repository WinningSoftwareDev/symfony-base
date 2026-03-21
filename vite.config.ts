import { defineConfig } from 'vite';
import vuePlugin from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import * as fs from 'node:fs';

export default defineConfig({
    base: './',
    publicDir: false,
    plugins: [vuePlugin({}), tailwindcss()],
    build: {
        outDir: './public/assets',
        emptyOutDir: true,
        rolldownOptions: {
            input: './assets/scripts/app.ts',
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`,
            }
        }
    },
    server: {
        host: '0.0.0.0',
        port: 3000,
        strictPort: true,
        https: {
            key: fs.readFileSync('/etc/nginx/certs/revue.key'),
            cert: fs.readFileSync('/etc/nginx/certs/revue.crt'),
        },
        cors: true,
        watch: {
            usePolling: true,
        },
        hmr: {
            host: 'revue.app',
            protocol: 'wss',
            clientPort: 3000
        }
    }
});