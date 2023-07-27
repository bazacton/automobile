<?php
/**
 * 
 * @return html
 *
 */
/*
 *
 * Start Function how to create inventory elements and inventory short codes
 *
 */

if (!function_exists('automobile_var_page_builder_dealer')) {

    function automobile_var_page_builder_dealer($die = 0) {
        global $automobile_node, $automobile_html_fields, $post, $automobile_form_fields, $automobile_var_plugin_options, $automobile_var_plugin_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_automobile_inventory_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'automobile_dealer';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $automobile_loc_latitude = isset($automobile_var_plugin_options['automobile_post_loc_latitude']) ? $automobile_var_plugin_options['automobile_post_loc_latitude'] : '';
        $automobile_loc_longitude = isset($automobile_var_plugin_options['automobile_post_loc_longitude']) ? $automobile_var_plugin_options['automobile_post_loc_longitude'] : '';
        $automobile_map_zoom_level = isset($automobile_var_plugin_options['automobile_map_zoom_level']) ? $automobile_var_plugin_options['automobile_map_zoom_level'] : '';

        $defaults = array(
            'column_size' => '1/1',
            'automobile_dealer_title' => '',
            'automobile_dealer_sub_title' => '',
            'automobile_dealer_searchbox' => 'yes', // yes or no
            'automobile_dealer_searchbox_top' => 'yes', // yes or no
            'automobile_dealer_searchbox_title_top' => '',
            'automobile_dealer_show_pagination' => 'pagination',
            'automobile_dealer_pagination' => '5', // yes or no
            'automobile_dealer_map' => 'no', // as per your requirement only numbers(0-9)
            'automobile_var_dealer_map_lat' => $automobile_loc_latitude,
            'automobile_var_dealer_map_long' => $automobile_loc_longitude,
            'automobile_var_dealer_map_zoom' => $automobile_map_zoom_level,
            'automobile_var_dealer_map_height' => '355',
        );
        if (isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else
            $atts = array();
        $dealer_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key]))
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'automobile_var_page_builder_dealer';
        $coloumn_class = 'column_' . $dealer_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }


        //Variable Validation
        $automobile_dealer_title = isset($automobile_dealer_title) ? $automobile_dealer_title : '';
        $automobile_dealer_sub_title = isset($automobile_dealer_sub_title) ? $automobile_dealer_sub_title : '';
        $automobile_dealer_searchbox_title_top = isset($automobile_dealer_searchbox_title_top) ? $automobile_dealer_searchbox_title_top : '';
        $automobile_dealer_searchbox = isset($automobile_dealer_searchbox) ? $automobile_dealer_searchbox : '';
        $automobile_dealer_searchbox_top = isset($automobile_dealer_searchbox_top) ? $automobile_dealer_searchbox_top : '';
        $automobile_dealer_show_pagination = isset($automobile_dealer_show_pagination) ? $automobile_dealer_show_pagination : '';
        $automobile_dealer_pagination = isset($automobile_dealer_pagination) ? $automobile_dealer_pagination : '';
        $automobile_dealer_map = isset($automobile_dealer_map) ? $automobile_dealer_map : '';
        $automobile_var_dealer_map_lat = isset($automobile_var_dealer_map_lat) ? $automobile_var_dealer_map_lat : '';
        $automobile_var_dealer_map_long = isset($automobile_var_dealer_map_long) ? $automobile_var_dealer_map_long : '';
        $automobile_var_dealer_map_zoom = isset($automobile_var_dealer_map_zoom) ? $automobile_var_dealer_map_zoom : '';
        $automobile_var_dealer_map_height = isset($automobile_var_dealer_map_height) ? $automobile_var_dealer_map_height : '';
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php
        if (isset($shortcode_view)) {
            echo esc_attr($shortcode_view);
        }
        ?>" item="dealer" data="<?php echo automobile_element_size_data_array_index($dealer_element_size) ?>">
                 <?php automobile_element_setting($name, $automobile_counter, $dealer_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter); ?>" data-shortcode-template="[automobile_dealer {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_plugin_text_srt('automobile_var_edit_dealer'); ?></h5>
                    <a href="javascript:automobile_var_removeoverlay('<?php echo esc_attr($name . $automobile_counter) ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose">
                        <i class="icon-times"></i></a>
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            automobile_shortcode_element_size();
                        }
                        ?>

                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_section_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_section_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_dealer_title,
                                'id' => 'automobile_dealer_title',
                                'cust_name' => 'automobile_dealer_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_search_box'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_search_box_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_dealer_searchbox,
                                'id' => 'automobile_dealer_searchbox',
                                'cust_name' => 'automobile_dealer_searchbox[]',
                                'classes' => 'dropdown chosen-select',
                                'extra_atr' => ' onchange="automobile_dealer_search_switch(this.value)"',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_select_field($automobile_opt_array);

                         $search_box_display = $automobile_dealer_searchbox == 'yes' ? 'block' : 'none';

                        echo '<div id="automobile_search_view_area" style=" display:' . $search_box_display . ';">';


                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_search_box_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_search_box_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_dealer_searchbox_title_top,
                                'id' => 'automobile_dealer_searchbox_title_top',
                                'cust_name' => 'automobile_dealer_searchbox_title_top[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        echo '</div>';

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_top_search_box'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_top_search_box_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_dealer_searchbox_top,
                                'id' => 'automobile_dealer_searchbox_top',
                                'cust_name' => 'automobile_dealer_searchbox_top[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );


                        $automobile_html_fields->automobile_select_field($automobile_opt_array);


                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_pagination'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_pagination_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_dealer_show_pagination,
                                'id' => 'automobile_dealer_show_pagination',
                                'cust_name' => 'automobile_dealer_show_pagination[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'pagination' => automobile_var_plugin_text_srt('automobile_var_pagination'),
                                    'single_page' => automobile_var_plugin_text_srt('automobile_var_single_page')
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_post_per_post'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_post_per_post_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_dealer_pagination,
                                'id' => 'automobile_dealer_pagination',
                                'cust_name' => 'automobile_dealer_pagination[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);



                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_map'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_map_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_dealer_map,
                                'id' => 'candidate_map',
                                'cust_name' => 'automobile_dealer_map[]',
                                'classes' => 'dropdown chosen-select',
                                'extra_atr' => ' onchange="automobile_dealer_map_switch(this.value)"',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        $automobile_map_display = $automobile_dealer_map == 'yes' ? 'block' : 'none';

                        echo '<div id="automobile_dealer_map_area" style="display:' . $automobile_map_display . ';">';

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_latitude'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_latitude_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_dealer_map_lat,
                                'id' => 'map_lat',
                                'cust_name' => 'automobile_var_dealer_map_lat[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_longitude'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_longitude_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_dealer_map_long,
                                'id' => 'map_long',
                                'cust_name' => 'automobile_var_dealer_map_long[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_zoom_level'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_zoom_level_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_dealer_map_zoom,
                                'id' => 'map_zoom',
                                'cust_name' => 'automobile_var_dealer_map_zoom[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_map_height'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_map_height_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_dealer_map_height,
                                'id' => 'map_height',
                                'cust_name' => 'automobile_var_dealer_map_height[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        echo '</div>';



                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_pb_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_plugin_text_srt('automobile_var_insert'); ?></a> </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>
                            <ul class="form-elements">
                                <li class="to-label"></li>
                                <li class="to-field">
                                    <?php
                                    $automobile_opt_array = array(
                                        'id' => '',
                                        'std' => 'dealer',
                                        'cust_id' => "",
                                        'cust_name' => "automobile_orderby[]",
                                    );

                                    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                    $automobile_opt_array = array(
                                        'id' => '',
                                        'std' => automobile_var_plugin_text_srt('automobile_var_save'),
                                        'cust_id' => "",
                                        'cust_name' => "",
                                        'cust_type' => 'button',
                                        'extra_atr' => 'style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))"',
                                    );

                                    $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                    ?>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
        </script> 
        <?php
        if ($die <> 1)
            die();
    }

    add_action('wp_ajax_automobile_var_page_builder_dealer', 'automobile_var_page_builder_dealer');
}