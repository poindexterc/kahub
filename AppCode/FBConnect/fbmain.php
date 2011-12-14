<?php
	$fbconfig['appid' ]  = "146470212065341";
	$fbconfig['api'   ]  = "212dcc92fc9aba19273b83a3f250157e";
	$fbconfig['secret']  = "31ec0b903044d95e4d0f2e0f0d3552fa";

    try{
        include_once "facebook.php";
    }
    catch(Exception $o){
        echo 'ibraheem';
        echo '<pre>';
        print_r($o);
        echo '</pre>';
    }
    // Create our Application instance.
    $facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret'],
      'cookie' => true,
    ));

    // We may or may not have this data based on a $_GET or $_COOKIE based session.
    // If we get a session here, it means we found a correctly signed session using
    // the Application Secret only Facebook and the Application know. We dont know
    // if it is still valid until we make an API call using the session. A session
    // can become invalid if it has already expired (should not be getting the
    // session back in this case) or if the user logged out of Facebook.
    $session = $facebook->getSession();
    $fbme = null;
    // Session based graph API call.
    if ($session) {
      try {
        $uid = $facebook->getUser();
        $fbme = $facebook->api('/me');        
      } catch (FacebookApiException $e) {
          d($e);
      }
    }

    function d($d){
        //echo 'ismail';

        //echo '<pre>';
        print_r($d);
        //echo '</pre>';
    }
?>