<?php
/**
 * Main functions and definitions
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$wp_includes = array(
  '/setup.php',                           // Load setup.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. 
  '/login.php',                           // Load custom login.
);

foreach ( $wp_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

// Disable all user admin top bar
add_filter('show_admin_bar', '__return_false');
