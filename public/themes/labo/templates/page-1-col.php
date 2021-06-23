<?php
/**
 * Template Name: Page 1 colonnes
 * Description: Page 1 colonnes
 */

use Timber\Post;
use Timber\Timber;
use Themes\labo\src\Repository\PostRepository;
use Themes\labo\src\Structure;


$structure       = Structure::getInstance();
$context         = $structure->getContext();
$posts           = new PostRepository();
$context['post'] = new Post();

if ($context['post']->meta('enable_posts_on_footer') === 'display') {
    $context['homeHighlights'] = $posts->lastAllOneCategory('faits-marquants', (int)$context['slides_quantity']);
}

Timber::render('page_1_col.twig', $context);
