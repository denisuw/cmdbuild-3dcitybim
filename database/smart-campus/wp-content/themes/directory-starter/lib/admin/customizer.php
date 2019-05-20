<?php
function directory_theme_customizer( $wp_customize ) {

/**
 * Table of Contents
 *
 * 1.0 - General
 *   1.1 - Site Identity
 *   	1.1.1 - Blog Name
 *      1.1.2 - Tagline
 *      1.1.3 - Colors
 *   1.2 - Spacing
 *      1.2.1 - Desktop Container Width
 *      1.2.2 - Container Padding Right
 *      1.2.3 - Container Padding Left
 *      1.2.4 - Container Margin Right
 *      1.2.5 - Container Margin Left
 *   1.3 - Static Front Page
 *      1.3.1 - Front Page
 *   1.4 - Alert Colors
 *      1.4.1 - Alert Warning Background Color
 *      1.4.2 - Alert Error Background Color
 *      1.4.3 - Alert Success Background Color
 *      1.4.4 - Alert Info Background Color
 *      1.4.5 - Alert Warning Text Color
 *      1.4.6 - Alert Error Text Color
 *      1.4.7 - Alert Success Text Color
 *      1.4.8 - Alert Info Text Color
 *      1.4.9 - Alert Warning Border Color
 *      1.4.10 - Alert Error Border Color
 *      1.4.11 - Alert Success Border Color
 *      1.4.12 - Alert Info Border Color
 * 	 1.5 - Button Colors
 *      1.5.1 - Button Text Color
 *      1.5.2 - Button Background Color
 *      1.5.3 - Button Hover Background Color
 *      1.5.4 - Button Border Color
 * 2.0 - Header
 *   2.1 - Header Top
 *      2.1.1 - Enable Header Top Section
 *      2.1.2 - Header Top Text Color
 *      2.1.3 - Header Top Link Color
 *      2.1.4 - Header Top Link Hover Color
 * 		2.1.5 - Header Top Background Color
 *   2.2 - Logo
 * 		2.2.1 - Logo
 *   2.3 - Header Image
 * 		2.3.1 - Header Image
 *   2.4 - Text Colors
 * 		2.4.1 - Header Text color
 * 		2.4.2 - Header Link color
 *      2.4.3 - Header Link Hover Color
 *   2.5 - Background Colors
 * 		2.5.1 - Header Background Color
 * 		2.5.2 - Header Border Color
 * 		2.5.3 - Header Shadow Color
 * 		2.5.4 - Primary Menu - Sub menu Background Color
 *      2.5.5 - Primary Menu - Sub menu Background hover Color
 *   2.6 - Typography
 *   2.7 - Spacing
 * 		2.7.1 - Header Height
 * 		2.7.2 - Logo Margin Right
 * 		2.7.3 - Logo Margin Left
 * 		2.7.4 - Logo Margin Top
 * 		2.7.5 - Primary Menu Height
 * 		2.7.6 - Primary Menu Line Height
 * 		2.7.7 - Primary Menu Padding Left Right
 *      2.7.8 - Header Logo Width
 *      2.7.9 - Header Menu Width
 * 3.0 - Body
 *   3.1 - Background Image
 * 		3.1.1 - Background Image
 *   3.2 - Text Colors
 * 		3.2.1 - Body Color
 * 		3.2.2 - h1 to h6 Color
 * 		3.2.3 - Link Color
 * 		3.2.4 - Link Hover Color
 * 		3.2.5 - Link Visited Color
 *   3.3 - Background Colors
 * 		3.3.1 - Body Background Color
 * 		3.3.2 - Content Box Background Color
 * 		3.3.3 - Content Box Border Color
 * 		3.3.4 - Content Box Shadow Color
 *   3.4 - Typography
 * 		3.4.1 - Font Family
 * 		3.4.2 - Font Size
 * 		3.4.3 - Line Height
 *   3.5 - Spacing
 *   3.6 - Sidebar
 * 		3.6.1 - Enable Blog Sidebar
 *      3.6.2 - Enable WooCommerce Sidebar
 *      3.6.3 - Blog Sidebar Position
 * 4.0 - Footer
 *   4.1 - Text Colors
 * 		4.1.1 - Text Color
 * 		4.1.2 - h1 to h6 Color
 * 		4.1.3 - Link Color
 * 		4.1.4 - Link Hover Color
 * 		4.1.5 - Link Visited Color
 *   4.2 - Background Colors
 * 		4.2.1 - Footer Section Background Color
 * 		4.2.2 - Footer Section Border Top Color
 * 		4.2.3 - Footer Section Border Bottom Color
 * 		4.2.4 - Footer Section Box Shadow Color
 *   4.3 - Typography
 *   4.4 - Spacing
 * 5.0 - Copyright
 * 	5.1 - Text Colors
 * 		5.1.1 - Text Color
 * 		5.1.2 - Link Color
 * 		5.1.3 - Link Hover Color
 * 		5.1.4 - Link Visited Color
 *	5.2 - Background Colors
 * 		5.2.1 - Copyright Section Background Color
 * 		5.2.2 - Copyright Section Border Color
 * 	5.3 - Typography
 * 	5.4 - Spacing
 * 		5.4.1 - Copyright Padding Top
 * 		5.4.2 - Copyright Padding Bottom
 */


//  =============================
//  1.0 - General
//  =============================

$wp_customize->add_panel( 'dt_general_panel', array(
	'priority'       => 10,
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'title'          => __('General', 'directory-starter' ),
	'description'    => '',
) );

	//  =============================
	//  1.1 - Site Identity
	//  =============================

		//  =============================
		//  1.1.1 - Blog Name
		//  =============================

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

		//  =============================
		//  1.1.2 - Tagline
		//  =============================

		$wp_customize->get_section( 'title_tagline' )->panel  = 'dt_general_panel';

		//  =============================
		//  1.1.3 - Colors
		//  =============================

		$wp_customize->get_section( 'colors' )->panel  = 'dt_general_panel';

	//  =============================
	//  1.2 - Spacing
	//  =============================

	$wp_customize->add_section( 'dt_general_spacing_section', array(
			'title'       => __( 'Spacing', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Spacing', 'directory-starter' ),
			'panel'  => 'dt_general_panel',
	) );

		//  =============================
		//  1.2.1 - Desktop Container Width
		//  =============================

		$wp_customize->add_setting( 'dt_container_width', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_container_width_default_value', DT_CONTAINER_WIDTH),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options'
		) );
		$wp_customize->add_control( 'dt_container_width', array(
				'type'        => 'text',
				'label'   => __( 'Desktop Container Width', 'directory-starter' ),
				'section' => 'dt_general_spacing_section',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTAINER_WIDTH ),
		) );

		//  =============================
		//  1.2.2 - Container Padding Right
		//  =============================

		$wp_customize->add_setting( 'dt_container_padding_right', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_container_padding_right_default_value', DT_CONTAINER_PADDING_RIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_container_padding_right', array(
				'label'   => __( 'Container Padding Right', 'directory-starter' ),
				'section' => 'dt_general_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTAINER_PADDING_RIGHT ),
		) );

		//  =============================
		//  1.2.3 - Container Padding Left
		//  =============================

		$wp_customize->add_setting( 'dt_container_padding_left', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_container_padding_left_default_value', DT_CONTAINER_PADDING_LEFT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_container_padding_left', array(
				'label'   => __('Container Padding Left', 'directory-starter' ),
				'section' => 'dt_general_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTAINER_PADDING_LEFT ),
		) );

		//  =============================
		//  1.2.4 - Container Margin Right
		//  =============================

		$wp_customize->add_setting( 'dt_container_margin_right', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_container_margin_right_default_value', DT_CONTAINER_MARGIN_RIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_container_margin_right', array(
				'label'   => __('Container Margin Right', 'directory-starter' ),
				'section' => 'dt_general_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTAINER_MARGIN_RIGHT ),
		) );

		//  =============================
		//  1.2.5 - Container Margin Left
		//  =============================

		$wp_customize->add_setting( 'dt_container_margin_left', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_container_margin_left_default_value', DT_CONTAINER_MARGIN_LEFT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_container_margin_left', array(
				'label'   => __('Container Margin Left', 'directory-starter' ),
				'section' => 'dt_general_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTAINER_MARGIN_LEFT ),
		) );

	//  =============================
	//  1.3 - Static Front Page
	//  =============================

		//  =============================
		//  1.3.1 - Front Page
		//  =============================

		$wp_customize->get_section( 'static_front_page' )->panel  = 'dt_general_panel';
		$wp_customize->get_section( 'static_front_page' )->priority  = 40;

	//  =============================
	//  1.4 - Alert Colors
	//  =============================

	$wp_customize->add_section( 'dt_alerts_section', array(
			'title'       => __( 'Alert Colors', 'directory-starter' ),
			'priority'    => 50,
			'description' => __( 'Alert Colors', 'directory-starter' ),
			'panel'  => 'dt_general_panel',
	) );

		//  =============================
		//  1.4.1 - Alert Warning Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_yellow', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_yellow_default_value', DT_ALERT_YELLOW),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_yellow', array(
				'label'       => __( 'Alert Warning Background Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_yellow',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_YELLOW ),
		) ) );

		//  =============================
		//  1.4.2 - Alert Error Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_red', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_red_default_value', DT_ALERT_RED),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_red', array(
				'label'       => __( 'Alert Error Background Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_red',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_RED ),
		) ) );

		//  =============================
		//  1.4.3 - Alert Success Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_green', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_green_default_value', DT_ALERT_GREEN),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_green', array(
				'label'       => __( 'Alert Success Background Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_green',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_GREEN ),
		) ) );

		//  =============================
		//  1.4.4 - Alert Info Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_blue', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_blue_default_value', DT_ALERT_BLUE),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_blue', array(
				'label'       => __( 'Alert Info Background Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_blue',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_BLUE ),
		) ) );

		//  =============================
		//  1.4.5 - Alert Warning Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_yellow_text', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_yellow_text_default_value', DT_ALERT_YELLOW_TEXT),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_yellow_text', array(
				'label'       => __( 'Alert Warning Text Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_yellow_text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_YELLOW_TEXT ),
		) ) );

		//  =============================
		//  1.4.6 - Alert Error Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_red_text', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_red_text_default_value', DT_ALERT_RED_TEXT),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_red_text', array(
				'label'       => __( 'Alert Error Text Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_red_text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_RED_TEXT ),
		) ) );

		//  =============================
		//  1.4.7 - Alert Success Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_green_text', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_green_text_default_value', DT_ALERT_GREEN_TEXT),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_green_text', array(
				'label'       => __( 'Alert Success Text Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_green_text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_GREEN_TEXT ),
		) ) );

		//  =============================
		//  1.4.8 - Alert Info Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_blue_text', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_blue_text_default_value', DT_ALERT_BLUE_TEXT),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_blue_text', array(
				'label'       => __( 'Alert Info Text Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_blue_text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_BLUE_TEXT ),
		) ) );

		//  =============================
		//  1.4.9 - Alert Warning Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_yellow_border', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_yellow_border_default_value', DT_ALERT_YELLOW_BORDER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_yellow_border', array(
				'label'       => __( 'Alert Warning Border Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_yellow_border',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_YELLOW_BORDER ),
		) ) );

		//  =============================
		//  1.4.10 - Alert Error Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_red_border', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_red_border_default_value', DT_ALERT_RED_BORDER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_red_border', array(
				'label'       => __( 'Alert Error Border Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_red_border',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_RED_BORDER ),
		) ) );

		//  =============================
		//  1.4.11 - Alert Success Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_green_border', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_green_border_default_value', DT_ALERT_GREEN_BORDER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_green_border', array(
				'label'       => __( 'Alert Success Border Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_green_border',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_GREEN_BORDER ),
		) ) );

		//  =============================
		//  1.4.12 - Alert Info Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_alert_blue_border', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_alert_blue_border_default_value', DT_ALERT_BLUE_BORDER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_alert_blue_border', array(
				'label'       => __( 'Alert Info Border Color', 'directory-starter' ),
				'section'     => 'dt_alerts_section',
				'settings'    => 'dt_alert_blue_border',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ALERT_BLUE_BORDER ),
		) ) );

	//  =============================
	//  1.5 - Button Colors
	//  =============================

	$wp_customize->add_section( 'dt_button_section', array(
			'title'       => __( 'Button Colors', 'directory-starter' ),
			'priority'    => 50,
			'description' => __( 'Button Colors', 'directory-starter' ),
			'panel'  => 'dt_general_panel',
	) );

		//  =============================
		//  1.5.1 - Button Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_btn_text_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_btn_text_color_default_value', DT_BTN_TEXT_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_btn_text_color', array(
				'label'       => __( 'Button Text Color', 'directory-starter' ),
				'section'     => 'dt_button_section',
				'settings'    => 'dt_btn_text_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_BTN_TEXT_COLOR ),
		) ) );

		//  =============================
		//  1.5.2 - Button Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_btn_bg_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_btn_bg_color_default_value', DT_BTN_BG_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_btn_bg_color', array(
				'label'       => __( 'Button Background Color', 'directory-starter' ),
				'section'     => 'dt_button_section',
				'settings'    => 'dt_btn_bg_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_BTN_BG_COLOR ),
		) ) );

		//  =============================
		//  1.5.3 - Button Hover Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_btn_hover_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_btn_hover_color_default_value', DT_BTN_HOVER_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_btn_hover_color', array(
				'label'       => __( 'Button Hover Background Color', 'directory-starter' ),
				'section'     => 'dt_button_section',
				'settings'    => 'dt_btn_hover_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_BTN_HOVER_COLOR ),
		) ) );

		//  =============================
		//  1.5.4 - Button Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_btn_border_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_btn_border_color_default_value', DT_BTN_BORDER_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_btn_border_color', array(
				'label'       => __( 'Button Border Color', 'directory-starter' ),
				'section'     => 'dt_button_section',
				'settings'    => 'dt_btn_border_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_BTN_BORDER_COLOR ),
		) ) );


