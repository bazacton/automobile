<?php
if ( ! function_exists( 'email_exists' ) )
	require_once ABSPATH . WPINC . '/registration.php';

// set query vars
function automobile_query_vars( $vars ) {
	$vars[] = 'social-login';
	return $vars;
}

add_action( 'query_vars', 'automobile_query_vars' );

// set parse request
function automobile_parse_request( $wp ) {

	$plugin_url = plugin_dir_url( __FILE__ );
	if ( array_key_exists( 'social-login', $wp->query_vars ) ) {
		if ( ! session_id() ) {
			session_start();
		}
		if ( isset( $wp->query_vars['social-login'] ) && $wp->query_vars['social-login'] == 'twitter' ) {
			automobile_twitter_connect();
		} else if ( isset( $wp->query_vars['social-login'] ) && $wp->query_vars['social-login'] == 'twitter-callback' ) {
			automobile_twitter_callback();
		} else if ( isset( $wp->query_vars['social-login'] ) && $wp->query_vars['social-login'] == 'linkedin' ) {
			require_once "linkedin/linkedin_function.php";
			die();
		} else if ( isset( $wp->query_vars['social-login'] ) && $wp->query_vars['social-login'] == 'facebook-callback' ) {
			require_once 'facebook/callback.php';
			die();
		}
		wp_die();
	}
	if ( isset( $_REQUEST['likedin-login-request'] ) ) {

		if ( ! session_id() ) {
			session_start();
		}
		$user_info = get_userdata( $_REQUEST['likedin-login-request'] );
		$ID = $_REQUEST['likedin-login-request'];

		$user_login = isset( $user_info->user_login ) ? $user_info->user_login : '';
		$user_id = $user_info->ID;
		wp_set_current_user( $user_id, $user_login );
		wp_set_auth_cookie( $user_id );
		do_action( 'wp_login', $user_login, $user_info );
	}
}

add_action( 'parse_request', 'automobile_parse_request' );

