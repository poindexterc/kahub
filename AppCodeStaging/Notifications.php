<?php
require_once 'MemberDBMethods.php';
require_once 'MyMailingMethods.php';
class Notifications
{

	
	function GetNoOfNotifications($MemberID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(NotificationID) AS Count FROM tbl_notifications WHERE (AddressedTo = '$MemberID') AND (Viewed <> 1)";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	
	}
	

	
	function GetNoOfNeBadges($MemberID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(NotificationID) AS Count FROM tbl_notifications WHERE (AddressedTo = '$MemberID') AND (Viewed <> 1) AND (NotificationType = 4)";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	
	function SetNotificationStatus($MemberID, $NID = false, $status = false)
	{
		$Query = '';
		if($MemberID > 0 && $NID == false && $status == false)
		{
			$Query = "UPDATE tbl_notifications SET Viewed = 1 WHERE (AddressedTo = '$MemberID') AND (Viewed <> 1)";
		}
		elseif($MemberID > 0 && $NID > 0 && $status == 1)
		{
			$Query = "UPDATE tbl_notifications SET Viewed = 1 WHERE (AddressedTo = '$MemberID') AND (NotificationID = $NID)";
		}
		if($Query != '')
		{
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}	
	}
	
	function GetNewNotifications($MemberID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications WHERE (AddressedTo = '$MemberID') AND (Viewed<>1) ORDER BY DateTime DESC";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$NID = $row['NotificationID'];
			$NType = $row['NotificationType'];
			if($NType == 1)
			{
				$result .= Notifications::GetReplyOnCommentNotification($NID);
			}
			elseif($NType == 2)
			{
				$result .= Notifications::GetFriendRequestNotification($NID);
			}
			elseif($NType == 3)
			{
				$result .= Notifications::GetFriendRequestAcceptedNotification($NID);
			}
			elseif($NType == 4)
			{
				$result .= Notifications::GetBadgeRecievedNotification($NID);
			}
			elseif($NType == 5)
			{
				$result .= Notifications::GetFriendSharedSomthingNotification($NID);
			}
			elseif($NType == 6)
			{
				$result .= Notifications::GetBragToFriendNotification($NID);
			}
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	function GetOldNotifications($MemberID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications WHERE (AddressedTo = '$MemberID') AND (Viewed=1) ORDER BY DateTime DESC LIMIT 0,5";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$NID = $row['NotificationID'];
			$NType = $row['NotificationType'];
			if($NType == 1)
			{
				$result .= Notifications::GetReplyOnCommentNotification($NID);
			}
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}

	
	function InsertNotification($NType, $data)
	{
		$Query = "INSERT INTO tbl_notifications (NotificationType, AddressedTo) VALUES  ('" . $NType . "', '" . $data['AddressedTo'] . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$NID = mysql_insert_id();
		if($NType == 1)
		{
			$Query = "INSERT INTO tbl_notifications_reply_comment (NotificationID, MemberID, StoryID, CommentID) VALUES  ('" . $NID . "', '" . $data['ActionBy'] . "', '" . $data['StoryID'] . "', '" . $data['CommentID'] . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
		elseif($NType == 2)
		{
			$Query = "INSERT INTO tbl_notifications_friend_request (NotificationID, MemberID) VALUES  ('" . $NID . "', '" . $data['ActionBy'] . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
		elseif($NType == 3)
		{
			$Query = "INSERT INTO tbl_notifications_friend_request_accepted (NotificationID, MemberID) VALUES  ('" . $NID . "', '" . $data['ActionBy'] . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
		elseif($NType == 4)
		{
			$Query = "INSERT INTO tbl_notifications_badge (NotificationID, BadgeID) VALUES  ('" . $NID . "', '" . $data['BadgeID'] . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			//$data['BadgeID'] = mysql_insert_id();
		}
		elseif($NType == 5)
		{
			$Query = "INSERT INTO tbl_notifications_share (NotificationID, MemberID, StoryID) VALUES  ('" . $NID . "', '" . $data['ActionBy'] . "', '" . $data['StoryID'] . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
		elseif($NType == 6)
		{
			$Query = "INSERT INTO tbl_notifications_badge_brag (NotificationID, MemberID, BadgeID) VALUES  ('" . $NID . "', '" . $data['ActionBy'] . "', '" . $data['BadgeID'] . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
		$unsub = Notifications::GetUnsubscribe($NType);
		if ($unsub=="false"){
			$mail = MyMailingMethods::SendNotificationMail($NType, $data);
			error_log($mail);
		} else {
			error_log("not sent");
		}
	}
	
	function SendNotificationToNetwork($MemberID, $StoryID)
	{
		$Query = "SELECT a.MemberID_Passive AS myFriendID 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
					WHERE (a.MemberID_Active =  '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$friendID = $row['myFriendID'];
			$data = array("AddressedTo" => $friendID, "ActionBy" => $MemberID, "StoryID" => $StoryID);
			Notifications::InsertNotification(5, $data);
			$row = mysql_fetch_array($QueryResult);
		}
	}
	
	private function GetReplyOnCommentNotification($NID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications_reply_comment WHERE (NotificationID = '$NID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$ActionBy = $row['MemberID'];
			$StoryID = $row['StoryID'];
			$commentID = $row['CommentID'];
			$imageID = HelpingDBMethods::GetMemberImageID($ActionBy);
			$commentData = HelpingDBMethods::GetCommentData($commentID);
			$storyData = HelpingDBMethods::GetStoryData($commentData['c-StoryID']);
			$StoryURL = HelpingDBMethods::GetStoryURL($StoryID);
			$MemberName = MemberDBMethods::GetUserName($ActionBy);
			$result = '<li class = "notification-reply" onClick="NotificationStatus(' . $NID . ');">
								<a href="http://www.kahub.com/l/comments?c='.$commentID.'" class="notifyhref"><img class = "notif-prof" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"alt = "" onerror="this.src=\'http://www.kahub.com/member/placeholderImageSmall.png\'"/><strong class = "heavy">' . $MemberName . '</strong> <span style="color: grey">replied to your comment on </span> '.HelpingMethods::GetLimitedText($storyData['s-title'], 32).'
								<br/>
								<div class = "cl"></div>
					   </a></li>';
		}
		
		return $result;
	}
	
	private function GetFriendRequestNotification($NID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications_friend_request WHERE (NotificationID = '$NID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$ActionBy = $row['MemberID'];
			$imageID = HelpingDBMethods::GetMemberImageID($ActionBy);
			
			$imageID = HelpingDBMethods::GetMemberImageID($ActionBy);
			$MemberName = MemberDBMethods::GetUserName($ActionBy);
			$result = '<li class = "notification-add-friend-request" onMouseOver="NotificationStatus(' . $NID . ');">
							<img class = "notif-prof" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\'"/><strong class = "heavy">' . $MemberName . '</strong> has requested to add you as a source.
							<br/>
							<div style = "height:25px;" id = "c-' . $NID . '">
								<div class="notifyWrap">
								<a class = "request addFriend notification-blue-btn" onClick = "AcceptFriendRequest(' . $ActionBy . ', ' . $NID . ')" onclick = "NotificationStatus(' . $NID . ')">Accept</a><a class = "request ignoreFriend notification-blue-btn" onClick = "IgnoreFriendRequest(' . $ActionBy . ', ' . $NID . ')" onclick = "NotificationStatus(' . $NID . ')">Ignore</a></div>									
								<div class = "cl"></div>
							</div>
							<div class = "cl"></div>
					   </li>';
		}
		
		return $result;
	}
	
	private function GetFriendRequestAcceptedNotification($NID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications_friend_request_accepted WHERE (NotificationID = '$NID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$ActionBy = $row['MemberID'];
			$imageID = HelpingDBMethods::GetMemberImageID($ActionBy);
			
			$MemberName = MemberDBMethods::GetUserName($ActionBy);
			$result = '<li class = "notification-add-friend-request-accepted" onMouseOver="NotificationStatus(' . $NID . ')"><a href = "http://www.kahub.com/l/profile.php?user=' . $ActionBy . '">
								<img class = "notif-prof" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\'"/><strong class = "heavy">' . $MemberName . '</strong> has accepted your friend request
								<br/>
								<div class = "cl"></div>
					   </a></li>';
		}
		
		return $result;
	}
	
	private function GetBadgeRecievedNotification($NID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications_badge WHERE (NotificationID = '$NID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		
		if($row!=false)
		{
			$BadgeName = HelpingDBMethods::GetBadgeName($row['BadgeID']);
			$result =  '<li class = "notification-badge">
						<div class="cross-hatch" onclick = "NotificationStatus(' . $NID . ')"><a class="cross">&#215;</a></div><div class="badge-got"><a class="badge-link" href = "javascript:BragMyBadgeHTML(' . $row['BadgeID'] . ')" onclick = "NotificationStatus(' . $NID . ')">Congrats! You\'ve unlocked the ' . $BadgeName . ' badge!</a>
							<br/>
							</div>
							<div class = "cl"></div>
						</li>';
		}
		
		return $result;
	}
	
	private function GetFriendSharedSomthingNotification($NID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications_share WHERE (NotificationID = '$NID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$ActionBy = $row['MemberID'];
			$StoryID = $row['StoryID'];
			$imageID = HelpingDBMethods::GetMemberImageID($ActionBy);
			$StoryURL = HelpingDBMethods::GetStoryURL($StoryID);
			$MemberName = MemberDBMethods::GetUserName($ActionBy);
			$result = '<li class = "notification-share">
								<img class = "notif-prof" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"alt = "" onerror="this.src=\'http://www.kahub.com/member/placeholderImageSmall.png\'"/><strong class = "heavy">' . $MemberName . '</strong> has shared something with you!
								<br/>
								<div style = "height:25px;"><a class = "notification-blue-btn" href = "http://www.kahub.com/anyShare/index.php?ref=personal_share&rand=0&rURL=' . $StoryURL . '" onclick = "NotificationStatus(' . $NID . ')" target = "_blank">See It</a></div>
								<div class = "cl"></div>
					   </li>';
		}
		
		return $result;
	}
	
	private function GetBragToFriendNotification($NID)
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_notifications_badge_brag WHERE (NotificationID = '$NID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$BadgeName = HelpingDBMethods::GetBadgeName($row['BadgeID']);
			$ActionBy = $row['MemberID'];
			$imageID = HelpingDBMethods::GetMemberImageID($ActionBy);
			
			$MemberName = MemberDBMethods::GetUserName($ActionBy);
			$result =  '<li class = "notification-badge">
							<img class = "notif-prof" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"alt = "" onerror="this.src=\'http://www.kahub.com/member/placeholderImageSmall.png\'"/>' . $MemberName . ' has unlocked the ' . $BadgeName . ' badge, and wanted you to know about it.
							<br/>
							<div style = "height:25px;"><a style = "width:145px;" class = "notification-blue-btn" href = "' . Settings::GetRootURL() . 'member/activity.php?id=' . $ActionBy . '" onclick = "NotificationStatus(' . $NID . ')" target = "_blank">See what they\'re up to</a></div>
							<div class = "cl"></div>
						</li>';
		}
		
		return $result;
	}
	
	private function GetUnsubscribe($NID)
	{
		$MemberID = $GLOBALS['user']->userID;	
		$result = "false"; 
		$Query = "SELECT * FROM tbl_unsubscribe WHERE (UnsubscribeType = '$NID') AND (MemberID = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result =  "true";
		} else {
			$result = "false";
		}
		return $result;
	}
}
?>