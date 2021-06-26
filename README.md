## Starter Template Wordpress
Starter kit for Wordpress developement with stuff for good development practice.

## WordPlate

WordPlate is simply a wrapper around WordPress. It makes developers life easier. It is just like building any other WordPress website with [themes](https://developer.wordpress.org/themes) and [plugins](https://developer.wordpress.org/plugins). Just with sprinkles on top.

### Features

- **WordPress + Composer = ♥️**
- **Environment Files**
- **WordPress Packagist**
- **Must-use plugins**
- **Mail**
- **Laravel Mix**
- **Debugging**
- **Security**

### Public Directory

After installing WordPlate, you should configure your web server's document / web root to be the `public` directory. The `index.php` in this directory serves as the front controller for all HTTP requests entering your application.

### Salt Keys

The next thing you should do after installing WordPlate is adding salt keys to your environment file.
If you're lazy like us, [visit our salt key generator](https://wordplate.github.io/salt) and copy the randomly generated keys to your `.env` file.

## Laravel Mix
<p>
<a href="https://www.npmjs.com/package/laravel-mix"><img src="https://img.shields.io/node/v/laravel-mix.svg" alt="Node"></a>
<a href="https://www.npmjs.com/package/laravel-mix"><img src="https://img.shields.io/npm/v/laravel-mix.svg" alt="NPM"></a>
<a href="https://npmcharts.com/compare/laravel-mix?minimal=true"><img src="https://img.shields.io/npm/dt/laravel-mix.svg" alt="NPM"></a>
<a href="https://www.npmjs.com/package/laravel-mix"><img src="https://img.shields.io/npm/l/laravel-mix.svg" alt="NPM"></a>
</p>
Laravel Mix is a clean layer on top of Webpack to make the 80% use case laughably simple to execute. Most would agree that, though incredibly powerful, Webpack ships with a steep learning curve. But what if you didn't have to worry about that?

[site](https://laravel-mix.com/)
[git](https://github.com/JeffreyWay/laravel-mix)

```sh
// Run all mix tasks...
npm run dev

// Run all mix tasks and minify output...
npm run build
```
## Timber
[![Build Status](https://img.shields.io/travis/timber/timber/master.svg?style=flat-square)](https://travis-ci.com/github/timber/timber)
[![Coverage Status](https://img.shields.io/coveralls/timber/timber.svg?style=flat-square)](https://coveralls.io/github/timber/timber)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/timber/timber.svg?style=flat-square)](https://scrutinizer-ci.com/g/timber/timber/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/timber/timber.svg?style=flat-square)](https://packagist.org/packages/timber/timber)
[![WordPress Download Count](https://img.shields.io/wordpress/plugin/dt/timber-library.svg?style=flat-square)](https://wordpress.org/plugins/timber-library/)
[![Join the chat at https://gitter.im/timber/timber](https://img.shields.io/gitter/room/timber/timber.svg?style=flat-square)](https://gitter.im/timber/timber?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![WordPress Rating](https://img.shields.io/wordpress/plugin/r/timber-library.svg?style=flat-square)](https://wordpress.org/support/plugin/timber-library/reviews/)
Timber helps you create fully-customized WordPress themes faster with more sustainable code. With Timber, you write your HTML using the Twig Template Engine separate from your PHP files.
[site](https://timber.github.io/docs/guides/template-locations/)
[git](https://github.com/timber/timber)


## Carbon fields
[![Build Status](https://travis-ci.org/htmlburger/carbon-fields.svg?branch=master)](https://travis-ci.org/htmlburger/carbon-fields) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/htmlburger/carbon-fields/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/htmlburger/carbon-fields/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/htmlburger/carbon-fields/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/htmlburger/carbon-fields/?branch=master) [![Gitter chat](https://badges.gitter.im/carbon-fields/Lobby.png)](https://gitter.im/carbon-fields/Lobby)
Carbon Fields - developer-oriented library for WordPress custom fields for all types of WordPress content.
[site](https://carbonfields.net/)
[git](https://github.com/htmlburger/carbon-fields)


# Extra
The integration of Carbon Field is not intended for use with bedrock. the composer.json file allows you to copy the vendor's assets into the plugins to be able to use Carbon Fields.
Run the 'composer install' command To install the packets, then run the script for Carbon Fields
composer 'run-script cf-copy' or 'composer cf-copy'.
You will also need to run this command after a composer update.

The resources folder contains all the assets that must be compiled (css, js, image) as well as the Twig views. If the site use loco translate, the plugin scan only the theme folder, if you want to translate string in the twig file, you must move the views folder into yout theme directory and update te path in function.php

The naming of the php files due to the hierarchy of Wordpress templates, does not allow them to be named according to MVC good practices, but the project is in MVC.
- The 'models' are in the themes / pasrel / src / Repository folder
- The controllers are the php files at the root of the theme: themes / name-theme / index.php, themes / name-theme / single.php, etc ...
- The views are in the resources / views folder
