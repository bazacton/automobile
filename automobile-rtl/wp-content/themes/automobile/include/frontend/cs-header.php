<?php
/**
 * Header Functions
 *
 * @package WordPress
 * @subpackage automobile
 * @since Auto Mobile 1.0
 */
if (!get_option('automobile_var_options')) {
    $automobile_activation_data = theme_default_options();
    if (is_array($automobile_activation_data) && sizeof($automobile_activation_data) > 0) {
        $automobile_var_options = $automobile_activation_data;
    } else {
        automobile_include_file('../backend/cs-global-variables.php', true);
    }
}
if (!function_exists('automobile_var_logo')) {

    function automobile_var_logo($container_class = 'cs-logo') {
        global $automobile_var_options;
        $automobile_var_logo = isset($automobile_var_options['automobile_var_custom_logo']) ? $automobile_var_options['automobile_var_custom_logo'] : '';
        $automobile_var_width = isset($automobile_var_options['automobile_var_logo_width']) ? $automobile_var_options['automobile_var_logo_width'] : '';
        $automobile_var_height = isset($automobile_var_options['automobile_var_logo_height']) ? $automobile_var_options['automobile_var_logo_height'] : '';
        $style_string = '';
        if ($automobile_var_width != '' || $automobile_var_height != '') {
            $style_string = 'style="';
            if ($automobile_var_width != '') {
                $style_string .= 'width:' . absint($automobile_var_width) . 'px;';
            }
            if ($automobile_var_height != '') {
                $style_string .= 'height:' . absint($automobile_var_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>

        <div class="<?php echo sanitize_html_class($container_class) ?>">
            <div class="cs-media">
                <figure>
                    <a href="<?php echo esc_url(home_url('/')) ?>">
                        <?php if ($automobile_var_logo != '') {
                            ?>
                            <img src="<?php echo esc_url($automobile_var_logo) ?>" <?php echo automobile_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/frontend/images/cs-logo.png') ?>" <?php echo automobile_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                            <?php
                        }
                        ?>
                    </a>
                </figure>
            </div>
        </div>
        <?php
    }

}

if (!function_exists('automobile_custom_pages_menu')) {

    function automobile_custom_pages_menu() {
        $cs_menu = wp_list_pages(array(
            'title_li' => '',
            'echo' => false,
        ));

        echo '<nav class="main-navigation"><ul class="menu-main-menu">' . $cs_menu . '</ul></nav>';
    }

}

if (!function_exists('automobile_woocommerce_header_cart')) {

    function automobile_woocommerce_header_cart() {
        if (class_exists('WooCommerce')) {
            global $woocommerce;
            ?>
            <li class="cs-cart cs-frag-cart">
                <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()) ?>">
                    <i class="icon-shopping-cart"></i>
                    <span class="csborder-color"><?php echo absint($woocommerce->cart->cart_contents_count) ?></span>
                </a>
            </li>
            <?php
        }
    }

}

if (!function_exists('automobile_woocommerce_header_cart_fragment')) {

    function automobile_woocommerce_header_cart_fragment($fragments) {
        if (class_exists('WooCommerce')) {
            global $woocommerce;
            ob_start();
            ?>
            <li class="cs-cart cs-frag-cart">
                <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()) ?>">
                    <i class="icon-shopping-cart"></i>
                    <span class="csborder-color"><?php echo absint($woocommerce->cart->cart_contents_count) ?></span>
                </a>
            </li>
            <?php
            $fragments['li.cs-frag-cart'] = ob_get_clean();
            return $fragments;
        }
    }

    add_filter('add_to_cart_fragments', 'automobile_woocommerce_header_cart_fragment');
}

if (!function_exists('automobile_var_subheader_style')) {

    function automobile_var_subheader_style($automobile_var_post_ID = '') {
        global $post, $wp_query, $automobile_var_options, $automobile_var_post_meta;
        $post_type = get_post_type(get_the_ID());
        $automobile_var_post_ID = get_the_ID();
        if (is_search() || is_category() || is_home() || is_404() || is_archive()) {
            $automobile_var_post_ID = '';
        }
        $meta_element = 'automobile_full_data';
        $automobile_var_post_meta = get_post_meta((int) $automobile_var_post_ID, "$meta_element", true);
        $automobile_var_header_banner_style = get_post_meta((int) $automobile_var_post_ID, "automobile_var_header_banner_style", true);

        if (isset($automobile_var_header_banner_style) && $automobile_var_header_banner_style == 'no-header') {
            $automobile_var_header_border_color = get_post_meta((int) $automobile_var_post_ID, "automobile_var_main_header_border_color", true);
            if ($automobile_var_header_border_color <> '') {
                echo '
                <style>
                #header {
                    border-bottom: 1px solid ' . $automobile_var_header_border_color . ';
                }
                </style>
                ';
            }
            echo '<div class="cs-no-subheader"></div>';
        } else if (isset($automobile_var_header_banner_style) && $automobile_var_header_banner_style == 'breadcrumb_header') {

            automobile_var_breadcrumb_page_setting($automobile_var_post_ID);
        } else if (isset($automobile_var_header_banner_style) && $automobile_var_header_banner_style == 'custom_slider') {

            automobile_var_rev_slider('pages', $automobile_var_post_ID);
        } else if (isset($automobile_var_header_banner_style) && $automobile_var_header_banner_style == 'map') {

            automobile_var_page_map($automobile_var_post_ID);
        } else if (isset($automobile_var_options['automobile_var_default_header'])) {

            if ($automobile_var_options['automobile_var_default_header'] == 'no_header') {
                $automobile_var_header_border_color = isset($automobile_var_options['automobile_var_header_border_color']) ? $automobile_var_options['automobile_var_header_border_color'] : '';
                if ($automobile_var_header_border_color <> '') {
                    echo '
                    <style>
                    #header .cs-main-nav .pinned {
                        border-bottom: 1px solid ' . $automobile_var_header_border_color . ';
                    }
                    </style>';
                }
            } else if ($automobile_var_options['automobile_var_default_header'] == 'breadcrumbs_sub_header') {
                automobile_var_breadcrumb_theme_option($automobile_var_post_ID);
            } else if ($automobile_var_options['automobile_var_default_header'] == 'slider') {

                automobile_var_rev_slider('default-pages', $automobile_var_post_ID);
            }
        }
    }

}

