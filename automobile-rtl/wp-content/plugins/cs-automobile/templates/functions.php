<?php
if ( ! function_exists('automobile_set_inventory_view') ) {

	function automobile_set_inventory_view() {
		
		$inv_view = isset($_POST['automobile_inventory_view']) ? $_POST['automobile_inventory_view'] : '';
		$inv_counter = isset($_POST['automobile_counter']) ? $_POST['automobile_counter'] : '';
		
		$_SESSION["automobile_inventory_view_$inv_counter"] = $inv_view;
		die;
	}

	add_action('wp_ajax_automobile_set_inventory_view', 'automobile_set_inventory_view');
	add_action('wp_ajax_nopriv_automobile_set_inventory_view', 'automobile_set_inventory_view');
}

/**
 * Start Function how to Add User Image for Avatar
 */
if ( ! function_exists('automobile_get_user_avatar') ) {

	function automobile_get_user_avatar($size = 0, $automobile_user_id = '') {
		if ( $automobile_user_id != '' ) {
			$automobile_user_avatars = get_the_author_meta('user_avatar_display', $automobile_user_id);

			if ( is_array($automobile_user_avatars) && isset($automobile_user_avatars[$size]) ) {
				return $automobile_user_avatars[$size];
			} else if ( ! is_array($automobile_user_avatars) && $automobile_user_avatars <> '' ) {
				return $automobile_user_avatars;
			}
		}
	}

}
/**
 * Start Function how to get only one Index from two dimenssion array
 */
if ( ! function_exists("array_column_by_two_dimensional") ) {

	function array_column_by_two_dimensional($array, $column_name) {
		if ( isset($array) && is_array($array) ) {
			return array_map(function($element) use($column_name) {
				return $element[$column_name];
			}, $array);
		}
	}

}
/**
 * End Function how to get only one Index from two dimenssion array
 */
/**
 * Start Function how to get inventory Detail
 */
if ( ! function_exists('get_inventory_detail') ) {

	function get_inventory_detail($inventory_id) {
		$post = get_post($inventory_id);
		return $post;
	}

}
/**
 * End Function how to get inventory Detail
 */
/**
 * Start Function how to allow the user for adding special characters
 */
if ( ! function_exists('automobile_var_allow_special_char') ) {

	function automobile_var_allow_special_char($input = '') {
		$output = $input;
		return $output;
	}

}
/**
 * End Function how to allow the user for adding special characters
 */
/**
 * Start Function how to get User Address details
 */
if ( ! function_exists('get_user_address_string_for_detail') ) {

	function get_user_address_string_for_detail($post_id) {
		$inventory_address = '';
		$automobile_var_post_loc_address = get_post_meta($post_id, 'automobile_var_post_loc_address', true);
		$automobile_var_post_loc_country = get_post_meta($post_id, 'automobile_var_post_loc_country', true);
		$selected_spec = get_term_by('slug', $automobile_var_post_loc_country, 'automobile_var_locations');
		$automobile_var_post_loc_country = isset($selected_spec->name) ? $selected_spec->name : '';

		$automobile_var_post_loc_region = get_post_meta($post_id, 'automobile_var_post_loc_region', true);
		$selected_spec = get_term_by('slug', $automobile_var_post_loc_region, 'automobile_var_locations');
		$automobile_var_post_loc_region = isset($selected_spec->name) ? $selected_spec->name : '';

		$automobile_var_post_loc_city = get_post_meta($post_id, 'automobile_var_post_loc_city', true);
		$selected_spec = get_term_by('slug', $automobile_var_post_loc_city, 'automobile_var_locations');
		$automobile_var_post_loc_city = isset($selected_spec->name) ? $selected_spec->name : '';

		if ( $automobile_var_post_loc_address != '' ) {
			$inventory_address .= $automobile_var_post_loc_address . " ";
		}
		if ( $automobile_var_post_loc_city != '' ) {
			$inventory_address .= $automobile_var_post_loc_city . " ";
		}
		if ( $automobile_var_post_loc_region != '' ) {
			$inventory_address .= $automobile_var_post_loc_region . ", ";
		}
		if ( $automobile_var_post_loc_country != '' ) {
			$inventory_address .= $automobile_var_post_loc_country;
		}
		return $inventory_address;
	}

}
/**
 * End Function how to get User Address details
 */
/**
 * Start Function how to add tool tip text without icon only tooltip string
 */
if ( ! function_exists('automobile_tooltip_helptext_string') ) {

	function automobile_tooltip_helptext_string($popover_text = '', $return_html = true, $class = '') {
		$popover_link = '';
		if ( isset($popover_text) && $popover_text != '' ) {
			$popover_link = ' class="cs-help cs ' . $class . '" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="' . $popover_text . '" ';
		}
		if ( $return_html == true ) {
			return $popover_link;
		} else {
			echo $popover_link;
		}
	}

}
/*
 *  End tool tip text assign function
 */


/**
 *
 * @str replace limit
 *
 */
if ( ! function_exists('automobile_str_replace_limit') ) {

	function automobile_str_replace_limit($search, $replace, $string, $limit = 1) {
		if ( is_bool($pos = (strpos($string, $search))) )
			return $string;
		$search_len = strlen($search);
		for ( $i = 0; $i < $limit; $i ++  ) {
			$string = substr_replace($string, $replace, $pos, $search_len);

			if ( is_bool($pos = (strpos($string, $search))) )
				break;
		}
		return $string;
	}

}

if ( ! function_exists('cs_inventory_category_template') ) {

	function cs_inventory_category_template($template = '') {

		$temp_query = get_queried_object();

		if ( is_archive() && isset($temp_query->taxonomy) && $temp_query->taxonomy == 'inventory-make' ) {
			$template = plugin_dir_path(__FILE__) . 'listings/inventory-categories.php';
		}
		return $template;
	}

	add_filter('template_include', 'cs_inventory_category_template');
}

/**
 * Start Function how to Convert  Custom Loaction 
 */
if ( ! function_exists('automobile_location_convert') ) {

	function automobile_location_convert() {
		global $automobile_var_plugin_options;
		$automobile_location_type = isset($automobile_var_plugin_options['automobile_search_by_location']) ? $automobile_var_plugin_options['automobile_search_by_location'] : '';
		$automobile_field_ret = true;
		$selectedkey = '';
		$locations_parent_id = 0;
		$country_args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'fields' => 'all',
			'slug' => '',
			'hide_empty' => false,
			'parent' => $locations_parent_id,
		);
		$automobile_location_countries = get_terms('automobile_locations', $country_args);
		if ( isset($_GET['location']) && $_GET['location'] != '' ) {
			$selectedkey = $_GET['location'];
		}
		if ( $automobile_location_type == 'countries_only' ) {
			if ( isset($automobile_location_countries) && ! empty($automobile_location_countries) ) {
				foreach ( $automobile_location_countries as $key => $country ) {
					$selected = '';
					if ( isset($selectedkey) && $selectedkey == $country->slug ) {
						$automobile_field_ret = false;
					}
				}
			}
		} else if ( $automobile_location_type == 'countries_and_cities' ) {
			if ( isset($automobile_location_countries) && ! empty($automobile_location_countries) ) {
				foreach ( $automobile_location_countries as $key => $country ) {
					$selected = '';
					if ( isset($selectedkey) && $selectedkey == $country->slug ) {
						$automobile_field_ret = false;
					}
					$selected_spec = get_term_by('slug', $country->slug, 'automobile_locations');
					$cities = '';
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
					if ( isset($cities) && $cities != '' && is_array($cities) ) {
						foreach ( $cities as $key => $city ) {
							if ( $selectedkey == $city->slug ) {
								$automobile_field_ret = false;
							}
						}
					}
				}
			}
		} else if ( $automobile_location_type == 'cities_only' ) {

			if ( isset($automobile_location_countries) && ! empty($automobile_location_countries) ) {
				foreach ( $automobile_location_countries as $key => $country ) {
					$selected = '';
					// load all cities against state  
					$cities = '';
					$selected_spec = get_term_by('slug', $country->slug, 'automobile_locations');
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
					if ( isset($cities) && $cities != '' && is_array($cities) ) {
						foreach ( $cities as $key => $city ) {
							if ( $selectedkey == $city->slug ) {
								$automobile_field_ret = false;
							}
						}
					}
				}
			}
		}
		if ( $automobile_field_ret == true && $selectedkey != '' ) {
			return $selectedkey;
		}
		return '';
	}

}
/**
 * End Function how to Convert  Custom Loaction 
 */
/**
 * Start Function how to get Custom Loaction Using Google Info
 */
if ( ! function_exists('automobile_get_custom_locationswith_google_auto') ) {

	function automobile_get_custom_locationswith_google_auto($dropdown_start_html = '', $dropdown_end_html = '', $automobile_text_ret = false, $automobile_top_search = false) {
		global $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text;
		$list_rand = rand(1000000, 49999999);
		$automobile_location_type = isset($automobile_var_plugin_options['automobile_search_by_location']) ? $automobile_var_plugin_options['automobile_search_by_location'] : '';
		ob_start();
		$location_list = '';
		$selectedkey = '';

		$automobile_locatin_cust = '';
		if ( isset($_GET['location']) ) {
			$automobile_locatin_cust = automobile_location_convert();
		}

		if ( isset($_REQUEST['location']) && $_REQUEST['location'] != '' ) {
			$selectedkey = $_REQUEST['location'];
		}
		$automobile_loc_name = '';
		if ( $automobile_locatin_cust == '' ) {
			$automobile_loc_name = ' name=location';
		}
		automobile_google_autocomplete_scripts();
		$output = '';
		$output .= '<div class="automobile_searchbox_div loction-search" data-locationadminurl="' . esc_url(admin_url("admin-ajax.php")) . '">';
		$automobile_var_all_locations = isset($automobile_var_plugin_static_text['automobile_var_all_locations']) ? $automobile_var_plugin_static_text['automobile_var_all_locations'] : '';

		$output .= '<input type="text" value="' . $selectedkey . '" class="automobile_search_location_field" autocomplete="off" placeholder="' . esc_html($automobile_var_all_locations) . '" />';

		$output .= '<input type="hidden" class="search_keyword"' . esc_html($automobile_loc_name) . ' value="' . $selectedkey . '" />';

		$output .= '</div>';

		$data = $output;
		ob_get_clean();
		echo $data;
	}

}
/**
 * End Function how to get Custom Loaction Using Google Info
 */
/**
 *
 * @check array emptiness 
 *
 */
if ( ! function_exists('is_array_empty') ) {

	function is_array_empty($a) {
		foreach ( $a as $elm )
			if ( ! empty($elm) )
				return false;
		return true;
	}

}

/**
 * Start Function how to get Custom Loaction 
 */
