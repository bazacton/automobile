<?php
/**
 * @Add Meta Box For Dealer Post
 * @return
 *
 */
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

if (!function_exists('automobile_user_edit_form_multipart_encoding')) {

    function automobile_user_edit_form_multipart_encoding() {

        echo ' enctype="multipart/form-data"';
    }

}

add_action('user_edit_form_tag', 'automobile_user_edit_form_multipart_encoding');

if (!function_exists('extra_user_profile_fields')) {

    function extra_user_profile_fields($user) {
        global $post, $automobile_form_fields, $automobile_html_fields, $automobile_plugin_options, $automobile_var_plugin_static_text;
        $automobile_plugin_options = get_option('automobile_plugin_options');
        $automobile_award_switch = isset( $automobile_plugin_options['automobile_award_switch'] )? $automobile_plugin_options['automobile_award_switch'] : '';
        $automobile_portfolio_switch = isset( $automobile_plugin_options['automobile_portfolio_switch'] )? $automobile_plugin_options['automobile_portfolio_switch'] : '';
        $automobile_skills_switch = isset( $automobile_plugin_options['automobile_skills_switch'] )? $automobile_plugin_options['automobile_skills_switch'] : '';
        $automobile_education_switch = isset( $automobile_plugin_options['automobile_education_switch'] )? $automobile_plugin_options['automobile_education_switch'] : '';
        $automobile_experience_switch = isset( $automobile_plugin_options['automobile_experience_switch'] )? $automobile_plugin_options['automobile_experience_switch'] : '';
        ?>


        <table class="form-table">
            <tr>
                <th><label for="dealer_type"><?php echo automobile_var_plugin_text_srt('automobile_var_dealer_type'); ?></label></th>
                <td>
                    <?php
                    /* Make sure the user can assign terms of the dealer type taxonomy before proceeding. */
                    $country_args = array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'fields' => 'all',
                        'slug' => '',
                        'hide_empty' => false,
                    );
                    $terms = get_terms('dealer_type', $country_args);
                    // If there are any specialism terms, loop through them and display checkboxes.
                    if (!empty($terms)) {
                        $dealer_type_options = array();
                        foreach ($terms as $term) {
                            $dealer_type_options[esc_attr($term->slug)] = $term->name;
                        }
                        $automobile_opt_array = array(
                            'usermeta' => true,
                            'user' => $user,
                            'std' => '',
                            'id' => 'dealer_type',
                            'classes' => 'chosen-select',
                            'options' => $dealer_type_options,
                        );
                        $automobile_form_fields->automobile_form_multiselect_render($automobile_opt_array);
                    } else {
                        // If there are no dealer type terms, display a message.
                        echo automobile_var_plugin_text_srt('automobile_var_no_dealer');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th><label for="user_status"><?php echo automobile_var_plugin_text_srt('automobile_var_profile_approved'); ?></label></th>
                <td><?php
                    $user_status = array();
                    $user_status = array(
                        '1' => 'Approved',
                        '0' => 'Pending',
                    );
                    $automobile_opt_array = array(
                        'std' => isset($user->user_status) ? $user->user_status : '',
                        'id' => '',
                        'cust_id' => 'profile_approved',
                        'cust_name' => 'profile_approved',
                        'classes' => 'chosen-select-no-single small',
                        'options' => $user_status,
                    );
                    $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
                    ?></td>
            </tr>
        </table> 


        <?php
        $user_roles = isset($user->roles) ? $user->roles : '';
        $automobile_dealer_role = false;
        if (($user_roles != '' && in_array("automobile_dealer", $user_roles)) || ($user_roles != '' && in_array("automobile_dealer", $user_roles))) {
            $automobile_dealer_role = true;
        }
        $custom_field = '';
        if ($automobile_dealer_role == false) {
            $custom_field = 'display:none;';
        }
        ?>
        <!-- Tab panes -->
        <div class="cs-user-customfield-block" style="<?php echo $custom_field; ?>;overflow:hidden; position:relative; ">
            <h3><?php echo automobile_var_plugin_text_srt('automobile_var_extra_profile_information') ?></h3>
            <div class="page-wrap page-opts left" >
                <div class="option-sec">
                    <div class="opt-conts">
                        <div class="elementhidden">
                            <nav class="admin-navigtion">
                                <ul id="cs-options-tab">
                                    <li><a name="#tab-profile-settings" href="javascript:;"><i class="icon-user9"></i><?php echo automobile_var_plugin_text_srt('automobile_var_my_profile'); ?></a></li>
                                    <li class="cs-gallery-fields"><a name="#tab-gallery" href="javascript:;"><i class="icon-list-alt"></i><?php echo automobile_var_plugin_text_srt('automobile_var_gallery'); ?> </a></li>
                                    <!-- dealer tabs -->
                                    <li class="cs-dealer-fields"><a name="#tab-dealer-custom-fields" href="javascript:void(0);"><i class="icon-list-alt"></i><?php echo automobile_var_plugin_text_srt('automobile_var_dealer_custom_fields'); ?></a></li>
                                </ul>
                            </nav>
                            <div id="tabbed-content">
                                <div id="tab-profile-settings">
                                    <?php automobile_user_profile_setting($user); ?>
                                </div>
                                <div class="cs-gallery-fields" id="tab-gallery">

                                    <div class="theme-help">
                                        <h4>
                                            <?php echo automobile_var_plugin_text_srt('automobile_var_gallery'); ?>
                                        </h4>
                                        <div class="clear"></div>
                                    </div>
                                    <?php automobile_gallery_fields($user); ?>
                                </div>
                                <!-- dealer tabbing content -->

                                <div class="cs-dealer-fields" id="tab-dealer-custom-fields">
                                    <div class="theme-help">
                                        <h4><?php echo automobile_var_plugin_text_srt('automobile_var_dealer_custom_fields'); ?></h4>
                                        <div class="clear"></div>
                                    </div>
                                    <?php automobile_dealer_profile_custom_fields($user); ?>
                                </div>
                                <!-- end dealer tabbing content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <!-- End extra fields for user profile tabbing -->

        <?php
    }

}
add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

