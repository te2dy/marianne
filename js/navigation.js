/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
function marianneToggleAriaExpanded( el ) {
	if ( 'true' !== el.getAttribute( 'aria-expanded' ) ) {
		el.setAttribute( 'aria-expanded', 'true' );
		el.addClass( 'submenu-show' );
	} else {
		el.setAttribute( 'aria-expanded', 'false' );
		el.addClass( 'submenu-hide' );
	}
}

/**
 * Handle clicks on submenu toggles.
 *
 * @param {Element} el - The element.
 */
function marianneExpandSubMenu( el ) {
	// Close other expanded items.
	el.closest( 'nav' ).querySelectorAll( '.sub-menu-toggle' ).forEach( function( button ) {
		if ( button !== el ) {
			button.setAttribute( 'aria-expanded', 'false' );
		}
	} );

	// Toggle aria-expanded on the button.
	marianneToggleAriaExpanded( el );

	// On tab-away collapse the menu.
	el.parentNode.querySelectorAll( 'ul > li:last-child > a' ).forEach( function( linkEl ) {
		linkEl.addEventListener( 'blur', function( event ) {
			if ( ! el.parentNode.contains( event.relatedTarget ) ) {
				el.setAttribute( 'aria-expanded', 'false' );
			}
		} );
	} );
}

(function ($) {
	"use strict";

	// Menu mobile.
	$("#menu-mobile-button").click(function () {
		$("#menu-primary-container").slideToggle(200);
	});

	/**
	 * Indicate submenus
	 *
	 * Adds the attributes aria-haspopup and aria-expanded
	 * to links to submenus with their default values.
	 */
	var menu_elements = $('#menu-primary .menu-item');
	menu_elements.each(function(el, item) {
		$(item).children('a').attr('role', 'menu-item');

		var submenu = $(this).children('.sub-menu');
		if (submenu.length > 0) {
			$(item).children('a').attr('aria-haspopup', 'true');
			$(item).children('a').attr('aria-expanded', 'false');
		}

		$(item).children('a').attr('tabindex', '-1');
	});

	// Change aria-expanded value on hover.
	$('#menu-primary .menu-item-has-children a').hover(function(){
		$(this).attr('aria-expanded', 'true');
	}, function(){
		$(this).attr('aria-expanded', 'false');
	});

})(jQuery);
