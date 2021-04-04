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
			<?php
			if ( has_post_format( array( 'audio', 'image', 'video' ) ) ) : ?>
				<div class="post-format-icon-container">
					<?php
					if ( has_post_format( 'audio' ) ) {
						marianne_svg( '<path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>' );
					} elseif ( has_post_format( 'image' ) ) {
						marianne_svg( '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline>' );
					} elseif ( has_post_format( 'video' ) ) {
						marianne_svg( '<polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>' );
					}
					?>
				</div>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<?php
		$marianne_thumbnail_class = 'entry-thumbnail loop-thumbnail';

		if ( true === marianne_get_theme_mod( 'marianne_global_images_expand' ) ) {
			$marianne_thumbnail_class .= ' entry-thumbnail-wide';
		}

		marianne_the_post_thumbnail( $marianne_thumbnail_class, array( 'link' ) );
		?>
	</header>

	<?php
	$marianne_single_classes  = 'entry-content loop-content';
	$marianne_single_classes .= ' text-align-' . marianne_get_theme_mod( 'marianne_content_text_align' );

	if ( true === marianne_get_theme_mod( 'marianne_content_hyphens' ) ) {
		$marianne_single_classes .= ' text-hyphens';
	}
	?>
	<section <?php marianne_add_class( $marianne_single_classes, false ); ?>>
		<a href="<?php the_permalink(); ?>">
			<?php the_excerpt(); ?>
		</a>
	</section>

	<?php
	twenty_twenty_one_print_first_instance_of_block( 'core/image', get_the_content() );
	?>

	<?php marianne_loop_comments( 'entry-footer loop-footer text-secondary' ); ?>
</article>
