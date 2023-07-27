<?php
/**
 * @ Start front end Blog list view 
 *
 *
 */
global $automobile_var_static_text;
$automobile_blog_vars = array('post', 'automobile_blog_cat', 'automobile_blog_description', 'automobile_blog_excerpt', 'automobile_notification', 'wp_query');
$automobile_blog_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($automobile_blog_vars);
extract($automobile_blog_vars);

extract($wp_query->query_vars);
$width = '350';
$height = '197';

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
	    $automobile_thumb_view = isset($automobile_thumb_view) ? $automobile_thumb_view : '';
	    $audioFile = get_post_meta($post->ID, 'automobile_audio_url', true);
	    $videoFile = get_post_meta($post->ID, 'automobile_video_url', true);
	    $current_user = wp_get_current_user();
	    $current_category = get_the_category();
	    $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
	    $avatar_image = get_avatar(get_the_author_meta('ID'));
	    $automobile_format = get_post_format();
	    if ($avatar_image == "") {
		//$custom_image_url = trailingslashit(get_template_directory_uri()).'assets/frontend/images/img-not-found16x9.jpg';
		$avatar_image = '<img src="' . trailingslashit(get_template_directory_uri()) . 'assets/frontend/images/img-not-found16x9.jpg" />';
	    }
	    $tags = get_tags();
	    ?> 
	    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="cs-blog-listing blog-classic">

		    <div class="cs-media">
			<?php if ($automobile_thumb_view == 'slider') { ?>
	    		<ul class="blog-listing-grid-slider">

				<?php echo automobile_post_slick_detail($width, $height, get_the_id(), 'post-list'); ?>
	    		</ul>
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
//                                            if (!automobile_image_exist($thumbnail) || $thumbnail == "") {
//                                               $thumbnail  = trailingslashit(get_template_directory_uri()).'assets/frontend/images/img-not-found16x9.jpg';
//                                               $thumbnail  = '<img src="'.$thumbnail.'" alt="no image" />';
//                                            }else{
//                                               // $thumbnail = the_post_thumbnail('automobile_var_media_3');
//                                            }
			    ?>
	    		<figure>
	    		    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php
		if (!automobile_image_exist($thumbnail) || $thumbnail == "") {
		    $thumbnail = trailingslashit(get_template_directory_uri()) . 'assets/frontend/images/img-not-found16x9.jpg';
				?>   <img class="lazyload no-src" src="<?php echo esc_url($thumbnail); ?>" data-src="<?php echo esc_url($thumbnail); ?>" alt="no image" /><?php
				    } else {
					the_post_thumbnail('automobile_var_media_3', array('class' => 'lazyload no-src'));
				    }
				    ?></a>

	    		    <figcaption>
				    <?php if (is_sticky()) { ?>
					<div class="caption-text"><span><?php echo esc_html($automobile_var_static_text['automobile_var_sticky_text']); ?></span></div>
				    <?php } ?>
	    		    </figcaption>
	    		</figure>
			<?php } ?>	
		    </div>
		    <div class="blog-text">
			<div class="post-meta">
			    <?php if ($avatar_image) { ?>
	    		    <figure><?php echo automobile_allow_special_char($avatar_image); ?></figure>
			    <?php }
			    ?>
			    <span class="post-by"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></span>
			    <em><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php echo date_i18n('F d, Y', strtotime(get_the_date())); ?></a></em>
			</div>
			<div class="post-option">
			    <span class="post-date">
				<?php
				$automobile_var_categories = automobile_var_cat_list(get_the_id());
				if ($automobile_var_categories != '') {
				    foreach ($automobile_var_categories as $key => $value) {
					echo '<a href="' . esc_url($value) . '" class="cs-button cs-color">' . esc_html($key) . '</a>';
					break;
				    }
				}
				?>
			    </span>
			</div>
			<div class="post-title">
			    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a></h4>
			</div>
			<?php if ($automobile_blog_description == 'yes') { ?><p> <?php echo automobile_get_excerpt($automobile_blog_excerpt, 'true', ''); ?></p>
	    		<a href="<?php the_permalink(); ?>" class="btn-more cs-color"></a>
			<?php }
			?> 
		    </div>
		</div>
	    </div>

	    <?php
	endwhile;
	?><?php
    } else {
	//$automobile_notification->error('No blog post found.');
	echo automobile_var_theme_text_srt('automobile_var_no_post_error');
    }
    ?>
 