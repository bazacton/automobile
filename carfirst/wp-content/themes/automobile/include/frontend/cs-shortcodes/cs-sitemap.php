<?php
/**
 * @Spacer html form for page builder
 */
if (!function_exists('automobile_sitemap')) {

    function automobile_sitemap($atts, $content = "") {
        global $automobile_border, $automobile_var_plugin_options, $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_theme_option_strings();
        $automobile_search_result_page = isset($automobile_var_plugin_options['automobile_search_result_page']) ? $automobile_var_plugin_options['automobile_search_result_page'] : '';

        $defaults = array('automobile_sitemap_section_title' => '');
        extract(shortcode_atts($defaults, $atts));

        $automobile_sitemap_section_title = $automobile_sitemap_section_title ? $automobile_sitemap_section_title : '';
        ob_start();
        ?>
        <div class="row">
            <div class="sitemap-links">	
                <?php if (isset($automobile_sitemap_section_title) && $automobile_sitemap_section_title != '') { ?>
                    <div class="cs-element-title col-md-12">
                        <h2><?php echo esc_html($automobile_sitemap_section_title); ?></h2>
                    </div> 
                <?php } ?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h3><?php echo automobile_var_theme_text_srt('automobile_var_pages'); ?></h3>
                        <ul>
                            <?php
                            $args = array(
                                'posts_per_page' => "-1",
                                'post_type' => 'page',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                            );
                            $query = new WP_Query($args);
                            $post_count = $query->post_count;
                            if ($query->have_posts()) {
                                while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                    <?php
                                endwhile;
                            }
							wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                    <div class="site-maps-links">
                        <h4><?php echo automobile_var_theme_text_srt('automobile_var_tag'); ?></h4>
                        <ul>
                            <?php
                            $tags = get_tags(array('order' => 'ASC', 'post_type' => 'post', 'order' => 'DESC'));
                            foreach ((array) $tags as $tag) {
                                ?>
                                <li> <?php echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" rel="tag">' . $tag->name . ' (' . $tag->count . ') </a>'; ?></li>
                                <?php
                            }
                            ?>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h4><?php echo automobile_var_theme_text_srt('automobile_var_posts'); ?></h4>
                        <ul>
                            <?php
                            $args = array(
                                'posts_per_page' => "-1",
                                'post_type' => 'post',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                            );
                            $query = new WP_Query($args);
                            $post_count = $query->post_count;
                            if ($query->have_posts()) {
                                while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></a></li>
                                    <?php
                                endwhile;
                            }
							wp_reset_postdata();
                            ?>
                        </ul>
                    </div>	
                    <div class="site-maps-links">
                        <h4><?php echo automobile_var_theme_text_srt('automobile_var_categories'); ?></h4>
                        <ul>
                            <?php
                            $args = array(
                                'show_option_all' => '',
                                'order' => 'ASC',
                                'post_type' => 'post',
                                'order' => 'ASC',
                                'style' => 'list',
                                'title_li' => '',
                                'taxonomy' => 'category'
                            );

                            wp_list_categories($args);
                            ?>

                        </ul>
                    </div>
                    <div class="site-maps-links">
                        <h4><?php echo automobile_var_theme_text_srt('automobile_var_dealer_types'); ?></h4>
                        <ul>
                            <?php
                            $country_args = array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'fields' => 'all',
                                'slug' => '',
                                'hide_empty' => false,
                            );
                            $terms = get_terms('dealer_type', $country_args);
                            if (!empty($terms)) {
                                $dealer_type = '';
                                foreach ($terms as $term) {
                                    $dealer_type = $term->name;
                                    ?>
                                    <li><a href=""><?php echo esc_html($dealer_type); ?></a></li>
                                    <?php
                                }
                            }
                            ?>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h4><?php echo automobile_var_theme_text_srt('automobile_var_inventories'); ?></h4>
                        <ul>
                            <?php
                            $args = array(
                                'posts_per_page' => "-1",
                                'post_type' => 'inventory',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                            );
                            $query = new WP_Query($args);
                            $post_count = $query->post_count;
                            if ($query->have_posts()) {
                                while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></a></li>
                                    <?php
                                endwhile;
                            }
							wp_reset_postdata();
                            ?>
                        </ul>
                    </div>	

                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="site-maps-links">
                        <h4><?php echo automobile_var_theme_text_srt('automobile_var_inventory_types'); ?></h4>
                        <ul>
                            <?php
                            $args = array(
                                'posts_per_page' => "-1",
                                'post_type' => 'inventory-type',
                                'order' => 'ASC',
                                'post_status' => 'publish',
                            );
                            $query = new WP_Query($args);
                            $post_count = $query->post_count;
                            if ($query->have_posts()) {
                                while ($query->have_posts()) : $query->the_post();
                                    ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 3, '...'); ?></a></li>
                                    <?php
                                endwhile;
                            }
							wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                </div>
            </div> 
        </div> 
        <?php
        $automobile_sitemap = ob_get_clean();
        return do_shortcode($automobile_sitemap);
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('automobile_sitemap', 'automobile_sitemap');
    }
}