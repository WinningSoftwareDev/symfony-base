import { defineConfig, loadEnv, ViteDevServer } from 'vite';
import vuePlugin from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import * as fs from 'node:fs';
import { fileURLToPath } from 'node:url';

const latteReloadPlugin = {
    name: 'latte-reload',
    configureServer(server: ViteDevServer) {
        server.watcher.add(fileURLToPath(new URL('./templates/**/*/*.latte', import.meta.url)));
        server.watcher.on('change', (path: string) => {
            if (path.endsWith('.latte')) {
                server.ws.send({
                    type: 'full-reload',
                });
            }
        });
    }
}

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return {
        base: './',
        publicDir: false,
        plugins: [vuePlugin({}), tailwindcss(), latteReloadPlugin],
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
            port: parseInt(env.VITE_SERVER_PORT || '3000'),
            strictPort: true,
            hmr: {
                host: 'localhost',
                port: parseInt(env.VITE_LOCAL_PORT || '3000'),
                protocol: 'ws'
            }
        },
        // server: {
        //     host: '0.0.0.0',
        //     port: parseInt(env.VITE_SERVER_PORT || '3000'),
        //     strictPort: true,
        //     https: {
        //         key: fs.readFileSync('/etc/nginx/certs/{APP_NAME}.key'),
        //         cert: fs.readFileSync('/etc/nginx/certs/{APP_NAME}.crt'),
        //     },
        //     cors: true,
        //     watch: {
        //         usePolling: true,
        //     },
        //     hmr: {
        //         host: '{APP_NAME}.app',
        //         protocol: 'wss',
        //         clientPort: parseInt(env.VITE_LOCAL_PORT || '3000')
        //     }
        // }
    }
});