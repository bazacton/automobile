<?php

/**
 * @MailChimp widget Class
 *
 *
 */
if (!class_exists('automobile_mailchimp')) {

    class automobile_mailchimp extends WP_Widget {
        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */

        /**
         * @init MailChimp Module
         *
         *
         */
        public function __construct() {
            global $automobile_var_static_text;
            
            parent::__construct(
                    'automobile_mailchimp', // Base ID
                    automobile_var_theme_text_srt('automobile_var_mailchimp'), // Name
                    array('classname' => 'widget-news-letter', 'description' => automobile_var_theme_text_srt('automobile_var_mailchimp_desciption'),) // Args
            );
        }

        /**
         * @MailChimp html form
         *
         *
         */
        function form($instance) {
            global $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_static_text;
            $strings = new automobile_theme_all_strings;
            $strings->automobile_short_code_strings();
            $instance = wp_parse_args((array) $instance, array('title' => ''));

            $title = $instance['title'];
            $social_switch = isset($instance['social_switch']) ? esc_attr($instance['social_switch']) : '';
            $description = isset($instance['description']) ? esc_attr($instance['description']) : '';

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_multiple_counter_title_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($title),
                    'cust_id' => '',
                    'cust_name' => automobile_allow_special_char($this->get_field_name('title')),
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_description'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_description_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($description),
                    'cust_id' => '',
                    'cust_name' => automobile_allow_special_char($this->get_field_name('description')),
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_social_icon'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => $social_switch,
                    'cust_name' => automobile_allow_special_char($this->get_field_name('social_switch')),
                    'id' => $this->get_field_name('social_switch'),
                    'return' => true,
                ),
            );


            $automobile_var_html_fields->automobile_var_checkbox_field($automobile_opt_array);
        }

        /**
         * @MailChimp update form data
         *
         *
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['description'] = $new_instance['description'];
            $instance['social_switch'] = $new_instance['social_switch'];
            return $instance;
        }

        /**
         * @Display MailChimp widget
         *
         *
         */
        function widget($args, $instance) {
            global $automobile_node, $social_switch;

            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            $description = empty($instance['description']) ? ' ' : apply_filters('widget_title', $instance['description']);
            $social_switch = empty($instance['social_switch']) ? ' ' : apply_filters('widget_title', $instance['social_switch']);
            echo automobile_allow_special_char($before_widget);
            if (!empty($title) && $title <> ' ') {
                echo automobile_allow_special_char($before_title);
                echo automobile_allow_special_char($title);
                echo automobile_allow_special_char($after_title);
            }
            global $wpdb, $post;
            /**
             * @Display MailChimp
             *
             *
             */
            if (function_exists('automobile_custom_mailchimp')) {
                echo '<p>';
                echo esc_html($description);
                echo '</p>';
                echo automobile_custom_mailchimp();
            }
            echo automobile_allow_special_char($after_widget);
        }

    }

}

if (function_exists('cs_widget_register')) {
    cs_widget_register("automobile_mailchimp");
}