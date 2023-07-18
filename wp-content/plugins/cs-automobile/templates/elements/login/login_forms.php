<?php
//=====================================================================
// Sign In With Social Media
//=====================================================================

if (!function_exists('automobile_var_page_builder_register')) {

    function automobile_var_page_builder_register($die = 0) {

        global $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'automobile_register';
        $counter = $_POST['counter'];

        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $parseObject = new ShortcodeParse();
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'automobile_var_register_title' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content'])) {
            $atts_content = $output['0']['content'];
        } else {
            $atts_content = array();
        }
        $button_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_register';

        $coloumn_class = 'column_' . $button_element_size;

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }

        $rand_id = rand(45, 897009);
        /* String Translations Variables */
        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_login_strings();
        /* End */
        ?>

        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="register" data="<?php echo automobile_element_size_data_array_index($button_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $button_element_size, '', 'heart'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_register {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_edit_register_options')); ?></h5>
                    <a href="javascript:automobile_var_removeoverlay('<?php echo esc_attr($name . $automobile_counter) ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> 
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
                        <?php
                        $automobile_opt_array = array(
                            'name' => esc_html(automobile_var_plugin_text_srt('automobile_var_section_title')),
                            'desc' => '',
                            'hint_text' => esc_html(automobile_var_plugin_text_srt('automobile_var_section_title_hint')),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_register_title,
                                'id' => 'automobile_var_register_title',
                                'cust_name' => 'automobile_var_register_title[]',
                                'return' => true,
                            ),
                        );
                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                        ?>
                    </div>
                    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_pb_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_insert')); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                        <?php
                    } else {
                        $automobile_opt_array = array(
                            'std' => 'register',
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'classes' => '',
                            'extra_atr' => '',
                            'cust_id' => '',
                            'cust_name' => 'automobile_orderby[]',
                            'return' => true,
                            'required' => false
                        );
                        $out = $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                        echo force_balance_tags($out);
                        $automobile_opt_array = array(
                            'name' => '',
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_save')),
                                'cust_id' => '',
                                'cust_type' => 'button',
                                'classes' => 'cs-admin-btn',
                                'cust_name' => '',
                                'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                'return' => true,
                            ),
                        );

                        $automobile_html_fields->automobile_text_field($automobile_opt_array);
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_register', 'automobile_var_page_builder_register');
}


/*
 *
 * Start Function  how to login from social site(facebook, linkedin,twitter,etc)
 *
 */
