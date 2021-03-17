<?php
/**
 * The template for displaying the sidebar.
 *
 * Displays the sidebar at the bottom of the page,
 * in the #content div and before the footer.
 *
 * @package Marianne
 * @since Marianne 1.0
 */

if ( is_active_sidebar( 'widgets' ) ) {
	?>
		<hr class="separator">

		<aside id="secondary" class="site-secondary" role="complementary">
			<?php dynamic_sidebar( 'widgets' ); ?>
		</aside>
	<?php
}