/*
 * Start Rev slider function
 */

if (!function_exists('automobile_var_rev_slider')) {

    function automobile_var_rev_slider($automobile_var_slider_type = '', $automobile_var_post_ID = '') {
        global $post, $post_meta, $automobile_var_options;

        if ($automobile_var_slider_type == 'pages') {
            $automobile_var_rev_slider_id = get_post_meta((int) $automobile_var_post_ID, "automobile_var_custom_slider_id", true);
        } else {
            $automobile_var_rev_slider_id = isset($automobile_var_options['automobile_var_custom_slider']) ? $automobile_var_options['automobile_var_custom_slider'] : '';
        }
        if (isset($automobile_var_rev_slider_id) && $automobile_var_rev_slider_id != '') {
            ?>
            <div class="cs-banner"> <?php echo do_shortcode("[rev_slider alias=\"{$automobile_var_rev_slider_id}\"]"); ?> </div>
            <?php
        }
    }

}

/*
 * Start page map function
 */

if (!function_exists('automobile_var_page_map')) {

    function automobile_var_page_map($automobile_var_post_ID = '') {
        global $post, $post_meta, $header_map;
        $automobile_var_custom_map = get_post_meta((int) $automobile_var_post_ID, "automobile_var_custom_map", true);
        if (empty($automobile_var_custom_map)) {
            $automobile_var_custom_map = "";
        } else {
            $automobile_var_custom_map = html_entity_decode($automobile_var_custom_map);
        }
        if (isset($automobile_var_custom_map) && $automobile_var_custom_map != '') {
            $header_map = true;
            ?>
            <div class="cs-fullmap"> <?php echo do_shortcode($automobile_var_custom_map); ?> </div>
            <?php
        }
    }

}

/**
 * @subheader page 
 * setting breadcrums
 */
