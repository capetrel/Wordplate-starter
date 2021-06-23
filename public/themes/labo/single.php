<?php

use Themes\labo\src\Repository\PostRepository;
use Themes\labo\src\Structure;
use Timber\Timber;
use Timber\Post;

$structure       = Structure::getInstance();
$context         = $structure->getContext();
$single_post     = new Post();
$post_tags       = $single_post->tags();
$repo            = new PostRepository();
$query           = $repo->getPage('evenements');
$page            = $query->get_posts()[0];

$context['post']        = $page;
$context['single_post'] = $single_post;
$context['category']    = $single_post->category();
$context['tags']        = $post_tags;

if (count($post_tags) > 1) {
    foreach ($post_tags as $tag) {
        $tags[] = $tag->slug;
    }
    $context['related_posts'] = $repo->lastRelatedByTags($tags);
} else {
    $context['related_posts'] = $repo->lastRelatedByCategory($single_post->category()->slug);
}

Timber::render('single.twig', $context);
