<?php
/**
 * Enqueue scripts and styles.
 */
function directory_theme_scripts() {
	// Load theme information.
	// Load main theme styles.
    wp_enqueue_style( 'directory-theme-style', get_template_directory_uri() . '/assets/css/style.css', array(), DIRECTORY_STARTER_VER );
    wp_enqueue_style( 'jquery-mmenu', get_template_directory_uri() . '/assets/css/jquery.mmenu.css', array(), DIRECTORY_STARTER_VER );
	// Load main theme responsive styles.
	wp_enqueue_style( 'directory-theme-style-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array('directory-theme-style'), DIRECTORY_STARTER_VER );
	// load font-awesome
	wp_register_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), DIRECTORY_STARTER_VER);
	wp_enqueue_style('font-awesome');

	// Load main theme js.
    wp_enqueue_script( 'directory-theme-script', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), DIRECTORY_STARTER_VER, true );
    wp_enqueue_script( 'jquery-mmenu', get_template_directory_uri() . '/assets/js/jquery.mmenu.min.js', array( 'jquery' ), DIRECTORY_STARTER_VER, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$query_args = array(
		'family' => 'Lato:400,700',
	);
	wp_enqueue_style( 'directory-theme_google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );

    ob_start();
    directory_theme_customize_css();
    $customizer_css = ob_get_clean();

    wp_add_inline_style( 'directory-theme-style', $customizer_css );
	
}
add_action( 'wp_enqueue_scripts', 'directory_theme_scripts' );



/**
 * Customizer Js
 */
function dt_theme_customizer_live_preview()
{
	wp_enqueue_script(
		'dt-theme-customizer-js',
		get_template_directory_uri().'/assets/js/theme-customizer.js',
		array( 'jquery','customize-preview' ),
		'0.1',
		true
	);
}
add_action( 'customize_preview_init', 'dt_theme_customizer_live_preview' );