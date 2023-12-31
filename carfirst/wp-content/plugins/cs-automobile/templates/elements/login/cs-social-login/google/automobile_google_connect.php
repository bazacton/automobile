<?php
global $automobile_google_settings;
$automobile_google_settings = get_option( 'automobile_plugin_options' );

// set google unique id
if ( ! function_exists( 'automobile_google_uniqid' ) ) {

    function automobile_google_uniqid() {
        if ( isset( $_COOKIE['automobile_google_uniqid'] ) ) {
            if ( get_site_transient( 'n_' . $_COOKIE['automobile_google_uniqid'] ) !== false ) {
                return $_COOKIE['automobile_google_uniqid'];
            }
        }
        $_COOKIE['automobile_google_uniqid'] = uniqid( 'nextend', true );
        setcookie( 'automobile_google_uniqid', $_COOKIE['automobile_google_uniqid'], time() + 3600, '/' );
        set_site_transient( 'n_' . $_COOKIE['automobile_google_uniqid'], 1, 3600 );

        return $_COOKIE['automobile_google_uniqid'];
    }

}

// google query var

if ( ! function_exists( 'automobile_google_add_query_var' ) ) {

    function automobile_google_add_query_var() {

        global $wp;
        $wp->add_query_var( 'editProfileRedirect' );
        $wp->add_query_var( 'loginGoogle' );
    }

}


add_filter( 'init', 'automobile_google_add_query_var' );
add_action( 'parse_request', 'automobile_google_login_compat' );

// for google login compat
if ( ! function_exists( 'automobile_google_login_compat' ) ) {

    function automobile_google_login_compat() {

        global $wp;
        if ( $wp->request == 'loginGoogle' || isset( $wp->query_vars['loginGoogle'] ) ) {
            automobile_google_login_action();
        }
    }

}

/*
  For login page
 */
add_action( 'login_init', 'automobile_google_login' );

if ( ! function_exists( 'automobile_google_login' ) ) {

    function automobile_google_login() {
        if ( isset( $_REQUEST['loginGoogle'] )and $_REQUEST['loginGoogle'] == '1' ) {
            automobile_google_login_action();
        }
    }

}

