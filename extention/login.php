<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';

$user = new flexibleAccess();
if($user->is_loaded())
{
	header('Location:' . Settings::GetRootURL() . 'member/');	
}
else
{
	require_once '../AppCode/MasterPageScript.php';
	
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
							// Tel user he is loged in successfully	
							Login::LoggedIn();	
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
								$user = new flexibleAccess();
								$response = $user->login($email,$password,$remember);
								if($response == true)
								{							
									// Tel user he is loged in successfully
									Login::LoggedIn();		
								}
								else
								{
									$GLOBALS['LiteralMessage'] = "Invalid User Name or Password";
									Login::SetPageContents($email);
								}
							}
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
		
		$GLOBALS['LiteralContent'] = <<<Page
				<!--header starts here -->
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
						<h3>HTML Content</h3>		            	
					</div>		        
					<div class="form-right">		        	
						<h1>Get Started.</h1>
						<p class="it-free">It's free and a whole lot a' fun.</p>
						<a href="#"><img alt="" src="images/website/facebook-acount.jpg" /></a>
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
	
	function LoggedIn()
	{
		$GLOBALS['LiteralMessage'] = 'You Are Logged In Successfully. Please Close this window and Enjoy web Experience with connichiwah.';	
		$GLOBALS['LiteralContent'] = <<<Page
				<!--header starts here -->
				<div class="header">
					<div class="reg-head">    							
						<h1><a href="' . $rootURL . 'member/Registration.php">Getting Started</a></h1>
						<a href = "' . $rootURL . '"><img alt="" src="../images/website/form-logo.jpg" class="reg-logo"/></a>
		            
						<div class="cl"></div>							
					</div>
				</div>
				<!--header ends -->	
				<div id = "message-div">{$GLOBALS['LiteralMessage']}</div>
				<input type = "hidden" id = "login-status" value = "true" />
				<a href = "javascript:close()">close</a>
				
Page;
	}
}
?>