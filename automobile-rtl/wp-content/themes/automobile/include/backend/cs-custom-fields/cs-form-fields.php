<?php

/**
 * Form Fields
 */
if (!class_exists('automobile_var_form_fields')) {

    class automobile_var_form_fields {

        private $counter = 0;

        public function __construct() {

            // Do something...
        }

        /**
         * @ render label
         */
        public function automobile_var_form_text_render($params = '') {

            global $post, $pagenow, $user;

            if (isset($params) && is_array($params)) {
                extract($params);
            }
            $automobile_var_output = '';
            $prefix_enable = 'true'; // default value of prefix add in name and id
            if (!isset($id)) {
                $id = '';
            }
            if (!isset($std)) {
                $std = '';
            }

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_var_'; // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php' && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_var_value = isset($std) ? $std : '';
            }
            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $automobile_var_rand_id = time();

            if (isset($rand_id) && $rand_id != '') {
                $automobile_var_rand_id = $rand_id;
            }

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            // Disabled Field
            $automobile_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_var_visibilty = 'readonly="readonly"';
            }

            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }

            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $automobile_var_input_type = 'text';
            if (isset($cust_type) && $cust_type != '') {
                $automobile_var_input_type = $cust_type;
            }

            $automobile_var_before = '';
            if (isset($before) && $before != '') {
                $automobile_var_before = '<div class="' . $before . '">';
            }

            $automobile_var_after = '';
            if (isset($after) && $after != '') {
                $automobile_var_after = $after;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                //$automobile_var_output .= '<div class="cs-drag-slider" data-slider-min="' . $min . '" data-slider-max="' . $max . '" data-slider-step="1" data-slider-value="' . $value . '">';
            }
            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                $automobile_var_output .= '<ul><li class="to-field"><div class="cs-drag-slider" data-slider-min="' . $min . '" data-slider-max="' . $max . '" data-slider-step="1" data-slider-value="' . $value . '"></div>';
            }
            
            $automobile_var_output .= $automobile_var_before;
            if ($value != '') {
                $automobile_var_output .= '<input type="' . $automobile_var_input_type . '" ' . $automobile_var_visibilty . $automobile_var_required . ' ' . $extra_atributes . ' ' . $automobile_var_classes . ' ' . $html_id . $html_name . ' value="' . $value . '" />';
            } else {
                $automobile_var_output .= '<input type="' . $automobile_var_input_type . '" ' . $automobile_var_visibilty . $automobile_var_required . ' ' . $extra_atributes . ' ' . $automobile_var_classes . ' ' . $html_id . $html_name . ' />';
            }
            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                $automobile_var_output .= "</li></ul>";
            }
            $automobile_var_output .= $automobile_var_after;

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Radio field
         */
        public function automobile_var_form_radio_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_var_output = '';

            if (!isset($id)) {
                $id = '';
            }

            $prefix_enable = 'true'; // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            if ($pagenow == 'post.php' && $id != '') {
                $automobile_var_value = get_post_meta($post->ID, 'automobile_var_' . $id, true);
                if (isset($automobile_var_value) && $automobile_var_value != '') {
                    $value = $automobile_var_value;
                } else {
                    $value = $std;
                }
            } else {
                $value = $std;
            }

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $html_id = isset($html_id) ? $html_id : '';

            // Disbaled Field
            $automobile_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_var_visibilty = 'readonly="readonly"';
            }
            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }
            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }

            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            $automobile_var_output .= '<input type="radio" ' . $automobile_var_visibilty . $automobile_var_required . ' ' . $automobile_var_classes . ' ' . $extra_atributes . ' ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Radio field
         */
        public function automobile_var_form_hidden_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_var_rand_id = time();

            if (!isset($id)) {
                $id = '';
            }
            $html_id = '';
            $html_id = ' id="automobile_var_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }

            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            $automobile_var_output = '<input type="hidden" ' . $html_id . ' ' . $automobile_var_classes . ' ' . $extra_atributes . ' ' . $html_name . ' value="' . sanitize_text_field($std) . '" />';
            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Date field
         */
        public function automobile_var_form_date_render($params = '') {

            global $post, $pagenow, $user;
            $automobile_var_format = 'd-m-Y';
            if (isset($format) && $format != '') {
                $automobile_var_format = $format;
            }

            if (isset($params) && is_array($params)) {
                extract($params);
            }
            $automobile_var_output = '';
            $prefix_enable = 'true'; // default value of prefix add in name and id
            if (!isset($id)) {
                $id = '';
            }
            if (!isset($std)) {
                $std = '';
            }

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_var_'; // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php' && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_var_value = isset($std) ? $std : '';
            }
            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $automobile_var_rand_id = time();

            if (isset($rand_id) && $rand_id != '') {
                $automobile_var_rand_id = $rand_id;
            }

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            // Disabled Field
            $automobile_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_var_visibilty = 'readonly="readonly"';
            }

            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }

            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $automobile_var_input_type = 'text';
            if (isset($cust_type) && $cust_type != '') {
                $automobile_var_input_type = $cust_type;
            }

            $automobile_var_before = '';
            if (isset($before) && $before != '') {
                $automobile_var_before = '<div class="' . $before . '">';
            }

            $automobile_var_after = '';
            if (isset($after) && $after != '') {
                $automobile_var_after = $after;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                $automobile_var_output .= '<div class="cs-drag-slider" data-slider-min="' . absint($min) . '" data-slider-max="' . absint($max) . '" data-slider-step="1" data-slider-value="' . $value . '">';
            }
            $automobile_var_output .= $automobile_var_before;

            $automobile_var_output .= '<script>
                                jQuery(function(){
                                    jQuery("#' . $cust_id . '").datetimepicker({
                                        format:"' . $automobile_var_format . '",
                                        timepicker:false
                                    });
                                });
                          </script>';
            if ($value != '') {
                $automobile_var_output .= '<input type="' . $automobile_var_input_type . '" ' . $automobile_var_visibilty . $automobile_var_required . ' ' . $extra_atributes . ' ' . $automobile_var_classes . ' ' . $html_id . $html_name . ' value="' . $value . '" />';
            } else {
                $automobile_var_output .= '<input type="' . $automobile_var_input_type . '" ' . $automobile_var_visibilty . $automobile_var_required . ' ' . $extra_atributes . ' ' . $automobile_var_classes . ' ' . $html_id . $html_name . ' />';
            }

            $automobile_var_output .= $automobile_var_after;

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Textarea field
         */
        public function automobile_var_form_textarea_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_var_output = '';
            if (!isset($id)) {
                $id = '';
            }
            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_var_value = get_post_meta($post->ID, 'automobile_var_' . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_var_value = $std;
            }

            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }

            $automobile_var_rand_id = time();

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $html_id = ' id="automobile_var_' . sanitize_html_class($id) . '"';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="automobile_var_cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_var_' . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }
            $automobile_var_before = '';
            if (isset($before) && $before != '') {
                $automobile_var_before = '<div class="' . $before . '">';
            }

            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }

            $automobile_var_after = '';
            if (isset($after) && $after != '') {
                $automobile_var_after = '</div>';
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            $automobile_var_output .= $automobile_var_before;
            $automobile_var_output .= ' <textarea' . $automobile_var_required . ' ' . $extra_atributes . ' ' . $html_id . $html_name . $automobile_var_classes . '>' . $value . '</textarea>';
            $automobile_var_output .= $automobile_var_after;

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render select field
         */
        public function automobile_var_form_select_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $prefix_enable = 'true';    // default value of prefix add in name and id
            if (!isset($id)) {
                $id = '';
            }
            $automobile_var_output = '';

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            $automobile_var_onchange = '';

            if ($pagenow == 'post.php' && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_var_value = $std;
            }

            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }

            $automobile_var_rand_id = time();
            if (isset($rand_id) && $rand_id != '') {
                $automobile_var_rand_id = $rand_id;
            }

            $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
                $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . $automobile_var_rand_id . '"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $automobile_var_display = '';
            if (isset($status) && $status == 'hide') {
                $automobile_var_display = 'style=display:none';
            }

            if (isset($onclick) && $onclick != '') {
                $automobile_var_onchange = 'onchange="' . $onclick . '"';
            }

            $automobile_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_var_visibilty = 'readonly="readonly"';
            }
            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }
            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if (isset($markup) && $markup != '') {
                $automobile_var_output .= $markup;
            }

            if (isset($div_classes) && $div_classes <> "") {
                $automobile_var_output .= '<div class="' . esc_attr($div_classes) . '">';
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            $automobile_var_output .= '<select ' . $automobile_var_visibilty . ' ' . $automobile_var_required . ' ' . $extra_atributes . ' ' . $automobile_var_classes . ' ' . $html_id . $html_name . ' ' . $automobile_var_onchange . ' >';
            if (isset($options_markup) && $options_markup == true) {
                $automobile_var_output .= $options;
            } else {
                if (isset($first_option) && $first_option <> "") {
                    $automobile_var_output .= $first_option;
                }
                if (is_array($options)) {
                    foreach ($options as $key => $option) {
                        if (!is_array($option)) {
                            $automobile_var_output .= '<option ' . selected($key, $value, false) . ' value="' . $key . '">' . $option . '</option>';
                        }
                    }
                }
            }
            $automobile_var_output .= '</select>';

            if (isset($div_classes) && $div_classes <> "") {
                $automobile_var_output .= '</div>';
            }

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Multi Select field
         */
        public function automobile_var_form_multiselect_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_var_output = '';

            $prefix_enable = 'true';    // default value of prefix add in name and id
            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            $automobile_var_onchange = '';

            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_var_value = $std;
            }
            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }
            $automobile_var_rand_id = time();
            if (isset($rand_id) && $rand_id != '') {
                $automobile_var_rand_id = $rand_id;
            }
            $html_wraper = '';
            if (isset($id) && $id != '') {
                $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            }
            $html_id = '';
            if (isset($id) && $id != '') {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            }
            $html_name = '';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . '][]"';
            } else {
                if (isset($id) && $id != '') {
                    $html_name = ' name="' . $prefix . sanitize_html_class($id) . '[]"';
                }
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $automobile_var_display = '';
            if (isset($status) && $status == 'hide') {
                $automobile_var_display = 'style=display:none';
            }

            if (isset($onclick) && $onclick != '') {
                $automobile_var_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
            }

            if (!is_array($value) && $value != '') {
                $value = explode(',', $value);
            }

            if (!is_array($value)) {
                $value = array();
            }

            // Disbaled Field
            $automobile_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_var_visibilty = 'readonly="readonly"';
            }
            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }
            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="multiple ' . $classes . '"';
            } else {
                $automobile_var_classes = ' class="multiple"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            $automobile_var_output .= '<select' . $automobile_var_visibilty . $automobile_var_required . ' ' . $extra_atributes . ' ' . $automobile_var_classes . ' ' . ' multiple="multiple" ' . $html_id . $html_name . ' ' . $automobile_var_onchange . ' style="height:110px !important;">';

            if (isset($options_markup) && $options_markup == true) {
                $automobile_var_output .= $options;
            } else {
                foreach ($options as $key => $option) {
                    $selected = '';
                    if (in_array($key, $value)) {
                        $selected = 'selected="selected"';
                    }

                    $automobile_var_output .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
                }
            }
            $automobile_var_output .= '</select>';

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Checkbox field
         */
        public function automobile_var_form_checkbox_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $prefix_enable = 'true';    // default value of prefix add in name and id

            $automobile_var_output = '';

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            if (!isset($id)) {
                $id = '';
            }

            $prefix = 'automobile_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php') {
                $automobile_var_value = get_post_meta($post->ID, 'automobile_var_' . $id, true);
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_var_value = $std;
            }

            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }

            $automobile_var_rand_id = time();

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            $btn_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $btn_name = ' name="' . $prefix . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $checked = isset($value) && $value == 'on' ? ' checked="checked"' : '';
            // Disbaled Field
            $automobile_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_var_visibilty = 'readonly="readonly"';
            }
            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }
            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_var_"') {
                $html_id = '';
            }

            if (isset($simple) && $simple == true) {
                if ($value == '') {
                    $automobile_var_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $automobile_var_classes . ' ' . $checked . ' ' . $extra_atributes . ' />';
                } else {
                    $automobile_var_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $automobile_var_classes . ' ' . $checked . ' value="' . $value . '"' . $extra_atributes . ' />';
                }
            } else {
                $automobile_var_output .= '<label class="pbwp-checkbox cs-chekbox">';
                $automobile_var_output .= '<input type="hidden"' . $html_id . $html_name . ' value="' . sanitize_text_field($std) . '" />';
                $automobile_var_output .= '<input type="checkbox" ' . $automobile_var_classes . ' ' . $btn_name . $checked . ' ' . $extra_atributes . ' />';
                $automobile_var_output .= '<span class="pbwp-box"></span>';
                $automobile_var_output .= '</label>';
            }

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Checkbox With Input Field
         */
        public function automobile_var_form_checkbox_with_field_render($params = '') {
            global $post, $pagenow;
            extract($params);
            extract($field);
            $prefix_enable = 'true';    // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            $automobile_var_value = get_post_meta($post->ID, $prefix . $id, true);
            if (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                    }
                }
            }
            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }

            $automobile_var_input_value = get_post_meta($post->ID, $prefix . $field_id, true);
            if (isset($automobile_var_input_value) && $automobile_var_input_value != '') {
                $input_value = $automobile_var_input_value;
            } else {
                $input_value = $field_std;
            }

            $automobile_var_visibilty = ''; // Disbaled Field
            if (isset($active) && $active == 'in-active') {
                $automobile_var_visibilty = 'readonly="readonly"';
            }
            $automobile_var_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_var_required = ' required';
            }
            $automobile_var_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $automobile_var_output .= '<label class="pbwp-checkbox">';
            $automobile_var_output .= $this->automobile_var_form_hidden_render(array('id' => $id, 'std' => '', 'type' => '', 'return' => 'return'));
            $automobile_var_output .= '<input type="checkbox" ' . $automobile_var_visibilty . $automobile_var_required . ' ' . $extra_atributes . ' ' . $automobile_var_classes . ' ' . ' name="' . $prefix . sanitize_html_class($id) . '" id="' . $prefix . sanitize_html_class($id) . '" value="' . sanitize_text_field('on') . '" ' . checked('on', $value, false) . ' />';
            $automobile_var_output .= '<span class="pbwp-box"></span>';
            $automobile_var_output .= '</label>';
            $automobile_var_output .= '<input type="text" name="' . $prefix . sanitize_html_class($field_id) . '"  value="' . sanitize_text_field($input_value) . '">';
            $automobile_var_output .= $this->automobile_var_form_description($description);

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render File Upload field
         */
        public function automobile_var_media_url($params = '') {
            global $post, $pagenow, $automobile_var_static_text;
            $strings = new automobile_theme_all_strings;
            $strings->automobile_theme_option_field_strings();
            extract($params);

            $automobile_var_output = '';

            $automobile_var_value = isset($post->ID) ? get_post_meta($post->ID, 'automobile_var_' . $id, true) : '';
            if (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $automobile_var_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                        }
                    }
                }
            }
            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
            } else {
                $value = $std;
            }

            $automobile_var_rand_id = time();

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $html_id = ' id="automobile_var_' . sanitize_html_class($id) . '"';
            $html_id_btn = ' id="automobile_var_' . sanitize_html_class($id) . '_btn"';
            $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_var_' . sanitize_html_class($id) . $automobile_var_rand_id . '"';
                $html_id_btn = ' id="automobile_var_' . sanitize_html_class($id) . $automobile_var_rand_id . '_btn"';
                $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '_array[]"';
            }
            $automobile_var_output .= '<input type="text" class="cs-form-text cs-input" ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';
            $automobile_var_output .= '<label class="cs-browse">';
            $automobile_var_output .= '<input type="button" ' . $html_id_btn . $html_name . ' class="uploadfile left" value="' . automobile_var_theme_text_srt('automobile_var_browse') . '"/>';
            $automobile_var_output .= '</label>';

            if (isset($return) && $return == true) {
                return $automobile_var_output;
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render File Upload field
         */
        public function automobile_var_form_fileupload_render($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_static_text;
            $strings = new automobile_theme_all_strings;
            $strings->automobile_theme_option_field_strings();
            extract($params);

            $automobile_var_output = '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_var_value = get_post_meta($post->ID, 'automobile_var_' . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $automobile_var_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
                        }
                    }
                }
            } else {
                $automobile_var_value = $std;
            }

            if (isset($automobile_var_value) && $automobile_var_value != '') {
                $value = $automobile_var_value;
                if (isset($dp) && $dp == true) {
                    $value = automobile_var_get_img_url($automobile_var_value, 'automobile_var_media_5');
                } else {
                    $value = $automobile_var_value;
                }
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $btn_name = ' name="automobile_var_' . sanitize_html_class($id) . '"';
            $html_id = ' id="automobile_var_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $btn_name = ' name="automobile_var_' . sanitize_html_class($id) . $automobile_var_random_id . '"';
                $html_id = ' id="automobile_var_' . sanitize_html_class($id) . $automobile_var_random_id . '"';
                $html_name = ' name="automobile_var_' . sanitize_html_class($id) . '_array[]"';
            } else if (isset($dp) && $dp == true) {
                $html_name = ' name="' . sanitize_html_class($id) . '"';
            }

            if (isset($cust_name) && $cust_name == true) {
                $html_name = ' name="' . $cust_name . '"';
            }

            if (isset($value) && $value != '') {
                $display_btn = ' style=display:none';
            } else {
                $display_btn = ' style=display:block';
            }

            $automobile_var_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

            $automobile_var_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-automobile-media left" value=' . automobile_var_theme_text_srt('automobile_var_browse') . ' /></label>';

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_var_output);
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * @ render Random String
         */
        public function automobile_var_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        /**
         * @ render submit field
         */
        public function automobile_var_form_submit_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_rand_id = time();

            if (!isset($id)) {
                $id = '';
            }

            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                if ($cust_name == '') {
                    $html_name = '';
                } else {
                    $html_name = ' name="' . $cust_name . '"';
                }
            }

            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }
            if ($html_id == ' id=""' || $html_id == ' id="automobile_"') {
                $html_id = '';
            }
            $automobile_output = '<input type="submit" ' . $html_id . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . $html_name . ' value="' . sanitize_text_field($std) . '" />';

            if (isset($return) && $return == true) {
                return automobile_allow_special_char($automobile_output);
            } else {
                echo automobile_allow_special_char($automobile_output);
            }
        }

    }

    $var_arrays = array('automobile_var_form_fields');
    $form_fields_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
    extract($form_fields_global_vars);
    $automobile_var_form_fields = new automobile_var_form_fields();
}

/**
 * 
 * @ render Wrapper Start
 */
function automobile_wrapper_start_render($params = '') {
    global $post, $jobcareer_html_fields;
    extract($params);
    $automobile_display = '';
    if (isset($status) && $status == 'hide') {
        $automobile_display = 'style="display:none;"';
    }

    $automobile_output = '<div class="wrapper_' . sanitize_html_class($id) . '" id="wrapper_' . sanitize_html_class($id) . '" ' . $automobile_display . '>';
    echo automobile_allow_special_char($automobile_output);
}

/**
 * 
 * @ render Wrapper Start
 */
function automobile_wrapper_end_render($params = '') {
    global $post, $jobcareer_html_fields;
    extract($params);

    $automobile_output = '</div>';
    echo automobile_allow_special_char($automobile_output);
}
