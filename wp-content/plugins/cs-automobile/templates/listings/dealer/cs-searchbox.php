<?php
/**
 * Inventorys Listing search box
 *
 */
global $wpdb, $automobile_var_plugin_options, $automobile_form_fields, $cus_field_mypost;
$popup_randid = $list_rand = rand(0, 499999999);
$a['automobile_dealer_searchbox_title_top'] = isset($a['automobile_dealer_searchbox_title_top']) ? $a['automobile_dealer_searchbox_title_top'] : '';
?>

<div class="section-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="cs-agent-filters">
        <span class="cs-filters-title"><?php echo esc_html($a['automobile_dealer_searchbox_title_top']) ?></span>
        <div class="row">

            <form  method="get" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php')); ?>" id="frm_dealer_type_list<?php echo esc_html($list_rand); ?>">
                <div class="cs-agent-filtration">
		    <?php
		    $final_query_str = str_replace("?", "", $qrystr);
		    $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'automobile_dealer_name', 'no');
		    $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'radius', 'no');
		    $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'location', 'no');
		    $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'dealer_type', 'no');
		    $final_query_str = str_replace("?", "", $final_query_str);

		    //// Making hidden fields
		    $query_str = explode('&', $final_query_str);
		    foreach ($query_str as $param) {
			if (!empty($param)) {
			    list($name, $value) = explode('=', $param);
			    if (is_array($name)) {
				$name . "[]";
			    }
			    $automobile_opt_array = array(
				'id' => '',
				'std' => $value,
				'cust_id' => "",
				'cust_name' => $name,
				'classes' => '',
			    );
			    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
			}
		    }
		    ?>
                    <!-- end extra query string -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="cs-select-dropdown">
                            <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_find_top_dealer')); ?></label>
			    <?php
			    $automobile_opt_array = array(
				'std' => esc_attr($automobile_dealer_name),
				'id' => '',
				'classes' => 'txt-field side-location-field',
				'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_find_top_dealer')) . '"',
				'cust_id' => 'automobile_dealer_name',
				'cust_name' => 'automobile_dealer_name',
				'required' => false
			    );
			    $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
			    ?>
                        </div>
                    </div>

                    <!-- location with radius -->
		    <?php if (isset($automobile_var_plugin_options['automobile_search_location']) && $automobile_var_plugin_options['automobile_search_location'] == 'on') { ?>

    		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    			<div class="select-location">
    			    <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_select_location')); ?></label>
				<?php
				//cs-select-location

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
				    $automobile_input_display = 'block';
				    $automobile_undo_display = 'block';
				}

				$automobile_radius_switch = isset($automobile_var_plugin_options['automobile_radius_switch']) ? $automobile_var_plugin_options['automobile_radius_switch'] : '';
				$min_value = 0;
				$max_value = '';
				if ($automobile_radius_switch == 'on') {
				    $automobile_default_radius = isset($automobile_var_plugin_options['automobile_default_radius']) ? $automobile_var_plugin_options['automobile_default_radius'] : '';
				    $automobile_radius_measure = isset($automobile_var_plugin_options['automobile_radius_measure']) ? $automobile_var_plugin_options['automobile_radius_measure'] : '';
				    $automobile_radius_measure = $automobile_radius_measure == 'km' ? esc_html(automobile_var_plugin_text_srt('automobile_var_km')) : esc_html(automobile_var_plugin_text_srt('automobile_var_miles'));

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
				    if ($automobile_var_plugin_options['automobile_google_autocomplete_enable'] == 'on') {
					automobile_get_custom_locationswith_google_auto('<div id="cs-top-select-holder" class="search-country" style="display:' . automobile_allow_special_char($automobile_select_display) . '"><div class="select-holder">', '</div><small>' . esc_html(automobile_var_plugin_text_srt('automobile_var_city_state_country')) . '</small> </div>', false, true);
				    } else {
					automobile_get_custom_locations('<div id="cs-top-select-holder" class="search-country" style="display:' . automobile_allow_special_char($automobile_select_display) . '">', '<small>' . esc_html(automobile_var_plugin_text_srt('automobile_var_city_state_country')) . '</small> </div>');
				    }
				    ?>
    				<a id="location_redius_popup<?php echo absint($list_rand); ?>" href="javascript:void(0);" class="location-btn pop">
					<?php if ('on' == $automobile_geo_location || 'on' == $automobile_radius_switch) { ?>
					    <i class="icon-location_searching"></i>
					<?php } ?>
    				</a>
				    <?php if ($automobile_radius_switch == 'on' || $automobile_geo_location == 'on') { ?>
					<div id="popup<?php echo absint($list_rand); ?>" style="display:none;"  class="select-popup">
					    <a class="cs-location-close-popup" id="automobile_close<?php echo absint($list_rand); ?>"><i class="cs-color icon-times"></i></a>
					    <?php if ($automobile_radius_switch == 'on') { ?>
	    				    <p><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_show_with_in')); ?></p>
	    				    <input id="ex6<?php echo absint($list_rand); ?>" name="radius" type="text" data-slider-min="<?php echo absint($min_value); ?>" data-slider-max="<?php echo absint($max_value); ?>" data-slider-step="<?php echo absint($radius_step); ?>" data-slider-value="<?php echo absint($automobile_radius); ?>"/>
	    				    <span id="ex6CurrentSliderValLabel_inventory"><span id="ex6SliderVal<?php echo absint($list_rand); ?>"><?php echo absint($automobile_radius); ?></span><?php echo esc_html($automobile_radius_measure); ?></span>
						<?php
					    }
					    ?>
					    <?php
					    if ($automobile_geo_location == 'on') {
						?>
	    				    <p class="my-location"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_of')); ?><i class="cs-color icon-location-arrow"></i><a class="cs-color" onclick="automobile_get_location(this)"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_my_location')); ?></a></p>
						<?php
					    }
					    ?>
					</div>
				    <?php } ?>
    			    </div>

				<?php
				$automobile_form_fields->automobile_form_text_render(
					array(
					    'id' => '',
					    'classes' => 'cs-geo-location  txt-field geo-search-location',
					    'cust_name' => $automobile_loc_name,
					    'extra_atr' => ' onchange="this.form.submit()" style="display:' . automobile_allow_special_char($automobile_input_display) . ';" ' . $automobile_loc_name,
					    'std' => $automobile_locatin_cust,
					)
				);
				?>

    			    <div class="cs-undo-select" style="display:<?php echo automobile_allow_special_char($automobile_undo_display) ?>;">
    				<i class="icon-times"></i>
    			    </div>
    			</div>


    		    </div>

			<?php
		    }
		    ?>


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="select-dropdown">
                            <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_dealer_type')); ?></label>
			    <?php
			    $dealer_type_options = array();
			    $dealer_type_options[''] = esc_html( automobile_var_plugin_text_srt( 'automobile_var_all_dealer_type' ) );
			    $dealer_type_args = array(
				'orderby' => 'name',
				'order' => 'ASC',
				'number' => '',
				'fields' => 'all',
				'slug' => '',
				'hide_empty' => false,
				'parent' => '0',
			    );