if (!function_exists('automobile_social_login_form')) {

    function automobile_social_login_form($args = NULL) {
        require_once ('cs-social-login/linkedin/linkedin_function.php');
        global $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text;

        /* String Translations Variables */
        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_login_strings();
        $strings->automobile_var_plugin_option_strings();
        /* End */

        $display_label = false;
        // check for admin login form
        $admin_page = '0';
        if (in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
            $admin_page = '1';
        }
        if (get_option('users_can_register') && $admin_page == 0) {
            if ($args == NULL)
                $display_label = true;
            elseif (is_array($args))
                extract($args);
            if (!isset($images_url))
                $images_url = automobile_var::plugin_url() . 'directory-login/cs-social-login/media/img/';
            $facebook_app_id = '';
            $facebook_secret = '';
            if (isset($automobile_var_plugin_options['automobile_dashboard'])) {
                $automobile_dashboard_link = get_permalink($automobile_var_plugin_options['automobile_dashboard']);
            }
            $twitter_enabled = isset($automobile_var_plugin_options['automobile_twitter_api_switch']) ? $automobile_var_plugin_options['automobile_twitter_api_switch'] : '';
            $facebook_enabled = isset($automobile_var_plugin_options['automobile_facebook_login_switch']) ? $automobile_var_plugin_options['automobile_facebook_login_switch'] : '';
            $google_enabled = isset($automobile_var_plugin_options['automobile_google_login_switch']) ? $automobile_var_plugin_options['automobile_google_login_switch'] : '';
            $linkedin_enabled = isset($automobile_var_plugin_options['automobile_linkedin_login_switch']) ? $automobile_var_plugin_options['automobile_linkedin_login_switch'] : '';

            if (isset($automobile_var_plugin_options['automobile_facebook_app_id']))
                $facebook_app_id = $automobile_var_plugin_options['automobile_facebook_app_id'];
            if (isset($automobile_var_plugin_options['automobile_facebook_secret']))
                $facebook_secret = $automobile_var_plugin_options['automobile_facebook_secret'];
            if (isset($automobile_var_plugin_options['automobile_consumer_key']))
                $twitter_app_id = $automobile_var_plugin_options['automobile_consumer_key'];
            if (isset($automobile_var_plugin_options['automobile_google_client_id']))
                $google_app_id = $automobile_var_plugin_options['automobile_google_client_id'];
            if (isset($automobile_var_plugin_options['automobile_linkedin_app_id']))
                $linkedin_app_id = $automobile_var_plugin_options['automobile_linkedin_app_id'];
            if (isset($automobile_var_plugin_options['automobile_linkedin_secret']))
                $linkedin_secret = $automobile_var_plugin_options['automobile_linkedin_secret'];
            if ($twitter_enabled == 'on' || $facebook_enabled == 'on' || $google_enabled == 'on' || $linkedin_enabled == 'on') :
                $rand_id = rand(0, 98989899);
                $isRegistrationOn = get_option('users_can_register');
                if ($isRegistrationOn) {
                    ?>
                    <div class="footer-element comment-form-social-connect social_login_ui <?php if (strpos($_SERVER['REQUEST_URI'], 'wp-signup.php')) echo 'mu_signup'; ?>">
                        <div class="social_login_facebook_auth">
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => esc_attr($facebook_app_id),
                                'cust_id' => "",
                                'cust_name' => "client_id",
                                'classes' => '',
                            );
                            $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => home_url('index.php?social-login=facebook-callback'),
                                'cust_id' => "",
                                'cust_name' => "redirect_uri",
                                'classes' => '',
                            );
                            $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                            ?>
                        </div>
                        <div class="social_login_twitter_auth">
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => esc_attr($twitter_app_id),
                                'cust_id' => "",
                                'cust_name' => "client_id",
                                'classes' => '',
                            );
                            $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => home_url('index.php?social-login=twitter'),
                                'cust_id' => "",
                                'cust_name' => "redirect_uri",
                                'classes' => '',
                            );
                            $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                            ?>
                        </div>
                        <div class="social_login_google_auth">
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => esc_attr($google_app_id),
                                'cust_id' => "",
                                'cust_name' => "client_id",
                                'classes' => '',
                            );
                            $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                            $automobile_opt_array = array(
                                'id' => '',
                                //'std' => '',
                                'std' => automobile_google_login_url() . (isset($_GET['redirect_to']) ? '&redirect=' . $_GET['redirect_to'] : ''),
                                'cust_id' => "",
                                'cust_name' => "redirect_uri",
                                'classes' => '',
                            );
                            $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                            ?>
                        </div>
                        <?php if ($linkedin_enabled == 'on') { ?>
                            <div class="social_login_linkedin_auth">
                                <?php
                                $automobile_opt_array = array(
                                    'id' => '',
                                    'std' => 'initiate',
//                                    'cust_id' => LINKEDIN::_GET_TYPE,
                                    'cust_name' => LINKEDIN::_GET_TYPE,
                                    'classes' => '',
                                );
                                $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                $automobile_opt_array = array(
                                    'id' => '',
                                    'std' => home_url('index.php?social-login=linkedin'),
                                    'cust_id' => "",
                                    'cust_name' => "redirect_uri",
                                    'classes' => '',
                                );
                                $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                ?>
                            </div>
                        <?php } ?>
                        <div class="cs-dealer-social">
                            <?php
                            echo '<em>' . esc_html(automobile_var_plugin_text_srt('automobile_var_signin_with_your_Social_networks')) . '</em>';
                            ?>
                            <ul>	 
                                <?php
                                if (is_user_logged_in()) {

                                    // remove id from all links
                                    if ($facebook_enabled == 'on') :
                                        echo apply_filters('social_login_login_facebook', '<li><a onclick="javascript:show_alert_msg(\'' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '\')" href="javascript:void(0);" title="Facebook" data-original-title="Facebook" class=" ' . esc_html(automobile_var_plugin_text_srt('automobile_var_facebook')) . '"><span class="social-mess-top fb-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-facebook-f"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_facebook_title')) . '</a></li>');
                                    endif;
                                    if ($twitter_enabled == 'on') :
                                        echo apply_filters('social_login_login_twitter', '<li><a onclick="javascript:show_alert_msg(\'' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '\')" href="javascript:void(0);" title="Twitter" data-original-title="twitter" class="' . esc_html(automobile_var_plugin_text_srt('automobile_var_twitter')) . '"><span class="social-mess-top tw-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-twitter4"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_twitter_title')) . '</a></li>');
                                    endif;
                                    if ($google_enabled == 'on') :
                                        echo apply_filters('social_login_login_google', '<li><a onclick="javascript:show_alert_msg(\'' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '\')" href="javascript:void(0);" rel="nofollow" title="google-plus" data-original-title="' . esc_html(automobile_var_plugin_text_srt('automobile_var_google_plus_icon')) . '" class="gplus"><span class="social-mess-top gplus-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-google4"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_google_title')) . '</a></li>');
                                    endif;
                                    if ($linkedin_enabled == 'on') :
                                        echo apply_filters('social_login_login_linkedin', '<li><a onclick="javascript:show_alert_msg(\'' . esc_html(automobile_var_plugin_text_srt('automobile_var_please_logout_first')) . '\')" href="javascript:void(0);" rel="nofollow" title="linked-in" data-original-title="' . esc_html(automobile_var_plugin_text_srt('automobile_var_linkedin_title')) . '" class="linkedin" data-applyinventoryid=""><span class="social-mess-top linkedin-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-linkedin2"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_linkedin_title_full')) . '</a></li>');
                                    endif;
                                } else {

                                    // remove id from all links
                                    if ($facebook_enabled == 'on') :
                                        echo apply_filters('social_login_login_facebook', '<li><a href="javascript:void(0);" title="Facebook" data-original-title="' . esc_html(automobile_var_plugin_text_srt('automobile_var_facebook_title')) . '" class="social_login_login_facebook facebook"><span class="social-mess-top fb-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-facebook-f"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_facebook')) . '</a></li>');
                                    endif;
                                    if ($twitter_enabled == 'on') :
                                        echo apply_filters('social_login_login_twitter', '<li><a href="javascript:void(0);" title="Twitter" data-original-title="' . esc_html(automobile_var_plugin_text_srt('automobile_var_twitter')) . '" class="social_login_login_twitter twitter"><span class="social-mess-top tw-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-twitter4"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_twitter')) . '</a></li>');
                                    endif;
                                    if ($google_enabled == 'on') :
                                        echo apply_filters('social_login_login_google', '<li><a  href="javascript:void(0);" rel="nofollow" title="google-plus" data-original-title="' . esc_html(automobile_var_plugin_text_srt('automobile_var_google_plus_icon')) . '" class="social_login_login_google gplus"><span class="social-mess-top gplus-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-google"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_google')) . '</a></li>');
                                    endif;
                                    if ($linkedin_enabled == 'on') :
                                        echo apply_filters('social_login_login_linkedin', '<li><a  href="javascript:void(0);" rel="nofollow" title="linked-in" data-original-title="' . esc_html(automobile_var_plugin_text_srt('automobile_var_linkedin_title')) . '" class="social_login_login_linkedin linkedin" data-applyinventoryid=""><span class="social-mess-top linkedin-social-login" style="display:none">' . esc_html(automobile_var_plugin_text_srt('automobile_var_set_api_key')) . '</span><i class="icon-linkedin2"></i>' . esc_html(automobile_var_plugin_text_srt('automobile_var_linkedin')) . '</a></li>');
                                    endif;
                                }

                                $social_login_provider = isset($_COOKIE['social_login_current_provider']) ? $_COOKIE['social_login_current_provider'] : '';

                                do_action('social_login_auth');
                                ?> 
                            </ul> 
                        </div>
                    </div>
                <?php } ?>

                <?php
            endif;
        }
    }

}
/*
 *
 * End Function  how to login from social site;
 *
 */

