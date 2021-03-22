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
	 * Enqueue Theme Customizer scripts and styles.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_customizer_scripts_styles() {
		$theme_version = wp_get_theme()->get( 'Version' );
		$min           = marianne_minify();

		// Enqueue custom controls files.
		wp_enqueue_style( 'marianne-customizer-controls', esc_url( get_template_directory_uri() . "/assets/css/customizer-controls$min.css" ), array(), $theme_version );

		wp_enqueue_script( 'marianne-customizer-controls', esc_url( get_template_directory_uri() . "/assets/js/customizer-controls$min.js" ), array( 'jquery', 'jquery-ui-slider', 'customize-preview' ), $theme_version, true );
	}

	add_action( 'customize_controls_enqueue_scripts', 'marianne_customizer_scripts_styles' );
}

if ( ! function_exists( 'marianne_customizer_script_live' ) ) {
	/**
	 * Enqueue Theme Customizer live preview script.
	 *
	 * @return void
	 *
	 * @since Marianne 1.3
	 */
	function marianne_customizer_script_live() {
		$theme_version = wp_get_theme()->get( 'Version' );
		$min           = marianne_minify();

		wp_enqueue_script( 'marianne-customizer-live', esc_url( get_template_directory_uri() . "/assets/js/customizer-live-preview$min.js" ), array( 'jquery', 'customize-preview' ), $theme_version, true );
	}

	add_action( 'customize_preview_init', 'marianne_customizer_script_live' );
}

