<?php
require_once 'ApplicationSettings.php';
require_once 'RequestQuery.php';
require_once 'access.class.php';
require_once 'HelpingDBMethods.php';
require_once 'CommentsMethods.php';
require_once 'Notifications.php';
class BadgeMethods
{	
	function AssignMemberBadgesOnComment($MemberID, $CommentType)
	{
		if($CommentType == 'share')
		{
			$NoOfComments = BadgeMethods::GetNoOfComments($MemberID, 'both');
			if($NoOfComments == 1)
			{
				BadgeMethods::AssignBadge(1, $MemberID); // Commented on first story
				BadgeMethods::AssignBadge(2, $MemberID); // is downloaded exention true if he is commenting, so this is implemented here
			}
			if($NoOfComments >= 55)
			{
				BadgeMethods::AssignBadge(48, $MemberID); // commented on 15 stories
				if($NoOfComments >= 307)
				{
					BadgeMethods::AssignBadge(4, $MemberID); // commented on 17 stories
				}
			}
		}
		elseif($CommentType == 'reply')
		{
			$NoOfReplies = BadgeMethods::GetNoOfComments($MemberID, 'replies');
			if($NoOfReplies >= 30)
			{
				BadgeMethods::AssignBadge(5, $MemberID); // replied to 30 comments
			}
			
			BadgeMethods::UpdateBadge8($MemberID);
			BadgeMethods::UpdateBadge10($MemberID);
		}
		BadgeMethods::UpdateBadge3($MemberID);
		BadgeMethods::UpdateBadge39($MemberID);
		BadgeMethods::UpdateBadge45($MemberID);
		BadgeMethods::UpdateBadge47($MemberID);
		BadgeMethods::UpdateBadge50($MemberID);
		BadgeMethods::UpdateBadge51($MemberID);
		BadgeMethods::UpdateBadge52($MemberID);
		BadgeMethods::UpdateBadge53($MemberID);
		BadgeMethods::UpdateBadge54($MemberID);
		BadgeMethods::UpdateBadge55($MemberID);
		BadgeMethods::UpdateBadge56($MemberID);
		BadgeMethods::UpdateBadge57($MemberID);
		BadgeMethods::UpdateBadge59($MemberID);
		BadgeMethods::UpdateBadge60($MemberID);
		
	}
	
	function AssignMemberBadgesOnTrust($MemberID, $StoryID)
	{
		BadgeMethods::UpdateBadge7($MemberID);
		BadgeMethods::UpdateBadge11($MemberID, $StoryID);
		BadgeMethods::UpdateBadge12($MemberID, $StoryID);
		BadgeMethods::UpdateBadge35($MemberID); // also implements badge 36 , 37
	}
	
	function AssignMemberBadgesOnLike($MemberID)
	{
		BadgeMethods::UpdateBadge40($MemberID); // also implements badge 41, 42, 43
	}
	
	function AssignBadge($BadgeID, $MemberID)
	{
		$isAlreadyAssigned = BadgeMethods::isAlreadyAssigned($BadgeID, $MemberID);
		if(!$isAlreadyAssigned)
		{
			//$DateTime = date("Y-m-d H-i-s");//gmdate('Y-m-d H-i-s')
			$Query = "INSERT INTO tbl_member_badge (MemberID, BadgeID) VALUES ($MemberID, $BadgeID)";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			
			$data = array("AddressedTo" => $MemberID, "BadgeID" => $BadgeID);
			Notifications::InsertNotification(4, $data);
		}
	}
	
	function RemoveBadge($BadgeID)
	{
		$Query = "DELETE FROM tbl_member_badge WHERE (BadgeID = $BadgeID)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function GetNoOfComments($MemberID, $ofType = 'both')
	{
		$result = 0; 
		$Query = "";
		if($ofType == 'both')
		{
			$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID')";
		}
		elseif($ofType == 'replies')
		{
			$Query = "SELECT COUNT(DISTINCT Reply_To) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Reply_To <> 0)";
		}	
		elseif($ofType == 'comments')
		{
			$Query = "SELECT COUNT(CommentID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Reply_To = 0)";
		}
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}	
	
	function isAlreadyAssigned($BadgeID, $MemberID)
	{
		$result = false; 
		$Query = "SELECT COUNT(MBID) AS Count FROM tbl_member_badge WHERE (MemberID  = '$MemberID') AND (BadgeID  = '$BadgeID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$count = $row['Count'];
			if($count > 0)
				$result = true;
		}
		return $result;
	}
	
