<?php

namespace Themes\labo\src\Widgets;

use WP_Widget;

class SocialNetworkWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('social_network_widget', 'Réseaux social Widget');
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'] = '<div class="sn-widget-wrapper">';
        echo $args['before_title'] .'<a class="sn-link" href="'. $instance['sn-link'] .'"><i class="'. $instance['sn-icon'] .'"></i>' . $instance['sn-title'] .'</a>'. $args['after_title'];
        echo $args['after_widget'] = '</div>';
    }

    public function form($instance)
    {

        $icon_value = isset($instance['sn-icon']) ? esc_attr($instance['sn-icon']) : '';
        $title_value = isset($instance['sn-title']) ? esc_attr($instance['sn-title']) : '';
        $link_value = isset($instance['sn-link']) ? esc_attr($instance['sn-link']) : '';

	    $select_options2 = array_merge(['' => 'Choisir'], ICON_SOCIAL);

        $form = new \App\FormBuilder($instance);
        echo $form->field(
            $this->get_field_id('sn-icon'),
            $this->get_field_name('sn-icon'),
            $icon_value,
            'Icône',
            ['type' => 'select', 'options' => $select_options2],
            ['class' => 'widefat']
        );

        echo $form->field(
            $this->get_field_id('sn-title'),
            $this->get_field_name('sn-title'),
            $title_value,
            'Titre',
            [],
            ['class' => 'widefat']
        );

        echo $form->field(
            $this->get_field_id('sn-link'),
            $this->get_field_name('sn-link'),
            $link_value,
            'Lien',
            [],
            ['class' => 'widefat']
        );
    }

    public function update($newInstance, $oldInstance)
    {
        $oldInstance['sn-icon'] = strip_tags($newInstance['sn-icon']);
        $oldInstance['sn-title'] = strip_tags($newInstance['sn-title']);
        $oldInstance['sn-link'] = strip_tags($newInstance['sn-link']);
        $oldInstance['sn-errors'] = [];
        return $oldInstance;
    }
}
