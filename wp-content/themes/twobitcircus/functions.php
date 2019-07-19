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
  '/widget.php',                          // Load Wdget.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
  '/login.php',                           // Load custom login.
  '/class-calendar.php',                  // Load calendar class.
  '/admin.php'                            // Load Admin Custom Setting
);

foreach ( $wp_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