	function UpdateBadge($BadgeID)
	{
		switch ($BadgeID)
		{
			case 6:
				BadgeMethods::UpdateBadge6();
				break;
			case 13:
				BadgeMethods::UpdateBadge13();
				break;
			case 14:
				BadgeMethods::UpdateBadge14();
				break;
			case 15:
				BadgeMethods::UpdateBadge15();
				break;
			case 16:
				BadgeMethods::UpdateBadge16();
				break;
			case 17:
				BadgeMethods::UpdateBadge17();
				break;
			case 18:
				BadgeMethods::UpdateBadge18();
				break;
			case 19:
				BadgeMethods::UpdateBadge19();
				break;
			case 20:
				BadgeMethods::UpdateBadge20();
				break;
			case 21:
				BadgeMethods::UpdateBadge21();
				break;
			case 22:
				BadgeMethods::UpdateBadge22();
				break;
			case 23:
				BadgeMethods::UpdateBadge23();
				break;
			case 24:
				BadgeMethods::UpdateBadge24();
				break;
			case 25:
				BadgeMethods::UpdateBadge25();
				break;
			case 26:
				BadgeMethods::UpdateBadge26();
				break;
			case 27:
				BadgeMethods::UpdateBadge27();
				break;
			case 28:
				BadgeMethods::UpdateBadge28();
				break;
			case 29:
				BadgeMethods::UpdateBadge29();
				break;
			case 30:
				BadgeMethods::UpdateBadge30();
				break;
			case 31:
				BadgeMethods::UpdateBadge31();
				break;
			case 32:
				BadgeMethods::UpdateBadge32();
				break;
			case 33:
				BadgeMethods::UpdateBadge33();
				break;
			case 34:
				BadgeMethods::UpdateBadge34();
				break;
			case 46:
				BadgeMethods::UpdateBadge46();
				break;
		}
		$datetime = date("Y-m-d H-i-s");
		$Query = "UPDATE tbl_badge_application SET Last_Update = '$datetime' WHERE (BadgeID = '$BadgeID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());		
	}
	
	function UpdateBadge1()	
	{
		// Implemented In AssignMemberBadgesOnComment
	}
	
	function UpdateBadge2()	
	{
		// Implemented In AssignMemberBadgesOnComment
	}
	
