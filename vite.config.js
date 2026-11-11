import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import path from 'path';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const nodeModules = resolve(__dirname, '../../node_modules');

export default defineConfig({
    build: {
        // L'output sta nel modulo (Modules/Geo/public, versionato) e si serve per symlink:
        //   public_html/assets/geo -> ../../laravel/Modules/Geo/public   (lo crea deploy.sh)
        // Quindi `public_path('assets/geo/manifest.json')` (buildDirectory qui sotto e
        // AdminPanelProvider::BUILD_DIRECTORY) legge proprio questo manifest.
        // `build.outDir` ha prevalenza su quello calcolato dal plugin Laravel: e' voluto.
        // emptyOutDir: true toglie i chunk vecchi; la cartella contiene solo output della build.
        outDir: './public',
        emptyOutDir: true,
        manifest: "manifest.json",
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
            },
        }
    },
    resolve: {
        alias: {
            'lit': path.resolve(nodeModules, 'lit'),
            'leaflet': path.resolve(nodeModules, 'leaflet'),
            'leaflet/dist/leaflet.css': path.resolve(nodeModules, 'leaflet/dist/leaflet.css'),
            'leaflet.markercluster': path.resolve(nodeModules, 'leaflet.markercluster'),
            'leaflet.markercluster/dist/MarkerCluster.css': path.resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.css'),
            'leaflet.markercluster/dist/MarkerCluster.Default.css': path.resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.Default.css'),
            'leaflet.heat': path.resolve(nodeModules, 'leaflet.heat'),
        }
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/geo',
            input: [
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/components/coordinate-picker-lit.js'),
            ],
            ...refreshPaths,
            refresh: true,
        }),
    ],
});