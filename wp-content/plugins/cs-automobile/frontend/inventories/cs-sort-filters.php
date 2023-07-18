<?php
/**
 * Inventories Sort Filters
 *
 */
global $wpdb, $a, $automobile_form_fields, $inventory_sort_by, $inventory_filter_page_size, $automobile_var_plugin_static_text;

$automobile_search_side = 'off';
if ( $a['automobile_inventory_searchbox'] == 'yes' ) {
    $automobile_search_side = 'on';
}
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="auto-sort-filter">
        <?php if ( isset( $count_post ) && $count_post != '' ) { ?>
            <div class="auto-show-resuilt"><span><?php echo automobile_var_plugin_text_srt( 'automobile_var_showing' ); ?> <em><?php echo esc_html( $count_post ) ?></em> <?php echo automobile_var_plugin_text_srt( 'automobile_var_results_search' ); ?></span></div>
        <?php } ?>
        <div class="auto-list">
            <span><?php echo automobile_var_plugin_text_srt( 'automobile_var_sort' ); ?></span>
            <ul>
                <li>
                    <div class="cs-select-post">
                        <?php
                        $automobile_opt_array = array(
                            'cust_id' => 'inventory_filter_sort_by',
                            'cust_name' => 'inventory_filter_sort_by',
                            'std' => $inventory_sort_by,
                            'desc' => '',
                            'extra_atr' => ' onchange="automobile_set_sort_filter(\'' . esc_js( admin_url( 'admin-ajax.php' ) ) . '\', \'inventory_filter_sort_by\')"',
                            'classes' => 'chosen-select-no-single',
                            'options' => array( 'recent' => automobile_var_plugin_text_srt( 'automobile_var_most_recent' ), 'featured' => automobile_var_plugin_text_srt( 'automobile_var_featured_only' ), 'alphabetical' => automobile_var_plugin_text_srt( 'automobile_var_alphabet_order' ) ),
                            'hint_text' => '',
                        );

                        $automobile_form_fields->automobile_form_select_render( $automobile_opt_array );

                        echo '<form name="filter_form_val" id="filter_form_val">';
                        foreach ( $_REQUEST as $request_key => $request_val ) {
                            if ( $request_key != 'action' && $request_key != 'automobile_inv_elem_atts' ) {
                                if ( is_array( $request_val ) ) {
                                    foreach ( $request_val as $req_val ) {
                                        echo '<input type="hidden" name="' . $request_key . '" value="' . $req_val . '">';
                                    }
                                } else {
                                    echo '<input type="hidden" name="' . $request_key . '" value="' . $request_val . '">';
                                }
                            }
                        }
                        echo '</form>';
                        ?>
                    </div>
                </li>
                <?php $active_view    = ( isset( $a['automobile_inventory_view'] ) && $a['automobile_inventory_view'] == 'grid' ) ? 'active': '';  ?>
                <li><a class="cs-inv-grid-view <?php echo $active_view; ?>" data-search="<?php echo esc_html( $automobile_search_side ) ?>"><i class="icon-view_module"></i></a></li>
                <?php $active_view    = ( isset( $a['automobile_inventory_view'] ) && $a['automobile_inventory_view'] == 'classic' ) ? 'active': '';  ?>
                <li><a class="cs-inv-classic-view <?php echo $active_view; ?>" data-search="<?php echo esc_html( $automobile_search_side ) ?>"><i class="icon-view_array"></i></a></li>
            </ul>
        </div>
    </div>
</div>