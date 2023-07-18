<?php
/**
 * @Google map html form for page builder start
 */
if (!function_exists('automobile_var_page_builder_map')) {

    function automobile_var_page_builder_map($die = 0) {
        global $automobile_node, $post, $automobile_var_html_fields, $automobile_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'automobile_map';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'automobile_var_map_title' => '',
            'automobile_var_map_height' => '',
            'automobile_var_map_lat' => '40.7143528',
            'automobile_var_map_lon' => '-74.0059731',
            'automobile_var_map_zoom' => '',
            'automobile_var_map_info' => '',
            'automobile_var_map_info_width' => '',
            'automobile_var_map_info_height' => '',
            'automobile_var_map_marker_icon' => '',
            'automobile_var_map_show_marker' => 'true',
            'automobile_var_map_controls' => '',
            'automobile_var_map_draggable' => '',
            'automobile_var_map_scrollwheel' => '',
            'automobile_var_map_border' => '',
            'automobile_var_map_border_color' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content'])) {
            $atts_content = $output['0']['content'];
        } else {
            $atts_content = array();
        }
        $map_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $automobile_var_map_title = isset($automobile_var_map_title) ? $automobile_var_map_title : '';
        $automobile_var_map_height = isset($automobile_var_map_height) ? $automobile_var_map_height : '';
        $automobile_var_map_lat = isset($automobile_var_map_lat) ? $automobile_var_map_lat : '';
        $automobile_var_map_lon = isset($automobile_var_map_lon) ? $automobile_var_map_lon : '';
        $automobile_var_map_zoom = isset($automobile_var_map_zoom) ? $automobile_var_map_zoom : '';
        $automobile_var_map_info = isset($automobile_var_map_info) ? $automobile_var_map_info : '';
        $automobile_var_map_marker_icon = isset($automobile_var_map_marker_icon) ? $automobile_var_map_marker_icon : '';
        $automobile_var_map_show_marker = isset($automobile_var_map_show_marker) ? $automobile_var_map_show_marker : '';
        $automobile_var_map_controls = isset($automobile_var_map_controls) ? $automobile_var_map_controls : '';
        $automobile_var_map_draggable = isset($automobile_var_map_draggable) ? $automobile_var_map_draggable : '';
        $automobile_var_map_scrollwheel = isset($automobile_var_map_scrollwheel) ? $automobile_var_map_scrollwheel : '';
        $automobile_var_map_border = isset($automobile_var_map_border) ? $automobile_var_map_border : '';
        $automobile_var_map_border_color = isset($automobile_var_map_border_color) ? $automobile_var_map_border_color : '';
        $name = 'automobile_var_page_builder_map';
        $coloumn_class = 'column_' . $map_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $rand_string = $automobile_counter . '' . automobile_generate_random_string(3);

        global $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="map" data="<?php echo automobile_element_size_data_array_index($map_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $map_element_size, '', 'globe'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[<?php echo esc_attr('automobile_map'); ?> {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_edit_map_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            automobile_shortcode_element_size();
                        }

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_element_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_element_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_allow_special_char($automobile_var_map_title),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'automobile_var_map_title[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_map_height'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_map_height_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_height),
                                'cust_id' => '',
                                'classes' => 'txtfield ',
                                'cust_name' => 'automobile_var_map_height[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_latitude'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_latitude_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_lat),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_var_map_lat[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_longitude'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_longitude_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_lon),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_var_map_lon[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_zoom'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_zoom_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_zoom),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_var_map_zoom[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_info_text'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_info_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_info),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_var_map_info[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_info_text_width'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_info_text_width_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_info_width),
                                'cust_id' => '',
                                'classes' => 'txtfield input-small',
                                'cust_name' => 'automobile_var_map_info_width[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_info_text_height'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_info_text_height_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_info_height),
                                'cust_id' => '',
                                'classes' => 'txtfield input-small',
                                'cust_name' => 'automobile_var_map_info_height[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'std' => esc_url($automobile_var_map_marker_icon),
                            'id' => 'map_marker_icon',
                            'name' => automobile_var_theme_text_srt('automobile_var_marker_icon_path'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_marker_icon_path_hint'),
                            'echo' => true,
                            'array' => true,
                            'prefix' => '',
                            'field_params' => array(
                                'std' => esc_url($automobile_var_map_marker_icon),
                                'cust_id' => '',
                                'id' => 'map_marker_icon',
                                'return' => true,
                                'array' => true,
                                'array_txt' => false,
                                'prefix' => '',
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_show_marker'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_show_marker_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_map_show_marker),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'automobile_var_map_show_marker[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'true' => automobile_var_theme_text_srt('automobile_var_on'),
                                    'false' => automobile_var_theme_text_srt('automobile_var_off'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_disable_map_controls'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_disable_map_controls_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_map_controls),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'automobile_var_map_controls[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'true' => automobile_var_theme_text_srt('automobile_var_on'),
                                    'false' => automobile_var_theme_text_srt('automobile_var_off'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_drage_able'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_drage_able_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_map_draggable),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'automobile_var_map_draggable[]',
                                'classes' => 'dropdown  chosen-select',
                                'options' => array(
                                    'true' => automobile_var_theme_text_srt('automobile_var_on'),
                                    'false' => automobile_var_theme_text_srt('automobile_var_off'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_scroll_wheel'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_scroll_wheel_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_map_scrollwheel),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'automobile_var_map_scrollwheel[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'true' => automobile_var_theme_text_srt('automobile_var_on'),
                                    'false' => automobile_var_theme_text_srt('automobile_var_off'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_map_border'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_map_border_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_map_border),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'automobile_var_map_border[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'yes' => automobile_var_theme_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_theme_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_border_color'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_border_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_map_border_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'automobile_var_map_border_color[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        ?>
                    </div>
                    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                        ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_page_builder_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                    <?php } else { ?>
                        <?php
                        $automobile_opt_array = array(
                            'std' => 'map',
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'classes' => '',
                            'extra_atr' => '',
                            'cust_id' => '',
                            'cust_name' => 'automobile_orderby[]',
                            'return' => false,
                            'required' => false
                        );
                        $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => '',
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_var_theme_text_srt('automobile_var_save'),
                                'cust_id' => '',
                                'cust_type' => 'button',
                                'classes' => 'cs-barber-admin-btn',
                                'cust_name' => '',
                                'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        ?>   
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_map', 'automobile_var_page_builder_map');
}
