<?php

/**
 * automobile Theme Options Fields
 *
 * @package WordPress
 * @subpackage automobile
 * @since Auto Mobile 1.0
 */
if (!class_exists('automobile_var_fields')) {

    class automobile_var_fields {

	/**
	 * Construct
	 *
	 * @return
	 */
	public function __construct() {
	    
	}

	/**
	 * Sub Menu Fields
	 *
	 * @return
	 */
	public function sub_menu($sub_menu = '') {

	    $menu_items = '';
	    $active = '';

	    if (is_array($sub_menu) && sizeof($sub_menu) > 0) {

		$menu_items .= '<ul class="sub-menu">';
		foreach ($sub_menu as $key => $value) {
		    $active = $key == "tab-global-setting" ? 'active' : '';
		    $menu_items .= '<li class="' . sanitize_html_class($key) . ' ' . $active . ' "><a href="#' . esc_html($key) . '" onClick="toggleDiv(this.hash);return false;">' . esc_attr($value) . '</a></li>';
		}
		$menu_items .= '</ul>';
	    }

	    return $menu_items;
	}

	/**
	 * All Options Fields
	 *
	 * @return
	 */
	public function automobile_var_fields($automobile_var_settings = '') {

	    global $automobile_var_options, $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_static_text;

	    $strings = new automobile_theme_all_strings;
	    $strings->automobile_theme_option_field_strings();
	    $counter = 0;
	    $automobile_var_counter = 0;
	    $menu = '';
	    $output = '';
	    $parent_heading = '';
	    $style = '';
	    $automobile_var_countries_list = '';

	    if (is_array($automobile_var_settings) && sizeof($automobile_var_settings) > 0) {
		foreach ($automobile_var_settings as $value) {
		    $counter++;
		    $val = '';

		    $select_value = '';
		    switch ($value['type']) {

			case "heading":
			    $parent_heading = $value['name'];
			    $menu .= '<li><a title="' . esc_html($value['name']) . '" href="#"><i class="' . sanitize_html_class($value["fontawesome"]) . '"></i><span class="cs-title-menu">' . esc_attr($value['name']) . '</span></a>';
			    if (is_array($value['options']) && $value['options'] <> '') {
				$menu .= $this->sub_menu($value['options']);
			    }
			    $menu .= '</li>';
			    break;

			case "main-heading":
			    $parent_heading = $value['name'];
			    $menu .= '<li><a title="' . esc_html($value['name']) . '" href="#' . $value['id'] . '" onClick="toggleDiv(this.hash);return false;">
							<i class="' . sanitize_html_class($value["fontawesome"]) . '"></i><span class="cs-title-menu">' . esc_attr($value['name']) . '</span></a>';
			    $menu .= '</li>';
			    break;

			case 'select_dashboard':
			    if (isset($automobile_var_options) and $automobile_var_options <> '') {
				if (isset($automobile_var_options[$value['id']])) {
				    $select_value = $automobile_var_options[$value['id']];
				}
			    } else {
				$select_value = $value['std'];
			    }
			    $args = array(
				'depth' => 0,
				'child_of' => 0,
				'sort_order' => 'ASC',
				'sort_column' => 'post_title',
				'show_option_none' => automobile_var_theme_text_srt('automobile_var_please_select_a_page'),
				'hierarchical' => '1',
				'exclude' => '',
//                                'include' => '',
				'meta_key' => '',
				'meta_value' => '',
				'authors' => '',
				'exclude_tree' => '',
				'selected' => $select_value,
				'echo' => 0,
				'name' => $value['id'],
				'post_type' => 'page'
			    );
			    $automobile_var_pages = wp_dropdown_pages($args);
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $val,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'options_markup' => true,
				    'options' => $automobile_var_pages,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
			    break;

			case "division":
			    $extra_atts = isset($value['extra_atts']) ? $value['extra_atts'] : '';
			    $d_enable = ' style="display:none;"';
			    if (isset($value['enable_val'])) {
				$enable_id = isset($value['enable_id']) ? $value['enable_id'] : '';
				$enable_val = $value['enable_val'];
				$d_val = '';
				if (isset($automobile_var_options[$enable_id])) {
				    $d_val = $automobile_var_options[$enable_id];
				}
				$enable_multi = explode(',', $enable_val);
				if (is_array($enable_multi) && sizeof($enable_multi) > 1) {
				    $d_enable = in_array($d_val, $enable_multi) ? ' style="display:block;"' : ' style="display:none;"';
				} else {
				    $d_enable = $d_val == $enable_val ? ' style="display:block;"' : ' style="display:none;"';
				}
			    }
			    $output .= '<div' . $d_enable . ' ' . $extra_atts . '>';
			    break;

			case "division_close":
			    $output .= '</div>';
			    break;

			case "col-right-text":
			    $col_heading = "";
			    $help_text = "";
			    if (isset($value['col_heading'])) {
				$col_heading = isset($value['col_heading']) ? $value['col_heading'] : '';
			    }
			    if (isset($value['help_text'])) {
				$help_text = isset($value['help_text']) ? $value['help_text'] : '';
			    }
			    $automobile_opt_array = array(
				'col_heading' => $col_heading,
				'help_text' => $help_text,
			    );
			    $output .= $automobile_var_html_fields->automobile_var_set_col_right($automobile_opt_array);
			    break;

			case "sub-heading":
			    $automobile_var_counter++;
			    if ($automobile_var_counter > 1) {
				$output .= '</div>';
			    }
			    if ($value['id'] != 'tab-global-setting') {
				$style = 'style="display:none;"';
			    }

			    $output .= '<div id="' . $value['id'] . '" ' . $style . ' >';
			    $output .= '<div class="theme-header">
											<h1>' . esc_attr($value['name']) . '</h1>
									   </div>';
			    if (isset($value['with_col']) && $value['with_col'] == true) {
				$output .= '<div class="col-holder">';
				$output .= '<div class="col2-right">';
			    }
			    break;

			case "announcement":
			    $automobile_var_counter++;
			    $output .= '<div id="' . $value['id'] . '" class="alert alert-info fade in nomargin theme_box">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
											<h4>' . automobile_allow_special_char($value['name']) . '</h4>
											<p>' . automobile_allow_special_char($value['std']) . '</p>
								 </div>';
			    break;

			case "section":
			    $output .= '<div class="theme-help">
									<h4>' . esc_attr($value['std']) . '</h4>
									<div class="clear"></div>
								  </div>';
			    break;

			case 'text':
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $val,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => '',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
			    break;

			case 'slider_code':
			    if (isset($automobile_var_options['automobile_var_' . $value['id']]) && $automobile_var_options['automobile_var_' . $value['id']] <> '') {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_slider_options = '';

			    if (class_exists('RevSlider') && class_exists('automobile_var_RevSlider')) {
				$slider = new automobile_var_RevSlider();
				$arrSliders = $slider->getAllSliderAliases();
				if (is_array($arrSliders)) {
				    foreach ($arrSliders as $key => $entry) {

					$selected = '';
					if ($select_value != '') {
					    if ($select_value == $entry['alias']) {
						$selected = ' selected="selected"';
					    }
					} else {
					    if (isset($value['std']))
						if ($value['std'] == $entry['alias']) {
						    $selected = ' selected="selected"';
						}
					}
					$automobile_slider_options .= '<option ' . $selected . ' value="' . $entry['alias'] . '">' . $entry['title'] . '</option>';
				    }
				}
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $val,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'options_markup' => true,
				    'options' => $automobile_slider_options,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    break;

			case 'range_font' :
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'extra_att' => 'style="width:50%; display:inline-block;"',
				'id' => 'automobile_var_' . $value['id'] . '_range',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $val,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => '',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

			    break;

			case 'range':
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'id' => 'automobile_var_' . $value['id'] . '_range',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $val,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => '',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

			    break;

			case 'textarea':
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'id' => 'automobile_var_' . $value['id'] . '_textarea',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $val,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => '',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

			    break;
			case 'automatic_upgrade':
			    // If this is an request to upgrade theme.
			    if (isset($_GET['action']) && $_GET['action'] == 'upgrade_theme') {
				$data = automobile_auto_upgrade_theme_and_plugins();
				//add_action( 'admin_notices', 'jobcareer_show_theme_auto_update_success' );

				$cs_theme_upgraded_name = '';
				if (isset($data['cs_theme_upgraded_name'])) {
				    $cs_theme_upgraded_name = $data['cs_theme_upgraded_name'];
				}

				$plugins_str = '';
				if (isset($data['cs_plugins_upgraded'])) {
				    $cs_plugins_upgraded = $data['cs_plugins_upgraded'];
				    $plugins_str = implode(', ', $cs_plugins_upgraded);
				}

				$msgStr = $cs_theme_upgraded_name;
				if ($msgStr != '') {
				    $msgStr .= ', ' . $plugins_str;
				} else {
				    $msgStr = $plugins_str;
				}

				if ($msgStr != '') {
				    $message = __('Successfully installed ', 'automobile');
				} else {
				    $message = __('Sorry unable to upgrade theme. Contact Theme Author and repot this issue.', 'automobile');
				}

				$cs_counter++;
				$output .= '<div id="' . $value['id'] . '" class="alert alert-info fade in nomargin theme_box">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
										<h4>Upgrade Theme and Plugin(s)</h4>
										<p>' . $message . '</p>
								</div>
								<script type="text/javascript">
									(function($){
										$(function() {
											$(".wrap").hide();
										});
									})(jQuery);
								</script>
								';
			    }
			    break;
			case 'generate_backup':

			    global $wp_filesystem;

			    $backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');

			    if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

				return true;
			    }

			    if (!WP_Filesystem($creds)) {
				request_filesystem_credentials($backup_url, '', true, false, array());
				return true;
			    }

			    $automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';

			    $automobile_var_upload_dir_path = get_template_directory_uri() . '/include/backend/cs-theme-options/backups/';

			    $automobile_var_all_list = $wp_filesystem->dirlist($automobile_var_upload_dir);

			    $output .= '<div class="backup_generates_area" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">';
			    $automobile_var_import_options = automobile_var_theme_text_srt('automobile_var_import_options');
			    $output .= '
							<div class="cs-import-help">
								<h4>' . $automobile_var_import_options . '</h4>
							</div>';

			    $output .= '<div class="external_backup_areas">';
			    $automobile_var_location_and_hit_import_button = automobile_var_theme_text_srt('automobile_var_location_and_hit_import_button');
			    $output .= '<p>' . $automobile_var_location_and_hit_import_button . '</p>';

			    $automobile_opt_array = array(
				'std' => '',
				'cust_id' => 'bkup_import_url',
				'cust_name' => 'bkup_import_url',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);

			    $automobile_opt_array = array(
				'std' => automobile_var_theme_text_srt('automobile_var_import'),
				'cust_id' => 'cs-backup-url-restore',
				'cust_name' => 'cs-backup-url-restore',
				'cust_type' => 'button',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);

			    $output .= '</div>';
			    $automobile_var_export_options = automobile_var_theme_text_srt('automobile_var_export_options');
			    $output .= '
							<div class="cs-import-help">
								<h4>' . $automobile_var_export_options . '</h4>
							</div>';

			    if (is_array($automobile_var_all_list) && sizeof($automobile_var_all_list) > 0) {

				$output .= '<p>' . automobile_var_theme_text_srt('automobile_var_download_backups_hint') . '</p>';

				$output .= '<select onchange="automobile_var_set_filename(this.value, \'' . esc_url($automobile_var_upload_dir_path) . '\')">';

				$automobile_var_list_count = 1;
				foreach ($automobile_var_all_list as $file_key => $file_val) {

				    if (isset($file_val['name'])) {

					$automobile_var_slected = sizeof($automobile_var_all_list) == $automobile_var_list_count ? ' selected="selected"' : '';
					$output .= '<option' . $automobile_var_slected . '>' . $file_val['name'] . '</option>';
				    }
				    $automobile_var_list_count++;
				}
				$output .= '</select>';
				$output .= '<div class="backup_action_btns">';

				if (isset($file_val['name'])) {

				    $automobile_opt_array = array(
					'std' => automobile_var_theme_text_srt('automobile_var_restore'),
					'cust_id' => 'cs-backup-restore',
					'cust_name' => 'cs-backup-restore',
					'cust_type' => 'button',
					'extra_atr' => 'data-file="' . $file_val['name'] . '"',
					'return' => true,
				    );
				    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
				    $automobile_var_download = automobile_var_theme_text_srt('automobile_var_download');
				    $output .= '<a download="' . $file_val['name'] . '" href="' . esc_url($automobile_var_upload_dir_path . $file_val['name']) . '">' . $automobile_var_download . '</a>';

				    $automobile_opt_array = array(
					'std' => automobile_var_theme_text_srt('automobile_var_delete'),
					'cust_id' => 'cs-backup-delte',
					'cust_name' => 'cs-backup-delte',
					'cust_type' => 'button',
					'extra_atr' => 'data-file="' . $file_val['name'] . '"',
					'return' => true,
				    );
				    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
				}

				$output .= '</div>';
			    }

			    $automobile_opt_array = array(
				'std' => automobile_var_theme_text_srt('automobile_var_generate_backup'),
				'cust_id' => 'cs-backup-generte',
				'cust_name' => 'cs-backup-generte',
				'cust_type' => 'button',
				'extra_atr' => 'onclick="javascript:automobile_var_backup_generate(\'' . esc_js(admin_url('admin-ajax.php')) . '\');"',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);

			    $output .= '</div>';

			    break;



			case "banner_fields":
			    $automobile_var_rand_id = rand(23789, 534578930);
			    if (isset($automobile_var_options) && $automobile_var_options <> '') {
				if (!isset($automobile_var_options['automobile_var_banner_title'])) {
				    $network_list = '';
				    $display = 'none';
				} else {

				    $network_list = isset($automobile_var_options['automobile_var_banner_title']) ? $automobile_var_options['automobile_var_banner_title'] : '';
				    $banner_style = isset($automobile_var_options['automobile_var_banner_style']) ? $automobile_var_options['automobile_var_banner_style'] : '';
				    $banner_type = isset($automobile_var_options['automobile_var_banner_type']) ? $automobile_var_options['automobile_var_banner_type'] : '';
				    $banner_image = isset($automobile_var_options['automobile_var_banner_image_array']) ? $automobile_var_options['automobile_var_banner_image_array'] : '';
				    $banner_field_url = isset($automobile_var_options['automobile_var_banner_field_url']) ? $automobile_var_options['automobile_var_banner_field_url'] : '';
				    $banner_target = isset($automobile_var_options['automobile_var_banner_target']) ? $automobile_var_options['automobile_var_banner_target'] : '';
				    $adsense_code = isset($automobile_var_options['automobile_var_adsense_code']) ? $automobile_var_options['automobile_var_adsense_code'] : '';
				    $code_no = isset($automobile_var_options['automobile_var_banner_field_code_no']) ? $automobile_var_options['automobile_var_banner_field_code_no'] : '';

				    $display = 'block';
				}
			    } else {
				$val = isset($automobile_var_options['options']) ? $value['options'] : '';
				$std = isset($automobile_var_options['id']) ? $value['id'] : '';
				$display = 'block';
				$network_list = isset($automobile_var_options['automobile_var_banner_title']) ? $automobile_var_options['automobile_var_banner_title'] : '';
				$banner_style = isset($automobile_var_options['automobile_var_banner_style']) ? $automobile_var_options['automobile_var_banner_style'] : '';
				$banner_type = isset($automobile_var_options['automobile_var_banner_type']) ? $automobile_var_options['automobile_var_banner_type'] : '';
				$banner_image = isset($automobile_var_options['automobile_var_banner_image_array']) ? $automobile_var_options['automobile_var_banner_image_array'] : '';
				$banner_field_url = isset($automobile_var_options['automobile_var_banner_field_url']) ? $automobile_var_options['automobile_var_banner_field_url'] : '';
				$banner_target = isset($automobile_var_options['automobile_var_banner_target']) ? $automobile_var_options['automobile_var_banner_target'] : '';
				$adsense_code = isset($automobile_var_options['automobile_var_adsense_code']) ? $automobile_var_options['automobile_var_adsense_code'] : '';
				$code_no = isset($automobile_var_options['automobile_var_banner_field_code_no']) ? $automobile_var_options['automobile_var_banner_field_code_no'] : '';
			    }
			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
				'desc' => '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_title_field_hint'),
				'field_params' => array(
				    'std' => '',
				    'cust_id' => 'banner_title_input',
				    'cust_name' => 'banner_title_input',
				    'classes' => '',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_banner_style'),
				'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_style_hint'),
				'field_params' => array(
				    'std' => '',
				    'desc' => '',
				    'cust_id' => "banner_style_input",
				    'cust_name' => 'banner_style_input',
				    'classes' => 'input-small chosen-select',
				    'options' =>
				    array(
					'top_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_top'),
					'bottom_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_bottom'),
					'sidebar_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_sidebar'),
					'vertical_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_vertical'),
				    ),
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);




			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_banner_type'),
				'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_type_hint'),
				'field_params' => array(
				    'std' => '',
				    'desc' => '',
				    'cust_id' => "banner_type_input",
				    'cust_name' => 'banner_type_input',
				    'classes' => 'input-small chosen-select',
				    'extra_atr' => 'onchange="javascript:automobile_var_banner_type_toggle(this.value , \'' . $automobile_var_rand_id . '\')"',
				    'options' =>
				    array(
					'image' => automobile_var_theme_text_srt('automobile_var_banner_image'),
					'code' => automobile_var_theme_text_srt('automobile_var_banner_code'),
				    ),
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);


			    $output .= '<div id="ads_image' . absint($automobile_var_rand_id) . '">';

			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_banner_image'),
				'id' => 'banner_field_image',
				'std' => '',
				'desc' => '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_image_hint'),
				'prefix' => '',
				'field_params' => array(
				    'std' => '',
				    'id' => 'banner_field_image',
				    'prefix' => '',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
			    $output .= '</div>';

			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_url_field'),
				'desc' => '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_url_hint'),
				'field_params' => array(
				    'std' => '',
				    'cust_id' => 'banner_field_url_input',
				    'cust_name' => 'banner_field_url_input',
				    'classes' => '',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);




			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_banner_target'),
				'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_target_hint'),
				'field_params' => array(
				    'std' => '',
				    'desc' => '',
				    'cust_id' => "banner_target_input",
				    'cust_name' => 'banner_target_input',
				    'classes' => 'input-small chosen-select',
				    'options' =>
				    array(
					'_self' => automobile_var_theme_text_srt('automobile_var_banner_target_self'),
					'_blank' => automobile_var_theme_text_srt('automobile_var_banner_target_blank'),
				    ),
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    $output .= '<div id="ads_code' . absint($automobile_var_rand_id) . '" style="display:none">';
			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_banner_ad_sense_code'),
				'desc' => '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_ad_sense_code_hint'),
				'field_params' => array(
				    'std' => '',
				    'cust_id' => 'adsense_code_input',
				    'cust_name' => 'adsense_code_input[]',
				    'classes' => '',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

			    $output .= '</div>';

			    $automobile_opt_array = array(
				'name' => '&nbsp;',
				'desc' => '',
				'hint_text' => '',
				'field_params' => array(
				    'std' => automobile_var_theme_text_srt('automobile_var_add'),
				    'id' => 'automobile_var_add_banner',
				    'classes' => '',
				    'cust_type' => 'button',
				    'extra_atr' => 'onclick="javascript:automobile_var_add_banner(\'' . admin_url("admin-ajax.php") . '\')"',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

			    $output .= '
							<div class="social-area" style="display:' . $display . '">
							<div class="theme-help">
							  <h4 style="padding-bottom:0px;">' . automobile_var_theme_text_srt('automobile_var_banner_already_added') . '</h4>
							  <div class="clear"></div>
							</div>
							<div class="boxes">
							<table class="to-table" border="0" cellspacing="0">
								<thead>
								  <tr>
                                                                  
                                                                        <th>' . automobile_var_theme_text_srt('automobile_var_banner_table_title') . '</th>
									<th>' . automobile_var_theme_text_srt('automobile_var_banner_table_style') . '</th>
									<th>' . automobile_var_theme_text_srt('automobile_var_banner_table_image') . '</th>

									<th>' . automobile_var_theme_text_srt('automobile_var_banner_table_clicks') . '</th>
									<th>' . automobile_var_theme_text_srt('automobile_var_banner_table_shortcode') . '</th>
									<th class="centr">' . automobile_var_theme_text_srt('automobile_var_actions') . '</th>
								  </tr>
								</thead>
								<tbody id="banner_area">';
			    $i = 0;
			    if (is_array($network_list)) {
				foreach ($network_list as $network) {
				    if (isset($network_list[$i]) || isset($network_list[$i])) {

					$automobile_rand_num = rand(123456, 987654);
					$output .= '<tr id="del_' . $automobile_rand_num . '">';

					$output .= '<td>' . esc_html($network_list[$i]) . '</td>';
					$output .= '<td>' . esc_html($banner_style[$i]) . '</td>';
					if (isset($banner_image[$i]) && !empty($banner_image[$i]) && $banner_type[$i] == 'image') {
					    $output .= '<td><img src="' . esc_url($banner_image[$i]) . '" width="100" /></td>';
					} else {
					    $output .= '<td>' . automobile_var_theme_text_srt('automobile_var_custom_code') . '</td>';
					}

					if ($banner_type[$i] == 'image') {
					    $banner_click_count = get_option("banner_clicks_" . $code_no[$i]);
					    $banner_click_count = $banner_click_count <> '' ? $banner_click_count : '0';
					    $output .= '<td>' . $banner_click_count . '</td>';
					} else {
					    $output .= '<td>&nbsp;</td>';
					}

					$output .= '<td>[automobile_ads id="' . $code_no[$i] . '"]</td>';
					$output .= '
                                          <td class="centr">
                                          <a class="remove-btn" onclick="javascript:return confirm(\'' . automobile_var_theme_text_srt('automobile_var_alert_msg') . '\')" href="javascript:ads_del(\'' . $automobile_rand_num . '\')" data-toggle="tooltip" data-placement="top" title="' . automobile_var_theme_text_srt('automobile_var_remove') . '">
                                          <i class="icon-times"></i></a>
                                          <a href="javascript:automobile_var_toggle(\'' . absint($automobile_rand_num) . '\')" data-toggle="tooltip" data-placement="top" title="' . automobile_var_theme_text_srt('automobile_var_edit') . '">
                                          <i class="icon-edit3"></i>
                                          </a>
                                          </td>
                                          </tr>';

					$output .= '
                                          <tr id="' . absint($automobile_rand_num) . '" style="display:none">
                                          <td colspan="3">
                                          <div class="form-elements">
                                          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                                          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                          <a class="cs-remove-btn" onclick="automobile_var_toggle(\'' . $automobile_rand_num . '\')"><i class="icon-times"></i></a>
                                          </div>
                                          </div>';

					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
					    'desc' => '',
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_title_field_hint'),
					    'field_params' => array(
						'std' => isset($network_list[$i]) ? $network_list[$i] : '',
						'cust_id' => 'banner_title',
						'cust_name' => 'automobile_var_banner_title[]',
						'classes' => '',
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_banner_style'),
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_style_hint'),
					    'field_params' => array(
						'std' => isset($banner_style[$i]) ? $banner_style[$i] : '',
						'cust_id' => 'banner_style',
						'cust_name' => 'automobile_var_banner_style[]',
						'desc' => '',
						'classes' => 'input-small chosen-select',
						'options' =>
						array(
						    'top_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_top'),
						    'bottom_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_bottom'),
						    'sidebar_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_sidebar'),
						    'vertical_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_vertical'),
						),
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);




					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_banner_type'),
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_type_hint'),
					    'field_params' => array(
						'std' => isset($banner_type[$i]) ? $banner_type[$i] : '',
						'cust_id' => 'banner_type',
						'cust_name' => 'automobile_var_banner_type[]',
						'desc' => '',
						'extra_atr' => 'onchange="javascript:automobile_var_banner_type_toggle(this.value , \'' . $automobile_rand_num . '\')"',
						'classes' => 'input-small chosen-select',
						'options' =>
						array(
						    'image' => automobile_var_theme_text_srt('automobile_var_banner_image'),
						    'code' => automobile_var_theme_text_srt('automobile_var_banner_code'),
						),
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

					$display_ads = 'none';
					if ($banner_type[$i] == 'image') {
					    $display_ads = 'block';
					} elseif ($banner_type[$i] == 'code') {
					    $display_ads = 'none';
					}
					$output .= '<div id="ads_image' . absint($automobile_rand_num) . '" style="display:' . esc_html($display_ads) . '">';

					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_banner_image'),
					    'id' => 'banner_image',
					    'std' => isset($banner_image[$i]) ? $banner_image[$i] : '',
					    'desc' => '',
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_image_hint'),
					    'prefix' => '',
					    'array' => true,
					    'field_params' => array(
						'std' => isset($banner_image[$i]) ? $banner_image[$i] : '',
						'id' => 'banner_image',
						'prefix' => '',
						'array' => true,
						'return' => true,
					    ),
					);

					$output .= $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
					$output .= '</div>';


					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_url_field'),
					    'desc' => '',
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_url_hint'),
					    'field_params' => array(
						'std' => isset($banner_field_url[$i]) ? $banner_field_url[$i] : '',
						'cust_id' => 'banner_field_url',
						'cust_name' => 'automobile_var_banner_field_url[]',
						'classes' => '',
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_banner_target'),
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_target_hint'),
					    'field_params' => array(
						'desc' => '',
						'std' => isset($banner_target[$i]) ? $banner_target[$i] : '',
						'cust_id' => 'banner_target',
						'cust_name' => 'automobile_var_banner_target[]',
						'classes' => 'input-small chosen-select',
						'options' =>
						array(
						    '_self' => automobile_var_theme_text_srt('automobile_var_banner_target_self'),
						    '_blank' => automobile_var_theme_text_srt('automobile_var_banner_target_blank'),
						),
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
					$display_ads = 'none';
					if ($banner_type[$i] == 'image') {
					    $display_ads = 'none';
					} elseif ($banner_type[$i] == 'code') {
					    $display_ads = 'block';
					}
					$output .= '<div id="ads_code' . absint($automobile_rand_num) . '" style="display:' . esc_html($display_ads) . '">';
					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_banner_ad_sense_code'),
					    'desc' => '',
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_ad_sense_code_hint'),
					    'field_params' => array(
						'std' => isset($adsense_code[$i]) ? $adsense_code[$i] : '',
						'cust_id' => 'adsense_code',
						'cust_name' => 'automobile_var_adsense_code[]',
						'classes' => '',
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
					$output .= '</div>';

					$automobile_opt_array = array(
					    'std' => isset($code_no[$i]) ? $code_no[$i] : '',
					    'id' => 'banner_field_code_no',
					    'cust_name' => 'automobile_var_banner_field_code_no[]',
					    'return' => true,
					);
					$output .= $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

					$output .= '
										  </td>
										</tr>';
				    }
				    $i++;
				}
			    }

			    $output .= '</tbody></table></div></div>';
			    break;


			case 'widgets_backup':

			    $output .= '<div class="backup_generates_area" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">';
			    if (class_exists('automobile_var_widget_data')) {

				global $wp_filesystem;

				$backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');

				if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

				    return true;
				}

				if (!WP_Filesystem($creds)) {
				    request_filesystem_credentials($backup_url, '', true, false, array());
				    return true;
				}

				$automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-widgets/import/widgets-backup/';

				$automobile_var_upload_dir_path = get_template_directory_uri() . '/include/backend/cs-widgets/import/widgets-backup/';

				$automobile_var_all_list = $wp_filesystem->dirlist($automobile_var_upload_dir);
				$automobile_var_import_widgets = automobile_var_theme_text_srt('automobile_var_import_widgets');
				$output .= '
                                            <div class="cs-import-help">
                                                    <h4>' . $automobile_var_import_widgets . '</h4>
                                            </div>';

				$output .= '
                                            <div class="external_backup_areas">
                                                    <div id="cs-import-widgets-con">
                                                            <div id="cs-import-widget-loader"></div>
                                                            ' . automobile_var_widget_data::import_settings_page() . '
                                                    </div>
                                            </div>';

				if (is_array($automobile_var_all_list) && sizeof($automobile_var_all_list) > 0) {
				    $automobile_var_download_backups_hint = automobile_var_theme_text_srt('automobile_var_download_backups_hint');
				    $output .= '<p>' . $automobile_var_download_backups_hint . '</p>';

				    $output .= '<select id="cs-wid-backup-change" onchange="automobile_var_set_filename(this.value, \'' . esc_url($automobile_var_upload_dir_path) . '\')">';

				    $automobile_var_list_count = 1;
				    foreach ($automobile_var_all_list as $file_key => $file_val) {

					if (isset($file_val['name'])) {

					    $automobile_var_slected = sizeof($automobile_var_all_list) == $automobile_var_list_count ? ' selected="selected"' : '';
					    $output .= '<option' . $automobile_var_slected . '>' . $file_val['name'] . '</option>';
					}
					$automobile_var_list_count++;
				    }
				    $output .= '</select>';
				    $output .= '<div class="backup_action_btns">';

				    if (isset($file_val['name'])) {

					$automobile_opt_array = array(
					    'std' => automobile_var_theme_text_srt('automobile_var_show_widget_settings'),
					    'cust_id' => 'cs-wid-backup-restore',
					    'cust_name' => 'cs-wid-backup-restore',
					    'cust_type' => 'button',
					    'extra_atr' => 'data-path="' . $automobile_var_upload_dir_path . '" data-file="' . $file_val['name'] . '"',
					    'return' => true,
					);
					$output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
					$automobile_var_download = automobile_var_theme_text_srt('automobile_var_download');
					$output .= '<a download="' . $file_val['name'] . '" href="' . esc_url($automobile_var_upload_dir_path . $file_val['name']) . '">' . $automobile_var_download . '</a>';

					$automobile_opt_array = array(
					    'std' => automobile_var_theme_text_srt('automobile_var_delete'),
					    'cust_id' => 'cs-wid-backup-delte',
					    'cust_name' => 'cs-wid-backup-delte',
					    'cust_type' => 'button',
					    'extra_atr' => 'data-file="' . $file_val['name'] . '"',
					    'return' => true,
					);
					$output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
				    }

				    $output .= '</div>';
				}
				$output .= '
                                            <div class="cs-import-help">
                                                    <h4>' . automobile_var_theme_text_srt('automobile_var_export_widgets') . '</h4>
                                            </div>';

				$output .= '
                                            <div id="cs-export-widgets-con">
                                                    <div id="cs-export-widget-loader"></div>
                                                    ' . automobile_var_widget_data::export_settings_page() . '
                                            </div>';
			    }

			    $output .= '</div>';

			    break;

			case "layout":
			    global $automobile_var_header_colors;

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    if (isset($value['id'])) {

				$automobile_name = 'automobile_var_' . $value['id'];

				$automobile_opt_array = array(
				    'name' => isset($value['name']) ? $value['name'] : '',
				    'id' => $automobile_name . '_layout',
				    'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				);
				$output .= $automobile_var_html_fields->automobile_var_opening_field($automobile_opt_array);

				if (is_array($value['options']) && sizeof($value['options']) > 0) {
				    $output .= '
									<div class="input-sec">
										<div class="meta-input pattern">';
				    foreach ($value['options'] as $key => $option) {
					$checked = '';
					$custom_class = '';
					if ($select_value != '') {

					    if ($select_value == $key) {
						$checked = ' checked';
						$custom_class = 'check-list';
					    }
					} else {
					    if ($value['std'] == $key) {
						$checked = ' checked';
						$custom_class = 'check-list';
					    }
					}

					$automobile_rand_id = rand(123456, 987654);

					$output .= '
												<div class="radio-image-wrapper">';
					$automobile_opt_array = array(
					    'std' => esc_html($key),
					    'cust_id' => $automobile_name . $automobile_rand_id,
					    'cust_name' => $automobile_name,
					    'cust_type' => 'radio',
					    'classes' => 'radio',
					    'extra_atr' => 'onclick="select_bg(\'' . $automobile_name . '\',\'' . esc_html($key) . '\',\'' . get_template_directory_uri() . '\',\'\')" ' . $checked,
					    'return' => true,
					);
					$output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
					$output .= '
                                                    <label for="radio_' . esc_html($key) . '"> 
                                                            <span class="ss"><img src="' . get_template_directory_uri() . '/assets/backend/images/' . esc_html($key) . '.png" /></span> 
                                                            <span class="' . sanitize_html_class($custom_class) . '" id="check-list">&nbsp;</span>
                                                    </label>
                                                    <span class="title-theme">' . esc_attr($option) . '</span>            
                                            </div>';
				    }
				    $output .= '
                                                </div>
                                        </div>';
				}
				$output .= $automobile_var_html_fields->automobile_var_closing_field(array());
			    }
			    break;

			case "horizontal_tab":
			    if (isset($automobile_var_options['automobile_var_layout']) && $automobile_var_options['automobile_var_layout'] <> 'boxed') {
				echo '
                                        <style type="text/css" scoped>
                                                .horizontal_tabs,.main_tab{
                                                        display:none;
                                                }
                                        </style>';
			    }
			    $output .= '<div class="horizontal_tabs"><ul>';
			    $i = 0;
			    if (is_array($value['options']) && sizeof($value['options']) > 0) {
				foreach ($value['options'] as $key => $val) {
				    $active = ($i == 0) ? 'active' : '';
				    $output .= '<li class="' . sanitize_html_class($val) . ' ' . $active . '"><a href="#' . $val . '" onclick="show_hide(this.hash);return false;">' . esc_html($key) . '</a></li>';
				    $i++;
				}
			    }
			    $output .= '</ul></div>';

			    break;

			case "layout_body":
			    global $automobile_var_header_colors;
			    $bg_counter = 0;
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    if ($value['path'] == "background") {
				$image_name = "background";
			    } else {
				$image_name = "pattern";
			    }

			    if (isset($value['id'])) {

				$automobile_name = 'automobile_var_' . $value['id'];

				$output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $value['display'] . '" id="' . $value['tab'] . '">';

				$automobile_opt_array = array(
				    'name' => isset($value['name']) ? $value['name'] : '',
				    'id' => $automobile_name . '_layout_body',
				    'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				);
				$output .= $automobile_var_html_fields->automobile_var_opening_field($automobile_opt_array);

				$output .= '
                                        <div class="input-sec">
                                                <div class="meta-input pattern">';
				if (is_array($value['options']) && sizeof($value['options']) > 0) {
				    foreach ($value['options'] as $key => $option) {
					$checked = '';
					$custom_class = '';
					if ($select_value == $option) {
					    $checked = ' checked';
					    $custom_class = 'check-list';
					}

					$automobile_rand_id = rand(123456, 987654);

					$output .= '
                                                <div class="radio-image-wrapper">';
					$automobile_opt_array = array(
					    'std' => $option,
					    'cust_id' => $automobile_name . $automobile_rand_id,
					    'cust_name' => $automobile_name,
					    'cust_type' => 'radio',
					    'classes' => 'radio',
					    'extra_atr' => 'onClick="javascript:select_bg(\'' . $automobile_name . '\',\'' . $option . '\',\'' . get_template_directory_uri() . '\',\'\')" ' . $checked,
					    'return' => true,
					);
					$output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
					$output .= '
														<label for="radio_' . esc_html($key) . '"> 
															<span class="ss"><img src="' . get_template_directory_uri() . '/assets/backend/images/' . $value['path'] . '/' . $image_name . $bg_counter . '.png" /></span> 
															<span id="check-list" class="' . sanitize_html_class($custom_class) . '">&nbsp;</span>
														</label>
													</div>';
					$bg_counter++;
				    }
				}
				$output .= '
											</div>
										</div>
									</div>
								</div>';
				$output .= $automobile_var_html_fields->automobile_var_closing_field(array());
			    }
			    break;

			case 'select':
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }
			    $display = isset($value['display']) ? $value['display'] : '';
			    $tab = isset($value['tab']) ? $value['tab'] : '';
			    if ($tab == 'custom_image_position') {
				$output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $display . '" id="' . $tab . '">';
			    }
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'extra_atr' => isset($value['extra_att']) ? $value['extra_att'] : '',
				    'return' => true,
				    'options' => isset($value['options']) ? $value['options'] : '',
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
			    if ($tab == 'custom_image_position') {
				$output .= '
                                                </div>
                                            </div>';
			    }
			    break;

			case 'gfont_select':

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    $output .= '
                                        <div class="alert alert-info fade in nomargin theme_box">
                                                <h4><b>' . esc_attr($value['name']) . '</b></h4>
                                                <p><strong>' . esc_attr($value['hint_text']) . '</strong></p>
                                        </div>';

			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_font_family'),
				'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_select' : '',
				'extra_att' => 'style="width:50%; display:inline-block;"',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'extra_atr' => 'onchange="automobile_var_google_font_att(\'' . admin_url("admin-ajax.php") . '\',this.value, \'automobile_var_' . $value['id'] . '_att\')"',
				    'first_option' => '<option value="">' . automobile_var_theme_text_srt('automobile_var_default_font') . '</option>',
				    'options' => isset($value['options']) ? $value['options'] : '',
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    break;
			case 'mailchimp':


			    if (isset($automobile_var_options) && $automobile_var_options <> '') {
				if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				    $select_value = $automobile_var_options['automobile_var_' . $value['id']];
				}
			    } else {
				$select_value = $value['std'];
			    }

			    $output .= '';



			    $output_str = '';
			    foreach ($value['options'] as $option_key => $option) {
				$selected = '';
				if ($select_value != '') {
				    if ($select_value == $option_key) {
					$selected = ' selected="selected"';
				    }
				} else {
				    if (isset($value['std']))
					if ($value['std'] == $option_key) {
					    $selected = ' selected="selected"';
					}
				}
				$output_str .= '<option' . $selected . ' value="' . $option_key . '">';
				$output_str .= $option;
				$output_str .= '</option>';
			    }
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_select' : '',
				'extra_att' => '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'first_option' => '<option value="">' . automobile_var_theme_text_srt('automobile_var_select_attribute') . '</option>',
				    'options' => isset($output_str) ? $output_str : '',
				    'options_markup' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);





			    $output .= '';

			    break;
			case 'gfont_att_select':

			    if (isset($automobile_var_options['automobile_var_' . $value['id']]) && $automobile_var_options['automobile_var_' . $value['id']] <> '') {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
				$value['options'] = automobile_var_get_google_font_attribute('', $automobile_var_options[str_replace('_att', '', 'automobile_var_' . $value['id'])]);
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_atts_array = array();
			    if (isset($value['options']) && is_array($value['options']) && !empty($value['options'])) {
				foreach ($value['options'] as $automobile_att) :
				    $automobile_atts_array[$automobile_att] = $automobile_att;
				endforeach;
			    }
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_select' : '',
				'extra_att' => 'style="width:50%; display:inline-block;"',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'first_option' => '<option value="">' . automobile_var_theme_text_srt('automobile_var_select_attribute') . '</option>',
				    'options' => isset($automobile_atts_array) ? $automobile_atts_array : '',
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    break;

			case 'select_ftext':

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_select' : '',
				'extra_att' => 'style="width:50%; display:inline-block;"',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'options' => isset($value['options']) ? $value['options'] : '',
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    break;

			case 'default_header':
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_header' : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'extra_atr' => 'onchange="javascript:automobile_var_show_slider(this.value)"',
				    'options' => isset($value['options']) ? $value['options'] : '',
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    break;

			case 'select_sidebar' :

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$select_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$select_value = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_options_markup = '<option value="">' . automobile_var_theme_text_srt('automobile_var_sidebar') . '</option>';

			    if (is_array($value['options']['sidebar']) && sizeof($value['options']['sidebar']) > 0) {
				foreach ($value['options']['sidebar'] as $option) {

				    $key = sanitize_title($option);
				    $selected = '';
				    if ($select_value != '') {
					if ($select_value == $key) {
					    $selected = ' selected="selected"';
					}
				    }
				    $automobile_options_markup .= '<option value="' . $key . '"' . $selected . '>' . $option . '</option>';
				}
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => isset($value['classes']) ? $value['classes'] : '',
				    'return' => true,
				    'options_markup' => true,
				    'options' => $automobile_options_markup,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    break;

			case "checkbox":

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$checked_value = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$checked_value = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_checkbox' : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $checked_value,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => '',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_checkbox_field($automobile_opt_array);

			    break;

			case 'hidden':
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'std' => $val,
				'id' => isset($value['id']) ? $value['id'] : '',
				'classes' => '',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

			    break;

			case 'hidden_field':
			    $val = isset($value['std']) ? $value['std'] : '';
			    $automobile_opt_array = array(
				'std' => $val,
				'id' => isset($value['id']) ? $value['id'] : '',
				'classes' => '',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

			    break;

			case "color":

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }
			    $display = isset($value['display']) ? $value['display'] : 'block';
			    $tab = isset($value['tab']) ? $value['tab'] : '';
			    $output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $display . ';" id="' . $tab . '">';
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_color' : '',
				'field_params' => array(
				    'std' => $val,
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'classes' => 'bg_color',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
			    $output .= '
						</div>
                                        </div>';

			    break;

			case "upload logo":
			    $automobile_var_counter++;

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }
			    $display = isset($value['display']) ? $value['display'] : '';
			    $tab = isset($value['tab']) ? $value['tab'] : '';
			    $output .= '
                                        <div class="main_tab">
                                                <div class="horizontal_tab" style="display:' . $display . '" id="' . $tab . '">';
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => isset($value['id']) ? $value['id'] : '',
				'main_id' => isset($value['mian_id']) ? $value['mian_id'] : '',
				'std' => $val,
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'prefix' => '',
				'field_params' => array(
				    'std' => isset($val) ? $val : '',
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'prefix' => '',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
			    $output .= '
						</div>
                                        </div>';

			    break;

			case "upload font":
			    $automobile_var_counter++;

			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => $automobile_name . '_upload',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
			    );
			    $output .= $automobile_var_html_fields->automobile_var_opening_field($automobile_opt_array);

			    $automobile_opt_array = array(
				'std' => $val,
				'cust_id' => $value['id'],
				'cust_name' => 'automobile_var_' . $value['id'],
				'classes' => 'input-medium',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
			    $output .= '
							<label class="browse-icon">';
			    $automobile_opt_array = array(
				'std' => automobile_var_theme_text_srt('automobile_var_browse'),
				'cust_id' => 'automobile_var_' . $value['id'],
				'cust_name' => $value['id'],
				'cust_type' => 'button',
				'classes' => 'cs-automobile-media left ',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
			    $output .= '
							</label>';
			    $output .= $automobile_var_html_fields->automobile_var_closing_field(array());

			    break;

			case "upload favicon":
			    if (isset($automobile_var_options['automobile_var_' . $value['id']])) {
				$val = $automobile_var_options['automobile_var_' . $value['id']];
			    } else {
				$val = isset($value['std']) ? $value['std'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => isset($value['id']) ? $value['id'] : '',
				'main_id' => isset($value['mian_id']) ? $value['mian_id'] : '',
				'std' => $val,
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'prefix' => '',
				'field_params' => array(
				    'std' => isset($val) ? $val : '',
				    'id' => isset($value['id']) ? $value['id'] : '',
				    'prefix' => '',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);

			    break;

			case "sidebar" :
			    if (isset($automobile_var_options['automobile_var_sidebar']) && is_array($automobile_var_options['automobile_var_sidebar']) && sizeof($automobile_var_options['automobile_var_sidebar']) > 0) {
				//if (is_array($val) && $val != '') {

				   // $val['sidebar'] = $automobile_var_options['automobile_var_sidebar'];
				//}
			    }
			    if (isset($automobile_var_options['automobile_var_sidebar']) && is_array($automobile_var_options['automobile_var_sidebar']) && sizeof($automobile_var_options['automobile_var_sidebar']) > 0) {
				$display = 'block';
			    } else {
				$display = 'none';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_sidebar_name'),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_opening_field($automobile_opt_array);

			    $automobile_opt_array = array(
				'std' => '',
				'cust_id' => 'sidebar_input',
				'cust_name' => 'sidebar_input',
				'classes' => 'input-medium',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);

			    $automobile_opt_array = array(
				'std' => automobile_var_theme_text_srt('automobile_var_add_sidebar'),
				'cust_type' => 'button',
				'cust_id' => 'add_new_sidebar',
				'cust_name' => 'add_new_sidebar',
				'extra_atr' => 'onclick="javascript:add_sidebar()"',
				'return' => true,
			    );
			    $output .= $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
			    $output .= $automobile_var_html_fields->automobile_var_closing_field(array());
			    $output .= '
							<div class="clear"></div>
							<div class="sidebar-area" style="display:' . $display . '">
								<div class="theme-help">
								  <h4 style="padding-bottom:0px;">' . automobile_var_theme_text_srt('automobile_var_already_added_sidebar') . '</h4>
								  <div class="clear"></div>
								</div>
								<div class="boxes">
									<table class="to-table" border="0" cellspacing="0">
									<thead>
										<tr>
											<th>' . automobile_var_theme_text_srt('automobile_var_sidebar_name') . '</th>
											<th class="centr">' . automobile_var_theme_text_srt('automobile_var_actions') . '</th>
										</tr>
									</thead>
									<tbody id="sidebar_area">';
			    if ($display == 'block') {
				$i = 1;
				if (isset($automobile_var_options['automobile_var_sidebar']) && is_array($automobile_var_options['automobile_var_sidebar']) && sizeof($automobile_var_options['automobile_var_sidebar']) > 0) {
				    foreach ($automobile_var_options['automobile_var_sidebar'] as $sidebar) {
					$output .= '<tr id="sidebar_' . $i . '">
							<td>';
                                        $automobile_sidebar_name = automobile_get_sidebar_id($sidebar);
					$automobile_opt_array = array(
					    'std' => $sidebar,
					    'id' => 'sidebar' . $i,
					    'cust_name' => 'automobile_var_sidebar['.$automobile_sidebar_name.']',
					    'return' => true,
					);
					$output .= $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

					$output .= $sidebar . '</td>
													<td class="centr"> <a class="remove-btn" onclick="javascript:return confirm(\'' . automobile_var_theme_text_srt('automobile_var_are_sure') . '\')" href="javascript:automobile_var_div_remove(\'sidebar_' . $i . '\')" data-toggle="tooltip" data-placement="top" title="' . automobile_var_theme_text_srt('automobile_var_remove') . '"><i class="icon-times"></i></a</td>
												</tr>';
					$i++;
				    }
				}
			    }
			    $output .= '
									 </tbody>
									</table>
								</div>
							</div>';
			    break;

			case "automobile_var_footer_sidebar":
			    $val = $value['std'];
			    if (isset($automobile_var_options['automobile_var_footer_sidebar']) and count($automobile_var_options['automobile_var_footer_sidebar']) > 0) {
				$val['automobile_var_footer_sidebar'] = $automobile_var_options['automobile_var_footer_sidebar'];
			    }

			    if (isset($automobile_var_options['automobile_var_footer_width']) and count($automobile_var_options['automobile_var_footer_width']) > 0) {
				$val['automobile_var_footer_width'] = $automobile_var_options['automobile_var_footer_width'];
			    }

			    if (isset($val['automobile_var_footer_sidebar']) and count($val['automobile_var_footer_sidebar']) > 0 and $val['automobile_var_footer_sidebar'] <> '') {
				$display = 'block';
			    } else {
				$display = 'none';
			    }


			    if (isset($val['automobile_var_footer_width']) and count($val['automobile_var_footer_width']) > 0 and $val['automobile_var_footer_width'] <> '') {
				$display = 'block';
			    } else {
				$display = 'none';
			    }

			    $output .= $automobile_var_html_fields->automobile_var_opening_field(array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_footer_sidebar_title'),
				    )
			    );

			    $output .= $automobile_var_form_fields->automobile_var_form_text_render(array(
				'std' => '',
				'cust_id' => "footer_sidebar_input",
				'cust_name' => 'footer_sidebar_input',
				'classes' => 'input-medium',
				'return' => true,
			    ));

			    $output .= $automobile_var_form_fields->automobile_var_form_select_render(array(
				'std' => '',
				'cust_id' => "footer_sidebar_width",
				'cust_name' => 'footer_sidebar_width',
				'classes' => 'select-medium chosen-select',
				'options' =>
				array(
				    '2 Column (16.67%)' => automobile_var_theme_text_srt('automobile_var_2column'),
				    '3 Column (25%)' => automobile_var_theme_text_srt('automobile_var_3column'),
				    '4 Column (33.33%)' => automobile_var_theme_text_srt('automobile_var_4column'),
				    '6 Column (50%)' => automobile_var_theme_text_srt('automobile_var_6column'),
				    '8 Column (66.66%)' => automobile_var_theme_text_srt('automobile_var_8column'),
				    '9 Column (75%)' => automobile_var_theme_text_srt('automobile_var_9column'),
				    '10 Column (83.33%)' => automobile_var_theme_text_srt('automobile_var_10column'),
				    '12 Column (100%)' => automobile_var_theme_text_srt('automobile_var_12column'),
				),
				'return' => true,
			    ));

			    $output .= $automobile_var_form_fields->automobile_var_form_text_render(array(
				'std' => automobile_var_theme_text_srt('automobile_var_add_sidebar'),
				'id' => "add_footer_sidebar",
				'cust_name' => '',
				'cust_type' => 'button',
				'extra_atr' => ' onclick="javascript:add_footer_sidebar()"',
				'return' => true,
			    ));

			    $output .= $automobile_var_html_fields->automobile_var_closing_field(array(
				'desc' => '',
				    )
			    );

			    $output .= '
					<div class="clear"></div>
					<div class="footer_sidebar-area" style="display:' . $display . '">
						<div class="theme-help">
						  <h4 style="padding-bottom:0px;">' . automobile_var_theme_text_srt('automobile_var_already_added_sidebar') . '</h4>
						  <div class="clear"></div>
						</div>
						<div class="boxes">
							<table class="to-table" border="0" cellspacing="0">
							<thead>
								<tr>
									<th>' . automobile_var_theme_text_srt('automobile_var_siderbar_name') . '</th>
									<th>' . automobile_var_theme_text_srt('automobile_var_siderbar_width') . '</th>
									<th class="centr">' . automobile_var_theme_text_srt('automobile_var_actions') . '</th>
								</tr>
							</thead>
							<tbody id="footer_sidebar_area">';
			    if ($display == 'block') {
				$i = 0;

				foreach ($val['automobile_var_footer_sidebar'] as $automobile_var_footer_sidebar) {
				    ?>
				    <script type="text/javascript">
				        var $ = jQuery;
				        $(document).ready(function () {
				            function slideout() {
				                setTimeout(function () {
				                    $("#footer_sidebar_area").slideUp("slow", function () {
				                    });

				                }, 2000);
				            }

				            $(function () {
				                $("#footer_sidebar_area").sortable({opacity: 0.8, cursor: 'move', update: function () {

				                        $("#footer_sidebar_area").html(theResponse);
				                        $("#footer_sidebar_area").slideDown('slow');
				                        slideout();

				                    }
				                });
				            });
				        });
				    </script> 
				    <?php

				    $output .= '<tr id="footer_sidebar_' . $i . '">
							
											<td>';

				    $automobile_footer_sidebar_name = automobile_get_sidebar_id($automobile_var_footer_sidebar);
				    $automobile_footer_sidebar_width = $automobile_var_options['automobile_var_footer_width'][$i];

				    $output .= $automobile_var_form_fields->automobile_var_form_text_render(array(
					'std' => isset($automobile_var_footer_sidebar) ? $automobile_var_footer_sidebar : '',
					'id' => "hide_footer_sidebar" . $i,
					'cust_name' => 'automobile_var_footer_sidebar[]',
					'cust_type' => 'hidden',
					'return' => true,
				    ));

				    $output .= $automobile_var_footer_sidebar;

				    $output .= '<td>';

				    $automobile_footer_sidebar_name = automobile_get_sidebar_id($automobile_var_footer_sidebar);

				    $output .= $automobile_var_form_fields->automobile_var_form_text_render(array(
					'std' => isset($automobile_footer_sidebar_width) ? $automobile_footer_sidebar_width : '',
					'id' => "hide_footer_sidebar_width" . $i,
					'cust_name' => 'automobile_var_footer_width[]',
					'cust_type' => 'hidden',
					'return' => true,
				    ));
				    $output .= absint($automobile_footer_sidebar_width);

				    $output .= '</td>';

				    $output .= '</td> 
											<td class="centr"> <a class="remove-btn" onclick="javascript:return confirm(\'' . automobile_var_theme_text_srt('automobile_var_alert') . '\')" href="javascript:automobile_div_remove(\'footer_sidebar_' . $i . '\')" data-toggle="tooltip" data-placement="top" title="Remove"><i class="icon-times"></i></a>
										</td>
									</tr>';
				    $i++;
				}
			    };
			    $output .= '</tbody>
							</table>
						</div>
					</div>';
			    break;

			case 'select_footer_sidebar':
			    if (isset($automobile_var_options) and $automobile_var_options <> '') {
				if (isset($automobile_var_options[$value['id']])) {
				    $select_value = $automobile_var_options[$value['id']];
				}
			    } else {
				$select_value = $value['std'];
			    }
			    $automobile_single_post_layout = $automobile_var_options['automobile_single_post_layout'];

			    if (isset($automobile_single_post_layout) and $automobile_single_post_layout == 'no_footer_sidebar') {
				$cus_style = ' style="display:none;"';
			    } else {
				$cus_style = ' style="display:block;"';
			    }
			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => $value['id'] . '_header',
				'extra_att' => isset($cus_style) ? $cus_style : '',
				'desc' => $value['desc'],
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'cust_id' => isset($value['id']) ? $value['id'] : '',
				    'cust_name' => isset($value['id']) ? $value['id'] : '',
				    'options' => $value['options']['automobile_var_footer_sidebar'],
				    'return' => true,
				    'classes' => $automobile_classes,
				),
			    );

			    if (isset($value['split']) && $value['split'] <> '') {
				$automobile_opt_array['split'] = $value['split'];
			    }
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

			    break;

			case 'select_footer_sidebar1':

			    if (isset($automobile_var_options) and $automobile_var_options <> '') {
				if (isset($automobile_var_options[$value['id']])) {
				    $select_value = $automobile_var_options[$value['id']];
				}
			    } else {
				$select_value = $value['std'];
			    }
			    $automobile_single_post_layout = $automobile_var_options['automobile_default_page_layout'];

			    if (isset($automobile_single_post_layout) and $automobile_single_post_layout == 'no_footer_sidebar') {
				$cus_style = ' style="display:none;"';
			    } else {
				$cus_style = ' style="display:block;"';
			    }

			    $automobile_opt_array = array(
				'name' => isset($value['name']) ? $value['name'] : '',
				'id' => $value['id'] . '_header',
				'extra_att' => isset($cus_style) ? $cus_style : '',
				'desc' => isset($value['desc']) ? $value['desc'] : '',
				'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
				'field_params' => array(
				    'std' => $select_value,
				    'cust_id' => isset($value['id']) ? $value['id'] : '',
				    'cust_name' => isset($value['id']) ? $value['id'] : '',
				    'classes' => $automobile_classes,
				    'options' => $value['options']['automobile_var_footer_sidebar'],
				    'return' => true,
				),
			    );

			    if (isset($value['split']) && $value['split'] <> '') {
				$automobile_opt_array['split'] = $value['split'];
			    }
			    $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
			    break;

			case "networks" :

			    if (isset($automobile_var_options) && $automobile_var_options <> '') {

				if (!isset($automobile_var_options['automobile_var_social_net_awesome'])) {
				    $network_list = '';
				    $display = 'none';
				} else {
				    $network_list = isset($automobile_var_options['automobile_var_social_net_awesome']) ? $automobile_var_options['automobile_var_social_net_awesome'] : '';
				    $social_net_tooltip = isset($automobile_var_options['automobile_var_social_net_tooltip']) ? $automobile_var_options['automobile_var_social_net_tooltip'] : '';
				    $social_net_icon_path = isset($automobile_var_options['automobile_var_social_icon_path_array']) ? $automobile_var_options['automobile_var_social_icon_path_array'] : '';
				    $social_net_url = isset($automobile_var_options['automobile_var_social_net_url']) ? $automobile_var_options['automobile_var_social_net_url'] : '';
				    $social_font_awesome_color = isset($automobile_var_options['automobile_var_social_icon_color']) ? $automobile_var_options['automobile_var_social_icon_color'] : '';
				    $display = 'block';
				}
			    } else {
				$val = isset($automobile_var_options['options']) ? $value['options'] : '';
				$std = isset($automobile_var_options['id']) ? $value['id'] : '';
				$display = 'block';
				$network_list = isset($automobile_var_options['automobile_var_social_net_awesome']) ? $automobile_var_options['automobile_var_social_net_awesome'] : '';
				$social_net_tooltip = isset($automobile_var_options['automobile_var_social_net_tooltip']) ? $automobile_var_options['automobile_var_social_net_tooltip'] : '';
				$social_net_icon_path = isset($automobile_var_options['automobile_var_social_icon_path_array']) ? $automobile_var_options['automobile_var_social_icon_path_array'] : '';
				$social_net_url = isset($automobile_var_options['automobile_var_social_net_url']) ? $automobile_var_options['automobile_var_social_net_url'] : '';
				$social_font_awesome_color = isset($automobile_var_options['automobile_var_social_icon_color']) ? $automobile_var_options['automobile_var_social_icon_color'] : '';
			    }

			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
				'desc' => '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_text'),
				'field_params' => array(
				    'std' => '',
				    'cust_id' => 'social_net_tooltip_input',
				    'cust_name' => 'social_net_tooltip_input',
				    'classes' => '',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_url_field'),
				'desc' => '',
				'hint_text' => automobile_var_theme_text_srt('automobile_var_url_hint'),
				'field_params' => array(
				    'std' => '',
				    'cust_id' => 'social_net_url_input',
				    'cust_name' => 'social_net_url_input',
				    'classes' => '',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_icon_path'),
				'id' => 'social_icon_input',
				'std' => '',
				'desc' => '',
				'hint_text' => '',
				'prefix' => '',
				'field_params' => array(
				    'std' => '',
				    'id' => 'social_icon_input',
				    'prefix' => '',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);

			    $output .= '
							<div class="form-elements">  
								<div id="automobile_var_infobox_networks' . $counter . '">
								  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<label>' . automobile_var_theme_text_srt('automobile_var_icon') . '</label>
								  </div>
								  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">' . automobile_var_icomoon_icons_box("", "networks" . $counter, 'social_net_awesome_input') . '</div>
								</div>
							</div>';

			    $automobile_opt_array = array(
				'name' => automobile_var_theme_text_srt('automobile_var_icon_color'),
				'desc' => '',
				'hint_text' => '',
				'field_params' => array(
				    'std' => '',
				    'cust_id' => 'social_font_awesome_color',
				    'cust_name' => 'social_font_awesome_color',
				    'classes' => 'bg_color',
				    'return' => true,
				),
			    );
			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

			    $automobile_opt_array = array(
				'name' => '&nbsp;',
				'desc' => '',
				'hint_text' => '',
				'field_params' => array(
				    'std' => automobile_var_theme_text_srt('automobile_var_add'),
				    'id' => 'add_soc_icon',
				    'classes' => '',
				    'cust_type' => 'button',
				    'extra_atr' => 'onclick="javascript:automobile_var_add_social_icon(\'' . admin_url("admin-ajax.php") . '\')"',
				    'return' => true,
				),
			    );

			    $output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

			    $output .= '
							<div class="social-area" style="display:' . $display . '">
							<div class="theme-help">
							  <h4 style="padding-bottom:0px;">' . automobile_var_theme_text_srt('automobile_var_already_added_social_icon') . '</h4>
							  <div class="clear"></div>
							</div>
							<div class="boxes">
							<table class="to-table" border="0" cellspacing="0">
								<thead>
								  <tr>
									<th>' . automobile_var_theme_text_srt('automobile_var_icon_path') . '</th>
									<th>' . automobile_var_theme_text_srt('automobile_var_network_name') . '</th>
									<th>' . automobile_var_theme_text_srt('automobile_var_url_field') . '</th>
									<th class="centr">' . automobile_var_theme_text_srt('automobile_var_actions') . '</th>
								  </tr>
								</thead>
								<tbody id="social_network_area">';
			    $i = 0;
			    if (is_array($network_list)) {
				foreach ($network_list as $network) {
				    if (isset($network_list[$i]) || isset($network_list[$i])) {

					$automobile_rand_num = rand(123456, 987654);
					$output .= '<tr id="del_' . $automobile_rand_num . '"><td>';
					if (isset($network_list[$i]) && !empty($network_list[$i])) {
					    $output .= '<i  class="fa ' . $network_list[$i] . ' icon-2x"></i>';
					} else {
					    $output .= '<img width="50" src="' . esc_url($social_net_icon_path[$i]) . '">';
					}
					$output .= '</td><td>' . $social_net_tooltip[$i] . '</td>';
					$output .= '<td><a href="#">' . $social_net_url[$i] . '</a></td>';
					$output .= '
										  <td class="centr"> 
											<a class="remove-btn" onclick="javascript:return confirm(\'' . automobile_var_theme_text_srt('automobile_var_alert_msg') . '\')" href="javascript:social_icon_del(\'' . $automobile_rand_num . '\')" data-toggle="tooltip" data-placement="top" title="' . automobile_var_theme_text_srt('automobile_var_remove') . '">
											<i class="icon-times"></i></a>
											<a href="javascript:automobile_var_toggle(\'' . absint($automobile_rand_num) . '\')" data-toggle="tooltip" data-placement="top" title="' . automobile_var_theme_text_srt('automobile_var_edit') . '">
											  <i class="icon-edit3"></i>
											</a>
										  </td>
										</tr>';

					$output .= '
										<tr id="' . absint($automobile_rand_num) . '" style="display:none">
										  <td colspan="3">
											<div class="form-elements">
												<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
												<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
													<a class="cs-remove-btn" onclick="automobile_var_toggle(\'' . $automobile_rand_num . '\')"><i class="icon-times"></i></a>
												</div>
											</div>';

					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
					    'desc' => '',
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_text'),
					    'field_params' => array(
						'std' => isset($social_net_tooltip[$i]) ? $social_net_tooltip[$i] : '',
						'cust_id' => 'social_net_tooltip' . $i,
						'cust_name' => 'automobile_var_social_net_tooltip[]',
						'classes' => '',
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_url_field'),
					    'desc' => '',
					    'hint_text' => automobile_var_theme_text_srt('automobile_var_url_hint'),
					    'field_params' => array(
						'std' => isset($social_net_url[$i]) ? $social_net_url[$i] : '',
						'cust_id' => 'social_net_url' . $i,
						'cust_name' => 'automobile_var_social_net_url[]',
						'classes' => '',
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_icon_path'),
					    'id' => 'social_icon_path',
					    'std' => isset($social_net_icon_path[$i]) ? $social_net_icon_path[$i] : '',
					    'desc' => '',
					    'hint_text' => '',
					    'prefix' => '',
					    'array' => true,
					    'field_params' => array(
						'std' => isset($social_net_icon_path[$i]) ? $social_net_icon_path[$i] : '',
						'id' => 'social_icon_path',
						'prefix' => '',
						'array' => true,
						'return' => true,
					    ),
					);

					$output .= $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
					$automobile_var_icon = automobile_var_theme_text_srt('automobile_var_icon');
					$output .= '
											<div class="form-elements">
												<div id="automobile_var_infobox_theme_options' . $i . '">
												  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
													<label>' . $automobile_var_icon . '</label>
												  </div>
												  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
													' . automobile_var_icomoon_icons_box($network_list[$i], "theme_options" . $i, 'automobile_var_social_net_awesome') . '
												  </div>
												</div>
											</div>';

					$automobile_opt_array = array(
					    'name' => automobile_var_theme_text_srt('automobile_var_icon_color'),
					    'desc' => '',
					    'hint_text' => '',
					    'field_params' => array(
						'std' => isset($social_font_awesome_color[$i]) ? $social_font_awesome_color[$i] : '',
						'cust_id' => 'social_font_awesome_color' . $i,
						'cust_name' => 'automobile_var_social_icon_color[]',
						'classes' => 'bg_color',
						'return' => true,
					    ),
					);
					$output .= $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

					$output .= '
										  </td>
										</tr>';
				    }
				    $i++;
				}
			    }

			    $output .= '</tbody></table></div></div>';


			    break;
		    }
		}
	    }

	    return array($output, $menu);
	}

    }

}
