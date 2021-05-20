/**
 * images.js
 *
 * EXPLICATIONS
 *
 * @since Marianne 1.?
 */


( function( $ ) {
	/**
	 * Image Overflow
	 *
	 * @see Theme Customizer
	 */

	var imageoverflowoption = marianne_img_options.setting,
		imageoverflowportrait = false,
		imageoverflowwidth = parseInt( marianne_img_options.overflow_width, 10 ),
		pagewidth = parseInt( marianne_img_options.content_width, 10 ),
		imageoverflow_max = pagewidth + ( imageoverflowwidth * 2 ),
		imageoverflow_min = pagewidth,
		imagewidth,
		imageheight,
		sidebar = 'none',
		margin = 'double',
		margin_value,
		maxwidth_value_calc;

	if ( '1' === marianne_img_options.include_portrait ) {
		imageoverflowportrait = true;
	}

	function imageoverflow( $element, $sidebar ) {
		var img = new Image();
		img.src = $( $element ).attr( "src" );
		img.onload = function () {
			if ( $element.attributes['width'] && $element.attributes['width'].value ) {
				imagewidth = parseInt( $element.attributes['width'].value, 10 );
			} else {
				imagewidth = this.width;
			}

			if ( $element.attributes['height'] && $element.attributes['height'].value !== 'undefined' ) {
				imageheight = parseInt( $element.attributes['height'].value, 10 );
			} else {
				imageheight = this.height;
			}

			console.log( imageoverflow_min );

			if ( imagewidth > imageoverflow_min && ! $( $element ).parents( ".wp-block-gallery" ).length ) {

				console.log( 'ok' );

				if ( imagewidth >= imageheight
					|| ( imagewidth < imageheight && false !== imageoverflowportrait )
				) {

					// If the image width is superior to the maximum overflow width.
					if ( imagewidth >= imageoverflow_max ) {

						if ( $( $element ).attr( "style" ) ) {
							$( $element ).removeAttr( "style" );
						}

						if ( ! window.matchMedia( "(max-width: " + imageoverflow_max + "px)" ).matches ) {
							if ( 'double' === margin ) {
								margin_value = '0 -' + imageoverflowwidth + 'px';
								maxwidth_value_calc = '100% + ' + imageoverflowwidth * 2 + 'px';
							} else if ( 'simple-right' === margin ) {
								margin_value = '0 -' + imageoverflowwidth + 'px 0 0';
								maxwidth_value_calc = '100% + ' + imageoverflowwidth + 'px';
							} else {
								margin_value = '0 0 0 -' + imageoverflowwidth + 'px';
								maxwidth_value_calc = '100% + ' + imageoverflowwidth + 'px';
							}

							$($element).css({
								'margin': margin_value,
								'max-width': 'calc(' + maxwidth_value_calc + ')'
							});
							$($element).attr('style', $($element).attr('style') + ' max-width: -moz-calc(' + maxwidth_value_calc + ');' + ' max-width: -webkit-calc(' + maxwidth_value_calc + ');');

						// If the image width is superior to the page width but inferior to the maximum overflow width.
						} else {
							margin_value = '0 calc(50% - 50vw)';

							$($element).css({
								'max-width': '100vw',
								'margin': margin_value
							});
							$($element).attr('style', $($element).attr('style') + ' margin: 0 -moz-calc(50% - 50vw);' + ' margin: 0 -webkit-calc(' + Math.floor($('.site').width() / 2) + 'px - ' + Math.floor($('body').width() / 2) + 'px);');
						}

					} else {
						if ('double' === margin) {
							margin_value = '0 -' + ((imagewidth - pagewidth) / 2) + 'px';
						} else if ('simple-right' === margin) {
							margin_value = '0 -' + ((imagewidth - pagewidth) / 2) + 'px 0 0';

						} else {
							margin_value = '0 0 0 -' + ((imagewidth - pagewidth) / 2) + 'px';
						}

						$($element).css('margin', margin_value);
						$($element).css('max-width', 'calc(100% + ' + (imagewidth - pagewidth) + 'px)');
						$($element).attr('style', $($element).attr('style') + ' max-width: -moz-calc(100% + ' + (imagewidth - pagewidth) + 'px);' + ' max-width: -webkit-calc(100% + ' + (imagewidth - pagewidth) + 'px);');
					}
				}
			}
		};
	}

	if ( $( "body" ).hasClass( "two-columns" ) ) {
		if ( $( "body" ).hasClass( "sidebar-left" ) ) {
			sidebar = "left";
		} else {
			sidebar = "right";
		}
	}
	if ( "left" === sidebar ) {
		margin = "simple-right";
	} else if ( 'right' === sidebar ) {
		margin = "simple-left";
	}

	if ( "all" === imageoverflowoption ) {
		$( ".entry-thumbnail img" ).each( function() {
			imageoverflow( this, margin );
		});
		$( ".entry-content img").each( function() {
			imageoverflow( this, margin );
		});
	} else if ( "featured" === imageoverflowoption ) {
		$( ".entry-thumbnail img" ).each( function() {
			imageoverflow( this, margin );
		});
	}

	$( window ).resize( function() {
		if ( "all" === imageoverflowoption ) {
			$( ".entry-thumbnail img" ).each( function() {
				imageoverflow( this, margin );
			});
			$( ".entry-content img" ).each( function() {
				imageoverflow( this, margin );
			});
		} else if ( "thumbnail" === imageoverflowoption ) {
			$( ".entry-thumbnail img" ).each( function() {
				imageoverflow( this, margin );
			});
		}
	});
} )( jQuery );
