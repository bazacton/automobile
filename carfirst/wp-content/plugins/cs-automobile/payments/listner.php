<?php
/*
 *File : Listener file for payment post in transaction custom post
 */

include_once('../../../../wp-load.php');

// Payment transaction custom transaction post
if ( ! function_exists('automobile_update_transaction') ) {

    function automobile_update_transaction($automobile_trans_array = array(), $automobile_trans_id) {

        foreach ($automobile_trans_array as $trans_key => $trans_val) {
            update_post_meta($automobile_trans_id, "$trans_key", $trans_val);
        }
    }
}

// Payment transaction custom post update 

if (!function_exists('automobile_update_post')) {

    function automobile_update_post($id = '', $automobile_trans_id = '') {
        global $automobile_var_plugin_options;
        $automobile_trans_type = get_post_meta($automobile_trans_id, 'automobile_transaction_type', true);

        if ($automobile_trans_type != 'cv_trans') {
            $automobile_transaction_id = get_post_meta($automobile_trans_id, 'automobile_transaction_id', true);
			$automobile_trans_feat = get_post_meta($automobile_trans_id, 'automobile_transaction_feature', true);
            $automobile_trans_pkg = get_post_meta($automobile_trans_id, 'automobile_transaction_package', true);
            if ($id == $automobile_trans_pkg) {
				update_post_meta($automobile_trans_id, 'automobile_inventory_id', '');
            }
            if (isset($automobile_var_plugin_options['automobile_inventories_review_option']) && $automobile_var_plugin_options['automobile_inventories_review_option'] != 'on') {
				update_post_meta((int) $id, 'automobile_inventory_status', 'active'); // automated active inventory if admin didn't set this option 
            } else {
				update_post_meta((int) $id, 'automobile_inventory_status', 'awaiting-activation');    // wait for approval if admin set this option
            }
			
			$to = 'example@abc.com';
			$subject = 'Paypal ipn call for automobile ';
			$message = 'id is = ' . $id . '-------';
			$headers = 'From: webmaster@inventory.chimpgroup.com' . "\r\n" .
			mail($to, $subject, $message, $headers);
			
            update_post_meta((int) $id, 'automobile_inventory_featured', $automobile_trans_feat);
            if ($automobile_trans_pkg != '') {
                update_post_meta((int) $id, 'automobile_trans_id', $automobile_transaction_id);
                update_post_meta((int) $id, 'automobile_inventory_package', $automobile_trans_pkg);
            }
        } else {
			update_post_meta($automobile_trans_id, 'automobile_resume_ids', '');
        }
    }

}
 
$postback = 'cmd=_notify-validate';

// go through each of the posted vars and add them to the postback variable

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $postback .= "&$key=$value";
}

$ourFileName = "debug1_postdata.txt";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
fwrite($ourFileHandle, $postback);
fclose($ourFileHandle);


/*
 * Paypal Gateway Listner
 */

if (isset($_POST['payment_status']) && $_POST['payment_status'] == 'Completed') {

    $inventory_id = $_POST['item_number'];
    if (isset($inventory_id) && $inventory_id != '') {
        if (isset($_POST['txn_id']) && $_POST['txn_id'] <> '') {
            
            $transaction_array = array();
            $transaction_array['automobile_trans_id'] = esc_attr($_POST['txn_id']);
            $transaction_array['automobile_inventory_id'] = esc_attr($_POST['item_number']);
            $transaction_array['automobile_transaction_status'] = 'approved';
            $transaction_array['automobile_full_address'] = esc_attr($_POST['address_street']) . ' ' . esc_attr($_POST['address_city']) . ' ' . esc_attr($_POST['address_country']);
            $transaction_array['automobile_transaction_amount'] = esc_attr($_POST['payment_gross']);
            $transaction_array['automobile_transaction_pay_method'] = 'automobile_paypal_gateway';
            $transaction_array['automobile_trans_currency'] = esc_attr($_POST['mc_currency']);
            $transaction_array['automobile_summary_email'] = esc_attr($_POST['payer_email']);
            $transaction_array['automobile_first_name'] = esc_attr($_POST['first_name']);

            $transaction_array['automobile_last_name'] = esc_attr($_POST['automobile_last_name']);
            
            $automobile_trans_id = isset($_POST['custom']) ? $_POST['custom'] : '';
            
            automobile_update_transaction($transaction_array, $automobile_trans_id);
            automobile_update_post($inventory_id, $automobile_trans_id);
        }
    }
}

/*
 * Authorize Gateway Listner
 */
