<?php
/**
 * Register Post Type Inventory Type
 * @return
 *
 */
if (!class_exists('automobile_post_inventory_types')) {

    class automobile_post_inventory_types {

        // The Constructor
        public function __construct() {
            add_action('init', array($this, 'inventory_type_register'));
            add_action('admin_menu', array($this, 'automobile_remove_post_boxes'));
        }

        /**
         * @Register Post Type
         * @return
         *
         */
        function inventory_type_register() {
            
            global $automobile_var_plugin_static_text;
            
            $labels = array(
                'name' => automobile_var_plugin_text_srt('automobile_var_inventory_types_post'),
                'singular_name' => automobile_var_plugin_text_srt('automobile_var_inventory_type_post'),
                'menu_name' => automobile_var_plugin_text_srt('automobile_var_inventory_types_admin'),
                'name_admin_bar' => automobile_var_plugin_text_srt('automobile_var_inventory_type_add'),
                'add_new' => automobile_var_plugin_text_srt('automobile_var_add_new_inventory'),
                'add_new_item' => automobile_var_plugin_text_srt('automobile_var_add_new_inventory_type'),
                'new_item' => automobile_var_plugin_text_srt('automobile_var_new_inventory_type'),
                'edit_item' => automobile_var_plugin_text_srt('automobile_var_edit_inventory_type'),
                'view_item' => automobile_var_plugin_text_srt('automobile_var_view_inventory_type'),
                'all_items' => automobile_var_plugin_text_srt('automobile_var_inventory_types'),
                'search_items' => automobile_var_plugin_text_srt('automobile_var_search_inventory_types'),
                'parent_item_colon' => automobile_var_plugin_text_srt('automobile_var_parent_inventory_types'),
                'not_found' => automobile_var_plugin_text_srt('automobile_var_no_inventory_type_found'),
                'not_found_in_trash' => automobile_var_plugin_text_srt('automobile_var_inventory_type_not_found_in_trash')
            );

            $args = array(
                'labels' => $labels,
                'description' => automobile_var_plugin_text_srt('automobile_var_description'),
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => 'edit.php?post_type=inventory',
                'query_var' => false,
                'rewrite' => array('slug' => 'inventory-type'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => array('title'),
				'exclude_from_search' => true
            );

            register_post_type('inventory-type', $args);
        }

        function automobile_submit_meta_box($post, $args = array()) {
            global $action, $post, $automobile_var_plugin_static_text;


            $post_type = $post->post_type;
            $post_type_object = get_post_type_object($post_type);
            $can_publish = current_user_can($post_type_object->cap->publish_posts);
            ?>
            <div class="submitbox directory-submit" id="submitpost">
                <div id="minor-publishing">
                    <div style="display:none;">
                        <?php submit_button(automobile_var_plugin_text_srt('automobile_var_save'), 'button', 'save'); ?>
                    </div>

                    <div id="minor-publishing-actions">

                        <?php if ($post_type_object->public) : ?>
                            <div id="preview-action">
                                <?php
                                if ('publish' == $post->post_status) {
                                    $preview_link = esc_url(get_permalink($post->ID));
                                    $preview_button = automobile_var_plugin_text_srt('automobile_var_preview_changes');
                                } else {
                                    $preview_link = set_url_scheme(get_permalink($post->ID));

                                    /**
                                     * Filter the URI of a post preview in the post submit box.
                                     *
                                     * @since 2.0.5
                                     * @since 4.0.0 $post parameter was added.
                                     *
                                     * @param string  $preview_link URI the user will be directed to for a post preview.
                                     * @param WP_Post $post         Post object.
                                     */
                                    $preview_link = esc_url(apply_filters('preview_post_link', add_query_arg('preview', 'true', esc_url($preview_link)), urlencode($post)));
                                    $preview_button = automobile_var_plugin_text_srt('automobile_var_preview');
                                }
                                ?>
                            </div>
                        <?php endif; // public post type      ?>
                        <div class="clear"></div>
                    </div><!-- #minor-publishing-actions -->
                </div>
                <div id="major-publishing-actions" style="border-top:0px">
                    <?php
                    /**
                     * Fires at the beginning of the publishing actions section of the Publish meta box.
                     *
                     * @since 2.7.0
                     */
                    do_action('post_submitbox_start');
                    ?>
                    <div id="delete-action">
                        <?php
                        if (current_user_can("delete_post", $post->ID)) {
                            if (!EMPTY_TRASH_DAYS) {
                                $delete_text = automobile_var_plugin_text_srt('automobile_var_delete_permanently');
                            } else {
                                $delete_text = automobile_var_plugin_text_srt('automobile_var_move_to_trash');
                            }
                            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                ?>
                                <a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo automobile_allow_special_char($delete_text) ?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <div id="publishing-action">
                        <span class="spinner"></span>
                        <?php
                        if (!in_array($post->post_status, array('publish', 'future', 'private')) || 0 == $post->ID) {
                            if ($can_publish) :

                                if (!empty($post->post_date_gmt) && time() < strtotime($post->post_date_gmt . ' +0000')) :
                                    ?>
                                    <input name="original_publish" type="hidden" id="original_publish" value="<?php echo esc_html('automobile_var_schedule'); ?>" />
                                    <?php submit_button(esc_html('automobile_var_schedule'), 'primary button-large', 'publish', false, array('accesskey' => 'p')); ?>
                                <?php else : ?>
                                    <input name="original_publish" type="hidden" id="original_publish" value="<?php echo automobile_var_plugin_text_srt('automobile_var_publish'); ?>" />
                                    <?php submit_button(automobile_var_plugin_text_srt('automobile_var_publish'), 'primary button-large', 'publish', false, array('accesskey' => 'p')); ?>
                                <?php
                                endif;
                            else :
                                ?>
                                <input name="original_publish" type="hidden" id="original_publish" value="<?php echo automobile_var_plugin_text_srt('automobile_var_submit_for_review'); ?>" />
                                <?php submit_button(automobile_var_plugin_text_srt('automobile_var_submit_for_review'), 'primary button-large', 'publish', false, array('accesskey' => 'p')); ?>
                            <?php
                            endif;
                        } else {

                            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                ?>
                                <input name="original_publish" type="hidden" id="original_publish" value="<?php echo automobile_var_plugin_text_srt('automobile_var_update'); ?>" />
                                <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php echo automobile_var_plugin_text_srt('automobile_var_update'); ?>" />
                                <?php
                            } else {
                                ?>
                                <input name="original_publish" type="hidden" id="original_publish" value="<?php echo automobile_var_plugin_text_srt('automobile_var_publish'); ?>">
                                <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php echo automobile_var_plugin_text_srt('automobile_var_publish'); ?>" accesskey="p">
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <?php
        }

        function automobile_remove_post_boxes() {
            remove_meta_box('submitdiv', 'inventory-type', 'side');
            remove_meta_box('slugdiv', 'inventory-type', 'side');
            remove_meta_box('mymetabox_revslider_0', 'inventory-type', 'normal');
        }

    }

    global $automobile_post_inventory_types;

    $automobile_post_inventory_types = new automobile_post_inventory_types();
}