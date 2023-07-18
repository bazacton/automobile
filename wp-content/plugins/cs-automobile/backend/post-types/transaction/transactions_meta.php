<?php
/**
 * Start Function  how to Create Transations Fields
 */
if (!function_exists('automobile_create_transactions_fields')) {

    function automobile_create_transactions_fields($key, $param) {
        global $post, $automobile_html_fields, $automobile_form_fields, $automobile_var_plugin_options,$automobile_var_plugin_static_text;
        
        $automobile_gateway_options = get_option('automobile_var_plugin_options');
        $automobile_currency_sign = isset($automobile_gateway_options['currency_sign']) ? $automobile_gateway_options['currency_sign'] : '$';
        $automobile_value = $param['title'];
        $html = '';
        switch ($param['type']) {
            case 'text' :
                // prepare
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $key, true);
				
                if (isset($automobile_value) && $automobile_value != '') {
                    if ($key == 'transaction_expiry_date') {
                        $automobile_value = date_i18n('d-m-Y', $automobile_value);
                    } else {
                        $automobile_value = $automobile_value;
                    }
                } else {
                    $automobile_value = '';
                }
				
                $output  = '<div class="form-elements">';
				$output .= '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . $param['title'] . '</label></div>';
				$output .= '<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
				$output .= '<input type="text" class="cs-form-text cs-input " name="automobile_' . $key . '" id="' . $key . '" value="' . $automobile_value . '" />' . "\n";
				$output .= '<span class="cs-form-desc">' . $param['description'] . '</span>' . "\n";
				$output .= '</div>';
				$output .= '</div>';
				
                $html .= $output;
                break;
            case 'textarea' :
                // prepare
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $key, true);
                if (isset($automobile_value) && $automobile_value != '') {
                    $automobile_value = $automobile_value;
                } else {
                    $automobile_value = '';
                }

                $automobile_opt_array = array(
                    'name' => $param['title'],
                    'desc' => '',
                    'hint_text' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => $key,
                        'return' => true,
                    ),
                );

                $output = $automobile_html_fields->automobile_textarea_field($automobile_opt_array);
                $html .= $output;
                break;
            case 'select' :
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $key, true);
                if (isset($automobile_value) && $automobile_value != '') {
                    $automobile_value = $automobile_value;
                } else {
                    $automobile_value = '';
                }
                $automobile_classes = '';
                if (isset($param['classes']) && $param['classes'] != "") {
                    $automobile_classes = $param['classes'];
                }

                $automobile_opt_array = array(
                    'name' => $param['title'],
                    'desc' => '',
                    'hint_text' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => $key,
                        'classes'=>$automobile_classes,
                        'options' => $param['options'],
                        'return' => true,
                    ),
                );

                $output = $automobile_html_fields->automobile_select_field($automobile_opt_array);
                // append
                $html .= $output;
                break;
            case 'hidden_label' :
                // prepare
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $key, true);

                if (isset($automobile_value) && $automobile_value != '') {
                    $automobile_value = $automobile_value;
                } else {
                    $automobile_value = '';
                }

                $automobile_opt_array = array(
                    'name' => $param['title'],
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);

                $output .= '<span>#' . $automobile_value . '</span>';

                $output .= $automobile_form_fields->automobile_form_hidden_render(
                        array(
                            'name' => '',
                            'id' => $key,
                            'return' => true,
                            'classes' => '',
                            'std' => $automobile_value,
                            'description' => '',
                            'hint' => ''
                        )
                );

                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);
                $html .= $output;
                break;
            case 'summary' :
                // prepare
                global $gateways;
                $object = new AUTOMOBILE_PAYMENTS();
                $automobile_var_plugin_options = get_option('automobile_var_plugin_options');
                $summary_status = get_post_meta($post->ID, "automobile_summary_status", true);
                $summary_transection_id = get_post_meta($post->ID, "automobile_summary_transection_id", true);
                $summary_amount = get_post_meta($post->ID, "automobile_summary_amount", true);
                $summary_currency = get_post_meta($post->ID, "automobile_summary_currency", true);
                $summary_email = get_post_meta($post->ID, "automobile_summary_email", true);
                $first_name = get_post_meta($post->ID, "automobile_first_name", true);
                $last_name = get_post_meta($post->ID, "automobile_last_name", true);
                $full_address = get_post_meta($post->ID, "automobile_full_address", true);
                $transaction_pay_method = get_post_meta($post->ID, "automobile_transaction_pay_method", true);
                $gateway_type = 'NILL';
                $gateway_logo = '';
                if (isset($transaction_pay_method) && $transaction_pay_method != '') {
                    $gateway_type = $gateways[strtoupper($transaction_pay_method)];
                    $logo = $automobile_var_plugin_options[strtolower($transaction_pay_method) . '_logo'];
                    if (isset($logo) && $logo != '') {
                        $gateway_logo = '<img src=' . esc_url($logo) . ' />';
                    }
                }
                $summary_status = $summary_status ? $summary_status : 'Pending';
                $summary_transection_id = $summary_transection_id ? $summary_transection_id : 'NILL';
                $summary_email = $summary_email ? $summary_email : 'NILL';
                $first_name = $first_name ? $first_name : 'NILL';
                $last_name = $last_name ? $last_name : 'NILL';
                $full_address = $full_address ? $full_address : 'NILL';

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_payment_summary'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_payment_method'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);
                $output .= $gateway_logo . ' ' . $gateway_type;
                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_gateway_transaction_id'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);
                $output .= $summary_transection_id;
                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_status'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);
                $output .= $summary_status;
                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_custom_email'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);
                $output .= $summary_email;
                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_first_name'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);
                $output .= $first_name;
                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_last_name'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);
                $output .= $last_name;
                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_address'),
                    'hint_text' => '',
                );
                $output = $automobile_html_fields->automobile_opening_field($automobile_opt_array);
                $output .= $full_address;
                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'desc' => '',
                );
                $output .= $automobile_html_fields->automobile_closing_field($automobile_opt_array);

                $html .= $output;
                break;
            default :
                break;
        }
        return $html;
    }
}