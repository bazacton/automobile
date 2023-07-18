<?php

/**
 *  File Type: Authorize.net Gateway

 */
if (!class_exists('AUTOMOBILE_AUTHORIZEDOTNET_GATEWAY')) {

    class AUTOMOBILE_AUTHORIZEDOTNET_GATEWAY extends AUTOMOBILE_PAYMENTS {

        // Call a construct for objects 
        public function __construct() {
            // Do Something
            global $automobile_gateway_options;
            $automobile_gateway_options = get_option('automobile_var_plugin_options');
            $automobile_lister_url = '';
            if (isset($automobile_gateway_options['dir_authorizenet_ipn_url'])) {
                $automobile_lister_url = $automobile_gateway_options['dir_authorizenet_ipn_url'];
            }
            if (isset($automobile_gateway_options['automobile_authorizenet_sandbox']) && $automobile_gateway_options['automobile_authorizenet_sandbox'] == 'on') {
                $this->gateway_url = "https://test.authorize.net/gateway/transact.dll";
            } else {
                $this->gateway_url = "https://secure.authorize.net/gateway/transact.dll";
            }
            $this->listner_url = $automobile_lister_url;
        }

        // Start function for Authorize.net payment gateway
        
        public function settings($automobile_gateways_id = '') {
            global $post,$automobile_var_plugin_static_text;
            $automobile_var_custom_logo =   automobile_var_plugin_text_srt('automobile_var_custom_logo');
            $automobile_var_authorize_settings = automobile_var_plugin_text_srt('automobile_var_authorize_settings') ;
            $automobile_var_default_status = automobile_var_plugin_text_srt('automobile_var_default_status') ;
            $automobile_var_default_status_authorize = automobile_var_plugin_text_srt('automobile_var_default_status_authorize') ;
            $automobile_var_authorize_sandbox = automobile_var_plugin_text_srt('automobile_var_authorize_sandbox') ;
            $automobile_var_authorize_sandbox_hint = automobile_var_plugin_text_srt('automobile_var_authorize_sandbox_hint') ;
            $automobile_var_login_id = automobile_var_plugin_text_srt('automobile_var_login_id');
            $automobile_var_login_id_hint = automobile_var_plugin_text_srt('automobile_var_login_id_hint') ;
            $automobile_var_transaction_key = automobile_var_plugin_text_srt('automobile_var_transaction_key') ;
            $automobile_var_transaction_key_hint = automobile_var_plugin_text_srt('automobile_var_transaction_key_hint') ;
            $automobile_var_authorize_ipn_url = automobile_var_plugin_text_srt('automobile_var_authorize_ipn_url') ;
            $automobile_var_authorize_ipn_url_hint = automobile_var_plugin_text_srt('automobile_var_authorize_ipn_url_hint') ;

            $automobile_rand_id = AUTOMOBILE_FUNCTIONS()->automobile_rand_id();

            $on_off_option = array("show" => "on", "hide" => "off");




            $automobile_settings[] = array(
                "name" => $automobile_var_authorize_settings,
                "id" => "tab-heading-options",
                "std" => $automobile_var_authorize_settings,
                "type" => "section",
                "options" => "",
                "parrent_id" => "$automobile_gateways_id",
                "active" => true,
            );




            $automobile_settings[] = array("name" => $automobile_var_custom_logo,
                "desc" => "",
                "hint_text" => "",
                "id" => "authorizedotnet_gateway_logo",
                "std" => automobile_var::plugin_url() . 'payments/images/athorizedotnet_.png',
                "display" => "none",
                "type" => "upload logo"
            );

            $automobile_settings[] = array("name" => $automobile_var_default_status,
                "desc" => "",
                "hint_text" => $automobile_var_default_status_authorize,
                "id" => "authorizedotnet_gateway_status",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $automobile_settings[] = array("name" => $automobile_var_authorize_sandbox,
                "desc" => "",
                "hint_text" => $automobile_var_authorize_sandbox_hint,
                "id" => "authorizenet_sandbox",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $automobile_settings[] = array("name" => $automobile_var_login_id,
                "desc" => "",
                "hint_text" => $automobile_var_login_id_hint,
                "id" => "authorizenet_login",
                "std" => "",
                "type" => "text"
            );

            $automobile_settings[] = array("name" => $automobile_var_transaction_key,
                "desc" => "",
                "hint_text" => $automobile_var_transaction_key_hint,
                "id" => "authorizenet_transaction_key",
                "std" => "",
                "type" => "text"
            );

            $ipn_url = automobile_var::plugin_url() . 'payments/listner.php';
            $automobile_settings[] = array("name" => $automobile_var_authorize_ipn_url,
                "desc" => $ipn_url,
                "hint_text" => $automobile_var_authorize_ipn_url_hint,
                "id" => "dir_authorizenet_ipn_url",
                "std" => $ipn_url,
                "type" => "text"
            );



            return $automobile_settings;
        }
            // Start function for process request Authorize.net payment gateway
        public function automobile_proress_request($params = '') {
            global $post, $automobile_gateway_options, $automobile_form_fields;
            extract($params);
            $automobile_current_date = date('Y-m-d H:i:s');
            $output = '';
            $rand_id = $this->automobile_get_string(5);
            $automobile_login = '';
            if (isset($automobile_gateway_options['automobile_authorizenet_login'])) {
                $automobile_login = $automobile_gateway_options['automobile_authorizenet_login'];
            }
            $transaction_key = '';
            if (isset($automobile_gateway_options['automobile_authorizenet_transaction_key'])) {
                $transaction_key = $automobile_gateway_options['automobile_authorizenet_transaction_key'];
            }
            if (isset($package)) {
                $package = $automobile_gateway_options['automobile_packages_options'][$automobile_trans_pkg];
            }

            $timeStamp = time();
            $sequence = rand(1, 1000);

            if (phpversion() >= '5.1.2') {
                $fingerprint = hash_hmac("md5", $automobile_login . "^" . $sequence . "^" . $timeStamp . "^" . $automobile_trans_amount . "^", $transaction_key);
            } else {
                $fingerprint = bin2hex(mhash(MHASH_MD5, $automobile_login . "^" . $sequence . "^" . $timeStamp . "^" . $automobile_trans_amount . "^", $transaction_key));
            }

            $currency = isset($automobile_gateway_options['automobile_currency_type']) && $automobile_gateway_options['automobile_currency_type'] != '' ? $automobile_gateway_options['automobile_currency_type'] : 'USD';
            $user_ID = get_current_user_id();

            $automobile_opt_hidden1_array = array(
                'id' => '',
                'std' => $automobile_login,
                'cust_id' => "",
                'cust_name' => "x_login",
                'return' => true,
            );
            $automobile_opt_hidden2_array = array(
                'id' => '',
                'std' => 'AUTH_CAPTURE',
                'cust_id' => "",
                'cust_name' => "x_type",
                'return' => true,
            );
            $automobile_opt_hidden3_array = array(
                'id' => '',
                'std' => $automobile_trans_amount,
                'cust_id' => "",
                'cust_name' => "x_amount",
                'return' => true,
            );
            $automobile_opt_hidden4_array = array(
                'id' => '',
                'std' => $sequence,
                'cust_id' => "",
                'cust_name' => "x_fp_sequence",
                'return' => true,
            );
            $automobile_opt_hidden5_array = array(
                'id' => '',
                'std' => $timeStamp,
                'cust_id' => "",
                'cust_name' => "x_fp_timestamp",
                'return' => true,
            );
            $automobile_opt_hidden6_array = array(
                'id' => '',
                'std' => $fingerprint,
                'cust_id' => "",
                'cust_name' => "x_fp_hash",
                'return' => true,
            );
            $automobile_opt_hidden7_array = array(
                'id' => '',
                'std' => 'PAYMENT_FORM',
                'cust_id' => "",
                'cust_name' => "x_show_form",
                'return' => true,
            );
            $automobile_opt_hidden8_array = array(
                'id' => '',
                'std' => 'ORDER-' . sanitize_text_field($automobile_order_id),
                'cust_id' => "",
                'cust_name' => "x_invoice_num",
                'return' => true,
            );
            $automobile_opt_hidden9_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_order_id),
                'cust_id' => "",
                'cust_name' => "x_po_num",
                'return' => true,
            );
            $automobile_opt_hidden10_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_inventory_id),
                'cust_id' => "",
                'cust_name' => "x_cust_id",
                'return' => true,
            );
            $automobile_opt_hidden11_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_package_title),
                'cust_id' => "",
                'cust_name' => "x_description",
                'return' => true,
            );
            $automobile_opt_hidden12_array = array(
                'id' => '',
                'std' => esc_url(get_permalink()),
                'cust_id' => "",
                'cust_name' => "x_cancel_url",
                'return' => true,
            );
            $automobile_opt_hidden13_array = array(
                'id' => '',
                'std' => __('Cancel Order', 'automobile'),
                'cust_id' => "",
                'cust_name' => "x_cancel_url_text",
                'return' => true,
            );
            $automobile_opt_hidden14_array = array(
                'id' => '',
                'std' => 'TRUE',
                'cust_id' => "",
                'cust_name' => "x_relay_response",
                'return' => true,
            );
            $automobile_opt_hidden15_array = array(
                'id' => '',
                'std' => sanitize_text_field($this->listner_url),
                'cust_id' => "",
                'cust_name' => "x_relay_url",
                'return' => true,
            );
            $automobile_opt_hidden16_array = array(
                'id' => '',
                'std' => 'false',
                'cust_id' => "",
                'cust_name' => "x_test_request",
                'return' => true,
            );
            $output .= '<form name="AuthorizeForm" id="direcotry-authorize-form" action="' . $this->gateway_url . '" method="post">  
			' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden1_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden2_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden3_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden4_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden5_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden6_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden7_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden8_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden9_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden10_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden11_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden12_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden13_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden14_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden15_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden16_array) . '

			</form>';
            echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($output);
            echo '<script>
				    	jQuery("#direcotry-authorize-form").submit();
				      </script>';
            die;
        }

    }

}