<?php
/**
 * 
 * @return html
 *
 */
/*
 *
 * Start Function how to create Dealer elements and Dealer short codes
 *
 */

if ( ! function_exists('automobile_var_page_builder_inventories') ) {

	function automobile_var_page_builder_inventories($die = 0) {
		global $automobile_node, $automobile_html_fields, $post, $automobile_form_fields, $automobile_var_plugin_static_text;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_automobile_inventory_view = '';
		$output = array();
		$counter = $_POST['counter'];
		$automobile_counter = $_POST['counter'];
		if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes($shortcode_element_id);
			$PREFIX = 'automobile_inventories';
			$parseObject = new ShortcodeParse();
			$output = $parseObject->automobile_shortcodes($output, $shortcode_str, true, $PREFIX);
		}

		$defaults = array( 'column_size' => '1/1', 'automobile_inventory_title' => '', 'automobile_inventory_sub_title' => '', 'automobile_inventory_top_search' => '', 'automobile_inventory_view' => 'classic', 'automobile_inventory_type' => '', 'automobile_inventory_make' => '', 'automobile_inventory_num_results' => '', 'automobile_inventory_result_type' => 'all', 'automobile_inventory_searchbox' => 'yes', 'automobile_inventory_filterable' => 'yes', 'automobile_inventory_show_pagination' => 'pagination', 'automobile_inventory_pagination' => '10', 'automobile_inventories_counter' => rand(10000000, 99999999) );
		if ( isset($output['0']['atts']) )
			$atts = $output['0']['atts'];
		else
			$atts = array();
		$inventories_element_size = '50';
		foreach ( $defaults as $key => $values ) {
			if ( isset($atts[$key]) )
				$$key = $atts[$key];
			else
				$$key = $values;
		}
		$name = 'automobile_var_page_builder_inventories';
		$coloumn_class = 'column_' . $inventories_element_size;
		if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
		?>
		<div id="<?php echo esc_attr($name . $automobile_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php
		if ( isset($shortcode_view) ) {
			echo esc_attr($shortcode_view);
		}
		?>" item="inventories" data="<?php echo automobile_element_size_data_array_index($inventories_element_size) ?>">
				 <?php automobile_element_setting($name, $automobile_counter, $inventories_element_size); ?>
			<div class="cs-wrapp-class-<?php echo intval($automobile_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $automobile_counter); ?>" data-shortcode-template="[automobile_inventories {{attributes}}]"  style="display: none;">
				<div class="cs-heading-area">
					<h5><?php echo automobile_var_plugin_text_srt('automobile_var_edit_inventories_option') ?></h5>
					<a href="javascript:automobile_var_removeoverlay('<?php echo esc_attr($name . $automobile_counter) ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose">
						<i class="icon-times"></i></a>
				</div>
				<div class="cs-pbwp-content">
					<div class="cs-wrapp-clone cs-shortcode-wrapp">
						<?php
						if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
							automobile_shortcode_element_size();
						}
						?>

						<?php
						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_section_title'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_section_title_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_title,
								'id' => 'inventory_title',
								'cust_name' => 'automobile_inventory_title[]',
								'return' => true,
							),
						);

						$automobile_html_fields->automobile_text_field($automobile_opt_array);

						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_inventory_view'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_inventory_view_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_view,
								'id' => 'inventory_view',
								'cust_name' => 'automobile_inventory_view[]',
								'classes' => 'dropdown chosen-select',
								'extra_atr' => ' onchange=automobile_inv_elem_view_change(this.value)',
								'options' => array(
									'grid' => automobile_var_plugin_text_srt('automobile_var_grid'),
									'classic' => automobile_var_plugin_text_srt('automobile_var_classic'),
								        'slider' => automobile_var_plugin_text_srt('automobile_var_slider'),
								        'fancy' => automobile_var_plugin_text_srt('automobile_var_fancy'),
								),
								'return' => true,
							),
						);

						$automobile_html_fields->automobile_select_field($automobile_opt_array);

						echo '<div class="cs-not-slider-view-area-inv" style="display:' . ($automobile_inventory_view != 'slider' ? 'block' : 'none') . ';">';
						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_inventory_top_content'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_inventory_top_content_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_top_search,
								'id' => 'inventory_top_search',
								'cust_name' => 'automobile_inventory_top_search[]',
								'classes' => 'dropdown chosen-select',
								'options' => array(
									'None' => automobile_var_plugin_text_srt('automobile_var_none'),
									'section_title' => automobile_var_plugin_text_srt('automobile_var_section_title'),
									'total_records' => automobile_var_plugin_text_srt('automobile_var_inventory_total_records_with_title'),
								),
								'return' => true,
							),
						);

						$automobile_html_fields->automobile_select_field($automobile_opt_array);
