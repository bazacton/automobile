<?php
/**
 * @Add Meta Box For Candidate Post
 * @return
 *
 */
/**
 * Start How to Add Profile Setting in User
 */
if (!function_exists('automobile_user_profile_setting')) {

    function automobile_user_profile_setting($user) {
        global $post, $automobile_form_fields, $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_options, $automobile_var_plugin_static_text;
        $automobile_html_fields->automobile_heading_render(
                array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_profile_settings'),
                    'id' => 'profile_setting',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => ''
                )
        );
        $automobile_opt_array = array(
            'std' => '',
            'user' => $user,
            'id' => 'user_img',
            'name' => automobile_var_plugin_text_srt('automobile_var_profile_image'),
            'desc' => '',
            'dp' => true,
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'dp' => true,
                'id' => 'user_img',
                'classes' => 'left cs-uploadimg upload',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_custom_upload_file_field($automobile_opt_array);

        $automobile_opt_array = array(
            'std' => '',
            'user' => $user,
            'std' => '',
            'id' => 'cover_user_img',
            'name' => automobile_var_plugin_text_srt('automobile_var_cover_image'),
            'desc' => '',
            'dp' => true,
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'dp' => true,
                'id' => 'cover_user_img',
                'classes' => 'left cs-cover-uploadimg upload',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_custom_upload_file_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_inventory_title'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'inventory_title',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_text_field($automobile_opt_array);

        $user_status = array();
        $user_status = array(
            'active' => automobile_var_plugin_text_srt('automobile_var_active'),
            'inactive' => automobile_var_plugin_text_srt('automobile_var_inactive'),
        );
        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_profile_status'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'user_status',
                'classes' => 'chosen-select-no-single',
                'options' => $user_status,
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_select_field($automobile_opt_array);
        $allow_search = array();
        $allow_search = array(
            'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
            'no' => automobile_var_plugin_text_srt('automobile_var_no')
        );

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_allow_in_search'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'allow_search',
                'classes' => 'chosen-select-no-single',
                'options' => $allow_search,
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_select_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_minimum_salary'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'minimum_salary',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_text_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_last_activity'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'id' => 'user_last_activity_date',
                'format' => 'd-m-Y H:i:s',
                'disabled' => 'yes',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_date_field($automobile_opt_array);

        $automobile_html_fields->automobile_heading_render(
                array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_social_networks'),
                    'id' => 'social_network',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => ''
                )
        );

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_facebook'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'facebook',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_text_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_twitter'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'twitter',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_text_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_linkedin'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'linkedin',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_text_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_google_plus'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'google_plus',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_text_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_plugin_text_srt('automobile_var_phone_no'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'phone_number',
                'return' => true,
            ),
        );
        $automobile_html_fields->automobile_text_field($automobile_opt_array);

        $automobile_html_fields->automobile_heading_render(
                array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_mailing_information'),
                    'id' => 'mailing_information',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => ''
                )
        );

        AUTOMOBILE_FUNCTIONS()->automobile_location_fields($user);
    }

}