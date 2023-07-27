<?php
global $post, $automobile_count_node, $automobile_xmlObject;

add_action('add_meta_boxes', 'automobile_page_bulider_add');

/**
 * @Adding Meta box with Frame static text
 *
 */
if (!function_exists('automobile_page_bulider_add')) {

    function automobile_page_bulider_add() {
	global $automobile_var_frame_static_text;
	$string = new automobile_var_frame_all_strings;
	$string->automobile_var_frame_all_string_all();
	$automobile_var_page_builder = isset($automobile_var_frame_static_text['automobile_var_page_builder']) ? $automobile_var_frame_static_text['automobile_var_page_builder'] : '';
	add_meta_box('id_page_builder', automobile_var_frame_text_srt('automobile_var_page_builder'), 'automobile_page_bulider', 'page', 'normal', 'high');
    }

}

/**
 * @Starting Page Builder
 *
 */
if (!function_exists('automobile_page_bulider')) {

    function automobile_page_bulider($post) {
	global $post, $automobile_xmlObject, $automobile_node, $automobile_count_node, $post, $column_container, $coloum_width, $automobile_var_frame_static_text;
	wp_reset_query();
	$postID = $post->ID;
	$count_widget = 0;
	$page_title = '';
	$page_content = '';
	$page_sub_title = '';
	$builder_active = 0;
	$automobile_page_bulider = get_post_meta($post->ID, "automobile_page_builder", true);
	if (!empty($automobile_page_bulider) && $automobile_page_bulider <> "") {
	    $automobile_xmlObject = new stdClass();
	    $automobile_xmlObject = new SimpleXMLElement($automobile_page_bulider);
	    $builder_active = $automobile_xmlObject->builder_active;
	}
	?>
	<input type="hidden" name="builder_active" value="<?php echo esc_html($builder_active) ?>" />
	<div class="clear"></div>
	<div id="add_page_builder_item" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')) ?>">
	    <div id="automobile_shortcode_area"></div>  
	    <?php
	    if ($automobile_page_bulider <> "") {
		if (isset($automobile_xmlObject->page_title))
		    $page_title = $automobile_xmlObject->page_title;
		if (isset($automobile_xmlObject->page_content))
		    $page_content = $automobile_xmlObject->page_content;
		if (isset($automobile_xmlObject->page_sub_title))
		    $page_sub_title = $automobile_xmlObject->page_sub_title;
		foreach ($automobile_xmlObject->column_container as $column_container) {
		    automobile_column_pb(1);
		}
	    }
	    ?>

	</div>
	<div class="clear"></div>
	<div class="add-widget"> <span class="addwidget"> <a href="javascript:ajaxSubmit('automobile_column_pb','1','column_full')"><i class="icon-plus-circle"></i> <?php echo automobile_var_frame_text_srt('automobile_var_add_page_section'); ?> </a> </span> 
	    <div id="loading" class="builderload"></div>
	    <div class="clear"></div>
	    <input type="hidden" name="page_builder_form" value="1" />
	    <div class="clear"></div>
	</div>
	<div class="clear"></div>

	<script type="text/javascript">
	    var count_widget = <?php echo absint($count_widget); ?>;
	    jQuery(function () {
	        jQuery(".draginner").sortable({
	            connectWith: '.draginner',
	            handle: '.column-in',
	            start: function (event, ui) {
	                jQuery(ui.item).css({"width": "25%"});
	            },
	            cancel: '.draginner .poped-up,#confirmOverlay',
	            revert: false,
	            receive: function (event, ui) {
	                callme();
	            },
	            placeholder: "ui-state-highlight",
	            forcePlaceholderSize: true
	        });
	        jQuery("#add_page_builder_item").sortable({
	            handle: '.column-in',
	            connectWith: ".columnmain",
	            cancel: '.column_container,.draginner,#confirmOverlay',
	            revert: false,
	            placeholder: "ui-state-highlight",
	            forcePlaceholderSize: true
	        });

	    });
	    function ajaxSubmit(action, total_column, column_class) {
	        counter++;
	        count_widget++;
	        jQuery('.builderload').html("<img src='<?php echo automobile_var_frame()->plugin_url() . 'assets/images/ajax_loading.gif' ?>' />");
	        var newCustomerForm = "action=" + action + '&counter=' + counter + '&total_column=' + total_column + '&column_class=' + column_class + '&postID=<?php echo esc_js($postID); ?>';

	        jQuery.ajax({
	            type: "POST",
	            url: "<?php echo admin_url('admin-ajax.php') ?>",
	            data: newCustomerForm,
	            success: function (data) {
	                jQuery('.builderload').html("");
	                jQuery("#add_page_builder_item").append(data);
	                jQuery('div.cs-drag-slider').each(function () {
	                    var _this = jQuery(this);
	                    _this.slider({
	                        range: 'min',
	                        step: _this.data('slider-step'),
	                        min: _this.data('slider-min'),
	                        max: _this.data('slider-max'),
	                        value: _this.data('slider-value'),
	                        slide: function (event, ui) {
	                            jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
	                        }
	                    });
	                });
	                jQuery('.bg_color').wpColorPicker();
	                jQuery(".draginner").sortable({
	                    connectWith: '.draginner',
	                    handle: '.column-in',
	                    cancel: '.draginner .poped-up,#confirmOverlay',
	                    revert: false,
	                    start: function (event, ui) {
	                        jQuery(ui.item).css({"width": "25%"})
	                    },
	                    receive: function (event, ui) {
	                        automobile_frame_callme();
	                    },
	                    placeholder: "ui-state-highlight",
	                    forcePlaceholderSize: true
	                });

	            }
	        });

	    }

	    function automobile_frame_ajax_widget(action, id) {
	        automobile_frame_loader();
	        counter++;
	        var newCustomerForm = "action=" + action + '&counter=' + counter;
	        var edit_url = action + counter;

	        jQuery.ajax({
	            type: "POST",
	            url: "<?php echo admin_url('admin-ajax.php') ?>",
	            data: newCustomerForm,
	            success: function (data) {
	                jQuery("#counter_" + id).append(data);
	                jQuery("#" + action + counter).append('<input type="hidden" name="automobile_widget_element_num[]" value="form" />');
	                jQuery('.bg_color').wpColorPicker();
	                jQuery(".draginner").sortable({
	                    connectWith: '.draginner',
	                    handle: '.column-in',
	                    cancel: '.draginner .poped-up,#confirmOverlay',
	                    revert: false,
	                    receive: function (event, ui) {
	                        automobile_frame_callme();
	                    },
	                    placeholder: "ui-state-highlight",
	                    forcePlaceholderSize: true
	                });
	                automobile_frame_removeoverlay("composer-" + id, "append");
	                jQuery('div.cs-drag-slider').each(function () {
	                    var _this = jQuery(this);
	                    _this.slider({
	                        range: 'min',
	                        step: _this.data('slider-step'),
	                        min: _this.data('slider-min'),
	                        max: _this.data('slider-max'),
	                        value: _this.data('slider-value'),
	                        slide: function (event, ui) {
	                            jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
	                        }
	                    });
	                });
	                automobile_frame_callme();
	                chosen_selectionbox();
	                jQuery('[data-toggle="popover"]').popover();
	            }
	        });
	    }
	    function automobile_frame_ajax_widget_element(action, id, name) {

	        automobile_frame_loader();
	        counter++;
	        var newCustomerForm = "action=" + action + '&element_name=' + name + '&counter=' + counter;
	        var edit_url = action + counter;

	        jQuery.ajax({
	            type: "POST",
	            url: "<?php echo admin_url('admin-ajax.php') ?>",
	            data: newCustomerForm,
	            success: function (data) {
	                jQuery("#counter_" + id).append(data);

	                jQuery("#counter_" + id + " #results-shortocde-id-form").append('<input type="hidden" name="automobile_widget_element_num[]" value="form" />');
	                jQuery('.bg_color').wpColorPicker();
	                jQuery(".draginner").sortable({
	                    connectWith: '.draginner',
	                    handle: '.column-in',
	                    cancel: '.draginner .poped-up,#confirmOverlay',
	                    revert: false,
	                    receive: function (event, ui) {
	                        automobile_frame_callme();
	                    },
	                    placeholder: "ui-state-highlight",
	                    forcePlaceholderSize: true
	                });
	                automobile_frame_removeoverlay("composer-" + id, "append");
	                jQuery('div.cs-drag-slider').each(function () {
	                    var _this = jQuery(this);
	                    _this.slider({
	                        range: 'min',
	                        step: _this.data('slider-step'),
	                        min: _this.data('slider-min'),
	                        max: _this.data('slider-max'),
	                        value: _this.data('slider-value'),
	                        slide: function (event, ui) {
	                            jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
	                        }
	                    });
	                });
	                automobile_frame_callme();
	            }
	        });
	    }
	    function automobile_frame_ajax_submit(action) {
	        counter++;
	        count_widget++;
	        var newCustomerForm = "action=" + action + '&counter=' + counter;
	        jQuery.ajax({
	            type: "POST",
	            url: "<?php echo admin_url() ?>/admin-ajax.php",
	            data: newCustomerForm,
	            success: function (data) {
	                jQuery("#add_page_builder_item").append(data);
	                if (count_widget > 0)
	                    jQuery("#add_page_builder_item").addClass('hasclass');

	            }
	        });

	    }
	</script>
	<?php
    }

}

/**
 * @Saving Data for Page Builder by POST ID
 *
 */
