<?php
/**
 * Inventories Grid view
 *
 */
global $wpdb, $a, $args, $count_post, $automobile_blog_num_post, $automobile_var_plugin_core, $automobile_var_plugin_static_text, $inventory_random_id;

// Session value for inventory view
$automobile_inventories_counter = isset($a['automobile_inventories_counter']) ? $a['automobile_inventories_counter'] : '';
//var_dump($automobile_inventories_counter);
//var_dump($_SESSION["automobile_inventory_view_$automobile_inventories_counter"]);
if (isset($_SESSION["automobile_inventory_view_$automobile_inventories_counter"]) && $_SESSION["automobile_inventory_view_$automobile_inventories_counter"] != '') {
    $a['automobile_inventory_view'] = $_SESSION["automobile_inventory_view_$automobile_inventories_counter"];
}

//var_dump($a['automobile_inventory_view']);

$main_col = 'section-content col-lg-12 col-md-12 col-sm-12 col-xs-12';
$automobile_inv_view = $a['automobile_inventory_view'];
$content_box_classes = 'col-lg-4 col-md-4 col-sm-12 col-xs-12'; // by callum
if ($a['automobile_inventory_searchbox'] == 'yes') {
    $main_col = 'section-content col-lg-9 col-md-9 col-sm-12 col-xs-12';
    $content_box_classes = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
}

wp_enqueue_style('automobile-mCustomScrollbar-css');
wp_enqueue_script('mCustomScrollbar-scripts');
$automobile_current_page = 1;
if (isset($_GET['page_inventory'])) {
    $automobile_current_page = $_GET['page_inventory'];
}

if ($a['automobile_inventory_view'] == 'grid') {

    $automobile_view_class = 'auto-listing auto-grid';
} elseif ($a['automobile_inventory_view'] == 'classic') {

    $automobile_view_class = 'auto-listing';
    $content_box_classes = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
} elseif ($a['automobile_inventory_view'] == 'fancy') {

    global $wpdb, $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text;
    $automobile_var_makes = automobile_var_plugin_text_srt('automobile_var_makes');

    $automobile_rand_num = rand(123456789, 987654321);
    $popup_randid = rand(0, 499999999);
    ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="cs-listing-filters">
	    <?php
	    if (empty($qrystr)) {
		$qrystr = '';
	    }
	    $final_query_str = str_replace("?", "", $qrystr);
	    $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'location', 'no');
	    $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'inventory_title', 'no');
	    $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'radius', 'no');
	    $final_query_str = str_replace("?", "", $final_query_str);
	    $query = explode('&', $final_query_str);
	    $automobile_inv_get_type = isset($_REQUEST['inventory_type']) ? $_REQUEST['inventory_type'] : '';
	    if (!isset($_REQUEST['inventory_type'])) {
		if (isset($automobile_var_plugin_options['automobile_default_inventory_type'])) {
		    $automobile_inv_get_type = ($automobile_inv_get_type != '') ? $automobile_inv_get_type : $automobile_var_plugin_options['automobile_default_inventory_type'];
		}
	    }

	    $inventory_make = '';
	    if (isset($_REQUEST['inventory_make'])) {
		$inventory_make = $_REQUEST['inventory_make'];
	    }
	    ?>
            <form class="search-form" method="get" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php')); ?>" onsubmit="return automobile_var_filter_form_submit();">


		<?php
		// Inventory Types
		$final_query_str = str_replace("?", "", $qrystr);
		$final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'inventory-type', 'no');
		$query = explode('&', $final_query_str);

		$automobile_inventory_type_posts = get_posts(array('posts_per_page' => '-1', 'post_type' => 'inventory-type', 'post_status' => 'publish'));

		if ($automobile_inventory_type_posts != '') {
		    ?>
		    <div class="select-input">
			<div class="tabs-filters">
			    <?php
			    $tax_options = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_type') . '</option>';
			    foreach ($automobile_inventory_type_posts as $inventory_typeitem) {
				$inventory_type_mypost = '';
				$inventory_type_qry_str = '';
				$inventory_type_qry_str .= automobile_remove_qrystr_extra_var($qrystr, 'inventory-type');
				if (automobile_remove_qrystr_extra_var($qrystr, 'inventory-type') != '?') {
				    $inventory_type_qry_str .= '&';
				}

				$inventory_type_qry_str .= 'inventory-type=' . $inventory_typeitem->post_name;

				if (isset($automobile_inv_get_type) && $automobile_inv_get_type == $inventory_typeitem->post_name) {
				    $selected = ' selected="selected"';
				} else {
				    $selected = '';
				}

				$tax_options .= '<option value="' . $inventory_typeitem->post_name . '" ' . $selected . '>' . $inventory_typeitem->post_title . '</option>';
				if ($a['automobile_inventory_view'] == 'fancy') {
				    ?>
				    <div class="tab_link" id="<?php echo $inventory_typeitem->post_name . $inventory_random_id; ?>"  onclick="automobile_var_filter_form_submit('<?php echo $inventory_typeitem->post_name; ?>', '<?php echo $a['automobile_inventory_view']; ?>')"><?php echo $inventory_typeitem->post_title; ?></div>
				<?php } else {
				    ?>

				    <div class="tab_link" id="<?php echo $inventory_typeitem->post_name . $inventory_random_id; ?>"  onclick="automobile_inventory_type_change('<?php echo $inventory_typeitem->post_name; ?>', '<?php echo $a['automobile_inventory_view']; ?>')"><?php echo $inventory_typeitem->post_title; ?></div>
				    <?php
				}
			    }
			    ?>
			</div>
		    </div>
		    <?php
		}
		?>
            </form>
        </div>
    </div>

    <?php
    $automobile_view_class = 'auto-listing auto-grid fancy';
    //$content_box_classes = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
}
echo '<div class="' . $main_col . '"><div class="row">';
if ($a['automobile_inventory_top_search'] != 'None') {
    include automobile_var()->plugin_path() . '/frontend/inventories/cs-sort-filters.php';
}

