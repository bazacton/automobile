<?php
/*
 *
 * @Shortcode Name : Button
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_accordion')) {

    function automobile_var_page_builder_accordion($die = 0) {
        global $automobile_node, $count_node, $post, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_static_text;


        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $PREFIX = 'automobile_accordion|accordion_item';
        $parseObject = new ShortcodeParse();
        $accordion_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }

        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_accordion_view' => '',
            'class' => 'cs-accrodian',
            'accordian_style' => '',
            'automobile_var_accordian_sub_title' => '',
            'accordion_animation' => '',
            'automobile_var_accordion_icon' => '',
            'automobile_var_accordian_main_title' => '',
            'automobile_var_accordion_column' => ''
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
            $accordion_num = count($atts_content);
        }
        $accordion_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $name = 'automobile_var_page_builder_accordion';
        $coloumn_class = 'column_' . $accordion_element_size;

        $automobile_var_accordion_view = isset($automobile_var_accordion_view) ? $automobile_var_accordion_view : '';
        $automobile_var_accordian_main_title = isset($automobile_var_accordian_main_title) ? $automobile_var_accordian_main_title : '';
        $automobile_var_accordian_sub_title = isset($automobile_var_accordian_sub_title) ? $automobile_var_accordian_sub_title : '';
        $automobile_var_accordion_column = isset($automobile_var_accordion_column) ? $automobile_var_accordion_column : '';
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="accordion" data="<?php echo automobile_element_size_data_array_index($accordion_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $accordion_element_size, '', 'list-ul'); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" data-shortcode-template="[<?php echo esc_attr(AUTOMOBILE_SC_ACCORDION); ?> {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_accordion_edit_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}}[/<?php echo esc_attr('automobile_accordion'); ?>]" data-shortcode-child-template="[<?php echo esc_attr('accordion_item'); ?> {{attributes}}] {{content}} [/<?php echo esc_attr('accordion_item'); ?>]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr('automobile_accordion'); ?> {{attributes}}]">
                                <?php
                                ?>
                                <?php
                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => automobile_allow_special_char($automobile_var_accordian_main_title),
                                        'id' => 'automobile_var_accordian_main_title',
                                        'cust_name' => 'automobile_var_accordian_main_title[]',
                                        'classes' => '',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                ?>

                                <?php
                                if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                    automobile_shortcode_element_size();
                                }

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_accordion_views'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_accordion_view_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_var_accordion_view,
                                        'id' => '',
                                        'cust_id' => 'automobile_var_accordion_view',
                                        'cust_name' => 'automobile_var_accordion_view[]',
                                        'classes' => 'service_postion chosen-select-no-single select-medium',
                                        'options' => array(
                                            'simple' => automobile_var_theme_text_srt('automobile_var_accordion_simple'),
                                            'modern' => automobile_var_theme_text_srt('automobile_var_accordion_modern'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                ?>

                            </div>
                            <?php
                            if (isset($accordion_num) && $accordion_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $accordion) {

                                    $rand_id = rand(3333, 99999);
                                    $automobile_var_accordion_text = $accordion['content'];
                                    $defaults = array('automobile_var_accordion_title' => 'Title', 'automobile_var_accordion_active' => 'yes', 'automobile_var_icon_box' => '');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($accordion['atts'][$key]))
                                            $$key = $accordion['atts'][$key];
                                        else
                                            $$key = $values;
                                    }

                                    $automobile_var_accordion_active = isset($automobile_var_accordion_active) ? $automobile_var_accordion_active : '';
                                    $automobile_var_accordion_title = isset($automobile_var_accordion_title) ? $automobile_var_accordion_title : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="automobile_infobox_<?php echo automobile_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_accordion'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_remove'); ?></a></header>


                                        <div class="form-elements" id="automobile_infobox_<?php echo esc_attr($rand_id); ?>">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <label><?php echo automobile_var_theme_text_srt('automobile_var_icon'); ?></label>
                                                <?php
                                                if (function_exists('automobile_var_tooltip_helptext')) {
                                                    echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_icon_hint'));
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                <?php echo automobile_var_icomoon_icons_box($automobile_var_icon_box, esc_attr($rand_id), 'automobile_var_icon_box'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_accordian_active'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_accordian_active_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $automobile_var_accordion_active,
                                                'id' => '',
                                                'cust_name' => 'automobile_var_accordion_active[]',
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
                                            'name' => automobile_var_theme_text_srt('automobile_var_accordian_title'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_accordian_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => automobile_allow_special_char($automobile_var_accordion_title),
                                                'id' => 'accordion_title',
                                                'cust_name' => 'automobile_var_accordion_title[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_accordian_descr'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_accordian_descr_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => automobile_allow_special_char($automobile_var_accordion_text),
                                                'id' => 'automobile_var_accordion_text',
                                                'cust_name' => 'automobile_var_accordion_text[]',
                                                'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                                'classes' => '',
                                                'return' => true,
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
                                'std' => $accordion_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'accordion_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('accordion', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo automobile_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_accordian_add_accordian'); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_page_builder_', '', $name)); ?>', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo automobile_allow_special_char($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                <?php } else { ?>

                                    <?php
                                    $automobile_opt_array = array(
                                        'std' => 'accordion',
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
                                    $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
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

    add_action('wp_ajax_automobile_var_page_builder_accordion', 'automobile_var_page_builder_accordion');
}
