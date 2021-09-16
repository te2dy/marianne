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
			<?php
			$marianne_footer_class  = 'site-footer text-secondary';
			$marianne_footer_class .= ' site-footer-align-' . esc_attr( marianne_get_theme_mod( 'marianne_footer_align' ) );
			?>
			<footer <?php marianne_add_class( $marianne_footer_class, false ); ?> role="contentinfo">
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
								'item_spacing'   => 'discard',
								'menu_class'     => 'navigation-menu',
								'menu_id'        => 'menu-footer',
								'theme_location' => 'footer',
							)
						);
						?>
					</nav>
				<?php endif; ?>

				<?php
				if ( 'footer' === marianne_get_theme_mod( 'marianne_social_location' ) ) {
					marianne_social_link();
				}
				?>

				<?php if ( false !== marianne_get_theme_mod( 'marianne_footer_mention' ) ) : ?>
					<div id="site-footer-mention" class="site-footer-block">
						<?php
						printf(
							/* translators: $1%s: WordPress. $2%s: Marianne. */
							esc_html_x( 'Powered by %1$s and %2$s', 'Site footer text', 'marianne' ),
							'<a href="' . esc_url( __( 'https://wordpress.org/', 'marianne' ) ) . '">WordPress</a>',
							'<a href="' . esc_url( __( 'https://wordpress.org/themes/marianne/', 'marianne' ) ) . '">' . esc_attr( wp_get_theme()->get( 'Name' ) ) . '</a>'
						);
						?>
					</div>
				<?php endif; ?>

				<?php if ( false !== marianne_get_theme_mod( 'marianne_footer_go_top' ) ) : ?>
					<div class="site-footer-block">
						<?php
						$marianne_svg_chevron_data   = marianne_svg_icons( 'chevron-up' );
						$marianne_svg_chevron_shapes = $marianne_svg_chevron_data['shapes'];
						$marianne_svg_chevron_args   = array(
							'aria-label' => __( 'Back to top', 'marianne' ),
							'class'      => 'feather-icons',
							'size'       => array( 12, 12 ),
						);
						?>

						<button id="back-to-top">
							<?php echo marianne_esc_svg( marianne_svg( $marianne_svg_chevron_shapes, $marianne_svg_chevron_args ) . ' ' . esc_html__( 'Back to top', 'marianne' ) ); ?>
						</button>
					</div>
				<?php endif; ?>

				<?php wp_footer(); ?>
			</footer>
		</div><!-- #page -->
	</body>
</html>