if ( ! function_exists('automobile_get_custom_locations') ) {

	function automobile_get_custom_locations($dropdown_start_html = '', $dropdown_end_html = '', $automobile_text_ret = false) {
		global $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text;
		$automobile_location_type = isset($automobile_var_plugin_options['automobile_search_by_location']) ? $automobile_var_plugin_options['automobile_search_by_location'] : '';
		$automobile_var_all_locations = isset($automobile_var_plugin_static_text['automobile_var_all_locations']) ? $automobile_var_plugin_static_text['automobile_var_all_locations'] : '';
		$automobile_var_location = isset($automobile_var_plugin_static_text['automobile_var_location']) ? $automobile_var_plugin_static_text['automobile_var_location'] : '';

		$locations_parent_id = 0;
		$country_args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'fields' => 'all',
			'slug' => '',
			'hide_empty' => false,
			'parent' => $locations_parent_id,
		);
		$automobile_location_countries = get_terms('automobile_locations', $country_args);

		ob_start();
		$location_list = '';
		$selectedkey = '';
		$output = '';
		if ( isset($_REQUEST['location']) && $_REQUEST['location'] != '' ) {
			$selectedkey = $_REQUEST['location'];
		}
		if ( $automobile_location_type == 'countries_only' ) {
			if ( isset($automobile_location_countries) && ! empty($automobile_location_countries) ) {

				foreach ( $automobile_location_countries as $key => $country ) {
					$selected = '';
					if ( isset($selectedkey) && $selectedkey == $country->slug ) {
						$selected = 'selected';
					}
					$location_list .= "<option class=\"item\" " . $selected . "  value='" . $country->slug . "'>" . $country->name . "</option>";
				}
			}
		} else if ( $automobile_location_type == 'countries_and_cities' ) {
			if ( isset($automobile_location_countries) && ! empty($automobile_location_countries) ) {
				foreach ( $automobile_location_countries as $key => $country ) {
					$selected = '';
					if ( isset($selectedkey) && $selectedkey == $country->slug ) {
						$selected = 'selected';
					}
					$location_list .= "<option disabled class=\"category\" " . $selected . "  value='" . $country->slug . "'>" . $country->name . "</option>";
					$selected_spec = get_term_by('slug', $country->slug, 'automobile_locations');
					$cities = '';
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
					if ( isset($cities) && $cities != '' && is_array($cities) ) {
						foreach ( $cities as $key => $city ) {
							$selected = ( $selectedkey == $city->slug) ? 'selected' : '';
							$location_list .= "<option class=\"item\" style=\"padding-left:30px;\" " . $selected . " value='" . $city->slug . "'>" . $city->name . "</option>";
						}
					}
				}
			}
		} else if ( $automobile_location_type == 'cities_only' ) {
			if ( isset($automobile_location_countries) && ! empty($automobile_location_countries) ) {
				foreach ( $automobile_location_countries as $key => $country ) {
					$selected = '';

					$cities = '';
					$selected_spec = get_term_by('slug', $country->slug, 'automobile_locations');
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
					if ( isset($cities) && $cities != '' && is_array($cities) ) {
						foreach ( $cities as $key => $city ) {
							$selected = ( $selectedkey == $city->slug) ? 'selected' : '';
							$location_list .= "<option class=\"item\" " . $selected . " value='" . $city->slug . "'>" . $city->name . "</option>";
						}
					}
				}
			}
		} else if ( $automobile_location_type == 'single_city' ) {
			$location_city = isset($automobile_var_plugin_options['automobile_search_by_location_city']) ? $automobile_var_plugin_options['automobile_search_by_location_city'] : '';
			if ( isset($location_city) && ! empty($location_city) ) {

				$automobile_opt_array = array(
					'std' => $location_city,
					'id' => '',
					'before' => '',
					'after' => '',
					'classes' => '',
					'extra_atr' => '',
					'cust_id' => '',
					'cust_name' => 'location',
					'return' => true,
					'required' => false
				);
				$output .= $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
			}
		}
		if ( $automobile_location_type != 'single_city' ) {
			$output .= force_balance_tags($dropdown_start_html);
			$automobile_locatin_cust = automobile_location_convert();
			$automobile_loc_name = ' name="location"';
			if ( $automobile_locatin_cust != '' && $automobile_text_ret == true ) {
				$automobile_loc_name = '';
			}
			$location_list = '<option value="" class="category">' . esc_html($automobile_var_all_locations) . '</option>' . $location_list;
			$automobile_opt_array = array(
				'cust_id' => 'inventory-search-location',
				'cust_name' => '',
				'std' => $selectedkey,
				'desc' => '',
				'extra_atr' => 'title="' . esc_html($automobile_var_location) . '"' . automobile_allow_special_char($automobile_loc_name) . ' data-placeholder="' . esc_html($automobile_var_all_locations) . '"',
				'classes' => 'dir-map-search single-select search-custom-location chosen-select',
				'options' => $location_list,
				'hint_text' => '',
				'options_markup' => true,
				'return' => true,
			);
			$output .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);

			$output .= force_balance_tags($dropdown_end_html);
			echo force_balance_tags($output);
		}
		$post_data = ob_get_clean();
		echo force_balance_tags($post_data);
	}

}
/**
 * End Function how to get Custom Loaction 
 */
/**
 * Start Function how to User Pagination 
 */
if ( ! function_exists('automobile_user_pagination') ) {

	function automobile_user_pagination($total_pages = 1, $page = 1, $shortcode_paging = 'page_id_all') {

		$query_string = $_SERVER['QUERY_STRING'];
		$base = get_permalink() . '?' . remove_query_arg($shortcode_paging, $query_string) . '%_%';

		$automobile_pagination = paginate_links(array(
			'base' => @add_query_arg($shortcode_paging, '%#%'),
			'format' => '&' . $shortcode_paging . '=%#%', // this defines the query parameter that will be used, in this case "p"
			'prev_text' => '<i class="icon-angle-left"></i>', // text for previous page
			'next_text' => '<i class="icon-angle-right"></i>', // text for next page
			'total' => $total_pages, // the total number of pages we have
			'current' => $page, // the current page
			'end_size' => 1,
			'mid_size' => 2,
			'type' => 'array',
		));
		$automobile_pages = '';
		if ( is_array($automobile_pagination) && sizeof($automobile_pagination) > 0 ) {
			$automobile_pages .= '<div class="nav-links">';
			foreach ( $automobile_pagination as $automobile_link ) {
				if ( strpos($automobile_link, 'current') !== false ) {
					$automobile_pages .= '<span class="page-numbers current">' . preg_replace("/[^0-9]/", "", $automobile_link) . '</span>';
				} else {
					$automobile_pages .= '' . $automobile_link . '';
				}
			}
			$automobile_pages .= '</div>';
		}
		echo force_balance_tags($automobile_pages);
	}

}
/**
 * End Function how to get Image Thumbnail 
 
if ( ! function_exists('automobile_get_image_thumb') ) {

	function automobile_get_image_thumb($image = '', $size = '') {
		if ( $image != '' ) {
			$image_url = $image;
			$link_array = explode('/', $image_url);
			$image_name = end($link_array);
			$image_name_explode = explode('.', $image_name);
			$image_name_no_extention = $image_name_explode[0];
			$automobile_img_sizes = array(
				'automobile_var_media_1' => '-775x436', // Blog Large, Blog Detail(16 x 9)
				'automobile_var_media_2' => '-290x218', // Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed Listing On Agents (270 x 203 (4 x 3)
				'automobile_var_media_3' => '-350x197', // Blog Grid(16 x 9)
				'automobile_var_media_4' => '-514x517', // Car Listing Detail(Custom)
				'automobile_var_media_5' => '-400x400', // Shop Detail, Released Models (360 x 360 )
				'automobile_var_media_6' => '-120x68', // Agents Listing( 16 x 9)
					// Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
			);
			if ( $size != '' ) {
				if ( array_key_exists($size, $automobile_img_sizes) ) {
					$thumb_size = $automobile_img_sizes[$size];
					$new_image_name = $image_name_no_extention . $thumb_size;
					$complete_url = str_replace($image_name_no_extention, $new_image_name, $image_url);
					return $complete_url;
				}
			}
		}
	}

}*/
/**
 * Start Function how to Author Role 
 */
if ( ! function_exists('automobile_author_role_template') ) {

	function automobile_author_role_template($author_template = '') {
		$author = get_queried_object();
		$role = $author->roles[0];
		if ( $role == 'automobile_dealer' ) {
			$author_template = plugin_dir_path(__FILE__) . 'single-pages/dealer/cs-single.php';
		}

		return $author_template;
	}

	add_filter('author_template', 'automobile_author_role_template');
}

/**
 * Start Function User Avatar 
 */
