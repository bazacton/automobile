<?php
/**
 *  File Type: Settings Class
 */
if (!class_exists('automobile_var_plugin_options')) {

    class automobile_var_plugin_options {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('wp_ajax_automobile_add_feats_to_list', array(&$this, 'automobile_add_feats_to_list'));
            add_action('wp_ajax_automobile_add_package_to_list', array(&$this, 'automobile_add_package_to_list'));
        }

        /**
         * End Contructer Function
         */
        /**
         * end Function how to call setting function
         */

        /**
         * Start Function how to create package section
         */
        public function automobile_packages_section() {
            global $post, $automobile_form_fields, $package_id, $counter_package, $package_title, $package_price, $package_duration, $package_no_ads, $package_description, $automobile_package_type, $package_listings, $package_cvs, $package_submission_limit, $package_duration_period, $package_featured_ads, $automobile_list_dur, $package_feature, $automobile_html_fields, $automobile_var_plugin_options, $automobile_var_plugin_static_text;

            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();

            //$automobile_var_plugin_options = get_option('automobile_var_plugin_options');
            //$automobile_packages_options = $automobile_var_plugin_options['automobile_packages_options'];
	    if (isset($automobile_var_plugin_options['automobile_packages_options']) && !empty($automobile_var_plugin_options['automobile_packages_options'])) {
		$automobile_packages_options = $automobile_var_plugin_options['automobile_packages_options'];
	    }
            $currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';
            $automobile_free_package_switch = get_option('automobile_free_package_switch');
            $cd_checked = '';
            if (isset($automobile_free_package_switch) && $automobile_free_package_switch == 'on') {
                $cd_checked = 'checked';
            }
            $automobile_opt_array = array(
                'id' => '',
                'std' => '1',
                'cust_id' => "",
                'cust_name' => "dynamic_directory_package",
                'return' => true,
            );


            $automobile_html = $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array) . '
                
                <script>
                    jQuery(document).ready(function($) {
                        jQuery("#total_packages").sortable({
                            cancel : \'td div.table-form-elem\'
                        });
                    });
                </script>';
            $automobile_html .= '<div class="form-elements" id="safetysafe_switch_add_package">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<a href="javascript:automobile_createpop(\'add_package_title\',\'filter\')" class="button button_style">' . automobile_var_plugin_text_srt('automobile_var_add_package') . '</a>
					</div>
				</div>';
            $automobile_html .= '<div class="cs-list-table">
              <table class="to-table" border="0" cellspacing="0">
                <thead>
                  <tr>
                    <th style="width:80%;">' . automobile_var_plugin_text_srt('automobile_var_title') . '</th>
                    <th style="width:80%;" class="centr">' . automobile_var_plugin_text_srt('automobile_var_actions') . '</th>
                    <th style="width:0%;" class="centr"></th>
                  </tr>
                </thead>
                <tbody id="total_packages">';
            if (isset($automobile_packages_options) && is_array($automobile_packages_options) && count($automobile_packages_options) > 0) {
                foreach ($automobile_packages_options as $package_key => $package) {
                    if (isset($package_key) && $package_key <> '') {
                        $counter_package = $package_id = isset($package['package_id']) ? $package['package_id'] : '';
                        $package_title = isset($package['package_title']) ? $package['package_title'] : '';
                        $package_price = isset($package['package_price']) ? $package['package_price'] : '';
                        $package_duration = isset($package['package_duration']) ? $package['package_duration'] : '';
                        $package_description = isset($package['package_description']) ? $package['package_description'] : '';
                        $automobile_package_type = isset($package['package_type']) ? $package['package_type'] : '';
                        $package_listings = isset($package['package_listings']) ? $package['package_listings'] : '';
                        $package_cvs = isset($package['package_cvs']) ? $package['package_cvs'] : '';
                        $package_submission_limit = isset($package['package_submission_limit']) ? $package['package_submission_limit'] : '';
                        $package_duration_period = isset($package['package_duration_period']) ? $package['package_duration_period'] : '';
                        $automobile_list_dur = isset($package['automobile_list_dur']) ? $package['automobile_list_dur'] : '';
                        $package_feature = isset($package['package_feature']) ? $package['package_feature'] : '';
                        $package_featured_ads = isset($package['package_featured_ads']) ? $package['package_featured_ads'] : '';
                        $automobile_html .= $this->automobile_add_package_to_list();
                    }
                }
            }
            $automobile_html .= '</tbody>
              </table>
              </div>
              </form>
              <div id="add_package_title" style="display: none;">
                <div class="cs-heading-area">
                  <h5> <i class="icon-plus-circle"></i> ' . automobile_var_plugin_text_srt('automobile_var_package_settings') . ' </h5>
                  <span class="cs-btnclose" onClick="javascript:automobile_remove_overlay(\'add_package_title\',\'append\')"> <i class="icon-times"></i></span> </div>';



            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_title'),
                'desc' => '',
                'hint_text' => automobile_var_plugin_text_srt('automobile_var_package_title_hint'),
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_title',
                    'cust_name' => 'package_title',
                    'return' => true,
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);


            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_price') . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($currency_sign),
                'desc' => '',
                'hint_text' => automobile_var_plugin_text_srt('automobile_var_package_price_hint'),
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_price',
                    'cust_name' => 'package_price',
                    'return' => true,
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);



            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_type'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => 'package_type',
                    'cust_name' => 'package_type',
                    'options' => array(
						'' => automobile_var_plugin_text_srt('automobile_var_select_submittion'),
                        'single' => automobile_var_plugin_text_srt('automobile_var_single_submission'),
                        'subscription' => automobile_var_plugin_text_srt('automobile_var_subscription'),
                    ),
                    'return' => true,
                    'onclick' => 'automobile_package_type_toogle(this.value, \'\')',
                    'classes' => 'chosen-select-no-single'
                ),
            );


            $automobile_html .= $automobile_html_fields->automobile_select_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_no_of_listings_in_package'),
                'desc' => '',
                'id' => 'package_listings_con',
                'hint_text' => '',
                'extra_atr' => 'style="display:none;"',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => '',
                    'cust_id' => 'package_listings',
                    'cust_name' => 'package_listings',
                    'return' => true,
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);


            // hide attribute		
            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_no_of_cvs'),
                'desc' => '',
                'id' => '',
                'hint_text' => '',
                'styles' => 'display:none',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => '',
                    'cust_id' => 'package_cvs',
                    'cust_name' => 'package_cvs',
                    'return' => true,
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);




            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_expiry'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_id' => 'package_duration',
                            'cust_name' => 'package_duration',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'package_duration_period',
                            'cust_name' => 'package_duration_period',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'return' => true,
                            'options' => array(
                                'days' => automobile_var_plugin_text_srt('automobile_var_days'),
                                'months' => automobile_var_plugin_text_srt('automobile_var_months'),
                                'years' => automobile_var_plugin_text_srt('automobile_var_years'),
                            ),
                        ),
                    ),
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_multi_fields($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_listings_expiry'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_id' => 'package_submission_limit',
                            'cust_name' => 'package_submission_limit',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => '',
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'automobile_list_dur',
                            'cust_name' => 'automobile_list_dur',
                            'classes' => 'chosen-select-no-single',
                            'return' => true,
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => automobile_var_plugin_text_srt('automobile_var_days'),
                                'months' => automobile_var_plugin_text_srt('automobile_var_months'),
                                'years' => automobile_var_plugin_text_srt('automobile_var_years'),
                            ),
                        ),
                    ),
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_multi_fields($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_featured'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_feature',
                    'cust_name' => 'package_feature',
                    'options' => array(
                        'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                        'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                    ),
                    'return' => true,
                    'classes' => 'chosen-select-no-single'
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_select_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_description'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'package_description',
                    'cust_name' => 'package_description',
                    'return' => true,
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_textarea_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => automobile_var_plugin_text_srt('automobile_var_add_package_to_list'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'after' => '<div class="package-loader"></div>',
                    'cust_type' => 'button',
                    'extra_atr' => 'onClick="add_package_to_list(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(automobile_var::plugin_url()) . '\')" ',
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
            $automobile_html .= '</div>';
            return $automobile_html;
        }

        /**
         * end Function how to create package section
         */

        /**
         * Start Function how to add package in list section
         */
        public function automobile_add_package_to_list() {
            global $counter_package, $automobile_form_fields, $package_id, $package_title, $package_price, $package_duration, $package_description, $automobile_var_plugin_static_text, $automobile_package_type, $package_listings, $package_cvs, $package_submission_limit, $automobile_list_dur, $package_duration_period, $package_featured_ads, $package_feature, $automobile_html_fields, $automobile_var_plugin_options;

            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();


            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }
            if (isset($_POST['package_title']) && $_POST['package_title'] <> '') {
                $package_id = time();
            }
            if (empty($package_id)) {
                $package_id = $counter_package;
            }
            $currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';

            $automobile_opt_array = array(
                'id' => '',
                'std' => absint($package_id),
                'cust_id' => "",
                'cust_name' => "package_id_array[]",
                'return' => true,
            );
            $automobile_html = '
            <tr class="parentdelete" id="edit_track' . esc_attr($counter_package) . '">
              <td id="subject-title' . esc_attr($counter_package) . '" style="width:100%;">' . esc_attr($package_title) . '</td>
              <td class="centr" style="width:20%;"><a href="javascript:automobile_createpop(\'edit_track_form' . esc_js($counter_package) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_package) . '" style="display: none;" class="table-form-elem">
                  ' . $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array) . '
                  <div class="cs-heading-area">
                    <h5 style="text-align: left;"> ' . automobile_var_plugin_text_srt('automobile_var_package_settings') . '</h5>
                    <span onclick="javascript:automobile_remove_overlay(\'edit_track_form' . esc_js($counter_package) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                    <div class="clear"></div>
                  </div>';
            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_title'),
                'desc' => '',
                'hint_text' => automobile_var_plugin_text_srt('automobile_var_package_title_hint'),
                'echo' => false,
                'field_params' => array(
                    'std' => htmlspecialchars($package_title),
                    'cust_id' => 'package_title' . esc_attr($counter_package),
                    'cust_name' => 'package_title_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);


            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_price') . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($currency_sign),
                'desc' => '',
                'hint_text' => automobile_var_plugin_text_srt('automobile_var_package_price_hint'),
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_price),
                    'cust_id' => 'package_price' . esc_attr($counter_package),
                    'cust_name' => 'package_price_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);



            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_type'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $automobile_package_type,
                    'id' => 'automobile_package_type' . esc_attr($counter_package),
                    'cust_name' => 'package_type_array[]',
                    'options' => array(
                        'single' => automobile_var_plugin_text_srt('automobile_var_single_submission'),
                        'subscription' => automobile_var_plugin_text_srt('automobile_var_subscription'),
                    ),
                    'return' => true,
                    'onclick' => 'automobile_package_type_toogle(this.value, \'' . esc_attr($counter_package) . '\')',
                    'classes' => 'chosen-select-no-single',
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_select_field($automobile_opt_array);



            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_no_of_listings_in_package'),
                'desc' => '',
                'id' => 'package_listings_con' . esc_attr($counter_package),
                'hint_text' => '',
                'extra_atr' => 'style="display:' . esc_attr($automobile_package_type == 'subscription' ? 'block' : 'none') . '"',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_listings),
                    'id' => '',
                    'cust_id' => 'package_listings' . esc_attr($counter_package),
                    'cust_name' => 'package_listings_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_no_of_cvs'),
                'desc' => '',
                'id' => '',
                'hint_text' => '',
                'styles' => 'display:none',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_cvs),
                    'id' => '',
                    'cust_id' => 'package_cvs' . esc_attr($counter_package),
                    'cust_name' => 'package_cvs_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_expiry'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => esc_attr($package_duration),
                            'id' => '',
                            'cust_id' => 'package_duration' . esc_attr($counter_package),
                            'cust_name' => 'package_duration_array[]',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => esc_attr($package_duration_period),
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'package_duration_period' . esc_attr($counter_package),
                            'cust_name' => 'package_duration_period_array[]',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => automobile_var_plugin_text_srt('automobile_var_days'),
                                'months' => automobile_var_plugin_text_srt('automobile_var_months'),
                                'years' => automobile_var_plugin_text_srt('automobile_var_years'),
                            ),
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_multi_fields($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_listings_expiry'),
                'id' => '',
                'desc' => '',
                'fields_list' => array(
                    array('type' => 'text', 'field_params' => array(
                            'std' => esc_attr($package_submission_limit),
                            'id' => '',
                            'cust_id' => 'package_submission_limit' . esc_attr($counter_package),
                            'cust_name' => 'package_submission_limit_array[]',
                            'cust_type' => '',
                            'classes' => 'input-large',
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                    array('type' => 'select', 'field_params' => array(
                            'std' => esc_attr($automobile_list_dur),
                            'id' => '',
                            'cust_type' => '',
                            'cust_id' => 'automobile_list_dur' . esc_attr($counter_package),
                            'cust_name' => 'automobile_list_dur_array[]',
                            'classes' => 'chosen-select-no-single',
                            'div_classes' => 'select-small',
                            'options' => array(
                                'days' => automobile_var_plugin_text_srt('automobile_var_days'),
                                'months' => automobile_var_plugin_text_srt('automobile_var_months'),
                                'years' => automobile_var_plugin_text_srt('automobile_var_years'),
                            ),
                            'return' => true,
                            'array' => true,
                            'force_std' => true,
                        ),
                    ),
                ),
            );


            $automobile_html .= $automobile_html_fields->automobile_multi_fields($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_package_featured'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $package_feature,
                    'cust_id' => 'package_feature' . esc_attr($counter_package),
                    'cust_name' => 'package_feature_array[]',
                    'options' => array(
                       'no' => automobile_var_plugin_text_srt('automobile_var_no'),
                        'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
                    ),
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_select_field($automobile_opt_array);



            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_description'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => esc_attr($package_description),
                    'cust_id' => 'package_description' . esc_attr($counter_package),
                    'cust_name' => 'package_description_array[]',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_textarea_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => automobile_var_plugin_text_srt('automobile_var_update_package'),
                    'cust_id' => '',
                    'cust_name' => '',
                    'return' => true,
                    'cust_type' => 'button',
                    'extra_atr' => 'onclick="update_title(' . esc_js($counter_package) . '); automobile_remove_overlay(\'edit_track_form' . esc_js($counter_package) . '\',\'append\')"',
                ),
            );
            $automobile_html .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
            $automobile_html .= '
                </div></td>
            </tr>';
            if (isset($_POST['package_title'])) {
                echo force_balance_tags($automobile_html);
                die();
            } else {
                return $automobile_html;
            }
        }

        /**
         * end Function how to add package in list section
         */
		 
        /**
         *
         * Array Fields
         */
        function automobile_in_array_field($array_val, $array_field, $array, $strict = false) {
            if ($strict) {
                foreach ($array as $item)
                    if (isset($item[$array_field]) && $item[$array_field] === $array_val)
                        return true;
            }
            else {
                foreach ($array as $item)
                    if (isset($item[$array_field]) && $item[$array_field] == $array_val)
                        return true;
            }
            return false;
        }

        /**
         * Start Function that how to check duplicate values
         */
        function automobile_check_duplicate_value($array_val, $array_field, $array) {
            $automobile_val_counter = 0;
            foreach ($array as $item) {
                if (isset($item[$array_field]) && $item[$array_field] == $array_val) {
                    $automobile_val_counter++;
                }
            }
            if ($automobile_val_counter > 1)
                return true;
            return false;
        }

        /**
         * End Function of how to check duplicate values
         */

    }

    //End Class
}
if (!function_exists('automobile_settings_fields')) {

    /**
     * Start Function that set value in setting fields
     */
    function automobile_settings_fields($key, $param) {
        global $post, $automobile_html_fields;
        $automobile_gateway_options = get_option('automobile_gateway_options');
        $automobile_value = $param['std'];
        $html = '';
        switch ($param['type']) {
            case 'text':
                if (isset($automobile_gateway_options)) {
                    if (isset($automobile_gateway_options[$param['id']])) {
                        $val = $automobile_gateway_options[$param['id']];
                    } else {
                        $val = $param['std'];
                    }
                } else {
                    $val = $param['std'];
                }
                $automobile_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'cust_type' => $param['type'],
                        'classes' => 'vsmall',
                    ),
                );
                $output = $automobile_html_fields->automobile_text_field($automobile_opt_array);

                $html .= $output;
                break;
            case 'textarea':
                $val = $param['std'];
                $std = get_option($param['id']);
                if (isset($automobile_gateway_options)) {
                    if (isset($automobile_gateway_options[$param['id']])) {
                        $val = $automobile_gateway_options[$param['id']];
                    } else {
                        $val = $param['std'];
                    }
                } else {
                    $val = $param['std'];
                }


                $automobile_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'extra_atr' => 'rows="10" cols="60"',
                        'classes' => '',
                    ),
                );
                $output = $automobile_html_fields->automobile_textarea_field($automobile_opt_array);

                $html .= $output;
                break;
            case "checkbox":
                $saved_std = '';
                $std = '';
                if (isset($automobile_gateway_options)) {
                    if (isset($automobile_gateway_options[$param['id']])) {
                        $saved_std = $automobile_gateway_options[$param['id']];
                    }
                } else {
                    $std = $param['std'];
                }
                $checked = '';
                if (!empty($saved_std)) {
                    if ($saved_std == 'on') {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                } elseif ($std == 'on') {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }

                $automobile_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => 'myClass',
                    ),
                );
                $output = $automobile_html_fields->automobile_checkbox_field($automobile_opt_array);
                $html .= $output;
                break;
            case "logo":
                if (isset($automobile_gateway_options) and $automobile_gateway_options <> '' && isset($automobile_gateway_options[$param['id']])) {
                    $val = $automobile_gateway_options[$param['id']];
                } else {
                    $val = $param['std'];
                }
                $output = '';
                $display = ($val <> '' ? 'display' : 'none');
                if (isset($value['tab'])) {
                    $output .='<div class="main_tab"><div class="horizontal_tab" style="display:' . $param['display'] . '" id="' . $param['tab'] . '">';
                }

                $automobile_opt_array = array(
                    'name' => esc_attr($param["name"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['desc']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $val,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => '',
                    ),
                );
                $output = $automobile_html_fields->automobile_upload_file_field($automobile_opt_array);
                $html .= $output;
                break;
            case 'select' :

                $options = '';
                if (isset($param['options']) && is_array($param['options'])) {
                    foreach ($param['options'] as $value => $option) {
                        $options[$value] = $option;
                    }
                }

                $automobile_opt_array = array(
                    'name' => esc_attr($param["title"]),
                    'desc' => '',
                    'hint_text' => esc_attr($param['description']),
                    'echo' => false,
                    'field_params' => array(
                        'std' => $automobile_value,
                        'cust_id' => $param['id'],
                        'cust_name' => $param['id'],
                        'return' => true,
                        'classes' => 'cs-form-select cs-input chosen-select-no-single',
                        'options' => $options,
                    ),
                );
                $output = $automobile_html_fields->automobile_upload_file_field($automobile_opt_array);
                // append
                $html .= $output;
                break;
            default :
                break;
        }
        return $html;
    }

    /**
     * end Function of set value in setting fields
     */
}
/**
 * Start Function that how to Checkt load satus
 */
