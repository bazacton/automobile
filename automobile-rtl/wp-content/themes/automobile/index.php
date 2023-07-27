<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
get_header();
/**
 * @ Start front end Blog list view 
 *
 *
 */
global $automobile_var_static_text;
$automobile_blog_vars = array('post', 'automobile_blog_cat', 'automobile_blog_description', 'automobile_blog_excerpt', 'automobile_notification', 'wp_query', 'blog_pagination', 'automobile_blog_num_post');
$automobile_blog_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($automobile_blog_vars);
extract($automobile_blog_vars);
;
$strings = new automobile_theme_all_strings;
$strings->automobile_theme_option_field_strings();

extract($wp_query->query_vars);
$width = '290';
$height = '218';

$cs_excerpt_length = 60;
$cs_theme_options = get_option('automobile_var_options');
if (isset($cs_theme_options['automobile_var_excerpt_length']) && $cs_theme_options['automobile_var_excerpt_length'] <> 0) {
    $cs_excerpt_length = $cs_theme_options['automobile_var_excerpt_length'];
}
$arguments = array(
    'posts_per_page' => 10,
    'post_type' => 'post',
);
$argus = array(
    'posts_per_page' => -1,
    'post_type' => 'post',
);
$query_str = new WP_Query($argus);
$count_post = $query_str->post_count;

$automobile_layout = isset($cs_theme_options['automobile_var_default_page_layout']) ? $cs_theme_options['automobile_var_default_page_layout'] : '';

$automobile_default_sidebar = false;
if ($automobile_layout == '') {
    $automobile_default_sidebar = true;
}

if (isset($automobile_layout) && ($automobile_layout == "sidebar_left" || $automobile_layout == "sidebar_right")) {
    $automobile_col_class = "col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else if ($automobile_default_sidebar == true) {
    $automobile_col_class = "col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else {
    $automobile_col_class = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
}

