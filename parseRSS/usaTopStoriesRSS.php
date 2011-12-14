<?
require_once 'rss_fetch.inc';
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../member/dbconn.php';
require_once '../AppCode/MasterPageScript.php';

$url = 'http://rssfeeds.usatoday.com/usatoday-NewsTopStories';
$rss = fetch_rss($url);
$mysql = mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());

foreach ($rss->items as $item ) {
    $title = $item[title];
    $url   = $item[guid];
    $query = mysql_query("INSERT INTO admin5_connichiwah.tbl_story VALUES (NULL, '$title', '$url', 0, NULL, 0);");
	$story = file_get_contents('http://www.connichiwah.com/anyShare/read.php?rURL='.$url);
	HelpingDBMethods::insertStoryText($story, $url);
}
?>