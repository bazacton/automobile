<?php
if (!function_exists('pre')) {

    function pre($data, $is_exit = true) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($is_exit == true) {
            exit;
        }
    }

}
require_once trailingslashit(get_template_directory()) . 'assets/frontend/translate/cs-strings.php';
require_once trailingslashit(get_template_directory()) . 'include/cs-global_functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-global-variables.php';
include(get_template_directory() . '/include/cs-theme-functions.php');
$var_arrays = array('automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
/**
 * Auto Mobile only works in WordPress 4.4 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('automobile_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * Create your own automobile_setup() function to override in a child theme.
     *
     * @since Auto Mobile 1.0
     */
    function automobile_setup() {
        global $automobile_var_static_text;

        //for theme check 
        $defaults = array(
            'default-image' => '',
            'width' => 0,
            'height' => 0,
            'flex-height' => false,
            'flex-width' => false,
            'uploads' => true,
            'random-default' => false,
            'header-text' => true,
            'default-text-color' => '',
            'wp-head-callback' => '',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
        );
        add_theme_support('custom-header', $defaults);

        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        $defaults = array(
            'default-color' => '',
            'default-image' => '',
            'default-repeat' => '',
            'default-position-x' => '',
            'default-attachment' => '',
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => ''
        );
        add_theme_support('custom-background', $defaults);
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Auto Mobile, use a find and replace
         * to change 'automobile' to the name of your theme in all the template files
         */
        load_theme_textdomain('automobile', get_template_directory() . '/languages');

// Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999);

// This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => automobile_var_theme_text_srt('automobile_var_primary_menu'),
            'social' => automobile_var_theme_text_srt('automobile_var_social_links_menu'),
        ));
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style();

        global $pagenow;

        if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {

            if (!get_option('automobile_var_options')) {
                wp_redirect(admin_url('themes.php?page=install-required-plugins'));
            }
        }
        add_filter('the_password_form', 'automobile_password_form');
    }

endif; // automobile_setup
add_action('after_setup_theme', 'automobile_setup');

require_once ABSPATH . '/wp-admin/includes/file.php';

function search_widget_title($title) {
    if ($title == '') {
        return esc_html__("Search", 'automobile');
    } else {
        return $title;
    }
}

add_filter('widget_title', 'search_widget_title', 10, 1); //we use the default priority and 3 arguments in the callback function
/*
 * Include file function
 */
if (!function_exists('automobile_include_file')) {

    function automobile_include_file($file_path = '', $inc = false) {
        if ($file_path != '') {
            if ($inc == true) {
                include $file_path;
            } else {
                require_once $file_path;
            }
        }
    }

}

/**
 * stripslashes string
 *
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_var_stripslashes_htmlspecialchars')) {

    function automobile_var_stripslashes_htmlspecialchars($value) {
        $value = is_array($value) ? array_map('automobile_var_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
        return $value;
    }

}


if (!function_exists('automobile_var_date_picker')) {

    function automobile_var_date_picker() {
        global $automobile_barber_template_path;
        wp_enqueue_script('barber-admin-upload', $automobile_barber_template_path, array('jquery', 'media-upload'));
    }

}

/**
 * @Inline CSS
 *
 */
/*
  $language = $site->language();
  if($page->content($language->code())->language() == $site->language($language->code())) {
  echo 'test';exit;
  }
 * 
 */
if (!function_exists('automobile_var_inline_styles_method')) {

    function automobile_var_inline_styles_method() {
        global $automobile_var_global_custom_css;
        wp_enqueue_style('automobile-custom-style-inline-style', get_template_directory_uri() . '/assets/frontend/css/custom-style.css', '', '');
        $automobile_custom_css = '';
        $custom_css = $automobile_var_global_custom_css;
        wp_add_inline_style('custom-style-inline', $custom_css);
    }

}
/*
 * set image size function
 */

if (!function_exists('automobile_var_get_attachment_id')) {

    function automobile_var_get_attachment_id($attachment_url) {
        global $wpdb;
        $attachment_id = false;
        // If there is no url, return.
        if ('' == $attachment_url)
            return;
        // Get the upload directory paths 
        $upload_dir_paths = wp_upload_dir();
        if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {
            // If this is the URL of an auto-generated thumbnail, get the URL of the original image 
            $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
            // Remove the upload path base directory from the attachment URL 
            $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

            $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
        }
        return $attachment_id;
    }

}

/**
 * @Custom CSS
 *
 */
if (!function_exists('write_stylesheet_content')) {

    function write_stylesheet_content() {
        global $wp_filesystem, $automobile_var_options;
        require_once get_template_directory() . '/include/frontend/cs-theme-styles.php';
        $automobile_export_options = automobile_var_custom_style_theme_options();
        
        $fileStr = $automobile_export_options;
        $regex = array(
	    "`^([\t\s]+)`ism"=>'',
            "`^\/\*(.+?)\*\/`ism"=>"",
            //"`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
            //"`([\n\A;\s]+)\/(.+?)[\n\r]`ism"=>"$1\n",
            "`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
	);
        $newStr = preg_replace(array_keys($regex), $regex, $fileStr);
        $automobile_option_fields = $newStr;

        $backup_url = wp_nonce_url('themes.php?page=automobile_var_settings_page');
        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
            return true;
        }
        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $automobile_upload_dir = get_template_directory() . '/assets/frontend/css/';
        $automobile_filename = trailingslashit($automobile_upload_dir) . 'default-element.css';
        if (!$wp_filesystem->put_contents($automobile_filename, $automobile_option_fields, FS_CHMOD_FILE)) {
            
        }
    }

}


/*
 * Start function for Custom excerpt function
 */
if (!function_exists('automobile_get_excerpt')) {

    function automobile_get_excerpt($wordslength = '', $readmore = 'true', $readmore_text = 'Read More') {
        global $post, $automobile_var_options;
        if ($wordslength == '') {
            $wordslength = $automobile_var_options['automobile_var_excerpt_length'] ? $automobile_var_options['automobile_var_excerpt_length'] : '30';
        }
        $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_content()));

        if ($readmore == 'true') {
            $more = '..';
        } else {
            $more = '...';
        }
        $excerpt_new = wp_trim_words($excerpt, $wordslength, $more);

        return $excerpt_new;
    }

}

/**
 * @Fetch Attachment Path
 *
 */
