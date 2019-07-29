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

    public $token = '';
    public $limit = 20;

    public function load_instagram_feed() {
        if(function_exists('curl_exec') && !empty($this->token)) {
            $data = $this->fetchData("https://api.instagram.com/v1/users/self/media/recent/?access_token=".$this->token); 
            if(!empty($data)) {
                return $this->insta_write($data);
            } else return 'empty';
        } else return 'no-curl';
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
      $table_name = $wpdb->prefix . 'social_feeds';
      //Wipe Data from DB
      $wpdb->delete($table_name, array('type' => 'instagram'));
      foreach($data->data  as $entry) {
          if(!empty($entry->images->thumbnail->url)) {
            $_data = array(
                'type' => 'instagram',
                'pubdate' => $entry->created_time,
                'user' => 'curvedigital',
                'image' =>$entry->images->standard_resolution->url,
                'link' => $entry->link,
                'title' => '',
                'text' => '',
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