if ( ! function_exists('automobile_user_avatar') ) {

	function automobile_user_avatar($Fieldname = 'media_upload') {
		$img_resized_name = '';
		// Register our new path for user images.
		add_filter('upload_dir', 'automobile_user_images_custom_directory');

		if ( is_user_logged_in() && isset($_FILES[$Fieldname]) && $_FILES[$Fieldname] != '' ) {

			$json = array();
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
			$automobile_allowed_image_types = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'png' => 'image/png',
				'gif' => 'image/gif',
			);
			$status = wp_handle_upload($_FILES[$Fieldname], array( 'test_form' => false, 'mimes' => $automobile_allowed_image_types ));
			if ( empty($status['error']) ) {

				$image = wp_get_image_editor($status['file']);

				$automobile_sizes_array = array(
					'775x436' => '775x436',
					'290x218' => '290x218',
					'350x197' => '350x197',
					'514x517' => '514x517',
					'400x400' => '400x400',
					'120x68' => '120x68',
				);

				if ( ! is_wp_error($image) ) {
					$sizes_array = array(
						array( 'width' => 775, 'height' => 436, 'crop' => true ),
						array( 'width' => 290, 'height' => 218, 'crop' => true ),
						array( 'width' => 350, 'height' => 197, 'crop' => true ),
						array( 'width' => 514, 'height' => 517, 'crop' => true ),
						array( 'width' => 400, 'height' => 400, 'crop' => true ),
						array( 'width' => 120, 'height' => 68, 'crop' => true ),
					);
					$resize = $image->multi_resize($sizes_array, true);
				}
				
				if ( is_wp_error($image) ) {
					echo '<span class="error-msg">' . $image->get_error_message() . '</span>';
				} else {

					$wp_upload_dir = wp_upload_dir();

					$img_resized_name = $img_resized_name1 = '';
					if ( $img_resized_name == '' && isset($resize[1]['width']) && in_array($resize[1]['width'] . 'x' . $resize[1]['height'], $automobile_sizes_array) ) {
						$img_resized_name = isset($resize[1]['file']) ? basename($resize[1]['file']) : '';
						$img_resized_name1 = isset($resize[1]['file']) ? basename($resize[1]['file']) : '';
					}
					if ( $img_resized_name == '' && isset($resize[2]['width']) && in_array($resize[2]['width'] . 'x' . $resize[2]['height'], $automobile_sizes_array) ) {
						$img_resized_name = isset($resize[2]['file']) ? basename($resize[2]['file']) : '';
					}
					if ( $img_resized_name == '' && isset($resize[3]['width']) && in_array($resize[3]['width'] . 'x' . $resize[3]['height'], $automobile_sizes_array) ) {
						$img_resized_name = isset($resize[3]['file']) ? basename($resize[3]['file']) : '';
					}
					if ( $img_resized_name == '' && isset($resize[4]['width']) && in_array($resize[4]['width'] . 'x' . $resize[4]['height'], $automobile_sizes_array) ) {
						$img_resized_name = isset($resize[4]['file']) ? basename($resize[4]['file']) : '';
					}
					if ( $img_resized_name == '' && isset($resize[5]['width']) && in_array($resize[5]['width'] . 'x' . $resize[5]['height'], $automobile_sizes_array) ) {
						$img_resized_name = isset($resize[5]['file']) ? basename($resize[5]['file']) : '';
					}
					if ( $img_resized_name == '' && isset($resize[6]['width']) && in_array($resize[6]['width'] . 'x' . $resize[6]['height'], $automobile_sizes_array) ) {
						$img_resized_name = isset($resize[6]['file']) ? basename($resize[6]['file']) : '';
					}
					//$img_resized_name = $_FILES[$Fieldname]['name'];
					
					$filename = $img_resized_name;
					$filename = $wp_upload_dir['url'] . '/' . basename( $filename );
					$filetype = wp_check_filetype(basename($filename), null);
					if ( $filename != '' ) {
						// Prepare an array of post data for the attachment.
						$attachment = array(
							'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
							'post_mime_type' => $filetype['type'],
							'post_title' => preg_replace('/\.[^.]+$/', '', basename( $filename ) ),
							'post_content' => '',
							'post_status' => 'inherit'
						);
						
						// Insert the attachment.
						$attach_id = wp_insert_attachment($attachment, $filename);

						// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
						require_once( ABSPATH . 'wp-admin/includes/image.php' );
						
						
						// Generate the metadata for the attachment, and update the database record.
						
						$attach_data = wp_generate_attachment_metadata($attach_id, $filename);
						
						wp_update_attachment_metadata($attach_id, $attach_data);
					}
				}

				//$uploads = wp_upload_dir();
				//$img_resized_name = isset($resize[0]['file']) ? basename($resize[0]['file']) : '';
			} else {
				$img_resized_name = '';
			}

			//remove_filter('upload_dir', 'automobile_cust_upload_dir');
		}
		// Set everything back to normal.
		remove_filter('upload_dir', 'automobile_user_images_custom_directory');
		
		return $img_resized_name;
	}

}

/**
 * Start Function how to decode gallery serialize array
 */
if ( ! function_exists('user_gallery_decoder') ) {

	function user_gallery_decoder($gallery_array) {
		$count = 0;
		if ( is_array($gallery_array) && ! empty($gallery_array) ) {
			foreach ( $gallery_array as $value ) {
				//Decode String 
				$old_array_value = rawurldecode($value);
				//unserialize String to Array
				$old_array_value = unserialize($old_array_value);
				//Create New Array
				$gallery[$count]['id'] = $old_array_value['id'];
				$gallery[$count]['url'] = $old_array_value['url'];
				$count ++;
			}
			//Remove Ertra Index
			$gallery = array_map('array_filter', $gallery);
			$gallery = array_filter($gallery);
			//Re-arrange Array Indexing  
			$gallery = array_values($gallery);
			return $gallery;
			//End
		}
	}

}
/**
 * Start Function how to get gallery crop images
 */
if ( ! function_exists('get_user_gallery_crop_image_url') ) {

	function get_user_gallery_crop_image_url($url) {

		$file_parts = pathinfo($url);
		switch ( $file_parts['extension'] ) {
			case "jpg":
				$image_url = str_replace(".jpg", "-290x218.jpg", $url);
				break;

			case "png":
				$image_url = str_replace(".png", "-290x218.png", $url);
				break;

			default:
				$image_url = '';
				break;
		}
		return $image_url;
	}

}

/**
 * Start Function User Gallery Multiple 
 */
if ( ! function_exists('user_gallery_multiple') ) {

	function user_gallery_multiple($Fieldname = 'media_upload') {
		$img_resized_name = '';
		$user_gallery = array();
		$count = 0;

		// Register our new path for user images.
		//add_filter('upload_dir', 'automobile_user_images_custom_directory');

		if ( is_user_logged_in() && isset($_FILES[$Fieldname]) && $_FILES[$Fieldname] != '' ) {

			$multi_files = isset($_FILES[$Fieldname]) ? $_FILES[$Fieldname] : '';

			if ( isset($multi_files['name']) && is_array($multi_files['name']) ) {
				$img_name_array = array();
				foreach ( $multi_files['name'] as $multi_key => $multi_value ) {
					if ( $multi_files['name'][$multi_key] ) {
						$loop_file = array(
							'name' => $multi_files['name'][$multi_key],
							'type' => $multi_files['type'][$multi_key],
							'tmp_name' => $multi_files['tmp_name'][$multi_key],
							'error' => $multi_files['error'][$multi_key],
							'size' => $multi_files['size'][$multi_key]
						);

						$json = array();
						require_once ABSPATH . 'wp-admin/includes/image.php';
						require_once ABSPATH . 'wp-admin/includes/file.php';
						require_once ABSPATH . 'wp-admin/includes/media.php';
						$automobile_allowed_image_types = array(
							'jpg|jpeg|jpe' => 'image/jpeg',
							'png' => 'image/png',
							'gif' => 'image/gif',
						);

						$status = wp_handle_upload($loop_file, array( 'test_form' => false, 'mimes' => $automobile_allowed_image_types ));

						if ( empty($status['error']) ) {

							$image = wp_get_image_editor($status['file']);
							$img_resized_name = $status['file'];

							if ( ! is_wp_error($image) ) {
								$sizes_array = array(
									array( 'width' => 775, 'height' => 436, 'crop' => true ), // Blog Large, Blog Detail(16 x 9)
									array( 'width' => 290, 'height' => 218, 'crop' => true ), // Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed Listing On Agents (270 x 203 (4 x 3)
									array( 'width' => 350, 'height' => 197, 'crop' => true ), // Blog Grid(16 x 9)
									array( 'width' => 514, 'height' => 517, 'crop' => true ), // Car Listing Detail(Custom)
									array( 'width' => 400, 'height' => 400, 'crop' => true ), // Shop Detail, Released Models (360 x 360 )
									array( 'width' => 120, 'height' => 68, 'crop' => true ), // Agents Listing( 16 x 9)
										//   Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
								);
								$resize = $image->multi_resize($sizes_array, true);
							}

							if ( is_wp_error($image) ) {

								echo '<span class="error-msg">' . $image->get_error_message() . '</span>';
							} else {
								$wp_upload_dir = wp_upload_dir();
								$img_name_array[] = isset($status['url']) ? $status['url'] : '';
								$filename = $img_name_array[$count];
								$filetype = wp_check_filetype(basename($filename), null);

								if ( $filename != '' ) {
									// Prepare an array of post data for the attachment.

									$attachment = array(
										'guid' => ($filename),
										'post_mime_type' => $filetype['type'],
										'post_title' => preg_replace('/\.[^.]+$/', '', ($loop_file['name'])),
										'post_content' => '',
										'post_status' => 'inherit'
									);
									require_once( ABSPATH . 'wp-admin/includes/image.php' );
									// Insert the attachment.
									$attach_id = wp_insert_attachment($attachment, $status['file']);
									// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
									$attach_data = wp_generate_attachment_metadata($attach_id, $status['file']);
									wp_update_attachment_metadata($attach_id, $attach_data);
									$user_gallery[$count]['id'] = $attach_id;
									$user_gallery[$count]['url'] = $filename;
									$count ++;
								}
							}
						}
					}
				}

				$img_resized_name = $user_gallery;
			} else {
				$img_resized_name = '';
			}
		}
		// Set everything back to normal.
		// remove_filter('upload_dir', 'automobile_user_images_custom_directory');
		return $img_resized_name;
	}

}


/**
 * inventory gallery
 */
if ( ! function_exists('automobile_inventory_gallery_multiple') ) {

	function automobile_inventory_gallery_multiple($Fieldname = 'media_upload') {
		$img_resized_name = '';
		// Register our new path for user images.
		//add_filter('upload_dir', 'automobile_user_images_custom_directory');

		if ( is_user_logged_in() && isset($_FILES[$Fieldname]) && $_FILES[$Fieldname] != '' ) {

			$multi_files = isset($_FILES[$Fieldname]) ? $_FILES[$Fieldname] : '';
			if ( isset($multi_files['name']) && is_array($multi_files['name']) ) {
				$img_name_array = array();
				foreach ( $multi_files['name'] as $multi_key => $multi_value ) {
					if ( $multi_files['name'][$multi_key] ) {
						$loop_file = array(
							'name' => $multi_files['name'][$multi_key],
							'type' => $multi_files['type'][$multi_key],
							'tmp_name' => $multi_files['tmp_name'][$multi_key],
							'error' => $multi_files['error'][$multi_key],
							'size' => $multi_files['size'][$multi_key]
						);

						$json = array();
						require_once ABSPATH . 'wp-admin/includes/image.php';
						require_once ABSPATH . 'wp-admin/includes/file.php';
						require_once ABSPATH . 'wp-admin/includes/media.php';
						$automobile_allowed_image_types = array(
							'jpg|jpeg|jpe' => 'image/jpeg',
							'png' => 'image/png',
							'gif' => 'image/gif',
						);
						$status = wp_handle_upload($loop_file, array( 'test_form' => false, 'mimes' => $automobile_allowed_image_types ));
						if ( empty($status['error']) ) {

							$image = wp_get_image_editor($status['file']);

							if ( ! is_wp_error($image) ) {
								$sizes_array = array(
									array( 'width' => 775, 'height' => 436, 'crop' => true ), // Blog Large, Blog Detail(16 x 9)
									array( 'width' => 290, 'height' => 218, 'crop' => true ), // Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed Listing On Agents (270 x 203 (4 x 3)
									array( 'width' => 350, 'height' => 197, 'crop' => true ), // Blog Grid(16 x 9)
									array( 'width' => 514, 'height' => 517, 'crop' => true ), // Car Listing Detail(Custom)
									array( 'width' => 400, 'height' => 400, 'crop' => true ), // Shop Detail, Released Models (360 x 360 )
									array( 'width' => 120, 'height' => 68, 'crop' => true ), // Agents Listing( 16 x 9)
										//   Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
								);
								$resize = $image->multi_resize($sizes_array, true);
							}

							if ( is_wp_error($image) ) {
								echo '<span class="error-msg">' . $image->get_error_message() . '</span>';
							} else {

								$wp_upload_dir = wp_upload_dir();
								$img_name_array[] = isset($status['url']) ? $status['url'] : '';
								$filename = $img_resized_name;
								$filetype = wp_check_filetype(basename($filename), null);
								if ( $filename != '' ) {
									// Prepare an array of post data for the attachment.
									$attachment = array(
										'guid' => $wp_upload_dir['url'] . '/' . ($filename),
										'post_mime_type' => $filetype['type'],
										'post_title' => preg_replace('/\.[^.]+$/', '', ($filename)),
										'post_content' => '',
										'post_status' => 'inherit'
									);

									// Insert the attachment.
									$attach_id = wp_insert_attachment($attachment, $filename);

									// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
									require_once( ABSPATH . 'wp-admin/includes/image.php' );

									// Generate the metadata for the attachment, and update the database record.
									$attach_data = wp_generate_attachment_metadata($attach_id, $filename);
									wp_update_attachment_metadata($attach_id, $attach_data);
								}
							}
						}
					}
				}

				$img_resized_name = $img_name_array;
				//$uploads = wp_upload_dir();
				//$img_resized_name = isset($resize[0]['file']) ? basename($resize[0]['file']) : '';
			} else {
				$img_resized_name = '';
			}

			//remove_filter('upload_dir', 'automobile_cust_upload_dir');
		}
		// Set everything back to normal.

		return $img_resized_name;
	}

}
/**
 * End inventory gallery
 */
