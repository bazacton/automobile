<?php
/*
 * Theme style 
 */
if (!function_exists('automobile_var_custom_style_theme_options')) {
    $automobile_var_custom_themeoption_str = '';

    /**
     * @Start Function for Theme Option Backend Settings and Classes
     *
     */
    function automobile_var_custom_style_theme_options() {
        global $automobile_var_custom_themeoption_str;
        $automobile_var_options = get_option('automobile_var_options');
        ob_start();

        $automobile_var_theme_color = isset($automobile_var_options['automobile_var_theme_color']) ? $automobile_var_options['automobile_var_theme_color'] : '';
        $automobile_var_bg_color = (isset($automobile_var_options['automobile_var_bg_color']) && $automobile_var_options['automobile_var_bg_color'] != '' ) ? $automobile_var_options['automobile_var_bg_color'] : '';
        $automobile_var_text_color = (isset($automobile_var_options['automobile_var_text_color']) && $automobile_var_options['automobile_var_text_color'] != '' ) ? $automobile_var_options['automobile_var_text_color'] : '';
        ?>
        /*!
        *Theme Colors Classes*/
        .cs-color, .slicknav_menu .slicknav_menutxt, .slicknav_nav a, .active > a, .active > a:hover, .active > a:focus, footer#footer .footer-links a, footer#footer a:hover, .wp-automobile .auto-listing .View-btn:hover,.single-page .cs-category-link-icon ul li a:hover,.single-page .cs-category-link-icon ul li a:hover:after,.main-navigation ul .cs-user-option .cs-user-dropdown ul li:hover a,.main-navigation ul .cs-user-option .cs-user-info .btn-sign-out:hover,.single-page .cs-auto-tab .nav-tabs > li > a:hover,.cs-footer-widgets .widget-our-partners ul li a::before,.cs-footer-widgets .widget-categores ul li a:before,.cs-footer-widgets .widget-about-us ul li a:before,.single-page .cs-detail-nav ul > li > a:hover,.single-page .cs-detail-nav ul > li > a.active,.single-page .cs-detail-nav ul > li > a.active:hover,.cs-construction .time-box h4,.cs-construction .time-box .label,.cs-construction .time-box .cs-slash, .wp-automobile ul.cs-user-accounts-list li:hover a, .post-title a:hover, .cs-categories a:hover, .wp-automobile ul.cs-user-accounts-list li.active a, .widget_nav_menu ul li a:hover, .widget_categories ul li a:hover, .wp-automobile .cs-field a:hover, .featured-listing ul li .cs-text h6 a:hover, .blog-listing.medium-view .cs-text h4 a:hover, .cs-blog-listing.blog-grid .blog-text h4 a:hover, .single-post .cs-tags ul li a:hover, .single-post .cs-social-media li a:hover, .widget-tags a:hover, .cs-blog-listing.blog-grid .post-option span, .widget-categories ul li a:hover, .widget-recent-posts .cs-text a:hover, .cs-subheader-text .breadcrumbs ul li a:hover, .widget-admin .cs-text a:hover, .cs-about-author .cs-text span a:hover, .cs-about-author .cs-text a:hover, .cs-next-previous-post a:hover, .cs-blog-related-post .blog-medium .cs-text h4 a:hover, .cs-post-options ul li a:hover, .wp-automobile .auto-sort-filter .auto-list ul li a:hover i, .wp-automobile .auto-listing .auto-text .post-title .btn:after, .wp-automobile .cs-listing-filters .cs-search .search-form .loction-search input[type="text"], .wp-automobile .cs-listing-filters .cs-search .search-form .loction-search:before, .wp-automobile .cs-listing-filters .cs-search .search-form .select-input .chosen-container-single .chosen-single, .wp-automobile .cs-listing-filters .cs-search .search-form .select-input:before, .wp-automobile .cs-listing-filters .cs-filter-title h6, .wp-automobile .cs-listing-filters .cs-checkbox-list li label:hover, .cs-checkbox-list li input[type="checkbox"]:checked + label:after, .wp-automobile .cs-listing-filters .panel-default .panel-heading a, .wp-automobile .cs-agent-listing .cs-post-title h6 a:hover, .wp-automobile .cs-blog.cs-blog-grid .blog-element .blog-text .post-title a:hover h4, .wp-automobile .catagory-section .cs-catagory ul li a:hover span, .cs-services .cs-media i, .wp-automobile .auto-listing .cs-checkbox input[type="checkbox"]:checked + label::after, .woocommerce ul.products li.product .price, .woocommerce .woocommerce-tabs .tab-content li i, .cs-agent-detail .cs-timeline-list li:hover, .widget_tag_cloud a:hover , .wp-automobile .cs-featured-list .cs-field [type="checkbox"]:checked + label:after, .catagory-section .cs-element-title span, .blog-listing.large-view .post-detail span.post-comments a:hover, .blog-listing.medium-view .post-detail span.post-comments a:hover, .panel-group.box .panel-title a, .panel-group.box .panel-title a:before, .single-page .cs-detail-nav ul > li:hover a, .single-page .cs-detail-nav ul > li a.active, .auto-listing .auto-text .btn-list .btn, .auto-listing .auto-price span, .auto-listing.auto-grid .post-title h6 a:hover, .single-page .auto-listing .cs-categories a:hover:hover, .auto-listing.auto-grid .View-btn:hover, .auto-listing.auto-grid .auto-text .cs-categories a:hover, .cs-team .cs-text h6 a:hover, .cs-team .cs-media .cs-caption ul li a:hover i, .cs-field .cs-btn-submit:hover input[type="button"], .cs-field .cs-btn-submit:hover input[type="submit"], .cs-contact-form .cs-btn-submit input[type="submit"], .single-post .cs-social-media li a:hover i, .woocommerce ul.products li.product .product-action-button .button:hover, .woocommerce ul.product_list_widget .amount, .widget_product_tag_cloud a:hover, .woocommerce a.remove, .woocommerce form table.shop_table.cart .product-price .amount, .woocommerce form table.shop_table.cart .product-subtotal .amount, .woocommerce form table.shop_table.cart .product-price .amount, .woocommerce form table.shop_table.cart .product-subtotal .amount, .widget ul li a:hover, .cs-compare li .cs-compare-box .cs-post-title h6 a:hover, .cs-search-result .cs-relevent-links .cs-text h4 a:hover, .post-detail a:hover, .cs-listing-filters .chosen-container-single .chosen-single:after, .woocommerce .woocommerce-tabs .nav-tabs.wc-tabs li.active a:focus, .woocommerce .woocommerce-tabs .nav-tabs.wc-tabs li.active a, .cs-compare-msg-box .cs-compare-page, .widget.widget_pages ul li a:hover, .widget_nav_menu ul li a:hover, .login-link-page, 
        .cs-services .cs-text h6 a:hover, .cs-subheader-text .breadcrumbs ul li.active, .wp-user-form .login-link-page, .user-forgot-password-page, .register-link, .map-tooltip .cs-text .cs-post-title span.cs-price, .auto-sort-filter .auto-list ul li a.active i, .compare-text-div a, .cs-blog-listing.blog-grid .post-meta .post-by a:hover, .cs-blog-listing.blog-grid .post-meta em a:hover, .cs-blog-post .cs-thumb-post .cs-text a:hover, .woocommerce ul.products li.product h2:hover
        {        <?php if (isset($automobile_var_theme_color) || $automobile_var_theme_color != '') { ?>
            color:<?php echo automobile_allow_special_char($automobile_var_theme_color); ?> !important;
        <?php } ?>
        }
        /*!
        * Theme Background Color */
        .cs-bgcolor, .chosen-container-multi .chosen-choices li.search-choice, .chosen-results li.active-result.highlighted, .single-page .auto-detail-filter .auto-field .active-result.result-selected, .single-page .auto-detail-filter .auto-field  .chosen-container .chosen-results li.highlighted, .main-navigation ul ul li:hover, .wp-automobile ul.cs-user-accounts-list li a:after, .wp-automobile .cs-field-holder .chosen-container .chosen-results li.active-result.result-selected ,.wp-automobile .cs-field-holder .chosen-container .chosen-results li:hover, .wp-automobile .pricetable-holder.classic.active .price-holder .cs-price span,.cs-testimonial-slider .slick-dots li button:hover, .cs-testimonial-slider .slick-dots li.slick-active button,.cs-testimonial-slider .cs-media figure:after, .wp-automobile .pricetable-holder.classic.active .price-holder a, .single-post .cs-contact-form .input-holder input[type="submit"], .blog-listing.large-view .post-detail:before, .blog-listing.large-view .cs-media figcaption .caption-text span, .blog-listing.medium-view .cs-media figcaption .caption-text span, .blog-listing.medium-view .cs-auto-categories li:after, .blog-listing.medium-view .post-detail:before, .wp-automobile .auto-sort-filter .chosen-container .chosen-results li.highlighted, .wp-automobile .pagination li a:hover, .wp-automobile .cs-listing-filters .slider-handle, .wp-automobile .cs-listing-filters .mCS-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, .wp-automobile .cs-listing-filters .mCS-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, .wp-automobile .pagination li a.active,.wp-automobile .auto-listing .auto-text .btn-list ul li:before,.wp-automobile .cs-agent-listing .contact-btn:hover, .wp-automobile .cs-compare li .cs-compare-box li:before, .wp-automobile .cs-tabs.full-width .nav > li > a:hover, .search-submit, .navigation.pagination .nav-links a:hover, .chosen-container .chosen-results li.highlighted, .wp-automobile .pagination li a:hover, .wp-automobile .pagination li.active a, .navigation.pagination .nav-links span, .catagory-section .button_style.cs-button a, .cs-blog-listing.blog-grid .cs-media figure figcaption:before, .cs-team .cs-media .cs-caption .cs-top-icon, .cs-gallery .cs-media figcaption i, .cs-field .cs-btn-submit:after, .cs-search-result .cs-relevent-links ul li .cs-text p::after, .blog-listing.medium-view .cs-media figure figcaption:before, .woocommerce form table.shop_table input.button[type="submit"], .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .cs-listing-filters .cs-search .search-form .chosen-container .chosen-results li.highlighted, .slider.slider-horizontal .slider-tick, .slider.slider-horizontal .slider-handle, .cs-blog-related-post .blog-medium .cs-media figure figcaption:before, .woocommerce ul.products li.product .button:hover, .woocommerce.single-product #review_form #respond .form-submit input[type="submit"], .woocommerce .woocommerce-message a.button.wc-forward:hover, .chosen-container .chosen-results li.highlighted, .chosen-container .chosen-results li.active-result.result-selected, .widget.woocommerce.widget_product_search input[type="submit"],
        .auto-listing.auto-grid .auto-text .cs-categories a, .wp-automobile.woocommerce ul.products li.product a.added_to_cart:hover
        {
        <?php if (isset($automobile_var_theme_color) || $automobile_var_theme_color != '') { ?>
            background-color:<?php echo automobile_allow_special_char($automobile_var_theme_color); ?> !important;
        <?php } ?>
        }

        /*!
        * Theme Border Color */
        .csborder-color, .slicknav_menu .slicknav_icon-bar, .single-page .auto-detail-filter .auto-field .slider.slider-horizontal .slider-tick,.single-page .auto-detail-filter .auto-field  .slider.slider-horizontal .slider-handle,.single-page .cs-auto-tab .nav-tabs > li > a:hover,.main-navigation ul ul li:hover > a,.single-page .cs-detail-nav ul > li > a.active,.single-page .cs-detail-nav ul > li > a.active:hover,.wp-automobile .pricetable-holder.modren.active,.cs-testimonial-slider .slick-dots li button:hover, .cs-testimonial-slider .slick-dots li.slick-active button, .widget_tag_cloud a:hover, .wp-automobile .pricetable-holder.classic.active, .widget-tags a:hover, .blog-listing.large-view .cs-text .btn-more, .single-post .cs-tags ul li a:hover, .wp-automobile .cs-listing-filters .cs-checkbox-list li input[type="checkbox"]:checked + label:after, .wp-automobile .cs-agent-listing .contact-btn:hover, .csborder-top-color, .wp-automobile .cs-tabs.full-width .nav > li > a:hover, .nav > li > a:focus, .wp-automobile .cs-tabs.full-width .nav > li > a:hover, .wp-automobile .cs-tabs.full-width .nav > li > a:focus, .wp-automobile .cs-tabs.full-width .nav-tabs > li.active > a,.wp-automobile .cs-tabs.full-width  .nav-tabs > li.active > a:hover,.wp-automobile .cs-tabs.full-width  .nav-tabs > li.active > a:focus, .woocommerce-tabs .nav-tabs.wc-tabs li.active a, .woocommerce ul.products li.product .product-action-button .button, .wp-automobile .cs-featured-list .cs-field label:hover:before, .wp-automobile .cs-featured-list .cs-field [type="checkbox"]:checked + label:before, .cs-package-payment ul li .radiobox input[type="radio"]:checked + label::after, .cs-field .cs-btn-submit:before, .cs-contact-form .cs-btn-submit input[type="submit"], blockquote, .widget_product_tag_cloud a:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce.single-product div.product form.cart .button
        {
        <?php if (isset($automobile_var_theme_color) || $automobile_var_theme_color != '') { ?>
            border-color:<?php echo automobile_allow_special_char($automobile_var_theme_color); ?> !important;
        <?php } ?>
        }

        <?php
        $automobile_var_sitcky_header_switch = isset($automobile_var_options['automobile_var_sitcky_header_switch']) ? $automobile_var_options['automobile_var_sitcky_header_switch'] : '';
        $automobile_var_layout = isset($automobile_var_options['automobile_var_layout']) ? $automobile_var_options['automobile_var_layout'] : '';
        $automobile_var_custom_bgimage = isset($automobile_var_options['automobile_var_custom_bgimage']) ? $automobile_var_options['automobile_var_custom_bgimage'] : '';
        $automobile_var_bg_image = isset($automobile_var_options['automobile_var_bg_image']) ? $automobile_var_options['automobile_var_bg_image'] : '';
        $automobile_var_pattern_image = isset($automobile_var_options['automobile_var_pattern_image']) ? $automobile_var_options['automobile_var_pattern_image'] : '';
        $automobile_var_background_position = isset($automobile_var_options['automobile_var_bgimage_position']) ? $automobile_var_options['automobile_var_bgimage_position'] : '';

        if ($automobile_var_layout != 'full_width') {
            $automobile_repeat_options = false;
            if ($automobile_var_custom_bgimage != "") {
                $automobile_repeat_options = true;
                $automobile_var_background_image = $automobile_var_custom_bgimage;
            } else if ($automobile_var_bg_image != "" && $automobile_var_bg_image != 'bg0') {
                $automobile_var_background_image = trailingslashit(get_template_directory_uri()) . "assets/backend/images/background/" . $automobile_var_bg_image . ".png";
            } else if ($automobile_var_pattern_image != "" && $automobile_var_pattern_image != 'pattern0') {
                $automobile_var_background_image = trailingslashit(get_template_directory_uri()) . "assets/backend/images/patterns/" . $automobile_var_pattern_image . ".png";
            }

            if (isset($automobile_var_background_image) && $automobile_var_background_image <> "") {
                if ($automobile_repeat_options == true) {
                    $wrppaer_style = 'background:url(' . $automobile_var_background_image . ') ' . $automobile_var_background_position . ' ' . $automobile_var_bg_color . ' !important;';
                } else {
                    $wrppaer_style = 'background:url(' . $automobile_var_background_image . ') repeat ' . $automobile_var_bg_color . ' !important;';
                }
            } else if ($automobile_var_bg_color != '') {
                $wrppaer_style = 'background:' . $automobile_var_bg_color . ' !important;';
            }
        } else if ($automobile_var_custom_bgimage != '') {
            $wrppaer_style = 'background:url(' . $automobile_var_custom_bgimage . ') ' . $automobile_var_background_position . ' ' . $automobile_var_bg_color . ' !important;';
        } else if ($automobile_var_bg_color != '') {
            $wrppaer_style = 'background:' . $automobile_var_bg_color . ' !important;';
        }

        if (isset($wrppaer_style) && $wrppaer_style != '') {
            ?>
            body{
            <?php echo automobile_allow_special_char($wrppaer_style) ?>
            }
            <?php
        }

        ///// Start Extra CSS
        if (isset($automobile_var_sitcky_header_switch) && $automobile_var_sitcky_header_switch == 'on') {
            ?>
            .cs-main-nav {
            position: fixed !important;

            z-index: 99 !important;
            }
            <?php
        } else {
            ?>
            .cs-main-nav {

            position: relative !important;

            z-index: 99 !important;
            }
            <?php
        }
        ///// END Extra CSS
        /**
         * @Set Header color Css
         *
         *
         */
        $automobile_var_header_bgcolor = (isset($automobile_var_options['automobile_var_header_bgcolor']) and $automobile_var_options['automobile_var_header_bgcolor'] <> '') ? $automobile_var_options['automobile_var_header_bgcolor'] : '';
        $automobile_var_menu_color = (isset($automobile_var_options['automobile_var_menu_color']) and $automobile_var_options['automobile_var_menu_color'] <> '') ? $automobile_var_options['automobile_var_menu_color'] : '';
        $automobile_var_menu_active_color = (isset($automobile_var_options['automobile_var_menu_active_color']) and $automobile_var_options['automobile_var_menu_active_color'] <> '') ? $automobile_var_options['automobile_var_menu_active_color'] : '';
        $automobile_var_modern_menu_color = (isset($automobile_var_options['automobile_var_modern_menu_color']) and $automobile_var_options['automobile_var_modern_menu_color'] <> '') ? $automobile_var_options['automobile_var_modern_menu_color'] : '';
        $automobile_var_modern_menu_active_color = (isset($automobile_var_options['automobile_var_modern_menu_active_color']) and $automobile_var_options['automobile_var_modern_menu_active_color'] <> '') ? $automobile_var_options['automobile_var_modern_menu_active_color'] : '';
        $automobile_var_submenu_bgcolor = (isset($automobile_var_options['automobile_var_submenu_bgcolor']) and $automobile_var_options['automobile_var_submenu_bgcolor'] <> '' ) ? $automobile_var_options['automobile_var_submenu_bgcolor'] : '';
        $automobile_var_submenu_color = (isset($automobile_var_options['automobile_var_submenu_color']) and $automobile_var_options['automobile_var_submenu_color'] <> '') ? $automobile_var_options['automobile_var_submenu_color'] : '';
        $automobile_var_menu_heading_color = (isset($automobile_var_options['automobile_var_menu_heading_color']) and $automobile_var_options['automobile_var_menu_heading_color'] <> '') ? $automobile_var_options['automobile_var_menu_heading_color'] : '';
        $automobile_var_submenu_hover_color = (isset($automobile_var_options['automobile_var_submenu_hover_color']) and $automobile_var_options['automobile_var_submenu_hover_color'] <> '') ? $automobile_var_options['automobile_var_submenu_hover_color'] : '';
        $automobile_var_topstrip_bgcolor = (isset($automobile_var_options['automobile_var_topstrip_bgcolor']) and $automobile_var_options['automobile_var_topstrip_bgcolor'] <> '') ? $automobile_var_options['automobile_var_topstrip_bgcolor'] : '';
        $automobile_var_topstrip_text_color = (isset($automobile_var_options['automobile_var_topstrip_text_color']) and $automobile_var_options['automobile_var_topstrip_text_color'] <> '') ? $automobile_var_options['automobile_var_topstrip_text_color'] : '';
        $automobile_var_topstrip_link_color = (isset($automobile_var_options['automobile_var_topstrip_link_color']) and $automobile_var_options['automobile_var_topstrip_link_color'] <> '') ? $automobile_var_options['automobile_var_topstrip_link_color'] : '';
        $automobile_var_menu_activ_bg = (isset($automobile_var_options['automobile_var_theme_color'])) ? $automobile_var_options['automobile_var_theme_color'] : '';
        $automobile_var_page_title_color = (isset($automobile_var_options['automobile_var_page_title_color'])) ? $automobile_var_options['automobile_var_page_title_color'] : '';

        /**
         * @Logo Margins
         *
         */
        $automobile_var_logo_margint = (isset($automobile_var_options['automobile_var_logo_margint']) and $automobile_var_options['automobile_var_logo_margint'] <> '') ? $automobile_var_options['automobile_var_logo_margint'] : '0';
        $automobile_var_logo_marginb = (isset($automobile_var_options['automobile_var_logo_marginb']) and $automobile_var_options['automobile_var_logo_marginb'] <> '') ? $automobile_var_options['automobile_var_logo_marginb'] : '0';

        $automobile_var_logo_marginr = (isset($automobile_var_options['automobile_var_logo_marginr']) and $automobile_var_options['automobile_var_logo_marginr'] <> '') ? $automobile_var_options['automobile_var_logo_marginr'] : '0';
        $automobile_var_logo_marginl = (isset($automobile_var_options['automobile_var_logo_marginl']) and $automobile_var_options['automobile_var_logo_marginl'] <> '') ? $automobile_var_options['automobile_var_logo_marginl'] : '0';

        /**
         * @Font Family
         *
         */
        $automobile_var_content_font = (isset($automobile_var_options['automobile_var_content_font'])) ? $automobile_var_options['automobile_var_content_font'] : '';
        $automobile_var_content_font_att = (isset($automobile_var_options['automobile_var_content_font_att'])) ? $automobile_var_options['automobile_var_content_font_att'] : '';

        $automobile_var_mainmenu_font = (isset($automobile_var_options['automobile_var_mainmenu_font'])) ? $automobile_var_options['automobile_var_mainmenu_font'] : '';
        $automobile_var_mainmenu_font_att = (isset($automobile_var_options['automobile_var_mainmenu_font_att'])) ? $automobile_var_options['automobile_var_mainmenu_font_att'] : '';

        $automobile_var_heading1_font = (isset($automobile_var_options['automobile_var_heading1_font'])) ? $automobile_var_options['automobile_var_heading1_font'] : '';
        $automobile_var_heading1_font_att = (isset($automobile_var_options['automobile_var_heading1_font_att'])) ? $automobile_var_options['automobile_var_heading1_font_att'] : '';

        $automobile_var_heading2_font = (isset($automobile_var_options['automobile_var_heading2_font'])) ? $automobile_var_options['automobile_var_heading2_font'] : '';
        $automobile_var_heading2_font_att = (isset($automobile_var_options['automobile_var_heading2_font_att'])) ? $automobile_var_options['automobile_var_heading2_font_att'] : '';

        $automobile_var_heading3_font = (isset($automobile_var_options['automobile_var_heading3_font'])) ? $automobile_var_options['automobile_var_heading3_font'] : '';
        $automobile_var_heading3_font_att = (isset($automobile_var_options['automobile_var_heading3_font_att'])) ? $automobile_var_options['automobile_var_heading3_font_att'] : '';

        $automobile_var_heading4_font = (isset($automobile_var_options['automobile_var_heading4_font'])) ? $automobile_var_options['automobile_var_heading4_font'] : '';
        $automobile_var_heading4_font_att = (isset($automobile_var_options['automobile_var_heading4_font_att'])) ? $automobile_var_options['automobile_var_heading4_font_att'] : '';

        $automobile_var_heading5_font = (isset($automobile_var_options['automobile_var_heading5_font'])) ? $automobile_var_options['automobile_var_heading5_font'] : '';
        $automobile_var_heading5_font_att = (isset($automobile_var_options['automobile_var_heading5_font_att'])) ? $automobile_var_options['automobile_var_heading5_font_att'] : '';

        $automobile_var_heading6_font = (isset($automobile_var_options['automobile_var_heading6_font'])) ? $automobile_var_options['automobile_var_heading6_font'] : '';
        $automobile_var_heading6_font_att = (isset($automobile_var_options['automobile_var_heading6_font_att'])) ? $automobile_var_options['automobile_var_heading6_font_att'] : '';

        $automobile_var_section_title_font = (isset($automobile_var_options['automobile_var_section_title_font'])) ? $automobile_var_options['automobile_var_section_title_font'] : '';
        $automobile_var_section_title_font_att = (isset($automobile_var_options['automobile_var_section_title_font_att'])) ? $automobile_var_options['automobile_var_section_title_font_att'] : '';

        $automobile_var_page_title_font = (isset($automobile_var_options['automobile_var_page_title_font'])) ? $automobile_var_options['automobile_var_page_title_font'] : '';
        $automobile_var_page_title_font_att = (isset($automobile_var_options['automobile_var_page_title_font_att'])) ? $automobile_var_options['automobile_var_page_title_font_att'] : '';

        $automobile_var_post_title_font = (isset($automobile_var_options['automobile_var_post_title_font'])) ? $automobile_var_options['automobile_var_post_title_font'] : '';
        $automobile_var_post_title_font_att = (isset($automobile_var_options['automobile_var_post_title_font_att'])) ? $automobile_var_options['automobile_var_post_title_font_att'] : '';

        $automobile_var_widget_heading_font = (isset($automobile_var_options['automobile_var_widget_heading_font'])) ? $automobile_var_options['automobile_var_widget_heading_font'] : '';
        $automobile_var_widget_heading_font_att = (isset($automobile_var_options['automobile_var_widget_heading_font_att'])) ? $automobile_var_options['automobile_var_widget_heading_font_att'] : '';

        $automobile_var_ft_widget_heading_font = (isset($automobile_var_options['automobile_var_ft_widget_heading_font'])) ? $automobile_var_options['automobile_var_ft_widget_heading_font'] : '';
        $automobile_var_ft_widget_heading_font_att = (isset($automobile_var_options['automobile_var_ft_widget_heading_font_att'])) ? $automobile_var_options['automobile_var_ft_widget_heading_font_att'] : '';

        /**
         * @Setting Content Fonts
         *
         */
        $automobile_var_content_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_content_font_att);

        $automobile_var_content_font_atts = automobile_var_get_font_att_array($automobile_var_content_fonts);

        /**
         * @Setting Main Menu Fonts
         *
         */
        $automobile_var_mainmenu_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_mainmenu_font_att);

        $automobile_var_mainmenu_font_atts = automobile_var_get_font_att_array($automobile_var_mainmenu_fonts);

        /**
         * @Setting Heading Fonts
         *
         */
        $automobile_var_heading1_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_heading1_font_att);
        $automobile_var_heading1_font_atts = automobile_var_get_font_att_array($automobile_var_heading1_fonts);

        $automobile_var_heading2_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_heading2_font_att);
        $automobile_var_heading2_font_atts = automobile_var_get_font_att_array($automobile_var_heading2_fonts);

        $automobile_var_heading3_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_heading3_font_att);
        $automobile_var_heading3_font_atts = automobile_var_get_font_att_array($automobile_var_heading3_fonts);

        $automobile_var_heading4_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_heading4_font_att);
        $automobile_var_heading4_font_atts = automobile_var_get_font_att_array($automobile_var_heading4_fonts);

        $automobile_var_heading5_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_heading5_font_att);
        $automobile_var_heading5_font_atts = automobile_var_get_font_att_array($automobile_var_heading5_fonts);

        $automobile_var_heading6_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_heading6_font_att);
        $automobile_var_heading6_font_atts = automobile_var_get_font_att_array($automobile_var_heading6_fonts);

        /**
         * @Section Title Fonts
         *
         */
        $automobile_var_section_title_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_section_title_font_att);
        $automobile_var_section_title_font_atts = automobile_var_get_font_att_array($automobile_var_section_title_fonts);

        /**
         * @Page Title Heading Fonts
         *
         */
        $automobile_var_page_title_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_page_title_font_att);
        $automobile_var_page_title_font_atts = automobile_var_get_font_att_array($automobile_var_page_title_fonts);

        /**
         * @Post Title Heading Fonts
         *
         */
        $automobile_var_post_title_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_post_title_font_att);
        $automobile_var_post_title_font_atts = automobile_var_get_font_att_array($automobile_var_post_title_fonts);

        /**
         * @Setting Widget Heading Fonts
         *
         */
        $automobile_var_widget_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_widget_heading_font_att);
        $automobile_var_widget_heading_font_atts = automobile_var_get_font_att_array($automobile_var_widget_heading_fonts);


        /**
         * @Setting Footer Widget Heading Fonts
         *
         */
        $automobile_var_ft_widget_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $automobile_var_ft_widget_heading_font_att);
        $automobile_var_ft_widget_heading_font_atts = automobile_var_get_font_att_array($automobile_var_ft_widget_heading_fonts);

        /**
         * @Font Sizes
         *
         */
        $automobile_var_content_size = (isset($automobile_var_options['automobile_var_content_size'])) ? $automobile_var_options['automobile_var_content_size'] : '';
        $automobile_var_mainmenu_size = (isset($automobile_var_options['automobile_var_mainmenu_size'])) ? $automobile_var_options['automobile_var_mainmenu_size'] : '';
        $automobile_var_heading_1_size = (isset($automobile_var_options['automobile_var_heading_1_size'])) ? $automobile_var_options['automobile_var_heading_1_size'] : '';
        $automobile_var_heading_2_size = (isset($automobile_var_options['automobile_var_heading_2_size'])) ? $automobile_var_options['automobile_var_heading_2_size'] : '';
        $automobile_var_heading_3_size = (isset($automobile_var_options['automobile_var_heading_3_size'])) ? $automobile_var_options['automobile_var_heading_3_size'] : '';
        $automobile_var_heading_4_size = (isset($automobile_var_options['automobile_var_heading_4_size'])) ? $automobile_var_options['automobile_var_heading_4_size'] : '';
        $automobile_var_heading_5_size = (isset($automobile_var_options['automobile_var_heading_5_size'])) ? $automobile_var_options['automobile_var_heading_5_size'] : '';
        $automobile_var_heading_6_size = (isset($automobile_var_options['automobile_var_heading_6_size'])) ? $automobile_var_options['automobile_var_heading_6_size'] : '';
        $automobile_var_section_title_size = (isset($automobile_var_options['automobile_var_section_title_size'])) ? $automobile_var_options['automobile_var_section_title_size'] : '';
        $automobile_var_page_title_size = (isset($automobile_var_options['automobile_var_page_title_size'])) ? $automobile_var_options['automobile_var_page_title_size'] : '';
        $automobile_var_post_title_size = (isset($automobile_var_options['automobile_var_post_title_size'])) ? $automobile_var_options['automobile_var_post_title_size'] : '';
        $automobile_var_widget_heading_size = (isset($automobile_var_options['automobile_var_widget_heading_size'])) ? $automobile_var_options['automobile_var_widget_heading_size'] : '';
        $automobile_var_ft_widget_heading_size = (isset($automobile_var_options['automobile_var_ft_widget_heading_size'])) ? $automobile_var_options['automobile_var_ft_widget_heading_size'] : '';

        /**
         * @Font LIne Heights
         *
         */
        $automobile_var_content_lh = (isset($automobile_var_options['automobile_var_content_lh'])) ? $automobile_var_options['automobile_var_content_lh'] : '';
        $automobile_var_mainmenu_lh = (isset($automobile_var_options['automobile_var_mainmenu_lh'])) ? $automobile_var_options['automobile_var_mainmenu_lh'] : '';
        $automobile_var_heading_1_lh = (isset($automobile_var_options['automobile_var_heading_1_lh'])) ? $automobile_var_options['automobile_var_heading_1_lh'] : '';
        $automobile_var_heading_2_lh = (isset($automobile_var_options['automobile_var_heading_2_lh'])) ? $automobile_var_options['automobile_var_heading_2_lh'] : '';
        $automobile_var_heading_3_lh = (isset($automobile_var_options['automobile_var_heading_3_lh'])) ? $automobile_var_options['automobile_var_heading_3_lh'] : '';
        $automobile_var_heading_4_lh = (isset($automobile_var_options['automobile_var_heading_4_lh'])) ? $automobile_var_options['automobile_var_heading_4_lh'] : '';
        $automobile_var_heading_5_lh = (isset($automobile_var_options['automobile_var_heading_5_lh'])) ? $automobile_var_options['automobile_var_heading_5_lh'] : '';
        $automobile_var_heading_6_lh = (isset($automobile_var_options['automobile_var_heading_6_lh'])) ? $automobile_var_options['automobile_var_heading_6_lh'] : '';
        $automobile_var_section_title_lh = (isset($automobile_var_options['automobile_var_section_title_lh'])) ? $automobile_var_options['automobile_var_section_title_lh'] : '';
        $automobile_var_page_title_lh = (isset($automobile_var_options['automobile_var_page_title_lh'])) ? $automobile_var_options['automobile_var_page_title_lh'] : '';
        $automobile_var_post_title_lh = (isset($automobile_var_options['automobile_var_post_title_lh'])) ? $automobile_var_options['automobile_var_post_title_lh'] : '';
        $automobile_var_widget_heading_lh = (isset($automobile_var_options['automobile_var_widget_heading_lh'])) ? $automobile_var_options['automobile_var_widget_heading_lh'] : '';
        $automobile_var_ft_widget_heading_lh = (isset($automobile_var_options['automobile_var_ft_widget_heading_lh'])) ? $automobile_var_options['automobile_var_ft_widget_heading_lh'] : '';

        $automobile_var_content_spc = (isset($automobile_var_options['automobile_var_content_spc'])) ? $automobile_var_options['automobile_var_content_spc'] : '';
        $automobile_var_mainmenu_spc = (isset($automobile_var_options['automobile_var_mainmenu_spc'])) ? $automobile_var_options['automobile_var_mainmenu_spc'] : '';
        $automobile_var_heading_1_spc = (isset($automobile_var_options['automobile_var_heading_1_spc'])) ? $automobile_var_options['automobile_var_heading_1_spc'] : '';
        $automobile_var_heading_2_spc = (isset($automobile_var_options['automobile_var_heading_2_spc'])) ? $automobile_var_options['automobile_var_heading_2_spc'] : '';
        $automobile_var_heading_3_spc = (isset($automobile_var_options['automobile_var_heading_3_spc'])) ? $automobile_var_options['automobile_var_heading_3_spc'] : '';
        $automobile_var_heading_4_spc = (isset($automobile_var_options['automobile_var_heading_4_spc'])) ? $automobile_var_options['automobile_var_heading_4_spc'] : '';
        $automobile_var_heading_5_spc = (isset($automobile_var_options['automobile_var_heading_5_spc'])) ? $automobile_var_options['automobile_var_heading_5_spc'] : '';
        $automobile_var_heading_6_spc = (isset($automobile_var_options['automobile_var_heading_6_spc'])) ? $automobile_var_options['automobile_var_heading_6_spc'] : '';
        $automobile_var_section_title_spc = (isset($automobile_var_options['automobile_var_section_title_spc'])) ? $automobile_var_options['automobile_var_section_title_spc'] : '';
        $automobile_var_page_title_spc = (isset($automobile_var_options['automobile_var_page_title_spc'])) ? $automobile_var_options['automobile_var_page_title_spc'] : '';
        $automobile_var_post_title_spc = (isset($automobile_var_options['automobile_var_post_title_spc'])) ? $automobile_var_options['automobile_var_post_title_spc'] : '';
        $automobile_var_widget_heading_spc = (isset($automobile_var_options['automobile_var_widget_heading_spc'])) ? $automobile_var_options['automobile_var_widget_heading_spc'] : '';
        $automobile_var_ft_widget_heading_spc = (isset($automobile_var_options['automobile_var_ft_widget_heading_spc'])) ? $automobile_var_options['automobile_var_ft_widget_heading_spc'] : '';

        /**
         * @Font Text Transform
         *
         */
        $automobile_var_content_textr = (isset($automobile_var_options['automobile_var_content_textr'])) ? $automobile_var_options['automobile_var_content_textr'] : '';
        $automobile_var_mainmenu_textr = (isset($automobile_var_options['automobile_var_mainmenu_textr'])) ? $automobile_var_options['automobile_var_mainmenu_textr'] : '';
        $automobile_var_heading_1_textr = (isset($automobile_var_options['automobile_var_heading_1_textr'])) ? $automobile_var_options['automobile_var_heading_1_textr'] : '';
        $automobile_var_heading_2_textr = (isset($automobile_var_options['automobile_var_heading_2_textr'])) ? $automobile_var_options['automobile_var_heading_2_textr'] : '';
        $automobile_var_heading_3_textr = (isset($automobile_var_options['automobile_var_heading_3_textr'])) ? $automobile_var_options['automobile_var_heading_3_textr'] : '';
        $automobile_var_heading_4_textr = (isset($automobile_var_options['automobile_var_heading_4_textr'])) ? $automobile_var_options['automobile_var_heading_4_textr'] : '';
        $automobile_var_heading_5_textr = (isset($automobile_var_options['automobile_var_heading_5_textr'])) ? $automobile_var_options['automobile_var_heading_5_textr'] : '';
        $automobile_var_heading_6_textr = (isset($automobile_var_options['automobile_var_heading_6_textr'])) ? $automobile_var_options['automobile_var_heading_6_textr'] : '';
        $automobile_var_section_title_textr = (isset($automobile_var_options['automobile_var_section_title_textr'])) ? $automobile_var_options['automobile_var_section_title_textr'] : '';
        $automobile_var_page_title_textr = (isset($automobile_var_options['automobile_var_page_title_textr'])) ? $automobile_var_options['automobile_var_page_title_textr'] : '';
        $automobile_var_post_title_textr = (isset($automobile_var_options['automobile_var_post_title_textr'])) ? $automobile_var_options['automobile_var_post_title_textr'] : '';
        $automobile_var_widget_heading_textr = (isset($automobile_var_options['automobile_var_widget_heading_textr'])) ? $automobile_var_options['automobile_var_widget_heading_textr'] : '';
        $automobile_var_ft_widget_heading_textr = (isset($automobile_var_options['automobile_var_ft_widget_heading_textr'])) ? $automobile_var_options['automobile_var_ft_widget_heading_textr'] : '';


        $automobile_var_widget_color = isset($automobile_var_options['automobile_var_widget_color']) ? $automobile_var_options['automobile_var_widget_color'] : '#2d2d2d';
        $automobile_var_ft_widget_title_color = isset($automobile_var_options['automobile_var_footer_widget_title_color']) ? $automobile_var_options['automobile_var_footer_widget_title_color'] : '';


        /**
         * @Font Color
         *
         */
        $automobile_var_heading_h1_color = (isset($automobile_var_options['automobile_var_heading_h1_color']) and $automobile_var_options['automobile_var_heading_h1_color'] <> '') ? $automobile_var_options['automobile_var_heading_h1_color'] : '';
        $automobile_var_heading_h2_color = (isset($automobile_var_options['automobile_var_heading_h2_color']) and $automobile_var_options['automobile_var_heading_h2_color'] <> '') ? $automobile_var_options['automobile_var_heading_h2_color'] : '';
        $automobile_var_heading_h3_color = (isset($automobile_var_options['automobile_var_heading_h3_color']) and $automobile_var_options['automobile_var_heading_h3_color'] <> '') ? $automobile_var_options['automobile_var_heading_h3_color'] : '';
        $automobile_var_heading_h4_color = (isset($automobile_var_options['automobile_var_heading_h4_color']) and $automobile_var_options['automobile_var_heading_h4_color'] <> '') ? $automobile_var_options['automobile_var_heading_h4_color'] : '';
        $automobile_var_heading_h5_color = (isset($automobile_var_options['automobile_var_heading_h5_color']) and $automobile_var_options['automobile_var_heading_h5_color'] <> '') ? $automobile_var_options['automobile_var_heading_h5_color'] : '';
        $automobile_var_heading_h6_color = (isset($automobile_var_options['automobile_var_heading_h6_color']) and $automobile_var_options['automobile_var_heading_h6_color'] <> '') ? $automobile_var_options['automobile_var_heading_h6_color'] : '';

        $automobile_var_widget_heading_size = (isset($automobile_var_options['automobile_var_widget_heading_size'])) ? $automobile_var_options['automobile_var_widget_heading_size'] : '';
        $automobile_var_section_heading_size = (isset($automobile_var_options['automobile_var_section_heading_size'])) ? $automobile_var_options['automobile_var_section_heading_size'] : '';
        $automobile_var_copyright_bg_color = (isset($automobile_var_options['automobile_var_copyright_bg_color'])) ? $automobile_var_options['automobile_var_copyright_bg_color'] : '';

        if (
                ( isset($automobile_var_options['automobile_var_custom_font_woff']) && $automobile_var_options['automobile_var_custom_font_woff'] <> '' ) &&
                ( isset($automobile_var_options['automobile_var_custom_font_ttf']) && $automobile_var_options['automobile_var_custom_font_ttf'] <> '' ) &&
                ( isset($automobile_var_options['automobile_var_custom_font_svg']) && $automobile_var_options['automobile_var_custom_font_svg'] <> '' ) &&
                ( isset($automobile_var_options['automobile_var_custom_font_eot']) && $automobile_var_options['automobile_var_custom_font_eot'] <> '' )
        ):

            $font_face_html = "
        @font-face {
	font-family: 'automobile_var_custom_font';
	src: url('" . $automobile_var_options['automobile_var_custom_font_eot'] . "');
	src:
		url('" . $automobile_var_options['automobile_var_custom_font_eot'] . "?#iefix') format('eot'),
		url('" . $automobile_var_options['automobile_var_custom_font_woff'] . "') format('woff'),
		url('" . $automobile_var_options['automobile_var_custom_font_ttf'] . "') format('truetype'),
		url('" . $automobile_var_options['automobile_var_custom_font_svg'] . "#automobile_var_custom_font') format('svg');
	font-weight: 400;
	font-style: normal;
        }";

            $custom_font = true;
        else: $custom_font = false;
        endif;

        if ($custom_font == true) {
            echo automobile_allow_special_char($font_face_html);
        }
        if ((isset($automobile_var_content_size) && $automobile_var_content_size != '') || (isset($automobile_var_content_spc) && $automobile_var_content_spc != '') || (isset($automobile_var_content_textr) && $automobile_var_content_textr != '') || (isset($automobile_var_text_color) && $automobile_var_text_color != '')) {
            ?>
            body, .main-section p, .mce-content-body p {
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_content_size) && $automobile_var_content_size != '') {
                    echo 'font-size: ' . $automobile_var_content_size . ';';
                }
                if (isset($automobile_var_content_spc) && $automobile_var_content_spc != '') {
                    echo esc_html($automobile_var_content_spc != '' ? 'letter-spacing: ' . $automobile_var_content_spc . 'px;' : '');
                }
                if (isset($automobile_var_content_textr) && $automobile_var_content_textr != '') {
                    echo esc_html($automobile_var_content_textr != '' ? 'text-transform: ' . $automobile_var_content_textr . ';' : '');
                }
                if (isset($automobile_var_text_color) && $automobile_var_text_color != '') {
                    echo esc_html($automobile_var_text_color != '' ? 'color: ' . $automobile_var_text_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_content_font_atts, $automobile_var_content_size, $automobile_var_content_lh, $automobile_var_content_font);
                if (isset($automobile_var_content_spc) && $automobile_var_content_spc != '') {
                    echo esc_html($automobile_var_content_spc != '' ? 'letter-spacing: ' . $automobile_var_content_spc . 'px;' : '');
                }
                if (isset($automobile_var_content_textr) && $automobile_var_content_textr != '') {
                    echo esc_html($automobile_var_content_textr != '' ? 'text-transform: ' . $automobile_var_content_textr . ';' : '');
                }
                if (isset($automobile_var_text_color) && $automobile_var_text_color != '') {
                    echo esc_html($automobile_var_text_color != '' ? 'color: ' . $automobile_var_text_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }
        if ((isset($automobile_var_logo_margint) && $automobile_var_logo_margint != '') || (isset($automobile_var_logo_marginr) && $automobile_var_logo_marginr != '') || (isset($automobile_var_logo_marginb) && $automobile_var_logo_marginb != '') || (isset($automobile_var_logo_marginl) && $automobile_var_logo_marginl != '')) {
            ?>
            header .cs-logo {
            <?php if (isset($automobile_var_logo_margint) && $automobile_var_logo_margint != '') { ?>
                margin-top:<?php echo automobile_allow_special_char($automobile_var_logo_margint); ?>px;
            <?php } if (isset($automobile_var_logo_marginr) && $automobile_var_logo_marginr != '') { ?>
                margin-right:<?php echo automobile_allow_special_char($automobile_var_logo_marginr); ?>px;
            <?php } if (isset($automobile_var_logo_marginb) && $automobile_var_logo_marginb != '') { ?>
                margin-bottom:<?php echo automobile_allow_special_char($automobile_var_logo_marginb); ?>px;
            <?php }if (isset($automobile_var_logo_marginl) && $automobile_var_logo_marginl != '') { ?>
                margin-left:<?php echo automobile_allow_special_char($automobile_var_logo_marginl); ?>px;
            <?php } ?>

            }
            <?php
        }
        if ((isset($automobile_var_mainmenu_size) && $automobile_var_mainmenu_size != '') || (isset($automobile_var_mainmenu_spc) && $automobile_var_mainmenu_spc != '') || (isset($automobile_var_mainmenu_textr) && $automobile_var_mainmenu_textr != '')) {
            ?>

            #header .main-navigation > ul > li > a, #header .main-navigation > ul > li{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_mainmenu_size) && $automobile_var_mainmenu_size != '') {
                    echo 'font-size: ' . $automobile_var_mainmenu_size . ';';
                }
                if (isset($automobile_var_mainmenu_spc) && $automobile_var_mainmenu_spc != '') {
                    echo esc_html($automobile_var_mainmenu_spc != '' ? 'letter-spacing: ' . $automobile_var_mainmenu_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_mainmenu_textr) && $automobile_var_mainmenu_textr != '') {
                    echo esc_html($automobile_var_mainmenu_textr != '' ? 'text-transform: ' . $automobile_var_mainmenu_textr . ' !important;' : '');
                }
                if (isset($automobile_var_menu_color) && $automobile_var_menu_color != '') {
                    echo esc_html($automobile_var_menu_color != '' ? 'color: ' . $automobile_var_menu_color . '' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_mainmenu_font_atts, $automobile_var_mainmenu_size, $automobile_var_mainmenu_lh, $automobile_var_mainmenu_font, true);
                if (isset($automobile_var_mainmenu_spc) && $automobile_var_mainmenu_spc != '') {
                    echo esc_html($automobile_var_mainmenu_spc != '' ? 'letter-spacing: ' . $automobile_var_mainmenu_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_mainmenu_textr) && $automobile_var_mainmenu_textr != '') {
                    echo esc_html($automobile_var_mainmenu_textr != '' ? 'text-transform: ' . $automobile_var_mainmenu_textr . ' !important;' : '');
                }
                if (isset($automobile_var_menu_color) && $automobile_var_menu_color != '') {
                    echo esc_html($automobile_var_menu_color != '' ? 'color: ' . $automobile_var_menu_color . '' : '');
                }
            }
            ?>
            }

            <?php
        }

        if ((isset($automobile_var_heading_1_size) && $automobile_var_heading_1_size != '') || (isset($automobile_var_heading_1_spc) && $automobile_var_heading_1_spc != '') || (isset($automobile_var_heading_1_textr) && $automobile_var_heading_1_textr != '') || (isset($automobile_var_heading_h1_color) && $automobile_var_heading_h1_color != '')) {
            ?>
            h1, h1 a{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_heading_1_size) && $automobile_var_heading_1_size != '') {
                    echo 'font-size: ' . $automobile_var_heading_1_size . ';';
                }
                if (isset($automobile_var_heading_1_spc) && $automobile_var_heading_1_spc != '') {
                    echo esc_html($automobile_var_heading_1_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_1_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_1_textr) && $automobile_var_heading_1_textr != '') {
                    echo esc_html($automobile_var_heading_1_textr != '' ? 'text-transform: ' . $automobile_var_heading_1_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h1_color) && $automobile_var_heading_h1_color != '') {
                    echo esc_html($automobile_var_heading_h1_color != '' ? 'color: ' . $automobile_var_heading_h1_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_heading1_font_atts, $automobile_var_heading_1_size, $automobile_var_heading_1_lh, $automobile_var_heading1_font, true);
                if (isset($automobile_var_heading_1_spc) && $automobile_var_heading_1_spc != '') {
                    echo esc_html($automobile_var_heading_1_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_1_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_1_textr) && $automobile_var_heading_1_textr != '') {
                    echo esc_html($automobile_var_heading_1_textr != '' ? 'text-transform: ' . $automobile_var_heading_1_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h1_color) && $automobile_var_heading_h1_color != '') {
                    echo esc_html($automobile_var_heading_h1_color != '' ? 'color: ' . $automobile_var_heading_h1_color . ' !important;' : '');
                }
            }
            ?>}
            <?php
        }
        if ((isset($automobile_var_heading_2_size) && $automobile_var_heading_2_size != '') || (isset($automobile_var_heading_2_spc) && $automobile_var_heading_2_spc != '') || (isset($automobile_var_heading_2_textr) && $automobile_var_heading_2_textr != '') || (isset($automobile_var_heading_h2_color) && $automobile_var_heading_h2_color != '')) {
            ?>
            h2, h2 a{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_heading_2_size) && $automobile_var_heading_2_size != '') {
                    echo 'font-size: ' . $automobile_var_heading_2_size . ';';
                }
                if (isset($automobile_var_heading_2_spc) && $automobile_var_heading_2_spc != '') {
                    echo esc_html($automobile_var_heading_2_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_2_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_2_textr) && $automobile_var_heading_2_textr != '') {
                    echo esc_html($automobile_var_heading_2_textr != '' ? 'text-transform: ' . $automobile_var_heading_2_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h2_color) && $automobile_var_heading_h2_color != '') {
                    echo esc_html($automobile_var_heading_h2_color != '' ? 'color: ' . $automobile_var_heading_h2_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_heading2_font_atts, $automobile_var_heading_2_size, $automobile_var_heading_2_lh, $automobile_var_heading2_font, true);
                if (isset($automobile_var_heading_2_spc) && $automobile_var_heading_2_spc != '') {
                    echo esc_html($automobile_var_heading_2_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_2_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_2_textr) && $automobile_var_heading_2_textr != '') {
                    echo esc_html($automobile_var_heading_2_textr != '' ? 'text-transform: ' . $automobile_var_heading_2_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h2_color) && $automobile_var_heading_h2_color != '') {
                    echo esc_html($automobile_var_heading_h2_color != '' ? 'color: ' . $automobile_var_heading_h2_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }
        if ((isset($automobile_var_heading_3_size) && $automobile_var_heading_3_size != '') || (isset($automobile_var_heading_3_spc) && $automobile_var_heading_3_spc != '') || (isset($automobile_var_heading_3_textr) && $automobile_var_heading_3_textr != '') || (isset($automobile_var_heading_h3_color) && $automobile_var_heading_h3_color != '')) {
            ?>
            h3, h3 a{ 
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_heading_3_size) && $automobile_var_heading_3_size != '') {
                    echo 'font-size: ' . $automobile_var_heading_3_size . ';';
                }
                if (isset($automobile_var_heading_3_spc) && $automobile_var_heading_3_spc != '') {
                    echo esc_html($automobile_var_heading_3_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_3_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_3_textr) && $automobile_var_heading_3_textr != '') {
                    echo esc_html($automobile_var_heading_3_textr != '' ? 'text-transform: ' . $automobile_var_heading_3_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h3_color) && $automobile_var_heading_h3_color != '') {
                    echo esc_html($automobile_var_heading_h3_color != '' ? 'color: ' . $automobile_var_heading_h3_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_heading3_font_atts, $automobile_var_heading_3_size, $automobile_var_heading_3_lh, $automobile_var_heading3_font, true);
                if (isset($automobile_var_heading_3_spc) && $automobile_var_heading_3_spc != '') {
                    echo esc_html($automobile_var_heading_3_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_3_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_3_textr) && $automobile_var_heading_3_textr != '') {
                    echo esc_html($automobile_var_heading_3_textr != '' ? 'text-transform: ' . $automobile_var_heading_3_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h3_color) && $automobile_var_heading_h3_color != '') {
                    echo esc_html($automobile_var_heading_h3_color != '' ? 'color: ' . $automobile_var_heading_h3_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }
        if ((isset($automobile_var_heading_4_size) && $automobile_var_heading_4_size != '') || (isset($automobile_var_heading_4_spc) && $automobile_var_heading_4_spc != '') || (isset($automobile_var_heading_4_textr) && $automobile_var_heading_4_textr != '') || (isset($automobile_var_heading_h4_color) && $automobile_var_heading_h4_color != '')) {
            ?>
            h4, h4 a{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_heading_4_size) && $automobile_var_heading_4_size != '') {
                    echo 'font-size: ' . $automobile_var_heading_4_size . ';';
                }
                if (isset($automobile_var_heading_4_spc) && $automobile_var_heading_4_spc != '') {
                    echo esc_html($automobile_var_heading_4_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_4_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_4_textr) && $automobile_var_heading_4_textr != '') {
                    echo esc_html($automobile_var_heading_4_textr != '' ? 'text-transform: ' . $automobile_var_heading_4_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h4_color) && $automobile_var_heading_h4_color != '') {
                    echo esc_html($automobile_var_heading_h4_color != '' ? 'color: ' . $automobile_var_heading_h4_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_heading4_font_atts, $automobile_var_heading_4_size, $automobile_var_heading_4_lh, $automobile_var_heading4_font, true);
                if (isset($automobile_var_heading_4_spc) && $automobile_var_heading_4_spc != '') {
                    echo esc_html($automobile_var_heading_4_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_4_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_4_textr) && $automobile_var_heading_4_textr != '') {
                    echo esc_html($automobile_var_heading_4_textr != '' ? 'text-transform: ' . $automobile_var_heading_4_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h4_color) && $automobile_var_heading_h4_color != '') {
                    echo esc_html($automobile_var_heading_h4_color != '' ? 'color: ' . $automobile_var_heading_h4_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }
        if ((isset($automobile_var_heading_5_size) && $automobile_var_heading_5_size != '') || (isset($automobile_var_heading_5_spc) && $automobile_var_heading_5_spc != '') || (isset($automobile_var_heading_5_textr) && $automobile_var_heading_5_textr != '') || (isset($automobile_var_heading_h5_color) && $automobile_var_heading_h5_color != '')) {
            ?>
            h5, h5 a{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_heading_5_size) && $automobile_var_heading_5_size != '') {
                    echo 'font-size: ' . $automobile_var_heading_5_size . ';';
                }
                if (isset($automobile_var_heading_5_spc) && $automobile_var_heading_5_spc != '') {
                    echo esc_html($automobile_var_heading_5_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_5_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_5_textr) && $automobile_var_heading_5_textr != '') {
                    echo esc_html($automobile_var_heading_5_textr != '' ? 'text-transform: ' . $automobile_var_heading_5_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h5_color) && $automobile_var_heading_h5_color != '') {
                    echo esc_html($automobile_var_heading_h5_color != '' ? 'color: ' . $automobile_var_heading_h5_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_heading5_font_atts, $automobile_var_heading_5_size, $automobile_var_heading_5_lh, $automobile_var_heading5_font, true);
                if (isset($automobile_var_heading_5_spc) && $automobile_var_heading_5_spc != '') {
                    echo esc_html($automobile_var_heading_5_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_5_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_5_textr) && $automobile_var_heading_5_textr != '') {
                    echo esc_html($automobile_var_heading_5_textr != '' ? 'text-transform: ' . $automobile_var_heading_5_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h5_color) && $automobile_var_heading_h5_color != '') {
                    echo esc_html($automobile_var_heading_h5_color != '' ? 'color: ' . $automobile_var_heading_h5_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }
        if ((isset($automobile_var_heading_6_size) && $automobile_var_heading_6_size != '') || (isset($automobile_var_heading_6_spc) && $automobile_var_heading_6_spc != '') || (isset($automobile_var_heading_6_textr) && $automobile_var_heading_6_textr != '') || (isset($automobile_var_heading_h6_color) && $automobile_var_heading_h6_color != '')) {
            ?>
            h6, h6 a{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_heading_6_size) && $automobile_var_heading_6_size != '') {
                    echo 'font-size: ' . $automobile_var_heading_6_size . ';';
                }
                if (isset($automobile_var_heading_6_spc) && $automobile_var_heading_6_spc != '') {
                    echo esc_html($automobile_var_heading_6_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_6_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_6_textr) && $automobile_var_heading_6_textr != '') {
                    echo esc_html($automobile_var_heading_6_textr != '' ? 'text-transform: ' . $automobile_var_heading_6_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h6_color) && $automobile_var_heading_h6_color != '') {
                    echo esc_html($automobile_var_heading_h6_color != '' ? 'color: ' . $automobile_var_heading_h6_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_heading6_font_atts, $automobile_var_heading_6_size, $automobile_var_heading_6_lh, $automobile_var_heading6_font, true);
                if (isset($automobile_var_heading_6_spc) && $automobile_var_heading_6_spc != '') {
                    echo esc_html($automobile_var_heading_6_spc != '' ? 'letter-spacing: ' . $automobile_var_heading_6_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_heading_6_textr) && $automobile_var_heading_6_textr != '') {
                    echo esc_html($automobile_var_heading_6_textr != '' ? 'text-transform: ' . $automobile_var_heading_6_textr . ' !important;' : '');
                }
                if (isset($automobile_var_heading_h6_color) && $automobile_var_heading_h6_color != '') {
                    echo esc_html($automobile_var_heading_h6_color != '' ? 'color: ' . $automobile_var_heading_h6_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }
        if ((isset($automobile_var_section_title_size) && $automobile_var_section_title_size != '') || (isset($automobile_var_section_title_spc) && $automobile_var_section_title_spc != '') || (isset($automobile_var_section_title_textr) && $automobile_var_section_title_textr != '') || (isset($automobile_var_section_title_color) && $automobile_var_section_title_color != '')) {
            ?>       
            .cs-element-title h2{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_section_title_size) && $automobile_var_section_title_size != '') {
                    echo 'font-size: ' . $automobile_var_section_title_size . ';';
                }
                if (isset($automobile_var_section_title_spc) && $automobile_var_section_title_spc != '') {
                    echo esc_html($automobile_var_section_title_spc != '' ? 'letter-spacing: ' . $automobile_var_section_title_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_section_title_textr) && $automobile_var_section_title_textr != '') {
                    echo esc_html($automobile_var_section_title_textr != '' ? 'text-transform: ' . $automobile_var_section_title_textr . ' !important;' : '');
                }
                if (isset($automobile_var_section_title_color) && $automobile_var_section_title_color != '') {
                    echo esc_html($automobile_var_section_title_color != '' ? 'color: ' . $automobile_var_section_title_color . ' !important;' : '');
                }
            } else {

                echo automobile_var_font_font_print($automobile_var_section_title_font_atts, $automobile_var_section_title_size, $automobile_var_section_title_lh, $automobile_var_section_title_font, true);
                if (isset($automobile_var_section_title_spc) && $automobile_var_section_title_spc != '') {
                    echo esc_html($automobile_var_section_title_spc != '' ? 'letter-spacing: ' . $automobile_var_section_title_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_section_title_textr) && $automobile_var_section_title_textr != '') {
                    echo esc_html($automobile_var_section_title_textr != '' ? 'text-transform: ' . $automobile_var_section_title_textr . ' !important;' : '');
                }
                if (isset($automobile_var_section_title_color) && $automobile_var_section_title_color != '') {
                    echo esc_html($automobile_var_section_title_color != '' ? 'color: ' . $automobile_var_section_title_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }

        if ((isset($automobile_var_post_title_size) && $automobile_var_post_title_size != '') || (isset($automobile_var_post_title_spc) && $automobile_var_post_title_spc != '') || (isset($automobile_var_post_title_textr) && $automobile_var_post_title_textr != '') || (isset($automobile_var_post_title_color) && $automobile_var_post_title_color != '')) {
            ?>
            .cs-post-title h3 a, .cs-post-title h2 a{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';

                if (isset($automobile_var_post_title_size) && $automobile_var_post_title_size != '') {
                    echo 'font-size: ' . $automobile_var_post_title_size . ';';
                }
                if (isset($automobile_var_post_title_spc) && $automobile_var_post_title_spc != '') {
                    echo esc_html($automobile_var_post_title_spc != '' ? 'letter-spacing: ' . $automobile_var_post_title_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_post_title_textr) && $automobile_var_post_title_textr != '') {
                    echo esc_html($automobile_var_post_title_textr != '' ? 'text-transform: ' . $automobile_var_post_title_textr . ' !important;' : '');
                }
                if (isset($automobile_var_post_title_color) && $automobile_var_post_title_color != '') {
                    echo esc_html($automobile_var_post_title_color != '' ? 'color: ' . $automobile_var_post_title_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_post_title_font_atts, $automobile_var_post_title_size, $automobile_var_post_title_lh, $automobile_var_post_title_font, true);
                if (isset($automobile_var_post_title_spc) && $automobile_var_post_title_spc != '') {
                    echo esc_html($automobile_var_post_title_spc != '' ? 'letter-spacing: ' . $automobile_var_post_title_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_post_title_textr) && $automobile_var_post_title_textr != '') {
                    echo esc_html($automobile_var_post_title_textr != '' ? 'text-transform: ' . $automobile_var_post_title_textr . ' !important;' : '');
                }
                if (isset($automobile_var_post_title_color) && $automobile_var_post_title_color != '') {
                    echo esc_html($automobile_var_post_title_color != '' ? 'color: ' . $automobile_var_post_title_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }
        if ((isset($automobile_var_page_title_size) && $automobile_var_page_title_size != '') || (isset($automobile_var_page_title_spc) && $automobile_var_page_title_spc != '') || (isset($automobile_var_page_title_textr) && $automobile_var_page_title_textr != '')) {
            ?>
            .cs-page-title h1{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_page_title_size) && $automobile_var_page_title_size != '') {
                    echo 'font-size: ' . $automobile_var_page_title_size . ';';
                }
                if (isset($automobile_var_page_title_spc) && $automobile_var_page_title_spc != '') {
                    echo esc_html($automobile_var_page_title_spc != '' ? 'letter-spacing: ' . $automobile_var_page_title_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_page_title_textr) && $automobile_var_page_title_textr != '') {
                    echo esc_html($automobile_var_page_title_textr != '' ? 'text-transform: ' . $automobile_var_page_title_textr . ' !important;' : '');
                }
                if (isset($automobile_var_page_title_color) && $automobile_var_page_title_color != '') {
                    echo esc_html($automobile_var_page_title_color != '' ? 'color: ' . $automobile_var_page_title_color . ' !important;' : '');
                }
            } else {

                echo automobile_var_font_font_print($automobile_var_page_title_font_atts, $automobile_var_page_title_size, $automobile_var_page_title_lh, $automobile_var_page_title_font, true);
                if (isset($automobile_var_page_title_spc) && $automobile_var_page_title_spc != '') {
                    echo esc_html($automobile_var_page_title_spc != '' ? 'letter-spacing: ' . $automobile_var_page_title_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_page_title_textr) && $automobile_var_page_title_textr != '') {
                    echo esc_html($automobile_var_page_title_textr != '' ? 'text-transform: ' . $automobile_var_page_title_textr . ' !important;' : '');
                }
                if (isset($automobile_var_page_title_color) && $automobile_var_page_title_color != '') {
                    echo esc_html($automobile_var_page_title_color != '' ? 'color: ' . $automobile_var_page_title_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }


        if ((isset($automobile_var_widget_heading_size) && $automobile_var_widget_heading_size != '') || (isset($automobile_var_widget_heading_spc) && $automobile_var_widget_heading_spc != '') || (isset($automobile_var_widget_title_color) && $automobile_var_widget_title_color != '')) {
            ?>
            .widget .widget-title h5{
            <?php
            if ($custom_font == true) {
                echo 'font-family: automobile_var_custom_font;';
                if (isset($automobile_var_widget_heading_size) && $automobile_var_widget_heading_size != '') {
                    echo 'font-size: ' . $automobile_var_widget_heading_size . ';';
                }
                if (isset($automobile_var_widget_heading_spc) && $automobile_var_widget_heading_spc != '') {
                    echo esc_html($automobile_var_widget_heading_spc != '' ? 'letter-spacing: ' . $automobile_var_widget_heading_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_widget_heading_textr) && $automobile_var_widget_heading_textr != '') {
                    echo esc_html($automobile_var_widget_heading_textr != '' ? 'text-transform: ' . $automobile_var_widget_heading_textr . ' !important;' : '');
                }
                if (isset($automobile_var_widget_title_color) && $automobile_var_widget_title_color != '') {
                    echo esc_html($automobile_var_widget_title_color != '' ? 'color: ' . $automobile_var_widget_title_color . ' !important;' : '');
                }
            } else {
                echo automobile_var_font_font_print($automobile_var_widget_heading_font_atts, $automobile_var_widget_heading_size, $automobile_var_widget_heading_lh, $automobile_var_widget_heading_font, true);
                if (isset($automobile_var_widget_heading_spc) && $automobile_var_widget_heading_spc != '') {
                    echo esc_html($automobile_var_widget_heading_spc != '' ? 'letter-spacing: ' . $automobile_var_widget_heading_spc . 'px !important;' : '');
                }
                if (isset($automobile_var_widget_heading_textr) && $automobile_var_widget_heading_textr != '') {
                    echo esc_html($automobile_var_widget_heading_textr != '' ? 'text-transform: ' . $automobile_var_widget_heading_textr . ' !important;' : '');
                }
                if (isset($automobile_var_widget_title_color) && $automobile_var_widget_title_color != '') {
                    echo esc_html($automobile_var_widget_title_color != '' ? 'color: ' . $automobile_var_widget_title_color . ' !important;' : '');
                }
            }
            ?>
            }
            <?php
        }


        if (isset($automobile_var_header_bgcolor) && $automobile_var_header_bgcolor != '') {
            ?>
            #header {
            background-color:<?php echo automobile_allow_special_char($automobile_var_header_bgcolor); ?> !important;
            }
            <?php
        }


        if (isset($automobile_var_submenu_color) && $automobile_var_submenu_color != '') {
            ?>
            .main-navigation > ul ul li > a {color:<?php echo automobile_allow_special_char($automobile_var_submenu_color); ?> !important;}
            <?php
        }
        if (isset($automobile_var_submenu_hover_color) && $automobile_var_submenu_hover_color != '') {
            ?>
            .main-navigation > ul ul li:hover  {
            background-color:<?php echo automobile_allow_special_char($automobile_var_submenu_bgcolor); ?> !important;}

            .main-navigation > ul ul li > a:hover  {
            color:<?php echo automobile_allow_special_char($automobile_var_submenu_hover_color); ?> !important;}

            <?php
        }


        if (isset($automobile_var_ft_widget_title_color) && $automobile_var_ft_widget_title_color != '') {
            ?>
			
            footer#footer .cs-footer-widgets .widget .widget-title h5{ color:<?php echo automobile_allow_special_char($automobile_var_ft_widget_title_color); ?> !important;}

            <?php
        }


        if (isset($automobile_var_menu_color) && $automobile_var_menu_color != '') {
            ?>
            .main-navigation > ul > li > a { color:<?php echo automobile_allow_special_char($automobile_var_menu_color); ?> !important;}
            .pinned .cs-cart a span {background:none !important; border-color:<?php echo automobile_allow_special_char($automobile_var_menu_color); ?> !important; color:<?php echo automobile_allow_special_char($automobile_var_menu_color); ?> !important;}
            <?php
        }
        if (isset($automobile_var_menu_active_color) && $automobile_var_menu_active_color != '') {
            ?>
            .main-navigation > ul > li:hover > a, .main-navigation > ul > li.current-menu-ancestor > a, .main-navigation > ul > li.current-menu-parent > a, .main-navigation > ul > li.current_page_item > a, .main-navigation > ul > li.current-menu-parent > ul.sub-dropdown >, .main-navigation ul li ul.sub-dropdown li.current-menu-parent.current-menu-parent > a, .main-navigation ul li ul.sub-dropdown li.current-menu-parent ul.sub-dropdown
            { color:<?php echo automobile_allow_special_char($automobile_var_menu_active_color); ?> !important; }
            <?php
        }
        if (isset($automobile_var_widget_color) && $automobile_var_widget_color != '') {
            ?>
            .page-sidebar .widget-title h3, .page-sidebar .widget-title h4, .page-sidebar .widget-title h5, .page-sidebar .widget-title h6{
            color:<?php echo automobile_allow_special_char($automobile_var_widget_color); ?> !important;
            }<?php
        }
        if (isset($automobile_var_widget_color) && $automobile_var_widget_color != '') {
            ?>
            .section-sidebar .widget-title h3, .section-sidebar .widget-title h4, .section-sidebar .widget-title h5, .section-sidebar .widget-title h6{
            color:<?php echo automobile_allow_special_char($automobile_var_widget_color); ?> !important;
            }
        <?php } ?>



        <?php
        /**
         * @Set Footer Colors
         *
         *
         */
        $automobile_var_footerbg_color = (isset($automobile_var_options['automobile_var_footerbg_color']) and $automobile_var_options['automobile_var_footerbg_color'] <> '') ? $automobile_var_options['automobile_var_footerbg_color'] : '';
        $automobile_var_copyright_bg_color = (isset($automobile_var_options['automobile_var_copyright_bg_color']) and $automobile_var_options['automobile_var_copyright_bg_color'] <> '') ? $automobile_var_options['automobile_var_copyright_bg_color'] : '';
        $automobile_var_widget_bg_color = (isset($automobile_var_options['automobile_var_widget_bg_color']) and $automobile_var_options['automobile_var_widget_bg_color'] <> '') ? $automobile_var_options['automobile_var_widget_bg_color'] : '';

        $automobile_var_footerbg_image = (isset($automobile_var_options['automobile_var_footer_background_image']) and $automobile_var_options['automobile_var_footer_background_image'] <> '') ? $automobile_var_options['automobile_var_footer_background_image'] : '';

        $automobile_var_footer_text_color = (isset($automobile_var_options['automobile_var_footer_text_color']) and $automobile_var_options['automobile_var_footer_text_color'] <> '') ? $automobile_var_options['automobile_var_footer_text_color'] : '';
        $automobile_var_link_color = (isset($automobile_var_options['automobile_var_link_color']) and $automobile_var_options['automobile_var_link_color'] <> '') ? $automobile_var_options['automobile_var_link_color'] : '';
        $automobile_var_sub_footerbg_color = (isset($automobile_var_options['automobile_var_sub_footerbg_color']) and $automobile_var_options['automobile_var_sub_footerbg_color'] <> '') ? $automobile_var_options['automobile_var_sub_footerbg_color'] : '';

        $automobile_var_copyright_text_color = (isset($automobile_var_options['automobile_var_copyright_text_color']) and $automobile_var_options['automobile_var_copyright_text_color'] <> '') ? $automobile_var_options['automobile_var_copyright_text_color'] : '';

        $automobile_var_copyright_bg_color = (isset($automobile_var_options['automobile_var_copyright_bg_color']) and $automobile_var_options['automobile_var_copyright_bg_color'] <> '') ? $automobile_var_options['automobile_var_copyright_bg_color'] : '';

        if (isset($automobile_var_footerbg_color) && $automobile_var_footerbg_color != '') {
            ?>
            #footer { background-color:<?php echo automobile_allow_special_char($automobile_var_footerbg_color); ?> !important; }
            <?php
        }
        if (isset($automobile_var_sub_footerbg_color) && $automobile_var_sub_footerbg_color != '') {
            ?>
            footer#footer-sec, footer.group:before { background-color:<?php echo automobile_allow_special_char($automobile_var_sub_footerbg_color); ?> !important; }
            <?php
        }
        if (isset($automobile_var_footer_text_color) && $automobile_var_footer_text_color != '') {
            ?>
            footer#footer p, footer#footer span, footer#footer .textwidget {color:<?php echo automobile_allow_special_char($automobile_var_footer_text_color); ?> !important;}
            <?php
        }


        if (isset($automobile_var_copyright_bg_color) && $automobile_var_copyright_bg_color != '') {
            ?>.footer-btm {background-color:<?php echo automobile_allow_special_char($automobile_var_copyright_bg_color); ?> !important;}
            <?php
        }
        if (isset($automobile_var_copyright_text_color) && $automobile_var_copyright_text_color != '') {
            ?>
            footer#footer .copyright-text p{
            color:<?php echo automobile_allow_special_char($automobile_var_copyright_text_color); ?> !important;
            }
        <?php }if (isset($automobile_var_link_color) && $automobile_var_link_color != '') { ?>
            footer#footer a , footer#footer .copyright-text >p >a{
            color:<?php echo automobile_allow_special_char($automobile_var_link_color); ?> !important;
            }<?php
        }
        if (isset($automobile_var_copyright_bg_color) && $automobile_var_copyright_bg_color != '') {
            ?>
            footer#footer .cs-copyright {background-color:<?php echo automobile_allow_special_char($automobile_var_copyright_bg_color); ?> !important;}
            <?php
        }

        if (isset($automobile_var_widget_bg_color) && $automobile_var_widget_bg_color != '') {
            ?>
            footer#footer .cs-footer-widgets {background-color:<?php echo automobile_allow_special_char($automobile_var_widget_bg_color); ?> !important;}
            <?php
        }


        $automobile_var_custom_themeoption_str = ob_get_clean();
        return $automobile_var_custom_themeoption_str;
    }

}
