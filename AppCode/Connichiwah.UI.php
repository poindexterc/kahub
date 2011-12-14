<?php
require_once 'ApplicationSettings.php';
require_once 'HelpingDBMethods.php';
require_once 'MemberDBMethods.php';
class ConnichiwahUI
{
	function UILogin()
	{
		return '<div class = "UI-Privacy-Options-Container"><a href="javascript:UILogin()" class="red-btn-85">Please Login</a></div>';
	}	
	
	
	
	function UIHoverboxShare($text_selected, $url, $MemberID)
	{
		$rooturl = Settings::GetRootURL();
		$ft = $_GET['ft'];
		$ImageID = HelpingDBMethods::GetMemberImageID($MemberID);
		$MemberImage = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
		//$result = '<textarea type="text" class="UI-Share-TextBox" name = "commentstext" id = "commentstext"></textarea><div style = "height:25px;"><input type="button" value="Share" class="share-btn" name = "submit" onclick = "Share()"/><a href = "' . $rooturl . 'extention/comment-service.php?type=UI.Hoverbox.Share&text={$text_selected}&url={$url}&lock=1" ><img alt="" src="' . $rooturl . 'extention/images/uni-lock.jpg" class="lock"/></a></div>';
		$result = '<div class = "replies-container"></div><img alt="" src="' . $MemberImage . '" class="UI-Face-Image fl current-member-image" style = "display:none;"/><textarea type="text" class="UI-Share-TextBox" name = "commentstext" id = "commentstext">I think that </textarea><div class="shareType"><li class="sharebtn active" id="friends" onClick="changeActive(2);"><img src="friends.png"></li><li class="sharebtn" id="world" onClick="changeActive(3);"><img src="world.png"></li></div><div style = "height:25px;" class="share-fix"><input type="button" value="Share" class="share-btn" name = "submit" onclick = "Share()"/>';

		//$result = str_replace("\n", "", $result);
		//$result = str_replace("\t", "", $result);
		return $result;
	}
	