/* ---------------------------------------------------
 * Load States
 * -------------------------------------------------- */
if (!function_exists('automobile_load_states')) {

    function automobile_load_states() {
        global $automobile_theme_options, $automobile_var_plugin_static_text;
         $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
        $automobile_locations = get_option('automobile_location_states');
        $states = '';
        $automobile_country = $_POST['country'];
        $automobile_country = trim(stripslashes($automobile_country));
        if ($automobile_country && $automobile_country != '') {
            $states_data = isset($automobile_locations[$automobile_country]) ? $automobile_locations[$automobile_country] : '';
            $states .= '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_state') . '</option>';
            if (isset($states_data) && $states_data != '') {
                foreach ($states_data as $key => $value) {
                    if ($key != 'no-state') {
                        $states .='<option value="' . $value['name'] . '">' . $value['name'] . '</option>';
                    }
                }
            }
        }
        echo force_balance_tags($states);
        die();
    }

    add_action('wp_ajax_automobile_load_states', 'automobile_load_states');
}
/**
 * end Function that how to Checkout  load satus
 */
/**
 * Start Function that how add location in location fields
 */
if (!function_exists('add_locations')) {

    function add_locations($original, $items_to_add, $country, $state = '') {
        if (!empty($state)) {
            $target = $original[$country][$state];
        } else {
            $target = $original[$country];
        }
        $new_arr = array_merge($target, $items_to_add);
        if (!empty($state)) {
            $original[$country][$state] = $new_arr;
        } else {
            $original[$country] = $new_arr;
        }
        return $original;
    }

}

