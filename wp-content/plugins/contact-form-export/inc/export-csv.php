<?php
/**
 * CFDB7 csv
 */

if (!defined( 'ABSPATH')) exit;

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
      $rows = $this->cfdb->get_results("SELECT form_value FROM $this->table_name WHERE form_post_id = '$this->fid' AND DATE_FORMAT(form_date, '%Y-%m-%d') = CURDATE() ORDER BY form_id DESC", OBJECT);
      foreach($rows as $row) {
        $rowRaw = unserialize( $row->form_value );
        $data[$rowRaw['inquiry']][] = $this->clean_value($rowRaw);
      }
      return $data;
    }
    public function clean_value($values) {
      foreach($values as $ky => $val) {
        $values[$ky] = str_replace( array('&quot;','&#039;','&#047;','&#092;')
      , array('"',"'",'/','\\'), $val );
      }
      return $values;
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
      $multipartSep = '-----'.md5(time()).'-----';
      foreach($emailRows as $to => $data) {
        $attachment = chunk_split(base64_encode($this->create_csv_string($data, $heading_key)));
        $headers = array(
           'From: Two Bit Circus <'.$to.'>' ,
           "Content-Type: multipart/mixed; boundary=\"$multipartSep\""
         );
        // Make the body of the message
        $body = "--$multipartSep\r\n"
              . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
              . "Content-Transfer-Encoding: 7bit\r\n"
              . "\r\n"
              . "$subject\r\n"
              . "--$multipartSep\r\n"
              . "Content-Type: text/csv\r\n"
              . "Content-Transfer-Encoding: base64\r\n"
              . "Content-Disposition: attachment; filename=\"Daily_Inquiries_".date("m_d_Y").".csv\"\r\n"
              . "\r\n"
              . "$attachment\r\n"
              . "--$multipartSep--";

         // Send the email, return the result
        @mail($to, $subject, $body, implode("\r\n", $headers));
        sleep(1);
      }
      die();
    }
}
