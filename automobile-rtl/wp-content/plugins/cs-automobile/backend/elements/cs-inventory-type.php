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

if (!function_exists('automobile_var_page_builder_inventory_type')) {

    function automobile_var_page_builder_inventory_type($die = 0) {

        global $automobile_node, $automobile_html_fields, $post, $automobile_form_fields, $automobile_var_plugin_static_text;
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
            $PREFIX = 'automobile_inventory_type';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }


        $defaults = array(
            'column_size' => '1/1',
            'automobile_inventory_type_title' => '',
            'automobile_inventory_type_sub_title' => '',
            'automobile_var_inventories' => '',
	    'automobile_var_inventories_style' => '',
            'automobile_inventory_type_button_title' => '',
            'automobile_inventory_type_button_url' => '',
        );
        if (isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else
            $atts = array();
        $inventory_type_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key]))
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'automobile_var_page_builder_inventory_type';
        $coloumn_class = 'column_' . $inventory_type_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }

       
        //Variable Validation

        $automobile_inventory_type_title = isset($automobile_inventory_type_title) ? $automobile_inventory_type_title : '';
        $automobile_inventory_type_sub_title = isset($automobile_inventory_type_sub_title) ? $automobile_inventory_type_sub_title : '';
        $automobile_var_inventories = isset($automobile_var_inventories) ? $automobile_var_inventories : '';
	$automobile_var_inventories_style = isset($automobile_var_inventories_style) ? $automobile_var_inventories_style : '';
        $automobile_inventory_type_button_title = isset($automobile_inventory_type_button_title) ? $automobile_inventory_type_button_title : '';
        $automobile_inventory_type_button_url = isset($automobile_inventory_type_button_url) ? $automobile_inventory_type_button_url : '';
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php
        if (isset($shortcode_view)) {
            echo esc_attr($shortcode_view);
        }
        ?>" item="inventory_type" data="<?php echo automobile_element_size_data_array_index($inventory_type_element_size) ?>">
                 <?php automobile_element_setting($name, $automobile_counter, $inventory_type_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter); ?>" data-shortcode-template="[automobile_inventory_type {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_plugin_text_srt('automobile_var_inventory_type_edit_options'); ?></h5>
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
                                'std' => $automobile_inventory_type_title,
                                'id' => 'automobile_inventory_type_title',
                                'cust_name' => 'automobile_inventory_type_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        
                        $inventory_types_data = array('' => automobile_var_plugin_text_srt('automobile_var_select_inventory_type'));
                        $inventory_type_posts = get_posts(array('posts_per_page' => '-1', 'post_type' => 'inventory-type', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC'));
                        
                        foreach ($inventory_type_posts as $inv_post) {
                            $inventory_types_data[$inv_post->ID] = $inv_post->post_title;
                        }

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_inventory_type'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_inventory_type_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_inventories,
                                'id' => 'automobile_var_inventories',
                                'cust_name' => 'automobile_var_inventories[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => $inventory_types_data,
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_select_field($automobile_opt_array);
			////////////////////////////////////////////////////////
			 $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_inventory_style'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_inventory_style_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_inventories_style,
                                'id' => 'automobile_var_inventories_style',
                                'cust_name' => 'automobile_var_inventories_style[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'simple' => automobile_var_plugin_text_srt('automobile_var_inventory_style_simple'),
                                    'classic' => automobile_var_plugin_text_srt('automobile_var_inventory_style_classic'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_select_field($automobile_opt_array);
			

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_button_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_button_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_inventory_type_button_title,
                                'id' => 'automobile_inventory_type_button_title',
                                'cust_name' => 'automobile_inventory_type_button_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_plugin_text_srt('automobile_var_button_url'),
                            'desc' => '',
                            'hint_text' => automobile_var_plugin_text_srt('automobile_var_button_url_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_inventory_type_button_url,
                                'id' => 'automobile_inventory_type_button_url',
                                'cust_name' => 'automobile_inventory_type_button_url[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);

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
                                        'std' => 'inventory_type',
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

    add_action('wp_ajax_automobile_var_page_builder_inventory_type', 'automobile_var_page_builder_inventory_type');
}