<?php

/**
 * @Ads widget Class
 *
 *
 */
if (!class_exists('automobile_ads')) {

    class automobile_ads extends WP_Widget {

        /**
         * @init Ads Module
         *
         *
         */
        public function __construct() {
            global $automobile_var_static_text;

            parent::__construct(
                    'automobile_ads', // Base ID
                    automobile_var_theme_text_srt('automobile_var_ads'), // Name
                    array('classname' => '', 'description' => automobile_var_theme_text_srt('automobile_var_ads_description'),) // Args
            );
        }

        /**
         * @Ads html form
         *
         *
         */
        function form($instance) {
            global $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_static_text;

            $cs_rand_id = rand(23789, 934578930);
            $instance = wp_parse_args((array) $instance, array('title' => '', 'banner_code' => ''));
            $title = $instance['title'];
            $banner_style = isset($instance['banner_style']) ? esc_attr($instance['banner_style']) : '';
            $banner_code = $instance['banner_code'];
            $banner_view = isset($instance['banner_view']) ? esc_attr($instance['banner_view']) : '';
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';


            $strings = new automobile_theme_all_strings;
            $strings->automobile_short_code_strings();

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_title_field'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($title),
                    'classes' => '',
                    'cust_id' => automobile_allow_special_char($this->get_field_name('title')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('title')),
                    'return' => true,
                    'required' => false
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_banner_view'),
                'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_view_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($banner_view),
                    'cust_id' => automobile_allow_special_char($this->get_field_id('banner_view')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('banner_view')),
                    'extra_atr' => 'onchange="javascript:banner_widget_toggle(this.value ,  \'' . $cs_rand_id . '\')"',
                    'desc' => '',
                    'classes' => '',
                    'options' =>
                    array(
                        'single' => automobile_var_theme_text_srt('automobile_var_single_banner'),
                        'random' => automobile_var_theme_text_srt('automobile_var_random_banner'),
                    ),
                    'return' => true,
                ),
            );
			
            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
            $display_single = automobile_allow_special_char($banner_view) == 'random' ? 'block' : 'none';
            echo '<div class="banner_style_field_'.esc_attr($cs_rand_id).'" style="display:'.esc_html($display_single).'">';
            
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_banner_style'),
                'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_style_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($banner_style),
                    'cust_id' => automobile_allow_special_char($this->get_field_id('banner_style')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('banner_style')),
                    'desc' => '',
                    'classes' => '',
                    'options' =>
                    array(
                        'top_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_top'),
                        'bottom_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_bottom'),
                        'sidebar_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_sidebar'),
                        'vertical_banner' => automobile_var_theme_text_srt('automobile_var_banner_type_vertical'),
                    ),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);



            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_no_of_banner'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_no_of_banner_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($showcount),
                    'classes' => '',
                    'cust_id' => automobile_allow_special_char($this->get_field_name('showcount')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('showcount')),
                    'return' => true,
                    'required' => false
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            echo '</div>';

            $display_random = automobile_allow_special_char($banner_view) == 'single' ? 'block' : 'none';
			if( $banner_view != 'single' && $banner_view != 'random'){
				$display_random =	'block';
			}
            echo '<div class="banner_code_field_'.esc_attr($cs_rand_id).'" style="display:'.esc_html($display_random).'">';
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_banner_code'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_banner_code_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($banner_code),
                    'classes' => '',
                    'cust_id' => automobile_allow_special_char($this->get_field_name('banner_code')),
                    'cust_name' => automobile_allow_special_char($this->get_field_name('banner_code')),
                    'return' => true,
                    'required' => false
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            echo '</div>';
        }

        /**
         * @Ads update form data
         *
         *
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['banner_style'] = esc_sql($new_instance['banner_style']);
            $instance['banner_code'] = $new_instance['banner_code'];
            $instance['banner_view'] = esc_sql($new_instance['banner_view']);
            $instance['showcount'] = esc_sql($new_instance['showcount']);
            return $instance;
        }

        /**
         * @Display Ads widget
         *
         */
        function widget($args, $instance) {
			
            extract($args, EXTR_SKIP);
            global $wpdb, $post, $automobile_var_options;
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			
            $title = wp_specialchars_decode(stripslashes($title));
            $banner_style = empty($instance['banner_style']) ? ' ' : apply_filters('widget_title', $instance['banner_style']);
            $banner_code = empty($instance['banner_code']) ? ' ' : $instance['banner_code'];
            $banner_view = empty($instance['banner_view']) ? ' ' : apply_filters('widget_title', $instance['banner_view']);
            $showcount = empty($instance['showcount']) ? ' ' : $instance['showcount']; 
			
            // WIDGET display CODE Start
            echo automobile_allow_special_char($before_widget, false);
            if (strlen($title) <> 1 || strlen($title) <> 0) {
                echo automobile_allow_special_char($before_title . $title . $after_title, false);
            }
            $showcount = ( $showcount <> '' || !is_integer($showcount) ) ? $showcount : 2;




            if ($banner_view == 'single') {
                echo do_shortcode($banner_code);
            } else {

                $total_banners = ( is_integer($showcount) && $showcount > 10) ? 10 : $showcount;
				
                if (isset($automobile_var_options['automobile_var_banner_title'])) {
                    $i = 0;
                    $d = 0;
                    $banner_array = array();
                    foreach ($automobile_var_options['automobile_var_banner_title'] as $banner) :
                        if ($automobile_var_options['automobile_var_banner_style'][$i] == $banner_style) {

                            $banner_array[] = $i;
                            $d++;
                        }
                        if ($total_banners == $d) {
                            break;
                        }
                        $i++;
                    endforeach;
                    if (sizeof($banner_array) > 0) {
                        $act_size = sizeof($banner_array) - 1;
                        $rand_banner = rand(0, $act_size);

                        $rand_banner = $banner_array[$rand_banner];
                        echo do_shortcode('[automobile_ads id="' . $automobile_var_options['automobile_var_banner_field_code_no'][$rand_banner] . '"]');
                    }
                }
            }

            echo automobile_allow_special_char($after_widget, false);
        }

    }

}
if (function_exists('cs_widget_register')) {
    cs_widget_register("automobile_ads");
}
