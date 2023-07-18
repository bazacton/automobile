<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 */
get_header();
$var_arrays = array('post', 'automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
$var_arrays = array('post');
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
                            <!--                    <div class="row">-->
                            <?php
                            if (is_author()) {
                                $var_arrays = array('author');
                                $archive_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
                                extract($archive_global_vars);
                                $userdata = get_userdata($author);
                            }
                            if (category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))) {
//                            echo '<div class="widget evorgnizer">';
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
//                            echo '</div>';
                            }
                            if (empty($_GET['page_id_all'])) {
                                $_GET['page_id_all'] = 1;
                            }
                            if (!isset($_GET["s"])) {
                                $_GET["s"] = '';
                            }
                            $description = 'yes';
                            $taxonomy = 'category';
                            $taxonomy_tag = 'post_tag';
                            $args_cat = array();
                            if (is_author()) {
                                $args_cat = array('author' => $wp_query->query_vars['author']);

                                $post_type = array('post');
                            } elseif (is_date()) {
                                
                              if (is_month() || is_year() || is_day() || is_time()) {
                                $cs_month = $wp_query->query_vars['monthnum'];
                                $cs_year = $wp_query->query_vars['year'];
                                $cs_month = $cs_month;
                                $args_cat = array('monthnum' => $cs_month, 'year' => $wp_query->query_vars['year'], 'day' => $wp_query->query_vars['day'], 'hour' => $wp_query->query_vars['hour'], 'minute' => $wp_query->query_vars['minute'], 'second' => $wp_query->query_vars['second']);
                            }
                            } else if ((isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy']))) {
                                $taxonomy = $wp_query->query_vars['taxonomy'];
                                $taxonomy_category = '';
                                if (isset($wp_query->query_vars[$taxonomy])) {
                                    $taxonomy_category = $wp_query->query_vars[$taxonomy];
                                }
                                if (isset($wp_query->query_vars['taxonomy']) && $wp_query->query_vars['taxonomy'] == 'service-category') {
                                    $args_cat = array($taxonomy => "$taxonomy_category");
                                    $post_type = 'service';
                                } else if (isset($wp_query->query_vars['taxonomy']) && $wp_query->query_vars['taxonomy'] == 'stylist-category') {
                                    $args_cat = array($taxonomy => "$taxonomy_category");
                                    $post_type = 'stylist';
                                } else {
                                    $taxonomy = 'category';
                                    $args_cat = array();
                                    $post_type = 'post';
                                }
                            } else if (is_category()) {

                                $taxonomy = 'category';
                                $args_cat = array();
                                $category_blog = '';
                                if (isset($wp_query->query_vars['cat'])) {
                                    $category_blog = $wp_query->query_vars['cat'];
                                }
                                $post_type = 'post';
                                $args_cat = array('cat' => "$category_blog");
                            } else if (is_tag()) {

                                $taxonomy = 'category';
                                $args_cat = array();
                                $tag_blog = '';
                                if (isset($wp_query->query_vars['tag'])) {
                                    $tag_blog = $wp_query->query_vars['tag'];
                                }
                                $post_type = 'post';
                                $args_cat = array('tag' => "$tag_blog");
                            } else {

                                $taxonomy = 'category';
                                $args_cat = array();
                                $post_type = 'post';
                            }
                            $args = array(
                                'post_type' => $post_type,
                                'paged' => $_GET['page_id_all'],
                                'post_status' => 'publish',
                                'order' => 'DESC',
                            );

                            $args = array_merge($args_cat, $args);
                            
                            $custom_query = new WP_Query($args);
                            if (have_posts()) :

                                if (empty($_GET['page_id_all'])) {
                                    $_GET['page_id_all'] = 1;
                                }
                                if (!isset($_GET["s"])) {
                                    $_GET["s"] = '';
                                }
                                while ($custom_query->have_posts()) : $custom_query->the_post();
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
                                wp_reset_postdata();
                            else:
                                if (function_exists('automobile_no_result_found')) {
                                    automobile_no_result_found();
                                }
                            endif;
                            $qrystr = '';
                            if (isset($_GET['page_id'])) {
                                $qrystr .= "&page_id=" . $_GET['page_id'];
                            }
                            if (isset($_GET['specialisms'])) {
                                $qrystr .= "&specialisms=" . $_GET['specialisms'];
                            }

                            if ($wp_query->found_posts > get_option('posts_per_page')) {
                                if (function_exists('automobile_pagination')) {

                                    echo automobile_pagination($custom_query->found_posts, get_option('posts_per_page'), $qrystr, 'Show Pagination', 'page_id_all');
                                }
                            }
                            ?>
                        </div></div></div>
                <?php
                if (isset($automobile_layout) and $automobile_layout == 'sidebar_right') {
                    if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                        echo '<div class="page-sidebar right col-md-3">';
                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
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

    <?php get_footer(); ?>