<?php
// Packages start
// Adding columns start

/**
 * Start Function  how to Create columns in transactions 
 */
if (!function_exists('transactions_columns_add')) {
    add_filter('manage_cs-transactions_posts_columns', 'transactions_columns_add');

    function transactions_columns_add($columns) {
        global $automobile_var_plugin_static_text;
        $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
        
        unset($columns['title']);
        unset($columns['date']);
        $columns['p_title'] = automobile_var_plugin_text_srt('automobile_var_package_id');
        $columns['p_date'] = automobile_var_plugin_text_srt('automobile_var_date');
        $columns['users'] = automobile_var_plugin_text_srt('automobile_var_user');
        $columns['package'] = automobile_var_plugin_text_srt('automobile_var_package_name');
        $columns['gateway'] = automobile_var_plugin_text_srt('automobile_var_payment_gateway');
        $columns['amount'] = automobile_var_plugin_text_srt('automobile_var_amount');
        return $columns;
    }

}

/**
 * Start Function  how to Show data in columns
 */
if (!function_exists('transactions_columns')) {
    add_action('manage_cs-transactions_posts_custom_column', 'transactions_columns', 10, 2);

    function transactions_columns($name) {
        global $post, $gateways, $automobile_var_plugin_options;
        $general_settings = new AUTOMOBILE_PAYMENTS();
        $currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';
        $automobile_emp_funs = new automobile_dealer_functions();
        $transaction_user = get_post_meta($post->ID, 'transaction_user', true);
        $transaction_amount = get_post_meta($post->ID, 'transaction_amount', true);
        $transaction_fee = get_post_meta($post->ID, 'transaction_fee', true);
        $transaction_status = get_post_meta($post->ID, 'transaction_status', true);
        // return payment gateway name
        switch ($name) {
            case 'p_title':
                echo get_the_title($post->ID);
                break;
            case 'p_date':
                echo get_the_date();
                break;
            case 'users':
                echo get_the_author_meta('display_name', (int) $transaction_user);
                break;
            case 'package':
                $automobile_trans_type = get_post_meta(get_the_id(), "automobile_transaction_type", true);
				
				$automobile_trans_pkg = get_post_meta(get_the_id(), "automobile_transaction_package", true);
				$automobile_trans_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);
                
                if ($automobile_trans_pkg_title != '') {
                    echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_trans_pkg_title);
                } else {
                    echo '-';
                }
                break;
            case 'gateway':
                $automobile_trans_gate = get_post_meta(get_the_id(), "automobile_transaction_pay_method", true);
                if ($automobile_trans_gate != '') {
                    $automobile_trans_gate = isset($gateways[strtoupper($automobile_trans_gate)]) ? $gateways[strtoupper($automobile_trans_gate)] : '';
                    echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_trans_gate);
                } else {
                    echo '-';
                }
                break;
            case 'amount':
                $automobile_trans_amount = get_post_meta(get_the_id(), "automobile_transaction_amount", true);
                if ($automobile_trans_amount != '') {
                    echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_trans_amount);
                } else {
                    echo '-';
                }
                break;
        }
    }

}

/**
 * Start Function  how to remove Row in columns
 */
if (!function_exists('remove_row_actions')) {
    add_filter('post_row_actions', 'remove_row_actions', 10, 1);

    function remove_row_actions($actions) {
        if (get_post_type() == 'cs-transactions') {
            unset($actions['view']);
            unset($actions['trash']);
            unset($actions['inline hide-if-no-js']);
        }
        return $actions;
    }

}

/**
 * Start Function  how configure gateway given dynamic gateway name
 */
if (!function_exists('automobile_gateway_name')) {

    function automobile_gateway_name($automobile_post_id = '') {
        global $gateways;
        $transaction_method = '';
        $transaction_method = get_post_meta($automobile_post_id, 'transaction_pay_method', true);
        $transaction_method = isset($gateways[strtoupper($transaction_method)]) ? $gateways[strtoupper($transaction_method)] : '';

        return $transaction_method;
    }

}
/**
 * Start Function how to Delete User From Wishlist 
 */
if (!function_exists('automobile_delete_wishlist')) {

    function automobile_delete_wishlist() {
        global $automobile_var_plugin_static_text;
        

        $user = get_current_user_id();
        if (isset($user) && $user <> '') {
            // check this record is in his list
            if (isset($_POST['post_id']) && $_POST['post_id'] <> '') {
                automobile_remove_from_user_meta_list($_POST['post_id'], 'cs-user-inventories-wishlist', $user);
                echo automobile_var_plugin_text_srt('automobile_var_removed_from_favourite');
            } else {
                echo automobile_var_plugin_text_srt('automobile_var_you_are_not_authorised');
            }
        }
        die();
    }

    add_action("wp_ajax_automobile_delete_wishlist", "automobile_delete_wishlist");
    add_action("wp_ajax_nopriv_automobile_delete_wishlist", "automobile_delete_wishlist");
}

/**
 * Start Function  how configure package name dynamic gateway name
 */
