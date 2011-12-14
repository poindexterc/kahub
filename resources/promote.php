<?
$url = $_GET['u'];
$title = $_GET['t'];
function strToHex($string)
{
	$hex='';
	for ($i=0; $i < strlen($string); $i++)
	{
		$myval = dechex(ord($string[$i]));
		while(strlen($myval) < 4)
		{
			$myval = '0' . $myval;	
		}
		$hex .= $myval;
	}
	return $hex;
}
$urlhex = strToHex($url);
$raw_url = parse_url($url); 
$domain_only =str_replace ('www.','', $raw_url); 
$domain =  $domain_only['host'];
$wotURL = 'http://api.mywot.com/0.4/public_query2?target='.$domain;
$xml= simplexml_load_file($wotURL) or die();
$rating = $xml->application[0]->attributes()->r;
if($rating>80){
	require_once '../AppCode/ApplicationSettings.php';
	require_once '../AppCode/access.class.php';
	require_once '../AppCode/HelpingDBMethods.php';
	$user = new flexibleAccess();
	$MemberID=$GLOBALS['user']->userID;
	$spamScore = HelpingDBMethods::spamScore($MemberID);
	$banned = HelpingDBMethods::isBanned($MemberID);
	if($spamScore<7&&$banned=="pass"&&$MemberID!=""){
		$inDB = HelpingDBMethods::storyInDB($url);
		if($inDB!=true&&$domain!="kahub.com"){
			$story = file_get_contents('http://www.kahub.com/anyShare/read.php?rURL='.$url);
			HelpingDBMethods::insertStoryTextExtension($story, $url, $title);
		}
	}
	$storyData = HelpingDBMethods::GetStoryDataFromURL($url);
	$promoCount = HelpingDBMethods::GetPromoteCount($storyData['s-id']);
	$isPromoted=HelpingDBMethods::GetPromoted($storyData['s-id'], $MemberID);
	if(!$isPromoted){
		$promoImg = '<img src="http://c689580.r80.cf2.rackcdn.com/kahubbtnpromote.png">';
	} else {
		$promoImg = '<img src="http://c689580.r80.cf2.rackcdn.com/kahubbtnpromoted.png">';
	}
	require_once '../AppCode/MasterPageScript.php';
	require_once '../AppCode/SideBarScript.php';
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>kahub</title>';
	echo		MasterPage::GetHeadScript();
	echo  '<style type="text/css">';
	echo 'body{background: #fff!important}#promoCount {
	    float: left;
	    background-color: #199636;
	    padding: 2px;
	    padding-left: 6px;
	    padding-right: 6px;
	    color: #ffffff;
	    font-weight: bold;
	    border-style: solid;
	    border-color: #1c8535;
	    border-width: 1px;
	}

	a.promoBtn img {
	    float: left;
	    margin-right: 6px;
	}
	a.promoBtn:hover {
	    cursor: pointer;
	}
	';
	
	echo '</style>';
	echo '</head>';
	echo '<body>';
	echo '<a class="promoBtn" onClick="PromoteStoryButton('.$storyData['s-id'].')">';
	echo $promoImg;
	echo '</a>';
	echo '<div id="promoCount">';
	echo ''.$promoCount.'';
	echo '</div>';
	echo '</body>';
	echo '</html>';
}
?>


	