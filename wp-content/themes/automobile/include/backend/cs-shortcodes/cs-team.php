<?php
/*
 *
 * @Shortcode Name : List
 * @retrun
 *
 * 
 */
if (!function_exists('automobile_var_page_builder_team')) {

    function automobile_var_page_builder_team($die = 0) {
        global $automobile_node, $count_node, $post, $automobile_var_html_fields, $automobile_var_form_fields;

        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        // 
        // $parseObject = new ShortcodeParse();
        $team_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'automobile_team|automobile_team_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'automobile_var_team_title' => '',
            'automobile_var_team_sub_title' => '',
            'automobile_var_team_col' => '',
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
            $team_num = count($atts_content);
        }
        $team_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }


        $name = 'automobile_var_page_builder_team';
        $coloumn_class = 'column_' . $team_element_size;
        $automobile_var_team_main_title = isset($automobile_var_team_main_title) ? $automobile_var_team_main_title : '';
        $automobile_var_team_sub_title = isset($automobile_var_team_sub_title) ? $automobile_var_team_sub_title : '';
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
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="team" data="<?php echo automobile_element_size_data_array_index($team_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $team_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_team_edit_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/automobile_team]" data-shortcode-child-template="[automobile_team_item {{attributes}}] {{content}} [/automobile_team_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[automobile_team {{attributes}}]">
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
                                        'std' => automobile_allow_special_char($automobile_var_team_title),
                                        'id' => 'team_title' . $automobile_counter,
                                        'cust_name' => 'automobile_var_team_title[]',
                                        'classes' => '',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_col'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_sel_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_var_team_col,
                                        'id' => '',
                                        'cust_name' => 'automobile_var_team_col[]',
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
                                ?>

                            </div>
                            <?php
                            if (isset($team_num) && $team_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $team) {

                                    $rand_id = rand(3333, 99999);
                                    $automobile_var_team_text = $team['content'];
                                    $defaults = array(
                                        'automobile_var_team_name' => '',
                                        'automobile_var_team_designation' => '',
                                        'automobile_var_team_image' => '',
                                        'automobile_var_team_phone' => '',
                                        'automobile_var_team_fb' => '',
                                        'automobile_var_team_twitter' => '',
                                        'automobile_var_team_google' => '',
                                        'automobile_var_team_linkedin' => '',
                                        'automobile_var_team_youtube' => ''
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($team['atts'][$key]))
                                            $$key = $team['atts'][$key];
                                        else
                                            $$key = $values;
                                    }


                                    $automobile_var_team_name = isset($automobile_var_team_name) ? $automobile_var_team_name : '';
                                    $automobile_var_team_designation = isset($automobile_var_team_designation) ? $automobile_var_team_designation : '';
                                    $automobile_var_team_image = isset($automobile_var_team_image) ? $automobile_var_team_image : '';
                                    $automobile_var_team_phone = isset($automobile_var_team_phone) ? $automobile_var_team_phone : '';
                                    $automobile_var_team_fb = isset($automobile_var_team_fb) ? $automobile_var_team_fb : '';
                                    $automobile_var_team_twitter = isset($automobile_var_team_twitter) ? $automobile_var_team_twitter : '';
                                    $automobile_var_team_google = isset($automobile_var_team_google) ? $automobile_var_team_google : '';
                                    $automobile_var_team_linkedin = isset($automobile_var_team_linkedin) ? $automobile_var_team_linkedin : '';
                                    $automobile_var_team_youtube = isset($automobile_var_team_youtube) ? $automobile_var_team_youtube : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="automobile_infobox_<?php echo automobile_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_team_sc'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_remove'); ?></a></header>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_name'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_name_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($automobile_var_team_name),
                                                'id' => 'team_name' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_name[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_designation'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_designation_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($automobile_var_team_designation),
                                                'id' => 'team_designation' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_designation[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'std' => $automobile_var_team_image,
                                            'id' => 'team_image_array',
                                            'main_id' => 'team_image_array',
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_image'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_image_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'field_params' => array(
                                                'std' => $automobile_var_team_image,
                                                'cust_id' => '',
                                                'cust_name' => 'automobile_var_team_image[]',
                                                'id' => 'team_image_array',
                                                'return' => true,
                                                'array' => true,
                                            //  'array_txt' => false,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);


                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_phone'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_phone_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($automobile_var_team_phone),
                                                'id' => 'team_phone' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_phone[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_fb'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_fb_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_url($automobile_var_team_fb),
                                                'id' => 'team_fb' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_fb[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_twitter'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_twitter_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_url($automobile_var_team_twitter),
                                                'id' => 'team_twitter' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_twitter[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_google'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_google_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_url($automobile_var_team_google),
                                                'id' => 'team_google' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_google[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_linkedin'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_linkedin_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_url($automobile_var_team_linkedin),
                                                'id' => 'team_linkedin' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_linkedin[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_team_sc_youtube'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_team_sc_youtube_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_url($automobile_var_team_youtube),
                                                'id' => 'team_youtube' . $automobile_counter,
                                                'cust_name' => 'automobile_var_team_youtube[]',
                                                'classes' => '',
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
                                'std' => $team_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'team_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('team', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo automobile_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_team_sc_add_item'); ?></a> </li>
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
                                        'std' => 'team',
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
        ?>
        <?php
    }

    add_action('wp_ajax_automobile_var_page_builder_team', 'automobile_var_page_builder_team');
}
