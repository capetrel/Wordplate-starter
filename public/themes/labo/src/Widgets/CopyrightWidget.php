<?php

namespace Themes\labo\src\Widgets;

use App\FormBuilder;
use WP_Widget;

class CopyrightWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('copyright_widget', 'Copyright Widget');
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'] = '<div class="cr-widget-wrapper">';
        echo $args['before_title'] . '<span class="copyright">' . get_bloginfo() . '&nbsp;&copy;&nbsp;'. date('Y') .'</span><span class="pipe">&nbsp;|&nbsp;</span><a href="'. $instance['cr-link'] .'">' . $instance['cr-title'] .'</a>'. $args['after_title'];
        echo $args['after_widget'] = "</div>";
    }

    public function form($instance)
    {
        $content_value = isset($instance['cr-title']) ? esc_attr($instance['cr-title']) : '';
        $link_value = isset($instance['cr-link']) ? esc_attr($instance['cr-link']) : '';

        $form = new FormBuilder($instance);
        echo $form->field(
            $this->get_field_id('cr-title'),
            $this->get_field_name('cr-title'),
            $content_value,
            'Texte du lien',
            [],
            ['class' => 'widefat']
        );

        echo $form->field(
            $this->get_field_id('cr-link'),
            $this->get_field_name('cr-link'),
            $link_value,
            'Lien de la page',
            [],
            ['class' => 'widefat']
        );
    }

    public function update($newInstance, $oldInstance)
    {
        $oldInstance['cr-title'] = strip_tags($newInstance['cr-title']);
        $oldInstance['cr-link'] = strip_tags($newInstance['cr-link']);
        $oldInstance['cr-errors'] = [];

        return $oldInstance;
    }
}
