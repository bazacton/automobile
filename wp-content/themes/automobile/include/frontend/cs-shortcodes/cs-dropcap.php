<?php

/**
 * dropcap html form for page builder
 */
if (!function_exists('automobile_var_dropcap_shortcode')) {

    function automobile_var_dropcap_shortcode($atts, $content = "") {

        $automobile_var_defaults = array(
            'automobile_var_column_size' => '',
            'automobile_dropcap_section_title' => '',
        );
        $author_name = '';
        extract(shortcode_atts($automobile_var_defaults, $atts));
        
        $automobile_dropcap_section_title = isset($automobile_dropcap_section_title) ? $automobile_dropcap_section_title : '';
        $dropcap_cite_url = isset($dropcap_cite_url) ? $dropcap_cite_url : '';
        $dropcap_cite = isset($dropcap_cite) ? $dropcap_cite : '';
        if (isset($dropcap_cite_url) && $dropcap_cite_url <> '') {

            if (isset($dropcap_cite_url) && $dropcap_cite_url <> '') {
                $author_name .= '<a href="' . esc_url($dropcap_cite_url) . '">';
            }
            $author_name .= '-- ' . $dropcap_cite;
            if (isset($dropcap_cite_url) && $dropcap_cite_url <> '') {
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
        if ($automobile_dropcap_section_title && trim($automobile_dropcap_section_title) != '') {
            $html .= '<div class="cs-element-title"><h2 class="">' . $automobile_dropcap_section_title . '</h2></div>';
        }
        $html .= '<div class="cs-dropcap">
		<p>' . do_shortcode($content) . '</p>
		</div>';
        if (isset($column_class) && $column_class <> '') {
            $html .= '</div>';
        }
        return $html;
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_dropcap', 'automobile_var_dropcap_shortcode');
}