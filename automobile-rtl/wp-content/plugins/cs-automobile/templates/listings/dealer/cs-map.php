<?php
if ($automobile_dealer_map == 'yes') {
    // getting inventory with page number

    $automobile_dealers = $automobile_dealers_array = array();
    if (!empty($loop_count->results)) {
        foreach ($loop_count->results as $user) {
            $latitude = get_user_meta($user->ID, "automobile_post_loc_latitude", true);
            $longitude = get_user_meta($user->ID, "automobile_post_loc_longitude", true);

            $thumb_url = get_user_meta($user->ID, 'user_img', true);
            $thumb_url = automobile_get_img_url($thumb_url, 'automobile_var_media_6');

            $automobile_ext = pathinfo($thumb_url, PATHINFO_EXTENSION);

            if ($thumb_url != '' && $automobile_ext != '') {
                $thumb_url = esc_url($thumb_url);
            } else {
                $thumb_url = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/dealer-no-image.jpg');
            }
            $recent_exp_company = '';
            $recent_exp_title = '';
            $post_loc_city = get_user_meta($user->ID, 'automobile_post_loc_city', true);
            $post_loc_country = get_user_meta($user->ID, 'automobile_post_loc_country', true);
            $automobile_dealer_type = get_user_meta($user->ID, 'automobile_dealer_type', true);
            $automobile_dealer_comp_address = get_user_meta($user->ID, 'automobile_post_loc_address', true);
            $automobile_phone_number=get_user_meta($user->ID, 'automobile_phone_number', true);
           
            
            $automobile_dealers[] = array(
                'post_id' => $user->ID,
                'post_title' => $user->display_name,
                'permalink' => esc_url(get_author_posts_url($user->ID)),
                'latitude' => $latitude,
                'longitude' => $longitude,
               'map_image'=>$thumb_url,
               'complete_address'=>$automobile_dealer_comp_address,
                'position' => ' ',
               'company' => $automobile_dealer_type,
               'city' => $post_loc_city,
               'country' => $post_loc_country,
                'automobile_phone_number'=> $automobile_phone_number,
            );
        }
    }

    $automobile_dealers_array['posts'] = $automobile_dealers;
    $automobile_json_array = json_encode($automobile_dealers_array);

    $automobile_latitude = $automobile_var_dealer_map_lat;
    $automobile_longitude = $automobile_var_dealer_map_long;
    $automobile_map_zoom = $automobile_var_dealer_map_zoom;

    if ($automobile_var_dealer_map_zoom != '' && $automobile_var_dealer_map_zoom != '' && $automobile_var_dealer_map_zoom != '') {


       $automobile_var_map_cluster_icon = isset($automobile_var_plugin_options['automobile_automobile_map_cluster_icon']) ? $automobile_var_plugin_options['automobile_automobile_map_cluster_icon'] : automobile_var::plugin_url() . 'assets/frontend/images/culster-icon.png';
       $automobile_var_map_marker_icon = isset($automobile_var_plugin_options['automobile_automobile_map_marker_icon']) ? $automobile_var_plugin_options['automobile_automobile_map_marker_icon'] : automobile_var::plugin_url() . 'assets/frontend/images/map-marker.png';


        $automobile_map_cluster_color = isset($automobile_var_plugin_options['automobile_map_cluster_color']) ? $automobile_var_plugin_options['automobile_map_cluster_color'] : '#000000';
        $automobile_map_auto_zoom = isset($automobile_var_plugin_options['automobile_map_auto_zoom']) ? $automobile_var_plugin_options['automobile_map_auto_zoom'] : '';
        $automobile_map_lock = isset($automobile_var_plugin_options['automobile_map_lock']) ? $automobile_var_plugin_options['automobile_map_lock'] : '';
        ?>
        <div id="cs-map-dealer-<?php echo esc_attr($rand_counter); ?>" class="cs-map-dealer ">
            <?php
            $automobile_map_lock_icon = 'icon-unlock';
            if ($automobile_map_lock == 'on') {
                $automobile_map_lock_icon = 'icon-lock3';
            }
            
            ?>
            <span class="gmaplock" id="gmaplock<?php echo esc_attr($rand_counter); ?>" style="cursor: pointer;"><i class="<?php echo automobile_allow_special_char($automobile_map_lock_icon); ?>"></i></span>
            <div id="automobile_map_<?php echo absint($rand_counter) ?>" style="width: 100%; height: <?php echo absint($automobile_var_dealer_map_height) ?>px;" class="loader"></div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                var dataobj = jQuery.parseJSON('<?php echo addslashes($automobile_json_array) ?>');
                automobile_googlecluster_listing_map('<?php echo esc_js($rand_counter) ?>', '<?php echo esc_js($automobile_latitude); ?>', '<?php echo esc_js($automobile_longitude); ?>', '<?php echo esc_url($automobile_var_map_cluster_icon) ?>', '<?php echo esc_url($automobile_var_map_marker_icon) ?>', dataobj, <?php echo absint($automobile_map_zoom); ?>, '<?php echo esc_js($automobile_map_cluster_color); ?>', '<?php echo esc_js($automobile_map_auto_zoom); ?>', '<?php echo esc_js($automobile_map_lock); ?>', '<?php echo esc_js($automobile_var_dealer_map_style); ?>');
            });
        </script>
        <?php
    }
}