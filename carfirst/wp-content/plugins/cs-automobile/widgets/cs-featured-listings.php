<?php
/**
 * @Recent posts widget Class
 *
 *
 */
if (!class_exists('automobile_featured_listings')) {

    class automobile_featured_listings extends WP_Widget {

        /**
         * @init Recent posts Module
         */
        public function __construct() {
            global $automobile_var_plugin_static_text;
			
            parent::__construct(
                    'automobile_featured_listings', // Base ID
                    automobile_var_plugin_text_srt('automobile_var_widget_featured_listings'), // Name
                    array('classname' => 'featured-listing', 'description' => automobile_var_plugin_text_srt('automobile_var_widget_featured_listings_des'),) // Args
            );
        }

        /**
         * @Recent posts html form
         *
         *
         */
        function form($instance) {
            global $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_plugin_static_text;
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $number_posts = isset($instance['number_posts']) ? esc_attr($instance['number_posts']) : '';

            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_title') ,
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($title),
                    'id' => automobile_allow_special_char($this->get_field_id('title')),
                    'classes' => '',
                    'cust_id' => automobile_allow_special_char($this->get_field_name('title')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('title')),
                    'return' => true,
                    'required' => false
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_num_post'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($number_posts),
                    'id' => automobile_allow_special_char($this->get_field_id('number_posts')),
                    'classes' => '',
                    'cust_id' => automobile_allow_special_char($this->get_field_name('number_posts')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('number_posts')),
                    'return' => true,
                    'required' => false
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
        }

        /**
         * @Recent posts update form data
         *
         *
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['number_posts'] = $new_instance['number_posts'];
            return $instance;
        }

        /**
         * @Display Recent posts widget
         *
         */
        function widget($args, $instance) {
            global $automobile_node, $wpdb, $post, $automobile_var_plugin_static_text, $automobile_var_plugin_core;
			
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));
            
            $number_posts = ( ! empty( $instance['number_posts'] ) ) ? absint( $instance['number_posts'] ) : 5;
            
            echo '<div class="widget featured-listing">';
                if (!empty($title) && $title <> ' ') {
                    echo automobile_var_special_char('<h6>' . $title . '</h6>');
                }
                ?>
                <ul>
                    <?php
                    $automobile_inventory_posted_date_formate = 'd-m-Y H:i:s';
                    $automobile_inventory_expired_date_formate = 'd-m-Y H:i:s';
                    $args = array('posts_per_page' => $number_posts, 'post_type' => 'inventory', 'order' => "DESC", 'orderby' => 'post_date',
                        'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                        'meta_query' => array(
                            array(
                                'key' => 'automobile_inventory_posted',
                                'value' => strtotime(date($automobile_inventory_posted_date_formate)),
                                'compare' => '<=',
                            ),
                            array(
                                'key' => 'automobile_inventory_expired',
                                'value' => strtotime(date($automobile_inventory_expired_date_formate)),
                                'compare' => '>=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                        )
                    );

                    $title_limit = 4;
                    $custom_query = new WP_Query($args);
                    if ($custom_query->have_posts() <> "") {
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                            $automobile_post_id = get_the_ID();

                            $automobile_new_price = get_post_meta($automobile_post_id, 'automobile_inventory_new_price', true);
                            $automobile_inv_gallery = get_post_meta($automobile_post_id, 'automobile_inventory_gallery_url', true);
                          
                            $automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';
                           $automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);
                            $automobile_img = wp_get_attachment_image_src($automobile_gal_id, 'thumbnail');
                            $automobile_img = isset($automobile_img[0]) ? $automobile_img[0] : '';
                            if ($automobile_img == '') {
                                $automobile_noimage = ' class="cs-noimage"';
                            }else{
                                $automobile_noimage = '';
                            }
                            ?>
                            <li<?php echo automobile_allow_special_char($automobile_noimage) ?>>
                                <?php if (isset($automobile_img) && $automobile_img != '') { ?>
                                    <div class="cs-media">
                                        <figure><a href="<?php echo esc_url(get_permalink()); ?>"><img src="<?php echo esc_url($automobile_img) ?>" alt=""></a></figure>
                                    </div>
                                <?php } ?>
                                <div class="cs-text">
                                    <h6><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h6>
                                    <?php echo automobile_inventory_listing_price($automobile_new_price); ?>
                                </div>

                            </li>

                            <?php
                        endwhile;
                    } else {
                        echo '<p>' . automobile_var_plugin_text_srt('automobile_var_noresult_found') . '</p>';
                    }
                    wp_reset_postdata();
                    ?>
                </ul> 
                <?php
            echo '</div>';
        }
    }

}
//add_action('widgets_init', create_function('', 'return register_widget("automobile_featured_listings");'));
	add_action( 'widgets_init', function() { 
		return register_widget("automobile_featured_listings");
	} );
