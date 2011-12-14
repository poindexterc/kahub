<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';

$user = new flexibleAccess();
if(!$user->is_loaded())
{
	header('Location:' . Settings::GetRootURL() . 'login.php');	
}
else
{
	require_once '../AppCode/MasterPageScript.php';
	require_once '../AppCode/SideBarScript.php';
	require_once '../AppCode/StoryRanking.php';
	require_once '../AppCode/HelpingMethods.php';
	require_once '../AppCode/URLKeyWordExtraction/URLKeyWordExtraction.php';
	$userID = $GLOBALS['user']->userID;
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	$cID = $_GET['c'];
	$comments=HelpingDBMethods::GetReplies($cID);
	$commentData = HelpingDBMethods::GetCommentData($cID);
	$storyID  = $commentData['c-StoryID'];
	$storyData = HelpingDBMethods::GetStoryData($storyID);
	$origComment = $commentData['c-text'];
	$urlhex = HelpingMethods::strToHex($storyData['s-url']);
	$origMember = $commentData['c-memberid'];
	$snippet = HelpingDBMethods::GetStorySnippet($storyID, 400);
	$origimageID = HelpingDBMethods::GetMemberImageID($origMember);
	$origName = MemberDBMethods::GetUserName($origMember);
	$reply = HelpingDBMethods::GetReply($cID);
	if($reply!=0){
		$replyMemberID = HelpingDBMethods::GetMemberIDByComment($reply);
		$ReplyimageID = HelpingDBMethods::GetMemberImageID($replyMemberID);
		$replyname = MemberDBMethods::GetUserName($replyMemberID);
		$replyCommentText = HelpingDBMethods::GetCommentText($reply);
		$replyImgSrc= HelpingDBMethods::GetImageData($ReplyimageID, 'member', 'thumbnail');
	}
	$isHub = MemberDBMethods::isHub($origMember);
	if($isHub!=2){
	    $hubData = HelpingDBMethods::getHubDatafromMemberID($commentData['c-memberid']);
    	$backgroundID = HelpingDBMethods::GetBackgroundImageID($hubData['h-hubID']);
	} else {
	    $backgroundID = HelpingDBMethods::GetBackgroundImageID($origMember);
	}
	
	$backgroundURL = HelpingDBMethods::GetImageData($backgroundID, 'member', 'thumbnail');
	$imgStringOrig = HelpingDBMethods::GetImageData($origimageID, 'member', 'thumbnail');
	$addComment = '<li class="textarearereply" id="textareareply"><textarea id="temp" onClick="$myjquery(\'#textareareply\').hide(); $myjquery(\'#textareareplybox\').show(); $myjquery(\'#comments-box-'.$cID.'\').show(); $myjquery(\'#comments-text-area-'.$cID.'\').focus();">What do you think?</textarea></li>';
	$hubComments = '<li class="textarearereplybox" id="textareareplybox"><span class="commentsBox commentsPage" id="comments-box-'.$cID.'"><textarea id="comments-text-area-'.$cID.'"></textarea><span class="CommentShow" onClick="commentShow('.$cID.')"><a onClick="inlineReply('.$storyID.',\''.$urlhex.'\', '.$cID.')" id="replytext">Comment</a></span></span></li>';
	$isPromoted=HelpingDBMethods::GetPromoted($storyID, $userID);
	$isLiked = HelpingDBMethods::GetIsStoryLiked($storyID, $userID);
	$promoCount = HelpingDBMethods::GetPromoteCount($storyID);
	if(!$isPromoted){
			$promote = "<span class='promoteLoad' onClick='promoteShow(".$storyID.")'><a onClick='PromoteStory(".$storyID.", \"".$urlhex."\")' class='promolink' id='promote-story-link-".$storyID."'>Promote</a></span>";
	} else {
			$promote = '<span class="promoted">Promoted!</span>';
	}
	if(!$isLiked)
	{
		$interesting = '<span class="Interesting" onclick="LikeStory('.$storyID.',\''.$urlhex.'\')" id="story-'.$storyID.'">Add to Fav Stream</span>';
		
	} else {
		$interesting = '<span class="Interesting" id="done">Added to Fav Stream!</span>';
	}
	
	if($promoCount==1&&$isPromoted==True){
		$promoteCount="You promoted this story.";
	} else if ($promoCount==1){
		$promoteCount="1 person has promoted this story so far.";
	} else if($promoCount==0){
		$promoteCount="Be the first to promote this story.";
	} else {
		$promoteCount=$promoCount." people have promoted this story so far.";
	}
	
	
	Page::Page_Load();	
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>kahub</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type="text/javascript" src="../js/jquery.idle-timer.js"></script>
				<script src="../js/jquery.bxSlider.min.js" type="text/javascript"></script>
				
				  <script type="text/javascript"> 
				  
				function commentShow(commentID){
					console.log("commenting");
					var comment = $myjquery(\'#comments-text-area-\'+commentID).val();
					$myjquery("#comments-box-"+commentID).html(\'<div class="commentsDone" id="done">\'+comment+\'</div>\');
				}	
						function restateShow(storyID){
							console.log("restating");
							$myjquery("#restate-Story-Link-"+storyID).html(\'<span class="restated" id="done">Restated!</span>\');

						}
						function promoteShow(storyID){
								console.log("promoting");
								$myjquery("#promote-story-link-"+storyID).effect("highlight", {}, 3000);
								$myjquery("#promote-story-link-"+storyID).html(\'<span class="promoted" id="done">Promoted!</span>\');

						}
						function readLater(storyID, url){
								console.log("liking");
								$myjquery("#story-"+storyID).html(\'<span class="Interesting" id="done">Added to Favs Stream!</span>\');

								}			
				  </script>
				

				    <style type="text/css" media="screen">
				    a{
				      color: #08C;
				      text-decoration: none;
				    }
				    ';
				    if($backgroundURL!="http://www.kahub.com/images/website/photo-1.jpg"){
                	    echo 'body{
                            background: url("'.$backgroundURL.'") !important;
                        }    
                        div.main-content {
                                -webkit-box-shadow: 0px 0px 13px 3px #5c5c5c;
                                -moz-box-shadow: 0px 0px 13px 3px #5c5c5c;
                                box-shadow: 0px 0px 13px 3px #5c5c5c;
                            }';
                	};
                	echo '</style>';
	echo "	
			";
	echo '
	<link rel="stylesheet" type="text/css" href="../css/style-profile.css" />';
			
	echo '	</head>';
	echo '	<body>';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">';
	echo '				<div class="main-content">';
	echo 							'<div id="sharing">';
	echo 								'<li>'.$promote.' | '.$promoteCount.'</li>';
	echo 								'<li><span class=\'read\' onClick="readLater('.$storyID.')"> '.$interesting.'</span></li>';
	echo 							'</div>';
	echo '					<div class="storyTextWrap">';
	echo '						<div id="storyTitlecomments"><a href="http://www.kahub.com/anyShare/xd_check.php?rURL='.$storyData['s-url'].'" onClick="StoryClick('.$storyID.')">';
	echo 							$storyData['s-title'];
	echo 							'</a>';

	echo 							'<div id="storyDescripComments">';
	echo 								$snippet;
	echo 							'</div>';
	echo 					'</div>';
	echo '<div class="origComment">';
	echo '<a href="http://www.kahub.com/l/profile.php?user='.$origMember.'"><img src = "' . $imgStringOrig . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/> '.$origName.'</a><div></div>';
	echo $origComment;
	if($reply!=0){
		echo '<div class="reply commentsPage"><span class="replyuname"><a href="http://www.kahub.com/l/profile?user='.$replyMemberID.'"><img src=' . $replyImgSrc . '>'.$replyname.'</a></span>: <span class="replycomment">"'.$replyCommentText.'"</span></div>';
	}
	echo '</div>';
	echo "<div class='clear'></div>";
	echo '					<div class="commentsWrap">';
	echo $comments;
	echo $addComment;
	echo $hubComments;
	echo '</div>';
	
	//Home Page Content Area Ends				    
	echo '				</div>';
	echo '			</div>';
	echo			MasterPage::GetFooter();
	echo '	    </div>';
	echo '	</body>';
	echo '</html>';
}

class Page
{
	function Page_Load()
	{
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db($GLOBALS['databaseName'], $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$noOfFriends = HelpingDBMethods::GetNoOfFriends($userNum);
				$imageID = HelpingDBMethods::GetMemberImageID($userNum);
				
									
					//Page::SetMainContent();
					Page::SetSideBarContent();	
					//StoryRanking::SetStoryRanking();					
					
			}
			mysql_close($DBConnection);
		}
		
		
	}
	
	
	function SetSideBarContent()
	{
		$GLOBALS['LiteralSideBarContent'] = '<div class = "side-bar-wrap">
												<span class = "side-bar-shadow">' . 
													SideBar::MemberProfileInformation().
												'</span>
											 </div>
											 <div class = "side-bar-wrap" style = "margin-top:30px;">
												<span class = "side-bar-shadow">
													' . SideBar::FacebookFriendsWidget() . '
												</span>
											 </div>';
	}
	
	
	
	
}


?>