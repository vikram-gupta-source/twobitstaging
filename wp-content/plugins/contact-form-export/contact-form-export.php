<?php
/*
Plugin Name: Contact Form Export
Plugin URI: http://wordpress.org/plugins/page-list/
Description: Export Data for Contact Form 7 Cron
Version: 1.0
Author: Alex
Author URI: http://web-profile.com.ua/wordpress/plugins/
License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

date_default_timezone_set('America/Los_Angeles');

function contact_form_export_activation() {
  if (! wp_next_scheduled ( 'contact_form_export_cron' )) {
	  wp_schedule_event(time(), 'daily', 'contact_form_export_cron');
  }
}
register_activation_hook(__FILE__, 'contact_form_export_activation');

// Remove Cron
function contact_form_export_deactivation() {
	wp_clear_scheduled_hook('contact_form_export_cron');
}
register_deactivation_hook(__FILE__, 'contact_form_export_deactivation');

// Handle Request of CRON
add_action( 'contact_form_export_cron', 'contact_form_export' );

if ( !function_exists( "contact_form_export" ) ) {
  function contact_form_export() {
    file_put_contents(dirname(__FILE__)."/complex_load.txt", time());
    if( is_admin() ){
      file_put_contents(dirname(__FILE__)."/complex_admin.txt", time());
        require_once 'inc/export-csv.php';
        $csv = new Expoert_CSV();
        $csv->send_csv_email();
    }
  }
}