echo '<div class="cs-inventories-listing-loader" style="display: none;"></div><div class="cs-msg-comparebox"></div>';
$qrystr = '';
foreach ($_GET as $key => $val) {
    if ($key != 'radius' && $key != 'automobile_inv_elem_atts' && $key != 'action' && $key != 'page_inventory' && $key != 'page_url' && $key != 'page_id') {
	if (is_array($val)) {
	    foreach ($val as $key_val) {
		$qrystr .= $key . '=' . $key_val . '&';
	    }
	} else {
	    $qrystr .= $key . '=' . $val . '&';
	}
    }
}
if (!isset($qrystr) || $qrystr == '') {
    foreach ($_POST as $key => $val) {
	if ($key != 'radius' && $key != 'automobile_inv_elem_atts' && $key != 'action' && $key != 'page_inventory' && $key != 'page_url' && $key != 'page_id') {

	    if (is_array($val)) {
		foreach ($val as $key_val) {
                    if( $key_val != ''){
                        $qrystr .= $key . '=' . $key_val . '&';
                    }
		}
	    } else {
		$qrystr .= $key . '=' . $val . '&';
	    }
	}
    }
}
include automobile_var()->plugin_path() . '/frontend/inventories/cs-search-keywords.php';

$loop = new WP_Query($args);
//echo '<div class="cs-inventories-listing-loader"></div>';

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
	    $automobile_inv_user_img_src = automobile_get_user_attachment_url_from_name($automobile_inventory_user_img);
	}
	if ($automobile_inv_user_img_src == '') {
	    $automobile_inv_user_img_src = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found4x3.jpg');
	}
	$automobile_inv_gallery = get_post_meta($post->ID, 'automobile_inventory_gallery_url', true);
	$automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';
        
        $automobile_img_url = $automobile_gal_url;
        /*
	$automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);
	$automobile_img_url = automobile_get_image_thumb($automobile_gal_url, 'automobile_var_media_2');
	if (isset($automobile_img_url) && $automobile_img_url != '') {
	    $automobile_img_url = $automobile_img_url;
	} else {
	    $automobile_img_url = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found16x9.jpg');
	}*/
	?>
	<div class="<?php echo esc_html($content_box_classes) ?>">
	    <div class="<?php echo esc_html($automobile_view_class) ?>">
		<div class="cs-media">
		    <?php if ($automobile_img_url != '') { ?>
	    	    <figure>

	    		<a href="<?php the_permalink(); ?>"> <img class="lazyload no-src" src="<?php echo esc_html($automobile_img_url); ?>" data-src="<?php echo esc_html($automobile_img_url); ?>" alt=""></a>
			    <?php if ($automobile_inventory_featured == 'yes') { ?>
				<figcaption> 
				    <span class="auto-featured"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_featured')); ?></span>
				</figcaption>
			    <?php } ?>
	    	    </figure>
		    <?php } ?>
		</div>
		<div class="auto-text">
		    <?php
		    $automobile_inv_makes = get_the_term_list($post->ID, 'inventory-make', '<span class="cs-categories">', ', ', '</span>');
		    if ($automobile_inv_makes != '') {
			printf('%1$s', $automobile_inv_makes);
		    }
		    ?>
		    <div class="post-title">
			<h4><a href="<?php echo esc_url(get_permalink()) ?>"><?php echo wp_trim_words(get_the_title($post->ID), 6, '...') ?></a></h4>
			<h6><a href="<?php echo esc_url(get_permalink()) ?>"><?php echo wp_trim_words(get_the_title($post->ID), 6, '...') ?></a></h6>
			<?php
			if ($price_status == 'on') {
			    echo automobile_inventory_listing_price($automobile_new_price, $automobile_old_price);
			}
			if (isset($automobile_inv_user_img_src) && $automobile_inv_user_img_src != '') {
			    echo '<a href="' . get_author_posts_url($automobile_inventory_username) . '" class="thumb-img"><img class="lazyload no-src" src="' . esc_url($automobile_inv_user_img_src) . '" alt=""></a>';
			}
			?>
		    </div>
		    <?php
		    echo automobile_inventory_features_info($post->ID);
		    if (is_array($automobile_inv_feature_list) && sizeof($automobile_inv_feature_list) > 0) {
			?>
	    	    <div class="btn-list">
	    		<a href="javascript:void(0)" class="btn btn-danger collapsed" data-toggle="collapse" data-target="#list-view<?php echo absint($post->ID) . $inventory_random_id ?>" aria-expanded="false"></a>
	    		<div id="list-view<?php echo absint($post->ID) . $inventory_random_id ?>" class="collapse" aria-expanded="false" style="height: 0px;" role="listbox">
	    		    <ul>
				    <?php
				    foreach ($automobile_inv_feature_list as $inv_feat) {
					?>
					<li><?php echo esc_html($inv_feat) ?></li>
					<?php
				    }
				    ?>
	    		    </ul>
	    		</div>
	    	    </div>
			<?php
		    }
		    if (get_the_content() != '') {
			?><p><?php echo wp_trim_words(get_the_content(), 15, '...') ?><a href="<?php echo esc_url(get_permalink()) ?>" class="read-more cs-color"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_more')); ?></a></p>
		    <?php } ?>
		    <?php echo automobile_inventory_compare_button($post->ID) ?>
		    <?php
		    if (current_user_can('administrator')){
			$admin = true;
		    } else {
			$admin = false;
		    }
		    if (is_user_logged_in() && $admin != true) {
			$user = automobile_get_user_id();

			$finded_result_list = automobile_find_index_user_meta_list($post->ID, 'cs-user-inventory-wishlist', 'post_id', automobile_get_user_id());
			if (isset($user) and $user <> '' and is_user_logged_in()) {
			    if (is_array($finded_result_list) && !empty($finded_result_list)) {
				?>
		    	    <a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" value="1" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_removeinventory_to('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, '', 'view1')" ><i class="icon-heart"></i>
				    <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>
		    	    </a> 
				<?php
			    } else {
				?>
		    	    <a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'view1')" ><i class="icon-heart-o"></i> <?php echo automobile_var_plugin_text_srt('automobile_var_shortlist'); ?></a> 
				<?php
			    }
			} else {
			    ?>
			    <a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'view1')" ><i class="icon-heart-o">
				</i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>
			    </a> 	
			    <?php
			}
		    } else {
			?>
	    	    <a href="javascript:void(0)" class="heart-btn short-list cs-color" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" onclick="trigger_func('#btn-header-main-login');"><i class='icon-heart-o'></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?></a> 
			<?php
		    }
		    ?>

		    <a href="<?php echo esc_url(get_permalink()) ?>" class="View-btn"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_view_detail')); ?><i class="icon-arrow-long-right"></i></a>
		</div>
	    </div>
	</div>
	<?php
    endwhile;
    //==Pagination Start
    if ($count_post > $automobile_blog_num_post && $automobile_blog_num_post > 0 && $a['automobile_inventory_show_pagination'] == "pagination") {
	$total_pages = 1;
	if ($count_post > 0) {
	    $total_pages = ceil($count_post / $automobile_blog_num_post);
	}
	echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><nav class="navigation pagination" role="navigation">';
	echo force_balance_tags($automobile_var_plugin_core->automobile_var_plugin_ajax_pagination($total_pages, $_REQUEST['page_inventory'], 'page_inventory'));
	echo '</nav></div>';
    }//==Pagination End 
} else {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p>' . automobile_var_plugin_text_srt('automobile_var_no_inventory_found') . '</p></div>';
}
echo '</div></div>';
?>
