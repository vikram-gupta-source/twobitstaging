<?php
/**
 * WP Custom Facebook Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'Facebook' ) ) {

  class Facebook {

    public $fbid = 0;
    public $token = '';
    public $limit = 20;
    public $redirect = '';
    public $name = '';
    private $fb;
    const FB_PATH = 'vendors/Facebook/';

  	public function __construct($appid, $appsecret) {
        require_once self::FB_PATH .'autoload.php';
        $fb_array = [
            'app_id' => $appid,
            'app_secret' => $appsecret,
            'default_graph_version' => 'v2.4',
          ];
        $this->fb = new Facebook\Facebook($fb_array);
      }
      //Handle Facebook API
      public function load_facebook_api() {
          $this->fb->setDefaultAccessToken($this->token);
          $accessToken = $this->fb->getDefaultAccessToken();
          //Connect and Return Results
          try {
              $response = $this->fb->get('/'.$this->fbid .'/posts?limit='.$this->limit.'&fields=likes.limit(1).summary(true),comments.limit(1).summary(true),created_time,message,from,full_picture,link');
              $data = $response->getDecodedBody();
          } catch(Exception $e) {
              // When Graph returns an error
              echo 'Error validating access token: ' . $e->getMessage(); 
          }
          if(!empty($data))
              return $this->fb_write($data);
          else return 'empty';
      }

      private function fb_write($data=null) {
          global $wpdb;
          if(empty($data['data'])) return null;
          $table_name = $wpdb->prefix . 'social_feeds';
          //Wipe Data from DB
          $wpdb->delete($table_name, array('type' => 'facebook'));
          foreach($data['data'] as $entry) {
              if(!empty($entry['message'])) {
                $_data = array(
                    'type' => 'facebook',
                    'pubdate' => strtotime($entry['created_time']),
                    'user' => (!empty($entry['from']['name'])) ? $entry['from']['name'] : $this->name,
                    'image' => (isset($entry['full_picture'])) ? $entry['full_picture'] : '',
                    'link' => (isset($entry['link'])) ? $entry['link'] : '',
                    'title' => '',
                    'text' => strip_tags($entry['message']),
                    'count' => (isset($entry['likes']['summary']['total_count'])) ? $entry['likes']['summary']['total_count'] : 0,
                    'count2' => (isset($entry['comments']['summary']['total_count'])) ? $entry['comments']['summary']['total_count'] : 0,
                );
                $wpdb->insert($table_name, $_data, array('%s', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d'));
              }
          }
          return 'passed';
      }

  }
}
