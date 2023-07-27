<?php

$var_arrays = array('automobile_var_home', 'automobile_var_demo');
$theme_option_array_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($theme_option_array_global_vars);

$home_demo = automobile_var_get_demo_content('home.json');

$automobile_page_option[] = array();
$automobile_page_option['theme_options'] = array(
    'select' => array(
        'home' => isset($automobile_var_home) ? $automobile_var_home : '',
    ),
    'home' => array(
        'name' => isset($automobile_var_demo) ? $automobile_var_demo : '',
        'page_slug' => 'home',
        'theme_option' => $home_demo,
        'thumb' => 'Import-Dummy-Data'
    ),
);
?>