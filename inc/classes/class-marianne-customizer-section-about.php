<?php
/**
 * About Marianne Section Class.
 *
 * Based on the work of:
 *
 * @author    WPTRT <themes@wordpress.org>
 * @copyright 2019 WPTRT
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      https://github.com/WPTRT/customize-section-button
 *
 * @package Marianne
 * @since Marianne 1.3
 */

if ( class_exists( 'WP_Customize_Section' ) ) {
	/**
	 * Instantiate the object.
	 */
	class Marianne_Customizer_Section_About extends WP_Customize_Section {
		/**
		 * The type of about section being rendered.
		 *
		 * @access public
		 * @var    string
		 */
		public $type = 'marianne-about';

		/**
		 * The URL to output.
		 *
		 * @access public
		 * @var    string
		 */
		public $url = '';

		/**
		 * Default priority of the section.
		 *
		 * @access public
		 * @var    string
		 */
		public $priority = 999;

		/**
		 * Adds custom parameters to pass to the JS via JSON.
		 *
		 * @access public
		 * @return array
		 */
		public function json() {

			$json  = parent::json();
			$theme = wp_get_theme();
			$url   = $this->url;

			if ( ! $url && $theme->get( 'ThemeURI' ) ) {
				// Fall back to the 'Theme URI' defined in 'style.css'.
				$url = $theme->get( 'ThemeURI' );

			} elseif ( ! $url && $theme->get( 'AuthorURI' ) ) {
				// Fall back to the 'Author URL' defined in 'style.css'.
				$url = $theme->get( 'AuthorURI' );
			}

			$json['url'] = esc_url( $url );

			return $json;
		}

		/**
		 * Outputs the section.
		 *
		 * @access public
		 * @return void
		 */
		protected function render_template() {
			?>
				<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

					<h3 class="accordion-section-title">
						<a href="{{ data.url }}" title="<?php esc_attr_e( 'Close the Customizer and go to About Marianne page', 'marianne' ); ?>">
							{{ data.title }}

							<span class="screen-reader-text"><?php esc_html_e( 'Close the Customizer and go to About Marianne page', 'marianne' ); ?></span>
						</a>
					</h3>
				</li>
			<?php
		}
	}
}
