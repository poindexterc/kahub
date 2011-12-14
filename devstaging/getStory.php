<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
$user = new flexibleAccess();
require_once '../AppCode/MasterPageScript.php';
require_once '../AppCode/SideBarScript.php';
require_once '../AppCode/StoryRanking.php';
require_once '../AppCode/URLKeyWordExtraction/URLKeyWordExtraction.php';
echo		MasterPage::GetHeadScript();

	$DBConnection = Settings::ConnectDB(); 		
	if($DBConnection)
	{
		$db_selected = mysql_select_db($GLOBALS['databaseName'], $DBConnection) or die(mysql_error());
		if($db_selected)
		{
			$noOfFriends = HelpingDBMethods::GetNoOfFriends($userNum);
			$imageID = HelpingDBMethods::GetMemberImageID($userNum);
			
								
				//Page::SetMainContent();
				//StoryRanking::SetStoryRanking();					
				

	

$storyID = $_GET['id'];
$StoryData = HelpingDBMethods::GetStoryData($storyID);
$storyURL = $StoryData['s-url'];
$url = file_get_contents($storyURL);
echo $url;
echo '<script type="text/javascript">




onload = function () {
	readStyle = \'style-novel\';
	    readSize = \'size-medium\';
	    readMargin = \'margin-medium\';
	    _readability_jquery = document.createElement(\'SCRIPT\');
	    _readability_jquery.type = \'text/javascript\';
	    _readability_jquery.src = \'http://www.connichiwah.com/anyShare/jquery-latest.min.js\';
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_jquery);
	    _readability_script = document.createElement(\'SCRIPT\');
	    _readability_script.type = \'text/javascript\';
	    _readability_script.src = \'http://www.connichiwah.com/dev/read/js/slideout/readability.js?x=\' + (Math.random());
	    document.getElementsByTagName(\'head\')[0].appendChild(_readability_script);
}




</script>';

	}
}
?>