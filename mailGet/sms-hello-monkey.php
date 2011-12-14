<?php
    require_once '../AppCode/ApplicationSettings.php';
	require_once '../AppCode/HelpingDBMethods.php';
	require_once '../AppCode/HelpingMethods.php';
	require_once '../AppCode/RequestQuery.php';
	require_once '../AppCode/MasterPageScript.php';
 
    // make an associative array of senders we know, indexed by phone number

    
 
    // if the sender is known, then greet them by name
    // otherwise, consider them just another monkey
    session_start();
    $number = $_REQUEST['From'];
    $memberID = HelpingDBMethods::getMemberFromPhone($number);
    $body = $_REQUEST['Body'];
    $type = $_SESSION['type'];
    $subtype = $_SESSION['subtype'];
        // if it doesnt, set the default
    if(!strlen($type)){
        $type = "firstArrival";
    }
    if($memberID!="none"){
        $type = "postComment";
    }
    if($type=="firstArrival"){
        welcome();
    } else if($type=="askEmail") {
        askEmail();
    } else if($type=="askPass"){
        askPass();
    } else if($type=="postComment"){
        postComment();
    } else {
        welcome();
    }
    
    function askEmail(){
        $valid = HelpingDBMethods::getUserFromEmail($body);
        $body = $_REQUEST['Body'];
        if($valid&&$body!=""){
            $_SESSION['email'] = $body;
            header("content-type: text/xml");
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            echo "<Response>
                      <Sms>Awesome! Now reply with the PASSWORD you use to sign into kahub</Sms>
                  </Response>";
            $_SESSION['type'] = "askPass";
            return false;
        } else {
            header("content-type: text/xml");
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            echo "<Response>
                      <Sms>".$body."</Sms>
                  </Response>";
            $_SESSION['type'] = "askEmail";
            return false;
        }
    }
    
    function askPass(){
        $pass = md5($_REQUEST['Body']);
        $memberID = HelpingDBMethods::getValidPassFromEmail($pass);
        if($memberID!="none"){
            HelpingDBMethods::addPhone($memberID, $_REQUEST['From']);
            header("content-type: text/xml");
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            echo "<Response>
                      <Sms>Sweet! Now you're setup to use kahub from your phone. PRO TIP: Text us the lyrics of any song and put \"#lyrics\" at the end. We'll take care of the rest.</Sms>
                  </Response>";
            $_SESSION['type'] = "postComment";
            return false;  
        } else {
            header("content-type: text/xml");
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            echo "<Response>
                      <Sms>Sorry, that doesnt seem to be a valid password :(. Try again.</Sms>
                  </Response>";
            $_SESSION['type'] = "askPass";
            return false;
        }
    }
    
    function welcome(){
        $_SESSION['type'] = "askEmail";
        header("content-type: text/xml");
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<Response>
                  <Sms>Welcome to kahub! Reply with the email you use to sign into kahub. (Std msg rates apply.)</Sms>
              </Response>";
    }
    function checkResult(){
        $comment = $_SESSION['comment'];
        $artist = $_SESSION['artist'];
        $song = $_SESSION['track'];
        $body = $_REQUEST['Body'];
        $number = $_REQUEST['From'];
        $memberID = HelpingDBMethods::getMemberFromPhone($number);
        if(strtolower($body)=="yes"){
            $vidURL = 'https://gdata.youtube.com/feeds/api/videos?q='.urlencode($artist.' - '.$song.' ').'&start-index=1&max-results=1&v=2&alt=json&category=Music';
            $youtube = json_decode(file_get_contents($vidURL), true);
            $vid = $youtube['feed']['entry'][0]['link'][0]['href'];
            $title = $youtube['feed']['entry'][0]['title']['$t'];
            $inDB = HelpingDBMethods::storyInDB($vid);
            if($inDB!=true){
            	$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$vid);
            	HelpingDBMethods::insertStoryTextExtension($story, urldecode($vid), $title);
            }
            $storyID = HelpingDBMethods::GetStoryID($vid);
            HelpingDBMethods::PostVideo($storyID, "NULL", '&#9835;'.$comment.'&#9835; with LyricMatch via SMS', $memberID, 0);
            $comment = "";
            $artist = "";
            $song = "";
            $_SESSION['subtype'] = "";
        } else {
            header("content-type: text/xml");
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            echo "<Response>
                      <Sms>So sorry, what song are you listening to then?</Sms>
                  </Response>";
                  $_SESSION['subtype'] = "postSong";
        }
        
    }
    function postComment(){
        $body = $_REQUEST['Body'];
        $number = $_REQUEST['From'];
        $subtype = $_SESSION['subtype'];
        $memberID = HelpingDBMethods::getMemberFromPhone($number);
        $musicURL = 'http://api.musixmatch.com/ws/1.1/track.search?apikey=edbb9f9d7c163a222eba64a5a479e40c&q_lyrics='.$body.'&format=json';
        $bodyArray = explode(" ", $body);
        $topicArray = explode("#", $body);
        foreach($bodyArray as $word){
            if($word[0]=="#"){
                $postType="hash";
                $hashtag = substr($word, 1);
            }
        }
        if($subType=="postSong"){
            $songArrayA = explode("#listeningto", $body);
            $songArrayB = explode("by", $songArrayA[1]);
            $vidURL = 'https://gdata.youtube.com/feeds/api/videos?q='.urlencode($songArrayB[1].' - '.$songArrayB[0].' ').'&start-index=1&max-results=1&v=2&alt=json&category=Music';
            $youtube = json_decode(file_get_contents($vidURL), true);
            $vid = $youtube['feed']['entry'][0]['link'][0]['href'];
            $title = $youtube['feed']['entry'][0]['title']['$t'];
            $inDB = HelpingDBMethods::storyInDB($vid);
            if($inDB!=true){
            	$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$vid);
            	HelpingDBMethods::insertStoryTextExtension($story, urldecode($vid), $title);
            }
            $storyID = HelpingDBMethods::GetStoryID($vid);
            HelpingDBMethods::PostVideo($storyID, "NULL", '&#9835; #listeningto '.$songArrayA[1].' &#9835; with SongMatch via SMS', $memberID, 0);
            $_SESSION['subtype'] = "";
            return false;
        }
        if($subtype=="check"){
            checkResult();
            return false;
        }
        
        if($hashtag=="listeningto" &&$postType=="hash"){
            $songArrayA = explode("#listeningto", $body);
            $songArrayB = explode("by", $songArrayA[1]);
            
            $vidURL = 'https://gdata.youtube.com/feeds/api/videos?q='.urlencode($songArrayB[1].' - '.$songArrayB[0].' ').'&start-index=1&max-results=1&v=2&alt=json&category=Music';
            $youtube = json_decode(file_get_contents($vidURL), true);
            $vid = $youtube['feed']['entry'][0]['link'][0]['href'];
            $title = $youtube['feed']['entry'][0]['title']['$t'];
            $inDB = HelpingDBMethods::storyInDB($vid);
            if($inDB!=true){
            	$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$vid);
            	HelpingDBMethods::insertStoryTextExtension($story, urldecode($vid), $title);
            }
            $storyID = HelpingDBMethods::GetStoryID($vid);
            HelpingDBMethods::PostVideo($storyID, "NULL", '&#9835; #listeningto '.$songArrayA[1].' &#9835; with SongMatch via SMS', $memberID, 0);
            return false;
        }
        if($hashtag=="l2" &&$postType=="hash"){
            $songArrayA = explode("#l2", $body);
            $songArrayB = explode("by", $songArrayA[1]);
            
            $vidURL = 'https://gdata.youtube.com/feeds/api/videos?q='.urlencode($songArrayB[1].' - '.$songArrayB[0].' ').'&start-index=1&max-results=1&v=2&alt=json&category=Music';
            $youtube = json_decode(file_get_contents($vidURL), true);
            $vid = $youtube['feed']['entry'][0]['link'][0]['href'];
            $title = $youtube['feed']['entry'][0]['title']['$t'];
            $inDB = HelpingDBMethods::storyInDB($vid);
            if($inDB!=true){
            	$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$vid);
            	HelpingDBMethods::insertStoryTextExtension($story, urldecode($vid), $title);
            }
            $storyID = HelpingDBMethods::GetStoryID($vid);
            HelpingDBMethods::PostVideo($storyID, "NULL", '&#9835; #listeningto '.$songArrayA[1].' &#9835; with SongMatch via SMS', $memberID, 0);
            return false;
        }
        if($hashtag =="lyrics"&&$postType=="hash"){
            $musicURL = 'http://api.musixmatch.com/ws/1.1/track.search?apikey=edbb9f9d7c163a222eba64a5a479e40c&q_lyrics='.urlencode($topicArray[0]).'&format=json';
            $lyrics = json_decode(file_get_contents($musicURL), true);
            $song= $lyrics['message']['body']['track_list'][0]['track']['track_name'];
            $artist= $lyrics['message']['body']['track_list'][0]['track']['artist_name'];
            if($song!=""){
                header("content-type: text/xml");
                echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                echo "<Response>
                          <Sms>Are you listening to ".$song." by ".$artist."?</Sms>
                      </Response>";
                $_SESSION['subtype'] = "check";
                $_SESSION['comment'] = $topicArray[0];
                $_SESSION['artist'] = $artist;
                $_SESSION['track'] = $song;
                return false;
            } else {
                header("content-type: text/xml");
                echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
                echo "<Response>
                          <Sms>Sorry, we wern't able to find what song you were listening to</Sms>
                      </Response>";
                return false;
            }
        }
        
        

        if($postType=="hash"){
            $story = HelpingDBMethods::LatestStoryTopic($hashtag);
            $comment = HelpingDBMethods::PostCommentsTopic($story, "NULL", $body, $memberID, 0, $hashtag);
            return $hashtag;
        } else if($subtype=="check") {
            checkResult();
        } else if($subtype=="postSong") {
            $songArray = explode("by", $body);
            $vidURL = 'https://gdata.youtube.com/feeds/api/videos?q='.urlencode($songArrayB[1].' - '.$songArrayB[0].' ').'&start-index=1&max-results=1&v=2&alt=json&category=Music';

            $youtube = json_decode(file_get_contents($vidURL), true);
            $vid = $youtube['feed']['entry'][0]['link'][0]['href'];
            $title = $youtube['feed']['entry'][0]['title']['$t'];
            $inDB = HelpingDBMethods::storyInDB($vid);
            if($inDB!=true){
            	$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$vid);
            	HelpingDBMethods::insertStoryTextExtension($story, urldecode($vid), $title);
            }
            $storyID = HelpingDBMethods::GetStoryID($vid);
            HelpingDBMethods::PostVideo($storyID, "NULL", '&#9835; #listeningto '.$body.' &#9835; with SongMatch via SMS', $memberID, 0);
            $_SESSION['subtype'] = "";
            return false;
        } else { 
            HelpingDBMethods::PostComments(241737, "NULL", $body, $memberID, 0);
            $_SESSION['type'] = "postComment";
        }
    }
    
    
	

    
 
    // now greet the sender
 
?>
