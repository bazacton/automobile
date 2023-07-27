<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
$var_arrays = array('post', 'automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
?>
<div class="cs-search-result">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="section-title">
            <h2 style="letter-spacing:0 !important; margin-bottom:15px;"><?php echo automobile_var_theme_text_srt('automobile_var_nothing'); ?></h2>
        </div>
    </div><!-- .page-header -->
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="cs-seggetions">
            <?php if (is_home() && current_user_can('publish_posts')) { ?>

                <p><?php printf(automobile_var_theme_text_srt('automobile_var_ready_publish'), esc_url(admin_url('post-new.php'))); ?></p>

            <?php } elseif (is_search()) { ?>

                <div class="cs-heading">
                    <h4><?php echo automobile_var_theme_text_srt('automobile_var_suggestions'); ?></h4>
                </div>
                <ul>
                    <li><i class="icon-check cs-color"></i><?php echo automobile_var_theme_text_srt('automobile_var_make_sure'); ?></li>
                    <li><i class="icon-check cs-color"></i><?php echo automobile_var_theme_text_srt('automobile_var_wildcard_searches'); ?></li>
                    <li><i class="icon-check cs-color"></i><?php echo automobile_var_theme_text_srt('automobile_var_try_more'); ?></li>
                </ul>
                <?php
                get_search_form();
            } else {
                ?>
                <p><?php echo automobile_var_theme_text_srt('automobile_var_perhaps'); ?></p>
                <?php get_search_form();
            }
            ?>

        </div>
    </div>
</div>
