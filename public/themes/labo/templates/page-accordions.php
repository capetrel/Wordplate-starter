<?php
/**
 * Template Name: Page accordéons
 * Description: Page avec des accordéons
 */

use Themes\labo\src\Structure;
use Timber\Post;
use Timber\Timber;

$structure             = Structure::getInstance();
$context               = $structure->getContext();
$context['post']       = new Post();
$context['accordions'] = carbon_get_the_post_meta('page_accordions');
$btn_list              = carbon_get_the_post_meta('under_banner_btn_fields');

if (!is_null($btn_list)) {
    $context['total_btns']   = count($btn_list);
    $context['page_buttons'] = $btn_list;
}

Timber::render('page_accordions.twig', $context);
