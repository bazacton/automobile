<?php
/* ------------------------------------------------------
 * Save Option
 * ----------------------------------------------------- */
/**
 * Start Function  how to Save Plugin Options
 */
if (!function_exists('plugin_option_save')) {

    function plugin_option_save() {
        global $reset_plugin_data, $automobile_setting_options, $automobile_var_plugin_static_text;
        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_option_strings();


        $_POST = stripslashes_htmlspecialchars($_POST);
        update_option("automobile_var_plugin_options", $_POST);

        automobile_update_packages_options();
        automobile_update_dyn_reviews();
        $response = '';
        if (class_exists('automobile_custom_fields_options')) {
            $custom_field_option = new automobile_custom_fields_options();
            $response = $custom_field_option->automobile_update_custom_fields();
        }

        if (class_exists('automobile_dealer_custom_fields_options')) {
            $automobile_dealer_custom_fields_options = new automobile_dealer_custom_fields_options();
            $response = $automobile_dealer_custom_fields_options->automobile_update_custom_fields();
        }

        echo automobile_var_plugin_text_srt('automobile_var_settings_saves');

        die();
    }

    add_action('wp_ajax_plugin_option_save', 'plugin_option_save');
}
/**
 * end Function how to Save Plugin Options
 */
/**
 * Start Function  for taking backup options fields
 */
if (!function_exists('automobile_pl_opt_backup_generate')) {

    function automobile_pl_opt_backup_generate() {
        global $wp_filesystem, $automobile_var_plugin_static_text;


        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_option_strings();

        $automobile_export_options = get_option('automobile_var_plugin_options');
        $automobile_inventory_cus_fields = get_option('automobile_inventory_cus_fields');
        $automobile_emp_cus_fields = get_option('automobile_dealer_cus_fields');
        if (is_array($automobile_export_options)) {
            $automobile_export_options['automobile_inventory_cus_fields'] = $automobile_inventory_cus_fields;
        }
       $automobile_option_fields = json_encode($automobile_export_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        $backup_url = '';
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
            return true;
        }
        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $automobile_upload_dir = automobile_var::plugin_path() . '/backend/settings/backups/';
        $automobile_filename = trailingslashit($automobile_upload_dir) . (current_time('d-M-Y_H.i.s')) . '.json';

        if (!$wp_filesystem->put_contents($automobile_filename, $automobile_option_fields, FS_CHMOD_FILE)) {
            echo automobile_var_plugin_text_srt('automobile_var_error_saving_file');
        } else {
            echo automobile_var_plugin_text_srt('automobile_var_backup_generated');
        }
        die();
    }

    add_action('wp_ajax_automobile_pl_opt_backup_generate', 'automobile_pl_opt_backup_generate');
}


/**
 * end Function  for taking backup options fields
 */
/**
 * Start Function  for demo setting
 */
if (!function_exists('automobile_get_settings_demo')) {

    function automobile_get_settings_demo($automobile_demo_file = '') {
        global $wp_filesystem;
        $backup_url = '';
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
            return true;
        }
        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $automobile_upload_dir = automobile_var::plugin_path() . 'admin/settings/demo/';
        $automobile_filename = trailingslashit($automobile_upload_dir) . $automobile_demo_file;
        $automobile_demo_data = array();
        if (is_file($automobile_filename)) {
            $get_options_file = $wp_filesystem->get_contents($automobile_filename);

            $automobile_demo_data = $get_options_file;
        }
        return $automobile_demo_data;
    }

}
/**
 * end Function  for for demo setting
 */
/**
 * Start Function  for demo data
 */
if (!function_exists('automobile_demo_plugin_data')) {

    function automobile_demo_plugin_data($filename = "") {
        // if $filename is not provided then go with the existing import plugin settings
        // else fetch JSON from external file and use those for importing
        if ($filename == "") {
            global $automobile_settings_init;
            $demo_plugin_data = '';
            if (isset($automobile_settings_init) && $automobile_settings_init <> '') {
                $automobile_settings = $automobile_settings_init['plugin_options'];
                $plugin_settings = json_decode($automobile_settings, true);
                $demo_plugin_data = $plugin_settings;
            }
        } else {
            global $wp_filesystem;
            $response = wp_remote_get($filename, array( 'timeout' => 240 ));
            if( is_array($response) ) {
                    $automobile_settings = $response['body']; // use the content
            } else {
                    return false;
            }
            $plugin_settings = json_decode($automobile_settings, true);
            $demo_plugin_data = $plugin_settings;
        }
        delete_option('automobile_var_plugin_options');
        update_option("automobile_var_plugin_options", $demo_plugin_data);

        if (isset($demo_plugin_data['automobile_inventory_cus_fields'])) {

            delete_option('automobile_inventory_cus_fields');
            update_option("automobile_inventory_cus_fields", $demo_plugin_data['automobile_inventory_cus_fields']);
        }
    }

}

/**
 * End Function  for demo data
 */
/**
 * Start Function  that how to take backup deleted files
 */
