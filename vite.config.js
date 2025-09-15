import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js'
            ],
            refresh: [
                'resources/**',
                'app/**',
                'routes/**',
                'config/**',
                '.env',
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
                compilerOptions: {
                    isCustomElement: (tag) => ['md-linedivider'].includes(tag),
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': resolve(__dirname, 'resources/js'),
            '@css': resolve(__dirname, 'resources/css'),
            '@components': resolve(__dirname, 'resources/js/components'),
            '@views': resolve(__dirname, 'resources/js/views'),
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: (id) => {
                    if (id.includes('node_modules')) {
                        if (id.includes('vue')) return 'vue';
                        if (id.includes('alpinejs')) return 'alpine';
                        if (id.includes('axios')) return 'axios';
                        if (id.includes('lodash')) return 'lodash';
                        if (id.includes('@heroicons')) return 'icons';
                        return 'vendor';
                    }
                },
                chunkFileNames: (chunkInfo) => {
                    const name = chunkInfo.name;
                    if (['vue', 'alpine', 'axios', 'lodash', 'icons'].includes(name)) {
                        return `js/vendor/${name}-[hash].js`;
                    }
                    return 'js/[name]-[hash].js';
                },
                entryFileNames: 'js/[name]-[hash].js',
                assetFileNames: ({ name }) => {
                    if (/\.(css)$/.test(name ?? '')) {
                        return 'css/[name]-[hash][extname]';
                    }
                    if (/\.(woff|woff2|eot|ttf|otf)$/.test(name ?? '')) {
                        return 'fonts/[name]-[hash][extname]';
                    }
                    if (/\.(png|jpe?g|gif|svg|webp)$/.test(name ?? '')) {
                        return 'images/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
            treeshake: {
                moduleSideEffects: false,
            },
        },
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
        sourcemap: false,
        target: 'es2015',
        cssTarget: 'chrome61',
    },
    server: {
        host: '0.0.0.0',
        port: 3000,
        hmr: {
            host: 'localhost',
        },
    },
    optimizeDeps: {
        include: [
            'vue',
            'alpinejs',
            'axios',
            'lodash',
            '@heroicons/vue/outline',
            '@heroicons/vue/solid',
            'flatpickr',
        ],
    },
});