	function UIFace($text_selected, $url)
	{
		$MemberID = $GLOBALS['user']->userID;
		$result = '';
		$MemberImage = '';
		$storyID = HelpingDBMethods::GetStoryID($url);
		$Query = "SELECT DISTINCT c.MemberID		
				  FROM tbl_comments c
						INNER JOIN tbl_friends a ON c.MemberID = a.MemberID_Active OR c.MemberID = a.MemberID_Passive
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 		
				  WHERE (c.Comment_Associated_Text = '$text_selected') AND (c.StoryID = '$storyID') AND (a.MemberID_Active =  '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row != false)
		{
			$result = '<div class = "UI-Faces-Only">';
			while($row!=false)
			{
				$MemberID = $row['MemberID'];
				$MemberName = MemberDBMethods::GetUserName($MemberID);
				$ImageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
				$MemberImage = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
				$Link_URL = 'javascript:UIFaceClick()';
				//$result .= '<div class="box-29-mid"><img src = "' . $MemberImage . '" style = "padding:0px; width:25px;" /></div>';
				$result .= '<a class = "UI-Face-Image-Link" rel = "' . $MemberID . '"><table><tr><td><img src = "' . $MemberImage . '" class = "UI-Face-Image" /></td><td><span class = "UI-Face-Image-Link-UserName" id = "UI-Face-Image-Link-UserName' . $MemberID . '">' . $MemberName . '</span></td></tr></table></a>';
				$row = mysql_fetch_array($QueryResult);
			}
			$result .= '</div>';
		}		
		return $result;
	}
	
	function UIHoverboxComments($text_selected, $url, $CurrentMemberID, $pageNo)
	{
		$rooturl = Settings::GetRootURL();
		$result = '<div class = "replies-container">';
		$storyID = HelpingDBMethods::GetStoryID($url);
		
		$limit = 3;
		$totalNoOfComments = HelpingDBMethods::GetCommentCount($text_selected, $storyID);
		$totalPages = ceil($totalNoOfComments/$limit);
		$offset = 0;
		if($pageNo == 'last')
		{
			$pageNo = $totalPages;
		}
		else
		{
			$offset = $limit * ($pageNo - 1);
		}
		
		$Query = "SELECT c.* 
				FROM tbl_comments c
				INNER JOIN tbl_friends a ON c.MemberID = a.MemberID_Active OR c.MemberID = a.MemberID_Passive
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 		
				WHERE (c.Comment_Associated_Text = '$text_selected') AND (c.StoryID = '$storyID') AND (a.MemberID_Active =  '$CurrentMemberID')
				GROUP BY c.CommentID
				ORDER BY Date_Time DESC LIMIT $offset, $limit";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$MemberID = $row['MemberID'];
			$MemberName = MemberDBMethods::GetUserName($MemberID);
			$ImageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
			$MemberImage = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$CommentText = $row['Comment_Text'];
			$CommentID = $row['CommentID'];
			$CategoryID = HelpingDBMethods::GetStoryCategoryID($storyID);
			$TrustLink = '';
			$LikeLink = '';
			
				$replybox = '<div id="reply-area"><input value="Write a reply..." onclick="javascript:UIHoverboxReply(' . $CommentID . ')" id = "reply-' . $CommentID . '" class="reply-box" readonly="true" style="float: right; width: 140px; margin-top: -30px; margin-right: 5px"></div>';
			if(HelpingDBMethods::isCommentLiked($CurrentMemberID, $CommentID) == false)
			{
				$LikeLink = '<a href="javascript:UIHoverboxLike(' . $CommentID . ')" class = "ok-button" id = "like-' . $CommentID . '"><img alt="" src="' . $rooturl . 'extention/images/uni-ok.png" class="middle"/></a>';
			}
			if(HelpingDBMethods::isMemberTrusted($CurrentMemberID, $MemberID, $CategoryID) == false)
			{
				if($CurrentMemberID!=$MemberID){
									$TrustLink = '';
				} else{
							$TrustLink = '';
						$replybox = '<div id="reply-area"><input value="Write a reply..." onclick="javascript:UIHoverboxReply(' . $CommentID . ')" id = "reply-' . $CommentID . '" class="reply-box" readonly="true" style="margin-right: 5px"></div>';
				}
			}
			
			/*$result .= '
							<div class = "comment-wrapper">
								<img alt="" src="' . $MemberImage . '" class="UI-Face-Image fl"/>
								<div class="comment-text fl"><span>' . $MemberName . '</span> said ' . $CommentText . '</div>
								<div class = "cl"></div>
								<a href="javascript:UIHoverboxTrust(' . $MemberID . ')" class="trust-btn">Trust</a>
								
								<span class = "fr">
									' . $LikeLink . '
									<a href="javascript:UIHoverboxReply(\'' . $text_selected . '\', \'' . $CommentID . '\')"><img alt="" src="../extention/images/uni-reply.png" class="middle"/></a>
								</span>
							</div>
						 ';*/
			$result .= '<div class = "comment-wrapper"><img alt="" src="' . $MemberImage . '" class="UI-Face-Image fl"/><div class="comment-text fl"><span>' . $MemberName . '</span> said ' . $CommentText . '</div><div class = "cl"></div>' . $TrustLink . ''.$replybox.'';
			$row = mysql_fetch_array($QueryResult);
		}
		
		{
			if($pageNo <=	$totalPages && $totalPages != 1)
			{
				$result .= '<div class = "comment-wrapper"><div class = "reply-pagination">';
				if($pageNo > 1)
				{
					$result .= '<div class = "previous" onClick = "UIHoverboxCommentsMore(' . ($pageNo - 1) . ');">Previous</div>';
				}
				if($pageNo < $totalPages)
				{
					$result .= '<div class = "next" onClick = "UIHoverboxCommentsMore(' . ($pageNo + 1) . ');">Next</div>';
				}
				$result .= '<div class="cl"></div>';
				$result .= '</div></div>';
			}	
		}
		$result .= '</div>';
		//$result = str_replace("\n", "", $result);
		return $result;
	}
	