if (!function_exists('automobile_var_breadcrumb_page_setting')) {

    function automobile_var_breadcrumb_page_setting() {
        global $post, $wp_query, $automobile_var_options, $post_meta;
        $meta_element = 'automobile_full_data';
        $automobile_var_post_ID = get_the_ID();
        if (function_exists('is_shop')) {
            if (is_shop()) {
                $automobile_var_post_ID = wc_get_page_id('shop');
            }
        }
        $post_meta = get_post_meta((int) $automobile_var_post_ID, "$meta_element", true);

        $automobile_var_sub_header_style = get_post_meta((int) $automobile_var_post_ID, "automobile_var_sub_header_style", true);
        $automobile_var_sub_header_sub_hdng = get_post_meta((int) $automobile_var_post_ID, "automobile_var_page_subheading_title", true);
        $automobile_var_header_banner_image = get_post_meta((int) $automobile_var_post_ID, "automobile_var_header_banner_image", true);
        $automobile_var_page_subheader_parallax = get_post_meta((int) $automobile_var_post_ID, "automobile_var_page_subheader_parallax", true);
        $automobile_var_page_subheader_color = get_post_meta((int) $automobile_var_post_ID, "automobile_var_page_subheader_color", true);
        $automobile_var_page_title_switch = get_post_meta((int) $automobile_var_post_ID, "automobile_var_page_title_switch", true);
        $automobile_var_sub_header_align = get_post_meta((int) $automobile_var_post_ID, "automobile_var_sub_header_align", true);
        $automobile_var_page_breadcrumbs = get_post_meta((int) $automobile_var_post_ID, "automobile_var_page_breadcrumbs", true);
        $automobile_var_subheader_padding_top = get_post_meta((int) $automobile_var_post_ID, "automobile_var_subheader_padding_top", true);
        $automobile_var_subheader_padding_bottom = get_post_meta((int) $automobile_var_post_ID, "automobile_var_subheader_padding_bottom", true);
        $automobile_var_subheader_margin_top = get_post_meta((int) $automobile_var_post_ID, "automobile_var_subheader_margin_top", true);
        $automobile_var_subheader_margin_bottom = get_post_meta((int) $automobile_var_post_ID, "automobile_var_subheader_margin_bottom", true);
        $automobile_var_page_subheader_text_color = get_post_meta((int) $automobile_var_post_ID, "automobile_var_page_subheader_text_color", true);

        $automobile_all_fields = array(
            'automobile_var_post_ID' => $automobile_var_post_ID,
            'automobile_var_sub_header_style' => $automobile_var_sub_header_style,
            'automobile_var_sub_header_sub_hdng' => $automobile_var_sub_header_sub_hdng,
            'automobile_var_header_banner_image' => $automobile_var_header_banner_image,
            'automobile_var_page_subheader_parallax' => $automobile_var_page_subheader_parallax,
            'automobile_var_page_subheader_color' => $automobile_var_page_subheader_color,
            'automobile_var_sub_header_align' => $automobile_var_sub_header_align,
            'automobile_var_page_title_switch' => $automobile_var_page_title_switch,
            'automobile_var_page_breadcrumbs' => $automobile_var_page_breadcrumbs,
            'automobile_var_subheader_padding_top' => $automobile_var_subheader_padding_top,
            'automobile_var_subheader_padding_bottom' => $automobile_var_subheader_padding_bottom,
            'automobile_var_subheader_margin_top' => $automobile_var_subheader_margin_top,
            'automobile_var_subheader_margin_bottom' => $automobile_var_subheader_margin_bottom,
            'automobile_var_page_subheader_text_color' => $automobile_var_page_subheader_text_color,
        );
        automobile_var_breadcrumb_markup($automobile_all_fields);
    }

}

/**
 * @subheader page 
 * breadcrums settings
 */