add_action('login_form', 'automobile_social_login_form', 10);
add_action('social_form', 'automobile_social_login_form', 10);
add_action('after_signup_form', 'automobile_social_login_form', 10);
add_action('social_login_form', 'automobile_social_login_form', 10);

/*
 *
 * Start Function  how to user  recover his  password
 *
 */
if (!function_exists('automobile_recover_pass')) {

    function automobile_recover_pass() {
        global $wpdb, $automobile_var_plugin_static_text;
        /* String Translations Variables */
        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_option_strings();
        $strings->automobile_var_plugin_login_strings();

        /* End */
        $automobile_danger_html = '<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><p><i class="icon-warning4"></i>';
        $automobile_success_html = '<div class="alert alert-success"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><p><i class="icon-checkmark6"></i>';

        $automobile_msg_html = '</p></div>';

        $automobile_msg = '';
        // check if we're in reset form
        if (isset($_POST['action']) && 'automobile_recover_pass' == $_POST['action']) {
            $email = esc_sql(trim($_POST['user_input']));
            if (empty($email)) {
                $automobile_msg = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_enter_email_address')) . $automobile_msg_html;
            } else if (!is_email($email)) {
                $automobile_msg = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_invalid_email_address')) . $automobile_msg_html;
            } else if (!email_exists($email)) {
                $automobile_msg = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_there_is_no_user_registered')) . $automobile_msg_html;
            } else {
                $random_password = wp_generate_password(12, false);
                $user = get_user_by('email', $email);
                $username = $user->user_login;
                $update_user = wp_update_user(array(
                    'ID' => $user->ID,
                    'user_pass' => $random_password
                        )
                );
                if ($update_user) {
                    $to = $email;
                    $subject = esc_html(automobile_var_plugin_text_srt('automobile_var_your_new_password'));
                    $sender = get_option('name');
                    $message = esc_html(automobile_var_plugin_text_srt('automobile_var_ur_request_has_been_completed_succssfully')) . "\r\n";
                    $message .= esc_html(automobile_var_plugin_text_srt('automobile_var_your_username_is')) . $username;
                    $message .= esc_html(automobile_var_plugin_text_srt('automobile_var_your_new_password_is')) . $random_password;

                    $headers[] = 'MIME-Version: 1.0' . "\r\n";
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers[] = "X-Mailer: PHP \r\n";
                    $headers[] = 'From: ' . $sender . ' <' . $email . '>' . "\r\n";

                    $mail = wp_mail($to, $subject, $message, $headers);
                    if ($mail):

                        $automobile_msg = $automobile_success_html . esc_html(automobile_var_plugin_text_srt('automobile_var_check_your_email_address_for_new_password')) . $automobile_msg_html;
                    endif;
                } else {

                    $automobile_msg = $automobile_danger_html . esc_html(automobile_var_plugin_text_srt('automobile_var_oops_something_went_wrong_updating_your_account')) . $automobile_msg_html;
                }
            }
            //end else
        }
        // end if
        echo ($automobile_msg);

        die;
    }

    add_action('wp_ajax_automobile_recover_pass', 'automobile_recover_pass');
    add_action('wp_ajax_nopriv_automobile_recover_pass', 'automobile_recover_pass');
}

