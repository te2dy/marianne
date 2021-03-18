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

	<section class="entry-content page-content">
		<?php
		the_content();

		wp_link_pages();
		?>
	</section>
</article>
