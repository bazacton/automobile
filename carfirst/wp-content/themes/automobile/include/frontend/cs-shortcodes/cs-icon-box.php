<?php
/*
 *
 * @Shortcode Name :  Start function for Multiple icon_box shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_var_icon_boxes_shortcode')) {
    function automobile_var_icon_boxes_shortcode($atts, $content = "") {
        global $post, $automobile_var_icon_box_column, $automobile_var_link_url, $automobile_var_icon_box_view, $automobile_var_icon_box_icon_size, $automobile_icon_box_content_align;
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_icon_boxes_title' => '',
            'automobile_var_icon_boxes_sub_title' => '',
            'automobile_var_icon_box_column' => '',
            'automobile_icon_box_content_color' => '',
            'automobile_title_color' => '',
            'automobile_var_icon_box_view' => '',
            'automobile_icon_box_icon_color' => '',
            'automobile_var_icon_box_icon_size' => '',
            'automobile_icon_box_content_align' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_var_icon_boxes_title = isset($automobile_var_icon_boxes_title) ? $automobile_var_icon_boxes_title : '';
        $automobile_var_icon_boxes_sub_title = isset($automobile_var_icon_boxes_sub_title) ? $automobile_var_icon_boxes_sub_title : '';
        $automobile_var_icon_box_column = isset($automobile_var_icon_box_column) ? $automobile_var_icon_box_column : '';
        $automobile_var_link_url = isset($automobile_var_link_url) ? $automobile_var_link_url : '';
        $automobile_var_icon_box_view = isset($automobile_var_icon_box_view) ? $automobile_var_icon_box_view : '';
        $automobile_var_icon_box_icon_size = isset($automobile_var_icon_box_icon_size) ? $automobile_var_icon_box_icon_size : '';
        $automobile_icon_box_content_align = isset($automobile_icon_box_content_align) ? $automobile_icon_box_content_align : '';
        $column_class = '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        $automobile_section_title = '';
        $html = '';
        $title_subtitle_style = '';
        if (isset($automobile_icon_box_content_color) && $automobile_icon_box_content_color != '') {

            $title_subtitle_style = 'style="color:' . $automobile_icon_box_content_color . ' !important;"';
        }
        if ($automobile_var_icon_boxes_title <> '' || $automobile_var_icon_boxes_sub_title <> '') {
            $automobile_section_title .= '<div class="cs-element-title">';
            if ($automobile_var_icon_boxes_title <> '') {
                $automobile_section_title .= '<h2 ' . $title_subtitle_style . '>' . esc_attr($automobile_var_icon_boxes_title) . '</h2>';
            }
            if ($automobile_var_icon_boxes_sub_title <> '') {
                $automobile_section_title .= do_shortcode($automobile_var_icon_boxes_sub_title);
            }
            $automobile_section_title .= '</div>';
        }
        if ($automobile_section_title != '' || $content != '') {
            if (isset($column_class) && $column_class <> '') {
                $html .= '<div class="' . $column_class . '">';
            }
            if ($automobile_section_title != '') {
                $html .= $automobile_section_title;
            }
            if ($content != '') {
                $html .= '<div class="cs-icon_boxes-list">'
                        . '<div class="row">';
                $html .= do_shortcode($content);
                $html .= '</div></div>';
            }
            if (isset($column_class) && $column_class <> '') {
                $html .= '</div>';
            }
        }
        return do_shortcode(do_shortcode($html));
    }
    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('icon_box', 'automobile_var_icon_boxes_shortcode');
    }
}
/*
 *
 * @Multiple  Start function for Multiple icon_box Item  shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_var_icon_boxes_item_shortcode')) {

    function automobile_var_icon_boxes_item_shortcode($atts, $content = "") {
        $defaults = array(
            'icon_boxes_style' => '',
            'automobile_var_icon_box_title' => '',
            'automobile_var_icon_boxes_icon' => '',
            'automobile_var_link_url' => '',
            'automobile_var_icon_box_icon_type' => '',
            'automobile_var_icon_box_image' => '',
        );
        global $post, $automobile_var_icon_box_column, $automobile_var_link_url, $automobile_title_color, $automobile_icon_box_icon_color, $automobile_var_icon_box_icon_size, $automobile_var_icon_box_view, $automobile_icon_box_content_align;
        extract(shortcode_atts($defaults, $atts));
        $html = '';
        $automobile_var_icon_box_view = isset($automobile_var_icon_box_view) ? $automobile_var_icon_box_view : '';
        $automobile_var_icon_boxes_icon = isset($automobile_var_icon_boxes_icon) ? $automobile_var_icon_boxes_icon : '';
        $automobile_var_icon_box_title = isset($automobile_var_icon_box_title) ? $automobile_var_icon_box_title : '';
        $automobile_var_link_url = isset($automobile_var_link_url) ? $automobile_var_link_url : '';
        $automobile_var_icon_box_icon_type = isset($automobile_var_icon_box_icon_type) ? $automobile_var_icon_box_icon_type : '';
        $automobile_var_icon_box_image = isset($automobile_var_icon_box_image) ? $automobile_var_icon_box_image : '';
        $col_class = '';
        if (isset($automobile_var_icon_box_column) && $automobile_var_icon_box_column != '') {
            $number_col = 12 / $automobile_var_icon_box_column;
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

        if ($automobile_var_icon_boxes_icon != '' || $automobile_var_icon_box_title != '' || $content != '') {
            $html .= ' <div class="'. $col_class .'">';
            $html .= '<div class="cs-services ' . $automobile_var_icon_box_view . ' '.$automobile_icon_box_content_align.'">';

            if ($automobile_var_icon_boxes_icon != '' && $automobile_var_icon_box_icon_type == 'icon') {
                $html .= '<div class="cs-media">';
                if ($automobile_var_link_url != '') {
                    $html .= '<a href="' . esc_url($automobile_var_link_url) . '">';
                }
		if(isset($automobile_var_icon_box_view) && $automobile_var_icon_box_view == 'classic'){
                $html .= '<i class="' . esc_attr($automobile_var_icon_boxes_icon) . ' ' . $automobile_var_icon_box_icon_size . '" style="color:' . $automobile_icon_box_icon_color . ' !important;line-height:50px;">
                    </i>';
		} else{
		    $html .= '<i class="cs-color ' . esc_attr($automobile_var_icon_boxes_icon) . ' ' . $automobile_var_icon_box_icon_size . '" style="color:' . $automobile_icon_box_icon_color . ' !important;line-height:50px;"> 
		     </i>';
		}
                if ($automobile_var_link_url != '') {
                    $html .= '</a>';
                }
                $html .= '</div>';
            } elseif ($automobile_var_icon_box_image != '' && $automobile_var_icon_box_icon_type == 'image') {
                $html .= '<div class="cs-media">';
                if ($automobile_var_link_url != '') {
                    $html .= '<a href="' . esc_url($automobile_var_link_url) . '">';
                }
                $html .= '<div class="cs-media"><img src="' . esc_url($automobile_var_icon_box_image) . '" alt="' . esc_html($automobile_var_icon_box_title) . '"></div>';
                if ($automobile_var_link_url != '') {
                    $html .= '</a>';
                }
                $html .= '</div>';
            }
            if ($automobile_var_icon_box_title != '' || $content != '') {
                $html .= '<div class="cs-text left">';
                if ($automobile_var_icon_box_title != '') {
                    $html .= '<h6 style="color:' . $automobile_title_color . ' !important;">';
                    if ($automobile_var_link_url != '') {
                        $html .= '<a href="' . esc_url($automobile_var_link_url) . '" style="color:' . $automobile_title_color . ' !important;">';
                    }
                    $html .= $automobile_var_icon_box_title;
                    if ($automobile_var_link_url != '') {
                        $html .= '</a>';
                    }
                    $html .= '</h6>';
                }
                if ($content != '') {
                    $html .=  do_shortcode($content);
                }
                $html .= '</div>';
            }
            $html .= '</div>';
            $html .= '</div>';
        }
        return do_shortcode($html);
    }
    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('icon_boxes_item', 'automobile_var_icon_boxes_item_shortcode');
    }
}
/*
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('icon_boxes_item', 'automobile_var_icon_boxes_item_shortcode');
 * 
 */
?>