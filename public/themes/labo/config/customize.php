<?php

/**
 * Css personnalisé pour l'admin
 */
add_action('admin_enqueue_scripts', function () {
	wp_enqueue_style('admin-style', get_stylesheet_directory_uri() . '/assets/css/ps-admin.css');
});

/**
 * Logo du site dans le theme
 */
add_action( 'after_setup_theme', function() {
	add_theme_support( 'custom-logo', ['height' => 95, 'width' => 268, 'flex-width' => true ] );
});