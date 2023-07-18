<?php
/*
 *
 * @Shortcode Name : Inventory Search
 * @retrun
 *
 */
/*
 *
 * Start Function  inventory search
 *
 */
if (!function_exists('automobile_var_page_builder_inventories_search')) {

    function automobile_var_page_builder_inventories_search($die = 0) {
		
        global $automobile_node, $automobile_html_fields, $post, $automobile_form_fields,$automobile_var_plugin_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $PREFIX = 'automobile_inventories_search';
            $parseObject = new ShortcodeParse();
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'inventories_search_title' => '',
            'inventory_search_style' => '',
            'inventory_search_layout' => '',
            'inventory_search_layout_bg' => '',
            'inventory_search_layout_heading_color' => '',
            'inventory_search_title_field_switch' => '',
	    'inventory_search_title_field_style' => '',
            'inventory_search_make_field_switch' => '',
            'inventory_search_type_field_switch' => '',
            'inventory_search_location_field_switch' => '',
            'inventory_lable_switch' => '',
            'inventory_search_hint_switch' => '',
            'inventory_advance_search_switch' => '',
            'inventory_advance_search_url' => '',
        );

        if (isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else
            $atts = array();
        if (isset($output['0']['content']))
            $inventories_search_content = $output['0']['content'];
        else
            $inventories_search_content = '';
        $inventories_search_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key]))
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'automobile_var_page_builder_inventories_search';
        $coloumn_class = 'column_' . $inventories_search_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
		
        <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="inventories_search" data="<?php echo automobile_element_size_data_array_index($inventories_search_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $inventories_search_element_size, '', 'ellipsis-h', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_inventories_search {{attributes}}]{{content}}[/automobile_inventories_search]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_plugin_text_srt('automobile_var_edit_inventory_search'); ?></h5>
                    <a href="javascript:automobile_var_removeoverlay('<?php echo esc_js($name . $automobile_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_bg_color'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_bg_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => isset($inventory_search_layout_bg) ? esc_attr($inventory_search_layout_bg) : '',
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'inventory_search_layout_bg[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_section_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_section_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventories_search_title,
                                'id' => 'inventories_search_title',
                                'cust_name' => 'inventories_search_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_element_title_color'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_element_title_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => isset($inventory_search_layout_heading_color) ? esc_attr($inventory_search_layout_heading_color) : '',
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'inventory_search_layout_heading_color[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);


                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_title_field'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_title_field_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_search_title_field_switch,
                                'id' => 'inventory_search_title_field_switch',
                                'cust_name' => 'inventory_search_title_field_switch[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);
                        
			    $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_view_style'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_choose_view_style'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_search_title_field_style,
                                'id' => 'inventory_search_title_field_style',
                                'cust_name' => 'inventory_search_title_field_style[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'simple' => automobile_var_plugin_text_srt('automobile_var_choose_view_style_simple'),
                                    'classic' => automobile_var_plugin_text_srt('automobile_var_choose_view_style_classic'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_type_field'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_type_field_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_search_type_field_switch,
                                'id' => 'inventory_search_type_field_switch',
                                'cust_name' => 'inventory_search_type_field_switch[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_make_field'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_make_field_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_search_make_field_switch,
                                'id' => 'inventory_search_make_field_switch',
                                'cust_name' => 'inventory_search_make_field_switch[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_location_field'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_location_field_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_search_location_field_switch,
                                'id' => 'inventory_search_location_field_switch',
                                'cust_name' => 'inventory_search_location_field_switch[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);


                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_lables'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_lables_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_lable_switch,
                                'id' => 'inventory_lable_switch',
                                'cust_name' => 'inventory_lable_switch[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_hint_text'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_hint_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_search_hint_switch,
                                'id' => 'inventory_search_hint_switch',
                                'cust_name' => 'inventory_search_hint_switch[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);


                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_advance_search'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_advance_search_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_advance_search_switch,
                                'id' => 'inventory_advance_search_switch',
                                'cust_name' => 'inventory_advance_search_switch[]',
                                'classes' => 'chosen-select-no-single select-medium',
                                'options' => array(
                                    'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                                    'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                                ),
                                'return' => true,
                                'extra_atr' => 'onchange="automobile_display_url_field(this.value);"',
                            ),
                        );
                        $automobile_html_fields->automobile_select_field($automobile_opt_array);

                        $display = "display:none;";
                        if (isset($inventory_advance_search_switch) && $inventory_advance_search_switch == 'yes') {
                            $display = "display:block;";
                        }
                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_url'),
                            'desc' => '',
                            'id' => 'advance_url_field',
                            'styles' => esc_attr($display),
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_url_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $inventory_advance_search_url,
                                'id' => 'inventory_advance_search_url',
                                'cust_name' => 'inventory_advance_search_url[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        ?>
                    </div>
                    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_plugin_text_srt('automobile_var_insert'); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                    <?php } else { ?>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <?php
                                $automobile_opt_array = array(
                                    'id' => '',
                                    'std' => 'inventories_search',
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
        <script>
            /*
             * modern selection box function
             */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
            /*
             * modern selection box function
             */
        </script> 
        <?php
        if ($die <> 1)
            die();
    }

    add_action('wp_ajax_automobile_var_page_builder_inventories_search', 'automobile_var_page_builder_inventories_search');
}
/*
 *
 * End Function  inventory search 
 *
 */