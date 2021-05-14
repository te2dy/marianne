<?php
/**
 * Custom Styles.
 *
 * The purpose of this file is to customize the theme styles
 * according to the customization choices.
 *
 * @package Marianne
 * @since Marianne 1.4
 */

if ( ! function_exists( 'marianne_header_sizes' ) ) {
	/**
	 * Defines heading sizes.
	 *
	 * Size of headings depend on the main font size.
	 * h4 and h5 have a size…
	 * h6 has the minimum size which is 80% of the main text size.
	 *
	 * @return array All heading sizes.
	 *   array( 'h1' => 150, 'h2' => 120… )
	 */
	function marianne_header_sizes() {
		// The number represents the percentage ofthe main body size.
		$h1 = 150; // Also the site title.
		$h3 = 100; // Also the site description.
		$h6 = 80;

		// h2 is between h1 & h3.
		$h2 = $h3 + ( $h1 - $h3 ) / 2; // Also the post & page title.

		// h4 and h5 are equaly between h3 and h6.
		$h4 = $h6 + ( ( $h3 - $h6 ) / 3 * 2 );
		$h5 = $h6 + ( ( $h3 - $h6 ) / 3 );

		$headers = array(
			'h1' => $h1,
			'h2' => $h2,
			'h3' => $h3,
			'h4' => $h4,
			'h5' => $h5,
			'h6' => $h6,
		);

		return $headers;
	}
}

if ( ! function_exists( 'marianne_percents_to_decimals' ) ) {
	/**
	 * Converts percents to decimals for css rules.
	 *
	 * @param integer|float $input An integer between 0 and 100 to convert.
	 * @param integer       $max_length Max numbers after the decimal point.
	 *
	 * @return float The integer converted in a decimal format.
	 */
	function marianne_percents_to_decimals( $input, $max_length = 2 ) {
		if ( ! is_numeric( $input ) ) {
			return;
		}

		$output = 0;

		if ( is_numeric( $input ) ) {
			$output = $input / 100;
			$output = number_format( $output, absint( $max_length ) );
			$output = rtrim( $output, '0' );
		}

		$output = floatval( $output );

		return $output;
	}
}

if ( ! function_exists( 'marianne_css_number_format' ) ) {
	/**
	 * Converts decimals to a nice css format.
	 *
	 * @param integer|float $input A number to convert.
	 *
	 * @return string The number with a css style applied.
	 */
	function marianne_css_number_format( $input ) {
		if ( ! is_numeric( $input ) ) {
			return;
		}

		$output = rtrim( $input, '0' );
		$output = rtrim( $output, '.' );

		if ( 0 < floatval( $output ) && '0.' === substr( $output, 0, 2 ) ) {
			$output = substr( $output, 1 );
		}

		return $output;
	}
}

if ( ! function_exists( 'marianne_array_to_css' ) ) {
	/**
	 * Generates a CSS string from a multidimensional array of CSS rules.
	 *
	 * @source http://matthewgrasmick.com/article/convert-nested-php-array-css-string
	 *
	 * @param array $rules An array of CSS rules in the following format:
	 *                     array( 'selector' => array( 'property' => 'value' ) ).
	 * @param string $rule_type Add an at-rule (optional)
	 *               default: 'standard'. Also supports other at-rules.
	 *               Example: $rule_type = '@font-face'.
	 *
	 * @return string A CSS string of rules not wrapped in <style> tags.
	 */
	function marianne_array_to_css( $rules, $rule_type = '' ) {
		$css = '';

		if ( $rules ) {
			if ( ! $rule_type ) {
				foreach ( $rules as $key => $value ) {
					if ( is_array( $value ) ) {
						$selector = $key;

						$properties = $value;

						$css .= "$selector{";
						$css .= marianne_array_to_css( $properties );
						$css .= '}';
					} else {
						$property = $key;

						$css .= "$property:$value;";
					}
				}
			} elseif ( '@font-face' === $rule_type ) {
				foreach ( $rules as $value ) {
					$selector = $rule_type;

					$properties = $value;

					$css .= "$selector{";
					$css .= marianne_array_to_css( $properties );
					$css .= '}';
				}
			} else {
				$css .= "$rule_type {";

				foreach ( $rules as $property => $value ) {
					$css .= "$property{";
					$css .= marianne_array_to_css( $value );
					$css .= '}';
				}

				$css .= '}';
			}
		}

		return $css;
	}
}

if ( ! function_exists( 'marianne_color_palette' ) ) {
	/**
	 * An array of colors used in the theme
	 * to be reused.
	 *
	 * @param string $name The name of the color to return.
	 *
	 * @return string The hex color.
	 */
	function marianne_color_palette( $name ) {
		$colors = array(
			'primary'   => '#000000',
			'secondary' => '#595959',
			'opposite'  => '#ffffff',
			'dark'      => '#2e2e2e',
			'medium'    => '#babab9',
			'light'     => '#e8e8e8',
			'contrast'  => '#de0000',
		);

		if ( true === array_key_exists( $name, $colors ) ) {
			return $colors[ $name ];
		} else {
			return $colors['contrast'];
		}
	}
}

if ( ! function_exists( 'marianne_custom_css' ) ) {
	/**
	 * Get the desired styles from Theme Customizer and apply them to the Theme itself.
	 */
	function marianne_custom_css() {

		// Global.
		$font_size                   = 12 * marianne_get_theme_mod( 'marianne_global_font_size' );
		$css[':root']['--font-size'] = marianne_percents_to_decimals( $font_size, 0 ) . 'pt';
		$css[':root']['--page-width'] = marianne_get_theme_mod( 'marianne_global_page_width' ) . 'px';

		$font_family = marianne_get_theme_mod( 'marianne_global_font_family' );

		if ( 'sans-serif' === $font_family ) {
			$css['body']['font-family'] = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif';
		} elseif ( 'serif' === $font_family ) {
			$css['body']['font-family'] = '"Iowan Old Style", "Apple Garamond", Baskerville, "Times New Roman", "Droid Serif", Times, "Source Serif Pro", serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
		} else {
			$css['body']['font-family'] = 'Menlo, Consolas, Monaco, "Liberation Mono", "Lucida Console", monospace';
		}

		// Responsive.
		// Soon…

		wp_add_inline_style( 'marianne-stylesheet', marianne_array_to_css( $css ) );
	}

	add_action( 'wp_enqueue_scripts', 'marianne_custom_css' );
}