// login process method
function automobile_social_process_login( $is_ajax = false ) {
	global $automobile_var_plugin_options, $wpdb, $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();

	if ( isset( $_REQUEST['redirect_to'] ) && $_REQUEST['redirect_to'] != '' ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( isset( $secure_cookie ) && $secure_cookie && false !== strpos( $redirect_to, 'wp-admin' ) )
			$redirect_to = preg_replace( '|^http://|', 'https://', $redirect_to );
	} else {
		$redirect_to = admin_url();
	}

	$automobile_page_id = isset( $automobile_var_plugin_options['automobile_js_dashboard'] ) ? $automobile_var_plugin_options['automobile_js_dashboard'] : $_POST['redirect_to'];
	$redirect_to = get_permalink( ( int ) $automobile_page_id );
	$redirect_to = apply_filters( 'social_login_redirect_to', $redirect_to );
	$social_login_provider = $_REQUEST['social_login_provider'];
	$automobile_provider_identity_key = 'social_login_' . $social_login_provider . '_id';
	$automobile_provided_signature = $_REQUEST['social_login_signature'];
	switch ( $social_login_provider ) {
		case 'facebook':
			if ( session_id() == '' ) {
				session_start();
			}
			$fields = array(
				'id', 'name', 'first_name', 'last_name', 'link', 'website',
				'gender', 'locale', 'about', 'email', 'hometown', 'location',
				'birthday'
			);
			automobile_social_login_verify_signature( $_REQUEST['social_login_access_token'], $automobile_provided_signature, $redirect_to );
			$fb_json = json_decode( automobile_http_get_contents( "https://graph.facebook.com/me?access_token=" . $_REQUEST['social_login_access_token'] . "&fields=" . implode( ',', $fields ) ) );
			$automobile_provider_identity = $fb_json->{ 'id' };
			$automobile_profile_pic = 'https://graph.facebook.com/' . $automobile_provider_identity . '/picture';
			$automobile_facebook = $fb_json->{ 'link' };
			$automobile_gender = $fb_json->{ 'gender' };
			$automobile_email = $fb_json->{ 'email' };
			$automobile_first_name = $fb_json->{ 'first_name' };
			$automobile_last_name = $fb_json->{ 'last_name' };
			$automobile_profile_url = $fb_json->{ 'link' };
			$automobile_gender = $fb_json->{ 'gender' };
			$automobile_name = $automobile_first_name . ' ' . $automobile_last_name;
			$user_login = strtolower( $automobile_first_name . $automobile_last_name );

			break;
		case 'twitter':
			$automobile_provider_identity = $_REQUEST['social_login_twitter_identity'];
			automobile_social_login_verify_signature( $automobile_provider_identity, $automobile_provided_signature, $redirect_to );
			$automobile_name = $_REQUEST['social_login_name'];
			$automobile_twitter = 'https://twitter.com/' . $_REQUEST['social_login_screen_name'];
			$names = explode( " ", $automobile_name );
			$automobile_first_name = '';
			if ( isset( $names[0] ) )
				$automobile_first_name = $names[0];
			$automobile_last_name = '';
			if ( isset( $names[1] ) )
				$automobile_last_name = $names[1];
			$automobile_screen_name = $_REQUEST['social_login_screen_name'];
			$automobile_profile_url = '';
			$automobile_gender = '';
			// Get host name from URL
			$site_url = parse_url( site_url() );
			$automobile_email = 'tw_' . md5( $automobile_provider_identity ) . '@' . $site_url['host'] . '.com';
			$user_login = $automobile_screen_name;

			break;
		default:
			break;
	}

	// Get user by meta
	$user_id = automobile_social_get_user_by_meta( $automobile_provider_identity_key, $automobile_provider_identity );

	if ( $user_id ) {
		$current_user = get_userdata( $user_id );
		$user_roles = isset( $current_user->roles ) ? $current_user->roles : '';
		if ( ($user_roles != '' && in_array( "automobile_dealer", $user_roles ) ) ) {
			$user_data = get_userdata( $user_id );
			$user_login = $user_data->user_login;

			// update user meta
			update_user_meta( $user_id, 'automobile_user_last_activity_date', strtotime( date( 'd-m-Y H:i:s' ) ) );
			update_user_meta( $user_id, 'automobile_allow_search', 'yes' );
			update_user_meta( $user_id, 'automobile_user_status', 'active' );
			if ( isset( $automobile_facebook ) && $automobile_facebook != '' ) {
				update_user_meta( $user_id, 'automobile_facebook', $automobile_facebook );
			}
			if ( isset( $automobile_twitter ) && $automobile_twitter != '' ) {
				update_user_meta( $user_id, 'automobile_twitter', $automobile_twitter );
			}
		} else {
			?>
			<script>
			    alert("<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_already_linked' ) ) ?>");
			    window.opener.location.reload();
			    window.close();
			</script>
			<?php
			$ID = Null;	 // set null bcz this user exist in other Role
		}
	} elseif ( $user_id = email_exists( $automobile_email ) ) { // User not found by provider identity, check by email
		$current_user = get_userdata( $user_id );
		$user_roles = isset( $current_user->roles ) ? $current_user->roles : '';
		if ( ($user_roles != '' && in_array( "automobile_dealer", $user_roles ) ) ) {
			// update user meta
			update_user_meta( $user_id, $automobile_provider_identity_key, $automobile_provider_identity );

			$user_data = get_userdata( $user_id );
			$user_login = $user_data->user_login;

			// update user meta
			update_user_meta( $user_id, 'automobile_user_last_activity_date', strtotime( date( 'd-m-Y H:i:s' ) ) );
			update_user_meta( $user_id, 'automobile_allow_search', 'yes' );
			update_user_meta( $user_id, 'automobile_user_status', 'active' );
			if ( isset( $automobile_facebook ) && $automobile_facebook != '' ) {
				update_user_meta( $user_id, 'automobile_facebook', $automobile_facebook );
			}
			if ( isset( $automobile_twitter ) && $automobile_twitter != '' ) {
				update_user_meta( $user_id, 'automobile_twitter', $automobile_twitter );
			}
		} else {
			?>
			<script>
			    alert("<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_already_linked' ) ); ?>");
			    window.opener.location.reload();
			    window.close();
			</script>
			<?php
			$ID = Null;	 // set null bcz this user exist in other Role
		}
	} else { // Create new user and associate provider identity
		if ( get_option( 'users_can_register' ) ) {
			$user_login = automobile_get_unique_username( $user_login );
			$userdata = array( 'user_login' => $user_login, 'user_email' => $automobile_email, 'first_name' => $automobile_first_name, 'last_name' => $automobile_last_name, 'user_url' => $automobile_profile_url, 'user_pass' => wp_generate_password() );
			// Create a new user
			$user_id = wp_insert_user( $userdata );
			$new_user = new WP_User( $user_id );
			// update user meta
			$new_user->set_role( 'automobile_dealer' );
			update_user_meta( $user_id, 'automobile_user_last_activity_date', strtotime( date( 'd-m-Y H:i:s' ) ) );
			update_user_meta( $user_id, 'automobile_allow_search', 'yes' );
			update_user_meta( $user_id, 'automobile_user_status', 'active' );
			if ( isset( $automobile_facebook ) && $automobile_facebook != '' ) {
				update_user_meta( $user_id, 'automobile_facebook', $automobile_facebook );
			}
			if ( isset( $automobile_twitter ) && $automobile_twitter != '' ) {
				update_user_meta( $user_id, 'automobile_twitter', $automobile_twitter );
			}

			update_user_meta( $user_id, 'automobile_user_registered', $social_login_provider );

			if ( $user_id && is_integer( $user_id ) ) {
				update_user_meta( $user_id, $automobile_provider_identity_key, $automobile_provider_identity );
			}
			if ( isset( $automobile_var_plugin_options['automobile_dealer_review_option'] ) && $automobile_var_plugin_options['automobile_dealer_review_option'] == 'on' ) {
				$wpdb->update(
						$wpdb->prefix . 'users', array( 'user_status' => 1 ), array( 'ID' => esc_sql( $user_id ) )
				);
				update_user_meta( $user_id, 'automobile_user_status', 'active' );
			} else {
				$wpdb->update(
						$wpdb->prefix . 'users', array( 'user_status' => 0 ), array( 'ID' => esc_sql( $user_id ) )
				);
				update_user_meta( $user_id, 'automobile_user_status', 'inactive' );
			}
		} else {
			add_filter( 'wp_login_errors', 'wp_login_errors' );

			return;
		}
	}

	wp_set_auth_cookie( $user_id );

	do_action( 'social_connect_login', $user_login );
	$redirect_to = site_url();
	if ( $is_ajax ) {
		echo '{"redirect":"' . $redirect_to . '"}';
	} else {
		wp_safe_redirect( $redirect_to );
	}

	exit();
}

