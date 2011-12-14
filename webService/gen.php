<?php
require_once '../AppCode/access.class.php';
$user = new flexibleAccess();
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/MyMailingMethods.php';
//require_once '../AppCode/CommentsMethods.php';
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/SideBarScript.php';
require_once '../AppCode/BadgeMethods.php';

if(isset($_GET['method']) && ($_GET['method'] != ""))
{	
	$MethodName = $_GET['method'];
	if($MethodName == "hello")
	{
		echo myWebservice::hello();
	}
	elseif($MethodName == "GetUserNameSuggestions")
	{
		$txt = $_POST['txt'];
		echo myWebservice::GetUserNameSuggestions($txt);
	}
	elseif($MethodName == "insertNewStoryBody")
	{
			$storyBody = $_POST['story'];
			$url = $_POST['url'];
			echo myWebservice::insertStoryBody($storyBody, $url);
		
	}
	elseif($MethodName == "checkUser")
	{
			$handle = $_POST['handle'];
			echo myWebservice::checkUser($handle);
		
	}
	elseif($MethodName == "saveHandle")
	{
			$handle = $_POST['handle'];
			echo myWebservice::saveHandle($handle);
		
	}
	elseif($MethodName == "AddFriend")
	{
		if($user->is_loaded())
		{ 
			$friendID = $_POST['friendID'];
			echo myWebservice::AddFriend($friendID);
		}
		else
		{
			echo 'You Are Not Loged In.';
		}
	}
	elseif($MethodName == "followhub")
	{
		if($user->is_loaded())
		{ 
			$friendID = $_POST['friendID'];
			echo myWebservice::followhub($friendID);
		}
		else
		{
			echo 'You Are Not Loged In.';
		}
	}
	elseif($MethodName == "unfollowhub")
	{
		if($user->is_loaded())
		{ 
			$friendID = $_POST['friendID'];
			echo myWebservice::unfollowhub($friendID);
		}
		else
		{
			echo 'You Are Not Loged In.';
		}
	}
	elseif($MethodName == "AddMultipleFriends")
	{
		if($user->is_loaded())
		{ 
			$data = $_POST['data'];
			echo myWebservice::AddMultipleFriends($data);
		}
		else
		{
			echo 'You Are Not Loged In.';
		}
	}
	elseif($MethodName == "AddFacebookFriends")
	{
		if($user->is_loaded())
		{ 
			$data = $_POST['data'];
			echo 'request Recieved.';
			echo myWebservice::AddFacebookFriends($data);
		}
		else
		{
			echo 'You Are Not Loged In.';
		}
	}
	elseif($MethodName == "GetMoreStories")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$limit = $_POST['limit'];
			$offset = $_POST['offset'];
			$view = $_POST['viewtype'];
			echo myWebservice::GetMoreStories($offset, $limit, $view);
		}
	}
	elseif($MethodName == "GetMoreBadges")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$limit = $_POST['limit'];
			$offset = $_POST['offset'];
			echo myWebservice::GetMoreBadges($offset, $limit, $userID);
		}
	}
	elseif($MethodName == "GetNotifications")
	{
		$type = $_POST['type'];
		echo myWebservice::GetNotifications($type);
	}
	elseif($MethodName == "pinComment")
	{
		$commentID = $_POST['commentID'];
		$hubID = $_POST['hubID'];
		echo myWebservice::pinComment($commentID, $hubID);
	}
	elseif($MethodName == "unpinComment")
	{
		$commentID = $_POST['commentID'];
		$hubID = $_POST['hubID'];
		echo myWebservice::unpinComment($commentID, $hubID);
	}
	elseif($MethodName == "LikeStory")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$StoryID = $_POST['storyid'];
			echo myWebservice::LikeStory($StoryID, $userID);
		}
	}
	elseif($MethodName == "RestateComment")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$commentID = $_POST['commentID'];
			echo myWebservice::RestateComment($commentID, $userID);
		}
	}
	elseif($MethodName == "inlineReply")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$commentID = $_POST['commentID'];
			$comment = $_POST['comment'];
			echo myWebservice::inlineReply($commentID, $comment, $userID);
		}
	}
	elseif($MethodName == "PostStory")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$storyID = $_POST['storyID'];
			$comment = $_POST['comment'];
			echo myWebservice::PostStory($storyID, $comment, $userID);
		}
	}
	elseif($MethodName == "PostStoryHub")
	{
		if($user->is_loaded())
		{
			$MemberID = $user->userID;
			$storyID = $_POST['storyID'];
			$comment = $_POST['comment'];
			$userID = HelpingDBMethods::getCurrentHubID($MemberID);
			echo myWebservice::PostStory($storyID, $comment, $MemberID);
			echo myWebservice::PostStory($storyID, $comment, $userID);
		}
	}
	elseif($MethodName == "PostVideoHub")
	{
		if($user->is_loaded())
		{
			$MemberID = $user->userID;
			$storyID = $_POST['storyID'];
			$comment = $_POST['comment'];
			$userID = HelpingDBMethods::getCurrentHubID($MemberID);
			echo myWebservice::PostVideo($storyID, $comment, $MemberID);
			echo myWebservice::PostVideo($storyID, $comment, $userID);
		}
	}
	elseif($MethodName == "PostPhotoHub")
	{
		if($user->is_loaded())
		{
			$MemberID = $user->userID;
			$storyID = $_POST['storyID'];
			$comment = $_POST['comment'];
			$photo = $_POST['image'];
			$userID = HelpingDBMethods::getCurrentHubID($MemberID);
			echo myWebservice::PostPhoto($storyID, $comment, $MemberID, $photo);
			echo myWebservice::PostPhoto($storyID, $comment, $userID, $photo);
		}
	}
	elseif($MethodName == "PromoteStory")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$storyID = $_POST['storyID'];
			echo myWebservice::PromoteStory($storyID, $userID);
		}
	}
	elseif($MethodName == "StoryClick")
	{
		if($user->is_loaded())
		{
			$StoryID = $_POST['storyid'];
			echo myWebservice::StoryClick($StoryID);
		}
	}
	elseif($MethodName == "GetSearchSuggestions")
	{
		$txt = $_POST['txt'];
		echo myWebservice::GetSearchSuggestions($txt);
	}
	elseif($MethodName == "NotificationStatus")
	{
		if($user->is_loaded())
		{
			$NID = $_POST['NID'];
			echo myWebservice::NotificationStatus($user->userID, $NID);
		}
	}
	elseif($MethodName == "AcceptFriendRequest")
	{
		if($user->is_loaded())
		{
			$friendID = $_POST['memberID'];
			echo myWebservice::AcceptFriendRequest($friendID);
		}
	}
	elseif($MethodName == "IgnoreFriendRequest")
	{
		if($user->is_loaded())
		{
			$friendID = $_POST['memberID'];
			echo myWebservice::IgnoreFriendRequest($friendID);
		}
	}
	elseif($MethodName == "BragMyBadgeHTML")
	{
		if($user->is_loaded())
		{
			$BadgeID = $_POST['badgeid'];
			echo myWebservice::BragMyBadgeHTML($BadgeID);
		}
	}
	elseif($MethodName == "GetBragSuggestions")
	{
		if($user->is_loaded())
		{
			$txt = $_POST['txt'];
			echo myWebservice::GetBragSuggestions($txt);
		}
	}
	elseif($MethodName == "BragToMyFriend")
	{
		if($user->is_loaded())
		{
			$friendID = $_POST['fid'];
			$BadgeID = $_POST['bid'];
			echo myWebservice::BragToMyFriend($friendID, $BadgeID);
		}
	}
	elseif($MethodName == "GetStoryData")
	{
		$StoryID = $_POST['storyid'];
		echo myWebservice::GetStoryData($StoryID);
	}
	elseif($MethodName == "GetCategorySuggestions")
	{
		$txt = $_POST['txt'];
		$bNo = $_POST['bno'];
		echo myWebservice::GetCategorySuggestions($txt, $bNo);
	}
	else
	{
		echo "No Such Method Exists";
	}
}
else
{
	echo "<error>Method Name Must Be Specified</error>";
}

