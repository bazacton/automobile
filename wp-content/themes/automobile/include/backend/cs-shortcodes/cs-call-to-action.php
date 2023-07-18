<?php
/*
 *
 * @File : Call to action
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_call_to_action')) {

    function automobile_var_page_builder_call_to_action($die = 0) {

        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;


        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $AUTOMOBILE_BARBER_PREFIX = 'call_to_action';
        $automobile_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
        $parseObject = new ShortcodeParse();
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $AUTOMOBILE_POSTID = '';
            $shortcode_element_id = '';
        } else {
            $AUTOMOBILE_POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $automobile_var_shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->automobile_shortcodes($output, $automobile_var_shortcode_str, true, $AUTOMOBILE_BARBER_PREFIX);
        }
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_call_to_action_title' => '',
            'automobile_var_call_action_subtitle' => '',
            'automobile_var_heading_color' => '#000',
            'automobile_var_icon_color' => '#FFF',
            'automobile_var_call_to_action_icon_background_color' => '',
            'automobile_var_call_to_action_button_text' => '',
            'automobile_var_call_to_action_button_link' => '#',
            'automobile_var_call_to_action_bg_img' => '',
            'automobile_var_contents_bg_color' => '',
            'automobile_var_call_to_action_img_array' => '',
	    'automobile_var_call_to_action_top_img_array' => '',
            'automobile_var_call_action_view' => '',
            'automobile_var_call_action_text_align' => '',
            'automobile_var_call_to_action_class' => '',
            'automobile_var_call_action_img_align' => '',
	    'automobile_var_call_action_style' => '',
            'automobile_var_button_bg_color' => '',
            'automobile_var_button_border_color' => ''
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else
            $atts_content = "";
        $call_to_action_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }


        $name = 'automobile_var_page_builder_call_to_action';
        $coloumn_class = 'column_' . $call_to_action_element_size;

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
             <?php echo esc_attr($shortcode_view); ?>" item="call_to_action" data="<?php echo automobile_element_size_data_array_index($call_to_action_element_size) ?>" >
                 <?php automobile_element_setting($name, $automobile_counter, $call_to_action_element_size) ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?>
                 <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[call_to_action {{attributes}}]{{content}}[/call_to_action]" style="display: none;">
                <div class="cs-heading-area" data-counter="<?php echo esc_attr($automobile_counter) ?>">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_call_to_action_edit') ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
                        <i class="icon-times"></i>
                    </a>
                </div> 
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
                        <?php
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            automobile_shortcode_element_size();
                        }
                        ?>

                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_element_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_element_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_allow_special_char($automobile_var_call_to_action_title),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_var_call_to_action_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        ?>

                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_allow_special_char($automobile_var_call_action_subtitle),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_var_call_action_subtitle[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_title_color'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_title_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_heading_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'automobile_var_heading_color[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                       
                        ?>

                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_short_text'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_short_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_textarea($atts_content),
                                'cust_id' => 'atts_content' . $automobile_counter,
                                'classes' => '',
                                'cust_name' => 'atts_content[]',
                                'return' => true,
                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                'automobile_editor' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
                       
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_call_style'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_call_action_style,
                                'cust_id' => '',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'cust_name' => 'automobile_var_call_action_style[]',
                                'options' => array(
                                    "default" => automobile_var_theme_text_srt('automobile_var_call_style_default'),
                                    "classic" => automobile_var_theme_text_srt('automobile_var_call_style_classic'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        
                       
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_bgcolor'),
                            'desc' => '',
                            'id' => 'call_to_action_id',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_bg_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_contents_bg_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'automobile_var_contents_bg_color[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        

                        ?>
			<?php
                        $automobile_opt_array = array(
                            'std' => $automobile_var_call_to_action_top_img_array,
                            'id' => 'call_to_action_top_img',
                            'main_id' => 'call_to_action_top_img',
                            'name' => automobile_var_theme_text_srt('automobile_var_top_image'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_theme_option_image_hint'),
                            'echo' => true,
                            'array' => true,
                            'field_params' => array(
                                'std' => $automobile_var_call_to_action_top_img_array,
                                'cust_id' => '',
                                'id' => 'call_to_action_top_img',
                                'return' => true,
                                'array' => true,
                                'array_txt' => false,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
                        ?>
                        <?php
                        $automobile_opt_array = array(
                            'std' => $automobile_var_call_to_action_img_array,
                            'id' => 'call_to_action_img',
                            'main_id' => 'call_to_action_img_id',
                            'name' => automobile_var_theme_text_srt('automobile_var_background_image'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_theme_option_bg_image_hint'),
                            'echo' => true,
                            'array' => true,
                            'field_params' => array(
                                'std' => $automobile_var_call_to_action_img_array,
                                'cust_id' => '',
                                'id' => 'call_to_action_img',
                                'return' => true,
                                'array' => true,
                                'array_txt' => false,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
                        ?>
                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_image_position'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_var_call_action_img_align,
                                'cust_id' => '',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'cust_name' => 'automobile_var_call_action_img_align[]',
                                'options' => array("no-repeat center top" => automobile_var_theme_text_srt('automobile_var_no_repeat_center_top'),
                                    "repeat center top" => automobile_var_theme_text_srt('automobile_var_repeat_center_top'),
                                    "no-repeat center" => automobile_var_theme_text_srt('automobile_var_no_repeat_center'),
                                    "Repeat Center" => automobile_var_theme_text_srt('automobile_var_repeat_center'),
                                    "no-repeat left top" => automobile_var_theme_text_srt('automobile_var_no_repeat_left_top'),
                                    "repeat left top" => automobile_var_theme_text_srt('automobile_var_repeat_left_top'),
                                    "no-repeat fixed center" => automobile_var_theme_text_srt('automobile_var_no_repeat_fixed_center'),
                                    "no-repeat fixed center / cover" => automobile_var_theme_text_srt('automobile_var_no_repeat_fixed_center_cover')
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        
                        
                        
                        
                          $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_call_to_action_button_bg'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_call_to_action_button_bg_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_button_bg_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'automobile_var_button_bg_color[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_call_to_action_button_border'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_call_to_action_button_border_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_button_border_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'automobile_var_button_border_color[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_button_color'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_button_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_call_to_action_icon_background_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'automobile_var_call_to_action_icon_background_color[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        ?>
                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_button_text'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_button_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_call_to_action_button_text),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'automobile_var_call_to_action_button_text[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_button_link'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_button_link_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_call_to_action_button_link),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'automobile_var_call_to_action_button_link[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_text_align'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_var_call_action_text_align),
                                'cust_id' => '',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'cust_name' => 'automobile_var_call_action_text_align[]',
                                'options' => array('center' => automobile_var_theme_text_srt('automobile_var_center_align'), 'left' => automobile_var_theme_text_srt('automobile_var_left_align'), 'right' => automobile_var_theme_text_srt('automobile_var_right_align')),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        ?>


                    </div>
        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>

                        <ul class="form-elements insert-bg">
                            <li class="to-field">
                                <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a>
                            </li>
                            <div id="results-shortocde"></div>
        <?php } else { ?>
            <?php
            $automobile_opt_array = array(
                'std' => 'call_to_action',
                'id' => '',
                'before' => '',
                'after' => '',
                'classes' => '',
                'extra_atr' => '',
                'cust_id' => 'automobile_orderby',
                'cust_name' => 'automobile_orderby[]',
                'return' => false,
                'required' => false
            );
            $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
            ?>
                            <?php
                            $automobile_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => automobile_var_theme_text_srt('automobile_var_save'),
                                    'cust_id' => '',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-barber-admin-btn',
                                    'cust_name' => '',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            ?>
                        <?php } ?>
                </div>
            </div>
        </div>

        <script>
            /* modern selection box and help hover text function */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
            /* end modern selection box and help hover text function */
        </script>
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_call_to_action', 'automobile_var_page_builder_call_to_action');
}