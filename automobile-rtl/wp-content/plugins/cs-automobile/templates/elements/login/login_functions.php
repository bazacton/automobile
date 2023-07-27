<?php

/**
 * @Generate Random String
 *
 *
 */
if (!function_exists('automobile_generate_random_string')) {

    function automobile_generate_random_string($length = 3) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
	    $randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
    }

}
/*
 *
 * Start Function  for if user exist using Ajax
 *
 */
if (!function_exists('ajax_login')) :

    function ajax_login() {
	global $automobile_var_plugin_options, $wpdb, $automobile_var_plugin_static_text;

	/* String Translations Variables */
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	/* End */

	$credentials = array();

	$automobile_danger_html = '<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><p><i class="icon-warning4"></i>';

	$automobile_success_html = '<div class="alert alert-success"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><p><i class="icon-checkmark6"></i>';

	$automobile_msg_html = '</p></div>';

	$credentials['user_login'] = esc_sql($_POST['user_login']);
	$credentials['user_password'] = esc_sql($_POST['user_pass']);
	if (isset($_POST['rememberme'])) {
	    $remember = esc_sql($_POST['rememberme']);
	} else {
	    $remember = '';
	}
	if ($remember) {
	    $credentials['remember'] = true;
	} else {
	    $credentials['remember'] = false;
	}
	if ($credentials['user_login'] == '') {
	    echo json_encode(array('loggedin' => false, 'message' => $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_username_should_not_be_empty')) . $automobile_msg_html));
	    exit();
	} elseif ($credentials['user_password'] == '') {
	    echo json_encode(array('loggedin' => false, 'message' => $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_password_should_not_be_empty')) . $automobile_msg_html));
	    exit();
	} else {
	    // PENDING ADDITION
	    $id = '';
	    $field = $wpdb->get_results("SELECT ID FROM $wpdb->users WHERE user_login='" . $credentials['user_login'] . "'");
	    $id = isset($field[0]) ? $field[0] : '';
	    $user_role_new = '';

	    if (!empty($id)):
		$user_data_info = get_userdata($field[0]->ID);
		$user_role = $user_data_info->roles;
		$user_role_new = $user_role[0];
	    endif;


	    if (count($field) > 0)
		$isPending = get_user_meta($field[0]->ID, 'automobile_user_status', 'active');
	    else
		$isPending = 'inactive';

	    if ($isPending != 'active' && $user_role_new != 'administrator') {

		echo json_encode(array('loggedin' => false, 'message' => $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_wrong_username_or_password')) . $automobile_msg_html));
		exit();
	    } else {
		$status = wp_signon($credentials, false);
		if (is_wp_error($status)) {
		    echo json_encode(array('loggedin' => false, 'message' => $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_wrong_username_or_password')) . $automobile_msg_html));
		} else {
		    $user_roles = isset($status->roles) ? $status->roles : '';
		    $uid = $status->ID;
		    $automobile_user_name = $_POST['user_login'];
		    $automobile_login_user = get_user_by('login', $automobile_user_name);
		    $automobile_page_id = '';
		    $default_url = $_POST['redirect_to'];
		    if (($user_roles != '' && in_array("automobile_dealer", $user_roles))) {
			$automobile_page_id = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : $default_url;
		    } elseif (($user_roles != '' && in_array("automobile_candidate", $user_roles))) {
			$automobile_page_id = isset($automobile_var_plugin_options['automobile_js_dashboard']) ? $automobile_var_plugin_options['automobile_js_dashboard'] : $default_url;
		    }
		    // update user last activity
		    update_user_meta($uid, 'automobile_user_last_activity_date', strtotime(date('d-m-Y H:i:s')));
		    $automobile_redirect_url = '';
		    if ($automobile_page_id != '') {
			$automobile_redirect_url = get_permalink($automobile_page_id);
		    } else {
			$automobile_redirect_url = $default_url;  // home URL if page not set
		    }
		    echo json_encode(array('redirecturl' => $automobile_redirect_url, 'loggedin' => true, 'message' => $automobile_success_html . esc_html(automobile_var_plugin_text_srt('automobile_var_login_successfully')) . $automobile_msg_html));
		}
	    }
	}
	die();
    }

endif;
add_action('wp_ajax_ajax_login', 'ajax_login');
add_action('wp_ajax_nopriv_ajax_login', 'ajax_login');

/*
 *
 * Start Function  for  user registration validation 
 *
 */
if (!function_exists('automobile_registration_validation')) {

    function automobile_registration_validation($atts = '') {
	global $wpdb, $automobile_var_plugin_options, $automobile_form_fields_frontend, $automobile_var_plugin_static_text;
	$automobile_terms_policy_switch = isset($automobile_var_plugin_options['automobile_terms_policy_switch']) && !empty($automobile_var_plugin_options['automobile_terms_policy_switch']) ? $automobile_var_plugin_options['automobile_terms_policy_switch'] : '';

	/* String Translations Variables */
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	/* End */


	$automobile_danger_html = '<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><p><i class="icon-warning4"></i>';
	$automobile_success_html = '<div class="alert alert-success"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><p><i class="icon-checkmark6"></i>';
	$automobile_msg_html = '</p></div>';

	$id = $_POST['id']; //rand id 
	$username = $_POST['user_login' . $id];
	$automobile_user_role_type = (isset($_POST['automobile_user_role_type' . $id]) and $_POST['automobile_user_role_type' . $id] <> '') ? $_POST['automobile_user_role_type' . $id] : '';
	$automobile_user_role_type = "dealer";
	$json = array();

	$automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
	if (empty($username)) {
	    $json['type'] = "error";
	    $json['message'] = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_username_should_not_be_empty')) . $automobile_msg_html;
	    echo json_encode($json);
	    exit();
	} elseif (!preg_match('/^[a-zA-Z0-9_]{5,}$/', $username)) { // for english chars + numbers only
	    $json['type'] = "error";
	    $json['message'] = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_valid_username')) . $automobile_msg_html;
	    echo json_encode($json);
	    exit();
	}
	$email = esc_sql($_POST['user_email' . $id]);
	if (empty($email)) {
	    $json['type'] = "error";
	    $json['message'] = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_email_should_not_be_empty')) . $automobile_msg_html;
	    echo json_encode($json);
	    exit();
	}
	if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
	    $json['type'] = "error";
	    $json['message'] = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_valid_email')) . $automobile_msg_html;
	    echo json_encode($json);
	    exit();
	}
	//do_action('automobile_verify_terms_policy', $_POST);
	//function aut_verify_terms_policy_callback($array_data = array()) {
	$cs_danger_html = '<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><p><i class="icon-warning4"></i>';
	$cs_msg_html = '</p></div>';
	$id = $_POST['id']; //rand id 
	if (array_key_exists("automobile_check_terms",$_POST)){
	$terms_check = $_POST['automobile_check_terms'];
	}
	if (empty($terms_check) && $automobile_terms_policy_switch == 'on') {
	    $json['type'] = "error";
	    $json['message'] = $cs_danger_html . esc_html__("Please check and accept Terms and Conditions to Register Successfully.", "cs-automobile") . $cs_msg_html;
	    echo json_encode($json);
	    exit();
	} else {

	}
	//}
	if ($automobile_captcha_switch == 'on') {
	    automobile_captcha_verify();
	}
	$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);

	$status = wp_create_user($username, $random_password, $email);
	 do_action('automobile_allow_search_save', $_POST, $status);
	if (is_wp_error($status)) {
	    $json['type'] = "error";
	    $json['message'] = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_user_already_exists')) . $automobile_msg_html;
	    echo json_encode($json);
	    die;
	} else {
	    global $wpdb;
	    $signup_user_role = '';
	    if ($automobile_user_role_type == 'dealer') {
		$signup_user_role = 'automobile_dealer';
	    }
	    wp_update_user(array('ID' => esc_sql($status), 'role' => esc_sql($signup_user_role), 'user_status' => 1));
	    $wpdb->update(
		    $wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($status))
	    );
	    update_user_meta($status, 'show_admin_bar_front', false);
	    // send email to user
	    $subject = esc_html(automobile_var_plugin_text_srt('automobile_var_user_registration_detail'));
	    $contents = 'Password:' . $random_password . "\n" . 'Email:' . $email . "\n";
	    $respose = wp_mail($email, $subject, $contents);
	    if ($respose) {
		$json['type'] = "success";
		$json['message'] = $automobile_success_html . esc_html(automobile_var_plugin_text_srt('automobile_var_check_email')) . $automobile_msg_html;
	    } else {
		$json['type'] = "error";
		$json['message'] = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_successfully_registered')) . $automobile_msg_html;
	    }
	    // end sent mail

	    $json['type'] = "success";
	    $json['message'] = $automobile_success_html . esc_html(automobile_var_plugin_text_srt('automobile_var_check_email')) . $automobile_msg_html;

	    // update user meta by role
	    if ($automobile_user_role_type == 'dealer' || $automobile_user_role_type == 'automobile_dealer') {

		$automobile_dealer_type = (isset($_POST['automobile_dealer_type_' . $id]) and $_POST['automobile_dealer_type_' . $id] <> '') ? $_POST['automobile_dealer_type_' . $id] : 'nill';

		$automobile_phone_no = (isset($_POST['phone_no' . $id]) and $_POST['phone_no' . $id] <> '') ? $_POST['phone_no' . $id] : '';


		wp_update_user(array(
		    'ID' => $status,
			// 'display_name' => $automobile_comp_name
		));

		if (isset($automobile_var_plugin_options['automobile_dealer_review_option']) && $automobile_var_plugin_options['automobile_dealer_review_option'] == 'on') {
		    $wpdb->update(
			    $wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($status))
		    );
		    update_user_meta($status, 'automobile_user_status', 'active');
		} else {
		    $wpdb->update(
			    $wpdb->prefix . 'users', array('user_status' => 0), array('ID' => esc_sql($status))
		    );
		    update_user_meta($status, 'automobile_user_status', 'inactive');
		}
	    }
	    update_user_meta($status, 'automobile_phone_number', $automobile_phone_no);
	    update_user_meta($status, 'automobile_user_last_activity_date', strtotime(date('d-m-Y')));
	    update_user_meta($status, 'automobile_allow_search', 'yes');


	    if (!empty($automobile_dealer_type)) {

		update_user_meta($status, 'automobile_dealer_type', $automobile_dealer_type);
	    }

	    echo json_encode($json);
	    die;
	}
	die();
    }

    add_action('wp_ajax_automobile_registration_validation', 'automobile_registration_validation');
    add_action('wp_ajax_nopriv_automobile_registration_validation', 'automobile_registration_validation');
}

if (!function_exists('automobile_allow_search_save_callback')) {

   function automobile_allow_search_save_callback($array_data = array(), $user_id = '') {
        global $cs_plugin_options;
        if ( empty($user_id) ) {
            return;
        }

        $cs_allow_in_search_user_switch = isset($cs_plugin_options['cs_allow_in_search_user_switch']) ? $cs_plugin_options['cs_allow_in_search_user_switch'] : '';
        if ( isset($cs_allow_in_search_user_switch) && $cs_allow_in_search_user_switch != 'on' ) {
            return;
        }
		$id = rand(0, 41564687897); //rand id 
        $allow_in_search = 'no';
        //$id = $array_data['id']; //rand id 
        $allow_in_search = $array_data['cs_allow_in_search' . $id];
        if ( isset($allow_in_search) && $allow_in_search == 'yes' ) {
            update_user_meta($user_id, 'cs_allow_search', $allow_in_search);
        } else {
            update_user_meta($user_id, 'cs_allow_search', $allow_in_search);
        }
    }

    add_action('wp_ajax_automobile_allow_search_save', 'automobile_allow_search_save_callback');
    add_action('wp_ajax_nopriv_automobile_allow_search_save', 'automobile_allow_search_save_callback');
}

if (!function_exists('automobile_contact_validation')) {

    function automobile_contact_validation($atts = '') {

	global $wpdb, $automobile_var_plugin_options, $automobile_form_fields_frontend, $automobile_var_plugin_static_text;

	/* String Translations Variables */
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	/* End */

	$id = rand(0, 41564687897); //rand id 
	$username = $_POST['user_login' . $id];
	$json = array();
	if ($automobile_captcha_switch == 'on') {
	    automobile_captcha_verify();
	}
	if (is_wp_error($status)) {
	    $json['type'] = "error";
	    $json['message'] = esc_html(automobile_var_plugin_text_srt('automobile_var_currently_issue'));
	    echo json_encode($json);
	    die;
	} else {
	    $json['type'] = "error";
	    $json['message'] = esc_html(automobile_var_plugin_text_srt('automobile_var_successfully_registered'));
	}

	echo json_encode($json);
	die;

	die();
    }

    add_action('wp_ajax_automobile_registration_validation', 'automobile_registration_validation');
    add_action('wp_ajax_nopriv_automobile_registration_validation', 'automobile_registration_validation');
}

/*
 *
 * Start Function  for  create form  capatach
 *
 */
if (!function_exists('automobile_captcha')) {

    function automobile_captcha($id = '') {
	global $automobile_var_plugin_options, $automobile_var_plugin_static_text;

	/* String Translations Variables */
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	/* End */

	$automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
	$automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
	$automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
	$output = '';
	if ($automobile_captcha_switch == 'on') {
	    if ($automobile_sitekey <> '' && $automobile_secretkey <> '') {
		$output .= '<script type="text/javascript">'
			. 'jQuery(window).on(load,function (){
                        captcha_reload(\'' . admin_url('admin-ajax.php') . '\', \'' . $id . '\');
                    });
                    </script>';
		$output .= '<div class="g-recaptcha" data-theme="light" id="' . $id . '" data-sitekey="' . $automobile_sitekey . '" style="transform:scale(1.22);-webkit-transform:scale(1.22);transform-origin:0 0;-webkit-transform-origin:0 0;"></div> <a class="recaptcha-reload-a" href="javascript:void(0);" onclick="captcha_reload(\'' . admin_url('admin-ajax.php') . '\', \'' . $id . '\');"><i class="icon-refresh2"></i> ' . esc_html(automobile_var_plugin_text_srt('automobile_var_reload')) . '</a>';
	    } else {
		$output = '<p>' . esc_html(automobile_var_plugin_text_srt('automobile_var_captcha_api_key')) . '</p>';
	    }
	}
	return $output;
    }

}
/*
 *
 * Start Function  for  create form validation/verify capatach
 *
 */
if (!function_exists('automobile_captcha_verify')) {

    function automobile_captcha_verify($page = '') {
	global $automobile_var_plugin_options, $automobile_var_plugin_static_text;

	/* String Translations Variables */
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	/* End */
	$automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
	$automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
	$automobile_captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
	$automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';

	if ($automobile_captcha_switch == 'on' && $automobile_sitekey != '' && $automobile_secretkey != '') {
	    if ($page == true) {
		if (empty($automobile_captcha)) {
		    return true;
		}
	    } else {
		$json = array();
		if (empty($automobile_captcha)) {
		    $json['type'] = "error";
		    $json['message'] = esc_html(automobile_var_plugin_text_srt('automobile_var_select_captcha_field'));
		    echo json_encode($json);
		    exit();
		}
	    }
	}
    }

}

/*
 *
 * Start Function  for  create form  capatach reload
 *
 */
if (!function_exists('captcha_reload')) {

    function captcha_reload($atts = '') {
	global $automobile_var_plugin_options;

	$captcha_id = $_REQUEST['captcha_id'];
	$automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
	$return_str = "<script>
        var " . $captcha_id . ";
            " . $captcha_id . " = grecaptcha.render('" . $captcha_id . "', {
                'sitekey': '" . $automobile_sitekey . "', //Replace this with your Site key
                'theme': 'light'
            });"
		. "</script>";
	$return_str .= automobile_captcha($captcha_id);
	echo force_balance_tags($return_str);
	die();
    }

    add_action('wp_ajax_captcha_reload', 'captcha_reload');
    add_action('wp_ajax_nopriv_captcha_reload', 'captcha_reload');
}
?>