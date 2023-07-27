<?php
/**
 * The template for Employer Detail
 */
global $author, $current_user, $automobile_var_plugin_options, $automobile_form_fields, $user, $automobile_var_plugin_core, $automobile_var_plugin_static_text;
$strings = new automobile_plugin_all_strings;
$strings->automobile_var_plugin_login_strings();
$strings->automobile_var_plugin_option_strings();

if (!function_exists('automobile_var_dealer_class')) {

    function automobile_var_dealer_class($classes) {
        $classes[] = 'cs-agent-detail';
        return $classes;
    }

}

add_filter('body_class', 'automobile_var_dealer_class');

$automobile_user_data = get_userdata($author);

$automobile_uniq = rand(11111111, 99999999);
//automobile_set_post_views($automobile_user_data->ID);
get_header();
/*
 *  login user detail
 *      
 */
?>

<!-- alert for complete theme -->
<div class="automobile_alerts" ></div>
<?php
$login_user_name = '';
$login_user_email = '';
$login_user_phone = '';
$automobile_emp_funs = new automobile_dealer_functions();
if (is_user_logged_in()) {
    $login_user_name = $current_user->display_name;
    $login_user_email = $current_user->user_email;
    $login_user_phone = get_user_meta($current_user->ID, 'automobile_contact_information', true);
}
$automobile_inventory_posted_date_formate = 'd-m-Y H:i:s';
$automobile_inventory_expired_date_formate = 'd-m-Y H:i:s';
$automobile_dealer_web_http = $automobile_user_data->user_url;
$automobile_dealer_email = $automobile_user_data->user_email;
$automobile_dealer_web = preg_replace('#^https?://#', '', $automobile_dealer_web_http);
$automobile_dealer_facebook = get_user_meta($automobile_user_data->ID, 'automobile_facebook', true);
$automobile_dealer_address = get_the_author_meta('automobile_post_comp_address', $automobile_user_data->ID);
$automobile_dealer_twitter = get_user_meta($automobile_user_data->ID, 'automobile_twitter', true);
$automobile_dealer_linkedin = get_user_meta($automobile_user_data->ID, 'automobile_linkedin', true);
$automobile_dealer_google_plus = get_user_meta($automobile_user_data->ID, 'automobile_google_plus', true);
$automobile_dealer_contact = get_user_meta($automobile_user_data->ID, 'automobile_contact_information', true);
$automobile_dealer_img = get_user_meta($automobile_user_data->ID, 'user_img', true);
$automobile_dealer_img = automobile_get_user_attachment_url_from_name( $automobile_dealer_img );



$dealer_img_class = '';
if ($automobile_dealer_img == "") {
	$dealer_img_class = 'class="no-image"';
    $automobile_dealer_img = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found4x3.jpg');
}
$automobile_mobile_number = get_user_meta($automobile_user_data->ID, 'automobile_mobile_number', true);
$automobile_profile_approved = $automobile_user_data->user_status;
$automobile_fax_number = get_user_meta($automobile_user_data->ID, 'automobile_fax_number', true);
$automobile_alternate_number = get_user_meta($automobile_user_data->ID, 'automobile_alternate_number', true);
$user_phone = get_user_meta($automobile_user_data->ID, 'automobile_phone_number', true);
$automobile_gallery = get_user_meta($automobile_user_data->ID, 'gallery_user_img', true);
$automobile_opening_hour = get_user_meta($automobile_user_data->ID, 'automobile_opening_hours', true);
if (is_array($automobile_opening_hour)) {
    extract($automobile_opening_hour);
}
$automobile_dealer_emp_username = $automobile_user_data->ID;

$automobile_plugin_single_container = isset($automobile_var_plugin_options['automobile_plugin_single_container']) ? $automobile_var_plugin_options['automobile_plugin_single_container'] : 'on';
?>

