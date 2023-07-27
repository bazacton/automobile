<?php
/**
 * @ Start front end Blog list view 
 *
 *
 */
$automobile_blog_vars = array('post', 'automobile_blog_cat', 'automobile_blog_description', 'automobile_blog_excerpt', 'automobile_notification', 'wp_query');
$automobile_blog_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($automobile_blog_vars);
extract($automobile_blog_vars);

extract($wp_query->query_vars);
$width = '775';
$height = '436';

$query = new WP_Query($args);
$post_count = $query->post_count;
if ($query->have_posts()) {
    $postCounter = 0;
    wp_reset_postdata();
    ?>  
            <div class="row">
                <?php
                while ($query->have_posts()) : $query->the_post();
                    $thumbnail = automobile_get_post_img_src($post->ID, $width, $height);
                    $automobile_postObject = get_post_meta($post->ID, "automobile_full_data", true);
                    $automobile_gallery = get_post_meta($post->ID, 'automobile_post_list_gallery', true);
                    $automobile_gallery = explode(',', $automobile_gallery);
                    $automobile_thumb_view = get_post_meta($post->ID, 'automobile_thumb_view', true);
                    $audioFile = get_post_meta($post->ID, 'automobile_audio_url', true);
                    $videoFile = get_post_meta($post->ID, 'automobile_video_url', true);
                    $automobile_thumb_view = isset($automobile_thumb_view) ? $automobile_thumb_view : '';
                    $current_user = wp_get_current_user();
                    $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
                    $tags = get_tags();
                    ?> 
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="blog-listing large-view">
                            
                                <div class="cs-media">
                                    <?php if ($automobile_thumb_view == 'slider') { ?>
                                        <ul class="blog-listing-large-slider">
                                            <?php echo automobile_post_slick_detail($width, $height, get_the_id(), 'post-list'); ?>
                                        </ul>
                                        <?php
                                        } elseif ($automobile_thumb_view == 'audio') {
                                            if ($audioFile <> '') {
                                                ?>
                                                <?php echo wp_audio_shortcode(array('src' => esc_url($audioFile))); ?>
                                                <?php
                                            }
                                        } elseif($automobile_thumb_view== 'video'){
                                            if ($videoFile <> '') {
                                                echo wp_oembed_get(automobile_allow_special_char($videoFile), array('height'=>$height));
                                            }
                                        }
                                        elseif($automobile_thumb_view=='single') {
                                           // if (the_post_thumbnail('automobile_var_media_1') !== NULL) {
                                            ?>
                                        <figure>
                                            <?php
                                                the_post_thumbnail('automobile_var_media_1',array('class'=>'lazyload no-src'));
                                            ?>
                                        </figure>
                                <?php   } ?>
                             </div>
                            <div class="cs-text">
                                <div class="post-detail">
                                    <span class="post-author"><i class="icon-user4"></i> by <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></span>
                                    <span class="post-date"> <a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php echo date('d F Y', strtotime(get_the_date())); ?></a></span>
                                    <span class="post-comments"><a href="<?php the_permalink(); ?>#comments"><i class="icon-bubble2"></i> <?php
                                            $num_comments = get_comments_number($post->ID); // get_comments_number returns only a numeric value
                                            echo absint($num_comments) . " ";
                                            if ($num_comments > 1) {
                                                echo automobile_var_theme_text_srt('automobile_var_comments_text');
                                            } else {
                                                echo automobile_var_theme_text_srt('automobile_var_comment_text');
                                            }
                                            ?></a></span>
                                </div>
                                <div class="post-title">
                                    <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php
                                            echo wp_trim_words(get_the_title(), 10, '...');
                                            ?></a></h2>
                                </div>
                                <?php if ($automobile_blog_description == 'yes') { ?><p> <?php echo automobile_get_excerpt($automobile_blog_excerpt, 'true', ''); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn-more cs-color"><?php echo automobile_var_theme_text_srt('automobile_var_readmore_text'); ?></a>
                                <?php }
                                ?> 
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
               
} else {
    $automobile_notification->error(automobile_var_theme_text_srt('automobile_var_no_post_error'));
}
?>
 