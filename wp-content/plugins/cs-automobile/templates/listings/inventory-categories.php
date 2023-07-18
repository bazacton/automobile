<?php
/**
 * The template for displaying inventory make page
 */
get_header();
$var_arrays = array('post');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);

$automobile_var_options = get_option('automobile_var_options');
if (isset($automobile_var_options['automobile_var_excerpt_length']) && $automobile_var_options['automobile_var_excerpt_length'] <> '') {
    $default_excerpt_length = $automobile_var_options['automobile_var_excerpt_length'];
} else {
    $default_excerpt_length = '120';
}
$automobile_layout = isset($automobile_var_options['automobile_var_default_page_layout']) ? $automobile_var_options['automobile_var_default_page_layout'] : '';

if (isset($automobile_layout) && ($automobile_layout == "sidebar_left" || $automobile_layout == "sidebar_right")) {
    $automobile_col_class = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else {
    $automobile_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}

$automobile_sidebar = isset($automobile_var_options['automobile_var_default_layout_sidebar']) ? $automobile_var_options['automobile_var_default_layout_sidebar'] : '';
$automobile_tags_name = 'post_tag';
$automobile_categories_name = 'category';
$width = '350';
$height = '210';

$inventory_random_id = rand(122220, 999999);

$_GET['page_inventory'] = isset($_GET['page_inventory']) ? $_GET['page_inventory'] : '1';

$automobile_blog_num_post = get_option('posts_per_page');

$temp_query = get_queried_object();

$inventory_make = isset($temp_query->slug) ? $temp_query->slug : '';

$inventories_postqry = array(
    'posts_per_page' => "-1",
    'post_type' => 'inventory',
    'post_status' => 'publish',
    'tax_query' => array(
	'relation' => 'AND',
	array(
	    'taxonomy' => 'inventory-make',
	    'field' => 'slug',
	    'terms' => $inventory_make
	),
    ),
);
$loop = new WP_Query($inventories_postqry);
$count_post = $loop->post_count;

$inventories_postqry = array(
    'posts_per_page' => "$automobile_blog_num_post",
    'paged' => $_GET['page_inventory'],
    'post_type' => 'inventory',
    'post_status' => 'publish',
    'tax_query' => array(
	'relation' => 'AND',
	array(
	    'taxonomy' => 'inventory-make',
	    'field' => 'slug',
	    'terms' => $inventory_make
	),
    ),
);
$loop = new WP_Query($inventories_postqry);
?>   

<div class="main-section">
    <div class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">     
                <!--Left Sidebar Starts-->
		<?php
		if ($automobile_layout == 'sidebar_left') {

		    if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
			echo '<div class="page-sidebar left col-md-3">';
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
			echo '</div>';
		    }
		}
		?>

                <div class= "<?php echo esc_html($automobile_col_class); ?>">
                    <div class="content-area">
                        <div class="row">
			    <?php
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

				    $automobile_inventory_user_img = get_user_meta($automobile_inventory_username, 'user_img', true);
                                    $automobile_inv_user_img_src = '';
				    if ($automobile_inventory_user_img != '') {
					$automobile_inv_user_img_src = automobile_get_img_url($automobile_inventory_user_img, 'automobile_var_media_6');
				    }
				    if ($automobile_inv_user_img_src == '') {
					$automobile_inv_user_img_src = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found4x3.jpg');
				    }
				    $automobile_inv_gallery = get_post_meta($post->ID, 'automobile_inventory_gallery_url', true);
				    $automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';
				    $automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);
				    $automobile_img_url = wp_get_attachment_image_src($automobile_gal_id, 'automobile_var_media_2');
				    if (isset($automobile_img_url[0]) && $automobile_img_url[0] != '') {
					$automobile_img_url = $automobile_img_url[0];
				    } else {
					$automobile_img_url = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found16x9.jpg');
				    }
				    ?>
				    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="auto-listing">
					    <div class="cs-media">
						<?php if ($automobile_img_url != '') { ?>
	    					<figure>

	    					    <img class="lazyload no-src" src="<?php echo esc_url($automobile_img_url); ?>" alt="">
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
						if (is_user_logged_in()) {
						    $user = automobile_get_user_id();

						    $finded_result_list = automobile_find_index_user_meta_list($post->ID, 'cs-user-inventory-wishlist', 'post_id', automobile_get_user_id());
						    if (isset($user) and $user <> '' and is_user_logged_in()) {
							if (is_array($finded_result_list) && !empty($finded_result_list)) {
							    ?>
		    					<a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" value="1" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_removeinventory_to('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, '', 'inv_cats')" ><i class="icon-heart"></i>
								<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>
		    					</a> 
							    <?php
							} else {
							    ?>
		    					<a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'inv_cats')" ><i class="icon-heart-o"></i> <?php echo automobile_var_plugin_text_srt('automobile_var_shortlist'); ?></a> 
							    <?php
							}
						    } else {
							?>
							<a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'inv_cats')" ><i class="icon-heart-o">
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
				if ($count_post > $automobile_blog_num_post && $automobile_blog_num_post > 0) {
				    $total_pages = 1;
				    if ($count_post > 0) {
					$total_pages = ceil($count_post / $automobile_blog_num_post);
				    }
				    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><nav class="navigation pagination" role="navigation">';
				    echo force_balance_tags($automobile_var_plugin_core->automobile_var_plugin_pagination($total_pages, $_GET['page_inventory'], 'page_inventory'));
				    echo '</nav></div>';
				}//==Pagination End 
			    } else {
				echo '<p>' . __('No inventory found.', 'automobile') . '</p>';
			    }
			    ?>
                        </div>
                    </div>
                </div>

		<?php
		if (isset($automobile_layout) and $automobile_layout == 'sidebar_right') {
		    if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
			echo '<div class="page-sidebar right col-md-3">';
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
			echo '</div>';
		    }
		}
		?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>