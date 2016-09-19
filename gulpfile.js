const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

var semantic = {
    watch: require('./semantic/tasks/watch'),
    build: require('./semantic/tasks/build')
};

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
gulp.task('watch-ui', semantic.watch);
gulp.task('build-ui', semantic.build);

elixir(mix => {

    mix.copy('semantic/dist/semantic.min.css', 'public/css/lib/semantic/semantic.min.css')
        .copy('semantic/dist/semantic.min.js', 'public/js/lib/semantic/semantic.min.js')
        .copy('semantic/dist/themes', 'public/css/themes');


    mix.sass('app.scss');

    mix.styles([
        'public/css/lib/semantic/semantic.min.css',
        'app.css'
    ], './public/css/app.min.css', './public/css');

    mix.webpack('app.js');


    mix.scripts([
        'app.js',
        'lib/semantic/semantic.min.js'
    ], './public/js/app.min.js', './public/js');
});