if (!function_exists('save_extra_user_profile_fields')) {

    function save_extra_user_profile_fields($user_id) {
        global $wpdb;
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        $data = array();
        foreach ($_POST as $key => $value) {
            if (strstr($key, 'automobile_')) {
                if ($key == 'automobile_transaction_expiry_date' || $key == 'automobile_inventory_expired' || $key == 'automobile_inventory_posted' || $key == 'automobile_user_last_activity_date') {
                    if ($value == '' || $key == 'automobile_user_last_activity_date') {
                        $value = date('d-m-Y H:i:s');
                    }
                    $data[$key] = strtotime($value);
                    update_user_meta($user_id, $key, strtotime($value));
                } else {
                    if ($key == 'automobile_cus_field') {
                        if (is_array($value) && sizeof($value) > 0) {
                            foreach ($value as $c_key => $c_val) {
                                update_user_meta($user_id, $c_key, $c_val);
                            }
                        }
                    } else {
                        $data[$key] = $value;
                        update_user_meta($user_id, $key, $value);
                    }
                }

                if ($key == 'automobile_opening_hours') {
                    $today = '';
                    $day = date("l");

                    if (is_array($value) && sizeof($value) > 0) {
                        foreach ($value as $c_key => $c_val) {

                            update_user_meta($user_id, $c_key, $c_val);
                        }
                    }
                }
            }
            if ($key == 'user_img') {
				update_user_meta($user_id, $key, automobile_save_img_url($value));
            }

            //change user status
            if ($key == 'profile_approved') {
                $wpdb->update(
                        $wpdb->prefix . 'users', array('user_status' => $value), array('ID' => esc_sql($user_id))
                );
            }
        }

        $automobile_media_image = automobile_user_avatar('automobile_user_img_media');
		
        if ($automobile_media_image == '') {
            $automobile_media_image = $_POST['user_img'];
		} else {
			$automobile_prev_img = get_user_meta($user_id, 'user_img', true);
            automobile_remove_img_url($automobile_prev_img);
        }
		
        update_user_meta($user_id, 'user_img', $automobile_media_image);
		
        if (isset($_FILES['automobile_gallery_user_img_media']) && !empty($_FILES['automobile_gallery_user_img_media'])) {
            $gallery_media_upload = user_gallery_multiple('automobile_gallery_user_img_media');

            $gallery_media_val = isset($_POST['gallery_user_img']) ? $_POST['gallery_user_img'] : '';
            $gallery_media_val = user_gallery_decoder($gallery_media_val);

            if (is_array($gallery_media_val) && sizeof($gallery_media_val) > 0) {
                $gallery_media_upload = array_merge($gallery_media_val, $gallery_media_upload);
            }
            update_user_meta($user_id, 'gallery_user_img', $gallery_media_upload);
        } else {
            $gallery_media_upload = isset($_POST['gallery_user_img']) ? $_POST['gallery_user_img'] : '';
            $gallery_media_val = user_gallery_decoder($gallery_media_upload);
            update_user_meta($user_id, 'gallery_user_img', $gallery_media_val);
        }
        update_user_meta($user_id, 'automobile_array_data', $data);
    }

}
/**
 * Start How to Add Profile Setting in User
 */
