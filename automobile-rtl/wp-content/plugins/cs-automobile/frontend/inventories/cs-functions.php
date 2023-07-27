<?php
/**
 * File Type: Inventory Functions
 * 
 * Start Functions
 *
 */
if (!function_exists('automobile_inventory_listing_price')) {

    function automobile_inventory_listing_price($new_price = '', $old_price = '', $main_div_id = 'auto-price', $view = '') {
        global $automobile_var_plugin_options;
        $automobile_currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '';
        $html = '';
        if ($new_price != '' || $old_price != '') {
            if ($view == 'slider') {
                if ($new_price != '') {
                    $html .= '<span>' . $automobile_currency_sign . $new_price . '</span> ';
                }
                if ($old_price != '') {
                    $html .= '<small> ' . $automobile_currency_sign . $old_price . '</small>';
                }
            } else {
                $html .= '<div class="' . $main_div_id . '">';
                if ($new_price != '') {
                    $html .= '<span class="cs-color">' . $automobile_currency_sign . $new_price . '</span> ';
                }
                if ($old_price != '') {
                    $html .= '<em> ' . $automobile_currency_sign . $old_price . '</em>';
                }
                $html .= '</div>';
            }
        }
        return $html;
    }

}

if (!function_exists('automobile_inventory_filters_makes')) {

    function automobile_inventory_filters_makes($automobile_fil_makes_models_vars = array()) {
        global $automobile_form_fields, $automobile_var_plugin_static_text;
        if (isset($_POST['automobile_filter_makes_data'])) {
            $automobile_makes_data = $_POST['automobile_filter_makes_data'];
            $automobile_makes_data = json_decode(stripslashes($automobile_makes_data), true);
            $automobile_makes_data = str_replace(array('[AND]'), array('&'), $automobile_makes_data);
            $automobile_fil_makes_models_vars = $automobile_makes_data;
            extract($automobile_makes_data);
        } else {
            extract($automobile_fil_makes_models_vars);
        }

        if (isset($_POST['automobile_inv_type'])) {
            $inventory_type = $_POST['automobile_inv_type'];
        }

        $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type", 'post_status' => 'publish'));

        $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

        $automobile_inventory_type_makes = get_post_meta($inventory_type_id, 'automobile_inventory_type_makes', true);
        if (!is_array($automobile_inventory_type_makes) || !count($automobile_inventory_type_makes) > 0) {
            $automobile_inventory_type_makes = array();
        }

        $automobile_html = '';
        $automobile_html .= '
        <div class="cs-search"><div class="search-form">';
        // Inventory Makes

        $inventory_make_args = array(
            'orderby' => 'name',
            'order' => 'ASC',
            'fields' => 'all',
            'slug' => '',
            'hide_empty' => false,
            'parent' => 0,
        );

        $all_inventory_makes = get_terms('inventory-make', $inventory_make_args);

        $automobile_html .= '
        <div class="select-input">';
        $all_inventory_make = get_terms('inventory-make');
        if ($all_inventory_make != '') {
            $tax_options = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_makes') . '</option>';
            foreach ($all_inventory_make as $inventory_makeitem) {
                $inventory_make_mypost = '';
                $inventory_make_qry_str = '';
                $inventory_make_qry_str .= automobile_remove_qrystr_extra_var($qrystr, 'inventory-make');
                if (automobile_remove_qrystr_extra_var($qrystr, 'inventory-make') != '?') {
                    $inventory_make_qry_str .= '&';
                }

                $inventory_make_qry_str .= 'inventory-make=' . $inventory_makeitem->slug;

                $selected = '';

                if (in_array($inventory_makeitem->slug, $automobile_inventory_type_makes)) {
                    if (isset($inventory_make) && $inventory_make == $inventory_makeitem->slug) {
                        $selected = ' selected="selected"';
                    }
                    $tax_options .= '<option value="' . $inventory_makeitem->slug . '" ' . $selected . '>' . $inventory_makeitem->name . '</option>';
                }
            }
            $automobile_opt_array = array(
                'std' => '',
                'id' => 'inventory_makes',
                'cust_name' => 'inventory_make',
                'classes' => 'chosen-select',
                'options_markup' => true,
                'extra_atr' => ' onchange="automobile_inventory_make_change(this.value)"',
                'options' => $tax_options,
                'return' => true,
            );
            $automobile_html .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
        }
        $automobile_html .= '
        </div>';

        $automobile_html .= '
        <script type="text/javascript">
            var model_data_' . absint($automobile_rand_num) . ' = \'' . json_encode(str_replace(array('&'), array('[AND]'), $automobile_fil_makes_models_vars)) . '\';
        </script>
        <div class="cs-inv-make-change-loader"></div>
        <div class="cs-automobile-inv-models" data-model-var="model_data_' . absint($automobile_rand_num) . '">';
        $automobile_html .= automobile_var_filter_models($inventory_make, $automobile_fil_makes_models_vars);
        $automobile_html .= '
        </div>
        </div></div>';
        $automobile_html .= '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';
        if (isset($_POST['automobile_filter_makes_data'])) {
            echo json_encode(array('makes_mark' => $automobile_html));
            die;
        } else {
            return $automobile_html;
        }
    }

    add_action('wp_ajax_automobile_inventory_filters_makes', 'automobile_inventory_filters_makes');
    add_action('wp_ajax_nopriv_automobile_inventory_filters_makes', 'automobile_inventory_filters_makes');
}
/**
 * Start Function how to Inventory Type Detail
 */
if (!function_exists('automobile_inventory_type_detail')) {

    function automobile_inventory_type_detail($inventory_type_slug = 0) {
        global $post;
        $inventory_type_slug = get_post_meta($post->ID, 'automobile_inventory_type', true);
        $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
        $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
        $automobile_inventory_type_cus_fields = get_post_meta($inventory_type_id, "automobile_inventory_type_cus_fields", true);
        $itration = 0;
        $html = '';
        if (is_array($automobile_inventory_type_cus_fields) && sizeof($automobile_inventory_type_cus_fields) > 0) {
            foreach ($automobile_inventory_type_cus_fields as $cus_field) {
             $automobile_type = isset($cus_field['type']) ? $cus_field['type'] : '';
	     if ($automobile_type == 'url') {
		  $automobile_cus_label = isset($cus_field['label']) ? $cus_field['label'] : '';
                    $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                    $automobile_icon_field = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                    $automobile_label_value = get_post_meta($post->ID, "$automobile_meta_key_field", true);
                    if (is_array($automobile_label_value)) {
                        $automobile_label_value = implode(', ', $automobile_label_value);
                    }
                    if( $automobile_label_value != ''){
                    $html = '<li class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <span>' . $automobile_cus_label . '</span>
			     <a class="url_link" target="_blank" href="'.$automobile_label_value.'">'.$automobile_label_value.'</a>
                        </div>
                    </li>';
                    }
                    //echo ($html);
	     }else if ($automobile_type == 'section') {
                    $automobile_cus_title = isset($cus_field['label']) ? $cus_field['label'] : '';
                    $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                    $automobile_icon_field = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                    $automobile_label_value = get_post_meta($post->ID, "$automobile_meta_key_field", true);
                    $html = '';
                    if ($itration > 0) {
                        $html = '</ul>
                        </div>
                        </li>
                        </ul>';
                    }

                    $html .= '<ul class="row">
                    <li class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="element-title">
                            <i class="cs-color ' . $automobile_icon_field . '"></i>
                            <span>' . $automobile_cus_title . '</span>
                        </div>
                    </li>
                    <li class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 specifications-info">
                            <ul class="row">';
                    //echo ($html);
                    $itration++;
                } else {
                    $automobile_cus_label = isset($cus_field['label']) ? $cus_field['label'] : '';
                    $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                    $automobile_icon_field = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                    $automobile_label_value = get_post_meta($post->ID, "$automobile_meta_key_field", true);
                    if (is_array($automobile_label_value)) {
                        $automobile_label_value = implode(', ', $automobile_label_value);
                    }
                    $html = '<li class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="cs-text">
                            <span>' . $automobile_cus_label . '</span>
                            <strong>' . $automobile_label_value . '</strong>
                        </div>
                    </li>';
                    //echo ($html);
                }
            }
            if ($itration > 0) {
                $html = '</ul>
                    </div>
                </li>
            </ul>';
            }
            echo ($html);
        }
    }

}
/**
 * End Function how to Inventory Type Detail
 */
/**
 * Start Function how to split string by words
 */
if (!function_exists('string_split_by_words')) {

    function string_split_by_words($text, $splitLength = 200) {
        // explode the text into an array of words
        $wordArray = explode(' ', $text);

        // Too many words
        if (sizeof($wordArray) > $splitLength) {
            // Split words into two arrays
            $firstWordArray = array_slice($wordArray, 0, $splitLength);
            $lastWordArray = array_slice($wordArray, $splitLength, sizeof($wordArray));

            // Turn array back into two split strings 
            $firstString = implode(' ', $firstWordArray);
            $lastString = implode(' ', $lastWordArray);
            return array($firstString, $lastString);
        }
        // if our array is under the limit, just send it straight back
        return array($text);
    }

}
/**
 * End Function how to split string by words
 */
/**
 * Start Function Related Cars
 */
