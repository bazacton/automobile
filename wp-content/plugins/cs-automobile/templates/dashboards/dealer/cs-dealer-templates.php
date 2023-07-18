<?php
/**
 * File Type: Dealer Templates
 */
if (!class_exists('automobile_dealer_templates')) {

    class automobile_dealer_templates {

        /**
         * Start construct Functions
         */
        public function __construct() {
            // Post Inventory Function
            add_action('wp_ajax_automobile_dealer_post_inventory', array(&$this, 'automobile_dealer_post_inventory'));
            add_action('wp_ajax_nopriv_automobile_dealer_post_inventory', array(&$this, 'automobile_dealer_post_inventory'));
            add_action('wp_ajax_get_inventory_type_ajax_results', array(&$this, 'get_inventory_type_ajax_results'));
            add_action('wp_ajax_nopriv_get_inventory_type_ajax_results', array(&$this, 'get_inventory_type_ajax_results'));
            add_action('wp_ajax_dyn_inventory_models_frontend', array($this, 'inventory_models_front_end'));
            add_action('wp_ajax_nopriv_dyn_inventory_models_frontend', array($this, 'inventory_models_front_end'));
        }

        /**
         * End construct Functions
         */

        /**
         * Start Function for how to create Dealer Menu
         */
        public function automobile_dealer_menu($uid, $automobile_pkg_array) {
            $stringObj = new automobile_plugin_all_strings();
            $stringObj->automobile_var_plugin_option_strings();
            global $automobile_var_plugin_options, $automobile_var_plugin_static_text;

            $automobile_candidate_switch = isset($automobile_var_plugin_options['automobile_candidate_switch']) ? $automobile_var_plugin_options['automobile_candidate_switch'] : '';
            $automobile_inventory_id = isset($_GET['inventory_id']) ? $_GET['inventory_id'] : '';
            echo '<script>
               window.onload = function(){
               automobile_inventory_edit_tab();
}; 

            </script>';
            ?>
            <div class="cs-user-dropdown"> 
                <ul class="cs-user-accounts-list">
                    <li id="dealer_left_profile_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-genral-setting') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) echo 'class="active"'; ?>>
                        <a id="dealer_profile_click_link_id" href="javascript:void(0);" onclick="automobile_dashboard_tab_load('user-genral-setting', 'dealer', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid); ?>');" ><i class="icon-newspaper4"></i><?php echo automobile_var_plugin_text_srt('automobile_var_general_setting'); ?></a>
                    </li>

                    <li id="dealer_left_list_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-car-listing') || (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'edit-user-car-listing' )) echo 'class="active"'; ?>>
                        <a id="dealer_inventory_click_link_id" href="javascript:void(0);" onclick="automobile_dashboard_tab_load('user-car-listing', 'dealer', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid); ?>');" ><i class="icon-suitcase5"></i><?php echo automobile_var_plugin_text_srt('automobile_var_my_vehicles'); ?></a>
                    </li>
                    <li id="dealer_left_post_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-post-vehicle')) echo 'class="active"'; ?>>
                        <a id="dealer_transactions_click_link_id" href="javascript:void(0);" onclick="automobile_dashboard_tab_load('user-post-vehicle', 'dealer', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid); ?>');" ><i class="icon-graph"></i><?php echo automobile_var_plugin_text_srt('automobile_var_post_vehicle'); ?></a>
                    </li>
                    <li id="dealer_left_shortlist_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-car-shortlist')) echo 'class="active"'; ?>>
                        <a id="dealer_transactions_click_link_id" href="javascript:void(0);" onclick="automobile_dashboard_tab_load('user-car-shortlist', 'dealer', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid); ?>');" ><i class="icon-graph"></i><?php echo automobile_var_plugin_text_srt('automobile_var_shortlisted'); ?></a>
                    </li>


                    <li id="dealer_left_transaction_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions')) echo 'class="active"'; ?>>
                        <a id="dealer_resumes_click_link_id" href="javascript:void(0);" onclick='automobile_dashboard_tab_load("transactions", "dealer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-heart11"></i><?php echo automobile_var_plugin_text_srt('automobile_var_payment'); ?></a>
                    </li>

                    <li id="dealer_left_packages_link" <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages')) echo 'class="active"'; ?>>
                        <a id="dealer_resumes_click_link_id" href="javascript:void(0);" onclick='automobile_dashboard_tab_load("packages", "dealer", "<?php echo esc_js(admin_url('admin-ajax.php')); ?>", "<?php echo absint($uid); ?>", "");' ><i class="icon-heart11"></i><?php echo automobile_var_plugin_text_srt('automobile_var_packages'); ?></a>
                    </li>



                    <li><a href="<?php echo esc_url(wp_logout_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>"><i class="icon-logout"></i><?php echo automobile_var_plugin_text_srt('automobile_var_logout'); ?></a> </li>

                    <li>
                        <a href="javascript:void(0)" onclick="cs_remove_profile('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid) ?>', 'dealer')"><i class="icon-trash4"></i><?php esc_html_e('Delete Profile', 'cs-automobile'); ?></a>
                    </li>
                </ul>
            </div>

            <?php
        }

        /**
         * End Function for how to create Dealer Menu
         */

        /**
         * Start Function for Dealer Post inventory
         */
        public function automobile_dealer_post_inventory($automobile_elem = false) {
            global $post, $gateways, $current_user, $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_static_text;

            $general_settings = new AUTOMOBILE_PAYMENTS();

            if ($automobile_elem == true) {
                $automobile_pag_id = $post->ID;
            }
            $automobile_var_plugin_options = get_option('automobile_var_plugin_options');
            if (isset($_POST['pkg_array'])) {
                $automobile_pkg_array = stripslashes($_POST['pkg_array']);
                $post_array = json_decode($automobile_pkg_array, true);
                if (is_array($post_array) && sizeof($post_array) > 0) {
                    if (isset($post_array['inventory_imge'])) {
                        $inventory_imge = $post_array['inventory_imge'];
                    }
                    if (isset($post_array['post_array'])) {
                        $post_array = $post_array['post_array'];
                        $_POST = array_merge($_POST, $post_array);
                    }
                }
            }

            $uid = (isset($_POST['automobile_uid']) and $_POST['automobile_uid'] <> '') ? $_POST['automobile_uid'] : '';
            $automobile_var_plugin_options = get_option('automobile_var_plugin_options');

            if (class_exists('automobile_dealer_functions')) {
                $automobile_emp_funs = new automobile_dealer_functions();
            }
            $automobile_vat_switch = isset($automobile_var_plugin_options['automobile_vat_switch']) ? $automobile_var_plugin_options['automobile_vat_switch'] : '';
            $automobile_pay_vat = isset($automobile_var_plugin_options['automobile_payment_vat']) ? $automobile_var_plugin_options['automobile_payment_vat'] : '0';
            $currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';
            //print_r($automobile_var_plugin_options);
            $automobile_feature_amount = isset($automobile_var_plugin_options['automobile_inventory_feat_price']) ? $automobile_var_plugin_options['automobile_inventory_feat_price'] : '';
            $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';
            $automobile_inventory_id = isset($_GET['inventory_id']) ? $_GET['inventory_id'] : '';
            // add post or not
            $automobile_post_inventory = true;
            if (isset($_POST['automobile_update_inventory']) && $_POST['automobile_update_inventory'] != '') {
                $automobile_post_inventory = false;
            }
            // add post or not
            $automobile_current_date = strtotime(date('d-m-Y'));
            if (!is_user_logged_in() && isset($_POST['automobile_pkg_trans']) && $_POST['automobile_pkg_trans'] == 1) {
                $automobile_username = isset($_POST['automobile_user']) ? $_POST['automobile_user'] : '';
                $automobile_user_email = isset($_POST['automobile_emp_email']) ? $_POST['automobile_emp_email'] : '';
                $automobile_posting_user = $automobile_emp_funs->automobile_create_user($automobile_username, $automobile_user_email);
            } else {
                $automobile_posting_user = $current_user->ID;
            }
            $automobile_trans_pkg = isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '';
            // Checking Subscription
            $automobile_pkg_subscribe = false;
            if ($automobile_emp_funs->automobile_is_pkg_subscribed($automobile_trans_pkg)) {
                $automobile_pkg_subscribe = true;
                $automobile_trans_ins_id = $automobile_emp_funs->automobile_is_pkg_subscribed($automobile_trans_pkg, true);
            } else if ($automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_price') != '' && $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_price') <= 0) {
                $automobile_pkg_subscribe = true;
                $automobile_trans_ins_id = '';
            }
            $automobile_inventory_emplyr = get_post_meta($automobile_inventory_id, 'automobile_inventory_username', true);
            $inventory_pckge_id = get_post_meta($automobile_inventory_id, 'automobile_inventory_package', true);
            $get_inventory_feat = get_post_meta($automobile_inventory_id, 'automobile_inventory_featured', true);

            if ($get_inventory_feat == 'on') {
                $get_inventory_feat = 'yes';
            }

            $automobile_inventory_pkg = '';
            $automobile_inventory_expiry = '';
            if ($automobile_inventory_id <> '') {
                $automobile_inventory_pkg = get_post_meta($automobile_inventory_id, 'automobile_inventory_package', true);
                $automobile_inventory_expiry = get_post_meta($automobile_inventory_id, 'automobile_inventory_expired', true);
            }
            $inventory_expired_case = false;
            if ($automobile_post_inventory == false && ( $automobile_inventory_expiry <= $automobile_current_date || $automobile_inventory_pkg == '' )) {
                $inventory_expired_case = true;
            }

            // Updating Data into Meta
            if ($automobile_inventory_id <> '' && isset($_POST['automobile_pkg_trans']) && $_POST['automobile_pkg_trans'] == 1 && $automobile_inventory_emplyr == $current_user->ID) {

                if ($inventory_expired_case == true) {
                    if (isset($_POST['inventory_pckge']) && $_POST['inventory_pckge'] != '') {
                        if ($automobile_emp_funs->automobile_is_pkg_subscribed($_POST['inventory_pckge'])) {
                            // update inventory -> 1. status['active'] 2. package[$_POST['automobile_package']] 3.inventory expiry update 4. update package transaction in Inventory
                            $automobile_ins_exp = $automobile_emp_funs->automobile_inventory_expiry($_POST['inventory_pckge']);
                            $automobile_pkg_transe_id = $automobile_emp_funs->automobile_is_pkg_subscribed($_POST['inventory_pckge'], true);
                            update_post_meta($automobile_inventory_id, 'automobile_inventory_expired', strtotime($automobile_ins_exp));
                            update_post_meta($automobile_inventory_id, 'automobile_inventory_package', $_POST['inventory_pckge']);
                            update_post_meta($automobile_inventory_id, 'automobile_trans_id', $automobile_pkg_transe_id);
                            update_post_meta($automobile_inventory_id, 'automobile_inventory_status', 'active');
                            // update transaction [Add inventory ID of the updated inventory]
                            $automobile_transe_post_id = $automobile_emp_funs->automobile_get_post_id_by_meta_key('automobile_transaction_id', $automobile_pkg_transe_id);
                            $automobile_inventory_poste_ids = get_post_meta($automobile_transe_post_id, "automobile_inventory_id", true);
                            $automobile_inventory_poste_ids = explode(',', $automobile_inventory_poste_ids);
                            if (is_array($automobile_inventory_poste_ids) && !in_array($automobile_inventory_id, $automobile_inventory_poste_ids) && $automobile_inventory_poste_ids[0] != '') {
                                $automobile_inventory_poste_ids = array_merge($automobile_inventory_poste_ids, array($automobile_inventory_id));
                                $automobile_inventory_poste_ids = implode(',', $automobile_inventory_poste_ids);
                                update_post_meta($automobile_transe_post_id, "automobile_inventory_id", "$automobile_inventory_poste_ids");
                            } else {
                                update_post_meta($automobile_transe_post_id, "automobile_inventory_id", "$automobile_inventory_id");
                            }
                            //what if feature also selected
                            if ($get_inventory_feat != 'yes') {
                                $automobile_total_amount = 0;
                                if (isset($_POST['automobile_inventory_featured']) && $_POST['automobile_inventory_featured'] != '') {
                                    $automobile_total_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount);
                                }
                                $automobile_smry_totl = $automobile_total_amount;
                                if ($automobile_vat_switch == 'on' && $automobile_pay_vat > 0) {
                                    $automobile_vat_amount = $automobile_total_amount * ( $automobile_pay_vat / 100 );
                                    $automobile_total_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_vat_amount) + $automobile_total_amount;
                                }
                                $automobile_trans_fields = array(
                                    'automobile_inventory_id' => $automobile_inventory_id,
                                    'automobile_trans_id' => rand(149344111, 991435901),
                                    'automobile_trans_user' => $automobile_posting_user,
                                    'automobile_package_title' => '',
                                    'automobile_trans_package' => '',
                                    'automobile_trans_featured' => isset($_POST['automobile_inventory_featured']) ? $_POST['automobile_inventory_featured'] : '',
                                    'automobile_trans_amount' => $automobile_total_amount,
                                    'automobile_trans_pkg_expiry' => '',
                                    'automobile_trans_list_num' => '0',
                                    'automobile_trans_list_expiry' => '0',
                                    'automobile_trans_list_period' => '',
                                );
                                if ($automobile_total_amount > 0 && $inventory_expired_case == true) {
                                    $automobile_trans_html = $automobile_emp_funs->automobile_pay_process($automobile_trans_fields);
                                }
                            }
                        } else {

                            $automobile_ins_exp = $automobile_emp_funs->automobile_inventory_expiry($_POST['inventory_pckge']);
                            update_post_meta($automobile_inventory_id, 'automobile_inventory_expired', strtotime($automobile_ins_exp));
                            update_post_meta($automobile_inventory_id, 'automobile_inventory_package', $_POST['inventory_pckge']);
                            update_post_meta($automobile_inventory_id, 'automobile_inventory_status', 'awaiting-activation');
                            // Generate new transaction
                            $automobile_total_amount = 0;
                            if (isset($_POST['inventory_pckge']) && $_POST['inventory_pckge'] <> '')
                                $automobile_total_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_emp_funs->get_pkg_field($_POST['inventory_pckge'], 'package_price'));

                            if (isset($_POST['automobile_inventory_featured']) && $_POST['automobile_inventory_featured'] != '' && $get_inventory_feat != 'yes') {
                                $automobile_total_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount);
                            }
                            $automobile_smry_totl = $automobile_total_amount;

                            if ($automobile_vat_switch == 'on' && $automobile_pay_vat > 0) {
                                $automobile_vat_amount = $automobile_total_amount * ( $automobile_pay_vat / 100 );
                                $automobile_total_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_vat_amount) + $automobile_total_amount;
                            }
                            $automobile_trans_pkg = isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '';
                            $automobile_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);
                            $automobile_pkg_expiry = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration');
                            $automobile_pkg_duration = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration_period');
                            $automobile_pkg_expir_days = strtotime($automobile_emp_funs->automobile_date_conv($automobile_pkg_expiry, $automobile_pkg_duration));
                            $automobile_pkg_list_num = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_listings');
                            $automobile_pkg_list_exp = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_submission_limit');
                            $automobile_pkg_list_per = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'automobile_list_dur');
                            $automobile_trans_fields = array(
                                'automobile_inventory_id' => $automobile_inventory_id,
                                'automobile_trans_id' => rand(149344111, 991435901),
                                'automobile_trans_user' => $automobile_posting_user,
                                'automobile_package_title' => $automobile_pkg_title,
                                'automobile_trans_package' => isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '',
                                'automobile_trans_featured' => isset($_POST['automobile_inventory_featured']) ? $_POST['automobile_inventory_featured'] : '',
                                'automobile_trans_amount' => $automobile_total_amount,
                                'automobile_trans_pkg_expiry' => $automobile_pkg_expir_days,
                                'automobile_trans_list_num' => $automobile_pkg_list_num,
                                'automobile_trans_list_expiry' => $automobile_pkg_list_exp,
                                'automobile_trans_list_period' => $automobile_pkg_list_per,
                            );
                            if ($automobile_total_amount > 0) {
                                $automobile_trans_html = $automobile_emp_funs->automobile_pay_process($automobile_trans_fields);
                            }
                        }
                    }
                }
                //$automobile_inventory_feat = isset($_POST['automobile_inventory_featured']) && $_POST['automobile_inventory_featured'] == 'on' ? 'yes' : 'no';
                $automobile_inventory_feat = isset($_POST['automobile_inventory_featured']) && $_POST['automobile_inventory_featured'] != '' ? 'yes' : 'no';
                $automobile_inventory_cus = isset($_POST['automobile_cus_field']) ? $_POST['automobile_cus_field'] : '';
                $automobile_inventory_makes = isset($_POST['automobile_inventory_makes']) ? $_POST['automobile_inventory_makes'] : '';
                $automobile_inventory_models = isset($_POST['automobile_inventory_models']) ? $_POST['automobile_inventory_models'] : '';

                if ($get_inventory_feat == 'yes') {
                    update_post_meta((int) $automobile_inventory_id, 'automobile_inventory_featured', $automobile_inventory_feat);
                }
                if (is_array($automobile_inventory_cus) && sizeof($automobile_inventory_cus) > 0) {
                    foreach ($automobile_inventory_cus as $c_key => $c_val) {
                        update_post_meta((int) $automobile_inventory_id, "$c_key", $c_val);
                    }
                }
                // update inventory dealer_type
                $automobile_inventory_dealer_type = isset($_POST['automobile_inventory_dealer_type']) ? $_POST['automobile_inventory_dealer_type'] : '';

                if (!empty($automobile_inventory_dealer_type)) {
                    wp_set_post_terms($automobile_inventory_id, array(), 'dealer_type', FALSE);
                    foreach ($automobile_inventory_dealer_type as $automobile_spec) {
                        $automobile_spec = (int) $automobile_spec;
                        wp_set_post_terms($automobile_inventory_id, array($automobile_spec), 'dealer_type', true);
                    }
                }
                if ($automobile_inventory_makes != '') {
                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_makes, 'inventory-make', false);
                }
                if ($automobile_inventory_models != '') {
                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_models, 'inventory-make', false);
                }
                // update inventory type
                $automobile_inventory_types = isset($_POST['automobile_inventory_types']) ? $_POST['automobile_inventory_types'] : '';
                if ($automobile_inventory_types != '') {
                    wp_set_post_terms((int) $automobile_inventory_id, array($automobile_inventory_types), 'inventory_type', FALSE);
                }
                if ($automobile_inventory_makes != '') {
                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_makes, 'inventory-make', false);
                }
                if ($automobile_inventory_models != '') {
                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_models, 'inventory-make', false);
                }
                // update location 
                $automobile_post_loc_country = isset($_POST['automobile_post_loc_country']) ? $_POST['automobile_post_loc_country'] : '';
                if ($automobile_post_loc_country != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_country", $automobile_post_loc_country);
                }
                $automobile_post_loc_region = isset($_POST['automobile_post_loc_region']) ? $_POST['automobile_post_loc_region'] : '';
                if ($automobile_post_loc_region != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_region", $automobile_post_loc_region);
                }
                $automobile_post_loc_city = isset($_POST['automobile_post_loc_city']) ? $_POST['automobile_post_loc_city'] : '';
                if ($automobile_post_loc_city != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_city", $automobile_post_loc_city);
                }
                $automobile_post_loc_address = isset($_POST['automobile_post_loc_address']) ? $_POST['automobile_post_loc_address'] : '';
                if ($automobile_post_loc_address != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_address", $automobile_post_loc_address);
                }

                $automobile_post_loc_latitude = isset($_POST['automobile_post_loc_latitude']) ? $_POST['automobile_post_loc_latitude'] : '';
                if ($automobile_post_loc_latitude != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_latitude", $automobile_post_loc_latitude);
                }
                $automobile_post_loc_longitude = isset($_POST['automobile_post_loc_longitude']) ? $_POST['automobile_post_loc_longitude'] : '';
                if ($automobile_post_loc_longitude != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_longitude", $automobile_post_loc_longitude);
                }
                $automobile_add_new_loc = isset($_POST['automobile_add_new_loc']) ? $_POST['automobile_add_new_loc'] : '';
                if ($automobile_add_new_loc != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_add_new_loc", $automobile_add_new_loc);
                }
                $automobile_post_loc_zoom = isset($_POST['automobile_post_loc_zoom']) ? $_POST['automobile_post_loc_zoom'] : '';
                if ($automobile_post_loc_zoom != '') {
                    update_post_meta((int) $automobile_inventory_id, "automobile_post_loc_zoom", $automobile_post_loc_zoom);
                }

                $inventory_post_args = array(
                    'ID' => $automobile_inventory_id,
                    'post_title' => isset($_POST['automobile_inventory_title']) ? $_POST['automobile_inventory_title'] : '',
                    'post_content' => isset($_POST['automobile_inventory_desc']) ? $_POST['automobile_inventory_desc'] : '',
                );

                $automobile_inventory_title_str = isset($_POST['automobile_inventory_title']) ? $_POST['automobile_inventory_title'] : '';
                $automobile_old_inventory_title_str = isset($_POST['old_inventory_title']) ? $_POST['old_inventory_title'] : '';

                if ($automobile_old_inventory_title_str != $automobile_inventory_title_str) {
                    $inventory_post_args['post_name'] = sanitize_title($automobile_inventory_title_str);
                }
                wp_update_post($inventory_post_args);
            }
            $automobile_inventory_pkg = get_post_meta($automobile_inventory_id, 'automobile_inventory_package', true);
            $automobile_inventory_expiry = get_post_meta($automobile_inventory_id, 'automobile_inventory_expired', true);
            $inventory_pckge_id = get_post_meta($automobile_inventory_id, 'automobile_inventory_package', true);
            $get_inventory_feat = get_post_meta($automobile_inventory_id, 'automobile_inventory_featured', true);
            $automobile_inventory_emplyr = get_post_meta($automobile_inventory_id, 'automobile_inventory_username', true);
            $automobile_status_changing = false;

            if ($get_inventory_feat == 'on') {
                $get_inventory_feat = 'yes';
            }

            // Getting Data of inventory
            if ($automobile_inventory_id <> '' && is_user_logged_in()) {

                $default_data_inventory = get_post($automobile_inventory_id);

                $automobile_inventory_titl = isset($default_data_inventory->post_title) ? $default_data_inventory->post_title : '';
                $automobile_inventory_descreption = isset($default_data_inventory->post_content) ? $default_data_inventory->post_content : '';
                $automobile_inventory_meta = get_post_meta($automobile_inventory_id);
                $automobile_inventory_type = get_post_meta($automobile_inventory_id, 'automobile_inventory_type', true);
                $automobile_inventory_old_price = get_post_meta($automobile_inventory_id, 'automobile_inventory_old_price', true);
                $automobile_inventory_new_price = get_post_meta($automobile_inventory_id, 'automobile_inventory_new_price', true);
                $automobile_inventory_country = get_post_meta($automobile_inventory_id, 'automobile_post_loc_country', true);
                $automobile_inventory_city = get_post_meta($automobile_inventory_id, 'automobile_post_loc_city', true);
                $automobile_inventory_comp_address = get_post_meta($automobile_inventory_id, 'automobile_post_comp_address', true);
                $automobile_inventory_post_loc_address = get_post_meta($automobile_inventory_id, 'automobile_post_loc_address', true);
                $automobile_inventory_post_loc_latitude = get_post_meta($automobile_inventory_id, 'automobile_post_loc_latitude', true);
                $automobile_inventory_post_loc_longitude = get_post_meta($automobile_inventory_id, 'automobile_post_loc_longitude', true);
                $automobile_inventory_gallery_user_img_media = get_post_meta($automobile_inventory_id, 'automobile_gallery_user_img_media');
                $automobile_inventory_gallery = get_post_meta($automobile_inventory_id, 'automobile_inventory_gallery_url', true);

                $automobile_inventory_expire = get_post_meta((int) $automobile_inventory_id, 'automobile_inventory_expired', true);
                if ($automobile_inventory_expiry >= $automobile_current_date && $automobile_inventory_pkg != '') {
                    $automobile_status_changing = true;
                    if (isset($_POST['automobile_pkg_trans']) && isset($_POST['automobile_post_status']) && $_POST['automobile_pkg_trans'] == 1) {
                        update_post_meta((int) $automobile_inventory_id, 'automobile_inventory_status', $_POST['automobile_post_status']);
                    }
                }
            }
            $automobile_img_value = get_post_meta($automobile_inventory_id, 'inventory_img', true);
            if ($automobile_inventory_id != '') {
                $post_inventory = get_post($automobile_inventory_id);
                $automobile_inventory_desc = $post_inventory->post_content;
            }
            $automobile_inventory_status = get_post_meta($automobile_inventory_id, 'automobile_inventory_status', true);
            if (class_exists('automobile_dealer_functions')) {
                if (isset($_POST['automobile_pkg_trans']) && $_POST['automobile_pkg_trans'] == 1) { // only for renewal inventory 
                    if ($automobile_pkg_subscribe == true) {
                        if ($automobile_post_inventory == true) {
                            $automobile_ins_pkg = isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '';
                            $automobile_ins_exp = $automobile_emp_funs->automobile_inventory_expiry($automobile_ins_pkg);
                            $automobile_inventory_fields = '';

                            if (isset($automobile_var_plugin_options['automobile_inventories_review_option']) && $automobile_var_plugin_options['automobile_inventories_review_option'] != 'on') {
                                $automobile_inventory_fields = array(
                                    'automobile_inventory_id' => rand(149344111, 991435901),
                                    'automobile_inventory_user' => $automobile_posting_user,
                                    'automobile_inventory_title' => isset($_POST['automobile_inventory_title']) ? $_POST['automobile_inventory_title'] : '',
                                    'automobile_inventory_desc' => isset($_POST['automobile_inventory_desc']) ? $_POST['automobile_inventory_desc'] : '',
                                    'automobile_inventory_expire' => $automobile_ins_exp,
                                    'automobile_inventory_dealer_type' => isset($_POST['automobile_inventory_dealer_type']) ? $_POST['automobile_inventory_dealer_type'] : '',
                                    'automobile_inventory_types' => isset($_POST['automobile_inventory_types']) ? $_POST['automobile_inventory_types'] : '',
                                    'automobile_inventory_custom' => isset($_POST['automobile_cus_field']) ? $_POST['automobile_cus_field'] : '',
                                    'automobile_inventory_pkg' => $automobile_ins_pkg,
                                    'automobile_inventory_status' => 'active', // if subscribe package already 
                                    'automobile_post_loc_country' => isset($_POST['automobile_post_loc_country']) ? $_POST['automobile_post_loc_country'] : '',
                                    'automobile_post_loc_region' => isset($_POST['automobile_post_loc_region']) ? $_POST['automobile_post_loc_region'] : '',
                                    'automobile_post_loc_city' => isset($_POST['automobile_post_loc_city']) ? $_POST['automobile_post_loc_city'] : '',
                                    'automobile_post_loc_address' => isset($_POST['automobile_post_loc_address']) ? $_POST['automobile_post_loc_address'] : '',
                                    'automobile_post_loc_latitude' => isset($_POST['automobile_post_loc_latitude']) ? $_POST['automobile_post_loc_latitude'] : '',
                                    'automobile_post_loc_longitude' => isset($_POST['automobile_post_loc_longitude']) ? $_POST['automobile_post_loc_longitude'] : '',
                                    'automobile_add_new_loc' => isset($_POST['automobile_add_new_loc']) ? $_POST['automobile_add_new_loc'] : '',
                                    'automobile_post_loc_zoom' => isset($_POST['automobile_post_loc_zoom']) ? $_POST['automobile_post_loc_zoom'] : '',
                                    'automobile_inventory_makes' => isset($_POST['automobile_inventory_makes']) ? $_POST['automobile_inventory_makes'] : '',
                                    'automobile_inventory_models' => isset($_POST['automobile_inventory_models']) ? $_POST['automobile_inventory_models'] : '',
                                    'gallery_user_img' => isset($_POST['media-gallery']) ? $_POST['media-gallery'] : '',
                                    'automobile_inventory_new_price' => isset($_POST['automobile_inventory_new_price']) ? $_POST['automobile_inventory_new_price'] : '',
                                    'automobile_inventory_old_price' => isset($_POST['automobile_inventory_old_price']) ? $_POST['automobile_inventory_old_price'] : '',
                                );
                            } else {
                                $automobile_inventory_fields = array(
                                    'automobile_inventory_id' => rand(149344111, 991435901),
                                    'automobile_inventory_user' => $automobile_posting_user,
                                    'automobile_inventory_title' => isset($_POST['automobile_inventory_title']) ? $_POST['automobile_inventory_title'] : '',
                                    'automobile_inventory_desc' => isset($_POST['automobile_inventory_desc']) ? $_POST['automobile_inventory_desc'] : '',
                                    'automobile_inventory_expire' => $automobile_ins_exp,
                                    'automobile_inventory_dealer_type' => isset($_POST['automobile_inventory_dealer_type']) ? $_POST['automobile_inventory_dealer_type'] : '',
                                    'automobile_inventory_types' => isset($_POST['automobile_inventory_types']) ? $_POST['automobile_inventory_types'] : '',
                                    'automobile_inventory_custom' => isset($_POST['automobile_cus_field']) ? $_POST['automobile_cus_field'] : '',
                                    'automobile_inventory_pkg' => $automobile_ins_pkg,
                                    'automobile_inventory_status' => 'awaiting-activation', // if subscribe package already 
                                    'automobile_post_loc_country' => isset($_POST['automobile_post_loc_country']) ? $_POST['automobile_post_loc_country'] : '',
                                    'automobile_post_loc_region' => isset($_POST['automobile_post_loc_region']) ? $_POST['automobile_post_loc_region'] : '',
                                    'automobile_post_loc_city' => isset($_POST['automobile_post_loc_city']) ? $_POST['automobile_post_loc_city'] : '',
                                    'automobile_post_loc_address' => isset($_POST['automobile_post_loc_address']) ? $_POST['automobile_post_loc_address'] : '',
                                    'automobile_post_loc_latitude' => isset($_POST['automobile_post_loc_latitude']) ? $_POST['automobile_post_loc_latitude'] : '',
                                    'automobile_post_loc_longitude' => isset($_POST['automobile_post_loc_longitude']) ? $_POST['automobile_post_loc_longitude'] : '',
                                    'automobile_add_new_loc' => isset($_POST['automobile_add_new_loc']) ? $_POST['automobile_add_new_loc'] : '',
                                    'automobile_post_loc_zoom' => isset($_POST['automobile_post_loc_zoom']) ? $_POST['automobile_post_loc_zoom'] : '',
                                    'automobile_inventory_makes' => isset($_POST['automobile_inventory_makes']) ? $_POST['automobile_inventory_makes'] : '',
                                    'automobile_inventory_models' => isset($_POST['automobile_inventory_models']) ? $_POST['automobile_inventory_models'] : '',
                                    'gallery_user_img' => isset($_POST['media-gallery']) ? $_POST['media-gallery'] : '',
                                    'automobile_inventory_new_price' => isset($_POST['automobile_inventory_new_price']) ? $_POST['automobile_inventory_new_price'] : '',
                                    'automobile_inventory_old_price' => isset($_POST['automobile_inventory_old_price']) ? $_POST['automobile_inventory_old_price'] : '',
                                );
                            }

                            if ($automobile_elem == true) {

                                $inventory_id = $automobile_emp_funs->automobile_add_inventory($automobile_inventory_fields, true);
                            } else {

                                $inventory_id = $automobile_emp_funs->automobile_add_inventory($automobile_inventory_fields);
                            }
                            $automobile_inventory_msg = esc_html__('Created Successfully.', 'cs-automobile');
                        } else {
                            $inventory_id = $automobile_inventory_id;
                            $automobile_inventory_msg = automobile_var_plugin_text_srt('automobile_var_update_successfully');
                        }
                        if ($automobile_pkg_subscribe && $automobile_post_inventory == true) {
                            $automobile_inventory_makes = isset($_POST['automobile_inventory_makes']) ? $_POST['automobile_inventory_makes'] : '';
                            $automobile_inventory_models = isset($_POST['automobile_inventory_models']) ? $_POST['automobile_inventory_models'] : '';
                            $trans_post_id = $automobile_emp_funs->automobile_get_post_id_by_meta_key("automobile_transaction_id", $automobile_trans_ins_id);
                            $automobile_inventory_post_ids = get_post_meta($trans_post_id, "automobile_inventory_id", true);
                            $automobile_inventory_post_ids = explode(',', $automobile_inventory_post_ids);
                            if (is_array($automobile_inventory_post_ids) && !in_array($inventory_id, $automobile_inventory_post_ids) && $automobile_inventory_post_ids[0] != '') {
                                $automobile_inventory_post_ids = array_merge($automobile_inventory_post_ids, array($inventory_id));
                                $automobile_inventory_post_ids = implode(',', $automobile_inventory_post_ids);
                                update_post_meta($trans_post_id, "automobile_inventory_id", "$automobile_inventory_post_ids");
                                if ($automobile_inventory_makes != '') {
                                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_makes, 'inventory-make', false);
                                }
                                if ($automobile_inventory_models != '') {
                                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_models, 'inventory-make', false);
                                }
                            } else {
                                update_post_meta($trans_post_id, "automobile_inventory_id", "$inventory_id");
                                if ($automobile_inventory_makes != '') {
                                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_makes, 'inventory-make', false);
                                }
                                if ($automobile_inventory_models != '') {
                                    wp_set_post_terms((int) $automobile_inventory_id, $automobile_inventory_models, 'inventory-make', false);
                                }
                            }
                        }

                        if (isset($automobile_trans_ins_id) && $automobile_trans_ins_id <> '' && $automobile_pkg_subscribe == true) {
                            update_post_meta((int) $inventory_id, 'automobile_trans_id', $automobile_trans_ins_id);
                        }
                        $automobile_total_amount = isset($automobile_total_amount) && $automobile_total_amount > 0 ? $automobile_total_amount : 0; //warning removal
                        if ($get_inventory_feat != 'yes') {

                            if (isset($_POST['automobile_inventory_featured']) && $_POST['automobile_inventory_featured'] != '') {
                                $automobile_total_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount);
                            }
                            $automobile_smry_totl = isset($automobile_total_amount) && $automobile_total_amount > 0 ? $automobile_total_amount : 0;

                            if ($automobile_vat_switch == 'on' && $automobile_pay_vat > 0) {
                                $automobile_vat_amount = $automobile_total_amount * ( $automobile_pay_vat / 100 );
                                $automobile_total_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_vat_amount) + $automobile_total_amount;
                            }

                            $automobile_trans_fields = array(
                                'automobile_inventory_id' => $automobile_inventory_id,
                                'automobile_trans_id' => rand(149344111, 991435901),
                                'automobile_trans_user' => $automobile_posting_user,
                                'automobile_package_title' => '',
                                'automobile_trans_package' => '',
                                'automobile_trans_featured' => isset($_POST['automobile_inventory_featured']) ? $_POST['automobile_inventory_featured'] : '',
                                'automobile_trans_amount' => isset($automobile_total_amount) && $automobile_total_amount > 0 ? $automobile_total_amount : 0,
                                'automobile_trans_pkg_expiry' => '',
                                'automobile_trans_list_num' => '0',
                                'automobile_trans_list_expiry' => '0',
                                'automobile_trans_list_period' => '',
                            );
                            $automobile_total_amount = isset($automobile_total_amount) && $automobile_total_amount > 0 ? $automobile_total_amount : 0;
                            if ($automobile_total_amount > 0 && $inventory_expired_case != true) {
                                $automobile_trans_html = $automobile_emp_funs->automobile_pay_process($automobile_trans_fields);
                            }
                        }
                    } else {

                        if ($automobile_post_inventory == true) {
                            $automobile_ins_pkg = isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '';

                            if (isset($automobile_var_plugin_options['automobile_inventories_review_option']) && $automobile_var_plugin_options['automobile_inventories_review_option'] != 'on') {
                                $backend_status_check = 'active'; // automated active inventory if admin didn't set this option 
                            } else {
                                $backend_status_check = 'automobile_inventory_status';    // wait for approval if admin set this option
                            }
                            $automobile_ins_exp = $automobile_emp_funs->automobile_inventory_expiry($automobile_ins_pkg);
                            $automobile_inventory_fields = array(
                                'automobile_inventory_id' => rand(149344111, 991435901),
                                'automobile_inventory_user' => $automobile_posting_user,
                                'automobile_inventory_title' => isset($_POST['automobile_inventory_title']) ? $_POST['automobile_inventory_title'] : '',
                                'automobile_inventory_desc' => isset($_POST['automobile_inventory_desc']) ? $_POST['automobile_inventory_desc'] : '',
                                'automobile_inventory_dealer_type' => isset($_POST['automobile_inventory_dealer_type']) ? $_POST['automobile_inventory_dealer_type'] : '',
                                'automobile_inventory_types' => isset($_POST['automobile_inventory_types']) ? $_POST['automobile_inventory_types'] : '',
                                'automobile_inventory_expire' => $automobile_ins_exp,
                                'automobile_inventory_custom' => isset($_POST['automobile_cus_field']) ? $_POST['automobile_cus_field'] : '',
                                'automobile_inventory_pkg' => '',
                                'automobile_inventory_status' => $backend_status_check,
                                'automobile_post_loc_country' => isset($_POST['automobile_post_loc_country']) ? $_POST['automobile_post_loc_country'] : '',
                                'automobile_post_loc_region' => isset($_POST['automobile_post_loc_region']) ? $_POST['automobile_post_loc_region'] : '',
                                'automobile_post_loc_city' => isset($_POST['automobile_post_loc_city']) ? $_POST['automobile_post_loc_city'] : '',
                                'automobile_post_loc_address' => isset($_POST['automobile_post_loc_address']) ? $_POST['automobile_post_loc_address'] : '',
                                'automobile_post_loc_latitude' => isset($_POST['automobile_post_loc_latitude']) ? $_POST['automobile_post_loc_latitude'] : '',
                                'automobile_post_loc_longitude' => isset($_POST['automobile_post_loc_longitude']) ? $_POST['automobile_post_loc_longitude'] : '',
                                'automobile_add_new_loc' => isset($_POST['automobile_add_new_loc']) ? $_POST['automobile_add_new_loc'] : '',
                                'automobile_post_loc_zoom' => isset($_POST['automobile_post_loc_zoom']) ? $_POST['automobile_post_loc_zoom'] : '',
                                'automobile_inventory_makes' => isset($_POST['automobile_inventory_makes']) ? $_POST['automobile_inventory_makes'] : '',
                                'automobile_inventory_models' => isset($_POST['automobile_inventory_models']) ? $_POST['automobile_inventory_models'] : '',
                                'gallery_user_img' => isset($_POST['gallery_user_img']) ? $_POST['gallery_user_img'] : '',
                                'automobile_inventory_new_price' => isset($_POST['automobile_inventory_new_price']) ? $_POST['automobile_inventory_new_price'] : '',
                                'automobile_inventory_old_price' => isset($_POST['automobile_inventory_old_price']) ? $_POST['automobile_inventory_old_price'] : '',
                            );

                            if ($automobile_elem == true) {
                                $inventory_id = $automobile_emp_funs->automobile_add_inventory($automobile_inventory_fields, true);
                            } else {
                                $inventory_id = $automobile_emp_funs->automobile_add_inventory($automobile_inventory_fields);
                            }

                            $automobile_inventory_msg = esc_html__('Created Successfully.', 'cs-automobile');
                        } else {
                            $inventory_id = $automobile_inventory_id;
                            $automobile_inventory_msg = automobile_var_plugin_text_srt('automobile_var_update_successfully');
                        }
                        $automobile_total_amount = 0;
                        if (isset($_POST['inventory_pckge']) && $_POST['inventory_pckge'] <> '')
                            $automobile_total_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_emp_funs->get_pkg_field($_POST['inventory_pckge'], 'package_price'));

                        if (isset($_POST['automobile_inventory_featured']) && $_POST['automobile_inventory_featured'] != '')
                            $automobile_total_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount);
                        $automobile_smry_totl = $automobile_total_amount;
                        if ($automobile_vat_switch == 'on' && $automobile_pay_vat > 0) {
                            $automobile_vat_amount = $automobile_total_amount * ( $automobile_pay_vat / 100 );
                            $automobile_total_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_vat_amount) + $automobile_total_amount;
                        }

                        $automobile_trans_pkg = isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '';
                        $automobile_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);
                        $automobile_pkg_expiry = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration');
                        $automobile_pkg_duration = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration_period');
                        $automobile_pkg_expir_days = strtotime($automobile_emp_funs->automobile_date_conv($automobile_pkg_expiry, $automobile_pkg_duration));
                        $automobile_pkg_list_num = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_listings');
                        $automobile_pkg_list_exp = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_submission_limit');
                        $automobile_pkg_list_per = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'automobile_list_dur');
                        $automobile_trans_fields = array(
                            'automobile_inventory_id' => $inventory_id,
                            'automobile_trans_id' => rand(149344111, 991435901),
                            'automobile_trans_user' => $automobile_posting_user,
                            'automobile_package_title' => $automobile_pkg_title,
                            'automobile_trans_package' => isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '',
                            'automobile_trans_featured' => isset($_POST['automobile_inventory_featured']) ? $_POST['automobile_inventory_featured'] : '',
                            'automobile_trans_amount' => $automobile_total_amount,
                            'automobile_trans_pkg_expiry' => $automobile_pkg_expir_days,
                            'automobile_trans_list_num' => $automobile_pkg_list_num,
                            'automobile_trans_list_expiry' => $automobile_pkg_list_exp,
                            'automobile_trans_list_period' => $automobile_pkg_list_per,
                        );

                        if ($automobile_total_amount > 0 && $inventory_expired_case != true) {
                            $automobile_trans_html = $automobile_emp_funs->automobile_pay_process($automobile_trans_fields);
                        }
                    }
                }
            }
            $automobile_act_class = 'active';
            $automobile_conf_class = 'cs-confrmation-tab';
            $automobile_conf_act_class = '';
            if (( isset($_POST['automobile_pkg_trans']) && $_POST['automobile_pkg_trans'] == 1 && isset($automobile_total_amount) && $automobile_total_amount > 0 ) || isset($_POST['invoice'])) {
                $automobile_act_class = '';
                $automobile_conf_class = '';
                $automobile_conf_act_class = 'active';
            }
            $automobile_access = true;
            if (isset($_GET['inventory_id']) && $_GET['inventory_id'] != '' && $automobile_inventory_emplyr != $current_user->ID) {
                $automobile_access = false;
            }
            if ($automobile_access == true) {
                $automobile_emp_dashboard = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : '';
                $qry_str = '';
                if (isset($_GET['inventory_id'])) {
                    $qry_str .= '&inventory_id=' . $_GET['inventory_id'];
                }
                if (isset($_GET['action'])) {
                    $qry_str .= '&action=' . $_GET['action'];
                }
                if ($qry_str != '') {
                    $automobile_emp_dash_link = get_permalink($automobile_emp_dashboard) . '?profile_tab=edit-user-car-listing' . $qry_str;
                } else {
                    $automobile_emp_dash_link = get_permalink($automobile_emp_dashboard) . '?profile_tab=user-post-vehicle';
                }
                ?>
                <div class="scetion-title">
                    <h4>
                        <?php
                        if (isset($_GET['inventory_id']) && $_GET['inventory_id'] != '') {
                            if (isset($automobile_inventory_titl)) {
                                echo automobile_var_plugin_text_srt('automobile_var_edit_inventory') . " -> " . esc_attr($automobile_inventory_titl);
                            } else {
                                echo automobile_var_plugin_text_srt('automobile_var_edit_inventory');
                            }
                        } else {
                            echo automobile_var_plugin_text_srt('automobile_var_post_inventory');
                        }
                        ?>
                    </h4>
                    <?php if (isset($_POST['automobile_pkg_trans'])) { ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cs-confirmation">


                            <?php
                            if (isset($automobile_var_plugin_options['automobile_inventory_welcome_title']) && $automobile_var_plugin_options['automobile_inventory_welcome_title'] != '') {
                                echo '<h5>' . $automobile_var_plugin_options['automobile_inventory_welcome_title'] . '</h5>';
                            }
                            if (isset($automobile_var_plugin_options['automobile_inventory_welcome_con']) && $automobile_var_plugin_options['automobile_inventory_welcome_con'] != '') {
                                echo '<p>' . $automobile_var_plugin_options['automobile_inventory_welcome_con'] . '</p>';
                            }
                            ?>

                        </div>
                    <?php } ?>
                </div>
                <div class="dashboard-content-holder">          
                    <div class="cs-post-inventory<?php
                    if (!is_user_logged_in()) {
                        echo ' cs-prevent';
                    }
                    ?>">
                             <?php if (isset($automobile_inventory_msg) && $automobile_inventory_msg != '') { ?>
                            <div class="alert alert-success alt-msg">
                                <?php echo esc_attr($automobile_inventory_msg) ?>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </div>
                        <?php } ?>
                        <?php
                        if ($automobile_elem == true) {
                            $automobile_emp_dash_link = get_permalink($automobile_pag_id);
                        }
                        ?>
                        <?php
                        $automobile_var_inventory_types = array();
                        $automobile_var_inventory_types[0] = __('--select--', 'automobile');
                        $args = array('posts_per_page' => -1, 'order' => 'ASC', 'post_type' => 'inventory-type');
                        $postslist = get_posts($args);
                        foreach ($postslist as $post) :
                            setup_postdata($post);
                            ?> 
                            <?php $automobile_var_inventory_types[$post->post_name] = get_the_title(); ?>
                            <?php
                        endforeach;
                        wp_reset_postdata();
                        ?>
                        <form name= "cs-emp-form" action="<?php echo esc_url_raw($automobile_emp_dash_link) ?>" method="post" id="cs-emp-form" data-ajaxurl="<?php echo esc_url(admin_url('admin-ajax.php')) ?>" enctype="multipart/form-data" class="user-post-vehicles">
                            <ul class="post-step tabs-nav">
                                <li class="<?php echo sanitize_html_class($automobile_act_class) ?>">
                                    <h6><a href="cs-tab1" id="cs-detail-tab"></a></h6>
                                </li>


                            </ul>
                            <div class="tabs-content">
                                <div class="tabs" id="cs-tab1">
                                    <div class="input-info">
                                        <div class="row">
                                            <?php
                                            $stringObj = new automobile_plugin_all_strings();
                                            $stringObj->automobile_var_plugin_login_strings();
                                            if (!is_user_logged_in()) {
                                                ?>
                                                <div class="col-md-12">
                                                    <div role="alert" class="alert alert-dismissible user-message"> 
                                                        <span>
                                                            <button aria-label="<?php echo automobile_var_plugin_text_srt('automobile_var_close'); ?>" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                                            <?php echo automobile_var_plugin_text_srt('automobile_var_dont_account') . ' <a onclick="trigger_func(\'#btn-header-main-login\');">' . ('automobile_var_log_in') . '</a>'; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <small class="cs-chk-msg" id="cs-email-chk"></small>
                                                <?php
                                            }
                                            ?>
                                            <div class="cs-field-holder">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h6><?php echo automobile_var_plugin_text_srt('automobile_var_vehicles_information'); ?></h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="cs-seprator"></div>
                                            </div>
                                            <div class="cs-field-holder">
                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label><?php echo automobile_var_plugin_text_srt('automobile_var_vehicle_title'); ?></label>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                    <div class="cs-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            'id' => 'inventory_title',
                                                            'std' => isset($automobile_inventory_titl) ? $automobile_inventory_titl : '',
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'required' => 'yes',
                                                            'hint_text' => '',
                                                        );


                                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                                                        if (isset($_GET['inventory_id']) && $_GET['inventory_id'] != '') {      // when a inventory edit then set old inventory title 
                                                            $automobile_opt_array = array(
                                                                'id' => 'old_inventory_title',
                                                                'std' => isset($automobile_inventory_titl) ? $automobile_inventory_titl : '',
                                                                'return' => true,
                                                                'prefix' => '',
                                                            );
                                                            echo force_balance_tags($automobile_form_fields->automobile_form_hidden_render($automobile_opt_array));
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cs-field-holder">
                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label><?php echo automobile_var_plugin_text_srt('automobile_var_vehicle_price_old'); ?></label>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                    <div class="cs-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            'id' => 'inventory_old_price',
                                                            'std' => isset($automobile_inventory_old_price) ? $automobile_inventory_old_price : '',
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'required' => 'yes',
                                                            'hint_text' => '',
                                                        );


                                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cs-field-holder">
                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label><?php echo automobile_var_plugin_text_srt('automobile_var_vehicle_price_new'); ?></label>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                    <div class="cs-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            'id' => 'inventory_new_price',
                                                            'std' => isset($automobile_inventory_new_price) ? $automobile_inventory_new_price : '',
                                                            'desc' => '',
                                                            'classes' => 'form-control',
                                                            'required' => 'yes',
                                                            'hint_text' => '',
                                                        );


                                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="cs-field-holder">
                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label><?php echo automobile_var_plugin_text_srt('automobile_var_description'); ?> </label>
                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                    <div class="cs-field1">
                                                        <?php
                                                        $automobile_default_cont_inv = isset($automobile_inventory_descreption) ? $automobile_inventory_descreption : '';
                                                        wp_editor($automobile_default_cont_inv, 'automobile_inventory_desc', array(
                                                            'textarea_name' => 'automobile_inventory_desc',
                                                            'editor_class' => 'text-input',
                                                            'teeny' => true,
                                                            'media_buttons' => false,
                                                            'textarea_rows' => 6,
                                                            'quicktags' => false
                                                                )
                                                        );
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">

                                                /*
                                                 * modern selection box function
                                                 */
                                                jQuery(document).ready(function ($) {
                                                    chosen_selectionbox();
                                                });
                                                /*
                                                 * modern selection box function
                                                 */
                                                tinymce.init({
                                                    selector: "textarea#automobile_inventory_desc",
                                                    menubar: false,
                                                    setup: function (editor) {
                                                        editor.on('change', function () {
                                                            editor.save();
                                                        });
                                                    }
                                                });
                                                tinymce.editors = [];
                                            </script>

                                            <div class="cs-field-holder">
                                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <h6><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_inventory_type')) ?></h6>

                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                    <div class="cs-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            "name" => automobile_var_plugin_text_srt('automobile_var_inventory_type'),
                                                            "desc" => "",
                                                            "id" => "inventory_type",
                                                            "std" => isset($automobile_inventory_type) ? $automobile_inventory_type : '',
                                                            'classes' => 'chosen-select-no-single',
                                                            "type" => "select_values",
                                                            'required' => 'yes',
                                                            "extra_atr" => 'onchange="getval(this)"',
                                                            "options" => $automobile_var_inventory_types,
                                                        );
                                                        echo force_balance_tags($automobile_form_fields->automobile_form_select_render($automobile_opt_array));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="loader-response-div"> </div>
                                            </div>
                                            <div class="ajax-response-div"> </div>

                                            <div class="inventory-location-fields">
                                                <?php
                                                global $automobile_var_plugin_core, $automobile_html_fields;

                                                $automobile_var_plugin_core->automobile_location_fields_front($automobile_inventory_id, 'dealer_profile');
                                                ?>
                                            </div>


                                            <div class="cs-field-holder">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <h6><?php echo automobile_var_plugin_text_srt('automobile_var_upload_images'); ?></h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="cs-seprator"></div>
                                            </div>

                                            <div class="cs-fields-holder">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                    <div id="multipleuploader">

                                                        <?php
                                                        $user = get_current_user_id();
                                                        global $post, $automobile_form_fields, $automobile_html_fields, $automobile_plugin_options, $automobile_html_fields_frontend;
                                                        $automobile_opt_array = array(
                                                            'std' => '',
                                                            'user' => '',
                                                            'id' => 'gallery_user_img',
                                                            'name' => '',
                                                            'desc' => '',
                                                            'hint_text' => '',
                                                            'echo' => true,
                                                            'field_params' => array(
                                                                'usermeta' => true,
                                                                'gallery' => $automobile_inventory_gallery,
                                                                'std' => '',
                                                                'id' => 'gallery_user_img',
                                                                'return' => true,
                                                            ),
                                                        );
                                                        $automobile_form_fields->automobile_multiple_inventory_upload_file_field($automobile_opt_array);
                                                        ?>
                                                    </div>
                                                    <div id="multipleuploader-new-loads"></div>

                                                </div>
                                            </div>
                                            <div class="cs-field-holder">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="cs-upload-img">

                                                        <p><?php echo automobile_var_plugin_text_srt('automobile_var_upload_images_dis'); ?></p>
                                                        <p><?php echo automobile_var_plugin_text_srt('automobile_var_upload_images_hint'); ?></p>
                                                        <p></p>
                                                        <div class="cs-browse-holder"><span class="file-input btn-file">
                                                                <a id="duplicatorbtn" onlick="duplicate()" class="btn button"><?php echo automobile_var_plugin_text_srt('automobile_var_upload_photos'); ?></a>
                                                            </span></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <script>

                                                document.getElementById('duplicatorbtn').onclick = duplicate;
                                                var i = 0;
                                                var original = document.getElementById('multipleuploader').html;
                                                function duplicate() {
                                                    counter = 2;
                                                    jQuery("#multipleuploader-new-loads").append('<div class="adding-more-img">\n\
                <input multiple id="automobile_gallery_user_img" name="gallery_user_img[]" type="hidden" class="" value="">\n\
                <input name="automobile_gallery_user_img_media[]" type="file" value="Browse">\n\
                <div class="page-wrap" style="display: none;" id="automobile_gallery_user_img_box">\n\
                <div class="gal-active"><div class="dragareamain" style="padding-bottom:0px;">\n\
                <ul id="gal-sortable"><li class="ui-state-default" id=""><div class="thumb-secs">\n\
                <img src="" id="automobile_gallery_user_img_img" width="100" alt="">\n\
                <div class="gal-edit-opts">\n\
                <a href="javascript:del_media(\'automobile_gallery_user_img\')" class="delete"></a> </div></div></li></ul></div></div></div><p></p></div>');
                                                    counter++;
                                                    ;
                                                }
                                            </script>
                                            <?php
                                            if (class_exists('automobile_dealer_functions')) {
                                                if ($automobile_inventory_id <> '' && is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID) {
                                                    echo force_balance_tags($automobile_emp_funs->automobile_custom_fields($automobile_inventory_id), true);
                                                } else {
                                                    echo force_balance_tags($automobile_emp_funs->automobile_custom_fields(), true);
                                                }
                                            }
                                            if ($automobile_status_changing == true) {
                                                
                                            }
                                            ?>
                                            <div class="cs-field-holder">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-md-12">
                                                    <div class="cs-field">
                                                        <div class="cs-btn-submit">
                                                            <input type="button" onclick="validateForm()" data-toggle="modal" class="btn btn-info btn-lg" value="<?php echo automobile_var_plugin_text_srt('automobile_var_submit_continue'); ?>" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                jQuery(document).ready(function () {
                                                    selectedval = document.getElementById('automobile_inventory_type');

                                                    if (selectedval != '') {
                                                        getval(selectedval);
                                                    }
                                                });
                                                function getval(inventory_type) {

                                                    if (inventory_type.value != 0)
                                                    {
                                                        jQuery('.loader-response-div').html('<div class="cs-fields-loader"><i class="icon-spinner icon-spin"></i></div>');
                                                        var query = window.location.search.substring(1);
                                                        var automobile_inventory_id;
                                                        var vars = query.split("&");
                                                        for (var i = 0; i < vars.length; i++) {
                                                            var pair = vars[i].split("=");
                                                            if (pair[0] == 'inventory_id') {
                                                                automobile_inventory_id = pair[1];
                                                                //   alert(automobile_inventory_id);
                                                            }
                                                        }
                                                        var dataString = 'action=get_inventory_type_ajax_results&automobile_inventory_type=' + inventory_type.value + '&automobile_inventory_id=' + automobile_inventory_id;
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo admin_url(); ?>/admin-ajax.php",
                                                            data: dataString,
                                                            success: function (response) {
                                                                //alert(response);
                                                                if (response != 'error') {
                                                                    jQuery('.loader-response-div').html('');
                                                                    jQuery('.ajax-response-div').html(response);
                                                                } else {
                                                                    alert('error');
                                                                }
                                                            }
                                                        });
                                                    }

                                                }

                                            </script>

                                        </div>
                                    </div>
                                </div>



                                <?php
                                $automobile_summry_init = 0;
                                $automobile_summry_pkg = '';
                                if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
                                    $automobile_pkg_contr = 0;
                                    foreach ($automobile_packages_options as $pckg_key => $pckg) {
                                        if (isset($pckg_key) && $pckg_key <> '') {
                                            $pckg_id = isset($pckg['package_id']) ? $pckg['package_id'] : '';
                                            $pckg_price = isset($pckg['package_price']) ? $pckg['package_price'] : '';

                                            $automobile_pckg_price = $pckg_price;
                                            if (is_user_logged_in() && $automobile_emp_funs->automobile_is_pkg_subscribed($pckg_id)) {
                                                $automobile_pckg_price = 0;
                                            }

                                            if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $automobile_inventory_id <> '' && $automobile_emp_funs->automobile_update_pkg_subs('', $inventory_pckge_id)) {
                                                $automobile_summry_pkg = $automobile_emp_funs->automobile_update_pkg_subs(true, $inventory_pckge_id);
                                                $automobile_summry_pkg = isset($automobile_summry_pkg['pkg_id']) ? $automobile_summry_pkg['pkg_id'] : '';
                                                $automobile_summry_init = 0;
                                            } else if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $automobile_inventory_id <> '' && $automobile_inventory_expiry >= $automobile_current_date && $automobile_inventory_pkg != '') {
                                                $automobile_summry_pkg = $automobile_inventory_pkg;
                                                $automobile_summry_init = 0;
                                            } else if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $automobile_inventory_id <> '' && $automobile_inventory_pkg != '' && $automobile_emp_funs->get_pkg_field($automobile_inventory_pkg, 'package_price') <= 0) {
                                                $automobile_summry_pkg = $automobile_inventory_pkg;
                                                $automobile_summry_init = 0;
                                            } else {

                                                if ($automobile_pkg_contr == 0) {
                                                    $automobile_summry_pkg = $pckg_id;
                                                    $automobile_summry_init = $automobile_pckg_price;
                                                }
                                            }
                                        }
                                        $automobile_pkg_contr++;
                                    }
                                }
                                ?>
                                <div class="cs-package-modal">
                                    <div class="modal fade in" id="myModal" role="dialog" style="display: block;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                        <div class="cs-featured-holder">
                                                            <div class="cs-featured-list">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="cs-field">
                                                                            <input type="checkbox" id="featured">

                                                                            <?php
                                                                            if ($automobile_feature_amount <> '') {
                                                                                if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $get_inventory_feat == 'yes' || $get_inventory_feat == 'on') {
                                                                                    $cspaid_class = ' class="cs-paid" checked="checked"';
                                                                                } else {
                                                                                    $cspaid_class = '';
                                                                                }
                                                                                ?>


                                                                                <input type="checkbox" id="automobile_inventory_featured" data-price="<?php echo AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount) ?>" name="automobile_inventory_featured"<?php
                                                                                if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $get_inventory_feat == 'yes') {
                                                                                    echo ' class="cs-paid" checked="checked"';
                                                                                }
                                                                                ?>>

                                                                                <label for="automobile_inventory_featured"><?php echo automobile_var_plugin_text_srt('automobile_var_list_your_post'); ?><span><?php echo automobile_var_plugin_text_srt('automobile_var_subscription_submition'); ?></span></label>
                                                                                <?php
                                                                                $automobile_inventory_feat_txt = isset($automobile_var_plugin_options['automobile_inventory_feat_txt']) ? $automobile_var_plugin_options['automobile_inventory_feat_txt'] : '';
                                                                                echo '<br>' . $automobile_inventory_feat_txt;
                                                                            }
                                                                            ?>

                                                                        </div>

                                                                        <div class="cs-featured-list-price">
                                                                            <span><?php echo AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_feature_amount) ?> </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="cs-package-detail"<?php if ($automobile_vat_switch == 'on') { ?> data-vatp="<?php echo AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_pay_vat) ?>" data-vat=""<?php } ?>>


                                                                <div class="package-list">
                                                                    <h6><?php echo automobile_var_plugin_text_srt('automobile_var_select_packcage'); ?></h6>
                                                                    <?php
                                                                    if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $automobile_inventory_id <> '' && $automobile_emp_funs->automobile_update_pkg_subs('', $inventory_pckge_id) && $automobile_inventory_expiry >= $automobile_current_date) {

                                                                        $automobile_subscribed_pkg = $automobile_emp_funs->automobile_update_pkg_subs(true, $inventory_pckge_id);

                                                                        if (isset($automobile_subscribed_pkg['pkg_id']) && $automobile_subscribed_pkg['pkg_id'] == $inventory_pckge_id) {
                                                                            echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_emp_funs->automobile_user_pkg_detail($automobile_subscribed_pkg));
                                                                        } else if ($inventory_pckge_id <> '' && $automobile_emp_funs->automobile_is_pkg_subscribed($inventory_pckge_id)) {
                                                                            echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_emp_funs->automobile_user_pkg_detail($inventory_pckge_id));
                                                                        } else {
                                                                            if ($inventory_pckge_id <> '' && $automobile_emp_funs->get_pkg_field($inventory_pckge_id) != '' && $automobile_emp_funs->get_pkg_field($inventory_pckge_id, 'package_price') <= 0) {
                                                                                printf(__('You are using "%s" Package.', 'automobile'), $automobile_emp_funs->get_pkg_field($inventory_pckge_id));
                                                                            }
                                                                        }
                                                                        $automobile_opt_array = array(
                                                                            'std' => $inventory_pckge_id,
                                                                            'id' => '',
                                                                            'echo' => true,
                                                                            'cust_name' => 'inventory_pckge',
                                                                        );
                                                                        $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                                                    } else if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $automobile_inventory_id <> '' && $automobile_inventory_expiry >= $automobile_current_date && $automobile_inventory_pkg != '') {
                                                                        echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_emp_funs->automobile_user_pkg_detail($automobile_inventory_pkg, $automobile_inventory_expiry));
                                                                        $automobile_opt_array = array(
                                                                            'std' => '0',
                                                                            'id' => '',
                                                                            'echo' => true,
                                                                            'cust_name' => 'inventory_pckge',
                                                                        );
                                                                        $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                                                    } else {

                                                                        if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
                                                                            ?>
                                                                            <ul>
                                                                                <?php
                                                                                $automobile_pkg_counter = 0;
                                                                                foreach ($automobile_packages_options as $package_key => $package) {
                                                                                    if (isset($package_key) && $package_key <> '') {
                                                                                        $package_id = isset($package['package_id']) ? $package['package_id'] : '';
                                                                                        $package_title = isset($package['package_title']) ? $package['package_title'] : '';
                                                                                        $package_price = isset($package['package_price']) ? $package['package_price'] : '';
                                                                                        $package_listings = isset($package['package_listings']) ? $package['package_listings'] : '';
                                                                                        $package_submission_limit = isset($package['package_submission_limit']) ? $package['package_submission_limit'] : '';
                                                                                        $automobile_list_dur = isset($package['automobile_list_dur']) ? $package['automobile_list_dur'] : '';
                                                                                        $package_duration = isset($package['package_duration']) ? $package['package_duration'] : '';
                                                                                        $package_duration_period = isset($package['package_duration_period']) ? $package['package_duration_period'] : '';
                                                                                        $package_description = isset($package['package_description']) ? $package['package_description'] : '';
                                                                                        $automobile_package_type = isset($package['package_type']) ? $package['package_type'] : '';
                                                                                        $automobile_package_type_text = $automobile_package_type == "single" ? automobile_var_plugin_text_srt('automobile_var_single_submission') : automobile_var_plugin_text_srt('automobile_var_subscription');
                                                                                        $automobile_pkg_chkd = '';
                                                                                        if ($automobile_pkg_counter == 0) {
                                                                                            $automobile_pkg_chkd = ' checked="checked"';
                                                                                        }
                                                                                        $automobile_pckg_price = $package_price;
                                                                                        if (is_user_logged_in() && $automobile_emp_funs->automobile_is_pkg_subscribed($package_id)) {
                                                                                            $automobile_pckg_price = 0;
                                                                                        }
                                                                                        ?>


                                                                                        <?php
                                                                                        $automobile_opt_array = array(
                                                                                            'std' => $package_id,
                                                                                            'id' => '',
                                                                                            'return' => true,
                                                                                            'cust_type' => 'radio',
                                                                                            'extra_atr' => 'data-price="' . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_pckg_price) . '" data-title="' . $package_title . '"  ' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_pkg_chkd) . '',
                                                                                            'cust_id' => 'inventory_pckge_' . $package_id,
                                                                                            'cust_name' => 'inventory_pckge',
                                                                                            'prefix' => '',
                                                                                        );
                                                                                        ?>






                                                                                        <?php if ($package_description != '') { ?>

                                                                                        <?php } ?>											<li>
                                                                                            <div class="package-content">
                                                                                                <ul>

                                                                                                    <li> <?php
                                                                                                        echo $package_title;
                                                                                                        if ($automobile_emp_funs->automobile_is_pkg_subscribed($package_id)) {
                                                                                                            ?><em> <?php echo automobile_var_plugin_text_srt('automobile_var_already_purchased'); ?> </em> <?php } ?></li>
                                                                                                    <li><?php echo $package_submission_limit . ' ' . $automobile_list_dur . ' listing'; ?><span><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($package_description) ?></span></li>
                                                                                                    <li> <?php echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($package_price); ?> <span>/<?php echo $package_duration_period; ?></span></li>
                                                                                                    <li>
                                                                                                        <div class="cs-field">
                                                                                                            <?php echo force_balance_tags($automobile_form_fields->automobile_form_text_render($automobile_opt_array)); ?>
                                                                                                            <label for="<?php echo 'inventory_pckge_' . $package_id; ?>"></label>

                                                                                                        </div>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </li>
                                                                                        <ul>




                                                                                            <?php
                                                                                        }
                                                                                        $automobile_pkg_counter++;
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                </div>
                                                            </div>
                                                            <div class="cs-package-payment contact-box cs-pay-box" style="display:<?php echo ( $automobile_summry_init > 0 ) ? 'block' : 'none' ?>;">
                                                                <h6><?php echo automobile_var_plugin_text_srt('automobile_var_make_payments'); ?></h6>
                                                                <ul>
                                                                    <li>
                                                                        <?php
                                                                        global $gateways;
                                                                        $automobile_gateway_options = get_option('automobile_var_plugin_options');

                                                                        $automobile_gw_counter = 1;
                                                                        if (is_array($gateways)) {
                                                                            foreach ($gateways as $key => $value) {
                                                                                $status = $automobile_gateway_options[strtolower($key) . '_status'];
                                                                                if (isset($status) && $status == 'on') {
                                                                                    $logo = '';
                                                                                    if (isset($automobile_gateway_options[strtolower($key) . '_logo'])) {
                                                                                        $logo = $automobile_gateway_options[strtolower($key) . '_logo'];
                                                                                    }
                                                                                    if (isset($logo) && $logo != '') {
                                                                                        $automobile_checked = $automobile_gw_counter == 1 ? ' checked="checked"' : '';
                                                                                        $automobile_active = $automobile_gw_counter == 1 ? ' class="active"' : '';
                                                                                        ?>
                                                                                                                                                                                                                                        <!-- <li <?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_active) ?>>
                                                                                                                                                                                                                                        <a><img alt="" src="<?php echo esc_url($logo) ?>"></a> 
                                                                                        <?php
                                                                                        $automobile_opt_array = array(
                                                                                            'std' => $key,
                                                                                            'id' => $key,
                                                                                            'return' => true,
                                                                                            'cust_type' => 'radio',
                                                                                            'extra_atr' => 'style="display:none; position:absolute;" ' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_checked),
                                                                                            'cust_name' => 'automobile_payment_gateway',
                                                                                            'prefix' => '',
                                                                                        );
                                                                                        ?>
                                                                                                                                                                                                                                        </li>-->
                                                                                        <div class="radiobox">
                                                                                            <?php echo force_balance_tags($automobile_form_fields->automobile_form_text_render($automobile_opt_array)); ?>
                                                                                            <label for="automobile_<?php echo $key; ?>"><img alt="" src="<?php echo esc_url($logo) ?>"></label>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    $automobile_gw_counter++;
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </li>	

                                                                </ul>
                                                                <?php
                                                                $automobile_inventory_pay_txt = isset($automobile_var_plugin_options['automobile_inventory_pay_txt']) ? $automobile_var_plugin_options['automobile_inventory_pay_txt'] : '';
                                                                echo '<br>' . $automobile_inventory_pay_txt;
                                                                ?>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="cs-voucher-list">

                                                            <ul class="cs-sumry-clacs" data-subs="<?php echo automobile_var_plugin_text_srt('automobile_var_subscription'); ?>" data-feat="<?php echo automobile_var_plugin_text_srt('automobile_var_featured_listing'); ?>" data-total="<?php echo automobile_var_plugin_text_srt('automobile_var_total'); ?>" data-vat="<?php printf(__('VAT (%s&#37;)', 'automobile'), $automobile_pay_vat) ?>" data-gtotal="<?php echo automobile_var_plugin_text_srt('automobile_var_grand_total'); ?>" data-currency="<?php echo esc_attr($currency_sign) ?>">
                                                                <?php
                                                                if ($automobile_summry_pkg != '') {
                                                                    ?>
                                                                    <li>
                                                                        <span><?php echo esc_attr($automobile_emp_funs->get_pkg_field($automobile_summry_pkg)) . ' ' . automobile_var_plugin_text_srt('automobile_var_subscription') ?></span>
                                                                        <strong><?php echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_summry_init) ?></strong>
                                                                    </li>
                                                                    <?php
                                                                    if ($automobile_vat_switch == 'on' && $automobile_summry_init > 0) {
                                                                        if ($automobile_pay_vat > 0) {
                                                                            $automobile_s_vat_amount = $automobile_summry_init * ( $automobile_pay_vat / 100 );
                                                                            $automobile_summry_init = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_s_vat_amount) + $automobile_summry_init;
                                                                            ?>
                                                                            <li>
                                                                                <span><?php printf(__('VAT (%s&#37;)', 'automobile'), $automobile_pay_vat) ?></span>
                                                                                <strong><?php echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_s_vat_amount) ?></strong>
                                                                            </li>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <?php if (isset($automobile_feature_amount) && $automobile_feature_amount > 0) {
                                                                        ?>


                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                <li class="grand-total">
                                                                    <span><?php echo automobile_var_plugin_text_srt('automobile_var_grand_total'); ?></span>
                                                                    <strong><?php echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_summry_init) ?></strong>
                                                                </li>
                                                            </ul>
                                                            <div class="cs-field">
                                                                <div class="cs-btn-submit contact-box cs-pay-box" style="display:<?php echo ( $automobile_summry_init > 0 ) ? 'block' : 'none' ?>;">

                                                                    <?php
                                                                    $automobile_pay_btn = 'automobile_pay_btn';
                                                                    if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $automobile_inventory_id <> '') {
                                                                        $automobile_pay_btn = 'automobile_update_inventory';
                                                                    }
                                                                    $automobile_opt_array = array(
                                                                        'std' => automobile_var_plugin_text_srt('automobile_var_continue_pay'),
                                                                        'id' => '',
                                                                        'return' => true,
                                                                        'cust_type' => 'submit',
                                                                        'classes' => 'continue-btn acc-submit cs-section-update btn btn-info btn-lg',
                                                                        'cust_name' => $automobile_pay_btn,
                                                                    );
                                                                    echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                                    $automobile_opt_array = array(
                                                                        'std' => '1',
                                                                        'id' => '',
                                                                        'return' => true,
                                                                        'cust_name' => 'automobile_pkg_trans',
                                                                    );
                                                                    echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                                                    ?>
                                                                </div>
                                                                <div class="contact-box cs-add-up-box" style="display:<?php echo ( $automobile_summry_init > 0 ) ? 'none' : 'block' ?>;">
                                                                    <div class="cs-field">                      
                                                                        <?php
                                                                        if (is_user_logged_in() && $automobile_inventory_emplyr == $current_user->ID && $automobile_inventory_id <> '') {

                                                                            $automobile_opt_array = array(
                                                                                'std' => automobile_var_plugin_text_srt('automobile_var_update'),
                                                                                'id' => '',
                                                                                'return' => true,
                                                                                'classes' => 'continue-btn btn btn-info btn-lg',
                                                                                'cust_type' => 'submit',
                                                                                'cust_name' => 'automobile_update_inventory',
                                                                                'prefix' => '',
                                                                            );
                                                                            echo force_balance_tags($automobile_form_fields->automobile_form_text_render($automobile_opt_array));
                                                                        } else {
                                                                            $automobile_opt_array = array(
                                                                                'std' => automobile_var_plugin_text_srt('automobile_var_post_inventory'),
                                                                                'id' => '',
                                                                                'return' => true,
                                                                                'classes' => 'continue-btn btn btn-info btn-lg',
                                                                                'cust_type' => 'submit',
                                                                                'cust_name' => 'automobile_create_inventory',
                                                                                'prefix' => '',
                                                                            );
                                                                            echo force_balance_tags($automobile_form_fields->automobile_form_text_render($automobile_opt_array));
                                                                        }
                                                                        ?>			</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>										
                                </div>
                                <script>

                                    jQuery('#myModal').hide();


                                </script>


                                <div class="tabs" id="cs-tab3">
                                    <div class="col-md-10 cs-confirmation">
                                        <?php
                                        if (( isset($_POST['automobile_pkg_trans']) && $_POST['automobile_pkg_trans'] == 1 && isset($automobile_total_amount) && $automobile_total_amount > 0 ) || isset($_POST['invoice'])) {
                                            ?>
                                            <span class="mail"><i class="icon-mail"></i></span>
                                            <?php
                                            $automobile_inventory_welcome_title = isset($automobile_var_plugin_options['automobile_inventory_welcome_title']) ? $automobile_var_plugin_options['automobile_inventory_welcome_title'] : '';
                                            if ($automobile_inventory_welcome_title <> '') {
                                                ?>
                                                <h3><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_inventory_welcome_title) ?></h3>
                                                <?php
                                            }
                                            $automobile_inventory_welcome_con = isset($automobile_var_plugin_options['automobile_inventory_welcome_con']) ? $automobile_var_plugin_options['automobile_inventory_welcome_con'] : '';
                                            if ($automobile_inventory_welcome_con <> '') {
                                                ?>
                                                <p><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_inventory_welcome_con) ?></p>
                                                <?php
                                            }
                                            ?>
                                            <div class="packege-detial">
                                                <?php
                                                $post_pkg = isset($_POST['inventory_pckge']) ? $_POST['inventory_pckge'] : '';
                                                if (isset($_POST['invoice']) && $_POST['invoice'] != '') {
                                                    $pkg_type = get_post_meta($_POST['invoice'], 'automobile_transaction_type', true);

                                                    $post_pkg = get_post_meta($_POST['invoice'], 'automobile_transaction_package', true);
                                                }
                                                if ($post_pkg != '') {
                                                    ?>
                                                    <h4><i class="icon-check-circle"></i><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_emp_funs->get_pkg_field($post_pkg)) . automobile_var_plugin_text_srt('automobile_var_package_subscription') ?></h4>
                                                    <?php
                                                }

                                                if (isset($automobile_smry_totl) && isset($automobile_pay_vat)) {
                                                    if (isset($automobile_vat_amount)) {
                                                        $automobile_grand_totl = $automobile_smry_totl + $automobile_vat_amount;
                                                    } else {
                                                        $automobile_grand_totl = $automobile_smry_totl + 0;
                                                    }
                                                    ?>
                                                    <ul>
                                                        <li><?php echo automobile_var_plugin_text_srt('automobile_var_total_charges'); ?><span><?php echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_smry_totl) ?></span></li>
                                                        <li><?php printf(__('VAT (%s&#37;)', 'automobile'), $automobile_pay_vat) ?><span><?php
                                                                if (!isset($automobile_vat_amount))
                                                                    $automobile_vat_amount = 0;
                                                                echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_vat_amount)
                                                                ?></span></li>
                                                        <li><?php echo automobile_var_plugin_text_srt('automobile_var_grand_total'); ?><span><?php
                                                                if (!isset($automobile_grand_totl))
                                                                    $automobile_grand_totl = 0;
                                                                echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_grand_totl)
                                                                ?></span></li>
                                                    </ul>
                                                    <?php
                                                } else if (isset($_POST['invoice']) && $_POST['invoice'] != '') {

                                                    $trans_amount = get_post_meta($_POST['invoice'], 'automobile_transaction_amount', true);
                                                    if ($trans_amount != '' && $trans_amount > 0) {
                                                        ?>
                                                        <ul>
                                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_total_charges'); ?><span><?php echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($trans_amount) ?></span></li>
                                                        </ul>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            if (isset($automobile_trans_html)) {
                                                echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_trans_html);
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (isset($_POST['automobile_posting']) && $_POST['automobile_posting'] == 'new') {
                                $automobile_opt_array = array(
                                    'std' => 'new',
                                    'id' => '',
                                    'return' => true,
                                    'cust_name' => 'automobile_posting',
                                    'prefix' => '',
                                );
                                echo force_balance_tags($automobile_form_fields->automobile_form_hidden_render($automobile_opt_array));
                            }
                            ?>
                        </form>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="unauthorized">
                            <?php echo automobile_var_plugin_text_srt('automobile_var_not_authorized'); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <script>
                /*
                 * modern selection box function
                 */
                jQuery(document).ready(function ($) {
                    chosen_selectionbox();
                });
                /*
                 * modern selection box function
                 */
            </script>
            <?php
            if ($uid != '') {
                die();
            }
        }

        public function get_inventory_type_ajax_results() {
            global $automobile_var_plugin_static_text;
            $automobile_inventory_type_id = isset($_POST['automobile_inventory_type']) ? $_POST['automobile_inventory_type'] : '';
            $automobile_inventory_id = isset($_POST['automobile_inventory_id']) ? $_POST['automobile_inventory_id'] : '';

            global $automobile_emp_functions;
            $inventory_id = isset($_GET['inventory_id']) ? $_GET['inventory_id'] : '111';
            // echo $automobile_inventory_type_id;
            $args = array(
                'name' => $automobile_inventory_type_id,
                'post_status' => 'publish',
                'post_type' => 'inventory-type'
            );
            $automobile_inventory_type = get_posts($args);
            if (isset($automobile_inventory_type[0]->ID)) {

                $automobile_emp_functions->inventory_makes($automobile_inventory_type[0]->ID, $automobile_inventory_id);
                $automobile_emp_functions->inventory_models($automobile_inventory_type[0]->ID, $automobile_inventory_id);
                echo '<div class="cs-field-holder">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<h6>' . automobile_var_plugin_text_srt('automobile_var_accessories_options') . '</h6>
										</div>
									</div><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="cs-seprator"></div>
									</div>';
                $automobile_emp_functions->inventory_type_custom_fields($automobile_inventory_type[0]->ID, $automobile_inventory_id);
                $automobile_emp_functions->automobile_inventory_feature_fields($automobile_inventory_type[0]->ID, $automobile_inventory_id);
            }
            ?>



            <?php
            exit;
        }

        public function inventory_models_front_end($inventory_type_slug = 0, $post_id = 0) {
            global $automobile_html_fields, $automobile_var_plugin_static_text;

            if (isset($_POST['post_id'])) {
                $post_id = $_POST['post_id'];
            }

            $html = '';
            $automobile_inventory_type_models_array = get_the_terms($post_id, 'inventory-model');
            $automobile_inventory_models = array();
            if (is_array($automobile_inventory_type_models_array) && sizeof($automobile_inventory_type_models_array) > 0) {
                foreach ($automobile_inventory_type_models_array as $in_category) {
                    $automobile_inventory_models[] = $in_category->term_id;
                }
            }

            if (!isset($automobile_inventory_models) || !is_array($automobile_inventory_models) || !count($automobile_inventory_models) > 0) {
                $automobile_inventory_models = array();
            }

            $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
            $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

            if (isset($_POST['inventory_make'])) {
                $automobile_inventory_make_id = $_POST['inventory_make'];
            } else {
                $automobile_inventory_make = wp_get_post_terms($post_id, 'inventory-make', true);
                $automobile_inventory_make_id = isset($automobile_inventory_make[0]->term_id) ? $automobile_inventory_make[0]->term_id : 0;
            }
            $automobile_inventory_make_models = get_term_meta($automobile_inventory_make_id, 'automobile_inventory_make_models', true);
            if (!isset($automobile_inventory_make_models) || !is_array($automobile_inventory_make_models) || !count($automobile_inventory_make_models) > 0) {
                $automobile_inventory_make_models = array();
            }

            $automobile_multi_cat_option = 'off';

            $args = array(
                'type' => 'post',
                'child_of' => 0,
                'parent' => '',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => 0,
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'number' => '',
                'taxonomy' => 'inventory-model',
                'pad_counts' => false
            );
            $categories = get_categories($args);
            $multiple = false;
            if ($automobile_multi_cat_option == 'on') {
                $multiple = true;
            }
            $tax_options = '<option value="">-- ' . automobile_var_plugin_text_srt('automobile_var_select_models') . ' --</option>';

            if ($categories) {
                foreach ($categories as $category) {
                    $selected = '';

                    if (in_array($category->slug, $automobile_inventory_make_models)) {
                        if (in_array($category->term_id, $automobile_inventory_models)) {
                            $selected = 'selected="selected"';
                        }
                        $tax_options .= '<option value="' . $category->term_id . '" ' . $selected . '>' . $category->name . '</option>';
                    }
                }
            }
            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_models'),
                'desc' => '',
                'hint_text' => '',
                'multi' => $multiple,
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => 'inventory_models',
                    'classes' => 'chosen-select',
                    'options_markup' => true,
                    'options' => $tax_options,
                    'return' => true,
                ),
            );

            $html .= $automobile_html_fields->automobile_select_field_front($automobile_opt_array);
            $html .= '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';
            if (isset($_POST['post_id']) && isset($_POST['inventory_make'])) {
                echo json_encode(array('models' => $html));
                die;
            } else {
                return $html;
            }
        }

        /**
         * End Function for Dealer Post inventory
         */

        /**
         * Start Function how to find for inventory action
         */
        public function automobile_inventory_action($uid) {
            $stringObj = new automobile_plugin_all_strings();
            $stringObj->automobile_var_plugin_option_strings();
            global $automobile_var_plugin_options, $current_user, $automobile_form_fields, $automobile_var_plugin_static_text;
            $automobile_inventory_id = isset($_GET['inventory_id']) ? $_GET['inventory_id'] : '';
            $inventory_title = '';
            if (isset($automobile_inventory_id) && $automobile_inventory_id != '') {
                $inventory_detail = get_inventory_detail($automobile_inventory_id);
                $inventory_title = $inventory_detail->post_title;
            }
            $applicant_title = '';
            if ($inventory_title != '') {
                $applicant_title = $inventory_title . " " . automobile_var_plugin_text_srt('automobile_var_applicants');
            } else {
                $applicant_title = automobile_var_plugin_text_srt('automobile_var_applicants');
            }
            $automobile_inventory_act = isset($_GET['action']) ? $_GET['action'] : '';
            $automobile_emp_funs = new automobile_dealer_functions();
            if ($automobile_inventory_act == 'applicants') {
                $automobile_fav_resumes = array();
                $automobile_fav_resumes = count_usermeta('cs-user-inventory-applied-list', serialize(strval($automobile_inventory_id)), 'LIKE', true);
                ?>
                <div class="cs-resumes">
                    <div class="scetion-title">
                        <h4><?php echo esc_html($applicant_title); ?></h4>
                    </div>
                    <?php
                    if (is_array($automobile_fav_resumes) && sizeof($automobile_fav_resumes) > 0 && $automobile_fav_resumes[0] != '') {
                        ?>
                        <ul class="resumes-list">
                            <?php
                            $automobile_candidate_switch = isset($automobile_var_plugin_options['automobile_candidate_switch']) ? $automobile_var_plugin_options['automobile_candidate_switch'] : '';
                            foreach ($automobile_fav_resumes as $automobile_fav) {
                                $candidate_usrid = $automobile_fav;
                                $inventory_applied_date = automobile_find_other_field_user_meta_list($automobile_inventory_id, 'post_id', 'cs-user-inventory-applied-list', 'date_time', $candidate_usrid);
                                $automobile_inventory_thumb_url = get_user_meta($automobile_fav->ID, "user_img", true);
                                $automobile_inventory_thumb_url = automobile_get_img_url($automobile_inventory_thumb_url, 'automobile_var_media_4');
                                $automobile_ext = pathinfo($automobile_inventory_thumb_url, PATHINFO_EXTENSION);
                                if ($automobile_inventory_thumb_url == '' || $automobile_ext == '') {
                                    $automobile_inventory_thumb_url = esc_url(wp_automobile::plugin_url() . 'assets/images/candidate-no-image.jpg');
                                }
                                $automobile_inventory_title = get_user_meta($automobile_fav->ID, "automobile_inventory_title", true);
                                $automobile_loc_address = get_user_meta($automobile_fav->ID, "automobile_post_loc_address", true);
                                $automobile_candidate_cv = get_user_meta($automobile_fav->ID, "automobile_candidate_cv", true);
                                $automobile_candidate_linkedin = get_user_meta($automobile_fav->ID, 'automobile_linkedin', true);
                                $automobile_last_activity_date = get_user_meta($automobile_fav->ID, 'automobile_user_last_activity_date', true);
                                ?>
                                <li>
                                    <?php
                                    if ($automobile_inventory_thumb_url != '') {
                                        ?>
                                        <img alt="" src="<?php echo esc_url($automobile_inventory_thumb_url) ?>">
                                    <?php } ?>
                                    <div class="cs-text">
                                        <h3><a href="<?php echo esc_url(get_author_posts_url($automobile_fav->ID)) ?>"><?php echo force_balance_tags($automobile_fav->display_name) ?></a></h3>
                                        <?php if ($automobile_inventory_title != '') { ?>
                                            <span><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_inventory_title) ?></span> 
                                            <?php
                                        }
                                        if (isset($inventory_applied_date) && $inventory_applied_date != '') {
                                            echo '<span>' . automobile_var_plugin_text_srt('automobile_var_applied_date') . automobile_time_elapsed_string($inventory_applied_date) . '</span>';
                                        }
                                        if ($automobile_loc_address != '') {
                                            ?>
                                            <span class="location"><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_loc_address) ?></span>
                                        <?php } ?>

                                        <div class="cs-posted"> 
                                            <span><?php echo automobile_var_plugin_text_srt('automobile_var_updated') . " " . esc_attr($automobile_emp_funs->automobile_time_elapsed($automobile_last_activity_date)); ?></span> 
                                        </div>
                                        <div class="cs-uploaded candidate-detail">
                                            <div class="cs-downlod-sec">
                                                <a><?php echo automobile_var_plugin_text_srt('automobile_var_actions'); ?></a>
                                                <ul>
                                                    <li>
                                                        <a onclick="document.getElementById('cover_letter_light<?php echo esc_html($automobile_fav->ID); ?>').style.display = 'block';
                                                                                        document.getElementById('cover_letter_fade<?php echo esc_html($automobile_fav->ID); ?>').style.display = 'block'" href="javascript:void(0)"><?php echo automobile_var_plugin_text_srt('automobile_var_cover_letter'); ?></a>
                                                    </li>
                                                    <?php if (isset($automobile_candidate_cv) && !is_array($automobile_candidate_cv) && esc_url($automobile_candidate_cv) != '') { ?>
                                                        <li><a target="_blank" href="<?php echo esc_url($automobile_candidate_cv) ?>"><?php echo automobile_var_plugin_text_srt('automobile_var_download'); ?></a></li>
                                                    <?php } else { ?>
                                                        <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php echo automobile_var_plugin_text_srt('automobile_var_no_downloadable'); ?>');"><?php echo automobile_var_plugin_text_srt('automobile_var_download'); ?></a></li>
                                                    <?php } ?>
                                                    <?php if ($automobile_candidate_linkedin != '') { ?>
                                                        <li><a target="_blank" href="<?php echo esc_url($automobile_candidate_linkedin) ?>"><?php echo automobile_var_plugin_text_srt('automobile_var_linked_in_profile'); ?></a></li>
                                                    <?php } else  ?>
                                                    <li><a data-toggle="modal" data-target="#cs-msgbox-<?php echo absint($automobile_fav->ID) ?>"><?php echo automobile_var_plugin_text_srt('automobile_var_send_message'); ?></a></li>    
                                                    <li><a href="<?php echo esc_url(get_author_posts_url($automobile_fav->ID)) ?>"><?php echo automobile_var_plugin_text_srt('automobile_var_view_profile'); ?></a></li>
                                                </ul>

                                            </div>
                                            <!-- start specialism popup -->
                                            <div id="cover_letter_light<?php echo esc_html($automobile_fav->ID); ?>" class="white_content">
                                                <a href = "javascript:void(0)" onclick = "document.getElementById('cover_letter_light<?php echo esc_html($automobile_fav->ID); ?>').style.display = 'none';
                                                                                document.getElementById('cover_letter_fade<?php echo esc_html($automobile_fav->ID); ?>').style.display = 'none'">Close</a>
                                                <h5><a><?php echo get_the_title($automobile_fav->ID) ?></a><?php
                                                    if (isset($automobile_post_loc_city) && $automobile_post_loc_city != '') {
                                                        echo " | " . $automobile_post_loc_city;
                                                    }
                                                    echo " - " . $automobile_var_cover_letter;
                                                    ?></h5>
                                                <?php
                                                if (isset($automobile_fav->ID) && $automobile_fav->ID != '') {
                                                    $automobile_cover_letter = get_user_meta($automobile_fav->ID, 'automobile_cover_letter', true);
                                                    if (isset($automobile_cover_letter) && $automobile_cover_letter != '')
                                                        echo force_balance_tags($automobile_cover_letter);
                                                    else
                                                        echo automobile_var_plugin_text_srt('automobile_var_not_set_by_user');
                                                }
                                                ?>
                                            </div>
                                            <div id="cover_letter_fade<?php echo esc_html($automobile_fav->ID); ?>" class="black_overlay"></div>
                                            <!-- end popup -->
                                            <!-- send message popup -->
                                            <div class="modal fade" id="cs-msgbox-<?php echo absint($automobile_fav->ID) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title"><?php echo automobile_var_plugin_text_srt('automobile_var_send_message'); ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="ajaxcontact-response-<?php echo absint($automobile_fav->ID) ?>" class="error-msg"></div>
                                                            <div class="cs-profile-contact-detail">
                                                                <form id="ajaxcontactform-<?php echo absint($automobile_fav->ID) ?>"  method="post" enctype="multipart/form-data">
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-user9"></i>
                                                                        <?php
                                                                        $automobile_opt_array = array(
                                                                            'id' => '',
                                                                            'classes' => 'form-control',
                                                                            'extra_atr' => 'placeholder="Enter your Name"',
                                                                            'cust_name' => 'ajaxcontactname',
                                                                        );
                                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                                        echo force_balance_tags($output);
                                                                        ?> 
                                                                    </div>
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-envelope4"></i>

                                                                        <?php
                                                                        $automobile_opt_array = array(
                                                                            'id' => '',
                                                                            'classes' => 'form-control',
                                                                            'extra_atr' => 'placeholder="Email Address"',
                                                                            'cust_name' => 'ajaxcontactemail',
                                                                        );
                                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                                        echo force_balance_tags($output);
                                                                        ?> 

                                                                    </div>
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-mobile4"></i>
                                                                        <?php
                                                                        $automobile_opt_array = array(
                                                                            'id' => '',
                                                                            'classes' => 'form-control',
                                                                            'extra_atr' => 'placeholder="Phone Number"',
                                                                            'cust_name' => 'ajaxcontactphone',
                                                                        );
                                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                                        echo force_balance_tags($output);
                                                                        ?> 
                                                                    </div>
                                                                    <div class="input-filed-contact">
                                                                        <?php
                                                                        $automobile_opt_array = array(
                                                                            'id' => '',
                                                                            'std' => '',
                                                                            'extra_atr' => 'placeholder="Message"',
                                                                            'cust_name' => 'ajaxcontactcontents',
                                                                        );
                                                                        $output = $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
                                                                        echo force_balance_tags($output);
                                                                        ?> 
                                                                    </div>
                                                                    <div id="jb-id-<?php echo absint($automobile_fav->ID) ?>" data-jid="<?php echo absint($automobile_fav->ID) ?>">
                                                                        <?php
                                                                        $automobile_opt_array = array(
                                                                            'id' => 'jb-cont-send-' . $automobile_fav->ID,
                                                                            'classes' => 'cs-bgcolor acc-submit',
                                                                            'std' => 'Send Request',
                                                                            'extra_atr' => 'data-id="' . $automobile_fav->ID . '"',
                                                                            'cust_name' => 'candidate_contactus',
                                                                            'cust_type' => 'button',
                                                                        );
                                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                                        echo force_balance_tags($output);
                                                                        ?> 


                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    } else {
                        echo '<div class="no-result"><h1>' . automobile_var_plugin_text_srt('automobile_var_no_applicant_found') . '</h1></div>';
                    }
                    ?>
                </div>
                <?php
            } else if ($automobile_inventory_act == 'edit') {
                echo '<div id="editinventory">';
                $this->automobile_dealer_post_inventory();
                echo '</div>';
            }
        }

        /**
         * End Function how to find for inventory action
         */
    }

    $automobile_emp_temps = new automobile_dealer_templates();
}