// get all inventory types
			    $all_dealer_type = get_terms('dealer_type', $dealer_type_args);
			    if ($all_dealer_type != '') {
				foreach ($all_dealer_type as $dealer_typeitem) {
				    if (isset($dealer_typeitem->name) && isset($dealer_typeitem->slug)) {
					$dealer_type_options[$dealer_typeitem->slug] = $dealer_typeitem->name;
				    }
				}
			    }
			    $automobile_opt_array = array(
				'std' => esc_html($automobile_dealer_type),
				'id' => '',
				'cust_id' => 'dealer_type',
				'cust_name' => 'dealer_type',
				'options' => $dealer_type_options,
				'classes' => 'chosen-select',
				'extra_atr' => 'data-placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_all_dealer_type')) . '"',
			    );
			    $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
			    ?>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="cs-search-btn">
			    <div class="search-form">
				<?php
				$automobile_opt_array = array(
				    'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_refine_search')),
				    'id' => '',
				    'classes' => '',
				    'extra_atr' => '',
				    'cust_id' => '',
				    'cust_name' => '',
				    'cust_type' => 'submit',
				);
				$automobile_form_fields->automobile_form_text_render($automobile_opt_array);
				?>
			    </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    $automobile_dealer_cus_fields = get_option("automobile_dealer_cus_fields");
    if (is_array($automobile_dealer_cus_fields) && sizeof($automobile_dealer_cus_fields) > 0) {
	?>
        <div class="cs-listing-filters">

    	<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
    	    <div class="cs-filter-title"><h6><a class="cs-expand-filters" href="javascript:void(0);"><i class="icon-minus8"></i> <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_colapse_all_filters')); ?></a></h6></div>

		<?php
		$custom_field_flag = 11;
		foreach ($automobile_dealer_cus_fields as $cus_fieldvar => $cus_field) {
		    $all_item_empty = 0;
		    if (isset($cus_field['options']['value']) && is_array($cus_field['options']['value'])) {
			foreach ($cus_field['options']['value'] as $cus_field_options_value) {

			    if ($cus_field_options_value != '') {
				$all_item_empty = 0;
				break;
			    } else {
				$all_item_empty = 1;
			    }
			}
		    }
		    if (isset($cus_field['enable_srch']) && $cus_field['enable_srch'] == 'yes' && ($all_item_empty == 0)) {
			$query_str_var_name = $cus_field['meta_key'];
			$collapse_condition = 'no';
			if (isset($cus_field['collapse_search'])) {
			    $collapse_condition = $cus_field['collapse_search'];
			}

			// get count array for this itration 
			$count_filtration = $cus_fields_count_arr;
			$filter_new_arr = '';
			if (isset($count_filtration[$query_str_var_name])) {
			    unset($count_filtration[$query_str_var_name]);
			    $filter_temp_arr = $count_filtration;

			    foreach ($filter_temp_arr as $var => $value) {
				$filter_new_arr[] = $value;
			    }
			} else {
			    if (isset($count_filtration) && $count_filtration != '') {
				foreach ($count_filtration as $var => $value) {
				    $filter_new_arr[] = $value;
				}
			    }
			}
			// get alll metapost ids by meta filteration
			$filter_new_arr = isset($filter_new_arr) && !empty($filter_new_arr) ? call_user_func_array('array_merge', $filter_new_arr) : '';
			$meta_post_ids_cus_fields_arr = '';
			$meta_post_dealer_name_id_condition = '';
			if (!empty($filter_new_arr)) {
			    // GET CUSTOM FIELDS POST ID
			    $meta_post_ids_cus_fields_arr = automobile_get_query_whereclase_by_array($filter_new_arr);
			    // if it returns the empty array
			    if (empty($meta_post_ids_cus_fields_arr)) {
				$meta_post_ids_cus_fields_arr = array(0);
			    }
			    $ids = $meta_post_ids_cus_fields_arr != '' ? implode(",", $meta_post_ids_cus_fields_arr) : '0';
			    $meta_post_dealer_name_id_condition = " ID in (" . $ids . ") AND ";
			}
			?>
	    	    <div class="panel panel-default" id="panel-default-<?php echo esc_html($custom_field_flag); ?>">

	    		<div class="panel-heading" role="tab" id="heading-<?php echo esc_html($custom_field_flag); ?>"> 
	    		    <a class="<?php
				if ($collapse_condition == 'yes') {
				    echo 'collapsed';
				}
				?>" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo esc_html($custom_field_flag); ?>" role="button" >
				       <?php echo esc_html($cus_field['label']); ?>
	    		    </a> 
	    		</div>
	    		<div id="collapse<?php echo esc_html($custom_field_flag); ?>"  role="tabpanel" aria-labelledby="heading-<?php echo esc_html($custom_field_flag); ?>" class="panel-collapse collapse <?php
			    if ($collapse_condition != 'yes') {
				echo 'in';
			    }
			    ?>">
	    		    <div class="panel-body">

				    <?php
				    if ($cus_field['type'] == 'dropdown') {
					$_query_string_arr = getMultipleParameters();
					?>
					<div class="cs-select-transmission">
					    <form action="#" method="get" name="frm_<?php echo str_replace(" ", "_", str_replace("-", "_", $query_str_var_name)); ?>">
						<ul class="cs-checkbox-list">
						    <?php
						    // parse query string and create hidden fileds
						    $final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
						    $final_query_str = str_replace("?", "", $final_query_str);
						    parse_str($final_query_str, $_query_str_arr);
						    foreach ($_query_str_arr as $_query_str_single_var => $_query_str_single_value) {
							if (is_array($_query_str_single_value)) {
							    foreach ($_query_str_single_value as $_query_str_single_value_arr) {
								echo '<li>';
								$automobile_form_fields->automobile_form_hidden_render(
									array(
									    'name' => '',
									    'id' => '',
									    'cust_id' => $_query_str_single_var . '[]',
									    'cust_name' => $_query_str_single_var . '[]',
									    'classes' => '',
									    'std' => $_query_str_single_value_arr,
									    'description' => '',
									    'hint' => ''
									)
								);
								echo '</li>';
							    }
							} else {
							    echo '<li>';
							    $automobile_form_fields->automobile_form_hidden_render(
								    array(
									'name' => '',
									'id' => '',
									'cust_id' => $_query_str_single_var,
									'cust_name' => $_query_str_single_var,
									'classes' => '',
									'std' => $_query_str_single_value,
									'description' => '',
									'hint' => ''
								    )
							    );
							    echo '</li>';
							}
						    }
						    $number_option_flag = 1;
						    $cut_field_flag = 0;
						    foreach ($cus_field['options']['value'] as $cus_field_options_value) {
							// if option label or value is empty then move on next ittration
							if ($cus_field['options']['value'][$cut_field_flag] == '' || $cus_field['options']['label'][$cut_field_flag] == '') {
							    $cut_field_flag ++;
							    continue;
							}
							if ($cus_field_options_value != '') {
							    if ($cus_field['multi'] == 'yes') {
								$dropdown_arr = '';
								if ($cus_field['post_multi'] == 'yes') {
								    $dropdown_arr = array(
									'key' => $query_str_var_name,
									'value' => serialize($cus_field_options_value),
									'compare' => 'Like',
								    );
								} else {
								    $dropdown_arr = array(
									'key' => $query_str_var_name,
									'value' => $cus_field_options_value,
									'compare' => '=',
								    );
								}

								if ($automobile_dealer_name != '') {

								    $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $meta_post_dealer_name_id_condition . " UCASE(display_name) LIKE '%$automobile_dealer_name%'");
								    if ($post_ids) {
									$cus_field_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
									    'include' => $post_ids,
									    'meta_query' => array(
										array(
										    'key' => 'automobile_user_status',
										    'value' => 'active',
										    'compare' => '=',
										),
										array(
										    'key' => 'automobile_allow_search',
										    'value' => 'yes',
										    'compare' => '=',
										),
										array(
										    'key' => 'automobile_user_last_activity_date',
										    'value' => strtotime(date($automobile_dealer_activity_date_formate)),
										    'compare' => '<=',
										),
										$dropdown_arr,
									    )
									);
								    }
								} else {
								    $cus_field_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
									'include' => $meta_post_ids_cus_fields_arr,
									'meta_query' => array(
									    array(
										'key' => 'automobile_user_status',
										'value' => 'active',
										'compare' => '=',
									    ),
									    array(
										'key' => 'automobile_allow_search',
										'value' => 'yes',
										'compare' => '=',
									    ),
									    array(
										'key' => 'automobile_user_last_activity_date',
										'value' => strtotime(date($automobile_dealer_activity_date_formate)),
										'compare' => '<=',
									    ),
									    $dropdown_arr,
									)
								    );
								}
								$cus_field_loop_count = new WP_User_Query($cus_field_mypost);

								$cus_field_count_post = $cus_field_loop_count->total_users;

								if (isset($_query_string_arr[$query_str_var_name]) && isset($cus_field_options_value) && is_array($_query_string_arr[$query_str_var_name]) && in_array($cus_field_options_value, $_query_string_arr[$query_str_var_name])) {

								    $form_field_array = array(
									'id' => '',
									'cust_name' => $query_str_var_name,
									'cust_id' => $query_str_var_name . '_' . $number_option_flag,
									'classes' => '',
									'std' => $cus_field_options_value,
									'extra_atr' => ' onclick="automobile_listing_content_load();" checked="checked" onchange="javascript:frm_' . str_replace(" ", "_", str_replace("-", "_", $query_str_var_name)) . '.submit();"',
									'simple' => true,
									'return' => true,
								    );

								    echo '<li class="checkbox" >' . $automobile_form_fields->automobile_form_checkbox_render($form_field_array) . '
							<label for="' . $query_str_var_name . '_' . $number_option_flag . '">' . $cus_field['options']['label'][$cut_field_flag] . '<span>(' . $cus_field_count_post . ')</span></label></li>';
								} else {
								    $form_field_array = array(
									'id' => '',
									'cust_name' => $query_str_var_name,
									'cust_id' => $query_str_var_name . '_' . $number_option_flag,
									'classes' => '',
									'std' => $cus_field_options_value,
									'extra_atr' => ' onclick="automobile_listing_content_load();" onchange="javascript:frm_' . str_replace(" ", "_", str_replace("-", "_", $query_str_var_name)) . '.submit();" ',
									'simple' => true,
									'return' => true,
								    );
								    echo '<li class="checkbox" >' . $automobile_form_fields->automobile_form_checkbox_render($form_field_array) . '
							<label for="' . $query_str_var_name . '_' . $number_option_flag . '">' . $cus_field['options']['label'][$cut_field_flag] . '<span>(' . $cus_field_count_post . ')</span></label></li>';
								}
								?>

								<?php
							    } else {

								$dropdown_arr = '';
								if ($cus_field['post_multi'] == 'yes') {
								    $dropdown_arr = array(
									'key' => $query_str_var_name,
									'value' => serialize($cus_field_options_value),
									'compare' => 'Like',
								    );
								} else {
								    $dropdown_arr = array(
									'key' => $query_str_var_name,
									'value' => $cus_field_options_value,
									'compare' => '=',
								    );
								}

								if ($automobile_dealer_name != '') {

								    $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $meta_post_dealer_name_id_condition . " UCASE(display_name) LIKE '%$automobile_dealer_name%'");
								    if ($post_ids) {
									$cus_field_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
									    'include' => $post_ids,
									    'meta_query' => array(
										array(
										    'key' => 'automobile_user_status',
										    'value' => 'active',
										    'compare' => '=',
										),
										array(
										    'key' => 'automobile_allow_search',
										    'value' => 'yes',
										    'compare' => '=',
										),
										array(
										    'key' => 'automobile_user_last_activity_date',
										    'value' => strtotime(date($automobile_dealer_activity_date_formate)),
										    'compare' => '<=',
										),
										$dropdown_arr,
									    )
									);
								    }
								} else {
								    $cus_field_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
									'include' => $meta_post_ids_cus_fields_arr,
									'meta_query' => array(
									    array(
										'key' => 'automobile_user_status',
										'value' => 'active',
										'compare' => '=',
									    ),
									    array(
										'key' => 'automobile_allow_search',
										'value' => 'yes',
										'compare' => '=',
									    ),
									    array(
										'key' => 'automobile_user_last_activity_date',
										'value' => strtotime(date($automobile_dealer_activity_date_formate)),
										'compare' => '<=',
									    ),
									    $dropdown_arr,
									)
								    );
								}
								$cus_field_loop_count = new WP_User_Query($cus_field_mypost);
								$cus_field_count_post = $cus_field_loop_count->total_users;
								$amp_sign = '';
								if (automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name) != '?')
								    $amp_sign = '&';
								if (isset($_GET[$query_str_var_name]) && $_GET[$query_str_var_name] == $cus_field_options_value) {

								    echo '<li><a onclick="automobile_listing_content_load();" class="text-capitalize active" href="' . automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name) . '">' . $cus_field['options']['label'][$cut_field_flag] . ' <span>(' . $cus_field_count_post . ')</span> </a></li>';
								} else {
								    echo '<li><a onclick="automobile_listing_content_load();" class="text-capitalize " href="' . automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name) . $amp_sign . $query_str_var_name . '=' . $cus_field_options_value . '">' . $cus_field['options']['label'][$cut_field_flag] . ' <span>(' . $cus_field_count_post . ')</span></a></li>';
								}
							    }
							}
							$number_option_flag ++;
							$cut_field_flag ++;
						    }
						    ?>
						</ul>
					    </form>
					</div>
					<?php
				    } else if ($cus_field['type'] == 'text' || $cus_field['type'] == 'email' || $cus_field['type'] == 'url') {
					?>
					<div class="cs-select-transmission">
					    <form action="#" method="get" name="frm_<?php echo esc_html($query_str_var_name); ?>">
						<?php
						// parse query string and create hidden fileds
						$final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
						$final_query_str = str_replace("?", "", $final_query_str);
						parse_str($final_query_str, $_query_str_arr);
						foreach ($_query_str_arr as $_query_str_single_var => $_query_str_single_value) {
						    if (is_array($_query_str_single_value)) {
							foreach ($_query_str_single_value as $_query_str_single_value_arr) {
							    $automobile_form_fields->automobile_form_hidden_render(
								    array(
									'name' => '',
									'id' => "' . $_query_str_single_var . '[]",
									'classes' => '',
									'std' => "' . $_query_str_single_value_arr . '",
									'description' => '',
									'hint' => ''
								    )
							    );
							}
						    } else {
							$automobile_form_fields->automobile_form_hidden_render(
								array(
								    'name' => '',
								    'id' => "' . $_query_str_single_var . '",
								    'classes' => '',
								    'std' => "' . $_query_str_single_value . '",
								    'description' => '',
								    'hint' => ''
								)
							);
						    }
						}
						$automobile_query = isset($_GET[$query_str_var_name]) ? $_GET[$query_str_var_name] : '';

						$automobile_form_fields->automobile_form_text_render(
							array(
							    'id' => $query_str_var_name,
							    'cust_name' => $query_str_var_name,
							    'extra_atr' => ' onclick="automobile_listing_content_load();" onchange="javascript:frm_' . str_replace(" ", "_", str_replace("-", "_", $query_str_var_name)) . '.submit();"',
							    'std' => $automobile_query,
							    'classes' => '',
							)
						);
						?>

					    </form>
					</div>
					<?php
				    } else if ($cus_field['type'] == 'date') {

					$cus_field_date_formate_arr = explode(" ", $cus_field['date_format']);
					?>
					<script>
		                            jQuery(function () {
		                                jQuery("#automobile_<?php echo esc_html($query_str_var_name); ?>").datetimepicker({
		                                    format: "<?php echo esc_html($cus_field_date_formate_arr[0]); ?>",
		                                    timepicker: false
		                                });
		                            });
					</script>
					<div class="cs-select-transmission">
					    <form action="#" method="get" name="frm_<?php echo esc_html($query_str_var_name); ?>">
						<?php
						// parse query string and create hidden fileds
						$final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
						$final_query_str = str_replace("?", "", $final_query_str);
						parse_str($final_query_str, $_query_str_arr);
						foreach ($_query_str_arr as $_query_str_single_var => $_query_str_single_value) {
						    if (is_array($_query_str_single_value)) {
							foreach ($_query_str_single_value as $_query_str_single_value_arr) {
							    $_GET[$query_str_var_name] = isset($_GET[$query_str_var_name]) ? $_GET[$query_str_var_name] : '';
							    $automobile_form_fields->automobile_form_hidden_render(
								    array(
									'name' => '',
									'id' => $_query_str_single_var . '[]',
									'classes' => '',
									'std' => $_query_str_single_value_arr,
									'description' => '',
									'hint' => ''
								    )
							    );
							}
						    } else {
							$automobile_query = isset($_GET[$query_str_var_name]) ? $_GET[$query_str_var_name] : '';

							$automobile_form_fields->automobile_form_hidden_render(
								array(
								    'name' => '',
								    'id' => $_query_str_single_var,
								    'classes' => '',
								    'std' => $_query_str_single_value,
								    'description' => '',
								    'hint' => ''
								)
							);
						    }
						}
						$automobile_query = isset($_GET[$query_str_var_name]) ? $_GET[$query_str_var_name] : '';

						$automobile_form_fields->automobile_form_text_render(
							array(
							    'id' => $query_str_var_name,
							    'cust_name' => $query_str_var_name,
							    'extra_atr' => ' onclick="automobile_listing_content_load();" onchange="javascript:frm_' . str_replace(" ", "_", str_replace("-", "_", $query_str_var_name)) . '.submit();"',
							    'std' => $automobile_query,
							    'classes' => '',
							)
						);
						?>

					    </form>
					</div>
					<?php
				    } elseif ($cus_field['type'] == 'range') {

					$range_min = $cus_field['min'];
					$range_max = $cus_field['max'];
					$range_increment = $cus_field['increment'];
					$filed_type = $cus_field['srch_style']; //input, slider, input_slider
					$filed_type_arr = explode(",", $filed_type);
					$range_flag = 0;
					while (count($filed_type_arr) > $range_flag) {
					    if ($filed_type_arr[$range_flag] == 'input') { // if input style
						echo '<ul>';
						while ($range_min < $range_max) {

						    ############ get count for this itration ##########
						    if ($automobile_dealer_name != '') {

							$post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $meta_post_dealer_name_id_condition . " UCASE(display_name) LIKE '%$automobile_dealer_name%'" . $alphabatic_qrystr);
							if ($post_ids) {
							    $cus_field_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
								'include' => $post_ids,
								'meta_query' => array(
								    array(
									'key' => 'automobile_user_status',
									'value' => 'active',
									'compare' => '=',
								    ),
								    array(
									'key' => 'automobile_allow_search',
									'value' => 'yes',
									'compare' => '=',
								    ),
								    array(
									'key' => 'automobile_user_last_activity_date',
									'value' => strtotime(date($automobile_dealer_activity_date_formate)),
									'compare' => '<=',
								    ),
								    array(
									'key' => $query_str_var_name,
									'value' => $range_min,
									'compare' => '>=',
									'type' => 'NUMERIC'
								    ),
								    array(
									'key' => $query_str_var_name,
									'value' => $range_min + $range_increment,
									'compare' => '<=',
									'type' => 'NUMERIC'
								    ),
								    $location_condition_arr,
								)
							    );
							}
						    } else {
							$post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $meta_post_dealer_name_id_condition . " 1=1 " . $alphabatic_qrystr);
							if ($post_ids) {
							    $cus_field_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
								'include' => $post_ids,
								'meta_query' => array(
								    array(
									'key' => 'automobile_user_status',
									'value' => 'active',
									'compare' => '=',
								    ),
								    array(
									'key' => 'automobile_allow_search',
									'value' => 'yes',
									'compare' => '=',
								    ),
								    array(
									'key' => 'automobile_user_last_activity_date',
									'value' => strtotime(date($automobile_dealer_activity_date_formate)),
									'compare' => '<=',
								    ),
								    array(
									'key' => $query_str_var_name,
									'value' => $range_min,
									'compare' => '>=',
									'type' => 'NUMERIC'
								    ),
								    array(
									'key' => $query_str_var_name,
									'value' => $range_min + $range_increment,
									'compare' => '<=',
									'type' => 'NUMERIC'
								    ),
								    $location_condition_arr,
								)
							    );
							}
						    }

						    $cus_field_loop_count = new WP_User_Query($cus_field_mypost);
						    $cus_field_count_post = $cus_field_loop_count->total_users;
						    ?>
			    			<li>
			    			    <a  <?php
							if (isset($_GET[$query_str_var_name]) && $_GET[$query_str_var_name] == ($range_min . "," . ($range_min + $range_increment))) {
							    echo 'class="active"';
							}
							?>href="<?php
							    if (isset($_GET[$query_str_var_name]) && $_GET[$query_str_var_name] == ($range_min . "," . ($range_min + $range_increment))) {
								echo (automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name, 'no'));
							    } else {
								$qry_new_var = (automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name, 'no')) . "&";
								if ($qry_new_var == '&') {
								    $qry_new_var = '?';
								}
								echo ($qry_new_var . $query_str_var_name . '=' . $range_min . "," . ($range_min + $range_increment));
							    }
							    ?>" onclick="automobile_listing_content_load();"><?php
								echo absint($range_min);
								echo " - ";
								echo absint($range_min + $range_increment);
								?> <span><?php echo '(' . $cus_field_count_post . ')'; ?></span><?php
							    if (isset($_GET[$query_str_var_name]) && $_GET[$query_str_var_name] == ($range_min . "-" . ($range_min + $range_increment))) {
								echo ' ';
							    }
							    ?></a>
			    			</li><?php
						    $range_min = $range_min + $range_increment;
						}
						echo '</ul>';
					    } elseif ($filed_type_arr[$range_flag] == 'slider') { // if slider style
						?>
						<div class="cs-price-range">
						    <form action="#" method="get" name="frm_<?php echo esc_html($query_str_var_name); ?>" id="frm_<?php echo esc_html($query_str_var_name); ?>">
							<?php
							// parse query string and create hidden fileds
							$final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
							$final_query_str = str_replace("?", "", $final_query_str);
							parse_str($final_query_str, $_query_str_arr);
							foreach ($_query_str_arr as $_query_str_single_var => $_query_str_single_value) {
							    if (is_array($_query_str_single_value)) {
								foreach ($_query_str_single_value as $_query_str_single_value_arr) {
								    $automobile_form_fields->automobile_form_hidden_render(
									    array(
										'name' => '',
										'id' => $_query_str_single_var . '[]',
										'classes' => '',
										'std' => $_query_str_single_value_arr,
										'description' => '',
										'hint' => ''
									    )
								    );
								}
							    } else {
								$automobile_form_fields->automobile_form_hidden_render(
									array(
									    'name' => '',
									    'id' => $_query_str_single_var,
									    'classes' => '',
									    'std' => $_query_str_single_value,
									    'description' => '',
									    'hint' => ''
									)
								);
							    }
							}
							$range_complete_str_first = "";
							$range_complete_str_second = "";
							if (isset($_GET[$query_str_var_name])) {
							    $range_complete_str = $_GET[$query_str_var_name];
							    $range_complete_str_arr = explode(",", $range_complete_str);
							    $range_complete_str_first = isset($range_complete_str_arr[0]) ? $range_complete_str_arr[0] : '';
							    $range_complete_str_second = isset($range_complete_str_arr[1]) ? $range_complete_str_arr[1] : '';
							} else {
							    $range_complete_str = '';
							    if (isset($_GET[$query_str_var_name]))
								$range_complete_str = $_GET[$query_str_var_name];
							    $range_complete_str_first = $cus_field['min'];
							    $range_complete_str_second = $cus_field['max'];
							}
							echo '<div class="cs-selector-range">
                                                                <input name="' . $query_str_var_name . '" onchange="range_form_submit' . $cus_fieldvar . '();" id="slider-range' . esc_html($query_str_var_name) . '" type="text" class="span2" value="" data-slider-min="' . $cus_field['min'] . '" data-slider-max="' . $cus_field['max'] . '" data-slider-step="5" data-slider-value="[' . $range_complete_str_first . ',' . $range_complete_str_second . ']" />
                                                                       <div class="selector-value">
                                                                        <span>' . $cus_field['min'] . '</span>
                                                                        <span class="pull-right">' . $cus_field['max'] . '</span>
                                                                       </div>
                                                               </div>';
							?>
						    </form>
						</div>
						<?php
						echo '<script>
                                                    function range_form_submit' . $cus_fieldvar . '(){
                                                        automobile_listing_content_load();
                                                        jQuery("#frm_' . esc_html($query_str_var_name) . '").submit();
                                                    }
                                                    jQuery(document).ready(function(){
                                                            jQuery("#slider-range' . esc_html($query_str_var_name) . '").slider({
                                                        });
                                                    });

                                                    </script>';
					    }
					    $range_flag ++;
					}
				    }
				    ?>

	    		    </div>
	    		</div>
	    	    </div><?php
		    }
		    $custom_field_flag ++;
		}
		?>
    	</div>
        </div>
    <?php } ?>
