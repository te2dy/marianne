<?php
/**
 * Template part for displaying posts.
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

		marianne_the_post_thumbnail( 'entry-thumbnail post-thumbnail', array( 'caption' ) );
		?>
	</header>

	<?php
	$marianne_single_classes  = 'entry-content post-content';
	$marianne_single_classes .= ' text-align-' . marianne_get_theme_mod( 'marianne_content_text_align' );

	if ( false !== marianne_get_theme_mod( 'marianne_content_hyphens' ) ) {
		$marianne_single_classes .= ' text-hyphens';
	}
	?>
	<section <?php marianne_add_class( $marianne_single_classes ); ?>>
		<?php
		the_content();

		wp_link_pages();
		?>
	</section>

	<?php if ( has_tag() || true === marianne_get_theme_mod( 'marianne_post_nav' ) ) : ?>
		<footer class="entry-footer post-footer">
			<div class="text-secondary">
				<?php the_tags(); ?>
			</div>

			<?php
			if ( true === marianne_get_theme_mod( 'marianne_post_nav' ) ) {
				$marianne_newer_post = get_next_post_link();
				$marianne_older_post = get_previous_post_link();

				if ( $marianne_newer_post || $marianne_older_post ) {
					?>
						<p><strong><?php esc_html_e( 'Continue reading', 'marianne' ); ?></strong></p>

						<nav class="post-navigation">
							<div class="nav-links">
								<?php
								if ( $marianne_newer_post ) {
									next_post_link( '%link', '‹ %title' );
								}

								if ( $marianne_older_post ) {
									previous_post_link( '%link', '%title ›' );
								}
								?>
							</div>
						</nav>
					<?php
				}
			}
			?>
		</footer>
	<?php endif; ?>
</article>