// set google login action
if ( ! function_exists( 'automobile_google_login_action' ) ) {

    function automobile_google_login_action() {


        global $wp, $wpdb, $automobile_google_settings, $automobile_var_plugin_options;
        include_once 'sdk/apiClient.php';
        include_once 'sdk/contrib/apiOauth2Service.php';

        $client = new apiClient();
        $client->setClientId( $automobile_var_plugin_options['automobile_google_client_id'] );
        $client->setClientSecret( $automobile_var_plugin_options['automobile_google_client_secret'] );
        $client->setDeveloperKey( $automobile_var_plugin_options['automobile_google_api_key'] );
        $client->setRedirectUri( automobile_google_login_url() );
        $client->setApprovalPrompt( 'auto' );

        $oauth2 = new apiOauth2Service( $client );

        if ( isset( $_GET['code'] ) ) {
            if ( isset( $automobile_google_settings['automobile_google_login_redirect_url'] ) && $automobile_google_settings['automobile_google_login_redirect_url'] != '' && $automobile_google_settings['automobile_google_login_redirect_url'] != 'auto' ) {
                $_GET['redirect'] = $automobile_google_settings['automobile_google_login_redirect_url'];
            } else {
                $_GET['redirect'] = automobile_google_login_url();
            }
            set_site_transient( automobile_google_uniqid() . '_google_r', $_GET['redirect'], 3600 );
            $client->authenticate();
            $access_token = $client->getAccessToken();
            set_site_transient( automobile_google_uniqid() . '_google_at', $access_token, 3600 );
            header( 'Location: ' . filter_var( automobile_google_login_url(), FILTER_SANITIZE_URL ) );
            exit;
        }

        $access_token = get_site_transient( automobile_google_uniqid() . '_google_at' );

        if ( $access_token !== false ) {
            $client->setAccessToken( $access_token );
        }
        if ( isset( $_REQUEST['logout'] ) ) {
            delete_site_transient( automobile_google_uniqid() . '_google_at' );
            $client->revokeToken();
        }
        if ( $client->getAccessToken() ) {
            $u = $oauth2->userinfo->get();
            // The access token may have been updated lazily.
            set_site_transient( automobile_google_uniqid() . '_google_at', $client->getAccessToken(), 3600 );
            $email = filter_var( $u['email'], FILTER_SANITIZE_EMAIL );
            if ( ! is_user_logged_in() ) {

                $ID = email_exists( $email );

                if ( $ID == NULL ) { // Register
                    if ( $ID == false ) { // Real register
                        $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
                        if ( ! isset( $automobile_google_settings['google_user_prefix'] ) )
                            $automobile_google_settings['google_user_prefix'] = 'Google - ';
                        $sanitized_user_login = sanitize_user( $automobile_google_settings['google_user_prefix'] . $u['name'] );
                        if ( ! validate_username( $sanitized_user_login ) ) {
                            $sanitized_user_login = sanitize_user( 'google' . $user_profile['id'] );
                        }
                        $defaul_user_name = $sanitized_user_login;
                        $i = 1;
                        while ( username_exists( $sanitized_user_login ) ) {
                            $sanitized_user_login = $defaul_user_name . $i;
                            $i ++;
                        }
                        $ID = wp_create_user( $sanitized_user_login, $random_password, $email );
                        if ( ! is_wp_error( $ID ) ) {
                            $new_user = new WP_User( $ID );
                            $user_info = get_userdata( $ID );
                            wp_update_user(array(
                            'ID' => $ID,
                            'display_name' => isset($u['name']) ? $u['name']:'',
                            'first_name' => isset($u['given_name']) ? $u['given_name']:'',
                            'last_name' => isset($u['family_name'])? $u['family_name']:'',
                            'googleplus' => isset( $u['link'])? $u['link']:''
                            ));
                            // update user meta
                            $new_user->set_role( 'automobile_dealer' );
                            update_user_meta( $ID, 'automobile_user_last_activity_date', strtotime( date( 'd-m-Y H:i:s' ) ) );
                            update_user_meta( $ID, 'automobile_allow_search', 'yes' );
                            // update_user_meta($ID, 'automobile_user_status', 'active');

                            update_user_meta( $ID, 'automobile_google_default_password', $user_info->user_pass );
                            do_action( 'automobile_google_user_registered', $ID, $u, $oauth2 );
                            update_user_meta( $ID, 'automobile_user_registered', 'google' );
                            if ( isset( $u['link'] ) && $u['link'] != '' ) {
                                update_user_meta( $ID, 'automobile_google_plus', $u['link'] );
                            }
                            if ( isset( $automobile_var_plugin_options['automobile_candidate_review_option'] ) && $automobile_var_plugin_options['automobile_candidate_review_option'] == 'on' ) {

                                $wpdb->update(
                                        $wpdb->prefix . 'users', array( 'user_status' => 1 ), array( 'ID' => esc_sql( $ID ) )
                                );
                                update_user_meta( $ID, 'automobile_user_status', 'active' );
                            } else {
                                $wpdb->update(
                                        $wpdb->prefix . 'users', array( 'user_status' => 0 ), array( 'ID' => esc_sql( $ID ) )
                                );
                                update_user_meta( $ID, 'automobile_user_status', 'inactive' );
                            }
                        } else {
                            return;
                        }
                    }

                    if ( isset( $automobile_google_settings['google_redirect_reg'] ) && $automobile_google_settings['google_redirect_reg'] != '' && $automobile_google_settings['google_redirect_reg'] != 'auto' ) {
                        set_site_transient( automobile_google_uniqid() . '_google_r', $automobile_google_settings['google_redirect_reg'], 3600 );
                    }
                }
                if ( $ID ) {

                    $current_user = get_userdata( $ID );
                    $user_roles = isset( $current_user->roles ) ? $current_user->roles : '';
                    if ( ($user_roles != '' && in_array( "automobile_dealer", $user_roles ) ) ) {
                        $user_info = get_userdata( $ID );
                        // update user meta
                        update_user_meta( $ID, 'automobile_user_last_activity_date', strtotime( date( 'd-m-Y H:i:s' ) ) );

                        update_user_meta( $ID, 'automobile_google_default_password', $user_info->user_pass );
                        do_action( 'automobile_google_user_registered', $ID, $u, $oauth2 );
                        update_user_meta( $ID, 'automobile_user_registered', 'google' );
                        if ( isset( $u['link'] ) && $u['link'] != '' ) {
                            update_user_meta( $ID, 'automobile_google_plus', $u['link'] );
                        }
                        $secure_cookie = is_ssl();
                        $secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, array() );
                        global $auth_secure_cookie; // XXX ugly hack to pass this to wp_authenticate_cookie

                        $auth_secure_cookie = $secure_cookie;
                        wp_set_auth_cookie( $ID, true, $secure_cookie );

                        do_action( 'wp_login', $user_info->user_login, $user_info );
                        update_user_meta( $ID, 'google_profile_picture', $u['picture'] );
                    } else {
                        ?>
                        <script>
                            alert("<?php echo __( 'This Google profile is already linked with other account. Linking process failed!', 'automobile' ); ?>");
                            window.opener.location.reload();
                            window.close();
                        </script>
                        <?php
                        $ID = Null;     // set null bcz this user exist in other Role
                    }
                }
            } else {

                $user_info = wp_get_current_user();
                set_site_transient( $user_info->ID . '_automobile_google_admin_notice', __( 'This Google profile is already linked with other account. Linking process failed!', 'automobile' ), 3600 );
            }
        } else {
            if ( isset( $automobile_google_settings['google_redirect'] ) && $automobile_google_settings['google_redirect'] != '' && $automobile_google_settings['google_redirect'] != 'auto' ) {
                $_GET['redirect'] = $automobile_google_settings['google_redirect'];
            }
            if ( isset( $_GET['redirect'] ) ) {
                set_site_transient( automobile_google_uniqid() . '_google_r', $_GET['redirect'], 3600 );
            }

            $redirect = get_site_transient( automobile_google_uniqid() . '_google_r' );

            if ( $redirect || $redirect == automobile_google_login_url() ) {
                $redirect = esc_url( home_url( '/' ) );
                set_site_transient( automobile_google_uniqid() . '_google_r', $redirect, 3600 );
            }
            header( 'LOCATION: ' . $client->createAuthUrl() );
            exit;
        }
        automobile_google_redirect();
    }

}

