( function( $ ) {
	"use strict";

	$( document ).ready( function( $ ) {
		/**
		 * Configure live preview in the Theme Customizer.
		 */

		// Site title.
		wp.customize( 'blogname', function( value ) {
			value.bind( function( newval ) {
				if ( $( '.site-title' ).children( 'a' ).length === 0 ) {
					$( '.site-title' ).html( newval );
				} else {
					$( '.site-title a' ).html( newval );
				}
			} );
		} );

		// Site description.
		wp.customize( 'blogdescription', function( value ) {
			value.bind( function( newval ) {
				$( '.site-description' ).html( newval );
			} );
		} );

		// Color scheme.
		wp.customize( 'colors_scheme', function( value ) {
			value.bind( function( newval ) {
				if ( $( 'body' ).hasClass( 'color-scheme-light' ) ) {
					$( 'body' ).removeClass( 'color-scheme-light' );
				}

				if ( $( 'body' ).hasClass( 'color-scheme-dark' ) ) {
					$( 'body' ).removeClass( 'color-scheme-dark' );
				}

				if ( $( 'body' ).hasClass( 'color-scheme-auto' ) ) {
					$( 'body' ).removeClass( 'color-scheme-auto' );
				}

				if ( newval === 'light' ) {
					$( 'body' ).addClass( 'color-scheme-light' );
				} else if ( newval === 'dark' ) {
					$( 'body' ).addClass( 'color-scheme-dark' );
				} else if ( newval === 'auto' ) {
					$( 'body' ).addClass( 'color-scheme-auto' );
				}
			} );
		} );

		// Hovered elements.
		wp.customize( 'colors_link_hover', function( value ) {
			value.bind( function( newval ) {
				if ( $( 'body' ).hasClass( 'link-hover-blue' ) ) {
					$( 'body' ).removeClass( 'link-hover-blue' );
				}

				if ( $( 'body' ).hasClass( 'link-hover-red' ) ) {
					$( 'body' ).removeClass( 'link-hover-red' );
				}

				if ( $( 'body' ).hasClass( 'link-hover-green' ) ) {
					$( 'body' ).removeClass( 'link-hover-green' );
				}

				if ( $( 'body' ).hasClass( 'link-hover-orange' ) ) {
					$( 'body' ).removeClass( 'link-hover-orange' );
				}

				if ( $( 'body' ).hasClass( 'link-hover-purple' ) ) {
					$( 'body' ).removeClass( 'link-hover-purple' );
				}

				if ( newval === 'blue' ) {
					$( 'body' ).addClass( 'link-hover-blue' );
				} else if ( newval === 'red' ) {
					$( 'body' ).addClass( 'link-hover-red' );
				} else if ( newval === 'green' ) {
					$( 'body' ).addClass( 'link-hover-green' );
				} else if ( newval === 'orange' ) {
					$( 'body' ).addClass( 'link-hover-orange' );
				} else if ( newval === 'purple' ) {
					$( 'body' ).addClass( 'link-hover-purple' );
				}
			} );
		} );
	} );
} )( jQuery, wp.customize );
