<?php
/**
 * CFDB7 csv
 */

//if (!defined( 'ABSPATH')) exit;

class Expoert_CSV{

    public $fid = 431;
    private $cfdb;
    private $table_name;

    public function __construct() {
      global $wpdb;
      $this->cfdb        = apply_filters( 'cfdb7_database', $wpdb );
      $this->table_name  = $this->cfdb->prefix.'db7_forms';
    }
    public function get_csv_heading() {
      $heading_row = $this->cfdb->get_results("SELECT form_id, form_value, form_date FROM $this->table_name WHERE form_post_id = '$this->fid' ORDER BY form_id DESC LIMIT 1", OBJECT);
      $heading_row = reset( $heading_row );
      $heading_row = unserialize( $heading_row->form_value );
      $heading_key = array_keys( $heading_row );
      return $heading_key;
    }
    public function get_email_listing() {
      $data = [];
      $rows = $this->cfdb->get_results("SELECT form_value FROM $this->table_name WHERE form_post_id = '$this->fid' AND DATE_FORMAT(form_date, '%Y-%m-%d') = (CURDATE() - INTERVAL 1 DAY) ORDER BY form_id DESC", OBJECT);
      foreach($rows as $row) {
        $rowRaw = unserialize( $row->form_value );
        $data[$rowRaw['inquiry']][] = $rowRaw;
      }
      return $data;
    }
    public function create_csv_string($data, $heading_key) {
      if (!$fp = fopen('php://temp', 'w+')) return FALSE;
      fputcsv($fp, $heading_key);
      // Loop data and write to file pointer
      foreach ($data as $line) fputcsv($fp, $line);
      rewind($fp);
      return stream_get_contents($fp);
    }

    public function send_csv_email() {
      $heading_key = $this->get_csv_heading();
      $emailRows = $this->get_email_listing();
      $setDate = date("m/d/Y");
      $subject = 'Daily Inquiries for ' . $setDate;
      $message = 'Attached is the Daily Inquiries for ' . $setDate;
      foreach($emailRows as $to => $data) {
        $headers = 'From: Two Bit Circus <'.$to.'>' . "\r\n";
        $attachments = chunk_split(base64_encode($this->create_csv_string($data, $heading_key)));
        try {
          $sent = wp_mail( 'alex@petrolad.com', $subject, $message, $headers, $attachments);
          if ( $sent ) {
            // The message was sent.
            echo 'The test message was sent. Check your email inbox.';
          } else {
            // The message was not sent.
            echo 'The message was not sent!';
          }
        } catch( Exception $e ) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        sleep(1);
      }
      die();
    }
}

function action_wp_mail_failed($wp_error)
{
    return error_log(print_r($wp_error, true));
}

// add the action
add_action('wp_mail_failed', 'action_wp_mail_failed', 10, 1);
