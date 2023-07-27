<?php

/**
 * Static string Return
 */
if (!function_exists('automobile_var_theme_text_srt')) {

    function automobile_var_theme_text_srt($str = '') {
        global $automobile_var_static_text;
        if (isset($automobile_var_static_text[$str])) {
            return $automobile_var_static_text[$str];
        }
    }

}
if (!class_exists('automobile_theme_all_strings')) {

    class automobile_theme_all_strings {

        public function __construct() {

            $this->automobile_theme_strings();
        }

        public function automobile_theme_option_strings() {
            global $automobile_var_static_text;
            /*
             * Theme Options
             */
            // echo 'automobile';exit;
            $automobile_var_static_text['automobile_var_theme_option_save_msg'] = __('Saving changes...', 'automobile');
            $automobile_var_static_text['automobile_var_save_msg'] = __('Save All Settings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_reset_msg'] = __('Reset All Options', 'automobile');
            $automobile_var_static_text['automobile_var_please_select'] = __('Please Select', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_breadcrumbs_sub_header'] = __('Breadcrumbs Sub Header', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_revolution_slider'] = __('Revolution Slider', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_no_sub_header'] = __('No sub Header', 'automobile');
            $automobile_var_static_text['automobile_var_general'] = __('General', 'automobile');
            $automobile_var_static_text['automobile_var_global'] = __('Global', 'automobile');
            $automobile_var_static_text['automobile_var_header'] = __('Header', 'automobile');
            $automobile_var_static_text['automobile_var_sub_header'] = __('Sub Header', 'automobile');
            $automobile_var_static_text['automobile_var_social_icons'] = __('Social icons', 'automobile');
            $automobile_var_static_text['automobile_var_social_sharing'] = __('Social sharing', 'automobile');
            $automobile_var_static_text['automobile_var_color'] = __('Color', 'automobile');
            $automobile_var_static_text['automobile_var_heading'] = __('Headings', 'automobile');
            /*
             * Global Setting 
             */

            $automobile_var_static_text['automobile_var_ads_unit_settings'] = __('Ads Unit Settings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_favicon'] = __('Custom favicon', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_favicon_hint'] = __('Custom favicon for your site', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_rtl'] = __('RTL', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_rtl_hint'] = __('Turn RTL On/Off here for Right to Left languages like Arabic etc.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_responsive'] = __('Responsive', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_responsive_hint'] = __('Set responsive design layout for mobile devices On/Off here', 'automobile');
            $automobile_var_static_text['automobile_var_excerpt'] = __('Excerpt (in words)', 'automobile');
            $automobile_var_static_text['automobile_var_excerpt_hint'] = __('Set excerpt length/limit from here. It controls text limit for all posts content', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_global_settings'] = __('Global Settings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_global_settings_hint'] = __('This is Global Settings.', 'automobile');
            $automobile_var_static_text['automobile_var_default_header_style'] = __('Default Header Style', 'automobile');
            $automobile_var_static_text['automobile_var_default_header_style_hint'] = __('Choose default header style for complete site', 'automobile');
            $automobile_var_static_text['automobile_var_default'] = __('Default', 'automobile');
            $automobile_var_static_text['automobile_var_std_default'] = __('default', 'automobile');
            $automobile_var_static_text['automobile_var_modern'] = __('Modern', 'automobile');
            $automobile_var_static_text['automobile_var_full_width'] = __('Full Width', 'automobile');			
            $automobile_var_static_text['automobile_var_logo'] = __('Logo', 'automobile');
            $automobile_var_static_text['automobile_var_logo_hint'] = __('Upload your custom logo in .png .jpg .gif formats only.', 'automobile');
            $automobile_var_static_text['automobile_var_logo_modern'] = __('Logo Modern', 'automobile');
            $automobile_var_static_text['automobile_var_logo_height'] = __('Logo Height', 'automobile');
            $automobile_var_static_text['automobile_var_logo_height_hint'] = __('Set exact logo height otherwise logo will not display normally.', 'automobile');
            $automobile_var_static_text['automobile_var_logo_width'] = __('Logo Width', 'automobile');
            $automobile_var_static_text['automobile_var_logo_width_hint'] = __('Set exact logo width otherwise logo will not display normally.', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_top'] = __('Logo margin top', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_top_hint'] = __('Logo spacing margin from top', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_bottom'] = __('Logo margin bottom', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_bottom_hint'] = __('Logo spacing margin from bottom.', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_right'] = __('Logo margin right', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_right_hint'] = __('Logo spacing margin from right.', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_left'] = __('Logo margin left', 'automobile');
            $automobile_var_static_text['automobile_var_logo_margin_left_hint'] = __('Logo spacing margin from left', 'automobile');

            $automobile_var_static_text['automobile_var_map_style'] = __('Map Style', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_hint'] = __('Select Map style for all Maps.', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_1'] = __('Map Box', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_2'] = __('Blue Water', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_3'] = __('Icy Blue', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_4'] = __('Bluish', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_5'] = __('Light Blue Water', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_6'] = __('Clad Me', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_7'] = __('Chilled', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_8'] = __('Two Tone', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_9'] = __('Light and Dark', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_10'] = __('Ilustracao', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_11'] = __('Flat Pale', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_12'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_map_style_13'] = __('Moret', 'automobile');
            /*
             * WooCommerce
             */
            $automobile_var_static_text['automobile_var_book_now_url'] = __('Book Now Url', 'automobile');
            $automobile_var_static_text['automobile_var_wooCommerce'] = __('WooCommerce', 'automobile');
            $automobile_var_static_text['automobile_var_wooCommerce_cart_icon'] = __('WooCommerce Cart Icon', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_wc_archive_sidebar'] = __('WooCommerce Archive Sidebar', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_wc_archive_sidebar_discription'] = __('Set Sidebar for WooCommerce Archive, Category etc', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_wc_archive_sidebar_hint'] = __('Select Sidebar for WooCommerce Archive, Category etc', 'automobile');
            /*
             *
             * Sub Header
             */
            $automobile_var_static_text['automobile_var_default_sub_header'] = __('Default Sub Header', 'automobile');
            $automobile_var_static_text['automobile_var_default_sub_header_hint'] = __('Sub Header settings made here will be implemented on all pages.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_header_border_color'] = __('Header Border Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_revolution_slider_hint'] = __('Please select Revolution Slider if already included in package. Otherwise buy Sliders from Code canyon But its optional', 'automobile');
            $automobile_var_static_text['automobile_var_style'] = __('Style', 'automobile');
            $automobile_var_static_text['automobile_var_classic'] = __('Classic', 'automobile');
            $automobile_var_static_text['automobile_var_with_background_image'] = __('With Background Image', 'automobile');
            $automobile_var_static_text['automobile_var_padding_top'] = __('Padding Top', 'automobile');
            $automobile_var_static_text['automobile_var_sub_header_padding_top_hint'] = __('Set custom padding for sub header content top area.', 'automobile');
            $automobile_var_static_text['automobile_var_padding_bottom'] = __('Padding Bottom', 'automobile');
            $automobile_var_static_text['automobile_var_sub_header_padding_bottom_hint'] = __('Set custom padding for sub header content bottom area.', 'automobile');
            $automobile_var_static_text['automobile_var_margin_top'] = __('Margin Top', 'automobile');
            $automobile_var_static_text['automobile_var_sub_header_margin_top_hint'] = __('Set custom Margin for sub header content top area.', 'automobile');
            $automobile_var_static_text['automobile_var_margin_bottom'] = __('Margin Bottom', 'automobile');
            $automobile_var_static_text['automobile_var_margin_bottom_hint'] = __('Set custom Margin for sub header content bottom area.', 'automobile');
            $automobile_var_static_text['automobile_var_page_title'] = __('Page Title', 'automobile');
            $automobile_var_static_text['automobile_var_text_color'] = __('Content Color', 'automobile');
            $automobile_var_static_text['automobile_var_breadcrumbs'] = __('Breadcrumbs', 'automobile');
            $automobile_var_static_text['automobile_var_sub_heading'] = __('Sub Heading', 'automobile');
            $automobile_var_static_text['automobile_var_bg_image_hint'] = __('Upload background image in .png .jpg .gif formats only.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_parallax'] = __('Parallax', 'automobile');
	    $automobile_var_static_text['automobile_var_theme_option_transparent'] = __('Transparent Header', 'automobile');
	    $automobile_var_static_text['automobile_var_theme_option_sticky'] = __('Sticky Header', 'automobile');
	    $automobile_var_static_text['automobile_var_theme_option_transparent_inventory'] = __('Transparent header on Inventory detail page', 'automobile');
            /*
             * Footer Options
             */
            $automobile_var_static_text['automobile_var_footer_options'] = __('Footer options', 'automobile');
            $automobile_var_static_text['automobile_var_footer_section'] = __('Footer section', 'automobile');
            $automobile_var_static_text['automobile_var_footer_section_hint'] = __('enable/disable footer area', 'automobile');
            $automobile_var_static_text['automobile_var_footer_widgets'] = __('Footer Widgets', 'automobile');
            $automobile_var_static_text['automobile_var_footer_widgets_hint'] = __('enable/disable footer widget area', 'automobile');
            $automobile_var_static_text['automobile_var_copy_write_section'] = __('Copy Write Section', 'automobile');
            $automobile_var_static_text['automobile_var_copy_write_section_hint'] = __('enable/disable Copy Write Section', 'automobile');
            $automobile_var_static_text['automobile_var_copyright_text'] = __('Copyright Text', 'automobile');
            $automobile_var_static_text['automobile_var_copyright_text_hint'] = __('write your own copyright text', 'automobile');
            $automobile_var_static_text['automobile_var_copyright_text_value'] = __('2015 automobile Name All rights reserved. Design by Chimp Studio', 'automobile');
            $automobile_var_static_text['automobile_var_contact_number'] = __('Contact Number', 'automobile');
            $automobile_var_static_text['automobile_var_contact_number_hint'] = __('Write your contact number', 'automobile');
            $automobile_var_static_text['automobile_var_contact_number_value'] = __('+0 (123) 456-789-10', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_back_to_top'] = __('Back to top', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_back_to_top_hint'] = __('Enable/disable footer back to top option.', 'automobile');
            /*
             * Colors
             */
            $automobile_var_static_text['automobile_var_theme_option_general_color'] = __('General Colors', 'automobile');
            $automobile_var_static_text['automobile_var_theme_color'] = __('Theme Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_color_hint'] = __('Choose theme skin color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_text_color'] = __('Body Text Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_text_color_hint'] = __('Choose text color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_header_color'] = __('Header colors', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_default_header_colors'] = __('Default Header Colors', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_default_header_colors_hint'] = __('Change Header background color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_menu_link_color'] = __('Menu Link color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_menu_link_color_hint'] = __('Change Header Menu Link color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_menu_hover_color'] = __('Menu Hover / Active Link color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_menu_hover_color_hint'] = __('Change Header Menu Active Link color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_submenu_hover_bg_color'] = __('Submenu Hover Background', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_submenu_hover_bg_color_hint'] = __('Change Submenu Hover Background color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_submenu_link_color'] = __('Submenu Link Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_submenu_link_color_hint'] = __('Change Submenu Link color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_submenu_hover_color'] = __('Submenu Hover / Active Link Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_submenu_hover_color_hint'] = __('Change Submenu Hover / Active Link color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_footer_color'] = __('footer colors', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_footer_bg_color'] = __('Footer Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_footer_text_color'] = __('Footer Text Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_footer_link_color'] = __('Footer Link Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_copyright_text_color'] = __('Copyright Text', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_widget_bg_color'] = __('Widget Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_copyright_bg_color'] = __('Copyright Background Color', 'automobile');

            /*
             * heading colors
             */
            $automobile_var_static_text['automobile_var_theme_option_heading_color'] = __('heading colors', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_heading_h1'] = __('heading h1', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_heading_h2'] = __('heading h2', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_heading_h3'] = __('heading h3', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_heading_h4'] = __('heading h4', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_heading_h5'] = __('heading h5', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_heading_h6'] = __('heading h6', 'automobile');
            $automobile_var_static_text['automobile_var_section_title'] = __('Section Title', 'automobile');
            $automobile_var_static_text['automobile_var_post_title'] = __('Post Title', 'automobile');
            $automobile_var_static_text['automobile_var_page_title'] = __('Page Title', 'automobile');
            $automobile_var_static_text['automobile_var_widget_title'] = __('Widgets Title', 'automobile');
            $automobile_var_static_text['automobile_var_footer_widget_title'] = __('Footer Widgets Title', 'automobile');
            /*
             * Custom Font
             */
            $automobile_var_static_text['automobile_var_theme_option_custom_font_woff'] = __('Custom Font .woff', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font_woff_hint'] = __('Upload Your Custom Font file in .woff format', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font_ttf'] = __('Custom Font .ttf', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font_ttf_hint'] = __('Upload Your Custom Font file in .ttf format', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font_svg'] = __('Custom Font .svg', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font_svg_hint'] = __('Upload Your Custom Font file in .svg format', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font_eot'] = __('Custom Font .eot', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font_eot_hint'] = __('Upload Your Custom Font file in .eot format', 'automobile');
            /*
             * Google Fonts
             */
            $automobile_var_static_text['automobile_var_theme_option_content_font'] = __('Content Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_content_font_discription'] = __('Set fonts for Body text', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_font_attribute'] = __('Font Attribute', 'automobile');
            $automobile_var_static_text['automobile_var_size'] = __('Size', 'automobile');
            $automobile_var_static_text['automobile_var_line_height'] = __('Line Height', 'automobile');
            $automobile_var_static_text['automobile_var_text_transform'] = __('Text Transform', 'automobile');
            $automobile_var_static_text['automobile_var_none'] = __('none', 'automobile');
            $automobile_var_static_text['automobile_var_capitalize'] = __('capitalize', 'automobile');
            $automobile_var_static_text['automobile_var_uppercase'] = __('uppercase', 'automobile');
            $automobile_var_static_text['automobile_var_lowercase'] = __('lowercase', 'automobile');
            $automobile_var_static_text['automobile_var_initial'] = __('initial', 'automobile');
            $automobile_var_static_text['automobile_var_inherit'] = __('inherit', 'automobile');
            $automobile_var_static_text['automobile_var_letter_spacing'] = __('Letter Spacing', 'automobile');
            $automobile_var_static_text['automobile_var_main_menu_font'] = __('Main Menu Font', 'automobile');
            $automobile_var_static_text['automobile_var_main_menu_font_hint'] = __('Set font for main Menu. It will be applied to sub menu as well', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_font_attribute_hint.'] = __('Set Font Attribute', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_Heading1_font'] = __('Heading 1 Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_Heading_font_hint'] = __('Select font for Headings. It will apply on all posts and pages headings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_Heading2_font'] = __('Heading 2 Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_Heading3_font'] = __('Heading 3 Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_Heading4_font'] = __('Heading 4 Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_Heading5_font'] = __('Heading 5 Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_Heading6_font'] = __('Heading 6 Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_section_title_font'] = __('Section Title Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_section_title_font_hint'] = __('Set font for Section Title Headings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_page_title_font'] = __('Page Title Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_font_page_title_hint'] = __('Set font for Page Title Headings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_post_title_font'] = __('Post Title Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_font_post_title_hint'] = __('Set font for Post Title Headings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_sidebar_widget_font'] = __('Sidebar Widget Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_sidebar_widget_font_hint'] = __('Set font for Widget Headings', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_footer_widget_font'] = __('Footer Widget Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_footer_widget_font_hint'] = __('Set font for Footer Widget Headings', 'automobile');
            /*
             * Social Network
             */
            $automobile_var_static_text['automobile_var_theme_option_social_network'] = __('Social Network', 'automobile');
            $automobile_var_static_text['automobile_var_fb'] = __('Facebook', 'automobile');
            $automobile_var_static_text['automobile_var_twitter'] = __('Twitter', 'automobile');
            $automobile_var_static_text['automobile_var_g_plus'] = __('Google Plus', 'automobile');
            $automobile_var_static_text['automobile_var_tumblr'] = __('Tumblr', 'automobile');
            $automobile_var_static_text['automobile_var_dribbble'] = __('Dribbble', 'automobile');
            $automobile_var_static_text['automobile_var_instagram'] = __('Instagram', 'automobile');
            $automobile_var_static_text['automobile_var_stumbleupon'] = __('StumbleUpon', 'automobile');
            $automobile_var_static_text['automobile_var_youtube'] = __('youtube', 'automobile');
            $automobile_var_static_text['automobile_var_share_more'] = __('share more', 'automobile');

            /*
             * Sidebar
             */
            $automobile_var_static_text['automobile_var_sidebar'] = __('Select Sidebar', 'automobile');
            $automobile_var_static_text['automobile_var_sidebar_name'] = __('Sidebar Name', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_sidebar_hint'] = __('Select a sidebar from the list already given. (Nine pre-made sidebars are given)', 'automobile');
            $automobile_var_static_text['automobile_var_default_pages'] = __('Default Pages', 'automobile');
            $automobile_var_static_text['automobile_var_default_pages_sidebar'] = __('Default Pages Sidebar', 'automobile');
            $automobile_var_static_text['automobile_var_default_pages_layout'] = __('Default Pages Layout', 'automobile');
            $automobile_var_static_text['automobile_var_default_pages_layout_hint'] = __('Set Sidebar for all pages like Search, Author Archive, Category Archive etc', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_default_pages_sidebar_hint'] = __('Select pre-made sidebars for default pages on sidebar layout. Full width layout cannot have sidebars', 'automobile');
            /**
             * Maintenance Mode
             */
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_hint'] = __('Turn Maintenance Mode On/Off here', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_logo_hint'] = __('Turn Logo On/Off here', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_social'] = __('Social Contact', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_social_hint'] = __('Turn Social Contact On/Off here', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_newsletter'] = __('Newsletter', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_newsletter_hint'] = __('Turn newsletter On/Off here', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_header'] = __('Header Switch', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_header_hint'] = __('Turn Header On/Off here', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_footer'] = __('Footer Switch', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_footer_hint'] = __('Turn Footer On/Off here', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_no_title'] = __('No Title', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_page'] = __('Maintenance Mode page', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintenance_mode_page_hint'] = __('Choose a page that you want to set for maintenance mode', 'automobile');
            /**
             * API Setting
             */
            $automobile_var_static_text['automobile_var_theme_option_mailchimp_key'] = __('Mail Chimp Key', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_mailchimp_key_hint'] = __('Enter a valid Mail Chimp API key here to get started. Once you\'\'ve done that, you can use the Mail Chimp Widget from the Widgets menu. You will need to have at least Mail Chimp list set up before the using the widget. You can get your mail chimp activation key', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_mailchimp_list'] = __('Mail Chimp List', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_flickr_api_setting'] = __('Flickr API Setting', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_flickr_key'] = __('Flickr key', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_flickr_key_hint'] = __('add your flickr key here.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_api_setting'] = __('Twitter API Setting', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_consumer_key'] = __('Consumer Key', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_consumer_key_hint'] = __('insert your consumer key here.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_cache_time_limit'] = __('Cache Time Limit', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_cache_time_limit_hint'] = __('Please enter the time limit in minutes for refresh cache.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_num'] = __('Number of tweet', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_num_hint'] = __('Please enter number of tweet that you get from twitter for chache file.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate'] = __('Date Time Formate', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate_hint'] = __('Select date time formate for every tweet.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate_1'] = __('Displays November 06 2012', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate_2'] = __('Displays 6th November', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate_3'] = __('Displays 06 Nov', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate_4'] = __('Displays 06 Nov 2012', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate_5'] = __('Displays Tues 06 Nov 2012', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_date_time_formate_6'] = __('Displays in hours, minutes etc', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_consumer_secret'] = __('Consumer Secret', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_consumer_secret_hint'] = __('insert your cunsumer secret key here.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_access_token'] = __('Access Token', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_access_token_hint'] = __('insert access token here.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_access_token_secret'] = __('Access Token Secret', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_twitter_access_token_secret_hint'] = __('insert access token secret here.', 'automobile');
			
			$automobile_var_static_text['automobile_var_theme_option_google_api_setting'] = __('Google', 'automobile');
			$automobile_var_static_text['automobile_var_theme_option_google_api_key'] = __('Google API Key', 'automobile');
            /**
             * import & export
             */
            $automobile_var_static_text['automobile_var_theme_option_import_export'] = __('import & export', 'automobile');
            $automobile_var_static_text['automobile_var_theme_backup_option'] = __('Theme Backup Options', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_backup'] = __('Backup', 'automobile');
            $automobile_var_static_text['automobile_var_widgets_backup_options'] = __('Widgets Backup Options', 'automobile');
            $automobile_var_static_text['automobile_var_widgets_backup'] = __('Widgets Backup', 'automobile');
            /**
             * Menu
             */
            $automobile_var_static_text['automobile_var_theme_option_typo_font'] = __('Typography / Fonts', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_font'] = __('Custom Font', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_google_font'] = __('Google Fonts', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_sidebar'] = __('Sidebar', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_footer_sidebar'] = __('Footer sidebar', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_maintaince_mode'] = __('MAINTENANCE MODE', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_api_setting'] = __('API Setting', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_layout'] = __('Layout', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_layout_type'] = __('Layout type', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_box'] = __('Boxed', 'automobile');
            $automobile_var_static_text['automobile_var_background'] = __('Background', 'automobile');
            $automobile_var_static_text['automobile_var_bgcolor'] = __('Background color', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_pattern'] = __('Pattern', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_custom_image'] = __('Custom Image', 'automobile');
            $automobile_var_static_text['automobile_var_background_image'] = __('Background image', 'automobile');
	    $automobile_var_static_text['automobile_var_top_image'] = __('Top image', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_bg_image_hint'] = __('Choose from Predefined Background images.', 'automobile');
	    $automobile_var_static_text['automobile_var_theme_option_image_hint'] = __('Choose from Predefined images.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_bg_pattern'] = __('Background pattern', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_bg_pattern_hint'] = __('Choose from Predefined Pattern images.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_bgcolor_hint'] = __('Provide a hex color code here (with #) for theme background color.', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_layout_hint'] = __('This option can be used only with Boxed Layout.', 'automobile');
            $automobile_var_static_text['automobile_var_bg_image_position'] = __('Background image position', 'automobile');
            $automobile_var_static_text['automobile_var_theme_option_bg_image_position_hint'] = __('Choose image position for body background', 'automobile');
            $automobile_var_static_text['automobile_var_no_repeat_center_top'] = __('no-repeat center top', 'automobile');
            $automobile_var_static_text['automobile_var_repeat_center_top'] = __('repeat center top', 'automobile');
	    $automobile_var_static_text['automobile_var_call_style_default'] = __('Default', 'automobile');
	    $automobile_var_static_text['automobile_var_call_style_classic'] = __('Classic', 'automobile');
            $automobile_var_static_text['automobile_var_no_repeat_center'] = __('no-repeat center', 'automobile');
            $automobile_var_static_text['automobile_var_repeat_center'] = __('Repeat Center', 'automobile');
            $automobile_var_static_text['automobile_var_no_repeat_left_top'] = __('no-repeat left top', 'automobile');
            $automobile_var_static_text['automobile_var_repeat_left_top'] = __('repeat left top', 'automobile');
            $automobile_var_static_text['automobile_var_no_repeat_fixed_center'] = __('no-repeat fixed center', 'automobile');
            $automobile_var_static_text['automobile_var_no_repeat_fixed_center_cover.'] = __('no-repeat fixed center / cover', 'automobile');
            $automobile_var_static_text['automobile_var_woocommerce_add_to_cart'] = __('add to cart', 'automobile');

            return $automobile_var_static_text;
        }

        public function automobile_theme_option_field_strings() {
            global $automobile_var_static_text;
            $automobile_var_static_text['automobile_var_demo'] = __('Demo', 'automobile');
            $automobile_var_static_text['automobile_var_import'] = __('Import', 'automobile');
            $automobile_var_static_text['automobile_var_import_options'] = __('Import Options', 'automobile');
            $automobile_var_static_text['automobile_var_location_and_hit_import_button'] = __('Input the URL from another location and hit Import Button to apply settings', 'automobile');
            $automobile_var_static_text['automobile_var_please_select_a_page'] = __('Please select a page', 'automobile');
            $automobile_var_static_text['automobile_var_export_options'] = __('Export Options', 'automobile');
            $automobile_var_static_text['automobile_var_restore'] = __('Restore', 'automobile');
            $automobile_var_static_text['automobile_var_error_saving_file'] = __('Error saving file!', 'automobile');
            $automobile_var_static_text['automobile_var_backup_generated'] = __('Backup Generated.', 'automobile');
            $automobile_var_static_text['automobile_var_file_deleted_successfully'] = __("File '%s' Deleted Successfully", 'automobile');
            $automobile_var_static_text['automobile_var_error_deleting_file'] = __('Error Deleting file!', 'automobile');
            $automobile_var_static_text['automobile_var_file_import_successfully'] = __('File Import Successfully', 'automobile');
            $automobile_var_static_text['automobile_var_error_restoring_file'] = __('Error Restoring file!', 'automobile');
            $automobile_var_static_text['automobile_var_file_restore_successfully'] = __("File '%s' Restore Successfully", 'automobile');
            $automobile_var_static_text['automobile_var_download_backups_hint'] = __('Here you can Generate/Download Backups. Also you can use these Backups to Restore settings.', 'automobile');
            $automobile_var_static_text['automobile_var_download'] = __('Download', 'automobile');
            $automobile_var_static_text['automobile_var_generate_backup'] = __('Generate Backup', 'automobile');
            $automobile_var_static_text['automobile_var_import_widgets'] = __('Import Widgets', 'automobile');
            $automobile_var_static_text['automobile_var_show_widget_settings'] = __('Show Widget Settings', 'automobile');
            $automobile_var_static_text['automobile_var_font_family'] = __('Font Family', 'automobile');
            $automobile_var_static_text['automobile_var_browse'] = __('Browse', 'automobile');
            $automobile_var_static_text['automobile_var_add_sidebar'] = __('Add Sidebar', 'automobile');
            $automobile_var_static_text['automobile_var_already_added_sidebar'] = __('Already Added Sidebars', 'automobile');
            $automobile_var_static_text['automobile_var_actions'] = __('Actions', 'automobile');
            $automobile_var_static_text['automobile_var_alert_msg'] = __('Are you sure! You want to delete this', 'automobile');
            $automobile_var_static_text['automobile_var_remove'] = __('Remove', 'automobile');
            $automobile_var_static_text['automobile_var_footer_sidebar_title'] = __('Please enter the desired title of Footer sidebar', 'automobile');
            $automobile_var_static_text['automobile_var_2column'] = __('2 Column (16.67%)', 'automobile');
            $automobile_var_static_text['automobile_var_3column'] = __('3 Column (25%)', 'automobile');
            $automobile_var_static_text['automobile_var_4column'] = __('4 Column (33.33%)', 'automobile');
            $automobile_var_static_text['automobile_var_6column'] = __('6 Column (50%)', 'automobile');
            $automobile_var_static_text['automobile_var_8column'] = __('8 Column (66.66%)', 'automobile');
            $automobile_var_static_text['automobile_var_9column'] = __('9 Column (75%)', 'automobile');
            $automobile_var_static_text['automobile_var_10column'] = __('10 Column (83.33%)', 'automobile');
            $automobile_var_static_text['automobile_var_12column'] = __('12 Column (100%)', 'automobile');
            $automobile_var_static_text['automobile_var_siderbar_name'] = __('SiderBar Name', 'automobile');
            $automobile_var_static_text['automobile_var_siderbar_width'] = __('Sider Bar Width', 'automobile');
            $automobile_var_static_text['automobile_var_icon_color'] = __('Icon Color', 'automobile');
            $automobile_var_static_text['automobile_var_add'] = __('Add', 'automobile');
            $automobile_var_static_text['automobile_var_already_added_social_icon'] = __('Already Added Social Icons', 'automobile');
            $automobile_var_static_text['automobile_var_network_name'] = __('Network Name', 'automobile');

            $automobile_var_static_text['automobile_var_export_widgets'] = __('Export Widgets', 'automobile');
            $automobile_var_static_text['automobile_var_default_font'] = __(' Default Font', 'automobile');
            $automobile_var_static_text['automobile_var_sticky_text'] = __('STICKY POST', 'automobile');
            return $automobile_var_static_text;
        }

        public function automobile_plugin_activation_strings() {
            global $automobile_var_static_text;
            $automobile_var_static_text['automobile_var_theme_option_revolution_slider'] = __('Revolution Slider', 'automobile');
            $automobile_var_static_text['automobile_var_notice_can_install_required'] = _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_can_install_recommended'] = _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_cannot_install'] = _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin.', 'Sorry, but you do not have the correct permissions to install the %s plugins.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_can_activate_required'] = _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_can_activate_recommended'] = _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_cannot_activate'] = _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin.', 'Sorry, but you do not have the correct permissions to activate the %s plugins.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_ask_to_update'] = _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_cannot_update'] = _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin.', 'Sorry, but you do not have the correct permissions to update the %s plugins.', 'automobile');
            $automobile_var_static_text['automobile_var_install_link'] = _n_noop('Begin installing plugin', 'Begin installing plugins', 'automobile');
            $automobile_var_static_text['automobile_var_activate_link'] = _n_noop('Begin activating plugin', 'Begin activating plugins', 'automobile');
            $automobile_var_static_text['automobile_var_sorry'] = _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'automobile');
            $automobile_var_static_text['automobile_var_sorry_not_permission'] = _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'automobile');
            $automobile_var_static_text['automobile_var_sorry_updated'] = _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'automobile');
            $automobile_var_static_text['automobile_var_activate_installed'] = _n_noop('Activate installed plugin', 'Activate installed plugins', 'automobile');
            $automobile_var_static_text['automobile_var_install_require_plugins'] = __('Install Required Plugins', 'automobile');
            $automobile_var_static_text['automobile_var_install_plugins'] = __('Install Plugins', 'automobile');
            /* Tgm New Strings */

            $automobile_var_static_text['automobile_var_updating_plugins'] = __('Updating Plugin: %s', 'automobile');
            $automobile_var_static_text['automobile_var_something_went_wrong'] = __('Something went wrong with the plugin API.', 'automobile');
            $automobile_var_static_text['automobile_var_ask_to_update_maybe'] = __('There is an update available for: %1$s. There are updates available for the following plugins: %1$s.', 'automobile');
            $automobile_var_static_text['automobile_var_update_link'] = __('Begin updating plugin Begin updating plugins', 'automobile');
            $automobile_var_static_text['automobile_var_plugin_needs_higher_version'] = __('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'automobile');
            $automobile_var_static_text['automobile_var_notice_cannot_install_activate'] = __('There are one or more required or recommended plugins to install, update or activate.', 'automobile');
            $automobile_var_static_text['automobile_var_plugin_need_to_be_updated'] = __('This plugin needs to be updated to be compatible with your theme.', 'automobile');
            $automobile_var_static_text['automobile_var_update_required'] = __('Update Required', 'automobile');

            $automobile_var_static_text['automobile_var_updated'] = __('updated', 'automobile');
            $automobile_var_static_text['automobile_var_version'] = __('Version', 'automobile');
            $automobile_var_static_text['automobile_var_upgrade_msg'] = __('Upgrade message from the plugin author:', 'automobile');
            $automobile_var_static_text['automobile_var_installed_no_action_taken'] = __('No plugins were selected to be installed. No action taken.', 'automobile');
            $automobile_var_static_text['automobile_var_updated_no_action_taken'] = __('No plugins were selected to be updated. No action taken.', 'automobile');

            $automobile_var_static_text['automobile_var_no_updated_at_this_time'] = __('No plugins are available to be updated at this time.', 'automobile');
            $automobile_var_static_text['automobile_var_install_at_this_time'] = __('No plugins are available to be installed at this time.', 'automobile');



            $automobile_var_static_text['automobile_var_no_plugin_install_update_activate'] = __('No plugins to install, update or activate.', 'automobile');
            $automobile_var_static_text['automobile_var_install_2s'] = __('Install %2$s', 'automobile');
            $automobile_var_static_text['automobile_var_update_2s'] = __('Update %2$s', 'automobile');
            $automobile_var_static_text['automobile_var_activate_2s'] = __('Activate %2$s', 'automobile');

            $automobile_var_static_text['automobile_var_activable_version'] = __('Available version:', 'automobile');
            $automobile_var_static_text['automobile_var_minimum_required_version'] = __('Minimum required version:', 'automobile');
            $automobile_var_static_text['automobile_var_install_version'] = __('Installed version:', 'automobile');
            $automobile_var_static_text['automobile_var_version_nr_unknown'] = _x('unknown', 'as in: "version nr unknown"', 'automobile');
            
            $automobile_var_static_text['automobile_var_install_update_status'] =  _x('%1$s, %2$s', 'Install/Update Status', 'automobile');
            $automobile_var_static_text['automobile_var_update_recommended'] = __('Update recommended', 'automobile');
            $automobile_var_static_text['automobile_var_requires_update_not_available'] = __('Required Update not Available', 'automobile');
            $automobile_var_static_text['automobile_var_active'] = __('Active', 'automobile');
            $automobile_var_static_text['automobile_var_requires_update'] = __('Requires Update', 'automobile');
            
            
            
            $automobile_var_static_text['automobile_var_updating_plugin_1s'] = __('Updating Plugin %1$s (%2$d/%3$d)', 'automobile');
            $automobile_var_static_text['automobile_var_error_occurred'] = __('An error occurred while installing %1$s: <strong>%2$s</strong>.', 'automobile');
            $automobile_var_static_text['automobile_var_updated'] = __('updated', 'automobile');
            $automobile_var_static_text['automobile_var_version'] = __('Version', 'automobile');
            $automobile_var_static_text['automobile_var_no_plugins_activated_at_time'] = __('No plugins are available to be activated at this time.', 'automobile');
            $automobile_var_static_text['automobile_var_no_plugins_activated'] = __('No plugins were selected to be activated. No action taken.', 'automobile');
            $automobile_var_static_text['automobile_var_plugina_pluginb'] = _x('and', 'plugin A *and* plugin B', 'automobile');
            $automobile_var_static_text['automobile_var_plugin_actived_successfully'] = __('The following plugin was activated successfully: The following plugins were activated successfully:', 'automobile');



            /**/
            $automobile_var_static_text['automobile_var_installing_plugins'] = __('Installing Plugin: %s', 'automobile');
            $automobile_var_static_text['automobile_var_something_wrong'] = __('Something went wrong.', 'automobile');
            $automobile_var_static_text['automobile_var_return'] = __('Return to Required Plugins Installer', 'automobile');
            $automobile_var_static_text['automobile_var_dashboard'] = __('Return to the dashboard', 'automobile');
            $automobile_var_static_text['automobile_var_plugin_activated'] = __('Plugin activated successfully.', 'automobile');
            $automobile_var_static_text['automobile_var_activated_successfully'] = __('The following plugin was activated successfully:', 'automobile');
            $automobile_var_static_text['automobile_var_complete'] = __('All plugins installed and activated successfully. %1$s', 'automobile');
            $automobile_var_static_text['automobile_var_dismiss'] = __('Dismiss this notice', 'automobile');
            $automobile_var_static_text['automobile_var_contact_admin'] = __('Please contact the administrator of this site for help.', 'automobile');
            $automobile_var_static_text['automobile_var_rename_failed'] = __('The remote plugin package is does not contain a folder with the desired slug and renaming did not work.', 'automobile');
            $automobile_var_static_text['automobile_var_plugin_provider'] = __('Please contact the plugin provider and ask them to package their plugin according to the WordPress guidelines.', 'automobile');
            $automobile_var_static_text['automobile_var_packaged_wrong'] = __('The remote plugin package consists of more than one file, but the files are not packaged in a folder.', 'automobile');
            $automobile_var_static_text['automobile_var_wordpress_guidelines'] = __('Please contact the plugin provider and ask them to package their plugin according to the WordPress guidelines.', 'automobile');
            $automobile_var_static_text['automobile_var_already_active'] = __('No action taken. Plugin %1$s was already active.', 'automobile');
            $automobile_var_static_text['automobile_var_external_source'] = __('External Source', 'automobile');
            $automobile_var_static_text['automobile_var_pre_packaged'] = __('Pre-Packaged', 'automobile');
            $automobile_var_static_text['automobile_var_repository'] = __('WordPress Repository', 'automobile');
            $automobile_var_static_text['automobile_var_required'] = __('Required', 'automobile');
            $automobile_var_static_text['automobile_var_recommended'] = __('Recommended', 'automobile');
            $automobile_var_static_text['automobile_var_not_installed'] = __('Not Installed', 'automobile');
            $automobile_var_static_text['automobile_var_installed_but'] = __('Installed But Not Activated', 'automobile');
            $automobile_var_static_text['automobile_var_no_plugins'] = __('No plugins to install or activate. Return to the Dashboard', 'automobile');
            $automobile_var_static_text['automobile_var_plugin'] = __('Plugin', 'automobile');
            $automobile_var_static_text['automobile_var_source'] = __('Source', 'automobile');
            $automobile_var_static_text['automobile_var_type'] = __('Type', 'automobile');
            $automobile_var_static_text['automobile_var_status'] = __('Status', 'automobile');
            $automobile_var_static_text['automobile_var_install'] = __('Install', 'automobile');
            $automobile_var_static_text['automobile_var_activate'] = __('Activate', 'automobile');
            $automobile_var_static_text['automobile_var_no_plugin_available'] = __('No plugins are available to be installed at this time', 'automobile');
            $automobile_var_static_text['automobile_var_no_package'] = __('Install package not available', 'automobile');
            $automobile_var_static_text['automobile_var_downloading_package'] = __('Downloading install package from %s', 'automobile');
            $automobile_var_static_text['automobile_var_unpack_package'] = __('Unpacking the package', 'automobile');
            $automobile_var_static_text['automobile_var_installing_package'] = __('Installing the plugin', 'automobile');
            $automobile_var_static_text['automobile_var_process_failed'] = __('Plugin install failed.', 'automobile');
            $automobile_var_static_text['automobile_var_process_success'] = __('Plugin installed successfully.', 'automobile');
            $automobile_var_static_text['automobile_var_activation_failed'] = __('Plugin activation failed.', 'automobile');
            $automobile_var_static_text['automobile_var_activation_success'] = __('Plugin activated successfully.', 'automobile');
            $automobile_var_static_text['automobile_var_skin_update_failed_error'] = __('An error occurred while installing %1$s: %2$s.', 'automobile');
            $automobile_var_static_text['automobile_var_skin_update_failed'] = __('The installation of %1$s failed.', 'automobile');
            $automobile_var_static_text['automobile_var_skin_upgrade_start'] = __('The installation and activation process is starting. This process may take a while on some hosts, so please be patient.', 'automobile');
            $automobile_var_static_text['automobile_var_skin_update_successful'] = __('%1$s installed and activated successfully.', 'automobile');
            $automobile_var_static_text['automobile_var_show_details'] = __('Show Details', 'automobile');
            $automobile_var_static_text['automobile_var_skin_upgrade_end'] = __('All installations and activations have been completed.', 'automobile');
            $automobile_var_static_text['automobile_var_skin_before_update_header'] = __('Installing and Activating Plugin %1$s (%2$d/%3$d)', 'automobile');
            $automobile_var_static_text['automobile_var_upgrade_start'] = __('The installation process is starting. This process may take a while on some hosts, so please be patient.', 'automobile');
            $automobile_var_static_text['automobile_var_hide_details'] = __('Hide Details', 'automobile');
            $automobile_var_static_text['automobile_var_update_successful'] = __('%1$s installed successfully.', 'automobile');
            $automobile_var_static_text['automobile_var_upgrade_end'] = __('All installations have been completed.', 'automobile');
            $automobile_var_static_text['automobile_var_before_update_header'] = __('Installing Plugin %1$s (%2$d/%3$d)', 'automobile');
            $automobile_var_static_text['automobile_var_framework'] = __('CS automobile Framework', 'automobile');
            $automobile_var_static_text['automobile_var_wrong'] = __('Something went wrong with the plugin API', 'automobile');
            return $automobile_var_static_text;
        }

        public function automobile_short_code_strings() {
            global $automobile_var_static_text;
            $automobile_var_static_text['automobile_var_element_title'] = __('Element Title', 'automobile');
            $automobile_var_static_text['automobile_var_element_title_hint'] = __('Enter element title here.', 'automobile');
            $automobile_var_static_text['automobile_var_element_sub_title'] = __('Element Sub Title', 'automobile');
            $automobile_var_static_text['automobile_var_element_sub_title_hint'] = __('Enter element sub title here.', 'automobile');

            $automobile_var_static_text['automobile_var_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_title_hint'] = __('Enter title here.', 'automobile');
            $automobile_var_static_text['automobile_var_title_color'] = __('Title Color', 'automobile');
            $automobile_var_static_text['automobile_var_title_color_hint'] = __('Set title color with this color picker.', 'automobile');

            $automobile_var_static_text['automobile_var_sel_col'] = __('Select Column', 'automobile');
            $automobile_var_static_text['automobile_var_col'] = __('Column', 'automobile');
            $automobile_var_static_text['automobile_var_sel_col_hint'] = __('Select Column view from this drop down', 'automobile');
            $automobile_var_static_text['automobile_var_sc_edit_msg'] = __('Edit Form Options', 'automobile');
            $automobile_var_static_text['automobile_var_image_field'] = __('Image', 'automobile');
            $automobile_var_static_text['automobile_var_image_hint'] = __('Select Image from media gallery with this button', 'automobile');

            $automobile_var_static_text['automobile_var_save'] = __('Save', 'automobile');
            $automobile_var_static_text['automobile_var_insert'] = __('Insert', 'automobile');
            $automobile_var_static_text['automobile_var_yes'] = __('Yes', 'automobile');
            $automobile_var_static_text['automobile_var_no'] = __('No', 'automobile');
            $automobile_var_static_text['automobile_var_text'] = __('Text', 'automobile');
            $automobile_var_static_text['automobile_var_edit_sitemap'] = __('Site Map Options', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_title_hint'] = __('Enter Section title here', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_edit'] = __('Icon Box Option', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_views'] = __('Views', 'automobile');
	    $automobile_var_static_text['automobile_var_icon_box_view_classic'] = __('Classic', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_views_hint'] = __('Set the Icon Box style', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_views_option_1'] = __('Simple', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_views_option_2'] = __('Top Center', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_title_hint'] = __('Enter Icon Box title here', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_title_color'] = __('Icon Box Title Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_title_color_hint'] = __('Set icon box title color here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_type'] = __('Icon Type', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_type_hint'] = __('Select icon type image or font icon.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_type_1'] = __('Icon', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_type_2'] = __('Image', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_image_hint'] = __('Attach image from media gallery.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon'] = __('Icon', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_hint'] = __('Select the Icon you would like to show with your accordian title.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size'] = __('Icon Font Size', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_hint'] = __('Set the Icon Font Size', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_option_1'] = __('Extra Small', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_option_2'] = __('Small', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_option_3'] = __('Medium', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_option_4'] = __('Medium Large', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_option_5'] = __('Large', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_option_6'] = __('Extra Large', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_font_size_option_7'] = __('Free Size', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_color'] = __('Icon Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_color_hint'] = __('Provide a hex colour code here (with #) for text color. if you want to override the default.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_title_link'] = __('Title Link', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_title_link_hint'] = __('Enter Icon Box title link here', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_content'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_content_hint'] = __('Enter the content here', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_content_color'] = __('Content Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_content_color_hint'] = __('Provide a hex colour code here (with #) for text color. if you want to override the default.', 'automobile');
            $automobile_var_static_text['automobile_var_multi_counter'] = __('Counter', 'automobile');
            $automobile_var_static_text['automobile_var_multi_counter_edit_options'] = __('Counter Options', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_title_hint'] = __('Enter Title Here', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_sub_title'] = __('Sub Title', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_sub_title_hint'] = __('Enter Sub Tiltle Here', 'automobile');
            $automobile_var_static_text['automobile_var_add_counter'] = __('Add Counter', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter'] = __('Counter', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_icon'] = __('Icon', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_icon_tooltip'] = __('Please Select Icon ', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_count'] = __('Count', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_count_tooltip'] = __('Enter Counter Range', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_content'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_content_tooltip'] = __('Enter Content Here', 'automobile');


            $automobile_var_static_text['automobile_var_multiple_counter_icon_color'] = __('Icon Color', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_icon_color_tooltip'] = __('Select Icon Color ', 'automobile');


            $automobile_var_static_text['automobile_var_multiple_counter_count_color'] = __('Count Color', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_count_color_tooltip'] = __('Select Count Color ', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_content_color'] = __('Content Color', 'automobile');
            $automobile_var_static_text['automobile_var_multiple_counter_content_color_tooltip'] = __('Select Content Color ', 'automobile');


            $automobile_var_static_text['automobile_var_published_by'] = __('published by', 'automobile');
            $automobile_var_static_text['automobile_var_view_all_posts_by'] = __('View all posts by ', 'automobile');
            $automobile_var_static_text['automobile_var_counter'] = __('Counter', 'automobile');
            $automobile_var_static_text['automobile_var_counter_hint'] = __('Enter counter author name here', 'automobile');
            $automobile_var_static_text['automobile_var_color_hint'] = __('Choose Color of Counter Text', 'automobile');
            $automobile_var_static_text['automobile_var_divider'] = __('Divider', 'automobile');
            $automobile_var_static_text['automobile_var_divider_hint'] = __('Divider setting on/off', 'automobile');
            $automobile_var_static_text['automobile_var_list_edit_option'] = __('List Options', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_title_hint'] = __('Enter list title here', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_sub_title'] = __('Sub Title', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_sub_title_hint'] = __('Enter list sub title here', 'automobile');
            $automobile_var_static_text['automobile_var_list_style'] = __('List Style', 'automobile');
            $automobile_var_static_text['automobile_var_list_style_hint'] = __('Choose list style from here.', 'automobile');
            $automobile_var_static_text['automobile_var_list_style_default'] = __('Default', 'automobile');
            $automobile_var_static_text['automobile_var_list_style_numeric'] = __('Numeric', 'automobile');
            $automobile_var_static_text['automobile_var_list_bullet'] = __('Bullet', 'automobile');
            $automobile_var_static_text['automobile_var_list_icon'] = __('Icon', 'automobile');
            $automobile_var_static_text['automobile_var_list_alphabetic'] = __('Alphabetic', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_item'] = __('List Title', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc'] = __('List', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_item_hint'] = __('Enter list title here.', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_icon'] = __('Icon', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_icon_color'] = __('Icon Color', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_icon_color_hint'] = __('Select icon color', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_icon_bg_color'] = __('Icon Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_icon_bg_color_hint'] = __('Select icon background color', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_icon_hint'] = __('Choose icon for list.', 'automobile');
            $automobile_var_static_text['automobile_var_list_sc_add_item'] = __('Add List Item', 'automobile');
            $automobile_var_static_text['automobile_var_ads_edit_options'] = __('Ads Options', 'automobile');
            $automobile_var_static_text['automobile_var_heading_edit_options'] = __('Headings Options', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_heading_style'] = __('Views', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_heading_style_hint'] = __('Select headings style with this dropdown. simple and one Fancy view. All headings font sizes,color and family can be change from theme options.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_heading_style_simple'] = __('Simple', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_heading_style_fancy'] = __('Fancy', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_fancy_heading'] = __('Fancy Heading', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_fancy_heading_hint'] = __('Enter text for fancy heading', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_title'] = __('Element Title', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_title_hint'] = __('Enter your element title here', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_sub_title'] = __('Element Sub Title', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_sub_title_hint'] = __('Enter your element sub title here', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_content'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_content_hint'] = __('Enter content here.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_font_size'] = __('Font Size', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_font_size_hint'] = __('Add font size for heading here.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_text_transform'] = __('Text Transform', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_text_transform_hint'] = __('Select style to heading. If you dont select heading it will display H1', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_capitalize'] = __('Capitalize', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_initial'] = __('Initial', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_inherit'] = __('Inherit', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_lowercase'] = __('Lowercase', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_none'] = __('None', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_uppercase'] = __('Uppercase', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_letter_spacing'] = __('Letter Spacing', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_letter_spacing_hint'] = __('Add letter spacing for heading here.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_bottom_margin'] = __('Bottom Margin', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_bottom_margin_hint'] = __('Enter heading bottom margin in numaric values only', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_line_height'] = __('Line Height', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_line_height_hint'] = __('Add line height for heading here.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_color'] = __('Element title color', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_color_hint'] = __('Choose element title color with this color picker.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_sub_title_color'] = __('Element sub title color', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_sub_title_color_hint'] = __('Select color title', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_content_color'] = __('Content Color', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_content_color_hint'] = __('select content color', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_type'] = __('Heading Style', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_type_hint'] = __('Select headings and style with this dropdown. H1 to H6 Headings and one Fancy view. All headings font sizes,color and family can be change from theme options.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_h1'] = __('H1', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_h2'] = __('H2', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_h3'] = __('H3', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_h4'] = __('H4', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_h5'] = __('H5', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_h6'] = __('H6', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_heading_align'] = __('Heading Align', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_heading_align_hint'] = __('Align the heading position with this dropdown.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_left'] = __('Left', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_right'] = __('Right', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_center'] = __('Center', 'automobile');

            $automobile_var_static_text['automobile_var_heading_sc_modern'] = __('Modern', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_classic'] = __('Classic', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_fancy'] = __('Fancy', 'automobile');		
			
            $automobile_var_static_text['automobile_var_heading_color'] = __('Heading Color', 'automobile');
            $automobile_var_static_text['automobile_var_heading_color_hint'] = __('Choose heading color with this color picker.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_divider'] = __('Divider On/Off', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_divider_hint'] = __('Set divider on/off for heading with this dropdown.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_yes'] = __('Yes', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_no'] = __('No', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_font_style'] = __('Font Style', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_font_style_hint'] = __('Select the font style here.', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_normal'] = __('Normal', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_italic'] = __('Italic', 'automobile');
            $automobile_var_static_text['automobile_var_heading_sc_oblique'] = __('Oblique', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_add_item'] = __('Add Team', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_name'] = __('Name', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_name_hint'] = __('Enter team member name here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_designation'] = __('Designation', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_designation_hint'] = __('Enter team member designation here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_image'] = __('Team Profile Image', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_image_hint'] = __('Select team member image from media gallery.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_phone'] = __('Phone No', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_phone_hint'] = __('Enter phone number here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_fb'] = __('Facebook', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_fb_hint'] = __('Enter facebook account link here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_twitter'] = __('Twitter', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_twitter_hint'] = __('Enter twitter account link here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_google'] = __('Google Plus', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_google_hint'] = __('Enter google+ accoount link here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_linkedin'] = __('Linkedin', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_linkedin_hint'] = __('Enter linkedin account link here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_youtube'] = __('Youtube', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_youtube_hint'] = __('Enter youtube link here.', 'automobile');
            $automobile_var_static_text['automobile_var_team_edit_options'] = __('Team Options', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_title'] = __('Element Title', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_title_hint'] = __('Enter Element Title Here', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_sub_title'] = __('Element Sub Title', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc_sub_title_hint'] = __('Enter Element Sub Title', 'automobile');
            $automobile_var_static_text['automobile_var_team_sc'] = __('Team', 'automobile');
            $automobile_var_static_text['automobile_var_call_to_action_edit'] = __('Call to Action Options', 'automobile');
            $automobile_var_static_text['automobile_var_short_text'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_short_text_hint'] = __('Enter Content here.', 'automobile');
            $automobile_var_static_text['automobile_var_text_color_hint'] = __('select content color with this color picker', 'automobile');
            $automobile_var_static_text['automobile_var_bg_color_hint'] = __('Define call to action background color with this color picker', 'automobile');
            $automobile_var_static_text['automobile_var_button_color'] = __('Button Text Color', 'automobile');


            $automobile_var_static_text['automobile_var_author_hint'] = __('Give the name of the quote author', 'automobile');
            $automobile_var_static_text['automobile_var_quote'] = __('Quote', 'automobile');
            $automobile_var_static_text['automobile_var_quote_edit'] = __('Blockquote OPTIONS', 'automobile');

            $automobile_var_static_text['automobile_var_dropcap_edit'] = __('Dropcap OPTIONS', 'automobile');
            $automobile_var_static_text['automobile_var_dropcaps_content_field_text'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_dropcaps_content_field_hint'] = __('Enter Content Here', 'automobile');




            $automobile_var_static_text['automobile_var_author_url'] = __('Author Url', 'automobile');
            $automobile_var_static_text['automobile_var_author_url_hint'] = __('Give the URL of author profile external/internal', 'automobile');


            $automobile_var_static_text['automobile_var_call_to_action_button_border'] = __('Button Border Color', 'automobile');
            $automobile_var_static_text['automobile_var_call_to_action_button_border_hint'] = __('Select Button Border color', 'automobile');

            $automobile_var_static_text['automobile_var_call_to_action_button_bg'] = __('Button Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_call_to_action_button_bg_hint'] = __('Select Button Background color', 'automobile');



            $automobile_var_static_text['automobile_var_button_color_hint'] = __('Set the button color for your call to action.', 'automobile');
            $automobile_var_static_text['automobile_var_button_text'] = __('Button Text', 'automobile');
            $automobile_var_static_text['automobile_var_button_text_hint'] = __('Enter text of the button.', 'automobile');
            $automobile_var_static_text['automobile_var_button_link'] = __('Button Link', 'automobile');
            $automobile_var_static_text['automobile_var_button_link_hint'] = __('Enter button link here.', 'automobile');
            $automobile_var_static_text['automobile_var_text_align'] = __('Text Align', 'automobile');
            $automobile_var_static_text['automobile_var_center_align'] = __('Center Align', 'automobile');
            $automobile_var_static_text['automobile_var_left_align'] = __('Left Align', 'automobile');
            $automobile_var_static_text['automobile_var_right_align'] = __('Right Align', 'automobile');
            $automobile_var_static_text['automobile_var_custom_id'] = __('Custom Id', 'automobile');
            $automobile_var_static_text['automobile_var_custom_id_hint'] = __('Use this option if you want to use specified id for this element.', 'automobile');
            $automobile_var_static_text['automobile_var_call_action'] = __('Call To Action', 'automobile');
            $automobile_var_static_text['automobile_var_image_position'] = __('Image Position', 'automobile');
	    $automobile_var_static_text['automobile_var_call_style'] = __('Choose Style', 'automobile');
            $automobile_var_static_text['automobile_var_client_edit_options'] = __('Clients Options', 'automobile');
            $automobile_var_static_text['automobile_var_client_element_title'] = __('Element title', 'automobile');
            $automobile_var_static_text['automobile_var_client_title_hint_text'] = __('Enter Element Title Here', 'automobile');
            $automobile_var_static_text['automobile_var_client_per_slide'] = __('Per Slide', 'automobile');
            $automobile_var_static_text['automobile_var_client_per_slide_hint_text'] = __('Enter the number of images to be shown for a row', 'automobile');
            $automobile_var_static_text['automobile_var_client_style'] = __('Client Style', 'automobile');
            $automobile_var_static_text['automobile_var_client_style_hint_text'] = __('Select the style for clients logos', 'automobile');
            $automobile_var_static_text['automobile_var_client_url'] = __('Client Url', 'automobile');
            $automobile_var_static_text['automobile_var_client_url_hint_text'] = __('Enter Url for Client logo', 'automobile');
            $automobile_var_static_text['automobile_var_client_image'] = __('Client Image', 'automobile');
            $automobile_var_static_text['automobile_var_client_url_image_hint_text'] = __('Enter The Image for Client', 'automobile');
            $automobile_var_static_text['automobile_var_client_url_add_clients'] = __('Add Client', 'automobile');
            $automobile_var_static_text['automobile_var_client_url_add_insert'] = __('Insert', 'automobile');
            $automobile_var_static_text['automobile_var_client_slider'] = __('Slider', 'automobile');
            $automobile_var_static_text['automobile_var_client_counter'] = __('Counter', 'automobile');
            $automobile_var_static_text['automobile_var_accordion'] = __('Accordion', 'automobile');
            $automobile_var_static_text['automobile_var_title_hint'] = __('Add your title here', 'automobile');
            $automobile_var_static_text['automobile_var_accordion_simple'] = __('Simple', 'automobile');
            $automobile_var_static_text['automobile_var_accordion_modern'] = __('Modern', 'automobile');
            $automobile_var_static_text['automobile_var_faq_simple'] = __('Simple', 'automobile');
            $automobile_var_static_text['automobile_var_faq_style'] = __('Faq Style', 'automobile');
            $automobile_var_static_text['automobile_var_accordion_views'] = __('View', 'automobile');
            $automobile_var_static_text['automobile_var_accordion_view_hint'] = __('select view for accordion', 'automobile');
            $automobile_var_static_text['automobile_var_faq_views'] = __('View', 'automobile');
            $automobile_var_static_text['automobile_var_faq_views_hint'] = __('select view for faq', 'automobile');
            $automobile_var_static_text['automobile_var_faq_icon_hint'] = __('select icon for faq', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_edit_options'] = __('Edit Tabs options', 'automobile');
            $automobile_var_static_text['automobile_var_margin_left'] = __('Margin Left', 'automobile');
            $automobile_var_static_text['automobile_var_margin_right'] = __('Margin Right', 'automobile');
            $automobile_var_static_text['automobile_var_margin_left_hint'] = __('Enter margin left without px', 'automobile');
            $automobile_var_static_text['automobile_var_margin_right_hint'] = __('Enter margin right without px', 'automobile');
            $automobile_var_static_text['automobile_var_sub_title_hint'] = __('Enter Sub Title Here', 'automobile');
            $automobile_var_static_text['automobile_var_accordion_edit_options'] = __('Accordion Options', 'automobile');
            $automobile_var_static_text['automobile_var_faq_edit_options'] = __('Faq Options', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_select_col'] = __('Columns', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_select_col_hint'] = __('Select No Of Columns', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_active'] = __('Active', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_active_hint'] = __('You can set the accordion section that is open by default on frontend by select dropdown', 'automobile');
            $automobile_var_static_text['automobile_var_faq_active_hint'] = __('You can set the faq section that is open by default on frontend by select dropdown', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_title_hint'] = __('enter title for your accordion', 'automobile');
            $automobile_var_static_text['automobile_var_faq_title_hint'] = __('enter title for your faq', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_q'] = __('Q.', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_descr'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_descr_hint'] = __('Enter content for acordion', 'automobile');
            $automobile_var_static_text['automobile_var_faq_descr_hint'] = __('Enter content for faq', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_add_accordian'] = __('Add Accordion', 'automobile');
            $automobile_var_static_text['automobile_var_add_faq'] = __('Add Faq', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_one_column'] = __('One Column', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_two_column'] = __('Two Column', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_three_column'] = __('Three Column', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_four_column'] = __('Four Column', 'automobile');
            $automobile_var_static_text['automobile_var_accordian_six_column'] = __('Six Column', 'automobile');
            $automobile_var_static_text['automobile_var_column_edit_options'] = __('Columns Options', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_title'] = __('Element Title', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_title_hint'] = __('Enter element title here.', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_text'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_text_hint'] = __('Enter content of the column', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_top_padding'] = __('Top Padding', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_top_padding_hint'] = __('Enter padding top without px.', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_bottom_padding'] = __('Bottom Padding', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_bottom_padding_hint'] = __('Enter padding bottom without px.', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_left_padding_text'] = __('Left Padding', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_left_padding_hint'] = __('Enter padding left without px.', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_right_padding_text'] = __('Right Padding', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_right_padding_hint'] = __('Enter padding right without px.', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_image_text'] = __('Background Image', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_image_hint'] = __('Select Image for column background.', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_color_text'] = __('Element Title Color', 'automobile');
            $automobile_var_static_text['automobile_var_column_field_background_color_text'] = __('Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_edit_form'] = __('Contact Form Options', 'automobile');
            $automobile_var_static_text['automobile_var_edit_schedule'] = __('Schedule Form Options', 'automobile');
            $automobile_var_static_text['automobile_var_best_time'] = __('Best time', 'automobile');
            $automobile_var_static_text['automobile_var_request_service'] = __('Request a service', 'automobile');
            $automobile_var_static_text['automobile_var_send_to'] = __('Receiver Email', 'automobile');
            $automobile_var_static_text['automobile_var_schedule_text'] = __('Schedule Services Hint Text', 'automobile');
            $automobile_var_static_text['automobile_var_schedule_text_hint'] = __('This hint text will show right side of schedule button.', 'automobile');
            $automobile_var_static_text['automobile_var_send_to_hint'] = __('Receiver, or receivers of the mail.', 'automobile');
            $automobile_var_static_text['automobile_var_success_message'] = __('Success Message', 'automobile');
            $automobile_var_static_text['automobile_var_success_message_hint'] = __('Enter Mail Successfully Send Message.', 'automobile');
            $automobile_var_static_text['automobile_var_error_message'] = __('Error Message', 'automobile');
            $automobile_var_static_text['automobile_var_error_message_hint'] = __('Enter Error Message In any case Mail Not Submited.', 'automobile');
            $automobile_var_static_text['automobile_var_contact_us'] = __('Contact Us', 'automobile');
            $automobile_var_static_text['automobile_var_contact_full_name'] = __('Full Name', 'automobile');
            $automobile_var_static_text['automobile_var_contact_email'] = __('Email Address', 'automobile');
            $automobile_var_static_text['automobile_var_contact_phone_number'] = __('Phone Number', 'automobile');
            $automobile_var_static_text['automobile_var_make_model'] = __('Make/Model', 'automobile');
            $automobile_var_static_text['automobile_var_mileage'] = __('Mileage (optional)', 'automobile');
            $automobile_var_static_text['automobile_var_contact_check_field'] = __('Subscribe and Get latest updates and offers by Email', 'automobile');
            $automobile_var_static_text['automobile_var_contact_message'] = __('I am interested in a price quote on this vehicle. Please contact me at you earliest convenience with your best price for this vehicle', 'automobile');
            $automobile_var_static_text['automobile_var_contact_button_text'] = __('Contact Dealer', 'automobile');
            $automobile_var_static_text['automobile_var_contact_required_fields_error_msg'] = __(' *ERROR: please fill the required fields.', 'automobile');
            $automobile_var_static_text['automobile_var_contact_default_success_msg'] = __('Email has been sent Successfully', 'automobile');
            $automobile_var_static_text['automobile_var_contact_default_error_msg'] = __('An error Occured, please try again later', 'automobile');
            $automobile_var_static_text['automobile_var_contact_ip_address'] = __('IP Address:', 'automobile');
            $automobile_var_static_text['automobile_var_contact_received'] = __('Contact Form Received', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_edit_options'] = __('Tabs Options', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_tabs_style'] = __('Tab Style', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_vertical_style'] = __('Vertical', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_horizontal_style'] = __('Horizontal', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_tabs_style_hint'] = __('Select your tabs style', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_active'] = __('Active', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_active_hint'] = __('You can set the tab section that is open by default on frontend by select dropdown', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_item_text'] = __('Tab Title', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_item_text_hint'] = __('Enter tab title here.', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_descr'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_descr_hint'] = __('Enter the tab content here.', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_add_accordian'] = __('Image', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_insert'] = __('Image', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_tabs'] = __('Tab', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_remove'] = __('Remove', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_icon'] = __('Tab Icon', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_add_tab'] = __('Add Tab', 'automobile');
            $automobile_var_static_text['automobile_var_tabs_icon_hint'] = __('Select the Icons you would like to show with your Tabs .', 'automobile');
            $automobile_var_static_text['automobile_var_map'] = __('Map', 'automobile');
            $automobile_var_static_text['automobile_var_edit_map_options'] = __('Map Options', 'automobile');
            $automobile_var_static_text['automobile_var_map_height'] = __('Height', 'automobile');
            $automobile_var_static_text['automobile_var_map_height_hint'] = __('Map height set here', 'automobile');
            $automobile_var_static_text['automobile_var_latitude'] = __('Latitude', 'automobile');
            $automobile_var_static_text['automobile_var_latitude_hint'] = __('Latitude is the angular distance of a place north or south of the earths equator, or of the equator of a celestial object, usually expressed in degrees and minutes.', 'automobile');
            $automobile_var_static_text['automobile_var_longitude'] = __('Longitude', 'automobile');
            $automobile_var_static_text['automobile_var_longitude_hint'] = __('Longitude the angular distance of a place east or west of the Greenwich meridian, or west of the standard meridian of a celestial object, usually expressed in degrees and minutes.', 'automobile');
            $automobile_var_static_text['automobile_var_zoom'] = __('Zoom', 'automobile');
            $automobile_var_static_text['automobile_var_zoom_hint'] = __('Set map zoom level example 10 or leave it empty by deafult will be apply.', 'automobile');
            $automobile_var_static_text['automobile_var_map_types'] = __('Map Types', 'automobile');
            $automobile_var_static_text['automobile_var_map_types_hint'] = __('Choose map type with this dropdown', 'automobile');
            $automobile_var_static_text['automobile_var_roadmap'] = __('ROADMAP', 'automobile');
            $automobile_var_static_text['automobile_var_hybrid'] = __('HYBRID', 'automobile');
            $automobile_var_static_text['automobile_var_satellite'] = __('SATELLITE', 'automobile');
            $automobile_var_static_text['automobile_var_terrain'] = __('TERRAIN', 'automobile');
            $automobile_var_static_text['automobile_var_info_text'] = __('Info Text', 'automobile');
            $automobile_var_static_text['automobile_var_info_text_hint'] = __('Enter info text for marker.', 'automobile');
            $automobile_var_static_text['automobile_var_info_text_width'] = __('Info Text Width', 'automobile');
            $automobile_var_static_text['automobile_var_info_text_width_hint'] = __('Set info text max width here.', 'automobile');
            $automobile_var_static_text['automobile_var_info_text_height'] = __('Info Text Height', 'automobile');
            $automobile_var_static_text['automobile_var_info_text_height_hint'] = __('Set info text max height here.', 'automobile');
            $automobile_var_static_text['automobile_var_marker_icon_path'] = __('Marker Icon', 'automobile');
            $automobile_var_static_text['automobile_var_marker_icon_path_hint'] = __('Select the Marker Icon Path for element.', 'automobile');
            $automobile_var_static_text['automobile_var_show_marker'] = __('Show Marker', 'automobile');
            $automobile_var_static_text['automobile_var_show_marker_hint'] = __('This switch on/off marker from the map.', 'automobile');
            $automobile_var_static_text['automobile_var_on'] = __('On', 'automobile');
            $automobile_var_static_text['automobile_var_off'] = __('Off', 'automobile');
            $automobile_var_static_text['automobile_var_disable_map_controls'] = __('Disable Controls', 'automobile');
            $automobile_var_static_text['automobile_var_disable_map_controls_hint'] = __('Map control disable/enable with this dropdown.', 'automobile');
            $automobile_var_static_text['automobile_var_drage_able'] = __('Draggable', 'automobile');
            $automobile_var_static_text['automobile_var_drage_able_hint'] = __('Draggable On/Off in map.', 'automobile');
            $automobile_var_static_text['automobile_var_scroll_wheel'] = __('Scroll Wheel', 'automobile');
            $automobile_var_static_text['automobile_var_scroll_wheel_hint'] = __('Set Scroll wheel zoom in zoom out enable disable from this dropdown.', 'automobile');
            $automobile_var_static_text['automobile_var_map_border'] = __('Border', 'automobile');
            $automobile_var_static_text['automobile_var_map_border_hint'] = __('Set border for map', 'automobile');
            $automobile_var_static_text['automobile_var_border_color'] = __('Border Color', 'automobile');
            $automobile_var_static_text['automobile_var_border_color_hint'] = __('Choose map border color.', 'automobile');
            $automobile_var_static_text['automobile_var_button_edit_text'] = __('Buttons Options', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_text'] = __('Label', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_text_hint'] = __('Add button text here', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_url'] = __('Link', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_url_hint'] = __('Enter button link/url here', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_top'] = __('Button Padding Top ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_top_hint'] = __('Enter button top padding for Button', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_bottom'] = __('Button Padding Bottom ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_bottom_hint'] = __('Enter button bottom padding ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_left'] = __('Button Padding Left ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_left_hint'] = __('Enter button Left padding ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_color'] = __('Lable Color ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_border_color'] = __('Border Color', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_border_color_hint'] = __('Define button border color with this color picker.', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_color_hint'] = __('Define button text color with this color picker.', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_right'] = __('Button Padding Right ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_padding_right_hint'] = __('Enter button padding Right ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_border'] = __('Enable Border ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_border_hint'] = __('Enable/Disable button border with this drop down.', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_type'] = __('Type ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_type_hint'] = __('Select button type with this dropdown two button types avaiable rounded and square', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_type_square'] = __('Square ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_type_rounded'] = __('Rounded ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_bg_color'] = __('Background Color ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_bg_color_hint'] = __('Define button border color with this color picker', 'automobile');
            $automobile_var_static_text['automobile_var_button_size'] = __('Size', 'automobile');
            $automobile_var_static_text['automobile_var_button_icon_on_off'] = __('Icon ON/OFF', 'automobile');
            $automobile_var_static_text['automobile_var_button_icon_on_off_hint'] = __('Set button icon on/off from this dropdown', 'automobile');
            $automobile_var_static_text['automobile_var_button_icon'] = __('Icon', 'automobile');
            $automobile_var_static_text['automobile_var_button_large'] = __('Large', 'automobile');
            $automobile_var_static_text['automobile_var_button_medium'] = __('Medium', 'automobile');
            $automobile_var_static_text['automobile_var_button_small'] = __('Small', 'automobile');
            $automobile_var_static_text['automobile_var_button_icon_hint'] = __('Select the Icons you would like to show in your button.', 'automobile');
            $automobile_var_static_text['automobile_var_button_size_hint'] = __('Select button size.Three sizes avaiable Large, Medium and Small', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_alignment'] = __('Icon Position ', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_alignment_hint'] = __('Select button icon position with this dropdown', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_alignment_left'] = __('Left', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_button_alignment_right'] = __('Right', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_target'] = __('Open link', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_target_hint'] = __('Select target type', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_target_blank'] = __('In same tab', 'automobile');
            $automobile_var_static_text['automobile_var_button_sc_target_self'] = __('In new tab', 'automobile');
            $automobile_var_static_text['automobile_var_image_edit_options'] = __('Image Frame Options', 'automobile');
            $automobile_var_static_text['automobile_var_image_field_name'] = __('Element Title', 'automobile');
            $automobile_var_static_text['automobile_var_image_field_name_hint'] = __('Enter element title here', 'automobile');
            $automobile_var_static_text['automobile_var_image_title'] = __('Image Title', 'automobile');
            $automobile_var_static_text['automobile_var_image_title_hint'] = __('Enter image title.', 'automobile');
            $automobile_var_static_text['automobile_var_image_field_url'] = __('Select Image ', 'automobile');
            $automobile_var_static_text['automobile_var_image_field_url_hint'] = __('Select image from media gallery with this button.', 'automobile');
            $automobile_var_static_text['automobile_var_image_field_caption'] = __('Caption', 'automobile');
            $automobile_var_static_text['automobile_var_image_field_caption_hint'] = __('Enter caption text', 'automobile');

            $automobile_var_static_text['automobile_var_image_field_desc'] = __('Image Description', 'automobile');
            $automobile_var_static_text['automobile_var_image_field_desc_hint'] = __('If you would like a caption to be shown below the image, add it here.', 'automobile');

            $automobile_var_static_text['automobile_var_testimonial_field_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_title_hint'] = __('Enter your title here.', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_subtitle'] = __('Sub title', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_subtitle_hint'] = __('Enter your sub title here.', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_text_color'] = __('Text Color', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_text_color_hint'] = __('Set text color here', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_text'] = __('Text', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_author_color'] = __('Author Color', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_position_color'] = __('Position Color', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_text_hint'] = __('Enter testimonial content here.', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_author'] = __('Author', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_author_hint'] = __('Enter testimonial author name here.', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_position'] = __('Position', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_position_hint'] = __('Enter position of author here.', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_image'] = __('Image', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_field_image_hint'] = __('Set author image from media gallery.', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial'] = __('Testimonial', 'automobile');
            $automobile_var_static_text['automobile_var_add_testimonial'] = __('Add Testimonial', 'automobile');
            $automobile_var_static_text['automobile_var_testimonial_edit'] = __('Testimonial options', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_left_padding'] = __('Padding Left', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_left_padding_hint'] = __('Set padding left for the divider in px.', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_right_padding'] = __('Padding Right', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_right_padding_hint'] = __('Set padding right for the divider in px.', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_top_margin'] = __('Margin Top', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_top_margin_hint'] = __('Set margin top for the divider in px.', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_bottom_margin'] = __('Margin Bottom', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_bottom_margin_hint'] = __('Set margin bottom for the divider in px.', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_align'] = __('Align', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_align_hint'] = __('Select Alignment Of Divider', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_views'] = __('Divider Views', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_views_hint'] = __('Select View of Divider', 'automobile');			
            $automobile_var_static_text['automobile_var_divider_edit'] = __('Divider Options', 'automobile');
            $automobile_var_static_text['automobile_var_edit_blog_items'] = __('Blog Options', 'automobile');
            $automobile_var_static_text['automobile_var_blog_section_hint'] = __('Enter your blog section title here.', 'automobile');
            $automobile_var_static_text['automobile_var_blog_cat_hint'] = __('Select category to show posts. If you dont select category it will display all posts.', 'automobile');
            $automobile_var_static_text['automobile_var_blog_design_views'] = __('Blog Design Views', 'automobile');
            $automobile_var_static_text['automobile_var_blog_design_views_hint'] = __('Select blog view from this drop down', 'automobile');
            $automobile_var_static_text['automobile_var_blog_grid'] = __('Grid', 'automobile');
            $automobile_var_static_text['automobile_var_blog_large'] = __('Large', 'automobile');
            $automobile_var_static_text['automobile_var_blog_medium'] = __('Medium', 'automobile');
	    $automobile_var_static_text['automobile_var_blog_classic'] = __('Classic', 'automobile');
            $automobile_var_static_text['automobile_var_blog_post_order'] = __('Post Order', 'automobile');
            $automobile_var_static_text['automobile_var_blog_post_order_hint'] = __('Arranging posts in ascending order and descending order with this dropdown.', 'automobile');
            $automobile_var_static_text['automobile_var_blog_asc'] = __('ASC', 'automobile');
            $automobile_var_static_text['automobile_var_blog_desc'] = __('DESC', 'automobile');
            $automobile_var_static_text['automobile_var_post_description'] = __('Post Description', 'automobile');
            $automobile_var_static_text['automobile_var_post_description_hint'] = __('Show/Hide post description with this dropdown.', 'automobile');
            $automobile_var_static_text['automobile_var_length_excerpt'] = __('Length of Excerpt', 'automobile');
            $automobile_var_static_text['automobile_var_length_excerpt_hint'] = __('Add number of excerpt words here for display on blog listing.', 'automobile');
            $automobile_var_static_text['automobile_var_post_per_page'] = __('No. of Post Per Page', 'automobile');
            $automobile_var_static_text['automobile_var_post_per_page_hint'] = __('Add number of post for show posts on page.', 'automobile');
            $automobile_var_static_text['automobile_var_blog_pagination'] = __('Pagination', 'automobile');
            $automobile_var_static_text['automobile_var_blog_pagination_hint'] = __('Pagination is the process of dividing a document into discrete pages. Manage your pagiantion via this dropdown.', 'automobile');
            $automobile_var_static_text['automobile_var_show_pagination'] = __('Show Pagination', 'automobile');
            $automobile_var_static_text['automobile_var_single_page'] = __('Single Page', 'automobile');
            $automobile_var_static_text['automobile_var_divider_field_align'] = __('Align', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_add'] = __('Add Icon Box', 'automobile');

            $automobile_var_static_text['automobile_var_icon_boxes'] = __('Icon Box', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_edit_options'] = __('Edit Multi icon Box options', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_title_hint'] = __('Enter your  title here', 'automobile');
            $automobile_var_static_text['automobile_var_multi_subtitle'] = __('Sub Title', 'automobile');
            $automobile_var_static_text['automobile_var_multi_subtitle_hint'] = __('Enter sub title here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_sel_col'] = __('Column', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_sel_col_hint'] = __('Select number of columns', 'automobile');
            $automobile_var_static_text['automobile_var_one_col'] = __('One Column', 'automobile');
            $automobile_var_static_text['automobile_var_two_col'] = __('Two Column', 'automobile');
            $automobile_var_static_text['automobile_var_three_col'] = __('Three Column', 'automobile');
            $automobile_var_static_text['automobile_var_four_col'] = __('Four Column', 'automobile');
            $automobile_var_static_text['automobile_var_six_col'] = __('Six Column', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_content_title'] = __('Content Title', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_content_title_hint'] = __('Add icon Box title here..', 'automobile');

            $automobile_var_static_text['automobile_var_icon_box_title'] = __('Icon Box Title', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_title_hint'] = __('Add icon box title here.', 'automobile');

            $automobile_var_static_text['automobile_var_icon_boxes_link_url'] = __('Title Link', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_link_url_hint'] = __('e.g. http://yourdomain.com/.', 'automobile');
            $automobile_var_static_text['automobile_var_multi_content_title_color'] = __('Content title Color', 'automobile');
            $automobile_var_static_text['automobile_var_multi_content_title_color_hint'] = __('Provide a hex colour code here (with #) for text color. if you want to override the default. ', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_icon_hint'] = __('Select the icon you would like to show with your icon box title.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_icon_bg_color'] = __('Icon Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_icon_bg_color_hint'] = __('Set the icon Box Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_icon_color'] = __('Icon Box icon Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_icon'] = __('Icon Box Icon', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_icon_color_hint'] = __('Set icon box icon color here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_text'] = __('Icon Box Content', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_text_hint'] = __('Enter icon box content here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_title_color'] = __('Element Title color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_title_color_hint'] = __('Provide a hex colour code here (with #) for element title color. if you want to override the default.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_single_service_title_color'] = __('Single icon Box Title Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_single_service_title_color_hint'] = __('Set Single icon Box title color from here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_styles'] = __('Styles', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_styles_hint'] = __('Choose styles for icon box.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_style_simple'] = __('Simple', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_style_box'] = __('Box', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_alignment'] = __('Alignment', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_alignment_left'] = __('Left', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_alignment_right'] = __('Right', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_alignment_center'] = __('Top Center', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_alignment_top_left'] = __('Top Left', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_alignment_top_right'] = __('Top Right', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_alignment_hint'] = __('Set the position of icon_box image here', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_single_service_icon_color'] = __('Single icon Box icon Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_single_service_icon_color_hint'] = __('Provide a hex colour code here (with #) for icon color. if you want to override the default.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_Icon_color'] = __('Icon Box icon Color', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_Icon_color_hint'] = __('Set icon box icon color here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_text'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_text_hint'] = __('Enter icon box content here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_boxes_content_hint'] = __('Add content here.', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_content'] = __('Icon Box Content', 'automobile');
            $automobile_var_static_text['automobile_var_icon_box_icon_content_hint'] = __('Enter icon box content here.', 'automobile');

            //$automobile_var_static_text['automobile_var_multi_services_text_color'] = __('Text Color', 'automobile');
            //$automobile_var_static_text['automobile_var_multi_services_text_color_hint'] = __('Provide a hex colour code here (with #) for text color. if you want to override the default.', 'automobile');
            $automobile_var_static_text['automobile_var_add_service'] = __('Add Service', 'automobile');

            /* Twitter Shortcode */
            $automobile_var_static_text['automobile_var_twitter_edit_msg'] = __('Tweets OPTIONS', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_username'] = __('Twitter User Name', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_username_hint'] = __('Enter your twitter user name here', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_view'] = __('View', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_view_option_1'] = __('Modern', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_view_option_2'] = __('Fancy', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_text_color'] = __('Text Color', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_text_color_hint'] = __('Set text color here', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_tweets_num'] = __('No of Tweets', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_tweets_num_hint'] = __('Enter no of tweets here', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_class'] = __('Class', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_valid_api'] = __('Please enter valid Twitter API Keys', 'automobile');
            $automobile_var_static_text['automobile_var_no_tweets_found'] = __('No Tweets Found', 'automobile');


            /* Video Shortcode */
            $automobile_var_static_text['automobile_var_video_field_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_video_field_title_hint'] = __('Enter text of the Title.', 'automobile');
            $automobile_var_static_text['automobile_var_video_field_url'] = __('Video Url', 'automobile');
            $automobile_var_static_text['automobile_var_video_field_url_hint'] = __('Enter url for the video here.', 'automobile');
            $automobile_var_static_text['automobile_var_video_field_width'] = __('Width', 'automobile');
            $automobile_var_static_text['automobile_var_video_field_width_hint'] = __('Set video frame width here.', 'automobile');
            $automobile_var_static_text['automobile_var_video_field_height'] = __('Height', 'automobile');
            $automobile_var_static_text['automobile_var_video_field_height_hint'] = __('Set video frame height here.', 'automobile');
            $automobile_var_static_text['automobile_var_edit_video_text'] = __('Video Options', 'automobile');
            $automobile_var_static_text['automobile_var_edit_spacer_options'] = __('Spacer Options', 'automobile');
            $automobile_var_static_text['automobile_var_spacer_height'] = __('Spacer Height', 'automobile');
            $automobile_var_static_text['automobile_var_spacer_height_hint'] = __('Set spacer height without(px)', 'automobile');



            /* Price Plan Shortcode */
            $automobile_var_static_text['automobile_var_price_plan_style'] = __('Styles', 'automobile');
            $automobile_var_static_text['automobile_var_price_plan_style_hint'] = __('Choose multi price table style here', 'automobile');
            $automobile_var_static_text['automobile_var_price_plan_style_simple'] = __('Simple', 'automobile');
            $automobile_var_static_text['automobile_var_price_plan_style_classic'] = __('Classic', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_sc'] = __('Price Table', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_add'] = __('Add Price Table', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_edit_option'] = __('Pricing Tables OPTIONS', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_title_hint'] = __('Enter Price plan Title Here', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_title_color'] = __('Title Color', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_title_color_hint'] = __('Set price-table title color from here', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_price'] = __('Price', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_price_hint'] = __('Add price without symbol', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_currency'] = __('Currency Symbols', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_currency_hint'] = __('Add your currency symbol here like $', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_time'] = __('Time Duration', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_time_hint'] = __('Add time duration for package or time range like this package for a month or year So wirte here for Mothly and year for Yearly Package', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_link'] = __('Button Link', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_link_hint'] = __('Add price table button Link here', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_text'] = __('Button Text', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_text_hint'] = __('Add button text here Example : Buy Now, Purchase Now, View Packages etc', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_color'] = __('Button text Color', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_color_hint'] = __('Set button color with color picker', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_bg_color'] = __('Button Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_button_bg_color_hint'] = __('Set button background color with color picker', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_featured'] = __('Featured on/off', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_featured_hint'] = __('Price table featured optiton enable/disbale with this dropdown', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_description'] = __('Content', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_description_hint'] = __('Features can be add easily in input with this shortcode 
					    					[feature_item]Text here[/feature_item][feature_item]Text here[/feature_item]', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_column_color'] = __('column Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_price_table_column_color_hint'] = __('Set column Background color', 'automobile');

            /* Progressbar Shortcode */
            $automobile_var_static_text['automobile_var_progressbar_options'] = __('Progress Bars Options', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar'] = __('Progress Bar', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar_title'] = __('Progress Bar Title', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar_title_hint'] = __('Enter progress bar title', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar_skill'] = __('Skill (in percentage)', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar_skill_hint'] = __('Enter skill (in percentage) here', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar_color'] = __('Progress Bar Color', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar_color_hint'] = __('Set progress bar color here', 'automobile');
            $automobile_var_static_text['automobile_var_progressbar_add_button'] = __('Add Progress Bar', 'automobile');

            /* Table Shortcode */
            $automobile_var_static_text['automobile_var_table_options'] = __('Table Options', 'automobile');
            $automobile_var_static_text['automobile_var_table_content'] = __('Table Content', 'automobile');
            $automobile_var_static_text['automobile_var_table_content_hint'] = __('Fill your table content in shortcode here. (th) for table heading and (td) for table container.', 'automobile');

            /* Flex Editor Shortcode */
            $automobile_var_static_text['automobile_var_editor_options'] = __('Editor Options', 'automobile');

            return $automobile_var_static_text;
        }

        public function automobile_theme_strings() {
            global $automobile_var_static_text;

            $automobile_var_static_text['automobile_var_custom_code'] = __('Custom Code', 'automobile');
            $automobile_var_static_text['automobile_var_custom_menu_description'] = __('Add a custom menu to your sidebar.', 'automobile');
            $automobile_var_static_text['automobile_var_custom_menu'] = __('CS: Custom Menu', 'automobile');
            $automobile_var_static_text['automobile_var_no_menus'] = __('No menus have been created yet. <a href="%s">Create some</a>.', 'automobile');
            $automobile_var_static_text['automobile_var_html_fields_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_enter_title_here'] = __('Enter your element title here.', 'automobile');
            $automobile_var_static_text['automobile_var_select_menu'] = __('Select Menu:', 'automobile');
            $automobile_var_static_text['automobile_var_single_banner'] = __(' Single Banner', 'automobile');
            $automobile_var_static_text['automobile_var_random_banner'] = __('Random Banners', 'automobile');
            $automobile_var_static_text['automobile_var_banner_view'] = __('Banner View ', 'automobile');
            $automobile_var_static_text['automobile_var_banner_view_hint'] = __('Select Banner View ', 'automobile');
            $automobile_var_static_text['automobile_var_search_pagination'] = __('Show Pagination', 'automobile');

            $automobile_var_static_text['automobile_var_no_of_banner'] = __('Number of Banners', 'automobile');
            $automobile_var_static_text['automobile_var_no_of_banner_hint'] = __('Please Number of Banners here', 'automobile');

            $automobile_var_static_text['automobile_var_banner_code'] = __('Banner Code', 'automobile');
            $automobile_var_static_text['automobile_var_banner_code_hint'] = __('Please Banner Code here', 'automobile');



            /* Ads Banner */
            $automobile_var_static_text['automobile_var_banner_title_field_hint'] = __('Please enter Banner Title', 'automobile');
            $automobile_var_static_text['automobile_var_banner_style'] = __('Banner Style', 'automobile');
            $automobile_var_static_text['automobile_var_banner_style_hint'] = __('Please Select  Banner Style', 'automobile');
            $automobile_var_static_text['automobile_var_banner_type'] = __('Banner Type', 'automobile');
            $automobile_var_static_text['automobile_var_banner_type_hint'] = __('Please enter  Banner Type', 'automobile');
            $automobile_var_static_text['automobile_var_banner_type_top'] = __('Top Banner', 'automobile');
            $automobile_var_static_text['automobile_var_banner_type_bottom'] = __('Bottom Banner', 'automobile');
            $automobile_var_static_text['automobile_var_banner_type_sidebar'] = __('Sidebar Banner', 'automobile');


            $automobile_var_static_text['automobile_var_banner_type_vertical'] = __('Vertical Banner', 'automobile');
            $automobile_var_static_text['automobile_var_banner_image'] = __('Image', 'automobile');
            $automobile_var_static_text['automobile_var_banner_code'] = __('Code', 'automobile');
            $automobile_var_static_text['automobile_var_banner_ad_sense_code'] = __('Ad sense Code', 'automobile');
            $automobile_var_static_text['automobile_var_banner_ad_sense_code_hint'] = __('Please enter Banner Ad sense Code', 'automobile');
            $automobile_var_static_text['automobile_var_banner_image_hint'] = __('Please Select Banner Image', 'automobile');
            $automobile_var_static_text['automobile_var_banner_target'] = __('Target', 'automobile');
            $automobile_var_static_text['automobile_var_banner_target_hint'] = __('Please select Banner Link Target', 'automobile');
            $automobile_var_static_text['automobile_var_banner_target_self'] = __('Self', 'automobile');
            $automobile_var_static_text['automobile_var_banner_target_blank'] = __('Blank', 'automobile');
            $automobile_var_static_text['automobile_var_banner_already_added'] = __('Already Added Banners', 'automobile');




            $automobile_var_static_text['automobile_var_banner_table_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_banner_table_style'] = __('Style', 'automobile');
            $automobile_var_static_text['automobile_var_banner_table_image'] = __('Image', 'automobile');
            $automobile_var_static_text['automobile_var_banner_table_clicks'] = __('Clicks', 'automobile');
            $automobile_var_static_text['automobile_var_banner_table_shortcode'] = __('Shortcode', 'automobile');





            $automobile_var_static_text['automobile_var_title_field'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_icon_text'] = __('Please enter text for icon', 'automobile');
            $automobile_var_static_text['automobile_var_url_field'] = __('Url', 'automobile');
            $automobile_var_static_text['automobile_var_url_hint'] = __('Enter image Url here', 'automobile');
            $automobile_var_static_text['automobile_var_default'] = __('Default', 'automobile');
            $automobile_var_static_text['automobile_var_style'] = __('Style', 'automobile');
            $automobile_var_static_text['automobile_var_style_hint'] = __('Select counter view', 'automobile');
            $automobile_var_static_text['automobile_var_full_size'] = _x('Full size', 'Used before full size attachment link.', 'automobile');
            $automobile_var_static_text['automobile_var_published_in'] = _x('<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'automobile');
            $automobile_var_static_text['automobile_var_search_for'] = _x('Search for:', 'label', 'automobile');
            $automobile_var_static_text['automobile_var_search_hellip'] = _x('Search &hellip;', 'placeholder', 'automobile');
            $automobile_var_static_text['automobile_var_search_by_key'] = __('Search by Keyword', 'automobile');
            $automobile_var_static_text['automobile_var_search_string'] = _x('Search', 'submit button', 'automobile');

            $automobile_var_static_text['automobile_var_error_404'] = __('404 Page', 'automobile');
            $automobile_var_static_text['automobile_var_Oops_404'] = __('404<em>Error</em>', 'automobile');
            $automobile_var_static_text['automobile_var_nothing_found_404'] = __('Sorry, but the page that you requested doesn&rsquo;t exist.', 'automobile');
            $automobile_var_static_text['automobile_var_search_by_keyword'] = __('Search by Keyword', 'automobile');
            $automobile_var_static_text['automobile_var_search_button'] = __('Search', 'automobile');
            $automobile_var_static_text['automobile_var_api_set_msg'] = __('Please set API key', 'automobile');
            $automobile_var_static_text['automobile_var_subscribe_success'] = __('subscribe successfully', 'automobile');
            $automobile_var_static_text['automobile_var_noresult_found'] = __('No result found.', 'automobile');
            $automobile_var_static_text['automobile_var_comments'] = __('Comments', 'automobile');
            $automobile_var_static_text['automobile_var_comment'] = __('Comment', 'automobile');
            $automobile_var_static_text['automobile_var_most_relevent'] = __('Most Relevent Links', 'automobile');
            $automobile_var_static_text['automobile_var_by'] = __('By', 'automobile');
            $automobile_var_static_text['automobile_var_next'] = __('Next', 'automobile');
            $automobile_var_static_text['automobile_var_prev'] = __('Previous', 'automobile');
            $automobile_var_static_text['automobile_var_tag'] = __('Tags', 'automobile');
            $automobile_var_static_text['automobile_var_posts'] = __('Posts', 'automobile');
            $automobile_var_static_text['automobile_var_categories'] = __('Categories', 'automobile');
            $automobile_var_static_text['automobile_var_dealer_types'] = __('Dealer Types', 'automobile');
            $automobile_var_static_text['automobile_var_inventories'] = __('Inventories', 'automobile');
            $automobile_var_static_text['automobile_var_inventory_types'] = __('Inventory types', 'automobile');
            $automobile_var_static_text['automobile_var_load_from_icomoon'] = __('Load from IcoMoon', 'automobile');
            $automobile_var_static_text['automobile_var_ago'] = __('Ago', 'automobile');
            $automobile_var_static_text['automobile_var_related_posts'] = __('Related Posts', 'automobile');
            $automobile_var_static_text['automobile_var_image_edit'] = __('Edit "%s"', 'automobile');
            $automobile_var_static_text['automobile_var_primary_menu'] = __('Primary Menu', 'automobile');
            $automobile_var_static_text['automobile_var_social_links_menu'] = __('Social Links Menu', 'automobile');
            $automobile_var_static_text['automobile_var_widget_display_text'] = __('This widget will be displayed on right/left side of the page.', 'automobile');
            $automobile_var_static_text['automobile_var_widget_display_right_text'] = __('This widget will be displayed on right side of the page.', 'automobile');
            $automobile_var_static_text['automobile_var_footer'] = __('Footer ', 'automobile');
            $automobile_var_static_text['automobile_var_widgets'] = __('Widgets ', 'automobile');
            $automobile_var_static_text['automobile_var_search_result'] = __('Search Results : %s', 'automobile');
            $automobile_var_static_text['automobile_var_author'] = __('Author', 'automobile');
            $automobile_var_static_text['automobile_var_archives'] = __('Archives', 'automobile');
            $automobile_var_static_text['automobile_var_daily_archives'] = __('Daily Archives: %s', 'automobile');
            $automobile_var_static_text['automobile_var_monthly_archives'] = __('Monthly Archives: %s', 'automobile');
            $automobile_var_static_text['automobile_var_yearly_archives'] = __('Yearly Archives: %s', 'automobile');
            $automobile_var_static_text['automobile_var_tags'] = __('Tags', 'automobile');
            $automobile_var_static_text['automobile_var_category'] = __('Category', 'automobile');
            $automobile_var_static_text['automobile_var_home'] = __('Home', 'automobile');
            $automobile_var_static_text['automobile_var_current_page'] = __('Current Page', 'automobile');
            $automobile_var_static_text['automobile_var_theme_options'] = __('CS Theme Options', 'automobile');
            $automobile_var_static_text['automobile_var_previous_page'] = __('Previous page', 'automobile');
            $automobile_var_static_text['automobile_var_next_page'] = __('Next page', 'automobile');
            $automobile_var_static_text['automobile_var_previous_image'] = __('Previous Image', 'automobile');
            $automobile_var_static_text['automobile_var_next_image'] = __('Next Image', 'automobile');
            $automobile_var_static_text['automobile_var_pages'] = __('Pages', 'automobile');
            $automobile_var_static_text['automobile_var_page'] = __('Page', 'automobile');
            $automobile_var_static_text['automobile_var_comments_closed'] = __('Comments are closed.', 'automobile');
            $automobile_var_static_text['automobile_var_reply'] = __('Reply', 'automobile');
            $automobile_var_static_text['automobile_var_full_width'] = __('Full Width', 'automobile');
            $automobile_var_static_text['automobile_var_sidebar_right'] = __('Sidebar Right', 'automobile');
            $automobile_var_static_text['automobile_var_sidebar_left'] = __('Sidebar Left', 'automobile');
            $automobile_var_static_text['automobile_var_delete_image'] = __('Delete image', 'automobile');
            $automobile_var_static_text['automobile_var_edit_item'] = __('Edit Item', 'automobile');
            $automobile_var_static_text['automobile_var_description'] = __('Description', 'automobile');
            $automobile_var_static_text['automobile_var_update'] = __('Update', 'automobile');
            $automobile_var_static_text['automobile_var_delete'] = __('Delete', 'automobile');
            $automobile_var_static_text['automobile_var_select_attribute'] = __('Select Attribute', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_widget'] = __('CS: Twitter Widget', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_widget_desciption'] = __('Twitter Widget.', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_widget_user_name'] = __('User Name', 'automobile');
            $automobile_var_static_text['automobile_var_twitter_widget_tweets_num'] = __('Num of Tweets', 'automobile');
            $automobile_var_static_text['automobile_var_flickr_gallery'] = __('CS : Flickr Gallery', 'automobile');
            $automobile_var_static_text['automobile_var_flickr_description'] = __('Type a user name to show photos in widget', 'automobile');
            $automobile_var_static_text['automobile_var_flickr_username'] = __('Flickr username', 'automobile');
            $automobile_var_static_text['automobile_var_flickr_username_hint'] = __('Enter your Flicker Username here', 'automobile');
            $automobile_var_static_text['automobile_var_flickr_photos'] = __('Number of Photos', 'automobile');
            $automobile_var_static_text['automobile_var_error'] = __('Error:', 'automobile');
            $automobile_var_static_text['automobile_var_flickr_api_key'] = __('Please Enter Flickr API key from Theme Options.', 'automobile');
            $automobile_var_static_text['automobile_var_mailchimp'] = __('CS: Mail Chimp', 'automobile');
            $automobile_var_static_text['automobile_var_mailchimp_desciption'] = __('Mail Chimp Newsletter Widget', 'automobile');
            $automobile_var_static_text['automobile_var_description_hint'] = __('Enter discription here.', 'automobile');
            $automobile_var_static_text['automobile_var_social_icon'] = __('Social Icon On/Off.', 'automobile');
            $automobile_var_static_text['automobile_var_recent_post'] = __('CS : Recent Posts', 'automobile');
            $automobile_var_static_text['automobile_var_recent_post_des'] = __('Recent Posts from category.', 'automobile');
            $automobile_var_static_text['automobile_var_choose_category'] = __('Choose Category.', 'automobile');
            $automobile_var_static_text['automobile_var_num_post'] = __('Number of Posts To Display.', 'automobile');
            $automobile_var_static_text['automobile_var_availability'] = __('Availability', 'automobile');
            $automobile_var_static_text['automobile_var_ads_description'] = __('Set Banners option in widget.', 'automobile');
            $automobile_var_static_text['automobile_var_ads'] = __('CS: Ads', 'automobile');
            $automobile_var_static_text['automobile_var_image'] = __('Add Image', 'automobile');
            $automobile_var_static_text['automobile_var_image_ads_hint'] = __('Select Image for Ads .', 'automobile');
            $automobile_var_static_text['automobile_var_ads_url'] = __('Image Url', 'automobile');
            $automobile_var_static_text['automobile_var_in_stock'] = __('in stock', 'automobile');
            $automobile_var_static_text['automobile_var_out_stock'] = __('out of stock', 'automobile');
            $automobile_var_static_text['automobile_var_wait'] = __('Please wait...', 'automobile');
            $automobile_var_static_text['automobile_var_load_icon'] = __('Successfully loaded icons', 'automobile');
            $automobile_var_static_text['automobile_var_try_again'] = __('Error: Try Again?', 'automobile');
            $automobile_var_static_text['automobile_var_load_json'] = __('Load from IcoMoon selection.json', 'automobile');
            $automobile_var_static_text['automobile_var_are_sure'] = __('Are you sure! You want to delete this', 'automobile');
            $automobile_var_static_text['automobile_var_icon_hint'] = __('Please enter text for icon', 'automobile');
            $automobile_var_static_text['automobile_var_icon_path'] = __('Icon Path', 'automobile');
            $automobile_var_static_text['automobile_var_icon'] = __('Icon', 'automobile');
            $automobile_var_static_text['automobile_var_icon_hint'] = __('Choose icon', 'automobile');
            $automobile_var_static_text['automobile_var_comment_awaiting'] = __('Your comment is awaiting moderation.', 'automobile');
            $automobile_var_static_text['automobile_var_edit'] = __('Edit', 'automobile');
            $automobile_var_static_text['automobile_var_you_may'] = __('You may use these HTML tags and attributes: %s', 'automobile');
            $automobile_var_static_text['automobile_var_message'] = __('Comment', 'automobile');
            $automobile_var_static_text['automobile_var_view_posts'] = __('View all posts by %s', 'automobile');
            $automobile_var_static_text['automobile_var_nothing'] = __('No Pages Were Found Containing "your added text"', 'automobile');
            $automobile_var_static_text['automobile_var_ready_publish'] = __('Ready to publish your first post? Get started here.', 'automobile');
            $automobile_var_static_text['automobile_var_nothing_match'] = __('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'automobile');
            $automobile_var_static_text['automobile_var_perhaps'] = __('It seems we cannot find what you are looking for. Perhaps searching can help.', 'automobile');
            $automobile_var_static_text['automobile_var_you_must'] = __('You must be to post a comment.', 'automobile');
            $automobile_var_static_text['automobile_var_log_out'] = __('Log out', 'automobile');
            $automobile_var_static_text['automobile_var_suggestions'] = __('Suggestions:', 'automobile');
            $automobile_var_static_text['automobile_var_make_sure'] = __('Make sure all words are spelled correctly', 'automobile');
            $automobile_var_static_text['automobile_var_wildcard_searches'] = __('Wildcard searches (using the asterisk *) are not supported', 'automobile');
            $automobile_var_static_text['automobile_var_try_more'] = __('Try more general keywords, especially if you are attempting a name', 'automobile');
            $automobile_var_static_text['automobile_var_log_out'] = __('Log out', 'automobile');
            $automobile_var_static_text['automobile_var_log_in'] = __('Logged in as', 'automobile');
            $automobile_var_static_text['automobile_var_require_fields'] = __('Required fields are marked %s', 'automobile');
            $automobile_var_static_text['automobile_var_name'] = __('Name *', 'automobile');
            $automobile_var_static_text['automobile_var_full_name'] = __('full name', 'automobile');
            $automobile_var_static_text['automobile_var_email'] = __('Email Address *', 'automobile');
            $automobile_var_static_text['automobile_var_enter_email'] = __('Please enter your email address', 'automobile');
            $automobile_var_static_text['automobile_var_website'] = __('Website', 'automobile');
            $automobile_var_static_text['automobile_var_text_here'] = __('Please enter a comment', 'automobile');
            $automobile_var_static_text['automobile_var_leave_comment'] = __('Leave us a comment', 'automobile');
            $automobile_var_static_text['automobile_var_cancel_reply'] = __('Cancel reply', 'automobile');
            $automobile_var_static_text['automobile_var_post_comment'] = __('Post comments', 'automobile');
            $automobile_var_static_text['automobile_var_interested'] = __('I am interested in a price quote on this vehicle. Please contact me at your earliest convenience with your best price for this vehicle.', 'automobile');
            $automobile_var_static_text['automobile_var_add_gallery'] = __('Add Gallery', 'automobile');
            $automobile_var_static_text['automobile_var_widget_setting'] = __('Widget Setting Export', 'automobile');
            $automobile_var_static_text['automobile_var_select_all'] = __('Select All', 'automobile');
            $automobile_var_static_text['automobile_var_unselect_all'] = __('Un-Select All', 'automobile');
            $automobile_var_static_text['automobile_var_clear_current'] = __('Clear Current Widgets Before Import', 'automobile');
            $automobile_var_static_text['automobile_var_all_active'] = __('All active widgets will be moved to inactive', 'automobile');
            $automobile_var_static_text['automobile_var_put_file'] = __('Put File URL that contains widget settings', 'automobile');
            $automobile_var_static_text['automobile_var_widget_imported'] = __('Widgets Imported Successfully.', 'automobile');
            $automobile_var_static_text['automobile_var_widget_not'] = __('Widgets data not Imported.', 'automobile');
            $automobile_var_static_text['automobile_var_readmore_text'] = __('Read More', 'automobile');
            $automobile_var_static_text['automobile_var_comment_text'] = __('comment', 'automobile');
            $automobile_var_static_text['automobile_var_comments_text'] = __('comments', 'automobile');
            $automobile_var_static_text['automobile_var_no_post_error'] = __('No blog post found.', 'automobile');
            $automobile_var_static_text['automobile_var_published_by'] = __('published by', 'automobile');
            $automobile_var_static_text['automobile_var_view_all_posts_by'] = __('View all posts by ', 'automobile');
            
            ///widgets cs facebook widget
            $automobile_var_static_text['automobile_var_facebook'] = __('CS : Facebook', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_desc'] = __('Facebook widget like box total customized with theme.', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_title'] = __('Title', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_url'] = __('Page Url', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_profile_url'] = __('Page Url', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_bgcolor'] = __('Background Color', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_width'] = __('Width', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_lightbox_height'] = __('Like Box Height', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_hide_cover'] = __('Hide Cover', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_show_faces'] = __('Show Faces', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_show_post'] = __('Show Post', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_hide_cta'] = __('Hide Cta', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_small_header'] = __('Small Header', 'automobile');
            $automobile_var_static_text['automobile_var_facebook_adaptwidth'] = __('Adapt Width', 'automobile');

            /*
              $automobile_strings = array(
              );
              foreach ($automobile_strings as $key => $value) {
              echo '$automobile_var_static_text[\'' . $key . '\'] = __(\'' . $value . '\' , 'automobile'); ';
              echo '<br />';
              }
             * 
             */
            return $automobile_var_static_text;
        }

    }

    new automobile_theme_all_strings;
}
?>