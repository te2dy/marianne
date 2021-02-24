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
		<div class="entry-meta-container">
			<?php if ( is_sticky() ) : ?>
				<div class="meta-sticky">
					<?php esc_html_e( 'Sticky post', 'marianne' ); ?>
				</div>
			<?php endif; ?>

			<?php marianne_the_categories( 'entry-meta text-secondary' ); ?>
		</div>

		<?php the_title( '<h1 class="entry-title post-title">', '</h1>' ); ?>

		<div class="entry-meta-container">
			<?php marianne_the_date( 'entry-meta post-date text-secondary' ); ?>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail post-thumbnail">
				<?php the_post_thumbnail(); ?>

				<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
					<figcaption class="wp-caption-text text-secondary">
						<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
					</figcaption>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</header>

	<section class="entry-content post-content">
		<?php the_content(); ?>

		<?php wp_link_pages(); ?>
	</section>

	<?php if ( has_tag() ) : ?>
		<footer class="entry-footer post-footer text-secondary">
			<?php the_tags(); ?>
		</footer>
	<?php endif; ?>
</article>
