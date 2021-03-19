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

		wp_enqueue_style( 'marianne-customizer', esc_url( get_template_directory_uri() . "/assets/css/customizer-controls$min.css" ), array(), $theme_version );

		wp_enqueue_script( 'marianne-customizer', esc_url( get_template_directory_uri() . "/assets/js/customizer-controls$min.js" ), array( 'jquery', 'jquery-ui-slider', 'customize-preview' ), $theme_version, true );
	}

	add_action( 'customize_controls_enqueue_scripts', 'marianne_customizer_scripts_styles' );
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

		/**
		 * List new options to add to the Customizer.
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
		 *                                             );
		 */
		$marianne_customizer_options = array();

		// Colors.
		$marianne_customizer_options[] = array(
			'section'     => 'colors',
			'id'          => 'theme',
			'title'       => __( 'Theme', 'marianne' ),
			'description' => __( 'Default: light.', 'marianne' ),
			'type'        => 'radio',
			'value'       => array(
				'light' => __( 'Light', 'marianne' ),
				'dark'  => __( 'Dark', 'marianne' ),
			),
		);
		$marianne_customizer_options[] = array(
			'section'     => 'colors',
			'id'          => 'link_hover',
			'title'       => __( 'Hovered links', 'marianne' ),
			'description' => __( 'Default: blue.', 'marianne' ),
			'type'        => 'radio',
			'value'       => array(
				'blue'   => __( 'Blue', 'marianne' ),
				'red'    => __( 'Red', 'marianne' ),
				'green'  => __( 'Green', 'marianne' ),
				'orange' => __( 'Orange', 'marianne' ),
				'purple' => __( 'Purple', 'marianne' ),
			),
		);

		// Fonts.
		$marianne_customizer_options[] = array(
			'section'     => 'marianne_fonts',
			'id'          => 'family',
			'title'       => __( 'Font Family', 'marianne' ),
			'description' => __( "Choose the font family you want to apply to your site. Your readers' device will render their system font or, if it doesn't work, their browers' own font. In any case, rendering may vary from device to device, but it will load way faster. Default: Sans serif.", 'marianne' ),
			'type'        => 'select',
			'value'       => array(
				'sans-serif' => __( 'Sans serif', 'marianne' ),
				'serif'      => __( 'Serif', 'marianne' ),
				'monospace'  => __( 'Monospaced', 'marianne' ),
			),
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_fonts',
			'id'          => 'text_shadow',
			'title'       => __( 'Text Shadow', 'marianne' ),
			'description' => __( 'Give some relief to the text so that it becomes less flat.', 'marianne' ),
			'type'        => 'checkbox',
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

			// Variables used to build the settings and controls.
			$section     = ! empty( $option['section'] ) ? $option['section'] : '';
			$id          = ! empty( $option['id'] ) ? $option['id'] : '';
			$type        = ! empty( $option['type'] ) ? $option['type'] : '';
			$title       = ! empty( $option['title'] ) ? $option['title'] : '';
			$description = ! empty( $option['description'] ) ? $option['description'] : '';
			$value       = ! empty( $option['value'] ) ? $option['value'] : '';

			if ( $section && $id ) {
				$option_id = $section . '_' . $id;
			} else {
				$option_id = '';
			}

			if ( $option_id ) {
				$option_default = $options_default[ $option_id ];

				// Choose the right sanitize callback.
				switch ( $type ) {
					case 'radio':
					case 'select':
						$sanitize_callback = 'marianne_sanitize_radio_select';
						break;

					default:
						$sanitize_callback = 'esc_url_raw';
						break;
				}

				// Add the setting.
				$wp_customize->add_setting(
					esc_html( $option_id ),
					array(
						'default'           => sanitize_key( $option_default ),
						'capability'        => 'edit_theme_options',
						'sanitize_callback' => $sanitize_callback,
					)
				);

				$value_type = 'value';
				if ( 'select' === $type || 'radio' === $type ) {
					$value_type = 'choices';
				}

				// Add the control.
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
			// Colors.
			'colors_theme'      => 'light',
			'colors_link_hover' => 'blue',

			// Fonts.
			'marianne_fonts_family'      => 'sans-serif',
			'marianne_fonts_text_shadow' => false,
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
	 * @param string               $input   Radio or select value.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 *
	 * @return integer Sanitized value.
	 */
	function marianne_sanitize_radio_select( $input, $setting ) {
		// Get the list of select options.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		if ( array_key_exists( $input, $choices ) ) {
			return sanitize_key( $input );
		} else {
			return sanitize_key( $setting->default );
		}
	}
}