if (!function_exists('automobile_pl_backup_file_delete')) {

    function automobile_pl_backup_file_delete() {
        global $wp_filesystem, $automobile_var_plugin_static_text;
        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_option_strings();

        $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=automobile_settings');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
            return true;
        }
        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $automobile_upload_dir = automobile_var::plugin_path() . 'admin/settings/backups/';

        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';
        $automobile_filename = trailingslashit($automobile_upload_dir) . $file_name;
        if (is_file($automobile_filename)) {
            unlink($automobile_filename);
            printf(automobile_var_plugin_text_srt('automobile_var_deleted_successfully'), $file_name);
        } else {
            echo automobile_var_plugin_text_srt('automobile_var_error_deleting_file');
        }
        die();
    }

    add_action('wp_ajax_automobile_pl_backup_file_delete', 'automobile_pl_backup_file_delete');
}
/**
 * End Function  that how to take backup deleted files
 */
/**
 * Start Function  for restoreing backup the data
 */











if (!function_exists('automobile_pl_backup_file_restore')) {

    function automobile_pl_backup_file_restore() {
        global $wp_filesystem, $automobile_var_plugin_static_text;

        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_option_strings();

        $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=automobile_settings');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
            return true;
        }
        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $automobile_upload_dir = automobile_var::plugin_path() . 'admin/settings/backups/';
        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';
        $file_path = isset($_POST['file_path']) ? $_POST['file_path'] : '';
        if ($file_path == 'yes') {
            $automobile_file_body = '';
            $automobile_file_response = wp_remote_get($file_name);
            if (is_array($automobile_file_response)) {
                $automobile_file_body = isset($automobile_file_response['body']) ? $automobile_file_response['body'] : '';
            }
            if ($automobile_file_body != '') {
                $get_options_file = json_decode($automobile_file_body, true);
                update_option("automobile_var_plugin_options", $get_options_file);
                if (isset($get_options_file['automobile_inventory_cus_fields'])) {
                    delete_option('automobile_inventory_cus_fields');
                    update_option("automobile_inventory_cus_fields", $get_options_file['automobile_inventory_cus_fields']);
                }
                echo automobile_var_plugin_text_srt('automobile_var_file_import_successfully');
            } else {
                echo automobile_var_plugin_text_srt('automobile_var_error_restoring_file');
            }
            die;
        }
        $automobile_filename = trailingslashit($automobile_upload_dir) . $file_name;
        if (is_file($automobile_filename)) {
            $get_options_file = $wp_filesystem->get_contents($automobile_filename);
            $get_options_file = json_decode($get_options_file, true);
            update_option("automobile_var_plugin_options", $get_options_file);
            if (isset($get_options_file['automobile_inventory_cus_fields'])) {
                delete_option('automobile_inventory_cus_fields');
                update_option("automobile_inventory_cus_fields", $get_options_file['automobile_inventory_cus_fields']);
            }
            printf(automobile_var_plugin_text_srt('automobile_var_restore_successfully'), $file_name);
        } else {
            echo automobile_var_plugin_text_srt('automobile_var_error_restoring_file');
        }
        die();
    }

    add_action('wp_ajax_automobile_pl_backup_file_restore', 'automobile_pl_backup_file_restore');
}
/**
 * End Function  for restoreing backup the data
 */
/**
 * Start Function  for reset all pluging
 */
if (!function_exists('plugin_option_rest_all')) {

    function plugin_option_rest_all() {
        global $wp_filesystem;
        $backup_url = home_url('/');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
            return true;
        }
        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $automobile_upload_dir = automobile_var::plugin_path() . 'admin/settings/default-settings/';
        $automobile_filename = trailingslashit($automobile_upload_dir) . 'default-settings.json';
        if (is_file($automobile_filename)) {
            $get_options_file = $wp_filesystem->get_contents($automobile_filename);
            $get_options_file = json_decode($get_options_file, true);
            update_option("automobile_var_plugin_options", $get_options_file);
        }
        die;
    }

    add_action('wp_ajax_plugin_option_rest_all', 'plugin_option_rest_all');
}
/**
 * end Function  for reset all pluging
 *
 * Start Function  for update package option data
 */
if (!function_exists('automobile_update_packages_options')) {

    function automobile_update_packages_options() {
        $data = get_option("automobile_var_plugin_options");
        $package_counter = 0;
        $package_array = $packages = $packagesdata = array();
        if (isset($_POST['package_id_array']) && !empty($_POST['package_id_array'])) {
            foreach ($_POST['package_id_array'] as $keys => $values) {
                if ($values) {
                    $package_array['package_id'] = $_POST['package_id_array'][$package_counter];
                    $package_array['package_title'] = $_POST['package_title_array'][$package_counter];
                    $package_array['package_price'] = $_POST['package_price_array'][$package_counter];
                    $package_array['package_duration'] = $_POST['package_duration_array'][$package_counter];
                    $package_array['package_duration_period'] = $_POST['package_duration_period_array'][$package_counter];
                    $package_array['package_description'] = $_POST['package_description_array'][$package_counter];
                    $package_array['package_type'] = $_POST['package_type_array'][$package_counter];
                    if (isset($_POST['package_type_array'][$package_counter]) && $_POST['package_type_array'][$package_counter] == 'single') {
                        $package_array['package_listings'] = 1;
                    } else {
                        $package_array['package_listings'] = $_POST['package_listings_array'][$package_counter];
                    }
                    $package_array['package_cvs'] = $_POST['package_cvs_array'][$package_counter];
                    $package_array['package_submission_limit'] = $_POST['package_submission_limit_array'][$package_counter];
                    $package_array['automobile_list_dur'] = $_POST['automobile_list_dur_array'][$package_counter];
                    $package_array['package_feature'] = $_POST['package_feature_array'][$package_counter];
                    $packages[$values] = $package_array;
                    $package_counter++;
                }
            }
        }
        // Update Packages
        $packagesdata['automobile_packages_options'] = $packages;
        $automobile_options = array_merge($data, $packagesdata);
        update_option("automobile_var_plugin_options", $automobile_options);
    }

}
/**
 * end Function  for update package option data
 */
