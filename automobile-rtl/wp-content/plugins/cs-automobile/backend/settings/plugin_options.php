<?php

/**
 * Start Function  how to Create Theme Options in Backend 
 */
if (!function_exists('automobile_settings_options_page')) {

    function automobile_settings_options_page() {

	global $automobile_setting_options, $automobile_form_fields, $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_option_strings();

	$automobile_var_plugin_options = get_option('automobile_var_plugin_options');
	$obj = new automobile_options_fields();
	$return = $obj->automobile_fields($automobile_setting_options);
	$automobile_opt_btn_array = array(
	    'id' => '',
	    'std' => automobile_var_plugin_text_srt('automobile_var_save_msg'),
	    'cust_id' => "submit_btn",
	    'cust_name' => "submit_btn",
	    'cust_type' => 'button',
	    'classes' => 'bottom_btn_save',
	    'extra_atr' => 'onclick="javascript:plugin_option_save(\'' . esc_js(admin_url('admin-ajax.php')) . '\');" ',
	    'return' => true,
	);


	$automobile_opt_hidden1_array = array(
	    'id' => '',
	    'std' => 'plugin_option_save',
	    'cust_id' => "",
	    'cust_name' => "action",
	    'return' => true,
	);

	;

	$automobile_opt_hidden2_array = array(
	    'id' => '',
	    'std' => automobile_var::plugin_url(),
	    'cust_id' => "automobile_plugin_url",
	    'cust_name' => "automobile_plugin_url",
	    'return' => true,
	);

	;

	$automobile_opt_btn_cancel_array = array(
	    'id' => '',
	    'std' => automobile_var_plugin_text_srt('automobile_var_reset_msg'),
	    'cust_id' => "submit_btn",
	    'cust_name' => "reset",
	    'cust_type' => 'button',
	    'classes' => 'bottom_btn_reset',
	    'extra_atr' => 'onclick="javascript:automobile_rest_plugin_options(\'' . esc_js(admin_url('admin-ajax.php')) . '\');"',
	    'return' => true,
	);

	$html = '
        <div class="theme-wrap fullwidth">
            <div class="inner">
                <div class="outerwrapp-layer">
                    <div class="loading_div"> <i class="icon-circle-o-notch icon-spin"></i> <br>
                        ' . automobile_var_plugin_text_srt('automobile_var_saving_changes') . '
                    </div>
                    <div class="form-msg"> <i class="icon-check-circle-o"></i>
                        <div class="innermsg"></div>
                    </div>
                </div>
                <div class="row">
                    <form id="plugin-options" method="post">
			<div class="col1">
                            <nav class="admin-navigtion">
                                <div class="logo"> <a href="javascript;;" class="logo1"><img src="' . esc_url(automobile_var::plugin_url()) . 'assets/backend/images/logo.png" /></a> <a href="#" class="nav-button"><i class="icon-align-justify"></i></a> </div>
                                <ul>
                                    ' . force_balance_tags($return[1], true) . '
                                </ul>
                            </nav>
                        </div>
                        <div class="col2">
                        ' . force_balance_tags($return[0], true) . '
                        </div>

                        <div class="clear"></div>
                        <div class="footer">
                        ' . $automobile_form_fields->automobile_form_text_render($automobile_opt_btn_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden1_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden2_array) . '
                        ' . $automobile_form_fields->automobile_form_text_render($automobile_opt_btn_cancel_array) . '
                                
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear"></div>';
	echo force_balance_tags($html, true);
    }

    /**
     * end Function  how to Create Theme Options in Backend 
     */
}
/**
 * Start Function  how to Create Theme Options setting in Backend 
 */
