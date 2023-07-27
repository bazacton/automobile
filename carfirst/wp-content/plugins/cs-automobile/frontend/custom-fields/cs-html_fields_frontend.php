<?php

/**
 * File Type: Form Fields
 */
if (!class_exists('automobile_html_fields_frontend')) {

    class automobile_html_fields_frontend extends automobile_form_fields {

        private $counter = 0;

        public function __construct() {
            // Do something...
        }

        /* ----------------------------------------------------------------------
         * @ render label
         * --------------------------------------------------------------------- */

        public function automobile_form_label($name = 'Label Not defined') {
            global $post, $pagenow;

            $automobile_output = '<li class="to-label">';
            $automobile_output .= '<label>' . $name . '</label>';
            $automobile_output .= '</li>';

            return $automobile_output;
        }

        /**
         * @ render description
         */
        public function automobile_form_description($description = '') {
            global $post, $pagenow;
            if ($description == '') {
                return;
            }
            $automobile_output = '<div class="left-info">';
            $automobile_output .= '<p>' . $description . '</p>';
            $automobile_output .= '</div>';
            return $automobile_output;
        }

        /**
         * @ render Headings
         */
        public function automobile_heading_render($params = '') {
            global $post;
            extract($params);
            $automobile_output = '<div class="theme-help" id="' . sanitize_html_class($id) . '">
                            <h4 style="padding-bottom:0px;">' . esc_attr($name) . '</h4>
                            <div class="clear"></div>
                          </div>';
            echo force_balance_tags($automobile_output);
        }

        /**
         * @ render text field
         */
        public function automobile_form_text_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $automobile_output = '';
            $std = '';
            $id = '';

            $prefix_enable = 'true'; // default value of prefix add in name and id

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
            } else {
                $automobile_value = isset($std) ? $std : '';
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
            $automobile_output = '';

            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';

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
                $automobile_required = ' required="required"';
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

            $automobile_icon = '';
            $automobile_icon = (isset($icon) and $icon <> '') ? '<i class="' . $icon . '"></i>' : '';
            if (isset($automobile_before) && $automobile_before != '') {
                $automobile_output .= '<div class="' . $automobile_before . '">';
            }
            if (isset($automobile_after) && $automobile_after != '') {
                $automobile_output .= '</div>';
            }



            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $automobile_output .= $automobile_icon;

            $automobile_output .= parent::automobile_form_text_render($field_params);



            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render Radio field
         */
        public function automobile_form_radio_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_output = '<ul class="form-elements">';
            $automobile_output .= $this->automobile_form_label($name);
            $automobile_output .= '<li class="to-field">';
            $automobile_output .= '<div class="input-sec">';
            $automobile_output .= parent::automobile_form_radio_render($field_params);
            $automobile_output .= '</div>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render text field
         */
        public function automobile_form_hidden_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $automobile_rand_id = time();
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
            $automobile_output .= parent::automobile_form_hidden_render($field_params);

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
            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_format = 'd-m-Y';
            if (isset($format) && $format != '') {
                $automobile_format = $format;
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required="required"';
            }
            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }
            $automobile_rand_id = time();
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            $automobile_piker_id = $id;
            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
                $automobile_piker_id = $id . $automobile_rand_id;
            }
            if (isset($force_empty) && $force_empty == true) {
                $value = '';
            }
            $automobile_output = '<div  class="' . $classes . '">';
            $automobile_output .= '<script>
                                jQuery(function(){
                                    jQuery("#automobile_' . $automobile_piker_id . '").datetimepicker({
                                        format:"' . $automobile_format . '",
                                        timepicker:false
                                    });
                                });
                          </script>';
            $automobile_output .= parent::automobile_form_date_render($field_params);
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</div>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render Textarea field
         */
        public function automobile_form_textarea_render($params = '') {
            global $post, $pagenow;
            extract($params);

            if (!isset($std)) {
                $std = '';
            }
            if (!isset($description)) {
                $description = '';
            }
            if (!isset($id)) {
                $id = '';
            }
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            } else {
                $automobile_value = $std;
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

            $automobile_output = '';
            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required="required"';
            }
            if (isset($automobile_before) && $automobile_before != '') {
                $automobile_output .= '<div class="' . $automobile_before . '">';
            }
            $automobile_output .= parent::automobile_form_textarea_render($field_params);
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</div>';
			
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render Rich edito field
         */
        public function automobile_form_editor_render($params = '') {
            global $post, $pagenow;
            extract($params);
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            } else {
                $automobile_value = $std;
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_output = '<div class="input-info">';
            $automobile_output .= '<div class="row">';
            $automobile_output .= '<div class="col-md-12">';
            ob_start();
            wp_editor($value, 'automobile_' . sanitize_html_class($id), $settings = array('textarea_name' => 'automobile_' . sanitize_html_class($id), 'editor_class' => 'text-input', 'teeny' => true, 'media_buttons' => false, 'textarea_rows' => 8, 'quicktags' => false));
            $automobile_editor_contents = ob_get_clean();
            $automobile_output .= $automobile_editor_contents;
            $automobile_output .= '</div>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
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
            if (isset($std) && $std <> '') {
                $std = $std;
            } else {
                $std = '';
            }
            if (isset($id) && $id <> '') {
                $id = $id;
            } else {
                $id = '';
            }
            if (isset($extra_att) && $extra_att <> '') {
                $extra_att = $extra_att;
            } else {
                $extra_att = '';
            }
            $automobile_onchange = '';
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            } else {
                $automobile_value = $std;
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_output = '';
            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }
            if (isset($description) && $description != '') {
                $description = $description;
            } else {
                $value = '';
            }
            $automobile_rand_id = time();
            $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
                $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . $automobile_rand_id . '"';
            }
            $automobile_display = '';
            if (isset($status) && $status == 'hide') {
                $automobile_display = 'style=display:none';
            }
            if (isset($onclick) && $onclick != '') {
                $automobile_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required="required"';
            }
            $automobile_output .= parent::automobile_form_select_render($field_params);
           if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render Multi Select field
         */
        public function automobile_form_multiselect_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $automobile_output = '';
            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';

            $automobile_onchange = '';
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            } else {
                $automobile_value = $std;
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_rand_id = time();
            $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '[]"';
            $automobile_display = '';
            if (isset($status) && $status == 'hide') {
                $automobile_display = 'style=display:none';
            }
            if (isset($onclick) && $onclick != '') {
                $automobile_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
            }
            if (!is_array($value)) {
                $value = array();
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required="required"';
            }
            $automobile_output = '<ul class="form-elements"' . $html_wraper . ' ' . $automobile_display . '>';
            $automobile_output .= $this->automobile_form_label($name);
            $automobile_output .= '<li class="to-field multiple">';

            $automobile_output .= parent::automobile_form_multiselect_render($field_params);

            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render Checkbox field
         */
        public function automobile_form_checkbox_render($params = '') {
            global $post, $pagenow;
            extract($params);
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
            } else {
                $automobile_value = $std;
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_output = '';
            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';

            $automobile_rand_id = time();
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $btn_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $btn_name = ' name="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
            $checked = isset($value) && $value == 'on' ? ' checked="checked"' : '';
            $automobile_output = '<ul class="form-elements">';
            $automobile_output .= $this->automobile_form_label($name);
            $automobile_output .= '<li class="to-field has_input">';
            $automobile_output .= '<label class="pbwp-checkbox cs-chekbox">';
            $automobile_output .= parent::automobile_form_checkbox_render($field_params);
            $automobile_output .= '<span class="pbwp-box"></span>';
            $automobile_output .= '</label>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render File Upload field
         */
        public function automobile_media_url($params = '') {
            global $post, $pagenow;
            extract($params);
            $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
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
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '_btn"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
            $automobile_output = '<ul class="form-elements">';
            $automobile_output .= $this->automobile_form_label($name);
            $automobile_output .= '<li class="to-field">';
            $automobile_output .= '<div class="input-sec">';
            $automobile_output .= parent::automobile_media_url($field_params);
            $automobile_output .= '</div>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * @ render File Upload field
         */
        public function automobile_form_fileupload_render($params = '') {
            global $post, $pagenow;
            extract($params);
            if ($pagenow == 'post.php') {
                $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
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
            $class = '';
            if (isset($value) && $classes != '') {
                $class = " " . $classes;
            }
            $automobile_random_id = AUTOMOBILE_FUNCTIONS()->automobile_rand_id();
            $btn_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $btn_name = ' name="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
            $automobile_output = '<ul class="form-elements">';
            $automobile_output .= $this->automobile_form_label($name);
            $automobile_output .= '<li class="to-field">';
            $automobile_output .= '<div class="page-wrap" ' . $display . ' id="automobile_' . sanitize_html_class($id) . '_box">';
            $automobile_output .= '<div class="gal-active">';
            $automobile_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $automobile_output .= '<ul id="gal-sortable">';
            $automobile_output .= '<li class="ui-state-default" id="">';
            $automobile_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="automobile_' . sanitize_html_class($id) . '_img" width="100" alt="" />';
            $automobile_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'automobile_' . sanitize_html_class($id) . '\')" class="delete"></a> </div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= parent::automobile_form_fileupload_render($field_params);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
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

    global $automobile_html_fields_frontend;
    $automobile_html_fields_frontend = new automobile_html_fields_frontend();
}