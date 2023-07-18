<?php

/**
 * Quote html form for page builder
 */
if (!function_exists('automobile_var_quote_shortcode')) {

    function automobile_var_quote_shortcode($atts, $content = "") {

        $automobile_var_defaults = array(
            'automobile_var_column_size' => '',
            'automobile_quote_section_title' => '',
            'quote_cite' => '',
            'quote_cite_url' => '#',
        );
        $author_name = '';
        extract(shortcode_atts($automobile_var_defaults, $atts));
        
        $automobile_quote_section_title = isset($automobile_quote_section_title) ? $automobile_quote_section_title : '';
        $quote_cite_url = isset($quote_cite_url) ? $quote_cite_url : '';
        $quote_cite = isset($quote_cite) ? $quote_cite : '';
        if (isset($quote_cite_url) && $quote_cite_url <> '') {

            if (isset($quote_cite_url) && $quote_cite_url <> '') {
                $author_name .= '<a href="' . esc_url($quote_cite_url) . '">';
            }
            $author_name .= '-- ' . $quote_cite;
            if (isset($quote_cite_url) && $quote_cite_url <> '') {
                $author_name .= '</a>';
            }
        }

        $html = '';
        $column_class = '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        if (isset($column_class) && $column_class <> '') {
            $html .= '<div  class="' . esc_html($column_class) . '" >';
        }
        if ($automobile_quote_section_title && trim($automobile_quote_section_title) != '') {
            $html .= '<div class="cs-element-title"><h2 class="">' . $automobile_quote_section_title . '</h2></div>';
        }
        $html .= '<blockquote>
		<span>' . do_shortcode($content) . '</span>
		<span class="author-name"> ' . $author_name . '</span>
		</blockquote>';
        if (isset($column_class) && $column_class <> '') {
            $html .= '</div>';
        }
        return $html;
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_quote', 'automobile_var_quote_shortcode');
}