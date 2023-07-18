<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
$automobile_var_options = AUTOMOBILE_VAR_GLOBALS()->theme_options();
$the_global_vars = array('automobile_var_frame_options');
$automobile_var_frame_options_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($the_global_vars);
extract($automobile_var_frame_options_vars);
$automobile_var_footer_switch = isset($automobile_var_options['automobile_var_footer_switch']) ? $automobile_var_options['automobile_var_footer_switch'] : '';
$automobile_var_footer_widget = isset($automobile_var_options['automobile_var_footer_widget']) ? $automobile_var_options['automobile_var_footer_widget'] : '';
$automobile_var_copy_write_section = isset($automobile_var_options['automobile_var_copy_write_section']) ? $automobile_var_options['automobile_var_copy_write_section'] : '';
$automobile_var_copy_right = isset($automobile_var_options['automobile_var_copy_right']) ? $automobile_var_options['automobile_var_copy_right'] : '';
$automobile_var_footer_contact_no = isset($automobile_var_options['automobile_var_footer_contact_no']) ? $automobile_var_options['automobile_var_footer_contact_no'] : '';
$automobile_var_back_to_top = isset($automobile_var_options['automobile_var_back_to_top']) ? $automobile_var_options['automobile_var_back_to_top'] : '';
?>

<!-- Footer Start -->
<?php

//print_r($automobile_var_frame_options);

if ((isset($automobile_var_footer_switch) && $automobile_var_footer_switch == 'on')) {

    if (isset($automobile_var_frame_options['automobile_var_maintinance_mode_page']) && $automobile_var_frame_options['automobile_var_maintinance_mode_page'] == get_the_id() && isset($automobile_var_frame_options['automobile_var_footer_setting']) && $automobile_var_frame_options['automobile_var_footer_setting'] != 'on') {
        echo '<div class="cs-nofooter"></div>';
    } else {
        ?>
        <footer id="footer">
            <?php
            if ($automobile_var_footer_widget == 'on') {

                $footer_sidebar_list = array();
                $automobile_footer_sidebar_width = '';

                if (isset($automobile_var_options) and isset($automobile_var_options['automobile_var_footer_sidebar'])) {
                    if (is_array($automobile_var_options['automobile_var_footer_sidebar']) and count($automobile_var_options['automobile_var_footer_sidebar']) > 0) {
                        $automobile_footer_sidebar = array('automobile_var_footer_sidebar' => $automobile_var_options['automobile_var_footer_sidebar']);
                    } else {
                        $automobile_footer_sidebar = array('automobile_var_footer_sidebar' => array());
                    }
                } else {
                    $automobile_footer_sidebar = isset($automobile_var_footer_sidebar) ? $automobile_var_footer_sidebar : '';
                }

                $cssidebar = false;
                $i = 0;
                if (isset($automobile_footer_sidebar['automobile_var_footer_sidebar']) && is_array($automobile_footer_sidebar['automobile_var_footer_sidebar'])) {
                    foreach ($automobile_footer_sidebar['automobile_var_footer_sidebar'] as $footer_sidebar_var => $footer_sidebar_val) {

                        $footer_sidebar_list[$footer_sidebar_var] = $footer_sidebar_val;
                        $automobile_footer_sidebar_width = substr($automobile_var_options['automobile_var_footer_width'][$i], 0, 2);
                        $footer_sidebar_id = sanitize_title($footer_sidebar_val);
                        if (is_active_sidebar($footer_sidebar_id)) {
                            $cssidebar = true;
                        }
                        $i++;
                    }
                }
                ?>
                <div class="cs-footer-widgets">
                    <div class="container">

                        <?php
                        $i = 0;
                        if (isset($automobile_footer_sidebar['automobile_var_footer_sidebar'])) {
                            if (is_array($automobile_footer_sidebar['automobile_var_footer_sidebar'])) {
                                
                                echo '<div class="row">';
                                foreach ($automobile_footer_sidebar['automobile_var_footer_sidebar'] as $footer_sidebar_var => $footer_sidebar_val) { 
                                    $footer_sidebar_list[$footer_sidebar_var] = $footer_sidebar_val;
                                    $automobile_footer_sidebar_width = substr($automobile_var_options['automobile_var_footer_width'][$i], 0, 2);
                                    $footer_sidebar_id = sanitize_title($footer_sidebar_val); 
                                            $footer_side = '';
                                        if($automobile_footer_sidebar_width == 2){
                                            $footer_side = 'col-lg-2 col-md-2 col-sm-6 col-xs-12';
                                        }elseif($automobile_footer_sidebar_width == 3){
                                            $footer_side = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
                                        }
                                        elseif($automobile_footer_sidebar_width == 4){
                                            $footer_side = 'col-lg-4 col-md-4 col-sm-6 col-xs-12';
                                        }
                                        elseif($automobile_footer_sidebar_width == 6){
                                            $footer_side = 'col-lg-6 col-md-6 col-sm-12 col-xs-12';
                                        }
                                        elseif($automobile_footer_sidebar_width == 8){
                                            $footer_side = 'col-lg-8 col-md-8 col-sm-12 col-xs-12';
                                        }
                                        elseif($automobile_footer_sidebar_width == 9){
                                            $footer_side = 'col-lg-9 col-md-9 col-sm-12 col-xs-12';
                                        }
                                        elseif($automobile_footer_sidebar_width == 10){
                                            $footer_side = 'col-lg-10 col-md-10 col-sm-12 col-xs-12';
                                        }else{
                                            $footer_side = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
                                        }
                                    if (is_active_sidebar(automobile_get_sidebar_id($footer_sidebar_id))) {
                                        echo '<div class="' . $footer_side . '">';
                                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($footer_sidebar_id)) :
                                        endif;                                        
                                        echo '</div>';
                                    }
                                    $i++;
                                }
                                echo '</div>';
                            }
                        }
                        ?>

                    </div>
                </div>

                <?php
            }
            if ($automobile_var_copy_write_section == 'on') {
                ?>
                <div class="cs-copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="copyright-text">
                                    <p>
                                        <?php
                                        $automobile_allowed_tags = array(
                                            'a' => array('href' => array(), 'class' => array()),
                                            'b' => array(),
                                            'i' => array('class' => array()),
                                        );
                                        echo wp_kses(wp_specialchars_decode($automobile_var_copy_right), $automobile_allowed_tags);
                                        ?>
                                    </p>



                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="cs-back-to-top">
                                    <?php if ($automobile_var_footer_contact_no <> '') { ?>
                                        <address>
                                            <i class="icon-phone"></i> <a href="#"><?php echo esc_html($automobile_var_footer_contact_no) ?></a>
                                        </address>
                                    <?php } if ($automobile_var_back_to_top == 'on') { ?>
                                        <a class="btn-to-top cs-bgcolor" href=""><i class="icon-keyboard_arrow_up"></i></a>
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </footer>

        <!-- Footer End --> 
    </div>

        <?php
    }
}
?>

<?php wp_footer(); ?>
</body>
</html>
