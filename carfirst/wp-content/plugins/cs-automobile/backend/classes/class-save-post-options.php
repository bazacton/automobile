<?php
/**
 * File Type: Plugin Functions
 */
if (!class_exists('automobile_inventory_plugin_functions')) {

    class automobile_inventory_plugin_functions {

        // The single instance of the class
        protected static $_instance = null;

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('save_post', array($this, 'automobile_save_post_option'));
            add_action('create_Specialisms', array($this, 'automobile_save_inventories_spec_fields'));
            add_action('edited_Specialisms', array($this, 'automobile_save_inventories_spec_fields'));
            add_action('Specialisms_edit_form_fields', array($this, 'automobile_edit_inventories_spec_fields'));
            add_action('Specialisms_add_form_fields', array($this, 'automobile_inventories_spec_fields'));
            add_action('create_automobile_locations', array($this, 'automobile_save_inventories_locations_fields'));
            add_action('edited_automobile_locations', array($this, 'automobile_save_inventories_locations_fields'));
            add_action('automobile_locations_edit_form_fields', array($this, 'automobile_edit_inventories_locations_fields'));
            add_action('automobile_locations_add_form_fields', array($this, 'automobile_inventories_locations_fields'));
            add_action('create_inventory_type', array($this, 'automobile_save_inventories_inventorytype_fields'));
            add_action('edited_inventory_type', array($this, 'automobile_save_inventories_inventorytype_fields'));
            add_action('inventory_type_edit_form_fields', array($this, 'automobile_edit_inventories_inventory_type_fields'));
            add_action('inventory_type_add_form_fields', array($this, 'automobile_inventories_inventory_type_fields'));
            $my_theme = wp_get_theme();

            if ($my_theme->name != 'AutoMobile') {
                add_action('media_buttons', array($this, 'reg_shortcodes_btn'), 11);
            }

            add_filter('manage_users_columns', array($this, 'automobile_new_modify_user_table'));
            add_filter('manage_users_custom_column', array($this, 'automobile_new_modify_user_table_row'), 10, 3);
            if (wp_is_mobile()) {
                add_action('wp_nav_menu_items', array($this, 'automobile_login_header_item_mobile'), 30, 2);
            }
            if (!wp_is_mobile()) {
                add_filter('wp_nav_menu_items', array($this, 'automobile_login_header_item_web'), 10, 2);
            }

            add_action('wp_footer', array($this, 'automobile_markup_append_body'));
        }

        /**
         * End construct Functions
         * Start Creating  Instance of the Class Function
         */
        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function automobile_new_modify_user_table($column) {
            $column['display_name'] = automobile_var_plugin_text_srt('automobile_var_display_name');
            $column['inventories'] = automobile_var_plugin_text_srt('automobile_var_inventories');
            return $column;
        }

        public function automobile_markup_append_body() {
            if (!is_user_logged_in()) {
                echo '<div class="cs-user-option">' . do_shortcode('[automobile_user_login register_role="automobile_dealer" without_btns="true"] [/automobile_user_login]') . '</div>';
            }
        }

        public function automobile_login_header_item_web($items, $args) {

            global $post, $automobile_var_plugin_options, $automobile_theme_options;
            if (isset($automobile_var_plugin_options['automobile_user_dashboard_switchs']) && $automobile_var_plugin_options['automobile_user_dashboard_switchs'] == 'on') {
                $automobile_menu_location = isset($automobile_var_plugin_options['automobile_menu_login_location']) ? $automobile_var_plugin_options['automobile_menu_login_location'] : '';

                if ($args->theme_location == $automobile_menu_location) {

                    $automobile_html = '';
                    $automobile_user_dashboard_switchs = 'on';
                    if (isset($automobile_var_plugin_options) && $automobile_var_plugin_options != '') {
                        if (isset($automobile_var_plugin_options['automobile_user_dashboard_switchs'])) {
                            $automobile_user_dashboard_switchs = $automobile_var_plugin_options['automobile_user_dashboard_switchs'];
                        }
                    }
                    $automobile_emp_funs = new automobile_dealer_functions();
                    if (isset($automobile_user_dashboard_switchs) and $automobile_user_dashboard_switchs == "on") {

                        if (is_user_logged_in()) {

                            ob_start();
                            $automobile_emp_funs->automobile_header_favorites();
                            echo '<li class="cs-user-option">';
                            echo do_shortcode('[automobile_user_login register_role="automobile_dealer"] [/automobile_user_login]');
                            echo '</li>';
                            $automobile_html .= ob_get_clean();
                        } else {
                            ob_start();
                            echo '<li class="cs-user-option">';
                            echo do_shortcode('[automobile_user_login register_role="automobile_dealer" btns_only="true"] [/automobile_user_login]');
                            echo '</li>';
                            $automobile_html .= ob_get_clean();
                        }
                    } else {
                        ob_start();
                        echo '<li class="cs-user-option">';
                        echo do_shortcode('[automobile_user_login register_role="automobile_dealer" btns_only="true"] [/automobile_user_login]');
                        echo '</li>';

                        $automobile_html .= ob_get_clean();
                    }

                    $items .= $automobile_html;
                }
            }
            return $items;
        }

        public function automobile_login_header_item_mobile($items, $args) {

            global $post, $automobile_var_plugin_options, $automobile_theme_options;
            if (isset($automobile_var_plugin_options['automobile_user_dashboard_switchs']) && $automobile_var_plugin_options['automobile_user_dashboard_switchs'] == 'on') {
                $automobile_menu_location = isset($automobile_var_plugin_options['automobile_menu_login_location']) ? $automobile_var_plugin_options['automobile_menu_login_location'] : '';
                $automobile_html = '';
                if ($args->theme_location == $automobile_menu_location) {

                    $automobile_user_dashboard_switchs = '';
                    if (isset($automobile_var_plugin_options) && $automobile_var_plugin_options != '') {
                        if (isset($automobile_var_plugin_options['automobile_user_dashboard_switchs'])) {
                            $automobile_user_dashboard_switchs = $automobile_var_plugin_options['automobile_user_dashboard_switchs'];
                        }
                    }
                    $automobile_emp_funs = new automobile_dealer_functions();
                    if (isset($automobile_user_dashboard_switchs) and $automobile_user_dashboard_switchs == "on") {

                        if (is_user_logged_in()) {

                            ob_start();
                            $automobile_emp_funs->automobile_header_favorites();
                            echo do_shortcode('[automobile_user_login register_role="automobile_dealer"] [/automobile_user_login]');
                            $automobile_html .= ob_get_clean();
                        } else {
                            ob_start();
                            echo do_shortcode('[automobile_user_login register_role="automobile_dealer" btns_only="true"] [/automobile_user_login]');
                            $automobile_html .= ob_get_clean();
                        }
                    } else {
                        ob_start();
                        echo do_shortcode('[automobile_user_login register_role="automobile_dealer" btns_only="true"] [/automobile_user_login]');
                        $automobile_html .= ob_get_clean();
                    }
                    //$items .= '<li class="cs-user-option">' . $automobile_html . '</li>';
                }
                echo '<div class="cs-user-option cs-mobile-menu">' . $automobile_html . '</div>';
            }
            return $items;
        }

        public function automobile_new_modify_user_table_row($val, $column_name, $user_id) {
            $user = get_userdata($user_id);
            switch ($column_name) {
                case 'display_name' :
                    $automobile_user = get_userdata($user_id);
                    $return = $automobile_user->display_name;
                    break;
                case 'inventories' :
                    $automobile_user = get_userdata($user_id);
                    $argus = array(
                        'post_type' => 'inventory',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key' => 'automobile_inventory_username',
                                'value' => $user_id,
                                'compare' => 'like',
                            ),
                        ),
                    );

                    $query = new WP_Query($argus);
                    $author_posts_link = admin_url('edit.php?author=' . $user_id . '&post_type=inventories');

                    if ($query->found_posts > 0) {
                        $return = '<a href="' . esc_url($author_posts_link) . '">' . $query->found_posts . '</a>';
                    } else {
                        $return = $query->found_posts;
                    }
                    wp_reset_postdata();
                    break;
                default:
            }
            return $return;
        }

        /**
         * End Creating  Instance Main Fuunctions
         * Start Saving Post  options Function
         */
        public function automobile_save_post_option($post_id = '') {
            global $post, $automobile_var_plugin_options;
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            $data = array();


            foreach ($_POST as $key => $value) {
                if (strstr($key, 'automobile_')) {
                    if ($key == 'automobile_transaction_expiry_date' || $key == 'automobile_inventory_expired' || $key == 'automobile_inventory_posted' || $key == 'automobile_user_last_activity_date' || $key == 'automobile_user_last_activity_date') {
                        if ($key == 'automobile_user_last_activity_date' && $value == '' || $key == 'automobile_user_last_activity_date') {
                            $value = date('d-m-Y H:i:s');
                        }
                        $data[$key] = strtotime($value);
                        update_post_meta($post_id, $key, strtotime($value));
                    } else {
                        if ($key == 'automobile_cus_field') {
                            if (is_array($value) && sizeof($value) > 0) {
                                foreach ($value as $c_key => $c_val) {
                                    update_post_meta($post_id, $c_key, $c_val);
                                }
                            }
                        } else {
                            if ($key == 'automobile_inventory_featured') {
                                if (is_admin()) {
                                    $data[$key] = $value;
                                    update_post_meta($post_id, $key, $value);
                                }
                            } else {
                                $data[$key] = $value;
                                update_post_meta($post_id, $key, $value);
                            }
                        }
                    }
                }

                if ($key == 'inventory_img' || $key == 'user_img' || $key == 'cover_user_img') {
                    update_post_meta($post_id, $key, automobile_save_img_url($value));
                }
            }
            update_post_meta($post_id, 'automobile_array_data', $data);
        }

        /**
         * End Saving Post  options Function
         * Start Insert Shortcode Function
         */
        public function reg_shortcodes_btn() {
            global $automobile_form_fields, $automobile_var_plugin_static_text;

            $automobile_rand = rand(2342344, 95676556);
            $automobile_shortcodes_list = '';
            $shortcode_array = array();

            $shortcode_array['package'] = array(
                'title' => automobile_var_plugin_text_srt('automobile_var_Inventory_package'),
                'name' => 'package',
                'icon' => 'icon-table',
                'categories' => 'loops misc',
            );
            $shortcode_array['inventory_type'] = array(
                'title' => automobile_var_plugin_text_srt('automobile_var_inventory_type'),
                'name' => 'inventory_type',
                'icon' => 'icon-table',
                'categories' => 'loops misc',
            );
            $shortcode_array['dealer'] = array(
                'title' => automobile_var_plugin_text_srt('automobile_var_inventory_dealer'),
                'name' => 'dealer',
                'icon' => 'icon-table',
                'categories' => 'loops misc',
            );
            $shortcode_array['inventories_search'] = array(
                'title' => automobile_var_plugin_text_srt('automobile_var_inventory_search'),
                'name' => 'inventories_search',
                'icon' => 'icon-table',
                'categories' => 'loops misc',
            );
            $shortcode_array['inventories'] = array(
                'title' => automobile_var_plugin_text_srt('automobile_var_inventories'),
                'name' => 'inventories',
                'icon' => 'icon-home',
                'categories' => 'loops misc',
            );
            $shortcode_array['register'] = array(
                'title' => automobile_var_plugin_text_srt('automobile_var_register'),
                'name' => 'register',
                'icon' => 'icon-home',
                'categories' => 'loops misc',
            );

            $automobile_shortcodes_list_option = '';
            $automobile_shortcodes_list_option[] = "Shortcode";

            foreach ($shortcode_array as $val) {
                $automobile_shortcodes_list_option[$val['name']] = $val['title'];
            }

            $automobile_opt_array = array(
                'id' => '',
                'std' => automobile_var_plugin_text_srt('automobile_var_browse'),
                'cust_id' => '',
                'cust_name' => "",
                'classes' => 'sc_select chosen-select select-small',
                'return' => true,
                'options' => $automobile_shortcodes_list_option,
                'extra_atr' => "onchange=\"automobile_shortocde_selection(this.value,'" . admin_url('admin-ajax.php') . "','composer-" . absint($automobile_rand) . "')\"",
            );
            $automobile_shortcodes_list .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
            $automobile_shortcodes_list .= '<span id="cs-shrtcode-loader"></span>';
            echo force_balance_tags($automobile_shortcodes_list);
        }

        /**
         * End Insert Shortcode Function
         * Start Special Characters Function
         */
        public function automobile_special_chars($input = '') {
            $output = $input; // output line 
            return $output;
        }

        /**
         * End Special Characters Function
         * Start Regular Expression  Text Function
         */
        public function automobile_slugy_text($str) {
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
            $clean = strtolower(trim($clean, '_'));
            $clean = preg_replace("/[\/_|+ -]+/", '_', $clean);
            return $clean;
        }

        /**
         * End Regular Expression  Text Function
         * Start  Creating  Random Id Function
         */
        public function automobile_rand_id() {
            $output = rand(12345678, 98765432);
            return $output;
        }

        /**
         * End  Creating  Random Id Function
         * Start Advance Deposit Function
         */
        public function automobile_percent_return($num) {
            if (is_numeric($num) && $num > 0 && $num <= 100) {
                $num = $num;
            } else if (is_numeric($num) && $num > 0 && $num > 100) {
                $num = 100;
            } else {
                $num = 0;
            }

            return $num;
        }

        /**
         * Number Format Function
         * Function how to get  attachment image src 
         */
        public function automobile_num_format($num) {
            $automobile_number = number_format((float) $num, 2, '.', '');
            return $automobile_number;
        }

        public function automobile_attach_image_src($attachment_id, $width, $height) {
            $image_url = wp_get_attachment_image_src($attachment_id, array($width, $height), true);
            if ($image_url[1] == $width and $image_url[2] == $height)
                ;
            else
                $image_url = wp_get_attachment_image_src($attachment_id, "full", true);
            $parts = explode('/uploads/', $image_url[0]);
            if (count($parts) > 1)
                return $image_url[0];
        }

        /**
         *  End How to get first image from gallery and its image src Function
         * Get post Id Through meta key Fundtion
         */
        public function automobile_get_post_id_by_meta_key($key, $value) {
            global $wpdb;
            $meta = $wpdb->get_results("SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $key . "' AND meta_value='" . $value . "'");

            if (is_array($meta) && !empty($meta) && isset($meta[0])) {
                $meta = $meta[0];
            }
            if (is_object($meta)) {
                return $meta->post_id;
            } else {
                return false;
            }
        }

        /**
         *  end Get post Id Through meta key Fundtion
         * Start Show All Taxonomy(categories) Function
         */
        public function automobile_show_all_cats($parent = '', $separator = '', $selected = "", $taxonomy = '') {

            if ($parent == "") {
                global $wpdb;
                $parent = 0;
            } else
                $separator .= " &ndash; ";
            $args = array(
                'parent' => $parent,
                'hide_empty' => 0,
                'taxonomy' => $taxonomy
            );
            $categories = get_categories($args);
            ?>

            <?php
            foreach ($categories as $category) {
                ?>
                <option <?php if ($selected == $category->slug) echo "selected"; ?> value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_attr($separator . $category->cat_name); ?></option>
                <?php
                automobile_show_all_cats($category->term_id, $separator, $selected, $taxonomy);
            }
        }

        /**
         *  End Show All Taxonomy(categories) Function
         *  Start how to icomoon get
         */
        public function automobile_icomoons($icon_value = '', $id = '', $name = '') {
            global $automobile_form_fields, $automobile_var_plugin_static_text;

            ob_start();
            ?>
            <script>
                jQuery(document).ready(function ($) {

                    var e9_element = $('#e9_element_<?php echo automobile_allow_special_char($id); ?>').fontIconPicker({
                        theme: 'fip-bootstrap'
                    });
                    // Add the event on the button
                    $('#e9_buttons_<?php echo automobile_allow_special_char($id); ?> button').on('click', function (e) {
                        e.preventDefault();
                        // Show processing message
                        $(this).prop('disabled', true).html('<i class="icon-cog demo-animate-spin"></i> Please wait...');
                        $.ajax({
                            url: '<?php echo automobile_var::plugin_url(); ?>/assets/icomoon/js/selection.json',
                            type: 'GET',
                            dataType: 'json'
                        })
                                .done(function (response) {
                                    // Get the class prefix
                                    var classPrefix = response.preferences.fontPref.prefix,
                                            icomoon_json_icons = [],
                                            icomoon_json_search = [];
                                    $.each(response.icons, function (i, v) {
                                        icomoon_json_icons.push(classPrefix + v.properties.name);
                                        if (v.icon && v.icon.tags && v.icon.tags.length) {
                                            icomoon_json_search.push(v.properties.name + ' ' + v.icon.tags.join(' '));
                                        } else {
                                            icomoon_json_search.push(v.properties.name);
                                        }
                                    });
                                    // Set new fonts on fontIconPicker
                                    e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
                                    // Show success message and disable
                                    $('#e9_buttons_<?php echo automobile_allow_special_char($id); ?> button').removeClass('btn-primary').addClass('btn-success').text('Successfully loaded icons').prop('disabled', true);
                                })
                                .fail(function () {
                                    // Show error message and enable
                                    $('#e9_buttons_<?php echo automobile_allow_special_char($id); ?> button').removeClass('btn-primary').addClass('btn-danger').text('Error: Try Again?').prop('disabled', false);
                                });
                        e.stopPropagation();
                    });

                    jQuery("#e9_buttons_<?php echo automobile_allow_special_char($id); ?> button").click();
                });


            </script>
            <?php
            $automobile_opt_array = array(
                'id' => '',
                'std' => automobile_allow_special_char($icon_value),
                'cust_id' => "e9_element_" . automobile_allow_special_char($id),
                'cust_name' => automobile_allow_special_char($name) . "[]",
                'return' => true,
            );

            echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
            ?>
            <span id="e9_buttons_<?php echo automobile_allow_special_char($id); ?>" style="display:none">
                <button autocomplete="off" type="button" class="btn btn-primary"><?php echo automobile_var_plugin_text_srt('automobile_var_load_json'); ?></button>
            </span>
            <?php
            $fontawesome = ob_get_clean();
            return $fontawesome;
        }

        /**
         * @ render Random ID
         * Start Get Current  user ID Function
         *
         */
        public static function automobile_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        public function automobile_get_user_id() {
            global $current_user;
            get_currentuserinfo();
            return $current_user->ID;
        }

        /**
         * End Current get user ID Function
         * How to create location Fields(fields) Function
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

            $automobile_var->automobile_location_gmap_script();
            $automobile_var->automobile_google_place_scripts();
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
                    $location_countries_list .= "<option " . $selected . "  value='" . $country->slug . "' data-name='" . $iso_code_list_admin . "'>" . esc_html($country->name) . "</option>";
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
                        $location_cities_list .= "<option " . $selected . " value='" . $city->slug . "'>" . esc_html($city->name) . "</option>";
                    }
                }
            }
            ?>
            <fieldset class="gllpLatlonPicker"  style="width:100%; float:left;">
                <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;" id="locations_wrap" data-themeurl="<?php echo automobile_var::plugin_url(); ?>" data-plugin_url="<?php echo automobile_var::plugin_url(); ?>" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php'), 'automobile'); ?>" data-map_marker="<?php echo automobile_var::plugin_url(); ?>/assets/images/map-marker.png">
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
                            $output .= '<div class="clear"></div><div class="cs-map-section" style="float:left; width:100%; height:100%;"><div class="gllpMap" id="cs-map-location-id"></div></div>';
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

                                (function ($) {
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
                                })(jQuery);

                            </script>
                            <?php
                        }

                        /**
                         * How to show location fields in front end
                         *
                         */
                        public function automobile_frontend_location_fields($post_id = '', $field_postfix = '', $user = '') {

                            global $automobile_var_plugin_options, $post, $automobile_html_fields, $automobile_html_fields2, $automobile_html_fields_frontend, $automobile_form_fields, $automobile_var_plugin_static_text;
                            $strings = new automobile_plugin_all_strings;
                            $strings->automobile_var_plugin_option_strings();

                            $automobile_map_latitude = isset($automobile_var_plugin_options['map_latitude']) ? $automobile_var_plugin_options['map_latitude'] : '';
                            $automobile_map_longitude = isset($automobile_var_plugin_options['map_longitude']) ? $automobile_var_plugin_options['map_longitude'] : '';
                            $automobile_map_zoom = isset($automobile_var_plugin_options['map_zoom']) ? $automobile_var_plugin_options['map_zoom'] : '11';


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
                            } else {
                                $automobile_array_data = get_post_meta($post_id, 'automobile_array_data', true);
                                $automobile_post_loc_address = get_post_meta($post_id, 'automobile_post_loc_address', true);

                                if (isset($automobile_array_data) && !empty($automobile_array_data)) {
                                    $automobile_post_loc_city = get_post_meta($post_id, 'automobile_post_loc_city', true);
                                    $automobile_post_loc_country = get_post_meta($post_id, 'automobile_post_loc_country', true);
                                    $automobile_post_loc_latitude = get_post_meta($post_id, 'automobile_post_loc_latitude', true);
                                    $automobile_post_loc_longitude = get_post_meta($post_id, 'automobile_post_loc_longitude', true);
                                    $automobile_post_loc_zoom = get_post_meta($post_id, 'automobile_post_loc_zoom', true);
                                    $automobile_post_loc_address = get_post_meta($post_id, 'automobile_post_loc_address', true);
                                    $automobile_post_comp_address = get_post_meta($post_id, 'automobile_post_comp_address', true);
                                    $automobile_add_new_loc = get_post_meta($post_id, 'automobile_add_new_loc', true);
                                } else {

                                    $automobile_post_loc_country = '';
                                    $automobile_post_loc_region = '';
                                    $automobile_post_loc_city = '';
                                    $automobile_post_loc_address = '';
                                    $automobile_post_comp_address = '';
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
                                }
                            }
                            if ($automobile_post_loc_latitude == '')
                                $automobile_post_loc_latitude = isset($automobile_var_plugin_options['automobile_post_loc_latitude']) ? $automobile_var_plugin_options['automobile_post_loc_latitude'] : '';
                            if ($automobile_post_loc_longitude == '')
                                $automobile_post_loc_longitude = isset($automobile_var_plugin_options['automobile_post_loc_longitude']) ? $automobile_var_plugin_options['automobile_post_loc_longitude'] : '';
                            if ($automobile_post_loc_zoom == '')
                                $automobile_post_loc_zoom = isset($automobile_var_plugin_options['automobile_post_loc_zoom']) ? $automobile_var_plugin_options['automobile_post_loc_zoom'] : '';
                            $automobile_var = new automobile_var();
                            $automobile_var->automobile_location_gmap_script();
                            $automobile_var->automobile_google_place_scripts();
                            $automobile_var->automobile_autocomplete_scripts();
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
                            $iso_code_list = '';
                            $iso_code_list_main = '';
                            $iso_code = '';
                            if (isset($automobile_location_countries) && !empty($automobile_location_countries)) {
                                $selected_iso_code = '';
                                foreach ($automobile_location_countries as $key => $country) {
                                    $selected = '';
                                    $t_id_main = $country->term_id;
                                    $iso_code_list_main = get_option("iso_code_$t_id_main");
                                    if (isset($iso_code_list_main['text'])) {
                                        $iso_code_list_main = $iso_code_list_main['text'];
                                    }
                                    if (isset($automobile_post_loc_country) && $automobile_post_loc_country == $country->slug) {
                                        $selected = 'selected';
                                        $t_id = $country->term_id;
                                        $iso_code_list = get_option("iso_code_$t_id");
                                        if (isset($iso_code_list['text'])) {
                                            $selected_iso_code = $iso_code_list['text'];
                                        }
                                    }
                                    $location_countries_list .= "<option " . $selected . "  value='" . $country->slug . "' data-name='" . $iso_code_list_main . "'>" . $country->name . "</option>";
                                }
                            }
                            $selected_country = $automobile_post_loc_country;
                            $selected_city = $automobile_post_loc_city;
                            if (isset($automobile_location_countries) && !empty($automobile_location_countries) && isset($automobile_post_loc_country) && !empty($automobile_post_loc_country)) {
                                // load all cities against state  
                                $cities = '';
                                $selected_spec = get_term_by('slug', $selected_country, 'automobile_locations');
                                $city_parent_id = isset($selected_spec->term_id) ? $selected_spec->term_id : '';
                                $cities_args = array(
                                    'orderby' => 'name',
                                    'order' => 'ASC',
                                    'fields' => 'all',
                                    'slug' => '',
                                    'hide_empty' => false,
                                    'parent' => $city_parent_id,
                                );
                                $cities = get_terms('automobile_locations', $cities_args);
                                if (isset($cities) && $cities != '' && is_array($cities)) {
                                    foreach ($cities as $key => $city) {
                                        $selected = ( $selected_city == $city->slug) ? 'selected' : '';
                                        $location_cities_list .= "<option " . $selected . " value='" . $city->slug . "'>" . $city->name . "</option>";
                                    }
                                }
                            }
                            ?>
                            <fieldset style="width:100%; float:left;" id="fe_map<?php echo absint($field_postfix) ?>">
                                <div class="page-wrap page-opts left" style=" position:relative;" id="locations_wrap" data-themeurl="<?php echo automobile_var::plugin_url(); ?>" data-plugin_url="<?php echo automobile_var::plugin_url(); ?>" data-ajaxurl="<?php echo esc_js(admin_url('admin-ajax.php'), 'automobile'); ?>" data-map_marker="<?php echo automobile_var::plugin_url() ?>/assets/images/map-marker.png">
                                    <div class="option-sec" style="margin-bottom:0;">
                                        <div class="opt-conts">
                                            <div class="col-md-6">
                                                <label>Country</label>
                                                <div class="select-holder">
                                                    <?php
                                                    $output = '';
                                                    $automobile_opt_array = array(
                                                        'name' => automobile_var_plugin_text_srt('automobile_var_country'),
                                                        'desc' => '',
                                                        'field_params' => array(
                                                            'std' => '',
                                                            'id' => 'loc_country',
                                                            'cust_id' => 'loc_country',
                                                            'extra_atr' => 'data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_country') . '"',
                                                            'cust_name' => 'automobile_post_loc_country',
                                                            'classes' => 'form-control form-select-country dir-map-search single-select SlectBox chosen-select',
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

                                                    echo $automobile_html_fields_frontend->automobile_form_select_render($automobile_opt_array);
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>City</label>
                                                <div class="select-holder">

                                                    <span class="loader-cities"></span>

                                                    <?php
                                                    $automobile_opt_array = array(
                                                        'name' => automobile_var_plugin_text_srt('automobile_var_city'),
                                                        'id' => 'loc_city',
                                                        'desc' => '',
                                                        'field_params' => array(
                                                            'std' => '',
                                                            'id' => 'loc_city',
                                                            'cust_id' => 'loc_city',
                                                            'extra_atr' => 'data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_select_city') . '"',
                                                            'cust_name' => 'automobile_post_loc_city',
                                                            'classes' => 'chosen-select form-control form-select-city dir-map-search single-select SlectBox',
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
                                                    echo $automobile_html_fields_frontend->automobile_form_select_render($automobile_opt_array);
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label><?php echo automobile_var_plugin_text_srt('automobile_var_complete_address'); ?></label>
                                                <?php
                                                $automobile_opt_array = array(
                                                    'std' => $automobile_post_comp_address,
                                                    'id' => 'post_comp_address',
                                                    'cust_id' => 'automobile_post_comp_address',
                                                    'cust_name' => 'automobile_post_comp_address',
                                                    'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_complete_address') . '"',
                                                    'return' => false,
                                                );

                                                $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo automobile_var_plugin_text_srt('automobile_var_find_on_map'); ?></label>
                                                <?php
                                                $automobile_opt_array = array(
                                                    'name' => '',
                                                    'desc' => '',
                                                    'field_params' => array(
                                                        'std' => $automobile_post_loc_address,
                                                        'id' => 'loc_address',
                                                        'classes' => 'form-control directory-search-location',
                                                        'extra_atr' => 'onkeypress="automobile_fe_search_map(this.value)" placeholder="' . automobile_var_plugin_text_srt('automobile_var_complete_address') . '"',
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
                                                echo $automobile_html_fields_frontend->automobile_form_text_render($automobile_opt_array);
                                                ?>

                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo automobile_var_plugin_text_srt('automobile_var_latitude'); ?></label>
                                                <?php
                                                $automobile_opt_array = array(
                                                    'name' => automobile_var_plugin_text_srt('automobile_var_latitude'),
                                                    'id' => 'post_loc_latitude',
                                                    'desc' => '',
                                                    //'styles' => 'display:none;',
                                                    'field_params' => array(
                                                        'std' => $automobile_post_loc_latitude,
                                                        'id' => 'post_loc_latitude',
                                                        'cust_name' => 'automobile_post_loc_latitude',
                                                        'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_latitude_hint') . '"',
                                                        'classes' => 'form-control gllpLatitude',
                                                        'return' => true,
                                                    ),
                                                );

                                                if (isset($value['split']) && $value['split'] <> '') {
                                                    $automobile_opt_array['split'] = $value['split'];
                                                }

                                                echo $automobile_html_fields_frontend->automobile_form_text_render($automobile_opt_array);
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label><?php echo automobile_var_plugin_text_srt('automobile_var_longitude'); ?></label>
                                                <?php
                                                $automobile_opt_array = array(
                                                    'name' => automobile_var_plugin_text_srt('automobile_var_longitude'),
                                                    'id' => 'post_loc_longitude',
                                                    'desc' => '',
                                                    'field_params' => array(
                                                        'std' => $automobile_post_loc_longitude,
                                                        'id' => 'post_loc_longitude',
                                                        'cust_name' => 'automobile_post_loc_longitude',
                                                        'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_longitude_hint') . '"',
                                                        'classes' => 'form-control gllpLongitude',
                                                        'return' => true,
                                                    ),
                                                );

                                                if (isset($value['split']) && $value['split'] <> '') {
                                                    $automobile_opt_array['split'] = $value['split'];
                                                }
                                                echo $automobile_html_fields_frontend->automobile_form_text_render($automobile_opt_array);
                                                ?>
                                            </div>

                                            <div class="col-md-12">
                                                <label></label>
                                                <?php
                                                $automobile_opt_array = array(
                                                    'name' => '',
                                                    'id' => 'map_search_btn',
                                                    'desc' => '',
                                                    'field_params' => array(
                                                        'std' => automobile_var_plugin_text_srt('automobile_var_search_location'),
                                                        'id' => 'map_search_btn',
                                                        'cust_type' => 'button',
                                                        'classes' => 'acc-submit cs-section-update cs-color csborder-color gllpSearchButton',
                                                        'return' => true,
                                                    ),
                                                );

                                                if (isset($value['split']) && $value['split'] <> '') {
                                                    $automobile_opt_array['split'] = $value['split'];
                                                }

                                                echo $automobile_html_fields_frontend->automobile_form_text_render($automobile_opt_array);
                                                ?>   
                                            </div>
                                            <div class="col-md-12" style="float: left; width:100%;" >
                                                <div class="clear"></div>
                                                <?php
                                                $automobile_opt_array = array(
                                                    'id' => '',
                                                    'id' => 'add_new_loc',
                                                    'std' => $automobile_add_new_loc,
                                                    'classes' => 'gllpSearchField_fe',
                                                    'extra_atr' => 'style="margin-bottom:10px;"',
                                                    'return' => true,
                                                );

                                                echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);

                                                $automobile_opt_array = array(
                                                    'id' => '',
                                                    'std' => esc_attr($automobile_post_loc_zoom),
                                                    'cust_id' => esc_attr($automobile_post_loc_zoom),
                                                    'cust_name' => "automobile_post_loc_zoom",
                                                    'classes' => 'gllpZoom',
                                                    'return' => true,
                                                );

                                                echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);

                                                $automobile_opt_array = array(
                                                    'id' => '',
                                                    'std' => automobile_var_plugin_text_srt('automobile_var_update_map'),
                                                    'cust_id' => '',
                                                    'cust_name' => "",
                                                    'classes' => 'gllpUpdateButton',
                                                    'return' => true,
                                                    'cust_type' => 'button',
                                                    'extra_atr' => 'style="display:none"',
                                                );
                                                echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                ?>
                                                <div class="clear"></div>
                                                <div class="cs-map-section" style="float:left; width:100%; height:270px;">
                                                    <div class="gllpMap" id="cs-map-location-fe-id" style="float:left; width:100%; height:270px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <script>
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

                                (function ($) {
                                    $(function () {
            <?php
            $automobile_var->automobile_google_place_scripts();
            ?> //var autocomplete;
                                        autocomplete = new google.maps.places.Autocomplete(document.getElementById('loc_address'));
            <?php if (isset($selected_iso_code) && !empty($selected_iso_code)) { ?>
                                            autocomplete.setComponentRestrictions({'country': '<?php echo esc_js($selected_iso_code) ?>'});
            <?php } ?>
                                    });
                                })(jQuery);
                                jQuery(document).ready(function () {
                                    var $ = jQuery;
                                    jQuery("[id^=map_canvas]").css("pointer-events", "none");
                                    jQuery("[id^=cs-map-location]").css("pointer-events", "none");
                                    // on leave handle
                                    var onMapMouseleaveHandler = function (event) {
                                        var that = jQuery(this);
                                        that.on('click', onMapClickHandler);
                                        that.off('mouseleave', onMapMouseleaveHandler);
                                        jQuery("[id^=map_canvas]").css("pointer-events", "none");
                                        jQuery("[id^=cs-map-location]").css("pointer-events", "none");
                                    }
                                    // on click handle
                                    var onMapClickHandler = function (event) {
                                        var that = jQuery(this);
                                        // Disable the click handler until the user leaves the map area
                                        that.off('click', onMapClickHandler);
                                        // Enable scrolling zoom
                                        that.find('[id^=map_canvas]').css("pointer-events", "auto");
                                        that.find('[id^=cs-map-location]').css("pointer-events", "auto");

                                        // Handle the mouse leave event
                                        that.on('mouseleave', onMapMouseleaveHandler);
                                    }
                                    // Enable map zooming with mouse scroll when the user clicks the map
                                    jQuery('.cs-map-section').on('click', onMapClickHandler);
                                    // new addition
                                });

                            </script>
                            <?php
                        }

                        /**
                         * Start How to add  Categories(Taxonomy) fields  Function
                         *
                         */
                        public function automobile_inventories_spec_fields($tag) {    //check for existing featured ID
                            global $automobile_form_fields, $automobile_var_plugin_static_text;


                            if (isset($tag->term_id)) {
                                $t_id = $tag->term_id;
                            } else {
                                $t_id = "";
                            }
                            $spec_image = '';
                            ?>

                            <div class="form-field">
                                <ul class="form-elements" style="margin:0; padding:0;">
                                    <li class="to-field" style="width:100%;">
                                        <label style="width:100%;"><?php echo automobile_var_plugin_text_srt('automobile_var_image'); ?></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => esc_url($spec_image),
                                            'cust_id' => "spec_image" . esc_attr($t_id),
                                            'cust_name' => "spec_image",
                                            'classes' => '',
                                            'return' => true,
                                        );
                                        echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                        ?>
                                        <label class="browse-icon">
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => '',
                                                'std' => automobile_var_plugin_text_srt('automobile_var_browse'),
                                                'cust_id' => '',
                                                'cust_name' => "spec_image" . esc_attr($t_id),
                                                'classes' => 'uploadMedia left',
                                                'return' => true,
                                                'cust_type' => 'button',
                                            );
                                            echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>
                                        </label>
                                        <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($spec_image) && trim($spec_image) != '' ? 'inline' : 'none'; ?>" id="spec_image<?php echo esc_attr($t_id) ?>_box" >
                                            <div class="gal-active" style="padding-left:0 !important;">
                                                <div class="dragareamain" style="padding-bottom:0px;">
                                                    <ul id="gal-sortable" style="width:200px;">
                                                        <li class="ui-state-default" id="">
                                                            <div class="thumb-secs"> <img src="<?php echo esc_url($spec_image); ?>"  id="spec_image<?php echo esc_attr($t_id); ?>_img" width="200" />
                                                                <div class="gal-edit-opts"> <a   href="javascript:del_media('spec_image<?php echo esc_attr($t_id); ?>')" class="delete"></a> </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                </ul>

                                <p><?php echo automobile_var_plugin_text_srt('automobile_var_image_for_dealer_type'); ?></p>
                            </div>
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => "1",
                                'cust_id' => "",
                                'cust_name' => "spec_image_meta",
                                'return' => true,
                            );
                            echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                        }

                        /**
                         * End How to add  Categories fields  Function
                         * Start How to Edit  Categories Fields  Function
                         *
                         */
                        public function automobile_edit_inventories_spec_fields($tag) {    //check for existing featured ID
                            global $automobile_form_fields, $automobile_var_plugin_static_text;


                            if (isset($tag->term_id)) {
                                $t_id = $tag->term_id;
                            } else {
                                $t_id = "";
                            }
                            $automobile_counter = $tag->term_id;
                            $cat_meta = get_option("spec_image_$t_id");
                            $spec_image = $cat_meta['img'];
                            ?>
                            <tr>
                                <th><label for="cat_f_img_url"> <?php echo automobile_var_plugin_text_srt('automobile_var_choose_icon'); ?></label></th>
                                <td>
                                    <ul class="form-elements" style="margin:0; padding:0;">
                                        <li class="to-field" style="width:100%;">
                                            <label style="width:100%;"> <?php echo automobile_var_plugin_text_srt('automobile_var_image'); ?></label>
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => '',
                                                'std' => esc_url($spec_image),
                                                'cust_id' => "spec_image" . esc_attr($automobile_counter),
                                                'cust_name' => "spec_image",
                                                'return' => true,
                                            );
                                            echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                            ?>
                                            <label class="browse-icon">
                                                <?php
                                                $automobile_opt_array = array(
                                                    'id' => '',
                                                    'std' => automobile_var_plugin_text_srt('automobile_var_browse'),
                                                    'cust_id' => '',
                                                    'cust_name' => "spec_image" . esc_attr($automobile_counter),
                                                    'classes' => 'uploadMedia left',
                                                    'return' => true,
                                                    'cust_type' => 'button',
                                                );
                                                echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                ?>
                                            </label>
                                            <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($spec_image) && trim($spec_image) != '' ? 'inline' : 'none'; ?>" id="spec_image<?php echo esc_attr($automobile_counter) ?>_box" >
                                                <div class="gal-active" style="padding-left:0 !important;">
                                                    <div class="dragareamain" style="padding-bottom:0px;">
                                                        <ul id="gal-sortable" style="width:200px;">
                                                            <li class="ui-state-default" id="">
                                                                <div class="thumb-secs"> <img src="<?php echo esc_url($spec_image); ?>"  id="spec_image<?php echo esc_attr($automobile_counter); ?>_img" width="200" />
                                                                    <div class="gal-edit-opts"> <a href="javascript:del_media('spec_image<?php echo esc_attr($automobile_counter); ?>')" class="delete"></a> </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                    </ul>

                                    <p><?php echo automobile_var_plugin_text_srt('automobile_var_image_for_dealer_type'); ?></p>
                                </td>
                            </tr>
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => "1",
                                'cust_id' => "",
                                'cust_name' => "spec_image_meta",
                                'return' => true,
                            );
                            echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                        }

                        /**
                         * Start Function save extra category extra fields callback function
                         *
                         */
                        public function automobile_save_inventories_spec_fields($term_id) {
                            if (isset($_POST['spec_image_meta']) and $_POST['spec_image_meta'] == '1') {
                                $t_id = $term_id;
                                get_option("spec_image_$t_id");
                                $spec_image_img = '';
                                if (isset($_POST['spec_image'])) {
                                    $spec_image_img = $_POST['spec_image'];
                                }
                                $cat_meta = array(
                                    'img' => $spec_image_img,
                                );
                                //save the option array
                                update_option("spec_image_$t_id", $cat_meta);
                            }
                        }

                        // Add Category Fields
                        public function automobile_inventories_locations_fields($tag) {    //check for existing featured ID
                            global $automobile_form_fields, $automobile_var_plugin_static_text;


                            if (isset($tag->term_id)) {
                                $t_id = $tag->term_id;
                            } else {
                                $t_id = "";
                            }
                            $locations_image = '';
                            $iso_code = '';
                            ?>
                            <div class="form-field">

                                <label><?php echo automobile_var_plugin_text_srt('automobile_var_iso_code'); ?></label>
                                <ul class="form-elements" style="margin:0; padding:0;">
                                    <li class="to-field" style="width:100%;">
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => "",
                                            'cust_id' => "iso_code",
                                            'cust_name' => "iso_code",
                                            'return' => true,
                                        );
                                        echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </li>
                                </ul>
                                </br> </br>
                            </div>
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => "1",
                                'cust_id' => "",
                                'cust_name' => "locations_image_meta",
                                'return' => true,
                            );
                            echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                        }

                        public function automobile_edit_inventories_locations_fields($tag) {    //check for existing featured ID
                            global $automobile_form_fields, $automobile_var_plugin_static_text;
                            if (isset($tag->term_id)) {
                                $t_id = $tag->term_id;
                            } else {
                                $t_id = "";
                            }
                            $cat_meta = get_option("iso_code_$t_id");
                            $iso_code = $cat_meta['text'];
                            ?>
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => "1",
                                'cust_id' => "",
                                'cust_name' => "locations_image_meta",
                                'return' => true,
                            );
                            echo $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                            ?>
                            <tr>
                                <th><label for="cat_f_img_url"> <?php echo automobile_var_plugin_text_srt('automobile_var_iso_code'); ?></label></th>
                                <td>
                                    <ul class="form-elements" style="margin:0; padding:0;">
                                        <li class="to-field" style="width:100%;">
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => '',
                                                'std' => esc_attr($iso_code),
                                                'cust_id' => "iso_code",
                                                'cust_name' => "iso_code",
                                                'return' => true,
                                            );
                                            echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php
                        }

                        /**
                         * Start Function how to save location in inventories fields
                         */
                        public function automobile_save_inventories_locations_fields($term_id) {
                            if (isset($_POST['locations_image_meta']) and $_POST['locations_image_meta'] == '1') {
                                $t_id = $term_id;
                                get_option("locations_image_$t_id");
                                $locations_image_img = '';
                                if (isset($_POST['locations_image'])) {
                                    $locations_image_img = $_POST['locations_image'];
                                }
                                if (isset($_POST['iso_code'])) {
                                    $iso_code = $_POST['iso_code'];
                                    //echo $iso_code; exit;
                                }
                                $cat_meta = array(
                                    'img' => $locations_image_img,
                                );
                                $cat_meta = array(
                                    'text' => $iso_code,
                                );
                                update_option("locations_image_$t_id", $cat_meta);
                                update_option("iso_code_$t_id", $cat_meta);
                            }
                        }

                        public function automobile_inventories_inventory_type_fields($tag) {
                            global $automobile_form_fields, $automobile_var_plugin_static_text;
                            if (isset($tag->term_id)) {
                                $t_id = $tag->term_id;
                            } else {
                                $t_id = "";
                            }

                            $locations_image = '';
                            $inventory_type_color = '';
                            wp_enqueue_style('wp-color-picker');
                            wp_enqueue_script('wp-color-picker');
                            ?>
                            <script type="text/javascript">
                                jQuery(document).ready(function ($) {
                                    $('.bg_color').wpColorPicker();
                                });
                            </script>
                            <div class="form-field">

                                <label><?php echo automobile_var_plugin_text_srt('automobile_var_inventory_type_color'); ?></label>
                                <ul class="form-elements" style="margin:0; padding:0;">
                                    <li class="to-field" style="width:100%;">
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => "",
                                            'cust_id' => "inventory_type_color",
                                            'cust_name' => "inventory_type_color",
                                            'classes' => 'bg_color',
                                            'return' => true,
                                        );
                                        echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </li>
                                </ul>
                                </br> </br>
                            </div>
                            <?php
                        }

                        public function automobile_edit_inventories_inventory_type_fields($tag) {    //check for existing featured ID
                            global $automobile_form_fields, $automobile_var_plugin_static_text;
                            wp_enqueue_style('wp-color-picker');
                            wp_enqueue_script('wp-color-picker');
                            if (isset($tag->term_id)) {
                                $t_id = $tag->term_id;
                            } else {
                                $t_id = "";
                            }
                            ?>
                            <script type="text/javascript">
                                jQuery(document).ready(function ($) {
                                    $('.bg_color').wpColorPicker();
                                });
                            </script>
                            <?php
                            $cat_meta = get_option("inventory_type_color_$t_id");
                            $inventory_type_color = $cat_meta['text'];
                            ?>

                            <tr>
                                <th><label for="cat_f_img_url"> <?php echo automobile_var_plugin_text_srt('automobile_var_inventory_type_color'); ?></label></th>
                                <td>
                                    <ul class="form-elements" style="margin:0; padding:0;">
                                        <li class="to-field" style="width:100%;">
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => '',
                                                'std' => esc_attr($inventory_type_color),
                                                'cust_id' => "inventory_type_color",
                                                'cust_name' => "inventory_type_color",
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            );
                                            echo $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php
                        }

                        /**
                         * Start Function how to save location in inventories fields
                         */
                        public function automobile_save_inventories_inventorytype_fields($term_id) {
                            if (isset($_POST['inventory_type_color'])) {
                                $t_id = $term_id;

                                if (isset($_POST['inventory_type_color'])) {
                                    $inventory_type_color = $_POST['inventory_type_color'];
                                }

                                $cat_meta = array(
                                    'text' => $inventory_type_color,
                                );

                                update_option("inventory_type_color_$t_id", $cat_meta);
                            }
                        }

                        /**
                         * End Function how to save location in inventories fields
                         * How to know about working  current Theme Function Start
                         */
                        public function automobile_get_current_theme() {
                            $automobile_theme = wp_get_theme();
                            $theme_name = $automobile_theme->get('Name');
                            return $theme_name;
                        }

                    }

                    /**
                     * End Function How to know about working  current Theme Function
                     * Design Pattern for Object initilization
                     */
                    function AUTOMOBILE_FUNCTIONS() {
                        return automobile_inventory_plugin_functions::instance();
                    }

                    $GLOBALS['automobile_inventory_plugin_functions'] = AUTOMOBILE_FUNCTIONS();
                }
