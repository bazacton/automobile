<?php
/**
 * Register Post Type Inventory
 * @return
 *
 */
if (!class_exists('automobile_post_inventory')) {
    class automobile_post_inventory {
        // The Constructor
        public function __construct() {
            add_action('init', array($this, 'inventory_register'));
            add_action('init', array($this, 'create_inventory_make'));
            add_action('init', array($this, 'create_inventory_model'));
            add_action('init', array($this, 'create_locations_taxonomies'));
            add_action('init', array($this, 'create_dealer_type_taxonomies'));
            add_action('admin_menu', array($this, 'remove_my_taxanomy_meta'));
            add_action('admin_footer', array($this, 'full_width_location'));
            add_action('admin_head-edit-tags.php', array($this, 'remove_inventory_parent_category'));
            add_filter("manage_edit-automobile_locations_columns", array($this, 'theme_columns'));
        }
        /**
         * @Register Post Type
         * @return
         *
         * @global type  */
        function inventory_register() {
            global $automobile_var_plugin_static_text;
			$strings = new automobile_plugin_all_strings;
			$strings->automobile_var_plugin_all_strings();
         
            $labels = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_inventories_post'),
                'singular_name' => automobile_var_plugin_text_srt('automobile_var_inventory_post_singular'),
                'menu_name' => automobile_var_plugin_text_srt('automobile_var_inventories_admin'),
                'name_admin_bar' => automobile_var_plugin_text_srt('automobile_var_inventory_add'),
                'add_new' => automobile_var_plugin_text_srt('automobile_var_add_new'),
                'add_new_item' => automobile_var_plugin_text_srt('automobile_var_add_new_inventory'),
                'new_item' => automobile_var_plugin_text_srt('automobile_var_new_inventory'),
                'edit_item' => automobile_var_plugin_text_srt('automobile_var_edit_inventory'),
                'view_item' => automobile_var_plugin_text_srt('automobile_var_view_inventory'),
                'all_items' => automobile_var_plugin_text_srt('automobile_var_inventories'),
                'search_items' => automobile_var_plugin_text_srt('automobile_var_search_inventories'),
                'parent_item_colon' => automobile_var_plugin_text_srt('automobile_var_parent_inventories'),
                'not_found' => automobile_var_plugin_text_srt('automobile_var_no_inventories_found'),
                'not_found_in_trash' => automobile_var_plugin_text_srt('automobile_var_no_inventories_found_in_trash')
            );
            $args = array(
                'labels' => $labels,
                'description' => automobile_var_plugin_text_srt('automobile_var_description'),
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'inventory'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor'),
				'exclude_from_search' => true
            );
            register_post_type('inventory', $args);
        }
        /**
         * @Register Inventory Make
         * @return
         */
        function create_inventory_make() {
            global $automobile_var_plugin_static_text;
			$strings = new automobile_plugin_all_strings;
			$strings->automobile_var_plugin_all_strings();
            $labels = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_inventory_makes_taxonomy'),
                'singular_name' => automobile_var_plugin_text_srt('automobile_var_inventory_make_taxonomy'),
                'search_items' => automobile_var_plugin_text_srt('automobile_var_search_inventory_makes'),
                'all_items' => automobile_var_plugin_text_srt('automobile_var_all_inventory_makes'),
                'parent_item' => automobile_var_plugin_text_srt('automobile_var_parent_inventory_make'),
                'parent_item_colon' => automobile_var_plugin_text_srt('automobile_var_parent_inventory_make_colon'),
                'edit_item' => automobile_var_plugin_text_srt('automobile_var_edit_inventory_make'),
                'update_item' => automobile_var_plugin_text_srt('automobile_var_update_inventory_make'),
                'add_new_item' => automobile_var_plugin_text_srt('automobile_var_add_new_inventory_make'),
                'new_item_name' => automobile_var_plugin_text_srt('automobile_var_new_inventory_make_name'),
                'menu_name' => automobile_var_plugin_text_srt('automobile_var_inventory_makes'),
            );
            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => false,
                'meta_box_cb' => false,
                'show_in_quick_edit' => false,
                'rewrite' => array('slug' => 'inventory-make'),
            );
            register_taxonomy('inventory-make', array('inventory'), $args);
           
            // Add to admin_init function
