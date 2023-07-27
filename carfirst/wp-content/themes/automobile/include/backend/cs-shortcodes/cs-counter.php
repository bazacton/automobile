<?php
/*
 *
 * @Shortcode Name : multi_counter
 * @retrun
 *
 */
if (!function_exists('automobile_var_page_builder_counter')) {

    function automobile_var_page_builder_counter($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $multi_counter_num = 0;

        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $AUTOMOBILE_POSTID = '';
            $shortcode_element_id = '';
        } else {
            $AUTOMOBILE_POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $AUTOMOBILE_PREFIX = 'multi_counter|multi_counter_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
        }

        $defaults = array(
            'automobile_var_column_size' => '1/1',
            'automobile_multi_counter_title' => '',
            'automobile_multi_counter_sub_title' => '',
            'automobile_var_counter_col' => '',
            'automobile_var_icon_color' => '',
            'automobile_var_count_color' => '',
            'automobile_var_counters_view' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content'])) {
            $atts_content = $output['0']['content'];
        } else {
            $atts_content = array();
        }
        if (is_array($atts_content)) {
            $multi_counter_num = count($atts_content);
        }
        $multi_counter_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $automobile_multi_counter_title = isset($automobile_multi_counter_title) ? $automobile_multi_counter_title : '';
        $automobile_multi_counter_sub_title = isset($automobile_multi_counter_sub_title) ? $automobile_multi_counter_sub_title : '';

        $name = 'automobile_var_page_builder_counter';
        $coloumn_class = 'column_' . $multi_counter_element_size;
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
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="counter" data="<?php echo automobile_element_size_data_array_index($multi_counter_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $multi_counter_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_multi_counter_edit_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/multi_counter]" data-shortcode-child-template="[multiple_counter_item {{attributes}}] {{content}} [/multiple_counter_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[multi_counter {{attributes}}]">
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
                                        'std' => esc_attr($automobile_multi_counter_title),
                                        'cust_id' => '',
                                        'cust_name' => 'automobile_multi_counter_title[]',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_style'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_style_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_var_counters_view,
                                        'id' => '',
                                        'cust_name' => 'automobile_var_counters_view[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            'default' => automobile_var_theme_text_srt('automobile_var_default'),
                                        ),
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);


                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_sel_col'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_sel_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_var_counter_col,
                                        'id' => '',
                                        'cust_name' => 'automobile_var_counter_col[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            '1' => automobile_var_theme_text_srt('automobile_var_one_col'),
                                            '2' => automobile_var_theme_text_srt('automobile_var_two_col'),
                                            '3' => automobile_var_theme_text_srt('automobile_var_three_col'),
                                            '4' => automobile_var_theme_text_srt('automobile_var_four_col'),
                                            '6' => automobile_var_theme_text_srt('automobile_var_six_col'),
                                        ),
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);


                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_multiple_counter_icon_color'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_multiple_counter_icon_color_tooltip'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_var_icon_color),
                                        'cust_id' => 'automobile_var_icon_color',
                                        'classes' => 'bg_color',
                                        'cust_name' => 'automobile_var_icon_color[]',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_multiple_counter_count_color'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_multiple_counter_count_color_tooltip'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_var_count_color),
                                        'cust_id' => 'automobile_var_count_color',
                                        'classes' => 'bg_color',
                                        'cust_name' => 'automobile_var_count_color[]',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                ?>

                            </div>
                            <?php
                            if (isset($multi_counter_num) && $multi_counter_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $multi_counter) {
                                    $rand_string = rand(123456, 987654);
                                    $automobile_var_multi_counter_text = $multi_counter['content'];
                                    $defaults = array(
                                        'automobile_var_icon' => '',
                                        'automobile_var_title' => '',
                                        'automobile_var_count' => '',
                                       // 'automobile_var_content' => '',
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($multi_counter['atts'][$key])) {
                                            $$key = $multi_counter['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    $automobile_var_icon = isset($automobile_var_icon) ? $automobile_var_icon : '';
                                    $automobile_var_count = isset($automobile_var_count) ? $automobile_var_count : '';
                                   // $automobile_var_content = isset($automobile_var_content) ? $automobile_var_content : '';
                                    $automobile_var_content_color = isset($automobile_var_content_color) ? $automobile_var_content_color : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="automobile_multi_counter_<?php echo automobile_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_multiple_counter'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_remove'); ?></a>
                                        </header>
                                        <div class="form-elements" id="<?php echo esc_attr($rand_string); ?>">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <label><?php echo automobile_var_theme_text_srt('automobile_var_multiple_counter_icon'); ?></label>
                                                <?php
                                                if (function_exists('automobile_var_tooltip_helptext')) {
                                                    echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_multiple_counter_icon_tooltip'));
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                <?php echo automobile_var_icomoon_icons_box(esc_attr($automobile_var_icon), $rand_string, 'automobile_var_icon'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_multiple_counter_title'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_multiple_counter_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_title),
                                                'cust_id' => 'automobile_var_title',
                                                'classes' => '',
                                                'cust_name' => 'automobile_var_title[]',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_multiple_counter_count'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_multiple_counter_count_tooltip'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_count),
                                                'cust_id' => 'automobile_var_count',
                                                'classes' => '',
                                                'cust_name' => 'automobile_var_count[]',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);




                                        $automobile_opt_array = array(
                                            'name' => automobile_var_frame_text_srt('automobile_var_multiple_counter_content'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_frame_text_srt('automobile_var_multiple_counter_content_tooltip'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_multi_counter_text),
                                                'cust_id' => '',
                                                'cust_name' => 'automobile_var_multi_counter_text[]',
                                                'return' => true,
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'classes' => '',
                                                'automobile_editor' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
                                        ?>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="hidden-object">
                            <?php
                            $automobile_opt_array = array(
                                'std' => automobile_allow_special_char($multi_counter_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'multi_counter_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                            ?>

                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_counterss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('counter', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_add_counter'); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg noborder">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo automobile_allow_special_char($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                <?php } else { ?>


                                    <?php
                                    $automobile_opt_array = array(
                                        'std' => 'counter',
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => '',
                                        'extra_atr' => '',
                                        'cust_id' => 'automobile_orderby' . $automobile_counter,
                                        'cust_name' => 'automobile_orderby[]',
                                        'return' => false,
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
                                            'cust_id' => 'multi_counter_save' . $automobile_counter,
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-automobile-admin-btn',
                                            'cust_name' => 'multi_counter_save',
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
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

    add_action('wp_ajax_automobile_var_page_builder_counter', 'automobile_var_page_builder_counter');
}