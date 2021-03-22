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
				<?php
				$marianne_footer_text = marianne_get_theme_mod( 'marianne_footer_text' );
				if ( $marianne_footer_text ) {
					?>
						<div id="site-footer-text" class="site-footer-block">
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

				<?php
				$social_links = array();

				$social_links['twitter'] = marianne_get_twitter_username_to_url( marianne_get_theme_mod( 'marianne_social_twitter' ) );
				$social_links['facebook'] = marianne_get_theme_mod( 'marianne_social_facebook' );
				$social_links['instagram'] = marianne_get_theme_mod( 'marianne_social_instagram' );
				$social_links['linkedin'] = marianne_get_theme_mod( 'marianne_social_linkedin' );

				if ( ! empty( $social_links ) ) :
					?>
						<div id="site-footer-social" class="site-footer-block">
							<?php
							foreach( $social_links as $site => $link ) {
								if ( $link ) {
									?>
										<a href="<?php echo esc_url( $link ); ?>">
											<?php marianne_svg( marianne_svg_social_path( $site ) ); ?>
										</a>
									<?php
								}
							}
							?>
						</div>
					<?php
				endif;
				?>

				<?php if ( true === marianne_get_theme_mod( 'marianne_footer_mention' ) ) : ?>
					<div id="site-footer-mention" class="site-footer-block">
						<?php
						printf(
							/* translators: $1%s: WordPress. $2%s: Marianne. */
							esc_html_x( 'Powered by %1$s and %2$s', 'Site footer text', 'marianne' ),
							'<a href="' . esc_url( __( 'https://wordpress.org/', 'marianne' ) ) . '">WordPress</a>',
							'<a href="' . esc_url( __( 'https://wordpress.org/themes/marianne/', 'marianne' ) ) . '">' . esc_html( wp_get_theme()->get( 'Name' ) ) . '</a>'
						);
						?>
					</div>
				<?php endif; ?>

				<?php wp_footer(); ?>
			</footer>
		</div><!-- #page -->
	</body>
</html>
