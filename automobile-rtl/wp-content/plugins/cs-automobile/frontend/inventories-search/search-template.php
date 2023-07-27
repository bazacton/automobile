<?php
/**
 * File Type: Inventory listing Shortcode
 */
/*
 *
 * Start Function  how to inventories search and  show in list views
 *
 */
if (!function_exists('automobile_inventory_search_box')) {

    function automobile_inventory_search_box($atts, $content = "") {

	global $wpdb, $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text;
	$defaults = array(
	    'inventories_search_title' => '',
	    'inventory_search_style' => '',
	    'inventory_search_layout_bg' => '',
	    'inventory_search_layout_heading_color' => '',
	    'inventory_search_title_field_switch' => '',
	    'inventory_search_type_field_switch' => '',
	    'inventory_search_make_field_switch' => '',
	    'inventory_search_location_field_switch' => '',
	    'inventory_search_title_field_style' => '',
	    'inventory_lable_switch' => '',
	    'inventory_search_hint_switch' => '',
	    'inventory_advance_search_switch' => '',
	    'inventory_advance_search_url' => '',
	);

	$automobile_rand_num = rand(1000000, 9999999);

	$search_result_page_id = '';
	$title_field_switch = 'no';
	if (isset($atts['inventory_search_title_field_switch']) && $atts['inventory_search_title_field_switch'] == 'yes') {
	    $title_field_switch = $atts['inventory_search_title_field_switch'];
	}

	$type_field_switch = 'no';
	if (isset($atts['inventory_search_type_field_switch']) && $atts['inventory_search_type_field_switch'] == 'yes') {
	    $type_field_switch = $atts['inventory_search_type_field_switch'];
	}

	$make_field_switch = 'no';
	if (isset($atts['inventory_search_make_field_switch']) && $atts['inventory_search_make_field_switch'] == 'yes') {
	    $make_field_switch = $atts['inventory_search_make_field_switch'];
	}

	$location_field_switch = 'no';
	if (isset($atts['inventory_search_location_field_switch']) && $atts['inventory_search_location_field_switch'] == 'yes') {
	    $location_field_switch = $atts['inventory_search_location_field_switch'];
	}

	$title_field_lable_switch = 'no';
	if (isset($atts['inventory_search_title_field_lable_switch']) && $atts['inventory_search_title_field_lable_switch'] == 'yes') {
	    $title_field_lable_switch = $atts['inventory_search_title_field_lable_switch'];
	}


	$inventory_search_layout_bg = 'none';
	if (isset($atts['inventory_search_layout_bg']) && $atts['inventory_search_layout_bg'] <> "") {
	    $inventory_search_layout_bg = $atts['inventory_search_layout_bg'];
	}
	$inventory_search_layout_heading_color = isset($atts['inventory_search_layout_heading_color']) ? $atts['inventory_search_layout_heading_color'] : '';
	if (isset($automobile_var_plugin_options['automobile_search_result_page'])) {
	    $search_result_page_id = $automobile_var_plugin_options['automobile_search_result_page'];
	}

	$inventory_lable_switch = 'no';
	if (isset($atts['inventory_lable_switch']) && $atts['inventory_lable_switch'] == 'yes') {
	    $inventory_lable_switch = $atts['inventory_lable_switch'];
	}
	$inventory_search_hint_switch = 'no';
	if (isset($atts['inventory_search_hint_switch']) && $atts['inventory_search_hint_switch'] == 'yes') {
	    $inventory_search_hint_switch = $atts['inventory_search_hint_switch'];
	}
	$inventory_advance_search_url = '';
	if (isset($atts['inventory_advance_search_url']) && $atts['inventory_advance_search_url'] <> "") {
	    $inventory_advance_search_url = $atts['inventory_advance_search_url'];
	}

	$inventory_advance_search_switch = 'no';
	if (isset($atts['inventory_advance_search_switch']) && $atts['inventory_advance_search_switch'] == 'yes') {
	    $inventory_advance_search_switch = $atts['inventory_advance_search_switch'];
	}
	$inventories_search_title = isset($atts['inventories_search_title']) ? $atts['inventories_search_title'] : '';
	ob_start();
	?>
	<div <?php
	if (isset($inventory_search_layout_bg) && ($inventory_search_layout_bg != '' && $inventory_search_layout_bg != 'none')) {
	    echo ' class="main-search ' . $atts['inventory_search_title_field_style'] . ' has-bgcolor" style="background:' . esc_attr($inventory_search_layout_bg) . ' !important;"';
	} else {
	    echo 'class="main-search"';
	}
	?>>

	    <?php
	    if ($search_result_page_id != '') { // search result page 
		if (isset($inventories_search_title) && $inventories_search_title <> "") {
		    ?> 
		    <div class="col-lg-12 col-md-12 col-sm-12">

			<div class="cs-section-title">
			    <h2 <?php
			    if ($inventory_search_layout_heading_color != '') {
				echo 'style="color:' . esc_html($inventory_search_layout_heading_color) . ' !important;"';
			    }
			    ?>><?php echo esc_html($inventories_search_title); ?></h2>
			</div>
		    </div>	
		<?php } ?>
	        <form class="search-area frm_inventories_filtration" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')) ?>" action="<?php echo esc_url(get_permalink($search_result_page_id)); ?>" method="get">
	    	<div class="row">
			<?php if ($title_field_switch == 'yes') { ?>
			    <?php if (isset($atts['inventory_search_title_field_style']) && $atts['inventory_search_title_field_style'] == 'classic') { ?>
		    	    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<?php } else { ?>
		    		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
				    <?php } ?>
				    <?php if ($inventory_lable_switch == 'yes') { ?>
		    		    <span class="search_title"><?php echo automobile_var_plugin_text_srt('automobile_var_title') ?></span>
				    <?php } ?>
				    <div class="search-input"> <i class="icon-search2"></i>
					<?php
					$automobile_opt_array = array(
					    'std' => '',
					    'id' => '',
					    'cust_id' => '',
					    'cust_name' => 'inventory_title',
					    'classes' => '',
					    'extra_atr' => 'placeholder="' . automobile_var_plugin_text_srt('automobile_var_search_by_keyword') . '"',
					);
					$automobile_form_fields->automobile_form_text_render($automobile_opt_array);

					if ($inventory_search_hint_switch == 'yes') {
					    ?>
		    			<label><?php echo automobile_var_plugin_text_srt('automobile_var_search_by_keyword'); ?></label> 
					<?php } ?>
				    </div>
				</div> 
				<?php
			    }
			    if ($type_field_switch == 'yes') {
				?>  
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
				    <?php if ($inventory_lable_switch == 'yes') { ?>
		    		    <span class="search_title"><?php echo automobile_var_plugin_text_srt('automobile_var_type') ?></span>
				    <?php } ?>
				    <div class="select-dropdown">
					<?php
					$type_options = '';
					 //$type_options = array();
					$type_options = array(automobile_var_plugin_text_srt('automobile_var_select_type'));

					$inventory_type_posts = get_posts(array('posts_per_page' => '-1', 'post_type' => 'inventory-type', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC'));

					foreach ($inventory_type_posts as $inv_post) {
					    $type_options[$inv_post->post_name] = $inv_post->post_title;
					}

					$automobile_inventory_type = '';
					if (!isset($_REQUEST['inventory_type'])) {
					    if (isset($automobile_var_plugin_options['automobile_default_inventory_type']) && $automobile_var_plugin_options['automobile_default_inventory_type'] != '') {

						$automobile_inventory_type = $automobile_var_plugin_options['automobile_default_inventory_type'];
					    }
					}

					$automobile_opt_array = array(
					    'std' => $automobile_inventory_type,
					    'id' => '',
					    'cust_id' => 'inventory_type',
					    'cust_name' => 'inventory_type',
					    'options' => $type_options,
					    'classes' => 'chosen-select inventory_type_shortcode',
					    'extra_atr' => 'data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_select_type') . '" onchange="automobile_inventory_search_box_makes(this.value, \'' . $automobile_rand_num . '\')"',
					);
					$automobile_form_fields->automobile_form_select_render($automobile_opt_array);


					if ($inventory_search_hint_switch == 'yes') {
					    ?>
		    			<label><?php echo automobile_var_plugin_text_srt('automobile_var_inventories_selecting_type') ?></label>
					<?php } ?>
				    </div>
				</div>
				<?php
			    }
			    if ($make_field_switch == 'yes') {
				?>  
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
				    <?php if ($inventory_lable_switch == 'yes') { ?>
		    		    <span class="search_title"><?php echo automobile_var_plugin_text_srt('automobile_var_makes') ?></span>
				    <?php } ?>
				    <div class="select-dropdown">
					<div class="type-makes-<?php echo absint($automobile_rand_num) ?>">
					    <?php
					    $makes_options = '';
					    $makes_options = array(''   => automobile_var_plugin_text_srt('automobile_var_select_makes'));
					    $makes_args = array(
						'orderby' => 'name',
						'order' => 'ASC',
						'number' => '',
						'fields' => 'all',
						'slug' => '',
						'hide_empty' => false,
						'parent' => '0',
					    );
					    // get all inventory types
					    $all_makes = get_terms('inventory-make', $makes_args);
					    if ($all_makes != '') {
						foreach ($all_makes as $makesitem) {
						    if (isset($makesitem->name) && isset($makesitem->slug)) {
							$makes_options[$makesitem->slug] = $makesitem->name;
						    }
						}
					    }
					    $automobile_opt_array = array(
						'std' => '',
						'id' => '',
						'cust_id' => 'inventory_make',
						'cust_name' => 'inventory_make',
						'options' => $makes_options,
						'classes' => 'chosen-select',
						'extra_atr' => 'data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_select_makes') . '"',
					    );
					    $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
					    ?>
					</div>
					<?php
					if ($inventory_search_hint_switch == 'yes') {
					    ?>
		    			<label><?php echo automobile_var_plugin_text_srt('automobile_var_inventories_selecting_make') ?></label>
					<?php } ?>
				    </div>
				</div>
				<?php
			    }
			    if ($location_field_switch == 'yes') {
				if (isset($automobile_var_plugin_options['automobile_search_location']) && $automobile_var_plugin_options['automobile_search_location'] == 'on') {
				    ?>
		    		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
					<?php if ($inventory_lable_switch == 'yes') { ?>
					    <span class="search_title"><?php echo automobile_var_plugin_text_srt('automobile_var_location') ?></span>
					<?php } ?>
		    		    <div class="select-location">
					    <?php
					    $automobile_radius = '';
					    if (isset($_GET['radius']) && $_GET['radius'] > 0) {
						$automobile_radius = $_GET['radius'];
					    }
					    $automobile_locatin_cust = automobile_location_convert();
					    $automobile_geo_location = isset($automobile_var_plugin_options['automobile_geo_location']) ? $automobile_var_plugin_options['automobile_geo_location'] : '';
					    $cookie_geo_loc = isset($_COOKIE['automobile_geo_loc']) ? $_COOKIE['automobile_geo_loc'] : '';
					    $cookie_geo_switch = isset($_COOKIE['automobile_geo_switch']) ? $_COOKIE['automobile_geo_switch'] : '';
					    if ($automobile_geo_location == 'on' && $cookie_geo_switch == 'on' && $cookie_geo_loc != '') {
						$automobile_locatin_cust = $cookie_geo_loc;
					    }
					    if (isset($_GET['location'])) {
						$automobile_locatin_cust = automobile_location_convert();
					    }
					    $automobile_loc_name = '';
					    $automobile_select_display = 'block';
					    $automobile_input_display = 'none';
					    $automobile_undo_display = 'none';
					    if ($automobile_locatin_cust != '') {
						$automobile_loc_name = ' name="location"';
						$automobile_select_display = 'none';
						$automobile_input_display = 'none';
						$automobile_undo_display = 'none';
					    }

					    $automobile_radius_switch = isset($automobile_var_plugin_options['automobile_radius_switch']) ? $automobile_var_plugin_options['automobile_radius_switch'] : '';
					    $min_value = 0;
					    $max_value = '';
					    if ($automobile_radius_switch == 'on') {
						$automobile_default_radius = isset($automobile_var_plugin_options['automobile_default_radius']) ? $automobile_var_plugin_options['automobile_default_radius'] : '';
						$automobile_radius_measure = isset($automobile_var_plugin_options['automobile_radius_measure']) ? $automobile_var_plugin_options['automobile_radius_measure'] : '';
						$automobile_radius_measure = $automobile_radius_measure == 'km' ? automobile_var_plugin_text_srt('automobile_var_km') : automobile_var_plugin_text_srt('automobile_var_miles');

						$min_value = isset($automobile_var_plugin_options['automobile_radius_min']) ? $automobile_var_plugin_options['automobile_radius_min'] : '';

						$max_value = isset($automobile_var_plugin_options['automobile_radius_max']) ? $automobile_var_plugin_options['automobile_radius_max'] : '';

						$radius_step = isset($automobile_var_plugin_options['automobile_radius_step']) ? $automobile_var_plugin_options['automobile_radius_step'] : '';

						// from submitted value
						$automobile_radius = preg_replace("/[^0-9,.]/", "", $automobile_radius);
						if ($automobile_radius == '') {
						    $automobile_radius = $automobile_default_radius;
						}
					    }
					    ?>
		    			<div id="cs-top-select-holder-location" class="select-location" data-locationadminurl="<?php echo esc_url(admin_url("admin-ajax.php")) ?>">
						<?php
						$location_title = '';
						if ($inventory_lable_switch == 'yes') {
						    $location_title = '<span>' . automobile_var_plugin_text_srt('automobile_var_desired_location') . '</span>';
						}
						if ($automobile_var_plugin_options['automobile_google_autocomplete_enable'] == 'on') {
						    automobile_get_custom_locationswith_google_auto('<div id="cs-top-select-holder" class="search-country" style="display:' . automobile_allow_special_char($automobile_select_display) . '"><div class="select-holder">', '</div>' . $location_title . ' </div>', false, true);
						} else {
						    automobile_get_custom_locations('<div id="cs-top-select-holder" class="search-country" style="display:' . automobile_allow_special_char($automobile_select_display) . '">', $location_title . '</div>');
						}
						$list_rand = rand(100000, 9999999);
						?>
		    			    <a id="location_redius_popup<?php echo absint($list_rand); ?>" href="javascript:void(0);" class="location-btn pop"><i class="icon-target3"></i></a>
						<?php
						if ($automobile_radius_switch == 'on') {
						    ?>
						    <div id="popup<?php echo absint($list_rand); ?>" style="display:none;"  class="select-popup">
							<a class="cs-location-close-popup" id="automobile_close<?php echo absint($list_rand); ?>"><i class="cs-color icon-times"></i></a>
							<p><?php echo automobile_var_plugin_text_srt('automobile_var_show_with_in'); ?></p>
							<input id="ex6<?php echo absint($list_rand); ?>" name="radius" type="text" data-slider-min="<?php echo absint($min_value); ?>" data-slider-max="<?php echo absint($max_value); ?>" data-slider-step="<?php echo absint($radius_step); ?>" data-slider-value="<?php echo absint($automobile_radius); ?>"/>
							<span id="ex6CurrentSliderValLabel_inventory"><span id="ex6SliderVal<?php echo absint($list_rand); ?>"><?php echo absint($automobile_radius); ?></span><?php echo esc_html($automobile_radius_measure); ?></span>
							<?php
							if ($automobile_geo_location == 'on' && automobile_server_protocol() == 'https://') {
							    ?>
			    				<p class="my-location"><?php echo automobile_var_plugin_text_srt('automobile_var_of'); ?> <i class="cs-color icon-location-arrow"></i>  <a class="cs-color" onclick="automobile_get_location(this)"><?php echo automobile_var_plugin_text_srt('automobile_var_my_location'); ?></a></p>
							    <?php
							}
							?>
						    </div>
						    <?php
						}
						?>
		    			</div>

		    			<input type="text" class="cs-geo-location form-control txt-field  geo-search-location" style="display:<?php echo esc_html($automobile_input_display) ?>;" <?php echo esc_html($automobile_loc_name) ?> value="<?php echo esc_html($automobile_locatin_cust) ?>" />
		    			<div class="cs-undo-select" style="display:<?php echo automobile_allow_special_char($automobile_undo_display) ?>;">
		    			    <i class="icon-times"></i>
		    			</div>
		    		    </div>
		    		</div>

		    		<script>
		    		    jQuery(document).ready(function () {
		    			automobile_page_settings();
		    		    });
		    		    jQuery(document).ajaxComplete(function () {
		    			automobile_page_settings();
		    		    });
		    		    function automobile_page_settings() {
		    			jQuery("#ex6<?php echo absint($list_rand); ?>").slider({});
		    			jQuery("#ex6<?php echo absint($list_rand); ?>").on("blur", function (slideEvt) {
		    			});
		    			jQuery("#ex6<?php echo absint($list_rand); ?>").on("slide", function (slideEvt) {
		    			    jQuery("#ex6SliderVal<?php echo absint($list_rand); ?>").text(slideEvt.value);
		    			});
		    			jQuery('#location_redius_popup<?php echo absint($list_rand); ?>').click(function (event) {
		    			    event.preventDefault();
		    			    jQuery("#popup<?php echo absint($list_rand); ?>").css('display', 'block') //to show
		    			    return false;
		    			});

		    			jQuery('#automobile_close<?php echo absint($list_rand); ?>').click(function () {
		    			    jQuery("#popup<?php echo absint($list_rand); ?>").css('display', 'none') //to hide
		    			    return false;
		    			});
		    		    }

		    		</script>					

				<?php } ?>
				<?php
			    }
			    if ($title_field_switch == 'yes' || $make_field_switch == 'yes' || $location_field_switch == 'yes') {
				?>
				<?php if (isset($atts['inventory_search_title_field_style']) && $atts['inventory_search_title_field_style'] == 'classic') { ?>
		    		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
				    <?php } else { ?>
		    		    <div class="col-lg-1 col-md-1 col-sm-3 col-xs-12">
					<?php } ?>
					<?php if ($inventory_lable_switch == 'yes') { ?>
		    			<span class="search_title">&nbsp;</span> 
					<?php } ?>  
                                        <?php $search_submit = (isset($inventory_search_style) and $inventory_search_style == "career")? '' : 'filters_search_btn'; ?>
					<div class="search-btn <?php echo $search_submit; ?>">
					    <?php if (isset($inventory_search_style) and $inventory_search_style == "career") { ?>
		    			    <button class="cs-bgcolor" onclick="document.getElementById('frm_inventories_filtration').submit();">
		    				<i class="<?php echo esc_html($search_icon); ?>"></i>
		    			    </button>
						<?php
					    } else {
						?>
		    			    <input type="submit" value="<?php
						if (isset($atts['inventory_search_title_field_style']) && $atts['inventory_search_title_field_style'] == 'classic') {

						    echo automobile_var_plugin_text_srt('automobile_var_search_inventory');
						} else {

						    echo automobile_var_plugin_text_srt('automobile_var_find_inventory');
						}
						?>" class=" cs-bgcolor">
						       <?php
						   }

						   ?>
					</div>
                                        <?php if ($inventory_advance_search_switch == 'yes') {
						       ?>
					   
		    			    <label>
		    				<a href="<?php echo esc_url($inventory_advance_search_url); ?>"  target="_blank">
						     <?php if (isset($atts['inventory_search_title_field_style']) && $atts['inventory_search_title_field_style'] == 'classic') { ?>
							<?php echo automobile_var_plugin_text_srt('automobile_var_advance_search_classic'); ?>
						     <?php } else{ ?>
							<?php echo automobile_var_plugin_text_srt('automobile_var_advance_search'); ?> 
						   <?php  } ?>
		    				</a>
		    			    </label>
					   
					    <?php } ?>
				    </div>
				<?php } ?>
	    		</div>
	    		</form>
			    <?php
			} else {
			    if (isset($full_view) && $full_view == true) {
				?>
				<div class="container">
				<?php }
				?><h2><?php echo automobile_var_plugin_text_srt('automobile_var_please_follow'); ?></h2><?php
				if (isset($full_view) && $full_view == true) {
				    ?></div><?php
			    }
			}
			?>

			<!--            </div>-->
		    </div>
		    <?php
		    $eventpost_data = ob_get_clean();
		    return $eventpost_data;
		}

		add_shortcode('automobile_inventories_search', 'automobile_inventory_search_box');
	    }

	    if (!function_exists('automobile_inventory_search_box_makes')) {

		function automobile_inventory_search_box_makes() {
		    global $automobile_form_fields, $automobile_var_plugin_static_text;
		    $inventory_type_slug = isset($_POST['inventory_type_slug']) ? $_POST['inventory_type_slug'] : '';
		    $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
		    $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

		    $automobile_var_get_makes = get_post_meta($inventory_type_id, 'automobile_inventory_type_makes', true);

		    $makes_options = array();
		    $makes_options[''] = automobile_var_plugin_text_srt('automobile_var_select_makes');

		    if (is_array($automobile_var_get_makes) && sizeof($automobile_var_get_makes) > 0) {
			foreach ($automobile_var_get_makes as $inv_make) {
			    $automobile_make = get_term_by('slug', $inv_make, 'inventory-make');
			    if (is_object($automobile_make)) {
				$makes_options[$automobile_make->slug] = $automobile_make->name;
			    }
			}
		    }
		    $automobile_opt_array = array(
			'std' => '',
			'id' => '',
			'cust_id' => 'inventory_make',
			'cust_name' => 'inventory_make',
			'options' => $makes_options,
			'return' => true,
			'classes' => 'chosen-select',
			'extra_atr' => 'data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_select_makes') . '"',
		    );
		    $html = $automobile_form_fields->automobile_form_select_render($automobile_opt_array);

		    $html .= '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';

		    echo json_encode(array('mark' => $html));
		    die;
		}

	    }
	    add_action('wp_ajax_automobile_inventory_search_box_makes', 'automobile_inventory_search_box_makes');
	    add_action('wp_ajax_nopriv_automobile_inventory_search_box_makes', 'automobile_inventory_search_box_makes');
	    