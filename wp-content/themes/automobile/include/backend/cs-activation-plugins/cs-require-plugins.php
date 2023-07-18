<?php

/*
 * tgm class for 
 * (internal and WordPress repository) 
 * plugin activation start
 */

automobile_include_file(trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/class-tgm-plugin-activation.php');
if (!function_exists('automobile_var_register_required_plugins')) {
    add_action('tgmpa_register', 'automobile_var_register_required_plugins');

    function automobile_var_register_required_plugins() {
        global $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_plugin_activation_strings();


        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */

        $plugins = array(
            /*
             * This is an example of how to include a plugin from the WordPress Plugin Repository.
             */
            array(
                'name' => automobile_var_theme_text_srt('automobile_var_theme_option_revolution_slider'),
                'slug' => 'revslider',
                'source' => 'http://chimpgroup.com/wp-demo/download-plugin/revslider.zip',
                'required' => false,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => automobile_var_theme_text_srt('automobile_var_framework'),
                'slug' => 'cs-automobile-framework',
                'source' => trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/cs-automobile-framework.zip',
                'required' => false,
                'version' => '1.0',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => 'CS automobile',
                'slug' => 'cs-automobile',
                'source' => trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/cs-automobile.zip',
                'required' => false,
                'version' => '1.1',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => 'Loco translate',
                'slug' => 'loco-translate',
                'required' => false,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
        );

        /*
         * Change this to your theme text domain, used for internationalising strings
         */
        $theme_text_domain = 'automobile';
        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
            'domain' => 'automobile', /* Text domain - likely want to be the same as your theme. */
            'default_path' => '', /* Default absolute path to pre-packaged plugins */
            'parent_slug' => 'themes.php', /* Default parent menu slug */
            //'parent_menu_slug' => 'themes.php', /* Default parent menu slug */
            //'parent_url_slug' => 'themes.php', /* Default parent URL slug */
            'menu' => 'install-required-plugins', /* Menu slug */
            'has_notices' => true, /* Show admin notices or not */
            'is_automatic' => true, /* Automatically activate plugins after installation or not */
            'message' => '', /* Message to output right before the plugins table */
            'strings' => array(
                'page_title' => automobile_var_theme_text_srt('automobile_var_install_require_plugins'),
                'menu_title' => automobile_var_theme_text_srt('automobile_var_install_plugins'),
                'installing' => automobile_var_theme_text_srt('automobile_var_installing_plugins'), /* %1$s = plugin name */
                'oops' => automobile_var_theme_text_srt('automobile_var_wrong'),
                'notice_can_install_required' => automobile_var_theme_text_srt('automobile_var_notice_can_install_required'), /* %1$s = plugin name(s) */
                'notice_can_install_recommended' => automobile_var_theme_text_srt('automobile_var_notice_can_install_recommended'), /* %1$s = plugin name(s) */
                'notice_cannot_install' => automobile_var_theme_text_srt('automobile_var_sorry'), /* %1$s = plugin name(s) */
                'notice_can_activate_required' => automobile_var_theme_text_srt('automobile_var_notice_can_activate_required'), /* %1$s = plugin name(s) */
                'notice_can_activate_recommended' => automobile_var_theme_text_srt('automobile_var_notice_can_activate_recommended'), /* %1$s = plugin name(s) */
                'notice_cannot_activate' => automobile_var_theme_text_srt('automobile_var_sorry_not_permission'), /* %1$s = plugin name(s) */
                'notice_ask_to_update' => automobile_var_theme_text_srt('automobile_var_notice_can_activate_recommended'), /* %1$s = plugin name(s) */
                'notice_cannot_update' => automobile_var_theme_text_srt('automobile_var_sorry_updated'), /* %1$s = plugin name(s) */
                'install_link' => automobile_var_theme_text_srt('automobile_var_install_link'),
                'activate_link' => automobile_var_theme_text_srt('automobile_var_activate_installed'),
                'return' => automobile_var_theme_text_srt('automobile_var_return'),
                'plugin_activated' => automobile_var_theme_text_srt('automobile_var_activation_success'),
                'complete' => automobile_var_theme_text_srt('automobile_var_complete'), /* %1$s = dashboard link */
                'nag_type' => automobile_var_theme_text_srt('automobile_var_updated'), /* Determines admin notice type - can only be 'updated' or 'error' */
            )
        );
        tgmpa($plugins, $config);
    }

}