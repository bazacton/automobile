<?php
/**
 * @Add Meta Box For Inventory Types
 * @return
 *
 */
if (!class_exists('automobile_var_inventory_type_meta')) {

    class automobile_var_inventory_type_meta {

        public function __construct() {
            add_action('wp_ajax_add_feature_to_list', array($this, 'add_feature_to_list'));
            add_action('add_meta_boxes', array($this, 'automobile_var_meta_inventory_type_add'));
        }

        function automobile_var_meta_inventory_type_add() {
            global $automobile_var_plugin_static_text;
            $automobile_var_inventory_type_options = isset($automobile_var_plugin_static_text['automobile_var_inventory_type_options']) ? $automobile_var_plugin_static_text['automobile_var_inventory_type_options'] : '';

            add_meta_box('automobile_var_meta_inventory_type', esc_html($automobile_var_inventory_type_options), array($this, 'automobile_var_meta_inventory_type'), 'inventory-type', 'normal', 'high');
        }

        function automobile_var_meta_inventory_type($post) {
            global $post, $automobile_html_fields, $automobile_post_inventory_types, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
            
            ?>		
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
                        <div class="elementhidden">
                            <nav class="admin-navigtion">
                                <ul id="cs-options-tab">
                                    <li><a href="javascript:;" name="#tab-inventory_types-settings-custom-fields"><i class="icon-car"></i><?php echo automobile_var_plugin_text_srt('automobile_var_custom_fields'); ?></a></li>
                                    <li><a href="javascript:;" name="#tab-inventory_types-settings-features"><i class="icon-list2"></i><?php echo automobile_var_plugin_text_srt('automobile_var_features'); ?></a></li>
                                    <li><a href="javascript:;" name="#tab-inventory_types-settings-makes"><i class="icon-gears"></i><?php echo automobile_var_plugin_text_srt('automobile_var_makes'); ?></a></li>
                                    <li><a href="javascript:;" name="#tab-inventory_settings"><i class="icon-gears"></i><?php echo automobile_var_plugin_text_srt('automobile_var_settings'); ?></a></li>
                                </ul>
                            </nav>
                            <div id="tabbed-content" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')) ?>">
                                <div id="tab-inventory_types-settings-custom-fields">
                                    <?php $this->automobile_var_post_inventory_type_fields(); ?>
                                </div>
                                <div id="tab-inventory_types-settings-features">
                                    <?php $this->automobile_var_post_inventory_type_features(); ?>
                                </div>
                                <div id="tab-inventory_types-settings-makes">
                                    <?php
                                    $post_id = $post->ID;
                                    $attached_array = $this->get_attached_cats('inventory-type', 'automobile_inventory_type_makes');
                                    $post->ID = $post_id;

                                    $args = array(
                                        'type' => 'post',
                                        'child_of' => 0,
                                        'parent' => '',
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                        'hide_empty' => 0,
                                        'hierarchical' => 1,
                                        'exclude' => '',
                                        'include' => '',
                                        'number' => '',
                                        'taxonomy' => 'inventory-make',
                                        'pad_counts' => false
                                    );

                                    $categories = get_categories($args);
                                    $inventory_categories_array = get_post_meta($post->ID, "automobile_inventory_type_makes", true);
                                    $tax_options = '<option value="">-- ' . automobile_var_plugin_text_srt('automobile_var_select_makes') . ' --</option>';
                                    if ($categories) {
                                        foreach ($categories as $category) {
                                            $selected = '';
                                            if (is_array($attached_array) && !in_array($category->slug, $attached_array)) {

                                                if (is_array($inventory_categories_array) && in_array($category->slug, $inventory_categories_array)) {
                                                    $selected = 'selected="selected"';
                                                }

                                                $tax_options .= '<option value="' . $category->slug . '" ' . $selected . '>' . $category->name . '</option>';
                                            }
                                        }
                                    }
                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_makes'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'multi' => true,
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => '',
                                            'id' => 'inventory_type_makes',
                                            'classes' => 'chosen-select',
                                            'extra_atr' => ' placeholder="-- ' . automobile_var_plugin_text_srt('automobile_var_select_makes') . ' --"',
                                            'options_markup' => true,
                                            'options' => $tax_options,
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_html_fields->automobile_select_field($automobile_opt_array);
                                    ?>
                                </div>

                                <div id="tab-inventory_settings">
                                    <?php
                                    global $automobile_html_fields;

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_enable_upload'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => '',
                                            'id' => 'enable_upload',
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_html_fields->automobile_checkbox_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_images_per_ad'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'usermeta' => true,
                                            'std' => '',
                                            'id' => 'images_per_ad',
                                            'return' => true,
                                        ),
                                    );
                                    $automobile_html_fields->automobile_text_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_price'),
                                        'id' => 'price_information',
                                        'classes' => '',
                                        'std' => '',
                                        'description' => '',
                                        'hint' => ''
                                    );
                                    $automobile_html_fields->automobile_heading_render($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_price'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => '',
                                            'id' => 'price_switch',
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_html_fields->automobile_checkbox_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_price_field_label'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'usermeta' => true,
                                            'std' => '',
                                            'id' => 'price_field_label',
                                            'return' => true,
                                        ),
                                    );
                                    $automobile_html_fields->automobile_text_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_enable_price_search'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => '',
                                            'id' => 'enable_price_search',
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_html_fields->automobile_checkbox_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_min_range'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'usermeta' => true,
                                            'std' => '',
                                            'id' => 'min_range',
                                            'return' => true,
                                        ),
                                    );
                                    $automobile_html_fields->automobile_text_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_max_range'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'usermeta' => true,
                                            'std' => '',
                                            'id' => 'max_range',
                                            'return' => true,
                                        ),
                                    );
                                    $automobile_html_fields->automobile_text_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_increment'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'usermeta' => true,
                                            'std' => '',
                                            'id' => 'increment_step',
                                            'return' => true,
                                        ),
                                    );
                                    $automobile_html_fields->automobile_text_field($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'name' => automobile_var_plugin_text_srt('automobile_var_price_search_style'),
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => 'yes',
                                            'id' => 'price_search_style',
                                            'classes' => 'chosen-select-no-single',
                                            'options' => array(
                                                'slider' => automobile_var_plugin_text_srt('automobile_var_slider'),
                                                'dropdown' => automobile_var_plugin_text_srt('automobile_var_dropdown'),
                                            ),
                                            'return' => true,
                                        ),
                                    );

                                    $automobile_html_fields->automobile_select_field($automobile_opt_array);
                                    ?>
                                </div>
                            </div> 
                            <?php $automobile_post_inventory_types->automobile_submit_meta_box('inventory-type', $args = array()); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <?php
        }

        function get_attached_cats($type = '', $meta_key = '') {
            global $post;

            $automobile_category_array = array();
            $args = array(
                'posts_per_page' => "-1",
                'post_type' => "$type",
                'post_status' => array('publish', 'pending', 'draft'),
                'post__not_in' => array($post->ID)
            );

            $custom_query = new WP_Query($args);
            if ($custom_query->have_posts() <> "") {

                while ($custom_query->have_posts()): $custom_query->the_post();
                    $automobile_aut_categories = get_post_meta(get_the_ID(), "$meta_key", true);
                    if (is_array($automobile_aut_categories)) {
                        $automobile_category_array = array_merge($automobile_category_array, $automobile_aut_categories);
                    }
                endwhile;
            }
            wp_reset_postdata();

            return is_array($automobile_category_array) ? array_unique($automobile_category_array) : $automobile_category_array;
        }

        /**
         * @Inventory Type Custom Fileds Function
         * @return
         */
        function automobile_var_post_inventory_type_fields() {

            global $post, $automobile_form_fields, $automobile_html_fields, $automobile_inventory_type_fields;

            $automobile_inventory_type_fields->custom_fields();
        }

        /**
         * @Inventory Type Features Function
         * @return
         */
        function automobile_var_post_inventory_type_features() {

            global $post, $automobile_form_fields, $automobile_html_fields;

            $this->automobile_features_items();
        }

        public function features_save($post_id) {

            if (isset($_POST['automobile_features_array']) && is_array($_POST['automobile_features_array'])) {
                $feat_array = array();
                $feat_counter = 0;
                foreach ($_POST['automobile_features_array'] as $feat) {
                    $feat_name = isset($_POST['automobile_feature_name_array'][$feat_counter]) ? $_POST['automobile_feature_name_array'][$feat_counter] : '';
                    $feat_array[$feat] = array('key' => 'feature_' . $feat, 'name' => $feat_name);
                    $feat_counter++;
                }
                update_post_meta($post_id, 'automobile_inventory_type_features', $feat_array);
            }
        }

        public function automobile_features_items() {

            global $post, $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_static_text;

            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
            
            $automobile_var_get_features = get_post_meta($post->ID, 'automobile_inventory_type_features', true);

            $html = '
            <script>
                jQuery(document).ready(function($) {
                    $("#total_features").sortable({
                        cancel : \'td div.table-form-elem\'
                    });
                });
            </script>
              <ul class="form-elements">
                  <li class="to-button"><a href="javascript:automobile_var_createpop(\'add_feature_title\',\'filter\')" class="button">' . automobile_var_plugin_text_srt('automobile_var_add_feature') . '</a> </li>
               </ul>
              <div class="cs-service-list-table">
              <table class="to-table" border="0" cellspacing="0">
                    <thead>
                      <tr>
                        <th style="width:100%;">' . automobile_var_plugin_text_srt('automobile_var_title') . '</th>
                        <th style="width:20%;" class="right">' . automobile_var_plugin_text_srt('automobile_var_actions') . '</th>
                      </tr>
                    </thead>
                    <tbody id="total_features">';
            if (is_array($automobile_var_get_features) && sizeof($automobile_var_get_features) > 0) {

                foreach ($automobile_var_get_features as $feat_key => $features) {
                    if (isset($features) && $features <> '') {

                        $counter_feature = $feature_id = $feat_key;
                        $automobile_feature_name = isset($features['name']) ? $features['name'] : '';

                        $automobile_features_array = array(
                            'counter_feature' => $counter_feature,
                            'feature_id' => $feature_id,
                            'automobile_feature_name' => $automobile_feature_name,
                        );

                        $html .= $this->add_feature_to_list($automobile_features_array);
                    }
                }
            }
            $html .= '
                </tbody>
            </table>

            </div>
            <div id="add_feature_title" style="display: none;">
                  <div class="cs-heading-area">
                    <h5><i class="icon-plus-circle"></i> ' . automobile_var_plugin_text_srt('automobile_var_features') . '</h5>
                    <span class="cs-btnclose" onClick="javascript:automobile_var_removeoverlay(\'add_feature_title\',\'append\')"> <i class="icon-times"></i></span> 	
                  </div>';

            $automobile_var_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_title'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => '',
                    'id' => 'feature_name',
                    'return' => true,
                ),
            );

            $html .= $automobile_html_fields->automobile_text_field($automobile_var_opt_array);

            $html .= '
                <ul class="form-elements noborder">
                  <li class="to-label"></li>
                  <li class="to-field">
                        <input type="button" value="' . automobile_var_plugin_text_srt('automobile_var_add_feature') . '" onclick="add_inventory_feature(\'' . esc_js(admin_url('admin-ajax.php')) . '\')" />
                        <div class="feature-loader"></div>
                  </li>
                </ul>
          </div>';

            echo force_balance_tags($html, true);
        }

        public function add_feature_to_list($automobile_var_atts = array()) {

            global $post, $automobile_form_fields, $automobile_html_fields, $automobile_var_plugin_static_text;

            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
            
            $automobile_var_defaults = array(
                'counter_feature' => '',
                'feature_id' => '',
                'automobile_feature_name' => '',
            );
            extract(shortcode_atts($automobile_var_defaults, $automobile_var_atts));

            foreach ($_POST as $keys => $values) {
                $$keys = $values;
            }

            if (isset($_POST['automobile_feature_name']) && $_POST['automobile_feature_name'] <> '') {
                $automobile_feature_name = $_POST['automobile_feature_name'];
            }

            if ($feature_id == '' && $counter_feature == '') {
                $counter_feature = $feature_id = rand(1000, 9999);
            }

            $html = '
            <tr class="parentdelete" id="edit_track' . absint($counter_feature) . '">
              <td id="subject-title' . absint($counter_feature) . '" style="width:100%;">' . esc_attr($automobile_feature_name) . '</td>

              <td class="centr" style="width:20%;"><a href="javascript:automobile_var_createpop(\'edit_track_form' . absint($counter_feature) . '\',\'filter\')" class="actions edit">&nbsp;</a> <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a></td>
              <td style="width:0"><div id="edit_track_form' . esc_attr($counter_feature) . '" style="display: none;" class="table-form-elem">
                <input type="hidden" name="automobile_features_array[]" value="' . absint($feature_id) . '" />
                  <div class="cs-heading-area">
                        <h5 style="text-align: left;">' . automobile_var_plugin_text_srt('automobile_var_features') . '</h5>
                        <span onclick="javascript:automobile_var_removeoverlay(\'edit_track_form' . esc_js($counter_feature) . '\',\'append\')" class="cs-btnclose"> <i class="icon-times"></i></span>
                        <div class="clear"></div>
                  </div>';

            $automobile_var_opt_array = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_title'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'std' => $automobile_feature_name,
                    'id' => 'feature_name',
                    'return' => true,
                    'array' => true,
                    'force_std' => true,
                ),
            );

            $html .= $automobile_html_fields->automobile_text_field($automobile_var_opt_array);

            $html .= '
                    <ul class="form-elements noborder">
                        <li class="to-label">
                          <label></label>
                        </li>
                        <li class="to-field">
                          <input type="button" value="' . automobile_var_plugin_text_srt('automobile_var_update_feature') . '" onclick="automobile_var_removeoverlay(\'edit_track_form' . esc_js($counter_feature) . '\',\'append\')" />
                        </li>
                    </ul>
                  </div>
                </td>
            </tr>';

            if (isset($_POST['automobile_feature_name'])) {
                echo force_balance_tags($html);
            } else {
                return $html;
            }

            if (isset($_POST['automobile_feature_name'])) {
                die();
            }
        }

    }

    global $automobile_inventory_type_meta;
    $automobile_inventory_type_meta = new automobile_var_inventory_type_meta();
    return $automobile_inventory_type_meta;
}