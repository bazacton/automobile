<?php
/**
 * File Type: Form Fields
 */
if (!class_exists('automobile_form_fields')) {

    class automobile_form_fields {

        private $counter = 0;

        public function __construct() {

            // Do something...
        }

        public function automobile_tooltip_helptext($popover_text = '', $return_html = true) {
            $popover_link = '';
            if (isset($popover_text) && $popover_text != '') {
                $popover_link = '<a class="cs-help cs" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="' . $popover_text . '"><i class="icon-help"></i></a>';
            }
            if ($return_html == true) {
                return $popover_link;
            } else {
                echo $popover_link;
            }
        }

        /**
         * @ render label
         */
        public function automobile_form_text_render($params = '') {

            global $post, $pagenow, $user;

            if (isset($params) && is_array($params)) {
                extract($params);
            }
            $automobile_output = '';
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

            $prefix = 'automobile_'; // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);                   
                } else {
                    $automobile_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '' && $user != '') {
                        $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_value = isset($std) ? $std : '';
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $automobile_rand_id = time();

            if (isset($rand_id) && $rand_id != '') {
                $automobile_rand_id = $rand_id;
            }

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            // Disabled Field
            $automobile_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }

            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
            }

            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $automobile_input_type = 'text';
            if (isset($cust_type) && $cust_type != '') {
                $automobile_input_type = $cust_type;
            }

            $automobile_before = '';
            if (isset($before) && $before != '') {
                $automobile_before = '<div class="' . $before . '">';
            }

            $automobile_after = '';
            if (isset($after) && $after != '') {
                $automobile_after = $after;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_"') {
                $html_id = '';
            }

            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                $automobile_output .= '<div class="cs-drag-slider" data-slider-min="' . $min . '" data-slider-max="' . $max . '" data-slider-step="1" data-slider-value="' . $value . '">';
            }
            $automobile_output .= $automobile_before;
            if ($value != '') {
                $automobile_output .= '<input type="' . $automobile_input_type . '" ' . $automobile_visibilty . $automobile_required . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . $html_id . $html_name . ' value="' . $value . '" />';
            } else {
                $automobile_output .= '<input type="' . $automobile_input_type . '" ' . $automobile_visibilty . $automobile_required . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . $html_id . $html_name . ' />';
            }

            $automobile_output .= $automobile_after;

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render Radio field
         */
        public function automobile_form_radio_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_output = '';

            if (!isset($id)) {
                $id = '';
            }

            $prefix_enable = 'true';    // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_rand_id . '"';
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
            $automobile_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
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

            $automobile_output .= '<input type="radio" ' . $automobile_visibilty . $automobile_required . ' ' . $automobile_classes . ' ' . $extra_atributes . ' ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render Radio field
         */
        public function automobile_form_hidden_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_rand_id = time();

            if (!isset($id)) {
                $id = '';
            }
            $html_id = '';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
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

            $automobile_output = '<input type="hidden" ' . $html_id . ' ' . $automobile_classes . ' ' . $extra_atributes . ' ' . $html_name . ' value="' . sanitize_text_field($std) . '" />';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render Date field
         */
        public function automobile_form_date_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_output = '';

            $automobile_post_id = isset($post->ID) ? $post->ID : 0;

            $automobile_format = 'd-m-Y';
            $prefix_enable = 'true';    // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if (isset($format) && $format != '') {
                $automobile_format = $format;
            }
            $automobile_value = '';
            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_post_meta($automobile_post_id, $id, true);
                } else {
                    $automobile_value = get_post_meta($automobile_post_id, $prefix . $id, true);
                }
                if (isset($strtotime) && $strtotime == true) {
                    $automobile_value = date($automobile_format, (int) $automobile_value);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                    }
                }

                if (isset($strtotime) && $strtotime == true) {
                    $automobile_value = date($automobile_format, (int) $automobile_value);
                }
            } else {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_post_meta($automobile_post_id, $id, true);
                } else {
                    if (isset($strtotime) && $strtotime == true) {
                        $automobile_value = isset($automobile_post_id) ? get_post_meta((int) $automobile_post_id, 'automobile_' . $id, true) : '';
                        $automobile_value = date($automobile_format, (int) $automobile_value);
                    } else {
                        $automobile_value = isset($automobile_post_id) ? get_post_meta($automobile_post_id, 'automobile_' . $id, true) : '';
                    }
                }
            }
            if (isset($std) && $std != '') {
                $automobile_value = $std;
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
            }
            // disable attribute
            $automobile_disabled = '';
            if (isset($disabled) && $disabled == 'yes') {
                $automobile_disabled = ' disabled="disabled"';
            }

            $automobile_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $automobile_rand_id = time();
            if (isset($rand_id) && $rand_id != '') {
                $automobile_rand_id = $rand_id;
            }

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            $automobile_piker_id = $id;
            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
                $automobile_piker_id = $id . $automobile_rand_id;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_"') {
                $html_id = '';
            }
            // default value
            $automobile_output .= '<script>
                                jQuery(function(){
                                    jQuery("#' . $prefix . $automobile_piker_id . '").datetimepicker({
                                        format:"' . $automobile_format . '",
                                        timepicker:false
                                    });
                                });
                          </script>';
            $automobile_output .= '<div class="input-sec">';
            $automobile_output .= '<input type="text"' . $automobile_visibilty . $automobile_required . ' ' . $automobile_disabled . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . $html_id . $html_name . '  value="' . sanitize_text_field($value) . '" />';
            $automobile_output .= '</div>';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render Textarea field
         */
        public function automobile_form_textarea_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_output = '';
            if (!isset($id)) {
                $id = '';
            }
            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_value = $std;
            }
            //echo "==(".$automobile_value.")";

            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            $automobile_rand_id = time();

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="automobile_cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
            }
            $automobile_before = '';
            if (isset($before) && $before != '') {
                $automobile_before = '<div class="' . $before . '">';
            }

            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $automobile_after = '';
            if (isset($after) && $after != '') {
                $automobile_after = '</div>';
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_"') {
                $html_id = '';
            }

            $automobile_output .= $automobile_before;
            $automobile_output .= ' <textarea' . $automobile_required . ' ' . $extra_atributes . ' ' . $html_id . $html_name . '>' . $value . '</textarea>';
            $automobile_output .= $automobile_after;

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render select field
         */
        public function automobile_form_select_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $prefix_enable = 'true';    // default value of prefix add in name and id
            if (!isset($id)) {
                $id = '';
            }

            $automobile_output = '';

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            $automobile_onchange = '';

            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_value = $std;
            }

            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
			$braces='';
			 if (isset($multi_front) && $multi_front != '') {
                $braces='[]';
            }
            $automobile_rand_id = time();
            if (isset($rand_id) && $rand_id != '') {
                $automobile_rand_id = $rand_id;
            }

            $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']'.$braces.'"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }
			

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
                $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . $automobile_rand_id . '"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $automobile_display = '';
            if (isset($status) && $status == 'hide') {
                $automobile_display = 'style=display:none';
            }

            if (isset($onclick) && $onclick != '') {
                $automobile_onchange = 'onchange="' . $onclick . '"';
            }

            $automobile_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
            }
            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="' . $classes . '"';
            }
			$automobile_multi = '';
            if (isset($multi) && $multi != '') {
                $automobile_multi = ' multiple="' . $multi . '"';
            }
			 if (isset($multi_front) && $multi_front != '') {
                $automobile_multi = ' multiple="' . $multi_front . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if (isset($markup) && $markup != '') {
                $automobile_output .= $markup;
            }

            if (isset($div_classes) && $div_classes <> "") {
                $automobile_output .= '<div class="' . esc_attr($div_classes) . '">';
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_"') {
                $html_id = '';
            }
			  if (isset($multi_front) && $multi_front != '') {
			 $automobile_output .= '<select ' . $automobile_visibilty . ' ' . $automobile_required . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . $html_id . $html_name . ' ' . $automobile_onchange . ' ' . $automobile_multi . ' >';
           
                if (is_array($options)) {
					
                    foreach ($options as $key => $option) {
						$selected_vale='';
                        if (in_array($key, $std)){
							$selected_vale='selected';
							
						}
						
                            $automobile_output .= '<option ' . $selected_vale . ' value="' . $key . '">' . $option . '</option>';
                       
                    }
                }
            
            $automobile_output .= '</select>';
			}
			else{
            $automobile_output .= '<select ' . $automobile_visibilty . ' ' . $automobile_required . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . $html_id . $html_name . ' ' . $automobile_onchange . ' ' . $automobile_multi . ' >';
            if (isset($options_markup) && $options_markup == true) {
                $automobile_output .= $options;
            } else {
                if (is_array($options)) {
                    foreach ($options as $key => $option) {
                        if (!is_array($option)) {
                            $automobile_output .= '<option ' . selected($key, $value, false) . ' value="' . $key . '">' . $option . '</option>';
                        }
                    }
                }
            }
            $automobile_output .= '</select>';
			}

            if (isset($div_classes) && $div_classes <> "") {
                $automobile_output .= '</div>';
            }

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render Multi Select field
         */
        public function automobile_form_multiselect_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $automobile_output = '';

            $prefix_enable = 'true';    // default value of prefix add in name and id
            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            $automobile_onchange = '';

            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_value = $std;
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_rand_id = time();
            if (isset($rand_id) && $rand_id != '') {
                $automobile_rand_id = $rand_id;
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

            $automobile_display = '';
            if (isset($status) && $status == 'hide') {
                $automobile_display = 'style=display:none';
            }

            if (isset($onclick) && $onclick != '') {
                $automobile_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
            }

            if (!is_array($value) && $value != '') {
                $value = explode(',', $value);
            }

            if (!is_array($value)) {
                $value = array();
            }

            // Disbaled Field
            $automobile_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
            }
            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="multiple ' . $classes . '"';
            } else {
                $automobile_classes = ' class="multiple"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="automobile_"') {
                $html_id = '';
            }

            $automobile_output .= '<select' . $automobile_visibilty . $automobile_required . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . ' multiple ' . $html_id . $html_name . ' ' . $automobile_onchange . ' style="height:110px !important;">';

            if (isset($options_markup) && $options_markup == true) {
                $automobile_output .= $options;
            } else {
                if (is_array($options)) {
                    foreach ($options as $key => $option) {
                        $selected = '';
                        if (in_array($key, $value)) {
                            $selected = 'selected="selected"';
                        }

                        $automobile_output .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
                    }
                }
            }
            $automobile_output .= '</select>';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render Checkbox field
         */
        public function automobile_form_checkbox_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $prefix_enable = 'true';    // default value of prefix add in name and id

            $automobile_output = '';

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            if (!isset($id)) {
                $id = '';
            }

            $prefix = 'automobile_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                    }
                }
            } else {
                $automobile_value = $std;
            }

            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            $automobile_rand_id = time();

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            $btn_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $automobile_rand_id . '"';
                $btn_name = ' name="' . $prefix . sanitize_html_class($id) . $automobile_rand_id . '"';
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
            $automobile_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
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

            if (isset($simple) && $simple == true) {
                if ($value == '') {
                    $automobile_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $automobile_classes . ' ' . $checked . ' ' . $extra_atributes . ' />';
                } else {
                    $automobile_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $automobile_classes . ' ' . $checked . ' value="' . $value . '"' . $extra_atributes . ' />';
                }
            } else {
                $automobile_output .= '<label class="pbwp-checkbox cs-chekbox">';
                $automobile_output .= '<input type="hidden"' . $html_id . $html_name . ' value="' . sanitize_text_field($std) . '" />';
                $automobile_output .= '<input type="checkbox" ' . $automobile_classes . ' ' . $btn_name . $checked . ' ' . $extra_atributes . ' />';
                $automobile_output .= '<span class="pbwp-box"></span>';
                $automobile_output .= '</label>';
            }

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render Checkbox With Input Field
         */
        public function automobile_form_checkbox_with_field_render($params = '') {
            global $post, $pagenow;
            extract($params);
            extract($field);
            $prefix_enable = 'true';    // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'automobile_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            $automobile_value = get_post_meta($post->ID, $prefix . $id, true);
            if (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                    }
                }
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            $automobile_input_value = get_post_meta($post->ID, $prefix . $field_id, true);
            if (isset($automobile_input_value) && $automobile_input_value != '') {
                $input_value = $automobile_input_value;
            } else {
                $input_value = $field_std;
            }

            $automobile_visibilty = ''; // Disbaled Field
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required';
            }
            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $automobile_output .= '<label class="pbwp-checkbox">';
            $automobile_output .= $this->automobile_form_hidden_render(array('id' => $id, 'std' => '', 'type' => '', 'return' => 'return'));
            $automobile_output .= '<input type="checkbox" ' . $automobile_visibilty . $automobile_required . ' ' . $extra_atributes . ' ' . $automobile_classes . ' ' . ' name="' . $prefix . sanitize_html_class($id) . '" id="' . $prefix . sanitize_html_class($id) . '" value="' . sanitize_text_field('on') . '" ' . checked('on', $value, false) . ' />';
            $automobile_output .= '<span class="pbwp-box"></span>';
            $automobile_output .= '</label>';
            $automobile_output .= '<input type="text" name="' . $prefix . sanitize_html_class($field_id) . '"  value="' . sanitize_text_field($input_value) . '">';
            $automobile_output .= $this->automobile_form_description($description);

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render File Upload field
         */
        public function automobile_media_url($params = '') {
            global $post, $pagenow, $automobile_var_plugin_static_text;

            extract($params);

            $automobile_output = '';

            $automobile_value = isset($post->ID) ? get_post_meta($post->ID, 'automobile_' . $id, true) : '';
            if (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $automobile_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                        }
                    }
                }
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            $automobile_rand_id = time();

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_id_btn = ' id="automobile_' . sanitize_html_class($id) . '_btn"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_id_btn = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '_btn"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }

            $automobile_output .= '<input type="text" class="cs-form-text cs-input" ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';
            $automobile_output .= '<label class="cs-browse">';
            $automobile_output .= '<input type="button" ' . $html_id_btn . $html_name . ' class="uploadfile left" value="' . automobile_var_plugin_text_srt('automobile_var_browse') . '"/>';
            $automobile_output .= '</label>';

            if (isset($return) && $return == true) {
                return $automobile_output;
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render File Upload field
         */
        public function automobile_form_fileupload_render($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_static_text;

            extract($params);

            $automobile_output = '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $automobile_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                        }
                    }
                }
            } else {
                $automobile_value = $std;
            }

            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
                if (isset($dp) && $dp == true) {
                    $value = automobile_get_img_url($automobile_value, 'automobile_var_media_6');
                } else {
                    $value = $automobile_value;
                }
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $btn_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $btn_name = ' name="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            } else if (isset($dp) && $dp == true) {
                $html_name = ' name="' . sanitize_html_class($id) . '"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' name="' . $cust_name . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            if (isset($value) && $value != '') {
                $display_btn = ' style=display:none';
            } else {
                $display_btn = ' style=display:block';
            }

            $automobile_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

            $automobile_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left" value=' . automobile_var_plugin_text_srt('automobile_var_browse') . ' /></label>';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render File Upload field button
         */
        public function automobile_img_upload_button($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_static_text;

            extract($params);

            $automobile_output = '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $automobile_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                        }
                    }
                }
            } else {
                $automobile_value = $std;
            }

            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
                if (isset($dp) && $dp == true) {
                    $value = automobile_get_img_url($automobile_value, 'automobile_var_media_6');
                } else {
                    $value = $automobile_value;
                }
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            if (isset($value) && $value != '') {
                $display = 'style=display:block';
            } else {
                $display = 'style=display:none';
            }

            $automobile_random_id = '';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $automobile_random_id = rand(12345678, 98765432);
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
            }

            $btn_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $btn_name = ' name="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            } else if (isset($dp) && $dp == true) {
                $html_name = ' name="' . sanitize_html_class($id) . '"';
            }
            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' name="' . $cust_name . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            if (isset($value) && $value != '') {
                $display_btn = ' style=display:none';
            } else {
                $display_btn = ' style=display:block';
            }

            $automobile_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';
            $automobile_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left" value=' . automobile_var_plugin_text_srt('automobile_var_browse') . ' /></label>';
            $automobile_output .= '<div class="page-wrap" ' . $display . ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_box">';
            $automobile_output .= '<div class="gal-active">';
            $automobile_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $automobile_output .= '<ul id="gal-sortable">';
            $automobile_output .= '<li class="ui-state-default" id="">';
            $automobile_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_img" width="100" alt="" />';
            $automobile_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'automobile_' . sanitize_html_class($id) . $automobile_random_id . '\')" class="delete delImgMedia"></a> </div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        public function automobile_form_custom_fileupload_render($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_static_text;

            extract($params);

            $automobile_output = '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $automobile_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                        }
                    }
                }
            } else {
                $automobile_value = $std;
            }
            $imagename_only = '';
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
                $imagename_only = $automobile_value;
                if (isset($dp) && $dp == true) {
                    $value = automobile_get_img_url($automobile_value, 'automobile_var_media_6');
                } else {
                    $value = $automobile_value;
                }
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $btn_name = ' name="automobile_' . sanitize_html_class($id) . '_media"';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $btn_name = ' name="automobile_' . sanitize_html_class($id) . '_media' . $automobile_random_id . '"';
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
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

            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="' . $classes . '"';
            }

            $automobile_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $imagename_only . '"/>';

            $automobile_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="file" class="' . $automobile_classes . '" value=' . automobile_var_plugin_text_srt('automobile_var_browse') . ' /></label>';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render multiple Custom File Upload field
         */
        public function automobile_form_multiple_custom_fileupload_render($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_static_text;

            extract($params);

            $automobile_output = '';

            $btn_name = ' name="automobile_' . sanitize_html_class($id) . '_media' . $automobile_random_id . '[]"';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
            $html_name = ' name="' . sanitize_html_class($id) . '[]"';

            $value = '';
            if (isset($f_value) && $f_value != '') {
                $value = $f_value;
            }

            if (isset($value) && $value != '') {
                $display_btn = ' style=display:none';
            } else {
                $display_btn = ' style=display:block';
            }

            $automobile_classes = '';
            if (isset($classes) && $classes != '') {
                $automobile_classes = ' class="' . $classes . '"';
            }
            $automobile_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

            $automobile_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="file" class="' . $automobile_classes . '" value=' . automobile_var_plugin_text_srt('automobile_var_browse') . ' /></label>';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * @ render cvupload Upload field
         */
        public function automobile_form_cvupload_render($params = '') {
            global $post, $pagenow, $automobile_var_plugin_core, $automobile_var_plugin_static_text;

            extract($params);
            $automobile_output = '';
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $automobile_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
                        }
                    }
                }
            } else {
                $automobile_value = $std;
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            if (isset($value) && $value != '') {
                $display = 'style=display:block';
            } else {
                $display = 'style=display:none';
            }

            $automobile_random_id = $automobile_var_plugin_core->automobile_rand_id();

            $btn_name = ' name="' . sanitize_html_class($id) . '"';
            $html_id = ' id="' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $btn_name = ' name="' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_id = ' id="' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }

            $automobile_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';
            $automobile_output .= '<label class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left" value="' . automobile_var_plugin_text_srt('automobile_var_browse') . '" /></label>';

            $automobile_output .= '<div class="page-wrap" ' . $display . ' id="automobile_' . sanitize_html_class($id) . '_box">';
            $automobile_output .= '<div class="gal-active">';
            $automobile_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $automobile_output .= '<ul id="gal-sortable">';
            $automobile_output .= '<li class="ui-state-default" id="">';
            $automobile_output .= '<div class="thumb-secs" id="automobile_' . sanitize_html_class($id) . '_img"> ' . basename($value);
            $automobile_output .= '<div class="gal-edit-opts"><a href="javascript:del_cv_media(\'automobile_' . sanitize_html_class($id) . '\', \'' . sanitize_html_class($id) . '\')" class="delete"></a> </div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';

            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        public function automobile_multiple_custom_upload_file_field($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_core, $user;

            extract($params);

            if ($pagenow == 'post.php') {
                $automobile_gallery = get_post_meta($post->ID, $id, true);
            } elseif (isset($user) && !empty($user)) {
                $automobile_gallery = get_user_meta($user->ID, $id, true);
            } else {
                $automobile_gallery = get_user_meta(get_current_user_id(), 'gallery_user_img', true);
            }
            $automobile_output = '';
            $automobile_gal_counter = 0;

            $automobile_output .= '
                        <div class="cs-upload-img">
                            <ul>';

            if (is_array($automobile_gallery) && sizeof($automobile_gallery) >= 1) {

                foreach ($automobile_gallery as $automobile_gal) {
                    $automobile_gal_counter++;
                    $automobile_url = isset($automobile_gal['url']) && !empty($automobile_gal['url']) ? $automobile_gal['url'] : '';

                    if ($automobile_url <> '') {
                        //Serialize Array to String
                        $image_data = serialize($automobile_gal);

                        $automobile_output .= ' <li id="automobile_' . $id . $automobile_gal_counter . '_box" style="display: block;" class="page-wrap">
                                        <input type="hidden" value="' . urlencode($image_data) . '" name="' . $id . '[]" id="automobile_' . $id . $automobile_gal_counter . '">
                                         <a href="javascript:del_media(\'automobile_' . $id . $automobile_gal_counter . '\')">
                                         <img width="100" height="75" alt="" id="automobile_' . $id . $automobile_gal_counter . '_img" src="' . esc_url($automobile_url) . '">
                                    </a>    
                                    </li>';
                    }
                }
            }
            $automobile_output .= '</ul>
                        </div>';
           
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /*
          multiple custome form upload */

        public function automobile_multiple_inventory_upload_file_field($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_core, $user, $automobile_var_plugin_static_text;

            extract($params);
            $automobile_gallery = '';
            $automobile_gallery = $field_params['gallery'];
            $automobile_output = '';
            $automobile_output .= '
                        <div class="cs-upload-img">
                            <ul>';
            if (is_array($automobile_gallery) && sizeof($automobile_gallery) >= 1) {
                $automobile_gal_counter = 0;
                foreach ($automobile_gallery as $automobile_gal) {
                    $automobile_gal_counter++;

                    $automobile_output .= ' <li id="automobile_' . $id . $automobile_gal_counter . '_box" style="display: block;" class="page-wrap">
                                         <input type="hidden" value="' . esc_url($automobile_gal) . '" name="' . $id . '[]" id="automobile_' . $id . $automobile_gal_counter . '">
                                         <a href="javascript:del_media(\'automobile_' . $id . $automobile_gal_counter . '\')">
                                         <img width="100" height="75" alt="" id="automobile_' . $id . $automobile_gal_counter . '_img" src="' . esc_url($automobile_gal) . '">
                                    </a>    
                                    </li>';
                }
            }
            $automobile_output .= '</ul>
                        </div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render Random String
         */
        public function automobile_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

    }

    global $automobile_form_fields;
    $automobile_form_fields = new automobile_form_fields();
}