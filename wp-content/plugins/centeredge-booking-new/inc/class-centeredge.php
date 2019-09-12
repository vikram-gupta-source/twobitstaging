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

    public $weeks = "+3 weeks"; // +3 weeks
    private $earlier = 0;
    private $first = true;
    private $writeDb = true;
    private $out = '';
    private $complexUrl = 'https://twobitcircus.centeredgeonline.com/areas/areatimeslotlist?date=';

    public function __construct() {
      $this->earlier = time();
      $this->later = strtotime($this->weeks);
    }

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
      if(empty($codes)) return null;
      for ($i=$this->earlier; $i<=$this->later; $i+=86400) {
        $setDate = date("m-d-Y", $i);
        foreach($codes as $code) {
          $links = [];
          $url = $this->complexUrl . urlencode(date("m/d/Y", $i)) .'&areaId='. $code['show_code'] .'&subAreaId=&force=false';
          $html = $this->load_content($url);
          if(preg_match('/"success":false/', $html)) continue;
          if(!empty($html)) {
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); // loads your HTML
            libxml_clear_errors();
            $xpath = new DOMXPath($doc);
            // returns a list of all links with rel=nofollow
            $rows = $xpath->query('//div[@class="time-slot  "]');
            if($rows->length > 0){
              // Loop through each event
              foreach($rows as $row) {
                $_codes = $xpath->query(sprintf("//input[contains(@class, '%s')]", 'slot-id-option'), $row);
                $times = $xpath->query(sprintf("//div[contains(@class, '%s')]", 'time-slot-progress'), $row);
                foreach($times as $ky => $time) {
                    $out = (preg_match('/Out/i', $item->nodeValue)) ? 1 : 0;
                    $text = trim(str_ireplace('Sold Out', '', $times[$ky]->nodeValue));
                    $link = '/areas/areadatetime/'.$code['show_code'].'#/'.urlencode($setDate).'/'.trim($_codes[$ky]->getAttribute('value')).'/';
                    $links[$code['title_of_show']][$setDate][$ky] = array(
                      'href' => $link,
                      'text' => $text,
                      'out'  => $out
                    );
                }
              }
            }
            $results .= $code['title_of_show'] . ' ' . $url . ' done.' . "\n";
          } else {
            $results .= $code['title_of_show'] . ' ' . $url . ' took to long.' . "\n";
          }
          if(!empty($links) && $this->writeDb === true) {
            // Insert Into DB
            $this->insertDb($links);
          }
          file_put_contents(dirname(__FILE__)."/complex_processing.txt", $results);
          //sleep(1);
        }
      }
      file_put_contents(dirname(__FILE__)."/complex_complete.txt", time());
    }

    // Handle DB Inserts
    private function insertDb($links) {
      global $wpdb;
      $insert_sql = [];
      $table_name = $wpdb->prefix . 'centeredge_booking';
      // Clear out existing Entries
      if($this->first === true) {
        $wpdb->query('DELETE FROM ' . $table_name . ' WHERE `type` = "complex"');
        $this->first = false;
      }
      foreach($links as $title => $event) {
        foreach($event as $date => $items) {
          foreach($items as $entry) {
            $insert_sql[] ="('complex', '".esc_sql($title)."', '".esc_sql($date)."', '".esc_sql($entry['href'])."', '".esc_sql($entry['text'])."', '".esc_sql($entry['out'])."')";
          }
        }
      }
      $this->out .= json_encode($insert_sql);
      file_put_contents(dirname(__FILE__)."/complex_out.txt", $this->out);
      if(!empty($insert_sql)) {
        $query = join(', ', $insert_sql);
        $sql ="INSERT INTO ".$table_name." (`type`, `name`, `posted`, `link`, `ticket`, `outstock`) VALUES ". $query;
        $wpdb->query($sql);
      }
    }
  }
}
