<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once '../../../../../../wp-load.php';
$api_options = get_option('social_fb_api_keys');
if (($loader = require_once __DIR__ . '/autoload.php') == null)  {
  die('Vendor directory not found, Please run composer install.');
}
if(!empty($api_options)) {
  $fb = new \Facebook\Facebook([
    'app_id' => $api_options['appid'],
    'app_secret' => $api_options['secret'],
    'default_graph_version' => 'v2.10',
    //'default_access_token' => '{access-token}', // optional
  ]);

  // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
  $helper = $fb->getRedirectLoginHelper();

  try {
    $accessToken = $helper->getAccessToken();
    if (isset($accessToken) && $accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
        exit;
      }
    }
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  if (! isset($accessToken)) {
    echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet. <br>';
    $permissions = ['email', 'user_likes']; // optional
    $loginUrl = $helper->getLoginUrl(get_site_url() . '/wp-content/plugins/social-feeds/inc/vendors/Facebook/callback.php', $permissions);
    echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
  } else {
     echo '<h3>Access Token</h3>';
     var_dump($accessToken->getValue());
  }
}
