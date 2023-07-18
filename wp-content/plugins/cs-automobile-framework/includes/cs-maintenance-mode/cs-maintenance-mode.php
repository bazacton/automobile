<?php

add_action('admin_menu', 'automobile_maintenance_mode_menu');
if (!function_exists('automobile_maintenance_mode_menu')) {

    function automobile_maintenance_mode_menu() {
        add_theme_page("Maintenance Mode", automobile_var_frame_text_srt('automobile_var_maintenance_field_name'), 'read', 'automobile_maintenance_mode', 'automobile_maintenance_mode');
    }

}

if (!function_exists('automobile_maintenance_mode')) {

    function automobile_maintenance_mode() {
        global $automobile_frame_settings, $automobile_var_frame_options, $automobile_var_form_fields,$automobile_var_frame_static_text;
        
        $automobile_html = '';
        $automobile_html .= '
        <div class="theme-wrap fullwidth">
        <div class="inner">
        <div class="outerwrapp-layer">
            <div class="loading_div"> 
                <i class="icon-circle-o-notch icon-spin"></i> <br>
                ' . automobile_var_frame_text_srt('automobile_var_saving_changes') . '
            </div>
            <div class="form-msg"> 
                <i class="icon-check-circle-o"></i>
                <div class="innermsg"></div>
            </div>
        </div>
        <div class="row">
        <form id="frm" method="post">
        <div class="col2">';
        $automobile_frame_fields = new automobile_maintenance_fields();
        $return_fields = $automobile_frame_fields->automobile_fields($automobile_frame_settings);
        $automobile_html .= $return_fields;
        $automobile_html .= '
        </div>
        <div class="footer">';
        $automobile_opt_array = array(
            'std' => automobile_var_frame_text_srt('automobile_var_maintenance_save_settings'),
            'cust_id' => 'submit_btn',
            'cust_name' => 'submit_btn',
            'cust_type' => 'button',
            'extra_atr' => 'onclick="javascript:automobile_frame_option_save(\'' . esc_js(admin_url('admin-ajax.php')) . '\');"',
            'classes' => 'bottom_btn_save',
            'return' => true,
        );
        $automobile_html .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
        $automobile_opt_array = array(
            'std' => 'automobile_frame_option_save',
            'cust_id' => 'action',
            'cust_name' => 'action',
            'classes' => '',
            'return' => true,
        );
        $automobile_html .= $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
        $automobile_opt_array = array(
            'std' => '1',
            'cust_id' => 'automobile_frame_option_saving',
            'cust_name' => 'automobile_frame_option_saving',
            'classes' => '',
            'return' => true,
        );
        $automobile_html .= $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
        $automobile_html .= '
        </div>
        </form>
        </div>
        </div>
        </div>';

        echo force_balance_tags($automobile_html);
    }

}

if (!function_exists('automobile_maintenance_options_array')) {
    add_action('init', 'automobile_maintenance_options_array');

    function automobile_maintenance_options_array() {
        global $automobile_frame_settings, $automobile_var_frame_options,$automobile_var_frame_static_text;

        $on_off_option = array(
            "show" => "on",
            "hide" => "off",
        );
        
        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_name'),
            "std" => automobile_var_frame_text_srt('automobile_var_maintenance_field_name'),
            "type" => "section"
        );
        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_name'),
            "desc" => "",
            "hint_text" => automobile_var_frame_text_srt('automobile_var_maintenance_field_mode_hint'),
            "id" => "coming_soon_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_logo'),
            "desc" => "",
            "hint_text" => automobile_var_frame_text_srt('automobile_var_maintenance_field_logo_hint'),
            "id" => "coming_logo_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_social'),
            "desc" => "",
            "hint_text" => automobile_var_frame_text_srt('automobile_var_maintenance_field_social_hint'),
            "id" => "coming_social_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_newsletter'),
            "desc" => "",
            "hint_text" => automobile_var_frame_text_srt('automobile_var_maintenance_field_newsletter_hint'),
            "id" => "coming_newsletter_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );


        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_header'),
            "desc" => "",
            "hint_text" => automobile_var_frame_text_srt('automobile_var_maintenance_field_header_hint'),
            "id" => "header_switch",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_footer'),
            "desc" => "",
            "hint_text" => automobile_var_frame_text_srt('automobile_var_maintenance_field_footer_hint'),
            "id" => "footer_setting",
            "std" => "off",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $args = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );

        $automobile_var_pages = get_pages($args);

        $automobile_var_options_array = array();
        $automobile_var_options_array[] = automobile_var_frame_text_srt('automobile_var_maintenance_field_select_page');
        foreach ($automobile_var_pages as $automobile_var_page) {

            $automobile_var_options_array[$automobile_var_page->ID] = isset($automobile_var_page->post_title) && ($automobile_var_page->post_title != '') ? $automobile_var_page->post_title : automobile_var_frame_text_srt('automobile_var_no_title');
        }


        $automobile_frame_settings[] = array("name" => automobile_var_frame_text_srt('automobile_var_maintenance_field_mode_page'),
            "desc" => "",
            "hint_text" => automobile_var_frame_text_srt('automobile_var_maintenance_field_mode_page_hint'),
            "id" => "maintinance_mode_page",
            "std" => automobile_var_frame_text_srt('automobile_var_maintenance_select_page'),
            "type" => "select",
            'classes' => 'chosen-select',
            "options" => $automobile_var_options_array
        );
    }

}