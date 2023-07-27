<?php

/**
 * @Twitter Tweets widget Class
 *
 *
 */
if (!class_exists('automobile_var_twitter_widget')) {

    class automobile_var_twitter_widget extends WP_Widget {

        /**
         * Twitter Module construct
         *
         *
         */
        public function __construct() {
            global $automobile_var_static_text;
            parent::__construct(
                    'automobile_var_twitter_widget', // Base ID
                    automobile_var_theme_text_srt('automobile_var_twitter_widget'), // Name
                    array('classname' => 'widget-twitter', 'description' => automobile_var_theme_text_srt('automobile_var_twitter_widget_desciption'),) // Args
            );
        }

        // Start function for backend twitter widget view
        function form($instance) {
            global $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_static_text;
            $strings = new automobile_theme_all_strings;
            $strings->automobile_short_code_strings();
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $username = isset($instance['username']) ? esc_attr($instance['username']) : '';
            $numoftweets = isset($instance['numoftweets']) ? esc_attr($instance['numoftweets']) : '';

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_html($title),
                    'id' => '',
                    'cust_name' => automobile_var_special_char($this->get_field_name('title')),
                    'cust_id' => automobile_var_special_char($this->get_field_name('title')),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_twitter_widget_user_name'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_html($username),
                    'id' => '',
                    'cust_name' => automobile_var_special_char($this->get_field_name('username')),
                    'cust_id' => automobile_var_special_char($this->get_field_name('username')),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_twitter_widget_tweets_num'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_html($numoftweets),
                    'id' => '',
                    'cust_name' => automobile_var_special_char($this->get_field_name('numoftweets')),
                    'cust_id' => automobile_var_special_char($this->get_field_name('numoftweets')),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
        }

        // Start function for update twitter data
        function update($new_instance, $old_instance) {

            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['username'] = $new_instance['username'];
            $instance['numoftweets'] = $new_instance['numoftweets'];
            return $instance;
        }

        // Start function for view twitter data
        function widget($args, $instance) {
            global $automobile_var_options, $automobile_twitter_arg;
            $automobile_twitter_arg['consumerkey'] = isset($automobile_var_options['automobile_var_consumer_key']) ? $automobile_var_options['automobile_var_consumer_key'] : '';
            $automobile_twitter_arg['consumersecret'] = isset($automobile_var_options['automobile_var_consumer_secret']) ? $automobile_var_options['automobile_var_consumer_secret'] : '';
            $automobile_twitter_arg['accesstoken'] = isset($automobile_var_options['automobile_var_access_token']) ? $automobile_var_options['automobile_var_access_token'] : '';
            $automobile_twitter_arg['accesstokensecret'] = isset($automobile_var_options['automobile_var_access_token_secret']) ? $automobile_var_options['automobile_var_access_token_secret'] : '';
            $automobile_cache_limit_time = isset($automobile_var_options['automobile_var_cache_limit_time']) ? $automobile_var_options['automobile_var_cache_limit_time'] : '';
            $automobile_tweet_num_from_twitter = isset($automobile_var_options['automobile_var_tweet_num_post']) ? $automobile_var_options['automobile_var_tweet_num_post'] : '';
            $automobile_twitter_datetime_formate = isset($automobile_var_options['automobile_var_twitter_datetime_formate']) ? $automobile_var_options['automobile_var_twitter_datetime_formate'] : '';

            if ($automobile_cache_limit_time == '') {
                $automobile_cache_limit_time = 60;
            }
            if ($automobile_twitter_datetime_formate == '') {
                $automobile_twitter_datetime_formate = 'time_since';
            }
            if ($automobile_tweet_num_from_twitter == '') {
                $automobile_tweet_num_from_twitter = 5;
            }

            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = wp_specialchars_decode(stripslashes($title));
            $username = $instance['username'];
            $numoftweets = $instance['numoftweets'];
            
            if ($numoftweets == '') {
                $numoftweets = 2;
            }
            echo automobile_var_special_char($before_widget);
            // WIDGET display CODE Start
            if (!empty($title) && $title <> ' ') {
                echo automobile_var_special_char('<h6>' . $title . '</h6>');
            }
            if (class_exists('wp_automobile_framework')) {
                if (strlen($username) > 1) {
                    automobile_include_file(wp_automobile_framework::plugin_path() . '/includes/cs-twitter/display-tweets.php');
                    display_tweets($username, $automobile_twitter_datetime_formate, $automobile_tweet_num_from_twitter, $numoftweets, $automobile_cache_limit_time);
                }
            }
            echo automobile_allow_special_char($after_widget);
        }

    }

}

if (function_exists('cs_widget_register')) {
    cs_widget_register("automobile_var_twitter_widget");
}

