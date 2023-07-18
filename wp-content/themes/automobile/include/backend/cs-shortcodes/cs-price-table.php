<?php
/*
 *
 * @Shortcode Name : Price Plan
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_price_table')) {

    function automobile_var_page_builder_price_table($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $price_table_num = 0;

        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $AUTOMOBILE_POSTID = '';
            $shortcode_element_id = '';
        } else {
            $AUTOMOBILE_POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $AUTOMOBILE_PREFIX = 'automobile_price_table|price_table_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
        }
        $defaults = array(
            'column_size' => '1/1',
            'automobile_multi_price_table_section_title' => '',
            'price_table_style' => '',
            'automobile_multi_price_col' => '',
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
            $price_table_num = count($atts_content);
        }
        $price_table_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_price_table';
        $coloumn_class = 'column_' . $price_table_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        ?>
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="price_table" data="<?php echo automobile_element_size_data_array_index($price_table_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $price_table_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_price_table_edit_option'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/automobile_price_table]" data-shortcode-child-template="[price_table_item {{attributes}}] {{content}} [/price_table_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[automobile_price_table {{attributes}}]">
                                <?php
                                if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                    automobile_shortcode_element_size();
                                }
                                $automobile_price_table_style = isset($automobile_price_table_style) ? $automobile_price_table_style : '';

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_multi_price_table_section_title),
                                        'id' => 'automobile_multi_price_table_section_title',
                                        'cust_name' => 'automobile_multi_price_table_section_title[]',
                                        'classes' => '',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_price_plan_style'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_price_plan_style_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $price_table_style,
                                        'id' => '',
                                        'cust_name' => 'price_table_style[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            'simple' => automobile_var_theme_text_srt('automobile_var_price_plan_style_simple'),
                                            'classic' => automobile_var_theme_text_srt('automobile_var_price_plan_style_classic'),
                                        ),
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                ?>
                                <?php
                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_accordian_select_col'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_accordian_select_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($automobile_multi_price_col),
                                        'cust_id' => 'automobile_multi_price_col',
                                        'cust_name' => 'automobile_multi_price_col[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            '1' => automobile_var_theme_text_srt('automobile_var_accordian_one_column'),
                                            '2' => automobile_var_theme_text_srt('automobile_var_accordian_two_column'),
                                            '3' => automobile_var_theme_text_srt('automobile_var_accordian_three_column'),
                                            '4' => automobile_var_theme_text_srt('automobile_var_accordian_four_column'),
                                            '6' => automobile_var_theme_text_srt('automobile_var_accordian_six_column'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                ?>

                            </div>
                            <?php
                            if (isset($price_table_num) && $price_table_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $price_table) {
                                    $rand_string = rand(1234, 7894563);
                                    $automobile_var_price_table_text = $price_table['content'];

                                    $defaults = array(
                                        'multi_pricetable_price' => '',
                                        'multi_price_table_text' => '',
                                        'multi_price_table_title_color' => '',
                                        'multi_price_table_currency' => '$',
                                        'multi_price_table_time_duration' => '',
                                        'multi_price_table_button_text' => 'Sign Up',
                                        'pricing_detail' => '',
                                        'pricetable_featured' => '',
                                        'multi_price_table_button_color' => '',
                                        'multi_price_table_button_color_bg' => '',
                                        'multi_price_table_button_column_color' => '',
                                        'multi_price_table_column_bgcolor' => '',
                                        'button_link' => ''
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($price_table['atts'][$key])) {
                                            $$key = $price_table['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="automobile_infobox_<?php echo automobile_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_price_table_sc'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_remove'); ?></a>
                                        </header>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_title'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($multi_price_table_text),
                                                'id' => 'multi_price_table_text',
                                                'cust_name' => 'multi_price_table_text[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_title_color'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_title_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($multi_price_table_title_color),
                                                'id' => 'multi_price_table_title_color',
                                                'cust_name' => 'multi_price_table_title_color[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_price'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_price_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($multi_pricetable_price),
                                                'id' => 'multi_pricetable_price',
                                                'cust_name' => 'multi_pricetable_price[]',
                                                'classes' => 'txtfield',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_currency'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_currency_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($multi_price_table_currency),
                                                'id' => 'multi_price_table_currency',
                                                'cust_name' => 'multi_price_table_currency[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_time'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_time_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($multi_price_table_time_duration),
                                                'id' => 'multi_price_table_time_duration',
                                                'cust_name' => 'multi_price_table_time_duration[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_button_link'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_button_link_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_url($button_link),
                                                'id' => 'button_link',
                                                'cust_name' => 'button_link[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_button_text'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_button_text_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($multi_price_table_button_text),
                                                'id' => 'multi_price_table_button_text',
                                                'cust_name' => 'multi_price_table_button_text[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_button_color'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_button_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($multi_price_table_button_color),
                                                'id' => 'multi_price_table_button_color',
                                                'cust_name' => 'multi_price_table_button_color[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_button_bg_color'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_button_bg_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($multi_price_table_button_color_bg),
                                                'id' => 'multi_price_table_button_color_bg',
                                                'cust_name' => 'multi_price_table_button_color_bg[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);



                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_featured'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_featured_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $pricetable_featured,
                                                'id' => '',
                                                'cust_name' => 'pricetable_featured[]',
                                                'classes' => 'dropdown chosen-select',
                                                'options' => array(
                                                    'Yes' => automobile_var_theme_text_srt('automobile_var_yes'),
                                                    'No' => automobile_var_theme_text_srt('automobile_var_no'),
                                                ),
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_frame_text_srt('automobile_var_price_table_description'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_description_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_price_table_text),
                                                'cust_id' => '',
                                                'cust_name' => 'automobile_var_price_table_text[]',
                                                'return' => true,
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'classes' => '',
                                                'automobile_editor' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);


                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_price_table_column_color'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_price_table_column_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($multi_price_table_column_bgcolor),
                                                'id' => 'multi_price_table_column_bgcolor',
                                                'cust_name' => 'multi_price_table_column_bgcolor[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
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
                                'std' => automobile_allow_special_char($price_table_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'price_table_num[]',
                                'return' => true,
                                'required' => false
                            );
                            echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));
                            ?>

                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('price_table', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_price_table_add'); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg noborder">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo automobile_allow_special_char($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                    <?php
                                } else {
                                    $automobile_opt_array = array(
                                        'std' => 'price_table',
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => '',
                                        'extra_atr' => '',
                                        'cust_id' => 'automobile_orderby' . $automobile_counter,
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
                                            'cust_id' => 'price_table_save' . $automobile_counter,
                                            'cust_type' => 'button',
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'classes' => 'cs-automobile-admin-btn',
                                            'cust_name' => 'price_table_save',
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
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_price_table', 'automobile_var_page_builder_price_table');
}