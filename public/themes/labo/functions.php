<?php

use Themes\labo\src\Repository\PostRepository;
use Themes\labo\src\Site;

define('Carbon_Fields\URL', WP_CONTENT_URL . '/mu-plugins/carbon-fields-plugin');

// $decrease_dates = __('Dates Décroissantes');
// $increase_dates = __('Dates Croissantes');
// $decrease_order = __('De A à Z');
// $increase_order = __('De Z à A');

define('POSTS_FILTERS', [
    'active' => '',
    'dates-desc'=> __('Dates Décroissantes'),
    'dates-asc'=> __('Dates Croissantes'),
    'desc'=> __('De A à Z'),
    'asc'=> __('De Z à A'),
]);

// Initialisation des champs personnalisé et de la configuration
require 'fields/page/page_fields.php';
require 'fields/post/post_fields.php';
require 'config/carbon_fields.php';
require 'config/disabled.php';
require 'config/customize.php';
require 'routes/web.php';
require 'routes/api.php';

const ICON_SOCIAL = [
    'ps-facebook-box' => 'Facebook',
    'ps-instagram-box' => 'Instagram',
    'ps-linkedin-box' => 'Linkedin',
    'ps-twitter-box' => 'Twitter',
    'ps-youtube-box' => 'Youtube',
    'ps-whatsapp-box' => 'What\'s App'
];

// Initialisation de Timber (twig)
new Timber\Timber();
Timber\Timber::$locations = [dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views'];

// Initialisation des classes personnalisées du site
new Site();

/**
 * Génère un nom de class en fonction du nombre d'items pour la page listant les faits marquants et communiqués
 * @param int $totalItems
 *
 * @return string
 */
function setHtmlClass(int $totalItems): string
{
    return $totalItems < 2 ? 'flex-items' : 'grid-items';
}

/**
 * Renvoie l'item qui est actif pour générer le <select> des filtres
 * @param string $active L'item qui doit apparaitre
 * @param array $values Les différentes valeurs
 * @param string $defaultValue La valeur vide et par default
 *
 * @return array
 */
function setActiveSelectItems(string $active, array $values, string $defaultValue): array
{
    foreach ($values as $k => $value) {
        $selectItems[$k] = $value;
    }
    $selectItems['all'] = $defaultValue;
    $selectItems['active'] = $active;
    return $selectItems;
}

/**
 * Renvoie les articles filtrés selon les différents paramètres
 * @param array $params Paramètres de la requete HTTP
 * @param PostRepository $posts
 * @param array $selectItems la listes des items du select
 * @param array $options les options ['paged' => $paged, 'pagination' => $pagination, 'emptySelectVal' => $emptyValPosts]
 *
 * @return array
 */
function returnFilteredPosts(array $params, PostRepository $posts, array $selectItems, array $options): array
{
    $result = [];
    switch ($params['order']) {
        case 'dates-desc':
            $result['items']        = $posts->getFilteredPosts($options['paged'], 'faits-marquants', 'date', 'DESC', $options['pagination']);
            $result['select_items'] = setActiveSelectItems($params['order'], $selectItems, $options['emptySelectVal']);
            break;
        case 'dates-asc':
            $result['items']        = $posts->getFilteredPosts($options['paged'], 'faits-marquants', 'date', 'ASC', $options['pagination']);
            $result['select_items'] = setActiveSelectItems($params['order'], $selectItems, $options['emptySelectVal']);
            break;
        case 'asc':
            $result['items']        = $posts->getFilteredPosts($options['paged'], 'faits-marquants', 'title', 'ASC', $options['pagination']);
            $result['select_items'] = setActiveSelectItems($params['order'], $selectItems, $options['emptySelectVal']);
            break;
        case 'desc':
            $result['items']        = $posts->getFilteredPosts($options['paged'], 'faits-marquants', 'title', 'DESC', $options['pagination']);
            $result['select_items'] = setActiveSelectItems($params['order'], $selectItems, $options['emptySelectVal']);
            break;
    }
    return $result;
}

/**
 * Détecte si la requête HTTP est un appel API
 * @return bool
 */
function getApiCall(): bool
{
    $headers = [];
    foreach (apache_request_headers() as $key => $value) {
        $headers[strtolower($key)] = $value;
    }
    if (isset($headers['x-api-header']) &&
        $headers['x-api-header'] === 'call' &&
        $headers['content-type'] === 'application/json') {
        return true;
    } else {
        return false;
    }
}