/**
 * end Function that how add location in location fields
 */
/**
 * Start Function that how Delete location in location fields
 */
if (!function_exists('automobile_delete_location')) {

    function automobile_delete_location() {
        global $automobile_theme_options;
        $type = $_POST['type'];
        $automobile_location_countries = get_option('automobile_location_countries');
        $automobile_location_states = get_option('automobile_location_states');
        $automobile_location_cities = get_option('automobile_location_cities');
        if ($type == 'country') {
            $node = $_POST['node'];
            $automobile_location_country = automobile_remove_location($automobile_location_countries, $automobile_location_countries[$node]);
            if (isset($automobile_location_states[$node])) {
                $automobile_location_states = automobile_remove_location($automobile_location_states, $automobile_location_states[$node]);
            }
            if (isset($automobile_location_cities[$node])) {
                $automobile_location_cities = automobile_remove_location($automobile_location_cities, $automobile_location_cities[$node]);
            }
            update_option('automobile_location_countries', $automobile_location_country);
            update_option('automobile_location_states', $automobile_location_states);
            update_option('automobile_location_cities', $automobile_location_cities);
        } else if ($type == 'state') {
            $node = $_POST['node'];
            $country_node = $_POST['country_node'];

            unset($automobile_location_states[$country_node][$node]);

            if (isset($automobile_location_cities[$country_node][$node])) {
                unset($automobile_location_cities[$country_node][$node]);
            }
            update_option('automobile_location_states', $automobile_location_states);
            update_option('automobile_location_cities', $automobile_location_cities);
        } else if ($type == 'city') {
            $node = $_POST['node'];
            $country_node = $_POST['country_node'];
            $state_node = $_POST['state_node'];
            unset($automobile_location_cities[$country_node][$state_node][$node]);
            update_option('automobile_location_cities', $automobile_location_cities);
        }
        die();
    }

    /**
     * Start Function that how Delete location in location fields
     */
    add_action('wp_ajax_automobile_delete_location', 'automobile_delete_location');
}
/**
 * Start Function that how remove location 
 */