/**
 * Start Function how to Set Post Views
 */
if ( ! function_exists('automobile_set_post_views') ) {

	function automobile_set_post_views($postID) {
		if ( ! isset($_COOKIE["automobile_count_views" . $postID]) ) {
			setcookie("automobile_count_views" . $postID, 'post_view_count', time() + 86400);
			$count_key = 'automobile_count_views';
			$count = get_post_meta($postID, $count_key, true);
			if ( $count == '' ) {
				$count = 0;
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
			} else {
				$count ++;
				update_post_meta($postID, $count_key, $count);
			}
		}
	}

}
/**
 * End Function how to Set Post Views
 */
/**
 * Start Function how to  get image
 */
if ( ! function_exists('automobile_get_orignal_image_nam') ) {

	function automobile_get_orignal_image_nam($img_name = '', $size = 'automobile_var_media_2') {
		$ret_name = '';
		$automobile_img_sizes = array(
			'automobile_var_media_1' => '-775x436', // Blog Large, Blog Detail(16 x 9)
			'automobile_var_media_2' => '-290x218', // Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed Listing On Agents (270 x 203 (4 x 3)
			'automobile_var_media_3' => '-350x197', // Blog Grid(16 x 9)
			'automobile_var_media_4' => '-514x517', // Car Listing Detail(Custom)
			'automobile_var_media_5' => '-400x400', // Shop Detail, Released Models (360 x 360 )
			'automobile_var_media_6' => '-120x68', // Agents Listing( 16 x 9)
				//   Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
		);



		if ( (strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false) ) {
			if ( strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) + strlen($automobile_img_sizes['automobile_var_media_1'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_1']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) + strlen($automobile_img_sizes['automobile_var_media_2'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_2']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) + strlen($automobile_img_sizes['automobile_var_media_3'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_3']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) + strlen($automobile_img_sizes['automobile_var_media_4'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_4']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) + strlen($automobile_img_sizes['automobile_var_media_5'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_5']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) + strlen($automobile_img_sizes['automobile_var_media_6'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_6']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) + strlen($automobile_img_sizes['automobile_var_media_6'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_6']));
			}
			$automobile_upload_dir = isset($automobile_upload_dir['url']) ? $automobile_upload_dir['url'] . '/' : '';
			if ( $ret_name != '' ) {
				if ( isset($automobile_img_sizes[$size]) ) {
					$ret_name = $automobile_upload_dir . $ret_name . $automobile_img_sizes[$size] . $img_ext;
				} else {
					$ret_name = $automobile_upload_dir . $ret_name . $img_ext;
				}
			}
		} else {
			if ( $img_name != '' ) {
				//$ret_name = $automobile_upload_dir . $img_name;
				$ret_name = '';
			}
		}

		return $ret_name;
	}

}

/**
 * Start Function how to Remove Extra Variables using Query String
 */
if ( ! function_exists('automobile_remove_qrystr_extra_var') ) {

	function automobile_remove_qrystr_extra_var($qStr, $key, $withqury_start = 'yes') {

		$qr_str = preg_replace('/[?&]' . $key . '=[^&]+$|([?&])' . $key . '=[^&]+&/', '$1', $qStr);
		if ( ! (strpos($qr_str, '?') !== false) ) {
			$qr_str = "?" . $qr_str;
		}
		$qr_str = str_replace("?&", "?", $qr_str);
		$qr_str = remove_dupplicate_var_val($qr_str);

		if ( $withqury_start == 'no' ) {
			$qr_str = str_replace("?", "", $qr_str);
		}
		return $qr_str;
		die();
	}

}
/**
 * End Function how to Remove Extra Variables using Query String
 */
/**
 * Start Function how to remove Dupplicate variable value
 */
if ( ! function_exists('remove_dupplicate_var_val') ) {

	function remove_dupplicate_var_val($qry_str) {
		$old_string = $qry_str;
		$qStr = str_replace("?", "", $qry_str);
		$query = explode('&', $qStr);
		$params = array();
		if ( isset($query) && ! empty($query) ) {
			foreach ( $query as $param ) {
				if ( ! empty($param) ) {
					$param_array = explode('=', $param);
					$name = isset($param_array[0]) ? $param_array[0] : '';
					$value = isset($param_array[1]) ? $param_array[1] : '';
					$new_str = $name . "=" . $value;
					// count matches
					$count_str = substr_count($old_string, $new_str);
					$count_str = $count_str - 1;
					if ( $count_str > 0 ) {
						$old_string = automobile_str_replace_limit($new_str, "", $old_string, $count_str);
					}
					$old_string = str_replace("&&", "&", $old_string);
				}
			}
		}
		$old_string = str_replace("?&", "?", $old_string);
		return $old_string;
	}

}
/*
 * start information messages
 */
if ( ! function_exists('automobile_info_messages_listing') ) {

	function automobile_info_messages_listing($message = 'There is no record in list', $return = true, $classes = '', $before = '', $after = '') {
		global $post;
		$output = '';
		$class_str = '';
		if ( $classes != '' ) {
			$class_str .= ' class="' . $classes . '"';
		}
		$before_str = '';
		if ( $before != '' ) {
			$before_str .= $before;
		}
		$after_str = '';
		if ( $after != '' ) {
			$after_str .= $after;
		}
		$output .= $before_str;
		$output .= '<span' . $class_str . '>';
		$output .= $message;
		$output .= '</span>';
		$output .= $after_str;
		if ( $return == true ) {
			return force_balance_tags($output);
		} else {
			echo force_balance_tags($output);
		}
	}

}
/*
 * end information messages
 */

/**
 * Start Function how to get Multiple Parameters
 */
if ( ! function_exists('getMultipleParameters') ) {

	function getMultipleParameters($query_string = '') {
		if ( $query_string == '' )
			$query_string = $_SERVER['QUERY_STRING'];
		$params = explode('&', $query_string);
		foreach ( $params as $param ) {
			$k = $param;
			$v = '';
			if ( strpos($param, '=') ) {
				list($name, $value) = explode('=', $param);
				$k = rawurldecode($name);
				$v = rawurldecode($value);
			}
			if ( isset($query[$k]) ) {
				if ( is_array($query[$k]) ) {
					$query[$k][] = $v;
				} else {
					$query[$k][] = array( $query[$k], $v );
				}
			} else {
				$query[$k][] = $v;
			}
		}
		return $query;
	}

}
/**
 * Start Function how to get image
 */
if ( ! function_exists('automobile_get_image_url') ) {

	function automobile_get_image_url($img_name = '', $size = 'automobile_var_media_2', $return_sizes = false) {
		$ret_name = '';
		$automobile_img_sizes = array(
			'automobile_var_media_1' => '-775x436', // Blog Large, Blog Detail(16 x 9)
			'automobile_var_media_2' => '-290x218', // Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed Listing On Agents (270 x 203 (4 x 3)
			'automobile_var_media_3' => '-350x197', // Blog Grid(16 x 9)
			'automobile_var_media_4' => '-514x517', // Car Listing Detail(Custom)
			'automobile_var_media_5' => '-400x400', // Shop Detail, Released Models (360 x 360 )
			'automobile_var_media_6' => '-120x68', // Agents Listing( 16 x 9)
				//   Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
		);
		if ( $return_sizes == true ) {
			return $automobile_img_sizes;
		}
		add_filter('upload_dir', 'automobile_user_images_custom_directory');
		$automobile_upload_dir = wp_upload_dir();
		$automobile_upload_sub_dir = '';

		if ( (strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false) ) {
			if ( strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) + strlen($automobile_img_sizes['automobile_var_media_1'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_1']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) + strlen($automobile_img_sizes['automobile_var_media_2'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_2']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) + strlen($automobile_img_sizes['automobile_var_media_3'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_3']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) + strlen($automobile_img_sizes['automobile_var_media_4'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_4']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) + strlen($automobile_img_sizes['automobile_var_media_5'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_5']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) + strlen($automobile_img_sizes['automobile_var_media_6'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_6']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) + strlen($automobile_img_sizes['automobile_var_media_6'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_6']));
			}
			$automobile_upload_dir = isset($automobile_upload_dir['url']) ? $automobile_upload_dir['url'] . '/' : '';
			$automobile_upload_dir = $automobile_upload_dir . $automobile_upload_sub_dir;
			if ( $ret_name != '' ) {
				if ( isset($automobile_img_sizes[$size]) ) {
					$ret_name = $automobile_upload_dir . $ret_name . $automobile_img_sizes[$size] . $img_ext;
				} else {
					$ret_name = $automobile_upload_dir . $ret_name . $img_ext;
				}
			}
		} else {
			if ( $img_name != '' ) {
				//$ret_name = $automobile_upload_dir . $img_name;
				$ret_name = '';
			}
		}
		// Set everything back to normal.
		remove_filter('upload_dir', 'automobile_user_images_custom_directory');
		return $ret_name;
	}

}
/**
 * Start Function how to get Login User Role 
 */
if ( ! function_exists('automobile_get_loginuser_role') ) :

	function automobile_get_loginuser_role() {
		global $current_user;
		$automobile_user_role = '';
		if ( is_user_logged_in() ) {
			wp_get_current_user();
			$user_roles = isset($current_user->roles) ? $current_user->roles : '';
			$automobile_user_role = 'other';
			if ( ($user_roles != '' && in_array("automobile_dealer", $user_roles) ) ) {
				$automobile_user_role = 'automobile_dealer';
			} elseif ( ($user_roles != '' && in_array("automobile_candidate", $user_roles) ) ) {
				$automobile_user_role = 'automobile_candidate';
			}
		}
		return $automobile_user_role;
	}

endif;

/**
 * Start Function how to get Profile Top Menu 
 */
if ( ! function_exists('automobile_profiletop_menu') ) {

	function automobile_profiletop_menu($action = '', $uid = '') {
		global $post, $automobile_var_plugin_options, $current_user, $wp_roles, $userdata, $automobile_var_plugin_static_text;
		$automobile_var_general_setting = isset($automobile_var_plugin_static_text['automobile_var_general_setting']) ? $automobile_var_plugin_static_text['automobile_var_general_setting'] : '';
		$automobile_var_posted_cars = isset($automobile_var_plugin_static_text['automobile_var_posted_cars']) ? $automobile_var_plugin_static_text['automobile_var_posted_cars'] : '';
		$automobile_var_post_new_car = isset($automobile_var_plugin_static_text['automobile_var_post_new_car']) ? $automobile_var_plugin_static_text['automobile_var_post_new_car'] : '';
		$automobile_var_shortlisted = isset($automobile_var_plugin_static_text['automobile_var_shortlisted']) ? $automobile_var_plugin_static_text['automobile_var_shortlisted'] : '';
		$automobile_var_payment = isset($automobile_var_plugin_static_text['automobile_var_payment']) ? $automobile_var_plugin_static_text['automobile_var_payment'] : '';
		$automobile_var_packages = isset($automobile_var_plugin_static_text['automobile_var_packages']) ? $automobile_var_plugin_static_text['automobile_var_packages'] : '';
		$automobile_var_logout = isset($automobile_var_plugin_static_text['automobile_var_logout']) ? $automobile_var_plugin_static_text['automobile_var_logout'] : '';
		$uid = (isset($uid) and $uid <> '') ? $uid : $current_user->ID;
		$user_display_name = get_the_author_meta('display_name', $uid);
		//print_r($automobile_var_plugin_options);
		$automobile_page_id = isset($automobile_theme_options['automobile_dashboard']) ? $automobile_theme_options['automobile_dashboard'] : '';
		$automobile_candidate_switch = isset($automobile_var_plugin_options['automobile_candidate_switch']) ? $automobile_var_plugin_options['automobile_candidate_switch'] : '';
		$dealer_dashboard = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : '';
		$url_dealer_dashboard = home_url();
		if ( $dealer_dashboard != '' ) {
			$url_dealer_dashboard = get_permalink($dealer_dashboard);
		}
		$user_role = automobile_get_loginuser_role();
		$automobile_profile_img_name = '';
		$automobile_user_role_type = '';
		if ( isset($user_role) && $user_role <> '' && $user_role == 'automobile_dealer' ) {
			$automobile_user_role_type = 'dealer';
			$automobile_page_id = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : '';
			$automobile_profile_img_name = get_the_author_meta('user_img', $uid);
		}
		$automobile_user_role_type = 'dealer';
		$automobile_loc_country = get_the_author_meta('automobile_post_loc_country', $uid);
		$automobile_loc_city = get_the_author_meta('automobile_post_loc_city', $uid);
		$menu_cls = $data_toogle = '';
		if ( $automobile_page_id == get_the_ID() ) {
			$menu_cls = 'nav nav-tabs';
			$data_toogle = '';
		}
		$automobile_profile_image = '';
		?>
		<div class="cs-login">

			<div class="cs-login-dropdown">
				<?php ?>
				<a class="navicon-button x dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="icon-user2"></i>
					<?php
					if ( $user_display_name != '' ) {
						echo $user_display_name;
					}
					?>

				</a>


				<div class="cs-user-dropdown">
					<?php
					$automobile_page_id = 288;
					if ( $automobile_page_id != '' && $automobile_user_role_type != '' ) {
						if ( $automobile_user_role_type == 'dealer' ) {
							$args = array(
								'author' => get_current_user_id(),
								'ignore_sticky_posts' => 1,
								'post_type' => 'inventory',
								'posts_per_page' => -1,
								'post_status' => 'publish',
							);
							$totl_posts = get_posts($args);
							$count_inventory_post = count($totl_posts);
							?>
							<ul>

								<li>  <a href="<?php echo esc_url($url_dealer_dashboard) . '?profile_tab=user-genral-setting'; ?>" <?php echo force_balance_tags($data_toogle); ?>><i class="icon-user9"></i> <?php echo esc_html($automobile_var_general_setting); ?></a></li>
								<li><a href="<?php echo esc_url($url_dealer_dashboard) . '?profile_tab=user-car-listing'; ?>"><?php echo esc_html($automobile_var_posted_cars); ?><span class="cs-bgcolor"><?php echo $count_inventory_post; ?></span></a></li>
								<li><a href="<?php echo esc_url($url_dealer_dashboard) . '?profile_tab=user-post-vehicle'; ?>"><?php echo esc_html($automobile_var_post_new_car); ?></a></li>
								<li><a href="<?php echo esc_url($url_dealer_dashboard) . '?profile_tab=user-car-shortlist'; ?>"><?php echo esc_html($automobile_var_shortlisted); ?></a></li>
								<li><a href="<?php echo esc_url($url_dealer_dashboard) . '?profile_tab=transactions'; ?>"><?php echo esc_html($automobile_var_payment); ?></a></li>
								<li><a href="<?php echo esc_url($url_dealer_dashboard) . '?profile_tab=packages'; ?>"><?php echo esc_html($automobile_var_packages); ?></a></li>
								<li><a href="javascript:void(0)" onclick="cs_remove_profile('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($uid) ?>', 'dealer')"><?php esc_html_e('Delete Profile', 'cs-automobile'); ?></a></li>
							</ul>
							<a href="<?php echo esc_url(wp_logout_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>" class="btn-sign-out"><i class="icon-logout"></i><?php echo esc_html($automobile_var_logout); ?></a>
							<?php
						}
					} else {
						?>
						<ul class="dropdown-menu <?php echo esc_html($menu_cls); ?>">
							<li>
								<h5><?php echo esc_html($user_display_name) ?></h5>
								<?php
								if ( is_user_logged_in() ) {
									?>
									<a class="logout-btn" href="<?php echo esc_url(wp_logout_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>" class="btn-sign-out"><i class="icon-logout"></i></a>
									<?php
								}
								?>
							</li>
						</ul>
					<?php }
					?>                    
				</div>

			</div>

		</div>
		<?php
	}

}
/**
 *
 * @site header login plugin
 *

  if (!function_exists('automobile_site_header_login_plugin')) {

  add_filter('wp_nav_menu_items', 'automobile_site_header_login_plugin', 10, 10);

  function automobile_site_header_login_plugin($items, $args) {
  global $automobile_var_plugin_options;


  //if (isset($automobile_var_plugin_options['automobile_user_dashboard_switchs']) && $automobile_var_plugin_options['automobile_user_dashboard_switchs'] == 'on') {
  //if ($args->theme_location == 'primary') {
  echo '<li class="cs-user-option">';
  //    echo do_shortcode('[automobile_user_login register_role="contributor"] [/automobile_user_login]');
  //echo do_shortcode('[automobile_register register_role="contributor"] [/automobile_register]');
  echo '</li>';
  //}
  // }

  return $items;
  }

  }
 */
/**
 * Start Function how to get User Address for listing
 */
if ( ! function_exists('get_user_address_string_for_list') ) {

	function get_user_address_string_for_list($post_id, $type = 'post') {
		$complete_address = '';


		if ( $type == 'post' ) {
			$automobile_post_loc_address = get_post_meta($post_id, 'automobile_post_loc_address', true);
			$automobile_post_loc_country = get_post_meta($post_id, 'automobile_post_loc_country', true);
			$selected_spec = get_term_by('slug', $automobile_post_loc_country, 'automobile_locations');
			$automobile_post_loc_country = isset($selected_spec->name) ? $selected_spec->name : '';

			$automobile_post_loc_region = get_post_meta($post_id, 'automobile_post_loc_region', true);
			$selected_spec = get_term_by('slug', $automobile_post_loc_region, 'automobile_locations');
			$automobile_post_loc_region = isset($selected_spec->name) ? $selected_spec->name : '';

			$automobile_post_loc_city = get_post_meta($post_id, 'automobile_post_loc_city', true);


			$automobile_post_loc_city = isset($selected_spec->name) ? $selected_spec->name : '';
		} else {
			$automobile_post_loc_address = get_the_author_meta('automobile_post_loc_address', $post_id);
			$automobile_post_loc_country = get_the_author_meta('automobile_post_loc_country', $post_id);


			$selected_spec = get_term_by('slug', $automobile_post_loc_country, 'automobile_locations');
			$automobile_post_loc_country = isset($selected_spec->name) ? $selected_spec->name : '';
			$automobile_post_loc_region = get_the_author_meta('automobile_post_loc_region', $post_id);
			$selected_spec = get_term_by('slug', $automobile_post_loc_region, 'automobile_locations');
			$automobile_post_loc_region = isset($selected_spec->name) ? $selected_spec->name : '';

			$automobile_post_loc_city = get_the_author_meta('automobile_post_loc_city', $post_id);
			$selected_spec = get_term_by('slug', $automobile_post_loc_city, 'automobile_locations');
			$automobile_post_loc_city = isset($selected_spec->name) ? $selected_spec->name : '';
		}



		$complete_address = $automobile_post_loc_city != '' ? $automobile_post_loc_city . ', ' : '';
		$complete_address .= $automobile_post_loc_country != '' ? $automobile_post_loc_country . ' ' : '';

		return $complete_address;
	}

}
/**
 * End Function how to get User Address for listing
 */
if ( ! function_exists('automobile_save_img_url') ) {

	function automobile_save_img_url($img_url = '') {
		if ( $img_url != '' ) {
			$img_id = automobile_get_attachment_id_from_url($img_url);
			$img_url = wp_get_attachment_image_src($img_id, 'automobile_var_media_6');

			if ( isset($img_url[0]) ) {
				$img_url = $img_url[0];
				if ( strpos($img_url, 'uploads/') !== false ) {
					$img_url = substr($img_url, ( strpos($img_url, 'uploads/') + strlen('uploads/')), strlen($img_url));
				}
			}
		}
		return $img_url;
	}

}


if ( ! function_exists('automobile_get_attachment_id_from_url') ) {

	function automobile_get_attachment_id_from_url($attachment_url = '') {
		global $wpdb;
		$attachment_id = false;
		// If there is no url, return.
		if ( '' == $attachment_url )
			return;
		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();
		if ( false !== strpos($attachment_url, $upload_dir_paths['baseurl']) ) {
			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
			// Remove the upload path base directory from the attachment URL
			$attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

			$attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
		}
		return $attachment_id;
	}
}

if ( ! function_exists('automobile_get_user_attachment_url_from_name') ) {

	function automobile_get_user_attachment_url_from_name( $image_name = '' ) {
		global $wpdb;
		$attachment_url = false;
		// If there is no url, return.
		if ( '' == $image_name )
			return;
		// Get the upload directory paths
		add_filter('upload_dir', 'automobile_user_images_custom_directory');
		$upload_dir_paths = wp_upload_dir();
		$upload_dir_path = $upload_dir_paths['url'];
		$attachment_url = $upload_dir_paths['url'] .'/'. $image_name;
		if ( false !== strpos($attachment_url, $upload_dir_path) ) {
			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
		}
		remove_filter('upload_dir', 'automobile_user_images_custom_directory');
		return $attachment_url;
	}
}

if ( ! function_exists('automobile_get_user_attachment_id_from_name') ) {

	function automobile_get_user_attachment_id_from_name( $image_name = '' ) {
		global $wpdb;
		$attachment_id = false;
		// If there is no url, return.
		if ( '' == $image_name )
			return;
		// Get the upload directory paths
		add_filter('upload_dir', 'automobile_user_images_custom_directory');
		$upload_dir_paths = wp_upload_dir();
		$upload_dir_path = $upload_dir_paths['url'];
		$attachment_url = $upload_dir_paths['url'] .'/'. $image_name;
		if ( false !== strpos($attachment_url, $upload_dir_path) ) {
			$attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
		}
		remove_filter('upload_dir', 'automobile_user_images_custom_directory');
		return $attachment_id;
	}
}

/**
 * Start Function how to check if Image Exists
 */

if ( ! function_exists('automobile_image_exist') ) {

	function automobile_image_exist($sFilePath) {

		$img_formats = array( "png", "jpg", "jpeg", "gif", "tiff" ); //Etc. . . 
		$path_info = pathinfo($sFilePath);
		if ( isset($path_info['extension']) && in_array(strtolower($path_info['extension']), $img_formats) ) {
			if ( ! filter_var($sFilePath, FILTER_VALIDATE_URL) === false ) {
				$automobile_file_response = wp_remote_get($sFilePath);
				if ( is_array($automobile_file_response) && isset($automobile_file_response['headers']['content-type']) && strpos($automobile_file_response['headers']['content-type'], 'image') !== false ) {
					return true;
				}
			}
		}
		return false;
	}

}



if ( ! function_exists('automobile_remove_img_url') ) {

	function automobile_remove_img_url($img_url = '') {
		$automobile_upload_dir = wp_upload_dir();
		$automobile_upload_dir = isset($automobile_upload_dir['basedir']) ? $automobile_upload_dir['basedir'] . '/' : '';
		if ( $img_url != '' ) {
			$automobile_img_sizes = automobile_get_img_url('', '', true);
			if ( isset($automobile_img_sizes['automobile_var_media_2']) && strpos($img_url, $automobile_img_sizes['automobile_var_media_2']) !== false ) {
				$img_ext = substr($img_url, ( strpos($img_url, $automobile_img_sizes['automobile_var_media_2']) + strlen($automobile_img_sizes['automobile_var_media_2'])), strlen($img_url));
				$img_name = substr($img_url, 0, strpos($img_url, $automobile_img_sizes['automobile_var_media_2']));
				if ( is_file($automobile_upload_dir . $img_name . $img_ext) ) {

					unlink($automobile_upload_dir . $img_name . $img_ext);
				}
				if ( is_array($automobile_img_sizes) ) {
					foreach ( $automobile_img_sizes as $automobile_key => $automobile_size ) {
						if ( is_file($automobile_upload_dir . $img_name . $automobile_size . $img_ext) ) {

							unlink($automobile_upload_dir . $img_name . $automobile_size . $img_ext);
						}
					}
				}
			} else {
				if ( is_file($automobile_upload_dir . $img_url) ) {

					unlink($automobile_upload_dir . $img_url);
				}
			}
		}
	}

}

/**
 * Start Function how to Add images sizes and their URL's 
 */
if ( ! function_exists('automobile_user_images_custom_directory') ) {

	function automobile_user_images_custom_directory($dir) {
		global $plugin_user_images_directory;
		return array(
			'path' => $dir['basedir'] . '/' . $plugin_user_images_directory,
			'url' => $dir['baseurl'] . '/' . $plugin_user_images_directory,
			'subdir' => '/' . $plugin_user_images_directory,
				) + $dir;
	}

}
if ( ! function_exists('automobile_tooltip_helptext') ) {

	function automobile_tooltip_helptext($popover_text = '', $return_html = true) {
		$popover_link = '';
		if ( isset($popover_text) && $popover_text != '' ) {
			$popover_link = '<a class="cs-help cs" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="' . $popover_text . '"><i class="icon-help"></i></a>';
		}
		if ( $return_html == true ) {
			return $popover_link;
		} else {
			echo $popover_link;
		}
	}

}

if ( ! function_exists('automobile_get_img_url') ) {

	function automobile_get_img_url($img_name = '', $size = 'automobile_var_media_6', $return_sizes = false) {
		$ret_name = '';
		$automobile_img_sizes = array(
			'automobile_var_media_1' => '775x436', // Blog Large, Blog Detail(16 x 9)
			'automobile_var_media_2' => '290x218', // Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed Listing On Agents (270 x 203 (4 x 3)
			'automobile_var_media_3' => '350x197', // Blog Grid(16 x 9)
			'automobile_var_media_4' => '514x517', // Car Listing Detail(Custom)
			'automobile_var_media_5' => '400x400', // Shop Detail, Released Models (360 x 360 )
			'automobile_var_media_6' => '120x68', // Agents Listing( 16 x 9)
				//   Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
		);
		if ( $return_sizes == true ) {
			return $automobile_img_sizes;
		}
		// Register our new path for user images.
		add_filter('upload_dir', 'automobile_user_images_custom_directory');
		$automobile_upload_dir = wp_upload_dir();
		$automobile_upload_sub_dir = '';

		if ( (strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false) || (strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false) ) {
			if ( strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_1']) + strlen($automobile_img_sizes['automobile_var_media_1'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_1']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_2']) + strlen($automobile_img_sizes['automobile_var_media_2'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_2']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_3']) + strlen($automobile_img_sizes['automobile_var_media_3'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_3']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_4']) + strlen($automobile_img_sizes['automobile_var_media_4'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_4']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_5']) + strlen($automobile_img_sizes['automobile_var_media_5'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_5']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) + strlen($automobile_img_sizes['automobile_var_media_6'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_6']));
			} elseif ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) !== false ) {
				$img_ext = substr($img_name, ( strpos($img_name, $automobile_img_sizes['automobile_var_media_6']) + strlen($automobile_img_sizes['automobile_var_media_6'])), strlen($img_name));
				$ret_name = substr($img_name, 0, strpos($img_name, $automobile_img_sizes['automobile_var_media_6']));
			}
			//echo $ret_name;
			$automobile_upload_dir = isset($automobile_upload_dir['url']) ? $automobile_upload_dir['url'] . '/' : '';
			$automobile_upload_dir = $automobile_upload_dir . $automobile_upload_sub_dir;
			
			if ( $ret_name != '' ) {
				if ( isset($automobile_img_sizes[$size]) ) {
					$ret_name = $automobile_upload_dir . $ret_name . $automobile_img_sizes[$size] . $img_ext;
				} else {
					$ret_name = $automobile_upload_dir . $ret_name . $img_ext;
				}
			}
		} else {
			if ( $img_name != '' ) {
				//$ret_name = $automobile_upload_dir . $img_name;
				$ret_name = '';
			}
		}
		// Set everything back to normal.
		remove_filter('upload_dir', 'automobile_user_images_custom_directory');
		return $ret_name;
	}

}
/**
 * get require images size by image URL 
 */
