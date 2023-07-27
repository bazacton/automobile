<?php

/*
 *
 * @Shortcode Name : Image Frame
 * @retrun
 *
 */
if (!function_exists('automobile_var_image_frame')) {

    function automobile_var_image_frame($atts, $content = "") {

        global $header_map, $post;
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_image_section_title' => '',
            'automobile_var_frame_image_url_array' => '',
            'automobile_var_image_title' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        
        $automobile_var_image_section_title = isset($automobile_var_image_section_title) ? $automobile_var_image_section_title : '';
        $automobile_var_frame_image_url = isset($automobile_var_frame_image_url_array) ? $automobile_var_frame_image_url_array : '';
        $automobile_var_image_title = isset($automobile_var_image_title) ? $automobile_var_image_title : '';

        $automobile_var_image_frame = '';
        if (isset($column_class) && $column_class <> '') {
            $automobile_var_image_frame .= '<div class="' . esc_html($column_class) . '">';
        }
        if (isset($automobile_var_image_section_title) && $automobile_var_image_section_title != '') {
            $automobile_var_image_frame .= '<div class="cs-element-title"> <h2>' . esc_html($automobile_var_image_section_title) . '</h2></div>';
        }
        
        $automobile_var_image_frame .= '<div class="cs-image-frame">';
        if ($automobile_var_frame_image_url <> '') {
            $automobile_var_image_frame .= '<div class="cs-media"><figure><img class="lazyload no-src" alt = "' . esc_html($automobile_var_image_title) . '" src = "' . esc_url($automobile_var_frame_image_url) . '" class = "lazy-image"></figure></div>';
        }
        if ($content != '' || $automobile_var_image_title != '')
        {
            $automobile_var_image_frame .= '<div class="cs-text" >';
        if ($automobile_var_image_title && trim($automobile_var_image_title) != '') {
            $automobile_var_image_frame .= '<h4>' . $automobile_var_image_title . '</h4>';
        }
        if($content <> ''){
            $automobile_var_image_frame .= do_shortcode($content);
        }
        $automobile_var_image_frame .= '</div>';
        }
        $automobile_var_image_frame .= '</div>';

        if (isset($column_class) && $column_class <> '') {
            $automobile_var_image_frame .= '</div>';
        }

        return $automobile_var_image_frame;
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_image_frame', 'automobile_var_image_frame');
}