<?php
require_once 'access.class.php';
$user = new flexibleAccess();
require_once 'ApplicationSettings.php';
require_once 'HelpingDBMethodsNew.php';
require_once 'MemberDBMethods.php';
require_once 'Notifications.php';
require_once 'RequestQuery.php';
require_once 'MemberDBMethods.php';
$databaseName = Settings::GetDatabaseName();
$rootURL = Settings::GetRootURL();
$LiteralRegionLinks = "";
$LiteralCategoryLinks = "";

class MasterPage
{
	function GetHeadScript()
	{	
		$MemberID = $GLOBALS['user']->userID;
		//if ($MemberID!=5){
		//	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://www.kahub.com">';    
		//}
		$result = <<<Content
			
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript">
              var _kmq = _kmq || [];
              function _kms(u){
                setTimeout(function(){
                  var s = document.createElement('script'); var f = document.getElementsByTagName('script')[0]; s.type = 'text/javascript'; s.async = true;
                  s.src = u; f.parentNode.insertBefore(s, f);
                }, 1);
              }
              _kms('//i.kissmetrics.com/i.js');_kms('//doug1izaerwt3.cloudfront.net/ef708ff382fb288b639757b4f42f078092071778.1.js');
              _kmq.push(['identify', 'uid{$MemberID}']);
            </script>
			<link rel="shortcut icon" href="http://c681693.r93.cf2.rackcdn.com/favicon.ico" />
			<link type="text/css" rel="stylesheet" href="{$GLOBALS['rootURL']}css/style.css" />  
				<script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
				<script type='text/javascript' src="http://www.kahub.com/js/jquery.notifyBar.js"></script> 
			    <script type='text/javascript' src="http://c563784.r84.cf2.rackcdn.com/commontest.js"></script>
			    <script type='text/javascript' src="http://www.kahub.com/js/jquery-ui-1.8.14.custom.min.js"></script>
				<script type="text/javascript" src="http://www.kahub.com/js/superfish.js"></script>
				<script type="text/javascript" src="http://www.kahub.com/js/jquery.html5uploader.min.js"></script> 
				<link rel="stylesheet" type="text/css" href=""http://www.kahub.com/css/superfish.css" media="screen">
				
				<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css'>
				<link href='http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>          
			<link href='http://fonts.googleapis.com/css?family=Copse' rel='stylesheet' type='text/css'>
		                                                                        	

		
		  <script type="text/javascript">
		<!--
		  var pressed = 0;
		  var keys = 0;
		  var beard = false;
		  function check(e){
		    var KeyID = e.keyCode;
		    console.log(KeyID);
		    if (KeyID==112 &&pressed==0){
		      pressed =1;
		      addto(pressed);
			  console.log(pressed);
		
		    }
		    else if (KeyID==107&&pressed==1){
		      pressed=2;
		      addto(pressed);
			  console.log(pressed);
		
		    } 
		    else if(KeyID==112&&pressed==2){
		      pressed =3;
		      addto(pressed);
			  console.log(pressed);
		
		    }
		    else if(KeyID==49 && pressed ==3){
		      pressed =4;
		      addto(pressed);
			  console.log(pressed);
		
		    }
		    else if(KeyID==56 && pressed ==4){
		      pressed =5;
		      addto(pressed);
			  console.log(pressed);
		
		    }
		    else if(KeyID==54 && pressed ==5){
		      pressed =6;
		      addto(pressed);
			  console.log(pressed);
		
		    }
		    else if(KeyID==48 && pressed ==6){
		      pressed =7;
		      addto(pressed);
			  console.log(pressed);
		    } else {
			 pressed=0;
			}
		}

	
		  

		  function addto(key){
		      if (key==7){
				document.getElementById("sound_element").innerHTML= "<embed src='http://www.kahub.com/song/Noble Fraternity.mp3' hidden=true autostart=true loop=true>";
				document.getElementById("body").style.background="#C41E3A";
				document.getElementById("headnorm").style.background="#355E3B";
				beard = true;
				var images = document.getElementsByTagName('img');
				for (var i = 0; i < images.length; i++) {
					images[i].src = "../images/moore.jpeg";
				}
			}
		}
			
		    
		  document.onkeypress=check;
		//-->
		  </script>
		  <!--
		                                                       /                                   --       
		                                         `y-          `M`        y:                        ss       
		   `.-.`   `....`    .. ...`   `.``...    `     ``.`  `M`````    `  ``    `    `   ``.`    ss `.`   
		 :hmdhdh- +ddhhdmy. `NNyhhNm+  yNhhhmNy`  h-  -o+//+o``Mo+//so   y- +s   oh-  `h` /+//+s-  sh+//+y. 
		.NM:  `` /Mm.  `oMd `MM:  +Mm  hMy  `NM-  m- `m.      `M:   `N`  d: `d: :y-h` s+  `-:::ss  sh    ss 
		`mM/` .. :Mm:` .sMh `MM.  :MN  hMo   NM-  m- `m-      `M`    N.  d:  -d.h` /y:h  .d:...ss  ss    oy 
		 .sddddh- :yddddh+` `mm`  :md  sm+   dm-  h-  -o+//+o `m`    d`  y-   od:   oh-  `y+//+so  oo    +o 
		   `````    ````     ``    ``  ``    ``   `     ````   `     `   `     `     `     ```` `         ` 


		  --> 
		
			
Content;
	return $result;
	}
	
	function GetHeader()
	{
		$rootURL = Settings::GetRootURL();
		if(isset($_POST['logout']))
		{
			$GLOBALS['user']->logout(Settings::GetRootURL(). 'login.php');
		}
		
			$q = 'Just type to Search People, Topics, or Icons...';
			if(RequestQueries::GetSearchQuery())
			{
				$q = RequestQueries::GetSearchQuery();
			}	
			$MemberID = $GLOBALS['user']->userID;
			$name = MemberDBMethods::Getusername($MemberID);
			$notificationsCount= Notifications::GetNoOfNotifications($MemberID);
			if($notificationsCount>90){
				$notificationsCount="90+";
			}
			if($notificationsCount==0){
				$old = "oldshit";
			} else {
				$old ="newshyt";
			}
			$NotificationText = Notifications::GetNewNotifications($MemberID);
			$OldNotificationText = Notifications::GetOldNotifications($MemberID);
			$LogOutLink = '	<ul class="sf-menu">
					<li class="current">
						<div class="headerlog"><a href="#">'.$name.'</a></div>
						<ul>
						<div class="items">
							<li id="profile">
								<a class ="profile" a href="http://www.kahub.com/l/profile">My Hub</a>
							</li>
							<li>
								<a class ="hub" a href="http://www.kahub.com/settings">Settings</a>
							</li>
							<li>
								<a class ="logout" onclick="logout()">Logout</a>
							</li>
						</div>
						</ul>
 				</ul><form id = "logoutform" name = "logoutform" method = "post"><input name = "logout" type = "hidden" value = "1"/></form>';

				$notifications = '<ul class="sf-menu2">
						<li class="notifications">
							<div class="headernotify '.$old.'"><a href="#" id="notifyCount">'.$notificationsCount.'</a></div>
							<ul>
							<div class="items-notify">
								<div class="newNotify">
								'.$NotificationText.'
								</div>
								<div class="oldNotify">
								'.$OldNotificationText.'
								</div>
							</div>
							
							</ul>
	 				</ul>';
			
			$profileLink = '<div class="head-logout"></div>';
			$result = <<<Header
			<!--header starts here -->
			<script type="text/javascript"> var _kmq = _kmq || []; function _kms(u){ setTimeout(function(){ var s = document.createElement('script'); var f = document.getElementsByTagName('script')[0]; s.type = 'text/javascript'; s.async = true; s.src = u; f.parentNode.insertBefore(s, f); }, 1); } _kms('//i.kissmetrics.com/i.js');_kms('//doug1izaerwt3.cloudfront.net/ef708ff382fb288b639757b4f42f078092071778.1.js'); </script>
			<div class="header" id="headnorm">
    			<div class="reg-head">
    				<div style = "float:left;">
    					<a href = "{$rootURL}"><div class="logo" id = "logo"></div></a>
    				</div>
    				<div style = "float:left;">
    					<!--<form id = "formSearch" method = "get" action = "{$GLOBALS['rootURL']}pages/search.php" onsubmit = "return doSearch()">    						
							<input type="text"  class="head-textfield" name = "q" value = "{$q}" onblur="WaterMark(this, event, 'Search kahub');" onfocus="WaterMark(this, event, 'Search Connichiwah');"/>
							<input type="submit" value="" class="head-search"/>
						</form>-->
						
						<input type="text"  class="head-textfield" id = "sf" value = "{$q}" onblur="WaterMark(this, event, 'Just type to Search People, Topics, or Icons...'); hideSearchSuggestionBox();" onfocus="WaterMark(this, event, 'Just type to Search People, Topics, or Icons...');" onkeyup="GetSearchSuggestions(this.value)"/>
						<div class="search-suggestionsBox" id="search-suggestions" >
							<div class="search-suggestionList hidden" id="search-autoSuggestionsList">&nbsp;</div>
						</div>
					</div>
					<div class="notifications">
						{$notifications}
					</div>
					<div style = "float:left; margin:3px 0px 0px 3px;">
						{$LogOutLink}						
					</div>
		
					<div class = "cl"></div>
    			</div>
			</div>
			<!--header ends -->
		
Header;
		return $result;
		
	}
		
	function GetFooter()
	{				
		$result = <<<FOOTER_HTML
		<!--footer area starts here -->
		<script type="text/javascript">var _kiq = _kiq || [];</script>
        <script type="text/javascript" src="//s3.amazonaws.com/ki.js/23097/4Ah.js" async="true"></script>
		<div id="sound_element"></div>
FOOTER_HTML;
		return $result;
	}
}
?>