<?php
require_once 'ApplicationSettings.php';
require_once 'HelpingDBMethods.php';
require_once 'HelpingMethods.php';
require_once 'RequestQuery.php';
require_once 'Notifications.php';
include_once 'FBConnect/fbmain.php';
class SideBar
{
	function MemberProfileInformation($type = 'home', $isWrapped = true)
	{
		
		$result = '';
		$rootURL = Settings::GetRootURL();
		$userID = $GLOBALS['user']->userID;
		$noOFNotification = Notifications::GetNoOfNotifications($userID);
		$NotificationText = Notifications::GetNewNotifications($userID);			
		//$friendRequests = HelpingDBMethods::GetFriendRequestCount($userID);
		
		$newNotificationsCount = Notifications::GetNoOfNotifications($userID);
		$newbadgesCount = Notifications::GetNoOfNeBadges($userID);
		$badges = HelpingDBMethods::GetBadges($userID, 'tab', 3, 0);
		
		if($type == 'home')
		{
			$myName = MemberDBMethods::GetUserName($userID);
			$noOfFriends = HelpingDBMethods::GetNoOfFriends($userID);
			$noOFBadges = HelpingDBMethods::GetnoOfBadges($userID);
			$noOfTrustsMyFriendsHaveOnMe = HelpingDBMethods::GetNoOfTrustsMyFriendsHaveOnMe($userID);
			
			$badges = HelpingDBMethods::GetBadges($userID, "main", 4, 0);
			$friends = HelpingDBMethods::GetRandomFriends($userID);
			
			$newNotificationsCount = Notifications::GetNoOfNotifications($userID);
			$newbadgesCount = Notifications::GetNoOfNeBadges($userID);
			if($newNotificationsCount > 0)
			{
				$newNotificationsCount = '<script type="text/javascript">document.title="(' . $newNotificationsCount . ') kahub | Home"</script><span class = "notification-popup-count">' . $newNotificationsCount . '</span>';
			}
			else
			{
				$newNotificationsCount = '';
				
			}
			if($newbadgesCount > 0)
			{
				$newbadgesCount = '<span class = "notification-popup-count">' . $newbadgesCount . '</span>';
			}
			else
			{
				$newbadgesCount = '';
			}
			
			
			$result = <<<SB
				<div style = "padding-bottom:5px;">
				<span class="top" onClick="showLoading()">
					<span onclick="notifications('home')" class = "notification-link-home">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_23s.jpg" />						
					</span>
					<span onclick="notifications('notifications')" class = "notification-link-notifications">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_25.jpg" class="pl-1"/>
						{$newNotificationsCount}
					</span>
					<span onclick="notifications('badges')" class = "notification-link-badges">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_27.jpg" class="flag"/>
						{$newbadgesCount}
					</span>
					</span>
					<div class = "cl"></div>
				</div>
				<div class="f-l-name">
            		<span><a href="http://www.connichiwah.com/member/profile.php">$myName&#0187;</a></span>
				</div>
				<ul class="ul home-tab">
            		<li><a href="http://www.connichiwah.com/member/getSources.php"><strong class = "heavy">{$noOfFriends}</strong> sources </a><img alt="friends-count" src="{$rootURL}images/website/question-mark.jpg" class = "help" />
            			<div class="friends-count-help hidden help-box">
							<div class="help-box-top"></div>
							<div class="help-box-mid">
								<p>Sources are like <strong>friends.</strong></p>
							</div>
							<div class="help-box-bot png"></div>
						</div>
            		</li>
					<li><a href="http://www.connichiwah.com/member/getBadges.php"><strong class = "heavy">{$noOFBadges}</strong> badges </a><img alt="badges-count" src="{$rootURL}images/website/question-mark.jpg"  class = "help"/>
						<div class="badges-count-help hidden help-box">
							<div class="help-box-top"></div>
							<div class="help-box-mid">
								<p>Bages are what you get when you do something special on connichiwah.</p>
							</div>
							<div class="help-box-bot png"></div>
						</div>
					</li>
					<li><a href="http://www.connichiwah.com/member/profile.php">Trusted on <strong class = "heavy">{$noOfTrustsMyFriendsHaveOnMe}</strong> thing(s)</a><img alt="issues-count" src="{$rootURL}images/website/question-mark.jpg"  class = "help"/>
						<div class="issues-count-help hidden help-box">
							<div class="help-box-top"></div>
							<div class="help-box-mid">
								<p>These are the things that your friends (sources) think you're really awesome at.</p>
							</div>
							<div class="help-box-bot png"></div>
						</div>
					</li>
				</ul>
	            	
				<div class="circle">
					{$badges}            	
				</div>
				<div class="squere">
					{$friends}	            	
				</div>
SB;
		}
		elseif($type == 'notifications')
		{
			

			if($newNotificationsCount > 0)
			{
				$newNotificationsCount = '<span class = "notification-popup-count">' . $newNotificationsCount . '</span>';
			}
			else
			{
				$newNotificationsCount = '';
			}
			if($newbadgesCount > 0)
			{
				$newbadgesCount = '<span class = "notification-popup-count">' . $newbadgesCount . '</span>';
			}
			else
			{
				$newbadgesCount = '';
			}
			
			//Notifications::SetNotificationStatus($userID);
			
			$result = <<<SB
				<div style = "padding-bottom:5px;">
				<span class="top" onClick="showLoading()">
				
				<span onclick="notifications('home')" class = "notification-link-home">
					<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_23.png" />
				</span>
					<span onclick="notifications('notifications')" class = "notification-link-notifications">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_25s.png" class="pl-1"/>
						{$newNotificationsCount}
					</span>
					<span onclick="notifications('badges')" class = "notification-link-badges">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_27.jpg" class="flag"/>
						{$newbadgesCount}
					</span>
					</span>
					<div class = "cl"></div>
				</div>
				<div class="f-l-name">
            		<span>Notifications ({$noOFNotification})</span>
				</div>
				<ul class="ul">	
            		{$NotificationText}					
				</ul>
SB;
		}
		elseif($type == 'badges')
		{
			if($newNotificationsCount > 0)
			{
				$newNotificationsCount = '<span class = "notification-popup-count">' . $newNotificationsCount . '</span>';
			}
			else
			{
				$newNotificationsCount = '';
			}
			if($newbadgesCount > 0)
			{
				$newbadgesCount = '<span class = "notification-popup-count">' . $newbadgesCount . '</span>';
			}
			else
			{
				$newbadgesCount = '';
			}
			$result = <<<SB
				<div style = "padding-bottom:5px;">
				<span class="top" onClick="showLoading()">
				
					<span onclick="notifications('home')" class = "notification-link-home">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_23.png" />
					</span>
					<span onclick="notifications('notifications')" class = "notification-link-notifications">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_25.jpg" class="pl-1"/>
						{$newNotificationsCount}
					</span>
					<span onclick="notifications('badges')" class = "notification-link-badges">
						<img alt="" src="{$rootURL}images/website/connichiwahloggedinhome_27s.png" class="flag"/>
						{$newbadgesCount}
					</span>
					</span>
					<div class = "cl"></div>
				</div>
				<div class="f-l-name">
            		<span><a href="http://www.connichiwah.com/member/getBadges.php">Badges&#0187;</a></span>
				</div>
				<ul class="ul badges-tab">
					{$badges}            	
				</ul>
SB;
		}
		if($isWrapped)
		{
			$result = '<div id = "sb-top-content">' . $result . '</div>';
		}
		return $result;
	}
	
