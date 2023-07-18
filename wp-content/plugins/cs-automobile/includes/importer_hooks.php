<?php

add_action('automobile_import_users', 'automobile_import_users_handle');
if (!function_exists('automobile_import_users_handle')) {

    function automobile_import_users_handle($obj) {
	if (class_exists('automobile_user_import')) {
	    //ob_start();
	    $automobile_user_import = new automobile_user_import();
	    $return = $automobile_user_import->automobile_import_user_demodata(false, false, false, $obj->users_data_path);
	    //ob_end_clean();
	    $obj->action_return = is_null($return) ? true : $return;
	} else {
	    $obj->action_return = false;
	}
    }

}

add_action('automobile_import_plugin_options', 'automobile_import_plugin_options_handle');
if (!function_exists('automobile_import_plugin_options_handle')) {

    function automobile_import_plugin_options_handle($obj) {
	if (function_exists('automobile_demo_plugin_data')) {
	    $return = automobile_demo_plugin_data($obj->plugins_data_path);
	    $obj->action_return = is_null($return) ? true : $return;
	} else {
	    $obj->action_return = false;
	}
    }

}