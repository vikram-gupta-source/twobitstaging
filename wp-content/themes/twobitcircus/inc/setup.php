<?php
/**
 * Main setup scripts
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'twobitcircus_custom_setup' ) ) {
  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   */
  function twobitcircus_custom_setup() {
    load_theme_textdomain( 'twobitcircus', get_template_directory() . '/languages' );
  }
}
add_action( 'after_setup_theme', 'twobitcircus_custom_setup' );

if ( ! function_exists( 'twobitcircus_change_logo_class' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
  function twobitcircus_change_logo_class( $html ) {
    $search = ['width="126"', 'height="126"', 'custom-logo-link', 'custom-logo'];
    $replace = ['', '', 'navbar-brand d-flex align-items-center', 'img-fluid'];
    return str_replace( $search, $replace, $html );
  }
}
if ( ! function_exists( 'twobitcircus_register_custom_settings' ) ) {
  // Custom site Settings
  function twobitcircus_register_custom_settings( $settings ) {
      $settings->add_setting(
          'footer_copyright',
          array(
              'default' => '',
              'capability' => 'edit_theme_options'
          )
        );

      $settings->add_control( new WP_Customize_Control(
          $settings,
          'footer_copyright',
          array(
              'label'      => __( 'Footer Copyright', 'textdomain' ),
              'settings'   => 'footer_copyright',
              'priority'   => 11,
              'section'    => 'title_tagline',
              'type'       => 'text',
          )
      ) );
  }
  add_action( 'customize_register', 'twobitcircus_register_custom_settings' );
}
// Add theme support for Custom Logo.
add_theme_support(
 'custom-logo',
  array(
   'width'      => 250,
   'height'     => 250,
   'flex-width' => true,
  )
);
// Update Custom Logo Classes
add_filter( 'get_custom_logo', 'twobitcircus_change_logo_class' );

if ( ! function_exists( 'twobitcircus_register_custom_footer_settings' ) ) {
  // Custom site Settings
  function twobitcircus_register_custom_footer_settings( $settings ) {
      $settings->add_setting(
          'footer_logo',
          array(
              'default' => '',
              'capability' => 'edit_theme_options'
          )
        );

      $settings->add_control( new WP_Customize_Image_Control(
          $settings,
          'footer_logo',
          array(
              'label'      => __( 'Footer Logo', 'textdomain' ),
              'settings'   => 'footer_logo',
              'priority'   => 9,
              'section'    => 'title_tagline',
          )
      ) );
  }
  add_action( 'customize_register', 'twobitcircus_register_custom_footer_settings' );
}
// This theme uses wp_nav_menu()
register_nav_menus(
  array(
   'header' => __( 'Header Menu', 'twobitcircus' ),
   'footer' => __( 'Footer Menu', 'twobitcircus' ),
  )
);

if ( ! function_exists( 'twobitcircus_show_post_type' ) ) {
  // Set Show labels for Custom Post Type
  function twobitcircus_shows_post_type() {
    $supports = array(
      'title',
      'editor',
      'excerpt',
      'page-attributes',
      );
    $labels = array(
      'menu_name'     => __( 'Shows', 'twobitcircus' ),
      'name'          => __( 'Shows', 'twobitcircus' ),
      'singular_name' => __('Show', 'twobitcircus' ),
      'all_items' => __( 'All Shows', 'twobitcircus' ),
      'add_new_item'  => __( 'Add New Show', 'twobitcircus' ),
      'edit_item'     => __( 'Edit Show', 'twobitcircus' ),
      'add_new'       => __( 'Add Show', 'twobitcircus' ),
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => $supports,
    		'hierarchical'          => false,
    		'public'                => true,
    		'has_archive'           => true,
    		'capability_type'       => 'post',
        'taxonomies'            => array( 'category' ),
        'menu_icon'     => 'dashicons-format-gallery',
    );
    // Registering your Custom Post Type
    register_post_type( 'shows', $args );
  }
}
add_theme_support('post-thumbnails');
add_post_type_support( 'shows', 'thumbnail' );
add_action( 'init', 'twobitcircus_shows_post_type', 0 );

if ( ! function_exists( 'twobitcircus_news_post_type' ) ) {
  // Set News labels for Custom Post Type
  function twobitcircus_news_post_type() {
    $supports = array(
      'title',
      'editor',
      'excerpt',
      'page-attributes',
      );
    $labels = array(
      'menu_name'     => __( 'News', 'twobitcircus' ),
      'name'          => __( 'News', 'twobitcircus' ),
      'singular_name' => __('News', 'twobitcircus' ),
      'all_items' => __( 'All News', 'twobitcircus' ),
      'add_new_item'  => __( 'Add New News', 'twobitcircus' ),
      'edit_item'     => __( 'Edit News', 'twobitcircus' ),
      'add_new'       => __( 'Add News', 'twobitcircus' ),
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => $supports,
    		'hierarchical'          => false,
    		'public'                => true,
    		'has_archive'           => true,
    		'capability_type'       => 'post',
        'menu_icon'     => 'dashicons-admin-site-alt3',
    );
    // Registering your Custom Post Type
    register_post_type( 'news', $args );
  }
}
add_theme_support('post-thumbnails');
add_post_type_support( 'news', 'thumbnail' );
add_action( 'init', 'twobitcircus_news_post_type', 0 );

// Handle Custom Shortcode
function twobitcircus_button_shortcode( $atts, $content=null ) {
  $attr = shortcode_atts( array(
		'link' => '#',
    'type' => 'link',
    'class' => '',
    'parent' => '',
    'ref' => '',
    'target' => '',
	), $atts );
  $target = ($attr['target']) ? 'target="' . esc_attr($attr['target']) . '" rel="noopener noreferrer"' : '';
  $link = ($attr['link']) ? esc_attr($attr['link']) : '#';
  $ref = ($attr['ref']) ? 'data-ref="' . esc_attr($attr['ref']) . '"' : '';
  $class = ($attr['class']) ? esc_attr($attr['class']) : '';
  $type = ($attr['type'] == 'link') ? '<a class="btn btn-twobit '.$class.'" href="'.$link.'" '.$target.' '. $ref.'><span>'.$content.'</span></a>' : '<button type="'.$attr['type'].'" class="btn btn-twobit '.$class.'"><span>'.$content.'</span></button>';
  $sm = (preg_match('/btn-sm/', $class)) ? 'sm' : '';
  return '<div class="cta-btn '.esc_attr($attr['parent']).'">'.$type.'<div class="btn-behind '.$sm.'">&nbsp;</div></div>';
}
add_shortcode( 'button', 'twobitcircus_button_shortcode' );

function cleanHtmlPara($content) {
  $content = str_replace( [ '<p>', '</p>', '<br />' ], '', $content );
  return $content;
}

// Handle Session Shortcode
function twobitcircus_session_shortcode( $atts, $content=null ) {
  $condition = false;
  if (empty($_COOKIE['geo_location'])) {
    $condition = true;
  }
  list ($if, $else) = explode ('[else]', $content, 2);
  return do_shortcode($condition ? $if : $else);
}
add_shortcode( 'is_session', 'twobitcircus_session_shortcode' );

// Custom Style More Page
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

//add_action('acf/init', function() {
    //remove_filter('acf_the_content', 'wpautop' );
    //remove_filter('the_content', 'wpautop' );
//});

function posts_link_attributes() {
    return 'class="btn btn-slide"';
}
// Handle Region & filters
// Collect Region
$region = (empty($_COOKIE['geo_location'])) ?  $geo->get_location_by_ip() : (json_decode(stripslashes($_COOKIE['geo_location'])));
$location = @get_locations(get_field('location_selection', 'option'))[0];

// Clean Location so it find only location that in region
function filter_location_by_field($field) {
  global $region;
  if(empty($field) || $region->status == 'fail') return false;
  // Test City
  $_item = explode('|', $field);
  if($_item[0] == 'all' || ($_item[0] == $region->city) || $_item[1] == $region->regionName) {
    return true;
  }
  return false;
}
// Clean Location so it find only location that in region
function filter_locations($array) {
  global $region;
  if(empty($field) || $region->status == 'fail') return $array;
  $_array = [];
  // Test City
  foreach($array as $item) {
    $_item = explode('|', $item['locations']);
    if($_item[0] == 'all') {
      $_array[] = $item;
    } elseif($_item[0] == $region->city) {
      $_array[] = $item;
    } elseif($_item[1] == $region->regionName) {
      $_array[] = $item;
    }
  }
  return $_array;
}
// Clean Location so it find only location that in region
function get_locations($array) {
  global $region;
  if(empty($array) || $region->status == 'fail') return $array;
  $_array = [];
  // Test Locations
  foreach($array as $item) {
    if($item['city'] == $region->city) {
      $_array[] = $item;
    } elseif($item['region'] == $region->regionName) {
      $_array[] = $item;
    }
  }
  return $_array;
}
// Get Time Close of Open
function openClosed($days, $timezone) {
  date_default_timezone_set($timezone);
  if(empty($days)) return 'closed';
  $dayofweek = date('l');
  $timestamp = time();
  foreach($days as $day) {
    if($dayofweek == $day['day']) {
      $startTime = strtotime($day['open']);
      $endTime = strtotime($day['close']);
      if(!empty($startTime) && ($startTime >= $endTime)) {
        $endTime = strtotime('+1 day' . $day['close']);
      } else {
        $endTime = strtotime($day['close']);
      }
      // check if current time is within a range
      if ($startTime <= $timestamp && $timestamp <= $endTime ) {
          return 'open';
      }
    }
  }
  return 'closed';
}

// Format to Telephone
function cleanPhone($phoneNumber) {
  return '+1' . preg_replace('/[^0-9]/','',$phoneNumber);
}
