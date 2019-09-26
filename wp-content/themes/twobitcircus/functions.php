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
  $shows = $data = [];
  $args = array(
    'post_type' => 'shows',
    'posts_per_page' => 9999,
    'orderby'   => 'menu_order, post_title',
    'order'     => 'ASC'
  );
  $query = new WP_Query( $args );
  $posts = $query->posts;
  //print_r($posts);
  if(!empty($posts)) {
    foreach($posts as $post) {
      $term = get_the_category($post->ID);
      $terms = $term[0];
      $shows[$term[0]->slug]['posts'][] = $post;
      $shows[$term[0]->slug]['terms'] = $terms;
    }
    $categories = get_categories();
    $filter = custom_term_sort($categories);
    foreach($filter as $term) {
      if(empty($term->description)) continue;
      $data[$term->slug]['posts'] = $shows[$term->slug]['posts'];
      $data[$term->slug]['terms'] = $term;
    }
  }
  return $data;
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

// Air Table connection
add_action('wp_ajax_nopriv_ajaxAirtable', 'ajaxAirtable');
add_action('wp_ajax_ajaxAirtable', 'ajaxAirtable');
function ajaxAirtable() {
    $output = [];
    $userAnswer = strtolower(stripslashes( $_POST['secret'] ));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.airtable.com/v0/app44GPTYlw2v5cCE/Secrets/recZh4w7UMjNAObWC");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = array();
    $headers[] = 'Authorization: Bearer keyFZPbWVXAiR6d4A';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    $raw = json_decode($server_output);
    curl_close ($ch);
    if(!empty($server_output)) {
      $correctAnswer = strtolower($raw->fields->Answer);
      if($userAnswer == $correctAnswer){
        $output['succeed'] = $raw->fields->Succeed;
      } else{
        $output['failed'] = $raw->fields->Fail;
      }
      echo json_encode($output);
    }
    wp_die();
}

add_action('init', 'add_attraction_rewrite', 10, 0);
if ( ! function_exists( 'add_attraction_rewrite' ) ) {
  function add_attraction_rewrite() {
      add_rewrite_rule('^attractions/([^/]+)/?$', 'index.php?pagename=attractions&category=$matches[1]','top');
      add_rewrite_rule('^attractions/([^/]+)/([^/]+)/?$', 'index.php?pagename=attractions&category=$matches[1]&show=$matches[2]','top');
  }
}

// Load in Locations
add_action("wp_ajax_twobit_location_ajax", "twobit_location_ajax");
if ( ! function_exists( 'twobit_location_ajax' ) ) {
  function twobit_location_ajax() {
    global $location; 
    echo openClosed($location['days'], $location['timezone'], $location['close_dates']);
    exit;
  }
}