if ( ! function_exists('automobile_get_image_thumb') ) {

	function automobile_get_image_thumb($image = '', $size = '') {
		if ( $image != '' ) {
			$image_url = $image;
			$link_array = explode('/', $image_url);
			$image_name = end($link_array);
			$image_name_explode = explode('.', $image_name);
			$image_name_no_extention = $image_name_explode[0];
			$automobile_img_sizes = array(
				'automobile_var_media_1' => '775x436', // Blog Large, Blog Detail(16 x 9)
				'automobile_var_media_2' => '290x218', // Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed Listing On Agents (270 x 203 (4 x 3)
				'automobile_var_media_3' => '350x197', // Blog Grid(16 x 9)
				'automobile_var_media_4' => '514x517', // Car Listing Detail(Custom)
				'automobile_var_media_5' => '400x400', // Shop Detail, Released Models (360 x 360 )
				'automobile_var_media_6' => '120x68', // Agents Listing( 16 x 9)
					//   Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
			);
			if ( $size != '' ) {
				if ( array_key_exists($size, $automobile_img_sizes) ) {
					$thumb_size = $automobile_img_sizes[$size];
					$new_image_name = $image_name_no_extention . $thumb_size;
					$complete_url = str_replace($image_name_no_extention, $new_image_name, $image_url);
					if(automobile_image_exist($complete_url)) {
						return $complete_url;
					}else{
						return $image;
					}
				}
			}
		}
	}

}
if ( ! function_exists('automobile_server_protocol') ) {

	function automobile_server_protocol() {
		if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ) {
			return 'https://';
		}
		return 'http://';
	}

}
/*
 * *
 * Start Function how to Count User Meta 
 */
