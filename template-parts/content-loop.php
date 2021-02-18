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

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'entry-loop' ) ); ?>>
	<header class="entry-header">
		<div class="entry-meta-container">
			<?php if ( is_sticky() ) : ?>
				<div class="meta-sticky">
					<?php esc_html_e( 'Sticky post', 'marianne' ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-meta text-secondary">
				<a href="<?php the_permalink(); ?>">
					<?php marianne_the_date(); ?>
				</a>
			</div>

			<?php marianne_the_categories( 'entry-meta text-secondary' ); ?>
		</div>

		<h3 class="entry-title loop-title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>
	</header>

	<section class="entry-content loop-content">
		<a href="<?php the_permalink(); ?>">
			<?php the_excerpt(); ?>
		</a>
	</section>

	<footer class="entry-meta loop-meta text-secondary">
		<?php marianne_loop_comments(); ?>
	</footer>
</article>
