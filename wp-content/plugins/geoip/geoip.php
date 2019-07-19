<?php
/*
Plugin Name: GeoIP
Plugin URI: http://wordpress.org/plugins/page-list/
Description: Custom GeoIP Api
Version: 1.0
Author: Alex
Author URI: http://web-profile.com.ua/wordpress/plugins/
Text Domain: geoip
License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once dirname( __FILE__ ) . '/inc/class-geoip.php';
$geo = new GeoIP();
