<?php
/**
 * File Type: Inventory listing Shortcode
 * 
 * Start Function how to create listing of Inventory
 *
 */
if ( ! function_exists( 'automobile_inventories_listing' ) ) {

    function automobile_inventories_listing( $atts, $content = "" ) {



        global $automobile_var_plugin_core, $a, $args, $count_post, $automobile_blog_num_post, $wpdb, $automobile_var_plugin_options, $automobile_html_fields, $automobile_form_fields, $inventory_sort_by, $inventory_filter_page_size;
        $automobile_rand_num = rand( 10000000, 99999999 );
        $a = shortcode_atts( array(
            'automobile_inventory_title' => '',
            'automobile_inventory_sub_title' => '',
            'automobile_inventory_show_pagination' => 'pagination', // yes or no
            'automobile_inventory_pagination' => '10', // as per your requirement only numbers(0-9)
            'automobile_inventory_searchbox' => 'yes', // yes or no
            'automobile_inventory_filterable' => 'yes', // yes or no
            'automobile_inventory_top_search' => '',
            'automobile_inventory_view' => 'classic', // simplelist, featured or detaillist
            'automobile_inventory_type' => '',
            'automobile_inventory_make' => '',
            'automobile_inventory_num_results' => '',
            'automobile_inventory_result_type' => 'all', // all, featured
            'automobile_inventory_sub_title' => '', // sub title
            'automobile_inventories_counter' => '',
                ), $atts
        );
        extract( $a );

        $automobile_invets_data = '';
//        $automobile_invets_data = '<div class="cs-inventories-listing-loader"></div>';
//
        $automobile_invets_data .= '
        <script type="text/javascript">
            var inv_atts_data_' . absint( $automobile_rand_num ) . ' = \'' . json_encode( str_replace( array( '&' ), array( '[AND]' ), $a ) ) . '\';
        </script>';

        if ( $automobile_inventory_title <> '' ) {
            $automobile_invets_data .= '<div class="cs-element-title">';
            $automobile_invets_data .= '<h2>' . esc_html( $automobile_inventory_title ) . '</h2>';
            $automobile_invets_data .= '</div>';
        }

        $automobile_invets_data .= '<input type="hidden" class="page_url" value="' . get_permalink() . '"><form class="searchform" method="get" data-ajaxurl="' . esc_js( admin_url( 'admin-ajax.php' ) ) . '">';
        if ( isset( $_GET ) ) {
            foreach ( $_GET as $key => $value ) {
                if ( is_array( $value ) ) {
                    foreach ( $value as $val ) {
                        $automobile_invets_data .= '<input type="hidden" name="' . $key . '[]" value="' . $val . '">';
                    }
                } else {
                    $automobile_invets_data .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
                }
            }
        }

        $automobile_invets_data .= '</form>';
if($automobile_inventory_view == 'slider'){
	$add_unique_class = '-silder';
}else{
	$add_unique_class ='';
}
        $automobile_invets_data .= '<div class="cs-inventories-elem-data'.$add_unique_class.'" data-inv-atts="inv_atts_data_' . absint( $automobile_rand_num ) . '">';
        $automobile_invets_data .= automobile_inventories_listing_inner( $a );
        $automobile_invets_data .= '</div>';

        return do_shortcode( $automobile_invets_data );
    }

    add_shortcode( 'automobile_inventories', 'automobile_inventories_listing' );
}