// login error
function automobile_login_errors( $errors ) {
	global $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	$errors->errors = array();
	$errors->add( 'registration_disabled', '<strong>' . esc_html( automobile_var_plugin_text_srt( 'automobile_var_error' ) ) . '</strong>:', esc_html( automobile_var_plugin_text_srt( 'automobile_var_user_registration' ) ) );




	return $errors;
}

// get unique username
function automobile_get_unique_username( $user_login, $c = 1 ) {
	if ( username_exists( $user_login ) ) {
		if ( $c > 5 )
			$append = '_' . substr( md5( $user_login ), 0, 3 ) . $c;
		else
			$append = $c;

		$user_login = apply_filters( 'social_login_username_exists', $user_login . $append );
		return automobile_get_unique_username( $user_login, ++ $c );
	} else {
		return $user_login;
	}
}

add_action( 'login_form_social_login', 'automobile_social_process_login' );

// ajax login
function automobile_ajax_login() {
	if ( isset( $_POST['login_submit'] ) && $_POST['login_submit'] == 'ajax' && // Plugins will need to pass this param
			isset( $_POST['action'] ) && $_POST['action'] == 'social_login' )
		automobile_social_process_login( true );
}

add_action( 'init', 'automobile_ajax_login' );

// filter user avatar
function automobile_filter_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
	$custom_avatar = '';
	$social_id = '';
	$provider_id = '';
	$user_id = ( ! is_integer( $id_or_email ) && ! is_string( $id_or_email ) && get_class( $id_or_email )) ? $id_or_email->user_id : $id_or_email;

	if ( ! empty( $user_id ) ) {

		$providers = array( 'facebook', 'twitter' );

		$social_login_provider = isset( $_COOKIE['social_login_current_provider'] ) ? $_COOKIE['social_login_current_provider'] : '';
		if ( ! empty( $social_login_provider ) && $social_login_provider == 'twitter' ) {
			$providers = array( 'twitter', 'facebook' );
		}
		foreach ( $providers as $search_provider ) {
			$social_id = get_user_meta( $user_id, 'social_login_' . $search_provider . '_id', true );
			if ( ! empty( $social_id ) ) {
				$provider_id = $search_provider;
				break;
			}
		}
	}
	if ( ! empty( $social_id ) ) {
		
	}

	if ( ! empty( $custom_avatar ) ) {
		update_user_meta( $user_id, 'custom_avatar', $custom_avatar );
		$return = '<img class="avatar" src="' . esc_url( $custom_avatar ) . '" style="width:' . $size . 'px" alt="' . $alt . '" />';
	} else if ( $avatar ) {
		// gravatar
		$return = $avatar;
	} else {
		// default
		$return = '<img class="avatar" src="' . esc_url( $default ) . '" style="width:' . $size . 'px" alt="' . $alt . '" />';
	}

	return $return;
}

