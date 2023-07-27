<?php

/*
 *
 * @Shortcode Name : Accordion
 * @retrun
 *
 */
if (!function_exists('automobile_faq_shortcode')) {

    function automobile_faq_shortcode($atts, $content = "") {


        global $acc_counter,$automobile_var_faq_view;
        $acc_counter = rand(40, 9999999);

        $html = '';
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_faq_view' => '',
            'automobile_var_faq_sub_title' => '',
            'automobile_var_faq_main_title' => ''
        );
        extract(shortcode_atts($defaults, $atts));

        $column_class = '';
        $automobile_var_faq_view = isset($automobile_var_faq_view) ? $automobile_var_faq_view : '';
        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_var_faq_main_title = isset($automobile_var_faq_main_title) ? $automobile_var_faq_main_title : '';
        $automobile_var_faq_sub_title = isset($automobile_var_faq_sub_title) ? $automobile_var_faq_sub_title : '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        if (isset($column_class) && $column_class <> '') {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }
        $boxex_class = '';
        if (isset($automobile_var_faq_view) && $automobile_var_faq_view == 'modern') {
            $boxex_class = ' box';
        }
 
        if($automobile_var_faq_main_title <> '')
        $html .= '<div class="cs-element-title">
            <h2>' . esc_attr($automobile_var_faq_main_title) . '</h2>
        </div>';
        
        $html .= '<div class="panel-group ' . $boxex_class . '" id="faq_' . absint($acc_counter) . '">';
        $html .= do_shortcode($content);
        $html .= '</div>';
        //  $html .= '</div>';

        if (isset($column_class) && $column_class <> '') {
            $html .= '</div>';
        }

        return $html;
    }

    if (function_exists('automobile_short_code')) {
        automobile_short_code('automobile_faq', 'automobile_faq_shortcode');
    }
}
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('automobile_faq', 'automobile_faq_shortcode');
/*
 *
 * @Accordion Item
 * @retrun
 *
 */
if (!function_exists('automobile_faq_item_shortcode')) {

    function automobile_faq_item_shortcode($atts, $content = "") {
        global $acc_counter,$automobile_var_faq_view;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        $defaults = array(
            'automobile_var_faq_title' => 'Title',
            'automobile_var_icon_box' => '',
            'automobile_var_faq_active' => 'yes',
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_acc_icon = '';
        $automobile_var_faq_title = isset($automobile_var_faq_title) ? $automobile_var_faq_title : '';
        $automobile_var_icon_box = isset($automobile_var_icon_box) ? $automobile_var_icon_box : '';
        $automobile_var_faq_active = isset($automobile_var_faq_active) ? $automobile_var_faq_active : '';
         if (isset($automobile_var_faq_view) && $automobile_var_faq_view == 'modern') {
        $automobile_var_acc_icon .= '<span class="cs-color">' . automobile_var_theme_text_srt('automobile_var_accordian_q') . '</span>';

        if (isset($automobile_var_icon_box) && $automobile_var_icon_box != '') {
            $automobile_var_acc_icon .= '<i class="' . $automobile_var_icon_box . '"></i>';
        }
         }else{
              if ($automobile_var_icon_box == '') {
            $automobile_var_acc_icon .= '<span class="cs-color">' . automobile_var_theme_text_srt('automobile_var_accordian_q') . '</span>';
        }
         if (isset($automobile_var_icon_box) && $automobile_var_icon_box != '') {
            $automobile_var_acc_icon .= '<i class="' . $automobile_var_icon_box . '"></i>';
        }
         }
        $faq_count = 0;
        $faq_count = rand(4045, 99999);
        $html = '';
        $active_in = '';
        $active_class = '';
        $styleColapse = 'collapsed';
        if (isset($automobile_var_faq_active) && $automobile_var_faq_active == 'yes') {
            $active_in = 'in';
            $styleColapse = '';
        } else {
            $active_class = 'collapsed';
        }

        $html .= ' <div class="panel panel-default">';
        $html .= '  <div class="panel-heading">';
        $html .= '   <h6 class="panel-title">';
        $html .= '<a class="' . esc_html($active_class) . '" data-toggle="collapse" data-parent="#faq_' . absint($acc_counter) . '" href="#collapse' . absint($faq_count) . '">' . $automobile_var_acc_icon . esc_html($automobile_var_faq_title) . '</a>';
        $html .= '   </h6>';
        $html .= ' </div>';
        $html .= '  <div id="collapse' . absint($faq_count) . '" class="panel-collapse collapse ' . esc_html($active_in) . '"	>';
        $html .= '     <div class="panel-body">' . do_shortcode($content) . '</div>';
        $html .= ' </div>';
        $html .= '</div>
		
		';
        return $html;
    }

    if (function_exists('automobile_short_code')) {
        automobile_short_code('faq_item', 'automobile_faq_item_shortcode');
    }
}
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('faq_item', 'automobile_faq_item_shortcode');
?>