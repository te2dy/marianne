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
		wp.customize( 'blogname', function( value ) {
			value.bind( function( newval ) {
				if ( $( '.site-title' ).children( 'a' ).length === 0 ) {
					$( '.site-title' ).html( newval );
				} else {
					$( '.site-title a' ).html( newval );
				}
			} );
		} );

		// Site Identity > Site description.
		wp.customize( 'blogdescription', function( value ) {
			value.bind( function( newval ) {
				$( '.site-description' ).html( newval );
			} );
		} );

		// Colors > Color Scheme.
		wp.customize( 'colors_scheme', function( value ) {
			value.bind( function( newval ) {
				var target = 'body',
					classes = {
						'light': 'color-scheme-light',
						'dark': 'color-scheme-dark',
						'auto': 'color-scheme-auto',
					};

					marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Colors > Hovered Elements.
		wp.customize( 'colors_link_hover', function( value ) {
			value.bind( function( newval ) {
				var target = 'body',
					classes = {
						'blue': 'link-hover-blue',
						'red': 'link-hover-red',
						'green': 'link-hover-green',
						'orange': 'link-hover-orange',
						'purple': 'link-hover-purple'
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Global > Page Width.
		wp.customize( 'marianne_global_page_width', function( value ) {
			value.bind( function( newval ) {
				var target = '.site',
					classes = {
						'480': 'page-width-480',
						'600': 'page-width-600',
						'720': 'page-width-720',
						'custom': 'page-width-custom'
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		wp.customize( 'marianne_global_page_width_custom', function( value ) {
			value.bind( function( newval ) {
				if ( 'custom' === wp.customize( 'marianne_global_page_width' ).get() ) {
					$( '#page' ).css( 'max-width', newval + 'px' );
				}
			} );
		} );

		// Global > Font Family.
		wp.customize( 'marianne_global_font_family', function( value ) {
			value.bind( function( newval ) {
				var target = 'body',
					classes = {
						'sans-serif': 'font-family-sans-serif',
						'serif': 'font-family-serif',
						'monospace': 'font-family-monospace'
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Global > Font Size.
		wp.customize( 'marianne_global_font_size', function( value ) {
			value.bind( function( newval ) {
				var target = 'body',
					classes = {
						80: 'font-size-80',
						90: 'font-size-90',
						100: 'font-size-100',
						110: 'font-size-110',
						120: 'font-size-120'
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Global > Text Shadow.
		wp.customize( 'marianne_global_text_shadow', function( value ) {
			value.bind( function( newval ) {
				var target = 'body',
					classToAdd = 'text-shadow';

				marianneCheckboxToggleClass( target, classToAdd, newval );
			} );
		} );

		// Content Formatting > Text Align.
		wp.customize( 'marianne_content_text_align', function( value ) {
			value.bind( function( newval ) {
				var target = [
						'.entry-content',
						'.comment-content'
					],
					classes = {
						'left': 'text-align-left',
						'center': 'text-align-center',
						'right': 'text-align-right',
						'justify': 'text-align-justify'
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );

		// Content Formatting > Hyphenation.
		wp.customize( 'marianne_content_hyphens', function( value ) {
			value.bind( function( newval ) {
				var target = '.entry-content',
					classToAdd = 'text-hyphens';

				marianneCheckboxToggleClass( target, classToAdd, newval );
			} );
		} );

		// Footer Settings > Footer Text.
		wp.customize( 'marianne_footer_text', function( value ) {
			value.bind( function( newval ) {
				if ( $( '#site-footer-text' ).length ) {
					$( '#site-footer-text' ).html( newval );
				} else {
					$( '.site-footer' )
						.prepend(
							'<div id="site-footer-text" class="site-footer-block">' + newval + '</div>'
						);
				}
			} );
		} );

		// Social Links > Style.
		wp.customize( 'marianne_social_style', function( value ) {
			value.bind( function( newval ) {
				var target = '.site-social',
					classes = {
						'round': 'site-social-round',
						'square': 'site-social-square'
					};

				marianneSelectRadioToggleClass( target, classes, newval );
			} );
		} );
	} );
} )( jQuery, wp.customize );
