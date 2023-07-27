<?php

if (!function_exists('automobile_iconlist_plugin_options')) {

    function automobile_iconlist_plugin_options($icon_value = '', $id = '', $name = '') {
        global $automobile_form_fields, $automobile_var_plugin_static_text;

        $automobile_var_icomoon = '
        <script>
            jQuery(document).ready(function ($) {

                var e9_element = $(\'#e9_element_' . esc_html($id) . '\').fontIconPicker({
                    theme: \'fip-bootstrap\'
                });
                // Add the event on the button
                $(\'#e9_buttons_' . esc_html($id) . ' button\').on(\'click\', function (e) {
                    e.preventDefault();
                    // Show processing message
                    $(this).prop(\'disabled\', true).html(\'<i class="icon-cog demo-animate-spin"></i> ' . __('Please wait...', 'automobile') . '\');
                    $.ajax({
                        url: "' . automobile_var()->plugin_url() . 'assets/common/icomoon/js/selection.json",
                        type: \'GET\',
                        dataType: \'json\'
                    }).done(function (response) {
                            // Get the class prefix
                            var classPrefix = response.preferences.fontPref.prefix,
                                    icomoon_json_icons = [],
                                    icomoon_json_search = [];
                            $.each(response.icons, function (i, v) {
                                    icomoon_json_icons.push(classPrefix + v.properties.name);
                                    if (v.icon && v.icon.tags && v.icon.tags.length) {
                                            icomoon_json_search.push(v.properties.name + \' \' + v.icon.tags.join(\' \'));
                                    } else {
                                            icomoon_json_search.push(v.properties.name);
                                    }
                            });
                            // Set new fonts on fontIconPicker
                            e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
                            // Show success message and disable
                            $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-success\').text(\'' . automobile_var_plugin_text_srt('automobile_var_load_icon') . '\').prop(\'disabled\', true);
                    })
                    .fail(function () {
                            // Show error message and enable
                            $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-danger\').text(\'' . automobile_var_plugin_text_srt('automobile_var_try_again') . '\').prop(\'disabled\', false);
                    });
                    e.stopPropagation();
                });
                jQuery("#e9_buttons_' . esc_html($id) . ' button").click();
            });
        </script>';
        $automobile_opt_array = array(
            'std' => esc_html($icon_value),
            'cust_id' => 'e9_element_' . esc_html($id),
            'cust_name' => esc_html($name) . '[]',
            'return' => true,
        );
        $automobile_var_icomoon .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
        $automobile_var_icomoon .= '
        <span id="e9_buttons_' . esc_html($id) . '" style="display:none">
            <button autocomplete="off" type="button" class="btn btn-primary">' . automobile_var_plugin_text_srt('automobile_var_load_json') . '</button>
        </span>';

        return $automobile_var_icomoon;
    }

}

/**
 *
 * @get query whereclase by array
 *
 */
if (!function_exists('automobile_get_query_whereclase_by_array')) {

    function automobile_get_query_whereclase_by_array($array, $user_meta = false) {
        $id = '';
        $flag_id = 0;
        if (isset($array) && is_array($array)) {
            foreach ($array as $var => $val) {
                $string = ' ';
                $string .= ' AND (';
                if (isset($val['key']) || isset($val['value'])) {
                    $string .= get_meta_condition($val);
                } else {  // if inner array 
                    if (isset($val) && is_array($val)) {
                        foreach ($val as $inner_var => $inner_val) {
                            $inner_relation = isset($inner_val['relation']) ? $inner_val['relation'] : 'and';
                            $second_string = '';

                            if (isset($inner_val) && is_array($inner_val)) {
                                $string .= "( ";
                                $inner_arr_count = is_array($inner_val) ? count($inner_val) : '';
                                $inner_flag = 1;
                                foreach ($inner_val as $inner_val_var => $inner_val_value) {
                                    if (is_array($inner_val_value)) {
                                        $string .= "( ";
                                        $string .= get_meta_condition($inner_val_value);
                                        $string .= ' )';
                                        if ($inner_flag != $inner_arr_count) {
                                            $string .= ' ' . $inner_relation . ' ';
                                        }
                                    }
                                    $inner_flag ++;
                                }
                                $string .= ' )';
                            }
                        }
                    }
                }
                $string .= " ) ";
                $id_condtion = '';
                if (isset($id) && $flag_id != 0) {
                    $id = implode(",", $id);
                    if (empty($id)) {
                        $id = 0;
                    }
                    if ($user_meta == true) {
                        $id_condtion = ' AND user_id IN (' . $id . ')';
                    } else {
                        $id_condtion = ' AND post_id IN (' . $id . ')';
                    }
                }
                if ($user_meta == true) {
                    $id = automobile_get_user_id_by_whereclase($string . $id_condtion);
                } else {
                    $id = automobile_get_post_id_by_whereclase($string . $id_condtion);
                }
                $flag_id = 1;
            }
        }
        return $id;
    }

}
/**
 * Start Function how to get Meta using Conditions
 */
