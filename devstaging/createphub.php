<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/HelpingDBMethods.php';
	require_once '../AppCode/MasterPageScript.php';
	require_once '../AppCode/SideBarScript.php';
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	
    
	
	

	Page::Page_Load();	
	
	echo '<!DOCTYPE html>';
	echo '<html>';
	echo '	<head>';
	echo '		<title>Get Started on kahub</title>';
	echo		MasterPage::GetHeadScript();
	echo '		
					<style type="text/css" media="screen">
				    a{
				      color: #3E5681;
				      text-decoration: none;
				    }
				  </style>
				'; 
	echo '	<link rel="stylesheet" type="text/css" href="../css/tipped.css" />
	<link rel="stylesheet" type="text/css" href="../css/style-profile.css" />';
			
	echo '	</head>';
	echo '	<body>

		';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">';
	echo '				<div class="main-content getstarted">';
	$signupInner = <<<HTML
	<div id="getStartedWrap">
		<ul class="getStarted">
			<li><div class="topHeaeder">What do you wanna be called?</div><br>
				<div id="slash">/</div><input type="text" name="handle" id="handle" onBlur="checkUser()"><br>
				<div id="check"></div><br>
				<div class="help">Enter what you want your username (handle) to be. These are used around the site to identify you</div>
				<input id="goodHandle" value="0" style="display: none"/> 
			</li>
			
			<li>
				<div id="getStartedBtn"><a class="button getStarted" onClick="saveHandle()">Get Started!</a></div>
			</li>
	
HTML;
echo $signupInner;
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