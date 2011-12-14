<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/Notifications.php';
require_once 'dbconn.php';
require_once '../AppCode/MasterPageScript.php';

$user = $_GET['user'];
$rootURL = Settings::GetRootURL();
$result = "";
$offset=0;
$limit=19;
$name = MemberDBMethods::GetUserName($user);

$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>kahub Latest Stories for '.$name.'</title>';
$rssfeed .= '<link>http://www.connichiwah.com</link>';
$rssfeed .= '<description>RSS Feed of '.$name.' Latest Stories stream on kahub</description>';
$rssfeed .= '<language>en-us</language>';
$rssfeed .= '<category>News</category>';
$rssfeed .= '<copyright>Copyright (C) 2011 kahub.com</copyright>';

$rootURL = Settings::GetRootURL();
$result = "";
$Query = "SELECT DISTINCT s.StoryID, s.Story_Title, s.Story_URL, s.views, s.DateTime, s.ImageID, c.MemberID, c.Comment_Text, c.CommentID, c.Reply_To, c.Date_Time
			FROM tbl_friends a
			INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
			INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
			INNER JOIN tbl_story s ON c.StoryID = s.StoryID
			WHERE (a.MemberID_Active = '$user')
			ORDER BY s.DateTime DESC LIMIT $offset, $limit";
$QueryResult =  mysql_query($Query)or die(mysql_error());
$row = mysql_fetch_array($QueryResult);
while($row != false)
{
		extract($row);
		$longURL = $row['Story_URL'];
		$comment = $row['Comment_Text'];
		$urlStart ='http://www.connichiwah.com/anyShare/index.php?ref=rss&rand=0&read=1&rURL=';
		$shortURL = file_get_contents('http://api.bitly.com/v3/shorten?login=poindexterc&apiKey=R_4d52b41dcfb52eb29aa7a81583017bc3&longUrl=http%3A%2F%2Fwww.kahub.com%2FanyShare%2Fxd_check.php%3Fuser%3D'.$user.'%26rURL%3D'.urlencode($row['Story_URL']).'&format=txt');
		$title = htmlspecialchars($row['Story_Title']);
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . $title . '</title>';
        $rssfeed .= '<link>' . $shortURL . '</link>';
		$rssfeed .= '<description>' . $comment . '</description>';
        $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($row['Date_Time'])) . '</pubDate>';
        $rssfeed .= '</item>';
		$row = mysql_fetch_array($QueryResult);
}
$rssfeed .= '</channel>';
$rssfeed .= '</rss>';
echo $rssfeed;
?>