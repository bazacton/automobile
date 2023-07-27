<?php
/**
 * File Type: Form Fields
 */
if (!class_exists('automobile_html_fields')) {

    class automobile_html_fields extends automobile_form_fields {

        public function __construct() {

// Do something...
        }

        /**
         * opening field markup
         * 
         */
        public function automobile_opening_field($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '
			<div class="form-elements">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            return $automobile_output;
        }

        /**
         * full opening field markup
         * 
         */
        public function automobile_full_opening_field($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '<div class="form-elements"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';

            return $automobile_output;
        }

        /**
         * closing field markup
         * 
         */
        public function automobile_closing_field($params = '') {
            extract($params);
            $automobile_output = '';
            if (isset($desc) && $desc != '') {
                $automobile_output .= '<p>' . esc_html($desc) . '</p>';
            }
            $automobile_output .= '</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '</div>';

            return $automobile_output;
        }

        /**
         * heading markup
         * 
         */
        public function automobile_heading_render($params = '') {
            global $post;
            extract($params);
            $automobile_output = '
			<div class="theme-help" id="' . sanitize_html_class($id) . '">
				<h4 style="padding-bottom:0px;">' . esc_attr($name) . '</h4>
				<div class="clear"></div>
			</div>';
            if (isset($echo) && $echo == false) {
                return $automobile_output;
            } else {
                echo force_balance_tags($automobile_output);
            }
        }

        /**
         * heading markup
         * 
         */
        public function automobile_set_heading($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '<li><a title="' . esc_html($name) . '" href="#"><i class="' . sanitize_html_class($fontawesome) . '"></i>
				<span class="cs-title-menu">' . esc_html($name) . '</span></a>';
            if (is_array($options) && sizeof($options) > 0) {
                $active = '';
                $automobile_output .= '<ul class="sub-menu">';
                foreach ($options as $key => $value) {
                    $active = ( $key == "tab-general-page-settings" ) ? 'active' : '';
                    $automobile_output .= '<li class="' . sanitize_html_class($key) . ' ' . $active . '"><a href="#' . $key . '" onClick="toggleDiv(this.hash);return false;">' . esc_html($value) . '</a></li>';
                }
                $automobile_output .= '</ul>';
            }
            $automobile_output .= '
			</li>';

            return $automobile_output;
        }

        /**
         * main heading markup
         * 
         */
        public function automobile_set_main_heading($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '<li><a title="' . $name . '" href="#' . $id . '" onClick="toggleDiv(this.hash);return false;"><i class="' . sanitize_html_class($fontawesome) . '"></i>
			<span class="cs-title-menu">' . esc_html($name) . '</span>
			</a>
			</li>';

            return $automobile_output;
        }

        /**
         * sub heading markup
         * 
         */
        public function automobile_set_sub_heading($params = '') {
            extract($params);
            $automobile_output = '';
            $style = '';
            if ($counter > 1) {
                $automobile_output .= '</div>';
            }
            if ($id != 'tab-general-page-settings') {
                $style = 'style="display:none;"';
            }
            $automobile_output .= '<div  id="' . $id . '" ' . $style . '>';
            $automobile_output .= '<div class="theme-header"><h1>' . esc_html($name) . '</h1>
			</div>';
            $automobile_output .= '<div class="col-holder">';
            $automobile_output .= '<div class="col2-right">';

            return $automobile_output;
        }

        /**
         * announcement markup
         * 
         */
        public function automobile_set_announcement($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '<div id="' . $id . '" class="alert alert-info fade in nomargin theme_box"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#215;</button>
			<h4>' . esc_html($name) . '</h4>
			<p>' . esc_html($std) . '</p></div>';

            return $automobile_output;
        }

        /**
         * settings col right markup
         * 
         */
        public function automobile_set_col_right($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '
			</div><!-- end col2-right-->';
            if ((isset($col_heading) && $col_heading != '') || (isset($help_text) && $help_text <> '')) {
                $automobile_output .= '<div class="col3"><h3>' . esc_html($col_heading) . '</h3><p>' . esc_html($help_text) . '</p></div>';
            }
            
            $automobile_output .= '</div>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * settings section markup
         * 
         */
        public function automobile_set_section($params = '') {
            extract($params);
            $automobile_output = '';
            if (isset($accordion) && $accordion == true) {
                if (isset($active) && $active == true) {
                    $active = '';
                } else {
                    $active = ' class="collapsed"';
                }
                $automobile_output .= '<div class="panel-heading"><a' . $active . ' href="#accordion-' . esc_attr($id) . '" data-parent="#accordion-' . esc_attr($parrent_id) . '" data-toggle="collapse"><h4>' . esc_html($std) . '</h4>';
            } else {
                $automobile_output .= '<div class="theme-help"><h4>' . esc_html($std) . '</h4><div class="clear"></div></div>';
            }
            if (isset($accordion) && $accordion == true) {
                $automobile_output .= '</a></div>';
            }

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * text field markup
         * 
         */
        public function automobile_text_field($params = '') {
            extract($params);
            $automobile_output = '';

            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $name = isset($name) ? $name : '';
            $field_params = isset($field_params) ? $field_params : '';
            $desc = isset($desc) ? $desc : '';
            $automobile_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
			<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            $automobile_output .= parent::automobile_form_text_render($field_params);
            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * date field markup
         * 
         */
        public function automobile_date_field($params = '') {
            extract($params);
            $automobile_output = '';

            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_output .= '
			<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_output .= parent::automobile_form_date_render($field_params);
            $automobile_output .= '<p>' . esc_html($desc) . '</p></div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * textarea field markup
         * 
         */
        public function automobile_textarea_field($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            if (isset($field_params['automobile_editor'])) {
                if ($field_params['automobile_editor'] == true) {
                    $editor_class = 'automobile_editor' . mt_rand();
                    $field_params['classes'] .= ' ' . $editor_class;
                }
            }
            $automobile_output .= parent::automobile_form_textarea_render($field_params);
            if ($desc != '') {
                $automobile_output .= '<p>' . esc_html($desc) . '</p>';
            }
            $automobile_output .= '</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '</div>';
            if (isset($field_params['automobile_editor'])) {
                if ($field_params['automobile_editor'] == true) {
                    echo '<script>
                                jQuery(".' . $editor_class . '").jqte();
                        </script>';
                }
            }
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * radio field markup
         * 
         */
        public function automobile_radio_field($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '
			<div class="input-sec">';
            $automobile_output .= parent::automobile_form_radio_render($field_params);
            $automobile_output .= esc_html($description);
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        public function automobile_var_get_icon_for_attachment($post_id) {

            return wp_get_attachment_image($post_id, 'thumbnail');
        }

        public function automobile_gallery_render($params = '') {
            extract($params);
            global $post, $automobile_var_plugin_core, $automobile_var_plugin_static_text;
            $automobile_var_delete_image = isset($automobile_var_plugin_static_text['automobile_var_delete_image']) ? $automobile_var_plugin_static_text['automobile_var_delete_image'] : '';
            $automobile_var_delete = isset($automobile_var_plugin_static_text['automobile_var_delete']) ? $automobile_var_plugin_static_text['automobile_var_delete'] : '';

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
                                    if ($automobile_var_attach_id == '') {
                                        $thumbnail_size_image = automobile_get_image_thumb($attach_url, 'automobile_var_media_6');
                                        $automobile_var_attach_img = '<img src="' . $thumbnail_size_image . '">';
                                    }
                                    echo '
                                    <li class="image" data-attachment_id="' . esc_attr($automobile_var_gal_id) . '">
                                        ' . $automobile_var_attach_img . '
                                        <input type="hidden" value="' . esc_url($attach_url) . '" name="automobile_' . $id . '_url[]" />
                                        <div class="actions">
                                            <span><a href="javascript:;" class="delete tips" data-tip="' . esc_html($automobile_var_delete_image) . '"><i class="icon-times"></i></a></span>
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
                        <input type="button" class="button button-primary button-large" data-choose="<?php echo esc_attr($name); ?>" data-update="<?php echo esc_attr($name); ?>" data-delete="<?php echo esc_html($automobile_var_delete); ?>" data-text="<?php echo esc_html($automobile_var_delete); ?>"  value="<?php echo esc_attr($name); ?>">
                    </label>
                </div>
            </div>
            <?php
        }

        /**
         * select field markup
         * 
         */
        public function automobile_select_field($params = '') {
            extract($params);
            global $automobile_var_plugin_core;
            $automobile_output = '';
            $automobile_styles = '';
            $desc = isset($desc) ? $desc : '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            if (isset($array) && $array == true) {
                $automobile_random_id = $automobile_var_plugin_core->automobile_rand_id();
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
            }
            if (isset($multi) && $multi == true) {
                $automobile_output .= parent::automobile_form_multiselect_render($field_params);
            } else {
                $automobile_output .= parent::automobile_form_select_render($field_params);
            }
            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }
        public function automobile_select_field_front($params = '') {
            extract($params);
            global $automobile_var_plugin_core;
            $automobile_output = '';
            $automobile_styles = '';
            $desc = isset($desc) ? $desc : '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_output .= '<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '><div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-9 col-md-9 col-sm-12 col-xs-12"><div class="cs-field-holder">';

            if (isset($array) && $array == true) {
                $automobile_random_id = $automobile_var_plugin_core->automobile_rand_id();
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
            }
            if (isset($multi) && $multi == true) {
                $automobile_output .= parent::automobile_form_multiselect_render($field_params);
            } else {
                $automobile_output .= parent::automobile_form_select_render($field_params);
            }
            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div></div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }
        /**
         * checkbox field markup
         * 
         */
        public function automobile_checkbox_field($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_output .= '
			<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_output .= parent::automobile_form_checkbox_render($field_params);
            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * upload media field markup
         * 
         */
        public function automobile_media_url_field($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_output .= parent::automobile_media_url($field_params);
            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * upload file field markup
         * 
         */
        public function automobile_upload_cv_file_field($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_core;

            extract($params);
            $std = isset($std) ? $std : '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
                }
            } elseif (isset($user) && !empty($user)) {

                if (isset($dp) && $dp == true) {

                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
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
                $automobile_random_id = $automobile_var_plugin_core->automobile_rand_id();
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
            }

            $field_params['automobile_random_id'] = $automobile_random_id;

            $automobile_output = '';
            $automobile_output .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	    <label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_output .= parent::automobile_form_cvupload_render($field_params);
            $automobile_output .= '<div class="page-wrap" ' . $display . ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_box">';
            $automobile_output .= '<div class="gal-active">';
            $automobile_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $automobile_output .= '<ul id="gal-sortable">';
            $automobile_output .= '<li class="ui-state-default" id="">';
            $automobile_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_img" width="100" alt="" />';
            $automobile_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'automobile_' . sanitize_html_class($id) . $automobile_random_id . '\')" class="delete"></a> </div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';

            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * upload file field markup
         * 
         */
        public function automobile_upload_file_field($params = '') {
            global $post, $pagenow, $image_val;

            extract($params);
            $std = isset($std) ? $std : '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
                }
            } elseif (isset($user) && !empty($user)) {

                if (isset($dp) && $dp == true) {

                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
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

            $field_params['automobile_random_id'] = $automobile_random_id;

            $automobile_output = '';
            $automobile_output .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	    <label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $automobile_output .= parent::automobile_form_fileupload_render($field_params);
            $automobile_output .= '<div class="page-wrap" ' . $display . ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_box">';
            $automobile_output .= '<div class="gal-active">';
            $automobile_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $automobile_output .= '<ul id="gal-sortable">';
            $automobile_output .= '<li class="ui-state-default" id="">';
            $automobile_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_img" width="100" alt="" />';
            $automobile_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'automobile_' . sanitize_html_class($id) . $automobile_random_id . '\')" class="delete"></a> </div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';

            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        public function automobile_custom_upload_file_field($params = '') {
            global $post, $pagenow, $image_val, $automobile_var_plugin_core;

            extract($params);
            $std = isset($std) ? $std : '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $automobile_value = get_post_meta($post->ID, $id, true);
                } else {
                    $automobile_value = get_post_meta($post->ID, 'automobile_' . $id, true);
                }
            } elseif (isset($user) && !empty($user)) {

                if (isset($dp) && $dp == true) {

                    $automobile_value = get_the_author_meta($id, $user->ID);
                } else {
                    $automobile_value = get_the_author_meta('automobile_' . $id, $user->ID);
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
                $automobile_random_id = $automobile_var_plugin_core->automobile_rand_id();
                $html_id = ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '"';
            }

            $field_params['automobile_random_id'] = $automobile_random_id;

            $automobile_output = '';
            $automobile_output .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	    <label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">'
                    . '<div class="cs-upload-warning"></div>';
            $automobile_output .= parent::automobile_form_custom_fileupload_render($field_params);
            $automobile_output .= '<div class="page-wrap" ' . $display . ' id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_box">';
            $automobile_output .= '<div class="gal-active">';
            $automobile_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $automobile_output .= '<ul id="gal-sortable">';
            $automobile_output .= '<li class="ui-state-default" id="">';
            $automobile_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="automobile_' . sanitize_html_class($id) . $automobile_random_id . '_img" width="100" alt="" />';
            $automobile_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'automobile_' . sanitize_html_class($id) . $automobile_random_id . '\')" class="delete"></a> </div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</li>';
            $automobile_output .= '</ul>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';
            $automobile_output .= '</div>';

            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * upload multiple file field markup
         * 
         */
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
            $gal_html = '';
            $automobile_gal_counter = 0;
        
            if (is_array($automobile_gallery) && sizeof($automobile_gallery) >= 1) {

                foreach ($automobile_gallery as $automobile_gal) {
                    $automobile_gal_counter++;
                   $automobile_url = isset($automobile_gal['url']) && !empty($automobile_gal['url']) ? $automobile_gal['url'] : '';

                        if ($automobile_url <> '') {
                            //Serialize Array to String
                            $image_data = serialize($automobile_gal);
                            $gal_html .= '
                        <div class="adding-more-img">
                         
                            <input type="hidden" value="' . urlencode($image_data) . '" name="' . $id . '[]" id="automobile_' . $id . $automobile_gal_counter . '">
                            <label class="browse-icon" style="display: none;">
                                <input type="file" value="Browse" name="automobile_' . $id . '_media[]">
                            </label>
                            <div id="automobile_' . $id . $automobile_gal_counter . '_box" style="display: block;" class="page-wrap">
                                <div class="gal-active">
                                    <div style="padding-bottom:0px;" class="dragareamain">
                                        <ul id="gal-sortable">
                                            <li class="ui-state-default">
                                                <div class="thumb-secs">
                                                    <img width="100" alt="" id="automobile_' . $id . $automobile_gal_counter . '_img" src="' . $automobile_url . '">
                                                    <div class="gal-edit-opts">
                                                        <a class="delete" href="javascript:del_media(\'automobile_' . $id . $automobile_gal_counter . '\')"></a> 
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                            	</div>
                            </div>
                        </div>';
                        }
         
                }
         }

            $automobile_output = '';
            $automobile_output .= '<div class="form-elements"><div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	    <label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '</div><div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">'
                    . '<div class="cs-upload-warning"></div>';
            
          
            $automobile_output .= '<p>' . esc_html($desc) . '</p>';
            $automobile_output .= '<div id="add_more">' . $gal_html . '</div>';
            $automobile_output .= '</div>';

            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '</div>';


            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        /**
         * select page field markup
         * 
         */
        public function automobile_select_page_field($params = '') {
            extract($params);
            $automobile_output = '';
            $automobile_output .= '
			<div class="form-elements">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="select-style">';
            $automobile_output .= wp_dropdown_pages($args);
            $automobile_output .= '<p>' . esc_html($desc) . '</p>
					</div>
				</div>';
            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

        public function automobile_multi_fields($params = '') {
            extract($params);
            $automobile_output = '';

            $automobile_styles = '';
            if (isset($styles) && $styles != '') {
                $automobile_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';

            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $automobile_output .= '
			<div' . $cust_id . $extra_attr . ' class="form-elements"' . $automobile_styles . '>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . esc_attr($name) . '</label>';
            if (isset($hint_text) && $hint_text != '') {
                $automobile_output .= parent::automobile_tooltip_helptext(esc_html($hint_text));
            }
            $automobile_output .= '
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            if (isset($fields_list) && is_array($fields_list)) {
                foreach ($fields_list as $field_array) {
                    if ($field_array['type'] == 'text') {
                        $automobile_output .= parent::automobile_form_text_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'hidden') {
                        $automobile_output .= parent::automobile_form_hidden_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'select') {
                        $automobile_output .= parent::automobile_form_select_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'multiselect') {
                        $automobile_output .= parent::automobile_form_multiselect_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'checkbox') {
                        $automobile_output .= parent::automobile_form_checkbox_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'radio') {
                        $automobile_output .= parent::automobile_form_radio_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'date') {
                        $automobile_output .= parent::automobile_form_radio_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'textarea') {
                        $automobile_output .= parent::automobile_form_textarea_render($field_array['field_params']);
                    } elseif ($field_array['type'] == 'media') {
                        $automobile_output .= parent::automobile_media_url($field_array['field_params']);
                    } elseif ($field_array['type'] == 'fileupload') {
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
                    } elseif ($field_array['type'] == 'dropdown_pages') {
                        $automobile_output .= wp_dropdown_pages($args);
                    }
                }
            }

            $automobile_output .= '<p>' . esc_html($desc) . '</p>
				</div>';

            if (isset($split) && $split == true) {
                $automobile_output .= '<div class="splitter"></div>';
            }
            $automobile_output .= '
			</div>';

            if (isset($echo) && $echo == true) {
                echo force_balance_tags($automobile_output);
            } else {
                return $automobile_output;
            }
        }

    }

    global $automobile_html_fields;
    $automobile_html_fields = new automobile_html_fields();
}