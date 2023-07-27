<?php

if (!function_exists('automobile_frame_option_save')) {

    function automobile_frame_option_save() {
		global $automobile_var_frame_static_text,$automobile_var_frame_options;
        if (isset($_REQUEST['automobile_frame_option_saving'])) {
            
            $_POST = automobile_var_stripslashes_htmlspecialchars($_POST);
            update_option("automobile_var_frame_options", $_POST);
            echo automobile_var_frame_text_srt('automobile_var_maintenance_save_message');
        }
        die();
    }

    add_action('wp_ajax_automobile_frame_option_save', 'automobile_frame_option_save');
}