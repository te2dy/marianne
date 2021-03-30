<?php
/**
 * Functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Marianne
 * @since Marianne 1.0
 */

if ( ! function_exists( 'marianne_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @return void
	 */
	function marianne_setup() {
		// Load translation files.
		load_theme_textdomain( 'marianne', get_template_directory() . '/languages' );

		$marianne_page_width = marianne_get_theme_mod( 'marianne_global_page_width' );

		// Set content-width.
		if ( ! isset( $content_width ) ) {
			$content_width = absint( $marianne_page_width );
		}

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress use default document title.
		add_theme_support( 'title-tag' );

		/**
		 * Add support for custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'width'                => 300,
				'height'               => 300,
				'flex-width'           => false,
				'flex-height'          => false,
				'header-text'          => array(
					'site-title',
					'site-description',
				),
				'unlink-homepage-logo' => true,
			)
		);

		// Register the main menu.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'marianne' ),
				'footer'  => __( 'Footer Menu', 'marianne' ),
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 *
		 * @since Marianne 1.1
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'marianne-thumbnails', absint( $marianne_page_width ) );
		add_image_size( 'marianne-thumbnails-retina', ( absint( $marianne_page_width ) * 2 ) );

		// Add support for responsive oEmbed content.
		add_theme_support( 'responsive-embeds' );

		// HTML5 support.
		add_theme_support(
			'html5',
			array(
				'caption',
				'comment-form',
				'comment-list',
				'gallery',
				'navigation-widgets',
				'script',
				'search-form',
				'style',
			)
		);
	}

	add_action( 'after_setup_theme', 'marianne_setup' );
}

if ( ! function_exists( 'marianne_environment_type' ) ) {
	/**
	 * Get or set the environment type.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_get_environment_type/
	 *
	 * @return string The environment type.
	 */
	function marianne_environment_type() {
		if ( function_exists( 'wp_get_environment_type' ) ) {
			$environment_type = wp_get_environment_type();
		} else {
			$environment_type = 'production';
		}

		return $environment_type;
	}
}

if ( ! function_exists( 'marianne_minify' ) ) {
	/**
	 * Displays ".min" if the environment is set to "production".
	 *
	 * @return string Returns ".min" or nothing.
	 */
	function marianne_minify() {
		$environment_type = marianne_environment_type();

		if ( 'production' === $environment_type ) {
			$min = '.min';
		} else {
			$min = '';
		}

		return $min;
	}
}

if ( ! function_exists( 'marianne_styles_scripts' ) ) {
	/**
	 * Enqueues scripts and styles.
	 *
	 * On production, minified files are enqueued.
	 *
	 * @return void
	 */
	function marianne_styles_scripts() {
		$theme_version = wp_get_theme()->get( 'Version' );
		$min           = marianne_minify();

		// The main stylesheet.
		wp_enqueue_style( 'marianne-stylesheet', get_template_directory_uri() . "/style$min.css", array(), $theme_version );

		/**
		 * The main menu navigation script.
		 *
		 * @since Marianne 1.2
		 */
		wp_enqueue_script( 'marianne-navigation', get_template_directory_uri() . "/assets/js/navigation$min.js", array( 'jquery' ), $theme_version, true );

		// Threaded comment reply styles.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'marianne_styles_scripts' );
}

if ( ! function_exists( 'marianne_head_meta' ) ) {
	/**
	 * Adds meta in head.
	 *
	 * @return void
	 */
	function marianne_head_meta() {
		?>
			<meta charset="<?php bloginfo( 'charset' ); ?>" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php
	}

	add_action( 'wp_head', 'marianne_head_meta', 0 );
}

if ( ! function_exists( 'marianne_widgets' ) ) {
	/**
	 * Register widgets.
	 *
	 * @return void
	 */
	function marianne_widgets() {
		register_sidebar(
			array(
				'name'          => __( 'Widgets', 'marianne' ),
				'id'            => 'widgets',
				'before_widget' => '<section id="%1$s" class="%2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	add_action( 'widgets_init', 'marianne_widgets' );
}

if ( ! function_exists( 'marianne_add_sub_menu_toggle' ) ) {
	/**
	 * Adds a button to top-level menu items that has sub-menus.
	 * An icon is added using CSS depending on the value of aria-expanded.
	 *
	 * Based on the work of the WordPress team in the Twenty Twenty-One Theme.
	 *
	 * @param string $output Nav menu item start element.
	 * @param object $item   Nav menu item.
	 * @param int    $depth  Depth.
	 * @param object $args   Nav menu args.
	 *
	 * @return string Nav menu item start element.
	 */
	function marianne_add_sub_menu_toggle( $output, $item, $depth, $args ) {
		if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) && 'primary' === $args->theme_location ) {

			// Add toggle button.
			$output .= '<button class="sub-menu-toggle" aria-haspopup="true" aria-expanded="false" onClick="marianneExpandSubMenu(this)">';
			$output .= '+';
			$output .= '<span class="screen-reader-text">' . esc_html__( 'Open submenu', 'marianne' ) . '</span>';
			$output .= '</button>';
		}

		return $output;
	}

	add_filter( 'walker_nav_menu_start_el', 'marianne_add_sub_menu_toggle', 10, 4 );
}

if ( ! function_exists( 'marianne_add_class' ) ) {
	/**
	 * Adds class attribute.
	 *
	 * @param string $classes      Classes to add.
	 * @param bool   $space_before If true, adds a space before the attribute.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_add_class( $classes = '', $space_before = true ) {
		if ( true === $space_before ) {
			echo ' ';
		}

		echo 'class="' . esc_attr( $classes ) . '"';
	}
}

if ( ! function_exists( 'marianne_svg_feather_icons' ) ) {
	/**
	 * SVG date for social icons.
	 *
	 * All defined shapes in this function were made by Feather Icons:
	 *
	 * @author Cole Bemis
	 * @license https://opensource.org/licenses/mit-license.php
	 * @link https://feathericons.com/
	 *
	 * @param string $name The id of the icon.
	 *
	 * @return array $svg_data The SVG image data.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_svg_feather_icons( $name = '' ) {
		$svg_data = array(
			'name'    => '',
			'shapes'  => '',
			'viewbox' => '0 0 24 24',
		);

		switch ( $name ) {
			case 'email':
				$svg_data['name']   = __( 'Email', 'marianne' );
				$svg_data['shapes'] = '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>';
				break;

			case 'facebook':
				$svg_data['name']   = __( 'Facebook', 'marianne' );
				$svg_data['shapes'] = '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>';
				break;

			case 'github':
				$svg_data['name']   = __( 'GitHub', 'marianne' );
				$svg_data['shapes'] = '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>';
				break;

			case 'gitlab':
				$svg_data['name']   = __( 'GitLab', 'marianne' );
				$svg_data['shapes'] = '<path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 0 1-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 0 1 4.82 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0 1 18.6 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.51L23 13.45a.84.84 0 0 1-.35.94z"></path>';
				break;

			case 'instagram':
				$svg_data['name']   = __( 'Instagram', 'marianne' );
				$svg_data['shapes'] = '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>';
				break;

			case 'link':
				$svg_data['name']   = __( 'Link', 'marianne' );
				$svg_data['shapes'] = '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>';
				break;

			case 'linkedin':
				$svg_data['name']   = __( 'LinkedIn', 'marianne' );
				$svg_data['shapes'] = '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>';
				break;

			case 'phone':
				$svg_data['name']   = __( 'Phone', 'marianne' );
				$svg_data['shapes'] = '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line>';
				break;

			case 'rss':
				$svg_data['name']   = __( 'RSS Feed', 'marianne' );
				$svg_data['shapes'] = '<path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>';
				break;

			case 'youtube':
				$svg_data['name']   = __( 'YouTube', 'marianne' );
				$svg_data['shapes'] = '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>';
				break;

			case 'twitch':
				$svg_data['name']   = __( 'Twitch', 'marianne' );
				$svg_data['shapes'] = '<path d="M21 2H3v16h5v4l4-4h5l4-4V2zm-10 9V7m5 4V7"></path>';
				break;

			case 'twitter':
				$svg_data['name']   = __( 'Twitter', 'marianne' );
				$svg_data['shapes'] = '<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>';
				break;
		}

		return $svg_data;
	}
}

if ( ! function_exists( 'marianne_esc_svg' ) ) {
	/**
	 * Escapes shapes for SVG image.
	 *
	 * Returns allowed SVG path attributes only and remove others.
	 *
	 * @link https://www.w3.org/TR/SVG2/shapes.html
	 *
	 * @param string $shapes Path to escape.
	 * @param bool   $echo   Echo or return the value.
	 *
	 * @return string $shapes Escaped path.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_esc_svg( $shapes = '', $echo = true ) {
		$allowed_path = array(
			'circle'   => array(
				'cx' => array(),
				'cy' => array(),
				'r'  => array(),
			),
			'line'     => array(
				'x1' => array(),
				'y1' => array(),
				'x2' => array(),
				'y2' => array(),
			),
			'path'     => array(
				'd'    => array(),
				'fill' => array(),
			),
			'polygon'  => array(
				'points' => array(),
			),
			'polyline' => array(
				'points' => array(),
			),
			'rect'     => array(
				'x'      => array(),
				'y'      => array(),
				'width'  => array(),
				'height' => array(),
				'rx'     => array(),
				'ry'     => array(),
			),
		);

		if ( true === $echo ) {
			echo wp_kses( $shapes, $allowed_path );
		} else {
			return wp_kses( $shapes, $allowed_path );
		}
	}
}

if ( ! function_exists( 'marianne_svg' ) ) {
	/**
	 * Converts a Twitter username into a Twitter URL.
	 *
	 * @param string $shapes  SVG shapes to displays.
	 * @param string $class   The class of the container.
	 *                        To set multiple classes,
	 *                        separate them with a space.
	 *                        Example: $class = "class-1 class-2".
	 * @param array  $size    The size of the image (width, height).
	 * @param string $viewbox The viewBox attribute to add to the image.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_svg( $shapes = '', $class = 'feather', $size = array( 18, 18 ), $viewbox = '0 0 24 24' ) {
		?>
			<svg xmlns="http://www.w3.org/2000/svg" width="<?php echo esc_attr( absint( $size[0] ) ); ?>" height="<?php echo esc_attr( absint( $size[1] ) ); ?>" <?php marianne_add_class( $class, false ); ?> viewBox="<?php echo esc_attr( $viewbox ); ?>">
				<?php marianne_esc_svg( $shapes ); ?>
			</svg>
		<?php
	}
}

// Loads required files.
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/theme-page.php';
require get_template_directory() . '/inc/classes/class-marianne-customizer-control-slider.php';
