<?php

/*
 *
 * @Shortcode Name : Accordion
 * @retrun
 *
 */
if (!function_exists('automobile_accordion_shortcode')) {

    function automobile_accordion_shortcode($atts, $content = "") {


        global $acc_counter, $automobile_var_accordion_column;
        $acc_counter = rand(40, 9999999);

        $html = '';
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_accordion_view' => '',
            'automobile_var_accordion_column' => '',
            'automobile_var_accordian_sub_title' => '',
            'automobile_var_accordian_main_title' => ''
        );
        extract(shortcode_atts($defaults, $atts));

        $column_class = '';
        $automobile_var_accordion_view = isset($automobile_var_accordion_view) ? $automobile_var_accordion_view : '';
        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_var_accordian_main_title = isset($automobile_var_accordian_main_title) ? $automobile_var_accordian_main_title : '';
        $automobile_var_accordian_sub_title = isset($automobile_var_accordian_sub_title) ? $automobile_var_accordian_sub_title : '';
        $automobile_var_counter_col = isset($automobile_var_accordion_column) ? $automobile_var_accordion_column : '';

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
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        if (isset($column_class) && $column_class <> '') {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }
        $boxex_class = '';
        if (isset($automobile_var_accordion_view) && $automobile_var_accordion_view == 'modern') {
            $boxex_class = ' box';
        }

        if (isset($automobile_var_accordian_main_title) && trim($automobile_var_accordian_main_title) <> '') {
            $html .= '<div class="cs-element-title">
                <h2>' . esc_attr($automobile_var_accordian_main_title) . '</h2>
            </div>';
        }
        $html .= '<div class="panel-group ' . $boxex_class . '" id="accordion_' . absint($acc_counter) . '" role="tablist" aria-multiselectable="true">';
        $html .= do_shortcode($content);
        $html .= '</div>';
        


        if (isset($column_class) && $column_class <> '') {
            $html .= '</div>';
        }

        return $html;
    }
//    if (function_exists('automobile_short_code')) {
//        automobile_short_code('automobile_accordion', 'automobile_accordion_shortcode');
//    }
    if (function_exists('automobile_var_short_code'))
{
    automobile_var_short_code('automobile_accordion', 'automobile_accordion_shortcode');
}

}

/*
 *
 * @Accordion Item
 * @retrun
 *
 */
if (!function_exists('automobile_accordion_item_shortcode')) {

    function automobile_accordion_item_shortcode($atts, $content = "") {
        global $acc_counter;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        $defaults = array(
            'automobile_var_accordion_title' => 'Title',
            'automobile_var_icon_box' => '',
            'automobile_var_accordion_active' => 'yes',
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_acc_icon = '';
        $automobile_var_accordion_title = isset($automobile_var_accordion_title) ? $automobile_var_accordion_title : '';
        $automobile_var_icon_box = isset($automobile_var_icon_box) ? $automobile_var_icon_box : '';
        $automobile_var_accordion_active = isset($automobile_var_accordion_active) ? $automobile_var_accordion_active : '';

        if (isset($automobile_var_icon_box) && $automobile_var_icon_box != '') {
            $automobile_var_acc_icon = '<i class="' . $automobile_var_icon_box . '"></i>';
        }

        $accordion_count = 0;
        $accordion_count = rand(4045, 99999);
        $html = '';
        $active_in = '';
        $active_class = '';
        $styleColapse = 'collapsed';
        if (isset($automobile_var_accordion_active) && $automobile_var_accordion_active == 'yes') {
            $active_in = 'in';
            $styleColapse = '';
        } else {
            $active_class = 'collapsed';
        }
        $html .= ' <div class="panel panel-default">';
        $html .= '  <div class="panel-heading" role="tab" id="heading_' . absint($accordion_count) . '">';
        $html .= '   <h6 class="panel-title">';
        $html .= '<a  role="button" class="' . esc_html($active_class) . '" data-toggle="collapse" data-parent="#accordion_' . absint($acc_counter) . '" href="#collapse' . absint($accordion_count) . '">' . $automobile_var_acc_icon . esc_html($automobile_var_accordion_title) . '</a>';
        $html .= '   </h6>';
        $html .= ' </div>';
        $html .= '  <div id="collapse' . absint($accordion_count) . '" class="panel-collapse collapse ' . esc_html($active_in) . '"	role="tabpanel" aria-labelledby="heading_' . absint($accordion_count) . '">';
        $html .= '     <div class="panel-body">' . do_shortcode($content) . '</div>';
        $html .= ' </div>';
        $html .= '</div>
		';
        return $html;
    }

//    if (function_exists('automobile_short_code')) {
//        automobile_short_code('accordion_item', 'automobile_accordion_item_shortcode');
//    }
    
    if (function_exists('automobile_var_short_code'))
{
    automobile_var_short_code('accordion_item', 'automobile_accordion_item_shortcode');
}
}

?>