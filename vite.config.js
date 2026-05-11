import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default defineConfig({
    build: {
<<<<<<< HEAD
=======
        // Directory di output per i file compilati del modulo Chart
        outDir: './public',
>>>>>>> c3b9b5924 (.)
        emptyOutDir: false,
        manifest: "manifest.json",
        rollupOptions: {
            // Evitiamo di bundlare chart.js perché Filament lo fornisce già lato admin.
            //external: ['chart.js', 'chart.js/helpers'],
            output: {
                globals: {
                //    'chart.js': 'Chart',
                //    'chart.js/helpers': 'Chart.helpers',
                },
            },
        },
        // Opzioni rollup commentate per riferimento futuro
        /*
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`
            }
        }
        */
    },
    optimizeDeps: {
        // Lasciamo che chart.js venga risolto dall'istanza globale caricata da Filament.
        exclude: ['chart.js', 'chart.js/helpers'],
    },
    plugins: [
        laravel({
            publicDirectory: '../../../public_html',
            buildDirectory: 'assets/geo',
            input: [
                // resolve(__dirname, 'Resources/assets/sass/app.scss'), // Percorso storico, lasciato commentato per riferimento
                resolve(__dirname, 'resources/css/app.css'),
                resolve(__dirname, 'resources/js/components/coordinate-picker-lit.js'),
                resolve(__dirname, 'resources/js/components/map-picker-lit.js'),
<<<<<<< HEAD
                resolve(__dirname, 'resources/js/components/geopoint-picker-lit.js'),
                resolve(__dirname, 'resources/js/components/geo-map-lit.js'),
                resolve(__dirname, 'resources/js/components/map-lit.js')
=======
                resolve(__dirname, 'resources/js/components/geopoint-picker-lit.js')
>>>>>>> c3b9b5924 (.)
            ],
            ...refreshPaths,
            refresh: true,
        }),
        tailwindcss(),
    ],
});
<<<<<<< HEAD

// Add geo-map-lit.js to the list of library entry points so it's bundled
import.meta.imports = {
  ...import.meta.imports,
  '/resources/js/components/geo-map-lit.js': true,
};
=======
>>>>>>> c3b9b5924 (.)
