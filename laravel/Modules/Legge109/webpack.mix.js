const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/resources/assets/js/app.js', 'js/legge109.js')
    .sass( __dirname + '/resources/assets/sass/app.scss', 'css/legge109.css');

if (mix.inProduction()) {
    mix.version();
}