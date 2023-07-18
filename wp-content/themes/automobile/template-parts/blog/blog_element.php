<?php
/**
 * @ Blog html form for page builder admin side
 *
 *
 */
if (!function_exists('automobile_var_page_builder_blog')) {

    function automobile_var_page_builder_blog($die = 0) {
        global $automobile_var_node, $post, $automobile_var_html_fields, $automobile_var_form_fields,$automobile_var_static_text;
        $strings = new automobile_theme_all_strings;
            $strings->automobile_short_code_strings();
            $strings->automobile_theme_option_strings();
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $automobile_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'automobile_blog';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array('automobile_blog_section_title' => '', 'automobile_blog_view' => '', 'automobile_blog_cat' => '', 'automobile_blog_orderby' => 'DESC', 'orderby' => 'ID', 'automobile_blog_description' => 'yes', 'automobile_blog_filterable' => '', 'automobile_blog_excerpt' => '30', 'automobile_blog_num_post' => '10', 'blog_pagination' => '', 'automobile_blog_class' => '');
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $blog_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'blog';
        $coloumn_class = 'column_' . $blog_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="blog" data="<?php echo automobile_element_size_data_array_index($blog_element_size) ?>">
            <?php automobile_element_setting($name, $automobile_counter, $blog_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($automobile_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter) ?>" data-shortcode-template="[automobile_blog {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo automobile_var_theme_text_srt('automobile_var_edit_blog_items') ?></h5>
                    <a href="javascript:automobile_frame_removeoverlay('<?php echo esc_js($name . $automobile_counter); ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
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
                                'std' => esc_attr($automobile_blog_section_title),
                                'cust_id' => '',
                                'cust_name' => 'automobile_blog_section_title[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                        $a_options = array();
                        $a_options = automobile_show_all_cats('', '', $automobile_blog_cat, "category", true);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_choose_category'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_blog_cat_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_blog_cat,
                                'id' => '',
                                'cust_name' => 'automobile_blog_cat[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => $a_options,
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_blog_design_views'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_blog_design_views_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $automobile_blog_view,
                                'id' => '',
                                'cust_name' => 'automobile_blog_view[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'grid' => automobile_var_theme_text_srt('automobile_var_blog_grid'),
                                    'large' => automobile_var_theme_text_srt('automobile_var_blog_large'),
                                    'medium' => automobile_var_theme_text_srt('automobile_var_blog_medium'),
				    'classic' => automobile_var_theme_text_srt('automobile_var_blog_classic'),
                                ),
                                'return' => true,
                            ),
                        );
                        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
                        ?>
                        <div id="Blog-listing<?php echo intval($automobile_counter); ?>" >
                            <?php
                            $automobile_opt_array = array(
                                'name' => automobile_var_theme_text_srt('automobile_var_blog_post_order'),
                                'desc' => '',
                                'hint_text' => automobile_var_theme_text_srt('automobile_var_blog_post_order_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_blog_orderby,
                                    'id' => '',
                                    'cust_name' => 'automobile_blog_orderby[]',
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'ASC' => automobile_var_theme_text_srt('automobile_var_blog_asc'),
                                        'DESC' => automobile_var_theme_text_srt('automobile_var_blog_desc'),
                                    ),
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_theme_text_srt('automobile_var_post_description'),
                                'desc' => '',
                                'hint_text' => automobile_var_theme_text_srt('automobile_var_post_description_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $automobile_blog_description,
                                    'id' => '',
                                    'cust_name' => 'automobile_blog_description[]',
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'yes' => automobile_var_theme_text_srt('automobile_var_yes'),
                                        'no' => automobile_var_theme_text_srt('automobile_var_no'),
                                    ),
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                            $automobile_opt_array = array(
                                'name' => automobile_var_theme_text_srt('automobile_var_length_excerpt'),
                                'desc' => '',
                                'hint_text' => automobile_var_theme_text_srt('automobile_var_length_excerpt_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($automobile_blog_excerpt),
                                    'cust_id' => '',
                                    'classes' => 'txtfield input-small',
                                    'cust_name' => 'automobile_blog_excerpt[]',
                                    'return' => true,
                                ),
                            );

                            $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);
                            ?>
                        </div>

                        <?php
                        $automobile_opt_array = array(
                            'name' => automobile_var_theme_text_srt('automobile_var_post_per_page'),
                            'desc' => '',
                            'hint_text' => automobile_var_theme_text_srt('automobile_var_post_per_page_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($automobile_blog_num_post),
                                'cust_id' => '',
                                'classes' => 'txtfield input-small',
                                'cust_name' => 'automobile_blog_num_post[]',
                                'return' => true,
                            ),
                        );

                        $automobile_var_html_fields->automobile_var_text_field($automobile_opt_array);

                        $automobile_opt_array = array(
            'name' => automobile_var_theme_text_srt('automobile_var_blog_pagination'),
            'desc' => '',
            'hint_text' => automobile_var_theme_text_srt('automobile_var_blog_pagination_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => $blog_pagination,
                'id' => '',
                'cust_name' => 'blog_pagination[]',
                'classes' => 'dropdown chosen-select-no-single select-medium',
                'options' => array(
                    'yes' => automobile_var_theme_text_srt('automobile_var_show_pagination'),
                    'no' => automobile_var_theme_text_srt('automobile_var_single_page'),
                ),
                'return' => true,
            ),
        );
        $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);
        ?>

                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_theme_text_srt('automobile_var_insert'); ?></a> </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>
                            <?php
                            $automobile_opt_array = array(
                                'std' => 'blog',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                 'cust_id' => 'automobile_orderby' . $automobile_counter,
                                'cust_name' => 'automobile_orderby[]',
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
                                    'std' => 'Save',
                                    'cust_id' => '',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-automobile-admin-btn',
                                    'cust_name' => 'button',
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

    add_action('wp_ajax_automobile_var_page_builder_blog', 'automobile_var_page_builder_blog');
}