if (!function_exists('get_meta_condition')) {

    function get_meta_condition($val) {
        $string = '';
        $meta_key = isset($val['key']) ? $val['key'] : '';
        $compare = isset($val['compare']) ? $val['compare'] : '=';
        $meta_value = isset($val['value']) ? $val['value'] : '';
        $string .= " meta_key='" . $meta_key . "' AND ";
        $type = isset($val['type']) ? $val['type'] : '';
        if ($compare == 'BETWEEN' || $compare == 'between' || $compare == 'Between') {
            $meta_val1 = '';
            $meta_val2 = '';
            if (isset($meta_value) && is_array($meta_value)) {
                $meta_val1 = isset($meta_value[0]) ? $meta_value[0] : '';
                $meta_val2 = isset($meta_value[1]) ? $meta_value[1] : '';
            }
            if ($type != '' && strtolower($type) == 'numeric') {
                $string .= " meta_value BETWEEN '" . $meta_val1 . "' AND " . $meta_val2 . " ";
            } else {
                $string .= " meta_value BETWEEN '" . $meta_val1 . "' AND '" . $meta_val2 . "' ";
            }
        } elseif ($compare == 'like' || $compare == 'LIKE' || $compare == 'Like') {
            $string .= " meta_value LIKE '%" . $meta_value . "%' ";
        } else {
            if ($type != '' && strtolower($type) == 'numeric') {
                $string .= " meta_value" . $compare . " " . $meta_value . " ";
            } else {
                $string .= " meta_value" . $compare . "'" . $meta_value . "' ";
            }
        }
        return $string;
    }

}
/**
 * end Function how to get Meta using Conditions
 */
/**
 * Start Function how to get post id using whereclase Query
 */
if (!function_exists('automobile_get_post_id_by_whereclase')) {

    function automobile_get_post_id_by_whereclase($whereclase) {
        global $wpdb;
        $qry = "SELECT post_id FROM $wpdb->postmeta WHERE 1=1 " . $whereclase;
        return $posts = $wpdb->get_col($qry);
    }

}

if (!function_exists('automobile_get_user_id_by_whereclase')) {

    function automobile_get_user_id_by_whereclase($whereclase) {
        global $wpdb;
        $qry = "SELECT user_id FROM $wpdb->usermeta WHERE 1=1 " . $whereclase;
        return $posts = $wpdb->get_col($qry);
    }

}

/**
 * end Function how to get post id using whereclase Query
 */
/**
 * Start Function how to get post id using whereclase Query
 */
if (!function_exists('automobile_get_post_id_whereclause_post')) {

    function automobile_get_post_id_whereclause_post($whereclase) {
        global $wpdb;
        $qry = "SELECT ID FROM $wpdb->posts WHERE 1=1 " . $whereclase;
        return $posts = $wpdb->get_col($qry);
    }

}
/**
 * Start Function Allow Special Character
 */
if (!function_exists('automobile_allow_special_char')) {

    function automobile_allow_special_char($input = '') {
        $output = $input;
        return $output;
    }

}

if (!function_exists('cs_get_server_data')) {

    function cs_get_server_data($server_data) {
        if (isset($server_data)) {

            return $_SERVER[$server_data];
        }
    }

}


