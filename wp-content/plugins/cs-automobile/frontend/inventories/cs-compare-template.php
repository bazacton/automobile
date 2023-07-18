<?php
/**
 * File Type: Inventory listing Shortcode
 * 
 * Start Function how to create listing of Inventory
 *
 */
if (!function_exists('automobile_compare_inventories_listing')) {

    function automobile_compare_inventories_listing($atts, $content = "") {
        global $automobile_var_plugin_core, $automobile_var_plugin_options,$automobile_var_plugin_static_text;
        $automobile_currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '';
        $automobile_search_result_page = isset($automobile_var_plugin_options['automobile_search_result_page']) ? $automobile_var_plugin_options['automobile_search_result_page'] : '';

        
        $automobile_blog_num_post = 4; // only allow to compare number of items
        $default_date_time_formate = 'd-m-Y H:i:s';
        $automobile_compare_inventory_posted_date_formate = 'd-m-Y H:i:s';
        $automobile_compare_inventory_expired_date_formate = 'd-m-Y H:i:s';
        $inventory_type = '';
        ob_start();
        $get_query_type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $automobile_compare_session_list = array();
        if (isset($_SESSION['automobile_compare_list']) && is_array($_SESSION['automobile_compare_list']) && sizeof($_SESSION['automobile_compare_list']) > 0) {
            foreach ($_SESSION['automobile_compare_list'] as $automobile_compare_list) {
                $inventory_type = isset($automobile_compare_list['type_id']) ? $automobile_compare_list['type_id'] : '';
                $meta_post_ids_arr = isset($automobile_compare_list['list_ids']) ? $automobile_compare_list['list_ids'] : '';
                if (is_array($meta_post_ids_arr) && sizeof($meta_post_ids_arr) > 1) {
                    $automobile_compare_session_list[$inventory_type] = $automobile_compare_list;
                }
            }
        }
        $meta_post_ids_arr = array();
        if ((isset($_REQUEST['inventories_ids']) && $_REQUEST['inventories_ids'] != '') && (isset($_REQUEST['type']) && $_REQUEST['type'] != '')) {
            $inventory_type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
            $inventories_ids = isset($_REQUEST['inventories_ids']) ? $_REQUEST['inventories_ids'] : '';
            $meta_post_ids_arr = explode(',', $inventories_ids);
        } else if (isset($_SESSION['automobile_compare_list']) && is_array($_SESSION['automobile_compare_list']) && sizeof($_SESSION['automobile_compare_list']) > 0) {
            foreach ($_SESSION['automobile_compare_list'] as $automobile_compare_list) {
                if (isset($automobile_compare_list['list_ids']) && is_array($automobile_compare_list['list_ids']) && sizeof($automobile_compare_list['list_ids']) > 1) {
                    $inventory_type = isset($automobile_compare_list['type_id']) ? $automobile_compare_list['type_id'] : '';
                    $meta_post_ids_arr = isset($automobile_compare_list['list_ids']) ? $automobile_compare_list['list_ids'] : '';
                    if ($get_query_type != '' && $get_query_type == $inventory_type) {
                        $inventory_type = isset($automobile_compare_list['type_id']) ? $automobile_compare_list['type_id'] : '';
                        $meta_post_ids_arr = isset($automobile_compare_list['list_ids']) ? $automobile_compare_list['list_ids'] : '';
                        break;
                    }
                }
            }
        }

        if ($get_query_type == '') {
            $get_query_type = $inventory_type;
        }
        ?>
        <!-- alert for complete theme -->
        <div class="automobile_alerts"></div>
        <!-- main-cs-loader for complete theme -->
        <div class="main-cs-loader"></div>
        <?php
        $defaults = array(
            'automobile_compare_inventory_title' => '',
            'automobile_compare_inventory_sub_title' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        ?>
		
		<div class="row">
            <div class="section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php if (isset($automobile_compare_inventory_title) && trim($automobile_compare_inventory_title) <> '') { ?>
                    <div class="cs-element-title">
                        <h2><?php echo esc_attr($automobile_compare_inventory_title); ?></h2>
                    </div>
                <?php } ?>
                <div class="cs-compare" data-ajaxurl="<?php echo admin_url('admin-ajax.php') ?>" data-id="<?php echo get_the_id() ?>" data-ids="<?php echo isset($_REQUEST['inventories_ids']) ? $_REQUEST['inventories_ids'] : '' ?>">
                    <?php
                    if (sizeof($automobile_compare_session_list) > 1) {
                        echo '<div class="cs-compare-options">';
                        echo '<form method="get">';
                        echo '<select name="type" class="chosen-select-no-single" onchange="this.form.submit()">';
                        foreach ($automobile_compare_session_list as $c_m_key => $c_m_val) {
                            if (isset($c_m_val['list_ids']) && sizeof($c_m_val['list_ids']) > 1) {
                                echo '<option ' . selected($c_m_key, $get_query_type, false) . ' value="' . $c_m_key . '">' . get_the_title($c_m_key) . '</option>';
                            }
                        }
                        echo '</select>';
                        echo '</form>';
                        echo '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';
                        echo '</div>';
                    }
                    if (is_array($meta_post_ids_arr) && sizeof($meta_post_ids_arr) > 1) {
                        ?>
                        <script>
                            var current_url = location.protocol + "//" + location.host + location.pathname;
                            var query_sep = '?';
                            if (current_url.indexOf("?") != -1) {
                                query_sep = '&';
                            }
                            window.history.pushState(null, null, current_url + query_sep + "type=<?php echo absint($inventory_type) ?>&inventories_ids=<?php echo implode(',', $meta_post_ids_arr) ?>");
                        </script>
                        <ul class="cs-compare-list">
                            <li>
                                <div class="cs-compare-box">
                                    <div class="Specification-logo" style="background:<?php echo plugins_url('../../assets/images/compare-logo.png', __FILE__); ?>">
                                        <img class="lazyload no-src" src="<?php
                                        echo esc_url(automobile_var::plugin_url() . 'assets/frontend/images/compare-logo.png');
                                        plugins_url('../../assets/images/compare-logo.png', __FILE__);
                                        ?>" alt="#" />
                                    </div>
                                </div>
                                <?php
                                $meta_post_ids_size = sizeof($meta_post_ids_arr);
                                $meta_post_ids_counter = 1;
                                foreach ($meta_post_ids_arr as $inventory_id) {
                                    $automobile_inv_gallery = get_post_meta($inventory_id, 'automobile_inventory_gallery_url', true);

                                    $automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';

                                    $automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);
                                    $automobile_img_url = wp_get_attachment_image_src($automobile_gal_id, 'automobile_var_media_3');
                                    ?>
                                    <div class="cs-compare-box dev-rem-<?php echo absint($inventory_id) ?>">
                                        <div class="cs-media">
                                            <figure>
                                                <?php if (isset($automobile_img_url[0]) && $automobile_img_url[0] != '') { ?>
                                                    <img class="lazyload no-src" src="<?php echo esc_url($automobile_img_url[0]) ?>" alt="">
                                                <?php } ?>

                                                <figcaption>
                                                    <a class="cs-bgcolor cs-remove-compare-item" data-id="<?php echo absint($inventory_id) ?>" data-type-id="<?php echo absint($inventory_type) ?>"><i class="icon-cross2"></i></a>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <?php if ($meta_post_ids_counter != $meta_post_ids_size) { ?>
                                            <span class="cs-vs"><?php echo automobile_var_plugin_text_srt('automobile_var_vs'); ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php
                                    $meta_post_ids_counter++;
                                }
                                ?>
                            </li>  

                            <li>
                                <div class="cs-compare-box">
                                    <p class="label"><?php echo automobile_var_plugin_text_srt('automobile_var_basic_info'); ?></p>
                                </div>
                                <?php
                                foreach ($meta_post_ids_arr as $inventory_id) {
                                    $automobile_old_price = get_post_meta($inventory_id, 'automobile_inventory_old_price', true);
                                    $automobile_new_price = get_post_meta($inventory_id, 'automobile_inventory_new_price', true);
                                    ?>
                                    <div class="cs-compare-box dev-rem-<?php echo absint($inventory_id) ?>">
                                        <div class="cs-post-title">
                                            <h6>
                                                <a href="<?php echo esc_url(get_permalink($inventory_id)) ?>"><?php echo get_the_title($inventory_id) ?></a>
                                            </h6>
                                        </div>
                                        <div class="cs-price">
                                            <strong class="cs-color"><?php echo esc_html($automobile_currency_sign) . esc_html($automobile_new_price); ?></strong>
                                            <em> <?php echo automobile_var_plugin_text_srt('automobile_var_msrp') . ' ' . esc_html($automobile_currency_sign) . esc_html($automobile_old_price); ?></em>
                                        </div>
                                    </div>
                                <?php } ?>
                            </li>
                            <li>
                                <div class="cs-compare-box">
                                    <small class="label"><?php echo automobile_var_plugin_text_srt('automobile_var_make_by') ?></small>
                                </div>
                                <?php
                                foreach ($meta_post_ids_arr as $inventory_id) {
                                    $automobile_inv_makes = get_the_term_list($inventory_id, 'inventory-make', '<span class="cs-categories">', ', ', '</span>');
                                    ?>
                                    <div class="cs-compare-box dev-rem-<?php echo absint($inventory_id) ?>">
                                        <span>&nbsp;<?php
                                            if ($automobile_inv_makes != '') {
                                                printf('%1$s', $automobile_inv_makes);
                                            }
                                            ?></span>
                                    </div>
                                <?php } ?>

                            </li>
                            <li>
                                <div class="cs-compare-box">
                                    <small class="label"><?php echo automobile_var_plugin_text_srt('automobile_var_model') ?></small>
                                </div>
                                <?php
                                foreach ($meta_post_ids_arr as $inventory_id) {
                                    $automobile_inv_model = get_the_term_list($inventory_id, 'inventory-model', '<span class="cs-categories">', ', ', '</span>');
                                    ?>
                                    <div class="cs-compare-box dev-rem-<?php echo absint($inventory_id) ?>">
                                        <span>&nbsp;<?php
                                            if ($automobile_inv_model != '') {
                                                printf('%1$s', $automobile_inv_model);
                                            }
                                            ?></span>
                                    </div>
                                <?php } ?>

                            </li>

                            <?php
                            // load inventory type record by slug
                            $inventory_type_fields_arr = array();
                            $automobile_inventory_type_cus_fields = get_post_meta($inventory_type, "automobile_inventory_type_cus_fields", true);
                            if (is_array($automobile_inventory_type_cus_fields) && sizeof($automobile_inventory_type_cus_fields) > 0) {
                                foreach ($automobile_inventory_type_cus_fields as $cus_field) {
                                    $automobile_unique_id = rand(1111111, 9999999);
                                    $automobile_type = isset($cus_field['type']) ? $cus_field['type'] : '';
                                    if ($automobile_type != 'section') {
                                        $single_inventory_arr = array();
                                        $automobile_cus_title = isset($cus_field['label']) ? $cus_field['label'] : '';
                                        $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                                        foreach ($meta_post_ids_arr as $inventory_id) {
                                            $automobile_label_value = get_post_meta($inventory_id, "$automobile_meta_key_field", true);
                                            $single_inventory_arr[] = array(
                                                'id' => $inventory_id,
                                                'key' => $automobile_meta_key_field,
                                                'label' => $automobile_cus_title,
                                                'value' => $automobile_label_value,
                                            );
                                        }
                                        $inventory_type_fields_arr[$automobile_unique_id] = $single_inventory_arr;
                                    }
                                }
                            }
// }						
                            if (is_array($inventory_type_fields_arr) && sizeof($inventory_type_fields_arr) > 0) {
                                foreach ($inventory_type_fields_arr as $li_row) {
                                    ?>
                                    <li>
                                        <?php
                                        if (is_array($li_row) && sizeof($li_row) > 0) {
                                            $li_row_counter = 0;
                                            foreach ($li_row as $li_ro) {
                                                if ($li_row_counter == 0) {
                                                    ?>
                                                    <div class="cs-compare-box">
                                                        <small class="label"><?php echo isset($li_ro['label']) ? esc_html($li_ro['label']) : '' ?></small>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="cs-compare-box dev-rem-<?php echo absint(isset($li_ro['id']) ? $li_ro['id'] : '') ?>">
                                                    <span>&nbsp;
                                                        <?php
                                                        $row_val = isset($li_ro['value']) ? $li_ro['value'] : '';
                                                        if (is_array($row_val)) {
                                                            echo implode(',', $row_val);
                                                        } else {
                                                            echo esc_html($row_val);
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                                <?php
                                                $li_row_counter++;
                                            }
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <ul class="cs-compare-list">
							<li>
								<div class="compare-text-div">
									<?php
									$listing_url = '';
									if($automobile_search_result_page != '' && is_numeric($automobile_search_result_page)){
									 $listing_url = '<a href="'. get_permalink($automobile_search_result_page).'">'.automobile_var_plugin_text_srt('automobile_var_click_here').'</a>';
									}
									echo force_balance_tags(sprintf(automobile_var_plugin_text_srt('automobile_var_list_empty'), $listing_url)); ?>
								</div>
							</li>
						</ul>
                        <?php
                    }
                    ?>               
                </div>
            </div>
        </div>
        <?php
        $eventpost_data = ob_get_clean();
        return do_shortcode($eventpost_data);
    }

    add_shortcode('automobile_compare_inventories', 'automobile_compare_inventories_listing');
}