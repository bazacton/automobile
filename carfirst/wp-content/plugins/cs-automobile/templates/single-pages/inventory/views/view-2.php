<?php
$automobile_inv_gallery = get_post_meta($post->ID, 'automobile_inventory_gallery_url', true);
$automobile_author_id = get_post_meta($post->ID, 'automobile_inventory_username', true);
$automobile_post_user_name = get_user_meta($automobile_author_id, 'nickname', true);
$automobile_dealer_facebook = get_user_meta($automobile_author_id, 'automobile_facebook', true);
$automobile_dealer_twitter = get_user_meta($automobile_author_id, 'automobile_twitter', true);
$automobile_dealer_linkedin = get_user_meta($automobile_author_id, 'automobile_linkedin', true);
$automobile_dealer_google_plus = get_user_meta($automobile_author_id, 'automobile_google_plus', true);
$automobile_post_user_address = get_user_meta($automobile_author_id, 'automobile_post_comp_address', true);
$automobile_post_user_phone = get_user_meta($automobile_author_id, 'automobile_phone_number', true);
$automobile_user_image = automobile_user_avatar('', $automobile_author_id);
$automobile_inventory_user_img = get_user_meta($automobile_author_id, 'user_img', true);
$automobile_post_author_url = get_author_posts_url($automobile_author_id);
$img_class = '';
$automobile_inv_user_img_src = '';
if ($automobile_inventory_user_img != '') {
    $automobile_inv_user_img_src = automobile_get_img_url($automobile_inventory_user_img, 'automobile_var_media_6');

    if ($automobile_inv_user_img_src == '') {
        $img_class = 'class="no-image"';
        $automobile_inv_user_img_src = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found4x3.jpg');
    }
}
$no_image_class = '';
if (!isset($automobile_inv_gallery) || empty($automobile_inv_gallery)) {
    $no_image_class = 'cs-no-images';
}
if ($automobile_plugin_single_container != 'on') {
    $automobile_plugin_single_container = 'on';
}
?>
<div class="cs-inventories-main-box detail-v2" data-ajaxurl="<?php echo admin_url('admin-ajax.php') ?>" id="primary">
    <?php if (is_array($automobile_inv_gallery) && !empty($automobile_inv_gallery)) { ?>
        <!-- Single - Page Slider Start -->
        <div class="slider-holder">
            <ul class="post-slider">
                <?php
                foreach ($automobile_inv_gallery as $automobile_slider_img) {

                    $automobile_slider_image = automobile_get_image_thumb($automobile_slider_img, 'automobile_var_media_1');
                    if ($automobile_slider_image != '') {
                        ?>
                        <li>
                            <img class="lazyload no-src" src="<?php echo esc_url($automobile_slider_image) ?>" alt="" />
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {

                jQuery('.post-slider').slick({
                    slidesToShow: 3,
                    speed: 1000,
                    swipeToSlide: true,
                    infinite: false,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '40px',
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '40px',
                                slidesToShow: 1
                            }
                        }
                    ]
                });
                jQuery('.slick-prev').addClass('hidden');
                jQuery('.post-slider').on('afterChange', function (event, slick, currentSlide) {
                    var item_length = jQuery('ul.post-slider li').length - 3;
                    if (currentSlide == item_length) {
                        jQuery('.slick-next').addClass('hidden');
                    } else {
                        jQuery('.slick-next').removeClass('hidden');
                    }

                    if (currentSlide === 0) {
                        jQuery('.slick-prev').addClass('hidden');
                    } else {
                        jQuery('.slick-prev').removeClass('hidden');
                    }
                });
            });
        </script>
        <!-- Single - Page Slider End -->
    <?php } ?>
    <!-- Main Start -->
    <div class="main-section"> 
        <div class="page-section" style="position:relative;">
            <?php
            if ($automobile_plugin_single_container == 'on') {
                echo "<div class=\"container\">\n<div class=\"row\">\n";
            }
            ?>
            <div id="compare_msg" class="compare-added-msg" style="display:none;"><span></span></div>
            <div class="custom-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="page-section">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="cs-detail-post-option">


                                <ul class="cs-detail-options">
                                    <?php if ($automobile_video_url != '') { ?>

                                        <li><i class="icon-remove_red_eye cs-color"></i><a data-toggle="modal" class="btn-video" href="" data-target="#request-video"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_watch_video')); ?></a></li>
                                    <?php } ?>
                                    <?php
                                    echo '<li>' . automobile_inventory_compare_det_button($post->ID) . '</li>';
                                    if (is_user_logged_in()) {
                                        $user = automobile_get_user_id();

                                        $finded_result_list = automobile_find_index_user_meta_list($post->ID, 'cs-user-inventory-wishlist', 'post_id', automobile_get_user_id());
                                        if (isset($user) and $user <> '' and is_user_logged_in()) {
                                            if (is_array($finded_result_list) && !empty($finded_result_list)) {
                                                ?>
                                                <li><i class="icon-remove_red_eye cs-color"></i><a class="whishlist_icon short-list" href="javascript:void(0)"  data-toggle="tooltip" data-placement="top" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" value="1" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_removeinventory_to('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, '', 'view2')" >
                                                        <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>
                                                    </a> </li>
                                                <?php
                                            } else {
                                                ?>
                                                <li><i class="icon-compare cs-color"></i> <a class="whishlist_icon btn-shortlist short-list" href="javascript:void(0)"  data-toggle="tooltip" data-placement="right" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'view2')" > <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?></a> </li>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <li><a class="whishlist_icon btn-shortlist short-list" href="javascript:void(0)"  data-toggle="tooltip" data-placement="right" shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>" shortlisted="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlisted')); ?>" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" value="0" add_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" remove_shortlist="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_remove_shortlist')); ?>" id="<?php echo 'addjobs_to_wishlist' . intval($post->ID); ?>" onclick="automobile_var_addinventory_to_wish('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, 'view2')" >

                                                    <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?>
                                                </a> </li> 
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <li> <a href="javascript:void(0)" class="heart-btn short-list btn-shortlist" data-toggle="tooltip" data-placement="right" title="<?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_add_to_shortlist')); ?>" onclick="trigger_func('#btn-header-main-login');"><i class='icon-heart-o'></i> <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_shortlist')); ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <div class="modal fade" id="request-video" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body popup-video">
                                                <?php
                                                $embed_code = wp_oembed_get($automobile_video_url);
                                                echo force_balance_tags($embed_code);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <ul class="cs-social-media">
                                    <?php if ($automobile_dealer_facebook != '') { ?>

                                        <li><a href="<?php echo esc_url($automobile_dealer_facebook) ?>" data-original-title="facebook"><i class="icon-facebook-with-circle"></i></a></li>
                                    <?php } if ($automobile_dealer_twitter != '') { ?>

                                        <li><a href="<?php echo esc_url($automobile_dealer_twitter) ?>" data-original-title="twitter"><i class="icon-twitter-with-circle"></i></a></li>
                                    <?php } if ($automobile_dealer_google_plus != '') { ?>

                                        <li><a href="<?php echo esc_url($automobile_dealer_google_plus) ?>" data-original-title="google"><i class="icon-google-with-circle"></i></a></li>
                                    <?php } if ($automobile_dealer_linkedin != '') { ?>

                                        <li><a href="<?php echo esc_url($automobile_dealer_linkedin) ?>" data-original-title="linkedin"><i class="icon-linkedin-with-circle"></i></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="car-detail-heading">
                                <div class="auto-text">
                                    <h2>
                                        <?php the_title(); ?>
                                        <?php if ($automobile_inventory_featured == 'yes') { ?>
                                            <span class="auto-featured"><?php echo esc_html__('Featured', 'cs-automobile'); ?></span>
                                        <?php } ?>
                                    </h2>
                                    <?php
                                    $automobile_inv_makes = get_the_term_list($post->ID, 'inventory-make', '<span><i class="icon-building-o"></i>', ', ', '</span>');
                                    if ($automobile_inv_makes != '') {
                                        printf('%1$s', $automobile_inv_makes);
                                    }
                                    ?>
                                    <address><i class="icon-location"></i><?php echo esc_html($automobile_post_comp_address); ?></address>
                                </div>
                                <?php
                                if ($price_status == 'on') {
                                    if ($automobile_old_price != '' || $automobile_new_price != '') {
                                        ?>
                                        <div class="auto-price"><span class="cs-color"><?php echo esc_html($currency_sign . $automobile_new_price); ?></span> <em><?php echo esc_html($currency_sign . $automobile_old_price); ?></em></div>
                                        <?php
                                    }
                                }
                                ?> 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="cs-detail-nav">
                                <ul>
                                    <li><a class="active" href="#vehicle"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_vehicle_overview')); ?></a></li>
                                    <li><a href="#specification"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_technical_specification')); ?></a></li>
                                    <li><a href="#accessories"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_accessories')); ?></a></li>
                                    <li><a href="#location"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_location')); ?></a></li>
                                    <li><a href="#contact"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_contact_us')); ?></a></li>
                                </ul>

                            </div>

                            <div class="on-scroll">
                                <div id="vehicle" class="auto-overview detail-content">
                                    <?php
                                    $view = 'detail';
                                    echo automobile_inventory_features_info($post->ID, $view);
                                    $inventory_content = get_the_content();
                                    $automobile_inventory_content_arr = string_split_by_words($inventory_content, 123);

                                    if (isset($automobile_inventory_content_arr[0])) {
                                        ?><p class="more-text"><?php echo do_shortcode($automobile_inventory_content_arr[0]); ?></p>
                                    <?php } if (isset($automobile_inventory_content_arr[1])) { ?>
                                        <p class="more-text"><?php echo do_shortcode($automobile_inventory_content_arr[1]); ?></p>
                                        <a id="load-text" href="" class="btn-show-more cs-color"> <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_show_more')); ?></a>
                                        <a id="hide-text" href="" class="btn-show-more cs-color"> <?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_less_more')); ?></a>
                                    <?php } ?>

                                </div>

                                <div id="specification" class="auto-specifications detail-content">
                                    <div class="section-title" style="text-align:left;">
                                        <h4><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_technical_specification')); ?></h4>
                                    </div>
                                    <?php
                                    $inventory_type_slug = get_post_meta($post->ID, 'automobile_inventory_type', true);
                                    automobile_inventory_type_detail($inventory_type_slug);
                                    ?>

                                </div>
                                <?php
                                $inventory_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish'));
                                $inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

                                $automobile_var_get_features = get_post_meta($inventory_type_id, 'automobile_inventory_type_features', true);


                                if (is_array($automobile_var_get_features)) {
                                    ?>
                                    <div id="accessories" class="cs-auto-accessories detail-content">
                                        <div class="element-title">
                                            <i class="cs-color icon-gear42"></i>
                                            <span><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_accessories_options')); ?></span>
                                        </div>
                                        <ul>

                                            <?php
                                            if (is_array($automobile_var_get_features) && sizeof($automobile_var_get_features) > 0) {

                                                foreach ($automobile_var_get_features as $feat_key => $features) {
                                                    if (isset($features) && $features <> '') {
                                                        $automobile_feature_name = isset($features['name']) ? $features['name'] : '';

                                                        if (is_array($automobile_inv_feature_list) && in_array($automobile_feature_name, $automobile_inv_feature_list) ? ' checked="checked"' : '') {
                                                            $feature_class = 'available';
                                                        } else {
                                                            $feature_class = 'not-available';
                                                        }
                                                        ?>
                                                        <li class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                            <div class="cs-listing-icon">
                                                                <ul>
                                                                    <li class="<?php echo esc_html($feature_class); ?>">

                                                                        <span><?php echo esc_html($automobile_feature_name); ?></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="detail-content">
                                    <div class="section-title">
                                        <h4 style="text-align:left;"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_inventory_location')); ?></h4>
                                    </div>
                                    <div id="location" class="cs-map loader maps">
                                        <?php
                                        include('cs-map.php');
                                        ?>

                                    </div>
                                </div>
                                <div id="contact" class="cs-contact-form detail-content cs-inventory-contact-detail" data-adminurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                                    <div class="section-title">
                                        <h4 style="text-align:left;"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_contact_us')); ?></h4>
                                    </div>
                                    <form id="ajaxcontactform" action="#" method="post" enctype="multipart/form-data">
                                        <div id="ajaxcontact-response" class="status status-message"></div>
                                        <?php
                                        $output = '';
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => '',
                                            'cust_id' => 'ajaxcontactname',
                                            'cust_name' => 'ajaxcontactname',
                                            'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_your_name')) . '"',
                                            'classes' => '',
                                            'return' => true,
                                            'required' => 'yes',
                                        );
                                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'id' => 'ajaxcontactemail',
                                            'std' => '',
                                            'cust_id' => 'ajaxcontactemail',
                                            'cust_name' => 'ajaxcontactemail',
                                            'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '"',
                                            'classes' => '',
                                            'return' => true,
                                            'required' => 'yes',
                                        );
                                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'id' => 'ajaxcontactphone',
                                            'std' => '',
                                            'cust_id' => 'ajaxcontactphone',
                                            'cust_name' => 'ajaxcontactphone',
                                            'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '"',
                                            'classes' => '',
                                            'return' => true,
                                            'required' => 'yes',
                                        );
                                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'id' => 'ajaxcontactcontents',
                                            'std' => '',
                                            'cust_id' => 'ajaxcontactcontents',
                                            'cust_name' => 'ajaxcontactcontents',
                                            'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_message')) . '"',
                                            'classes' => '',
                                            'return' => true,
                                            'required' => 'yes',
                                        );
                                        $output .= $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_submit')),
                                            'cust_id' => 'inventory_contactus',
                                            'cust_name' => 'inventory_contactus',
                                            'cust_type' => 'submit',
                                            'classes' => 'profile-contact-btn cs-bgcolor',
                                            'extra_atr' => ' data-inventoryid="' . absint($post->ID) . '" ',
                                            'return' => true,
                                        );
                                        $output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        echo force_balance_tags($output);
                                        ?>
                                        <div id="main-cs-loader" class="loader_class"></div>



                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
            <aside class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="cs-author-post">

                    <div class="element-title">
                        <h6><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_posted_by')); ?></h6>
                    </div>
                    <div class="cs-media">
                        <figure><a href="<?php echo esc_url($automobile_post_author_url); ?>"><img <?php echo $img_class; ?> src="<?php echo $automobile_inv_user_img_src; ?>" alt=""></a></figure>
                    </div>
                    <div class="cs-text">

                        <span><a class="dealer-name" href="<?php echo esc_url($automobile_post_author_url); ?>"><?php echo $automobile_post_user_name; ?></a></span>

                        <p><?php echo $automobile_post_user_address; ?></p>
                        <strong><?php echo $automobile_post_user_phone; ?></strong>
                        <a href="<?php echo esc_url($automobile_post_author_url); ?>"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_dealer_detail')); ?></a>
                    </div>
                </div>
                <div class="cs-category-link-icon">
                    <ul>
                        <li><a data-toggle="modal" href="#" data-target="#request-more-info"><i class="cs-color icon-question-circle"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_request_more')); ?></a></li>
                        <li><a data-toggle="modal" href="#" data-target="#schedule-test-drive"><i class="cs-color icon-chrome2"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_test_drive')); ?></a></li>
                        <li><a data-toggle="modal" href="#" data-target="#make-an-Offer"><i class="cs-color icon-documents2"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_an_offer')); ?></a></li>
                        <li><a onclick="window.print()" href="#" download><i class="cs-color icon-print3"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_print_detail')); ?></a></li>
                        <li><a data-toggle="modal" href="#" data-target="#email-to-friend"><i class="cs-color icon-mail5"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_friend')); ?></a></li>
                    </ul>
                    <div class="cs-form-modal">
                        <div class="modal fade" id="request-more-info" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_request_more')); ?></h4>
                                        <div class="cs-login-form cs-info-contact-detail" data-adminurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-cap="recaptcha7" >
                                            <form class="row" id="ajaxinfoform" action="#" method="post" enctype="multipart/form-data">
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12"><div id="ajaxinfo-response" class="status status-message"></div></div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxinfoname">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_your_name')); ?></strong>
                                                            <i class="icon-user-plus2"></i>
                                                            <?php
                                                            $output = '';
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxinfoname',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxinfoname',
                                                                'cust_name' => 'ajaxinfoname',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_type_your_name')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxinfoemail">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_label')); ?></strong>
                                                            <i class="icon-envelope"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxinfoemail',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxinfoemail',
                                                                'cust_name' => 'ajaxinfoemail',
                                                                'cust_type' => 'email',
                                                                'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxinfophone">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_phone_label')); ?></strong>
                                                            <i class="icon-iphone26"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxinfophone',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxinfophone',
                                                                'cust_type' => 'tel',
                                                                'cust_name' => 'ajaxinfophone',
                                                                'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxinfocontents',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxinfocontents',
                                                                'cust_name' => 'ajaxinfocontents',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
                                                $automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
                                                $automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
                                                if ($automobile_captcha_switch == 'on' && $automobile_sitekey != '' && $automobile_secretkey != '') {
                                                    ?>
                                                    <script>

                                                        var recaptcha7;
                                                        var automobile_multicap = function () {

                                                            recaptcha7 = grecaptcha.render('recaptcha7', {
                                                                'sitekey': '<?php echo esc_js($automobile_sitekey); ?>', //Replace this with your Site key
                                                                'theme': 'light'
                                                            });
                                                        };

                                                    </script>
                                                    <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <?php
                                                        echo '<div class="input-holder recaptcha-reload" id="recaptcha7_div">';
                                                        echo automobile_captcha('recaptcha7');
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_submit_query')),
                                                            'cust_id' => 'info_contactus',
                                                            'cust_name' => 'info_contactus',
                                                            'cust_type' => 'submit',
                                                            'classes' => 'profile-contact-btn cs-color csborder-color',
                                                            'extra_atr' => ' data-inventoryid="' . absint($post->ID) . '" ',
                                                            'return' => true,
                                                        );
                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                        echo force_balance_tags($output);
                                                        ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="cs-form-modal">
                        <div class="modal fade" id="schedule-test-drive" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_test_drive')); ?></h4>
                                        <div class="cs-login-form cs-test-detail " data-adminurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-cap="recaptcha10" >
                                            <form class="row" id="ajaxtestform" action="#" method="post" enctype="multipart/form-data">
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12"><div id="ajaxtest-response" class="status status-message"></div></div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxname">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_your_name')); ?></strong>
                                                            <i class="icon-user-plus2"></i>
                                                            <?php
                                                            $output = '';
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxname',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxname',
                                                                'cust_name' => 'ajaxname',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_type_your_name')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxemail">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_label')); ?></strong>
                                                            <i class="icon-envelope"></i>
                                                            <?php
                                                            $output = '';
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxemail',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxemail',
                                                                'cust_name' => 'ajaxemail',
                                                                'cust_type' => 'email',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="phone-1">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_phone_label')); ?></strong>
                                                            <i class="icon-iphone26"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxphone',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxphone',
                                                                'cust_name' => 'ajaxphone',
                                                                'cust_type' => 'tel',
                                                                'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxtime">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_best_time')); ?></strong>
                                                            <i class="icon-clock96"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxtime',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxtime',
                                                                'cust_name' => 'ajaxtime',
                                                                'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_date')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_date_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxcontents',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxcontents',
                                                                'cust_name' => 'ajaxcontents',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
                                                $automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
                                                $automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
                                                automobile_google_recaptcha_scripts();
                                                if ($automobile_captcha_switch == 'on' && $automobile_sitekey != '' && $automobile_secretkey != '') {
                                                    ?>
                                                    <script>

                                                        var recaptcha10;
                                                        var automobile_multicap = function () {

                                                            recaptcha10 = grecaptcha.render('recaptcha10', {
                                                                'sitekey': '<?php echo esc_js($automobile_sitekey); ?>', //Replace this with your Site key
                                                                'theme': 'light'
                                                            });
                                                        };

                                                    </script>
                                                    <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <?php
                                                        echo '<div class="input-holder recaptcha-reload" id="recaptcha10_div">';
                                                        echo automobile_captcha('recaptcha10');
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_submit_query')),
                                                            'cust_id' => 'test_drive',
                                                            'cust_name' => 'test_drive',
                                                            'cust_type' => 'submit',
                                                            'classes' => 'cs-color csborder-color profile-contact-btn',
                                                            'extra_atr' => ' data-inventoryid="' . $post->ID . '" ',
                                                            'return' => true,
                                                        );
                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                        echo force_balance_tags($output);
                                                        ?>
                                                        <div id="main-test-loader" class="loader_class"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="cs-form-modal">
                        <div class="modal fade" id="make-an-Offer" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_an_offer')); ?></h4>
                                        <div class="cs-login-form cs-offer-detail" data-adminurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-cap="recaptcha11" >
                                            <form class="row" id="ajaxofferform" action="#" method="post" enctype="multipart/form-data">
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12"><div id="ajaxoffer-response" class="status status-message"></div></div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxoffername">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_your_name')); ?></strong>
                                                            <i class="icon-user-plus2"></i>
                                                            <?php
                                                            $output = '';
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxoffername',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxoffername',
                                                                'cust_name' => 'ajaxoffername',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_type_your_name')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxofferemail">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_label')); ?></strong>
                                                            <i class="icon-envelope"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxofferemail',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxofferemail',
                                                                'cust_name' => 'ajaxofferemail',
                                                                'cust_type' => 'email',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="phone-6">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_phone_label')); ?></strong>
                                                            <i class="icon-iphone26"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxofferphone',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxofferphone',
                                                                'cust_name' => 'ajaxofferphone',
                                                                'cust_type' => 'tel',
                                                                'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxofferprice">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_offered_price')); ?></strong>
                                                            <i class="icon-dollar183"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxofferprice',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxofferprice',
                                                                'cust_name' => 'ajaxofferprice',
                                                                'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_price_amount')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label>
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_financing_required')); ?></strong>
                                                            <i class="icon-expand38"></i>
                                                            <?php
                                                            $finance_status = array();
                                                            $finance_status = array(
                                                                'yes' => esc_html(automobile_var_plugin_text_srt('automobile_var_yes')),
                                                                'no' => esc_html(automobile_var_plugin_text_srt('automobile_var_no')),
                                                            );
                                                            $automobile_opt_array = array(
                                                                'std' => '',
                                                                'id' => '',
                                                                'cust_id' => 'ajaxofferfinancing',
                                                                'cust_name' => 'ajaxofferfinancing',
                                                                'classes' => 'chosen-select',
                                                                'options' => $finance_status,
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_select_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>

                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxoffercontents',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxoffercontents',
                                                                'cust_name' => 'ajaxoffercontents',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
                                                $automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
                                                $automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
                                                if ($automobile_captcha_switch == 'on' && $automobile_sitekey != '' && $automobile_secretkey != '') {
                                                    ?>
                                                    <script>

                                                        var recaptcha11;
                                                        var automobile_multicap = function () {

                                                            recaptcha11 = grecaptcha.render('recaptcha11', {
                                                                'sitekey': '<?php echo ($automobile_sitekey); ?>', //Replace this with your Site key
                                                                'theme': 'light'
                                                            });
                                                        };

                                                    </script>
                                                    <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <?php
                                                        echo '<div class="input-holder recaptcha-reload" id="recaptcha11_div">';
                                                        echo automobile_captcha('recaptcha11');
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_submit_query')),
                                                            'cust_id' => 'offerform',
                                                            'cust_name' => 'offerform',
                                                            'cust_type' => 'submit',
                                                            'classes' => 'cs-color csborder-color profile-contact-btn',
                                                            'extra_atr' => ' data-inventoryid="' . absint($post->ID) . '" ',
                                                            'return' => true,
                                                        );
                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                        echo force_balance_tags($output);
                                                        ?>
                                                        <div id="main-offer-loader" class="loader_class"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cs-form-modal">
                        <div class="modal fade" id="email-to-friend" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h4><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_friend')); ?></h4>
                                        <div class="cs-login-form cs-mail-detail" data-adminurl="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-cap="recaptcha12" >
                                            <form class="row" id="ajaxfriendform" action="#" method="post" enctype="multipart/form-data">
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12"><div id="ajaxmail-response" class="status status-message"></div></div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxmailname">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_your_name')); ?></strong>
                                                            <i class="icon-user-plus2"></i>
                                                            <?php
                                                            $output = '';
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxmailname',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxmailname',
                                                                'cust_name' => 'ajaxmailname',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_type_your_name')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxmail">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_email_label')); ?></strong>
                                                            <i class="icon-envelope"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxmail',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxmail',
                                                                'cust_name' => 'ajaxmail',
                                                                'cust_type' => 'email',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_email')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="ajaxfriendmail">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_friend_email')); ?></strong>
                                                            <i class="icon-envelope"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxfriendmail',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxfriendmail',
                                                                'cust_name' => 'ajaxfriendmail',
                                                                'cust_type' => 'email',
                                                                'extra_atr' => 'placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_type_desired')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label for="phone-7">
                                                            <strong><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_phone_label')); ?></strong>
                                                            <i class="icon-iphone26"></i>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxmailphone',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxmailphone',
                                                                'cust_name' => 'ajaxmailphone',
                                                                'cust_type' => 'tel',
                                                                'extra_atr' => ' placeholder="' . esc_html(automobile_var_plugin_text_srt('automobile_var_phone')) . '"',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );
                                                            $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <label>
                                                            <?php
                                                            $automobile_opt_array = array(
                                                                'id' => 'ajaxmailcontents',
                                                                'std' => '',
                                                                'cust_id' => 'ajaxmailcontents',
                                                                'cust_name' => 'ajaxmailcontents',
                                                                'classes' => '',
                                                                'return' => true,
                                                                'required' => 'yes',
                                                            );

                                                            $output = $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);
                                                            echo force_balance_tags($output);
                                                            ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                                $automobile_captcha_switch = isset($automobile_var_plugin_options['automobile_captcha_switch']) ? $automobile_var_plugin_options['automobile_captcha_switch'] : '';
                                                $automobile_sitekey = isset($automobile_var_plugin_options['automobile_sitekey']) ? $automobile_var_plugin_options['automobile_sitekey'] : '';
                                                $automobile_secretkey = isset($automobile_var_plugin_options['automobile_secretkey']) ? $automobile_var_plugin_options['automobile_secretkey'] : '';
                                                if ($automobile_captcha_switch == 'on' && $automobile_sitekey != '' && $automobile_secretkey != '') {
                                                    ?>
                                                    <script>

                                                        var recaptcha12;
                                                        var automobile_multicap = function () {

                                                            recaptcha12 = grecaptcha.render('recaptcha12', {
                                                                'sitekey': '<?php echo ($automobile_sitekey); ?>', //Replace this with your Site key
                                                                'theme': 'light'
                                                            });
                                                        };

                                                    </script>
                                                    <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                        <?php
                                                        echo '<div class="input-holder recaptcha-reload" id="recaptcha12_div">';
                                                        echo automobile_captcha('recaptcha12');
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
                                                    <div class="cs-modal-field">
                                                        <?php
                                                        $automobile_opt_array = array(
                                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_submit_query')),
                                                            'cust_id' => 'mailfriend',
                                                            'cust_name' => 'mailfriend',
                                                            'cust_type' => 'submit',
                                                            'classes' => 'cs-color csborder-color profile-contact-btn',
                                                            'extra_atr' => ' data-inventoryid="' . absint($post->ID) . '" ',
                                                            'return' => true,
                                                        );
                                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                                        echo force_balance_tags($output);
                                                        ?>

                                                        <div id="main-friend-loader" class="loader_class"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="auto-detail-filter">
                    <script language="JavaScript">

                        function doCalc()
                        {
                            jQuery(".automobile_calculator_result").hide("slow");
                            jQuery(".automobile_calculator_loader").show("slow");
                            zeroBlanks(document.mortform);

                            var down_payment = numval(document.mortform.down_payment.value);
                            var p = numval(document.mortform.p.value);
                            p = p - down_payment;
                            var r = numval(document.mortform.r.value) / 100;
                            var y = numval(document.mortform.y.value);
                            setTimeout(function () {
                                document.mortform.payment.value = formatNumber(mortgagePayment(p, r / 12, y * 12), 2);
                                jQuery(".automobile_calculator_loader").hide("slow");
                                jQuery(".automobile_calculator_result").show("slow");
                            }, 1000);

                        }

                        function zeroBlanks(formname)
                        {
                            var i, ctrl;
                            for (i = 0; i < formname.elements.length; i++)
                            {
                                ctrl = formname.elements[i];
                                if (ctrl.type == "text")
                                {
                                    if (makeNumeric(ctrl.value) == "")
                                        ctrl.value = "0";
                                }
                            }
                        }

                        function filterChars(s, charList)
                        {
                            var s1 = "" + s; // force s1 to be a string data type
                            var i;
                            for (i = 0; i < s1.length; )
                            {
                                if (charList.indexOf(s1.charAt(i)) < 0)
                                    s1 = s1.substring(0, i) + s1.substring(i + 1, s1.length);
                                else
                                    i++;
                            }
                            return s1;
                        }

                        function makeNumeric(s)
                        {
                            return filterChars(s, "1234567890.-");
                        }

                        function numval(val, digits, minval, maxval)
                        {
                            val = makeNumeric(val);
                            if (val == "" || isNaN(val))
                                val = 0;
                            val = parseFloat(val);
                            if (digits != null)
                            {
                                var dec = Math.pow(10, digits);
                                val = (Math.round(val * dec)) / dec;
                            }
                            if (minval != null && val < minval)
                                val = minval;
                            if (maxval != null && val > maxval)
                                val = maxval;
                            return parseFloat(val);
                        }

                        function formatNumber(val, digits, minval, maxval)
                        {
                            var sval = "" + numval(val, digits, minval, maxval);
                            var i;
                            var iDecpt = sval.indexOf(".");
                            if (iDecpt < 0)
                                iDecpt = sval.length;
                            if (digits != null && digits > 0)
                            {
                                if (iDecpt == sval.length)
                                    sval = sval + ".";
                                var places = sval.length - sval.indexOf(".") - 1;
                                for (i = 0; i < digits - places; i++)
                                    sval = sval + "0";
                            }
                            var firstNumchar = 0;
                            if (sval.charAt(0) == "-")
                                firstNumchar = 1;
                            for (i = iDecpt - 3; i > firstNumchar; i -= 3)
                                sval = sval.substring(0, i) + "," + sval.substring(i);

                            return sval;
                        }

                        function mortgagePayment(p, r, y)
                        {
                            return futureValue(p, r, y) / geomSeries(1 + r, 0, y - 1);
                        }

                        function futureValue(p, r, y)
                        {
                            return p * Math.pow(1 + r, y);
                        }

                        function geomSeries(z, m, n)
                        {
                            var amt;
                            if (z == 1.0)
                                amt = n + 1;
                            else
                                amt = (Math.pow(z, n + 1) - 1) / (z - 1);
                            if (m >= 1)
                                amt -= geomSeries(z, 0, m - 1);
                            return amt;
                        }


                    </script>
                    <?php
                    $currency_price = '';
                    if ($automobile_new_price != '') {
                        $currency_price = $currency_sign . $automobile_new_price;
                    }
                    ?>
                    <div class="element-title">
                        <h6><i class="cs-bgcolor icon-line-graph"></i><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_financing_calculator')); ?></h6>
                    </div>
                    <div class="auto-filter">
                        <form name="mortform" action="JavaScript:doCalc()" method="post">
                            <ul>
                                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="auto-field">
                                        <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_vehicle_price')); ?><span class="cs-color"><?php echo '(' . esc_html($currency_sign) . ')'; ?></span></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => '',
                                            'cust_id' => 'vehicle_price',
                                            'cust_name' => 'p',
                                            'extra_atr' => 'value="' . $currency_price . '" onchange="value=formatNumber(value,2,0)" ',
                                            'classes' => '',
                                            'return' => true,
                                            'required' => 'yes',
                                        );
                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        echo force_balance_tags($output);
                                        ?>
                                    </div>
                                </li>
                                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="auto-field">
                                        <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_interest_rate')) ?><span class="cs-color"> (&#x25;)</span></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => '',
                                            'cust_id' => 'interest_rate',
                                            'cust_name' => 'r',
                                            'extra_atr' => 'placeholder="0" onchange="value=numval(value,2,0)" ',
                                            'classes' => '',
                                            'return' => true,
                                            'required' => 'yes',
                                        );
                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        echo force_balance_tags($output);
                                        ?>
                                    </div>
                                </li>
                                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="auto-field">
                                        <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_period')); ?> <span class="cs-color"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_year')); ?></span></label>
                                        <?php
                                        echo '<div class="cs-selector-range">
                                                                <input name="y" id="slider-range-finance" type="text" class="span2" value="" data-slider-min="1" data-slider-max="5" data-slider-step="1" />
                                                                       <div class="selector-value">
                                                                        <span>1</span>
                                                                        <span class="pull-right">5</span>
                                                                       </div>
                                                               </div>';

                                        echo '<script>
                                                    jQuery(document).ready(function(){
                                                            jQuery("#slider-range-finance").slider({
                                                        });
                                                    });

                                                 </script>';
                                        ?>
                                    </div>
                                </li>
                                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="auto-field">
                                        <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_down_payment')) ?><span class="cs-color"><?php echo '(' . esc_html($currency_sign) . ')'; ?></span></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => '',
                                            'cust_id' => 'down_payment',
                                            'cust_name' => 'down_payment',
                                            'classes' => '',
                                            'return' => true,
                                            'required' => 'yes',
                                        );
                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        echo force_balance_tags($output);
                                        ?>
                                    </div>
                                </li>
                                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="automobile_calculator_loader" style="display: none;"><i class="icon-spinner8 icon-spin"></i></div>
                                    <div class="auto-field automobile_calculator_result" style="display: none;">
                                        <label><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_calculator_payment')) ?><span class="cs-color"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_month')); ?></span></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => '',
                                            'std' => '',
                                            'cust_id' => '',
                                            'cust_name' => 'payment',
                                            'extra_atr' => ' readonly ',
                                            'classes' => 'cs_calc_total',
                                            'return' => true,
                                        );
                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        echo force_balance_tags($output);
                                        ?>
                                    </div>
                                </li>
                                <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="auto-field">
                                        <?php
                                        $automobile_opt_array = array(
                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_calculate')),
                                            'cust_id' => '',
                                            'cust_name' => '',
                                            'cust_type' => 'submit',
                                            'classes' => 'cs-bgcolor',
                                            'extra_atr' => 'onclick="doCalc()" ',
                                            'return' => true,
                                        );
                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        echo force_balance_tags($output);

                                        $automobile_opt_array = array(
                                            'std' => esc_html(automobile_var_plugin_text_srt('automobile_var_clear_values')),
                                            'cust_type' => 'reset',
                                            'classes' => 'cs-bgcolor',
                                            'return' => true,
                                        );
                                        $output = $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        echo force_balance_tags($output);
                                        ?>

                                    </div>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
                <?php
                if ($automobile_plugin_single_ads != '') {
                    echo do_shortcode(htmlspecialchars_decode($automobile_plugin_single_ads));
                }
                ?>

            </aside>
            <?php
            if ($automobile_plugin_single_container == 'on') {
                echo "</div>\n</div>\n";
            }
            ?>
        </div>
        <?php
        automobile_var::automobile_var_googlemapcluster_scripts();
        ?>

        <div class="page-section" style="margin-bottom:30px;">
            <?php
            if ($automobile_plugin_single_container == 'on') {
                echo "<div class=\"container\">\n<div class=\"row\">\n";
            }
            automobile_related_cars('4');
            if ($automobile_plugin_single_container == 'on') {
                echo "</div>\n</div>\n";
            }
            ?>
            <div class="cs-msg-comparebox"></div>
        </div>


    </div>
</div>