<?php

/*
 *
 * @Shortcode Name :   Start function for Testimonial shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_testimonials_shortcode')) {

    function automobile_testimonials_shortcode($atts, $content = null) {
        global $column_class, $section_title, $post,$automobile_var_author_color,$automobile_var_position_color;
        $randomid = rand(0123, 9999);
        $defaults = array(
            'automobile_var_column_size' => '',
            'automobile_var_testimonial_content' => '',
            'automobile_var_testimonial_title' => '',
            'automobile_var_testimonial_sub_title' => '',
            'automobile_var_author_color' => '',
            'automobile_var_position_color' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $html = '';
        $section_title = '';
        $automobile_var_testimonial_title = isset($automobile_var_testimonial_title) ? $automobile_var_testimonial_title : '';
        $automobile_var_testimonial_content = isset($automobile_var_testimonial_content) ? $automobile_var_testimonial_content : '';
        $automobile_var_testimonial_sub_title = isset($automobile_var_testimonial_sub_title) ? $automobile_var_testimonial_sub_title : '';
        $automobile_var_column_size = isset($automobile_var_column_size) ? $automobile_var_column_size : '';
        $automobile_var_author_color = isset($automobile_var_author_color) ? $automobile_var_author_color : '';
        $automobile_var_position_color = isset($automobile_var_position_color) ? $automobile_var_position_color : '';

        if (isset($automobile_var_column_size) && $automobile_var_column_size != '') {
            if (function_exists('automobile_var_custom_column_class')) {
                $column_class = automobile_var_custom_column_class($automobile_var_column_size);
            }
        }

        if (isset($column_class) && $column_class <> '') {
            $html .= '<div class="' . $column_class . '">';
        }
        if (isset($automobile_var_testimonial_title) and $automobile_var_testimonial_title <> '') {
            $html .= '<div class="cs-element-title">';
                $html .= '<h2>' . esc_html($automobile_var_testimonial_title) . '</h2> ';
            $html .= '</div>';
        }
        if (function_exists('automobile_enqueue_slick_script')) {
            automobile_enqueue_slick_script();
        }
//  Start script for Testimonial slider view
        ?>
        <script type='text/javascript'>

            jQuery(document).ready(function () {
                "use strict";
                jQuery('.cs-testimonial-slider').slick({
                    dots: true,
                    arrows: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                });
            });


        </script>
        <?php

        $html .= '<ul class="cs-testimonial-slider">';
        $html .= do_shortcode($content);
        $html .= ' </ul>';

        if (isset($column_class) && $column_class <> '') {
            $html .= ' </div>';
        }

        return $html;
    }

    if (function_exists('automobile_short_code')) {
        automobile_short_code('automobile_testimonial', 'automobile_testimonials_shortcode');
    }
}

if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('automobile_testimonial', 'automobile_testimonials_shortcode');
/*
 *
 * @Shortcode Name :  Start function for Testimonial Item shortcode/element front end view
 * @retrun
 *
 */
if (!function_exists('automobile_testimonial_item')) {

    function automobile_testimonial_item($atts, $content = null) {
        global $column_class, $post,$automobile_var_author_color,$automobile_var_position_color;
        $width = '150';
        $height = '150';
        $defaults = array('automobile_var_testimonial_author' => '', 'automobile_var_testimonial_position' => '', 'automobile_var_testimonial_author_image_array' => '');

        extract(shortcode_atts($defaults, $atts));
        $figure = '';
        $html = '';

        $automobile_var_testimonial_author_image_array = isset($automobile_var_testimonial_author_image_array) ? $automobile_var_testimonial_author_image_array : '';
        $image_id = automobile_var_get_image_id($automobile_var_testimonial_author_image_array);
        $image_url = automobile_attachment_image_src($image_id, $width, $height);
        $automobile_var_testimonial_position = isset($automobile_var_testimonial_position) ? $automobile_var_testimonial_position : '';
        $automobile_var_testimonial_author = isset($automobile_var_testimonial_author) ? $automobile_var_testimonial_author : '';
        $author_color = '';
        if ($automobile_var_author_color != ''){
            $author_color = 'style="color: '.$automobile_var_author_color.' !important;"';
        }
        $position_color = '';
         if ($automobile_var_position_color != ''){
            $position_color = 'style="color: '.$automobile_var_position_color.' !important;"';
        }

        $html .= '';
        $html .= ' <li>';
        if ($image_url <> '') {
            $html .= '<div class="cs-media">';
            $html .= ' <figure><img src="' . esc_url($image_url) . '" ></figure>';
            $html .= '</div>';
        }
        $html .= '<div class="cs-text">';
        $html .= '<p>' . do_shortcode($content) . '</p>';
        $html .= '<div class="author-detail">';
        $html .= '<div class="author-name">';

        $html .= '<span class="cs-divider-shap cs-color"></span>';
        if ($automobile_var_testimonial_author <> '') {
            $html .= '<h6 '.$author_color.'>' . $automobile_var_testimonial_author . '';
        }
        if ($automobile_var_testimonial_position <> '') {
            $html .= '<span '.$position_color.'>' . $automobile_var_testimonial_position . '</span></h6>';
        }
        $html .= '</div>';
        $html .= ' </div>';
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }

    if (function_exists('automobile_short_code')) {
        automobile_short_code('testimonial_item', 'automobile_testimonial_item');
    }
}
if (function_exists('automobile_var_short_code'))
    automobile_var_short_code('testimonial_item', 'automobile_testimonial_item');
