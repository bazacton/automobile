<?php
/*
 * Frontend file for Contact Us short code
 */
if (!function_exists('automobile_var_contact_us_data')) {

    function automobile_var_contact_us_data($atts, $content = "") {
        global $post, $abc;
		
        $defaults = shortcode_atts(array(
            'automobile_var_column_size' => '',
            'automobile_var_contact_us_element_title' => '',
            'automobile_var_contact_us_element_subtitle' => '',
            'automobile_var_contact_us_element_send' => '',
            'automobile_var_contact_us_element_success' => '',
            'automobile_var_contact_us_element_error' => ''
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
        $automobile_contactus_section_title = isset($automobile_var_contact_us_element_title) ? $automobile_var_contact_us_element_title : '';
        $automobile_contact_us_element_subtitle = isset($automobile_var_contact_us_element_subtitle) ? $automobile_var_contact_us_element_subtitle : '';
        $automobile_contactus_send = isset($automobile_var_contact_us_element_send) ? $automobile_var_contact_us_element_send : '';
        $automobile_success = isset($automobile_var_contact_us_element_success) ? $automobile_var_contact_us_element_success : '';
        $automobile_error = isset($automobile_var_contact_us_element_error) ? $automobile_var_contact_us_element_error : '';

        // End All variables
        if (isset($column_class) && $column_class <> '') {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }
        $html .= '<div class="cs-contact-form">';
                                      //  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
       
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
                    $('input[type="submit"]').attr('disabled' , true);
                    $("#loading_div<?php echo esc_js($automobile_email_counter); ?>").html('<img src="<?php echo esc_js(esc_url(get_template_directory_uri())); ?>/assets/backend/images/ajax-loader.gif" />');
                    $("#loading_div<?php echo esc_js($automobile_email_counter); ?>").show();
                    $("#message<?php echo esc_js($automobile_email_counter); ?>").html('');
                    var datastring = $('#frm<?php echo esc_js($automobile_email_counter); ?>').serialize() + "&automobile_contact_email=<?php echo esc_js($automobile_contactus_send); ?>&automobile_contact_succ_msg=<?php echo esc_js($success); ?>&automobile_contact_error_msg=<?php echo esc_js($error); ?>&action=automobile_var_contact_submit";
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
                                $("#messag<?php echo esc_js($automobile_email_counter) ?>").show();
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
      //  $html .= '<span id="message' . absint($automobile_email_counter) . '" class="error" style="display:none;">' . automobile_var_theme_text_srt('automobile_var_contact_required_fields_error_msg') . '</span>';
        $html .= '<div id="message' . absint($automobile_email_counter) . '" class="alert alert-danger" style="display:none;"><i class="icon-warning4"></i>&nbsp; <span style="color: #ff0000;"  class="error">' . automobile_var_theme_text_srt('automobile_var_contact_required_fields_error_msg') . '</span><br></div>';
        $html .= '<div id="messag' . absint($automobile_email_counter) . '" class="alert alert-success" style="display:none;"><i class="icon-success"></i>&nbsp; <span  class="error">' . $success . '</span><br></div>';
        $html .= '<form  name="frm' . absint($automobile_email_counter) . '" id="frm' . absint($automobile_email_counter) . '" action="javascript:automobile_var_contact_frm_submit(' . absint($automobile_email_counter) . ')" >';
        $html .= '<div class="row" >';
        $html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
        $html .= '<div class="row" id="ul_frm' . absint($automobile_email_counter) . '">';
        $html .= ' <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="cs-form-holder">';
        $html .= '<div class="input-holder"><input name="contact_name" type="text" placeholder="' . automobile_var_theme_text_srt('automobile_var_contact_full_name') . '" required><i class=" icon-user"></i></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="cs-form-holder">';
        $html .= '<div class="input-holder"><input name="contact_email" type="email" placeholder="' . automobile_var_theme_text_srt('automobile_var_contact_email') . '" required><i class=" icon-envelope"></i></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="cs-form-holder">';
        $html .= '<div class="input-holder"><input name="contact_phone" type="text" placeholder="' . automobile_var_theme_text_srt('automobile_var_contact_phone_number') . '"><i class="icon-mobile2"></i></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="cs-form-holder">';
        $html .= '<div class="input-holder" id="data-toggle">';
        $html .= '<input type="checkbox"  id="cbox2"  name = "check_box" value="' . automobile_var_theme_text_srt('automobile_var_contact_check_field') . '"><label for="cbox2">' . automobile_var_theme_text_srt('automobile_var_contact_check_field') . '</label>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">	';
        $html .= '<div class="row">';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="cs-form-holder">';
        $html .= '<div class="input-holder">';
        $html .= '<textarea name="contact_msg" placeholder="' . automobile_var_theme_text_srt('automobile_var_text_here') . '"></textarea><i></i></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="cs-btn-submit cs-color">';
        $html .= '<input type="submit" value="' . automobile_var_theme_text_srt('automobile_var_contact_button_text') . '">';
        $html .= '<div id="loading_div' . absint($automobile_email_counter) . '"></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</form>';
      //  $html .= '</div>';
        $html .= '</div>';
        if (isset($column_class) && $column_class <> '') {
            $html .= '</div>';
        }

        return $html;
    }
	
	

}
if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('automobile_contact_form', 'automobile_var_contact_us_data');
    }


//Submit Contact Us Form Hooks
add_action('wp_ajax_nopriv_automobile_var_contact_submit', 'automobile_var_contact_submit');
add_action('wp_ajax_automobile_var_contact_submit', 'automobile_var_contact_submit');
