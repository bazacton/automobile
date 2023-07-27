<?php
/**
 * Html Fields
 */
if (!class_exists('automobile_var_html_fields')) {

    class automobile_var_html_fields extends automobile_var_form_fields {

        public function __construct() {

            // Do something...
        }

        /**
         * opening field markup
         * 
         */
        public function automobile_var_opening_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $name = isset($name) ? $name : '';
            $automobile_var_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            return $automobile_var_output;
        }

        /**
         * full opening field markup
         * 
         */
        public function automobile_var_full_opening_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '<div class="form-elements"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

            return $automobile_var_output;
        }

        /**
         * closing field markup
         * 
         */
        public function automobile_var_closing_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            if (isset($desc) && $desc != '') {
                $automobile_var_output .= '<p>' . esc_html($desc) . '</p>';
            }
            $automobile_var_output .= '</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '</div>';

            return $automobile_var_output;
        }

        /**
         * division markup
         * 
         */
        public function automobile_var_division($params = '') {
            global $post;
            extract($params);

            $automobile_var_id = 'automobile_var_' . $id;

            $d_enable = ' style="display:none;"';
            if (isset($enable_val)) {

                $d_val = '';
                $d_val = get_post_meta($post->ID, $enable_id, true);

                $enable_multi = explode(',', $enable_val);
                if (is_array($enable_multi) && sizeof($enable_multi) > 1) {
                    $d_enable = in_array($d_val, $enable_multi) ? ' style="display:block;"' : ' style="display:none;"';
                } else {
                    $d_enable = $d_val == $enable_val ? ' style="display:block;"' : ' style="display:none;"';
                }
            }

            $automobile_var_output = '';
            $automobile_var_output .= '<div id="' . $automobile_var_id . '"' . $d_enable . '>';

            if (isset($return) && $return == true) {
                return $automobile_var_output;
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * division markup close
         * 
         */
        public function automobile_var_division_close($params = '') {

            extract($params);
            $automobile_var_output = '</div>';

            if (isset($return) && $return == true) {
                return $automobile_var_output;
            } else {
                echo automobile_allow_special_char($automobile_var_output);
            }
        }

        /**
         * layout style
         * 
         */
        public function automobile_form_layout_render($params = '') {
            global $post, $automobile_var_form_fields, $automobile_var_html_fields;
            extract($params);

            $automobile_value = get_post_meta($post->ID, 'automobile_var_' . $id, true);
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }

            $automobile_left = $automobile_right = $automobile_none = $automobile_left_checklist = $automobile_right_checklist = $automobile_none_checklist = '';
            if (isset($automobile_value)) {
                if (isset($value) && $value == 'left') {
                    $automobile_left = 'checked';
                    $automobile_left_checklist = "class=check-list";
                } if (isset($value) && $value == 'right') {
                    $automobile_right = 'checked';
                    $automobile_right_checklist = "class=check-list";
                } else if (isset($value) && $value == 'none') {
                    $automobile_none = 'checked';
                    $automobile_none_checklist = "class=check-list";
                }
            }

            $help_text_str = '';
            if (isset($help_text) && $help_text != '') {
                $help_text_str = $help_text;
            }

            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';

            $automobile_output = '
			<div  ' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>
				</div>
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_output .= '<div class="input-sec">';
            $automobile_output .= '<div class="meta-input pattern">';
            $automobile_output .= '<div class=\'radio-image-wrapper\'>';
            $automobile_opt_array = array(
                'extra_atr' => '' . $automobile_none . ' onclick="show_sidebar_page(\'none\')"',
                'cust_name' => 'automobile_var_' . sanitize_html_class($id),
                'cust_id' => 'page_radio_1',
                'classes' => 'radio',
                'std' => 'none',
                'return' => true,
            );

            $automobile_output .= $automobile_var_form_fields->automobile_var_form_radio_render($automobile_opt_array);
            $automobile_output .= '<label for="page_radio_1">';
            $automobile_output .= '<span class="ss">';
            $automobile_output .= '<img src="' . get_template_directory_uri() . '/assets/backend/images/no_sidebar.png"  />';
            $automobile_output .= '</span>';
            $automobile_output .= '<span ' . $automobile_none_checklist . ' id="check-list"></span>';
            $automobile_output .= '</label>';
            $automobile_output .= '<span class="title-theme">' . automobile_var_theme_text_srt('automobile_var_full_width') . '</span></div>';
            $automobile_output .= '<div class=\'radio-image-wrapper\'>';

            $automobile_opt_array = array(
                'extra_atr' => '' . $automobile_right . ' onclick="show_sidebar_page(\'right\')"',
                'cust_name' => 'automobile_var_' . sanitize_html_class($id),
                'cust_id' => 'page_radio_2',
                'classes' => 'radio',
                'std' => 'right',
                'return' => true,
            );
            $automobile_output .= $automobile_var_form_fields->automobile_var_form_radio_render($automobile_opt_array);
            $automobile_output .= '<label for="page_radio_2">';
            $automobile_output .= '<span class="ss">';
            $automobile_output .= '<img src="' . get_template_directory_uri() . '/assets/backend/images/sidebar_right.png" />';
            $automobile_output .= '</span>';
            $automobile_output .= '<span ' . $automobile_right_checklist . ' id="check-list"></span>';
            $automobile_output .= '</label>';
            $automobile_output .= '<span class="title-theme">' . automobile_var_theme_text_srt('automobile_var_sidebar_right') . '</span> </div>';
            $automobile_output .= '<div class=\'radio-image-wrapper\'>';

            $automobile_opt_array = array(
                'cust_id' => 'page_radio_3',
                'classes' => 'radio',
                'std' => 'left',
                'extra_atr' => '' . $automobile_left . ' onclick="show_sidebar_page(\'left\')"',
                'cust_name' => 'automobile_var_' . sanitize_html_class($id),
                'return' => true,
            );
            $automobile_output .= $automobile_var_form_fields->automobile_var_form_radio_render($automobile_opt_array);
            $automobile_output .= '<label for="page_radio_3">';
            $automobile_output .= '<span class="ss">';
            $automobile_output .= '<img src="' . get_template_directory_uri() . '/assets/backend/images/sidebar_left.png"  />';
            $automobile_output .= '</span>';
            $automobile_output .= '<span ' . $automobile_left_checklist . ' id="check-list"></span>';
            $automobile_output .= '</label>';
            $automobile_output .= '<span class="title-theme">' . automobile_var_theme_text_srt('automobile_var_sidebar_left') . '</span> </div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
				</div>';

            echo automobile_allow_special_char($automobile_output);
        }

        /**
         * heading markup
         * 
         */
        public function automobile_var_heading_render($params = '') {
            global $post;
            extract($params);
            $automobile_var_output = '
			<div class="theme-help" id="' . sanitize_html_class($id) . '">
				<h4 style="padding-bottom:0px;">' . esc_attr($name) . '</h4>
				<div class="clear"></div>
			</div>';
            echo automobile_allow_special_char($automobile_var_output);
        }

        /**
         * heading markup
         * 
         */
        public function automobile_var_set_heading($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '<li><a title="' . esc_html($name) . '" href="#"><i class="' . sanitize_html_class($fontawesome) . '"></i>
				<span class="cs-title-menu">' . esc_html($name) . '</span></a>';
            if (is_array($options) && sizeof($options) > 0) {
                $active = '';
                $automobile_var_output .= '<ul class="sub-menu">';
                foreach ($options as $key => $value) {
                    $active = ( $key == "tab-general-page-settings" ) ? 'active' : '';
                    $automobile_var_output .= '<li class="' . sanitize_html_class($key) . ' ' . $active . '"><a href="#' . $key . '" onClick="toggleDiv(this.hash);return false;">' . esc_html($value) . '</a></li>';
                }
                $automobile_var_output .= '</ul>';
            }
            $automobile_var_output .= '
			</li>';

            return $automobile_var_output;
        }

        /**
         * main heading markup
         * 
         */
        public function automobile_var_set_main_heading($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '<li><a title="' . $name . '" href="#' . $id . '" onClick="toggleDiv(this.hash);return false;"><i class="' . sanitize_html_class($fontawesome) . '"></i>
			<span class="cs-title-menu">' . esc_html($name) . '</span>
			</a>
			</li>';

            return $automobile_var_output;
        }

        /**
         * sub heading markup
         * 
         */
        public function automobile_var_set_sub_heading($params = '') {
            extract($params);
            $automobile_var_output = '';
            $style = '';
            if ($counter > 1) {
                $automobile_var_output .= '</div>';
            }
            if ($id != 'tab-general-page-settings') {
                $style = 'style="display:none;"';
            }
            $automobile_var_output .= '<div  id="' . $id . '" ' . $style . '>';
            $automobile_var_output .= '<div class="theme-header"><h1>' . esc_html($name) . '</h1>
			</div>';
	    $automobile_var_output .= '<div class="col-holder">';
            $automobile_var_output .= '<div class="col2-right">';

            return $automobile_var_output;
        }

        /**
         * announcement markup
         * 
         */
        public function automobile_var_set_announcement($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '<div id="' . $id . '" class="alert alert-info fade in nomargin theme_box"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
			<h4>' . esc_html($name) . '</h4>
			<p>' . esc_html($std) . '</p></div>';

            return $automobile_var_output;
        }

        /**
         * settings col right markup
         * 
         */
        public function automobile_var_set_col_right($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '
			</div><!-- end col2-right-->';
            if ((isset($col_heading) && $col_heading != '') || (isset($help_text) && $help_text <> '')) {
                $automobile_var_output .= '<div class="col3"><h3>' . esc_html($col_heading) . '</h3><p>' . esc_html($help_text) . '</p></div>';
            }
	    
	    $automobile_var_output .= '</div>';
            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * settings section markup
         * 
         */
        public function automobile_var_set_section($params = '') {
            extract($params);
            $automobile_var_output = '';
            if (isset($accordion) && $accordion == true) {
                if (isset($active) && $active == true) {
                    $active = '';
                } else {
                    $active = ' class="collapsed"';
                }
                $automobile_var_output .= '<div class="panel-heading"><a' . $active . ' href="#accordion-' . esc_attr($id) . '" data-parent="#accordion-' . esc_attr($parrent_id) . '" data-toggle="collapse"><h4>' . esc_html($std) . '</h4>';
            } else {
                $automobile_var_output .= '<div class="theme-help"><h4>' . esc_html($std) . '</h4><div class="clear"></div></div>';
            }
            if (isset($accordion) && $accordion == true) {
                $automobile_var_output .= '</a></div>';
            }

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * text field markup
         * 
         */
        public function automobile_var_text_field($params = '') {
            extract($params);
            $automobile_var_output = '';

            $automobile_var_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $name = isset($name) ? $name : '';
            $field_params = isset($field_params) ? $field_params : '';
            $desc = isset($desc) ? $desc : '';
            $automobile_var_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_var_output .= parent::automobile_var_form_text_render($field_params);
            $automobile_var_output .= '<p>' . esc_html($desc) . '</p></div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * date field markup
         * 
         */
        public function automobile_var_date_field($params = '') {
            extract($params);
            $automobile_var_output = '';

            $automobile_var_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_var_output .= '
			<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_var_output .= parent::automobile_var_form_date_render($field_params);
            $automobile_var_output .= '<p>' . esc_html($desc) . '</p></div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * textarea field markup
         * 
         */
        public function automobile_var_textarea_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_var_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            if(isset($field_params['automobile_editor'])){
                if($field_params['automobile_editor']==true){
                        $editor_class = 'automobile_editor'.mt_rand();
                        $field_params['classes'] .= ' '.$editor_class;	
                }
            }
            $automobile_var_output .= parent::automobile_var_form_textarea_render($field_params);
            $automobile_var_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '</div>';
            if(isset($field_params['automobile_editor'])){
                if($field_params['automobile_editor']==true){
                        echo '<script>
                                jQuery(".'.$editor_class.'").jqte();
                        </script>';
                }
            }
            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * radio field markup
         * 
         */
        public function automobile_var_radio_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '
			<div class="input-sec">';
            $automobile_var_output .= parent::automobile_var_form_radio_render($field_params);
            $automobile_var_output .= esc_html($description);
            $automobile_var_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * select field markup
         * 
         */
        public function automobile_var_select_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_styles = '';
            $desc = isset($desc) ? $desc : '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_var_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            if (isset($array) && $array == true) {
                $automobile_var_random_id = rand(123456, 987654);
                $html_id = ' id="automobile_var_' . sanitize_html_class($id) . $automobile_var_random_id . '"';
            }
            if (isset($multi) && $multi == true) {
                $automobile_var_output .= parent::automobile_var_form_multiselect_render($field_params);
            } else {
                $automobile_var_output .= parent::automobile_var_form_select_render($field_params);
            }
            $automobile_var_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * checkbox field markup
         * 
         */
        public function automobile_var_checkbox_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_var_output .= '
			<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_var_output .= parent::automobile_var_form_checkbox_render($field_params);
            $automobile_var_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * upload media field markup
         * 
         */
        public function automobile_var_media_url_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_var_output .= parent::automobile_var_media_url($field_params);
            $automobile_var_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * upload file field markup
         * 
         */
        public function automobile_var_upload_file_field($params = '') {
            global $post, $pagenow, $image_val;

            extract($params);
            $std = isset($std) ? $std : '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_var_value = get_post_meta($post->ID, 'automobile_var_' . $id, true);
                }
            } elseif (isset($user) && !empty($user)) {

                if (isset($dp) && $dp == true) {

                    $automobile_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    $automobile_var_value = get_the_author_meta('automobile_var_' . $id, $user->ID);
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
            if (isset($value) && $value != '') {
                $display = 'style=display:block';
            } else {
                $display = 'style=display:none';
            }

            $automobile_var_random_id = '';
            $html_id = ' id="automobile_var_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $automobile_var_random_id = rand(123456, 987654);
              
                $html_id = ' id="automobile_var_' . sanitize_html_class($id) . $automobile_var_random_id . '"';
            }
            
            $field_params['automobile_var_random_id'] = $automobile_var_random_id;

            $automobile_var_output = '';
            $automobile_var_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_var_output .= '<div' . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	    <label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_var_output .= parent::automobile_var_form_fileupload_render($field_params);
            $automobile_var_output .= '<div class="page-wrap" ' . $display . ' id="automobile_var_' . sanitize_html_class($id) . $automobile_var_random_id . '_box">';
            $automobile_var_output .= '<div class="gal-active">';
            $automobile_var_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $automobile_var_output .= '<ul id="gal-sortable">';
            $automobile_var_output .= '<li class="ui-state-default" id="">';
            $automobile_var_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="automobile_var_' . sanitize_html_class($id) . $automobile_var_random_id . '_img" width="100" />';
            $automobile_var_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'automobile_var_' . sanitize_html_class($id) . $automobile_var_random_id . '\')" class="delete"></a> </div>';
            $automobile_var_output .= '</div>';
            $automobile_var_output .= '</li>';
            $automobile_var_output .= '</ul>';
            $automobile_var_output .= '</div>';
            $automobile_var_output .= '</div>';
            $automobile_var_output .= '</div>';

            $automobile_var_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        /**
         * select page field markup
         * 
         */
        public function automobile_var_select_page_field($params = '') {
            extract($params);
            $automobile_var_output = '';
            $automobile_var_output .= '
			<div class="form-elements">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="select-style">';
            $automobile_var_output .= wp_dropdown_pages($args);
            $automobile_var_output .= '<p>' . esc_html($desc) . '</p>
					</div>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        public function automobile_var_multi_fields($params = '') {
            extract($params);
            $automobile_var_output = '';

            $automobile_var_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_var_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_var_output .= '
			<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_var_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_var_output .= automobile_var_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_var_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            if (isset($fields_list) && is_array($fields_list)) {
                foreach ($fields_list as $field_array) {
                    if ($field_array['type'] == 'text') {
                        $automobile_var_output .= parent::automobile_var_form_text_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'hidden') {
                        $automobile_var_output .= parent::automobile_var_form_hidden_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'select') {
                        $automobile_var_output .= parent::automobile_var_form_select_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'multiselect') {
                        $automobile_var_output .= parent::automobile_var_form_multiselect_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'checkbox') {
                        $automobile_var_output .= parent::automobile_var_form_checkbox_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'radio') {
                        $automobile_var_output .= parent::automobile_var_form_radio_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'date') {
                        $automobile_var_output .= parent::automobile_var_form_radio_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'textarea') {
                        $automobile_var_output .= parent::automobile_var_form_textarea_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'media') {
                        $automobile_var_output .= parent::automobile_var_media_url($field_array['field_params']);
                    } elseif ($field_array['type'] == 'fileupload') {
                        $automobile_var_output .= '<div class="page-wrap" ' . $display . ' id="automobile_var_' . sanitize_html_class($id) . '_box">';
                        $automobile_var_output .= '<div class="gal-active">';
                        $automobile_var_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
                        $automobile_var_output .= '<ul id="gal-sortable">';
                        $automobile_var_output .= '<li class="ui-state-default" id="">';
                        $automobile_var_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="automobile_var_' . sanitize_html_class($id) . '_img" width="100"  />';
                        $automobile_var_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'automobile_var_' . sanitize_html_class($id) . '\')" class="delete"></a> </div>';
                        $automobile_var_output .= '</div>';
                        $automobile_var_output .= '</li>';
                        $automobile_var_output .= '</ul>';
                        $automobile_var_output .= '</div>';
                        $automobile_var_output .= '</div>';
                        $automobile_var_output .= '</div>';
                        $automobile_var_output .= parent::automobile_var_form_fileupload_render($field_params);
                    } elseif ($field_array['type'] == 'dropdown_pages') {
                        $automobile_var_output .= wp_dropdown_pages($args);
                    }
                }
            }

            $automobile_var_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_var_output .= '<div class="splitter"></div>';
            }
            $automobile_var_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo automobile_allow_special_char($automobile_var_output);
            } else {
                return $automobile_var_output;
            }
        }

        public function automobile_var_get_attachment_id($attachment_url) {
            global $wpdb;
            $attachment_id = false;
            //  If there is no url, return. 
            if ('' == $attachment_url)
                return;
            // Get the upload directory paths 
            $upload_dir_paths = wp_upload_dir();
            if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {
                //  If this is the URL of an auto-generated thumbnail, get the URL of the original image 
                $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);
                // Remove the upload path base directory from the attachment URL 
                $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

                $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
            }
            return $attachment_id;
        }

        public function automobile_var_get_icon_for_attachment($post_id) {

            return wp_get_attachment_image($post_id, 'thumbnail');
        }

        public function automobile_gallery_render($params = '') {
            extract($params);
            global $post, $automobile_var_plugin_core, $automobile_var_plugin_static_text;
           

            $automobile_var_random_id = rand(156546, 956546);
            ?>
            <div class="cs-gallery-con">
                <div id="gallery_container_<?php echo esc_attr($automobile_var_random_id); ?>" data-csid="automobile_<?php echo esc_attr($id) ?>">
                    <script>
                        jQuery(document).ready(function () {
                            jQuery("#gallery_sortable_<?php echo esc_attr($automobile_var_random_id); ?>").sortable({
                                out: function (event, ui) {
                                    automobile_var_gallery_sorting_list('<?php echo 'automobile_' . sanitize_html_class($id); ?>', '<?php echo esc_attr($automobile_var_random_id); ?>');
                                }
                            });

                            gal_num_of_items('<?php echo esc_html($id) ?>', '<?php echo absint($automobile_var_random_id) ?>', '');

                            jQuery('#gallery_container_<?php echo esc_attr($automobile_var_random_id); ?>').on('click', 'a.delete', function () {
                                gal_num_of_items('<?php echo esc_attr($id) ?>', '<?php echo absint($automobile_var_random_id) ?>', 1);
                                jQuery(this).closest('li.image').remove();
                                automobile_var_gallery_sorting_list('<?php echo 'automobile_' . sanitize_html_class($id); ?>', '<?php echo esc_attr($automobile_var_random_id); ?>');
                            });
                        });
                    </script>
                    <ul class="gallery_images" id="gallery_sortable_<?php echo esc_attr($automobile_var_random_id); ?>">
                        <?php
                        $gallery = get_post_meta($post->ID, 'automobile_' . $id . '_url', true);

                        $automobile_var_gal_counter = 0;
                        if (is_array($gallery) && sizeof($gallery) > 0) {
                            foreach ($gallery as $attach_url) {

                                if ($attach_url != '') {

                                    $automobile_var_gal_id = rand(156546, 956546);

                                    $automobile_var_attach_id = $automobile_var_plugin_core->automobile_var_get_attachment_id($attach_url);

                                    $automobile_var_attach_img = $this->automobile_var_get_icon_for_attachment($automobile_var_attach_id);
                                    echo '
                                    <li class="image" data-attachment_id="' . esc_attr($automobile_var_gal_id) . '">
                                        ' . $automobile_var_attach_img . '
                                        <input type="hidden" value="' . esc_url($attach_url) . '" name="automobile_' . $id . '_url[]" />
                                        <div class="actions">
                                            <span><a href="javascript:;" class="delete tips" data-tip="' . automobile_var_theme_text_srt('automobile_var_delete_image') . '"><i class="icon-times"></i></a></span>
                                        </div>
                                    </li>';
                                }
                                $automobile_var_gal_counter++;
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div id="automobile_var_<?php echo esc_attr($id) ?>_temp"></div>
                <input type="hidden" value="" name="automobile_<?php echo esc_attr($id) ?>_num" />
                <div style="width:100%; display:inline-block; margin:20px 0;">
                    <label class="add_gallery hide-if-no-js" data-id="<?php echo 'automobile_' . sanitize_html_class($id); ?>" data-rand_id="<?php echo esc_attr($automobile_var_random_id); ?>">
                        <input type="button" class="button button-primary button-large" data-choose="<?php echo esc_attr($name); ?>" data-update="<?php echo esc_attr($name); ?>" data-delete="<?php echo automobile_var_theme_text_srt('automobile_var_delete'); ?>" data-text="<?php echo automobile_var_theme_text_srt('automobile_var_delete'); ?>"  value="<?php echo esc_attr($name); ?>">
                    </label>
                </div>
            </div>
            <?php
        }

        public function automobile_var_gallery_render($params = '') {
            global $post;
            extract($params);
            $automobile_var_random_id = rand(156546, 956546);
            ?>
            <div class="form-elements">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label><?php echo automobile_var_theme_text_srt('automobile_var_add_gallery'); ?></label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div id="gallery_container_<?php echo esc_attr($automobile_var_random_id); ?>" data-csid="automobile_var_<?php echo esc_attr($id) ?>">
                        <script>
                            jQuery(document).ready(function () {
                                jQuery("#gallery_sortable_<?php echo esc_attr($automobile_var_random_id); ?>").sortable({
                                    out: function (event, ui) {
                                        automobile_var_gallery_sorting_list('<?php echo 'automobile_var_' . sanitize_html_class($id); ?>', '<?php echo esc_attr($automobile_var_random_id); ?>');
                                    }
                                });

                                gal_num_of_items('<?php echo esc_attr($id) ?>', '<?php echo absint($automobile_var_random_id) ?>', '');

                                jQuery('#gallery_container_<?php echo esc_attr($automobile_var_random_id); ?>').on('click', 'a.delete', function () {
                                    gal_num_of_items('<?php echo esc_attr($id) ?>', '<?php echo absint($automobile_var_random_id) ?>', 1);
                                    jQuery(this).closest('li.image').remove();
                                    automobile_var_gallery_sorting_list('<?php echo 'automobile_var_' . sanitize_html_class($id); ?>', '<?php echo esc_attr($automobile_var_random_id); ?>');
                                });
                            });
                        </script>
                        <ul class="gallery_images" id="gallery_sortable_<?php echo esc_attr($automobile_var_random_id); ?>">
                            <?php
                            $gallery = get_post_meta($post->ID, 'automobile_var_' . $id . '_url', true);
                            $gallery_titles = get_post_meta($post->ID, 'automobile_var_' . $id . '_title', true);
                            $gallery_descs = get_post_meta($post->ID, 'automobile_var_' . $id . '_desc', true);

                            $automobile_var_gal_counter = 0;
                            if (is_array($gallery) && sizeof($gallery) > 0) {
                                foreach ($gallery as $attach_url) {

                                    if ($attach_url != '') {

                                        $automobile_var_gal_id = rand(156546, 956546);

                                        $automobile_var_gallery_title = isset($gallery_titles[$automobile_var_gal_counter]) ? $gallery_titles[$automobile_var_gal_counter] : '';
                                        $automobile_var_gallery_desc = isset($gallery_descs[$automobile_var_gal_counter]) ? $gallery_descs[$automobile_var_gal_counter] : '';

                                        $automobile_var_attach_id = $this->automobile_var_get_attachment_id($attach_url);

                                        $automobile_var_attach_img = $this->automobile_var_get_icon_for_attachment($automobile_var_attach_id);
                                        echo '
                                            <li class="image" data-attachment_id="' . esc_attr($automobile_var_gal_id) . '">
                                                    ' . $automobile_var_attach_img . '
                                                    <input type="hidden" value="' . esc_url($attach_url) . '" name="automobile_var_' . $id . '_url[]" />
                                                    <div class="actions">
                                                            <span><a href="javascript:automobile_var_createpop(\'edit_track_form' . absint($automobile_var_gal_id) . '\',\'filter\')"><i class="icon-edit3"></i></a></span>
                                                            <span><a href="javascript:;" class="delete tips" data-tip="' . automobile_var_theme_text_srt('automobile_var_delete_image') . '"><i class="icon-times"></i></a></span>
                                                    </div>
                                                    <tr class="parentdelete" id="edit_track' . absint($automobile_var_gal_id) . '">
                                                      <td style="width:0">
                                                      <div id="edit_track_form' . absint($automobile_var_gal_id) . '" style="display: none;" class="table-form-elem">
                                                              <div class="cs-heading-area">
                                                                    <h5 style="text-align: left;">' . automobile_var_theme_text_srt('automobile_var_edit_item') . '</h5>
                                                                    <span onclick="javascript:automobile_var_remove_overlay(\'edit_track_form' . absint($automobile_var_gal_id) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                                                                    <div class="clear"></div>
                                                              </div>
                                                              <div class="form-elements">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                      <label>&nbsp;</label>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                      ' . $automobile_var_attach_img . '
                                                                    </div>
                                                              </div>
                                                              <div class="form-elements">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                      <label>' . automobile_var_theme_text_srt('automobile_var_title') . '</label>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                      <input type="text" name="automobile_var_' . $id . '_title[]" value="' . esc_html($automobile_var_gallery_title) . '" />
                                                                    </div>
                                                              </div>
                                                              <div class="form-elements">
                                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                                      <label>' . automobile_var_theme_text_srt('automobile_var_description') . '</label>
                                                                    </div>
                                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                                      <textarea name="automobile_var_' . $id . '_desc[]">' . esc_html($automobile_var_gallery_desc) . '</textarea>
                                                                    </div>
                                                              </div>
                                                              <ul class="form-elements noborder">
                                                                    <li class="to-label">
                                                                      <label></label>
                                                                    </li>
                                                                    <li class="to-field">
                                                                      <input type="button" value="' . automobile_var_theme_text_srt('automobile_var_update') . '" onclick="automobile_var_remove_overlay(\'edit_track_form' . absint($automobile_var_gal_id) . '\',\'append\')" />
                                                                    </li>
                                                              </ul>
                                                            </div>
                                                            </td>
                                                    </tr>
                                            </li>';
                                    }
                                    $automobile_var_gal_counter++;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div id="automobile_var_<?php echo esc_attr($id) ?>_temp"></div>
                    <input type="hidden" value="" name="automobile_var_<?php echo esc_attr($id) ?>_num" />
                    <div style="width:100%; display:inline-block; margin:20px 0;">
                        <label class="browse-icon add_gallery hide-if-no-js" data-id="<?php echo 'automobile_var_' . sanitize_html_class($id); ?>" data-rand_id="<?php echo esc_attr($automobile_var_random_id); ?>">
                            <input type="button" class="left" data-choose="<?php echo esc_attr($name); ?>" data-update="<?php echo esc_attr($name); ?>" data-delete="<?php echo automobile_var_theme_text_srt('automobile_var_delete'); ?>" data-text="<?php echo automobile_var_theme_text_srt('automobile_var_delete'); ?>"  value="<?php echo esc_attr($name); ?>">
                        </label>
                    </div>
                </div>
            </div>
            <?php
        }

    }

    $var_arrays = array('automobile_var_html_fields');
    $automobile_var_html_fields_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
    extract($automobile_var_html_fields_global_vars);
    $automobile_var_html_fields = new automobile_var_html_fields();
}