if ( ! function_exists('count_usermeta') ) {

	function count_usermeta($key, $value, $opr, $return = false) {
		$arg = array(
			'meta_key' => $key,
			'meta_value' => $value,
			'meta_compare' => $opr,
		);
		$users = get_users($arg);

		if ( $return == true ) {
			return $users;
		}
		return count($users);
	}

}
/**
 * End Function how to Count User Meta 
 */
/** Start Function how to Add specialisms  in Dropdown  
 */
if ( ! function_exists('get_dealer_type_dropdown') ) {

	function get_dealer_type_dropdown($name, $id, $user_id = '', $class = '', $required_status = 'false') {
		global $automobile_form_fields, $post, $automobile_var_plugin_static_text;
		$automobile_var_select_dealer_type = isset($automobile_var_plugin_static_text['automobile_var_select_dealer_type']) ? $automobile_var_plugin_static_text['automobile_var_select_dealer_type'] : '';
		$automobile_var_no_dealer = isset($automobile_var_plugin_static_text['automobile_var_no_dealer']) ? $automobile_var_plugin_static_text['automobile_var_no_dealer'] : '';
		$output = '';

		$automobile_spec_args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'fields' => 'all',
			'slug' => '',
			'hide_empty' => false,
		);
		$terms = get_terms('dealer_type', $automobile_spec_args);


		if ( ! empty($terms) && is_array($terms) ) {

			$automobile_selected_dealer = get_user_meta($user_id, $name, true);
			$dealer_option = '';
			foreach ( $terms as $term ) {
				$automobile_selected = '';
				if ( is_array($automobile_selected_dealer) && in_array($term->slug, $automobile_selected_dealer) ) {
					$automobile_selected = ' selected="selected"';
				}
				$dealer_option .= '<option' . $automobile_selected . ' value="' . esc_attr($term->slug) . '">' . $term->name . '</option>';
			}
			$automobile_opt_array = array(
				'cust_id' => $id,
				'cust_name' => $name . '[]',
				'std' => '',
				'desc' => '',
				'return' => true,
				'extra_atr' => 'data-placeholder="' . $automobile_var_select_dealer_type . '"',
				'classes' => $class,
				'options' => $dealer_option,
				'options_markup' => true,
				'hint_text' => '',
			);

			if ( isset($required_status) && $required_status == true ) {
				$automobile_opt_array['required'] = 'yes';
			}
			$output .= $automobile_form_fields->automobile_form_multiselect_render($automobile_opt_array);
		} else {
			$output .= $automobile_var_no_dealer;
		}
		return $output;
	}

}

