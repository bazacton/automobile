<?php
/*
 *
 * @File :Maintenance 
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_maintenance')) {

    function automobile_var_page_builder_maintenance($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_frame_static_text;
        if (function_exists('automobile_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $automobile_output = array();
            $automobile_PREFIX = 'automobile_maintenance';

            $automobile_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
                $automobile_POSTID = '';
                $shortcode_element_id = '';
            } else {
                $automobile_POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
                $shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
                $shortcode_str = stripslashes($shortcode_element_id);
                $parseObject = new ShortcodeParse();
                $automobile_output = $parseObject->automobile_shortcodes($automobile_output, $shortcode_str, true, $automobile_PREFIX);
            }
            $defaults = array(
                'automobile_var_column' => '1',
                'automobile_var_maintenance_logo_url_array' => '',
                'automobile_var_maintenance_image_url_array' => '',
                'automobile_var_maintenance_title' => '',
                'automobile_fluid_info' => '',
                'automobile_var_lunch_date' => '',
                'automobile_var_maintenance_estimated_time' => '',
                'automobile_var_maintenance_time_left' => '',
            );
            if (isset($automobile_output['0']['atts'])) {
                $atts = $automobile_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($automobile_output['0']['content'])) {
                $maintenance_column_text = $automobile_output['0']['content'];
            } else {
                $maintenance_column_text = '';
            }
            $maintenance_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'automobile_var_page_builder_maintenance';
            $coloumn_class = 'column_' . $maintenance_element_size;
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            automobile_var_date_picker();
            ?>

            <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="maintenance" data="<?php echo automobile_element_size_data_array_index($maintenance_element_size) ?>" >
                     <?php automobile_element_setting($name, $automobile_counter, $maintenance_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_maintenance {{attributes}}]{{content}}[/automobile_maintenance]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($automobile_counter) ?>">
                        <h5><?php echo automobile_var_frame_text_srt('automobile_var_edit_maintain_page') ?></h5>
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
                                'name' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_title'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_var_maintenance_title),
                                    'cust_id' => 'automobile_var_maintenance_title' . $automobile_counter,
                                    'classes' => '',
                                    'cust_name' => 'automobile_var_maintenance_title[]',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_sub_title'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_sub_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_var_maintenance_time_left),
                                    'cust_id' => 'automobile_var_maintenance_time_left' . $automobile_counter,
                                    'classes' => '',
                                    'cust_name' => 'automobile_var_maintenance_time_left[]',
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_text'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_text_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($maintenance_column_text),
                                    'cust_id' => 'maintenance_column_text' . $automobile_counter,
                                    'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                    'classes' => '',
                                    'cust_name' => 'maintenance_column_text[]',
                                    'return' => true,
                                    'automobile_editor' => true
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_fluid'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_fluid_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($automobile_fluid_info),
                                    'id' => '',
                                    'cust_name' => 'automobile_fluid_info[]',
                                    'classes' => 'dropdown chosen-select',
                                    'options' => array(
                                        'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                                        'no' => automobile_var_frame_text_srt('automobile_var_no'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                            
                             $automobile_opt_array = array(
                                'std' => esc_url($automobile_var_maintenance_logo_url_array),
                                'id' => 'maintenance_logo_url',
                                'name' => automobile_var_frame_text_srt('automobile_var_logo'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_logo_hint'),
                                'echo' => true,
                                'array' => true,
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => esc_url($automobile_var_maintenance_logo_url_array),
                                    'id' => 'maintenance_logo_url',
                                    'return' => true,
                                    'array' => true,
                                    'array_txt' => false,
                                    'prefix' => '',
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
                            
                            
                            
                            $automobile_opt_array = array(
                                'std' => esc_url($automobile_var_maintenance_image_url_array),
                                'id' => 'maintenance_image_url',
                                'name' => automobile_var_frame_text_srt('automobile_var_image'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_image_hint'),
                                'echo' => true,
                                'array' => true,
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => esc_url($automobile_var_maintenance_image_url_array),
                                    'id' => 'maintenance_image_url',
                                    'return' => true,
                                    'array' => true,
                                    'array_txt' => false,
                                    'prefix' => '',
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_launch_date'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_launch_date_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_var_lunch_date),
                                    'cust_id' => 'automobile_var_lunch_date' . $automobile_counter,
                                    'classes' => '',
                                    'id' => 'lunch_date',
                                    'cust_name' => 'automobile_var_lunch_date[]',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_date_field($automobile_opt_array);
                            ?>
                        </div>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_frame_text_srt('automobile_var_insert'); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>

                            <?php
                            $automobile_opt_array = array(
                                'std' => 'maintenance',
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
                                    'std' => automobile_var_frame_text_srt('automobile_var_maintenance_sc_save'),
                                    'cust_id' => 'maintenance_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-automobile-admin-btn',
                                    'cust_name' => 'maintenance_save',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        }
                        ?>
                    </div>
                </div>
                <script type="text/javascript">
                            /*
                             jQuery(document).ready(function ($) {
                             if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
                             var config = {
                             '.chosen-select': {width: "100%"},
                             '.chosen-select-deselect': {allow_single_deselect: true},
                             '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%"},
                             '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                             '.chosen-select-width': {width: "95%"}
                             }
                             for (var selector in config) {
                             jQuery(selector).chosen(config[selector]);
                             }
                             }
                                         
                             });
                             */
                            popup_over();

                </script>
            </div>

            <?php
        }
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_maintenance', 'automobile_var_page_builder_maintenance');
}