<?php
/*
Plugin Name: Global Social Feeds
Plugin URI: http://wordpress.org/plugins/page-list/
Description: Custom Social Feed
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
if ( ! class_exists( 'SocialFeed' ) ) {

  // Register Class
  class SocialFeed {

    public function social_init() {
      // Request to Include Social Class
      require_once dirname( __FILE__ ) . '/inc/socialadmin.class.php';
      require_once dirname( __FILE__ ) . '/inc/facebook.class.php';
      require_once dirname( __FILE__ ) . '/inc/twitter.class.php';
      require_once dirname( __FILE__ ) . '/inc/instagrams.class.php';
      require_once dirname( __FILE__ ) . '/inc/youtube.class.php';

      if(!is_admin()) {
        // Get Expire Times
        $fb_expire = get_option('facebook_feed_expire');
        $tw_expire = get_option('twitter_feed_expire');
        $insta_expire = get_option('instagram_feed_expire');
        $yt_expire = get_option('youtube_feed_expire');
        //Test FB Connection
        if(empty($fb_expire) || (isset($fb_expire) && $fb_expire < time())) {
            $fb_api_options = get_option('social_fb_api_keys');
            if(!empty($fb_api_options['appid'])) {
              $fb = new Facebook( $fb_api_options['appid'], $fb_api_options['secret'] );
              $fb->fbid = $fb_api_options['sid'];
              $fb->token = $fb_api_options['token'];
              $fb->sid = $fb_api_options['name'];
              $fb->redirect = get_site_url() . '/inc/vendors/Facebook/callback.php';
              $fb->limit = 30;
              $fbfeeds = $fb->load_facebook_api();
              if(!empty($fbfeeds)) update_option('facebook_feed_expire', strtotime("+1 day"));
            }
        }
        //Test TW Connection
        if(empty($tw_expire) || (isset($tw_expire) && $tw_expire < time())) {
            $tw_api_options = get_option('social_tw_api_keys');
            if(!empty($tw_api_options['appid'])) {
              $tw = new Twitter($tw_api_options['appid'], $tw_api_options['secret'], $tw_api_options['token_access'], $tw_api_options['token_secret']);
              $tw->limit = 30;
              $tw->twid = $tw_api_options['name'];
              $twfeed = $tw->load_twitter_feed();
              if(!empty($twfeed)) update_option('twitter_feed_expire', strtotime("+1 day"));
            }
        }
        //Test Instagram Connection
        if(empty($insta_expire) || (isset($insta_expire) && $insta_expire < time())) {
            $insta_api_options = get_option('social_insta_api_keys');
            if(!empty($insta_api_options['appid'])) {
              $isg = new Instagrams();
              $isg->limit = 30;
              $isg->token = $insta_api_options['token'];
              $isgfeed = $isg->load_instagram_feed();
              if(!empty($isgfeed)) update_option('instagram_feed_expire', strtotime("+1 day"));
            }
        }
        //Test YT Connection
        if(empty($yt_expire) || (isset($yt_expire) && $yt_expire < time())) {
            $yt_api_options = get_option('social_yt_api_keys');
            if(!empty($yt_api_options['appid'])) {
              $yt = new Youtube($yt_api_options['appid']);
              $yt->limit = 30;
              $yt->ytid = $yt_api_options['sid'];
              $yt->name = $yt_api_options['name'];
              $ytfeed = $yt->load_youtube_playlist_api();
              if(!empty($ytfeed)) update_option('youtube_feed_expire', strtotime("+1 day"));
            }
        }
      }
    }
    public function get_social_feeds() {
      global $wpdb;
      $column = array();
      $table_name = $wpdb->prefix . 'social_feeds';
      $querystr = 'SELECT * FROM ' . $table_name . ' ORDER BY `pubdate` DESC';
      $feeds = $wpdb->get_results($querystr, OBJECT);
      foreach($feeds as $feed) {
        $column[$feed->type][] = $feed;
      }
      return (!empty($column)) ? $column : '';
    }
    public function get_distinct_social() {
      global $wpdb;
      $table_name = $wpdb->prefix . 'social_feeds';
      $querystr = 'SELECT DISTINCT `type` FROM ' . $table_name;
      $social = $wpdb->get_results($querystr, OBJECT);
      return (!empty($social)) ? $social : '';
    }
  }
}

//Init Social
$sf = new SocialFeed();
$sf->social_init();
//Init Social Admin Setting
$sadmin = new SocialAdmin();

// Hook to Create Database
register_activation_hook( __FILE__, 'social_feeds_create_db' );
function social_feeds_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'social_feeds';
  if($wpdb->get_var("show tables like '$table_name'") != $table_name){
  	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
  		`id` int(11) NOT NULL AUTO_INCREMENT,
      `type` varchar(25) NOT NULL,
      `pubdate` varchar(25) NOT NULL,
  	  `user` varchar(100) NOT NULL,
      `link` TEXT NOT NULL,
      `image` TEXT NOT NULL,
      `title` varchar(150) NOT NULL,
      `text` TEXT NOT NULL,
      `count`  int(11) NOT NULL,
      `count2` int(11) NOT NULL,
      PRIMARY KEY (`id`),
  		INDEX `name_key` (type)
  	) $charset_collate;";

  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  	dbDelta( $sql );
  }
}
// Hook to uninstall Database
register_deactivation_hook( __FILE__, 'social_feeds_remove_database' );
function social_feeds_remove_database() {
    global $wpdb;
    $wpdb::delete( $table_name );
}