// insert google avatar
if ( ! function_exists( 'automobile_google_insert_avatar' ) ) {

    function automobile_google_insert_avatar( $avatar = '', $id_or_email = '', $size = 96, $default = '', $alt = false ) {

        $id = 0;
        if ( is_numeric( $id_or_email ) ) {
            $id = $id_or_email;
        } else if ( is_string( $id_or_email ) ) {
            $u = get_user_by( 'email', $id_or_email );
            $id = $u->id;
        } else if ( is_object( $id_or_email ) ) {
            $id = $id_or_email->user_id;
        }
        if ( $id == 0 )
            return $avatar;
        $pic = get_user_meta( $id, 'google_profile_picture', true );
        if ( ! $pic || $pic == '' )
            return $avatar;
        $avatar = preg_replace( '/src=("|\').*?("|\')/i', 'src=\'' . $pic . '\'', $avatar );
        return $avatar;
    }

}

add_filter( 'bp_core_fetch_avatar', 'automobile_google_bp_insert_avatar', 3, 5 );

// insert google bp avatar
if ( ! function_exists( 'automobile_google_bp_insert_avatar' ) ) {

    function automobile_google_bp_insert_avatar( $avatar = '', $params = array(), $id = '' ) {
        if ( ! is_numeric( $id ) || strpos( $avatar, 'gravatar' ) === false )
            return $avatar;
        $pic = get_user_meta( $id, 'google_profile_picture', true );
        if ( ! $pic || $pic == '' )
            return $avatar;
        $avatar = preg_replace( '/src=("|\').*?("|\')/i', 'src=\'' . $pic . '\'', $avatar );
        return $avatar;
    }

}

/* -----------------------------------------------------------------------------
  Miscellaneous functions
  ----------------------------------------------------------------------------- */

