<?php
/**
 * Main setup scripts
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'twobitcircus_admin_menu_logo' ) ) {
  add_action('admin_menu', 'twobitcircus_admin_menu_logo');

  function twobitcircus_admin_menu_logo() {
      global $menu;
      $url = '/';
      $menu[0] = array( '<img class="brand-logo" src="/wp-content/uploads/2019/05/animated-logo.gif" />', 'read', $url, 'twobitcircus-logo', 'twobitcircus-logo');
  }
}
// ALow Featured Images
add_theme_support( 'post-thumbnails' );
// Hide Bottom Left Wordpress Copy
add_action('admin_footer_text','__return_false');

// Remove elements from menu
function remove_menus() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menus' );

// Disable all user admin top bar
add_filter('show_admin_bar', '__return_false');

// Enable Option Seetting ACF
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}
if( function_exists('acf_set_options_page_title') ) {
    acf_set_options_page_title( __('Two Bit Settings') );
}

// Enable Option Calender ACF
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Calendar',
		'menu_title'	=> 'Calendar',
		'menu_slug' 	=> 'calendar',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
    'icon_url'    => 'dashicons-calendar-alt',
    'position'    => 30
	));
}
