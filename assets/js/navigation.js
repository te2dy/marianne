/**
 * navigation.js
 *
 * Handles dropdown for the primary menu
 * and toggling it for small screens.
 *
 * Based on the work of the WordPress team in the Twenty Twenty-One Theme.
 *
 * @since Marianne 1.2
 */

/**
 * Collapse menu when the user clicks outside.
 */
function marianneCollapseMenuOnClickOutside( event ) {
	if ( ! document.getElementById( "menu-primary" ).contains( event.target ) ) {
		document.getElementById( "menu-primary" ).querySelectorAll( ".sub-menu-toggle" ).forEach( function( button ) {
			button.setAttribute( "aria-expanded", "false" );
		} );
	}
}

/**
 * Toggle an attribute"s value
 *
 * @param {Element} el - The element.
 */
function marianneToggleAriaExpanded( el, withListeners ) {
	if ( "true" !== el.getAttribute( "aria-expanded" ) ) {
		el.setAttribute( "aria-expanded", "true" );

		if ( withListeners ) {
			document.addEventListener( "click", marianneCollapseMenuOnClickOutside );
		}
	} else {
		el.setAttribute( "aria-expanded", "false" );

		if ( withListeners ) {
			document.addEventListener( "click", marianneCollapseMenuOnClickOutside );
		}
	}
}

/**
 * Handle clicks on submenu toggles except on small screens.
 *
 * @param {Element} el - The element.
 */
function marianneExpandSubMenu( el ) {
	if ( window.matchMedia( "(min-width: 500px)" ).matches ) {
		// Close other expanded items.
		el.closest( "nav" ).querySelectorAll( ".sub-menu-toggle" ).forEach( function( button ) {
			if ( button !== el ) {
				button.setAttribute( "aria-expanded", "false" );
			}
		} );

		// Toggle aria-expanded on the button.
		marianneToggleAriaExpanded( el, true );

		// On tab-away collapse the menu.
		el.parentNode.querySelectorAll( "ul > li:last-child > a" ).forEach( function( linkEl ) {
			linkEl.addEventListener( "blur", function( event ) {
				if ( ! el.parentNode.contains( event.relatedTarget ) ) {
					el.setAttribute( "aria-expanded", "false" );
				}
			} );
		} );
	} else {
		el.removeAttribute( "aria-haspopup" ).removeAttribute( "aria-expanded" );
	}
}

/**
 * Handles aria changes on click.
 *
 * @param {Element} el - The element.
 */
function marianneAriaExpand( el ) {
	if ( "true" !== el.getAttribute( "aria-expanded" ) ) {
		el.setAttribute( "aria-expanded", "true" );
	} else {
		el.setAttribute( "aria-expanded", "false" );
	}
}

