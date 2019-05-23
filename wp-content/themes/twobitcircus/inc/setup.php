<?php
/**
 * Main setup scripts
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'pm_change_logo_class' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
  function pm_change_logo_class( $html ) {
    $search = ['width="126"', 'height="126"', 'custom-logo-link', 'custom-logo'];
    $replace = ['', '', 'navbar-brand d-flex align-items-center', 'img-fluid'];
    return str_replace( $search, $replace, $html );
  }
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
add_filter( 'get_custom_logo', 'pm_change_logo_class' );

// Custom site Settings
function pm_register_custom_settings( $settings ) {
    $settings->add_setting(
        'enable_intro',
        array(
            'default' => 'true',
            'type' => 'option',
            'capability' => 'edit_theme_options'
        )
      );

    $settings->add_control( new WP_Customize_Control(
        $settings,
        'enable_intro',
        array(
            'label'      => __( 'Enable intro at start', 'textdomain' ),
            'settings'   => 'enable_intro',
            'priority'   => 10,
            'section'    => 'title_tagline',
            'type'       => 'checkbox',
        )
    ) );
}
add_action( 'customize_register', 'pm_register_custom_settings' );

// This theme uses wp_nav_menu()
register_nav_menus(
  array(
   'header' => __( 'Header Menu', 'twobitcircus' ),
   'footer' => __( 'Footer Menu', 'twobitcircus' ),
   'social' => __( 'Social Menu', 'twobitcircus' ),
  )
);

if ( ! function_exists( 'pm_studio_post_type' ) ) {
  // Set Studio labels for Custom Post Type
  function pm_studio_post_type() {
    $supports = array(
      'title',
      'editor',
      'excerpt',
      'page-attributes',
      );
    $labels = array(
      'menu_name'     => __( 'Studios', 'twobitcircus' ),
      'name'          => __( 'Studios', 'twobitcircus' ),
      'singular_name' => __('Studio', 'twobitcircus' ),
      'all_items' => __( 'All Studios', 'twobitcircus' ),
      'add_new_item'  => __( 'Add New Studio', 'twobitcircus' ),
      'edit_item'     => __( 'Edit Studio', 'twobitcircus' ),
      'add_new'       => __( 'Add Studio', 'twobitcircus' ),
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => $supports,
    		'hierarchical'          => false,
    		'public'                => true,
    		'has_archive'           => true,
    		'capability_type'       => 'post',
        'menu_icon'     => 'dashicons-format-gallery',
    );
    // Registering your Custom Post Type
    register_post_type( 'studio', $args );
  }
}
add_theme_support('post-thumbnails');
add_post_type_support( 'studio', 'thumbnail' );
add_action( 'init', 'pm_studio_post_type', 0 );

if ( ! function_exists( 'pm_faqs_post_type' ) ) {
  // Set FAQ labels for Custom Post Type
  function pm_faqs_post_type() {
    $supports = array(
      'title',
      'editor',
      );
    $labels = array(
      'menu_name'     => __( 'FAQ', 'twobitcircus' ),
      'name'          => __( 'FAQ', 'twobitcircus' ),
      'singular_name' => __('FAQ', 'twobitcircus' ),
      'all_items' => __( 'All FAQ', 'twobitcircus' ),
      'add_new_item'  => __( 'Add New FAQ', 'twobitcircus' ),
      'edit_item'     => __( 'Edit FAQ', 'twobitcircus' ),
      'add_new'       => __( 'Add FAQ', 'twobitcircus' ),
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => $supports,
    		'hierarchical'          => false,
    		'public'                => true,
    		'has_archive'           => true,
    		'capability_type'       => 'post',
        'menu_icon'     => 'dashicons-editor-help',
    );
    // Registering your Custom Post Type
    register_post_type( 'faqs', $args );
  }
}
add_action( 'init', 'pm_faqs_post_type', 0 );

if ( ! function_exists( 'pm_teams_post_type' ) ) {
  // Set TEAM labels for Custom Post Type
  function pm_teams_post_type() {
    $supports = array(
      'title',
      'editor',
      'excerpt',
      'page-attributes',
      );
    $labels = array(
      'menu_name'     => __( 'Teams', 'twobitcircus' ),
      'name'          => __( 'Teams', 'twobitcircus' ),
      'singular_name' => __('Team', 'twobitcircus' ),
      'all_items' => __( 'All Teams', 'twobitcircus' ),
      'add_new_item'  => __( 'Add Team Team', 'twobitcircus' ),
      'edit_item'     => __( 'Edit Team', 'twobitcircus' ),
      'add_new'       => __( 'Add Team', 'twobitcircus' ),
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => $supports,
        'hierarchical'          => false,
        'public'                => true,
        'has_archive'           => true,
        'capability_type'       => 'post',
        'menu_icon'     => 'dashicons-groups',
    );
    // Registering your Custom Post Type
    register_post_type( 'teams', $args );
  }
}
add_theme_support('post-thumbnails');
add_post_type_support( 'teams', 'thumbnail' );
add_action( 'init', 'pm_teams_post_type', 0 );

// Handle Custom Shortcode
function pm_button_shortcode( $atts, $content=null ) {
  $attr = shortcode_atts( array(
		'link' => 'link',
	), $atts );
  return '<a class="btn btn-slide" href="'.esc_attr($attr['link']).'"><span>'.$content.'</span></a>';
}
add_shortcode( 'button', 'pm_button_shortcode' );

// Custom Style More Page
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="btn btn-slide"';
}
