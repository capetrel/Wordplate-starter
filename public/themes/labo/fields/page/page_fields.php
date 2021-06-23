<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function bannerText() {
    Container::make('post_meta', __('Bannière d\'entête', 'pasrel'))
        ->set_context('carbon_fields_after_title')
        ->where('post_type', '=', 'page')
        ->add_fields([
            Field::make('rich_text', 'banner_title', __('Texte dans la bannière', 'pasrel')),
        ]);
}

function enableBannerCalc() {
    Container::make('post_meta', __('Voile sur la bannière', 'pasrel'))
        ->set_context('carbon_fields_after_title')
        ->where('post_type', '=', 'page')
        ->add_fields([
            Field::make( 'radio', 'enable_banner_calc', __("Activer l'effet de calque", 'pasrel'))
                ->set_default_value('disable')
                ->set_help_text(__('Active le calque de couleur sur le bandeau', 'pasrel'))
                ->add_options([
                    'enable' => 'Activer',
                    'disable' => 'Désactiver'
                ])
        ]);
}

function specialPageTitle() {
    Container::make('post_meta', __('Titre de remplacement', 'pasrel'))
        ->set_context('carbon_fields_after_title')
        ->where('post_type', '=', 'page')
        ->where('post_id', '!=', get_option('page_on_front'))
        ->add_fields([
            Field::make('text', 'special_page_title', __('Titre de page de remplacement', 'pasrel')),
        ]);
}

function homeBlocks() {
    Container::make('post_meta', __("Groupe de Blocs", 'pasrel'))
        ->where('post_type', '=', 'page')
        ->where('post_id', '=', get_option('page_on_front'))
        ->set_classes( 'home_blocks' )
        ->add_tab('home_bloc_1', [
            Field::make('image', "homeblock_image_1", __("Image de fond 1", 'pasrel'))
                ->set_required( true ),
            Field::make('text', "homeblock_title_1", __("Texte de fond 1", 'pasrel'))
                ->set_required( true )
                ->set_default_value('Académiques et soignants'),
            Field::make('association', "homeblock_link_1", __("Lien du bloc 1", 'pasrel'))
                ->set_types([['type' => 'post','post_type' => 'page']])
                ->set_min(1)
                ->set_max(1)
                ->set_required( true ),
            Field::make( 'select', "homeblock_select_color_1", __("Choix de la Couleur de fond 1", 'pasrel'))
                ->add_options([
                    'academyc_red' => __('Rouge soignants', 'pasrel'),
                    'industriel_green' => __('Vert industriels', 'pasrel'),
                    'people_blue' => __('Bleu grand public', 'pasrel'),
                ])
                ->set_required( true )
                ->set_default_value('academyc_red'),
        ])
        ->add_tab('home_bloc_2', [
            Field::make('image', "homeblock_image_2", __("Image de fond 2", 'pasrel'))
                ->set_required( true ),
            Field::make('text', "homeblock_title_2", __("Texte de fond 2", 'pasrel'))
                ->set_required( true )
                ->set_default_value('Industriels'),
            Field::make('association', "homeblock_link_2", __("Lien du bloc 2", 'pasrel'))
                ->set_types([['type' => 'post', 'post_type' => 'page']])
                ->set_min(1)
                ->set_max(1)
                ->set_required( true ),
            Field::make( 'select', "homeblock_select_color_2", __("Choix de la Couleur de fond 2", 'pasrel'))
                ->set_options([
                    'academyc_red' => __('Rouge soignants', 'pasrel'),
                    'industriel_green' => __('Vert industriels', 'pasrel'),
                    'people_blue' => __('Bleu grand public', 'pasrel'),
                ])
                ->set_required( true )
                ->set_default_value('industriel_green'),
        ])
        ->add_tab('home_bloc_3', [
            Field::make('image', "homeblock_image_3", __("Image de fond 3", 'pasrel'))
                ->set_required( true ),
            Field::make('text', "homeblock_title_3", __("Texte de fond 3", 'pasrel'))
                ->set_required( true )
                ->set_default_value('Grand public'),
            Field::make('association', "homeblock_link_3", __("Lien du bloc 3", 'pasrel'))
                ->set_types([['type' => 'post', 'post_type' => 'page']])
                ->set_min(1)
                ->set_max(1)
                ->set_required( true ),
            Field::make( 'select', "homeblock_select_color_3", __("Choix de la Couleur de fond 3", 'pasrel'))
                ->set_options([
                    'academyc_red' => __('Rouge soignants', 'pasrel'),
                    'industriel_green' => __('Vert industriels', 'pasrel'),
                    'people_blue' => __('Bleu grand public', 'pasrel'),
                ])
                ->set_required( true )
                ->set_default_value('people_blue'),
        ]);

}

function pageAccordions() {
    Container::make('post_meta', __('Accordéons', 'pasrel'))
        ->where('post_template', '=', 'templates/page-accordions.php')
        ->add_fields([
            Field::make('complex', 'page_accordions', __('Accordéons', 'pasrel'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('text', 'accordion_title', 'Titre'),
                    Field::make('image', 'accordion_image', 'Image'),
                    Field::make('rich_text', 'accordion_content', 'Contenue'),
                ]),
        ]);
}

function page2ColImage() {
    Container::make('post_meta', __("Image d'accompagnement", 'pasrel'))
        ->where('post_template', '=', 'templates/page-2-col.php')
        ->add_fields([
            Field::make('image', 'page_2col_image', __("Image d'accompagnement du contenu", 'pasrel')),
            Field::make('select', 'page_2col_image_position', __("Gauche ou droite", 'pasrel'))
                ->set_help_text(__("Si il y a une image d'accompagnement, définir sa position", 'pasrel'))
                ->add_options([
                    'left_col' => 'Gauche',
                    'right_col' => 'Droite',
                ])
                ->set_default_value('left_col'),
        ]);
}

function lastPostsOnPage() {
    Container::make('post_meta', __("afficher les 4 derniers faits marquants ", 'pasrel'))
        ->where('post_template', '=', 'templates/page-1-col.php')
        ->add_fields([
            Field::make( 'radio', 'enable_posts_on_footer', __("Afficher les derniers faits marquants", 'pasrel'))
                ->set_default_value('hide')
                ->set_help_text(__('Affiche les 4 derniers faits marquants', 'pasrel'))
                ->add_options([
                    'display' => 'Afficher',
                    'hide' => 'Masquer'
                ])
        ]);
}