( function( $ ) {
	// Adds role and tabindex to menu links.
	var menu_elements = $( "#menu-primary .menu-item" );

	menu_elements.each( function ( el, item ) {
		$( item )
			.children( "a" )
			.attr( "role", "menu-item" );

		$( item )
			.children( "a" )
			.attr( "tabindex", "0" );
	});

	/**
	 * Change aria-expanded value on hover and focus.
	 *
	 * @param $id - The id of the primary menu.
	 */
	function marianneAriaMenu( $id ) {
		var id = $id + " ";

		// On screen wider than 500px.
		if ( ! window.matchMedia( "(max-width: 500px)" ).matches
			&& ! window.matchMedia( "(hover: none)" ).matches
		) {

			// Reset if the mobile menu was first displayed.
			if ( ! $( id + ".sub-menu-toggle" ).attr( "aria-haspopup" )
				|| ! $( id + ".sub-menu-toggle" ).attr( "aria-expended" )
			) {
				$( id + ".sub-menu-toggle" ).attr( "aria-haspopup", "true" );
				$( id + ".sub-menu-toggle" ).attr( "aria-expanded", "false" );
			}

			// On hover, set the aria-expanded attribute to true.
			$( id + ".menu-item-has-children" ).hover( function() {
				if ( $( this ).find( ".sub-menu-toggle" ).attr( "aria-expanded") ) {
					$( this )
						.find( ".sub-menu-toggle" )
						.attr( "aria-expanded", "true" );
				}
			}, function() {
				if ( $( this ).find( ".sub-menu-toggle" ).attr( "aria-expanded") ) {
					$( this )
						.find( ".sub-menu-toggle" )
						.attr( "aria-expanded", "false" );
				}
			} );

			// On submenu element focus, set the aria-expanded attribute to true.
			$( id + ".sub-menu a" ).focus( function() {
				if ( $( this ).parents( ".menu-item-has-children" ).find( ".sub-menu-toggle" ).attr( "aria-expanded" ) ) {
					$( this )
						.parents( ".menu-item-has-children" )
						.find( ".sub-menu-toggle" )
						.attr( "aria-expanded", "true" );
				}
			} );

			$( id + ".sub-menu a" ).blur( function() {
				if ( $( this ).parents( ".menu-item-has-children" ).find( ".sub-menu-toggle" ).attr( "aria-expanded" ) ) {
					$( this )
						.parents( ".menu-item-has-children" )
						.find( ".sub-menu-toggle" )
						.attr( "aria-expanded", "false" );
				}
			} );

			// On submenu button focus, set the aria-expanded attribute to true.
			$( id + ".sub-menu-toggle" ).focus( function() {
				if ( $( this ).closest( ".menu-item-has-children" ).find( ".sub-menu-toggle" ).attr( "aria-expanded" ) ) {
					$( this )
						.closest( ".menu-item-has-children" )
						.find( ".sub-menu-toggle" )
						.attr( "aria-expanded", "true" );
				}
			} );

			$( id + ".sub-menu-toggle" ).blur( function() {
				if ( $( this ).closest( ".menu-item-has-children" ).find( ".sub-menu-toggle" ).attr( "aria-expanded" ) ) {
					$( this )
						.closest( ".menu-item-has-children" )
						.find( ".sub-menu-toggle" )
						.attr( "aria-expanded", "false" );
				}
			} );

			// When esc key is pressed, set the aria-expanded attribute to false.
			document.addEventListener( "keydown", function( event ) {
				var escKey = event.keyCode === 27;

				if ( escKey ) {
					$( ".sub-menu-toggle" ).attr( "aria-expanded", "false" );
				}
			} );

		// On small screen.
		} else {
			$( id + ".sub-menu-toggle" ).removeAttr( "aria-haspopup" );
			$( id + ".sub-menu-toggle" ).removeAttr( "aria-expanded" );

			$( "#menu-mobile-button" )
				.attr( "aria-haspopup", "true" )
				.attr( "aria-expanded", "false" );

			$( "#header-search-button" ).attr( "aria-expanded", "false" );
			$( ".header-search-box" ).hide();

			// When esc key is pressed, hide menu.
			$( document ).keydown( function( e ) {
				var escKey = e.keyCode === 27;

				if ( escKey ) {
					$( "#menu-mobile-button" ).attr( "aria-expanded", "false" );
					$( "#header-search-button" ).attr( "aria-expanded", "false" );
					$( ".header-search-box" ).hide();
				}
			} );

			$( document ).mouseup( function( e ) {
				var container = $( "#menu-primary-container" );

				if ( ! container.is( e.target ) && container.has( e.target ).length === 0 ) {
					$( "#menu-mobile-button" ).attr( "aria-expanded", "false" );
					$( "#header-search-button" ).attr( "aria-expanded", "false" );
					$( ".header-search-box" ).hide();
				}
			} );

			$( "#menu-mobile-button" ).click( function () {
				$( "#header-search-button" ).attr( "aria-expanded", "false" );
				$( ".header-search-box" ).hide();
			} );
		}
	}

	$( window ).on( "load", function() {
		marianneAriaMenu( "#menu-primary" );
	} );

	$( window ).on( "resize", function() {
		marianneAriaMenu( "#menu-primary" );
	} );

	// Enabled search form toggling in the header.
	if ( ! $( "body" ).hasClass( "search" ) ) {
		$( "#header-search-button" ).click( function() {
			$( ".header-search-box" ).toggle();

			$( this ).attr( "aria-expanded", function( index, attr ) {
				return attr === "false" ? "true" : "false";
			} );
		} );
	}
} )( jQuery );
