let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version(); // Adiciona versão para cache busting


    const mix = require('laravel-mix');

// Compile CSS e JS do AdminLTE
mix.styles([
    'node_modules/admin-lte/dist/css/adminlte.min.css',
], 'public/css/adminlte.css')
   .scripts([
    'node_modules/admin-lte/dist/js/adminlte.min.js',
], 'public/js/adminlte.js')
   .version();
