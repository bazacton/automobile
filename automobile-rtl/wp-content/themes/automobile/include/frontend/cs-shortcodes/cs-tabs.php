<?php

/*
 *
 * @Shortcode Name :  tabs front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_tabs_shortcode')) {

    function automobile_var_tabs_shortcode($atts, $content = "") {
        global $post, $automobile_var_tabs_column;
        global $tabs_content;
        $tabs_content = '';
        $defaults = array(
            'automobile_var_tabs_title' => '',
            'automobile_var_tabs_style' => '',
        );

        extract(shortcode_atts($defaults, $atts));
        $automobile_var_tabs_title = isset($automobile_var_tabs_title) ? $automobile_var_tabs_title : '';
        $automobile_var_tabs_style = isset($automobile_var_tabs_style) ? $automobile_var_tabs_style : '';
        $html = '';
        $automobile_section_title = '';
        $automobile_section_sub_title = '';
        if (isset($automobile_var_tabs_title) && trim($automobile_var_tabs_title) <> '') {
            $automobile_section_title = '<div class="cs-element-title"><h2>' . esc_attr($automobile_var_tabs_title) . '</h2></div>';
        }
        $automobile_tabs_style = "vertical";

        $automobile_var_tabs_style;
        $html .= $automobile_section_title;
        if ($automobile_var_tabs_style == "Horizontal") {
            $html .= "<div class='cs-tabs full-width'>";
        } else {
            $html .= "<div class='cs-faq-tabs'>";
        }
        $html .= '  <ul class="nav nav-tabs" role="tablist">';
        $html .= do_shortcode($content);
        $html .= '</ul>';
        $html .= '<div class="tab-content">';
        $html .= $tabs_content;
        $html .= '</div>';
        $html .= '</div>';


        return do_shortcode($html);
    }
if (function_exists('automobile_var_short_code')) {
    automobile_var_short_code('automobile_tabs', 'automobile_var_tabs_shortcode');
}
}


/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_tabs_item_shortcode')) {

    function automobile_var_tabs_item_shortcode($atts, $content = "") {
        global $post, $automobile_var_tabs_column, $tabs_content;
        $output = '';
        global $tabs_content;
        $defaults = array(
            'automobile_var_tabs_item_text' => '',
            'automobile_var_tabs_item_icon' => '',
            //'automobile_var_tabs_desc' => '',
            'automobile_var_tabs_active' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_tabs_column_str = '';
        if ($automobile_var_tabs_column != 12) {
            $automobile_var_tabs_column_str = 'class = "col-md-' . esc_html($automobile_var_tabs_column) . '"';
        }
        $automobile_var_tabs_item_text = isset($automobile_var_tabs_item_text) ? $automobile_var_tabs_item_text : '';
        $automobile_var_tabs_color = isset($automobile_var_tabs_color) ? $automobile_var_tabs_color : '';
        $automobile_var_tabs_item_icon = isset($automobile_var_tabs_item_icon) ? $automobile_var_tabs_item_icon : '';
        //$automobile_var_tabs_desc = isset($automobile_var_tabs_desc) ? $automobile_var_tabs_desc : '';
        $automobile_var_tabs_active = isset($automobile_var_tabs_active) ? $automobile_var_tabs_active : '';
        ?>

        <?php

        $activeClass = "";
        if ($automobile_var_tabs_active == 'Yes') {
            $activeClass = 'active in';
        }

        $fa_icon = '';
        if ($automobile_var_tabs_item_icon) {
            $fa_icon = '<i class="' . sanitize_html_class($automobile_var_tabs_item_icon) . '"></i>  ';
        }
        $randid = rand(877, 9999);
        $output .= '<li  class="' . ($activeClass) . ' in"><a data-toggle="tab" href="#cs-tab-' . sanitize_title($automobile_var_tabs_item_text) . $randid . '"  aria-expanded="true">' . $fa_icon . $automobile_var_tabs_item_text . '</a></li>';
        $tabs_content .= '<div id="cs-tab-' . sanitize_title($automobile_var_tabs_item_text) . $randid . '" class="tab-pane fade ' . ($activeClass) . '">';
        $tabs_content .= do_shortcode($content);
        $tabs_content .= '</div>';

        return do_shortcode($output);
    }
if (function_exists('automobile_var_short_code')) {
    automobile_var_short_code('automobile_tabs_item', 'automobile_var_tabs_item_shortcode');
}
}
?>