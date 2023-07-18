<?php
if (isset($qrystr) && $qrystr != '') {
    global $automobile_var_plugin_static_text, $a;			
	if(isset($_POST['page_url']) && $_POST['page_url'] != ''){
		$current_page_url	= $_POST['page_url'];
	} else {
		$current_page_url	= get_permalink();
	}
	if(isset($a['automobile_inventory_view']) && $a['automobile_inventory_view'] != 'fancy'){
    ?>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="auto-your-search">
            <ul class="filtration-tags">
                <?php
                //get all query string
                if (isset($qrystr)) {
                    $qrystr_arr = getMultipleParameters($qrystr);
                    foreach ($qrystr_arr as $qry_var => $qry_val) {
                        if ($qry_val != '') {
                            if (!is_array($qry_val)) {
                                if (strpos($qry_val, ',') !== FALSE) {
                                    $qry_val = explode(",", $qry_val);
                                }
                            }
                            if (is_array($qry_val)) {
                                foreach ($qry_val as $qry_val_var => $qry_val_value) {
                                    if ($qry_val_value != '') {
                                        echo '<li>';
                                        if ($qry_var == 'dealer_type') { // only one remove the specialism
                                            if (strpos($qrystr, ',' . $qry_val_value) !== FALSE) {
                                                $speciliasim_new_qry = str_replace(',' . $qry_val_value, "", $qrystr);
                                            } else if (strpos($qrystr, $qry_val_value . ',') !== FALSE) {
                                                $speciliasim_new_qry = str_replace($qry_val_value . ',', "", $qrystr);
                                            } else {
                                                $speciliasim_new_qry = str_replace($qry_val_value, "", $qrystr);
                                            }

                                            echo '<a href="?' . $speciliasim_new_qry . '">' . str_replace("+", " ", $qry_val_value) . ' <i class="icon-cross2"></i></a>';
                                        } else {
                                            $qrystr1 = str_replace("&" . $qry_var . '[]=' . $qry_val_value, "", $qrystr);
											$qrystr1 = str_replace($qry_var . '[]=' . $qry_val_value, "", $qrystr1);
                                            $qrystr1 = str_replace($qry_var . '=' . $qry_val_value.'&', "", $qrystr1);
                                            $qrystr1 = str_replace("&" . $qry_var . '=' . $qry_val_value, "", $qrystr1);
											if(is_array($qry_val)){
												$qrystr1	= str_replace( $qry_var, $qry_var.'[]', $qrystr1 );
											}
                                            echo '<a href="?' . $qrystr1 . '">' . str_replace("+", " ", $qry_val_value) . ' <i class="icon-cross2"></i></a>';
                                        }

                                        echo '</li>';
                                    }
                                }
                            } else {
                                echo '<li>';
                                if ($qry_var == 'dealer_type') { // only remove the 
                                    if (strpos($qrystr, ',' . $qry_val) !== FALSE) {
                                        $speciliasim_new_qry = str_replace(',' . $qry_val, "", $qrystr);
                                    } elseif (strpos($qrystr, $qry_val . ",") !== FALSE) {
                                        $speciliasim_new_qry = str_replace($qry_val . ",", "", $qrystr);
                                    } else {
                                        $speciliasim_new_qry = str_replace($qry_val, "", $qrystr);
                                    }
                                    echo '<a href="?' . $speciliasim_new_qry . '">' . str_replace("+", " ", $qry_val) . ' <i class="icon-cross2"></i></a>';
                                } else {
                                    echo '<a href="' . automobile_remove_qrystr_extra_var($qrystr, $qry_var) . '">' . str_replace("+", " ", $qry_val) . ' <i class="icon-cross2"></i></a>';
                                }
                                echo '</li>';
                            }
                        }
                    }
                }
                ?>
            </ul>
            <a class="clear-tags cs-color" href="<?php echo $current_page_url; ?>"><?php echo automobile_var_plugin_text_srt('automobile_var_clear_filters'); ?></a>
        </div>
    </div>
    <?php
} }