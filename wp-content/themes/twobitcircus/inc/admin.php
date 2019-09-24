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

function custom_acf_flexible_content_layout_title( $title, $field, $layout, $i ) {
	// load text sub field
	if( !empty(get_sub_field('region')) && !empty(get_sub_field('city'))) {
		return get_sub_field('city')  . ', ' . get_sub_field('region');
	}
  if( !empty(get_sub_field('locations'))) {
    $filter = (preg_match('/all|all/', get_sub_field('locations'))) ? 'All Locations' : str_replace('|', ', ', get_sub_field('locations'));
    if(!empty(get_sub_field('title'))) {
      return $filter . ' - ' . get_sub_field('title');
    }
    if(!empty(get_sub_field('show_title'))) {
      return $filter . ' - ' . get_sub_field('show_title') . ' - ' . get_sub_field('show_date');
    }
    return $filter;
  }
  if( !empty(get_sub_field('title'))) {
    return get_sub_field('title');
  }
	// return
	return $title;
}
// name
add_filter('acf/fields/flexible_content/layout_title', 'custom_acf_flexible_content_layout_title', 10, 4);

// Save custom meta
function twobit_taxonomy_save_taxonomy_meta( $term_id, $tag_id ) {
    if ( isset( $_POST[ 'category_icon' ] ) ) {
        update_term_meta( $term_id, 'category_icon', $_POST[ 'category_icon' ] );
    } else {
        update_term_meta( $term_id, 'category_icon', '' );
    }
}
add_action( 'created_category', 'twobit_taxonomy_save_taxonomy_meta', 10, 2 );
add_action( 'edited_category', 'twobit_taxonomy_save_taxonomy_meta', 10, 2 );
