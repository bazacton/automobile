<?php
/*
 *
 * @File : Video
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_video')) {

    function automobile_var_page_builder_video($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields;

        if (function_exists('automobile_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $automobile_output = array();
            $AUTOMOBILE_PREFIX = 'automobile_video';
            $counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            $automobile_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
                $AUTOMOBILE_POSTID = '';
                $shortcode_element_id = '';
            } else {
                $AUTOMOBILE_POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
                $shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
                $shortcode_str = stripslashes($shortcode_element_id);
                $parseObject = new ShortcodeParse();
                $automobile_output = $parseObject->automobile_shortcodes($automobile_output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
            }
            $defaults = array(
                'automobile_var_video_title' => '',
                'automobile_var_video_url' => '',
                'automobile_var_video_width' => '',
                'automobile_var_video_height' => '',
            );
            if (isset($automobile_output['0']['atts'])) {
                $atts = $automobile_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($automobile_output['0']['content'])) {
                $video_text = $automobile_output['0']['content'];
            } else {
                $video_text = '';
            }
            $video_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'automobile_var_page_builder_video';
            $coloumn_class = 'column_' . $video_element_size;
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
			$stringsObj = new automobile_theme_all_strings;
			$stringsObj->automobile_short_code_strings();
						
            ?>
            <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="video" data="<?php echo automobile_element_size_data_array_index($video_element_size) ?>" >
                     <?php automobile_element_setting($name, $automobile_counter, $video_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_video {{attributes}}]{{content}}[/automobile_video]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($automobile_counter) ?>">
                        <h5><?php echo automobile_var_theme_text_srt('automobile_var_edit_video_text'); ?></h5>
                        <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
                            <i class="icon-times"></i>
                        </a>
                    </div>
                    <div class="cs-pbwp-content">
                        <div class="cs-wrapp-clone cs-shortcode-wrapp">
                            <?php
                            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                automobile_shortcode_element_size();
                            }

                            $automobile_opt_array = array(
                                'name' => automobile_var_theme_text_srt('automobile_var_element_title'),
                                'desc' => '',
                                'hint_text' => automobile_var_theme_text_srt('automobile_var_element_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_var_video_title),
                                    'cust_id' => 'automobile_var_video_title' . $automobile_counter,
                                    'classes' => '',
                                    'cust_name' => 'automobile_var_video_title[]',
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_theme_text_srt('automobile_var_video_field_url'),
                                'desc' => '',
                                'hint_text' => automobile_var_theme_text_srt('automobile_var_video_field_url_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_var_video_url),
                                    'cust_id' => 'automobile_var_video_url' . $automobile_counter,
                                    'classes' => '',
                                    'cust_name' => 'automobile_var_video_url[]',
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                      
                            $automobile_opt_array = array(
                                'name' => automobile_var_theme_text_srt('automobile_var_video_field_width'),
                                'desc' => '',
                                'hint_text' => automobile_var_theme_text_srt('automobile_var_video_field_width_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_var_video_width),
                                    'cust_id' => 'automobile_var_video_width' . $automobile_counter,
                                    'classes' => '',
                                    'cust_name' => 'automobile_var_video_width[]',
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_theme_text_srt('automobile_var_video_field_height'),
                                'desc' => '',
                                'hint_text' => automobile_var_theme_text_srt('automobile_var_video_field_height_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_var_video_height),
                                    'cust_id' => 'automobile_var_video_height' . $automobile_counter,
                                    'classes' => '',
                                    'cust_name' => 'automobile_var_video_height[]',
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            ?>
                        </div>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" 
                                       onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', 
                                                   '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>

                            <?php
                            $automobile_opt_array = array(
                                'std' => 'video',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                'cust_id' => 'automobile_orderby' . $automobile_counter,
                                'cust_name' => 'automobile_orderby[]',
                                'required' => false
                            );
                             $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => automobile_var_theme_text_srt('automobile_var_save'),
                                    'cust_id' => 'video_save' . $automobile_counter,
                                    'cust_type' => 'button',
                                       'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-automobile-admin-btn',
                                    'cust_name' => 'video_save',
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
                                /* modern selection box and help hover text function */
                                jQuery(document).ready(function ($) {
                                    chosen_selectionbox();
                                    popup_over();
                                });
                                /* end modern selection box and help hover text function */
                            </script>
            <?php
        }
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_video', 'automobile_var_page_builder_video');
}
 