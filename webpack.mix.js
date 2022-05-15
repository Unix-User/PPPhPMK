const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/bootstrap.min.js', 'public/js')
    .js('resources/js/jquery.dropotron.min.js', 'public/js')
    .js('resources/js/jquery.scrollex.min.js', 'public/js')
    .js('resources/js/jquery.scrolly.min.js', 'public/js')
    .js('resources/js/main.js', 'public/js')
    .js('resources/js/md5.js', 'public/js')
    .js('resources/js/util.js', 'public/js')
    .css('resources/css/bootstrap.min.css', 'public/css')
    .css('resources/css/font-awesome.min.css', 'public/css')
    .css('resources/css/main.css', 'public/css')
    .css('resources/css/style.css', 'public/css');
    
