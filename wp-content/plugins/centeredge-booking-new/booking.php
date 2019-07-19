<?php
/*
Plugin Name: Centeredge Booking New
Plugin URI: http://wordpress.org/plugins/page-list/
Description: Custom Centeredge Booking New Scraping
Version: 1.0
Author: Alex
Author URI: http://web-profile.com.ua/wordpress/plugins/
License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

date_default_timezone_set('America/Los_Angeles');

// Add 6 Hours to Cron Schedule
function centeredge_booking_new_recurrence_interval( $schedules ) {
    $schedules['sixhours'] = array(
            'interval'  => 60 * 60 * 6,
            'display'   => __( 'Every 6 Hours', 'textdomain' )
    );
    $schedules['fourhours'] = array(
            'interval'  => 60 * 60 * 4,
            'display'   => __( 'Every 4 Hours', 'textdomain' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'centeredge_booking_new_recurrence_interval' );

// Activate CenterEdge Book Cron
function centeredge_booking_new_activation() {
  if (! wp_next_scheduled ( 'centeredge_booking_new_cron' )) {
	  wp_schedule_event(time(1547627400), 'twicedaily', 'centeredge_booking_new_cron');
  }
}
register_activation_hook(__FILE__, 'centeredge_booking_new_activation');

// Remove CenterEdge Book Cron
function centeredge_booking_new_deactivation() {
	wp_clear_scheduled_hook('centeredge_booking_new_cron');
}
register_deactivation_hook(__FILE__, 'centeredge_booking_new_deactivation');

// Handle Request of CRON
add_action( 'centeredge_booking_new_cron', 'centeredge_booking_new' );

if ( !function_exists( "centeredge_booking_new" ) ) {
  function centeredge_booking_new() {
    // Request to Include CenterEdge Class
    require_once dirname( __FILE__ ) . '/inc/class-centeredge.php';
    $ce = new CenterEdgeNew();
    $ce->centeredge_init();
  }
}

// Hook to Create Database
register_activation_hook( __FILE__, 'centeredge_booking_new_create_db' );
function centeredge_booking_new_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'centeredge_booking';
  if($wpdb->get_var("show tables like '$table_name'") != $table_name){
  	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
  		`id` int(11) NOT NULL AUTO_INCREMENT,
      `type` varchar(25) NOT NULL,
  		`name` varchar(100) NOT NULL,
  		`posted` varchar(25) NOT NULL,
      `link` varchar(200) NOT NULL,
      `ticket` varchar(50) NOT NULL,
      PRIMARY KEY (`id`),
  		INDEX `name_key` (name)
  	) $charset_collate;";

  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  	dbDelta( $sql );
  }
}
// Hook to uninstall Database
register_deactivation_hook( __FILE__, 'centeredge_booking_new_remove_database' );
function centeredge_booking_new_remove_database() {
     global $wpdb;
     $table_name = $wpdb->prefix . 'centeredge_booking';
     $sql = "DROP TABLE IF EXISTS $table_name";
     $wpdb->query($sql);
}
