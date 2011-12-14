<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/Notifications.php';
require_once '../AppCode/MasterPageScript.php';
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-type: text/xml");

$rootURL = Settings::GetRootURL();
$result = "";
$offset=0;
$limit=19;
$check1 = md5("theblacksheepis");
$check2 = md5(time());
$check = $check1.$check2;
$key = $_GET['key'];
$Query = "SELECT COUNT(MemberID) as Count FROM tbl_member WHERE (isHub=0)";
$QueryResult =  mysql_query($Query)or die(mysql_error());
$row = mysql_fetch_array($QueryResult);
$total = $row['Count'];
if($key!=$check){
	//header('Location:http://www.kahub.com/');	
}
$rssfeed = '<xml>';
$rssfeed .= '<rows>';
$rssfeed .= '<page>1</page>';
$rssfeed .= '<total>'.$total.'</total>';
$rootURL = Settings::GetRootURL();
$result = "";
$Query = "SELECT * FROM tbl_member WHERE (isHub=0)";
$QueryResult =  mysql_query($Query)or die(mysql_error());
$row = mysql_fetch_array($QueryResult);
while($row != false)
{
		$name = MemberDBMethods::GetUsername($row['MemberID']);
		$friends = HelpingDBMethods::GetNoOfFriends($row['MemberID']);
		$ban = HelpingDBMethods::isBanned($row['MemberID']);
		$spamScore = HelpingDBMethods::spamScore($row['MemberID']);
		$noComments = HelpingDBMethods::GetNoComments($row['MemberID']);
		
        $rssfeed .= '<row id="'.$row['MemberID'].'">';
        $rssfeed .= '<cell id="id">' . $row['MemberID'] . '</cell>';
        $rssfeed .= '<cell name="name">' . $name . '</cell>';
        $rssfeed .= '<cell name="friends">' . $friends . '</cell>';
        $rssfeed .= '<cell name="noComments">' . $noComments . '</cell>';
		$rssfeed .= '<cell name="spamScore">' . $spamScore . '</cell>';
		$rssfeed .= '<cell name="banned">' . $ban . '</cell>';
        $rssfeed .= '</row>';
		$row = mysql_fetch_array($QueryResult);
}
$rssfeed .= '</rows>';
$rssfeed .= '</xml>';

echo $rssfeed;
?>