if (!function_exists('automobile_related_cars')) {

    function automobile_related_cars($automobile_limit = '-1') {

        global $post, $automobile_var_plugin_core, $automobile_var_plugin_static_text;

        $title_limit = 10;
        $custom_taxterms = '';
        $width = 250;
        $height = 188;

        $custom_taxterms = wp_get_object_terms($post->ID, array('inventory-make'), array('fields' => 'ids'));
        $args = array(
            'post_type' => 'inventory',
            'post_status' => 'publish',
            'posts_per_page' => $automobile_limit,
            'orderby' => 'DESC',
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'inventory-make',
                    'field' => 'id',
                    'terms' => $custom_taxterms
                )
            ),
            'post__not_in' => array($post->ID),
        );
        
        $custom_query = new WP_Query($args);
        if( $custom_query->have_posts()){
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div  style="text-align:left;" class="cs-section-title">
                <?php $invent_slug = get_post_meta( $post->ID, 'automobile_inventory_type', true); ?>
                <h3><?php printf(automobile_var_plugin_text_srt('automobile_related_cars'), $invent_slug); ?></h3>
            </div>
        </div>
        <?php
        }
        while ($custom_query->have_posts()) : $custom_query->the_post();

            $automobile_old_price = get_post_meta($post->ID, 'automobile_inventory_old_price', true);
            $automobile_new_price = get_post_meta($post->ID, 'automobile_inventory_new_price', true);
            $automobile_inv_feature_list = get_post_meta($post->ID, 'automobile_inventory_feature_list', true);
            $automobile_inventory_username = get_post_meta($post->ID, 'automobile_inventory_username', true);

            $automobile_inventory_user_img = get_user_meta($automobile_inventory_username, 'user_img', true);
            if ($automobile_inventory_user_img != '') {
                $automobile_inv_user_img_src = automobile_get_img_url($automobile_inventory_user_img, 'automobile_var_media_6');
            }

            $automobile_inv_gallery = get_post_meta($post->ID, 'automobile_inventory_gallery_url', true);
			
            $automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';
			
            $automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);
            $automobile_img_url = wp_get_attachment_image_src($automobile_gal_id, 'automobile_var_media_2');
            if (isset($automobile_img_url) && $automobile_img_url != '' && is_array($automobile_img_url)) {
                $automobile_img_url = $automobile_img_url[0];
            } else {
                $automobile_img_url = esc_url(automobile_var::plugin_url() . '/assets/frontend/images/img-not-found16x9.jpg');
                
            }
            ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="auto-listing auto-grid">
                    <?php if (isset($automobile_gal_url) && $automobile_gal_url != '') { ?>
                        <div class="cs-media">
                            <figure><a href="<?php echo esc_url(get_permalink());?>"><img class="lazyload no-src" src="<?php echo esc_url($automobile_gal_url) ?>" alt=""></a></figure>
                        </div>
                    <?php } ?>
                    <div class="auto-text">
                        <?php
                        $automobile_inv_makes = get_the_term_list($post->ID, 'inventory-make', '<span class="cs-categories">', ', ', '</span>');
                        if ($automobile_inv_makes != '') {
                            printf('%1$s', $automobile_inv_makes);
                        }
                        ?>
                        <div class="post-title">
                            <h6><a href="<?php esc_url(the_permalink()) ?>"><?php echo wp_trim_words(get_the_title($post->ID), 6, '...') ?></a></h6>
                            <!--<div class="auto-price">-->
                            <?php
                            echo automobile_inventory_listing_price($automobile_new_price, $automobile_old_price);
                            ?>
                            <!--</div>-->
                        </div>
                        <?php
                        if (is_array($automobile_inv_feature_list) && sizeof($automobile_inv_feature_list) > 0) {
                            ?>
                            <div class="btn-list">
                                <a href="javascript:void(0)" class="btn btn-danger collapsed" data-toggle="collapse" data-target="#list-view<?php echo absint($post->ID) ?>" aria-expanded="false"></a>
                                <div id="list-view<?php echo absint($post->ID) ?>" class="collapse" aria-expanded="false" style="height: 0px;">
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
                        
                        echo automobile_inventory_compare_button( $post->ID );
                        ?>
                        <a href="<?php echo esc_url(get_permalink()) ?>" class="View-btn"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_view_detail')) ?><i class="icon-arrow-long-right"></i></a>
                    </div>
                </div>
            </div>

            <?php
        endwhile;
        wp_reset_postdata();
        ?>
<!--
        </div>
        </div
-->
        <?php
    }

}
/**
 * End Function Related Cars
 */
/**
 * Start Function Inventory Compare Button
 */
if (!function_exists('automobile_inventory_compare_button')) {

    function automobile_inventory_compare_button($inv_id = '') {
        global $automobile_var_plugin_static_text, $inventory_random_id;

        $inventory_type_slug = get_post_meta($inv_id, 'automobile_inventory_type', true);
        if ($inventory_type_slug != '') {
            $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
            $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
        } else {
            $inventory_type_id = '';
        }
        $inv_compare_check = '';
        if (isset($_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'])) {
            $automobile_type_comp_list = $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'];
            if (is_array($automobile_type_comp_list) && in_array($inv_id, $automobile_type_comp_list)) {
                $inv_compare_check = ' checked="checked"';
            }
        }
        $html = '';
        $html .= '
        <div class="cs-compare-msg-box" id="cs-compare-msg-box-' . absint($inv_id) . '"></div>
        <div class="cs-checkbox">
            <input type="checkbox" ' . $inv_compare_check . ' class="automobile_compare_check_add" data-id="' . absint($inv_id). '" data-random = "' . absint($inv_id) . '" name="list" value="check-listn" id="check-list' . absint($inv_id) . '" data-ajaxurl="'. admin_url('admin-ajax.php') .'">
            <label for="check-list' . absint($inv_id) . '">' . automobile_var_plugin_text_srt('automobile_var_compare') . '</label>
        </div>';
        return $html;
    }

}
/**
 * End Function Inventory Compare Button
 */
/**
 * Start Function Inventory Compare Det Button
 */
if (!function_exists('automobile_inventory_compare_det_button')) {

    function automobile_inventory_compare_det_button($inv_id = '') {
        global $automobile_var_plugin_static_text;
        $automobile_var_compared = automobile_var_plugin_text_srt('automobile_var_compared');

        $inventory_type_slug = get_post_meta($inv_id, 'automobile_inventory_type', true);
        if ($inventory_type_slug != '') {
            $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
            $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
        } else {
            $inventory_type_id = '';
        }
        $inv_compare_check = 'check';
        $compare_title = automobile_var_plugin_text_srt('automobile_var_add_to_compare');
        $remove_compare_title = automobile_var_plugin_text_srt('automobile_var_remove_compare');
        $html = '<a class="btn-compare cs-btn-compare" data-type="detail-page" data-id="' . $inv_id . '" data-check="' . $inv_compare_check . '" data-ajaxurl="' . admin_url( 'admin-ajax.php' ) . '"><i class="icon-flow-tree"></i><span>' . $compare_title . '</span></a>';
        if (isset($_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'])) {
            $automobile_type_comp_list = $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'];
            if (is_array($automobile_type_comp_list) && in_array($inv_id, $automobile_type_comp_list)) {
                $inv_compare_uncheck = 'uncheck';
                $html = '<a class="btn-compare cs-btn-compare" data-type="detail-page" data-id="' . $inv_id . '" data-check="' . $inv_compare_uncheck . '" data-check="' . $inv_compare_check . '" data-ajaxurl="' . admin_url( 'admin-ajax.php' ) . '"><i class="icon-flow-tree"></i> <span>' . $remove_compare_title . '</span></a>';
            }
        }

        return $html;
    }

}
/**
 * End Function Inventory Compare Det Button
 */
/**
 * Start Function Automobile Compare Add
 */
if (!function_exists('automobile_var_compare_add')) {

    function automobile_var_compare_add() {
        global $automobile_var_plugin_static_text, $automobile_var_plugin_options;
        $automobile_inv_id = isset($_POST['automobile_inventory_id']) ? $_POST['automobile_inventory_id'] : '';
        $automobile_check_action = isset($_POST['_action']) ? $_POST['_action'] : '';
        $add_to_compare = '';
        $add_to_compare_already = '';
        $inventory_type_slug = get_post_meta($automobile_inv_id, 'automobile_inventory_type', true);
        if ($inventory_type_slug != '') {
            $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
            $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
        } else {
            $inventory_type_id = '';
        }
        $mark_msg = automobile_var_plugin_text_srt('automobile_var_cannot_compare');
        if ($inventory_type_id != '') {
            if ($automobile_check_action == 'check') {
                $already_in_list = false;
                if (isset($_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'])) {
                    $automobile_type_comp_list = $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'];
                    if (is_array($automobile_type_comp_list) && in_array($automobile_inv_id, $automobile_type_comp_list)) {
                        if (($key = array_search($automobile_inv_id, $automobile_type_comp_list)) !== false) {
                            $already_in_list = true;
                        }
                    }
                }
                if ($already_in_list == true) {
                    $mark_msg = automobile_var_plugin_text_srt('automobile_var_already_compared');
                    $add_to_compare_already = automobile_var_plugin_text_srt('automobile_var_add_to_compare');
                } else {
                    $compare_listing_url = isset($automobile_var_plugin_options['automobile_compare_list_page']) ? $automobile_var_plugin_options['automobile_compare_list_page'] : '';
                    if( $compare_listing_url != '' ){
                        $compare_listing_url = esc_url(get_permalink($compare_listing_url));
                        $added_succesfully_msg = sprintf(automobile_var_plugin_text_srt('automobile_var_compared'), $compare_listing_url);
                    }else{
                        $added_succesfully_msg = automobile_var_plugin_text_srt('automobile_var_compared_successfully'); 
                    }
                    
                    if (isset($_SESSION['automobile_compare_list']) && !isset($_SESSION['automobile_compare_list']["type_{$inventory_type_id}"])) {
                        $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"] = array(
                            'type_id' => $inventory_type_id,
                            'list_ids' => array($automobile_inv_id),
                        );
                        $mark_msg = $added_succesfully_msg;
                    } else if (isset($_SESSION['automobile_compare_list']) && isset($_SESSION['automobile_compare_list']["type_{$inventory_type_id}"])) {
                        $type_session_arr = $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"];
                        if (isset($type_session_arr['list_ids']) && is_array($type_session_arr['list_ids']) && sizeof($type_session_arr['list_ids']) < 3) {
                            array_push($type_session_arr['list_ids'], $automobile_inv_id);
                            $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"] = array(
                                'type_id' => $inventory_type_id,
                                'list_ids' => $type_session_arr['list_ids'],
                            );
                            $mark_msg = $added_succesfully_msg;
                        } else if (isset($type_session_arr['list_ids']) && is_array($type_session_arr['list_ids']) && sizeof($type_session_arr['list_ids']) >= 3) {
                            $mark_msg = automobile_var_plugin_text_srt('automobile_var_have_3_inventories');
                            $add_to_compare_already = automobile_var_plugin_text_srt('automobile_var_add_to_compare');
                            $mark_msg .= '<script>jQuery("#check-list' . $automobile_inv_id . '").attr("checked", false);</script>';
                        } else if (!isset($type_session_arr['list_ids'])) {
                            $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"] = array(
                                'type_id' => $inventory_type_id,
                                'list_ids' => array($automobile_inv_id),
                            );
                            $mark_msg = $added_succesfully_msg;
                        }
                    } else {
                        $_SESSION['automobile_compare_list'] = array(
                            "type_{$inventory_type_id}" => array(
                                'type_id' => $inventory_type_id,
                                'list_ids' => array($automobile_inv_id),
                            ),
                        );
                        $mark_msg = $added_succesfully_msg;
                    }
                }
            } else {
                if (isset($_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'])) {
                    $automobile_type_comp_list = $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"]['list_ids'];
                    if (is_array($automobile_type_comp_list) && in_array($automobile_inv_id, $automobile_type_comp_list)) {
                        if (($key = array_search($automobile_inv_id, $automobile_type_comp_list)) !== false) {
                            unset($automobile_type_comp_list[$key]);
                            $_SESSION['automobile_compare_list']["type_{$inventory_type_id}"] = array(
                                'type_id' => $inventory_type_id,
                                'list_ids' => $automobile_type_comp_list,
                            );
                        }
                    }
                }
                $mark_msg = automobile_var_plugin_text_srt('automobile_var_removed_compare');
                $add_to_compare = automobile_var_plugin_text_srt('automobile_var_add_to_compare');
            }
        } else {
            $mark_msg = automobile_var_plugin_text_srt('automobile_var_cannot_compare');
        }
        $compare_msg = '';
        if( $add_to_compare != '' ){
            $compare_msg = $add_to_compare;
        }elseif( $add_to_compare_already != '' ){
            $compare_msg = $add_to_compare_already;
        }else{
            $compare_msg = automobile_var_plugin_text_srt('automobile_var_remove_compare');
        }
        echo json_encode(array('mark' => $mark_msg, 'compare' => $compare_msg ));
        die;
    }

    add_action('wp_ajax_automobile_var_compare_add', 'automobile_var_compare_add');
    add_action('wp_ajax_nopriv_automobile_var_compare_add', 'automobile_var_compare_add');
}
/**
 * End Function Automobile Compare Add
 */
/**
 * Start Function Removing Compare
 */
if (!function_exists('automobile_var_removing_compare')) {

    function automobile_var_removing_compare() {

        $automobile_inv_id = isset($_POST['inventory_id']) ? $_POST['inventory_id'] : '';
        $automobile_type_id = isset($_POST['type_id']) ? $_POST['type_id'] : '';
        $automobile_inv_ids = isset($_POST['inv_ids']) ? $_POST['inv_ids'] : '';
        $automobile_page_id = isset($_POST['page_id']) ? $_POST['page_id'] : '';

        if (isset($_SESSION['automobile_compare_list']["type_{$automobile_type_id}"]['list_ids'])) {
            $automobile_type_comp_list = $_SESSION['automobile_compare_list']["type_{$automobile_type_id}"]['list_ids'];
            if (is_array($automobile_type_comp_list) && in_array($automobile_inv_id, $automobile_type_comp_list)) {
                if (($key = array_search($automobile_inv_id, $automobile_type_comp_list)) !== false) {
                    unset($automobile_type_comp_list[$key]);
                    $_SESSION['automobile_compare_list']["type_{$automobile_type_id}"] = array(
                        'type_id' => $automobile_type_id,
                        'list_ids' => $automobile_type_comp_list,
                    );
                }
            }
        }

        $automobile_inv_ids = explode(',', $automobile_inv_ids);
        if (in_array($automobile_inv_id, $automobile_inv_ids)) {
            if (($key = array_search($automobile_inv_id, $automobile_inv_ids)) !== false) {
                unset($automobile_inv_ids[$key]);
            }
        }
        $automobile_inv_ids = implode(',', $automobile_inv_ids);

        $final_url = add_query_arg(array('type' => $automobile_type_id, 'inventories_ids' => $automobile_inv_ids), get_permalink($automobile_page_id));

        echo json_encode(array('url' => $final_url));
        die;
    }

    add_action('wp_ajax_automobile_var_removing_compare', 'automobile_var_removing_compare');
    add_action('wp_ajax_nopriv_automobile_var_removing_compare', 'automobile_var_removing_compare');
}
/**
 * End Function Removing Compare
 */
/*
 *
 * Start Function  for  create form  capatach
 *
 */
if (!function_exists('automobile_captcha')) {

    function automobile_captcha($id = '') {

        $strings = new automobile_plugin_all_strings();
        $strings->automobile_var_plugin_login_strings();
        global $automobile_var_plugin_options, $automobile_var_plugin_static_text;


        /* String Translations Variables */


        /* End */
        $automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
        $automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
        $automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
        $output = '';
        if ($automobile_captcha_switch == 'on') {
            if ($automobile_sitekey <> '' && $automobile_secretkey <> '') {
                $output .= '<script type="text/javascript">'
                . ' jQuery(window).on(load,function (){
                        captcha_reload(\'' . admin_url('admin-ajax.php') . '\', \'' . $id . '\');
                    });
                    </script>';

                $output .= '<div class="g-recaptcha" data-theme="light" id="' . $id . '" data-sitekey="' . $automobile_sitekey . '" style="transform:scale(1.22); -webkit-transform:scale(1.22); transform-origin:0 0; -webkit-transform-origin:0 0;">'
                        . '</div> '
                        . '<a class="recaptcha-reload-a" href="javascript:void(0);" onclick="captcha_reload(\'' . admin_url('admin-ajax.php') . '\', \'' . $id . '\');">'
                        . '<i class="icon-refresh2"></i> ' . esc_html(automobile_var_plugin_text_srt('automobile_var_reload')) . '</a>';
            } else {
                $output = '<p>' . esc_html(automobile_var_plugin_text_srt('automobile_var_captcha_api_key')) . '</p>';
            }
        }
        return $output;
    }

}
/**
 * End Function for create form capatach
 */
