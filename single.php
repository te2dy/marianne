<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

				get_template_part( 'template-parts/content', 'single' );

				if ( comments_open() ) {
					comments_template();
				}
			}
		}
		?>
	</main>
</div>

<?php
get_sidebar()
get_footer();
