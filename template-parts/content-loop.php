<?php
/**
 * Template part for displaying posts in the loop.
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
			<div class="entry-meta entry-sticky text-secondary">
				<?php esc_html_e( 'Sticky post', 'marianne' ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-meta text-secondary">
			<a href="<?php the_permalink(); ?>"><?php marianne_the_date(); ?></a>
		</div>

		<?php marianne_the_categories( 'entry-meta text-secondary' ); ?>

		<h3 class="entry-title loop-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<?php marianne_the_post_thumbnail( 'entry-thumbnail loop-thumbnail', array( 'link' ) ); ?>
	</header>

	<?php
	$marianne_single_classes  = 'entry-content loop-content';
	$marianne_single_classes .= ' text-align-' . marianne_get_theme_mod( 'marianne_content_text_align' );

	if ( false !== marianne_get_theme_mod( 'marianne_content_hyphens' ) ) {
		$marianne_single_classes .= ' text-hyphens';
	}
	?>
	<section <?php marianne_add_class( $marianne_single_classes, false ); ?>>
		<a href="<?php the_permalink(); ?>">
			<?php the_excerpt(); ?>
		</a>
	</section>

	<?php marianne_loop_comments( 'footer', 'loop-footer text-secondary' ); ?>
</article>
