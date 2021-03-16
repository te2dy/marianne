<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Marianne
 * @since Marianne 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-single' ); ?>>
	<header class="entry-header">
		<?php if ( is_sticky() ) : ?>
			<div class="entry-meta meta-sticky text-secondary">
				<?php esc_html_e( 'Sticky post', 'marianne' ); ?>
			</div>
		<?php endif; ?>

		<?php
		marianne_the_date( 'entry-meta entry-date post-date text-secondary' );

		marianne_the_categories( 'entry-meta text-secondary' );

		the_title( '<h1 class="entry-title post-title">', '</h1>' );

		marianne_the_post_thumbnail( 'entry-thumbnail post-thumbnail', 'caption' );
		?>
	</header>

	<section class="entry-content post-content">
		<?php
		the_content();

		wp_link_pages();
		?>
	</section>

	<?php if ( has_tag() ) : ?>
		<footer class="entry-footer post-footer text-secondary">
			<?php the_tags(); ?>
		</footer>
	<?php endif; ?>
</article>
