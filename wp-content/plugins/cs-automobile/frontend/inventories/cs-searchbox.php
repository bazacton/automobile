<?php
/**
 * Inventoriess Listing search box
 *
 */
global $wpdb, $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text;
$automobile_var_makes = automobile_var_plugin_text_srt('automobile_var_makes');

$automobile_rand_num = rand(123456789, 987654321);
$popup_randid = rand(0, 499999999);
?>

<aside id="cs-automobile-inv-filters" class="section-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')) ?>">
    <div class="cs-listing-filters">
        <?php
        $final_query_str = str_replace("?", "", $qrystr);
        $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'location', 'no');
        $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'inventory_title', 'no');
        $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'radius', 'no');
        $final_query_str = str_replace("?", "", $final_query_str);
        $query = explode('&', $final_query_str);
        $automobile_inv_get_type = isset($_REQUEST['inventory_type']) ? $_REQUEST['inventory_type'] : '';
		if(!isset($_REQUEST['inventory_type'])){
			if(isset($automobile_var_plugin_options['automobile_default_inventory_type'])){
				$automobile_inv_get_type = ($automobile_inv_get_type!='') ? $automobile_inv_get_type : $automobile_var_plugin_options['automobile_default_inventory_type'];
			}
		}
		
        $inventory_make = '';
        if (isset($_REQUEST['inventory_make'])) {
            $inventory_make = $_REQUEST['inventory_make'];
        }
        ?>
        <form class="search-form" method="get" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php')); ?>" onsubmit="return automobile_var_filter_form_submit();">
            <!-- end extra query string -->
            <div class="search-input">
                <i class="icon-search7"></i>
                <?php
                $automobile_form_fields->automobile_form_text_render(
                        array(
                            'id' => 'inventory_title',
                            'cust_name' => 'inventory_title',
                            'cust_type' => 'search',
                            'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_inventories_title') . '"',
                            'classes' => 'form-control txt-field',
                            'std' => $inventory_title,
                        )
                );
                ?>
            </div>
            <!-- location with radius -->
            <?php
            if (isset($automobile_var_plugin_options['automobile_search_location']) && $automobile_var_plugin_options['automobile_search_location'] == 'on') {
                ?>
                <div class="cs-search">
                    <div class="search-form">

                        <div class="loction-search">
                            <?php
                            $automobile_radius = '';
                            if (isset($_REQUEST['radius']) && $_REQUEST['radius'] > 0) {
                                $automobile_radius = $_REQUEST['radius'];
                            }
                            $automobile_locatin_cust = '';
                            $automobile_geo_location = isset($automobile_var_plugin_options['automobile_geo_location']) ? $automobile_var_plugin_options['automobile_geo_location'] : '';
                            $cookie_geo_loc = isset($_COOKIE['automobile_geo_loc']) ? $_COOKIE['automobile_geo_loc'] : '';
                            $cookie_geo_switch = isset($_COOKIE['automobile_geo_switch']) ? $_COOKIE['automobile_geo_switch'] : '';
                            if ($automobile_geo_location == 'on' && $cookie_geo_switch == 'on' && $cookie_geo_loc != '') {
                                $automobile_locatin_cust = $cookie_geo_loc;
                            }
                            if (isset($_REQUEST['location'])) {
                                $automobile_locatin_cust = automobile_location_convert();
                            }
                            $automobile_loc_name = '';
                            $automobile_select_display = 'block';
                            $automobile_input_display = 'none';
                            $automobile_undo_display = 'none';
                            if ($automobile_locatin_cust != '') {
                                $automobile_loc_name = ' name=location';
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
                            <div id="cs-select-holder-location" class="select-location" data-locationadminurl="<?php echo esc_url(admin_url("admin-ajax.php")) ?>">
                                <?php
                                if ($automobile_var_plugin_options['automobile_google_autocomplete_enable'] == 'on') {
                                    automobile_get_custom_locationswith_google_auto('<div id="cs-select-holder" class="search-country" style="display:' . automobile_allow_special_char($automobile_select_display) . '"><div class="select-holder">', '</div><span>' . automobile_var_plugin_text_srt('automobile_var_desired_location') . '</span> </div>');
                                } else {
                                    automobile_get_custom_locations('<div id="cs-select-holder" class="search-country" style="display:' . automobile_allow_special_char($automobile_select_display) . '"><div class="select-holder">', '</div><span>' . automobile_var_plugin_text_srt('automobile_var_desired_location') . '</span> </div>');
                                }
                                ?>
                                <a id="location_redius_popup<?php echo absint($popup_randid); ?>" href="javascript:void(0);" class="location-btn pop"><i class="icon-hair-cross cs-color"></i></a>
                                <?php
                                if ($automobile_radius_switch == 'on') {
                                    ?>
                                    <div id="popup<?php echo absint($popup_randid) ?>" style="display:none;" class="select-popup">
                                        <a class="cs-location-close-popup cs-color" id="automobile_close<?php echo absint($popup_randid); ?>"><i class="cs-color icon-times"></i></a>
                                        <p><?php echo automobile_var_plugin_text_srt('automobile_var_show_with_in'); ?></p>
                                        <input id="ex6<?php echo absint($popup_randid); ?>" type="text" name="radius" data-slider-min="<?php echo absint($min_value); ?>" data-slider-max="<?php echo absint($max_value); ?>" data-slider-step="<?php echo absint($radius_step); ?>" data-slider-value="<?php echo absint($automobile_radius); ?>"/>
                                        <span id="ex6CurrentSliderValLabel"><span id="ex6SliderVal<?php echo absint($popup_randid); ?>"><?php echo absint($automobile_radius); ?></span><?php echo esc_html($automobile_radius_measure); ?></span>
                                        <?php
                                        if ($automobile_geo_location == 'on' && automobile_server_protocol() =='https://') {
                                            ?>
                                            <p class="my-location"><?php echo automobile_var_plugin_text_srt('automobile_var_of'); ?> <i class="cs-color icon-location-arrow"></i><a class="cs-color" onclick="automobile_get_location(this)"><?php echo automobile_var_plugin_text_srt('automobile_var_my_location'); ?></a></p>
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
                            
                            <!--
                            <input type="text" class="cs-geo-location form-control txt-field  geo-search-location" placeholder="<?php echo automobile_var_plugin_text_srt('automobile_var_select_location'); ?>" style="display:<?php echo esc_html($automobile_input_display) ?>;" <?php echo esc_html($automobile_loc_name) ?> value="<?php echo esc_html($automobile_locatin_cust) ?>" />
                            <div class="cs-undo-select" style="display:<?php echo esc_html($automobile_undo_display) ?>;">
                                    <i class="icon-times"></i>
                            </div>
                            //-->
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            $automobile_fil_makes_models_vars = array(
                'inventory_title' => isset($inventory_title) ? $inventory_title : '',
                'meta_post_ids_arr' => isset($meta_post_ids_arr) ? $meta_post_ids_arr : '',
                'automobile_inventory_posted_date_formate' => isset($automobile_inventory_posted_date_formate) ? $automobile_inventory_posted_date_formate : '',
                'automobile_inventory_expired_date_formate' => isset($automobile_inventory_expired_date_formate) ? $automobile_inventory_expired_date_formate : '',
                'inventory_title_id_condition' => isset($inventory_title_id_condition) ? $inventory_title_id_condition : '',
                'qrystr' => isset($qrystr) ? $qrystr : '',
                'automobile_rand_num' => $automobile_rand_num,
                'inventory_type' => $automobile_inv_get_type,
                'inventory_make' => $inventory_make,
            );
            ?>
            <div class="cs-inv-type-change-loader"></div>

            <?php
            // Inventory Types
            $final_query_str = str_replace("?", "", $qrystr);
            $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'inventory-type', 'no');
            $query = explode('&', $final_query_str);
//            foreach ($query as $param) {
//                if (!empty($param)) {
//                    $param_array = explode('=', $param);
//                    $name = isset($param_array[0]) ? $param_array[0] : '';
//                    $value = isset($param_array[1]) ? $param_array[1] : '';
//                    $new_str = $name . "=" . $value;
//                    if (is_array($name)) {
//                        foreach ($_query_str_single_value as $_query_str_single_value_arr) {
//                            $automobile_form_fields->automobile_form_hidden_render(
//                                    array(
//                                        'id' => $name,
//                                        'cust_name' => $name . '[]',
//                                        'std' => $value,
//                                    )
//                            );
//                        }
//                    } else {
//                        $automobile_form_fields->automobile_form_hidden_render(
//                                array(
//                                    'id' => $name,
//                                    'cust_name' => $name,
//                                    'std' => $value,
//                                )
//                        );
//                    }
//                }
//            }

            $automobile_inventory_type_posts = get_posts(array('posts_per_page' => '-1', 'post_type' => 'inventory-type', 'post_status' => 'publish'));

            if ($automobile_inventory_type_posts != '') {
                ?>
                <div class="select-input">
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
                    }

                    $automobile_opt_array = array(
                        'std' => $automobile_inv_get_type,
                        'id' => 'inventory_types',
                        'cust_name' => 'inventory_type',
                        'classes' => 'chosen-select',
                        'options_markup' => true,
                        'extra_atr' => ' onchange="automobile_inventory_type_change(this.value)"',
                        'options' => $tax_options,
                        'return' => false,
                    );
                    $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
                    ?>
                </div>
                <?php
            }
            echo '
            <script type="text/javascript">
                var makes_data_' . absint($automobile_rand_num) . ' = \'' . json_encode(str_replace(array('&'), array('[AND]'), $automobile_fil_makes_models_vars)) . '\';
            </script>
            <div class="cs-automobile-inv-makes" data-makes-var="makes_data_' . absint($automobile_rand_num) . '">';
            // Filter makes and models here
            echo automobile_inventory_filters_makes($automobile_fil_makes_models_vars);
            echo '
            </div>';

            $automobile_fil_cus_fields_vars = array(
                'inventory_title' => isset($inventory_title) ? $inventory_title : '',
                'cus_fields_count_arr' => isset($cus_fields_count_arr) ? $cus_fields_count_arr : '',
                'automobile_inventory_posted_date_formate' => isset($automobile_inventory_posted_date_formate) ? $automobile_inventory_posted_date_formate : '',
                'automobile_inventory_expired_date_formate' => isset($automobile_inventory_expired_date_formate) ? $automobile_inventory_expired_date_formate : '',
                'inventory_title_id_condition' => isset($inventory_title_id_condition) ? $inventory_title_id_condition : '',
                'filter_arr2' => isset($filter_arr2) ? $filter_arr2 : '',
                'qrystr' => isset($qrystr) ? $qrystr : '',
            );
            ?>
            
            <div class="cs-automobile-inv-cus-types" data-type-var="type_data_<?php echo absint($automobile_rand_num) ?>">
                <?php
                automobile_var_filter_custom_fields($automobile_inv_get_type, $automobile_fil_cus_fields_vars);
                ?>
            </div>
        </form>
    </div>
</aside>
<script>
    jQuery(document).ready(function () {
		automobile_page_settings();
	});
	jQuery(document).ajaxComplete(function () {
		automobile_page_settings();
	});
		function automobile_page_settings(){
			
			jQuery(".mCustomScrollbar").mCustomScrollbar({
			});
				
			jQuery(".btn-primary").click(function () {
				jQuery(".collapse").collapse('toggle');
			});

			jQuery(document).on('click', '.cs-expand-filters', function () {
				if (jQuery(this).hasClass('cs-colapse')) {
					jQuery(".collapse").collapse('hide');
					jQuery(this).html('<i class="icon-plus8"></i> <?php echo automobile_var_plugin_text_srt('automobile_var_expand_all_filters'); ?>');
					jQuery(this).removeClass('cs-colapse');
				} else {
					jQuery(".collapse").collapse('show');
					jQuery(this).html('<i class="icon-minus8"></i> <?php echo automobile_var_plugin_text_srt('automobile_var_colapse_all_filters'); ?>');
					jQuery(this).addClass('cs-colapse');
				}
			});

			jQuery("#ex6<?php echo absint($popup_randid); ?>").slider({
			});
			jQuery("#ex6<?php echo absint($popup_randid); ?>").on("blur", function (slideEvt) {
			});
			jQuery("#ex6<?php echo absint($popup_randid); ?>").on("slide", function (slideEvt) {
				jQuery("#ex6SliderVal<?php echo absint($popup_randid); ?>").text(slideEvt.value);
			});
			jQuery('#location_redius_popup<?php echo absint($popup_randid); ?>').click(function (event) {
				event.preventDefault();
				jQuery("#popup<?php echo absint($popup_randid); ?>").css('display', 'block') //to show
				return false;
			});

			jQuery('#automobile_close<?php echo absint($popup_randid); ?>').click(function () {
				jQuery("#popup<?php echo absint($popup_randid); ?>").css('display', 'none') //to hide
				return false;
			});
		}
		
</script>