const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/resources/assets/js/app.js', 'js/questionari.js')
    .sass( __dirname + '/resources/assets/sass/app.scss', 'css/questionari.css');

if (mix.inProduction()) {
    mix.version();
}