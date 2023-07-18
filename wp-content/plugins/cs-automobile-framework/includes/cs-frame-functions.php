<?php
/**
 * Core Functions of Plugin
 * @return
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('automobile_var_core_functions')) {

    class automobile_var_core_functions {

        public function __construct() {
            add_action('save_post', array($this, 'automobile_var_save_custom_option'));
        }

        /**
         * Save Custom Fields
         * of Post Types
         * @return
         */
        public function automobile_var_save_custom_option($post_id = '') {
            global $post;

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            if (wp_automobile_var_automobile()->is_request('admin')) {
                $automobile_var_data = array();
                foreach ($_POST as $key => $value) {
                    if (strstr($key, 'automobile_var_')) {
                        $automobile_var_data[$key] = $value;
                        update_post_meta($post_id, $key, $value);
                    }
                }
                update_post_meta($post_id, 'automobile_var_full_data', $automobile_var_data);
            }
        }

    }

}


/**
 * @Framework Form
 * @Fields
 *
 */
if (!function_exists('automobile_column_pb')) {

    function automobile_column_pb($die = 0, $shortcode = '') {
        global $post, $automobile_node, $automobile_xmlObject, $automobile_count_node, $column_container, $coloum_width, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_frame_static_text;

        $total_widget = 0;
        $i = 1;
        $automobile_page_section_title = $automobile_page_section_height = $automobile_page_section_width = '';
        $automobile_section_background_option = '';
        $automobile_var_section_title = '';
        $automobile_var_section_subtitle = '';
        $title_sub_title_alignment = '';
        $automobile_section_bg_image = '';
        $automobile_section_bg_image_position = '';
        $automobile_section_bg_image_repeat = '';
        $automobile_section_parallax = '';
        $automobile_section_nopadding = '';
        $automobile_section_nomargin = '';
        $automobile_section_slick_slider = '';
        $automobile_section_custom_slider = '';
        $automobile_section_video_url = '';
        $automobile_section_video_mute = '';
        $automobile_section_video_autoplay = '';
        $automobile_section_border_bottom = '0';
        $automobile_section_border_top = '0';
        $automobile_section_border_color = '#e0e0e0';
        $automobile_section_padding_top = '60';
        $automobile_section_padding_bottom = '30';
        $automobile_section_margin_top = '0';
        $automobile_section_margin_bottom = '0';
        $automobile_section_css_id = '';
        $automobile_section_view = 'container';
        $automobile_layout = '';
        $automobile_sidebar_left = '';
        $automobile_sidebar_right = '';
        $automobile_section_bg_color = '';
        if (isset($column_container)) {
            $column_attributes = $column_container->attributes();
            $column_class = $column_attributes->class;
            $automobile_var_section_title = $column_attributes->automobile_var_section_title;
            $automobile_var_section_subtitle = $column_attributes->automobile_var_section_subtitle;
            $title_sub_title_alignment = $column_attributes->title_sub_title_alignment;
            $automobile_section_background_option = $column_attributes->automobile_section_background_option;
            $automobile_section_bg_image = $column_attributes->automobile_section_bg_image;
            $automobile_section_bg_image_position = $column_attributes->automobile_section_bg_image_position;
            $automobile_section_bg_image_repeat = $column_attributes->automobile_section_bg_image_repeat;
            $automobile_section_slick_slider = $column_attributes->automobile_section_slick_slider;
            $automobile_section_custom_slider = $column_attributes->automobile_section_custom_slider;
            $automobile_section_video_url = $column_attributes->automobile_section_video_url;
            $automobile_section_video_mute = $column_attributes->automobile_section_video_mute;
            $automobile_section_video_autoplay = $column_attributes->automobile_section_video_autoplay;
            $automobile_section_bg_color = $column_attributes->automobile_section_bg_color;
            $automobile_section_parallax = $column_attributes->automobile_section_parallax;
            $automobile_section_nopadding = $column_attributes->automobile_section_nopadding;
            $automobile_section_nomargin = $column_attributes->automobile_section_nomargin;
            $automobile_section_padding_top = $column_attributes->automobile_section_padding_top;
            $automobile_section_padding_bottom = $column_attributes->automobile_section_padding_bottom;
            $automobile_section_border_bottom = $column_attributes->automobile_section_border_bottom;
            $automobile_section_border_top = $column_attributes->automobile_section_border_top;
            $automobile_section_border_color = $column_attributes->automobile_section_border_color;
            $automobile_section_margin_top = $column_attributes->automobile_section_margin_top;
            $automobile_section_margin_bottom = $column_attributes->automobile_section_margin_bottom;
            $automobile_section_css_id = $column_attributes->automobile_section_css_id;
            $automobile_section_view = $column_attributes->automobile_section_view;
            $automobile_layout = $column_attributes->automobile_layout;
            $automobile_sidebar_left = $column_attributes->automobile_sidebar_left;
            $automobile_sidebar_right = $column_attributes->automobile_sidebar_right;
        }
        $style = '';
        if (isset($_POST['action'])) {
            $name = $_POST['action'];
            $automobile_counter = $_POST['counter'];
            $total_column = $_POST['total_column'];
            $column_class = $_POST['column_class'];
            $postID = $_POST['postID'];
            $randomno = rand(12345678, 93242432);
            $rand = rand(12345678, 93242432);
            $style = '';
        } else {
            $postID = $post->ID;
            $name = '';
            $automobile_counter = '';
            $total_column = 0;
            $rand = rand(1, 999);
            $randomno = rand(34, 3242432);
            $name = $_REQUEST['action'];
            $style = ' style="display:none;"';
        }
        $automobile_page_elements_name = automobile_shortcode_names();
        $automobile_page_categories_name = automobile_elements_categories();
        $automobile_var_add_element = automobile_var_frame_text_srt('automobile_var_add_element');
        $automobile_var_search = automobile_var_frame_text_srt('automobile_var_search');
        $automobile_var_show_all = automobile_var_frame_text_srt('automobile_var_search');
        $automobile_var_filter_by = automobile_var_frame_text_srt('automobile_var_filter_by');
        $automobile_var_insert_sc = automobile_var_frame_text_srt('automobile_var_insert_sc');
        ?>
        <div class="cs-page-composer composer-<?php echo absint($rand) ?>" id="composer-<?php echo absint($rand) ?>" style="display:none">
            <div class="page-elements">
                <div class="cs-heading-area">

                    <h5> <i class="icon-plus-circle"></i> <?php echo esc_html($automobile_var_add_element); ?>  </h5>
                    <span class='cs-btnclose' onclick='javascript:automobile_frame_removeoverlay("composer-<?php echo absint($rand) ?>", "append")'><i class="icon-times"></i></span> 
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        'use strict';
                        automobile_page_composer_filterable('<?php echo absint($rand) ?>');
                    });
                </script>
                <div class="cs-filter-content">
                    <p>

                        <?php
                        if (function_exists('automobile_var_date_picker')) {

                            automobile_var_date_picker();
                        }
                        $automobile_opt_array = array(
                            'std' => '',
                            'cust_id' => 'quicksearch' . absint($rand),
                            'classes' => '',
                            'cust_name' => '',
                            'extra_atr' => ' placeholder=' . $automobile_var_search,
                        );
                        $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
                        ?>

                    </p>
                    <div class="cs-filtermenu-wrap">
                        <h6><?php echo esc_html($automobile_var_filter_by); ?></h6>
                        <ul class="cs-filter-menu" id="filters<?php echo absint($rand) ?>">
                            <li data-filter="all" class="active"><?php echo esc_html($automobile_var_show_all); ?></li>
                            <?php foreach ($automobile_page_categories_name as $key => $value) { ?>
                                <li data-filter="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="cs-filter-inner" id="page_element_container<?php echo absint($rand) ?>">
                        <?php foreach ($automobile_page_elements_name as $key => $value) { ?>
                            <div class="element-item <?php echo esc_attr($value['categories']); ?>"> 
                                <a href='javascript:automobile_frame_ajax_widget("automobile_var_page_builder_<?php echo esc_js($value['name']); ?>","<?php echo esc_js($rand) ?>")'>
                                    <?php automobile_page_composer_elements($value['title'], $value['icon']); ?>
                                </a> 
                            </div>
                        <?php } ?>                    
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($shortcode) && $shortcode <> '') {
            ?>
            <a class="button" href="javascript:automobile_frame_createpop('composer-<?php echo esc_js($rand) ?>', 'filter')"><i class="icon-plus-circle"></i><?php echo esc_html($automobile_var_insert_sc); ?> </a>
            <?php
        } else {
            ?>
            <div id="<?php echo esc_attr($randomno); ?>_del" class="column columnmain parentdeletesection column_100" >
                <div class="column-in"> <a class="button" href="javascript:automobile_frame_createpop('composer-<?php echo esc_js($rand) ?>', 'filter')"><i class="icon-plus-circle"></i> <?php echo esc_html($automobile_var_add_element); ?></a>
                    <p> 
                        <a href="javascript:automobile_frame_createpop('<?php echo esc_js($column_class . $randomno); ?>','filterdrag')" class="options">
                            <i class="icon-gear"></i></a> &nbsp; <a href="#" class="delete-it btndeleteitsection"><i class="icon-trash-o"></i></a> &nbsp; 
                    </p>
                </div>
                <div class="column column_container page_section <?php echo sanitize_html_class($column_class); ?>" >
                    <?php
                    $parts = explode('_', $column_class);
                    if ($total_column > 0) {
                        for ($i = 1; $i <= $total_column; $i++) {
                            ?>
                            <div class="dragarea" data-item-width="col_width_<?php echo esc_attr($parts[$i]); ?>">

                                <?php
                                $automobile_opt_array = array(
                                    'std' => '0',
                                    'cust_id' => '',
                                    'classes' => 'textfld',
                                    'cust_name' => 'total_widget[]',
                                    'extra_atr' => '',
                                );
                                $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                                ?>

                                <div class="draginner" id="counter_<?php echo absint($rand) ?>"></div>
                            </div>
                            <?php
                        }
                    }
                    $i = 1;

                    if (isset($column_container)) {
                        global $wpdb;
                        $total_column = count($column_container->children());
                        $section = 0;
                        $section_widget_element_num = 0;
                        foreach ($column_container->children() as $column) {
                            $section++;
                            $total_widget = count($column->children());
                            ?>
                            <script type="text/javascript">

                                function automobile_var_gallery_view(val) {
                                    var automobile_var_gallery_view = jQuery('.gallery_slider_view').val();
                                    if (automobile_var_gallery_view == 'slider') {
                                        jQuery('#slider_gallery').show();
                                        jQuery('#slider_gallery').show();
                                        jQuery('.slider_view_paging').hide();
                                        jQuery('#slider_category').hide();
                                        jQuery('.slider_view_paging_unique').hide();
                                    } else if (automobile_var_gallery_view == 'unique_gallery') {
                                        jQuery('.slider_view_paging_unique').show();
                                        jQuery('.slider_view_paging_style').hide();
                                    } else {
                                        jQuery('#slider_gallery').hide();
                                        jQuery('.slider_view_paging_unique').hide();
                                        jQuery('.slider_view_paging').show();
                                        jQuery('#slider_category').show();
                                        jQuery('#slider_category_column').hide();
                                    }
                                }


                            </script>
                            <div class="dragarea" data-item-width="col_width_<?php echo esc_attr($parts[$i]) ?>">
                                <div class="toparea">
                                    <?php
                                    $automobile_opt_array = array(
                                        'std' => esc_attr($total_widget),
                                        'cust_id' => '',
                                        'classes' => 'textfld page-element-total-widget',
                                        'cust_name' => 'total_widget[]',
                                        'extra_atr' => '',
                                    );
                                    $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                                    ?>
                                </div>
                                <div class="draginner" id="counter_<?php echo absint($rand) ?>">
                                    <?php
                                    $shortcode_element = '';
                                    $filter_element = 'filterdrag';
                                    $shortcode_view = '';
                                    $global_array = array();
                                    $section_widget__element = 0;
                                    $all_shortcode_list = automobile_shortcode_names();
                                    foreach ($column->children() as $automobile_node) { 
                                        
                                        $section_widget__element++;
                                        $shortcode_element_idd = $rand . '_' . $section_widget__element;
                                        $global_array[] = $automobile_node;
                                        $automobile_count_node++;
                                        $automobile_counter = $postID . $automobile_count_node;
                                        $a = $name = "automobile_var_page_builder_" . $automobile_node->getName();
                                        $coloumn_class = 'column_' . $automobile_node->page_element_size;
                                        $type = '';
                                        if ($automobile_node->getName() == 'page_element') {
                                            $type = 'page_element';
                                        }

                                        $automobile_var_quick_quote = automobile_var_frame_text_srt('automobile_var_quick_quote');
                                        $automobile_var_edit_options = automobile_var_frame_text_srt('automobile_var_edit_options');
                                        ?>
                                        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete  <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="<?php echo esc_attr($automobile_node->getName()); ?>" data="<?php echo automobile_element_size_data_array_index($automobile_node->page_element_size) ?>" >
                                            <?php automobile_ajax_element_setting($automobile_node->getName(), $automobile_counter, $automobile_node->page_element_size, $shortcode_element_idd, $postID, $element_description = '', $automobile_node->getName() . '-icon', $type); ?>
                                            <div class="cs-wrapp-class-<?php echo esc_attr($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" style="display: none;">
                                                <div class="cs-heading-area">
                                                    <?php
                                                    $shortcode_name = '';
                                                    if ($automobile_node->getName() == 'quick_slider') {
                                                        $shortcode_name = $automobile_var_quick_quote;
                                                    } else {
                                                        //$shortcode_name = str_replace("_", " ", $automobile_node->getName());
                                                        $shortcode_name = $all_shortcode_list[$automobile_node->getName()]['title'];
                                                    }
                                                    ?>
                                                    <h5><?php echo sprintf($automobile_var_edit_options, esc_html($shortcode_name)) ?></h5>

                                                    <a href="javascript:;" onclick="javascript:automobile_frame_removeoverlay('<?php echo esc_attr($name . $automobile_counter); ?>', '<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                                                </div>
                                                <?php
                                                $automobile_opt_array = array(
                                                    'std' => 'shortcode',
                                                    'cust_id' => 'shortcode_' . $name . $automobile_counter,
                                                    'classes' => 'cs-wiget-element-type',
                                                    'cust_name' => 'automobile_widget_element_num[]',
                                                    'extra_atr' => '',
                                                );
                                                $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                                                ?>
                                                <div class="pagebuilder-data-load">
                                                    <?php
                                                    $automobile_opt_array = array(
                                                        'std' => $automobile_node->getName(),
                                                        'cust_id' => '',
                                                        'classes' => '',
                                                        'cust_name' => 'automobile_orderby[]',
                                                        'extra_atr' => '',
                                                    );
                                                    $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                                                    
                                                    
                                                    $automobile_shortcode = htmlspecialchars_decode($automobile_node->automobile_shortcode);
                                                    //$fp = fopen("/home/group/public_html/clients/jobcareer2018/wp-content/plugins/cs-automobile-framework/includes/logs/page_builder_log_". $automobile_node->getName(). "_". date('Y-m-d h:i:s', time()).".txt","wb"); 
                                                    //fwrite($fp, $automobile_shortcode);
                                                    //fclose($fp);
                                                    
                                                    
                                                    $automobile_opt_array = array(
                                                        'std' => $automobile_shortcode,
                                                        'cust_id' => '',
                                                        'classes' => 'cs-textarea-val',
                                                        'cust_name' => 'shortcode[' . $automobile_node->getName() . '][]',
                                                        'extra_atr' => ' style=display:none;',
                                                        'force_std' => true,
                                                    );
                                                    $automobile_var_form_fields->automobile_var_form_textarea_render($automobile_opt_array);
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>

                </div>
                <div id="<?php echo esc_attr($column_class . $randomno); ?>" style="display:none">
                    <div class="cs-heading-area">
                        <h5><?php echo automobile_var_frame_text_srt('automobile_var_edit_page'); ?></h5>
                        <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($column_class . $randomno); ?>','filterdrag')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
                    <div class="cs-pbwp-content">
                        <div class="cs-wrapp-clone cs-shortcode-wrapp">
                            <?php
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_title'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_var_section_title,
                                    'id' => 'section_title',
                                    'classes' => '',
                                    'array' => true,
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_subtitle'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_subtitle_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_var_section_subtitle,
                                    'id' => 'section_subtitle',
                                    'classes' => '',
                                    'array' => true,
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_title_sub_title_align'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_title_sub_title_align_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $title_sub_title_alignment,
                                    'id' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'title_sub_title_alignment[]',
                                    'classes' => 'chosen-select-no-single select-medium',
                                    'options' => array(
                                        'left' => automobile_var_frame_text_srt('automobile_var_align_left'),
                                        'center' => automobile_var_frame_text_srt('automobile_var_align_center'),
                                        'right' => automobile_var_frame_text_srt('automobile_var_align_right'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_bg_view'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_choose_bg'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_section_background_option,
                                    'id' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_background_option[]',
                                    'classes' => 'chosen-select-no-single select-medium',
                                    'options' => array(
                                        'no-image' => automobile_var_frame_text_srt('automobile_var_none'),
                                        'section-custom-background-image' => automobile_var_frame_text_srt('automobile_var_bg_image'),
                                        'section-custom-slider' => automobile_var_frame_text_srt('automobile_var_custom_slider'),
                                        'section_background_video' => automobile_var_frame_text_srt('automobile_var_video'),
                                    ),
                                    'return' => true,
                                    'extra_atr' => 'onchange="javascript:automobile_section_background_settings_toggle(this.value, ' . absint($randomno) . ')"',
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                            ?>    
                            <div class="meta-body noborder section-custom-background-image-<?php echo esc_attr($randomno); ?>" style=" <?php
                            if ($automobile_section_background_option == "section-custom-background-image") {
                                echo "display:block";
                            } else
                                echo "display:none";
                            ?>">
                                     <?php
                                     $automobile_opt_array = array(
                                         'std' => $automobile_section_bg_image,
                                         'id' => 'section_bg_image',
                                         'name' => automobile_var_frame_text_srt('automobile_var_bg_image'),
                                         'desc' => '',
                                         'force_std' => true,
                                         'echo' => true,
                                         'array' => true,
                                         'field_params' => array(
                                             'std' => $automobile_section_bg_image,
                                             'cust_id' => '',
                                             'id' => 'section_bg_image',
                                             'force_std' => true,
                                             'return' => true,
                                             'array' => true,
                                             'array_txt' => false,
                                         ),
                                     );
                                     $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);


                                     $automobile_opt_array = array(
                                         'name' => automobile_var_frame_text_srt('automobile_var_bg_position'),
                                         'desc' => '',
                                         'hint_text' => automobile_var_frame_text_srt('automobile_var_bg_position_hint'),
                                         'echo' => true,
                                         'field_params' => array(
                                             'std' => $automobile_section_bg_image_position,
                                             'id' => '',
                                             'cust_id' => '',
                                             'cust_name' => 'automobile_section_bg_image_position[]',
                                             'classes' => 'select_dropdown chosen-select-no-single select-medium',
                                             'options' => array(
                                                 'no-repeat center top' => automobile_var_frame_text_srt('automobile_var_no_center_top'),
                                                 'repeat center top' => automobile_var_frame_text_srt('automobile_var_center_top'),
                                                 'no-repeat center' => automobile_var_frame_text_srt('automobile_var_no_center'),
                                                 'no-repeat center / cover' => automobile_var_frame_text_srt('automobile_var_no_center_cover'),
                                                 'repeat center' => automobile_var_frame_text_srt('automobile_var_repeat_center'),
                                                 'no-repeat left top' => automobile_var_frame_text_srt('automobile_var_no_left_top'),
                                                 'repeat left top' => automobile_var_frame_text_srt('automobile_var_repeat_left_top'),
                                                 'no-repeat fixed center' => automobile_var_frame_text_srt('automobile_var_no_fixed'),
                                                 'no-repeat fixed center / cover' => automobile_var_frame_text_srt('automobile_var_no_fixed_cover'),
                                             ),
                                             'return' => true,
                                             'extra_atr' => '',
                                         ),
                                     );
                                     $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                     ?>    
                            </div>
                            <div class="meta-body noborder section-slider-<?php echo esc_attr($randomno); ?>" style=" <?php
                            if ($automobile_section_background_option == "section-slider") {
                                echo "display:block";
                            } else
                                echo "display:none";
                            ?>">
                            </div>
                            <div class="meta-body noborder section-custom-slider-<?php echo esc_attr($randomno); ?>" style=" <?php
                            if ($automobile_section_background_option == "section-custom-slider") {
                                echo "display:block";
                            } else
                                echo "display:none";
                            ?>" >

                                <?php
                                $automobile_opt_array = array(
                                    'name' => automobile_var_frame_text_srt('automobile_var_custom_slider'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_frame_text_srt('automobile_var_custom_slider_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($automobile_section_custom_slider),
                                        'cust_id' => '',
                                        'classes' => 'txtfield',
                                        'cust_name' => 'automobile_section_custom_slider[]',
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                                ?>

                            </div>
                            <div class="meta-body noborder section-background-video-<?php echo esc_attr($randomno); ?>" style=" <?php
                            if ($automobile_section_background_option == "section_background_video") {
                                echo "display:block";
                            } else
                                echo "display:none";
                            ?>">
                                <div class="form-elements">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label><?php echo esc_html('automobile_var_video_url'); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="input-sec">
                                            <?php
                                            $automobile_opt_array = array(
                                                'std' => esc_url(automobile_var_frame_text_srt('automobile_section_video_url')),
                                                'cust_id' => '',
                                                'id' => 'section_video_url_' . esc_attr($randomno),
                                                'classes' => '',
                                                'cust_name' => 'automobile_section_video_url',
                                                'extra_atr' => '',
                                            );
                                            $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
                                            ?>
                                            <label class="browse-icon">
                                                <?php
                                                $automobile_opt_array = array(
                                                    'std' => automobile_var_frame_text_srt('automobile_var_browse'),
                                                    'cust_id' => '',
                                                    'cust_type' => 'button',
                                                    'classes' => 'cs-automobile-media left',
                                                    'cust_name' => 'automobile_section_video_url_' . esc_attr($randomno),
                                                    'extra_atr' => '',
                                                );
                                                $automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array);
                                                ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $automobile_opt_array = array(
                                    'name' => automobile_var_frame_text_srt('automobile_var_mute'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_frame_text_srt('automobile_var_choose_mute'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_section_video_mute,
                                        'id' => '',
                                        'cust_id' => '',
                                        'cust_name' => 'automobile_section_video_mute[]',
                                        'classes' => 'select_dropdown chosen-select-no-single select-medium',
                                        'options' => array(
                                            'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                                            'no' => automobile_var_frame_text_srt('automobile_var_no'),
                                        ),
                                        'return' => true,
                                        'extra_atr' => '',
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                ?>    
                                <?php
                                $automobile_opt_array = array(
                                    'name' => automobile_var_frame_text_srt('automobile_var_video_auto'),
                                    'desc' => '',
                                    'hint_text' => automobile_var_frame_text_srt('automobile_var_choose_video_auto'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_section_video_autoplay,
                                        'id' => '',
                                        'cust_id' => '',
                                        'cust_name' => 'automobile_section_video_autoplay[]',
                                        'classes' => 'select_dropdown chosen-select-no-single select-medium',
                                        'options' => array(
                                            'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                                            'no' => automobile_var_frame_text_srt('automobile_var_no'),
                                        ),
                                        'return' => true,
                                        'extra_atr' => '',
                                    ),
                                );
                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                ?>      

                            </div>
                            <?php
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_enable_parallax'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_section_parallax,
                                    'id' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_parallax[]',
                                    'classes' => 'select_dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                                        'no' => automobile_var_frame_text_srt('automobile_var_no'),
                                    ),
                                    'return' => true,
                                    'extra_atr' => '',
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_section_nopadding'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_no_padding_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_section_nopadding,
                                    'id' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_nopadding[]',
                                    'classes' => 'select_dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                                        'no' => automobile_var_frame_text_srt('automobile_var_no'),
                                    ),
                                    'return' => true,
                                    'extra_atr' => '',
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_section_nomargin'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_no_margin_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_section_nomargin,
                                    'id' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_nomargin[]',
                                    'classes' => 'select_dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                                        'no' => automobile_var_frame_text_srt('automobile_var_no'),
                                    ),
                                    'return' => true,
                                    'extra_atr' => '',
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);


                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_select_view'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_section_view,
                                    'id' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_view[]',
                                    'classes' => 'select_dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'container' => automobile_var_frame_text_srt('automobile_var_box'),
                                        'wide' => automobile_var_frame_text_srt('automobile_var_wide'),
                                    ),
                                    'return' => true,
                                    'extra_atr' => '',
                                ),
                            );
                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_bg_color'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_choose_bg_coor'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_section_bg_color),
                                    'cust_id' => '',
                                    'classes' => 'bg_color',
                                    'cust_name' => 'automobile_section_bg_color[]',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            //range
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_padding_top'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_padding_top_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_section_padding_top),
                                    'id' => '',
                                    'classes' => 'small',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_padding_top[]',
                                    'return' => true,
                                    'required' => false,
                                    'after' => '<span class="automobile_form_px">(px)</span>',
                                ),
                                'return' => true,
                                'extra_atr' => '',
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_padding_bot'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_padding_bot_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_section_padding_bottom),
                                    'id' => '',
                                    'classes' => '',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_padding_bottom[]',
                                    'return' => true,
                                    'required' => false,
                                    'after' => '<span class="automobile_form_px">(px)</span>',
                                ),
                                'return' => true,
                                'extra_atr' => '',
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_margin_top'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_margin_top_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_section_margin_top),
                                    'id' => '',
                                    'classes' => '',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_margin_top[]',
                                    'return' => true,
                                    'required' => false,
                                    'after' => '<span class="automobile_form_px">(px)</span>',
                                ),
                                'return' => true,
                                'extra_atr' => '',
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_margin_bot'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_margin_bot_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_section_margin_bottom),
                                    'id' => '',
                                    'classes' => '',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_margin_bottom[]',
                                    'return' => true,
                                    'required' => false,
                                    'after' => '<span class="automobile_form_px">(px)</span>',
                                ),
                                'return' => true,
                                'extra_atr' => '',
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_border_top'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_border_top_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => absint($automobile_section_border_top),
                                    'id' => '',
                                    'classes' => '',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_border_top[]',
                                    'return' => true,
                                    'required' => false,
                                    'after' => '<span class="automobile_form_px">(px)</span>',
                                ),
                                'return' => true,
                                'extra_atr' => '',
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_border_bot'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_border_bot_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => absint($automobile_section_border_bottom),
                                    'id' => '',
                                    'classes' => '',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'automobile_section_border_bottom[]',
                                    'return' => true,
                                    'required' => false,
                                    'after' => '<span class="automobile_form_px">(px)</span>',
                                ),
                                'return' => true,
                                'extra_atr' => '',
                            );
                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_border_color'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_choose_border_color'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_section_border_color),
                                    'cust_id' => '',
                                    'classes' => 'bg_color',
                                    'cust_name' => 'automobile_section_border_color[]',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            $choose_id = '';
                            $automobile_opt_array = array(
                                'name' => automobile_var_frame_text_srt('automobile_var_cus_id'),
                                'desc' => '',
                                'hint_text' => automobile_var_frame_text_srt('automobile_var_cus_id_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_section_css_id),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'automobile_section_css_id[]',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            ?>

                            <div class="form-elements elementhiddenn">
                                <ul class="noborder">
                                    <li class="to-label">
                                        <label><?php echo automobile_var_frame_text_srt('automobile_var_select_layout'); ?></label>
                                    </li>
                                    <li class="to-field">
                                        <div class="meta-input">
                                            <div class="meta-input pattern">
                                                <div class='radio-image-wrapper'>

                                                    <?php
                                                    $checked = '';
                                                    if ($automobile_layout == "none") {
                                                        $checked = "checked";
                                                    }
                                                    $automobile_opt_array = array(
                                                        'extra_atr' => 'onclick="show_sidebar(\'none\',\'' . esc_js($randomno) . '\')" ' . $checked . '',
                                                        'cust_name' => 'automobile_layout[' . esc_attr($rand) . '][]',
                                                        'cust_id' => 'radio_1' . esc_attr($randomno),
                                                        'classes' => 'radio_automobile_sidebar',
                                                        'std' => 'none',
                                                    );
                                                    $automobile_var_form_fields->automobile_var_form_radio_render($automobile_opt_array);
                                                    ?>
                                                    <label for="radio_1<?php echo esc_attr($randomno) ?>"> 
                                                        <span class="ss"> <img src="<?php echo automobile_var_frame()->plugin_url() . 'assets/images/no_sidebar.png'; ?>"  alt="" />  </span>
                                                        <span  <?php
                                                        if ($automobile_layout == "none") {
                                                            echo "class='check-list'";
                                                        }
                                                        ?> id="check-list"></span> 
                                                    </label>
                                                </div>
                                                <div class='radio-image-wrapper'>

                                                    <?php
                                                    $checked = '';
                                                    if ($automobile_layout == "right") {
                                                        $checked = "checked";
                                                    }
                                                    $automobile_opt_array = array(
                                                        'extra_atr' => 'onclick="show_sidebar(\'right\',\'' . esc_js($randomno) . '\')" ' . $checked . '',
                                                        'cust_name' => 'automobile_layout[' . esc_attr($rand) . '][]',
                                                        'cust_id' => 'radio_2' . esc_attr($randomno),
                                                        'classes' => 'radio_automobile_sidebar',
                                                        'std' => 'right',
                                                    );
                                                    $automobile_var_form_fields->automobile_var_form_radio_render($automobile_opt_array);
                                                    ?>

                                                    <label for="radio_2<?php echo esc_attr($randomno) ?>"> 
                                                        <span class="ss"><img src="<?php echo automobile_var_frame()->plugin_url() . 'assets/images/sidebar_right.png'; ?>" alt="" /></span> 
                                                        <span <?php
                                                        if ($automobile_layout == "right") {
                                                            echo "class='check-list'";
                                                        }
                                                        ?> id="check-list"></span> 
                                                    </label>
                                                </div>
                                                <div class='radio-image-wrapper'>

                                                    <?php
                                                    $checked = '';
                                                    if ($automobile_layout == "left") {
                                                        $checked = "checked";
                                                    }
                                                    $automobile_opt_array = array(
                                                        'extra_atr' => 'onclick="show_sidebar(\'left\',\'' . esc_js($randomno) . '\')" ' . $checked . '',
                                                        'cust_name' => 'automobile_layout[' . esc_attr($rand) . '][]',
                                                        'cust_id' => 'radio_3' . esc_attr($randomno),
                                                        'classes' => 'radio_automobile_sidebar',
                                                        'std' => 'left',
                                                    );

                                                    $automobile_var_form_fields->automobile_var_form_radio_render($automobile_opt_array);
                                                    ?>
                                                    <label for="radio_3<?php echo esc_attr($randomno); ?>">
                                                        <span class="ss">
                                                            <img src="<?php echo automobile_var_frame()->plugin_url() . 'assets/images/sidebar_left.png'; ?>" alt="" /></span> <span <?php
                                                        if ($automobile_layout == "left") {
                                                            echo "class='check-list'";
                                                        }
                                                        ?> id="check-list">
                                                        </span> 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <?php
                                $display = 'none';
                                if ($automobile_layout == "left") {
                                    $display = "block";
                                }

                                global $wpdb;
                                $automobile_var_options = get_option('automobile_var_options');
                                $a_option = array();
                                if (isset($automobile_var_options['automobile_var_sidebar']) && count($automobile_var_options['automobile_var_sidebar']) > 0) {
                                    foreach ($automobile_var_options['automobile_var_sidebar'] as $sidebar) {
                                        $a_option[sanitize_title($sidebar)] = esc_html($sidebar);
                                    }
                                }

                                $automobile_opt_array = array(
                                    'name' => automobile_var_frame_text_srt('automobile_var_left_sidebar'),
                                    'desc' => '',
                                    'classes' => 'meta-body',
                                    'styles' => 'display:' . $display,
                                    'extra_atr' => '',
                                    'id' => esc_attr($randomno) . '_sidebar_left',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_sidebar_left,
                                        'id' => '',
                                        'cust_name' => 'automobile_sidebar_left[]',
                                        'classes' => 'dropdown chosen-select-no-single select-medium',
                                        'options' => $a_option,
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                                $display = 'none';
                                if ($automobile_layout == "right") {
                                    $display = "block";
                                }
                                $a_option = array();
                                if (isset($automobile_var_options['automobile_var_sidebar']) and count($automobile_var_options['automobile_var_sidebar']) > 0) {
                                    foreach ($automobile_var_options['automobile_var_sidebar'] as $sidebar) {
                                        $a_option[sanitize_title($sidebar)] = esc_attr($sidebar);
                                    }
                                }

                                $automobile_opt_array = array(
                                    'name' => automobile_var_frame_text_srt('automobile_var_right_sidebar'),
                                    'desc' => '',
                                    'classes' => 'meta-body',
                                    'styles' => 'display:' . $display,
                                    'extra_atr' => '',
                                    'id' => esc_attr($randomno) . '_sidebar_right',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $automobile_sidebar_right,
                                        'id' => '',
                                        'cust_name' => 'automobile_sidebar_right[]',
                                        'classes' => 'dropdown chosen-select-no-single select-medium',
                                        'options' => $a_option,
                                        'return' => true,
                                    ),
                                );

                                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                                ?>

                            </div>
                            <?php
                            $automobile_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => 'Save',
                                    'cust_id' => '',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-admin-btn',
                                    'cust_name' => '',
                                    'extra_atr' => 'onclick="javascript:automobile_frame_removeoverlay(\'' . esc_js($column_class . $randomno) . '\', \'filterdrag\')"',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            ?>   
                        </div>
                    </div>
                </div>

                <?php
                $automobile_opt_array = array(
                    'std' => esc_attr($rand),
                    'id' => '',
                    'before' => '',
                    'after' => '',
                    'classes' => '',
                    'extra_atr' => '',
                    'cust_id' => '',
                    'cust_name' => 'column_rand_id[]',
                    'required' => false
                );
                $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

                $automobile_opt_array = array(
                    'std' => esc_attr($column_class),
                    'id' => '',
                    'before' => '',
                    'after' => '',
                    'classes' => '',
                    'extra_atr' => '',
                    'cust_id' => '',
                    'cust_name' => 'column_class[]',
                    'required' => false
                );
                $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);

                $automobile_opt_array = array(
                    'std' => esc_attr($total_column),
                    'id' => '',
                    'before' => '',
                    'after' => '',
                    'classes' => '',
                    'extra_atr' => '',
                    'cust_id' => '',
                    'cust_name' => 'total_column[]',
                    'required' => false
                );
                $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
                ?>                   


            </div>

            <?php
        }

        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_automobile_column_pb', 'automobile_column_pb');
}


