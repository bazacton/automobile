<?php
/**
 * Inventory Type custom 
 * dynamic Fields
 */
if (!class_exists('automobile_inventory_type_dynamic_fields')) {

    class automobile_inventory_type_dynamic_fields {

        public function __construct() {
            add_action('wp_ajax_automobile_inventory_type_pb_text', array($this, 'automobile_inventory_type_pb_text'));
            add_action('wp_ajax_automobile_inventory_type_pb_textarea', array($this, 'automobile_inventory_type_pb_textarea'));
            add_action('wp_ajax_automobile_inventory_type_pb_dropdown', array($this, 'automobile_inventory_type_pb_dropdown'));
            add_action('wp_ajax_automobile_inventory_type_pb_date', array($this, 'automobile_inventory_type_pb_date'));
            add_action('wp_ajax_automobile_inventory_type_pb_email', array($this, 'automobile_inventory_type_pb_email'));
            add_action('wp_ajax_automobile_inventory_type_pb_url', array($this, 'automobile_inventory_type_pb_url'));
            add_action('wp_ajax_automobile_inventory_type_pb_range', array($this, 'automobile_inventory_type_pb_range'));
            add_action('wp_ajax_automobile_inventory_type_pb_section', array($this, 'automobile_inventory_type_pb_section'));
            add_action('wp_ajax_automobile_check_fields_avail', array($this, 'automobile_check_fields_avail'));
        }

        function custom_fields() {
            global $post, $automobile_count_node, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();
            ?>
            <div class="inside-tab-content">
                <div class="dragitem">
                    <h4><?php echo automobile_var_plugin_text_srt('automobile_var_click_to_add_item'); ?></h4>
                    <div class="pb-form-buttons">
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_text')" title="Text" data-type="text" data-name="custom_text"><i class="icon-file-text-o"></i><?php echo automobile_var_plugin_text_srt('automobile_var_text'); ?></a>
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_textarea')" title="Textarea" data-type="textarea" data-name="custom_textarea"><i class="icon-text"></i><?php echo automobile_var_plugin_text_srt('automobile_var_textarea'); ?></a>
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_dropdown')" title="Dropdown" data-type="select" data-name="custom_select"><i class="icon-download"></i><?php echo automobile_var_plugin_text_srt('automobile_var_dropdown'); ?></a>
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_date')" title="Date" data-type="date" data-name="custom_date"><i class="icon-calendar-o"></i><?php echo automobile_var_plugin_text_srt('automobile_var_date'); ?></a>
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_email')" title="Email" data-type="email" data-name="custom_email"><i class="icon-envelope"></i><?php echo automobile_var_plugin_text_srt('automobile_var_custom_email'); ?></a>
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_url')" title="URL" data-type="url" data-name="custom_url"><i class="icon-link4"></i><?php echo automobile_var_plugin_text_srt('automobile_var_url'); ?></a>
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_range')" title="Range" data-type="range" data-name="custom_range"><i class=" icon-target3"></i><?php echo automobile_var_plugin_text_srt('automobile_var_range'); ?></a>
                        <a href="javascript:automobile_inventory_type_field_add('automobile_inventory_type_pb_section')" title="Section" data-type="section" data-name="custom_section"><i class=" icon-box"></i><?php echo automobile_var_plugin_text_srt('automobile_var_section') ?></a>
                    </div>
                </div>
                <div class="cs-custom-fields">
                    <div id="cs-pb-formelements">
                        <?php
                        $automobile_count_node = 0;
                        $count_widget = 0;
                        $automobile_inventory_type_cus_fields = get_post_meta($post->ID, "automobile_inventory_type_cus_fields", true);
                        if (is_array($automobile_inventory_type_cus_fields) && sizeof($automobile_inventory_type_cus_fields) > 0) {
                            
                            foreach ($automobile_inventory_type_cus_fields as $f_key => $automobile_field) {
                                global $automobile_f_counter;
                                $automobile_f_counter = $f_key;
                                if (isset($automobile_field['type']) && $automobile_field['type'] == "text") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_text(1);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "section") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_section(1);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "textarea") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_textarea(1);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "dropdown") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_dropdown(1);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "date") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_date(1);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "email") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_email(1);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "url") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_url(1);
                                } else if (isset($automobile_field['type']) && $automobile_field['type'] == "range") {
                                    $automobile_count_node++;
                                    $this->automobile_inventory_type_pb_range(1);
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="alert alert-warning" id="cs-pbwp-alert"><?php echo automobile_var_plugin_text_srt('automobile_var_please_insert_items') ?></div>
                <input type="hidden" name="custom_fields_elements" value="1" />

                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        automobile_custom_fields_js();
                        chosen_selectionbox();
                    });
                    var counter = <?php echo esc_js($automobile_count_node); ?>;
                    function automobile_inventory_type_field_add(action) {
                        counter++;
                        var newCustomerForm = "action=" + action + '&counter=' + counter;
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo esc_js(admin_url('admin-ajax.php')); ?>",
                            data: newCustomerForm,
                            success: function (data) {
                                jQuery("#cs-pb-formelements").append(data);
                                chosen_selectionbox();
                            }
                        });
                    }
                </script> 
            </div>
            <?php
        }

        public function automobile_inventory_type_pb_section($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();

            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_section_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_section');
            }
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_section[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_section',
                'name' => 'automobile_cus_field_section[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));

            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'section', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);

            $automobile_output = $this->automobile_fields_layout($automobile_fields);

            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        public function automobile_inventory_type_pb_text($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();


            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_text_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_text');
            }
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_text[required]',
                'title' => automobile_var_plugin_text_srt('automobile_var_required'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_text[featured]',
                'title' => automobile_var_plugin_text_srt('automobile_var_featured'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_text[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_text[meta_key]',
                'title' => automobile_var_plugin_text_srt('automobile_var_meta_key'),
                'check' => true,
                'std' => '',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_text[placeholder]',
                'title' => automobile_var_plugin_text_srt('automobile_var_place_holder'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_text[enable_srch]',
                'title' => automobile_var_plugin_text_srt('automobile_var_enable_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_text[default_value]',
                'title' => automobile_var_plugin_text_srt('automobile_var_default_value'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_text[collapse_search]',
                'title' => automobile_var_plugin_text_srt('automobile_var_collapse_in_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));

            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_text',
                'name' => 'automobile_cus_field_text[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'text', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);

            $automobile_output = $this->automobile_fields_layout($automobile_fields);

            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        /**
         * End function how to create Text Fields
         */

        /**
         * Start function how to create Textarea Fields
         */
        public function automobile_inventory_type_pb_textarea($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();

            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_textarea_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_textarea');
            }
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_textarea[required]',
                'title' => automobile_var_plugin_text_srt('automobile_var_required'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_textarea[featured]',
                'title' => automobile_var_plugin_text_srt('automobile_var_featured'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_textarea[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_textarea[meta_key]',
                'title' => automobile_var_plugin_text_srt('automobile_var_meta_key'),
                'check' => true,
                'std' => '',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_textarea(array(
                'id' => '',
                'name' => 'cus_field_textarea[help]',
                'title' => automobile_var_plugin_text_srt('automobile_var_help_text'),
                'std' => '',
                'hint' => '',
            ));

            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_textarea[placeholder]',
                'title' => automobile_var_plugin_text_srt('automobile_var_place_holder'),
                'std' => '',
                'hint' => '',
            ));

            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_textarea[rows]',
                'title' => automobile_var_plugin_text_srt('automobile_var_rows'),
                'std' => '5',
                'hint' => '',
            ));

            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_textarea[cols]',
                'title' => automobile_var_plugin_text_srt('automobile_var_columns'),
                'std' => '25',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_textarea[default_value]',
                'title' => automobile_var_plugin_text_srt('automobile_var_default_value'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_textarea[collapse_search]',
                'title' => automobile_var_plugin_text_srt('automobile_var_collapse_in_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_textarea',
                'name' => 'automobile_cus_field_textarea[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'textarea', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);
            $automobile_output = $this->automobile_fields_layout($automobile_fields);
            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        /**
         * End function how to create Textarea Fields
         */

        /**
         * Start function how to create dropdown option fields
         */
        public function automobile_inventory_type_pb_dropdown($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_form_fields, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();



            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_dropdown_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_dropdown');
            }
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_dropdown[required]',
                'title' => automobile_var_plugin_text_srt('automobile_var_required'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_dropdown[featured]',
                'title' => automobile_var_plugin_text_srt('automobile_var_featured'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_dropdown[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_dropdown[meta_key]',
                'title' => automobile_var_plugin_text_srt('automobile_var_meta_key'),
                'check' => true,
                'std' => '',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_textarea(array(
                'id' => '',
                'name' => 'cus_field_dropdown[help]',
                'title' => automobile_var_plugin_text_srt('automobile_var_help_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_dropdown[enable_srch]',
                'title' => automobile_var_plugin_text_srt('automobile_var_enable_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_dropdown[srch_style]',
                'title' => automobile_var_plugin_text_srt('automobile_var_search_style'),
                'std' => '',
                'options' => array('simple' => automobile_var_plugin_text_srt('automobile_var_simple'), 'with_bg' => automobile_var_plugin_text_srt('automobile_var_with_image')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_dropdown[multi]',
                'title' => automobile_var_plugin_text_srt('automobile_var_enable_multi_select'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_dropdown[post_multi]',
                'title' => automobile_var_plugin_text_srt('automobile_var_post_multi_select'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_dropdown[first_value]',
                'title' => automobile_var_plugin_text_srt('automobile_var_first_value'),
                'std' => '- select -',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_dropdown[collapse_search]',
                'title' => automobile_var_plugin_text_srt('automobile_var_collapse_in_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_selectbox',
                'name' => 'automobile_cus_field_dropdown[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= '
			<div class="form-elements">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<label>' . automobile_var_plugin_text_srt('automobile_var_options') . '</label>
				</div>
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';

            if (isset($automobile_inventory_type_cus_fields[$automobile_f_counter]['options']['value'])) {
                $automobile_opt_counter = 0;
                $automobile_radio_counter = 1;
                foreach ($automobile_inventory_type_cus_fields[$automobile_f_counter]['options']['value'] as $automobile_option) {
                    $automobile_checked = (int) $automobile_inventory_type_cus_fields[$automobile_f_counter]['options']['select'][0] == (int) $automobile_radio_counter ? ' checked="checked"' : '';
                    $automobile_opt_label = $automobile_inventory_type_cus_fields[$automobile_f_counter]['options']['label'][$automobile_opt_counter];
                    $automobile_opt_img = $automobile_inventory_type_cus_fields[$automobile_f_counter]['options']['img'][$automobile_opt_counter];
                    $automobile_fields_markup .= '
					<div class="pbwp-clone-field clearfix">';
                    $automobile_opt_array = array(
                        'cust_id' => 'cus_field_dropdown_selected_' . absint($automobile_counter),
                        'cust_name' => 'cus_field_dropdown[selected][' . absint($automobile_counter) . '][]',
                        'cust_type' => 'radio',
                        'extra_atr' => $automobile_checked,
                        'std' => $automobile_radio_counter,
                        'return' => true,
                    );
                    $automobile_fields_markup .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                    $automobile_opt_array = array(
                        'cust_id' => 'cus_field_dropdown_options_' . absint($automobile_counter),
                        'cust_name' => 'cus_field_dropdown[options][' . absint($automobile_counter) . '][]',
                        'extra_atr' => ' data-type="option"',
                        'std' => $automobile_opt_label,
                        'classes' => 'input-small',
                        'return' => true,
                    );
                    $automobile_fields_markup .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                    $automobile_opt_array = array(
                        'cust_id' => 'cus_field_dropdown_options_values_' . absint($automobile_counter),
                        'cust_name' => 'cus_field_dropdown[options_values][' . absint($automobile_counter) . '][]',
                        'std' => $automobile_option,
                        'classes' => 'input-small',
                        'return' => true,
                    );
                    $automobile_fields_markup .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                    $automobile_fields_markup .= '<div class="cs-dr-option-img">';
                    $automobile_opt_array = array(
                        'id' => 'cus_field_dropdown_options_imgs',
                        'cust_name' => 'cus_field_dropdown[options_imgs][' . absint($automobile_counter) . '][]',
                        'std' => $automobile_opt_img,
                        'array' => true,
                        'return' => true,
                    );
                    $automobile_fields_markup .= $automobile_form_fields->automobile_img_upload_button($automobile_opt_array);
                    $automobile_fields_markup .= '</div>';

                    $automobile_fields_markup .= '
                            <img src="' . esc_url(automobile_var::plugin_url() . 'assets/backend/images/add.png') . '" class="pbwp-clone-field" alt="' . automobile_var_plugin_text_srt('automobile_var_add_another_choice') . '" style="cursor:pointer; margin:0 3px;">
                            <img src="' . esc_url(automobile_var::plugin_url() . 'assets/backend/images/remove.png') . '" alt="' . automobile_var_plugin_text_srt('automobile_var_remove_this_choice') . '" class="pbwp-remove-field" style="cursor:pointer;">
                    </div>';
                    $automobile_opt_counter++;
                    $automobile_radio_counter++;
                }
            } else {
                $automobile_fields_markup .= '
		<div class="pbwp-clone-field clearfix">';

                $automobile_opt_array = array(
                    'cust_id' => 'cus_field_dropdown_selected_' . absint($automobile_counter),
                    'cust_name' => 'cus_field_dropdown[selected][' . absint($automobile_counter) . '][]',
                    'cust_type' => 'radio',
                    'extra_atr' => ' checked="checked"',
                    'std' => '1',
                    'return' => true,
                );
                $automobile_fields_markup .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                $automobile_opt_array = array(
                    'cust_id' => 'cus_field_dropdown_options_' . absint($automobile_counter),
                    'cust_name' => 'cus_field_dropdown[options][' . absint($automobile_counter) . '][]',
                    'extra_atr' => ' data-type="option" placeholder="Label"',
                    'std' => '',
                    'classes' => 'input-small',
                    'return' => true,
                );
                $automobile_fields_markup .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                $automobile_opt_array = array(
                    'cust_id' => 'cus_field_dropdown_options_values_' . absint($automobile_counter),
                    'cust_name' => 'cus_field_dropdown[options_values][' . absint($automobile_counter) . '][]',
                    'extra_atr' => ' placeholder="Value"',
                    'std' => '',
                    'classes' => 'input-small',
                    'return' => true,
                );
                $automobile_fields_markup .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

                $automobile_fields_markup .= '<div class="cs-dr-option-img">';
                $automobile_opt_array = array(
                    'id' => 'cus_field_dropdown_options_imgs',
                    'cust_name' => 'cus_field_dropdown[options_imgs][' . absint($automobile_counter) . '][]',
                    'std' => '',
                    'array' => true,
                    'return' => true,
                );
                $automobile_fields_markup .= $automobile_form_fields->automobile_img_upload_button($automobile_opt_array);
                $automobile_fields_markup .= '</div>';

                $automobile_fields_markup .= '
                        <img src="' . esc_url(automobile_var::plugin_url() . 'assets/backend/images/add.png') . '" class="pbwp-clone-field" alt="' . automobile_var_plugin_text_srt('automobile_var_add_another_choice') . '" style="cursor:pointer; margin:0 3px;">
                        <img src="' . esc_url(automobile_var::plugin_url() . 'assets/backend/images/remove.png') . '" alt="' . automobile_var_plugin_text_srt('automobile_var_remove_this_choice') . '" class="pbwp-remove-field" style="cursor:pointer;">
                </div>';
            }
            $automobile_fields_markup .= '
				</div>
			</div>';
            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'dropdown', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);
            $automobile_output = $this->automobile_fields_layout($automobile_fields);
            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        /**
         * End function how to create dropdown option fields
         */

        /**
         * Start function how to create custom fields
         */
        public function automobile_inventory_type_pb_date($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();


            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_date_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_date');
            }
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_date[required]',
                'title' => automobile_var_plugin_text_srt('automobile_var_required'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_date[featured]',
                'title' => automobile_var_plugin_text_srt('automobile_var_featured'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_date[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_date[meta_key]',
                'title' => automobile_var_plugin_text_srt('automobile_var_meta_key'),
                'check' => true,
                'std' => '',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_textarea(array(
                'id' => '',
                'name' => 'cus_field_date[help]',
                'title' => automobile_var_plugin_text_srt('automobile_var_help_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_date[enable_srch]',
                'title' => automobile_var_plugin_text_srt('automobile_var_enable_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_date[date_format]',
                'title' => automobile_var_plugin_text_srt('automobile_var_date_format'),
                'std' => 'd.m.Y H:i',
                'hint' => automobile_var_plugin_text_srt('automobile_var_date_format') . ': d.m.Y H:i, Y/m/d',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_date[collapse_search]',
                'title' => automobile_var_plugin_text_srt('automobile_var_collapse_in_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_date',
                'name' => 'automobile_cus_field_date[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'date', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);
            $automobile_output = $this->automobile_fields_layout($automobile_fields);
            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        /**
         * End function how to create custom fields
         */

        /**
         * Start function how to create custom email fields
         */
        public function automobile_inventory_type_pb_email($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();



            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_email_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_custom_email');
            }
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_email[required]',
                'title' => automobile_var_plugin_text_srt('automobile_var_required'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_email[featured]',
                'title' => automobile_var_plugin_text_srt('automobile_var_featured'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_email[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_email[meta_key]',
                'title' => automobile_var_plugin_text_srt('automobile_var_meta_key'),
                'check' => true,
                'std' => '',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_email[placeholder]',
                'title' => automobile_var_plugin_text_srt('automobile_var_place_holder'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_textarea(array(
                'id' => '',
                'name' => 'cus_field_email[help]',
                'title' => automobile_var_plugin_text_srt('automobile_var_help_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_email[enable_srch]',
                'title' => automobile_var_plugin_text_srt('automobile_var_enable_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_email[default_value]',
                'title' => automobile_var_plugin_text_srt('automobile_var_default_value'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_email[collapse_search]',
                'title' => automobile_var_plugin_text_srt('automobile_var_collapse_in_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_email',
                'name' => 'automobile_cus_field_email[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('$automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'email', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);
            $automobile_output = $this->automobile_fields_layout($automobile_fields);
            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        /**
         * End function how to create custom email fields
         */

        /**
         * Start function how to create post custom url fields
         */
        public function automobile_inventory_type_pb_url($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();

            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_url_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_url');
            }
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_url[required]',
                'title' => automobile_var_plugin_text_srt('automobile_var_required'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_url[featured]',
                'title' => automobile_var_plugin_text_srt('$automobile_var_featured'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_url[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_url[meta_key]',
                'title' => automobile_var_plugin_text_srt('automobile_var_meta_key'),
                'check' => true,
                'std' => '',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_url[placeholder]',
                'title' => automobile_var_plugin_text_srt('automobile_var_place_holder'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_textarea(array(
                'id' => '',
                'name' => 'cus_field_url[help]',
                'title' => automobile_var_plugin_text_srt('automobile_var_help_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_url[enable_srch]',
                'title' => automobile_var_plugin_text_srt('automobile_var_enable_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_url[default_value]',
                'title' => automobile_var_plugin_text_srt('automobile_var_default_value'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_url[collapse_search]',
                'title' => automobile_var_plugin_text_srt('automobile_var_collapse_in_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_url',
                'name' => 'automobile_cus_field_url[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'url', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);
            $automobile_output = $this->automobile_fields_layout($automobile_fields);
            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        /**
         * End function how to create post custom url fields
         */

        /**
         * Start function how to create post custom range in fields
         */
        public function automobile_inventory_type_pb_range($die = 0, $automobile_return = false) {
            global $automobile_f_counter, $automobile_inventory_type_cus_fields, $automobile_var_plugin_static_text;
            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();

            $automobile_fields_markup = '';
            if (isset($_REQUEST['counter'])) {
                $automobile_counter = $_REQUEST['counter'];
            } else {
                $automobile_counter = $automobile_f_counter;
            }
            if (isset($automobile_inventory_type_cus_fields[$automobile_counter])) {
                $automobile_title = isset($automobile_inventory_type_cus_fields[$automobile_counter]['label']) ? sprintf(automobile_var_plugin_text_srt('automobile_var_range_string'), $automobile_inventory_type_cus_fields[$automobile_counter]['label']) : '';
            } else {
                $automobile_title = automobile_var_plugin_text_srt('automobile_var_range');
            }
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_range[required]',
                'title' => automobile_var_plugin_text_srt('automobile_var_required'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_range[featured]',
                'title' => automobile_var_plugin_text_srt('automobile_var_featured'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_range[label]',
                'title' => automobile_var_plugin_text_srt('automobile_var_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_range[meta_key]',
                'title' => automobile_var_plugin_text_srt('automobile_var_meta_key'),
                'check' => true,
                'std' => '',
                'hint' => automobile_var_plugin_text_srt('automobile_var_meta_key_hint'),
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_range[placeholder]',
                'title' => automobile_var_plugin_text_srt('automobile_var_place_holder'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_textarea(array(
                'id' => '',
                'name' => 'cus_field_range[help]',
                'title' => automobile_var_plugin_text_srt('automobile_var_help_text'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_range[min]',
                'title' => automobile_var_plugin_text_srt('automobile_var_minimum_value'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_range[max]',
                'title' => automobile_var_plugin_text_srt('automobile_var_maximum_value'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_range[increment]',
                'title' => automobile_var_plugin_text_srt('automobile_var_increment_step'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_range[enable_srch]',
                'title' => automobile_var_plugin_text_srt('automobile_var_enable_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_input_text(array(
                'id' => '',
                'name' => 'cus_field_range[default_value]',
                'title' => automobile_var_plugin_text_srt('automobile_var_default_value'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_range[srch_style]',
                'title' => automobile_var_plugin_text_srt('automobile_var_search_style'),
                'std' => '',
                'options' => array('slider' => automobile_var_plugin_text_srt('automobile_var_slider'), 'dropdown' => automobile_var_plugin_text_srt('automobile_var_dropdown')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_fields_select(array(
                'id' => '',
                'name' => 'cus_field_range[collapse_search]',
                'title' => automobile_var_plugin_text_srt('automobile_var_collapse_in_search'),
                'std' => '',
                'options' => array('no' => automobile_var_plugin_text_srt('automobile_var_no'), 'yes' => automobile_var_plugin_text_srt('automobile_var_yes')),
                'hint' => '',
            ));
            $automobile_fields_markup .= $this->automobile_inventory_type_fields_icon(array(
                'id' => 'fontawsome_icon_range',
                'name' => 'automobile_cus_field_range[fontawsome_icon]',
                'title' => automobile_var_plugin_text_srt('automobile_var_icon'),
                'std' => '',
                'hint' => '',
            ));
            $automobile_fields = array('automobile_counter' => $automobile_counter, 'automobile_name' => 'range', 'automobile_title' => $automobile_title, 'automobile_markup' => $automobile_fields_markup);
            $automobile_output = $this->automobile_fields_layout($automobile_fields);
            if ($automobile_return == true) {
                return force_balance_tags($automobile_output, true);
            } else {
                echo force_balance_tags($automobile_output, true);
            }
            if ($die <> 1)
                die();
        }

        /**
         * end function how to create post custom range in fields
         */

        /**
         * Start function how to create post fields layout 
         */
        public function automobile_fields_layout($automobile_fields) {
            global $automobile_form_fields;
            $automobile_defaults = array('automobile_counter' => '1', 'automobile_name' => '', 'automobile_title' => '', 'automobile_markup' => '');
            extract(shortcode_atts($automobile_defaults, $automobile_fields));

            $automobile_html = '<div class="pb-item-container">';
            $automobile_section_class = '';
            if ($automobile_name == 'section') {
                $automobile_section_class = 'cs-cust-field-section';
            }
            $automobile_html .= '<div class="pbwp-legend ' . $automobile_section_class . '">';
            $automobile_html .= '<input type="hidden" name="automobile_cus_field_title[]" value="' . $automobile_name . '">';
            $automobile_html .= '<input type="hidden" name="automobile_cus_field_id[]" value="' . $automobile_counter . '">';

            if ($automobile_name == 'textarea') {
                $automobile_show_icon = 'icon-text';
            } else if ($automobile_name == 'dropdown') {
                $automobile_show_icon = 'icon-download';
            } else if ($automobile_name == 'date') {
                $automobile_show_icon = 'icon-calendar-o';
            } else if ($automobile_name == 'email') {
                $automobile_show_icon = 'icon-envelope';
            } else if ($automobile_name == 'url') {
                $automobile_show_icon = 'icon-link4';
            } else if ($automobile_name == 'range') {
                $automobile_show_icon = 'icon-target3';
            } else if ($automobile_name == 'section') {
                $automobile_show_icon = 'icon-box';
            } else {
                $automobile_show_icon = 'icon-file-text-o';
            }
            $automobile_html .= '
                <div class="pbwp-label"><i class="' . $automobile_show_icon . '"></i> ' . esc_attr($automobile_title) . ' </div>
                <div class="pbwp-actions">
                    <a class="pbwp-remove" href="#"><i class="icon-times"></i></a>
                    <a class="pbwp-toggle" href="#"><i class="icon-sort-down"></i></a>
                </div>
            </div>
            <div class="pbwp-form-holder" style="display:none;">';
            $automobile_html .= $automobile_markup;
            $automobile_html .= '	
                    </div>
            </div>';

            return force_balance_tags($automobile_html, true);
        }

        /**
         * End function how to create post fields layout in html
         */

        /**
         * Start function how to create post custom fields in input
         */
        public function automobile_fields_input_text($params = '') {
            global $automobile_f_counter, $automobile_form_fields, $automobile_html_fields, $automobile_inventory_type_cus_fields;
            $automobile_output = '';
            $automobile_output .= '<script>jQuery(document).ready(function($) {
                                    automobile_check_fields_avail();
                            });</script>';
            extract($params);
            $automobile_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $automobile_label = str_replace(array('[', ']'), array('', ''), $automobile_label);
            if (isset($automobile_inventory_type_cus_fields[$automobile_f_counter])) {
                $automobile_value = isset($automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label]) ? $automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label] : '';
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $automobile_rand_id = time();
            $html_id = $id != '' ? 'automobile_' . sanitize_html_class($id) . '' : '';
            $html_name = 'automobile_' . $name . '[]';
            $automobile_check_con = '';
            if (isset($check) && $check == true) {
                $html_id = 'check_field_name_' . $automobile_rand_id;
            }

            $automobile_output .= $automobile_html_fields->automobile_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));

            $automobile_opt_array = array(
                'id' => $id,
                'cust_id' => $html_id,
                'cust_name' => $html_name,
                'std' => $value,
                'return' => true,
            );

            $automobile_output .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);

            $automobile_output .= '<span class="name-checking"></span>';

            $automobile_output .= $automobile_html_fields->automobile_closing_field(array(
                'desc' => '',
            ));
            return force_balance_tags($automobile_output);
        }

        /**
         * end function how to create post custom fields in input
         */

        /**
         * Start function how to create post custom fields in input textarea
         */
        public function automobile_fields_input_textarea($params = '') {
            global $automobile_f_counter, $automobile_form_fields, $automobile_html_fields, $automobile_inventory_type_cus_fields;
            $automobile_output = '';
            extract($params);
            $automobile_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $automobile_label = str_replace(array('[', ']'), array('', ''), $automobile_label);
            $automobile_output .= '<script>jQuery(document).ready(function($) {
                                    automobile_check_fields_avail();
                            });</script>';
            if (isset($automobile_inventory_type_cus_fields[$automobile_f_counter])) {
                $automobile_value = isset($automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label]) ? $automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label] : '';
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $html_id = $id != '' ? 'automobile_' . sanitize_html_class($id) : '';
            $html_name = 'automobile_' . $name . '[]';

            $automobile_output .= $automobile_html_fields->automobile_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));

            $automobile_opt_array = array(
                'id' => $id,
                'cust_id' => $html_id,
                'cust_name' => $html_name,
                'std' => $value,
                'return' => true,
            );

            $automobile_output .= $automobile_form_fields->automobile_form_textarea_render($automobile_opt_array);

            $automobile_output .= $automobile_html_fields->automobile_closing_field(array(
                'desc' => '',
            ));
            return force_balance_tags($automobile_output);
        }

        /**
         * end function how to create post custom fields in input textarea
         */

        /**
         * Start function how to create post custom select fields
         */
        public function automobile_fields_select($params = '') {
            global $automobile_f_counter, $automobile_form_fields, $automobile_html_fields, $automobile_inventory_type_cus_fields;
            $automobile_output = '';
            extract($params);
            $automobile_output .= '<script>jQuery(document).ready(function($) {
                           	  automobile_check_fields_avail();
                           });
			</script>';

            $automobile_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $automobile_label = str_replace(array('[', ']'), array('', ''), $automobile_label);
            if (isset($automobile_inventory_type_cus_fields[$automobile_f_counter])) {
                $automobile_value = isset($automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label]) ? $automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label] : '';
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $html_id = $id != '' ? 'automobile_' . sanitize_html_class($id) . '' : '';
            $html_name = 'automobile_' . $name . '[]';
            $html_class = 'chosen-select-no-single';

            $automobile_output .= $automobile_html_fields->automobile_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));

            $automobile_opt_array = array(
                'id' => $id,
                'cust_id' => $html_id,
                'cust_name' => $html_name,
                'std' => $value,
                'classes' => $html_class,
                'options' => $options,
                'return' => true,
            );

            $automobile_output .= $automobile_form_fields->automobile_form_select_render($automobile_opt_array);

            $automobile_output .= $automobile_html_fields->automobile_closing_field(array(
                'desc' => '',
            ));

            return force_balance_tags($automobile_output);
        }

        /**
         * end function how to create post custom select fields
         */

        /**
         * Start function how to create post custom icon fields
         */
        public function automobile_inventory_type_fields_icon($params = '') {
            global $automobile_f_counter, $automobile_form_fields, $automobile_html_fields, $automobile_inventory_type_cus_fields;
            $automobile_output = '';
            extract($params);
            $automobile_output .= '';
            $rand_id = rand(0, 999999);
            $automobile_label = substr($name, strpos($name, '['), strpos($name, ']'));
            $automobile_label = str_replace(array('[', ']'), array('', ''), $automobile_label);
            if (isset($automobile_inventory_type_cus_fields[$automobile_f_counter])) {
                $automobile_value = isset($automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label]) ? $automobile_inventory_type_cus_fields[$automobile_f_counter][$automobile_label] : '';
            }
            if (isset($automobile_value) && $automobile_value != '') {
                $value = $automobile_value;
            } else {
                $value = $std;
            }
            $html_id = $id != '' ? 'automobile_' . sanitize_html_class($id) . '' : '';
            $html_name = 'automobile_' . $name . '[]';
            $html_class = 'chosen-select-no-single';

            $automobile_output .= $automobile_html_fields->automobile_opening_field(array(
                'name' => $title,
                'hint_text' => $hint,
            ));

            $automobile_output .= automobile_iconlist_plugin_options($value, $id . $automobile_f_counter . $rand_id, $name);

            $automobile_output .= $automobile_html_fields->automobile_closing_field(array(
                'desc' => '',
            ));

            return force_balance_tags($automobile_output);
        }

        /**
         * end function how to create post custom icon fields
         */

        /**
         * Start function how to save array of fields
         */
        public function automobile_save_array($automobile_sec_counter = 0, $automobile_type = '', $cus_field_array = array()) {
            $automobile_fields = array('required', 'featured', 'label', 'meta_key', 'placeholder', 'enable_srch', 'default_value', 'fontawsome_icon', 'help', 'rows', 'cols', 'multi', 'post_multi', 'first_value', 'collapse_search', 'date_format', 'min', 'max', 'increment', 'enable_inputs', 'srch_style');
            $cus_field_array['type'] = $automobile_type;
            foreach ($automobile_fields as $field) {
                if (isset($_POST["automobile_cus_field_{$automobile_type}"][$field][$automobile_sec_counter])) {
                    $cus_field_array[$field] = $_POST["automobile_cus_field_{$automobile_type}"][$field][$automobile_sec_counter];
                }
            }
            return $cus_field_array;
        }

        /**
         * end function how to save array of fields
         */

        /**
         * Start function how to update fields
         */
        public function automobile_update_custom_fields($post_id) {
            $automobile_obj = new automobile_inventory_type_dynamic_fields();
            $text_counter = $section_counter = $textarea_counter = $dropdown_counter = $date_counter = $email_counter = $url_counter = $range_counter = $cus_field_counter = $error = 0;
            $cus_field = array();
          
            if (isset($_POST['automobile_cus_field_id']) && sizeof($_POST['automobile_cus_field_id']) > 0) {
                foreach ($_POST['automobile_cus_field_id'] as $keys => $values) {
                    if ($values != '') {
                        $automobile_rand_numb = rand(1342121, 9974532);
                        $cus_field_array = array();
                        $automobile_type = isset($_POST["automobile_cus_field_title"][$cus_field_counter]) ? $_POST["automobile_cus_field_title"][$cus_field_counter] : '';
                        switch ($automobile_type) {
                            case('text'):
                                $cus_field_array = $automobile_obj->automobile_save_array($text_counter, $automobile_type, $cus_field_array);
                                $text_counter++;
                                break;
                            case('section'):
                                $cus_field_array = $automobile_obj->automobile_save_array($section_counter, $automobile_type, $cus_field_array);
                                $section_counter++;
                                break;
                            case('textarea'):
                                $cus_field_array = $automobile_obj->automobile_save_array($textarea_counter, $automobile_type, $cus_field_array);
                                $textarea_counter++;
                                break;
                            case('dropdown'):
                                $cus_field_array = $automobile_obj->automobile_save_array($dropdown_counter, $automobile_type, $cus_field_array);

                                if (isset($_POST["cus_field_{$automobile_type}"]['options_values'][$values]) && (strlen(implode($_POST["cus_field_{$automobile_type}"]['options_values'][$values])) != 0)) {
                                    $cus_field_array['options'] = array();
                                    $option_counter = 0;

                                    foreach ($_POST["cus_field_{$automobile_type}"]['options_values'][$values] as $option) {
                                        if ($option != '') {
                                            $option = ltrim(rtrim($option));
                                            if ($_POST["cus_field_{$automobile_type}"]['options'][$values][$option_counter] != '') {
                                                $cus_field_array['options']['select'][] = isset($_POST["cus_field_{$automobile_type}"]['selected'][$values][$option_counter]) ? $_POST["cus_field_{$automobile_type}"]['selected'][$values][$option_counter] : '';
                                                $cus_field_array['options']['label'][] = isset($_POST["cus_field_{$automobile_type}"]['options'][$values][$option_counter]) ? $_POST["cus_field_{$automobile_type}"]['options'][$values][$option_counter] : '';
                                                $cus_field_array['options']['value'][] = isset($option) && $option != '' ? strtolower(str_replace(" ", "-", $option)) : '';
                                                $cus_field_array['options']['img'][] = isset($_POST["cus_field_{$automobile_type}"]['options_imgs'][$values][$option_counter]) ? $_POST["cus_field_{$automobile_type}"]['options_imgs'][$values][$option_counter] : '';
                                            }
                                        }
                                        $option_counter++;
                                    }
                                } else {
                                    $error = 1;
                                }
                                $dropdown_counter++;
                                break;
                            case('date'):
                                $cus_field_array = $automobile_obj->automobile_save_array($date_counter, $automobile_type, $cus_field_array);
                                $date_counter++;
                                break;
                            case('email'):
                                $cus_field_array = $automobile_obj->automobile_save_array($email_counter, $automobile_type, $cus_field_array);
                                $email_counter++;
                                break;
                            case('url'):
                                $cus_field_array = $automobile_obj->automobile_save_array($url_counter, $automobile_type, $cus_field_array);
                                $url_counter++;
                                break;
                            case('range'):
                                $cus_field_array = $automobile_obj->automobile_save_array($range_counter, $automobile_type, $cus_field_array);
                                $range_counter++;
                                break;
                        }
                        $cus_field[$automobile_rand_numb] = $cus_field_array;
                        $cus_field_counter++;
                    }
                }
            }

            if ($error == 0) {

                update_post_meta($post_id, "automobile_inventory_type_cus_fields", $cus_field);
            }
        }

        public function automobile_check_fields_avail() {
            global $automobile_var_plugin_static_text;

            $strings = new automobile_plugin_all_strings;
            $strings->automobile_var_plugin_option_strings();

            $automobile_json = array();
            $automobile_temp_names = array();
            $automobile_temp_names_1 = array();
            $automobile_temp_names_2 = array();
            $automobile_temp_names_3 = array();
            $automobile_temp_names_4 = array();
            $automobile_temp_names_5 = array();
            $automobile_temp_names_6 = array();
            $automobile_field_name = $_REQUEST['name'];
            $post_id = isset($_POST['automobile_cus_field_text']['meta_key']) ? $_POST['automobile_cus_field_text']['meta_key'] : '';
            $automobile_inventory_type_cus_fields = get_post_meta($post_id, "automobile_inventory_type_cus_fields", true);
            $form_field_names = isset($_REQUEST['automobile_cus_field_text']['meta_key']) ? $_REQUEST['automobile_cus_field_text']['meta_key'] : array();
            $form_field_names_1 = isset($_REQUEST['automobile_cus_field_textarea']['meta_key']) ? $_REQUEST['automobile_cus_field_textarea']['meta_key'] : array();
            $form_field_names_2 = isset($_REQUEST['automobile_cus_field_dropdown']['meta_key']) ? $_REQUEST['automobile_cus_field_dropdown']['meta_key'] : array();
            $form_field_names_3 = isset($_REQUEST['automobile_cus_field_date']['meta_key']) ? $_REQUEST['automobile_cus_field_date']['meta_key'] : array();
            $form_field_names_4 = isset($_REQUEST['automobile_cus_field_email']['meta_key']) ? $_REQUEST['automobile_cus_field_email']['meta_key'] : array();
            $form_field_names_5 = isset($_REQUEST['automobile_cus_field_url']['meta_key']) ? $_REQUEST['automobile_cus_field_url']['meta_key'] : array();
            $form_field_names_6 = isset($_REQUEST['automobile_cus_field_range']['meta_key']) ? $_REQUEST['automobile_cus_field_range']['meta_key'] : array();
            $form_field_names = array_merge($form_field_names, $form_field_names_1, $form_field_names_2, $form_field_names_3, $form_field_names_4, $form_field_names_5, $form_field_names_6);
            $length = count(array_keys($form_field_names, $automobile_field_name));
            if ($automobile_field_name == '') {
                $automobile_json['type'] = 'error';
                $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_field_name_is_required');
            } else {
                if (is_array($automobile_inventory_type_cus_fields) && sizeof($automobile_inventory_type_cus_fields) > 0) {
                    $success = 1;
                    foreach ($automobile_inventory_type_cus_fields as $field_key => $automobile_field) {
                        if (isset($automobile_field['type'])) {
                            if (preg_match('/\s/', $automobile_field_name)) {
                                $automobile_json['type'] = 'error';
                                $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_whitespaces_not_allowed');
                                echo json_encode($automobile_json);
                                die();
                            }
                            if (preg_match('/[\'^�$%&*()}{@#~?><>,|=+�]/', $automobile_field_name)) {
                                $automobile_json['type'] = 'error';
                                $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_Special_character_not_allowed');
                                echo json_encode($automobile_json);
                                die();
                            }
                            if (trim($automobile_field['type']) == trim($automobile_field_name)) {

                                if (in_array(trim($automobile_field_name), $form_field_names) && $length > 1) {
                                    $automobile_json['type'] = 'error';
                                    $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_name_already_exist');
                                    echo json_encode($automobile_json);
                                    die();
                                }
                            } else {
                                if (in_array(trim($automobile_field_name), $form_field_names) && $length > 1) {
                                    $automobile_json['type'] = 'error';
                                    $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_name_already_exist');
                                    echo json_encode($automobile_json);
                                    die();
                                }
                            }
                        }
                    }
                    $automobile_json['type'] = 'success';
                    $automobile_json['message'] = '<i class="icon-checkmark6"></i> ' . automobile_var_plugin_text_srt('automobile_var_name_available');
                } else {
                    if (preg_match('/\s/', $automobile_field_name)) {
                        $automobile_json['type'] = 'error';
                        $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_whitespaces_not_allowed');
                        echo json_encode($automobile_json);
                        die();
                    }
                    if (preg_match('/[\'^�$%&*()}{@#~?><>,|=+]/', $automobile_field_name)) {
                        $automobile_json['type'] = 'error';
                        $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_Special_character_not_allowed');
                        echo json_encode($automobile_json);
                        die();
                    }
                    if (in_array(trim($automobile_field_name), $form_field_names) && $length > 1) {
                        $automobile_json['type'] = 'error';
                        $automobile_json['message'] = '<i class="icon-times"></i> ' . automobile_var_plugin_text_srt('automobile_var_name_already_exist');
                    } else {
                        $automobile_json['type'] = 'success';
                        $automobile_json['message'] = '<i class="icon-checkmark6"></i> ' . automobile_var_plugin_text_srt('automobile_var_name_available');
                    }
                }
            }
            echo json_encode($automobile_json);
            die();
        }

    }

    global $automobile_inventory_type_fields;

    $automobile_inventory_type_fields = new automobile_inventory_type_dynamic_fields();
}