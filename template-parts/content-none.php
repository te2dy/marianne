<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Marianne
 * @since Marianne 1.0
 */

?>

<article <?php post_class( 'entry-page' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title page-title">
			<?php esc_html_e( 'Nothing here', 'marianne' ); ?>
		</h1>
	</header>

	<?php
	$marianne_single_classes  = "entry-content page-content";
	$marianne_single_classes .= ' text-align-' . marianne_get_theme_mod( 'marianne_content_text_align' );
	?>
	<section <?php marianne_add_class( $marianne_single_classes ); ?>>
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'marianne' ); ?></p>

		<?php get_search_form(); ?>
	</section>
</article>
