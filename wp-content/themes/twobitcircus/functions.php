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
 
function composeShows() {
  $shows = [];
  $args = array(
    'post_type' => 'shows',
    'orderby'   => 'menu_order',
    'order'     => 'ASC'
  );
  $query = new WP_Query( $args );
  $posts = $query->posts;
  if(!empty($posts)) {
    foreach($posts as $post) {
      $term = get_the_category($post->ID);
      $catSlug = (!empty($term[0])) ? $term[0]->slug : '';
      $shows[$catSlug][] = $post;
    }
  }
  return $shows;
}
function composeTickets($name) {
  global $wpdb;
  $composedDates = [];
  // Get Dates
  if(!empty($name)) {
    $table_name = $wpdb->prefix . 'centeredge_booking';
    $_query = 'SELECT * FROM `'. $table_name .'` WHERE `name`="'. $name .'" ORDER BY `posted`, `ticket`';
    $data = $wpdb->get_results($_query);
    if(!empty($data)) {
      foreach($data as $entry) {
        $composedDates[$entry->posted][] = $entry;
      }
    }
  }
  return $composedDates;
}