// social add comment meta
function automobile_social_add_comment_meta( $comment_id ) {
	$social_login_comment_via_provider = isset( $_POST['social_login_comment_via_provider'] ) ? $_POST['social_login_comment_via_provider'] : '';
	if ( $social_login_comment_via_provider != '' ) {
		update_comment_meta( $comment_id, 'social_login_comment_via_provider', $social_login_comment_via_provider );
	}
}

add_action( 'comment_post', 'automobile_social_add_comment_meta' );

// social comment meta
function automobile_social_comment_meta( $link ) {
	global $comment;
	$images_url = get_template_directory_uri() . '/media/img/';
	if ( is_object( $comment ) ) {
		$social_login_comment_via_provider = get_comment_meta( $comment->comment_ID, 'social_login_comment_via_provider', true );
		if ( $social_login_comment_via_provider && current_user_can( 'manage_options' ) ) {
			return $link . '&nbsp;<img class="social_login_comment_via_provider" alt="' . $social_login_comment_via_provider . '" src="' . $images_url . $social_login_comment_via_provider . '_16.png"  />';
		} else {
			return $link;
		}
	}
	return $link;
}

add_action( 'get_comment_author_link', 'automobile_social_comment_meta' );

// social login form
function automobile_comment_form_social_login() {
	if ( comments_open() && ! is_user_logged_in() ) {
		automobile_social_login_form();
	}
}

// login page url
function automobile_login_page_uri() {
	global $automobile_form_fields;
	$automobile_opt_array = array(
		'id' => '',
		'cust_id' => 'social_login_form_uri',
		'std' => esc_url( site_url( 'wp-login.php', 'login_post' ) ),
		'cust_type' => 'hidden',
		'classes' => '',
	);

	$automobile_form_fields->automobile_form_text_render( $automobile_opt_array );
}

add_action( 'wp_footer', 'automobile_login_page_uri' );

// get user by meta key
function automobile_social_get_user_by_meta( $meta_key, $meta_value ) {
	global $wpdb;

	$sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
	return $wpdb->get_var( $wpdb->prepare( $sql, $meta_key, $meta_value ) );
}

// generate social signature
function automobile_social_generate_signature( $data ) {
	return hash( 'SHA256', AUTH_KEY . $data );
}

