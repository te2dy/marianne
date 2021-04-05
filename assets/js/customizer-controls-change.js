( function( $ ) {
	"use strict";

	$( document ).ready( function( $ ) {
		/* Show/hide controls depending on other control values. */

		// The speed of animations.
		var speed = 200;

		// Show Custom Page Width only when 'Custom' is checked.
		if ( $( '#customize-control-custom_logo .remove-button' ).length > 0 ) {
			$( '#customize-control-marianne_header_logo_round' ).show();
		} else {
			$( '#customize-control-marianne_header_logo_round' ).hide();
		}

		$( '#customize-control-custom_logo' ).on( 'DOMSubtreeModified', function () {
			if ( $( '#customize-control-custom_logo .remove-button' ).length > 0 ) {
				$( '#customize-control-marianne_header_logo_round' ).show( speed );
			} else {
				$( '#customize-control-marianne_header_logo_round' ).hide( speed );
			}
		});

		// Show Search button text only when the search button is enabled.
		if ( $( '#_customize-input-marianne_header_menu_search' ).is( ':checked' ) ) {
			$( '#customize-control-marianne_header_menu_search_text' ).show();
		} else {
			$( '#customize-control-marianne_header_menu_search_text' ).hide();
		}

		$( '#_customize-input-marianne_header_menu_search' ).change( function () {
			if ( $( '#_customize-input-marianne_header_menu_search' ).is( ':checked' ) ) {
				$( '#customize-control-marianne_header_menu_search_text' ).show( speed );
			} else {
				$( '#customize-control-marianne_header_menu_search_text' ).hide( speed );
			}
		});

		// Show Phone Type only when a phone number is typed.
		if ( $( '#_customize-input-marianne_social_phone' ).val().length > 0 ) {
			$( '#customize-control-marianne_social_phone_type' ).show();
		} else {
			$( '#customize-control-marianne_social_phone_type' ).hide();
		}

		$( '#_customize-input-marianne_social_phone' ).on( 'input', function () {
			if ( $( this ).val().length > 0 ) {
				$( '#customize-control-marianne_social_phone_type' ).show( speed );
			} else {
				$( '#customize-control-marianne_social_phone_type' ).hide( speed );
			}
		});
	} );
} )( jQuery, wp.customize );
