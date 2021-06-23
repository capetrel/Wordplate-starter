<?php

namespace Themes\labo\src;

use App\Asset;
use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Themes\labo\src\Widgets\ContactInformationsWidget;
use Themes\labo\src\Widgets\CopyrightWidget;
use Themes\labo\src\Widgets\SocialNetworkWidget;
use Twig\Environment;
use Twig\TwigFunction;

class Site extends \App\Site
{
    public function __construct($site_name_or_id = null)
    {
        parent::__construct($site_name_or_id);
        $this->registerImages();

        add_action('admin_init', [$this, 'addTinyMceStyle']);
        add_filter('tiny_mce_before_init', [$this, 'addTinyMceCustomFormats']);
        add_action('init', [$this, 'addTinyMceCaretButton']);
        add_action('after_setup_theme', [$this, 'carbonLoad']);
        add_action('carbon_fields_register_fields', [$this, 'registerThemeOptions']);

    }

    /**
     * Lance carbon fields
     */
    public function carbonLoad()
    {
        Carbon_Fields::boot();
    }

    public function extendTwig(Environment $twig): Environment
    {
        $twig = parent::extendTwig($twig);

        $twig->addFunction(new TwigFunction('getenv', function ($key) {
            return getenv($key);
        }));

        return $twig;
    }

    public function registerAssets()
    {
        $asset = new Asset(get_stylesheet_directory());

        // wp_register_script('rgpd', $asset->getPath('rgpd.js'), [], '1.0.0', true);
        // wp_enqueue_script('rgpd');

    }

    public function registerMenus(): void
    {
        register_nav_menus([
            'header' => 'Menu principal',
        ]);
    }

    public function registerPostType(): void
    {

        $this->addType('partners', [
            'menu_icon'     => 'dashicons-money',
            'supports'      => ['title', 'thumbnail', 'custom-fields'],
            'menu_position' => 7,
            'show_in_rest'  => false,
            'publicly_queryable'  => false
        ], 'Partenaire', 'Partenaires', true);
    }


    public function registerSidebar(): void
    {
        $this->addSidebar('Gauche', 'Pied de page à gauche', 'pasrel', 'left-footer', 'span', 'div');
        $this->addSidebar('Droite', 'Pied de page à droite', 'pasrel', 'right-footer', 'span', 'div');
    }

    public function registerWidget(): void
    {
        $this->addWidget(SocialNetworkWidget::class);
        $this->addWidget(CopyrightWidget::class);
        $this->addWidget(ContactInformationsWidget::class);
    }

    /**
     * Ajoutes des options générales dans le tableau de bord de wordpress
     */
    public function registerSettings(): void
    {
        $options = [
            'show_in_rest'      => false,
            'sanitize_callback' => 'esc_html',
        ];

        $sectionParams = [
            'id'    => 'contact_informations',
            'title' => 'Coordonées',
        ];

        $fields['address_title'] = [
            'type'  => 'text',
            'id'    => 'address_title',
            'title' => '<label for="address_title">' . __('Titre de l\'adresse') . '</label>'
        ];

        $fields['address_street'] = [
            'type'  => 'text',
            'id'    => 'address_street',
            'title' => '<label for="address_street">'. __('Adresse (rue)') . '</label>'
        ];

        $fields['address_more'] = [
            'type'  => 'text',
            'id'    => 'address_more',
            'title' => '<label for="address_more">' . __('Adresse (complétment)') . '</label>'
        ];

        $fields['address_cp_city'] = [
            'type'  => 'text',
            'id'    => 'address_cp_city',
            'title' => '<label for="address_cp_city">' . __('Code postal et ville') . '</label>'
        ];

        $fields['address_tel'] = [
            'type'  => 'text',
            'id'    => 'address_tel',
            'title' => '<label for="address_tel">' . __('Téléphone') . '</label>'
        ];

        $fields['address_contact'] = [
            'type'  => 'mail',
            'id'    => 'address_contact',
            'title' => '<label for="address_contact">' . __('Contact (mail)') . '</label>'
        ];

        $this->addSettings($sectionParams, $fields, $options);
    }

    /**
     * Ajoutes des options au thèmes
     */
    public function registerThemeOptions() :void
    {

        $select_options = array_merge(['' => 'Choisir'], ICON_SOCIAL);

        Container::make('theme_options', __('Theme Options'))
                ->add_fields([
                 Field::make('complex', 'pasrel_social_header_links', 'Réseaux sociaux d\entête')
                      ->set_layout('tabbed-horizontal')
                      ->add_fields([
                          Field::make('select', 'social_header_icon', __('Icône'))
                               ->add_options($select_options)
                               ->set_width(50),
                          Field::make('text', 'social_header_url', __('Lien'))
                               ->set_width(50),
                      ])
                ])
                ->add_fields([
                 Field::make('text', 'partners_quantity', __('Nombre de partenaires en pied de page'))
                      ->set_default_value('4')
                      ->set_width(50),
                 Field::make('text', 'slides_quantity', __('Nombre d\'articles dans les diaporamas'))
                      ->set_default_value('4')
                      ->set_width(50),
                ]);
    }

    /**
     * Ajoute des formats d'images
     */
    private function registerImages()
    {
        add_image_size('banner_home', 1920, 373, true);
        add_image_size('banner_page', 1920, 209, true);
        add_image_size('home_more', 344, 316, true);
        add_image_size('mini', 250, 100);
        add_image_size('logo_partner', 0, 70);
    }

    /**
     * Enregistre la feuille de style de l'éditeur de texte.
     */
    public function addTinyMceStyle()
    {
        add_editor_style('assets/css/editor.css');
    }

    /**
     * Enregistre un bouton supplémentaire dans l'éditeur de texte
     */
    public function addTinyMceCaretButton()
    {
        add_filter('mce_external_plugins', function ($plugins) {
            $plugins['caret'] = get_stylesheet_directory_uri() . '/assets/editor/caret.js';
            return $plugins;
        });
        add_filter('mce_buttons_2', function ($buttons) {
            $buttons[] = 'caret';
            return $buttons;
        });
    }

    /**
     * Ajoute des styles à la liste des styles dans l'éditeur
     * https://www.hostpapa.co.uk/knowledgebase/how-to-add-custom-styles-to-wordpress-visual-editor/
     */
    public function addTinyMceCustomFormats($init_array)
    {
        $style_formats = [
            [
                'title'   => 'Bouton de base',
                'block'   => 'a',
                'classes' => 'button',
                'wrapper' => true,
            ],
            [
                'title'   => 'En avant',
                'block'   => 'span',
                'classes' => 'forward-p',
                'wrapper' => true,
            ],
        ];

        $init_array['style_formats'] = json_encode($style_formats);

        return $init_array;
    }
}
