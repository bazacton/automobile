<?php

/*
 *
 * @Shortcode Name : b Package
 * Start Function how to create Shortcode of  Package
 *
 */
if (!function_exists('automobile_inventory_package_shortcode')) {

    function automobile_inventory_package_shortcode($atts) {
        global $post, $current_user, $automobile_form_fields, $automobile_var_plugin_options, $automobile_var_plugin_static_text;
        $defaults = array(
            'column_size' => '1/1',
            'automobile_package_title' => '',
            'automobile_package_sub_title' => '',
            'inventory_pkges' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_html = '';

        $inventory_pkges = explode(',', $inventory_pkges);

        $currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';
        $automobile_emp_dashboard = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : '';
        $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';

        $user_role = automobile_get_loginuser_role();

        $rand_id = rand(0, 9999999);

        $automobile_package_title = isset($automobile_package_title) ? $automobile_package_title : '';
        $automobile_package_sub_title = isset($automobile_package_sub_title) ? $automobile_package_sub_title : '';
        if ($automobile_package_title != '' || $automobile_package_sub_title != '') {
            $automobile_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="section-title" >';
        }

        if ($automobile_package_title != '') {
            $automobile_html .= '<h1>' . $automobile_package_title . '</h1>';
        }
        if ($automobile_package_sub_title != '') {
            $automobile_html .= '<p>' . $automobile_package_sub_title . '</p>';
        }
        if ($automobile_package_title != '' || $automobile_package_sub_title != '') {
            $automobile_html .= '</div>
					</div>';
        }




        $automobile_html .= '<div class="cs-packeges" id="cs-cv-form' . $rand_id . '" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">';
        $automobile_html .= '<div class = "row" >';
        if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
            $size = sizeof($automobile_packages_options);
            $automobile_pkg_counter = 0;
            foreach ($automobile_packages_options as $package_key => $package) {
                if (isset($package_key) && $package_key <> '' && in_array($package_key, $inventory_pkges)) {
                    $automobile_rand_id = rand(53445, 65765);
                    $package_id = isset($package['package_id']) ? $package['package_id'] : '';
                    $package_title = isset($package['package_title']) ? $package['package_title'] : '';
                    $package_price = isset($package['package_price']) ? $package['package_price'] : '';
                    $package_listings = isset($package['package_listings']) ? $package['package_listings'] : '';
                    $package_submission_limit = isset($package['package_submission_limit']) ? $package['package_submission_limit'] : '';
                    $automobile_list_dur = isset($package['automobile_list_dur']) ? $package['automobile_list_dur'] : '';
                    $package_duration = isset($package['package_duration']) ? $package['package_duration'] : '';
                    $package_duration_period = isset($package['package_duration_period']) ? $package['package_duration_period'] : '';
                    $package_feature = isset($package['package_feature']) ? $package['package_feature'] : '';
                    $package_desc = isset($package['package_description']) ? $package['package_description'] : '';
                    $automobile_package_type = isset($package['package_type']) ? $package['package_type'] : '';
                    $pkg_feat_class = $package_feature == 'yes' ? ' active' : '';

                    if($automobile_pkg_counter == 0){
                       $first =  'first-element';
                    }else if($automobile_pkg_counter == $size-1){
                        $first =  'last-element';
                    }else{
                        $first = '';
                    }

                    $automobile_html .= ' <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="pricetable-holder modren '.$first.' ' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($pkg_feat_class) . '">
							<h2>' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($package_title) . '</h2>
							<div class="price-holder ">
								<div class="cs-price"><span class="cs-color"><sup class="cs-color">' . esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($package_price) . '</sup><em>' . sprintf(automobile_var_plugin_text_srt('automobile_var_price_plan_string'), $package_submission_limit, $automobile_list_dur) . '</em></span>
									<ul>';
                    if ($automobile_package_type == 'subscription') {
                        $automobile_html .= '<li>' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($package_listings) . '' . sprintf(automobile_var_plugin_text_srt('automobile_var_max_inventory_string'), $package_submission_limit, $automobile_list_dur) . '</li>';
                    } else {
                        $automobile_html .= '<li>' . automobile_var_plugin_text_srt('automobile_var_single_submission') . '</li>';
                    }
                    $automobile_html .= '<li>' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($package_duration) . '' . sprintf(automobile_var_plugin_text_srt('automobile_var_duration_string'), $package_duration_period) . '</li>
							<li>' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($package_desc) . '</li>
							</ul>
								</div>';
                    if (!is_user_logged_in()) {
                        $automobile_html .= '<a class="cs-color csborder-color acc-submit" href="javascript:;" onclick="trigger_func(\'#btn-header-main-login\');">' . automobile_var_plugin_text_srt('automobile_var_buy_now') . '</a>';
                    } else if (is_user_logged_in() && !((isset($user_role) && $user_role <> '' && $user_role == 'automobile_dealer') )) {
                        $automobile_html .= '<a id="automobile_emp_check_' . absint($automobile_rand_id) . '" href="javascript:;" class="cs-color acc-submit">' . automobile_var_plugin_text_srt('automobile_var_buy_now') . '</a>';
                    } else {
                        $automobile_html .= '<form method="post" action="' . add_query_arg(array('profile_tab' => 'packages'), get_permalink($automobile_emp_dashboard)) . '">
							<input class="slct-cv-pkg cs-color csborder-color acc-submit" type="submit" value="' . automobile_var_plugin_text_srt('automobile_var_buy_now') . '">
							<input type="hidden" name="automobile_package" value="' . absint($package_id) . '" style="display:none; position:absolute;" />
							<input type="hidden" name="automobile_inventory_pkg_trans" value="1">
							</form>';
                    } $automobile_html .= '</div>
					</div>
					</div>';
                }

                $automobile_pkg_counter++;
            }
        }

        $automobile_html .= '</div>';
        $automobile_html .= '</div>';
        return do_shortcode($automobile_html);
    }

    add_shortcode('automobile_package', 'automobile_inventory_package_shortcode');
}