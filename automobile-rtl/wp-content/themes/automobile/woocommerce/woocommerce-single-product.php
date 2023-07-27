<?php
/*
 * Remove wordpress 
 * default comment 
 * filter
 */
do_action('automobile_deregister_filter', 'comment_form_field_comment', 'automobile_filter_comment_form_field_comment');
do_action('automobile_deregister_action', 'comment_form_logged_in_after', 'automobile_comment_tut_fields');
do_action('automobile_deregister_action', 'comment_form_after_fields', 'automobile_comment_tut_fields');
do_action('automobile_deregister_filter', 'comment_form_submit_button', 'awesome_comment_form_submit_button');

/**
 * The template for 
 * product detail
 */
get_header();
$automobile_page_sidebar_right = '';
$automobile_page_sidebar_left = '';
$automobile_var_layout = '';
$leftSidebarFlag = false;
$rightSidebarFlag = false;
$automobile_var_layout = get_post_meta($post->ID, 'automobile_var_page_layout', true);
$automobile_sidebar_right = get_post_meta($post->ID, 'automobile_var_page_sidebar_right', true);
$automobile_sidebar_left = get_post_meta($post->ID, 'automobile_var_page_sidebar_left', true);

if ($automobile_var_layout == 'left') {
    $automobile_var_layout = "col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $leftSidebarFlag = true;
} else if ($automobile_var_layout == 'right') {
    $automobile_var_layout = "col-lg-9 col-md-9 col-sm-12 col-xs-12";
    $rightSidebarFlag = true;
} else {
    $automobile_var_layout = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
?>
<div class="main-section"> 
    <div class="page-section">
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

                <div class="page-content <?php echo automobile_allow_special_char($automobile_var_layout) ?>">
                    <div class="site-main">
                        <?php
                        if (function_exists('woocommerce_content')) {
                            woocommerce_content();
                        }
                        ?>
                    </div>

                <?php if ($rightSidebarFlag == true) { ?>
                    <div class="page-sidebar right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php
                        if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar_right))) {
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar_right)) : endif;
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div><!-- .Site Main start -->
</div><!-- .content-area -->
<?php get_footer(); ?>
