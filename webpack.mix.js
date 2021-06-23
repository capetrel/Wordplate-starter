const mix = require('laravel-mix');

require('dotenv').config();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your WordPlate applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JavaScript files.
 |
 */

const theme = process.env.WP_THEME;

mix.disableSuccessNotifications()
  .setResourceRoot('../')
  .setPublicPath(`public/themes/${theme}/assets`)
  .js('resources/js/main.js', 'js/main.js')
  // .js('ressources/js/tarteaucitron.js', 'js/tarteaucitron.js')
  //.js('ressources/js/rgpd.js', 'js/rgpd.js')
  .sass('resources/scss/main.scss', 'css/main.css')
  .sass('resources/scss/editor.scss', 'css/editor.css')
  .sass('resources/scss/admin.scss', 'css/ps-admin.css')
  .browserSync({
    proxy: 'http://wp-labo.test',
    files: [
      'resources/**/**/*',
      'public/themes/**/**/*.php',
    ]
  })