// Contact form submit ajax
if (!function_exists('automobile_var_contact_submit')) {

    function automobile_var_contact_submit() {

        define('WP_USE_THEMES', false);
        global $abc;
        $check_box = '';
        $json = array();
        $automobile_contact_error_msg = '';
        $subject_name = '';
        foreach ($_REQUEST as $keys => $values) {
            $$keys = $values;
        }
        $bloginfo = get_bloginfo();
        $automobile_contactus_send = '';
        $subjecteEmail = "(" . $bloginfo . ") " . automobile_var_theme_text_srt('automobile_var_contact_received');
        if ($automobile_contact_email <> '') {
            $message = '
            <table width="100%" border="1">
              <tr>
                <td width="100"><strong>' . esc_html__('Full Name', 'automobile'). '</strong></td>
                <td>' . esc_html($contact_name) . '</td>
              </tr>
              <tr>
                <td><strong>' . esc_html__('Email Address', 'automobile') . '</strong></td>
                <td>' . esc_html($contact_email) . '</td>
              </tr>';
             if ($contact_phone != ''){
              $message .= '<tr>
                <td><strong>'  .  esc_html__('Phone Number', 'automobile') .  '</strong></td>
                <td>' . esc_html($contact_phone) . '</td>
              </tr>';
             }
             if ($contact_msg != ''){
              $message .= '<tr>
                <td><strong>' .  esc_html__('Message', 'automobile') . '</strong></td>
                <td>' . esc_html($contact_msg) . '</td>
              </tr>';
             }
            if ($check_box != '') {
                $message .= '
              <tr>
                <td><strong>' .  esc_html__('Message', 'automobile') . '</strong></td>
                <td>' . esc_html($check_box) . '</td>
              </tr>';
            }
            $message .= '
              <tr>
                <td><strong>' .  esc_html__('IP Address', 'automobile'). '</strong></td>
                <td>' . cs_get_server_data("REMOTE_ADDR") . '</td>
              </tr>
            </table>';
            $headers = "From: " . $contact_name . "\r\n";
            $headers .= "Reply-To: " . $contact_email . "\r\n";
            $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $attachments = '';
            if (wp_mail($automobile_contact_email, sanitize_email($subjecteEmail), $message, $headers, '')) {
                $json['type'] = "success";
                $json['message'] = '' . esc_html($automobile_contact_succ_msg) . '';
            } else {
                $json['type'] = "error";
                $json['message'] = '' . esc_html($automobile_contact_error_msg) . '';
            };
        } else {
            $json['type'] = "error";
            $json['message'] = '' . esc_html($automobile_contact_error_msg) . '';
        }
        echo json_encode($json);
        die();
    }

}


