<?php

use Themes\labo\src\Repository\PostRepository;
use Themes\labo\src\Structure;
use Timber\Timber;
use Timber\Post;

$structure = Structure::getInstance();
$context = $structure->getContext();
$posts = new PostRepository();

$context['post'] = new Post();

if (is_front_page()) {
    $context['bigbanner'] = is_front_page();
    $context['homeHighlights'] = $posts->lastAllOneCategory('', (int)$context['slides_quantity']);

    Timber::render('home.twig', $context);
} else {
    Timber::render('default.twig', $context);
}
