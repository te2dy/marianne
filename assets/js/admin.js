/**
 * Toggle the attribute aria-expanded value.
 *
 * @param {Element} el - The element.
 */
function marianneAdminDonateButton( el ) {
	if ( el.getAttribute( "aria-haspopup" ) ) {
		if ( el.getAttribute( "aria-expanded" ) === "false" ) {
			el.setAttribute( "aria-expanded", "true" );
		} else if ( el.getAttribute( "aria-expanded" ) === "true" ) {
			el.setAttribute( "aria-expanded", "false" );
		}
	}
}
