<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Marianne
 * @since Marianne 1.0
 */

get_header();
?>

<div id="content" class="site-content">
	<main id="primary" class="site-primary" role="main">
		<?php if ( is_archive() ) : ?>
			<header class="archive-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );

				$description = get_the_archive_description();
				if ( $description ) {
					?>
						<div class="archive-description">
							<?php echo wp_kses_post( wpautop( $description ) ); ?>
						</div>
					<?php
				}
				?>
			</header>
		<?php endif; ?>

		<?php get_template_part( 'loop' ); ?>
	</main>

	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
