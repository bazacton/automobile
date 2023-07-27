<?php

/*
 *
 * @Shortcode Name :   Start function for Price Plan shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_price_table_shortcode')) {

    function automobile_price_table_shortcode($atts, $content = null) {
        global $automobile_multi_price_col, $automobile_price_plan_counter;
        $automobile_price_plan_counter == 0;
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_multi_price_table_section_title' => '',
            'price_table_style' => '',
            'automobile_multi_price_col' => '',
        );
        extract(shortcode_atts($defaults, $atts));

        $automobile_var_price_table = '';
        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_multi_price_table_section_title = isset($automobile_multi_price_table_section_title) ? $automobile_multi_price_table_section_title : '';
        $price_table_style = isset($price_table_style) ? $price_table_style : '';
        $automobile_var_price_table_text = isset($automobile_var_price_table_text) ? $automobile_var_price_table_text : '';


        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }

        if (isset($column_class) && $column_class <> '') {

            $automobile_var_price_table .= '<div class="' . esc_html($column_class) . '">';
        }

        if ($automobile_multi_price_table_section_title <> '') {
            $automobile_var_price_table .='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            $automobile_var_price_table .= '<div class="cs-element-title"><h2>' . esc_html($automobile_multi_price_table_section_title) . '</h2></div>';
            $automobile_var_price_table .= '</div>';
        }
        $automobile_var_price_table .= '<div class="price-items-wrapper">' . do_shortcode($content) . '</div>';
        $automobile_var_price_table .= '<script type="text/javascript">(function($){ $(".price-items-wrapper > div").last().find(".pricetable-holder").addClass("last-element"); })(jQuery);</script>';
        

        if (isset($column_class) && $column_class <> '') {
            $automobile_var_price_table .= '</div>';
        }

        return $automobile_var_price_table;
    }

//    if (function_exists('automobile_short_code')) {
//        automobile_short_code('automobile_price_table', 'automobile_price_table_shortcode');
//    }
    
    if (function_exists('automobile_var_short_code'))
{
automobile_var_short_code('automobile_price_table', 'automobile_price_table_shortcode');
}
}

/*
 *
 * @Shortcode Name :  Start function for Price Plan Item shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_price_table_item')) {

    function automobile_price_table_item($atts, $content = null) {
        global $automobile_multi_price_col, $automobile_price_plan_counter;
        $defaults = array(
            'multi_price_table_text' => '',
            'multi_price_table_title_color' => '',
            'multi_pricetable_price' => '',
            'multi_price_table_currency' => '',
            'multi_price_table_time_duration' => '',
            'button_link' => '',
            'multi_price_table_button_text' => '',
            'multi_price_table_button_color' => '',
            'multi_price_table_button_color_bg' => '',
            'pricetable_featured' => '',
            'multi_price_table_column_bgcolor' => '',
        );

        extract(shortcode_atts($defaults, $atts));
             
        if ($automobile_price_plan_counter == 0) {
            $first = 'first-element';
        } else {
            $first = '';
        }

        $automobile_multi_price_col = isset($automobile_multi_price_col) ? $automobile_multi_price_col : '';

        $multi_price_table_text = isset($multi_price_table_text) ? $multi_price_table_text : '';
        $multi_price_table_title_color = isset($multi_price_table_title_color) ? $multi_price_table_title_color : '';
        $multi_pricetable_price = isset($multi_pricetable_price) ? $multi_pricetable_price : '';
        $multi_price_table_currency = isset($multi_price_table_currency) ? $multi_price_table_currency : '';
        $multi_price_table_time_duration = isset($multi_price_table_time_duration) ? $multi_price_table_time_duration : '';
        $button_link = isset($button_link) ? $button_link : '';
        $multi_price_table_button_text = isset($multi_price_table_button_text) ? $multi_price_table_button_text : '';
        $multi_price_table_button_color = isset($multi_price_table_button_color) ? $multi_price_table_button_color : '';
        $multi_price_table_button_color_bg = isset($multi_price_table_button_color_bg) ? $multi_price_table_button_color_bg : '';
        $pricetable_featured = isset($pricetable_featured) ? $pricetable_featured : '';
        $multi_price_table_column_bgcolor = isset($multi_price_table_column_bgcolor) ? 'style="background-color:'.$multi_price_table_column_bgcolor.'"' : '';
        $active_class = '';
        if ($pricetable_featured == 'Yes') {
            $active_class = 'active';
        }

        if (isset($automobile_multi_price_col) && $automobile_multi_price_col != '') {
            $number_col = 12 / $automobile_multi_price_col;
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

        $automobile_var_price_table_item = '';
        $automobile_var_price_table_item .= '<div class="' . esc_html($col_class) . '">';
        $automobile_var_price_table_item .= '<div class="pricetable-holder modren ' . esc_html($active_class) . ' ' . esc_html($first) . '" ' .automobile_allow_special_char($multi_price_table_column_bgcolor).'>';
        if ($multi_price_table_text <> '') {
            $automobile_var_price_table_item .= '<h2 style="">' . esc_html($multi_price_table_text) . '</h2>';
        }
        $automobile_var_price_table_item .= '<div class="price-holder ">';
        $automobile_var_price_table_item .= '<div class="cs-price"><span class="cs-color">';
        if ($multi_price_table_currency <> '') {
            $automobile_var_price_table_item .= '<sup class="cs-color">' . esc_html($multi_price_table_currency) . '</sup>';
        }
        if ($multi_pricetable_price <> '') {
            $automobile_var_price_table_item .= esc_html($multi_pricetable_price);
        }

        if ($multi_price_table_time_duration <> '') {
            $automobile_var_price_table_item .= '<em>' . esc_html($multi_price_table_time_duration) . '</em>';
        }
        $automobile_var_price_table_item .= '</span>';
        
        $automobile_var_price_table_item .= do_shortcode($content);
       
        $automobile_var_price_table_item .= '</div>';
        if ($multi_price_table_button_text <> '') {
            $automobile_var_price_table_item .= '<a style="background-color:'.automobile_allow_special_char($multi_price_table_button_color_bg).'!important; color:'.automobile_allow_special_char($multi_price_table_button_color).' !important" href="' . esc_url($button_link) . '" class="cs-color ">' . esc_html($multi_price_table_button_text) . '</a>';
        }
        $automobile_var_price_table_item .= '</div>';
        $automobile_var_price_table_item .= '</div>';
        $automobile_var_price_table_item .= '</div>';

        $automobile_price_plan_counter ++;


        return $automobile_var_price_table_item;
    }

//    if (function_exists('automobile_short_code')) {
//        automobile_short_code('price_table_item', 'automobile_price_table_item');
//    }
    
    if (function_exists('automobile_var_short_code'))
{
automobile_var_short_code('price_table_item', 'automobile_price_table_item');
}
}

