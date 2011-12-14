<?php
require_once 'HelpingDBMethods.php';
class StoryRanking
{
	function SetStoryRanking()
	{
		$timeLimit = date('Y-m-d H-i-s', strtotime('-1 day'));
		//$Query = "SELECT * FROM tbl_story WHERE DateTime > '$timeLimit' ORDER BY DateTime DESC";
		$Query = "SELECT * FROM tbl_story";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while( $row != false)
		{
			$StoryID = $row['StoryID'];
			$url = $row['Story_URL'];
			//HelpingDBMethods::UpdateStoryCategory($StoryID, $url);
			//HelpingDBMethods::UpdateStoryTags($StoryID, $url);
			//StoryRanking::SetStoryCommentRanking($StoryID);
			HelpingDBMethods::UpdateStoryImage($StoryID);
			$row = mysql_fetch_array($QueryResult);
		}
	}
	
	function GetStoryRanking($StoryID)
	{
		$result = 0;
		$Query = "SELECT Ranking as Count FROM tbl_story_ranking WHERE (StoryID = '$StoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}		
		return $result;
	}
	
	function GetStoryCommulativeRank($StoryID, $MemberID)
	{
		$trustFactor = StoryRanking::GetTrustedMemberRanking($StoryID, $MemberID);
		$lastCommentRanking = StoryRanking::GetLastCommentRanking($StoryID);
		$ranking = StoryRanking::GetStoryRanking($StoryID);
		return $trustFactor+$lastCommentRanking+$ranking;
	}
	
	function GetLastCommentRanking($StoryID)
	{
		$result = date('Y-m-d H-i-s');
		$rankingPoints = 0;
		$Query = "SELECT c.Date_Time AS Date 
				FROM tbl_friends a
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive
				AND a.MemberID_Passive = b.MemberID_Active
				INNER JOIN tbl_comments c ON a.FriendsID = c.MemberID
				WHERE (c.StoryID = '$StoryID')
				ORDER BY c.Date_Time DESC LIMIT 0, 1";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row != false)
		{
			$result = $row['Date'];
		}
		$timeDiff = time() - strtotime($result);
		if($timeDiff < 5*60)
		{
			$rankingPoints = 10;
		}
		elseif($timeDiff < 10*60)
		{
			$rankingPoints = -2;
		}
		
		elseif($timeDiff < 12*60)
		{
			$rankingPoints = -5;
		}
		elseif($timeDiff < 20*60)
		{
			$rankingPoints = -7;
		}
		elseif($timeDiff < 60*60)
		{
			$rankingPoints = -10;
		}
		elseif($timeDiff < 120*60)
		{
			$rankingPoints = -15;
		}
		elseif($timeDiff < 300*60)
		{
			$rankingPoints = -40;
		}
		
		return $rankingPoints;
	}
	
	function GetTrustedMemberRanking($StoryID, $MemberID)
	{
		$Query = "SELECT COUNT( DISTINCT tbl_comments.CommentID ) AS Count 
				FROM tbl_comments 
				INNER JOIN tbl_trust ON tbl_comments.MemberID = tbl_trust.FriendsID
				WHERE tbl_comments.StoryID = '$StoryID'";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$result = $row['Count'];
		return $result + 20;
	}
	
	private function GetStoryViewsRanking($StoryID)
	{
		$result = 0;
		$rankingPoints = 0; 
		$Query = "SELECT views as Count FROM tbl_story WHERE (StoryID = '$StoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result <= 5)
		{
			$rankingPoints = 0;
		}
		elseif($result > 5 && $result <= 50)
		{
			$rankingPoints = 10;
		}
		elseif($result > 51 && $result <= 1000)
		{
			$rankingPoints = 2;
		}
		elseif($result > 1000 && $result <= 5000)
		{
			$rankingPoints = 3;
		}
		elseif($result > 5000 && $result <= 20000)
		{
			$rankingPoints = 5;
		}
		elseif($result > 20000 && $result <= 50000)
		{
			$rankingPoints = 3;
		}
		elseif($result > 50000)
		{
			$rankingPoints = 2;
		}
		return $rankingPoints;
	}
	
	private function GetCommentorsBadgesRanking($StoryID)
	{
		$result = 0;
		$rankingPoints = 0;
		$Query = "SELECT DISTINCT MemberID FROM tbl_comments WHERE (StoryID = '$StoryID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while( $row != false)
		{
			$MemberID= $row['MemberID'];
			$result = HelpingDBMethods::GetnoOfBadges($MemberID);
			if($result == 2)
			{
				$rankingPoints += 5;
			}
			elseif($result == 3)
			{
				$rankingPoints += 6;
			}
			elseif($result == 4)
			{
				$rankingPoints += 7;
			}
			elseif($result == 5)
			{
				$rankingPoints += 8;
			}
			elseif($result >5)
			{
				$rankingPoints += 9;
			}
			$row = mysql_fetch_array($QueryResult);
		}
		
		return $rankingPoints;	
	}
	
	private function SetStoryCommentRanking($StoryID)
	{
		//$trustedMemberRanking = StoryRanking::GetTrustedMemberRanking($StoryID);
		$storyViewsRanking = StoryRanking::GetStoryViewsRanking($StoryID);
		$CommentorsBadgesRanking = StoryRanking::GetCommentorsBadgesRanking($StoryID);
		$noOfMembersCommentRanking = StoryRanking::GetNoOfMembersCommentRanking($StoryID);
		$rankingPoints = $storyViewsRanking + $CommentorsBadgesRanking + $noOfMembersCommentRanking;
		
		$Query = "INSERT INTO tbl_story_ranking (StoryID, Ranking) VALUES ($StoryID, $rankingPoints) ON DUPLICATE KEY UPDATE Ranking = $rankingPoints;";
		$QueryResult =  mysql_query($Query)or die(mysql_error());		
	}
	
	private function GetNoOfMembersCommentRanking($StoryID)
	{
		$result = 0;
		$rankingPoints = 0;
		$Query = "SELECT COUNT(DISTINCT MemberID) AS Count FROM tbl_comments WHERE (StoryID = '$StoryID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if( $row != false)
		{
			$result= $row['Count'];
		}
		if($result >= 98)
		{
			$rankingPoints = 7;
		}
		return $rankingPoints;
	}
}
?>
