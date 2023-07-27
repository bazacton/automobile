<?php

/**
 * @Saving Theme Options
 *
*/ 
if (!function_exists('theme_option_save')) {

    function theme_option_save() {
        global $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
            $strings->automobile_theme_option_strings();
        // theme option save request
        if (isset($_REQUEST['automobile_var_theme_option_save_flag'])) {
            $_POST = automobile_var_stripslashes_htmlspecialchars($_POST);
            
            update_option("automobile_var_options", $_POST);
            // create css file when them option call
            write_stylesheet_content();
            
            echo automobile_var_theme_text_srt('automobile_var_save_msg');
        }
        die();
    }

    add_action('wp_ajax_theme_option_save', 'theme_option_save');
}


/**
 * @Generate Options Backup
 * @return
 *
 */
if (!function_exists('automobile_var_settings_backup_generate')) {

    function automobile_var_settings_backup_generate() {

        global $wp_filesystem, $automobile_var_options, $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
            $strings->automobile_theme_option_field_strings();

        $automobile_var_export_options = $automobile_var_options;

        $automobile_var_option_fields = json_encode($automobile_var_export_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

        $backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

            return true;
        }

        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }

        $automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';
        $automobile_var_filename = trailingslashit($automobile_var_upload_dir) . (current_time('d-M-Y_H.i.s')) . '.json';


        if (!$wp_filesystem->put_contents($automobile_var_filename, $automobile_var_option_fields, FS_CHMOD_FILE)) {
            echo automobile_var_theme_text_srt('automobile_var_error_saving_file');
        } else {
            echo automobile_var_theme_text_srt('automobile_var_backup_generated');
        }

        die();
    }

    add_action('wp_ajax_automobile_var_settings_backup_generate', 'automobile_var_settings_backup_generate');
}

/**
 * @Delete Backup File
 * @return
 *
 */
if (!function_exists('automobile_var_backup_file_delete')) {

    function automobile_var_backup_file_delete() {

        global $wp_filesystem, $automobile_var_static_text;

        $strings = new automobile_theme_all_strings;
            $strings->automobile_theme_option_field_strings();
        $backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

            return true;
        }

        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }

        $automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';

        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';

        $automobile_var_filename = trailingslashit($automobile_var_upload_dir) . $file_name;

        if (is_file($automobile_var_filename)) {
            unlink($automobile_var_filename);
            printf(automobile_var_theme_text_srt('automobile_var_file_deleted_successfully'), $file_name);
        } else {
            echo automobile_var_theme_text_srt('automobile_var_error_deleting_file');
        }

        die();
    }

    add_action('wp_ajax_automobile_var_backup_file_delete', 'automobile_var_backup_file_delete');
}

/**
 * @Restore Backup File
 * @return
 *
 */
if (!function_exists('automobile_var_backup_file_restore')) {

    function automobile_var_backup_file_restore() {

        global $wp_filesystem, $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
            $strings->automobile_theme_option_field_strings();

        $backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

            return true;
        }

        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }

        $automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';

        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';

        $file_path = isset($_POST['file_path']) ? $_POST['file_path'] : '';

        if ($file_path == 'yes') {

            $automobile_var_file_body = '';

            $automobile_var_file_response = wp_remote_get($file_name, array('decompress' => false));

            if (is_array($automobile_var_file_response)) {
                $automobile_var_file_body = isset($automobile_var_file_response['body']) ? $automobile_var_file_response['body'] : '';
            }

            if ($automobile_var_file_body != '') {

                $get_options_file = json_decode($automobile_var_file_body, true);

                update_option("automobile_var_options", $get_options_file);


                echo automobile_var_theme_text_srt('automobile_var_file_import_successfully');
            } else {
                echo automobile_var_theme_text_srt('automobile_var_error_restoring_file');
            }

            die;
        }

        $automobile_var_filename = trailingslashit($automobile_var_upload_dir) . $file_name;

        if (is_file($automobile_var_filename)) {

            $get_options_file = $wp_filesystem->get_contents($automobile_var_filename);

            $get_options_file = json_decode($get_options_file, true);

            update_option("automobile_var_options", $get_options_file);


            $automobile_var_file_restore_successfully = automobile_var_theme_text_srt('automobile_var_file_restore_successfully');
            printf($automobile_var_file_restore_successfully, $file_name);
        } else {
            echo automobile_var_theme_text_srt('automobile_var_error_restoring_file');
        }

        die();
    }

    add_action('wp_ajax_automobile_var_backup_file_restore', 'automobile_var_backup_file_restore');
}

