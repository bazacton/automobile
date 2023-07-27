<?php
/**
 * Dealer alpha 1Column
 *
 */
$show_pagination = $a['automobile_dealer_show_pagination'];
if ((isset( $a['automobile_dealer_searchbox_top'] ) && $a['automobile_dealer_searchbox_top'] == 'yes')) {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

    include plugin_dir_path(__FILE__) . '../cs-top-view-search.php';
    echo '</div>';
}
include plugin_dir_path(__FILE__) . '../cs-sort-filters.php';
include plugin_dir_path(__FILE__) . '../cs-search-keywords.php';

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php
    $old_char = '';
    $new_char = '';
    if ($count_post > 0) {
        $loop = new WP_User_Query($args);
        $loop_count = $loop->total_users;

        $automobile_inventory_posted_date_formate = 'd-m-Y H:i:s';
        $automobile_inventory_expired_date_formate = 'd-m-Y H:i:s';
        echo ' <div class="row">';
        $flag = 0;
        if (!empty($loop->results)) {
            foreach ($loop->results as $automobile_user) {

                $automobile_address = get_user_address_string_for_list($automobile_user->ID, 'usermeta');
                $automobile_web_http = $automobile_user->user_url;

                $automobile_web = preg_replace('#^https?://#', '', $automobile_web_http);
                $automobile_dealer_img = get_user_meta($automobile_user->ID, 'user_img', true);
                //$automobile_dealer_img = automobile_get_user_attachment_url_from_name($automobile_dealer_img, 'automobile_var_media_6');
		$automobile_dealer_img = automobile_get_user_attachment_url_from_name( $automobile_dealer_img );
                if ( $automobile_dealer_img == "" ) {
                 $automobile_dealer_img = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found4x3.jpg');
                }
                $automobile_dealer_username = $automobile_user->ID;
                $automobile_post_loc_latitude = get_user_meta($automobile_user->ID, 'automobile_post_loc_latitude', true);

                $automobile_post_loc_longitude = get_user_meta($automobile_user->ID, 'automobile_post_loc_longitude', true);


                $args = array(
                    'ignore_sticky_posts' => 1,
                    'post_type' => 'inventory',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => 'automobile_inventory_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'automobile_inventory_username',
                            'value' => $automobile_dealer_username,
                            'compare' => '=',
                        ),
                        
                    )
                );
                //echo "<pre>";print_r($args);echo "</pre>";
                $totl_posts = get_posts($args);
               // echo "<pre>";print_r($totl_posts);echo "</pre>";
                $count_inventory_post = count($totl_posts);
                $automobile_user_data = get_userdata($automobile_user->ID);
               //print_r($automobile_user);
                ?>
                
                    <div class="dealer-list">
                        <div class="img-holder">
                            <figure>
                                <a href="<?php echo get_author_posts_url($automobile_user->ID) ?>"><img class="lazyload no-src" src="<?php echo esc_url($automobile_dealer_img);  ?>" data-src="<?php echo esc_url($automobile_dealer_img);  ?>" alt="image"></a>
                            </figure>
                        </div>
                        <div class="text-holder">
                            <div class="cs-post-title">
                                <h3><a href="<?php echo get_author_posts_url($automobile_user->ID) ?>"><?php echo esc_html($automobile_user->display_name) ?></a></h3>
                                <span class="dealer-info"><?php echo esc_html($automobile_user_data->automobile_post_comp_address); ?></span><p><?php echo force_balance_tags(wp_trim_words( $automobile_user_data->description, $num_words = 40, $more = null ) ); ?></p>
                            </div>
                            <!--<address><?php echo esc_html($automobile_address); ?></address>
                            <a href="<?php echo get_author_posts_url($automobile_user->ID) ?>" class="contact-btn"><i class="icon-phone5"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_contact_now')); ?></a>-->
                        </div>
                    </div>
                    
                
                <?php
            }
            echo ' </div>';
        }
    } else {
        echo '<li class="ln-no-match">';
        echo '<div class="massage-notfound">
                                            <div class="massage-title">
                                             <h6><i class="icon-warning4"></i><strong> ' . esc_html(automobile_var_plugin_text_srt('automobile_var_sorry')) . '</strong>&nbsp; ' . esc_html(automobile_var_plugin_text_srt('automobile_var_no_search')) . ' </h6>
                                            </div>
                                             <ul>
                                                <li>' . esc_html(automobile_var_plugin_text_srt('automobile_var_re_check_spelling')) . ' </li>
                                                <li>' . esc_html(automobile_var_plugin_text_srt('automobile_var_try_broadening_your_search')) . '</li>
                                                <li>' . esc_html(automobile_var_plugin_text_srt('automobile_var_try_adjusting_filters')) . '</li>
                                             </ul>
                                          </div>';
        echo '</li>';
    }
    ?>     
</div>
<?php
if ((isset($users_per_page) && $count_post > $users_per_page && $users_per_page > 0) && $show_pagination == 'pagination') {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><nav class="navigation pagination" role="navigation">';
    automobile_user_pagination($total_pages, $page, $automobile_var_dealer_page);
    echo '</nav></div>';
}
if ((isset( $a['automobile_dealer_searchbox'] ) && $a['automobile_dealer_searchbox'] == 'yes')) {
    echo ' </div>';
}
?>