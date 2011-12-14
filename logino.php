<?php
	require_once 'AppCode/ApplicationSettings.php';
	require_once 'AppCode/access.class.php';
	include_once "AppCode/FBConnect/fbmain.php";
	$user = new flexibleAccess();
	if($user->is_loaded())
	{
		header('Location:' . Settings::GetRootURL() . 'l/');	
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
		echo '		<title>Welcome to connichiwah</title>';
		echo		MasterPage::GetHeadScript();
	/*echo '	<script src="' . $rootURL . 'script/mCalender/src/js/jscal2.js" type = "text/javascript"></script>
				<script src="' . $rootURL . 'script/mCalender/src/js/lang/en.js" type = "text/javascript"></script>
				<link href="' . $rootURL . 'script/mCalender/src/css/jscal2.css" rel="stylesheet" type="text/css"  />
				<link href="' . $rootURL . 'script/mCalender/src/css/border-radius.css" rel="stylesheet" type="text/css" />
				<link href="' . $rootURL . 'script/mCalender/src/css/steel/steel.css" rel="stylesheet" type="text/css" />
				<script src="' . $rootURL . 'js/login-script.js" type = "text/javascript"></script>';*/
				
		echo '	<link href="http://d16wvpsx39mdzi.cloudfront.net/style-home.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="http://cdn.sublimevideo.net/js/2ureh5dg.js"></script></head>';
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
		function goodPw($pass){
			$good = "true";
			if (preg_match("/[0-9+]/", $pass)){
				$good = "true";
			} else {
				$good = "false";
			}
		 	if (preg_match("/PASS/", $pass)) {
				$good = "false";
			}
			if (preg_match("/123/", $pass)) {
				$good = "false";
			}
			if (preg_match("/pass/", $pass)) {
				$good = "false";
			}
		return $good;
		}
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
							$GLOBALS['LiteralMessage'] = "<div class = 'errorBox' style ='width:80%;'><div class='loading-image'>Email Required</div></div>";
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
								$returnURL = Settings::GetRootURL() . 'l/';
								if(preg_match('/login.php/', $returnURL) || $returnURL == '')
								{
									$returnURL = Settings::GetRootURL() . 'l/';
								}
								header('Location: ' . $returnURL);
								//Login::SetPageContents($un);		
							}
							else
							{
								$GLOBALS['LiteralMessage'] = "<div class = 'errorBox' style ='width:80%;'><div class='loading-image'>Invalid Email or Password</div></div>";
								Login::SetPageContents($un);
							}
						}
					}
					elseif (isset($_POST['btnRegister'])) 
					{
						$isSuccessfull = false;
						$realemail = false;
						$fn = $_POST['r_FN'];
						$ln = $_POST['r_LN'];
						$email = $_POST['r_Email'];
						$emailveri = $_POST['r_Emailveri'];
						$c_email = $_POST['r_Email_Confirm'];
						$password = $_POST['r_Password'];
						$passwordveri = $_POST['r_Passwordveri'];
						$sex = '';
						if(isset($_POST['radio-gender']))
						{
							$sex = $_POST['radio-gender'];
						}
						$r_DOB = $_POST['Month'] . '/' . $_POST['Day'] . '/' .$_POST['Year'];
						$remember = true;
						$good_pw = Login::goodPw($password);
						
						
						
						if($fn == "")
						{
							$GLOBALS['LiteralMessage'] = "First Name Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						}
						elseif($ln == "")
						{
							$GLOBALS['LiteralMessage'] = "Last Name Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						}
						elseif($emailveri !=""){
							$GLOBALS['LiteralMessage'] = "ERR 2048";
						}
						elseif($email == "")
						{
							$GLOBALS['LiteralMessage'] = "Email Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						}
						elseif($password == "")
						{
							$GLOBALS['LiteralMessage'] = "Password Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						}
						elseif($passwordveri !="")
						{
							$GLOBALS['LiteralMessage'] = "ERR 2723";
						}
						elseif($good_pw == "false")
						{
								$GLOBALS['LiteralMessage'] = "Please select a stronger password <br> <br>TIP: Passwords must be at least 6 characters long, contain 1 number, and cannot be obvious (i.e. Your password can't be, password)";
								Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						
						}
						elseif($r_DOB == '')
						{
							$GLOBALS['LiteralMessage'] = "Date of Birth Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						}
						elseif($sex == '')
						{
							$GLOBALS['LiteralMessage'] = "Gender Required";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						}
						elseif((date('Y') - date('Y', strtotime($r_DOB)) < 13))
						{
							$GLOBALS['LiteralMessage'] = "Sorry, but you are not allowed to join";
							Login::SetPageContents('', '', $fn, $ln, $email, $c_email, $r_DOB, $sex);
						}
						else
						{
							$isUniqueEmail = MemberDBMethods::isEmailAvailable($email);
							if($isUniqueEmail)
							{
								//$array_DOB = HelpingMethods::ConvertDateToArray($r_DOB);
								
								  
								$newUserID = MemberDBMethods::AddMember($fn, $ln, $email, $password, date('Y-m-d H:i:s', strtotime($r_DOB)), $sex);
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
										$returnURL = Settings::GetRootURL() . 'l/Registration.php';
										if(preg_match('/login.php/', $returnURL) || $returnURL == '')
										{
											$returnURL = Settings::GetRootURL() . 'l/Registration.php';
										}
										header('Location: ' . $returnURL);
										//Login::SetPageContents($un);		
									}
									else
									{
										$GLOBALS['LiteralMessage'] = "Invalid Email or Password";
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
		
		function SetPageContents($un = '', $password = '', $rFN = '', $rLN = '', $rEmail = '', $rCEmail = '', $rDOB = '', $sex = '')
		{
			//$userName = "";
			$f_Checked = '';
			$m_Checked = '';
			$DOB_Array = HelpingMethods::ConvertDateToArray($rDOB);
			$stories = HelpingDBMethods::mostRecentStoryAll();
			
			
			
			$fbAppID = $GLOBALS['fbconfig']['appid'];
			$fbData = '';//'<a href="http://www.facebook.com/profile.php?id=636401316"><span style = "padding-bottom:0px;"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/hs341.snc4/41366_636401316_193_q.jpg" height="25px"></span> <span style = "padding-bottom:0px; color: #AAA; font-size: 16px; font-size: 16px;">Black Label</span></a>
			//<span style = "padding-bottom:0px;"><input type="checkbox" id="cbPostOnWall" value="1" checked = "checked" /> Post On Wall</span>';
			if ($GLOBALS['fbme'])
			{

				echo $cookie['access_token'];
				
				//print_r($GLOBALS['fbme']);
				try
				{
					//get user id
					$uid    = $GLOBALS['facebook']->getUser();
					//or you can use $uid = $fbme['id'];
					
					$fql    =   "select name, first_name, last_name, email, profile_url, pic_square, pic_big, sex, birthday_date from user where uid=" . $uid;
					$param  =   array(
							'method'    => 'fql.query',
							'query'     => $fql,
							'callback'  => ''
							);
					$fqlResult   =   $GLOBALS['facebook']->api($param);
					//$userName = $fqlResult[0]['name'];
					if($rEmail == '')
					{
						$rEmail = $fqlResult[0]['email'];
					}
					if($rFN == '' && $rLN == '')
					{
						$rFN = $fqlResult[0]['first_name'];
						$rLN = $fqlResult[0]['last_name'];
					}
					if($rDOB == '')
					{
				
						$rDOB = $fqlResult[0]['birthday_date'];
					}
					if($sex == '')
					{
						$sex = $fqlResult[0]['sex'];
					}
					$DOB_Array = HelpingMethods::ConvertDateToArray($rDOB);					
				}
				catch(Exception $o)
				{
					d($o);
				}
				if($sex == 'male')
				{
					$m_Checked = 'checked = "checked"';
				}
				elseif($sex == 'female')
				{
					$f_Checked = 'checked = "checked"';
				}				
			}
			$dobText = 	Login::GetDOBText($DOB_Array);	
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
    					<a href = "{$GLOBALS['rootURL']}"><img alt="" src="http://d2vowzaj4r0awp.cloudfront.net/form-logo.jpg" class="form-logo"/></a>    			
						<input type="text" value="{$un}" class="form-head-mail" name = "username" onblur="WaterMark(this, event, 'Email');" onfocus="WaterMark(this, event, 'Email');"/>
						<input type="password" value="{$password}" class="form-head-pasword" name = "password" onblur="WaterMark(this, event, 'Password');" onfocus="WaterMark(this, event, 'Password');"/>
						<input type="submit" value="" class="form-head-btn" name = "btnLogin"/>					
					</form>
    			</div>
				<!--header ends -->	
				<div id = "message-div">{$GLOBALS['LiteralMessage']}</div>
								<div class="main">
				    
					<a class="sublime" href="http://connichiwah.com/videos/whatis.mp4">
					 <img src="../images/mainpageplay.png">
					</a>
				
					<video style="display:none"
					        class="sublime zoom"
					        width="640" height="360"
					        poster="http://www.connichiwah.com/videos/img1re.jpg"
					        preload="none">
					    <source src="http://connichiwah.com/videos/whatis.mp4" />
					</video>
					 <div class="recently-shared">
						<p class="justshared">JUST SHARED</p>
						<p class="onconn">ON CONNICHIWAH</p>
						{$stories}
						</div>
					<div class="form-right">		        	
						<h1>Get Started.</h1>
						<p class="it-free">It's free and a whole lot a' fun.</p>
						<fb:login-button autologoutlink="true" perms="email,user_birthday,offline_access">Get Started With Your Facebook Account</fb:login-button>
						<fb:facepile width="318" max_rows="1"></fb:facepile>
						
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
									<input type="text" class="r_Emailveri" name = "r_Emailveri" value=""/>
									<span class="register-label">Email:</span>
            					</li>

								<li>
									<input type="password" class="form-right-textfeld" name = "r_Password"/>
									<input type="password" class= "r_Passwordveri" name = "r_Passwordveri" value=""/>
									<span class="register-label">Password:</span>
            					</li>
            					<li>
									<div class="form-right-textfeld" style = "padding:3px 0px 3px 3px; width:192px;">{$dobText}</div>
									<span class="register-label">Date Of Birth:</span>
            					</li>
            					<li>
            						<div class="form-right-textfeld">
            							<input type = "radio" id = "radio-gender-female" name = "radio-gender" value = "female" {$f_Checked}/>
										<label for = "radio-gender-female">Female | </label>
										<input type = "radio" id = "radio-gender-male" name = "radio-gender" value = "male" {$m_Checked}/>
										<label for = "radio-gender-male">Male</label>
            						</div>
									<span class="register-label">Gender:</span>
            					</li>
								
							</ul>
							<input type = "submit" name = "btnRegister"  class="form-right-get-started" value = "" />
						</form>
					</div>		        
				</div>
Page;
		}
		
		function GetDOBText($DOB_Array)
		{
			$result = '<select name = "Month" selected="'.$fb_month.'">							
							<option value = "01">Jan</option>
							<option value = "02">Feb</option>
							<option value = "03">Mar</option>
							<option value = "4">Apr</option>
							<option value = "5">May</option>
							<option value = "6">Jun</option>
							<option value = "7">Jul</option>
							<option value = "8">Aug</option>
							<option value = "9">Sep</option>
							<option value = "10">Oct</option>
							<option value = "11">Nov</option>
							<option value = "12">Dec</option>
					   </select>';
			$result .= '<select name = "Day">';
			for($i = 1; $i <= 31; $i++)
			{
				$result .= '<option value = "' . $i . '">' . $i . '</option>';
			}
			$result .= '</select>';
			$result .= '<select name = "Year">';
			for($i = 1900; $i <= date('Y'); $i++)
			{
				$result .= '<option value = "' . $i . '">' . $i . '</option>';
			}
			$result .= '</select>';
			
			return $result;
		}
	}
?>

<a href="http://www.connichiwah.com/welcomerefractory.php"><!-- technology-gruesome --></a>

<a href="http://www.connichiwah.com/welcomerefractory.php"><img src="technology-gruesome.gif" height="1" width="1" border="0"></a>

<a href="http://www.connichiwah.com/welcomerefractory.php" style="display: none;">technology-gruesome</a>

<div style="display: none;"><a href="http://www.connichiwah.com/welcomerefractory.php">technology-gruesome</a></div>

<a href="http://www.connichiwah.com/welcomerefractory.php"></a>

<!-- <a href="http://www.connichiwah.com/welcomerefractory.php">technology-gruesome</a> -->

<div style="position: absolute; top: -250px; left: -250px;"><a href="http://www.connichiwah.com/welcomerefractory.php">technology-gruesome</a></div>

<a href="http://www.connichiwah.com/welcomerefractory.php"><span style="display: none;">technology-gruesome</span></a>

<a href="http://www.connichiwah.com/welcomerefractory.php"><div style="height: 0px; width: 0px;"></div></a>