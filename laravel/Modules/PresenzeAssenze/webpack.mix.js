const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/resources/assets/js/app.js', 'js/presenzeassenze.js')
    .sass( __dirname + '/resources/assets/sass/app.scss', 'css/presenzeassenze.css');

if (mix.inProduction()) {
    mix.version();
}