if ( ! function_exists( 'automobile_inventories_listing_inner' ) ) {

    function automobile_inventories_listing_inner( $a ) {
        global $automobile_var_plugin_core, $a, $args, $count_post, $automobile_blog_num_post, $wpdb, $automobile_var_plugin_options, $automobile_html_fields, $automobile_form_fields, $inventory_sort_by, $inventory_filter_page_size;

        if ( isset( $_REQUEST['automobile_inv_elem_atts'] ) ) {
            $automobile_inv_atts_data = $_REQUEST['automobile_inv_elem_atts'];
            $automobile_inv_atts_data = json_decode( stripslashes( $automobile_inv_atts_data ), true );
            $automobile_inv_atts_data = str_replace( array( '[AND]' ), array( '&' ), $automobile_inv_atts_data );
            $a = $automobile_inv_atts_data;
        }

         ob_start();
        $automobile_html='';
        ?>
        <!-- alert for complete theme -->
        <div class="automobile_alerts" ></div>

        <?php
        // sorting filters
        $inventory_sort_by = 'recent';    // default value
        $inventory_sort_order = 'desc';   // default value
        $inventory_filter_page_size = '';
        if ( $a['automobile_inventory_view'] == 'slider' && $a['automobile_inventory_num_results'] > 0 ) {
            $automobile_blog_num_post = $a['automobile_inventory_num_results'];
        } else if ( $a['automobile_inventory_show_pagination'] == 'pagination' ) {
            $automobile_blog_num_post = $a['automobile_inventory_pagination']; //pick from atribute 
        } else {
            if ( isset( $a['automobile_inventory_pagination'] ) and $a['automobile_inventory_pagination'] <> '' ) {
                if ( $a['automobile_inventory_pagination'] != 0 )
                    $automobile_blog_num_post = $a['automobile_inventory_pagination'];
                else
                    $automobile_blog_num_post = "10";
            } else {
                $automobile_blog_num_post = "10";
            }
        }
        

        $qryvar_sort_by_column = 'post_date';
        $qryvar_inventory_sort_type = 'DESC';
        $inventory_filter_page_size = $automobile_blog_num_post;  // default value for paging
        if ( $a['automobile_inventory_show_pagination'] == "pagination" ) {

            if ( isset( $_SESSION['inventory_filter_sort_by'] ) && $_SESSION['inventory_filter_sort_by'] != '' ) {
                $inventory_sort_by = $_SESSION['inventory_filter_sort_by'];
            }
            if ( isset( $_SESSION['inventory_filter_page_size'] ) && $_SESSION['inventory_filter_page_size'] != '' ) {
                $automobile_blog_num_post = $_SESSION['inventory_filter_page_size'];
                $inventory_filter_page_size = $automobile_blog_num_post;
            }
        }
        if ( $inventory_sort_by == 'recent' ) {
            $qryvar_inventory_sort_type = 'DESC';
            $qryvar_sort_by_column = 'post_date';
        } elseif ( $inventory_sort_by == 'alphabetical' ) {
            $qryvar_inventory_sort_type = 'ASC';
            $qryvar_sort_by_column = 'post_title';
        } elseif ( $inventory_sort_by == 'featured' ) {
            $qryvar_inventory_sort_type = 'DESC';
            $qryvar_sort_by_column = 'automobile_inventory_featured';
        }
        // getting all record of dealer for paging
        if ( empty( $_REQUEST['page_inventory'] ) )
            $_REQUEST['page_inventory'] = 1;
        $qrystr = ''; //?';
        ############ filtration proccess ############
        $filter_arr = '';
        $radius_array = '';
        // check featured on or off
        if ( $a['automobile_inventory_result_type'] == 'featured' ) {
            $filter_arr[] = array(
                'key' => 'automobile_inventory_featured',
                'value' => 'yes',
                'compare' => '=',
            );
        }
        $posted = '';
        $inventory_title = '';
        $location = '';
        $inventory_type = '';
        $inventory_make = '';
        $default_date_time_formate = 'd-m-Y H:i:s';
        $automobile_inventory_posted_date_formate = 'd-m-Y H:i:s';
        $automobile_inventory_expired_date_formate = 'd-m-Y H:i:s';
        if ( isset( $_REQUEST['inventory_title'] ) ) {
            $inventory_title = $_REQUEST['inventory_title'];
            $inventory_title = str_replace( "+", " ", $inventory_title );
        }
        if ( isset( $_REQUEST['location'] ) ) {
            $location = $_REQUEST['location'];
        }
        if ( isset( $_REQUEST['posted'] ) ) {
            $posted = $_REQUEST['posted'];
        }
        if ( isset( $_REQUEST['inventory_type'] ) ) {
            $inventory_type = $_REQUEST['inventory_type'];
        } else {
            if ( isset( $automobile_var_plugin_options['automobile_default_inventory_type'] ) ) {
                $inventory_type = ($inventory_type != '') ? $inventory_type : $automobile_var_plugin_options['automobile_default_inventory_type'];
            }
        }
        if ( isset( $_REQUEST['price'] ) ) {
            $inventory_new_price = $_REQUEST['price'];
        }
        if ( $a['automobile_inventory_view'] == 'slider' && $a['automobile_inventory_type'] != '' ) {
            $inventory_type = $a['automobile_inventory_type'];
        }
        if ( isset( $_REQUEST['inventory_make'] ) ) {
            $inventory_make = $_REQUEST['inventory_make'];
        }
        if ( $a['automobile_inventory_view'] == 'slider' && $a['automobile_inventory_make'] != '' ) {
            $inventory_make = $a['automobile_inventory_make'];
        }
        $cus_fields_count_arr = array();
        $location_condition_arr = array();
        global $wp_filesystem;
        if ( empty( $wp_filesystem ) ) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }
        // location check
        if ( $location != '' && $a['automobile_inventory_view'] != 'slider' ) {
            $automobile_radius_switch = isset( $automobile_var_plugin_options['automobile_radius_switch'] ) ? $automobile_var_plugin_options['automobile_radius_switch'] : '';
            if ( isset( $_REQUEST['radius'] ) && $_REQUEST['radius'] > 0 && $automobile_radius_switch == 'on' ) {
                $automobile_radius = $_REQUEST['radius'];
                $automobile_radius_measure = isset( $automobile_var_plugin_options['automobile_radius_measure'] ) ? $automobile_var_plugin_options['automobile_radius_measure'] : '';
                $distance_km_miles = $automobile_radius_measure;
                $qrystr .= '&radius=' . $automobile_radius;  // added again this var in query string for linking again
                $automobile_radius = preg_replace( "/[^0-9,.]/", "", $automobile_radius );
                if ( $distance_km_miles == 'km' ) {
                    if ( isset( $_REQUEST['radius'] ) ) {
                        $automobile_radius = $automobile_radius * 0.621371; // for km
                    }
                }

                $Latitude = '';
                $Longitude = '';
                $prepAddr = '';
                $minLat = '';
                $maxLat = '';
                $minLong = '';
                $maxLong = '';

                if ( isset( $_REQUEST['location'] ) && ! empty( $_REQUEST['location'] ) ) {
                    $address = sanitize_text_field( $_REQUEST['location'] );
                    $prepAddr = str_replace( ' ', '+', $address );
                    $google_api = isset( $automobile_var_plugin_options['automobile_google_api_key'] )? $automobile_var_plugin_options['automobile_google_api_key'] : '';
                    $geocode = $wp_filesystem->get_contents( automobile_server_protocol() . 'google.com/maps/api/geocode/json?key='.$google_api.'&address=' . $prepAddr . '&sensor=false' );
                    $output = json_decode( $geocode );
                    $Latitude = isset( $output->results[0] )? $output->results[0]->geometry->location->lat : '';
                    $Longitude = isset( $output->results[0] )? $output->results[0]->geometry->location->lng : '';
                    if ( isset( $Latitude ) && $Latitude <> '' && isset( $Longitude ) && $Longitude <> '' ) {
                        $zcdRadius = new RadiusCheck( $Latitude, $Longitude, $automobile_radius );
                        $minLat = $zcdRadius->MinLatitude();
                        $maxLat = $zcdRadius->MaxLatitude();
                        $minLong = $zcdRadius->MinLongitude();
                        $maxLong = $zcdRadius->MaxLongitude();
                    }
                }

                $automobile_compare_type = 'DECIMAL(10,6)';
                if ( $automobile_radius > 50 ) {
                    $automobile_compare_type = 'DECIMAL';
                }

                if ( $minLat != '' && $maxLat != '' && $minLong != '' && $maxLong != '' ) {

                    $radius_array = array(
                        'relation' => 'AND',
                        array(
                            'key' => 'automobile_post_loc_latitude',
                            'value' => array( $minLat, $maxLat ),
                            'compare' => 'BETWEEN',
                            'type' => $automobile_compare_type
                        ),
                        array(
                            'key' => 'automobile_post_loc_longitude',
                            'value' => array( $minLong, $maxLong ),
                            'compare' => 'BETWEEN',
                            'type' => $automobile_compare_type
                        ),
                    );
                }
            }
            $qrystr .= '&location=' . $location;
            $automobile_location_type = isset( $automobile_var_plugin_options['automobile_search_by_location'] ) ? $automobile_var_plugin_options['automobile_search_by_location'] : '';
            if ( $automobile_location_type == 'countries_and_cities' || $automobile_location_type == 'countries_only' ) {
                if ( isset( $radius_array ) && is_array( $radius_array ) ) {
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
                                'key' => 'automobile_post_loc_address',
                                'value' => $location,
                                'compare' => 'LIKE',
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
                                'key' => 'automobile_post_loc_address',
                                'value' => $location,
                                'compare' => 'LIKE',
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
                            'key' => 'automobile_post_loc_address',
                            'value' => $location,
                            'compare' => 'LIKE',
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
                        'key' => 'automobile_post_loc_address',
                        'value' => $location,
                        'compare' => 'LIKE',
                    );
                    $cus_fields_count_arr['location'][] = array(
                        'key' => 'automobile_post_loc_country',
                        'value' => $location,
                        'compare' => '=',
                    );
                }
            } elseif ( $automobile_location_type == 'cities_only' || $automobile_location_type == 'single_city' ) {

                if ( isset( $radius_array ) && is_array( $radius_array ) ) {
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
                                'key' => 'automobile_post_loc_address',
                                'value' => $location,
                                'compare' => 'LIKE',
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
                                'key' => 'automobile_post_loc_address',
                                'value' => $location,
                                'compare' => 'LIKE',
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
                    $location_condition_arr[] = array(
                        'key' => 'automobile_post_loc_address',
                        'value' => $location,
                        'compare' => 'LIKE',
                    );

                    // for count query
                    $cus_fields_count_arr['location'][] = array(
                        'key' => 'automobile_post_loc_city',
                        'value' => $location,
                        'compare' => '=',
                    );
                    $cus_fields_count_arr['location'][] = array(
                        'key' => 'automobile_post_loc_address',
                        'value' => $location,
                        'compare' => 'LIKE',
                    );
                }
            }
        }

        $filter_arr_inv_make = '';
        if ( $inventory_make != '' ) {

            $filter_arr_inv_make = array(
                'taxonomy' => 'inventory-make',
                'field' => 'slug',
                'terms' => $inventory_make
            );
        }

        $filter_arr_inv_models = '';

        if ( isset( $_REQUEST['inventory_model'] ) && isset( $_SERVER["QUERY_STRING"] ) ) {

            $automobile_filter_query_boxes = array();
            $automobile_query_string = $_SERVER["QUERY_STRING"];
            $automobile_query_string = explode( '&', $automobile_query_string );

            if ( ! empty( $automobile_query_string ) ) {

                if ( count( array_filter( $automobile_query_string ) ) > 0 ) {
                    foreach ( $automobile_query_string as $q_str ) {
                        if ( strpos( $q_str, 'inventory_model' ) !== false ) {
                            $automobile_filter_query_boxes[] = str_replace( array( 'inventory_model=' ), array( '' ), $q_str );
                        }
                    }
                } else {
                    if ( isset( $_REQUEST['inventory_model'] ) ) {
                        $automobile_filter_query_boxes[] = str_replace( array( 'inventory_model=' ), array( '' ), 'inventory_model=' . $_REQUEST['inventory_model'] );
                    }
                }
            }
            if ( sizeof( $automobile_filter_query_boxes ) > 0 ) {
                $filter_arr_inv_models = array(
                    'taxonomy' => 'inventory-model',
                    'field' => 'slug',
                    'terms' => $automobile_filter_query_boxes
                );
            }
        }


        $filter_arr_inv_type = '';
        if ( $inventory_type != '' ) {
            $filter_arr_inv_type = array(
                'key' => 'automobile_inventory_type',
                'value' => $inventory_type,
                'compare' => '=',
            );
        }

        $filter_arr_inv_price = '';


        if ( isset( $inventory_new_price ) != '' ) {

            $automobile_price_range = explode( ",", $inventory_new_price );

            $filter_arr_inv_price = array(
                'key' => 'automobile_inventory_new_price',
                'value' => array( preg_replace( '/\D/', '', $automobile_price_range[0] ), preg_replace( '/\D/', '', $automobile_price_range[1] ) ),
                'compare' => 'BETWEEN',
                'type' => 'DECIMAL(10,3)',
            );
        }

        if ( $a['automobile_inventory_view'] != 'slider' ) {
            $inventory_type_post = get_posts( array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$inventory_type", 'post_status' => 'publish' ) );
            $inventory_type_id = isset( $inventory_type_post[0]->ID ) ? $inventory_type_post[0]->ID : 0;
            $automobile_inventory_cus_fields = get_post_meta( $inventory_type_id, "automobile_inventory_type_cus_fields", true );

            if ( is_array( $automobile_inventory_cus_fields ) && sizeof( $automobile_inventory_cus_fields ) > 0 ) {
                foreach ( $automobile_inventory_cus_fields as $cus_field ) {
                    if ( isset( $cus_field['enable_srch'] ) && $cus_field['enable_srch'] == 'yes' ) {
                        $query_str_var_name = $cus_field['meta_key'];
                        if ( isset( $_REQUEST[$query_str_var_name] ) && $_REQUEST[$query_str_var_name] != '' ) {
                            if ( ! isset( $cus_field['multi'] ) || $cus_field['multi'] != 'yes' ) {
                                $qrystr .= '&' . $query_str_var_name . '=' . $_REQUEST[$query_str_var_name];
                            }
                            if ( $cus_field['type'] == 'dropdown' ) {
                                if ( isset( $cus_field['multi'] ) && $cus_field['multi'] == 'yes' ) {
                                    $_query_string_arr = getMultipleParameters();
                                    $filter_multi_arr = ['relation' => 'OR', ];
                                    if ( is_array( $_REQUEST[$query_str_var_name] ) ) {
                                        foreach ( $_REQUEST[$query_str_var_name] as $query_str_var_name_key ) {
                                            if ( $cus_field['post_multi'] == 'yes' ) {
                                                $filter_multi_arr[] = array(
                                                    'key' => $query_str_var_name,
                                                    'value' => serialize( $query_str_var_name_key ),
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
                                    } else {
                                        if ( $cus_field['post_multi'] == 'yes' ) {
                                            $filter_multi_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => serialize( $_REQUEST[$query_str_var_name] ),
                                                'compare' => 'Like',
                                            );
                                        } else {
                                            $filter_multi_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => $_REQUEST[$query_str_var_name],
                                                'compare' => '=',
                                            );
                                        }
                                        $qrystr .= '&' . $query_str_var_name . '=' . $_REQUEST[$query_str_var_name];
                                    }
                                    $filter_arr[] = array(
                                        $filter_multi_arr
                                    );
                                    // for count query
                                    $cus_fields_count_arr[$query_str_var_name][] = array(
                                        $filter_multi_arr
                                    );
                                } else {
                                    if ( $cus_field['post_multi'] == 'yes' ) {

                                        $filter_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => serialize( $_REQUEST[$query_str_var_name] ),
                                            'compare' => 'Like',
                                        );
                                        // for count query
                                        $cus_fields_count_arr[$query_str_var_name][] = array(
                                            'key' => $query_str_var_name,
                                            'value' => serialize( $_REQUEST[$query_str_var_name] ),
                                            'compare' => 'Like',
                                        );
                                    } else {
                                        $filter_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => $_REQUEST[$query_str_var_name],
                                            'compare' => '=',
                                        );
                                        // for count query
                                        $cus_fields_count_arr[$query_str_var_name][] = array(
                                            'key' => $query_str_var_name,
                                            'value' => $_REQUEST[$query_str_var_name],
                                            'compare' => '=',
                                        );
                                    }
                                }
                            } else if ( $cus_field['type'] == 'text' || $cus_field['type'] == 'email' || $cus_field['type'] == 'url' ) {
                                $filter_arr[] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $_REQUEST[$query_str_var_name],
                                    'compare' => 'LIKE',
                                );
                                // for count query
                                $cus_fields_count_arr[$query_str_var_name][] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $_REQUEST[$query_str_var_name],
                                    'compare' => 'LIKE',
                                );
                            } else if ( $cus_field['type'] == 'range' ) {
                                $ranges_str_arr = explode( ",", $_REQUEST[$query_str_var_name] );
                                $range_first = $ranges_str_arr[0];
                                $range_seond = $ranges_str_arr[1];
                                $automobile_range_compare_type = 'numeric';

                                $filter_arr[] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $range_first,
                                    'compare' => '>=',
                                    'type' => $automobile_range_compare_type
                                );

                                $filter_arr[] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $range_seond,
                                    'compare' => '<=',
                                    'type' => $automobile_range_compare_type
                                );

                                // for count query
                                $cus_fields_count_arr[$query_str_var_name][] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $range_first,
                                    'compare' => '>=',
                                    'type' => $automobile_range_compare_type
                                );
                                // for count query
                                $cus_fields_count_arr[$query_str_var_name][] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $range_seond,
                                    'compare' => '<=',
                                    'type' => $automobile_range_compare_type
                                );
                            } else if ( $cus_field['type'] == 'date' ) {
                                $filter_arr[] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $_REQUEST[$query_str_var_name],
                                    'compare' => 'LIKE',
                                );
                                $cus_fields_count_arr[$query_str_var_name][] = array(
                                    'key' => $query_str_var_name,
                                    'value' => $_REQUEST[$query_str_var_name],
                                    'compare' => 'LIKE',
                                );
                            }
                        }
                    }
                }
            }
            $meta_post_ids_arr = '';
            $inventory_title_id_condition = '';

            if ( isset( $filter_arr ) && ! empty( $filter_arr ) ) {
                $meta_post_ids_arr = automobile_get_query_whereclase_by_array( $filter_arr );
                // if no result found in filtration 
                if ( empty( $meta_post_ids_arr ) ) {
                    $meta_post_ids_arr = array( 0 );
                }
                $ids = $meta_post_ids_arr != '' ? implode( ",", $meta_post_ids_arr ) : '0';
                $inventory_title_id_condition = " ID in (" . $ids . ") AND ";
            }
        } else {
            $meta_post_ids_arr = '';
        }
        ############ end filtration proccess ############

        $inventories_postqry = '';
        if ( $inventory_title != '' ) {
            $qrystr .= '&inventory_title=' . $inventory_title;  // added again this var in query string for linking again
            $post_ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE " . $inventory_title_id_condition . " UCASE(post_title) LIKE '%$inventory_title%' OR UCASE(post_content) LIKE '%$inventory_title%'  AND post_type='inventories' AND post_status='publish'" );
            if ( $post_ids ) {

                $inventories_postqry = array( 'posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column,
                    'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                    'post__in' => $post_ids,
                    'tax_query' => array(
                        'relation' => 'AND',
                        $filter_arr_inv_make,
                        $filter_arr_inv_models,
                    ),
                    'meta_query' => array(
                        $filter_arr_inv_type,
                        $filter_arr_inv_price,
                        array(
                            'key' => 'automobile_inventory_posted',
                            'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                            'compare' => '<=',
                        ),
                        array(
                            'key' => 'automobile_inventory_expired',
                            'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                            'compare' => '>=',
                        ),
                        array(
                            'key' => 'automobile_inventory_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                        $location_condition_arr,
                    ),
                );
            }
        } else {
            $inventories_postqry = array( 'posts_per_page' => "-1", 'post_type' => 'inventory', 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column,
                'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                'post__in' => $meta_post_ids_arr,
                'tax_query' => array(
                    'relation' => 'AND',
                    $filter_arr_inv_make,
                    $filter_arr_inv_models,
                ),
                'meta_query' => array(
                    $filter_arr_inv_type,
                    $filter_arr_inv_price,
                    array(
                        'key' => 'automobile_inventory_posted',
                        'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                        'compare' => '<=',
                    ),
                    array(
                        'key' => 'automobile_inventory_expired',
                        'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                        'compare' => '>=',
                    ),
                    array(
                        'key' => 'automobile_inventory_status',
                        'value' => 'active',
                        'compare' => '=',
                    ),
                    $location_condition_arr,
                ),
            );
        }

        $loop_count = new WP_Query( $inventories_postqry );

        $count_post = $loop_count->post_count;
        // getting inventory with page number
        if ( $qryvar_sort_by_column == 'automobile_inventory_featured' ) {
            $qryvar_sort_by_column = 'meta_value';

            if ( $inventory_title != '' ) {
                $post_ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE " . $inventory_title_id_condition . " UCASE(post_title) LIKE '%$inventory_title%' OR UCASE(post_content) LIKE '%$inventory_title%'   AND post_type='inventories' AND post_status='publish'" );
                if ( $post_ids ) {
                    $args = array( 'posts_per_page' => "$automobile_blog_num_post", 'post_type' => 'inventory', 'paged' => $_REQUEST['page_inventory'], 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column, 'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'post__in' => $post_ids,
                        'tax_query' => array(
                            'relation' => 'AND',
                            $filter_arr_inv_make,
                            $filter_arr_inv_models,
                        ),
                        'meta_query' => array(
                            $filter_arr_inv_type,
                            $filter_arr_inv_price,
                            array(
                                'key' => 'automobile_inventory_featured',
                                'value' => 'yes',
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_inventory_posted',
                                'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                                'compare' => '<=',
                            ),
                            array(
                                'key' => 'automobile_inventory_expired',
                                'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                                'compare' => '>=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                            $location_condition_arr,
                        ),
                            // $feature_order
                    );
                }
            } else {
                $args = array( 'posts_per_page' => "$automobile_blog_num_post", 'post_type' => 'inventory', 'paged' => $_REQUEST['page_inventory'], 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column, 'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                    'tax_query' => array(
                        'relation' => 'AND',
                        $filter_arr_inv_make,
                        $filter_arr_inv_models,
                    ),
                    'meta_query' => array(
                        $filter_arr_inv_type,
                        $filter_arr_inv_price,
                        array(
                            'key' => 'automobile_inventory_featured',
                            'value' => 'yes',
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'automobile_inventory_posted',
                            'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                            'compare' => '<=',
                        ),
                        array(
                            'key' => 'automobile_inventory_expired',
                            'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                            'compare' => '>=',
                        ),
                        array(
                            'key' => 'automobile_inventory_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                        $location_condition_arr,
                    ),
                        // $feature_order
                );
            }
        } elseif ( $qryvar_sort_by_column == 'post_date' ) {
            $qryvar_sort_by_column = 'meta_value_num';

            if ( $inventory_title != '' ) {
                $post_ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE " . $inventory_title_id_condition . " UCASE(post_title) LIKE '%$inventory_title%' OR UCASE(post_content) LIKE '%$inventory_title%'   AND post_type='inventories' AND post_status='publish'" );
                if ( $post_ids ) {
                    $args = array( 'posts_per_page' => "$automobile_blog_num_post", 'post_type' => 'inventory', 'paged' => $_REQUEST['page_inventory'], 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column, 'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'post__in' => $post_ids,
                        'meta_key' => 'automobile_inventory_posted',
                        'tax_query' => array(
                            'relation' => 'AND',
                            $filter_arr_inv_make,
                            $filter_arr_inv_models,
                        ),
                        'meta_query' => array(
                            $filter_arr_inv_type,
                            $filter_arr_inv_price,
                            array(
                                'key' => 'automobile_inventory_posted',
                                'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                                'compare' => '<=',
                            ),
                            array(
                                'key' => 'automobile_inventory_expired',
                                'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                                'compare' => '>=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                            $location_condition_arr,
                        ),
                    );
                }
            } else {
                $args = array( 'posts_per_page' => "$automobile_blog_num_post", 'post_type' => 'inventory', 'paged' => $_REQUEST['page_inventory'], 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column, 'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                    'meta_key' => 'automobile_inventory_posted',
                    'post__in' => $meta_post_ids_arr,
                    'tax_query' => array(
                        'relation' => 'AND',
                        $filter_arr_inv_make,
                        $filter_arr_inv_models,
                    ),
                    'meta_query' => array(
                        $filter_arr_inv_type,
                        $filter_arr_inv_price,
                        array(
                            'key' => 'automobile_inventory_posted',
                            'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                            'compare' => '<=',
                        ),
                        array(
                            'key' => 'automobile_inventory_expired',
                            'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                            'compare' => '>=',
                        ),
                        array(
                            'key' => 'automobile_inventory_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                        $location_condition_arr,
                    ),
                );
            }
        } else {
            if ( $inventory_title != '' ) {
                $post_ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE " . $inventory_title_id_condition . " UCASE(post_title) LIKE '%$inventory_title%' OR UCASE(post_content) LIKE '%$inventory_title%'   AND post_type='inventories' AND post_status='publish'" );
                if ( $post_ids ) {
                    $args = array( 'posts_per_page' => "$automobile_blog_num_post", 'post_type' => 'inventory', 'paged' => $_REQUEST['page_inventory'], 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column, 'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'post__in' => $post_ids,
                        'tax_query' => array(
                            'relation' => 'AND',
                            $filter_arr_inv_make,
                            $filter_arr_inv_models,
                        ),
                        'meta_query' => array(
                            $filter_arr_inv_type,
                            $filter_arr_inv_price,
                            array(
                                'key' => 'automobile_inventory_posted',
                                'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                                'compare' => '<=',
                            ),
                            array(
                                'key' => 'automobile_inventory_expired',
                                'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                                'compare' => '>=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'active',
                                'compare' => '=',
                            ),
                            $location_condition_arr,
                        ),
                    );
                }
            } else {
                $args = array( 'posts_per_page' => "$automobile_blog_num_post", 'post_type' => 'inventory', 'paged' => $_REQUEST['page_inventory'], 'order' => $qryvar_inventory_sort_type, 'orderby' => $qryvar_sort_by_column, 'post_status' => 'publish', 'ignore_sticky_posts' => 1,
                    'post__in' => $meta_post_ids_arr,
                    'tax_query' => array(
                        'relation' => 'AND',
                        $filter_arr_inv_make,
                        $filter_arr_inv_models,
                    ),
                    'meta_query' => array(
                        $filter_arr_inv_type,
                        $filter_arr_inv_price,
                        array(
                            'key' => 'automobile_inventory_posted',
                            'value' => strtotime( date( $automobile_inventory_posted_date_formate ) ),
                            'compare' => '<=',
                        ),
                        array(
                            'key' => 'automobile_inventory_expired',
                            'value' => strtotime( date( $automobile_inventory_expired_date_formate ) ),
                            'compare' => '>=',
                        ),
                        array(
                            'key' => 'automobile_inventory_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                        $location_condition_arr,
                    ),
                );
            }
        }

        $random_id = rand( 11111110, 99999999 );
        $number_option = rand( 11111110, 99999999 );
        $rand_id = rand( 122220, 999999 );
        global $inventory_random_id;
        $inventory_random_id = $rand_id;
        ?>
        <div id="fade<?php echo esc_html( $rand_id ); ?>" class="black_overlay"></div>
        <!-- end popup -->

        <div class="row cs-inventories-main-box" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ) ?>" data-counter="<?php echo (isset( $a['automobile_inventories_counter'] ) ? $a['automobile_inventories_counter'] : '') ?>">
        <?php
        if ( $a['automobile_inventory_searchbox'] == 'yes' && $a['automobile_inventory_view'] != 'slider' ) {
            include('cs-searchbox.php');
        }

        if ( $a['automobile_inventory_view'] == 'slider' ) {
            $automobile_var_plugin_core->automobile_var_get_template_part( 'cs', 'slider', 'inventories-views' );
        } else {
            $automobile_var_plugin_core->automobile_var_get_template_part( 'cs', 'view', 'inventories-views' );
        }

        // end inventory views
        ?>               
        </div>
            <?php
            $automobile_html .= ob_get_clean();
            //$automobile_html = ob_get_flush();

            if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'automobile_inventories_elem_view' ) {
                echo json_encode( array( 'mark' => $automobile_html ) );
                //die;
            } else {
                return $automobile_html;
            }
            die();
        }

        add_action( 'wp_ajax_automobile_inventories_elem_view', 'automobile_inventories_listing_inner' );
        add_action( 'wp_ajax_nopriv_automobile_inventories_elem_view', 'automobile_inventories_listing_inner' );
    }