if ( ! function_exists( 'marianne_customize_register' ) ) {
	/**
	 * Add various options to the theme.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/customize_register/
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function marianne_customize_register( $wp_customize ) {
		/**
		 * Create new sections in Theme Customizer.
		 *
		 * Summary:
		 * - Fonts.
		 *
		 * @link https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
		 */
		$wp_customize->add_section(
			'marianne_fonts',
			array(
				'title' => __( 'Fonts', 'marianne' ),
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


		// Adds live preview to the site's name and description.
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		/**
		 * Lists new options to add to the Customizer.
		 *
		 * To simplify the code, all new options are pushed in an array.
		 *
		 * @return array  $marianne_customizer_options An array of options that follows this pattern:
		 *                                             $marianne_customizer_options[] = array(
		 *                                                 'id'          => 'The option id',
		 *                                                 'title'       => 'The title of the option',
		 *                                                 'description' => 'The description of the option',
		 *                                                 'type'        => 'The type of the option (text, checkbox…)',
		 *                                                 'value'       => 'The value of the option',
		 *                                                 'live'        => (bool) Enable/disable live preview.
		 *                                             );
		 */
		$marianne_customizer_options = array();

		// Site Identity.
		$marianne_customizer_options[] = array(
			'section'     => 'title_tagline',
			'id'          => 'logo_circular',
			'title'       => __( 'Make the logo round.', 'marianne' ),
			'description' => __( 'Default: unckecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

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
			'title'       => __( 'Hovered elements.', 'marianne' ),
			'description' => __( 'Color used for link and button hovers. Default: blue.', 'marianne' ),
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

		// Fonts.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_fonts',
			'id'          => 'family',
			'title'       => __( 'Font Family', 'marianne' ),
			'description' => __( "Choose the font family you want to apply to your site. Your readers' device will render the pages with their system font. Please note that the rendering may vary from device to device. Default: Sans serif.", 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'sans-serif' => __( 'Sans serif', 'marianne' ),
				'serif'      => __( 'Serif', 'marianne' ),
				'monospace'  => __( 'Monospaced', 'marianne' ),
			),
			'live'        => true,
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_fonts',
			'id'          => 'size',
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
			'section'     => 'marianne_fonts',
			'id'          => 'smooth',
			'title'       => __( 'Force anti-aliasing.', 'marianne' ),
			'description' => __( 'By default, the browser automatically chooses whether or not to smooth the fonts. By checking this box, you will ask it to smooth them. Default: unckecked.', 'marianne' ),
			'type'        => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_fonts',
			'id'          => 'text_shadow',
			'title'       => __( 'Enable text shadow.', 'marianne' ),
			'description' => __( 'Give some relief to your texts. Default: disabled.', 'marianne' ),
			'type'        => 'checkbox',
			'live'        => true,
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
			'description' => __( 'Break some words in half so that they continue on another line rather than moving them entirely to the next line. Especially useful when the text alignment is set to "justify". Default: disabled.', 'marianne' ),
			'type'        => 'checkbox',
			'live'        => true,
		);

		// Post Settings.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_post',
			'id'          => 'nav',
			'title'       => __( 'Display links to previous and next posts.', 'marianne' ),
			'description' => __( 'Default: hidden.', 'marianne' ),
			'type'        => 'checkbox',
		);

		// Footer Settings.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_footer',
			'id'          => 'mention',
			'title'       => __( 'Display the default footer mention.', 'marianne' ),
			'description' => __( 'Useful to promote WordPress and Marianne to your readers. Default: displayed.', 'marianne' ),
			'type'        => 'checkbox',
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
			'section'     => 'marianne_social',
			'id'          => 'twitter',
			'title'       => __( 'Twitter', 'marianne' ),
			'description' => __( 'Type your twitter @username.', 'marianne' ),
			'type'        => 'text',
		);

		/**
		 * Add settings and controls to the Theme Customizer.
		 *
		 * Now, iterate the options put in the array $marianne_customizer_settings
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

			if ( ! empty( $option['live'] ) && true === $option['live'] ) {
				$live = 'postMessage';
			} else {
				$live = 'refresh';
			}

			if ( $section && $id ) {
				$option_id = $section . '_' . $id;
			} else {
				$option_id = '';
			}

			if ( $option_id ) {
				$option_default = $options_default[ $option_id ];

				if ( 'marianne_social_twitter' !== $option_id ) {
					// Choose the right sanitize callback.
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

						default:
							$sanitize_callback = 'esc_html';
							break;
					}
				} elseif( 'marianne_social_twitter' === $option_id ) {
					$sanitize_callback = 'marianne_sanitize_twitter';
				}

				// Add the setting.
				$wp_customize->add_setting(
					esc_html( $option_id ),
					array(
						'default'           => sanitize_key( $option_default ),
						'capability'        => 'edit_theme_options',
						'sanitize_callback' => $sanitize_callback,
						'transport'         => $live,
					)
				);

				$value_type = 'value';
				if ( 'select' === $type || 'radio' === $type ) {
					$value_type = 'choices';
				}

				// Add the control.
				$others_controles = array( 'marianne_slider' );

				if ( ! in_array( $type, $others_controles, true ) ) {
					$wp_customize->add_control(
						new WP_Customize_Control(
							$wp_customize,
							sanitize_key( $option_id ),
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
							esc_html( $option_id ),
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
	 * The default option values.
	 *
	 * @param string $option The option to retrieve the default value (optional).
	 *
	 * @return string|array $output If an option is set, return the value of its default options.
	 *                              Otherwise, return an array with the default values of all the options.
	 */
	function marianne_options_default( $option = '' ) {
		$output = '';

		/**
		 * The array of default values.
		 *
		 * $options_default = array(
		 *     'the_id_of_the_option' => 'Its default value',
		 * );
		 */
		$options_default = array(
			// Site Identity.
			'title_tagline_logo_circular' => false,

			// Colors.
			'colors_scheme'     => 'light',
			'colors_link_hover' => 'blue',

			// Fonts.
			'marianne_fonts_family'      => 'sans-serif',
			'marianne_fonts_size'        => 100,
			'marianne_fonts_smooth'      => false,
			'marianne_fonts_text_shadow' => false,

			// Content Formatting.
			'marianne_content_text_align' => 'left',
			'marianne_content_hyphens'    => false,

			// Post Settings
			'marianne_post_nav' => false,

			// Footer Settings.
			'marianne_footer_mention' => true,
			'marianne_footer_text'    => '',

			// Social Links.
			'marianne_social_twitter' => '',
		);

		$option = sanitize_key( $option );

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
	 * A Custom get_theme_mod() function.
	 *
	 * Get automatically the default value of the option.
	 *
	 * @param string $id The id of the option.
	 *
	 * @return string The value of the option.
	 */
	function marianne_get_theme_mod( $id ) {
		$output = '';

		$options_default = marianne_options_default();

		if ( $id && array_key_exists( $id, $options_default ) ) {
			$default = $options_default[ $id ];

			$output = get_theme_mod( $id, $default );
		}

		return $output;
	}
}

if ( ! function_exists( 'marianne_sanitize_radio_select' ) ) {
	/**
	 * Radio and select sanitization.
	 *
	 * Based on the work of the WordPress Theme Review Team.
	 *
	 * @link https://github.com/WPTT/code-examples/blob/master/customizer/sanitization-callbacks.php
	 *
	 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
	 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
	 *
	 * @param string               $input   Radio or select value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 *
	 * @return integer Sanitized value.
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
	 */
	function marianne_sanitize_checkbox( $input ) {
		return ( isset( $input ) && true === $input ) ? true : false;
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
	 */
	function marianne_sanitize_twitter( $input ) {
		$input  = esc_attr( $input );
		$output = '';

		if ( $input ) {
			if ( preg_match( '/^\@[A-Za-z0-9_]{1,15}$/', $input ) ) {
				$output = $input;
			}
		}

		return $output;
	}
}
