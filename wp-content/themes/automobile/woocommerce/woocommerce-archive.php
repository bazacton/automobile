<?php
/**
 * Shop Archive
 */
$var_arrays = array('post', 'automobile_var_options');
$page_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);
$automobile_layout = isset($automobile_var_options['automobile_var_woo_archive_layout']) ? $automobile_var_options['automobile_var_woo_archive_layout'] : '';
if ($automobile_layout == "sidebar_left" || $automobile_layout == "sidebar_right") {
    $automobile_col_class = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else {
    $automobile_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
$automobile_sidebar = isset($automobile_var_options['automobile_var_woo_archive_sidebar']) ? $automobile_var_options['automobile_var_woo_archive_sidebar'] : '';
?>   
<div class="main-section">
    <div class="page-section">
        <!-- Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <?php if ($automobile_layout == 'sidebar_left') { ?>
                    <div class="page-sidebar left col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php
                        if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
                        }
                        ?>
                    </div>
                <?php } ?>
                <div class="<?php echo esc_html($automobile_col_class); ?>">
                    <?php
                    if (function_exists('woocommerce_content')) {
                        woocommerce_content();
                    }
                    ?>
                </div>
                <?php if ($automobile_layout == 'sidebar_right') { ?>
                    <div class="page-sidebar right col-lg-3 col-md-3 col-sm-12 col-xs-12"><?php
                    if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
                    }
                    ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>