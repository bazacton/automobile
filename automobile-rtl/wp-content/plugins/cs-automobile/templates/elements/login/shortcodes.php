<?php
/*
 *
 * Start Function  for shortcode of register for user
 *
 */

if (!function_exists('automobile_register_shortcode')) {

    function automobile_register_shortcode($atts, $content = "") {
	global $wpdb, $automobile_var_plugin_options, $automobile_form_fields_frontend, $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	automobile_socialconnect_scripts(); // social login script
	$defaults = array('column_size' => '1/1', 'automobile_var_register_title' => '', 'register_title' => '', 'register_text' => '', 'register_role' => 'automobile_dealer', 'automobile_register_class' => '', 'automobile_register_animation' => '');
	extract(shortcode_atts($defaults, $atts));
	$automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
	$automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
	$automobile_terms_policy_switch = isset($automobile_var_plugin_options['automobile_terms_policy_switch']) && !empty($automobile_var_plugin_options['automobile_terms_policy_switch']) ? $automobile_var_plugin_options['automobile_terms_policy_switch'] : '';
	$automobile_cand_term_page = isset($automobile_var_plugin_options['dealer_term_page']) && !empty($automobile_var_plugin_options['dealer_term_page']) ? $automobile_var_plugin_options['dealer_term_page'] : '';
	$automobile_privacy_page = isset($automobile_var_plugin_options['privacy_page']) && !empty($automobile_var_plugin_options['privacy_page']) ? $automobile_var_plugin_options['privacy_page'] : '';
	$privacy_link = '';
	$term_dealer_link = '';
	if (!empty($automobile_cand_term_page)) {
	    $term_dealer_link = get_the_permalink($automobile_cand_term_page);
	}
	if (!empty($automobile_privacy_page)) {
	    $privacy_link = get_the_permalink($automobile_privacy_page);
	}
	$automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';

	if ($automobile_sitekey <> '' and $automobile_secretkey <> '' and ! is_user_logged_in()) {
	    automobile_google_recaptcha_scripts();
	    ?>
	    <script>

	        var recaptcha1;
	        var recaptcha2;
	        var recaptcha3;
	        var recaptcha4;
	        var automobile_multicap = function () {
	    	//Render the recaptcha1 on the element with ID "recaptcha1"
	    	recaptcha1 = grecaptcha.render('recaptcha1', {
	    	    'sitekey': '<?php echo ($automobile_sitekey); ?>', //Replace this with your Site key
	    	    'theme': 'light'
	    	});
	    	//Render the recaptcha2 on the element with ID "recaptcha2"
	    	recaptcha2 = grecaptcha.render('recaptcha2', {
	    	    'sitekey': '<?php echo ($automobile_sitekey); ?>', //Replace this with your Site key
	    	    'theme': 'light'
	    	});
	        };
	    </script>
	    <?php
	}

	$output = '';
	$registraion_div_rand_id = rand(5, 99999);
	$rand_id = rand(5, 99999);
	$rand_value = rand(0, 9999999);
	$role = $register_role;
	$output .= '<div class="cs-form-dealer">';
	if (is_user_logged_in()) {
	    $output .= '<div class="alert alert-warning">' . esc_html(automobile_var_plugin_text_srt('automobile_var_you_have_already_logged_in')) . '<a data-dismiss="alert" class="close" href="#">&times;</a></div>';
	}
	if (is_user_logged_in()) {

	    $output .= '<script>'
		    . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_id) . ', input#user_pass' . absint($rand_id) . '", function (e) {
                    if (e.which == "13") {
                        show_alert_msg("' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '");
                        return false;
                    }
                });'
		    . '</script>';
	} else {
	    $output .= '<script>'
		    . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_id) . ', input#user_pass' . absint($rand_id) . '", function (e) {
                    if (e.which == "13") {
                        automobile_user_authentication("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_id) . '");
                        return false;
                    }
                });'
		    . '</script>';
	}
	$output .= '<div class="user-box login-from login-form-id-' . absint($rand_id) . '" id="login-form-id-' . $rand_id . '" style="display:none;">
                        <div class="scetion-title">
                            <h2>' . esc_html(automobile_var_plugin_text_srt('automobile_var_user_login')) . '</h2>
                        </div>';
	//Form Start

	$output .= '<form method="post" class="wp-user-form webkit" id="ControlForm_' . $rand_id . '">';
	//Element Row Class Start
	$output .= '<span class="status status-message" style="display:none"></span>';
	$output .= ' <div class="row">';
	//Element Start
	$output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	$output .= '<div class="cs-dealer-field">';
	$output .= '<label for="user_login_' . absint($rand_id) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_username')) . '</strong> <i class="icon-user-plus2"></i>';

	$automobile_opt_array = array(
	    'id' => '',
	    'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_username')),
	    'cust_id' => 'user_login_' . $rand_id,
	    'cust_name' => 'user_login',
	    'classes' => '',
	    'extra_atr' => ' size="20" tabindex="11" onfocus="if(this.value ==\'Username\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'Username\'; }"',
	    'return' => true,
	);
	$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
	$output .= '</label></div>';
	$output .= '</div>';
	//Element End
	//Element Password Start
	$output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	$output .= '<div class="cs-dealer-field">';
	$output .= '<label for="user_pass' . absint($rand_id) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_password')) . '</strong> <i class="icon-unlock40"></i>';
	$automobile_opt_array = array(
	    'id' => '',
	    'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_password')),
	    'cust_id' => 'user_pass' . $rand_id,
	    'cust_name' => 'user_pass',
	    'cust_type' => 'password',
	    'classes' => '',
	    'extra_atr' => ' size="20" tabindex="12" onfocus="if(this.value ==\'Username\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'Username\'; }"',
	    'return' => true,
	);
	$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
	$output .= '</label>';
	$output .= '</div>';
	$output .= '</div>';
	//Element End
	//Element Btn Start

	$output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	$output .= '<div class="cs-dealer-field-btn">';

	if (is_user_logged_in()) {


	    $automobile_opt_array = array(
		'id' => '',
		'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_log_in')),
		'cust_id' => 'user-submit',
		'cust_name' => 'user-submit',
		'cust_type' => 'button',
		'extra_atr' => ' onclick="javascript:show_alert_msg(\'' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '\')"',
		'classes' => 'cs-color csborder-color',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
	} else {
	    $automobile_opt_array = array(
		'id' => '',
		'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_log_in')),
		'cust_id' => 'user-submit',
		'cust_name' => 'user-submit',
		'cust_type' => 'button',
		'extra_atr' => ' onclick="javascript:automobile_user_authentication(\'' . admin_url("admin-ajax.php") . '\',\'' . $rand_id . '\')"',
		'classes' => 'cs-color csborder-color',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

	    $automobile_opt_array = array(
		'std' => get_permalink(),
		'id' => 'redirect_to',
		'cust_name' => 'redirect_to',
		'cust_type' => 'hidden',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

	    $automobile_opt_array = array(
		'std' => '1',
		'id' => 'user_cookie',
		'cust_name' => 'user-cookie',
		'cust_type' => 'hidden',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

	    $automobile_opt_array = array(
		'id' => '',
		'std' => 'ajax_login',
		'cust_name' => 'action',
		'cust_type' => 'hidden',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

	    $automobile_opt_array = array(
		'std' => 'login',
		'id' => 'login',
		'cust_name' => 'login',
		'cust_type' => 'hidden',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

	    $output .= '<a class="user-forgot-password-page" href="#">' . esc_html(automobile_var_plugin_text_srt('automobile_var_forgot_password')) . '</a>';
	}
	$output .= '</div>';
	$output .= '</div>';
	//Element Btn End
	//Element Start
	$output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';

	$output .= '<i class="icon-user-add"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_new_to_us')) . '  <a class="register-link" href="#">' . esc_html(automobile_var_plugin_text_srt('automobile_var_register_here')) . '</a>';


	$output .= '</div>';
	//Element End
	$output .= '</div>';
	//Element Row Class Start
	$output .= '</form>';
	//Form End

	$output .= '</div>';


	$output .= '<div class="forgot-box login-from " style="display:none;" id="login-form-id-' . $rand_value . '">';
	ob_start();
	$output .= do_shortcode('[automobile_forgot_password]');
	$output .= ob_get_clean();
	$output .= '</div>';
	$output .= '<div class="cs-form-dealer dealer-signup" id="dealer' . $rand_value . '">';
	if (isset($automobile_var_register_title) && $automobile_var_register_title != '') {
	    $output .= '<div class="cs-element-title"><h2>' . esc_html($automobile_var_register_title) . '</h2></div>';
	}
	$output .= '<div id="result_' . $rand_value . '" class="status-message"><p class="status"></p></div>';
	$isRegistrationOn = get_option('users_can_register');

	if ($isRegistrationOn) {
	    // registration page element

	    $output .= '<script>'
		    . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_value) . ', input#user_email' . absint($rand_value) . ', input#dealer_type' . absint($rand_value) . ', input#phone_no' . absint($rand_value) . '", function (e) {
                    if (e.which == "13") {
                        automobile_registration_validation("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_value) . '");
                        return false;
                    }
                });'
		    . '</script>';

	    // popup dealer  form
	    $output .= '<form method="post" class="wp-user-form demo_test" id="wp_signup_form_' . $rand_value . '" enctype="multipart/form-data">';
	    $output .= '<div class="row">';

	    //  popup dealer registration form Atrributes Start
	    //Element Start
	    $output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	    $output .= '<div class="cs-dealer-field"><label for="user_login' . absint($rand_value) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_desired_username')) . '</strong> <i class="icon-user-plus2"></i>';

	    $automobile_opt_array = array(
		'id' => '',
		'std' => '',
		'cust_id' => 'user_login' . absint($rand_value),
		'cust_name' => 'user_login' . absint($rand_value),
		'extra_atr' => 'size="20" tabindex="101"  placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_desired_username')) . '"',
		'classes' => '',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

	    $output .= '</label></div>';
	    $output .= '</div>';
	    //Element End
	    //Element Start
	    $output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	    $output .= '<div class="cs-dealer-field"><label for="user_email' . absint($rand_value) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '</strong> <i class="icon-envelope"></i>';

	    $automobile_opt_array = array(
		'id' => 'user_email' . absint($rand_value),
		'std' => '',
		'cust_id' => 'user_email' . absint($rand_value),
		'cust_name' => 'user_email' . absint($rand_value),
		'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_enter_email')) . '"',
		'classes' => '',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
	    $output .= '</label></div>';
	    $output .= '</div>';
	    //Element End
	    //Element Start 
	    $output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	    $output .= '<div class="cs-dealer-field">';
	    $output .= '<div class="select-holder">';
	    $output .= '<label for="automobile_dealer_type' . absint($rand_value) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_dealer_type')) . '</strong> <i class="icon-v-card"></i>';
	    $output .= get_dealer_type_dropdown('automobile_dealer_type' . absint($rand_value), 'automobile_dealer_type' . absint($rand_value), '', 'chosen-select');
	    $output .= '</label>';
	    $output .= '</div>';
	    $output .= '</div>';
	    $output .= '</div>';
	    //Element End
	    //Element Start

	    $output .= $automobile_form_fields_frontend->automobile_form_hidden_render(
		    array('name' => 'user_role_type',
			'id' => 'user_role_type' . absint($rand_value),
			'classes' => '',
			'std' => 'automobile_dealer',
			'description' => '',
			'return' => true,
			'hint' => '',
			'icon' => 'icon-user9'
		    )
	    );


	    //Element End
	    //Element Start
	    $output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	    $output .= '<div class="cs-dealer-field"><label for="phone_no' . absint($rand_value) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '</strong> <i class="icon-phone"></i>';
	    $automobile_opt_array = array(
		'id' => '',
		'std' => '',
		'cust_id' => 'phone_no' . absint($rand_value),
		'cust_name' => 'phone_no' . absint($rand_value),
		'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone_hint')) . '"',
		'classes' => 'register_phone',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);


	    $output .= '</label></div></div>';
		$output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
		//allow in search
			$output .= '<div class="cs-dealer-field"><label for="allow_search"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_allow_in_search')) . '</strong>';
			$on_off_option = array(
			    "show" => "yes",
			    "hide" => "off",
			);
			$automobile_opt_array = array(
			    'id' => '',
			    'std' => '',
			    'cust_id' => 'allow_search',
			    'cust_name' => 'allow_search',
			    'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone_hint')) . '"',
			    'classes' => 'chosen-select-no-single',
			    'options' => $on_off_option,
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
	    $output .= '</div>';
					if ($automobile_terms_policy_switch == 'on') {
			    $output .= '<div class="terms"><label><input type="checkbox" name="automobile_check_terms" id="automobile_check_terms' . $rand_id . '">'
				    . ' ' . esc_html__("By registering you confirm that you accept the ", 'cs-automobile');
			    $output .= '<a target="_blank" href="' . $term_dealer_link . '">' . esc_html__('Terms & Conditions ', 'cs-automobile') . '</a>';
			    $output .= ' and ';
			    $output .= '<a target="_blank" href="' . $privacy_link . '"> ' . esc_html__('Privacy Policy', 'cs-automobile') . ' </a>';
			    $output .= '</label></div>';
			}
	    //Element End
	    // popup dealer registration form Atrributes End
	    if ($automobile_captcha_switch == 'on' && $automobile_sitekey != '' && $automobile_secretkey != '' && (!is_user_logged_in())) {

		//Element Start
		$output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
		$output .= ' <div class="cs-dealer-field">';
		$output .= '<div class="recaptcha-reload" id="recaptcha1_div">';
		$output .= automobile_captcha('recaptcha1');
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		//Element End
	    }
	    // popup dealer registration form Button
	    //Element Start
	    $output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	    $output .= '<div class="cs-dealer-field-btn">';
	    ob_start();
	    $output .= do_action('register_form');
	    $output .= ob_get_clean();
	    $automobile_rand_id = rand(122, 1545464897);

	    $automobile_opt_array = array(
		'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_create_account')),
		'cust_id' => 'submitbtn' . $rand_value,
		'cust_name' => 'user-submit',
		'cust_type' => 'button',
		'classes' => 'cs-color csborder-color',
		'extra_atr' => ' tabindex="103" onclick="javascript:automobile_registration_validation(\'' . admin_url("admin-ajax.php") . '\',\'' . absint($rand_value) . '\')"',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
	    $automobile_opt_array = array(
		'id' => '',
		'std' => $role,
		'cust_id' => 'sign_in-role',
		'cust_name' => 'role',
		'cust_type' => 'hidden',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

	    $automobile_opt_array = array(
		'id' => '',
		'std' => 'automobile_registration_validation',
		'cust_name' => 'action',
		'cust_type' => 'hidden',
		'return' => true,
	    );
	    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);


	    $output .= '</div>';
	    $output .= '</div>';
	    //Element End
	    //Element Start
	    $output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	    $output .= '<i class="icon-user-add"></i> ' . esc_html(automobile_var_plugin_text_srt('automobile_var_already_have_account')) . ' 
                                <a href="#" class="login-link-page">' . esc_html(automobile_var_plugin_text_srt('automobile_var_login_now')) . '</a>
                            
                ';
	    $output .= '</div>';
	    //Element End
	    // popup dealer registration form Button End
	    $output .= '</div></form>';
	    // popup dealer registration form End
	    // registration page element
	    $output .= '<div class="register_content">' . do_shortcode($content . $register_text) . '</div>';
	} else {
	    $output .= '<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">';
	    $output .= '<div class="cs-dealer-field">';
	    $output .= '<div class="cs-user-register">
                        <div class="cs-section-title">
                            <h2>' . esc_html(automobile_var_plugin_text_srt('automobile_var_register_here')) . '</h2>
                        </div>
                        <p>' . esc_html(automobile_var_plugin_text_srt('automobile_var_user_registration')) . '</p>';
	    $output .= '</div>';
	    $output .= '</div>';
	    $output .= '</div>';
	}
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	ob_start();
	$output .= do_action('login_form');
	$output .= ob_get_clean();
	return $output;
    }

    add_shortcode('automobile_register', 'automobile_register_shortcode');
}
/*
 *
 * Start Function  for shortcode of user login
 * 
 *
 */

