<?php

/**
 * @Page options
 * @return html
 *
 */
if (!function_exists('automobile_subheader_element')) {

    function automobile_subheader_element() {
        global $post, $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_frame_static_text;
        $page_subheader_no_image = '';

        $automobile_default_map = '[automobile_map automobile_var_map_element_title="Address Help" automobile_var_sub_element_title="Map info" automobile_var_map_height_title="300" automobile_var_map_latitude_title="-0.127758" automobile_var_map_longitude_title="51.507351" automobile_var_info_text_title="info text" automobile_var_info_width_title="300" automobile_var_info_height_title="100" automobile_var_map_zoom="9" automobile_var_map_types="HYBRID" automobile_var_show_marker="true" automobile_var_disable_map="true" automobile_var_drag_able="true" automobile_var_scrol_wheel="true" automobile_var_map_direction="true" ][/automobile_map]';

        $automobile_banner_style = get_post_meta($post->ID, 'automobile_header_banner_style', true);

        $automobile_default_header = $automobile_breadcrumb_header = $automobile_custom_slider = $automobile_map = $automobile_no_header = 'hide';
        if (isset($automobile_banner_style) && $automobile_banner_style == 'default_header') {
            $automobile_default_header = 'show';
        } else if (isset($automobile_banner_style) && $automobile_banner_style == 'breadcrumb_header') {
            $automobile_breadcrumb_header = 'show';
        } else if (isset($automobile_banner_style) && $automobile_banner_style == 'custom_slider') {
            $automobile_custom_slider = 'show';
        } else if (isset($automobile_banner_style) && $automobile_banner_style == 'map') {
            $automobile_map = 'show';
        } else if (isset($automobile_banner_style) && $automobile_banner_style == 'no-header') {
            $automobile_no_header = 'show';
        } else {
            $automobile_default_header = 'show';
        }

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_choose_subheader'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => 'default_header',
                'id' => 'header_banner_style',
                'return' => true,
                'extra_atr' => 'onchange="automobile_header_element_toggle(this.value)"',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'default_header' => automobile_var_frame_text_srt('automobile_var_default_subheader'),
                    'breadcrumb_header' => automobile_var_frame_text_srt('automobile_var_custom_subheader'),
                    'custom_slider' => automobile_var_frame_text_srt('automobile_var_rev_slider'),
                    'map' => automobile_var_frame_text_srt('automobile_var_map'),
                    'no-header' => automobile_var_frame_text_srt('automobile_var_no_subheader')
                ),
            ),
        );

        $automobile_var_html_fields->automobile_var_select_field($automobile_var_opt_array);


        $automobile_var_opt_array = array(
            'id' => 'custom_header',
            'enable_id' => 'automobile_var_header_banner_style',
            'enable_val' => 'breadcrumb_header',
        );

        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_style'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => 'simple',
                'id' => 'sub_header_style',
                'return' => true,
                'extra_atr' => 'onchange="automobile_var_page_subheader_style(this.value)"',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'classic' => automobile_var_frame_text_srt('automobile_var_classic'),
                    'with_bg' => automobile_var_frame_text_srt('automobile_var_with_image'),
                ),
            ),
        );

        $automobile_var_html_fields->automobile_var_select_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_padding_top'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_padding_top_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_padding_top',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_padding_bot'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_padding_bot_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_padding_bottom',
                'return' => true,
            ),
        );
        $automobile_var_html_fields->automobile_var_text_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_margin_top'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_margin_top_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_margin_top',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_margin_bot'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_margin_bot_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_margin_bottom',
                'return' => true,
            ),
        );
        $automobile_var_html_fields->automobile_var_text_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_page_title'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_title_switch',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_checkbox_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_sub_header_align'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => 'left',
                'id' => 'sub_header_align',
                'return' => true,
                'extra_atr' => '',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'left' => automobile_var_frame_text_srt('automobile_var_align_left'),
                    'center' => automobile_var_frame_text_srt('automobile_var_align_center'),
                    'right' => automobile_var_frame_text_srt('automobile_var_align_right'),
                ),
            ),
        );

        $automobile_var_html_fields->automobile_var_select_field($automobile_var_opt_array);
        

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_text_color'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_text_color_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheader_text_color',
                'classes' => 'bg_color',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'id' => 'subheader_with_bc',
            'enable_id' => 'automobile_var_sub_header_style',
            'enable_val' => 'classic',
        );
        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);
        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_breadcrumbs'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_breadcrumbs',
                'return' => true,
            ),
        );
        $automobile_var_html_fields->automobile_var_checkbox_field($automobile_var_opt_array);
        $automobile_var_html_fields->automobile_var_division_close(array());

        $automobile_var_opt_array = array(
            'id' => 'subheader_with_bg',
            'enable_id' => 'automobile_var_sub_header_style',
            'enable_val' => 'with_bg',
        );
        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_sub_heading'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_sub_heading_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheading_title',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_textarea_field($automobile_var_opt_array);

        $automobile_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_bg_image'),
            'id' => 'header_banner_image',
            'main_id' => '',
            'std' => '',
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_bg_image_hint'),
            'prefix' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'header_banner_image',
                'prefix' => '',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_parallax'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_parallax_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheader_parallax',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_checkbox_field($automobile_var_opt_array);

        $automobile_var_html_fields->automobile_var_division_close(array());

        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_bg_color'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_bg_color_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheader_color',
                'classes' => 'bg_color',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_var_opt_array);

        $automobile_var_html_fields->automobile_var_division_close(array());

        $automobile_var_opt_array = array(
            'id' => 'rev_slider_header',
            'enable_id' => 'automobile_var_header_banner_style',
            'enable_val' => 'custom_slider',
        );

        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);

        $automobile_slider_value = get_post_meta($post->ID, 'automobile_var_custom_slider_id', true);
        $automobile_slider_options = '<option value="">' . automobile_var_frame_text_srt('automobile_var_slider') . '</option>';

        if (class_exists('RevSlider') && class_exists('automobile_var_RevSlider')) {
            $slider = new automobile_var_RevSlider();
            $arrSliders = $slider->getAllSliderAliases();
            if (is_array($arrSliders)) {
                foreach ($arrSliders as $key => $entry) {
                    $automobile_slider_selected = '';
                    if ($automobile_slider_value != '') {
                        if ($automobile_slider_value == $entry['alias']) {
                            $automobile_slider_selected = ' selected="selected"';
                        }
                    }
                    $automobile_slider_options .= '<option ' . $automobile_slider_selected . ' value="' . $entry['alias'] . '">' . $entry['title'] . '</option>';
                }
            }
        }

        $automobile_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_slider'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'custom_slider_id',
                'classes' => 'dropdown chosen-select',
                'return' => true,
                'options_markup' => true,
                'options' => $automobile_slider_options,
            ),
        );
        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);



        $automobile_var_html_fields->automobile_var_division_close(array());


        $automobile_var_opt_array = array(
            'id' => 'map_header',
            'enable_id' => 'automobile_var_header_banner_style',
            'enable_val' => 'map',
        );

        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);


        $automobile_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_map_sc'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => $automobile_default_map,
                'id' => 'custom_map',
                'classes' => '',
                'return' => true,
            ),
        );
        $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);


        $automobile_var_html_fields->automobile_var_division_close(array());

        $automobile_var_opt_array = array(
            'id' => 'no_header',
            'enable_id' => 'automobile_var_header_banner_style',
            'enable_val' => 'no-header',
        );

        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);


        $automobile_var_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_header_border'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_header_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'main_header_border_color',
                'classes' => 'bg_color',
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_text_field($automobile_var_opt_array);
        $automobile_var_html_fields->automobile_var_division_close(array());
        ?>
        <script>
            jQuery(document).ready(function () {
                chosen_selectionbox();
            });
        </script>
        <?php

    }

}

