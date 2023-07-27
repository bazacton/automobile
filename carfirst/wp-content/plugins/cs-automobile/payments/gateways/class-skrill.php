<?php

/**
 *  File Type: Skrill- Monery Booker Gateway
 *
 */
if (!class_exists('AUTOMOBILE_SKRILL_GATEWAY')) {

    class AUTOMOBILE_SKRILL_GATEWAY extends AUTOMOBILE_PAYMENTS {

        
        // Start skrill gateway construct
        
        public function __construct() {
            global $automobile_gateway_options;
            $automobile_lister_url = '';
            if (isset($automobile_gateway_options['automobile_skrill_ipn_url'])) {
                $automobile_lister_url = $automobile_gateway_options['automobile_skrill_ipn_url'];
            }



            $automobile_gateway_options = get_option('automobile_var_plugin_options');
            $this->gateway_url = "https://www.moneybookers.com/app/payment.pl";
            $this->listner_url = $automobile_lister_url;
        }

        
        // Start function for skrill payment gateway setting 
        
        public function settings($automobile_gateways_id = '') {
            global $post,$automobile_var_plugin_static_text;
            

            $automobile_rand_id = AUTOMOBILE_FUNCTIONS()->automobile_rand_id();

            $on_off_option = array("show" => "on", "hide" => "off");


            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_skrill_settings'), 
                "id" => "tab-heading-options",
                "std" =>  automobile_var_plugin_text_srt('automobile_var_skrill_settings'),
                "type" => "section",
                "id" => "$automobile_rand_id",
                "parrent_id" => "$automobile_gateways_id",
                "active" => false,
            );



            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_custom_logo'), 
                "desc" => "",
                "hint_text" => "",
                "id" => "skrill_gateway_logo",
                "std" => automobile_var::plugin_url() . 'payments/images/skrill.png',
                "display" => "none",
                "type" => "upload logo"
            );

            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_default_status'),
                "desc" => "",
                "hint_text" =>  automobile_var_plugin_text_srt('automobile_var_default_status_skrill'),
                "id" => "skrill_gateway_status",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_skrill_business'),
                "desc" => "",
                "hint_text" =>  automobile_var_plugin_text_srt('automobile_var_skrill_business_hint'),
                "id" => "skrill_email",
                "std" => "",
                "type" => "text"
            );

            $ipn_url = automobile_var::plugin_url() . 'payments/listner.php';
            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_skrill_ipn_url'),
                "desc" => $ipn_url,
                "hint_text" =>  automobile_var_plugin_text_srt('automobile_var_skrill_ipn_url_hint'),
                "id" => "skrill_ipn_url",
                "std" => $ipn_url,
                "type" => "text"
            );



            return $automobile_settings;
        }
        
         // Start function for skrill payment gateway process request 

        public function automobile_proress_request($params = '') {
            global $post, $automobile_gateway_options, $automobile_form_fields;
            extract($params);

            $automobile_current_date = date('Y-m-d H:i:s');
            $output = '';
            $rand_id = $this->automobile_get_string(5);
            $business_email = $automobile_gateway_options['automobile_skrill_email'];

            $currency = isset($automobile_gateway_options['automobile_currency_type']) && $automobile_gateway_options['automobile_currency_type'] != '' ? $automobile_gateway_options['automobile_currency_type'] : 'USD';
            $user_ID = get_current_user_id();
            $automobile_opt_hidden_array = array(
                'id' => '',
                'std' => sanitize_email($business_email),
                'cust_id' => "",
                'cust_name' => "pay_to_email",
                'return' => true,
            );
            $automobile_opt_amount_array = array(
                'id' => '',
                'std' => $automobile_trans_amount,
                'cust_id' => "",
                'cust_name' => "amount",
                'return' => true,
            );
            $automobile_opt_language_array = array(
                'id' => '',
                'std' => 'EN',
                'cust_id' => "",
                'cust_name' => "language",
                'return' => true,
            );
            $automobile_opt_currency_array = array(
                'id' => '',
                'std' => $currency,
                'cust_id' => "",
                'cust_name' => "currency",
                'return' => true,
            );
            $automobile_opt_description_array = array(
                'id' => '',
                'std' => 'Package : ',
                'cust_id' => "",
                'cust_name' => "detail1_description",
                'return' => true,
            );
            $automobile_opt_detail1_array = array(
                'id' => '',
                'std' => $automobile_package_title,
                'cust_id' => "",
                'cust_name' => "detail1_text",
                'return' => true,
            );
            $automobile_opt_detail2_description_array = array(
                'id' => '',
                'std' => 'Ad Title : ',
                'cust_id' => "",
                'cust_name' => "detail2_description",
                'return' => true,
            );
            $automobile_opt_detail2_text_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_package_title),
                'cust_id' => "",
                'cust_name' => "detail2_text",
                'return' => true,
            );
            $automobile_opt_detail3_description_array = array(
                'id' => '',
                'std' => "Ad ID : ",
                'cust_id' => "",
                'cust_name' => "detail3_description",
                'return' => true,
            );

            $automobile_opt_detail3_text_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_order_id),
                'cust_id' => "",
                'cust_name' => "detail3_text",
                'return' => true,
            );
            $automobile_opt_cancel_url_array = array(
                'id' => '',
                'std' => esc_url(get_permalink()),
                'cust_id' => "",
                'cust_name' => "cancel_url",
                'return' => true,
            );

            $automobile_opt_status_url_array = array(
                'id' => '',
                'std' => sanitize_text_field($this->listner_url),
                'cust_id' => "",
                'cust_name' => "status_url",
                'return' => true,
            );

            $automobile_opt_transaction_id_array = array(
                'id' => '',
                'std' => sanitize_text_field($automobile_order_id) . '||' . sanitize_text_field($automobile_order_id),
                'cust_id' => "",
                'cust_name' => "transaction_id",
                'return' => true,
            );

            $automobile_opt_customer_number_array = array(
                'id' => '',
                'std' => $automobile_order_id,
                'cust_id' => "",
                'cust_name' => "customer_number",
                'return' => true,
            );
            $automobile_opt_return_url_array = array(
                'id' => '',
                'std' => esc_url(get_permalink()),
                'cust_id' => "",
                'cust_name' => "return_url",
                'return' => true,
            );

            $automobile_opt_merchant_fields_array = array(
                'id' => '',
                'std' => $automobile_order_id,
                'cust_id' => "",
                'cust_name' => "merchant_fields",
                'return' => true,
            );
            $output .= '<form name="SkrillForm" id="direcotry-skrill-form" action="' . $this->gateway_url . '" method="post">  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_hidden_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_amount_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_language_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_currency_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_description_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_detail1_array) . '
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_detail2_description_array) . '                    
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_detail2_text_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_detail3_description_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_detail3_text_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_cancel_url_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_status_url_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_transaction_id_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_customer_number_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_return_url_array) . '  
                        ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_merchant_fields_array) . '  
                        </form>';

            echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($output);
            echo '<script>
				  	jQuery("#direcotry-skrill-form").submit();
				  </script>';
            die;
        }

    }

}