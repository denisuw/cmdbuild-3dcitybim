<?php
$menus = array(
		'primary-menu' => __( 'Primary Menu', 'directory-starter' ),   // main menu for header
		'footer-links' => __( 'Footer Links', 'directory-starter' )    // links menu for footer
);
$enable_header_top = esc_attr(get_theme_mod('dt_enable_header_top', DT_ENABLE_HEADER_TOP));
if ($enable_header_top == '1') {
	$menus['header-top'] = __( 'Header Top', 'directory-starter' );
}
// register nav menus
register_nav_menus($menus);