<?php
/**
 * @Add Meta Box For Inventories
 * @return
 *
 */
if ( ! class_exists('automobile_var_inventory_meta') ) {

	class automobile_var_inventory_meta {

		public function __construct() {
			add_action('add_meta_boxes', array( $this, 'automobile_var_meta_inventory_add' ));
			add_action('wp_ajax_inventory_type_dyn_fields', array( $this, 'inventory_type_change_fields' ));
			add_action('wp_ajax_dyn_inventory_models', array( $this, 'inventory_models' ));
		}

		function automobile_var_meta_inventory_add() {

			global $automobile_var_plugin_static_text;

			add_meta_box('automobile_var_meta_inventory', automobile_var_plugin_text_srt('automobile_var_inventory_options'), array( $this, 'automobile_var_meta_inventory' ), 'inventory', 'normal', 'high');
			add_meta_box('automobile_var_inventory_gallery', automobile_var_plugin_text_srt('automobile_var_gallery'), array( $this, 'automobile_var_inventory_gallery' ), 'inventory', 'side', 'low');
		}

		function automobile_var_inventory_gallery($post) {


			global $post, $automobile_html_fields, $automobile_var_plugin_static_text;

			$automobile_html_fields->automobile_gallery_render(array( 'id' => 'inventory_gallery', 'name' => automobile_var_plugin_text_srt('automobile_var_upload') ));
		}

		function automobile_var_meta_inventory($post) {
			global $post, $automobile_var_plugin_static_text;
			?>		
			<div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
				<div class="option-sec" style="margin-bottom:0;">
					<div class="opt-conts">
						<div class="elementhidden">
							<div id="tabbed-content" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')) ?>">
								<div id="tab-inventories-settings-cs-inventory">
									<?php $this->automobile_var_post_inventory_fields(); ?>
								</div>
							</div>  
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<?php
		}

		/**
		 * @Inventory Custom Fileds Function
		 * @return
		 */
		function automobile_var_post_inventory_fields() {

			global $post, $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_core, $automobile_var_plugin_static_text, $automobile_var_plugin_options;


			$post_id = $post->ID;
			$inventory_type_slug = get_post_meta($post->ID, 'automobile_inventory_type', true);
			$automobile_inventory_featured = get_post_meta($post->ID, 'automobile_inventory_featured', true);
			$automobile_users_list = array();
			$automobile_users = get_users('orderby=nicename&role=automobile_dealer');
			foreach ( $automobile_users as $user ) {
				$automobile_users_list[$user->ID] = $user->display_name;
			}
			$automobile_packages_list = array();
///////////////////////

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
////////////////////
			$automobile_opt_array = array(
				'name' => __('View', 'automobile'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => 'default',
					'id' => 'inventory_view',
					'classes' => 'chosen-select-no-single',
					'options' => array(
						'default' => __('Default', 'automobile'),
						'view-1' => __('View 1', 'automobile'),
						'view-2' => __('View 2', 'automobile'),
                                                'view-3' => __('View 3', 'automobile'),
					),
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_select_field($automobile_opt_array);

			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_id_number'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_id',
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_text_field($automobile_opt_array);

			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_transaction_id'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'trans_id',
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_text_field($automobile_opt_array);

			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_posted_by'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_username',
					'classes' => 'chosen-select-no-single',
					'options' => $automobile_users_list,
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_select_field($automobile_opt_array);
                        $automobile_inventory_posted = get_post_meta( $post_id, 'automobile_inventory_posted', true);
                        $automobile_inventory_posted = ( $automobile_inventory_posted == '')? date('d-m-Y H:i:s') : '';
                        
                        $automobile_inventory_expired = get_post_meta( $post_id, 'automobile_inventory_expired', true);
                        $automobile_inventory_expired = ( $automobile_inventory_expired == '')? date('d-m-Y', strtotime(date('d-m-Y'). ' + 1 year')) : '';
                        
			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_posted_on'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'id' => 'inventory_posted',
					'classes' => '',
					'strtotime' => true,
					'std' => $automobile_inventory_posted, //date('d-m-Y H:i:s'),
					'description' => '',
					'hint' => '',
					'format' => 'd-m-Y H:i:s',
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_date_field($automobile_opt_array);
			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_expired_on'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => $automobile_inventory_expired, //date('d-m-Y'),
					'id' => 'inventory_expired',
					'format' => 'd-m-Y',
					'strtotime' => true,
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_date_field($automobile_opt_array);

			if ( $automobile_inventory_featured == 'yes' || $automobile_inventory_featured == 'on' ) {
				$automobile_opt_array = array(
					'name' => automobile_var_plugin_text_srt('automobile_var_featured'),
					'desc' => '',
					'hint_text' => '',
					'echo' => true,
					'field_params' => array(
						'std' => 'yes',
						'id' => 'inventory_featured',
						'classes' => 'chosen-select-no-single',
						'options' => array(
							'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
							'no' => automobile_var_plugin_text_srt('automobile_var_no'),
						),
						'return' => true,
					),
				);

				$automobile_html_fields->automobile_select_field($automobile_opt_array);
			} else {
				$automobile_opt_array = array(
					'name' => automobile_var_plugin_text_srt('automobile_var_featured'),
					'desc' => '',
					'hint_text' => '',
					'echo' => true,
					'field_params' => array(
						'std' => 'yes',
						'id' => 'inventory_featured',
						'classes' => 'chosen-select-no-single',
						'options' => array(
							'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
							'no' => automobile_var_plugin_text_srt('automobile_var_no'),
						),
						'return' => true,
					),
				);

				$automobile_html_fields->automobile_select_field($automobile_opt_array);
			}
			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_packages'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_package',
					'classes' => 'chosen-select-no-single',
					'options' => $automobile_packages_list,
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_select_field($automobile_opt_array);

			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_status'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_status',
					'classes' => 'chosen-select-no-single',
					'options' => array(
						'awaiting-activation' => automobile_var_plugin_text_srt('automobile_var_awaiting_activation'),
						'active' => automobile_var_plugin_text_srt('automobile_var_active'),
						'inactive' => automobile_var_plugin_text_srt('automobile_var_inactive'),
						'delete' => automobile_var_plugin_text_srt('automobile_var_delete'),
					),
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_select_field($automobile_opt_array);

			$automobile_form_fields->automobile_form_hidden_render(
					array(
						'name' => automobile_var_plugin_text_srt('automobile_var_organization'),
						'id' => 'org_name',
						'classes' => '',
						'std' => '',
						'description' => '',
						'hint' => ''
					)
			);
			$automobile_html_fields->automobile_heading_render(
					array(
						'name' => automobile_var_plugin_text_srt('automobile_var_price'),
						'id' => 'price_information',
						'classes' => '',
						'std' => '',
						'description' => '',
						'hint' => ''
					)
			);
			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_new_price'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_new_price',
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_text_field($automobile_opt_array);

			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_old_price'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_old_price',
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_text_field($automobile_opt_array);

			$automobile_html_fields->automobile_heading_render(
					array(
						'name' => automobile_var_plugin_text_srt('automobile_var_video'),
						'id' => 'video_label',
						'classes' => '',
						'std' => '',
						'description' => '',
						'hint' => '',
					)
			);

			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_video_url'),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_video_url',
					'return' => true,
				),
			);

			$automobile_html_fields->automobile_text_field($automobile_opt_array);

			$automobile_html_fields->automobile_heading_render(
					array(
						'name' => automobile_var_plugin_text_srt('automobile_var_mailing_information'),
						'id' => 'mailing_information',
						'classes' => '',
						'std' => '',
						'description' => '',
						'hint' => ''
					)
			);
			$automobile_var_plugin_core->automobile_location_fields();

			$automobile_html_fields->automobile_heading_render(
					array(
						'name' => automobile_var_plugin_text_srt('automobile_var_inventory_field'),
						'id' => 'inventory_fields_label',
						'classes' => '',
						'std' => '',
						'description' => '',
						'hint' => '',
					)
			);
			$inventory_types_data = array( '' => automobile_var_plugin_text_srt('automobile_var_select_inventory_type') );
			$automobile_inventory_args = array( 'posts_per_page' => '-1', 'post_type' => 'inventory-type', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
			$cust_query = get_posts($automobile_inventory_args);
			if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
				foreach ( $cust_query as $automobile_inventory_type ) {
					$inventory_types_data[$automobile_inventory_type->post_name] = get_the_title($automobile_inventory_type->ID);
				}
			}
			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_inventory_type'),
				'desc' => '',
				'hint_text' => automobile_var_plugin_text_srt('automobile_var_select_inventory_type'),
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_type',
					'extra_atr' => ' onchange="automobile_inventory_type_change(this.value, \'' . $post_id . '\')"',
					'classes' => 'chosen-select-no-single',
					'return' => true,
					'options' => $inventory_types_data,
				),
			);
			$automobile_html_fields->automobile_select_field($automobile_opt_array);

			echo '<div id="cs-inventory-type-field">';
			$this->inventory_type_change_fields($inventory_type_slug, $post_id);
			echo '</div>';
		}

		public function inventory_type_change_fields($inventory_type_slug = 0, $post_id = 0) {

			if ( isset($_POST['inventory_type_slug']) ) {
				$inventory_type_slug = $_POST['inventory_type_slug'];
			}
			if ( isset($_POST['post_id']) ) {
				$post_id = $_POST['post_id'];
			}

			$html = $this->inventory_makes($inventory_type_slug, $post_id);
			$html .= $this->inventory_type_dyn_fields($inventory_type_slug);
			$html .= $this->feature_fields($inventory_type_slug, $post_id);

			if ( isset($_POST['inventory_type_slug']) ) {
				echo json_encode(array( 'inventory_fields' => $html ));
				die;
			} else {
				echo force_balance_tags($html);
			}
		}

		function feature_fields($inventory_type_slug = 0, $post_id = 0) {
			global $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_static_text;


			$automobile_inventory_features = get_post_meta($post_id, 'automobile_inventory_feature_list', true);

			$html = $automobile_html_fields->automobile_heading_render(
					array(
						'name' => automobile_var_plugin_text_srt('automobile_var_features'),
						'id' => 'features_information',
						'classes' => '',
						'std' => '',
						'echo' => false,
						'description' => '',
						'hint' => ''
					)
			);

			$html .= $automobile_html_fields->automobile_opening_field(array( 'name' => automobile_var_plugin_text_srt('automobile_var_features') ));

			$inventory_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish' ));
			$inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

			$automobile_var_get_features = get_post_meta($inventory_type_id, 'automobile_inventory_type_features', true);

			if ( is_array($automobile_var_get_features) && sizeof($automobile_var_get_features) > 0 ) {

				foreach ( $automobile_var_get_features as $feat_key => $features ) {
					if ( isset($features) && $features <> '' ) {
						$automobile_feature_name = isset($features['name']) ? $features['name'] : '';
						$html .= '
                        <div class="cs-feature-list cs-checkbox checkbox-inline">
                            <input ' . (is_array($automobile_inventory_features) && in_array($automobile_feature_name, $automobile_inventory_features) ? ' checked="checked"' : '') . ' type="checkbox" value="' . $automobile_feature_name . '" name="automobile_inventory_feature_list[]"><label>' . $automobile_feature_name . '</label>
                        </div>';
					}
				}
			}

			$html .= $automobile_html_fields->automobile_closing_field(array());

			return $html;
		}

		public function inventory_type_dyn_fields($inventory_type_slug = 0) {
			global $automobile_html_fields, $automobile_var_plugin_static_text;

			$automobile_fields_output = '';
			$inventory_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish' ));
			$inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
			$automobile_inventory_type_cus_fields = get_post_meta($inventory_type_id, "automobile_inventory_type_cus_fields", true);
			$automobile_fields_output .= $automobile_html_fields->automobile_heading_render(
					array( 'name' => automobile_var_plugin_text_srt('automobile_var_custom_fields'),
						'id' => 'automobile_fields_section',
						'classes' => '',
						'std' => '',
						'echo' => false,
						'description' => '',
					)
			);
			if ( is_array($automobile_inventory_type_cus_fields) && sizeof($automobile_inventory_type_cus_fields) > 0 ) {
				//echo "<pre>";print_r($automobile_inventory_type_cus_fields);echo "</pre>";
				foreach ( $automobile_inventory_type_cus_fields as $cus_field ) {
					$automobile_type = isset($cus_field['type']) ? $cus_field['type'] : '';
					switch ( $automobile_type ) {
						case('section'):

							$automobile_fields_output .= $automobile_html_fields->automobile_set_section(array( 'std' => isset($cus_field['label']) ? $cus_field['label'] : '' ));
							break;
						case('text'):
                                                    
							if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
								$automobile_opt_array = array(
									'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
									'desc' => '',
									'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
									'echo' => false,
									'field_params' => array(
										'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
										'id' => $cus_field['meta_key'],
										'cus_field' => true,
										'return' => true,
									),
								);
								if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
									$automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
								}

								$automobile_fields_output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
							}
							break;
						case('textarea'):
							if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
								$automobile_opt_array = array(
									'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
									'desc' => '',
									'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
									'echo' => false,
									'field_params' => array(
										'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
										'id' => $cus_field['meta_key'],
										'cus_field' => true,
										'return' => true,
									),
								);
								if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
									$automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
								}
								$automobile_fields_output .= $automobile_html_fields->automobile_textarea_field($automobile_opt_array);
							}
							break;
						case('dropdown'):
							if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
								$automobile_options = array();
								if ( isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0 ) {
									if ( isset($cus_field['first_value']) && $cus_field['first_value'] != '' ) {
										$automobile_options[''] = $cus_field['first_value'];
									}
									$automobile_opt_counter = 0;
									foreach ( $cus_field['options']['value'] as $automobile_option ) {

										$automobile_opt_label = $cus_field['options']['label'][$automobile_opt_counter];
										$automobile_options[$automobile_option] = $automobile_opt_label;
										$automobile_opt_counter ++;
									}
								}

								$automobile_opt_array = array(
									'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
									'desc' => '',
									'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
									'echo' => false,
									'field_params' => array(
										'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
										'id' => $cus_field['meta_key'],
										'options' => $automobile_options,
										'classes' => 'chosen-select chosen-select-no-single',
										'cus_field' => true,
										'return' => true,
									),
								);
								if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
									$automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
								}
								if ( isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes' ) {
									$automobile_opt_array['multi'] = true;
								}
								$automobile_fields_output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);
							}
							break;
						case('date'):
							if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
								$automobile_format = isset($cus_field['date_format']) && $cus_field['date_format'] != '' ? $cus_field['date_format'] : 'd-m-Y';

								$automobile_opt_array = array(
									'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
									'desc' => '',
									'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
									'echo' => false,
									'field_params' => array(
										'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
										'id' => $cus_field['meta_key'],
										'format' => $automobile_format,
										'cus_field' => true,
										'return' => true,
									),
								);
								if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
									$automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
								}
								$automobile_fields_output .= $automobile_html_fields->automobile_date_field($automobile_opt_array);
							}
							break;
						case('email'):
							if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
								$automobile_opt_array = array(
									'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
									'desc' => '',
									'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
									'echo' => false,
									'field_params' => array(
										'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
										'id' => $cus_field['meta_key'],
										'cus_field' => true,
										'return' => true,
									),
								);
								if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
									$automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
								}
								$automobile_fields_output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
							}
							break;
						case('url'):
							if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {

								$automobile_opt_array = array(
									'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
									'desc' => '',
									'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
									'echo' => false,
									'field_params' => array(
										'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
										'id' => $cus_field['meta_key'],
										'cus_field' => true,
										'return' => true,
									),
								);
								if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
									$automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
								}
								$automobile_fields_output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
							}
							break;
						case('range'):
							if ( isset($cus_field['meta_key']) && $cus_field['meta_key'] != '' ) {
								$automobile_opt_array = array(
									'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
									'desc' => '',
									'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
									'echo' => false,
									'field_params' => array(
										'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
										'id' => $cus_field['meta_key'],
										'cus_field' => true,
										'return' => true,
									),
								);
								if ( isset($cus_field['required']) && $cus_field['required'] == 'yes' ) {
									$automobile_opt_array['field_params']['extra_atr'] = ' required="required"';
								}
								$automobile_fields_output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
							}
							break;
					}
				}
				$automobile_fields_output .= '
                <script>
                    jQuery(document).ready(function () {
                        chosen_selectionbox();
                    });
                </script>';
			} else {
				$automobile_fields_output .= automobile_var_plugin_text_srt('automobile_var_no_custom_field_found');
			}

			return $automobile_fields_output;
		}

		public function inventory_makes($inventory_type_slug = 0, $post_id = 0) {
			global $automobile_html_fields, $automobile_var_plugin_static_text;



			$html = '';

			$automobile_inventory_type_makes_array = get_the_terms($post_id, 'inventory-make');
			$automobile_inventory_makes = array();
			if ( is_array($automobile_inventory_type_makes_array) && sizeof($automobile_inventory_type_makes_array) > 0 ) {
				foreach ( $automobile_inventory_type_makes_array as $in_category ) {
					$automobile_inventory_makes[] = $in_category->term_id;
				}
			}

			if ( ! isset($automobile_inventory_makes) || ! is_array($automobile_inventory_makes) || ! count($automobile_inventory_makes) > 0 ) {
				$automobile_inventory_makes = array();
			}

			$inventory_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish' ));
			$inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

			$automobile_inventory_type_makes = get_post_meta($inventory_type_id, 'automobile_inventory_type_makes', true);

			if ( ! isset($automobile_inventory_type_makes) || ! is_array($automobile_inventory_type_makes) || ! count($automobile_inventory_type_makes) > 0 ) {
				$automobile_inventory_type_makes = array();
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
				'taxonomy' => 'inventory-make',
				'pad_counts' => false
			);
			$categories = get_categories($args);

			$multiple = false;
			if ( $automobile_multi_cat_option == 'on' ) {
				$multiple = true;
			}
			$tax_options = '<option value="">-- ' . automobile_var_plugin_text_srt('automobile_var_select_makes') . ' --</option>';

			if ( $categories ) {
				foreach ( $categories as $category ) {
					$selected = '';

					if ( in_array($category->slug, $automobile_inventory_type_makes) ) {
						if ( in_array($category->term_id, $automobile_inventory_makes) ) {
							$selected = 'selected="selected"';
						}
						$tax_options .= '<option value="' . $category->term_id . '" ' . $selected . '>' . $category->name . '</option>';
					}
				}
			}

			$automobile_opt_array = array(
				'name' => automobile_var_plugin_text_srt('automobile_var_makes'),
				'desc' => '',
				'hint_text' => '',
				'multi' => $multiple,
				'echo' => false,
				'field_params' => array(
					'std' => '',
					'id' => 'inventory_makes',
					'classes' => 'chosen-select',
					'extra_atr' => ' onchange="automobile_load_make_models(this.value,\'' . $post_id . '\')"',
					'options_markup' => true,
					'options' => $tax_options,
					'return' => true,
				),
			);

			$html .= $automobile_html_fields->automobile_select_field($automobile_opt_array);

			$html .= '<div id="cs-inv-model-box">';
			$html .= $this->inventory_models($inventory_type_slug, $post_id);
			$html .= '</div>';

			return $html;
		}

		public function inventory_models($inventory_type_slug = 0, $post_id = 0) {
			global $automobile_html_fields, $automobile_var_plugin_static_text;

			if ( isset($_POST['post_id']) ) {
				$post_id = $_POST['post_id'];
			}

			$html = '';
			$automobile_inventory_type_models_array = get_the_terms($post_id, 'inventory-model');
			$automobile_inventory_models = array();
			if ( is_array($automobile_inventory_type_models_array) && sizeof($automobile_inventory_type_models_array) > 0 ) {
				foreach ( $automobile_inventory_type_models_array as $in_category ) {
					$automobile_inventory_models[] = $in_category->term_id;
				}
			}

			if ( ! isset($automobile_inventory_models) || ! is_array($automobile_inventory_models) || ! count($automobile_inventory_models) > 0 ) {
				$automobile_inventory_models = array();
			}

			$inventory_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish' ));
			$inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

			if ( isset($_POST['inventory_make']) ) {
				$automobile_inventory_make_id = $_POST['inventory_make'];
			} else {
				$automobile_inventory_make = wp_get_post_terms($post_id, 'inventory-make', true);
				$automobile_inventory_make_id = isset($automobile_inventory_make[0]->term_id) ? $automobile_inventory_make[0]->term_id : 0;
			}
			$automobile_inventory_make_models = get_term_meta($automobile_inventory_make_id, 'automobile_inventory_make_models', true);

			if ( ! isset($automobile_inventory_make_models) || ! is_array($automobile_inventory_make_models) || ! count($automobile_inventory_make_models) > 0 ) {
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
			if ( $automobile_multi_cat_option == 'on' ) {
				$multiple = true;
			}
			$tax_options = '<option value="">-- ' . automobile_var_plugin_text_srt('automobile_var_select_models') . ' --</option>';

			if ( $categories ) {
				foreach ( $categories as $category ) {
					$selected = '';

					if ( in_array($category->slug, $automobile_inventory_make_models) ) {
						if ( in_array($category->term_id, $automobile_inventory_models) ) {
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

			$html .= $automobile_html_fields->automobile_select_field($automobile_opt_array);
			$html .= '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';
			if ( isset($_POST['post_id']) && isset($_POST['inventory_make']) ) {
				echo json_encode(array( 'models' => $html ));
				die;
			} else {
				return $html;
			}
		}

		/**
		 * Start Function How to create taxonomies
		 */
	}

	return new automobile_var_inventory_meta();
}