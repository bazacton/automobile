<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
$var_arrays = array('post', 'automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->

    <?php automobile_post_thumbnail(); ?>

    <div class="entry-content">
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

    <?php
    edit_post_link(
            sprintf(
                    /* translators: %s: Name of current post */
                    automobile_var_theme_text_srt('automobile_var_image_edit'), get_the_title()
            ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->'
    );
    ?>

</article><!-- #post-## -->
