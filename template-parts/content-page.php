<?php
/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Marianne
 * @since Marianne 1.0
 */

?>

<article id="page-<?php the_ID(); ?>" <?php post_class( 'entry-page' ); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title page-title">', '</h1>' ); ?>
	</header>

	<section class="entry-content page-content">
		<?php the_content(); ?>

		<?php wp_link_pages(); ?>
	</section>
</article>