/**
 * @Sidebar Layout setting start
 * @return
 *
 */
if (!function_exists('automobile_sidebar_layout_options')) {

    function automobile_sidebar_layout_options() {
        global $post, $automobile_var_options, $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_frame_static_text;

       // if (isset($post->post_type) && $post->post_type == 'page') {
//            $automobile_var_opt_array = array(
//                'name' => automobile_var_frame_text_srt('automobile_var_header_style'),
//                'desc' => '',
//                'hint_text' => '',
//                'echo' => true,
//                'field_params' => array(
//                    'std' => 'default_header_style',
//                    'id' => 'header_style',
//                    'return' => true,
//                    'classes' => 'dropdown chosen-select',
//                    'extra_atr' => 'onclick="automobile_header_element_toggle(this.value)"',
//                    'options' => array(
//                        'modern_header_style' => automobile_var_frame_text_srt('automobile_var_modern_header'),
//                        'default_header_style' => automobile_var_frame_text_srt('automobile_var_default_header')
//                    ),
//                ),
//            );
//
//
//            $automobile_var_html_fields->automobile_var_select_field($automobile_var_opt_array);
//        }
        $automobile_sidebars_array = array('' => automobile_var_frame_text_srt('automobile_var_side_bar'));
        if (isset($automobile_var_options['automobile_var_sidebar']) && is_array($automobile_var_options['automobile_var_sidebar']) && sizeof($automobile_var_options['automobile_var_sidebar']) > 0) {
            foreach ($automobile_var_options['automobile_var_sidebar'] as $key => $sidebar) {
                $automobile_sidebars_array[sanitize_title($sidebar)] = $sidebar;
            }
        }

        $automobile_var_html_fields->automobile_form_layout_render(
                array('name' => automobile_var_frame_text_srt('automobile_var_choose_sidebar'),
                    'id' => 'page_layout',
                    'std' => 'none',
                    'classes' => '',
                    'description' => '',
                    'onclick' => '',
                    'status' => '',
                    'meta' => '',
                    'help_text' => automobile_var_frame_text_srt('automobile_var_sidebar_hint')
                )
        );

        $automobile_var_opt_array = array(
            'id' => 'left_layout',
            'enable_id' => 'automobile_var_page_layout',
            'enable_val' => 'left',
        );

        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);


        $automobile_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_left_sidebar'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_sidebar_left',
                'classes' => 'dropdown chosen-select',
                'return' => true,
                'options' => $automobile_sidebars_array,
            ),
        );
        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);


        $automobile_var_html_fields->automobile_var_division_close(array());


        $automobile_var_opt_array = array(
            'id' => 'right_layout',
            'enable_id' => 'automobile_var_page_layout',
            'enable_val' => 'right',
        );

        $automobile_var_html_fields->automobile_var_division($automobile_var_opt_array);


        $automobile_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_right_sidebar'),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_sidebar_right',
                'classes' => 'dropdown chosen-select',
                'return' => true,
                'options' => $automobile_sidebars_array,
            ),
        );
        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);


        $automobile_var_html_fields->automobile_var_division_close(array());
        ?>
        <script>
            jQuery(document).ready(function () {
                chosen_selectionbox();
            });
        </script>
        <?php

    }
}