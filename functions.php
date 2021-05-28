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
				'class'      => 'feather-icons sub-menu-toggle-icon',
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
			case '500px':
				$svg_data['name']   = _x( '500px', 'The name of the photography site.', 'marianne' );
				$svg_data['shapes'] = '<path d="M7.433 9.01A2.994 2.994 0 0 0 4.443 12a2.993 2.993 0 0 0 2.99 2.99 2.994 2.994 0 0 0 2.99-2.99 2.993 2.993 0 0 0-2.99-2.99m0 5.343A2.357 2.357 0 0 1 5.079 12a2.357 2.357 0 0 1 2.354-2.353A2.356 2.356 0 0 1 9.786 12a2.356 2.356 0 0 1-2.353 2.353m6.471-5.343a2.994 2.994 0 0 0-2.99 2.99 2.993 2.993 0 0 0 2.99 2.99 2.994 2.994 0 0 0 2.99-2.99 2.994 2.994 0 0 0-2.99-2.99m0 5.343A2.355 2.355 0 0 1 11.552 12a2.355 2.355 0 0 1 2.352-2.353A2.356 2.356 0 0 1 16.257 12a2.356 2.356 0 0 1-2.353 2.353m-11.61-3.55a2.1 2.1 0 0 0-1.597.423V9.641h2.687c.093 0 .16-.017.16-.292 0-.269-.108-.28-.18-.28H.39c-.174 0-.265.14-.265.294v2.602c0 .136.087.183.247.214.141.028.223.012.285-.057l.006-.01c.283-.408.9-.804 1.486-.732.699.086 1.262.644 1.34 1.327a1.512 1.512 0 0 1-1.5 1.685c-.636 0-1.19-.408-1.422-1.001-.035-.088-.092-.152-.343-.062-.229.083-.243.18-.212.268a2.11 2.11 0 0 0 1.976 1.386 2.102 2.102 0 0 0 .305-4.18M18.938 9.04c-.805.062-1.434.77-1.434 1.61v2.66c0 .155.117.187.293.187s.293-.031.293-.186v-2.668c0-.524.382-.974.868-1.024a.972.972 0 0 1 .758.247.984.984 0 0 1 .322.73c0 .08-.039.34-.217.58-.135.182-.39.399-.844.399h-.009c-.115 0-.215.005-.234.28-.013.186-.012.269.148.29.286.04.576-.016.865-.166.492-.256.822-.741.861-1.267a1.562 1.562 0 0 0-.452-1.222 1.56 1.56 0 0 0-1.218-.45m3.919 1.56l1.085-1.086c.04-.039.132-.132-.055-.324-.08-.083-.153-.125-.217-.125h-.001a.163.163 0 0 0-.121.058L22.46 10.21l-1.086-1.093c-.088-.088-.19-.067-.322.065-.135.136-.157.24-.069.328l1.086 1.092-1.064 1.064-.007.007c-.026.025-.065.063-.065.125-.001.063.042.139.126.223.07.071.138.107.2.107.069 0 .114-.045.139-.07l1.068-1.067 1.09 1.092a.162.162 0 0 0 .115.045h.002c.069 0 .142-.04.217-.118.122-.129.143-.236.06-.319z"/>';
				break;

			case 'chevron-down':
				$svg_data['name']   = 'chevron-down';
				$svg_data['shapes'] = '<polyline points="6 9 12 15 18 9"></polyline>';
				break;

			case 'diaspora':
				$svg_data['name']   = __( 'Diaspora', 'marianne' );
				$svg_data['shapes'] = '<path d="M15.257 21.928l-2.33-3.255c-.622-.87-1.128-1.549-1.155-1.55-.027 0-1.007 1.317-2.317 3.115-1.248 1.713-2.28 3.115-2.292 3.115-.035 0-4.5-3.145-4.51-3.178-.006-.016 1.003-1.497 2.242-3.292 1.239-1.794 2.252-3.29 2.252-3.325 0-.056-.401-.197-3.55-1.247a1604.93 1604.93 0 0 1-3.593-1.2c-.033-.013.153-.635.79-2.648.46-1.446.845-2.642.857-2.656.013-.015 1.71.528 3.772 1.207 2.062.678 3.766 1.233 3.787 1.233.021 0 .045-.032.053-.07.008-.039.026-1.794.04-3.902.013-2.107.036-3.848.05-3.87.02-.03.599-.038 2.725-.038 1.485 0 2.716.01 2.735.023.023.016.064 1.175.132 3.776.112 4.273.115 4.33.183 4.33.026 0 1.66-.547 3.631-1.216 1.97-.668 3.593-1.204 3.605-1.191.04.045 1.656 5.307 1.636 5.327-.011.01-1.656.574-3.655 1.252-2.75.932-3.638 1.244-3.645 1.284-.006.029.94 1.442 2.143 3.202 1.184 1.733 2.148 3.164 2.143 3.18-.012.036-4.442 3.299-4.48 3.299-.015 0-.577-.767-1.249-1.705z"/>';
				break;

			case 'email':
				$svg_data['name']   = __( 'Email', 'marianne' );
				$svg_data['shapes'] = '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline>';
				break;

			case 'facebook':
				$svg_data['name']   = __( 'Facebook', 'marianne' );
				$svg_data['shapes'] = '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>';
				break;

			case 'flickr':
				$svg_data['name']   = __( 'Facebook', 'marianne' );
				$svg_data['shapes'] = '<path d="M5.334 6.666C2.3884 6.666 0 9.055 0 12c0 2.9456 2.3884 5.334 5.334 5.334 2.9456 0 5.332-2.3884 5.332-5.334 0-2.945-2.3864-5.334-5.332-5.334zm13.332 0c-2.9456 0-5.332 2.389-5.332 5.334 0 2.9456 2.3864 5.334 5.332 5.334C21.6116 17.334 24 14.9456 24 12c0-2.945-2.3884-5.334-5.334-5.334Z"/>';
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

			case 'mastodon':
				$svg_data['name']   = __( 'Mastodon', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.193 7.88c0-5.207-3.411-6.733-3.411-6.733C18.062.357 15.108.025 12.041 0h-.076c-3.069.025-6.02.357-7.74 1.147 0 0-3.412 1.526-3.412 6.732 0 1.193-.023 2.619.015 4.13.124 5.092.934 10.11 5.641 11.355 2.17.574 4.034.695 5.536.612 2.722-.15 4.25-.972 4.25-.972l-.09-1.975s-1.945.613-4.13.54c-2.165-.075-4.449-.234-4.799-2.892a5.5 5.5 0 0 1-.048-.745s2.125.52 4.818.643c1.646.075 3.19-.097 4.758-.283 3.007-.359 5.625-2.212 5.954-3.905.517-2.665.475-6.508.475-6.508zm-4.024 6.709h-2.497v-6.12c0-1.29-.543-1.944-1.628-1.944-1.2 0-1.802.776-1.802 2.313v3.349h-2.484v-3.35c0-1.537-.602-2.313-1.802-2.313-1.085 0-1.628.655-1.628 1.945v6.119H4.831V8.285c0-1.29.328-2.314.987-3.07.68-.759 1.57-1.147 2.674-1.147 1.278 0 2.246.491 2.886 1.474L12 6.585l.622-1.043c.64-.983 1.608-1.474 2.886-1.474 1.104 0 1.994.388 2.674 1.146.658.757.986 1.781.986 3.07v6.305z"></path>';
				break;

			case 'phone':
				$svg_data['name']   = __( 'Phone', 'marianne' );
				$svg_data['shapes'] = '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line>';
				break;

			case 'reddit':
				$svg_data['name']   = __( 'Reddit', 'marianne' );
				$svg_data['shapes'] = '<path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.687-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z"/>';
				break;

			case 'rss':
				$svg_data['name']   = __( 'RSS Feed', 'marianne' );
				$svg_data['shapes'] = '<path d="M19.199 24C19.199 13.467 10.533 4.8 0 4.8V0c13.165 0 24 10.835 24 24h-4.801zM3.291 17.415c1.814 0 3.293 1.479 3.293 3.295 0 1.813-1.485 3.29-3.301 3.29C1.47 24 0 22.526 0 20.71s1.475-3.294 3.291-3.295zM15.909 24h-4.665c0-6.169-5.075-11.245-11.244-11.245V8.09c8.727 0 15.909 7.184 15.909 15.91z"/>';
				break;

			case 'spotify':
				$svg_data['name']   = __( 'Spotify', 'marianne' );
				$svg_data['shapes'] = '<path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"></path>';
				break;

			case 'twitch':
				$svg_data['name']   = __( 'Twitch', 'marianne' );
				$svg_data['shapes'] = '<path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714Z"/>';
				break;

			case 'twitter':
				$svg_data['name']   = __( 'Twitter', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>';
				break;

			case 'vimeo':
				$svg_data['name']   = __( 'Vimeo', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.9765 6.4168c-.105 2.338-1.739 5.5429-4.894 9.6088-3.2679 4.247-6.0258 6.3699-8.2898 6.3699-1.409 0-2.578-1.294-3.553-3.881l-1.9179-7.1138c-.719-2.584-1.488-3.878-2.312-3.878-.179 0-.806.378-1.8809 1.132l-1.129-1.457a315.06 315.06 0 003.501-3.1279c1.579-1.368 2.765-2.085 3.5539-2.159 1.867-.18 3.016 1.1 3.447 3.838.465 2.953.789 4.789.971 5.5069.5389 2.45 1.1309 3.674 1.7759 3.674.502 0 1.256-.796 2.265-2.385 1.004-1.589 1.54-2.797 1.612-3.628.144-1.371-.395-2.061-1.614-2.061-.574 0-1.167.121-1.777.391 1.186-3.8679 3.434-5.7568 6.7619-5.6368 2.4729.06 3.6279 1.664 3.4929 4.7969z"/>';
				break;

			case 'vk':
				$svg_data['name']   = __( 'VK', 'marianne' );
				$svg_data['shapes'] = '<path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.391 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1-1.49-1.135-1.744-1.135-.356 0-.458.102-.458.593v1.575c0 .424-.135.678-1.253.678-1.846 0-3.896-1.118-5.335-3.202C4.624 10.857 4.03 8.57 4.03 8.096c0-.254.102-.491.593-.491h1.744c.44 0 .61.203.78.677.863 2.49 2.303 4.675 2.896 4.675.22 0 .322-.102.322-.66V9.721c-.068-1.186-.695-1.287-.695-1.71 0-.204.17-.407.44-.407h2.744c.373 0 .508.203.508.643v3.473c0 .372.17.508.271.508.22 0 .407-.136.813-.542 1.254-1.406 2.151-3.574 2.151-3.574.119-.254.322-.491.763-.491h1.744c.525 0 .644.27.525.643-.22 1.017-2.354 4.031-2.354 4.031-.186.305-.254.44 0 .78.186.254.796.779 1.203 1.253.745.847 1.32 1.558 1.473 2.05.17.49-.085.744-.576.744z"/>';
				break;

			case 'youtube':
				$svg_data['name']   = __( 'YouTube', 'marianne' );
				$svg_data['shapes'] = '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>';
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
	 *                                           Default: 'simple-icons'.
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
			$class   = isset( $args['class'] ) ? $args['class'] : 'simple-icons';
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
