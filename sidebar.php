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
		

		<?php
		$marianne_widgets_class = 'site-secondary';

		if ( true === marianne_get_theme_mod( 'marianne_print_widgets_hide' ) ) {
			$marianne_widgets_class .= ' print-widgets-hide';
		}
		?>
		<aside id="secondary"<?php marianne_add_class( $marianne_widgets_class ); ?> role="complementary">
			<?php dynamic_sidebar( 'widgets' ); ?>
		</aside>
	<?php
}
