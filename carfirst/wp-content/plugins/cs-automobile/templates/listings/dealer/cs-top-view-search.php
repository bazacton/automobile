<?php
/*
 *
 * Dealer Top view Searchbox
 * 
 *
 */
global $automobile_var_plugin_options, $automobile_var_plugin_static_text;
?>
<div class="cs-ag-search">
    <ul class="filter-list">

        <li><a href="<?php echo esc_url(automobile_remove_qrystr_extra_var($qrystr, 'alphanumaric')); ?>"><?php echo esc_html(automobile_var_plugin_text_srt('automobile_var_all')); ?></a></li>

        <?php
        $alphas_arr = range('A', 'Z');
        $query_str_anchor_url = "";
        foreach ($alphas_arr as $char) {
            $query_str_anchor_url = automobile_remove_qrystr_extra_var($qrystr, 'alphanumaric');
            if (automobile_remove_qrystr_extra_var($qrystr, 'alphanumaric') != '?') {
                $query_str_anchor_url .= '&';
            }$query_str_anchor_url .='alphanumaric=' . esc_html($char);
            ?>
            <li>
                <a href="<?php echo esc_url($query_str_anchor_url); ?>" class="<?php echo esc_html($char); ?>">
                    <?php echo esc_html($char); ?>
                </a>
            </li>
            <?php
        }
        ?>
        <li><a href="?alphanumaric=numeric">0-9</a></li> 
    </ul>
</div>