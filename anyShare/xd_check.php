<?php
	require_once '../AppCode/ApplicationSettings.php';
	require_once '../AppCode/HelpingDBMethods.php';
	require_once '../AppCode/HelpingMethods.php';
	require_once '../AppCode/RequestQuery.php';
	require_once '../AppCode/Notifications.php';
	require_once '../AppCode/MasterPageScript.php';
	$url = $_GET['rURL'];
	$uid = $_GET['user'];
	$first = $_GET['ft'];
	$user = new flexibleAccess();
	if($user->is_loaded())
	{
		$uid = $GLOBALS['user']->userID;
	}
	
	if($uid==''){
		$uid = 0;
	}
	
	$iter = $_GET['iter'];
	
	
	$inDB = HelpingDBMethods::storyInDB($url);
	if($inDB!=true&&$first!=1){
		$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$url);
		HelpingDBMethods::insertStoryText($story, $url);
		header('Location: http://www.kahub.com/anyShare/story.php?iter='.$iter.'&user='.$uid.'&rURL='.$url);	
	} else if($first!=1) {
		header('Location: http://www.kahub.com/anyShare/story.php?iter='.$iter.'&user='.$uid.'&rURL='.$url);	
	} else if($inDB!=true){
	    $story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$url);
		HelpingDBMethods::insertStoryText($story, $url);
		header('Location: http://www.kahub.com/anyShare/story.php?ft=1&iter='.$iter.'&user='.$uid.'&rURL='.$url);
	} else {
	    header('Location: http://www.kahub.com/anyShare/story.php?ft=1&iter='.$iter.'&user='.$uid.'&rURL='.$url);	
	}
	
	
	
	
?>
