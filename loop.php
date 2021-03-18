<?php
/**
 * The loop.
 *
 * The loop displays the list of posts.
 *
 * @package Marianne
 * @since Marianne 1.0
 */

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/content', 'loop' );
	}

	marianne_loop_navigation();
} else {
	get_template_part( 'template-parts/content', 'none' );
}