echo '<div class="cs-not-fancy-view-area-inv" style="display:' . ($automobile_inventory_view != 'fancy' ? 'block' : 'none') . ';">';
						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_search_box'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_search_box_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_searchbox,
								'id' => 'inventory_searchbox',
								'cust_name' => 'automobile_inventory_searchbox[]',
								'classes' => 'dropdown chosen-select',
								'options' => array(
									'yes' => automobile_var_plugin_text_srt('automobile_var_yes'),
									'no' => automobile_var_plugin_text_srt('automobile_var_no'),
								),
								'return' => true,
							),
						);

						$automobile_html_fields->automobile_select_field($automobile_opt_array);
echo '</div>';
						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_result_type'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_result_type_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_result_type,
								'id' => 'inventory_result_type',
								'cust_name' => 'automobile_inventory_result_type[]',
								'classes' => 'dropdown chosen-select',
								'options' => array(
									'all' => automobile_var_plugin_text_srt('automobile_var_all'),
									'featured' => automobile_var_plugin_text_srt('automobile_var_featured_only'),
								),
								'return' => true,
							),
						);

						$automobile_html_fields->automobile_select_field($automobile_opt_array);

						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_pagination'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_pagination_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_show_pagination,
								'id' => 'inventory_show_pagination',
								'cust_name' => 'automobile_inventory_show_pagination[]',
								'classes' => 'dropdown chosen-select',
								'options' => array(
									'pagination' => automobile_var_plugin_text_srt('automobile_var_pagination'),
									'single_page' => automobile_var_plugin_text_srt('automobile_var_single_page'),
								),
								'return' => true,
							),
						);

						$automobile_html_fields->automobile_select_field($automobile_opt_array);

						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_post_per_post'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_post_per_post_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_pagination,
								'id' => 'inventory_pagination',
								'cust_name' => 'automobile_inventory_pagination[]',
								'return' => true,
							),
						);

						$automobile_html_fields->automobile_text_field($automobile_opt_array);
						echo '</div>';

						echo '<div class="cs-slider-view-area-inv" style="display:' . ($automobile_inventory_view == 'slider' ? 'block' : 'none') . ';">';
						$automobile_inventory_types = array( '' => automobile_var_plugin_text_srt('automobile_var_select_type') );
						$inventory_type_posts = get_posts(array( 'posts_per_page' => '-1', 'post_type' => 'inventory-type', 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ));
						foreach ( $inventory_type_posts as $inv_post ) {
							$automobile_inventory_types[$inv_post->post_name] = $inv_post->post_title;
						}
						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_type'),
							'desc' => '',
							'hint_text' => automobile_var_plugin_text_srt('automobile_var_type_hint'),
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_type,
								'id' => 'inventory_type',
								'cust_name' => 'automobile_inventory_type[]',
								'extra_atr' => ' onchange=automobile_inv_elem_type_change(this.value)',
								'classes' => 'dropdown chosen-select',
								'options' => $automobile_inventory_types,
								'return' => true,
							),
						);
						$automobile_html_fields->automobile_select_field($automobile_opt_array);

						$inventory_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$automobile_inventory_type", 'post_status' => 'publish' ));
						$inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

						$automobile_inventory_type_makes = get_post_meta($inventory_type_id, 'automobile_inventory_type_makes', true);
						if ( ! is_array($automobile_inventory_type_makes) || ! count($automobile_inventory_type_makes) > 0 ) {
							$automobile_inventory_type_makes = array();
						}
						$args = array(
							'type' => 'post',
							'child_of' => 0,
							'parent' => '',
							'orderby' => 'name',
							'order' => 'ASC',
							'hide_empty' => 0,
							'hierarchical' => 1,
							'exclude' => '',
							'include' => '',
							'number' => '',
							'taxonomy' => 'inventory-make',
							'pad_counts' => false
						);
						$categories = get_categories($args);

						$tax_options = '<option value="">-- ' . automobile_var_plugin_text_srt('automobile_var_select_makes') . ' --</option>';

						if ( $categories ) {
							foreach ( $categories as $category ) {

								if ( in_array($category->slug, $automobile_inventory_type_makes) ) {
									$tax_options .= '<option ' . selected($category->slug, $automobile_inventory_make, false) . ' value="' . $category->slug . '">' . $category->name . '</option>';
								}
							}
						}

						echo '<div class="cs-inv-elem-makes">';
						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_makes'),
							'desc' => '',
							'hint_text' => '',
							'echo' => true,
							'field_params' => array(
								'std' => '',
								'id' => 'inventory_make',
								'cust_name' => 'automobile_inventory_make[]',
								'classes' => 'chosen-select',
								'options_markup' => true,
								'options' => $tax_options,
								'return' => true,
							),
						);
						$automobile_html_fields->automobile_select_field($automobile_opt_array);
						echo '</div>';

						$automobile_opt_array = array(
							'name' => automobile_var_plugin_text_srt('automobile_var_show_results'),
							'desc' => '',
							'hint_text' => '',
							'echo' => true,
							'field_params' => array(
								'std' => $automobile_inventory_num_results,
								'id' => 'inventory_num_results',
								'cust_name' => 'automobile_inventory_num_results[]',
								'return' => true,
							),
						);
						$automobile_html_fields->automobile_text_field($automobile_opt_array);

						$automobile_opt_array = array(
							'id' => 'inventories_counter',
							'cust_name' => 'automobile_inventories_counter[]',
							'std' => $automobile_inventories_counter,
						);
						$automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
						echo '</div>';

						if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
							?>
							<ul class="form-elements insert-bg">
								<li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:automobile_shortcode_insert_editor('<?php echo esc_js(str_replace('automobile_var_pb_', '', $name)); ?>', '<?php echo esc_js($name . $automobile_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo automobile_var_plugin_text_srt('automobile_var_insert') ?></a> </li>
							</ul>
							<div id="results-shortocde"></div>
						<?php } else { ?>
							<ul class="form-elements">
								<li class="to-label"></li>
								<li class="to-field">
									<?php
									$automobile_opt_array = array(
										'id' => '',
										'std' => 'inventories',
										'cust_id' => "",
										'cust_name' => "automobile_orderby[]",
									);

									$automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
									$automobile_opt_array = array(
										'id' => '',
										'std' => automobile_var_plugin_text_srt('automobile_var_save'),
										'cust_id' => "",
										'cust_name' => "",
										'cust_type' => 'button',
										'extra_atr' => 'style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))"',
									);

									$automobile_form_fields->automobile_form_text_render($automobile_opt_array);
									?>
								</li>
							</ul>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<script>
		    jQuery(document).ready(function ($) {
		        chosen_selectionbox();
		        popup_over();
		    });
		</script> 
		<?php
		if ( $die <> 1 )
			die();
	}

	add_action('wp_ajax_automobile_var_page_builder_inventories', 'automobile_var_page_builder_inventories');
}

