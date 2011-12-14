<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';

$user = new flexibleAccess();

	$userNum = $_GET['user'];
	if ($userNum==""){
		$userNum=$GLOBALS['user']->userID;
	}
	require_once '../AppCode/MasterPageScript.php';
	require_once '../AppCode/SideBarScript.php';
	$currUser = $GLOBALS['user']->userID;
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	$fname = MemberDBMethods::GetUserName($userNum);
	$hubName = MemberDBMethods::getHubName($userNum);
	$isHub = MemberDBMethods::isHub($userNum);
	$first = MemberDBMethods::GetFirstname($userNum);
	$noOfFriends = HelpingDBMethods::GetNoOfFriends($userNum);
	$friend = HelpingDBMethods::isMyFriend($currUser,$userNum);

	if ($isHub!=1){
		header('Location:http://www.kahub.com/l/profile?user='.$userNum);	
	} 
	
	$friends = HelpingDBMethods::GetFriendsProfile($userNum);
	$replyText = $_POST['profile-comment-box'];
	if ($replyText!=""){
		$cid = $_POST['c-id'];
		HelpingDBMethods::UIHoverboxReplyPost($asscText, $curl, $cid, $replyText);
	}
	$key= md5($hubName);
	$keyFeatured2 = "featured";
	$keyFeatured = $key.$keyFeatured2;
	$keyStories2 = "storiesafeadadfse";
	$keyStories = $key.$keyStories2;
	$keyWiki2 = "wikitopic";
	$keyWiki = $key.$keyWiki2;
	$keyDDG2 = "ddgtopic";
	$keyDDG = $key.$keyDDG2;
	$memcache = new Memcache;
	$memcache->connect('localhost', 11211) or die ("Could not connect"); //connect to memcached server
	$result = $memcache->get($keyFeatured);
	if($result == null) {
		$featuredArrayCache = HelpingDBMethods::GetStoriesForFeatured($hubName);
		arsort($featuredArrayCache, SORT_NUMERIC);
		$memcache->set($keyFeatured, $featuredArrayCache, false, 1800);
		reset($featuredArrayCache);
		$first_key = key($featuredArrayCache);
		if($first_key!=""){
			HelpingDBMethods::hasPublished($first_key, $userNum);
		}
	}
	$resultStories = $memcache->get($keyStories);
	if($resultStories == null) {
		$storiesCache = HelpingDBMethods::LatestStoriesPersonArray($fname);
		$memcache->set($keyStories, $storiesCache, false, 600);
	}
	$resultWiki = $memcache->get($keyWiki);
	if($resultWiki == null) {
		$wikiCache = HelpingDBMethods::wikidefinition($hubName);
		$memcache->set($keyWiki, $wikiCache, false, 7200);
	}
	$resultDDG = $memcache->get($keyDDG);
	if($resultDDG == null) {
		$ddgCache = HelpingDBMethods::duckDuckGo($hubName);
		$memcache->set($keyDDG, $ddgCache, false, 7200);
	}
	$featuredArray = $memcache->get($keyFeatured);
	$storiesArray = $memcache->get($keyStories);
	$wikiDef = $memcache->get($keyWiki);
	$ddg = $memcache->get($keyDDG);
	$stories = HelpingDBMethods::GetLatestStoriesPerson($storiesArray);
	$featStories = HelpingDBMethods::showFeaturedStories($featuredArray);
	$wikiImg = str_replace($wikiDef[4]."px", "200px", $wikiDef[0]);
	if($noOfFriends==0){
		$noFollowers = 'Be the first to follow <b>'.$hubName.'</b>';
	} else if($noOfFriends==1){
		$noFollowers = '<b>1</b> Follower';
	} else {
		$noFollowers = '<b>'.$noOfFriends.'</b> Followers';
	}
	if($ddg[0]==""){
		$descripText=$wikiDef[1];
		$dFrom = "";
	} else {
		$descripText=$ddg[0];
		$dFrom = "; and <a href='http://www.duckduckgo.com' target='_blank'>DuckDuckGo</a>";
	}
	$followers = HelpingDBMethods::GetFollowersNoName($userNum);
	


	Page::Page_Load();	
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>kahub | '.$fname.' Hub</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type="text/javascript" src="../js/jquery.idle-timer.js"></script>
				
				<script type="text/javascript"> _kmq.push([\'record\', \'Viewed Topic Hub\']);</script>
        		<script type="text/javascript"> _kmq.push([\'record\', \'Viewed Topic Hub '.$userNum.'\']);</script>
				  <script type="text/javascript"> 

				
				  </script>
				

				    <style type="text/css" media="screen">
				    a{
				      color: #3E5681;
				      text-decoration: none;
				    }
				  </style>



				<script type = "text/javascript">
					

					
					
					
					
					function replybox($boxid){
						
						var text = document.getElementById($boxid);
						if (text.value=="What do you think?"){
							text.value="";
						}
						
						if (text.value==""){
							text.rows = "2";
						}
						
						
					}
					
					
				
					
					
					function FitToContent(id, maxHeight)
					{
				
					   var text = id && id.style ? id : document.getElementById(id);
					   
					a = text.value.split("\n");
					b=1;
					for (x=0;x < a.length; x++) { if (a[x].length >= text.cols) b+= Math.floor(a[x].length/text.cols);
					}
					b+= a.length;
					if (b > text.rows) text.rows = b;
					   
					}
					
					
					
				
					
				</script>
				';
	echo "		<script type='text/javascript' src='../js/bridge/bridge.js'></script>
			<!--[if lt IE 9]>
			  <script type='text/javascriptt src='../js/excanvas/excanvas.js'></script>
			<![endif]-->

			
			
			";
	echo '	
	<link rel="stylesheet" type="text/css" href="../css/style-profile.css" />';
			
	echo '	</head>';
	echo '	<body>
	
		    <script type="text/javascript" charset="utf-8">
            function commentShow(commentID){
				console.log("commenting");
				var comment = $myjquery(\'#comments-text-area-\'+commentID).val();
				$myjquery("#comments-box-"+commentID).html(\'<div class="commentsDone" id="done">\'+comment+\'</div>\');
			}
			
			function promoteShow(storyID){
					console.log("promoting");
					var currPromo = document.getElementById("promo-num-"+storyID).innerHTML;
					var newPromo = parseInt(currPromo)+1;
					$myjquery("#promo-num-"+storyID).effect("highlight", {}, 3000);
					$myjquery("#promo-num-"+storyID).html("<span class=\'promo-num promotednum\'>"+newPromo+"</span>");
					$myjquery("#promote-story-link-"+storyID).html(\'<span class="promoted" id="done">Promoted!</span>\');

			}

		    </script>
		
		</body>';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">';
	echo '				<div class="main-content">';
	if($wikiImg!=""){
		echo '<div class="profile-pic"><img alt="" src="'.$wikiImg.'" height = "156px" /></div>';
	}
	echo '<div class="big-name thub">';
	//Home Page Content Area Starts
	echo $fname.' Hub';
	if ($friend!=true){
					echo '<span class="addsource thub"><input type="button" value="    Follow" onclick="Followhub('.$userNum.');" class="btn-follow"></span>';
	} else {
	    echo ' <a class="unfollowhub" onClick="unfollowHub('.$userNum.')">Unfollow</a>';
	}
	echo '<div class="follower-count">';
	echo $noFollowers;
	echo '</div>';
	echo '<div class="followers">';
	echo $followers;
	echo '</div>';
	echo '</div>';

		echo '<div class="wikiDescrip">';
		echo '<div class="wiki-source">';
		echo 'From <a href="http://www.wikipedia.org" target="_blank">Wikipedia</a>, the free encyclopedia'.$dFrom.' <a class="viewonwiki" href="'.$wikiDef[2].'" target="_blank">View on Wikipedia</a></div>';
		echo $descripText;
		echo '</div>';
		if($ddg[1]!=""){
			echo '<div class="officialSite">';
			echo ' <a href="'.$ddg[1].'" target="_blank">'.$ddg[2].'</a></div>';	
		}
		
		if($featStories!=""){
			echo '<div class="featured-stories">';
			echo $featStories;
			echo '</div>';
			echo '<div class="profile-latest"><h7>Latest stories</h7></div>';
			echo $stories;
		} else {
			echo '<div class="noStories">';
			echo 'It dosen\'t look like there are any stories about '.$hubName.' yet :(. Why don\'t ya be a leader and share one!?!';
			echo '</div>';
		}

	
	//Home Page Content Area Ends				    
	echo '				</div>';
	echo '			</div>';
	echo			MasterPage::GetFooter();
	echo '	    </div>';
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