<?php

/**
 * @Spacer html form for page builder
 */
if (!function_exists('automobile_var_spacer_shortcode')) {

    function automobile_var_spacer_shortcode($atts, $content = "") {
        global $automobile_border;

        $automobile_var_defaults = array('automobile_var_spacer_height' => '25');
        extract(shortcode_atts($automobile_var_defaults, $atts));
		
       return '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:' . do_shortcode($automobile_var_spacer_height) . 'px">
		</div>';
        
   

	}
if(function_exists('automobile_var_short_code')) automobile_var_short_code('spacer', 'automobile_var_spacer_shortcode');
    
}