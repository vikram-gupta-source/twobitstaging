<?php
/**
 * WP Custom Instagrams Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'Instagrams' ) ) {

  class Instagrams {

    public $api_options = [];
    const IN_PATH = 'vendors/instagram/';

    public function load_instagram_feed() {
      require_once self::IN_PATH .'instagram.php';
      if(!empty($this->api_options)) {
        $connection = new Instagram(array(
          'apiKey' => $this->api_options['appid'],
          'apiSecret' => $this->api_options['secret'],
          'apiCallback' => get_site_url() . '/wp-content/plugins/instagram-feeds/inc/vendors/instagram/callback.php'
        ));
        $code = $connection->getOAuthToken($this->api_options['token']);
        print_r($code);
        $connection->setAccessToken($code);
        print_r($connection);
        // Get latest photos according to #hashtag keyword
        $media = $connection->getTagMedia($this->api_options['hash']);
        print_r($media);
      }
        //if(!empty($data)) {
        //    return $this->insta_write($data);
        //} else return 'empty';
    }

    private function fetchData($url){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 20);
      $result = curl_exec($ch);
      $result = json_decode($result);
      curl_close($ch);
      return $result;
    }

    private function insta_write($data=null) {
      global $wpdb;
      if(empty($data->data )) return null;
      $table_name = $wpdb->prefix . 'instagram_feeds';
      //Wipe Data from DB
      $wpdb->query("TRUNCATE TABLE `".$table_name."`");
      foreach($data->data  as $entry) {
          if(!empty($entry->images->thumbnail->url)) {
            $_data = array(
                'pubdate' => $entry->created_time,
                'user' => $entry->author,
                'image' =>$entry->images->standard_resolution->url,
                'link' => $entry->link,
                'count' => $entry->comments->count,
                'count2' => $entry->likes->count,
            );
            $wpdb->insert($table_name, $_data, array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d'));
          }
      }
      return 'passed';
    }
  }
}
?>
