<?php

/**
 * Move titles above menu templates.
 *
 * @since 1.0.0
 */
function velux_remove_titles(){

}
add_action( 'init', 'velux_remove_titles' );

/**
 * Remove hero for all pages except front.
 *
 * @since 1.0.0
 */
function velux_remove_hero_if_not_home() {

	remove_action( 'primer_header', 'primer_add_hero', 10 );

	if( is_front_page() && is_active_sidebar( 'hero' ) ){
		add_action( 'primer_after_header', 'primer_add_hero' );
	}

}
add_action( 'primer_before_header', 'velux_remove_hero_if_not_home' );

/**
 *
 * Add child and parent theme files.
 *
 */
function velux_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
}
add_action( 'wp_enqueue_scripts', 'velux_theme_enqueue_styles' );

/**
 *
 * Register Footer Menu.
 *
 */
function velux_theme_register_nav_menu() {
	 register_nav_menu( 'footer', __( 'Footer Menu', 'velux' ) );
}
add_action( 'after_setup_theme', 'velux_theme_register_nav_menu' );

/**
 * Remove primer navigation and add velux navigation
 */
function velux_navigation() {
	wp_dequeue_script( 'primer-navigation' );
	wp_enqueue_script( 'velux-navigation', get_stylesheet_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20120206', true );
}
add_action( 'wp_print_scripts', 'velux_navigation', 100 );

/**
 * Add mobile menu to header
 *
 * @link https://codex.wordpress.org/Function_Reference/get_template_part
 */
function velux_add_mobile_menu() {
	get_template_part( 'templates/parts/mobile-menu' );
}
add_action( 'primer_header', 'velux_add_mobile_menu', 0 );

/**
 *
 * Adding content to footer via action.
 *
 */
function velux_theme_footer_content() {
	return;
}
add_action( 'primer_footer', 'velux_theme_footer_content' );

/**
 * Display the footer nav before the site info.
 *
 * @action primer_after_footer
 *
 * @since 1.0.0
 */
function velux_add_nav_footer() {

	get_template_part( 'templates/parts/footer-nav' );

}
add_action( 'primer_after_footer', 'velux_add_nav_footer', 10 );

/**
 * Move navigation from after_header to header
 *
 * @link https://codex.wordpress.org/Function_Reference/remove_action
 * @link https://codex.wordpress.org/Function_Reference/add_action
 */
function velux_move_navigation() {
	remove_action( 'primer_after_header', 'primer_add_primary_navigation', 20 );
	get_template_part( 'templates/parts/primary-navigation' );
}
add_action( 'primer_header', 'velux_move_navigation', 19 );

/**
 * Returns the featured image, custom header or false in this priority order.
 *
 * @return false|string
 */
function velux_get_custom_header() {
	$post_id = get_queried_object_id();
	$image_size = (int) get_theme_mod( 'full_width' ) === 1 ? 'hero-2x' : 'hero';
	if ( has_post_thumbnail( $post_id ) ) {
		$image = get_the_post_thumbnail_url( $post_id, $image_size );
		if ( getimagesize( $image ) ) {
			return $image;
		}
	}
	$custom_header = get_custom_header();
	if ( ! empty( $custom_header->attachment_id ) ) {
		$image = wp_get_attachment_image_url( $custom_header->attachment_id, $image_size );
		if ( getimagesize( $image ) ) {
			return $image;
		}
	}
	$header_image = get_header_image();
	return $header_image;
}

/**
 *
 * Register Hero Widget.
 *
 */
register_sidebar(
	array(
		'name'          => esc_html__( 'Hero', 'velux' ),
		'id'            => 'hero',
		'description'   => esc_html__( 'The Hero widget area.', 'velux' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	)
);

/**
 * Add image size for hero image
 *
 * @link https://codex.wordpress.org/Function_Reference/add_image_size
 */
function velux_add_image_size() {

	add_image_size( 'hero', 2400, 1320, array( 'center', 'center' ) );

}
add_action( 'after_setup_theme', 'velux_add_image_size' );

/**
 * Update custom header arguments
 *
 * @param $args
 * @return mixed
 */
function velux_update_custom_header_args( $args ) {
	$args['width'] = 2400;
	$args['height'] = 1320;

	return $args;
}
add_filter( 'primer_custom_header_args', 'velux_update_custom_header_args' );

/**
 * Get header image with image size
 *
 * @return false|string
 */
function velux_get_header_image() {
	$image_size = (int) get_theme_mod( 'full_width' ) === 1 ? 'hero-2x' : 'hero';
	$custom_header = get_custom_header();

	if ( ! empty( $custom_header->attachment_id ) ) {
		$image = wp_get_attachment_image_url( $custom_header->attachment_id, $image_size );
		if ( getimagesize( $image ) ) {
			return $image;
		}
	}
	$header_image = get_header_image();
	return $header_image;
}

/**
 * Update colors
 *
 * @action primer_colors
 */
function velux_colors() {
	return array(
		array(
			'name'    => 'link_color',
			'label'   => __( 'Link Color', 'primer' ),
			'default' => '#51748e',
			'css'     => array(
				'a, a:visited, .entry-footer a, .sticky .entry-title a:before, .footer-widget-area .footer-widget .widget a' => array(
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'header_textcolor',
			'default' => '#212121',
			'css'     => array(
				'.side-masthead, .site-title a, .site-description, .site-title a:hover, .site-title a:visited, .site-title a:focus, .hero-widget, header .main-navigation-container .menu li a, .main-navigation-container .menu li.current-menu-item > a, .main-navigation-container .menu li.current-menu-item > a:hover, .side-masthead .site-title a, .side-masthead .site-title a:hover, .hero-widget h2.widget-title' => array(
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'background_color',
			'default' => '#fff',
			'css'     => array(
				'body' => array(
					'background-color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'main_text_color',
			'label'   => __( 'Main Text Color', 'primer' ),
			'default' => '#212121',
			'css'     => array(
				'.site-content, .site-content h1, .site-content h2, .site-content h3, .site-content h4, .site-content h5, .site-content h6, .site-content p, .site-content blockquote, legend' => array(
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'secondary_text_color',
			'label'   => __( 'Secondary Text Color', 'primer' ),
			'default' => '#999999',
			'css'     => array(
				'.side-masthead .social-menu a, .entry-meta li, .side-masthead .social-menu a:hover' => array(
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'button_color',
			'label'   => __( 'Button Color', 'primer' ),
			'default' => '#8e452a',
			'css'     => array(
				'.cta, button, input[type="button"], input[type="reset"], input[type="submit"]:not(.search-submit), a.fl-button' => array(
					'background-color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'w_text_color',
			'label'   => __( 'Widget Text Color', 'primer' ),
			'default' => '#fff',
			'css'     => array(
				'.footer-widget-area, .footer-widget .widget-title, .site-footer, .footer-widget-area .footer-widget .widget, .footer-widget-area .footer-widget .widget-title' => array(
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'w_background_color',
			'label'   => __( 'Widget Background Color', 'primer' ),
			'default' => '#212121',
			'css'     => array(
				'.site-footer' => array(
					'background-color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'footer_textcolor',
			'label'   => __( 'Footer Text Color', 'primer' ),
			'default' => '#fff',
			'css'     => array(
				'.site-info-wrapper a, .site-info .social-menu a' => array(
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'footer_backgroundcolor',
			'label'   => __( 'Footer Background Color', 'primer' ),
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
 * @since 1.0.0
 * @return array
 */
function velux_color_schemes() {
	return array(
		'dark_blue' => array(
			'label'  => esc_html__( 'Dark Blue', 'velux' ),
			'colors' => array(
				'header_textcolor'         => '#ffffff',
				'background_color'         => '#ffffff',
				'link_color'               => '#363a3d',
				'main_text_color'          => '#202223',
				'secondary_text_color'     => '#ffffff',
				'button_color'			   => '#3f7b84',
				'w_text_color'			   => '#ffffff',
				'w_background_color'	   => '#212121',
				'footer_textcolor'		   => '#ffffff',
				'footer_backgroundcolor'   => '#191919',
			),
		),
	);
}
add_action( 'primer_color_schemes', 'velux_color_schemes' );

/**
 *
 * Add selectors for font customizing.
 *
 * @since 1.0.0
 */
function update_font_types() {
	return	array(
		array(
			'name'    => 'primary_font',
			'label'   => __( 'Primary Font', 'primer' ),
			'default' => 'Roboto',
			'css'     => array(
				'body, p, .hero-wrapper .textwidget p, .site-description, .search-form input[type="search”], .widget li a, .site-info-text, h6, body p, .widget p, ' => array(
					'font-family' => '"%s", sans-serif',
				),
			),
		),
		array(
			'name'    => 'secondary_font',
			'label'   => __( 'Secondary Font', 'primer' ),
			'default' => 'Playfair Display',
			'css'     => array(
				'h1, h2, h3, h4, h5, h6, label, legend, table th, .site-title, .entry-title, .widget-title, .main-navigation li a, button, a.button, input[type="button"], input[type="reset"], input[type="submit"], blockquote, .entry-meta, .entry-footer, .comment-list li .comment-meta .says, .comment-list li .comment-metadata, .comment-reply-link, #respond .logged-in-as, .fl-callout-text, .site-title, .hero-wrapper .textwidget h1, .hero-wrapper .textwidget .button, .main-navigation li a, .widget-title, .footer-nav ul li a, h1, h2, h3, h4, h5, .entry-title, .single .entry-meta, .hero .widget h1' => array(
					'font-family' => '"%s", serif',
				),
			),
		),
	);
}
add_action( 'primer_font_types', 'update_font_types' );

function velux_add_default_header_image( $array ) {
	$array['default-image'] = get_stylesheet_directory_uri() . '/.dev/img/header.png';

	return $array;
}
add_filter( 'primer_custom_header_args', 'velux_add_default_header_image', 20 );
