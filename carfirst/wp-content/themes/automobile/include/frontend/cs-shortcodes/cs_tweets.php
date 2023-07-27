<?php

/*
 *
 * @Shortcode Name :  Start function for Tweets shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('automobile_var_tweets_shortcode')) {

    function automobile_var_tweets_shortcode($atts, $content = "") {
        $defaults = array('column_size' => '', 
            'automobile_var_tweets_user_name' => 'default', 
            'automobile_var_tweets_color' => '', 
            'automobile_var_no_of_tweets' => '', 
            'automobile_var_tweets_class' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = automobile_var_custom_column_class($column_size);

        $CustomId = '';
        if (isset($automobile_var_tweets_class) && $automobile_var_tweets_class) {
            $CustomId = 'id="' . $automobile_var_tweets_class . '"';
        }
        $html = '';
        automobile_var_enqueue_slick_script();
        
        $html .= '
        <div class="cs-tweets-ticker">
        <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
            <h2 class="cs-color">@' . $automobile_var_tweets_user_name . '</h2>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-12">
            <ul class="cs-testimonial-slider">';
                $html .= automobile_get_tweets($automobile_var_tweets_user_name, $automobile_var_no_of_tweets, $automobile_var_tweets_color);
                $html .= '
            </ul>
            </div>
            </div>
        </div>
        <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery(".cs-testimonial-slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                arrows:false,
                autoplaySpeed: 2000,
            });
        });
        </script>';
                
        return $html;
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('automobile_tweets', 'automobile_var_tweets_shortcode');
    }
}

/*
 *
 * @ Start function for Get Tweets through APi
 * @retrun
 *
 */
if (!function_exists('automobile_get_tweets')) {

    function automobile_get_tweets($username, $numoftweets, $automobile_tweets_color = '') {
        global $automobile_var_options, $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();

        $username = html_entity_decode($username);
        $numoftweets = $numoftweets;
        if ($numoftweets == '') {
            $numoftweets = 2;
        }
        if (class_exists('wp_automobile_framework')) {
            if (strlen($username) > 1) {

                $text = '';
                $return = '';
                $cacheTime = 10000;
                $transName = 'latest-tweets';
                automobile_include_file(wp_automobile_framework::plugin_path() . '/includes/cs-twitter/twitteroauth.php');
                $consumerkey = isset($automobile_var_options['automobile_var_consumer_key']) ? $automobile_var_options['automobile_var_consumer_key'] : '';
                $consumersecret = isset($automobile_var_options['automobile_var_consumer_secret']) ? $automobile_var_options['automobile_var_consumer_secret'] : '';
                $accesstoken = isset($automobile_var_options['automobile_var_access_token']) ? $automobile_var_options['automobile_var_access_token'] : '';
                $accesstokensecret = isset($automobile_var_options['automobile_var_access_token_secret']) ? $automobile_var_options['automobile_var_access_token_secret'] : '';
                $connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
                $tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $username . "&count=" . $numoftweets);

                
                if (!is_wp_error($tweets) and is_array($tweets)) {
                    set_transient($transName, $tweets, 60 * $cacheTime);
                } else {
                    $tweets = get_transient('latest-tweets');
                }
                if (!is_wp_error($tweets) and is_array($tweets)) {
                    $twitter_text_color = '';
                    if (!empty($automobile_tweets_color)) {
                        $twitter_text_color = "style='color: $automobile_tweets_color !important'";
                    }
                    $rand_id = rand(11115, 300000);
                    $exclude = 0;
                    $return = '';
                    foreach ($tweets as $tweet) {
                        $exclude++;
                        $text = $tweet->{'text'};
                        foreach ($tweet->{'user'} as $type => $userentity) {
                            if ($type == 'profile_image_url') {
                                $profile_image_url = $userentity;
                            } else if ($type == 'screen_name') {
                                $screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="colrhover" title="' . $userentity . '">@' . $userentity . '</a>';
                            }
                        }
                        foreach ($tweet->{'entities'} as $type => $entity) {
                            if ($type == 'hashtags') {
                                foreach ($entity as $j => $hashtag) {
                                    $update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&amp;src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
                                    $text = str_replace('#' . $hashtag->{'text'}, $update_with, $text);
                                }
                            }
                        }
                        $large_ts = time();
                        $n = $large_ts - strtotime($tweet->{'created_at'});
                        if ($n < (60)) {
                            $posted = sprintf(esc_html__('%d seconds ago', 'automobile'), $n);
                        } elseif ($n < (60 * 60)) {
                            $minutes = round($n / 60);
                            $posted = sprintf(_n('About a Minute Ago', '%d Minutes Ago', $minutes, 'automobile'), $minutes);
                        } elseif ($n < (60 * 60 * 16)) {
                            $hours = round($n / (60 * 60));
                            $posted = sprintf(_n('About an Hour Ago', '%d Hours Ago', $hours, 'automobile'), $hours);
                        } elseif ($n < (60 * 60 * 24)) {
                            $hours = round($n / (60 * 60));
                            $posted = sprintf(_n('About an Hour Ago', '%d Hours Ago', $hours, 'automobile'), $hours);
                        } elseif ($n < (60 * 60 * 24 * 6.5)) {
                            $days = round($n / (60 * 60 * 24));
                            $posted = sprintf(_n('About a Day Ago', '%d Days Ago', $days, 'automobile'), $days);
                        } elseif ($n < (60 * 60 * 24 * 7 * 3.5)) {
                            $weeks = round($n / (60 * 60 * 24 * 7));
                            $posted = sprintf(_n('About a Week Ago', '%d Weeks Ago', $weeks, 'automobile'), $weeks);
                        } elseif ($n < (60 * 60 * 24 * 7 * 4 * 11.5)) {
                            $months = round($n / (60 * 60 * 24 * 7 * 4));
                            $posted = sprintf(_n('About a Month Ago', '%d Months Ago', $months, 'automobile'), $months);
                        } elseif ($n >= (60 * 60 * 24 * 7 * 4 * 12)) {
                            $years = round($n / (60 * 60 * 24 * 7 * 52));
                            $posted = sprintf(_n('About a year Ago', '%d years Ago', $years, 'automobile'), $years);
                        }

                        $return .= '
                        <li>
                            <span class="cs-color" '. automobile_var_allow_special_char($twitter_text_color) .'>' . $text . '</span>
                            ' . $posted . '
                        </li>';
                    }
                    return $return;
                } else {
                    if (isset($tweets->errors[0]) && $tweets->errors[0] <> "") {
                        return '<div class="cs-twitter item" data-hash="dummy-one"><h4>' . $tweets->errors[0]->message . esc_html(automobile_var_theme_text_srt('automobile_var_twitter_valid_api')) . '</h4></div>';
                    } else {
                        return '<div class="cs-twitter item" data-hash="dummy-two"><h4>' . esc_html(automobile_var_theme_text_srt('automobile_var_no_tweets_found')) . '</h4></div>';
                    }
                }
            } else {
                return '<div class="cs-twitter item" data-hash="dummy-three"><h4>' . esc_html(automobile_var_theme_text_srt('automobile_var_no_tweets_found')) . '</h4></div>';
            }
        }
    }

}