/**
 * @Shortcode For Popup
 *
 */
add_action('media_buttons', 'automobile_shortcode_popup', 11);

if (!function_exists('automobile_shortcode_popup')) {

    function automobile_shortcode_popup($die = 0, $shortcode = 'shortcode') {
        global $automobile_var_frame_static_text;
        $automobile_var_add_element = automobile_var_frame_text_srt('automobile_var_add_element');
        $automobile_var_filter_by = automobile_var_frame_text_srt('automobile_var_filter_by');
        $automobile_var_search = automobile_var_frame_text_srt('automobile_var_search');
        $automobile_var_show_all = automobile_var_frame_text_srt('automobile_var_show_all');
        $automobile_var_insert_sc = automobile_var_frame_text_srt('automobile_var_insert_sc');

        $i = 1;
        $style = '';
        if (isset($_POST['action'])) {
            $name = $_POST['action'];
            $automobile_counter = $_POST['counter'];
            $rand = $randomno = rand(1345, 9999);
            $style = '';
        } else {
            $name = '';
            $automobile_counter = '';
            $rand = $randomno = rand(1345, 9999);
            if (isset($_REQUEST['action']))
                $name = $_REQUEST['action'];
            $style = 'style="display:none;"';
        }
        $automobile_page_elements_name = array();
        $automobile_page_elements_name = automobile_shortcode_names();
        $automobile_page_categories_name = automobile_elements_categories();
        ?> 
        <div class="cs-page-composer  <?php echo sanitize_html_class($shortcode); ?> composer-<?php echo intval($rand) ?>" id="composer-<?php echo intval($rand) ?>" style="display:none">
            <div class="page-elements">
                <div class="cs-heading-area">
                    <h5>
                        <i class="icon-plus-circle"></i> <?php echo esc_html($automobile_var_add_element); ?>
                    </h5>
                    <span class='cs-btnclose' onclick='javascript:automobile_frame_removeoverlay("composer-<?php echo esc_js($rand) ?>", "append")'>
                        <i class="icon-times"></i>
                    </span>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        automobile_page_composer_filterable('<?php echo esc_js($rand) ?>');
                    });
                </script>
                <div class="cs-filter-content shortcode">
                    <p><input type="text" id="quicksearch<?php echo intval($rand) ?>" placeholder="<?php echo esc_html($automobile_var_search); ?>" /></p>
                    <div class="cs-filtermenu-wrap">
                        <h6><?php echo esc_html($automobile_var_filter_by); ?></h6>
                        <ul class="cs-filter-menu" id="filters<?php echo intval($rand) ?>">
                            <li data-filter="all" class="active"><?php echo esc_html($automobile_var_show_all); ?></li>
                            <?php
                            foreach ($automobile_page_categories_name as $key => $value) {
                                echo '<li data-filter="' . $key . '">' . $value . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="cs-filter-inner" id="page_element_container<?php echo intval($rand) ?>">
                        <?php
                        foreach ($automobile_page_elements_name as $key => $value) {
                            echo '<div class="element-item ' . $value['categories'] . '">';
                            $icon = isset($value['icon']) ? $value['icon'] : 'accordion-icon';
                            ?>
                            <a href='javascript:automobile_shortocde_selection("<?php echo esc_js($key); ?>","<?php echo admin_url('admin-ajax.php'); ?>","composer-<?php echo intval($rand) ?>")'><?php automobile_page_composer_elements($value['title'], $icon) ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="cs-page-composer-shortcode"></div>
        </div>
        <?php
        if (isset($shortcode) && $shortcode <> '') {
            ?>
            <a class="button" href="javascript:automobile_frame_createpop('composer-<?php echo esc_js($rand) ?>', 'filter')">
                <i class="icon-plus-circle"></i> <?php echo esc_html($automobile_var_insert_sc); ?></a>
            <?php
        }
    }

}


