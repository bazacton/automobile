<?php
/**
 * automobile Theme Options
 *
 * @package WordPress
 * @subpackage automobile
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_var_settings_page')) {

    function automobile_var_settings_page() {

	global $automobile_var_options, $automobile_var_settings, $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_static_text;
	$strings = new automobile_theme_all_strings;
	$strings->automobile_theme_option_strings();
	?>
	<div class="theme-wrap fullwidth">
	    <div class="inner">
		<div class="outerwrapp-layer">
		    <div class="loading_div"> 
			<i class="icon-circle-o-notch icon-spin"></i> <br>
			<?php
			echo automobile_var_theme_text_srt('automobile_var_theme_option_save_msg');
			?>
		    </div>
		    <div class="form-msg"> 
			<i class="icon-check-circle-o"></i>
			<div class="innermsg"></div>
		    </div>
		</div>
		<div class="row">
		    <form id="frm" method="post">
			<?php
			$automobile_var_fields = new automobile_var_fields();
			$return = $automobile_var_fields->automobile_var_fields($automobile_var_settings);
			?>
			<div class="col1">
			    <nav class="admin-navigtion">
				<div class="logo"> <a href="<?php echo esc_url(home_url('/')) ?>" class="logo1"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/backend/images/logo-themeoption.png') ?>" /></a> <a href="#" class="nav-button"><i class="icon-align-justify"></i></a> </div>
				<ul>
				    <?php echo automobile_allow_special_char($return[1], true); ?>
				</ul>
			    </nav>
			</div>

			<div class="col2">
			    <?php echo automobile_allow_special_char($return[0], true); ?>
			</div>
			<script>
			    jQuery(document).ready(function () {
				chosen_selectionbox();
			    });
			</script>
			<div class="clear"></div>
			<div class="footer">
			    <?php
			    $automobile_opt_array = array(
				'std' => automobile_var_theme_text_srt('automobile_var_save_msg'),
				'cust_id' => 'submit_btn',
				'cust_name' => 'submit_btn',
				'cust_type' => 'button',
				'extra_atr' => 'onclick="javascript:theme_option_save(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(get_template_directory_uri()) . '\');"',
				'classes' => 'bottom_btn_save',
			    );
			    $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);

			    $automobile_opt_array = array(
				'std' => 'theme_option_save',
				'cust_id' => 'action',
				'cust_name' => 'action',
				'classes' => '',
			    );
			    $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

			    $automobile_opt_array = array(
				'std' => automobile_var_theme_text_srt('automobile_var_theme_option_reset_msg'),
				'cust_id' => 'reset',
				'cust_name' => 'reset',
				'cust_type' => 'button',
				'extra_atr' => 'onclick="javascript:automobile_var_rest_all_options(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(get_template_directory_uri()) . '\');"',
				'classes' => 'bottom_btn_reset',
			    );
			    $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
			    ?>
			</div>
		    </form>
		</div>
	    </div>
	</div>
	<div class="clear"></div>
	<?php
    }

}

/**
 * @Background Count function
 * @return
 *
 */
if (!function_exists('automobile_var_bgcount')) {

    function automobile_var_bgcount($name, $count) {

	$pattern = array();
	for ($i = 0; $i <= $count; $i++) {
	    $pattern['option' . $i] = $name . $i;
	}
	return $pattern;
    }

}




/**
 * @Theme Options array
 * @return
 *
 */
