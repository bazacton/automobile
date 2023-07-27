<?php
/**
 * File Type: Dealer Functions
 */
if (!class_exists('automobile_dealer_functions')) {

    class automobile_dealer_functions {

	/**
	 * Start construct Functions
	 */
	public function __construct() {
	    add_action('wp_ajax_automobile_check_user_avail', array(&$this, 'automobile_check_user_avail'));
	    add_action('wp_ajax_nopriv_automobile_check_user_avail', array(&$this, 'automobile_check_user_avail'));
	    add_action('wp_ajax_automobile_inventory_delete', array(&$this, 'automobile_inventory_delete'));
	    add_action('wp_ajax_automobile_fav_resume_del', array(&$this, 'automobile_fav_resume_del'));
	    add_action('wp_ajax_automobile_emp_check', array(&$this, 'automobile_emp_check'));
	    add_action('wp_ajax_nopriv_automobile_emp_check', array(&$this, 'automobile_emp_check'));
	    add_action('wp_ajax_automobile_inventory_status_update', array(&$this, 'automobile_inventory_status_update'));
	    add_action('wp_ajax_nopriv_automobile_inventory_status_update', array(&$this, 'automobile_inventory_status_update'));
	    add_action('wp_ajax_automobile_unset_user_fav', array(&$this, 'automobile_unset_user_fav'));
	    add_action('wp_ajax_ajax_dealer_form_save', array(&$this, 'ajax_dealer_form_save'));
	    add_action("wp_ajax_cs_remove_profile", array(&$this, 'cs_remove_profile_callback'));
	    add_action("wp_ajax_nopriv_cs_remove_profile", array(&$this, 'cs_remove_profile_callback'));
	}

	/**
	 * End construct Functions
	 */
	function cs_remove_profile_callback() {
	    $u_id = isset($_POST['u_id']) ? $_POST['u_id'] : '';

	    if (isset($u_id) && !empty($u_id)) {
		wp_delete_user($u_id);
		$reponse['status'] = 'success';
		$reponse['message'] = esc_html__('Delete Successfully', 'jobhunt');
		$reponse['redirecturl'] = home_url();
		echo json_encode($reponse);
		wp_die();
	    }
	    $reponse['status'] = 'error';
	    $reponse['message'] = esc_html__('Something went wrong', 'jobhunt');
	    echo json_encode($reponse);
	    wp_die();
	}

	/**
	 * Start Function for checking the Availability and Registration for User
	 */
	public function automobile_check_user_avail() {
	    global $automobile_var_plugin_static_text;
	    $automobile_json = array();
	    $automobile_user_email = isset($_POST['emp_email']) ? $_POST['emp_email'] : '';
	    $automobile_username = isset($_POST['emp_username']) ? $_POST['emp_username'] : '';
	    $automobile_error = false;
	    $automobile_json['type'] = 'success';
	    if (email_exists($automobile_user_email)) {
		$automobile_json['msg'] = automobile_var_plugin_text_srt('automobile_var_email_in_use');
		$automobile_json['type'] = 'error';
		$automobile_error = true;
	    } else if (username_exists($automobile_username)) {
		$automobile_json['msg'] = automobile_var_plugin_text_srt('automobile_var_username_in_use');
		$automobile_json['type'] = 'error';
		$automobile_error = true;
	    }
	    if ($automobile_error == false) {
		$automobile_json['msg'] = automobile_var_plugin_text_srt('automobile_var_you_will_recieve');
		$automobile_json['type'] = 'success';
	    }
	    echo json_encode($automobile_json);
	    die;
	}

	/**
	 * END Function for checking the Availability and Registration for User
	 */

	/**
	 * Start Function for Creating User Registration Form
	 */
	public function automobile_create_user($automobile_username, $automobile_user_email) {
	    global $wpdb;
	    if (!username_exists($automobile_username) && !email_exists($automobile_user_email)) {
		$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
		$role = 'guest';
		$automobile_user_email = sanitize_email($automobile_user_email);
		$automobile_register = wp_create_user($automobile_username, $random_password, $automobile_user_email);
		if (!is_wp_error($automobile_register)) {
		    wp_update_user(array('ID' => esc_sql($automobile_register), 'role' => esc_sql($role), 'user_status' => 1));
		    $wpdb->update(
			    $wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($automobile_register))
		    );
		    update_user_meta($automobile_register, 'show_admin_bar_front', false);
		    wp_new_user_notification(esc_sql($automobile_register), $random_password);
		    $get_user = get_user_by('email', $automobile_user_email);
		    // Creating Dealer Post
		    $dealer_post = array(
			'post_title' => $automobile_username,
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => '',
			'post_type' => 'dealer',
			'post_date' => current_time('Y-m-d H:i:s')
		    );
		    $post_id = wp_insert_post($dealer_post);
		    if ($post_id) {
			// update username
			update_post_meta($post_id, 'automobile_user', $get_user->ID);
		    }
		    return $get_user->ID;
		}
	    }
	}

	/**
	 * End Function for Creating User Registration Form
	 */

	/**
	 * Start Function for Creating inventory  Fields
	 */
	/*

	  generating fields for inventory
	 */
	public function inventory_type_custom_fields($automobile_inventory_type_id = '', $automobile_inventory_id = '') {
	    global $automobile_html_fields, $automobile_form_fields, $automobile_var_plugin_static_text;
	    $automobile_fields_output = '';
	    $automobile_inventory_type_cus_fields = get_post_meta($automobile_inventory_type_id, "automobile_inventory_type_cus_fields", true);

	    if (is_array($automobile_inventory_type_cus_fields) && sizeof($automobile_inventory_type_cus_fields) > 0) {

		foreach ($automobile_inventory_type_cus_fields as $cus_field) {
		    $automobile_type = isset($cus_field['type']) ? $cus_field['type'] : '';


		    switch ($automobile_type) {
			case('section'):
			    echo '<div class="cs-field-holder">';
			    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
			    echo '<h6>';
			    $font_awesome_icon = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
			    echo '<i class="cs-color ' . $font_awesome_icon . '"></i>';
			    echo isset($cus_field['label']) ? $cus_field['label'] : '';
			    echo '</h6>';
			    echo '</div>';
			    echo '</div>';
			    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="cs-seprator"></div>
									</div>';
			    break;
			case('text'):
			    if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {

				$automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
				if ($automobile_inventory_id != '') {
				    $automobile_default_val = get_post_meta($automobile_inventory_id, $cus_field['meta_key'], true);
				}

				echo '<div class="cs-field-holder"><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>';
				echo isset($cus_field['label']) ? $cus_field['label'] : "";
				echo '</label></div>';
				$automobile_opt_array = array(
				    'name' => '',
				    'desc' => '',
				    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : "",
				    'echo' => false,
				    'std' => $automobile_default_val,
				    'id' => $cus_field['meta_key'],
				    'cus_field' => true,
				    'return' => true,
				);

				echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="cs-field">';
				$output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
				echo force_balance_tags($output);
				echo '</div></div></div>';
			    }
			    break;
			case('textarea'):
			    if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
				$automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
				if ($automobile_inventory_id != '') {
				    $automobile_default_val = get_post_meta($automobile_inventory_id, $cus_field['meta_key'], true);
				}
				echo '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>';
				echo isset($cus_field['label']) ? $cus_field['label'] : "";
				echo '</label>
										</div>
										<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
												<div class="cs-field">';
				$automobile_opt_array = array(
				    'name' => '',
				    'desc' => '',
				    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				    'echo' => false,
				    'std' => $automobile_default_val,
				    'id' => $cus_field['meta_key'],
				    'cus_field' => true,
				    'return' => true,
				);
				if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				    $automobile_opt_array['extra_atr'] = 'required="required"';
				}
				$output = $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
				echo force_balance_tags($output);
				echo '</div></div></div>';
			    }
			    break;
			case('dropdown'):
			    if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {

				$automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
				if ($automobile_inventory_id != '') {
				    $automobile_default_val = get_post_meta($automobile_inventory_id, $cus_field['meta_key'], true);
				}

				echo '<div class="cs-field-holder"><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><label>';
				echo isset($cus_field['label']) ? $cus_field['label'] : "";
				echo '</label>
										</div>';
				$automobile_options = array();
				if (isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0) {
				    if (isset($cus_field['first_value']) && $cus_field['first_value'] != '') {
					$automobile_options[''] = $cus_field['first_value'];
				    }
				    $automobile_opt_counter = 0;
				    foreach ($cus_field['options']['value'] as $automobile_option) {

					$automobile_opt_label = $cus_field['options']['label'][$automobile_opt_counter];
					$automobile_options[$automobile_option] = $automobile_opt_label;
					$automobile_opt_counter++;
				    }
				}

				$automobile_opt_array = array(
				    "name" => isset($cus_field['label']) ? $cus_field['label'] : '',
				    "desc" => "",
				    'id' => $cus_field['meta_key'],
				    'cus_field' => true,
				    'return' => true,
				    "std" => $automobile_default_val,
				    'classes' => 'chosen-select-no-single',
				    "type" => "select_values",
				    'options' => $automobile_options,
				);
				if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				    $automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
				}
				if (isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes') {
				    $automobile_opt_array['multi_front'] = true;
				}


				echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">';
				$output = $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
				echo force_balance_tags($output);
				echo '</div></div>';
			    }
			    break;
			case('date'):
			    if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
				$automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
				if ($automobile_inventory_id != '') {
				    $automobile_default_val = get_post_meta($automobile_inventory_id, $cus_field['meta_key'], true);
				}
				echo '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>' . isset($cus_field['label']) ? $cus_field['label'] : '' . '</label>
										</div>
										<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
												<div class="cs-field">';
				$automobile_format = isset($cus_field['date_format']) && $cus_field['date_format'] != '' ? $cus_field['date_format'] : 'd-m-Y';

				$automobile_opt_array = array(
				    'name' => '',
				    'desc' => '',
				    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				    'echo' => false,
				    'field_params' => array(
					'std' => $automobile_default_val,
					'id' => $cus_field['meta_key'],
					'format' => $automobile_format,
					'cus_field' => true,
					'return' => true,
				    ),
				);
				if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				    $automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
				}
				$output = $automobile_html_fields->automobile_date_field($automobile_opt_array);
				echo force_balance_tags($output);
				echo '</div></div></div>';
			    }
			    break;
			case('email'):
			    if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
				$automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
				if ($automobile_inventory_id != '') {
				    $automobile_default_val = get_post_meta($automobile_inventory_id, $cus_field['meta_key'], true);
				}
				echo '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><label>';
				echo isset($cus_field['label']) ? $cus_field['label'] : '';
				echo '</label></div>';
				$automobile_opt_array = array(
				    'name' => '',
				    'desc' => '',
				    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				    'echo' => false,
				    'std' => $automobile_default_val,
				    'id' => $cus_field['meta_key'],
				    'cus_field' => true,
				    'return' => true,
				);
				if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				    $automobile_opt_array['required'] = 'yes';
				}
				echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="cs-field">';
				$output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
				echo force_balance_tags($output);
				echo '</div></div></div>';
			    }
			    break;
			case('url'):
			    if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
				$automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
				if ($automobile_inventory_id != '') {
				    $automobile_default_val = get_post_meta($automobile_inventory_id, $cus_field['meta_key'], true);
				}
				echo '<div class="cs-field-holder"><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>';
				echo isset($cus_field['label']) ? $cus_field['label'] : '';
				echo '</label></div>';
				$automobile_opt_array = array(
				    'name' => '',
				    'desc' => '',
				    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				    'echo' => false,
				    'std' => $automobile_default_val,
				    'id' => $cus_field['meta_key'],
				    'cus_field' => true,
				    'return' => true,
				);
				if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				    $automobile_opt_array['required'] = "yes";
				}
				echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="cs-field">';
				$output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
				echo force_balance_tags($output);
				echo '</div></div></div>';
			    }
			    break;
			case('range'):
			    if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
				$automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
				if ($automobile_inventory_id != '') {
				    $automobile_default_val = get_post_meta($automobile_inventory_id, $cus_field['meta_key'], true);
				}
				echo '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>';
				echo isset($cus_field['label']) ? $cus_field['label'] : '';
				echo '</label></div>';
				$automobile_opt_array = array(
				    'name' => '',
				    'desc' => '',
				    'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				    'echo' => false,
				    'std' => $automobile_default_val,
				    'id' => $cus_field['meta_key'],
				    'cus_field' => true,
				    'return' => true,
				);
				if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				    $automobile_opt_array['required'] = "required";
				}
				echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
										<div class="cs-field">';

				$output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
				echo force_balance_tags($output);
				echo '</div></div></div>';
			    }
			    break;
		    }
		}





		echo '
                <script>
                    jQuery(document).ready(function () {
                        chosen_selectionbox();
                    });
                </script>';
	    } else {
		echo automobile_var_plugin_text_srt('automobile_var_no_custom_field_found');
	    }
	}

	/*
	  inventory features
	 */

	public function automobile_inventory_feature_fields($automobile_inventory_type_id = '', $automobile_inventory_id = '') {
	    global $automobile_html_fields, $automobile_var_plugin_static_text;
	    $automobile_fields_output = '';
	    $automobile_inventory_features = get_post_meta($automobile_inventory_id, 'automobile_inventory_feature_list', true);

	    $html = $automobile_html_fields->automobile_heading_render(
		    array(
			'name' => automobile_var_plugin_text_srt('automobile_var_features'),
			'id' => 'features_information',
			'classes' => '',
			'std' => '',
			'echo' => false,
			'description' => '',
			'hint' => ''
		    )
	    );

	    $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'post_status' => 'publish'));
	    $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

	    $automobile_var_get_features = get_post_meta($automobile_inventory_type_id, 'automobile_inventory_type_features', true);

	    if (is_array($automobile_var_get_features) && sizeof($automobile_var_get_features) > 0) {
		echo '<div class="cs-checkbox-holder"><ul class="cs-checkbox-list">';
		$automobile_checkbox_id = 0;
		foreach ($automobile_var_get_features as $feat_key => $features) {
		    $automobile_checkbox_id++;
		    if (isset($features) && $features <> '') {
			$automobile_feature_name = isset($features['name']) ? $features['name'] : '';
			echo '
                        <li class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="cs-checkbox"><input id="' . $automobile_checkbox_id . 'cs-checkbox" ' . (is_array($automobile_inventory_features) && in_array($automobile_feature_name, $automobile_inventory_features) ? ' checked="checked"' : '') . ' type="checkbox" value="' . $automobile_feature_name . '" name="automobile_inventory_feature_list[]"><label for="' . $automobile_checkbox_id . 'cs-checkbox">' . $automobile_feature_name . '</label>
                       </div> </li>';
		    }
		}
	    }
	    echo '</ul></div>';

	    echo force_balance_tags($automobile_fields_output);
	}

	/*
	  inventory makes
	 */

	public function inventory_makes($inventory_type_id = 0, $automobile_inventory_id = '') {
	    global $automobile_form_fields, $automobile_var_plugin_static_text;

	    if ($inventory_type_id != 0) {

		$automobile_inventory_type_makes = get_post_meta($inventory_type_id, 'automobile_inventory_type_makes', true);
		if (isset($automobile_inventory_type_makes) && is_array($automobile_inventory_type_makes) && count($automobile_inventory_type_makes) > 0) {
		    $automobile_inventory_type_makes_array = array();
		    if ($automobile_inventory_type_makes != '') {
			foreach ($automobile_inventory_type_makes as $key => $val) {

			    $automobil_term_info = get_term_by('slug', $val, 'inventory-make');
			    if ($automobil_term_info != '') {
				$automobile_inventory_type_makes_array[$automobil_term_info->term_id] = $val;
			    }
			}
		    }
		    $automobile_default_val = '';
		    if ($automobile_inventory_id != '') {
			$automobile_default_val = get_post_meta($automobile_inventory_id, 'automobile_inventory_makes', true);
		    }
		    echo '<div class="cs-field-holder">
												<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
													<h6>' . automobile_var_plugin_text_srt('automobile_var_inventroy_makes') . '</h6>
												
												</div>
											<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
												<div class="cs-field">';


		    $automobile_opt_array = array(
			"name" => automobile_var_plugin_text_srt('automobile_var_inventory_type'),
			"desc" => "",
			"id" => "inventory_makes",
			"std" => $automobile_default_val,
			'classes' => 'chosen-select-no-single',
			'extra_atr' => ' onchange="automobile_load_make_models_frontend(this.value,\'' . $post_id . '\',\'' . admin_url() . 'admin-ajax.php' . '\')"',
			"type" => "select_values",
			"options" => $automobile_inventory_type_makes_array,
			'return' => true,
			    //'options_markup' => true,
		    );

		    echo force_balance_tags($automobile_form_fields->automobile_form_select_render($automobile_opt_array));

		    echo '</div>
			</div>
	            	</div>';
		}
	    }
	}

	/*
	  inventory models
	 */

	public function inventory_models($inventory_type_id = 0, $automobile_inventory_id = '') {
	    global $automobile_form_fields, $automobile_var_plugin_static_text;

	    $automobile_inventory_make = get_post_meta($inventory_type_id, 'automobile_inventory_type_makes', true);
	    $i = 0;
	    foreach ($automobile_inventory_make as $key => $post_object) {
		if ($i === 0) {
		    $term_slug = $post_object;
		}
		$i++;
	    }
	    $term = get_term_by('slug', $term_slug, 'inventory-make');


	    $automobile_inventory_type_models = get_term_meta($term->term_id, 'automobile_inventory_make_models', true);

	    //$automobile_inventory_type_models = get_post_meta($inventory_type_id, 'automobile_inventory_type_models', true);
	    if (isset($automobile_inventory_type_models) && is_array($automobile_inventory_type_models) && count($automobile_inventory_type_models) > 0) {
		$automobile_inventory_type_models_array = array();
		if ($automobile_inventory_type_models != '') {
		    foreach ($automobile_inventory_type_models as $key => $val) {

			$automobil_term_info = get_term_by('slug', $val, 'inventory-model');
			if ($automobil_term_info != '') {
			    $automobile_inventory_type_models_array[$automobil_term_info->term_id] = $val;
			}
		    }
		}
		$automobile_default_val = '';
		if ($automobile_inventory_id != '') {
		    $automobile_default_val = get_post_meta($automobile_inventory_id, 'automobile_inventory_models', true);
		}
		echo '<div class="cs-field-holder">
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<h6>' . automobile_var_plugin_text_srt('automobile_var_inventroy_models') . '</h6>
						</div>
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
		<div class="cs-field">';
		$automobile_opt_array = array(
		    "name" => automobile_var_plugin_text_srt('automobile_var_inventroy_models'),
		    "desc" => "",
		    "id" => "inventory_models",
		    "std" => $automobile_default_val,
		    'classes' => 'chosen-select-no-single',
		    "type" => "select_values",
		    "options" => $automobile_inventory_type_models_array,
		);
		echo force_balance_tags($automobile_form_fields->automobile_form_select_render($automobile_opt_array));

		echo '</div>
											</div>
											</div>';
		echo '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';
	    }
	}

	public function automobile_add_inventory($values = array(), $automobile_elem = false) {
	    extract($values);

	    $automobile_inventory_id = isset($automobile_inventory_id) ? $automobile_inventory_id : '';
	    $automobile_inventory_user = isset($automobile_inventory_user) ? $automobile_inventory_user : '';
	    $automobile_inventory_title = isset($automobile_inventory_title) ? $automobile_inventory_title : '';
	    $automobile_inventory_desc = isset($automobile_inventory_desc) ? $automobile_inventory_desc : '';
	    $automobile_inventory_old_price = isset($automobile_inventory_old_price) ? $automobile_inventory_old_price : '';
	    $automobile_inventory_new_price = isset($automobile_inventory_new_price) ? $automobile_inventory_new_price : '';
	    $automobile_inventory_types = isset($automobile_inventory_types) ? $automobile_inventory_types : '';
	    $automobile_inventory_dealer_type = isset($automobile_inventory_dealer_type) ? $automobile_inventory_dealer_type : '';
	    $automobile_inventory_expire = isset($automobile_inventory_expire) ? $automobile_inventory_expire : '';
	    $automobile_inventory_pkg = isset($automobile_inventory_pkg) ? $automobile_inventory_pkg : '';
	    $automobile_inventory_status = isset($automobile_inventory_status) ? $automobile_inventory_status : '';
	    $automobile_inventory_custom = isset($automobile_inventory_custom) ? $automobile_inventory_custom : '';
	    // location fields
	    $automobile_post_loc_country = isset($automobile_post_loc_country) ? $automobile_post_loc_country : '';
	    $automobile_post_loc_region = isset($automobile_post_loc_region) ? $automobile_post_loc_region : '';
	    $automobile_post_loc_city = isset($automobile_post_loc_city) ? $automobile_post_loc_city : '';
	    $automobile_post_loc_address = isset($automobile_post_loc_address) ? $automobile_post_loc_address : '';
	    $automobile_post_loc_latitude = isset($automobile_post_loc_latitude) ? $automobile_post_loc_latitude : '';
	    $automobile_post_loc_longitude = isset($automobile_post_loc_longitude) ? $automobile_post_loc_longitude : '';
	    $automobile_add_new_loc = isset($automobile_add_new_loc) ? $automobile_add_new_loc : '';
	    $automobile_post_loc_zoom = isset($automobile_post_loc_zoom) ? $automobile_post_loc_zoom : '';
	    $automobile_inventory_makes = isset($automobile_inventory_makes) ? $automobile_inventory_makes : '';
	    $automobile_inventory_models = isset($automobile_inventory_models) ? $automobile_inventory_models : '';
	    $gallery_user_img = isset($gallery_user_img) ? $gallery_user_img : '';

	    if ($automobile_elem == true) {
		$automobile_inventory_desc = $automobile_inventory_desc;
	    } else {
		$automobile_inventory_desc = html_entity_decode(base64_decode($automobile_inventory_desc));
	    }

	    $inventory_post = array(
		'post_title' => $automobile_inventory_title,
		'post_content' => $automobile_inventory_desc,
		'post_status' => 'publish',
		'post_type' => 'inventory',
		'post_date' => current_time('Y-m-d H:i:s')
	    );
	    //insert inventory

	    $inventory_id = wp_insert_post($inventory_post);
	    // add automobile_inventory_dealer_type

	    if (!empty($automobile_inventory_dealer_type)) {
		wp_set_post_terms($inventory_id, array(), 'dealer_type', FALSE);
		foreach ($automobile_inventory_dealer_type as $automobile_spec) {
		    $automobile_spec = (int) $automobile_spec;
		    wp_set_post_terms($inventory_id, array($automobile_spec), 'dealer_type', true);
		}
	    }
	    // add automobile_inventory_type
	    if ($automobile_inventory_types != '') {
		wp_set_post_terms($inventory_id, array($automobile_inventory_types), 'inventory_type', FALSE);
	    }

	    $automobile_insert_array = array(
		'automobile_inventory_id' => $automobile_inventory_id,
		'automobile_inventory_username' => $automobile_inventory_user,
		'automobile_inventory_posted' => strtotime(current_time('d-m-Y H:i:s')),
		'automobile_inventory_expired' => strtotime($automobile_inventory_expire),
		'automobile_inventory_package' => $automobile_inventory_pkg,
		'automobile_inventory_status' => $automobile_inventory_status,
	    );
	    // update location fiels
	    if ($automobile_post_loc_country != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_country", $automobile_post_loc_country);
	    }
	    if ($automobile_post_loc_region != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_region", $automobile_post_loc_region);
	    }
	    if ($automobile_post_loc_city != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_city", $automobile_post_loc_city);
	    }
	    if ($automobile_post_loc_address != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_address", $automobile_post_loc_address);
	    }
	    if ($automobile_post_loc_latitude != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_latitude", $automobile_post_loc_latitude);
	    }
	    if ($automobile_post_loc_longitude != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_longitude", $automobile_post_loc_longitude);
	    }
	    if ($automobile_add_new_loc != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_add_new_loc", $automobile_add_new_loc);
	    }
	    if ($automobile_post_loc_zoom != '') {
		update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_zoom", $automobile_post_loc_zoom);
	    }

	    if (is_array($automobile_inventory_custom) && sizeof($automobile_inventory_custom) > 0) {
		$automobile_custom_array = array();
		foreach ($automobile_inventory_custom as $cus_key => $automobile_val) {
		    $automobile_custom_array[$cus_key] = $automobile_val;
		}
		$automobile_insert_array = array_merge($automobile_insert_array, $automobile_custom_array);
	    }
	    foreach ($automobile_insert_array as $inventory_key => $inventory_val) {

		update_post_meta($inventory_id, "$inventory_key", $inventory_val);
	    }

	    if ($automobile_inventory_makes != '') {
		wp_set_post_terms($inventory_id, $automobile_inventory_makes, 'inventory-make', false);
	    }
	    if ($automobile_inventory_models != '') {
		wp_set_post_terms($inventory_id, $automobile_inventory_models, 'inventory-model', false);
	    }
	    if ($gallery_user_img != '') {

		update_post_meta($inventory_id, "automobile_inventory_gallery_url", $gallery_user_img);
	    }

	    if ($automobile_inventory_old_price != '') {
		update_post_meta($inventory_id, "automobile_inventory_old_price", $automobile_inventory_old_price);
	    }

	    if ($automobile_inventory_new_price != '') {
		update_post_meta($inventory_id, "automobile_inventory_new_price", $automobile_inventory_new_price);
	    }


	    return $inventory_id;
	}

	/**
	 * End Function for Creating inventory Fields
	 */

	/**
	 * Start Function for Creating pay Process
	 */
	public function automobile_pay_process($values = array()) {

	    $automobile_transaction_fields = $values;
	    extract($values);
	    $automobile_inventory_id = isset($automobile_inventory_id) ? $automobile_inventory_id : '';
	    $automobile_trans_id = isset($automobile_trans_id) ? $automobile_trans_id : '';
	    $automobile_trans_user = isset($automobile_trans_user) ? $automobile_trans_user : '';
	    $automobile_trans_pkg = isset($automobile_trans_package) ? $automobile_trans_package : '';
	    $automobile_trans_featured = isset($automobile_trans_featured) && $automobile_trans_featured == 'on' ? 'yes' : 'no';
	    $automobile_trans_amount = isset($automobile_trans_amount) ? $automobile_trans_amount : '';
	    $automobile_trans_pkg_expiry = isset($automobile_trans_pkg_expiry) ? $automobile_trans_pkg_expiry : '';
	    $automobile_trans_list_num = isset($automobile_trans_list_num) ? $automobile_trans_list_num : '';
	    $automobile_trans_list_expiry = isset($automobile_trans_list_expiry) ? $automobile_trans_list_expiry : '';
	    $automobile_trans_list_period = isset($automobile_trans_list_period) ? $automobile_trans_list_period : '';
	    $post_author = $automobile_trans_user;
	    $transaction_post = array(
		'post_title' => '#' . $automobile_trans_id,
		'post_status' => 'publish',
		'post_author' => $post_author,
		'post_type' => 'cs-transactions',
		'post_date' => current_time('Y-m-d H:i:s')
	    );
	    //insert the transaction
	    $trans_id = wp_insert_post($transaction_post);
	    $automobile_trans_pay_method = '';
	    if (isset($_POST['automobile_payment_gateway']) && $_POST['automobile_payment_gateway'] == 'AUTOMOBILE_PRE_BANK_TRANSFER') {
		$automobile_trans_pay_method = 'AUTOMOBILE_PRE_BANK_TRANSFER';
	    }
	    $automobile_trans_array = array(
		'inventory_id' => $automobile_inventory_id,
		'transaction_id' => $automobile_trans_id,
		'transaction_user' => $automobile_trans_user,
		'transaction_feature' => $automobile_trans_featured,
		'transaction_package' => $automobile_trans_pkg,
		'transaction_amount' => $automobile_trans_amount,
		'transaction_pay_method' => $automobile_trans_pay_method,
		'transaction_expiry_date' => $automobile_trans_pkg_expiry,
		'transaction_listings' => $automobile_trans_list_num,
		'transaction_listing_expiry' => $automobile_trans_list_expiry,
		'transaction_listing_period' => $automobile_trans_list_period,
	    );

	    if ($automobile_trans_amount <= 0) {
		$automobile_trans_array['transaction_status'] = 'approved';
	    }

	    foreach ($automobile_trans_array as $trans_key => $trans_val) {
		update_post_meta($trans_id, "automobile_{$trans_key}", $trans_val);
	    }
	    // Make inventory ids clear if query direct from packages element
	    if ($automobile_inventory_id == $automobile_trans_pkg) {
		update_post_meta($trans_id, 'automobile_inventory_id', '');
	    }
	    $automobile_transaction_fields['automobile_order_id'] = $trans_id;

	    if ($automobile_trans_amount > 0) {

		if (isset($_POST['automobile_payment_gateway']) && $_POST['automobile_payment_gateway'] == 'AUTOMOBILE_PAYPAL_GATEWAY' && !empty($automobile_transaction_fields)) {
		    $paypal_gateway = new AUTOMOBILE_PAYPAL_GATEWAY();
		    $paypal_gateway->automobile_proress_request($automobile_transaction_fields);
		} else if (isset($_POST['automobile_payment_gateway']) && $_POST['automobile_payment_gateway'] == 'AUTOMOBILE_AUTHORIZEDOTNET_GATEWAY' && !empty($automobile_transaction_fields)) {
		    $authorizedotnet = new AUTOMOBILE_AUTHORIZEDOTNET_GATEWAY();
		    $authorizedotnet->automobile_proress_request($automobile_transaction_fields);
		} else if (isset($_POST['automobile_payment_gateway']) && $_POST['automobile_payment_gateway'] == 'AUTOMOBILE_SKRILL_GATEWAY' && !empty($automobile_transaction_fields)) {
		    $skrill = new AUTOMOBILE_SKRILL_GATEWAY();
		    $skrill->automobile_proress_request($automobile_transaction_fields);
		} else if (isset($_POST['automobile_payment_gateway']) && $_POST['automobile_payment_gateway'] == 'AUTOMOBILE_PRE_BANK_TRANSFER' && !empty($automobile_transaction_fields)) {
		    $banktransfer = new AUTOMOBILE_PRE_BANK_TRANSFER();
		    return $banktransfer->automobile_proress_request($automobile_transaction_fields);
		} else {
		    // Do Nothing
		}
	    }
	}

	/**
	 * End Function for Creating pay Process
	 */

	/**
	 * Start Function for how to get package Fields
	 */
	public function get_pkg_field($automobile_pkg_id = '', $automobile_pkg_field = 'package_title') {
	    global $automobile_var_plugin_options;
	    $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';
	    if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
		$automobile_user_package = isset($automobile_packages_options[$automobile_pkg_id]) ? $automobile_packages_options[$automobile_pkg_id] : '';
		$automobile_pkg_field = isset($automobile_user_package[$automobile_pkg_field]) ? $automobile_user_package[$automobile_pkg_field] : '';
		return $automobile_pkg_field;
	    }
	}

	/**
	 * End Function for how to get package Fields
	 */

	/**
	 * Start Function for how to Date Duration posting
	 */
	public function automobile_date_conv($automobile_duration, $automobile_format) {
	    if ($automobile_format == "days") {
		$automobile_adexp = date('Y-m-d H:i:s', strtotime("+" . $automobile_duration . " days"));
	    } elseif ($automobile_format == "months") {
		$automobile_adexp = date('Y-m-d H:i:s', strtotime("+" . $automobile_duration . " months"));
	    } elseif ($automobile_format == "years") {
		$automobile_adexp = date('Y-m-d H:i:s', strtotime("+" . $automobile_duration . " years"));
	    } else {
		$automobile_adexp = '';
	    }
	    return $automobile_adexp;
	}

	/**
	 * End Function for how to Date Duration posting
	 */

	/**
	 * Start Function how to get post id with the help of Meta key
	 */
	public function automobile_get_post_id_by_meta_key($key, $value) {
	    global $wpdb;
	    $meta = $wpdb->get_results("SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $key . "' AND meta_value='" . $value . "'");
	    if (is_array($meta) && !empty($meta) && isset($meta[0])) {
		$meta = $meta[0];
	    }
	    if (is_object($meta)) {
		return $meta->post_id;
	    } else {
		return false;
	    }
	}

	/**
	 * End Function how to get post id with the help of Meta key
	 */

	/**
	 * Start Function how to get Ramaining Listing in inventory Packages
	 */
	public function automobile_pkg_remaining_listing($automobile_inventory_pkg_names = '', $automobile_transaction_id = 0) {
	    global $post, $current_user, $automobile_var_plugin_options;
	    $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';
	    $html = '';
	    $trans_post_id = $this->automobile_get_post_id_by_meta_key("automobile_transaction_id", $automobile_transaction_id);
	    $automobile_inventory_post_ids = get_post_meta($trans_post_id, "automobile_inventory_id", true);
	    $automobile_inventory_post_ids = explode(',', $automobile_inventory_post_ids);
	    if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
		if (isset($automobile_packages_options[$automobile_inventory_pkg_names])) {
		    $automobile_user_package = $automobile_packages_options[$automobile_inventory_pkg_names];
		    $automobile_package = isset($automobile_user_package['package_id']) ? $automobile_user_package['package_id'] : '';
		    $automobile_pkg_lists = get_post_meta($trans_post_id, 'automobile_transaction_listings', true);
		    if (isset($automobile_inventory_post_ids[0]) && $automobile_inventory_post_ids[0] == '')
			unset($automobile_inventory_post_ids[0]);
		    if (is_array($automobile_inventory_post_ids) && sizeof($automobile_inventory_post_ids) > 0) {
			if ((int) $automobile_pkg_lists > (int) sizeof($automobile_inventory_post_ids)) {
			    return (int) $automobile_pkg_lists - (int) sizeof($automobile_inventory_post_ids);
			}
		    } else {
			return (int) $automobile_pkg_lists;
		    }
		}
	    }
	    return 0;
	}

	/**
	 * End Function how to get Ramaining Listing in inventory Packages
	 */

	/**
	 * Start Function how update Submission CV's
	 */
	public function automobile_update_pkg_subs($return_pkg = false, $automobile_pckg = '') {
	    global $automobile_var_plugin_options;
	    $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';
	    if ($automobile_pckg != '' && $this->automobile_is_pkg_subscribed($automobile_pckg)) {
		if ($return_pkg == true) {
		    $automobile_trans_id = $this->automobile_is_pkg_subscribed($automobile_pckg, true);
		    return array('pkg_id' => $automobile_pckg, 'trans_id' => $automobile_trans_id);
		}
		return true;
	    }
	    return false;
	}

	/**
	 * End Function how update Submission CV's
	 */

	/**
	 * Start Function how to find for Subscribers for Current User
	 */
	public function automobile_is_pkg_subscribed($automobile_package = '', $return_trans = false) {
	    global $post, $current_user;
	    $automobile_emp_funs = new automobile_dealer_functions();
	    $automobile_current_date = strtotime(date('d-m-Y'));
	    $args = array(
		'posts_per_page' => "-1",
		'post_type' => 'cs-transactions',
		'post_status' => 'publish',
		'meta_query' => array(
		    'relation' => 'AND',
		    array(
			'key' => 'automobile_transaction_package',
			'value' => $automobile_package,
			'compare' => '=',
		    ),
		    array(
			'key' => 'automobile_transaction_user',
			'value' => $current_user->ID,
			'compare' => '=',
		    ),
		    array(
			'key' => 'automobile_transaction_expiry_date',
			'value' => $automobile_current_date,
			'compare' => '>',
		    ),
		    array(
			'key' => 'automobile_transaction_status',
			'value' => 'approved',
			'compare' => '=',
		    ),
		),
	    );
	    $custom_query = new WP_Query($args);
	    $automobile_trans_count = $custom_query->post_count;
	    $automobile_trnasaction_id = 0;
	    $automobile_trans_counter = 0;
	    if ($automobile_trans_count > 0) {
		while ($custom_query->have_posts()) : $custom_query->the_post();
		    $automobile_pkg_list_num = get_post_meta(get_the_id(), 'automobile_transaction_listings', true);
		    $automobile_inventory_ids = get_post_meta(get_the_id(), 'automobile_inventory_id', true);
		    $automobile_inventory_ids = explode(',', $automobile_inventory_ids);
		    $automobile_ids_num = 0;
		    if (isset($automobile_inventory_ids[0]) && $automobile_inventory_ids[0] == '')
			unset($automobile_inventory_ids[0]);
		    $automobile_ids_num = sizeof($automobile_inventory_ids);
		    if ((int) $automobile_ids_num < (int) $automobile_pkg_list_num) {
			$automobile_trnasaction_id = get_the_id();
		    }
		    $automobile_trans_counter++;
		endwhile;
	    }
	    if ($automobile_trans_counter > 0 && isset($automobile_trnasaction_id) && $automobile_trnasaction_id != '') {
		$automobile_trnasaction_id = get_post_meta($automobile_trnasaction_id, 'automobile_transaction_id', true);
		if ($this->automobile_pkg_remaining_listing($automobile_package, $automobile_trnasaction_id) > 0) {
		    if ($return_trans == true) {
			return $automobile_trnasaction_id;
		    }
		    return true;
		}
	    }
	    return false;
	}

	/**
	 * Start Function how to find Expire Packages
	 */
	public function automobile_expire_pkgs_id() {
	    global $post, $current_user;
	    $trans_array1 = $trans_array2 = array();
	    $automobile_emp_funs = new automobile_dealer_functions();
	    $automobile_current_date = strtotime(date('d-m-Y'));
	    $args = array(
		'posts_per_page' => "-1",
		'post_type' => 'cs-transactions',
		'post_status' => 'publish',
		'meta_query' => array(
		    'relation' => 'AND',
		    array(
			'key' => 'automobile_transaction_package',
			'value' => '',
			'compare' => '!=',
		    ),
		    array(
			'key' => 'automobile_transaction_user',
			'value' => $current_user->ID,
			'compare' => '=',
		    ),
		    array(
			'key' => 'automobile_transaction_expiry_date',
			'value' => $automobile_current_date,
			'compare' => '<=',
		    ),
		    array(
			'key' => 'automobile_transaction_status',
			'value' => 'approved',
			'compare' => '=',
		    ),
		),
	    );
	    $custom_query = new WP_Query($args);
	    $automobile_trans_count = $custom_query->post_count;
	    if ($automobile_trans_count > 0) {
		while ($custom_query->have_posts()) : $custom_query->the_post();
		    $trans_array1[] = get_the_id();
		endwhile;
		wp_reset_postdata();
	    }
	    $args = array(
		'posts_per_page' => "-1",
		'post_type' => 'cs-transactions',
		'post_status' => 'publish',
		'meta_query' => array(
		    'relation' => 'AND',
		    array(
			'key' => 'automobile_transaction_package',
			'value' => '',
			'compare' => '!=',
		    ),
		    array(
			'key' => 'automobile_transaction_user',
			'value' => $current_user->ID,
			'compare' => '=',
		    ),
		    array(
			'key' => 'automobile_transaction_expiry_date',
			'value' => $automobile_current_date,
			'compare' => '>',
		    ),
		    array(
			'key' => 'automobile_transaction_status',
			'value' => 'approved',
			'compare' => '=',
		    ),
		),
	    );
	    $custom_query = new WP_Query($args);
	    $automobile_trans_count = $custom_query->post_count;
	    if ($automobile_trans_count > 0) {
		while ($custom_query->have_posts()) : $custom_query->the_post();
		    $automobile_inventory_ids = get_post_meta(get_the_id(), 'automobile_inventory_id', true);
		    $automobile_package = get_post_meta(get_the_id(), 'automobile_transaction_package', true);
		    $automobile_pkg_list_num = get_post_meta(get_the_id(), 'automobile_transaction_listings', true);
		    $automobile_inventory_ids = explode(',', $automobile_inventory_ids);
		    $automobile_ids_num = 0;

		    if (isset($automobile_inventory_ids[0]) && $automobile_inventory_ids[0] == '')
			unset($automobile_inventory_ids[0]);
		    $automobile_ids_num = sizeof($automobile_inventory_ids);
		    if ((int) $automobile_ids_num == (int) $automobile_pkg_list_num) {
			$automobile_trnasaction_id = get_the_id();
			if ($automobile_trnasaction_id != '') {
			    $automobile_trnasaction_id = get_post_meta($automobile_trnasaction_id, 'automobile_transaction_id', true);
			    if ($this->automobile_pkg_remaining_listing($automobile_package, $automobile_trnasaction_id) == 0) {
				$trans_array2[] = get_the_id();
			    }
			}
		    }
		endwhile;
		wp_reset_postdata();
	    }
	    $trans_array = array_merge($trans_array1, $trans_array2);
	    return $trans_array;
	}

	/**
	 * End Function how to find Expire Packages
	 */

	/**
	 * Start Function how to find Expire for Transaction
	 */
	public function automobile_expire_pkgs($automobile_trans) {
	    $stringObj = new automobile_plugin_all_strings();
	    $stringObj->automobile_var_plugin_option_strings();
	    global $automobile_var_plugin_options, $automobile_var_plugin_static_text;
	    $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';
	    $automobile_transac_id = get_post_meta($automobile_trans, 'automobile_transaction_id', true);
	    $automobile_transac_pkg = get_post_meta($automobile_trans, 'automobile_transaction_package', true);
	    $automobile_transac_expiry = get_post_meta($automobile_trans, 'automobile_transaction_expiry_date', true);
	    $html = '';
	    $automobile_package_title = $this->get_pkg_field($automobile_transac_pkg);
	    $automobile_user_package = isset($automobile_packages_options[$automobile_transac_pkg]) ? $automobile_packages_options[$automobile_transac_pkg] : '';
	    $automobile_pkg_listings = get_post_meta($automobile_trans, 'automobile_transaction_listings', true);
	    $automobile_package_type = isset($automobile_user_package['package_type']) ? $automobile_user_package['package_type'] : '';
	    $automobile_listing_left = $this->automobile_pkg_remaining_listing($automobile_transac_pkg, $automobile_transac_id);
	    $automobile_ads_used = ($automobile_pkg_listings > 0 && $automobile_pkg_listings > $automobile_listing_left) ? ($automobile_pkg_listings - $automobile_listing_left) : '0';
	    if ($automobile_transac_expiry != '') {
		$automobile_transac_expiry = date_i18n(get_option('date_format'), $automobile_transac_expiry);
	    }

	    $html .= '<li><Strong>' . $automobile_package_title . '</strong><em>' . automobile_var_plugin_text_srt('automobile_var_expire') . '</em></li>';
	    $html .= '<li>#' . $automobile_transac_id . '</li>';
	    $html .= '<li>' . $automobile_transac_expiry . '</li>';
	    if ($automobile_package_type == 'subscription') {
		$html .= '<li>' . $automobile_pkg_listings . '</li>';
		$html .= '<li>' . $automobile_ads_used . '</li>';
		$html .= '<li>' . $automobile_listing_left . '</li>';
	    } else {
		$html .= '<li colspan="3">' . automobile_var_plugin_text_srt('automobile_var_single_submission') . '</li>';
	    }

	    return $html;
	}

	/**
	 * End Function how to find Expire for Transaction
	 */

	/**
	 * Start Function how to find User pakcakge Details
	 */
	function automobile_user_pkg_detail($automobile_pkg, $automobile_ad_expiry = '', $automobile_profile = false) {
	    $stringObj = new automobile_plugin_all_strings();
	    $stringObj->automobile_var_plugin_option_strings();
	    global $automobile_var_plugin_options, $automobile_var_plugin_static_text;
	    $automobile_var_expiry = automobile_var_plugin_text_srt('automobile_var_expiry');
	    $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';


	    $html = '';
	    if (is_array($automobile_pkg) && isset($automobile_pkg['pkg_id']) && isset($automobile_pkg['trans_id'])) {
		if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
		    $automobile_listing_left = $this->automobile_pkg_remaining_listing($automobile_pkg['pkg_id'], $automobile_pkg['trans_id']);
		    $trans_post_id = $this->automobile_get_post_id_by_meta_key("automobile_transaction_id", $automobile_pkg['trans_id']);
		    $automobile_transac_expiry = get_post_meta($trans_post_id, 'automobile_transaction_expiry_date', true);
		    $automobile_user_package = $automobile_packages_options[$automobile_pkg['pkg_id']];
		    $automobile_package_title = isset($automobile_user_package['package_title']) ? $automobile_user_package['package_title'] : '';
		    $automobile_pkg_listings = get_post_meta($trans_post_id, 'automobile_transaction_listings', true);
		    $automobile_package_type = isset($automobile_user_package['package_type']) ? $automobile_user_package['package_type'] : '';
		    $automobile_ads_used = ($automobile_pkg_listings > 0 && $automobile_pkg_listings > $automobile_listing_left) ? ($automobile_pkg_listings - $automobile_listing_left) : '0';
		    if ($automobile_transac_expiry != '') {
			$automobile_transac_expiry = date_i18n(get_option('date_format'), $automobile_transac_expiry);
		    }
		    if ($automobile_profile == true) {
			$html .= '<li><strong>' . $automobile_package_title . '</strong><em>' . automobile_var_plugin_text_srt('automobile_var_active') . '</em></li>';
			$html .= '<li>#' . $automobile_pkg['trans_id'] . '</li>';

			$html .= '<li>' . $automobile_transac_expiry . '</li>';
			if ($automobile_package_type == 'subscription') {
			    $html .= '<li>' . $automobile_pkg_listings . '</li>';
			    $html .= '<li>' . $automobile_ads_used . '</li>';
			    $html .= '<li>' . $automobile_listing_left . '</li>';
			} else {
			    $html .= '<li colspan="3">' . automobile_var_plugin_text_srt('automobile_var_single_submission') . '</li>';
			}
		    } else {
			$html .= '<div class="cs-subscription-box">';
			$html .= '<div class="cs-subscription-head">
                                        <h4>' . automobile_var_plugin_text_srt('automobile_var_subscription_details') . '</h4>
                                  </div>';
			$html .= '<ul>';
			$html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_transactions') . ' </span> <span class="subs-value">#' . $automobile_pkg['trans_id'] . '</span></li>';
			$html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_packages') . ' </span> <span class="subs-value">' . $automobile_package_title . '</span></li>';
			$html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_expiry') . ' </span> <span class="subs-value">' . $automobile_transac_expiry . '</span></li>';
			if ($automobile_package_type == 'subscription') {
			    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_total_inventory') . ' </span> <span class="subs-value">' . $automobile_pkg_listings . '</span></li>';
			    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_used') . ' </span> <span class="subs-value">' . $automobile_ads_used . '</span></li>';
			    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_remaning') . ' </span> <span class="subs-value">' . $automobile_listing_left . '</span></li>';
			} else {
			    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_submissions') . ' </span> <span class="subs-value">' . automobile_var_plugin_text_srt('automobile_var_single_submission') . '</span></li>';
			}
			$html .= '</ul>';
			$html .= '</div>';
		    }
		}
	    } else {
		if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
		    $automobile_user_package = $automobile_packages_options[$automobile_pkg];
		    $automobile_package_title = isset($automobile_user_package['package_title']) ? $automobile_user_package['package_title'] : '';
		    if ($automobile_ad_expiry != '') {
			$automobile_ad_expiry = date_i18n(get_option('date_format'), $automobile_ad_expiry);
		    }
		    $html .= '<div class="cs-subscription-box">';
		    $html .= '<div class="cs-subscription-head">
                                <h4>' . automobile_var_plugin_text_srt('automobile_var_subscription_details') . '</h4>
                            </div>';
		    $html .= '<ul>';
		    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_packages') . ' </span> <span class="subs-value">' . $automobile_package_title . '</span></li>';
		    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_ad_expiry') . ' </span> <span class="subs-value">' . $automobile_ad_expiry . '</span></li>';
		    $html .= '</ul>';
		    $html .= '</div>';
		}
	    }
	    return $html;
	}

	/**
	 * End Function how to find User pakcakge Details
	 */

	/**
	 * Start Function how to find Subscriber Summary
	 */
	public function automobile_subscribed_pkg_summary($automobile_inventory_pkg_names = '') {
	    $stringObj = new automobile_plugin_all_strings();
	    $stringObj->automobile_var_plugin_option_strings();
	    global $automobile_var_plugin_static_text;

	    $html = '';
	    if ($this->automobile_is_pkg_subscribed($automobile_inventory_pkg_names)) {
		$automobile_trans_id = $this->automobile_is_pkg_subscribed($automobile_inventory_pkg_names, true);
		$automobile_pkg_title = $this->get_pkg_field($automobile_inventory_pkg_names);
		$automobile_trans_post_id = $this->automobile_get_post_id_by_meta_key("automobile_transaction_id", $automobile_trans_id);
		$automobile_pkg_listings = get_post_meta($automobile_trans_post_id, 'automobile_transaction_listings', true);
		$automobile_listing_left = $this->automobile_pkg_remaining_listing($automobile_inventory_pkg_names, $automobile_trans_id);
		$automobile_package_type = $this->get_pkg_field($automobile_inventory_pkg_names, 'package_type');
		$automobile_used_listings = ($automobile_pkg_listings > 0 && $automobile_pkg_listings > $automobile_listing_left) ? ($automobile_pkg_listings - $automobile_listing_left) : '0';
		$html .= '<div class="cs-subscription-box">';
		$html .= '<div class="cs-subscription-head">
                            <h4>' . automobile_var_plugin_text_srt('automobile_var_subscription_details') . '</h4>
                        </div>';
		$html .= '<ul>';
		$html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_transactions') . ' </span> <span class="subs-value">#' . $automobile_trans_id . '</span></li>';
		$html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_packages') . ' </span> <span class="subs-value">' . $automobile_pkg_title . '</span></li>';
		if ($automobile_package_type == 'subscription') {
		    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_total_inventory') . ' </span> <span class="subs-value">' . $automobile_pkg_listings . '</span></li>';
		    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_used') . ' </span> <span class="subs-value">' . $automobile_used_listings . '</span></li>';
		    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_remaning') . ' </span> <span class="subs-value">' . $automobile_listing_left . '</span></li>';
		} else {
		    $html .= '<li><span class="subs-title">' . automobile_var_plugin_text_srt('automobile_var_submissions') . ' </span> <span class="subs-value">' . automobile_var_plugin_text_srt('automobile_var_single_submission') . '</span></li>';
		}
		$html .= '</ul>';
		$html .= '</div>';
	    }
	    return $html;
	}

	/**
	 * End Function how to find Subscriber Summary
	 */

	/**
	 * Start Function how to find inventory Expiry
	 */
	public function automobile_inventory_expiry($automobile_pkg_id = '') {
	    if ($automobile_pkg_id != '') {
		$automobile_list_expiry = $this->get_pkg_field($automobile_pkg_id, 'package_submission_limit');
		$automobile_list_dur = $this->get_pkg_field($automobile_pkg_id, 'automobile_list_dur');
		$automobile_inventory_expiry = $this->automobile_date_conv($automobile_list_expiry, $automobile_list_dur);
		return $automobile_inventory_expiry;
	    }
	}

	/**
	 * End Function how to find inventory Expiry
	 */

	/**
	 * Start Function for inventory Delete
	 */
	public function automobile_inventory_delete() {
	    global $current_user;
	    $automobile_jd_id = isset($_POST['u_id']) ? $_POST['u_id'] : '';
	    if ($automobile_jd_id != '') {
		$automobile_jb_emplyr = get_post_meta((int) $automobile_jd_id, 'automobile_inventory_username', true);
		if ($automobile_jb_emplyr == (string) $current_user->ID) {
		    update_post_meta($automobile_jd_id, 'automobile_inventory_status', 'delete');
		    update_post_meta($automobile_jd_id, 'automobile_inventory_expired', strtotime(date("d-m-Y", strtotime('-1 days'))));
		}
		echo '<i class="icon-trash"></i>';
	    }
	    die();
	}

	/**
	 * End Function for inventory Delete
	 */

	/**
	 * Start Function for inventory update Status
	 */
	public function automobile_inventory_status_update() {
	    global $current_user, $automobile_var_plugin_static_text;
	    $response = '';
	    $automobile_jd_id = isset($_POST['automobile_inventoryid']) ? $_POST['automobile_inventoryid'] : '';
	    $automobile_status = isset($_POST['automobile_status']) ? $_POST['automobile_status'] : '';
	    if ($automobile_jd_id != '' && $automobile_status != '' && ($automobile_status == 'active' || $automobile_status == 'inactive')) {
		$automobile_jb_emplyr = get_post_meta((int) $automobile_jd_id, 'automobile_inventory_username', true);
		$automobile_inventory_status = get_post_meta((int) $automobile_jd_id, 'automobile_inventory_status', true);
		$automobile_inventory_expired = get_post_meta((int) $automobile_jd_id, "automobile_inventory_expired", true);
		// check allow user to change status
		$inventory_status_link_allow = 1;
		if ($automobile_inventory_status != 'active' && $automobile_inventory_status != 'inactive') // check staus diffrent 
		    $inventory_status_link_allow = 0;
		if ($automobile_inventory_expired < time()) // check inventory expire
		    $inventory_status_link_allow = 0;
		if ($automobile_jb_emplyr != (string) $current_user->ID)
		    $inventory_status_link_allow = 0;
		if ($inventory_status_link_allow == 1) {
		    update_post_meta($automobile_jd_id, 'automobile_inventory_status', $automobile_status);
		    if ($automobile_status == 'inactive') {
			$response['icon'] = '<i class="icon-eye-slash"></i>';
		    } else if ($automobile_status == 'active') {
			$response['icon'] = '<i class="icon-eye3"></i>';
		    }
		    $response['error'] = 0;
		    $response['message'] = automobile_var_plugin_text_srt('automobile_var_changed_inventory');
		} else {
		    $response['error'] = 1;
		    $response['message'] = automobile_var_plugin_text_srt('automobile_var_not_authorized');
		}
	    } else {
		$response['error'] = 1;
		$response['message'] = automobile_var_plugin_text_srt('automobile_var_not_authorized');
	    }
	    echo json_encode($response);
	    die();
	}

	/**
	 * End Function for inventory update Status
	 */

	/**
	 * Start Function for Checking Employeer
	 */
	public function automobile_emp_check() {
	    global $automobile_var_plugin_static_text;
	    $automobile_uid = isset($_POST['uid']) ? $_POST['uid'] : '';
	    if ($automobile_uid != '') {
		if (!$this->is_dealer()) {
		    echo automobile_var_plugin_text_srt('automobile_var_become_dealer');
		}
	    }
	    die();
	}

	/**
	 * end Function for Checking Employeer
	 */

	/**
	 * Start Function for Time elapsed
	 */
	public function automobile_time_elapsed($ptime) {
	    global $automobile_var_plugin_static_text;
	    $etime = time() - strtotime($ptime);
	    if ($etime < 1) {
		return '0 seconds';
	    }
	    $a = array(365 * 24 * 60 * 60 => 'year',
		30 * 24 * 60 * 60 => 'month',
		24 * 60 * 60 => 'day',
		60 * 60 => 'hour',
		60 => 'minute',
		1 => 'second'
	    );
	    $a_plural = array('year' => 'years',
		'month' => 'months',
		'day' => 'days',
		'hour' => 'hours',
		'minute' => 'minutes',
		'second' => 'seconds'
	    );
	    foreach ($a as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1) {
		    $r = round($d);
		    return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . automobile_var_plugin_text_srt('automobile_var_ago');
		}
	    }
	}

	/**
	 * end Function for Time elapsed
	 */

	/**
	 * Start Function for posting inventory number
	 */
	public function posted_inventory_num($uid) {
	    $args = array(
		'posts_per_page' => "-1",
		'post_type' => 'inventory',
		'post_status' => 'publish',
		'meta_query' => array(
		    'relation' => 'AND',
		    array(
			'key' => 'automobile_inventory_username',
			'value' => $uid,
			'compare' => '=',
		    ),
		    array(
			'key' => 'automobile_inventory_status',
			'value' => 'delete',
			'compare' => '!=',
		    ),
		),
		'orderby' => 'ID',
		'order' => 'DESC',
	    );

	    $custom_query = new WP_Query($args);
	    return $custom_query->post_count;
	}

	/**
	 * end Function for posting inventory number
	 */

	/**
	 * Start Function for how many inventory are active
	 */
	public function active_inventory_num($uid) {
	    $args = array(
		'posts_per_page' => "-1",
		'post_type' => 'inventory',
		'post_status' => 'publish',
		'meta_query' => array(
		    'relation' => 'AND',
		    array(
			'key' => 'automobile_inventory_username',
			'value' => $uid,
			'compare' => '=',
		    ),
		    array(
			'key' => 'automobile_inventory_status',
			'value' => 'active',
			'compare' => '=',
		    ),
		),
		'orderby' => 'ID',
		'order' => 'DESC',
	    );

	    $custom_query = new WP_Query($args);

	    return $custom_query->post_count;
	}

	// Start function to check user role as a dealer 

	public function is_dealer() {

	    global $current_user;
	    $user_role = automobile_get_loginuser_role();
	    if (isset($user_role) && $user_role <> '' && $user_role == 'automobile_dealer') {
		return true;
	    }
	    return false;
	}

	// start function to set user favourite 

	public function automobile_set_user_fav($new_id = '') {

	    global $current_user;

	    $automobile_fav_ids = 'automobile_user_fav_' . $current_user->ID;

	    if ($new_id != '') {

		$exist_vals = '';
		if (isset($_COOKIE[$automobile_fav_ids])) {
		    $exist_vals = $_COOKIE[$automobile_fav_ids];
		}

		$ids_array = explode(',', $exist_vals);

		if (is_array($ids_array) && !in_array($new_id, $ids_array)) {

		    if ($ids_array[0] != '') {
			$ids_array[] = $new_id;
		    } else {
			$ids_array = array($new_id);
		    }
		}

		$ids_array = implode(',', $ids_array);

		if (isset($_COOKIE[$automobile_fav_ids])) {

		    unset($_COOKIE[$automobile_fav_ids]);
		    setcookie($automobile_fav_ids, null, -1, '/');
		}

		setcookie($automobile_fav_ids, $ids_array, time() + 86400, '/');
	    }
	}

	/**
	 * Start Function for doing unset user
	 */
	public function automobile_unset_user_fav() {
	    global $current_user;
	    $automobile_return = array();
	    $rem_id = isset($_POST['automobile_id']) && $_POST['automobile_id'] != '' ? $_POST['automobile_id'] : '';
	    $automobile_fav_ids = 'automobile_user_fav_' . $current_user->ID;
	    $automobile_return['count'] = '';
	    if ($rem_id != '') {
		$exist_vals = '';
		if (isset($_COOKIE[$automobile_fav_ids])) {
		    $exist_vals = $_COOKIE[$automobile_fav_ids];
		}
		$ids_array = explode(',', $exist_vals);

		if (is_array($ids_array) && in_array($rem_id, $ids_array)) {

		    if (( $key = array_search($rem_id, $ids_array) ) !== false) {
			unset($ids_array[$key]);
		    }
		}
		$automobile_return['count'] = sizeof($ids_array);
		$ids_array = implode(',', $ids_array);
		if (isset($_COOKIE[$automobile_fav_ids])) {
		    unset($_COOKIE[$automobile_fav_ids]);
		    setcookie($automobile_fav_ids, null, -1, '/');
		}
		setcookie($automobile_fav_ids, $ids_array, time() + 86400, '/');
	    }
	    echo json_encode($automobile_return);
	    die;
	}

	/**
	 * End Function for doing unset user
	 */

	/**
	 * Start Function finding header favorites
	 */
	public function automobile_header_favorites() {
	    global $current_user;
	    if (!is_user_logged_in()) {
		/*
		  echo '<div class="wish-list">
		  <a><i class="icon-heart6"></i></a> <em class="cs-bgcolor" id="cs-fav-counts">0</em>
		  </div>';
		 * 
		 */
	    } else if (is_user_logged_in() && $this->is_dealer()) {
		$automobile_fav_ids = 'automobile_user_fav_' . $current_user->ID;
		$exist_vals = '';
		if (isset($_COOKIE[$automobile_fav_ids])) {
		    $exist_vals = $_COOKIE[$automobile_fav_ids];
		}
		if ($exist_vals != '') {
		    $exist_vals = explode(',', $exist_vals);
		    $fav_count = sizeof($exist_vals);
		} else {
		    $fav_count = 0;
		}
		?>
		<!--
		<div class="wish-list"> 
		    <a><i class="icon-heart6"></i></a> <em class="cs-bgcolor" id="cs-fav-counts"><?php echo absint($fav_count) ?></em>
		<?php
		if (is_array($exist_vals) && sizeof($exist_vals) > 0) {
		    ?>
		    					    <div class="recruiter-widget wish-list-dropdown">
		    						<ul class="recruiter-list">
		    <?php
		    foreach ($exist_vals as $ex_val) {

			$automobile_user_img = get_post_meta($ex_val, "user_img", true);
			$automobile_inventory_title = get_post_meta($ex_val, "automobile_inventory_title", true);
			$automobile_loc_address = get_post_meta($ex_val, "automobile_post_loc_address", true);
			?>
																			    <li class="alert alert-dismissible">
																				<button class="close" id="cs-rem-<?php echo absint($ex_val) ?>" onclick="automobile_unset_user_fav('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($ex_val) ?>')"><span>&times;</span></button>
			<?php
			if ($automobile_user_img != '') {
			    $automobile_user_img = automobile_get_img_url($automobile_user_img, 'automobile_var_media_4');
			    ?>
			    																						<a href="<?php echo esc_url(get_the_permalink($ex_val)) ?>"><img src="<?php echo esc_url($automobile_user_img) ?>" alt="" /></a>
			<?php } ?>
																				<div class="cs-info">
																				    <h4><a href="<?php echo esc_url(get_the_permalink($ex_val)) ?>"><?php echo get_the_title($ex_val) ?></a></h4>
			<?php if ($automobile_loc_address != '') { ?>
			    																						    <span class="location"><i class="icon-location6"></i><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_loc_address) ?></span>
			<?php } ?>
																				</div>
																			    </li>
			<?php
		    }
		    ?>

		    						</ul>
		    					    </div>
		    <?php
		}
		?>
		</div>
		-->
		<?php
	    }
	}

	/**
	 * End Function finding header favorites
	 */

	/**
	 * Start Function for geting all inventory application
	 */
	public function all_inventory_apps($uid = '') {
	    $args = array(
		'posts_per_page' => "-1",
		'post_type' => 'inventory',
		'post_status' => 'publish',
		'meta_query' => array(
		    'relation' => 'AND',
		    array(
			'key' => 'automobile_inventory_username',
			'value' => $uid,
			'compare' => '=',
		    ),
		    array(
			'key' => 'automobile_inventory_status',
			'value' => 'delete',
			'compare' => '!=',
		    ),
		),
		'orderby' => 'ID',
		'order' => 'DESC',
	    );
	    $custom_query = new WP_Query($args);

	    $automobile_apps = 0;
	    if ($custom_query->have_posts()) {

		while ($custom_query->have_posts()) : $custom_query->the_post();

		    // getting inventory' application count
		    $automobile_applicants = count_usermeta('cs-user-inventory-applied-list', serialize(strval(get_the_id())), 'LIKE', true);
		    $automobile_apps += count($automobile_applicants);
		endwhile;
	    }
	    return $automobile_apps;
	}

	/**
	 * End Function for geting all inventory application
	 */

	/**
	 * Start Function for how to initilize Editor
	 */
	public function automobile_init_editor() {
	    echo '<div style="display: none;">';
	    wp_editor('', 'automobile_comp_init_detail', array(
		'textarea_name' => 'automobile_comp_init_detail',
		'editor_class' => 'text-input',
		'teeny' => true,
		'media_buttons' => false,
		'textarea_rows' => 4,
		'quicktags' => false
		    )
	    );
	    echo '</div>';
	    ?>
	    <script type="text/javascript">
	        jQuery(document).ready(function (e) {
	    	if (typeof (et_tinyMCEPreInit) == 'undefined') {
	    	    et_tinyMCEPreInit = JSON.stringify(tinyMCEPreInit);
	    	}
	        });
	    </script>
	    <?php
	}

	/**
	 * End Function for how to initilize Editor
	 */

	/**
	 * Start Function for Creating inventory Custom Fields
	 */
	public function automobile_custom_fields($automobile_inventory_id = '') {
	    global $automobile_form_fields;
	    $automobile_html = '';
	    $automobile_inventory_cus_fields = get_option("automobile_inventory_cus_fields");
	    if (is_array($automobile_inventory_cus_fields) && sizeof($automobile_inventory_cus_fields) > 0) {
		foreach ($automobile_inventory_cus_fields as $cus_field) {
		    $automobile_type = isset($cus_field['type']) ? $cus_field['type'] : '';
		    switch ($automobile_type) {
			case('text'):
			    $automobile_label = isset($cus_field['label']) ? $cus_field['label'] : '';
			    $automobile_meta_key = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
			    $automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
			    $automobile_required = isset($cus_field['required']) && $cus_field['required'] == 'yes' ? ' required' : '';
			    $automobile_help_txt = isset($cus_field['help']) ? $cus_field['help'] : '';
			    if ($automobile_inventory_id != '') {
				$automobile_default_val = get_post_meta((int) $automobile_inventory_id, "$automobile_meta_key", true);
			    }
			    $automobile_html .= '
                                        <div class="col-md-6">
                                            <label>asd' . esc_attr($automobile_label) . '</label>';
			    $automobile_opt_array = array(
				'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
				'desc' => '',
				'classes' => 'form-control',
				'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				'std' => $automobile_default_val,
				'id' => isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '',
				'cus_field' => true,
				'return' => true,
			    );

			    if (isset($cus_field['placeholder']) && $cus_field['placeholder'] != '') {
				$automobile_opt_array['extra_atr'] = ' placeholder="' . $cus_field['placeholder'] . '"';
			    }

			    if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				$automobile_opt_array['required'] = 'yes';
			    }

			    $automobile_html .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

			    if ($automobile_help_txt <> '') {
				$automobile_html .= '<span class="cs-caption">' . $automobile_help_txt . '</span>';
			    }
			    $automobile_html .= '	
                                        </div>';
			    break;
			case('textarea'):
			    $automobile_label = isset($cus_field['label']) ? $cus_field['label'] : '';
			    $automobile_rows = isset($cus_field['rows']) ? $cus_field['rows'] : '';
			    $automobile_cols = isset($cus_field['cols']) ? $cus_field['cols'] : '';
			    $automobile_meta_key = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
			    $automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
			    $automobile_required = isset($cus_field['required']) && $cus_field['required'] == 'yes' ? ' required' : '';
			    $automobile_help_txt = isset($cus_field['help']) ? $cus_field['help'] : '';
			    if ($automobile_inventory_id != '') {
				$automobile_default_val = get_post_meta((int) $automobile_inventory_id, "$automobile_meta_key", true);
			    }
			    $automobile_html .= '
                                        <div class="col-md-6">
                                            <label>' . esc_attr($automobile_label) . '</label>';

			    $automobile_opt_array = array(
				'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
				'desc' => '',
				'classes' => 'form-control',
				'extra_atr' => 'rows="' . $automobile_rows . '" cols="' . $automobile_cols . '"',
				'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				'std' => $automobile_default_val,
				'id' => isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '',
				'cus_field' => true,
				'return' => true,
			    );

			    if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				$automobile_opt_array['required'] = 'yes';
			    }

			    $automobile_html .= $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);

			    if ($automobile_help_txt <> '') {
				$automobile_html .= '<span class="cs-caption">' . $automobile_help_txt . '</span>';
			    }
			    $automobile_html .= '	
                                        </div>';
			    break;
			case('dropdown'):
			    $automobile_label = isset($cus_field['label']) ? $cus_field['label'] : '';
			    $automobile_meta_key = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
			    $automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
			    $automobile_required = isset($cus_field['required']) && $cus_field['required'] == 'yes' ? ' required' : '';
			    $automobile_help_txt = isset($cus_field['help']) ? $cus_field['help'] : '';

			    if ($automobile_inventory_id != '') {
				$automobile_default_val = get_post_meta((int) $automobile_inventory_id, "$automobile_meta_key", true);
			    }
			    $automobile_dr_name = ' name="automobile_cus_field[' . sanitize_html_class($automobile_meta_key) . ']"';
			    $automobile_dr_mult = '';
			    if (isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes') {
				$automobile_dr_name = ' name="automobile_cus_field[' . sanitize_html_class($automobile_meta_key) . '][]"';
				$automobile_dr_mult = ' multiple="multiple"';
			    }

			    $a_options = array();

			    $automobile_options_mark = '';

			    if (isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0) {
				if (isset($cus_field['first_value']) && $cus_field['first_value'] != '') {
				    $automobile_options_mark .= '<option value="">' . $cus_field['first_value'] . '</option>';
				}
				$automobile_opt_counter = 0;
				foreach ($cus_field['options']['value'] as $automobile_option) {

				    if (isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes') {

					$automobile_checkd = '';
					if (is_array($automobile_default_val) && in_array($automobile_option, $automobile_default_val)) {
					    $automobile_checkd = ' selected="selected"';
					}
				    } else {
					$automobile_checkd = $automobile_option == $automobile_default_val ? ' selected="selected"' : '';
				    }

				    $automobile_opt_label = $cus_field['options']['label'][$automobile_opt_counter];
				    $automobile_options_mark .= '<option value="' . $automobile_option . '"' . $automobile_checkd . '>' . $automobile_opt_label . '</option>';
				    $automobile_opt_counter++;
				}
			    }

			    $automobile_html .= '
							<div class="col-md-6">
								<label>' . esc_attr($automobile_label) . '</label>
								<div class="select-holder">';

			    $automobile_opt_array = array(
				'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
				'desc' => '',
				'classes' => 'chosen-select form-control',
				'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				'std' => $automobile_default_val,
				'id' => isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '',
				'options' => $automobile_options_mark,
				'options_markup' => true,
				'cus_field' => true,
				'return' => true,
			    );

			    if (isset($cus_field['first_value']) && $cus_field['first_value'] != '') {
				$automobile_opt_array['extra_atr'] = ' data-placeholder="' . $cus_field['first_value'] . '"';
			    }

			    if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				$automobile_opt_array['required'] = 'yes';
			    }
			    if (isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes') {
				$automobile_html .= $automobile_form_fields->automobile_form_multiselect_render($automobile_opt_array);
			    } else {
				$automobile_html .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
			    }


			    if ($automobile_help_txt <> '') {
				$automobile_html .= '<span class="cs-caption">' . $automobile_help_txt . '</span>';
			    }
			    $automobile_html .= '	
								</div>
							</div>';
			    break;
			case('date'):
			    $automobile_label = isset($cus_field['label']) ? $cus_field['label'] : '';
			    $automobile_meta_key = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
			    $automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
			    $automobile_required = isset($cus_field['required']) && $cus_field['required'] == 'yes' ? ' required' : '';
			    $automobile_format = isset($cus_field['date_format']) ? $cus_field['date_format'] : 'd-m-Y';
			    $automobile_help_txt = isset($cus_field['help']) ? $cus_field['help'] : '';
			    if ($automobile_inventory_id != '') {
				$automobile_default_val = get_post_meta((int) $automobile_inventory_id, "$automobile_meta_key", true);
			    }

			    $automobile_html .= '
							<div class="col-md-6">
								<label>' . esc_attr($automobile_label) . '</label>';

			    $automobile_opt_array = array(
				'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
				'desc' => '',
				'classes' => 'form-control',
				'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
				'id' => isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '',
				'cus_field' => true,
				'format' => $automobile_format,
				'return' => true,
			    );

			    if (isset($cus_field['placeholder']) && $cus_field['placeholder'] != '') {
				$automobile_opt_array['extra_atr'] = ' placeholder="' . $cus_field['placeholder'] . '"';
			    }

			    if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				$automobile_opt_array['required'] = 'yes';
			    }

			    $automobile_html .= $automobile_form_fields->automobile_form_date_render($automobile_opt_array);

			    if ($automobile_help_txt <> '') {
				$automobile_html .= '<span class="cs-caption">' . $automobile_help_txt . '</span>';
			    }
			    $automobile_html .= '	
					</div>';
			    break;
			case('email'):
			    $automobile_label = isset($cus_field['label']) ? $cus_field['label'] : '';
			    $automobile_meta_key = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
			    $automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
			    $automobile_required = isset($cus_field['required']) && $cus_field['required'] == 'yes' ? ' required' : '';
			    $automobile_help_txt = isset($cus_field['help']) ? $cus_field['help'] : '';
			    if ($automobile_inventory_id != '') {
				$automobile_default_val = get_post_meta((int) $automobile_inventory_id, "$automobile_meta_key", true);
			    }
			    $automobile_html .= '
                                        <div class="col-md-6">
                                            <label>' . esc_attr($automobile_label) . '</label>';
			    $automobile_opt_array = array(
				'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
				'desc' => '',
				'classes' => 'form-control',
				'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				'std' => $automobile_default_val,
				'id' => isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '',
				'cus_field' => true,
				'return' => true,
			    );

			    if (isset($cus_field['placeholder']) && $cus_field['placeholder'] != '') {
				$automobile_opt_array['extra_atr'] = ' placeholder="' . $cus_field['placeholder'] . '"';
			    }

			    if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				$automobile_opt_array['required'] = 'yes';
			    }

			    $automobile_html .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
			    if ($automobile_help_txt <> '') {
				$automobile_html .= '<span class="cs-caption">' . $automobile_help_txt . '</span>';
			    }
			    $automobile_html .= '	
					</div>';
			    break;
			case('url'):
			    $automobile_label = isset($cus_field['label']) ? $cus_field['label'] : '';
			    $automobile_meta_key = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
			    $automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
			    $automobile_required = isset($cus_field['required']) && $cus_field['required'] == 'yes' ? ' required' : '';
			    $automobile_help_txt = isset($cus_field['help']) ? $cus_field['help'] : '';
			    if ($automobile_inventory_id != '') {
				$automobile_default_val = get_post_meta((int) $automobile_inventory_id, "$automobile_meta_key", true);
			    }
			    $automobile_html .= '
                                        <div class="col-md-6">
                                            <label>' . esc_attr($automobile_label) . '</label>';

			    $automobile_opt_array = array(
				'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
				'desc' => '',
				'classes' => 'form-control',
				'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				'std' => $automobile_default_val,
				'id' => isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '',
				'cus_field' => true,
				'return' => true,
			    );

			    if (isset($cus_field['placeholder']) && $cus_field['placeholder'] != '') {
				$automobile_opt_array['extra_atr'] = ' placeholder="' . $cus_field['placeholder'] . '"';
			    }

			    if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				$automobile_opt_array['required'] = 'yes';
			    }

			    $automobile_html .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

			    if ($automobile_help_txt <> '') {
				$automobile_html .= '<span class="cs-caption">' . $automobile_help_txt . '</span>';
			    }
			    $automobile_html .= '	
					</div>';
			    break;
			case('range'):
			    $automobile_label = isset($cus_field['label']) ? $cus_field['label'] : '';
			    $automobile_meta_key = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
			    $automobile_default_val = isset($cus_field['default_value']) ? $cus_field['default_value'] : '';
			    $automobile_required = isset($cus_field['required']) && $cus_field['required'] == 'yes' ? ' required' : '';
			    $automobile_help_txt = isset($cus_field['help']) ? $cus_field['help'] : '';
			    if ($automobile_inventory_id != '') {
				$automobile_default_val = get_post_meta((int) $automobile_inventory_id, "$automobile_meta_key", true);
			    }

			    $automobile_html .= '
                                        <div class="col-md-6">
                                            <label>' . esc_attr($automobile_label) . '</label>';

			    $automobile_opt_array = array(
				'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
				'desc' => '',
				'classes' => 'form-control',
				'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
				'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
				'id' => isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '',
				'cus_field' => true,
				'return' => true,
			    );

			    if (isset($cus_field['placeholder']) && $cus_field['placeholder'] != '') {
				$automobile_opt_array['extra_atr'] = ' placeholder="' . $cus_field['placeholder'] . '"';
			    }

			    if (isset($cus_field['required']) && $cus_field['required'] == 'yes') {
				$automobile_opt_array['required'] = 'yes';
			    }

			    $automobile_html .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

			    if ($automobile_help_txt <> '') {
				$automobile_html .= '<span class="cs-caption">' . $automobile_help_txt . '</span>';
			    }
			    $automobile_html .= '	
                                        </div>';
			    break;
		    }
		}
	    }
	    return $automobile_html;
	}

	/**
	 * End Function for Creating inventory Custom Fields
	 */

	/**
	 * Start Function for how Save form with the Help of Ajax
	 */
	function ajax_dealer_form_save() {
	    global $post, $current_user, $reset_date, $automobile_options, $automobile_var_plugin_static_text;
	    if (isset($_POST['automobile_user']) && $_POST['automobile_user'] <> '') {
		$user_id = $_POST['automobile_user'];

		if (!current_user_can('edit_user', $user_id)) {
		    return false;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		    return;
		}

		$data = array();
		// update email
		if (isset($_POST['user_email'])) {
		    $email_response = wp_update_user(array('ID' => $user_id, 'user_email' => $_POST['user_email']));
		    if (isset($email_response->errors)) {
			echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_already_used'));
			die();
		    }
		}
		// update display name
		if (isset($_POST['display_name'])) {
		    wp_update_user(array('ID' => $user_id, 'display_name' => $_POST['display_name']));
		}
		// update website url
		if (isset($_POST['user_url'])) {
		    wp_update_user(array('ID' => $user_id, 'user_url' => $_POST['user_url']));
		}
		// update first name
		if (isset($_POST['first_name'])) {
		    wp_update_user(array('ID' => $user_id, 'first_name' => $_POST['first_name']));
		}
		// update last name
		if (isset($_POST['last_name'])) {
		    wp_update_user(array('ID' => $user_id, 'last_name' => $_POST['last_name']));
		}

		// description
		if (isset($_POST['comp_detail'])) {
		    wp_update_user(array('ID' => $user_id, 'description' => $_POST['comp_detail']));
		}
		if (isset($_POST['automobile_complete_address'])) {
		    wp_update_user(array('ID' => $user_id, 'automobile_complete_address' => $_POST['automobile_complete_address']));
		}

		foreach ($_POST as $key => $value) {
		    if (strstr($key, 'automobile_')) {
			if ($key == 'automobile_transaction_expiry_date' || $key == 'automobile_inventory_expired' || $key == 'automobile_inventory_posted' || $key == 'automobile_user_last_activity_date') {
			    if ($value == '' || $key == 'automobile_user_last_activity_date') {
				$value = date('d-m-Y H:i:s');
			    }
			    $data[$key] = strtotime($value);
			    update_user_meta($user_id, $key, strtotime($value));
			} else {
			    if ($key == 'automobile_cus_field') {
				if (is_array($value) && sizeof($value) > 0) {
				    foreach ($value as $c_key => $c_val) {
					update_user_meta($user_id, $c_key, $c_val);
				    }
				}
			    } else {
				if ($key == 'automobile_allow_search') {
				    if ($value == 'on') {
					$value = 'yes';
				    } else {
					$value = 'no';
				    }
				}
				$data[$key] = $value;
				update_user_meta($user_id, $key, $value);
			    }
			}
		    }
		}

		update_user_meta($user_id, 'automobile_array_data', $data);

		$automobile_media_image = automobile_user_avatar();


		if ($automobile_media_image == '') {
		    $automobile_media_image = $_POST['automobile_dealer_img'];
		} else {
		    $automobile_prev_img = get_user_meta($current_user->ID, 'user_img', true);
		    automobile_remove_img_url($automobile_prev_img);
		}
		update_user_meta(get_current_user_id(), 'user_img', $automobile_media_image);


		if (isset($_FILES['gallery_user_img']) && !empty($_FILES['gallery_user_img'])) {

		    $gallery_media_upload = user_gallery_multiple('gallery_user_img');
		    $gallery_media_val = isset($_POST['gallery_user_img']) ? $_POST['gallery_user_img'] : '';
		    $gallery_media_val = user_gallery_decoder($gallery_media_val);
		    if (is_array($gallery_media_val) && sizeof($gallery_media_val) > 0) {
			$gallery_media_upload = array_merge($gallery_media_val, $gallery_media_upload);
		    }
		    update_user_meta($user_id, 'gallery_user_img', $gallery_media_upload);
		} else {
		    $gallery_media_upload = isset($_POST['gallery_user_img']) ? $_POST['gallery_user_img'] : '';
		    $gallery_media_val = user_gallery_decoder($gallery_media_upload);
		    update_user_meta($user_id, 'gallery_user_img', $gallery_media_val);
		}


		echo automobile_var_plugin_text_srt('automobile_var_update_successfully');
	    } else {
		echo automobile_var_plugin_text_srt('automobile_var_save_failed');
	    }
	    die();
	}

	/**
	 * End Function for how Save form with the Help of Ajax
	 */
    }

    global $automobile_emp_functions;
    $automobile_emp_functions = new automobile_dealer_functions();
}