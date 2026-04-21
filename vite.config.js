import { defineConfig } from 'vite';

export default defineConfig({
    css: {
        postcss: {
            plugins: [],
        },
    },
    build: {
        emptyOutDir: false,
        manifest: false,
        outDir: '../../../public_html/modules/geo',
        rollupOptions: {
            input: {
                'geo-map-widget': './resources/js/widgets/geo-map-widget.js',
                'map-picker': './resources/js/filament/map-picker.js',
                'map-picker.css': './resources/css/filament/map-picker.css',
            },
            output: {
                entryFileNames: '[name].js',
                assetFileNames: '[name][extname]',
            },
        },
    },
});
