<?php
/*
 *
 * @Shortcode Name : Clients
 * @retrun
 *
 */

if (!function_exists('automobile_var_page_builder_clients')) {

    function automobile_var_page_builder_clients($die = 0) {
        global $post, $automobile_node, $automobile_var_html_fields, $automobile_var_form_fields , $automobile_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $automobile_counter = $_POST['counter'];
        $clients_num = 0;
        $automobile_var_clients_element_title = isset($automobile_var_clients_element_title) ? $automobile_var_clients_element_title : '';
        $automobile_var_clients_perslide = isset($automobile_var_clients_perslide) ? $automobile_var_clients_perslide : '';
        $automobile_var_clients_text_color = isset($automobile_var_clients_text_color) ? $automobile_var_clients_text_color : '';
        $automobile_var_clients_author = isset($automobile_var_clients_author) ? $automobile_var_clients_author : '';
        $automobile_var_clients_position = isset($automobile_var_clients_position) ? $automobile_var_clients_position : '';
        $clients_img_user = isset($clients_img_user) ? $clients_img_user : '';
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $AUTOMOBILE_POSTID = '';
            $shortcode_element_id = '';
        } else {
            $AUTOMOBILE_POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $AUTOMOBILE_PREFIX = 'automobile_clients|clients_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $AUTOMOBILE_PREFIX);
        }
        $defaults = array('column_size' => '1/1', 'automobile_var_clients_text_color' => '', 'automobile_clients_text_align' => '', 'automobile_var_clients_element_title' => '',
            'automobile_clients_class' => '', 'clients_style' => '', 'clients_text_color' => '', 'automobile_var_clients_perslide' => '5',);
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
            $clients_num = count($atts_content);
        }
        $clients_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'automobile_var_page_builder_clients';
        $coloumn_class = 'column_' . $clients_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new automobile_theme_all_strings;
        $strings->automobile_short_code_strings();
        ?>
        <div id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>_del" class="column  parentdelete <?php echo automobile_allow_special_char($coloumn_class); ?> <?php echo automobile_allow_special_char($shortcode_view); ?>" item="clients" data="<?php echo automobile_element_size_data_array_index($clients_element_size) ?>" >
            <?php automobile_element_setting($name, $automobile_counter, $clients_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo automobile_allow_special_char($automobile_counter) ?> <?php echo automobile_allow_special_char($shortcode_element); ?>" id="<?php echo automobile_allow_special_char($name . $automobile_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_client_edit_options'); ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo automobile_allow_special_char($name . $automobile_counter) ?>','<?php echo automobile_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>" data-shortcode-template="{{child_shortcode}} [/automobile_clients]" data-shortcode-child-template="[clients_item {{attributes}}] {{content}} [/clients_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[automobile_clients {{attributes}}]">
                                <?php
                                if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                    automobile_shortcode_element_size();
                                }
                                $automobile_clients_style = isset($automobile_clients_style) ? $automobile_clients_style : '';
                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_client_element_title'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_client_title_hint_text'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_var_clients_element_title),
                                        'cust_id' => '',
                                        'cust_id' => 'automobile_var_clients_element_title' . $automobile_counter,
                                        'cust_name' => 'automobile_var_clients_element_title[]',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'name' => automobile_var_theme_text_srt('automobile_var_client_per_slide'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_theme_text_srt('automobile_var_client_per_slide_hint_text'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_var_clients_perslide),
                                        'cust_id' => '',
                                        'cust_id' => 'automobile_var_clients_perslide' . $automobile_counter,
                                        'cust_name' => 'automobile_var_clients_perslide[]',
                                        'return' => true,
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                ?>

                            </div>
                            <?php
                            if (isset($clients_num) && $clients_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $clients) {
                                    $rand_string = rand(1234, 7894563);
                                    $automobile_var_clients_text = $clients['content'];
                                    $defaults = array('automobile_var_clients_author' => '', 'automobile_var_clients_text' => '', 'automobile_var_clients_img_user_array' => '', 'automobile_var_clients_position' => '');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($clients['atts'][$key])) {
                                            $$key = $clients['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="automobile_infobox_<?php echo automobile_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo automobile_var_theme_text_srt('automobile_var_client_counter'); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_theme_text_srt('automobile_var_remove'); ?></a>
                                        </header>
                                        <?php
                                        $automobile_opt_array = array(
                                            'name' => automobile_var_theme_text_srt('automobile_var_client_url'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_client_url_hint_text'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($automobile_var_clients_text),
                                                'cust_id' => '',
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'cust_name' => 'automobile_var_clients_text[]',
                                                'return' => true,
                                            ),
                                        );

                                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                                        $automobile_opt_array = array(
                                            'std' => $automobile_var_clients_img_user_array,
                                            'id' => 'clients_img_user',
                                            'name' => automobile_var_theme_text_srt('automobile_var_client_image'),
                                            'desc' => '',
                                            'hint_text' => automobile_var_theme_text_srt('automobile_var_client_url_image_hint_text'),
                                            'echo' => true,
                                            'array' => true,
                                            'prefix' => '',
                                            'field_params' => array(
                                                'std' => $automobile_var_clients_img_user_array,
                                                'id' => 'clients_img_user',
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
                                'std' => automobile_allow_special_char($clients_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'clients_num[]',
                                'return' => true,
                                'required' => false
                            );
                            echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));
                            ?>

                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="automobile_shortcode_element_ajax_call('clients', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo automobile_var_theme_text_srt('automobile_var_client_url_add_clients'); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg noborder">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo str_replace('automobile_var_page_builder_', '', $name); ?>', 'shortcode-item-<?php echo automobile_allow_special_char($automobile_counter); ?>', '<?php echo automobile_allow_special_char($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_client_url_add_insert'); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
            <?php
        } else {
            $automobile_opt_array = array(
                'std' => 'clients',
                'id' => '',
                'before' => '',
                'after' => '',
                'classes' => '',
                'extra_atr' => '',
                'cust_id' => 'automobile_orderby' . $automobile_counter,
                'cust_name' => 'automobile_orderby[]',
                'return' => true,
                'required' => false
            );
            echo automobile_allow_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));

            $automobile_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => automobile_var_theme_text_srt('automobile_var_save'),
                    'cust_id' => 'clients_save' . $automobile_counter,
                    'cust_type' => 'button',
                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                    'classes' => 'cs-automobile-admin-btn',
                    'cust_name' => 'clients_save',
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
            <script>
                                /* modern selection box and help hover text function */
                                jQuery(document).ready(function ($) {
                                    chosen_selectionbox();
                                    popup_over();
                                });
                                /* end modern selection box and help hover text function */
                            </script>
        </div>

        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_var_page_builder_clients', 'automobile_var_page_builder_clients');
}