/*
 *
 * Start Function for Inventory Features Info
 *
 */
if (!function_exists('automobile_inventory_features_info')) {

    function automobile_inventory_features_info($inv_id = '', $view = '') {

        $html = '';

        $inventory_type_slug = get_post_meta($inv_id, 'automobile_inventory_type', true);
        $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
        $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
        $automobile_inventory_type_cus_fields = get_post_meta($inventory_type_id, "automobile_inventory_type_cus_fields", true);
        $have_featured_fields = false;
        if (is_array($automobile_inventory_type_cus_fields) && sizeof($automobile_inventory_type_cus_fields) > 0) {
            foreach ($automobile_inventory_type_cus_fields as $cus_field) {
                $automobile_featured_field = isset($cus_field['featured']) ? $cus_field['featured'] : '';
                $automobile_label_field = isset($cus_field['label']) ? $cus_field['label'] : '';
                $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                $automobile_icon_field = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                $automobile_label_value = get_post_meta($inv_id, "$automobile_meta_key_field", true);
                if ($automobile_featured_field == 'yes' && $automobile_label_field != '' && $automobile_label_value != '') {
                    $have_featured_fields = true;
                    break;
                }
            }
        }

        if ($have_featured_fields) {
            if ($view == 'detail') {
                $html .= '<ul class="row">';
                foreach ($automobile_inventory_type_cus_fields as $cus_field) {
                    $automobile_featured_field = isset($cus_field['featured']) ? $cus_field['featured'] : '';
                    $automobile_label_field = isset($cus_field['label']) ? $cus_field['label'] : '';
                    $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                    $automobile_icon_field = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                    $automobile_label_value = get_post_meta($inv_id, "$automobile_meta_key_field", true);
                    if ($automobile_featured_field == 'yes' && $automobile_label_field != '' && $automobile_label_value != '') {
                        if (is_array($automobile_label_value)) {
                            $automobile_label_value = implode(', ', $automobile_label_value);
                        }
                        $html .= '
                        <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="cs-media">
                                <figure><i class="' . $automobile_icon_field . ' cs-color"></i></figure>
                            </div>
                            <div class="auto-text">
                                <span>' . esc_html__($automobile_label_field, 'cs-automobile') . '</span>
                                <strong>' . esc_html__($automobile_label_value, 'cs-automobile') . '</strong>
                            </div>
                        </li>';
                    }
                }
                $html .= '</ul>';
            } else {
                $html .= '
                <ul class="auto-info-detail">';
                foreach ($automobile_inventory_type_cus_fields as $cus_field) {
                    $automobile_featured_field = isset($cus_field['featured']) ? $cus_field['featured'] : '';
                    $automobile_label_field = isset($cus_field['label']) ? $cus_field['label'] : '';
                    $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                    $automobile_label_value = get_post_meta($inv_id, "$automobile_meta_key_field", true);
                    if ($automobile_featured_field == 'yes' && $automobile_label_field != '' && $automobile_label_value != '') {
                        if (is_array($automobile_label_value)) {
                            $automobile_label_value = implode(', ', $automobile_label_value);
                        }
                        $html .= '<li>' . esc_html__($automobile_label_field, 'cs-automobile')  . '<span>' . esc_html__($automobile_label_value, 'cs-automobile') . '</span></li>';
                    }
                }
                $html .= '
                </ul>';
            }
        }

        return $html;
    }

}



if (!function_exists('automobile_dealer_features_info')) {

    function automobile_dealer_features_info($user_id = '') {

        $html = '';

        $automobile_dealer_cus_fields = get_option("automobile_dealer_cus_fields");
        if (is_array($automobile_dealer_cus_fields) && sizeof($automobile_dealer_cus_fields) > 0) {
            $html .= '<ul class="row">';
            foreach ($automobile_dealer_cus_fields as $cus_field) {
                $automobile_label_field = isset($cus_field['label']) ? $cus_field['label'] : '';
                $automobile_meta_key_field = isset($cus_field['meta_key']) ? $cus_field['meta_key'] : '';
                $automobile_icon_field = isset($cus_field['fontawsome_icon']) ? $cus_field['fontawsome_icon'] : '';
                $automobile_label_value = get_user_meta($user_id, "$automobile_meta_key_field", true);

                if ($automobile_label_field != '' && $automobile_label_value != '') {
                    if (is_array($automobile_label_value)) {
                        $automobile_label_value = implode(', ', $automobile_label_value);
                    }
                    $html .= '
                        <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <div class="cs-media">
                                <figure><i class="' . $automobile_icon_field . ' cs-color"></i></figure>
                            </div>
                            <div class="auto-text">
                                <span>' . esc_html__($automobile_label_field, 'cs-automobile') . '</span>
                                <strong>' . esc_html__($automobile_label_value, 'cs-automobile')  . '</strong>
                            </div>
                        </li>';
                }
            }
            $html .= '</ul>';
        }

        return $html;
    }

}

/**
 * End Function for Inventory Features Info
 */
/*
 *
 * Start Function for Automobile Filter Models
 *
 */
add_action('wp_ajax_automobile_var_filter_models', 'automobile_var_filter_models');
add_action('wp_ajax_nopriv_automobile_var_filter_models', 'automobile_var_filter_models');

