<?php
/**
 * 
 * @return html
 *
 */
/*
 *
 * Start Function how to create compare_inventory elements and compare_inventory short codes
 *
 */

if (!function_exists('automobile_var_page_builder_compare_inventories')) {

    function automobile_var_page_builder_compare_inventories($die = 0) {
        global $automobile_node, $automobile_html_fields, $post, $automobile_form_fields , $automobile_var_plugin_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_automobile_compare_inventory_view = '';
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
            $PREFIX = 'automobile_compare_inventories';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }

        $defaults = array('column_size' => '1/1', 'automobile_compare_inventory_title' => '', 'automobile_compare_inventory_sub_title' => '', 'automobile_compare_inventory_top_search' => '', 'automobile_compare_inventory_view' => 'classic', 'automobile_compare_inventory_result_type' => 'all', 'automobile_compare_inventory_searchbox' => 'yes', 'automobile_compare_inventory_filterable' => 'yes', 'automobile_compare_inventory_show_pagination' => 'pagination', 'automobile_compare_inventory_pagination' => '10');
        if (isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else
            $atts = array();
        $compare_inventories_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key]))
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'automobile_var_page_builder_compare_inventories';
        $coloumn_class = 'column_' . $compare_inventories_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
      
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php
        if (isset($shortcode_view)) {
            echo esc_attr($shortcode_view);
        }
        ?>" item="compare_inventories" data="<?php echo automobile_element_size_data_array_index($compare_inventories_element_size) ?>">
        <?php automobile_element_setting($name, $automobile_counter, $compare_inventories_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter); ?>" data-shortcode-template="[automobile_compare_inventories {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_plugin_text_srt('automobile_var_edit_compare_inventories_option') ?></h5>
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
                                'std' => $automobile_compare_inventory_title,
                                'id' => 'compare_inventory_title',
                                'cust_name' => 'automobile_compare_inventory_title[]',
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
                'std' => 'compare_inventories',
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

    add_action('wp_ajax_automobile_var_page_builder_compare_inventories', 'automobile_var_page_builder_compare_inventories');
}