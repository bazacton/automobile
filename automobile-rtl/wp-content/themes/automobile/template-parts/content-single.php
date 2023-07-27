<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Automobile
 * @since Auto Mobile 1.0
 */
?>
<?php
$var_arrays = array('author', 'post', 'automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
$thumb_view = get_post_meta($post->ID, 'automobile_thumb_view', true);
$inside_detail_view = get_post_meta($post->ID, 'automobile_detail_view', true);
$automobile_blog_view = get_post_meta($post->ID, 'automobile_blog_views', true);


$automobile_uniq = rand(11111111, 99999999);
$automobile_postObject = get_post_meta($post->ID, 'automobile_full_data', true);
$automobile_gallery_ids = get_post_meta($post->ID, 'automobile_post_list_gallery', true);
$automobile_gallery_slider_ids = get_post_meta($post->ID, 'automobile_post_detail_gallery', true);
$automobile_gallery = explode(',', $automobile_gallery_ids);
$automobile_gallery_slider = explode(',', $automobile_gallery_slider_ids);
get_header();
$automobile_postid = get_the_id();
$automobile_layout = '';


$automobile_views_counter = get_post_meta($automobile_postid, "automobile_post_views_counter", true);
//setPostViews(get_the_ID());
$leftSidebarFlag = false;
$rightSidebarFlag = false;
$automobile_layout = get_post_meta($post->ID, 'automobile_page_layout', true);
$automobile_sidebar_left = get_post_meta($post->ID, 'automobile_page_sidebar_left', true);
$automobile_sidebar_right = get_post_meta($post->ID, 'automobile_page_sidebar_right', true);
$post_tags_show = get_post_meta($post->ID, 'automobile_post_tags_show', true);
$automobile_post_social_sharing = get_post_meta($post->ID, 'automobile_post_social_sharing', true);
$post_pagination_show = get_post_meta($post->ID, 'automobile_post_pagination_show', true);
$inside_post_view = get_post_meta($post->ID, 'automobile_detail_view', true);
$post_audio = get_post_meta($post->ID, 'automobile_audio_view', true);
$post_video = get_post_meta($post->ID, 'automobile_video_view', true);
$automobile_single_view = get_post_meta($post->ID, 'automobile_single_view', true);
$automobile_related_post = get_post_meta($automobile_postid, 'automobile_automobile_related_post', true);
$automobile_related_blog_post = get_post_meta($automobile_postid, 'automobile_related_blog_post', true);
$automobile_default_sidebar = false;
if ($automobile_layout == '') {
    $automobile_default_sidebar = true;
}

if ($automobile_layout == "left") {
    $automobile_layout = "page-content";
    $leftSidebarFlag = true;
    $custom_height = 300;
} else if ($automobile_layout == "right") {
    $automobile_layout = "page-content";
    $rightSidebarFlag = true;
    $custom_height = 300;
} else {
    $automobile_layout = "page-content-fullwidth";
    $custom_height = 408;
}
if (!isset($automobile_layout)) {
    $automobile_layout = isset($jobcareer_options['automobile_single_post_layout']) ? $jobcareer_options['automobile_single_post_layout'] : '';
    if (isset($automobile_layout) && $automobile_layout == "sidebar_left") {
        $automobile_layout = "page-content";
        $automobile_sidebar_left = $jobcareer_options['automobile_single_layout_sidebar'];
        $leftSidebarFlag = true;
        $custom_height = 300;
    } else if (isset($automobile_layout) && $automobile_layout == "sidebar_right") {
        $automobile_layout = "page-content";
        $automobile_sidebar_right = $jobcareer_options['automobile_single_layout_sidebar'];
        $rightSidebarFlag = true;
        $custom_height = 300;
    }
}
$width = 775;
$height = 436;
$automobile_user_data = get_userdata($author);
$image_url = automobile_get_post_img_src($post->ID, 960, 540);
$automobile_section_bg = $image_url <> '' ? esc_url($image_url) : '';
if ($inside_detail_view == 'slider') {
    ?>
    <ul class="blog-detail-slider" style="margin-bottom:30px;">
        <?php echo automobile_post_slick_detail($width, $height, $automobile_postid, 'post-list'); ?>
    </ul>
<?php } elseif ($inside_detail_view == 'audio') { ?>
    <div class="cs-media" style="margin-bottom:30px;">
        <?php
        $attr = array(
            'src' => $post_audio,
            'loop' => '',
            'autoplay' => '',
            'preload' => 'none'
        );
        echo do_shortcode(wp_audio_shortcode($attr));
        ?>
    </div>
<?php } elseif ($inside_detail_view == 'video') { ?>
    <div class="cs-media" style="margin-bottom:30px;">
        <?php echo wp_oembed_get($post_video, array('height' => 300)); ?>
    </div>
<?php } elseif ($inside_detail_view == 'single') { ?>
    <div class="cs-media" style="margin-bottom:30px;">
        <div class="detail-img">
            <?php the_post_thumbnail('automobile_var_media_1',array('class'=>'lazyload no-src')); ?>
        </div>
    </div>
<?php } ?>
<div class="cs-blog-post">
    <div class="cs-thumb-post">
        <div class="cs-media">
            <figure><?php
                $automobile_var_author_id = get_post_field('post_author', $automobile_postid);
                echo get_avatar($automobile_var_author_id, 35);
                ?></figure>
        </div>
        <div class="cs-text">
            <span><?php echo automobile_var_theme_text_srt('automobile_var_by') . ' '; ?><a href="<?php echo get_author_posts_url($automobile_var_author_id); ?>"><?php the_author(); ?></a><br><?php
                echo date_i18n(get_option('date_format'), strtotime(get_the_date())) . ' , ';
                the_time();
                ?></span>
        </div>
    </div>
    <div class="cs-post-options">
        <ul>
            <li><a><i class="icon-ribbon"></i><?php echo esc_html($automobile_views_counter); ?></a></li>
            <li>
                <?php
                $automobile_post_like_counter = get_post_meta($automobile_postid, "automobile_post_like_counter", true);
                if (!isset($automobile_post_like_counter) or empty($automobile_post_like_counter))
                    $automobile_post_like_counter = 0;
                if (isset($_COOKIE["automobile_post_like_counter" . $automobile_postid])) {
                    echo '<a><i class="icon-heart3"></i>' . $automobile_post_like_counter . '</a>';
                } else {
                    ?>
                    <a id="post_likes<?php echo automobile_allow_special_char($automobile_postid); ?>" onclick="automobile_post_likes_count('<?php echo admin_url('admin-ajax.php') ?>', '<?php echo automobile_allow_special_char($automobile_postid) ?>')"><i class="icon-heart3"></i><?php echo absint($automobile_post_like_counter) ?></a>
                    <?php
                }
                ?>
            </li>
            <li><a><i class="icon-chat2"></i><?php echo get_comments_number(); ?></a></li>
        </ul>
    </div>
</div>
<div class="cs-blog-detail-text">
    <?php 
	the_content();
	wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'automobile') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); 
	?>
