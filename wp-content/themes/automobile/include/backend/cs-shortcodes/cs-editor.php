<?php
/*
 *
 * @File : Flex column
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_editor')) {

    function automobile_var_page_builder_editor($die = 0) {
        global $automobile_node, $post, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'automobile_editor';
        $counter = $_POST['counter'];
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_editor_title' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content'])) {
            $automobile_var_editor_content = $output['0']['content'];
        } else {
            $automobile_var_editor_content = '';
        }
        $editor_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key]))
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'automobile_var_page_builder_editor';
        $coloumn_class = 'column_' . $editor_element_size;
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
            <?php echo esc_attr($shortcode_view); ?>" item="editor" data="<?php echo automobile_element_size_data_array_index($editor_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $editor_element_size, '', 'columns', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?>
                 <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_editor {{attributes}}]{{content}}[/automobile_editor]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_editor_options'); ?></h5>
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
                        ?>
                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_element_title'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_element_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => automobile_allow_special_char($automobile_var_editor_title),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'automobile_var_editor_title[]',
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
                                'std' => esc_textarea($automobile_var_editor_content),
                                'cust_id' => '',
                                'classes' => 'textarea',
                                'cust_name' => 'automobile_var_editor_content[]',
                                'automobile_editor' => true,
                                'return' => true,
                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
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
                            'std' => 'editor',
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
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_editor', 'automobile_var_page_builder_editor');
}
 