<?php
/**
 * Inventories Grid view
 *
 */
global $wpdb, $a, $args, $count_post, $automobile_blog_num_post, $automobile_var_plugin_core, $automobile_var_plugin_static_text;
$automobile_var_no_inventory_found = isset($automobile_var_plugin_static_text['automobile_var_no_inventory_found']) ? $automobile_var_plugin_static_text['automobile_var_no_inventory_found'] : '';

echo '<div class="cs-auto-listing cs-auto-box">';
echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

if (isset($args['post__in'])) {
    unset($args['post__in']);
}
if (isset($args['paged'])) {
    unset($args['paged']);
}

$loop = new WP_Query($args);

if ($loop->have_posts()) {
    ?>
    <ul class="cs-auto-box-slider row">
        <?php
        while ($loop->have_posts()) : $loop->the_post();
            global $post;

            $automobile_old_price = get_post_meta($post->ID, 'automobile_inventory_old_price', true);
            $automobile_new_price = get_post_meta($post->ID, 'automobile_inventory_new_price', true);

            $inventory_type_slug = get_post_meta($post->ID, 'automobile_inventory_type', true);

            if ($inventory_type_slug != '') {
                $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
                $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;
            } else {
                $inventory_type_id = '';
            }

            $price_status = get_post_meta($inventory_type_id, "automobile_price_switch", true);

            $automobile_inv_feature_list = get_post_meta($post->ID, 'automobile_inventory_feature_list', true);
            $automobile_inventory_featured = get_post_meta($post->ID, 'automobile_inventory_featured', true);


            $automobile_inv_gallery = get_post_meta($post->ID, 'automobile_inventory_gallery_url', true);

            $automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';

            $automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);
            $automobile_img_url = automobile_get_image_thumb($automobile_gal_url, 'automobile_var_media_4');
            if (isset($automobile_img_url) && $automobile_img_url != '') {
                $automobile_img_url = $automobile_img_url;
            } else {
                $automobile_img_url = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found16x9.jpg');
            }
            ?>

            <li class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="cs-media">
                    <?php if ($automobile_inventory_featured == 'yes') { ?>
                        <span class="featured"></span>
                    <?php } ?>
                    <figure> 
                        <?php if (isset($automobile_img_url) && $automobile_img_url != '') { ?>
                            <a href="<?php echo esc_url(get_permalink()) ?>"><img class="lazyload no-src" src="<?php echo esc_url($automobile_img_url) ?>" data-src="<?php echo esc_url($automobile_img_url) ?>" alt="<?php echo get_the_title($post->ID); ?>"></a>
                        <?php } ?>
                        <figcaption> 

                        </figcaption>
                    </figure>
                    <div class="caption-text"> 
                        <a href="<?php echo esc_url(get_permalink()) ?>"><h2><?php echo wp_trim_words(get_the_title($post->ID), 6, '...') ?></h2></a>
                    </div>
                </div>
                <div class="auto-text cs-bgcolor"> 
                    <?php
                    if ($price_status == 'on') {
                        echo automobile_inventory_listing_price($automobile_new_price, $automobile_old_price, '', 'slider');
                    }
                    ?>
                    <a href="<?php echo esc_url(get_permalink()) ?>" class="cs-button pull-right">
                        <i class="icon-arrow_forward"></i>
                    </a> 
                </div>
            </li>
            <?php
        endwhile;
        ?>
    </ul>
    <?php
} else {
    echo '<p>' . automobile_var_plugin_text_srt('automobile_var_no_inventory_found') . '</p>';
}
echo '</div>';
echo '</div>';