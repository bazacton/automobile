<?php
/*
 *
 * @Shortcode Name : Maintenance
 * @retrun
 *
 */
if (!function_exists('automobile_var_maintenance')) {

    function automobile_var_maintenance($atts, $content = "") {
        global $post, $wp_query, $automobile_var_options, $automobile_var_post_meta, $automobile_var_frame_options;
        
        update_option('automobile_underconstruction_redirecting', '0'); // for undercostruction reset redirect.\
        
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_column' => '1',
            'automobile_var_maintenance_text' => '',
            'automobile_var_maintenance_time_left' => '',
            'automobile_var_maintenance_logo_url_array' => '',
            'automobile_var_maintenance_image_url_array' => '',
            'automobile_fluid_info' => '',
            'automobile_var_maintenance_title' => '',
            'automobile_var_lunch_date' => '',
            'automobile_var_maintenance_sub_title' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = '';

        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if ($automobile_var_column_size <> '') {
                if (function_exists('automobile_var_custom_column_class')) {
                    $column_class = automobile_var_custom_column_class($automobile_var_column_size);
                }
            }
        }

        if (isset($column_class) && $column_class <> '') {
            echo '<div class="' . esc_html($column_class) . '">';
        }
        $automobile_fluid_info = isset($automobile_fluid_info) ? $automobile_fluid_info : '';
        $automobile_var_maintenance_image_url_array = isset($automobile_var_maintenance_image_url_array) ? $automobile_var_maintenance_image_url_array : '';
        $automobile_var_maintenance_logo_url_array = isset($automobile_var_maintenance_logo_url_array) ? $automobile_var_maintenance_logo_url_array : '';
        $automobile_var_maintenance_title = isset($automobile_var_maintenance_title) ? $automobile_var_maintenance_title : '';
        $automobile_var_maintenance_sub_title = isset($automobile_var_maintenance_time_left) ? $automobile_var_maintenance_time_left : '';
        $automobile_var_maintenance_text = $content;
        $automobile_var_lunch_date = isset($automobile_var_lunch_date) ? $automobile_var_lunch_date : '';
        $automobile_var_coming_soon_switch = isset($automobile_var_frame_options['automobile_var_coming_soon_switch']) ? $automobile_var_frame_options['automobile_var_coming_soon_switch'] : '';
        $automobile_var_coming_logo_switch = isset($automobile_var_frame_options['automobile_var_coming_logo_switch']) ? $automobile_var_frame_options['automobile_var_coming_logo_switch'] : '';
        $automobile_var_header_switch = isset($automobile_var_frame_options['automobile_var_header_switch']) ? $automobile_var_frame_options['automobile_var_header_switch'] : '';
        $automobile_var_footer_switch = isset($automobile_var_frame_options['automobile_var_footer_setting']) ? $automobile_var_frame_options['automobile_var_footer_setting'] : '';
        $automobile_var_coming_social_switch = isset($automobile_var_frame_options['automobile_var_coming_social_switch']) ? $automobile_var_frame_options['automobile_var_coming_social_switch'] : '';
        $automobile_var_coming_newsletter_switch = isset($automobile_var_frame_options['automobile_var_coming_newsletter_switch']) ? $automobile_var_frame_options['automobile_var_coming_newsletter_switch'] : '';

        $automobile_var_date = date_i18n('Y/m/d', strtotime($automobile_var_lunch_date));
 
        $automobile_var_maintenance = '';
        ob_start();
        if ($automobile_var_header_switch <> 'on') {
            echo ' <div class="wrapper"><div class="main-section"><div class="page-section"><div class="container">';
        }
        ?>

        <?php if ($automobile_fluid_info == 'no') { ?>
            <div id="cs-construction" class="page-section" style="background:url(<?php echo $automobile_var_maintenance_image_url_array; ?>) no-repeat;background-size:cover;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="cs-construction">
                                <div class="cs-light-overlay"></div>
                                <div class="cs-construction-holder">
                                    <?php if (isset($automobile_var_coming_logo_switch) && $automobile_var_coming_logo_switch == 'on') { ?>
                                        <div class="cs-logo">
                                            <figure><a href="#"><img src="<?php echo esc_url($automobile_var_maintenance_logo_url_array); ?>" alt="" /></a></figure>
                                        </div>
                                    <?php } ?>
                                    <em><span class="cs-color"><?php echo esc_html($automobile_var_maintenance_title); ?></span><?php echo $automobile_var_maintenance_sub_title; ?></em>
                                    <div class="cs-const-counter">
                                        <div id="getting-started"><?php echo $automobile_var_date; ?></div>
                                    </div>
                                    <?php if ($automobile_var_maintenance_text <> '') { ?>
                                        <p><?php echo htmlspecialchars_decode($automobile_var_maintenance_text); ?></p>
                                    <?php } ?>
                                    <?php if ($automobile_var_coming_newsletter_switch <> '' && $automobile_var_coming_newsletter_switch == "on") { ?>
                                        <div class="cs-form">
                                            <?php
                                            $under_construction = '1';
                                            automobile_custom_mailchimp($under_construction); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($automobile_var_coming_social_switch <> '' && $automobile_var_coming_social_switch == "on") { ?>
                                        <div class="cs-social-media">
                                            <?php echo automobile_var_social_network(); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } elseif ($automobile_fluid_info == 'yes') {
            ?>
            <div id="cs-construction" class="page-section" style="background:url(<?php echo $automobile_var_maintenance_image_url_array; ?>) no-repeat;background-size:cover;">
                <div class="container">
                    <div class="cs-light-overlay"></div>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="cs-construction">

                                <div class="cs-construction-holder">
                                    <?php if (isset($automobile_var_coming_logo_switch) && $automobile_var_coming_logo_switch == 'on') { ?>
                                        <div class="cs-logo">
                                            <figure><a href="#"><img src="<?php echo esc_url($automobile_var_maintenance_logo_url_array); ?>" alt="" /></a></figure>
                                        </div>
                                    <?php } ?>
                                    <em><span class="cs-color"><?php echo esc_html($automobile_var_maintenance_title); ?></span><?php echo $automobile_var_maintenance_sub_title; ?></em>
                                    <div class="cs-const-counter">
                                        <div id="getting-started"><?php echo $automobile_var_date; ?></div>
                                    </div>
                                    <?php if ($automobile_var_maintenance_text <> '') { ?>
                                        <p><?php echo htmlspecialchars_decode($automobile_var_maintenance_text); ?></p>
                                    <?php } ?>               
                                    <?php if ($automobile_var_coming_newsletter_switch <> '' && $automobile_var_coming_newsletter_switch == "on") { ?>
                                        <div class="cs-form">
                                            <?php
                                            $under_construction = '1';
                                            automobile_custom_mailchimp($under_construction); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($automobile_var_coming_social_switch <> '' && $automobile_var_coming_social_switch == "on") { ?>
                                        <div class="cs-social-media">
                                            <?php echo automobile_var_social_network(); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php

        if ($automobile_var_footer_switch <> 'on') {
            echo '</div></div></div></div></div>';
        }
        if (isset($column_class) && $column_class <> '') {
            echo '</div>';
        }
        ?>
        <?php
        $automobile_var_maintenance = ob_get_clean();
        return $automobile_var_maintenance;
    }

    if (function_exists('automobile_var_short_code'))
        automobile_var_short_code('automobile_maintenance', 'automobile_var_maintenance');
}