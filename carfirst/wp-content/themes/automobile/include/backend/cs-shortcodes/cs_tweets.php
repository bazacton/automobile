<?php
/*
 *
 * @Shortcode Name : Tweets
 * @retrun
 *
 */
if (!function_exists('automobile_var_page_builder_tweets')) {

    function automobile_var_page_builder_tweets($die = 0) {
        global $automobile_node, $count_node, $post, $automobile_var_html_fields, $automobile_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'automobile_tweets';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array( 
            'automobile_var_tweets_user_name' => 'default', 
            'automobile_var_no_of_tweets' => '', 
            'automobile_var_tweets_color' => '', 
            'automobile_var_tweets_class' => ''
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $tweets_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_tweets';
        $coloumn_class = 'column_' . $tweets_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        
        global $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="tweets" data="<?php echo automobile_element_size_data_array_index($tweets_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $tweets_element_size, '', 'check-square-o'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_tweets {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_twitter_edit_msg'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_attr($name . $automobile_counter); ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
                        <?php
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            automobile_shortcode_element_size();
                        }
                        
                        $automobile_opt_array = array(
                            'name' => esc_html(automobile_var_theme_text_srt('automobile_var_twitter_username')),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_twitter_username_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_tweets_user_name),
                                'cust_id' => 'automobile_var_tweets_user_name',
                                'cust_name' => 'automobile_var_tweets_user_name[]',
                                'classes' => 'input-medium',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => esc_html(automobile_var_theme_text_srt('automobile_var_twitter_text_color')),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_twitter_text_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_tweets_color),
                                'cust_id' => 'automobile_var_tweets_color',
                                'cust_name' => 'automobile_var_tweets_color[]',
                                'classes' => 'bg_color',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => esc_html(automobile_var_theme_text_srt('automobile_var_twitter_tweets_num')),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_twitter_tweets_num_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_no_of_tweets),
                                'cust_id' => 'automobile_var_no_of_tweets',
                                'cust_name' => 'automobile_var_no_of_tweets[]',
                                'classes' => 'input-medium',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        ?>
                    </div>
                    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field">
                                <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_pb_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a>
                            </li>
                        </ul>
                        <div id="results-shortocde"></div>
                        <?php
                    } else {

                        $automobile_opt_array = array(
                            'std' => 'tweets',
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'classes' => '',
                            'extra_atr' => '',
                            'cust_id' => '',
                            'cust_name' => 'automobile_orderby[]',
                            'return' => true,
                            'required' => false
                        );
                        echo automobile_var_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));

                        $automobile_opt_array = array(
                            'name' => '',
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html(automobile_var_theme_text_srt('automobile_var_save')),
                                'cust_id' => '',
                                'cust_type' => 'button',
                                'classes' => 'cs-admin-btn',
                                'cust_name' => '',
                                'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                    }
                    ?>
                </div>
            </div>
        </div>
        <script>
            /*
             * modern selection box function
             */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
            /*
             * modern selection box function
             */
        </script>

        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_tweets', 'automobile_var_page_builder_tweets');
}
?>