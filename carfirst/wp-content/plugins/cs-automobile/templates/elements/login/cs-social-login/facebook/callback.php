<?php
global $automobile_var_plugin_options;

require_once 'facebook.php';
 $client_id = isset($automobile_var_plugin_options['automobile_facebook_app_id']) ? $automobile_var_plugin_options['automobile_facebook_app_id'] : '';
 $secret_key = isset($automobile_var_plugin_options['automobile_facebook_secret']) ? $automobile_var_plugin_options['automobile_facebook_secret'] : '';


if (isset($_GET['code'])) {
    $code = $_GET['code'];
    /*
   var_dump((automobile_http_get_contents("https://graph.facebook.com/oauth/access_token?" .
                    'client_id=' . $client_id . '&redirect_uri=' . home_url('index.php?social-login=facebook-callback') .
                    '&client_secret=' . $secret_key .
                    '&code=' . urlencode($code)))); 
     * 
     */
   
   
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
    $redirect_uri = urlencode(plugin_dir_url(__FILE__) . 'callback.php');
    wp_redirect('https://graph.facebook.com/oauth/authorize?client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&scope=email');
}