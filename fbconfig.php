<?php

session_start();
// added in v4.0.0
require_once 'autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

// init app with app id and secret
FacebookSession::setDefaultApplication('252001668249149', 'd39f42942b1239ae7f83726a5ea23a3e');
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://localhost/RecommendationEngine/fbconfig.php');
try {
    $session = $helper->getSessionFromRedirect();
} catch (FacebookRequestException $ex) {
    // When Facebook returns an error
} catch (Exception $ex) {
    // When validation fails or other local issues
}
// see if we have a session
if (isset($session)) {
    // graph api request for user data
    $request = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    // get response
    $graphObject = $response->getGraphObject();
        $kwarr = array();
   

    
//    $fav_ath = $graphObject->getProperty('favorite_athletes');    
//    $fav_team = $graphObject->getProperty('favorite_teams');    
    $gender = $graphObject->getProperty('gender');    
    $inspiration = $graphObject->getProperty('inspirational_people'); 
    foreach ($inspiration as $spv) {
        array_push($kwarr, $spv->getProperty('name'));        
    }
    $sports = $graphObject->getProperty('sports');   
    foreach ($sports as $spv) {
        array_push($kwarr, $spv->getProperty('name'));        
    }
    
    
    
    // echo "<pre>";print_r($sports); 
    // Code to get the 
    

    
    
    
    
    
    $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
    /* ---- Session Variables ----- */
    $_SESSION['FBID'] = $fbid;
    $_SESSION['FULLNAME'] = $fbfullname;
    $_SESSION['EMAIL'] = $femail;
    $_SESSION['KEYWORDS'] = $kwarr;
    /* ---- header location after session ---- */
    header("Location: index.php");
} else {
    $loginUrl = $helper->getLoginUrl();
    header("Location: " . $loginUrl);
}
?>