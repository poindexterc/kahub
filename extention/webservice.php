<?php
require_once '../AppCode/access.class.php';
$user = new flexibleAccess();
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/Connichiwah.UI.php';
require_once '../AppCode/Notifications.php';
require_once '../AppCode/BadgeMethods.php';
header('Content-Type: text/javascript');
if(isset($_GET['method']) && ($_GET['method'] != ""))
{	
	$MethodName = $_GET['method'];
	if($MethodName == "hello")
	{
		//echo $_GET['callback'] . '(' . myWebservice::hello() . ');';
		if($user->is_loaded())
		{
			echo $_GET['callback'] . '(Logged In);';
		}
		else
		{
			echo $_GET['callback'] . '(Not Logged In);';
		} 
	}
	elseif($MethodName == "GetComments")
	{
		$url = $_GET['url'];
		echo $_GET['callback'] . '(' . myWebservice::GetComments($url) . ');';
	}
	elseif($MethodName == "GetUserNameSuggestions")
	{
		$txt = $_GET['txt'];
		echo $_GET['callback'] . '(' . myWebservice::GetUserNameSuggestions($txt) . ');';
	}
	elseif($MethodName == "UI.Face")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		echo $_GET['callback'] . '(' . myWebservice::UIFace($txt, $url) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.Comments")
	{
		if($user->is_loaded())
		{
			$txt = $_GET['text'];
			$url = $_GET['url'];
			$pageNo = $_GET['pno'];
			echo $_GET['callback'] . '(' . myWebservice::UIHoverboxComments($txt, $url, $user->userID, $pageNo) . ');';
		}
		else
		{
			echo $_GET['callback'] . "(\"{'mycomments':'You Are Not Logged In'}\");";
		}
	}
	elseif($MethodName == "UI.Hoverbox.Reply")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		$CommentID = $_GET['commentID'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxReply($txt, $url, $CommentID) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.More")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		$pageNo = $_GET['pageno'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxMore($txt, $url, $pageNo, $user->userID) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.Reply.Post")
	{
		if($user->is_loaded())
		{
			$txt = $_GET['text'];
			$url = $_GET['url'];
			$CommentID = $_GET['commentID'];
			$mycomments = $_GET['mycomments'];
			echo $_GET['callback'] . '(' . myWebservice::UIHoverboxReplyPost($txt, $url, $CommentID, $mycomments) . ');';
		}
		else
		{
			echo $_GET['callback'] . "(\"{'mycomments':'You Are Not Logged In'}\");";
		} 
	}
	elseif($MethodName == "UI.Hoverbox.Like")
	{
		if($user->is_loaded())
		{
			$txt = $_GET['text'];
			$url = $_GET['url'];
			$CommentID = $_GET['commentID'];
			echo $_GET['callback'] . '(' . myWebservice::UIHoverboxLike($txt, $url, $CommentID) . ');';
		}
		else
		{
			echo $_GET['callback'] . "(\"{'mycomments':'You Are Not Logged In'}\");";
		}
	}
	elseif($MethodName == "UI.Hoverbox.Trust")
	{
		if($user->is_loaded())
		{
			$txt = $_GET['text'];
			$url = $_GET['url'];
			$MemberID = $_GET['memberID'];
			echo $_GET['callback'] . '(' . myWebservice::UIHoverboxTrust($txt, $url, $MemberID) . ');';
		}
		else
		{
			echo $_GET['callback'] . "(\"{'mycomments':'You Are Not Logged In'}\");";
		}
	}
	elseif($MethodName == "UI.Hoverbox.Share")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxShare($txt, $url) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.Share.Post")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		$title = $_GET['title'];
		$mycomments = $_GET['mycomments'];
		$sharemode = $_GET['sharemode'];
		$sharewith = $_GET['sharewith'];
		$facebookshare = $_GET['fb'];
		//echo $_GET['callback'] . '(alert("hi - from service"););';
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxSharePost($txt, $url, $title, $mycomments, $sharemode, $sharewith, $facebookshare) . ');';
	}
	elseif($MethodName == "UI.Privacy")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		echo $_GET['callback'] . '(' . myWebservice::UIPrivacy($txt, $url) . ');';
	}
	elseif($MethodName == "UI.Privacy.SourceSelection")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		echo $_GET['callback'] . '(' . myWebservice::UIPrivacySourceSelection($txt, $url) . ');';
	}
	elseif($MethodName == "isInRestrictedDomain")
	{
		$url = $_GET['url'];
		echo $_GET['callback'] . '(' . myWebservice::isInRestrictedDomain($url) . ');';
		//echo myWebservice::isInRestrictedDomain($url);
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
		//alert("Symbol: " + data.symbol + ", Price: " + data.price);
		return HelpingMethods::hexToStr("06106c07506d06e06902007007206f06407506306506402006207902007406806502005506e06907606507207306907407902006f06602007406806502005006106306906606906302006107206502006306f06d07006f07306506402006f06602006e06f07406106206c06502006e06106d06507302006906e02007406806502007706f07206c06402006f06602007307006f07207407302c02007306306906506e06306502006406907306306f07606507207902c02006207507306906e06507307302c02007006f06c06907406906307302c02006d07507306906302006106e06402006606906c06d");
		//return '{"message":"Hello World !!! " , "datetime":"' . gmdate('Y-m-d H-i-s') . '"}';//"Hello World !!! " . gmdate('Y-m-d H-i-s');
	}
	
	function GetComments($url)
	{
		$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$result = HelpingDBMethods::GetAllComments($url);
			}
			mysql_close($DBConnection);
		}
		return '{"comments":"' . $result . '"}';
	}
	
	function UIFace($txt, $url)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$result = ConnichiwahUI::UIFace($txt, $url);
			}
			mysql_close($DBConnection);
		}
		return "{'faces':'" . $result . "'}";
	}
	
	function UIHoverboxComments($txt, $url, $userID, $pageNo = 1)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$result = ConnichiwahUI::UIHoverboxComments($txt, $url, $userID, $pageNo);
				//$result = ConnichiwahUI::UIHoverboxMore($txt, $url, 0, 3, 1);
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxReply($txt, $url, $CommentID)
	{
		//$txt = HelpingMethods::hexToStr($txt);
		//$txt = addslashes($txt);
		//$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$result = ConnichiwahUI::UIHoverboxReply($txt, $url, $CommentID);
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxMore($txt, $url, $pageNo, $userID)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$limit = 3;
		$offset = $limit * ($pageNo - 1);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$result = ConnichiwahUI::UIHoverboxMore($txt, $url, $offset, $limit, $pageNo);
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxReplyPost($txt, $url, $CommentID, $Comments)
	{		
		$MemberID = $GLOBALS['user']->userID;
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$storyID = HelpingDBMethods::GetStoryID($url);
				$ReplyTo = $CommentID;
				$AddressedTo = HelpingDBMethods::GetMemberIDByComment($ReplyTo);
				$NewCommentID = HelpingDBMethods::PostComments($storyID, $txt, $Comments, $MemberID, $ReplyTo);
				$data = array("AddressedTo" => $AddressedTo, "ActionBy" => $MemberID, "StoryID" => $storyID, "CommentID" => $NewCommentID);
				Notifications::InsertNotification(1, $data);
				
				$result = ConnichiwahUI::UIHoverboxComments($txt, $url, $MemberID, 'last');
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxLike($txt, $url, $CommentID)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$CurrentMemberID = $GLOBALS['user']->userID;
				if(HelpingDBMethods::isCommentLiked($CurrentMemberID, $CommentID) == false)
				{
					$result = HelpingDBMethods::LikeComment($CurrentMemberID, $CommentID);
					$LastCommentData = HelpingDBMethods::GetStorySingleComent($CommentID, false);
					$NewCommentID = HelpingDBMethods::PostComments($StoryID, $LastCommentData['c-a-t'], 'Interesting', $userID, $LastCommentData['c-id']);
					
					$data = array("AddressedTo" => $LastCommentData['c-memberid'], "ActionBy" => $CurrentMemberID, "StoryID" => $StoryID, "CommentID" => $NewCommentID);
					Notifications::InsertNotification(1, $data);
				}
				else
				{
					$result = "Already Liked";
				}
			}
			mysql_close($DBConnection);
		}
		return "{'result':'" . $result . "'}";
	}
	
	function UIHoverboxTrust($txt, $url, $FriendID)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$MemberID = $GLOBALS['user']->userID;
				$storyID = HelpingDBMethods::GetStoryID($url);
				$CategoryID = HelpingDBMethods::GetStoryCategoryID($storyID);
				if(HelpingDBMethods::isMemberTrusted($MemberID, $FriendID, $CategoryID) == false)
				{
					$result = HelpingDBMethods::TrustMember($MemberID, $FriendID, $CategoryID);
				}
				else
				{
					$result = "Already Trusted";
				}			
			}
			mysql_close($DBConnection);
		}
		return "{'result':'" . $result . "'}";
	}
	
	function UIHoverboxShare($txt, $url)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$MemberID = $GLOBALS['user']->userID;
		
		$result = "";
		if($GLOBALS['user']->is_loaded())
		{		
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{				
					$result = ConnichiwahUI::UIHoverboxShare($txt, $url, $MemberID);
				}
				mysql_close($DBConnection);
			}
		}
		else
		{
			$result = ConnichiwahUI::UILogin();
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxSharePost($txt, $url, $title, $Comments, $sharemode, $sharewith, $facebookshare)
	{
		$MemberID = $GLOBALS['user']->userID;
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$title = HelpingMethods::hexToStr($title);
		$title = addslashes($title);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$storyID = HelpingDBMethods::GetStoryID($url);
				if($storyID == 0)
				{
					HelpingDBMethods::InsertStory($title, $url);
					$storyID = HelpingDBMethods::GetStoryID($url);
				}
				//HelpingDBMethods::FacebookShare($MemberID, $txt, $title, $url);
								
				$ReplyTo = 0;
				$CommentID = HelpingDBMethods::PostComments($storyID, $txt, $Comments, $MemberID, $ReplyTo);
				/////////////////////////////////////////////////////////////////////////////
				// function to share this comment with network or some source etc goes here//
				if($sharemode == 3)//1 for source 2 for network
				{
					$userID = HelpingDBMethods::getCurrentHubID($MemberID);
					$CommentID = HelpingDBMethods::PostComments($storyID, $txt, $Comments, $userID, $ReplyTo);

				}
				else
				{
					// add notification for all friends
					//Notifications::SendNotificationToNetwork($MemberID, $storyID);
				}
				/////////////////////////////////////////////////////////////////////////////
				$result = ConnichiwahUI::UIHoverboxComments($txt, $url, $MemberID, 1);
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIPrivacy($txt, $url)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		return "{'mycomments':'" . ConnichiwahUI::UIPrivacy($txt, $url) . "'}"; 
	}
	
	function UIPrivacySourceSelection($txt, $url)
	{
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		return "{'mycomments':'" . ConnichiwahUI::UIPrivacySourceSelection($txt, $url) . "'}"; 
	}
	
	function isInRestrictedDomain($url)
	{
		$url = HelpingMethods::hexToStr($url);
		//$pos = strpos($url,Settings::GetRootURL() . 'anyShare/story.php');
		//if($pos === false) 
		{
			$domainName = HelpingMethods::GetDomain($url);
			$result = "";
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{								
					$result = HelpingDBMethods::isInRestrictedDomain($domainName);
				}
				mysql_close($DBConnection);
			}
			return "{'result':'" . $result . "'}";
		}
		//else 
		{			
			//return "{'result':'false', 'activeUrl':'" . $url . "'}";
		}
	}
	
	
	
	
	
	
	function GetUserNameSuggestions($txt)
	{
		$MemberID = $GLOBALS['user']->userID;
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
					//$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE mFirst_Name LIKE '$txt%' LIMIT 4";
					//$QueryResult = mysql_query($Query);
					$QueryResult = HelpingDBMethods::GetMyFriendsList($MemberID, $txt, 4);
					while ($result = mysql_fetch_array($QueryResult))
					{
						$suggestions .= '<li id = "user-name-suggestion-'. $result['MemberID'] . '" onClick="fill('. $result['MemberID'] . ');" >' . $result['mFirst_Name'] . ' ' . $result['mLast_Name'] . '</li>';
					}					
				}
				else
				{
					// Dont do anything.
				}
			}
			mysql_close($DBConnection);
		}
		
		return 	"{'suggestions':'" . $suggestions . "'}"; 
	}
}
?>