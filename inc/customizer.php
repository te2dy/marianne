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

		$wp_customize->add_section(
			'marianne_content',
			array(
				'title' => __( 'Content Formatting', 'marianne' ),
			)
		);

		$wp_customize->add_section(
			'marianne_footer',
			array(
				'title' => __( 'Footer Settings', 'marianne' ),
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
			'type'        => 'select',
			'value'       => array(
				'light' => __( 'Light', 'marianne' ),
				'dark'  => __( 'Dark', 'marianne' ),
				'os'    => __( 'Operating system color scheme (light or dark)', 'marianne' ),
			),
		);
		$marianne_customizer_options[] = array(
			'section'     => 'colors',
			'id'          => 'link_hover',
			'title'       => __( 'Hovered links', 'marianne' ),
			'description' => __( 'Default: blue.', 'marianne' ),
			'type'        => 'select',
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
			'id'          => 'size',
			'title'       => __( 'Font Size', 'marianne' ),
			'description' => __( 'The main font size. Default: 100%.', 'marianne' ),
			'type'        => 'marianne_slider',
			'input_attrs' => array(
				'min'  => 80,
				'max'  => 120,
				'step' => 10,
			),
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_fonts',
			'id'          => 'text_shadow',
			'title'       => __( 'Text Shadow', 'marianne' ),
			'description' => __( 'Give some relief to the text so that it becomes less flat.', 'marianne' ),
			'type'        => 'checkbox',
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
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_content',
			'id'          => 'hyphens',
			'title'       => __( 'Enable hyphenation', 'marianne' ),
			'description' => __( 'Break some words in half so that they continue on another line rather than moving them entirely to the next line. Especially useful when the text alignment is set to "justify".', 'marianne' ),
			'type'        => 'checkbox',
		);

		// Footer Settings
		$marianne_customizer_options[] = array(
			'section' => 'marianne_footer',
			'id'      => 'mention',
			'title'   => __( 'Display the default footer mention to WordPress and Marianne. Default: checked.', 'marianne' ),
			'type'    => 'checkbox',
		);

		$marianne_customizer_options[] = array(
			'section'     => 'marianne_footer',
			'id'          => 'text',
			'title'       => __( 'Footer Text', 'marianne' ),
			'description' => __( 'Add a text you want to display in the footer.', 'marianne' ),
			'type'        => 'textarea',
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
			$input_attrs = ! empty( $option['input_attrs'] ) ? $option['input_attrs'] : null;

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
				$others_controles = array( 'marianne_slider' );

				if ( ! in_array( $type, $others_controles ) ) {
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
			// Colors.
			'colors_theme'      => 'light',
			'colors_link_hover' => 'blue',

			// Fonts.
			'marianne_fonts_family'      => 'sans-serif',
			'marianne_fonts_size'        => 100,
			'marianne_fonts_text_shadow' => false,

			// Content Formatting.
			'marianne_content_text_align' => 'left',
			'marianne_content_hyphens'    => false,

			// Footer Settings.
			'marianne_footer_mention' => true,
			'marianne_footer_text'    => '',
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
	 * @param string               $input   Radio or select value to be sanitized.
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

if ( ! function_exists( 'marianne_sanitize_checkbox' ) ) {
	/** Checkbox sanitization.
	*
	* @param string $input Checkbox value to be sanitized.
	*
	* @return bool Sanitized value.
	*/
	function marianne_sanitize_checkbox( $input ) {
		return ( isset( $input ) && true == $input ) ? true : false;
	}
}

if ( ! function_exists( 'marianne_sanitize_slider' ) ) {
	/**
	 * Slider sanitization.
	 *
	 * @param number               $input   Slider value to be sanitized.
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

		$min = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );
		$max = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );
		$step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

		$number = floor( $input / $attrs['step'] ) * $attrs['step'];

		return marianne_in_range( $number, $min, $max );
	}
}

if ( ! function_exists( 'marianne_in_range' ) ) {
	/**
	 * Only allow values between a certain minimum & maxmium range
	 *
	 * @param  number $input Input to be sanitized.
	 * @param  number	$max   The max value of the input.
	 * @param  number	$min   The min value of the input.
	 *
	 * @return number	Sanitized input.
	 *
	 * Based on the work of:
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	function skyrocket_in_range( $input, $min, $max ){
		if ( $input < $min ) {
			$input = $min;
		}

		if ( $input > $max ) {
			$input = $max;
		}

		return $input;
	}
}

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Custom Controls.
	 *
	 * Based on the work of:
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */

	// Slider.
	class Marianne_Customizer_Control_Slider extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'marianne_slider';

		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="slider-custom-control">
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />

				<span class="customize-control-description">
					<?php echo esc_html( $this->description ); ?>
				</span>

				<div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div>

				<span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->settings['default']->default ); ?>"></span>
			</div>
		<?php
		}
	}
}