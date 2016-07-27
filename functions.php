<?php
/**
 *
 * Add child and parent theme files.
 *
 */
function activation_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
}
add_action( 'wp_enqueue_scripts', 'activation_theme_enqueue_styles' );

/**
 * Register custom Custom Navigation Menus.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_nav_menus
 */
function velux_register_site_info_menu() {
	register_nav_menus(
		array(
			'site-info' => esc_html__( 'Site Info', 'velux' ),
		)
	);
}
add_action( 'after_setup_theme', 'velux_register_site_info_menu' );

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
 * Display hero in the header
 *
 * @action velux_header
 */
function velux_add_hero() {
	if ( is_front_page() && is_active_sidebar( 'hero' ) ) {
		get_template_part( 'templates/parts/hero' );
	}
}
add_action( 'primer_after_header', 'velux_add_hero', 25 );

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
