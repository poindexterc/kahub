<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/Connichiwah.UI.php';
header('Content-Type: text/javascript');
if(isset($_GET['method']) && ($_GET['method'] != ""))
{	
	$MethodName = $_GET['method'];
	if($MethodName == "hello")
	{
		//echo $_GET['callback'] . '(' . $jsonData . ');';
		echo $_GET['callback'] . '(' . myWebservice::hello() . ');';
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
		$txt = $_GET['text'];
		$url = $_GET['url'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxComments($txt, $url) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.Reply")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		$CommentID = $_GET['commentID'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxReply($txt, $url, $CommentID) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.Reply.Post")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		$CommentID = $_GET['commentID'];
		$mycomments = $_GET['mycomments'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxReplyPost($txt, $url, $CommentID, $mycomments) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.Like")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		$CommentID = $_GET['commentID'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxLike($txt, $url, $CommentID) . ');';
	}
	elseif($MethodName == "UI.Hoverbox.Trust")
	{
		$txt = $_GET['text'];
		$url = $_GET['url'];
		$MemberID = $_GET['memberID'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxTrust($txt, $url, $MemberID) . ');';
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
		$mycomments = $_GET['mycomments'];
		$sharemode = $_GET['sharemode'];
		$sharewith = $_GET['sharewith'];
		echo $_GET['callback'] . '(' . myWebservice::UIHoverboxSharePost($txt, $url, $mycomments, $sharemode, $sharewith) . ');';
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
	
	function UIHoverboxComments($txt, $url)
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
				$result = ConnichiwahUI::UIHoverboxComments($txt, $url);
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxReply($txt, $url, $CommentID)
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
				$result = ConnichiwahUI::UIHoverboxReply($txt, $url, $CommentID);
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxReplyPost($txt, $url, $CommentID, $Comments)
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
				$storyID = HelpingDBMethods::GetStoryID($url);
				$MemberID = 1;
				$ReplyTo = $CommentID;
				HelpingDBMethods::PostComments($storyID, $txt, $Comments, $MemberID, $ReplyTo);
				
				
				$result = ConnichiwahUI::UIHoverboxComments($txt, $url);
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
				$CurrentMemberID = 1;
				if(HelpingDBMethods::isCommentLiked($CurrentMemberID, $CommentID) == false)
				{
					$result = HelpingDBMethods::LikeComment($CurrentMemberID, $CommentID);
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
				$MemberID = 1;
				if(HelpingDBMethods::isMemberTrusted($MemberID, $FriendID) == false)
				{
					$result = HelpingDBMethods::TrustMember($MemberID, $FriendID);
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
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$result = ConnichiwahUI::UIHoverboxShare($txt, $url);
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function UIHoverboxSharePost($txt, $url, $Comments, $sharemode, $sharewith)
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
				$storyID = HelpingDBMethods::GetStoryID($url);
				if($storyID == 0)
				{
					HelpingDBMethods::InsertStory('', $url);
					$storyID = HelpingDBMethods::GetStoryID($url);
				}
				$MemberID = 1;
				$ReplyTo = 0;
				HelpingDBMethods::PostComments($storyID, $txt, $Comments, $MemberID, $ReplyTo);
				/////////////////////////////////////////////////////////////////////////////
				// function to share this comment with network or some source etc goes here//
				/////////////////////////////////////////////////////////////////////////////
				$result = ConnichiwahUI::UIHoverboxComments($txt, $url);
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
		//return $result;
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
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE mFirst_Name LIKE '$txt%' LIMIT 4";
					$QueryResult = mysql_query($Query);
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