if (!function_exists('automobile_attachment_image_src')) {

    function automobile_attachment_image_src($attachment_id, $width, $height) {
        $image_url = wp_get_attachment_image_src($attachment_id, array($width, $height), true);
        if ($image_url[1] == $width and $image_url[2] == $height) {
            
        } else {
            $image_url = wp_get_attachment_image_src($attachment_id, "full", true);
        }
        $parts = explode('/uploads/', $image_url[0]);
        if (count($parts) > 1) {
            return $image_url[0];
        }
    }

}

/**
 * Start Function how to check if Image Exists
 */
if (!function_exists('automobile_image_exist')) {

    function automobile_image_exist($sFilePath) {

        $img_formats = array("png", "jpg", "jpeg", "gif", "tiff"); //Etc. . . 
        $path_info = pathinfo($sFilePath);
        if (isset($path_info['extension']) && in_array(strtolower($path_info['extension']), $img_formats)) {
            if (!filter_var($sFilePath, FILTER_VALIDATE_URL) === false) {
                $automobile_file_response = wp_remote_get($sFilePath);
                if (is_array($automobile_file_response) && isset($automobile_file_response['headers']['content-type']) && strpos($automobile_file_response['headers']['content-type'], 'image') !== false) {
                    return true;
                }
            }
        }
        return false;
    }

}

/*
 * start function for custom pagination
 */
if (!function_exists('automobile_pagination')) {

    function automobile_pagination($total_records, $per_page, $qrystr = '', $show_pagination = 'Show Pagination', $page_var = 'paged') {

        if ($show_pagination <> 'Show Pagination') {
            return;
        } else if ($total_records < $per_page) {
            return;
        } else {

            $html = '';
            $dot_pre = '';

            $dot_more = '';

            $total_page = 0;
            if ($per_page <> 0)
                $total_page = ceil($total_records / $per_page);
            $page_id_all = 0;
            if (isset($_GET[$page_var]) && $_GET[$page_var] != '') {
                $page_id_all = $_GET[$page_var];
            }

            $loop_start = $page_id_all - 2;

            $loop_end = $page_id_all + 2;

            if ($page_id_all < 3) {

                $loop_start = 1;

                if ($total_page < 5)
                    $loop_end = $total_page;
                else
                    $loop_end = 5;
            }

            else if ($page_id_all >= $total_page - 1) {

                if ($total_page < 5)
                    $loop_start = 1;
                else
                    $loop_start = $total_page - 4;

                $loop_end = $total_page;
            }

            $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><nav class="navigation pagination" role="navigation"><div class="nav-links">';
            if ($page_id_all > 1) {
                $html .= '<a href="?page_id_all=' . ($page_id_all - 1) . $qrystr . '"  class="prev page-numbers">
				' . automobile_var_theme_text_srt('automobile_var_prev') . ' </a>';
            } else {
                $html .= '<a class="prev page-numbers">' . automobile_var_theme_text_srt('automobile_var_prev') . '</a>';
            }

            if ($page_id_all > 3 and $total_page > 5)
                $html .= '<a class="page-numbers" href="?page_id_all=1' . $qrystr . '">1</a>';

            if ($page_id_all > 4 and $total_page > 6)
                $html .= '<a>. . .</a>';

            if ($total_page > 1) {

                for ($i = $loop_start; $i <= $loop_end; $i ++) {

                    if ($i <> $page_id_all)
                        $html .= '<a class="page-numbers" href="?page_id_all=' . $i . $qrystr . '">' . $i . '</a>';
                    else
                        $html .= '<span class="page-numbers current">' . $i . '</span>';
                }
            }

            if ($loop_end <> $total_page and $loop_end <> $total_page - 1) {
                $html .= '<a>. . .</a>';
            }

            if ($loop_end <> $total_page) {
                $html .= '<a href="?page_id_all={' . $total_page . '}{' . $qrystr . '}">' . $total_page . '</a>';
            }
            if ($per_page > 0 and $page_id_all < ($total_records / $per_page)) {

                $html .= '<a class="next page-numbers" href="?page_id_all=' . ($page_id_all + 1) . $qrystr . '" >' . automobile_var_theme_text_srt('automobile_var_next') . '</a>';
            } else {
                $html .= '<a class="next page-numbers">' . automobile_var_theme_text_srt('automobile_var_next') . ' </a>';
            }
            $html .= "</div></nav></div>";
            return $html;
        }
    }

}


/**
 * @Fetch Attachment Path
 *
 */
if (!function_exists('automobile_attachment_image_id')) {

    function automobile_attachment_image_id($attachment_id) {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment_id));
        return isset($attachment[0]) ? $attachment[0] : '';
    }

}
/**
 * Including the required files
 *
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_require_theme_files')) {

    function automobile_require_theme_files($automobile_path = '') {

        global $wp_filesystem;

        $backup_url = '';

        if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

            return true;
        }

        if (!WP_Filesystem($creds)) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }

        $automobile_sh_front_dir = trailingslashit(get_template_directory()) . $automobile_path;

        $automobile_all_f_list = $wp_filesystem->dirlist($automobile_sh_front_dir);

        if (is_array($automobile_all_f_list) && sizeof($automobile_all_f_list) > 0) {

            foreach ($automobile_all_f_list as $file_key => $file_val) {

                if (isset($file_val['name'])) {

                    $automobile_file_name = $file_val['name'];

                    $automobile_ext = pathinfo($automobile_file_name, PATHINFO_EXTENSION);

                    if ($automobile_ext == 'php') {
                        require_once trailingslashit(get_template_directory()) . $automobile_path . $automobile_file_name;
                    }
                }
            }
        }
    }

}

/**
 * @Get sidebar name id
 *
 */
if (!function_exists('automobile_get_sidebar_id')) {

    function automobile_get_sidebar_id($automobile_page_sidebar_left = '') {

        return sanitize_title($automobile_page_sidebar_left);
    }

}

/**
 * Theme necessary
 * Files require.
 *
 * @since Auto Mobile 1.0
 */
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/cs-require-plugins.php';
require_once trailingslashit(get_template_directory()) . 'include/cs-class-parse.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-custom-fields/cs-form-fields.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-custom-fields/cs-html-fields.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-admin-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-googlefont/cs-fonts-array.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-googlefont/cs-fonts.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-googlefont/cs-fonts-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/import/cs-class-widget-data.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-flickr.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-twitter.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-facebook.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-mailchimp.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-recent-posts.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-ads.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-custom-menu-widget.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options-fields.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options-arrays.php';
require_once trailingslashit(get_template_directory()) . 'include/frontend/cs-header.php';
#Blogs
require_once trailingslashit(get_template_directory()) . 'template-parts/blog/blog_element.php';
require_once trailingslashit(get_template_directory()) . 'template-parts/blog/blog_functions.php';

