<?
require_once 'rss_fetch.inc';
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../member/dbconn.php';
require_once '../AppCode/MasterPageScript.php';

$url = 'http://feeds.washingtonpost.com/rss/homepage';
$rss = fetch_rss($url);
$mysql = mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());

foreach ($rss->items as $item ) {
    $title = $item[title];
    $url   = $item[guid];
    HelpingDBMethods::InsertStory($title, $url);
	$story = file_get_contents('http://www.connichiwah.com/anyShare/read.php?rURL='.$url);
	HelpingDBMethods::insertStoryText($story, $url);
	$storyID = HelpingDBMethods::GetStoryID($url);
	echo date("Y-d-j H:i:s");
	echo "<br>";
	echo $storyID;
	echo "<br>";
}
?>