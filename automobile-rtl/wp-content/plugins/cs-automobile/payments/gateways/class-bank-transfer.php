<?php
/**
 *  File Type: Pre Bank Transfer
 *
 */
if (!class_exists('AUTOMOBILE_PRE_BANK_TRANSFER')) {

    class AUTOMOBILE_PRE_BANK_TRANSFER {

        public function __construct() {
            global $automobile_gateway_options;
            $automobile_gateway_options = get_option('automobile_var_plugin_options');
        }
     
        // Start function for Bank Transfer setting 
        
        public function settings($automobile_gateways_id = '') {
            global $post,$automobile_var_plugin_static_text;
            

            $automobile_rand_id = AUTOMOBILE_FUNCTIONS()->automobile_rand_id();

            $on_off_option = array("show" => "on", "hide" => "off");



            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_bank_transfer_settings'),
                "id" => "tab-heading-options",
                "std" => automobile_var_plugin_text_srt('automobile_var_bank_transfer_settings'),  
                "type" => "section",
                "parrent_id" => "$automobile_gateways_id",
                "active" => false,
            );
            
            

            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_custom_logo'), 
                "desc" => "",
                "hint_text" => "",
                "id" => "pre_bank_transfer_logo",
                "std" => automobile_var::plugin_url() . 'payments/images/bank.png',
                "display" => "none",
                "type" => "upload logo"
            );

            $automobile_settings[] = array("name" => automobile_var_plugin_text_srt('automobile_var_default_status'), 
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_default_status_bank'),  
                "id" => "pre_bank_transfer_status",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );
            $automobile_settings[] = array("name" =>automobile_var_plugin_text_srt('automobile_var_bank_information'),   
                "desc" => "",
                "hint_text" =>automobile_var_plugin_text_srt('automobile_var_bank_information_hint'),   
                "id" => "bank_information",
                "std" => "",
                "type" => "text"
            );
            $automobile_settings[] = array("name" =>automobile_var_plugin_text_srt('automobile_var_account_number'),  
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_account_number_hint'), 
                "id" => "bank_account_id",
                "std" => "",
                "type" => "text"
            );
            $automobile_settings[] = array("name" =>automobile_var_plugin_text_srt('automobile_var_other_information'),  
                "desc" => "",
                "hint_text" => automobile_var_plugin_text_srt('automobile_var_other_information_hint'),  
                "id" => "other_information",
                "std" => "",
                "type" => "textarea"
            );



            return $automobile_settings;
        }

        // Start function for process request 
        
        public function automobile_proress_request($params = '') {
            global $post, $automobile_var_plugin_options, $automobile_gateway_options, $current_user,$automobile_var_plugin_static_text;
            $automobile_var_gross_charges =  automobile_var_plugin_text_srt('automobile_var_gross_charges');
            $automobile_var_order_detail = automobile_var_plugin_text_srt('automobile_var_order_detail');
            $automobile_var_order_id = automobile_var_plugin_text_srt('automobile_var_order_id');
            $automobile_var_bank_detail = automobile_var_plugin_text_srt('automobile_var_bank_detail');
            $automobile_var_please_transfer = automobile_var_plugin_text_srt('automobile_var_please_transfer');
            $automobile_var_bank_information = automobile_var_plugin_text_srt('automobile_var_bank_information');
            $automobile_var_account_no = automobile_var_plugin_text_srt('automobile_var_account_no');

            extract($params);
			
			$automobile_emp_funs = new automobile_dealer_functions();
			
			$automobile_emp_id = $automobile_trans_user;
            $args = array(
                'posts_per_page' => "1",
                'post_type' => 'employer',
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'automobile_user',
                        'value' => $current_user->ID,
                        'compare' => '=',
                    ),
                ),
            );

            $custom_query = new WP_Query($args);

            if ($custom_query->post_count > 0) {
				while ($custom_query->have_posts()) : $custom_query->the_post();
                	$automobile_emp_id = get_the_id();
				endwhile;
            }
			wp_reset_postdata();
			$automobile_frst_name = get_post_meta($automobile_emp_id, 'automobile_first_name', true);
			$automobile_usr_email = get_post_meta($automobile_emp_id, 'automobile_email', true);
			$automobile_lst_name = get_post_meta($automobile_emp_id, 'automobile_last_name', true);
			$automobile_user_adres = get_post_meta($automobile_emp_id, 'automobile_post_loc_address', true);
			
			$automobile_trans_post_id = $automobile_emp_funs->automobile_get_post_id_by_meta_key("automobile_transaction_id", $automobile_trans_id);
			
			update_post_meta($automobile_trans_post_id, 'automobile_first_name', $automobile_frst_name);
			update_post_meta($automobile_trans_post_id, 'automobile_last_name', $automobile_lst_name);
			update_post_meta($automobile_trans_post_id, 'automobile_summary_email', $automobile_usr_email);
			update_post_meta($automobile_trans_post_id, 'automobile_full_address', $automobile_user_adres);
			
            $automobile_feature_amount = isset($automobile_var_plugin_options['automobile_inventory_feat_price']) ? $automobile_var_plugin_options['automobile_inventory_feat_price'] : '';

            $automobile_totl_amount = 0;
            $automobile_detail = '<ul>';
            $automobile_currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';

            if ($automobile_trans_package <> '') {
                $automobile_trans_pkg_title = isset($automobile_trans_pkg) && $automobile_trans_pkg <> '' ? $automobile_emp_funs->get_pkg_field($automobile_trans_pkg) : '';
                $automobile_trans_pkg_price = isset($automobile_trans_pkg) && $automobile_trans_pkg <> '' ? $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_price') : '';
                $automobile_detail .= '<li>Package : ' . $automobile_trans_pkg_title . ' - ' . $automobile_currency_sign . $automobile_trans_pkg_price . '</li>';
                $automobile_totl_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_trans_pkg_price);
            }

            if (isset($automobile_trans_featured) && $automobile_trans_featured == 'on') {

                $automobile_detail .= '<li>Featured - ' . $automobile_currency_sign . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount) . '</li>';
                $automobile_totl_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount);
            }

            $automobile_totl_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_totl_amount);

            $automobile_detail .= '<li>Total Charges: ' . $automobile_currency_sign . $automobile_totl_amount . '</li>';

            $automobile_payment_vat = isset($automobile_var_plugin_options['automobile_payment_vat']) ? $automobile_var_plugin_options['automobile_payment_vat'] : '';

            if ($automobile_payment_vat <> '' && $automobile_payment_vat > 0) {

                $automobile_tax_amount = $automobile_totl_amount * ($automobile_payment_vat / 100);
                $automobile_tax_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_tax_amount);

                $automobile_totl_amount = $automobile_totl_amount + $automobile_tax_amount;
                $automobile_totl_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_totl_amount);

                $automobile_detail .= '<li>' . sprintf(__('%s&#37; VAT :', 'automobile'), $automobile_payment_vat) . ' - ' . $automobile_currency_sign . $automobile_tax_amount . '</li>';
                $automobile_detail .= '<li>'.$automobile_var_gross_charges. $automobile_currency_sign . $automobile_totl_amount . '</li>';
            }

            $automobile_detail .= '</ul>';

            $automobile_bank_transfer = '<div class="cs-bank-transfer">';
            $automobile_bank_transfer .= '<h2>' . $automobile_var_order_detail . '</h2>';

            $automobile_bank_transfer .= '<ul class="list-group">';
            $automobile_bank_transfer .= '<li class="list-group-item">';
            $automobile_bank_transfer .= '<span class="badge">#' . $automobile_trans_id . '</span>';
            $automobile_bank_transfer .= $automobile_var_order_id;
            $automobile_bank_transfer .= '</li>';

            $automobile_bank_transfer .= '<ul class="list-group">';
            $automobile_bank_transfer .= '<h2>' . $automobile_var_bank_detail . '</h2>';
            $automobile_bank_transfer .= '<p>' . $automobile_var_please_transfer . '</p1>';

            if (isset($automobile_gateway_options['automobile_bank_information']) && $automobile_gateway_options['automobile_bank_information'] != '') {
                $automobile_bank_transfer .= '<li class="list-group-item">';
                $automobile_bank_transfer .= '<span class="badge">' . $automobile_gateway_options['automobile_bank_information'] . '</span>';
                $automobile_bank_transfer .= $automobile_var_bank_information;
                $automobile_bank_transfer .= '</li>';
            }

            if (isset($automobile_gateway_options['automobile_bank_account_id']) && $automobile_gateway_options['automobile_bank_account_id'] != '') {
                $automobile_bank_transfer .= '<li class="list-group-item">';
                $automobile_bank_transfer .= '<span class="badge">' . $automobile_gateway_options['automobile_bank_account_id'] . '</span>';
                $automobile_bank_transfer .= $automobile_var_account_no;
                $automobile_bank_transfer .= '</li>';
            }

            if (isset($automobile_gateway_options['automobile_other_information']) && $automobile_gateway_options['automobile_other_information'] != '') {
                $automobile_bank_transfer .= '<li class="list-group-item">';
                $automobile_bank_transfer .= '<span>' . $automobile_gateway_options['automobile_other_information'] . '</span>';
                $automobile_bank_transfer .= '</li>';
            }

            $automobile_bank_transfer .= '</ul>';
            $automobile_bank_transfer .= '</div>';

            return force_balance_tags($automobile_bank_transfer);
        }

    }

}