<?php
/**
 * @Recent posts widget Class
 *
 *
 */
if (!class_exists('automobile_recentposts')) {

    class automobile_recentposts extends WP_Widget {

        /**
         * @init Recent posts Module
         *
         *
         */
        public function __construct() {
            global $automobile_var_static_text;
            
            parent::__construct(
                    'automobile_recentposts', // Base ID
                    automobile_var_theme_text_srt('automobile_var_recent_post'), // Name
                    array('classname' => 'widget-recent-blog', 'description' => automobile_var_theme_text_srt('automobile_var_recent_post_des'),) // Args
            );
        }

        /**
         * @Recent posts html form
         *
         *
         */
        function form($instance) {
            global $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_static_text;
            $strings = new automobile_theme_all_strings;
            $strings->automobile_short_code_strings();
            
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $select_category = isset($instance['select_category']) ? esc_attr($instance['select_category']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
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
            if (function_exists('automobile_show_all_cats')) {
                $a_options = array();
                $a_options = automobile_show_all_cats('', '', automobile_allow_special_char($this->get_field_id('select_category')), "category", true);
                $automobile_opt_array = array(
                    'name' => automobile_var_theme_text_srt('automobile_var_choose_category'),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => true,
                    'field_params' => array(
                        'std' => $select_category,
                        'cust_name' => automobile_allow_special_char($this->get_field_name('select_category')),
                        'cust_id' => automobile_allow_special_char($this->get_field_id('select_category')),
                        'id' => '',
                        'classes' => 'chosen-select cs-recentpost-width',
                        'options' => $a_options,
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
            }
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_num_post'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($showcount),
                    'id' => automobile_allow_special_char($this->get_field_id('showcount')),
                    'classes' => '',
                    'cust_id' => automobile_allow_special_char($this->get_field_name('showcount')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('showcount')),
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
            $instance['select_category'] = $new_instance['select_category'];
            $instance['showcount'] = $new_instance['showcount'];
            return $instance;
        }

        /**
         * @Display Recent posts widget
         *
         */
        function widget($args, $instance) {
            global $automobile_node, $wpdb, $post, $automobile_var_static_text;
            
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = wp_specialchars_decode(stripslashes($title));
            $select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);
            $showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);

            if ($instance['showcount'] == "") {
                $instance['showcount'] = '-1';
            }
            echo '<div class="widget widget-recent-posts">';
            if (!empty($title) && $title <> ' ') {
                echo automobile_allow_special_char($before_title);
                echo automobile_allow_special_char($title);
                echo automobile_allow_special_char($after_title);
            }
            ?>
            <ul>
                <?php
                if (isset($select_category) and $select_category <> ' ' and $select_category <> '') {
                    $args = array('posts_per_page' => $showcount, 'post_type' => 'post', 'category_name' => $select_category);
                } else {
                    $args = array('posts_per_page' => $showcount, 'post_type' => 'post');
                }
                $title_limit = 4;
                $custom_query = new WP_Query($args);
                if ($custom_query->have_posts() <> "") {
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                        $automobile_post_id = get_the_ID();

                        $automobile_noimage = '';
                        $width = 150;
                        $height = 150;
                        $image_id = get_post_thumbnail_id($automobile_post_id);
                        $image_url = automobile_attachment_image_src($image_id, $width, $height);
                        if ($image_url == '') {
                            $automobile_noimage = ' class="cs-noimage"';
                        }
                        ?>
                        <li<?php echo automobile_allow_special_char($automobile_noimage) ?>>
                            <?php if ($image_url != '') { ?>
                                <div class="cs-media">
                                    <figure><a href="<?php echo esc_url(get_permalink()); ?>"><img src="<?php echo esc_url($image_url) ?>" ></a></figure>
                                </div>
                            <?php } ?>
                            <div class="cs-text">
                                <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo wp_trim_words(get_the_title($automobile_post_id), $title_limit, '...'); ?></a>
                                <span><i class="icon-clock5"></i><?php echo get_the_date(); ?></span>
                            </div>

                        </li>

                        <?php
                    endwhile;
                    wp_reset_postdata();
                } else {
                    echo '<p>' . automobile_var_theme_text_srt('automobile_var_noresult_found') . '</p>';
                }
                ?>
            </ul>
            <?php
            echo '</div>';
        }

    }

}
if (function_exists('cs_widget_register')) {
    cs_widget_register("automobile_recentposts");
}