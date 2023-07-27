<?php

/**
 * The template for Inventory Detail 
 */
global $post, $current_user, $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text, $automobile_inv_gallery;
$strings = new automobile_plugin_all_strings;
$strings->automobile_var_plugin_login_strings();
$strings->automobile_var_plugin_option_strings();

if ( ! function_exists( 'automobile_var_inventory_class' ) ) {

    function automobile_var_inventory_class( $classes ) {
        $classes[] = 'single-page';
        return $classes;
    }

}
add_filter( 'body_class', 'automobile_var_inventory_class' );
if ( is_single() ) {
    automobile_set_post_views( $post->ID );
}
get_header();
$currency_sign = isset( $automobile_var_plugin_options['automobile_currency_sign'] ) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';
$automobile_plugin_single_container = isset( $automobile_var_plugin_options['automobile_plugin_single_container'] ) ? $automobile_var_plugin_options['automobile_plugin_single_container'] : 'on';
$automobile_plugin_single_ads = isset( $automobile_var_plugin_options['automobile_detail_ads'] ) ? $automobile_var_plugin_options['automobile_detail_ads'] : '';
$automobile_old_price = get_post_meta( $post->ID, 'automobile_inventory_old_price', true );
$automobile_new_price = get_post_meta( $post->ID, 'automobile_inventory_new_price', true );
$inventory_type_slug = get_post_meta( $post->ID, 'automobile_inventory_type', true );
$automobile_inv_gallery[0] = esc_url( automobile_var::plugin_url() . 'assets/frontend/images/dealer-no-image.jpg' );
if ( $inventory_type_slug != '' ) {
    $inventory_type_post = get_posts( array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type_slug", 'post_status' => 'publish' ) );
    $inventory_type_id = isset( $inventory_type_post[0]->ID ) ? $inventory_type_post[0]->ID : 0;
} else {
    $inventory_type_id = '';
}
$price_status = get_post_meta( $inventory_type_id, "automobile_price_switch", true );

$automobile_options_inv_view = isset( $automobile_var_plugin_options['automobile_detail_style'] ) ? $automobile_var_plugin_options['automobile_detail_style'] : '';
$automobile_inv_view = get_post_meta( $post->ID, 'automobile_inventory_view', true );
$automobile_inv_feature_list = get_post_meta( $post->ID, 'automobile_inventory_feature_list', true );
$automobile_inventory_username = get_post_meta( $post->ID, 'automobile_inventory_username', true );
$automobile_video_url = get_post_meta( $post->ID, 'automobile_inventory_video_url', true );
$automobile_inventory_user_img = get_user_meta( $automobile_inventory_username, 'user_img', true );
$automobile_inventory_featured = get_post_meta( $post->ID, 'automobile_inventory_featured', true );
if ( $automobile_inventory_user_img != '' ) {
    $automobile_inv_user_img_src = automobile_get_img_url( $automobile_inventory_user_img, 'automobile_var_media_6' );
}
$automobile_post_comp_address = get_post_meta( $post->ID, 'automobile_post_comp_address', true );

$width = 500;
$height = 300;
if ( have_posts() ):
    while ( have_posts() ) : the_post();
        if ( $automobile_inv_view == 'default' || $automobile_inv_view == '' ) {

            if ( $automobile_options_inv_view == 'view-3' ) {
                include 'views/view-3.php';
            } elseif ( $automobile_options_inv_view == 'view-2' ) {
                include 'views/view-2.php';
            } else {
                include 'views/view-1.php';
            }
        } else if ( $automobile_inv_view == 'view-3' ) {
            include 'views/view-3.php';
        } else if ( $automobile_inv_view == 'view-2' ) {
            include 'views/view-2.php';
        } else {
            include 'views/view-1.php';
        }
    endwhile;
endif;

get_footer();
