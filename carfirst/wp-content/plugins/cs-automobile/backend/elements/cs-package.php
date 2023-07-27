<?php
/**
 * 
 * @return html
 *
 */
/*
 *
 * Start Function how to create Pakages elements and Pakages short codes
 *
 */

if (!function_exists('automobile_var_page_builder_package')) {

    function automobile_var_page_builder_package($die = 0) {
        global $automobile_node, $automobile_html_fields, $post, $automobile_form_fields, $automobile_var_plugin_static_text , $automobile_var_plugin_options;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_automobile_package_view = '';
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
            $PREFIX = 'automobile_package';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }

        $defaults = array(
            'column_size' => '1/1',
            'automobile_package_title' => '',
            'automobile_package_sub_title' => '',
            'inventory_pkges' => '',
            );
        if (isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else
            $atts = array();
        $package_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key]))
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'automobile_var_page_builder_package';
        $coloumn_class = 'column_' . $package_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        
        
        $automobile_rand_id = rand(13441324, 93441324);
        
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php
        if (isset($shortcode_view)) {
            echo esc_attr($shortcode_view);
        }
        ?>" item="package" data="<?php echo automobile_element_size_data_array_index($package_element_size) ?>">
                 <?php automobile_element_setting($name, $automobile_counter, $package_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter); ?>" data-shortcode-template="[automobile_package {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_plugin_text_srt('automobile_var_packages_edit') ?></h5>
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
                                'std' => $automobile_package_title,
                                'id' => 'compare_inventory_title',
                                'cust_name' => 'automobile_package_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_section_sub_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_section_sub_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_package_sub_title,
                                'id' => 'compare_inventory_sub_title',
                                'cust_name' => 'automobile_package_sub_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                       
                        $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';
                        $inventory_pkges = explode(',', $inventory_pkges);
                        if (!is_array($inventory_pkges)) {
                            $inventory_pkges = array();
                        }

                        if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {

                            $automobile_pkgs_options = '';
                            foreach ($automobile_packages_options as $package_key => $package) {
                                if (isset($package_key) && $package_key <> '') {
                                    $package_id = isset($package['package_id']) ? $package['package_id'] : '';
                                    $package_title = isset($package['package_title']) ? $package['package_title'] : '';
                                    $automobile_selected = in_array($package_id, $inventory_pkges) ? ' selected="selected"' : '';

                                    $automobile_pkgs_options .= '<option' . $automobile_selected . ' value="' . absint($package_id) . '">' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($package_title) . '</option>' . "\n";
                                }
                            }
                            $automobile_opt_array = array(
                                'name' =>automobile_var_plugin_text_srt('automobile_var_packages'),
                                'desc' => '',
                                'hint_text' => automobile_var_plugin_text_srt('automobile_var_packages_hint'),
                                'multi' => true,
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $inventory_pkges,
                                    'id' => 'inventory_pkges',
                                    'classes' => 'dropdown chosen-select',
                                    'cust_name' => 'inventory_pkges[' . $automobile_rand_id . '][]',
                                    'options_markup' => true,
                                    'options' => $automobile_pkgs_options,
                                    'return' => true,
                                ),
                            );

                            $automobile_html_fields->automobile_select_field($automobile_opt_array);
                        }


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
                                        'std' => 'package',
                                        'cust_id' => "",
                                        'cust_name' => "automobile_orderby[]",
                                    );

                                    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                    $automobile_opt_array = array(
                                    'id' => '',
                                    'std' => absint($automobile_rand_id),
                                    'cust_id' => "",
                                    'cust_name' => "automobile_pkg_id[]",
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

    add_action('wp_ajax_automobile_var_page_builder_package', 'automobile_var_page_builder_package');
}