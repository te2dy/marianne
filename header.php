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
	$marianne_body_class  = 'font-family-' . esc_attr( marianne_get_theme_mod( 'marianne_global_font_family' ) );
	$marianne_body_class .= ' font-size-' . esc_attr( marianne_get_theme_mod( 'marianne_global_font_size' ) );
	$marianne_body_class .= ' color-scheme-' . esc_attr( marianne_get_theme_mod( 'colors_scheme' ) );
	$marianne_body_class .= ' link-hover-' . esc_attr( marianne_get_theme_mod( 'colors_link_hover' ) );

	if ( true === marianne_get_theme_mod( 'marianne_global_font_smooth' ) ) {
		$marianne_body_class .= ' font-smooth';
	}

	if ( true === marianne_get_theme_mod( 'marianne_global_text_shadow' ) ) {
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

		<?php
		$marianne_page_class  = 'site';
		$marianne_page_class .= ' page-width-' . esc_attr( marianne_get_theme_mod( 'marianne_global_page_width' ) );
		?>
		<div id="page" <?php marianne_add_class( $marianne_page_class, false ); ?>>
			<?php
			if ( false === marianne_get_theme_mod( 'marianne_header_logo_title_inline' ) ) {
				$marianne_header_template = 'default';
			} else {
				$marianne_header_template = 'inline-logo-title';
			}

			get_template_part( 'template-parts/header', $marianne_header_template );
			?>
