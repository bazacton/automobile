<?php
/**
 *  File Type: 2Checkout Gateway
 *

 */
if (!class_exists('automobile_2CHECKOUT_GATEWAY')) {

    class automobile_2CHECKOUT_GATEWAY {

        public function __construct() {
            // Do Something
        }
         
        //start function for payment checkout setting gateways
        
        public function settings() {
            global $post,$automobile_var_plugin_static_text;

            $automobile_rand_id = AUTOMOBILE_FUNCTIONS()->automobile_rand_id();

            $on_off_option = array("show" => "on", "hide" => "off");

            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_custom_logo'),
                "desc" => "",
                "hint_text" => "",
                "id" => "2checkout_gateway_logo",
                "std" => "",
                "display" => "none",
                "type" => "logo"
            );

            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_default_status'),
                "desc" => "",
                "hint_text" =>  automobile_var_plugin_text_srt('automobile_var_default_status_hint'),
                "id" => "2checkout_status",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_checkout_sandbox'),
                "desc" => "",
                "hint_text" =>  automobile_var_plugin_text_srt('automobile_var_checkout_sandbox_hint'),
                "id" => "2checkout_sandbox",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_checkout_business') ,
                "desc" => "",
                "hint_text" => "",
                "id" => "2checkout_email",
                "std" => "",
                "type" => "text"
            );

            $ipn_url = automobile_var::plugin_url() . 'payments/gateways/class-2checkout.php';
            $automobile_settings[] = array("name" =>  automobile_var_plugin_text_srt('automobile_var_checkout_ipn_url'),
                "desc" => "",
                "hint_text" =>  automobile_var_plugin_text_srt('automobile_var_checkout_ipn_url_hint') ,
                "id" => "dir_2checkout_ipn_url",
                "std" => $ipn_url,
                "type" => "text"
            );

            return $automobile_settings;
        }

       //start function for generate form
        
        public function automobile_generate_form() {
            global $post;
        }

    }

}