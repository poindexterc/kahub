<?php
require_once '../AppCode/access.class.php';
$user = new flexibleAccess();
require_once '../AppCode/HelpingDBMethods.php';
if($user->is_loaded())
{
	$uid = $GLOBALS['user']->userID;
	$user = $GLOBALS['user']->userID;
	
} else {
	$uid = $_GET['user'];
}

$iter = $_GET['iter'];
if($iter==""){
	$iter = 1;
}
$key = md5($uid);
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Could not connect"); //connect to memcached server
$totalResult2 = "total";
$totalResult = $key.$totalResult2;
$result = $memcache->get($totalResult);
if($result == null) {
	$Query = "SELECT COUNT(DISTINCT s.StoryID) AS Count
				FROM tbl_friends a
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
				INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
				INNER JOIN tbl_story s ON c.StoryID = s.StoryID
				WHERE (a.MemberID_Active = '$uid')";
	$QueryResult =  mysql_query($Query)or die(mysql_error());
	$totalResultsCache = mysql_result($QueryResult, 0, 0);
	$memcache->set($totalResult, $totalResultsCache, false, 14400);
}
$totalStories2 = md5("stories");
$totalStories = $totalStories2;
$resultStories = $memcache->get($totalStories);
if($resultStories == null) {
	$countquery = "SELECT COUNT(*) AS cnt FROM tbl_story";
	$QueryResult = mysql_query($countquery);
	$countCache = mysql_result($QueryResult, 0, 0);
	$memcache->set($totalStories, $countCache, false, 14400);
}
$count = $memcache->get($totalStories);
$totalResults = $memcache->get($totalResult);

if($totalResults<20){
	$storyRand = rand(0, $count);
	$Query = "SELECT StoryID, Story_URL
				FROM tbl_story ORDER BY views DESC LIMIT $storyRand, 1";	
	$QueryResult = mysql_query($Query);
	$row = mysql_fetch_array($QueryResult);
	if($row != false)
	{
		$url = $row['Story_URL'];
		//echo '3--' . $url;
		header('Location:http://www.kahub.com/anyShare/xd_check.php?iter='.$iter.'&user='.$uid.'&rURL='.$url);
	}
} else if (($iter % 2) == 0){
	$Query = "SELECT DISTINCT s.Story_URL
				FROM tbl_friends a
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
				INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
				INNER JOIN tbl_story s ON c.StoryID = s.StoryID
				WHERE (a.MemberID_Active = '$uid')
				ORDER BY RAND() LIMIT 1";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false){
				$url = $row['Story_URL'];
				//echo '3--' . $url;
				header('Location:http://www.kahub.com/anyShare/xd_check.php?iter='.$iter.'&user='.$uid.'&rURL='.$url);
			} 
} else {	
	$storyRand = rand(0, $count);
	$storyRead = storyRead($user, $storyRand);
	while($storyRead!=0){
		$storyRand = rand(0, $count);
		$storyRead = storyRead($user, $storyRand);
	}
	$Query = "SELECT StoryID, Story_URL 
				FROM tbl_story ORDER BY views DESC LIMIT $storyRand, 1";	
	$QueryResult = mysql_query($Query);
	$row = mysql_fetch_array($QueryResult);
	if($row != false&&$storyRead==0)
	{
		$url = $row['Story_URL'];
		//echo '3--' . $url;
		$storyID = HelpingDBMethods::GetStoryID($url);
		HelpingDBMethods::insertMemberViewed($storyID, $user);
		header('Location:http://www.kahub.com/anyShare/xd_check.php?iter='.$iter.'&user='.$uid.'&rURL='.$url);
	}
}

function storyRead($MemberID, $StoryID){
	$query = "SELECT COUNT(id) FROM tbl_story_viewed WHERE (MemberID='$MemberID') AND (StoryID ='$StoryID')";
	$queryResult = mysql_query($query);
	$count = mysql_result($queryResult, 0, 0);
	return $count;
}
?>