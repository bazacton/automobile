<?php

/*
 * @Shortcode Name :   Start function for Counter shortcode/element front end view
 */
if (!function_exists('automobile_counters_shortcode')) {

    function automobile_counters_shortcode($atts, $content = null) {
        global $post, $automobile_var_counter_col, $automobile_var_icon_color, $automobile_var_count_color, $automobile_var_content_color;
        $defaults = array(
            'automobile_var_column_size' => '1/1',
            'automobile_multi_counter_title' => '',
            'automobile_multi_counter_sub_title' => '',
            'automobile_var_counter_col' => '',
            'automobile_var_icon_color' => '',
            'automobile_var_count_color' => '',
            'automobile_var_content_color' => '',
            'automobile_var_counters_view' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_section_title = '';
        $automobile_var_column_size = '';
        $automobile_multi_counter_title = isset($automobile_multi_counter_title) ? $automobile_multi_counter_title : '';
        $automobile_multi_counter_sub_title = isset($automobile_multi_counter_sub_title) ? $automobile_multi_counter_sub_title : '';
        $automobile_var_counter_col = isset($automobile_var_counter_col) ? $automobile_var_counter_col : '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }

        $automobile_var_counter = '';
        if (isset($column_class) && $column_class <> '') {
            $automobile_var_counter .= '<div class="' . esc_html($column_class) . '">';
        }

        if (trim($automobile_multi_counter_title) <> '') {
            $automobile_section_title .= '<div class="cs-element-title">';
                $automobile_section_title .= '<h2>' . esc_attr($automobile_multi_counter_title) . '</h2>';
            $automobile_section_title .= '</div>';
        }
        $automobile_var_counter .= $automobile_section_title;

        $automobile_var_counter .=' <div class="row">';
        $automobile_var_counter .= do_shortcode($content);
        $automobile_var_counter .=' </div>';

        if (isset($column_class) && $column_class <> '') {
            $automobile_var_counter .= '</div>';
        }

        return $automobile_var_counter;
    }

}

if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('multi_counter', 'automobile_counters_shortcode');

/*
 * @Shortcode Name :  Start function for counter Item
 */
if (!function_exists('automobile_counter_item')) {

    function automobile_counter_item($atts, $content = null) {
        global $post, $automobile_var_counter_col, $automobile_var_icon_color, $automobile_var_count_color, $automobile_var_content_color;
        $col_class = '';
        if (isset($automobile_var_counter_col) && $automobile_var_counter_col != '') {
            $number_col = 12 / $automobile_var_counter_col;
            $number_col_sm = 12;
            $number_col_xs = 12;
            if ($number_col == 2) {
                $number_col_sm = 4;
                $number_col_xs = 6;
            }
            if ($number_col == 3) {
                $number_col_sm = 6;
                $number_col_xs = 12;
            }
            if ($number_col == 4) {
                $number_col_sm = 6;
                $number_col_xs = 12;
            }
            if ($number_col == 6) {
                $number_col_sm = 12;
                $number_col_xs = 12;
            }
            $col_class = 'col-lg-' . $number_col . ' col-md-' . $number_col . ' col-sm-' . $number_col_sm . ' col-xs-' . $number_col_xs . '';
        }
        $automobile_var_counter_item = '';
        $defaults = array(
            'automobile_var_icon' => '',
            'automobile_var_count' => '',
            //'automobile_var_content' => '',
            'automobile_var_title' => ''
        );

        extract(shortcode_atts($defaults, $atts));
        $automobile_var_icon = isset($automobile_var_icon) ? $automobile_var_icon : '';
        $automobile_var_count = isset($automobile_var_count) ? $automobile_var_count : '';
        $automobile_var_icon_color = isset($automobile_var_icon_color) ? $automobile_var_icon_color : '';
        $automobile_var_count_color = isset($automobile_var_count_color) ? $automobile_var_count_color : '';
        $automobile_var_content_color = isset($automobile_var_content_color) ? $automobile_var_content_color : '';

        $automobile_var_content = $content;

        $automobile_var_counter_item .='<div class="' . $col_class . '">';
        $automobile_var_counter_item .='<div class="cs-counter">';
        $automobile_var_counter_item .='<div class="cs-media">';
        if ($automobile_var_title <> '') {
            $automobile_var_counter_item .='<h3>' . esc_html($automobile_var_title) . '</h3>';
        }
        $automobile_var_counter_item .='<figure> <i style="color:' . esc_html($automobile_var_icon_color) . ' !important" class="' . esc_html($automobile_var_icon) . ' cs-color"> </i> </figure>';
        $automobile_var_counter_item .='</div>';
        $automobile_var_counter_item .='<div class="cs-text" style="color:' . esc_html($automobile_var_content_color) . ' !important"> <strong  style="color:' . esc_html($automobile_var_count_color) . ' !important"  class="counter">' . esc_html(($automobile_var_count)) . '</strong> <span>' . ($automobile_var_content) . '</span> </div>';
        $automobile_var_counter_item .='</div>';
        $automobile_var_counter_item .='</div>';

        return $automobile_var_counter_item;
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('multi_counter_item', 'automobile_counter_item');
}