//  =============================
//  2.0 - Header
//  =============================

$wp_customize->add_panel( 'dt_header_panel', array(
	'priority'       => 20,
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'title'          => __('Header', 'directory-starter' ),
	'description'    => '',
) );

	//  =============================
	//  2.1 - Header Top
	//  =============================

	$wp_customize->add_section( 'dt_header_top_section', array(
			'title'       => __( 'Header Top', 'directory-starter' ),
			'priority'    => 8,
			'description' => __( 'Header Top', 'directory-starter' ),
			'panel'  => 'dt_header_panel',
	) );

		//  =============================
		//  2.1.1 - Enable Header Top Section
		//  =============================

		$wp_customize->add_setting( 'dt_enable_header_top', array(
				'default' => apply_filters('dt_enable_header_top_default_value', DT_ENABLE_HEADER_TOP),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_enable_header_top', array(
				'label'   => __('Enable Header Top Section', 'directory-starter' ),
				'section' => 'dt_header_top_section',
				'type'    => 'checkbox',
				'std'         => '0',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ENABLE_HEADER_TOP ),
		) );

		//  =============================
		//  2.1.2 - Header Top Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_top_text_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_top_text_color_default_value', DT_HEADER_TOP_TEXT_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_top_text_color', array(
				'label'       => __( 'Header Top Text Color', 'directory-starter' ),
				'section'     => 'dt_header_top_section',
				'settings'    => 'dt_header_top_text_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_TOP_TEXT_COLOR ),
		) ) );

		//  =============================
		//  2.1.3 - Header Top Link Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_top_link_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_top_link_color_default_value', DT_HEADER_TOP_LINK_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_top_link_color', array(
				'label'       => __( 'Header Top Link Color', 'directory-starter' ),
				'section'     => 'dt_header_top_section',
				'settings'    => 'dt_header_top_link_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_TOP_LINK_COLOR ),
		) ) );

		//  =============================
		//  2.1.4 - Header Top Link Hover Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_top_link_hover', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_top_link_hover_default_value', DT_HEADER_TOP_LINK_HOVER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_top_link_hover', array(
				'label'       => __( 'Header Top Link Hover Color', 'directory-starter' ),
				'section'     => 'dt_header_top_section',
				'settings'    => 'dt_header_top_link_hover',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_TOP_LINK_HOVER ),
		) ) );

		//  =============================
		//  2.1.5 - Header Top Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_top_bg_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_top_bg_color_default_value', DT_HEADER_TOP_BG_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_top_bg_color', array(
				'label'       => __( 'Header Top Background Color', 'directory-starter' ),
				'section'     => 'dt_header_top_section',
				'settings'    => 'dt_header_top_bg_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_TOP_BG_COLOR ),
		) ) );

	//  =============================
	//  2.2 - Logo
	//  =============================

	$wp_customize->add_section( 'dt_header_logo_section', array(
			'title'       => __( 'Logo', 'directory-starter' ),
			'priority'    => 9,
			'description' => __( 'Logo', 'directory-starter' ),
			'panel'  => 'dt_header_panel',
	) );

		//  =============================
		//  2.2.1 - Logo
		//  =============================

		$wp_customize->add_setting( 'logo', array(
				'sanitize_callback' => 'esc_url_raw',
				'description' => __( 'Upload a logo to replace the default site name and description in the header', 'directory-starter' ),
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
				'label'    => __( 'Logo', 'directory-starter' ),
				'section'  => 'dt_header_logo_section',
				'settings' => 'logo',
		) ) );

	//  =============================
	//  2.3 - Header Image
	//  =============================

		//  =============================
		//  2.3.1 - Header Image
		//  =============================

		$wp_customize->get_section( 'header_image' )->panel  = 'dt_header_panel';
		$wp_customize->get_section( 'header_image' )->priority  = 10;

	//  =============================
	//  2.4 - Text Colors
	//  =============================

	$wp_customize->add_section( 'dt_header_text_section', array(
			'title'       => __( 'Text Colors', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Text Colors', 'directory-starter' ),
			'panel'  => 'dt_header_panel',
	) );

		//  =============================
		//  2.4.1 - Header Text color
		//  =============================

		$wp_customize->get_control( 'header_textcolor' )->section = 'dt_header_text_section';

		//  =============================
		//  2.4.2 - Header Link color
		//  =============================

		$wp_customize->add_setting( 'dt_header_link_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_link_color_default_value', DT_HEADER_LINK_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_link_color', array(
				'label'       => __( 'Header Link Color', 'directory-starter' ),
				'section'     => 'dt_header_text_section',
				'settings'    => 'dt_header_link_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_LINK_COLOR ),
		) ) );

		//  =============================
		//  2.4.3 - Header Link Hover Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_link_hover', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_link_hover_default_value', DT_HEADER_LINK_HOVER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_link_hover', array(
				'label'       => __( 'Header Link Hover Color', 'directory-starter' ),
				'section'     => 'dt_header_text_section',
				'settings'    => 'dt_header_link_hover',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_LINK_HOVER ),
		) ) );

	//  =============================
	//  2.5 - Background Colors
	//  =============================

	$wp_customize->add_section( 'dt_header_bg_section', array(
			'title'       => __( 'Background Colors', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Background Colors', 'directory-starter' ),
			'panel'  => 'dt_header_panel',
	) );

		//  =============================
		//  2.5.1 - Header Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_bg_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_bg_color_default_value', DT_HEADER_BG_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_bg_color', array(
				'label'       => __( 'Header Background Color', 'directory-starter' ),
				'section'     => 'dt_header_bg_section',
				'settings'    => 'dt_header_bg_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_BG_COLOR ),
		) ) );

		//  =============================
		//  2.5.2 - Header Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_border_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_border_color_default_value', DT_HEADER_BORDER_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_header_border_color', array(
				'label'       => __( 'Header Border Color', 'directory-starter' ),
				'section'     => 'dt_header_bg_section',
				'settings'    => 'dt_header_border_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_BORDER_COLOR ),
		) ) );

		//  =============================
		//  2.5.3 - Header Shadow Color
		//  =============================

		$wp_customize->add_setting( 'dt_header_shadow_color', array(
				'default' => apply_filters('dt_header_shadow_color_default_value', DT_HEADER_SHADOW_COLOR),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_header_shadow_color', array(
				'label'   => __( 'Header Shadow Color', 'directory-starter' ),
				'section' => 'dt_header_bg_section',
				'settings'    => 'dt_header_shadow_color',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_SHADOW_COLOR ),
		) );

		//  =============================
		//  2.5.4 - Primary Menu - Sub menu Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_p_nav_submenu_bg_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_p_nav_submenu_bg_color_default_value', DT_P_NAV_SUBMENU_BG_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_p_nav_submenu_bg_color', array(
				'label'       => __( 'Primary Menu - Sub menu Background Color', 'directory-starter' ),
				'section'     => 'dt_header_bg_section',
				'settings'    => 'dt_p_nav_submenu_bg_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_P_NAV_SUBMENU_BG_COLOR ),
		) ) );

		//  =============================
		//  2.5.5 - Primary Menu - Sub menu Background hover Color
		//  =============================

		$wp_customize->add_setting( 'dt_p_nav_submenu_bg_hover', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_p_nav_submenu_bg_hover_default_value', DT_P_NAV_SUBMENU_BG_HOVER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_p_nav_submenu_bg_hover', array(
				'label'       => __( 'Primary Menu - Sub menu Background hover Color', 'directory-starter' ),
				'section'     => 'dt_header_bg_section',
				'settings'    => 'dt_p_nav_submenu_bg_hover',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_P_NAV_SUBMENU_BG_HOVER ),
		) ) );

	//  =============================
	//  2.6 - Typography
	//  =============================

	$wp_customize->add_section( 'dt_header_typography_section', array(
			'title'       => __( 'Typography', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Typography', 'directory-starter' ),
			'panel'  => 'dt_header_panel',
	) );

	//  =============================
	//  2.7 - Spacing
	//  =============================

	$wp_customize->add_section( 'dt_header_spacing_section', array(
			'title'       => __( 'Spacing', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Spacing', 'directory-starter' ),
			'panel'  => 'dt_header_panel',
	) );

		//  =============================
		//  2.7.1 - Header Height
		//  =============================

		$wp_customize->add_setting( 'dt_header_height', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_header_height_default_value', DT_HEADER_HEIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_header_height', array(
				'label'   => __('Header Min Height', 'directory-starter' ),
				'section' => 'dt_header_spacing_section',
				'settings'    => 'dt_header_height',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_HEIGHT ),
		) );

		//  =============================
		//  2.7.2 - Logo Margin Right
		//  =============================

		$wp_customize->add_setting( 'dt_logo_margin_right', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_logo_margin_right_default_value', DT_LOGO_MARGIN_RIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_logo_margin_right', array(
				'label'   => __('Logo Margin Right', 'directory-starter' ),
				'section' => 'dt_header_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_LOGO_MARGIN_RIGHT ),
		) );

		//  =============================
		//  2.7.3 - Logo Margin Left
		//  =============================

		$wp_customize->add_setting( 'dt_logo_margin_left', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_logo_margin_left_default_value', DT_LOGO_MARGIN_LEFT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_logo_margin_left', array(
				'label'   => __('Logo Margin Left', 'directory-starter' ),
				'section' => 'dt_header_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_LOGO_MARGIN_LEFT ),
		) );

		//  =============================
		//  2.7.4 - Logo Margin Top
		//  =============================

		$wp_customize->add_setting( 'dt_logo_margin_top', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_logo_margin_top_default_value', DT_LOGO_MARGIN_TOP),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_logo_margin_top', array(
				'label'   => __('Logo Margin Top', 'directory-starter' ),
				'section' => 'dt_header_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_LOGO_MARGIN_TOP ),
		) );

		//  =============================
		//  2.7.5 - Primary Menu Height
		//  =============================

		$wp_customize->add_setting( 'dt_p_nav_height', array(
				'default' => apply_filters('dt_p_nav_height_default_value', DT_P_NAV_HEIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_p_nav_height', array(
				'label'   => __('Primary Menu Min Height', 'directory-starter' ),
				'section' => 'dt_header_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_P_NAV_HEIGHT ),
		) );

		//  =============================
		//  2.7.6 - Primary Menu Line Height
		//  =============================

		$wp_customize->add_setting( 'dt_p_nav_line_height', array(
				'default' => apply_filters('dt_p_nav_line_height_default_value', DT_P_NAV_LINE_HEIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_p_nav_line_height', array(
				'label'   => __('Primary Menu Line Height', 'directory-starter' ),
				'section' => 'dt_header_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_P_NAV_LINE_HEIGHT ),
		) );

		//  =============================
		//  2.7.7 - Primary Menu Padding Left Right
		//  =============================

		$wp_customize->add_setting( 'dt_p_nav_padding_left_right', array(
				'default' => apply_filters('dt_p_nav_padding_left_right_default_value', DT_P_NAV_PADDING_LEFT_RIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_p_nav_padding_left_right', array(
				'label'   => __('Primary Menu Padding Left Right', 'directory-starter' ),
				'section' => 'dt_header_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_P_NAV_PADDING_LEFT_RIGHT ),
		) );

        //  =============================
        //  2.7.8 - Header Logo Width
        //  =============================

        $wp_customize->add_setting( 'dt_header_logo_width', array(
            'transport' => 'postMessage',
            'default' => apply_filters('dt_header_logo_width_default_value', DT_HEADER_LOGO_WIDTH.'%'),// customizer escapes % in default value so we need to add %% so it does not
            'sanitize_callback' => 'sanitize_text_field',
            'capability'  => 'edit_theme_options',
        ) );
        $wp_customize->add_control( 'dt_header_logo_width', array(
            'label'   => __('Header Logo Width', 'directory-starter' ),
            'section' => 'dt_header_spacing_section',
            'settings'    => 'dt_header_logo_width',
            'type'    => 'text',
            'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_LOGO_WIDTH ),
        ) );

        //  =============================
        //  2.7.9 - Header Menu Width
        //  =============================

        $wp_customize->add_setting( 'dt_header_menu_width', array(
            'transport' => 'postMessage',
            'default' => apply_filters('dt_header_menu_width_default_value', DT_HEADER_MENU_WIDTH.'%'),// customizer escapes % in default value so we need to add %% so it does not
            'sanitize_callback' => 'sanitize_text_field',
            'capability'  => 'edit_theme_options',
        ) );
        $wp_customize->add_control( 'dt_header_menu_width', array(
            'label'   => __('Header Menu Width', 'directory-starter' ),
            'section' => 'dt_header_spacing_section',
            'settings'    => 'dt_header_menu_width',
            'type'    => 'text',
            'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_HEADER_MENU_WIDTH ),
        ) );

//  =============================
//  3.0 - Body
//  =============================

$wp_customize->add_panel( 'dt_body_panel', array(
	'priority'       => 20,
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'title'          => __('Body', 'directory-starter' ),
	'description'    => '',
) );

	//  =============================
	//  3.1 - Background Image
	//  =============================

		//  =============================
		//  3.1.1 - Background Image
		//  =============================

		$wp_customize->get_section( 'background_image' )->panel  = 'dt_body_panel';
		$wp_customize->get_section( 'background_image' )->priority  = 10;

	//  =============================
	//  3.2 - Text Colors
	//  =============================

	$wp_customize->add_section( 'dt_body_text_section', array(
			'title'       => __( 'Text Colors', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Text Colors', 'directory-starter' ),
			'panel'  => 'dt_body_panel',
	) );

		//  =============================
		//  3.2.1 - Body Color
		//  =============================

		$wp_customize->add_setting( 'dt_body_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_body_color_default_value', DT_BODY_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_body_color', array(
				'label'       => __( 'Body Color', 'directory-starter' ),
				'section'     => 'dt_body_text_section',
				'settings'    => 'dt_body_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_BODY_COLOR ),
		) ) );

		//  =============================
		//  3.2.2 - h1 to h6 Color
		//  =============================

		$wp_customize->add_setting( 'dt_h1toh6_color', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_h1toh6_color_default_value', DT_H1TOH6_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_h1toh6_color', array(
				'label'       => __( 'h1 to h6 Color', 'directory-starter' ),
				'section'     => 'dt_body_text_section',
				'settings'    => 'dt_h1toh6_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_H1TOH6_COLOR ),
		) ) );

		//  =============================
		//  3.2.3 - Link Color
		//  =============================

		$wp_customize->add_setting( 'dt_link_color', array(
				'default' => apply_filters('dt_link_color_default_value', DT_LINK_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_link_color', array(
				'label'       => __( 'Link Color', 'directory-starter' ),
				'section'     => 'dt_body_text_section',
				'settings'    => 'dt_link_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_LINK_COLOR ),
		) ) );

		//  =============================
		//  3.2.4 - Link Hover Color
		//  =============================

		$wp_customize->add_setting( 'dt_link_hover', array(
				'default' => apply_filters('dt_link_hover_default_value', DT_LINK_HOVER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_link_hover', array(
				'label'       => __( 'Link Hover Color', 'directory-starter' ),
				'section'     => 'dt_body_text_section',
				'settings'    => 'dt_link_hover',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_LINK_HOVER ),
		) ) );

		//  =============================
		//  3.2.5 - Link Visited Color
		//  =============================

		$wp_customize->add_setting( 'dt_link_visited', array(
				'default' => apply_filters('dt_link_visited_default_value', DT_LINK_VISITED),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_link_visited', array(
				'label'       => __( 'Link Visited Color', 'directory-starter' ),
				'section'     => 'dt_body_text_section',
				'settings'    => 'dt_link_visited',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_LINK_VISITED ),
		) ) );


	//  =============================
	//  3.3 - Background Colors
	//  =============================

	$wp_customize->add_section( 'dt_body_bg_section', array(
			'title'       => __( 'Background Colors', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Background Colors', 'directory-starter' ),
			'panel'  => 'dt_body_panel',
	) );

		//  =============================
		//  3.3.1 - Body Background Color
		//  =============================

		$wp_customize->get_control( 'background_color' )->section = 'dt_body_bg_section';

		//  =============================
		//  3.3.2 - Content Box Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_content_bg', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_content_bg_default_value', DT_CONTENT_BG),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_content_bg', array(
				'label'       => __( 'Content Box Background Color', 'directory-starter' ),
				'section'     => 'dt_body_bg_section',
				'settings'    => 'dt_content_bg',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTENT_BG ),
		) ) );

		//  =============================
		//  3.3.3 - Content Box Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_content_border', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_content_border_default_value', DT_CONTENT_BORDER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_content_border', array(
				'label'       => __( 'Content Box Border Color', 'directory-starter' ),
				'section'     => 'dt_body_bg_section',
				'settings'    => 'dt_content_border',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTENT_BORDER ),
		) ) );

		//  =============================
		//  3.3.4 - Content Box Shadow Color
		//  =============================

		$wp_customize->add_setting( 'dt_content_shadow', array(
				'default' => apply_filters('dt_content_shadow_default_value', DT_CONTENT_SHADOW),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_content_shadow', array(
				'label'   => __('Content Box Shadow Color', 'directory-starter' ),
				'section' => 'dt_body_bg_section',
				'settings'    => 'dt_content_shadow',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_CONTENT_SHADOW ),
		) );

	//  =============================
	//  3.4 - Typography
	//  =============================

	$wp_customize->add_section( 'dt_body_typography_section', array(
			'title'       => __( 'Typography', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Typography', 'directory-starter' ),
			'panel'  => 'dt_body_panel',
	) );

		//  =============================
		//  3.4.1 - Font Family
		//  =============================

		$wp_customize->add_setting( 'dt_font_family', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_font_family_default_value', DT_FONT_FAMILY),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_font_family', array(
				'label'   => __('Font Family', 'directory-starter' ),
				'section' => 'dt_body_typography_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FONT_FAMILY ),
		) );

		//  =============================
		//  3.4.2 - Font Size
		//  =============================

		$wp_customize->add_setting( 'dt_font_size', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_font_size_default_value', DT_FONT_SIZE),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_font_size', array(
				'label'   => __('Font Size', 'directory-starter' ),
				'section' => 'dt_body_typography_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FONT_SIZE ),
		) );

		//  =============================
		//  3.4.3 - Line Height
		//  =============================

		$wp_customize->add_setting( 'dt_line_height', array(
				'transport' => 'postMessage',
				'default' => apply_filters('dt_line_height_default_value', DT_LINE_HEIGHT),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_line_height', array(
				'label'   => __('Line Height', 'directory-starter' ),
				'section' => 'dt_body_typography_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_LINE_HEIGHT ),
		) );

	//  =============================
	//  3.5 - Spacing
	//  =============================

	$wp_customize->add_section( 'dt_body_spacing_section', array(
			'title'       => __( 'Spacing', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Spacing', 'directory-starter' ),
			'panel'  => 'dt_body_panel',
	) );

	//  =============================
	//  3.6 - Sidebar
	//  =============================

	$wp_customize->add_section( 'dt_body_sidebar_section', array(
			'title'       => __( 'Sidebar', 'directory-starter' ),
			'priority'    => 40,
			'description' => __( 'Sidebar', 'directory-starter' ),
			'panel'  => 'dt_body_panel',
	) );

		//  =============================
		//  3.6.1 - Enable Blog Sidebar
		//  =============================

		$wp_customize->add_setting( 'dt_enable_blog_sidebar', array(
				'default' => apply_filters('dt_enable_blog_sidebar_default_value', DT_ENABLE_BLOG_SIDEBAR),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_enable_blog_sidebar', array(
				'label'   => __('Enable Blog Sidebar', 'directory-starter' ),
				'section' => 'dt_body_sidebar_section',
				'type'    => 'checkbox',
				'std'         => '0',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_ENABLE_BLOG_SIDEBAR ),
		) );

		//  =============================
		//  3.6.2 - Enable WooCommerce Sidebar
		//  =============================

		if ( class_exists( 'WooCommerce' ) ) {
			$wp_customize->add_setting('dt_enable_woo_sidebar', array(
				'default' => apply_filters('dt_enable_woo_sidebar_default_value', DT_ENABLE_BLOG_SIDEBAR),
				'sanitize_callback' => 'sanitize_text_field',
				'capability' => 'edit_theme_options',
			));
			$wp_customize->add_control('dt_enable_woo_sidebar', array(
				'label' => __('Enable WooCommerce Sidebar', 'directory-starter'),
				'section' => 'dt_body_sidebar_section',
				'type' => 'checkbox',
				'std' => '0',
				'description' => sprintf(__('Default: %s', 'directory-starter'), DT_ENABLE_BLOG_SIDEBAR),
			));
		}

		//  =============================
		//  3.6.3 - Blog Sidebar Position
		//  =============================

		$wp_customize->add_setting( 'dt_blog_sidebar_position', array(
				'default' => apply_filters('dt_blog_sidebar_position_default_value', DT_BLOG_SIDEBAR_POSITION),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_blog_sidebar_position', array(
				'label'   => __('Blog Sidebar Position', 'directory-starter' ),
				'section' => 'dt_body_sidebar_section',
				'type'    => 'select',
				'choices' => array(
						'left' => 'Left',
						'right' => 'Right',
				),
				'std'         => 'right',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_BLOG_SIDEBAR_POSITION ),
		) );