	function FacebookFriendsWidget()
	{
		$currUser = $GLOBALS['user']->userID;
		
		$result = '';
		if ($GLOBALS['fbme'])
		{
			$uid    = $GLOBALS['fbme']['id'];
			//or you can use $uid = $fbme['id'];
			
			$fql    =   "SELECT first_name, last_name, pic_big
					from user 
					where uid in (SELECT uid2 from friend where uid1=" . $uid . ") AND is_app_user = 1";
			//echo $fql;
			$param  =   array(
					'method'    => 'fql.query',
					'query'     => $fql,
					'callback'  => ''
					);
			$fqlResult   =   $GLOBALS['facebook']->api($param);
			if(count($fqlResult) > 0)
			{
				$rootURL = Settings::GetRootURL();
				$data = '';
				foreach($fqlResult as $friendUser)
				{
					$data .= '<table cellspacing = "5" cellpadding = "5" style = "">';
					$first_name = $friendUser['first_name'];
					$last_name = $friendUser['last_name'];
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE (mFirst_Name = '$first_name') AND (mLast_Name = '$last_name') LIMIT 0,2";
					$QueryResult =  mysql_query($Query)or die(mysql_error());
					$row = mysql_fetch_array($QueryResult);
					
					while( $row != false)
					{
						$friend = HelpingDBMethods::isMyFriend($currUser,$row['MemberID']);
						
						if($friend!=true){
						
						$data .= '<tr>
									<td>
										<img src = " ' . $friendUser['pic_big'] . '" style = "height:50px;" />
									</td>
									<td>
										' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '
										<div class="addfb" onClick="AddFriendFromSearch('.$row['MemberID'].')">Add as a source</div>
									</td>
								 </tr>';
						}
						$row = mysql_fetch_array($QueryResult);
					}
					$data .= '</table>';
				}
				$result = <<<HTML
	            
				<div class = "f-l-name"><span>Friends you may know...</span></div>
				<div id = "message-div"></div>
				<div class = "friend-list-container">
					{$data}
	            </div>
HTML;
			}
			else
			{
			$result = <<<HTML

								<div class = "f-l-name"><span>Invite your friends!</span></div>
								<div id = "message-div"></div>
								<div class = "friend-list-container">
									<input type="text"  class="form-head-share email" id="email-1" value="Email" name = "username" onblur="WaterMark(this, event, 'Email');" onfocus="WaterMark(this, event, 'Email');"/>
					            </div>
								<input type="button" value="Send Invite" class = "btnAddFriend" style = "float:right;" value = "Invite" onclick = "AddMultipleFriendsHome()"/>
HTML;
			}
		}
		else
		{
			$fbAppID = $GLOBALS['fbconfig']['appid'];
			$result = <<<Content
			<div style = "width:100%; text-align:center; padding-top:30px;">
				<div id="fb-root"></div>
				<script type="text/javascript">
					window.fbAsyncInit = function() {
						FB.init({appId: '{$fbAppID}', status: true, cookie: true, xfbml: true});

						// All the events registered 
						FB.Event.subscribe('auth.login', function(response) {
							// do something with response
							fblogin();
						});
						FB.Event.subscribe('auth.logout', function(response) {
							// do something with response
							fblogout();
						});
					};
					(function() {
						var e = document.createElement('script');
						e.type = 'text/javascript';
						e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
						e.async = true;
						document.getElementById('fb-root').appendChild(e);
					}());

					function fblogin()
					{
						location.reload(true);
					}
					function fblogout()
					{
						location.reload(true);
					}
				</script>				
				<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream">Find More Friends</fb:login-button>
				</div>
Content;
		}
		return $result;
	}
}
?>