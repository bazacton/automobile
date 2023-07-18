<?php
/**
 * File Type: Inventory hunt option fields file
 */
if (!class_exists('automobile_options_fields')) {

    class automobile_options_fields {

        public function __construct() {
            
        }

        /**
         * Start Function  how to create Fields Settings
         */
        public function automobile_fields($automobile_setting_options) {
            global $automobile_var_plugin_options, $automobile_form_fields, $automobile_html_fields, $help_text, $col_heading, $automobile_var_plugin_static_text;
			$strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_option_strings();
            $automobile_var_plugin_options = get_option('automobile_var_plugin_options');
            $counter = 0;
            $automobile_counter = 0;
            $menu = '';
            $output = '';
            $parent_heading = '';
            $style = '';
            $automobile_countries_list = '';
            foreach ($automobile_setting_options as $value) {
                $counter++;
                $val = '';

                $select_value = '';
                if (isset($value['help_text']) && $value['help_text'] <> '') {
                    $help_text = $value['help_text'];
                } else {
                    $help_text = '';
                }
                if (isset($value['col_heading']) && $value['col_heading'] <> '') {
                    $col_heading = $value['col_heading'];
                } else {
                    $col_heading = '';
                }
                $automobile_classes = '';
                if (isset($value['classes']) && $value['classes'] != "") {
                    $automobile_classes = $value['classes'];
                }
                switch ($value['type']) {
                    case "heading":
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'fontawesome' => $value['fontawesome'],
                            'options' => $value['options'],
                        );

                        $menu .= $automobile_html_fields->automobile_set_heading($automobile_opt_array);
                        break;

                    case "main-heading":
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'fontawesome' => $value['fontawesome'],
                            'id' => $value['id'],
                        );
                        $menu .= $automobile_html_fields->automobile_set_main_heading($automobile_opt_array);
                        break;

                    case "sub-heading":
                        $automobile_counter++;
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'counter' => $automobile_counter,
                            'id' => $value['id'],
                        );
                        $output .= $automobile_html_fields->automobile_set_sub_heading($automobile_opt_array);
                        break;
                    case "col-right-text":
                        $automobile_opt_array = array(
                            'col_heading' => $col_heading,
                            'help_text' => $help_text,
                        );
                        $output .= $automobile_html_fields->automobile_set_col_right($automobile_opt_array);
                        break;
                    case "announcement":
                        $automobile_counter++;
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'std' => $value['std'],
                            'id' => $value['id'],
                        );
                        $output .= $automobile_html_fields->automobile_set_announcement($automobile_opt_array);
                        break;
                    case "division":
                        $extra_atts = isset($value['extra_atts']) ? $value['extra_atts'] : '';
                        $d_enable = ' style="display:none;"';
                        if (isset($value['enable_val'])) {
                            $enable_id = isset($value['enable_id']) ? $value['enable_id'] : '';
                            $enable_val = isset($value['enable_val']) ? $value['enable_val'] : '';
                            $d_val = '';
                            if (isset($automobile_var_plugin_options)) {
                                if (isset($automobile_var_plugin_options[$enable_id])) {
                                    $d_val = $automobile_var_plugin_options[$enable_id];
                                }
                            }
                            $d_enable = $d_val == $enable_val ? ' style="display:block;"' : ' style="display:none;"';
                        }
                        $output .= '<div' . $d_enable . ' ' . $extra_atts . '>';
                        break;
                    case "division_close":
                        $output .= '</div>';
                        break;
                    case "section":

                        $automobile_opt_array = array(
                            'id' => $value['id'],
                            'std' => $value['std'],
                        );

                        if (isset($value['accordion']) && $value['accordion'] <> '') {
                            $automobile_opt_array['accordion'] = $value['accordion'];
                        }

                        if (isset($value['active']) && $value['active'] <> '') {
                            $automobile_opt_array['active'] = $value['active'];
                        }

                        if (isset($value['parrent_id']) && $value['parrent_id'] <> '') {
                            $automobile_opt_array['parrent_id'] = $value['parrent_id'];
                        }

                        $output .= $automobile_html_fields->automobile_set_section($automobile_opt_array);
                        break;
                    case 'text' :
                        if (isset($automobile_var_plugin_options)) {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']])) {
                                $val = $automobile_var_plugin_options['automobile_' . $value['id']];
                            } else {
                                $val = $value['std'];
                            }
                        } else {
                            $val = $value['std'];
                        }

                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $val,
                                'id' => $value['id'],
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        break;
                    case 'text3' :
                        if (isset($automobile_var_plugin_options)) {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']])) {
                                $val = $automobile_var_plugin_options['automobile_' . $value['id']];
                                $val2 = $automobile_var_plugin_options['automobile_' . $value['id2']];
                                $val3 = $automobile_var_plugin_options['automobile_' . $value['id3']];
                            } else {
                                $val = $value['std'];
                                $val2 = $value['std2'];
                                $val3 = $value['std3'];
                            }
                        } else {
                            $val = $value['std'];
                            $val2 = $value['std2'];
                            $val3 = $value['std3'];
                        }

                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => 'radius_fields',
                            'desc' => '',
                            'hint_text' => $value['hint_text'],
                            'fields_list' => array(
                                array(
                                    'type' => 'text', 'field_params' => array(
                                        'std' => $val,
                                        'id' => $value['id'],
                                        'extra_atr' => ' placeholder="' . $value['placeholder'] . '"',
                                        'return' => true,
                                        'classes' => 'input-small',
                                    ),
                                ),
                                array(
                                    'type' => 'text', 'field_params' => array(
                                        'std' => $val2,
                                        'id' => $value['id2'],
                                        'extra_atr' => ' placeholder="' . $value['placeholder2'] . '"',
                                        'return' => true,
                                        'classes' => 'input-small',
                                    ),
                                ),
                                array(
                                    'type' => 'text', 'field_params' => array(
                                        'std' => $val3,
                                        'id' => $value['id3'],
                                        'extra_atr' => ' placeholder="' . $value['placeholder3'] . '"',
                                        'return' => true,
                                        'classes' => 'input-small',
                                    ),
                                )
                            ),
                        );

                        $output .= $automobile_html_fields->automobile_multi_fields($automobile_opt_array);

                        break;
                    case 'range' :
                        if (isset($automobile_var_plugin_options)) {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']])) {
                                $val = $automobile_var_plugin_options['automobile_' . $value['id']];
                            } else {
                                $val = $value['std'];
                            }
                        } else {
                            $val = $value['std'];
                        }

                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $val,
                                'id' => $value['id'],
                                'range' => true,
                                'min' => $value['min'],
                                'max' => $value['max'],
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        break;
                    case 'textarea':
                        $val = $value['std'];
                        $std = get_option($value['id']);
                        if (isset($automobile_var_plugin_options)) {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']])) {
                                $val = $automobile_var_plugin_options['automobile_' . $value['id']];
                            } else {
                                $val = $value['std'];
                            }
                        } else {
                            $val = $value['std'];
                        }
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $val,
                                'id' => $value['id'],
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_textarea_field($automobile_opt_array);
                        break;
                    case "radio":
                        if (isset($automobile_var_plugin_options)) {
                            $select_value = $automobile_var_plugin_options['automobile_' . $value['id']];
                        } else {
                            
                        }
                        foreach ($value['options'] as $key => $option) {
                            $checked = '';
                            if ($select_value != '') {
                                if ($select_value == $option) {
                                    $checked = ' checked';
                                }
                            } else {
                                if ($value['std'] == $option) {
                                    $checked = ' checked';
                                }
                            }
                            $output .= $automobile_html_fields->automobile_radio_field(
                                    array(
                                        'name' => $key,
                                        'id' => $value['id'],
                                        'classes' => '',
                                        'std' => $option,
                                        'description' => '',
                                        'hint' => '',
                                        'prefix_on' => false,
                                        'extra_atr' => $checked,
                                        'field_params' => array(
                                            'std' => $option,
                                            'id' => $value['id'],
                                            'return' => true,
                                        ),
                                    )
                            );
                        }
                        break;
                    case 'select':
                        if (isset($automobile_var_plugin_options) and $automobile_var_plugin_options <> '') {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']]) and $automobile_var_plugin_options['automobile_' . $value['id']] <> '') {
                                $select_value = $automobile_var_plugin_options['automobile_' . $value['id']];
                            } else {
                                $select_value = $value['std'];
                            }
                        } else {
                            $select_value = $value['std'];
                        }

                        if ($select_value == 'absolute') {
                            if ($automobile_var_plugin_options['automobile_headerbg_options'] == 'automobile_rev_slider') {
                                $output .= '<style>
                                                    #automobile_headerbg_image_upload,#automobile_headerbg_color_color,#automobile_headerbg_image_box{ display:none;}
                                                    #tab-header-options ul#automobile_headerbg_slider_1,#tab-header-options ul#automobile_headerbg_options_header{ display:block;}
                                            </style>';
                            } else if ($automobile_var_plugin_options['automobile_headerbg_options'] == 'automobile_bg_image_color') {
                                $output .= '<style>
                                                    #automobile_headerbg_image_upload,#automobile_headerbg_color_color,#automobile_headerbg_image_box{ display:block;}
                                                    #tab-header-options ul#automobile_headerbg_slider_1{ display:none; }
                                            </style>';
                            } else {
                                $output .= '<style>
                                                    #automobile_headerbg_options_header{display:block;}
                                                    #automobile_headerbg_image_upload,#automobile_headerbg_color_color,#automobile_headerbg_image_box{ display:none;}
                                                    #tab-header-options ul#automobile_headerbg_slider_1{ display:none; }
                                            </style>';
                            }
                        } elseif ($select_value == 'relative') {
                            $output .='<style>
                                                    #tab-header-options ul#automobile_headerbg_slider_1,#tab-header-options ul#automobile_headerbg_options_header,#tab-header-options ul#automobile_headerbg_image_upload,#tab-header-options ul#automobile_headerbg_color_color,#tab-header-options #automobile_headerbg_image_box{ display:none;}
                                      </style>';
                        }
                        $output .= ($value['id'] == 'automobile_bgimage_position') ? '<div class="main_tab">' : '';
                        $select_header_bg = ($value['id'] == 'automobile_header_position') ? 'onchange=javascript:automobile_set_headerbg(this.value)' : '';

                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $select_value,
                                'id' => $value['id'],
                                'options' => $value['options'],
                                'classes' => $automobile_classes,
                                'return' => true,
                            ),
                        );

                        if (isset($value['change']) && $value['change'] == 'yes') {
                            $automobile_opt_array['field_params']['onclick'] = $value['id'] . '_change(this.value)';
                        }

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        $output .=($value['id'] == 'automobile_bgimage_position') ? '</div>' : '';
                        break;
                    case 'select_values' :
                        if (isset($automobile_var_plugin_options) and $automobile_var_plugin_options <> '') {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']]) and $automobile_var_plugin_options['automobile_' . $value['id']] <> '') {
                                $select_value = $automobile_var_plugin_options['automobile_' . $value['id']];
                            } else {
                                $select_value = $value['std'];
                            }
                        } else {
                            $select_value = $value['std'];
                        }
                        $output .= ($value['id'] == 'automobile_bgimage_position') ? '<div class="main_tab">' : '';
                        $select_header_bg = ($value['id'] == 'automobile_header_position') ? 'onchange=javascript:automobile_set_headerbg(this.value)' : '';
                        $automobile_search_display = '';
                        if ($value['id'] == 'automobile_search_by_location') {
                            $automobile_inventory_loc_sugg = isset($automobile_var_plugin_options['automobile_inventory_loc_sugg']) ? $automobile_var_plugin_options['automobile_inventory_loc_sugg'] : '';
                            $automobile_search_display = $automobile_inventory_loc_sugg == 'Website' ? 'block' : 'none';
                        }
                        if ($value['id'] == 'automobile_search_by_location_city') {
                            $automobile_search_by_location = isset($automobile_var_plugin_options['automobile_search_by_location']) ? $automobile_var_plugin_options['automobile_search_by_location'] : '';
                            $automobile_search_display = $automobile_search_by_location == 'single_city' ? 'block' : 'none';
                        }
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $select_value,
                                'id' => $value['id'],
                                'options' => $value['options'],
                                'classes' => $automobile_classes,
                                'return' => true,
                            ),
                        );

                        if (isset($value['change']) && $value['change'] == 'yes') {
                            $automobile_opt_array['field_params']['onclick'] = $value['id'] . '_change(this.value)';
                        }

                        if (isset($value['extra_atts']) && $value['extra_atts'] != '') {
                            $automobile_opt_array['field_params']['extra_atr'] = $value['extra_atts'];
                        }

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        break;
                    case 'ad_select':
                        if (isset($automobile_var_plugin_options) and $automobile_var_plugin_options <> '') {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']]) and $automobile_var_plugin_options['automobile_' . $value['id']] <> '') {
                                $select_value = $automobile_var_plugin_options['automobile_' . $value['id']];
                            } else {
                                $select_value = $value['std'];
                            }
                        } else {
                            $select_value = $value['std'];
                        }
                        if ($select_value == 'absolute') {
                            if ($automobile_var_plugin_options['automobile_headerbg_options'] == 'automobile_rev_slider') {
                                $output .='<style>
                                                    #automobile_headerbg_image_upload,#automobile_headerbg_color_color,#automobile_headerbg_image_box{ display:none;}
                                                    #tab-header-options ul#automobile_headerbg_slider_1,#tab-header-options ul#automobile_headerbg_options_header{ display:block;}
                                            </style>';
                            } else if ($automobile_var_plugin_options['automobile_headerbg_options'] == 'automobile_bg_image_color') {
                                $output .='<style>
                                                    #automobile_headerbg_image_upload,#automobile_headerbg_color_color,#automobile_headerbg_image_box{ display:block;}
                                                    #tab-header-options ul#automobile_headerbg_slider_1{ display:none; }
                                            </style>';
                            } else {
                                $output .='<style>
                                                    #automobile_headerbg_options_header{display:block;}
                                                    #automobile_headerbg_image_upload,#automobile_headerbg_color_color,#automobile_headerbg_image_box{ display:none;}
                                                    #tab-header-options ul#automobile_headerbg_slider_1{ display:none; }
                                            </style>';
                            }
                        } elseif ($select_value == 'relative') {
                            $output .='<style>
                                            #tab-header-options ul#automobile_headerbg_slider_1,#tab-header-options ul#automobile_headerbg_options_header,#tab-header-options ul#automobile_headerbg_image_upload,#tab-header-options ul#automobile_headerbg_color_color,#tab-header-options #automobile_headerbg_image_box{ display:none;}
                                     </style>';
                        }
                        $output .= ($value['id'] == 'automobile_bgimage_position') ? '<div class="main_tab">' : '';
                        $select_header_bg = ($value['id'] == 'automobile_header_position') ? 'onchange=javascript:automobile_set_headerbg(this.value)' : '';
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $select_value,
                                'id' => $value['id'],
                                'options' => $value['options'],
                                'return' => true,
                            ),
                        );

                        if (isset($value['change']) && $value['change'] == 'yes') {
                            $automobile_opt_array['field_params']['onclick'] = $value['id'] . '_change(this.value)';
                        }

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        break;

                    case "checkbox":
                        $std = '';
                        if (isset($automobile_var_plugin_options)) {
                            if (isset($automobile_var_plugin_options['automobile_' . $value['id']])) {
                                $std = $automobile_var_plugin_options['automobile_' . $value['id']];
                            }
                        } else {
                            $std = $value['std'];
                        }

                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $std,
                                'id' => $value['id'],
                                'extra_atr' => isset($value['onchange']) ? 'onchange=' . $value['onchange'] : '',
                                'return' => true,
                            ),
                        );

                        if (isset($value['onchange']) && $value['onchange'] <> '') {
                            $automobile_opt_array['field_params']['extra_atr'] = ' onchange=' . $value['onchange'];
                        }

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_checkbox_field($automobile_opt_array);

                        break;
                    case "color":
                        $val = $value['std'];
                        if (isset($automobile_var_plugin_options)) {
                            if (isset($automobile_var_plugin_options[$value['id']])) {
                                $val = $automobile_var_plugin_options[$value['id']];
                            }
                        } else {
                            $std = $value['std'];
                            if ($std != '') {
                                $val = $std;
                            }
                        }
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $val,
                                'classes' => 'bg_color',
                                'id' => $value['id'],
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        break;
                    case "packages":
                        $obj = new automobile_var_plugin_options();
                        $output .= $obj->automobile_packages_section();
                        break;
                    case "gateways":
                        global $gateways;
                        $general_settings = new AUTOMOBILE_PAYMENTS();
                        $automobile_counter = '';
                        foreach ($gateways as $key => $value) {
                            $output .='<div class="theme-help">';
                            $output .='<h4>' . $value . '</h4>';
                            $output .='<div class="clear"></div>';
                            $output .='</div>';
                            if (class_exists($key)) {
                                $settings = new $key();
                                $automobile_settings = $settings->settings();
                                $html = '';
                                foreach ($automobile_settings as $key => $params) {
                                    ob_start();
                                    automobile_settings_fields($key, $params);
                                    $post_data = ob_get_clean();
                                    $output .= $post_data;
                                }
                            }
                        }
                        break;

                    case "upload":
                        $automobile_counter++;
                        if (isset($automobile_var_plugin_options) and $automobile_var_plugin_options <> '' && isset($automobile_var_plugin_options['automobile_' . $value['id']])) {
                            $val = $automobile_var_plugin_options['automobile_' . $value['id']];
                        } else {
                            $val = $value['std'];
                        }
                        $display = ($val <> '' ? 'display' : 'none');
                        if (isset($value['tab'])) {
                            $output .= '<div class="main_tab"><div class="horizontal_tab" style="display:' . $value['display'] . '" id="' . $value['tab'] . '">';
                        }
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'std' => $val,
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $val,
                                'id' => $value['id'],
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_upload_file_field($automobile_opt_array);

                        if (isset($value['tab'])) {
                            $output.='</div></div>';
                        }
                        break;
                    case "upload logo":
                        $automobile_counter++;

                        if (isset($automobile_var_plugin_options) and $automobile_var_plugin_options <> '' && isset($automobile_var_plugin_options['automobile_' . $value['id']])) {
                            $val = $automobile_var_plugin_options['automobile_' . $value['id']];
                        } else {
                            $val = $value['std'];
                        }

                        $display = ($val <> '' ? 'display' : 'none');
                        if (isset($value['tab'])) {
                            $output .='<div class="main_tab"><div class="horizontal_tab" style="display:' . $value['display'] . '" id="' . $value['tab'] . '">';
                        }
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'std' => $val,
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'field_params' => array(
                                'std' => $val,
                                'id' => $value['id'],
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_upload_file_field($automobile_opt_array);

                        if (isset($value['tab'])) {
                            $output.='</div></div>';
                        }
                        break;
                    case "custom_fields":
                        $automobile_counter++;
                        global $automobile_inventory_cus_fields;

                        break;


                    case "dealer_custom_fields":
                        $automobile_counter++;
                        global $automobile_dealer_cus_fields;

                        $automobile_dealer_cus_fields = get_option("automobile_dealer_cus_fields");
                        $automobile_fields_obj = new automobile_dealer_custom_fields_options();
                        $output .= '
                                    <div class="inside-tab-content">
                                        <div class="dragitem">
                                            <div class="pb-form-buttons">
                                            <span class="automobile_cus_fields_text">' . automobile_var_plugin_text_srt('automobile_var_click_to_add') . '</span>
                                                <ul>
                                                    <li><a ' . automobile_tooltip_helptext_string(automobile_var_plugin_text_srt('automobile_var_text'), true) . '  href="javascript:automobile_add_dealer_custom_field(\'automobile_pb_dealer_text\')" data-type="text" data-name="custom_text"><i class="icon-file-text-o"></i></a></li>
                                                    <li><a ' . automobile_tooltip_helptext_string(automobile_var_plugin_text_srt('automobile_var_textarea'), true) . '  href="javascript:automobile_add_dealer_custom_field(\'automobile_pb_dealer_textarea\')" data-type="textarea" data-name="custom_textarea"><i class="icon-text"></i></a></li>
                                                    <li><a ' . automobile_tooltip_helptext_string(automobile_var_plugin_text_srt('automobile_var_dropdown') , true) . '  href="javascript:automobile_add_dealer_custom_field(\'automobile_pb_dealer_dropdown\')" data-type="select" data-name="custom_select"><i class="icon-download"></i></a></li>
                                                    <li><a ' . automobile_tooltip_helptext_string(automobile_var_plugin_text_srt('automobile_var_date') , true) . '  href="javascript:automobile_add_dealer_custom_field(\'automobile_pb_dealer_date\')" data-type="date" data-name="custom_date"><i class="icon-calendar-o"></i></a></li>
                                                    <li><a ' . automobile_tooltip_helptext_string(automobile_var_plugin_text_srt('automobile_var_custom_email'), true) . '  href="javascript:automobile_add_dealer_custom_field(\'automobile_pb_dealer_email\')" data-type="email" data-name="custom_email"><i class="icon-envelope"></i></a></li>
                                                    <li><a ' . automobile_tooltip_helptext_string(automobile_var_plugin_text_srt('automobile_var_url') , true) . '  href="javascript:automobile_add_dealer_custom_field(\'automobile_pb_dealer_url\')" data-type="url" data-name="custom_url"><i class="icon-link4"></i></a></li>
                                                    <li><a ' . automobile_tooltip_helptext_string(automobile_var_plugin_text_srt('automobile_var_range'), true) . '  href="javascript:automobile_add_dealer_custom_field(\'automobile_pb_dealer_range\')" data-type="url" data-name="custom_range"><i class=" icon-target3"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                            <div id="automobile_dealer_field_elements" class="cs-custom-fields">';
                        $automobile_count_node = time();
                        if (is_array($automobile_dealer_cus_fields) && sizeof($automobile_dealer_cus_fields) > 0) {
                            foreach ($automobile_dealer_cus_fields as $f_key => $automobile_field) {
                                global $automobile_f_counter;
                                $automobile_f_counter = $f_key;
                                if (isset($automobile_field['type']) && $automobile_field['type'] == "text") {
                                    $automobile_count_node++;
                                    $output .= $automobile_fields_obj->automobile_pb_dealer_text(1, true);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "textarea") {
                                    $automobile_count_node++;
                                    $output .= $automobile_fields_obj->automobile_pb_dealer_textarea(1, true);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "dropdown") {
                                    $automobile_count_node++;
                                    $output .= $automobile_fields_obj->automobile_pb_dealer_dropdown(1, true);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "date") {
                                    $automobile_count_node++;
                                    $output .= $automobile_fields_obj->automobile_pb_dealer_date(1, true);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "email") {
                                    $automobile_count_node++;
                                    $output .= $automobile_fields_obj->automobile_pb_dealer_email(1, true);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "url") {
                                    $automobile_count_node++;
                                    $output .= $automobile_fields_obj->automobile_pb_dealer_url(1, true);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "range") {
                                    $automobile_count_node++;
                                    $output .= $automobile_fields_obj->automobile_pb_dealer_range(1, true);
                                }
                            }
                        }
                        $output .= '</div>
                                        <script type="text/javascript">
                                            jQuery(function() {
                                                automobile_custom_fields_script(\'automobile_dealer_field_elements\');
                                            });
                                            jQuery(document).ready(function($) {
                                                automobile_check_dealer_fields_avail();
                                            });
                                            var counter = ' . esc_js($automobile_count_node) . ';
                                            function automobile_add_dealer_custom_field(action){
                                                counter++;
                                                var fields_data = "action=" + action + \'&counter=\' + counter;
                                                jQuery.ajax({
                                                    type:"POST",
                                                    url: "' . esc_js(admin_url('admin-ajax.php')) . '",
                                                    data: fields_data,
                                                    success:function(data){
                                                        jQuery("#automobile_dealer_field_elements").append(data);
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>';
                        break;

                    case 'select_dashboard':
                        if (isset($automobile_var_plugin_options) and $automobile_var_plugin_options <> '') {
                            if (isset($automobile_var_plugin_options[$value['id']])) {
                                $select_value = $automobile_var_plugin_options[$value['id']];
                            }
                        } else {
                            $select_value = $value['std'];
                        }
						
                        $field_args = array(
                            'depth' => 0,
                            'child_of' => 0,
                            'class' => 'chosen-select',
                            'sort_order' => 'ASC',
                            'sort_column' => 'post_title',
                            'show_option_none' => automobile_var_plugin_text_srt('automobile_var_please_select_page'),
                            'hierarchical' => '1',
                            'exclude' => '',
                            'include' => '',
                            'meta_key' => '',
                            'meta_value' => '',
                            'authors' => '',
                            'exclude_tree' => '',
                            'selected' => $select_value,
                            'echo' => 0,
                            'name' => $value['id'],
                            'post_type' => 'page'
                        );
                        $automobile_opt_array = array(
                            'name' => $value['name'],
                            'id' => $value['id'],
                            'desc' => $value['desc'],
                            'hint_text' => $value['hint_text'],
                            'std' => $select_value,
                            'args' => $field_args,
                            'return' => true,
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_select_page_field($automobile_opt_array);

                        break;
                    case 'default_location_fields':
                        global $automobile_var_plugin_options, $post;
                        $automobile_map_latitude = isset($automobile_var_plugin_options['map_latitude']) ? $automobile_var_plugin_options['map_latitude'] : '';
                        $automobile_map_longitude = isset($automobile_var_plugin_options['map_longitude']) ? $automobile_var_plugin_options['map_longitude'] : '';
                        $automobile_map_zoom = isset($automobile_var_plugin_options['map_zoom']) ? $automobile_var_plugin_options['map_zoom'] : '11';
                        if (isset($automobile_var_plugin_options) && !empty($automobile_var_plugin_options)) {
                            $automobile_post_loc_city = $automobile_var_plugin_options['automobile_post_loc_city'];
                            $automobile_post_loc_country = $automobile_var_plugin_options['automobile_post_loc_country'];
                            $automobile_post_loc_latitude = $automobile_var_plugin_options['automobile_post_loc_latitude'];
                            $automobile_post_loc_longitude = $automobile_var_plugin_options['automobile_post_loc_longitude'];
                            $automobile_post_loc_zoom = $automobile_var_plugin_options['automobile_post_loc_zoom'];
                            $automobile_post_loc_address = $automobile_var_plugin_options['automobile_post_loc_address'];
                            $automobile_add_new_loc = $automobile_var_plugin_options['automobile_add_new_loc'];
                        } else {
                            //if location is not set then get from default location from settings
                            $automobile_post_loc_latitude = $automobile_post_loc_city = $automobile_post_loc_country = '';
                            $automobile_post_loc_latitude = '';
                            $automobile_post_loc_longitude = '';
                            $automobile_post_loc_zoom = '';
                            $automobile_post_loc_address = '';
                            $loc_city = '';
                            $loc_postcode = '';
                            $loc_region = '';
                            $loc_country = '';
                            $event_map_switch = '';
                            $event_map_heading = '';
                            $automobile_add_new_loc = '';
                        }
                        if ($automobile_post_loc_latitude == '')
                            $automobile_post_loc_latitude = $automobile_map_latitude;
                        if ($automobile_post_loc_longitude == '')
                            $automobile_post_loc_longitude = $automobile_map_longitude;
                        if ($automobile_post_loc_zoom == '')
                            $automobile_post_loc_zoom = $automobile_map_zoom;
                        $automobile_var = new automobile_var();
                        $automobile_var->automobile_location_gmap_script();
                        $automobile_var->automobile_google_place_scripts();
                        $automobile_var->automobile_autocomplete_scripts();
                        $locations_parent_id = 0;
                        $country_args = array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'fields' => 'all',
                            'slug' => '',
                            'hide_empty' => false,
                            'parent' => $locations_parent_id,
                        );
                        $automobile_location_countries = get_terms('automobile_locations', $country_args);
                        $location_countries_list = '';
                        $location_states_list = '';
                        $location_cities_list = '';
                        $iso_code_list = '';
                        $iso_code_list_main = '';
                        if (isset($automobile_location_countries) && !empty($automobile_location_countries)) {
                            $selected_iso_code = '';
                            foreach ($automobile_location_countries as $key => $country) {
                                $t_id_main = $country->term_id;
                                $iso_code_list_main = get_option("iso_code_$t_id_main");
                                if (isset($iso_code_list_main['text'])) {
                                    $iso_code_list_main = $iso_code_list_main['text'];
                                }
                                $selected_contry = '';
                                if (isset($automobile_post_loc_country) && $automobile_post_loc_country == $country->slug) {
                                    $selected_contry = 'selected';
                                    $t_id = $country->term_id;
                                    $iso_code_list = get_option("iso_code_$t_id");

                                    if (isset($iso_code_list['text'])) {

                                        $selected_iso_code = $iso_code_list['text'];
                                    }
                                }
                                $location_countries_list .= "<option " . $selected_contry . "  value='" . $country->slug . "' data-name='" . $iso_code_list_main . "'>" . $country->name . "</option>";
                            }
                        }
                        $selected_country = $automobile_post_loc_country;
                        $selected_city = $automobile_post_loc_city;
                        $states = '';
                        if ($automobile_post_loc_country != '') {
                            $selected_spec = get_term_by('slug', $selected_country, 'automobile_locations');
                            $state_parent_id = $selected_spec->term_id;
                            $states_args = array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'fields' => 'all',
                                'slug' => '',
                                'hide_empty' => false,
                                'parent' => $state_parent_id,
                            );
                            $cities = get_terms('automobile_locations', $states_args);
                        }
                        if (isset($automobile_location_countries) && !empty($automobile_location_countries) && isset($automobile_post_loc_country) && !empty($automobile_post_loc_country)) {
                            // load all cities against state
                            if (isset($cities) && $cities != '' && is_array($cities)) {
                                foreach ($cities as $key => $city) {
                                    $selected = ( $selected_city == $city->slug) ? 'selected' : '';
                                    $location_cities_list .= "<option " . $selected . " value='" . $city->slug . "'>" . $city->name . "</option>";
                                }
                            }
                        }

                        $output .= '<fieldset class="gllpLatlonPicker"  style="width:100%; float:left;">
                                        <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;" id="locations_wrap" data-themeurl="' . automobile_var::plugin_url() . '" data-plugin_url="' . automobile_var::plugin_url() . '" data-ajaxurl="' . esc_js(admin_url('admin-ajax.php'), 'cs-automobile') . '" data-map_marker="' . automobile_var::plugin_url() . '/assets/images/map-marker.png">
                                            <div class="option-sec" style="margin-bottom:0;">
                                                <div class="opt-conts">';

                        $automobile_var_country = isset($automobile_var_plugin_static_text['automobile_var_country']) ? $automobile_var_plugin_static_text['automobile_var_country'] : '';
                        $automobile_opt_array = array(
                            'name' => esc_html($automobile_var_country),
                            'id' => 'post_loc_country',
                            'desc' => '',
                            'field_params' => array(
                                'std' => '',
                                'id' => 'post_loc_country',
                                'cust_id' => 'loc_country',
                                'classes' => 'chosen-select form-select-country dir-map-search single-select SlectBox',
                                'options_markup' => true,
                                'return' => true,
                            ),
                        );

                        if (isset($value['contry_hint']) && $value['contry_hint'] != '') {
                            $automobile_opt_array['hint_text'] = $value['contry_hint'];
                        }

                        if (isset($location_countries_list) && $location_countries_list != '') {
                            $automobile_opt_array['field_params']['options'] = '<option value="">' .  automobile_var_plugin_text_srt('automobile_var_select_country') . '</option>' . $location_countries_list;
                        } else {
                            $automobile_opt_array['field_params']['options'] = '<option value="">' .  automobile_var_plugin_text_srt('automobile_var_select_country') . '</option>';
                        }

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' =>   automobile_var_plugin_text_srt('automobile_var_city'),
                            'id' => 'post_loc_city',
                            'desc' => '',
                            'field_params' => array(
                                'std' => '',
                                'id' => 'post_loc_city',
                                'cust_id' => 'loc_city',
                                'classes' => 'chosen-select form-select-city dir-map-search single-select',
                                'markup' => '<span class="loader-cities"></span>',
                                'options_markup' => true,
                                'return' => true,
                            ),
                        );

                        if (isset($value['city_hint']) && $value['city_hint'] != '') {
                            $automobile_opt_array['hint_text'] = $value['city_hint'];
                        }

                        if (isset($location_cities_list) && $location_cities_list != '') {
                            $automobile_opt_array['field_params']['options'] = '<option value="">' .  automobile_var_plugin_text_srt('automobile_var_select_city'). '</option>' . $location_cities_list;
                        } else {
                            $automobile_opt_array['field_params']['options'] = '<option value="">' .  automobile_var_plugin_text_srt('automobile_var_select_city')  . '</option>';
                        }

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);



                        $automobile_opt_array = array(
                            'name' =>  automobile_var_plugin_text_srt('automobile_var_complete_address'),
                            'id' => 'post_loc_address',
                            'desc' => '',
                            'field_params' => array(
                                'std' => $automobile_post_loc_address,
                                'id' => 'post_loc_address',
                                'classes' => 'directory-search-location',
                                'extra_atr' => 'onkeypress="automobile_gl_search_map(this.value)"',
                                'cust_id' => 'loc_address',
                                'return' => true,
                            ),
                        );

                        if (isset($value['address_hint']) && $value['address_hint'] != '') {
                            $automobile_opt_array['hint_text'] = $value['address_hint'];
                        }

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' =>  automobile_var_plugin_text_srt('automobile_var_latitude'),
                            'id' => 'post_loc_latitude',
                            'desc' => '',
                            'styles' => 'display:none;',
                            'field_params' => array(
                                'std' => $automobile_post_loc_latitude,
                                'id' => 'post_loc_latitude',
                                'cust_type' => 'hidden',
                                'classes' => 'gllpLatitude',
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }
                        $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_longitude'),
                            'id' => 'post_loc_longitude',
                            'desc' => '',
                            'styles' => 'display:none;',
                            'field_params' => array(
                                'std' => $automobile_post_loc_longitude,
                                'id' => 'post_loc_longitude',
                                'cust_type' => 'hidden',
                                'classes' => 'gllpLongitude',
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }

                        $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => '',
                            'id' => 'map_search_btn',
                            'desc' => '',
                            'field_params' => array(
                                'std' => automobile_var_plugin_text_srt('automobile_var_search_on_map'),
                                'id' => 'map_search_btn',
                                'cust_type' => 'button',
                                'classes' => 'gllpSearchButton',
                                'return' => true,
                            ),
                        );

                        if (isset($value['split']) && $value['split'] <> '') {
                            $automobile_opt_array['split'] = $value['split'];
                        }
                        $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        $output .= $automobile_html_fields->automobile_full_opening_field(array());
                        $output .= '
                        <div class="clear"></div>';

                        $automobile_opt_array = array(
                            'id' => 'add_new_loc',
                            'std' => $automobile_add_new_loc,
                            'cust_type' => 'hidden',
                            'classes' => 'gllpSearchField',
                            'return' => true,
                        );

                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                        $automobile_opt_array = array(
                            'id' => 'post_loc_zoom',
                            'std' => $automobile_post_loc_zoom,
                            'cust_type' => 'hidden',
                            'classes' => 'gllpZoom',
                            'return' => true,
                        );

                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                        $output .= '
											<div class="clear"></div>
											<div class="cs-map-section" style="float:left; width:100%; height:100%;">
												<div class="gllpMap" id="cs-map-location-id"></div>
											</div>';

                        $output .= $automobile_html_fields->automobile_closing_field(array(
                            'desc' => '',
                                )
                        );

                        $output .= '
                                        </div>
                                    </div>
                                </div>
                                    </fieldset>';
                        $output .= '<script type="text/javascript">
                            var autocomplete;
                                        jQuery(document).ready(function () {
                                            automobile_load_location_ajax();
                                        });
                                        function automobile_gl_search_map() {
                                        
                                            var vals;
                                            vals = jQuery(\'#loc_address\').val();
                                            jQuery(\'.gllpSearchField\').val(vals);
                                        }
                                        (function ($) {
                                            $(function () {
                                    ' . $automobile_var->automobile_google_place_scripts() . '
                                                autocomplete = new google.maps.places.Autocomplete(document.getElementById(\'loc_address\'));';

                        if (isset($selected_iso_code) && $selected_iso_code != '') {
                            $output .= 'autocomplete.setComponentRestrictions({\'country\': \'' . $selected_iso_code . '\'});';
                        }
                        $output .= '});
                            

                                        })(jQuery);
                                    </script>';


                        break;
                    case 'generate_backup':
                        global $wp_filesystem;
                        

                        $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=automobile_settings');
                        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
                            return true;
                        }
                        if (!WP_Filesystem($creds)) {
                            request_filesystem_credentials($backup_url, '', true, false, array());
                            return true;
                        }
                        $automobile_upload_dir = automobile_var::plugin_path() . '/backend/settings/backups/';
                        $automobile_upload_dir_path = automobile_var::plugin_url() . '/backend/settings/backups/';
                        $automobile_all_list = $wp_filesystem->dirlist($automobile_upload_dir);
                        $output .= '<div class="backup_generates_area" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">';
                        $output .= '
                                    <div class="theme-help">
                                            <h4>' . automobile_var_plugin_text_srt('automobile_var_import_options'). '</h4>
                                    </div>';

                        $output .= $automobile_html_fields->automobile_opening_field(array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_file_url'), 
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_file_url_hint'),
                                )
                        );

                        $output .= '<div  class="external_backup_areas">';
                        $automobile_opt_array = array(
                            'std' => '',
                            'cust_id' => "bkup_import_url",
                            'cust_name' => '',
                            'classes' => 'input-medium',
                            'return' => true,
                        );
                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                        $automobile_opt_array = array(
                            'std' => automobile_var_plugin_text_srt('automobile_var_import'),
                            'cust_id' => "cs-p-backup-url-restore",
                            'cust_name' => '',
                            'cust_type' => 'button',
                            'return' => true,
                        );
                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                        $output .= '</div>';

                        $output .= $automobile_html_fields->automobile_closing_field(array(
                            'desc' => '',
                                )
                        );

                        $output .= '<div class="theme-help">
                                            <h4>' . automobile_var_plugin_text_srt('automobile_var_export_options') . '</h4>
                                    </div>';


                        $output .= $automobile_html_fields->automobile_opening_field(array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_generated_files'), 
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_generated_files_hint'),
                                )
                        );

                        if (is_array($automobile_all_list) && sizeof($automobile_all_list) > 0) {
                            $automobile_list_count = 1;
                            $bk_options = '';
                            foreach ($automobile_all_list as $file_key => $file_val) {
                                if (isset($file_val['name'])) {
                                    $automobile_slected = sizeof($automobile_all_list) == $automobile_list_count ? ' selected="selected"' : '';
                                    $bk_options .= '<option' . $automobile_slected . '>' . $file_val['name'] . '</option>';
                                }
                                $automobile_list_count++;
                            }
                            $automobile_opt_array = array(
                                'std' => automobile_var_plugin_text_srt('automobile_var_import'),
                                'cust_id' => "",
                                'cust_name' => '',
                                'classes' => 'input-medium chosen-select-no-single',
                                'extra_atr' => ' onchange="automobile_set_p_filename(this.value, \'' . esc_url($automobile_upload_dir_path) . '\')"',
                                'options_markup' => true,
                                'options' => $bk_options,
                                'return' => true,
                            );
                            $output .= $automobile_html_fields->automobile_form_select_render($automobile_opt_array);

                            $output .= '<div class="backup_action_btns">';
                            if (isset($file_val['name'])) {
                                $automobile_opt_array = array(
                                    'std' =>  automobile_var_plugin_text_srt('automobile_var_restore'),
                                    'cust_id' => "cs-p-backup-restore",
                                    'cust_name' => '',
                                    'extra_atr' => ' data-file="' . $file_val['name'] . '"',
                                    'cust_type' => 'button',
                                    'return' => true,
                                );
                                $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                $output .= '<a download="' . $file_val['name'] . '" href="' . esc_url($automobile_upload_dir_path . $file_val['name']) . '">' . automobile_var_plugin_text_srt('automobile_var_download'). '</a>';
                                $automobile_opt_array = array(
                                    'std' => automobile_var_plugin_text_srt('automobile_var_delete'), 
                                    'cust_id' => "cs-p-backup-delte",
                                    'cust_name' => '',
                                    'extra_atr' => ' data-file="' . $file_val['name'] . '"',
                                    'cust_type' => 'button',
                                    'return' => true,
                                );
                                $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                            }

                            $output .= '</div>';
                            $output .= '<div>&nbsp;</div>';
                        }

                        $automobile_opt_array = array(
                            'std' => automobile_var_plugin_text_srt('automobile_var_generate_backup'), 
                            'cust_id' => "cs-p-bkp",
                            'cust_name' => '',
                            'extra_atr' => ' onclick="javascript:automobile_pl_backup_generate(\'' . esc_js(admin_url('admin-ajax.php')) . '\');"',
                            'cust_type' => 'button',
                            'return' => true,
                        );
                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                        $output .= $automobile_html_fields->automobile_closing_field(array(
                            'desc' => '',
                                )
                        );
                        $output .= '</div>';
                        break;

                    case 'user_import_export':
                        global $wp_filesystem;
					
                        
                        //$output .= '<div class="backup_generates_area" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">';
                        $output .= '';

                        $output .= $automobile_html_fields->automobile_opening_field(array(
                            'name' =>  automobile_var_plugin_text_srt('automobile_var_file_url'),
                            'hint_text' => ''
                                )
                        );

                        $output .= '<div class="external_backup_areas">';
                        $automobile_opt_array = array(
                            'std' => '',
                            'cust_id' => "user_import_url",
                            'cust_name' => '',
                            'classes' => 'input-medium',
                            'return' => true,
                        );
                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                        $automobile_opt_array = array(
                            'std' =>  automobile_var_plugin_text_srt('automobile_var_import_users') ,
                            'cust_id' => "cs-p-backup-url-restore",
                            'cust_name' => '',
                            'cust_type' => 'button',
                            'return' => true,
                        );
                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                        $output .= '</div>';

                        $output .= $automobile_html_fields->automobile_closing_field(array(
                            'desc' => '',
                                )
                        );


                        // $output .= '</div>';
                        break;


                        $output .= '</div>';
                        $output .= '</tbody>
							</table></div></div>';
                }
            }
            $output .= '</div>';
            return array($output, $menu);
        }

        /**
         * End Function  how to create Fields Settings
         */
    }

}