# Files
require_once trailingslashit(get_template_directory()) . 'include/backend/theme-config.php';
require_once trailingslashit(CS_BASE) . 'include/backend/importer-hooks.php';

if (class_exists('woocommerce')) {
    require_once trailingslashit(get_template_directory()) . 'include/backend/cs-woocommerce/cs-config.php';
}
// shortcodes files
automobile_require_theme_files('include/backend/cs-shortcodes/');
automobile_require_theme_files('include/frontend/cs-shortcodes/');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_content_width')) {

    function automobile_content_width() {
        $GLOBALS['content_width'] = apply_filters('automobile_content_width', 840);
    }

}
add_action('after_setup_theme', 'automobile_content_width', 0);

/**
 * @MailChimp
 */
if (!function_exists('automobile_mailchimp')) {

    add_action('wp_ajax_nopriv_automobile_mailchimp', 'automobile_mailchimp');
    add_action('wp_ajax_automobile_mailchimp', 'automobile_mailchimp');

    function automobile_mailchimp() {
        global $automobile_var_options, $counter, $automobile_var_static_text;
        $mailchimp_key = '';
        if (isset($automobile_var_options['automobile_var_mailchimp_key'])) {
            $mailchimp_key = $automobile_var_options['automobile_var_mailchimp_key'];
        }
        if (isset($automobile_var_options['automobile_var_mailchimp_list'])) {
            $automobile_list_id = $automobile_var_options['automobile_var_mailchimp_list'];
        }
        if (isset($_POST) and ! empty($automobile_list_id) and $mailchimp_key != '') {
            if ($mailchimp_key <> '') {
                $MailChimp = new MailChimp($mailchimp_key);
            }
            $email = $_POST['mc_email'];
            $list_id = $automobile_list_id;
            $result = $MailChimp->call('lists/subscribe', array(
                'id' => $list_id,
                'email' => array('email' => $email),
                'merge_vars' => array(),
                'double_optin' => false,
                'update_existing' => false,
                'replace_interests' => false,
                'send_welcome' => true,
            ));
            if ($result <> '') {
                if (isset($result['status']) and $result['status'] == 'error') {
                    echo automobile_allow_special_char($result['error']);
                } else {
                    echo automobile_var_theme_text_srt('automobile_var_subscribe_success');
                }
            }
        } else {
            echo automobile_var_theme_text_srt('automobile_var_api_set_msg');
        }
        die();
    }

}

/**
 * @Allow Special Characters
 *
 */
if (!function_exists('automobile_var_special_char')) {

    function automobile_var_special_char($input = '') {
        $output = $input;
        return $output;
    }

}

/*
 * Start tool tip text asaign function
 */
if (!function_exists('automobile_var_tooltip_text')) {

    function automobile_var_tooltip_text($popover_text = '', $return_html = true) {
        $popover_link = '';
        if (isset($popover_text) && $popover_text != '') {
            $popover_link = '<a class="cs-help" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="' . $popover_text . '"><i class="icon-help"></i></a>';
        }
        if ($return_html == true) {
            return automobile_var_special_char($popover_link);
        } else {
            echo automobile_var_special_char($popover_link);
        }
    }

}
/*
 *  End tool tip text asaign function
 */

/**
 * @Social Networks Detail
 *
 */
if (!function_exists('automobile_var_social_network')) {

    function automobile_var_social_network($icon_type = '', $tooltip = '') {
        global $automobile_var_options;
        $tooltip_data = '';
        if ($icon_type == 'large') {
            $icon = 'icon-2x';
        } else {

            $icon = '';
        }
        if (isset($tooltip) && $tooltip <> '') {
            $tooltip_data = 'data-placement-tooltip="tooltip"';
        }
        if (isset($automobile_var_options['automobile_var_social_net_url']) and count($automobile_var_options['automobile_var_social_net_url']) > 0) {
            $i = 0;
            ?>
            <ul>
                <?php
                if (is_array($automobile_var_options['automobile_var_social_net_url'])):
                    foreach ($automobile_var_options['automobile_var_social_net_url'] as $val) {

                        if ($val != '') {
                            ?>      
                            <li>
                                <a href="<?php echo esc_url($val); ?>" data-original-title="<?php echo automobile_allow_special_char($automobile_var_options['automobile_var_social_net_tooltip'][$i]); ?>" data-placement="top" <?php echo automobile_allow_special_char($tooltip_data, false); ?> class="colrhover"  target="_blank">
                                    <?php if ($automobile_var_options['automobile_var_social_net_awesome'][$i] <> '' && isset($automobile_var_options['automobile_var_social_net_awesome'][$i])) { ?>
                                        <i class="fa <?php echo esc_attr($automobile_var_options['automobile_var_social_net_awesome'][$i]); ?> <?php echo esc_attr($icon); ?>"></i>

                                    <?php } else { ?>
                                        <img title="<?php echo esc_attr($automobile_var_options['automobile_var_social_net_tooltip'][$i]); ?>" src="<?php echo esc_url($automobile_var_options['automobile_var_social_icon_path_array'][$i]); ?>" alt="<?php echo esc_attr($automobile_var_options['automobile_var_social_net_tooltip'][$i]); ?>" />
                            <?php } ?>
                                </a>
                            </li>
                            <?php
                        }
                        $i ++;
                    }
                endif;
                ?>
            </ul>
            <?php
        }
    }

}


