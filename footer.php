<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #page div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Marianne
 * @since Marianne 1.0
 */

?>
			<footer class="site-footer text-secondary" role="contentinfo">
				<div class="site-footer-block">
					<?php
					$marianne_site_name = '<em>' . get_bloginfo( 'name', 'display' ) . '</em>';

					$marianne_wp_link  = '<a href="' . esc_url( __( 'https://wordpress.org/', 'marianne' ) ) . '">';
					$marianne_wp_link .= 'WordPress';
					$marianne_wp_link .= '</a>';

					$marianne_theme_info = wp_get_theme();
					$marianne_theme_name = $marianne_theme_info->get( 'Name' );

					printf(
						/* translators: $1%s: WordPress. $2%s: Marianne */
						esc_html_x( '%1$s is proudly powered by %2$s and %3$s', 'Site footer text', 'marianne' ),
						$marianne_site_name,
						$marianne_wp_link,
						esc_html( $marianne_theme_name )
					);
					?>
				</div>

				<?php
				if ( has_nav_menu( 'footer' ) ) {
					echo '<nav id="menu-footer-container" class="site-footer-block" role="navigation" aria-label="' . esc_attr__( 'Footer menu', 'marianne' ) . '">';

					wp_nav_menu(
						array(
							'container'       => '',
							'depth'           => 1,
							'menu_class'      => 'navigation-menu',
							'menu_id'         => 'menu-footer',
							'theme_location'  => 'footer',
						)
					);

					echo '</nav>';
				}
				?>

				<?php wp_footer(); ?>
			</footer>
		</div><!-- #page -->
	</body>
</html>