if (isset($_POST['x_response_code']) && $_POST['x_response_code'] == '1') {

    $inventory_id = $_POST['x_cust_id'];

    if (isset($inventory_id) && $inventory_id != '') {
        $transaction_array = array();
        $transaction_array['automobile_inventory_id'] = esc_attr($inventory_id);
        $transaction_array['transaction_purchase_on'] = date('Y-m-d H:i:s');

        $transaction_array['automobile_transaction_status'] = 'approved';
        $transaction_array['automobile_transaction_pay_method'] = 'automobile_authorizedotnet_gateway';
        $transaction_array['order_id'] = esc_attr($_POST['x_po_num']);

        $transaction_array['summary_status'] = 'Completed';
        $transaction_array['automobile_trans_id'] = esc_attr($_POST['x_trans_id']);
        $transaction_array['automobile_transaction_amount'] = esc_attr($_POST['x_amount']);
        $transaction_array['automobile_trans_currency'] = 'USD';

        $transaction_array['address_street'] = esc_attr($_POST['x_address']);
        $transaction_array['address_city'] = esc_attr($_POST['x_city']);
        $transaction_array['address_country'] = esc_attr($_POST['x_country']);
        $transaction_array['automobile_full_address'] = esc_attr($_POST['x_address']) . ' ' . esc_attr($_POST['x_city']) . ' ' . esc_attr($_POST['x_country']);

        if (esc_attr($_POST['x_email'] == '')) {
            $transaction_array['automobile_summary_email'] = automobile_get_user_data($transaction_array['order_id'], 'email');
        } else {
            $transaction_array['automobile_summary_email'] = esc_attr($_POST['x_email']);
        }

        if (esc_attr($_POST['x_first_name'] == '')) {
            $transaction_array['automobile_first_name'] = automobile_get_user_data($transaction_array['order_id'], 'first_name');
        } else {
            $transaction_array['automobile_first_name'] = esc_attr($_POST['x_first_name']);
        }

        if (esc_attr($_POST['x_last_name'] == '')) {
            $transaction_array['automobile_last_name'] = automobile_get_user_data($transaction_array['order_id'], 'last_name');
        } else {
            $transaction_array['automobile_last_name'] = esc_attr($_POST['x_last_name']);
        }

        $package_id = get_post_meta((int) $transaction_array['order_id'], 'transaction_package', true);

        $automobile_trans_id = isset($_POST['x_po_num']) ? $_POST['x_po_num'] : '';

        automobile_update_transaction($transaction_array, $automobile_trans_id);
		automobile_update_post($inventory_id, $automobile_trans_id);
    }
}

/*
 * Skrill Gateway Listner
 */

if (isset($_POST['merchant_id'])) {
    // Validate the Moneybookers signature
    $concatFields = $_POST['merchant_id']
            . $_POST['order_id']
            . strtoupper(md5('Paste your secret word here'))
            . $_POST['mb_amount']
            . $_POST['mb_currency']
            . $_POST['status'];

    $automobile_var_plugin_options = get_option('automobile_var_plugin_options');

    $MBEmail = $automobile_var_plugin_options['skrill_email'];

     if (isset($_POST['status']) && $_POST['status'] == '2' && trim($_POST['pay_to_email']) == trim($MBEmail)) {
        $data = explode('||', $_POST['transaction_id']);
        $order_id = $data[0];
        $inventory_id = $data[1];

        if (isset($inventory_id) && $inventory_id != '') {
            $transaction_array = array();
            $transaction_array['automobile_inventory_id'] = esc_attr($inventory_id);
            $transaction_array['transaction_purchase_on'] = date('Y-m-d H:i:s');
            $transaction_array['automobile_transaction_status'] = 'approved';
            $transaction_array['automobile_transaction_pay_method'] = 'automobile_skrill_gateway';
            $transaction_array['order_id'] = esc_attr($order_id);

            $transaction_array['summary_status'] = 'Completed';
            $transaction_array['automobile_trans_id'] = esc_attr($_POST['mb_transaction_id']);
            $transaction_array['automobile_transaction_amount'] = esc_attr($_POST['amount']);
            $transaction_array['automobile_trans_currency'] = $_POST['currency'];
            $transaction_array['transaction_address'] = '';


            $package_id = get_post_meta((int) $transaction_array['order_id'], 'transaction_package', true);

            $user_id = get_post_meta((int) $transaction_array['order_id'], 'transaction_user', true);

            if ($user_id != '') {
                if ($_POST['summary_email'] == '') {
                    $transaction_array['automobile_summary_email'] = automobile_get_user_data($transaction_array['order_id'], 'email');
                }

                $transaction_array['automobile_first_name'] = automobile_get_user_data($transaction_array['order_id'], 'first_name');
                $transaction_array['automobile_last_name'] = automobile_get_user_data($transaction_array['order_id'], 'last_name');
                $transaction_array['automobile_full_address'] = automobile_get_user_data($transaction_array['order_id'], 'address');
            }

            $automobile_trans_id = isset($order_id) ? $order_id : '';

            automobile_update_transaction($transaction_array, $automobile_trans_id);
            automobile_update_post($inventory_id, $automobile_trans_id);
        }
    } else {
      
    }
}

/*
 * start function for get user data
 */

if (!function_exists('automobile_get_user_data')) {

    function automobile_get_user_data($order_id = '', $key = '') {
        $user_id = get_post_meta((int) $order_id, 'transaction_user', true);
        if ($user_id != '') {
            if ($key != '') {
                return get_user_meta($user_id, $key, true);
            }
        }
        return;
    }

}