if (!function_exists('automobile_var_breadcrumb_theme_option')) {

    function automobile_var_breadcrumb_theme_option() {
        global $automobile_var_options;
        $automobile_var_post_ID = get_the_ID();
        if (function_exists('is_shop')) {
            if (is_shop()) {
                $automobile_var_post_ID = wc_get_page_id('shop');
            }
        }

        $automobile_var_sub_header_style = isset($automobile_var_options['automobile_var_sub_header_style']) ? $automobile_var_options['automobile_var_sub_header_style'] : '';
        $automobile_var_sub_header_sub_hdng = isset($automobile_var_options['automobile_var_sub_header_sub_hdng']) ? $automobile_var_options['automobile_var_sub_header_sub_hdng'] : '';
        $automobile_var_header_banner_image = isset($automobile_var_options['automobile_var_sub_header_bg_img']) ? $automobile_var_options['automobile_var_sub_header_bg_img'] : '';
        $automobile_var_page_subheader_parallax = isset($automobile_var_options['automobile_var_sub_header_parallax']) ? $automobile_var_options['automobile_var_sub_header_parallax'] : '';
        $automobile_var_page_subheader_color = isset($automobile_var_options['automobile_var_sub_header_bg_clr']) ? $automobile_var_options['automobile_var_sub_header_bg_clr'] : '';
        $automobile_var_page_title_switch = isset($automobile_var_options['automobile_var_page_title_switch']) ? $automobile_var_options['automobile_var_page_title_switch'] : '';
        $automobile_var_sub_header_align = isset($automobile_var_options['automobile_var_sub_header_align']) ? $automobile_var_options['automobile_var_sub_header_align'] : '';
        $automobile_var_page_breadcrumbs = isset($automobile_var_options['automobile_var_breadcrumbs_switch']) ? $automobile_var_options['automobile_var_breadcrumbs_switch'] : '';
        $automobile_var_subheader_padding_top = isset($automobile_var_options['automobile_var_sh_paddingtop']) ? $automobile_var_options['automobile_var_sh_paddingtop'] : '';
        $automobile_var_subheader_padding_bottom = isset($automobile_var_options['automobile_var_sh_paddingbottom']) ? $automobile_var_options['automobile_var_sh_paddingbottom'] : '';
        $automobile_var_subheader_margin_top = isset($automobile_var_options['automobile_var_sh_margintop']) ? $automobile_var_options['automobile_var_sh_margintop'] : '';
        $automobile_var_subheader_margin_bottom = isset($automobile_var_options['automobile_var_sh_marginbottom']) ? $automobile_var_options['automobile_var_sh_marginbottom'] : '';
        $automobile_var_page_subheader_text_color = isset($automobile_var_options['automobile_var_sub_header_text_color']) ? $automobile_var_options['automobile_var_sub_header_text_color'] : '';

        $automobile_all_fields = array(
            'automobile_var_post_ID' => $automobile_var_post_ID,
            'automobile_var_sub_header_style' => $automobile_var_sub_header_style,
            'automobile_var_sub_header_sub_hdng' => $automobile_var_sub_header_sub_hdng,
            'automobile_var_header_banner_image' => $automobile_var_header_banner_image,
            'automobile_var_page_subheader_parallax' => $automobile_var_page_subheader_parallax,
            'automobile_var_page_subheader_color' => $automobile_var_page_subheader_color,
            'automobile_var_page_title_switch' => $automobile_var_page_title_switch,
            'automobile_var_sub_header_align' => $automobile_var_sub_header_align,
            'automobile_var_page_breadcrumbs' => $automobile_var_page_breadcrumbs,
            'automobile_var_subheader_padding_top' => $automobile_var_subheader_padding_top,
            'automobile_var_subheader_padding_bottom' => $automobile_var_subheader_padding_bottom,
            'automobile_var_subheader_margin_top' => $automobile_var_subheader_margin_top,
            'automobile_var_subheader_margin_bottom' => $automobile_var_subheader_margin_bottom,
            'automobile_var_page_subheader_text_color' => $automobile_var_page_subheader_text_color,
        );

        $automobile_sub_header_view = true;
//        if (is_singular('post')) {
//            $automobile_post_subheader = get_post_meta((int) $automobile_var_post_ID, "automobile_var_header_banner_style", true);
//            if ($automobile_post_subheader == '') {
//                $automobile_sub_header_view = false;
//            }
//        }
        if ($automobile_sub_header_view == true) {
            automobile_var_breadcrumb_markup($automobile_all_fields);
        }
    }

}

/**
 * @subheader styles 
 * markup
 */