//  =============================
//  4.0 - Footer
//  =============================

$wp_customize->add_panel( 'dt_footer_panel', array(
	'priority'       => 30,
	'capability'     => 'edit_theme_options',
	'theme_supports' => '',
	'title'          => __('Footer', 'directory-starter' ),
	'description'    => '',
) );

	//  =============================
	//  4.1 - Text Colors
	//  =============================

	$wp_customize->add_section( 'dt_footer_text_section', array(
		'title'       => __( 'Text Colors', 'directory-starter' ),
		'priority'    => 30,
		'description' => __( 'Text Colors', 'directory-starter' ),
		'panel'  => 'dt_footer_panel',
	) );

		//  =============================
		//  4.1.1 - Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_text_color', array(
				'default' => apply_filters('dt_fw_text_color_default_value', DT_FW_TEXT_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_text_color', array(
				'label'       => __( 'Text Color', 'directory-starter' ),
				'section'     => 'dt_footer_text_section',
				'settings'    => 'dt_fw_text_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_TEXT_COLOR ),
		) ) );

		//  =============================
		//  4.1.2 - h1 to h6 Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_h1toh6_color', array(
				'default' => apply_filters('dt_fw_h1toh6_color_default_value', DT_FW_H1TOH6_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_h1toh6_color', array(
				'label'       => __( 'h1 to h6 Color', 'directory-starter' ),
				'section'     => 'dt_footer_text_section',
				'settings'    => 'dt_fw_h1toh6_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_H1TOH6_COLOR ),
		) ) );

		//  =============================
		//  4.1.3 - Link Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_link_color', array(
				'default' => apply_filters('dt_fw_link_color_default_value', DT_FW_LINK_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_link_color', array(
				'label'       => __( 'Link Color', 'directory-starter' ),
				'section'     => 'dt_footer_text_section',
				'settings'    => 'dt_fw_link_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_LINK_COLOR ),
		) ) );

		//  =============================
		//  4.1.4 - Link Hover Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_link_hover', array(
				'default' => apply_filters('dt_fw_link_hover_default_value', DT_FW_LINK_HOVER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_link_hover', array(
				'label'       => __( 'Link Hover Color', 'directory-starter' ),
				'section'     => 'dt_footer_text_section',
				'settings'    => 'dt_fw_link_hover',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_LINK_HOVER ),
		) ) );

		//  =============================
		//  4.1.5 - Link Visited Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_link_visited', array(
				'default' => apply_filters('dt_fw_link_visited_default_value', DT_FW_LINK_VISITED),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_link_visited', array(
				'label'       => __( 'Link Visited Color', 'directory-starter' ),
				'section'     => 'dt_footer_text_section',
				'settings'    => 'dt_fw_link_visited',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_LINK_VISITED ),
		) ) );

	//  =============================
	//  4.2 - Background Colors
	//  =============================

	$wp_customize->add_section( 'dt_footer_bg_section', array(
		'title'       => __( 'Background Colors', 'directory-starter' ),
		'priority'    => 30,
		'description' => __( 'Background Colors', 'directory-starter' ),
		'panel'  => 'dt_footer_panel',
	) );

		//  =============================
		//  4.2.1 - Footer Section Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_bg', array(
				'default' => apply_filters('dt_fw_bg_default_value', DT_FW_BG),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_bg', array(
				'label'       => __( 'Footer Section Background Color', 'directory-starter' ),
				'section'     => 'dt_footer_bg_section',
				'settings'    => 'dt_fw_bg',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_BG ),
		) ) );

		//  =============================
		//  4.2.2 - Footer Section Border Top Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_border_top_color', array(
				'default' => apply_filters('dt_fw_border_top_color_default_value', DT_FW_BORDER_TOP_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_border_top_color', array(
				'label'       => __( 'Footer Section Border Top Color', 'directory-starter' ),
				'section'     => 'dt_footer_bg_section',
				'settings'    => 'dt_fw_border_top_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_BORDER_TOP_COLOR ),
		) ) );

		//  =============================
		//  4.2.3 - Footer Section Border Bottom Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_border_bottom_color', array(
				'default' => apply_filters('dt_fw_border_bottom_color_default_value', DT_FW_BORDER_BOTTOM_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_border_bottom_color', array(
				'label'       => __( 'Footer Section Border Bottom Color', 'directory-starter' ),
				'section'     => 'dt_footer_bg_section',
				'settings'    => 'dt_fw_border_bottom_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_BORDER_BOTTOM_COLOR ),
		) ) );

		//  =============================
		//  4.2.4 - Footer Section Box Shadow Color
		//  =============================

		$wp_customize->add_setting( 'dt_fw_box_shadow_color', array(
				'default' => apply_filters('dt_fw_box_shadow_color_default_value', DT_FW_BOX_SHADOW_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_fw_box_shadow_color', array(
				'label'       => __( 'Footer Section Box Shadow Color', 'directory-starter' ),
				'section'     => 'dt_footer_bg_section',
				'settings'    => 'dt_fw_box_shadow_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_FW_BOX_SHADOW_COLOR ),
		) ) );


	//  =============================
	//  4.3 - Typography
	//  =============================

	$wp_customize->add_section( 'dt_footer_typography_section', array(
		'title'       => __( 'Typography', 'directory-starter' ),
		'priority'    => 30,
		'description' => __( 'Typography', 'directory-starter' ),
		'panel'  => 'dt_footer_panel',
	) );

	//  =============================
	//  4.4 - Spacing
	//  =============================

	$wp_customize->add_section( 'dt_footer_spacing_section', array(
		'title'       => __( 'Spacing', 'directory-starter' ),
		'priority'    => 30,
		'description' => __( 'Spacing', 'directory-starter' ),
		'panel'  => 'dt_footer_panel',
	) );