if (isset($_POST['page_builder_form']) and $_POST['page_builder_form'] == 1) {
    add_action('save_post', 'save_page_builder');
    if (!function_exists('save_page_builder')) {

	function save_page_builder($post_id) {
	    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	    if (isset($_POST['builder_active'])) {
		$sxe = new SimpleXMLElement("<pagebuilder></pagebuilder>");
		if (empty($_POST["builder_active"]))
		    $_POST["builder_active"] = "";
		if (empty($_POST["page_content"]))
		    $_POST["page_content"] = "";
		$sxe->addChild('builder_active', $_POST['builder_active']);
		$sxe->addChild('page_content', $_POST['page_content']);
                
		$automobile_counter = 0;
		$page_element_id = 0;
		$column_container_no = 0;
		$widget_no = 0;

		//Multi counter;
		$automobile_counter_counter = 0;
		$automobile_counter_counter_node = 0;
		$automobile_shortcode_counter_counter = 0;
		$automobile_global_counter_counter = 0;

		//Ads Packages
		$automobile_global_package = 0;
		$automobile_shortcode_counter_package = 0;
		$automobile_counter_package = 0;

		//Ads counters
		$automobile_global_ads = 0;
		$automobile_shortcode_counter_ads = 0;
		$automobile_counter_ads = 0;

		//inventory_type counters
		$automobile_global_inventory_type = 0;
		$automobile_shortcode_counter_inventory_type = 0;
		$automobile_counter_inventory_type = 0;

		//column counters
		$automobile_global_counter_column = 0;
		$automobile_shortcode_counter_column = 0;
		$automobile_counter_column = 0;

		//Contact Us counters
		$automobile_global_counter_contact_us = 0;
		$automobile_shortcode_counter_contact_us = 0;
		$automobile_counter_contact_us = 0;

		//Schedule counters
		$automobile_global_counter_schedule = 0;
		$automobile_shortcode_counter_schedule = 0;
		$automobile_counter_schedule = 0;

		//blog counters
		$automobile_global_counter_blog = 0;
		$automobile_shortcode_counter_blog = 0;
		$automobile_counter_blog = 0;


		//Services Counter
		$automobile_global_counter_services = 0;
		$automobile_shortcode_counter_services = 0;
		$automobile_counter_services = 0;

		//Services Counter
		$automobile_global_counter_price_services = 0;
		$automobile_shortcode_counter_price_services = 0;
		$automobile_counter_price_services = 0;

		//Map Counter
		$automobile_global_counter_map = 0;
		$automobile_shortcode_counter_map = 0;
		$automobile_counter_map = 0;


		//Heading Counter
		$automobile_global_counter_heading = 0;
		$automobile_shortcode_counter_heading = 0;
		$automobile_counter_heading = 0;



		//Video Counter
		$automobile_global_counter_video = 0;
		$automobile_shortcode_counter_video = 0;
		$automobile_counter_video = 0;

		//Image Frame Counter
		$automobile_global_counter_image_frame = 0;
		$automobile_shortcode_counter_image_frame = 0;
		$automobile_counter_image_frame = 0;


		//Multi Teams
		$automobile_shortcode_counter_team = 0;
		$automobile_global_counter_team = 0;
		$automobile_counter_team = 0;
		$automobile_counter_team_node = 0;

		$automobile_global_counter_list = 0;
		$automobile_shortcode_counter_list = 0;
		$automobile_counter_list_node = 0;
		$automobile_counter_list = 0;

		//testimonial;
		$automobile_counter_testimonial = 0;
		$automobile_counter_testimonial_node = 0;
		$automobile_shortcode_counter_testimonial = 0;
		$automobile_global_counter_testimonial = 0;

		//accordion;
		$automobile_counter_accordion = 0;
		$automobile_counter_accordion_node = 0;
		$automobile_shortcode_counter_accordion = 0;
		$automobile_global_counter_accordion = 0;

		//accordion;
		$automobile_counter_faq = 0;
		$automobile_counter_faq_node = 0;
		$automobile_shortcode_counter_faq = 0;
		$automobile_global_counter_faq = 0;

		//clients;
		$automobile_counter_clients = 0;
		$automobile_counter_clients_node = 0;
		$automobile_shortcode_counter_clients = 0;
		$automobile_global_counter_clients = 0;


		//Price Table;
		$automobile_counter_price_table = 0;
		$automobile_counter_price_table_node = 0;
		$automobile_shortcode_counter_price_table = 0;
		$automobile_global_counter_price_table = 0;

		//Partner;
		$automobile_counter_partner = 0;
		$automobile_counter_partner_node = 0;
		$automobile_shortcode_counter_partner = 0;
		$automobile_global_counter_partner = 0;

		//multi_services;
		$automobile_counter_icon_boxes = 0;
		$automobile_counter_icon_boxes_node = 0;
		$automobile_shortcode_counter_icon_boxes = 0;
		$automobile_global_counter_icon_boxes = 0;


		//Button  Counter
		$automobile_global_counter_button = 0;
		$automobile_shortcode_counter_button = 0;
		$automobile_counter_button = 0;

		//Woocommerce Featured Product
		$automobile_global_counter_woo_feature = 0;
		$automobile_shortcode_counter_woo_feature = 0;
		$automobile_counter_woo_feature = 0;
		// sapcer

		$automobile_counter_spacer = 0;
		$automobile_shortcode_counter_spacer = 0;
		$automobile_global_counter_spacer = 0;

		// Divider

		$automobile_counter_divider = 0;
		$automobile_shortcode_counter_divider = 0;
		$automobile_global_counter_divider = 0;

		//flex editor

		$automobile_counter_editor = 0;
		$automobile_shortcode_counter_editor = 0;
		$automobile_global_counter_editor = 0;


		//quote

		$automobile_counter_quote = 0;
		$automobile_shortcode_counter_quote = 0;
		$automobile_global_counter_quote = 0;

		//dropcap

		$automobile_counter_dropcap = 0;
		$automobile_shortcode_counter_dropcap = 0;
		$automobile_global_counter_dropcap = 0;


		//Maintenance Page 
		$automobile_global_counter_maintenance = 0;
		$automobile_shortcode_counter_maintenance = 0;
		$automobile_counter_maintenance = 0;

		//tabs;
		$automobile_counter_tabs = 0;
		$automobile_counter_tabs_node = 0;
		$automobile_shortcode_counter_tabs = 0;
		$automobile_global_counter_tabs = 0;

		//Dealer
		$automobile_counter_dealer = 0;
		$automobile_global_counter_dealer = 0;
		$automobile_shortcode_counter_dealer = 0;


		//Inventory
		$automobile_counter_inventory = 0;
		$automobile_global_counter_inventory = 0;
		$automobile_shortcode_counter_inventory = 0;

		//Inventory Search
		$automobile_counter_inventory_search = 0;
		$automobile_global_counter_inventory_search = 0;
		$automobile_shortcode_counter_inventory_search = 0;

		//Compare Inventory
		$automobile_counter_compare_inventory = 0;
		$automobile_global_counter_compare_inventory = 0;
		$automobile_shortcode_counter_compare_inventory = 0;

		//Listing Price;
		$automobile_counter_listing_price = 0;
		$automobile_counter_listing_price_node = 0;
		$automobile_shortcode_counter_listing_price = 0;
		$automobile_global_counter_listing_price = 0;

		//Site map
		$automobile_global_counter_sitemap = 0;
		$automobile_shortcode_counter_sitemap = 0;
		$automobile_counter_sitemap = 0;

		//Call To Action;
		$automobile_counter_call_to_action = 0;
		$automobile_shortcode_counter_call_to_action = 0;
		$automobile_global_counter_call_to_action = 0;

		//Tweets Counter;
		$automobile_counter_tweets = 0;
		$automobile_shortcode_counter_tweets = 0;
		$automobile_global_counter_tweets = 0;

		//progressbar
		$automobile_counter_progressbars = 0;
		$automobile_counter_progressbars_node = 0;
		$automobile_global_counter_progressbars = 0;
		$automobile_shortcode_counter_progressbars = 0;

		// Register Counter;
		$automobile_counter_register = 0;
		$automobile_global_counter_register = 0;
		$automobile_shortcode_counter_register = 0;

		// Table 
		$automobile_counter_table = 0;
		$automobile_global_counter_table = 0;
		$automobile_shortcode_counter_table = 0;


		if (isset($_POST['total_column'])) {
		    foreach ($_POST['total_column'] as $count_column) {
			// Sections Element Attributes start
			$column_container = $sxe->addChild('column_container');
			if (empty($_POST['column_class'][$column_container_no]))
			    $_POST['column_class'][$column_container_no] = "";
			$column_container->addAttribute('class', $_POST['column_class'][$column_container_no]);
			$column_rand_id = $_POST['column_rand_id'][$column_container_no];

			//automobile_section_background_option
			if (empty($_POST['automobile_var_section_title_array'][$column_container_no]))
			    $_POST['automobile_var_section_title_array'][$column_container_no] = "";
			if (empty($_POST['automobile_var_section_subtitle_array'][$column_container_no]))
			    $_POST['automobile_var_section_subtitle_array'][$column_container_no] = "";
			if (empty($_POST['title_sub_title_alignment'][$column_container_no]))
			    $_POST['title_sub_title_alignment'][$column_container_no] = "";
			if (empty($_POST['automobile_section_background_option'][$column_container_no]))
			    $_POST['automobile_section_background_option'][$column_container_no] = "";
			if (empty($_POST['automobile_var_section_bg_image_array'][$column_container_no]))
			    $_POST['automobile_var_section_bg_image_array'][$column_container_no] = "";
			if (empty($_POST['automobile_section_bg_image_position'][$column_container_no]))
			    $_POST['automobile_section_bg_image_position'][$column_container_no] = "";
			if (empty($_POST['automobile_section_bg_image_repeat'][$column_container_no]))
			    $_POST['automobile_section_bg_image_repeat'][$column_container_no] = "";
			if (empty($_POST['automobile_section_flex_slider'][$column_container_no]))
			    $_POST['automobile_section_flex_slider'][$column_container_no] = "";
			if (empty($_POST['automobile_section_video_url'][$column_container_no]))
			   // $_POST['automobile_section_video_url'][$column_container_no] = "";
			if (empty($_POST['automobile_section_video_mute'][$column_container_no]))
			    $_POST['automobile_section_video_mute'][$column_container_no] = "";
			if (empty($_POST['automobile_section_video_autoplay'][$column_container_no]))
			    $_POST['automobile_section_video_autoplay'][$column_container_no] = "";
			if (empty($_POST['automobile_section_bg_color'][$column_container_no]))
			    $_POST['automobile_section_bg_color'][$column_container_no] = "";
			if (empty($_POST['automobile_section_padding_top'][$column_container_no]))
			    $_POST['automobile_section_padding_top'][$column_container_no] = "";
			if (empty($_POST['automobile_section_padding_bottom'][$column_container_no]))
			    $_POST['automobile_section_padding_bottom'][$column_container_no] = "";
			if (empty($_POST['automobile_section_nopadding'][$column_container_no]['0']))
			    $_POST['automobile_section_nopadding'][$column_container_no]['0'] = "";
			if (empty($_POST['automobile_section_nomargin'][$column_container_no]))
			    $_POST['automobile_section_nomargin'][$column_container_no] = "";
			if (empty($_POST['automobile_section_parallax'][$column_container_no]))
			    $_POST['automobile_section_parallax'][$column_container_no] = "";
			if (empty($_POST['automobile_section_css_id'][$column_container_no]))
			    $_POST['automobile_section_css_id'][$column_container_no] = "";
			if (empty($_POST['automobile_section_view'][$column_rand_id]['0']))
			    $_POST['automobile_section_view'][$column_rand_id] = "";
			if (empty($_POST['automobile_layout'][$column_rand_id]['0']))
			    $_POST['automobile_layout'][$column_rand_id]['0'] = "";
			$column_container->addAttribute('automobile_var_section_title', isset($_POST['automobile_var_section_title_array'][$column_container_no]) ? $_POST['automobile_var_section_title_array'][$column_container_no] : '');
			$column_container->addAttribute('automobile_var_section_subtitle', isset($_POST['automobile_var_section_subtitle_array'][$column_container_no]) ? $_POST['automobile_var_section_subtitle_array'][$column_container_no] : '');
			$column_container->addAttribute('title_sub_title_alignment', isset($_POST['title_sub_title_alignment'][$column_container_no]) ? $_POST['title_sub_title_alignment'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_background_option', isset($_POST['automobile_section_background_option'][$column_container_no]) ? $_POST['automobile_section_background_option'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_bg_image', isset($_POST['automobile_var_section_bg_image_array'][$column_container_no]) ? $_POST['automobile_var_section_bg_image_array'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_bg_image_position', isset($_POST['automobile_section_bg_image_position'][$column_container_no]) ? $_POST['automobile_section_bg_image_position'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_bg_image_repeat', isset($_POST['automobile_section_bg_image_repeat'][$column_container_no]) ? $_POST['automobile_section_bg_image_repeat'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_flex_slider', isset($_POST['automobile_section_flex_slider'][$column_container_no]) ? $_POST['automobile_section_flex_slider'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_custom_slider', isset($_POST['automobile_section_custom_slider'][$column_container_no]) ? $_POST['automobile_section_custom_slider'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_video_url', isset($_POST['automobile_section_video_url'][$column_container_no]) ? $_POST['automobile_section_video_url'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_video_mute', isset($_POST['automobile_section_video_mute'][$column_container_no]) ? $_POST['automobile_section_video_mute'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_video_autoplay', isset($_POST['automobile_section_video_autoplay'][$column_container_no]) ? $_POST['automobile_section_video_autoplay'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_bg_color', isset($_POST['automobile_section_bg_color'][$column_container_no]) ? $_POST['automobile_section_bg_color'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_padding_top', isset($_POST['automobile_section_padding_top'][$column_container_no]) ? $_POST['automobile_section_padding_top'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_padding_bottom', isset($_POST['automobile_section_padding_bottom'][$column_container_no]) ? $_POST['automobile_section_padding_bottom'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_border_bottom', isset($_POST['automobile_section_border_bottom'][$column_container_no]) ? $_POST['automobile_section_border_bottom'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_border_top', isset($_POST['automobile_section_border_top'][$column_container_no]) ? $_POST['automobile_section_border_top'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_border_color', isset($_POST['automobile_section_border_color'][$column_container_no]) ? $_POST['automobile_section_border_color'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_margin_top', isset($_POST['automobile_section_margin_top'][$column_container_no]) ? $_POST['automobile_section_margin_top'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_margin_bottom', isset($_POST['automobile_section_margin_bottom'][$column_container_no]) ? $_POST['automobile_section_margin_bottom'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_nopadding', isset($_POST['automobile_section_nopadding'][$column_container_no]) ? $_POST['automobile_section_nopadding'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_parallax', isset($_POST['automobile_section_parallax'][$column_container_no]) ? $_POST['automobile_section_parallax'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_nomargin', isset($_POST['automobile_section_nomargin'][$column_container_no]) ? $_POST['automobile_section_nomargin'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_css_id', isset($_POST['automobile_section_css_id'][$column_container_no]) ? $_POST['automobile_section_css_id'][$column_container_no] : '');
			$column_container->addAttribute('automobile_section_view', isset($_POST['automobile_section_view'][$column_container_no]) ? $_POST['automobile_section_view'][$column_container_no] : '');
			$column_container->addAttribute('automobile_layout', isset($_POST['automobile_layout'][$column_rand_id]['0']) ? $_POST['automobile_layout'][$column_rand_id]['0'] : '');
			$column_container->addAttribute('automobile_sidebar_left', isset($_POST['automobile_sidebar_left'][$column_container_no]) ? $_POST['automobile_sidebar_left'][$column_container_no] : '');
			$column_container->addAttribute('automobile_sidebar_right', isset($_POST['automobile_sidebar_right'][$column_container_no]) ? $_POST['automobile_sidebar_right'][$column_container_no] : '');
			// Sections Element Attributes end
			for ($i = 0; $i < $count_column; $i++) {
			    $column = $column_container->addChild('column');
			    $a = $_POST['total_widget'][$widget_no];
			    for ($j = 1; $j <= $a; $j++) {
				$page_element_id++;

				// Save Column page element 

				if ($_POST['automobile_orderby'][$automobile_counter] == "flex_column") {
				    $shortcode = '';
				    $flex_column = $column->addChild('flex_column');
				    $flex_column->addChild('page_element_size', htmlspecialchars($_POST['flex_column_element_size'][$automobile_global_counter_column]));
				    $flex_column->addChild('flex_column_element_size', htmlspecialchars($_POST['flex_column_element_size'][$automobile_global_counter_column]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['flex_column'][$automobile_shortcode_counter_column]), ENT_QUOTES));
					$automobile_shortcode_counter_column++;
					$flex_column->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_column ';
					if (isset($_POST['automobile_var_column_section_title'][$automobile_counter_column]) && $_POST['automobile_var_column_section_title'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_section_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_column_section_title'][$automobile_counter_column]), ENT_QUOTES)) . '" ';
					}


					if (isset($_POST['automobile_column_margin_left'][$automobile_counter_column]) && $_POST['automobile_column_margin_left'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_column_margin_left="' . stripslashes(htmlspecialchars(($_POST['automobile_column_margin_left'][$automobile_counter_column]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_column_margin_right'][$automobile_counter_column]) && $_POST['automobile_column_margin_right'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_column_margin_right="' . stripslashes(htmlspecialchars(($_POST['automobile_column_margin_right'][$automobile_counter_column]), ENT_QUOTES)) . '" ';
					}

					if (isset($_POST['automobile_var_column_top_padding'][$automobile_counter_column]) && $_POST['automobile_var_column_top_padding'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_top_padding="' . stripslashes(htmlspecialchars(($_POST['automobile_var_column_top_padding'][$automobile_counter_column]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_column_bottom_padding'][$automobile_counter_column]) && $_POST['automobile_var_column_bottom_padding'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_bottom_padding="' . stripslashes(htmlspecialchars(($_POST['automobile_var_column_bottom_padding'][$automobile_counter_column]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_column_left_padding'][$automobile_counter_column]) && $_POST['automobile_var_column_left_padding'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_left_padding="' . stripslashes(htmlspecialchars(($_POST['automobile_var_column_left_padding'][$automobile_counter_column]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_column_right_padding'][$automobile_counter_column]) && $_POST['automobile_var_column_right_padding'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_right_padding="' . stripslashes(htmlspecialchars(($_POST['automobile_var_column_right_padding'][$automobile_counter_column]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_column_image_url_array'][$automobile_counter_column]) && $_POST['automobile_var_column_image_url_array'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_image_url_array="' . htmlspecialchars($_POST['automobile_var_column_image_url_array'][$automobile_counter_column], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_column_title_color'][$automobile_counter_column]) && $_POST['automobile_var_column_title_color'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_title_color="' . htmlspecialchars($_POST['automobile_var_column_title_color'][$automobile_counter_column], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_column_bg_color'][$automobile_counter_column]) && $_POST['automobile_var_column_bg_color'][$automobile_counter_column] != '') {
					    $shortcode .= 'automobile_var_column_bg_color="' . htmlspecialchars($_POST['automobile_var_column_bg_color'][$automobile_counter_column], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					if (isset($_POST['automobile_var_column_text'][$automobile_counter_column]) && $_POST['automobile_var_column_text'][$automobile_counter_column] != '') {
					    $shortcode .= htmlspecialchars($_POST['automobile_var_column_text'][$automobile_counter_column], ENT_QUOTES) . ' ';
					}
					$shortcode .= '[/automobile_column]';
					$flex_column->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_column++;
				    }
				    $automobile_global_counter_column++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "package") {
				    $automobile_var_package = '';
				    $package = $column->addChild('package');
				    $package->addChild('page_element_size', htmlspecialchars($_POST['package_element_size'][$automobile_global_package]));
				    $package->addChild('package_element_size', htmlspecialchars($_POST['package_element_size'][$automobile_global_package]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['package'][$automobile_shortcode_counter_package]), ENT_QUOTES));
					$automobile_shortcode_counter_package++;
					$package->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_var_package = '[automobile_package ';
					if (isset($_POST['automobile_package_title'][$automobile_counter_package]) && $_POST['automobile_package_title'][$automobile_counter_package] != '') {
					    $automobile_var_package .= 'automobile_package_title="' . stripslashes(htmlspecialchars(($_POST['automobile_package_title'][$automobile_counter_package]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_package_sub_title'][$automobile_counter_package]) && $_POST['automobile_package_sub_title'][$automobile_counter_package] != '') {
					    $automobile_var_package .= 'automobile_package_sub_title="' . stripslashes(htmlspecialchars(($_POST['automobile_package_sub_title'][$automobile_counter_package]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_pkg_id'][$automobile_counter_package]) && $_POST['automobile_pkg_id'][$automobile_counter_package] != '') {
					    $automobile_pkg_id = $_POST['automobile_pkg_id'][$automobile_counter_package];
					    if (isset($_POST['inventory_pkges'][$automobile_pkg_id]) && $_POST['inventory_pkges'][$automobile_pkg_id] != '') {

						if (is_array($_POST['inventory_pkges'][$automobile_pkg_id])) {

						    $automobile_var_package .= ' inventory_pkges="' . implode(',', $_POST['inventory_pkges'][$automobile_pkg_id]) . '" ';
						}
					    }
					}

					if (isset($_POST['inventory_pkges'][$automobile_counter_package]) && $_POST['inventory_pkges'][$automobile_counter_package] != '') {
					    //  $automobile_var_package .= 'inventory_pkges="' . stripslashes(htmlspecialchars(($_POST['inventory_pkges'][$automobile_counter_package]), ENT_QUOTES)) . '" ';
					}
					$automobile_var_package .= ']';
					$automobile_var_package .= '[/automobile_package]';

					$package->addChild('automobile_shortcode', $automobile_var_package);
					$automobile_counter_package++;
				    }
				    $automobile_global_package++;
				}
				// Loops Short Code Start
				// Blog
				else if (isset($_POST['automobile_orderby'][$automobile_counter]) && $_POST['automobile_orderby'][$automobile_counter] == "blog") {
				    $shortcode = '';
				    $blog = $column->addChild('blog');
				    $blog->addChild('page_element_size', htmlspecialchars($_POST['blog_element_size'][$automobile_global_counter_blog]));
				    $blog->addChild('blog_element_size', htmlspecialchars($_POST['blog_element_size'][$automobile_global_counter_blog]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['blog'][$automobile_shortcode_counter_blog]);
					$automobile_shortcode_counter_blog++;
					$blog->addChild('automobile_shortcode', htmlspecialchars($shortcode_str));
				    } else {
					$shortcode = '[automobile_blog ';
					if (isset($_POST['automobile_blog_section_title'][$automobile_counter_blog]) && $_POST['automobile_blog_section_title'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_section_title="' . htmlspecialchars($_POST['automobile_blog_section_title'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_blog_description'][$automobile_counter_blog]) && $_POST['automobile_blog_description'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_description="' . htmlspecialchars($_POST['automobile_blog_description'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}if (isset($_POST['automobile_blog_cat'][$automobile_counter_blog]) && $_POST['automobile_blog_cat'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_cat="' . htmlspecialchars($_POST['automobile_blog_cat'][$automobile_counter_blog]) . '" ';
					}if (isset($_POST['automobile_blog_view'][$automobile_counter_blog]) && $_POST['automobile_blog_view'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_view="' . htmlspecialchars($_POST['automobile_blog_view'][$automobile_counter_blog]) . '" ';
					}if (isset($_POST['automobile_blog_excerpt'][$automobile_counter_blog]) && $_POST['automobile_blog_excerpt'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_excerpt="' . htmlspecialchars($_POST['automobile_blog_excerpt'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}if (isset($_POST['automobile_blog_num_post'][$automobile_counter_blog]) && $_POST['automobile_blog_num_post'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_num_post="' . htmlspecialchars($_POST['automobile_blog_num_post'][$automobile_counter_blog]) . '" ';
					}if (isset($_POST['automobile_blog_orderby'][$automobile_counter_blog]) && $_POST['automobile_blog_orderby'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_orderby="' . htmlspecialchars($_POST['automobile_blog_orderby'][$automobile_counter_blog]) . '" ';
					}if (isset($_POST['blog_pagination'][$automobile_counter_blog]) && $_POST['blog_pagination'][$automobile_counter_blog] != '') {
					    $shortcode .= 'blog_pagination="' . htmlspecialchars($_POST['blog_pagination'][$automobile_counter_blog]) . '" ';
					}if (isset($_POST['automobile_blog_class'][$automobile_counter_blog]) && $_POST['automobile_blog_class'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_class="' . htmlspecialchars($_POST['automobile_blog_class'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}if (isset($_POST['automobile_blog_animation'][$automobile_counter_blog]) && $_POST['automobile_blog_animation'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_blog_animation="' . htmlspecialchars($_POST['automobile_blog_animation'][$automobile_counter_blog]) . '" ';
					}
					$shortcode .= ']';
					$blog->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_blog++;
				    }
				    $automobile_global_counter_blog++;
				}
				// video fields
				else if (isset($_POST['automobile_orderby'][$automobile_counter]) && $_POST['automobile_orderby'][$automobile_counter] == "video") {
				    $shortcode = '';
				    $video = $column->addChild('video');
				    $video->addChild('page_element_size', htmlspecialchars($_POST['video_element_size'][$automobile_global_counter_video]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['video'][$automobile_shortcode_counter_video]);
					$automobile_shortcode_counter_video++;
					$video->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode .= '[automobile_video ';
					if (isset($_POST['automobile_var_video_title'][$automobile_counter_video]) && $_POST['automobile_var_video_title'][$automobile_counter_video] != '') {
					    $shortcode .= 'automobile_var_video_title="' . htmlspecialchars($_POST['automobile_var_video_title'][$automobile_counter_video], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_video_url'][$automobile_counter_video]) && $_POST['automobile_var_video_url'][$automobile_counter_video] != '') {
					    $shortcode .= 'automobile_var_video_url="' . htmlspecialchars($_POST['automobile_var_video_url'][$automobile_counter_video], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_video_width'][$automobile_counter_video]) && $_POST['automobile_var_video_width'][$automobile_counter_video] != '') {
					    $shortcode .= 'automobile_var_video_width="' . htmlspecialchars($_POST['automobile_var_video_width'][$automobile_counter_video]) . '" ';
					}

					if (isset($_POST['automobile_var_video_height'][$automobile_counter_video]) && $_POST['automobile_var_video_height'][$automobile_counter_video] != '') {
					    $shortcode .= 'automobile_var_video_height="' . htmlspecialchars($_POST['automobile_var_video_height'][$automobile_counter_video]) . '" ';
					}

					$shortcode .= ']';
					$video->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_video++;
				    }
				    $automobile_global_counter_video++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "inventory_type") {
				    $automobile_var_inventory_type = '';
				    $inventory_type = $column->addChild('inventory_type');
				    $inventory_type->addChild('page_element_size', htmlspecialchars($_POST['inventory_type_element_size'][$automobile_global_inventory_type]));
				    $inventory_type->addChild('inventory_type_element_size', htmlspecialchars($_POST['inventory_type_element_size'][$automobile_global_inventory_type]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['inventory_type'][$automobile_shortcode_counter_inventory_type]), ENT_QUOTES));
					$automobile_shortcode_counter_inventory_type++;
					$inventory_type->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_var_inventory_type = '[automobile_inventory_type ';
					if (isset($_POST['automobile_inventory_type_title'][$automobile_counter_inventory_type]) && $_POST['automobile_inventory_type_title'][$automobile_counter_inventory_type] != '') {
					    $automobile_var_inventory_type .= 'automobile_inventory_type_title="' . stripslashes(htmlspecialchars(($_POST['automobile_inventory_type_title'][$automobile_counter_inventory_type]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_inventory_type_sub_title'][$automobile_counter_inventory_type]) && $_POST['automobile_inventory_type_sub_title'][$automobile_counter_inventory_type] != '') {
					    $automobile_var_inventory_type .= 'automobile_inventory_type_sub_title="' . stripslashes(htmlspecialchars(($_POST['automobile_inventory_type_sub_title'][$automobile_counter_inventory_type]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_inventories'][$automobile_counter_inventory_type]) && $_POST['automobile_var_inventories'][$automobile_counter_inventory_type] != '') {
					    $automobile_var_inventory_type .= 'automobile_var_inventories="' . stripslashes(htmlspecialchars(($_POST['automobile_var_inventories'][$automobile_counter_inventory_type]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_inventories_style'][$automobile_counter_inventory_type]) && $_POST['automobile_var_inventories_style'][$automobile_counter_inventory_type] != '') {
					    $automobile_var_inventory_type .= 'automobile_var_inventories_style="' . stripslashes(htmlspecialchars(($_POST['automobile_var_inventories_style'][$automobile_counter_inventory_type]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_inventory_type_button_title'][$automobile_counter_inventory_type]) && $_POST['automobile_inventory_type_button_title'][$automobile_counter_inventory_type] != '') {
					    $automobile_var_inventory_type .= 'automobile_inventory_type_button_title="' . stripslashes(htmlspecialchars(($_POST['automobile_inventory_type_button_title'][$automobile_counter_inventory_type]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_inventory_type_button_url'][$automobile_counter_inventory_type]) && $_POST['automobile_inventory_type_button_url'][$automobile_counter_inventory_type] != '') {
					    $automobile_var_inventory_type .= 'automobile_inventory_type_button_url="' . stripslashes(htmlspecialchars(($_POST['automobile_inventory_type_button_url'][$automobile_counter_inventory_type]), ENT_QUOTES)) . '" ';
					}
					$automobile_var_inventory_type .= ']';
					$automobile_var_inventory_type .= '[/automobile_inventory_type]';

					$inventory_type->addChild('automobile_shortcode', $automobile_var_inventory_type);
					$automobile_counter_inventory_type++;
				    }
				    $automobile_global_inventory_type++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "blog") {
				    $shortcode = '';
				    $blog = $column->addChild('blog');
				    $blog->addChild('page_element_size', htmlspecialchars($_POST['blog_element_size'][$automobile_global_counter_blog]));
				    $blog->addChild('blog_element_size', htmlspecialchars($_POST['blog_element_size'][$automobile_global_counter_blog]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['blog'][$automobile_shortcode_counter_blog]), ENT_QUOTES));
					$automobile_shortcode_counter_blog++;
					$blog->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_blog ';
					if (isset($_POST['automobile_var_blog_title'][$automobile_counter_blog]) && $_POST['automobile_var_blog_title'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_blog_title'][$automobile_counter_blog]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_blog_subtitle'][$automobile_counter_blog]) && $_POST['automobile_var_blog_subtitle'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_subtitle="' . htmlspecialchars($_POST['automobile_var_blog_subtitle'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_category'][$automobile_counter_blog]) && $_POST['automobile_var_blog_category'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_category="' . htmlspecialchars($_POST['automobile_var_blog_category'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_column'][$automobile_counter_blog]) && $_POST['automobile_var_blog_column'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_column="' . htmlspecialchars($_POST['automobile_var_blog_column'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_view'][$automobile_counter_blog]) && $_POST['automobile_var_blog_view'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_view="' . htmlspecialchars($_POST['automobile_var_blog_view'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_orderby'][$automobile_counter_blog]) && $_POST['automobile_var_blog_orderby'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_orderby="' . htmlspecialchars($_POST['automobile_var_blog_orderby'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_description'][$automobile_counter_blog]) && $_POST['automobile_var_blog_description'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_description="' . htmlspecialchars($_POST['automobile_var_blog_description'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_excerpt'][$automobile_counter_blog]) && $_POST['automobile_var_blog_excerpt'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_excerpt="' . htmlspecialchars($_POST['automobile_var_blog_excerpt'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_num_post'][$automobile_counter_blog]) && $_POST['automobile_var_blog_num_post'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_num_post="' . htmlspecialchars($_POST['automobile_var_blog_num_post'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_blog_pagination'][$automobile_counter_blog]) && $_POST['automobile_var_blog_pagination'][$automobile_counter_blog] != '') {
					    $shortcode .= 'automobile_var_blog_pagination="' . htmlspecialchars($_POST['automobile_var_blog_pagination'][$automobile_counter_blog], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					if (isset($_POST['blog_text'][$automobile_counter_blog]) && $_POST['blog_text'][$automobile_counter_blog] != '') {
					    $shortcode .= htmlspecialchars($_POST['blog_text'][$automobile_counter_blog], ENT_QUOTES) . ' ';
					}
					$shortcode .= '[/automobile_blog]';

					$blog->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_blog++;
				    }
				    $automobile_global_counter_blog++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "heading") {
				    $automobile_var_heading = '';
				    $heading = $column->addChild('heading');
				    $heading->addChild('page_element_size', htmlspecialchars($_POST['heading_element_size'][$automobile_global_counter_heading]));
				    $heading->addChild('heading_element_size', htmlspecialchars($_POST['heading_element_size'][$automobile_global_counter_heading]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['heading'][$automobile_shortcode_counter_heading]), ENT_QUOTES));
					$automobile_shortcode_counter_heading++;
					$heading->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_var_heading = '[automobile_heading ';
					if (isset($_POST['heading_title'][$automobile_counter_heading]) && $_POST['heading_title'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'heading_title="' . htmlspecialchars($_POST['heading_title'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['sub_heading_title'][$automobile_counter_heading]) && $_POST['sub_heading_title'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'sub_heading_title="' . htmlspecialchars($_POST['sub_heading_title'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['heading_style'][$automobile_counter_heading]) && $_POST['heading_style'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'heading_style="' . htmlspecialchars($_POST['heading_style'][$automobile_counter_heading]) . '" ';
					}
					if (isset($_POST['heading_size'][$automobile_counter_heading]) && $_POST['heading_size'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'heading_size="' . htmlspecialchars($_POST['heading_size'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['letter_space'][$automobile_counter_heading]) && $_POST['letter_space'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'letter_space="' . htmlspecialchars($_POST['letter_space'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['line_height'][$automobile_counter_heading]) && $_POST['line_height'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'line_height="' . htmlspecialchars($_POST['line_height'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['heading_align'][$automobile_counter_heading]) && $_POST['heading_align'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'heading_align="' . htmlspecialchars($_POST['heading_align'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['heading_font_style'][$automobile_counter_heading]) && $_POST['heading_font_style'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'heading_font_style="' . htmlspecialchars($_POST['heading_font_style'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['heading_divider'][$automobile_counter_heading]) && $_POST['heading_divider'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'heading_divider="' . htmlspecialchars($_POST['heading_divider'][$automobile_counter_heading]) . '" ';
					}
					if (isset($_POST['heading_color'][$automobile_counter_heading]) && $_POST['heading_color'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'heading_color="' . htmlspecialchars($_POST['heading_color'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['color_title'][$automobile_counter_heading]) && $_POST['color_title'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= 'color_title="' . htmlspecialchars($_POST['color_title'][$automobile_counter_heading], ENT_QUOTES) . '" ';
					}

					$automobile_var_heading .= ']';
					if (isset($_POST['heading_content'][$automobile_counter_heading]) && $_POST['heading_content'][$automobile_counter_heading] != '') {
					    $automobile_var_heading .= htmlspecialchars($_POST['heading_content'][$automobile_counter_heading], ENT_QUOTES);
					}

					$automobile_var_heading .= '[/automobile_heading]';

					$heading->addChild('automobile_shortcode', $automobile_var_heading);
					$automobile_counter_heading++;
				    }
				    $automobile_global_counter_heading++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "testimonial") {
				    $shortcode = $shortcode_item = '';
				    $testimonial = $column->addChild('testimonial');
				    $testimonial->addChild('page_element_size', htmlspecialchars($_POST['testimonial_element_size'][$automobile_global_counter_testimonial]));
				    $testimonial->addChild('testimonial_element_size', htmlspecialchars($_POST['testimonial_element_size'][$automobile_global_counter_testimonial]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['testimonial'][$automobile_shortcode_counter_testimonial]);
					$automobile_shortcode_counter_testimonial++;
					$testimonial->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['testimonial_num'][$automobile_counter_testimonial]) && $_POST['testimonial_num'][$automobile_counter_testimonial] > 0) {
					    for ($i = 1; $i <= $_POST['testimonial_num'][$automobile_counter_testimonial]; $i++) {
						$shortcode_item .= '[testimonial_item ';

						if (isset($_POST['automobile_var_testimonial_author'][$automobile_counter_testimonial_node]) && $_POST['automobile_var_testimonial_author'][$automobile_counter_testimonial_node] != '') {
						    $shortcode_item .= 'automobile_var_testimonial_author="' . htmlspecialchars($_POST['automobile_var_testimonial_author'][$automobile_counter_testimonial_node], ENT_QUOTES) . '" ';
						}

						if (isset($_POST['automobile_var_testimonial_position'][$automobile_counter_testimonial_node]) && $_POST['automobile_var_testimonial_position'][$automobile_counter_testimonial_node] != '') {
						    $shortcode_item .= 'automobile_var_testimonial_position="' . htmlspecialchars($_POST['automobile_var_testimonial_position'][$automobile_counter_testimonial_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_testimonial_author_image_array'][$automobile_counter_testimonial_node]) && $_POST['automobile_var_testimonial_author_image_array'][$automobile_counter_testimonial_node] != '') {
						    $shortcode_item .= 'automobile_var_testimonial_author_image_array="' . $_POST['automobile_var_testimonial_author_image_array'][$automobile_counter_testimonial_node] . '" ';
						}

						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_testimonial_content'][$automobile_counter_testimonial_node]) && $_POST['automobile_var_testimonial_content'][$automobile_counter_testimonial_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_testimonial_content'][$automobile_counter_testimonial_node], ENT_QUOTES);
						}
						$shortcode_item .= '[/testimonial_item]';
						$automobile_counter_testimonial_node++;
					    }
					}
					$section_title = '';
					if (isset($_POST['automobile_var_testimonial_title'][$automobile_counter_testimonial]) && $_POST['automobile_var_testimonial_title'][$automobile_counter_testimonial] != '') {
					    $section_title .= 'automobile_var_testimonial_title="' . htmlspecialchars($_POST['automobile_var_testimonial_title'][$automobile_counter_testimonial], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_author_color'][$automobile_counter_testimonial]) && $_POST['automobile_var_author_color'][$automobile_counter_testimonial] != '') {
					    $section_title .= 'automobile_var_author_color="' . htmlspecialchars($_POST['automobile_var_author_color'][$automobile_counter_testimonial], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_position_color'][$automobile_counter_testimonial]) && $_POST['automobile_var_position_color'][$automobile_counter_testimonial] != '') {
					    $section_title .= 'automobile_var_position_color="' . htmlspecialchars($_POST['automobile_var_position_color'][$automobile_counter_testimonial], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_testimonial_sub_title'][$automobile_counter_testimonial]) && $_POST['automobile_var_testimonial_sub_title'][$automobile_counter_testimonial] != '') {
					    $section_title .= 'automobile_var_testimonial_sub_title="' . htmlspecialchars($_POST['automobile_var_testimonial_sub_title'][$automobile_counter_testimonial], ENT_QUOTES) . '" ';
					}

					$shortcode = '[automobile_testimonial ' . $section_title . ' ]' . $shortcode_item . '[/automobile_testimonial]';
					$testimonial->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_testimonial++;
				    }
				    $automobile_global_counter_testimonial++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "accordion") {
				    $shortcode = $shortcode_item = '';
				    $accordion = $column->addChild('accordion');
				    $accordion->addChild('page_element_size', htmlspecialchars($_POST['accordion_element_size'][$automobile_global_counter_accordion]));
				    $accordion->addChild('accordion_element_size', htmlspecialchars($_POST['accordion_element_size'][$automobile_global_counter_accordion]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['accordion'][$automobile_shortcode_counter_accordion]);
					$automobile_shortcode_counter_accordion++;
					$accordion->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['accordion_num'][$automobile_counter_accordion]) && $_POST['accordion_num'][$automobile_counter_accordion] > 0) {
					    for ($i = 1; $i <= $_POST['accordion_num'][$automobile_counter_accordion]; $i++) {
						$shortcode_item .= '[accordion_item ';

						if (isset($_POST['automobile_var_accordion_active'][$automobile_counter_accordion_node]) && $_POST['automobile_var_accordion_active'][$automobile_counter_accordion_node] != '') {
						    $shortcode_item .= 'automobile_var_accordion_active="' . htmlspecialchars($_POST['automobile_var_accordion_active'][$automobile_counter_accordion_node], ENT_QUOTES) . '" ';
						}

						if (isset($_POST['automobile_var_accordion_title'][$automobile_counter_accordion_node]) && $_POST['automobile_var_accordion_title'][$automobile_counter_accordion_node] != '') {
						    $shortcode_item .= 'automobile_var_accordion_title="' . htmlspecialchars($_POST['automobile_var_accordion_title'][$automobile_counter_accordion_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_icon_box'][$automobile_counter_accordion_node]) && $_POST['automobile_var_icon_box'][$automobile_counter_accordion_node] != '') {
						    $shortcode_item .= 'automobile_var_icon_box="' . htmlspecialchars($_POST['automobile_var_icon_box'][$automobile_counter_accordion_node], ENT_QUOTES) . '" ';
						}
						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_accordion_text'][$automobile_counter_accordion_node]) && $_POST['automobile_var_accordion_text'][$automobile_counter_accordion_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_accordion_text'][$automobile_counter_accordion_node], ENT_QUOTES);
						}
						$shortcode_item .= '[/accordion_item]';
						$automobile_counter_accordion_node++;
					    }
					}
					$section_title = '';

					if (isset($_POST['automobile_var_accordion_view'][$automobile_counter_accordion]) && $_POST['automobile_var_accordion_view'][$automobile_counter_accordion] != '') {
					    $section_title .= 'automobile_var_accordion_view="' . htmlspecialchars($_POST['automobile_var_accordion_view'][$automobile_counter_accordion], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_accordian_main_title'][$automobile_counter_accordion]) && $_POST['automobile_var_accordian_main_title'][$automobile_counter_accordion] != '') {
					    $section_title .= 'automobile_var_accordian_main_title="' . htmlspecialchars($_POST['automobile_var_accordian_main_title'][$automobile_counter_accordion], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_accordian_sub_title'][$automobile_counter_accordion]) && $_POST['automobile_var_accordian_sub_title'][$automobile_counter_accordion] != '') {
					    $section_title .= 'automobile_var_accordian_sub_title="' . htmlspecialchars($_POST['automobile_var_accordian_sub_title'][$automobile_counter_accordion], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_accordion_column'][$automobile_counter_accordion]) && $_POST['automobile_var_accordion_column'][$automobile_counter_accordion] != '') {
					    $section_title .= 'automobile_var_accordion_column="' . htmlspecialchars($_POST['automobile_var_accordion_column'][$automobile_counter_accordion], ENT_QUOTES) . '" ';
					}



					$shortcode = '[automobile_accordion ' . $section_title . ' ]' . $shortcode_item . '[/automobile_accordion]';
					$accordion->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_accordion++;
				    }
				    $automobile_global_counter_accordion++;
				} else if ($_POST['automobile_orderby'][$automobile_counter] == "faq") {
				    $shortcode = $shortcode_item = '';
				    $faq = $column->addChild('faq');
				    $faq->addChild('page_element_size', htmlspecialchars($_POST['faq_element_size'][$automobile_global_counter_faq]));
				    $faq->addChild('faq_element_size', htmlspecialchars($_POST['faq_element_size'][$automobile_global_counter_faq]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['faq'][$automobile_shortcode_counter_faq]);
					$automobile_shortcode_counter_faq++;
					$faq->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['faq_num'][$automobile_counter_faq]) && $_POST['faq_num'][$automobile_counter_faq] > 0) {
					    for ($i = 1; $i <= $_POST['faq_num'][$automobile_counter_faq]; $i++) {
						$shortcode_item .= '[faq_item ';

						if (isset($_POST['automobile_var_faq_active'][$automobile_counter_faq_node]) && $_POST['automobile_var_faq_active'][$automobile_counter_faq_node] != '') {
						    $shortcode_item .= 'automobile_var_faq_active="' . htmlspecialchars($_POST['automobile_var_faq_active'][$automobile_counter_faq_node], ENT_QUOTES) . '" ';
						}

						if (isset($_POST['automobile_var_faq_title'][$automobile_counter_faq_node]) && $_POST['automobile_var_faq_title'][$automobile_counter_faq_node] != '') {
						    $shortcode_item .= 'automobile_var_faq_title="' . htmlspecialchars($_POST['automobile_var_faq_title'][$automobile_counter_faq_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_icon_box'][$automobile_counter_faq_node]) && $_POST['automobile_var_icon_box'][$automobile_counter_faq_node] != '') {
						    $shortcode_item .= 'automobile_var_icon_box="' . htmlspecialchars($_POST['automobile_var_icon_box'][$automobile_counter_faq_node], ENT_QUOTES) . '" ';
						}
						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_faq_text'][$automobile_counter_faq_node]) && $_POST['automobile_var_faq_text'][$automobile_counter_faq_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_faq_text'][$automobile_counter_faq_node], ENT_QUOTES);
						}
						$shortcode_item .= '[/faq_item]';
						$automobile_counter_faq_node++;
					    }
					}
					$section_title = '';

					if (isset($_POST['automobile_var_faq_view'][$automobile_counter_faq]) && $_POST['automobile_var_faq_view'][$automobile_counter_faq] != '') {
					    $section_title .= 'automobile_var_faq_view="' . htmlspecialchars($_POST['automobile_var_faq_view'][$automobile_counter_faq], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_faq_main_title'][$automobile_counter_faq]) && $_POST['automobile_var_faq_main_title'][$automobile_counter_faq] != '') {
					    $section_title .= 'automobile_var_faq_main_title="' . htmlspecialchars($_POST['automobile_var_faq_main_title'][$automobile_counter_faq], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_faq_sub_title'][$automobile_counter_faq]) && $_POST['automobile_var_faq_sub_title'][$automobile_counter_faq] != '') {
					    $section_title .= 'automobile_var_faq_sub_title="' . htmlspecialchars($_POST['automobile_var_faq_sub_title'][$automobile_counter_faq], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_faq_column'][$automobile_counter_faq]) && $_POST['automobile_var_faq_column'][$automobile_counter_faq] != '') {
					    $section_title .= 'automobile_var_faq_column="' . htmlspecialchars($_POST['automobile_var_faq_column'][$automobile_counter_faq], ENT_QUOTES) . '" ';
					}



					$shortcode = '[automobile_faq ' . $section_title . ' ]' . $shortcode_item . '[/automobile_faq]';
					$faq->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_faq++;
				    }
				    $automobile_global_counter_faq++;
				} else if ($_POST['automobile_orderby'][$automobile_counter] == "progressbars") {
				    $shortcode = $shortcode_item = '';
				    $progressbars = $column->addChild('progressbars');
				    $progressbars->addChild('progressbars_element_size', $_POST['progressbars_element_size'][$automobile_global_counter_progressbars]);
				    $progressbars->addChild('page_element_size', $_POST['progressbars_element_size'][$automobile_global_counter_progressbars]);

				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['progressbars'][$automobile_shortcode_counter_progressbars]);
					$automobile_shortcode_counter_progressbars++;
					$progressbars->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {

					if (isset($_POST['progressbars_num'][$automobile_counter_progressbars]) && $_POST['progressbars_num'][$automobile_counter_progressbars] > 0) {
					    for ($i = 1; $i <= $_POST['progressbars_num'][$automobile_counter_progressbars]; $i++) {
						$shortcode_item .= '[progressbar_item ';
						if (isset($_POST['progressbars_title'][$automobile_counter_progressbars_node]) && $_POST['progressbars_title'][$automobile_counter_progressbars_node] != '') {
						    $shortcode_item .= 'progressbars_title="' . htmlspecialchars($_POST['progressbars_title'][$automobile_counter_progressbars_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['progressbars_percentage'][$automobile_counter_progressbars_node]) && $_POST['progressbars_percentage'][$automobile_counter_progressbars_node] != '') {
						    $shortcode_item .= 'progressbars_percentage="' . htmlspecialchars($_POST['progressbars_percentage'][$automobile_counter_progressbars_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['progressbars_color'][$automobile_counter_progressbars_node]) && $_POST['progressbars_color'][$automobile_counter_progressbars_node] != '') {
						    $shortcode_item .= 'progressbars_color="' . htmlspecialchars($_POST['progressbars_color'][$automobile_counter_progressbars_node], ENT_QUOTES) . '" ';
						}
						$shortcode_item .= ']';

						$automobile_counter_progressbars_node++;
					    }
					}

					$shortcode .= '[automobile_progressbar ';

					if (isset($_POST['progressbars_element_title'][$automobile_counter_progressbars]) && $_POST['progressbars_element_title'][$automobile_counter_progressbars] != '') {
					    $shortcode .= 'progressbars_element_title="' . htmlspecialchars($_POST['progressbars_element_title'][$automobile_counter_progressbars], ENT_QUOTES) . '" ';
					}

					$shortcode .= ']' . $shortcode_item . '[/automobile_progressbar]';
					$progressbars->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_progressbars++;
				    }
				    $automobile_global_counter_progressbars++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "list") {


				    $shortcode = $shortcode_item = '';
				    $list = $column->addChild('list');
				    $list->addChild('page_element_size', htmlspecialchars($_POST['list_element_size'][$automobile_global_counter_list]));
				    $list->addChild('list_element_size', htmlspecialchars($_POST['list_element_size'][$automobile_global_counter_list]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['list'][$automobile_shortcode_counter_list]);
					$automobile_shortcode_counter_list++;
					$list->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['list_num'][$automobile_counter_list]) && $_POST['list_num'][$automobile_counter_list] > 0) {
					    for ($i = 1; $i <= $_POST['list_num'][$automobile_counter_list]; $i++) {
						$shortcode_item .= '[automobile_list_item ';
						if (isset($_POST['automobile_var_list_item_text'][$automobile_counter_list_node]) && $_POST['automobile_var_list_item_text'][$automobile_counter_list_node] != '') {
						    $shortcode_item .= 'automobile_var_list_item_text="' . htmlspecialchars($_POST['automobile_var_list_item_text'][$automobile_counter_list_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_list_item_icon'][$automobile_counter_list_node]) && $_POST['automobile_var_list_item_icon'][$automobile_counter_list_node] != '') {
						    $shortcode_item .= 'automobile_var_list_item_icon="' . htmlspecialchars($_POST['automobile_var_list_item_icon'][$automobile_counter_list_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_list_item_icon_color'][$automobile_counter_list_node]) && $_POST['automobile_var_list_item_icon_color'][$automobile_counter_list_node] != '') {
						    $shortcode_item .= 'automobile_var_list_item_icon_color="' . htmlspecialchars($_POST['automobile_var_list_item_icon_color'][$automobile_counter_list_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_list_item_icon_bg_color'][$automobile_counter_list_node]) && $_POST['automobile_var_list_item_icon_bg_color'][$automobile_counter_list_node] != '') {
						    $shortcode_item .= 'automobile_var_list_item_icon_bg_color="' . htmlspecialchars($_POST['automobile_var_list_item_icon_bg_color'][$automobile_counter_list_node], ENT_QUOTES) . '" ';
						}
						$shortcode_item .= ']';
						$shortcode_item .= '[/automobile_list_item]';
						$automobile_counter_list_node++;
					    }
					}
					$section_title = '';
					if (isset($_POST['automobile_var_list_title'][$automobile_counter_list]) && $_POST['automobile_var_list_title'][$automobile_counter_list] != '') {
					    $section_title .= 'automobile_var_list_title="' . htmlspecialchars($_POST['automobile_var_list_title'][$automobile_counter_list], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_list_type'][$automobile_counter_list]) && $_POST['automobile_var_list_type'][$automobile_counter_list] != '') {
					    $section_title .= 'automobile_var_list_type="' . htmlspecialchars($_POST['automobile_var_list_type'][$automobile_counter_list], ENT_QUOTES) . '" ';
					}
					$shortcode = '[automobile_list ' . $section_title . ' ]' . $shortcode_item . '[/automobile_list]';

					$list->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_list++;
				    }
				    $automobile_global_counter_list++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "team") {

				    $shortcode = $shortcode_item = '';
				    $team = $column->addChild('team');
				    $team->addChild('page_element_size', htmlspecialchars($_POST['team_element_size'][$automobile_global_counter_team]));
				    $team->addChild('team_element_size', htmlspecialchars($_POST['team_element_size'][$automobile_global_counter_team]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['team'][$automobile_shortcode_counter_team]);
					$automobile_shortcode_counter_team++;
					$team->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['team_num'][$automobile_counter_team]) && $_POST['team_num'][$automobile_counter_team] > 0) {
					    for ($i = 1; $i <= $_POST['team_num'][$automobile_counter_team]; $i++) {
						$shortcode_item .= '[automobile_team_item ';

						if (isset($_POST['automobile_var_team_name'][$automobile_counter_team_node]) && $_POST['automobile_var_team_name'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_name="' . htmlspecialchars($_POST['automobile_var_team_name'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_team_designation'][$automobile_counter_team_node]) && $_POST['automobile_var_team_designation'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_designation="' . htmlspecialchars($_POST['automobile_var_team_designation'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}

						if (isset($_POST['automobile_var_team_image'][$automobile_counter_team_node]) && $_POST['automobile_var_team_image'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_image="' . htmlspecialchars($_POST['automobile_var_team_image'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_team_phone'][$automobile_counter_team_node]) && $_POST['automobile_var_team_phone'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_phone="' . htmlspecialchars($_POST['automobile_var_team_phone'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_team_fb'][$automobile_counter_team_node]) && $_POST['automobile_var_team_fb'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_fb="' . htmlspecialchars($_POST['automobile_var_team_fb'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_team_twitter'][$automobile_counter_team_node]) && $_POST['automobile_var_team_twitter'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_twitter="' . htmlspecialchars($_POST['automobile_var_team_twitter'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_team_google'][$automobile_counter_team_node]) && $_POST['automobile_var_team_google'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_google="' . htmlspecialchars($_POST['automobile_var_team_google'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_team_linkedin'][$automobile_counter_team_node]) && $_POST['automobile_var_team_linkedin'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_linkedin="' . htmlspecialchars($_POST['automobile_var_team_linkedin'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_team_youtube'][$automobile_counter_team_node]) && $_POST['automobile_var_team_youtube'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= 'automobile_var_team_youtube="' . htmlspecialchars($_POST['automobile_var_team_youtube'][$automobile_counter_team_node], ENT_QUOTES) . '" ';
						}

						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_team_text'][$automobile_counter_team_node]) && $_POST['automobile_var_team_text'][$automobile_counter_team_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_team_text'][$automobile_counter_team_node], ENT_QUOTES);
						}
						$shortcode_item .= '[/automobile_team_item]';
						$automobile_counter_team_node++;
					    }
					}
					$section_title = '';
					if (isset($_POST['automobile_var_team_title'][$automobile_counter_team]) && $_POST['automobile_var_team_title'][$automobile_counter_team] != '') {
					    $section_title .= 'automobile_var_team_title="' . htmlspecialchars($_POST['automobile_var_team_title'][$automobile_counter_team], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_team_sub_title'][$automobile_counter_team]) && $_POST['automobile_var_team_sub_title'][$automobile_counter_team] != '') {
					    $section_title .= 'automobile_var_team_sub_title="' . htmlspecialchars($_POST['automobile_var_team_sub_title'][$automobile_counter_team], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_team_col'][$automobile_counter_team]) && $_POST['automobile_var_team_col'][$automobile_counter_team] != '') {
					    $section_title .= 'automobile_var_team_col="' . htmlspecialchars($_POST['automobile_var_team_col'][$automobile_counter_team], ENT_QUOTES) . '" ';
					}

					$shortcode = '[automobile_team ' . $section_title . ' ]' . $shortcode_item . '[/automobile_team]';

					$team->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_team++;
				    }
				    $automobile_global_counter_team++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "clients") {
				    $shortcode = $shortcode_item = '';
				    $clients = $column->addChild('clients');
				    $clients->addChild('page_element_size', htmlspecialchars($_POST['clients_element_size'][$automobile_global_counter_clients]));
				    $clients->addChild('clients_element_size', htmlspecialchars($_POST['clients_element_size'][$automobile_global_counter_clients]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['clients'][$automobile_shortcode_counter_clients]);
					$automobile_shortcode_counter_clients++;
					$clients->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['clients_num'][$automobile_counter_clients]) && $_POST['clients_num'][$automobile_counter_clients] > 0) {
					    for ($i = 1; $i <= $_POST['clients_num'][$automobile_counter_clients]; $i++) {
						$shortcode_item .= '[clients_item ';

						if (isset($_POST['automobile_var_clients_position'][$automobile_counter_clients_node]) && $_POST['automobile_var_clients_position'][$automobile_counter_clients_node] != '') {
						    $shortcode_item .= 'automobile_var_clients_position="' . htmlspecialchars($_POST['automobile_var_clients_position'][$automobile_counter_clients_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_clients_img_user_array'][$automobile_counter_clients_node]) && $_POST['automobile_var_clients_img_user_array'][$automobile_counter_clients_node] != '') {
						    $shortcode_item .= 'automobile_var_clients_img_user_array="' . $_POST['automobile_var_clients_img_user_array'][$automobile_counter_clients_node] . '" ';
						}
						if (isset($_POST['automobile_var_clients_text'][$automobile_counter_clients_node]) && $_POST['automobile_var_clients_text'][$automobile_counter_clients_node] != '') {
						    $shortcode_item .= 'automobile_var_clients_text="' . $_POST['automobile_var_clients_text'][$automobile_counter_clients_node] . '" ';
						}

						if (isset($_POST['automobile_var_clients_author'][$automobile_counter_clients_node]) && $_POST['automobile_var_clients_author'][$automobile_counter_clients_node] != '') {
						    $shortcode_item .= 'automobile_var_clients_author="' . htmlspecialchars($_POST['automobile_var_clients_author'][$automobile_counter_clients_node], ENT_QUOTES) . '" ';
						}

						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_clients_text'][$automobile_counter_clients_node]) && $_POST['automobile_var_clients_text'][$automobile_counter_clients_node] != '') {
						    $shortcode_item .= 'automobile_var_clients_text="' . $_POST['automobile_var_clients_text'][$automobile_counter_clients_node] . '" ';
						}

						$shortcode_item .= '[/clients_item]';
						$automobile_counter_clients_node++;
					    }
					}
					$section_title = '';
					if (isset($_POST['automobile_var_clients_element_title'][$automobile_counter_clients]) && $_POST['automobile_var_clients_element_title'][$automobile_counter_clients] != '') {
					    $section_title .= 'automobile_var_clients_element_title="' . htmlspecialchars($_POST['automobile_var_clients_element_title'][$automobile_counter_clients], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_clients_perslide'][$automobile_counter_clients]) && $_POST['automobile_var_clients_perslide'][$automobile_counter_clients] != '') {
					    $section_title .= 'automobile_var_clients_perslide="' . htmlspecialchars($_POST['automobile_var_clients_perslide'][$automobile_counter_clients], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['clients_style'][$automobile_counter_clients]) && $_POST['clients_style'][$automobile_counter_clients] != '') {
					    $section_title .= 'clients_style="' . htmlspecialchars($_POST['clients_style'][$automobile_counter_clients], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_clients_text_color'][$automobile_counter_clients]) && $_POST['automobile_var_clients_text_color'][$automobile_counter_clients] != '') {
					    $section_title .= 'automobile_var_clients_text_color="' . htmlspecialchars($_POST['automobile_var_clients_text_color'][$automobile_counter_clients], ENT_QUOTES) . '" ';
					}

					$shortcode = '[automobile_clients ' . $section_title . ' ]' . $shortcode_item . '[/automobile_clients]';
					$clients->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_clients++;
				    }
				    $automobile_global_counter_clients++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "icon_box") {
				    $shortcode = $shortcode_item = '';

				    $icon_boxes = $column->addChild('icon_box');
				    $icon_boxes->addChild('page_element_size', htmlspecialchars($_POST['icon_box_element_size'][$automobile_global_counter_icon_boxes]));
				    $icon_boxes->addChild('icon_box_element_size', htmlspecialchars($_POST['icon_box_element_size'][$automobile_global_counter_icon_boxes]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['icon_box'][$automobile_shortcode_counter_icon_boxes]);
					$automobile_shortcode_counter_icon_boxes++;
					$icon_boxes->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['icon_boxes_num'][$automobile_counter_icon_boxes]) && $_POST['icon_boxes_num'][$automobile_counter_icon_boxes] > 0) {
					    for ($i = 1; $i <= $_POST['icon_boxes_num'][$automobile_counter_icon_boxes]; $i++) {
						$shortcode_item .= '[icon_boxes_item ';
						if (isset($_POST['automobile_var_icon_box_view'][$automobile_counter_icon_boxes_node]) && $_POST['automobile_var_icon_box_view'][$automobile_counter_icon_boxes_node] != '') {
						    $shortcode_item .= 'automobile_var_icon_box_view="' . htmlspecialchars($_POST['automobile_var_icon_box_view'][$automobile_counter_icon_boxes_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_icon_box_title'][$automobile_counter_icon_boxes_node]) && $_POST['automobile_var_icon_box_title'][$automobile_counter_icon_boxes_node] != '') {
						    $shortcode_item .= 'automobile_var_icon_box_title="' . htmlspecialchars($_POST['automobile_var_icon_box_title'][$automobile_counter_icon_boxes_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_link_url'][$automobile_counter_icon_boxes_node]) && $_POST['automobile_var_link_url'][$automobile_counter_icon_boxes_node] != '') {
						    $shortcode_item .= 'automobile_var_link_url="' . htmlspecialchars($_POST['automobile_var_link_url'][$automobile_counter_icon_boxes_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_icon_boxes_icon'][$automobile_counter_icon_boxes_node]) && $_POST['automobile_var_icon_boxes_icon'][$automobile_counter_icon_boxes_node] != '') {
						    $shortcode_item .= 'automobile_var_icon_boxes_icon="' . htmlspecialchars($_POST['automobile_var_icon_boxes_icon'][$automobile_counter_icon_boxes_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_icon_box_icon_type'][$automobile_counter_icon_boxes_node]) && $_POST['automobile_var_icon_box_icon_type'][$automobile_counter_icon_boxes_node] != '') {
						    $shortcode_item .= 'automobile_var_icon_box_icon_type="' . htmlspecialchars($_POST['automobile_var_icon_box_icon_type'][$automobile_counter_icon_boxes_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_icon_box_image'][$automobile_counter_icon_boxes_node]) && $_POST['automobile_var_icon_box_image'][$automobile_counter_icon_boxes_node] != '') {
						    $shortcode_item .= 'automobile_var_icon_box_image="' . htmlspecialchars($_POST['automobile_var_icon_box_image'][$automobile_counter_icon_boxes_node], ENT_QUOTES) . '" ';
						}

						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_icon_boxes_text'][$automobile_counter_icon_boxes_node]) && $_POST['automobile_var_icon_boxes_text'][$automobile_counter_icon_boxes_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_icon_boxes_text'][$automobile_counter_icon_boxes_node], ENT_QUOTES);
						}
						$shortcode_item .= '[/icon_boxes_item]';
						$automobile_counter_icon_boxes_node++;
					    }
					}
					$section_title = '';
					if (isset($_POST['automobile_var_icon_boxes_title'][$automobile_counter_icon_boxes]) && $_POST['automobile_var_icon_boxes_title'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_var_icon_boxes_title="' . htmlspecialchars($_POST['automobile_var_icon_boxes_title'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_title_color'][$automobile_counter_icon_boxes]) && $_POST['automobile_title_color'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_title_color="' . htmlspecialchars($_POST['automobile_title_color'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_icon_box_content_color'][$automobile_counter_icon_boxes]) && $_POST['automobile_icon_box_content_color'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_icon_box_content_color="' . htmlspecialchars($_POST['automobile_icon_box_content_color'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_icon_box_icon_color'][$automobile_counter_icon_boxes]) && $_POST['automobile_icon_box_icon_color'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_icon_box_icon_color="' . htmlspecialchars($_POST['automobile_icon_box_icon_color'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_icon_box_icon_size'][$automobile_counter_icon_boxes]) && $_POST['automobile_var_icon_box_icon_size'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_var_icon_box_icon_size="' . htmlspecialchars($_POST['automobile_var_icon_box_icon_size'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_icon_box_view'][$automobile_counter_icon_boxes]) && $_POST['automobile_var_icon_box_view'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_var_icon_box_view="' . htmlspecialchars($_POST['automobile_var_icon_box_view'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_icon_box_content_align'][$automobile_counter_icon_boxes]) && $_POST['automobile_icon_box_content_align'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_icon_box_content_align="' . htmlspecialchars($_POST['automobile_icon_box_content_align'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_icon_boxes_sub_title'][$automobile_counter_icon_boxes]) && $_POST['automobile_var_icon_boxes_sub_title'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_var_icon_boxes_sub_title="' . htmlspecialchars(str_replace('"', '\'', automobile_custom_shortcode_encode($_POST['automobile_var_icon_boxes_sub_title'][$automobile_counter_icon_boxes]))) . '" ';
					}

					if (isset($_POST['automobile_var_icon_box_column'][$automobile_counter_icon_boxes]) && $_POST['automobile_var_icon_box_column'][$automobile_counter_icon_boxes] != '') {
					    $section_title .= 'automobile_var_icon_box_column="' . htmlspecialchars($_POST['automobile_var_icon_box_column'][$automobile_counter_icon_boxes], ENT_QUOTES) . '" ';
					}

					$shortcode = '[icon_box ' . $section_title . ' ]' . $shortcode_item . '[/icon_box]';

					$icon_boxes->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_icon_boxes++;
				    }
				    $automobile_global_counter_icon_boxes++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "tabs") {


				    $shortcode = $shortcode_item = '';
				    $tabs = $column->addChild('tabs');
				    $tabs->addChild('page_element_size', htmlspecialchars($_POST['tabs_element_size'][$automobile_global_counter_tabs]));
				    $tabs->addChild('tabs_element_size', htmlspecialchars($_POST['tabs_element_size'][$automobile_global_counter_tabs]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['tabs'][$automobile_shortcode_counter_tabs]);
					$automobile_shortcode_counter_tabs++;
					$tabs->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {

					if (isset($_POST['tabs_num'][$automobile_counter_tabs]) && $_POST['tabs_num'][$automobile_counter_tabs] > 0) {
					    for ($i = 1; $i <= $_POST['tabs_num'][$automobile_counter_tabs]; $i++) {
						$shortcode_item .= '[automobile_tabs_item ';

						if (isset($_POST['automobile_var_tabs_item_text'][$automobile_counter_tabs_node]) && $_POST['automobile_var_tabs_item_text'][$automobile_counter_tabs_node] != '') {
						    $shortcode_item .= 'automobile_var_tabs_item_text="' . htmlspecialchars($_POST['automobile_var_tabs_item_text'][$automobile_counter_tabs_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_tabs_item_icon'][$automobile_counter_tabs_node]) && $_POST['automobile_var_tabs_item_icon'][$automobile_counter_tabs_node] != '') {
						    $shortcode_item .= 'automobile_var_tabs_item_icon="' . htmlspecialchars($_POST['automobile_var_tabs_item_icon'][$automobile_counter_tabs_node], ENT_QUOTES) . '" ';
						}
						/*
						  if (isset($_POST['automobile_var_tabs_desc'][$automobile_counter_tabs_node]) && $_POST['automobile_var_tabs_desc'][$automobile_counter_tabs_node] != '') {
						  $shortcode_item .= 'automobile_var_tabs_desc="' . htmlspecialchars($_POST['automobile_var_tabs_desc'][$automobile_counter_tabs_node], ENT_QUOTES) . '" ';
						  }
						 */
						if (isset($_POST['automobile_var_tabs_active'][$automobile_counter_tabs_node]) && $_POST['automobile_var_tabs_active'][$automobile_counter_tabs_node] != '') {
						    $shortcode_item .= 'automobile_var_tabs_active="' . htmlspecialchars($_POST['automobile_var_tabs_active'][$automobile_counter_tabs_node], ENT_QUOTES) . '" ';
						}
						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_tabs_desc'][$automobile_counter_tabs_node]) && $_POST['automobile_var_tabs_desc'][$automobile_counter_tabs_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_tabs_desc'][$automobile_counter_tabs_node], ENT_QUOTES);
						}

						$shortcode_item .= '[/automobile_tabs_item]';
						$automobile_counter_tabs_node++;
					    }
					}

					$section_title = '';
					if (isset($_POST['automobile_var_tabs_title'][$automobile_counter_tabs]) && $_POST['automobile_var_tabs_title'][$automobile_counter_tabs] != '') {
					    $section_title .= 'automobile_var_tabs_title="' . htmlspecialchars($_POST['automobile_var_tabs_title'][$automobile_counter_tabs], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_tabs_style'][$automobile_counter_tabs]) && $_POST['automobile_var_tabs_style'][$automobile_counter_tabs] != '') {
					    $section_title .= 'automobile_var_tabs_style="' . htmlspecialchars($_POST['automobile_var_tabs_style'][$automobile_counter_tabs], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_tabs_column'][$automobile_counter_tabs]) && $_POST['automobile_var_tabs_column'][$automobile_counter_tabs] != '') {
					    $section_title .= 'automobile_var_tabs_column="' . htmlspecialchars($_POST['automobile_var_tabs_column'][$automobile_counter_tabs], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_tabs_view'][$automobile_counter_tabs]) && $_POST['automobile_var_tabs_view'][$automobile_counter_tabs] != '') {
					    $section_title .= 'automobile_var_tabs_view="' . htmlspecialchars($_POST['automobile_var_tabs_view'][$automobile_counter_tabs], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_tabs_align'][$automobile_counter_tabs]) && $_POST['automobile_var_tabs_align'][$automobile_counter_tabs] != '') {
					    $section_title .= 'automobile_var_tabs_align="' . htmlspecialchars($_POST['automobile_var_tabs_align'][$automobile_counter_tabs], ENT_QUOTES) . '" ';
					}
					$shortcode = '[automobile_tabs ' . $section_title . ' ]' . $shortcode_item . '[/automobile_tabs]';

					$tabs->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_tabs++;
				    }
				    $automobile_global_counter_tabs++;
				} else if ($_POST['automobile_orderby'][$automobile_counter] == "table") {
				    $shortcode = '';
				    $table = $column->addChild('table');
				    $table->addChild('table_element_size', $_POST['table_element_size'][$automobile_global_counter_table]);
				    $table->addChild('page_element_size', $_POST['table_element_size'][$automobile_global_counter_table]);
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['table'][$automobile_shortcode_counter_table]);
					$automobile_shortcode_counter_table++;
					$table->addChild('automobile_shortcode', htmlspecialchars($shortcode_str));
				    } else {
					$shortcode .= '[automobile_table ';
					if (isset($_POST['automobile_table_element_title'][$automobile_counter_table]) && $_POST['automobile_table_element_title'][$automobile_counter_table] != '') {
					    $shortcode .= ' automobile_table_element_title="' . htmlspecialchars($_POST['automobile_table_element_title'][$automobile_counter_table], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					if (isset($_POST['automobile_table_content'][$automobile_counter_table]) && $_POST['automobile_table_content'][$automobile_counter_table] != '') {
					    $shortcode .= htmlspecialchars($_POST['automobile_table_content'][$automobile_counter_table], ENT_QUOTES);
					}
					$shortcode .= '[/automobile_table]';
					$table->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_table++;
				    }
				    $automobile_global_counter_table++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "counter") {

				    $shortcode = $shortcode_item = '';
				    $counter = $column->addChild('counter');
				    $counter->addChild('page_element_size', htmlspecialchars($_POST['counter_element_size'][$automobile_global_counter_counter]));
				    $counter->addChild('counter_element_size', htmlspecialchars($_POST['counter_element_size'][$automobile_global_counter_counter]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['counter'][$automobile_shortcode_counter_counter]);
					$automobile_shortcode_counter_counter++;
					$counter->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {

					if (isset($_POST['multi_counter_num'][$automobile_counter_counter]) && $_POST['multi_counter_num'][$automobile_counter_counter] > 0) {

					    for ($i = 1; $i <= $_POST['multi_counter_num'][$automobile_counter_counter]; $i++) {
						$shortcode_item .= '[multi_counter_item ';

						if (isset($_POST['automobile_var_icon'][$automobile_counter_counter_node]) && $_POST['automobile_var_icon'][$automobile_counter_counter_node] != '') {
						    $shortcode_item .= 'automobile_var_icon="' . htmlspecialchars($_POST['automobile_var_icon'][$automobile_counter_counter_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_title'][$automobile_counter_counter_node]) && $_POST['automobile_var_title'][$automobile_counter_counter_node] != '') {
						    $shortcode_item .= 'automobile_var_title="' . $_POST['automobile_var_title'][$automobile_counter_counter_node] . '" ';
						}

						if (isset($_POST['automobile_var_count'][$automobile_counter_counter_node]) && $_POST['automobile_var_count'][$automobile_counter_counter_node] != '') {
						    $shortcode_item .= 'automobile_var_count="' . $_POST['automobile_var_count'][$automobile_counter_counter_node] . '" ';
						}


						if (isset($_POST['automobile_var_content'][$automobile_counter_counter_node]) && $_POST['automobile_var_content'][$automobile_counter_counter_node] != '') {
						    $shortcode_item .= 'automobile_var_content="' . htmlspecialchars($_POST['automobile_var_content'][$automobile_counter_counter_node], ENT_QUOTES) . '" ';
						}

						$shortcode_item .= ']';
//                                                if (isset($_POST['automobile_var_content'][$automobile_counter_counter_node]) && $_POST['automobile_var_content'][$automobile_counter_counter_node] != '') {
//                                                    $shortcode_item .= 'automobile_var_content="' . htmlspecialchars($_POST['automobile_var_content'][$automobile_counter_counter_node], ENT_QUOTES) . '" ';
//                                                }

						if (isset($_POST['automobile_var_multi_counter_text'][$automobile_counter_counter_node]) && $_POST['automobile_var_multi_counter_text'][$automobile_counter_counter_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_multi_counter_text'][$automobile_counter_counter_node], ENT_QUOTES);
						}

						$shortcode_item .= '[/multi_counter_item]';
						$automobile_counter_counter_node++;
					    }
					}

					$section_title = '';
					if (isset($_POST['automobile_multi_counter_title'][$automobile_counter_counter]) && $_POST['automobile_multi_counter_title'][$automobile_counter_counter] != '') {
					    $section_title .= 'automobile_multi_counter_title="' . htmlspecialchars($_POST['automobile_multi_counter_title'][$automobile_counter_counter], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_multi_counter_sub_title'][$automobile_counter_counter]) && $_POST['automobile_multi_counter_sub_title'][$automobile_counter_counter] != '') {
					    $section_title .= 'automobile_multi_counter_sub_title="' . htmlspecialchars($_POST['automobile_multi_counter_sub_title'][$automobile_counter_counter], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_counter_col'][$automobile_counter_counter]) && $_POST['automobile_var_counter_col'][$automobile_counter_counter] != '') {
					    $section_title .= 'automobile_var_counter_col="' . htmlspecialchars($_POST['automobile_var_counter_col'][$automobile_counter_counter], ENT_QUOTES) . '" ';
					}


					if (isset($_POST['automobile_var_icon_color'][$automobile_counter_counter]) && $_POST['automobile_var_icon_color'][$automobile_counter_counter] != '') {
					    $section_title .= 'automobile_var_icon_color="' . htmlspecialchars($_POST['automobile_var_icon_color'][$automobile_counter_counter], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_count_color'][$automobile_counter_counter]) && $_POST['automobile_var_count_color'][$automobile_counter_counter] != '') {
					    $section_title .= 'automobile_var_count_color="' . htmlspecialchars($_POST['automobile_var_count_color'][$automobile_counter_counter], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_counters_view'][$automobile_counter_counter]) && $_POST['automobile_var_counters_view'][$automobile_counter_counter] != '') {
					    $section_title .= 'automobile_var_counters_view="' . htmlspecialchars($_POST['automobile_var_counters_view'][$automobile_counter_counter], ENT_QUOTES) . '" ';
					}

					$shortcode = '[multi_counter ' . $section_title . ' ]' . $shortcode_item . '[/multi_counter]';
					$counter->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_counter++;
				    }
				    $automobile_global_counter_counter++;
				} else if ($_POST['automobile_orderby'][$automobile_counter] == "sitemap") {
				    $shortcode = '';
				    $sitemap = $column->addChild('sitemap');
				    $sitemap->addChild('page_element_size', '100');
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['sitemap'][$automobile_shortcode_counter_spacer]);
					$automobile_shortcode_counter_sitemap++;
					$sitemap->addChild('automobile_shortcode', htmlspecialchars($shortcode_str));
				    } else {
					$shortcode .= '[' . automobile_sitemap . ' ';
					if (isset($_POST['automobile_sitemap_section_title'][$automobile_counter_sitemap]) && $_POST['automobile_sitemap_section_title'][$automobile_counter_sitemap] != '') {
					    $shortcode .= 'automobile_sitemap_section_title="' . htmlspecialchars($_POST['automobile_sitemap_section_title'][$automobile_counter_sitemap]) . '" ';
					}
					$shortcode .= ']';
					$sitemap->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_sitemap++;
				    }
				    $automobile_global_counter_sitemap++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "partner") {
				    $shortcode = $shortcode_item = '';
				    $partner = $column->addChild('partner');
				    $partner->addChild('page_element_size', htmlspecialchars($_POST['partner_element_size'][$automobile_global_counter_partner]));
				    $partner->addChild('partner_element_size', htmlspecialchars($_POST['partner_element_size'][$automobile_global_counter_partner]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['partner'][$automobile_shortcode_counter_partner]);
					$automobile_shortcode_counter_partner++;
					$partner->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['partner_num'][$automobile_counter_partner]) && $_POST['partner_num'][$automobile_counter_partner] > 0) {
					    for ($i = 1; $i <= $_POST['partner_num'][$automobile_counter_partner]; $i++) {
						$shortcode_item .= '[partner_item ';

						if (isset($_POST['automobile_var_partner_position'][$automobile_counter_partner_node]) && $_POST['automobile_var_partner_position'][$automobile_counter_partner_node] != '') {
						    $shortcode_item .= 'automobile_var_partner_position="' . htmlspecialchars($_POST['automobile_var_partner_position'][$automobile_counter_partner_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['automobile_var_partner_img_user_array'][$automobile_counter_partner_node]) && $_POST['automobile_var_partner_img_user_array'][$automobile_counter_partner_node] != '') {
						    $shortcode_item .= 'automobile_var_partner_img_user_array="' . $_POST['automobile_var_partner_img_user_array'][$automobile_counter_partner_node] . '" ';
						}

						if (isset($_POST['automobile_var_partner_author'][$automobile_counter_partner_node]) && $_POST['automobile_var_partner_author'][$automobile_counter_partner_node] != '') {
						    $shortcode_item .= 'automobile_var_partner_author="' . htmlspecialchars($_POST['automobile_var_partner_author'][$automobile_counter_partner_node], ENT_QUOTES) . '" ';
						}

						$shortcode_item .= ']';
						if (isset($_POST['automobile_var_partner_text'][$automobile_counter_partner_node]) && $_POST['automobile_var_partner_text'][$automobile_counter_partner_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_partner_text'][$automobile_counter_partner_node], ENT_QUOTES);
						}
						$shortcode_item .= '[/partner_item]';
						$automobile_counter_partner_node++;
					    }
					}
					$section_title = '';
					if (isset($_POST['automobile_var_partner_section_title'][$automobile_counter_partner]) && $_POST['automobile_var_partner_section_title'][$automobile_counter_partner] != '') {
					    $section_title .= 'automobile_var_partner_section_title="' . htmlspecialchars($_POST['automobile_var_partner_section_title'][$automobile_counter_partner], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['partner_style'][$automobile_counter_partner]) && $_POST['partner_style'][$automobile_counter_partner] != '') {
					    $section_title .= 'partner_style="' . htmlspecialchars($_POST['partner_style'][$automobile_counter_partner], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_partner_text_color'][$automobile_counter_partner]) && $_POST['automobile_var_partner_text_color'][$automobile_counter_partner] != '') {
					    $section_title .= 'automobile_var_partner_text_color="' . htmlspecialchars($_POST['automobile_var_partner_text_color'][$automobile_counter_partner], ENT_QUOTES) . '" ';
					}

					$shortcode = '[automobile_partner ' . $section_title . ' ]' . $shortcode_item . '[/automobile_partner]';
					$partner->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_partner++;
				    }
				    $automobile_global_counter_partner++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "tweets") {

				    $shortcode = '';
				    $tweet = $column->addChild('tweets');
				    $tweet->addChild('page_element_size', htmlspecialchars($_POST['tweets_element_size'][$automobile_global_counter_tweets]));
				    $tweet->addChild('tweets_element_size', htmlspecialchars($_POST['tweets_element_size'][$automobile_global_counter_tweets]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['tweets'][$automobile_shortcode_counter_tweets]);
					$automobile_shortcode_counter_tweets++;
					$tweet->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_tweets ';

					if (isset($_POST['automobile_var_tweets_user_name'][$automobile_counter_tweets]) && $_POST['automobile_var_tweets_user_name'][$automobile_counter_tweets] != '') {
					    $shortcode .= 'automobile_var_tweets_user_name="' . htmlspecialchars($_POST['automobile_var_tweets_user_name'][$automobile_counter_tweets]) . '" ';
					}
					if (isset($_POST['automobile_var_tweets_color'][$automobile_counter_tweets]) && $_POST['automobile_var_tweets_color'][$automobile_counter_tweets] != '') {
					    $shortcode .= 'automobile_var_tweets_color="' . htmlspecialchars($_POST['automobile_var_tweets_color'][$automobile_counter_tweets]) . '" ';
					}
					if (isset($_POST['automobile_var_no_of_tweets'][$automobile_counter_tweets]) && $_POST['automobile_var_no_of_tweets'][$automobile_counter_tweets] != '') {
					    $shortcode .= 'automobile_var_no_of_tweets="' . htmlspecialchars($_POST['automobile_var_no_of_tweets'][$automobile_counter_tweets]) . '" ';
					}
					if (isset($_POST['automobile_var_tweets_class'][$automobile_counter_tweets]) && $_POST['automobile_var_tweets_class'][$automobile_counter_tweets] != '') {
					    $shortcode .= 'automobile_var_tweets_class="' . htmlspecialchars($_POST['automobile_var_tweets_class'][$automobile_counter_tweets]) . '" ';
					}
					$shortcode .= ']';
					$tweet->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_tweets++;
				    }
				    $automobile_global_counter_tweets++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "price_services") {

				    $automobile_var_price_services_shortcode = '';
				    $automobile_var_price_services = $column->addChild('price_services');
				    $automobile_var_price_services->addChild('page_element_size', htmlspecialchars($_POST['price_services_element_size'][$automobile_global_counter_price_services]));
				    $automobile_var_price_services->addChild('price_services_element_size', htmlspecialchars($_POST['price_services_element_size'][$automobile_global_counter_price_services]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['price_services'][$automobile_shortcode_counter_price_services]), ENT_QUOTES));
					$automobile_shortcode_counter_price_services++;
					$automobile_var_price_services->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_var_price_services_shortcode = '[automobile_price_services ';
					if (isset($_POST['automobile_var_price_services_element_title'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_element_title'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_element_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_price_services_element_title'][$automobile_counter_price_services]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_element_subtitle'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_element_subtitle'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_element_subtitle="' . htmlspecialchars($_POST['automobile_var_price_services_element_subtitle'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_view'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_view'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_view="' . htmlspecialchars($_POST['automobile_var_price_services_view'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_category'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_category'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_category="' . htmlspecialchars($_POST['automobile_var_price_services_category'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_paging_filter_style'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_paging_filter_style'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_paging_filter_style="' . htmlspecialchars($_POST['automobile_var_price_services_paging_filter_style'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_column'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_column'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_column="' . htmlspecialchars($_POST['automobile_var_price_services_column'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_item_per_page'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_item_per_page'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_item_per_page="' . htmlspecialchars($_POST['automobile_var_price_services_item_per_page'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_excerpt'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_excerpt'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_excerpt="' . htmlspecialchars($_POST['automobile_varprice_services_excerpt'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_price_services_excerpt_length'][$automobile_counter_price_services]) && $_POST['automobile_var_price_services_excerpt_length'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= 'automobile_var_price_services_excerpt_length="' . htmlspecialchars($_POST['automobile_var_price_services_excerpt_length'][$automobile_counter_price_services], ENT_QUOTES) . '" ';
					}

					$automobile_var_price_services_shortcode .= ']';
					if (isset($_POST['price_services_text'][$automobile_counter_price_services]) && $_POST['price_services_text'][$automobile_counter_price_services] != '') {
					    $automobile_var_price_services_shortcode .= htmlspecialchars($_POST['price_services_text'][$automobile_counter_price_services], ENT_QUOTES) . ' ';
					}
					$automobile_var_price_services_shortcode .= '[/automobile_price_services]';

					$automobile_var_price_services->addChild('automobile_shortcode', $automobile_var_price_services_shortcode);

					$automobile_counter_price_services++;
				    }
				    $automobile_global_counter_price_services++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "map") {

				    $automobile_var_map_shortcode = '';
				    $automobile_var_map = $column->addChild('map');
				    $automobile_var_map->addChild('page_element_size', htmlspecialchars($_POST['map_element_size'][$automobile_global_counter_map]));
				    $automobile_var_map->addChild('map_element_size', htmlspecialchars($_POST['map_element_size'][$automobile_global_counter_map]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['map'][$automobile_shortcode_counter_map]), ENT_QUOTES));
					$automobile_shortcode_counter_map++;
					$automobile_var_map->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_var_map_shortcode = '[automobile_map ';
					if (isset($_POST['automobile_var_map_title'][$automobile_counter_map]) && $_POST['automobile_var_map_title'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_map_title'][$automobile_counter_map]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_map_height'][$automobile_counter_map]) && $_POST['automobile_var_map_height'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_height="' . htmlspecialchars($_POST['automobile_var_map_height'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_lat'][$automobile_counter_map]) && $_POST['automobile_var_map_lat'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_lat="' . htmlspecialchars($_POST['automobile_var_map_lat'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_lon'][$automobile_counter_map]) && $_POST['automobile_var_map_lon'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_lon="' . htmlspecialchars($_POST['automobile_var_map_lon'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_zoom'][$automobile_counter_map]) && $_POST['automobile_var_map_zoom'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_zoom="' . htmlspecialchars($_POST['automobile_var_map_zoom'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_map_info'][$automobile_counter_map]) && $_POST['automobile_var_map_info'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_info="' . htmlspecialchars($_POST['automobile_var_map_info'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_map_info_width'][$automobile_counter_map]) && $_POST['automobile_var_map_info_width'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_info_width="' . htmlspecialchars($_POST['automobile_var_map_info_width'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_map_info_height'][$automobile_counter_map]) && $_POST['automobile_var_map_info_height'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_info_height="' . htmlspecialchars($_POST['automobile_var_map_info_height'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_map_marker_icon_array'][$automobile_counter_map]) && $_POST['automobile_var_map_marker_icon_array'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_marker_icon="' . htmlspecialchars($_POST['automobile_var_map_marker_icon_array'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_show_marker'][$automobile_counter_map]) && $_POST['automobile_var_map_show_marker'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_show_marker="' . htmlspecialchars($_POST['automobile_var_map_show_marker'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_controls'][$automobile_counter_map]) && $_POST['automobile_var_map_controls'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_controls="' . htmlspecialchars($_POST['automobile_var_map_controls'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_draggable'][$automobile_counter_map]) && $_POST['automobile_var_map_draggable'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_draggable="' . htmlspecialchars($_POST['automobile_var_map_draggable'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_scrollwheel'][$automobile_counter_map]) && $_POST['automobile_var_map_scrollwheel'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_scrollwheel="' . htmlspecialchars($_POST['automobile_var_map_scrollwheel'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_map_border'][$automobile_counter_map]) && $_POST['automobile_var_map_border'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_border="' . htmlspecialchars($_POST['automobile_var_map_border'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_map_border_color'][$automobile_counter_map]) && $_POST['automobile_var_map_border_color'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= 'automobile_var_map_border_color="' . htmlspecialchars($_POST['automobile_var_map_border_color'][$automobile_counter_map], ENT_QUOTES) . '" ';
					}


					$automobile_var_map_shortcode .= ']';
					if (isset($_POST['map_text'][$automobile_counter_map]) && $_POST['map_text'][$automobile_counter_map] != '') {
					    $automobile_var_map_shortcode .= htmlspecialchars($_POST['map_text'][$automobile_counter_map], ENT_QUOTES) . ' ';
					}
					$automobile_var_map_shortcode .= '[/automobile_map]';

					$automobile_var_map->addChild('automobile_shortcode', $automobile_var_map_shortcode);

					$automobile_counter_map++;
				    }
				    $automobile_global_counter_map++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "image_frame") {

				    $automobile_var_image_frame = '';
				    $image_frame = $column->addChild('image_frame');
				    $image_frame->addChild('page_element_size', htmlspecialchars($_POST['image_frame_element_size'][$automobile_global_counter_image_frame]));
				    $image_frame->addChild('image_frame_element_size', htmlspecialchars($_POST['image_frame_element_size'][$automobile_global_counter_image_frame]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['image_frame'][$automobile_shortcode_counter_image_frame]), ENT_QUOTES));
					$automobile_shortcode_counter_image_frame++;
					$image_frame->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_var_image_frame = '[automobile_image_frame ';
					if (isset($_POST['automobile_var_contact_info_title'][$automobile_counter_image_frame]) && $_POST['automobile_var_contact_info_title'][$automobile_counter_image_frame] != '') {
					    $automobile_var_image_frame .= 'automobile_var_contact_info_title="' . htmlspecialchars($_POST['automobile_var_contact_info_title'][$automobile_counter_image_frame], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_image_section_title'][$automobile_counter_image_frame]) && $_POST['automobile_var_image_section_title'][$automobile_counter_image_frame] != '') {
					    $automobile_var_image_frame .= 'automobile_var_image_section_title="' . htmlspecialchars($_POST['automobile_var_image_section_title'][$automobile_counter_image_frame], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_image_title'][$automobile_counter_image_frame]) && $_POST['automobile_var_image_title'][$automobile_counter_image_frame] != '') {
					    $automobile_var_image_frame .= 'automobile_var_image_title="' . htmlspecialchars($_POST['automobile_var_image_title'][$automobile_counter_image_frame], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_frame_image_url_array'][$automobile_counter_image_frame]) && $_POST['automobile_var_frame_image_url_array'][$automobile_counter_image_frame] != '') {
					    $automobile_var_image_frame .= 'automobile_var_frame_image_url_array="' . htmlspecialchars($_POST['automobile_var_frame_image_url_array'][$automobile_counter_image_frame], ENT_QUOTES) . '" ';
					}

					$automobile_var_image_frame .= ']';
					if (isset($_POST['automobile_var_image_description'][$automobile_counter_image_frame]) && $_POST['automobile_var_image_description'][$automobile_counter_image_frame] != '') {
					    $automobile_var_image_frame .= htmlspecialchars($_POST['automobile_var_image_description'][$automobile_counter_image_frame], ENT_QUOTES) . ' ';
					}
					$automobile_var_image_frame .= '[/automobile_image_frame]';

					$image_frame->addChild('automobile_shortcode', $automobile_var_image_frame);
					$automobile_counter_image_frame++;
				    }
				    $automobile_global_counter_image_frame++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "spacer") {

				    $shortcode = '';
				    $spacer = $column->addChild('spacer');
				    $spacer->addChild('page_element_size', htmlspecialchars($_POST['spacer_element_size'][$automobile_global_counter_spacer]));
				    $spacer->addChild('spacer_element_size', htmlspecialchars($_POST['spacer_element_size'][$automobile_global_counter_spacer]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['spacer'][$automobile_shortcode_counter_spacer]), ENT_QUOTES));
					$automobile_shortcode_counter_spacer++;
					$spacer->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[spacer ';
					if (isset($_POST['automobile_var_spacer_height'][$automobile_counter_spacer]) && $_POST['automobile_var_spacer_height'][$automobile_counter_spacer] != '') {
					    $shortcode .= 'automobile_var_spacer_height="' . stripslashes(htmlspecialchars(($_POST['automobile_var_spacer_height'][$automobile_counter_spacer]), ENT_QUOTES)) . '" ';
					}

					$shortcode .= ']';
					$shortcode .= '[/spacer]';
					$spacer->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_spacer++;
				    }
				    $automobile_global_counter_spacer++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "divider") {

				    $shortcode = '';
				    $divider = $column->addChild('divider');
				    $divider->addChild('page_element_size', htmlspecialchars($_POST['divider_element_size'][$automobile_global_counter_divider]));
				    $divider->addChild('divider_element_size', htmlspecialchars($_POST['divider_element_size'][$automobile_global_counter_divider]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['divider'][$automobile_shortcode_counter_divider]), ENT_QUOTES));
					$automobile_shortcode_counter_divider++;
					$divider->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_divider ';
					if (isset($_POST['automobile_var_divider_padding_left'][$automobile_counter_divider]) && $_POST['automobile_var_divider_padding_left'][$automobile_counter_divider] != '') {
					    $shortcode .= 'automobile_var_divider_padding_left="' . stripslashes(htmlspecialchars(($_POST['automobile_var_divider_padding_left'][$automobile_counter_divider]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_divider_padding_right'][$automobile_counter_divider]) && $_POST['automobile_var_divider_padding_right'][$automobile_counter_divider] != '') {
					    $shortcode .= 'automobile_var_divider_padding_right="' . stripslashes(htmlspecialchars(($_POST['automobile_var_divider_padding_right'][$automobile_counter_divider]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_divider_margin_top'][$automobile_counter_divider]) && $_POST['automobile_var_divider_margin_top'][$automobile_counter_divider] != '') {
					    $shortcode .= 'automobile_var_divider_margin_top="' . stripslashes(htmlspecialchars(($_POST['automobile_var_divider_margin_top'][$automobile_counter_divider]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_divider_margin_buttom'][$automobile_counter_divider]) && $_POST['automobile_var_divider_margin_buttom'][$automobile_counter_divider] != '') {
					    $shortcode .= 'automobile_var_divider_margin_buttom="' . stripslashes(htmlspecialchars(($_POST['automobile_var_divider_margin_buttom'][$automobile_counter_divider]), ENT_QUOTES)) . '" ';
					}

					if (isset($_POST['automobile_var_divider_views'][$automobile_counter_divider]) && $_POST['automobile_var_divider_views'][$automobile_counter_divider] != '') {
					    $shortcode .= 'automobile_var_divider_views="' . stripslashes(htmlspecialchars(($_POST['automobile_var_divider_views'][$automobile_counter_divider]), ENT_QUOTES)) . '" ';
					}

					if (isset($_POST['automobile_var_divider_align'][$automobile_counter_divider]) && $_POST['automobile_var_divider_align'][$automobile_counter_divider] != '') {
					    $shortcode .= 'automobile_var_divider_align="' . stripslashes(htmlspecialchars(($_POST['automobile_var_divider_align'][$automobile_counter_divider]), ENT_QUOTES)) . '" ';
					}

					$shortcode .= ']';
					$shortcode .= '[/automobile_divider]';
					$divider->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_divider++;
				    }
				    $automobile_global_counter_divider++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "call_to_action") {

				    $shortcode = '';
				    $call_to_action = $column->addChild('call_to_action');
				    $call_to_action->addChild('page_element_size', htmlspecialchars($_POST['call_to_action_element_size'][$automobile_global_counter_call_to_action]));
				    $call_to_action->addChild('call_to_action_element_size', htmlspecialchars($_POST['call_to_action_element_size'][$automobile_global_counter_call_to_action]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['call_to_action'][$automobile_shortcode_counter_call_to_action]), ENT_QUOTES));
					$automobile_shortcode_counter_call_to_action++;
					$call_to_action->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[call_to_action ';
					if (isset($_POST['automobile_var_call_to_action_title'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_title'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_title'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_content_type'][$automobile_counter_call_to_action]) && $_POST['automobile_var_content_type'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_content_type="' . stripslashes(htmlspecialchars(($_POST['automobile_var_content_type'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_action_subtitle'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_action_subtitle'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_action_subtitle="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_action_subtitle'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_button_bg_color'][$automobile_counter_call_to_action]) && $_POST['automobile_var_button_bg_color'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_button_bg_color="' . htmlspecialchars($_POST['automobile_var_button_bg_color'][$automobile_counter_call_to_action], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_border_color'][$automobile_counter_call_to_action]) && $_POST['automobile_var_button_border_color'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_button_border_color="' . htmlspecialchars($_POST['automobile_var_button_border_color'][$automobile_counter_call_to_action], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_contents_color'][$automobile_counter_call_to_action]) && $_POST['automobile_var_contents_color'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_contents_color="' . stripslashes(htmlspecialchars(($_POST['automobile_var_contents_color'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_heading_color'][$automobile_counter_call_to_action]) && $_POST['automobile_var_heading_color'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_heading_color="' . stripslashes(htmlspecialchars(($_POST['automobile_var_heading_color'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}

					if (isset($_POST['automobile_var_call_action_icon'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_action_icon'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_action_icon="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_action_icon'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_icon_color'][$automobile_counter_call_to_action]) && $_POST['automobile_var_icon_color'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_icon_color="' . stripslashes(htmlspecialchars(($_POST['automobile_var_icon_color'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_to_action_icon_background_color'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_icon_background_color'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_icon_background_color="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_icon_background_color'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_to_action_button_text'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_button_text'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_button_text="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_button_text'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_to_action_button_link'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_button_link'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_button_link="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_button_link'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_to_action_bg_img'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_bg_img'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_bg_img="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_bg_img'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_class_automobile'][$automobile_counter_call_to_action]) && $_POST['automobile_var_class_automobile'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_class_automobile="' . stripslashes(htmlspecialchars(($_POST['automobile_var_class_automobile'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_contents_bg_color'][$automobile_counter_call_to_action]) && $_POST['automobile_var_contents_bg_color'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_contents_bg_color="' . stripslashes(htmlspecialchars(($_POST['automobile_var_contents_bg_color'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}




					if (isset($_POST['automobile_var_call_to_action_img_array'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_img_array'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_img_array="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_img_array'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_to_action_top_img_array'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_top_img_array'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_top_img_array="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_top_img_array'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_action_style'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_action_style'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_action_style="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_action_style'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_action_view'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_action_view'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_action_view="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_action_view'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_action_text_align'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_action_text_align'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_action_text_align="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_action_text_align'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_to_action_class'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_to_action_class'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_to_action_class="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_to_action_class'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_call_action_img_align'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_action_img_align'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= 'automobile_var_call_action_img_align="' . stripslashes(htmlspecialchars(($_POST['automobile_var_call_action_img_align'][$automobile_counter_call_to_action]), ENT_QUOTES)) . '" ';
					}

//                                        if (isset($_POST['automobile_var_call_action_contents'][$automobile_counter_call_to_action]) && $_POST['automobile_var_call_action_contents'][$automobile_counter_call_to_action] != '') {
//                                            $shortcode .= 'automobile_var_call_action_contents="' . stripslashes(htmlspecialchars(str_replace('"', '/', automobile_custom_shortcode_encode($_POST['automobile_var_call_action_contents'][$automobile_counter_call_to_action])), ENT_QUOTES)) . '" ';
//                                        }
					$shortcode .= '] ';

					if (isset($_POST['atts_content'][$automobile_counter_call_to_action]) && $_POST['atts_content'][$automobile_counter_call_to_action] != '') {
					    $shortcode .= htmlspecialchars($_POST['atts_content'][$automobile_counter_call_to_action], ENT_QUOTES) . ' ';
					}


					$shortcode .= '[/call_to_action]';
					$call_to_action->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_call_to_action++;
				    }
				    $automobile_global_counter_call_to_action++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "editor") {
				    $shortcode = '';
				    $editor = $column->addChild('editor');
				    $editor->addChild('page_element_size', htmlspecialchars($_POST['editor_element_size'][$automobile_global_counter_editor]));
				    $editor->addChild('editor_element_size', htmlspecialchars($_POST['editor_element_size'][$automobile_global_counter_editor]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['editor'][$automobile_shortcode_counter_editor]), ENT_QUOTES));
					$automobile_shortcode_counter_editor++;
					$editor->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_editor ';
					if (isset($_POST['automobile_var_editor_title'][$automobile_counter_editor]) && $_POST['automobile_var_editor_title'][$automobile_counter_editor] != '') {
					    $shortcode .= 'automobile_var_editor_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_editor_title'][$automobile_counter_editor]), ENT_QUOTES)) . '" ';
					}

					$shortcode .= ']';
					if (isset($_POST['automobile_var_editor_content'][$automobile_counter_editor]) && $_POST['automobile_var_editor_content'][$automobile_counter_editor] != '') {
					    $shortcode .= htmlspecialchars($_POST['automobile_var_editor_content'][$automobile_counter_editor], ENT_QUOTES) . ' ';
					}
					$shortcode .= '[/automobile_editor]';
					$editor->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_editor++;
				    }
				    $automobile_global_counter_editor++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "quote") {

				    $shortcode = '';
				    $quote = $column->addChild('quote');
				    $quote->addChild('page_element_size', htmlspecialchars($_POST['quote_element_size'][$automobile_global_counter_quote]));
				    $quote->addChild('quote_element_size', htmlspecialchars($_POST['quote_element_size'][$automobile_global_counter_quote]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['quote'][$automobile_shortcode_counter_quote]), ENT_QUOTES));
					$automobile_shortcode_counter_quote++;
					$quote->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_quote ';
					if (isset($_POST['automobile_quote_section_title'][$automobile_counter_quote]) && $_POST['automobile_quote_section_title'][$automobile_counter_quote] != '') {
					    $shortcode .= 'automobile_quote_section_title="' . stripslashes(htmlspecialchars(($_POST['automobile_quote_section_title'][$automobile_counter_quote]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['quote_cite'][$automobile_counter_quote]) && $_POST['quote_cite'][$automobile_counter_quote] != '') {
					    $shortcode .= 'quote_cite="' . htmlspecialchars($_POST['quote_cite'][$automobile_counter_quote], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['quote_cite_url'][$automobile_counter_quote]) && $_POST['quote_cite_url'][$automobile_counter_quote] != '') {
					    $shortcode .= 'quote_cite_url="' . htmlspecialchars($_POST['quote_cite_url'][$automobile_counter_quote], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['quote_cite'][$automobile_counter_quote]) && $_POST['quote_cite'][$automobile_counter_quote] != '') {
					    $shortcode .= 'quote_cite="' . htmlspecialchars($_POST['quote_cite'][$automobile_counter_quote], ENT_QUOTES) . '" ';
					}

					$shortcode .= ']';
					if (isset($_POST['quotes_content'][$automobile_counter_quote]) && $_POST['quotes_content'][$automobile_counter_quote] != '') {
					    $shortcode .= htmlspecialchars($_POST['quotes_content'][$automobile_counter_quote], ENT_QUOTES) . ' ';
					}
					$shortcode .= '[/automobile_quote]';
					$quote->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_quote++;
				    }
				    $automobile_global_counter_quote++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "dropcap") {

				    $shortcode = '';
				    //echo '<pre>';
				    //print_r($_POST);
				    //echo '</pre>';//exit;
				    $dropcap = $column->addChild('dropcap');
				    $dropcap->addChild('page_element_size', htmlspecialchars($_POST['dropcap_element_size'][$automobile_global_counter_dropcap]));
				    $dropcap->addChild('dropcap_element_size', htmlspecialchars($_POST['dropcap_element_size'][$automobile_global_counter_dropcap]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['dropcap'][$automobile_shortcode_counter_dropcap]), ENT_QUOTES));
					$automobile_shortcode_counter_dropcap++;
					$dropcap->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_dropcap ';
					if (isset($_POST['automobile_dropcap_section_title'][$automobile_counter_dropcap]) && $_POST['automobile_dropcap_section_title'][$automobile_counter_dropcap] != '') {
					    $shortcode .= 'automobile_dropcap_section_title="' . stripslashes(htmlspecialchars(($_POST['automobile_dropcap_section_title'][$automobile_counter_dropcap]), ENT_QUOTES)) . '" ';
					}
					$shortcode .= ']';
					if (isset($_POST['dropcaps_content'][$automobile_counter_dropcap]) && $_POST['dropcaps_content'][$automobile_counter_dropcap] != '') {
					    $shortcode .= htmlspecialchars($_POST['dropcaps_content'][$automobile_counter_dropcap], ENT_QUOTES) . ' ';
					}
					$shortcode .= '[/automobile_dropcap]';
					$dropcap->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_dropcap++;
				    }
				    $automobile_global_counter_dropcap++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "button") {

				    $automobile_var_button = '';
				    $button = $column->addChild('button');
				    $button->addChild('page_element_size', htmlspecialchars($_POST['button_element_size'][$automobile_global_counter_button]));
				    $button->addChild('button_element_size', htmlspecialchars($_POST['button_element_size'][$automobile_global_counter_button]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['button'][$automobile_shortcode_counter_button]), ENT_QUOTES));
					$automobile_shortcode_counter_button++;
					$button->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_var_button = '[automobile_button ';
					if (isset($_POST['automobile_var_button_text'][$automobile_counter_button]) && $_POST['automobile_var_button_text'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_text="' . htmlspecialchars($_POST['automobile_var_button_text'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_link'][$automobile_counter_button]) && $_POST['automobile_var_button_link'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_link="' . htmlspecialchars($_POST['automobile_var_button_link'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_button_size'][$automobile_counter_button]) && $_POST['automobile_var_button_size'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_size="' . htmlspecialchars($_POST['automobile_var_button_size'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_button_icon'][$automobile_counter_button]) && $_POST['automobile_button_icon'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_button_icon="' . htmlspecialchars($_POST['automobile_button_icon'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_button_border'][$automobile_counter_button]) && $_POST['automobile_var_button_border'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_border="' . htmlspecialchars($_POST['automobile_var_button_border'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_type'][$automobile_counter_button]) && $_POST['automobile_var_button_type'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_type="' . htmlspecialchars($_POST['automobile_var_button_type'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_align'][$automobile_counter_button]) && $_POST['automobile_var_button_align'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_align="' . htmlspecialchars($_POST['automobile_var_button_align'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_target'][$automobile_counter_button]) && $_POST['automobile_var_button_target'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_target="' . htmlspecialchars($_POST['automobile_var_button_target'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_button_padding_top'][$automobile_counter_button]) && $_POST['automobile_var_button_padding_top'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_padding_top="' . htmlspecialchars($_POST['automobile_var_button_padding_top'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_padding_bottom'][$automobile_counter_button]) && $_POST['automobile_var_button_padding_bottom'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_padding_bottom="' . htmlspecialchars($_POST['automobile_var_button_padding_bottom'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_padding_left'][$automobile_counter_button]) && $_POST['automobile_var_button_padding_left'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_padding_left="' . htmlspecialchars($_POST['automobile_var_button_padding_left'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_padding_right'][$automobile_counter_button]) && $_POST['automobile_var_button_padding_right'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_padding_right="' . htmlspecialchars($_POST['automobile_var_button_padding_right'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_button_border_color'][$automobile_counter_button]) && $_POST['automobile_var_button_border_color'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_border_color="' . htmlspecialchars($_POST['automobile_var_button_border_color'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_button_color'][$automobile_counter_button]) && $_POST['automobile_var_button_color'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_color="' . htmlspecialchars($_POST['automobile_var_button_color'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_border_color'][$automobile_counter_button]) && $_POST['automobile_var_border_color'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_border_color="' . htmlspecialchars($_POST['automobile_var_border_color'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_button_bg_color'][$automobile_counter_button]) && $_POST['automobile_var_button_bg_color'][$automobile_counter_button] != '') {
					    $automobile_var_button .= 'automobile_var_button_bg_color="' . htmlspecialchars($_POST['automobile_var_button_bg_color'][$automobile_counter_button], ENT_QUOTES) . '" ';
					}

					$automobile_var_button .= ']';
					if (isset($_POST['button_text'][$automobile_counter_button]) && $_POST['button_text'][$automobile_counter_button] != '') {
					    $automobile_var_button .= htmlspecialchars($_POST['button_text'][$automobile_counter_button], ENT_QUOTES) . ' ';
					}
					$automobile_var_button .= '[/automobile_button]';

					$button->addChild('automobile_shortcode', $automobile_var_button);
					$automobile_counter_button++;
				    }
				    $automobile_global_counter_button++;
				} else if (isset($_POST['automobile_orderby'][$automobile_counter]) && $_POST['automobile_orderby'][$automobile_counter] == 'inventories') {
				    $shortcode = '';
				    $inventory = $column->addChild('inventories');
				    $inventory->addChild('page_element_size', htmlspecialchars($_POST['inventories_element_size'][$automobile_global_counter_inventory]));
				    $inventory->addChild('inventories_element_size', htmlspecialchars($_POST['inventories_element_size'][$automobile_global_counter_inventory]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['inventories'][$automobile_shortcode_counter_inventory]);
					$automobile_shortcode_counter_inventory++;
					$inventory->addChild('automobile_shortcode', htmlspecialchars($shortcode_str));
				    } else {
					$shortcode = '[automobile_inventories ';
					if (isset($_POST['automobile_inventory_title'][$automobile_counter_inventory]) && $_POST['automobile_inventory_title'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_title="' . htmlspecialchars($_POST['automobile_inventory_title'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_sub_title'][$automobile_counter_inventory]) && $_POST['automobile_inventory_sub_title'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_sub_title="' . htmlspecialchars($_POST['automobile_inventory_sub_title'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_searchbox'][$automobile_counter_inventory]) && $_POST['automobile_inventory_searchbox'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_searchbox="' . htmlspecialchars($_POST['automobile_inventory_searchbox'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_filterable'][$automobile_counter_inventory]) && $_POST['automobile_inventory_filterable'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_filterable="' . htmlspecialchars($_POST['automobile_inventory_filterable'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_top_search'][$automobile_counter_inventory]) && $_POST['automobile_inventory_top_search'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_top_search="' . htmlspecialchars($_POST['automobile_inventory_top_search'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_type'][$automobile_counter_inventory]) && $_POST['automobile_inventory_type'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_type="' . htmlspecialchars($_POST['automobile_inventory_type'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_make'][$automobile_counter_inventory]) && $_POST['automobile_inventory_make'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_make="' . htmlspecialchars($_POST['automobile_inventory_make'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_num_results'][$automobile_counter_inventory]) && $_POST['automobile_inventory_num_results'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_num_results="' . htmlspecialchars($_POST['automobile_inventory_num_results'][$automobile_counter_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_inventory_view'][$automobile_counter_inventory]) && $_POST['automobile_inventory_view'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_view="' . htmlspecialchars($_POST['automobile_inventory_view'][$automobile_counter_inventory]) . '" ';
					}if (isset($_POST['automobile_inventory_result_type'][$automobile_counter_inventory]) && $_POST['automobile_inventory_result_type'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_result_type="' . htmlspecialchars($_POST['automobile_inventory_result_type'][$automobile_counter_inventory]) . '" ';
					}if (isset($_POST['automobile_inventory_show_pagination'][$automobile_counter_inventory]) && $_POST['automobile_inventory_show_pagination'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_show_pagination="' . htmlspecialchars($_POST['automobile_inventory_show_pagination'][$automobile_counter_inventory]) . '" ';
					}if (isset($_POST['automobile_inventory_pagination'][$automobile_counter_inventory]) && $_POST['automobile_inventory_pagination'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventory_pagination="' . htmlspecialchars($_POST['automobile_inventory_pagination'][$automobile_counter_inventory]) . '" ';
					}
					if (isset($_POST['automobile_inventories_counter'][$automobile_counter_inventory]) && $_POST['automobile_inventories_counter'][$automobile_counter_inventory] != '') {
					    $shortcode .= 'automobile_inventories_counter="' . htmlspecialchars($_POST['automobile_inventories_counter'][$automobile_counter_inventory]) . '" ';
					}
					$shortcode .= ']';
					$inventory->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_inventory++;
				    }
				    $automobile_global_counter_inventory++;
				} else if (isset($_POST['automobile_orderby'][$automobile_counter]) && $_POST['automobile_orderby'][$automobile_counter] == 'inventories_search') {
				    $shortcode = '';
				    $inventory_search = $column->addChild('inventories_search');
				    $inventory_search->addChild('page_element_size', htmlspecialchars($_POST['inventories_search_element_size'][$automobile_global_counter_inventory_search]));
				    $inventory_search->addChild('inventories_search_element_size', htmlspecialchars($_POST['inventories_search_element_size'][$automobile_global_counter_inventory_search]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['inventories_search'][$automobile_shortcode_counter_inventory_search]);
					$automobile_shortcode_counter_inventory_search++;
					$inventory_search->addChild('automobile_shortcode', htmlspecialchars($shortcode_str));
				    } else {
					$shortcode = '[automobile_inventories_search ';
					if (isset($_POST['inventories_search_title'][$automobile_counter_inventory_search]) && $_POST['inventories_search_title'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventories_search_title="' . htmlspecialchars($_POST['inventories_search_title'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_style'][$automobile_counter_inventory_search]) && $_POST['inventory_search_style'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_style="' . htmlspecialchars($_POST['inventory_search_style'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_layout'][$automobile_counter_inventory_search]) && $_POST['inventory_search_layout'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_layout="' . htmlspecialchars($_POST['inventory_search_layout'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_layout_bg'][$automobile_counter_inventory_search]) && $_POST['inventory_search_layout_bg'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_layout_bg="' . htmlspecialchars($_POST['inventory_search_layout_bg'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_layout_heading_color'][$automobile_counter_inventory_search]) && $_POST['inventory_search_layout_heading_color'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_layout_heading_color="' . htmlspecialchars($_POST['inventory_search_layout_heading_color'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_make_field_switch'][$automobile_counter_inventory_search]) && $_POST['inventory_search_make_field_switch'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_make_field_switch="' . htmlspecialchars($_POST['inventory_search_make_field_switch'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_type_field_switch'][$automobile_counter_inventory_search]) && $_POST['inventory_search_type_field_switch'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_type_field_switch="' . htmlspecialchars($_POST['inventory_search_type_field_switch'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_title_field_style'][$automobile_counter_inventory_search]) && $_POST['inventory_search_title_field_style'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_title_field_style="' . htmlspecialchars($_POST['inventory_search_title_field_style'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_title_field_switch'][$automobile_counter_inventory_search]) && $_POST['inventory_search_title_field_switch'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_title_field_switch="' . htmlspecialchars($_POST['inventory_search_title_field_switch'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_location_field_switch'][$automobile_counter_inventory_search]) && $_POST['inventory_search_location_field_switch'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_location_field_switch="' . htmlspecialchars($_POST['inventory_search_location_field_switch'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_lable_switch'][$automobile_counter_inventory_search]) && $_POST['inventory_lable_switch'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_lable_switch="' . htmlspecialchars($_POST['inventory_lable_switch'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_search_hint_switch'][$automobile_counter_inventory_search]) && $_POST['inventory_search_hint_switch'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_search_hint_switch="' . htmlspecialchars($_POST['inventory_search_hint_switch'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_advance_search_switch'][$automobile_counter_inventory_search]) && $_POST['inventory_advance_search_switch'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_advance_search_switch="' . htmlspecialchars($_POST['inventory_advance_search_switch'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['inventory_advance_search_url'][$automobile_counter_inventory_search]) && $_POST['inventory_advance_search_url'][$automobile_counter_inventory_search] != '') {
					    $shortcode .= 'inventory_advance_search_url="' . htmlspecialchars($_POST['inventory_advance_search_url'][$automobile_counter_inventory_search], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					//var_dump($automobile_counter_inventory_search); die;
					$inventory_search->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_inventory_search++;
				    }
				    $automobile_global_counter_inventory_search++;
				} else if (isset($_POST['automobile_orderby'][$automobile_counter]) && $_POST['automobile_orderby'][$automobile_counter] == 'dealer') {
				    $shortcode = '';
				    $dealer = $column->addChild('dealer');
				    $dealer->addChild('page_element_size', htmlspecialchars($_POST['dealer_element_size'][$automobile_global_counter_dealer]));
				    $dealer->addChild('dealer_element_size', htmlspecialchars($_POST['dealer_element_size'][$automobile_global_counter_dealer]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['dealer'][$automobile_shortcode_counter_dealer]);
					$automobile_shortcode_counter_dealer++;
					$dealer->addChild('automobile_shortcode', htmlspecialchars($shortcode_str));
				    } else {

					$shortcode = '[automobile_dealer ';
					if (isset($_POST['automobile_dealer_title'][$automobile_counter_dealer]) && $_POST['automobile_dealer_title'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_title="' . htmlspecialchars($_POST['automobile_dealer_title'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_dealer_sub_title'][$automobile_counter_dealer]) && $_POST['automobile_dealer_sub_title'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_sub_title="' . htmlspecialchars($_POST['automobile_dealer_sub_title'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_dealer_searchbox_title_top'][$automobile_counter_dealer]) && $_POST['automobile_dealer_searchbox_title_top'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_searchbox_title_top="' . htmlspecialchars($_POST['automobile_dealer_searchbox_title_top'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_dealer_searchbox'][$automobile_counter_dealer]) && $_POST['automobile_dealer_searchbox'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_searchbox="' . htmlspecialchars($_POST['automobile_dealer_searchbox'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_dealer_searchbox_top'][$automobile_counter_dealer]) && $_POST['automobile_dealer_searchbox_top'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_searchbox_top="' . htmlspecialchars($_POST['automobile_dealer_searchbox_top'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_dealer_show_pagination'][$automobile_counter_dealer]) && $_POST['automobile_dealer_show_pagination'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_show_pagination="' . htmlspecialchars($_POST['automobile_dealer_show_pagination'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_dealer_pagination'][$automobile_counter_dealer]) && $_POST['automobile_dealer_pagination'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_pagination="' . htmlspecialchars($_POST['automobile_dealer_pagination'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_dealer_map'][$automobile_counter_dealer]) && $_POST['automobile_dealer_map'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_dealer_map="' . htmlspecialchars($_POST['automobile_dealer_map'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_dealer_map_lat'][$automobile_counter_dealer]) && $_POST['automobile_var_dealer_map_lat'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_var_dealer_map_lat="' . htmlspecialchars($_POST['automobile_var_dealer_map_lat'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_dealer_map_long'][$automobile_counter_dealer]) && $_POST['automobile_var_dealer_map_long'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_var_dealer_map_long="' . htmlspecialchars($_POST['automobile_var_dealer_map_long'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_dealer_map_zoom'][$automobile_counter_dealer]) && $_POST['automobile_var_dealer_map_zoom'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_var_dealer_map_zoom="' . htmlspecialchars($_POST['automobile_var_dealer_map_zoom'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_dealer_map_height'][$automobile_counter_dealer]) && $_POST['automobile_var_dealer_map_height'][$automobile_counter_dealer] != '') {
					    $shortcode .= 'automobile_var_dealer_map_height="' . htmlspecialchars($_POST['automobile_var_dealer_map_height'][$automobile_counter_dealer], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					$dealer->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_dealer++;
				    }
				    $automobile_global_counter_dealer++;
				} else if (isset($_POST['automobile_orderby'][$automobile_counter]) && $_POST['automobile_orderby'][$automobile_counter] == 'compare_inventories') {
				    $shortcode = '';
				    $compare_inventory = $column->addChild('compare_inventories');
				    $compare_inventory->addChild('page_element_size', htmlspecialchars($_POST['compare_inventories_element_size'][$automobile_global_counter_compare_inventory]));
				    $compare_inventory->addChild('compare_inventories_element_size', htmlspecialchars($_POST['compare_inventories_element_size'][$automobile_global_counter_compare_inventory]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['compare_inventories'][$automobile_shortcode_counter_compare_inventory]);
					$automobile_shortcode_counter_compare_inventory++;
					$compare_inventory->addChild('automobile_shortcode', htmlspecialchars($shortcode_str));
				    } else {
					$shortcode = '[automobile_compare_inventories ';
					if (isset($_POST['automobile_compare_inventory_title'][$automobile_counter_compare_inventory]) && $_POST['automobile_compare_inventory_title'][$automobile_counter_compare_inventory] != '') {
					    $shortcode .= 'automobile_compare_inventory_title="' . htmlspecialchars($_POST['automobile_compare_inventory_title'][$automobile_counter_compare_inventory], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_compare_inventory_sub_title'][$automobile_counter_compare_inventory]) && $_POST['automobile_compare_inventory_sub_title'][$automobile_counter_compare_inventory] != '') {
					    $shortcode .= 'automobile_compare_inventory_sub_title="' . htmlspecialchars($_POST['automobile_compare_inventory_sub_title'][$automobile_counter_compare_inventory], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					$compare_inventory->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_compare_inventory++;
				    }
				    $automobile_global_counter_compare_inventory++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "price_table") {

				    $shortcode = $shortcode_item = '';

				    $price_table = $column->addChild('price_table');
				    $price_table->addChild('page_element_size', htmlspecialchars($_POST['price_table_element_size'][$automobile_global_counter_price_table]));
				    $price_table->addChild('price_table_element_size', htmlspecialchars($_POST['price_table_element_size'][$automobile_global_counter_price_table]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes($_POST['shortcode']['price_table'][$automobile_shortcode_counter_price_table]);
					$automobile_shortcode_counter_price_table++;
					$price_table->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					if (isset($_POST['price_table_num'][$automobile_counter_price_table]) && $_POST['price_table_num'][$automobile_counter_price_table] > 0) {
					    for ($i = 1; $i <= $_POST['price_table_num'][$automobile_counter_price_table]; $i++) {
						$shortcode_item .= '[price_table_item ';

						if (isset($_POST['multi_price_table_text'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_text'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_text="' . htmlspecialchars($_POST['multi_price_table_text'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['multi_price_table_title_color'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_title_color'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_title_color="' . $_POST['multi_price_table_title_color'][$automobile_counter_price_table_node] . '" ';
						}
						if (isset($_POST['multi_pricetable_price'][$automobile_counter_price_table_node]) && $_POST['multi_pricetable_price'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_pricetable_price="' . $_POST['multi_pricetable_price'][$automobile_counter_price_table_node] . '" ';
						}

						if (isset($_POST['multi_price_table_currency'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_currency'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_currency="' . htmlspecialchars($_POST['multi_price_table_currency'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}

						if (isset($_POST['multi_price_table_time_duration'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_time_duration'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_time_duration="' . htmlspecialchars($_POST['multi_price_table_time_duration'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['button_link'][$automobile_counter_price_table_node]) && $_POST['button_link'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'button_link="' . htmlspecialchars($_POST['button_link'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['multi_price_table_button_text'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_button_text'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_button_text="' . htmlspecialchars($_POST['multi_price_table_button_text'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['multi_price_table_button_color'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_button_color'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_button_color="' . htmlspecialchars($_POST['multi_price_table_button_color'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['multi_price_table_button_color_bg'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_button_color_bg'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_button_color_bg="' . htmlspecialchars($_POST['multi_price_table_button_color_bg'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['pricetable_featured'][$automobile_counter_price_table_node]) && $_POST['pricetable_featured'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'pricetable_featured="' . htmlspecialchars($_POST['pricetable_featured'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}
						if (isset($_POST['multi_price_table_column_bgcolor'][$automobile_counter_price_table_node]) && $_POST['multi_price_table_column_bgcolor'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= 'multi_price_table_column_bgcolor="' . htmlspecialchars($_POST['multi_price_table_column_bgcolor'][$automobile_counter_price_table_node], ENT_QUOTES) . '" ';
						}


						$shortcode_item .= ']';

						if (isset($_POST['automobile_var_price_table_text'][$automobile_counter_price_table_node]) && $_POST['automobile_var_price_table_text'][$automobile_counter_price_table_node] != '') {
						    $shortcode_item .= htmlspecialchars($_POST['automobile_var_price_table_text'][$automobile_counter_price_table_node], ENT_QUOTES);
						}



						$shortcode_item .= '[/price_table_item]';
						$automobile_counter_price_table_node++;
					    }
					}
					$section_title = '';
					if (isset($_POST['automobile_multi_price_table_section_title'][$automobile_counter_price_table]) && $_POST['automobile_multi_price_table_section_title'][$automobile_counter_price_table] != '') {
					    $section_title .= 'automobile_multi_price_table_section_title="' . htmlspecialchars($_POST['automobile_multi_price_table_section_title'][$automobile_counter_price_table], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['price_table_style'][$automobile_counter_price_table]) && $_POST['price_table_style'][$automobile_counter_price_table] != '') {
					    $section_title .= 'price_table_style="' . htmlspecialchars($_POST['price_table_style'][$automobile_counter_price_table], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_multi_price_col'][$automobile_counter_price_table]) && $_POST['automobile_multi_price_col'][$automobile_counter_price_table] != '') {
					    $section_title .= 'automobile_multi_price_col="' . htmlspecialchars($_POST['automobile_multi_price_col'][$automobile_counter_price_table], ENT_QUOTES) . '" ';
					}


					$shortcode = '[automobile_price_table ' . $section_title . ' ]' . $shortcode_item . '[/automobile_price_table]';
					$price_table->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_price_table++;
				    }
				    $automobile_global_counter_price_table++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "maintenance") {

				    $automobile_bareber_maintenance = '';
				    $maintenance = $column->addChild('maintenance');
				    $maintenance->addChild('page_element_size', htmlspecialchars($_POST['maintenance_element_size'][$automobile_global_counter_maintenance]));
				    $maintenance->addChild('maintenance_element_size', htmlspecialchars($_POST['maintenance_element_size'][$automobile_global_counter_maintenance]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['maintenance'][$automobile_shortcode_counter_maintenance]), ENT_QUOTES));
					$automobile_bareber_maintenance++;
					$maintenance->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$automobile_bareber_maintenance = '[automobile_maintenance ';
//                                        if (isset($_POST['automobile_var_maintenance_text'][$automobile_counter_maintenance]) && $_POST['automobile_var_maintenance_text'][$automobile_counter_maintenance] != '') {
//                                            $automobile_bareber_maintenance .= 'automobile_var_maintenance_text="' . htmlspecialchars($_POST['automobile_var_maintenance_text'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
//                                        }
//                                        if (isset($_POST['automobile_var_maintenance_text'][$automobile_counter_maintenance]) && $_POST['automobile_var_maintenance_text'][$automobile_counter_maintenance] != '') {
//                                            $automobile_bareber_maintenance .= 'automobile_var_maintenance_text="' . htmlspecialchars(str_replace('"', '', automobile_custom_shortcode_encode($_POST['automobile_var_maintenance_text'][$automobile_counter_maintenance])), ENT_QUOTES) . '" ';
//                                        }

					if (isset($_POST['automobile_fluid_info'][$automobile_counter_maintenance]) && $_POST['automobile_fluid_info'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= 'automobile_fluid_info="' . htmlspecialchars($_POST['automobile_fluid_info'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_maintenance_time_left'][$automobile_counter_maintenance]) && $_POST['automobile_var_maintenance_time_left'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= 'automobile_var_maintenance_time_left="' . htmlspecialchars($_POST['automobile_var_maintenance_time_left'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_maintenance_sub_title'][$automobile_counter_maintenance]) && $_POST['automobile_var_maintenance_sub_title'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= 'automobile_var_maintenance_sub_title="' . htmlspecialchars($_POST['automobile_var_maintenance_sub_title'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_lunch_date'][$automobile_counter_maintenance]) && $_POST['automobile_var_lunch_date'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= 'automobile_var_lunch_date="' . htmlspecialchars($_POST['automobile_var_lunch_date'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_maintenance_image_url_array'][$automobile_counter_maintenance]) && $_POST['automobile_var_maintenance_image_url_array'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= 'automobile_var_maintenance_image_url_array="' . htmlspecialchars($_POST['automobile_var_maintenance_image_url_array'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_maintenance_logo_url_array'][$automobile_counter_maintenance]) && $_POST['automobile_var_maintenance_logo_url_array'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= 'automobile_var_maintenance_logo_url_array="' . htmlspecialchars($_POST['automobile_var_maintenance_logo_url_array'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_maintenance_title'][$automobile_counter_maintenance]) && $_POST['automobile_var_maintenance_title'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= 'automobile_var_maintenance_title="' . htmlspecialchars($_POST['automobile_var_maintenance_title'][$automobile_counter_maintenance], ENT_QUOTES) . '" ';
					}

					$automobile_bareber_maintenance .= ']';
					if (isset($_POST['maintenance_column_text'][$automobile_counter_maintenance]) && $_POST['maintenance_column_text'][$automobile_counter_maintenance] != '') {
					    $automobile_bareber_maintenance .= htmlspecialchars($_POST['maintenance_column_text'][$automobile_counter_maintenance], ENT_QUOTES) . ' ';
					}
					$automobile_bareber_maintenance .= '[/automobile_maintenance]';

					$maintenance->addChild('automobile_shortcode', $automobile_bareber_maintenance);
					$automobile_counter_maintenance++;
				    }
				    $automobile_global_counter_maintenance++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "contact_form") {
				    $shortcode = '';

				    $contact_us = $column->addChild('contact_form');
				    $contact_us->addChild('page_element_size', htmlspecialchars($_POST['contact_form_element_size'][$automobile_global_counter_contact_us]));
				    $contact_us->addChild('contact_form_element_size', htmlspecialchars($_POST['contact_form_element_size'][$automobile_global_counter_contact_us]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['contact_form'][$automobile_shortcode_counter_contact_us]), ENT_QUOTES));
					$automobile_shortcode_counter_contact_us++;
					$contact_us->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_contact_form ';
					if (isset($_POST['automobile_var_contact_us_element_title'][$automobile_counter_contact_us]) && $_POST['automobile_var_contact_us_element_title'][$automobile_counter_contact_us] != '') {
					    $shortcode .= 'automobile_var_contact_us_element_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_contact_us_element_title'][$automobile_counter_contact_us]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_contact_us_element_subtitle'][$automobile_counter_contact_us]) && $_POST['automobile_var_contact_us_element_subtitle'][$automobile_counter_contact_us] != '') {
					    $shortcode .= 'automobile_var_contact_us_element_subtitle="' . htmlspecialchars($_POST['automobile_var_contact_us_element_subtitle'][$automobile_counter_contact_us], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_contact_us_element_send'][$automobile_counter_contact_us]) && $_POST['automobile_var_contact_us_element_send'][$automobile_counter_contact_us] != '') {
					    $shortcode .= 'automobile_var_contact_us_element_send="' . htmlspecialchars($_POST['automobile_var_contact_us_element_send'][$automobile_counter_contact_us], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_contact_us_element_success'][$automobile_counter_contact_us]) && $_POST['automobile_var_contact_us_element_success'][$automobile_counter_contact_us] != '') {
					    $shortcode .= 'automobile_var_contact_us_element_success="' . htmlspecialchars($_POST['automobile_var_contact_us_element_success'][$automobile_counter_contact_us], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_contact_us_element_error'][$automobile_counter_contact_us]) && $_POST['automobile_var_contact_us_element_error'][$automobile_counter_contact_us] != '') {
					    $shortcode .= 'automobile_var_contact_us_element_error="' . htmlspecialchars($_POST['automobile_var_contact_us_element_error'][$automobile_counter_contact_us], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					$shortcode .= '[/automobile_contact_form]';

					$contact_us->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_contact_us++;
				    }
				    $automobile_global_counter_contact_us++;
				} elseif ($_POST['automobile_orderby'][$automobile_counter] == "schedule") {
				    $shortcode = '';

				    $schedule = $column->addChild('schedule');
				    $schedule->addChild('page_element_size', htmlspecialchars($_POST['schedule_element_size'][$automobile_global_counter_schedule]));
				    $schedule->addChild('schedule_element_size', htmlspecialchars($_POST['schedule_element_size'][$automobile_global_counter_schedule]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['schedule'][$automobile_shortcode_counter_schedule]), ENT_QUOTES));
					$automobile_shortcode_counter_schedule++;
					$schedule->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
				    } else {
					$shortcode = '[automobile_schedule ';
					if (isset($_POST['automobile_var_schedule_element_title'][$automobile_counter_schedule]) && $_POST['automobile_var_schedule_element_title'][$automobile_counter_schedule] != '') {
					    $shortcode .= 'automobile_var_schedule_element_title="' . stripslashes(htmlspecialchars(($_POST['automobile_var_schedule_element_title'][$automobile_counter_schedule]), ENT_QUOTES)) . '" ';
					}
					if (isset($_POST['automobile_var_schedule_element_subtitle'][$automobile_counter_schedule]) && $_POST['automobile_var_schedule_element_subtitle'][$automobile_counter_schedule] != '') {
					    $shortcode .= 'automobile_var_schedule_element_subtitle="' . htmlspecialchars($_POST['automobile_var_schedule_element_subtitle'][$automobile_counter_schedule], ENT_QUOTES) . '" ';
					}

					if (isset($_POST['automobile_var_schedule_element_send'][$automobile_counter_schedule]) && $_POST['automobile_var_schedule_element_send'][$automobile_counter_schedule] != '') {
					    $shortcode .= 'automobile_var_schedule_element_send="' . htmlspecialchars($_POST['automobile_var_schedule_element_send'][$automobile_counter_schedule], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_schedule_element_success'][$automobile_counter_schedule]) && $_POST['automobile_var_schedule_element_success'][$automobile_counter_schedule] != '') {
					    $shortcode .= 'automobile_var_schedule_element_success="' . htmlspecialchars($_POST['automobile_var_schedule_element_success'][$automobile_counter_schedule], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_schedule_element_error'][$automobile_counter_schedule]) && $_POST['automobile_var_schedule_element_error'][$automobile_counter_schedule] != '') {
					    $shortcode .= 'automobile_var_schedule_element_error="' . htmlspecialchars($_POST['automobile_var_schedule_element_error'][$automobile_counter_schedule], ENT_QUOTES) . '" ';
					}
					if (isset($_POST['automobile_var_schedule_hint_text'][$automobile_counter_schedule]) && $_POST['automobile_var_schedule_hint_text'][$automobile_counter_schedule] != '') {
					    $shortcode .= 'automobile_var_schedule_hint_text="' . htmlspecialchars($_POST['automobile_var_schedule_hint_text'][$automobile_counter_schedule], ENT_QUOTES) . '" ';
					}
					$shortcode .= ']';
					$shortcode .= '[/automobile_schedule]';

					$schedule->addChild('automobile_shortcode', $shortcode);

					$automobile_counter_schedule++;
				    }
				    $automobile_global_counter_schedule++;
				} else if (isset($_POST['automobile_orderby'][$automobile_counter]) && $_POST['automobile_orderby'][$automobile_counter] == "register") {
				    $shortcode = '';

				    $register = $column->addChild('register');
				    $register->addChild('page_element_size', htmlspecialchars($_POST['register_element_size'][$automobile_global_counter_register]));
				    $register->addChild('register_element_size', htmlspecialchars($_POST['register_element_size'][$automobile_global_counter_register]));
				    if (isset($_POST['automobile_widget_element_num'][$automobile_counter]) && $_POST['automobile_widget_element_num'][$automobile_counter] == 'shortcode') {
					$shortcode_str = isset($_POST['shortcode']['register'][$automobile_shortcode_counter_register]) && $_POST['shortcode']['register'][$automobile_shortcode_counter_register] != '' ? $_POST['shortcode']['register'][$automobile_shortcode_counter_register] : '';
					$register->addChild('automobile_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
					$automobile_shortcode_counter_register++;
				    } else {
					$shortcode .= '[automobile_register ';
					if (isset($_POST['automobile_var_register_title'][$automobile_counter_register]) && trim($_POST['automobile_var_register_title'][$automobile_counter_register]) <> '') {
					    $shortcode .= 'automobile_var_register_title="' . htmlspecialchars($_POST['automobile_var_register_title'][$automobile_counter_register]) . '" ';
					}
					$shortcode .= ']';
					$register->addChild('automobile_shortcode', $shortcode);
					$automobile_counter_register++;
				    }
				    $automobile_global_counter_register++;
				}
				$automobile_counter++;
			    }
			    $widget_no++;
			}
			$column_container_no++;
		    }
		}
		update_post_meta($post_id, 'automobile_page_builder', $sxe->asXML());
		//creating xml page builder end
	    }
	}

    }
}
?>