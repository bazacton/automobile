<?php
/**
 * Core Functions of Plugin
 * @return
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('automobile_var_plugin_core_functions')) {

    class automobile_var_plugin_core_functions {

        public function __construct() {
            add_action('save_post', array($this, 'automobile_var_save_custom_option'));

            // Inventory Makes Custom Fields
            add_action('create_inventory-make', array($this, 'save_inventory_makes_custom_fields'));
            add_action('edited_inventory-make', array($this, 'save_inventory_makes_custom_fields'));
            add_action('inventory-make_edit_form_fields', array($this, 'edit_inventory_makes_custom_fields'));
            add_action('inventory-make_add_form_fields', array($this, 'inventory_makes_custom_fields'));
        }

        /**
         * Save Custom Fields
         * of Post Types
         * @return
         */
        public function automobile_var_save_custom_option($post_id = '') {
            global $post, $automobile_inventory_type_fields, $automobile_inventory_type_meta;

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            $automobile_var_data = array();
            foreach ($_POST as $key => $value) {
                if (strstr($key, 'automobile_')) {
                    if ($key == 'automobile_transaction_expiry_date' || $key == 'automobile_inventory_expired' || $key == 'automobile_inventory_posted' || $key == 'automobile_user_last_activity_date' || $key == 'automobile_user_last_activity_date') {
                        if (($key == 'automobile_user_last_activity_date' && $value == '') || $key == 'automobile_user_last_activity_date') {
                            $value = date('d-m-Y H:i:s');
                        }
                        $automobile_var_data[$key] = strtotime($value);
                        update_post_meta($post_id, $key, strtotime($value));
                    } else if ($key == 'automobile_inventory_makes' && get_post_type() == 'inventory') {
                        wp_set_post_terms($post_id, $value, 'inventory-make', false);
                    } else if ($key == 'automobile_inventory_models' && get_post_type() == 'inventory') {
                        wp_set_post_terms($post_id, $value, 'inventory-model', false);
                    } else {
                        $automobile_var_data[$key] = $value;
                        if ($key == 'automobile_inventory_new_price') {
                            $value = preg_replace('/\D/', '', $value);
                        }

                        update_post_meta($post_id, $key, $value);
                        if ($key == 'automobile_cus_field' && get_post_type() != 'inventory-type') {
                            if (is_array($value) && sizeof($value) > 0) {
                                foreach ($value as $c_key => $c_val) {
                                    update_post_meta($post_id, $c_key, $c_val);
                                }
                            }
                        }
                    }
                }
                if (get_post_type() == 'inventory-type') {
                    if (!array_key_exists('automobile_inventory_type_makes', $_POST)) {
                        update_post_meta($post_id, 'automobile_inventory_type_makes', '');
                    }
                }
            }

            update_post_meta($post_id, 'automobile_var_full_data', $automobile_var_data);
            update_post_meta($post_id, 'automobile_array_data', $automobile_var_data);

            if (get_post_type() == 'inventory-type') {
                $automobile_inventory_type_fields->automobile_update_custom_fields($post_id);
                $automobile_inventory_type_meta->features_save($post_id);
            }
            //}
        }

        /**
         * Get attachment id
         * from url
         * @return id
         */
        public function automobile_var_get_attachment_id($attachment_url) {
            global $wpdb;
            $attachment_id = false;
            
            //$attachment_id = attachment_url_to_postid($attachment_url);
            //return $attachment_id;
            // If there is no url, return.
            if ('' == $attachment_url)
                return;
            // Get the upload directory paths 
            $upload_dir_paths = wp_upload_dir();
            
            if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {
                
                // If this is the URL of an auto-generated thumbnail, get the URL of the original image 
                $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
                
                // Remove the upload path base directory from the attachment URL 
                $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);
                
                $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
            }
            return $attachment_id;
        }

        /*
         * Pagination 
         */

        public function automobile_var_plugin_pagination($total_pages = 1, $page = 1, $shortcode_paging = '') {
            global $automobile_var_plugin_static_text;
            $query_string = $_SERVER['QUERY_STRING'];
            $base = get_permalink() . '?' . remove_query_arg($shortcode_paging, $query_string) . '%_%';

            $automobile_var_pagination = paginate_links(array(
                'base' => @add_query_arg($shortcode_paging, '%#%'),
                'format' => '&' . $shortcode_paging . '=%#%', // this defines the query parameter that will be used, in this case "p"
                'prev_text' => '<i class="icon-angle-left"></i> ' . automobile_var_plugin_text_srt('automobile_var_previous'), // text for previous page
                'next_text' => automobile_var_plugin_text_srt('automobile_var_next') . ' <i class="icon-angle-right"></i>', // text for next page
                'total' => $total_pages, // the total number of pages we have
                'current' => $page, // the current page
                'end_size' => 1,
                'mid_size' => 2,
                'type' => 'array',
            ));
            $automobile_var_pages = '';
            if (is_array($automobile_var_pagination) && sizeof($automobile_var_pagination) > 0) {
                $automobile_var_pages .= '<ul class="pagination">';
                foreach ($automobile_var_pagination as $automobile_var_link) {
                    if (strpos($automobile_var_link, 'current') !== false) {
                        $automobile_var_pages .= '<li><a class="active">' . preg_replace("/[^0-9]/", "", $automobile_var_link) . '</a></li>';
                    } else {
                        $automobile_var_pages .= '<li>' . $automobile_var_link . '</li>';
                    }
                }
                $automobile_var_pages .= '</ul>';
            }
            echo force_balance_tags($automobile_var_pages);
        }

        /*
         * Pagination 
         */

        public function automobile_var_plugin_ajax_pagination($total_pages = 1, $page = 1, $shortcode_paging = '') {
            global $automobile_var_plugin_static_text;
            $query_string = $_SERVER['QUERY_STRING'];
            $base = get_permalink() . '?' . remove_query_arg($shortcode_paging, $query_string) . '%_%';

            $automobile_var_pagination = paginate_links(array(
                'base' => @add_query_arg($shortcode_paging, '%#%'),
                'format' => '&' . $shortcode_paging . '=%#%', // this defines the query parameter that will be used, in this case "p"
                'prev_text' => automobile_var_plugin_text_srt('automobile_var_previous'), // text for previous page
                'next_text' => automobile_var_plugin_text_srt('automobile_var_next'), // text for next page
                'total' => $total_pages, // the total number of pages we have
                'current' => $page, // the current page
                'end_size' => 1,
                'mid_size' => 2,
                'type' => 'array',
            ));
            $automobile_var_pages = '';
            if (is_array($automobile_var_pagination) && sizeof($automobile_var_pagination) > 0) {
                $automobile_var_pages .= '<div class="nav-links">';
                foreach ($automobile_var_pagination as $automobile_var_link) {
                    if (strpos($automobile_var_link, 'current') !== false) {
                        $automobile_var_pages .= '<span class="page-numbers current">' . preg_replace("/[^0-9]/", "", $automobile_var_link) . '</span>';
                    } else {
                        if (strip_tags($automobile_var_link) == automobile_var_plugin_text_srt('automobile_var_previous')) {
                            $automobile_var_pages .= '<a class="prev page-numbers" href="javascript:;" onclick="automobile_ajax_pagination(' . ($page - 1) . ')">' . strip_tags($automobile_var_link) . '</a>';
                        } elseif (strip_tags($automobile_var_link) == automobile_var_plugin_text_srt('automobile_var_next')) {
                            $automobile_var_pages .= '<a class="next page-numbers" href="javascript:;" onclick="automobile_ajax_pagination(' . ($page + 1) . ')">' . strip_tags($automobile_var_link) . '</a>';
                        } else {
                         $automobile_var_link =str_replace(";","",$automobile_var_link);
                         $automobile_var_link =str_replace("&","",$automobile_var_link);
						 $automobile_var_link =str_replace("hellip","...",$automobile_var_link);
						 if (strpos($automobile_var_link, 'dots') !== false) {
							$automobile_var_pages .= '<a class="page-numbers" href="javascript:;">' . strip_tags($automobile_var_link) . '</a>';
						 }
						 else {
							$automobile_var_pages .= '<a class="page-numbers" href="javascript:;" onclick="automobile_ajax_pagination(' . strip_tags($automobile_var_link) . ')">' . strip_tags($automobile_var_link) . '</a>';
						  }
                        }
                    }
                }
                $automobile_var_pages .= '</div>';
            }
            echo '<form name="pagination_form_val" id="pagination_form_val">';
            foreach ($_REQUEST as $request_key => $request_val) {
                if ($request_key != 'page_inventory' && $request_key != 'action' && $request_key != 'automobile_inv_elem_atts'&& $request_key != 'page_url') {
                    echo '<input type="hidden" name="' . $request_key . '" value="' . $request_val . '">';
                }
            }
            echo '</form>';
            echo force_balance_tags($automobile_var_pages);
        }

        /**
         * Include any template file 
         * with wordpress standards
         */
        public function automobile_var_get_template_part($slug, $name = '', $ext_template = '') {
            $template = '';

            if ($ext_template != '') {
                $ext_template = trailingslashit($ext_template);
            }
            if ($name) {
                $template = locate_template(array("{$slug}-{$name}.php", automobile_var()->template_path() . "{$ext_template}{$slug}-{$name}.php"));
            }
            if (!$template && $name && file_exists(automobile_var()->plugin_path() . "/templates/{$ext_template}{$slug}-{$name}.php")) {
                $template = automobile_var()->plugin_path() . "/templates/{$ext_template}{$slug}-{$name}.php";
            }
            if (!$template) {
                $template = locate_template(array("{$slug}.php", automobile_var()->template_path() . "{$ext_template}{$slug}.php"));
            }
            if ($template) {
                load_template($template, false);
            }
        }

        public function inventory_makes_custom_fields($tag) {
            global $automobile_form_fields;
        }

        function get_attached_models($id = '') {

            $automobile_category_array = array();
            $args = array(
                'type' => 'post',
                'child_of' => 0,
                'parent' => '',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => 0,
                'hierarchical' => 1,
                'exclude' => array($id),
                'include' => '',
                'number' => '',
                'taxonomy' => 'inventory-make',
                'pad_counts' => false
            );

            $inventory_makes = get_categories($args);

            if (is_array($inventory_makes) && sizeof($inventory_makes) > 0) {
                foreach ($inventory_makes as $inv_make) {
                    if (is_object($inv_make)) {
                        $inv_term_id = $inv_make->term_id;
                        $automobile_aut_categories = get_term_meta($inv_term_id, "automobile_inventory_make_models", true);
                        if (is_array($automobile_aut_categories)) {
                            $automobile_category_array = array_merge($automobile_category_array, $automobile_aut_categories);
                        }
                    }
                }
            }

            return array_unique($automobile_category_array);
        }

        public function edit_inventory_makes_custom_fields($tag) {    //check for existing featured ID
            global $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_static_text;

            if (isset($tag->term_id)) {
                $t_id = $tag->term_id;
            } else {
                $t_id = "";
            }

            $attached_array = $this->get_attached_models($t_id);

            $args = array(
                'type' => 'post',
                'child_of' => 0,
                'parent' => '',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => 0,
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'number' => '',
                'taxonomy' => 'inventory-model',
                'pad_counts' => false
            );

            $categories = get_categories($args);
            $inventory_categories_array = get_term_meta($t_id, "automobile_inventory_make_models", true);
            $tax_options = '<option value="">-- ' . automobile_var_plugin_text_srt('automobile_var_select_models') . ' --</option>';
            if ($categories) {
                foreach ($categories as $category) {
                    $selected = '';
                    if (is_array($attached_array) && !in_array($category->slug, $attached_array)) {

                        if (is_array($inventory_categories_array) && in_array($category->slug, $inventory_categories_array)) {
                            $selected = 'selected="selected"';
                        }

                        $tax_options .= '<option value="' . $category->slug . '" ' . $selected . '>' . $category->name . '</option>';
                    }
                }
            }
            ?>

            <tr>
                <th><label for="cat_f_models"> <?php echo automobile_var_plugin_text_srt('automobile_var_models'); ?></label></th>
                <td>
                    <ul class="form-elements" style="margin:0; padding:0;">
                        <li class="to-field" style="width:50%;">
                            <?php
                            $automobile_opt_array = array(
                                'std' => '',
                                'id' => 'inventory_make_models',
                                'classes' => 'chosen-select',
                                'options_markup' => true,
                                'options' => $tax_options,
                                'return' => false,
                            );

                            $automobile_form_fields->automobile_form_multiselect_render($automobile_opt_array);
                            ?>
                        </li>
                    </ul>
                </td>
            </tr>
            <?php
        }

        /**
         * Start Function how to 
         * save extra inventory
         * Makes fields
         */
        public function save_inventory_makes_custom_fields($term_id) {
            if (isset($_POST['automobile_inventory_make_models'])) {
                $t_id = $term_id;

                $inventory_make_models = '';
                if (isset($_POST['automobile_inventory_make_models'])) {
                    $inventory_make_models = $_POST['automobile_inventory_make_models'];
                }

                update_term_meta($t_id, "automobile_inventory_make_models", $inventory_make_models);
            }
        }

        /*
         * front end location fields
         */

        public function automobile_location_fields_front($inventory_id = '', $field_postfix = '') {
            global $automobile_var_plugin_options, $post, $automobile_html_fields, $automobile_form_fields, $automobile_var_plugin_static_text;

            $automobile_map_latitude = isset($automobile_var_plugin_options['map_latitude']) ? $automobile_var_plugin_options['map_latitude'] : '';
            $automobile_map_longitude = isset($automobile_var_plugin_options['map_longitude']) ? $automobile_var_plugin_options['map_longitude'] : '';
            $automobile_map_zoom = isset($automobile_var_plugin_options['map_zoom']) ? $automobile_var_plugin_options['map_zoom'] : '2';
            $automobile_array_data = '';

            if ($inventory_id != '') {  // get values from postmeta
                $automobile_array_data = get_post_meta($inventory_id, 'automobile_array_data', true);
                if (isset($automobile_array_data) && !empty($automobile_array_data)) {
                    $automobile_post_loc_city = get_post_meta($inventory_id, 'automobile_post_loc_city', true);
                    $automobile_post_loc_country = get_post_meta($inventory_id, 'automobile_post_loc_country', true);
                    $automobile_post_loc_latitude = get_post_meta($inventory_id, 'automobile_post_loc_latitude', true);
                    $automobile_post_loc_longitude = get_post_meta($inventory_id, 'automobile_post_loc_longitude', true);
                    $automobile_post_loc_zoom = get_post_meta($inventory_id, 'automobile_post_loc_zoom', true);
                    $automobile_post_loc_address = get_post_meta($inventory_id, 'automobile_post_loc_address', true);
                    $automobile_post_comp_address = get_post_meta($inventory_id, 'automobile_post_comp_address', true);
                    $automobile_add_new_loc = get_post_meta($inventory_id, 'automobile_add_new_loc', true);
                }
            } else {
                $automobile_post_loc_country = '';
                $automobile_post_loc_region = '';
                $automobile_post_loc_city = '';
                $automobile_post_loc_address = '';
                $automobile_post_loc_latitude = isset($automobile_var_plugin_options['automobile_post_loc_latitude']) ? $automobile_var_plugin_options['automobile_post_loc_latitude'] : '';
                $automobile_post_loc_longitude = isset($automobile_var_plugin_options['automobile_post_loc_longitude']) ? $automobile_var_plugin_options['automobile_post_loc_longitude'] : '';
                $automobile_post_loc_zoom = isset($automobile_var_plugin_options['automobile_post_loc_zoom']) ? $automobile_var_plugin_options['automobile_post_loc_zoom'] : '';
                $loc_city = '';
                $loc_postcode = '';
                $loc_region = '';
                $loc_country = '';
                $event_map_switch = '';
                $event_map_heading = '';
                $automobile_add_new_loc = '';
                $automobile_post_comp_address = '';
            }

            if ($automobile_post_loc_latitude == '')
                $automobile_post_loc_latitude = $automobile_map_latitude;
            if ($automobile_post_loc_longitude == '')
                $automobile_post_loc_longitude = $automobile_map_longitude;
            if ($automobile_post_loc_zoom == '')
                $automobile_post_loc_zoom = $automobile_map_zoom;
            $automobile_var = new automobile_var();

            $automobile_var->automobile_google_place_scripts();
            $automobile_var->automobile_location_gmap_script();
            $automobile_var->automobile_autocomplete_scripts();

            /**
             * How to get countries againts location Function Start
             *
             */
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
            $location_countries_list = '';
            $location_states_list = '';
            $location_cities_list = '';
            $iso_code_list_main = '';
            $iso_code_list_admin = '';
            $iso_code = '';
            $iso_code_list = '';

            if (isset($automobile_location_countries) && !empty($automobile_location_countries)) {
                $selected_iso_code = '';
                if (is_array($automobile_location_countries)) {
                    foreach ($automobile_location_countries as $key => $country) {
                        $selected = '';
                        $t_id_main = $country->term_id;
                        $iso_code_list_main = get_option("iso_code_$t_id_main");
                        if (isset($iso_code_list_main['text'])) {
                            $iso_code_list_admin = $iso_code_list_main['text'];
                        }
                        if (isset($automobile_post_loc_country) && $automobile_post_loc_country == $country->slug) {
                            $selected = 'selected';
                            $t_id = $country->term_id;
                            $iso_code_list = get_option("iso_code_$t_id");
                            if (isset($iso_code_list['text'])) {
                                $selected_iso_code = $iso_code_list['text'];
                            }
                        }
                        $location_countries_list .= "<option " . $selected . "  value='" . $country->slug . "' data-name='" . $iso_code_list_admin . "'>" . $country->name . "</option>";
                    }
                }
            }
            $selected_country = $automobile_post_loc_country;
            $selected_city = $automobile_post_loc_city;
            if (isset($automobile_location_countries) && !empty($automobile_location_countries) && isset($automobile_post_loc_country) && !empty($automobile_post_loc_country)) {
                // load all cities against state  
                $cities = '';
                $selected_spec = get_term_by('slug', $selected_country, 'automobile_locations');
                if (isset($selected_spec->term_id)) {
                    $state_parent_id = $selected_spec->term_id;
                } else {
                    $state_parent_id = '';
                }
                $states_args = array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'fields' => 'all',
                    'slug' => '',
                    'hide_empty' => false,
                    'parent' => $state_parent_id,
                );
                $cities = get_terms('automobile_locations', $states_args);
                if (isset($cities) && $cities != '' && is_array($cities)) {
                    foreach ($cities as $key => $city) {
                        $selected = ( $selected_city == $city->slug) ? 'selected' : '';
                        $location_cities_list .= "<option " . $selected . " value='" . $city->slug . "'>" . $city->name . "</option>";
                    }
                }
            }
            ?>

            <fieldset id="fe_map<?php echo absint($field_postfix) ?>"  class="gllpLatlonPicker"  style="width:100%; float:left;">
                <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;" id="locations_wrap" data-themeurl="<?php echo automobile_var::plugin_url(); ?>" data-plugin_url="<?php echo automobile_var::plugin_url(); ?>" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php'), 'cs-automobile'); ?>" data-map_marker="<?php echo automobile_var::plugin_url(); ?>/assets/images/map-marker.png">
                    <div class="option-sec" style="margin-bottom:0;">

                        <div class="opt-conts">
                            <?php
                            global $automobile_form_fields;
                            ?>
                            <?php
                            $output = '';
                            $automobile_opt_array = array(
                                'name' => automobile_var_plugin_text_srt('automobile_var_country'),
                                'desc' => '',
                                'std' => $automobile_post_loc_country,
                                'id' => 'loc_country',
                                'cust_id' => 'loc_country',
                                'cust_name' => 'automobile_post_loc_country',
                                'classes' => 'chosen-select form-select-country dir-map-search single-select SlectBox',
                                'options_markup' => true,
                                'return' => true,
                            );

                            if (isset($value['contry_hint']) && $value['contry_hint'] != '') {
                                $automobile_opt_array['hint_text'] = $value['contry_hint'];
                            }

                            if (isset($location_countries_list) && $location_countries_list != '') {
                                $automobile_opt_array['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_country') . '</option>' . $location_countries_list;
                            } else {
                                $automobile_opt_array['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_country') . '</option>';
                            }

                            if (isset($value['split']) && $value['split'] <> '') {
                                $automobile_opt_array['split'] = $value['split'];
                            }
                            $output .= '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>' .__( 'Country', 'cs-automobile' ) . '</label>
										</div><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
											<div class="cs-field">';
                            $output .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
                            $output .= '</div></div></div>';
                            $automobile_opt_array = array(
                                'name' => automobile_var_plugin_text_srt('automobile_var_city'),
                                'id' => 'loc_city',
                                'desc' => '',
                                'std' => '',
                                'id' => 'loc_city',
                                'cust_id' => 'loc_city',
                                'cust_name' => 'automobile_post_loc_city',
                                'classes' => 'chosen-select form-select-city dir-map-search single-select',
                                'markup' => '<span class="loader-cities"></span>',
                                'options_markup' => true,
                                'return' => true,
                            );
                            if (isset($value['city_hint']) && $value['city_hint'] != '') {
                                $automobile_opt_array['hint_text'] = $value['city_hint'];
                            }
                            if (isset($location_cities_list) && $location_cities_list != '') {
                                $automobile_opt_array['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_city') . '</option>' . $location_cities_list;
                            } else {
                                $automobile_opt_array['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_city') . '</option>';
                            }
                            if (isset($value['split']) && $value['split'] <> '') {
                                $automobile_opt_array['split'] = $value['split'];
                            }
                            $output .= '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>' . __( 'City', 'cs-automobile' ) . '</label>
										</div><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
											<div class="cs-field">';
                            $output .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
                            $output .= '</div></div></div>';
                            $automobile_opt_array = array(
                                'name' => automobile_var_plugin_text_srt('automobile_var_complete_address'),
                                'desc' => '',
                                'hint_text' => automobile_var_plugin_text_srt('automobile_var_address_with_city'),
                                'std' => $automobile_post_comp_address,
                                'id' => 'complete_address',
                                'cust_id' => 'complete_address',
                                'cust_name' => 'automobile_post_comp_address',
                                'return' => true,
                            );

                            if (isset($value['address_hint']) && $value['address_hint'] != '') {
                                $automobile_opt_array['hint_text'] = $value['address_hint'];
                            }
                            if (isset($value['split']) && $value['split'] <> '') {
                                $automobile_opt_array['split'] = $value['split'];
                            }
                            $output .= '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>' . __( 'Complete Address', 'cs-automobile' ) . '</label>
										</div><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
											<div class="cs-field">';

                            $output .= $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
                            $output .= '</div></div></div>';
                            $output .= '<div class="theme-help" id="mailing_information">
                                                        <h4 style="padding-bottom:0px;">' . automobile_var_plugin_text_srt('automobile_var_find_on_map') . '</h4>
                                                        <div class="clear"></div>
                                                </div>';

                            $automobile_opt_array_address = array(
                                'name' => automobile_var_plugin_text_srt('automobile_var_address'),
                                'desc' => '',
                                'std' => '',
                                'id' => 'loc_address',
                                'classes' => 'directory-search-locationa',
                                'extra_atr' => 'onkeypress="automobile_gl_search_map(this.value)",placeholder="' . automobile_var_plugin_text_srt('automobile_var_latitude') . '"',
                                'cust_id' => 'loc_address',
                                'cust_name' => 'automobile_post_loc_address',
                                'return' => true,
                            );

                            if (isset($value['address_hint']) && $value['address_hint'] != '') {
                                $automobile_opt_array_address['hint_text'] = $value['address_hint'];
                            }
                            if (isset($value['split']) && $value['split'] <> '') {
                                $automobile_opt_array_address['split'] = $value['split'];
                            }

                            //$output .= $automobile_html_fields->automobile_text_field($automobile_opt_array_address);
                            $automobile_opt_array_lat = array(
                                'name' => automobile_var_plugin_text_srt('automobile_var_latitude'),
                                'id' => 'post_loc_latitude',
                                'desc' => '',
                                //'styles' => 'display:none;',
                                'std' => $automobile_post_loc_latitude,
                                'id' => 'post_loc_latitude',
                                'cust_name' => 'automobile_post_loc_latitude',
                                //'cust_type' => 'hidden',
                                'classes' => 'gllpLatitude',
                                'return' => true,
                                'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_latitude') . '"',
                            );

                            if (isset($value['split']) && $value['split'] <> '') {
                                $automobile_opt_array_lat['split'] = $value['split'];
                            }

                            // $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array_lat);
                            $automobile_opt_array_Long = array(
                                'name' => automobile_var_plugin_text_srt('automobile_var_longitude'),
                                'id' => 'post_loc_longitude',
                                'desc' => '',
                                'std' => $automobile_post_loc_longitude,
                                'id' => 'post_loc_longitude',
                                'cust_name' => 'automobile_post_loc_longitude',
                                'classes' => 'gllpLongitude',
                                'return' => true,
                                'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_longitude') . '"',
                            );

                            if (isset($value['split']) && $value['split'] <> '') {
                                $automobile_opt_array_Long['split'] = $value['split'];
                            }

                            $automobile_opt_array_btn = array(
                                'name' => '',
                                'id' => 'map_search_btn',
                                'desc' => '',
                                'std' => '',
                                'id' => 'map_search_btn',
                                'cust_type' => 'button',
                                'classes' => 'gllpSearchButton cs-bgcolor',
                                'return' => true,
                            );

                            if (isset($value['split']) && $value['split'] <> '') {
                                $automobile_opt_array_btn['split'] = $value['split'];
                            }

                            $automobile_opt_array = array(
                                'id' => 'add_new_loc',
                                'std' => $automobile_add_new_loc,
                                'cust_type' => 'hidden',
                                'classes' => 'gllpSearchField_fe',
                                'return' => true,
                            );

                            $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                            $automobile_opt_array = array(
                                'id' => 'post_loc_zoom',
                                'std' => $automobile_post_loc_zoom,
                                'cust_type' => 'hidden',
                                'classes' => 'gllpZoom',
                                'return' => true,
                            );

                            $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                            $output .= '<div class="clear"></div>';
                            $output .= '<div class="cs-field-holder">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<label>' . automobile_var_plugin_text_srt('automobile_var_location') . '</label>
										</div>
										<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
											<div class="cs-field">
												<div class="main-search account-search">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="select-location">
                                                                   ' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array_address) . '
                                                                    <a href="#" class="location-btn pop"><i class="icon-target3"></i></a>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                                <div class="select-location">
                                                                    ' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array_lat) . '
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="select-location">
                                                                    ' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array_Long) . '
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                                <div class="search-btn">
                                                                 <i class="icon-search3"></i>
                                                                    ' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array_btn) . '
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
												
												
												<div class="clear"></div><div class="cs-map-section cs-map-holder"><div style="width:100%; height:200px;" class="gllpMap" id="cs-map-location-fe-id"></div></div>
												
												
											</div>
										</div>
									</div>';

                            $output .= '</div></div></div></fieldset>';

                            echo balanceTags($output);
                            ?>
                            <?php $automobile_var->automobile_google_place_scripts(); ?>
                            </fieldset>

                            <script type="text/javascript">


                                "use strict";
                                window.autocomplete;
                                jQuery(document).ready(function () {
                                    //automobile_load_location_ajax();
                                });
                                jQuery(document).ready(function () {

                                    automobile_fe_search_map();
                                    automobile_load_location_ajax();
                                    if (jQuery("#fe_map<?php echo absint($field_postfix) ?> #cs-map-location-fe-id").hasClass("gllpMap")) {
                                        var vals;
                                        automobile_map_location_load('<?php echo absint($field_postfix); ?>');
                                        if (vals)
                                            automobile_search_map(vals);
                                    }
                                });

                                function automobile_fe_search_map() {

                                    var vals;
                                    vals = jQuery('#fe_map<?php echo absint($field_postfix) ?> #loc_address').val();
                                    jQuery('#fe_map<?php echo absint($field_postfix); ?> .gllpSearchField_fe').val(vals);
                                }

                                /*
                                 function automobile_gl_search_map() {
                                             
                                 var vals;
                                 vals = jQuery('#loc_address').val();
                                 vals = vals + ", " + jQuery('#loc_city').val();
                                 vals = vals + ", " + jQuery('#loc_region').val();
                                 vals = vals + ", " + jQuery('#loc_country').val();
                                 jQuery('.gllpSearchField').val(vals);
                                             
                                 }
                                 */
                                //var autocomplete = '';
                                jQuery(document).ready(function ($) {
                                    $(function () {


                                        autocomplete = new google.maps.places.Autocomplete(document.getElementById('loc_address'));
            <?php if (isset($selected_iso_code) && !empty($selected_iso_code)) { ?>
                                            autocomplete.setComponentRestrictions({'country': '<?php echo $selected_iso_code; ?>'});

                <?php
            }
            ?>
                                    });
                                });
                                /*
                                 jQuery(document).ready(function () {
                                 automobile_map_location_load('inventory');
                                             
                                 // new addition
                                 });
                                 */
                            </script>
                            <?php
                        }

                        /*
                         * front end location fields ends
                         */

                        public function automobile_location_fields($user = '') {
                            global $automobile_var_plugin_options, $post, $automobile_html_fields, $automobile_form_fields, $automobile_var_plugin_static_text;
                            $strings = new automobile_plugin_all_strings;
                            $strings->automobile_var_plugin_option_strings();

                            $automobile_map_latitude = isset($automobile_var_plugin_options['map_latitude']) ? $automobile_var_plugin_options['map_latitude'] : '';
                            $automobile_map_longitude = isset($automobile_var_plugin_options['map_longitude']) ? $automobile_var_plugin_options['map_longitude'] : '';
                            $automobile_map_zoom = isset($automobile_var_plugin_options['map_zoom']) ? $automobile_var_plugin_options['map_zoom'] : '2';
                            $automobile_array_data = '';
                            if (isset($user) && !empty($user)) { // get values from usermeta
                                $automobile_array_data = get_the_author_meta('automobile_array_data', $user->ID);
                                if (isset($automobile_array_data) && !empty($automobile_array_data)) {
                                    $automobile_post_loc_city = get_the_author_meta('automobile_post_loc_city', $user->ID);
                                    $automobile_post_loc_country = get_the_author_meta('automobile_post_loc_country', $user->ID);
                                    $automobile_post_loc_latitude = get_the_author_meta('automobile_post_loc_latitude', $user->ID);
                                    $automobile_post_loc_longitude = get_the_author_meta('automobile_post_loc_longitude', $user->ID);
                                    $automobile_post_loc_zoom = get_the_author_meta('automobile_post_loc_zoom', $user->ID);
                                    $automobile_post_loc_address = get_the_author_meta('automobile_post_loc_address', $user->ID);
                                    $automobile_post_comp_address = get_the_author_meta('automobile_post_comp_address', $user->ID);
                                    $automobile_add_new_loc = get_the_author_meta('automobile_add_new_loc', $user->ID);
                                } else {
                                    $automobile_post_loc_country = '';
                                    $automobile_post_loc_region = '';
                                    $automobile_post_loc_city = '';
                                    $automobile_post_loc_address = '';
                                    $automobile_post_loc_latitude = isset($automobile_var_plugin_options['automobile_post_loc_latitude']) ? $automobile_var_plugin_options['automobile_post_loc_latitude'] : '';
                                    $automobile_post_loc_longitude = isset($automobile_var_plugin_options['automobile_post_loc_longitude']) ? $automobile_var_plugin_options['automobile_post_loc_longitude'] : '';
                                    $automobile_post_loc_zoom = isset($automobile_var_plugin_options['automobile_post_loc_zoom']) ? $automobile_var_plugin_options['automobile_post_loc_zoom'] : '';
                                    $loc_city = '';
                                    $loc_postcode = '';
                                    $loc_region = '';
                                    $loc_country = '';
                                    $event_map_switch = '';
                                    $event_map_heading = '';
                                    $automobile_add_new_loc = '';
                                    $automobile_post_comp_address = '';
                                }
                            } else {  // get values from postmeta
                                $automobile_array_data = get_post_meta($post->ID, 'automobile_array_data', true);
                                if (isset($automobile_array_data) && !empty($automobile_array_data)) {
                                    $automobile_post_loc_city = get_post_meta($post->ID, 'automobile_post_loc_city', true);
                                    $automobile_post_loc_country = get_post_meta($post->ID, 'automobile_post_loc_country', true);
                                    $automobile_post_loc_latitude = get_post_meta($post->ID, 'automobile_post_loc_latitude', true);
                                    $automobile_post_loc_longitude = get_post_meta($post->ID, 'automobile_post_loc_longitude', true);
                                    $automobile_post_loc_zoom = get_post_meta($post->ID, 'automobile_post_loc_zoom', true);
                                    $automobile_post_loc_address = get_post_meta($post->ID, 'automobile_post_loc_address', true);
                                    $automobile_post_comp_address = get_post_meta($post->ID, 'automobile_post_comp_address', true);
                                    $automobile_add_new_loc = get_post_meta($post->ID, 'automobile_add_new_loc', true);
                                } else {
                                    $automobile_post_loc_country = '';
                                    $automobile_post_loc_region = '';
                                    $automobile_post_loc_city = '';
                                    $automobile_post_loc_address = '';
                                    $automobile_post_loc_latitude = isset($automobile_var_plugin_options['automobile_post_loc_latitude']) ? $automobile_var_plugin_options['automobile_post_loc_latitude'] : '';
                                    $automobile_post_loc_longitude = isset($automobile_var_plugin_options['automobile_post_loc_longitude']) ? $automobile_var_plugin_options['automobile_post_loc_longitude'] : '';
                                    $automobile_post_loc_zoom = isset($automobile_var_plugin_options['automobile_post_loc_zoom']) ? $automobile_var_plugin_options['automobile_post_loc_zoom'] : '';
                                    $loc_city = '';
                                    $loc_postcode = '';
                                    $loc_region = '';
                                    $loc_country = '';
                                    $event_map_switch = '';
                                    $event_map_heading = '';
                                    $automobile_add_new_loc = '';
                                    $automobile_post_comp_address = '';
                                }
                            }
                            if ($automobile_post_loc_latitude == '')
                                $automobile_post_loc_latitude = $automobile_map_latitude;
                            if ($automobile_post_loc_longitude == '')
                                $automobile_post_loc_longitude = $automobile_map_longitude;
                            if ($automobile_post_loc_zoom == '')
                                $automobile_post_loc_zoom = $automobile_map_zoom;
                            $automobile_var = new automobile_var();

                            $automobile_var->automobile_google_place_scripts();
                            $automobile_var->automobile_location_gmap_script();
                            $automobile_var->automobile_autocomplete_scripts();

                            /**
                             * How to get countries againts location Function Start
                             *
                             */
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
                            $location_countries_list = '';
                            $location_states_list = '';
                            $location_cities_list = '';
                            $iso_code_list_main = '';
                            $iso_code_list_admin = '';
                            $iso_code = '';
                            $iso_code_list = '';

                            if (isset($automobile_location_countries) && !empty($automobile_location_countries)) {
                                $selected_iso_code = '';
                                if (is_array($automobile_location_countries)) {
                                    foreach ($automobile_location_countries as $key => $country) {
                                        $selected = '';
                                        $t_id_main = $country->term_id;
                                        $iso_code_list_main = get_option("iso_code_$t_id_main");
                                        if (isset($iso_code_list_main['text'])) {
                                            $iso_code_list_admin = $iso_code_list_main['text'];
                                        }
                                        if (isset($automobile_post_loc_country) && $automobile_post_loc_country == $country->slug) {
                                            $selected = 'selected';
                                            $t_id = $country->term_id;
                                            $iso_code_list = get_option("iso_code_$t_id");
                                            if (isset($iso_code_list['text'])) {
                                                $selected_iso_code = $iso_code_list['text'];
                                            }
                                        }
                                        $location_countries_list .= "<option " . $selected . "  value='" . $country->slug . "' data-name='" . $iso_code_list_admin . "'>" . $country->name . "</option>";
                                    }
                                }
                            }
                            $selected_country = $automobile_post_loc_country;
                            $selected_city = $automobile_post_loc_city;
                            if (isset($automobile_location_countries) && !empty($automobile_location_countries) && isset($automobile_post_loc_country) && !empty($automobile_post_loc_country)) {
                                // load all cities against state  
                                $cities = '';
                                $selected_spec = get_term_by('slug', $selected_country, 'automobile_locations');
                                if (isset($selected_spec->term_id)) {
                                    $state_parent_id = $selected_spec->term_id;
                                } else {
                                    $state_parent_id = '';
                                }
                                $states_args = array(
                                    'orderby' => 'name',
                                    'order' => 'ASC',
                                    'fields' => 'all',
                                    'slug' => '',
                                    'hide_empty' => false,
                                    'parent' => $state_parent_id,
                                );
                                $cities = get_terms('automobile_locations', $states_args);
                                if (isset($cities) && $cities != '' && is_array($cities)) {
                                    foreach ($cities as $key => $city) {
                                        $selected = ( $selected_city == $city->slug) ? 'selected' : '';
                                        $location_cities_list .= "<option " . $selected . " value='" . $city->slug . "'>" . $city->name . "</option>";
                                    }
                                }
                            }
                            ?>
                            <fieldset class="gllpLatlonPicker"  style="width:100%; float:left;">
                                <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;" id="locations_wrap" data-themeurl="<?php echo automobile_var::plugin_url(); ?>" data-plugin_url="<?php echo automobile_var::plugin_url(); ?>" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php'), 'cs-automobile'); ?>" data-map_marker="<?php echo automobile_var::plugin_url(); ?>/assets/images/map-marker.png">
                                    <div class="option-sec" style="margin-bottom:0;">
                                        <div class="opt-conts">

                                            <?php
                                            $output = '';
                                            $automobile_opt_array = array(
                                                'name' => automobile_var_plugin_text_srt('automobile_var_country'),
                                                'desc' => '',
                                                'field_params' => array(
                                                    'std' => '',
                                                    'id' => 'loc_country',
                                                    'cust_id' => 'loc_country',
                                                    'cust_name' => 'automobile_post_loc_country',
                                                    'classes' => 'chosen-select form-select-country dir-map-search single-select SlectBox',
                                                    'options_markup' => true,
                                                    'return' => true,
                                                ),
                                            );
                                            if (isset($value['contry_hint']) && $value['contry_hint'] != '') {
                                                $automobile_opt_array['hint_text'] = $value['contry_hint'];
                                            }

                                            if (isset($location_countries_list) && $location_countries_list != '') {
                                                $automobile_opt_array['field_params']['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_country') . '</option>' . $location_countries_list;
                                            } else {
                                                $automobile_opt_array['field_params']['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_country') . '</option>';
                                            }

                                            if (isset($value['split']) && $value['split'] <> '') {
                                                $automobile_opt_array['split'] = $value['split'];
                                            }

                                            $output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);
                                            $automobile_opt_array = array(
                                                'name' => automobile_var_plugin_text_srt('automobile_var_city'),
                                                'id' => 'loc_city',
                                                'desc' => '',
                                                'field_params' => array(
                                                    'std' => '',
                                                    'id' => 'loc_city',
                                                    'cust_id' => 'loc_city',
                                                    'cust_name' => 'automobile_post_loc_city',
                                                    'classes' => 'chosen-select form-select-city dir-map-search single-select',
                                                    'markup' => '<span class="loader-cities"></span>',
                                                    'options_markup' => true,
                                                    'return' => true,
                                                ),
                                            );
                                            if (isset($value['city_hint']) && $value['city_hint'] != '') {
                                                $automobile_opt_array['hint_text'] = $value['city_hint'];
                                            }
                                            if (isset($location_cities_list) && $location_cities_list != '') {
                                                $automobile_opt_array['field_params']['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_city') . '</option>' . $location_cities_list;
                                            } else {
                                                $automobile_opt_array['field_params']['options'] = '<option value="">' . automobile_var_plugin_text_srt('automobile_var_select_city') . '</option>';
                                            }
                                            if (isset($value['split']) && $value['split'] <> '') {
                                                $automobile_opt_array['split'] = $value['split'];
                                            }
                                            $output .= $automobile_html_fields->automobile_select_field($automobile_opt_array);

                                            $automobile_opt_array = array(
                                                'name' => automobile_var_plugin_text_srt('automobile_var_complete_address'),
                                                'desc' => '',
                                                'hint_text' => automobile_var_plugin_text_srt('automobile_var_address_with_city'),
                                                'field_params' => array(
                                                    'std' => $automobile_post_comp_address,
                                                    'id' => 'complete_address',
                                                    'cust_id' => 'complete_address',
                                                    'cust_name' => 'automobile_post_comp_address',
                                                    'return' => true,
                                                ),
                                            );

                                            if (isset($value['address_hint']) && $value['address_hint'] != '') {
                                                $automobile_opt_array['hint_text'] = $value['address_hint'];
                                            }
                                            if (isset($value['split']) && $value['split'] <> '') {
                                                $automobile_opt_array['split'] = $value['split'];
                                            }

                                            $output .= $automobile_html_fields->automobile_textarea_field($automobile_opt_array);

                                            $output .= '<div class="theme-help" id="mailing_information">
                                                        <h4 style="padding-bottom:0px;">' . automobile_var_plugin_text_srt('automobile_var_find_on_map') . '</h4>
                                                        <div class="clear"></div>
                                                </div>';

                                            $automobile_opt_array = array(
                                                'name' => automobile_var_plugin_text_srt('automobile_var_address'),
                                                'desc' => '',
                                                'field_params' => array(
                                                    'std' => $automobile_post_loc_address,
                                                    'id' => 'loc_address',
                                                    'classes' => 'directory-search-locationa',
                                                    'extra_atr' => 'onkeypress="automobile_gl_search_map(this.value)"',
                                                    'cust_id' => 'loc_address',
                                                    'cust_name' => 'automobile_post_loc_address',
                                                    'return' => true,
                                                ),
                                            );

                                            if (isset($value['address_hint']) && $value['address_hint'] != '') {
                                                $automobile_opt_array['hint_text'] = $value['address_hint'];
                                            }
                                            if (isset($value['split']) && $value['split'] <> '') {
                                                $automobile_opt_array['split'] = $value['split'];
                                            }

                                            $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
                                            $automobile_opt_array = array(
                                                'name' => automobile_var_plugin_text_srt('automobile_var_latitude'),
                                                'id' => 'post_loc_latitude',
                                                'desc' => '',
                                                'field_params' => array(
                                                    'std' => $automobile_post_loc_latitude,
                                                    'id' => 'post_loc_latitude',
                                                    'cust_name' => 'automobile_post_loc_latitude',
                                                    'classes' => 'gllpLatitude',
                                                    'return' => true,
                                                ),
                                            );

                                            if (isset($value['split']) && $value['split'] <> '') {
                                                $automobile_opt_array['split'] = $value['split'];
                                            }

                                            $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
                                            $automobile_opt_array = array(
                                                'name' => automobile_var_plugin_text_srt('automobile_var_longitude'),
                                                'id' => 'post_loc_longitude',
                                                'desc' => '',
                                                'field_params' => array(
                                                    'std' => $automobile_post_loc_longitude,
                                                    'id' => 'post_loc_longitude',
                                                    'cust_name' => 'automobile_post_loc_longitude',
                                                    'classes' => 'gllpLongitude',
                                                    'return' => true,
                                                ),
                                            );

                                            if (isset($value['split']) && $value['split'] <> '') {
                                                $automobile_opt_array['split'] = $value['split'];
                                            }
                                            $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
                                            $automobile_opt_array = array(
                                                'name' => '',
                                                'id' => 'map_search_btn',
                                                'desc' => '',
                                                'field_params' => array(
                                                    'std' => automobile_var_plugin_text_srt('automobile_var_search_on_map'),
                                                    'id' => 'map_search_btn',
                                                    'cust_type' => 'button',
                                                    'classes' => 'gllpSearchButton cs-bgcolor',
                                                    'return' => true,
                                                ),
                                            );

                                            if (isset($value['split']) && $value['split'] <> '') {
                                                $automobile_opt_array['split'] = $value['split'];
                                            }

                                            $output .= $automobile_html_fields->automobile_text_field($automobile_opt_array);
                                            $output .= $automobile_html_fields->automobile_full_opening_field(array());
                                            $output .= '<div class="clear"></div>';

                                            $automobile_opt_array = array(
                                                'id' => 'add_new_loc',
                                                'std' => $automobile_add_new_loc,
                                                'cust_type' => 'hidden',
                                                'classes' => 'gllpSearchField',
                                                'return' => true,
                                            );

                                            $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            $automobile_opt_array = array(
                                                'id' => 'post_loc_zoom',
                                                'std' => $automobile_post_loc_zoom,
                                                'cust_type' => 'hidden',
                                                'classes' => 'gllpZoom',
                                                'return' => true,
                                            );

                                            $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            $output .= '<div class="clear"></div><div class="cs-map-section" style="float:left; width:100%; height:100%;"><div class="gllpMap" id="cs-map-location-fe-id"></div></div>';
                                            $output .= $automobile_html_fields->automobile_closing_field(array(
                                                'desc' => '',
                                                    )
                                            );
                                            $output .= '</div></div></div></fieldset>';

                                            echo balanceTags($output);
                                            ?>

                                            </fieldset>

                                            <script type="text/javascript">
                                                "use strict";
                                                var autocomplete;
                                                jQuery(document).ready(function () {
                                                    automobile_load_location_ajax();
                                                });

                                                function automobile_gl_search_map() {

                                                    var vals;
                                                    vals = jQuery('#loc_address').val();
                                                    jQuery('.gllpSearchField').val(vals);

                                                }

                                                jQuery(document).ready(function ($) {
                                                    $(function () {
            <?php $automobile_var->automobile_google_place_scripts() ?>
                                                        //var autocomplete = '';
                                                        autocomplete = new google.maps.places.Autocomplete(document.getElementById('loc_address'));
            <?php if (isset($selected_iso_code) && !empty($selected_iso_code)) { ?>
                                                            autocomplete.setComponentRestrictions({'country': '<?php echo $selected_iso_code; ?>'});

                <?php
            }
            ?>
                                                    });
                                                });

                                            </script>
                                            <?php
                                        }

                                        public function automobile_rand_id() {
                                            $output = rand(12345678, 98765432);
                                            return $output;
                                        }

                                    }

                                    global $automobile_var_plugin_core;
                                    $automobile_var_plugin_core = new automobile_var_plugin_core_functions();
                                }
