<?php
/*
Plugin Name: Contact Form Export
Plugin URI: http://wordpress.org/plugins/page-list/
Description: Export Data for COntact Form 7 Cron
Version: 1.0
Author: Alex
Author URI: http://web-profile.com.ua/wordpress/plugins/
License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	//exit; // Exit if accessed directly.
}

date_default_timezone_set('America/Los_Angeles');

// Activate CenterEdge Book Cron
function contact_form_export_activation() {
  if (! wp_next_scheduled ( 'contact_form_export_cron' )) {
	  //wp_schedule_event(time(), 'daily', 'contact_form_export_cron');
  }
}
//register_activation_hook(__FILE__, 'contact_form_export_activation');

// Remove Cron
function contact_form_export_deactivation() {
	//wp_clear_scheduled_hook('contact_form_export_cron');
}
//register_deactivation_hook(__FILE__, 'contact_form_export_deactivation');

// Handle Request of CRON
//add_action( 'contact_form_export_cron', 'contact_form_export' );

//if ( !function_exists( "contact_form_export" ) ) {
//  function contact_form_export() {
error_log('testing if error log is working');
define('WP_USE_THEMES', false);
require('../../../wp-load.php');
//print_r(is_admin());

    //if( is_admin() ){
        require_once 'inc/export-csv.php';
        $csv = new Expoert_CSV();
        //if( isset($_REQUEST['csv']) && ( $_REQUEST['csv'] == true ) && isset( $_REQUEST['nonce'] ) ) {
        $csv->send_csv_email();
        //}
  //  }
//  }
//}
