<?php

/**
 *  File Type: Paypal Gateway
 *
 */
if (!class_exists('AUTOMOBILE_PAYPAL_GATEWAY')) {

    class AUTOMOBILE_PAYPAL_GATEWAY extends AUTOMOBILE_PAYMENTS {

        public function __construct() {
            global $automobile_gateway_options;

            $automobile_gateway_options = get_option('automobile_var_plugin_options');

            $automobile_lister_url = '';
            if (isset($automobile_gateway_options['automobile_dir_paypal_ipn_url'])) {
                $automobile_lister_url = $automobile_gateway_options['automobile_dir_paypal_ipn_url'];
            }

            if (isset($automobile_gateway_options['automobile_paypal_sandbox']) && $automobile_gateway_options['automobile_paypal_sandbox'] == 'on') {
                $this->gateway_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
            } else {
                $this->gateway_url = "https://www.paypal.com/cgi-bin/webscr";
            }
            $this->listner_url = $automobile_lister_url;
        }

        // Start function for paypal setting 
        
        public function settings($automobile_gateways_id = '') {
            global $post,$automobile_var_plugin_static_text;
            

            $automobile_rand_id = AUTOMOBILE_FUNCTIONS()->automobile_rand_id();

            $on_off_option = array("show" => "on", "hide" => "off");



            $automobile_settings[] = array(
                "name" => automobile_var_plugin_text_srt('automobile_var_paypal_settings') ,
                "id" => "tab-heading-options",
                "std" => automobile_var_plugin_text_srt('automobile_var_paypal_settings'),
                "type" => "section",
                "options" => "",
                "parrent_id" => "$automobile_gateways_id",
                "active" => true,
            );



            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_custom_logo'),
                "desc" => "",
                "hint_text" => "",
                "id" => "paypal_gateway_logo",
                "std" => automobile_var::plugin_url() . 'payments/images/paypal.png',
                "display" => "none",
                "type" => "upload logo"
            );

            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_status'),
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_defaule_status_paypal') ,
                "id" => "paypal_gateway_status",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_paypal_sandbox') ,
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_paypal_sandbox_hint') ,
                "id" => "paypal_sandbox",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_paypal_business_email') ,
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_paypal_business_email_hint') ,
                "id" => "paypal_email",
                "std" => "",
                "type" => "text"
            );

            $ipn_url = automobile_var::plugin_url() . 'payments/listner.php';
            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_paypal_ipn_url'),
                "desc" => $ipn_url,
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_paypal_ipn_url_hint'),
                "id" => "dir_paypal_ipn_url",
                "std" => $ipn_url,
                "type" => "text"
            );



            return $automobile_settings;
        }
        
        // Start function for paypal process request  

        public function automobile_proress_request($params = '') {
            global $post, $automobile_gateway_options, $automobile_form_fields;
            extract($params);

            $automobile_current_date = date('Y-m-d H:i:s');
            $output = '';
            $rand_id = $this->automobile_get_string(5);
            $business_email = $automobile_gateway_options['automobile_paypal_email'];


            $currency = isset($automobile_gateway_options['automobile_currency_type']) && $automobile_gateway_options['automobile_currency_type'] != '' ? $automobile_gateway_options['automobile_currency_type'] : 'USD';
            $automobile_opt_hidden1_array = array(
                'id' => '',
                'std' => '_xclick',
                'cust_id' => "",
                'cust_name' => "cmd",
                'return' => true,
            );
            $automobile_opt_hidden2_array = array(
                'id' => '',
                'std' => sanitize_email($business_email),
                'cust_id' => "",
                'cust_name' => "business",
                'return' => true,
            );
            $automobile_opt_hidden3_array = array(
                'id' => '',
                'std' => $automobile_trans_amount,
                'cust_id' => "",
                'cust_name' => "amount",
                'return' => true,
            );
            $automobile_opt_hidden4_array = array(
                'id' => '',
                'std' => $currency,
                'cust_id' => "",
                'cust_name' => "currency_code",
                'return' => true,
            );
            $automobile_opt_hidden5_array = array(
                'id' => '',
                'std' => $automobile_package_title,
                'cust_id' => "",
                'cust_name' => "item_name",
                'return' => true,
            );
            $automobile_opt_hidden6_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_inventory_id),
                'cust_id' => "",
                'cust_name' => "item_number",
                'return' => true,
            );
            $automobile_opt_hidden7_array = array(
                'id' => '',
                'std' => '',
                'cust_id' => "",
                'cust_name' => "cancel_return",
                'return' => true,
            );
            $automobile_opt_hidden8_array = array(
                'id' => '',
                'std' => '1',
                'cust_id' => "",
                'cust_name' => "no_note",
                'return' => true,
            );
            $automobile_opt_hidden9_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_order_id),
                'cust_id' => "",
                'cust_name' => "invoice",
                'return' => true,
            );
            $automobile_opt_hidden10_array = array(
                'id' => '',
                'std' => esc_url($this->listner_url),
                'cust_id' => "",
                'cust_name' => "notify_url",
                'return' => true,
            );
            $automobile_opt_hidden11_array = array(
                'id' => '',
                'std' => '',
                'cust_id' => "",
                'cust_name' => "lc",
                'return' => true,
            );
            $automobile_opt_hidden12_array = array(
                'id' => '',
                'std' => '2',
                'cust_id' => "",
                'cust_name' => "rm",
                'return' => true,
            );
            $automobile_opt_hidden13_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_order_id),
                'cust_id' => "",
                'cust_name' => "custom",
                'return' => true,
            );
            $automobile_opt_hidden14_array = array(
                'id' => '',
                'std' => esc_url(home_url('/')),
                'cust_id' => "",
                'cust_name' => "return",
                'return' => true,
            );
            
            $output .= '<form name="PayPalForm" id="direcotry-paypal-form" action="' . $this->gateway_url . '" method="post">  
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
                        </form>';
 
            
            $data = AUTOMOBILE_FUNCTIONS()->automobile_special_chars($output);
            $data .= '<script>
					  	  jQuery("#direcotry-paypal-form").submit();
					  </script>';
            echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($data);
        }

        public function automobile_gateway_listner() {
            
        }

    }

}