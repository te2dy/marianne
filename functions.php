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

			// Adds toggle button.
			$output .= '<button class="sub-menu-toggle" aria-haspopup="true" aria-expanded="false" onClick="marianneExpandSubMenu(this)">';

			// Displays the chevron SVG.
			$svg_chevron_data   = marianne_svg_icons( 'chevron-down' );
			$svg_chevron_shapes = $svg_chevron_data['shapes'];
			$svg_chevron_args   = array(
				'class'      => 'feather sub-menu-toggle-icon',
				'size'       => array( 12, 12 ),
				'echo'       => false,
				'aria-label' => __( 'Submenu opening icon', 'marianne' ),
			);

			$output .= marianne_esc_svg( marianne_svg( $svg_chevron_shapes, $svg_chevron_args ) );

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

if ( ! function_exists( 'marianne_svg_icons' ) ) {
	/**
	 * SVG shapes for social icons.
	 *
	 * @param string $name The id of the icon.
	 *
	 * @return array $svg_data The SVG image data.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_svg_icons( $name = '' ) {
		$svg_data = array(
			'name'    => '',
			'shapes'  => '',
			'viewbox' => '0 0 24 24',
		);

		switch ( $name ) {
			case 'chevron-down':
				$svg_data['name']   = 'chevron-down';
				$svg_data['shapes'] = '<polyline points="6 9 12 15 18 9"></polyline>';
				break;

			case 'email':
				$svg_data['name']   = __( 'Email', 'marianne' );
				$svg_data['shapes'] = '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>';
				break;

			case 'facebook':
				$svg_data['name']   = __( 'Facebook', 'marianne' );
				$svg_data['shapes'] = '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>';
				break;

			case 'github':
				$svg_data['name']   = __( 'GitHub', 'marianne' );
				$svg_data['shapes'] = '<path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>';
				break;

			case 'gitlab':
				$svg_data['name']   = __( 'GitLab', 'marianne' );
				$svg_data['shapes'] = '<path d="M4.845.904c-.435 0-.82.28-.955.692C2.639 5.449 1.246 9.728.07 13.335a1.437 1.437 0 00.522 1.607l11.071 8.045c.2.145.472.144.67-.004l11.073-8.04a1.436 1.436 0 00.522-1.61c-1.285-3.942-2.683-8.256-3.817-11.746a1.004 1.004 0 00-.957-.684.987.987 0 00-.949.69l-2.405 7.408H8.203l-2.41-7.408a.987.987 0 00-.942-.69h-.006zm-.006 1.42l2.173 6.678H2.675zm14.326 0l2.168 6.678h-4.341zm-10.593 7.81h6.862c-1.142 3.52-2.288 7.04-3.434 10.559L8.572 10.135zm-5.514.005h4.321l3.086 9.5zm13.567 0h4.325c-2.467 3.17-4.95 6.328-7.411 9.502 1.028-3.167 2.059-6.334 3.086-9.502zM2.1 10.762l6.977 8.947-7.817-5.682a.305.305 0 01-.112-.341zm19.798 0l.952 2.922a.305.305 0 01-.11.341v.002l-7.82 5.68.026-.035z"/>';
				break;

			case 'instagram':
				$svg_data['name']   = __( 'Instagram', 'marianne' );
				$svg_data['shapes'] = '<path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>';
				break;

			case 'link':
				$svg_data['name']   = __( 'Link', 'marianne' );
				$svg_data['shapes'] = '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>';
				break;

			case 'linkedin':
				$svg_data['name']   = __( 'LinkedIn', 'marianne' );
				$svg_data['shapes'] = '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>';
				break;

			case 'phone':
				$svg_data['name']   = __( 'Phone', 'marianne' );
				$svg_data['shapes'] = '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line>';
				break;

			case 'rss':
				$svg_data['name']   = __( 'RSS Feed', 'marianne' );
				$svg_data['shapes'] = '<path d="M19.199 24C19.199 13.467 10.533 4.8 0 4.8V0c13.165 0 24 10.835 24 24h-4.801zM3.291 17.415c1.814 0 3.293 1.479 3.293 3.295 0 1.813-1.485 3.29-3.301 3.29C1.47 24 0 22.526 0 20.71s1.475-3.294 3.291-3.295zM15.909 24h-4.665c0-6.169-5.075-11.245-11.244-11.245V8.09c8.727 0 15.909 7.184 15.909 15.91z"/>';
				break;

			case 'youtube':
				$svg_data['name']   = __( 'YouTube', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>';
				break;

			case 'vimeo':
				$svg_data['name']   = __( 'Vimeo', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.9765 6.4168c-.105 2.338-1.739 5.5429-4.894 9.6088-3.2679 4.247-6.0258 6.3699-8.2898 6.3699-1.409 0-2.578-1.294-3.553-3.881l-1.9179-7.1138c-.719-2.584-1.488-3.878-2.312-3.878-.179 0-.806.378-1.8809 1.132l-1.129-1.457a315.06 315.06 0 003.501-3.1279c1.579-1.368 2.765-2.085 3.5539-2.159 1.867-.18 3.016 1.1 3.447 3.838.465 2.953.789 4.789.971 5.5069.5389 2.45 1.1309 3.674 1.7759 3.674.502 0 1.256-.796 2.265-2.385 1.004-1.589 1.54-2.797 1.612-3.628.144-1.371-.395-2.061-1.614-2.061-.574 0-1.167.121-1.777.391 1.186-3.8679 3.434-5.7568 6.7619-5.6368 2.4729.06 3.6279 1.664 3.4929 4.7969z"/>';
				break;

			case 'twitch':
				$svg_data['name']   = __( 'Twitch', 'marianne' );
				$svg_data['shapes'] = '<path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714Z"/>';
				break;

			case 'twitter':
				$svg_data['name']   = __( 'Twitter', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>';
				break;

			case 'mastodon':
				$svg_data['name']   = __( 'Mastodon', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.193 7.88c0-5.207-3.411-6.733-3.411-6.733C18.062.357 15.108.025 12.041 0h-.076c-3.069.025-6.02.357-7.74 1.147 0 0-3.412 1.526-3.412 6.732 0 1.193-.023 2.619.015 4.13.124 5.092.934 10.11 5.641 11.355 2.17.574 4.034.695 5.536.612 2.722-.15 4.25-.972 4.25-.972l-.09-1.975s-1.945.613-4.13.54c-2.165-.075-4.449-.234-4.799-2.892a5.5 5.5 0 0 1-.048-.745s2.125.52 4.818.643c1.646.075 3.19-.097 4.758-.283 3.007-.359 5.625-2.212 5.954-3.905.517-2.665.475-6.508.475-6.508zm-4.024 6.709h-2.497v-6.12c0-1.29-.543-1.944-1.628-1.944-1.2 0-1.802.776-1.802 2.313v3.349h-2.484v-3.35c0-1.537-.602-2.313-1.802-2.313-1.085 0-1.628.655-1.628 1.945v6.119H4.831V8.285c0-1.29.328-2.314.987-3.07.68-.759 1.57-1.147 2.674-1.147 1.278 0 2.246.491 2.886 1.474L12 6.585l.622-1.043c.64-.983 1.608-1.474 2.886-1.474 1.104 0 1.994.388 2.674 1.146.658.757.986 1.781.986 3.07v6.305z"></path>';
				break;

			case 'spotify':
				$svg_data['name']   = __( 'Spotify', 'marianne' );
				$svg_data['shapes'] = '<path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"></path>';
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
	 * @param string $input SVG HTML to escape.
	 *
	 * @return string $output Escaped SVG.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_esc_svg( $input = '' ) {
		$allowed_html = array(
			'svg'      => array(
				'xmlns'      => array(),
				'role'       => array(),
				'class'      => array(),
				'id'         => array(),
				'viewbox'    => array(),
				'width'      => array(),
				'height'     => array(),
				'aria-label' => array(),
			),
			'title'    => array(),
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

		$output = wp_kses( $input, $allowed_html );
		return $output;
	}
}

if ( ! function_exists( 'marianne_svg' ) ) {
	/**
	 * Converts a Twitter username into a Twitter URL.
	 *
	 * @param string $shapes SVG shapes to displays.
	 * @param array  $args   Parameters to set.
	 *                       $args = array(
	 *                           'class'      => 'string' The class of the SVG image.
	 *                                           Default: 'icon'.
	 *                           'size'       => (array) The size of the image (width, height).
	 *                                           Default: array( 18, 18 ).
	 *                           'viewbox'    => (string) The viewBox attribute to add to the image.
	 *                                           Default: '0 0 24 24'.
	 *                           'echo'       => (bool) Whether to return or echo the SVG image.
	 *                                           Default: true.
	 *                           'aria_label' => (string) Label the image.
	 *                                           Default: ''.
	 *
	 * @return string|void $svg The SVG HTML.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_svg( $shapes = '', $args = array() ) {
		if ( is_array( $args ) && ! empty( $args ) ) {
			$class   = isset( $args['class'] ) ? $args['class'] : 'icon';
			$size    = isset( $args['size'] ) ? $args['size'] : array( 18, 18 );
			$viewbox = isset( $args['viewbox'] ) ? $args['viewbox'] : '0 0 24 24';

			if ( isset( $args['echo'] ) && is_bool( $args['echo'] ) ) {
				$echo = $args['echo'];
			} else {
				$echo = true;
			}

			$aria_label = isset( $args['aria-label'] ) ? $args['aria-label'] : '';
		}

		$svg  = '<svg xmlns="http://www.w3.org/2000/svg" role="img" aria-label="' . esc_attr( $aria_label ) . '" width="' . esc_attr( absint( $size[0] ) ) . '" height="' . esc_attr( absint( $size[1] ) ) . '" class="' . esc_attr( $class ) . '" viewBox="' . esc_attr( $viewbox ) . '">';
		$svg .= $shapes;
		$svg .= '</svg>';


		return $svg;
	}
}

// Loads required files.
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/custom-styles.php';
require get_template_directory() . '/inc/marianne-theme-page.php';
require get_template_directory() . '/inc/classes/class-marianne-customizer-control-slider.php';
require get_template_directory() . '/inc/classes/class-marianne-customizer-section-about.php';