/**
 * Start function to get user profile link
 */
if ( ! function_exists('automobile_users_profile_link') ) {

	function automobile_users_profile_link($page_id = '', $profile_page = '', $uid = '') {
		if ( ! isset($page_id) or $page_id == '' ) {
			$user_link = home_url('/') . '?author=' . $uid;
		} else {
			$user_link = get_permalink($page_id) . '?profile_tab=' . $profile_page;
		}
		return esc_url($user_link);
	}

}
/**
 * Start Function how to user logout
 */
if ( ! function_exists('automobile_user_logout') ) {

	function automobile_user_logout($action = '', $uid = '') {
		global $automobile_var_plugin_static_text;
		$automobile_var_logout = isset($automobile_var_plugin_static_text['automobile_var_logout']) ? $automobile_var_plugin_static_text['automobile_var_logout'] : '';
		if ( is_user_logged_in() ) {
			echo '<a  href="' . esc_url(wp_logout_url("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) . '" class="btn-sign-out"><i class="icon-logout"></i>' . $automobile_var_logout . '</a>';
		}
	}

}

/**
 * Start Function Map
 */
if ( ! function_exists('automobile_var_map') ) {

	function automobile_var_map($atts, $content = "") {
		global $author;
		$automobile_user_data = get_userdata($author);
		automobile_set_post_views($automobile_user_data->ID);

		$defaults = array(
			'column_size' => '1/1',
			'automobile_map_section_title' => '',
			'map_title' => '',
			'map_height' => '',
			'map_lat' => '',
			'map_lon' => '',
			'map_zoom' => '',
			'map_type' => '',
			'map_info' => '',
			'map_info_width' => '200',
			'map_info_height' => '200',
			'map_marker_icon' => '',
			'map_show_marker' => 'true',
			'map_controls' => '',
			'map_draggable' => '',
			'map_scrollwheel' => '',
			'map_conactus_content' => '',
			'map_border' => '',
			'map_border_color' => '',
			'automobile_map_style' => '',
			'automobile_map_class' => '',
			'automobile_map_directions' => 'off'
		);
		extract(shortcode_atts($defaults, $atts));



		if ( $map_info_width == '' || $map_info_height == '' ) {
			$map_info_width = '300';
			$map_info_height = '150';
		}

		if ( isset($map_height) && $map_height == '' ) {
			$map_height = '500';
		}
		$map_dynmaic_no = rand(6548, 9999999);
		if ( $map_show_marker == "true" ) {
			$map_show_marker = " var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '',
                        icon: '" . $map_marker_icon . "',
                        shadow: ''
                    });
            ";
		} else {
			$map_show_marker = "var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '',
                        icon: '',
                        shadow: ''
                    });";
		}
		$border = '';
		if ( isset($map_border) && $map_border == 'yes' && $map_border_color != '' ) {
			$border = 'border:1px solid ' . $map_border_color . '; ';
		}

		$map_type = isset($map_type) ? $map_type : '';
		$map_dynmaic_no = automobile_generate_random_string('10');
		$html = '';
		$html .= '<div  class="' . $automobile_map_class . ' " style="animation-duration:">';
		$html .= '<div class="clear"></div>';
		$html .= '<div class="cs-map-section" style="' . $border . ';">';
		$html .= '<div class="cs-map">';
		$html .= '<div class="cs-map-content">';

		$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas' . $map_dynmaic_no . '" style="height:' . $map_height . 'px;"> </div>';


		$html .= '</div>';
		$html .= '</div>';
		$html .= "<script type='text/javascript'>
                    jQuery(window).on(load,function (){
						'use strict';
                        setTimeout(function(){
                        jQuery('.cs-map-" . $map_dynmaic_no . "').animate({
                            'height':'" . $map_height . "'
                        },400)
                        },400)
                    })
		    var panorama;
                    function initialize() {
                    var myLatlng = new google.maps.LatLng(" . $map_lat . ", " . $map_lon . ");
                    var mapOptions = {
                        zoom: " . $map_zoom . ",
                        scrollwheel: " . $map_scrollwheel . ",
                        draggable: " . $map_draggable . ",
                        streetViewControl: false,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId." . $map_type . ",
                        disableDefaultUI: " . $map_controls . ",
                        };";


		$html .= "var map = new google.maps.Map(document.getElementById('map_canvas" . $map_dynmaic_no . "'), mapOptions);";


		$html .= "
                        var styles = '';
                        if(styles != ''){
                            var styledMap = new google.maps.StyledMapType(styles, {name: 'Styled Map'});
                            map.mapTypes.set('map_style', styledMap);
                            map.setMapTypeId('map_style');
                        }
                        var infowindow = new google.maps.InfoWindow({
                            content: '" . $map_info . "',
                            maxWidth: " . $map_info_width . ",
                            maxHeight: " . $map_info_height . ",
                            
                        });
                        " . $map_show_marker . "
                        //google.maps.event.addListener(marker, 'click', function() {
                            if (infowindow.content != ''){
                              infowindow.open(map, marker);
                               map.panBy(1,-60);
                               google.maps.event.addListener(marker, 'click', function(event) {
                                infowindow.open(map, marker);
                               });
                            }
                        //});
                            panorama = map.getStreetView();
                            panorama.setPosition(myLatlng);
                            panorama.setPov(({
                              heading: 265,
                              pitch: 0
                            }));

                    }
					
                        function automobile_toggle_street_view(btn) {
                          var toggle = panorama.getVisible();
                          if (toggle == false) {
                                if(btn == 'streetview'){
                                  panorama.setVisible(true);
                                }
                          } else {
                                if(btn == 'mapview'){
                                  panorama.setVisible(false);
                                }
                          }
                        }

                google.maps.event.addDomListener(window, 'load', initialize);
                </script>";

		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}

}

/**
 * Start Function how to Get Current User ID
 */
if ( ! function_exists('automobile_get_user_id') ) {

	function automobile_get_user_id() {
		global $current_user;
		wp_get_current_user();
		return $current_user->ID;
	}

}
/**
 * Start Function how to Find Other Fields User Meta List
 */
if ( ! function_exists('automobile_find_other_field_user_meta_list') ) {

	function automobile_find_other_field_user_meta_list($post_id, $post_column, $list_name, $need_find, $user_id) {
		$finded = automobile_find_index_user_meta_list($post_id, $list_name, $post_column, $user_id);
		$index = '';
		$need_find_value = '';
		if ( isset($finded[0]) ) {
			$index = $finded[0];
			$existing_list_data = get_user_meta($user_id, $list_name, true);
			$need_find_value = $existing_list_data[$index][$need_find];
		}
		return $need_find_value;
	}

}
/**
 * End Function how to Find Other Fields User Meta List
 */
/**
 * Start Function how to Find Index User Meta List
 */
if ( ! function_exists('automobile_find_index_user_meta_list') ) {

	function automobile_find_index_user_meta_list($post_id, $list_name, $need_find, $user_id) {
		$existing_list_data = get_user_meta($user_id, $list_name, true);
		//$finded = in_multiarray($post_id, $existing_list_data, $need_find);
                $finded = isset($existing_list_data[$post_id])? $existing_list_data[$post_id] : array();
		return $finded;
	}

}/**
 * Start Function how to find Index
 */
if ( ! function_exists('in_multiarray') ) {

	function in_multiarray($elem, $array, $field) {
		$top = is_array($array) && sizeof($array) - 1;
		$bottom = 0;
		$finded_index = array();
		if ( is_array($array) ) {
			while ( $bottom <= $top ) {
				if ( $array[$bottom][$field] == $elem )
					$finded_index[] = $bottom;
				else
				if ( is_array($array[$bottom][$field]) )
					if ( in_multiarray($elem, ($array[$bottom][$field])) )
						$finded_index[] = $bottom;
				$bottom ++;
			}
		}
		return $finded_index;
	}

}
/**
 * Start Function how to remove given Indexes
 */
if ( ! function_exists('remove_index_from_array') ) {

	function remove_index_from_array($array, $index_array) {
                $index_array    = is_array($index_array)? $index_array : array();
		$top = sizeof($index_array) - 1;
		$bottom = 0;
		if ( is_array($index_array) ) {
			while ( $bottom <= $top ) {
				unset($array[$index_array[$bottom]]);
				$bottom ++;
			}
		}
		if ( ! empty($array) )
			return array_values($array);
		else
			return $array;
	}

}
/**
 * Start Function how to Create  User Meta List
 */
if ( ! function_exists('automobile_var_create_user_meta_list') ) {

	function automobile_var_create_user_meta_list($post_id, $list_name, $user_id) {
		$current_timestamp = strtotime(date('d-m-Y H:i:s'));
		$existing_list_data = array();
		$existing_list_data = get_user_meta($user_id, $list_name, true);
		// search duplicat and remove it then arrange new ordering
		//$finded = in_multiarray($post_id, $existing_list_data, 'post_id');
                $existing_list_data = is_array($existing_list_data)? $existing_list_data : array();
		// adding one more entry
		$existing_list_data[$post_id] = array( 'post_id' => $post_id, 'date_time' => $current_timestamp );
		update_user_meta($user_id, $list_name, $existing_list_data);
	}

}
if ( ! function_exists('automobile_var_addinventory_to_user') ) {

	function automobile_var_addinventory_to_user() {
		$user = automobile_get_user_id();
		if ( isset($user) && $user <> '' ) {
			if ( isset($_POST['post_id']) && $_POST['post_id'] <> '' ) {
				automobile_var_create_user_meta_list($_POST['post_id'], 'cs-user-inventory-wishlist', $user);
				if ( isset($_POST['view']) && $_POST['view'] != 'view2' && $_POST['view'] != 'view3' ) { ?>
				<i class="icon-heart"></i>
				<?php } ?>
				<?php _e('Shortlisted', 'inventory'); ?>
				<?php
			}
		} else {
			_e('You have to login first.', 'inventory');
		}
		die();
	}

	add_action("wp_ajax_automobile_var_addinventory_to_user", "automobile_var_addinventory_to_user");
	add_action("wp_ajax_nopriv_automobile_var_addinventory_to_user", "automobile_var_addinventory_to_user");
}
/**
 * End Function how to remove Inventory User
 */
