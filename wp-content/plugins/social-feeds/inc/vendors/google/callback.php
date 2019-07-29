<?php
session_start();
require_once('../../config/global.php');
if(isset($_GET['code'])) {

    require_once ROOT . '/vendors/google/autoload.php';
    $client = new Google_Client();
    $client->setClientId(GOOGLE_CLIENT_ID);
    $client->setClientSecret(GOOGLE_CLIENT_SECRET);
    $client->setScopes('https://www.googleapis.com/auth/youtube');
    $client->setRedirectUri(GOOGLE_API_REDIRECT);

    $client->authenticate($_GET['code']);
    $_SESSION['google_token'] = $client->getAccessToken();
    echo $_SESSION['google_token'];
}