/**
 * @Width sizes for Elements
 *
 */
if (!function_exists('automobile_var_page_builder_element_sizes')) {

    function automobile_var_page_builder_element_sizes($size = '100') {

        if (isset($size) && $size == '') {
            $element_size = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
        } else {
            $element_size_col = $size;
        }

        if (isset($element_size_col) and $element_size_col == '100' || $element_size_col > 75) {

            $element_size = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
        } else if (isset($element_size_col) and $element_size_col == '75' || $element_size_col > 67) {

            $element_size = 'col-lg-9 col-md-9 col-sm-12 col-xs-12';
        } else if (isset($element_size_col) and $element_size_col == '67' || $element_size_col > 50) {

            $element_size = 'col-lg-8 col-md-8 col-sm-12 col-xs-12';
        } else if (isset($element_size_col) and $element_size_col == '50' || $element_size_col > 33) {

            $element_size = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
        } else if (isset($element_size_col) and $element_size_col == '33' || $element_size_col > 25) {

            $element_size = 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
        } else if (isset($element_size_col) and $element_size_col == '25' || $element_size_col < 25) {

            $element_size = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
        }

        return $element_size;
    }

}


/**
 * @Shortcode Names for Elements
 *
 */
if (!function_exists('automobile_shortcode_names')) {
	
    function automobile_shortcode_names() {
        global $post, $automobile_var_frame_static_text;
		$strings = new automobile_var_frame_all_strings;
		$strings->automobile_var_frame_all_string_all();
		
        $shortcode_array['team'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_team'),
            'name' => 'team',
            'icon' => 'icon-user',
            'categories' => 'loops',
        );
        $shortcode_array['list'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_list'),
            'name' => 'list',
            'icon' => 'icon-newspaper',
            'categories' => 'typography',
        );
        $shortcode_array['clients'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_clients'),
            'name' => 'clients',
            'icon' => 'icon-user3',
            'categories' => 'loops',
        );
        $shortcode_array['button'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_button'),
            'name' => 'button',
            'icon' => 'icon-support2',
            'categories' => 'typography',
        );
        $shortcode_array['tabs'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_tabs'),
            'name' => 'tabs',
            'icon' => 'icon-tab',
            'categories' => 'contentblocks',
            'desc' => automobile_var_frame_text_srt('automobile_var_tabs_desc'),
        );
        $shortcode_array['contact_form'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_contact_form'),
            'name' => 'contact_form',
            'icon' => 'icon-building-o',
            'categories' => 'typography',
        );
        
        $shortcode_array['schedule'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_schedule_form'),
            'name' => 'schedule',
            'icon' => 'icon-building-o',
            'categories' => 'contentblocks',
        );
        $shortcode_array['call_to_action'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_call_action'),
            'name' => 'call_to_action',
            'icon' => 'fa icon-info-circle',
            'categories' => 'typography',
        );
        $shortcode_array['map'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_map'),
            'name' => 'map',
            'icon' => 'icon-location2',
            'categories' => 'contentblocks',
        );
        $shortcode_array['accordion'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_accordian'),
            'name' => 'accordion',
            'icon' => 'icon-list-ul',
            'categories' => 'contentblocks',
        );
        $shortcode_array['faq'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_faq'),
            'name' => 'faq',
            'icon' => 'icon-list-ul',
            'categories' => 'contentblocks',
        );

        $shortcode_array['progressbars'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_progressbars'),
            'name' => 'progressbars',
            'icon' => 'icon-list-alt',
            'categories' => ' loops',
        );
        $shortcode_array['icon_box'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_icon_boxs_title'),
            'name' => 'icon_box',
            'icon' => 'icon-database2',
            'categories' => 'loops',
        );
        
        $shortcode_array['editor'] = array(
            'title' => automobile_var_frame_text_srt('automobile_var_editor'),
            'name' => 'editor',
            'icon' => 'icon-clock-o',
            'categories' => 'typography',
        );
        
        if (class_exists('automobile_var')) {

            $shortcode_array['testimonial'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_testimonial'),
                'name' => 'testimonial',
                'icon' => 'icon-comments-o',
                'categories' => 'loops',
            );

            $shortcode_array['blog'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_blog'),
                'name' => 'blog',
                'icon' => 'icon-newspaper',
                'categories' => 'loops',
            );

            $shortcode_array['divider'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_divider'),
                'name' => 'divider',
                'icon' => 'icon-ellipsis-h',
                'categories' => 'typography',
            );
            $shortcode_array['spacer'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_spacer'),
                'name' => 'spacer',
                'icon' => 'icon-ellipsis-h',
                'categories' => 'contentblocks',
            );

            $shortcode_array['flex_column'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_column'),
                'name' => 'flex_column',
                'icon' => 'icon-columns',
                'categories' => 'typography',
            );
            $shortcode_array['sitemap'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_sitemap'),
                'name' => 'sitemap',
                'icon' => 'icon-arrows-v',
                'categories' => 'typography',
            );

            $shortcode_array['image_frame'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_image_frame'),
                'name' => 'image_frame',
                'icon' => 'icon-photo',
                'categories' => 'typography',
            );
            
            $shortcode_array['table'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_table'),
                'name' => 'table',
                'icon' => 'icon-th',
                'categories' => 'contentblocks',
            );

            $shortcode_array['video'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_video'),
                'name' => 'video',
                'icon' => 'icon-video2',
                'categories' => 'contentblocks',
            );

            $shortcode_array['compare_inventories'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_compare_inventories'),
                'name' => 'compare_inventories',
                'icon' => 'icon-compare',
                'categories' => 'wpam',
            );
            $shortcode_array['inventories'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_inventories'),
                'name' => 'inventories',
                'icon' => 'icon-car',
                'categories' => 'wpam',
            );
            $shortcode_array['inventories_search'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_inventories_search'),
                'name' => 'inventories_search',
                'icon' => 'icon-search2',
                'categories' => 'wpam',
            );


            $shortcode_array['counter'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_multiple_counter'),
                'name' => 'counter',
                'icon' => 'icon-navicon',
                'categories' => 'loops',
            );
            
            $shortcode_array['quote'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_quote'),
                'name' => 'quote',
                'icon' => 'icon-comments-o',
                'categories' => 'typography',
            );
			
			$shortcode_array['dropcap'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_dropcap'),
                'name' => 'dropcap',
                'icon' => 'icon-comments-o',
                'categories' => 'typography',
            );

            $shortcode_array['heading'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_heading'),
                'name' => 'heading',
                'icon' => 'icon-header',
                'categories' => 'contentblocks',
            );

            $shortcode_array['price_table'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_price_plan'),
                'name' => 'price_table',
                'icon' => 'icon-briefcase',
                'categories' => 'contentblocks',
            );
            $shortcode_array['dealer'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_dealer'),
                'name' => 'dealer',
                'icon' => 'icon-briefcase',
                'categories' => 'wpam',
            );
            $shortcode_array['inventory_type'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_inventory_type'),
                'name' => 'inventory_type',
                'icon' => 'icon-table',
                'categories' => 'wpam',
            );
            $shortcode_array['package'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_packages'),
                'name' => 'package',
                'icon' => 'icon-table',
                'categories' => 'wpam',
            );
            $shortcode_array['tweets'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_tweets'),
                'name' => 'tweets',
                'icon' => 'icon-twitter2',
                'categories' => 'loops',
            );

            $shortcode_array['register'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_register_heading'),
                'name' => 'register',
                'icon' => 'icon-home',
                'categories' => 'wpam',
            );
        }
        if (class_exists('wp_automobile_framework')) {
            $shortcode_array['maintenance'] = array(
                'title' => automobile_var_frame_text_srt('automobile_var_maintenance'),
                'name' => 'maintenance',
                'icon' => 'icon-gears',
                'categories' => 'typography',
            );
        }

        ksort($shortcode_array);
        return $shortcode_array;
    }

}


