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

if ( ! function_exists( 'marianne_array_to_css' ) ) {
	/**
	 * Generates a CSS string from a multidimensional array of CSS rules.
	 *
	 * Based on the work of Matthew Grasmick.
	 *
	 * @link http://matthewgrasmick.com/article/convert-nested-php-array-css-string
	 *
	 * @param array  $rules An array of CSS rules in the following format:
	 *                      array( 'selector' => array( 'property' => 'value' ) ).
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
	 * An array of colors used in the theme and to be reused.
	 *
	 * @param string $name   The name of the color to return.
	 * @param string $scheme The color scheme associated with the color.
	 *
	 * @return string The hex color.
	 */
	function marianne_color_palette( $name, $scheme ) {
		$colors = array(
			'blue'   => array(
				'light' => '#0057B7',
				'dark'  => '#529ff5',
			),
			'red'    => array(
				'light' => '#de0000',
				'dark'  => '#f14646',
			),
			'green'  => array(
				'light' => '#006400',
				'dark'  => '#18af18',
			),
			'orange' => array(
				'light' => '#ff8c00',
				'dark'  => '#ffab2e',
			),
			'purple' => array(
				'light' => '#800080',
				'dark'  => '#9a389a',
			),
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
	 * Inlines custom styles.
	 *
	 * Gets the custom styles from the Theme Customizer
	 * and inlines them in the head element of pages.
	 */
	function marianne_custom_css() {
		// Variables.
		$marianne_page_width = marianne_get_theme_mod( 'marianne_global_page_width' );

		$css[':root']['--font-size']  = ( 12 * absint( marianne_get_theme_mod( 'marianne_global_font_size' ) ) / 100 ) . 'pt';

		$font_family = marianne_get_theme_mod( 'marianne_global_font_family' );
		if ( 'sans-serif' === $font_family ) {
			$css['body']['font-family'] = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif';
		} elseif ( 'serif' === $font_family ) {
			$css['body']['font-family'] = '"Iowan Old Style", "Apple Garamond", Baskerville, "Times New Roman", "Droid Serif", Times, "Source Serif Pro", serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
		} else {
			$css['body']['font-family'] = 'Menlo, Consolas, Monaco, "Liberation Mono", "Lucida Console", monospace';
		}

		$marianne_layout = marianne_get_theme_mod( 'marianne_global_layout' );
		if ( 'one-column' === $marianne_layout ) {
			$css['.site']['max-width'] = absint( $marianne_page_width ) . 'px';
		} elseif ( 'two-column-left-sidebar' === $marianne_layout ) {
			$css['.site']['display']             = 'grid';
			$css['.site']['grid-template-areas'] = '"header content" "sidebar content" "sidebar footer"';
			$css['.site']['max-width'] = absint( $marianne_page_width + 200 ) . 'px';

			$css['.site-header']['grid-area'] = 'header';
			$css['.site-header']['margin-right'] = '2em';
			$css['.site-header']['padding-right'] = '2em';

			$css['.site-content']['grid-area'] = 'content';
			$css['.site-content']['width'] = absint( $marianne_page_width ) . 'px';

			$css['.site-secondary']['grid-area'] = 'sidebar';
			$css['.site-secondary']['margin-right'] = '2em';
			$css['.site-secondary']['padding-right'] = '2em';

			$css['.site-footer']['grid-area'] = 'footer';
			$css['.site-footer']['width'] = absint( $marianne_page_width ) . 'px';
		}

		$css['.entry-thumbnail-wide .wp-post-image']['width'] = absint( $marianne_page_width ) . 'px';

		$css['.alignwide']['margin-right'] = 'calc(-75vw / 2 + ' . absint( $marianne_page_width ) . 'px / 2)';
		$css['.alignwide']['margin-left']  = 'calc(-75vw / 2 + ' . absint( $marianne_page_width ) . 'px / 2)';
		$css['.alignfull']['margin-left']  = 'calc(-100vw / 2 + ' . absint( $marianne_page_width ) . 'px / 2)';
		$css['.alignfull']['margin-left']  = 'calc(-100vw / 2 + ' . absint( $marianne_page_width ) . 'px / 2)';

		wp_add_inline_style( 'marianne-stylesheet', marianne_array_to_css( $css ) );

		// Responsive
		if ( $marianne_page_width > 480 + ( 480 * 0.1 ) ) {
			$media_rule = '@media all and (max-width: ' . absint( $marianne_page_width + ( $marianne_page_width * 0.1 ) ) . 'px)';

			$media = array();

			$media['.site']['margin-right'] = '10%';
			$media['.site']['margin-left'] = '10%';

			wp_add_inline_style( 'marianne-stylesheet', marianne_array_to_css( $media, $media_rule ) );
		}

		if ( $marianne_page_width > 480 ) {
			$media_rule = '@media all and (max-width: ' . absint( 480 + ( 480 * 0.1 ) ) . 'px)';

			$media = array();

			$media['.site']['margin-right'] = '5%';
			$media['.site']['margin-left'] = '5%';

			$media['.site-content']['margin'] = '2em auto';

			$media['.site-header']['margin-bottom'] = '1em';

			$media['.entry-loop.sticky']['margin-right'] = '-.5rem';
			$media['.entry-loop.sticky']['margin-left'] = '-.5rem';
			$media['.entry-loop.sticky']['padding'] = '.5rem';

			$media['.entry-loop.sticky figure']['margin-right'] = '-.5rem';
			$media['.entry-loop.sticky figure']['margin-left'] = '-.5rem';

			$media['.nav-links']['display'] = 'block';
			$media['.nav-links']['justify-content'] = 'unset';

			$media['.nav-links .nav-link-previous,.nav-links .nav-link-next']['max-width'] = 'unset';

			$media['.nav-links .nav-link-previous']['padding-right'] = '0';

			$media['.nav-links .nav-link-next']['padding-top'] = '.5em';
			$media['.nav-links .nav-link-next']['padding-left'] = '0';
			$media['.nav-links .nav-link-next']['text-align'] = 'right';

			$media['.nav-links-one .nav-link-next']['text-align'] = 'right';

			$media['.comment-list .parent .comment']['padding'] = '.5em 0 0 .5em';

			$media['.wp-block-media-text']['display'] = 'block';
			$media['.alignfull']['margin-right'] = '-1em';
			$media['.alignfull']['margin-left'] = '-1em';

			wp_add_inline_style( 'marianne-stylesheet', marianne_array_to_css( $media, $media_rule ) );
		}
	}

	add_action( 'wp_enqueue_scripts', 'marianne_custom_css' );
}
