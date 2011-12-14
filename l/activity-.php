<?php
require_once '../AppCode/access.class.php';
$user = new flexibleAccess();
require_once '../AppCode/HelpingDBMethods.php';
if($user->is_loaded())
{
	$friendID = $_GET['id'];
	$MemberID = $user->userID;
	
	$noOfFriends = HelpingDBMethods::GetNoOfFriends($friendID);
	$imageID = HelpingDBMethods::GetMemberImageID($friendID);
	if($noOfFriends < 3 || $imageID == 0)
	{
		$Query = "SELECT s.StoryID, s.Story_URL
						FROM tbl_story s
						INNER JOIN tbl_comments c ON s.StoryID = c.StoryID
						INNER JOIN tbl_trust t ON c.MemberID = t.FriendsID						
						WHERE (t.MemberID = $MemberID)
						ORDER BY c.Date_Time DESC LIMIT 300, 1";	
		$QueryResult = mysql_query($Query);
		$row = mysql_fetch_array($QueryResult);
		if($row != false)
		{
			$url = $row['Story_URL'];
			//echo '1--' . $url;
			header('Location:' . $url);
		}
		else
		{
			$Query = "SELECT s.StoryID, s.Story_URL
						FROM tbl_story s
						INNER JOIN tbl_comments c ON s.StoryID = c.StoryID				
						WHERE (c.MemberID = $MemberID)
						ORDER BY c.Date_Time DESC LIMIT 0, 1";	
			$QueryResult = mysql_query($Query);
			$row = mysql_fetch_array($QueryResult);
			if($row != false)
			{
				$url = $row['Story_URL'];
				//echo '3--' . $url;
				header('Location:' . $url);
			}
			else
			{
				echo 'should neot be here';
			}
		}
	}
	else
	{					
		// most recent story comment
		$Query = "SELECT DISTINCT s.StoryID, s.Story_URL
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive	AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON b.MemberID_Active = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID
						WHERE (a.MemberID_Active = '$friendID')
						ORDER BY c.Date_Time DESC LIMIT 0, 1";	
		$QueryResult = mysql_query($Query);
		$row = mysql_fetch_array($QueryResult);
		if($row != false)
		{
			$url = $row['Story_URL'];
			//echo '2--' . $url;
			header('Location:' . $url);
		}		
	}
}
else
{
	echo 'You Are Not Loged In.';
}
?>