<?php

/**
 * Ads html form for page builder
 */
if (!function_exists('automobile_var_automobile_ads')) {

    function automobile_var_automobile_ads($atts, $content = "") {


        global $automobile_var_options;
        $defaults = array('id' => '0');
        extract(shortcode_atts($defaults, $atts));
        $html = '';
        if (isset($automobile_var_options['automobile_var_banner_field_code_no']) && is_array($automobile_var_options['automobile_var_banner_field_code_no'])) {
            $i = 0;
            foreach ($automobile_var_options['automobile_var_banner_field_code_no'] as $banner) :
                if ($automobile_var_options['automobile_var_banner_field_code_no'][$i] == $id) {
                    break;
                }
                $i++;
            endforeach;

            $automobile_var_banner_title = isset($automobile_var_options['automobile_var_banner_title'][$i]) ? $automobile_var_options['automobile_var_banner_title'][$i] : '';
            $automobile_var_banner_style = isset($automobile_var_options['automobile_var_banner_style'][$i]) ? $automobile_var_options['automobile_var_banner_style'][$i] : '';
            $automobile_var_banner_type = isset($automobile_var_options['automobile_var_banner_type'][$i]) ? $automobile_var_options['automobile_var_banner_type'][$i] : '';
            $automobile_var_banner_image = isset($automobile_var_options['automobile_var_banner_image_array'][$i]) ? $automobile_var_options['automobile_var_banner_image_array'][$i] : '';
            $automobile_var_banner_url = isset($automobile_var_options['automobile_var_banner_field_url'][$i]) ? $automobile_var_options['automobile_var_banner_field_url'][$i] : '';
            $automobile_var_banner_url_target = isset($automobile_var_options['automobile_var_banner_target'][$i]) ? $automobile_var_options['automobile_var_banner_target'][$i] : '';
            $automobile_var_banner_adsense_code = isset($automobile_var_options['automobile_var_adsense_code'][$i]) ? $automobile_var_options['automobile_var_adsense_code'][$i] : '';
            $automobile_var_banner_code_no = isset($automobile_var_options['automobile_var_banner_field_code_no'][$i]) ? $automobile_var_options['automobile_var_banner_field_code_no'][$i] : '';

            $html .= '<div class="automobile_banner_section">';
            if ($automobile_var_banner_type == 'image') {
                if (!isset($_COOKIE["banner_clicks_" . $automobile_var_banner_code_no])) {
                    $html .= '<a onclick="automobile_var_banner_click_count_plus(\'' . admin_url('admin-ajax.php') . '\', \'' . $automobile_var_banner_code_no . '\')" id="banner_clicks' . $automobile_var_banner_code_no . '" href="' . esc_url($automobile_var_banner_url) . '" target="_blank"><img src="' . esc_url($automobile_var_banner_image) . '" alt="' . $automobile_var_banner_title . '" /></a>';
                } else {
                    $html .= '<a href="' . esc_url($automobile_var_banner_url) . '" target="' . $automobile_var_banner_url_target . '"><img src="' . esc_url($automobile_var_banner_image) . '" alt="' . $automobile_var_banner_title . '" /></a>';
                }
            } else {
                $html .= wp_specialchars_decode(stripslashes($automobile_var_banner_adsense_code));
            }
            $html .= '</div>';
        }
        $html .= '<script type="text/javascript">
    function automobile_var_banner_click_count_plus(ajax_url, id) {
        "use strict";
        var dataString = "code_id=" + id + "&action=automobile_var_banner_click_count_plus";
        jQuery.ajax({
            type: "POST",
            url: ajax_url,
            data: dataString,
            success: function (response) {
                if (response != "error") {
                    jQuery("#banner_clicks" + id).removeAttr("onclick");
                }
            }
        });
        return false;
    }
</script>';
        return $html;



        return do_shortcode($html);
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_ads', 'automobile_var_automobile_ads');
}