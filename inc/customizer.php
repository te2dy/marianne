<?php
/**
 * Marianne customizing.
 *
 * This file adds customization options in the Theme Customizer.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Marianne
 * @since Marianne 1.3
 */

if ( ! function_exists( 'marianne_customizer_scripts_styles' ) ) {
	/**
	 * Enqueues Theme Customizer scripts and styles.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_customizer_scripts_styles() {
		$theme_version = wp_get_theme()->get( 'Version' );
		$min           = marianne_minify();

		// Enqueue custom sections and controls files.
		wp_enqueue_style( 'marianne-customizer-controls', get_template_directory_uri() . "/assets/css/customizer-controls$min.css", array( 'dashicons' ), $theme_version );
		wp_enqueue_script( 'marianne-customizer-controls', get_template_directory_uri() . "/assets/js/customizer-controls$min.js", array( 'jquery', 'jquery-ui-slider', 'customize-preview' ), $theme_version, true );

		// Enqueue the script that shows/hides other controls depending on the context.
		wp_enqueue_script( 'marianne-customizer-controls-change', get_template_directory_uri() . "/assets/js/customizer-controls-change$min.js", array( 'jquery', 'customize-preview' ), $theme_version, true );
	}

	add_action( 'customize_controls_enqueue_scripts', 'marianne_customizer_scripts_styles' );
}

if ( ! function_exists( 'marianne_customizer_script_live' ) ) {
	/**
	 * Enqueues Theme Customizer live preview script.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_customizer_script_live() {
		$theme_version = wp_get_theme()->get( 'Version' );
		$min           = marianne_minify();

		wp_enqueue_script( 'marianne-customizer-live', get_template_directory_uri() . "/assets/js/customizer-live-preview$min.js", array( 'jquery', 'customize-preview' ), $theme_version, true );

		$marianne_localize_script = array(
			'default_search_text' => esc_html_x( 'Search', 'The search button text.', 'marianne' ),
		);

		wp_localize_script( 'marianne-customizer-live', 'marianne_live', $marianne_localize_script );
	}

	add_action( 'customize_preview_init', 'marianne_customizer_script_live' );
}

if ( ! function_exists( 'marianne_customize_register' ) ) {
	/**
	 * Adds various options to the theme.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/customize_register/
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_customize_register( $wp_customize ) {
		/**
		 * Creates new sections in the Theme Customizer.
		 *
		 * @link https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
		 */
		$wp_customize->add_section(
			'marianne_global',
			array(
				'title' => __( 'Global Settings', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_header',
			array(
				'title' => __( 'Header Settings', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_content',
			array(
				'title'       => __( 'Content Formatting', 'marianne' ),
				'description' => __( 'The following settings apply to the main content of posts and pages.', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_loop',
			array(
				'title' => __( 'Post List Settings', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_post',
			array(
				'title' => __( 'Post Settings', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_footer',
			array(
				'title' => __( 'Footer Settings', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_social',
			array(
				'title' => __( 'Social Links', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_print',
			array(
				'title'       => __( 'Print Settings', 'marianne' ),
				'description' => __( 'These settings only apply to the printing of the pages of your site.', 'marianne' ),
			)
		);

		/**
		 * Creates a new section linked to the About Marianne page.
		 *
		 * Based on the work of:
		 *
		 * @author    WPTRT <themes@wordpress.org>
		 * @copyright 2019 WPTRT
		 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
		 * @link      https://github.com/WPTRT/customize-section-button
		 *
		 * @since Marianne 1.3
		 */
		$wp_customize->register_section_type( 'Marianne_Customizer_Section_About' );

		$wp_customize->add_section(
			new Marianne_Customizer_Section_About(
				$wp_customize,
				'marianne_about',
				array(
					'title' => __( 'About Marianne', 'marianne' ),
					'url'   => admin_url( 'themes.php?page=marianne-theme-page' ),
				)
			)
		);

		// Adds live preview to the site's name and description.
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		/**
		 * Lists new options to add to the Customizer.
		 *
		 * To simplify the build of the Customizer, all new options are pushed in an array.
		 * The Customizer will be built later.
		 *
		 * @return array $marianne_customizer_options An array of new options that follows this pattern:
		 *                                            $marianne_customizer_options[] = array(
		 *                                                'section'     => (string) The section of the option,
		 *                                                'id'          => (string) The option id,
		 *                                                'title'       => (string) The title of the option,
		 *                                                'description' => (string) The description of the option,
		 *                                                'type'        => (string) The type of the option (text, checkbox…),
		 *                                                'input_attrs' => (array)  Some parameters to apply to the control
		 *                                                                          Required for the type ’marianne_slider’,
		 *                                                'value'       => (array)  The value of the option,
		 *                                                'live'        => (bool)   Enable/disable live preview,
		 *                                            );
		 */
		$marianne_customizer_options = array();

		// Colors.
		$marianne_customizer_options[] = array(
			'section'     => 'colors',
			'id'          => 'scheme',
			'title'       => __( 'Color Scheme', 'marianne' ),
			'description' => __( 'The automatic mode chooses between light and dark color scheme depending on the settings of the operating system or browser of your visitors. The background color of the dark color scheme is "intrinsic gray", which is the color seen by the human eye in total darkness. Default: light.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'light' => __( 'Light', 'marianne' ),
				'dark'  => __( 'Dark', 'marianne' ),
				'auto'  => __( 'Auto', 'marianne' ),
			),
			'live'        => true,
		);
		$marianne_customizer_options[] = array(
			'section'     => 'colors',
			'id'          => 'link_hover',
			'title'       => __( 'Hovered elements', 'marianne' ),
			'description' => __( 'Color used for link and button hovering. Default: blue.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'blue'   => __( 'Blue', 'marianne' ),
				'red'    => __( 'Red', 'marianne' ),
				'green'  => __( 'Green', 'marianne' ),
				'orange' => __( 'Orange', 'marianne' ),
				'purple' => __( 'Purple', 'marianne' ),
			),
			'live'        => true,
		);

		// Global.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_global',
			'id'          => 'layout',
			'title'       => __( 'Layout', 'marianne' ),
			'description' => __( 'You can choose to display your site in one or two columns, with a left sidebar. Default: one column.', 'marianne' ),
			'type'        => 'radio',
			'value'       => array(
				'one-column'              => __( 'One column', 'marianne' ),
				'two-column-left-sidebar' => __( 'Two columns with a left sidebar', 'marianne' ),
			),
			'live'        => false,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_global',
			'id'          => 'page_width',
			'title'       => __( 'Page Width', 'marianne' ),
			'description' => __( 'If you increase the width of the page, your featured images may become too small. In this case, you should regenerate their thumbnails with a plugins (recommended). Or you can enable the next option. Default: 480px.', 'marianne' ),
			'type'        => 'marianne_slider',
			'input_attrs' => array(
				'min'  => 480,
				'max'  => 1080,
				'step' => 10,
			),
			'live'        => false,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_global',
			'id'          => 'images_expand',
			'title'       => __( 'Expand featured images that are not wide enough.', 'marianne' ),
			'description' => __( 'This can make the images a bit blurry. This is less efficient than regenerating the images. Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_global',
			'id'          => 'font_family',
			'title'       => __( 'Font Family', 'marianne' ),
			'description' => __( "Choose the font family you want to apply to your site. Your readers' device will render the pages with its own system font. Please note that the rendering may vary from device to device. Default: Sans serif.", 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'sans-serif' => __( 'Sans serif', 'marianne' ),
				'serif'      => __( 'Serif', 'marianne' ),
				'monospace'  => __( 'Monospaced', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_global',
			'id'          => 'font_size',
			'title'       => __( 'Font Size', 'marianne' ),
			'description' => __( 'The main font size. Default: 100%.', 'marianne' ),
			'type'        => 'marianne_slider',
			'input_attrs' => array(
				'min'  => 80,
				'max'  => 120,
				'step' => 10,
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_global',
			'id'          => 'font_smooth',
			'title'       => __( 'Force anti-aliasing.', 'marianne' ),
			'description' => __( 'By default, the browser automatically chooses whether or not to smooth the fonts. By checking this box, you will ask it to smooth them. Default: unckecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_global',
			'id'          => 'text_shadow',
			'title'       => __( 'Enable text shadow.', 'marianne' ),
			'description' => __( 'Give some relief to your texts. Default: disabled.', 'marianne' ),
			'type'        => 'checkbox',
			'live'        => true,
		);

		// Header Settings.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_header',
			'id'          => 'align',
			'title'       => __( 'Header Align', 'marianne' ),
			'description' => __( 'Default: left.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'left'   => __( 'Left', 'marianne' ),
				'center' => __( 'Center', 'marianne' ),
				'right'  => __( 'Right', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_header',
			'id'          => 'logo_round',
			'title'       => __( 'Make the logo round.', 'marianne' ),
			'description' => __( 'Only applies if a logo is set (see the Site Identity section). Default: unckecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_header',
			'id'          => 'title_weight',
			'title'       => __( 'Font weight of the site title', 'marianne' ),
			'description' => __( 'Default: bolder.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'normal' => __( 'Normal', 'marianne' ),
				'bold'   => __( 'Bold', 'marianne' ),
				'bolder' => __( 'Bolder', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_header',
			'id'          => 'desc_weight',
			'title'       => __( 'Font weight of the site description', 'marianne' ),
			'description' => __( 'Default: normal.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'thin'   => __( 'Thin', 'marianne' ),
				'normal' => __( 'Normal', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_header',
			'id'          => 'desc_style',
			'title'       => __( 'Font style of the site description', 'marianne' ),
			'description' => __( 'Default: normal.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'normal' => __( 'Normal', 'marianne' ),
				'italic' => __( 'Italic', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_header',
			'id'          => 'menu_search',
			'title'       => __( 'Add a search button.', 'marianne' ),
			'description' => __( 'It will be added as a primary menu item if a menu is set. Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_header',
			'id'          => 'menu_search_text',
			'title'       => __( 'Search button text', 'marianne' ),
			'description' => __( 'You can customize the button text. Leave blank to use the default text (Search).', 'marianne' ),
			'type'        => 'text',
		);

		// Content Formatting.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_content',
			'id'          => 'text_align',
			'title'       => __( 'Text Align', 'marianne' ),
			'description' => __( 'It does not prevent to choose a particular alignment in the text editor. Default: left.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'left'    => __( 'Left', 'marianne' ),
				'center'  => __( 'Center', 'marianne' ),
				'right'   => __( 'Right', 'marianne' ),
				'justify' => __( 'Justify', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_content',
			'id'          => 'hyphens',
			'title'       => __( 'Enable hyphenation.', 'marianne' ),
			'description' => __( 'Breaks some words in half so that they continue on another line rather than moving them entirely to the next line. Especially useful when the text alignment is set to "justify". Default: disabled.', 'marianne' ),
			'type'        => 'checkbox',
			'live'        => true,
		);

		// Post List Settings.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_loop',
			'id'          => 'author_name',
			'title'       => __( "Display the author's name.", 'marianne' ),
			'description' => __( 'Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_loop',
			'id'          => 'author_name_prefix',
			'title'       => __( "Add a prefix to the author's name.", 'marianne' ),
			'description' => __( 'By John Doe. Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_loop',
			'id'          => 'author_avatar',
			'title'       => __( "Display the author's avatar.", 'marianne' ),
			'description' => __( 'Make sure avatars are enabled in Settings > Discussion. Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_loop',
			'id'          => 'post_time',
			'title'       => __( 'Display the post published time after the date.', 'marianne' ),
			'description' => __( 'Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_loop',
			'id'          => 'comment_link_text',
			'title'       => __( 'Text of the comment link when there are no comments yet', 'marianne' ),
			'description' => __( 'For example, "No comments" or "Write a comment". Default: empty.', 'marianne' ),
			'type'        => 'text',
		);

		// Post Settings.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_post',
			'id'          => 'post_time',
			'title'       => __( 'Display the post published time after the date.', 'marianne' ),
			'description' => __( 'Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section' => 'marianne_post',
			'id'      => 'author_position',
			'title'   => __( "Position of the author's identity", 'marianne' ),
			'value'   => array(
				'none'   => __( 'Not displayed (default)', 'marianne' ),
				'top'    => __( 'Post header', 'marianne' ),
				'bottom' => __( 'Bottom of the post', 'marianne' ),
			),
			'type'    => 'radio',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_post',
			'id'          => 'author_info',
			'title'       => __( "Author's info to display", 'marianne' ),
			'description' => __( 'Before displaying avatars, make sure that they are enabled in Settings > Discussion.', 'marianne' ),
			'value'       => array(
				'name'        => __( 'Name', 'marianne' ),
				'avatar'      => __( 'Avatar', 'marianne' ),
				'name_avatar' => __( 'Name & avatar', 'marianne' ),
			),
			'type'        => 'radio',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_post',
			'id'          => 'author_avatar',
			'title'       => __( "Display the author's avatar.", 'marianne' ),
			'description' => __( 'Default: checked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_post',
			'id'          => 'author_name_prefix',
			'title'       => __( "Add a prefix to the author's name.", 'marianne' ),
			'description' => __( 'Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_post',
			'id'          => 'author_bio',
			'title'       => __( "Display the author's biographical info.", 'marianne' ),
			'description' => __( 'Only if this info is set on the profile of the author. Default: checked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_post',
			'id'          => 'nav',
			'title'       => __( 'Display a link to the next and the previous post.', 'marianne' ),
			'description' => __( 'Default: unchecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		// Footer Settings.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_footer',
			'id'          => 'align',
			'title'       => __( 'Footer Align', 'marianne' ),
			'description' => __( 'Default: left.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'left'   => __( 'Left', 'marianne' ),
				'center' => __( 'Center', 'marianne' ),
				'right'  => __( 'Right', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_footer',
			'id'          => 'text',
			'title'       => __( 'Footer Text', 'marianne' ),
			'description' => __( 'You can write any text to add in the footer.', 'marianne' ),
			'type'        => 'textarea',
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_footer',
			'id'          => 'mention',
			'title'       => __( 'Display the default footer mention.', 'marianne' ),
			'description' => __( 'Useful to promote WordPress and Marianne to your readers. Default: displayed.', 'marianne' ),
			'type'        => 'checkbox',
		);

		// Social Links.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'location',
			'title'       => __( 'Where do you want to display your social links?', 'marianne' ),
			'description' => __( 'Default: footer.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'header' => __( 'Header', 'marianne' ),
				'footer' => __( 'Footer', 'marianne' ),
			),
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'style',
			'title'       => __( 'How do you want to display your social links?', 'marianne' ),
			'description' => __( 'Default: square.', 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'square' => __( 'Square', 'marianne' ),
				'round'  => __( 'Round', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'target_blank',
			'title'       => __( 'Open links in a new tab.', 'marianne' ),
			'description' => __( 'Default: unckecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'twitter',
			'title'       => __( 'Twitter', 'marianne' ),
			'description' => __( 'Your Twitter @username. Do not forget the at symbol.', 'marianne' ),
			'type'        => 'text',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'mastodon',
			'title'       => __( 'Mastodon', 'marianne' ),
			'description' => __( 'Your Mastodon profile URL.', 'marianne' ),
			'type'        => 'text',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'facebook',
			'title'       => __( 'Facebook', 'marianne' ),
			'description' => __( 'Your Facebook profile or page URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'diaspora',
			'title'       => __( 'Diaspora', 'marianne' ),
			'description' => __( 'Your Diaspora profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'vk',
			'title'       => __( 'VK', 'marianne' ),
			'description' => __( 'Your VK profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'instagram',
			'title'       => __( 'Instagram', 'marianne' ),
			'description' => __( 'Your Instagram profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'flickr',
			'title'       => __( 'Flickr', 'marianne' ),
			'description' => __( 'Your Flickr page URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => '500px',
			'title'       => _x( '500px', 'The name of the photography site.', 'marianne' ),
			'description' => __( 'Your 500px page URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'youtube',
			'title'       => __( 'YouTube', 'marianne' ),
			'description' => __( 'Your YouTube channel URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'vimeo',
			'title'       => __( 'Vimeo', 'marianne' ),
			'description' => __( 'Your Vimeo page URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'spotify',
			'title'       => __( 'Spotify', 'marianne' ),
			'description' => __( 'The URL of the Spotify page you want to share.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'linkedin',
			'title'       => __( 'LinkedIn', 'marianne' ),
			'description' => __( 'Your LinkedIn profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'github',
			'title'       => __( 'GitHub', 'marianne' ),
			'description' => __( 'Your GitHub profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'gitlab',
			'title'       => __( 'GitLab', 'marianne' ),
			'description' => __( 'Your GitLab profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'twitch',
			'title'       => __( 'Twitch', 'marianne' ),
			'description' => __( 'Your Twitch profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'reddit',
			'title'       => __( 'Reddit', 'marianne' ),
			'description' => __( 'Your Reddit profile URL.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'email',
			'title'       => __( 'Email', 'marianne' ),
			'description' => __( 'Your email address.', 'marianne' ),
			'type'        => 'email',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'phone',
			'title'       => __( 'Phone', 'marianne' ),
			'description' => __( 'Your phone number (without spaces).', 'marianne' ),
			'type'        => 'text',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'phone_type',
			'title'       => __( 'What type of phone link do you want to add?', 'marianne' ),
			'description' => __( "This will automatically open the right application on your readers' phone when they will click on it.", 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'classic'  => __( 'Classic', 'marianne' ),
				'sms'      => __( 'SMS', 'marianne' ),
				'whatsapp' => __( 'WhatsApp', 'marianne' ),
			),
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'link',
			'title'       => __( 'Link', 'marianne' ),
			'description' => __( 'Any link you want to display.', 'marianne' ),
			'type'        => 'url',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_social',
			'id'          => 'rss',
			'title'       => __( 'Add a link to the RSS feed of your site.', 'marianne' ),
			'description' => __( 'Default: unckecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		// Print Settings.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_print',
			'id'          => 'comments_hide',
			'title'       => __( 'Hide comments.', 'marianne' ),
			'description' => __( 'Check to hide comments when priting a post or page. In any case, the comment form will be hidden. Default: checked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_print',
			'id'          => 'widgets_hide',
			'title'       => __( 'Hide widgets.', 'marianne' ),
			'description' => __( 'Check to hide your widgets when priting a post or page. Default: checked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_print',
			'id'          => 'url',
			'title'       => __( 'Display URL of links.', 'marianne' ),
			'description' => __( 'URLs will be visible on print so that readers can see them and visit them. Default: checked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_print',
			'id'          => 'info',
			'title'       => __( 'Display information related to printing.', 'marianne' ),
			'description' => __( 'Adds the date the post or page was retrieved and a short link to access the content. Default: checked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		/**
		 * Finally, adds settings and controls to the Theme Customizer.
		 *
		 * Iterates the options put in the array $marianne_customizer_settings
		 * to add them in the Customizer.
		 */

		// Gets the default values of the options.
		$options_default = marianne_options_default();

		// Iterates.
		foreach ( $marianne_customizer_options as $option ) {
			// Gets option values.
			$section     = ! empty( $option['section'] ) ? $option['section'] : '';
			$id          = ! empty( $option['id'] ) ? $option['id'] : '';
			$type        = ! empty( $option['type'] ) ? $option['type'] : '';
			$title       = ! empty( $option['title'] ) ? $option['title'] : '';
			$description = ! empty( $option['description'] ) ? $option['description'] : '';
			$value       = ! empty( $option['value'] ) ? $option['value'] : '';
			$input_attrs = ! empty( $option['input_attrs'] ) ? $option['input_attrs'] : null;

			// Sets up live preview.
			if ( ! empty( $option['live'] ) && true === $option['live'] ) {
				$live = 'postMessage';
			} else {
				$live = 'refresh';
			}

			/**
			 * Sets the option name.
			 *
			 * Options add to new settings will be named this way:
			 * 'marianne_customesection_option'
			 */
			if ( $section && $id ) {
				$option_name = $section . '_' . $id;
			} else {
				$option_name = '';
			}

			if ( $option_name ) {
				// Gets the default values of options.
				$option_default = $options_default[ $option_name ];

				// Calls the right sanitization function depending on the type of the option.
				if ( 'marianne_social_twitter' !== $option_name && 'marianne_social_email' !== $option_name && 'marianne_social_phone' !== $option_name ) {
					switch ( $type ) {
						case 'radio':
						case 'select':
							$sanitize_callback = 'marianne_sanitize_radio_select';
							break;

						case 'checkbox':
							$sanitize_callback = 'marianne_sanitize_checkbox';
							break;

						case 'textarea':
							$sanitize_callback = 'sanitize_textarea_field';
							break;

						case 'slider':
							$sanitize_callback = 'marianne_sanitize_slider';
							break;

						case 'url':
							$sanitize_callback = 'esc_url_raw';
							break;

						case 'text':
							$sanitize_callback = 'wp_filter_nohtml_kses';
							break;

						default:
							$sanitize_callback = 'esc_html';
							break;
					}
				} elseif ( 'marianne_social_twitter' === $option_name ) {
					$sanitize_callback = 'marianne_sanitize_twitter';
				} elseif ( 'marianne_social_email' === $option_name ) {
					$sanitize_callback = 'sanitize_email';
				} elseif ( 'marianne_social_phone' === $option_name ) {
					$sanitize_callback = 'marianne_sanitize_phone';
				}

				// Creates the setting.
				$wp_customize->add_setting(
					sanitize_key( $option_name ),
					array(
						'default'           => sanitize_key( $option_default ),
						'capability'        => 'edit_theme_options',
						'sanitize_callback' => $sanitize_callback,
						'transport'         => $live,
					)
				);

				if ( 'select' !== $type && 'radio' !== $type ) {
					$value_type = 'value';
				} else {
					$value_type = 'choices';
				}

				// Creates the control.
				$others_controles = array( 'marianne_slider' );

				if ( ! in_array( $type, $others_controles, true ) ) {
					$wp_customize->add_control(
						new WP_Customize_Control(
							$wp_customize,
							sanitize_key( $option_name ),
							array(
								'label'       => esc_html( $title ),
								'description' => esc_html( $description ),
								'section'     => esc_html( $section ),
								'type'        => esc_html( $type ),
								$value_type   => $value,
							)
						)
					);
				} elseif ( 'marianne_slider' === $type ) {
					$wp_customize->add_control(
						new Marianne_Customizer_Control_Slider(
							$wp_customize,
							esc_html( $option_name ),
							array(
								'label'       => esc_html( $title ),
								'description' => esc_html( $description ),
								'section'     => esc_html( $section ),
								'input_attrs' => $input_attrs,
							)
						)
					);
				}
			}
		}
	}

	add_action( 'customize_register', 'marianne_customize_register' );
}

if ( ! function_exists( 'marianne_options_default' ) ) {
	/**
	 * Sets the default values of options.
	 *
	 * @param string $option The option to retrieve the default value (optional).
	 *
	 * @return string|array $output If an option is set, return the value of its default options.
	 *                              Otherwise, return an array with the default values of all the options.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_options_default( $option = '' ) {
		$output = '';

		// The array of default values.
		$options_default = array(
			// Colors.
			'colors_scheme'     => 'light',
			'colors_link_hover' => 'blue',

			// Global.
			'marianne_global_layout'        => 'one-column',
			'marianne_global_page_width'    => 480,
			'marianne_global_images_expand' => false,
			'marianne_global_font_family'   => 'sans-serif',
			'marianne_global_font_size'     => 100,
			'marianne_global_font_smooth'   => false,
			'marianne_global_text_shadow'   => false,

			// Header Settings.
			'marianne_header_align'            => 'left',
			'marianne_header_title_weight'     => 'bolder',
			'marianne_header_desc_weight'      => 'normal',
			'marianne_header_desc_style'       => 'normal',
			'marianne_header_logo_round'       => false,
			'marianne_header_menu_search'      => false,
			'marianne_header_menu_search_text' => '',

			// Content Formatting.
			'marianne_content_text_align' => 'left',
			'marianne_content_hyphens'    => false,

			// Post List Settings.
			'marianne_loop_author_name'        => false,
			'marianne_loop_author_name_prefix' => false,
			'marianne_loop_author_avatar'      => false,
			'marianne_loop_post_time'          => false,
			'marianne_loop_comment_link_text'  => '',

			// Post Settings.
			'marianne_post_post_time'          => false,
			'marianne_post_author_position'    => 'none',
			'marianne_post_author_info'        => 'name',
			'marianne_post_author_avatar'      => true,
			'marianne_post_author_name_prefix' => false,
			'marianne_post_author_bio'         => true,
			'marianne_post_nav'                => false,

			// Footer Settings.
			'marianne_footer_align'   => 'left',
			'marianne_footer_mention' => true,
			'marianne_footer_text'    => '',

			// Social Links.
			'marianne_social_location'     => 'footer',
			'marianne_social_style'        => 'square',
			'marianne_social_target_blank' => false,
			'marianne_social_twitter'      => '',
			'marianne_social_mastodon'     => '',
			'marianne_social_facebook'     => '',
			'marianne_social_diaspora'     => '',
			'marianne_social_instagram'    => '',
			'marianne_social_linkedin'     => '',
			'marianne_social_500px'        => '',
			'marianne_social_flickr'       => '',
			'marianne_social_youtube'      => '',
			'marianne_social_vimeo'        => '',
			'marianne_social_spotify'      => '',
			'marianne_social_email'        => '',
			'marianne_social_github'       => '',
			'marianne_social_gitlab'       => '',
			'marianne_social_link'         => '',
			'marianne_social_phone'        => '',
			'marianne_social_phone_type'   => 'classic',
			'marianne_social_rss'          => false,
			'marianne_social_twitch'       => '',
			'marianne_social_reddit'       => '',
			'marianne_social_vk'           => '',

			// Print Settings.
			'marianne_print_comments_hide' => true,
			'marianne_print_widgets_hide'  => true,
			'marianne_print_url'           => true,
			'marianne_print_info'          => true,
		);

		if ( ! $option ) {
			$output = $options_default;
		} elseif ( array_key_exists( $option, $options_default ) ) {
			$output = $options_default[ $option ];
		}

		return $output;
	}
}

if ( ! function_exists( 'marianne_get_theme_mod' ) ) {
	/**
	 * A custom get_theme_mod() function.
	 *
	 * It gets automatically the default value of the option.
	 *
	 * @param string $id The id of the option.
	 *
	 * @return string The value of the option.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_get_theme_mod( $id ) {
		$output = '';

		$options_default = marianne_options_default();

		if ( $id && array_key_exists( $id, $options_default ) ) {
			$default = $options_default[ $id ];
			$output  = get_theme_mod( $id, $default );
		}

		return $output;
	}
}

if ( ! function_exists( 'marianne_sanitize_radio_select' ) ) {
	/**
	 * Radio and select sanitization.
	 *
	 * Based on the work of the WordPress Theme Review Team:
	 *
	 * @copyright Copyright (c) 2015, WordPress Theme Review Team
	 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
	 *
	 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
	 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
	 *
	 * @param string               $input   Radio or select value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 *
	 * @return integer Sanitized value.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_sanitize_radio_select( $input, $setting ) {
		$input   = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;

		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

if ( ! function_exists( 'marianne_sanitize_checkbox' ) ) {
	/**
	 * Checkbox sanitization.
	 *
	 * @param string $input Checkbox value to sanitize.
	 *
	 * @return bool Sanitized value.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_sanitize_checkbox( $input ) {
		return ( isset( $input ) && false !== $input ) ? true : false;
	}
}

if ( ! function_exists( 'marianne_sanitize_slider' ) ) {
	/**
	 * Slider sanitization.
	 *
	 * @param number               $input   Slider value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 *
	 * @return number Sanitized value.
	 *
	 * Based on the work of:
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 *
	 * @since Marianne 1.3
	 */
	function marianne_sanitize_slider( $input, $setting ) {
		$attrs = $setting->manager->get_control( $setting->id )->input_attrs;

		$min  = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );
		$max  = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );
		$step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

		$number = floor( $input / $attrs['step'] ) * $attrs['step'];

		return marianne_in_range( $number, $min, $max );
	}
}

if ( ! function_exists( 'marianne_in_range' ) ) {
	/**
	 * Only allows values between a certain minimum & maximum range.
	 *
	 * @param number $input Input to be sanitized.
	 * @param number $min   The min value of the input.
	 * @param number $max   The max value of the input.
	 *
	 * @return number Sanitized input.
	 *
	 * Based on the work of:
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 *
	 * @since Marianne 1.3
	 */
	function marianne_in_range( $input, $min, $max ) {
		if ( $input < $min ) {
			$input = $min;
		}

		if ( $input > $max ) {
			$input = $max;
		}

		return $input;
	}
}

if ( ! function_exists( 'marianne_sanitize_twitter' ) ) {
	/**
	 * Twitter username sanitization.
	 *
	 * @param string $input The desired username.
	 *
	 * @return string The username, if it matches the regular expression.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_sanitize_twitter( $input ) {
		$output = '';

		if ( $input ) {
			if ( preg_match( '/^\@[A-Za-z0-9_]{1,15}$/', $input ) ) {
				$output = $input;
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'marianne_sanitize_phone' ) ) {
	/**
	 * Phone number sanitization.
	 *
	 * @param string $input The number to sanitize.
	 *
	 * @return bool Sanitized number.
	 *
	 * @since Marianne 1.3
	 */
	function marianne_sanitize_phone( $input ) {
		$output = '';

		if ( preg_match( '/\+?[0-9]+/', $input, $match ) ) {
			$output = $match[0];
		}

		return $output;
	}
}

if ( ! function_exists( 'marianne_sanitize_phone' ) ) {
	/**
	 * Email sanitization.
	 *
	 * @param string $input The email to sanitize.
	 *
	 * @return bool Sanitized email.
	 *
	 * @since Marianne 1.?
	 */
	function marianne_sanitize_phone( $input ) {
		$output = '';

		if ( preg_match( '/\+?[0-9]+/', $input, $match ) ) {
			$output = $match[0];
		}

		return $output;
	}
}
