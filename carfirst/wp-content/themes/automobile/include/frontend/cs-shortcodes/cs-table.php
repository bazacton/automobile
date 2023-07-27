<?php

/*
 *
 * @Shortcode Name : Start function for Table shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_table_shortcode')) {

    function automobile_var_table_shortcode($atts, $content = "") {
        $defaults = array('automobile_table_element_title' => '', 'automobile_var_column_size' => '');
        extract(shortcode_atts($defaults, $atts));
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        $html = '';
        ////// Start Column Class
        if (isset($column_class) && $column_class <> '') {
            $html .= '<div class="' . $column_class . '">';
        }
            ////// Element Title
            if (isset($automobile_table_element_title) && trim($automobile_table_element_title) <> '') {
                $html .= '<div class="cs-element-title"><h2>' . $automobile_table_element_title . '</h2></div>';
            }
            ////// Table Content
            $html .= '<div class="cs-pricing-table table-responsive">' . do_shortcode($content) . '</div>';
        ////// End Column Class
        if (isset($column_class) && $column_class <> '') {
            $html .= ' </div>';
        }
        return $html;
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('automobile_table', 'automobile_var_table_shortcode');
    }
}
/*
 *
 * @Shortcode Name : Start function for Table shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_table_shortcode')) {

    function automobile_table_shortcode($atts, $content = "") {
        $defaults = array('automobile_table_content' => '');
        extract(shortcode_atts($defaults, $atts));
        return '<table class="table ">' . do_shortcode($content) . '</table>';
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('table', 'automobile_table_shortcode');
    }
}

/*
 *
 * @Shortcode Name : Start function for Table Body  shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_table_body_shortcode')) {

    function automobile_table_body_shortcode($atts, $content = "") {
        $defaults = array();
        extract(shortcode_atts($defaults, $atts));
        return '<tbody>'. do_shortcode($content) .'</tbody>';
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('tbody', 'automobile_table_body_shortcode');
    }
}
/*
 *
 * @Shortcode Name : Start function for Table Head  shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_table_head_shortcode')) {

    function automobile_table_head_shortcode($atts, $content = "") {
        $defaults = array();
        extract(shortcode_atts($defaults, $atts));
        return '<thead>' . do_shortcode($content) . '</thead>';
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('thead', 'automobile_table_head_shortcode');
    }
}
/*
 *
 * @Shortcode Name : Start function for Table Row  shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_table_row_shortcode')) {

    function automobile_table_row_shortcode($atts, $content = "") {
        $defaults = array();
        extract(shortcode_atts($defaults, $atts));
        return '<tr>' . do_shortcode($content) . '</tr>';
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('tr', 'automobile_table_row_shortcode');
    }
}

/*
 *
 * @Shortcode Name :Start function for Table Heading  shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_table_heading_shortcode')) {

    function automobile_table_heading_shortcode($atts, $content = "") {
        $defaults = array();
        extract(shortcode_atts($defaults, $atts));
        $html = '';
        $html .= '<th>';
        $html .= do_shortcode($content);
        $html .= '</th>';

        return $html;
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('th', 'automobile_table_heading_shortcode');
    }
}

/*
 *
 * @Shortcode Name :  Start function for Table Data  shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_table_data_shortcode')) {

    function automobile_table_data_shortcode($atts, $content = "") {
        $defaults = array();
        extract(shortcode_atts($defaults, $atts));
        return '<td>' . do_shortcode($content) . '</td>';
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('td', 'automobile_table_data_shortcode');
    }
}
