<?php
/**
 * @ Start function for Add Meta Box For Post  
 * @return
 *
 */
add_action('add_meta_boxes', 'automobile_meta_post_add');
if (!function_exists('automobile_meta_post_add')) {

    function automobile_meta_post_add() {
        global $automobile_var_frame_static_text;

        add_meta_box('automobile_meta_post', automobile_var_frame_text_srt('automobile_var_post_options'), 'automobile_meta_post', 'post', 'normal', 'high');
    }

}

/**
 * @ Start function for Meta Box For Post  
 * @return
 *
 */
if (!function_exists('automobile_meta_post')) {

    function automobile_meta_post($post) {
        global $automobile_var_frame_static_text;
        ?>
        <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <div class="elementhidden">
                        <nav class="admin-navigtion">
                            <ul id="cs-options-tab">
                                <li><a name="#tab-general-settings" href="javascript:;"><i class="icon-gear"></i><?php echo automobile_var_frame_text_srt('automobile_var_general_setting'); ?> </a></li>
                                <li><a name="#tab-slideshow" href="javascript:;"><i class="icon-forward2"></i> <?php echo automobile_var_frame_text_srt('automobile_var_subheader'); ?></a></li>
                                <li><a name="#tab-post-options" href="javascript:;"><i class="icon-list-alt"></i><?php echo automobile_var_frame_text_srt('automobile_var_post_settings'); ?>  </a></li>
                            </ul> 
                        </nav>
                        <div id="tabbed-content">
                            <div id="tab-general-settings">
                                <?php
                                automobile_post_settings_element();
                                automobile_sidebar_layout_options();
                                ?>
                            </div>
                            <div id="tab-slideshow">
                                <?php automobile_subheader_element(); ?>
                            </div>
                            <div id="tab-post-options">
                                <?php
                                if (function_exists('automobile_var_post_options')) {
                                    automobile_var_post_options();
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }

}

/**
 * @ Start function for Slider options 
 * @return html
 *
 */
if (!function_exists('automobile_var_post_options')) {

    function automobile_var_post_options() {
        global $post, $automobile_html_fields, $automobile_var_form_fields, $automobile_var_frame_static_text;

        // Show hide post thumnail
        $thumb_view = get_post_meta($post->ID, 'automobile_thumb_view', true);
        $post_thumb_image = $post_thumb_slider = 'hide';
        if (isset($thumb_view) && $thumb_view == 'single') {
            $post_thumb_image = 'show';
        } else if (isset($thumb_view) && $thumb_view == 'slider') {
            $post_thumb_slider = 'show';
        }
        // Show hide post detail views
        $detail_view = get_post_meta($post->ID, 'automobile_detail_view', true);
        $automobile_blog_view = get_post_meta($post->ID, 'automobile_blog_views', true);
        ?>
        <script>


            function thumb_view(val) {
                if (val == 'single') {
                    jQuery('#post_list_gallery').hide();
                    jQuery('#post_video_url').hide();
                    jQuery('#post_audio_url').hide();
                } else if (val == 'slider') {
                    jQuery('#post_list_gallery').show();
                    jQuery('#post_video_url').hide();
                    jQuery('#post_audio_url').hide();
                } else if (val == 'audio') {
                    jQuery('#post_audio_url').show();
                    jQuery('#post_list_gallery').hide();
                    jQuery('#post_video_url').hide();
                } else if (val == 'video') {
                    jQuery('#post_audio_url').hide();
                    jQuery('#post_list_gallery').hide();
                    jQuery('#post_video_url').show();
                } else {
                    jQuery('#automobile_post_list_gallery').hide();
                    jQuery('#post_video_url').hide();
                    jQuery('#post_audio_url').hide();
                }

            }


            function inside_post_view(val) {
                if (val == 'slider') {
                    jQuery('#post_detail_gallery').show();
                    jQuery('#audio_view').hide();
                    jQuery('#video_view').hide();
                } else if (val == 'audio') {
                    jQuery('#post_detail_gallery').hide();
                    jQuery('#audio_view').show();
                    jQuery('#video_view').hide();
                } else if (val == 'video') {
                    jQuery('#post_detail_gallery').hide();
                    jQuery('#audio_view').hide();
                    jQuery('#video_view').show();
                } else if (val == 'audio') {
                    jQuery('#post_detail_gallery').hide();
                    jQuery('#audio_view').hide();
                    jQuery('#video_view').show();
                } else {
                    jQuery('#post_detail_gallery').hide();
                    jQuery('#audio_view').hide();
                    jQuery('#video_view').hide();
                }

            }
        </script>
        <?php
        $automobile_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_thumbnail_view_demo'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_thumbnail_view_demo_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'thumb_view',
                'extra_atr' => 'onchange="thumb_view(this.value)"',
                'classes' => 'chosen-select-no-single automobile_thumb_view',
                'options' => array('none' => automobile_var_frame_text_srt('automobile_var_none'), 'single' => automobile_var_frame_text_srt('automobile_var_single_image'), 'slider' => automobile_var_frame_text_srt('automobile_var_slider'), 'video' => automobile_var_frame_text_srt('automobile_var_video')),
                'return' => true,
            ),
        );
        $automobile_html_fields->automobile_select_field($automobile_opt_array);

        $automobile_slider_display = 'none';
        $automobile_single_image = 'none';
        $automobile_audio_display = 'none';
        $automobile_video_display = 'none';

        if ($thumb_view == "slider") {
            $automobile_slider_display = 'block';
        } elseif ($thumb_view == "single") {
            $automobile_single_image = 'none';
        }
        if ($thumb_view == "video") {
            $automobile_video_display = 'block';
        }
        if ($thumb_view == "audio") {
            $automobile_audio_display = 'block';
        }
        ?>


        <div id="post_video_url" style="display: <?php echo esc_html($automobile_video_display); ?>">
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_thumbnail_video_url'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_thumbnail_video_url_hint'),
                'echo' => true,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => '',
                    'id' => 'video_url',
                    'return' => true,
                ),
            );
            $automobile_html_fields->automobile_text_field($automobile_opt_array);
            ?>
        </div>
        <div class="row" id="post_list_gallery" style="display: <?php echo esc_html($automobile_slider_display); ?>">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="" >
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="" >
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_add_gallery_images'),
                    'desc' => '',
                    'hint_text' => '',
                    'id' => 'post_list_gallery',
                    'extra_atr' => '',
                    'echo' => true,
                );

                $automobile_html_fields->automobile_gallery_render($automobile_opt_array);
                ?>
            </div>
        </div>

        <div id="detail_view" >
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_inside_post_view'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_inside_post_view_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => 'single',
                    'id' => 'detail_view',
                    'extra_atr' => 'onchange="inside_post_view(this.value)"',
                    'classes' => 'chosen-select-no-single',
                    'options' => array('none' => automobile_var_frame_text_srt('automobile_var_none'), 'single' => automobile_var_frame_text_srt('automobile_var_single_image'), 'slider' => automobile_var_frame_text_srt('automobile_var_slider'), 'video' => automobile_var_frame_text_srt('automobile_var_video')),
                    'return' => true,
                ),
            );

            $automobile_html_fields->automobile_select_field($automobile_opt_array);
            $detail_slider = 'none';
            $detail_audio = 'none';
            $detail_video = 'none';
            if (isset($detail_view) && $detail_view == 'slider') {
                $detail_slider = 'block';
            } else if (isset($detail_view) && $detail_view == 'audio') {
                $detail_audio = 'block';
            } else if (isset($detail_view) && $detail_view == 'video') {
                $detail_video = 'block';
            } else {
                $detail_slider = 'none';
                $detail_audio = 'none';
                $detail_video = 'none';
            }
            ?>
        </div>
        <div id="post_detail_gallery" style="display: <?php echo esc_html($detail_slider); ?>">
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_add_gallery_images'),
                'id' => 'post_detail_gallery',
                'classes' => '',
                'std' => 'gallery_slider_meta_form',
            );

            $automobile_html_fields->automobile_gallery_render($automobile_opt_array);
            ?>
        </div>

        <div id="video_view" style="display: <?php echo esc_html($detail_video); ?>">
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_thumbnail_video_url'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_thumbnail_video_url_hint'),
                'echo' => true,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => '',
                    'id' => 'video_view',
                    'return' => true,
                ),
            );
            $automobile_html_fields->automobile_text_field($automobile_opt_array);
            ?>
        </div>
        <?php
    }

}

/**
 * @page/post General Settings Function
 * @return
 *
 */
if (!function_exists('automobile_post_settings_element')) {

    function automobile_post_settings_element() {
        global $post, $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_frame_static_text;


        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_social_sharing'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'post_social_sharing',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_checkbox_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_tag'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'post_tags_show',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_checkbox_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_related_posts'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'related_post',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_checkbox_field($automobile_var_opt_array);
    }

}