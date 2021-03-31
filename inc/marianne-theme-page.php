<?php
/**
 * The page of the theme.
 *
 * This file displays an "About Marianne" page
 * in the WordPress administration section.
 *
 * @package Marianne
 * @since Marianne 1.3
 */

if ( ! function_exists( 'marianne_admin_styles_scripts' ) ) {
	/**
	 * Enqueues theme page scripts and styles.
	 *
	 * On production, minified files are enqueued.
	 *
	 * @return void
	 */
	function marianne_admin_styles_scripts() {
		$theme_version = wp_get_theme()->get( 'Version' );
		$min           = marianne_minify();

		wp_enqueue_style( 'marianne-admin-page', get_template_directory_uri() . "/assets/css/marianne-theme-page$min.css", array(), $theme_version );
		wp_enqueue_script( 'marianne-admin-scripts', get_template_directory_uri() . "/assets/js/marianne-theme-page$min.js", array(), $theme_version, true );
	}

	add_action( 'admin_enqueue_scripts', 'marianne_admin_styles_scripts' );
}

/**
 * Adds submenu page to the Appearance main menu.
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_page/
 *
 * @return void
 */
function marianne_add_theme_page() {
	add_theme_page(
		esc_html__( 'About Marianne', 'marianne' ),
		esc_html__( 'About Marianne', 'marianne' ),
		'edit_theme_options',
		'marianne-theme-page',
		'marianne_theme_page'
	);
}
add_action( 'admin_menu', 'marianne_add_theme_page' );

/**
 * Outputs the content of the page.
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_page/
 *
 * @return void
 */
