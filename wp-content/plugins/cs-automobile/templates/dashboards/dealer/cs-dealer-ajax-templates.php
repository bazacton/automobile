<?php
/**
 * File Type: Dealer Ajax Templates
 */
if (!class_exists('automobile_dealer_ajax_templates')) {

    class automobile_dealer_ajax_templates {

        /**
         * Start construct Functions
         */
        public function __construct() {
            // Profile
            add_action('wp_ajax_automobile_dealer_ajax_profile', array(&$this, 'automobile_dealer_ajax_profile'));
            add_action('wp_ajax_nopriv_automobile_dealer_ajax_profile', array(&$this, 'automobile_dealer_ajax_profile'));
            // Transactions
            add_action('wp_ajax_automobile_ajax_trans_history', array(&$this, 'automobile_ajax_trans_history'));
            add_action('wp_ajax_nopriv_automobile_ajax_trans_history', array(&$this, 'automobile_ajax_trans_history'));
            // inventory Management
            add_action('wp_ajax_automobile_ajax_manage_inventory', array(&$this, 'automobile_ajax_manage_inventory'));
            add_action('wp_ajax_nopriv_automobile_ajax_manage_inventory', array(&$this, 'automobile_ajax_manage_inventory'));
            // Favourite Resumes
            add_action('wp_ajax_automobile_ajax_shortlisted_vehicles', array(&$this, 'automobile_ajax_shortlisted_vehicles'));
            add_action('wp_ajax_nopriv_automobile_ajax_shortlisted_vehicles', array(&$this, 'automobile_ajax_shortlisted_vehicles'));
            add_action('wp_ajax_automobile_ajax_manage_inventory_ajax', array(&$this, 'automobile_ajax_manage_inventory_ajax'));
            add_action('wp_ajax_nopriv_automobile_ajax_manage_inventory_ajax', array(&$this, 'automobile_ajax_manage_inventory_ajax'));
            // inventory Packages
            add_action('wp_ajax_automobile_ajax_inventory_packages', array(&$this, 'automobile_ajax_inventory_packages'));
            add_action('wp_ajax_nopriv_automobile_ajax_inventory_packages', array(&$this, 'automobile_ajax_inventory_packages'));
        }

        /**
         * End construct Functions

         * * Start Function for Creating of dealer profile in Ajax
         */
        public function automobile_dealer_ajax_profile($uid = '') {

            global $post, $current_user, $automobile_form_fields, $automobile_form_fields_frontend, $automobile_var_plugin_static_text;
            $stringsObj = new automobile_plugin_all_strings();
            $stringsObj->automobile_var_plugin_login_strings();
            $stringsObj->automobile_var_plugin_option_strings();
            /*
              $strings = new automobile_var_plugin_static_text;
              $strings->automobile_template_strings();
             */
            $automobile_var_a = automobile_var_plugin_text_srt('automobile_var_a');

            $automobile_emp_funs = new automobile_dealer_functions();
            if ($uid == '') {
                $uid = (isset($_POST['automobile_uid']) and $_POST['automobile_uid'] <> '') ? $_POST['automobile_uid'] : $current_user->ID;
            }
            if ($uid != '') {
                $automobile_user_data = get_userdata($uid);

                $automobile_comp_name = $automobile_user_data->display_name;
                $automobile_var_dealer_email = $automobile_user_data->user_email;
                $automobile_comp_detail = $automobile_user_data->description;
                $automobile_user_status = get_user_meta($uid, 'automobile_user_status', true);
                $automobile_minimum_salary = get_user_meta($uid, 'automobile_minimum_salary', true);
                $automobile_allow_search = get_user_meta($uid, 'automobile_allow_search', true);
                $automobile_facebook = get_user_meta($uid, 'automobile_facebook', true);
                $automobile_twitter = get_user_meta($uid, 'automobile_twitter', true);
                $automobile_google_plus = get_user_meta($uid, 'automobile_google_plus', true);
                $automobile_linkedin = get_user_meta($uid, 'automobile_linkedin', true);
                $automobile_phone_number = get_user_meta($uid, 'automobile_phone_number', true);
                $automobile_email = $automobile_user_data->user_email;
                $automobile_website = $automobile_user_data->user_url;
                $automobile_comp_address = get_user_meta($uid, 'automobile_complete_address', true);
                $automobile_value = get_user_meta(get_current_user_id(), 'user_img', true);

                $imagename_only = $automobile_value;

                $automobile_var = new automobile_var();
                ?>
                <div class="cs-loader"></div>

                <form id="automobile_dealer_form" name="automobile_dealer_form"  enctype="multipart/form-data" method="post">
                    <div class="scetion-title">
                        <h4><?php echo automobile_var_plugin_text_srt('automobile_var_my_profile'); ?></h4>
                    </div>
                    <div class="dashboard-content-holder">
                        <div class="cs-account-info">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="cs-profile-pic">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <div class="cs-img-detail">
                                                <div class="profile-pic">
                                                    <div class="cs-media" >
                                                        <div class="page-wrap" id="automobile_dealer_img_box">
                                                            <figure>
                                                                <?php
                                                                if ($automobile_value <> '') {
                                                                    $automobile_value = automobile_get_user_attachment_url_from_name($automobile_value);
                                                                    ?>
                                                                    <img src="<?php echo esc_url($automobile_value); ?>" id="automobile_dealer_img_img" width="100" alt="" />
                                                                    <div class="gal-edit-opts close"><a href="javascript:automobile_del_media('automobile_dealer_img')" class="delete">
                                                                            <span aria-hidden="true"><?php echo esc_html($automobile_var_a); ?></span></a>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <img src="<?php echo esc_url($automobile_var->plugin_url()); ?>assets/frontend/images/not-found.png" id="automobile_dealer_img_img" width="100" alt="" />
                                                                    <?php
                                                                }
                                                                ?>
                                                        </div>
                                                        </figure>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                            <div class="cs-browse-holder"> <em><?php echo automobile_var_plugin_text_srt('automobile_var_profile_photo'); ?></em> <span class="file-input btn-file"><?php echo automobile_var_plugin_text_srt('automobile_var_update_avatar'); ?>
                                                    <?php
                                                    $automobile_opt_array = array(
                                                        'std' => $imagename_only,
                                                        'id' => '',
                                                        'return' => true,
                                                        'cust_id' => 'automobile_dealer_img',
                                                        'cust_name' => 'automobile_dealer_img',
                                                        'prefix' => '',
                                                    );
                                                    echo force_balance_tags($automobile_form_fields->automobile_form_hidden_render($automobile_opt_array));
                                                    $automobile_opt_array = array(
                                                        'std' => automobile_var_plugin_text_srt('automobile_var_browse'),
                                                        'id' => '',
                                                        'force_std' => true,
                                                        'return' => true,
                                                        'cust_id' => '',
                                                        'cust_name' => 'media_upload',
                                                        'classes' => 'left cs-uploadimg upload',
                                                        'cust_type' => 'file',
                                                    );
                                                    echo force_balance_tags($automobile_form_fields->automobile_form_text_render($automobile_opt_array));
                                                    ?>
                                                </span> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cs-field-holder">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo automobile_var_plugin_text_srt('automobile_var_full_name') ?></label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="cs-field">
                                        <?php
                                        $automobile_opt_array = array(
                                            'cust_id' => 'display_name',
                                            'cust_name' => 'display_name',
                                            'std' => $automobile_comp_name,
                                            'desc' => '',
                                            'classes' => 'form-control',
                                            'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_company_name') . '"',
                                            'hint_text' => '',
                                        );

                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </div>
                                </div>
                            </div>


                          
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								 <div class="cs-switch-holder">
                                        <label><?php echo automobile_var_plugin_text_srt('automobile_var_allow_in_search'); ?></label>
                                        <div class="material-switch pbwp-checkbox cs-chekbox">
                                            <?php
                                            $on_off_option = array(
                                                "show" => "yes",
                                                "hide" => "off",
                                            );
                                            $automobile_opt_array = array(
                                                'id' => 'allow_search',
                                                'std' => '',
                                                'desc' => '',
                                                'view' => 'simple',
                                                'extra_atr' => 'data-placeholder="' . automobile_var_plugin_text_srt('automobile_var_please_select') . '"',
                                                'classes' => 'form-control',
                                                'options' => $on_off_option,
                                                'hint_text' => '',
                                            );

                                            $automobile_form_fields_frontend->automobile_form_checkbox_render($automobile_opt_array);
                                            ?>
                                            <label for="automobile_allow_search" class="label-default"></label>
                                        </div>
                                    </div>
                                </div>
                          
                            <div class="cs-field-holder">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo automobile_var_plugin_text_srt('automobile_var_dealer_type'); ?></label>
                                    <div class="select-dropdown">
                                        <?php echo get_dealer_type_dropdown('automobile_dealer_type', 'automobile_dealer_type', $uid, 'form-control chosen-select-no-single', true) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <label><?php echo automobile_var_plugin_text_srt('automobile_var_description'); ?> </label>
                            <?php
                            $automobile_comp_detail = (isset($automobile_comp_detail)) ? $automobile_comp_detail : '';
                            wp_editor($automobile_comp_detail, 'comp_detail', array(
                                'textarea_name' => 'comp_detail',
                                'editor_class' => 'text-input',
                                'teeny' => true,
                                'media_buttons' => false,
                                'textarea_rows' => 6,
                                'quicktags' => false
                                    )
                            );
                            ?>


                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="cs-seprator"></div>
                    </div>
                    <div class="cs-social-network col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="scetion-title">
                            <h6><?php echo automobile_var_plugin_text_srt('automobile_var_social_networks'); ?></h6>
                        </div>
                        <div class="input-info">
                            <div class="row">
                                <div class="social-media-info">
                                    <div class="cs-field-holder">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => 'facebook',
                                                'std' => $automobile_facebook,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_facebook') . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );
                                            $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>

                                        </div>
                                    </div>
                                    <div class="cs-field-holder">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => 'twitter',
                                                'std' => $automobile_twitter,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_twitter') . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );

                                            $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>
                                        </div></div>
                                    <div class="cs-field-holder">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => 'google_plus',
                                                'std' => $automobile_google_plus,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_google_plus') . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );

                                            $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>

                                        </div></div>
                                    <div class="cs-field-holder">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            $automobile_opt_array = array(
                                                'id' => 'linkedin',
                                                'std' => $automobile_linkedin,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_linkedin') . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );

                                            $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                            ?>
                                        </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cs-contact-info col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="scetion-title">
                            <h6><?php echo automobile_var_plugin_text_srt('automobile_var_contact_information'); ?></h6>
                        </div>
                        <div class="input-info">
                            <div class="row">
                                <div class="cs-field-holder">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo automobile_var_plugin_text_srt('automobile_var_phone'); ?></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'id' => 'phone_number',
                                            'std' => $automobile_phone_number,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_phone') . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );
                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </div></div>
                                <div class="cs-field-holder">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo automobile_var_plugin_text_srt('automobile_var_email'); ?></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'cust_id' => 'user_email',
                                            'cust_name' => 'user_email',
                                            'std' => $automobile_email,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_email') . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );
                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </div></div>
                                <div class="cs-field-holder">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo automobile_var_plugin_text_srt('automobile_var_website'); ?></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'cust_id' => 'user_url',
                                            'cust_name' => 'user_url',
                                            'std' => $automobile_website,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_website') . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );
                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </div></div>
                                <div class="cs-field-holder">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label><?php echo automobile_var_plugin_text_srt('automobile_var_complete_address'); ?></label>
                                        <?php
                                        $automobile_opt_array = array(
                                            'cust_id' => 'automobile_complete_address',
                                            'cust_name' => 'automobile_complete_address',
                                            'std' => $automobile_comp_address,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . automobile_var_plugin_text_srt('automobile_var_complete_address') . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );
                                        $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                                        ?>
                                    </div></div>
                                <div class="user-post-vehicles">
                                    <div class="cs-field-holder">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h6><?php echo automobile_var_plugin_text_srt('automobile_var_user_upload_images'); ?></h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="cs-seprator"></div>
                                    </div>

                                    <div class="cs-fields-holder">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                            <div id="multipleuploader">

                                                <?php
                                                global $post, $automobile_form_fields, $automobile_html_fields, $automobile_plugin_options, $automobile_html_fields_frontend;

                                                $automobile_opt_array = array(
                                                    'std' => '',
                                                    'user' => $user,
                                                    'id' => 'gallery_user_img',
                                                    'name' => '',
                                                    'desc' => '',
                                                    'hint_text' => '',
                                                    'echo' => true,
                                                    'field_params' => array(
                                                        'usermeta' => true,
                                                        'user' => $user,
                                                        'std' => '',
                                                        'id' => 'gallery_user_img',
                                                        'return' => true,
                                                    ),
                                                );
                                                $automobile_form_fields->automobile_multiple_custom_upload_file_field($automobile_opt_array);
                                                ?>
                                            </div>
                                            <div id="multipleuploader-new-loads"></div>

                                        </div>
                                    </div>
                                    <div class="cs-field-holder">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="cs-upload-img">

                                                <p><?php echo automobile_var_plugin_text_srt('automobile_var_upload_images_dis'); ?></p>
                                                <p><?php echo automobile_var_plugin_text_srt('automobile_var_upload_images_hint'); ?></p>
                                                <p></p>
                                                <div class="cs-browse-holder"><span class="file-input btn-file">
                                                        <a id="duplicatorbtn" onlick="duplicate()" class="btn button"><?php echo automobile_var_plugin_text_srt('automobile_var_upload_photos'); ?></a>
                                                    </span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>

                                    document.getElementById('duplicatorbtn').onclick = duplicate;
                                    var i = 0;
                                    //var original = document.getElementById('multipleuploader').html;


                                    function duplicate() {

                                        var counter = 2;
                                        jQuery("#multipleuploader-new-loads").append('<div class="adding-more-img">\n\
                <input id="automobile_gallery_user_img" name="gallery_user_img[]" type="hidden" class="" value="">\n\
                <input name="automobile_gallery_user_img_media[]" type="file" value="Browse">\n\
                <div class="page-wrap" style="display: none;" id="automobile_gallery_user_img_box">\n\
                <div class="gal-active"><div class="dragareamain" style="padding-bottom:0px;">\n\
                <ul id="gal-sortable"><li class="ui-state-default" id=""><div class="thumb-secs">\n\
                <img src="" id="automobile_gallery_user_img_img" width="100" alt="">\n\
                <div class="gal-edit-opts">\n\
                <a href="javascript:del_media(\'automobile_gallery_user_img\')" class="delete"></a> </div></div></li></ul></div></div></div><p></p></div>');
                                        counter++;
                                        ;
                                    }
                                </script>

                            </div>
                        </div>
                    </div>

                    <div class="cs-field-holder">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-md-12">
                            <div class="cs-field"><div class="cs-btn-submit">
                                    <?php
                                    $automobile_opt_array = array(
                                        'std' => 'update_profile',
                                        'id' => '',
                                        'echo' => true,
                                        'cust_id' => 'user_profile',
                                        'cust_name' => 'user_profile',
                                    );
                                    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'std' => $uid,
                                        'id' => '',
                                        'echo' => true,
                                        'cust_id' => 'automobile_user',
                                        'cust_name' => 'automobile_user',
                                    );
                                    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                    ?>


                                    <input type="button" name="button_action" value="update" class="acc-submit cs-section-update cs-color csborder-color" onclick="javascript:ajax_dealer_profile_form_save('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_js(automobile_var::plugin_url()); ?>', 'automobile_dealer_form')">
                                    <?php
                                    $automobile_opt_array = array(
                                        'std' => 'ajax_dealer_form_save',
                                        'id' => '',
                                        'echo' => true,
                                        'cust_name' => 'action',
                                    );
                                    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);

                                    $automobile_opt_array = array(
                                        'std' => $uid,
                                        'id' => '',
                                        'echo' => true,
                                        'cust_name' => 'post_id',
                                    );
                                    $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);
                                    ?>

                                </div>  </div></div></div>
                </div>
                </form>
                <script type="text/javascript">

                    /*
                     * modern selection box function
                     */
                    jQuery(document).ready(function ($) {
                        chosen_selectionbox();
                    });
                    /*
                     * modern selection box function
                     */
                    tinymce.init({
                        selector: "textarea#comp_detail",
                        menubar: false,
                        setup: function (editor) {
                            editor.on('change', function () {
                                editor.save();
                            });
                        }
                    });
                    tinymce.editors = [];
                </script>
                <?php
                die();
            }
        }

        /**
         * End Function for Creating of dealer profile in Ajax
         */

        /**
         * Start Function how to manage inventory in ajax funciton
         */
        public function automobile_ajax_manage_inventory() {
            global $post, $automobile_var_plugin_options, $automobile_var_plugin_static_text;
            $automobile_var_expired = automobile_var_plugin_text_srt('automobile_var_expired');
            $automobile_var_removed = automobile_var_plugin_text_srt('automobile_var_removed');
            $automobile_var_active = automobile_var_plugin_text_srt('automobile_var_active');
            $post_to_load = isset($_POST['post_to_load']) ? $_POST['post_to_load'] : '5';
            $inventory_load_status = isset($_POST['status_val']) ? $_POST['status_val'] : '';

            //echo $post_to_load;
            if (class_exists('automobile_dealer_functions')) {
                $automobile_emp_funs = new automobile_dealer_functions();
            }
            $uid = get_current_user_id();
            $automobile_uri = (isset($_POST['automobile_uri']) and $_POST['automobile_uri'] <> '') ? $_POST['automobile_uri'] : '';
            if ($uid != '') {
                ?>
                <div class="cs-manage-inventory">
                    <?php
                    $automobile_emp_dashboard = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : '';
                    if ($automobile_emp_dashboard != '') {
                        $automobile_dealer_link = get_permalink($automobile_emp_dashboard);
                    } else {
                        $automobile_dealer_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    }
                    $automobile_blog_num_post = 5;
                    if (empty($_REQUEST['page_id_all']))
                        $_REQUEST['page_id_all'] = 1;
                    $mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'automobile_inventory_username',
                                'value' => $uid,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'delete',
                                'compare' => '!=',
                            ),
                        ),
                        'order' => "ASC");
                    $loop_count = new WP_Query($mypost);
                    $count_post = $loop_count->post_count;
                    $args = array(
                        'posts_per_page' => $automobile_blog_num_post,
                        'post_type' => 'inventory',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'automobile_inventory_username',
                                'value' => $uid,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'delete',
                                'compare' => '!=',
                            ),
                        ),
                        'orderby' => 'ID',
                        'order' => 'DESC',
                    );
                    $custom_query = new WP_Query($args);
                    if ($inventory_load_status != '' && $inventory_load_status != 'all') {
                        $automobile_blog_num_post = $automobile_blog_num_post * $post_to_load;
                        if (empty($_REQUEST['page_id_all']))
                            $_REQUEST['page_id_all'] = 1;
                        $mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'automobile_inventory_username',
                                    'value' => $uid,
                                    'compare' => '=',
                                ),
                                array(
                                    'key' => 'automobile_inventory_status',
                                    'value' => $inventory_load_status,
                                    'compare' => '==',
                                ),
                            ),
                            'order' => "ASC");
                        $loop_count = new WP_Query($mypost);
                        $count_post = $loop_count->post_count;
                        $args = array(
                            'posts_per_page' => $automobile_blog_num_post,
                            'post_type' => 'inventory',
                            'post_status' => 'publish',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'automobile_inventory_username',
                                    'value' => $uid,
                                    'compare' => '=',
                                ),
                                array(
                                    'key' => 'automobile_inventory_status',
                                    'value' => $inventory_load_status,
                                    'compare' => '==',
                                ),
                            ),
                            'orderby' => 'ID',
                            'order' => 'DESC',
                        );
                        $custom_query = new WP_Query($args);
                    }
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="cs-user-section-title"><h4><?php echo automobile_var_plugin_text_srt('automobile_var_my_vehicles'); ?></h4>
                            <ul>
                                <li>
                                    <?php
                                    global $automobile_form_fields;
                                    $admin_url = admin_url();
                                    $automobile_var_inventory_statuses = array('all' => automobile_var_plugin_text_srt('automobile_var_my_all'), 'active' => automobile_var_plugin_text_srt('automobile_var_my_active'), 'inactive' => automobile_var_plugin_text_srt('automobile_var_my_inactive'), 'awaiting-activation' => automobile_var_plugin_text_srt('automobile_var_my_awaiting'), 'delete' => automobile_var_plugin_text_srt('automobile_var_my_delete'));

                                    $automobile_opt_array = array(
                                        "name" => 'inventory_status',
                                        "std" => $inventory_load_status,
                                        "desc" => "",
                                        "id" => "inventory_status",
                                        'classes' => 'chosen-select-no-single',
                                        "type" => "select_values",
                                        'required' => 'yes',
                                        "extra_atr" => 'onchange="automobile_load_more_ajax_with_status(\'' . $admin_url . '\',this)"',
                                        "options" => $automobile_var_inventory_statuses,
                                    );
                                    echo force_balance_tags($automobile_form_fields->automobile_form_select_render($automobile_opt_array));
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <script>
                            jQuery(document).ready(function ($) {
                                chosen_selectionbox();
                            });
                        </script>
                    </div>
                    <?php
                    if ($custom_query->have_posts()) {

                        $get_uid = ( isset($_GET['uid']) && $_GET['uid'] <> '' ) ? '&amp;uid=' . $_GET['uid'] : '';
                        ?>

                        <div class="dashboard-content-holder">
                            <?php $this->automobile_loop_content($custom_query, $automobile_dealer_link, $get_uid); ?>
                        </div>

                        <div class="ajax-load-more-div"></div>
                        <!--                        <div class="main-cs-loader"></div>-->


                        <?php
                        //==Pagination Start
                        if ($count_post > $automobile_blog_num_post && $automobile_blog_num_post > 0) {
                            echo '<nav>';
                            $counter = '';
                            $admin_url = admin_url();

                            echo '<div class="cs-load-more"><a href="javascript:;" class="loadmore-btn" onclick="automobile_load_more_ajax(\'' . $admin_url . '\');">' . automobile_var_plugin_text_srt('automobile_var_load_more') . '</a></div>';
                            echo '</nav>';
                        }//==Pagination End 
                        ?>
                        <?php
                    } else {
                        echo '<div class="cs-no-record">' . automobile_info_messages_listing(automobile_var_plugin_text_srt('automobile_var_no_record_inventory')) . '</div>';
                    }
                    ?>
                </div>
                </div>

                <script>
                    jQuery(document).ready(function () {
                        jQuery('[data-toggle="tooltip"]').tooltip();
                    });
                </script>
                <?php
                die();
            }
        }

        /**
         * End Function how to manage inventory in ajax funciton
         */

        /**
         * Start Function how to manage inventory in ajax funciton
         */
        public function automobile_ajax_manage_inventory_ajax() {
            global $post, $automobile_var_plugin_options, $automobile_var_plugin_static_text;
            $post_to_load = isset($_POST['post_to_load']) ? $_POST['post_to_load'] : '5';
            $inventory_load_status = isset($_POST['status_val']) ? $_POST['status_val'] : '';


            if (class_exists('automobile_dealer_functions')) {
                $automobile_emp_funs = new automobile_dealer_functions();
            }
            $uid = get_current_user_id();
            $automobile_uri = (isset($_POST['automobile_uri']) and $_POST['automobile_uri'] <> '') ? $_POST['automobile_uri'] : '';
            if ($uid != '') {
                ?>
                <div class="cs-manage-inventory">
                    <?php
                    $automobile_emp_dashboard = isset($automobile_var_plugin_options['automobile_emp_dashboard']) ? $automobile_var_plugin_options['automobile_emp_dashboard'] : '';
                    if ($automobile_emp_dashboard != '') {
                        $automobile_dealer_link = get_permalink($automobile_emp_dashboard);
                    } else {
                        $automobile_dealer_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    }
                    $automobile_blog_num_post = 5;
                    if (empty($_REQUEST['page_id_all']))
                        $_REQUEST['page_id_all'] = 1;
                    $mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'automobile_inventory_username',
                                'value' => $uid,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'delete',
                                'compare' => '!=',
                            ),
                        ),
                        'order' => "ASC");
                    $loop_count = new WP_Query($mypost);
                    $count_post = $loop_count->post_count;
                    $args = array(
                        'posts_per_page' => $automobile_blog_num_post,
                        'paged' => $post_to_load,
                        'post_type' => 'inventory',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'automobile_inventory_username',
                                'value' => $uid,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'automobile_inventory_status',
                                'value' => 'delete',
                                'compare' => '!=',
                            ),
                        ),
                        'orderby' => 'ID',
                        'order' => 'DESC',
                    );
                    $custom_query = new WP_Query($args);
                    if ($inventory_load_status != '') {
                        $automobile_blog_num_post = $automobile_blog_num_post * $post_to_load;
                        if (empty($_REQUEST['page_id_all']))
                            $_REQUEST['page_id_all'] = 1;
                        $mypost = array('posts_per_page' => "-1", 'post_type' => 'inventory',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'automobile_inventory_username',
                                    'value' => $uid,
                                    'compare' => '=',
                                ),
                                array(
                                    'key' => 'automobile_inventory_status',
                                    'value' => $inventory_load_status,
                                    'compare' => '==',
                                ),
                            ),
                            'order' => "ASC");
                        $loop_count = new WP_Query($mypost);
                        $count_post = $loop_count->post_count;
                        $args = array(
                            'posts_per_page' => $automobile_blog_num_post,
                            'paged' => $post_to_load,
                            'post_type' => 'inventory',
                            'post_status' => 'publish',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'automobile_inventory_username',
                                    'value' => $uid,
                                    'compare' => '=',
                                ),
                                array(
                                    'key' => 'automobile_inventory_status',
                                    'value' => $inventory_load_status,
                                    'compare' => '==',
                                ),
                            ),
                            'orderby' => 'ID',
                            'order' => 'DESC',
                        );
                        $custom_query = new WP_Query($args);
                    }
                    ?>

                    <?php
                    if ($custom_query->have_posts()) {

                        $get_uid = ( isset($_GET['uid']) && $_GET['uid'] <> '' ) ? '&amp;uid=' . $_GET['uid'] : '';
                        ?>

                        <div class="dashboard-content-holder">

                            <?php $this->automobile_loop_content($custom_query, $automobile_dealer_link, $get_uid); ?>

                        </div>
                        <?php
                        //==Pagination Start
                        if ($count_post > $automobile_blog_num_post && $automobile_blog_num_post > 0) {
                            echo '<nav>';

                            echo '</nav>';
                        }//==Pagination End 
                        ?>
                        <?php
                    } else {
                        echo '<div class="cs-no-record">' . automobile_info_messages_listing(automobile_var_plugin_text_srt('automobile_var_no_record_inventory')) . '</div>';
                    }
                    ?>
                </div>
                </div>

                <script>
                    jQuery(document).ready(function () {
                        jQuery('[data-toggle="tooltip"]').tooltip();
                    });
                </script>
                <?php
                die();
            }
        }

        /**
         * End Function how to manage inventory in ajax funciton
         */
        /*
         * function loop content
         */
        public function automobile_loop_content($custom_query = '', $automobile_dealer_link = '', $get_uid = '') {
            global $automobile_var_plugin_static_text;
            $automobile_var_featured = automobile_var_plugin_text_srt('automobile_var_featured');
            ?>
            <ul class = "cs-featurelisted-car">
                <?php
                while ($custom_query->have_posts()) : $custom_query->the_post();
                    global $post;
                    $inventory_title = $post->post_title;
                    $inventory_id = $post->ID;
                    $automobile_inventory_package = get_post_meta($inventory_id, "automobile_inventory_package", true);
                    $automobile_inventory_status = get_post_meta($inventory_id, "automobile_inventory_status", true);

                    $automobile_inventory_expired = get_post_meta($inventory_id, "automobile_inventory_expired", true);
                    $automobile_inventory_status = get_post_meta($inventory_id, "automobile_inventory_status", true);
                    $automobile_inventory_featured = get_post_meta($inventory_id, 'automobile_inventory_featured', true);
                    $automobile_count_views = get_post_meta($inventory_id, 'automobile_count_views', true);
                    if (isset($automobile_count_views) && $automobile_count_views == '') {
                        $automobile_count_views = 0;
                    }
                    $automobile_inventory_all_status = array('awaiting-activation' => automobile_var_plugin_text_srt('automobile_var_pending'), 'active' => automobile_var_plugin_text_srt('automobile_var_active'), 'inactive' => automobile_var_plugin_text_srt('automobile_var_inactive'), 'delete' => automobile_var_plugin_text_srt('automobile_var_delete'));
                    $automobile_shortlisted = count_usermeta('cs-user-inventory-wishlist', serialize(strval($inventory_id)), 'LIKE');
                    $automobile_url = $automobile_dealer_link . "?profile_tab=edit-user-car-listing&inventory_id=" . $inventory_id . $get_uid . "&action=edit";
                    $current_status = 'active';
                    $automobile_eye_class = 'icon-eye-slash';
                    $status_toot_tip_text = 'Active';
                    if ($automobile_inventory_status == 'active') {
                        $automobile_eye_class = 'icon-eye3';
                        $current_status = 'inactive';
                        $status_toot_tip_text = 'Inactive';
                    }
                    $inventory_status_link_allow = 1;
                    if ($automobile_inventory_status != 'active' && $automobile_inventory_status != 'inactive') // check staus diffrent 
                        $inventory_status_link_allow = 0;
                    if ($automobile_inventory_expired < time()) // check inventory expire
                        $inventory_status_link_allow = 0;
                    $automobile_apps = 0;
                    // Getting inventory application count
                    $automobile_applicants = count_usermeta('cs-user-inventory-applied-list', serialize(strval($inventory_id)), 'LIKE', true);
                    $automobile_apps += count($automobile_applicants);
                    ?>
                    <?php
                    $feature_image = get_post_meta($post->ID, 'automobile_inventory_gallery_url');
                    $feature_image = is_array($feature_image)? $feature_image : array();
                    //Re-arrange Array Indexing  
                    $feature_image[0] = !empty( $feature_image )? array_values($feature_image[0]) : '';
                    $automobile_image_url = isset($feature_image[0][0]) ? $feature_image[0][0] : '';
                    if (isset($automobile_image_url) && $automobile_image_url != '') {
                        $thumbnail_size_image = automobile_get_image_thumb($automobile_image_url, 'automobile_var_media_6');
                    } else {
                        $thumbnail_size_image = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found16x9.jpg');
                    }
                    ?>
                    <li id="cs-inventory-parent-<?php the_ID(); ?>">
                        <div class="cs-media">
                            <figure><a href="<?php the_permalink(); ?>"> <?php
                                    if (isset($thumbnail_size_image) && $thumbnail_size_image != '') {
                                        echo '<img  src="' . $thumbnail_size_image . '">';
                                    }
                                    ?>
                                </a>
                            </figure>
                        </div>
                        <div class="cs-text">
                            <?php
                            $automobile_var_featured = (get_post_meta(get_the_ID(), 'automobile_inventory_featured', true));
                            if ($automobile_var_featured == 'yes') {
                                ?>
                                <span class="cs-featured">Featured</span>
                            <?php } ?>

                            <h6><a href="<?php echo esc_url(get_permalink($inventory_id)); ?>"><?php ?><?php if (isset($inventory_title)) echo esc_html(wp_trim_words($inventory_title, 7, '...')); ?></a></h6>
                            <div class="post-options">
                                <?php
                                if ($automobile_inventory_expired != '') {
                                    ?>
                                    <span class="expire-date <?php if ($automobile_inventory_expired < time()) echo ' error-msg'; ?>"><?php echo automobile_var_plugin_text_srt('automobile_var_expire_date'); ?> <em><?php echo date_i18n(get_option('date_format'), $automobile_inventory_expired); ?></em></span>
                                    <?php
                                }
                                ?>
                                <span><?php echo automobile_var_plugin_text_srt('automobile_var_application'); ?> <?php echo $automobile_count_views; ?></span>
                            </div>

                            <div class="cs-post-types">
                                <div class="shortlist">
                                    <a href="<?php echo esc_url($automobile_dealer_link) ?>?inventory_id=<?php echo esc_html($inventory_id) ?>&profile_tab=applicants&action=applicants" data-toggle="tooltip" data-placement="top" title="<?php echo absint($automobile_apps) . " " . $automobile_var_application; ?>" >

                                    </a>
                                </div>


                                <div class="cs-post-list">

                                    <div class="cs-edit-post">
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo automobile_var_plugin_text_srt('automobile_var_edit_inventory'); ?>" href="<?php echo esc_url($automobile_url) ?>"><i class="icon-edit3"></i></a>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo automobile_var_plugin_text_srt('automobile_var_remove_inventory'); ?>" id="cs-inventory-<?php echo absint($inventory_id) ?>" onclick="automobile_inventory_delete('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($inventory_id) ?>')" data-toggle="tooltip" data-original-title="<?php echo esc_html($status_toot_tip_text); ?>" ><i class="icon-trash-o"></i></a>
                                        </a>
                                    </div>
                                    <div class="cs-list">
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo esc_html($status_toot_tip_text); ?>" id="automobile_invenotry_link<?php echo esc_html($inventory_id); ?>" href="javascript:void(0);" onclick="automobile_inventory_status_update('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo esc_html($inventory_id); ?>', '<?php echo esc_html($current_status); ?>')"><i class="<?php echo sanitize_html_class($automobile_eye_class) ?>"></i></a>
                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo automobile_var_plugin_text_srt('automobile_var_edit_inventory'); ?>" href="<?php echo esc_url($automobile_url) ?>"><i class="icon-edit3"></i></a>

                                        <a data-toggle="tooltip" data-placement="top" title="<?php echo automobile_var_plugin_text_srt('automobile_var_remove_inventory'); ?>" id="cs-inventory-<?php echo absint($inventory_id) ?>" onclick="automobile_inventory_delete('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', '<?php echo absint($inventory_id) ?>')" data-toggle="tooltip" data-original-title="<?php echo esc_html($status_toot_tip_text); ?>" ><i class="icon-trash-o"></i></a>
                                        </a>
                                    </div>

                                </div>
                                <span class="cs-default-btn <?php
                                if (isset($automobile_inventory_all_status[$automobile_inventory_status]))
                                    echo esc_html($automobile_inventory_all_status[$automobile_inventory_status]);
                                ?>"  id="automobile_inventory_status_html<?php echo esc_html($inventory_id); ?>" class="cs-default-btn"><?php
                                      if (isset($automobile_inventory_all_status[$automobile_inventory_status]))
                                          echo esc_html($automobile_inventory_all_status[$automobile_inventory_status]);
                                      else
                                          echo automobile_var_plugin_text_srt('automobile_var_awaiting');
                                      ?></span>
                            </div>
                    </li>
                    <?php
                endwhile;
                ?>
            </ul>
            <?php
        }

        /**
         * Start Function Transaction in Ajax function
         */
        public function automobile_ajax_trans_history() {
            $stringObj = new automobile_plugin_all_strings();
            $stringObj->automobile_var_plugin_option_strings();
            global $post, $automobile_var_plugin_options, $gateways, $automobile_var_plugin_static_text;
            $automobile_var_date_expire = automobile_var_plugin_text_srt('automobile_var_date_expire');

            $general_settings = new AUTOMOBILE_PAYMENTS();
            $currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';
            $automobile_emp_funs = new automobile_dealer_functions();
            $uid = (isset($_POST['automobile_uid']) and $_POST['automobile_uid'] <> '') ? $_POST['automobile_uid'] : '';
            if ($uid != '') {
                $args = array(
                    'posts_per_page' => "-1",
                    'post_type' => 'cs-transactions',
                    'post_status' => 'publish',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'automobile_transaction_user',
                            'value' => $uid,
                            'compare' => '=',
                        ),
                    ),
                    'orderby' => 'ID',
                    'order' => 'DESC',
                );
                $custom_query = new WP_Query($args);
                ?>
                <div class="cs-transection">
                    <div class="scetion-title">
                        <h4><?php echo automobile_var_plugin_text_srt('automobile_var_transactions'); ?></h4>
                    </div>
                    <?php
                    if ($custom_query->have_posts()) {
                        ?>
                        <div class="payment-list">
                            <ul>
                                <li>
                                    <div class="payment-label">
                                        <ul>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_packege'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_trans_id'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_date'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_payment'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_amount'); ?></li>
                                        </ul>
                                    </div>
                                </li>
                                <?php
                                while ($custom_query->have_posts()) : $custom_query->the_post();
                                    ?>
                                    <li>
                                        <div class="payment-content">
                                            <ul>
                                                <?php
                                                $automobile_trans_id = get_post_meta(get_the_id(), "automobile_transaction_id", true);
                                                //print_r(get_post_meta(get_the_id()));
                                                $automobile_trans_gate = get_post_meta(get_the_id(), "automobile_payment_gateway", true);
                                                $automobile_pay_logo = '';
                                                if ($automobile_trans_gate == 'AUTOMOBILE_PAYPAL_GATEWAY') {
                                                    $automobile_pay_logo = '<img src="' . automobile_var::plugin_url() . 'payments/images/paypal.png">';
                                                }
                                                if ($automobile_trans_gate == 'AUTOMOBILE_SKRILL_GATEWAY') {
                                                    $automobile_pay_logo = '<img src="' . automobile_var::plugin_url() . 'payments/images/skrill.png">';
                                                }
                                                if ($automobile_trans_gate == 'automobile_athorizedotnet_GATEWAY') {
                                                    $automobile_pay_logo = '<img src="' . automobile_var::plugin_url() . 'payments/images/athorizedotnet.png">';
                                                }
                                                if ($automobile_trans_gate == 'AUTOMOBILE_BANK_GATEWAY') {
                                                    $automobile_pay_logo = '<img src="' . automobile_var::plugin_url() . 'payments/images/bank.png">';
                                                }
                                                $automobile_trans_amount = get_post_meta(get_the_id(), "automobile_transaction_amount", true);
                                                $automobile_trans_status = get_post_meta(get_the_id(), "automobile_transaction_status", true);

                                                $automobile_trans_status = $automobile_trans_status == '' ? 'pending' : $automobile_trans_status;
                                                $automobile_trans_type = get_post_meta(get_the_id(), "automobile_transaction_type", true);

                                                $automobile_trans_pkg = get_post_meta(get_the_id(), "automobile_transaction_package", true);
                                                $automobile_trans_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);
                                                if ($automobile_trans_pkg_title != '') {
                                                    $automobile_trans_pkg_title = automobile_var_plugin_text_srt('automobile_var_advertise_inventory') . ' - ' . $automobile_trans_pkg_title;
                                                }

                                                if ($automobile_trans_pkg_title == '') {
                                                    $automobile_trans_pkg_title = automobile_var_plugin_text_srt('automobile_var_featured_inventory');
                                                }

                                                $automobile_trans_gate = isset($gateways[strtoupper($automobile_trans_gate)]) ? $gateways[strtoupper($automobile_trans_gate)] : '-';
                                                ?>
                                                <li class="trans-description"><span>&nbsp; <b><?php echo esc_attr($automobile_trans_pkg_title) ?></b><em class="<?php echo 'payment-package-' . $automobile_trans_status; ?>">&nbsp;<?php echo esc_attr(ucfirst($automobile_trans_status)) ?></em></span></li>	
                                                <li class="trans-id"><span>&nbsp;<?php echo esc_attr($automobile_trans_id) ?></span></li>
                                                <li class="trans-date"><span>&nbsp;<?php echo date_i18n(get_option('date_format'), strtotime(get_the_date())) ?></span></li>
                                                <li class="trans-payment"><span>&nbsp;<?php echo $automobile_pay_logo; ?></span></li>
                                                <li class="trans-amount"><span class="amount csborder-color">&nbsp;<?php echo esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_trans_amount) ?></span></li>

                                            </ul>
                                        </div>
                                    </li>   
                                    <?php
                                endwhile;
                                ?>

                        </div>
                    </ul>


                    <?php
                } else {
                    echo '<div class="cs-no-record">' . automobile_info_messages_listing(automobile_var_plugin_text_srt('automobile_var_no_record_transections')) . '</div>';
                }
                ?></div><?php
                die();
            }
        }

        /**
         * End Function Transaction in Ajax function
         */

        /**
         * Start Function Create Resumes  in Ajax function
         */
        public function automobile_ajax_shortlisted_vehicles() {

            global $post, $automobile_form_fields2, $automobile_var_plugin_static_text;

            $uid = (isset($_POST['automobile_uid']) and $_POST['automobile_uid'] <> '') ? $_POST['automobile_uid'] : '';
            if ($uid <> '') {
                ?>
                <section class="cs-favorite-inventories">
                    <?php
                    $user = get_current_user_id();
                    if (isset($user) && $user <> '') {
                        $automobile_shortlist_array = get_user_meta($user, 'cs-user-inventory-wishlist', true);
                        if (!empty($automobile_shortlist_array))
                            $automobile_shortlist = array_column_by_two_dimensional($automobile_shortlist_array, 'post_id');
                        else
                            $automobile_shortlist = array();
                    }
                    ?>
                    <div class="scetion-title">
                        <h5><?php echo automobile_var_plugin_text_srt('automobile_var_shortlisted_vehicles'); ?></h5>
                    </div>
                    <?php
                    if (!empty($automobile_shortlist) && count($automobile_shortlist) > 0) {

                        $automobile_blog_num_post = 10;
                        if (empty($_REQUEST['page_id_all']))
                            $_REQUEST['page_id_all'] = 1;
                        $mypost = array('posts_per_page' => "-1", 'post__in' => $automobile_shortlist, 'post_type' => 'inventory', 'order' => "ASC");
                        $loop_count = new WP_Query($mypost);
                        $count_post = $loop_count->post_count;
                        $args = array('posts_per_page' => $automobile_blog_num_post, 'post_type' => 'inventory', 'paged' => $_REQUEST['page_id_all'], 'order' => 'DESC', 'orderby' => 'post_date', 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'post__in' => $automobile_shortlist);
                        $custom_query = new WP_Query($args);
                        if ($custom_query->have_posts()):
                            ?>
                            <ul class="cs-shortlisted-car">
                                <?php
                                while ($custom_query->have_posts()): $custom_query->the_post();
                                    $automobile_old_price = get_post_meta($post->ID, 'automobile_inventory_old_price', true);
                                    $automobile_new_price = get_post_meta($post->ID, 'automobile_inventory_new_price', true);
                                    $automobile_inventories_thumb_url = '';
                                    $employer_img = '';
                                    // get employer images at run time


                                    $feature_image = get_post_meta($post->ID, 'automobile_inventory_gallery_url');
                                    $automobile_image_url = isset($feature_image[0][0]) ? $feature_image[0][0] : '';
                                    $thumbnail_size_image = automobile_get_image_thumb($automobile_image_url, 'automobile_var_media_6');

                                    if (!automobile_image_exist($thumbnail_size_image) || $thumbnail_size_image == "") {
                                        $thumbnail_size_image = esc_url(automobile_var::plugin_url() . 'assets/frontend/images/img-not-found16x9.jpg');
                                    }
                                    ?>
                                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12 holder-<?php echo intval($post->ID); ?>">
                                        <?php
                                        ?>

                                        <div class="cs-media">
                                            <figure><a href="<?php the_permalink(); ?>"> <?php
                                                    echo '<img src="' . $thumbnail_size_image . '">';
                                                    ?></a>
                                            </figure>
                                        </div>
                                        <div class="cs-text">
                                            <address><i class=" icon-map2"></i><?php echo get_post_meta(get_the_ID(), 'automobile_post_loc_address', true); ?></address>
                                            <h6><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h6>
                                            <?php echo automobile_inventory_listing_price($automobile_new_price, $automobile_old_price, 'cs-price'); ?>

                                            <a class="cs-remove-btn cs-bgcolor" title="" data-placement="top" data-toggle="tooltip" href="javascript:void(0);" data-original-title="Remove" onclick="javascript:automobile_var_removeinventory_to('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', '<?php echo absint($post->ID); ?>', this, '.holder-<?php echo absint($post->ID); ?>')" data-postid="<?php echo intval($post->ID); ?>">Remove</a>
                                        </div>
                                    </li> <?php
                                endwhile;
                                ?>
                            </ul>
                            <?php
                        //==Pagination Start

                        endif;
                        ?>

                        <?php
                    } else {
                        echo '<div class="cs-no-record">' . automobile_info_messages_listing(automobile_var_plugin_text_srt('automobile_var_no_shortlisted')) . '</div>';
                    }
                    ?>
                </section>  		
                <?php
            } else {
                echo '<div class="no-result"><h1>' . automobile_var_plugin_text_srt('automobile_var_create_profile') . '</h1></div>';
            }
            ?>
            <script>
                jQuery(document).ready(function () {
                    jQuery('[data-toggle="tooltip"]').tooltip();
                });
            </script>
            <?php
            die();
        }

        /**
         * End Function Create Resumes  in Ajax function
         */

        /**
         * Start Function Creating inventory Packages in Ajax Function
         */
        public function automobile_ajax_inventory_packages() {
            $stringObj = new automobile_plugin_all_strings();
            $stringObj->automobile_var_plugin_option_strings();
            global $automobile_var_plugin_options, $current_user, $automobile_form_fields, $automobile_var_plugin_static_text;
            $general_settings = new AUTOMOBILE_PAYMENTS();
            if (isset($_POST['pkg_array'])) {
                $post_array = stripslashes($_POST['pkg_array']);
                $post_array = json_decode($post_array, true);
                if (is_array($post_array) && sizeof($post_array) > 0) {
                    if (isset($post_array['post_array'])) {
                        $post_array = $post_array['post_array'];
                        $_POST = array_merge($_POST, $post_array);
                    }
                }
            }
            $automobile_emp_funs = new automobile_dealer_functions();
            $automobile_vat_switch = isset($automobile_var_plugin_options['automobile_vat_switch']) ? $automobile_var_plugin_options['automobile_vat_switch'] : '';
            $automobile_pay_vat = isset($automobile_var_plugin_options['automobile_payment_vat']) ? $automobile_var_plugin_options['automobile_payment_vat'] : '0';
            $currency_sign = isset($automobile_var_plugin_options['automobile_currency_sign']) ? $automobile_var_plugin_options['automobile_currency_sign'] : '$';
            $automobile_feature_amount = isset($automobile_var_plugin_options['automobile_inventory_feat_price']) ? $automobile_var_plugin_options['automobile_inventory_feat_price'] : '';
            $automobile_packages_options = isset($automobile_var_plugin_options['automobile_packages_options']) ? $automobile_var_plugin_options['automobile_packages_options'] : '';

            if (isset($_POST['automobile_package']) && $_POST['automobile_package'] != '') {
                if (!$automobile_emp_funs->automobile_is_pkg_subscribed($_POST['automobile_package'])) {
                    $automobile_package = $_POST['automobile_package'];
                    $automobile_html = '';
                    $automobile_total_amount = 0;
                    $automobile_total_amount += AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_emp_funs->get_pkg_field($_POST['automobile_package'], 'package_price'));
                    $automobile_smry_totl = $automobile_total_amount;
                    if ($automobile_vat_switch == 'on' && $automobile_pay_vat > 0) {
                        $automobile_vat_amount = $automobile_total_amount * ( $automobile_pay_vat / 100 );
                        $automobile_total_amount = AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_vat_amount) + $automobile_total_amount;
                    }

                    if ($automobile_total_amount <= 0) {
                        // Adding Free Package
                        $automobile_trans_pkg = isset($_POST['automobile_package']) ? $_POST['automobile_package'] : '';
                        $automobile_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);
                        $automobile_pkg_expiry = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration');
                        $automobile_pkg_duration = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration_period');
                        $automobile_pkg_expir_days = strtotime($automobile_emp_funs->automobile_date_conv($automobile_pkg_expiry, $automobile_pkg_duration));
                        $automobile_pkg_list_num = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_listings');
                        $automobile_pkg_list_exp = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_submission_limit');
                        $automobile_pkg_list_per = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'automobile_list_dur');
                        $automobile_trans_fields = array(
                            'automobile_inventory_id' => isset($_POST['automobile_package']) ? $_POST['automobile_package'] : '',
                            'automobile_trans_id' => rand(149344111, 991435901),
                            'automobile_trans_user' => $current_user->ID,
                            'automobile_package_title' => $automobile_pkg_title,
                            'automobile_trans_package' => isset($_POST['automobile_package']) ? $_POST['automobile_package'] : '',
                            'automobile_trans_amount' => 0,
                            'automobile_trans_pkg_expiry' => $automobile_pkg_expir_days,
                            'automobile_trans_list_num' => $automobile_pkg_list_num,
                            'automobile_trans_list_expiry' => $automobile_pkg_list_exp,
                            'automobile_trans_list_period' => $automobile_pkg_list_per,
                        );
                        $automobile_emp_funs->automobile_pay_process($automobile_trans_fields);
                        $automobile_html .= automobile_var_plugin_text_srt('automobile_var_successfully_subscribed');
                        //echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_html);
                    }

                    if (isset($_POST['automobile_pkge_trans']) && $_POST['automobile_pkge_trans'] == "1") {
                        if ($automobile_total_amount > 0) {
                            $automobile_trans_pkg = isset($_POST['automobile_package']) ? $_POST['automobile_package'] : '';
                            $automobile_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);
                            $automobile_pkg_expiry = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration');
                            $automobile_pkg_duration = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_duration_period');
                            $automobile_pkg_expir_days = strtotime($automobile_emp_funs->automobile_date_conv($automobile_pkg_expiry, $automobile_pkg_duration));
                            $automobile_pkg_list_num = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_listings');
                            $automobile_pkg_list_exp = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'package_submission_limit');
                            $automobile_pkg_list_per = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg, 'automobile_list_dur');
                            $automobile_trans_fields = array(
                                'automobile_inventory_id' => isset($_POST['automobile_package']) ? $_POST['automobile_package'] : '',
                                'automobile_trans_id' => rand(149344111, 991435901),
                                'automobile_trans_user' => $current_user->ID,
                                'automobile_package_title' => $automobile_pkg_title,
                                'automobile_trans_package' => isset($_POST['automobile_package']) ? $_POST['automobile_package'] : '',
                                'automobile_trans_amount' => $automobile_total_amount,
                                'automobile_trans_pkg_expiry' => $automobile_pkg_expir_days,
                                'automobile_trans_list_num' => $automobile_pkg_list_num,
                                'automobile_trans_list_expiry' => $automobile_pkg_list_exp,
                                'automobile_trans_list_period' => $automobile_pkg_list_per,
                            );
                            $automobile_trnas_html = $automobile_emp_funs->automobile_pay_process($automobile_trans_fields);
                        }
                    }
                    if (isset($automobile_trnas_html) && $automobile_trnas_html != '') {
                        $automobile_html .= $automobile_trnas_html;
                    } else {
                        if ($automobile_total_amount > 0) {
                            $automobile_html .= '
										<form method="post" id="cs-emp-pkgs" data-ajaxurl="' . esc_url(admin_url('admin-ajax.php')) . '">
											<div class="cs-order-summery">
												<h4>' . automobile_var_plugin_text_srt('automobile_var_order_summery') . '</h4>
												<ul class="cs-sumry-clacs">
														<li><span>' . esc_attr($automobile_emp_funs->get_pkg_field($_POST['automobile_package'])) . ' ' . automobile_var_plugin_text_srt('automobile_var_subscription') . '</span><em>' . esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_emp_funs->get_pkg_field($_POST['automobile_package'], 'package_price')) . '</em></li>';
                            if ($automobile_vat_switch == 'on' && isset($automobile_vat_amount)) {
                                $automobile_html .= '
											<li><span>' . sprintf(__('VAT (%s&#37;)', 'automobile'), $automobile_pay_vat) . '</span><em>' . esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_vat_amount) . '</em></li>';
                            }

                            $automobile_html .= '
										<li><span>' . automobile_var_plugin_text_srt('automobile_var_total') . '</span><em>' . esc_attr($currency_sign) . AUTOMOBILE_FUNCTIONS()->automobile_num_format($automobile_total_amount) . '</em></li>
										</ul>
											</div>
	
											<div class="cs-package-payment contact-box cs-pay-box cs-packages-gateways" style="display:block;">
												<ul class="select-card cs-all-gates"><li>';
                            global $gateways;
                            $automobile_gateway_options = get_option('automobile_var_plugin_options');
                            $automobile_gw_counter = 1;
                            $automobile_gatway_enable_flag = 0;
                            if (isset($gateways) && is_array($gateways)) {
                                foreach ($gateways as $key => $value) {
                                    $status = $automobile_gateway_options[strtolower($key) . '_status'];
                                    if (isset($status) && $status == 'on') {
                                        $logo = '';
                                        if (isset($automobile_gateway_options[strtolower($key) . '_logo'])) {
                                            $logo = $automobile_gateway_options[strtolower($key) . '_logo'];
                                        }
                                        if (isset($logo) && $logo != '') {
                                            $automobile_checked = $automobile_gw_counter == 1 ? ' checked="checked"' : '';
                                            $automobile_active = $automobile_gw_counter == 1 ? ' active' : '';
                                            $automobile_html .= '
													<div class="radiobox' . $automobile_active . '">';

                                            $automobile_opt_array = array(
                                                'std' => $key,
                                                'id' => '',
                                                'cust_type' => 'radio',
                                                'extra_atr' => ' style="display:none; position:absolute;" ' . AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_checked),
                                                'return' => true,
                                                'cust_name' => 'automobile_payment_gateway',
                                            );
                                            $automobile_html .= '' . $automobile_form_fields->automobile_form_text_render($automobile_opt_array) . '';
                                            $automobile_html .= '<label><img alt="" src="' . esc_url($logo) . '"></label> </div>';
                                            $automobile_gatway_enable_flag++;   // if any gatway enable then set flag
                                        }
                                        $automobile_gw_counter++;
                                    }
                                }
                            }
                            $automobile_html .= '</li></ul>';
                            $automobile_html .= '<div class="cs-field"><div class="cs-btn-submit">';
                            if ($automobile_gatway_enable_flag > 0) {
                                $automobile_opt_array = array(
                                    'std' => absint($automobile_package),
                                    'id' => '',
                                    'cust_name' => 'automobile_package',
                                    'return' => true,
                                );
                                $automobile_html .= $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'std' => '1',
                                    'id' => '',
                                    'cust_name' => 'automobile_pkge_trans',
                                    'return' => true,
                                );

                                $automobile_html .= $automobile_form_fields->automobile_form_hidden_render($automobile_opt_array);

                                $automobile_opt_array = array(
                                    'std' => automobile_var_plugin_text_srt('automobile_var_pay_now'),
                                    'id' => '',
                                    'cust_type' => 'submit',
                                    'classes' => 'continue-btn',
                                    'return' => true,
                                );

                                $automobile_html .= $automobile_form_fields->automobile_form_text_render($automobile_opt_array);
                            }
                            $automobile_html .= '</div></div></div> </form>';
                        }
                    }
                    echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_html);
                } else {
                    echo '<div class="cs-no-record">' . automobile_info_messages_listing(automobile_var_plugin_text_srt('automobile_var_subscribe_package')) . '</div>';
                }
            }
            ?>
            <div class="cs-packages">
                <?php
                $automobile_results = false;
                if (is_array($automobile_packages_options) && sizeof($automobile_packages_options) > 0) {
                    $args = array(
                        'posts_per_page' => "-1",
                        'post_type' => 'cs-transactions',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'automobile_uid',
                                'value' => $current_user->ID,
                                'compare' => '=',
                            ),
                            array(
                                array(
                                    'key' => 'automobile_transaction_package',
                                    'value' => '',
                                    'compare' => '!=',
                                ),
                            ),
                        ),
                    );
                    $custom_query = new WP_Query($args);
                    $automobile_trans_count = $custom_query->post_count;
                    ?>
                    <div class="scetion-title">
                        <h4><?php echo automobile_var_plugin_text_srt('automobile_var_packages'); ?></h4>
                    </div>
                    <?php
                    if ($automobile_trans_count > 0) {
                        ?>
                        <div class="packages-list">
                            <ul>
                                <li>
                                    <div class="packages-label">
                                        <ul>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_packege'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_trans_id'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_date_expire'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_total_ads'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_used'); ?></li>
                                            <li><?php echo automobile_var_plugin_text_srt('automobile_var_remaning'); ?></li>
                                        </ul>
                                    </div>
                                </li>



                                <?php
                                $automobile_trans_num = 1;

                                $automobile_expire_trans = $automobile_emp_funs->automobile_expire_pkgs_id();

                                while ($custom_query->have_posts()) : $custom_query->the_post();

                                    $automobile_trans_id = get_post_meta(get_the_id(), "automobile_transaction_id", true);
                                    //print_r(get_post_meta(get_the_id()));
                                    $automobile_trans_expiry = get_post_meta(get_the_id(), "automobile_transaction_expiry_date", true);
                                    $automobile_trans_type = get_post_meta(get_the_id(), "automobile_transaction_type", true);
                                    $automobile_trans_lists = get_post_meta(get_the_id(), "automobile_transaction_listings", true);
                                    $automobile_trans_status = get_post_meta(get_the_id(), "automobile_transaction_status", true);
                                    $automobile_tr_post_id = get_the_id();
                                    $automobile_trans_status = $automobile_trans_status != '' ? $automobile_trans_status : 'pending';
                                    $automobile_trans_status = $automobile_trans_status == 'approved' ? 'active' : $automobile_trans_status;
                                    $automobile_trans_lists = $automobile_trans_lists != '' && $automobile_trans_lists > 0 ? $automobile_trans_lists : 0;
                                    if ($automobile_trans_expiry != '') {

                                        $automobile_trans_expiry = date_i18n(get_option('date_format'), $automobile_trans_expiry);
                                    }

                                    $automobile_trans_pkg = get_post_meta($automobile_tr_post_id, "automobile_transaction_package", true);
                                    $automobile_trans_pkg_title = $automobile_emp_funs->get_pkg_field($automobile_trans_pkg);

                                    if ($automobile_trans_type != 'cv_trans') {

                                        if ($automobile_emp_funs->automobile_is_pkg_subscribed($automobile_trans_pkg) && $automobile_emp_funs->automobile_is_pkg_subscribed($automobile_trans_pkg, true) == $automobile_trans_id) {
                                            $automobile_pkg = $automobile_emp_funs->automobile_update_pkg_subs(true, $automobile_trans_pkg);
                                            if (AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_emp_funs->automobile_user_pkg_detail($automobile_pkg, '', true)) != '') {
                                                echo '<li>
												<div class="packages-label">
													<ul>';
                                                //echo '<td>' . absint($automobile_trans_num) . '</td>';
                                                echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_emp_funs->automobile_user_pkg_detail($automobile_pkg, '', true));
                                                echo '</ul>
												</div>
											</li>';
                                                $automobile_trans_num++;
                                            }
                                        } else if (is_array($automobile_expire_trans) && in_array($automobile_tr_post_id, $automobile_expire_trans)) {
                                            echo '<li>
												<div class="packages-label">
													<ul>';

                                            echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_emp_funs->automobile_expire_pkgs($automobile_tr_post_id));
                                            echo '</ul>
												</div>
											</li>';
                                            $automobile_trans_num++;
                                        } else if ($automobile_trans_pkg_title != '') {
                                            ?>
                                            <li>
                                                <div class="packages-label">
                                                    <ul>
                                                        <li><b><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_trans_pkg_title) ?></b> &nbsp; <em class="<?php echo 'payment-package-' . $automobile_trans_status; ?>"><?php echo ucfirst($automobile_trans_status) ?></em></li>
                                                        <li>#<?php echo absint($automobile_trans_id) ?></li>

                                                        <li><?php echo AUTOMOBILE_FUNCTIONS()->automobile_special_chars($automobile_trans_expiry) ?></li>
                                                        <li><?php echo absint($automobile_trans_lists) ?></li>
                                                        <li>-</li>
                                                        <li>-</li>

                                                    </ul>
                                                </div>
                                            </li>
                                            <?php
                                            $automobile_trans_num++;
                                        }
                                    }
                                    ?>


                                    <?php
                                endwhile;
                                ?>
                            </ul>
                        </div>
                        <?php
                    } else {
                        echo '<div class="cs-no-record">' . automobile_info_messages_listing(automobile_var_plugin_text_srt('automobile_var_no_package_list')) . '</div>';
                    }
                }
                ?>
            </div>
            <?php
            die();
        }

        /**
         * End Function Creating inventory Packages in Ajax Function
         */
        //cs-msgbox-1720
    }

    $automobile_emp_ajax_temps = new automobile_dealer_ajax_templates();
}