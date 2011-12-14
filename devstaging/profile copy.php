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
	$userNum = $_GET['user'];
	if ($userNum==""){
		$userNum=$GLOBALS['user']->userID;
	}
	require_once '../AppCode/MasterPageScript.php';
	require_once '../AppCode/SideBarScript.php';
	require_once '../AppCode/StoryRanking.php';
	require_once '../AppCode/URLKeyWordExtraction/URLKeyWordExtraction.php';
	$currUser = $GLOBALS['user']->userID;
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	$fname = MemberDBMethods::GetUserName($userNum);
	$first = MemberDBMethods::GetFirstname($userNum);
	$CommentData = HelpingDBMethods::GetMostRecentStoryData($userNum);
	$CommentText = $CommentData['c-text'];
	$storyID = $CommentData['c-StoryID'];
	$commentID = $CommentData['c-id'];
	$asscText = $CommentData['c-a-t'];
	$StoryData = HelpingDBMethods::GetStoryData($storyID);
	$storyTitle = $StoryData['s-title'];
	$storyURL = $StoryData['s-url'];
	$imageID = HelpingDBMethods::GetMemberImageID($userNum);
	$noOfFriends = HelpingDBMethods::GetNoOfFriends($userNum);
	$friend = HelpingDBMethods::isMyFriend($currUser,$userNum);
	$isMyFriend = HelpingDBMethods::isMyFriend($currUser, $userNum);
	$isHisFriend = HelpingDBMethods::isMyFriend($userNum, $currUser);
	if($isMyFriend && $isHisFriend)
	{
		$friendTie = true;
	}else
	{
		$friendTie = false;

	}
	
	$isHub = MemberDBMethods::isHub($userNum);
	if ($isHub!=0){
		header('Location:http://www.kahub.com/l/hub?user='.$userNum);	
	}
	
	
	$memberImage = HelpingDBMethods::GetImageData($imageID, 'member');
	$friends = HelpingDBMethods::GetFriendsProfile($userNum);
	$noBadges = HelpingDBMethods::GetnoOfBadges($userNum);
	$noComments = HelpingDBMethods::GetNoComments($userNum);
	$trust = HelpingDBMethods::GetFriendTrust($userNum);
	$stories = HelpingDBMethods::GetLatestStoriesProfile(0, 30, $userNum);
	$badges = HelpingDBMethods::GetBadges($userNum, "profile", 7, 0);
	$replyText = $_POST['profile-comment-box'];
	if ($replyText!=""){
		$cid = $_POST['c-id'];
		HelpingDBMethods::UIHoverboxReplyPost($asscText, $curl, $cid, $replyText);
	}
	
	
	Page::Page_Load();	
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>kahub | '.$fname.'</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type="text/javascript" src="../js/jquery.idle-timer.js"></script>
				<script src="../js/jquery.bxSlider.min.js" type="text/javascript"></script>
				
				  <script type="text/javascript"> 
				  <!--
				  var BrowserDetect = {
				  	init: function () {
				  		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
				  		this.version = this.searchVersion(navigator.userAgent)
				  			|| this.searchVersion(navigator.appVersion)
				  			|| "an unknown version";
				  		this.OS = this.searchString(this.dataOS) || "an unknown OS";
				  	},
				  	searchString: function (data) {
				  		for (var i=0;i<data.length;i++)	{
				  			var dataString = data[i].string;
				  			var dataProp = data[i].prop;
				  			this.versionSearchString = data[i].versionSearch || data[i].identity;
				  			if (dataString) {
				  				if (dataString.indexOf(data[i].subString) != -1)
				  					return data[i].identity;
				  			}
				  			else if (dataProp)
				  				return data[i].identity;
				  		}
				  	},
				  	searchVersion: function (dataString) {
				  		var index = dataString.indexOf(this.versionSearchString);
				  		if (index == -1) return;
				  		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
				  	},
				  	dataBrowser: [
				  		{
				  			string: navigator.userAgent,
				  			subString: "Chrome",
				  			identity: "Chrome"
				  		},
				  		{ 	string: navigator.userAgent,
				  			subString: "OmniWeb",
				  			versionSearch: "OmniWeb/",
				  			identity: "OmniWeb"
				  		},
				  		{
				  			string: navigator.vendor,
				  			subString: "Apple",
				  			identity: "Safari",
				  			versionSearch: "Version"
				  		},
				  		{
				  			prop: window.opera,
				  			identity: "Opera"
				  		},
				  		{
				  			string: navigator.vendor,
				  			subString: "iCab",
				  			identity: "iCab"
				  		},
				  		{
				  			string: navigator.vendor,
				  			subString: "KDE",
				  			identity: "Konqueror"
				  		},
				  		{
				  			string: navigator.userAgent,
				  			subString: "Firefox",
				  			identity: "Firefox"
				  		},
				  		{
				  			string: navigator.vendor,
				  			subString: "Camino",
				  			identity: "Camino"
				  		},
				  		{		// for newer Netscapes (6+)
				  			string: navigator.userAgent,
				  			subString: "Netscape",
				  			identity: "Netscape"
				  		},
				  		{
				  			string: navigator.userAgent,
				  			subString: "MSIE",
				  			identity: "Explorer",
				  			versionSearch: "MSIE"
				  		},
				  		{
				  			string: navigator.userAgent,
				  			subString: "Gecko",
				  			identity: "Mozilla",
				  			versionSearch: "rv"
				  		},
				  		{ 		// for older Netscapes (4-)
				  			string: navigator.userAgent,
				  			subString: "Mozilla",
				  			identity: "Netscape",
				  			versionSearch: "Mozilla"
				  		}
				  	],
				  	dataOS : [
				  		{
				  			string: navigator.platform,
				  			subString: "Win",
				  			identity: "Windows"
				  		},
				  		{
				  			string: navigator.platform,
				  			subString: "Mac",
				  			identity: "Mac"
				  		},
				  		{
				  			   string: navigator.userAgent,
				  			   subString: "iPhone",
				  			   identity: "iPhone"
				  	    },
				  		{
				  			string: navigator.platform,
				  			subString: "Linux",
				  			identity: "Linux"
				  		}
				  	]

				  };
				  BrowserDetect.init();


				  // -->				
				  </script>
				

				    <style type="text/css" media="screen">
				    a{
				      color: #5370A6;
				      text-decoration: none;
				    }
				  </style>
				  <!--[if IE ]>
				<link rel="stylesheet" href="normal.css" type="text/css" media="screen" charset="utf-8"> 
				<![endif]-->


				  <style type="text/css" media="screen and (min-width: 1071px)">
				    .barupgrade{
				      width: 100%;
				      height: 50px;
				      background-color: #F8F9DE;
				      border: 1px solid #F7F797;
				      color: #333;
				      font: 12pt "Helvetica", "Arial", sans-serif;

				    }
				    #errorhead{
				      font: 20pt "Helvetica", "Arial", sans-serif;
				      font-weight: bold;
				      float: left;
				      margin-left: 5px;
				      vertical-align: middle;
				    }
				    #errorhead .error{
				      margin: 8px
				    }
				    #errorbody{
				      float: right;
				      margin: 5px 50px 10px 0px;
				    }

				    #consider{
				      font: 15pt "Helvetica", "Arial", sans-serif;
				    }
				  </style>
				  <style type="text/css" media="screen and (min-width: 770px) and (max-width: 1070px)">
				    .barupgrade{
				      width: 100%;
				      height: 50px;
				      background-color: #F8F9DE;
				      border: 1px solid #F7F797;
				      color: #333;
				      font: 10.5pt "Helvetica", "Arial", sans-serif;
				    }
				    #errorhead{
				      font: 15pt "Helvetica", "Arial", sans-serif;
				      font-weight: bold;
				      float: left;
				      margin-left: 5px;
				      vertical-align: middle;
				    }
				    #errorhead .error{
				      margin: 10px
				    }
				    #errorbody{
				      float: right;
				      margin: 7px 50px 10px 0px;
				    }
				    #consider{
				      font: 13pt "Helvetica", "Arial", sans-serif;
				    }
				  </style>

				  <style type="text/css" media="screen and (max-width: 769px)">
				    .barupgrade{
				      width: 100%;
				      height: 120px;
				      background-color: #F8F9DE;
				      border: 1px solid #F7F797;
				      color: #333;
				    }
				    #errorhead{
				      margin-left: 5px;
				      margin-top: 5px;
				    }
				    #errorhead .error{
				      font: 15pt "Helvetica", "Arial", sans-serif;
				      font-weight: bold;
				    }
				    #errorbody{
				      margin-left: 5px;
				      margin-top: 5px;
				      font: 12pt "Helvetica", "Arial", sans-serif;
				    }

				    #consider{
				      margin-top: 5px;
				      font: 13pt "Helvetica", "Arial", sans-serif;
				    }

				  </style>
				<script type = "text/javascript">
					$myjquery(document).ready(function(){
						$myjquery("#story-no-1").click();
						$myjquery(window).scroll(function() {
							//var bodyHeight = $myjquery("body").height();
							var windowHeight = $myjquery(window).height();
							var windowOffset = window.pageYOffset;
							if(windowOffset + windowHeight + 500 > $myjquery(".more").position().top)
							{
								//alert($myjquery(".more").position().top);
								$myjquery(".more").click();
							}
							
						});
						
					});
					function externalLinks()
					{
					  if (!document.getElementsByTagName) return;
					  var anchors = document.getElementsByTagName("a");
					  for (var i=0; i<anchors.length; i++)
					  {
					      var anchor = anchors[i];
					      if(anchor.getAttribute("href"))
							anchor.target = "_blank";
					  }
					}
					
					
					
					
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

			<script type='text/javascript' src='../js/spinners/spinners.js'></script>
			<script type='text/javascript' src='../js/tipped/tipped.js'></script>
			";
	echo '	<link rel="stylesheet" type="text/css" href="../css/tipped.css" />
	<link rel="stylesheet" type="text/css" href="../css/style-profile.css" />';
			
	echo '	</head>';
	echo '	<body>
		<!--[if lt IE 7]>
		  <div class="barworst">
		    <div id="errorhead"><div class="error">You are using an outdated browser</div></div><div id="errorbody">You are using quite possibly the worst web browser in history. Seriously.<br><div id="consider">Upgrade to a modern browser such as <a href="http://www.apple.com/safari">Safari</a>, <a href="http://www.google.com/chrome">Chrome</a>, or <a href="http://www.mozilla.com/firefox">Firefox</a></div></div>
		  </div>
		  </div>

		  <![endif]-->

		  <!--[if IE 7]>
		    <div class="barworst">
		      <div id="errorhead"><div class="error">You are using an outdated browser</div></div><div id="errorbody">Your browser is not supported and is out of date.<br><div id="consider">Upgrade to a modern browser such as <a href="http://www.apple.com/safari">Safari</a>, <a href="http://www.google.com/chrome">Chrome</a>, or <a href="http://www.mozilla.com/firefox">Firefox</a></div></div>
		    </div>
		    </div>

		    <![endif]-->


		  <!--[if gte IE 8]>
		    <div class="barworst">
		      <div id="errorhead"><div class="error">Your browser is not supported</div></div><div id="errorbody">The browser you are currently using will not give you the best connichiwah experience. <br><div id="consider">Consider switching to a better browser such as <a href="http://www.apple.com/safari">Safari</a>, <a href="http://www.google.com/chrome">Chrome</a>, or <a href="http://www.mozilla.com/firefox">Firefox</a></div></div>
		    </div>
		    </div>

		    <![endif]-->
		    <div id="barupgrade">
		    <div class="barupgrade">
		      <div id="errorhead"><div class="error">Your browser is not up to date</div></div><div id="errorbody">The browser you are currently using has a new version out.<br><div id="consider"><a href="http://www.apple.com/safari/download">Upgrade to the latest version of Safari</a></div></div>
		    </div>
		    </div>
		    <script type="text/javascript" charset="utf-8">

		      if(BrowserDetect.browser=="Safari" && BrowserDetect.version<5 && BrowserDetect.OS!="iPhone"){
		        document.getElementById("barupgrade").style.display = "block";
		      } else{
		        document.getElementById("barupgrade").style.display = "none";

		      }

		    </script>
		
		</body>';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">';
	echo '				<div class="main-content"><div class="profile-pic"><img alt="" src="'.$memberImage.'" height = "156px" /></div>';
	echo '<div class="big-name">';
	echo "<table id='stats'>";
	echo "<thead>
			<tr>";
	echo "<th scope='col' id='commentsno' class='theader'>";
	echo '<a href="profile?user='.$userNum.'">';
	echo $noComments;
	echo '</a>';
	echo "</th>";
	echo "<th scope='col' id='sourcesno' class='theader'>";
	echo '<a href="getSources?user='.$userNum.'">';
	echo $noOfFriends;
	echo '</a>';
	echo "</th>";
	
	echo "</tr> </thead>";
	echo "<tbody>
	        <tr>";
    echo "<td><a href='profile?user=".$userNum."'>Comments</a></td>";
    echo "<td><a href='getSources?user=".$userNum."'>Sources</a></td>";

	echo "</tr></tbody>";
	echo "</table><div class='name-head'>";
	//Home Page Content Area Starts
	echo $fname;
	if($userNum<87){
		echo " <img src='founderbadgemed.jpg'/>";
	}
	echo "</div>";
	
	if ($friend!=true){
					echo '<span class="addsource"><input type="button" value="    Add as a source" onclick="AddFriendFromSearch('.$userNum.');" class="btn-add-prof"></span>';
	}
	echo '</div>';
