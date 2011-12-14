<?
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/MasterPageScript.php';
$user = new flexibleAccess();
if($user->is_loaded())
{
	$uid = $GLOBALS['user']->userID;
} else {
	header('Location: http://www.kahub.com/');
}
$create=true;
$hubName= $_GET['hName'];
function hubCreated($hubName)
{
	$result = false; 
	$storyID = HelpingDBMethods::GetStoryID($url);
	
	$Query = "SELECT COUNT(id) as Count FROM tbl_hub WHERE (keyword  = '$hubName')";	
	$QueryResult =  mysql_query($Query)or die(mysql_error());
	$row = mysql_fetch_array($QueryResult);
	if($row!=false)
	{
		//$result = $row['StoryID'];
		$count = $row['Count'];
		if($count > 0)
			$result = true;
	}
	return $result;
}

$created = hubCreated($hubName);
if($created){
	$create = false;
	echo "1";
} 

if(strlen($hubName)<3){
	$create = false;
	echo "2";
}
if(strlen($hubName)>15){
	$create = false;
	echo "3";
}

$wikiData = HelpingDBMethods::wikidefinition($hubName);
if($wikiData[3]==""){
	$create = false;
	echo "4";
}

if(strlen($wikiData[3])>25){
	$create = false;
	echo "5";
}
$storiesCache = HelpingDBMethods::LatestStoriesPersonArray($wikiData[3]);
if($storiesCache[3]==""){
	$create= false;
	echo "6";
}


if($create){
	$tblMember = MemberDBMethods::AddMemberHub($wikiData[3], "", "", "", "", "", "");
	MemberDBMethods::addHub($wikiData[3], $tblMember, $uid);
	header('Location: http://www.kahub.com/l/hub?user='.$tblMember);
} else {
	header('Location: http://www.kahub.com/INVALIDTOPIC');
}