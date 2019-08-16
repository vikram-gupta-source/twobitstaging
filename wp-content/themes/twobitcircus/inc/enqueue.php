<?php
/**
 * Main enqueue scripts
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'twobitcircus_theme_enqueue' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function twobitcircus_theme_enqueue() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );
		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
    wp_enqueue_style( 'twobitcircus-styles', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), $css_version );
		wp_enqueue_script( 'twobitcircus-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
if ( ! function_exists( 'twobitcircus_admin_theme_enqueue' ) ) {
  // Load Admin theme styling
  function twobitcircus_admin_theme_enqueue() {
    $the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );
    $css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/admin.min.css' );
    $js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/toolbar.min.js' );
    wp_enqueue_style('twobitcircus-admin-theme', get_stylesheet_directory_uri() . '/css/admin.min.css', array(), $css_version );
    wp_enqueue_script( 'twobitcircus-admin-scripts', get_template_directory_uri() . '/js/toolbar.min.js', array(), $js_version, true );
  }
}

add_action( 'wp_enqueue_scripts', 'twobitcircus_theme_enqueue' );
add_action('admin_enqueue_scripts', 'twobitcircus_admin_theme_enqueue');
add_action('login_enqueue_scripts', 'twobitcircus_admin_theme_enqueue');