/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_widgets_init')) {

    function automobile_widgets_init() {

        global $automobile_var_options, $automobile_var_static_text;

        /**
         * @If Theme Activated
         */
        if (get_option('automobile_var_options')) {
            if (isset($automobile_var_options['automobile_var_sidebar']) && !empty($automobile_var_options['automobile_var_sidebar'])) {
                foreach ($automobile_var_options['automobile_var_sidebar'] as $sidebar) {
                    $sidebar_id = sanitize_title($sidebar);

                    $automobile_widget_start = '<div class="widget %2$s">';
                    $automobile_widget_end = '</div>';
                    if (isset($automobile_var_options['automobile_var_footer_widget_sidebar']) && $automobile_var_options['automobile_var_footer_widget_sidebar'] == $sidebar) {

                        $automobile_widget_start = '<aside class="widget col-lg-4 col-md-4 col-sm-6 col-xs-12 %2$s">';
                        $automobile_widget_end = '</aside>';
                    }
                    register_sidebar(array(
                        'name' => $sidebar,
                        'id' => $sidebar_id,
                        'description' => automobile_var_theme_text_srt('automobile_var_widget_display_text'),
                        'before_widget' => $automobile_widget_start,
                        'after_widget' => $automobile_widget_end,
                        'before_title' => '<div class="widget-title"><h5>',
                        'after_title' => '</h5></div>'
                    ));
                }
            }

            $sidebar_name = '';
            if (isset($automobile_var_options['automobile_var_footer_sidebar']) && !empty($automobile_var_options['automobile_var_footer_sidebar'])) {
                $i = 0;
                foreach ($automobile_var_options['automobile_var_footer_sidebar'] as $automobile_var_footer_sidebar) {

                    $footer_sidebar_id = sanitize_title($automobile_var_footer_sidebar);
                    $sidebar_name = isset($automobile_var_options['automobile_var_footer_width']) ? $automobile_var_options['automobile_var_footer_width'] : '';
                    $automobile_sidebar_name = isset($sidebar_name[$i]) ? $sidebar_name[$i] : '';
                    $custom_width = str_replace('(', ' - ', $automobile_sidebar_name);
                    $automobile_widget_start = '<div class="widget %2$s">';
                    $automobile_widget_end = '</div>';

                    if (isset($automobile_var_options['automobile_var_footer_widget_sidebar']) && $automobile_var_options['automobile_var_footer_widget_sidebar'] == $automobile_var_footer_sidebar) {

                        $automobile_widget_start = '<aside class="widget col-lg-4 col-md-4 col-sm-6 col-xs-12 %2$s">';
                        $automobile_widget_end = '</aside>';
                    }

                    register_sidebar(array(
                        'name' => automobile_var_theme_text_srt('automobile_var_footer') . $automobile_var_footer_sidebar . ' ' . '(' . $custom_width . ' ',
                        'id' => $footer_sidebar_id,
                        'description' => automobile_var_theme_text_srt('automobile_var_widget_display_text'),
                        'before_widget' => $automobile_widget_start,
                        'after_widget' => $automobile_widget_end,
                        'before_title' => '<div class="widget-title"><h5>',
                        'after_title' => '</h5></div>'
                    ));
                    $i ++;
                }
            }
        } else {
            register_sidebar(array(
                'name' => automobile_var_theme_text_srt('automobile_var_widgets'),
                'id' => 'sidebar-1',
                'description' => automobile_var_theme_text_srt('automobile_var_widget_display_right_text'),
                'before_widget' => '<div class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h5>',
                'after_title' => '</h5></div>'
            ));
        }
    }

}

add_action('widgets_init', 'automobile_widgets_init');


/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_javascript_detection')) {

    function automobile_javascript_detection() {
        echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
    }

    add_action('wp_head', 'automobile_javascript_detection', 0);
}

/**
 * Default Pages title.
 *
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_post_page_title')) {

    function automobile_post_page_title() {
        global $author, $automobile_var_static_text;

        $automobile_var_search_result = automobile_var_theme_text_srt('automobile_var_search_result');
        $automobile_var_author = automobile_var_theme_text_srt('automobile_var_author');
        $automobile_var_archives = automobile_var_theme_text_srt('automobile_var_archives');
        $automobile_var_daily_archives = automobile_var_theme_text_srt('automobile_var_daily_archives');
        $automobile_var_monthly_archives = automobile_var_theme_text_srt('automobile_var_monthly_archives');
        $automobile_var_yearly_archives = automobile_var_theme_text_srt('automobile_var_yearly_archives');
        $automobile_var_tags = automobile_var_theme_text_srt('automobile_var_tags');
        $automobile_var_category = automobile_var_theme_text_srt('automobile_var_category');
        $automobile_var_error_404 = automobile_var_theme_text_srt('automobile_var_error_404');
        $automobile_var_home = automobile_var_theme_text_srt('automobile_var_home');
        $userdata = get_userdata($author);
        if (is_author()) {
            $automobile_var_search_result = automobile_var_theme_text_srt('automobile_var_search_result');
            $automobile_var_author = automobile_var_theme_text_srt('automobile_var_author');
            $automobile_var_archives = automobile_var_theme_text_srt('automobile_var_archives');
            $automobile_var_daily_archives = automobile_var_theme_text_srt('automobile_var_daily_archives');
            $automobile_var_monthly_archives = automobile_var_theme_text_srt('automobile_var_monthly_archives');
            $automobile_var_yearly_archives = automobile_var_theme_text_srt('automobile_var_yearly_archives');
            $automobile_var_tags = automobile_var_theme_text_srt('automobile_var_tags');
            $automobile_var_error_404 = automobile_var_theme_text_srt('automobile_var_error_404');
            $automobile_var_home = automobile_var_theme_text_srt('automobile_var_home');
            $userdata = get_userdata($author);
            echo esc_html($automobile_var_author) . " " . $automobile_var_archives . ": " . $userdata->display_name;
        } elseif (is_tag()) {
            echo esc_html($automobile_var_tags) . " " . $automobile_var_archives . ": " . single_cat_title('', false);
        } elseif (is_category()) {
            echo esc_html($automobile_var_category) . " " . $automobile_var_archives . ": " . single_cat_title('', false);
        } elseif (is_search()) {

            printf($automobile_var_search_result, '<span>' . get_search_query() . '</span>');
        } elseif (is_day()) {
            printf($automobile_var_daily_archives, '<span>' . get_the_date() . '</span>');
        } elseif (is_month()) {
            printf($automobile_var_monthly_archives, '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'automobile')) . '</span>');
        } elseif (is_year()) {
            printf($automobile_var_yearly_archives, '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'automobile')) . '</span>');
        } elseif (is_404()) {
            echo esc_attr($automobile_var_error_404);
        } elseif (is_home()) {
            echo esc_html($automobile_var_home);
        } elseif (is_page() || is_singular()) {
            echo get_the_title();
        } elseif (function_exists('is_shop') && is_shop()) {
            $automobile_var_post_ID = wc_get_page_id('shop');
            echo get_the_title($automobile_var_post_ID);
        } elseif (is_archive()) {

            $temp_query = get_queried_object();
            if (isset($temp_query->taxonomy) && $temp_query->taxonomy == 'inventory-make') {
                $inventory_make = isset($temp_query->name) ? $temp_query->name : '';
                printf(__('Inventory Make: %s', 'automobile'), $inventory_make);
            } else {
                echo esc_html($automobile_var_archives);
            }
        }
    }

}
/**
 * @Breadcrumb Function
 *
 */