if (!function_exists('automobile_remove_location')) {

    function automobile_remove_location($array, $item) {
        $index = array_search($item, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
        return $array;
    }

}
/**
 * end Function of how to remove location 
 */
/**
 * Start Function that how to load country of states 
 */
if (!function_exists('automobile_load_country_states')) {

    function automobile_load_country_states() {
        global $automobile_theme_options, $automobile_var_plugin_static_text;
        $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
        $states = '';
        $automobile_country = $_POST['country'];
        $json = array();
        $json['cities'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_city') . '</option>';
        $automobile_country = trim(stripslashes($automobile_country));
        if ($automobile_country && $automobile_country != '') {
            $states = '';
            $selected_spec = get_term_by('slug', $automobile_country, 'automobile_locations');
            $state_parent_id = $selected_spec->term_id;
            $states_args = array(
                'orderby' => 'name',
                'order' => 'ASC',
                'fields' => 'all',
                'slug' => '',
                'hide_empty' => false,
                'parent' => $state_parent_id,
            );
            $cities = get_terms('automobile_locations', $states_args);

            if (isset($cities) && $cities != '' && is_array($cities)) {
                foreach ($cities as $key => $city) {
                    $json['cities'] .= "<option value='" . $city->slug . "'>" . $city->name . "</option>";
                }
            }
        }
        echo json_encode($json);
        die();
    }

    add_action("wp_ajax_automobile_load_country_states", "automobile_load_country_states");
    add_action("wp_ajax_nopriv_automobile_load_country_states", "automobile_load_country_states");
}
/**
 * end Function that how to load country of states 
 */
/**
 * Start Function that how to crate cities against country 
 */
if (!function_exists('automobile_load_country_cities')) {

    function automobile_load_country_cities() {
        global $automobile_theme_options, $automobile_var_plugin_static_text;
        $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
            
        $automobile_country = $_POST['country'];
        $automobile_state = $_POST['state'];
        $json = array();
        $json['cities'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_city') . '</option>';
        if ($automobile_state && $automobile_state != '') {
            // load all cities against state  
            $cities = '';
            $selected_spec = get_term_by('slug', $automobile_state, 'automobile_locations');
            $state_parent_id = $selected_spec->term_id;
            $states_args = array(
                'orderby' => 'name',
                'order' => 'ASC',
                'fields' => 'all',
                'slug' => '',
                'hide_empty' => false,
                'parent' => $state_parent_id,
            );
            $cities = get_terms('automobile_locations', $states_args);
            if (isset($cities) && $cities != '' && is_array($cities)) {
                foreach ($cities as $key => $city) {
                    $json['cities'] .= "<option value='" . $city->slug . "'>" . $city->name . "</option>";
                }
            }
        }
        echo json_encode($json);
        die();
    }

    add_action('wp_ajax_automobile_load_country_cities', 'automobile_load_country_cities');
}
if (class_exists('automobile_var_plugin_options')) {
    $settings_object = new automobile_var_plugin_options();
}