</div>
<?php
$automobile_posts_tags_show = get_post_meta($automobile_postid, 'automobile_var_post_tags_show', true);
$automobile_var_tages = '';
$automobile_var_tages = automobile_var_tag_list($automobile_postid);
?>
<div class="cs-blog-tags">
    <?php
    if ($automobile_posts_tags_show == 'on') {
        if (is_array($automobile_var_tages) && $automobile_var_tages != '') {
            ?>

            <div class="cs-tags">
                <label><i class="icon-tags"></i><?php echo automobile_var_theme_text_srt('automobile_var_tag'); ?></label>
                <ul>
                    <?php
                    foreach ($automobile_var_tages as $key => $value) {
                        ?>
                        <li><a href="<?php echo esc_url($value); ?>"><?php echo esc_html($key); ?></a></li>
                    <?php }
                    ?>

                </ul>
            </div>
            <?php
        }
    }
    $automobile_social_share_show = get_post_meta($automobile_postid, 'automobile_var_post_social_sharing', true);
    $automobile_related_post_show = get_post_meta($automobile_postid, 'automobile_var_related_post', true);

    if ($automobile_social_share_show == 'on') {
        ?>
        <ul class="cs-social-media">
            <?php echo automobile_social_share_blog('', 'yes'); ?>
        </ul>
        <?php
    }
    ?>
