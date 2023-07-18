<?php
/*
 *
 * Start Function how to manage of element setting
 *
 */
if (!function_exists('automobile_element_setting')) {

    function automobile_element_setting($name, $automobile_counter, $element_size, $element_description = '', $page_element_icon = 'icon-star', $type = '') {
        global $automobile_form_fields;
        $element_title = str_replace("automobile_var_page_builder_", "", $name);
        //echo "name == ".$name;
        $elm_name = str_replace("automobile_var_page_builder_", "", $name);
        $element_list = automobile_element_list();
        ?>
        <div class="column-in">
            <?php
            $automobile_opt_array = array(
                'id' => '',
                'std' => esc_attr($element_size),
                'cust_id' => "",
                'cust_name' => esc_attr($element_title) . "_element_size[]",
                'classes' => 'item',
            );
            $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
            ?>
            <a href="javascript:;" onclick="javascript:_createpopshort(jQuery(this))" class="options"><i class="icon-gear"></i></a>
            <a href="#" class="delete-it btndeleteit"><i class="icon-trash-o"></i></a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)"><i class="icon-minus4"></i></a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)"><i class="icon-plus3"></i></a> 
            <span> <i class="cs-icon <?php echo str_replace("jobcareer_pb_", "", $name); ?>-icon"></i> 
                <strong><?php
        if (isset($element_list['element_list'][$elm_name])) {
            echo automobile_validate_data($element_list['element_list'][$elm_name]);
        }
            ?></strong><br/>
                    <?php echo esc_attr($element_description); ?> 
            </span>
        </div>
        <?php
    }

}

/*
 *
 * Start Function  to validate data
 *
 */
if (!function_exists('automobile_validate_data')) {

    function automobile_validate_data($input = '') {
        $output = $input;
        return $output;
    }

}

if (!function_exists('automobile_element_list')) {

    function automobile_element_list() {

        global $automobile_var_frame_static_text;

        $element_list = array();
        $element_list['element_list'] = array(
            'package' => automobile_var_plugin_text_srt('automobile_var_packages'),
            'inventory_type' => automobile_var_plugin_text_srt('automobile_var_inventory_type'),
            'dealer' => automobile_var_plugin_text_srt('automobile_var_dealer'),
            'inventories_search' => automobile_var_plugin_text_srt('automobile_var_inventories_search'),
            'inventories' => automobile_var_plugin_text_srt('automobile_var_inventories'),
            'register' => automobile_var_plugin_text_srt('automobile_var_register'),
        );
        return $element_list;
    }

}

/*
 *
 * Start Function how to manage of element_size using shortcode
 *
 */
if (!function_exists('automobile_shortcode_element_size')) {

    function automobile_shortcode_element_size($column_size = '') {
        global $automobile_html_fields;
       
        $automobile_opt_array = array(
            'name' => __('Size', 'jobhunt'),
            'desc' => '',
            'hint_text' => __('Select column width. This width will be calculated depend page width', 'jobhunt'),
            'echo' => true,
            'field_params' => array(
                'std' => $column_size,
                'id' => '',
                'cust_id' => 'column_size',
                'cust_name' => 'column_size[]',
                'options' => array(
                    '1/1' => __('Full width', 'jobhunt'),
                    '1/2' => __('One half', 'jobhunt'),
                    '1/3' => __('One third', 'jobhunt'),
                    '2/3' => __('Two third', 'jobhunt'),
                    '1/4' => __('One fourth', 'jobhunt'),
                    '3/4' => __('Three fourth', 'jobhunt'),
                ),
                'return' => true,
                'classes' => 'column_size chosen-select-no-single'
            ),
        );


        $automobile_html_fields->automobile_select_field($automobile_opt_array);
    }

}