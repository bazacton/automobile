<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage Automobile
 * @since Automobile
 */
get_header();

if (isset($automobile_var_options['automobile_var_excerpt_length']) && $automobile_var_options['automobile_var_excerpt_length'] <> '') {
    $default_excerpt_length = $automobile_var_options['automobile_var_excerpt_length'];
} else {
    $default_excerpt_length = '60';
}
$automobile_layout = isset($automobile_var_options['automobile_var_default_page_layout']) ? $automobile_var_options['automobile_var_default_page_layout'] : '';
$automobile_default_sidebar = false;
if ($automobile_layout == '') {
    $automobile_default_sidebar = true;
}
if (isset($automobile_layout) && ($automobile_layout == "sidebar_left" || $automobile_layout == "sidebar_right")) {
    $automobile_col_class = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else if ($automobile_default_sidebar == true) {
    $automobile_col_class = "page-content col-lg-9 col-md-9 col-sm-12 col-xs-12";
} else {
    $automobile_col_class = "page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12";
}
$strings = new automobile_theme_all_strings;
$strings->automobile_theme_option_strings();
$automobile_sidebar = isset($automobile_var_options['automobile_var_default_layout_sidebar']) ? $automobile_var_options['automobile_var_default_layout_sidebar'] : '';
$automobile_blog_excerpt_theme_option = isset($automobile_var_options['automobile_var_excerpt_length']) ? $automobile_var_options['automobile_var_excerpt_length'] : '255';
?><div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <!-- .entry -header -->
        <div class="main-section"> 
            <div class="page-section" style=" margin-bottom:30px;">
                <div class="container">
                    <div class="row">
                        <?php if ($automobile_layout == 'sidebar_left') { ?>
                            <div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <?php
                                if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) : endif;
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <div class="<?php echo esc_html($automobile_col_class); ?>">
                            <?php

                            // Start the loop.
                            while (have_posts()) : the_post();
                                ?>

                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                    <nav id="image-navigation" class="navigation image-navigation">
                                        <div class="nav-links">
                                            <div class="nav-previous"><?php previous_image_link(false, automobile_var_theme_text_srt('automobile_var_page_previous')); ?></div>
                                            <div class="nav-next"><?php next_image_link(false, automobile_var_theme_text_srt('automobile_var_page_next')); ?></div>
                                        </div><!-- .nav-links -->
                                    </nav><!-- .image-navigation -->

                                    <header class="entry-header">
                                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                                    </header><!-- .entry-header -->

                                    <div class="entry-content">

                                        <div class="entry-attachment">
                                            <?php
                                            /**
                                             * Filter the default automobile image attachment size.
                                             *
                                             * @since Traveladvisor
                                             *
                                             * @param string $image_size Image size. Default 'large'.
                                             */
                                            $image_size = apply_filters('automobile_attachment_size', 'large');

                                            echo wp_get_attachment_image(get_the_ID(), $image_size);
                                            ?>

                                            <?php
                                            if (function_exists('automobile_excerpt')):
                                                automobile_excerpt('entry-caption');
                                            endif;
                                            ?>

                                        </div><!-- .entry-attachment -->

                                        <?php
                                        the_content();
                                        wp_link_pages(array(
                                            'before' => '<div class="page-links"><span class="page-links-title">' . automobile_var_theme_text_srt('automobile_var_pages') . '</span>',
                                            'after' => '</div>',
                                            'link_before' => '<span>',
                                            'link_after' => '</span>',
                                            'pagelink' => '<span class="screen-reader-text">' . automobile_var_theme_text_srt('automobile_var_page') . ' </span>%',
                                            'separator' => '<span class="screen-reader-text">, </span>',
                                        ));
                                        ?>
                                    </div><!-- .entry-content -->

                                    <footer class="entry-footer">


                                        <?php
                                        if (function_exists('automobile_entry_meta')):
                                            automobile_entry_meta();
                                        endif;
                                        ?>
                                        <?php
                                        // Retrieve attachment metadata.
                                        $metadata = wp_get_attachment_metadata();
                                        if ($metadata) {
                                            printf('<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>', esc_html_x('Full size', 'Used before full size attachment link.', 'automobile'), esc_url(wp_get_attachment_url()), absint($metadata['width']), absint($metadata['height'])
                                            );
                                        }

                                        edit_post_link(
                                                sprintf(
                                                        /* translators: %s: Name of current post */
                                                        __('Edit<span class="screen-reader-text"> "%s"</span>', 'automobile'), get_the_title()
                                                ), '<span class="edit-link">', '</span>'
                                        );
                                        ?>
                                    </footer><!-- .entry-footer -->
                                </article><!-- #post-## -->


                                <?php
                                // If comments are open or we have at least one comment, load up the comment template.
                                if (comments_open() || get_comments_number()) {
                                    comments_template();
                                }

                                // Parent post navigation.
                                the_post_navigation(array(
                                    'prev_text' => _x('<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'automobile'),
                                ));
// End the loop.
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                        <?php
                        if (isset($automobile_layout) && $automobile_layout == 'sidebar_right') {

                            if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar))) {
                                ?>
                                <div class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12"><?php
                                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar)) :
                                        ?><?php
                                    endif;
                                    ?>
                                </div>
                                <?php
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
    </main><!-- .Site Main start -->
</div><!-- .content-area -->
<?php get_footer(); ?>
