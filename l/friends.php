<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';

$user = new flexibleAccess();
	require_once '../AppCode/MasterPageScript.php';
	require_once '../AppCode/SideBarScript.php';
	$currUser = $GLOBALS['user']->userID;
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$handle = $_GET['user'];
	if($handle==""){
	    $hubMemberData = HelpingDBMethods::getHubInfoFromMemberID($currUser);
	    $handle = $hubMemberData['h-handle'];
	}
	$hubData = HelpingDBMethods::GetHubInfo($handle);
	$userNum = $hubData['h-hubID'];
	$name = MemberDBMethods::GetUsername($hubData['h-memberID']);
	$LiteralHeader = MasterPage::GetHeader();
	$isHub = MemberDBMethods::isHub($userNum);
	$follow = HelpingDBMethods::isMyFriend($currUser,$userNum);
	$pal = HelpingDBMethods::isMyFriend($currUser,$hubData['h-memberID']);
	if ($replyText!=""){
		$cid = $_POST['c-id'];
		HelpingDBMethods::UIHoverboxReplyPost($asscText, $curl, $cid, $replyText);
	}
	$imageID = HelpingDBMethods::GetMemberImageID($userNum);
	if($imageID==0){
		$imageID = HelpingDBMethods::GetMemberImageID($hubData['h-memberID']);
	}
	$imageURL = HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail');

	if($hubData['h-memberID']==$currUser){
		$myHub=true;
		$edit = "edit_area";
	} else {
		$myHub=false;
		$edit = "";
	}
	$noFriends = HelpingDBMethods::GetNoOfFriends($hubData['h-memberID']);

	$interests = HelpingDBMethods::GetFriendsNoNameAll($hubData['h-memberID']);
	$rs1 = HelpingDBMethods::getNoRestate($userNum);
	$rs2 = HelpingDBMethods::getNoRestate($hubData['h-memberID']);

	if($follow){
		$friend = true;
	} 
	if($pal){
		$friend = true;
		$unfollowID = $hubData['h-memberID'];
		$unfollowText ="Remove from friends";
	} else {
		$unfollowID = $userNum;
		$unfollowText ="Unfollow";
	}

	Page::Page_Load();	
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>'.$name.' (/'.$handle.') on kahub</title>';
	echo		MasterPage::GetHeadScript();
	echo '				 
				

				    <style type="text/css" media="screen">
				    a{
				      color: #3E5681;
				      text-decoration: none;
				    }
				  </style>
				 
				';
	echo "		<script type='text/javascript' src='../js/bridge/bridge.js'></script>
				<script type='text/javascript' src='../js/parseURL.js'></script>
			<!--[if lt IE 9]>
			  <script type='text/javascriptt src='../js/excanvas/excanvas.js'></script>
			<![endif]-->

			<script type='text/javascript' src='../js/spinners/spinners.js'></script>
			
			";
	echo '	<link rel="stylesheet" type="text/css" href="../css/tipped.css" />
	<link rel="stylesheet" type="text/css" href="../css/style-profile.css" />';
			
	echo '	</head>';
	echo '	<body onLoad="$myjquery(\'#help\').hide(); $myjquery(\'#commentArea\').hide();">

		    <script type="text/javascript" charset="utf-8">

			function promoteShow(storyID){
					console.log("promoting");
					var currPromo = document.getElementById("promo-num-"+storyID).innerHTML;
					var newPromo = parseInt(currPromo)+1;
					$myjquery("#promo-num-"+storyID).effect("highlight", {}, 3000);
					$myjquery("#promo-num-"+storyID).html("<span class=\'promo-num promotednum\'>"+newPromo+"</span>");
					$myjquery("#promote-story-link-"+storyID).html(\'<span class="promoted" id="done">Promoted!</span>\');

			}
			function commentShow(commentID){
				console.log("commenting");
				var comment = $myjquery(\'#comments-text-area-\'+commentID).val();
				$myjquery("#comments-box-"+commentID).html(\'<div class="commentsDone" id="done">\'+comment+\'</div>\');
			}
			function commentHubShow(){
				console.log("commentinghub");
				var comment = $myjquery(\'#comment\').val();
				$myjquery(\'#commentArea\').html(\'<div class="commentsDone" id="done">\'+comment+\'</div>\');
			}
			
			function urlClick(){
				$myjquery(\'#help\').show();
			}

		    </script>
		';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">';
	echo '				<div class="main-content">';
	if($handle=="p"){
		echo "This hub does not exist.";
	} else {
		echo '<div class="profile-picFriends" data-width="200" data-height="200" data-type="jpg" data-crop="true" data-quality="70"><a href="http://www.kahub.com/'.$handle.'"><img alt="" src="'.$imageURL.'" height = "156px" /></a></div>';
	echo '<div class="big-nameFriends"><a href="http://www.kahub.com/'.$handle.'">';
	//Home Page Content Area Starts
	echo $name;
	echo '</a>';
	if ($friend!=true){
					echo '<span class="addsource"><input type="button" value="    Follow" onclick="Followhub('.$userNum.');" class="btn-follow"><input type="button" value="    Friend" onclick="AddFriendFromSearch('.$hubData['h-memberID'].');" class="btn-add-prof"></span>
					<div class="about"><div id="followdesc">Get all their public updates</div><div id="frienddesc">Get all their updates</div></div>';
	}
	echo '<div class="handleFriends">';
	echo '/'.$handle;
	echo '</div>';
	echo '</div>';

		
	
		if($interests!=""){
		    echo '<div id="friendsShow">'.$name.' has '.$noFriends.' friends</div>';
			echo '<div class="clr"></div>';
			echo $interests;
			echo '<div class="clear"></div>';
			echo '<div class="clr"></div>';
			echo '<div class="clr"></div>';
						
		} else {
			echo '<div class="noStories">';
			echo 'It doesn\'t look like there are any stories yet!';
			echo '</div>';
		}
		
	}

	
	//Home Page Content Area Ends				    
	echo '				</div>';
	echo '			</div>';
	echo '	    </div>';
	echo			MasterPage::GetFooter();
	echo '	</body>';
	echo '</html>';


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