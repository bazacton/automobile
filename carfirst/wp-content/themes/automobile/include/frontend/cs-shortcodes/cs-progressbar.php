<?php

/*
 *
 * @Shortcode Name :  Start function for Progressbar  shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_progressbars_shortcode')) {

    function automobile_var_progressbars_shortcode($atts, $content = "") {
        
        $defaults = array(
            'column_size' => '1/1',
            'progressbars_element_title' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = automobile_var_custom_column_class($column_size);
        
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('.progress .progress-bar').css("width",
                        function () {
                            return $(this).attr("aria-valuenow") + "%";
                        }
                )
            });

        </script>
        <?php

        $output = '';
        $output .= '<div class="cs-element-title">';
        $output .= '<h2> ' . esc_html($progressbars_element_title) . '</h2>';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('automobile_progressbar', 'automobile_var_progressbars_shortcode');
    }
}

/*
 *
 * @Shortcode Name :  Start function for Progressbar  item shortcode/element front end view
 * @retrun
 *
 */



if (!function_exists('automobile_var_progressbar_item_shortcode')) {

    function automobile_var_progressbar_item_shortcode($atts, $content = "") {
        
        $defaults = array('progressbars_title' => '', 'progressbars_color' => '', 'progressbars_percentage' => '50');
        extract(shortcode_atts($defaults, $atts));
        $progressbars_color = isset($progressbars_color) ? $progressbars_color : '';
        $output = '';
        $output .= '<div class="progress-info">';
        $output .= '<span>' . esc_html($progressbars_title) . '</span>';
        $output .= '<small>' . $progressbars_percentage . '%</small>';
        $output .= '</div>';
        $output .= '<div class="progress skill-bar">';
        $output .= '<div class="progress-bar progress-bar-success" style="background:' . $progressbars_color . '; " role="progressbar" aria-valuenow="' . $progressbars_percentage . '" aria-valuemin="0" aria-valuemax="100" ></div>';
        $output .= '</div>';
        return $output;
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('progressbar_item', 'automobile_var_progressbar_item_shortcode');
    }
}
?>