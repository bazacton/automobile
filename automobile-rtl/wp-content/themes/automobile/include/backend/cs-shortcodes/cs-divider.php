<?php
/**
 * @Divider html form for page builder
 */
if (!function_exists('automobile_var_page_builder_divider')) {

    function automobile_var_page_builder_divider($die = 0) {
        global $automobile_node, $count_node, $post, $automobile_var_html_fields, $automobile_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $AUTOMOBILE_PREFIX = 'automobile_divider';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
        }
        $defaults = array(
            'automobile_var_divider_padding_left' => '0',
            'automobile_var_divider_padding_right' => '0',
            'automobile_var_divider_margin_top' => '0',
            'automobile_var_divider_margin_buttom' => '0',
			'automobile_var_divider_views' => '0',
            'automobile_var_divider_align' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
		
        $divider_element_size = '100';
		
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_divider';
        $coloumn_class = 'column_' . $divider_element_size;
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
        <div id="<?php echo esc_attr($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
        <?php echo esc_attr($shortcode_view); ?>" item="divider" data="<?php echo automobile_element_size_data_array_index($divider_element_size) ?>" >
             <?php automobile_element_setting($name, $automobile_counter, $divider_element_size) ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_divider {{attributes}}]{{content}}[/automobile_divider]" style="display: none;"">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_divider_edit'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">

        <?php
        $automobile_opt_array = array(
            'name' => automobile_var_theme_text_srt('automobile_var_divider_field_left_padding'),
            'desc' => '',
            'hint_text' => automobile_var_theme_text_srt('automobile_var_divider_field_left_padding_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => esc_html($automobile_var_divider_padding_left),
                'id' => 'divider_height',
                'cust_name' => 'automobile_var_divider_padding_left[]',
                'return' => true,
                'cs-range-input' => 'cs-range-input',
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
        $automobile_opt_array = array(
            'name' => automobile_var_theme_text_srt('automobile_var_divider_field_right_padding'),
            'desc' => '',
            'hint_text' => automobile_var_theme_text_srt('automobile_var_divider_field_right_padding_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => esc_html($automobile_var_divider_padding_right),
                'id' => 'divider_height',
                'cust_name' => 'automobile_var_divider_padding_right[]',
                'return' => true,
                'cs-range-input' => 'cs-range-input',
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
        $automobile_opt_array = array(
            'name' => automobile_var_theme_text_srt('automobile_var_divider_field_top_margin'),
            'desc' => '',
            'hint_text' => automobile_var_theme_text_srt('automobile_var_divider_field_top_margin_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => esc_html($automobile_var_divider_margin_top),
                'id' => 'divider_height',
                'cust_name' => 'automobile_var_divider_margin_top[]',
                'return' => true,
                'cs-range-input' => 'cs-range-input',
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
        $automobile_opt_array = array(
            'name' => automobile_var_theme_text_srt('automobile_var_divider_field_bottom_margin'),
            'desc' => '',
            'hint_text' => automobile_var_theme_text_srt('automobile_var_divider_field_bottom_margin_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => esc_html($automobile_var_divider_margin_buttom),
                'id' => 'divider_height',
                'cust_name' => 'automobile_var_divider_margin_buttom[]',
                'return' => true,
                'cs-range-input' => 'cs-range-input',
            ),
        );
        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

		$automobile_opt_array = array(
            'name' => automobile_var_theme_text_srt('automobile_var_divider_field_align'),
            'desc' => '',
            'hint_text' => automobile_var_theme_text_srt('automobile_var_divider_field_align_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => $automobile_var_divider_align,
                'id' => '',
                'cust_name' => 'automobile_var_divider_align[]',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'center' => automobile_var_theme_text_srt('automobile_var_heading_sc_center'),
                    'left' => automobile_var_theme_text_srt('automobile_var_heading_sc_left'),
                    'right' => automobile_var_theme_text_srt('automobile_var_heading_sc_right'),
                ),
                'return' => true,
            ),
        );
        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
				
		$automobile_opt_array = array(
            'name' => automobile_var_theme_text_srt('automobile_var_divider_field_views'),
            'desc' => '',
            'hint_text' => automobile_var_theme_text_srt('automobile_var_divider_field_views_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => $automobile_var_divider_views,
                'id' => '',
                'cust_name' => 'automobile_var_divider_views[]',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'modern' => automobile_var_theme_text_srt('automobile_var_heading_sc_modern'),
                    'classic' => automobile_var_theme_text_srt('automobile_var_heading_sc_classic'),
                    'fancy' => automobile_var_theme_text_srt('automobile_var_heading_sc_fancy'),
                ),
                'return' => true,
            ),
        );
        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);		
        ?>

                    </div>
        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_page_builder_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
        <?php } else { ?>
                        <?php
                        $automobile_opt_array = array(
                            'std' => 'divider',
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'classes' => '',
                            'extra_atr' => '',
                            'cust_id' => '',
                            'cust_name' => 'automobile_orderby[]',
                            'return' => false,
                            'required' => false
                        );
                        $automobile_var_html_fields->automobile_var_form_hidden_render($automobile_opt_array);

                        $automobile_opt_array = array(
                            'name' => '',
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_var_theme_text_srt('automobile_var_save'),
                                'cust_id' => '',
                                'cust_type' => 'button',
                                'classes' => 'cs-automobile-admin-btn',
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

    add_action('wp_ajax_automobile_var_page_builder_divider', 'automobile_var_page_builder_divider');
}
 