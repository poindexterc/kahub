<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
include('../AppCode/image.thumbnail.php');
include_once "../AppCode/FBConnect/fbmain.php";
require_once '../AppCode/HelpingDBMethods.php';
$user = new flexibleAccess();

	require_once '../AppCode/MasterPageScript.php';
	

	$LiteralMessage = "";
	$LiteralContent = "";
	$key =  mysql_real_escape_string($_GET['key']);
	$verify =  mysql_real_escape_string($_GET['verify']);
	$keyCheck = mysql_real_escape_string($_POST['keyVal']);
	$veriCheck = mysql_real_escape_string($_POST['veriVal']);
	if ($key != $keyCheck){
		header("Location: http://www.connichiwah.com/member/invalid.php");
	}
	else if ($verify != $veriCheck){
		header("Location: http://www.connichiwah.com/member/invalid.php");
	} else {		
		$userID = $GLOBALS['user']->userID;
		mysql_query("DELETE FROM admin5_connichiwah.tbl_member WHERE MemberID='$userID'");
		
	}
?>