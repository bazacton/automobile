<?php

/**
 * @  Blog html form for page builder Frontend side
 *
 *
 */
if (!function_exists('automobile_blog_shortcode')) {

    function automobile_blog_shortcode($atts) {
        global $post, $wpdb, $blog_pagination, $automobile_blog_num_post, $automobile_counter_node, $automobile_column_atts, $automobile_blog_cat, $automobile_blog_description, $automobile_blog_excerpt, $post_thumb_view, $automobile_blog_section_title, $automobile_exclude_post_id, $args;
        $defaults = array('automobile_blog_section_title' => '', 'automobile_blog_view' => '', 'automobile_exclude_post_id' => '0', 'automobile_blog_cat' => '', 'automobile_blog_orderby' => 'DESC', 'orderby' => 'ID', 'automobile_blog_description' => 'yes', 'automobile_blog_excerpt' => '255', 'automobile_blog_num_post' => '10', 'blog_pagination' => '', 'automobile_blog_class' => '');
        extract(shortcode_atts($defaults, $atts));
        $automobile_dataObject = get_post_meta($post->ID, 'automobile_full_data');

        $automobile_sidebarLayout = '';
        $section_automobile_layout = '';
        $pageSidebar = false;
        $box_col_class = 'col-md-3';
        if (isset($automobile_dataObject['automobile_page_layout'])) {
            $automobile_sidebarLayout = $automobile_dataObject['automobile_page_layout'];
        }

        if (isset($automobile_column_atts->automobile_layout)) {
            $section_automobile_layout = $automobile_column_atts->automobile_layout;
            if ($section_automobile_layout == 'left' || $section_automobile_layout == 'right') {
                $pageSidebar = true;
            }
        }
        if ($automobile_sidebarLayout == 'left' || $automobile_sidebarLayout == 'right') {
            $pageSidebar = true;
        }
        if ($pageSidebar == true) {
            $box_col_class = 'col-md-4';
        }

        if ((isset($automobile_dataObject['automobile_page_layout']) && $automobile_dataObject['automobile_page_layout'] <> '' and $automobile_dataObject['automobile_page_layout'] <> "none") || $pageSidebar == true) {
            $automobile_blog_grid_layout = 'col-md-4';
        } else {
            $automobile_blog_grid_layout = 'col-md-3';
        }

        $CustomId = '';
        if (isset($automobile_blog_class) && $automobile_blog_class) {
            $CustomId = 'id="' . $automobile_blog_class . '"';
        }
        $owlcount = rand(40, 9999999);
        $automobile_counter_node++;
        ob_start();
        //==Filters
        $filter_category = '';
        $filter_tag = '';
        $author_filter = '';

        if (isset($_GET['filter_category']) && $_GET['filter_category'] <> '' && $_GET['filter_category'] <> '0') {
            $filter_category = $_GET['filter_category'];
        }

        if (isset($_GET['sort']) and $_GET['sort'] == 'asc') {
            $automobile_blog_orderby = 'ASC';
        } else {
            $automobile_blog_orderby = $automobile_blog_orderby;
        }
        if (isset($_GET['sort']) and $_GET['sort'] == 'alphabetical') {
            $orderby = 'title';
            $automobile_blog_orderby = 'ASC';
        } else {
            $orderby = 'meta_value';
        }
        //==Sorting End         
        if (empty($_GET['page_id_all'])) {
            $_GET['page_id_all'] = 1;
        }
        $automobile_blog_num_post = $automobile_blog_num_post ? $automobile_blog_num_post : '-1';
        if ($automobile_exclude_post_id == 0 && $automobile_exclude_post_id == '') {
            $args = array('posts_per_page' => "-1", 'post_type' => 'post', 'order' => $automobile_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
        } else {
            $args = array('posts_per_page' => "-1", 'post__not_in' => array($automobile_exclude_post_id), 'post_type' => 'post', 'order' => $automobile_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
        }
        if (isset($automobile_blog_cat) && $automobile_blog_cat <> '' && $automobile_blog_cat <> '0') {
            $blog_category_array = array('category_name' => "$automobile_blog_cat");
            $args = array_merge($args, $blog_category_array);
        }
        if (isset($filter_category) && $filter_category <> '' && $filter_category <> '0') {

            if (isset($_GET['filter-tag'])) {
                $filter_tag = $_GET['filter-tag'];
            }
            if ($filter_tag <> '') {
                $blog_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
            } else {
                $blog_category_array = array('category_name' => "$filter_category");
            }
            $args = array_merge($args, $blog_category_array);
        }

        if (isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0') {
            $filter_tag = $_GET['filter-tag'];
            if ($filter_tag <> '') {
                $course_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
                $args = array_merge($args, $course_category_array);
            }
        }
        if (isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0') {
            $author_filter = $_GET['by_author'];
            if ($author_filter <> '') {
                $authorArray = array('author' => "$author_filter");
                $args = array_merge($args, $authorArray);
            }
        }
        $query = new WP_Query($args);
        $count_post = $query->post_count;
		wp_reset_postdata();
        $automobile_blog_num_post = $automobile_blog_num_post ? $automobile_blog_num_post : '-1';
        if ($automobile_exclude_post_id == 0 && $automobile_exclude_post_id == '') {
            $args = array('posts_per_page' => "$automobile_blog_num_post", 'post_type' => 'post', 'paged' => $_GET['page_id_all'], 'order' => $automobile_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
        } else {
            $args = array('posts_per_page' => "$automobile_blog_num_post", 'post__not_in' => array($automobile_exclude_post_id), 'post_type' => 'post', 'paged' => $_GET['page_id_all'], 'order' => $automobile_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
        }
        if (isset($automobile_blog_cat) && $automobile_blog_cat <> '' && $automobile_blog_cat <> '0') {
            $blog_category_array = array('category_name' => "$automobile_blog_cat");
            $args = array_merge($args, $blog_category_array);
        }
        if (isset($filter_category) && $filter_category <> '' && $filter_category <> '0') {
            if (isset($_GET['filter-tag'])) {
                $filter_tag = $_GET['filter-tag'];
            }
            if ($filter_tag <> '') {
                $blog_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
            } else {
                $blog_category_array = array('category_name' => "$filter_category");
            }
            $args = array_merge($args, $blog_category_array);
        }

        if (isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0') {
            $filter_tag = $_GET['filter-tag'];
            if ($filter_tag <> '') {
                $course_category_array = array('category_name' => "$filter_category", 'tag' => "$filter_tag");
                $args = array_merge($args, $course_category_array);
            }
        }
        if (isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0') {
            $author_filter = $_GET['by_author'];
            if ($author_filter <> '') {
                $authorArray = array('author' => "$author_filter");
                $args = array_merge($args, $authorArray);
            }
        }
        if ($automobile_blog_cat != '' && $automobile_blog_cat != '0') {
            $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $automobile_blog_cat));
        }
        $outerDivStart = '<div class="content-area">';
        $outerDivEnd = '</div>';
        $section_title = '';

        if (isset($automobile_blog_section_title) && trim($automobile_blog_section_title) <> '') {
            $section_title = '<div class="main-title"><div class="cs-element-title"><h2>' . $automobile_blog_section_title . '</h2></div></div>';
        }

        echo automobile_allow_special_char($outerDivStart);
        echo automobile_allow_special_char($section_title);
        set_query_var('args', $args);
        

        if ($automobile_blog_view == '3-slides') {
            get_template_part('template-parts/blog/blog', '3slides');
        } else if ($automobile_blog_view == '4-slides') {
            get_template_part('template-parts/blog/blog', '4slides');
        } else if ($automobile_blog_view == 'medium') {
            get_template_part('template-parts/blog/blog', 'medium');
        } else if ($automobile_blog_view == 'grid') {
            get_template_part('template-parts/blog/blog', 'grid');
        } else if ($automobile_blog_view == 'large') {
            get_template_part('template-parts/blog/blog', 'large');
        } else if ($automobile_blog_view == 'classic') {
            get_template_part('template-parts/blog/blog', 'classic');
        }
       
        if ($blog_pagination == "yes" && $count_post > $automobile_blog_num_post && $automobile_blog_num_post > 0 && $automobile_blog_view != 'blog-crousel') {
            $qrystr = '';
            if (isset($_GET['page_id']))
                $qrystr .= "&amp;page_id=" . $_GET['page_id'];
            if ($automobile_blog_view == 'medium' || $automobile_blog_view == 'blog-lrg') {
                
            }
            echo automobile_pagination($count_post, $automobile_blog_num_post, $qrystr, 'Show Pagination', 'page_id_all');
            if ($automobile_blog_view == 'medium' || $automobile_blog_view == 'blog-lrg') {
                
            }
        }
       // if ($automobile_blog_view != 'large') {
            echo '</div>';
       // }
        echo automobile_allow_special_char($outerDivEnd);  
        wp_reset_postdata();
        $post_data = ob_get_clean();
        return $post_data;
    }

    if (function_exists('automobile_var_short_code')) {
        automobile_var_short_code('automobile_blog', 'automobile_blog_shortcode');
    }
}
/**
 * @ cs get categories all post
 *
 *
 */
if (!function_exists('automobile_get_categories')) {

    function automobile_get_categories($automobile_blog_cat) {
        global $post, $wpdb;
        if (isset($automobile_blog_cat) && $automobile_blog_cat != '' && $automobile_blog_cat != '0') {
            $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $automobile_blog_cat));
            echo '<a class="cs-color" href="' . esc_url(home_url('/')) . '?cat=' . $row_cat->term_id . '">' . $row_cat->name . '</a>';
        } else {
            $before_cat = "";
            $categories_list = get_the_term_list(get_the_id(), 'category', $before_cat, ' ', '');
            if ($categories_list) {
                printf('%1$s', $categories_list);
            }
            // End if Categories 
        }
    }

}
/**
 * @ Post Likes Counter
 *
 *
 */
if (!function_exists('automobile_var_page_builder_post_likes_count')) {

    function automobile_var_page_builder_post_likes_count() {
        $automobile_like_counter = get_post_meta($_POST['post_id'], "automobile_post_like_counter", true);
        if (!isset($_COOKIE["automobile_post_like_counter" . $_POST['post_id']])) {
            setcookie("automobile_post_like_counter" . $_POST['post_id'], 'true', time() + 86400, '/', '');
            update_post_meta($_POST['post_id'], 'automobile_post_like_counter', $automobile_like_counter + 1);
        }
        $automobile_like_counter = get_post_meta($_POST['post_id'], "automobile_post_like_counter", true);
        if (!isset($automobile_like_counter) or empty($automobile_like_counter)) {
            $automobile_like_counter = 0;
        }

        echo automobile_var_special_char($automobile_like_counter);
        die(0);
    }

    add_action('wp_ajax_automobile_var_page_builder_post_likes_count', 'automobile_var_page_builder_post_likes_count');
    add_action('wp_ajax_nopriv_automobile_var_page_builder_post_likes_count', 'automobile_var_page_builder_post_likes_count');
}
