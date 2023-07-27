<?php

/*
 *
 * @Shortcode Name : Button
 * @retrun
 *
 */
if (!function_exists('automobile_var_button')) {

    function automobile_var_button($atts, $content = "") {

        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_column' => '1',
            'automobile_var_button_text' => '',
            'automobile_var_button_link' => '#',
            'automobile_var_button_border' => '',
            'automobile_var_button_icon_position' => '',
            'automobile_var_button_type' => 'rounded',
            'automobile_var_button_target' => '_self',
            'automobile_var_button_border_color' => '',
            'automobile_var_button_color' => '#fff',
            'automobile_var_button_bg_color' => '',
            'automobile_var_button_padding_top' => '',
            'automobile_var_button_padding_bottom' => '',
            'automobile_var_button_padding_left' => '',
            'automobile_var_button_padding_right' => '',
            'automobile_var_button_align' => '',
            'automobile_button_icon' => '',
            'automobile_var_button_size' => 'btn-lg'
        );
        
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_column = isset($automobile_var_column) ? $automobile_var_column : '';
        $automobile_var_button_text = isset($automobile_var_button_text) ? $automobile_var_button_text : '';
        $automobile_var_button_link = isset($automobile_var_button_link) ? $automobile_var_button_link : '';
        $automobile_var_button_border = isset($automobile_var_button_border) ? $automobile_var_button_border : '';
        $automobile_var_button_icon_position = isset($automobile_var_button_icon_position) ? $automobile_var_button_icon_position : '';
        $automobile_var_button_type = isset($automobile_var_button_type) ? $automobile_var_button_type : '';
        $automobile_var_button_padding_top = isset($automobile_var_button_padding_top) ? $automobile_var_button_padding_top : '';
        $automobile_var_button_border_color = isset($automobile_var_button_border_color) ? $automobile_var_button_border_color : '';
        $automobile_var_button_bg_color = isset($automobile_var_button_bg_color) ? $automobile_var_button_bg_color : '';
        $automobile_var_button_color = isset($automobile_var_button_color) ? $automobile_var_button_color : '';
        $automobile_var_button_target = isset($automobile_var_button_target) ? $automobile_var_button_target : '';
        $automobile_button_icon = isset($automobile_button_icon) ? $automobile_button_icon : '';
        $button_size = isset($automobile_var_button_size) ? $automobile_var_button_size : '';
        $column_class = '';
        $html = '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        if (isset($column_class) && $column_class <> '') {
            $html .= '<div  class="' . esc_html($column_class) . '" >';
        }
        $button_type_class = 'no_circle';
        $automobile_var_button_align = isset($automobile_var_button_align) ? $automobile_var_button_align : '';
        $border = '';
        $has_icon = '';
        if ($button_size == 'btn-xlg') {
            $button_size = 'large';
        } elseif ($button_size == 'btn-lg') {
            $button_size = 'custom-btn btn-lg';
        } elseif ($button_size == 'medium-btn') {
            $button_size = 'medium';
        } else {
            $button_size = 'small';
        }
        if (isset($automobile_var_button_border) && $automobile_var_button_border == 'yes' && $automobile_var_button_border_color <> '') { 
            $border = ' border: 2px solid ' . $automobile_var_button_border_color . ' !important;';
        }
        if (isset($automobile_var_button_type) && $automobile_var_button_type == 'rounded') {
            $button_type_class = 'circle';
        }
        if (isset($automobile_var_button_type) && $automobile_var_button_type == 'three-d') {
            $button_type_class = 'has-shadow';
            $border = '';
        }
        if (isset($automobile_button_icon) && $automobile_button_icon <> '') {
            $has_icon = 'has_icon';
        }
        $button_class_position = (isset($automobile_var_button_align) and $automobile_var_button_align == 'left') ? 'icon-left' : 'icon-right';
        $has_border = '';
        if($automobile_var_button_border == 'yes'){
            $has_border = 'has-border';
        }


        $html .= '<div class="button_style cs-button">';

        $html .= '<a href="' . esc_url($automobile_var_button_link) . '" class="csborder-color '. $has_border .' btn-post ' . sanitize_html_class($button_type_class) . '  ' . $button_size . ' bg-color  ' . $has_icon . ' button-icon-' . $automobile_var_button_align . '" style="' . $border . '  background-color: ' . $automobile_var_button_bg_color . '; color:' . $automobile_var_button_color . ';" target="' . $automobile_var_button_target . '">';
        if (isset($automobile_button_icon) && $automobile_button_icon <> '') {
            $html .= '<i class="' . $automobile_button_icon . '"></i>';
        }
        if (isset($automobile_var_button_text) && $automobile_var_button_text <> '') {
            $html .= $automobile_var_button_text;
        }
        $html .= '</a>';

        $html .= '</div>';


        if (isset($column_class) && $column_class <> '') {
            $html .= '</div>';
        }

        return do_shortcode($html);
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_button', 'automobile_var_button');
}