</div>

<script>
    jQuery(document).ready(function () {
        jQuery(".btn-primary").click(function () {
            jQuery(".collapse").collapse('toggle');
        });

        jQuery(document).on('click', '.cs-expand-filters', function () {
            if (jQuery(this).hasClass('cs-colapse')) {
                jQuery(".collapse").collapse('hide');
                jQuery(this).html('<i class="icon-plus8"></i> <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_expand_all_filters')) ?>');
                jQuery(this).removeClass('cs-colapse');

            } else {
                jQuery(".collapse").collapse('show');
                jQuery(this).html('<i class="icon-minus8"></i> <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_colapse_all_filters')) ?>');
                jQuery(this).addClass('cs-colapse');
            }
        });

        jQuery("#ex6<?php echo absint($popup_randid); ?>").slider();
        jQuery("#ex6<?php echo absint($popup_randid); ?>").on("slide", function (slideEvt) {

            jQuery("#ex6SliderVal<?php echo absint($popup_randid); ?>").text(slideEvt.value);
        });
        jQuery('#location_redius_popup<?php echo absint($popup_randid); ?>').click(function (event) {

            event.preventDefault();

            jQuery("#popup<?php echo absint($popup_randid); ?>").css('display', 'block') //to show
            return false;
        });

        jQuery('#automobile_close<?php echo absint($popup_randid); ?>').click(function () {
            jQuery("#popup<?php echo absint($popup_randid); ?>").css('display', 'none') //to show
            return false;
        });


    });
</script>