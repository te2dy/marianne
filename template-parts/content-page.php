<?php
/**
 * Template part for displaying pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Marianne
 * @since Marianne 1.0
 */

?>

<article id="page-<?php the_ID(); ?>" <?php post_class( 'entry-page' ); ?>>
	<?php if ( ! is_front_page() ) : ?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title page-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<?php
	$marianne_single_classes  = 'entry-content page-content';
	$marianne_single_classes .= ' text-align-' . marianne_get_theme_mod( 'marianne_content_text_align' );

	if ( false !== marianne_get_theme_mod( 'marianne_content_hyphens' ) ) {
		$marianne_single_classes .= ' text-hyphens';
	}

	if ( true === marianne_get_theme_mod( 'marianne_print_url' ) ) {
		$marianne_single_classes .= ' print-url-show';
	}
	?>
	<section <?php marianne_add_class( $marianne_single_classes, false ); ?>>
		<?php
		the_content();

		wp_link_pages();
		?>
	</section>

	<?php if ( true === marianne_get_theme_mod( 'marianne_print_info' ) ) : ?>
		<footer class="entry-footer post-footer">
			<?php marianne_print_info(); ?>
		</footer>
	<?php endif; ?>
</article>
