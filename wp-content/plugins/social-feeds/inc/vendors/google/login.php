<?php
require_once('../../config/global.php');
require_once ROOT . '/vendors/google/autoload.php';
$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$client->setRedirectUri(GOOGLE_API_REDIRECT);

$authUrl = $client->createAuthUrl();
echo '<a href="'.$authUrl.'">Authorize Access</a>';