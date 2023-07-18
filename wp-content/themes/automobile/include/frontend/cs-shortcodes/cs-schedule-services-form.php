<?php
/*
 * Frontend file for Contact Us short code
 */
if (!function_exists('automobile_var_schedule_data')) {

    function automobile_var_schedule_data($atts, $content = "") {
	global $post, $abc;
	$defaults = shortcode_atts(array(
	    'automobile_var_column_size' => '',
	    'automobile_var_schedule_element_title' => '',
	    'automobile_var_schedule_element_subtitle' => '',
	    'automobile_var_schedule_element_send' => '',
	    'automobile_var_schedule_element_success' => '',
	    'automobile_var_schedule_element_error' => '',
	    'automobile_var_schedule_hint_text' => ''
		), $atts);

	extract(shortcode_atts($defaults, $atts));

	$strings = new automobile_theme_all_strings;
	$strings->automobile_short_code_strings();

	if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
	    if (function_exists('automobile_var_custom_column_class')) {
		$column_class = automobile_var_custom_column_class($automobile_var_column_size);
	    }
	}

	$automobile_email_counter = rand(56, 5565);
	// Set All variables 
	$html = '';
	$section_title = '';
	$column_class = isset($column_class) ? $column_class : '';
	$automobile_contactus_section_title = isset($automobile_var_schedule_element_title) ? $automobile_var_schedule_element_title : '';
	$automobile_schedule_element_subtitle = isset($automobile_var_schedule_element_subtitle) ? $automobile_var_schedule_element_subtitle : '';
	$automobile_contactus_send = isset($automobile_var_schedule_element_send) ? $automobile_var_schedule_element_send : '';
	$automobile_success = isset($automobile_var_schedule_element_success) ? $automobile_var_schedule_element_success : '';
	$automobile_error = isset($automobile_var_schedule_element_error) ? $automobile_var_schedule_element_error : '';
	$automobile_var_schedule_hint_text = isset($automobile_var_schedule_hint_text) ? $automobile_var_schedule_hint_text : '';

	// End All variables
	if (isset($column_class) && $column_class <> '') {
	    $html .= '<div class="' . esc_html($column_class) . '">';
	}
	// $html .= '<div class="cs-contact-form">';

	$html .= '<div class="cs-element-title">';
	if ($automobile_contactus_section_title <> '') {
	    $html .= '<h2>' . esc_html($automobile_contactus_section_title) . '</h2>';
	}
	$html .= '</div>';


	if (trim($automobile_success) && trim($automobile_success) != '') {
	    $success = $automobile_success;
	} else {
	    $success = automobile_var_theme_text_srt('automobile_var_contact_default_success_msg');
	}

	if (trim($automobile_error) && trim($automobile_error) != '') {
	    $error = $automobile_error;
	} else {
	    $error = automobile_var_theme_text_srt('automobile_var_contact_default_error_msg');
	}
	?>

	<script type="text/javascript">
	    function automobile_var_contact_frm_submit(form_id) {

		var automobile_mail_id = '<?php echo esc_js($automobile_email_counter); ?>';
		if (form_id == automobile_mail_id) {
		    var $ = jQuery;
		    $('input[type="submit"]').attr('disabled', true);
		    $("#loading_div<?php echo esc_js($automobile_email_counter); ?>").html('<img src="<?php echo esc_js(esc_url(get_template_directory_uri())); ?>/assets/backend/images/ajax-loader.gif" />');
		    $("#loading_div<?php echo esc_js($automobile_email_counter); ?>").show();
		    $("#message<?php echo esc_js($automobile_email_counter); ?>").html('');
		    var datastring = $('#frm<?php echo esc_js($automobile_email_counter); ?>').serialize() + "&automobile_contact_email=<?php echo esc_js($automobile_contactus_send); ?>&automobile_contact_succ_msg=<?php echo esc_js($success); ?>&automobile_contact_error_msg=<?php echo esc_js($error); ?>&action=automobile_var_contact_sche_submit";
		    $.ajax({
			type: 'POST',
			url: '<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>',
			data: datastring,
			dataType: "json",
			success: function (response) {
			    if (response.type == 'error') {
				$("#loading_div<?php echo esc_js($automobile_email_counter); ?>").html('');
				$("#loading_div<?php echo esc_js($automobile_email_counter); ?>").hide();
				$("#message<?php echo esc_js($automobile_email_counter); ?>").addClass('error_mess');
				$("#message<?php echo esc_js($automobile_email_counter); ?>").show();
				$("#message<?php echo esc_js($automobile_email_counter) ?>").html(response.message);
				$('input[type="submit"]').removeAttr('disabled');
			    } else if (response.type == 'success') {

				$("#frm<?php echo esc_js($automobile_email_counter); ?>").slideUp();
				$("#loading_div<?php echo esc_js($automobile_email_counter); ?>").html('');
				$("#loading_div<?php echo esc_js($automobile_email_counter); ?>").hide();
				$("#message<?php echo esc_js($automobile_email_counter); ?>").addClass('succ_mess');
				$("#message<?php echo esc_js($automobile_email_counter) ?>").show();
				$("#message<?php echo esc_js($automobile_email_counter); ?>").html(response.message);
				$('input[type="submit"]').removeAttr('disabled');
			    }

			}
		    }
		    );
		}
	    }


	</script>
	<?php
	$html .= '<span id="message' . absint($automobile_email_counter) . '" class="error" style="display:none;">' . automobile_var_theme_text_srt('automobile_var_contact_required_fields_error_msg') . '</span>';
	$html .= '<form class="user-post-vehicles row"  name="frm' . absint($automobile_email_counter) . '" id="frm' . absint($automobile_email_counter) . '" action="javascript:automobile_var_contact_frm_submit(' . absint($automobile_email_counter) . ')">';
	$html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<div class="cs-field">';
	$html .= '<input type="text" name ="contact_name" placeholder="' . automobile_var_theme_text_srt('automobile_var_contact_full_name') . '">';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<div class="cs-field">';
	$html .= '<input type="email" name ="contact_email" placeholder="' . automobile_var_theme_text_srt('automobile_var_contact_email') . '">';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<div class="cs-field">';
	$html .= '<input type="text" name ="contact_phone" placeholder="' . automobile_var_theme_text_srt('automobile_var_contact_phone_number') . '">';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<div class="cs-field">';
	$html .= '<input type="text" name ="contact_makemodel" placeholder="' . automobile_var_theme_text_srt('automobile_var_make_model') . '">';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<div class="cs-field">';
	$html .= '<input type="text" name ="millage" placeholder="' . automobile_var_theme_text_srt('automobile_var_mileage') . '">';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<div class="cs-field">';
	$html .= '<i class="icon-access_time"></i>';
	$html .= '<input type="text" name ="best_time" placeholder="' . automobile_var_theme_text_srt('automobile_var_best_time') . '">';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="col-lg-3 col-md-3 col-sm-4 col-md-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<div class="cs-field">';
	$html .= '<div class="cs-btn-submit">';
	$html .= '<input type="submit" value="' . automobile_var_theme_text_srt('automobile_var_request_service') . '">';
	$html .= '</div>';
	$html .= '<div id="loading_div' . absint($automobile_email_counter) . '"></div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
	$html .= '<div class="cs-field-holder">';
	$html .= '<p>' . $automobile_var_schedule_hint_text . '</p>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</form>';
	if (isset($column_class) && $column_class <> '') {
	    $html .= '</div>';
	}

	return $html;
    }

    if (function_exists('automobile_var_short_code')) {
	automobile_var_short_code('automobile_schedule', 'automobile_var_schedule_data');
    }
}



//Submit Contact Us Form Hooks
add_action('wp_ajax_nopriv_automobile_var_contact_sche_submit', 'automobile_var_contact_sche_submit');
add_action('wp_ajax_automobile_var_contact_sche_submit', 'automobile_var_contact_sche_submit');
