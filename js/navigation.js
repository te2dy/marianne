/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
(function ($) {
	"use strict";

	$("#menu-mobile-button").click(function () {
		$("#menu-primary-container").slideToggle(200);
	});
	
	
})(jQuery);
