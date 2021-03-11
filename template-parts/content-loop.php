<?php
/**
 * Template part for displaying posts in the loop
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Marianne
 * @since Marianne 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-loop' ); ?>>
	<header class="entry-header loop-header">
		<?php if ( is_sticky() ) : ?>
			<div class="entry-meta meta-sticky text-secondary">
				<?php esc_html_e( 'Sticky post', 'marianne' ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-meta text-secondary">
			<a href="<?php the_permalink(); ?>">
				<?php marianne_the_date(); ?>
			</a>
		</div>

		<?php marianne_the_categories( 'entry-meta text-secondary' ); ?>

		<h3 class="entry-title loop-title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>

		<?php marianne_the_post_thumbnail( 'entry-thumbnail loop-thumbnail', 'link' ); ?>
	</header>

	<section class="entry-content loop-content">
		<a href="<?php the_permalink(); ?>">
			<?php the_excerpt(); ?>
		</a>
	</section>

	<?php marianne_loop_comments( 'footer', 'loop-footer text-secondary' ); ?>
</article>
