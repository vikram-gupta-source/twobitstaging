<?php
/*
Plugin Name: Instagram Feeds
Plugin URI: http://wordpress.org/plugins/page-list/
Description: Custom Instagram Feed
Version: 1.0
Author: Alex
Author URI: http://web-profile.com.ua/wordpress/plugins/
License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

date_default_timezone_set('America/Los_Angeles');


/* Check if Class Exists. */
if ( ! class_exists( 'InstagramFeed' ) ) {

  // Register Class
  class InstagramFeed {

    public function capture_instagram_feeds() {
      // Request to Include Social Class
      require_once dirname( __FILE__ ) . '/inc/instagrams.class.php';
      $insta_api_options = get_option('instagram_insta_api_keys');
      if(!empty($insta_api_options['enable'])) {
        //Test Instagram Connection
        if(!empty($insta_api_options['hash'])) {
          $isg = new Instagrams();
          $isg->hash = $insta_api_options['hash'];
          $isg->limit = $insta_api_options['limit'];
          $isg->json = $insta_api_options['json'];
          $isgfeed = $isg->load_instagram_feed();
        }
      }
    }

    public function get_instagram_feeds() {
      global $wpdb;
      $column = array();
      $table_name = $wpdb->prefix . 'instagram_feeds';
      $querystr = 'SELECT * FROM ' . $table_name . ' ORDER BY `pubdate` DESC';
      $feeds = $wpdb->get_results($querystr, OBJECT);
      foreach($feeds as $feed) {
        $column[] = $feed;
      }
      return (!empty($column)) ? $column : '';
    }

  }
}

//Init Instagram Admin Setting
if(is_admin()) {
  if(!empty($_GET['action']) && ($_GET['action'] == 'populate')) {
    $inst = new InstagramFeed();
    $inst->capture_instagram_feeds();
  }
  require_once dirname( __FILE__ ) . '/inc/instagramadmin.class.php';
  $iadmin = new InstagramAdmin();
}

// Hook to Create Database
register_activation_hook( __FILE__, 'instagram_feeds_create_db' );
function instagram_feeds_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'instagram_feeds';
  if($wpdb->get_var("show tables like '$table_name'") != $table_name){
  	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `pubdate` varchar(25) NOT NULL,
  	  `instagram_id` bigint(30) NOT NULL,
      `link` TEXT NOT NULL,
      `caption` TEXT NOT NULL,
      `image` TEXT NOT NULL,
      `count`  int(11) NOT NULL,
      `count2` int(11) NOT NULL,
      `status` tinyint(1) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`),
      UNIQUE KEY `instagram_id_key` (`instagram_id`),
      KEY `pubdate_key` (`pubdate`)
  	) $charset_collate;";
  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  	dbDelta( $sql );
  }
}
// Hook to uninstall Database
register_deactivation_hook( __FILE__, 'instagram_feeds_remove_database' );
function instagram_feeds_remove_database() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'instagram_feeds';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    $table_options = $wpdb->prefix . 'options';
    $querystr = 'DELETE FROM ' . $table_options . ' WHERE `option_name` = "instagram_insta_api_keys"';
    $wpdb->query($querystr);
}