if (!function_exists('automobile_var_filter_models')) {

    function automobile_var_filter_models($automobile_inventory_make = '', $automobile_fil_models_vars = array()) {
        global $wpdb, $automobile_var_plugin_static_text;
        if (isset($_POST['automobile_inventory_make'])) {
            $automobile_inventory_make = $_POST['automobile_inventory_make'];
        }

        if (isset($_POST['automobile_models_data'])) {
            $automobile_inventory_data = $_POST['automobile_models_data'];
            $automobile_inventory_data = json_decode(stripslashes($automobile_inventory_data), true);
            $automobile_inventory_data = str_replace(array('[AND]'), array('&'), $automobile_inventory_data);
            extract($automobile_inventory_data);
        } else {
            extract($automobile_fil_models_vars);
        }
        $automobile_inventory_make_term = get_term_by('slug', $automobile_inventory_make, 'inventory-make');
        if (is_object($automobile_inventory_make_term)) {
            $all_inventory_model = get_term_meta($automobile_inventory_make_term->term_id, 'automobile_inventory_make_models', true);
        } else {
            $all_inventory_model = '';
        }
        $inv_model_markup = '';

        if (!empty($all_inventory_model)) {
            $inv_model_markup .= '
        <div class="cs-select-model">
        <div class="cs-filter-title"><h6>' . automobile_var_plugin_text_srt('automobile_var_select_model') . '</h6></div>
        <ul class="cs-checkbox-list mCustomScrollbar" data-mcs-theme="dark">';
            foreach ($all_inventory_model as $inventory_modelitem) {
                $automobile_inventory_model_term = get_term_by('slug', $inventory_modelitem, 'inventory-model');
                if (is_object($automobile_inventory_model_term)) {
                    $inventory_model_mypost = '';
                    if ($inventory_title != '') {

                        $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE " . $inventory_title_id_condition . " UCASE(post_title) LIKE '%$inventory_title%' OR UCASE(post_content) LIKE '%$inventory_title%' AND post_type='inventories' AND post_status='publish'");
                        if ($post_ids) {
                            $inventory_model_mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => "DESC", 'orderby' => 'post_date',
                                'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                                'post__in' => $post_ids,
                                'tax_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'inventory-make',
                                        'field' => 'slug',
                                        'terms' => array($automobile_inventory_make)
                                    ),
                                    array(
                                        'taxonomy' => 'inventory-model',
                                        'field' => 'slug',
                                        'terms' => array($automobile_inventory_model_term->slug)
                                    ),
                                //$filter_arr2
                                ),
                                'meta_query' => array(
                                    array(
                                        'key' => 'automobile_inventory_posted',
                                        'value' => strtotime(date($automobile_inventory_posted_date_formate)),
                                        'compare' => '<=',
                                    ),
                                    array(
                                        'key' => 'automobile_inventory_expired',
                                        'value' => strtotime(date($automobile_inventory_expired_date_formate)),
                                        'compare' => '>=',
                                    ),
                                    array(
                                        'key' => 'automobile_inventory_status',
                                        'value' => 'active',
                                        'compare' => '=',
                                    ),
                                )
                            );
                        }
                    } else {
                        $inventory_model_mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => "DESC", 'orderby' => 'post_date',
                            'post__in' => $meta_post_ids_arr,
                            'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                            'tax_query' => array(
                                'relation' => 'AND',
                                array(
                                    'taxonomy' => 'inventory-make',
                                    'field' => 'slug',
                                    'terms' => array($automobile_inventory_make)
                                ),
                                array(
                                    'taxonomy' => 'inventory-model',
                                    'field' => 'slug',
                                    'terms' => array($automobile_inventory_model_term->slug)
                                ),
                            ),
                            'meta_query' => array(
                                array(
                                    'key' => 'automobile_inventory_posted',
                                    'value' => strtotime(date($automobile_inventory_posted_date_formate)),
                                    'compare' => '<=',
                                ),
                                array(
                                    'key' => 'automobile_inventory_expired',
                                    'value' => strtotime(date($automobile_inventory_expired_date_formate)),
                                    'compare' => '>=',
                                ),
                                array(
                                    'key' => 'automobile_inventory_status',
                                    'value' => 'active',
                                    'compare' => '=',
                                ),
                            )
                        );
                    }

                    $inventory_model_loop_count = new WP_Query($inventory_model_mypost);
                    $inventory_model_count_post = $inventory_model_loop_count->post_count;
                    ###################################################
                    $inventory_model_qry_str = '';
                    $inventory_model_qry_str .= automobile_remove_qrystr_extra_var($qrystr, 'inventory-model');
                    if (automobile_remove_qrystr_extra_var($qrystr, 'inventory-model') != '?') {
                        $inventory_model_qry_str .= '&';
                    }

                    $inventory_model_qry_str .= 'inventory-model=' . $automobile_inventory_model_term->slug;

                    $automobile_filter_query_boxes = array();
                    if (isset($_SERVER["QUERY_STRING"])) {
                        $automobile_query_string = $_SERVER["QUERY_STRING"];
                        $automobile_query_string = explode('&', $automobile_query_string);
                        if (!empty($automobile_query_string)) {
                            if (count(array_filter($automobile_query_string)) > 0) {
                                foreach ($automobile_query_string as $q_str) {
                                    if (strpos($q_str, 'inventory_model') !== false) {
                                        $automobile_filter_query_boxes[] = str_replace(array('inventory_model='), array(''), $q_str);
                                    }
                                }
                            } else {
                                if (isset($_REQUEST['inventory_model'])) {
                                    $automobile_filter_query_boxes[] = str_replace(array('inventory_model='), array(''), 'inventory_model=' . $_REQUEST['inventory_model']);
                                }
                            }
                        }
                    }

                    $inv_model_markup .= '
                <li>
                    <div class="checkbox">
                        <input id="checkbox-' . $automobile_inventory_model_term->slug . '" name="inventory_model" type="checkbox"' . (is_array($automobile_filter_query_boxes) && in_array($automobile_inventory_model_term->slug, $automobile_filter_query_boxes) ? ' checked="checked"' : '') . ' value="' . $automobile_inventory_model_term->slug . '">
                        <label for="checkbox-' . $automobile_inventory_model_term->slug . '">' . $automobile_inventory_model_term->name . '</label>
                        <span>(' . absint($inventory_model_count_post) . ')</span>
                    </div>
                </li>';
                }
            }
            $inv_model_markup .= '
        </ul>
        </div>';
        } else {
            $inv_model_markup .= automobile_var_plugin_text_srt('automobile_var_no_models_found');
        }
        if (isset($_POST['automobile_inventory_make'])) {
            echo json_encode(array('mark' => $inv_model_markup));
            die;
        } else {
            return $inv_model_markup;
        }
    }

}

add_action('wp_ajax_automobile_var_filter_custom_fields', 'automobile_var_filter_custom_fields');
add_action('wp_ajax_nopriv_automobile_var_filter_custom_fields', 'automobile_var_filter_custom_fields');