</div>
<div class="cs-about-author">
    <div class="cs-media">
        <?php
        echo get_avatar($automobile_var_author_id, 35);
        ?>
    </div>
    <div class="cs-text">
        <span><?php echo automobile_var_theme_text_srt('automobile_var_published_by'); ?><a href="<?php echo get_author_posts_url($automobile_var_author_id); ?>"><?php the_author(); ?></a></span>
        <p><?php echo get_the_author_meta('description'); ?></p>
        <a href="<?php echo get_author_posts_url($automobile_var_author_id); ?>"><i class="icon-angle-double-right"></i><?php echo automobile_var_theme_text_srt('automobile_var_view_all_posts_by'); ?><?php the_author(); ?></a>
    </div>
</div>
<div class="cs-next-previous-post row">
    <?php
    $automobile_previous_post = get_previous_post();
    $automobile_next_post = get_next_post();
    
    $prev_post = get_adjacent_post(false, '', true);
    if ($prev_post) {
        $prev_post_url = get_permalink($prev_post->ID);
    }
    $next_post = get_adjacent_post(false, '', false);
    if ($next_post) {
        $next_post_url = get_permalink($next_post->ID);
    }
    if (isset($prev_post_url) && $prev_post_url != ''):
        ?>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="cs-previous">
                <a class="btn-prev" href="<?php echo esc_url($prev_post_url); ?>"><i class="icon-keyboard_arrow_left"></i><?php echo automobile_var_theme_text_srt('automobile_var_prev'); ?></a>
                <div class="inner-text">
                    <div class="cs-media">
                        <figure><?php
    $automobile_var_author_id = get_post_field('post_author', $automobile_previous_post->ID);
    echo get_avatar($automobile_var_author_id, 35);
        ?></figure>
                    </div>
                    <div class="cs-text">
                        <h6><a href="<?php echo esc_url($prev_post_url); ?>"><?php previous_post_link('%link'); ?></a></h6>
                        <span><i class="icon-clock5"></i><?php echo human_time_diff(get_the_time('U', $automobile_previous_post->ID), current_time('timestamp')) . ' ' . automobile_var_theme_text_srt('automobile_var_ago'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endif;
    if (isset($next_post_url) && $next_post_url != ''):
        ?>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
            <div class="cs-next">
                <a class="btn-next" href="<?php echo esc_url($next_post_url); ?>"><?php echo automobile_var_theme_text_srt('automobile_var_next'); ?><i class="icon-keyboard_arrow_right"></i></a>
                <div class="inner-text">
                    <div class="cs-media">
                        <figure><?php
    $automobile_var_author_id = get_post_field('post_author', $automobile_next_post->ID);
    echo get_avatar($automobile_var_author_id, 35);
        ?></figure>
                    </div>
                    <div class="cs-text">
                        <h6><a href="<?php echo esc_url($next_post_url); ?>"><?php next_post_link('%link'); ?></a></h6>
                        <span><i class="icon-clock5"></i><?php echo human_time_diff(get_the_time('U', $automobile_next_post->ID), current_time('timestamp')) . ' ' . automobile_var_theme_text_srt('automobile_var_ago'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php if ($automobile_related_post_show == 'on') { ?>
    <div class="cs-blog-related-post">

        <?php
        $automobile_var_categories = '';
        $automobile_cats_list = array();
        $automobile_var_categories = get_the_category($id = false);
        if ($automobile_var_categories != '') {
            foreach ($automobile_var_categories as $automobile_var_cat) {
                if (isset($automobile_var_cat->cat_ID)) {
                    $automobile_cats_list[] = $automobile_var_cat->cat_ID;
                }
            }
        }
        if (is_array($automobile_cats_list) && $automobile_cats_list != '') {
            $number_of_posts = 5;
            automobile_var_related_posts($automobile_cats_list, $number_of_posts);
        }
        ?>   
    </div>
<?php } ?>
                                