/**
 * Start Function how to Remove List From User Meta List
 */
if ( ! function_exists('automobile_var_remove_from_user_meta_list') ) {

	function automobile_var_remove_from_user_meta_list($post_id, $list_name, $user_id) {
		$existing_list_data = '';
		$existing_list_data = get_user_meta($user_id, $list_name, true);
		if( isset( $existing_list_data[$post_id] ) ){
                    unset( $existing_list_data[$post_id] );
                }
		update_user_meta($user_id, $list_name, $existing_list_data);
	}

}
/**
 * Start Function how to Remove List From User Meta List Ajax function
 */
if ( ! function_exists('automobile_var_removeinventory_to_user') ) {

	function automobile_var_removeinventory_to_user() {
		$user = automobile_get_user_id();
		if ( isset($user) && $user <> '' ) {
			if ( isset($_POST['post_id']) && $_POST['post_id'] <> '' ) {
				automobile_var_remove_from_user_meta_list($_POST['post_id'], 'cs-user-inventory-wishlist', $user);
				if ( isset($_POST['view']) && $_POST['view'] != 'view2' && $_POST['view'] != 'view3' ) {
					echo '<i class="icon-heart-o"></i> ';
				}
				_e('Shortlist', 'inventoryhunt');
			} else {
				_e('You are not authorised', 'inventory');
			}
		} else {
			_e('You have to login first.', 'inventory');
		}

		die();
	}

	add_action("wp_ajax_automobile_var_removeinventory_to_user", "automobile_var_removeinventory_to_user");
	add_action("wp_ajax_nopriv_automobile_var_removeinventory_to_user", "automobile_var_removeinventory_to_user");
}

/**
 * Start Function change author links
 */
if ( ! function_exists('change_author_permalinks') ) {

	function change_author_permalinks() {
		global $wp_rewrite, $automobile_var_plugin_options;
		$author_slug = isset($automobile_var_plugin_options['automobile_author_page_slug']) ? $automobile_var_plugin_options['automobile_author_page_slug'] : 'user';
		// Change the value of the author permalink base to whatever you want here
		$wp_rewrite->author_base = $author_slug;
		$wp_rewrite->flush_rules();
	}

	add_action('init', 'change_author_permalinks');
}

/**
 * Start Function users query variables 
 */
if ( ! function_exists('users_query_vars') ) {
	add_filter('query_vars', 'users_query_vars');

	function users_query_vars($vars) {
		global $automobile_var_plugin_options;
		// add lid to the valid list of variables
		$author_slug = isset($automobile_var_plugin_options['automobile_author_page_slug']) ? $automobile_var_plugin_options['automobile_author_page_slug'] : 'user';
		$new_vars = array( $author_slug );
		$vars = $new_vars + $vars;
		return $vars;
	}

}

/**
 * Start user re-write rule add in .htaccess 
 */
if ( ! function_exists('user_rewrite_rules') ) {

	function user_rewrite_rules($wp_rewrite) {
		global $automobile_var_plugin_options;
		$author_slug = isset($automobile_var_plugin_options['automobile_author_page_slug']) ? $automobile_var_plugin_options['automobile_author_page_slug'] : 'user';
		$newrules = array();
		$new_rules[$author_slug . '/(\d*)$'] = 'index.php?author=$matches[1]';
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}

	add_filter('generate_rewrite_rules', 'user_rewrite_rules');
}
/**
 * @Allow Special Characters
 *
 */
if ( ! function_exists('automobile_var_special_char') ) {

	function automobile_var_special_char($input = '') {
		$output = $input;
		return $output;
	}

}


/**
 * Start Function  how to upload User image(Avatar)
 */
if ( ! function_exists( 'automobile_import_user_profile_images' ) ) {

    function automobile_import_user_profile_images( $fieldname_url = '', $fieldname_orignal = '' ) {
        $img_resized_name = '';
		add_filter('upload_dir', 'automobile_user_images_custom_directory');
        if ( is_user_logged_in() && isset( $fieldname_url ) && $fieldname_url != '' ) {
            $cs_allowed_image_types = array(
                'jpg|jpeg|jpe' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            );
            $image = wp_get_image_editor( $fieldname_url );
            if ( ! is_wp_error( $image ) ) {
                $sizes_array = array(
                    array( 'width' => 270, 'height' => 203, 'crop' => true ),
                    array( 'width' => 236, 'height' => 168, 'crop' => true ),
                    array( 'width' => 200, 'height' => 200, 'crop' => true ),
                    array( 'width' => 180, 'height' => 135, 'crop' => true ),
                    array( 'width' => 150, 'height' => 113, 'crop' => true ),
                );
                $resize = $image->multi_resize( $sizes_array, true );
            }

            if ( is_wp_error( $image ) ) {
                
            } else {
                $wp_upload_dir = wp_upload_dir();
                $img_resized_name = isset( $fieldname_orignal ) ? basename( $fieldname_orignal ) : '';
                $filename = $img_resized_name;
				$filename = $wp_upload_dir['url'] . '/' . basename( $filename );
                $filetype = wp_check_filetype( basename( $filename ), null );
                if ( $filename != '' ) {
                    // Prepare an array of post data for the attachment.
                    $attachment = array(
                        'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
                        'post_mime_type' => $filetype['type'],
                        'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );

                    // Insert the attachment.
                    $attach_id = wp_insert_attachment( $attachment, $filename );
                    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );

                    // Generate the metadata for the attachment, and update the database record.
                    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
                    wp_update_attachment_metadata( $attach_id, $attach_data );
                }
            }
        }
		remove_filter('upload_dir', 'automobile_user_images_custom_directory');
        return $img_resized_name;
    }
}
/**

 * Start Function how to get all Countries and Cities Function

 */
if ( ! function_exists( 'automobile_get_all_countries_cities' ) ) {



	function automobile_get_all_countries_cities() {

		global $automobile_var_plugin_options;

		$automobile_location_type = isset( $automobile_var_plugin_options['automobile_search_by_location'] ) ? $automobile_var_plugin_options['automobile_search_by_location'] : '';

		$location_name = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '';

		$locations_parent_id = 0;
		
		$country_args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'fields' => 'all',
			'slug' => '',
			'hide_empty' => false,
			'parent' => $locations_parent_id,
		);

		$automobile_location_countries = get_terms( 'automobile_locations', $country_args );

		$location_list = '';

		$selectedkey = '';

		if ( isset( $_REQUEST['location'] ) && $_REQUEST['location'] != '' ) {

			$selectedkey = $_REQUEST['location'];
		}

		if ( $automobile_location_type == 'countries_only' ) {

			if ( isset( $automobile_location_countries ) && ! empty( $automobile_location_countries ) ) {

				foreach ( $automobile_location_countries as $key => $country ) {

					$selected = '';

					if ( isset( $selectedkey ) && $selectedkey == $country->slug ) {

						$selected = 'selected';
					}

					if ( preg_match( "/^$location_name/i", $country->name ) ) {

						$location_list[] = array( 'slug' => $country->slug, 'value' => $country->name );
					}
				}
			}
		} else if ( $automobile_location_type == 'countries_and_cities' ) {

			if ( isset( $automobile_location_countries ) && ! empty( $automobile_location_countries ) ) {

				foreach ( $automobile_location_countries as $key => $country ) {

					$country_added = 0;  // check for country added in array or not

					$selected = '';

					if ( isset( $selectedkey ) && $selectedkey == $country->slug ) {

						$selected = 'selected';
					}

					if ( preg_match( "/^$location_name/i", $country->name ) ) {

						$location_list[] = array( 'slug' => $country->slug, 'value' => $country->name );

						$country_added = 1;
					}

					$selected_spec = get_term_by( 'slug', $country->slug, 'automobile_locations' );

					$state_parent_id = $selected_spec->term_id;

					$cities = '';

					$states_args = array(
						'orderby' => 'name',
						'order' => 'ASC',
						'fields' => 'all',
						'slug' => '',
						'hide_empty' => false,
						'parent' => $state_parent_id,
					);

					$cities = get_terms( 'automobile_locations', $states_args );

					if ( isset( $cities ) && $cities != '' && is_array( $cities ) ) {

						$flag_i = 0;

						foreach ( $cities as $key => $city ) {

							if ( preg_match( "/^$location_name/i", $city->name ) ) {

								if ( $country_added == 0 ) { // means if country not added in array then add one time in array for this city
									if ( $flag_i == 0 ) {

										$location_list[] = array( 'slug' => $country->slug, 'value' => $country->name );
									}
								}

								$location_list[]['child'] = array( 'slug' => $city->slug, 'value' => $city->name );

								$flag_i ++;
							}
						}
					}
				}
			}
		} else if ( $automobile_location_type == 'cities_only' ) {

			if ( isset( $automobile_location_countries ) && ! empty( $automobile_location_countries ) ) {

				foreach ( $automobile_location_countries as $key => $country ) {

					$selected = '';

					$selected_spec = get_term_by( 'slug', $country->slug, 'automobile_locations' );

					$city_parent_id = $selected_spec->term_id;

					$cities_args = array(
						'orderby' => 'name',
						'order' => 'ASC',
						'fields' => 'all',
						'slug' => '',
						'hide_empty' => false,
						'parent' => $city_parent_id,
					);

					$cities = get_terms( 'automobile_locations', $cities_args );

					if ( isset( $cities ) && $cities != '' && is_array( $cities ) ) {

						foreach ( $cities as $key => $city ) {

							if ( preg_match( "/^$location_name/i", $city->name ) ) {

								$location_list[] = array( 'slug' => $city->slug, 'value' => $city->name );
							}
						}
					}
				}
			}
		}

		echo json_encode( $location_list );

		die();
	}

	add_action( "wp_ajax_automobile_get_all_countries_cities", "automobile_get_all_countries_cities" );

	add_action( "wp_ajax_nopriv_automobile_get_all_countries_cities", "automobile_get_all_countries_cities" );
}

/**

 * End Function how to get all Countries and Cities Function

 */