if (!function_exists('automobile_var_filter_custom_fields')) {

    function automobile_var_filter_custom_fields($inventory_type_slug = 0, $automobile_fil_cus_fields_vars = array()) {

        global $wpdb, $automobile_form_fields, $automobile_var_plugin_static_text;
        if (isset($_POST['inventory_type_slug'])) {
            $inventory_type_slug = $_POST['inventory_type_slug'];
        }
        if (isset($_POST['automobile_filter_fields_data'])) {
            $automobile_fil_cus_fields_vars = $_POST['automobile_filter_fields_data'];
            $automobile_fil_cus_fields_vars = json_decode(stripslashes($automobile_fil_cus_fields_vars), true);
            $automobile_fil_cus_fields_vars = str_replace(array('[AND]'), array('&'), $automobile_fil_cus_fields_vars);
            extract($automobile_fil_cus_fields_vars);
        } else {
            extract($automobile_fil_cus_fields_vars);
        }

        $automobile_markup_fields = '';
        $automobile_markup_fields .= '
        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">';
        if ($inventory_type_slug != '') {
            $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
            $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
        } else {
            $inventory_type_id = '';
        }

        $automobile_inventory_cus_fields = get_post_meta($inventory_type_id, "automobile_inventory_type_cus_fields", true);
        $automobile_inventory_cus_price_field = get_post_meta($inventory_type_id, "automobile_enable_price_search", true);

        if ($automobile_inventory_cus_price_field == 'on') {
            $price_search_style = get_post_meta($inventory_type_id, "automobile_price_search_style", true);
            $automobile_min_range = get_post_meta($inventory_type_id, "automobile_min_range", true);
            $automobile_max_range = get_post_meta($inventory_type_id, "automobile_max_range", true);
            $automobile_increment_step = get_post_meta($inventory_type_id, "automobile_increment_step", true);
            $automobile_inventory_field_label = get_post_meta($inventory_type_id, "automobile_price_field_label", true);
            if(is_array($automobile_inventory_cus_fields)){
            $automobile_inventory_cus_fields['price_field'] = array(
                'type' => 'range',
                'required' => 'no',
                'featured' => 'no',
                'label' => $automobile_inventory_field_label,
                'meta_key' => 'price',
                'placeholder' => '',
                'enable_srch' => 'yes',
                'default_value' => '',
                'fontawsome_icon' => '',
                'help' => '',
                'collapse_search' => 'no',
                'min' => $automobile_min_range,
                'max' => $automobile_max_range,
                'increment' => $automobile_increment_step,
                'srch_style' => $price_search_style,
            );

            $new_value = $automobile_inventory_cus_fields['price_field'];
            unset($automobile_inventory_cus_fields['price_field']);
            array_unshift($automobile_inventory_cus_fields, $new_value);
	    }
        }

        if (is_array($automobile_inventory_cus_fields) && sizeof($automobile_inventory_cus_fields) > 0) {

            $custom_field_flag = 11;
            foreach ($automobile_inventory_cus_fields as $cus_fieldvar => $cus_field) {
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
                    $count_filtration = $cus_fields_count_arr;
                    $filter_new_arr = array();
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
                    $filter_new_arr = isset($filter_new_arr) && !empty($filter_new_arr) ? call_user_func_array('array_merge', $filter_new_arr) : '';
                    $meta_post_ids_cus_fields_arr = '';
                    $meta_post_inventory_title_id_condition = '';
                    if (!empty($filter_new_arr)) {
                        $meta_post_ids_cus_fields_arr = automobile_get_query_whereclase_by_array($filter_new_arr);
                        if (empty($meta_post_ids_cus_fields_arr)) {
                            $meta_post_ids_cus_fields_arr = array(0);
                        }
                        $ids = $meta_post_ids_cus_fields_arr != '' ? implode(",", $meta_post_ids_cus_fields_arr) : '0';
                        $meta_post_inventory_title_id_condition = " ID in (" . $ids . ") AND ";
                    }
                    $automobile_collapsed_class = '';
                    if ($collapse_condition == 'yes') {
                        $automobile_collapsed_class = 'collapsed';
                    }
                    $automobile_markup_fields .= '
                <div class="panel panel-default">
                    <div class="panel-heading" role="tablist" id="heading' . esc_html($custom_field_flag) . '">
                        <a role="button" data-toggle="collapse" href="#collapse' . esc_html($custom_field_flag) . '" aria-expanded="' . ($collapse_condition != 'yes' ? 'true' : 'false') . '" aria-controls="collapse' . esc_html($custom_field_flag) . '">
                            ' . esc_html($cus_field['label']) . '
                        </a> 
                    </div>
                    <div id="collapse' . esc_html($custom_field_flag) . '" class="panel-collapse collapse ' . ($collapse_condition != 'yes' ? ' in' : '') . '" role="tabpanel" aria-labelledby="heading' . esc_html($custom_field_flag) . '">
                        <div class="panel-body">';
                    if ($cus_field['type'] == 'dropdown') {
                        $automobile_sr_search_style = isset($cus_field['srch_style']) ? $cus_field['srch_style'] : '';
                        $_query_string_arr = getMultipleParameters();
                        if ($automobile_sr_search_style == 'with_bg') {
                            $automobile_markup_fields .= '<div class="cs-carbody-style"><ul class="cs-checkbox-list">';
                        } else {
                            $automobile_markup_fields .= '
							<ul class="cs-checkbox-list" data-mcs-theme="dark">';
                        }
                        $final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
                        $final_query_str = str_replace("?", "", $final_query_str);
                        $query = explode('&', $final_query_str);

//                        foreach ($query as $param) {
//                            if (!empty($param)) {
//                                $param_array = explode('=', $param);
//                                $name = isset($param_array[0]) ? $param_array[0] : '';
//                                $value = isset($param_array[1]) ? $param_array[1] : '';
//                                $new_str = $name . "=" . $value;
//                                if (is_array($name)) {
//                                    foreach ($_query_str_single_value as $_query_str_single_value_arr) {
//                                        $automobile_markup_fields .= '<li>';
//                                        $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                                array(
//                                                    'id' => $name,
//                                                    'cust_name' => $name . '[]',
//                                                    'std' => $value,
//                                                    'return' => true,
//                                                )
//                                        );
//                                        $automobile_markup_fields .= '</li>';
//                                    }
//                                } else {
//                                    $automobile_markup_fields .= '<li>';
//                                    $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                            array(
//                                                'id' => $name,
//                                                'cust_name' => $name,
//                                                'std' => $value,
//                                                'return' => true,
//                                            )
//                                    );
//                                    $automobile_markup_fields .= '</li>';
//                                }
//                            }
//                        }
                        $number_option_flag = 1;
                        $cut_field_flag = 0;
                        foreach ($cus_field['options']['value'] as $cus_field_options_value) {
                            if ($cus_field['options']['value'][$cut_field_flag] == '' || $cus_field['options']['label'][$cut_field_flag] == '') {
                                $cut_field_flag++;
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

                                    $cus_field_mypost = '';
                                    if ($inventory_title != '') {

                                        $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE " . $meta_post_inventory_title_id_condition . " UCASE(post_title) LIKE '%$inventory_title%' OR UCASE(post_content) LIKE '%$inventory_title%'   AND post_type='inventories' AND post_status='publish'");
                                        if ($post_ids) {
                                            $cus_field_mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => "DESC", 'orderby' => 'post_date',
                                                'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                                                'post__in' => $post_ids,
                                                'tax_query' => array(
                                                    'relation' => 'AND',
                                                    $filter_arr2
                                                ),
                                                'meta_query' => array(
                                                    array(
                                                        'key' => 'automobile_inventory_posted',
                                                        'value' => strtotime(date($automobile_inventory_posted_date_formate)),
                                                        'compare' => '<=',
                                                    ),
                                                    array(
                                                        'key' => 'automobile_inventory_expired',
                                                        'value' => strtotime(date($automobile_inventory_expired_date_formate)),
                                                        'compare' => '>=',
                                                    ),
                                                    array(
                                                        'key' => 'automobile_inventory_status',
                                                        'value' => 'active',
                                                        'compare' => '=',
                                                    ),
                                                    $dropdown_arr,
                                                )
                                            );
                                        }
                                    } else {
                                         global $args;
                                        $search_args = $args;
                                        $cus_field_mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => "DESC", 'orderby' => 'post_date',
                                            'post__in' => $meta_post_ids_cus_fields_arr,
                                            'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                                            'tax_query' => array(
                                                'relation' => 'AND',
                                                $filter_arr2
                                            ),
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'automobile_inventory_posted',
                                                    'value' => strtotime(date($automobile_inventory_posted_date_formate)),
                                                    'compare' => '<=',
                                                ),
                                                array(
                                                    'key' => 'automobile_inventory_expired',
                                                    'value' => strtotime(date($automobile_inventory_expired_date_formate)),
                                                    'compare' => '>=',
                                                ),
                                                array(
                                                    'key' => 'automobile_inventory_status',
                                                    'value' => 'active',
                                                    'compare' => '=',
                                                ),
                                                $dropdown_arr,
                                            )
                                        );
                                    }
                                    $search_args['meta_query'][] = $dropdown_arr;
                                    $search_args['posts_per_page'] = -1;
                                    $cus_field_mypost       = $search_args;
                                    $cus_field_mypost['post__in']   = $meta_post_ids_cus_fields_arr;
                                    //unset($cus_field_mypost['post__in']);
                                    $cus_field_loop_count = new WP_Query($cus_field_mypost);
                                    $cus_field_count_post = $cus_field_loop_count->post_count;
                                    if (isset($_query_string_arr[$query_str_var_name]) && isset($cus_field_options_value) && is_array($_query_string_arr[$query_str_var_name]) && in_array($cus_field_options_value, $_query_string_arr[$query_str_var_name])) {
                                        $automobile_markup_fields .= '<li><div class="checkbox">';

                                        $automobile_markup_fields .= $automobile_form_fields->automobile_form_checkbox_render(
                                                array(
                                                    'simple' => true,
                                                    'cust_id' => $query_str_var_name . '_' . $number_option_flag,
                                                    'cust_name' => $query_str_var_name,
                                                    'extra_atr' => ' checked="checked"',
                                                    'std' => $cus_field_options_value,
                                                    'return' => true
                                                )
                                        );

                                        $automobile_markup_fields .= '<label for="' . $query_str_var_name . '_' . $number_option_flag . '">' . $cus_field['options']['label'][$cut_field_flag] . '</label><span>(' . $cus_field_count_post . ')</span></div></li>';
                                    } else {
										$multi_checked	= '';
										if(isset($_REQUEST[$query_str_var_name])){
											if(is_array($_REQUEST[$query_str_var_name])){
												if (in_array($cus_field_options_value, $_REQUEST[$query_str_var_name])){
													$multi_checked	= 'checked = "checked"';
												}
											}
										}
                                        $automobile_markup_fields .= '<li><div class="checkbox">';

                                        $automobile_markup_fields .= $automobile_form_fields->automobile_form_checkbox_render(
                                                array(
                                                    'simple' => true,
                                                    'cust_id' => $query_str_var_name . '_' . $number_option_flag,
                                                    'cust_name' => $query_str_var_name.'[]',
                                                    'extra_atr' => 'multiselectable = ""'.$multi_checked,
                                                    'std' => $cus_field_options_value,
                                                    'return' => true,
                                                )
                                        );

                                        $automobile_markup_fields .= '<label for="' . $query_str_var_name . '_' . $number_option_flag . '">' . $cus_field['options']['label'][$cut_field_flag] . '</label><span>(' . $cus_field_count_post . ')</span></div></li>';
                                    }
                                } else {
                                    //get count for this itration
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
                                    $cus_field_mypost = '';
                                    if ($inventory_title != '') {

                                        $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE " . $meta_post_inventory_title_id_condition . " UCASE(post_title) LIKE '%$inventory_title%' OR UCASE(post_content) LIKE '%$inventory_title%'  AND post_type='inventories' AND post_status='publish'");
                                        if ($post_ids) {
                                            $cus_field_mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => "DESC", 'orderby' => 'post_date',
                                                'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                                                'post__in' => $post_ids,
                                                'tax_query' => array(
                                                    'relation' => 'AND',
                                                    $filter_arr2
                                                ),
                                                'meta_query' => array(
                                                    array(
                                                        'key' => 'automobile_inventory_posted',
                                                        'value' => strtotime(date($automobile_inventory_posted_date_formate)),
                                                        'compare' => '<=',
                                                    ),
                                                    array(
                                                        'key' => 'automobile_inventory_expired',
                                                        'value' => strtotime(date($automobile_inventory_expired_date_formate)),
                                                        'compare' => '>=',
                                                    ),
                                                    array(
                                                        'key' => 'automobile_inventory_status',
                                                        'value' => 'active',
                                                        'compare' => '=',
                                                    ),
                                                    $dropdown_arr,
                                                )
                                            );
                                        }
                                    } else {
                                        $inventory_type_atr = '';
                                        global $args;
                                        $search_args = $args;
                                        $search_args['posts_per_page'] = -1;
                                        if (isset($_REQUEST['inventory_type'])) {
                                            $inventory_type_atr = array(
                                                'key' => 'automobile_inventory_type',
                                                'value' => $_REQUEST['inventory_type'],
                                                'compare' => '=',
                                            );
                                        }
                                        $cus_field_mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => "DESC", 'orderby' => 'post_date',
                                            'post__in' => $meta_post_ids_cus_fields_arr,
                                            'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                                            'tax_query' => array(
                                                'relation' => 'AND',
                                                $filter_arr2
                                            ),
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'automobile_inventory_posted',
                                                    'value' => strtotime(date($automobile_inventory_posted_date_formate)),
                                                    'compare' => '<=',
                                                ),
                                                array(
                                                    'key' => 'automobile_inventory_expired',
                                                    'value' => strtotime(date($automobile_inventory_expired_date_formate)),
                                                    'compare' => '>=',
                                                ),
                                                array(
                                                    'key' => 'automobile_inventory_status',
                                                    'value' => 'active',
                                                    'compare' => '=',
                                                ),
                                                $inventory_type_atr,
                                                $dropdown_arr,
                                            )
                                        );
                                    }
                                    $search_args['meta_query'][] = $dropdown_arr;
                                    $cus_field_mypost = $search_args;
                                    $cus_field_mypost['post__in']   = $meta_post_ids_cus_fields_arr;
                                    $cus_field_loop_count = new WP_Query($cus_field_mypost);
                                    $cus_field_count_post = $cus_field_loop_count->post_count;
                                    $amp_sign = '';
                                    if (automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name) != '?') {
                                        $amp_sign = '&';
                                    }
                                    $automobile_filter_query_boxes = array();
                                    if (isset($_SERVER["QUERY_STRING"])) {
                                        $automobile_query_string = $_SERVER["QUERY_STRING"];
                                        $automobile_query_string = explode('&', $automobile_query_string);

                                        if (!empty($automobile_query_string)) {
                                            foreach ($automobile_query_string as $q_str) {
                                                if (strpos($q_str, $cus_field['meta_key']) !== false) {
                                                    $automobile_filter_query_boxes[] = str_replace(array($cus_field['meta_key'] . '='), array(''), $q_str);
                                                }
                                            }
                                        }
                                    }
                                    if ($automobile_sr_search_style == 'with_bg') {
                                        $checked = '';
                                        if (isset($_REQUEST[$cus_field['meta_key']])) {
                                            $checked = ($_REQUEST[$cus_field['meta_key']] == $cus_field_options_value) ? ' checked="checked"' : '';
                                        }
                                        $automobile_markup_fields .= '
                                        <li>
                                            <div class="checkbox">
                                                <input name="' . $cus_field['meta_key'] . '" id="checkbox-' . $cus_field_options_value . '" type="checkbox"' . (is_array($automobile_filter_query_boxes) && in_array($cus_field_options_value, $automobile_filter_query_boxes) ? ' checked="checked"' : '') . $checked . ' value="' . $cus_field_options_value . '">
                                                <label for="checkbox-' . $cus_field_options_value . '">
                                                    <img class="lazyload no-src" src="' . $cus_field['options']['img'][$cut_field_flag] . '" alt="">
                                                    <span>' . $cus_field['options']['label'][$cut_field_flag] . '</span>
                                                        </label>
                                            </div>
                                        </li>';
                                    } else {
                                        $checked = '';
                                        if (isset($_REQUEST[$cus_field['meta_key']])) {
                                            $checked = ($_REQUEST[$cus_field['meta_key']] == $cus_field_options_value) ? ' checked="checked"' : '';
                                        }
                                        $automobile_markup_fields .= '
                                        <li>
                                            <div class="checkbox">
                                                <input name="' . $cus_field['meta_key'] . '" id="checkbox-' . $cus_field_options_value . '" type="checkbox"' . (is_array($automobile_filter_query_boxes) && in_array($cus_field_options_value, $automobile_filter_query_boxes) ? ' checked="checked"' : '') . $checked . ' value="' . $cus_field_options_value . '">
                                                <label for="checkbox-' . $cus_field_options_value . '">' . $cus_field['options']['label'][$cut_field_flag] . '</label>
                                                <span>(' . absint($cus_field_count_post) . ')</span>
                                            </div>
                                        </li>';
                                    }
                                }
                            }
                            $number_option_flag++;
                            $cut_field_flag++;
                        }
                        $automobile_markup_fields .= '
                        </div></ul>';
                        $automobile_markup_fields .= '</div>';
                    } else if ($cus_field['type'] == 'text' || $cus_field['type'] == 'email' || $cus_field['type'] == 'url') {

                        $final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
                        $final_query_str = str_replace("?", "", $final_query_str);
                        parse_str($final_query_str, $_query_str_arr);
//                        foreach ($_query_str_arr as $_query_str_single_var => $_query_str_single_value) {
//                            if (is_array($_query_str_single_value)) {
//                                foreach ($_query_str_single_value as $_query_str_single_value_arr) {
//                                    $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                            array(
//                                                'id' => $_query_str_single_var,
//                                                'cust_name' => $_query_str_single_var . '[]',
//                                                'std' => $_query_str_single_value_arr,
//                                                'return' => true,
//                                            )
//                                    );
//                                }
//                            } else {
//                                $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                        array(
//                                            'id' => $_query_str_single_var,
//                                            'cust_name' => $_query_str_single_var,
//                                            'std' => $_query_str_single_value,
//                                            'return' => true,
//                                        )
//                                );
//                            }
//                        }

                        $automobile_markup_fields .= $automobile_form_fields->automobile_form_text_render(
                                array(
                                    'id' => $query_str_var_name,
                                    'cust_name' => $query_str_var_name,
                                    'classes' => 'form-control',
                                    'extra_atr' => '',
                                    'std' => isset($_REQUEST[$query_str_var_name]) ? $_REQUEST[$query_str_var_name] : '',
                                    'return' => true,
                                )
                        );
                    } else if ($cus_field['type'] == 'date') {

                        $cus_field_date_formate_arr = explode(" ", $cus_field['date_format']);
                        $automobile_markup_fields .= '
                        <script>
                            jQuery(function () {
                                jQuery("#automobile_' . esc_html($query_str_var_name) . '").datetimepicker({
                                    format: "' . esc_html($cus_field_date_formate_arr[0]) . '",
                                    timepicker: false
                                });
                            });
                        </script>';
                        $final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
                        $final_query_str = str_replace("?", "", $final_query_str);
                        parse_str($final_query_str, $_query_str_arr);
//                        foreach ($_query_str_arr as $_query_str_single_var => $_query_str_single_value) {
//                            if (is_array($_query_str_single_value)) {
//                                foreach ($_query_str_single_value as $_query_str_single_value_arr) {
//                                    $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                            array(
//                                                'id' => $_query_str_single_var,
//                                                'cust_name' => $_query_str_single_var . '[]',
//                                                'std' => $_query_str_single_value_arr,
//                                                'return' => true,
//                                            )
//                                    );
//                                }
//                            } else {
//                                $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                        array(
//                                            'id' => $_query_str_single_var,
//                                            'cust_name' => $_query_str_single_var,
//                                            'std' => $_query_str_single_value,
//                                            'return' => true,
//                                        )
//                                );
//                            }
//                        }

                        $automobile_markup_fields .= $automobile_form_fields->automobile_form_text_render(
                                array(
                                    'id' => $query_str_var_name,
                                    'cust_name' => $query_str_var_name,
                                    'classes' => 'form-control',
                                    'extra_atr' => '',
                                    'std' => isset($_REQUEST[$query_str_var_name]) ? $_REQUEST[$query_str_var_name] : '',
                                    'return' => true,
                                )
                        );
                    } elseif ($cus_field['type'] == 'range') {

                        $automobile_rang_rand = rand(1000000, 9999999);
                        $range_min = $cus_field['min'];
                        $range_max = $cus_field['max'];
                        $range_increment = $cus_field['increment'];
                        $filed_type = isset($cus_field['srch_style']) ? $cus_field['srch_style'] : ''; //input, slider, input_slider
                        if (strpos($filed_type, '-') !== FALSE) {
                            $filed_type_arr = explode("_", $filed_type);
                        } else {
                            $filed_type_arr[0] = $filed_type;
                        }
                        $range_flag = 0;
                        while (count($filed_type_arr) > $range_flag) {
                            // if slider style
                            if ($filed_type_arr[$range_flag] == 'dropdown') {
                                $range_complete_str_first = "";
                                $range_complete_str_second = "";
                                if (isset($_REQUEST[$query_str_var_name])) {
                                    $range_complete_str = $_REQUEST[$query_str_var_name];
                                    $range_complete_str_arr = explode(",", $range_complete_str);
                                    $range_complete_str_first = isset($range_complete_str_arr[0]) ? $range_complete_str_arr[0] : '';
                                    $range_complete_str_second = isset($range_complete_str_arr[1]) ? $range_complete_str_arr[1] : '';
                                } else {
                                    $range_complete_str = '';
                                    if (isset($_REQUEST[$query_str_var_name]))
                                        $range_complete_str = $_REQUEST[$query_str_var_name];
                                    $range_complete_str_first = $cus_field['min'];
                                    $range_complete_str_second = $cus_field['max'];
                                }
                                $query_str_var_val = '';
                                if ($range_complete_str_first != '' && $range_complete_str_second != '') {
                                    $query_str_var_val = ' value="' . $range_complete_str_first . ',' . $range_complete_str_second . '"';
                                }
                                $automobile_range_options_from = $automobile_range_options_to = '';
                                while (absint($range_min) <= absint($range_max)) {

                                    $automobile_range_options_from .= '<option ' . selected($range_complete_str_first, $range_min, false) . ' value="' . $range_min . '">' . $range_min . '</option>';

                                    $automobile_range_options_to .= '<option ' . selected($range_complete_str_second, $range_min, false) . ' value="' . $range_min . '">' . $range_min . '</option>';

                                    $range_min = $range_min + $range_increment;
                                }
                                $automobile_markup_fields .= '<div class="cs-model-year">';
                                $automobile_markup_fields .= '<div class="cs-select-filed"><select id="cs-range-from-' . $automobile_rang_rand . '" data-id="' . $automobile_rang_rand . '" class="cs-range-dropdown-from chosen-select-no-single">';
                                $automobile_markup_fields .= $automobile_range_options_from;
                                $automobile_markup_fields .= '</select></div>';

                                $automobile_markup_fields .= '<span>' . __('to', 'cs-automobile') . '</span>';

                                $automobile_markup_fields .= '<div class="cs-select-filed"><select id="cs-range-to-' . $automobile_rang_rand . '" data-id="' . $automobile_rang_rand . '" class="cs-range-dropdown-to chosen-select-no-single">';
                                $automobile_markup_fields .= $automobile_range_options_to;
                                $automobile_markup_fields .= '</select></div>';
                                $automobile_markup_fields .= '<input type="hidden" id="cs-range-val-' . $automobile_rang_rand . '" name="' . $query_str_var_name . '"' . $query_str_var_val . ' />';
                                $automobile_markup_fields .= '</div>';
                                $automobile_markup_fields .= '
                                <script>
                                jQuery(document).ready(function(){chosen_selectionbox();});
                                jQuery(document).on("change", ".cs-range-dropdown-from, .cs-range-dropdown-to", function(){
									
                                    var rang_rand = jQuery(this).data("id");
                                    var rang_from = jQuery("#cs-range-from-"+rang_rand).val();
                                    var rang_to = jQuery("#cs-range-to-"+rang_rand).val();
                                    jQuery("#cs-range-val-"+rang_rand).val(rang_from+","+rang_to);
									on_select_field_change("cs-range-val-"+rang_rand);
                                    jQuery(this).parents("form.cs-inv-type-types").submit();
                                });
                                </script>';
                            } else {
                                $final_query_str = automobile_remove_qrystr_extra_var($qrystr, $query_str_var_name);
                                $final_query_str = str_replace("?", "", $final_query_str);
                                parse_str($final_query_str, $_query_str_arr);
//                                foreach ($_query_str_arr as $_query_str_single_var => $_query_str_single_value) {
//                                    if (is_array($_query_str_single_value)) {
//                                        foreach ($_query_str_single_value as $_query_str_single_value_arr) {
//                                            $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                                    array(
//                                                        'name' => '',
//                                                        'id' => $_query_str_single_var . '[]',
//                                                        'classes' => '',
//                                                        'std' => $_query_str_single_value_arr,
//                                                        'description' => '',
//                                                        'hint' => '',
//                                                        'return' => true
//                                                    )
//                                            );
//                                        }
//                                    } else {
//                                        $automobile_markup_fields .= $automobile_form_fields->automobile_form_hidden_render(
//                                                array(
//                                                    'name' => '',
//                                                    'id' => $_query_str_single_var,
//                                                    'classes' => '',
//                                                    'std' => $_query_str_single_value,
//                                                    'description' => '',
//                                                    'hint' => '',
//                                                    'return' => true
//                                                )
//                                        );
//                                    }
//                                }
                                $range_complete_str_first = "";
                                $range_complete_str_second = "";
                                if (isset($_REQUEST[$query_str_var_name])) {
                                    $range_complete_str = $_REQUEST[$query_str_var_name];
                                    $range_complete_str_arr = explode(",", $range_complete_str);
                                    $range_complete_str_first = isset($range_complete_str_arr[0]) ? $range_complete_str_arr[0] : '';
                                    $range_complete_str_second = isset($range_complete_str_arr[1]) ? $range_complete_str_arr[1] : '';
                                } else {
                                    $range_complete_str = '';
                                    if (isset($_REQUEST[$query_str_var_name]))
                                        $range_complete_str = $_REQUEST[$query_str_var_name];
                                    $range_complete_str_first = $cus_field['min'];
                                    $range_complete_str_second = $cus_field['max'];
                                }
                                $automobile_markup_fields .= '
                                <div class="cs-selector-range">
                                    <input name="' . $query_str_var_name . '" id="slider-range' . esc_html($query_str_var_name) . '" type="text" class="span2 slider-slide-range" value="" data-slider-min="' . $cus_field['min'] . '" data-slider-max="' . $cus_field['max'] . '" data-slider-step="' . $cus_field['increment'] . '" data-slider-value="[' . $range_complete_str_first . ',' . $range_complete_str_second . ']" />
                                    <div class="selector-value">
                                        <span>' . $cus_field['min'] . '</span>
                                        <span class="pull-right">' . $cus_field['max'] . '</span>
                                    </div>
                                </div>
                                <script>
                                jQuery(document).ready(function(){
                                    jQuery("#slider-range' . esc_html($query_str_var_name) . '").slider({
										stop: function(event, ui) {
                                            jQuery(this).parents("form").submit();
                                        },
                                    });
                                    jQuery("#slider-range' . esc_html($query_str_var_name) . '").on("slideStop", function () {
                                        jQuery(this).addClass("updated-slide-slider");
										jQuery(this).change();
                                    });
									 jQuery("#slider-range' . esc_html($query_str_var_name) . '").on("slideStart", function () {
                                        jQuery(this).removeClass("updated-slide-slider");
										jQuery(this).change();
                                    });
                                });
                                </script>';
                            }
                            $range_flag++;
                        }
                    }
                    $automobile_markup_fields .= '
                </div>
                </div>
                </div>';
                }
                $custom_field_flag++;
            }
        }
        $automobile_markup_fields .= '
    </div>';
        if (isset($_POST['inventory_type_slug'])) {
            echo json_encode(array('mark' => $automobile_markup_fields));
            die;
        } else {
            echo force_balance_tags($automobile_markup_fields);
        }
    }

}