if (!function_exists('automobile_breadcrumbs')) {

    function automobile_breadcrumbs($automobile_border = '') {
        global $wp_query, $automobile_var_options, $post, $automobile_var_static_text;
        /* === OPTIONS === */
        $automobile_var_current_page = automobile_var_theme_text_srt('automobile_var_current_page');
        $automobile_var_error_404 = automobile_var_theme_text_srt('automobile_var_error_404');
        $automobile_var_home = automobile_var_theme_text_srt('automobile_var_home');


        $text['home'] = esc_html($automobile_var_home); // text for the 'Home' link
        $text['category'] = '%s'; // text for a category page
        $text['search'] = '%s'; // text for a search results page
        $text['tag'] = '%s'; // text for a tag page
        $text['author'] = '%s'; // text for an author page
        $text['404'] = esc_attr($automobile_var_error_404); // text for the 404 page

        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter = ''; // delimiter between crumbs
        $before = '<li class="active">'; // tag before the current crumb
        $after = '</li>'; // tag after the current crumb
        /* === END OF OPTIONS === */
        $current_page = $automobile_var_current_page;
        $homeLink = home_url() . '/';
        $linkBefore = '<li>';
        $linkAfter = '</li>';
        $linkAttr = '';
        $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
        $linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

        $automobile_border_style = $automobile_border != '' ? ' style="border-top: 1px solid ' . $automobile_border . ';"' : '';

        if (is_home() || is_front_page()) {

            if ($showOnHome == "1")
                echo '<div' . $automobile_border_style . ' class="breadcrumbs page-title-align-center"><ul>' . $before . '<a href="' . $homeLink . '">' . $text['home'] . '</a>' . $after . '</ul></div>';
        } else {
            echo '<div' . $automobile_border_style . ' class="breadcrumbs pull-right"><ul>' . sprintf($linkhome, $homeLink, $text['home']) . $delimiter;
            if (is_category()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo automobile_allow_special_char($cats);
                }
                echo automobile_allow_special_char($before) . sprintf($text['category'], single_cat_title('', false)) . automobile_allow_special_char($after);
            } elseif (is_search()) {

                echo automobile_allow_special_char($before) . sprintf($text['search'], get_search_query()) . $after;
            } elseif (is_day()) {

                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                echo automobile_allow_special_char($before) . get_the_time('d') . $after;
            } elseif (is_month()) {

                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo automobile_allow_special_char($before) . get_the_time('F') . $after;
            } elseif (is_year()) {

                echo automobile_allow_special_char($before) . get_the_time('Y') . $after;
            } elseif (is_single() && !is_attachment()) {

                if (function_exists("is_shop") && get_post_type() == 'product') {
                    $automobile_shop_page_id = wc_get_page_id('shop');
                    $current_page = get_the_title(get_the_id());
                    $automobile_shop_page = "<li><a href='" . esc_url(get_permalink($automobile_shop_page_id)) . "'>" . get_the_title($automobile_shop_page_id) . "</a></li>";
                    echo automobile_allow_special_char($automobile_shop_page);
                    if ($showCurrent == 1)
                        echo automobile_allow_special_char($before) . $current_page . $after;
                }
                else if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                    if ($showCurrent == 1)
                        echo automobile_allow_special_char($delimiter) . $before . $current_page . $after;
                } else {

                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    if ($showCurrent == 0)
                        $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo automobile_allow_special_char($cats);

                    if ($showCurrent == 1)
                        echo automobile_allow_special_char($before) . $current_page . $after;
                }
            } elseif (!is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && !is_404()) {

                $post_type = get_post_type_object(get_post_type());
                echo automobile_allow_special_char($before) . $post_type->labels->singular_name . $after;
            } elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])) {

                $taxonomy = $taxonomy_category = '';
                $taxonomy = $wp_query->query_vars['taxonomy'];
                echo automobile_allow_special_char($before) . $taxonomy . $after;
            } elseif (is_page() && !$post->post_parent) {

                if ($showCurrent == 1)
                    echo automobile_allow_special_char($before) . get_the_title() . $after;
            } elseif (is_page() && $post->post_parent) {

                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i ++) {
                    echo automobile_allow_special_char($breadcrumbs[$i]);
                    if ($i != count($breadcrumbs) - 1)
                        echo automobile_allow_special_char($delimiter);
                }
                if ($showCurrent == 1)
                    echo automobile_allow_special_char($delimiter . $before . get_the_title() . $after);
            } elseif (is_tag()) {

                echo automobile_allow_special_char($before) . sprintf($text['tag'], single_tag_title('', false)) . $after;
            } elseif (is_author()) {

                global $author;
                $userdata = get_userdata($author);
                echo automobile_allow_special_char($before) . sprintf($text['author'], $userdata->display_name) . $after;
            } elseif (is_404()) {

                echo automobile_allow_special_char($before) . $text['404'] . $after;
            }
            echo '</ul></div>';
        }
    }

}
/**
 * Enqueues scripts and styles.
 *
 * @since Auto Mobile 1.0
 */
