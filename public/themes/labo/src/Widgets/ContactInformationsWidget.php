<?php

namespace Themes\labo\src\Widgets;

use App\FormBuilder;
use WP_Widget;

class ContactInformationsWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('particulars_widget', 'Coordonnées Widget');
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'] = '<div class="particulars-widget-wrapper">';
        echo $args['before_title'];
        if ($instance['particulars-title'] !== '') {
            echo '<span class="widget-title">'.$instance['particulars-title'].'</span>';
        }
        echo '<address class="contact-informations">';
        echo '	<div class="inline address"><i class="icon ps-map-pin-line"></i>';
        echo '	<span class="content">';
        echo        get_option('address_title') .'<br>';
        echo        get_option('address_street') . '<br>';
        if (get_option('address_more')) {
            echo get_option('address_more'). '<br>';
        }
	    echo        get_option('address_cp_city');
        echo '	</span></div>';
        echo '	<div class="inline tel"><i class="icon ps-smartphone-line"></i><span class="content">'.get_option('address_tel').'</span></div>';
        echo '	<div class="inline mail"><i class="icon ps-mail-line"></i><span class="content"><a href="mailto:'.get_option('address_contact').'" title="Écrire à '.get_option('address_contact').'">'.get_option('address_contact').'</a></span></div>';
        echo '</address>';
        echo $args['after_title'];
        echo $args['after_widget'] = "</div>";
    }

    public function form($instance)
    {
        $title_value = isset($instance['particulars-title']) ? esc_attr($instance['particulars-title']) : '';

        $form = new FormBuilder($instance);
        echo $form->field(
            $this->get_field_id('particulars-title'),
            $this->get_field_name('particulars-title'),
            $title_value,
            'Titre',
            [],
            ['class' => 'widefat']
        );
        echo '<br>';
        if ($title_value !== '') {
            echo '<span class="widget-title">'.$title_value.'</span>';
        }
        echo '<address class="contact-informations">';
        echo '	<i class="map-pin-line"></i>';
        echo '	<span class="contact-informations__address">';
        echo        get_option('address_title') .'<br>';
        echo        get_option('address_street') . '<br>';
        if (get_option('address_more')) {
            echo get_option('address_more'). '<br>';
        }
        echo '	</span>';
        echo '	<i class="ps-mail-line"></i><span class="contact-informations__tel">'.get_option('address_tel').'</span>';
        echo '	<i class="ps-smartphone-line"></i><span class="contact-informations__mail">'.get_option('address_contact').'</span>';
        echo '</address>';
    }

    public function update($newInstance, $oldInstance)
    {
        $oldInstance['particulars-title'] = strip_tags($newInstance['particulars-title']);
        return $oldInstance;
    }
}