/**
 * @List of the elements in Page Builder
 *
 */
if (!function_exists('automobile_element_list')) {

    function automobile_element_list() {

        global $automobile_var_frame_static_text;
		$strings = new automobile_var_frame_all_strings;
		$strings->automobile_var_frame_all_string_all();
		
        $element_list = array();
        $element_list['element_list'] = array(
            'team' => automobile_var_frame_text_srt('automobile_var_team'),
            'package' => automobile_var_frame_text_srt('automobile_var_packages'),
            'counter' => automobile_var_frame_text_srt('automobile_var_multiple_counter'),
            'inventory_type' => automobile_var_frame_text_srt('automobile_var_inventory_type'),
            'flex_column' => automobile_var_frame_text_srt('automobile_var_column'),
            'contact_form' => automobile_var_frame_text_srt('automobile_var_contact_form'),
            'schedule' => automobile_var_frame_text_srt('automobile_var_schedule_form'),
            'inventories' => automobile_var_frame_text_srt('automobile_var_inventories'),
            'compare_inventories' => automobile_var_frame_text_srt('automobile_var_compare_inventories'),
            'inventories_search' => automobile_var_frame_text_srt('automobile_var_inventories_search'),
            'inventories search' => automobile_var_frame_text_srt('automobile_var_inventories_search'),
            'gallery' => automobile_var_frame_text_srt('automobile_var_gallery'),
            'blog' => automobile_var_frame_text_srt('automobile_var_blog'),
            'tabs' => automobile_var_frame_text_srt('automobile_var_tabs'),
            'ads' => automobile_var_frame_text_srt('automobile_var_ads_only'),
            'tweets' => automobile_var_frame_text_srt('automobile_var_tweets'),
            'icon_box' => automobile_var_frame_text_srt('automobile_var_icon_boxs_title'),
            'testimonial' => automobile_var_frame_text_srt('automobile_var_testimonial'),
            'accordion' => automobile_var_frame_text_srt('automobile_var_accordion'),
            'faq' => automobile_var_frame_text_srt('automobile_var_faq'),
            'progressbars' => automobile_var_frame_text_srt('automobile_var_progressbars'),
            'clients' => automobile_var_frame_text_srt('automobile_var_clients'),
            'price_table' => automobile_var_frame_text_srt('automobile_var_price_plan'),
            'map' => automobile_var_frame_text_srt('automobile_var_map'),
            'quote' => automobile_var_frame_text_srt('automobile_var_quote'),
            'dropcap' => automobile_var_frame_text_srt('automobile_var_dropcap'),
            'divider' => automobile_var_frame_text_srt('automobile_var_divider'),
            'heading' => automobile_var_frame_text_srt('automobile_var_heading'),
            'promobox' => automobile_var_frame_text_srt('automobile_var_promobox'),
            'automobile_heading' => automobile_var_frame_text_srt('automobile_var_auto_heading'),
            'video' => automobile_var_frame_text_srt('automobile_var_video'),
            'table' => automobile_var_frame_text_srt('automobile_var_table'),
            'partner' => automobile_var_frame_text_srt('automobile_var_partner'),
            'automobile_image_frame' => automobile_var_frame_text_srt('automobile_var_image_frame'),
            'button' => automobile_var_frame_text_srt('automobile_var_button'),
            'listing_price' => automobile_var_frame_text_srt('automobile_var_listing_price'),
            'spacer' => automobile_var_frame_text_srt('automobile_var_spacer'),
            'image_frame' => automobile_var_frame_text_srt('automobile_var_image_frame'),
            'flex_editor' => automobile_var_frame_text_srt('automobile_var_flex_editor'),
            'call_to_action' => automobile_var_frame_text_srt('automobile_var_call_action'),
            'maintenance' => automobile_var_frame_text_srt('automobile_var_maintenance'),
            'price_services' => automobile_var_frame_text_srt('automobile_var_price_services'),
            'list' => automobile_var_frame_text_srt('automobile_var_list'),
            'contact_info' => automobile_var_frame_text_srt('automobile_var_contact_info'),
            'dealer' => automobile_var_frame_text_srt('automobile_var_dealer'),
            'sitemap' => automobile_var_frame_text_srt('automobile_var_sitemap'),
            'register' => automobile_var_frame_text_srt('automobile_var_register'),
            'editor' => automobile_var_frame_text_srt('automobile_var_editor'),
        );
        return $element_list;
    }

}

