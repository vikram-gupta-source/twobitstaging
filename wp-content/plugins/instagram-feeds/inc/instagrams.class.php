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

    public $hash = '';
    public $limit = 10;

    private function scrape_insta_hash() {
      $insta_source = file_get_contents('https://www.instagram.com/explore/tags/'.$this->hash.'/'); // instagrame tag url
      $shards = explode('window._sharedData = ', $insta_source);
      $insta_json = explode(';</script>', $shards[1]);
      $insta_array = json_decode($insta_json[0], TRUE);
      return $insta_array; // this return a lot things print it and see what else you need
    }

    public function load_instagram_feed() {
      $data = [];
      $results_array = $this->scrape_insta_hash();
      for ($i=$this->limit; $i >= 0; $i--) {
        if(array_key_exists($i,$results_array['entry_data']['TagPage'][0]["graphql"]["hashtag"]["edge_hashtag_to_media"]["edges"])){
          $latest_array = $results_array['entry_data']['TagPage'][0]["graphql"]["hashtag"]["edge_hashtag_to_media"]["edges"][$i]["node"];
          $url = $this->saveImg($latest_array['thumbnail_src'], $latest_array['id']);
          $newPosting = [
            "pubdate"=>$latest_array['taken_at_timestamp'],
            "instagram_id" => $latest_array['id'],
            "link"=>"https://www.instagram.com/p/".$latest_array['shortcode'],
            "caption"=> ((isset($latest_array['edge_media_to_caption'])) ? $latest_array['edge_media_to_caption']['edges'][0]["node"]["text"] : ''),
            "image" => $url,
            'count' => $latest_array['edge_media_to_comment']['count'],
            'count2' => (isset($latest_array['video_view_count'])) ? $latest_array['video_view_count'] : $latest_array['edge_liked_by']['count'],
            'status' => 0
          ];
          array_push($data, $newPosting);
        }
      }
      $this->insta_write($data);
      add_action('admin_notices', function($messages){
        ?>
        <div class="notice notice-success"><p>Instagram Feed has been processed.</p></div>
        <?php
      });
    }
    public function instagram_custom_warning_filter() {

    }
    private function saveImg($img, $id) {
      $parts = explode('?', $img);
      $pathinfo = pathinfo($parts[0]);
      $url =  $id.'.'.$pathinfo['extension'];
      $filepath = ABSPATH . '/wp-content/uploads/instagram/'.$url; 
      $image = imagecreatefromjpeg($img);
      imagejpeg($image, $filepath, 75);
      imagedestroy($image);
      return '/wp-content/uploads/instagram/' . $url;
    }
    private function insta_write($data=null) {
      global $wpdb;
      if(empty($data)) return null;
      $table_name = $wpdb->prefix . 'instagram_feeds';
      foreach($data  as $entry) {
        $wpdb->replace($table_name, $entry, array('%d', '%d', '%s', '%s', '%s', '%d', '%d', '%d'));
      }
      return 'passed';
    }
  }
}
?>
