<?php

/*
  Plugin Name: CS Automobile
  Plugin URI: http://themeforest.net/user/Chimpstudio/
  Description: CS Automobile.
  Version: 2.0
  Author: ChimpStudio
  Author URI: http://themeforest.net/user/Chimpstudio/
  Requires at least: 4.1
  Tested up to: 6.0
  Text Domain: cs-automobile
  Domain Path: /languages/

  Copyright: 2015 chimpgroup (email : info@chimpstudio.co.uk)
  License: GNU General Public License v3.0
  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( ! class_exists( 'automobile_var' ) ) :

    class automobile_var {

        protected static $_instance = null;

        /**
         * Main Plugin Instance
         *
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Initiate Plugin Actions
         *
         */
        public function __construct() {

            $this->plugin_actions();
            $this->define_constants();
            $this->includes();

            add_action( 'admin_menu', array( $this, 'automobile_register_automobile_settings' ) );
        }

        /**
         * Initiate Plugin 
         * Text Domain
         * @return
         */
//        public function load_plugin_textdomain() {
//
//            if ( session_id() == '' ) {
//                session_start();
//            }
//            $locale = apply_filters( 'plugin_locale', get_locale(), 'cs-automobile' );
//
//            load_textdomain( 'cs-automobile', WP_LANG_DIR . '/cs-automobile/cs-automobile-' . $locale . '.mo' );
//            load_plugin_textdomain( 'cs-automobile', false, plugin_basename( dirname( __FILE__ ) ) . "/languages" );
//        }

        /**
         * Fetch and return version of the current plugin
         *
         * @return	string	version of this plugin
         */
        public static function get_plugin_version() {
            $plugin_data = get_plugin_data( __FILE__ );
            return $plugin_data['Version'];
        }

        /**
         * What type of request is this?
         * string $type ajax, frontend or admin
         * @return bool
         */
        public function is_request( $type ) {
            switch ( $type ) {
                case 'admin' :
                    return is_admin();
                case 'ajax' :
                    return defined( 'DOING_AJAX' );
                case 'cron' :
                    return defined( 'DOING_CRON' );
                case 'frontend' :
                    return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
            }
        }

        /**
         * Start Function how to Create WC Contants
         */
        private function define_constants() {
            global $post, $wp_query, $automobile_var_plugin_options, $current_user, $automobile_jh_scodes, $plugin_user_images_directory;
            $automobile_var_plugin_options = get_option( 'automobile_var_plugin_options' );
            $this->plugin_url = plugin_dir_url( __FILE__ );
            $this->plugin_dir = plugin_dir_path( __FILE__ );
            $plugin_user_images_directory = 'cs-automobile-users';
        }

        /**
         * Include required core files 
         * used in admin and on the frontend.
         */
        public function includes() {
            if ( ! defined( 'PLUGIN_DOMAIN' ) ) {
                define( 'PLUGIN_DOMAIN', 'cs-automobile' );
            }
            // importer hooks
            require_once ABSPATH . '/wp-admin/includes/file.php';
            require_once 'backend/importer-hooks.php';
            require_once 'assets/common/translate/cs-strings.php';
            require_once 'includes/cs-core-functions.php';
            require_once 'includes/cs-functions.php';
            if ( $this->is_request( 'admin' ) ) {
                require_once 'backend/custom-fields/cs-form-fields.php';
                require_once 'backend/custom-fields/cs-html-fields.php';
                require_once 'backend/users/cs-meta.php';
                require_once 'backend/users/cs-import.php';
                require_once 'backend/plugin_settings.php';
            }
            require_once 'classes/class_transactions.php';

            require_once 'backend/custom-fields/cs-form-fields.php';
            require_once 'frontend/custom-fields/form-fields-frontend.php';
            require_once 'frontend/custom-fields/cs-html_fields_frontend.php';
            require_once 'backend/post-types/cs-inventory.php';
            if ( $this->is_request( 'admin' ) ) {
                require_once 'backend/meta-boxes/cs-inventory-meta.php';
            }

            require_once 'backend/post-types/cs-inventory-type.php';
            if ( $this->is_request( 'admin' ) ) {
                require_once 'backend/dynamic-fields/cs-inventory-type-fields.php';
                require_once 'backend/dynamic-fields/cs-dealer-fields.php';
            }
            require_once 'backend/meta-boxes/cs-inventory-type-meta.php';

            require_once 'frontend/inventories/cs-functions.php';
            require_once 'templates/functions.php';
            // for login
            require_once 'templates/elements/login/login_functions.php';
            require_once 'templates/elements/login/login_forms.php';
            require_once 'templates/elements/login/shortcodes.php';

            if ( $this->is_request( 'admin' ) ) {
                require_once 'backend/elements/cs-inventories.php';
                require_once 'backend/elements/cs-dealer.php';
                require_once 'backend/elements/cs-inventory-type.php';
                require_once 'backend/elements/cs-inventories-compare.php';
                require_once 'backend/elements/cs-package.php';
            }
            require_once 'frontend/cs-shortcodes/cs-package.php';
            require_once 'frontend/cs-shortcodes/cs-inventory-type.php';
            require_once 'frontend/inventories-search/search-element.php';
            require_once 'frontend/inventories-search/search-template.php';
            require_once 'frontend/inventories/cs-template.php';
            require_once 'frontend/inventories/cs-compare-template.php';
            // linkedin login
            // recaptchas
            // for login
            require_once 'templates/elements/login/login_functions.php';
            require_once 'templates/elements/login/login_forms.php';
            require_once 'templates/elements/login/shortcodes.php';
            require_once 'templates/elements/login/cs-social-login/cs-social-login.php';
            require_once 'templates/elements/login/cs-social-login/google/automobile_google_connect.php';
            // linkedin login
            // recaptchas
            require_once 'templates/elements/login/recaptcha/autoload.php';
            // for dealer listing
            require_once 'templates/listings/dealer/cs-template.php';
            // Location Checker
            require_once 'classes/class_location_check.php';
            require_once 'templates/dashboards/dealer/cs-dealer-functions.php';
            require_once 'templates/dashboards/dealer/cs-dealer-templates.php';
            require_once 'templates/dashboards/dealer/cs-dealer-ajax-templates.php';
            require_once 'classes/class_dashboards_templates.php';
            require_once 'backend/classes/class-save-post-options.php';
            require_once 'payments/class-payments.php';
            require_once 'payments/config.php';

            // Plugin Settings Files
            if ( $this->is_request( 'admin' ) ) {
                require_once 'backend/settings/plugin_options.php';
                require_once 'backend/settings/plugin_options_functions.php';
                require_once 'backend/settings/plugin_options_fields.php';
                require_once 'backend/settings/plugin_options_array.php';
            }

            // Inventory Package Files
            //  require_once 'templates/packages/inventory/inventory_package_elements.php';
            //   require_once 'templates/packages/inventory/inventory_package_functions.php';
            require_once 'backend/post-types/cs-transaction.php';
            require_once 'backend/meta-boxes/cs-transactions-meta.php';
            // require_once 'backend/post-types/transaction/transactions_meta.php';
            //Custom Fields
            require_once 'backend/meta-boxes/cs-meta.php';

            // Plugin Widget Files
            require_once 'widgets/cs-featured-listings.php';

            // Shorcode Functions File
            if ( $this->is_request( 'admin' ) ) {
                require_once 'backend/elements/shortcode_functions.php';
            }
        }

        public function automobile_register_automobile_settings() {
            global $automobile_var_plugin_static_text;
            //add submenu page
            add_submenu_page( 'edit.php?post_type=inventory', automobile_var_plugin_text_srt( 'automobile_var_settings' ), automobile_var_plugin_text_srt( 'automobile_var_settings' ), 'manage_options', 'automobile_settings', array( &$this, 'automobile_settings' ) );
        }

        public function automobile_settings() {
            // initialize settings array 
            automobile_settings_option();

            automobile_settings_options_page();
        }

        /**
         * Start Function how to Add table Style Script
         */
        public static function automobile_data_table_style_script() {
            wp_enqueue_script( 'automobile_jquery_data_table_js', plugins_url( '/assets/scripts/jquery.data_tables.js', __FILE__ ), '', '', true );
            wp_enqueue_style( 'automobile_data_table_css', plugins_url( '/assets/css/jquery.data_tables.css', __FILE__ ) );
        }

        /**
         * End Function how to Add Tablit Style Script
         */

        /**
         * Set plugin actions.
         * @return
         */
        public function plugin_actions() {

            add_action( 'init', array( $this, 'load_plugin_textdomain' ), 0 );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_files_enqueue' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'frontend_files_enqueue' ), 2 );
             add_action( 'wp_enqueue_scripts', array( $this, 'frontend_files_enqueue_responsive' ), 3 );
             add_filter( 'template_include', array( $this, 'automobile_var_single_template' ) );
            add_action( 'admin_menu', array( $this, 'admin_menu_position' ) );
            add_action( 'admin_menu', array( $this, 'admin_sub_menu_positions' ) );
        }
        public function load_plugin_textdomain() {
            if ( session_id() == '' ) {
                session_start();
            }
            if ( function_exists( 'icl_object_id' ) ) {

                global $sitepress, $wp_filesystem;

                require_once ABSPATH . '/wp-admin/includes/file.php';

                $backup_url = '';

                if ( false === ($creds = request_filesystem_credentials( $backup_url, '', false, false, array() ) ) ) {

                    return true;
                }

                if ( ! WP_Filesystem( $creds ) ) {
                    request_filesystem_credentials( $backup_url, '', true, false, array() );
                    return true;
                }

                $cs_languages_dir = plugin_dir_path( __FILE__ ) . 'languages/';

                $cs_all_langs = $wp_filesystem->dirlist( $cs_languages_dir );

                $cs_mo_files = array();
                if ( is_array( $cs_all_langs ) && sizeof( $cs_all_langs ) > 0 ) {
					
                    foreach ( $cs_all_langs as $file_key => $file_val ) {

                        if ( isset( $file_val['name'] ) ) {

                            $cs_file_name = $file_val['name'];

                            $cs_ext = pathinfo( $cs_file_name, PATHINFO_EXTENSION );

                            if ( $cs_ext == 'mo' ) {
                                $cs_mo_files[] = $cs_file_name;
                            }
                        }
                    }
                }

                $cs_active_langs = $sitepress->get_current_language();

                foreach ( $cs_mo_files as $mo_file ) {
                    if ( strpos( $mo_file, $cs_active_langs ) !== false ) {
                        $cs_lang_mo_file = $mo_file;
                    }
                }
            }
			
            $locale = apply_filters( 'plugin_locale', get_locale(), 'cs-automobile' );
            $dir = trailingslashit( WP_LANG_DIR );
            if ( isset( $cs_lang_mo_file ) && $cs_lang_mo_file != '' ) {
                load_textdomain( 'cs-automobile', plugin_dir_path( __FILE__ ) . "languages/" . $cs_lang_mo_file );
            } else {
                load_textdomain( 'cs-automobile', plugin_dir_path( __FILE__ ) . "languages/cs-automobile-" . $locale . '.mo' );
            }
        }
        /**
         *
         * @Responsive Tabs Styles and Scripts
         */
        public static function automobile_enqueue_tabs_script() {
            
        }

        /**
         * End Function how to Add Tablit Style Script
         */

        /**
         * Start Function how to Create plugin Directory
         */
        public static function plugin_dir() {
            return plugin_dir_path( __FILE__ );
        }

        /**
         * End Function how to Create plugin Directory
         */
        public static function automobile_jquery_ui_scripts() {
            
        }

        /**
         * @Admin Menu Filter
         * Menu Positions
         */
        public function admin_menu_position() {
            global $menu, $submenu;

            if ( current_user_can( 'administrator' ) ) {
                foreach ( $menu as $key => $menu_item ) {
                    if ( isset( $menu_item[2] ) && $menu_item[2] == 'edit.php?post_type=inventory' ) {
                        $menu[$key][0] = __( 'Automobile', 'cs-automobile' );
                    }
                }
            }
        }

        /**
         * @Sub Menu Filter
         * Menu Positions
         */
        public function admin_sub_menu_positions() {
            global $menu, $submenu;

            if ( current_user_can( 'administrator' ) ) {
                $arr = array();
                $arr[] = isset( $submenu['edit.php?post_type=inventory'][5] ) ? $submenu['edit.php?post_type=inventory'][5] : '';
                $arr[] = isset( $submenu['edit.php?post_type=inventory'][19] ) ? $submenu['edit.php?post_type=inventory'][19] : '';
                $arr[] = isset( $submenu['edit.php?post_type=inventory'][18] ) ? $submenu['edit.php?post_type=inventory'][18] : '';
                $arr[] = isset( $submenu['edit.php?post_type=inventory'][15] ) ? $submenu['edit.php?post_type=inventory'][15] : '';
                $arr[] = isset( $submenu['edit.php?post_type=inventory'][16] ) ? $submenu['edit.php?post_type=inventory'][16] : '';
                $arr[] = isset( $submenu['edit.php?post_type=inventory'][17] ) ? $submenu['edit.php?post_type=inventory'][17] : '';
                $arr[] = isset( $submenu['edit.php?post_type=inventory'][20] ) ? $submenu['edit.php?post_type=inventory'][20] : '';
                $submenu['edit.php?post_type=inventory'] = $arr;

                return $submenu;
            }
        }

        /**
         * Get the plugin url.
         * @return string
         */
        public static function plugin_url() {
            return trailingslashit( plugins_url( '/', __FILE__ ) );
        }

        /**
         * Get the plugin path.
         * @return string
         */
        public static function plugin_path() {
            return untrailingslashit( plugin_dir_path( __FILE__ ) );
        }

        /**
         * Get the plugin template path.
         * @return string
         */
        public function template_path() {
            return apply_filters( 'automobile_plugin_template_path', 'cs-automobile/' );
        }

        /**
         * Start Function how to Add Location Picker Scripts
         */
        public function automobile_location_gmap_script() {
            wp_enqueue_script( 'jquery_latlon_picker_js', plugins_url( '/assets/backend/js/jquery_latlon_picker.js', __FILE__ ), '', '', true );
        }

        /**
         * End Function how to Add Location Picker Scripts
         */

        /**
         * Start Function how to Activate the plugin
         */
        public static function activate() {
            global $plugin_user_images_directory;
            add_option( 'automobile_var_plugin_activation', 'installed' );
            add_option( 'automobile_var', '1' );
            // create user role for dealer
            $result = add_role(
                    'automobile_dealer', 'Dealer', array(
                'read' => false,
                'edit_posts' => false,
                'delete_posts' => false,
                    )
            );
            // create users images directory 
            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/' . $plugin_user_images_directory;
            if ( ! is_dir( $upload_dir ) ) {
                mkdir( $upload_dir, 0777 );
            }
        }

        /**
         * Start Function how to DeActivate the plugin
         */
        static function deactivate() {
            delete_option( 'automobile_var_plugin_activation' );
            delete_option( 'automobile_var', false );
        }
        /**
         * Start Function for single pages
         */
        public function automobile_var_single_template( $single_template ) {
            global $post;

            if ( get_post_type() == 'inventory' ) {
                if ( is_single() ) {
                    $single_template = plugin_dir_path( __FILE__ ) . 'templates/single-pages/inventory/cs-single.php';
                }
            }

            return $single_template;
        }

        /**
         * Default plugin 
         * admin files enqueue.
         * @return
         */
        public function admin_files_enqueue() {

            if ( $this->is_request( 'admin' ) ) {
                // admin css files
                wp_enqueue_style( 'bootstrap-style', plugins_url( '/assets/backend/css/bootstrap.css', __FILE__ ) );
                wp_enqueue_style( 'fonticonpicker-style', plugins_url( '/assets/common/icomoon/css/jquery.fonticonpicker.min.css', __FILE__ ) );
                wp_enqueue_style( 'automobile-iconmoon-style', plugins_url( '/assets/common/icomoon/css/iconmoon.css', __FILE__ ) );
                wp_enqueue_style( 'fonticonpicker-bootstrap', plugins_url( '/assets/common/icomoon/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css', __FILE__ ) );
                wp_enqueue_style( 'wp-color-picker' );

                wp_enqueue_style( 'automobile-admin-styles', plugins_url( '/assets/backend/css/admin-style.css', __FILE__ ) );
                wp_enqueue_style( 'automobile-datatable-css', plugins_url( '/assets/backend/css/datatable.css', __FILE__ ) );
                wp_enqueue_style( 'chosen-style', plugins_url( '/assets/common/css/chosen.css', __FILE__ ) );
                // editor css file
                wp_enqueue_style( 'editor-style', plugins_url( '/assets/backend/editor/css/jquery-te-1.4.0.css', __FILE__ ) );

                // js scripts enqueue
                $automobile_var_template_path = plugins_url( '/assets/backend/js/bootstrap.min.js', __FILE__ );
                wp_enqueue_script( 'automobile-admin-upload-script', $automobile_var_template_path, array( 'jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker' ) );
                wp_enqueue_script( 'automobile-datatable-script', plugins_url( '/assets/backend/js/datatable.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'fonticonpicker-script', plugins_url( '/assets/common/icomoon/js/jquery.fonticonpicker.min.js', __FILE__ ) );
                wp_enqueue_script( 'automobile-common-scripts', plugins_url( '/assets/backend/js/cs-common-scripts.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'cs-automobile-modernizr-script', plugins_url( '/assets/common/js/modernizr.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'automobile-common-jquery-datetimepicker-script', plugins_url( '/assets/common/js/jquery_datetimepicker.js', __FILE__ ) );
                wp_enqueue_script( 'automobile-chosen-select-script', plugins_url( '/assets/common/js/chosen.select.js', __FILE__ ), '', '', true );
                // editor js file
                wp_enqueue_script( 'automobile-editor-script', plugins_url( '/assets/backend/editor/scripts/jquery-te-1.4.0.min.js', __FILE__ ), '', '', true );
                // shortcode scripts
                wp_enqueue_script( 'automobile-shortcode-script', plugins_url( '/assets/backend/js/shortcode-functions.js', __FILE__ ), '', '', true );

                wp_enqueue_script( 'automobile-common-main-scriptss', plugins_url( '/assets/common/js/automobile-functions.js', __FILE__ ) );
                wp_enqueue_script( 'automobile-commonextra-function-scripts', plugins_url( '/assets/common/js/extra_functions.js', __FILE__ ) );
            }
        }

        /**
         * Default plugin 
         * front files enqueue.
         * @return
         */
        public function frontend_files_enqueue() {

            if ( $this->is_request( 'frontend' ) ) {

                // css files enqueue
                wp_register_style( 'automobile-mCustomScrollbar-css', plugins_url( '/assets/frontend/css/jquery.mcustomscrollbar.css', __FILE__ ) );
                wp_enqueue_style( 'bootstrap-style', plugins_url( '/assets/common/css/bootstrap.css', __FILE__ ) );
                wp_enqueue_style( 'fonticonpicker-bootstrap', plugins_url( '/assets/common/icomoon/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css', __FILE__ ) );
                wp_enqueue_style( 'automobile-plugin-css', plugins_url( '/assets/frontend/css/cs-automobile-plugin.css', __FILE__ ) );
                wp_enqueue_style( 'bootstrap-slider-css', plugins_url( '/assets/frontend/css/bootstrap-slider.css', __FILE__ ) );
                wp_enqueue_style( 'automobile-iconmoon-style', plugins_url( '/assets/common/icomoon/css/iconmoon.css', __FILE__ ) );
                wp_enqueue_style( 'jquery-datetimepicker-style', plugins_url( '/assets/common/css/jquery_datetimepicker.css', __FILE__ ) );
                wp_enqueue_style( 'chosen-style', plugins_url( '/assets/common/css/chosen.css', __FILE__ ) );
                wp_enqueue_style( 'automobile_gallery_css', plugins_url( '/assets/frontend/css/gallery.css', __FILE__ ) );
                $automobile_var_plugin_options = get_option( 'automobile_var_plugin_options' );
                $automobile_var_plugin_options  = is_array($automobile_var_plugin_options)? $automobile_var_plugin_options : array();
                $automobile_default_css_option = isset( $automobile_var_plugin_options['automobile_common-elements-style'] ) ? $automobile_var_plugin_options['automobile_common-elements-style'] : 'no-set';
                //Common css Elements
                if ( $automobile_default_css_option == 'on' ) {
                    wp_enqueue_style( 'automobile_var_plugin_defalut_elements_css', plugins_url( '/assets/common/css/default-elements.css', __FILE__ ) );
                }

                //recaptcha
                //wp_enqueue_script( 'google_recaptcha_scripts', 'https://www.google.com/recaptcha/api.js?onload=cs_multicap&amp;render=explicit', '', '' );
                // js scripts enqueue 
				
                //wp_enqueue_script( 'automobile-mootools', plugins_url( '/assets/frontend/js/mootools.js', __FILE__ ), '', '' );
                wp_enqueue_script( 'bootstrap_slider_js', plugins_url( '/assets/frontend/js/bootstrap-slider.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'bootstrap-min-script', plugins_url( '/assets/frontend/js/bootstrap.min.js', __FILE__ ), array( 'jquery' ) );
                wp_enqueue_script( 'slick-script', plugins_url( '/assets/frontend/js/slick.js', __FILE__ ), '', '', true );
				wp_enqueue_script( 'automobile-function-script', plugins_url( '/assets/frontend/js/cs-common-scripts.js', __FILE__ ), '', '', true );
                wp_register_script( 'mCustomScrollbar-scripts', plugins_url( '/assets/frontend/js/jquery.mCustomScrollbar.concat.min.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'modernizr-script', plugins_url( '/assets/common/js/modernizr.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'jquery-datetimepicker-script', plugins_url( '/assets/common/js/jquery_datetimepicker.js', __FILE__ ), '', '', true );
                $google_api_key = '?libraries=places';
				if ( isset( $automobile_var_plugin_options['automobile_google_api_key'] ) && $automobile_var_plugin_options['automobile_google_api_key'] != '' ) {
					$google_api_key = '?key=' . $automobile_var_plugin_options['automobile_google_api_key'] . '&libraries=places';
				}
				
			
				wp_enqueue_script( 'automobile-google-autocomplete-script', 'https://maps.googleapis.com/maps/api/js' . $google_api_key );
                wp_enqueue_script( 'automobile-jquery.cookie', plugins_url( '/assets/frontend/js/jquery.cookie.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'automobile-chosen-select-script', plugins_url( '/assets/common/js/chosen.select.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'automobile-plugin-funtions-script', plugins_url( '/assets/frontend/js/plugin-funtions.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'automobile-commonextra-function-scripts', plugins_url( '/assets/common/js/extra_functions.js', __FILE__ ), '', '', true );
                wp_enqueue_script( 'automobile-common-main-scripts', plugins_url( '/assets/common/js/automobile-functions.js', __FILE__ ), '', '', true );
                wp_localize_script(
                        'automobile-common-main-scripts', 'automobile_globals', array(
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'google_api_key'    => isset( $automobile_var_plugin_options['automobile_google_api_key'] )? $automobile_var_plugin_options['automobile_google_api_key'] : '',
                        )
                );
                
                
                wp_enqueue_script( 'automobile-lazy-sizes-image', plugins_url( '/assets/frontend/js/lazy-sizes-image.js', __FILE__ ), '', '', true );
				wp_enqueue_script( 'vimeocdn-froogaloop2', 'https://a.vimeocdn.com/js/froogaloop2.min.js', '', '', true );
				 
				 
            }
        }

        public function frontend_files_enqueue_responsive() {
            if ( $this->is_request( 'frontend' ) && is_rtl() ) {
                wp_enqueue_style( 'automobile-rtl-css', plugins_url( '/assets/frontend/css/rtl.css', __FILE__ ) );
            }
        }

        // start function for google map files 
        public static function automobile_var_googlemapcluster_scripts() {
            wp_enqueue_script( 'automobile-googlemapcluster', plugins_url( '/assets/frontend/js/markerclusterer.js', __FILE__ ), '', '', true );
            wp_enqueue_script( 'automobile-var-map-info', plugins_url( '/assets/frontend/js/map-infobox.js', __FILE__ ), '', '', true );
        }

        /**
         * End Function how to Add Google Place Scripts
         */

        /**
         * Start Function how to Add Google Place Scripts
         */
        public function automobile_google_place_scripts() {
            global $automobile_var_plugin_options;
            $google_api_key = '?libraries=places';
			if ( isset( $automobile_var_plugin_options['automobile_google_api_key'] ) && $automobile_var_plugin_options['automobile_google_api_key'] != '' ) {
				$google_api_key = '?key=' . $automobile_var_plugin_options['automobile_google_api_key'] . '&libraries=places';
			}
			wp_enqueue_script( 'automobile-google-autocomplete-script', 'https://maps.googleapis.com/maps/api/js' . $google_api_key );
            wp_enqueue_script( 'automobile-googlemapcluster', plugins_url( '/assets/frontend/js/markerclusterer.js', __FILE__ ), '', '', true );
            wp_enqueue_script( 'automobile-var-map-info', plugins_url( '/assets/frontend/js/map-infobox.js', __FILE__ ), '', '', true );
        }

        /**
         * Start Function how to Add Google Autocomplete Scripts
         */
        public function automobile_autocomplete_scripts() {
            wp_enqueue_script( 'jquery-ui-autocomplete' );
            wp_enqueue_script( 'jquery-ui-slider' );
        }

        /**
         * End Function how to Add Google Autocomplete Scripts
         */
    }

    /**
     *
     * @login popup script files
     */
    if ( ! function_exists( 'automobile_range_slider_scripts' ) ) {

        function automobile_range_slider_scripts() {
            
        }

    }

    /**
     *
     * @google auto complete script
     */
    if ( ! function_exists( 'automobile_google_autocomplete_scripts' ) ) {

        function automobile_google_autocomplete_scripts() {

            wp_enqueue_script( 'location_autocomplete_js', plugins_url( '/assets/common/js/jquery.location-autocomplete.js', __FILE__ ), '', '' );
        }

    }

    /**
     *
     * @Add this enqueue Script
     */
    if ( ! function_exists( 'automobile_addthis_script_init_method' ) ) {

        function automobile_addthis_script_init_method() {
            wp_enqueue_script( 'addthis_js', automobile_server_protocol() . 's7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true );
        }

    }

    /**
     *
     * @login popup script files
     */
    if ( ! function_exists( 'automobile_google_recaptcha_scripts' ) ) {

        function automobile_google_recaptcha_scripts() {

            //  wp_enqueue_script('automobile_google_recaptcha_scripts', 'https://www.google.com/recaptcha/api.js', '', '');
            //  wp_enqueue_script('automobile_google_recaptcha_scripts', 'https://www.google.com/recaptcha/api.js?onload=automobile_multicap&amp;render=explicit', '', '');
        }

    }
    /**
     *
     * @login popup script files
     */
    if ( ! function_exists( 'automobile_login_box_popup_scripts' ) ) {

        function automobile_login_box_popup_scripts() {
            //    wp_enqueue_script('automobile_uiMorphingButton_fixed_js', plugins_url('/assets/common/js/uiMorphingButton_fixed.js', __FILE__), '', '', true);
        }

    }
    /**
     *
     * @social login script
     */
    if ( ! function_exists( 'automobile_socialconnect_scripts' ) ) {

        function automobile_socialconnect_scripts() {
            wp_enqueue_script( 'socialconnect_js', plugins_url( '/templates/elements/login/cs-social-login/media/js/cs-connect.js', __FILE__ ), '', '', true );
        }

    }

    function automobile_var() {
        register_activation_hook( __FILE__, array( 'automobile_var', 'activate' ) );
        register_deactivation_hook( __FILE__, array( 'automobile_var', 'deactivate' ) );
        return automobile_var::instance();
    }

    function my_plugin_body_class( $classes ) {
        $classes[] = ' wp-automobile';
        return $classes;
    }

    add_filter( 'body_class', 'my_plugin_body_class' );
    /*
      Custom Css *
     */

    function my_styles_method() {
        get_template_directory_uri() . '/css/custom_script.css';
        $automobile_plugin_options = get_option( 'automobile_plugin_options' );
        wp_enqueue_style( 'custom-style-inline', plugins_url( '/assets/backend/css/custom_script.css', __FILE__ ) );
        $automobile_custom_css = isset( $automobile_plugin_options['automobile_style-custom-css'] ) ? $automobile_plugin_options['automobile_style-custom-css'] : '';
        $custom_css = $automobile_custom_css;
        wp_add_inline_style( 'custom-style-inline', $custom_css );
    }

    add_action( 'wp_enqueue_scripts', 'my_styles_method' );
    // Global for backwards compatibility.
    $GLOBALS['automobile_var'] = automobile_var();
endif;
/*
  Default Sidebars On/OFF Check
 */
add_action( 'wp_loaded', 'callback_function' );

function callback_function() {
    if ( ! is_admin() ) {
        $automobile_var_plugin_options = get_option( 'automobile_var_plugin_options' );
        $automobile_default_sidebar_option = isset( $automobile_var_plugin_options['automobile_default-sidebars'] ) ? $automobile_var_plugin_options['automobile_default-sidebars'] : '';
        if ( $automobile_default_sidebar_option == 'on' ) {
            global $wp_registered_sidebars;
            foreach ( $wp_registered_sidebars as $sidebar_id ) {
                $automobile_unregister_id = isset( $sidebar_id['id'] ) ? $sidebar_id['id'] : '';
                if ( $automobile_unregister_id != '' ) {
                    unregister_sidebar( $sidebar_id['id'] );
                }
            }
        }
    }
}