/**
 * @Page builder Sorting List
 */
if (!function_exists('automobile_elements_categories')) {

    function automobile_elements_categories() {
        global $automobile_var_frame_static_text;
        $strings = new automobile_var_frame_all_strings;
        $automobile_var_typography = automobile_var_frame_text_srt('automobile_var_typography');
        //$automobile_var_common_elements = automobile_var_frame_text_srt('automobile_var_common_elements');
        //$automobile_var_media_element = automobile_var_frame_text_srt('automobile_var_media_element');
        $automobile_var_content_blocks = automobile_var_frame_text_srt('automobile_var_content_blocks');
        $automobile_var_loops = automobile_var_frame_text_srt('automobile_var_loops');
        $automobile_var_wpam = automobile_var_frame_text_srt('automobile_var_wpam');
        return array('typography' => $automobile_var_typography, 'contentblocks' => $automobile_var_content_blocks, 'loops' => $automobile_var_loops, 'wpam' => $automobile_var_wpam);
    }

}

/*
 * @Page builder Element (shortcode(s))
 */
if (!function_exists('automobile_page_composer_elements')) {

    function automobile_page_composer_elements($element = '', $icon = '', $description = '') {
        echo '<i class="' . $icon . '"></i><span data-title="' . esc_html($element) . '"> ' . esc_html($element) . '</span>';
    }

}

