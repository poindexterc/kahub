<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/Notifications.php';
require_once 'dbconn.php';
require_once '../AppCode/MasterPageScript.php';

$url = $_GET['url'];
$storyID = HelpingDBMethods::GetStoryID($url);
$storyData = HelpingDBMethods::GetStoryData($storyID);
$title = $storyData['s-title'];
$uid = $GLOBALS['user']->userID;
$shortURL = file_get_contents('http://api.bitly.com/v3/shorten?login=poindexterc&apiKey=R_4d52b41dcfb52eb29aa7a81583017bc3&longUrl=http%3A%2F%2Fwww.kahub.com%2FanyShare%2Fxd_check.php%3Fuser%3D'.$uid.'%26rURL%3D'.urlencode($url).'&format=txt');
$content = <<<Content
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:regular,bold' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Add to Instapaper/Read it Later</title> 
<style type="text/css"> 
body {
	background: #f0f0f0;
	margin: 0;
	padding: 0;
	font: 15px normal 'Droid Serif', Verdana, Arial, Helvetica, sans-serif;
	color: #444;
}
h1 {font-size: 3em; margin: 20px 0;}
.container {margin: 10px 20px;}
ul.tabs {
	margin: 0;
	padding: 0;
	float: left;
	list-style: none;
	height: 32px;
	border-bottom: 1px solid #999;
	border-left: 1px solid #999;
}
ul.tabs li {
	float: left;
	margin: 0;
	padding: 0;
	height: 31px;
	width: 404px;
	line-height: 31px;
	border: 1px solid #999;
	border-left: none;
	margin-bottom: -1px;
	background: #e0e0e0;
	overflow: hidden;
	position: relative;
	text-align: center;
	
}
ul.tabs li a {
	text-decoration: none;
	color: #000;
	display: block;
	font-size: 1.2em;
	padding: 0;
	border: 1px solid #fff;
	outline: none;
}
ul.tabs li a:hover {
	background: #ccc;
}	
html ul.tabs li.active, html ul.tabs li.active a:hover  {
	background: #fff;
	border-bottom: 1px solid #fff;
	font-weight: bold;
}
.tab_container {
	border: 1px solid #999;
	border-top: none;
	clear: both;
	float: left; 
	background: #fff;
	-moz-border-radius-bottomright: 5px;
	-khtml-border-radius-bottomright: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-moz-border-radius-bottomleft: 5px;
	-khtml-border-radius-bottomleft: 5px;
	-webkit-border-bottom-left-radius: 5px;
}
.tab_content {
	padding: 20px;
	font-size: 1.2em;
}
.tab_content h2 {
	font-weight: normal;
	padding-bottom: 10px;
	border-bottom: 1px dashed #ddd;
	font-size: 1.8em;
}
.tab_content h3 a{
	color: #254588;
}
.tab_content img {
	float: left;
	margin: 0 20px 20px 0;
	border: 1px solid #ddd;
	padding: 5px;
}
</style> 
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script> 
<script type="text/javascript"> 
 
$(document).ready(function() {
 
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
 
});
</script> 
</head> 
 
<body> 
 
<div class="container"> 
    <ul class="tabs"> 
        <li><a href="#tab1">Instapaper</a></li> 
        <li><a href="#tab2">Read it Later</a></li> 
    </ul> 
    <div class="tab_container"> 
        <div id="tab1" class="tab_content"> 
          <iframe src="http://www.instapaper.com/edit?url={$shortURL}&title={$title}" frameborder="0" width="770px" height="400px"></iframe>
        </div> 
        <div id="tab2" class="tab_content"> 
           <iframe src="https://readitlaterlist.com/save?url={$shortURL}&title={$title}" frameborder="0" width="770px" height="400px"></iframe>
        </div> 
    </div> 
</div> 

 
 
</body> 
</html>
Content;

echo $content;
?>