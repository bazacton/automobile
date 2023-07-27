<?php

/*
 *
 * @Shortcode Name : Start function for Eitor shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_editor_shortocde')) {
    function automobile_var_editor_shortocde($atts, $content = "") {
	$defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_editor_title' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $html = '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        if((isset($automobile_var_editor_title) && $automobile_var_editor_title <> "") || (isset($content) && $content <> "")){
            if (isset($column_class) && $column_class <> '') {
                $html .= '<div class="' . $column_class . '">';
            }
                ///// Editor Element Title
                if(isset($automobile_var_editor_title) && $automobile_var_editor_title <> ""){
                    $html .= '<div class="cs-element-title">';
                        $html .= '<h2>'. $automobile_var_editor_title.'</h2>';
                    $html .= '</div>';
                }
                ///// Editor Content
                if(isset($content) && $content <> ""){
                    $content = nl2br($content);
                    $content = automobile_var_custom_shortcode_decode($content);
                    $html .= '<div class="automobile_editor"><div class="row">' . do_shortcode($content) . '</div></div>';
                }

            if (isset($column_class) && $column_class <> '') {
                $html .= ' </div>';
            }
        }
	return $html;
        
	 }
    if (function_exists('automobile_var_short_code')){
        automobile_var_short_code('automobile_editor', 'automobile_var_editor_shortocde');
    }
}