if (!function_exists('automobile_user_profile_setting')) {

    function automobile_user_profile_setting($user) {
        global $post, $automobile_form_fields, $automobile_html_fields, $automobile_plugin_options, $automobile_var_plugin_core, $automobile_var_plugin_static_text;

        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_option_strings();

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
            'hint_text' => automobile_var_plugin_text_srt('automobile_var_profile_image_hint'),
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
            'no' => automobile_var_plugin_text_srt('automobile_var_no'),
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
            'name' => automobile_var_plugin_text_srt('automobile_var_last_activity'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'id' => 'user_last_activity_date',
                'format' => 'd-m-Y H:i:s',
                'disabled' => '',
                'strtotime' => true,
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_date_field($automobile_opt_array);
        $automobile_html_fields->automobile_heading_render(
                array(
                    'name' => automobile_var_plugin_text_srt('automobile_var_opening_hours'),
                    'id' => 'opening_hours',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => ''
                )
        );
        ?> 

        <ul class="form-elements">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <li class="to-label"><label><?php echo automobile_var_plugin_text_srt('automobile_var_opening_hours'); ?></label></li>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <li class="cs-opening-hours">
                    <table class="user-openings">
                        <thead>
                            <tr>
                                <th><?php echo automobile_var_plugin_text_srt('automobile_var_day_name'); ?></th>
                                <th><?php echo automobile_var_plugin_text_srt('automobile_var_start_time'); ?></th>
                                <th><?php echo automobile_var_plugin_text_srt('automobile_var_end_time'); ?></th>
                            </tr>
                        </thead>
                        <?php
                        if (function_exists('automobile_post_openinghours')) {
                            automobile_post_openinghours($user->ID);
                        }
                        ?>
                    </table>
                </li>
            </div>
        </ul>
        <?php
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

        /* $automobile_opt_array = array(
          'name' => automobile_var_plugin_text_srt('automobile_var_mobile_no'),
          'desc' => '',
          'hint_text' => '',
          'echo' => true,
          'field_params' => array(
          'usermeta' => true,
          'user' => $user,
          'std' => '',
          'id' => 'mobile_number',
          'return' => true,
          ),
          );
          $automobile_html_fields->automobile_text_field($automobile_opt_array);

          $automobile_opt_array = array(
          'name' => automobile_var_plugin_text_srt('automobile_var_fax_no'),
          'desc' => '',
          'hint_text' => '',
          'echo' => true,
          'field_params' => array(
          'usermeta' => true,
          'user' => $user,
          'std' => '',
          'id' => 'fax_number',
          'return' => true,
          ),
          );
          $automobile_html_fields->automobile_text_field($automobile_opt_array);


          $automobile_opt_array = array(
          'name' => automobile_var_plugin_text_srt('automobile_var_alternate_no'),
          'desc' => '',
          'hint_text' => '',
          'echo' => true,
          'field_params' => array(
          'usermeta' => true,
          'user' => $user,
          'std' => '',
          'id' => 'alternate_number',
          'return' => true,
          ),
          );
          $automobile_html_fields->automobile_text_field($automobile_opt_array);
         */

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

        $automobile_var_plugin_core->automobile_location_fields($user);
    }

}

/**
 * Start How to create Gallery Custom Fields
 */
if (!function_exists('automobile_gallery_fields')) {

    function automobile_gallery_fields($user) {

        global $post, $automobile_form_fields, $automobile_html_fields, $automobile_plugin_options, $automobile_var_plugin_static_text;

        $automobile_opt_array = array(
            'std' => '',
            'user' => $user,
            'id' => 'gallery_user_img',
            'name' => automobile_var_plugin_text_srt('automobile_var_gallery_image'),
            'desc' => '',
            'hint_text' => automobile_var_plugin_text_srt('automobile_var_profile_image_hint'),
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'std' => '',
                'id' => 'gallery_user_img',
                'return' => true,
            ),
        );
        $automobile_html_fields->automobile_multiple_custom_upload_file_field($automobile_opt_array);

        $automobile_opt_array = array(
            'name' => '',
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'usermeta' => true,
                'user' => $user,
                'cust_type' => 'button',
                'std' => automobile_var_plugin_text_srt('automobile_var_add_more'),
                'id' => 'button_add',
                'extra_atr' => 'onclick="javascript:;"',
                'return' => true,
            ),
        );

        $automobile_html_fields->automobile_text_field($automobile_opt_array);
    }

}





