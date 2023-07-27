<?php

/**
 * @Divider html form for page builder
 */
if (!function_exists('automobile_var_automobile_divider_shortcode')) {

    function automobile_var_automobile_divider_shortcode($atts, $content = "") {

        $automobile_var_defaults = array(
            'automobile_var_divider_padding_left' => '0',
            'automobile_var_divider_padding_right' => '0',
            'automobile_var_divider_margin_top' => '0',
            'automobile_var_divider_margin_buttom' => '0',
            'automobile_var_divider_views' => '',			
            'automobile_var_divider_align' => '',
        );
        extract(shortcode_atts($automobile_var_defaults, $atts));


        $automobile_var_divider_padding_left = isset($automobile_var_divider_padding_left) ? $automobile_var_divider_padding_left : '';
        $automobile_var_divider_padding_right = isset($automobile_var_divider_padding_right) ? $automobile_var_divider_padding_right : '';
        $automobile_var_divider_margin_top = isset($automobile_var_divider_margin_top) ? $automobile_var_divider_margin_top : '';
        $automobile_var_divider_margin_buttom = isset($automobile_var_divider_margin_buttom) ? $automobile_var_divider_margin_buttom : '';
        $automobile_var_divider_views = isset($automobile_var_divider_views) ? $automobile_var_divider_views : '';
		$automobile_var_divider_align = isset($automobile_var_divider_align) ? $automobile_var_divider_align : '';
		
		
//		var_dump($automobile_var_divider_views);
//		
//		die("dead end");
		
		
        $style_string = '';
        $html = '';
        if ($automobile_var_divider_padding_left != '' || $automobile_var_divider_padding_right != '' || $automobile_var_divider_margin_top != '' || $automobile_var_divider_margin_buttom != '') {
            $style_string .= ' ';

			if ($automobile_var_divider_padding_left != '') {
                $style_string .= ' padding-left:' . esc_html($automobile_var_divider_padding_left) . 'px; ';
            }

			if ($automobile_var_divider_padding_right != '') {
                $style_string .= ' padding-right:' . esc_html($automobile_var_divider_padding_right) . 'px; ';
            }

			if ($automobile_var_divider_margin_top != '') {
                $style_string .= ' margin-top:' . esc_html($automobile_var_divider_margin_top) . 'px; ';
            }

			if ($automobile_var_divider_margin_buttom != '') {
                $style_string .= ' margin-bottom:' . esc_html($automobile_var_divider_margin_buttom) . 'px; ';
            }

			
			$divider_view = '';
			
			if ($automobile_var_divider_views != '') {
                $divider_view = $automobile_var_divider_views;
            }
			

            $style_string .= ' ';
        }
		
        $html .= '<div class="' . esc_html($automobile_var_divider_align) . '">';
            $html .= '<div  style=" ' . esc_html($style_string) . '" class="cs-spreator">';
                $html .= '<div class="cs-seprater '.$divider_view.'" style="text-align:center;"> <span> <i class="icon-transport177"> </i> </span> </div>';
            $html .= '</div>';
        $html .= '</div>';

        return do_shortcode($html);
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_divider', 'automobile_var_automobile_divider_shortcode');
}