class myWebservice
{
	public static function hello()
	{
		/*$time = time() - (5*60*60);
		$hrz = date("G", $time);
		return $hrz;*/
		//return "Hello World !!! " . gmdate('Y-m-d H-i-s');
		/*return date('Y-m-d H-i-s', time() . '+1 day');*/
		$time = time() - (5*60*60);
		$hrz = date("G", $time);
		$mins = date("i", $time);
		$isLess = ($hrz < 11 && $mins <= 30)? true: false;
		if($isLess && $hrz > 6)
		{
			return 'sdg';
		}
		else
		{
			return 'Egf' . $hrz;
		}
		
	}
	
	function GetUserNameSuggestions($txt)
	{
		$txt = addslashes($txt);
		$suggestions = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$txt = mysql_real_escape_string($txt);
				if(strlen($txt) >0)
				{
					$CurrentMemberID = $GLOBALS['user']->userID;
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE (mFirst_Name LIKE '%$txt%') OR (mLast_Name LIKE '%$txt%') OR (mEmail  LIKE '%$txt%') LIMIT 10";
					$QueryResult = mysql_query($Query);
					while ($result = mysql_fetch_array($QueryResult))
					{
						if($CurrentMemberID != $result['MemberID'])
						{
							$suggestions .= '<li id = "user-name-suggestion-'. $result['MemberID'] . '" onClick="fill('. $result['MemberID'] . ');" >' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '</li>';
						}
					}					
				}
				else
				{
					// Dont do anything.
				}
			}
			mysql_close($DBConnection);
		}
		
		return 	$suggestions;
	}
	
	function AddFriend($friendID)
	{
		$result = '';
		if($friendID > 0)
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{
					$isMember = MemberDBMethods::isExistMemberByID($friendID);
					if($isMember)
					{
						$CurrentMemberID = $GLOBALS['user']->userID;
						$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
						$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
						if($isMyFriend && $isHisFriend)
						{
							$result = 'Already Friends';
						}				
						elseif($isMyFriend)
						{
							$result = 'Friend Request Pending';
						}
						else
						{
							HelpingDBMethods::AddFriend($CurrentMemberID, $friendID);
							$data = array("AddressedTo" => $friendID, "ActionBy" => $CurrentMemberID);
							Notifications::InsertNotification(2, $data);
							$result = 'Friend Request Sent';
						}
					}
					else
					{
						$result = 'Member Do not Exists';
					}
				}
				mysql_close($DBConnection);
			}
		}
		return $result;
	}
	
	function insertNewStoryBody($storyBody, $url){
		HelpingDBMethods::insertStoryBody($storyBody, $url);
	}
	function checkUser($handle){
		if($handle!=""){
			$result = MemberDBMethods::checkHandle($handle);
			return $result;
		}
		
	}
	function saveHandle($handle){
		if($handle!=""){
			$result = MemberDBMethods::saveHandle($handle);
			return $result;
		}
		
	}
	function followhub($friendID)
	{
		$result = '';
		if($friendID > 0)
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{
					$isMember = MemberDBMethods::isExistMemberByID($friendID);
					if($isMember)
					{
						$CurrentMemberID = $GLOBALS['user']->userID;
						$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
						$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
						if($isMyFriend && $isHisFriend)
						{
							$result = 'Already Following';
						}				
						elseif($isMyFriend)
						{
							$result = 'Friend Request Pending';
						}
						else
						{
							HelpingDBMethods::AddFriend($CurrentMemberID, $friendID);
							HelpingDBMethods::followhub($CurrentMemberID, $friendID);
							
							$result = 'Following!';
						}
					}
					else
					{
						$result = 'Member Do not Exists';
					}
				}
				mysql_close($DBConnection);
			}
		}
		return $result;
	}
	function unfollowhub($friendID)
	{
		$result = '';
		if($friendID > 0)
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{
					$isMember = MemberDBMethods::isExistMemberByID($friendID);
					if($isMember)
					{
						$CurrentMemberID = $GLOBALS['user']->userID;
						$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
						$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
						if($isMyFriend && $isHisFriend)
						{
							HelpingDBMethods::unfollowhub($CurrentMemberID, $friendID);
							$result = 'Yup, they\'re gone. Unfollowed.';
						}				
						elseif($isMyFriend)
						{
							$result = '...you already have requested to add this person as a friend. wait for a resposnse, you may be surprised.';
						}
						else
							
							$result = 'Not following yet... so... yea..';
						}
					}
					else
					{
						$result = 'Member does not exist';
					}
				}
				mysql_close($DBConnection);
			}
		
		return $result;
	}
	function AddMultipleFriends($data)
	{
		$result = '';
		$CountFriendsAdded = 0;
		$CountInvitations = 0;
		$CurrentMemberID = $GLOBALS['user']->userID;
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$items = explode(',', $data);
				foreach($items as $item)
				{
					if($item != '')
					{
						$MemberName = MemberDBMethods::GetUserName($CurrentMemberID);
						
						
						
						$itemData = explode(':', $item);
						$email = HelpingMethods::hexToStr($itemData[0]);
						$description = HelpingMethods::hexToStr($itemData[1]);
						$friendID = MemberDBMethods::GetMemberIDByUserName($email);
						if($friendID > 0)
						{
							$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
							$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
							if($isMyFriend && $isHisFriend)
							{
								$r = 'Already Friends';
							}				
							elseif($isMyFriend)
							{
								$r = 'Friend Request Pending';
							}
							else
							{
								HelpingDBMethods::AddFriend($CurrentMemberID, $friendID);
								$CountFriendsAdded ++;
								$data = array("AddressedTo" => $friendID, "ActionBy" => $CurrentMemberID);
								Notifications::InsertNotification(2, $data);
								$r = 'Friend Request Sent';
							}
						}
						
						else
						{
							$CountInvitations ++;
							// Send Invitation Email
							$to = $email;
							$from = "no-reply@connichiwah.com";
							$headers = "From: " . $MemberName . " <no-reply@connichiwah.com> \r\n";
							$title = HelpingDBMethods::mostRecentStory($CurrentMemberID);
							$subject=$MemberName . ' just shared something with you on connichiwah.';
							if ($title!="nostory"){
							$body = <<<Body
Hey,
{$MemberName} just shared something with you on connichiwah, because they trust you!

{$MemberName} just shared, {$title} with everyone, but before you see what they shared with you, you've got to join connichiwah

You can join connichiwah today by visiting http://www.conichiwah.com


---
This message was intended for {$to}.
You have received this message because your friend, {$MemberName}, has requested that we send you an invitation to join connichiwah.
Body;
						} else { 
							$body = <<<Body
Hey,
{$MemberName} just shared something with you on connichiwah, because they trust you!

But before you can see what they wanted you to see, you've got to join connichiwah. 

You can join connichiwah today by visiting http://www.conichiwah.com


---
This message was intended for {$to}.
You have received this message because your friend, {$MemberName}, has requested that we send you an invitation to join connichiwah.
Body;
	
						}
							$r = '';
							$isSent = MyMailingMethods::GeneralMail($to, $subject, $body, $headers, $r);
							/*if($isSent == true)
							{
								$r = 'Link Reported ... !!!';
							}
							else
							{
								$r = 'Reporting Failed, Try gain ... !!!';
							}*/
						}
					}
				}
			}
			mysql_close($DBConnection);
		}
		if($CountInvitations > 0)
		{
			BadgeMethods::AssignBadge(44, $MemberID); // invited friends to connichiwah
		}
		$result = $CountFriendsAdded . ' Friends Added and ' . $CountInvitations . ' Friends are invited.';
		return $result;
	}
	
	function AddFacebookFriends($data)
	{
		$result = '';
		$CountFriendsAdded = 0;
		$CountAlreadyFriends = 0;
		$CountFriendsRequestPending = 0;
		$CurrentMemberID = $GLOBALS['user']->userID;
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$items = explode(',', $data);
				foreach($items as $friendID)
				{
					if($friendID >0)
					{
						$MemberName = MemberDBMethods::GetUserName($CurrentMemberID);
						if($friendID > 0)
						{
							$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
							$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
							if($isMyFriend && $isHisFriend)
							{
								//$r = 'Already Friends';
								$CountAlreadyFriends++;
							}				
							elseif($isMyFriend)
							{
								//$r = 'Friend Request Pending';
								$CountFriendsRequestPending++;
							}
							else
							{
								HelpingDBMethods::AddFriend($CurrentMemberID, $friendID);
								$CountFriendsAdded ++;
								$data = array("AddressedTo" => $friendID, "ActionBy" => $CurrentMemberID);
								Notifications::InsertNotification(2, $data);
								//$r = 'Friend Request Sent';
							}
						}
						else
						{
							$CountInvitations ++;
							// Send Invitation Email
							$to = $email;
							$from = "no-reply@connichiwah.com";
							
							$headers = "From: " . $MemberName . " <noreply@connichiwah.com> \r\n";
							$title = HelpingDBMethods::mostRecentStory($CurrentMemberID);
							$subject=$MemberName . ' just shared something with you on connichiwah.';
							if ($title!="nostory"){
							$body = <<<Body
Hey,
{$MemberName} just shared something with you on connichiwah, because they trust you!

{$MemberName} just shared, {$title} with everyone, but before you see what they shared with you, you've got to join connichiwah

You can join connichiwah today by visiting http://www.conichiwah.com


---
This message was intended for {$to}.
You have received this message because your friend, {$MemberName}, has requested that we send you an invitation to join connichiwah.
Body;
							} else { 
							$body = <<<Body
Hey,
{$MemberName} just shared something with you on connichiwah, because they trust you!

But before you can see what they wanted you to see, you've got to join connichiwah. 

You can join connichiwah today by visiting http://www.conichiwah.com


---
This message was intended for {$to}.
You have received this message because your friend, {$MemberName}, has requested that we send you an invitation to join connichiwah.
Body;

							}
							$r = '';
							$isSent = MyMailingMethods::GeneralMail($to, $subject, $body, $headers, $r);
							/*if($isSent == true)
							{
								$r = 'Link Reported ... !!!';
							}
							else
							{
								$r = 'Reporting Failed, Try gain ... !!!';
							}*/
						}
					}
				}
			}
			mysql_close($DBConnection);
		}
		if($CountInvitations > 0)
		{
			BadgeMethods::AssignBadge(44, $MemberID); // invited friends to connichiwah
		}
		$result = $CountFriendsAdded . ' <b>Friends Added</b>, <br>' . $CountAlreadyFriends . ' <b>Friends are already friends</b> and <br>' . $CountFriendsRequestPending . ' <b>Friend Requests Pending.</b>';
		return $result;
	}
	
	function AcceptFriendRequest($friendID)
	{
		$result = '';
		if($friendID > 0)
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{
					$isMember = MemberDBMethods::isExistMemberByID($friendID);
					if($isMember)
					{
						$CurrentMemberID = $GLOBALS['user']->userID;
						$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
						$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
						if(!$isMyFriend && $isHisFriend)
						{
							HelpingDBMethods::AddFriend($CurrentMemberID, $friendID);
							$data = array("AddressedTo" => $friendID, "ActionBy" => $CurrentMemberID);
							Notifications::InsertNotification(3, $data);
							$result = 'Friend Added';
						}
					}
					else
					{
						$result = 'Member does not exist';
					}
				}
				mysql_close($DBConnection);
			}
		}
		return $result;
	}
	
	function IgnoreFriendRequest($friendID)
	{
		$result = '';
		if($friendID > 0)
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{
					$isMember = MemberDBMethods::isExistMemberByID($friendID);
					if($isMember)
					{
						$CurrentMemberID = $GLOBALS['user']->userID;
						$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
						$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
						if(!$isMyFriend && $isHisFriend)
						{
							HelpingDBMethods::IgnoreFriendRequest($CurrentMemberID, $friendID);
							///$data = array("AddressedTo" => $friendID, "ActionBy" => $CurrentMemberID);
							//Notifications::InsertNotification(3, $data);
							$result = 'Request Ignored';
						}
					}
					else
					{
						$result = 'Member does not exist';
					}
				}
				mysql_close($DBConnection);
			}
		}
		return $result;
	}
	
	function GetMoreStories($offset, $limit, $viewtype)
	{
		sleep(2);
		$result = '';
		$DBConnection = Settings::ConnectDB(); 	
		$CurrentMemberID = $GLOBALS['user']->userID;
			
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				if($viewtype="1"){
					$result = HelpingDBMethods::GetLatestStories($offset, $limit, $CurrentMemberID);
				}
				if($viewtype="0") {
					$result = HelpingDBMethods::GetLatestStoriesInteresting($offset, $limit, $CurrentMemberID);
				}
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	
	function GetMoreBadges($offset, $limit, $userID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$result = HelpingDBMethods::GetBadges($userID, 'tab', $limit, $offset);
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}

	function GetNotifications($type)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$result = SideBar::MemberProfileInformation($type, false);
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}	
	
	function LikeStory($StoryID, $userID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$result = HelpingDBMethods::LikeStory($StoryID, $userID);
				if($result > 0)
				{
					//////////////////////////////////////////////////////////////////////////////
					// To mark intresting we dont have any selected text, to post it as comment //
					// so there must be some thing else to do it....							//
					// Simply find the last comment on the page, and reply "Interesting"   		//
					//////////////////////////////////////////////////////////////////////////////
					$result = 'liked';
				}
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function RestateComment($commentID, $userID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					$result = HelpingDBMethods::restateStory($commentID, $userID);
					$commentData = HelpingDBMethods::GetCommentData($commentID);
					HelpingDBMethods::PostComments($commentData['c-StoryID'], $commentData['c-a-t'], 'Bump', $userID, $commentData['c-id']);
					$result = 'restated';
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function inlineReply($commentID, $comment, $userID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					$commentData = HelpingDBMethods::GetCommentData($commentID);
					$ReplyTo = $commentID;
					$AddressedTo = HelpingDBMethods::GetMemberIDByComment($commentID);
					$NewCommentID = HelpingDBMethods::PostComments($commentData['c-StoryID'], $commentData['c-a-t'], $comment , $userID, $commentData['c-id']);
					$data = array("AddressedTo" => $AddressedTo, "ActionBy" => $userID, "StoryID" => $commentData['c-StoryID'], "CommentID" => $NewCommentID);
					Notifications::InsertNotification(1, $data);
					$result = 'replied';
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function PostStory($storyID, $comment, $userID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					HelpingDBMethods::PostComments($storyID, "NULL", $comment , $userID, 0);
					$result = 'commented';
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function PostVideo($storyID, $comment, $userID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					HelpingDBMethods::PostVideo($storyID, "NULL", $comment , $userID, 0);
					$result = 'commented';
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function PostPhoto($storyID, $comment, $userID, $photo)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					HelpingDBMethods::PostPhoto($storyID, "NULL", $comment , $userID, $photo);
					$result = 'commented';
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function pinComment($commentID, $hubID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					HelpingDBMethods::pinComment($commentID, $hubID);
					$result = 'pinned';
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function unpinComment($commentID, $hubID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					HelpingDBMethods::unpinComment($commentID, $hubID);
					$result = 'unpinned';
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	function PromoteStory($storyID, $userID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
					$promoted = HelpingDBMethods::GetPromoted($storyID, $userID);
					if(!$promoted){
						$result = HelpingDBMethods::promoteStory($storyID, $userID);
						//////////////////////////////////////////////////////////////////////////////
						// To mark intresting we dont have any selected text, to post it as comment //
						// so there must be some thing else to do it....							//
						// Simply find the last comment on the page, and reply "Interesting"   		//
						//////////////////////////////////////////////////////////////////////////////
						HelpingDBMethods::PostComments($storyID, 'NULL', 'Promote', $userID, 0);
						$result = 'promoted';
					}
					
				
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	
	function StoryClick($StoryID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$result = HelpingDBMethods::StoryClick($StoryID);				
				$result = 'clicked';
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	
	function GetSearchSuggestions($txt)
	{
		$txt = addslashes($txt);
		$suggestions = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$txt = mysql_real_escape_string($txt);
				if(strlen($txt) >0)
				{
					$CurrentMemberID = $GLOBALS['user']->userID;
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name, ImageID, isHub FROM tbl_member WHERE (isHub!=2) AND (mFirst_Name LIKE '%$txt%') OR (mLast_Name LIKE '%$txt%') OR (mEmail  LIKE '%$txt%') LIMIT 10";
					$QueryResult = mysql_query($Query);
					while ($result = mysql_fetch_array($QueryResult))
					{						
						if($CurrentMemberID != $result['MemberID'])
						{
							$imageID = $result['ImageID'];
							$MemberImage = HelpingDBMethods::GetImageData($imageID, "member");
							$memberID = $result['MemberID'];
							$AddBtnString = '';
							$friendID = $result['MemberID'];
							$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
							$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
							if($isMyFriend && $isHisFriend)
							{
								$AddBtnString = '<input type = "button" value = "Added" class = "btn-search-added"/>';
							}				
							elseif($isMyFriend)
							{
								$AddBtnString = '<input type = "button" value = "Pending" class = "btn-search-added"/>';
							}
							else
							{
								$AddBtnString = '<input type = "button" value = "Add" onClick="AddFriendFromSearch('. $result['MemberID'] . ');" class = "btn-search-add"/>';
							}
							$isHub = MemberDBMethods::isHub($result['MemberID']);
							$noOfFriends = HelpingDBMethods::GetNoOfFriends($result['MemberID']);
							
							if ($isHub==1){
								$wikiDef = HelpingDBMethods::wikidefinition($result['mFirst_Name']);
								$MemberImage = 	$wikiDef[0];
								$aboutText = "Topic Hub &#183; ".$noOfFriends." Followers";
							} else{
								$aboutText = $noOfFriends." Friends";
							}
							if($isHub!=2){
								$suggestions .= '<a href="http://www.kahub.com/l/profile?user='.$friendID.'"><li id = "user-name-suggestion-'. $result['MemberID'] . '" >
													<div style = "float:left; width:40px;">
														<img style = "height:40px; width:40px;" src = "' . $MemberImage . '"/>
													</div>
													<div style = "float:left; width:160px; padding:3px;">
														<div>' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '</div>
														<div class="aboutTextSearch">'.$aboutText.'</div>
													</div>
													<div style = "float:right; margin-right:10px; width:100px;">
													</div>
													<div class = "cl"></div>
												 </a></li>';
							} else{
								$hubInfo=HelpingDBMethods::getHubInfoFromID($friendID);
								$hubName = MemberDBMethods::GetUserName($hubInfo['h-memberID']);
								$noOfFriends = HelpingDBMethods::GetNoOfFriends($hubInfo['h-hubID']);
								if($noOfFriends==0){
									$noOfFriends="";
								} else {
									$noOfFriends="&#183; ".$noOfFriends." Followers";
								}
								$suggestions .= '<a href="http://www.kahub.com/l/phub?user='.$hubInfo['h-handle'].'"><li id = "user-name-suggestion-'. $result['MemberID'] . '" >
													<div style = "float:left; width:40px;">
														<img style = "height:40px; width:40px;" src = "' . $MemberImage . '"/>
													</div>
													<div style = "float:left; width:160px; padding:3px;">
														<div>'.$hubName.' (/'.$hubInfo['h-handle'].')</div>
														<div class="aboutTextSearch">'.$hubInfo['h-headline'].' '.$noOfFriends.'</div>
													</div>
													<div style = "float:right; margin-right:10px; width:100px;">
													</div>
													<div class = "cl"></div>
												 </a></li>';
							}
						}
					}					
				}
				else
				{
					// Dont do anything.
				}
			}
			mysql_close($DBConnection);
		}
		
		return 	$suggestions;
	}
	
	
	
	function NotificationStatus($UserID, $NID)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				Notifications::SetNotificationStatus($UserID, $NID, 1);
			}
			mysql_close($DBConnection);
		}
		
		return 	$result;
	}
	
	function BragMyBadgeHTML($BadgeID)
	{
		return <<<HTML
		<div id = "source-suggestions-container">
		<input type = "text" id = "input-brag-to" class = "input-brag-to" value = "Type the name of someone to Brag to" onblur="WaterMark(this, event, 'Type the name of someone to Brag to'); hideBragSuggestionBox();" onfocus="WaterMark(this, event, 'Type the name of someone to Brag to');" onkeyup="GetBragSuggestions(this.value)"/>
		<input type = "hidden" id = "badge-id" value = "{$BadgeID}" />
		<input type = "hidden" id = "sid-brag" value = "0" />
		<div id = "source-suggestions">
		
		</div>
		<input type = "button" class = "btn-brag" value = "Ok, done" onclick = "BragToMyFriend()" />
		</div>
HTML;
	}
	
	function GetBragSuggestions($txt)
	{
		$txt = addslashes($txt);
		$suggestions = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$txt = mysql_real_escape_string($txt);
				if(strlen($txt) >0)
				{
					$CurrentMemberID = $GLOBALS['user']->userID;
					$QueryResult = HelpingDBMethods::GetMyFriendsList($CurrentMemberID, $txt, 8);
					//$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE (mFirst_Name LIKE '%$txt%') OR (mLast_Name LIKE '%$txt%') OR (mEmail  LIKE '%$txt%') LIMIT 10";
					//$QueryResult = mysql_query($Query);
					while ($result = mysql_fetch_array($QueryResult))
					{						
						if($CurrentMemberID != $result['MemberID'])
						{	
							$friendID = $result['MemberID'];						
							$badges = HelpingDBMethods::GetBadges($friendID, "brag", 4, 0);
							$suggestions .= '<li id = "user-name-suggestion-'. $result['MemberID'] . '" onclick = "fillBragTo(\'' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '\', ' . $friendID . ')" class = "li-brag-suggestions">
												<div style = "float:left; width:150px; text-align:left;">' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '</div>
												<div style = "float:left; width:125px; text-align:right;">' . $badges . '</div>											
												<div class = "cl"></div>
											 </li>';
						}
					}					
				}
				else
				{
					// Dont do anything.
				}
			}
			mysql_close($DBConnection);
		}
		
		return 	$suggestions;
	}
	
	function BragToMyFriend($friendID, $BadgeID)
	{
		$result = '';
		if($friendID > 0)
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{
					$isMember = MemberDBMethods::isExistMemberByID($friendID);
					if($isMember)
					{
						$CurrentMemberID = $GLOBALS['user']->userID;
						$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friendID);
						$isHisFriend = HelpingDBMethods::isMyFriend($friendID, $CurrentMemberID);
						if($isMyFriend && $isHisFriend)
						{
							
							$data = array("AddressedTo" => $friendID, "ActionBy" => $CurrentMemberID, "BadgeID" => $BadgeID);
							Notifications::InsertNotification(6, $data);
							BadgeMethods::UpdateBadge9($CurrentMemberID);
							$result = 'Your friend is being notified!';
						}
						else
						{							
							$result = 'You are not Friends';
						}
					}
					else
					{
						$result = 'Member does not exist';
					}
				}
				mysql_close($DBConnection);
			}
		}
		return $result;
	}
	
	function GetStoryData($StoryID)
	{
		//sleep(5);
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$tags = HelpingDBMethods::GetStoryTags($StoryID);
				$StoryData = HelpingDBMethods::GetStoryData($StoryID);
				$CommentData = HelpingDBMethods::GetStorySingleComent($StoryID);
				$category = HelpingDBMethods::GetStoryCategoryID($StoryID);
				$sTitle = $StoryData['s-title'];
				$sURL = $StoryData['s-url'];
				$CommentText = $CommentData['c-text'];
				$commentorID = $CommentData['c-memberid'];
				
				$commentorImageID = HelpingDBMethods::GetMemberImageID($commentorID);
				$commentorImage = HelpingDBMethods::GetImageData($commentorImageID, "member");
				$tagString = implode(",", $tags);
				$result =  '<?xml version="1.0" encoding="utf-8" ?> 
							<result>
								<stitle>' . $sTitle . '</stitle>
								<url>' . $sURL . '</url>
								<comment>' . $CommentText . '</comment>
								<imgMember>' . $commentorImage . '</imgMember>
								<tags>' . $tagString . ' </tags>
								<categoryID>' . $category . ' </categoryID>
								
							</result>';
			}
			mysql_close($DBConnection);
		}		
		return 	$result;
	}
	
	function GetCategorySuggestions($txt, $bNo)
	{
		$txt = addslashes($txt);
		$suggestions = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$txt = mysql_real_escape_string($txt);
				if(strlen($txt) >0)
				{					
					$QueryResult = mysql_query("SELECT CategoryID, CategoryName FROM tbl_category WHERE CategoryName LIKE '%$txt%' ORDER BY CategoryName LIMIT 0, 5");
					while ($result = mysql_fetch_array($QueryResult))
					{
						$suggestions .= '<li onclick = "SetCategory(\'' . $result['CategoryName'] . '\', ' . $bNo . ')" class = "li-brag-suggestions">' . $result['CategoryName'] . '</li>';					
						/*$suggestions .= '<li id = "user-name-suggestion-'. $result['MemberID'] . '" onclick = "fillBragTo(\'' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '\', ' . $friendID . ')" class = "li-brag-suggestions">
									<div style = "float:left; width:150px; text-align:left;">' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '</div>
									<div style = "float:left; width:125px; text-align:right;">' . $badges . '</div>											
									<div class = "cl"></div>
									</li>';*/
					}					
				}
				else
				{
					// Dont do anything.
				}
			}
			mysql_close($DBConnection);
		}
		
		return 	$suggestions;
	}
}
?>