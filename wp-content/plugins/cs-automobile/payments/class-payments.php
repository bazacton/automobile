<?php
global $gateways;
/**
 *  File Type: Payemnts Base Class
 *
 */
if ( ! class_exists('AUTOMOBILE_PAYMENTS') ) {

    class AUTOMOBILE_PAYMENTS {
        public $gateways;
        public function __construct() {            
	    global $gateways;
            $gateways['AUTOMOBILE_PAYPAL_GATEWAY'] = 'Paypal';
            $gateways['AUTOMOBILE_AUTHORIZEDOTNET_GATEWAY'] = 'Authorize.net';
            $gateways['AUTOMOBILE_PRE_BANK_TRANSFER'] = 'Pre Bank Transfer';
            $gateways['AUTOMOBILE_SKRILL_GATEWAY'] = 'Skrill-MoneyBooker';
        }
        
        // Start function currency general setting 
        
        public function automobile_general_settings() {
            global $automobile_settings,$automobile_var_plugin_static_text;
            $automobile_currencuies = automobile_get_currency();
            foreach ($automobile_currencuies as $key => $value) {
                $currencies[$key] = $value['name'] . '-' . $value['code'];
            }
            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_select_currency'),
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_select_currency_hint'),
                "id" => "currency_type",
                "std" => "USD",
		'classes' => 'dropdown chosen-select-no-single ',
                "type" => "select_values",
                "options" => $currencies
            );
            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_currency_sign'),
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_currency_sign_hint'),
                "id" => "currency_sign",
                "std" => "$",
                "type" => "text");
            return $automobile_settings;
        }
        
         // Start function get string length
        
        public function automobile_get_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }
        
        // Start function for add transaction 
        
        public function automobile_add_transaction($fields = array()) {
            global $automobile_var_plugin_options;
            define("DEBUG", 1);
            define("USE_SANDBOX", 1);
            define("LOG_FILE", "./ipn.log");
            include_once('../../../../wp-load.php');
            if (is_array($fields)) {
                foreach ($fields as $key => $value) {
                    update_post_meta((int) $fields['automobile_transaction_id'], "$key", $value);
                }
            }
            return true;
        }
        

    }

}