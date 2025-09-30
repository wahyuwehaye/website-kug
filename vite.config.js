import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), 'VITE');

    const devHost = env.VITE_DEV_HOST || '0.0.0.0';
    const devPort = Number(env.VITE_DEV_PORT || 5173);
    const hmrHost = env.VITE_HMR_HOST || 'localhost';
    const hmrProtocol = env.VITE_HMR_PROTOCOL || 'http';

    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                    'resources/css/filament/admin/theme.css',
                ],
                refresh: true,
            }),
        ],
        server: {
            host: devHost,
            port: devPort,
            cors: true,
            hmr: {
                host: hmrHost,
                protocol: hmrProtocol,
                port: devPort,
            },
        },
    };
});
