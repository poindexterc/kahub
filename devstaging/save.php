<?
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/MasterPageScript.php';
require_once '../AppCode/SideBarScript.php';
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/Notifications.php';
require_once '../AppCode/MasterPageScript.php';
$url = $_GET['rURL'];
$uid = $_GET['user'];
$user = new flexibleAccess();
if($user->is_loaded())
{
	$uid = $GLOBALS['user']->userID;
}
$newHeadline = $_POST['value'];
$Query = "UPDATE  tbl_person_hub SET  headline = '".mysql_real_escape_string(urldecode($newHeadline))."' WHERE   (MemberID = $uid)";
$QueryResult =  mysql_query($Query)or die(mysql_error());
return $newHeadline;