function automobile_inv_elem_type_change() {
	global $automobile_html_fields, $automobile_var_plugin_static_text;
	$automobile_inv_type_slug = isset($_POST['inventory_type_slug']) ? $_POST['inventory_type_slug'] : '';

	$inventory_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'inventory-type', 'name' => "$automobile_inv_type_slug", 'post_status' => 'publish' ));
	$inventory_type_id = isset($inventory_type_post[0]->ID) ? $inventory_type_post[0]->ID : 0;

	$automobile_inventory_type_makes = get_post_meta($inventory_type_id, 'automobile_inventory_type_makes', true);
	if ( ! is_array($automobile_inventory_type_makes) || ! count($automobile_inventory_type_makes) > 0 ) {
		$automobile_inventory_type_makes = array();
	}
	$args = array(
		'type' => 'post',
		'child_of' => 0,
		'parent' => '',
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => 0,
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'number' => '',
		'taxonomy' => 'inventory-make',
		'pad_counts' => false
	);
	$categories = get_categories($args);

	$tax_options = '<option value="">-- ' . automobile_var_plugin_text_srt('automobile_var_select_makes') . ' --</option>';

	if ( $categories ) {
		foreach ( $categories as $category ) {

			if ( in_array($category->slug, $automobile_inventory_type_makes) ) {
				$tax_options .= '<option value="' . $category->slug . '">' . $category->name . '</option>';
			}
		}
	}

	$automobile_opt_array = array(
		'name' => automobile_var_plugin_text_srt('automobile_var_makes'),
		'desc' => '',
		'hint_text' => '',
		'echo' => false,
		'field_params' => array(
			'std' => '',
			'id' => 'inventory_make',
			'cust_name' => 'automobile_inventory_make[]',
			'classes' => 'chosen-select',
			'options_markup' => true,
			'options' => $tax_options,
			'return' => true,
		),
	);
	$html = $automobile_html_fields->automobile_select_field($automobile_opt_array);
	$html .= '<script>jQuery(document).ready(function(){chosen_selectionbox();});</script>';

	echo json_encode(array( 'type_makes' => $html ));
	die;
}

add_action('wp_ajax_automobile_inv_elem_type_change', 'automobile_inv_elem_type_change');