/**
 * @saving all the theme options end
 * @return
 *
 */
if (!function_exists('theme_option_rest_all')) {

    function theme_option_rest_all() {

        global $wp_filesystem;

        $backup_url = esc_url(home_url('/'));
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

            return true;
        }

        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }

        $automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/default-settings/';

        $automobile_var_filename = trailingslashit($automobile_var_upload_dir) . 'default-settings.json';

        if (is_file($automobile_var_filename)) {

            $get_options_file = $wp_filesystem->get_contents($automobile_var_filename);

            $get_options_file = json_decode($get_options_file, true);

            update_option("automobile_var_options", $get_options_file);
        } else {
            automobile_var_reset_data();
        }
        die;
    }

    add_action('wp_ajax_theme_option_rest_all', 'theme_option_rest_all');
}


/**
 * @Default Options for Theme
 *
*/ 

if (!function_exists('theme_default_options')) {

    function theme_default_options() {

        global $wp_filesystem;

        $backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

            return true;
        }

        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }

        $automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/default-settings/';

        $automobile_var_filename = trailingslashit($automobile_var_upload_dir) . 'default-settings.json';

        if (is_file($automobile_var_filename)) {

            $get_options_file = $wp_filesystem->get_contents($automobile_var_filename);

            $automobile_var_default_data = $get_options_file = json_decode($get_options_file, true);
        } else {
            $automobile_var_default_data = '';
        }

        return $automobile_var_default_data;
    }

}


/**
 * @Getting Demo Content
 *
*/ 
if (!function_exists('automobile_var_get_demo_content')) {

    function automobile_var_get_demo_content($automobile_var_demo_file = '') {

        global $wp_filesystem;

        $backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');
        if (false === ( $creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

            return true;
        }

        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }

        $automobile_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/demo-data/';

        $automobile_var_filename = trailingslashit($automobile_var_upload_dir) . $automobile_var_demo_file;

        $automobile_var_demo_data = array();

        if (is_file($automobile_var_filename)) {

            $get_options_file = $wp_filesystem->get_contents($automobile_var_filename);

            $automobile_var_demo_data = $get_options_file;
        }

        return $automobile_var_demo_data;
    }

}

/**
 * @theme activation
 * @return
 *
 */
if (!function_exists('automobile_var_activation_data')) {

    function automobile_var_activation_data() {
        update_option('automobile_var_options', theme_default_options());
    }

}

/**
 * @array for reset theme options
 * @return
 *
 */
if (!function_exists('automobile_var_reset_data')) {

    function automobile_var_reset_data() {
        global $reset_data, $automobile_var_settings;
        foreach ($automobile_var_settings as $value) {
            if ($value['type'] <> 'heading' and $value['type'] <> 'sub-heading' and $value['type'] <> 'main-heading') {
                if ($value['type'] == 'sidebar' || $value['type'] == 'networks' || $value['type'] == 'badges') {
                    $reset_data = (array_merge($reset_data, $value['options']));
                } elseif ($value['type'] == 'check_color') {
                    $reset_data[$value['id']] = $value['std'];
                    $reset_data[$value['id'] . '_switch'] = 'off';
                } else {
                    $reset_data[$value['id']] = $value['std'];
                }
            }
        }
        return $reset_data;
    }

}
