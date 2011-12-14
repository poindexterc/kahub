<?php
	require_once 'AppCode/ApplicationSettings.php';
	require_once 'AppCode/access.class.php';
	include_once "AppCode/FBConnect/fbmain.php";
	$user = new flexibleAccess();
	if($user->is_loaded())
	{
		header('Location:' . Settings::GetRootURL() . 'member/');	
	}
	else
	{
		require_once 'AppCode/MasterPageScript.php';
		
		$LiteralMessage = "";
		$LiteralContent = "";
		Login::Page_Load();

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '	<head>';
		echo '		<title>Connichiwah : Login or Register</title>';
		echo		MasterPage::GetHeadScript();
		echo '	</head>';
		echo '	<body>';
		echo '		<div class="container">';
		//echo			MasterPage::GetHeader();
		echo '			<div class="mainDiv">';	
		echo '				<!-- Content Page Code Starts -->';
							//Home Page Content Area Starts
		echo				$LiteralContent;
							//Home Page Content Area Ends				    
		echo '				<!-- Content Page Code Ends --> ';
		echo '				<div class="clear" ></div>';
		echo '			</div>';
		echo			MasterPage::GetFooter();
		echo '	    </div>';
		echo '	</body>';
		echo '</html>';
	}
	class Login
	{
		function Page_Load()
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db($GLOBALS['databaseName'], $DBConnection) or die(mysql_error());
				if($db_selected)
				{
					if (isset($_POST['btnLogin'])) 
					{
						$isSuccessfull = false;
						$un = $_POST['username'];
						$password = $_POST['password'];
						$remember = true;
						//if(isset($_POST['remember']))
						//{
						//	$remember = true;
						//}
						if($un == "")
						{
							$GLOBALS['LiteralMessage'] = "<div class = 'errorBox' style ='width:80%;'><div class='loading-image'>User Name Required</div></div>";
							Login::SetPageContents($un);
						}
						elseif($password == "")
						{
							$GLOBALS['LiteralMessage'] = "<div class = 'errorBox' style ='width:80%;'><div class='loading-image'>Password Required</div></div>";
							Login::SetPageContents($un);
						}
						else
						{
							$response = $GLOBALS['user']->login($un,$password,$remember);
							if($response == true)
							{							
								//$returnURL = RequestQueries::GetReturnURL();
								$returnURL = Settings::GetRootURL() . 'member/';
								if(preg_match('/login.php/', $returnURL) || $returnURL == '')
								{
									$returnURL = Settings::GetRootURL() . 'member/';
								}
								header('Location: ' . $returnURL);
								//Login::SetPageContents($un);		
							}
							else
							{
								$GLOBALS['LiteralMessage'] = "<div class = 'errorBox' style ='width:80%;'><div class='loading-image'>Invalid User Name or Password</div></div>";
								Login::SetPageContents($un);
							}
						}
					}
					elseif (isset($_POST['btnRegister'])) 
					{
						$isSuccessfull = false;
						$fn = $_POST['r_FN'];
						$ln = $_POST['r_LN'];
						$email = $_POST['r_Email'];
						$c_email = $_POST['r_Email_Confirm'];
						$password = $_POST['r_Password'];
						$c_password= $_POST['r_Password_Confirm'];
						$remember = true;
						if($fn == "")
						{
							$GLOBALS['LiteralMessage'] = "First Name Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email);
						}
						elseif($ln == "")
						{
							$GLOBALS['LiteralMessage'] = "Last Name Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email);
						}
						elseif($email == "")
						{
							$GLOBALS['LiteralMessage'] = "Email Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email);
						}
						elseif($email != $c_email)
						{
							$GLOBALS['LiteralMessage'] = "Email Mismatch";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email);
						}
						elseif($password == "")
						{
							$GLOBALS['LiteralMessage'] = "Password Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email);
						}
						elseif($password != $c_password)
						{
							$GLOBALS['LiteralMessage'] = "Password Mismatch";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email);
						}
						else
						{
							$isUniqueEmail = MemberDBMethods::isEmailAvailable($email);
							if($isUniqueEmail)
							{
								$newUserID = MemberDBMethods::AddMember($fn, $ln, $email, $password);
								if($newUserID > 0)
								{
									if($GLOBALS['fbme'])
									{
										try
										{
											//get user id
											$uid    = $GLOBALS['facebook']->getUser();
											//or you can use $uid = $fbme['id'];
											
											$fql    =   "select pic_big from user where uid=" . $uid;
											$param  =   array(
													'method'    => 'fql.query',
													'query'     => $fql,
													'callback'  => ''
													);
											$fqlResult   =   $GLOBALS['facebook']->api($param);
											//$fbData .= 'Email : ' . $data[0]['email'] . '<br/>';
											//echo $fqlResult[0]['pic_big'];
											$ImageID = 0;
											$ImageID = HelpingDBMethods::SaveImageDataInDB($fqlResult[0]['pic_big'], $ImageID);
											MemberDBMethods::UpdateMemberImage($newUserID, $ImageID);
										}
										catch(Exception $o)
										{
											d($o);
										}
									}
									$user = new flexibleAccess();
									$response = $user->login($email,$password,$remember);
									if($response == true)
									{							
										//$returnURL = RequestQueries::GetReturnURL();
										$returnURL = Settings::GetRootURL() . 'member/Registration.php';
										if(preg_match('/login.php/', $returnURL) || $returnURL == '')
										{
											$returnURL = Settings::GetRootURL() . 'member/Registration.php';
										}
										header('Location: ' . $returnURL);
										//Login::SetPageContents($un);		
									}
									else
									{
										$GLOBALS['LiteralMessage'] = "Invalid User Name or Password";
										Login::SetPageContents($email);
									}
								}
							}
              else
              {
                $GLOBALS['LiteralMessage'] = "User Registered using this Email";
							  Login::SetPageContents('', '', $fn, $ln, $email, $c_email);
              }
						}
					}				
					else
					{
						Login::SetPageContents("Email", "Password");
					}				
				}
				mysql_close($DBConnection);
			}
		}
		
		function SetPageContents($un = '', $password = '', $rFN = '', $rLN = '', $rEmail = '', $rCEmail = '')
		{
			$userName = "";
		
			$fbAppID = $GLOBALS['fbconfig']['appid'];
			$fbData = '';//'<a href="http://www.facebook.com/profile.php?id=636401316"><span style = "padding-bottom:0px;"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs341.snc4/41366_636401316_193_q.jpg" height="25px"></span> <span style = "padding-bottom:0px; color: #AAA; font-size: 16px; font-size: 16px;">Black Label</span></a>
			//<span style = "padding-bottom:0px;"><input type="checkbox" id="cbPostOnWall" value="1" checked = "checked" /> Post On Wall</span>';
			if ($GLOBALS['fbme'])
			{
				//print_r($GLOBALS['fbme']);
				try
				{
					//get user id
					$uid    = $GLOBALS['facebook']->getUser();
					//or you can use $uid = $fbme['id'];
					
					$fql    =   "select name, first_name, last_name, email, profile_url, pic_square, pic_big from user where uid=" . $uid;
					$param  =   array(
							'method'    => 'fql.query',
							'query'     => $fql,
							'callback'  => ''
							);
					$fqlResult   =   $GLOBALS['facebook']->api($param);
					//$fbData .= 'Email : ' . $data[0]['email'] . '<br/>';
					//echo $fqlResult[0]['pic_big'];
					$fbData .= '<a href = "' . $fqlResult[0]['profile_url'] . '"><img src = "' . $fqlResult[0]['pic_square'] . '" height = "25px" /><span style = "padding-bottom:5px; color: #AAA; font-size: 16px; font-size: 16px;">' . $fqlResult[0]['name'] . '</span></a>
							<span style = "padding-bottom:5px;"><input type="checkbox" id="cbPostOnWall" value="1" checked = "checked" /> Post On Wall</span>';
				}
				catch(Exception $o)
				{
					d($o);
				}
				$userName = $fqlResult[0]['name'];
				if($rEmail == '')
				{
					$rEmail = $fqlResult[0]['email'];
					$rCEmail = $fqlResult[0]['email'];
				}
				if($rFN == '' && $rLN == '')
				{
					$rFN = $fqlResult[0]['first_name'];
					$rLN = $fqlResult[0]['last_name'];
				}
				
			}			
			$GLOBALS['LiteralContent'] = <<<Page
				<!--header starts here -->
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
					var theImages = new Array() // do not change this

					theImages[0] = 'onemany-01.png'
					theImages[1] = 'discovervari-01.png'
					theImages[2] = 'contextualize-01.png'
					theImages[3] = 'chatvari-01.png'
					theImages[4] = 'share-01.png'

					// do not edit anything below this line

					var j = 0
					var p = theImages.length;
					var preBuffer = new Array()
					for (i = 0; i < p; i++){
					   preBuffer[i] = new Image()
					   preBuffer[i].src = theImages[i]
					}
					var whichImage = Math.round(Math.random()*(p-1));
					function showImage(){
					document.write('<img src="'+theImages[whichImage]+'">');
					}


					function fblogin()
					{
						location.reload(true);
					}
					function fblogout()
					{
						location.reload(true);
					}
				</script>
				<div class="form-head">
					<form method = "post" action = "{$GLOBALS['rootURL']}login.php">
    					<a href = "{$GLOBALS['rootURL']}"><img alt="" src="{$GLOBALS['rootURL']}images/website/form-logo.jpg" class="form-logo"/></a>    			
						<input type="text" value="{$un}" class="form-head-mail" name = "username" onblur="WaterMark(this, event, 'Email');" onfocus="WaterMark(this, event, 'Email');"/>
						<input type="password" value="{$password}" class="form-head-pasword" name = "password" onblur="WaterMark(this, event, 'Password');" onfocus="WaterMark(this, event, 'Password');"/>
						<input type="submit" value="" class="form-head-btn" name = "btnLogin"/>					
					</form>
    			</div>
				<!--header ends -->	
				<div id = "message-div">{$GLOBALS['LiteralMessage']}</div>
				
				<div class="main">		    
					<div class="form-left">
						<script type="text/javascript">
						 showImage();
						</script>							            	
					</div>		        
					<div class="form-right">		        	
						<h1>Get Started.</h1>
						<p class="it-free">It's free and a whole lot a' fun.</p>
						<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream">Get Started With Your Facebook Account</fb:login-button>
						<!--<img alt="" src="images/website/facebook-acount.jpg" />-->						
						<p class="start-fresh">or start fresh:</p>
						
						<form method = "post" action = "{$GLOBALS['rootURL']}login.php">					
							<ul>
            					<li>								                    
									<input type="text" class="form-right-textfeld" name = "r_FN" value = "{$rFN}"/>
									<span class="register-label">First Name:</span>	
            					</li>
								<li>		                    
									<input type="text" class="form-right-textfeld" name = "r_LN" value = "{$rLN}"/>
									<span class="register-label">Last Name:</span>
            					</li>
								<li>									                    
									<input type="text" class="form-right-textfeld" name = "r_Email" value = "{$rEmail}"/>
									<span class="register-label">Email:</span>
            					</li>
								<li>
									<input type="text" class="form-right-textfeld" name = "r_Email_Confirm" value = "{$rCEmail}"/>
									<span class="register-label">Email Again:</span>
            					</li>
								<li>
									<input type="password" class="form-right-textfeld" name = "r_Password"/>
									<span class="register-label">Password:</span>
            					</li>
            					<li>
									<input type="password" class="form-right-textfeld" name = "r_Password_Confirm"/>
									<span class="register-label">Password Again:</span>
            					</li>
							</ul>
							<input type = "submit" name = "btnRegister"  class="form-right-get-started" value = "" />
						</form>
					</div>		        
				</div>
Page;
		}
	}
?>