<?php
/*
 *
 * @Shortcode Name : Table
 * @retrun
 *
 */
if (!function_exists('automobile_var_page_builder_table')) {

    function automobile_var_page_builder_table($die = 0) {
        global $automobile_node, $automobile_count_node, $post, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'automobile_table';
        $defaultAttributes = false;
        $parseObject = new ShortcodeParse();
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
            $defaultAttributes = true;
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array('automobile_var_column_size' => '1/2', 'automobile_table_element_title' => '', 'automobile_table_content' => '', 'automobile_table_class' => '');
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $atts_content = '[table]
                            [thead]
                              [tr]
                                [th]Column 1[/th]
                                [th]Column 2[/th]
                                [th]Column 3[/th]
                                [th]Column 4[/th]
                              [/tr]
                            [/thead]
                            [tbody]
                              [tr]
                                [td]Item 1[/td]
                                [td]Item 2[/td]
                                [td]Item 3[/td]
                                [td]Item 4[/td]
                              [/tr]
                              [tr]
                                [td]Item 11[/td]
                                [td]Item 22[/td]
                                [td]Item 33[/td]
                                [td]Item 44[/td]
                              [/tr]
                            [/tbody]
                        [/table]';

        if ($defaultAttributes) {
            $atts_content = $atts_content;
        } else {
            if (isset($output['0']['content'])) {
                $atts_content = $output['0']['content'];
            } else {
                $atts_content = "";
            }
        }
        $table_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_table';
        $automobile_count_node++;
        $coloumn_class = 'column_' . $table_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="table" data="<?php echo automobile_element_size_data_array_index($table_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $table_element_size, '', 'th'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>"  data-shortcode-template="[automobile_table {{attributes}}] {{content}} [/automobile_table]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_table_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_attr($name . $automobile_counter) ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
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
                                'std' => automobile_allow_special_char($automobile_table_element_title),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_table_element_title[]',
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        ?>
                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_table_content'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_table_content_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_textarea($atts_content),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'automobile_table_content[]',
                                'return' => true,
                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
                        ?>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg noborder cs-insert-noborder">
                                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_page_builder_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>
                            <?php
                            $automobile_opt_array = array(
                                'std' => 'table',
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
                                    'classes' => 'cs-admin-btn',
                                    'cust_name' => '',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            ?>   
                        <?php } ?>
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
        </div>
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_table', 'automobile_var_page_builder_table');
}
?>
