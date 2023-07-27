<?php
/*
 *
 * @Shortcode Name : icon_box
 * @retrun
 *
 */
if (!function_exists('automobile_var_page_builder_icon_box')) {

    function automobile_var_page_builder_icon_box($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;


        $string = new automobile_theme_all_strings;
        $string->automobile_short_code_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $icon_boxes_num = 0;

        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $AUTOMOBILE_POSTID = '';
            $shortcode_element_id = '';
        } else {
            $AUTOMOBILE_POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $AUTOMOBILE_PREFIX = 'icon_box|icon_boxes_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
        }
        $defaults = array(
            'automobile_var_column_size' => '1/1',
            'automobile_var_icon_boxes_title' => '',
            'automobile_var_icon_boxes_sub_title' => '',
            'automobile_var_icon_box_content_align' => '',
            'automobile_var_icon_box_column' => '',
            'automobile_var_icon_box_view' => '',
            'automobile_title_color' => '',
            'automobile_icon_box_content_color' => '',
            'automobile_icon_box_icon_color' => '',
            'automobile_var_icon_box_icon_size' => '',
            'automobile_icon_box_content_align' => '',
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
            $icon_boxes_num = count($atts_content);
        }
        $icon_boxes_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $automobile_var_icon_boxes_title = isset($automobile_var_icon_boxes_title) ? $automobile_var_icon_boxes_title : '';
        $automobile_var_icon_boxes_sub_title = isset($automobile_var_icon_boxes_sub_title) ? $automobile_var_icon_boxes_sub_title : '';
        $automobile_var_icon_box_column = isset($automobile_var_icon_box_column) ? $automobile_var_icon_box_column : '';


        $name = 'automobile_var_page_builder_icon_box';
        $coloumn_class = 'column_' . $icon_boxes_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="icon_box" data="<?php echo automobile_element_size_data_array_index($icon_boxes_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $icon_boxes_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_icon_box_edit'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/icon_box]" data-shortcode-child-template="[icon_boxes_item {{attributes}}] {{content}} [/icon_boxes_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[icon_box {{attributes}}]">
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
                                        'std' => esc_attr($automobile_var_icon_boxes_title),
                                        'cust_id' => '',
                                        'cust_name' => 'automobile_var_icon_boxes_title[]',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                
                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_boxes_title_color'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_boxes_title_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($automobile_icon_box_content_color),
                                        'id' => 'automobile_icon_box_content_color',
                                        'cust_name' => 'automobile_icon_box_content_color[]',
                                        'classes' => 'bg_color',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_boxes_text'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_boxes_content_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_var_icon_boxes_sub_title),
                                        'cust_id' => '',
                                        'cust_name' => 'automobile_var_icon_boxes_sub_title[]',
                                        'return' => true,
                                        'classes' => '',
                                        'automobile_editor' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
                                
                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_box_styles'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_styles_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_var_icon_box_view,
                                        'id' => '',
                                        'cust_id' => 'automobile_var_icon_box_view',
                                        'cust_name' => 'automobile_var_icon_box_view[]',
                                        'classes' => 'automobile_var_icon_box_view chosen-select select-medium',
                                        'extra_atr' => ' onchange=automobile_icon_box_style_change(this.value)',
                                        'options' => array(
                                            'simple' => automobile_var_theme_text_srt('automobile_var_icon_box_style_simple'),
                                            'has-border' => automobile_var_theme_text_srt('automobile_var_icon_box_style_box'),
					    'classic' => automobile_var_theme_text_srt('automobile_var_icon_box_view_classic'),
                                        ),
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                                
                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_box_alignment'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_alignment_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_icon_box_content_align,
                                        'id' => '',
                                        'cust_name' => 'automobile_icon_box_content_align[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            'left' => automobile_var_theme_text_srt('automobile_var_icon_box_alignment_left'),
                                            'right' => automobile_var_theme_text_srt('automobile_var_icon_box_alignment_right'),
                                            'top-center' => automobile_var_theme_text_srt('automobile_var_icon_box_alignment_center'),
                                            'top-left' => automobile_var_theme_text_srt('automobile_var_icon_box_alignment_top_left'),
                                            'top-right' => automobile_var_theme_text_srt('automobile_var_icon_box_alignment_top_right'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                
                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_boxes_sel_col'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_boxes_sel_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($automobile_var_icon_box_column),
                                        'cust_id' => 'automobile_var_icon_box_column' . $automobile_counter,
                                        'cust_name' => 'automobile_var_icon_box_column[]',
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
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_box_title_color'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_title_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_title_color),
                                        'cust_id' => 'automobile_title_color',
                                        'classes' => 'bg_color',
                                        'cust_name' => 'automobile_title_color[]',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_boxes_Icon_color'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_boxes_Icon_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($automobile_icon_box_icon_color),
                                        'id' => 'automobile_icon_box_icon_color',
                                        'cust_name' => 'automobile_icon_box_icon_color[]',
                                        'classes' => 'bg_color',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_var_icon_box_icon_size,
                                        'id' => '',
                                        'cust_id' => 'automobile_var_icon_box_icon_size',
                                        'cust_name' => 'automobile_var_icon_box_icon_size[]',
                                        'classes' => 'icon_box_postion chosen-select-no-single select-medium',
                                        'options' => array(
                                            'icon-xs' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_option_1'),
                                            'icon-sm' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_option_2'),
                                            'icon-md' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_option_3'),
                                            'icon-ml' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_option_4'),
                                            'icon-lg' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_option_5'),
                                            'icon-xl' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_option_6'),
                                            'icon-xxl' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_font_size_option_7'),
                                        ),
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                                ?>
                            </div>
                            <?php
                            if (isset($icon_boxes_num) && $icon_boxes_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $icon_boxes) {
                                    $rand_string = rand(123456, 987654);
                                    $automobile_var_icon_boxes_text = $icon_boxes['content'];
                                    $defaults = array(
                                        'automobile_var_icon_box_title' => '',
                                        'automobile_var_icon_box_icon_size' => '',
                                        'automobile_var_icon_boxes_icon' => '',
                                        'automobile_var_link_url' => '',
                                        'automobile_var_icon_box_icon_type' => '',
                                        'automobile_var_icon_box_image' => ''
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($icon_boxes['atts'][$key])) {
                                            $$key = $icon_boxes['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }

                                    $automobile_var_icon_boxes_text = isset($automobile_var_icon_boxes_text) ? $automobile_var_icon_boxes_text : '';
                                    $automobile_var_icon_box_title = isset($automobile_var_icon_box_title) ? $automobile_var_icon_box_title : '';



                                    $automobile_var_icon_boxes_icon = isset($automobile_var_icon_boxes_icon) ? $automobile_var_icon_boxes_icon : '';
                                    $automobile_var_icon_box_icon_size = isset($automobile_var_icon_box_icon_size) ? $automobile_var_icon_box_icon_size : '';
                                    $automobile_var_icon_box_icon_color = isset($automobile_var_icon_box_icon_color) ? $automobile_var_icon_box_icon_color : '';
                                    $automobile_var_link_url = isset($automobile_var_link_url) ? $automobile_var_link_url : '';
                                    $automobile_var_icon_box_icon_type = isset($automobile_var_icon_box_icon_type) ? $automobile_var_icon_box_icon_type : '';
                                    $automobile_var_icon_box_image = isset($automobile_var_icon_box_image) ? $automobile_var_icon_box_image : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="automobile_infobox_<?php echo automobile_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_icon_boxes'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_tabs_remove'); ?></a>
                                        </header>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_icon_box_title'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => automobile_allow_special_char($automobile_var_icon_box_title),
                                                'cust_id' => 'automobile_var_icon_box_title',
                                                'classes' => '',
                                                'cust_name' => 'automobile_var_icon_box_title[]',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_icon_boxes_link_url'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_boxes_link_url_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_link_url),
                                                'cust_id' => 'automobile_var_link_url',
                                                'classes' => '',
                                                'cust_name' => 'automobile_var_link_url[]',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);




                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_type'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_type_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($automobile_var_icon_box_icon_type),
                                                'id' => 'automobile_var_icon_box_icon_type',
                                                'cust_name' => 'automobile_var_icon_box_icon_type[]',
                                                //'extra_atr' => ' onchange=automobile_icon_box_view_change(this.value)',
                                                'classes' => 'chosen-select-no-single select-medium function-class',
                                                'options' => array(
                                                    'icon' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_type_1'),
                                                    'image' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_type_2'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                        ?>	 				

                                        <div class="cs-sh-icon_box-image-area" style="display:<?php echo esc_html($automobile_var_icon_box_icon_type == 'image' ? 'block' : 'none') ?>;">
                                        <?php
                                        $automobile_opt_array = array(
                                            'std' => $automobile_var_icon_box_image,
                                            'id' => 'icon_box_image_array',
                                            'main_id' => 'icon_box_image_array',
                                            'name' => automobile_var_theme_text_srt('automobile_var_image_field'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_image_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'field_params' => array(
                                                'std' => $automobile_var_icon_box_image,
                                                'cust_id' => '',
                                                'cust_name' => 'automobile_var_icon_box_image[]',
                                                'id' => 'icon_box_image_array',
                                                'return' => true,
                                                'array' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);

                                        $rand_id = rand(1111111, 9999999);
                                        ?>
                                        </div>

                                        <div class="cs-sh-icon_box-icon-area" style="display:<?php echo esc_html($automobile_var_icon_box_icon_type != 'image' ? 'block' : 'none') ?>;">
                                            <div class="form-elements" id="automobile_infobox_<?php echo esc_attr($rand_id); ?>">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <label><?php echo automobile_var_theme_text_srt('automobile_var_icon_boxes_icon'); ?></label>
                <?php
                if (function_exists('automobile_var_tooltip_helptext')) {
                    echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_icon_boxes_icon_hint'));
                }
                ?>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <?php echo automobile_var_icomoon_icons_box($automobile_var_icon_boxes_icon, esc_attr($rand_id), 'automobile_var_icon_boxes_icon'); ?>
                                                </div>
                                            </div>

                                        </div>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_content'),
                    'desc' => '',
                    'hint_text' => automobile_var_theme_text_srt('automobile_var_icon_box_icon_content_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($automobile_var_icon_boxes_text),
                        'cust_id' => '',
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'cust_name' => 'automobile_var_icon_boxes_text[]',
                        'return' => true,
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
                            <script type="text/javascript">
                                jQuery('.function-class').change(function ($) {
                                    var value = jQuery(this).val();

                                    var parentNode = jQuery(this).parent().parent().parent();
                                    if (value == 'image') {
                                        //alert(parentNode);
                                        parentNode.find(".cs-sh-icon_box-image-area").show();
                                        parentNode.find(".cs-sh-icon_box-icon-area").hide();
                                        /*
                                         jQuery(".cs-sh-icon_box-image-area").show();
                                         jQuery(".cs-sh-icon_box-icon-area").hide();
                                         */
                                    } else {
                                        parentNode.find(".cs-sh-icon_box-image-area").hide();
                                        parentNode.find(".cs-sh-icon_box-icon-area").show();
                                        /*
                                         jQuery(".cs-sh-icon_box-image-area").hide();
                                         jQuery(".cs-sh-icon_box-icon-area").show();
                                         */
                                    }

                                }
                                );
                            </script>
                        </div>
                        <div class="hidden-object">
        <?php
        $automobile_opt_array = array(
            'std' => automobile_allow_special_char($icon_boxes_num),
            'id' => '',
            'before' => '',
            'after' => '',
            'classes' => 'fieldCounter',
            'extra_atr' => '',
            'cust_id' => '',
            'cust_name' => 'icon_boxes_num[]',
            'return' => false,
            'required' => false
        );
        $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
        ?>

                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_icon_boxesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('icon_box', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_icon_box_add'); ?></a> </li>
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
                'std' => 'icon_box',
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
                    'cust_id' => 'icon_boxes_save' . $automobile_counter,
                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                    'cust_type' => 'button',
                    'classes' => 'cs-automobile-admin-btn',
                    'cust_name' => 'icon_boxes_save',
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

    add_action('wp_ajax_automobile_var_page_builder_icon_box', 'automobile_var_page_builder_icon_box');
}