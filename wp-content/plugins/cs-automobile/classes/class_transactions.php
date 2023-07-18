<?php
/**
 *  File Type: Transactions Class
 */
if (!class_exists('automobile_transactions_options')) {

    class automobile_transactions_options {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_ajax_update_trans', array(&$this, 'update_trans'));
        }

        /**
         * End construct Functions
         */

        /**
         * Start Function for add submenu page in admin dashboard
         */
        public function automobile_transactions_settings() {
             global $automobile_var_plugin_static_text;
             
			add_submenu_page('edit.php?post_type=inventory', automobile_var_plugin_text_srt('automobile_var_transactions'), automobile_var_plugin_text_srt('automobile_var_transactions'), 'manage_options', 'automobile_transactions', array(&$this, 'automobile_transactions_area'));
        }

        /**
         * End Function for add submenu page in admin dashboard
         */

        /**
         * Start Function for how to create transactions_area fields
         */
        public function automobile_transactions_area() {
            global $post, $automobile_var_plugin_options, $gateways, $automobile_form_fields,$automobile_var_plugin_static_text;
            $automobile_var_cv_search = automobile_var_plugin_text_srt('automobile_var_cv_search');

            $general_settings = new AUTOMOBILE_PAYMENTS();

            $automobile_emp_funs = new automobile_dealer_functions();

            automobile_var::automobile_data_table_style_script();

            $automobile_html = '
			<div class="theme-wrap fullwidth">
				<div class="row">
					<form name="cs-booking-transactions" id="cs-booking-transactions" data-url="' . esc_js(admin_url('admin-ajax.php')) . '" method="post">
						<div class="cs-customers-area">';
            $args = array(
                'posts_per_page' => "-1",
                'post_type' => 'cs-transactions',
                'post_status' => 'publish',
                'orderby' => 'ID',
                'order' => 'DESC',
            );
            $custom_query = new WP_Query($args);
            if ($custom_query->have_posts()) {

                $automobile_html .= '
                            <script type="text/javascript">
                            jQuery(document).ready(function() {
                                jQuery("#automobile_custmr_data").DataTable();
                            });
                            </script>
                            <div class="cs-title"><h2>' . automobile_var_plugin_text_srt('automobile_var_transactions') . '</h2></div>
                            <div class="automobile_table_data automobile_loading">
                                <table id="automobile_custmr_data" class="display dataTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_package_id') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_title') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_payment_method') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_amount') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_custom_email') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_first_name') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_last_name') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_address') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_status') . '</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_package_id') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_title') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_payment_method') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_amount') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_custom_email') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_first_name') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_last_name') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_address') . '</th>
                                            <th>' . automobile_var_plugin_text_srt('automobile_var_status') . '</th>
                                        </tr>
                                    </tfoot>
                                        <tbody>';
                
                while ($custom_query->have_posts()) : $custom_query->the_post();
                    $automobile_trans_id = get_post_meta(get_the_id(), "automobile_transaction_id", true);
                    $automobile_trans_gate = get_post_meta(get_the_id(), "automobile_transaction_pay_method", true);
                    $automobile_trans_amount = get_post_meta(get_the_id(), "automobile_transaction_amount", true);
                    $automobile_trans_status = get_post_meta(get_the_id(), "automobile_transaction_status", true);
                    $summary_email = get_post_meta(get_the_id(), "automobile_summary_email", true);
                    $first_name = get_post_meta(get_the_id(), "automobile_first_name", true);
                    $last_name = get_post_meta(get_the_id(), "automobile_last_name", true);
                    $full_address = get_post_meta(get_the_id(), "automobile_full_address", true);
                    $automobile_trans_amount = $automobile_trans_amount != '' && $automobile_trans_amount > 0 ? $automobile_trans_amount : 0;
                    $summary_email = isset($summary_email) && $summary_email != '' ? $summary_email : automobile_var_plugin_text_srt('automobile_var_nill');
                    $first_name = isset($first_name) && $first_name != '' ? $first_name : automobile_var_plugin_text_srt('automobile_var_nill');
                    $last_name = isset($last_name) && $last_name != '' ? $last_name : automobile_var_plugin_text_srt('automobile_var_nill');
                    $full_address = isset($full_address) && $full_address != '' ? $full_address : automobile_var_plugin_text_srt('automobile_var_nill');
                    $automobile_trans_type = get_post_meta(get_the_id(), "automobile_transaction_type", true);
         			
					$automobile_trans_pkg = get_post_meta(get_the_id(), "automobile_transaction_package", true);
					$automobile_trans_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);

					if ($automobile_trans_pkg_title != '') {
						$automobile_trans_pkg_title = automobile_var_plugin_text_srt('automobile_var_advertise_inventory') . ' - ' . $automobile_trans_pkg_title;
					}
						
                    $automobile_trans_gate = isset($gateways[strtoupper($automobile_trans_gate)]) ? $gateways[strtoupper($automobile_trans_gate)] : automobile_var_plugin_text_srt('automobile_var_nill');
                    $automobile_html .= '
                                <tr>
                                    <td>#' . $automobile_trans_id . '</td>
                                    <td>' . $automobile_trans_pkg_title . '</td>
                                    <td>' . $automobile_trans_gate . '</td>
                                    <td>' . esc_attr(automobile_var_plugin_text_srt('automobile_currency_sign')) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_trans_amount) . '</td>
                                    <td>' . $summary_email . '</td>
                                    <td>' . $first_name . '</td>
                                    <td>' . $last_name . '</td>
                                    <td>' . $full_address . '</td>
                                    <td>
                                    <div id="cs-status-' . absint(get_the_id()) . '">';

										$automobile_opt_array = array(
											'std' => $automobile_trans_status,
											'cust_id' => 'automobile_update_trans',
											'cust_name' => '',
											'extra_atr' => ' onchange="automobile_update_transaction_status(\'' . esc_js(admin_url('admin-ajax.php')) . '\',\'' . absint(get_the_id()) . '\',this.value)"',
											'options' => array(
												'pending' => automobile_var_plugin_text_srt('automobile_var_pending'),
												'approved' => automobile_var_plugin_text_srt('automobile_var_approved'),
												'cancelled' => automobile_var_plugin_text_srt('automobile_var_cancelled'),
												'refunded' => automobile_var_plugin_text_srt('automobile_var_refunded'),
											),
											'return' => true,
										);
										$automobile_html .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
					
										$automobile_html .= '
                                        <div class="cs-holder"></div>
                                    </div>
                                    </td>
                                </tr>';
                endwhile;
                $automobile_html .= '	
                                    </tbody>
                                </table>
                            </div>';
            }
            $automobile_html .= '	
                                </div>
                            </form>
                        </div>
			</div>';

            echo force_balance_tags($automobile_html, true);
        }
 

        /**
         * Start Function for how to Update transactions_area fields
         */
        public function update_trans() {
            $automobile_emp_funs = new automobile_dealer_functions();
            $automobile_trans_id = isset($_POST['automobile_id']) ? $_POST['automobile_id'] : '';
            $automobile_trans_val = isset($_POST['automobile_val']) ? $_POST['automobile_val'] : '';

            if ($automobile_trans_id != '' && $automobile_trans_val != '') {

                $automobile_trans_type = get_post_meta($automobile_trans_id, "automobile_transaction_type", true);

                update_post_meta($automobile_trans_id, 'automobile_transaction_status', $automobile_trans_val);

                if ($automobile_trans_val == 'cancelled' || $automobile_trans_val == 'refunded') {

                    if ($automobile_trans_type == 'cv_trans') {

                        $automobile_user_id = get_post_meta($automobile_trans_id, "automobile_transaction_user", true);

                        $automobile_emp_id = $automobile_emp_funs->automobile_get_post_id_by_meta_key("automobile_user", $automobile_user_id);

                        $automobile_resume_ids = get_post_meta($automobile_trans_id, "automobile_resume_ids", true);
                        $automobile_resume_ids = explode(',', $automobile_resume_ids);
                        if (isset($automobile_resume_ids) && is_array($automobile_resume_ids) && sizeof($automobile_resume_ids) && $automobile_resume_ids[0] != '') {
                            foreach ($automobile_resume_ids as $automobile_resume_id) {
                                if ($automobile_emp_id != '' && $automobile_resume_id != '') {

                                    $automobile_fav_resumes = get_post_meta($automobile_emp_id, "automobile_fav_resumes", true);
                                    $automobile_fav_resumes = unserialize($automobile_fav_resumes);

                                    if (is_array($automobile_fav_resumes) && sizeof($automobile_fav_resumes) > 0 && $automobile_fav_resumes[0] != '') {

                                        foreach (array_keys($automobile_fav_resumes, $automobile_resume_id, true) as $key) {
                                            unset($automobile_fav_resumes[$key]);
                                        }

                                        $automobile_fav_resumes = serialize($automobile_fav_resumes);

                                        update_post_meta($automobile_emp_id, "automobile_fav_resumes", $automobile_fav_resumes);
                                    }
                                }
                            }
                        }
                    } else {
                        $automobile_inventory_id = get_post_meta($automobile_trans_id, "automobile_inventory_id", true);
                        $automobile_inventory_id = explode(',', $automobile_inventory_id);
                        if (isset($automobile_inventory_id) && is_array($automobile_inventory_id) && sizeof($automobile_inventory_id) && $automobile_inventory_id[0] != '') {
                            foreach ($automobile_inventory_id as $id) {
                                update_post_meta($id, 'automobile_inventory_status', 'delete');
                            }
                        }
                    }
                }
                echo ucfirst($automobile_trans_val);
            }
            die();
        }

        /**
         * End Function for how to Update transactions_area fields
         */
    }

}

// Call hook for transactions options 
if (class_exists('automobile_transactions_options')) {
    $automobile_transactions_obj = new automobile_transactions_options();
    add_action('admin_menu', array(&$automobile_transactions_obj, 'automobile_transactions_settings'));
}