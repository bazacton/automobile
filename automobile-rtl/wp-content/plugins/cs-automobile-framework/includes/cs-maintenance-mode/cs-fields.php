<?php

if (!class_exists('automobile_maintenance_fields')) {

    class automobile_maintenance_fields {

        /**
         * Construct
         *
         * @return
         */
        public function __construct() {
            
        }
        
        /**
         * All Options Fields
         *
         * @return
         */
        public function automobile_fields($automobile_frame_settings = '') {

            global $automobile_var_frame_options, $automobile_var_form_fields, $automobile_var_html_fields;
            $counter = 0;
            $output = '';

            if (is_array($automobile_frame_settings) && sizeof($automobile_frame_settings) > 0) {
                foreach ($automobile_frame_settings as $value) {
                    $counter++;
                    $val = '';

                    $select_value = '';
                    switch ($value['type']) {
                        
                        case "section":
                            $output .= '
                            <div class="alert alert-info fade in nomargin theme_box">
                                <h4>' . esc_attr($value['std']) . '</h4>
                                <div class="clear"></div>
                            </div>';
                        break;
                            
                        case "checkbox":

                            if (isset($automobile_var_frame_options['automobile_var_' . $value['id']])) {
                                $checked_value = $automobile_var_frame_options['automobile_var_' . $value['id']];
                            } else {
                                $checked_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $automobile_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'id' => isset($value['id']) ? 'automobile_var_' . $value['id'] . '_checkbox' : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'field_params' => array(
                                    'std' => $checked_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $automobile_var_html_fields->automobile_var_checkbox_field($automobile_opt_array);

                        break;

                        case 'select':
                            if (isset($automobile_var_frame_options['automobile_var_' . $value['id']])) {
                                $select_value = $automobile_var_frame_options['automobile_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $automobile_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'extra_atr' => isset($value['extra_att']) ? $value['extra_att'] : '',
                                    'return' => true,
                                    'options' => isset($value['options']) ? $value['options'] : '',
                                ),
                            );
                            $output .= $automobile_var_html_fields->automobile_var_select_field($automobile_opt_array);

                        break;
                    }
                }
            }

            return $output;
        }

    }

}