<?php
/**
 * WP Custom Calendar Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if ( ! class_exists( 'Calendar' ) ) {

  // Register Class
  class Calendar {

    public $daysToShow = '';
    private $current_date = 0;
    private $calender = [];
    private $end_date = 0;
    private $allowShows = '';
    private $closed = '';
    private $limit = 0;

  	public function __construct() {
      // Get Dates
      $_region = get_locations(get_field('location_selection', 'option'));
      $_allowShow = filter_locations(get_field('allow_shows', 'option'));
      $_closed = filter_locations(get_field('calendar_days_of_the_week_closed', 'option'));
      date_default_timezone_set($_region[0]['timezone']);
      $this->daysToShow = get_field('days_to_show', 'option');
      $this->current_date = time();
      $this->end_date = strtotime($this->daysToShow);
      $this->allowShows = (!empty($_allowShow)) ? explode(',', $_allowShow[0]['calendar_allow_shows']) : [];
      $this->closed = (!empty($_closed)) ? explode(',', $_closed[0]['closed_days']) : [];
      $this->special_event = get_field('special_event', 'option');
    }
    public function init() {
      global $wpdb;
      $table_name = $wpdb->prefix . 'centeredge_booking';
      $_query = 'SELECT * FROM `'. $table_name .'` WHERE `posted` <= "'. date('m-d-Y', $this->end_date) .'" GROUP BY `name`, `posted` ORDER BY `posted`, `ticket`';
      $data = $wpdb->get_results($_query);
      if(!empty($data)) {
        foreach($data as $entry) {
          if(in_array(trim($entry->name), $this->allowShows)) {
            $_day = explode('-',$entry->posted)[1];
            $this->calender[$_day][ date('H:i A', strtotime($entry->ticket))][] = $entry;
          }
        }
      }
      //print_r($this->calender);
      $this->specials();
      return $this->calender;
    }
    public function get_closed() {
      return $this->closed;
    }
    public function get_endDate() {
      return $this->end_date;
    }
    private function specials() {
      if(empty($this->special_event)) return false;
      $allow = filter_locations($this->special_event);
      foreach($allow as $spvent) {
        $recurring = [];
        $collect = [];
        $excludeEvent = [];
        if( $spvent['show_date'] < date('m-d-Y') && empty($spvent['recurring_day'])) {
          continue;
        }
        if($spvent['recurring_day']) {
          $nextRecurring = strtotime('next '.$spvent['recurring_day']['value']);
          if(!empty($spvent['recurring_exclude_date'])) {
            $exludeOut = explode(PHP_EOL, $spvent['recurring_exclude_date']);
            $exludeOut = array_filter($exludeOut, 'strlen');
            foreach($exludeOut as $exDate) {
              $excludeEvent[] = strtotime($exDate);
            }
            //print_r($excludeEvent);
          }

          if($nextRecurring > $this->end_date) continue;
          $_spday = date('d', $nextRecurring);
          $this->limit = 0;
          $recurring = $this->getRecurringDays($nextRecurring, $excludeEvent, $spvent['recurring_day']['value'], $this->end_date, $collect);
        } else {
          $_spday = explode('-',$spvent['show_date'])[1];
        }
        $obj = [];
        $obj['name'] = $spvent['show_title'];
        $obj['posted'] = $spvent['show_date'];
        $obj['link'] = $spvent['show_link'];
        $obj['ticket'] = $spvent['show_time'];
        $obj['ticket_alt'] = $spvent['show_time_alt'];
        $obj['target'] = $spvent['target'];
        $setTimeTicket = date('H:i A', strtotime($obj['ticket']));
        if(!empty($recurring)) {
          //print_r($recurring);
          foreach($recurring as $key => $recr) {
            $_dy = date('d', $recr);
            $obj['posted'] = date('m-d-Y', $recr);
            $setTimeTicket = date('H:i A', strtotime($obj['ticket']));
            if(isset($this->calender[$_dy]) && $this->calender[$_dy][$setTimeTicket]) {
              $setTimeTicket = $setTimeTicket.'-2-'.$key;
            }
            $specialEvent[$_dy][$setTimeTicket][] = (object) $obj;
          }
        } else {
          if($this->calender[$_spday][$setTimeTicket]) {
            $setTimeTicket = $setTimeTicket.'-2';
          }
          $specialEvent[$_spday][$setTimeTicket][] = (object) $obj;
        }
      }
      //print_r($specialEvent);
      do {
        $day = date('d', $this->current_date);
        if(isset($specialEvent[$day]) && !empty($specialEvent[$day])) {
          if(isset($this->calender[$day])) {
            $calender[$day] = array_merge($specialEvent[$day], $this->calender[$day]);
          } else {
            $this->calender[$day] = $specialEvent[$day];
          }
        }
        $this->current_date = strtotime('+1 day', $this->current_date);
      } while ($this->current_date <= $this->end_date);
    }
    private function getRecurringDays($date, $exc, $day, $end, $collect, $limit=0) { 
      if(empty($date)) return false;
      if($this->limit > 5) return false;
      $checkDate = '';
      $today = strtolower(date('l'));
      if($today == $day && empty($collect)) {
        $date = strtotime("today");
      } else {
        $date = (!empty($collect)) ? strtotime('next '.$day, $date) : $date;
      }
      if($date <= $end) {
        // Check to Skip Date if Excluded
        if(!in_array($date, $exc)) {
          $collect[] = $date;
        } else {
          //echo 'STOP---' . $date . '---STOP!';
          $collect[] = '';

        }
        $this->limit++;
        return $this->getRecurringDays($date, $exc, $day, $end, $collect, $this->limit);
      }
      return $collect;
    }
  }
}
