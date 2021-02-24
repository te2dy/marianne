<?php
/**
 * Functions and definitions
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

		// Set content-width.
		if ( ! isset( $content_width ) ) {
			$content_width = 600;
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
				'height'      => 200,
				'width'       => 200,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array(
					'site-title',
					'site-description',
				),
			)
		);

		// Register the main menu.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'marianne' ),
				'footer'  => __( 'Footer Menu', 'marianne' ),
			)
		);

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
		$environment_type = 'production';

		if ( function_exists( 'wp_get_environment_type' ) ) {
			$environment_type = wp_get_environment_type();
		}

		return $environment_type;
	}
}

if ( ! function_exists( 'marianne_minify' ) ) {
	/**
	 * Display ".min" if the environment is set to "production".
	 *
	 * @return string Returns ".min" or nothing.
	 */
	function marianne_minify() {
		$environment_type = marianne_environment_type();

		$min = '';
		if ( 'production' === $environment_type ) {
			$min = '.min';
		}

		return $min;
	}
}

if ( ! function_exists( 'marianne_styles_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void
	 */
	function marianne_styles_scripts() {
		$theme_info    = wp_get_theme();
		$theme_version = $theme_info->get( 'Version' );
		$min           = marianne_minify();

		/**
		 * The main stylesheet.
		 *
		 * On production, the minified stylesheet is enqueued.
		 *
		 * @see marianne_minify()
		 */
		wp_enqueue_style( 'stylesheet', esc_url( get_template_directory_uri() . "/style$min.css" ), array(), esc_attr( $theme_version ) );

		wp_enqueue_script( 'navigation', esc_url( get_template_directory_uri() . "/js/navigation$min.js" ), array( 'jquery' ), esc_attr( $theme_version ), true );

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

// Load required files.
require_once get_template_directory() . '/inc/template-tags.php';

/* POUR LE MENU */
function marianne_add_sub_menu_toggle( $output, $item, $depth, $args ) {
	if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add toggle button.
		$output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="marianneExpandSubMenu(this)">';
		$output .= '<span class="icon-plus">+</span>';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Open submenu', 'twentytwentyone' ) . '</span>';
		$output .= '</button>';
	}
	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'marianne_add_sub_menu_toggle', 10, 4 );