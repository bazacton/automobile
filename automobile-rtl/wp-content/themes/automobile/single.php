<?php
/**
 * The template for displaying all single posts and attachments
 */
$automobile_postid = get_the_id();
automobile_post_views_count($automobile_postid);


$var_arrays = array('post');
$page_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);
$automobile_page_sidebar_right = '';
$automobile_page_sidebar_left = '';
$automobile_var_layout = '';
$leftSidebarFlag = false;
$rightSidebarFlag = false;
$width = 870;
$height = 446;
$image_url = automobile_get_post_img_src($post->ID, 960, 540);
$automobile_section_bg = $image_url <> '' ? esc_url($image_url) : '';
$automobile_var_layout = get_post_meta($post->ID, 'automobile_var_page_layout', true);
$automobile_sidebar_right = get_post_meta($post->ID, 'automobile_var_page_sidebar_right', true);
$automobile_sidebar_left = get_post_meta($post->ID, 'automobile_var_page_sidebar_left', true);
$inside_detail_view = get_post_meta($post->ID, 'automobile_detail_view', true);
$automobile_blog_view = get_post_meta($post->ID, 'automobile_blog_views', true);

if ($automobile_var_layout == 'left') {
    $automobile_var_layout = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $leftSidebarFlag = true;
} else if ($automobile_var_layout == 'right') {
    $automobile_var_layout = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $rightSidebarFlag = true;
} else {
    $automobile_var_layout = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
if (!get_option('automobile_var_options') && is_active_sidebar('sidebar-1')) {
    $automobile_var_layout = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $automobile_def_sidebar = 'sidebar-1';
}
if (!function_exists('automobile_fancy_view_body_classes')) {

// add fancy class in body when view = fancy
    function automobile_fancy_view_body_classes($classes) {
        $classes[] = 'fancy-view';
        return $classes;
    }

    if ($automobile_blog_view == 'fancy') {
        add_filter('body_class', 'automobile_fancy_view_body_classes');
    }
}
get_header();
?>
<!-- .entry -header -->
<div class="main-section"> 
    <div class="page-section" >
        <div class="container">
            <div class="row">
                <?php if ($leftSidebarFlag == true) { ?>
                    <div class="page-sidebar left col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php
                        if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar_left))) {
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar_left)) : endif;
                        }
                        ?>
                    </div>
                <?php } ?>

                <div class="<?php echo automobile_allow_special_char($automobile_var_layout) ?>">
                    <div class="content-area">
                        <?php
                        // Start the loop.
                        $automobile_var_post_type = '';
                        while (have_posts()) : the_post();
                            $automobile_var_post_type = get_post_type();
                            // Include the single post content template.
                            if ($automobile_var_post_type <> '' && $automobile_var_post_type == 'post') {
                                get_template_part('template-parts/content-single', 'single');
                            }

                        // End of the loop.
                        endwhile;
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) {
                            $var_arrays = array('automobile_var_args');
                            $single_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
                            extract($single_global_vars);
                            comments_template();
                        }
                        ?>
                    </div>
                </div>
                <?php if ($rightSidebarFlag == true) { ?>
                    <div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php
                        if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar_right))) {
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar_right)) : endif;
                        }
                        ?>
                    </div>
                    <?php
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
