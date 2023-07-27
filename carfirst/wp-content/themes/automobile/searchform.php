<?php
/**
 * Template for displaying search forms in Auto Mobile
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
?>
<?php
$var_arrays = array('post', 'automobile_var_static_text');
$search_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($search_global_vars);

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
            <input type="search" class="search-field" placeholder="<?php echo automobile_var_theme_text_srt('automobile_var_search_hellip') ; ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo automobile_var_theme_text_srt('automobile_var_search_for') ; ?>" />
	</label>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo automobile_var_theme_text_srt('automobile_var_search_string') ; ?></span></button>
</form>
