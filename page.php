<?php
/**
 * The template for displaying all single pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package Marianne
 * @since Marianne 1.0
 */

get_header();
?>

<div id="content" class="site-content">
	<main id="primary" class="site-primary" role="main">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				if ( comments_open() ) {
					comments_template();
				}
			}
		}
		?>
	</main>

	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
