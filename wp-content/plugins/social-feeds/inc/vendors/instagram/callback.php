<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once '../../../../../../wp-load.php';
$api_options = get_option('social_insta_api_keys');

require_once __DIR__ . '/instagram.php';

if(!empty($api_options)) {
    $connection = new Instagram(array(
      'apiKey' => $api_options['appid'],
      'apiSecret' => $api_options['secret'],
      'apiCallback' => get_site_url() . '/wp-content/plugins/social-feeds/inc/vendors/instagram/callback.php'
    )); 
    if(!empty($_GET['code'])) {
      $data = $connection->getOAuthToken($_GET['code'], true);
      echo json_encode($_GET['code']);
    } else {
      $scope = array('public_content');
      $loginUrl = $connection->getLoginUrl($scope);
      if(!empty($loginUrl)) {
        echo '<a href="' . $loginUrl . '">Log in with Instagram!</a>';
      } else {
        echo "Token Instagram Redirect Error";
      }
    }
}
