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
	$userNum = $_GET['user'];
	if ($userNum==""){
		$userNum=$GLOBALS['user']->userID;
	}
	require_once '../AppCode/MasterPageScript.php';
	require_once '../AppCode/SideBarScript.php';
	if(MemberDBMethods::isHub($userNum)==1){
		header("Location: http://www.kahub.com/l/hub?user=".$userNum);
	} else {
		$hubData = HelpingDBMethods::GetHubInfoFromMemberID($userNum);
		header("Location: http://www.kahub.com/".$hubData['h-handle']);
	}

}
?>