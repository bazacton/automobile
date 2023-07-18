<?php
/**
 * @Removing More... Link
 *
 */
if (!function_exists('remove_more_link_scroll')) {

    function remove_more_link_scroll($link) {
        $link = preg_replace('|#more-[0-9]+|', '', $link);
        return $link;
    }

    add_filter('the_content_more_link', 'remove_more_link_scroll');
}

/**
 * @Header Settings
 *
 */
if (!function_exists('automobile_var_header_settings')) {

    function automobile_var_header_settings() {
        global $automobile_var_options;
        $automobile_var_favicon = isset($automobile_var_options['automobile_var_custom_favicon']) ? $automobile_var_options['automobile_var_custom_favicon'] : '#';
        ?>
        <link rel="shortcut icon" href="<?php echo esc_url($automobile_var_favicon); ?>">
        <?php
    }

}


/* ----------------------------------------------------------------
  // @ Post Likes Counter
  /---------------------------------------------------------------- */
if (!function_exists('automobile_post_likes_count')) {

    function automobile_post_likes_count() {
        $automobile_like_counter = get_post_meta($_POST['post_id'], "automobile_post_like_counter", true);
        if (!isset($_COOKIE["automobile_post_like_counter" . $_POST['post_id']])) {
            setcookie("automobile_post_like_counter" . $_POST['post_id'], 'true', time() + 86400, '/', '');
            update_post_meta($_POST['post_id'], 'automobile_post_like_counter', $automobile_like_counter + 1);
        }
        $automobile_like_counter = get_post_meta($_POST['post_id'], "automobile_post_like_counter", true);
        if (!isset($automobile_like_counter) or empty($automobile_like_counter))
            $automobile_like_counter = 0;

        echo '<i class="icon-heart3"></i>' . automobile_allow_special_char($automobile_like_counter);
        die(0);
    }

    add_action('wp_ajax_automobile_post_likes_count', 'automobile_post_likes_count');
    add_action('wp_ajax_nopriv_automobile_post_likes_count', 'automobile_post_likes_count');
}



/**
 * @Related posts for same Category
 *
 */