/**
 * @Section element Size(s)
 *
 * @returm size
 */
if (!function_exists('automobile_element_size_data_array_index')) {

    function automobile_element_size_data_array_index($size) {
        if ($size == "" or $size == 100) {
            return 0;
        } else if ($size == 75) {
            return 1;
        } else if ($size == 67) {
            return 2;
        } else if ($size == 50) {
            return 3;
        } else if ($size == 33) {
            return 4;
        } else if ($size == 25) {
            return 5;
        }
    }

}

/**
 * @Page Builder Elements Settings
 *
 */
if (!function_exists('automobile_element_setting')) {

    function automobile_element_setting($name, $automobile_counter, $element_size, $element_description = '', $page_element_icon = 'icon-star', $type = '') {

        global $automobile_var_form_fields;
        $element_title = str_replace("automobile_var_page_builder_", "", $name);
        $elm_name = str_replace("automobile_var_page_builder_", "", $name);
        $element_list = automobile_element_list();
        $all_shortcode_list = automobile_shortcode_names();
        $current_shortcode_name = str_replace("automobile_var_page_builder_", "", $name);
        $current_shortcode_detail = $all_shortcode_list[$current_shortcode_name];
        $shortcode_icon = isset($current_shortcode_detail['icon']) ? $current_shortcode_detail['icon'] : '';
        ?>

        <div class="column-in">
            <?php
            $automobile_opt_array = array(
                'std' => esc_attr($element_size),
                'id' => '',
                'before' => '',
                'after' => '',
                'classes' => 'item',
                'extra_atr' => '',
                'cust_id' => '',
                'cust_name' => esc_attr($element_title) . '_element_size[]',
                'required' => false
            );
            $automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array);
            ?>
            <a href="javascript:;" onclick="javascript:automobile_createpopshort(jQuery(this))" class="options"><i class="icon-gear"></i></a>
            <a href="#" class="delete-it btndeleteit"><i class="icon-trash-o"></i></a> &nbsp;
            <a class="decrement" onclick="javascript:automobile_decrement(this)"><i class="icon-minus3"></i></a> &nbsp; 
            <a class="increment" onclick="javascript:automobile_increment(this)"><i class="icon-plus3"></i></a> 
            <span> 
                <i class="<?php echo $shortcode_icon . ' ' . str_replace("automobile_var_page_builder_", "", $name); ?>-icon"></i> 
                <strong><?php echo esc_html($element_list['element_list'][$elm_name]); ?></strong><br/>
                <?php echo esc_attr($element_description); ?> 
            </span>
        </div>
        <?php
    }

}

/**
 * @Sizes for Shortcodes elements
 *
 */
if (!function_exists('automobile_shortcode_element_size')) {

    function automobile_shortcode_element_size($column_size = '') {

        global $automobile_var_html_fields, $automobile_var_frame_static_text;

        $automobile_opt_array = array(
            'name' => automobile_var_frame_text_srt('automobile_var_size'),
            'desc' => '',
            'hint_text' => automobile_var_frame_text_srt('automobile_var_column_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => $column_size,
                'cust_id' => 'column_size',
                'cust_type' => 'button',
                'classes' => 'column_size  dropdown chosen-select-no-single select-medium',
                'cust_name' => 'automobile_var_column_size[]',
                'extra_atr' => '',
                'options' => array(
                    '1/1' => automobile_var_frame_text_srt('automobile_var_full_width'),
                    '1/2' => automobile_var_frame_text_srt('automobile_var_one_half'),
                    '1/3' => automobile_var_frame_text_srt('automobile_var_one_third'),
                    '2/3' => automobile_var_frame_text_srt('automobile_var_two_third'),
                    '1/4' => automobile_var_frame_text_srt('automobile_var_one_fourth'),
                    '3/4' => automobile_var_frame_text_srt('automobile_var_three_fourth'),
                ),
                'return' => true,
            ),
        );

        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
    }

}

/**
 * @Adding Shortcode
 *
 */
if (!function_exists('automobile_var_short_code')) {

    function automobile_var_short_code($name = '', $function = '') {

        if ($name != '' && $function != '') {
            add_shortcode($name, $function);
        }
    }

}

/**
 * @Element Ajax Settings
 * @Size
 * @Remove
 *
 */
if (!function_exists('automobile_ajax_element_setting')) {

    function automobile_ajax_element_setting($name, $automobile_counter, $element_size, $shortcode_element_id, $automobile_POSTID, $element_description = '', $page_element_icon = '', $type = '') {
        global $automobile_node, $post;
        $element_title = str_replace("automobile_var_page_builder_", "", $name);
        $all_shortcode_list = automobile_shortcode_names();
        $current_shortcode_name = str_replace("automobile_var_page_builder_", "", $name);
        $current_shortcode_detail = $all_shortcode_list[$current_shortcode_name];
        $shortcode_icon = isset($current_shortcode_detail['icon']) ? $current_shortcode_detail['icon'] : '';
        ?>
        <div class="column-in">
            <input type="hidden" name="<?php echo esc_attr($element_title); ?>_element_size[]" class="item" value="<?php echo esc_attr($element_size); ?>" >

            <a href="javascript:;" onclick="javascript:ajax_shortcode_widget_element(jQuery(this), '<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($automobile_POSTID); ?>', '<?php echo esc_js($name); ?>')" class="options"><i class="icon-gear"></i></a><a href="#" class="delete-it btndeleteit"><i class="icon-trash-o"></i></a> &nbsp; <a class="decrement" onclick="javascript:automobile_decrement(this)"><i class="icon-minus3"></i></a> &nbsp; <a class="increment" onclick="javascript:automobile_increment(this)"><i class="icon-plus3"></i></a> 
            <span> 
                <i class="<?php echo $shortcode_icon . ' ' . str_replace("automobile_var_page_builder_", "", $name); ?>-icon"></i> 
                <strong>
                    <?php
                    if ($automobile_node->getName() == 'page_element') {
                        $element_name = $automobile_node->element_name;
                        $element_name = str_replace("cs-", "", $element_name);
                    } else {
                        $element_name = $automobile_node->getName();
                        $element_name = $all_shortcode_list[$element_name]['title'];
                    }
                    echo strtoupper(str_replace('_', ' ', $element_name));
                    ?>
                </strong><br/>
                <?php echo esc_attr($element_description); ?> 
            </span>
        </div>
        <?php
    }

}

/**
 * @Page Builder ELements all Categories
 *
 */
