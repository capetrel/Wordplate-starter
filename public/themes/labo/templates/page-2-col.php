<?php
/**
 * Template Name: Page 2 colonnes
 * Description: Page 2 colonnes
 */

use Timber\Post;
use Timber\Timber;
use Themes\labo\src\Structure;

$structure               = Structure::getInstance();
$context                 = $structure->getContext();
$context['post']         = new Post();

Timber::render('page_2_col.twig', $context);
