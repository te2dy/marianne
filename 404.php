<?php
/**
 * The template for displaying the 404 (Not Found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Marianne
 * @since Marianne 1.0
 */

get_header();
?>

<div id="content" class="site-content">
	<main id="primary" class="site-primary" role="main">
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	</main>

	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
