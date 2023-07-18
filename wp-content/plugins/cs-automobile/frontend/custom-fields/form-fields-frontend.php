<?php

/**
 * File Type: Form Fields
 */
if (!class_exists('automobile_form_fields_frontend')) {

    class automobile_form_fields_frontend {

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

        /* ----------------------------------------------------------------------
         * @ render description
         * --------------------------------------------------------------------- */

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

        /* ----------------------------------------------------------------------
         * @ render Headings
         * --------------------------------------------------------------------- */

        public function automobile_heading_render($params = '') {
            global $post;
            extract($params);
            $automobile_output = '<div class="theme-help" id="' . sanitize_html_class($id) . '">
                            <h4 style="padding-bottom:0px;">' . esc_attr($name) . '</h4>
                            <div class="clear"></div>
                          </div>';
            echo force_balance_tags($automobile_output);
        }

        /* ----------------------------------------------------------------------
         * @ render text field
         * --------------------------------------------------------------------- */

        public function automobile_form_text_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $automobile_rand_value = '';
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
            if (isset($no_border) && $no_border == true) {
                $no_border = ' noborder';
            } else {
                $no_border = '';
            }
            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }
            $automobile_rand_id = time();
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $automobile_rand_value = rand(0, 9999997878);
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
            // Disbaled Field
            $automobile_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $automobile_visibilty = 'readonly="readonly"';
            }
            $automobile_required = '';
            if (isset($required) && $required == 'yes') {
                $automobile_required = ' required="required"';
            }
            $automobile_icon = '';
            $automobile_icon = (isset($icon) and $icon <> '') ? '<i class="' . $icon . '"></i>' : '';
            //Calculate Remainings
            $automobile_output = '<div class="' . $classes . '">';
            $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_value . '"';
            $automobile_output .= $automobile_icon;
            $automobile_output .= '<input type="text" ' . $automobile_visibilty . $automobile_required . ' class="cs-form-text cs-input form-control" ' . $html_id . $html_name . '  value="' . sanitize_text_field($value) . '" placeholder="' . $name . '" />';
            $automobile_output .= '</div>';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render Radio field
         * --------------------------------------------------------------------- */

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
            $automobile_output .= '<input type="radio" class="cs-form-text cs-input " name="automobile_' . sanitize_html_class($id) . '" id="automobile_' . sanitize_html_class($id) . '" value="' . sanitize_text_field($value) . '" />';
            $automobile_output .= '</div>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            echo force_balance_tags($automobile_output);
        }

        /* ----------------------------------------------------------------------
         * @ render Hidden field
         * --------------------------------------------------------------------- */

        public function automobile_form_hidden_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $automobile_rand_id = time();
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
            $automobile_output = '<input type="hidden" id="automobile_' . sanitize_text_field($id) . '" class="cs-form-text cs-input"' . $html_name . ' value="' . sanitize_text_field($std) . '" />';
            if (isset($return) && $return == 'true') {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render Date field
         * --------------------------------------------------------------------- */

        public function automobile_form_date_render($params = '') {
            global $post, $pagenow;
            extract($params);
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
            $automobile_output .= '<input type="text"' . $automobile_required . ' class="cs-form-text cs-input form-control" ' . $html_id . $html_name . '  value="' . sanitize_text_field($value) . '" placeholder="' . $name . '" />';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</div>';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render Textarea field
         * --------------------------------------------------------------------- */

        public function automobile_form_textarea_render($params = '') {
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
            $automobile_rand_id = time();
            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }
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
            $automobile_output = '<div class="' . $classes . '">';
            $automobile_output .= ' <textarea' . $automobile_required . ' rows="5" cols="30"' . $html_id . $html_name . ' placeholder="' . $name . '">' . sanitize_text_field($value) . '</textarea>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</div>';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render Rich editor field
         * --------------------------------------------------------------------- */

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

        /* ----------------------------------------------------------------------
         * @ render select field
         * --------------------------------------------------------------------- */

        public function automobile_form_select_render($params = '') {
            global $post, $pagenow,$automobile_var_plugin_static_text;
            extract($params);
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
            $automobile_output .= $this->automobile_form_label($name);
                 $automobile_output .= '<select' . $html_id . $html_name . ' ' . $automobile_onchange . $automobile_required . ' data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_please_select') . '" class="chosen-select">';
            foreach ($options as $key => $option) {
                $automobile_output .= '<option ' . selected($key, $value, false) . 'value="' . $key . '">' . $option . '</option>';
            }
            $automobile_output .= '</select>';
            $automobile_output .= $holder;
            $automobile_output .= $this->automobile_form_description($description);
               if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render Multi Select field
         * --------------------------------------------------------------------- */

        public function automobile_form_multiselect_render($params = '') {
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
            global $post, $pagenow,$automobile_var_plugin_static_text;
            extract($params);
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
            $automobile_output .= '<select' . $automobile_required . ' class="multiple" multiple="multiple" ' . $html_id . $html_name . ' ' . $automobile_onchange . ' style="height:110px !important;"data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_please_select') . '" class="chosen-select">';
            foreach ($options as $key => $option) {
                $selected = '';
                if (in_array($key, $value)) {
                    $selected = 'selected="selected"';
                }
                $automobile_output .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
            }
            $automobile_output .= '</select>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render Checkbox field
         * --------------------------------------------------------------------- */

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
            $automobile_rand_id = time();
            $html_id = ' id="automobile_' . sanitize_html_class($id) . '"';
            $btn_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            $html_name = ' name="automobile_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $btn_name = ' name="automobile_' . sanitize_html_class($id) . $automobile_rand_id . '"';
                $html_name = ' name="automobile_' . sanitize_html_class($id) . '_array[]"';
            }
			$automobile_allow_search = get_user_meta(get_current_user_id(), 'automobile_allow_search', true);
                        $checked = isset($automobile_allow_search) && $automobile_allow_search == 'yes' ? ' checked="checked"' : '';
			if(isset($view) && $view=='simple'){
				$automobile_output='';
				 $automobile_output .= '<input type="hidden" '.$html_name . ' value="' . sanitize_text_field($std) . '" />';
				 $automobile_output .= '<input type="checkbox" '.$html_id . ' class="myClass"' . $btn_name.'check' . $checked . ' />';
				 if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
				} else {
                echo force_balance_tags($automobile_output);
				}
			}
			else{
            $automobile_output = '<ul class="form-elements">';
            $automobile_output .= $this->automobile_form_label($name);
            $automobile_output .= '<li class="to-field has_input">';
            $automobile_output .= '<label class="pbwp-checkbox cs-chekbox">';
            $automobile_output .= '<input type="hidden"' . $html_id . $html_name . ' value="' . sanitize_text_field($std) . '" />';
            $automobile_output .= '<input type="checkbox" class="myClass"' . $btn_name . $checked . ' />';
            $automobile_output .= '<span class="pbwp-box"></span>';
            $automobile_output .= '</label>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
			}
        }

        /* ----------------------------------------------------------------------
         * @ render File Upload field
         * --------------------------------------------------------------------- */

        public function automobile_media_url($params = '') {
            global $post, $pagenow,$automobile_var_plugin_static_text;
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
            $automobile_output .= '<input type="text" class="cs-form-text cs-input" ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';
            $automobile_output .= '<label class="cs-browse">';
            $automobile_output .= '<input type="button" ' . $html_id_btn . $html_name . ' class="uploadfile left" value="' . automobile_var_plugin_text_srt('automobile_var_browse') . '"/>';
            $automobile_output .= '</label>';
            $automobile_output .= '</div>';
            $automobile_output .= $this->automobile_form_description($description);
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render File Upload field
         * --------------------------------------------------------------------- */

        public function automobile_form_fileupload_render($params = '') {
            global $post, $pagenow,$automobile_var_plugin_static_text;
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
            $automobile_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';
            $automobile_output .= '<label class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left ' . $class . '" value="' . automobile_var_plugin_text_srt('automobile_var_browse') . '" /></label>';
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            if (isset($return) && $return == true) {
                return force_balance_tags($automobile_output);
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /* ----------------------------------------------------------------------
         * @ render Random String
         * --------------------------------------------------------------------- */

        public function automobile_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

    }

    global $automobile_form_fields_frontend;
    $automobile_form_fields_frontend = new automobile_form_fields_frontend();
}