if (!function_exists('automobile_var_contact_form_submit')) {

    function automobile_var_contact_form_submit() {

        define('WP_USE_THEMES', false);
        global $automobile_var_plugin_static_text;
        $json = array();
        $automobile_contact_error_msg = '';
        $subject_name = '';
        foreach ($_REQUEST as $keys => $values) {
            $$keys = $values;
        }
        $bloginfo = get_bloginfo();
        $automobile_contactus_send = '';
        $subjecteEmail = "(" . $bloginfo . ") " . esc_html(automobile_var_plugin_text_srt('automobile_var_contact_form_received'));

        if ($automobile_contact_email <> '') {
            $message = '
            <table width="100%" border="1">
              <tr>
                <td width="100"><strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_name')) . '</strong></td>
                <td>' . esc_html($contact_name) . '</td>
              </tr>
              <tr>
                <td><strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_email_label')) . '</strong></td>
                <td>' . esc_html($contact_email) . '</td>
              </tr>
              <tr>
                <td><strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_website')) . '</strong></td>
                <td>' . esc_html($contact_website) . '</td>
              </tr>
              <tr>
                <td><strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_message')) . '</strong></td>
                <td>' . esc_html($contact_msg) . '</td>
              </tr>
              <tr>
                <td><strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_ip_Address')) . '</strong></td>
                <td>' . $_SERVER["REMOTE_ADDR"] . '</td>
              </tr>
            </table>';
            $headers = "From: " . $contact_name . "\r\n";
            $headers .= "Reply-To: " . $contact_email . "\r\n";
            $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $attachments = '';

            if (mail($automobile_contact_email, sanitize_email($subjecteEmail), $message, $headers, '')) {
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
//Submit Contact Us Form Hooks
add_action('wp_ajax_nopriv_automobile_var_contact_form_submit', 'automobile_var_contact_form_submit');
add_action('wp_ajax_automobile_var_contact_form_submit', 'automobile_var_contact_form_submit');


if (!function_exists('automobile_set_sort_filter')) {

    function automobile_set_sort_filter() {
        if (session_id() == '') {
            session_start();
        }
        $field_name = $_REQUEST['field_name'];
        $field_name_value = $_REQUEST['field_name_value'];
        $_SESSION[$field_name] = $field_name_value;
        echo 'success';
        die();
    }

    add_action("wp_ajax_automobile_set_sort_filter", "automobile_set_sort_filter");
    add_action("wp_ajax_nopriv_automobile_set_sort_filter", "automobile_set_sort_filter");
}

if (!function_exists('automobile_dealer_sort_filter')) {

    function automobile_dealer_sort_filter() {
        if (session_id() == '') {
            session_start();
        }
        $field_name = $_REQUEST['field_name'];
        $field_name_value = $_REQUEST['field_name_value'];
        $_SESSION[$field_name] = $field_name_value;
        echo 'success';
        die();
    }

    add_action("wp_ajax_automobile_dealer_sort_filter", "automobile_dealer_sort_filter");
    add_action("wp_ajax_nopriv_automobile_dealer_sort_filter", "automobile_dealer_sort_filter");
}



/**
 * Start Function how to send mail using Ajax
 */
if (!function_exists('ajaxcontact_send_mail')) {

    function ajaxcontact_send_mail() {
        global $automobile_var_plugin_static_text;

        $results = '';
        $error = 0;
        $error_result = 0;
        $message = "";
        $name = '';
        $email = '';
        $phone = '';
        $contents = '';
        $dealerid = '';
        if (isset($_POST['automobile_ajaxcontactname'])) {
            $name = $_POST['automobile_ajaxcontactname'];
        }
        if (isset($_POST['automobile_ajaxcontactemail'])) {
            $email = $_POST['automobile_ajaxcontactemail'];
        }
        if (isset($_POST['automobile_ajaxcontactphone'])) {
            $phone = $_POST['automobile_ajaxcontactphone'];
        }
        if (isset($_POST['automobile_ajaxcontactcontents'])) {
            $contents = $_POST['automobile_ajaxcontactcontents'];
        }

        if ($name == '') {
            if (isset($_POST['ajaxcontactname'])) {
                $name = $_POST['ajaxcontactname'];
            }
        }
        if ($email == '') {
            if (isset($_POST['ajaxcontactemail'])) {
                $email = $_POST['ajaxcontactemail'];
            }
        }
        if ($phone == '') {
            if (isset($_POST['ajaxcontactphone'])) {
                $phone = $_POST['ajaxcontactphone'];
            }
        }
        if ($contents == '') {
            if (isset($_POST['ajaxcontactcontents'])) {
                $contents = $_POST['ajaxcontactcontents'];
            }
        }
        if (isset($_POST['dealerid'])) {
            $dealerid = $_POST['dealerid'];   // user id for candidate
        }
		if( $dealerid == '' && isset( $_POST['inventoryid'] ) ){
			$dealerid = get_post_meta( $_POST['inventoryid'], 'automobile_inventory_username', true ); // user id for candidate
		}

        $subject = automobile_var_plugin_text_srt('automobile_var_dealer_subject');
        $admin_email_from = get_option('admin_email');
        // getting candidate email address
        // getting email address from user table
        $automobile_user_id = $dealerid;
        $user_info = get_userdata($automobile_user_id);
        $admin_email = '';
        if (isset($user_info->user_email) && $user_info->user_email <> '') {
            $admin_email = $user_info->user_email;
        }
		
		
        if (strlen($name) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_name') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } else if (strlen($email) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_email') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results = " '" . $email . "' " . "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_email_not_valid') . "</span>";
            $error = 1;
            $error_result = 1;
        }
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";

        $contents = 'Name:' . $name . "\n" . 'Email:' . $email . "\n" . 'Phone:' . $phone . "\n" . $contents;
        if ($error == 0) {
			
            $respose = @mail($admin_email, $subject, $contents, $headers, '');
            if ($respose) {
                $error = 0;
                $error_result = 0;
                $results = automobile_var_plugin_text_srt('automobile_var_inquery_sent');
            } else {
                $error = 1;
                $error_result = 1;
                $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_not_sent') . "</span><br/>";
            }
        }

        if ($error_result == 1) {
            $data = 1;
            $message = $results . "|1";
            die($message);
        } else {
            $data = 0;
            $message = $results . "|0";
            die($message);
        }
    }

    // creating Ajax call for WordPress
    add_action('wp_ajax_nopriv_ajaxcontact_send_mail', 'ajaxcontact_send_mail');
    add_action('wp_ajax_ajaxcontact_send_mail', 'ajaxcontact_send_mail');
}
/**
 * End Function how to send mail using Ajax
 */
/**
 * Start Function how to send info inquiry mail using Ajax
 */
if (!function_exists('ajaxinfo_send_mail')) {

    function ajaxinfo_send_mail() {
        global $automobile_var_plugin_static_text;
        $results = '';
        $error = 0;
        $error_result = 0;
        $message = "";
        $name = '';
        $email = '';
        $phone = '';
        $contents = '';
        $dealerid = '';
        if (isset($_POST['automobile_ajaxinfoname'])) {
            $name = $_POST['automobile_ajaxinfoname'];
        }
        if (isset($_POST['automobile_ajaxinfoemail'])) {
            $email = $_POST['automobile_ajaxinfoemail'];
        }
        if (isset($_POST['automobile_ajaxinfophone'])) {
            $phone = $_POST['automobile_ajaxinfophone'];
        }
        if (isset($_POST['automobile_ajaxinfocontents'])) {
            $contents = $_POST['automobile_ajaxinfocontents'];
        }

        if ($name == '') {
            if (isset($_POST['ajaxinfoname'])) {
                $name = $_POST['ajaxinfoname'];
            }
        }
        if ($email == '') {
            if (isset($_POST['ajaxinfoemail'])) {
                $email = $_POST['ajaxinfoemail'];
            }
        }
        if ($phone == '') {
            if (isset($_POST['ajaxinfophone'])) {
                $phone = $_POST['ajaxinfophone'];
            }
        }
        if ($contents == '') {
            if (isset($_POST['ajaxinfocontents'])) {
                $contents = $_POST['ajaxinfocontents'];
            }
        }
        if (isset($_POST['dealerid'])) {
            $dealerid = $_POST['dealerid'];   // user id for candidate
        }


        $subject = automobile_var_plugin_text_srt('automobile_var_moreinfo_subject');
        ;
        $admin_email_from = get_option('admin_email');
        // getting candidate email address
        // getting email address from user table
        $automobile_user_id = $dealerid;
        $user_info = get_userdata($automobile_user_id);
        $admin_email = '';
        if (isset($user_info->user_email) && $user_info->user_email <> '') {
            $admin_email = $user_info->user_email;
        }
        if (strlen($name) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_name') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } else if (strlen($email) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_email') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results = " '" . $email . "' " . "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_email_not_valid') . "</span>";
            $error = 1;
            $error_result = 1;
        } else if (automobile_captcha_verify(true)) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_captcha_validate') . "</span>";
            $error = 1;
            $error_result = 1;
        }

        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";

        $contents = 'Name:' . $name . "\n" . 'Email:' . $email . "\n" . 'Phone:' . $phone . "\n" . $contents;
        if ($error == 0) {
            $respose = @mail($admin_email, $subject, $contents, $headers, '');
            if ($respose) {
                $error = 0;
                $error_result = 0;
                $results = automobile_var_plugin_text_srt('automobile_var_inquery_sent');
            } else {
                $error = 1;
                $error_result = 1;
                $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_not_sent') . "</span>";
            }
        }
        if ($error_result == 1) {
            $data = 1;
            $message = $results . "|1";
            die($message);
        } else {
            $data = 0;
            $message = $results . "|0";
            die($message);
        }
    }

    // creating Ajax call for WordPress
    add_action('wp_ajax_nopriv_ajaxinfo_send_mail', 'ajaxinfo_send_mail');
    add_action('wp_ajax_ajaxinfo_send_mail', 'ajaxinfo_send_mail');
}
/**
 * End Function how to send info inquiry mail using Ajax
 */
/**
 * Start Function how to send test drive using Ajax
 */
if (!function_exists('ajax_send_mail')) {

    function ajax_send_mail() {
        global $automobile_var_plugin_static_text;
        $results = '';
        $error = 0;
        $error_result = 0;
        $message = "";
        $name = '';
        $email = '';
        $phone = '';
        $contents = '';
        $dealerid = '';
        $time = '';
        if (isset($_POST['automobile_ajaxname'])) {
            $name = $_POST['automobile_ajaxname'];
        }
        if (isset($_POST['automobile_ajaxemail'])) {
            $email = $_POST['automobile_ajaxemail'];
        }
        if (isset($_POST['automobile_ajaxphone'])) {
            $phone = $_POST['automobile_ajaxphone'];
        }
        if (isset($_POST['automobile_ajaxcontents'])) {
            $contents = $_POST['automobile_ajaxcontents'];
        }
        if (isset($_POST['automobile_ajaxtime'])) {
            $contents = $_POST['automobile_ajaxtime'];
        }

        if ($name == '') {
            if (isset($_POST['ajaxname'])) {
                $name = $_POST['ajaxname'];
            }
        }
        if ($email == '') {
            if (isset($_POST['ajaxemail'])) {
                $email = $_POST['ajaxemail'];
            }
        }
        if ($phone == '') {
            if (isset($_POST['ajaxphone'])) {
                $phone = $_POST['ajaxphone'];
            }
        }
        if ($contents == '') {
            if (isset($_POST['ajaxcontents'])) {
                $contents = $_POST['ajaxcontents'];
            }
        }
        if ($time == '') {
            if (isset($_POST['ajaxtime'])) {
                $time = $_POST['ajaxtime'];
            }
        }
        if (isset($_POST['dealerid'])) {
            $dealerid = $_POST['dealerid'];   // user id for candidate
        }


        $subject = automobile_var_plugin_text_srt('automobile_var_test_drive_subject');
        $admin_email_from = get_option('admin_email');
        // getting candidate email address
        // getting email address from user table
        $automobile_user_id = $dealerid;
        $user_info = get_userdata($automobile_user_id);
        $admin_email = '';
        if (isset($user_info->user_email) && $user_info->user_email <> '') {
            $admin_email = $user_info->user_email;
        }
        if (strlen($name) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_name') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } else if (strlen($email) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_email') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results = " '" . $email . "' " . "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_email_not_valid') . "</span>";
            $error = 1;
            $error_result = 1;
        } else if (automobile_captcha_verify(true)) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_captcha_validate') . "</span>";
            $error = 1;
            $error_result = 1;
        }

        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";

        $contents = 'Name:' . $name . "\n" . 'Email:' . $email . "\n" . 'Phone:' . $phone . "\n" . $time . "\n" . $contents;
        if ($error == 0) {
            $respose = @mail($admin_email, $subject, $contents, $headers, '');
            if ($respose) {
                $error = 0;
                $error_result = 0;
                $results = automobile_var_plugin_text_srt('automobile_var_inquery_sent');
            } else {
                $error = 1;
                $error_result = 1;
                $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_not_sent') . "</span>";
            }
        }
        if ($error_result == 1) {
            $data = 1;
            $message = $results . "|1";
            die($message);
        } else {
            $data = 0;
            $message = $results . "|0";
            die($message);
        }
    }

    // creating Ajax call for WordPress
    add_action('wp_ajax_nopriv_ajax_send_mail', 'ajax_send_mail');
    add_action('wp_ajax_ajax_send_mail', 'ajax_send_mail');
}
/**
 * End Function how to send test drive mail using Ajax
 */