// Contact form submit ajax
if (!function_exists('automobile_var_contact_sche_submit')) {

    function automobile_var_contact_sche_submit() {

	define('WP_USE_THEMES', false);
	global $abc;
	$check_box = '';
	$json = array();
	$automobile_contact_error_msg = '';
	$subject_name = '';
	foreach ($_REQUEST as $keys => $values) {
	    $$keys = $values;
	}
	$bloginfo = get_bloginfo();
	$automobile_contactus_send = '';
	$subjecteEmail = "(" . $bloginfo . ") " . automobile_var_theme_text_srt('automobile_var_contact_received');
	if ($automobile_contact_email <> '') {
	    $message = '
            <table width="100%" border="1">
              <tr>
                <td width="100"><strong>' . esc_html__('Full Name', 'automobile')  . '</strong></td>
                <td>' . esc_html($contact_name) . '</td>
              </tr>
              <tr>
                <td><strong>' . esc_html__('Email Address', 'automobile')  . '</strong></td>
                <td>' . esc_html($contact_email) . '</td>
              </tr>
	      ';
	    if ($contact_phone != '') {
		$message .= '<tr>
                <td><strong>'. esc_html__('Phone Number', 'automobile')  . '</strong></td>
                <td>' . esc_html($contact_phone) . '</td>
              </tr>';
	    }
	    if ($contact_makemodel != '') {
		$message .= '<tr>
                <td><strong>' . esc_html__('Make/Model', 'automobile')  . '</strong></td>
                <td>' . esc_html($contact_makemodel) . '</td>
              </tr>';
	    }
	    if ($millage != '') {
		$message .= '<tr>
                <td><strong>'. esc_html__('Mileage', 'automobile')  . '</strong></td>
                <td>' . esc_html($millage) . '</td>
              </tr>';
	    }
	    if ($best_time != '') {
		$message .= '<tr>
                <td><strong>' . esc_html__('Best time', 'automobile')  . '</strong></td>
                <td>' . esc_html($best_time) . '</td>
              </tr>';
	    }
	    if ($contact_msg != '') {
		$message .= '<tr>
                <td><strong>' . automobile_var_theme_text_srt('automobile_var_contact_message') . '</strong></td>
                <td>' . esc_html($contact_msg) . '</td>
              </tr>';
	    }
	    if ($check_box != '') {
		$message .= '
              <tr>
                <td><strong>' . automobile_var_theme_text_srt('automobile_var_contact_check_field') . '</strong></td>
                <td>' . esc_html($check_box) . '</td>
              </tr>';
	    }
	    $message .= '
              <tr>
                <td><strong>' . esc_html__('IP Address', 'automobile')  . '</strong></td>
                <td>' . cs_get_server_data("REMOTE_ADDR") . '</td>
              </tr>
            </table>';
	    $headers = "From: " . $contact_name . "\r\n";
	    $headers .= "Reply-To: " . $contact_email . "\r\n";
	    $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
	    $headers .= "MIME-Version: 1.0" . "\r\n";
	    $attachments = '';
	    if (wp_mail($automobile_contact_email, 'Schedule form', $message, $headers, '')) {
		$json['type'] = "success";
		$json['message'] = '' . esc_html($automobile_contact_succ_msg) . '';
	    } else {
		$json['type'] = "error";
		$json['message'] = '' . esc_html($automobile_contact_error_msg) . '';
	    };
	} else {
	    $json['type'] = "error";
	    $json['message'] = '' . esc_html($automobile_contact_error_msg) . '';
	}
	echo json_encode($json);
	die();
    }

}

/**
 * Start Function Data Size
 */
if (!function_exists('automobile_element_size_data_array_index')) {

    function automobile_element_size_data_array_index($size) {
        if ($size == "" or $size == 100) {
            return 0;
        } else if ($size == 75) {
            return 1;
        } else if ($size == 67) {
            return 2;
        } else if ($size == 50) {
            return 3;
        } else if ($size == 33) {
            return 4;
        } else if ($size == 25) {
            return 5;
        }
    }

}



