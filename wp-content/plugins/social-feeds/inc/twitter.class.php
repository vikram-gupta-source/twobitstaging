<?php
/**
 * WP Custom Twitter Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'Twitter' ) ) {

  class Twitter {

    public $twid = '';
    public $limit = 20;
    public $name = '';
    private $tw;
    const TW_PATH = 'vendors/twitter/twitteroauth/';

  	public function __construct($appid, $appsecret, $token, $tokensecret) {
        require_once self::TW_PATH .'twitteroauth.php';
        $this->tw = new TwitterOAuth($appid, $appsecret, $token, $tokensecret);
    }

    public function load_twitter_feed() {
        if(function_exists('curl_exec')) {
            $data = $this->tw->get('statuses/user_timeline', array('screen_name' => $this->twid, 'exclude_replies' => true, 'include_rts' => false, 'count' => $this->limit));
            if(!empty($data)) {
                return $this->tw_write($data);
            } else return 'empty';
        } else return 'no-curl';
    }

    private function tw_write($data=null) {
        global $wpdb;
        if(empty($data)) return null;
        $table_name = $wpdb->prefix . 'social_feeds';
        //Wipe Data from DB
        $wpdb->delete($table_name, array('type' => 'twitter'));
        foreach($data as $entry) {
            if(!empty($entry->text)) {
              $_data = array(
                  'type' => 'twitter',
                  'pubdate' => strtotime($entry->created_at),
                  'user' => $entry->user->screen_name,
                  'image' => (isset($entry->extended_entities->media[0]->media_url_https)) ? $entry->extended_entities->media[0]->media_url_https : '',
                  'link' => 'http://twitter.com/'.$entry->user->screen_name.'/statuses/' . $entry->id_str,
                  'title' => '',
                  'text' => $entry->text,
                  'count' => $entry->retweet_count,
                  'count2' => $entry->favorite_count,
              );
              $wpdb->insert($table_name, $_data, array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d'));
            }
        }
        return 'passed';
    }
  }
}
?>
