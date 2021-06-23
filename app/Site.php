<?php

namespace App;

use Twig\Environment;
use Twig\TwigFunction;

class Site extends \Timber\Site
{

    public function __construct($site_name_or_id = null)
    {
        $this->viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views';
        $this->cachePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage'. DIRECTORY_SEPARATOR .'views';

        add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
        add_action('admin_init', [$this, 'registerSettings']);
        add_action('init', [$this, 'registerMenus']);
        add_action('init', [$this, 'registerPostType']);
        add_action('widgets_init', [$this, 'registerSidebar']);
        add_action('widgets_init', [$this, 'registerWidget']);
        add_action('init', [$this, 'registerTaxonomies']);
        add_filter('timber/twig', [$this, 'extendTwig']);
        add_theme_support('html5');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('responsive-embeds');

        parent::__construct($site_name_or_id);
    }

    public function registerAssets()
    {
        $asset = new Asset(get_stylesheet_directory());

        wp_register_style('main', $asset->getPath('main.css'), [], '1.0.0');
	    wp_enqueue_style('main');

        wp_register_script('main', $asset->getPath('main.js'), [], '1.0.0', true);
	    wp_enqueue_script('main');

    }

    public function registerTaxonomies(): void {}

    public function registerMenus(): void {}

    public function registerPostType(): void {}

    public function registerSidebar(): void {}

    public function registerWidget(): void {}

    public function registerSettings(): void {}

	public function registerThemeOptions(): void {}

    public function extendTwig(Environment $twig): Environment
    {
        $twig->addFunction(new TwigFunction('dump', function (...$args) {
            dump($args);
            return '';
        }));
        return $twig;
    }

    public function sectionInfo()
    {
        echo '<p>Préciser ici les coordonnées du propriétaire du site</p>';
    }

    public function fieldHtml($args)
    {
        $value = html_entity_decode(get_option($args['id']));
        echo '<input class="regular-text" type="'.$args['type'].'" id="'. $args['id'] .'" name="'. $args['id'] .'" value="' . $value . '" />';
    }

    protected function addSettings(array $sectionParams, array $fields, array $options, string $page = 'general')
    {

        add_settings_section(
            $sectionParams['id'],
            $sectionParams['title'],
            [$this, 'sectionInfo'],
            $page
        );

        foreach ($fields as $field) {
            add_settings_field(
                $field['id'],
                $field['title'],
                [$this, 'fieldHtml'],
                $page,
                $sectionParams['id'],
                [
                    'id' => $field['id'],
                    'type' => $field['type']
                ]
            );

            $options['type'] = $field['type'];

            register_setting($page, $field['id'], $options);
        }
    }

    protected function addSidebar(string $name, string $description, string $theme, string $sidebar_class_name = '', string $title_tag = 'span', string $wrapper = null)
    {
        $tag_wrapper = [];
        $id = sanitize_title($name);
        if (!is_null($wrapper)) {
            $tag_wrapper = [
                'before_sidebar'  => '<'.$wrapper.' class="'.$sidebar_class_name.'">',
                'after_sidebar'   => '</'.$wrapper.'>'
            ];
        }
        $widget = [
            'name'          => __($name, $theme),
            'id'            => $id,
            'description'   => __($description, $theme),
            'class'         => $sidebar_class_name . '__widget',
            'before_title'  => '<'.$title_tag.' class="widget-content">',
            'after_title'   => '</'.$title_tag.'>'
        ];
        register_sidebar(array_merge($tag_wrapper, $widget));
    }

    protected function addWidget(string $widgetClasse)
    {
        register_widget($widgetClasse);
    }

    protected function addType(string $slug, array $options, string $singular, string $plural = null, bool $masculin = true)
    {
        if ($plural === null) {
            $plural = $singular . 's';
        }
        $p = strtolower($plural);
        $s = strtolower($singular);
        $tous = $masculin ? "Tous" : "Toutes";
        $le = $masculin ? "le" : "la";
        $ce = $masculin ? "ce" : "cette";
        $un = $masculin ? "un" : "une";
        $nouveau = $masculin ? "Nouveau" : "Nouvelle";
        $n = strtolower($nouveau);

        $labels = [
            'name'              =>$plural,
            'singular_name'     =>$singular,
            'menu_name'         =>$plural,
            'name_admin_bar'    =>$singular,
            'add_new'           =>'Ajouter',
            'add_new_item'      =>"Ajouter $un $n $s",
            'new_item'          =>"$nouveau $s",
            'edit_item'         =>"Editer $le $s",
            'view_item'         =>"Voir $ce",
            'all_items'         =>"$tous les $p",
            'search_items'      =>"Rechercher des $p",
            'not_found'         =>'Aucun résultat',
            'not_found_in_trash'=>'Aucun élément dans la corbeille',
        ];

        $args = [
            'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => ['slug' => $slug],
            'has_archive'         => true,
            'hierarchical'        => null,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'supports'            => ['title', 'editor']
        ];

        register_post_type($slug, array_merge($args, $options));
    }

    protected function addTaxonomy(string $slug, array $types, string $singular, string $plural = null, bool $masculin = true)
    {
        if ($plural === null) {
            $plural = $singular . 's';
        }
        $p = strtolower($plural);
        $s = strtolower($singular);
        $tous = $masculin ? "Tous" : "Toutes";
        $le = $masculin ? "le" : "la";
        $ce = $masculin ? "ce" : "cette";
        $un = $masculin ? "un" : "une";
        $nouveau = $masculin ? "Nouveau" : "Nouvelle";
        $n = strtolower($nouveau);

        $labels = [
            'name'                      =>$plural,
            'singular_name'             =>$singular,
            'popular_items'             =>'populaire',
            'separate_items_with_commas'=>'Séparer les termes avec des virgules',
            'add_new_item'              =>"Ajouter $un $n $s",
            'new_item_name'             =>"$nouveau $s",
            'edit_item'                 =>"Editer $le $s",
            'update_item'               =>"Changer $le $s",
            'view_item'                 =>"Voir $ce",
            'all_items'                 =>"$tous les $p",
            'search_items'              =>"Rechercher des $p",
            'not_found'                 =>'Aucun résultat',
            'add_or_remove_items'       =>'Ajouter ou supprimer',
            'no_terms'                  =>'Pas de catégorie',
            'back_to_items'             =>"Retour aux $p"

        ];

        $args = [
            'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'query_var'           => true,
            'rewrite'             => ['slug' => $slug],
            'hierarchical'        => null,
        ];

        register_taxonomy($slug, $types, $args);
    }

}
