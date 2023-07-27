<?php

/*
 *
 * @Shortcode Name : Map
 * @retrun
 *
 */
if (!function_exists('automobile_var_column')) {

    function automobile_var_column($atts, $content = "") {
        global $header_map;
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_column_section_title' => '',
            'automobile_var_column_text' => '',
            'automobile_column_margin_left' => '',
            'automobile_column_margin_right' => '',
            'automobile_var_column_top_padding' => '',
            'automobile_var_column_bottom_padding' => '',
            'automobile_var_column_left_padding' => '',
            'automobile_var_column_right_padding' => '',
            'automobile_var_column_image_url_array' => '',
            'automobile_var_column_bg_color' => '',
            'automobile_var_column_title_color' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        
        $automobile_var_column_section_title = isset($automobile_var_column_section_title) ? $automobile_var_column_section_title : '';
        $automobile_var_column_title_color = isset($automobile_var_column_title_color) ? $automobile_var_column_title_color : '';
        $automobile_column_margin_left = isset($automobile_column_margin_left) ? $automobile_column_margin_left : '';
        $automobile_column_margin_right = isset($automobile_column_margin_right) ? $automobile_column_margin_right : '';
        $automobile_var_column_top_padding = isset($automobile_var_column_top_padding) ? $automobile_var_column_top_padding : '';
        $automobile_var_column_bottom_padding = isset($automobile_var_column_bottom_padding) ? $automobile_var_column_bottom_padding : '';
        $automobile_var_column_left_padding = isset($automobile_var_column_left_padding) ? $automobile_var_column_left_padding : '';
        $automobile_var_column_right_padding = isset($automobile_var_column_right_padding) ? $automobile_var_column_right_padding : '';
        $automobile_var_column_image_url = isset($atts['automobile_var_column_image_url_array']) ? $atts['automobile_var_column_image_url_array'] : '';
        $automobile_var_column_bg_color = isset($automobile_var_column_bg_color) ? $automobile_var_column_bg_color : '';
        
        $column_class = '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }

        $style_string = '';
        if ($automobile_var_column_top_padding != '' || $automobile_var_column_bottom_padding != '' || $automobile_var_column_left_padding != '' || $automobile_var_column_right_padding != '' || $automobile_column_margin_left != '' || $automobile_column_margin_right != '') {
            $style_string .= 'style=" ';
            if ($automobile_var_column_top_padding != '') {
                $style_string .= ' padding-top:' . $automobile_var_column_top_padding . 'px; ';
            }
            if ($automobile_var_column_bottom_padding != '') {
                $style_string .= ' padding-bottom:' . $automobile_var_column_bottom_padding . 'px; ';
            }
            if ($automobile_var_column_left_padding != '') {
                $style_string .= ' padding-left:' . $automobile_var_column_left_padding . 'px; ';
            }
            if ($automobile_var_column_right_padding != '') {
                $style_string .= ' padding-right:' . $automobile_var_column_right_padding . 'px; ';
            }
            if ($automobile_column_margin_left != '') {
                $style_string .= ' margin-left:' . $automobile_column_margin_left . 'px; ';
            }
            if ($automobile_column_margin_right != '') {
                $style_string .= ' margin-right:' . $automobile_column_margin_right . 'px; ';
            }
            if ($automobile_var_column_image_url != '') {
                $style_string .= ' background-image:url(' . esc_url($automobile_var_column_image_url) . '); ';
            }
            if ($automobile_var_column_bg_color != '') {
                $style_string .= ' background-color:' . $automobile_var_column_bg_color . '; ';
            }
            $style_string .= '" ';
        }
        
        $html_column = '';
        if (isset($column_class) && $column_class <> '') {
            $html_column .= '<div class="' . automobile_allow_special_char($column_class) . '">';
        }
        $automobile_column_bg_class = '';
        if (isset($automobile_var_column_bg_color) && $automobile_var_column_bg_color != '') {
            $automobile_column_bg_class = ' has-bg';
        }
        if (isset($automobile_var_column_section_title) && $automobile_var_column_section_title != '') {
            $title_style = '';
            if($automobile_var_column_title_color){
                $title_style = 'style="color:'. $automobile_var_column_title_color .' !important;"';
            }
            $html_column .= '<div class="cs-element-title"><h2 '. $title_style .'>' . esc_html($automobile_var_column_section_title) . '</h2></div>';
        }
        $html_column .= '<div '. $style_string .' class="cs-column-text ' . $automobile_column_bg_class . '">';
            $html_column .= do_shortcode($content);
        $html_column .= '</div>';

        if (isset($column_class) && $column_class <> '') {
            $html_column .= '</div>';
        }
        return $html_column;
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_column', 'automobile_var_column');
}