<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/MasterPageScript.php';
include_once '../AppCode/FBConnect/fbmain.php';
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	


	$nameArray = split(" ", $fullName);
	$getStartHub = HelpingDBMethods::showFeatHubs();

	if (isset($_POST['upload'])){

	}
	$MemberID = $GLOBALS['user']->userID;
	$imageID = HelpingDBMethods::GetMemberImageID($MemberID);
	if($imageID!=0){
		$image = HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail'); 
		$imageURL = '<img src="'.$image.'">';
	}
	
	$memcache = new Memcache;
	$memcache->connect('localhost', 11211) or die ("Could not connect");
	$key = "handleTemp";
    $keyHandle2 = md5($MemberID);
    $keyHandle = $key.$keyHandle2;
    $handle = $memcache->get($keyHandle);
    if($handle==null){
        $handle = "";
    }
    
    
	
	Page::Page_Load();	
	$facebook = Page::FindFacebookFriends();
    
	echo '<!DOCTYPE html>';
	echo '<html>';
	echo '	<head>';
	echo '		<title>Get Started on kahub</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type="text/javascript"> _kmq.push([\'record\', \'Signup\']);</script>
	            <script type="text/javascript" src="jquery.form.js"></script>
			    <style type="text/css" media="screen">
				    a{
				      color: #3E5681;
				      text-decoration: none;
				    }
				    li form input {
                        margin-top: 0;
                        margin-right: auto;
                        margin-bottom: 10px;
                        margin-left: 70px;
                    }
				</style>
			    <script type="text/javascript" >
                $myjquery(document).ready(function() { 
                    $myjquery(\'#photoimg\').live(\'change\', function(){ 
                        $myjquery("#dropbox").html(\'\');
                      	$myjquery("#dropbox").html(\'<img src="loader.gif" alt="Uploading...."/>\');
                      	$myjquery("#imageform").ajaxForm({
                      		target: \'#dropbox\'
                      	}).submit();
                      });
                }); 
                </script>
				'; 
				
	echo '<link rel="stylesheet" type="text/css" href="../css/style-profile.css" />';
			
	echo '	</head>';
	echo '	<body onLoad="$myjquery(\'#handle\').focus();">';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">';
	echo '				<div class="main-content getstarted">';
	$wikiJobs = HelpingDBMethods::wikiImg("Steve Jobs");
    if($wikiJobs!=""){
        $wikiJobsImg = str_replace($wikiJobs[1]."px", "70px", $wikiJobs[0]);
    } else {
        $wikiJobsImg = "";
    }
    if($wikiJobsImg!=""){
	    $jobsImg = '<div class="featImg"><img src='.$wikiJobsImg.' alt="Steve Jobs"></div><div class="namewphoto feat">Steve Jobs</div>';
	}  else {
	    $jobsImg = '<div class="nameFeat feat"><span class="featspacer">&mdash;</span>Steve Jobs<span class="featspacer">&mdash;</span></div>';
	}
	$signupInner = <<<HTML
	<div id="getStartedWrap">
		<ul class="getStarted">
			<li><div class="numberStep">1.</div><div class="topHeaeder">What do you wanna be called?</div><br>
				<div id="slash">/</div><input type="text" name="handle" id="handle" value="{$handle}" onBlur="checkUser()"><br>
				<div id="check"></div><br>
				<div class="help">Enter what you want your username (handle) to be. These are used around the site to identify you</div>
			</li>
			<li>
				<div class="numberStep">2.</div><div class="topHeader">Drop in a photo of your good lookin' self</div><br>
	            <div class="droparea spot" data-width="200" data-height="200" data-type="jpg" data-crop="true" data-quality="70" id="dropbox" >{$imageURL}
					<form enctype="multipart/form-data" action="uploadStarted.php" method="POST" style="opacity: 0">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
					<input name="uploadedfile" type="file"/><br />
					<input type="submit" value="Upload File" />
					</form></div>
					
                    <form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'>
                        <input type="file" name="photoimg" id="photoimg" />
					<li>
					</li>
					</form>
			</li>
			<li>
				<div class="numberStep">3.</div><div class="topHeader">Friend your friends and follow your interests.</div><br>
			</li>
			{$facebook}
			{$getStartHub}
			<input id="followCountInput" value="0" style="display: none"/> 
			<input id="goodHandle" value="0" style="display: none"/> 
			<li>
				<div id="getStartedBtn"><a class="button getStarted inactive" onClick="saveHandle()" id="btnGetStarted">Get Started!</a><div class="legalBottom">By clicking "Get Started!" above, you are affirming that you are over 13 years of age and that you have read and agree to our <a href="http://www.kahub.com/privacy">Privacy Policy</a> and <a href="http://www.kahub.com/terms">Terms of Service</a>.</div></div>
			</li>
		</ul>
	</div>
	
HTML;
	echo 				$signupInner;
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
				//$noOfFriends = HelpingDBMethods::GetNoOfFriends($userNum);
				//$imageID = HelpingDBMethods::GetMemberImageID($userNum);
				
									
					//Page::SetMainContent();
					//Page::SetSideBarContent();
					//StoryRanking::SetStoryRanking();					
					
			}
			mysql_close($DBConnection);
		}
	}
	function FindFacebookFriends()
	{
		$data = '';
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
				    $DBConnection = Settings::ConnectDB(); 		
            		$db_selected = mysql_select_db($GLOBALS['databaseName'], $DBConnection) or die(mysql_error());
					$data .= '<table cellspacing = "5" cellpadding = "5" style = "">';
					$first_name = $friendUser['first_name'];
					$last_name = $friendUser['last_name'];
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE (mFirst_Name = '$first_name') AND (mLast_Name = '$last_name')";
					$QueryResult =  mysql_query($Query)or die(mysql_error());
					$row = mysql_fetch_array($QueryResult);
					while( $row != false)
					{
						$data .= '<tr class="fbonboard">
									<td>
										<img src = " ' . $friendUser['pic_big'] . '" style = "height:30px;" />
									</td>
									<td>
										' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '
									</td>
									<td>
									    <a class="friendsPage btn-add-prof onboard" onclick="AddFriendFromSearch('.$row['MemberID'].');">Add Friend</a>
									</td>
								  </tr>';
						$row = mysql_fetch_array($QueryResult);
					}
					$data .= '</table>';
				}
				$fb = <<<HTML
				<div class = "friend-list-container onboard">
					{$data}
	            </div>
HTML;
			}
			else
			{
			 //Page::FindFriends();
			}
		}
		else
		{
			$fbAppID = $GLOBALS['fbconfig']['appid'];
			$fb = <<<Content
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
				<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream">Find Some Friends</fb:login-button>
				</div>
Content;
		}
		return $fb;
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