<?php
/**
* Routes : https://timber.github.io/docs/guides/routing/
* Pour les évènements il est possible des les appelée en Ajax, mais c'est plus simple sans (en plus il n'y a pas d'image)
*/

Routes::map('tag/:slug', function ($params) {
    Routes::load('404.php', $params);
});

Routes::map('tag/:slug/page/:page', function ($params) {
    Routes::load('404.php', $params);
});
