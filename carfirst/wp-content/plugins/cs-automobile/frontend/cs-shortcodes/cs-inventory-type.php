<?php

/**
 * @Ads html form for page builder
 */
if (!function_exists('automobile_var_inventory_type_shortcode')) {

    function automobile_var_inventory_type_shortcode($atts, $content = "") {
        global $automobile_var_plugin_options, $automobile_var_plugin_static_text;
        $automobile_var_defaults = array(
            'column_size' => '1/1',
            'automobile_inventory_type_title' => '',
            'automobile_inventory_type_sub_title' => '',
            'automobile_var_inventories' => '',
	    'automobile_var_inventories_style' => '',
            'automobile_inventory_type_button_title' => '',
            'automobile_inventory_type_button_url' => '',
        );
        extract(shortcode_atts($automobile_var_defaults, $atts));

        $html = '';
        $automobile_inventory_type_title = isset($automobile_inventory_type_title) ? $automobile_inventory_type_title : '';
        $automobile_inventory_type_sub_title = isset($automobile_inventory_type_sub_title) ? $automobile_inventory_type_sub_title : '';
        $automobile_var_inventories = isset($automobile_var_inventories) ? $automobile_var_inventories : '';
        $inventories = get_post($automobile_var_inventories);
        $automobile_inventory_type_button_title = isset($automobile_inventory_type_button_title) ? $automobile_inventory_type_button_title : '';
	$automobile_var_inventories_style = isset($automobile_var_inventories_style) ? $automobile_var_inventories_style : '';
        $automobile_inventory_type_button_url = isset($automobile_inventory_type_button_url) ? $automobile_inventory_type_button_url : '';
        $automobile_var_get_makes = get_post_meta($automobile_var_inventories, 'automobile_inventory_type_makes');
        $automobile_search_result_page = isset($automobile_var_plugin_options['automobile_search_result_page']) ? $automobile_var_plugin_options['automobile_search_result_page'] : '';
        $count_available = 0;
        $make = '';
        if (!function_exists('get_count')) {

            function get_count($make, $type) {
                $args = array(
                    'post_type' => 'inventory',
                    'post_status' => 'publish',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'field' => 'automobile_inventory_status',
                            'value' => 'active',
                        ),
                        array(
                            'field' => 'automobile_inventory_type',
                            'value' => $type,
                        ),
                    ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'inventory-make',
                            'field' => 'slug',
                            'terms' => $make
                        )
                    )
                );
                $my_query = new WP_Query($args);
                $count = 0;
                while ($my_query->have_posts()) : $my_query->the_post();
                    $exp_date = get_post_meta(get_the_ID(), 'automobile_inventory_expired', true);
                    if ($exp_date > time()) {
                        $count++;
                    }

                endwhile;
                wp_reset_postdata();
                return $count;
            }

        }

        if (is_array($automobile_var_get_makes) && !empty($automobile_var_get_makes)) {
            foreach ($automobile_var_get_makes[0] as $value) {

                $make .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">';
                $make .= '<div class="cs-catagory">';
                $make .= '<ul>';
                $page_url = add_query_arg(array(
                    'inventory_make' => $value,
                    'inventory_type' => $inventories->post_name,
                        ), get_permalink($automobile_search_result_page));



                $automobile_make = get_term_by('slug', $value, 'inventory-make');
                $count = get_count($value, $inventories->post_name);
                $count_available += $count;
                if (is_object($automobile_make)) {
                    $make .= '<li><a href="' . $page_url . '"><span>' . $automobile_make->name . '</span><small>(' . $count . ')</small></a></li>';
                }

                $make .= '</ul>';
                $make .= '</div>';
                $make .= '</div>';
            }
			
        } else {
            $make .= automobile_var_plugin_text_srt('automobile_var_nothing');
        }

        $html .= '<div class="catagory-section '.$automobile_var_inventories_style.'">';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

        $html .= '<div class="cs-element-title">';
        if ($automobile_inventory_type_title <> ''):
            $html .= '<h2>' . esc_html($automobile_inventory_type_title) . '</h2>';
        endif;

        $html .= '<span>' . automobile_var_plugin_text_srt('automobile_var_available_start_string') . ' ' . esc_html($count_available) . ' ' . strtolower($inventories->post_title) . ' ' . automobile_var_plugin_text_srt('automobile_var_available_ending_string') . '</span>';

        $html .= ' </div>';
        $html .= '</div>';

        $html .= $make;
        if ($automobile_inventory_type_button_title <> ''):
            $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            $html .= '<div class="button_style cs-button"> <a href="' . esc_url($automobile_inventory_type_button_url) . '">' . esc_html($automobile_inventory_type_button_title) . '</a> </div>';
            $html .= '</div>';
        endif;
        $html .= '</div>';



        return do_shortcode($html);
    }

    add_shortcode('automobile_inventory_type', 'automobile_var_inventory_type_shortcode');
}