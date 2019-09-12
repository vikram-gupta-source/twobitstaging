<?php
/**
 * WP Custom CenterEdge Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'CenterEdge' ) ) {

  class CenterEdge {

    public $weeks = "+3 weeks"; // +3 weeks
    private $earlier = 0;
    private $first = true;
    private $writeDb = true;
    private $standardUrl = 'https://twobitcircus.centeredgeonline.com/movie/movies/';

    public function __construct() {
      $this->earlier = time();
      $this->later = strtotime($this->weeks);
    }

    public function centeredge_init() {
      // Handle Scrapping of standard of Centeredge Pages
      $this->standardScrap();
    }
    // Standard Old Scrapping Methods
    private function standardScrap() {
      for ($i=$this->earlier; $i<=$this->later; $i+=86400) {
        $links = [];
        $setDate = date("m-d-Y", $i);
        $html = file_get_contents($this->standardUrl. $setDate);
        $dom = new DOMDocument();
        libxml_use_internal_errors(TRUE);
        if(!empty($html)) {
          // Load in the HTML content
          $dom->loadHTML($html);
          // Remove Html Erros
          libxml_clear_errors();
          $xpath = new DOMXPath($dom);
          // Capture Table Start
          $rows = $xpath->query("//table[@class='table']");
          if($rows->length > 0){
            // Loop through each event
        		foreach($rows as $row){
              $setTitle = '';
              $block = $xpath->query("//td[@class='visible-table-title']", $row);
              foreach($block as $ticket){
                $count = 0;
                $arr = $ticket->getElementsByTagName("a");
                foreach($arr as $key => $item) {
                  $out = (preg_match('/Out/i', $item->nodeValue)) ? 1 : 0;
                  $href =  $item->getAttribute("href");
                  $text = trim(preg_replace("/[\r\n]+/", " ", $item->nodeValue));
                  $setTitle = ($count == 0) ? $text : $setTitle; // 2nd Entry has the Title
                  $text = trim(str_ireplace('(Out)', '', $text));
                  if($count > 0) {
                    $links[$setTitle][$setDate][$key]= [
                      'href' => $href,
                      'text' => $text,
                      'out'  => $out
                    ];
                  } 
                  $count++;
                }
              }
        		}
        	}
        }
        if(!empty($links) && $this->writeDb === true) {
          // Insert Into DB
          $this->insertDb($links);
        }
      }
      file_put_contents(dirname(__FILE__)."/standard_complete.txt", time());
    }

    // Handle DB Inserts
    private function insertDb($links) {
      global $wpdb;
      $insert_sql = [];
      $table_name = $wpdb->prefix . 'centeredge_booking';
      // Clear out existing Entries
      if($this->first === true) {
        $wpdb->query('DELETE FROM ' . $table_name . ' WHERE `type` = "simple"');
        $this->first = false;
      }
      foreach($links as $title => $event) {
        foreach($event as $date => $items) {
          foreach($items as $entry) {
            $insert_sql[] ="('simple', '".esc_sql($title)."', '".esc_sql($date)."', '".esc_sql($entry['href'])."', '".esc_sql($entry['text'])."', '".esc_sql($entry['out'])."')";
          }
        }
      }
      if(!empty($insert_sql)) {
        $query = join(', ', $insert_sql);
        $sql ="INSERT INTO ".$table_name." (`type`, `name`, `posted`, `link`, `ticket`, `outstock`) VALUES ". $query;
        $wpdb->query($sql);
      }
    }
  }
}