$automobile_sidebar = isset($cs_theme_options['automobile_var_default_layout_sidebar']) ? $cs_theme_options['automobile_var_default_layout_sidebar'] : '';
$query = new WP_Query($arguments);
$post_count = $query->post_count;
if ($query->have_posts()) {
    $postCounter = 0;
    wp_reset_postdata();
    ?>
    <div class="main-section">
        <div class="container">
            <div class="row">
                <?php
                if ($automobile_layout == 'sidebar_left') {
                    if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                        ?>
                        <div class="page-sidebar left col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <?php
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="page-content <?php echo esc_html($automobile_col_class); ?>">
                    <div class="content-area">
                        <div class="row">
                            <?php
                            while ($query->have_posts()) : $query->the_post();
                                $thumbnail = automobile_get_post_img_src($post->ID, $width, $height);
                                $automobile_postObject = get_post_meta($post->ID, "automobile_full_data", true);
                                $automobile_gallery = get_post_meta($post->ID, 'automobile_post_list_gallery', true);
                                $automobile_gallery = explode(',', $automobile_gallery);
                                $automobile_thumb_view = get_post_meta($post->ID, 'automobile_thumb_view', true);
                                $automobile_thumb_view = isset($automobile_thumb_view) ? $automobile_thumb_view : '';
                                $audioFile = get_post_meta($post->ID, 'automobile_audio_url', true);
                                $videoFile = get_post_meta($post->ID, 'automobile_video_url', true);
                                $current_user = wp_get_current_user();
                                $current_category = get_the_category();
                                $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
                                $tags = get_tags();
                                $cs_automobile_content = get_the_content();
                                ?> 
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="blog-listing medium-view">
                                        <div class="cs-media">
                                            <?php if ($automobile_thumb_view == 'slider') { ?>
                                                <div class="cs-media blog-medium-slider">
                                                    <?php echo automobile_post_slick_detail($width, $height, get_the_id(), 'post-list', 0); ?>
                                                </div>
                                                <?php
                                            } elseif ($automobile_thumb_view == 'audio') {
                                                if ($audioFile <> '') {
                                                    ?>
                                                    <?php echo wp_audio_shortcode(array('src' => esc_url($audioFile))); ?>
                                                    <?php
                                                }
                                            } elseif ($automobile_thumb_view == 'video') {
                                                if ($videoFile <> '') {
                                                    echo wp_oembed_get(automobile_allow_special_char($videoFile), array('height' => $height));
                                                }
                                            } elseif ($automobile_thumb_view == 'single') {
                                                if (!(the_post_thumbnail('automobile_var_media_2') == NULL) && the_post_thumbnail('automobile_var_media_2') <> '') {
                                                    ?>
                                                    <figure>
                                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('automobile_var_media_2',array('class'=>'lazyload no-src')); ?></a>
                                                        <figcaption>
                                                            <?php if (is_sticky()) { ?>
                                                                <div class="caption-text"><span><?php echo automobile_var_theme_text_srt('automobile_var_sticky_text'); ?></span></div>
                                                            <?php } ?>
                                                        </figcaption>
                                                    </figure>
                                                <?php }
                                            } ?>	
                                        </div>
                                        <div class="cs-text">
                                            <div class="post-title">
                                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a>
                                                
                                                <?php if (is_sticky($post->ID)) {
                                                    echo '<span class="list-feature-item">' . esc_html__(' Featured', 'automobile') . '</span>';
                                                } ?>
                                                </h4>
                                            </div>
                                            <ul class="cs-auto-categories">
                                                <?php
                                                $automobile_var_categories = automobile_var_cat_list(get_the_id());
                                                if ($automobile_var_categories != '') {
                                                    foreach ($automobile_var_categories as $key => $value) {
                                                        echo '<li><a href="' . esc_url($value) . '" class="cs-button cs-color">' . esc_html($key) . '</a></li>';
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <?php if ($cs_excerpt_length <> 0) { ?><p> <?php echo wp_trim_words($cs_automobile_content, $cs_excerpt_length); ?></p>
                                                <a href="<?php the_permalink(); ?>" class="read-more cs-color"></a>
                                            <?php }
                                            ?> 
                                            <div class="post-detail">
                                                <span class="post-author"><i class="icon-user4"></i> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></span>
                                                <span class="post-comments"><a href="<?php the_permalink(); ?>#comments"> <?php
                                                        $num_comments = get_comments_number($post->ID); // get_comments_number returns only a numeric value
                                                        echo absint($num_comments) . " ";
                                                        if ($num_comments > 1) {
                                                            echo automobile_var_theme_text_srt('automobile_var_comments_text');
                                                        } else {
                                                            echo automobile_var_theme_text_srt('automobile_var_comment_text');
                                                        }
                                                        ?></a></span>
                                                <span class="post-date"><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php echo date('F d, Y', strtotime(get_the_date())); ?></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            endwhile;
                            $qrystr = '';
                            if (isset($_GET['page_id'])) {
                                $qrystr .= "&amp;page_id=" . $_GET['page_id'];
                            }
                            echo automobile_pagination($count_post, 10, $qrystr, 'Show Pagination', 'page_id_all');
                            ?></div></div></div><?php
                        } else {
                            $automobile_notification->error(automobile_var_theme_text_srt('automobile_var_no_post_error'));
                        }
                        ?> 
            <?php
            if (isset($automobile_layout) && $automobile_layout == 'sidebar_right') {

                if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                    ?>
                    <div class="page-sidebar right col-lg-3 col-md-3 col-sm-12 col-xs-12"><?php
                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) :
                        ?><?php
                    endif;
                    ?>
                    </div>
                        <?php
                    }
                }if (is_active_sidebar('sidebar-1')) {
                    echo '<div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')) : endif;
                    echo '</div>';
                }
                ?>
        </div></div></div>
            <?php get_footer(); ?>