if (!function_exists('automobile_var_options_array')) {

    add_action('init', 'automobile_var_options_array');

    function automobile_var_options_array() {

	global $automobile_var_settings, $automobile_var_options, $automobile_var_static_text;
	$banner_fields = array('banner_field_title' => array('Banner 1'), 'banner_field_style' => array('top_banner'), 'banner_field_type' => array('code'), 'banner_field_image' => array(''), 'banner_field_url' => array('#'), 'banner_field_url_target' => array('_self'), 'banner_adsense_code' => array(''), 'banner_field_code_no' => array('0'));
	$strings = new automobile_theme_all_strings;
	$strings->automobile_theme_strings();
	$strings->automobile_theme_option_strings();
	$on_off_option = array(
	    "show" => "on",
	    "hide" => "off",
	);
	$navigation_style = array(
	    "left" => "left",
	    "center" => "center",
	    "right" => "right"
	);

	$social_network = array(
	    'automobile_var_social_net_icon_path' => array('', '', '', '', ''),
	    'automobile_var_social_net_awesome' => array('icon-facebook9', 'icon-dribbble7', 'icon-twitter2', 'icon-behance2'),
	    'automobile_var_social_net_url' => array('https://www.facebook.com/', 'https://dribbble.com/', 'https://www.twitter.com/', 'https://www.behance.net/'),
	    'automobile_var_social_net_tooltip' => array('Facebook', 'Dribbble', 'Twitter', 'Behance'),
	    'automobile_var_social_icon_color' => array('#cccccc', '#cccccc', '#cccccc', '#cccccc')
	);

	$automobile_var_sidebar = array(
	    'sidebar' => array(
	    )
	);

	$automobile_var_footer_sidebar = array(
	    'automobile_var_footer_sidebar' => array(
		'' => automobile_var_theme_text_srt('automobile_var_please_select'),
	    )
	);

	$deafult_sub_header = array(
	    'breadcrumbs_sub_header' => automobile_var_theme_text_srt('automobile_var_theme_option_breadcrumbs_sub_header'),
	    'slider' => automobile_var_theme_text_srt('automobile_var_theme_option_revolution_slider'),
	    'no_header' => automobile_var_theme_text_srt('automobile_var_theme_option_no_sub_header'),
	);

	if (isset($automobile_var_options['automobile_var_sidebar']) && is_array($automobile_var_options['automobile_var_sidebar']) && sizeof($automobile_var_options['automobile_var_sidebar']) > 0) {
	    $automobile_var_sidebar = array('sidebar' => $automobile_var_options['automobile_var_sidebar']);
	}

	// google fonts array
	$automobile_var_fonts = automobile_var_googlefont_list();
	$automobile_var_fonts_atts = automobile_var_get_google_font_attribute();

	if (isset($automobile_var_options) and isset($automobile_var_options['automobile_var_footer_sidebar'])) {
	    if (is_array($automobile_var_options['automobile_var_footer_sidebar']) and count($automobile_var_options['automobile_var_footer_sidebar']) > 0) {
		$automobile_footer_sidebar = array('automobile_var_footer_sidebar' => $automobile_var_options['automobile_var_footer_sidebar']);
	    } else {
		$automobile_footer_sidebar = array('automobile_var_footer_sidebar' => array());
	    }
	} else {
	    $automobile_footer_sidebar = $automobile_var_footer_sidebar;
	}

	$footer_sidebar_list[''] = automobile_var_theme_text_srt('automobile_var_please_select');
	if (isset($automobile_footer_sidebar['automobile_var_footer_sidebar']) && is_array($automobile_footer_sidebar['automobile_var_footer_sidebar'])) {
	    foreach ($automobile_footer_sidebar['automobile_var_footer_sidebar'] as $footer_sidebar_var => $footer_sidebar_val) {
		$footer_sidebar_list[$footer_sidebar_var] = $footer_sidebar_val;
	    }
	}
	$automobile_footer_sidebar['automobile_var_footer_sidebar'] = $footer_sidebar_list;

	//Set the Options Array
	$automobile_var_settings = array();

	//general setting options
	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_general'),
	    "fontawesome" => 'icon-cog3',
	    "type" => "heading",
	    "options" => array(
		'tab-global-setting' => automobile_var_theme_text_srt('automobile_var_global'),
		'tab-header-options' => automobile_var_theme_text_srt('automobile_var_header'),
		'tab-sub-header-options' => automobile_var_theme_text_srt('automobile_var_sub_header'),
		'tab-footer-options' => automobile_var_theme_text_srt('automobile_var_footer'),
		'tab-social-setting' => automobile_var_theme_text_srt('automobile_var_social_icons'),
		'tab-social-network' => automobile_var_theme_text_srt('automobile_var_social_sharing'),
		'banner-fields' => automobile_var_theme_text_srt('automobile_var_ads_unit_settings'),
	    )
	);
	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_color'),
	    "fontawesome" => 'icon-magic',
	    "hint_text" => "",
	    "type" => "heading",
	    "options" => array(
		'tab-general-color' => automobile_var_theme_text_srt('automobile_var_general'),
		'tab-header-color' => automobile_var_theme_text_srt('automobile_var_header'),
		'tab-footer-color' => automobile_var_theme_text_srt('automobile_var_footer'),
		'tab-heading-color' => automobile_var_theme_text_srt('automobile_var_heading'),
	    )
	);
	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_theme_option_typo_font'),
	    "fontawesome" => 'icon-font',
	    "desc" => "",
	    "hint_text" => "",
	    "type" => "heading",
	    "options" => array(
		'tab-custom-font' => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font'),
		'tab-font-family' => automobile_var_theme_text_srt('automobile_var_theme_option_google_font'),
	    )
	);
	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar'),
	    "fontawesome" => 'icon-columns',
	    "id" => "tab-sidebar",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ''
	);

	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_sidebar'),
	    "fontawesome" => 'icon-columns',
	    "id" => "tab-footer-sidebar",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ''
	);

	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_theme_option_api_setting'),
	    "fontawesome" => 'icon-columns',
	    "id" => "tab-api-setting",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ''
	);

	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_global'),
	    "id" => "tab-global-setting",
	    "with_col" => false,
	    "type" => "sub-heading"
	);


	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_theme_option_layout'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_layout_type'),
	    "id" => "layout",
	    "std" => "full_width",
	    "options" => array(
		"boxed" => automobile_var_theme_text_srt('automobile_var_theme_option_box'),
		"full_width" => automobile_var_theme_text_srt('automobile_var_full_width'),
	    ),
	    "type" => "layout",
	);

	$automobile_var_settings[] = array(
	    "name" => "",
	    "id" => "horizontal_tab",
	    "class" => "horizontal_tab",
	    "type" => "horizontal_tab",
	    "std" => "",
	    "options" => array(
		automobile_var_theme_text_srt('automobile_var_background') => 'background_tab',
		automobile_var_theme_text_srt('automobile_var_bgcolor') => 'background_tab_color',
		automobile_var_theme_text_srt('automobile_var_theme_option_pattern') => 'pattern_tab',
		automobile_var_theme_text_srt('automobile_var_theme_option_custom_image') => 'custom_image_tab'
	    )
	);

	$automobile_var_layout = isset($automobile_var_options['automobile_var_layout']) ? $automobile_var_options['automobile_var_layout'] : '';
	$automobile_var_bg_image = isset($automobile_var_options['automobile_var_bg_image']) ? $automobile_var_options['automobile_var_bg_image'] : '';
	$automobile_var_bg_color = isset($automobile_var_options['automobile_var_bg_color']) ? $automobile_var_options['automobile_var_bg_color'] : '';
	$automobile_var_pattern_image = isset($automobile_var_options['automobile_var_pattern_image']) ? $automobile_var_options['automobile_var_pattern_image'] : '';
	$automobile_var_custom_bgimage = isset($automobile_var_options['automobile_var_custom_bgimage']) ? $automobile_var_options['automobile_var_custom_bgimage'] : '';
	if ($automobile_var_layout == 'full_width') {
	    $bg_image_display = "none";
	} else {
	    $bg_image_display = "block";
	}
	$bg_color_display = $pattern_image_display = $custom_bgimage_display = $custom_bgimage_position_display = "none";
	if ($automobile_var_custom_bgimage <> '') {
	    $custom_bgimage_display = "block";
	    $custom_bgimage_position_display = "block";
	    $bg_image_display = "none";
	} elseif ($automobile_var_pattern_image <> '' && $automobile_var_pattern_image <> 0) {
	    $pattern_image_display = "block";
	    $bg_image_display = "none";
	} elseif ($automobile_var_bg_color <> '') {
	    $bg_color_display = "block";
	    $bg_image_display = "none";
	}
	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_background_image'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_bg_image_hint'),
	    "id" => "bg_image",
	    "class" => "automobile_var_background_",
	    "path" => "background",
	    "tab" => "background_tab",
	    "std" => "bg1",
	    "type" => "layout_body",
	    "display" => $bg_image_display,
	    "options" => automobile_var_bgcount('bg', '10')
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_bg_pattern'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_bg_pattern_hint'),
	    "id" => "pattern_image",
	    "class" => "automobile_var_background_",
	    "path" => "patterns",
	    "tab" => "pattern_tab",
	    "std" => "bg7",
	    "type" => "layout_body",
	    "display" => $pattern_image_display,
	    "options" => automobile_var_bgcount('pattern', '27')
	);
	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_bgcolor'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_bgcolor_hint'),
	    "id" => "bg_color",
	    "std" => "#f3f3f3",
	    "tab" => "background_tab_color",
	    "display" => $bg_color_display,
	    "type" => "color"
	);

	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_image'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_layout_hint'),
	    "id" => "custom_bgimage",
	    "std" => "",
	    "tab" => "custom_image_tab",
	    "display" => $custom_bgimage_display,
	    "type" => "upload logo"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_bg_image_position'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_bg_image_position_hint'),
	    "id" => "bgimage_position",
	    "std" => automobile_var_theme_text_srt('automobile_var_repeat_center'),
	    "type" => "select",
	    "tab" => "custom_image_position",
	    "display" => $custom_bgimage_position_display,
	    'classes' => 'chosen-select',
	    "options" => array(
		"no-repeat center top" => automobile_var_theme_text_srt('automobile_var_no_repeat_center_top'),
		"repeat center top" => automobile_var_theme_text_srt('automobile_var_repeat_center_top'),
		"no-repeat center" => automobile_var_theme_text_srt('automobile_var_no_repeat_center'),
		"Repeat Center" => automobile_var_theme_text_srt('automobile_var_repeat_center'),
		"no-repeat left top" => automobile_var_theme_text_srt('automobile_var_no_repeat_left_top'),
		"repeat left top" => automobile_var_theme_text_srt('automobile_var_repeat_left_top'),
		"no-repeat fixed center" => automobile_var_theme_text_srt('automobile_var_no_repeat_fixed_center'),
		"no-repeat fixed center / cover" => automobile_var_theme_text_srt('automobile_var_no_repeat_fixed_center_cover'),
	    )
	);

	if ($automobile_var_layout == 'full_width') {
	    $favicon_display = "none";
	} else {
	    $favicon_display = "block";
	}

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_favicon'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_favicon_hint'),
	    "id" => "custom_favicon",
	    "std" => "",
	    "tab" => "custom_favicon",
	    "display" => $favicon_display,
	    "type" => "upload logo"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_responsive'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_responsive_hint'),
	    "id" => "responsive",
	    "std" => "on",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_excerpt'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_excerpt_hint'),
	    "id" => "excerpt_length",
	    "std" => "120",
	    "type" => "text"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_map_style'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_map_style_hint'),
	    "id" => "def_map_style",
	    "std" => "",
	    "type" => "select",
	    'classes' => 'chosen-select-no-single',
	    "options" => array(
		'map-box' => automobile_var_theme_text_srt('automobile_var_map_style_1'),
		'blue-water' => automobile_var_theme_text_srt('automobile_var_map_style_2'),
		'icy-blue' => automobile_var_theme_text_srt('automobile_var_map_style_3'),
		'bluish' => automobile_var_theme_text_srt('automobile_var_map_style_4'),
		'light-blue-water' => automobile_var_theme_text_srt('automobile_var_map_style_5'),
		'clad-me' => automobile_var_theme_text_srt('automobile_var_map_style_6'),
		'chilled' => automobile_var_theme_text_srt('automobile_var_map_style_7'),
		'two-tone' => automobile_var_theme_text_srt('automobile_var_map_style_8'),
		'light-and-dark' => automobile_var_theme_text_srt('automobile_var_map_style_9'),
		'ilustracao' => automobile_var_theme_text_srt('automobile_var_map_style_10'),
		'flat-pale' => automobile_var_theme_text_srt('automobile_var_map_style_11'),
		'title' => automobile_var_theme_text_srt('automobile_var_map_style_12'),
		'moret' => automobile_var_theme_text_srt('automobile_var_map_style_13'),
		'shunli_home' => 'shunli home',
		'new' => 'new',
		'pinky_wedding' => 'Pinky Wedding',
		'photobooth' => 'Photobooth',
		'mapa_blanco' => 'MapaBlanco',
		'mint' => 'mint',
		'zenmap' => 'Zenmap2.0',
		'paper' => 'Paper',
		'bentley' => 'Bentley',
	    )
	);


	// Header options start
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_header'),
	    "id" => "tab-header-options",
	    "type" => "sub-heading"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_default_header_style'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_default_header_style_hint'),
	    "id" => "header_style",
	    "std" => automobile_var_theme_text_srt('automobile_var_std_default'),
	    "type" => "select",
	    'classes' => 'chosen-select-no-single',
	    "options" => array(
		"default" => automobile_var_theme_text_srt('automobile_var_default'),
		"full_width" => automobile_var_theme_text_srt('automobile_var_full_width'),
	    )
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_transparent'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "header_transparent",
	    "std" => "",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_sticky'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "header_sticky",
	    "std" => "",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_transparent_inventory'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "header_inventory_page",
	    "std" => "",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_hint'),
	    "id" => "custom_logo",
	    "std" => "",
	    "type" => "upload logo"
	);
