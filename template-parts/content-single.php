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
		if ( 'top' === marianne_get_theme_mod( 'marianne_post_author_position' ) ) {
			$marianne_post_info_args = array();

			if ( 'name' === marianne_get_theme_mod( 'marianne_post_author_info' ) ) {
				$marianne_post_info_args[] = 'author_name';
			} elseif ( 'avatar' === marianne_get_theme_mod( 'marianne_post_author_info' ) ) {
				$marianne_post_info_args[] = 'author_avatar';
			} else {
				$marianne_post_info_args[] = 'author_name';
				$marianne_post_info_args[] = 'author_avatar';
			}

			if ( true === marianne_get_theme_mod( 'marianne_post_author_name_prefix' ) ) {
				$marianne_post_info_args[] = 'author_prefix';
			}

			if ( true === marianne_get_theme_mod( 'marianne_post_post_time' ) ) {
				$marianne_post_info_args[] = 'time';
			}

			marianne_post_info( 'entry-meta text-secondary', $marianne_post_info_args );
		} else {
			$marianne_date_args = array(
				'date' => true,
				'time' => false,
			);

			if ( true === marianne_get_theme_mod( 'marianne_post_post_time' ) ) {
				$marianne_date_args['time'] = true;
			}

			marianne_the_date( 'entry-meta entry-date text-secondary', $marianne_date_args );
		}

		marianne_the_categories( 'entry-meta entry-categories text-secondary' );

		the_title( '<h1 class="entry-title post-title">', '</h1>' );

		$marianne_thumbnail_class = 'entry-thumbnail post-thumbnail';

		if ( true === marianne_get_theme_mod( 'marianne_global_images_expand' ) ) {
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

	<?php if ( has_tag() || 'bottom' === marianne_get_theme_mod( 'marianne_post_author_position' ) || true === marianne_get_theme_mod( 'marianne_post_nav' ) || true === marianne_get_theme_mod( 'marianne_print_info' ) ) : ?>
		<footer class="entry-footer post-footer">
			<?php marianne_post_signature( 'post-signature' ); ?>

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
