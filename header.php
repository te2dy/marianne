<?php
/**
 * The header
 *
 * This is the template that displays all of the <head> section,
 * the site branding (logo, title, description) and the main menu.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Marianne
 * @since Marianne 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		}
		?>

		<a class="skip-link screen-reader-text" href="#content">
			<?php esc_html_e( 'Skip to content', 'marianne' ); ?>
		</a>

		<div id="page" class="site">
			<header id="header" class="site-header" role="banner">
				<?php if ( has_custom_logo() ) { ?>
					<div class="site-logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php } ?>

				<?php
				marianne_site_title();

				marianne_site_description();
				?>

				<button id="menu-mobile-button" onclick="marianneExpandMobileMenu(this)">Menu</button>
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'container'            => 'nav',
							'container_id'         => 'menu-primary-container',
							'container_aria_label' => esc_attr( 'Primary menu', 'marianne' ),
							'depth'                => 2,
							'item_spacing'         => 'discard',
							'menu_class'           => 'navigation-menu',
							'menu_id'              => 'menu-primary',
							'theme_location'       => 'primary',
						)
					);
				}
				?>
			</header>
