<?php
/**
 * @Spacer html form for page builder
 */
if (!function_exists('automobile_var_page_builder_spacer')) {

    function automobile_var_page_builder_spacer($die = 0) {
        global $automobile_node, $count_node, $post, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;
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
            $AUTOMOBILE_PREFIX = 'spacer';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
        }
        $defaults = array('automobile_var_spacer_height' => '25');
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $spacer_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_spacer';
        $coloumn_class = 'column_' . $spacer_element_size;
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
             <?php echo esc_attr($shortcode_view); ?>" item="spacer" data="<?php echo automobile_element_size_data_array_index($spacer_element_size) ?>" >
                 <?php automobile_element_setting($name, $automobile_counter, $spacer_element_size) ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[spacer {{attributes}}]{{content}}[/spacer]" style="display: none;"">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_edit_spacer_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">

                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_spacer_height'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_spacer_height_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($automobile_var_spacer_height),
                                'id' => 'spacer_height',
                                'cust_name' => 'automobile_var_spacer_height[]',
                                'return' => true,
                                'cs-range-input' => 'cs-range-input',
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
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
                            'std' => 'spacer',
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

    add_action('wp_ajax_automobile_var_page_builder_spacer', 'automobile_var_page_builder_spacer');
}
 