if (!function_exists('automobile_user_login_shortcode')) {

    function automobile_user_login_shortcode($atts, $content = "") {
	global $wpdb, $automobile_var_plugin_options, $automobile_form_fields_frontend, $automobile_form_fields, $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	$defaults = array('column_size' => '1/1', 'register_title' => '', 'btns_only' => false, 'without_btns' => false, 'register_text' => '', 'register_role' => 'automobile_dealer', 'automobile_type' => '', 'automobile_login_txt' => '', 'login_btn_class' => '');
	extract(shortcode_atts($defaults, $atts));
	automobile_socialconnect_scripts(); // social login script
	$user_disable_text = esc_html(automobile_var_plugin_text_srt('automobile_var_user_registration'));
	$automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
	$automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
	$automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
	$automobile_terms_policy_switch = isset($automobile_var_plugin_options['automobile_terms_policy_switch']) && !empty($automobile_var_plugin_options['automobile_terms_policy_switch']) ? $automobile_var_plugin_options['automobile_terms_policy_switch'] : '';
	$automobile_cand_term_page = isset($automobile_var_plugin_options['dealer_term_page']) && !empty($automobile_var_plugin_options['dealer_term_page']) ? $automobile_var_plugin_options['dealer_term_page'] : '';
	$automobile_privacy_page = isset($automobile_var_plugin_options['privacy_page']) && !empty($automobile_var_plugin_options['privacy_page']) ? $automobile_var_plugin_options['privacy_page'] : '';
	$privacy_link = '';
	$term_dealer_link = '';
	if (!empty($automobile_cand_term_page)) {
	    $term_dealer_link = get_the_permalink($automobile_cand_term_page);
	}
	if (!empty($automobile_privacy_page)) {
	    $privacy_link = get_the_permalink($automobile_privacy_page);
	}
	$rand_id = rand(13243, 99999);

	if ($automobile_sitekey <> '' and $automobile_secretkey <> '' and ! is_user_logged_in() && $btns_only == false) {
	    automobile_google_recaptcha_scripts();
	    ?>
	    <script>
	        var recaptcha4;
	        var automobile_multicap = function () {
	    	//Render the recaptcha2 on the element with ID "recaptcha2"
	    	recaptcha4 = grecaptcha.render('recaptcha4', {
	    	    'sitekey': '<?php echo ($automobile_sitekey); ?>', //Replace this with your Site key
	    	    'theme': 'light'
	    	});
	        };

	    </script>
	    <?php
	}
	$output = '';
	if (is_user_logged_in()) {
	    $output .= automobile_profiletop_menu();
	} else {
	    $role = $register_role;

	    $output .= '<div class="cs-login">';
	    $isRegistrationOn = get_option('users_can_register');

	    if ($isRegistrationOn) {

		if ($without_btns == false) {
		    $output .= '<a class="cs-bgcolor btn-form" data-target="#join-us" data-toggle="modal" href="#"><i class="icon-plus"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_join_us')) . '</a>';
		}
		if ($btns_only == false) {
		    // modal start  Modal
		    $output .= '<div class="modal fade" id="join-us" role="dialog">';
		    // modal start  dialog
		    $output .= '<div class="modal-dialog">';
		    // modal  start content
		    $output .= '<div class="modal-content">';
		    // modal start  header
		    $output .= '<div class="modal-header">';
		    $output .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		    $output .= '</div>';
		    // modal  End header
		    // 
		    // modal Start body 
		    $output .= '<div class="modal-body">'
			    . '<h4>' . esc_html(automobile_var_plugin_text_srt('automobile_var_create_account')) . '</h4>';
		    $isRegistrationOn = get_option('users_can_register');
		    $popup_register_rand_divids = rand(0, 999999);
		    if ($isRegistrationOn) {

			$rand_ids = rand(0, 999999);
			// popup dealer registration form
			$output .= '<div id="dealer' . $rand_ids . '" role="tabpanel" class="tab-pane active">';
			$output .= '<div id="result_' . absint($rand_ids) . '" class="status status-message"></div>';
			$output .= '<script>'
				. 'jQuery("body").on("keypress", "input#user_login' . absint($rand_ids) . ', input#user_email' . absint($rand_ids) . ', input#dealer_type' . absint($rand_ids) . ', input#phone_no' . absint($rand_ids) . '", function (e) {
									if (e.which == "13") {
										automobile_registration_validation("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_ids) . '");
										return false;
									}
									});'
				. '</script>';
			// popup dealer  form
			$output .= '<div class="cs-login-form"><form method="post" class="wp-user-form demo_test" id="wp_signup_form_' . $rand_ids . '" enctype="multipart/form-data">';
			//  popup dealer registration form Atrributes Start
			$output .= '<div class="input-holder"><label for="user_login' . absint($rand_ids) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_username')) . '</strong> <i class="icon-user-plus2"></i>';

			$automobile_opt_array = array(
			    'id' => '',
			    'std' => '',
			    'cust_id' => 'user_login' . absint($rand_ids),
			    'cust_name' => 'user_login' . absint($rand_ids),
			    'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_desired_username')) . '"',
			    'classes' => '',
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

			$output .= '</label></div>';

			$output .= '<div class="input-holder"><label for="user_email' . absint($rand_ids) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '</strong> <i class="icon-envelope"></i>';

			$automobile_opt_array = array(
			    'id' => 'user_email' . absint($rand_ids),
			    'std' => '',
			    'cust_id' => 'user_email' . absint($rand_ids),
			    'cust_name' => 'user_email' . absint($rand_ids),
			    'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_enter_email')) . '"',
			    'classes' => '',
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
			$output .= '</label></div>';
			$output .= '<div class="input-holder"><label for="automobile_dealer_type_' . absint($rand_ids) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_dealer_type')) . '</strong> <i class="icon-v-card"></i>';
			//  $output .='<div class="side-by-side select-icon clearfix">';
			// $output .='<div class="select-holder">';
			$output .= get_dealer_type_dropdown('automobile_dealer_type_' . absint($rand_ids), 'automobile_dealer_type_' . absint($rand_ids), '', 'chosen-select xyz');
			// $output .='</div>';
			//  $output .='</div>';
			$output .= '</label></div>';
			$output .= $automobile_form_fields_frontend->automobile_form_hidden_render(
				array('name' => 'user_role_type',
				    'id' => 'user_role_type',
				    'classes' => '',
				    'std' => 'automobile_dealer',
				    'description' => '',
				    'return' => true,
				    'hint' => '',
				    'icon' => 'icon-user9'
				)
			);
			$output .= '<div class="input-holder"><label for="phone_no' . absint($rand_ids) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '</strong> <i class="icon-phone"></i>';
			$automobile_opt_array = array(
			    'id' => '',
			    'std' => '',
			    'cust_id' => 'phone_no' . absint($rand_ids),
			    'cust_name' => 'phone_no' . absint($rand_ids),
			    'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone_hint')) . '"',
			    'classes' => 'register_phone',
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);


			$output .= '</label></div>';

			//allow in search
			$output .= '<div class="input-holder"><label for="allow_search"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_allow_in_search')) . '</strong>';
			$on_off_option = array(
			    "show" => "yes",
			    "hide" => "off",
			);
			$automobile_opt_array = array(
			    'id' => '',
			    'std' => '',
			    'cust_id' => 'allow_search',
			    'cust_name' => 'allow_search',
			    'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone_hint')) . '"',
			    'classes' => 'chosen-select-no-single',
			    'options' => $on_off_option,
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);


			$output .= '</label></div>';
			// popup dealer registration form Atrributes End
			if ($automobile_captcha_switch == 'on' && $automobile_sitekey != '' && $automobile_secretkey != '' && (!is_user_logged_in())) {

			    $output .= ' <div class="input-holder">';
			    $output .= '<div class="recaptcha-reload" id="recaptcha4_div">';
			    $output .= automobile_captcha('recaptcha4');
			    $output .= '</div>';
			    $output .= '</div>';
			}

			if ($automobile_terms_policy_switch == 'on') {
			    $output .= '<div class="terms"><label><input type="checkbox" name="automobile_check_terms" id="automobile_check_terms' . $rand_id . '">'
				    . ' ' . esc_html__("By registering you confirm that you accept the ", 'cs-automobile');
			    $output .= '<a target="_blank" href="' . $term_dealer_link . '">' . esc_html__('Terms & Conditions ', 'cs-automobile') . '</a>';
			    $output .= ' and ';
			    $output .= '<a target="_blank" href="' . $privacy_link . '"> ' . esc_html__('Privacy Policy', 'cs-automobile') . ' </a>';
			    $output .= '</label></div>';
			}
			// popup dealer registration form Button
			$output .= '<div class="input-holder">';
			ob_start();
			$output .= do_action('register_form');
			$output .= ob_get_clean();
			$automobile_rand_id = rand(122, 1545464897);

			$automobile_opt_array = array(
			    'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_create_account')),
			    'cust_id' => 'submitbtn' . $automobile_rand_id,
			    'cust_name' => 'user-submit',
			    'cust_type' => 'button',
			    'classes' => 'cs-color csborder-color',
			    'extra_atr' => ' tabindex="103" onclick="javascript:automobile_registration_validation(\'' . admin_url("admin-ajax.php") . '\',\'' . absint($rand_ids) . '\')"',
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
			$automobile_opt_array = array(
			    'id' => '',
			    'std' => $role,
			    'cust_id' => 'signin-role',
			    'cust_name' => 'role',
			    'cust_type' => 'hidden',
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

			$automobile_opt_array = array(
			    'id' => '',
			    'std' => 'automobile_registration_validation',
			    'cust_name' => 'action',
			    'cust_type' => 'hidden',
			    'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);


			$output .= '</div>';
			// popup dealer registration form Button End
			$output .= '</form></div>';
			// popup dealer registration form End
			$output .= ' <div class="register_content">' . do_shortcode($content . $register_text) . '</div>';

			$output .= '</div>';
			// popup candidate registration 
		    } else {
			$output .= '<div class="col-md-6 register-page">
                                        <div class="cs-user-register">
                                            <div class="cs-section-title">
                                                   <h2>' . esc_html(automobile_var_plugin_text_srt('automobile_var_register_here')) . '</h2>
                                           </div>
                                           <p>' . $user_disable_text . '</p>
                                        </div>
                                   </div>';
		    }
		    $output .= '</div>';
		    // modal body End
		    // modal Start Footer


		    $output .= '<div class="modal-footer"> <a data-dismiss="modal" data-target="#sign-in" data-toggle="modal" href="javascript:;" aria-hidden="true">' . esc_html(automobile_var_plugin_text_srt('automobile_var_already_have_account')) . '</a>';

		    if (class_exists('automobile_var')) {

			ob_start();
			$social_output = do_action('login_form');
			$social_output .= ob_get_clean();

			if ($isRegistrationOn && $social_output) {
			    $output .= '<div class="cs-separator"><span>' . esc_html(automobile_var_plugin_text_srt('automobile_var_or')) . '</span></div>';
			    $output .= ' <div class="cs-user-social">';
			    $output .= $social_output;
			    $output .= '</div>';
			}
		    }

		    $output .= '</div>';
		    // modal  Footer End
		    $output .= '</div>';
		    // modal  End content
		    $output .= '</div>';
		    // modal End  dialog
		    $output .= '</div>';
		    // modal End  Modal
		}
	    }

	    if ($without_btns == false) {
		$output .= '<a id="btn-header-main-login" data-target="#sign-in" data-toggle="modal" class="cs-bgcolor btn-form" href="#"><i class="icon-login"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_sign_in')) . '</a>';
	    }
	    if ($btns_only == false) {
		$output .= '<div class="login-form cs-login-pbox login-form-id-' . absint($rand_id) . '">';
		$output .= '<div class="modal fade" id="sign-in" tabindex="-1" role="dialog">';

		$output .= '<div class="modal-dialog" role="document">';
		$output .= '<div class="modal-content">';
		$output .= '<div class="modal-header">';
		$output .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		$output .= '</div>';
		$output .= '<div class="modal-body">';
		$output .= '<h4>' . esc_html(automobile_var_plugin_text_srt('automobile_var_user_sign_in')) . '</h4>';
		$output .= '<div class="status status-message"></div>';
		if (is_user_logged_in()) {
		    $output .= '<script>'
			    . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_id) . ', input#user_pass' . absint($rand_id) . '", function (e) {
                                    if (e.which == "13") {
                                        show_alert_msg("' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '");
                                        return false;
                                    }
                            });'
			    . '</script>';
		} else {
		    $output .= '<script>'
			    . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_id) . ', input#user_pass' . absint($rand_id) . '", function (e) {
                                if (e.which == "13") {
                                    automobile_user_authentication("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_id) . '");
                                    return false;
                                }
                            });'
			    . '</script>';
		}

