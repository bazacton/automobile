<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$var_arrays = array('wp_query');
$page_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}

$woo_pagination = paginate_links( array(
	'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
	'format'       => '',
	'add_args'     => '',
	'current'      => max( 1, get_query_var( 'paged' ) ),
	'total'        => $wp_query->max_num_pages,
	'prev_text'    => '<i class="icon-angle-left"></i> '.esc_html__('Previous', 'automobile'),
	'next_text'    => esc_html__('Next', 'automobile').' <i class="icon-angle-right"></i>',
	'type'         => 'array',
	'end_size'     => 3,
	'mid_size'     => 3
) );

$automobile_var_pages = '';
if (is_array($woo_pagination) && sizeof($woo_pagination) > 0) {
    $automobile_var_pages .= '<ul class="pagination">';
    foreach ($woo_pagination as $automobile_var_link) {
        if (strpos($automobile_var_link, 'current') !== false) {
            
            $automobile_var_pages .= '<li ><a class="active">' . preg_replace("/[^0-9]/", "", $automobile_var_link) . '</a></li>';
        } else {
            $automobile_var_pages .= '<li>' . $automobile_var_link . '</li>';
        }
    }
    $automobile_var_pages .= '</ul>';
}

echo automobile_allow_special_char($automobile_var_pages);
