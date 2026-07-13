import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
<<<<<<< HEAD
import path from 'path';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';
=======
import { dirname, resolve } from 'path';
import { fileURLToPath } from 'url';
>>>>>>> laraxot/dev

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const nodeModules = resolve(__dirname, '../../node_modules');

export default defineConfig({
    build: {
<<<<<<< HEAD
        outDir: './public',
=======
>>>>>>> laraxot/dev
        emptyOutDir: false,
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
<<<<<<< HEAD
            'lit': path.resolve(nodeModules, 'lit'),
            'leaflet': path.resolve(nodeModules, 'leaflet'),
            'leaflet/dist/leaflet.css': path.resolve(nodeModules, 'leaflet/dist/leaflet.css'),
            'leaflet.markercluster': path.resolve(nodeModules, 'leaflet.markercluster'),
            'leaflet.markercluster/dist/MarkerCluster.css': path.resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.css'),
            'leaflet.markercluster/dist/MarkerCluster.Default.css': path.resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.Default.css'),
            'leaflet.heat': path.resolve(nodeModules, 'leaflet.heat'),
=======
            'lit': resolve(nodeModules, 'lit'),
            'leaflet': resolve(nodeModules, 'leaflet'),
            'leaflet/dist/leaflet.css': resolve(nodeModules, 'leaflet/dist/leaflet.css'),
            'leaflet.markercluster': resolve(nodeModules, 'leaflet.markercluster'),
            'leaflet.markercluster/dist/MarkerCluster.css': resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.css'),
            'leaflet.markercluster/dist/MarkerCluster.Default.css': resolve(nodeModules, 'leaflet.markercluster/dist/MarkerCluster.Default.css'),
            'leaflet.heat': resolve(nodeModules, 'leaflet.heat'),
>>>>>>> laraxot/dev
        }
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/geo',
            input: [
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/components/coordinate-picker-lit.js'),
<<<<<<< HEAD
=======
                resolve(__dirname, 'resources/js/components/map-picker-lit.js'),
                resolve(__dirname, 'resources/js/components/geopoint-picker-lit.js'),
>>>>>>> laraxot/dev
            ],
            ...refreshPaths,
            refresh: true,
        }),
    ],
});