	function UIPrivacy($text_selected, $url)
	{
		$rooturl = Settings::GetRootURL();
		/*return <<<HTML
				<div class="share-with">                
                    <div class="share-with-top"></div>
                    <div class="share-with-mid">
                        <a href="{$rooturl}service/comment-service.php?type=UI.Hoverbox.Share&text={$text_selected}&url={$url}&lock=2" class="red-btn-85">Share with<br /> a Source</a>
                        <a href="{$rooturl}service/comment-service.php?type=UI.Hoverbox.Share&text={$text_selected}&url={$url}" class="red-btn-85">Share with<br /> your Network</a>
                    </div>
                    <div class="share-with-bot"></div>                
                </div>
HTML;*/
		return '<div class = "UI-Privacy-Options-Container"><a href="javascript:UIPrivacySourceSelection()" class="red-btn-85">Share with<br /> a Source</a><a href="javascript:SourceSelected(2)" class="red-btn-85">Share with<br /> your Network</a></div>';
	}
	
	function UIPrivacySourceSelection($text_selected, $url)
	{
		$rooturl = Settings::GetRootURL();
		/*return <<<HTML
						<div>
							<input type="text" id="txtSource" name = "txtSource" value="Type the name of a source" class="white-box-172" onkeyup="lookup(this.value);" onblur="fill();"/>
                        </div>
                        <div class="suggestionsBox" id="suggestions" style="display: none;" >
							<div class="suggestionList" id="autoSuggestionsList">
								&nbsp;
							</div>
						</div>
                        <!--<input type="submit" value="Okay, done" class="okay-done" />-->
                        <a href="{$rooturl}service/comment-service.php?type=UI.Hoverbox.Share&text={$text_selected}&url={$url}" class="okay-done">Okay, done</a>
HTML;*/
		return '<div><input type="text" id="txtSource" name = "txtSource" value="Type the name of a source" class="white-box-172" onfocus="WaterMarkSource(this, event)" onkeyup="GetUserNameSuggestions(this.value)" onblur="hideSuggestionBox(); WaterMarkSource(this, event);"/></div><div class="suggestionsBox" id="suggestions" ><div class="suggestionList" id="autoSuggestionsList" style="display: none;">&nbsp;</div></div><input type="button" value="Okay, done" class="okay-done" onclick = "SourceSelected(1)" />';
	}
	
	function UIHoverboxReply($text_selected, $url, $CommentID)
	{
		$rooturl = Settings::GetRootURL();
		$result = '';
		$Query = "SELECT * FROM tbl_comments WHERE (CommentID = '$CommentID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$totalNoOfComments = HelpingDBMethods::GetCommentCount(addslashes($row['Comment_Associated_Text']), $row['StoryID']);
			$more_text = '';
			if($totalNoOfComments > 1)
			{
				$more_text = '<div class = "reply-pagination"><div class = "more" onClick = "UIHoverboxMore(1);">View More...</div></div>';
			}
			
			$MemberID = $row['MemberID'];
			$MemberName = MemberDBMethods::GetUserName($MemberID);
			$ImageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
			$MemberImage = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$CommentText = $row['Comment_Text'];
			$CurrentMemberImageID = HelpingDBMethods::GetMemberImageID($GLOBALS['user']->userID);
			$CurrentMemberImage = HelpingDBMethods::GetImageData($CurrentMemberImageID, 'member', 'thumbnail');
			/*$result .= '<div class = "replies-container">
							<div class = "comment-wrapper">
								<img alt="" src="' . $MemberImage . '" class="UI-Face-Image fl"/>
								<div class="comment-text fl">
									<span>' . $MemberName . '</span> said ' . $CommentText . '
								</div>
								<div class="cl"></div>
								' . $more_text . '
							</div>
						</div>
						<div class = "comment-reply-wrapper">
							<img alt="" src="' . $CurrentMemberImage . '" class="UI-Face-Image fl current-member-image" />
							<div class="comment-text fl">
								<textarea type="text" name = "commentstext" id = "commentstext" class="white-box-140"></textarea>
							</div>
							<div class="cl"></div>
							<input type="button" value="Post Reply" class="post-reply-btn" onclick = "PostReply(' . $CommentID . ')" />
						</div>';*/
			$result .= '<div class = "replies-container"><div class = "comment-wrapper"><img alt="" src="' . $MemberImage . '" class="UI-Face-Image fl"/><div class="comment-text fl"><span>' . $MemberName . '</span> said ' . $CommentText . '</div><div class="cl"></div>' . $more_text . '</div></div><div class = "comment-reply-wrapper"><img alt="" src="' . $CurrentMemberImage . '" class="UI-Face-Image fl current-member-image" /><div class="comment-text fl"><textarea type="text" name = "commentstext" id = "commentstext" class="white-box-140"></textarea></div><div class="cl"></div><input type="button" value="Post Reply" class="post-reply-btn" onclick = "PostReply(' . $CommentID . ')" /></div>';
		}
		