/**
 * Start Function How to create Dealer Custiom Fields
 */
if (!function_exists('automobile_dealer_profile_custom_fields')) {

    function automobile_dealer_profile_custom_fields($user) {
        global $automobile_form_fields, $automobile_html_fields;
        $automobile_dealer_cus_fields = get_option("automobile_dealer_cus_fields");
        if (is_array($automobile_dealer_cus_fields) && sizeof($automobile_dealer_cus_fields) > 0) {
            foreach ($automobile_dealer_cus_fields as $cus_field) {
                $automobile_type = isset($cus_field['type']) ? $cus_field['type'] : '';
                switch ($automobile_type) {
                    case('text'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $automobile_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        }
                        break;
                    case('textarea'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $automobile_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $automobile_html_fields->automobile_textarea_field($automobile_opt_array);
                        }
                        break;
                    case('dropdown'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $automobile_options = array();
                            if (isset($cus_field['options']['value']) && is_array($cus_field['options']['value']) && sizeof($cus_field['options']['value']) > 0) {
                                if (isset($cus_field['first_value']) && $cus_field['first_value'] != '') {
                                    $automobile_options[''] = $cus_field['first_value'];
                                }
                                $automobile_opt_counter = 0;
                                foreach ($cus_field['options']['value'] as $automobile_option) {

                                    $automobile_opt_label = $cus_field['options']['label'][$automobile_opt_counter];
                                    $automobile_options[$automobile_option] = $automobile_opt_label;
                                    $automobile_opt_counter++;
                                }
                            }

                            $automobile_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'options' => $automobile_options,
                                    'cus_field' => true,
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'return' => true,
                                ),
                            );

                            if (isset($cus_field['post_multi']) && $cus_field['post_multi'] == 'yes') {
                                $automobile_opt_array['multi'] = true;
                            }

                            $automobile_html_fields->automobile_select_field($automobile_opt_array);
                        }
                        break;
                    case('date'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $automobile_format = isset($cus_field['date_format']) && $cus_field['date_format'] != '' ? $cus_field['date_format'] : 'd-m-Y';

                            $automobile_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'format' => $automobile_format,
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $automobile_html_fields->automobile_date_field($automobile_opt_array);
                        }
                        break;
                    case('email'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $automobile_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        }
                        break;
                    case('url'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {

                            $automobile_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        }
                        break;
                    case('range'):
                        if (isset($cus_field['meta_key']) && $cus_field['meta_key'] != '') {
                            $automobile_opt_array = array(
                                'name' => isset($cus_field['label']) ? $cus_field['label'] : '',
                                'desc' => '',
                                'hint_text' => isset($cus_field['help']) ? $cus_field['help'] : '',
                                'echo' => true,
                                'field_params' => array(
                                    'usermeta' => true,
                                    'user' => $user,
                                    'std' => isset($cus_field['default_value']) ? $cus_field['default_value'] : '',
                                    'id' => $cus_field['meta_key'],
                                    'cus_field' => true,
                                    'return' => true,
                                ),
                            );

                            $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        }
                        break;
                }
            }
        }
    }

}

