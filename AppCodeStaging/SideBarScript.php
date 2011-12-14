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
		

			$myName =  MemberDBMethods::GetUserName($userID);
			$noOfFriends = HelpingDBMethods::GetNoOfFriends($userID);
			$imageID = HelpingDBMethods::GetMemberImageID($userID);
			$imageSource = HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail');
			$newNotificationsCount = Notifications::GetNoOfNotifications($userID);
			$newbadgesCount = Notifications::GetNoOfNeBadges($userID);
			$hubName = HelpingMethods::GetLimitedText(strtolower(str_replace( ' ', '', MemberDBMethods::GetUserName($userID))), 11);  
			$interests = HelpingDBMethods::GetInterestsSide();
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
			$hubData = HelpingDBMethods::getHubInfoFromMemberID($userID);
			$noFollowers = HelpingDBMethods::GetNoOfFriends($hubData['h-hubID']);
            $noFriends = HelpingDBMethods::GetNoOfFriends($userID);
            $noComments = HelpingDBMethods::GetNoComments($userID);
			
			
			$result = <<<SB
				<div style = "padding-bottom:5px;">
					<div class = "cl"></div>
				</div>
            	    <a href="http://www.kahub.com/l/profile.php"><span class="profPicSide"><img src="$imageSource"></a><br /><div class="nameSideBar">&mdash;<a href="http://www.kahub.com/l/profile.php">$myName</a>&mdash;<div class="sideStats"><a href="http://www.kahub.com/l/friends.php">$noFriends Friends</a> &#183; <a href="http://www.kahub.com/l/followers.php">$noFollowers Followers</a> <br /> $noComments Comments</div></div> </li>
					<div class="interestsSidebar">
					<ul class="interestsSide">
    				{$interests}
    				</ul>
    				</div>
			
				
				
					<div class = "cl"></div>
				

				<div class="promoShow">
					<!--/* OpenX Javascript Tag v2.8.7 */-->

					<script type='text/javascript'><!--//<![CDATA[
					   var m3_u = (location.protocol=='https:'?'https://www.kahub.com/adServe/www/delivery/ajs.php':'http://www.kahub.com/adServe/www/delivery/ajs.php');
					   var m3_r = Math.floor(Math.random()*99999999999);
					   if (!document.MAX_used) document.MAX_used = ',';
					   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
					   document.write ("?zoneid=1&amp;target=_blank");
					   document.write ('&amp;cb=' + m3_r);
					   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
					   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
					   document.write ("&amp;loc=" + escape(window.location));
					   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
					   if (document.context) document.write ("&context=" + escape(document.context));
					   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
					   document.write ("'><\/scr"+"ipt>");
					//]]>--></script><noscript><a href='http://www.kahub.com/adServe/www/delivery/ck.php?n=abb0ef91&amp;cb=54964698746464896468' target='_blank'><img src='http://www.kahub.com/adServe/www/delivery/avw.php?zoneid=1&amp;cb=54964698746464896468&amp;n=abb0ef91' border='0' alt='' /></a></noscript><div id="adDescrip">Advertisement</div>
</div>
SB;
		

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
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE (mFirst_Name = '$first_name') AND (mLast_Name = '$last_name') LIMIT 0,1";
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
										<b class="fb"><a href="http://www.kahub.com/l/profile.php?user='.$row['MemberID'].'">' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '</a></b>
										<div class="addfb" onClick="AddFriendFromSearch('.$row['MemberID'].')">Add as a Friend</div>
									</td>
								 </tr>';
						}
						$row = mysql_fetch_array($QueryResult);
					}
					$data .= '</table>';
				}
				$result = <<<HTML
	            
					{$data}
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