		return $result;
	}
	
	function UIHoverboxMore($text_selected, $url, $offset, $limit, $pageNo)
	{
		$storyID = HelpingDBMethods::GetStoryID($url);		
		$totalNoOfComments = HelpingDBMethods::GetCommentCount($text_selected, $storyID);
		$result = '';
		$rooturl = Settings::GetRootURL();		
		$Query = "SELECT c.*
				FROM tbl_comments c
				INNER JOIN tbl_friends a ON c.MemberID = a.MemberID_Active OR c.MemberID = a.MemberID_Passive
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 		
				WHERE (c.Comment_Associated_Text = '$text_selected') AND (c.StoryID = '$storyID') AND (a.MemberID_Active =  '$MemberID')
				GROUP BY c.CommentID
				ORDER BY Date_Time DESC LIMIT $offset, $limit";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$MemberID = $row['MemberID'];
			$MemberName = MemberDBMethods::GetUserName($MemberID);
			$ImageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
			$MemberImage = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$CommentText = $row['Comment_Text'];
			//$CommentID = $row['CommentID'];
			/*$result .= '<div class = "comment-wrapper">
							<img alt="" src="' . $MemberImage . '" class="UI-Face-Image fl"/>
							<div class="comment-text fl">
								<span>' . $MemberName . '</span> said ' . $CommentText . '
							</div>
							<div class="cl"></div>							
						</div>';*/
			$result .= '<div class = "comment-wrapper"><img alt="" src="' . $MemberImage . '" class="UI-Face-Image fl"/><div class="comment-text fl"><span>' . $MemberName . '</span> said ' . $CommentText . '</div><div class="cl"></div></div>';
			$row = mysql_fetch_array($QueryResult);
		}
		
		{
			// Next - Previous Implemntation
			/*$result .= '<div class = "comment-wrapper">
							<div class = "reply-pagination">
								<div class = "previous" onClick = "UIHoverboxMore(' . ($pageNo - 1) . ');">Previous</div>
								<div class = "next" onClick = "UIHoverboxMore(' . ($pageNo + 1) . ');">Next</div>
								<div class="cl"></div>
							</div>
						</div>';*/
			$totalPages = ceil($totalNoOfComments/$limit);
			if($pageNo <=	$totalPages && $totalPages != 1)
			{
				$result .= '<div class = "comment-wrapper"><div class = "reply-pagination">';
				if($pageNo > 1)
				{
					$result .= '<div class = "previous" onClick = "UIHoverboxMore(' . ($pageNo - 1) . ');">Previous</div>';
				}
				if($pageNo < $totalPages)
				{
					$result .= '<div class = "next" onClick = "UIHoverboxMore(' . ($pageNo + 1) . ');">Next</div>';
				}
				$result .= '<div class="cl"></div>';
				$result .= '</div></div>';
			}		
		}	
		return $result;
	}
}

?>