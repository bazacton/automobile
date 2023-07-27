<?php
global $automobile_settings_init;

require_once ABSPATH . '/wp-admin/includes/file.php';

// Home Demo
$automobile_demo = automobile_get_settings_demo('demo.json');

$automobile_settings_init = array(
	"plugin_options" => $automobile_demo,
);