/**
 * Start Function Post Opening Hours
 */
if (!function_exists('automobile_post_openinghours')) {

    function automobile_post_openinghours($user_id = '') {
        global $automobile_xmlObject, $current_user, $user, $automobile_var_plugin_static_text;

        $opning_hours = get_user_meta($user_id, 'automobile_opening_hours', true);
        $weekdays = array(
            "Sun" => automobile_var_plugin_text_srt('automobile_var_sunday'),
            "Mon" => automobile_var_plugin_text_srt('automobile_var_monday'),
            "Tue" => automobile_var_plugin_text_srt('automobile_var_tuesday'),
            "Wed" => automobile_var_plugin_text_srt('automobile_var_wednesday'),
            "Thu" => automobile_var_plugin_text_srt('automobile_var_thursday'),
            "Fri" => automobile_var_plugin_text_srt('automobile_var_friday'),
            "Sat" => automobile_var_plugin_text_srt('automobile_var_saturday'),
        );
        $weekday_fields = array();

        foreach ($weekdays as $key => $value) {
            $weekday_fields[$key] = array(
                'openhours_' . $key . '_text' => array(
                    'name' => 'openhours_' . $key . '_text',
                    'type' => 'text',
                    'title' => $value,
                    'class' => '',
                    'description' => '',
                    'default' => $value,
                ),
                'openhours_' . $key . '_start' => array(
                    'name' => 'openhours_' . $key . '_start',
                    'type' => 'text',
                    'class' => 'openhours-time',
                    'title' => 'Start Time',
                    'description' => '',
                    'default' => '',
                ),
                'openhours_' . $key . '_end' => array(
                    'name' => 'openhours_' . $key . '_end',
                    'type' => 'text',
                    'class' => 'openhours-time',
                    'title' => 'End Time',
                    'description' => '',
                    'default' => '',
                )
            );
        }

        $dynamic_post_other_options['openinghours'] = array(
            'title' => automobile_var_plugin_text_srt('automobile_var_opening_hours'),
            'id' => 'openinghour-meta-option',
            'notes' => automobile_var_plugin_text_srt('automobile_var_opening_hours'),
            'params' => $weekday_fields
        );
        $output = '';

        foreach ($dynamic_post_other_options['openinghours']['params'] as $params) {
            $output .= '<tr>';
            if (is_array($params)) {
                foreach ($params as $key => $param) {
                    if (isset($opning_hours[$key])) {
                        $value = $opning_hours[$key];
                    } else {
                        $value = $param['default'];
                    }
                    switch ($param['type']) {
                        case 'text' :
                            $output .= '
                            <td>
                                <input type="text" name="automobile_opening_hours[' . $key . ']" value="' . $value . '" class="' . sanitize_html_class($param['class']) . '" />
                            </td>';

                            break;
                    }
                }
            }
            $output .= '</tr>';
        }
        echo balanceTags($output, true);
    }

}