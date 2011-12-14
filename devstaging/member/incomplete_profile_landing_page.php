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
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	Page::Page_Load();

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>Connichiwah : Complete Your Profile</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type = "text/javascript">
					//var is_chrome = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
					//if(is_chrome)
					//{
					//	alert("hi");
					//}
					var isInstalled = false;
					$myjquery(document).ready(function(){					
						$myjquery("script").each(function() {
							if($myjquery(this).attr("src") == rootURL + "extention/connichiwah-extention.js")
							{
							   isInstalled = true; 
							}
						});
						if(isInstalled == false)
						{
							$myjquery("#check-extention").css("background", "url(http://www.connichiwah.com/images/website/cross-mark.png) no-repeat");
							$myjquery("#check-extention").css("background-position", "380px 50%");	
						}
					});	
				</script>';
	echo '	</head>';
	echo '	<body>';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">
						<div class="side-bar">';
	echo					$LiteralSideBarContent;
	echo '				</div>';	
	echo '				<div class="main-content">';
							//Home Page Content Area Starts
	echo					$LiteralContent;
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
				Page::SetMainContent();
				Page::SetSideBarContent();				
			}
			mysql_close($DBConnection);
		}
	}
	
	function SetMainContent()
	{
		$rootURL = Settings::GetRootURL();
		$userID = $GLOBALS['user']->userID;
		$myName = MemberDBMethods::GetUserName($userID);
		$noOfFriends = HelpingDBMethods::GetNoOfFriends($userID);
		$imageID = HelpingDBMethods::GetMemberImageID($userID);
		$memberImage = HelpingDBMethods::GetImageData($imageID, 'member');
		
		
		$friendsTickMark = '';
		$imageTickMark = '';
		$profileCompleteString = '<img alt="" src="' . $rootURL . 'images/website/tick-mark-big.jpg" />
									<span>Profile Complete</span>';
		if($noOfFriends < 3)
		{
			$friendsTickMark = ' style = "background:url(' . $rootURL . 'images/website/cross-mark.png) no-repeat;background-position: 350px 50%;"';
		}
		if($imageID == 0)
		{
			$imageTickMark = ' style = "background:url(' . $rootURL . 'images/website/cross-mark.png) no-repeat;background-position: 280px 50%;"';
		}
		if($noOfFriends < 3 || $imageID == 0)
		{
			$profileCompleteString = '<img alt="" src="' . $rootURL . 'images/website/cross-mark-big.png" />
					<span>Profile In Complete</span>';
		}
		$GLOBALS['LiteralContent'] = <<<HTML
			<h1>{$myName}: Welcome to connichiwah!</h1>
            <ul>
            	<li class="li-1">
                	<h2 {$friendsTickMark}>Find friends already on connichiwah</h2>
                	<input type = "hidden" id = "member-id" value = "0" />
                    <input type="text" id = "txt-freind-name" value="Type in their name or email address" class="email-type" onblur="WaterMark(this, event, 'Type in their name or email address'); hideSuggestionBox();" onfocus="WaterMark(this, event, 'Type in their name or email address');" onkeyup="GetUserNameSuggestions(this.value)"/>
                    <input type="button" value="Add" class="btnAddFriend" onclick = "AddFriend()" />
                    <div class="suggestionsBox" id="suggestions" >
						<div class="suggestionList" id="autoSuggestionsList" style="display: none;">&nbsp;</div>
					</div>
					
                </li>
                <li class="li-2">
            		<h2 {$imageTickMark}>Upload a photo of yourself</h2>
					<img alt="" src="{$memberImage}" height = "156px" />
					<a href="{$rootURL}member/Registration.php?action=2"><img alt="" src="{$rootURL}images/website/photo-upload.jpg" /></a>
                </li>
                <li class="li-3">
                	<h2 id = "check-extention">Get the connichiwah browser extension</h2>
                    <a href="{$rootURL}member/Registration.php?action=3"><img alt="" src="{$rootURL}images/website/get-it-now-btn.jpg" /></a>
                    <h3>This will allow you to conversate with your friends all over the web</h3>
                    <div class="cl"></div>
                    <p>
                    	We respect your privacy.This extension will not provide connichiwah, or any of it's affilliates	any information about you at all.Not even 
                        your IP Address.'Cause that's just not cool.
                    </p>
                </li>
                <li class="li-4">
                	<h2>Go out and comment on some stuff!</h2>
                    <h3>Try <a style = "text-decoration:none; color: #344E7B" href="{$rootURL}extention/test/test.html"><span class = "heavy">This</span></a> for starters</h3>
                </li>
                <li class="li-5">
                    <a href="{$rootURL}">
						{$profileCompleteString}
                    </a>    
                </li>
            </ul>
HTML;
	}
	
	function SetSideBarContent()
	{
		$GLOBALS['LiteralSideBarContent'] = SideBar::MemberProfileInformation();
	}
}
?>