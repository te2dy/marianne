( function( $ ) {
	"use strict";

	$( document ).ready( function( $ ) {
		/*
		 *
		 * UNUSED AND NOT MINIFIED YET
		 *
		 */
		// The speed of animations.
		var speed = 200;

		// Show Custom Page Width only when 'Custom' is checked.
		if ( $( 'input[id="_customize-input-marianne_global_page_width-radio-custom"]' ).is( ':checked' ) ) {
			$( '#customize-control-marianne_global_page_width_custom' ).show();
		} else {
			$( '#customize-control-marianne_global_page_width_custom' ).hide();
		}

		$( '#customize-control-marianne_global_page_width input[type=radio]' ).change( function () {
			if ( $( 'input[id="_customize-input-marianne_global_page_width-radio-custom"]' ).is( ':checked' ) ) {
				$( '#customize-control-marianne_global_page_width_custom' ).show( speed );
			} else {
				$( '#customize-control-marianne_global_page_width_custom' ).hide( speed );
			}
		});
	} );
} )( jQuery, wp.customize );