if ($friendTie!=true){
	echo '<div class="nothing"><span class="nothing-name">'.$first.' does not share everything with everyone.</span> Add '.$first.' as a source to see what they\'re sharing.</div>';
	echo '</span><div class="profile-friends"><div class="profile-friends-title">SOURCES (';
	echo $noOfFriends;
	echo ') </div><ul class="friends" id="profilesslide">';
	echo $friends;

	echo '</ul></div> <div class="profile-badges"><div class="profile-badges-title">BADGES (';
	echo $noBadges;
	echo ')</div>';
	echo $badges;
	echo '<span class="viewall">View All '.$noBadges.'</span>';
} else if ($friendTie=true)  {

	
		if ($CommentText!=""){
			$justsaid='<span class="profile-justsaid">just said <span class"profile-comment">'.$CommentText.'</span> about <span class="profile-title"><a href="'.$storyURL.'">'.$storyTitle.'</a>';
		} else {
			$justsaid='<div class="nothing"><span class="nothing-name">'.$first.' hasn\'t shared anything yet.</span> Why don\'t \'cha help \'em out by sharing something with them personally? <br> You can do this by sharing something, then in the box that appears clicking on the little lock icon, then click "Share with a source", type their name, then click "Okay, done". Bada bing, bada boom! '.$first.'\'s happy.</div>';
		}
		echo $justsaid; 

		if ($trust!=""){
			$trusttext='<div class="trust">Really awesome when it comes to<span class="trusts">'.$trust.'</span></div>';
		} else {
			$trusttext='<div class="nothing"><span class="nothing-name">'.$first.' isn\'t trusted on anything yet.</span> Why don\'t ya be nice and trust them on something? <br> You can do this by clicking the "Trust" button under their profile picture in any place where they\'ve commented. Easy peasy. '.$first.' feels super good, all because of you!</div>';
		}
		echo $trusttext;
		echo '</span><div class="profile-friends"><div class="profile-friends-title"><a href="http://www.connichiwah.com/member/getSources.php?user='.$userNum.'">SOURCES (';
		echo $noOfFriends;
		echo ')</a></div><ul class="friends" id="profilesslide">';
		echo $friends;
		echo '</ul></div> <div class="profile-badges"><div class="profile-badges-title"><a href="http://www.connichiwah.com/member/getBadges.php?user='.$userNum.'">BADGES (';
		echo $noBadges;
		echo ')</a></span></div><ul id="badgesslide">';
		echo $badges;
		echo '<span class="view-all"><a href="http://www.connichiwah.com/member/getBadges.php?user='.$userNum.'">View all '.$noBadges.'</a></span></ul>';
		echo '<div class="profile-latest">Latest from '.$first.'\'S Network</div>';
		echo $stories;
} 
	
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