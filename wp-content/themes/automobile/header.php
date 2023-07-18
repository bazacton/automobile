<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Auto_Mobile
 * @since Auto Mobile 1.0
 */
do_action('automobile_before_header');
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
	<?php
	global $automobile_var_options, $automobile_var_frame_options;
	$automobile_var_layout = isset($automobile_var_options['automobile_var_layout']) ? $automobile_var_options['automobile_var_layout'] : '';
	?>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if (is_singular() && pings_open(get_queried_object())) : ?>
    	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>
	<?php
	automobile_var_load_fonts();
	wp_head();
	?>

    </head>

    <body <?php body_class() ?>>
        <?php wp_body_open(); ?>
        <div class="wrapper wrapper-<?php echo esc_attr($automobile_var_layout); ?>"> 
            <!-- Header Start -->
	    <?php
	    $automobile_var_maintenance_page = isset($automobile_var_frame_options['automobile_var_maintinance_mode_page']) ? $automobile_var_frame_options['automobile_var_maintinance_mode_page'] : '';
	    $automobile_var_maintenance_check = isset($automobile_var_frame_options['automobile_var_coming_soon_switch']) ? $automobile_var_frame_options['automobile_var_coming_soon_switch'] : '';
	    $automobile_var_header_switch = isset($automobile_var_frame_options['automobile_var_header_switch']) ? $automobile_var_frame_options['automobile_var_header_switch'] : 'off';

	    // if (get_the_ID() == $automobile_var_maintenance_page && $automobile_var_maintenance_check == 'on' && $automobile_var_header_switch == 'off') {
	    if ((isset($automobile_var_maintenance_page) && !empty($automobile_var_maintenance_page) && get_the_ID() == $automobile_var_maintenance_page) && $automobile_var_maintenance_check == 'on' && $automobile_var_header_switch <> 'on') {
		echo '<header id="header"></header>';
	    } elseif ((isset($automobile_var_maintenance_page) && !empty($automobile_var_maintenance_page) && get_the_ID() == $automobile_var_maintenance_page) && $automobile_var_maintenance_check <> 'on' && $automobile_var_header_switch <> 'on') {
		echo '<header id="header"></header>';
	    } else {
		$header_style = $automobile_var_options['automobile_var_header_style'];
		if (array_key_exists("automobile_var_header_transparent", $automobile_var_options)) {
		    $header_transparent = $automobile_var_options['automobile_var_header_transparent'];
		}
		if (array_key_exists("automobile_var_header_sticky", $automobile_var_options)) {
		    $header_sticky = $automobile_var_options['automobile_var_header_sticky'];
		}
		$header_classes = '';

		if ($header_style == 'full_width') {
		    $header_classes = 'full-width';
		} elseif ($header_classes == 'default') {
		    $header_classes = 'default';
		}
		if (array_key_exists("automobile_var_header_inventory_page", $automobile_var_options)) {
		    $header_transparent_inventory_page = $automobile_var_options['automobile_var_header_inventory_page'];
		} else {
		    $header_transparent_inventory_page = '';
		}
		if (is_author()) {
		    $var_author = 'yes';
		} else {
		    $var_author = 'no';
		}
		if (isset($var_author) && $var_author == 'no' && get_post_type() == 'inventory') {
		    $automobile_inv_view = get_post_meta($post->ID, 'automobile_inventory_view', true);
		} else {
		    $automobile_inv_view = '';
		}
		if (array_key_exists("automobile_var_header_transparent", $automobile_var_options)) {
		    if ($header_transparent_inventory_page == 'on') { // transparent off on invenory detail page
			if ($header_transparent == 'on' && $automobile_inv_view != 'view-3' && $var_author != 'yes') {
			    $header_classes .= ' transparent';
			}
		    } else {
			if ($header_transparent == 'on' && $automobile_inv_view != 'view-3' && $automobile_inv_view != 'view-2' && $automobile_inv_view != 'view-1' & $automobile_inv_view != 'default') {
			    $header_classes .= ' transparent';
			}
		    }
		}
		if (array_key_exists("automobile_var_header_sticky", $automobile_var_options)) {
		    if ($header_sticky == 'on') {
			$header_classes .= ' sticky';
		    }
		}
		?>

    	    <header id="header" class="<?php echo automobile_allow_special_char($header_classes); ?>">
    		<div class="container">
    		    <div class="row">
			    <?php
			    $isRegistrationOn = get_option('users_can_register');
			    global $automobile_var_plugin_options;
			    $sign_in_btn = isset( $automobile_var_plugin_options['automobile_user_dashboard_switchs'] )? $automobile_var_plugin_options['automobile_user_dashboard_switchs'] : 'off';
			    if (!$isRegistrationOn && $sign_in_btn != 'on' && wp_is_mobile()) {
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    <div class="user-login-mobile">
					<?php
					echo automobile_var_logo();
					?>
					<div class="cs-main-nav pull-right">
					    <?php
					    $defaults = array(
						'theme_location' => '',
						'menu' => '',
						'container' => '',
						'container_class' => '',
						'container_id' => '',
						'menu_class' => '',
						'menu_id' => '',
						'echo' => false,
						'fallback_cb' => 'automobile_custom_pages_menu',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'items_wrap' => '<ul class="%1$s">%3$s</ul>',
						'depth' => '',
					    );

					    if (has_nav_menu('primary')) {
						$defaults = array(
						    'theme_location' => 'primary',
						    'menu' => '',
						    'container' => 'nav',
						    'container_class' => 'main-navigation',
						    'container_id' => '',
						    'menu_class' => "",
						    'menu_id' => "",
						    'echo' => false,
						    'fallback_cb' => 'wp_page_menu',
						    'before' => '',
						    'after' => '',
						    'link_before' => '',
						    'link_after' => '',
						    'items_wrap' => '<ul class="%1$s">%3$s</ul>',
						    'depth' => '',);
					    }

					    echo wp_nav_menu($defaults);
					    ?>
					</div>
				    </div>
				</div>
			    <?php } else {
				?>
				<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
				    <?php
				    echo automobile_var_logo();
				    ?>
				</div>
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
				    <div class="cs-main-nav pull-right">
					<?php
					$defaults = array(
					    'theme_location' => '',
					    'menu' => '',
					    'container' => 'nav',
					    'container_class' => 'main-navigation',
					    'container_id' => '',
					    'menu_class' => '',
					    'menu_id' => '',
					    'echo' => false,
					    'fallback_cb' => 'automobile_custom_pages_menu',
					    'before' => '',
					    'after' => '',
					    'link_before' => '',
					    'link_after' => '',
					    'items_wrap' => '<ul class="%1$s">%3$s</ul>',
					    'depth' => 0,
					);

					if (has_nav_menu('primary')) {
					    $defaults = array(
						'theme_location' => 'primary',
						'menu' => '',
						'container' => 'nav',
						'container_class' => 'main-navigation',
						'container_id' => '',
						'menu_class' => "",
						'menu_id' => "",
						'echo' => false,
						'fallback_cb' => 'wp_page_menu',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'link_after' => '',
						'items_wrap' => '<ul class="%1$s">%3$s</ul>',
						'depth' => 0,);
					}

					echo wp_nav_menu($defaults);
					?>
				    </div>
				</div>
			    <?php } ?>
    		    </div>
    		</div>
    	    </header>
	    <?php } ?>
            <!-- Header End --> 
	    <?php
	    if (function_exists('automobile_var_subheader_style')) {
		$author = get_queried_object();
		$role = isset($author->roles[0]) ? $author->roles[0] : '';
		if ($role != 'automobile_dealer') {
		    automobile_var_subheader_style();
		}
	    }