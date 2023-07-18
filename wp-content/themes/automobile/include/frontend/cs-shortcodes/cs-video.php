<?php

/*
 *
 * @Shortcode Name : Video 
 * @retrun
 *
 */
if (!function_exists('automobile_var_video')) {

    function automobile_var_video($atts, $content = "") {
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_video_title' => '',
            'automobile_var_video_url' => '',
            'automobile_var_video_width' => '',
            'automobile_var_video_height' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_video_title = isset($automobile_var_video_title) ? $automobile_var_video_title : '';
        $automobile_var_video_url = isset($automobile_var_video_url) ? $automobile_var_video_url : '';
        $automobile_var_video_url =  ($automobile_var_video_url) ? $automobile_var_video_url : '';
        $automobile_var_video_width = isset($automobile_var_video_width) ? $automobile_var_video_width : '500';
        $automobile_var_video_height = isset($automobile_var_video_height) ? $automobile_var_video_height : '300';
        
        $video_url = '';
        $video_url = parse_url($automobile_var_video_url);
        $automobile_iframe = '<' . 'i' . 'frame ';
        ///// Column Class
        $column_class = '';
        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        //////// Start Element Column CLass
        $video = '';
        if (isset($column_class) && $column_class <> '') {
            $video .= '<div class="' . $column_class . '">';
        }
        
        //////// Start Video Element Content
        if ($automobile_var_video_title != '') {
            $video .= '<div class="cs-element-title"><h2>' . $automobile_var_video_title . '</h2></div>';
        }
        if($automobile_var_video_url != '' ){
            if ($video_url['host'] == cs_get_server_data("SERVER_NAME")) {
                $video .= '<figure  class="cs-video ' . $column_class . '">';
                $video .= '' . do_shortcode('[video width="' . $automobile_var_video_width . '" height="' . $automobile_var_video_height . '" src="' . esc_url($automobile_var_video_url) . '"][/video]') . '';
                $video .= '</figure>';
            } else {
                if ($video_url['host'] == 'vimeo.com') {
                    $content_exp = explode("/", $automobile_var_video_url);
                    $content_vimo = array_pop($content_exp);
                    $video .= '<figure  class="cs-video ' . $column_class . '">';
                    $video .= $automobile_iframe . ' width="' . $automobile_var_video_width . '" height="' . $automobile_var_video_height . '" src="'.automobile_server_protocol().'player.vimeo.com/video/' . $content_vimo . '" allowfullscreen></iframe>';
                    $video .= '</figure>';
                } else {
                    $video .= wp_oembed_get($automobile_var_video_url, array( 'height' => $automobile_var_video_height.'px', 'width' => $automobile_var_video_width.'px' ));
                }
            }
        }
		
		
		
		
        //////// End Video Element Content
        
        //////// End Element Column CLass
        if (isset($column_class) && $column_class <> '') {
            $video .= '</div>';
        }
        return $video;
    }

    if(function_exists('automobile_var_short_code')) automobile_var_short_code('automobile_video', 'automobile_var_video');
}

function automobile_oembed_filter( $return, $data, $url ) {
        $return = str_replace('frameborder="0"', 'style="border: none"', $return);
	return $return;
}
add_filter('oembed_dataparse', 'automobile_oembed_filter', 90, 3);