<?php
/**
 * WP Custom CenterEdge Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'CenterEdgeNew' ) ) {

  class CenterEdgeNew {

    private $out = '';
    const AWSURL = 'http://ec2-34-200-14-116.compute-1.amazonaws.com/data_times.json';

    public function centeredge_init() {
      // Handle Scrapping of complex single pages of Centeredge Pages
      $this->complexScrap();
    }
    private function load_content($url) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      $response = curl_exec($ch);
      curl_close($ch);
      return $response;
    }
    // Complex Single Entry Scrapping Methods
    private function complexScrap() {
      $results = '';
      $codes = get_field('center_edge_complex_feeds', 'options');
      file_put_contents(dirname(__FILE__)."/codes.json", json_encode($codes));
      if(empty($codes)) return null;
      //file_put_contents(dirname(__FILE__)."/start.txt", 'start');
      $data = $this->load_content(self::AWSURL);
      $links = json_decode(unserialize($data));
      //file_put_contents(dirname(__FILE__)."/links.txt", $data);
      if(!empty($links)) {
        // Insert Into DB
        $this->insertDb($links);
      }
    }

    // Handle DB Inserts
    private function insertDb($links) {
      global $wpdb;
      $table_name = $wpdb->prefix . 'centeredge_booking';
      // Clear out existing Entries
      //file_put_contents(dirname(__FILE__)."/db.txt", 'db');
      $wpdb->query('DELETE FROM ' . $table_name . ' WHERE `type` = "complex"');
      $wpdb->query('ALTER TABLE ' . $table_name . ' AUTO_INCREMENT = 1');
      foreach($links as $items) {
        $insert_sql = [];
        foreach($items as $entry) {
          $insert_sql[] ="('complex', '".esc_sql($entry[1])."', '".esc_sql($entry[2])."', '".esc_sql($entry[3])."', '".esc_sql($entry[4])."', '".esc_sql($entry[5])."')";
        }
        if(!empty($insert_sql)) {
          $query = join(', ', $insert_sql);
          $sql ="INSERT INTO ".$table_name." (`type`, `name`, `posted`, `link`, `ticket`, `outstock`) VALUES ". $query;
          $wpdb->query($sql);
        }
      }
    }
  }
}
