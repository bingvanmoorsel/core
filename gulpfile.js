var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass("backend/backend.scss")
        .scripts([
            "vendor/jQuery/jquery-2.1.3.min.js",
            "vendor/datepicker/bootstrap-sass-datepicker.js",
            "vendor/priceformat/jquery.price_format.min.js",
            "backend.js"
            ],
        "public/js/backend.js", 'resources/assets/js');
});