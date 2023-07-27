<?php
global $post, $automobile_var_plugin_options, $automobile_inv_gallery;
$rand_counter = rand(11342345, 96754534);
$automobile_dealers = $automobile_dealers_array = array();
$latitude = get_post_meta($post->ID, "automobile_post_loc_latitude", true);
$longitude = get_post_meta($post->ID, "automobile_post_loc_longitude", true);
$recent_exp_company = '';
$recent_exp_title = '';
$post_loc_city = get_post_meta($post->ID, 'automobile_post_loc_city', true);
$post_loc_country = get_post_meta($post->ID, 'automobile_post_loc_country', true);
$latitude = isset($latitude) ? $latitude : '40.7143528';
$longitude = isset($longitude) ? $longitude : '-74.0059731';
$automobile_map_zoom_level = get_post_meta($post->ID, 'automobile_post_loc_zoom', true);
$automobile_post_comp_address = get_post_meta($post->ID, 'automobile_post_comp_address', true);



$automobile_inventory_new_price = get_post_meta($post->ID, 'automobile_inventory_new_price', true);
$cs_map_image = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/dealer-no-image.jpg');

$automobile_inventory_username = get_post_meta($post->ID, 'automobile_inventory_username', true);
$automobile_user_detail = get_user_by('id', $automobile_inventory_username);
$automobile_inventory_user_name = isset($automobile_user_detail->display_name) ? $automobile_user_detail->display_name : '';
$automobile_user_status = get_user_meta($automobile_inventory_username, 'automobile_user_status', true);

if (isset($automobile_inv_gallery[0])) {
    $cs_map_image = $automobile_inv_gallery[0];
}
$user_status_icon = '';
if( $automobile_user_status == 'active'){
    $user_status_icon = '<i class="icon-check_circle"></i>';
}
  $cs_map_image = automobile_get_image_thumb($cs_map_image, 'automobile_var_media_3');
$automobile_dealers[] = array(
    'post_id' => '',
    'post_title' => get_the_title($post->ID),
    'permalink' => '',
    'latitude' => $latitude,
    'longitude' => $longitude,
    'position' => '',
    'company' => '',
    'complete_address'=>$automobile_post_comp_address,
    'automobile_var_dealer_map_height' => '340',
    'automobile_var_dealer_map_style' => '',
    'map_image' => $cs_map_image,
    'new_price' => automobile_var_plugin_text_srt('automobile_var_map_price').$automobile_inventory_new_price,
    'complete_address' => $automobile_post_comp_address,
    'author' => $automobile_inventory_user_name,
    'user_status_icon' => $user_status_icon
);
$automobile_var_dealer_map_style = "";
$automobile_dealers_array['posts'] = $automobile_dealers;
$automobile_json_array = json_encode($automobile_dealers_array);
$automobile_map_zoom = '';
if ($automobile_map_zoom_level == '') {
    $automobile_map_zoom = isset($automobile_var_plugin_options['automobile_map_zoom_level']) ? $automobile_var_plugin_options['automobile_map_zoom_level'] : '10';
} else {
    $automobile_map_zoom = $automobile_map_zoom_level;
}
$automobile_var_dealer_map_height = isset($automobile_var_dealer_map_height) ? $automobile_var_dealer_map_height : '340';
if ($latitude != '' && $longitude != '') {
    $automobile_var_map_cluster_icon = isset($automobile_var_plugin_options['automobile_automobile_map_cluster_icon']) ? $automobile_var_plugin_options['automobile_automobile_map_cluster_icon'] : automobile_var::plugin_url() . 'assets/frontend/images/culster-icon.png';
    $automobile_var_map_marker_icon = isset($automobile_var_plugin_options['automobile_automobile_map_marker_icon']) ? $automobile_var_plugin_options['automobile_automobile_map_marker_icon'] : automobile_var::plugin_url() . 'assets/frontend/images/map-marker.png';
    $automobile_map_cluster_color = isset($automobile_var_plugin_options['automobile_map_cluster_color']) ? $automobile_var_plugin_options['automobile_map_cluster_color'] : '#000000';
    $automobile_map_auto_zoom = isset($automobile_var_plugin_options['automobile_map_auto_zoom']) ? $automobile_var_plugin_options['automobile_map_auto_zoom'] : '';
    $automobile_map_lock = isset($automobile_var_plugin_options['automobile_map_lock']) ? $automobile_var_plugin_options['automobile_map_lock'] : '';
    if ($automobile_var_dealer_map_style == "") {
        $cs_theme_options = get_option('automobile_var_options');
        $automobile_var_dealer_map_style = isset($cs_theme_options['automobile_var_def_map_style']) ? $cs_theme_options['automobile_var_def_map_style'] : '';
    } else {
        echo $automobile_var_dealer_map_style = "map-box";
    }
	$automobile_map_control = false;
	$map_control_class = '';
	if( false == $automobile_map_control ){
		$map_control_class = 'disable-map-control';
	}
    ?>
    <div id="cs-map-dealer-<?php echo esc_attr($rand_counter); ?>" class="cs-map-dealer <?php echo $map_control_class; ?>">
        <?php
        $automobile_map_lock_icon = 'icon-unlock';
        if ($automobile_map_lock == 'on') {
            $automobile_map_lock_icon = 'icon-lock3';
        }
        ?>
        <span class="gmaplock" id="gmaplock<?php echo esc_attr($rand_counter); ?>" style="cursor: pointer;"><i class="<?php echo automobile_allow_special_char($automobile_map_lock_icon); ?>"></i></span>
        <div id="automobile_map_<?php echo absint($rand_counter) ?>" style="width: 100%; height: <?php echo absint($automobile_var_dealer_map_height) ?>px;"></div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var dataobj = jQuery.parseJSON('<?php echo addslashes($automobile_json_array) ?>');
            automobile_googlecluster_map('<?php echo esc_js($rand_counter) ?>', '<?php echo esc_js($latitude); ?>', '<?php echo esc_js($longitude); ?>', '<?php echo esc_url($automobile_var_map_cluster_icon) ?>', '<?php echo esc_url($automobile_var_map_marker_icon) ?>', dataobj, <?php echo absint($automobile_map_zoom); ?>, '<?php echo esc_js($automobile_map_cluster_color); ?>', '<?php echo esc_js($automobile_map_auto_zoom); ?>', '<?php echo esc_js($automobile_map_lock); ?>', '<?php echo esc_js($automobile_var_dealer_map_style); ?>', '<?php echo esc_js($automobile_map_control); ?>');
        });
    </script>
    <?php
}