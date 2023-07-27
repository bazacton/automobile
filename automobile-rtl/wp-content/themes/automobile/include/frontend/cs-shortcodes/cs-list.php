<?php

/*
 *
 * @Shortcode Name :  List front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_list_shortcode')) {

    function automobile_var_list_shortcode($atts, $content = "") {
        global $post, $automobile_var_list_column, $automobile_var_list_type;
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_list_title' => '',
            'automobile_var_list_type' => '',
        );


        extract(shortcode_atts($defaults, $atts));

        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_var_list_title = isset($automobile_var_list_title) ? $automobile_var_list_title : '';
        $automobile_var_list_type = isset($automobile_var_list_type) ? $automobile_var_list_type : '';

        $html = '';
        $automobile_section_title = '';



        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        if (isset($column_class) && $column_class <> '') {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }

        if (isset($automobile_var_list_title) && trim($automobile_var_list_title) <> '') {
            $automobile_section_title .= '<div class="cs-element-title">';
            $automobile_section_title .= '<h2>' . esc_attr($automobile_var_list_title) . '</h2>';
            $automobile_section_title .= '</div>';
        }

        $html .= $automobile_section_title;
        if ($automobile_var_list_type == 'numeric-icon') {
            $html .= '<ol>';
        } elseif ($automobile_var_list_type == 'alphabetic') {
            $html .= '<ol  style="list-style-type: lower-alpha;">';
        } elseif ($automobile_var_list_type == 'built') {
            $html .= '<ul>';
        } else {
            $html .= '<ul class="cs-icon-list">';
        }

        $html .= do_shortcode($content);

        if ($automobile_var_list_type == 'numeric-icon' || $automobile_var_list_type == 'alphabetic') {
            $html .= '</ol>';
        } else {
            $html .= '</ul>';
        }
            if (isset($column_class) && $column_class <> '') {
                $html .= '</div>';
            }
        return do_shortcode($html);
    }

}
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('automobile_list', 'automobile_var_list_shortcode');

/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_list_item_shortcode')) {

    function automobile_var_list_item_shortcode($atts, $content = "") {
        global $post, $automobile_var_list_type;
        $defaults = array('automobile_var_list_item_text' => '', 'automobile_var_list_item_icon' => '', 'automobile_var_list_item_icon_color' => '', 'automobile_var_list_item_icon_bg_color' => '');
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_list_item_text = isset($automobile_var_list_item_text) ? $automobile_var_list_item_text : '';
        $automobile_var_list_item_icon = isset($automobile_var_list_item_icon) ? $automobile_var_list_item_icon : '';
        $automobile_var_list_item_icon_color = isset($automobile_var_list_item_icon_color) ? $automobile_var_list_item_icon_color : '';
        $automobile_var_list_item_icon_bg_color = isset($automobile_var_list_item_icon_bg_color) ? $automobile_var_list_item_icon_bg_color : '';

        $html = '';

        if (isset($automobile_var_list_type) && $automobile_var_list_type == 'icon') {
            $icon_style = '';
            if ($automobile_var_list_item_icon_color != '' || $automobile_var_list_item_icon_bg_color != '') {
                $icon_style .= ' style="';
                if ($automobile_var_list_item_icon_color != '') {
                    $icon_style .= 'color: ' . $automobile_var_list_item_icon_color . ' !important;';
                }
                if ($automobile_var_list_item_icon_bg_color != '') {
                    $icon_style .= ' background-color: ' . $automobile_var_list_item_icon_bg_color . ' !important;';
                }
                $icon_style .= '"';
            }
            $html .= '<li><i class="cs-color ' . esc_html($automobile_var_list_item_icon) . '" ' . $icon_style . '></i>' . esc_html($automobile_var_list_item_text) . '</li>';
        } else
        if (isset($automobile_var_list_type) && $automobile_var_list_type == 'default') {
            $html .= '<li style="list-style-type:none !important;">' . esc_html($automobile_var_list_item_text) . '</li>';
        } else
        if (isset($automobile_var_list_type) && $automobile_var_list_type == 'built') {
            $html .= '<li style="list-style-type:disc !important;">' . esc_html($automobile_var_list_item_text) . '</li>';
        } else
        if (isset($automobile_var_list_type) && $automobile_var_list_type == 'numeric-icon') {
            $html .= '<li> ' . esc_html($automobile_var_list_item_text) . '</li>';
        } else
        if (isset($automobile_var_list_type) && $automobile_var_list_type == 'alphabetic') {
            $html .= '<li style="list-style:lower-alpha !important;"> ' . esc_html($automobile_var_list_item_text) . '</li>';
        }
        return do_shortcode($html);
    }

}
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('automobile_list_item', 'automobile_var_list_item_shortcode');
?>