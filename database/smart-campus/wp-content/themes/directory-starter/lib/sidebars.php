<?php
function directory_theme_widgets_init()
{
	// Sidebars
	register_sidebar(array(
		'name' => __('Sidebar Blog', 'directory-starter'),
		'id' => 'sidebar-primary',
		'description' => __( 'Sidebar for blog pages, can be enabled from customizer Body>Sidebar', 'directory-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __('Sidebar Page', 'directory-starter'),
		'id' => 'pages',
		'description' => __( 'Sidebar for pages.', 'directory-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(array(
			'name' => __('Sidebar WooCommerce', 'directory-starter'),
			'id' => 'sidebar-wc',
			'description' => __( 'Sidebar for WooCommerce.', 'directory-starter' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}

	if (FOOTER_SIDEBAR_COUNT > 0) {
		register_sidebar(array(
			'name' => __('Sidebar Footer 1', 'directory-starter'),
			'id' => 'sidebar-footer1',
			'description' => __( 'Sidebar Footer 1.', 'directory-starter' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}

	if (FOOTER_SIDEBAR_COUNT > 1) {
		register_sidebar(array(
			'name' => __('Sidebar Footer 2', 'directory-starter'),
			'id' => 'sidebar-footer2',
			'description' => __( 'Sidebar Footer 2.', 'directory-starter' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}

	if (FOOTER_SIDEBAR_COUNT > 2) {
		register_sidebar(array(
			'name' => __('Sidebar Footer 3', 'directory-starter'),
			'id' => 'sidebar-footer3',
			'description' => __( 'Sidebar Footer 3.', 'directory-starter' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}

	if (FOOTER_SIDEBAR_COUNT > 3) {
		register_sidebar(array(
			'name' => __('Sidebar Footer 4', 'directory-starter'),
			'id' => 'sidebar-footer4',
			'description' => __( 'Sidebar Footer 4.', 'directory-starter' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		));
	}


}

add_action('widgets_init', 'directory_theme_widgets_init');