<?php
/*
 *
 * @Shortcode Name : Testimonial
 * @retrun
 *
 */
if (!function_exists('automobile_var_page_builder_testimonial')) {

    function automobile_var_page_builder_testimonial($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $testimonial_num = 0;


        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $AUTOMOBILE_POSTID = '';
            $shortcode_element_id = '';
        } else {
            $AUTOMOBILE_POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $AUTOMOBILE_PREFIX = 'automobile_testimonial|testimonial_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
        }
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_testimonial_title' => '',
            'automobile_testimonial_class' => '',
            'automobile_var_testimonial_sub_title' => '',
            'automobile_var_author_color' => '',
            'automobile_var_position_color' => ''
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
            $testimonial_num = count($atts_content);
        }
        $testimonial_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $automobile_var_testimonial_title = isset($automobile_var_testimonial_title) ? $automobile_var_testimonial_title : '';
        $automobile_var_testimonial_content = isset($automobile_var_testimonial_content) ? $automobile_var_testimonial_content : '';
        $automobile_var_testimonial_sub_title = isset($automobile_var_testimonial_sub_title) ? $automobile_var_testimonial_sub_title : '';
        $automobile_var_author_color = isset($automobile_var_author_color) ? $automobile_var_author_color : '';
        $automobile_var_position_color = isset($automobile_var_position_color) ? $automobile_var_position_color : '';
        $name = 'automobile_var_page_builder_testimonial';
        $coloumn_class = 'column_' . $testimonial_element_size;
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
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="testimonial" data="<?php echo automobile_element_size_data_array_index($testimonial_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $testimonial_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_testimonial_edit'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/automobile_testimonial]" data-shortcode-child-template="[testimonial_item {{attributes}}] {{content}} [/testimonial_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[automobile_testimonial {{attributes}}]">
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
                                        'std' => esc_attr($automobile_var_testimonial_title),
                                        'cust_id' => '',
                                        'cust_name' => 'automobile_var_testimonial_title[]',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                
                                 $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_testimonial_author_color'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_var_author_color),
                                        'cust_id' => 'automobile_var_author_color' . $automobile_counter,
                                        'classes' => 'bg_color',
                                        'cust_name' => 'automobile_var_author_color[]',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_testimonial_position_color'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_var_position_color),
                                        'cust_id' => 'automobile_var_position_color' . $automobile_counter,
                                        'classes' => 'bg_color',
                                        'cust_name' => 'automobile_var_position_color[]',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                
                                ?>

                            </div>
                            <?php
                            if (isset($testimonial_num) && $testimonial_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $testimonial) {
                                    $rand_string = rand(123456, 987654);
                                    $automobile_var_testimonial_content = $testimonial['content'];
                                    $defaults = array('automobile_var_testimonial_author' => '', 'automobile_var_testimonial_author_image_array' => '', 'automobile_var_testimonial_position' => '');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($testimonial['atts'][$key])) {
                                            $$key = $testimonial['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    $automobile_var_testimonial_author = isset($automobile_var_testimonial_author) ? $automobile_var_testimonial_author : '';
                                    $automobile_var_testimonial_position = isset($automobile_var_testimonial_position) ? $automobile_var_testimonial_position : '';
                                    $automobile_var_testimonial_author_image_array = isset($automobile_var_testimonial_author_image_array) ? $automobile_var_testimonial_author_image_array : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="automobile_infobox_<?php echo automobile_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_testimonial'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_tabs_remove'); ?></a>
                                        </header>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_testimonial_field_text'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_testimonial_field_text_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_testimonial_content),
                                                'cust_id' => '',
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'cust_name' => 'automobile_var_testimonial_content[]',
                                                'return' => true,
                                                'classes' => '',
                                                'automobile_editor' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

                                       

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_testimonial_field_author'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_testimonial_field_author_hint'),
                                            'echo' => true,
                                            'classes' => 'txtfield',
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_testimonial_author),
                                                'cust_id' => '',
                                                'cust_name' => 'automobile_var_testimonial_author[]',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_testimonial_field_position'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_testimonial_field_position_hint'),
                                            'echo' => true,
                                            'classes' => 'txtfield',
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_testimonial_position),
                                                'cust_id' => '',
                                                'cust_name' => 'automobile_var_testimonial_position[]',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);



                                        $automobile_opt_array = array(
                                            'std' => esc_url($automobile_var_testimonial_author_image_array),
                                            'id' => 'testimonial_author_image',
                                            'name' => automobile_var_theme_text_srt('automobile_var_testimonial_field_image'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_testimonial_field_image_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'prefix' => '',
                                            'field_params' => array(
                                                'std' => esc_url($automobile_var_testimonial_author_image_array),
                                                'id' => 'testimonial_author_image',
                                                'return' => true,
                                                'array' => true,
                                                'array_txt' => false,
                                                'prefix' => '',
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);
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
                                'std' => automobile_allow_special_char($testimonial_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'testimonial_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                            ?>

                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('testimonial', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_add_testimonial'); ?></a> </li>
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
                                        'std' => 'testimonial',
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
                                            'cust_id' => 'testimonial_save' . $automobile_counter,
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-automobile-admin-btn',
                                            'cust_name' => 'testimonial_save',
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                }
                                ?>
                                <script>
                                    /* modern selection box and help hover text function */
                                    jQuery(document).ready(function ($) {
                                        chosen_selectionbox();
                                        popup_over();
                                    });
                                    /* end modern selection box and help hover text function */
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_testimonial', 'automobile_var_page_builder_testimonial');
}