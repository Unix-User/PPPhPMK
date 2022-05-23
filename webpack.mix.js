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

mix.copy('resources/js/jquery.min.js', 'public/js')
    .copy('resources/js/breakpoints.min.js', 'public/js')
    .copy('resources/js/jquery.scrolly.min.js', 'public/js')
    .copy('resources/js/jquery.dropotron.min.js', 'public/js')
    .copy('resources/js/jquery.scrollex.min.js', 'public/js')
    .copy('resources/js/browser.min.js', 'public/js')
    .copy('resources/js/util.js', 'public/js')
    .copy('resources/js/main.js', 'public/js')
    .copy('resources/js/bootstrap.min.js', 'public/js')
    .copy('resources/js/md5.js', 'public/js')
    .copy('resources/js/skel.min.js', 'public/js')
    .css('resources/css/fontawesome-all.min.css', 'public/css')
    .css('resources/css/main.css', 'public/css')
    .css('resources/css/noscript.css', 'public/css')
    .css('resources/css/bootstrap.min.css', 'public/css')
    .css('resources/css/style.css', 'public/css');