//Modal Sign In Form 
		$output .= '<div class="cs-login-form"><form method="post" class="wp-user-form webkit" id="ControlForm_' . absint($rand_id) . '">';
//Modal Sign In Form  Attributes
		$output .= '<div class="input-holder"><label for="user_login' . absint($rand_id) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_username')) . '</strong> <i class="icon-user-plus2"></i>';
		$automobile_opt_array = array(
		    'id' => '',
		    'std' => '',
		    'cust_id' => 'user_login' . absint($rand_id),
		    'cust_name' => 'user_login',
		    'classes' => '',
		    'extra_atr' => ' tabindex="11" placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_desired_username')) . '"',
		    'return' => true,
		);
		$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
		$output .= '</label></div>';
		$output .= '<div class="input-holder">';

		$output .= ' <label for="user_pass' . absint($rand_id) . '"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_password')) . '</strong> <i class="icon-unlock40"></i>';

		$automobile_opt_array = array(
		    'id' => '',
		    'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_password')),
		    'cust_id' => 'user_pass' . absint($rand_id),
		    'cust_name' => 'user_pass',
		    'cust_type' => 'password',
		    'classes' => '',
		    'extra_atr' => ' tabindex="12" size="20" onfocus="if(this.value ==\'Password\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'Password\'; }"',
		    'return' => true,
		);
		$output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

		$output .= '</label></div>';

		if (is_user_logged_in()) {
		    $output .= '<div class="input-holder">';
		    $automobile_opt_array = array(
			'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_sign_in')),
			'cust_name' => 'user-submit',
			'cust_type' => 'button',
			'classes' => 'cs-color csborder-color',
			'extra_atr' => ' onclick="javascript:show_alert_msg(\'' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '\')"',
			'return' => true,
		    );
		    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

		    $output .= '</div>';
		} else {
		    $output .= '<div class="input-holder">';
		    $automobile_opt_array = array(
			'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_sign_in')),
			'cust_name' => 'user-submit',
			'cust_type' => 'button',
			'classes' => 'cs-color csborder-color',
			'extra_atr' => ' onclick="javascript:automobile_user_authentication(\'' . admin_url("admin-ajax.php") . '\',\'' . absint($rand_id) . '\')"',
			'return' => true,
		    );
		    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

		    $automobile_opt_array = array(
			'id' => '',
			'std' => get_permalink(),
			'cust_id' => 'redirect_to',
			'cust_name' => 'redirect_to',
			'cust_type' => 'hidden',
			'return' => true,
		    );
		    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

		    $automobile_opt_array = array(
			'id' => '',
			'std' => '1',
			'cust_id' => 'user-cookie',
			'cust_name' => 'user-cookie',
			'cust_type' => 'hidden',
			'return' => true,
		    );
		    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

		    $automobile_opt_array = array(
			'id' => '',
			'std' => 'ajax_login',
			'cust_name' => 'action',
			'cust_type' => 'hidden',
			'return' => true,
		    );
		    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

		    $automobile_opt_array = array(
			'id' => '',
			'std' => 'login',
			'cust_id' => 'login',
			'cust_name' => 'login',
			'cust_type' => 'hidden',
			'return' => true,
		    );
		    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

		    $output .= '</div>';
		}
		$output .= '<div class="input-holder">';
		$output .= '<a class="btn-forgot-pass" data-dismiss="modal" data-target="#user-forgot-pass" data-toggle="modal" href="javascript:;" aria-hidden="true"><i class=" icon-question-circle"></i> ' . esc_html(automobile_var_plugin_text_srt('automobile_var_forgot_password')) . '</a>';
		$output .= '</div>';

