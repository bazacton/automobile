<?php
/**
 * Dealer Sort Filters
 *
 */
global $wpdb, $a, $automobile_form_fields, $inventory_sort_by, $inventory_filter_page_size, $automobile_var_plugin_static_text;
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="cs-inventories-listing-loader"></div>
    <div class="auto-sort-filter">
        <?php if (isset($count_post) && $count_post != '') { ?>
            <div class="auto-show-resuilt"><span><?php echo automobile_var_plugin_text_srt('automobile_var_showing'); ?> <em><?php echo esc_html($count_post) ?></em> <?php echo automobile_var_plugin_text_srt('automobile_var_results_search'); ?></span></div>
        <?php } ?>
        <div class="auto-list">
            <span><?php echo automobile_var_plugin_text_srt('automobile_var_sort'); ?></span>
            <ul>
                <li>
                    <div class="cs-select-post">
                        <?php
                        $dealer_filter_sort_by = (isset($_SESSION['dealer_filter_sort_by'])) ? $_SESSION['dealer_filter_sort_by'] : '';
                        $automobile_opt_array = array(
                            'cust_id' => 'dealer_filter_sort_by',
                            'cust_name' => 'dealer_filter_sort_by',
                            'std' => $dealer_filter_sort_by,
                            'desc' => '',
                            'extra_atr' => ' onchange="automobile_dealer_sort_filter(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'dealer_filter_sort_by\')"',
                            'classes' => 'chosen-select-no-single',
                            'options' => array('ASC' => automobile_var_plugin_text_srt('automobile_var_asc'), 'DESC' => automobile_var_plugin_text_srt('automobile_var_dsc')),
                            'hint_text' => '',
                        );

                        $automobile_form_fields->automobile_form_select_render($automobile_opt_array);

                        echo '<form name="filter_form_val" id="filter_form_val">';
                        foreach ($_REQUEST as $request_key => $request_val) {
                            if ($request_key != 'action' && $request_key != 'automobile_inv_elem_atts') {
                                echo '<input type="hidden" name="' . $request_key . '" value="' . $request_val . '">';
                            }
                        }
                        echo '</form>';
                        ?>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>