/**
 * Start Function how to send offer using Ajax
 */
if (!function_exists('ajaxoffer_send_mail')) {

    function ajaxoffer_send_mail() {
        global $automobile_var_plugin_static_text;
        $results = '';
        $error = 0;
        $error_result = 0;
        $message = "";
        $name = '';
        $email = '';
        $phone = '';
        $contents = '';
        $dealerid = '';
        $price = '';
        $finance = '';
        if (isset($_POST['automobile_ajaxoffername'])) {
            $name = $_POST['automobile_ajaxoffername'];
        }
        if (isset($_POST['automobile_ajaxofferemail'])) {
            $email = $_POST['automobile_ajaxofferemail'];
        }
        if (isset($_POST['automobile_ajaxofferphone'])) {
            $phone = $_POST['automobile_ajaxofferphone'];
        }
        if (isset($_POST['automobile_ajaxoffercontents'])) {
            $contents = $_POST['automobile_ajaxoffercontents'];
        }
        if (isset($_POST['automobile_ajaxofferprice'])) {
            $contents = $_POST['automobile_ajaxofferprice'];
        }
        if (isset($_POST['automobile_ajaxofferfinancing'])) {
            $contents = $_POST['automobile_ajaxofferfinancing'];
        }

        if ($name == '') {
            if (isset($_POST['ajaxoffername'])) {
                $name = $_POST['ajaxoffername'];
            }
        }
        if ($email == '') {
            if (isset($_POST['ajaxofferemail'])) {
                $email = $_POST['ajaxofferemail'];
            }
        }
        if ($phone == '') {
            if (isset($_POST['ajaxofferphone'])) {
                $phone = $_POST['ajaxofferphone'];
            }
        }
        if ($contents == '') {
            if (isset($_POST['ajaxoffercontents'])) {
                $contents = $_POST['ajaxoffercontents'];
            }
        }
        if ($price == '') {
            if (isset($_POST['ajaxofferprice'])) {
                $price = $_POST['ajaxofferprice'];
            }
        }

        if ($finance == '') {
            if (isset($_POST['ajaxofferfinancing'])) {
                $finance = $_POST['ajaxofferfinancing'];
            }
        }
        if (isset($_POST['dealerid'])) {
            $dealerid = $_POST['dealerid'];   // user id for candidate
        }

        $subject = automobile_var_plugin_text_srt('automobile_var_offer_subject');
        $admin_email_from = get_option('admin_email');
        // getting candidate email address
        // getting email address from user table
        $automobile_user_id = $dealerid;
        $user_info = get_userdata($automobile_user_id);
        $admin_email = '';
        if (isset($user_info->user_email) && $user_info->user_email <> '') {
            $admin_email = $user_info->user_email;
        }
        if (strlen($name) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_name') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } else if (strlen($email) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_email') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results = " '" . $email . "' " . "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_email_not_valid') . "</span>";
            $error = 1;
            $error_result = 1;
        } else if (automobile_captcha_verify(true)) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_captcha_validate') . "</span>";
            $error = 1;
            $error_result = 1;
        }

        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";

        $contents = 'Name:' . $name . "\n" . 'Email:' . $email . "\n" . 'Phone:' . $phone . "\n" . $price . "\n" . $finance . "\n" . $contents;
        if ($error == 0) {
            $respose = @mail($admin_email, $subject, $contents, $headers, '');
            if ($respose) {
                $error = 0;
                $error_result = 0;
                $results = automobile_var_plugin_text_srt('automobile_var_inquery_sent');
            } else {
                $error = 1;
                $error_result = 1;
                $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_not_sent') . "</span>";
            }
        }

        if ($error_result == 1) {
            $data = 1;
            $message = $results . "|1";
            die($message);
        } else {
            $data = 0;
            $message = $results . "|0";
            die($message);
        }
    }

    // creating Ajax call for WordPress
    add_action('wp_ajax_nopriv_ajaxoffer_send_mail', 'ajaxoffer_send_mail');
    add_action('wp_ajax_ajaxoffer_send_mail', 'ajaxoffer_send_mail');
}
/**
 * End Function how to send offer mail using Ajax
 */
