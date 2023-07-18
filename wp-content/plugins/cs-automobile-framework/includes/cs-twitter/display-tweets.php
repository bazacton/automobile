<?php

function get_auth($id, $max_tweets) {
    global $automobile_twitter_arg;
    $include_rts = true; // include retweets is set to true by default, if you don't want to include retweets set this to false
    $exclude_replies = true; //Replies are not displayed by default.  If you wish to change this set this to false
    $consumer_key = $automobile_twitter_arg['consumerkey'];
    $consumer_secret = $automobile_twitter_arg['consumersecret'];
    $user_token = $automobile_twitter_arg['accesstoken'];
    $user_secret = $automobile_twitter_arg['accesstokensecret'];

    require_once 'includes/tmhOAuth.php';

    $tmhOAuth = new tmhOAuth(array(
        'consumer_key' => $consumer_key,
        'consumer_secret' => $consumer_secret,
        'user_token' => $user_token,
        'user_secret' => $user_secret
    ));
    $twitter_settings_arr = array(
        'count' => $max_tweets,
        'screen_name' => $id,
        'include_rts' => $include_rts,
        'exclude_replies' => $exclude_replies
    );

    $code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), $twitter_settings_arr);
	
    $res_code = array(
        '200',
        '304'
    );
    if (in_array($code, $res_code)) {
        $data = $tmhOAuth->response['response'];
        return $data;
    } else {
        return $data = '500';
    }
}

function cache_json($id, $max_tweets, $time) {
	$cache_dir	= plugin_dir_path( __FILE__ ).'cache/';
	$cache = $cache_dir . $id . '.json'; //Twitter cache directory
    $cache_folder = $cache_dir; //Twitter cache directory
    if (!file_exists($cache)) {
        if (!file_exists($cache_folder)) {
            $cache_dir = mkdir($cache_folder);
            $cache_data = true;
        }
        if (!file_exists($cache)) {
            $cache_data = true;
        }
    } else {
        $cache_time = time() - filemtime($cache);
        if ($cache_time > 60 * $time) {
            $cache_data = true;
        }
    }
    $tweets = '';
	
	global $wp_filesystem;
	if ( empty($wp_filesystem) ) {
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
	}
	
    if (isset($cache_data)) {
        $data = get_auth($id, $max_tweets);
        if ($data != '500') {
            $cached = $wp_filesystem->put_contents($cache, $data);
        }
    }
    $tweets = json_decode($wp_filesystem->get_contents($cache), true);


    return $tweets;
}

function dateDiff($time1, $time2, $precision = 6) {
    if (!is_int($time1)) {
        $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
        $time2 = strtotime($time2);
    }
    if ($time1 > $time2) {
        $ttime = $time1;
        $time1 = $time2;
        $time2 = $ttime;
    }
    $intervals = array(
        'year',
        'month',
        'day',
        'hour',
        'minute',
        'second'
    );
    $diffs = array();
    foreach ($intervals as $interval) {
        $diffs[$interval] = 0;
        $ttime = strtotime("+1 " . $interval, $time1);
        while ($time2 >= $ttime) {
            $time1 = $ttime;
            $diffs[$interval] ++;
            $ttime = strtotime("+1 " . $interval, $time1);
        }
    }
    $count = 0;
    $times = array();
    foreach ($diffs as $interval => $value) {
        if ($count >= $precision) {
            break;
        }
        if ($value > 0) {
            if ($value != 1) {
                $interval .= "s";
            }
            $times[] = $value . " " . $interval;
            $count++;
        }
    }
    return implode(", ", $times);
}

function display_tweets($id, $style = '', $max_tweets = 10, $max_cache_tweets = 10, $time = 60) {
    global $automobile_var_frame_static_text;
    $tweets = cache_json($id, $max_tweets, $time);
    $twitter = '';

    $twitter .= '<ul>';
    if (!empty($tweets)) {
        $tweet_flag = 1;
        foreach ($tweets as $tweet) {
            $pubDate = $tweet['created_at'];
            $tweet = $tweet['text'];
            $today = time();
            $time = substr($pubDate, 11, 5);
            $day = substr($pubDate, 0, 3);
            $date = substr($pubDate, 7, 4);
            $month = substr($pubDate, 4, 3);
            $year = substr($pubDate, 25, 5);
            $english_suffix = date('jS', strtotime(preg_replace('/\s+/', ' ', $pubDate)));
            $full_month = date('F', strtotime($pubDate));


            #pre-defined tags
            $default = $full_month . $date . $year;
            $full_date = $day . $date . $month . $year;
            $ddmmyy = $date . $month . $year;
            $mmyy = $month . $year;
            $mmddyy = $month . $date . $year;
            $ddmm = $date . $month;

            #Time difference
            $timeDiff = dateDiff($today, $pubDate, 1);

            # Turn URLs into links
            $tweet = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\./-]*(\?\S+)?)?)?)@', '<a target="blank" title="$1" href="$1">$1</a>', $tweet);

            #Turn hashtags into links
            $tweet = preg_replace('/#([0-9a-zA-Z_-]+)/', "<a target='blank' title='$1' href=\"http://twitter.com/search?q=%23$1\">#$1</a>", $tweet);

            #Turn @replies into links
            $tweet = preg_replace("/@([0-9a-zA-Z_-]+)/", "<a target='blank' title='$1' href=\"http://twitter.com/$1\">@$1</a>", $tweet);

            $twitter .= "<li>";
                $twitter .= "<div class=\"cs-media\"><figure><i class=\"icon-twitter\"></i></figure></div>";
                $twitter .= "<div class=\"cs-text\"><p>" . $tweet . "&nbsp;";
                    if (isset($style)) {
                        if (!empty($style)) {
                            $when = ($style == 'time_since' ? '' : esc_html(automobile_var_frame_text_srt('automobile_var_tweets_time_on')));
                            $twitter.="<span><i class=\"icon-dot-single\"></i>" . $when . "&nbsp;";

                            switch ($style) {
                                case 'eng_suff': {
                                        $twitter .= $english_suffix . '&nbsp;' . $full_month;
                                    }
                                    break;
                                case 'time_since'; {
                                        $twitter .= $timeDiff . "&nbsp;ago";
                                    }
                                    break;
                                case 'ddmmyy'; {
                                        $twitter .= $ddmmyy;
                                    }
                                    break;
                                case 'ddmm'; {
                                        $twitter .= $ddmm;
                                    }
                                    break;
                                case 'full_date'; {
                                        $twitter .= $full_date;
                                    }
                                    break;
                                case 'default'; {
                                        $twitter .= $default;
                                    }
                            } //end switch statement
                            $twitter .= "</span>"; //end of List
                        }
                    }
                $twitter .= "</p></div>";
            $twitter .= "</li>";
            if ($max_cache_tweets <= $tweet_flag) {
                break;
            }
            $tweet_flag++;
        } //end of foreach
    } else {
        $twitter .= '<li>'. esc_html(automobile_var_frame_text_srt('automobile_var_no_tweets_found')) .'</li>';
    } //end if statement
    $twitter .= '</ul>'; //end of Unordered list (Notice it's after the foreach loop!)
    echo $twitter;
}
?>