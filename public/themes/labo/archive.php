<?php

use Timber\Post;
use Timber\Timber;
use Themes\labo\src\Structure;
use Themes\labo\src\Repository\PostRepository;

global $params;
global $paged;

$structure             = Structure::getInstance();
$paged                 = !isset($paged) || !$paged ? 1 : $paged;
$context               = $structure->getContext();
$allPosts              = __('--Choisir--', 'pasrel');
$selectItems           = array_merge([''=> $allPosts], POSTS_FILTERS);
$highlights_pagination = $context['highlights_pagination'];

$context['post']         = new Post();
$context['select_items'] = $selectItems;
$context['filter_class'] = 'highlights';

if (isset($params['num'])) {
    $paged = (int)$params['num'];
}

$postRepo           = new PostRepository();
$context['items']   = $postRepo->paginatedPostInCategoryWithTag($paged, '', (int)$highlights_pagination);
$context['display'] = setHtmlClass(count($context['items']));

Timber::render('archive.twig', $context);
