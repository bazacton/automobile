<?php

/*
 *
 * @File : Call to action
 * @retrun
 *
 */

if (!function_exists('automobile_var_call_to_action_shortcode')) {

    function automobile_var_call_to_action_shortcode($atts, $content = "") {
	$defaults = array(
	    'automobile_var_column_size' => '',
	    'automobile_var_call_to_action_title' => '',
	    'automobile_var_call_action_subtitle' => '',
	    'automobile_var_heading_color' => '#000',
	    'automobile_var_call_to_action_icon_background_color' => '',
	    'automobile_var_call_to_action_button_text' => '',
	    'automobile_var_call_to_action_button_link' => '#',
	    'automobile_var_call_to_action_bg_img' => '',
	    'automobile_var_contents_bg_color' => '',
	    'automobile_var_call_to_action_top_img_array' => '',
	    'automobile_var_call_to_action_img_array' => '',
	    'automobile_var_call_action_view' => '',
	    'automobile_var_call_action_text_align' => '',
	    'automobile_var_call_to_action_class' => '',
	    'automobile_var_call_action_img_align' => '',
	    'automobile_var_button_bg_color' => '',
	    'automobile_var_button_border_color' => '',
	    'automobile_var_call_action_style' => ''
	);



	extract(shortcode_atts($defaults, $atts));

	$automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
	$automobile_var_call_to_action_img_array = isset($automobile_var_call_to_action_img_array) ? $automobile_var_call_to_action_img_array : '';
	$automobile_var_call_action_img_align = isset($automobile_var_call_action_img_align) ? $automobile_var_call_action_img_align : '';
	$automobile_var_call_to_action_title = isset($automobile_var_call_to_action_title) ? $automobile_var_call_to_action_title : '';
	$automobile_var_call_action_text_align = isset($automobile_var_call_action_text_align) ? $automobile_var_call_action_text_align : '';
	$automobile_var_call_action_style = isset($automobile_var_call_action_style) ? $automobile_var_call_action_style : '';
	$automobile_var_call_to_action_top_img_array = isset($automobile_var_call_to_action_top_img_array) ? $automobile_var_call_to_action_top_img_array : '';
	$automobile_var_call_action_subtitle = isset($automobile_var_call_action_subtitle) ? $automobile_var_call_action_subtitle : '';
	$automobile_var_heading_color = isset($automobile_var_heading_color) ? $automobile_var_heading_color : '';
	$automobile_var_call_action_contents = $content;
	$automobile_var_call_to_action_button_text = isset($automobile_var_call_to_action_button_text) ? $automobile_var_call_to_action_button_text : '';
	$automobile_var_call_to_action_button_link = isset($automobile_var_call_to_action_button_link) ? $automobile_var_call_to_action_button_link : '';
	$automobile_var_button_bg_color = isset($automobile_var_button_bg_color) ? $automobile_var_button_bg_color : '';
	$automobile_var_button_border_color = isset($automobile_var_button_border_color) ? $automobile_var_button_border_color : '';
	$automobile_var_call_to_action_icon_background_color = isset($automobile_var_call_to_action_icon_background_color) ? $automobile_var_call_to_action_icon_background_color : '';
	$column_class = '';
	if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
	    if (function_exists('automobile_var_custom_column_class')) {
		$column_class = automobile_var_custom_column_class($automobile_var_column_size);
	    }
	}
	$style_string = $automobile_var_CustomId = '';
	if ($automobile_var_call_to_action_img_array) {
	    $style_string .= ' background:url(' . esc_url($automobile_var_call_to_action_img_array) . ') ' . esc_html($automobile_var_call_action_img_align) . ' !important; background-color:#fff;';
	} else {
	    $style_string .= ' background-color:' . esc_html($automobile_var_contents_bg_color) . ' !important;';
	}
	$style_string = ' style="' . $style_string . '"';

	$html = '';
	if ($automobile_var_call_to_action_title <> '') {
	    $html .= '<div class="cs-element-title"><h2>' . esc_attr($automobile_var_call_to_action_title) . '</h2></div>';
	}
	$html .= '<div ' . automobile_var_allow_special_char($style_string) . '>';
	if (isset($column_class) && $column_class <> '') {
	    $html .= '<div  class="' . esc_html($column_class) . '" >';
	}
	$html .= '<div class="cs-calltoaction  '.$automobile_var_call_action_style.'  align-' . $automobile_var_call_action_text_align . '">';
	if (isset($automobile_var_call_action_style) && $automobile_var_call_action_style == 'classic') {
	    $html .= '   <div class="cs-media">';
	    if ($automobile_var_call_to_action_top_img_array != '') {
		$html .= '<figure>';

		$html .= '<img class="lazyload no-src" src="' . esc_url($automobile_var_call_to_action_top_img_array) . '" >';

		$html .= '</figure>';
	    }
	    $html .= '</div>';
	}
	$html .= '<div class="cs-text">';
	if (isset($automobile_var_call_action_subtitle) && $automobile_var_call_action_subtitle <> '') {
	    $color_string = '';
	    if ($automobile_var_heading_color != '') {
		$color_string = ' style="color:' . esc_html($automobile_var_heading_color) . ' !important;"';
	    }
	    $html .= '<h2 ' . automobile_var_allow_special_char($color_string) . '>' . esc_html($automobile_var_call_action_subtitle) . '</h2>';
	}
	if ($automobile_var_call_action_contents != '') {
	    $color_string = '';

	    $html .= do_shortcode($automobile_var_call_action_contents);
	}
	if (isset($automobile_var_call_to_action_button_text) and $automobile_var_call_to_action_button_text <> '') {
	    $color_string = '';
	    $button_text_color = '';
	    if ($automobile_var_call_to_action_icon_background_color != '') {
		$button_text_color = ' color:' . $automobile_var_call_to_action_icon_background_color . ' !important;';
	    }
	    $button_border_color = '';
	    if ($automobile_var_button_border_color != '') {
		$button_border_color = ' border: 2px solid ' . $automobile_var_button_border_color . ' !important;';
	    }
	    if ($automobile_var_button_bg_color != '' || $automobile_var_call_to_action_icon_background_color != '') {
		$color_string = ' style="background-color:' . esc_html($automobile_var_button_bg_color) . ' !important; ' . $button_text_color . '' . $button_border_color . '"';
	    }

	    $html .= '</div>';
	    $html .= '<a href="' . esc_url($automobile_var_call_to_action_button_link) . '" class="csborder-color cs-color" ' . automobile_var_allow_special_char($color_string) . '>' . esc_html($automobile_var_call_to_action_button_text) . '</a>';
	}
	$html .= '</div>';

	if (isset($column_class) && $column_class <> '') {
	    $html .= '</div>';
	}
	$html .= '</div>';
	$html .= '</div>';

	return $html;
    }

    if (function_exists('automobile_var_short_code')) {
	automobile_var_short_code('call_to_action', 'automobile_var_call_to_action_shortcode');
    }
}