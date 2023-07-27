<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Automobile
 * @since Auto Mobile 1.0
 */
?>
<?php
$var_arrays = array('post', 'automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);
$cs_excerpt_length = 60;
$cs_theme_options = get_option('automobile_var_options');
if (isset($cs_theme_options['automobile_var_excerpt_length']) && $cs_theme_options['automobile_var_excerpt_length'] <> 0) {
    $cs_excerpt_length = $cs_theme_options['automobile_var_excerpt_length'];
}
$width = '290';
$height = '218';
$automobile_var_comments = automobile_var_theme_text_srt('automobile_var_comments');
$thumbnail = automobile_get_post_img_src_search($post->ID, $width, $height);
$automobile_postObject = get_post_meta($post->ID, "automobile_full_data", true);
$automobile_gallery = get_post_meta($post->ID, 'automobile_post_list_gallery', true);
$automobile_gallery = explode(',', $automobile_gallery);
$automobile_thumb_view = get_post_meta($post->ID, 'automobile_thumb_view', true);
$automobile_thumb_view = isset($automobile_thumb_view) ? $automobile_thumb_view : '';
$audioFile = get_post_meta($post->ID, 'automobile_audio_url', true);
$videoFile = get_post_meta($post->ID, 'automobile_video_url', true);
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
                
                if ( has_post_thumbnail() ) {
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
            }
            ?>	
        </div>
        <div class="cs-text">
            <div class="post-title">
                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a></h4>
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


