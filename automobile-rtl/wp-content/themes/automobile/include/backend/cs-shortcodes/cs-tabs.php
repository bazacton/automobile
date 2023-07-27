<?php
/*
 *
 * @Shortcode Name : Tabs
 * @retrun
 *
 * 
 */
if (!function_exists('automobile_var_page_builder_tabs')) {

    function automobile_var_page_builder_tabs($die = 0) {
        global $automobile_node, $count_node, $post, $automobile_var_html_fields, $automobile_var_form_fields;




        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $tabs_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'automobile_tabs|automobile_tabs_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }

        $defaults = array(
            'automobile_var_tabs_title' => '',
            'automobile_var_tabs_style' => '',
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
            $tabs_num = count($atts_content);
        }
        $tabs_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $name = 'automobile_var_page_builder_tabs';
        $coloumn_class = 'column_' . $tabs_element_size;
        $automobile_var_tabs_main_title = isset($automobile_var_tabs_main_title) ? $automobile_var_tabs_main_title : '';
        $automobile_var_tabs_style = isset($automobile_var_tabs_style) ? $automobile_var_tabs_style : '';

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
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="tabs" data="<?php echo automobile_element_size_data_array_index($tabs_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $tabs_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_tabs_edit_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/automobile_tabs]" data-shortcode-child-template="[automobile_tabs_item {{attributes}}] {{content}} [/automobile_tabs_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[automobile_tabs {{attributes}}]">
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
                                        'std' => automobile_allow_special_char($automobile_var_tabs_title),
                                        'id' => 'tabs_title' . $automobile_counter,
                                        'cust_name' => 'automobile_var_tabs_title[]',
                                        'classes' => '',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_tabs_tabs_style'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_tabs_tabs_style_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => automobile_allow_special_char($automobile_var_tabs_style),
                                        'id' => 'tabs_style' . $automobile_counter,
                                        'cust_name' => 'automobile_var_tabs_style[]',
                                        'classes' => 'chosen-select-no-single select-medium',
                                        'options' => array('Vertical' => automobile_var_theme_text_srt('automobile_var_tabs_vertical_style'), 'Horizontal' => automobile_var_theme_text_srt('automobile_var_tabs_horizontal_style'),),
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                ?>

                            </div>
                            <?php
                            if (isset($tabs_num) && $tabs_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $tabs) {
                                    $automobile_var_tabs_text = $tabs['content'];
                                    $rand_id = rand(3333, 99999);

                                    $defaults = array(
                                        'automobile_var_tabs_item_text' => 'Title',
                                        'automobile_var_tabs_item_icon' => '',
                                        'automobile_var_tabs_active' => ''
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($tabs['atts'][$key]))
                                            $$key = $tabs['atts'][$key];
                                        else
                                            $$key = $values;
                                    }

                                    $automobile_var_tabs_item_text = isset($automobile_var_tabs_item_text) ? $automobile_var_tabs_item_text : '';
                                    $automobile_var_tabs_desc = $automobile_var_tabs_text;
                                    $automobile_var_tabs_item_icon = isset($automobile_var_tabs_item_icon) ? $automobile_var_tabs_item_icon : '';
                                    $automobile_var_tabs_active = isset($automobile_var_tabs_active) ? $automobile_var_tabs_active : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="automobile_infobox_<?php echo automobile_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_tabs_tabs'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_tabs_remove'); ?></a></header>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_tabs_active'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_tabs_active_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($automobile_var_tabs_active),
                                                'id' => 'tabs_active',
                                                'cust_name' => 'automobile_var_tabs_active[]',
                                                'options' => array('Yes' => automobile_var_theme_text_srt('automobile_var_yes'), 'No' => automobile_var_theme_text_srt('automobile_var_no')),
                                                'classes' => 'chosen-select-no-single select-medium',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_tabs_item_text'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_tabs_item_text_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($automobile_var_tabs_item_text),
                                                'id' => 'tabs_item_text' . $automobile_counter,
                                                'cust_name' => 'automobile_var_tabs_item_text[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
?>
                                        <div class="form-elements" id="automobile_infobox_<?php echo esc_attr($rand_id); ?>">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <label><?php echo automobile_var_theme_text_srt('automobile_var_tabs_icon'); ?></label>
                                                <?php
                                                if (function_exists('automobile_var_tooltip_helptext')) {
                                                    echo automobile_var_tooltip_helptext(automobile_var_theme_text_srt('automobile_var_tabs_icon_hint'));
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                <?php echo automobile_var_icomoon_icons_box(esc_html($automobile_var_tabs_item_icon), esc_attr($rand_id), 'automobile_var_tabs_item_icon'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_tabs_descr'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_tabs_descr_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => automobile_allow_special_char($automobile_var_tabs_desc),
                                                'cust_id' => 'automobile_var_tabs_desc' . $automobile_counter,
                                                'cust_name' => 'automobile_var_tabs_desc[]',
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
                        </div>
                        <div class="hidden-object">
                            <?php
                            $automobile_opt_array = array(
                                'std' => $tabs_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'tabs_num[]',
                                'return' => true,
                                'required' => false
                            );
                            echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('tabs', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo automobile_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_tabs_add_tab'); ?></a> </li>
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
                                        'std' => 'tabs',
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
        ?>
        <?php
    }

    add_action('wp_ajax_automobile_var_page_builder_tabs', 'automobile_var_page_builder_tabs');
}
