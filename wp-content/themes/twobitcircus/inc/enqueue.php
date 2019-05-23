<?php
/**
 * Main enqueue scripts
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'theme_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function pm_theme_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style( 'twobitcircus-styles', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), $css_version );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );

    wp_enqueue_script( 'twobitcircus-jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), $js_version, true );
    wp_enqueue_script( 'twobitcircus-scripts-transit', get_template_directory_uri() . '/js/jquery.transit.min.js', array(), $js_version, true );
		wp_enqueue_script( 'twobitcircus-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'pm_theme_scripts' );