if (!function_exists('automobile_var_breadcrumb_markup')) {

    function automobile_var_breadcrumb_markup($automobile_fields = array()) {

        extract($automobile_fields);
        global $post;
        $automobile_sub_style = '';
        $automobile_var_sub_header_align = isset($automobile_var_sub_header_align) ? $automobile_var_sub_header_align : 'pull-left';

        if ($automobile_var_header_banner_image != '' && $automobile_var_sub_header_style == 'with_bg') {
            $automobile_var_parallax_fixed = $automobile_var_page_subheader_parallax == 'on' ? ' fixed' : '';

            $automobile_sub_style .= ' background:url(' . $automobile_var_header_banner_image . ') ' . $automobile_var_page_subheader_color . ' no-repeat' . $automobile_var_parallax_fixed . ' ;';
            $automobile_sub_style .= ' background-size: cover;';
        } else if ($automobile_var_page_subheader_color != '' && ($automobile_var_sub_header_style == 'with_bg' || $automobile_var_sub_header_style == 'classic')) {
            $automobile_sub_style .= ' background:' . $automobile_var_page_subheader_color . ' !important;';
        }
        if ($automobile_var_subheader_padding_top != '') {
            $automobile_sub_style .= ' padding-top: ' . esc_html($automobile_var_subheader_padding_top) . 'px !important;';
        }
        if ($automobile_var_subheader_padding_bottom != '') {
            $automobile_sub_style .= ' padding-bottom: ' . esc_html($automobile_var_subheader_padding_bottom) . 'px !important;';
        }
        if ($automobile_var_subheader_margin_top != '') {
            $automobile_sub_style .= ' margin-top: ' . esc_html($automobile_var_subheader_margin_top) . 'px !important;';
        }
        if ($automobile_var_subheader_margin_bottom != '') {
            $automobile_sub_style .= ' margin-bottom: ' . esc_html($automobile_var_subheader_margin_bottom) . 'px !important;';
        }

        if ($automobile_var_header_banner_image != '') {
            $automobile_upload_dir = wp_upload_dir();
            $automobile_upload_baseurl = isset($automobile_upload_dir['baseurl']) ? $automobile_upload_dir['baseurl'] . '/' : '';

            $automobile_upload_dir = isset($automobile_upload_dir['basedir']) ? $automobile_upload_dir['basedir'] . '/' : '';

            if (false !== strpos($automobile_var_header_banner_image, $automobile_upload_baseurl)) {
                $automobile_upload_subdir_file = str_replace($automobile_upload_baseurl, '', $automobile_var_header_banner_image);
            }

            $automobile_images_dir = trailingslashit(get_template_directory()) . 'assets/frontend/images/';

            $automobile_img_name = preg_replace('/^.+[\\\\\\/]/', '', $automobile_var_header_banner_image);

            if (is_file($automobile_upload_dir . $automobile_img_name) || is_file($automobile_images_dir . $automobile_img_name)) {
                if (ini_get('allow_url_fopen')) {
                    $automobile_var_header_image_height = getimagesize($automobile_var_header_banner_image);
                }
            } else if (isset($automobile_upload_subdir_file) && is_file($automobile_upload_dir . $automobile_upload_subdir_file)) {
                if (ini_get('allow_url_fopen')) {
                    $automobile_var_header_image_height = getimagesize($automobile_var_header_banner_image);
                }
            } else {
                $automobile_var_header_image_height = '';
            }

            if ($automobile_var_header_image_height != '' && isset($automobile_var_header_image_height[1])) {
                $automobile_var_header_image_height = $automobile_var_header_image_height[1] . 'px';
                $automobile_sub_style .= ' height: ' . $automobile_var_header_image_height . ' !important;';
            }
        }
        $post_type = '';
        if (!is_author() && !is_404()) {
            if ($post) {
                $post_type = get_post_type($post->ID);
            }
        }
        if ($automobile_var_sub_header_align == '') {
            $automobile_var_sub_header_align = 'pull-left';
        }

        if ($post_type == 'inventory') {
            
        } else {
            if ($automobile_var_sub_header_style == 'with_bg') {
                ?>
                <div class="cs-subheader center"<?php if ($automobile_sub_style != '') { ?> style="<?php echo automobile_allow_special_char($automobile_sub_style) ?>"<?php } ?>>
                    <div class="container">
                        <div class="cs-page-title <?php echo sanitize_html_class($automobile_var_sub_header_align); ?>">
                            <?php if ($automobile_var_page_title_switch == "on") { ?>
                                <h1<?php if ($automobile_var_page_subheader_text_color != '') { ?> style="color:<?php echo esc_html($automobile_var_page_subheader_text_color); ?> !important;"<?php } ?>><?php automobile_post_page_title(); ?></h1>
                            <?php } ?>
                            <?php if ($automobile_var_sub_header_sub_hdng != '') { ?>
                                <div <?php if ($automobile_var_page_subheader_text_color != '') { ?> style="color:<?php echo esc_html($automobile_var_page_subheader_text_color); ?> !important;"<?php } ?>><?php echo do_shortcode($automobile_var_sub_header_sub_hdng) ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="cs-subheader"<?php if ($automobile_sub_style != '') { ?> style="<?php echo automobile_allow_special_char($automobile_sub_style) ?>"<?php } ?>>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="cs-subheader-text">
                                    <?php if ($automobile_var_page_title_switch == "on") { ?>
                                        <div class="cs-page-title <?php echo sanitize_html_class($automobile_var_sub_header_align); ?>">
                                            <h1<?php if ($automobile_var_page_subheader_text_color != '') { ?> style="color:<?php echo esc_html($automobile_var_page_subheader_text_color); ?> !important;"<?php } ?>><?php automobile_post_page_title(); ?></h1>
                                        </div>
                                        <?php
                                    }
                                    if ($automobile_var_page_breadcrumbs == "on") {
                                        automobile_breadcrumbs();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }

}