( function( $ ) {
	"use strict";

	$( document ).ready( function( $ ) {
		/* Show/hide controls depending on other control values. */

		// The speed of animations.
		var speed = 200;

		// Show 'Make the logo round' option only when a loge is set.
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

		// Show Sidebar Width only when 'Left sidebar' layout is selected.
		if ( $( '#marianne_global_layout_sidebar-left' ).is( ':checked' ) ) {
			$( '#customize-control-marianne_global_sidebar_width' ).show();
		} else {
			$( '#customize-control-marianne_global_sidebar_width' ).hide();
		}

		$( '#customize-control-marianne_global_layout input[type="radio"]' ).change( function () {
			if ( $( '#marianne_global_layout_sidebar-left' ).is( ':checked' ) ) {
				$( '#customize-control-marianne_global_sidebar_width' ).show( speed );
			} else {
				$( '#customize-control-marianne_global_sidebar_width' ).hide( speed );
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
