<?php

/*
 *
 * @Shortcode Name :   Start function for Clients shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_clients_shortcode')) {

    function automobile_clients_shortcode($atts, $content = null) {
        global $automobile_var_blog_variables, $clients_style, $item_counter, $automobile_var_clients_text, $post, $clients_section_title;


        $randomid = rand(1234, 7894563);
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_clients_perslide' => '5',
            'clients_style' => '',
            'automobile_var_clients_text' => '',
            'automobile_clients_text_align' => '',
            'automobile_var_clients_element_title' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $item_counter = 1;
        $automobile_var_clients = '';
        $automobile_var_clients_element_title = isset($automobile_var_clients_element_title) ? $automobile_var_clients_element_title : '';
        $automobile_var_clients_perslide = isset($automobile_var_clients_perslide) ? $automobile_var_clients_perslide : '';

        $clients_style = isset($clients_style) ? $clients_style : '';
        $automobile_var_clients_text = isset($automobile_var_clients_text) ? $automobile_var_clients_text : '';


        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }
        if (function_exists('automobile_enqueue_slick_script')) {
            automobile_enqueue_slick_script();
        }
        if (isset($column_class) && $column_class <> '') {

            $automobile_var_clients .= '<div class="' . esc_html($column_class) . '">';
        }

        if ($automobile_var_clients_element_title <> '') {
            $automobile_var_clients .= '<div class="cs-element-title"><h2>' . esc_html($automobile_var_clients_element_title) . '</h2></div>';
        }

        $automobile_var_clients .='<ul class="cs-partners-slider classic" id="client-slider' . absint($randomid) . '">';
        $automobile_var_clients .= do_shortcode($content);
        $automobile_var_clients .='</ul>';


        if (isset($column_class) && $column_class <> '') {
            $automobile_var_clients .= '</div>';
        }
        echo '<script>
     jQuery(document).ready(function () {
                 
            jQuery("#client-slider' . $randomid . '").slick({
                infinite: true,
                slidesToShow: ' . $automobile_var_clients_perslide . ',
                slidesToScroll: 1,
                autoplay: true,
                arrows: false,
                autoplaySpeed: 1500,
                swipeToSlide: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    
                    // instead of a settings object
                ]
            });
    

                });</script>';

        return $automobile_var_clients;
    }

//    if (function_exists('automobile_short_code')) {
//        automobile_short_code('automobile_clients', 'automobile_clients_shortcode');
//    }
    
    if (function_exists('automobile_var_short_code'))
{
automobile_var_short_code('automobile_clients', 'automobile_clients_shortcode');
}
}

/*
 *
 * @Shortcode Name :  Start function for Testimonial Item shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_clients_item')) {

    function automobile_clients_item($atts, $content = null) {
        global $clients_style, $column_class, $item_counter, $clients_style, $automobile_var_clients_text_color, $post;
        $defaults = array(
            'automobile_var_clients_img_user_array' => '',
            'automobile_var_clients_text' => '',
        );

        extract(shortcode_atts($defaults, $atts));

        $automobile_var_clients_item = '';
        $clients_img_user = isset($automobile_var_clients_img_user_array) ? $automobile_var_clients_img_user_array : '';
        $automobile_var_clients_text = isset($automobile_var_clients_text) ? $automobile_var_clients_text : '';
        $automobile_var_clients_element_title = isset($automobile_var_clients_element_title) ? $automobile_var_clients_element_title : '';
        $automobile_var_clients_item .= '<li>';
        if ($automobile_var_clients_text <> '') {

            $automobile_var_clients_item .= '<a href="' . esc_url($automobile_var_clients_text) . '">';
        }
        if ($clients_img_user <> '') {
            $automobile_var_clients_item .= '<img src="' . esc_url($clients_img_user) . '" />';
        }
        if ($automobile_var_clients_text <> '') {

            $automobile_var_clients_item .= '</a>';
        }
        $automobile_var_clients_item .= '</li>';
        $item_counter++;

        return $automobile_var_clients_item;
    }

//    if (function_exists('automobile_short_code')) {
//        automobile_short_code('clients_item', 'automobile_clients_item');
//    }
    
    if (function_exists('automobile_var_short_code'))
{
automobile_var_short_code('clients_item', 'automobile_clients_item');
}

}




