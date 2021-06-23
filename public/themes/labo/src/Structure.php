<?php


namespace Themes\labo\src;

use Themes\labo\src\Repository\PartnerRepository;
use Timber\Timber;

class Structure
{
    // Hold the class instance.
    private static $instance = null;
    private $context;

    private function __construct()
    {
        $partnerQuantity                        = carbon_get_theme_option('partners_quantity');
        $this->context                          = Timber::context();
        $this->context['footer_left_widget']    = Timber::get_widgets('gauche');
        $this->context['footer_right_widget']   = Timber::get_widgets('droite');
        $this->context['partners']              = PartnerRepository::orderByWeight((int)$partnerQuantity);
        $this->context['header_sn']             = carbon_get_theme_option('pasrel_social_header_links');
        $this->context['slides_quantity']       = carbon_get_theme_option('slides_quantity');
        $this->context['events_pagination']     = carbon_get_theme_option('events_pagination');
        $this->context['highlights_pagination'] = carbon_get_theme_option('highlights_pagination');
        $this->context['presses_pagination']    = carbon_get_theme_option('presses_pagination');
    }

    public static function getInstance(): ?Structure
    {
        if (!self::$instance) {
            self::$instance = new Structure();
        }

        return self::$instance;
    }

    public function getContext()
    {
        return $this->context;
    }
}
