<?php
/**
 * The template part for displaying an Author biography
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
$var_arrays = array('automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
?>

<div class="author-info">
    <div class="author-avatar">
        <?php
        /**
         * Filter the Auto Mobile author bio avatar size.
         *
         * @since Auto Mobile 1.0
         *
         * @param int $size The avatar height and width size in pixels.
         */
        $author_bio_avatar_size = apply_filters('automobile_author_bio_avatar_size', 42);

        echo get_avatar(get_the_author_meta('user_email'), $author_bio_avatar_size);
        ?>
    </div><!-- .author-avatar -->

    <div class="author-description">
        <h2 class="author-title"><span class="author-heading"><?php echo automobile_var_theme_text_srt('automobile_var_author'); ?></span> <?php echo get_the_author(); ?></h2>

        <p class="author-bio">
            <?php the_author_meta('description'); ?>
            <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                <?php printf(automobile_var_theme_text_srt('automobile_var_view_posts'), get_the_author()); ?>
            </a>
        </p><!-- .author-bio -->
    </div><!-- .author-description -->
</div><!-- .author-info -->