/**
 * Start Function  how to remove html tags
 */
if (!function_exists('stripslashes_htmlspecialchars')) {

    function stripslashes_htmlspecialchars($value) {
        $value = is_array($value) ? array_map('stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
        return $value;
    }

}
/**
 * End Function  how to remove html tags
 */
/**
 * Start Function  how to update Reviews options
 */
if (!function_exists('automobile_update_dyn_reviews')) {

    function automobile_update_dyn_reviews() {
        $data = get_option("automobile_var_plugin_options");
        $dyn_reviews_counter = 0;
        $dyn_reviews_array = $dyn_reviews = $extrasdata = array();
        if (isset($_POST['dyn_reviews_id_array']) && !empty($_POST['dyn_reviews_id_array'])) {
            foreach ($_POST['dyn_reviews_id_array'] as $keys => $values) {
                if ($values) {
                    $dyn_reviews_array['dyn_reviews_id'] = $_POST['dyn_reviews_id_array'][$dyn_reviews_counter];
                    $dyn_reviews_array['automobile_dyn_reviews_title'] = $_POST['automobile_dyn_reviews_title_array'][$dyn_reviews_counter];
                    $dyn_reviews[$values] = $dyn_reviews_array;
                    $dyn_reviews_counter++;
                }
            }
        }
        $extrasdata['automobile_dyn_reviews_options'] = $dyn_reviews;
        $automobile_options = array_merge($data, $extrasdata);
        update_option("automobile_var_plugin_options", $automobile_options);
    }

}
/**
 * End Function  how to update Reviews options
 */
/**
 * Start Function  how to get currency Symbols
 */
if (!function_exists('automobile_get_currency_symbol')) {

    function automobile_get_currency_symbol() {
        $code = $_POST['code'];
        $currency_list = automobile_get_currency();
        echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($currency_list[$code]['symbol']);
        die();
    }

    add_action('wp_ajax_automobile_get_currency_symbol', 'automobile_get_currency_symbol');
}
/**
 * End Function  how to get currency Symbols
 */
/**
 * Start Function  how to get currency List
 */
if (!function_exists('automobile_get_currency')) {

    function automobile_get_currency() {
        return array(
            'USD' => array('numeric_code' => 840, 'code' => 'USD', 'name' => 'United States dollar', 'symbol' => '$', 'fraction_name' => 'Cent[D]', 'decimals' => 2),
            'AED' => array('numeric_code' => 784, 'code' => 'AED', 'name' => 'United Arab Emirates dirham', 'symbol' => 'د.إ', 'fraction_name' => 'Fils', 'decimals' => 2),
            'AFN' => array('numeric_code' => 971, 'code' => 'AFN', 'name' => 'Afghan afghani', 'symbol' => '؋', 'fraction_name' => 'Pul', 'decimals' => 2),
            'ALL' => array('numeric_code' => 8, 'code' => 'ALL', 'name' => 'Albanian lek', 'symbol' => 'L', 'fraction_name' => 'Qintar', 'decimals' => 2),
            'AMD' => array('numeric_code' => 51, 'code' => 'AMD', 'name' => 'Armenian dram', 'symbol' => 'դր.', 'fraction_name' => 'Luma', 'decimals' => 2),
            'AMD' => array('numeric_code' => 51, 'code' => 'AMD', 'name' => 'Armenian dram', 'symbol' => 'դր.', 'fraction_name' => 'Luma', 'decimals' => 2),
            'ANG' => array('numeric_code' => 532, 'code' => 'ANG', 'name' => 'Netherlands Antillean guilder', 'symbol' => 'ƒ', 'fraction_name' => 'Cent', 'decimals' => 2),
            'AOA' => array('numeric_code' => 973, 'code' => 'AOA', 'name' => 'Angolan kwanza', 'symbol' => 'Kz', 'fraction_name' => 'Cêntimo', 'decimals' => 2),
            'ARS' => array('numeric_code' => 32, 'code' => 'ARS', 'name' => 'Argentine peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'AUD' => array('numeric_code' => 36, 'code' => 'AUD', 'name' => 'Australian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'AWG' => array('numeric_code' => 533, 'code' => 'AWG', 'name' => 'Aruban florin', 'symbol' => 'ƒ', 'fraction_name' => 'Cent', 'decimals' => 2),
            'AZN' => array('numeric_code' => 944, 'code' => 'AZN', 'name' => 'Azerbaijani manat', 'symbol' => 'AZN', 'fraction_name' => 'Qəpik', 'decimals' => 2),
            'BAM' => array('numeric_code' => 977, 'code' => 'BAM', 'name' => 'Bosnia and Herzegovina convertible mark', 'symbol' => 'КМ', 'fraction_name' => 'Fening', 'decimals' => 2),
            'BBD' => array('numeric_code' => 52, 'code' => 'BBD', 'name' => 'Barbadian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'BDT' => array('numeric_code' => 50, 'code' => 'BDT', 'name' => 'Bangladeshi taka', 'symbol' => '৳', 'fraction_name' => 'Paisa', 'decimals' => 2),
            'BGN' => array('numeric_code' => 975, 'code' => 'BGN', 'name' => 'Bulgarian lev', 'symbol' => 'лв', 'fraction_name' => 'Stotinka', 'decimals' => 2),
            'BHD' => array('numeric_code' => 48, 'code' => 'BHD', 'name' => 'Bahraini dinar', 'symbol' => 'ب.د', 'fraction_name' => 'Fils', 'decimals' => 3),
            'BIF' => array('numeric_code' => 108, 'code' => 'BIF', 'name' => 'Burundian franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'BMD' => array('numeric_code' => 60, 'code' => 'BMD', 'name' => 'Bermudian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'BND' => array('numeric_code' => 96, 'code' => 'BND', 'name' => 'Brunei dollar', 'symbol' => '$', 'fraction_name' => 'Sen', 'decimals' => 2),
            'BND' => array('numeric_code' => 96, 'code' => 'BND', 'name' => 'Brunei dollar', 'symbol' => '$', 'fraction_name' => 'Sen', 'decimals' => 2),
            'BOB' => array('numeric_code' => 68, 'code' => 'BOB', 'name' => 'Bolivian boliviano', 'symbol' => 'Bs.', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'BRL' => array('numeric_code' => 986, 'code' => 'BRL', 'name' => 'Brazilian real', 'symbol' => 'R$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'BSD' => array('numeric_code' => 44, 'code' => 'BSD', 'name' => 'Bahamian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'BTN' => array('numeric_code' => 64, 'code' => 'BTN', 'name' => 'Bhutanese ngultrum', 'symbol' => 'BTN', 'fraction_name' => 'Chertrum', 'decimals' => 2),
            'BWP' => array('numeric_code' => 72, 'code' => 'BWP', 'name' => 'Botswana pula', 'symbol' => 'P', 'fraction_name' => 'Thebe', 'decimals' => 2),
            'BWP' => array('numeric_code' => 72, 'code' => 'BWP', 'name' => 'Botswana pula', 'symbol' => 'P', 'fraction_name' => 'Thebe', 'decimals' => 2),
            'BYR' => array('numeric_code' => 974, 'code' => 'BYR', 'name' => 'Belarusian ruble', 'symbol' => 'Br', 'fraction_name' => 'Kapyeyka', 'decimals' => 2),
            'BZD' => array('numeric_code' => 84, 'code' => 'BZD', 'name' => 'Belize dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'CAD' => array('numeric_code' => 124, 'code' => 'CAD', 'name' => 'Canadian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'CDF' => array('numeric_code' => 976, 'code' => 'CDF', 'name' => 'Congolese franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'CHF' => array('numeric_code' => 756, 'code' => 'CHF', 'name' => 'Swiss franc', 'symbol' => 'Fr', 'fraction_name' => 'Rappen[I]', 'decimals' => 2),
            'CLP' => array('numeric_code' => 152, 'code' => 'CLP', 'name' => 'Chilean peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'CNY' => array('numeric_code' => 156, 'code' => 'CNY', 'name' => 'Chinese yuan', 'symbol' => '元', 'fraction_name' => 'Fen[E]', 'decimals' => 2),
            'COP' => array('numeric_code' => 170, 'code' => 'COP', 'name' => 'Colombian peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'CRC' => array('numeric_code' => 188, 'code' => 'CRC', 'name' => 'Costa Rican colón', 'symbol' => '₡', 'fraction_name' => 'Céntimo', 'decimals' => 2),
            'CUC' => array('numeric_code' => 931, 'code' => 'CUC', 'name' => 'Cuban convertible peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'CUP' => array('numeric_code' => 192, 'code' => 'CUP', 'name' => 'Cuban peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'CVE' => array('numeric_code' => 132, 'code' => 'CVE', 'name' => 'Cape Verdean escudo', 'symbol' => 'Esc', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'CZK' => array('numeric_code' => 203, 'code' => 'CZK', 'name' => 'Czech koruna', 'symbol' => 'K�?', 'fraction_name' => 'Haléř', 'decimals' => 2),
            'DJF' => array('numeric_code' => 262, 'code' => 'DJF', 'name' => 'Djiboutian franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'DKK' => array('numeric_code' => 208, 'code' => 'DKK', 'name' => 'Danish krone', 'symbol' => 'kr', 'fraction_name' => 'Øre', 'decimals' => 2),
            'DKK' => array('numeric_code' => 208, 'code' => 'DKK', 'name' => 'Danish krone', 'symbol' => 'kr', 'fraction_name' => 'Øre', 'decimals' => 2),
            'DOP' => array('numeric_code' => 214, 'code' => 'DOP', 'name' => 'Dominican peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'DZD' => array('numeric_code' => 12, 'code' => 'DZD', 'name' => 'Algerian dinar', 'symbol' => 'د.ج', 'fraction_name' => 'Centime', 'decimals' => 2),
            'EEK' => array('numeric_code' => 233, 'code' => 'EEK', 'name' => 'Estonian kroon', 'symbol' => 'KR', 'fraction_name' => 'Sent', 'decimals' => 2),
            'EGP' => array('numeric_code' => 818, 'code' => 'EGP', 'name' => 'Egyptian pound', 'symbol' => '£', 'fraction_name' => 'Piastre[F]', 'decimals' => 2),
            'ERN' => array('numeric_code' => 232, 'code' => 'ERN', 'name' => 'Eritrean nakfa', 'symbol' => 'Nfk', 'fraction_name' => 'Cent', 'decimals' => 2),
            'ETB' => array('numeric_code' => 230, 'code' => 'ETB', 'name' => 'Ethiopian birr', 'symbol' => 'ETB', 'fraction_name' => 'Santim', 'decimals' => 2),
            'EUR' => array('numeric_code' => 978, 'code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'fraction_name' => 'Cent', 'decimals' => 2),
            'FJD' => array('numeric_code' => 242, 'code' => 'FJD', 'name' => 'Fijian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'FKP' => array('numeric_code' => 238, 'code' => 'FKP', 'name' => 'Falkland Islands pound', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2),
            'GBP' => array('numeric_code' => 826, 'code' => 'GBP', 'name' => 'British pound[C]', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2),
            'GEL' => array('numeric_code' => 981, 'code' => 'GEL', 'name' => 'Georgian lari', 'symbol' => 'ლ', 'fraction_name' => 'Tetri', 'decimals' => 2),
            'GHS' => array('numeric_code' => 936, 'code' => 'GHS', 'name' => 'Ghanaian cedi', 'symbol' => '₵', 'fraction_name' => 'Pesewa', 'decimals' => 2),
            'GIP' => array('numeric_code' => 292, 'code' => 'GIP', 'name' => 'Gibraltar pound', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2),
            'GMD' => array('numeric_code' => 270, 'code' => 'GMD', 'name' => 'Gambian dalasi', 'symbol' => 'D', 'fraction_name' => 'Butut', 'decimals' => 2),
            'GNF' => array('numeric_code' => 324, 'code' => 'GNF', 'name' => 'Guinean franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'GTQ' => array('numeric_code' => 320, 'code' => 'GTQ', 'name' => 'Guatemalan quetzal', 'symbol' => 'Q', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'GYD' => array('numeric_code' => 328, 'code' => 'GYD', 'name' => 'Guyanese dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'HKD' => array('numeric_code' => 344, 'code' => 'HKD', 'name' => 'Hong Kong dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'HNL' => array('numeric_code' => 340, 'code' => 'HNL', 'name' => 'Honduran lempira', 'symbol' => 'L', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'HRK' => array('numeric_code' => 191, 'code' => 'HRK', 'name' => 'Croatian kuna', 'symbol' => 'kn', 'fraction_name' => 'Lipa', 'decimals' => 2),
            'HTG' => array('numeric_code' => 332, 'code' => 'HTG', 'name' => 'Haitian gourde', 'symbol' => 'G', 'fraction_name' => 'Centime', 'decimals' => 2),
            'HUF' => array('numeric_code' => 348, 'code' => 'HUF', 'name' => 'Hungarian forint', 'symbol' => 'Ft', 'fraction_name' => 'Fillér', 'decimals' => 2),
            'IDR' => array('numeric_code' => 360, 'code' => 'IDR', 'name' => 'Indonesian rupiah', 'symbol' => 'Rp', 'fraction_name' => 'Sen', 'decimals' => 2),
            'ILS' => array('numeric_code' => 376, 'code' => 'ILS', 'name' => 'Israeli new sheqel', 'symbol' => '₪', 'fraction_name' => 'Agora', 'decimals' => 2),
            'INR' => array('numeric_code' => 356, 'code' => 'INR', 'name' => 'Indian rupee', 'symbol' => '₨', 'fraction_name' => 'Paisa', 'decimals' => 2),
            'IQD' => array('numeric_code' => 368, 'code' => 'IQD', 'name' => 'Iraqi dinar', 'symbol' => 'ع.د', 'fraction_name' => 'Fils', 'decimals' => 3),
            'IRR' => array('numeric_code' => 364, 'code' => 'IRR', 'name' => 'Iranian rial', 'symbol' => '﷼', 'fraction_name' => 'Dinar', 'decimals' => 2),
            'ISK' => array('numeric_code' => 352, 'code' => 'ISK', 'name' => 'Icelandic króna', 'symbol' => 'kr', 'fraction_name' => 'Eyrir', 'decimals' => 2),
            'JMD' => array('numeric_code' => 388, 'code' => 'JMD', 'name' => 'Jamaican dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'JOD' => array('numeric_code' => 400, 'code' => 'JOD', 'name' => 'Jordanian dinar', 'symbol' => 'د.ا', 'fraction_name' => 'Piastre[H]', 'decimals' => 2),
            'JPY' => array('numeric_code' => 392, 'code' => 'JPY', 'name' => 'Japanese yen', 'symbol' => '¥', 'fraction_name' => 'Sen[G]', 'decimals' => 2),
            'KES' => array('numeric_code' => 404, 'code' => 'KES', 'name' => 'Kenyan shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2),
            'KGS' => array('numeric_code' => 417, 'code' => 'KGS', 'name' => 'Kyrgyzstani som', 'symbol' => 'KGS', 'fraction_name' => 'Tyiyn', 'decimals' => 2),
            'KHR' => array('numeric_code' => 116, 'code' => 'KHR', 'name' => 'Cambodian riel', 'symbol' => '៛', 'fraction_name' => 'Sen', 'decimals' => 2),
            'KMF' => array('numeric_code' => 174, 'code' => 'KMF', 'name' => 'Comorian franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'KPW' => array('numeric_code' => 408, 'code' => 'KPW', 'name' => 'North Korean won', 'symbol' => '₩', 'fraction_name' => 'Ch�?n', 'decimals' => 2),
            'KRW' => array('numeric_code' => 410, 'code' => 'KRW', 'name' => 'South Korean won', 'symbol' => '₩', 'fraction_name' => 'Jeon', 'decimals' => 2),
            'KWD' => array('numeric_code' => 414, 'code' => 'KWD', 'name' => 'Kuwaiti dinar', 'symbol' => 'د.ك', 'fraction_name' => 'Fils', 'decimals' => 3),
            'KYD' => array('numeric_code' => 136, 'code' => 'KYD', 'name' => 'Cayman Islands dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'KZT' => array('numeric_code' => 398, 'code' => 'KZT', 'name' => 'Kazakhstani tenge', 'symbol' => '〒', 'fraction_name' => 'Tiyn', 'decimals' => 2),
            'LAK' => array('numeric_code' => 418, 'code' => 'LAK', 'name' => 'Lao kip', 'symbol' => '₭', 'fraction_name' => 'Att', 'decimals' => 2),
            'LBP' => array('numeric_code' => 422, 'code' => 'LBP', 'name' => 'Lebanese pound', 'symbol' => 'ل.ل', 'fraction_name' => 'Piastre', 'decimals' => 2),
            'LKR' => array('numeric_code' => 144, 'code' => 'LKR', 'name' => 'Sri Lankan rupee', 'symbol' => 'Rs', 'fraction_name' => 'Cent', 'decimals' => 2),
            'LRD' => array('numeric_code' => 430, 'code' => 'LRD', 'name' => 'Liberian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'LSL' => array('numeric_code' => 426, 'code' => 'LSL', 'name' => 'Lesotho loti', 'symbol' => 'L', 'fraction_name' => 'Sente', 'decimals' => 2),
            'LTL' => array('numeric_code' => 440, 'code' => 'LTL', 'name' => 'Lithuanian litas', 'symbol' => 'Lt', 'fraction_name' => 'Centas', 'decimals' => 2),
            'LVL' => array('numeric_code' => 428, 'code' => 'LVL', 'name' => 'Latvian lats', 'symbol' => 'Ls', 'fraction_name' => 'Santīms', 'decimals' => 2),
            'LYD' => array('numeric_code' => 434, 'code' => 'LYD', 'name' => 'Libyan dinar', 'symbol' => 'ل.د', 'fraction_name' => 'Dirham', 'decimals' => 3),
            'MAD' => array('numeric_code' => 504, 'code' => 'MAD', 'name' => 'Moroccan dirham', 'symbol' => 'Dh', 'fraction_name' => 'Centime', 'decimals' => 2),
            'MDL' => array('numeric_code' => 498, 'code' => 'MDL', 'name' => 'Moldovan leu', 'symbol' => 'L', 'fraction_name' => 'Ban', 'decimals' => 2),
            'MGA' => array('numeric_code' => 969, 'code' => 'MGA', 'name' => 'Malagasy ariary', 'symbol' => 'MGA', 'fraction_name' => 'Iraimbilanja', 'decimals' => 5),
            'MKD' => array('numeric_	code' => 807, 'code' => 'MKD', 'name' => 'Macedonian denar', 'symbol' => 'ден', 'fraction_name' => 'Deni', 'decimals' => 2),
            'MMK' => array('numeric_code' => 104, 'code' => 'MMK', 'name' => 'Myanma kyat', 'symbol' => 'K', 'fraction_name' => 'Pya', 'decimals' => 2),
            'MNT' => array('numeric_code' => 496, 'code' => 'MNT', 'name' => 'Mongolian tögrög', 'symbol' => '₮', 'fraction_name' => 'Möngö', 'decimals' => 2),
            'MOP' => array('numeric_code' => 446, 'code' => 'MOP', 'name' => 'Macanese pataca', 'symbol' => 'P', 'fraction_name' => 'Avo', 'decimals' => 2),
            'MRO' => array('numeric_code' => 478, 'code' => 'MRO', 'name' => 'Mauritanian ouguiya', 'symbol' => 'UM', 'fraction_name' => 'Khoums', 'decimals' => 5),
            'MUR' => array('numeric_code' => 480, 'code' => 'MUR', 'name' => 'Mauritian rupee', 'symbol' => '₨', 'fraction_name' => 'Cent', 'decimals' => 2),
            'MVR' => array('numeric_code' => 462, 'code' => 'MVR', 'name' => 'Maldivian rufiyaa', 'symbol' => 'ރ.', 'fraction_name' => 'Laari', 'decimals' => 2),
            'MWK' => array('numeric_code' => 454, 'code' => 'MWK', 'name' => 'Malawian kwacha', 'symbol' => 'MK', 'fraction_name' => 'Tambala', 'decimals' => 2),
            'MXN' => array('numeric_code' => 484, 'code' => 'MXN', 'name' => 'Mexican peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'MYR' => array('numeric_code' => 458, 'code' => 'MYR', 'name' => 'Malaysian ringgit', 'symbol' => 'RM', 'fraction_name' => 'Sen', 'decimals' => 2),
            'MZN' => array('numeric_code' => 943, 'code' => 'MZN', 'name' => 'Mozambican metical', 'symbol' => 'MTn', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'NAD' => array('numeric_code' => 516, 'code' => 'NAD', 'name' => 'Namibian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'NGN' => array('numeric_code' => 566, 'code' => 'NGN', 'name' => 'Nigerian naira', 'symbol' => '₦', 'fraction_name' => 'Kobo', 'decimals' => 2),
            'NIO' => array('numeric_code' => 558, 'code' => 'NIO', 'name' => 'Nicaraguan córdoba', 'symbol' => 'C$', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'NOK' => array('numeric_code' => 578, 'code' => 'NOK', 'name' => 'Norwegian krone', 'symbol' => 'kr', 'fraction_name' => 'Øre', 'decimals' => 2),
            'NPR' => array('numeric_code' => 524, 'code' => 'NPR', 'name' => 'Nepalese rupee', 'symbol' => '₨', 'fraction_name' => 'Paisa', 'decimals' => 2),
            'NZD' => array('numeric_code' => 554, 'code' => 'NZD', 'name' => 'New Zealand dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'OMR' => array('numeric_code' => 512, 'code' => 'OMR', 'name' => 'Omani rial', 'symbol' => 'ر.ع.', 'fraction_name' => 'Baisa', 'decimals' => 3),
            'PAB' => array('numeric_code' => 590, 'code' => 'PAB', 'name' => 'Panamanian balboa', 'symbol' => 'B/.', 'fraction_name' => 'Centésimo', 'decimals' => 2),
            'PEN' => array('numeric_code' => 604, 'code' => 'PEN', 'name' => 'Peruvian nuevo sol', 'symbol' => 'S/.', 'fraction_name' => 'Céntimo', 'decimals' => 2),
            'PGK' => array('numeric_code' => 598, 'code' => 'PGK', 'name' => 'Papua New Guinean kina', 'symbol' => 'K', 'fraction_name' => 'Toea', 'decimals' => 2),
            'PHP' => array('numeric_code' => 608, 'code' => 'PHP', 'name' => 'Philippine peso', 'symbol' => '₱', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'PKR' => array('numeric_code' => 586, 'code' => 'PKR', 'name' => 'Pakistani rupee', 'symbol' => '₨', 'fraction_name' => 'Paisa', 'decimals' => 2),
            'PLN' => array('numeric_code' => 985, 'code' => 'PLN', 'name' => 'Polish złoty', 'symbol' => 'zł', 'fraction_name' => 'Grosz', 'decimals' => 2),
            'PYG' => array('numeric_code' => 600, 'code' => 'PYG', 'name' => 'Paraguayan guaraní', 'symbol' => '₲', 'fraction_name' => 'Céntimo', 'decimals' => 2),
            'QAR' => array('numeric_code' => 634, 'code' => 'QAR', 'name' => 'Qatari riyal', 'symbol' => 'ر.ق', 'fraction_name' => 'Dirham', 'decimals' => 2),
            'RON' => array('numeric_code' => 946, 'code' => 'RON', 'name' => 'Romanian leu', 'symbol' => 'L', 'fraction_name' => 'Ban', 'decimals' => 2),
            'RSD' => array('numeric_code' => 941, 'code' => 'RSD', 'name' => 'Serbian dinar', 'symbol' => 'дин.', 'fraction_name' => 'Para', 'decimals' => 2),
            'RUB' => array('numeric_code' => 643, 'code' => 'RUB', 'name' => 'Russian ruble', 'symbol' => 'руб.', 'fraction_name' => 'Kopek', 'decimals' => 2),
            'RWF' => array('numeric_code' => 646, 'code' => 'RWF', 'name' => 'Rwandan franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'SAR' => array('numeric_code' => 682, 'code' => 'SAR', 'name' => 'Saudi riyal', 'symbol' => 'ر.س', 'fraction_name' => 'Hallallah', 'decimals' => 2),
            'SBD' => array('numeric_code' => 90, 'code' => 'SBD', 'name' => 'Solomon Islands dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'SCR' => array('numeric_code' => 690, 'code' => 'SCR', 'name' => 'Seychellois rupee', 'symbol' => '₨', 'fraction_name' => 'Cent', 'decimals' => 2),
            'SDG' => array('numeric_code' => 938, 'code' => 'SDG', 'name' => 'Sudanese pound', 'symbol' => '£', 'fraction_name' => 'Piastre', 'decimals' => 2),
            'SEK' => array('numeric_code' => 752, 'code' => 'SEK', 'name' => 'Swedish krona', 'symbol' => 'kr', 'fraction_name' => 'Öre', 'decimals' => 2),
            'SGD' => array('numeric_code' => 702, 'code' => 'SGD', 'name' => 'Singapore dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'SHP' => array('numeric_code' => 654, 'code' => 'SHP', 'name' => 'Saint Helena pound', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2),
            'SLL' => array('numeric_code' => 694, 'code' => 'SLL', 'name' => 'Sierra Leonean leone', 'symbol' => 'Le', 'fraction_name' => 'Cent', 'decimals' => 2),
            'SOS' => array('numeric_code' => 706, 'code' => 'SOS', 'name' => 'Somali shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2),
            'SRD' => array('numeric_code' => 968, 'code' => 'SRD', 'name' => 'Surinamese dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'STD' => array('numeric_code' => 678, 'code' => 'STD', 'name' => 'São Tomé and Príncipe dobra', 'symbol' => 'Db', 'fraction_name' => 'Cêntimo', 'decimals' => 2),
            'SVC' => array('numeric_code' => 222, 'code' => 'SVC', 'name' => 'Salvadoran colón', 'symbol' => '₡', 'fraction_name' => 'Centavo', 'decimals' => 2),
            'SYP' => array('numeric_code' => 760, 'code' => 'SYP', 'name' => 'Syrian pound', 'symbol' => '£', 'fraction_name' => 'Piastre', 'decimals' => 2),
            'SZL' => array('numeric_code' => 748, 'code' => 'SZL', 'name' => 'Swazi lilangeni', 'symbol' => 'L', 'fraction_name' => 'Cent', 'decimals' => 2),
            'THB' => array('numeric_code' => 764, 'code' => 'THB', 'name' => 'Thai baht', 'symbol' => '฿', 'fraction_name' => 'Satang', 'decimals' => 2),
            'TJS' => array('numeric_code' => 972, 'code' => 'TJS', 'name' => 'Tajikistani somoni', 'symbol' => 'ЅМ', 'fraction_name' => 'Diram', 'decimals' => 2),
            'TMM' => array('numeric_code' => 0, 'code' => 'TMM', 'name' => 'Turkmenistani manat', 'symbol' => 'm', 'fraction_name' => 'Tennesi', 'decimals' => 2),
            'TND' => array('numeric_code' => 788, 'code' => 'TND', 'name' => 'Tunisian dinar', 'symbol' => 'د.ت', 'fraction_name' => 'Millime', 'decimals' => 3),
            'TOP' => array('numeric_code' => 776, 'code' => 'TOP', 'name' => 'Tongan paʻanga', 'symbol' => 'T$', 'fraction_name' => 'Seniti[J]', 'decimals' => 2),
            'TRY' => array('numeric_code' => 949, 'code' => 'TRY', 'name' => 'Turkish lira', 'symbol' => 'TL', 'fraction_name' => 'Kuruş', 'decimals' => 2),
            'TTD' => array('numeric_code' => 780, 'code' => 'TTD', 'name' => 'Trinidad and Tobago dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'TWD' => array('numeric_code' => 901, 'code' => 'TWD', 'name' => 'New Taiwan dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'TZS' => array('numeric_code' => 834, 'code' => 'TZS', 'name' => 'Tanzanian shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2),
            'UAH' => array('numeric_code' => 980, 'code' => 'UAH', 'name' => 'Ukrainian hryvnia', 'symbol' => '₴', 'fraction_name' => 'Kopiyka', 'decimals' => 2),
            'UGX' => array('numeric_code' => 800, 'code' => 'UGX', 'name' => 'Ugandan shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2),
            'UYU' => array('numeric_code' => 858, 'code' => 'UYU', 'name' => 'Uruguayan peso', 'symbol' => '$', 'fraction_name' => 'Centésimo', 'decimals' => 2),
            'UZS' => array('numeric_code' => 860, 'code' => 'UZS', 'name' => 'Uzbekistani som', 'symbol' => 'UZS', 'fraction_name' => 'Tiyin', 'decimals' => 2),
            'VEF' => array('numeric_code' => 937, 'code' => 'VEF', 'name' => 'Venezuelan bolívar', 'symbol' => 'Bs F', 'fraction_name' => 'Céntimo', 'decimals' => 2),
            'VND' => array('numeric_code' => 704, 'code' => 'VND', 'name' => 'Vietnamese đồng', 'symbol' => '₫', 'fraction_name' => 'Hào[K]', 'decimals' => 10),
            'VUV' => array('numeric_code' => 548, 'code' => 'VUV', 'name' => 'Vanuatu vatu', 'symbol' => 'Vt', 'fraction_name' => 'None', 'decimals' => NULL),
            'WST' => array('numeric_code' => 882, 'code' => 'WST', 'name' => 'Samoan tala', 'symbol' => 'T', 'fraction_name' => 'Sene', 'decimals' => 2),
            'XAF' => array('numeric_code' => 950, 'code' => 'XAF', 'name' => 'Central African CFA franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'XCD' => array('numeric_code' => 951, 'code' => 'XCD', 'name' => 'East Caribbean dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
            'XOF' => array('numeric_code' => 952, 'code' => 'XOF', 'name' => 'West African CFA franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'XPF' => array('numeric_code' => 953, 'code' => 'XPF', 'name' => 'CFP franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2),
            'YER' => array('numeric_code' => 886, 'code' => 'YER', 'name' => 'Yemeni rial', 'symbol' => '﷼', 'fraction_name' => 'Fils', 'decimals' => 2),
            'ZAR' => array('numeric_code' => 710, 'code' => 'ZAR', 'name' => 'South African rand', 'symbol' => 'R', 'fraction_name' => 'Cent', 'decimals' => 2),
            'ZMK' => array('numeric_code' => 894, 'code' => 'ZMK', 'name' => 'Zambian kwacha', 'symbol' => 'ZK', 'fraction_name' => 'Ngwee', 'decimals' => 2),
            'ZWR' => array('numeric_code' => 0, 'code' => 'ZWR', 'name' => 'Zimbabwean dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2),
        );
    }

}
/**
 * End Function how to get currency Symbols
 */
?>