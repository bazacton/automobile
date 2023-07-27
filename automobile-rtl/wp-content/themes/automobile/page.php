<?php
/**
 * The template for displaying all pages
 */
get_header();
$var_arrays = array('post', 'automobile_node', 'automobile_sidebarLayout', 'column_class', 'automobile_xmlObject', 'automobile_node_id', 'column_attributes', 'automobile_paged_id', 'automobile_elem_id');
$page_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($page_global_vars);
$automobile_post_id = isset($post->ID) ? $post->ID : '';
if (isset($automobile_post_id) and $automobile_post_id <> '') {
    $automobile_postObject = get_post_meta($post->ID, 'automobile_full_data', true);
} else {
    $automobile_post_id = '';
}
?>
<!-- Main Content Section -->
<div class="main-section">
    <?php
    $automobile_page_sidebar_right = '';
    $automobile_page_sidebar_left = '';
    $automobile_postObject = get_post_meta($post->ID, 'automobile_var_full_data', true);
    $automobile_page_layout = get_post_meta($post->ID, 'automobile_var_page_layout', true);
    $automobile_page_sidebar_right = get_post_meta($post->ID, 'automobile_var_page_sidebar_right', true);
    $automobile_page_sidebar_left = get_post_meta($post->ID, 'automobile_var_page_sidebar_left', true);
    $automobile_page_bulider = get_post_meta($post->ID, "automobile_page_builder", true);
    $section_container_width = '';
    $page_element_size = 'page-content-fullwidth';

    if (!isset($automobile_page_layout) || $automobile_page_layout == "none") {
        $page_element_size = 'page-content-fullwidth';
    } else {
        $page_element_size = 'page-content col-lg-9 col-md-9 col-sm-12 col-xs-12';
    }
    $automobile_xmlObject = '';

    if (isset($automobile_page_bulider) && $automobile_page_bulider <> '') {
        $automobile_xmlObject = new SimpleXMLElement($automobile_page_bulider);
    }
    if (isset($automobile_page_layout)) {
        $automobile_sidebarLayout = $automobile_page_layout;
    }
    $pageSidebar = false;
    if ($automobile_sidebarLayout == 'left' || $automobile_sidebarLayout == 'right') {
        $pageSidebar = true;
    }
    if(!empty($automobile_xmlObject[0])){
	$count = count($automobile_xmlObject)> 1;
    }else {
	$count = '';
    }
    //var_dump($automobile_xmlObject);
    if (isset($automobile_xmlObject) && !empty($automobile_xmlObject) && $count ) {
        if (isset($automobile_page_layout)) {
            $automobile_page_sidebar_right = $automobile_page_sidebar_right;
            $automobile_page_sidebar_left = $automobile_page_sidebar_left;
        }
        $automobile_counter_node = $column_no = 0;
        $fullwith_style = '';
        $section_container_style_elements = ' ';
        if (isset($automobile_page_layout) && $automobile_sidebarLayout <> '' and $automobile_sidebarLayout <> "none") {

            $fullwith_style = 'style="width:100%;"';
            $section_container_style_elements = ' width: 100%;';
            echo '<div class="container">';
            echo '<div class="row">';


            if (isset($automobile_page_layout) && $automobile_sidebarLayout <> '' and $automobile_sidebarLayout <> "none" and $automobile_sidebarLayout == 'left') :
                if (is_active_sidebar(automobile_get_sidebar_id($automobile_page_sidebar_left))) {
                    ?>
                    <aside class="page-sidebar left col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_page_sidebar_left)) : endif; ?>
                    </aside>
                    <?php
                }
            endif;
            echo '<div class="' . ($page_element_size) . '">';
        }
        if (post_password_required()) {
            echo '<header class="heading"><h6 class="transform">' . get_the_title() . '</h6></header>';
            echo automobile_password_form();
        } else {
            $width = 840;
            $height = 328;
            $image_url = automobile_get_post_img_src($post->ID, $width, $height);
            wp_reset_postdata();


            if (get_the_content() != '' || $image_url != '') {
                if ($pageSidebar != true) {
                    ?>
                    <div class="page-section">
                        <!-- Container Start -->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php
                                }
                                if (isset($image_url) && $image_url != '') {
                                    ?>
                                    <a href="<?php echo esc_url($image_url); ?>" data-rel="prettyPhoto" >
                                        <figure>
                                            <div class="page-featured-image">
                                                <img class="img-thumbnail cs-page-thumbnail" data-src="" src="<?php echo esc_url($image_url); ?>">
                                            </div>
                                        </figure>
                                    </a>
                                    <?php
                                }
                                echo '<div class="cs-rich-editor">';
                                the_content();
                                echo '</div>';
                                if ($pageSidebar != true) {
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        $automobile_page_inline_style = '';
        if (isset($automobile_xmlObject->column_container)) {
            $automobile_elem_id = 0;
        }
        foreach ($automobile_xmlObject->column_container as $column_container) {
            $automobile_section_bg_image = $automobile_var_section_title = $automobile_var_section_subtitle = $title_sub_title_alignment = $automobile_section_bg_image_position = $automobile_section_bg_image_repeat = $automobile_section_bg_color = $automobile_section_padding_top = $automobile_section_padding_bottom = $automobile_section_custom_style = $automobile_section_css_id = $automobile_layout = $automobile_sidebar_left = $automobile_sidebar_right = $css_bg_image = '';
            $section_style_elements = '';
            $section_container_style_elements = '';
            $section_video_element = '';
            $automobile_section_bg_color = '';
            $automobile_section_view = 'container';
            $automobile_section_rand_id = rand(123456, 987654);
            if (isset($column_container)) {
                $column_attributes = $column_container->attributes();
                $column_class = $column_attributes->class;
                $parallax_class = '';
                $parallax_data_type = '';
                $automobile_section_parallax = $column_attributes->automobile_section_parallax;
                if (isset($automobile_section_parallax) && (string) $automobile_section_parallax == 'yes') {
                    $parallax_class = ($automobile_section_parallax == 'yes') ? 'parallex-bg' : '';
                    $parallax_data_type = ' data-type="background"';
                }
                $automobile_var_section_title = $column_attributes->automobile_var_section_title;
                $automobile_var_section_subtitle = $column_attributes->automobile_var_section_subtitle;
                $title_sub_title_alignment = $column_attributes->title_sub_title_alignment;
                $automobile_section_margin_top = $column_attributes->automobile_section_margin_top;
                $automobile_section_margin_bottom = $column_attributes->automobile_section_margin_bottom;
                $automobile_section_padding_top = $column_attributes->automobile_section_padding_top;
                $automobile_section_padding_bottom = $column_attributes->automobile_section_padding_bottom;
                $automobile_section_view = $column_attributes->automobile_section_view;
                $automobile_section_border_color = $column_attributes->automobile_section_border_color;
                if (isset($automobile_section_border_color) && $automobile_section_border_color != '') {
                    $section_style_elements .= '';
                }
                if (isset($automobile_section_margin_top) && $automobile_section_margin_top != '') {
                    $section_style_elements .= 'margin-top: ' . $automobile_section_margin_top . 'px;';
                }
                if (isset($automobile_section_padding_top) && $automobile_section_padding_top != '') {
                    $section_style_elements .= 'padding-top: ' . $automobile_section_padding_top . 'px;';
                }
                if (isset($automobile_section_padding_bottom) && $automobile_section_padding_bottom != '') {
                    $section_style_elements .= 'padding-bottom: ' . $automobile_section_padding_bottom . 'px;';
                }
                if (isset($automobile_section_margin_bottom) && $automobile_section_margin_bottom != '') {
                    $section_style_elements .= 'margin-bottom: ' . $automobile_section_margin_bottom . 'px;';
                }
                $automobile_section_border_top = $column_attributes->automobile_section_border_top;
                $automobile_section_border_bottom = $column_attributes->automobile_section_border_bottom;
                if (isset($automobile_section_border_top) && $automobile_section_border_top != '') {
                    $section_style_elements .= 'border-top: ' . $automobile_section_border_top . 'px ' . $automobile_section_border_color . ' solid;';
                }
                if (isset($automobile_section_border_bottom) && $automobile_section_border_bottom != '') {
                    $section_style_elements .= 'border-bottom: ' . $automobile_section_border_bottom . 'px ' . $automobile_section_border_color . ' solid;';
                }
                $automobile_section_background_option = $column_attributes->automobile_section_background_option;
                $automobile_section_bg_image_position = $column_attributes->automobile_section_bg_image_position;
                if (isset($column_attributes->automobile_section_bg_color))
                    $automobile_section_bg_color = $column_attributes->automobile_section_bg_color;
                if (isset($automobile_section_background_option) && $automobile_section_background_option == 'section-custom-background-image') {
                    $automobile_section_bg_image = $column_attributes->automobile_section_bg_image;
                    $automobile_section_bg_image_position = $column_attributes->automobile_section_bg_image_position;
                    $automobile_section_bg_imageg = '';
                    if (isset($automobile_section_bg_image) && $automobile_section_bg_image != '') {
                        if (isset($automobile_section_parallax) && (string) $automobile_section_parallax == 'yes') {
                            $automobile_paralax_str = false !== strpos($automobile_section_bg_image_position, 'fixed') ? '' : ' fixed';
                            $automobile_section_bg_imageg = 'url(' . $automobile_section_bg_image . ') ' . $automobile_section_bg_image_position . ' ' . $automobile_paralax_str;
                        } else {
                            $automobile_section_bg_imageg = 'url(' . $automobile_section_bg_image . ') ' . $automobile_section_bg_image_position . ' ';
                        }
                    }
                    $section_style_elements .= 'background: ' . $automobile_section_bg_imageg . ' ' . $automobile_section_bg_color . ';';
                } else if (isset($automobile_section_background_option) && $automobile_section_background_option == 'section_background_video') {
                    $automobile_section_video_url = $column_attributes->automobile_section_video_url;
                    $automobile_section_video_mute = $column_attributes->automobile_section_video_mute;
                    $automobile_section_video_autoplay = $column_attributes->automobile_section_video_autoplay;
                    $mute_flag = $mute_control = '';
                    $mute_flag = 'true';
                    if ($automobile_section_video_mute == 'yes') {
                        $mute_flag = 'false';
                        $mute_control = 'controls muted ';
                    }
                    $automobile_video_autoplay = 'autoplay';
                    if ($automobile_section_video_autoplay == 'yes') {
                        $automobile_video_autoplay = 'autoplay';
                    } else {
                        $automobile_video_autoplay = '';
                    }
                    $section_video_class = 'video-parallex';
                    $url = parse_url($automobile_section_video_url);
                    if ($url['host'] == cs_get_server_data("SERVER_NAME")) {
                        $file_type = wp_check_filetype($automobile_section_video_url);
                        if (isset($file_type['type']) && $file_type['type'] <> '') {
                            $file_type = $file_type['type'];
                        } else {
                            $file_type = 'video/mp4';
                        }
                        $rand_player_id = rand(6, 555);
                        $section_video_element = '<div class="page-section-video cs-section-video">
                                    <video id="player' . automobile_allow_special_char($rand_player_id) . '" width="100%" height="100%" ' . automobile_allow_special_char($automobile_video_autoplay) . ' loop="true" preload="none" volume="false" controls="controls" class="nectar-video-bg   cs-video-element"  ' . automobile_allow_special_char($mute_control) . ' >
                                        <source src="' . esc_url($automobile_section_video_url) . '" type="' . automobile_allow_special_char($file_type) . '">
                                    </video>
                                </div>';
                    } else {
                        $section_video_element = wp_oembed_get($automobile_section_video_url, array('height' => '1083'));
                    }
                } else {
                    if (isset($automobile_section_bg_color) && $automobile_section_bg_color != '') {
                        $section_style_elements .= 'background: ' . esc_attr($automobile_section_bg_color) . ';';
                    }
                }
                $automobile_section_padding_top = $column_attributes->automobile_section_padding_top;
                $automobile_section_padding_bottom = $column_attributes->automobile_section_padding_bottom;
                
                 
                if (isset($automobile_section_padding_top) && $automobile_section_padding_top != '') {
                    $section_container_style_elements .= 'padding-top: ' . $automobile_section_padding_top . 'px; ';
                }
                if (isset($automobile_section_padding_bottom) && $automobile_section_padding_bottom != '') {
                    $section_container_style_elements .= 'padding-bottom: ' . $automobile_section_padding_bottom . 'px; ';
                }
                $automobile_section_custom_style = $column_attributes->automobile_section_custom_style;
                $automobile_section_css_id = $column_attributes->automobile_section_css_id;
                if (isset($automobile_section_css_id) && trim($automobile_section_css_id) != '') {
                    $automobile_section_css_id = 'id="' . $automobile_section_css_id . '"';
                }

                $page_element_size = 'section-fullwidth';
                $automobile_layout = $column_attributes->automobile_layout;
                if (!isset($automobile_layout) || $automobile_layout == '' || $automobile_layout == 'none') {
                    $automobile_layout = "none";
                    $page_element_size = 'section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12';
                } else {
                    $page_element_size = 'section-content col-lg-9 col-md-9 col-sm-12 col-xs-12 ';
                }
                $automobile_sidebar_left = $column_attributes->automobile_sidebar_left;
                $automobile_sidebar_right = $column_attributes->automobile_sidebar_right;
            }
            if (isset($automobile_section_bg_image) && $automobile_section_bg_image <> '' && $automobile_section_background_option == 'section-custom-background-image') {
                $css_bg_image = 'url(' . $automobile_section_bg_image . ')';
            }

            $section_style_element = '';
            if ($section_style_elements) {
                $section_style_element = 'style="' . $section_style_elements . '"';
                $automobile_page_inline_style .= ".cs-page-sec-{$automobile_section_rand_id}{{$section_style_elements}}";
            }
            if ($section_container_style_elements) {
                $section_container_style_elements = 'style="' . $section_container_style_elements . '"';
            }
            ?>
            <!-- Page Section -->
            <?php 
                $automobile_section_nopadding = $column_attributes->automobile_section_nopadding;
                  $automobile_section_nomargin = $column_attributes->automobile_section_nomargin;
                $paddingClass = ($automobile_section_nopadding=='yes')?'nopadding':'';
                 $marginClass = ($automobile_section_nomargin=='yes')?'cs-nomargin':'';
             ?>
            <div <?php echo automobile_allow_special_char($automobile_section_css_id); ?> class="page-section cs-page-sec-<?php echo absint($automobile_section_rand_id) ?> <?php echo sanitize_html_class($parallax_class); ?> <?php echo sanitize_html_class($paddingClass); ?> <?php echo sanitize_html_class($marginClass); ?>" <?php echo automobile_allow_special_char($parallax_data_type); ?>  <?php //echo automobile_allow_special_char($section_style_element);    ?> >
                <?php
                echo automobile_allow_special_char($section_video_element);
                if (isset($automobile_section_background_option) && $automobile_section_background_option == 'section-custom-slider') {
                    $automobile_section_custom_slider = $column_attributes->automobile_section_custom_slider;
                    if ($automobile_section_custom_slider != '') {
                        echo do_shortcode($automobile_section_custom_slider);
                    }
                }
                if ($automobile_page_layout == '' || $automobile_page_layout == 'none') {
                    if ($automobile_section_view == 'container') {
                        $automobile_section_view = 'container';
                    } else {
                        $automobile_section_view = 'wide';
                    }
                } else {
                    $automobile_section_view = '';
                }
                ?>
                <!-- Container Start -->
                
                <div class="<?php echo sanitize_html_class($automobile_section_view); ?> "> 
                    <?php
                    if (isset($automobile_layout) && ( $automobile_layout != '' || $automobile_layout != 'none' )) {
                        ?>
                        <div class="row">
                            <?php
                        }
                        // start page section
                        if ($automobile_var_section_title != '' || $automobile_var_section_subtitle != '') {
                            $title_align = '';
                            if($title_sub_title_alignment <> ''){
                                $title_align = ' style="text-align:'. $title_sub_title_alignment .'!important;"';
                            }
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="cs-section-title" <?php echo automobile_allow_special_char($title_align); ?>>
                                    <?php if ($automobile_var_section_title != '') { ?>
                                        <h2><?php echo esc_html($automobile_var_section_title) ?></h2>
                                    <?php } if ($automobile_var_section_subtitle != '') { ?>
                                        <span><?php echo esc_html($automobile_var_section_subtitle) ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        } // end page section
                        if (isset($automobile_layout) && $automobile_layout == "left" && $automobile_sidebar_left <> '') {
                            echo '<aside class="section-sidebar left col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                            if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar_left))) {
                                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar_left)) : endif;
                            }
                            echo '</aside>';
                        }
                        $automobile_node_id = 0;
                        
                        echo '<div class="' . ($page_element_size).'">';
                        echo '<div class="row">';
						
						
                        foreach ($column_container->children() as $column) {
                            $column_no++;
                            $automobile_node_id++;
                            foreach ($column->children() as $automobile_node) {
                                $automobile_elem_id++;
                                $page_element_size = '100';
                                if (isset($automobile_node->page_element_size))
                                    $page_element_size = $automobile_node->page_element_size;
                                if (function_exists('automobile_var_page_builder_element_sizes')) {
                                    echo '<div class="' . automobile_var_page_builder_element_sizes($page_element_size) . ' ">';
                                }
                                $shortcode = trim((string) $automobile_node->automobile_shortcode);
                                $shortcode = html_entity_decode($shortcode);
                                echo do_shortcode($shortcode);
                                if (function_exists('automobile_var_page_builder_element_sizes')) {
                                    echo '</div>';
                                }
                            }
                        }
                        echo '</div><!-- end section row -->';
                        echo '</div>';
                        if (isset($automobile_layout) && $automobile_layout == "right" && $automobile_sidebar_right <> '') {
                            echo '<aside class="section-sidebar right col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                            if (is_active_sidebar(automobile_get_sidebar_id($automobile_sidebar_right))) {
                                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_sidebar_right)) : endif;
                            }
                            echo '</aside>';
                        }
                        if (isset($automobile_layout) && ( $automobile_layout != '' || $automobile_layout != 'none' )) {
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>  <!-- End Container Start -->
            </div> <!-- End Page Section -->
            <?php
            $column_no = 0;
        }

        if (isset($automobile_page_layout) && $automobile_sidebarLayout <> '' and $automobile_sidebarLayout <> "none") {
            echo '</div>';
        }

        if (isset($automobile_page_layout) && $automobile_sidebarLayout <> '' && $automobile_sidebarLayout <> "none" && $automobile_sidebarLayout == 'right') :
            if (is_active_sidebar(automobile_get_sidebar_id($automobile_page_sidebar_right))) {
                ?>
                <aside class="page-sidebar right col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($automobile_page_sidebar_right)) : endif; ?>
                </aside>
                <?php
            }
        endif;
        if (isset($automobile_page_layout) && $automobile_sidebarLayout <> '' and $automobile_sidebarLayout <> "none") {
            echo '</div>';
            echo '</div>';
        }
        if ($automobile_page_inline_style != '') {
            automobile_var_dynamic_scripts('automobile_page_style', 'css', $automobile_page_inline_style);
        }
    } else {
        ?>
        <div class="container">        
            <!-- Row Start -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                    while (have_posts()) : the_post();
                        echo '<div class="cs-rich-editor">';
                        the_content();
                        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">Pages</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                        echo '</div>';
                    endwhile;
                   
                    ?>
                </div>
                <?php
                if (comments_open()) :
                    comments_template('', true);
                endif;
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div><!-- End Main Content Section -->

<?php
get_footer();
