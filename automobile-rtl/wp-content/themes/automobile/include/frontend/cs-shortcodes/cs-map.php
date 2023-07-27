<?php

/*
 *
 * @Shortcode Name : Start function for Map shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_var_map_shortcode')) {

    function automobile_var_map_shortcode($atts, $content = "") {
        global $header_map, $automobile_var_form_fields, $automobile_var_html_fields, $automobile_var_options;
        $defaults = array(
            'automobile_var_column_size' => '1/1',
            'automobile_var_map_title' => '',
            'automobile_var_map_height' => '',
            'automobile_var_map_lat' => '40.7143528',
            'automobile_var_map_lon' => '-74.0059731',
            'automobile_var_map_zoom' => '11',
            'automobile_var_map_info' => '',
            'automobile_var_map_info_width' => '200',
            'automobile_var_map_info_height' => '200',
            'automobile_var_map_marker_icon' => '',
            'automobile_var_map_show_marker' => 'true',
            'automobile_var_map_controls' => '',
            'automobile_var_map_draggable' => 'true',
            'automobile_var_map_scrollwheel' => 'true',
            'automobile_var_map_border' => '',
            'automobile_var_map_border_color' => '',
            'automobile_map_style' => '',
            'automobile_map_class' => '',
            'automobile_map_directions' => 'off'
        );
        extract(shortcode_atts($defaults, $atts));
        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_var_map_title = isset($automobile_var_map_title) ? $automobile_var_map_title : '';
        $automobile_var_map_height = isset($automobile_var_map_height) ? $automobile_var_map_height : '';
        $automobile_var_map_lat = isset($automobile_var_map_lat) ? $automobile_var_map_lat : '';
        $automobile_var_map_lon = isset($automobile_var_map_lon) ? $automobile_var_map_lon : '';
        $automobile_var_map_zoom = isset($automobile_var_map_zoom) ? $automobile_var_map_zoom : '';
        $automobile_var_map_info = isset($automobile_var_map_info) ? $automobile_var_map_info : '';
        $automobile_var_map_info_width = isset($automobile_var_map_info_width) ? $automobile_var_map_info_width : '';
        $automobile_var_map_info_height = isset($automobile_var_map_info_height) ? $automobile_var_map_info_height : '';
        $automobile_var_map_marker_icon = isset($automobile_var_map_marker_icon) ? $automobile_var_map_marker_icon : '';
        $automobile_var_map_show_marker = isset($automobile_var_map_show_marker) ? $automobile_var_map_show_marker : '';
        $automobile_var_map_controls = isset($automobile_var_map_controls) ? $automobile_var_map_controls : '';
        $automobile_var_map_draggable = isset($automobile_var_map_draggable) ? $automobile_var_map_draggable : '';
        $automobile_var_map_scrollwheel = isset($automobile_var_map_scrollwheel) ? $automobile_var_map_scrollwheel : '';
        $automobile_var_map_border = isset($automobile_var_map_border) ? $automobile_var_map_border : '';
        $automobile_var_map_border_color = isset($automobile_var_map_border_color) ? $automobile_var_map_border_color : '';
        
        $automobile_var_map_style = isset($automobile_var_options['automobile_var_def_map_style']) ? $automobile_var_options['automobile_var_def_map_style'] : '';
        
        if (isset($automobile_var_map_height) && $automobile_var_map_height == '') {
            $automobile_var_map_height = '500';
        }

        $column_class = '';
        
        if ($header_map) {
            $header_map = false;
        } else {
            if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
                if (function_exists('automobile_custom_column_class')) {
                    $column_class = automobile_custom_column_class($automobile_var_column_size);
                }
            }
        }
        $section_title = '';
        if ($automobile_var_map_title && trim($automobile_var_map_title) != '') {
            $section_title = '<div class="cs-element-title"><h2>' . $automobile_var_map_title . '</h2></div>';
        }
        
        $map_dynmaic_no = rand(6548, 9999999);
        if ($automobile_var_map_show_marker == "true") {
            $automobile_var_map_show_marker = " var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '',
                        icon: '" . $automobile_var_map_marker_icon . "',
                        shadow: ''
                    });
            ";
        } else {
            $automobile_var_map_show_marker = "var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: '',
                        icon: '',
                        shadow: ''
                    });";
        }
        $border = '';
        if (isset($automobile_var_map_border) && $automobile_var_map_border == 'yes' && $automobile_var_map_border_color != '') {
            $border = 'border:1px solid ' . $automobile_var_map_border_color . '; ';
        }
        
        automobile_enqueue_google_map();
        

	$map_dynmaic_no = automobile_generate_random_string('10');
        $html = '';
        $html .= '<div ' . $automobile_map_class . ' style="animation-duration:">';
        $html .= $section_title;
        $html .= '<div class="clear"></div>';
        $html .= '<div class="cs-map-section" style="' . $border . ';">';
        $html .= '<div class="cs-map">';
        $html .= '<div class="cs-map-content">';

        $html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas' . $map_dynmaic_no . '" style="height:' . $automobile_var_map_height . 'px;"> </div>';

        if ($automobile_map_directions == 'off') {
            $html .= '<div id="cs-directions-panel"></div>';
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= "<script type='text/javascript'>
                    jQuery(document).ready(function() {
                   
		    var panorama;
                    function initialize() {
                    var myLatlng = new google.maps.LatLng(" . $automobile_var_map_lat . ", " . $automobile_var_map_lon . ");
                    var mapOptions = {
                        zoom: " . $automobile_var_map_zoom . ",
                        scrollwheel: " . $automobile_var_map_scrollwheel . ",
                        draggable: " . $automobile_var_map_draggable . ",
                        streetViewControl: false,
                        center: myLatlng,
                       
                        disableDefaultUI: " . $automobile_var_map_controls . ",
                        };";

        if ($automobile_map_directions == 'on') {
            $html .= "var directionsDisplay;
                      var directionsService = new google.maps.DirectionsService();
                      directionsDisplay = new google.maps.DirectionsRenderer();";
        }

        $html .= "var map = new google.maps.Map(document.getElementById('map_canvas" . $map_dynmaic_no . "'), mapOptions);";

        if ($automobile_map_directions == 'on') {
            $html .= "directionsDisplay.setMap(map);
                        directionsDisplay.setPanel(document.getElementById('cs-directions-panel'));

                        function automobile_calc_route() {
                                var myLatlng = new google.maps.LatLng(" . $automobile_var_map_lat . ", " . $automobile_var_map_lon . ");
                                var start = myLatlng;
                                var end = document.getElementById('automobile_end_direction').value;
                                var mode = document.getElementById('automobile_chng_dir_mode').value;
                                var request = {
                                        origin:start,
                                        destination:end,
                                        travelMode: google.maps.TravelMode[mode]
                                };
                                directionsService.route(request, function(response, status) {
                                        if (status == google.maps.DirectionsStatus.OK) {
                                                directionsDisplay.setDirections(response);
                                        }
                                });
                        }
                        document.getElementById('automobile_search_direction').addEventListener('click', function() {
                                automobile_calc_route();
                        });";
        }

        $html .= "
                        var style = '".$automobile_var_map_style."';
                        if (style != '') {
                            var styles = automobile_map_select_style(style);
                            if (styles != '') {
                                var styledMap = new google.maps.StyledMapType(styles,
                                        {name: 'Styled Map'});
                                map.mapTypes.set('map_style', styledMap);
                                map.setMapTypeId('map_style');
                            }
                        }
                        var infowindow = new google.maps.InfoWindow({
                            content: '" . $automobile_var_map_info . "',
                            maxWidth: " . $automobile_var_map_info_width . ",
                            maxHeight: " . $automobile_var_map_info_height . ",
                            
                        });
                        " . $automobile_var_map_show_marker . "
                            if (infowindow.content != ''){
                              infowindow.open(map, marker);
                               map.panBy(1,-60);
                               google.maps.event.addListener(marker, 'click', function(event) {
                                infowindow.open(map, marker);
                               });
                            }
                            panorama = map.getStreetView();
                            panorama.setPosition(myLatlng);
                            panorama.setPov(({
                              heading: 265,
                              pitch: 0
                            }));
                    }			
                        function automobile_toggle_street_view(btn) {
                          var toggle = panorama.getVisible();
                          if (toggle == false) {
                                if(btn == 'streetview'){
                                  panorama.setVisible(true);
                                }
                          } else {
                                if(btn == 'mapview'){
                                  panorama.setVisible(false);
                                }
                          }
                        }
                google.maps.event.addDomListener(window, 'load', initialize);
                });
                </script>";

        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}

if (function_exists('automobile_var_short_code')) {
    automobile_var_short_code('automobile_map', 'automobile_var_map_shortcode');
}