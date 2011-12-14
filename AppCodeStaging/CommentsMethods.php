<?php
require_once 'ApplicationSettings.php';
require_once 'RequestQuery.php';
require_once 'HelpingDBMethods.php';
require_once 'HelpingMethods.php';
class CommentsMethods
{	
	function GetCommentCount($StoryID)
	{
		$Query = "SELECT COUNT(StoryID) FROM tblcomments WHERE (StoryID = '$StoryID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$result =  mysql_result($QueryResult, 0, 0);
		return $result; 
	}
	
	function GetComments($StoryID, $offset, $limit, $showAllLink = false)
	{
		$rootURL = Settings::GetRootURL();
		$result = "";
		$result = '<ul class="comments-list" id = "ul-comments' . $StoryID . '">
						<span class="sprites arrow-top"></span>';
		$Query = "SELECT * FROM tblcomments WHERE (StoryID = '$StoryID') AND (Approved = 1) LIMIT $offset, $limit";
		if($limit == 'all')
		{
			$Query = "SELECT * FROM tblcomments WHERE (StoryID = '$StoryID') AND (Approved = 1)";
		}
		
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		
		if($row!=false)
		{
			$storyURL = HelpingDBMethods::GetStoryURL($StoryID);
			if($showAllLink)
			{
				$result .= '<li>
								<p class="single-line center"><a href="' . Settings::GetRootURL() . 'story/' . $storyURL . '">View All Comments</a></p>
							</li>';
			}
			$isAlt = true;
			while($row != false)
			{
				$username = $row['Name'];
				$timeAgo = HelpingMethods::GetShortDateTime($row['DateTime']);
				$altClass = '';
				if($isAlt == true)
				{
					$altClass = 'class="alt"';
					$isAlt = false;
				}
				else
				{
					$isAlt = true;
				}
				$result .= <<<Content
						<li  {$altClass}>
							<div class="author">
								<img alt="" src="{$rootURL}images/author-3.jpg" />
								<p><a>{$username}</a><br/><span class = "datetime">{$timeAgo}</span></p>
							</div>
							<div class="comments-text">
								<p>{$row['Text']}</p>
							</div>
						</li>						
Content;
				$row = mysql_fetch_array($QueryResult);					
			}						
		}
		$result .= CommentsMethods::SetPostCommentsSection($StoryID);
		$result .= '</ul>';
		return $result;
		//return $StoryID . ", Offset : " . $offset . ", Limit : " . $limit;
	}
	
	function GetComment($CommentID)
	{
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT * FROM tblcomments WHERE (CommentID = $CommentID) AND (Approved = 1)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$username = $row['Name'];
			$timeAgo = HelpingMethods::GetShortDateTime($row['DateTime']);
			$result = <<<Content
						<li>
							<div class="author">
								<img alt="" src="{$rootURL}images/author-3.jpg" />
								<p><a>{$username}</a><br/><span class = "datetime">{$timeAgo}</span></p>
							</div>
							<div class="comments-text">
								<p>{$row['Text']}</p>
							</div>
						</li>
Content;
		}
		return $result;
	}
	
	function SetPostCommentsSection($StoryID)
	{
		$userID = 0;
		$PostCommentBox = '<p class="single-line center"><a class = "login" href="#Login_SignUp_Box">Register Now</a>  or <a class = "login" href="#Login_SignUp_Box">Login Here</a></p>';
		if($GLOBALS['user']->is_loaded())
		{
			$PostCommentBox = '<p><textarea style = "height:25px;" type="text" id = "inputText-' . $StoryID . '" class="comment-field middle expand25-200 elastic"></textarea> &nbsp;<input type="button" value="" class="sprites btn-post-comment middle" onclick="postComment(' . $StoryID . ', 0, 1)" /></p>';
		}
		
		$result = <<<Content
				<li class="bg-white" id = "post-comment-li-{$StoryID}">
						<div class="author">
							<p class="single-line center"><strong>Post Comment:</strong></p>
						</div>
						<div class="comments-text">
		{$PostCommentBox}
						</div>
					</li>
						
Content;
		return $result;
	}
	
	function InsertComments($StoryID, $name, $email, $message)
	{
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tblcomments (StoryID, MemberID, Name, Email, Website, Text, ReplyTo, Approved, DateTime, Level) 
				VALUES ('" . $StoryID . "', 0, '" . $name . "', '" . $email . "', '', '" . $message . "', 0, 1, '" . $DateTime . "', 1)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
}

?>