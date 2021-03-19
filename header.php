<?php
/**
 * The template for displaying the header.
 *
 * This is the template that displays all of the head section,
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

	<?php
	$classes  = '';
	$classes .= 'font-family-' . esc_attr( marianne_get_theme_mod( 'marianne_fonts_family' ) );
	?>
	<body <?php body_class( $classes ); ?>>
		<?php
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		}
		?>

		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'marianne' ); ?></a>

		<div id="page" class="site">
			<header id="header" class="site-header" role="banner">
				<?php
				marianne_logo();

				marianne_site_title();

				marianne_site_description();

				marianne_menu_primary();
				?>
			</header>
