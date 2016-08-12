<?php

/**
 * Remove hero for all pages except front.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_remove_hero_if_not_home() {

	remove_action( 'primer_header', 'primer_add_hero', 10 );

	if ( is_front_page() && is_active_sidebar( 'hero' ) ) {

		add_action( 'primer_after_header', 'primer_add_hero' );

	}

}
add_action( 'primer_before_header', 'velux_remove_hero_if_not_home' );

/**
 *
 * Add child and parent theme files.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_theme_enqueue_styles() {

	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );

	wp_enqueue_style( 'velux-lt-ie9-style', get_stylesheet_directory_uri() . '/ie.css', array(), PRIMER_VERSION );
	wp_style_add_data( 'velux-lt-ie9-style', 'conditional', 'lt IE 9' );

}
add_action( 'wp_enqueue_scripts', 'velux_theme_enqueue_styles' );

/**
 * Register Footer Menu.
 *
 * @package velux
 * @since   1.0.0
 *
 * @param $menu
 */
function velux_register_nav_menu( $menu ) {

	$menu[ 'footer' ] = __( 'Footer Menu', 'activation' );

	return $menu;

}
add_filter( 'primer_nav_menus', 'velux_register_nav_menu' );

/**
 * Add mobile menu to header
 *
 * @package Velux
 * @since 1.0.0
 *
 * @link https://codex.wordpress.org/Function_Reference/get_template_part
 */
function velux_add_mobile_menu() {

	get_template_part( 'templates/parts/mobile-menu' );

}
add_action( 'primer_header', 'velux_add_mobile_menu', 0 );

/**
 * Display the footer nav before the site info.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_add_nav_footer() {

	get_template_part( 'templates/parts/footer-nav' );

}
add_action( 'primer_after_footer', 'velux_add_nav_footer', 10 );

/**
 * Move navigation from after_header to header
 *
 * @package Velux
 * @since 1.0.0
 * @link https://codex.wordpress.org/Function_Reference/remove_action
 * @link https://codex.wordpress.org/Function_Reference/add_action
 */
function velux_move_navigation() {

	remove_action( 'primer_after_header', 'primer_add_primary_navigation', 20 );

	get_template_part( 'templates/parts/primary-navigation' );

}
add_action( 'primer_header', 'velux_move_navigation', 19 );

/**
 * Register sidebar areas.
 *
 * @link    http://codex.wordpress.org/Function_Reference/register_sidebar
 *
 * @package Velux
 * @since   1.0.0
 *
 * @param array $sidebars
 *
 * @return array
 */