/*
 *
 * End Function  how to user  recover his  password
 *
 */
/*
 *
 * Start Function  how to user  recover his  lost password
 *
 */

if (!function_exists('automobile_lost_pass')) {

    function automobile_lost_pass($atts, $content = "") {
        global $automobile_form_fields, $automobile_var_plugin_static_text;
        /* String Translations Variables */
        $strings = new automobile_plugin_all_strings;
        $strings->automobile_var_plugin_login_strings();
        $strings->automobile_var_plugin_option_strings();
        /* End */
        $automobile_defaults = array(
            'automobile_type' => '',
        );
        extract(shortcode_atts($automobile_defaults, $atts));
        ob_start();
        $automobile_rand = rand(12345678, 98765432);
        if ($automobile_type == 'popup') {
            ?>
            <div class = "modal" id = "user-forgot-pass"  role = "dialog">
                <div class = "modal-dialog" role = "document">
                    <div class = "modal-content">
                        <div class = "modal-header">
                            <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"><span aria-hidden = "true">&times;</span></button>
                        </div>
                        <div class = "modal-body">
                            <h4><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_password_recovery')); ?></h4>
                            <div id="cs-result-<?php echo absint($automobile_rand) ?>" class="status status-message"></div>
                            <div class="cs-login-form" id="login-form-id-<?php echo absint($automobile_rand) ?>">
                                <form  id="wp_pass_lost_<?php echo absint($automobile_rand) ?>" method="post">	
                                    <div class="input-holder">
                                        <label for="cs-email"> <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email')); ?></strong> <i class="icon-envelope"></i>
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => 'cs-email',
                                                'std' => '',
                                                'cust_id' => "cs-email",
                                                'cust_name' => "user_input",
                                                'classes' => '',
                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_enter_email_address')) . '"',
                                            );
                                            $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>
                                        </label>
                                    </div>
                                    <div class="input-holder">
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_send_email')),
                                            'cust_id' => "",
                                            'cust_name' => "submit",
                                            'classes' => 'cs-color csborder-color',
                                            'cust_type' => 'submit',
                                        );
                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </div>



                                </form>
                            </div>
                        </div>
                        <?php
                        $isRegistrationOn = get_option('users_can_register');
                        if ($isRegistrationOn) {
                            ?>
                            <div class="modal-footer">
                                <div class="cs-user-signup"> <i class="icon-user-plus2"></i> <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_not_member_yet')); ?></strong> <a href="javascript:;" data-toggle="modal" data-target="#join-us" data-dismiss="modal" class="cs-color" aria-hidden="true"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_Sign_up_now')); ?></a> </div>
                            </div>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="scetion-title">
                <h2><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_forgot_password')); ?></h2>
            </div>
            <div class="status status-message" id="cs-result-<?php echo absint($automobile_rand) ?>"></div>
            <form class="user_form" id="wp_pass_lost_<?php echo absint($automobile_rand) ?>" method="post">		
                <div class="row">
                    <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="cs-dealer-field">

                            <?php echo '<label for="user_email"> <strong>' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '</strong> <i class="icon-envelope"></i>'; ?>

                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => '',
                                'cust_id' => "user_email",
                                'cust_name' => "user_input",
                                'classes' => '',
                                'extra_atr' => 'onfocus="if (this.value == \'' . esc_html(automobile_var_plugin_text_srt('automobile_var_enter_email_address')) . '\') {
                                                this.value = \'\';
                                            }" onblur="if (this.value == \'\') {
                                                        this.value = \'' . esc_html(automobile_var_plugin_text_srt('automobile_var_enter_email_address')) . '\' ;
                                                    }"',
                            );
                            $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                            echo '</label>';
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">

                        <div class="cs-dealer-field-btn">
                            <?php
                            $automobile_opt_array = array(
                                'id' => '',
                                'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_send_email')),
                                'cust_id' => "",
                                'cust_name' => "submit",
                                'classes' => 'cs-color csborder-color',
                                'cust_type' => 'submit',
                            );
                            $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                        <a class="login-link-page" href="#"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_login_here')); ?></a>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
        <script type="text/javascript">
            var $ = jQuery;
            $("#wp_pass_lost_<?php echo absint($automobile_rand) ?>").submit(function () {
				 $('#cs-result-<?php echo absint($automobile_rand) ?>').addClass('cs-spinner');				 
                $('#cs-result-<?php echo absint($automobile_rand) ?>').html('<i class="icon-spinner8 icon-spin"></i>').fadeIn();
                var input_data = $('#wp_pass_lost_<?php echo absint($automobile_rand) ?>').serialize() + '&action=automobile_recover_pass';
                $.ajax({
                    type: "POST",
                    url: "<?php echo esc_url(admin_url('admin-ajax.php')) ?>",
                    data: input_data,
                    success: function (msg) {
						$('#cs-result-<?php echo absint($automobile_rand) ?>').removeClass('cs-spinner');
                        $('#cs-result-<?php echo absint($automobile_rand) ?>').html(msg);
                    }
                });
                return false;
            });
            $(document).on('click', '.cs-forgot-switch', function () {

                $('.cs-login-pbox').hide();
                $('.cs-forgot-pbox').show();
            });
            $(document).on('click', '.cs-login-switch', function () {
                $('.cs-forgot-pbox').hide();
                $('.cs-login-pbox').show();
            });
        </script>
        <?php
        $automobile_html = ob_get_clean();

        return do_shortcode($automobile_html);
    }

    add_shortcode('automobile_forgot_password', 'automobile_lost_pass');
}
/*
 *
 * End Function  how to user  recover his  lost password
 *
 */
?>