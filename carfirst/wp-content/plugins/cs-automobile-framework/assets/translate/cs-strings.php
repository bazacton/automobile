<?php
/**
 * @Text which is being used in Framework
 *
 */
if (!function_exists('automobile_var_frame_text_srt')) {

    function automobile_var_frame_text_srt($str = '') {
        global $automobile_var_frame_static_text;
        if (isset($automobile_var_frame_static_text[$str])) {
            return $automobile_var_frame_static_text[$str];
        }
    }

}
if (!class_exists('automobile_var_frame_all_strings')) {

    class automobile_var_frame_all_strings {

        public function __construct() {

            $this->automobile_var_frame_all_string_all();
        }

        public function automobile_var_frame_all_string_all() {
            global $automobile_var_frame_static_text;

            /* framework */

            $automobile_var_frame_static_text['automobile_var_add_page_section'] = __('Add Page Sections', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_Oops_404'] = __('Oops! That page can’t be found. ', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_nothing_found_404'] = __('It looks like nothing was found at this location. Maybe try a search?. ', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_api_set_msg'] = __('Please set API key', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_subscribe_success'] = __('subscribe successfully', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_noresult_found'] = __('No result found.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_comments'] = __('Comments', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_by'] = __('By', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_next'] = __('Next', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_prev'] = __('PREVIOUS', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tag'] = __('Tags', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_ago'] = __('Ago', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_related_posts'] = __('Related Posts', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_image_edit'] = __('Edit "%s"', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_primary_menu'] = __('Primary Menu', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_social_links_menu'] = __('Social Links Menu', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_widget_display_text'] = __('This widget will be displayed on right/left side of the page.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_widget_display_right_text'] = __('This widget will be displayed on right side of the page.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_footer'] = __('Footer ', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_widgets'] = __('Widgets ', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_search_result'] = __('Search Results : %s', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_author'] = __('Author', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_archives'] = __('Archives', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_packages'] = __('Inventory Packages', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tweets'] = __('Tweets', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_tweets_found'] = __('NO tweets found.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tweets_time_on'] = __('On', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_daily_archives'] = __('Daily Archives: %s', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_monthly_archives'] = __('Monthly Archives: %s', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_yearly_archives'] = __('Yearly Archives: %s', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tags'] = __('Tags', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_error_404'] = __('Error 404', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_home'] = __('Home', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_current_page'] = __('Current Page', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_theme_options'] = __('CS Theme Options', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_previous_page'] = __('Previous page', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_next_page'] = __('Next page', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_previous_image'] = __('Previous Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_next_image'] = __('Next Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_pages'] = __('Pages:', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_page'] = __('Page', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_comments_closed'] = __('Comments are closed.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_reply'] = __('Reply', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_full_width'] = __('Full width', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_sidebar_right'] = __('Sidebar Right', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_sidebar_left'] = __('Sidebar Left', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_delete_image'] = __('Delete image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_edit_item'] = __('Edit Item', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_description'] = __('Description', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_update'] = __('Update', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_delete'] = __('Delete', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_select_attribute'] = __('Select Attribute', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_ads'] = __('CS : Ads', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_select_image_ads'] = __('Select Image from Ads.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_flickr_gallery'] = __('CS : Flickr Gallery', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_flickr_description'] = __('Type a user name to show photos in widget', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_flickr_username'] = __('Flickr username', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_flickr_username_hint'] = __('Enter your Flicker Username here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_flickr_photos'] = __('Number of Photos', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_error'] = __('Error:', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_flickr_api_key'] = __('Please Enter Flickr API key from Theme Options.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_mailchimp'] = __('CS: Mail Chimp', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_mailchimp_desciption'] = __('Mail Chimp Newsletter Widget', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_description_hint'] = __('Enter discription here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_social_icon'] = __('Social Icon On/Off.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_recent_post'] = __('CS : Recent Posts', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_recent_post_des'] = __('Recent Posts from category.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_category'] = __('Choose Category.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_num_post'] = __('Number of Posts To Display.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_availability'] = __('Availability', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_in_stock'] = __('in stock', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_out_stock'] = __('out of stock', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_wait'] = __('Please wait...', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_load_icon'] = __('Successfully loaded icons', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_try_again'] = __('Error: Try Again?', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_load_json'] = __('Load from IcoMoon selection.json', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_are_sure'] = __('Are you sure! You want to delete this', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_hint'] = __('Please enter text for icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_path'] = __('Icon Path', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon'] = __('Icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_comment_awaiting'] = __('Your comment is awaiting moderation.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_edit'] = __('Edit', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_you_may'] = __('You may use these HTML tags and attributes: %s', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_message'] = __('Message', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_view_posts'] = __('View all posts by %s', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_nothing'] = __('Nothing Found', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_ready_publish'] = __('Ready to publish your first post? Get started here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_nothing_match'] = __('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_perhaps'] = __('It seems we can’t find what you’re looking for. Perhaps searching can help.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_you_must'] = __('You must be to post a comment.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_log_out'] = __('Log out', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_log_in'] = __('Logged in as', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_require_fields'] = __('Required fields are marked %s', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_name'] = __('Name *', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_full_name'] = __('full name', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_email'] = __('Email Address *', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_enter_email'] = __('Please enter your email address', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_website'] = __('Website', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_text_here'] = __('Text here...', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_leave_comment'] = __('Leave us a comment', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_cancel_reply'] = __('Cancel reply', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_post_comment'] = __('Post comments', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_interested'] = __('I am interested in a price quote on this vehicle. Please contact me at your earliest convenience with your best price for this vehicle.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_dealer'] = __('Dealers Listing', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_page_option'] = __('Page Options', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_general_setting'] = __('General Settings', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_subheader'] = __('Subheader', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_subheader'] = __('Choose Sub-Header', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_default_subheader'] = __('Default Subheader', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_custom_subheader'] = __('Custom Subheader', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_rev_slider'] = __('Revolution Slider', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_map'] = __('Map', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_subheader'] = __('No Subheader', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_style'] = __('Style', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_classic'] = __('Classic', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_with_image'] = __('With Background Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_padding_top'] = __('Padding Top', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_padding_top_hint'] = __('Set padding top here.(In px)', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_padding_bot'] = __('Padding Bottom', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_padding_bot_hint'] = __('Set padding bottom. (In px)', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_margin_top'] = __('Margin Top', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_margin_top_hint'] = __('Set Margin top here.(In px) ', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_margin_bot'] = __('Margin Bottom', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_margin_bot_hint'] = __('Set Margin bottom. (In px)', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_select_layout'] = __('Select Layout', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_page_title'] = __('Page Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_text_color'] = __('Text Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_text_color_hint'] = __('Provide a hex color code here (with #) for title.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_breadcrumbs'] = __('Breadcrumbs', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_sub_heading'] = __('Sub Heading', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_sub_heading_hint'] = __('Enter subheading text here.it will display after title.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_bg_image'] = __('Background Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_bg_image_hint'] = __('Choose subheader background image from media gallery or leave it empty for display default image set by theme options.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_parallax'] = __('Parallax', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_parallax_hint'] = __('Parallax is an effect where the background content or image in this case, is moved at a different speed than the foreground content while scrolling can be enable with this switch.', CSFRAME_DOMAIN);
            $automobile_var_frame_static_text['automobile_var_bg_color'] = __('Background Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_bg_color_hint'] = __('Provide a hex color code here (with #) if you want to override the default, leave it empty for using background image.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_slider'] = __('Select Slider', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_map_sc'] = __('Custom Map Short Code', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_header_border'] = __('Header Border Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_header_hint'] = __('Provide a hex color code here (with #) for header border color.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_header_style'] = __('Choose Header Style', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_modern_header'] = __('Modern Header Style', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_default_header'] = __('Default header style', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_side_bar'] = __('Select Sidebar', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_sidebar'] = __('Choose Sidebar', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_sidebar_hint'] = __('Choose sidebar layout for this post.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_left_sidebar'] = __('Select Left Sidebar', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_right_sidebar'] = __('Select Right Sidebar', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_post_options'] = __('Post Options', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_social_sharing'] = __('Social Sharing', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_product_options'] = __('Product Options', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_add_element'] = __('Add Element', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_search'] = __('Search', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_show_all'] = __('Show all', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_filter_by'] = __('Filter by', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_insert_sc'] = __('CS: Insert shortcode', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_quote'] = __('Blockquote', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_dropcap'] = __('Dropcap', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_edit_options'] = __('%s Options', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_title'] = __('Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_title_hint'] = __('This Title will view on top of this section.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_subtitle'] = __('Sub Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_subtitle_hint'] = __('This Sub Title will view below the Title of this section.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_bg_view'] = __('Background View', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_bg'] = __('Choose Background View.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_none'] = __('None', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_title_sub_title_align'] = __('Alignment', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_sub_header_align'] = __('Text Align', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_title_sub_title_align_hint'] = __('Set title/sub title alignment from this dropdown.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_align_left'] = __('Left', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_align_center'] = __('Center', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_align_right'] = __('Right', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_custom_slider'] = __('Custom Slider', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_video'] = __('Video', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_bg_position'] = __('Background Image Position', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_bg_position'] = __('Choose Background Image Position', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_center_top'] = __('no-repeat center top', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_center_top'] = __('repeat center top', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_center'] = __('no-repeat center', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_center_cover'] = __('no-repeat center / cover', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_repeat_center'] = __('repeat center', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_left_top'] = __('no-repeat left top', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_repeat_left_top'] = __('repeat left top', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_fixed'] = __('no-repeat fixed center', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_fixed_cover'] = __('no-repeat fixed center / cover', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_custom_slider_hint'] = __('Enter Custom Slider', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_video_url'] = __('Video Url', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_browse'] = __('Browse', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_mute'] = __('Enable Mute', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_mute'] = __('Choose Mute selection', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_yes'] = __('Yes', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no'] = __('No', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_video_auto'] = __('Video Auto Play', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_video_auto'] = __('Choose Video Auto Play selection', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_enable_parallax'] = __('Enable Parallax', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_section_nopadding'] = __('No Padding', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_section_nomargin'] = __('No Margin', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_select_view'] = __('Select View', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_box'] = __('Box', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_wide'] = __('Wide', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_bg_coor'] = __('Choose background color.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_border_top'] = __('Border Top', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_border_top_hint'] = __('Set the Border top (In px)', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_border_bot'] = __('Border Bottom', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_border_bot_hint'] = __('Set the Border Bottom (In px)', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_border_color'] = __('Border Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_choose_border_color'] = __('Choose Border color.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_cus_id'] = __('Custom Id', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_cus_id_hint'] = __('Enter Custom Id.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_select_layout'] = __('Select Layout', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_edit_page'] = __('Edit Page Section', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_ads_only'] = __('Ads', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_inventories'] = __('Inventory Listing', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_inventories_search'] = __('Inventory Search', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_compare_inventories'] = __('Inventory Compare', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_gallery'] = __('Gallery', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icons_box'] = __('Icons Box', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_plan'] = __('Pricing Tables', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_wc_feature'] = __('WC Feature Product', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_column'] = __('Columns', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_contact_form'] = __('Contact Form', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_schedule_form'] = __('Schedule Form', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_best_time'] = __('Best time', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_testimonial'] = __('Testimonial', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion'] = __('Accordion', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multi_services'] = __('Multi Services', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_partner'] = __('Partner', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_blog'] = __('Blog - Views', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_heading'] = __('Headings', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_counter'] = __('Counter', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_image_frame'] = __('Image Frame', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_flex_editor'] = __('flex editor', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_editor'] = __('Editor', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_call_action'] = __('Call To Action', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance'] = __('maintenance', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_list'] = __('List', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_contact_info'] = __('Contact Info', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_divider'] = __('Divider', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_promobox'] = __('Promobox', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_auto_heading'] = __('Automobile Heading', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_button'] = __('Buttons', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_sitemap'] = __('Site Map', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_listing_price'] = __('Listing Price', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_spacer'] = __('Spacer', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_typography'] = __('Typography', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_common_elements'] = __('Common Elements', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_media_element'] = __('Media Element', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_content_blocks'] = __('Content Blocks', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_loops'] = __('Loops', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_wpam'] = __('WPAM', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_size'] = __('Size', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_column_hint'] = __('Select column width. This width will be calculated depend page width.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_one_half'] = __('One half', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_one_third'] = __('One third', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_two_third'] = __('Two third', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_one_fourth'] = __('One fourth', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_three_fourth'] = __('Three fourth', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_plz_select'] = __('Please select..', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_text'] = __('Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_testimonial_text'] = __('Text', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_text_hint'] = __('Enter testimonial content here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_author_hint'] = __('Enter testimonial author name here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_position'] = __('Position', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_position_hint'] = __('Enter position of author here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_image'] = __('Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_image_hint'] = __('Set author image from media gallery.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_active'] = __('Active', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_active_hint'] = __('You can set the accordian section that is open by default on frontend by select dropdown', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_active_hint'] = __('You can set the faq section that is open by default on frontend by select dropdown', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_remove'] = __('Remove', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_list_Item'] = __('List Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_list_Item_hint'] = __('Enter list title here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_tooltip'] = __('Choose icon for list.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_list_sc_icon_color'] = __('Icon Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_list_sc_icon_color_hint'] = __('Select icon color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_list_sc_icon_bg_color'] = __('Icon Background Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_list_sc_icon_bg_color_hint'] = __('Select icon background color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_listing_title_hint'] = __('Enter listing_price text here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price'] = __('Price', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_hint'] = __('Enter listing_price author name here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_color'] = __('Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_color_hint'] = __('Set text color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_counter_hint'] = __('Enter counter text here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_counter_author_hint'] = __('Enter counter author name here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_counter_text_hint'] = __('Enter position of author here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_divider_hint'] = __('Divider setting on/off', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_image_url'] = __('Image Url', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_image_url_hint'] = __('Enter image url', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_service'] = __('Multiple Service', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_content_title'] = __('Content Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_content_title_hint'] = __('Add service title here..', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_link_url'] = __('Link Url', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_link_hint'] = __('e.g. http://yourdomain.com/.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_content_title_color'] = __('Content title Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_content_title_color_hint'] = __('Set title color from here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_bg_color'] = __('Icon Background Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_bg_color_hint'] = __('Set the Service Background', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_color'] = __('Icon Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_color_hint'] = __('Set the position of service image here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_service_text_hint'] = __('Enter little description about service.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_content_color'] = __('Content Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_content_color_hint'] = __('Provide a hex colour code here (with #) for text color. if you want to override the default.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_page_builder'] = __('CS Page Builder', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_enter_valid'] = __('Enter Valid Email Address', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_inventory_type'] = __('Inventory Makes', 'cs-frame');

            /*
              multi counter
             */
            
            $automobile_var_frame_static_text['automobile_var_multiple_counter_title'] = __('Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_title_hint'] = __('Enter Title Here', 'cs-frame');
            
            $automobile_var_frame_static_text['automobile_var_multiple_counter'] = __('Counter', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_icon'] = __('Icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_icon_tooltip'] = __('Please Select Icon ', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_count'] = __('Count', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_count_tooltip'] = __('Enter Counter Range', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_content'] = __('Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_content_tooltip'] = __('Enter Content Here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_content_color'] = __('Content Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_multiple_counter_content_color_tooltip'] = __('Select Content Color ', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_thumbnail_view_demo'] = __('Thumbnail View demo', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_thumbnail_view_demo_hint'] = __('Choose thumbnail view type for this post. None for no image. Single image for display featured image on listings and slider for display slides on thumbnail view.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_single_image'] = __('Single Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_slider'] = __('Slider', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_audio'] = __('Audio', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_thumbnail_audio_url'] = __('Thumbnail Audio URL', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_thumbnail_audio_url_hint'] = __('Enter Audio URL for this Post', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_thumbnail_video_url'] = __('Thumbnail Video URL', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_thumbnail_video_url_hint'] = __('Enter Specific Video Url (Youtube, Vimeo and Dailymotion)', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_add_gallery_images'] = __('Add Gallery Images', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_detail_views'] = __('Detail Views', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_simple'] = __('Simple', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_fancy'] = __('Fancy', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_inside_post_view'] = __('Inside Post Thumbnail View', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_inside_post_view_hint'] = __('Choose inside thumbnail view type for this post. None for no image. Single image for display featured image on detail. Slider for display slides on detail. Audio for make this audio post and video for display video inside post.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_audio_url'] = __('Audio Url', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_audio_url_hint'] = __('Enter Mp3 audio url for this post .', 'cs-frame');

            /*             * accordion Code */
            $automobile_var_frame_static_text['automobile_var_accordian'] = __('Accordion', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq'] = __('Faq', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_title'] = __('Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_title_hint'] = __('Enter accordion title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_title'] = __('Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_title_hint'] = __('Enter faq title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_text'] = __('Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_text_hint'] = __('Enter accordian content here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_text'] = __('Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_text_hint'] = __('Enter faq content here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_icon'] = __('Icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_icon_hint'] = __('Select Icon for accordion', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_icon'] = __('Icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_icon_hint'] = __('Select Icon for faq', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_title_hint'] = __('Enter accordion title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_view'] = __('View', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_view_hint'] = __('Select View for Accordion', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_view'] = __('View', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_faq_view_hint'] = __('Select View for Accordion', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_view_simple'] = __('Simple', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_accordion_view_modern'] = __('Modern', 'cs-frame');

            /*             * Site map Short Code */
            $automobile_var_frame_static_text['automobile_var_edit_sitemap'] = __('Edit SiteMap Options', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_section_title'] = __('Section Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_post_settings'] = __('Post Settings', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_edit_maintain_page'] = __('Edit Maintain Page Options', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_insert'] = __('Insert', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_logo'] = __('Logo', 'cs-frame');
            
            $automobile_var_frame_static_text['automobile_var_no_margin_hint'] = __('Select Yes to remove margin for this section', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_please_select_maintinance'] = __('Please Select a Maintenance Page', 'cs-frame');
            /*             * Client Short Code */
            $automobile_var_frame_static_text['automobile_var_clients'] = __('Clients', 'cs-frame');
            /*
              team
             */

            $automobile_var_frame_static_text['automobile_var_team'] = __('Team', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_add_item'] = __('Add Team', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_name'] = __('Name', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_name_hint'] = __('Enter team member name here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_designation'] = __('Designation', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_designation_hint'] = __('Enter team member designation here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_image'] = __('Team Profile Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_image_hint'] = __('Select team member image from media gallery.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_phone'] = __('Phone No', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_phone_hint'] = __('Enter phone number here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_fb'] = __('Facebook', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_fb_hint'] = __('Enter facebook account link here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_twitter'] = __('Twitter', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_twitter_hint'] = __('Enter twitter account link here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_google'] = __('Google Plus', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_google_hint'] = __('Enter google+ account link here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_linkedin'] = __('Linkedin', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_linkedin_hint'] = __('Enter linkedin account link here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_youtube'] = __('Youtube', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_youtube_hint'] = __('Enter youtube link here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_title'] = __('Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_title_hint'] = __('Enter Team Title Here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_sub_title'] = __('Sub Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc_sub_title_hint'] = __('Enter Team Sub Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_team_sc'] = __('Team', 'cs-frame');
            /*             * Maintenance Short Code */

            $automobile_var_frame_static_text['automobile_var_maintenance'] = __('Maintenance', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_title'] = __('Element Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_title_hint'] = __('Enter Maintenance Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_sub_title'] = __('Element Sub Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_sub_title_hint'] = __('Enter Maintenance Subtitle', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_text'] = __('Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_text_hint'] = __('Enter Maintenance Text', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_fluid'] = __('Fluid', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_fluid_hint'] = __('Make Maintenance Page fluid on/off', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_image_hint'] = __('Select Image for Maintaince background.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_logo_hint'] = __('Select Image for Maintaince Logo.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_launch_date'] = __('Launch Date', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_launch_date_hint'] = __('Enter launch Date', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_sc_save'] = __('Save', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_save_settings'] = __('Save Settings', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_select_page'] = __('Select A page', 'cs-frame');

            /*
              tabs */

            $automobile_var_frame_static_text['automobile_var_tabs'] = __('Tabs', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab'] = __('Tab', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tabs_desc'] = __('You can manage your tabs using this shortcode', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_active'] = __('Active', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_active_hint'] = __('You can set the tab section that is open by default on frontend by select dropdown', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_item_text'] = __('Tab Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_item_text_hint'] = __('Enter tab title here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_desc'] = __('Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_desc_hint'] = __('Enter tab content here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_icon'] = __('Tab Icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_tab_icon_hint'] = __('Select the Icons you would like to show with your tab .', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_saving_changes'] = __('Saving changes...', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_title'] = __('No Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_no_padding_hint'] = __('Select Yes to remove padding for this section', 'cs-frame');




            /* Maintenance Mode */

            $automobile_var_frame_static_text['automobile_var_maintenance_save_btn'] = __('Save Settings', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_name'] = __('Maintenance Mode', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_mode'] = __('Maintenance Mode', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_mode_hint'] = __('Turn Maintenance Mode On/Off here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_logo'] = __('Maintenance Mode Logo', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_logo_hint'] = __('Turn Logo On/Off here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_social'] = __('Social Contact', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_social_hint'] = __('Turn Social Contact On/Off here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_newsletter'] = __('Newsletter', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_newsletter_hint'] = __('Turn newsletter On/Off here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_header'] = __('Header Switch', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_header_hint'] = __('Turn Header On/Off here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_footer'] = __('Footer Switch', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_footer_hint'] = __('Turn Footer On/Off here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_select_page'] = __('Please Select a Page', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_mode_page'] = __('Maintenance Mode Page', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_field_mode_page_hint'] = __('Choose a page that you want to set for maintenance mode', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_maintenance_save_message'] = __('All Settings Saved', 'cs-frame');
            /*
              icos box
             */
            $automobile_var_frame_static_text['automobile_var_icon_boxs_title'] = __('Icon Box', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxs_views'] = __('Views', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxs_views_hint'] = __('Select the Icon Box style', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_view_option_1'] = __('Simple', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_view_option_2'] = __('Top Center', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_content_title'] = __('Icon Box Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_content_title_hint'] = __('Add Icon Box title here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_link_url'] = __('Title Link', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_link_url_hint'] = __('e.g. http://yourdomain.com/.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_content_title_color'] = __('Content title Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_content_title_color_hint'] = __('Set title color from here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_Icon'] = __('Icon Box Icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_Icon_hint'] = __('Select the icons you would like to show with your accordion title.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size'] = __('Icon Font Size', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_hint'] = __('Set the Icon Font Size', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_option_1'] = __('Extra Small', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_option_2'] = __('Small', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_option_3'] = __('Medium', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_option_4'] = __('Medium Large', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_option_5'] = __('Large', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_option_6'] = __('Extra Large', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_font_size_option_7'] = __('Free Size', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_Icon_bg'] = __('Icon Background Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_Icon_bg_hint'] = __('Set the Icon Box Background.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_Icon_color'] = __('Icon Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_Icon_color_hint'] = __('Set Icon Box icon color from here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_text'] = __('Icon Box Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_boxes_text_hint'] = __('Enter icon box content here.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_type'] = __('Icon Type', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_type_hint'] = __('Select icon type image or font icon.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_type_1'] = __('Icon', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_icon_type_2'] = __('Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_image'] = __('Image', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_icon_box_image_hint'] = __('Attach image from media gallery.', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_register_heading'] = __('User Registration', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_register'] = __('User Registration', 'cs-frame');


            
            
            /*Price Table*/
            $automobile_var_frame_static_text['automobile_var_price_table_title'] = __('Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_title_hint'] = __('Enter Price table Title Here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_title_color'] = __('Title Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_title_color_hint'] = __('Set price-table title color from here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_price'] = __('Price', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_price_hint'] = __('Add price without symbol', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_currency'] = __('Currency Symbols', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_currency_hint'] = __('Add your currency symbol here like $', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_time'] = __('Time Duration', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_time_hint'] = __('Add time duration for package or time range like this package for a month or year So wirte here for Mothly and year for Yearly Package', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_link'] = __('Button Link', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_link_hint'] = __('Add price table button Link here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_text'] = __('Button Text', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_text_hint'] = __('Add button text here Example : Buy Now, Purchase Now, View Packages etc', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_color'] = __('Button text Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_color_hint'] = __('Set button color with color picker', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_bg_color'] = __('Button Background Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_button_bg_color_hint'] = __('Set button background color with color picker', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_featured'] = __('Featured on/off', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_featured_hint'] = __('Price table featured option enable/disable with this dropdown', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_description'] = __('Content', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_description_hint'] = __('Features can be add easily in input with this shortcode 
					    					[feature_item]Text here[/feature_item][feature_item]Text here[/feature_item]', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_column_color'] = __('column Background Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_price_table_column_color_hint'] = __('Set column Background color', 'cs-frame');
            
            /* Progressbar Shortcode */
            $automobile_var_frame_static_text['automobile_var_progressbars'] = __('Progress Bars', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar'] = __('Progress Bar', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar_title'] = __('Progress Bar Title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar_title_hint'] = __('Enter progress bar title', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar_skill'] = __('Skill (in percentage)', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar_skill_hint'] = __('Enter skill (in percentage) here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar_color'] = __('Progress Bar Color', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar_color_hint'] = __('Set progress bar color here', 'cs-frame');
            $automobile_var_frame_static_text['automobile_var_progressbar_add_button'] = __('Add Progress Bar', 'cs-frame');
            
            /* Table Shortcode */
            $automobile_var_frame_static_text['automobile_var_table'] = __('Table', 'cs-frame');
            
            return $automobile_var_frame_static_text;
        }

    }

}
new automobile_var_frame_all_strings;
/*
  $automobile_strings = array(
  'automobile_var_tabs' => __('Tabs', CSFRAME_DOMAIN),
  'automobile_var_tabs_desc' => __('You can manage your tabs using this shortcode', CSFRAME_DOMAIN),
  'automobile_var_tab_active' => __('Tab Active', CSFRAME_DOMAIN),
  'automobile_var_tab_active_hint' => __('Select Tab ON/OFF option here', CSFRAME_DOMAIN),
  'automobile_var_tab_item_text' => __('Tab Item Text', CSFRAME_DOMAIN),
  'automobile_var_tab_item_text_hint' => __('Enter tab Item text here', CSFRAME_DOMAIN),
  'automobile_var_tab_desc' => __('Tab Description', CSFRAME_DOMAIN),
  'automobile_var_tab_desc_hint' => __('Enter the tab description here.', CSFRAME_DOMAIN),
  'automobile_var_tab_icon' => __('Tab Icon', CSFRAME_DOMAIN),
  'automobile_var_tab_icon_hint' => __('Select the Icons you would like to show with your tab .', CSFRAME_DOMAIN),
  );
  foreach ($automobile_strings as $key => $value) {
  echo '$automobile_var_frame_static_text[\'' . $key . '\'] = __(\'' . $value . '\' , CSFRAME_DOMAIN); ';
  echo '<br />';
  }
 */

//automobile_var_frame_all_strings();
?>