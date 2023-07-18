<?php
/**
 * File Type: dealer
 */
function automobile_dealer_popup_style() {
    wp_enqueue_style('custom-candidate-style-inline', plugins_url('../assets/backend/css/custom_script.css', __FILE__));
    $automobile_plugin_options = get_option('automobile_plugin_options');
    $automobile_custom_css = '#id_confrmdiv
{
	display: none;
	background-color: #eee;
	border-radius: 5px;
	border: 1px solid #aaa;
	position: fixed;
	width: 300px;
	left: 50%;
	margin-left: -150px;
	padding: 6px 8px 8px;
	box-sizing: border-box;
	text-align: center;
}
#id_confrmdiv .button {
	background-color: #ccc;
	display: inline-block;
	border-radius: 3px;
	border: 1px solid #aaa;
	padding: 2px;
	text-align: center;
	width: 80px;
	cursor: pointer;
}
#id_confrmdiv .button:hover
{
	background-color: #ddd;
}
#confirmBox .message
{
	text-align: left;
	margin-bottom: 8px;
}';
    wp_add_inline_style('custom-candidate-style-inline', $automobile_custom_css);
}

add_action('wp_enqueue_scripts', 'automobile_dealer_popup_style', 5);
get_header();

global $automobile_var_plugin_static_text,$automobile_var_plugin_options;
?>
<div class="main-section" id="primary" >
    <main class="page-section" id="dealer-dashboard">
        <div class="<?php if (isset($automobile_var_plugin_options['automobile_plugin_single_container']) && $automobile_var_plugin_options['automobile_plugin_single_container'] == 'on') echo 'container' ?>">
            <div class="post-1 post type-post status-publish format-standard hentry category-uncategorized">
                <!-- alert for complete theme -->
                <div class="automobile_alerts" ></div>

                <?php
                global $post, $current_user, $wp_roles, $userdata, $automobile_plugin_options;

                //$slug = $post_inventry_type->post_name;
                automobile_var::automobile_enqueue_tabs_script();
                automobile_var::automobile_jquery_ui_scripts();
                $automobile_emp_funs = '';
                if (class_exists('automobile_dealer_functions')) {
                    $automobile_emp_funs = new automobile_dealer_functions();
                }
                $automobile_emp_temps = '';
                if (class_exists('automobile_dealer_templates')) {
                    $automobile_emp_temps = new automobile_dealer_templates();
                }
                if (class_exists('automobile_dealer_ajax_templates')) {
                    $automobile_emp_ajax_temps = new automobile_dealer_ajax_templates();
                }
                $uid = $current_user->ID;
                if (isset($_GET['uid']) && $_GET['uid'] <> '') {
                    $uid = $_GET['uid'];
                }
                $automobile_action = isset($_POST['button_action']) ? $_POST['button_action'] : '';
                $post_title = isset($_POST['post_title']) ? $_POST['post_title'] : '';
                $post_content = isset($_POST['dealer_content']) ? $_POST['dealer_content'] : '';
                $post_author = $uid;
                $automobile_post_id = $automobile_emp_funs->automobile_get_post_id_by_meta_key("automobile_user", $uid);
                // Create dealer post
                $dealer_post = array(
                    'ID' => $automobile_post_id,
                    'post_title' => $post_title,
                    'post_content' => $post_content,
                    'post_author' => $post_author,
                    'post_type' => 'dealer',
                    'post_date' => current_time('Y-m-d h:i:s')
                );

                if (isset($automobile_post_id) and $automobile_post_id <> '' and $automobile_action == 'update') {
                    wp_update_post($dealer_post);
                }
                if (is_user_logged_in()) {
                    global $current_user;
                    $automobile_emp_dashboard = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : '';
                    if ($automobile_emp_dashboard != '') {
                        $automobile_dealer_link = get_permalink($automobile_emp_dashboard);
                    }
                    $dealer_post_data = get_post($automobile_post_id);
                    $automobile_dealer_title = isset($dealer_post_data->post_title) ? $dealer_post_data->post_title : '';
                    $dealer_address = get_user_address_string_for_list($automobile_post_id);
                }
                $automobile_emp_funs->automobile_init_editor();
                $automobile_pkg_array = $automobile_blnk_array = $automobile_gallery_images_array = array();
                $automobile_inventory_id = isset($_GET['inventory_id']) ? $_GET['inventory_id'] : '';
                $automobile_gallery_array = array();
		$gallery_media_upload = '';
                if (isset($_FILES['automobile_gallery_user_img_media']) && $_FILES['automobile_gallery_user_img_media'] != '') {
                    $gallery_media_upload = automobile_inventory_gallery_multiple('automobile_gallery_user_img_media');
                    $automobile_gallery_array['media-gallery'] = $gallery_media_upload;
		}

                $automobile_pkg_array['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
                $automobile_pkg_array['inventory_id'] = $automobile_inventory_id;
                $automobile_pkg_array['user_id'] = $uid;
                $automobile_pkg_array['post_array'] = isset($_POST) ? $_POST : '';
		$automobile_pkg_array['post_array']['gallery_user_img'] = $gallery_media_upload;
	
		$gallery_user_img = array();
                $gallery_user_img = isset($_POST['gallery_user_img']) ? $_POST['gallery_user_img'] : '';
		
		if (is_array($gallery_user_img) && !empty($gallery_user_img) && !empty($automobile_gallery_array['media-gallery'])) {
		    
                    $automobile_gallery_images_array = array_merge($gallery_user_img, $automobile_gallery_array['media-gallery']);
                } else {
                    $automobile_gallery_images_array = $gallery_user_img;
                }
                if (is_array($automobile_gallery_images_array) && !empty($automobile_gallery_images_array)) {
                    $automobile_gallery_images_array = array_filter($automobile_gallery_images_array);
                    $automobile_gallery_images_array = array_values($automobile_gallery_images_array);
                    update_post_meta($automobile_inventory_id, "automobile_inventory_gallery_url", $automobile_gallery_images_array);
                }
                if (empty($automobile_gallery_images_array) && $_POST) {
                      update_post_meta($automobile_inventory_id, "automobile_inventory_gallery_url", $automobile_gallery_images_array);
                }
                if (isset($automobile_pkg_array['post_array']['automobile_inventory_desc'])) {
                    $automobile_pkg_array['post_array']['automobile_inventory_desc'] = base64_encode(htmlentities($automobile_pkg_array['post_array']['automobile_inventory_desc']));
                }


                $automobile_blnk_array['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
                $automobile_blnk_array['inventory_id'] = '';
                $automobile_blnk_array['user_id'] = $uid;
                if (is_array($automobile_pkg_array) && sizeof($automobile_pkg_array) > 0) {
                    $automobile_pkg_array = json_encode($automobile_pkg_array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		    
                }


                if (is_array($automobile_blnk_array) && sizeof($automobile_blnk_array) > 0) {
                    $automobile_blnk_array = json_encode($automobile_blnk_array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                }
                ?>
                <script type="text/javascript">
                    var pkg_array = '<?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_pkg_array) ?>';
                    var blank_array = '<?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_blnk_array) ?>';

                    var autocomplete;
                </script>
                <?php
                $automobile_dash_class = 'active';
                $automobile_inventory_class = '';
                if ($automobile_inventory_id != '') {
                    $automobile_dash_class = '';
                    $automobile_inventory_class = 'active';
                }
                if (is_user_logged_in()) {


                    $user_role = automobile_get_loginuser_role();
                    if (isset($user_role) && $user_role <> '' && $user_role == 'automobile_dealer') {
                        ?>
                        <div class="cs-user-account-holder">	
                                <div class="row">
                                    <?php
                                    global $current_user;
                                    $dealer_post_data = get_post($automobile_post_id);
                                    $automobile_dealer_title = isset($dealer_post_data->post_title) ? $dealer_post_data->post_title : '';
                                    $automobile_dealer_address = get_user_address_string_for_list($automobile_post_id);
                                    ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="cs-tabs nav-position-left row" id="cstabs">
                                            <?php $automobile_emp_temps->automobile_dealer_menu($uid, $automobile_pkg_array); ?>
                                            <div class="tab-content" id="dealer-dashboard" data-validationmsg="<?php echo automobile_var_plugin_text_srt('automobile_var_please_ensure'); ?>">
                                                <!-- warning popup -->

                                                <div id="id_confrmdiv">
                                                    <div class="cs-confirm-container">
                                                        <i class="icon-exclamation2"></i>
                                                        <div class="message"><?php echo automobile_var_plugin_text_srt('automobile_var_really_want_delete'); ?></div>
                                                        <a href="javascript:void(0);" id="id_truebtn"><?php echo automobile_var_plugin_text_srt('automobile_var_yes_delete'); ?></a>
                                                        <a href="javascript:void(0);" id="id_falsebtn"><?php echo automobile_var_plugin_text_srt('automobile_var_cancel'); ?></a>
                                                    </div>
                                                </div>
                                                <div class="main-cs-loader"></div>
                                                <!-- end warning popup -->

                                                <?php
                                                $automobile_posting = '';
                                                if (isset($_POST['automobile_posting']) && $_POST['automobile_posting'] == 'new') {
                                                    $automobile_posting = 'new';
                                                }
                                                if ($automobile_posting != 'new') {
                                                    $automobile_var = new automobile_var();
                                                    $automobile_var->automobile_location_gmap_script();
                                                    $automobile_var->automobile_google_place_scripts();
                                                    $automobile_var->automobile_autocomplete_scripts();
                                                    ?>
                                                    <div id="cs-act-tab" class="tab-pane <?php echo sanitize_html_class($automobile_inventory_class) ?> fade in tabs-container">
                                                        <?php $automobile_emp_temps->automobile_inventory_action($uid) ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="tab-pane <?php if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-genral-setting') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) echo 'active'; ?> fade1 tabs-container" id="user-genral-setting">
                                                    <div class="cs-loader"></div>
                                                    <?php
                                                    if ((isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-genral-setting') || (!isset($_REQUEST['profile_tab']) || $_REQUEST['profile_tab'] == '')) {
                                                        ?>
                                                        <script>
                                                            jQuery(window).on('load',function () {
                                                                automobile_ajax_dealer_profile('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
                                                            });
                                                        </script>


                                                    <?php }
                                                    ?>
                                                </div>
                                                <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-post-vehicle') echo 'active'; ?> fade1 tabs-container" id="user-post-vehicle">
                                                    <div class="cs-loader"></div>
                                                    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-post-vehicle') {
                                                        ?>
                                                        <script>
                                                            jQuery(window).on('load',function () {
                                                                automobile_dealer_post_inventory('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
                                                            });
                                                        </script>
                                                    <?php }
                                                    ?>
                                                </div>
                                                <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-car-listing') echo 'active'; ?> fade1 tabs-container" id="user-car-listing">
                                                    <div class="cs-loader"></div>
                                                    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-car-listing') {
                                                        ?>
                                                        <script>
                                                            jQuery(window).on('load',function () {
                                                                automobile_ajax_manage_inventory('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
                                                            });
                                                        </script>
                                                    <?php }
                                                    ?>
                                                </div>
                                                <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') echo 'active'; ?> fade1 tabs-container" id="transactions">
                                                    <div class="cs-loader"></div>
                                                    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'transactions') { ?>
                                                        <script>
                                                            jQuery(window).on('load',function () {
                                                                automobile_ajax_trans_history('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
                                                            });
                                                        </script>
                                                    <?php }
                                                    ?>
                                                </div>

                                                <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-car-shortlist') echo 'active'; ?> fade1 tabs-container" id="user-car-shortlist">
                                                    <div class="cs-loader"></div>
                                                    <?php
                                                    if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-car-shortlist') {
                                                        ?>
                                                        <script>
                                                            jQuery(window).on('load',function () {
                                                                automobile_ajax_shortlisted_vehicles('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>');
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') echo 'active'; ?> fade1 tabs-container" id="packages">
                                                    <div class="cs-loader"></div>
                                                    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'packages') {
                                                        ?>
                                                        <script>
                                                            jQuery(window).on('load',function () {
                                                                automobile_ajax_inventory_packages(pkg_array);
                                                            });
                                                        </script>
                                                    <?php }
                                                    ?>
                                                </div>
                                                <div class="tab-pane <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-post-vehicle') echo 'active'; ?> fade1 tabs-container" id="user-post-vehicle">
                                                    <div class="cs-loader"></div>
                                                    <?php if (isset($_REQUEST['profile_tab']) && $_REQUEST['profile_tab'] == 'user-post-vehicle') {
                                                        ?>
                                                        <script type="text/javascript">
                                                            jQuery(window).on('load',function () {
                                                                automobile_dealer_post_inventory('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js($uid) ?>', pkg_array);
                                                            });
                                                        </script>
                                                    <?php }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <?php
                    } else {
                        ?>
                        <div id="main">
                            <div class="main-section">
                                <section class="candidate-profile">
                                    <div class="<?php if (isset($automobile_var_plugin_options['automobile_plugin_single_container']) && $automobile_var_plugin_options['automobile_plugin_single_container'] == 'on') echo 'container' ?>">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="unauthorized">
                                                    <?php
                                                    echo force_balance_tags(automobile_var_plugin_text_srt('automobile_var_please_register'));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div id="main">
                        <div class="main-section">
                            <section class="candidate-profile">
                                <div class="<?php if (isset($automobile_var_plugin_options['automobile_plugin_single_container']) && $automobile_var_plugin_options['automobile_plugin_single_container'] == 'on') echo 'container' ?>"  data-validationmsg="<?php echo automobile_var_plugin_text_srt('automobile_var_please_ensure'); ?>">
                                   <div class="container">
									<div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            echo '<div id="user-post-vehicle">';
                                            //$automobile_emp_temps->automobile_dealer_post_inventory();
                                            echo do_shortcode('[automobile_register register_role="dealer"] [/automobile_register]');
                                            echo '</div>';
                                            ?>
                                        </div>
                                    </div>
								 </div>
                                </div>
                        </div> 
                        </section>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
</div>
</main>
</div>
<?php
get_footer();