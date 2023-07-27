<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
get_header();
$var_arrays = array('automobile_var_static_text', 'automobile_var_form_fields', 'automobile_var_html_fields');
$error_page_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);

extract($error_page_global_vars);
?>
<div class="main-section"> 
    <div class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="cs-page-not-found">
                        <div class="cs-text">
                            <p><?php echo html_entity_decode(automobile_var_theme_text_srt('automobile_var_nothing_found_404')); ?></p>
                            <span class="cs-error"><?php echo html_entity_decode(automobile_var_theme_text_srt('automobile_var_Oops_404')); ?></span>
                        </div>
                        <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="input-holder">
                                <i class="icon-search2"> </i>
                                <?php
                                $automobile_opt_array = array(
                                    'std' => '',
                                    'id' => '',
                                    'classes' => 'form-control txt-bar',
                                    'extra_atr' => 'onfocus="if (this.value == \'' . automobile_var_theme_text_srt('automobile_var_search_by_keyword') . '\') {
                                            this.value = \'\';
                                        }" 
                                       onblur="if (this.value == \'\') {
                                                   this.value = \'' . automobile_var_theme_text_srt('automobile_var_search_by_keyword') . '\';
                                               }" 
                                       placeholder="' . automobile_var_theme_text_srt('automobile_var_search_by_keyword') . '"',
                                    'cust_id' => 's',
                                    'cust_name' => 's',
                                    'return' => true,
                                    'required' => false
                                );
                                echo automobile_var_special_char($automobile_var_form_fields->automobile_var_form_text_render($automobile_opt_array));
                                
                                ?>
                                <label>
                                    <?php
                                    $automobile_opt_array = array(
                                        'std' => automobile_var_theme_text_srt('automobile_var_search_button'),
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => 'btnsubmit cs-bgcolor',
                                        'extra_atr' => '',
                                        'cust_id' => '',
                                        'cust_name' => '',
                                        'return' => true,
                                        'required' => false
                                    );
                                    echo automobile_var_special_char($automobile_var_form_fields->automobile_var_form_submit_render($automobile_opt_array));
                                    ?>
                                    <i class="icon-search2"> </i>
                                </label>
                            </div>
                            <?php
                            $automobile_opt_array = array(
                                'std' => 'en',
                                'id' => '',
                                'extra_atr' => '',
                                'cust_id' => 'lang',
                                'cust_name' => 'lang',
                                'return' => true,
                                'required' => false
                            );
                            echo automobile_var_special_char($automobile_var_form_fields->automobile_var_form_hidden_render($automobile_opt_array));
                            ?>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="cs-seprater-v1">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home"><span><i class="icon-home2 cs-bgcolor"> </i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</div>
<?php get_footer(); ?>