function velux_register_sidebars( $sidebars ) {

	/**
	 * Register Hero Widget.
	 */
	$sidebars['hero'] = array(
		'name'          => esc_attr__( 'Hero', 'velux' ),
		'id'            => 'hero',
		'description'   => esc_attr__( 'The Hero widget area.', 'velux' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	);

	return $sidebars;

}
add_filter( 'primer_sidebars', 'velux_register_sidebars' );

/**
 * Add image size for hero image
 *
 * @package Velux
 * @since   1.0.0
 * @link    https://codex.wordpress.org/Function_Reference/add_image_size
 *
 * @param array $images_sizes
 *
 * @return array
 */
function velux_add_image_size( $images_sizes ) {

	$images_sizes[ 'primer-hero' ] = array(
		'width'  => 1200,
		'height' => 660,
		'crop'   => array( 'center', 'center' ),
	);

	$images_sizes[ 'primer-hero-2x' ] = array(
		'width'  => 2400,
		'height' => 1320,
		'crop'   => array( 'center', 'center' ),
	);

	return $images_sizes;

}
add_filter( 'primer_image_sizes', 'velux_add_image_size' );

/**
 * Update custom header arguments
 *
 * @package Velux
 * @since 1.0.0
 * @param $args
 *
 * @return mixed
 */
function velux_update_custom_header_args( $args ) {

	$args['width']  = 2400;
	$args['height'] = 1320;

	return $args;

}
add_filter( 'primer_custom_header_args', 'velux_update_custom_header_args' );

/**
 * Update colors
 *
 * @package Velux
 * @since 1.0.0
 * @action primer_colors
 *
 * @return array
 */
function velux_colors() {

	return array(
		'link_color' => array(
			'label'   => __( 'Link Color', 'velux' ),
			'default' => '#51748e',
			'css'     => array(
				'#content a, #content a:visited, .entry-footer a, .entry-footer a:visited, .sticky .entry-title a:before, .footer-widget-area .footer-widget .widget a, .footer-widget-area .footer-widget .widget a:visited, header .main-navigation-container .menu li.current-menu-item > a:hover ,
				header .main-navigation-container .menu li.current-menu-item > a {' => array(
					'color' => '%1$s',
				),
			),
		),
		'background_color' => array(
			'default' => '#fff',
			'css'     => array(
				'body' => array(
					'background-color' => '%1$s',
				),
			),
		),
		'button_color' => array(
			'label'   => __( 'Button Color', 'velux' ),
			'default' => '#8e452a',
			'css'     => array(
				'.cta, button, input[type="button"], input[type="reset"], input[type="submit"]:not(.search-submit), a.fl-button' => array(
					'border-bottom' => '2px solid %1$s',
					'color' => '%1$s',
				),
			),
		),
		'w_background_color' => array(
			'label'   => __( 'Widget Background Color', 'velux' ),
			'default' => '#212121',
			'css'     => array(
				'.site-footer' => array(
					'background-color' => '%1$s',
				),
			),
		),
		'footer_background_color' => array(
			'label'   => __( 'Footer Background Color', 'velux' ),
			'default' => '#191919',
			'css'     => array(
				'.site-info-wrapper, .footer-nav, .site-info-wrapper' => array(
					'background-color' => '%1$s',
				),
			),
		),
	);

}
add_action( 'primer_colors', 'velux_colors', 9 );

/**
 * Change velux color schemes
 *
 * @action primer_color_schemes
 *
 * @package Velux
 * @since 1.0.0
 *
 * @return array
 */
function velux_color_schemes() {

	return array(
		'dark_blue' => array(
			'label'  => esc_html__( 'Dark Blue', 'velux' ),
			'colors' => array(
				'background_color'         => '#ffffff',
				'link_color'               => '#363a3d',
				'button_color'			   => '#3f7b84',
				'w_background_color'	   => '#212121',
				'footer_background_color'  => '#191919',
			),
		),
	);

}
add_action( 'primer_color_schemes', 'velux_color_schemes' );

/**
 *
 * Add selectors for font customizing.
 *
 * @package Velux
 * @since 1.0.0
 *
 * @return array
 */
function velux_update_font_types() {

	return array(
		'primary_font' => array(
			'label'   => __( 'Primary Font', 'velux' ),
			'default' => 'Roboto',
			'css'     => array(
				'body, p, .hero-wrapper .textwidget p, .site-description, .search-form input[type="search"], .widget li a, .site-info-text, h6, body p, .widget p, ' => array(
					'font-family' => '"%s", sans-serif',
				),
			),
		),
		'secondary_font' => array(
			'label'   => __( 'Secondary Font', 'velux' ),
			'default' => 'Playfair Display',
			'css'     => array(
				'h1, h2, h3, h4, h5, h6, label, legend, table th, .site-title, .entry-title, .widget-title, .main-navigation li a, button, a.button, input[type="button"], input[type="reset"], input[type="submit"], blockquote, .entry-meta, .entry-footer, .comment-list li .comment-meta .says, .comment-list li .comment-metadata, .comment-reply-link, #respond .logged-in-as, .fl-callout-text, .site-title, .hero-wrapper .textwidget h1, .hero-wrapper .textwidget .button, .main-navigation li a, .widget-title, .footer-nav ul li a, h1, h2, h3, h4, h5, .entry-title, .single .entry-meta, .hero .widget h1, button, .button, .btn, input[type="submit"], .fl-button, .fl-button a' => array(
					'font-family' => '"%s", serif',
				),
			),
		),
	);

}
add_action( 'primer_font_types', 'velux_update_font_types' );

/**
 * Add a default hero image in the header area.
 *
 * @package Velux
 * @since   1.0.0
 *
 * @param array $array
 *
 * @return array
 */
function velux_add_default_header_image( $array ) {

	$array['default-image'] = get_stylesheet_directory_uri() . '/assets/img/header.png';

	return $array;

}
add_filter( 'primer_custom_header_args', 'velux_add_default_header_image', 20 );
