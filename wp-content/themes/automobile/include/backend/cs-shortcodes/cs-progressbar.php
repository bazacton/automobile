<?php
/*
 *
 * @Shortcode Name : Progressbar
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_progressbars')) {

    function automobile_var_page_builder_progressbars($die = 0) {
        global $automobile_node, $post, $automobile_var_html_fields, $automobile_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $PREFIX = 'automobile_progressbar|progressbar_item';
        $parseObject = new ShortcodeParse();
        $progressbars_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array('column_size' => '1/1', 'progressbars_element_title' => '');

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
            $progressbars_num = count($atts_content);
        }

        $progressbars_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_progressbars';
        $coloumn_class = 'column_' . $progressbars_element_size;

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        
        global $automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        $strings->automobile_theme_option_field_strings();
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="progressbars" data="<?php echo automobile_element_size_data_array_index($progressbars_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $progressbars_element_size, '', 'list-alt'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter); ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_progressbar_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter); ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                <div class="cs-clone-append cs-pbwp-content" >
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo esc_attr($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr('automobile_progressbar'); ?>]" data-shortcode-child-template="[<?php echo esc_attr('progressbar_item'); ?> {{attributes}}] {{content}} [/<?php echo esc_attr('progressbar_item'); ?>]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr('automobile_progressbar'); ?> {{attributes}}]">
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
                                        'std' => esc_html($progressbars_element_title),
                                        'id' => 'progressbars_element_title',
                                        'cust_name' => 'progressbars_element_title[]',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                ?>
                            </div>
                            <?php
                            if (isset($progressbars_num) && $progressbars_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $progressbars) {
                                    $rand_id = $automobile_counter . '' . automobile_generate_random_string(3);
                                    $defaults = array('progressbars_title' => '', 'progressbars_color' => '#4d8b0c', 'progressbars_percentage' => '50');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($progressbars['atts'][$key])) {
                                            $$key = $progressbars['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    echo '<div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content" id="automobile_infobox_' . $rand_id . '">';
                                    ?>
                                    <header>
                                        <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_progressbar'); ?></h4>
                                        <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_remove'); ?></a></header>

                                    <?php
                                    $automobile_opt_array = array(
                                        'name' => automobile_var_theme_text_srt('automobile_var_progressbar_title'),
                                        'desc' => '',
                                        'hint_text' => automobile_var_theme_text_srt('automobile_var_progressbar_title_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => esc_html($progressbars_title),
                                            'id' => 'progressbars_title',
                                            'cust_name' => 'progressbars_title[]',
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


                                    $automobile_opt_array = array(
                                        'name' => automobile_var_theme_text_srt('automobile_var_progressbar_skill'),
                                        'desc' => '',
                                        'hint_text' => automobile_var_theme_text_srt('automobile_var_progressbar_skill_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => esc_html($progressbars_percentage),
                                            'id' => 'progressbars_percentage',
                                            'cust_name' => 'progressbars_percentage[]',
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


                                    $automobile_opt_array = array(
                                        'name' => automobile_var_theme_text_srt('automobile_var_progressbar_color'),
                                        'desc' => '',
                                        'hint_text' => automobile_var_theme_text_srt('automobile_var_progressbar_color_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => esc_html($progressbars_color),
                                            'id' => 'progressbars_color',
                                            'cust_name' => 'progressbars_color[]',
                                            'return' => true,
                                            'classes' => 'bg_color',
                                        ),
                                    );

                                    $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                    ?>

                                </div>
                                <script>
                                    /*
                                     * popup over 
                                     */
                                    chosen_selectionbox();                                
                                    popup_over();
                                    /*
                                     *End popup over 
                                     */
                                </script> 
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="hidden-object">

                        <?php
                        $automobile_opt_array = array(
                            'std' => esc_attr($progressbars_num),
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'classes' => 'fieldCounter',
                            'extra_atr' => '',
                            'cust_id' => '',
                            'cust_name' => 'progressbars_num[]',
                            'return' => true,
                            'required' => false
                        );
                        echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));
                        ?>
                    </div>
                    <div class="wrapptabbox cs-zero-padding">
                        <div class="opt-conts">
                            <ul class="form-elements noborder">
                                <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('progressbars', 'shortcode-item-<?php echo esc_js($automobile_counter); ?>', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_progressbar_add_button'); ?></a> </li>
                                <div id="loading" class="shortcodeload"></div>
                            </ul>
                            <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                <ul class="form-elements insert-bg">
                                    <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_page_builder_', '', $name)); ?>', 'shortcode-item-<?php echo esc_js($automobile_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                                </ul>
                                <div id="results-shortocde"></div>
                            <?php } else { ?>

                                <?php
                                $automobile_opt_array = array(
                                    'std' => 'progressbars',
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
        <script>

            /*
             * modern selection box function
             */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
            /*
             * modern selection box function
             */
        </script>
        <?php
        if ($die <> 1) {
            die();
        }
    }
    add_action('wp_ajax_automobile_var_page_builder_progressbars', 'automobile_var_page_builder_progressbars');
}
?>