	function UpdateBadge3($MemberID)	
	{
		// ************* Comment on 30 different stories within 24 hours *************//
		$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL 1 DAY)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 30)
		{
			BadgeMethods::AssignBadge(3, $MemberID);
		}
	}
	
	function UpdateBadge4()	
	{
		// Implemented In AssignMemberBadgesOnComment
	}
	
	function UpdateBadge5()	
	{
		// Implemented In AssignMemberBadgesOnComment
	}
	
	function UpdateBadge6()	
	{
		// ************* The person in a persons friend list with the most badges *************//
		$Query = "SELECT COUNT(DISTINCT MemberID) AS Count, MemberID FROM tbl_member_badge";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$MemberID = $row['MemberID'];
			BadgeMethods::RemoveBadge(6);
			BadgeMethods::AssignBadge(6, $MemberID);
		}
	}
	
	function UpdateBadge7($MemberID)	
	{
		// ************* 7 people trust you on anything *************//
		$Query = "SELECT COUNT(TrustID) AS Count FROM tbl_trust WHERE (FriendsID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 12)
		{
			BadgeMethods::AssignBadge(7, $MemberID);
		}
	}
	
	function UpdateBadge8($MemberID)	
	{
		// ************* Comment with one word 5 times *************//
		/*$Query = "SELECT COUNT(TrustID) AS Count FROM tbl_trust WHERE (MemberID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 5)
		{
			BadgeMethods::AssignBadge(8, $MemberID);
		}*/
	}
	
	function UpdateBadge9($MemberID)	
	{
		// ************* Bragged to 15 different friends *************//
		$Query = "SELECT COUNT(DISTINCT a.MemberID) AS Count 
				FROM tbl_notifications_badge_brag as a 
				INNER JOIN tbl_notifications b ON a.NotificationID = b.NotificationID
				WHERE (a.MemberID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 35)
		{
			BadgeMethods::AssignBadge(9, $MemberID);
		}
	}
	
	function UpdateBadge10($MemberID)	
	{
		// ************* Comment on 50 stories which get over 700 comments *************//
		$Query = "SELECT DISTINCT StoryID FROM tbl_comments WHERE (MemberID = '$MemberID') GROUP BY StoryID HAVING COUNT(CommentID) >= 700";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		if(mysql_num_rows($QueryResult) > 70)
		{
			BadgeMethods::AssignBadge(10, $MemberID);
		}
	}
	
	function UpdateBadge11($MemberID, $StoryID)	
	{
		// ************* 30 people trust you on a specific category *************//
		$CategoryID = HelpingDBMethods::GetStoryCategoryID($StoryID);
		$Query = "SELECT COUNT(TrustID) AS Count FROM tbl_trust WHERE (FriendsID = '$MemberID') AND (CategoryID = '$CategoryID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 30)
		{
			BadgeMethods::AssignBadge(11, $MemberID);
		}
	}
	
	function UpdateBadge12($MemberID, $StoryID)	
	{
		// ************* 15 Geniuses trust you on a specific topic/category *************//
		$BadgeIDGenius = 11;
		$CategoryID = HelpingDBMethods::GetStoryCategoryID($StoryID);
		$Query = "SELECT COUNT(t.TrustID) AS Count 
				FROM tbl_trust t
				INNER JOIN tbl_member_badge b ON t.MemberID = b.MemberID
				WHERE (t.FriendsID = '$MemberID') AND (t.CategoryID = '$CategoryID') AND (b.BadgeID = '$BadgeIDGenius')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 15)
		{
			BadgeMethods::AssignBadge(12, $MemberID);
		}
	}
	
	function UpdateBadge13()	
	{
		// ************* The person in a persons friend list with the most trusts in Tech category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('tech', 13);
	}
	
	function UpdateBadge14()	
	{
		// ************* The person in a persons friend list with the most trusts in Skiing category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('skiing', 14);
	}
	
	function UpdateBadge15()	
	{
		// ************* The person in a persons friend list with the most trusts in Gaming category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('gaming', 15);
	}
	
	function UpdateBadge16()	
	{
		// ************* The person in a persons friend list with the most trusts in poker category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('poker', 16);
	}
	
	function UpdateBadge17()	
	{
		// ************* The person in a persons friend list with the most trusts in finance category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('finance', 17);
	}
	
	function UpdateBadge18()	
	{
		// ************* The person in a persons friend list with the most trusts in photography category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('photography', 18);
	}
	
	function UpdateBadge19()	
	{
		// ************* The person in a persons friend list with the most trusts in Apple category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('Apple', 19);
	}
	
	function UpdateBadge20()	
	{
		// ************* The person in a persons friend list with the most trusts in football category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('football', 20);
	}
	
	function UpdateBadge21()	
	{
		// ************* The person in a persons friend list with the most trusts in baseball category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('baseball', 21);
	}
	
	function UpdateBadge22()	
	{
		// ************* The person in a persons friend list with the most trusts in soccer category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('soccer', 22);
	}
	
	function UpdateBadge23()	
	{
		// ************* The person in a persons friend list with the most trusts in gossip category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('gossip', 23);
	}
	
	function UpdateBadge24()	
	{
		// ************* The person in a persons friend list with the most trusts in music category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('music', 24);
	}
	
	function UpdateBadge25()	
	{
		// ************* The person in a persons friend list with the most trusts in politics category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('politics', 25);
	}
	
	function UpdateBadge26()	
	{
		// ************* The person in a persons friend list with the most trusts in green category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('green', 26);
	}
	
	function UpdateBadge27()	
	{
		// ************* The person in a persons friend list with the most trusts in sports category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('sports', 27);
	}
	
	function UpdateBadge28()	
	{
		// ************* The person in a persons friend list with the most trusts in health category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('health', 28);
	}
	
	function UpdateBadge29()	
	{
		// ************* The person in a persons friend list with the most trusts in basketball category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('basketball', 29);
	}
	
	function UpdateBadge30()	
	{
		// ************* The person in a persons friend list with the most trusts in education category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('education', 30);
	}
	
	function UpdateBadge31()	
	{
		// ************* The person in a persons friend list with the most trusts in movies category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('movies', 31);
	}
	
	function UpdateBadge32()	
	{
		// ************* The person in a persons friend list with the most trusts in journalism category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('journalism', 32);
	}
	
	function UpdateBadge33()	
	{
		// ************* The person in a persons friend list with the most trusts in business category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('business', 33);
	}
	
	function UpdateBadge34()	
	{
		// ************* The person in a persons friend list with the most trusts in fashion category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('fashion', 38);
	}
	
	function UpdateBadge35($MemberID)	
	{
		// ************* Trust 7 people *************//
		$Query = "SELECT COUNT(TrustID) AS Count FROM tbl_trust WHERE (MemberID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 7)
		{
			BadgeMethods::AssignBadge(35, $MemberID);
			BadgeMethods::UpdateBadge36($result);
		}
	}
	
	function UpdateBadge36($count)	
	{
		// ************* Trust 14 people *************//
		if($count >= 14)
		{
			BadgeMethods::AssignBadge(36, $MemberID);
			BadgeMethods::UpdateBadge37($count);
		}
	}
	
	function UpdateBadge37($result)	
	{
		// ************* Trust 56 people *************//
		if($count >= 56)
		{
			BadgeMethods::AssignBadge(37, $MemberID);
		}
	}
	
	function UpdateBadge38()	
	{
		// ************* The person in a persons friend list with the most trusts in fashion category *************//		
		BadgeMethods::UpdateCategoryRelatedBadge('fashion', 38);
	}
	
	function UpdateBadge39($MemberID)	
	{
		// ************* Commented on a story after 2am EST *************//
		$time = time() - (5*60*60);
		$hrz = date("G", $time);
		if($hrz >= 2 && $hrz <= 6 )
		{
			BadgeMethods::AssignBadge(39, $MemberID);
		}
	}
	
	function UpdateBadge40($MemberID)	
	{
		// ************* Marked 5 stories as good *************//
		$Query = "SELECT COUNT(LikeID) AS Count FROM tbl_story_like WHERE (MemberID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 5)
		{
			BadgeMethods::AssignBadge(40, $MemberID);
			BadgeMethods::UpdateBadge41($result);
		}
	}
	
	function UpdateBadge41($count)	
	{
		// ************* Marked 70 Stories as good *************//
		if($count >= 70)
		{
			BadgeMethods::AssignBadge(41, $MemberID);
			BadgeMethods::UpdateBadge42($count);
		}
	}
	
	function UpdateBadge42($count)	
	{
		// ************* Marked 400 Stories as good *************//
		if($count >= 400)
		{
			BadgeMethods::AssignBadge(42, $MemberID);
			BadgeMethods::UpdateBadge43($count);
		}
	}
	
	function UpdateBadge43($count)	
	{
		// ************* Marked 150 Stories as good *************//
		if($count >= 800)
		{
			BadgeMethods::AssignBadge(43, $MemberID);
		}
	}
	
	function UpdateBadge44()	
	{
		// Implemented In gen.AddmultipleFriends() // Invite 5 Friends to Connichiwah
	}
	
	function UpdateBadge45($MemberID)	
	{
		// ************* Commented on 50 stories within the first 24 hours of joining *************//
		$Query = "SELECT DateTime FROM tbl_member WHERE (MemberID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$joiningTime = $row['DateTime'];
		}
		$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time < '$joiningTime' + INTERVAL 1 DAY) AND (Date_Time > '$joiningTime')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result > 50)
		{
			BadgeMethods::AssignBadge(45, $MemberID);
		}
	}
	
	function UpdateBadge46()	
	{
		// ************* Most comments on a single domain *************//
	}
	
	function UpdateBadge47($MemberID)	
	{
		// ************* Commented on 5 stories marked with Travel *************//
		$TagID = HelpingDBMethods::GetTagID('travel');
		$Query = "SELECT COUNT(DISTINCT st.StoryID) AS Count 
				FROM tbl_story_tags st
				INNER JOIN  tbl_comments c ON st.StoryID = c.StoryID					
				WHERE (st.TagID = '$TagID') AND (c.MemberID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 5)
			{
				BadgeMethods::AssignBadge(47, $MemberID);
			}			
		}
	}
	
	function UpdateBadge48()	
	{
		// ************* Commented on 15 stories *************//
		// Implemented In AssignMemberBadgesOnComment
	}
	
	function UpdateBadge49($MemberID)	
	{
		// ************* Have 40 sources of a different gender ************* //
		// ************* Not Implemented with Gender *********************** //
		$noOfFriends = HelpingDBMethods::GetNoOfFriends($MemberID);
		if($noOfFriends >= 40)
		{
			BadgeMethods::AssignBadge(49, $MemberID);
		}
	}
	
	function UpdateBadge50($MemberID)	
	{
		// ************* Commented on 70 stories tagged GOP, Republican, Tea Party, or Christine O'Donnell *************//
		$TagID1 = HelpingDBMethods::GetTagID('GOP');
		$TagID2 = HelpingDBMethods::GetTagID('Republican');
		$TagID3 = HelpingDBMethods::GetTagID('Tea Party');
		$TagID4 = HelpingDBMethods::GetTagID("Christine O\'Donnell");
		
		$Query = "SELECT COUNT(DISTINCT st.StoryID) AS Count 
				FROM tbl_story_tags st
				INNER JOIN  tbl_comments c ON st.StoryID = c.StoryID					
				WHERE (c.MemberID = '$MemberID') AND (st.TagID = '$TagID1') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID2') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID3') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID4')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 70)
			{
				BadgeMethods::AssignBadge(50, $MemberID);
			}			
		}
	}
	
	function UpdateBadge51($MemberID)	
	{
		// ************* Commented on 3 stories tagged as sleep, bed, or mattress *************//
		$TagID1 = HelpingDBMethods::GetTagID('sleep');
		$TagID2 = HelpingDBMethods::GetTagID('bed');
		$TagID3 = HelpingDBMethods::GetTagID('mattress');
		
		$Query = "SELECT COUNT(DISTINCT st.StoryID) AS Count 
				FROM tbl_story_tags st
				INNER JOIN  tbl_comments c ON st.StoryID = c.StoryID					
				WHERE (c.MemberID = '$MemberID') AND (st.TagID = '$TagID1') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID2') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID3')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 3)
			{
				BadgeMethods::AssignBadge(51, $MemberID);
			}			
		}
	}
	
	function UpdateBadge52($MemberID)	
	{
		// ************* Commented on 7 stories tagged with beer, wine, or alcohol *************//
		$TagID1 = HelpingDBMethods::GetTagID('beer');
		$TagID2 = HelpingDBMethods::GetTagID('wine');
		$TagID3 = HelpingDBMethods::GetTagID('alcohol');
		
		$Query = "SELECT COUNT(DISTINCT st.StoryID) AS Count 
				FROM tbl_story_tags st
				INNER JOIN  tbl_comments c ON st.StoryID = c.StoryID					
				WHERE (c.MemberID = '$MemberID') AND (st.TagID = '$TagID1') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID2') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID3')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 7)
			{
				BadgeMethods::AssignBadge(52, $MemberID);
			}			
		}
	}
	
	function UpdateBadge53($MemberID)	
	{
		// ************* Commented on at least 70 stories each month for the past 2 months *************//
		$isEligible = false;
		$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL 1 MONTH)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 70)
			{
				$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL 2 MONTH) AND (Date_Time < NOW() - INTERVAL 1 MONTH)";
				$QueryResult =  mysql_query($Query)or die(mysql_error());
				$row = mysql_fetch_array($QueryResult);
				if($row!=false)
				{
					$result = $row['Count'];
					if($result >= 70)
					{
						$isEligible = true;
					}
				}
			}
		}
		if($isEligible)
		{
			BadgeMethods::AssignBadge(53, $MemberID);
		}
	}
	
	function UpdateBadge54($MemberID)	
	{
		// ************* Commented on at least 300 stories each month for the past 6 months *************//
		$isEligible = false;
		$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL 1 MONTH)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 305)
			{
				$isEligible = true;
				for($i = 2; $i <= 5; $i++)
				{
					if($isEligible)
					{
						$j = $i - 1;
						$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL $i MONTH) AND (Date_Time < NOW() - INTERVAL $j MONTH)";
						$QueryResult =  mysql_query($Query)or die(mysql_error());
						$row = mysql_fetch_array($QueryResult);
						if($row!=false)
						{
							$result = $row['Count'];
							if($result >= 300)
							{
								$isEligible = true;
							}
							else
							{
								$isEligible = false;
							}
						}
					}					
				}
				
			}
		}
		if($isEligible)
		{
			BadgeMethods::AssignBadge(54, $MemberID);
		}
	}
	
	function UpdateBadge55($MemberID)	
	{
		// ************* Commented on at least 40 stories each month for the past year *************//
		$isEligible = false;
		$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL 1 MONTH)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 900)
			{
				$isEligible = true;
				for($i = 2; $i <= 11; $i++)
				{
					if($isEligible)
					{
						$j = $i - 1;
						$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL $i MONTH) AND (Date_Time < NOW() - INTERVAL $j MONTH)";
						$QueryResult =  mysql_query($Query)or die(mysql_error());
						$row = mysql_fetch_array($QueryResult);
						if($row!=false)
						{
							$result = $row['Count'];
							if($result >= 900)
							{
								$isEligible = true;
							}
							else
							{
								$isEligible = false;
							}
						}
					}					
				}
				
			}
		}
		if($isEligible)
		{
			BadgeMethods::AssignBadge(55, $MemberID);
		}
	}
	
	function UpdateBadge56($MemberID)	
	{
		// ************* Commented on 30 stories tagged with Bieber or Justin Bieber *************//
		$TagID1 = HelpingDBMethods::GetTagID('Bieber');
		$TagID2 = HelpingDBMethods::GetTagID('Justin Bieber');
		
		$Query = "SELECT COUNT(DISTINCT st.StoryID) AS Count 
				FROM tbl_story_tags st
				INNER JOIN  tbl_comments c ON st.StoryID = c.StoryID					
				WHERE (c.MemberID = '$MemberID') AND (st.TagID = '$TagID1') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID2')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 30)
			{
				BadgeMethods::AssignBadge(56, $MemberID);
			}			
		}
	}
	
	function UpdateBadge57($MemberID)	
	{
		// ************* Commented on a story after 2am EST *************//
		$time = time() - (5*60*60);
		$hrz = date("G", $time);
		$mins = date("i", $time);
		$isLess = ($hrz < 11 && $mins <= 30)? true: false;
		if($isLess && $hrz > 6)
		{
			BadgeMethods::AssignBadge(57, $MemberID);
		}
	}
	
	function UpdateBadge58()	
	{
		// ************* Lost a badge to one of your friends who you bragged to about getting that badge ************* //
		// ************* Not Implemented ***************************************************************************** //
	}
	
	function UpdateBadge59($MemberID)	
	{
		// ************* Commented on 17 stories tagged keyboard or typing *************//
		$TagID1 = HelpingDBMethods::GetTagID('keyboard');
		$TagID2 = HelpingDBMethods::GetTagID('typing');
		
		$Query = "SELECT COUNT(DISTINCT st.StoryID) AS Count 
				FROM tbl_story_tags st
				INNER JOIN  tbl_comments c ON st.StoryID = c.StoryID					
				WHERE (c.MemberID = '$MemberID') AND (st.TagID = '$TagID1') OR
				(c.MemberID = '$MemberID') AND (st.TagID = '$TagID2')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
			if($result >= 17)
			{
				BadgeMethods::AssignBadge(59, $MemberID);
			}			
		}
	}
	
	function UpdateBadge60($MemberID)	
	{
		// ************* Commented on 32 stories within 7 minutes of one another *************//
		$Query = "SELECT COUNT(DISTINCT StoryID) AS Count FROM tbl_comments WHERE (MemberID = '$MemberID') AND (Date_Time > NOW() - INTERVAL 12 MINUTE)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		if($result >= 32)
		{
			BadgeMethods::AssignBadge(60, $MemberID);
		}
	}
	
	private function UpdateCategoryRelatedBadge($CategoryName, $BadgeID)
	{
		// ************* The person in a persons friend list with the most trusts in fashion category *************//
		$CategoryID = HelpingDBMethods::GetCategoryID($CategoryName);
		$Query = "SELECT COUNT(FriendsID) AS Count, FriendsID FROM tbl_trust
				WHERE CategoryID = '$CategoryID'
				GROUP BY FriendsID
				ORDER BY Count DESC
				LIMIT 0, 1";//"SELECT COUNT(FriendsID) AS Count, FriendsID FROM tbl_trust WHERE (CategoryID = '$CategoryID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$MemberID = $row['FriendsID'];
			BadgeMethods::RemoveBadge($BadgeID);
			BadgeMethods::AssignBadge($BadgeID, $MemberID);
		}
	}
}