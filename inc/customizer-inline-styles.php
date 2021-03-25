<?php
// UNUSED YET.

if ( ! function_exists( 'marianne_array_to_css' ) ) {
	/**
	 * Generates a CSS string from a multidimensional array of CSS rules.
	 *
	 * @param array $rules An array of CSS rules in the form of:
	 *                  array( 'selector' => array( 'property' => 'value' ) ).
	 *                  Also supports selector nesting, e.g.,
	 *                  array( 'selector' => array( 'selector' => array( 'property' => 'value' ) ) ).
	 *
	 * @param string $rule_type
	 *   default: 'standard'. Also supports multiple at-rules with the same identifier.
	 *   Example: $rule_type = '@font-face'.
	 *            $rules = [0] => array( 'property' => 'value' )
	 *
	 * @return string A CSS string of rules not wrapped in <style> tags.
	 * @source http://matthewgrasmick.com/article/convert-nested-php-array-css-string
	 */
	function marianne_array_to_css( $rules ) {
		$css = '';

		foreach ( $rules as $key => $value ) {
			if ( is_array( $value ) ) {
				$selector   = $key;
				$properties = $value;

				$css .= $selector . '{';
				$css .= marianne_array_to_css( $properties );
				$css .= '}';
			} else {
				$property = $key;

				$css .= $property . ':' . $value . ';';
			}
		}

		return $css;
	}
}

if ( ! function_exists( 'marianne_inline_css' ) ) {
	/**
	 * Get the desired styles from Theme Customizer and apply them to the Theme itself.
	 */
	function marianne_inline_css() {
		$css = array();

		if ( 'custom' === marianne_get_theme_mod( 'marianne_global_page_width' ) ) {
			$css['#page'] = array(
				'max-width' => absint( marianne_get_theme_mod( 'marianne_global_page_width_custom' ) ) . 'px',
			);
		}

		wp_add_inline_style( 'marianne-stylesheet', wp_strip_all_tags( marianne_array_to_css( $css ) ) );
	}

	add_action( 'wp_enqueue_scripts', 'marianne_inline_css' );
}
