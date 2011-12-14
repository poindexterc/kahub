<?php
	require_once '../AppCode/ApplicationSettings.php';
	require_once '../AppCode/HelpingDBMethods.php';
	require_once '../AppCode/HelpingMethods.php';
	require_once '../AppCode/RequestQuery.php';
	require_once '../AppCode/Notifications.php';
	require_once '../AppCode/MasterPageScript.php';
	$url = $_GET['u'];
	$uid = $_GET['user'];
	$user = new flexibleAccess();
	if($user->is_loaded())
	{
		$uid = $GLOBALS['user']->userID;
	} else {
		header('Location: http://www.kahub.com/login.php');
	}
	
	if($uid==''){
		$uid = 0;
	}
	
	$iter = $_GET['iter'];
	$title = $_GET['t'];
	$raw_url = parse_url($url); 
	$domain_only =str_replace ('www.','', $raw_url); 
	$domain =  $domain_only['host'];	
	$inDB = HelpingDBMethods::storyInDB($url);
	if($inDB!=true&&$domain!="kahub.com"){
		$story = file_get_contents('http://www.kahub.com/anyShare/read2.php?rURL='.$url);
		if($story==""){
			$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$url);
		}
		if($story=="Looks like we couldn't find the content :("){
			$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$url);
		}
		HelpingDBMethods::insertStoryTextExtension($story, $url, addslashes($title));
		header('Location: http://www.kahub.com/anyShare/story.php?iter='.$iter.'&user='.$uid.'&rURL='.$url);	
	} else if($domain!="kahub.com") {
		header('Location: http://www.kahub.com/anyShare/story.php?iter='.$iter.'&user='.$uid.'&rURL='.$url);	
	} else {
		echo '<h1>Not so fast!</h1>';
	}
	
?>
