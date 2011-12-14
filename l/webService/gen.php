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
			echo myWebservice::GetMoreStories($offset, $limit, $userID);
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
	elseif($MethodName == "LikeStory")
	{
		if($user->is_loaded())
		{
			$userID = $user->userID;
			$StoryID = $_POST['storyid'];
			echo myWebservice::LikeStory($StoryID, $userID);
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
		
		return "Hello World !!! " . gmdate('Y-m-d H-i-s');
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
							$from = "noreply@connichiwah.com";
							
							$headers = "From: " . $MemberName . " <noreply@connichiwah.com> \r\n";
							
							$subject= 'Friend Requst : By ' . $MemberName;
							$body = <<<Body
								<h1>Hey Buddy it's me, {$MemberName}</h1>
								<div>Comm on Join Me on Connichiwah and we can share every thing. </div>
								<div>To Join Connichiwah <a href = "http://www.connichiwah.com">Click Here</a></div>
Body;
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
							$from = "noreply@connichiwah.com";
							
							$headers = "From: " . $MemberName . " <noreply@connichiwah.com> \r\n";
							
							$subject= 'Friend Requst : By ' . $MemberName;
							$body = <<<Body
								<h1>Hey Buddy it's me, {$MemberName}</h1>
								<div>Comm on Join Me on Connichiwah and we can share every thing. </div>
								<div>To Join Connichiwah <a href = "http://www.connichiwah.com">Click Here</a></div>
Body;
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
		$result = $CountFriendsAdded . ' Friends Added, ' . $CountAlreadyFriends . ' Friends are already friends and ' . $CountFriendsRequestPending . ' Friend Requests Pending .';
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
						$result = 'Member Do not Exists';
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
						$result = 'Member Do not Exists';
					}
				}
				mysql_close($DBConnection);
			}
		}
		return $result;
	}
	
	function GetMoreStories($offset, $limit, $userID)
	{
		sleep(2);
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$result = HelpingDBMethods::GetLatestStories($offset, $limit, $userID);
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
					$LastCommentData = HelpingDBMethods::GetStorySingleComent($StoryID);
					HelpingDBMethods::PostComments($StoryID, $LastCommentData['c-a-t'], 'Interesting', $userID, $LastCommentData['c-id']);
					$result = 'liked';
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
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name, ImageID FROM tbl_member WHERE (mFirst_Name LIKE '%$txt%') OR (mLast_Name LIKE '%$txt%') OR (mEmail  LIKE '%$txt%') LIMIT 10";
					$QueryResult = mysql_query($Query);
					while ($result = mysql_fetch_array($QueryResult))
					{						
						if($CurrentMemberID != $result['MemberID'])
						{
							$imageID = $result['ImageID'];
							$MemberImage = HelpingDBMethods::GetImageData($imageID, "member");
							
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
							$badges = HelpingDBMethods::GetBadges($friendID, "search", 4, 0);
							$suggestions .= '<li id = "user-name-suggestion-'. $result['MemberID'] . '" >
												<div style = "float:left; width:40px;">
													<img style = "height:40px; width:40px;" src = "' . $MemberImage . '"/>
												</div>
												<div style = "float:left; width:160px; padding:3px;">
													<div>' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '</div>
													<div>' . $badges . '</div>
												</div>
												<div style = "float:right; margin-right:10px; width:100px;">
													' . $AddBtnString . ' 
												</div>
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
							$result = 'Your friend is being notified !';
						}
						else
						{							
							$result = 'You are not Friends';
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
							</result>';
			}
			mysql_close($DBConnection);
		}		
		return 	$result;
	}
}
?>