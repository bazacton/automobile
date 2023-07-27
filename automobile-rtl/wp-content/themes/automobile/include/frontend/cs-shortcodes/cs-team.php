<?php

/*
 *
 * @Shortcode Name :  Team front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_team_shortcode')) {

    function automobile_var_team_shortcode($atts, $content = "") {

        global $post, $automobile_var_team_column, $automobile_var_team_col;
        if (!function_exists('automobile_var_theme_demo')) {

            function automobile_var_theme_demo($str = '') {
                global $automobile_strings;
                if (isset($automobile_strings[$str])) {
                    return $automobile_strings[$str];
                }
            }

        }
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_team_title' => '',
            'automobile_var_team_sub_title' => '',
            'automobile_var_team_col' => '',
        );
        extract(shortcode_atts($defaults, $atts));

        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_var_team_title = isset($automobile_var_team_title) ? $automobile_var_team_title : '';
        $automobile_var_team_sub_title = isset($automobile_var_team_sub_title) ? $automobile_var_team_sub_title : '';
        $automobile_var_team_col = isset($automobile_var_team_col) ? $automobile_var_team_col : '';

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
        if (trim($automobile_var_team_title) <> '') {
            $automobile_section_title .= '<div class="cs-element-title">';
                $automobile_section_title .= '<h2>' . esc_attr($automobile_var_team_title) . '</h2>';
            $automobile_section_title .= '</div>';
        }
        $html .= $automobile_section_title;
        $html .= '<div class="row">';
        $html .= do_shortcode($content);
        $html .= '</div>';



        if (isset($column_class) && $column_class <> '') {
            $html .= '</div>';
        }
        return do_shortcode($html);
    }

}
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('automobile_team', 'automobile_var_team_shortcode');

/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_team_item_shortcode')) {

    function automobile_var_team_item_shortcode($atts, $content = "") {
        global $post, $automobile_var_team_col;
        $defaults = array(
            'automobile_var_team_name' => '',
            'automobile_var_team_designation' => '',
            'automobile_var_team_image' => '',
            'automobile_var_team_phone' => '',
            'automobile_var_team_fb' => '',
            'automobile_var_team_twitter' => '',
            'automobile_var_team_google' => '',
            'automobile_var_team_linkedin' => '',
            'automobile_var_team_youtube' => ''
        );
        extract(shortcode_atts($defaults, $atts));

        $automobile_var_team_name = isset($automobile_var_team_name) ? $automobile_var_team_name : '';
        $automobile_var_team_designation = isset($automobile_var_team_designation) ? $automobile_var_team_designation : '';
        $automobile_var_team_image = isset($automobile_var_team_image) ? $automobile_var_team_image : '';
        $automobile_var_team_phone = isset($automobile_var_team_phone) ? $automobile_var_team_phone : '';
        $automobile_var_team_fb = isset($automobile_var_team_fb) ? $automobile_var_team_fb : '';
        $automobile_var_team_twitter = isset($automobile_var_team_twitter) ? $automobile_var_team_twitter : '';
        $automobile_var_team_google = isset($automobile_var_team_google) ? $automobile_var_team_google : '';
        $automobile_var_team_linkedin = isset($automobile_var_team_linkedin) ? $automobile_var_team_linkedin : '';
        $automobile_var_team_youtube = isset($automobile_var_team_youtube) ? $automobile_var_team_youtube : '';
        $col_class = '';
        if (isset($automobile_var_team_col) && $automobile_var_team_col != '') {
            $number_col = 12 / $automobile_var_team_col;
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

        $html = '';



        $html .= '<div class="' . $col_class . '">';

        $html .= ' <div class="cs-team">';
        $html .= ' <div class="cs-media">';
        if ($automobile_var_team_image <> '') {
            $html .= ' <figure><a href="#"><img src="' . esc_url($automobile_var_team_image) . '" ></a></figure>';
        }
        $html .= ' <div class="cs-caption"> <i class="icon-bars cs-top-icon"></i>';
        $html .= ' <ul>';
        if ($automobile_var_team_fb <> '') {
            $html .= ' <li><a href="' . esc_url($automobile_var_team_fb) . '"><i class="icon-facebook2"></i></a></li>';
        }
        if ($automobile_var_team_twitter <> '') {
            $html .= ' <li><a href="' . esc_url($automobile_var_team_twitter) . '"><i class="icon-twitter2"></i></a></li>';
        }
        if ($automobile_var_team_google <> '') {
            $html .= ' <li><a href="' . esc_url($automobile_var_team_google) . '"><i class="icon-google4"></i></a></li>';
        }
        if ($automobile_var_team_linkedin <> '') {
            $html .= ' <li><a href="' . esc_url($automobile_var_team_linkedin) . '"><i class="icon-linkedin4"></i></a></li>';
        }
        if ($automobile_var_team_youtube <> '') {
            $html .= ' <li><a href="' . esc_url($automobile_var_team_youtube) . '"><i class="icon-youtube"></i></a></li>';
        }
        $html .= '</ul>';
        $html .= ' </div>';
        $html .= ' </div>';
        $html .= ' <div class="cs-text">';
        if ($automobile_var_team_name <> '') {
            $html .= ' <h6><a href="#">' . esc_html($automobile_var_team_name) . '</a></h6>';
        }
        if ($automobile_var_team_designation <> '') {
            $html .= ' <span>' . esc_html($automobile_var_team_designation) . '</span>';
        }
        if ($automobile_var_team_phone <> '') {
            $html .= '  <em><i class="icon-phone4"></i>' . esc_html($automobile_var_team_phone) . '</em>';
        }
        $html .= ' </div>';
        $html .= ' </div>';
        $html .= ' </div>';

        return do_shortcode($html);
    }

}
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('automobile_team_item', 'automobile_var_team_item_shortcode');
?>