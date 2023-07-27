<?php
/**
 * @Add Page Meta Boxe
 * @return
 */
add_action('add_meta_boxes', 'automobile_page_options_add');

if (!function_exists('automobile_page_options_add')) {

    function automobile_page_options_add() {
        global $automobile_var_frame_static_text;
        add_meta_box('id_page_options', automobile_var_frame_text_srt('automobile_var_page_option'), 'automobile_page_options', 'page', 'normal', 'low');
    }

}

/**
 * @Getting Page Options Layout
 *
 */
if (!function_exists('automobile_page_options')) {

    function automobile_page_options($post) {
        global $post, $automobile_var_frame_static_text;
        ?>

        <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <div class="elementhidden">
                        <nav class="admin-navigtion">
                            <ul id="cs-options-tab">
                                <li><a name="#tab-general-settings" href="javascript:;"><i class="icon-gear"></i><?php echo automobile_var_frame_text_srt('automobile_var_general_setting'); ?> </a></li>
                                <li><a name="#tab-slideshow" href="javascript:;"><i class="icon-forward2"></i> <?php echo automobile_var_frame_text_srt('automobile_var_subheader'); ?></a></li>
                            </ul>
                        </nav>
                        <div id="tabbed-content">
                            <div id="tab-general-settings">
                                <?php automobile_sidebar_layout_options(); ?>
                            </div>
                            <div id="tab-slideshow">
                                <?php automobile_subheader_element(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}