if (!function_exists('automobile_settings_option')) {

    function automobile_settings_option() {
	global $automobile_setting_options, $automobile_var_plugin_options, $automobile_var_plugin_static_text;

	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_option_strings();

	$automobile_theme_menus = get_registered_nav_menus();
	$automobile_var_plugin_options = get_option('automobile_var_plugin_options');
	$on_off_option = array(
	    "show" => automobile_var_plugin_text_srt('automobile_var_on'),
	    "hide" => automobile_var_plugin_text_srt('automobile_var_off'),
	);

	$automobile_min_days = array();
	for ($days = 1; $days < 11; $days ++) {
	    $automobile_min_days[$days] = "$days day";
	}
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_general_options'),
	    "fontawesome" => 'icon-tools',
	    "id" => "tab-general",
	    "std" => "",
	    "type" => "heading",
	    "options" => array(
		'tab-general-page-settings' => automobile_var_plugin_text_srt('automobile_var_page_settings'),
		'tab-general-default-location' => automobile_var_plugin_text_srt('automobile_var_default_location'),
		'tab-general-others' => automobile_var_plugin_text_srt('automobile_var_others'),
	    )
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_gateways'),
	    "fontawesome" => 'icon-wallet2',
	    "id" => "tab-gateways-settings",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ''
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_packages'),
	    "fontawesome" => 'icon-credit-card',
	    "id" => "tab-packages-settings",
	    "std" => "",
	    "type" => "heading",
	    "options" => array(
		'tab-inventory-pkgs' => automobile_var_plugin_text_srt('automobile_var_inventory_credit'),
		'tab-featured_inventories' => automobile_var_plugin_text_srt('automobile_var_featured_inventories'),
	    )
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_custom_fields'),
	    "fontawesome" => 'icon-list-alt',
	    "id" => "tab-custom-fields",
	    "std" => "",
	    "type" => "heading",
	    "options" => array(
		'tab-cusfields-dealers' => automobile_var_plugin_text_srt('automobile_var_dealer'),
	    )
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_api_setting'),
	    "fontawesome" => 'icon-link4',
	    "id" => "tab-api-setting",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ''
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_search_option'),
	    "fontawesome" => 'icon-search',
	    "id" => "tab-basic-settings",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => '',
	);

	// General Settings
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_general_options'),
	    "id" => "tab-general-page-settings",
	    "type" => "sub-heading",
	    "help_text" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_user_setting'),
	    "id" => "tab-user-settings",
	    "std" => automobile_var_plugin_text_srt('automobile_var_user_setting'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_user_login_dashboard'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_user_login_dashboard_hint'),
	    "id" => "user_dashboard_switchs",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_menu_location'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_menu_location_hint'),
	    "id" => "menu_login_location",
	    "std" => "",
	    'classes' => 'chosen-select-no-single',
	    "type" => "select_values",
	    "options" => $automobile_theme_menus,
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_dealer_dashboard'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_dealer_dashboard_hint'),
	    "id" => "automobile_emp_dashboard",
	    "std" => "",
	    "type" => "select_dashboard",
	    "options" => '',
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_author_page_slug'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_author_page_slug_hint'),
	    "id" => "author_page_slug",
	    "std" => "user",
	    "type" => "text"
	);
	$on_off_option = array("show" => "on", "hide" => "off");
	$automobile_setting_options[] = array("name" => esc_html__("Terms and Conditions For Registeration", "cs-automobile"),
	    "id" => "tab-job-options",
	    "std" => esc_html__("Terms and Conditions For Registeration", "cs-automobile"),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array(
	    "name" => esc_html__("Terms and Conditions switch", "cs-automobile"),
	    "desc" => "",
	    "hint_text" => esc_html__("Turn this condition on to add terms and policy chek in the signup.", "cs-automobile"),
	    "id" => "terms_policy_switch",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array(
	    "name" => esc_html__("Dealer Terms and Conditions Page", "cs-automobile"),
	    "desc" => "",
	    "hint_text" => esc_html__("Please select the dealer terms and conditions page.", "cs-automobile"),
	    "id" => "dealer_term_page",
	    "std" => "",
	    "classes" => "chosen-select-no-single",
	    "type" => "select_dashboard",
	    "options" => '',
	);
	$automobile_setting_options[] = array(
	    "name" => esc_html__("Privacy Policy", "cs-automobile"),
	    "desc" => "",
	    "hint_text" => esc_html__("Please select the privacy policy page.", "cs-automobile"),
	    "id" => "privacy_page",
	    "std" => "",
	    "classes" => "chosen-select-no-single",
	    "type" => "select_dashboard",
	    "options" => '',
	);
	//Default css Elements
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_css'),
	    "id" => "tab-inventory-options",
	    "std" => automobile_var_plugin_text_srt('automobile_var_default_css_element'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_css'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_default_css_element_hint'),
	    "id" => "common-elements-style",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);

	// Default sidebar
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_sidebars'),
	    "id" => "tab-inventory-options",
	    "std" => automobile_var_plugin_text_srt('automobile_var_default_sidebars'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_sidebar_switch'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_default_sidebar_switch_hint'),
	    "id" => "default-sidebars",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	//Detail Page Style Start
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_detail_page_style'),
	    "id" => "tab-inventory-options",
	    "std" => automobile_var_plugin_text_srt('automobile_var_detail_page_style'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_detail_style'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_detail_style_hint'),
	    "id" => "detail_style",
	    "std" => "",
	    "classes" => "chosen-select-no-single",
	    "type" => "select",
	    "options" => array(
		'' => automobile_var_plugin_text_srt('automobile_var_detail_style_0'),
		'view-1' => automobile_var_plugin_text_srt('automobile_var_detail_style_1'),
		'view-2' => automobile_var_plugin_text_srt('automobile_var_detail_style_2'),
		'view-3' => automobile_var_plugin_text_srt('automobile_var_detail_style_3'),
	    ),
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_detail_advertisement'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_detail_advertisement_hint'),
	    "id" => "detail_ads",
	    "std" => "",
	    "type" => "textarea",
	);
	//Detail Page Style End
	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);
	// general default location 
	// Default location

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_location'),
	    "id" => "tab-general-default-location",
	    "type" => "sub-heading",
	    "help_text" => automobile_var_plugin_text_srt('automobile_var_default_location_hint'),
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_location'),
	    "id" => "tab-settings-default-location",
	    "std" => automobile_var_plugin_text_srt('automobile_var_default_location'),
	    "type" => "section",
	    "options" => "",
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_cluster_icon'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "automobile_map_cluster_icon",
	    "std" => automobile_var::plugin_url() . 'assets/backend/images/culster-icon.png',
	    "display" => "none",
	    "type" => "upload logo"
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_map_marker_icon'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "automobile_map_marker_icon",
	    "std" => automobile_var::plugin_url() . 'assets/backend/images/map-marker.png',
	    "display" => "none",
	    "type" => "upload logo"
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_zoom_level'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "map_zoom_level",
	    "std" => "11",
	    "type" => "text"
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_map_marker_color'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "map_cluster_color",
	    "std" => "#fff",
	    "type" => "color"
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_map_auto_zoom'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_map_auto_zoom_hint'),
	    "id" => "map_auto_zoom",
	    "main_id" => 'automobile_map_auto_zoom_main',
	    "std" => "",
	    "type" => "checkbox"
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_map_lock'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "map_lock",
	    "main_id" => 'automobile_map_lock_main',
	    "std" => "",
	    "type" => "checkbox"
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_address'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "default_locations",
	    "std" => "",
	    "type" => "default_location_fields",
	    "contry_hint" => automobile_var_plugin_text_srt('automobile_var_contry_hint'),
	    "city_hint" => automobile_var_plugin_text_srt('automobile_var_city_hint'),
	    "address_hint" => automobile_var_plugin_text_srt('automobile_var_address_hint'),
	);
	$automobile_setting_options[] = array("col_heading" => automobile_var_plugin_text_srt('automobile_var_default_location'),
	    "type" => "col-right-text",
	    "help_text" => automobile_var_plugin_text_srt('automobile_var_default_geo_location_hint'),
	);
	//End default location 
	// general others
	// Default location fields
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_others'),
	    "id" => "tab-general-others",
	    "type" => "sub-heading",
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_submissions'),
	    "id" => "tab-settings-submissions",
	    "std" => automobile_var_plugin_text_srt('automobile_var_submissions'),
	    "type" => "section",
	    "options" => ""
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_search_result_page'),
	    "desc" => '',
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_search_result_page_hint'),
	    "id" => "automobile_search_result_page",
	    "std" => '',
	    "type" => "select_dashboard",
	    "options" => ''
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_compare_list_page'),
	    "desc" => '',
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_compare_list_page_hint'),
	    "id" => "automobile_compare_list_page",
	    "std" => '',
	    "type" => "select_dashboard",
	    "options" => ''
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_single_page_switch'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_single_page_switch_hint'),
	    "id" => "plugin_single_container",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_inventory_switch'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_inventory_switch_hint'),
	    "id" => "inventories_review_option",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_dealer_switch'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_dealer_switch_hint'),
	    "id" => "dealer_review_option",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_vat_switch'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_vat_switch_hint'),
	    "id" => "vat_switch",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_value_added'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_value_added_hint'),
	    "id" => "payment_vat",
	    "std" => "",
	    "type" => "text",
	);

	global $gateways;
	$general_settings = new AUTOMOBILE_PAYMENTS();
	$automobile_settings = $general_settings->automobile_general_settings();

	foreach ($automobile_settings as $key => $params) {
	    $automobile_setting_options[] = $params;
	}
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_confirmation'),
	    "id" => "tab-welcome-page",
	    "std" => automobile_var_plugin_text_srt('automobile_var_confirmation'),
	    "type" => "section",
	    "options" => "",
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_title'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_confirmation_title_hint'),
	    "id" => "inventory_welcome_title",
	    "std" => "",
	    "type" => "text",
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_content'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_confirmation_content_hint'),
	    "id" => "inventory_welcome_con",
	    "std" => "",
	    "type" => "textarea",
	);

	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);

	// Payments Gateways
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_gateways_settings'),
	    "id" => "tab-gateways-settings",
	    "type" => "sub-heading"
	);
	$automobile_gateways_id = rand(99, 99999);

	foreach ($gateways as $key => $value) {
	    if (class_exists($key)) {
		$settings = new $key();
		$automobile_settings = $settings->settings($automobile_gateways_id);
		foreach ($automobile_settings as $key => $params) {
		    $automobile_setting_options[] = $params;
		}
	    }
	}
	$automobile_setting_options[] = array("col_heading" => automobile_var_plugin_text_srt('automobile_var_gateways_settings'),
	    "type" => "col-right-text",
	    "help_text" => ""
	);
	// Packages
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_inventory_credit'),
	    "id" => "tab-inventory-pkgs",
	    "type" => "sub-heading"
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_inventory_credit'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_add_edit_packages'),
	    "id" => "cs-inventory-packages",
	    "std" => '',
	    "type" => "packages"
	);
	$automobile_setting_options[] = array("col_heading" => automobile_var_plugin_text_srt('automobile_var_inventory_credit'),
	    "type" => "col-right-text",
	    "help_text" => ""
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_featured_inventories'),
	    "id" => "tab-featured_inventories",
	    "type" => "sub-heading"
	);
	//content box heading
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_featured_inventories'),
	    "id" => "tab-settings-featured-inventories",
	    "std" => automobile_var_plugin_text_srt('automobile_var_featured_inventories'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_feature_price'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_feature_price_hint'),
	    "id" => "inventory_feat_price",
	    "std" => "",
	    "type" => "text",
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_feature_price_text'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_feature_price_text_hint'),
	    "id" => "inventory_feat_txt",
	    "std" => "",
	    "type" => "textarea",
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_payment_text'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_payment_text_hint'),
	    "id" => "inventory_pay_txt",
	    "std" => "",
	    "type" => "textarea",
	);
	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);
	// Custom Fields
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_inventories_fields'),
	    "id" => "tab-cusfields-inventories",
	    "type" => "sub-heading"
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_inventories_custom_fields'),
	    "id" => "tab-user-settings",
	    "std" => automobile_var_plugin_text_srt('automobile_var_inventories_custom_fields'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_custom_fields'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "cs-custom-fields",
	    "std" => "",
	    "type" => "custom_fields",
	);
	$automobile_setting_options[] = array("col_heading" => automobile_var_plugin_text_srt('automobile_var_dealers_fields'),
	    "type" => "col-right-text",
	    "help_text" => ""
	);
	// Dealer
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_dealers_fields'),
	    "id" => "tab-cusfields-dealers",
	    "type" => "sub-heading"
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_dealer_custom_fields'),
	    "id" => "tab-user-settings",
	    "std" => automobile_var_plugin_text_srt('automobile_var_dealer_custom_fields'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_custom_fields'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "cs-custom-fields",
	    "std" => "",
	    "type" => "dealer_custom_fields",
	);
	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_api_setting'),
	    "id" => "tab-api-setting",
	    "type" => "sub-heading"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_twitter_section'),
	    "id" => "Twitter",
	    "std" => "Twitter",
	    "type" => "section",
	    "options" => ""
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_twitter'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_twitter_hint'),
	    "id" => "twitter_api_switch",
	    "std" => "on",
	    "type" => "checkbox"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_twitter_consumer_key'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_twitter_consumer_key_hint'),
	    "id" => "consumer_key",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_twitter_consumer_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_twitter_consumer_secret_hint'),
	    "id" => "consumer_secret",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_twitter_access_token'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_twitter_access_token_hint'),
	    "id" => "access_token",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_twitter_access_token_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_twitter_access_token_secret_hint'),
	    "id" => "access_token_secret",
	    "std" => "",
	    "type" => "text"
	);
	//end Twitter Api		
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_facebook_section'),
	    "id" => "Facebook",
	    "std" => "Facebook",
	    "type" => "section",
	    "options" => ""
	);

	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_facebook_switch'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_facebook_switch_hint'),
	    "id" => "facebook_login_switch",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_facebook_app_id'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_facebook_app_id_hint'),
	    "id" => "facebook_app_id",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_facebook_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_facebook_secret_hint'),
	    "id" => "facebook_secret",
	    "std" => "",
	    "type" => "text"
	);
	//end facebook api
	//start linkedin api
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_linkedin_section'),
	    "id" => "Linked-in",
	    "std" => "Linked-in",
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array(
	    "desc" => "",
	    "name" => automobile_var_plugin_text_srt('automobile_var_linkedin_switch'),
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_linkedin_switch_hint'),
	    "id" => "linkedin_login_switch",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_linkedin_app_id'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_linkedin_app_id_hint'),
	    "id" => "linkedin_app_id",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_linkedin_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_linkedin_secret_hint'),
	    "id" => "linkedin_secret",
	    "std" => "",
	    "type" => "text"
	);



	//end linkedin api
	//start google api
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_google_section'),
	    "id" => "Google+",
	    "std" => "Google+",
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_google_switch'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_google_switch_hint'),
	    "id" => "google_login_switch",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_google_client_id'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_google_client_id_hint'),
	    "id" => "google_client_id",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_google_client_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_google_client_secret_hint'),
	    "id" => "google_client_secret",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_google_api'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_google_api_hint'),
	    "id" => "google_api_key",
	    "std" => "",
	    "type" => "text"
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_redirect'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_redirect_hint'),
	    "id" => "google_login_redirect_url",
	    "std" => "",
	    "type" => "text"
	);
	//end google api
	// captcha settings
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_captcha'),
	    "id" => "Captcha",
	    "std" => "Captcha",
	    "type" => "section",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_captcha'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_captcha_hint'),
	    "id" => "captcha_switch",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_captcha_site_key'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_captcha_site_key_hint'),
	    "id" => "sitekey",
	    "std" => "",
	    "type" => "text",
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_captcha_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_captcha_secret_hint'),
	    "id" => "secretkey",
	    "std" => "",
	    "type" => "text",
	);
	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);
	// end captcha settings
	// Search Settings
	// Basic Search Settings
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_search_options'),
	    "id" => "tab-basic-settings",
	    "type" => "sub-heading"
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_searching_options'),
	    "id" => "tab-settings-Searching-Options",
	    "std" => automobile_var_plugin_text_srt('automobile_var_searching_options'),
	    "type" => "section",
	    "options" => ""
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_location_search'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_location_search_hint'),
	    "id" => "search_location",
	    "std" => "on",
	    "type" => "checkbox",
	    "onchange" => "automobile_search_view_change(this.name)",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_search_location",
	    "enable_val" => "on",
	    "extra_atts" => 'id="automobile_search_view_area"',
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_google_auto_complete'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_google_auto_complete_hint'),
	    "id" => "google_autocomplete_enable",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_geo_location'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_geo_location_hint'),
	    "id" => "geo_location",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_radius'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_radius_hint'),
	    "id" => "radius_switch",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);

	$inventory_types_data = array('' => automobile_var_plugin_text_srt('automobile_var_select_inventory_type'));
	$automobile_inventory_args = array('posts_per_page' => '-1', 'post_type' => 'inventory-type', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC');
	$cust_query = get_posts($automobile_inventory_args);
	if (is_array($cust_query) && sizeof($cust_query) > 0) {
	    foreach ($cust_query as $automobile_inventory_type) {
		$inventory_types_data[$automobile_inventory_type->post_name] = get_the_title($automobile_inventory_type->ID);
	    }
	}

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_inventory_type'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "default_inventory_type",
	    "std" => "",
	    "type" => "select_values",
	    'classes' => 'chosen-select-no-single',
	    "extra_atts" => '',
	    "options" => $inventory_types_data,
	);


	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_radius_input'),
	    "id" => "radius_min",
	    "id2" => "radius_max",
	    "id3" => "radius_step",
	    "std" => "0",
	    "std2" => "500",
	    "std3" => "20",
	    "placeholder" => automobile_var_plugin_text_srt('automobile_var_radius_min_value'),
	    "placeholder2" => automobile_var_plugin_text_srt('automobile_var_radius_max_value'),
	    "placeholder3" => automobile_var_plugin_text_srt('automobile_var_radius_increment_step'),
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_radius_increment_step_hint'),
	    "desc" => "",
	    "type" => "text3",
	);
	$automobile_setting_options[] = array(
	    "name" => automobile_var_plugin_text_srt('automobile_var_default_radius'),
	    "id" => "default_radius",
	    "std" => "200",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_default_radius_hint'),
	    "desc" => "",
	    "type" => "text",
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_radius_measurement'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_radius_measurement_hint'),
	    "id" => "radius_measure",
	    "std" => "",
	    "type" => "select_values",
	    'classes' => 'chosen-select-no-single',
	    "options" => array(
		'miles' => automobile_var_plugin_text_srt('automobile_var_miles'),
		'km' => automobile_var_plugin_text_srt('automobile_var_km'),
	    ),
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_search_by_location'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_search_by_location_hint'),
	    "id" => "search_by_location",
	    "std" => "",
	    "type" => "select_values",
	    'classes' => 'chosen-select-no-single',
	    "extra_atts" => ' onchange="automobile_single_city_change(this.value)"',
	    "options" => array(
		"countries_only" => automobile_var_plugin_text_srt('automobile_var_countries_only'),
		"countries_and_cities" => automobile_var_plugin_text_srt('automobile_var_countries_and_cities'),
		"cities_only" => automobile_var_plugin_text_srt('automobile_var_cities_only'),
		"single_city" => automobile_var_plugin_text_srt('automobile_var_select_city'),
	    )
	);
	$automobile_location_countries = get_option('automobile_location_countries');
	$states_list = get_option('automobile_location_states');
	$cities_list = get_option('automobile_location_cities');
	$cities_array = array();
	$cities_array[''] = automobile_var_plugin_text_srt('automobile_var_select_city');
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
	if (isset($automobile_location_countries) && !empty($automobile_location_countries)) {
	    foreach ($automobile_location_countries as $key => $country) {
		// load all cities against state  
		$cities = '';
		$selected_spec = get_term_by('slug', $country->slug, 'automobile_locations');
		$city_parent_id = $selected_spec->term_id;
		$cities_args = array(
		    'orderby' => 'name',
		    'order' => 'ASC',
		    'fields' => 'all',
		    'slug' => '',
		    'hide_empty' => false,
		    'parent' => $city_parent_id,
		);
		$cities = get_terms('automobile_locations', $cities_args);
		if (isset($cities) && $cities != '' && is_array($cities)) {
		    foreach ($cities as $key => $city) {
			$cities_array[$city->slug] = $city->name;
		    }
		}
	    }
	}

	$automobile_setting_options[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_search_by_location",
	    "enable_val" => "single_city",
	    "extra_atts" => 'id="automobile_single_city_area"',
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_select_city'),
	    "desc" => "",
	    "hint_text" => automobile_var_plugin_text_srt('automobile_var_select_city_hint'),
	    "id" => "",
	    "std" => "",
	    'classes' => 'chosen-select-no-single',
	    "type" => "select_values",
	    "options" => $cities_array,
	);
	$automobile_setting_options[] = array(
	    "type" => "division_close",
	);
	$automobile_setting_options[] = array(
	    "type" => "division_close",
	);
	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);



	// Add-ons     
	global $automobile_var_plugin_addons;   // global array for add
	if (isset($automobile_var_plugin_addons) && !empty($automobile_var_plugin_addons)) {
	    $addon_subtabs = '';
	    foreach ($automobile_var_plugin_addons as $addon_var => $addon_val) {
		if ((isset($addon_val['slug']) && $addon_val['slug'] != '') && (isset($addon_val['name']) && $addon_val['name'] != ''))
		    $addon_subtabs['tab-' . $addon_val['slug']] = $addon_val['name'];
	    }
	    // main menu
	    $automobile_setting_options[] = array(
		"name" => esc_html($automobile_var_add_on_setting),
		"fontawesome" => 'icon-search',
		"id" => "tab-inventoryline-add-addone",
		"std" => "",
		"type" => "heading",
		"options" => isset($addon_subtabs) ? $addon_subtabs : '',
	    );
	    $automobile_setting_options[] = $automobile_var_plugin_addons['settings'];
	    if (isset($automobile_var_plugin_addons) && !empty($automobile_var_plugin_addons)) {
		foreach ($automobile_var_plugin_addons as $var => $val) {
		    if ((isset($val['name']) && $val['name'] != '') && (isset($val['slug']) && $val['slug'] != '')) {
			$automobile_setting_options[] = array("name" => __($val['name'], "automobile"),
			    "id" => "tab-" . $val['slug'],
			    "type" => "sub-heading"
			);
			$automobile_setting_options[] = array("name" => esc_html($automobile_var_inventories_line_maps),
			    "desc" => "",
			    "hint_text" => esc_html($automobile_var_active_inactive),
			    "id" => "inventoriesline_addon_maps",
			    "std" => "on",
			    "type" => "checkbox");

			// first addon settings
			if (isset($val['settings']) && !empty($val['settings'])) {
			    foreach ($val['settings'] as $setting_var => $settings_val) {
				$automobile_setting_options[] = $settings_val;
			    }
			}
		    }
		}
	    }
	}
	//End  Add-ons
	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_import_export'),
	    "fontawesome" => 'icon-database',
	    "id" => "tab-import-export-options",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ""
	);
	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_import_export'),
	    "id" => "tab-import-export-options",
	    "type" => "sub-heading"
	);

	$automobile_setting_options[] = array("name" => automobile_var_plugin_text_srt('automobile_var_backup'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "backup_options",
	    "std" => "",
	    "type" => "generate_backup"
	);



	$automobile_setting_options[] = array(
	    "type" => "col-right-text",
	);

	update_option('automobile_plugin_data', $automobile_setting_options);
    }

}
$output = '';
$output .= '</div>';