add_filter('manage_edit-inventory_columns', 'my_edit_inventory_columns');

function my_edit_inventory_columns($columns) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Inventory Name','cs-automobile'),
        'posted_by' => __('Posted By','cs-automobile'),
        'expired_on' => __('Expired On','cs-automobile'),
        'type' => __('Inventory Type','cs-automobile')
    );
    return $columns;
}

add_action('manage_inventory_posts_custom_column', 'my_manage_inventory_columns', 10, 2);

function my_manage_inventory_columns($column, $post_id) {
    global $post;
    switch ($column) {
        case 'posted_by' :
            $automobile_user_id = get_post_meta($post_id, 'automobile_inventory_username', true);
            if (!empty($automobile_user_id))
                $user_info = "";
            $user_info = get_userdata($automobile_user_id);
            if (is_object($user_info)) {
                echo $user_info->user_login . "\n";
            } else {
                echo __('Unknown');
            }
            break;
        case 'expired_on' :
            $automobile_timestempterms = get_post_meta($post_id, 'automobile_inventory_expired', true);
            if (!empty($automobile_timestempterms)) {

                echo $date = date('d-m-Y', $automobile_timestempterms);
            } else {
                echo __('Unknown');
            }
            break;
        case 'type' :
            $automobile_type = get_post_meta($post_id, 'automobile_inventory_type', true);
            if (empty($automobile_type)) {
                echo __('Unknown');
            } else {
                echo $automobile_type;
            }
            break;
        default :
            break;
    }
}

        }

        /**
         * @Register Inventory Model
         * @return
         */
        function create_inventory_model() {

            global $automobile_var_plugin_static_text;
            $labels = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_inventory_models_taxonomy'),
                'singular_name' => automobile_var_plugin_text_srt('automobile_var_inventory_model_taxonomy'),
                'search_items' => automobile_var_plugin_text_srt('automobile_var_search_inventory_models'),
                'all_items' => automobile_var_plugin_text_srt('automobile_var_all_inventory_models'),
                'parent_item' => automobile_var_plugin_text_srt('automobile_var_parent_inventory_model'),
                'parent_item_colon' => automobile_var_plugin_text_srt('automobile_var_parent_inventory_model_colon'),
                'edit_item' => automobile_var_plugin_text_srt('automobile_var_edit_inventory_model'),
                'update_item' => automobile_var_plugin_text_srt('automobile_var_update_inventory_model'),
                'add_new_item' => automobile_var_plugin_text_srt('automobile_var_add_new_inventory_model'),
                'new_item_name' => automobile_var_plugin_text_srt('automobile_var_new_inventory_model_name'),
                'menu_name' => automobile_var_plugin_text_srt('automobile_var_inventory_models'),
            );

            $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => false,
                'query_var' => false,
                'meta_box_cb' => false,
                'show_in_quick_edit' => false,
                'rewrite' => array('slug' => 'inventory-model'),
            );

            register_taxonomy('inventory-model', array('inventory'), $args);
        }

        function remove_inventory_parent_category() {
            // don't run in the Tags screen
            if (isset($_GET['taxonomy']) && ('inventory-make' == $_GET['taxonomy'] || 'inventory-model' == $_GET['taxonomy'])) {

                $parent = 'parent()';

                if (isset($_GET['action']))
                    $parent = 'parent().parent()';
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function ($)
                    {
                        $('label[for=parent]').<?php echo $parent; ?>.remove();
                    });
                </script>
                <?php
            }
        }

        function create_locations_taxonomies() {
            global $automobile_var_plugin_static_text;
            

            register_taxonomy("automobile_locations", array("inventory"), array
                (
                "hierarchical" => true,
                "label" => automobile_var_plugin_text_srt('automobile_var_locations'),
                'labels' => array('new_item_name' => automobile_var_plugin_text_srt('automobile_var_new_location'),
                    'add_new_item' => automobile_var_plugin_text_srt('automobile_var_add_new_location'),
                    'edit_item' => automobile_var_plugin_text_srt('automobile_var_edit_location'),
                    'show_ui' => true,
                    "singular_label" => "automobile_locations"),
                'not_found' => automobile_var_plugin_text_srt('automobile_var_no_locations_found'),
                "public" => false,
                'show_ui' => true,
                "show_in_menu" => true,
                "rewrite" => false
                    )
            );
        }

        /**
         * Start Function How to create taxonomies
         */
        function create_dealer_type_taxonomies() {

            global $automobile_var_plugin_static_text;
           
            register_taxonomy("dealer_type", array("inventory"), array
                (
                "hierarchical" => true,
                "label" => automobile_var_plugin_text_srt('automobile_var_dealer_type'),
                'labels' => array('new_item_name' => automobile_var_plugin_text_srt('automobile_var_new_dealer_type'),
                    'add_new_item' => automobile_var_plugin_text_srt('automobile_var_add_new_dealer_type'),
                    'edit_item' => automobile_var_plugin_text_srt('automobile_var_edit_dealer_type'),
                    "singular_name" => automobile_var_plugin_text_srt('automobile_var_dealer_type'),
                ),
                "public" => false,
                'show_ui' => true,
                "show_in_menu" => true,
                "rewrite" => false)
            );
        }

        /**
         * End Function How to create taxonomies
         */
        function remove_my_taxanomy_meta() {
            remove_meta_box('automobile_locationsdiv', 'inventory', 'side');
        }

        function full_width_location() {

            $a_get_current_requset_uri = $_SERVER["REQUEST_URI"];
            $a_get_current_requset_uri = explode("?", $a_get_current_requset_uri);
            $a_get_current_taxonomy = isset($a_get_current_requset_uri[1]) ? explode("&", $a_get_current_requset_uri[1]) : '';
            if (is_array($a_get_current_taxonomy) && count($a_get_current_taxonomy) > 0) {
                if (isset($a_get_current_taxonomy[0]) && $a_get_current_taxonomy['0'] == 'taxonomy=automobile_locations') {
                    echo '<style type="text/css">';
                    echo '#col-right {width:100%;}
							#popup_div {
									background-color: #fff;
									border: 2px solid #ccc;
									box-shadow: 10px 10px 5px #888888;
									display: none;
									padding: 12px;
									position: fixed;
									left: 497px;
									top: 90px; 
									z-index: 10000;
								} 
								
								#close_div{float:right;} 
								';
                    echo '</style>';
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            jQuery(".top").prepend('<a href="javascript:void(0);" id="btn_add" class="button">Add Location</a>'); // add link 
                            jQuery("#col-left").hide();

                            var popupDiv = '<div id="popup_div"><span id="close_div" class="icon icon-close icon-close2"></span></div>'; // popup container html
                            jQuery("#wpfooter").prepend(popupDiv); // send to footer div
                            jQuery("#tag-name").attr("required", "true");
                            jQuery(".term-description-wrap").hide();
                            jQuery("#popup_div").hide();
                            // jQuery("#parent").addClass('postform chosen-select');

                            jQuery(document).on('click', '#btn_add', function () {
                                jQuery("#popup_div").show();
                                jQuery("#col-left").show();
                                var texonomy_form = jQuery("#col-left").html();
                                jQuery("#popup_div").append(texonomy_form);
                                jQuery("#col-container #col-left").hide();
                                jQuery("#col-container #col-left").html('');
                                return false;
                            });
                            jQuery(document).on('click', '#close_div', function () {
                                jQuery("#popup_div").slideUp();
                            })
                        });
                    </script>

                    <?php
                }
            }
        }

        /**
         * Start Function How to create coloumes of post and theme
         */
        function theme_columns($theme_columns) {
            global $automobile_var_plugin_static_text;
            $new_columns = array(
                'cb' => '<input type="checkbox" />',
                'name' => automobile_var_plugin_text_srt('automobile_var_name'),
                'header_icon' => '',
                'slug' => automobile_var_plugin_text_srt('automobile_var_slug'),
                'posts' => automobile_var_plugin_text_srt('automobile_var_posts')
            );
            return $new_columns;
        }

    }

    return new automobile_post_inventory();
}