if (!function_exists('automobile_show_all_cats')) {

    function automobile_show_all_cats($parent, $separator, $selected = "", $taxonomy = '', $optional = '') {
        global $automobile_var_frame_static_text;

        if ($parent == "") {
            global $wpdb;
            $parent = 0;
        } else
            $separator .= " &ndash; ";
        $args = array(
            'parent' => $parent,
            'hide_empty' => 0,
            'taxonomy' => $taxonomy
        );
        $categories = get_categories($args);

        if ($optional) {
            $a_options = array();
            $a_options[''] = automobile_var_frame_text_srt('automobile_var_plz_select');
            foreach ($categories as $category) {
                $a_options[$category->slug] = $category->cat_name;
            }

            return $a_options;
			
        } else {
            foreach ($categories as $category) {
                ?>
                <option <?php
                if ($selected == $category->slug) {
                    echo "selected";
                }
                ?> value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_attr($separator . $category->cat_name); ?></option>
                    <?php
                    automobile_show_all_cats($category->term_id, $separator, $selected, $taxonomy);
                }
            }
        }

    }
    /**
     * @Bootstrap Coloumn Class
     *
     * @returm Coloumn
     */
    if (!function_exists('automobile_var_custom_column_class')) {

        function automobile_var_custom_column_class($column_size) {
            $coloumn_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
            if (isset($column_size) && $column_size <> '') {
                list($top, $bottom) = explode('/', $column_size);
                $width = $top / $bottom * 100;
                $width = (int) $width;
                $coloumn_class = '';
                if (round($width) == '25' || round($width) < 25) {
                    $coloumn_class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
                } elseif (round($width) == '33' || (round($width) < 33 && round($width) > 25)) {
                    $coloumn_class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
                } elseif (round($width) == '50' || (round($width) < 50 && round($width) > 33)) {
                    $coloumn_class = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
                } elseif (round($width) == '67' || (round($width) < 67 && round($width) > 50)) {
                    $coloumn_class = 'col-lg-8 col-md-12 col-sm-12 col-xs-12';
                } elseif (round($width) == '75' || (round($width) < 75 && round($width) > 67)) {
                    $coloumn_class = 'col-md-9 col-lg-9 col-sm-12 col-xs-12';
                } else {
                    $coloumn_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
                }
            }
            return esc_html($coloumn_class);
        }

    }

    /**
     * @Page Builder Element Data on Ajax Call
     *
     */
    if (!function_exists('automobile_shortcode_element_ajax_call')) {

        function automobile_shortcode_element_ajax_call() {
            global $post, $automobile_var_html_fields, $automobile_var_form_fields, $automobile_var_frame_static_text;


            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'testimonial') {
                $rand_id = rand(324335, 9234299);
                ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo esc_html(automobile_var_frame_text_srt('automobile_var_testimonial')); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(automobile_var_frame_text_srt('automobile_var_remove')); ?></a>
                </header>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_testimonial_text'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_text_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
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
                    'name' => automobile_var_frame_text_srt('automobile_var_author'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_author_hint'),
                    'echo' => true,
                    'classes' => 'txtfield',
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'automobile_var_testimonial_author[]',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_position'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_position_hint'),
                    'echo' => true,
                    'classes' => 'txtfield',
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'automobile_var_testimonial_position[]',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'std' => '',
                    'id' => 'testimonial_author_image',
                    'name' => automobile_var_frame_text_srt('automobile_var_image'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'prefix' => '',
                    'field_params' => array(
                        'std' => '',
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
        } elseif ($_POST['shortcode_element'] == 'accordion') {
            $automobile_var_active = automobile_var_frame_text_srt('automobile_var_active');
            $automobile_var_active_hint = automobile_var_frame_text_srt('automobile_var_active_hint');
            $automobile_var_accordion_title = automobile_var_frame_text_srt('automobile_var_accordion_title');
            $automobile_var_accordion_title_hint = automobile_var_frame_text_srt('automobile_var_accordion_title_hint');
            $automobile_var_accordion_text = automobile_var_frame_text_srt('automobile_var_accordion_text');
            $automobile_var_accordion_text_hint = automobile_var_frame_text_srt('automobile_var_accordion_text_hint');

            $rand_id = rand(324235, 993249);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_accordion'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>

                <div class="form-elements" id="automobile_infobox_<?php echo esc_attr($rand_id); ?>">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo automobile_var_frame_text_srt('automobile_var_accordion_icon'); ?></label>
                        <?php
                        if (function_exists('automobile_var_tooltip_helptext')) {
                            echo automobile_var_tooltip_helptext(automobile_var_frame_text_srt('automobile_var_accordion_icon_hint'));
                        }
                        ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo automobile_var_icomoon_icons_box('', esc_attr($rand_id), 'automobile_var_icon_box'); ?>
                    </div>
                </div>

                <?php
                $automobile_opt_array = array(
                    'name' => $automobile_var_active,
                    'desc' => '',
                    'hint_text' => $automobile_var_active_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => '',
                        'cust_name' => 'automobile_var_accordion_active[]',
                        'classes' => 'dropdown chosen-select',
                        'options' => array(
                            'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                            'no' => automobile_var_frame_text_srt('automobile_var_no'),
                        ),
                        'return' => true,
                    ),
                );



                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => $automobile_var_accordion_title,
                    'desc' => '',
                    'hint_text' => $automobile_var_accordion_title_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'accordion_title',
                        'cust_name' => 'automobile_var_accordion_title[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => $automobile_var_accordion_text,
                    'desc' => '',
                    'hint_text' => $automobile_var_accordion_text_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'automobile_var_accordion_text',
                        'cust_name' => 'automobile_var_accordion_text[]',
                        'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                        'return' => true,
                        'classes' => '',
                        'automobile_editor' => true
                    ),
                );
                $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
                ?>

            </div>

            <?php
        } elseif ($_POST['shortcode_element'] == 'faq') {
            $automobile_var_active = automobile_var_frame_text_srt('automobile_var_active');
            $automobile_var_faq_active_hint = automobile_var_frame_text_srt('automobile_var_faq_active_hint');
            $automobile_var_faq_title = automobile_var_frame_text_srt('automobile_var_faq_title');
            $automobile_var_faq_title_hint = automobile_var_frame_text_srt('automobile_var_faq_title_hint');
            $automobile_var_faq_text = automobile_var_frame_text_srt('automobile_var_faq_text');
            $automobile_var_faq_text_hint = automobile_var_frame_text_srt('automobile_var_faq_text_hint');

            $rand_id = rand(324235, 993249);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_faq'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>

                <div class="form-elements" id="automobile_infobox_<?php echo esc_attr($rand_id); ?>">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo automobile_var_frame_text_srt('automobile_var_faq_icon'); ?></label>
                        <?php
                        if (function_exists('automobile_var_tooltip_helptext')) {
                            echo automobile_var_tooltip_helptext(automobile_var_frame_text_srt('automobile_var_faq_icon_hint'));
                        }
                        ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo automobile_var_icomoon_icons_box('', esc_attr($rand_id), 'automobile_var_icon_box'); ?>
                    </div>
                </div>                                   
                <?php
                $automobile_opt_array = array(
                    'name' => $automobile_var_active,
                    'desc' => '',
                    'hint_text' => $automobile_var_faq_active_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => '',
                        'cust_name' => 'automobile_var_faq_active[]',
                        'classes' => 'dropdown chosen-select',
                        'options' => array(
                            'yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                            'no' => automobile_var_frame_text_srt('automobile_var_no'),
                        ),
                        'return' => true,
                    ),
                );



                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => $automobile_var_faq_title,
                    'desc' => '',
                    'hint_text' => $automobile_var_faq_title_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'faq_title',
                        'cust_name' => 'automobile_var_faq_title[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => $automobile_var_faq_text,
                    'desc' => '',
                    'hint_text' => $automobile_var_faq_text_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'automobile_var_faq_text',
                        'cust_name' => 'automobile_var_faq_text[]',
                        'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                        'return' => true,
                        'classes' => '',
                        'automobile_editor' => true
                    ),
                );
                $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
                ?>

            </div>

            <?php
        } elseif ($_POST['shortcode_element'] == 'list') {

            $rand_id = rand(23, 45453);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="automobile_list_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_list'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_list_Item'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_list_Item_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'list_item_text',
                        'cust_name' => 'automobile_var_list_item_text[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                ?>	 				

                <div class="icon_fields">
                    <div class="form-elements" id="automobile_infobox_<?php echo esc_attr($rand_id); ?>">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo automobile_var_frame_text_srt('automobile_var_icon'); ?></label>
                            <?php
                            if (function_exists('automobile_var_tooltip_helptext')) {
                                echo automobile_var_tooltip_helptext(automobile_var_frame_text_srt('automobile_var_icon_tooltip'));
                            }
                            ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <?php echo automobile_var_icomoon_icons_box('', $rand_id, 'automobile_var_list_item_icon'); ?>
                        </div>
                    </div>
                    <?php
                    $automobile_opt_array = array(
                        'name' => automobile_var_frame_text_srt('automobile_var_list_sc_icon_color'),
                        'desc' => '',
                        'hint_text' => automobile_var_frame_text_srt('automobile_var_list_sc_icon_color_hint'),
                        'echo' => true,
                        'field_params' => array(
                            'std' => '',
                            'id' => 'automobile_var_list_item_icon_color',
                            'cust_name' => 'automobile_var_list_item_icon_color[]',
                            'classes' => 'bg_color',
                            'return' => true,
                        ),
                    );
                    $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                    $automobile_opt_array = array(
                        'name' => automobile_var_frame_text_srt('automobile_var_list_sc_icon_bg_color'),
                        'desc' => '',
                        'hint_text' => automobile_var_frame_text_srt('automobile_var_list_sc_icon_bg_color_hint'),
                        'echo' => true,
                        'field_params' => array(
                            'std' => '',
                            'id' => 'automobile_var_list_item_icon_bg_color',
                            'cust_name' => 'automobile_var_list_item_icon_bg_color[]',
                            'classes' => 'bg_color',
                            'return' => true,
                        ),
                    );
                    $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                    ?>
                </div>
            </div>
            <script>
                popup_over();
                jQuery(document).ready(function ($) {
                    var getValue = $("#automobile_var_list_type option:selected").val();
                    $('.icon_fields').css('display', 'none');
                    if (getValue == 'icon') {
                        $('.icon_fields').css('display', 'block');
                    } else {
                        $('.icon_fields').css('display', 'none');
                    }
                });
            </script> 

            <?php
        } elseif (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'listing_price') {

            $rand_id = rand(324335, 9234299);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_listing_price'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php
                        echo esc_html($automobile_var_remove);
                        ;
                        ?></a>
                </header>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_title'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_listing_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'cust_name' => 'automobile_var_listing_price_text[]',
                        'return' => true,
                        'classes' => '',
                        'automobile_editor' => true
                    ),
                );

                $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_hint'),
                    'echo' => true,
                    'classes' => 'txtfield',
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'automobile_var_listing_price_author[]',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_color'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'automobile_var_listing_price_position',
                        'classes' => 'bg_color',
                        'cust_name' => 'automobile_var_listing_price_position[]',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                ?>

            </div>
            <?php
        }
        elseif ($_POST['shortcode_element'] == 'tabs') {

            $rand_id = rand(23, 45453);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="automobile_tabs_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_tab'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_tab_active'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_tab_active_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'tabs_item_text',
                        'cust_name' => 'automobile_var_tabs_active[]',
                        'classes' => 'dropdown chosen-select-no-single select-medium',
                        'options' => array('Yes' => automobile_var_frame_text_srt('automobile_var_yes'), 'No' => automobile_var_frame_text_srt('automobile_var_no')),
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_tab_item_text'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_tab_item_text_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'tabs_item_text',
                        'cust_name' => 'automobile_var_tabs_item_text[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                ?>
                <div class="form-elements" id="automobile_infobox_<?php echo esc_attr($rand_id); ?>">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo esc_html(automobile_var_frame_text_srt('automobile_var_tab_icon')); ?></label>
                        <?php
                        if (function_exists('automobile_var_tooltip_helptext')) {
                            echo automobile_var_tooltip_helptext(automobile_var_frame_text_srt('automobile_var_tab_icon_hint'));
                        }
                        ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo automobile_var_icomoon_icons_box('', $rand_id, 'automobile_var_tabs_item_icon'); ?>
                    </div>
                </div>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_tab_desc'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_tab_desc_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'automobile_var_tabs_desc',
                        'cust_name' => 'automobile_var_tabs_desc[]',
                        'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                        'return' => true,
                        'classes' => '',
                        'automobile_editor' => true
                    ),
                );

                $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
                ?>   


            </div>

            <?php
        } elseif (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'partner') {

            $rand_id = rand(335, 92342454599);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_partner'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php
                        echo automobile_var_frame_text_srt('automobile_var_remove');
                        ?></a>
                </header>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_image_url'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_image_url_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'cust_name' => 'automobile_var_partner_text[]',
                        'return' => true,
                        'classes' => '',
                        'automobile_editor' => true
                    ),
                );

                $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'std' => '',
                    'id' => 'partner_img_user',
                    'name' => automobile_var_frame_text_srt('automobile_var_image'),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => true,
                    'array' => true,
                    'prefix' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => 'partner_img_user',
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
        } elseif (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'clients') {

            $rand_id = rand(1234, 7894563);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_clients'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_image_url'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_image_url_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'cust_name' => 'automobile_var_clients_text[]',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'std' => '',
                    'id' => 'clients_img_user',
                    'name' => automobile_var_frame_text_srt('automobile_var_image'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'prefix' => '',
                    'field_params' => array(
                        'std' => '',
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
        } elseif (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'price_table') {

            $rand_id = rand(1234, 7894563);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_price_plan'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>
                <?php
                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_title'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_text',
                        'cust_name' => 'multi_price_table_text[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_title_color'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_title_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_title_color',
                        'cust_name' => 'multi_price_table_title_color[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_price'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_price_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_pricetable_price',
                        'cust_name' => 'multi_pricetable_price[]',
                        'classes' => 'txtfield',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_currency'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_currency_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_currency',
                        'cust_name' => 'multi_price_table_currency[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_time'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_time_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_time_duration',
                        'cust_name' => 'multi_price_table_time_duration[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_button_link'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_button_link_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'button_link',
                        'cust_name' => 'button_link[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_button_text'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_button_text_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_button_text',
                        'cust_name' => 'multi_price_table_button_text[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_button_color'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_button_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_button_color',
                        'cust_name' => 'multi_price_table_button_color[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_button_bg_color'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_button_bg_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_button_color_bg',
                        'cust_name' => 'multi_price_table_button_color_bg[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);



                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_featured'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_featured_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => '',
                        'cust_name' => 'pricetable_featured[]',
                        'classes' => 'dropdown chosen-select',
                        'options' => array(
                            'Yes' => automobile_var_frame_text_srt('automobile_var_yes'),
                            'No' => automobile_var_frame_text_srt('automobile_var_no'),
                        ),
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_description'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_description_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'automobile_var_price_table_text[]',
                        'return' => true,
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'classes' => '',
                        'automobile_editor' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);

                $automobile_opt_array = array(
                    'name' => automobile_var_frame_text_srt('automobile_var_price_table_column_color'),
                    'desc' => '',
                    'hint_text' => automobile_var_frame_text_srt('automobile_var_price_table_column_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'multi_price_table_column_bgcolor',
                        'cust_name' => 'multi_price_table_column_bgcolor[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );

                $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                ?>

            </div>
            <?php
        } elseif (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'counter') {
           
            $multiple_counter_count = 'multiple_counter_' . rand(455345, 23454390);
            if (isset($automobile_var_multi_counter_text) && $automobile_var_multi_counter_text != '') {
                $automobile_var_multi_counter_text = $automobile_var_multi_counter_text;
            } else {
                $automobile_var_multi_counter_text = '';
            }
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp' id="automobile_multi_counter_<?php echo automobile_allow_special_char($multiple_counter_count); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_multiple_counter'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php
            echo automobile_var_frame_text_srt('automobile_var_remove');
            ?></a>
                </header>

                <div class="form-elements" id="<?php echo esc_attr($multiple_counter_count); ?>">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo automobile_var_frame_text_srt('automobile_var_multiple_counter_icon'); ?></label>
            <?php
            if (function_exists('automobile_var_tooltip_helptext')) {
                echo automobile_var_tooltip_helptext(automobile_var_frame_text_srt('automobile_var_multiple_counter_icon_tooltip'));
            }
            ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <?php echo automobile_var_icomoon_icons_box('', $multiple_counter_count, 'automobile_var_icon'); ?>
                    </div>
                </div>


            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_multiple_counter_title'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_multiple_counter_title_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'automobile_var_title',
                    'classes' => '',
                    'cust_name' => 'automobile_var_title[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_multiple_counter_count'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_multiple_counter_count_tooltip'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'automobile_var_count',
                    'classes' => '',
                    'cust_name' => 'automobile_var_count[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_multiple_counter_content'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_multiple_counter_content_tooltip'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => '',
                    'cust_name' => 'automobile_var_multi_counter_text[]',
                    'return' => true,
                    'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                    'classes' => '',
                    'automobile_editor' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
            ?>
            </div>

            <?php
        } else if ($_POST['shortcode_element'] == 'progressbars') {
            $rand_id = rand(40, 9999999);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="automobile_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_progressbar'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_progressbar_title'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_progressbar_title_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'progressbars_title',
                    'cust_name' => 'progressbars_title[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_progressbar_skill'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_progressbar_skill_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '50',
                    'id' => 'progressbars_percentage',
                    'cust_name' => 'progressbars_percentage[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_progressbar_color'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_progressbar_color_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '#4d8b0c',
                    'id' => 'progressbars_color',
                    'cust_name' => 'progressbars_color[]',
                    'return' => true,
                    'classes' => 'bg_color',
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            ?>

            </div>

            <?php
        } elseif (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'team') {

            $rand_id = 'multiple_team_' . rand(455345, 23454390);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="automobile_infobox_<?php echo automobile_allow_special_char($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_team_sc'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a></header>
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_name'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_name_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_name',
                    'cust_name' => 'automobile_var_team_name[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_designation'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_designation_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_designation',
                    'cust_name' => 'automobile_var_team_designation[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'std' => '',
                'id' => 'team_image_array',
                'main_id' => 'team_image_array',
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_image'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_image_hint'),
                'echo' => true,
                'array' => true,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => '',
                    'cust_name' => 'automobile_var_team_image[]',
                    'id' => 'team_image_array',
                    'return' => true,
                    'array' => true,
                // 'array_txt' => false,
                ),
            );
            $automobile_var_html_fields->automobile_var_upload_file_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_phone'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_phone_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_phone',
                    'cust_name' => 'automobile_var_team_phone[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_fb'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_fb_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_fb',
                    'cust_name' => 'automobile_var_team_fb[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_twitter'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_twitter_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_twitter',
                    'cust_name' => 'automobile_var_team_twitter[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_google'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_google_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_google',
                    'cust_name' => 'automobile_var_team_google[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_linkedin'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_linkedin_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_linkedin',
                    'cust_name' => 'automobile_var_team_linkedin[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_team_sc_youtube'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_team_sc_youtube_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'team_youtube',
                    'cust_name' => 'automobile_var_team_youtube[]',
                    'classes' => '',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
            ?>

            </div>

            <?php
        } elseif (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'icon_box') {
            $icon_boxes_count = 'icon_boxes_' . rand(455345, 23454390);
            if (isset($automobile_var_icon_boxes_text) && $automobile_var_icon_boxes_text != '') {
                $automobile_var_icon_boxes_text = $automobile_var_icon_boxes_text;
            } else {
                $automobile_var_icon_boxes_text = '';
            }
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp' id="automobile_infobox_<?php echo automobile_allow_special_char($icon_boxes_count); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo automobile_var_frame_text_srt('automobile_var_icon_boxs_title'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo automobile_var_frame_text_srt('automobile_var_remove'); ?></a>
                </header>
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_icon_boxes_content_title'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_icon_boxes_content_title_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'automobile_var_icon_box_title',
                    'classes' => '',
                    'cust_name' => 'automobile_var_icon_box_title[]',
                    'return' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_icon_boxes_link_url'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_icon_boxes_link_url_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => 'automobile_var_link_url',
                    'classes' => '',
                    'cust_name' => 'automobile_var_link_url[]',
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);


            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_icon_box_icon_type'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_icon_box_icon_type_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'automobile_var_icon_box_icon_type',
                    'cust_name' => 'automobile_var_icon_box_icon_type[]',
                    //'extra_atr' => ' onchange=automobile_icon_box_view_change(this.value)',
                    'classes' => 'chosen-select-no-single select-medium function-class',
                    'options' => array(
                        'icon' => automobile_var_frame_text_srt('automobile_var_icon_box_icon_type_1'),
                        'image' => automobile_var_frame_text_srt('automobile_var_icon_box_icon_type_2'),
                    ),
                    'return' => true,
                ),
            );
            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
            $rand_id = rand(123450, 854987);
            ?>	 				

                <div class="cs-sh-icon_box-image-area" style="display:none;">
            <?php
            $automobile_opt_array = array(
                'std' => '',
                'id' => 'icon_box_image_array',
                'main_id' => 'icon_box_image_array',
                'name' => automobile_var_frame_text_srt('automobile_var_icon_box_image'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_icon_box_image_hint'),
                'echo' => true,
                'array' => true,
                'field_params' => array(
                    'std' => '',
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
                <div class="cs-sh-icon_box-icon-area" style="display:block;">
                    <div class="form-elements" id="<?php echo esc_attr($rand_id); ?>">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo automobile_var_frame_text_srt('automobile_var_icon_boxes_Icon'); ?></label>
            <?php
            if (function_exists('automobile_var_tooltip_helptext')) {
                echo automobile_var_tooltip_helptext(automobile_var_frame_text_srt('automobile_var_icon_boxes_Icon_hint'));
            }
            ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <?php echo automobile_var_icomoon_icons_box('', $rand_id, 'automobile_var_icon_boxes_icon'); ?>
                        </div>
                    </div>

                </div>
            <?php
            $automobile_opt_array = array(
                'name' => automobile_var_frame_text_srt('automobile_var_icon_boxes_text'),
                'desc' => '',
                'hint_text' => automobile_var_frame_text_srt('automobile_var_icon_boxes_text_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'cust_id' => '',
                    'cust_name' => 'automobile_var_icon_boxes_text[]',
                    'return' => true,
                    'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                    'classes' => '',
                    'automobile_editor' => true,
                ),
            );

            $automobile_var_html_fields->automobile_var_textarea_field($automobile_opt_array);
            ?>
            </div>
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
            <?php
        }




        die;
    }

    add_action('wp_ajax_automobile_shortcode_element_ajax_call', 'automobile_shortcode_element_ajax_call');
}


if (!function_exists('automobile_custom_shortcode_encode')) {

    function automobile_custom_shortcode_encode($sh_content = '') {
        $sh_content = str_replace(array('[', ']'), array('automobile_open', 'automobile_close'), $sh_content);
        return $sh_content;
    }

}


if (!function_exists('cs_widget_register')) {

    function cs_widget_register($name) {

        add_action('widgets_init', function() use ($name) {
            return register_widget($name);
        });
    }

}