if (!function_exists('automobile_var_related_posts')) {

    function automobile_var_related_posts($automobile_var_post_cat, $automobile_var_number_of_posts) {

        $args = array(
            'category__in' => $automobile_var_post_cat,
            'posts_per_page' => $automobile_var_number_of_posts
        );

        $automobile_var_query = new WP_Query($args);
        global $automobile_var_static_text;
        if ($automobile_var_query->have_posts()) {
            ?>


            <h3><?php echo automobile_var_theme_text_srt('automobile_var_related_posts'); ?></h3>
            <div class="row">

                <?php while ($automobile_var_query->have_posts()) : $automobile_var_query->the_post(); ?>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="blog-medium">
                            <div class="cs-media">
                                <figure>
                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('automobile_var_media_3',array('class'=>'lazyload no-src')); ?></a>
                                    <figcaption></figcaption>
                                </figure>
                            </div>
                            <div class="cs-text">
                                <span class="post-date"><?php echo get_the_date(); ?></span>

                                <h4><a href="<?php echo esc_url(get_permalink()); ?>"> <?php the_title(); ?></a></h4>

                                <?php
                                automobile_var_the_excerpt();
                                ?>
                                <?php
                                $automobile_var_categories = get_the_category($id = false);
                                if ($automobile_var_categories != '') {

                                    foreach ($automobile_var_categories as $automobile_var_cat) {
                                        if (isset($automobile_var_cat->cat_ID)) {
                                            $automobile_var_term_link = get_category_link($automobile_var_cat->cat_ID);
                                            echo '<a href="' . esc_url($automobile_var_term_link) . ' " class="cs-color"">' . esc_html($automobile_var_cat->name) . '</a> ';
                                        }
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <?php
                endwhile;
            }
            ?>

        </div>


        <?php
        wp_reset_postdata();
    }

}

/**
 * @Custom excerpt funciton
 *
 */
if (!function_exists('automobile_var_the_excerpt')) {

    function automobile_var_the_excerpt() {
        add_filter('excerpt_length', 'automobile_var_the_excerpt_length', 30);
        the_excerpt();
    }

}

if (!function_exists('automobile_var_the_excerpt_length')) {

    function automobile_var_the_excerpt_length($length) {
        global $automobile_var_options;
        $default_excerpt_length = isset($automobile_var_options['automobile_var_excerpt_length']) ? $automobile_var_options['automobile_var_excerpt_length'] : '50';
        return $default_excerpt_length;
    }

}

if (!function_exists('automobile_var_wpdoautomobile_excerpt_more')) {

    add_filter('excerpt_more', 'automobile_var_wpdoautomobile_excerpt_more');

    function automobile_var_wpdoautomobile_excerpt_more($more = '...') {
        return '...';
    }

}

/**
 * @Categories List by Post
 *
 */
if (!function_exists('automobile_var_cat_list')):

    function automobile_var_cat_list($automobile_var_post_id) {
        if ($automobile_var_post_id == '') {
            $automobile_var_post_id = get_the_id();
        }
        $automobile_var_cats_list = array();
        $automobile_var_cats = get_the_category($automobile_var_post_id);
        if ($automobile_var_cats != ''):
            foreach ($automobile_var_cats as $automobile_var_cat) {
                $automobile_var_term_link = get_category_link($automobile_var_cat->cat_ID);
                $automobile_var_cats_list[$automobile_var_cat->name] = $automobile_var_term_link;
            }
        endif;
        return $automobile_var_cats_list;
    }

endif;

/**
 * @Tag List by Post
 *
 */
if (!function_exists('automobile_var_tag_list')) {

    function automobile_var_tag_list($automobile_var_post_id) {
        if ($automobile_var_post_id == '') {
            $automobile_var_post_id = get_the_id();
        }
        $automobile_var_tags_list = array();
        $automobile_var_tags = get_the_tags($automobile_var_post_id);
        if ($automobile_var_tags != '') {
            foreach ($automobile_var_tags as $automobile_var_tag) {
                $automobile_var_tag_link = get_tag_link($automobile_var_tag->term_id);
                $automobile_var_tags_list[$automobile_var_tag->name] = $automobile_var_tag_link;
            }
        }
        return $automobile_var_tags_list;
    }

}


/**
 * @Getting child Comments
 *
 */
if (!function_exists('automobile_var_comment')):

    function automobile_var_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        global $wpdb, $automobile_var_static_text;
        $automobile_var_childs = $wpdb->get_var($wpdb->prepare("SELECT COUNT(comment_parent) FROM $wpdb->comments WHERE comment_parent = %d", $comment->comment_ID));
        if($automobile_var_childs > 1){
            $comment_txt = automobile_var_theme_text_srt('automobile_var_comments');
        }else {
            $comment_txt = automobile_var_theme_text_srt('automobile_var_comment');
        }
        $GLOBALS['comment'] = $comment;
        $args['reply_text'] = '<i class="icon-reply5"></i> ' . automobile_var_theme_text_srt('automobile_var_reply') . '<span><em>' . automobile_allow_special_char($automobile_var_childs) . '</em>' . $comment_txt  . '</span>';
        $args['after'] = '';
        $comment->comment_type  = ($comment->comment_type == '')? 'comment' : $comment->comment_type;
        switch ($comment->comment_type) :
            case 'comment' :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div class="thumblist" id="comment-<?php comment_ID(); ?>">
                        <ul>
                            <li>
                                <div class="cs-media">
                                    <figure>
                                        <a><?php echo get_avatar($comment, 40); ?></a>
                                    </figure>
                                </div>
                                <div class="cs-text">
                                    <div class="cs-title">
                                        <h6><?php comment_author(); ?></h6>
                                        <span class="post-date" datetime="<?php echo date('Y-m-d', strtotime(get_comment_time())); ?>"><?php echo get_comment_date() . ' ' . get_comment_time(); ?></span>
                                    </div>
                                    <?php if ($comment->comment_approved == '0') : ?>
                                        <p><div class="comment-awaiting-moderation colr"><?php echo automobile_var_theme_text_srt('automobile_var_comment_awaiting'); ?></div></p>
                                    <?php endif; ?>
                                    <?php comment_text(); ?>
                                    <div class="cs-reply">
                                        <?php comment_reply_link(array_merge($args, array('depth' => $depth))); ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php
                    break;
                case 'pingback' :
                case 'trackback' :
                    ?>
                <li class="post pingback">
                    <p><?php comment_author_link(); ?><?php edit_comment_link(automobile_var_theme_text_srt('automobile_var_edit'), ' '); ?></p>
                    <?php
                    break;
            endswitch;
        }

    endif;

    /**
     * @Replacing Reply Link Classes
     *
     */
    if (!function_exists('replace_reply_link_class')) {

        //add_filter('comment_reply_link', 'replace_reply_link_class');

        function replace_reply_link_class($class) {
            $class = str_replace("class='comment-reply-link", "class='comment-reply-link cs-color", $class);
            return $class;
        }

    }

    /**
     * @Generating Random String
     *
     */
    if (!function_exists('automobile_generate_random_string')) {

        function automobile_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

    }

    if (!function_exists('automobile_allow_special_char')) {

        function automobile_allow_special_char($input = '') {
            $output = $input;
            return $output;
        }

    }


    if (!function_exists('automobile_section')) {

        function automobile_section($class, $title, $csheading) {
            if ($title <> '') {
                $automobile_html = '';
                $automobile_html .= '<div class="' . $class . '">
                    <h' . $csheading . '>' . esc_html($title) . '</h' . $csheading . '>
                    <div class="stripe-line"></div>
                </div>';
                return $automobile_html;
            }
        }

    }

    /**
     * @Getting Image Source by Post
     *
     */
    if (!function_exists('automobile_get_post_img_src')) {

        function automobile_get_post_img_src($post_id, $width, $height) {
            global $post;
            if (has_post_thumbnail()) {
                $image_id = get_post_thumbnail_id($post_id);
                $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
                if ($image_url[1] == $width and $image_url[2] == $height) {
                    return $image_url[0];
                } else {
                    $image_url = wp_get_attachment_image_src($image_id, "full", true);
                    return $image_url[0];
                }
            }
        }

    }
    /**
     * @Getting Image Source by Post
     *
     */
    if (!function_exists('automobile_get_post_img_src_search')) {

        function automobile_get_post_img_src_search($post_id, $width, $height) {
            global $post;
            if (has_post_thumbnail()) {
                $image_id = get_post_thumbnail_id($post_id);
                $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
                if ($image_url[1] == $width and $image_url[2] == $height) {
                    return $image_url[0];
                } else {
                    $image_url = wp_get_attachment_image_src($image_id, "thumbnail", true);
                    return $image_url[0];
                }
            }
        }

    }

    /**
     * @Flex Slider
     *
     */
    if (!function_exists('automobile_post_flex_slider')) {

        function automobile_post_flex_slider($width, $height, $postid, $view) {
            global $post, $automobile_node, $automobile_theme_options, $automobile_counter_node;
            $automobile_post_counter = rand(40, 9999999);
            $automobile_counter_node++;

            if ($view == 'post-list') {
                $viewMeta = 'automobile_post_list_gallery';
            } else {
                $viewMeta = $view;
            }

            $automobile_meta_slider_options = get_post_meta("$postid", $viewMeta, true);
            $totaImages = '';
            ?>

            <div id="flexslider<?php echo esc_attr($automobile_post_counter); ?>" class="flexslider">
                <div class="flex-viewport">
                    <ul class="slides slides-1">
                        <?php
                        $automobile_counter = 1;

                        if ($view == 'post') {
                            $sliderData = get_post_meta($post->ID, 'automobile_post_detail_gallery', true);
                            $sliderData = explode(',', $sliderData);
                            $totaImages = count($sliderData);
                        } else if ($view == 'post-list') {
                            $sliderData = get_post_meta($post->ID, 'automobile_post_list_gallery', true);
                            $sliderData = explode(',', $sliderData);
                            $totaImages = count($sliderData);
                        } else {
                            $sliderData = get_post_meta($post->ID, 'automobile_post_list_gallery', true);
                            $sliderData = explode(',', $sliderData);
                            $totaImages = count($sliderData);
                        }

                        foreach ($sliderData as $as_node) {
                            $image_url = automobile_attachment_image_src((int) $as_node, $width, $height);
                            echo '<li>
                                    <figure>
                                        <img src="' . esc_url($image_url) . '" >';
                            if (isset($as_node['title']) && $as_node['title'] != '') {
                                ?>         
                                <figcaption>
                                    <div class="container">
                                        <?php if ($as_node['title'] <> '') { ?>
                                            <h2 class="colr">
                                                <?php
                                                if ($as_node['link_url'] <> '') {
                                                    
                                                } else {

                                                    echo esc_attr($as_node['title']);
                                                }
                                                ?>
                                            </h2>
                                        <?php }
                                        ?>
                                    </div>
                                </figcaption>
                            <?php } ?>

                            </figure>
                            </li>
                            <?php
                            $automobile_counter++;
                        }
                        //automobile_enqueue_slick_script();
                        ?>
                    </ul>
                </div>
            </div>

            <?php
        }

    }

    /**
     * @Getting Attachment Source by ID
     *
     */
    if (!function_exists('automobile_attachment_image_src')) {

        function automobile_attachment_image_src($attachment_id, $width, $height) {
            $image_url = wp_get_attachment_image_src($attachment_id, array($width, $height), true);
            if ($image_url[1] == $width and $image_url[2] == $height)
                return $image_url[0];
            else
                $image_url = wp_get_attachment_image_src($attachment_id, "full", true);
            $parts = explode('/uploads/', $image_url[0]);
            if (count($parts) > 1)
                return $image_url[0];
        }

    }


    /**
     * @Comment Form Fields
     *
     */
    if (!function_exists('automobile_comment_tut_fields')) {

        function automobile_comment_tut_fields() {

            global $automobile_var_static_text;

            $you_may_use = automobile_var_theme_text_srt('automobile_var_you_may');
            $automobile_comment_opt_array = array(
                'std' => '',
                'id' => '',
                'classes' => 'commenttextarea',
                'extra_atr' => ' rows="30" cols="10"',
                'cust_id' => 'comment_mes',
                'cust_name' => 'comment',
                'return' => true,
                'required' => false
            );
            $automobile_msg_class = isset($automobile_msg_class) ? $automobile_msg_class : '';
            $html = '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="input-holder">
                        <label>' . automobile_var_theme_text_srt('automobile_var_message') . '</label>
                        <textarea id="comment_mes" name="comment"  class="commenttextarea" rows="30" cols="10" placeholder="' . automobile_var_theme_text_srt('automobile_var_text_here') . '"></textarea>' .
                    '</div>';

            echo automobile_allow_special_char($html);
        }

        add_action('comment_form_logged_in_after', 'automobile_comment_tut_fields');
        add_action('comment_form_after_fields', 'automobile_comment_tut_fields');
    }

    if (!function_exists('automobile_filter_comment_form_field_comment')) {

        function automobile_filter_comment_form_field_comment($field) {

            return '';
        }

        // add the filter
        //add_filter('comment_form_field_comment', 'automobile_filter_comment_form_field_comment', 10, 1);
    }

    /**
     * @Comment Form Submit Button Filter
     *
     */
    if (!function_exists('awesome_comment_form_submit_button')) {

        function awesome_comment_form_submit_button($button) {
            $button = '<div class="input-holder"><input name="submit" type="submit" class="cs-button cs-bgcolor" tabindex="5" value="Submit comments" /></div></div></div></div>';
            return $button;
        }

        add_filter('comment_form_submit_button', 'awesome_comment_form_submit_button');
    }

    /**
     * @Enqueue Script for AddThis
     *
     */
    if (!function_exists('automobile_addthis_script_init_method')) {

        function automobile_addthis_script_init_method() {
            wp_enqueue_script('automobile_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
        }

    }

    /**
     * @Social Media Sharing Function
     *
     */
    if (!function_exists('automobile_social_share_blog')) {

        function automobile_social_share_blog($default_icon = 'false', $title = 'true', $post_social_sharing_text = '') {

            global $automobile_var_options;
            $html = '';
            $automobile_var_twitter = isset($automobile_var_options['automobile_var_twitter_share']) ? $automobile_var_options['automobile_var_twitter_share'] : '';
            $automobile_var_facebook = isset($automobile_var_options['automobile_var_facebook_share']) ? $automobile_var_options['automobile_var_facebook_share'] : '';
            $automobile_var_google_plus = isset($automobile_var_options['automobile_var_google_plus_share']) ? $automobile_var_options['automobile_var_google_plus_share'] : '';
            $automobile_var_tumblr = isset($automobile_var_options['automobile_var_tumblr_share']) ? $automobile_var_options['automobile_var_tumblr_share'] : '';
            $automobile_var_dribbble = isset($automobile_var_options['automobile_var_dribbble_share']) ? $automobile_var_options['automobile_var_dribbble_share'] : '';
            $automobile_var_share = isset($automobile_var_options['automobile_var_stumbleupon_share']) ? $automobile_var_options['automobile_var_stumbleupon_share'] : '';
            $automobile_var_stumbleupon = isset($automobile_var_options['automobile_var_stumbleupon_share']) ? $automobile_var_options['automobile_var_stumbleupon_share'] : '';
            automobile_addthis_script_init_method();
            $html = '';

            $single = false;
            if (is_single()) {
                $single = true;
            }



            $path = trailingslashit(get_template_directory_uri()) . "include/assets/images/";
            if ($automobile_var_twitter == 'on' or $automobile_var_facebook == 'on' or $automobile_var_google_plus == 'on' or $automobile_var_tumblr == 'on' or $automobile_var_dribbble == 'on' or $automobile_var_share == 'on' or $automobile_var_stumbleupon == 'on') {


                if (isset($automobile_var_facebook) && $automobile_var_facebook == 'on') {
                    if ($single == true) {
                        $html .='<li><a class="addthis_button_facebook" data-original-title="facebook"><i class="icon-facebook"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_facebook" data-original-title="facebook"><i class="icon-facebook"></i></a></li>';
                    }
                }
                if (isset($automobile_var_twitter) && $automobile_var_twitter == 'on') {

                    if ($single == true) {
                        $html .='<li><a class="addthis_button_twitter"  data-original-title="twitter"><i class="icon-twitter"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_twitter"  data-original-title="twitter"><i class="icon-twitter"></i></a></li>';
                    }
                }
                if (isset($automobile_var_google_plus) && $automobile_var_google_plus == 'on') {

                    if ($single == true) {
                        $html .='<li><a class="addthis_button_google" data-original-title="google-plus"><i class="icon-googleplus"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_google" data-original-title="google-plus"><i class="icon-googleplus"></i></a></li>';
                    }
                }
                if (isset($automobile_var_tumblr) && $automobile_var_tumblr == 'on') {

                    if ($single == true) {
                        $html .='<li><a class="addthis_button_tumblr" data-original-title="tumblr"><i class="icon-tumblr"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_tumblr" data-original-title="tumblr"><i class="icon-tumblr""></i></a></li>';
                    }
                }


                if (isset($automobile_var_dribbble) && $automobile_var_dribbble == 'on') {
                    if ($single == true) {
                        $html .='<li><a class="addthis_button_dribbble" data-original-title="dribbble"><i class="icon-dribbble2"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_dribbble" data-original-title="dribbble"><i class="icon-dribbble2"></i></a></li>';
                    }
                }
                if (isset($automobile_var_stumbleupon) && $automobile_var_stumbleupon == 'on') {
                    if ($single == true) {
                        $html .='<li><a class="addthis_button_stumbleupon" data-original-title="stumbleupon"><i class="icon-stumbleupon"></i></a></li>';
                    } else {
                        $html .='<li><a class="addthis_button_stumbleupon" data-original-title="stumbleupon"><i class="icon-stumbleupon"></i></a></li>';
                    }
                }

                $html .='<li><a class="cs-more addthis_button_compact"><i class="icon-share-alt"></i></a></li>';
            }
            echo automobile_allow_special_char($html, true);
        }

    }

    /**
     * @Getting Attachment ID by URL
     *
     */
    if (!function_exists('automobile_var_get_image_id')) {

        function automobile_var_get_image_id($attachment_url) {
            global $wpdb;
            $attachment_id = false;
            //  If there is no url, return. 
            if ('' == $attachment_url)
                return;
            // Get the upload directory paths 
            $upload_dir_paths = wp_upload_dir();
            if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {
                //  If this is the URL of an auto-generated thumbnail, get the URL of the original image 
                $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
                // Remove the upload path base directory from the attachment URL 
                $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

                $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
            }
            return $attachment_id;
        }

    }

    if (!function_exists('automobile_post_views_count')) {

        function automobile_post_views_count($postID) {
            $automobile_views_counter = get_post_meta($postID, "automobile_post_views_counter", true);
            if( $automobile_views_counter == ''){
                 $automobile_views_counter = 0;
            }
            if (!isset($_COOKIE["automobile_post_views_counter" . $postID])) {
                setcookie("automobile_post_views_counter" . $postID, time() + 86400);
                update_post_meta($postID, 'automobile_post_views_counter', $automobile_views_counter + 1);
            }
        }

    }
    ?>