<div class="main-section"> 
    <div class="page-section dealer-detail">
        <?php
        if ($automobile_plugin_single_container == 'on') {
            echo "<div class=\"container\">\n<div class=\"row\">\n";
        }
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="cs-admin-info">
                <div class="cs-media">
                    <?php if (isset($automobile_dealer_img) && $automobile_dealer_img <> "") {
                        ?>
                        <figure><img <?php echo $dealer_img_class; ?> class="lazyload no-src" alt="Dealer Logo" src="<?php echo esc_url($automobile_dealer_img); ?>"></figure>
                    <?php } ?>
                </div>
                <div class="cs-text">

                    <div class="cs-title">
                        <h3><?php echo esc_html($automobile_user_data->display_name); ?></h3>
                        <?php if ($automobile_profile_approved == 1) { ?>
                            <a href="#"><i class="icon-check_circle"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_verified')); ?></a>
                        <?php } ?>
                    </div>
                    <?php if ($automobile_dealer_address != '') { ?>
                        <address><?php echo esc_html($automobile_dealer_address) ?></address>
                    <?php } ?>
                    <ul>
                        <li><?php if ($user_phone != '') { ?>
                                <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_phone')); ?></span>
                                <?php echo esc_html($user_phone); ?>
                            <?php } ?>
                            <?php if ($automobile_mobile_number != '' || $automobile_fax_number != '' || $automobile_alternate_number != '') { ?>
                                <ul>
                                    <?php if ($automobile_mobile_number != '') { ?>
                                        <li>
                                            <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_mobile_number')); ?></span>
                                            <?php echo esc_html($automobile_mobile_number); ?>
                                        </li>
                                    <?php }if ($automobile_fax_number != '') { ?>
                                        <li>
                                            <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_fax_number')); ?></span>
                                            <?php echo esc_html($automobile_fax_number); ?>
                                        </li>
                                    <?php }if ($automobile_alternate_number != '') { ?>
                                        <li>
                                            <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_alternate_number')); ?></span>
                                            <?php echo esc_html($automobile_alternate_number); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                        <?php if ($automobile_dealer_web != '') { ?>
                            <li>
                                <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_website')); ?></span>
                                <a href="<?php echo esc_url($automobile_dealer_web); ?>"><?php echo esc_html($automobile_dealer_web); ?></a>
                            </li>
                        <?php }if ($automobile_dealer_email != '') { ?>
                            <li>
                                <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_label')); ?></span>
                                <a href="<?php echo esc_url($automobile_dealer_email) ?>"><?php echo esc_html($automobile_dealer_email) ?></a>
                            </li>
                        <?php } ?>
                    </ul>


                </div>
            </div>

        </div>
        <?php
        if ($automobile_plugin_single_container == 'on') {
            echo "</div>\n</div>\n";
        }
        ?>
    </div>

    <div class="page-section has-border" >
        <?php
        if ($automobile_plugin_single_container == 'on') {
            echo "<div class=\"container\">\n<div class=\"row\">\n";
        }
        ?>
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="cs-post-option pull-left">
                        <ul>
                            <li>
                                <i class="icon-clock"></i>
                                <?php
                                $openhours_Mon_text = isset($openhours_Mon_text) ? $openhours_Mon_text : '';
                                $openhours_Mon_start = isset($openhours_Mon_start) ? $openhours_Mon_start : '';
                                $openhours_Mon_end = isset($openhours_Mon_end) ? $openhours_Mon_end : '';
                                $openhours_Tue_text = isset($openhours_Tue_text) ? $openhours_Tue_text : '';
                                $openhours_Tue_start = isset($openhours_Tue_start) ? $openhours_Tue_start : '';
                                $openhours_Tue_end = isset($openhours_Tue_end) ? $openhours_Tue_end : '';
                                $openhours_Wed_text = isset($openhours_Wed_text) ? $openhours_Wed_text : '';
                                $openhours_Wed_start = isset($openhours_Wed_start) ? $openhours_Wed_start : '';
                                $openhours_Wed_end = isset($openhours_Wed_end) ? $openhours_Wed_end : '';
                                $openhours_Thu_text = isset($openhours_Thu_text) ? $openhours_Thu_text : '';
                                $openhours_Thu_start = isset($openhours_Thu_start) ? $openhours_Thu_start : '';
                                $openhours_Thu_end = isset($openhours_Thu_end) ? $openhours_Thu_end : '';
                                $openhours_Fri_text = isset($openhours_Fri_text) ? $openhours_Fri_text : '';
                                $openhours_Fri_start = isset($openhours_Fri_start) ? $openhours_Fri_start : '';
                                $openhours_Fri_end = isset($openhours_Fri_end) ? $openhours_Fri_end : '';
                                $openhours_Sat_text = isset($openhours_Sat_text) ? $openhours_Sat_text : '';
                                $openhours_Sat_start = isset($openhours_Sat_start) ? $openhours_Sat_start : '';
                                $openhours_Sat_end = isset($openhours_Sat_end) ? $openhours_Sat_end : '';
                                $openhours_Sun_text = isset($openhours_Sun_text) ? $openhours_Sun_text : '';
                                $openhours_Sun_start = isset($openhours_Sun_start) ? $openhours_Sun_start : '';
                                $openhours_Sun_end = isset($openhours_Sun_end) ? $openhours_Sun_end : '';
                                $today = '';
                                $day = date("l");

                                if ($day == $openhours_Mon_text) {
                                    $today = $openhours_Mon_start . ' - ' . $openhours_Mon_end;
                                } else if ($day == $openhours_Tue_text) {
                                    $today = $openhours_Tue_start . ' - ' . $openhours_Tue_end;
                                } else if ($day == $openhours_Wed_text) {
                                    $today = $openhours_Wed_start . ' - ' . $openhours_Wed_end;
                                } else if ($day == $openhours_Thu_text) {
                                    $today = $openhours_Thu_start . ' - ' . $openhours_Thu_end;
                                } else if ($day == $openhours_Fri_text) {
                                    $today = $openhours_Fri_start . ' - ' . $openhours_Fri_end;
                                } else if ($day == $openhours_Sat_text) {
                                    $today = $openhours_Sat_start . ' - ' . $openhours_Sat_end;
                                } else {
                                    $today = $openhours_Sun_start . ' - ' . $openhours_Sun_end;
                                }
                                if ($today == ' - ') {
                                    $today = automobile_var_plugin_text_srt('automobile_var_closed_today');
                                } else {
                                    echo esc_html(automobile_var_plugin_text_srt('automobile_var_open_today'));
                                }
                                ?>
                                <span><?php echo esc_html($today); ?><i class="icon-keyboard_arrow_down"></i></span>
                                <ul class="cs-timeline-list">
                                    <li>
                                        <?php
                                        echo esc_html($openhours_Mon_text);
                                        if ($openhours_Mon_start == '' && $openhours_Mon_end == '') {
                                            ?> <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_closed')); ?></span><?php
                                        } else {
                                            ?> <span><?php echo esc_html($openhours_Mon_start); ?> - <?php echo esc_html($openhours_Mon_end); ?></span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo esc_html($openhours_Tue_text);
                                        if ($openhours_Tue_start == '' && $openhours_Tue_end == '') {
                                            ?> <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_closed')); ?></span><?php
                                        } else {
                                            ?> <span><?php echo esc_html($openhours_Tue_start); ?> - <?php echo esc_html($openhours_Tue_end); ?></span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo esc_html($openhours_Wed_text);
                                        if ($openhours_Wed_start == '' && $openhours_Wed_end == '') {
                                            ?> <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_closed')); ?></span><?php
                                        } else {
                                            ?> <span><?php echo esc_html($openhours_Wed_start); ?> - <?php echo esc_html($openhours_Wed_end); ?></span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo esc_html($openhours_Thu_text);
                                        if ($openhours_Thu_start == '' && $openhours_Thu_end == '') {
                                            ?> <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_closed')); ?></span><?php
                                        } else {
                                            ?> <span><?php echo esc_html($openhours_Thu_start); ?> - <?php echo esc_html($openhours_Thu_end); ?></span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo esc_html($openhours_Fri_text);
                                        if ($openhours_Fri_start == '' && $openhours_Fri_end == '') {
                                            ?> <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_closed')); ?></span><?php
                                        } else {
                                            ?> <span><?php echo esc_html($openhours_Fri_start); ?> - <?php echo esc_html($openhours_Fri_end); ?></span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo esc_html($openhours_Sat_text);
                                        if ($openhours_Sat_start == '' && $openhours_Sat_end == '') {
                                            ?> <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_closed')); ?></span><?php
                                        } else {
                                            ?> <span><?php echo esc_html($openhours_Sat_start); ?> - <?php echo esc_html($openhours_Sat_end); ?></span>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo esc_html($openhours_Sun_text);
                                        if ($openhours_Sun_start == '' && $openhours_Sun_end == '') {
                                            ?> <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_closed')); ?></span><?php
                                        } else {
                                            ?> <span><?php echo esc_html($openhours_Sun_start); ?> - <?php echo esc_html($openhours_Sun_end); ?></span>
                                        <?php } ?>
                                    </li>		
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <?php if ($automobile_dealer_facebook != '' || $automobile_dealer_twitter != '' || $automobile_dealer_linkedin != '' || $automobile_dealer_google_plus != '') { ?>
                        <div class="cs-social-media pull-right">
                            <ul>
                                <?php if ($automobile_dealer_facebook != '') { ?>
                                    <li><a href="<?php echo esc_url($automobile_dealer_facebook) ?>"><i class="icon-facebook22"></i></a></li>
                                <?php } if ($automobile_dealer_twitter != '') { ?>
                                    <li><a href="<?php echo esc_url($automobile_dealer_twitter) ?>"><i class="icon-twitter4"></i></a></li>
                                <?php } if ($automobile_dealer_google_plus != '') { ?>
                                    <li><a href="<?php echo esc_url($automobile_dealer_google_plus) ?>"><i class="icon-google-plus"></i></a></li>
                                <?php } if ($automobile_dealer_linkedin != '') { ?>
                                    <li><a href="<?php echo esc_url($automobile_dealer_linkedin) ?>"><i class="icon-linkedin4"></i></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
        if ($automobile_plugin_single_container == 'on') {
            echo "</div>\n</div>\n";
        }
        ?>
    </div> 
    <div class="page-section">
        <?php
        if ($automobile_plugin_single_container == 'on') {
            echo "<div class=\"container\">\n<div class=\"row\">\n";
        }
        ?>
        <div class="section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="cs-related-inventories col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <?php
                    $user_gallery = get_user_meta($automobile_user_data->ID, 'gallery_user_img', true);
					if (is_array($user_gallery)) {
                        ?>
                        <ul class="cs-detail-slider">
                            <?php
                            foreach ($user_gallery as $gallary) {
								if (isset($gallary['url']) && $gallary['url'] != '') {
                                    if (function_exists('get_user_gallery_crop_image_url')):
                                        $image_url = get_user_gallery_crop_image_url($gallary['url']);
                                    endif;
									$image = wp_get_attachment_image_src( $gallary['id'], 'automobile_var_media_3' );
									
                                    if ( isset( $image[0] ) && $image[0] != '' ) :
                                        ?>
                                        <li>
                                            <figure><img class="lazyload no-src" src="<?php echo esc_url($image[0]); ?>" alt="<?php echo automobile_var_plugin_text_srt('automobile_var_profile_image_hint'); ?>" /></figure>
                                        </li>
                                        <?php
                                    endif;
                                }
                            }
                            ?>

                        </ul>
                    <?php }echo automobile_dealer_features_info($automobile_user_data->ID);
                    ?>
                    <div class="rich_editor_text">
                        <strong><?php printf(automobile_var_plugin_text_srt('automobile_var_about_strings'), esc_html($automobile_user_data->display_name)) ?></strong>
                        <?php echo force_balance_tags($automobile_user_data->description) ?>
                    </div>


                    <?php
                    $automobile_current_page = 1;
                    if (isset($_GET['page_id_all'])) {
                        $automobile_current_page = $_GET['page_id_all'];
                    }
                    $args = array(
                        'post_type' => 'inventory',
                        'post_status' => 'publish',
                        'posts_per_page' => '-1',
                        'ignore_sticky_posts' => 1,
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_inventory_username',
                                'value' => $automobile_user_data->ID,
                                'compare' => '=',
                            ),
                        )
                    );
                    $loop = new WP_Query($args);
                    $count_post = $loop->post_count;
                    $args = array(
                        'post_type' => 'inventory',
                        'post_status' => 'publish',
                        'posts_per_page' => '5',
                        'paged' => $automobile_current_page,
                        'ignore_sticky_posts' => 1,
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_inventory_username',
                                'value' => $automobile_user_data->ID,
                                'compare' => '=',
                            ),
                        )
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) : $loop->the_post();
                        global $post;
                        $automobile_old_price = get_post_meta($post->ID, 'automobile_inventory_old_price', true);
                        $automobile_new_price = get_post_meta($post->ID, 'automobile_inventory_new_price', true);
                        $automobile_inv_feature_list = get_post_meta($post->ID, 'automobile_inventory_feature_list', true);
                        $automobile_inventory_username = get_post_meta($post->ID, 'automobile_inventory_username', true);

                        $automobile_inventory_user_img = get_user_meta($automobile_inventory_username, 'user_img', true);
                        if ($automobile_inventory_user_img != '') {
                            //$automobile_inv_user_img_src = automobile_get_img_url($automobile_inventory_user_img, 'automobile_var_media_6');
							$automobile_inv_user_img_src = automobile_get_user_attachment_url_from_name( $automobile_inventory_user_img );
                        } else {
                            $automobile_inv_user_img_src = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found4x3.jpg');
                        }

                        $automobile_inv_gallery = get_post_meta($post->ID, 'automobile_inventory_gallery_url', true);
                        $automobile_gal_url = isset($automobile_inv_gallery[0]) ? $automobile_inv_gallery[0] : '';

                        
                        $automobile_gal_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($automobile_gal_url);
                        if( $automobile_gal_id > 0){
                            $automobile_img_url = wp_get_attachment_image_src($automobile_gal_id, 'automobile_var_media_2');
                        }else{
                            $automobile_img_url = $automobile_inv_gallery;
                        }
                        if (is_array($automobile_img_url) && isset($automobile_img_url)) {
                            $automobile_img_url = $automobile_img_url[0];
                        } else {
                            $automobile_img_url = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found16x9.jpg');
                        }
                        ?>

                        <div class="auto-listing">
						
                            <div class="cs-media">
                                <?php if (isset($automobile_img_url) && $automobile_img_url != '') { ?>
                                <figure><a href="<?php echo esc_url(get_permalink());?>"><img class="lazyload no-src" src="<?php echo esc_url($automobile_img_url) ?>" data-src="<?php echo esc_url($automobile_img_url) ?>" alt=""></a></figure>
                                <?php } ?>
                            </div>
                            <div class="auto-text">
                                <?php
                                $automobile_inv_makes = get_the_term_list($post->ID, 'inventory-make', '<span class="cs-categories">', ', ', '</span>');
                                if ($automobile_inv_makes != '') {
                                    printf('%1$s', $automobile_inv_makes);
                                }
                                ?>
                                <div class="post-title">
                                    <h4><a href="<?php esc_url(the_permalink()) ?>"><?php echo wp_trim_words(get_the_title($post->ID), 6, '...') ?></a></h4>
                                    <h6><a href="<?php esc_url(the_permalink()) ?>"><?php echo wp_trim_words(get_the_title($post->ID), 6, '...') ?></a></h6>
                                    <?php
                                    echo automobile_inventory_listing_price($automobile_new_price, $automobile_old_price);
                                    if (isset($automobile_inv_user_img_src) && $automobile_inv_user_img_src != '') {
                                        echo '<a class="thumb-img" href="'. get_author_posts_url( $automobile_inventory_username ).'"><img class="lazyload no-src" src="' . esc_url($automobile_inv_user_img_src) . '" alt=""></a>';
                                    }
                                    ?>
                                </div>
                                <?php
                                echo automobile_inventory_features_info($post->ID);
                                if (is_array($automobile_inv_feature_list) && sizeof($automobile_inv_feature_list) > 0) {
                                    ?>
                                    <div class="btn-list">
                                        <a href="javascript:void(0)" class="btn btn-danger collapsed" data-toggle="collapse" data-target="#list-view<?php echo absint($post->ID) ?>" aria-expanded="false"></a>
                                        <div id="list-view<?php echo absint($post->ID) ?>" class="collapse" aria-expanded="false" style="height: 0px;">
                                            <ul>
                                                <?php
                                                foreach ($automobile_inv_feature_list as $inv_feat) {
                                                    ?>
                                                    <li><?php echo esc_html($inv_feat) ?></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if (get_the_content() != '') {
                                    ?><p><?php echo wp_trim_words(get_the_content(), 20, '...') ?><a href="<?php echo esc_url(get_permalink()) ?>" class="read-more cs-color"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_more')); ?></a></p>
                                <?php } ?>
                                <?php echo automobile_inventory_compare_button($post->ID) ?>
								<div class="cs-msg-comparebox"></div>
                                <?php
                                if (is_user_logged_in()) {
                                    $user = automobile_get_user_id();

                                    $finded_result_list = automobile_find_index_user_meta_list($post->ID, 'cs-user-inventory-wishlist', 'post_id', automobile_get_user_id());
                                    if (isset($user) and $user <> '' and is_user_logged_in()) {
                                        if (is_array($finded_result_list) && !empty($finded_result_list)) {
                                            ?>
                                            <a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" value="1" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" shortlist="<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlist' ) ); ?>" shortlisted="<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlisted' ) ); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_removeinventory_to('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, '', 'dealer')" ><i class="icon-heart"></i>
                                                <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>
                                            </a> 
                                            <?php
                                        } else {
                                            ?>
                                            <a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" shortlist="<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlist' ) ); ?>" shortlisted="<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlisted' ) ); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'dealer')" ><i class="icon-heart-o"></i> <?php echo automobile_var_plugin_text_srt('automobile_var_shortlist'); ?></a> 
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <a class="whishlist_icon short-list cs-color" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" shortlist="<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlist' ) ); ?>" shortlisted="<?php echo esc_html( automobile_var_plugin_text_srt( 'automobile_var_shortlisted' ) ); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'dealer')" ><i class="icon-heart-o"></i>
                                            <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>
                                        </a> 	
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a href="javascript:void(0)" class="heart-btn short-list cs-color" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" onclick="trigger_func('#btn-header-main-login');"><i class='icon-heart-o'></i> <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?></a>
                                    <?php
                                }
                                ?>

                                <a href="<?php echo esc_url(get_permalink()) ?>" class="View-btn"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_view_detail')); ?><i class="icon-arrow-long-right"></i></a>
                            </div>
                        </div>


                        <?php
                    endwhile;
                    echo '<nav>';

                    $total_pages = 1;
                    if ($count_post > 0) {
                        $total_pages = ceil($count_post / 5);
                    }
                    $output = $automobile_var_plugin_core->automobile_var_plugin_pagination($total_pages, $automobile_current_page, 'page_id_all');
                    echo force_balance_tags($output);
                    echo '</nav>';
                    ?>
				
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="cs-tabs-holder">
                        <div class="cs-location-tabs">

                            <!--Tabs Start-->
                            <?php
                            automobile_var::automobile_var_googlemapcluster_scripts();
                            ?>

                            <div class="cs-tabs horizontal vertical">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home"><i class="icon-location-pin"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_location')); ?></a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <?php
                                        include('cs-map.php');
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <!--Tabs End-->
                        </div>
                        <div class="cs-agent-contact-form">
                            <span class="cs-form-title"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_contact_dealer')); ?></span>
                            <div class="cs-profile-contact-detail" data-adminurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" >
                                <form id="ajaxcontactdealer" action="#" method="post" enctype="multipart/form-data">
                                    <div id="ajaxcontact-response" class="status status-message"></div>
                                    <?php
                                    $output = '';
                                    $automobile_opt_array = array(
                                        'id' => 'ajaxdealername',
                                        'std' => '',
                                        'cust_id' => 'ajaxdealername',
                                        'cust_name' => 'ajaxcontactname',
                                        'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_full_name')) . '"',
                                        'classes' => '',
                                        'return' => true,
                                        'required' => 'yes',
                                    );
                                    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                    $automobile_opt_array = array(
                                        'id' => 'ajaxdealeremail',
                                        'std' => '',
                                        'cust_id' => 'ajaxdealeremail',
                                        'cust_name' => 'ajaxcontactemail',
                                        'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '"',
                                        'classes' => '',
                                        'return' => true,
                                        'required' => 'yes',
                                    );
                                    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'id' => 'ajaxdealerphone',
                                        'std' => '',
                                        'cust_id' => 'ajaxdealerphone',
                                        'cust_name' => 'ajaxcontactphone',
                                        'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '"',
                                        'classes' => '',
                                        'return' => true,
                                        'required' => 'yes',
                                    );
                                    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'id' => 'ajaxdealercontents',
                                        'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_interested')),
                                        'cust_id' => 'ajaxdealercontents',
                                        'cust_name' => 'ajaxcontactcontents',
                                        'classes' => '',
                                        'return' => true,
                                        'required' => 'yes',
                                    );
                                    $output .= $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_contact_dealer')),
                                        'cust_id' => 'dealerid_contactus',
                                        'cust_name' => 'dealerid_contactus',
                                        'cust_type' => 'submit',
                                        'classes' => 'profile-contact-btn cs-bgcolor',
                                        'extra_atr' => ' data-dealerid="' . absint($automobile_user_data->ID) . '" ',
                                        'return' => true,
                                    );
                                    $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                    echo force_balance_tags($output);
                                    ?>
                                    <div id="main-dealer-loader" class="loader_class"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($automobile_plugin_single_container == 'on') {
            echo "</div>\n</div>\n";
        }
        ?>
    </div>   
</div>
<?php get_footer(); ?>