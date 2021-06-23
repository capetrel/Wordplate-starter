<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function postHeader() {
    Container::make('post_meta', __("Entête de l'article", 'pasrel'))
        ->set_context('carbon_fields_after_title')
        ->where('post_type', '=', 'post')
        ->add_fields([
            Field::make('textarea', 'post_head', __('Chapeau d\'entête', 'pasrel')),
        ]);
}

function postFooter() {
    Container::make('post_meta', __("Pied de l'article", 'pasrel'))
        ->set_context('carbon_fields_after_title')
        ->where('post_type', '=', 'post')
        ->add_fields([
            Field::make('text', 'post_more_text', __('Texte du lien', 'pasrel'))
                ->set_default_value('www.universite-paris-saclay.fr'),
            Field::make('text', 'post_more_link', __('Lien vers la page', 'pasrel'))
                ->set_default_value('https://www.universite-paris-saclay.fr/'),
        ]);
}

function partnerFields() {
    Container::make('post_meta', __('Partenaires', 'pasrel'))
        ->set_context('carbon_fields_after_title')
        ->where('post_type', '=', 'partners')
        ->add_fields([
            Field::make('text', 'partner_link', __('Lien', 'pasrel')),
            Field::make('text', 'partner_weight', __('Poid', 'pasrel'))
                ->set_default_value('0')
                ->set_attributes([
                    'type' => 'number',
                    'min' => '0',
                ]),
            Field::make( 'radio', 'enable_img_sizing', __("Changer la taille de l'image ?", 'pasrel'))
                ->set_help_text(__('Activer le champ de saisie pour la taille de l\'image', 'pasrel'))
                ->set_default_value('false')
                ->add_options([
                    'true' => 'Oui',
                    'false' => 'Non',
                ]),
            Field::make('text', 'partner_img_height', __("hauteur de l'image (60px par defaut) ", 'pasrel'))
                ->set_help_text('Saisir une valeur entre 10 et 250')
                ->set_default_value('60')
                ->set_width(25)
                ->set_attributes([
                    'type' => 'number',
                    'min' => '10',
                    'max' => '150',
                ])
                ->set_conditional_logic([
                    'relation' => 'AND', [ // Optional, defaults to "AND"
                        'field' => 'enable_img_sizing',
                        'value' => 'true', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
                        'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
                    ]
                ]),
        ]);
}