//        $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_modern'),
//            "desc" => "",
//            "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_hint'),
//            "id" => "custom_logo_modern",
//            "std" => "",
//            "type" => "upload logo"
//        );

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_height'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('header_view_hint'),
	    "id" => "header_view",
	    "std" => "67",
	    "type" => "range"
	);


	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_height'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_height_hint'),
	    "id" => "logo_height",
	    "min" => '0',
	    "max" => '100',
	    "std" => "67",
	    "type" => "range"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_width'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_width_hint'),
	    "id" => "logo_width",
	    "min" => '0',
	    "max" => '210',
	    "std" => "142",
	    "type" => "range"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_margin_top'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_margin_top_hint'),
	    "id" => "logo_margint",
	    "min" => '0',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_margin_bottom'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_margin_bottom_hint'),
	    "id" => "logo_marginb",
	    "min" => '-60',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_margin_right'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_margin_right_hint'),
	    "id" => "logo_marginr",
	    "min" => '0',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_logo_margin_left'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_logo_margin_left_hint'),
	    "id" => "logo_marginl",
	    "min" => '-20',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);

//        if (class_exists('WooCommerce')) {
//            $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_header'),
//                "id" => "tab-header-options",
//                "std" => automobile_var_theme_text_srt('automobile_var_wooCommerce'),
//                "type" => "section",
//                "options" => ""
//            );
//
//            $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_wooCommerce_cart_icon'),
//                "desc" => "",
//                "hint_text" => "",
//                "id" => "woocommerce_cart_icon",
//                "std" => "on",
//                "type" => "checkbox"
//			);
//        }
	// sub header element settings 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_sub_header'),
	    "id" => "tab-sub-header-options",
	    "type" => "sub-heading"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_default_sub_header'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_default_sub_header_hint'),
	    "id" => "default_header",
	    "std" => automobile_var_theme_text_srt('automobile_var_theme_option_breadcrumbs_sub_header'),
	    'classes' => 'chosen-select',
	    "type" => "default_header",
	    "options" => $deafult_sub_header
	);

	$automobile_var_settings[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_var_default_header",
	    "enable_val" => "no_header",
	    "extra_atts" => 'id="cs-no-headerfields"',
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_header_border_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "header_border_color",
	    "std" => "",
	    "type" => "color"
	);
	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);

	$automobile_var_settings[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_var_default_header",
	    "enable_val" => "slider",
	    "extra_atts" => 'id="cs-rev-slider-fields"',
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_revolution_slider'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_revolution_slider_hint'),
	    "id" => "custom_slider",
	    "std" => "",
	    "type" => "slider_code",
	    "options" => ''
	);
	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);

	$automobile_var_settings[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_var_default_header",
	    "enable_val" => "breadcrumbs_sub_header",
	    "extra_atts" => 'id="cs-breadcrumbs-fields"',
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_style'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "sub_header_style",
	    "std" => "simple",
	    'classes' => 'chosen-select',
	    "type" => "select",
	    "extra_att" => " onchange=automobile_var_subheader_style(this.value)",
	    "options" => array(
		'classic' => automobile_var_theme_text_srt('automobile_var_classic'),
		'with_bg' => automobile_var_theme_text_srt('automobile_var_with_background_image'),
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_padding_top'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_sub_header_padding_top_hint'),
	    "id" => "sh_paddingtop",
	    "min" => '0',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_padding_bottom'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_sub_header_padding_bottom_hint'),
	    "id" => "sh_paddingbottom",
	    "min" => '0',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_margin_top'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_sub_header_margin_top_hint'),
	    "id" => "sh_margintop",
	    "min" => '0',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_margin_bottom'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_margin_bottom_hint'),
	    "id" => "sh_marginbottom",
	    "min" => '0',
	    "max" => '200',
	    "std" => "0",
	    "type" => "range"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_page_title'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "page_title_switch",
	    "std" => "on",
	    "type" => "checkbox"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "sub_header_text_color",
	    "std" => "#ffffff",
	    "type" => "color"
	);
	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);
	$automobile_var_settings[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_var_sub_header_style",
	    "enable_val" => "classic",
	    "extra_atts" => 'id="cs-subheader-with-bc"',
	);
	$automobile_var_settings[] = array(
	    "name" => automobile_var_theme_text_srt('automobile_var_breadcrumbs'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "breadcrumbs_switch",
	    "std" => "on",
	    "type" => "checkbox"
	);
	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);

	//
	$automobile_var_settings[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_var_default_header",
	    "enable_val" => "breadcrumbs_sub_header",
	    "extra_atts" => 'id="cs-breadcrumbs_sub_header_fields"',
	);
	//
	$automobile_var_settings[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_var_sub_header_style",
	    "enable_val" => "with_bg",
	    "extra_atts" => 'id="cs-subheader-with-bg"',
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_sub_heading'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "sub_header_sub_hdng",
	    "std" => "",
	    "type" => "textarea"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_background_image'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_bg_image_hint'),
	    "id" => "sub_header_bg_img",
	    "std" => "",
	    "type" => "upload logo"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_parallax'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "sub_header_parallax",
	    "std" => "",
	    "type" => "checkbox",
	    "options" => $on_off_option
	);
	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);

	//
	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);
	//

	$automobile_var_settings[] = array(
	    "type" => "division",
	    "enable_id" => "automobile_var_default_header",
	    "enable_val" => "breadcrumbs_sub_header",
	    "extra_atts" => 'id="sub_header_bg_clr"',
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_bgcolor'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "sub_header_bg_clr",
	    "std" => "",
	    "type" => "color"
	);
	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);

	$automobile_var_settings[] = array(
	    "type" => "division_close",
	);

	// start footer options    

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_footer_options'),
	    "id" => "tab-footer-options",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_footer_section'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_footer_section_hint'),
	    "id" => "footer_switch",
	    "std" => "on",
	    "type" => "checkbox"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_footer_widgets'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_footer_widgets_hint'),
	    "id" => "footer_widget",
	    "std" => "on",
	    "type" => "checkbox"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_copy_write_section'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_copy_write_section_hint'),
	    "id" => "copy_write_section",
	    "std" => "on",
	    "type" => "checkbox");


	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_copyright_text'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_copyright_text_hint'),
	    "id" => "copy_right",
	    "std" => automobile_var_theme_text_srt('automobile_var_copyright_text_value'),
	    "type" => "textarea"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_contact_number'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_contact_number_hint'),
	    "id" => "footer_contact_no",
	    "std" => automobile_var_theme_text_srt('automobile_var_contact_number_value'),
	    "type" => "text"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_back_to_top'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_back_to_top_hint'),
	    "id" => "back_to_top",
	    "std" => "on",
	    "type" => "checkbox",
	);

	// End footer tab setting
	// general colors 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_general_color'),
	    "id" => "tab-general-color",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_color'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_color_hint'),
	    "id" => "theme_color",
	    "std" => "#ed413f",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_text_color'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_text_color_hint'),
	    "id" => "text_color",
	    "std" => "#555555",
	    "type" => "color"
	);

	// start top strip tab options
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_header_color'),
	    "id" => "tab-header-color",
	    "type" => "sub-heading"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_bgcolor'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_default_header_colors_hint'),
	    "id" => "header_bgcolor",
	    "std" => "#ffffff",
	    "type" => "color"
	);


	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_menu_link_color'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_menu_link_color_hint'),
	    "id" => "menu_color",
	    "std" => "#282828",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_menu_hover_color'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_menu_hover_color_hint'),
	    "id" => "menu_active_color",
	    "std" => "#ed413f ",
	    "type" => "color"
	);


	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_submenu_hover_bg_color'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_submenu_hover_bg_color_hint'),
	    "id" => "submenu_bgcolor",
	    "std" => "#ffffff",
	    "type" => "color",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_submenu_link_color'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_submenu_link_color_hint'),
	    "id" => "submenu_color",
	    "std" => "#282828",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_submenu_hover_color'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_submenu_hover_color_hint'),
	    "id" => "submenu_hover_color",
	    "std" => "#ed413f",
	    "type" => "color"
	);


	// footer colors 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_color'),
	    "id" => "tab-footer-color",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_bg_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "footerbg_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_text_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "footer_text_color",
	    "std" => "#999999",
	    "type" => "color"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_widget_bg_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "widget_bg_color",
	    "std" => "#999999",
	    "type" => "color"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_link_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "link_color",
	    "std" => "#999999",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_copyright_bg_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "copyright_bg_color",
	    "std" => "#999999",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_copyright_text_color'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "copyright_text_color",
	    "std" => "#999999",
	    "type" => "color"
	);

	// heading colors 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_heading_color'),
	    "id" => "tab-heading-color",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_heading_h1'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_h1_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_heading_h2'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_h2_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_heading_h3'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_h3_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_heading_h4'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_h4_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_heading_h5'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_h5_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_heading_h6'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_h6_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_section_title'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "section_title_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_post_title'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "post_title_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_page_title'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "page_title_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_widget_title'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "widget_title_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_footer_widget_title'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "footer_widget_title_color",
	    "std" => "#333333",
	    "type" => "color"
	);

	// start font family 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font'),
	    "id" => "tab-custom-font",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_woff'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_woff_hint'),
	    "id" => "custom_font_woff",
	    'class' => 'input-medium',
	    "std" => "",
	    "type" => "upload font"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_ttf'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_ttf_hint'),
	    "id" => "custom_font_ttf",
	    'class' => 'input-medium',
	    "std" => "",
	    "type" => "upload font"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_svg'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_svg_hint'),
	    "id" => "custom_font_svg",
	    'class' => 'input-medium',
	    "std" => "",
	    "type" => "upload font"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_eot'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_custom_font_eot_hint'),
	    "id" => "custom_font_eot",
	    'class' => 'input-medium',
	    "std" => "",
	    "type" => "upload font"
	);


	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_google_font'),
	    "id" => "tab-font-family",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_content_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_content_font_discription'),
	    "id" => "content_font",
	    "std" => "Raleway",
	    "type" => "gfont_select",
	    'classes' => 'chosen-select',
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "content_font_att",
	    "std" => "500",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "content_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "content_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "content_textr",
	    "std" => "none",
	    "type" => "select_ftext",
	    'classes' => 'chosen-select',
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "content_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_main_menu_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_main_menu_font_hint'),
	    "id" => "mainmenu_font",
	    "std" => "Raleway",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "mainmenu_font_att",
	    "std" => "700",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "mainmenu_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "14",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "mainmenu_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "mainmenu_textr",
	    "std" => "none",
	    "type" => "select_ftext",
	    'classes' => 'chosen-select',
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "mainmenu_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading1_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading_font_hint'),
	    "id" => "heading1_font",
	    "std" => "Montserrat",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "heading1_font_att",
	    "std" => "700",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_1_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "36",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_1_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_1_textr",
	    "std" => "none",
	    "type" => "select_ftext",
	    'classes' => 'chosen-select',
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_1_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading2_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading_font_hint'),
	    "id" => "heading2_font",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "heading2_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_2_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "30",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_2_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_2_textr",
	    "std" => "none",
	    "type" => "select_ftext",
	    'classes' => 'chosen-select',
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_2_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading3_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading_font_hint'),
	    "id" => "heading3_font",
	    'classes' => 'chosen-select',
	    "std" => "",
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "heading3_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_3_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "26",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_3_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_3_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_3_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading4_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading_font_hint'),
	    "id" => "heading4_font",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "heading4_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_4_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "20",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_4_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_4_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_4_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading5_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading_font_hint'),
	    "id" => "heading5_font",
	    'classes' => 'chosen-select',
	    "std" => "",
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "heading5_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_5_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "18",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_5_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_5_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_5_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading6_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_Heading_font_hint'),
	    "id" => "heading6_font",
	    'classes' => 'chosen-select',
	    "std" => "",
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "heading6_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_6_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "16",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_6_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_6_textr",
	    'classes' => 'chosen-select',
	    "std" => "none",
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "heading_6_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_section_title_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_section_title_font_hint'),
	    "id" => "section_title_font",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "section_title_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "section_title_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "20",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "section_title_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "section_title_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "section_title_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_page_title_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_page_title_hint'),
	    "id" => "page_title_font",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "page_title_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "page_title_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "20",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "page_title_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "page_title_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "page_title_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_post_title_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_post_title_hint'),
	    "id" => "post_title_font",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "post_title_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "post_title_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "20",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "post_title_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "post_title_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "post_title_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar_widget_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar_widget_font_hint'),
	    "id" => "widget_heading_font",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "widget_heading_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "widget_heading_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "18",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "widget_heading_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "widget_heading_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "widget_heading_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_widget_font'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_widget_font_hint'),
	    "id" => "ft_widget_heading_font",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_select",
	    "options" => $automobile_var_fonts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_font_attribute_hint'),
	    "id" => "ft_widget_heading_font_att",
	    "std" => "",
	    'classes' => 'chosen-select',
	    "type" => "gfont_att_select",
	    "options" => $automobile_var_fonts_atts
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_size'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "ft_widget_heading_size",
	    "min" => '6',
	    "max" => '50',
	    "std" => "18",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_line_height'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "ft_widget_heading_lh",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_text_transform'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "ft_widget_heading_textr",
	    "std" => "none",
	    'classes' => 'chosen-select',
	    "type" => "select_ftext",
	    "options" => array(
		'none' => automobile_var_theme_text_srt('automobile_var_none'),
		'capitalize' => automobile_var_theme_text_srt('automobile_var_capitalize'),
		'uppercase' => automobile_var_theme_text_srt('automobile_var_uppercase'),
		'lowercase' => automobile_var_theme_text_srt('automobile_var_lowercase'),
		'initial' => automobile_var_theme_text_srt('automobile_var_initial'),
		'inherit' => automobile_var_theme_text_srt('automobile_var_inherit')
	    ),
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_letter_spacing'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "ft_widget_heading_spc",
	    "min" => '6',
	    "max" => '50',
	    "std" => "13",
	    "type" => "range_font",
	);
	/* social icons setting */
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_social_icons'),
	    "id" => "tab-social-setting",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_social_network'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "social_network",
	    "std" => "",
	    "type" => "networks",
	    "options" => $social_network
	);

	// social Network setting 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_social_sharing'),
	    "id" => "tab-social-network",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_fb'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "facebook_share",
	    "std" => "on",
	    "type" => "checkbox");

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_twitter'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "twitter_share",
	    "std" => "on",
	    "type" => "checkbox");

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_g_plus'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "google_plus_share",
	    "std" => "off",
	    "type" => "checkbox");
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_tumblr'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "tumblr_share",
	    "std" => "on",
	    "type" => "checkbox");

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_dribbble'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "dribbble_share",
	    "std" => "on",
	    "type" => "checkbox");



	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_stumbleupon'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "stumbleupon_share",
	    "std" => "on",
	    "type" => "checkbox");



	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_share_more'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "share_share",
	    "std" => "on",
	    "type" => "checkbox");


	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_ads_unit_settings'),
	    "id" => "banner-fields",
	    "type" => "sub-heading"
	);
	///Ads Unit 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_ads_unit_settings'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "cs_banner_fields",
	    "std" => "",
	    "type" => "banner_fields",
	    "options" => $banner_fields
	);


	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar'),
	    "id" => "tab-sidebar",
	    "type" => "sub-heading"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar_hint'),
	    "id" => "sidebar",
	    "std" => $automobile_var_sidebar,
	    "type" => "sidebar",
	    "options" => $automobile_var_sidebar
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_default_pages'),
	    "id" => "default_pages",
	    "std" => automobile_var_theme_text_srt('automobile_var_default_pages_sidebar'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_default_pages_layout'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_default_pages_layout_hint'),
	    "id" => "default_page_layout",
	    "std" => "sidebar_right",
	    "type" => "layout",
	    "options" => array(
		"sidebar_left" => automobile_var_theme_text_srt('automobile_var_sidebar_left'),
		"sidebar_right" => automobile_var_theme_text_srt('automobile_var_sidebar_right'),
		"no_sidebar" => automobile_var_theme_text_srt('automobile_var_full_width'),
	    )
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_default_pages_sidebar_hint'),
	    "id" => "default_layout_sidebar",
	    "std" => "",
	    "type" => "select_sidebar",
	    "options" => $automobile_var_sidebar
	);


	if (class_exists('WooCommerce')) {

	    $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_wc_archive_sidebar'),
		"id" => "woo_archive_pages",
		"std" => automobile_var_theme_text_srt('automobile_var_theme_option_wc_archive_sidebar'),
		"type" => "section",
		"options" => ""
	    );
	    $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_layout'),
		"desc" => "",
		"hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_wc_archive_sidebar_discription'),
		"id" => "woo_archive_layout",
		"std" => "sidebar_right",
		"type" => "layout",
		"options" => array(
		    "sidebar_left" => automobile_var_theme_text_srt('automobile_var_sidebar_left'),
		    "sidebar_right" => automobile_var_theme_text_srt('automobile_var_sidebar_right'),
		    "no_sidebar" => automobile_var_theme_text_srt('automobile_var_full_width'),
		)
	    );

	    $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar'),
		"desc" => "",
		"hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_wc_archive_sidebar_hint'),
		"id" => "woo_archive_sidebar",
		"std" => "",
		"type" => "select_sidebar",
		"options" => $automobile_var_sidebar
	    );
	}

	// Footer sidebar tab 
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_sidebar'),
	    "id" => "tab-footer-sidebar",
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_footer_sidebar'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_sidebar_hint'),
	    "id" => "automobile_footer_sidebar",
	    "std" => $automobile_var_footer_sidebar,
	    "type" => "automobile_var_footer_sidebar",
	    "options" => $automobile_var_footer_sidebar
	);



	//Mailchimp List
	$mail_chimp_list[] = '';
	if (isset($automobile_var_options['automobile_var_mailchimp_key'])) {
	    $mailchimp_option = $automobile_var_options['automobile_var_mailchimp_key'];
	    if ($mailchimp_option <> '') {

		if (function_exists('automobile_mailchimp_list')) {
		    $mc_list = automobile_mailchimp_list($mailchimp_option);

		    if (is_array($mc_list) && isset($mc_list['data'])) {
			foreach ($mc_list['data'] as $list) {
			    $mail_chimp_list[$list['id']] = $list['name'];
			}
		    }
		}
	    }
	}
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_api_setting'),
	    "id" => "tab-api-setting",
	    "type" => "sub-heading"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_mailchimp_key'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_mailchimp_key_hint'),
	    "id" => "mailchimp_key",
	    "std" => "",
	    "type" => "text");
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_mailchimp_list'),
	    "desc" => "",
	    "hint_text" => "",
	    "id" => "mailchimp_list",
	    "std" => "on",
	    "type" => "mailchimp",
	    "classes" => 'chosen-select',
	    "options" => $mail_chimp_list
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_flickr_api_setting'),
	    "id" => "flickr_api_setting",
	    "std" => automobile_var_theme_text_srt('automobile_var_theme_option_flickr_api_setting'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_flickr_key'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_flickr_key_hint'),
	    "id" => "flickr_key",
	    "std" => "",
	    "type" => "text");
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_api_setting'),
	    "id" => "Twitter",
	    "std" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_api_setting'),
	    "type" => "section",
	    "options" => ""
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_consumer_key'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_consumer_key_hint'),
	    "id" => "consumer_key",
	    "std" => "",
	    "type" => "text");
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_cache_time_limit'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_cache_time_limit_hint'),
	    "id" => "cache_limit_time",
	    "std" => "",
	    "type" => "text");

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_num'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_num_hint'),
	    "id" => "tweet_num_post",
	    "std" => "",
	    "type" => "text");

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate_hint'),
	    "id" => "twitter_datetime_formate",
	    "std" => "",
	    'classes' => 'chosen-select-no-single',
	    "type" => "select",
	    "options" => array(
		'default' => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate_1'),
		'eng_suff' => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate_2'),
		'ddmm' => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate_3'),
		'ddmmyy' => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate_4'),
		'full_date' => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate_5'),
		'time_since' => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_date_time_formate_6'),
	    )
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_consumer_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_consumer_secret_hint'),
	    "id" => "consumer_secret",
	    "std" => "",
	    "type" => "text");
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_access_token'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_access_token_hint'),
	    "id" => "access_token",
	    "std" => "",
	    "type" => "text");
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_access_token_secret'),
	    "desc" => "",
	    "hint_text" => automobile_var_theme_text_srt('automobile_var_theme_option_twitter_access_token_secret_hint'),
	    "id" => "access_token_secret",
	    "std" => "",
	    "type" => "text");

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_google_api_setting'),
	    "id" => "google_api",
	    "std" => automobile_var_theme_text_srt('automobile_var_theme_option_google_api_setting'),
	    "type" => "section",
	    "options" => ""
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_google_api_key'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "google_api_key",
	    "std" => "",
	    "type" => "text"
	);
	/*
	 * End Api Setting
	 */

	/*  Automatic Updater */
	$automobile_var_settings[] = array("name" => esc_html__("Auto Update", 'automobile'),
	    "fontawesome" => 'icon-tasks',
	    "id" => "tab-auto-updater",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ""
	);
	$automobile_var_settings[] = array("name" => esc_html__("Auto Update Theme", 'automobile'),
	    "id" => "tab-auto-updater",
	    "with_col" => true,
	    "type" => "sub-heading"
	);
	$automobile_var_settings[] = array("name" => esc_html__("Automatic Upgrade", 'automobile'),
	    "desc" => "",
	    "hint_text" => esc_html__("", 'automobile'),
	    "id" => "cs_backup_options",
	    "std" => "",
	    "type" => "automatic_upgrade"
	);
	$automobile_var_settings[] = array("name" => esc_html__("Marketplace Username", 'automobile'),
	    "desc" => "",
	    "hint_text" => esc_html__("Enter your Marketplace Username.", 'automobile'),
	    "id" => "cs_marketplace_username",
	    "std" => "",
	    "type" => "text");
	$automobile_var_settings[] = array("name" => esc_html__("Secret API Key", 'automobile'),
	    "desc" => "",
	    "hint_text" => esc_html__("Enter your Secret API key.", 'automobile'),
	    "id" => "cs_secret_api_key",
	    "std" => "",
	    "type" => "text");
	$automobile_var_settings[] = array("name" => esc_html__("Skip Theme Backup", 'automobile'),
	    "desc" => "",
	    "hint_text" => esc_html__("Do you want to skip theme backup?", 'automobile'),
	    "id" => "cs_skip_theme_backup",
	    "std" => "on",
	    "type" => "checkbox",
	);
	$automobile_var_settings[] = array("col_heading" => esc_html__("Attention User Account Information!", 'automobile'),
	    "type" => "col-right-text",
	    "help_text" => esc_html__("To obtain your API Key, visit your \"My Settings\" page on any of the Envato 
							Marketplaces. Once a valid connection has been made any changes to the API 
							key below for this username will not effect the results for 5 minutes 
							because they're cached in the database. If you have already made an API 
							connection and just purchase a theme and it's not showing up, wait five 
							minutes and refresh the page. If the theme is still not showing up, it's 
							possible the author has not made it available for auto install yet.", 'automobile')
	);

	/* Import & Export */
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_import_export'),
	    "fontawesome" => 'icon-database',
	    "id" => "tab-import-export-options",
	    "std" => "",
	    "type" => "main-heading",
	    "options" => ""
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_import_export'),
	    "id" => "tab-import-export-options",
	    "type" => "sub-heading"
	);

	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_backup_option'),
	    "std" => automobile_var_theme_text_srt('automobile_var_theme_backup_option'),
	    "id" => "theme-bakups-options",
	    "type" => "section"
	);
	$automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_theme_option_backup'),
	    "desc" => "",
	    "hint_text" => '',
	    "id" => "automobile_backup_options",
	    "std" => "",
	    "type" => "generate_backup"
	);

	if (class_exists('automobile_var_widget_data')) {

	    $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_widgets_backup_options'),
		"std" => automobile_var_theme_text_srt('automobile_var_widgets_backup_options'),
		"id" => "widgets-bakups-options",
		"type" => "section"
	    );

	    $automobile_var_settings[] = array("name" => automobile_var_theme_text_srt('automobile_var_widgets_backup'),
		"desc" => "",
		"hint_text" => '',
		"id" => "automobile_widgets_backup",
		"std" => "",
		"type" => "widgets_backup"
	    );
	}

	$automobile_var_settings[] = array(
	    "id" => "theme_option_save_flag",
	    "std" => md5(uniqid(rand(), true)),
	    "type" => "hidden_field"
	);
    }

}