if (!function_exists('automobile_package_name')) {

    function automobile_package_name($automobile_post_id = '') {
        $transaction_package = get_post_meta($automobile_post_id, 'transaction_package', true);
        $automobile_var_plugin_options = get_option('automobile_var_plugin_options');
        $automobile_packages_options = $automobile_var_plugin_options['automobile_packages_options'];
        $package_title = isset($automobile_packages_options[$transaction_package]['package_title']) ? $automobile_packages_options[$transaction_package]['package_title'] : '';
        return $package_title;
    }

}

/**
 * Start Function  how create post type of transactions
 */
if (!class_exists('post_type_transactions')) {

    class post_type_transactions {

        // The Constructor
        public function __construct() {
            add_action('init', array(&$this, 'transactions_init'));
            add_action('admin_init', array(&$this, 'transactions_admin_init'));
        }

        public function transactions_init() {
            // Initialize Post Type
            $this->transactions_register();
        }

        public function transactions_register() {
            global $automobile_var_plugin_static_text;
            
            $labels = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_packages'),
                'menu_name' => automobile_var_plugin_text_srt('automobile_var_packages'),
                'add_new_item' => automobile_var_plugin_text_srt('automobile_var_add_new_packages'),
                'edit_item' => automobile_var_plugin_text_srt('automobile_var_edit_packages'),
                'new_item' => automobile_var_plugin_text_srt('automobile_var_new_packages_item'),
                'add_new' => automobile_var_plugin_text_srt('automobile_var_add_new_packages'),
                'view_item' => automobile_var_plugin_text_srt('automobile_var_view_packages_item'),
                'search_items' => automobile_var_plugin_text_srt('automobile_var_search'),
                'not_found' => automobile_var_plugin_text_srt('automobile_var_nothing'),
                'not_found_in_trash' => automobile_var_plugin_text_srt('automobile_var_nothing_found_in_trash'),
                'parent_item_colon' => ''
            );
            $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'query_var' => false,
                'menu_icon' => 'dashicons-admin-post',
                'show_in_menu' => 'edit.php?post_type=inventory',
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array(''),
				'exclude_from_search' => true
            );
            register_post_type('cs-transactions', $args);
        }

        /**
         * End Function  how create post type of transactions
         */

        /**
         * Start Function  how add meta boxes of transactions
         */
        public function transactions_admin_init() {
            // Add metaboxes
            add_action('add_meta_boxes', array(&$this, 'automobile_meta_transactions_add'));
        }

        public function automobile_meta_transactions_add() {
            global $automobile_var_plugin_static_text;
            

            add_meta_box('automobile_meta_transactions', automobile_var_plugin_text_srt('automobile_var_package_options'), array(&$this, 'automobile_meta_transactions'), 'cs-transactions', 'normal', 'high');
        }

        public function automobile_meta_transactions($post) {
            global $gateways, $automobile_html_fields, $automobile_form_fields, $automobile_var_plugin_static_text, $automobile_var_plugin_options;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();

            $automobile_users_list = array();
            $automobile_users = get_users('orderby=nicename');

            foreach ($automobile_users as $user) {
                $automobile_users_list[$user->ID] = $user->display_name;
            }
            $automobile_packages_list = array();
            //$automobile_packages_options = get_option('automobile_var_plugin_options');
           // $automobile_packages_options = $automobile_packages_options['automobile_packages_options'];
	    if (isset($automobile_var_plugin_options['automobile_packages_options']) && !empty($automobile_var_plugin_options['automobile_packages_options'])) {
		$automobile_packages_options = $automobile_var_plugin_options['automobile_packages_options'];
	    }
            if (isset($automobile_packages_options) && is_array($automobile_packages_options) && count($automobile_packages_options) > 0) {
                foreach ($automobile_packages_options as $package_key => $package) {
                    if (isset($package_key) && $package_key <> '') {
                        $package_id = isset($package['package_id']) ? $package['package_id'] : '';
                        $package_title = isset($package['package_title']) ? $package['package_title'] : '';
                        $automobile_packages_list[$package_id] = $package_title;
                    }
                }
            }

            $object = new AUTOMOBILE_PAYMENTS();
            $payment_geteways = array();
            $payment_geteways[''] = automobile_var_plugin_text_srt('automobile_var_select_payment_gateway');
            //$automobile_gateway_options = get_option('automobile_var_plugin_options');
	    if (isset($automobile_var_plugin_options['automobile_var_plugin_options']) && !empty($automobile_var_plugin_options['automobile_var_plugin_options'])) {
		$automobile_gateway_options = $automobile_var_plugin_options['automobile_var_plugin_options'];
	    }
	    if (isset($automobile_gateway_options) && !empty($automobile_gateway_options)) {

		foreach ($gateways as $key => $value) {
		    $status = $automobile_gateway_options[strtolower($key) . '_status'];
		    if (isset($status) && $status == 'on') {
			$payment_geteways[strtolower($key)] = $value;
		    }
		}
	    }

            $automobile_trans_type = get_post_meta(get_the_id(), "automobile_transaction_type", true);

            $transaction_meta = array();
            $transaction_meta['transaction_id'] = array(
                'name' => 'transaction_id',
                'type' => 'hidden_label',
                'title' => automobile_var_plugin_text_srt('automobile_var_transaction_id'),
                'description' => '',
            );
            $transaction_meta['transaction_user'] = array(
                'name' => 'transaction_user',
                'type' => 'select',
                'classes' => 'chosen-select',
                'title' => automobile_var_plugin_text_srt('automobile_var_package_user'),
                'options' => $automobile_users_list,
                'description' => '',
            );
            
			$transaction_meta['transaction_package'] = array(
				'name' => 'transaction_package',
				'type' => 'select',
				'classes' => 'chosen-select-no-single',
				'title' => automobile_var_plugin_text_srt('automobile_var_packages'),
				'options' => $automobile_packages_list,
				'description' => '',
			);

            if ($automobile_trans_type != 'cv_trans') {
                $transaction_meta['transaction_feature'] = array(
                    'name' => 'transaction_feature',
                    'type' => 'select',
                    'classes' => 'chosen-select-no-single',
                    'title' => automobile_var_plugin_text_srt('automobile_var_package_featured'),
                    'options' => array(
                        'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                        'yes' => automobile_var_plugin_text_srt('automobile_var_yes')
                    ),
                    'description' => '',
                );
            }
            $transaction_meta['transaction_amount'] = array(
                'name' => 'transaction_amount',
                'type' => 'text',
                'title' => automobile_var_plugin_text_srt('automobile_var_amount'),
                'description' => '',
            );
            $transaction_meta['transaction_pay_method'] = array(
                'name' => 'transaction_pay_method',
                'type' => 'select',
                'classes' => 'chosen-select-no-single',
                'title' => automobile_var_plugin_text_srt('automobile_var_payment_gateway'),
                'options' => $payment_geteways,
                'description' => '',
            );
            $transaction_meta['transaction_expiry_date'] = array(
                'name' => 'transaction_expiry_date',
                'type' => 'text',
                'title' => automobile_var_plugin_text_srt('automobile_var_package_expiry_date'),
                'description' => '',
            );
            if ($automobile_trans_type == 'cv_trans') {
                $transaction_meta['transaction_listings'] = array(
                    'name' => 'transaction_listings',
                    'type' => 'text',
                    'title' => automobile_var_plugin_text_srt('automobile_var_no_of_cvs'),
                    'description' => '',
                );
            } else {
                $transaction_meta['transaction_listings'] = array(
                    'name' => 'transaction_listings',
                    'type' => 'text',
                    'title' => automobile_var_plugin_text_srt('automobile_var_no_of_listings_in_package'),
                    'description' => '',
                );
            }

            if ($automobile_trans_type != 'cv_trans') {
                $transaction_meta['transaction_listing_expiry'] = array(
                    'name' => 'transaction_listing_expiry',
                    'type' => 'text',
                    'title' => automobile_var_plugin_text_srt('automobile_var_listing_expiry'),
                    'description' => '',
                );


                $transaction_meta['transaction_listing_period'] = array(
                    'name' => 'transaction_listing_period',
                    'type' => 'select',
                    'classes' => 'chosen-select-no-single',
                    'title' => automobile_var_plugin_text_srt('automobile_var_listing_period'),
                    'options' => array(
                        'days' => automobile_var_plugin_text_srt('automobile_var_days'),
                        'months' => automobile_var_plugin_text_srt('automobile_var_months'),
                        'years' => automobile_var_plugin_text_srt('automobile_var_years')
                    ),
                    'description' => '',
                );
            }
            if ($automobile_trans_type == 'cv_trans') {
                $transaction_meta['transaction_resumes'] = array(
                    'name' => 'transaction_resumes',
                    'type' => 'cv_resumes',
                    'title' => automobile_var_plugin_text_srt('automobile_var_resumes'),
                    'description' => '',
                );
            }

            $html = '<div class="page-wrap">
						<div class="option-sec" style="margin-bottom:0;">
							<div class="opt-conts">
								<div class="cs-review-wrap">
									<script type="text/javascript">
										jQuery(function(){
											jQuery("#transaction_expiry_date").datetimepicker({
												format:"d-m-Y",
												timepicker:false
											});
										});
									</script>';
            foreach ($transaction_meta as $key => $params) {
                $html .= automobile_create_transactions_fields($key, $params);
            }

            $html .= '</div>
						</div>
					</div>';
            $automobile_opt_array = array(
                'std' => '1',
                'id' => 'transactions_form',
                'cust_name' => 'transactions_form',
                'cust_type' => 'hidden',
                'return' => true,
            );
            $html .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
            $html .= '
				<div class="clear"></div>
			</div>';
            echo force_balance_tags($html);
        }

    }

    /**
     * End Function  how add meta boxes of transactions
     */
    return new post_type_transactions();
}