// login verify signature
function automobile_social_login_verify_signature( $data, $signature, $redirect_to ) {
	$generated_signature = automobile_social_generate_signature( $data );

	if ( $generated_signature != $signature ) {
		wp_safe_redirect( $redirect_to );
		exit();
	}
}

// get the contents of url
function automobile_http_get_contents( $url ) {
	global $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	$response = wp_remote_get( $url );
	if ( is_wp_error( $response ) ) {
		die( sprintf( esc_html( automobile_var_plugin_text_srt( 'automobile_var_something_went_wrong' ) ), $response->get_error_message() ) );
	} else {
		return $response['body'];
	}
}

// add custom styling
function automobile_add_stylesheets() {
	if ( is_admin() ) {
		if ( ! wp_style_is( 'social_login', 'registered' ) ) {

			wp_register_style( "social_login_css", plugins_url( 'media/css/cs-social-style.css', __FILE__ ) );
		}

		if ( did_action( 'wp_print_styles' ) ) {
			wp_print_styles( 'social_login' );
			wp_print_styles( 'wp-jquery-ui-dialog' );
		} else {
			wp_enqueue_style( "social_login" );
			wp_enqueue_style( "wp-jquery-ui-dialog" );
		}
	}
}

add_action( 'login_enqueue_scripts', 'automobile_add_stylesheets' );
add_action( 'wp_head', 'automobile_add_stylesheets' );

// add admin side styling
function automobile_add_admin_stylesheets() {
	if ( is_admin() ) {
		if ( ! wp_style_is( 'social_login', 'registered' ) ) {
			wp_register_style( "social_login_css", plugins_url( 'media/css/cs-social-style.css', __FILE__ ) );
		}

		if ( did_action( 'wp_print_styles' ) ) {
			wp_print_styles( 'social_login' );
		} else {
			wp_enqueue_style( "social_login" );
		}
	}
}

add_action( 'admin_print_styles', 'automobile_add_admin_stylesheets' );

// add javascripts files
function automobile_add_javascripts() {
	if ( is_admin() ) {
		$deps = array( 'jquery', 'jquery-ui-core', 'jquery-ui-dialog' );
		$wordpress_enabled = 0;


		if ( $wordpress_enabled ) {
			$deps[] = 'jquery-ui-dialog';
		}

		if ( ! wp_script_is( 'social_login_js', 'registered' ) )
			wp_register_script( 'social_login_js', plugins_url( 'media/js/cs-connect.js', __FILE__ ), $deps );

		wp_enqueue_script( 'social_login_js' );
		wp_localize_script( 'social_login_js', 'social_login_data', array( 'wordpress_enabled' => $wordpress_enabled ) );
	}
}

add_action( 'login_enqueue_scripts', 'automobile_add_javascripts' );
add_action( 'wp_enqueue_scripts', 'automobile_add_javascripts' );

// Twitter Callback