/**
 * Start Function how to send offer using Ajax
 */
if (!function_exists('ajaxfriend_send_mail')) {

    function ajaxfriend_send_mail() {
        global $automobile_var_plugin_static_text;
        $results = '';
        $error = 0;
        $error_result = 0;
        $message = "";
        $name = '';
        $email = '';
        $phone = '';
        $contents = '';
        $dealerid = '';
        $friendmail = '';
        if (isset($_POST['automobile_ajaxmailname'])) {
            $name = $_POST['automobile_ajaxmailname'];
        }
        if (isset($_POST['automobile_ajaxmail'])) {
            $email = $_POST['automobile_ajaxmail'];
        }
        if (isset($_POST['automobile_ajaxmailphone'])) {
            $phone = $_POST['automobile_ajaxmailphone'];
        }
        if (isset($_POST['automobile_ajaxmailcontents'])) {
            $contents = $_POST['automobile_ajaxmailcontents'];
        }
        if (isset($_POST['automobile_ajaxfriendmail'])) {
            $friendmail = $_POST['automobile_ajaxfriendmail'];
        }

        if ($name == '') {
            if (isset($_POST['ajaxmailname'])) {
                $name = $_POST['ajaxmailname'];
            }
        }
        if ($email == '') {
            if (isset($_POST['ajaxmail'])) {
                $email = $_POST['ajaxmail'];
            }
        }
        if ($phone == '') {
            if (isset($_POST['ajaxmailphone'])) {
                $phone = $_POST['ajaxmailphone'];
            }
        }
        if ($contents == '') {
            if (isset($_POST['ajaxmailcontents'])) {
                $contents = $_POST['ajaxmailcontents'];
            }
        }
        if ($friendmail == '') {
            if (isset($_POST['ajaxfriendmail'])) {
                $friendmail = $_POST['ajaxfriendmail'];
            }
        }


        if (isset($_POST['dealerid'])) {
            $dealerid = $_POST['dealerid'];   // user id for dealer
        }
        if (isset($_POST['automobile_terms_page'])) {
            $automobile_terms_page = 'on';
            $automobile_contact_terms = isset($_POST['automobile_contact_terms']) ? $_POST['automobile_contact_terms'] : '';
        } else {
            $automobile_terms_page = 'off';
            $automobile_contact_terms = '';
        }

        $subject = automobile_var_plugin_text_srt('automobile_var_mail_friend_subject');
        $admin_email_from = get_option('admin_email');

        $automobile_user_id = $dealerid;
        $user_info = get_userdata($automobile_user_id);
        $admin_email = '';
        if (isset($user_info->user_email) && $user_info->user_email <> '') {
            $admin_email = $user_info->user_email;
        }
        if (strlen($name) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_name') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } else if (strlen($email) == 0) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_enter_email') . "</span><br/>";
            $error = 1;
            $error_result = 1;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $results = " '" . $email . "' " . "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_email_not_valid') . "</span>";
            $error = 1;
            $error_result = 1;
        } else if (automobile_captcha_verify(true)) {
            $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_captcha_validate') . "</span>";
            $error = 1;
            $error_result = 1;
        }

        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";

        $contents = 'Name:' . $name . "\n" . 'Email:' . $email . "\n" . 'Phone:' . $phone . "\n" . $friendmail . "\n" . $contents;
        if ($error == 0) {
            $respose = @mail($friendmail, $subject, $contents, $headers, '');
            if ($respose) {
                $error = 0;
                $error_result = 0;
                $results = automobile_var_plugin_text_srt('automobile_var_inquery_sent');
            } else {
                $error = 1;
                $error_result = 1;
                $results = "&nbsp; <span style=\"color: #ff0000;\">" . automobile_var_plugin_text_srt('automobile_var_not_sent') . "</span>";
            }
        }

        if ($error_result == 1) {
            $data = 1;
            $message = $results . "|1";
            die($message);
        } else {
            $data = 0;
            $message = $results . "|0";
            die($message);
        }
    }

    // creating Ajax call for WordPress
    add_action('wp_ajax_nopriv_ajaxfriend_send_mail', 'ajaxfriend_send_mail');
    add_action('wp_ajax_ajaxfriend_send_mail', 'ajaxfriend_send_mail');
}
        