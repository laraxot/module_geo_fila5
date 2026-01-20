const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/resources/assets/js/app.js', 'js/inail.js')
    .sass( __dirname + '/resources/assets/sass/app.scss', 'css/inail.css');

if (mix.inProduction()) {
    mix.version();
}