function marianne_theme_page() {
	// The variables used in the page.
	$theme_info        = wp_get_theme();
	$theme_version     = $theme_info->get( 'Version' );
	$theme_wp_link     = _x( 'https://wordpress.org/themes/marianne/', 'Link to Marianne on WordPress Theme Directory', 'marianne' );
	$support_wp_link   = 'https://wordpress.org/support/theme/marianne';
	$gh_link           = 'https://github.com/te2dy/marianne';
	$gh_link_issues    = 'https://github.com/te2dy/marianne/issues';
	$gh_link_translate = 'https://github.com/te2dy/marianne/tree/main/languages';
	$bitcoin_address   = '1BTUsDokaDRsqn4dsyAY6bc2rCLes4Vssb';
	$bitcoin_href      = 'bitcoin:' . $bitcoin_address;
	$btc_qr            = ' data:image/png;base64,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';

	/**
	 * Allows some html elements in paragraphs.
	 *
	 * @see wp_kses()
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_kses/
	 */
	$kses_allowed_html = array(
		'a' => array(
			'href'   => array(),
			'target' => array(),
		),
	);
	?>
		<div class="wrap marianne-admin">
			<div class="marianne-admin-block">
				<h1 class="marianne-admin-header marianne-admin-title">
					<?php echo esc_html_x( 'Marianne', 'The title of the theme page.', 'marianne' ); ?>
				</h1>

				<p>
					<strong>
						<?php
						printf(
							/* translators: %s: The version number of the theme. */
							esc_html__( 'Version %s', 'marianne' ),
							esc_html( $theme_version )
						);
						?>
					</strong>
				</p>

				<?php
				/**
				 * If an update is available, displays a message
				 * and a link to update.
				 *
				 * @link https://developer.wordpress.org/reference/functions/theme_update_available/
				 */
				theme_update_available( $theme_info );
				?>

				<div class="marianne-admin-margins">
					<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php echo esc_html_x( 'Customize', 'Verb. Point to the Theme Customizer.', 'marianne' ); ?></a>

					<a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" class="button"><?php esc_html_e( 'Menus', 'marianne' ); ?></a>

					<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" class="button"><?php esc_html_e( 'Widgets', 'marianne' ); ?></a>

					<a href="mailto:teddytheme@laposte.net" id="marianne-admin-button-thanks" class="button"><?php esc_html_e( 'Say thank you 🙏', 'marianne' ); ?></a>

					<button id="marianne-button-btc" class="button" aria-haspopup="true" aria-expanded="false" onclick="marianneAdminDonateButton(this)"><?php esc_html_e( 'Donate ₿', 'marianne' ); ?></button>

					<div id="marianne-btc-donate-container">
						<div id="marianne-btc-donate">
							<h3><?php esc_html_e( 'Donate Bitcoin', 'marianne' ); ?></h3>

							<p id="btc-address">
								<?php
								printf(
									wp_kses(
										/* translators: %1$s: Bitcoin scheme followed by address. %2$s: Bitcoin address. */
										_x( 'Address: <a href="%1$s">%2$s</a>', 'The bitcoin address link.', 'marianne' ),
										$kses_allowed_html
									),
									esc_attr( $bitcoin_href ),
									esc_html( $bitcoin_address )
								);
								?>
							</p>

							<p><a href="<?php echo esc_attr( $bitcoin_href ); ?>"><img id="btc-qr" src="<?php echo esc_attr( $btc_qr ); ?>" alt="<?php esc_attr_e( 'Donate Bitcoin', 'marianne' ); ?>" /></a><p>
						</div>
					</div>
				</div>

				<p>
					<?php
					/**
					 * Creates an array of links related to the theme to display.
					 */
					$links = array(
						array(
							'label' => __( 'WordPress Theme Directory', 'marianne' ),
							'url'   => $theme_wp_link,
						),
						array(
							'label' => __( 'WordPress Support Forum', 'marianne' ),
							'url'   => $support_wp_link,
						),
						array(
							'label' => __( 'GitHub Repository', 'marianne' ),
							'url'   => $gh_link,
						),
					);

					$i           = 0;
					$links_count = count( $links );

					// Displays the links.
					foreach ( $links as $link ) {
						$i++;

						echo '<a href="' . esc_url( $link['url'] ) . '" target="_blank">' . esc_html( $link['label'] ) . '</a>';

						if ( $i !== $links_count ) {
							echo ' | ';
						}
					}
					?>
				</p>
			</div>

			<div class="marianne-admin-block">
				<h2 class="marianne-admin-header"><?php esc_html_e( 'FAQ', 'marianne' ); ?></h2>

				<p><strong><?php esc_html_e( 'How can I set up a logo?', 'marianne' ); ?></strong></p>

				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %s: The URL of the Theme Customizer. */
							__( 'Open the <a href="%s">Theme Customizer</a>. Then, go to Site Identity and select a logo. Do not forget to press Publish for the logo to go live.', 'marianne' ),
							$kses_allowed_html
						),
						esc_url( admin_url( 'customize.php' ) )
					);
					?>
				</p>

				<p><strong><?php esc_html_e( 'How can I set change fonts?', 'marianne' ); ?></strong></p>

				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %s: The URL of the Theme Customizer. */
							__( 'Open the <a href="%s">Theme Customizer</a>. Then, go to Global Settings and select your favorite font family. Do not forget to press Publish.', 'marianne' ),
							$kses_allowed_html
						),
						esc_url( admin_url( 'customize.php' ) )
					);
					?>
				</p>

				<p><strong><?php esc_html_e( 'Can I display social links with this theme?', 'marianne' ); ?></strong></p>

				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %s: The URL of the Theme Customizer. */
							__( 'Yes, you can! Open the <a href="%s">Theme Customizer</a>. Then, go to Social Links. Everything is in there.', 'marianne' ),
							$kses_allowed_html
						),
						esc_url( admin_url( 'customize.php' ) )
					);
					?>
				</p>

				<p><strong><?php esc_html_e( 'Where can I download the pro/premium version of Marianne?', 'marianne' ); ?></strong></p>

				<p><?php esc_html_e( 'There is no paid version of Marianne. You already have everything this theme can provide without restrictions.', 'marianne' ); ?></p>

				<p><strong><?php esc_html_e( 'I have other questions.', 'marianne' ); ?></strong></p>

				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %s: The URL of the support forum of the theme on WordPress.org */
							__( 'Please visit the <a href="%s" target="_blank">support forum</a> and post them.', 'marianne' ),
							$kses_allowed_html
						),
						esc_url( $support_wp_link )
					);
					?>
				</p>
			</div>

			<div class="marianne-admin-block">
				<h2 class="marianne-admin-header"><?php echo esc_html__( 'Contribute', 'marianne' ); ?></h2>

				<p><strong><?php esc_html_e( 'Issues & Feature Requests', 'marianne' ); ?></strong></p>

				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %1$s: The URL of the GitHub Issues page of the Marianne repository. %2$s: The URL of the support forum of the theme on WordPress.org */
							__( 'Please report issues or make feature requests on <a href="%1$s" target="_blank">GitHub</a> or, if you do not have an account, on the <a href="%2$s" target="_blank">support forum</a>.', 'marianne' ),
							$kses_allowed_html
						),
						esc_url( $gh_link_issues ),
						esc_url( $support_wp_link )
					);
					?>
				</p>

				<p><strong><?php esc_html_e( 'Translate', 'marianne' ); ?></strong></p>

				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %s: The URL of the language repository on GitHub. */
							__( 'You want to use Marianne in your language? You can help me to translate it on <a href="%1$s" target="_blank">GitHub</a> where a .pot file is available.', 'marianne' ),
							$kses_allowed_html
						),
						esc_url( $gh_link_translate )
					);
					?>
				</p>

				<p><strong><?php esc_html_e( 'Development', 'marianne' ); ?></strong></p>

				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %s: The URL of the Marianne repository on GitHub. */
							__( 'There are probably many technical improvements to be made to this theme. You can help me by <a href="%s" target="_blank">contributing on GitHub</a>.', 'marianne' ),
							$kses_allowed_html
						),
						esc_url( $gh_link )
					);
					?>
				</p>
			</div>


			<footer class="marianne-admin-footer">
				<div class="marianne-mif">
					<div class="marianne-flag">
						<span class="marianne-flag-blue"></span>
						<span class="marianne-flag-white"></span>
						<span class="marianne-flag-red"></span>
					</div>

					<div>
						<?php
						printf(
							wp_kses(
								/* translators: %s: The URL of the personal website of Teddy. */
								__( 'Made in France by <a href="%s" target="_blank">Teddy</a>', 'marianne' ),
								$kses_allowed_html
							),
							esc_url( 'https://chezteddy.fr/' )
						);
						?>
					</div>
				</div>
			</footer>
		</div>
	<?php
}
