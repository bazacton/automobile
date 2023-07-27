<?php
/*
 *
 * @File : Button
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_button')) {

    function automobile_var_page_builder_button($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;

        if (function_exists('automobile_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $automobile_output = array();
            $AUTOMOBILE_PREFIX = 'automobile_button';

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
                'automobile_var_column' => '1',
                'automobile_var_button_text' => '',
                'automobile_var_button_link' => '',
                'automobile_var_button_border' => '',
                'automobile_var_button_icon_position' => '',
                'automobile_var_button_type' => '',
                'automobile_var_button_target' => '',
                'automobile_var_button_border_color' => '',
                'automobile_var_button_color' => '',
                'automobile_var_button_bg_color' => '',
                'automobile_var_button_padding_top' => '',
                'automobile_var_button_padding_bottom' => '',
                'automobile_var_button_padding_left' => '',
                'automobile_var_button_padding_right' => '',
                'automobile_var_button_align' => '',
                'automobile_button_icon' => '',
                'automobile_var_button_size' => '',
                'automobile_var_icon_view' => ''
            );
            if (isset($automobile_output['0']['atts'])) {
                $atts = $automobile_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($automobile_output['0']['content'])) {
                $button_column_text = $automobile_output['0']['content'];
            } else {
                $button_column_text = '';
            }
            $button_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }

            $name = 'automobile_var_page_builder_button';
            $coloumn_class = 'column_' . $button_element_size;
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
            <?php echo esc_attr($shortcode_view); ?>" item="button" data="<?php echo automobile_element_size_data_array_index($button_element_size) ?>" >
                 <?php automobile_element_setting($name, $automobile_counter, $button_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_button {{attributes}}]{{content}}[/automobile_button]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($automobile_counter) ?>">
                        <h5><?php echo automobile_var_theme_text_srt('automobile_var_button_edit_text'); ?></h5>
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
                'name' => automobile_var_theme_text_srt('automobile_var_button_sc_text'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_text_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($automobile_var_button_text),
                    'cust_id' => 'automobile_var_button_text' . $automobile_counter,
                    'classes' => '',
                    'cust_name' => 'automobile_var_button_text[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_sc_url'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_url_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($automobile_var_button_link),
                    'cust_id' => 'automobile_var_button_link' . $automobile_counter,
                    'classes' => '',
                    'cust_name' => 'automobile_var_button_link[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_sc_border'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_border_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => $automobile_var_button_border,
                    'id' => '',
                    'cust_name' => 'automobile_var_button_border[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => array(
                        'yes' => automobile_var_theme_text_srt('automobile_var_yes'),
                        'no' => automobile_var_theme_text_srt('automobile_var_no'),
                    ),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
            
            $automobile_opt_array = array(
              'name' => automobile_var_theme_text_srt('automobile_var_button_sc_border_color'),
              'desc' => '',
              'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_border_color_hint'),
              'echo' => true,
              'field_params' => array(
              'std' => esc_attr($automobile_var_button_border_color),
              'cust_id' => 'automobile_var_button_border_color' . $automobile_counter,
              'classes' => 'bg_color',
              'cust_name' => 'automobile_var_button_border_color[]',
              'return' => true,
              ),
              );
              $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_sc_button_bg_color'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_button_bg_color_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($automobile_var_button_bg_color),
                    'cust_id' => 'automobile_var_button_bg_color' . $automobile_counter,
                    'classes' => 'bg_color',
                    'cust_name' => 'automobile_var_button_bg_color[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_sc_button_color'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_button_color_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($automobile_var_button_color),
                    'cust_id' => 'automobile_var_button_color' . $automobile_counter,
                    'classes' => 'bg_color',
                    'cust_name' => 'automobile_var_button_color[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

          
            
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_size'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_size_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => $automobile_var_button_size,
                    'id' => '',
                    'cust_name' => 'automobile_var_button_size[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => array(
                        'btn-lg' => automobile_var_theme_text_srt('automobile_var_button_large'),
                        'medium-btn' => automobile_var_theme_text_srt('automobile_var_button_medium'),
                        'btn-sml' => automobile_var_theme_text_srt('automobile_var_button_small'),
                    ),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
            
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_icon_on_off'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_icon_on_off_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => $automobile_var_icon_view,
                    'id' => '',
                    'cust_id' => 'automobile_var_icon_view',
                    'cust_name' => 'automobile_var_icon_view[]',
                    'classes' => 'dropdown chosen-select-no-single select-medium',
                    'options' => array(
                        'on' => automobile_var_theme_text_srt('automobile_var_on'),
                        'off' => automobile_var_theme_text_srt('automobile_var_off'),
                    ),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
           
            ?>
            <style type="text/css">
                .icon_fields{ display: <?php echo esc_html($automobile_var_icon_view == 'off' ? 'none' : 'block') ?>; }
            </style>
            <script>
                $(function() {
                     $('#automobile_var_icon_view').change(function(){
                         var getValue = $("#automobile_var_icon_view option:selected").val();
                         if(getValue == 'on') {
                             $('.icon_fields').css('display','block');
                         } else {
                             $('.icon_fields').css('display','none');
                         } 
                     });
                 });

            </script>
            <div class="icon_fields">
                <div class="form-elements" id="automobile_button_<?php echo esc_attr($automobile_counter); ?>">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo automobile_var_theme_text_srt('automobile_var_button_icon'); ?></label>
                        <?php
                        if (function_exists('automobile_var_tooltip_helptext')) {
                            echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_button_icon_hint'));
                        }
                        ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo automobile_var_icomoon_icons_box(esc_html($automobile_button_icon), esc_attr($automobile_counter), 'automobile_button_icon'); ?>
                    </div>
                </div>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_theme_text_srt('automobile_var_button_sc_button_alignment'),
                    'desc' => '',
                    'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_button_alignment_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => $automobile_var_button_align,
                        'id' => '',
                        'cust_name' => 'automobile_var_button_align[]',
                        'classes' => 'dropdown chosen-select',
                        'options' => array(
                            'left' => automobile_var_theme_text_srt('automobile_var_button_sc_button_alignment_left'),
                            'right' => automobile_var_theme_text_srt('automobile_var_button_sc_button_alignment_right'),
                        ),
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                ?>
            </div>
            <?php    
            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_sc_button_type'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_button_type_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => $automobile_var_button_type,
                    'id' => '',
                    'cust_name' => 'automobile_var_button_type[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => array(
                        'square' => automobile_var_theme_text_srt('automobile_var_button_sc_button_type_square'),
                        'rounded' => automobile_var_theme_text_srt('automobile_var_button_sc_button_type_rounded'),
                    ),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_theme_text_srt('automobile_var_button_sc_target'),
                'desc' => '',
                'hint_text' => automobile_var_theme_text_srt('automobile_var_button_sc_target_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => $automobile_var_button_target,
                    'id' => '',
                    'cust_name' => 'automobile_var_button_target[]',
                    'classes' => 'dropdown chosen-select',
                    'options' => array(
                        '_blank' => automobile_var_theme_text_srt('automobile_var_button_sc_target_blank'),
                        '_self' => automobile_var_theme_text_srt('automobile_var_button_sc_target_self'),
                    ),
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
                            </ul>
                            <div id="results-shortocde"></div>
            <?php } else { ?>

                <?php
                $automobile_opt_array = array(
                    'std' => 'button',
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
                        'cust_id' => 'button_save' . $automobile_counter,
                        'cust_type' => 'button',
                        'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                        'classes' => 'cs-automobile-admin-btn',
                        'cust_name' => 'button_save',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            }
            ?>
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
            </div>
            <?php
        }
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_button', 'automobile_var_page_builder_button');
}
 