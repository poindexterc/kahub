<?php
require_once '../AppCode/access.class.php';
$user = new flexibleAccess();
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/MyMailingMethods.php';
require_once '../AppCode/CommentsMethods.php';
require_once '../AppCode/MemberDBMethods.php';
if($user->is_loaded())
{
	if(isset($_GET['method']) && ($_GET['method'] != ""))
	{	
		$MethodName = $_GET['method'];
		if($MethodName == "hello")
		{
			echo myMemberService::hello();
		}
		elseif($MethodName == "ChangeName")
		{	
			if(isset($_POST['name'])){$name = $_POST['name'];}
			echo myMemberService::ChangeName($name);
		}
		elseif($MethodName == "ChangeEmail")
		{	
			if(isset($_POST['email'])){$email = $_POST['email'];}
			echo myMemberService::ChangeEmail($email);
		}
		elseif($MethodName == "ChangePassword")
		{	
			if(isset($_POST['oldPassword'])){$oldPassword = $_POST['oldPassword'];}
			if(isset($_POST['newPassword'])){$newPassword = $_POST['newPassword'];}
			echo myMemberService::ChangePassword($oldPassword, $newPassword);
		}
		elseif($MethodName == "ChangeDOB")
		{	
			if(isset($_POST['DOB'])){$DOB = $_POST['DOB'];}
			echo myMemberService::ChangeDOB($DOB);
		}
		elseif($MethodName == "ChangeAboutMe")
		{	
			if(isset($_POST['aboutme'])){$aboutme = $_POST['aboutme'];}
			echo myMemberService::ChangeAboutMe($aboutme);
		}
		else
		{
			echo '{"status":"0", "message":"No Such Method Exists"}';
		}	
	}
	else
	{
		echo '{"status":"0", "message":"Method Name Must Be Specified"}';
	}
}
else
{
	echo '{"status":"0", "message":"You are not Loged In"}';
}
class myMemberService
{
	function hello()
	{
		
		return '{"status":"1", "message":"Hello World !!! ' . gmdate('Y-m-d H-i-s'). '"}';
	}
	
	function ChangeName($name)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$userID = $GLOBALS['user']->userID;
				$Query = "UPDATE tblmembers	SET MemberName= '$name'	WHERE MemberID=$userID";
				$QueryResult =  mysql_query($Query)or die(mysql_error());				
				$result = '{"status":"1", "message":"Name Updated"}';
			}
			mysql_close($DBConnection);
		}		
		return $result;
	}
	
	function ChangeEmail($email)
	{
		$result = '';
		$status = false;
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$userID = $GLOBALS['user']->userID;
				$Query = "UPDATE tblmembers	SET MemberEmail= '$email'	WHERE MemberID=$userID";
				$QueryResult =  mysql_query($Query)or die(mysql_error());				
				$result = '{"status":"1", "message":"Email Updated"}';
				$status = true;
			}
			mysql_close($DBConnection);
		}
		if($status == true)
		{
			$un = MemberDBMethods::GetUserName($GLOBALS['user']->userID);
			$to = $email;
			$from = "noreply@sopider.com";
			
			$headers = "From: Sopider Team <noreply@sopider.com> \r\n";
			
			$subject= 'Hello ' . $un . ', Your Email Is Been Changed.';
			$body = <<<Body
					<h1>Hello {$un}</h1>
					<div>Your Email Is Been Changed</div>
Body;
			$isSent = MyMailingMethods::GeneralMail($to, $subject, $body, $headers, $result);
			/*if($isSent == true)
			{
				$result = 'Your Password is Mailed to You';
			}
			else
			{
				return $result;
			}*/	
		}			
		return $result;
	}
	
	function ChangePassword($oldPassword, $newPassword)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$userID = $GLOBALS['user']->userID;
				if($oldPassword == MemberDBMethods::GetUserPassword($userID))
				{
					$Query = "UPDATE tblmembers	SET MemberPassword= '$newPassword'	WHERE MemberID=$userID";
					$QueryResult =  mysql_query($Query)or die(mysql_error());				
					$result = '{"status":"1", "message":"Password Updated"}';
				}
				else
				{
					$result = '{"status":"0", "message":"Password Verification Failed"}';
				}
			}
			mysql_close($DBConnection);
		}		
		return $result;
	}
	
	function ChangeDOB($DOB)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$userID = $GLOBALS['user']->userID;
				$Query = "UPDATE tblmembers	SET DOB= '$DOB'	WHERE MemberID=$userID";
				$QueryResult =  mysql_query($Query)or die(mysql_error());				
				$result = '{"status":"1", "message":"Date of Birth Updated"}';
			}
			mysql_close($DBConnection);
		}		
		return $result;
	}
	
	function ChangeAboutMe($aboutme)
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$userID = $GLOBALS['user']->userID;
				$Query = "UPDATE tblmembers	SET AboutMe= '$aboutme'	WHERE MemberID=$userID";
				$QueryResult =  mysql_query($Query)or die(mysql_error());				
				$result = '{"status":"1", "message":"About Me Updated"}';
			}
			mysql_close($DBConnection);
		}		
		return $result;
	}
}
?>