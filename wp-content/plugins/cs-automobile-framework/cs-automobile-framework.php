<?php

/*
  Plugin Name: CS Automobile Framework
  Plugin URI: http://themeforest.net/user/Chimpstudio/
  Description: CS Automobile Framework.
  Version: 2.0
  Author: ChimpStudio
  Author URI: http://themeforest.net/user/Chimpstudio/
  Requires at least: 4.1
  Tested up to: 6.0
  Text Domain: cs-frame
  Domain Path: /languages/

  Copyright: 2015 chimpgroup (email : info@chimpstudio.co.uk)
  License: GNU General Public License v3.0
  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('wp_automobile_framework')) :

    class wp_automobile_framework {

        public function automobile_var_save_custom_option($post_id = '') {
            global $post;

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            if (automobile_var_frame()->is_request('admin')) {
                $automobile_var_data = array();
                foreach ($_POST as $key => $value) {
                    if (strstr($key, 'automobile_var_')) {
                        $automobile_var_data[$key] = $value;
                        update_post_meta($post_id, $key, $value);
                    }
                }
                update_post_meta($post_id, 'automobile_var_full_data', $automobile_var_data);
            }
        }

        protected static $_instance = null;

        /**
         * Main Plugin Instance
         *
         */
        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Initiate Plugin Actions
         *
         */
        public function __construct() {
            global $automobile_var_frame_options;
            $automobile_var_frame_options = get_option('automobile_var_frame_options');

            define('CSFRAME_DOMAIN', 'cs-frame');
            $this->plugin_actions();
            $this->includes();
            add_action('save_post', array($this, 'automobile_var_save_custom_option'));
        }

        /**
         * Fetch and return version of the current plugin
         *
         * @return	string	version of this plugin
         */
        public static function get_plugin_version() {
            $plugin_data = get_plugin_data(__FILE__);
            return $plugin_data['Version'];
        }

        /**
         * Initiate Plugin 
         * Text Domain
         * @return
         */
        public function load_plugin_textdomain() {
            $locale = apply_filters('plugin_locale', get_locale(), 'cs-frame');

            load_textdomain('cs-frame', WP_LANG_DIR . '/cs-frame/cs-frame-' . $locale . '.mo');
            load_plugin_textdomain('cs-frame', false, plugin_basename(dirname(__FILE__)) . "/languages");
        }

        /**
         * Checking the Request Type
         * string $type ajax, frontend or admin
         * @return bool
         */
        public function is_request($type) {
            switch ($type) {
                case 'admin' :
                    return is_admin();
                case 'ajax' :
                    return defined('DOING_AJAX');
                case 'cron' :
                    return defined('DOING_CRON');
                case 'frontend' :
                    return (!is_admin() || defined('DOING_AJAX') ) && !defined('DOING_CRON');
            }
        }

        /**
         * Include required core files 
         * used in admin and on the frontend.
         */
        public function includes() {
            // Theme Domain Name

            require_once 'assets/translate/cs-strings.php';
            require_once 'includes/cs-maintenance-mode/cs-maintenance-mode.php';
            require_once 'includes/cs-maintenance-mode/cs-functions.php';
            require_once 'includes/cs-maintenance-mode/cs-fields.php';
            require_once 'includes/cs-frame-functions.php';
            require_once 'includes/cs-mailchimp/cs-class.php';
            require_once 'includes/cs-mailchimp/cs-functions.php';
            require_once 'includes/cs-page-builder.php';

            // Post and Page Meta Boxes
            require_once 'includes/cs-metaboxes/cs-page-functions.php';
            require_once 'includes/cs-metaboxes/cs-page.php';
            require_once 'includes/cs-metaboxes/cs-post.php';
            require_once 'includes/cs-metaboxes/cs-product.php';
            // Shortcodes
            require_once 'includes/cs-shortcodes/backend/cs-maintain.php';
            require_once 'includes/cs-shortcodes/frontend/cs-maintenance.php';
            // Importer
            require_once 'includes/cs-importer/theme-importer.php';
            //  require_once 'includes/cs-importer/class-widget-data.php';
            // Auto Update Theme
            require_once 'includes/cs-importer/auto-update-theme.php';
        }

        /**
         * Set plugin actions.
         * @return
         */
        public function plugin_actions() {

            add_action('init', array($this, 'load_plugin_textdomain'), 0);
            add_action('automobile_before_header', array($this, 'under_construction'));
            add_action('admin_enqueue_scripts', array($this, 'admin_plugin_files_enqueue'));
            add_action('automobile_deregister_filter', array($this, 'automobile_deregister_filter_callback'), 11, 3);
            add_action('automobile_deregister_action', array($this, 'automobile_deregister_action_callback'), 11, 3);
            
        }
        
        public function automobile_deregister_action_callback($action_name, $action_callback_function, $actionObject = ''){
            if( $actionObject != ''){
                remove_action( $action_name, array( $actionObject, $action_callback_function ), 1 );
            }else{
                remove_action( $action_name, $action_callback_function);
            }
        }
        
        public function automobile_deregister_filter_callback($filter_name, $filter_callback_function, $filterObject = ''){
            if( $filterObject != ''){
                remove_filter( $filter_name, array( $filterObject, $filter_callback_function ), 1 );
            }else{
                remove_filter( $filter_name, $filter_callback_function);
            }
        }

        /**
         * Get the plugin url.
         * @return string
         */
        public static function plugin_url() {
            return trailingslashit(plugins_url('/', __FILE__));
        }

        public static function plugin_dir() {
            return plugin_dir_path(__FILE__);
        }

        /**
         * Get the plugin path.
         * @return string
         */
        public static function plugin_path() {
            return untrailingslashit(plugin_dir_path(__FILE__));
        }

        /**
         * Default plugin 
         * admin files enqueue.
         * @return
         */
        public function admin_plugin_files_enqueue() {

            if ($this->is_request('admin')) {
                // admin js files
                $automobile_scripts_path = plugins_url('/assets/js/cs-page-builder-functions.js', __FILE__);
                wp_enqueue_script('cs-frame-admin', $automobile_scripts_path, array('jquery'));
            }
        }

        public function under_construction() {
            global $automobile_var_options, $automobile_var_frame_options, $automobile_var_frame_static_text;
            
            if (get_option('automobile_underconstruction_redirecting') != 1) {
                if (isset($automobile_var_frame_options['automobile_var_coming_soon_switch']) && $automobile_var_frame_options['automobile_var_coming_soon_switch'] == 'on' && isset($automobile_var_frame_options['automobile_var_maintinance_mode_page']) && !is_user_logged_in()) {
                    
                    if ($automobile_var_frame_options['automobile_var_maintinance_mode_page'] != '' && $automobile_var_frame_options['automobile_var_maintinance_mode_page'] != '0') {
                        update_option('automobile_underconstruction_redirecting', '1');
                        wp_redirect(get_permalink($automobile_var_frame_options['automobile_var_maintinance_mode_page']));
                        exit;
                    } else {
                        echo '
                        <script>
                            alert("' . automobile_var_frame_text_srt('automobile_var_please_select_maintinance') . '");
                        </script>';
                    }
                }
            }
        }

    }

    /**
     * Framework Instance
     * @return
     *
     */
    if (!function_exists('automobile_var_frame')) {

        function automobile_var_frame() {
            return wp_automobile_framework::instance();
        }

    }

    // Global for backwards compatibility.
    $GLOBALS['wp_automobile_framework'] = automobile_var_frame();

endif;