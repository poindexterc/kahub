<?php
require_once '../AppCode/access.class.php';
$user = new flexibleAccess();
require_once '../AppCode/HelpingDBMethods.php';
if($user->is_loaded())
{
	$MemberID = $user->userID;
	
	$noOfFriends = HelpingDBMethods::GetNoOfFriends($friendID);
	$imageID = HelpingDBMethods::GetMemberImageID($friendID);
				$Query = "SELECT s.StoryID, s.Story_URL
							FROM tbl_story s
							INNER JOIN tbl_comments c ON s.StoryID = c.StoryID				
							ORDER BY c.Date_Time DESC LIMIT 0, 1";	
							
				$QueryResult = mysql_query($Query);
				$row = mysql_fetch_array($QueryResult);
				if($row != false)
				{
					//echo '3--' . $url;
					$maxStory = $row['Story_ID'];
				
			}
				$Query = "SELECT s.StoryID, s.Story_URL
							FROM tbl_story s
							INNER JOIN tbl_comments c ON s.StoryID = c.StoryID				
							ORDER BY c.Date_Time ASC LIMIT 0, 1";	
							
				$QueryResult = mysql_query($Query);
				$row = mysql_fetch_array($QueryResult);
				if($row != false)
				{
					//echo '3--' . $url;
					$minStory = $row['Story_ID'];
				
			}
			
				$storyRand = rand(100, $minStory);
				$Query = "SELECT s.StoryID, s.Story_URL
							FROM tbl_story s
							INNER JOIN tbl_comments c ON s.StoryID = c.StoryID	
							WHERE (s.StoryID = $storyRand)
							ORDER BY c.Date_Time DESC LIMIT 0, 1";	
							
				$QueryResult = mysql_query($Query);
				$row = mysql_fetch_array($QueryResult);
				if($row != false)
				{
					$url = $row['Story_URL'];
					//echo '3--' . $url;
					header('Location:' . $url);
				
			} else {
				
			}
		}
	

else
{
	echo 'You Are Not Loged In.';
}
?>