if (!function_exists('automobile_var_scripts')) {

    function automobile_var_scripts() {
        global $automobile_var_options;
        $theme_version = automobile_get_theme_version();
        wp_enqueue_style('automobile_google_fonts', 'https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap');
        wp_enqueue_style('bootstrap-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/bootstrap.css', array(), $theme_version);

        wp_enqueue_style('bootstrap-theme-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/bootstrap-theme.css', array('bootstrap-style'), $theme_version);
        wp_enqueue_style('automobile-iconmoon-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/iconmoon.css', array('bootstrap-theme-style'), $theme_version);
        wp_enqueue_style('chosen-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/chosen.css', array('automobile-iconmoon-style'), $theme_version);
        // Theme stylesheet.
        wp_enqueue_style('automobile-style', get_stylesheet_uri(), array(), $theme_version);
        wp_enqueue_style('automobile-widget-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/widget.css', array('automobile-style'), $theme_version);
        // wp_enqueue_style('automobile-responsive-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/responsive.css', array('automobile-widget-style'), $theme_version);

        if (class_exists('woocommerce')) {
            wp_enqueue_style('automobile-woocommerce', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/woocommerce.css', array(), $theme_version);
        }

        // color style 
        $custom_style_ver = (isset($automobile_var_options['automobile_var_theme_option_save_flag'])) ? $automobile_var_options['automobile_var_theme_option_save_flag'] : '';
        wp_enqueue_style('automobile-default-element-style', get_template_directory_uri() . '/assets/frontend/css/default-element.css', '', $custom_style_ver);
        // Load the html5 shiv.
        wp_enqueue_script('html5-script', 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', array(), '3.7.3');
        wp_script_add_data('html5-script', 'conditional', 'lt IE 9');
        // Load the html5 shiv.
        wp_enqueue_script('automobile-respond-script', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', array(), '3.7.3');
        wp_script_add_data('automobile-respond-script', 'conditional', 'lt IE 9');
        wp_enqueue_script('modernizr-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/modernizr.js', array('jquery'), '3.7.3');
        wp_enqueue_script('bootstrap-min-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/bootstrap.min.js', array(), '3.7.3');
        wp_enqueue_script('jquery-fitvids', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/jquery.fitvids.js', '', '', true);
        wp_enqueue_script('automobile-responsive-menu-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/responsive.menu.js', '', '', true);
        wp_enqueue_script('automobile-chosen-select-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/chosen.select.js', '', '', true);
        wp_enqueue_script('slick-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/slick.js', '', '', true);
        wp_enqueue_script('automobile-echo-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/echo.js', '', '', true);
        wp_enqueue_script('automobile-functions-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/functions.js', '', $theme_version, true);
        wp_enqueue_script('automobile-counter-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/counter.js', '', '', true);
        wp_enqueue_script('automobile-count-down-script', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/jquery.countdown.js', '', '', true);
        wp_enqueue_script('automobile-map-styles', trailingslashit(get_template_directory_uri()) . 'assets/backend/scripts/cs-map_styles.js', '', '', true);
        wp_enqueue_script('automobile-lazy-sizes-image', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/lazy-sizes-image.js', array('jquery'), true);

        if (is_singular() && get_comments_number()) {
            wp_enqueue_script('comment-reply');
        }
        if (!function_exists('automobile_var_dynamic_scripts')) {

            function automobile_var_dynamic_scripts($automobile_js_key, $automobile_arr_key, $automobile_js_code) {
                // Register the script
                wp_register_script('automobile_dynamic_scripts', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/cs-inline-scripts-functions.js', '', '', true);
                // Localize the script
                $automobile_code_array = array(
                    $automobile_arr_key => $automobile_js_code
                );
                wp_localize_script('automobile_dynamic_scripts', $automobile_js_key, $automobile_code_array);
                wp_enqueue_script('automobile_dynamic_scripts');

                wp_enqueue_style('automobile_dynamic_scripts');
            }

        }

        if (!function_exists('automobile_enqueue_google_map')) {

            function automobile_enqueue_google_map() {
                global $automobile_var_options;
                $google_api_key = '?libraries=places';
                if (isset($automobile_var_options['automobile_var_google_api_key']) && $automobile_var_options['automobile_var_google_api_key'] != '') {
                    $google_api_key = '?key=' . $automobile_var_options['automobile_var_google_api_key'] . '&libraries=places';
                }
                wp_enqueue_script('automobile-google-autocomplete-script', 'https://maps.googleapis.com/maps/api/js' . $google_api_key);
            }

        }

        /* include rtl css file */
        /*
          if (is_rtl()) {
          wp_enqueue_style('automobile-rtl-css', get_template_directory_uri() . '/assets/frontend/css/rtl.css');
          }
         */
    }

    add_action('wp_enqueue_scripts', 'automobile_var_scripts', 1);
}

if (!function_exists('automobile_var_scripts_low_per')) {

    function automobile_var_scripts_responsive() {
        global $automobile_var_options;
        $theme_version = automobile_get_theme_version();
        /* include rtl css file */
        if (is_rtl()) {
            wp_enqueue_style('automobile-rtl-css', get_template_directory_uri() . '/assets/frontend/css/rtl.css');
        }
        wp_enqueue_style('automobile-responsive-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/responsive.css', array('automobile-widget-style'), $theme_version);
    }

    add_action('wp_enqueue_scripts', 'automobile_var_scripts_responsive', 4);
}


if (!function_exists('automobile_var_admin_scripts_enqueue')) {

    function automobile_var_admin_scripts_enqueue() {
        $theme_version = automobile_get_theme_version();
        if (is_admin()) {
            global $automobile_var_template_path;
            $automobile_var_template_path = trailingslashit(get_template_directory_uri()) . 'assets/backend/scripts/cs-media-upload.js';

            //wp_enqueue_style('cs-automobile-responsive-style', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/responsive.css', array('cs-automobile-widget-style'), $theme_version);
            wp_enqueue_style('fonticonpicker-style', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/css/jquery.fonticonpicker.min.css', array('bootstrap-theme-style'), $theme_version);
            wp_enqueue_style('automobile-fonticonpicker');
            wp_enqueue_style('automobile-iconmoon-style', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/css/iconmoon.css');
            wp_enqueue_style('fonticonpicker-bootstrap', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css');
            wp_enqueue_style('chosen-style', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/chosen.css');
            wp_enqueue_style('automobile-admin-style', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/cs-admin-style.css');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_style('automobile_admin_google_fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900');
            wp_enqueue_style('automobile_admin_google_fonts_lato', 'https://fonts.googleapis.com/css?family=Lato:400,100,300,700,900');
            wp_enqueue_style('automobile_admin_google_fonts_sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600&subset=latin,cyrillic-ext');

            // all js script
            wp_enqueue_media();
            wp_enqueue_script('admin-upload', $automobile_var_template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
            wp_enqueue_script('fonticonpicker-script', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/js/jquery.fonticonpicker.min.js');
            wp_enqueue_script('bootstrap_min_script', trailingslashit(get_template_directory_uri()) . 'assets/backend/scripts/bootstrap.min.js', '', '', true);

            wp_enqueue_style('jquery-datetimepicker-style', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/jquery_datetimepicker.css');
            wp_enqueue_style('jquery_datepicker-css', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/datepicker.css');
            wp_enqueue_style('jquery_ui_date_picker-css', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/jquery_ui_datepicker_theme.css');
            wp_enqueue_script('jquery-datetimepicker-script', trailingslashit(get_template_directory_uri()) . 'assets/backend/scripts/jquery_datetimepicker.js');

            wp_enqueue_script('automobile-theme-options', trailingslashit(get_template_directory_uri()) . 'assets/backend/scripts/cs-theme-option-fucntions.js', '', '', true);
            wp_enqueue_script('automobile-chosen-select-script', trailingslashit(get_template_directory_uri()) . 'assets/backend/scripts/chosen.select.js', '', '', true);
            wp_enqueue_script('automobile-custom-functions', trailingslashit(get_template_directory_uri()) . 'assets/backend/scripts/cs-fucntions.js', '', $theme_version, true);

            ////editor script
            wp_enqueue_script('editor-script', trailingslashit(get_template_directory_uri()) . 'assets/backend/editor/scripts/jquery-te-1.4.0.min.js');
            wp_enqueue_style('editor-style', trailingslashit(get_template_directory_uri()) . 'assets/backend/editor/css/jquery-te-1.4.0.css');

            if (!function_exists('automobile_var_date_picker')) {

                function automobile_var_date_picker() {
                    global $automobile_var_template_path;
                    wp_enqueue_script('automobile-admin-upload', $automobile_var_template_path, array('jquery', 'media-upload'));
                }

            }
        }
    }

    add_action('admin_enqueue_scripts', 'automobile_var_admin_scripts_enqueue');
}
/**
 * Adds custom classes to the array of body classes.
 *
 * @since Auto Mobile 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
if (!function_exists('automobile_body_classes')) {

    function automobile_body_classes($classes) {

        global $automobile_var_options;
        $classes[] = 'wp-automobile';
        // Adds a class of custom-background-image to sites with a custom background image.
        if (get_background_image()) {
            $classes[] = 'custom-background-image';
        }
        // Adds a class of group-blog to sites with more than 1 published author.
        if (is_multi_author()) {
            $classes[] = 'group-blog';
        }

        // Adds a class of no-sidebar to sites without active sidebar.

        $automobile_page_layout = get_post_meta(get_the_ID(), 'automobile_var_page_layout', true);

        if ($automobile_page_layout == 'none') {
            //     if (!is_active_sidebar('sidebar-1')) {
            $classes[] = 'no-sidebar';
            //    }
        }
        // Adds a class of hfeed to non-singular pages.
        if (!is_singular()) {
            $classes[] = 'hfeed';
        }

        $automobile_var_res_cls = (isset($automobile_var_options['automobile_var_responsive']) && $automobile_var_options['automobile_var_responsive'] == "on") ? 'cbp-spmenu-push' : 'non-responsive';

        $classes[] = $automobile_var_res_cls;

        return $classes;
    }

    add_filter('body_class', 'automobile_body_classes');
}

/**
 * Converts a HEX value to RGB.
 *
 * @since Auto Mobile 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 * HEX code, empty array otherwise.
 */
if (!function_exists('automobile_hex2rgb')) {

    function automobile_hex2rgb($color) {
        $color = trim($color, '#');

        if (strlen($color) === 3) {
            $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
            $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
            $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
        } else if (strlen($color) === 6) {
            $r = hexdec(substr($color, 0, 2));
            $g = hexdec(substr($color, 2, 2));
            $b = hexdec(substr($color, 4, 2));
        } else {
            return array();
        }

        return array('red' => $r, 'green' => $g, 'blue' => $b);
    }

}
/*
 * RevSlider Extend Class 
 */

if (!class_exists('automobile_var_RevSlider')) {
    if (class_exists('RevSlider')) {

        class automobile_var_RevSlider extends RevSlider {

            /**
             * @Get Sliders Alias, Title, ID
             *
             */
            public function getAllSliderAliases() {
                $arrAliases = array();
                $slider_array = array();

                $slider = new RevSlider();

                if (method_exists($slider, "get_sliders")) {
                    $slider = new RevSlider();
                    $objSliders = $slider->get_sliders();

                    foreach ($objSliders as $arrSlider) {
                        $arrAliases['id'] = $arrSlider->id;
                        $arrAliases['title'] = $arrSlider->title;
                        $arrAliases['alias'] = $arrSlider->alias;
                        $slider_array[] = $arrAliases;
                    }
                } else {
                    $where = "";
                    $response = $this->db->fetch(GlobalsRevSlider::$table_sliders, $where, "id");
                    foreach ($response as $arrSlider) {
                        $arrAliases['id'] = $arrSlider["id"];
                        $arrAliases['title'] = $arrSlider["title"];
                        $arrAliases['alias'] = $arrSlider["alias"];
                        $slider_array[] = $arrAliases;
                    }
                }
                return($slider_array);
            }

        }

    }
}

if (!function_exists('automobile_change_query_vars')) {

    function automobile_change_query_vars($query) {
        if (!is_admin()) {
            if (!function_exists('is_shop')) {
                if (is_search() || is_home() || is_archive()) {
                    if (empty($_GET['page_id_all'])) {
                        $_GET['page_id_all'] = 1;
                    }
                    $query->query_vars['paged'] = $_GET['page_id_all'];
                    return $query;
                }
            } else {
                if ((is_search() || is_home() || is_archive()) && !is_shop() && !is_product_taxonomy() && !is_author()) {
                    if (empty($_GET['page_id_all'])) {
                        $_GET['page_id_all'] = 1;
                    }
                    $query->query_vars['paged'] = $_GET['page_id_all'];
                    return $query;
                }
            }
        }
    }

    add_filter('pre_get_posts', 'automobile_change_query_vars');
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Auto Mobile 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
if (!function_exists('automobile_content_image_sizes_attr')) {

    function automobile_content_image_sizes_attr($sizes, $size) {
        $width = $size[0];

        840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

        if ('page' === get_post_type()) {
            840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
        } else {
            840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
            600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
        }

        return $sizes;
    }

    add_filter('wp_calculate_image_sizes', 'automobile_content_image_sizes_attr', 10, 2);
}
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Auto Mobile 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
if (!function_exists('automobile_post_thumbnail_sizes_attr')) {

    function automobile_post_thumbnail_sizes_attr($attr, $attachment, $size) {
        if ('post-thumbnail' === $size) {
            is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
            !is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
        }
        return $attr;
    }

    add_filter('wp_get_attachment_image_attributes', 'automobile_post_thumbnail_sizes_attr', 10, 3);
}

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Auto Mobile 1.0
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
if (!function_exists('automobile_widget_tag_cloud_args')) {

    function automobile_widget_tag_cloud_args($args) {
        $args['largest'] = 1;
        $args['smallest'] = 1;
        $args['unit'] = 'em';
        return $args;
    }

    add_filter('widget_tag_cloud_args', 'automobile_widget_tag_cloud_args');
}
/**
 * Add Admin Page for 
 * Theme Options Menu
 */
if (!function_exists('automobile_var_options')) {

    add_action('admin_menu', 'automobile_var_options');

    function automobile_var_options() {
        global $automobile_var_static_text;
        $automobile_var_theme_options = automobile_var_theme_text_srt('automobile_var_theme_options');
        if (current_user_can('administrator')) {
            add_theme_page($automobile_var_theme_options, $automobile_var_theme_options, 'read', 'automobile_var_settings_page', 'automobile_var_settings_page');
        }
    }

}

/*
 * Include slick Script enqueue files functions 
 */
if (!function_exists('automobile_enqueue_slick_script')) {

    function automobile_enqueue_slick_script() {
        wp_enqueue_script('automobile_slick_js', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/slick.js', '', '', true);
    }

}

add_image_size('automobile_var_media_1', 775, 436, true);      // Blog Large, Blog Detail(16 x 9)
add_image_size('automobile_var_media_2', 290, 218, true);      /* Blog Medium, Related Posts , Car Listing, Car Listing Grid, Related Listing on Detail, Agent Detail Gallery, Comapre Listing, Retaed 		
  Listing On Agents (270 x 203 (4 x 3) */
add_image_size('automobile_var_media_3', 350, 197, true);      // Blog Grid(16 x 9)
add_image_size('automobile_var_media_4', 514, 517, true);      // Car Listing Detail(Custom)
add_image_size('automobile_var_media_5', 400, 400, true);      // Shop Detail, Released Models (360 x 360 )
add_image_size('automobile_var_media_6', 120, 68, true);       // Agents Listing( 16 x 9)
// Shop Listing ( Use Wordpress Default (300x300) Dont Crop255 x 255
// Default Gallery
add_action('admin_footer-post.php', 'automobile_remove_gallery_setting_div');
if (!function_exists('automobile_remove_gallery_setting_div')) {

    function automobile_remove_gallery_setting_div() {
        echo '
		<style type="text/css">
			.media-sidebar .gallery-settings{
				display:none;
			}
		</style>';
    }

}
add_filter('post_gallery', 'automobile_custom_gallery', 10, 2);

function automobile_custom_gallery($output, $attr) {
    global $post;
    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }
    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'include' => '',
        'exclude' => ''
                    ), $attr));
    $id = intval($id);
    if ('RAND' == $order)
        $orderby = 'none';
    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }
    if (empty($attachments))
        return '';
    wp_enqueue_script('cs-automobile-viewbox-script', trailingslashit(get_template_directory_uri()) . '/assets/frontend/scripts/jquery.viewbox.min.js', '', '', true);
    // Here's your actual output, you may customize it to your need
    // Now you loop through each attachment
    $output .= "<div class=\"row\">\n";
    foreach ($attachments as $id => $attachment) {
        $img_full = wp_get_attachment_image_src($id, 'full');
        $img = wp_get_attachment_image_src($id, 'automobile_var_media_2');
        $title = $attachment->post_title;
        $content = $attachment->post_excerpt;
        $output .= "<div class=\"col-lg-3 col-md-3 col-sm-6 col-xs-12\">\n";
        $output .= "<div class=\"cs-gallery\">\n";
        $output .= "<div class=\"cs-media\">\n";
        $output .= "<figure><a class=\"thumbnail\" href=\"{$img_full[0]}\"><img class='lazyload no-src'  src=\"{$img[0]}\" alt=\"$title\" /></a>\n";
        $output .= "<figcaption>\n";
        $output .= "<i class=\"icon-search2\"></i><span>" . $content . "</span>\n";
        $output .= "</figcaption></figure>\n";
        $output .= "</div>\n";
        $output .= "</div>\n";
        $output .= "</div>\n";
    }
    $output .= "</div>\n";
    return $output;
}

/*
 *  Include slick Script enqueue files functions 
 */
if (!function_exists('automobile_var_enqueue_slick_script')) {

    function automobile_var_enqueue_slick_script() {
        wp_enqueue_script('automobile_slick_js', trailingslashit(get_template_directory_uri()) . 'assets/frontend/scripts/slick.js', '', '', true);
    }

}

/*
 * Get current theme version
 */
if (!function_exists('automobile_get_theme_version')) {

    function automobile_get_theme_version() {
        $my_theme = wp_get_theme();
        $theme_version = $my_theme->get('Version');
        return $theme_version;
    }

}
/*
  password form
 */
if (!function_exists('automobile_password_form')) {

    function automobile_password_form() {
        global $post, $automobile_var_options, $automobile_var_form_fields;
        $cs_password_opt_array = array(
            'std' => '',
            'id' => '',
            'classes' => '',
            'extra_atr' => ' size="20"',
            'cust_id' => 'password_field',
            'cust_name' => 'post_password',
            'return' => true,
            'required' => false,
            'cust_type' => 'password',
        );

        $cs_submit_opt_array = array(
            'std' => esc_html__("Submit", 'automobile'),
            'id' => '',
            'classes' => 'bgcolr',
            'extra_atr' => '',
            'cust_id' => '',
            'cust_name' => 'Submit',
            'return' => true,
            'required' => false,
            'cust_type' => 'submit',
        );


        $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
        $o = '<div class="password_protected">
                <div class="protected-icon"><a href="#"><i class="icon-unlock-alt icon-4x"></i></a></div>
                <h3>' . esc_html__("This post is password protected. To view it please enter your password below:", 'automobile') . '</h3>';
        $o .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post"><label>'
                . $automobile_var_form_fields->automobile_var_form_text_render($cs_password_opt_array)
                . '</label>'
                . $automobile_var_form_fields->automobile_var_form_text_render($cs_submit_opt_array)
                . '</form>
            </div>';
        return $o;
    }

}
if (!function_exists('automobile_allow_special_char')) {

    function automobile_allow_special_char($input = '') {
	$output = $input;
	return $output;
    }

}