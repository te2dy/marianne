( function( $ ) {
	"use strict";

	/**
	 * Toggles class (or multiple ones) to an element (or multiple ones).
	 *
	 * Function used for select and radio options in the Theme Customizer.
	 *
	 * @param {string|array} target  The element to which toggle the class.
	 * @param {array}        classes The classes to toogle.
	 * @param {string}       newval  The value sent by the Customizer.
	 *
	 * @since Marianne 1.3
	 */
	function marianneSelectRadioToggleClass( target, classes, newval ) {
		if ( target && classes && newval ) {
			$.each( classes, function( key, theClass ) {
				if ( ! Array.isArray( target ) ) {
					if ( $( target ).hasClass( theClass ) ) {
						$( target ).removeClass( theClass );
					}

					if ( key === newval ) {
						$( target ).addClass( theClass );
					}
				} else {
					$.each( target, function( index, value ) {
						if ( $( value ).hasClass( theClass ) ) {
							$( value ).removeClass( theClass );
						}

						if ( key === newval ) {
							$( value ).addClass( theClass );
						}
					} );
				}
			} );
		}
	}

	/**
	 * Toggles class (or multiple ones) to an element (or multiple ones).
	 *
	 * Function used for checkbox options in the Theme Customizer.
	 *
	 * @param {string|array} target  The element to which toggle the class.
	 * @param {array}        classes The classes to toogle.
	 * @param {string}       newval  The value sent by the Customizer.
	 *
	 * @since Marianne 1.3
	 */
	function marianneCheckboxToggleClass( target, classToAdd, checked ) {
		if ( target && classToAdd ) {
			if ( checked === true ) {
				if ( ! $( target ).hasClass( classToAdd ) ) {
					$( target ).addClass( classToAdd );
				}
			} else {
				if ( $( target ).hasClass( classToAdd ) ) {
					$( target ).removeClass( classToAdd );
				}
			}
		}
	}

	$( document ).ready( function( $ ) {
		/**
		 * Sets up live preview for the Theme Customizer.
		 */

		// Site Identity > Site Title.
		wp.customize( "blogname", function( value ) {
			value.bind( function( newval ) {
				if ( $( ".site-title" ).children( "a" ).length === 0 ) {
					$( ".site-title" ).html( newval );
				} else {
					$( ".site-title a" ).html( newval );
				}
			} );
		} );

		// Site Identity > Site description.
		wp.customize( "blogdescription", function( value ) {
			value.bind( function( newval ) {
				$( ".site-description" ).html( newval );
			} );
		} );

		// Colors > Color Scheme.
		wp.customize( "colors_scheme", function( value ) {
			value.bind( function( newval ) {
				var target = "body",
					classes = {
						"light": "color-scheme-light",
						"dark": "color-scheme-dark",
						"auto": "color-scheme-auto",
					};

					marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Colors > Hovered Elements.
		wp.customize( "colors_link_hover", function( value ) {
			value.bind( function( newval ) {
				var target = "body",
					classes = {
						"blue": "link-hover-blue",
						"red": "link-hover-red",
						"green": "link-hover-green",
						"orange": "link-hover-orange",
						"purple": "link-hover-purple"
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Global > Font Family.
		wp.customize( "marianne_global_font_family", function( value ) {
			value.bind( function( newval ) {
				if ( newval === 'sans-serif' ) {
					$( "body" ).css( 'font-family', '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif' );
				} else if ( newval === 'serif' ) {
					$( "body" ).css( 'font-family', '"Iowan Old Style", "Apple Garamond", Baskerville, "Times New Roman", "Droid Serif", Times, "Source Serif Pro", serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"' );
				} else if ( newval === 'monospace' ) {
					$( "body" ).css( 'font-family', 'Menlo, Consolas, Monaco, "Liberation Mono", "Lucida Console", monospace' );
				}
			} );
		} );

		// Global > Font Size.
		wp.customize( "marianne_global_font_size", function( value ) {
			value.bind( function( newval ) {
				$( "body" ).css( "font-size", ( 12 * Number( newval ) / 100 ) + "pt" );
			} );
		} );

		// Global > Text Shadow.
		wp.customize( "marianne_global_text_shadow", function( value ) {
			value.bind( function( newval ) {
				var target = "body",
					classToAdd = "text-shadow";

				marianneCheckboxToggleClass( target, classToAdd, newval );
			} );
		} );

		// Header Settings > Align.
		wp.customize( "marianne_header_align", function( value ) {
			value.bind( function( newval ) {
				var target = ".site-header",
					classes = {
						"left": "site-header-align-left",
						"center": "site-header-align-center",
						"right": "site-header-align-right"
				};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Header Settings > Site Title Weight.
		wp.customize( "marianne_header_title_weight", function( value ) {
			value.bind( function( newval ) {
				var target = ".site-title",
					classes = {
						"normal": "site-title-weight-normal",
						"bold": "site-title-weight-bold",
						"bolder": "site-title-weight-bolder"
				};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Header Settings > Site Description Weight.
		wp.customize( "marianne_header_desc_weight", function( value ) {
			value.bind( function( newval ) {
				var target = ".site-description",
					classes = {
						"thin": "site-desc-weight-thin",
						"normal": "site-desc-weight-normal"
				};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Header Settings > Site Description Style.
		wp.customize( "marianne_header_desc_style", function( value ) {
			value.bind( function( newval ) {
				var target = ".site-description",
					classes = {
						"normal": "site-desc-style-normal",
						"italic": "site-desc-style-italic"
				};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Header Settings > Search button text.
		wp.customize( "marianne_header_menu_search_text", function( value ) {
			value.bind( function( newval ) {
				if ( $( "#header-search-button" ).length > 0 ) {
					if ( newval.length > 0 ) {
						$( "#header-search-button" ).html( newval );
					} else {
						$( "#header-search-button" ).html( marianne_live.default_search_text );
					}
				}
			} );
		} );

		// Content Formatting > Text Align.
		wp.customize( "marianne_content_text_align", function( value ) {
			value.bind( function( newval ) {
				var target = [
						".entry-content",
						".comment-content"
					],
					classes = {
						"left": "text-align-left",
						"center": "text-align-center",
						"right": "text-align-right",
						"justify": "text-align-justify"
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Content Formatting > Hyphenation.
		wp.customize( "marianne_content_hyphens", function( value ) {
			value.bind( function( newval ) {
				var target = ".entry-content",
					classToAdd = "text-hyphens";

				marianneCheckboxToggleClass( target, classToAdd, newval );
			} );
		} );

		// Footer Settings > Align.
		wp.customize( "marianne_footer_align", function( value ) {
			value.bind( function( newval ) {
				var target = ".site-footer",
					classes = {
						"left": "site-footer-align-left",
						"center": "site-footer-align-center",
						"right": "site-footer-align-right"
				};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Footer Settings > Footer Text.
		wp.customize( "marianne_footer_text", function( value ) {
			value.bind( function( newval ) {
				if ( $( "#site-footer-text" ).length ) {
					$( "#site-footer-text" ).html( newval );
				} else {
					$( ".site-footer" )
						.prepend(
							'<div id="site-footer-text" class="site-footer-block">' + newval + "</div>"
						);
				}
			} );
		} );

		// Social Links > Style.
		wp.customize( "marianne_social_style", function( value ) {
			value.bind( function( newval ) {
				var target = ".site-social",
					classes = {
						"square": "site-social-square",
						"round": "site-social-round"
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );
	} );
} )( jQuery, wp.customize );
