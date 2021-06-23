## Starter Template Wordpress
Starter kit for Wordpress devlopement with stuff for good devlopment practice.

## WordPlate

WordPlate is simply a wrapper around WordPress. It makes developers life easier. It is just like building any other WordPress website with [themes](https://developer.wordpress.org/themes) and [plugins](https://developer.wordpress.org/plugins). Just with sprinkles on top.

[![Build Status](https://badgen.net/github/checks/wordplate/framework?label=build&icon=github)](https://github.com/wordplate/framework/actions)
[![Monthly Downloads](https://badgen.net/packagist/dm/wordplate/framework)](https://packagist.org/packages/wordplate/framework/stats)
[![Latest Version](https://badgen.net/packagist/v/wordplate/framework)](https://packagist.org/packages/wordplate/framework)

- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Plugins](#plugins)
- [Laravel Mix](#laravel-mix)
- [Integrations](#integrations)
- [Upgrade Guide](#upgrade-guide)
- [FAQ](#faq)
- [Acknowledgements](#acknowledgements)
- [Contributing](#contributing)

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


# Développeur
L'intégration de Carbon Field n'est pas prévu pour être utiliser avec bedrock. le fichier composer.json permet de copier les assets du vendor dans le plugins pour pouvoir utiliser Carbon Fields.
Lancer la commande 'composer install' Pour installer les différend packet, puis lancer le script pour Carbon Fields
composer 'run-script cf-copy' ou 'composer cf-copy'.
Il faudra également lancer cette commande après un composer update.

Le dossier ressources contient tous les assets qui doivent êtres compilés (css, js, image) ainsi que les vues Twig.

Le dossier app contient un ensemble de classes indépendante du projet. Site.php est destiné à des projets wordpress, mais les autres sont framework agnostic.

Le nommage des fichiers php dù à la hiérarchie des gabarits de Wordpress, ne permet pas de les nommer selon les bonnes pratiques MVC, mais le projet est en paterne MVC.
- Les 'modèles' sont dans le dossier themes/pasrel/src/Repository
- Les controller sont les fichiers php à la racine du thème : themes/nom-theme/index.php, themes/nom-theme/single.php, etc...
- Les vues sont dans le dossier resources/views
