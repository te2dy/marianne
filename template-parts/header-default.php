<?php
/**
 *
 */

$marianne_header_class  = 'site-header';
$marianne_header_class .= ' site-header-align-' . esc_attr( marianne_get_theme_mod( 'marianne_header_align' ) );
?>

<header id="header" <?php marianne_add_class( $marianne_header_class, false ); ?> role="banner">
	<?php
	$marianne_logo_class = 'site-logo';

	if ( true === marianne_get_theme_mod( 'marianne_header_logo_round' ) ) {
		$marianne_logo_class .= ' image-circular';
	}

	marianne_logo( $marianne_logo_class );

	marianne_site_title();

	marianne_site_description();

	if ( 'header' === marianne_get_theme_mod( 'marianne_social_location' ) ) {
		marianne_social_link( 'header' );
	}

	marianne_header_image();

	marianne_menu_primary();
	?>
</header>
