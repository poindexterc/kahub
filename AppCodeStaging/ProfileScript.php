<?php
require_once 'ApplicationSettings.php';
require_once 'HelpingDBMethods.php';
require_once 'HelpingMethods.php';
require_once 'RequestQuery.php';
require_once 'Notifications.php';
include_once 'FBConnect/fbmain.php';
class Profile {
	function GetUserName($memberID)
	{
		$result = "";
		$Query = "SELECT mFirst_Name, mLast_Name FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['mFirst_Name'] . " " . $row['mLast_Name'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}