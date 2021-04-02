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

		$marianne_thumbnail_class = 'entry-thumbnail post-thumbnail';

		if ( false !== marianne_get_theme_mod( 'marianne_global_images_expand' ) ) {
			$marianne_thumbnail_class .= ' entry-thumbnail-wide';
		}

		marianne_the_post_thumbnail( $marianne_thumbnail_class, array( 'caption' ) );
		?>
	</header>

	<?php
	$marianne_single_classes  = 'entry-content post-content';
	$marianne_single_classes .= ' text-align-' . marianne_get_theme_mod( 'marianne_content_text_align' );

	if ( true === marianne_get_theme_mod( 'marianne_content_hyphens' ) ) {
		$marianne_single_classes .= ' text-hyphens';
	}

	if ( true === marianne_get_theme_mod( 'marianne_print_url' ) ) {
		$marianne_single_classes .= ' print-url-show';
	}
	?>
	<section <?php marianne_add_class( $marianne_single_classes, false ); ?>>
		<?php
		the_content();

		wp_link_pages();
		?>
	</section>

	<?php if ( has_tag() || true === marianne_get_theme_mod( 'marianne_post_nav' ) || true === marianne_get_theme_mod( 'marianne_print_info' ) ) : ?>
		<footer class="entry-footer post-footer">
			<div class="entry-tags post-tags text-secondary">
				<?php the_tags(); ?>
			</div>

			<?php
			if ( true === marianne_get_theme_mod( 'marianne_print_info' ) ) {
				marianne_print_info();
			}

			if ( true === marianne_get_theme_mod( 'marianne_post_nav' ) ) {
				marianne_post_links();
			}
			?>
		</footer>
	<?php endif; ?>
</article>
