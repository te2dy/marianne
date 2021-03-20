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
				<?php if ( true === marianne_get_theme_mod( 'marianne_footer_mention' ) ) : ?>
					<div class="site-footer-block">
						<?php
						printf(
							/* translators: $1%s: Site name. $2%s: WordPress. $3%s: Marianne. */
							esc_html_x( '%1$s is proudly powered by %2$s and %3$s', 'Site footer text', 'marianne' ),
							get_bloginfo( 'name', 'display' ),
							'<a href="' . esc_url( __( 'https://wordpress.org/', 'marianne' ) ) . '">WordPress</a>',
							'<a href="' . esc_url( __( 'https://wordpress.org/themes/marianne/', 'marianne' ) ) . '">' . esc_html( wp_get_theme()->get( 'Name' ) ) . '</a>'
						);
						?>
					</div>
				<?php endif; ?>

				<?php
				$marianne_footer_text = marianne_get_theme_mod( 'marianne_footer_text' );
				if ( $marianne_footer_text ) {
					?>
						<div class="site-footer-block">
							<?php echo wp_kses_post( wpautop( $marianne_footer_text ) ); ?>
						</div>
					<?php
				}
				?>

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
