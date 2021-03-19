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
	$marianne_body_class  = 'font-family-' . esc_attr( marianne_get_theme_mod( 'marianne_fonts_family' ) );
	$marianne_body_class .= ' theme-' . esc_attr( marianne_get_theme_mod( 'colors_theme' ) );
	$marianne_body_class .= ' link-hover-' . esc_attr( marianne_get_theme_mod( 'colors_link_hover' ) );

	if ( false !== marianne_get_theme_mod( 'marianne_fonts_text_shadow' ) ) {
		$marianne_body_class .= ' text-shadow';
	}
	?>
	<body <?php body_class( $marianne_body_class ); ?>>
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
