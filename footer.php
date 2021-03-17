<?php
/**
 * The template for displaying the footer.
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
					printf(
						/* translators: $1%s: Site name. $2%s: WordPress. $3%s: Marianne. */
						esc_html_x( '%1$s is proudly powered by %2$s and %3$s', 'Site footer text', 'marianne' ),
						get_bloginfo( 'name', 'display' ),
						'<a href="' . esc_url( __( 'https://wordpress.org/', 'marianne' ) ) . '">WordPress</a>',
						esc_html( wp_get_theme()->get( 'Name' ) )
					);
					?>
				</div>

				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav id="menu-footer-container" class="site-footer-block" role="navigation" aria-label="<?php echo esc_attr__( 'Footer Menu', 'marianne' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'container'      => '',
								'depth'          => 1,
								'menu_class'     => 'navigation-menu',
								'menu_id'        => 'menu-footer',
								'theme_location' => 'footer',
							)
						);
						?>
					</nav>
				<?php endif; ?>

				<?php wp_footer(); ?>
			</footer>
		</div><!-- #page -->
	</body>
</html>
