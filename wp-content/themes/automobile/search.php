<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Automobile
 * @since Auto Mobile 1.0
 */
get_header();

$var_arrays = array('post', 'automobile_var_static_text');
$archive_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($archive_global_vars);
$automobile_var_options = AUTOMOBILE_VAR_GLOBALS()->theme_options();
if (isset($automobile_var_options['automobile_var_excerpt_length']) && $automobile_var_options['automobile_var_excerpt_length'] <> '') {
    $default_excerpt_length = $automobile_var_options['automobile_var_excerpt_length'];
} else {
    $default_excerpt_length = '120';
}
$automobile_layout = isset($automobile_var_options['automobile_var_default_page_layout']) ? $automobile_var_options['automobile_var_default_page_layout'] : '';

if (isset($automobile_layout) && ($automobile_layout == "sidebar_left" || $automobile_layout == "sidebar_right")) {
    $automobile_col_class = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else {
    $automobile_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
if (!get_option('automobile_var_options') && is_active_sidebar('sidebar-1')) {
    $automobile_col_class = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $automobile_def_sidebar = 'sidebar-1';
}

$automobile_sidebar = isset($automobile_var_options['automobile_var_default_layout_sidebar']) ? $automobile_var_options['automobile_var_default_layout_sidebar'] : '';
$automobile_tags_name = 'post_tag';
$automobile_categories_name = 'category';
$width = '350';
$height = '210';

if (!isset($_GET['page_id_all']))
    $_GET['page_id_all'] = 1;


//$_GET['paged'] = $_GET['page_id_all']; 
?>   

<div class="main-section">
    <div class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!--Left Sidebar Starts-->
                <?php if ($automobile_layout == 'sidebar_left') { ?>
                    <div class="page-sidebar left col-md-3">
                        <?php
                        if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
                        }
                        ?>
                    </div>
                <?php } ?>
                <!--Left Sidebar End-->
                <!-- Page Detail Start -->
                <div class= "<?php echo esc_html($automobile_col_class); ?>">
                    <div class="content-area">
                        <div class="row">
                            <?php
                            if (is_author()) {
                                $var_arrays = array('author');
                                $archive_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
                                extract($archive_global_vars);
                                $userdata = get_userdata($author);
                            }
                            if (category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))) {
                                echo '<div class="widget evorgnizer">';
                                if (is_author()) {
                                    ?>
                                    <figure>
                                        <a>
                                            <?php
                                            echo get_avatar($userdata->user_email, apply_filters('automobile_author_bio_avatar_size', 70));
                                            ?>
                                        </a>
                                    </figure>
                                    <div class="left-sp">
                                        <h5><a><?php echo esc_attr($userdata->display_name); ?></a></h5>
                                        <p><?php echo automobile_allow_special_char($userdata->description, true); ?></p>
                                    </div>
                                    <?php
                                } elseif (is_category()) {
                                    $category_description = category_description();
                                    if (!empty($category_description)) {
                                        ?>
                                        <div class="left-sp">
                                            <p><?php echo category_description(); ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php
                                } elseif (is_tag()) {
                                    $tag_description = tag_description();
                                    if (!empty($tag_description)) {
                                        ?>
                                        <div class="left-sp">
                                            <p><?php echo apply_filters('tag_archive_meta', $tag_description); ?></p>
                                        </div>
                                        <?php
                                    }
                                }
                                echo '</div>';
                            }
                            if (have_posts()) {
                                ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="cs-search-result">
                                        <div class="cs-relevent-links ">
                                            <div class="row">
                                                <?php
                                                while (have_posts()) : the_post();
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
                                                    ?>  

                                                    <?php get_template_part('template-parts/content'); ?>

                                                    <?php
                                                endwhile;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                get_template_part('template-parts/content-none');
                            }
                            $qrystr = '';

                            if ($wp_query->found_posts > get_option('posts_per_page')) {
                                if (isset($_GET['s']))
                                    $qrystr = "&amp;s=" . $_GET['s'];
                                if (isset($_GET['page_id']))
                                    $qrystr .= "&amp;page_id=" . $_GET['page_id'];
                                echo automobile_pagination($wp_query->found_posts, get_option('posts_per_page'), $qrystr, automobile_var_theme_text_srt('automobile_var_search_pagination'), 'page_id_all');
                            }
                            ?>
                        </div></div>
                </div>
                <?php if (isset($automobile_layout) and $automobile_layout == 'sidebar_right') { 
                    if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                        echo '<div class="page-sidebar right col-md-3">';
                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) :
                            ?><?php
                            endif;
                             echo '</div>';
                        }
                }
                if (is_active_sidebar('sidebar-1')) {
                    echo '<div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')) : endif;
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>