<?php
	require_once 'AppCode/ApplicationSettings.php';
	require_once 'AppCode/access.class.php';
	include_once "AppCode/HelpingDBMethods.php";
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
		$errorMessage = "This is an error";
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> ';
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '	<head>';
		echo '		<title>Reset Password | kahub</title>';
	/*echo '	<script src="' . $rootURL . 'script/mCalender/src/js/jscal2.js" type = "text/javascript"></script>
				<script src="' . $rootURL . 'script/mCalender/src/js/lang/en.js" type = "text/javascript"></script>
				<link href="' . $rootURL . 'script/mCalender/src/css/jscal2.css" rel="stylesheet" type="text/css"  />
				<link href="' . $rootURL . 'script/mCalender/src/css/border-radius.css" rel="stylesheet" type="text/css" />
				<link href="' . $rootURL . 'script/mCalender/src/css/steel/steel.css" rel="stylesheet" type="text/css" />
				<script src="' . $rootURL . 'js/login-script.js" type = "text/javascript"></script>';*/
				
		echo '	<link href="http://www.kahub.com/css/style-home.css" rel="stylesheet" type="text/css" /></head>';
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
		echo '	    </div>';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
     	<script src="jquery.infieldlabel.min.js" type="text/javascript" charset="utf-8"></script> <script type="text/javascript" charset="utf-8">
		$(function(){ $("label").inFieldLabels(); });
	</script>';
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
						$pass = $_POST['password'];
						$remember = true;
						if(isset($_POST['remember']))
						{
							$remember = true;
						}
						echo $verify;
						if($pass == "")
						{
							$GLOBALS['errorMessage'] = "Email Required";
							Login::SetPageContents($un);
						}
						else
						{
							$email = $_POST['email'];
							$veri = HelpingDBMethods::newPassword($email, $pass);
							echo $pass;
							echo $email;
							echo $veri;
							$response = $GLOBALS['user']->login($email,$pass,$remember);
							echo $response;
							if($response == true)
							{							
								//$returnURL = RequestQueries::GetReturnURL();
								$returnURL = Settings::GetRootURL() . 'l/';
								if(preg_match('/login.php/', $returnURL) || $returnURL == '')
								{
									$returnURL = Settings::GetRootURL() . 'l/';
								}
								$MemberID = $GLOBALS['user']->userID;
								MemberDBMethods::loginUser($MemberID);
								header('Location: ' . $returnURL);
								//Login::SetPageContents($un);		
							}
							else
							{
								$GLOBALS['errorMessage'] = "Hmm, your email or password isn't right...";
								Login::SetPageContents($un);
							}
						}					
					} else {
						Login::SetPageContents("", "");
					}				
				}
				mysql_close($DBConnection);
			}
		}
		
		function SetPageContents($un = '', $password = '', $rFN = '', $rLN = '', $rEmail = '', $rCEmail = '', $rDOB = '', $sex = '')
		{
			//$userName = "";
			$email = $_GET['e'];
			$code = $_GET['p'];
			$verify = HelpingDBMethods::verifyResetCode($code, $email);			
			if($verify==1){									
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
				<div class="header"><div id="head-text">Reset.</div></div>
			  <div class="page"><div class="login-logo"><p>No account? No problem. <br><a href="#">Sign up here!</a></p></div><li class="error">{$GLOBALS['errorMessage']}</li><li><p>
				<form method = "post" action = "{$GLOBALS['rootURL']}resetpassVeri.php">
					
			      <label for="password">Password</label><br />
			      <input type="password" name="password" value="{$pass}"
			    	id="password">
				<input type="text" name="email" value="{$email}" style="display:none;">
			    </p></li>
			    <li>
			      <button type = "submit" class="large orange button form-head-btn" name = "btnLogin">Reset</button>
			      </li></form></div>
    				
Page;
		}
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