// google sign up button
if ( ! function_exists( 'automobile_google_sign_button' ) ) {

    function automobile_google_sign_button() {

        global $automobile_google_settings;
        $automobile_google_settings = is_array($automobile_google_settings)? $automobile_google_settings : array();
        $automobile_google_settings['google_login_button'] = 'Google';
        return '<a href="' . automobile_google_login_url() . (isset( $_GET['redirect_to'] ) ? '&redirect=' . $_GET['redirect_to'] : '') . '" rel="nofollow">' . $automobile_google_settings['google_login_button'] . '</a><br />';
    }

}

// google link button
if ( ! function_exists( 'automobile_google_link_button' ) ) {

    function automobile_google_link_button() {

        global $automobile_google_settings;
        $automobile_google_settings = is_array($automobile_google_settings)? $automobile_google_settings : array();
        $automobile_google_settings['google_login_button'] = 'Google';
        $images_url = automobile_var::plugin_url() . 'directory-login/cs-social-login/media/img/';
        return '<a href="' . esc_url( automobile_google_login_url() . '&redirect=' . automobile_google_curPageURL() ) . '"><img alt="Twitter" src="' . esc_url( $images_url . 'google_32.png' ) . '" /></a><br />';
    }

}

add_action( 'login_form', 'automobile_google_link_button' );
add_action( 'register_form', 'automobile_google_link_button' );

// google page url
if ( ! function_exists( 'automobile_google_curPageURL' ) ) {

    function automobile_google_curPageURL() {

        $pageURL = 'http';
        if ( isset( $_SERVER["HTTPS"] ) && $_SERVER["HTTPS"] == "on" ) {
            $pageURL.= "s";
        }
        $pageURL.= "://";
        if ( $_SERVER["SERVER_PORT"] != "80" ) {
            $pageURL.= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL.= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

}

// custom google login
if ( ! function_exists( 'automobile_google_login_url' ) ) {

    function automobile_google_login_url() {
        //global $post;
        return home_url( 'wp-login.php' ) . '?loginGoogle=1';
    }

}

// google redirect URL
if ( ! function_exists( 'automobile_google_redirect' ) ) {

    function automobile_google_redirect() {
        global $post;
        if ( isset( $_GET['redirect_to'] ) && $_GET['redirect_to'] != '' ) {
            $redirect = get_permalink( $_GET['redirect_to'] );
        } else {
            $redirect = esc_url( home_url( '/' ) );
        }

        header( 'LOCATION: ' . $redirect );
        delete_site_transient( automobile_google_uniqid() . '_google_r' );
        exit;
    }

}

//google edit profile url
if ( ! function_exists( 'automobile_google_edit_profile_redirect' ) ) {

    function automobile_google_edit_profile_redirect() {

        global $wp;
        if ( isset( $wp->query_vars['editProfileRedirect'] ) ) {
            if ( function_exists( 'bp_loggedin_user_domain' ) ) {
                header( 'LOCATION: ' . bp_loggedin_user_domain() . 'profile/edit/group/1/' );
            } else {
                header( 'LOCATION: ' . self_admin_url( 'profile.php' ) );
            }
            exit;
        }
    }

}

add_action( 'parse_request', 'automobile_google_edit_profile_redirect' );

// google query
if ( ! function_exists( 'automobile_google_jquery' ) ) {

    function automobile_google_jquery() {

        wp_enqueue_script( 'jquery' );
    }

}

add_action( 'login_form_login', 'automobile_google_jquery' );
add_action( 'login_form_register', 'automobile_google_jquery' );

/*
  Session notices used in the profile settings
 */
if ( ! function_exists( 'automobile_google_admin_notice' ) ) {

    function automobile_google_admin_notice() {
        $user_info = wp_get_current_user();
        $notice = get_site_transient( $user_info->ID . '_automobile_google_admin_notice' );
        if ( $notice !== false ) {
            echo '<div class="updated">
		   <p>' . $notice . '</p>
		</div>';
            delete_site_transient( $user_info->ID . '_automobile_google_admin_notice' );
        }
    }

}

add_action( 'admin_notices', 'automobile_google_admin_notice' );
