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

	<section class="entry-content page-content">
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'marianne' ); ?></p>

		<?php get_search_form(); ?>
	</section>
</article>