//Modal Sign In Form  Attributes End
		$output .= '</form></div>';
		$output .= '</div>';

		if (class_exists('automobile_var')) {
		    ob_start();
		    $social_output = do_action('login_form');
		    $social_output .= ob_get_clean();
		    $output .= '<div class="modal-footer">';
		    if ($isRegistrationOn) {
			if ($social_output) {
			    $output .= '<div class="cs-separator"><span>' . esc_html(automobile_var_plugin_text_srt('automobile_var_or')) . '</span></div>';
			    $output .= ' <div class="cs-user-social ">';
			    $output .= $social_output;
			    $output .= '</div>';
			}
			$output .= '<div class="cs-user-signup"> <i class="icon-user-plus2"></i> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_not_member_yet')) . ' </strong> <a class="cs-color" data-dismiss="modal" data-target="#join-us" data-toggle="modal" href="javascript:;" aria-hidden="true">' . esc_html(automobile_var_plugin_text_srt('automobile_var_Sign_up_now')) . '</a> </div>';
		    }
		    $output .= '</div>';
		}
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';


		ob_start();
		$output .= do_shortcode('[automobile_forgot_password automobile_type="popup"]');
		$output .= ob_get_clean();
	    }
	    $output .= '</div>';
	}

	return $output;
    }

    add_shortcode('automobile_user_login', 'automobile_user_login_shortcode');
}