function tabs_search_result_func($on_page_refresh = ''){

global $a, $wpdb, $args, $count_post, $automobile_blog_num_post, $automobile_var_plugin_core;
	
$inventory_type = $_POST['tab_value'];

$inventory_type_posts = get_posts( array( 'posts_per_page' => '-1', 'post_type' => 'inventory-type', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ) );

	foreach ( $inventory_type_posts as $inv_post ) {
		$type_options[] = $inv_post->post_title;
	}

		if(!empty($type_options) && empty($inventory_type)){
		   $inventory_type = $type_options[0];
		}
		
	    $args = array(
            'post_type' => 'inventory',
			'ignore_sticky_posts' => 1,			
            'posts_per_page' => 9,			
            'post_status' => 'publish',
			'paged' => 1,
            'orderby' => 'DESC',
			'meta_query' => array(
				array(
					'key' => 'automobile_inventory_type',
					'value' => $inventory_type,
					'compare' => '=',
				),
            ),
        );
        		
        $loop = new WP_Query($args);
		$count_post = $loop->found_posts;

		$cs_html = '';
//		var_dump($automobile_inv_feature_list);
//		var_dump($automobile_inv_gallery);
		
$cs_html .= '<div class="cs-inventories-listing-loader" style="display: none;"></div><div class="cs-msg-comparebox"></div>';
				
if ($loop->have_posts()) {

    while ($loop->have_posts()) : $loop->the_post();
        global $post;

        $automobile_old_price = get_post_meta($post->ID, 'automobile_inventory_old_price', true);
        $automobile_new_price = get_post_meta($post->ID, 'automobile_inventory_new_price', true);
        $inventory_type_slug = get_post_meta($post->ID, 'automobile_inventory_type', true);

        if ($inventory_type_slug != '') {
            $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
            $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

	     } else {
            $inventory_type_id = '';
        }

        $price_status = get_post_meta($inventory_type_id, "automobile_price_switch", true);
		
        $automobile_inv_feature_list = get_post_meta($post->ID, 'automobile_inventory_feature_list', true);
        $automobile_inventory_username = get_post_meta($post->ID, 'automobile_inventory_username', true);
        $automobile_inventory_featured = get_post_meta($post->ID, 'automobile_inventory_featured', true);

        $automobile_inv_user_img_src = '';
        $automobile_inventory_user_img = get_user_meta($automobile_inventory_username, 'user_img', true);
		
        if ($automobile_inventory_user_img != '') {
			//$automobile_inv_user_img_src = automobile_get_img_url($automobile_inventory_user_img, 'automobile_var_media_6');
			$automobile_inv_user_img_src = automobile_get_user_attachment_url_from_name( $automobile_inventory_user_img );
		}

        if ($automobile_inv_user_img_src == '') {
            $automobile_inv_user_img_src = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found4x3.jpg');
        }
		
        $automobile_inv_gallery = get_post_meta($post->ID, 'automobile_inventory_gallery_url', true);
        $automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';
		
//      $automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);		
		
        $automobile_img_url = automobile_get_image_thumb($automobile_gal_url, 'automobile_var_media_2');
		
        if (isset($automobile_img_url) && $automobile_img_url != '') {
            $automobile_img_url = $automobile_img_url;
        } else {
            $automobile_img_url = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found16x9.jpg');
        }
		
		$cs_html .= '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> <div class="auto-listing auto-grid fancy"> <div class="cs-media">';
	   
                    if ($automobile_img_url != '') {
						
                        $cs_html .= '<figure>';
                        $cs_html .= '<a href="' . get_permalink() . '">';
						$cs_html .= '<img class="lazyload no-src" src="'.esc_html($automobile_img_url) . '" data-src="'. esc_html($automobile_img_url).'" alt="">';
						$cs_html .= '</a>';
                            if ($automobile_inventory_featured == 'yes') {
                                $cs_html .= '<figcaption>
                                    <span class="auto-featured">'.esc_html(automobile_var_plugin_text_srt('automobile_var_featured')) .'</span>
                                </figcaption>';
                             } 
                        $cs_html .= '</figure>';
                     } 
					 
                $cs_html .= '</div>';
                $cs_html .= '<div class="auto-text">';

                    $automobile_inv_makes = get_the_term_list($post->ID, 'inventory-make', '<span class="cs-categories">', ', ', '</span>');
					
                    if ($automobile_inv_makes != '') {
						$cs_html .= $automobile_inv_makes;
                    }

                    $cs_html .= '<div class="post-title">                    
                        <h4><a href="'.esc_url(get_permalink()).'">'.wp_trim_words(get_the_title($post->ID), 6, '...').' </a></h4>
                        <h6><a href="'.esc_url(get_permalink()).'">'.wp_trim_words(get_the_title($post->ID), 6, '...').'</a></h6>';

                        if ($price_status == 'on') {
                            $cs_html .= automobile_inventory_listing_price($automobile_new_price,$automobile_old_price);
                        }
						
                        if (isset($automobile_inv_user_img_src) && $automobile_inv_user_img_src != '') {
                            $cs_html .= '<a href="'. get_author_posts_url( $automobile_inventory_username ).'" class="thumb-img"><img class="lazyload no-src" src="' . esc_url($automobile_inv_user_img_src) . '" alt=""></a>';
                        }

                    $cs_html .= '</div></div>';
					
					
					$cs_html .= automobile_inventory_features_info($post->ID);
					
                    if (is_array($automobile_inv_feature_list) && sizeof($automobile_inv_feature_list) > 0) {

							$cs_html .= '<div class="btn-list">';
                            $cs_html .= '<a href="javascript:void(0)" class="btn btn-danger collapsed" data-toggle="collapse" data-target="#list-view'.absint($post->ID) . $inventory_random_id.'" aria-expanded="false"></a>';
                            $cs_html .= '<div id="list-view'.absint($post->ID) . $inventory_random_id.'" class="collapse" aria-expanded="false" style="height: 0px;" role="listbox">';
                            $cs_html .= '<ul>';

                                    foreach ($automobile_inv_feature_list as $inv_feat) {
                                        $cs_html .= '<li>'.esc_html($inv_feat).'</li>';
                                    }

                                $cs_html .= '</ul>
											</div>
										</div>';
								}
										
								if ( get_the_content() != '' ) {
									$cs_html .= '<p>' . wp_trim_words( get_the_content(), 15, '...' ) . '<a href="' . esc_url( get_permalink() ) . '" class="read-more cs-color">' . esc_html( automobile_var_plugin_text_srt( 'automobile_var_more' ) ) . '</a></p>';
								}

								$cs_html .= automobile_inventory_compare_button( $post->ID );
								
                    if (is_user_logged_in()) {
						
                        $user = automobile_get_user_id();

                        $finded_result_list = automobile_find_index_user_meta_list($post->ID, 'cs-user-inventory-wishlist', 'post_id', automobile_get_user_id());
						
                        if (isset($user) and $user <> '' and is_user_logged_in()) {
                            if (is_array($finded_result_list) && !empty($finded_result_list)) {

                               $cs_html .= '<a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="'.esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlist' ) ).'" shortlisted="'.esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlisted' ) ).'" title="'.esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')).'" value="1" add_shortlist="'.esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')).'" remove_shortlist="'.esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')).'" id="addjobs_to_wishlist' . intval($post->ID).'" onclick="automobile_var_removeinventory_to('.esc_url(admin_url('admin-ajax.php')).', '.absint($post->ID).', \"this\", \"view1\")" ><i class="icon-heart"></i>';
                               $cs_html .= '"' . esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')) . '"';
                               $cs_html .= '</a>';

                            } else {

                                $cs_html .= '<a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="'.esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlist' ) ).'" shortlisted="'.esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlisted' ) ).'" title="'.esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')).'" value="0" add_shortlist="'.esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')).'" remove_shortlist="'.esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')) .'" id="addjobs_to_wishlist' . intval($post->ID).'" onclick="automobile_var_addinventory_to_wish('.esc_url(admin_url('admin-ajax.php')).', '.absint($post->ID).', \"this\", \"view1\")" ><i class="icon-heart-o"></i>'.automobile_var_plugin_text_srt('automobile_var_shortlist').'</a>'; 

                            }
							
                        } else {

                            $cs_html .= '<a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="'.esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlist' )).'" shortlisted="'.esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlisted' ) ).'" title="'.esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')).'" value="0" add_shortlist="'.esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')).'" remove_shortlist="'.esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')).'" id="addjobs_to_wishlist' . intval($post->ID) .'" onclick="automobile_var_addinventory_to_wish('.esc_url(admin_url('admin-ajax.php')).', '.absint($post->ID).', \"this\", \"view1\")" ><i class="icon-heart-o">';
                            $cs_html .= '</i>'.esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist'));
							$cs_html .= '</a>';
							
                        }
                    } else {

						$btn_header_main_login = "#btn-header-main-login";
                        $cs_html .= '<a href="javascript:void(0)" class="heart-btn short-list cs-color" data-toggle="tooltip" data-placement="top" title="'.esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')).'" onclick="trigger_func('.$btn_header_main_login.');"><i class="icon-heart-o"></i>'.esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')).'</a>';
                    }								

				$cs_html .= '<a href="'.esc_url(get_permalink()).'" class="View-btn">'.esc_html(automobile_var_plugin_text_srt('automobile_var_view_detail')).'<i class="icon-arrow-long-right"></i>'.'</a>';
                $cs_html .= '</div>';

			$cs_html .= '</div></div>';

    endwhile;

		} else {
			$cs_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p>' . automobile_var_plugin_text_srt('automobile_var_no_inventory_found') . '</p></div>';
		}

	if($on_page_refresh == 'on_page_refresh'){
	echo $cs_html;	
}else{
	echo json_encode(array('success' => $cs_html));
}
	wp_die();
}

//add_action('wp_ajax_tabs_search_result_func', 'tabs_search_result_func');
add_action('wp_ajax_tabs_search_result_func', 'tabs_search_result_func');
add_action('wp_ajax_nopriv_tabs_search_result_func', 'tabs_search_result_func');