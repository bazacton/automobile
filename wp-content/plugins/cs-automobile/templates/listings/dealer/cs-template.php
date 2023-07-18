<?php
/**
 * File Type: Dealer Shortcode
 *
 * Start Function how to show the employee listing
 *
 */
if (!function_exists('automobile_dealer_listing')) {

    function automobile_dealer_listing($atts, $content = "") {
        ob_start();
        global $wpdb, $automobile_var_plugin_options, $automobile_form_fields, $automobile_var_plugin_static_text;
        $rand_counter = rand(11342345, 96754534);
        $automobile_loc_latitude = isset($automobile_var_plugin_options['automobile_post_loc_latitude']) ? $automobile_var_plugin_options['automobile_post_loc_latitude'] : '';
        $automobile_loc_longitude = isset($automobile_var_plugin_options['automobile_post_loc_longitude']) ? $automobile_var_plugin_options['automobile_post_loc_longitude'] : '';
        $automobile_map_zoom_level = isset($automobile_var_plugin_options['automobile_map_zoom_level']) ? $automobile_var_plugin_options['automobile_map_zoom_level'] : '';
        $a = shortcode_atts(
                array(
            'column_size' => '1/1',
            'automobile_dealer_title' => '',
            'automobile_dealer_sub_title' => '',
            'automobile_dealer_searchbox' => 'yes', // yes or no
            'automobile_dealer_searchbox_top' => 'yes', // yes or no
            'automobile_dealer_searchbox_title_top' => '', // yes or no
            'automobile_dealer_show_pagination' => 'pagination',
            'automobile_dealer_pagination' => '', // yes or no
            'automobile_dealer_map' => 'on', // as per your requirement only numbers(0-9)
            'automobile_var_dealer_map_lat' => $automobile_loc_latitude,
            'automobile_var_dealer_map_long' => $automobile_loc_longitude,
            'automobile_var_dealer_map_zoom' => $automobile_map_zoom_level,
            'automobile_var_dealer_map_height' => '355',
            'automobile_var_dealer_map_style' => '',
                ), $atts
        );
        extract($a);
        
        ?>
        <!-- alert for complete theme -->
        <div class="automobile_alerts"></div>
        <!-- main-cs-loader for complete theme -->
        <div class="main-cs-loader" ></div>
        <?php
        // getting all record of dealer for paging
        /*
        if (empty($_GET['page_dealer']))
            $_GET['page_dealer'] = 1;
         * 
         */
        $qrystr = '';
        if($automobile_var_dealer_map_style=="")
        {
        $cs_theme_options=get_option('automobile_var_options');
       $automobile_var_dealer_map_style=  isset($cs_theme_options['automobile_var_def_map_style'])?$cs_theme_options['automobile_var_def_map_style']:'';
        }
        else{
          echo  $automobile_var_dealer_map_style="map-box";
        }
        #############################################
        #           Filtration Start            #####
        #############################################
        ############ filtration proccess ############
        $filter_arr = '';
        $posted = '';
        $dealer_type = '';
        $location = '';
        $default_date_time_formate = 'd-m-Y H:i:s';
        $automobile_dealer_activity_date_formate = 'd-m-Y H:i:s';
        if (isset($_GET['location']))
            $location = $_GET['location'];
        if (isset($_GET['posted']))
            $posted = $_GET['posted'];
        if (isset($_GET['dealer_type']) && $_GET['dealer_type'] != '') {
            $dealer_type = $_GET['dealer_type'];
            $qrystr .= '&dealer_type=' . $_GET['dealer_type'];
            if (!is_array($dealer_type))
                $dealer_type = Array($dealer_type);
        } elseif (isset($_GET['dealer_type_string']) && $_GET['dealer_type_string'] != '') {
            $dealer_type = explode(",", $_GET['dealer_type_string']);
            $qrystr .= '&dealer_type=' . $_GET['dealer_type_string'];
        }
        $cus_fields_count_arr = '';
        // posted date check
        if ($posted != '') {
            $lastdate = '';
            $now = '';
            $qrystr .= '&posted=' . $posted;  // added again this var in query string for linking again
            if ($posted == 'lasthour') {
                $now = date($default_date_time_formate);
                $lastdate = date($default_date_time_formate, strtotime('-1 hours', time()));
            } elseif ($posted == 'last24') {
                $now = date($default_date_time_formate);
                $lastdate = date($default_date_time_formate, strtotime('-24 hours', time()));
            } elseif ($posted == '7days') {
                $now = date($default_date_time_formate);
                $lastdate = date($default_date_time_formate, strtotime('-7 days', time()));
            } elseif ($posted == '14days') {
                $now = date($default_date_time_formate);
                $lastdate = date($default_date_time_formate, strtotime('-14 days', time()));
            } elseif ($posted == '30days') {
                $now = date($default_date_time_formate);
                $lastdate = date($default_date_time_formate, strtotime('-30 days', time()));
            }
            if ($lastdate != '' && $now != '') {
                $filter_arr[] = array(
                    'key' => 'automobile_user_last_activity_date',
                    'value' => strtotime($lastdate),
                    'compare' => '>=',
                );
                // for count query
                $cus_fields_count_arr['posted'][] = array(
                    'key' => 'automobile_user_last_activity_date',
                    'value' => strtotime($lastdate),
                    'compare' => '>=',
                );
            }
        }
 global $wp_filesystem;
	  if (empty($wp_filesystem)) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
			}
        $cus_fields_count_arr = '';
        $location_condition_arr = '';
        // location check
        if ($location != '') {
            $automobile_radius_switch = isset($automobile_var_plugin_options['automobile_radius_switch']) ? $automobile_var_plugin_options['automobile_radius_switch'] : 'on';
            if (isset($_GET['radius']) && $_GET['radius'] > 0 && $automobile_radius_switch == 'on') {
                $automobile_radius = $_GET['radius'];
                $automobile_radius_measure = isset($automobile_var_plugin_options['automobile_radius_measure']) ? $automobile_var_plugin_options['automobile_radius_measure'] : '';
                $distance_km_miles = $automobile_radius_measure;
                $qrystr .= '&radius=' . $automobile_radius;  // added again this var in query string for linking again
                $automobile_radius = preg_replace("/[^0-9,.]/", "", $automobile_radius);
                if ($distance_km_miles == 'km') {
                    if (isset($_GET['radius'])) {
                        $automobile_radius = $automobile_radius * 0.621371;    // for km
                    }
                }
                $Latitude = '';
                $Longitude = '';
                $prepAddr = '';
                $minLat = '';
                $maxLat = '';
                $minLong = '';
                $maxLong = '';
                if (isset($_GET['location']) && !empty($_GET['location'])) {
                    $address = sanitize_text_field($_GET['location']);
                    $prepAddr = str_replace(' ', '+', $address);
                    $geocode = $wp_filesystem->get_contents(automobile_server_protocol() . 'google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
                    $output = json_decode($geocode);
                    $Latitude = $output->results[0]->geometry->location->lat;
                    $Longitude = $output->results[0]->geometry->location->lng;
                    if (isset($Latitude) && $Latitude <> '' && isset($Longitude) && $Longitude <> '') {
                        $zcdRadius = new RadiusCheck($Latitude, $Longitude, $automobile_radius);
                        $minLat = $zcdRadius->MinLatitude();
                        $maxLat = $zcdRadius->MaxLatitude();
                        $minLong = $zcdRadius->MinLongitude();
                        $maxLong = $zcdRadius->MaxLongitude();
                    }
                }

                if ($minLat != '' && $maxLat != '' && $minLong != '' && $maxLong != '') {
                    $radius_array = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'automobile_post_loc_latitude',
                            'value' => array($minLat, $maxLat),
                            'compare' => 'BETWEEN',
                            'type' => 'CHAR'
                        ),
                        array(
                            'key' => 'automobile_post_loc_longitude',
                            'value' => array($minLong, $maxLong),
                            'compare' => 'BETWEEN',
                            'type' => 'CHAR'
                        ),
                    );
                }
            }
            $qrystr .= '&location=' . $location;  // added again this var in query string for linking again

            $automobile_location_type = isset($automobile_var_plugin_options['automobile_search_by_location']) ? $automobile_var_plugin_options['automobile_search_by_location'] : '';
            if ($automobile_location_type == 'countries_and_cities' || $automobile_location_type == 'countries_only') {
                if (isset($radius_array) && is_array($radius_array)) {

                    $location_condition_arr[] = array(
                        'relation' => 'AND',
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => 'automobile_post_loc_city',
                                'value' => $location,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_post_loc_country',
                                'value' => $location,
                                'compare' => '=',
                            ),
                            $radius_array,
                        )
                    );
                    // for count query
                    $cus_fields_count_arr['location'][] = array(
                        'relation' => 'AND',
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => 'automobile_post_loc_city',
                                'value' => $location,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_post_loc_country',
                                'value' => $location,
                                'compare' => '=',
                            ),
                            $radius_array,
                        )
                    );
                } else {
                    $location_condition_arr[] = array(
                        'relation' => 'OR',
                        array(
                            'key' => 'automobile_post_loc_city',
                            'value' => $location,
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'automobile_post_loc_country',
                            'value' => $location,
                            'compare' => '=',
                        )
                    );

                    // for count query
                    $cus_fields_count_arr['location'][] = array(
                        'key' => 'automobile_post_loc_city',
                        'value' => $location,
                        'compare' => '=',
                    );
                    $cus_fields_count_arr['location'][] = array(
                        'key' => 'automobile_post_loc_country',
                        'value' => $location,
                        'compare' => '=',
                    );
                }
            } elseif ($automobile_location_type == 'cities_only' || $automobile_location_type == 'single_city') {

                if (isset($radius_array) && is_array($radius_array)) {
                    $location_condition_arr[] = array(
                        'relation' => 'AND',
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => 'automobile_post_loc_city',
                                'value' => $location,
                                'compare' => '=',
                            ),
                            $radius_array,
                        )
                    );
                    // for count query
                    $cus_fields_count_arr['location'][] = array(
                        'relation' => 'AND',
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => 'automobile_post_loc_city',
                                'value' => $location,
                                'compare' => '=',
                            ),
                            $radius_array,
                        )
                    );
                } else {
                    $location_condition_arr[] = array(
                        'key' => 'automobile_post_loc_city',
                        'value' => $location,
                        'compare' => '=',
                    );

                    // for count query
                    $cus_fields_count_arr['location'][] = array(
                        'key' => 'automobile_post_loc_city',
                        'value' => $location,
                        'compare' => '=',
                    );
                }
            }
        }
        // end posted date check
        // location check

        $alphanumaric = '';
        $alphabatic_qrystr = '';
        if (isset($_GET['alphanumaric']) && $_GET['alphanumaric'] != '') {
            $alphanumaric = $_GET['alphanumaric'];
        }
        if ($alphanumaric != '') {

            $qrystr .= '&alphanumaric=' . $alphanumaric; // using this in paging
            $keyword = 'a-z';
            $comapare = ' NOT REGEXP ';
            if ($alphanumaric != "numeric") {
                $keyword = $alphanumaric;
                $comapare = ' REGEXP '; // only specific alphabets
            }
            $alphabatic_qrystr = " AND display_name " . $comapare . " '^[" . $keyword . "]' ";
        }
        // posted date check
        $filter_arr2[] = '';


        // Dealer Tywep check
        if ($dealer_type != '' && $dealer_type != 'All Dealer Type') {

            foreach ($dealer_type as $dealer_type_key) {
                $filter_arr[] = array(
                    'key' => 'automobile_dealer_type',
                    'value' => $dealer_type_key,
                    'compare' => 'LIKE',
                );
            }
        }



        // end inventory_type check
        // load all custom fileds for filtration 

        $automobile_dealer_cus_fields = get_option("automobile_dealer_cus_fields");
        if (is_array($automobile_dealer_cus_fields) && sizeof($automobile_dealer_cus_fields) > 0) {
            foreach ($automobile_dealer_cus_fields as $cus_field) {
                if (isset($cus_field['enable_srch']) && $cus_field['enable_srch'] == 'yes') {
                    $query_str_var_name = $cus_field['meta_key'];
                    if (isset($_GET[$query_str_var_name]) && $_GET[$query_str_var_name] != '') {
                        if (!isset($cus_field['multi']) || $cus_field['multi'] != 'yes') {
                            $qrystr .= '&' . $query_str_var_name . '=' . $_GET[$query_str_var_name];
                        }
                        if ($cus_field['type'] == 'dropdown') {
                            if (isset($cus_field['multi']) && $cus_field['multi'] == 'yes') {
                                $_query_string_arr = getMultipleParameters();
                                $filter_multi_arr = ['relation' => 'OR',];
                                foreach ($_query_string_arr[$query_str_var_name] as $query_str_var_name_key) {
                                    if ($cus_field['post_multi'] == 'yes') {
                                        $filter_multi_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => serialize($query_str_var_name_key),
                                            'compare' => 'Like',
                                        );
                                    } else {
                                        $filter_multi_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => $query_str_var_name_key,
                                            'compare' => '=',
                                        );
                                    }
                                    $qrystr .= '&' . $query_str_var_name . '=' . $query_str_var_name_key;
                                }
                                $filter_arr[] = array(
                                    $filter_multi_arr
                                );
                                // for count query
                                $cus_fields_count_arr[$query_str_var_name][] = array(
                                    $filter_multi_arr
                                );
                            } else {
                                if ($cus_field['post_multi'] == 'yes') {
                                    $filter_arr[] = array(
                                        'key' => $query_str_var_name,
                                        'value' => serialize($_GET[$query_str_var_name]),
                                        'compare' => 'Like',
                                    );
                                    // for count query
                                    $cus_fields_count_arr[$query_str_var_name][] = array(
                                        'key' => $query_str_var_name,
                                        'value' => serialize($_GET[$query_str_var_name]),
                                        'compare' => 'Like',
                                    );
                                } else {
                                    $filter_arr[] = array(
                                        'key' => $query_str_var_name,
                                        'value' => $_GET[$query_str_var_name],
                                        'compare' => '=',
                                    );
                                    // for count query
                                    $cus_fields_count_arr[$query_str_var_name][] = array(
                                        'key' => $query_str_var_name,
                                        'value' => $_GET[$query_str_var_name],
                                        'compare' => '=',
                                    );
                                }
                            }
                        } elseif ($cus_field['type'] == 'text' || $cus_field['type'] == 'email' || $cus_field['type'] == 'url') {
                            $filter_arr[] = array(
                                'key' => $query_str_var_name,
                                'value' => $_GET[$query_str_var_name],
                                'compare' => 'LIKE',
                            );
                            // for count query
                            $cus_fields_count_arr[$query_str_var_name][] = array(
                                'key' => $query_str_var_name,
                                'value' => $_GET[$query_str_var_name],
                                'compare' => 'LIKE',
                            );
                        } elseif ($cus_field['type'] == 'range') {
                            $ranges_str_arr = explode(",", $_GET[$query_str_var_name]);
                            $range_first = isset($ranges_str_arr[0]) ? $ranges_str_arr[0] : '';
                            $range_seond = isset($ranges_str_arr[1]) ? $ranges_str_arr[1] : '';
                            $filter_arr[] = array(
                                'key' => $query_str_var_name,
                                'value' => $range_first,
                                'compare' => '>=',
                                'type' => 'NUMERIC'
                            );
                            $filter_arr[] = array(
                                'key' => $query_str_var_name,
                                'value' => $range_seond,
                                'compare' => '<=',
                                'type' => 'NUMERIC'
                            );

                            // for count query
                            $cus_fields_count_arr[$query_str_var_name][] = array(
                                'key' => $query_str_var_name,
                                'value' => $range_first,
                                'compare' => '>=',
                                'type' => 'NUMERIC'
                            );
                            // for count query
                            $cus_fields_count_arr[$query_str_var_name][] = array(
                                'key' => $query_str_var_name,
                                'value' => $range_seond,
                                'compare' => '<=',
                                'type' => 'NUMERIC'
                            );
                        } elseif ($cus_field['type'] == 'date') {
                            $filter_arr[] = array(
                                'key' => $query_str_var_name,
                                'value' => $_GET[$query_str_var_name],
                                'compare' => 'LIKE',
                            );
                            $cus_fields_count_arr[$query_str_var_name][] = array(
                                'key' => $query_str_var_name,
                                'value' => $_GET[$query_str_var_name],
                                'compare' => 'LIKE',
                            );
                        }
                    }
                }
            }
        }
        // end load all custom fileds for filtration

        $meta_post_ids_arr = '';
        $dealer_name_id_condition = '';
        if (isset($filter_arr) && !empty($filter_arr)) {

            $meta_post_ids_arr = automobile_get_query_whereclase_by_array($filter_arr, true);
            // if no result found in filtration 
            if (empty($meta_post_ids_arr)) {
                $meta_post_ids_arr = array(0);
            }
            $ids = $meta_post_ids_arr != '' ? implode(",", $meta_post_ids_arr) : '0';
            $dealer_name_id_condition = " ID in (" . $ids . ") AND ";
        }
        $automobile_dealer_name = '';
        if (isset($_GET['automobile_dealer_name'])) {
            $automobile_dealer_name = $_GET['automobile_dealer_name'];
            $automobile_dealer_name = str_replace("+", " ", $automobile_dealer_name);
        }


        $automobile_dealer_type = '';
        if (isset($_GET['dealer_type'])) {
            $automobile_dealer_type = $_GET['dealer_type'];
            $automobile_dealer_type = str_replace("+", " ", $automobile_dealer_type);
        }


        $mypost = '';
        if ($automobile_dealer_name != '') {
            $qrystr .= '&automobile_dealer_name=' . $automobile_dealer_name; // using this in paging
            $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $dealer_name_id_condition . " UCASE(display_name) LIKE '%$automobile_dealer_name%'" . $alphabatic_qrystr);
            if ($post_ids) {

                $mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
                    'include' => $post_ids,
                    'meta_query' => array(
                        array(
                            'key' => 'automobile_user_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'automobile_allow_search',
                            'value' => 'yes',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'automobile_user_last_activity_date',
                            'value' => strtotime(date($automobile_dealer_activity_date_formate)),
                            'compare' => '<=',
                        ),
                        $location_condition_arr,
                    )
                );
            }
        } else {

            $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $dealer_name_id_condition . " 1=1 " . $alphabatic_qrystr);

            if ($post_ids) {

                $mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
                    'include' => $post_ids,
                    'meta_query' => array(
                        array(
                            'key' => 'automobile_user_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'automobile_allow_search',
                            'value' => 'yes',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'automobile_user_last_activity_date',
                            'value' => strtotime(date($automobile_dealer_activity_date_formate)),
                            'compare' => '<=',
                        ),
                        $location_condition_arr,
                    )
                );
            }
        }
        $loop_count = new WP_User_Query($mypost);
        $count_post = $loop_count->total_users;
        // show paging check from atributes
        if ($a['automobile_dealer_show_pagination'] == 'pagination') {
            $automobile_blog_num_post = $a['automobile_dealer_pagination']; //pick from atribute 
        } else {
            if (isset($a['automobile_dealer_pagination']) and $a['automobile_dealer_pagination'] <> '') {
                if ($a['automobile_dealer_pagination'] != 0)
                    $automobile_blog_num_post = $a['automobile_dealer_pagination'];
                else
                    $automobile_blog_num_post = "999999";
            } else {
                $automobile_blog_num_post = "999999";
            }
        }
        // result query with paging element
        $args = '';
         static $counter;
        if (!isset($counter)) {
            $counter = 1;
        } else {
            $counter ++;
        }
        $page = isset($_GET['dealer_paging_' . $counter]) ? $_GET['dealer_paging_' . $counter] : '1';
        if ($count_post > 0) {
            $total_users = $count_post;
            $automobile_var_dealer_page = 'dealer_paging_' . $counter;
            // grab the current page number and set to 1 if no page number is set
       
            // how many users to show per page
            $users_per_page = absint($automobile_blog_num_post);

            // calculate the total number of pages.
            $total_pages = 1;
            $offset = 1;

            if ($users_per_page > 0) {
                $offset = $users_per_page * ($page - 1);
            }
            if ($total_users > 0 && $users_per_page > 0) {

                $total_pages = ceil($total_users / $users_per_page);
            }

            if ($automobile_dealer_name != '') {
                $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $dealer_name_id_condition . " UCASE(display_name) LIKE '%$automobile_dealer_name%'" . $alphabatic_qrystr);
                if ($post_ids) {

                    $args = array('number' => $users_per_page, 'role' => 'automobile_dealer', 'offset' => $offset, 'order' => 'DESC', 'orderby' => 'display_name',
                        'include' => $post_ids,
                        'meta_query' => array(
                            array(
                                'key' => 'automobile_user_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_allow_search',
                                'value' => 'yes',
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_user_last_activity_date',
                                'value' => strtotime(date($automobile_dealer_activity_date_formate)),
                                'compare' => '<=',
                            ),
                            $location_condition_arr,
                        )
                    );
                }
            } else {

                $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $dealer_name_id_condition . " 1=1 " . $alphabatic_qrystr);
                if ($post_ids) {	
					$dealer_filter_sort_by	= (isset($_SESSION['dealer_filter_sort_by']))?$_SESSION['dealer_filter_sort_by']:'ASC';
                    $args = array('number' => $users_per_page, 'role' => 'automobile_dealer', 'offset' => $offset, 'order' => $dealer_filter_sort_by, 'orderby' => 'display_name',
                        'include' => $post_ids,
                        'meta_query' => array(
                            array(
                                'key' => 'automobile_user_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_allow_search',
                                'value' => 'yes',
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_user_last_activity_date',
                                'value' => strtotime(date($automobile_dealer_activity_date_formate)),
                                'compare' => '<=',
                            ),
                            $location_condition_arr,
                        )
                    );
                }
            }

            // end result query with paging
        }
        ?>
        <div class="cs-content-holder">

            <?php
            if ($a['automobile_dealer_searchbox'] == 'yes') {
                ?>
                <?php $random_id = rand(0, 9999999); ?>
                <!-- dealer type popup -->
                <div class="modal fade" id="light<?php echo esc_html($random_id); ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-body">
                                <div class="white_content">
                                    <a class="close" data-dismiss="modal">&nbsp;</a>
                                    <form action="#" method="get" id="frm_all_dealer_type<?php echo esc_html($random_id); ?>" >
                                        <?php
                                        // parse query string and create hidden fileds
                                        $final_query_str = str_replace("?", "", $qrystr);
                                        $final_query_str = automobile_remove_qrystr_extra_var($final_query_str, 'dealer_type', 'no');
                                        $query = explode('&', $final_query_str);
                                        foreach ($query as $param) {
                                            if (!empty($param)) {
                                                list($name, $value) = explode('=', $param);
                                                $new_str = $name . "=" . $value;
                                                if (is_array($name)) {
                                                    foreach ($_query_str_single_value as $_query_str_single_value_arr) {
                                                        $automobile_opt_array = array(
                                                            'id' => '',
                                                            'std' => $value,
                                                            'cust_id' => "",
                                                            'cust_name' => $name . "[]",
                                                            'classes' => '',
                                                        );
                                                        $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                                    }
                                                } else {
                                                    $automobile_opt_array = array(
                                                        'id' => '',
                                                        'std' => $value,
                                                        'cust_id' => "",
                                                        'cust_name' => $name,
                                                        'classes' => '',
                                                    );
                                                    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                                }
                                            }
                                        }
                                        ?>
                                        <ul class="custom-listing">
                                            <?php
                                            // get all inventory types
                                            $dealer_type_parent_id = 0;
                                            $input_type_dealer_type = 'radio';   // if first level then select only sigle dealer type
                                            if ($dealer_type != '') {
                                                $selected_spec = get_term_by('slug', $dealer_type[0], 'dealer_type');
                                                $dealer_type_parent_id = $selected_spec->term_id;
                                            }
                                            $dealer_type_args = array(
                                                'orderby' => 'name',
                                                'order' => 'ASC',
                                                'fields' => 'all',
                                                'slug' => '',
                                                'hide_empty' => false,
                                                'parent' => $dealer_type_parent_id,
                                            );
                                            $all_dealer_type = get_terms('dealer_type', $dealer_type_args);
                                            if (count($all_dealer_type) <= 0) {
                                                $dealer_type_args = array(
                                                    'orderby' => 'name',
                                                    'order' => 'ASC',
                                                    'fields' => 'all',
                                                    'slug' => '',
                                                    'parent' => isset($selected_spec->parent) ? $selected_spec->parent : '',
                                                );


                                                $all_dealer_type = get_terms('dealer_type', $dealer_type_args);

                                                if (isset($selected_spec->parent) && $selected_spec->parent != 0) {    // if parent is not root means not main parent
                                                    $input_type_dealer_type = 'checkbox';   // if first level then select multiple dealer type
                                                }
                                            } else {

                                                if ($dealer_type_parent_id != 0) {    // if parent is not root means not main parent
                                                    $input_type_dealer_type = 'checkbox';   // if first level then select multiple dealer type
                                                }
                                            }
                                            if ($input_type_dealer_type == 'checkbox') {
                                                $automobile_opt_array = array(
                                                    'id' => '',
                                                    'std' => '',
                                                    'cust_id' => "dealer_type_string_all",
                                                    'cust_name' => 'dealer_type_string_all',
                                                );
                                                $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                            }
                                            $random_ids = rand(0, 999999);
                                            $dealer_type_mypost = '';

                                            if ($all_dealer_type != '') {
                                                $random_ids = rand(0, 999999);
                                                foreach ($all_dealer_type as $dealer_typeitem) {
                                                    ############ get count for this itration ##########
                                                    $inventory_id_para = '';
                                                    if ($automobile_dealer_name != '') {
                                                        $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $dealer_name_id_condition . " UCASE(display_name) LIKE '%$automobile_dealer_name%'" . $alphabatic_qrystr);
                                                        if ($post_ids) {
                                                            $dealer_type_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
                                                                'include' => $post_ids,
                                                                'meta_query' => array(
                                                                    array(
                                                                        'key' => 'automobile_user_status',
                                                                        'value' => 'active',
                                                                        'compare' => '=',
                                                                    ),
                                                                    array(
                                                                        'key' => 'automobile_allow_search',
                                                                        'value' => 'yes',
                                                                        'compare' => '=',
                                                                    ),
                                                                    array(
                                                                        'key' => 'automobile_dealer_type',
                                                                        'value' => $dealer_typeitem->slug,
                                                                        'compare' => 'LIKE',
                                                                    ),
                                                                    array(
                                                                        'key' => 'automobile_user_last_activity_date',
                                                                        'value' => strtotime(date($automobile_dealer_activity_date_formate)),
                                                                        'compare' => '<=',
                                                                    ),
                                                                    $location_condition_arr,
                                                                )
                                                            );
                                                        }
                                                    } else {
                                                        $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users WHERE " . $dealer_name_id_condition . " 1=1 " . $alphabatic_qrystr);
                                                        if ($post_ids) {

                                                            $dealer_type_mypost = array('role' => 'automobile_dealer', 'order' => 'DESC', 'orderby' => 'registered',
                                                                'include' => $post_ids,
                                                                'meta_query' => array(
                                                                    array(
                                                                        'key' => 'automobile_user_status',
                                                                        'value' => 'active',
                                                                        'compare' => '=',
                                                                    ),
                                                                    array(
                                                                        'key' => 'automobile_allow_search',
                                                                        'value' => 'yes',
                                                                        'compare' => '=',
                                                                    ),
                                                                    array(
                                                                        'key' => 'automobile_dealer_type',
                                                                        'value' => $dealer_typeitem->slug,
                                                                        'compare' => 'LIKE',
                                                                    ),
                                                                    array(
                                                                        'key' => 'automobile_user_last_activity_date',
                                                                        'value' => strtotime(date($automobile_dealer_activity_date_formate)),
                                                                        'compare' => '<=',
                                                                    ),
                                                                    $location_condition_arr,
                                                                )
                                                            );
                                                        }
                                                    }

                                                    $dealer_type_loop_count = new WP_User_Query($dealer_type_mypost);
                                                    $dealer_type_count_post = $dealer_type_loop_count->total_users;
                                                    ###################################################
                                                    if ($input_type_dealer_type == 'checkbox') {
                                                        if (isset($dealer_type) && is_array($dealer_type)) {
                                                            if (in_array($dealer_typeitem->slug, $dealer_type)) {
                                                                $automobile_opt_array = array(
                                                                    'id' => '',
                                                                    'std' => $dealer_typeitem->slug,
                                                                    'cust_type' => $input_type_dealer_type,
                                                                    'cust_id' => "checklistcomplete" . $random_ids,
                                                                    'cust_name' => 'dealer_type_string_all',
                                                                    'return' => true,
                                                                    'extra_atr' => 'checked="checked" onchange="javascript:submit_specialism_form(\'frm_all_dealer_type' . $random_id . '\', \'dealer_type_string_all\');"',
                                                                );

                                                                echo '<li class="' . $input_type_dealer_type . '">' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array) . '
								<label for="checklist' . $random_ids . '">' . $dealer_typeitem->name . ' <span>(' . $dealer_type_count_post . ')</span></label></li>';
                                                            } else {
                                                                $automobile_opt_array = array(
                                                                    'id' => '',
                                                                    'std' => $dealer_typeitem->slug,
                                                                    'cust_type' => $input_type_dealer_type,
                                                                    'cust_id' => "checklistcomplete" . $random_ids,
                                                                    'cust_name' => 'dealer_type_string_all',
                                                                    'return' => true,
                                                                    'extra_atr' => 'onchange="submit_specialism_form(\'frm_all_dealer_type' . $random_id . '\', \'dealer_type_string_all\');"',
                                                                );
                                                                echo '<li class="' . $input_type_dealer_type . '">' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array) . '
								<label for="checklist' . $random_ids . '">' . $dealer_typeitem->name . '<span>(' . $dealer_type_count_post . ')</span></label></li>';
                                                            }
                                                        } else {
                                                            $automobile_opt_array = array(
                                                                'id' => '',
                                                                'std' => $dealer_typeitem->slug,
                                                                'cust_type' => $input_type_dealer_type,
                                                                'cust_id' => "checklistcomplete" . $random_ids,
                                                                'cust_name' => '',
                                                                'return' => true,
                                                                'extra_atr' => 'onchange="submit_specialism_form(\'frm_all_dealer_type' . $random_id . '\', \'dealer_type_string_all\');" ',
                                                            );


                                                            echo '<li class="' . $input_type_dealer_type . '">' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array)
                                                            . '<label for="checklist' . $random_ids . '">' . $dealer_typeitem->name . '<span>(' . $dealer_type_count_post . ')</span></label></li>';
                                                        }
                                                    } else
                                                    if ($input_type_dealer_type == 'radio') {
                                                        if (isset($dealer_type) && is_array($dealer_type)) {
                                                            if (in_array($dealer_typeitem->slug, $dealer_type)) {
                                                                $automobile_opt_array = array(
                                                                    'id' => '',
                                                                    'std' => $dealer_typeitem->slug,
                                                                    'cust_type' => $input_type_dealer_type,
                                                                    'cust_id' => "checklistcomplete" . $random_ids,
                                                                    'cust_name' => 'dealer_type',
                                                                    'return' => true,
                                                                    'extra_atr' => 'checked="checked" onchange="javascript:frm_all_dealer_type' . $random_id . '.submit();" ',
                                                                );
                                                                echo '<li class="' . $input_type_dealer_type . '">' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array) . '
							<label  class="active" for="checklistcomplete' . $random_ids . '">' . $dealer_typeitem->name . ' <span>(' . $dealer_type_count_post . ')</span>  <i class="icon-check-circle"></i></label></li>';
                                                            } else {
                                                                $automobile_opt_array = array(
                                                                    'id' => '',
                                                                    'std' => $dealer_typeitem->slug,
                                                                    'cust_type' => $input_type_dealer_type,
                                                                    'cust_id' => "checklistcomplete" . $random_ids,
                                                                    'cust_name' => 'dealer_type',
                                                                    'return' => true,
                                                                    'extra_atr' => 'onchange="javascript:frm_all_dealer_type.submit();" ',
                                                                );
                                                                echo '<li class="' . $input_type_dealer_type . '">' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array) . ''
                                                                . '<label for="checklistcomplete' . $random_ids . '">' . $dealer_typeitem->name . '<span>(' . $dealer_type_count_post . ')</span></label></li>';
                                                            }
                                                        } else {
                                                            $automobile_opt_array = array(
                                                                'id' => '',
                                                                'std' => $dealer_typeitem->slug,
                                                                'cust_type' => $input_type_dealer_type,
                                                                'cust_id' => "checklistcomplete" . $random_ids,
                                                                'cust_name' => 'dealer_type',
                                                                'return' => true,
                                                                'extra_atr' => 'onchange="javascript:frm_all_dealer_type' . $random_id . '.submit();" ',
                                                            );
                                                            echo '<li class="' . $input_type_dealer_type . '">' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array)
                                                            . '<label for="checklistcomplete' . $random_ids . '">' . $dealer_typeitem->name . '<span>(' . $dealer_type_count_post . ')</span></label></li>';
                                                        }
                                                    }
                                                    $random_ids++;
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="fade<?php echo esc_html($random_id); ?>" class="black_overlay"></div>
                <?php
            }
            ?>
        </div>
        <?php
        automobile_var::automobile_var_googlemapcluster_scripts();


        $main_col = '';
        if (isset($atts['automobile_dealer_title']) && $atts['automobile_dealer_title'] != '') {
            echo '<div class="cs-element-title"><h2>';
            echo esc_html($atts['automobile_dealer_title']);
            echo '</h2>';
            echo '</div>';
        }

        if ($a['automobile_dealer_searchbox'] == 'yes') {
            $main_col = 'col-lg-9 col-md-9 col-sm-12 col-xs-12';
            echo '<div class="row">';
            include('cs-searchbox.php');
        } else {
            $main_col = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
        }
        ?>
        <div class="section-content <?php echo automobile_allow_special_char($main_col); ?>">
            <div class="row">
                <?php
                //Dealer Map 
                if ($automobile_dealer_map == 'yes') {
                    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="cs-agent-map">';
                    include('cs-map.php');
                    echo '</div></div>';
                }
                // dealer views
                include( 'views/cs-simple.php');

                // end dealer view
                ?>
            </div>
        </div>

        <?php
        echo "</div>";
        $dealer_post_data = ob_get_clean();
        return $dealer_post_data;
    }

    add_shortcode('automobile_dealer', 'automobile_dealer_listing');
}
/*
 *
 * End Function how to show the employee listing
 *
 */