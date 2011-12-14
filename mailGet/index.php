<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/MasterPageScript.php';
$bodyArray = $_POST;
$text = $bodyArray['text'];
$html = $bodyArray['html'];
if($html==""){
    $body = $text;
} else {
    $body = $html;
}
$subject = $bodyArray['subject'];
$fromArray = json_decode($bodyArray['envelope'], true);
$from = $fromArray['from'];
$memberID = HelpingDBMethods::getUserIDFromEmail($from);
if($memberID){
    $headers =  'From: kahub <notifications@kahub.com>' . "\r<br>";
	$status = false;
    $story = HelpingDBMethods::LatestStoryTopic($subject);
    $comment = HelpingDBMethods::PostCommentsTopic($story, "NULL", $body.' via email', $memberID, 0, $subject);
}



?>