function automobile_twitter_callback() {
	global $automobile_var_plugin_options, $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();
	$consumer_key = isset( $automobile_var_plugin_options['automobile_consumer_key'] ) ? $automobile_var_plugin_options['automobile_consumer_key'] : '';
	$consumer_secret = isset( $automobile_var_plugin_options['automobile_consumer_secret'] ) ? $automobile_var_plugin_options['automobile_consumer_secret'] : '';
    $_SESSION['oauth_token'] = isset( $_SESSION['oauth_token'] ) ? $_SESSION['oauth_token'] : '';
	$_SESSION['oauth_token_secret'] = isset( $_SESSION['oauth_token_secret'] ) ? $_SESSION['oauth_token_secret'] : '';

	if ( ! class_exists( 'TwitterOAuth' ) ) {
		require_once automobile_var::plugin_dir() . 'includes/cs-twitter/twitteroauth.php';
	}
	$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );
	$access_token = $connection->getAccessToken( $_REQUEST['oauth_verifier'] );
	$_SESSION['access_token'] = $access_token;
	unset( $_SESSION['oauth_token'] );
	unset( $_SESSION['oauth_token_secret'] );
	if ( 200 == $connection->http_code ) {
		$_SESSION['status'] = 'verified';
		$user = $connection->get( 'account/verify_credentials' );
		$name = $user->name;
		$screen_name = $user->screen_name;
		$twitter_id = $user->id;
		$signature = automobile_social_generate_signature( $twitter_id );
		?>
		<html>
			<head>
				<script>
			    function init() {
				window.opener.wp_social_login({'action': 'social_login', 'social_login_provider': 'twitter',
				    'social_login_signature': '<?php echo esc_attr( $signature ) ?>',
				    'social_login_twitter_identity': '<?php echo esc_attr( $twitter_id ) ?>',
				    'social_login_screen_name': '<?php echo esc_attr( $screen_name ) ?>',
				    'social_login_name': '<?php echo esc_attr( $name ) ?>'});
				window.close();
			    }
				</script>
			</head>
			<body onLoad="init();">

			</body>
		</html>
		<?php
		exit;
	} else {

		echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_login_error' ) );
	}
}

// Twitter connect
function automobile_twitter_connect() {

	global $automobile_var_plugin_options, $automobile_var_plugin_static_text;
	$strings = new automobile_plugin_all_strings;
	$strings->automobile_var_plugin_login_strings();

	if ( ! class_exists( 'TwitterOAuth' ) ) {
		require_once automobile_var::plugin_dir() . 'includes/cs-twitter/twitteroauth.php';
	}

	$consumer_key = isset( $automobile_var_plugin_options['automobile_consumer_key'] ) ? $automobile_var_plugin_options['automobile_consumer_key'] : '';
	$consumer_secret = isset( $automobile_var_plugin_options['automobile_consumer_secret'] ) ? $automobile_var_plugin_options['automobile_consumer_secret'] : '';

	$twitter_oath_callback = home_url( 'index.php?social-login=twitter-callback' );
	if ( $consumer_key != '' && $consumer_secret != '' ) {
		$connection = new TwitterOAuth( $consumer_key, $consumer_secret );
		$request_token = $connection->getRequestToken( $twitter_oath_callback );
		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		switch ( $connection->http_code ) {
			case 200:
				$url = $connection->getAuthorizeURL( $token );
				wp_redirect( $url );
				break;
			default:
				echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_problem_connecting_to_twitter' ) );
		}
		exit();
	}
}

// Facebook Callback
/*
function automobile_facebook_callback() {
    global $automobile_var_plugin_options;

    require_once plugin_dir_url(__FILE__) . 'facebook/facebook.php';

    $client_id = $automobile_var_plugin_options['automobile_facebook_app_id'];
    $secret_key = $automobile_var_plugin_options['automobile_facebook_secret'];

    if (isset($_GET['code'])) {
        $code = $_GET['code'];
       
        parse_str(automobile_http_get_contents("https://graph.facebook.com/oauth/access_token?" .
                        'client_id=' . $client_id . '&redirect_uri=' . home_url('index.php?social-login=facebook-callback') .
                        '&client_secret=' . $secret_key .
                        '&code=' . urlencode($code)));
        $signature = automobile_social_generate_signature($access_token);
        do_action('social_login_before_register_facebook', $code, $signature, $access_token);
        ?>
        <html>
            <head>
                <script>
                    function init() {
                        window.opener.wp_social_login({'action': 'social_login', 'social_login_provider': 'facebook',
                            'social_login_signature': '<?php echo esc_attr($signature) ?>',
                            'social_login_access_token': '<?php echo esc_attr($access_token) ?>'});
                        window.close();
                    }
                </script>
            </head>
            <body onLoad="init();"></body>
        </html>
        <?php
    } else {
        $redirect_uri = urlencode(plugin_dir_url(__FILE__) . 'facebook/callback.php');
        wp_redirect('https://graph.facebook.com/oauth/authorize?client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&scope=email');
    }
}
 * 
 */