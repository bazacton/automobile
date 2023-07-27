<?php
/* *
 * @Shortcode Name : Heading
 * @retrun
 * */
if (!function_exists('automobile_var_page_builder_heading')) {

    function automobile_var_page_builder_heading($die = 0) {
        global $automobile_node, $post, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;
        ;
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
            $PREFIX = 'automobile_heading';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'heading_title' => '',
            'color_title' => '',
            'heading_color' => '#000',
            'class' => 'cs-heading-shortcode',
            'heading_style' => '1',
            'heading_style_type' => '1',
            'heading_size' => '',
            'font_weight' => '',
            'letter_space' => '',
            'line_height' => '',
            'heading_font_style' => '',
            'heading_align' => 'center',
            'heading_divider' => '',
            'heading_color' => '',
            'sub_heading_title' => '',
            'heading_content_color' => ''
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content'])) {
            $heading_content = $output['0']['content'];
        } else {
            $heading_content = '';
        }
        $heading_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key]))
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'automobile_var_page_builder_heading';
        $coloumn_class = 'column_' . $heading_element_size;

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="heading" data="<?php echo automobile_element_size_data_array_index($heading_element_size) ?>" >
        <?php automobile_element_setting($name, $automobile_counter, $heading_element_size, '', 'h-square', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>"  data-shortcode-template="[automobile_heading {{attributes}}]{{content}}[/automobile_heading]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_heading_edit_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter) ?>','<?php echo esc_js($filter_element); ?>')"
                       class="cs-btnclose"><i class="icon-times"></i>
                    </a>
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            automobile_shortcode_element_size();
                        }

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_heading_sc_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_heading_sc_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_allow_special_char($heading_title),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'heading_title[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_heading_sc_content'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_heading_sc_content_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_textarea($heading_content),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'heading_content[]',
                                'return' => true,
                                'automobile_editor' => true,
                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_heading_sc_type'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_heading_sc_type_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $heading_style,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'heading_style[]',
                                'classes' => 'chosen-select select-medium',
                                'options' => array(
                                    '1' => automobile_var_theme_text_srt('automobile_var_heading_sc_h1'),
                                    '2' => automobile_var_theme_text_srt('automobile_var_heading_sc_h2'),
                                    '3' => automobile_var_theme_text_srt('automobile_var_heading_sc_h3'),
                                    '4' => automobile_var_theme_text_srt('automobile_var_heading_sc_h4'),
                                    '5' => automobile_var_theme_text_srt('automobile_var_heading_sc_h5'),
                                    '6' => automobile_var_theme_text_srt('automobile_var_heading_sc_h6'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        ?>

                        <div class="form-elements">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label><?php echo automobile_var_theme_text_srt('automobile_var_heading_sc_font_size'); ?></label>
                                <?php
                                if (function_exists('automobile_var_tooltip_helptext')) {
                                    echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_heading_sc_font_size_hint'));
                                }
                                ?>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <?php
                                $automobile_opt_array = array(
                                    'std' => esc_attr($heading_size),
                                    'id' => '',
                                    'classes' => 'cs-range-input input-small',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'heading_size[]',
                                    'extra_atr' => ' placeholder="' . automobile_var_theme_text_srt('automobile_var_heading_sc_font_size') . '"',
                                    'return' => true,
                                    'required' => false,
                                    'rang' => true,
                                    'min' => 0,
                                    'max' => 50,
                                );
                                echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array));
                                ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label><?php echo automobile_var_theme_text_srt('automobile_var_heading_sc_letter_spacing'); ?></label>
                                <?php
                                if (function_exists('automobile_var_tooltip_helptext')) {
                                    echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_heading_sc_letter_spacing_hint'));
                                }
                                ?>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                                <?php
                                $automobile_opt_array = array(
                                    'std' => esc_attr($letter_space),
                                    'id' => '',
                                    'classes' => 'cs-range-input input-small',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'letter_space[]',
                                    'extra_atr' => ' placeholder="' . automobile_var_theme_text_srt('automobile_var_heading_sc_letter_spacing') . '"',
                                    'return' => true,
                                    'required' => false,
                                    'rang' => true,
                                    'min' => 0,
                                    'max' => 50,
                                );
                                echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array));
                                ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label><?php echo automobile_var_theme_text_srt('automobile_var_heading_sc_line_height'); ?></label>
                                <?php
                                if (function_exists('automobile_var_tooltip_helptext')) {
                                    echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_heading_sc_line_height_hint'));
                                }
                                ?>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <?php
                                $automobile_opt_array = array(
                                    'std' => esc_attr($line_height),
                                    'id' => '',
                                    'classes' => 'cs-range-input input-small',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'line_height[]',
                                    'extra_atr' => ' placeholder="' . automobile_var_theme_text_srt('automobile_var_heading_sc_line_height') . '"',
                                    'return' => true,
                                    'required' => false,
                                    'rang' => true,
                                    'min' => 0,
                                    'max' => 50,
                                );
                                echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array));
                                ?>
                            </div>
                        </div>


                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_heading_sc_heading_align'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_heading_sc_heading_align_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $heading_align,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'heading_align[]',
                                'classes' => 'chosen-select select-medium',
                                'options' => array(
                                    'left' => automobile_var_theme_text_srt('automobile_var_heading_sc_left'),
                                    'right' => automobile_var_theme_text_srt('automobile_var_heading_sc_right'),
                                    'Center' => automobile_var_theme_text_srt('automobile_var_heading_sc_center'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_heading_color'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_heading_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_allow_special_char($heading_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'heading_color[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_heading_sc_divider'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_heading_sc_divider_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $heading_divider,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'heading_divider[]',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'options' => array(
                                    'on' => automobile_var_theme_text_srt('automobile_var_on'),
                                    'off' => automobile_var_theme_text_srt('automobile_var_off'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_heading_sc_font_style'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_heading_sc_font_style_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $heading_font_style,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'heading_font_style[]',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'options' => array(
                                    'normal' => automobile_var_theme_text_srt('automobile_var_heading_sc_normal'),
                                    'italic' => automobile_var_theme_text_srt('automobile_var_heading_sc_italic'),
                                    'oblique' => automobile_var_theme_text_srt('automobile_var_heading_sc_oblique'),
                                ),
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        ?>

                    </div>
        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                        <?php
                    } else {
                        $automobile_opt_array = array(
                            'std' => 'heading',
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
                        echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));

                        $automobile_opt_array = array(
                            'name' => '',
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_var_theme_text_srt('automobile_var_save'),
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
                    <script>
                        /* modern selection box function */
                        jQuery(document).ready(function ($) {
                            chosen_selectionbox();
                            popup_over();
                        });
                        /* modern selection box function */
                    </script>
                </div>
            </div>
        </div>
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_heading', 'automobile_var_page_builder_heading');
}