//  =============================
//  5.0 - Copyright
//  =============================

	$wp_customize->add_panel( 'dt_copyright_panel', array(
			'priority'       => 30,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __('Copyright', 'directory-starter' ),
			'description'    => '',
	) );

	//  =============================
	//  5.1 - Text Colors
	//  =============================

	$wp_customize->add_section( 'dt_copyright_text_section', array(
			'title'       => __( 'Text Colors', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Text Colors', 'directory-starter' ),
			'panel'  => 'dt_copyright_panel',
	) );

		//  =============================
		//  5.1.1 - Text Color
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_text_color', array(
				'default' => apply_filters('dt_copyright_text_color_default_value', DT_COPYRIGHT_TEXT_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_copyright_text_color', array(
				'label'       => __( 'Text Color', 'directory-starter' ),
				'section'     => 'dt_copyright_text_section',
				'settings'    => 'dt_copyright_text_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_TEXT_COLOR ),
		) ) );


		//  =============================
		//  5.1.2 - Link Color
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_link_color', array(
				'default' => apply_filters('dt_copyright_link_color_default_value', DT_COPYRIGHT_LINK_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_copyright_link_color', array(
				'label'       => __( 'Link Color', 'directory-starter' ),
				'section'     => 'dt_copyright_text_section',
				'settings'    => 'dt_copyright_link_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_LINK_COLOR ),
		) ) );

		//  =============================
		//  5.1.3 - Link Hover Color
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_link_hover', array(
				'default' => apply_filters('dt_copyright_link_hover_default_value', DT_COPYRIGHT_LINK_HOVER),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_copyright_link_hover', array(
				'label'       => __( 'Link Hover Color', 'directory-starter' ),
				'section'     => 'dt_copyright_text_section',
				'settings'    => 'dt_copyright_link_hover',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_LINK_HOVER ),
		) ) );

		//  =============================
		//  5.1.4 - Link Visited Color
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_link_visited', array(
				'default' => apply_filters('dt_copyright_link_visited_default_value', DT_COPYRIGHT_LINK_VISITED),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_copyright_link_visited', array(
				'label'       => __( 'Link Visited Color', 'directory-starter' ),
				'section'     => 'dt_copyright_text_section',
				'settings'    => 'dt_copyright_link_visited',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_LINK_VISITED ),
		) ) );

	//  =============================
	//  5.2 - Background Colors
	//  =============================

	$wp_customize->add_section( 'dt_copyright_bg_section', array(
			'title'       => __( 'Background Colors', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Background Colors', 'directory-starter' ),
			'panel'  => 'dt_copyright_panel',
	) );

		//  =============================
		//  5.2.1 - Copyright Section Background Color
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_bg', array(
				'default' => apply_filters('dt_copyright_bg_default_value', DT_COPYRIGHT_BG),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_copyright_bg', array(
				'label'       => __( 'Copyright Section Background Color', 'directory-starter' ),
				'section'     => 'dt_copyright_bg_section',
				'settings'    => 'dt_copyright_bg',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_BG ),
		) ) );

		//  =============================
		//  5.2.2 - Copyright Section Border Color
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_border_color', array(
				'default' => apply_filters('dt_copyright_border_color_default_value', DT_COPYRIGHT_BORDER_COLOR),
				'sanitize_callback' => 'sanitize_hex_color',
				'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'dt_copyright_border_color', array(
				'label'       => __( 'Copyright Section Border Color', 'directory-starter' ),
				'section'     => 'dt_copyright_bg_section',
				'settings'    => 'dt_copyright_border_color',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_BORDER_COLOR ),
		) ) );

	//  =============================
	//  5.3 - Typography
	//  =============================

	$wp_customize->add_section( 'dt_copyright_typography_section', array(
			'title'       => __( 'Typography', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Typography', 'directory-starter' ),
			'panel'  => 'dt_copyright_panel',
	) );


	//  =============================
	//  5.4 - Spacing
	//  =============================

	$wp_customize->add_section( 'dt_copyright_spacing_section', array(
			'title'       => __( 'Spacing', 'directory-starter' ),
			'priority'    => 30,
			'description' => __( 'Spacing', 'directory-starter' ),
			'panel'  => 'dt_copyright_panel',
	) );

		//  =============================
		//  5.4.1 - Copyright Padding Top
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_padding_top', array(
				'default' => apply_filters('dt_copyright_padding_top_default_value', DT_COPYRIGHT_PADDING_TOP),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_copyright_padding_top', array(
				'label'   => __('Copyright Padding Top', 'directory-starter' ),
				'section' => 'dt_copyright_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_PADDING_TOP ),
		) );

		//  =============================
		//  5.4.2 - Copyright Padding Bottom
		//  =============================

		$wp_customize->add_setting( 'dt_copyright_padding_bottom', array(
				'default' => apply_filters('dt_copyright_padding_bottom_default_value', DT_COPYRIGHT_PADDING_BOTTOM),
				'sanitize_callback' => 'sanitize_text_field',
				'capability'  => 'edit_theme_options',
		) );
		$wp_customize->add_control( 'dt_copyright_padding_bottom', array(
				'label'   => __('Copyright Padding Bottom', 'directory-starter' ),
				'section' => 'dt_copyright_spacing_section',
				'type'    => 'text',
				'description' => sprintf( __( 'Default: %s', 'directory-starter' ), DT_COPYRIGHT_PADDING_BOTTOM ),
		) );

	



}

add_action( 'customize_register', 'directory_theme_customizer' );
