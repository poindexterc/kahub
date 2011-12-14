<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/Notifications.php';
require_once 'dbconn.php';
require_once '../AppCode/MasterPageScript.php';

$url = $_GET['url'];
$comment = HelpingMethods::GetLimitedText(HelpingDBMethods::GetCommentText($_GET['cID']), 100);
$storyID = HelpingDBMethods::GetStoryID($url);
$storyData = HelpingDBMethods::GetStoryData($storyID);
$title = $storyData['s-title'];
$uid = $GLOBALS['user']->userID;
$author = MemberDBMethods::GetUserName($_GET['a']);
$shortURL = file_get_contents('http://api.bitly.com/v3/shorten?login=poindexterc&apiKey=R_4d52b41dcfb52eb29aa7a81583017bc3&longUrl=http%3A%2F%2Fwww.connichiwah.com%2FanyShare%2Fxd_check.php%3Fuser%3D'.$uid.'%26rURL%3D'.urlencode($url).'&format=txt');
$sURL = substr_replace($shortURL,"",-1);
$eURL = urlencode($sURL);
$content = <<<Content
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:regular,bold' rel='stylesheet' type='text/css'>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<script src="http://platform.twitter.com/anywhere.js?id=3YqqPOmqNAScpykEMl2Rog&v=1" type="text/javascript"></script>
<title>kahub | Restate</title> 
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
div.NoSummaryText {
    font-size: 11px;
}

li.twtShare {
    background-color: #33CCFF;
}

li.tbrShare {
    background-color: #54728C;
}

ul.shareTypes li {
    width: 300px;
    vertical-align: middle;
    padding-top: 10px;
    height: 20px;
    padding-bottom: 10px;
    text-align: center;
    color: #ffffff;
    font-family: Helvetica, Arial, sans-serif;
    font-weight: bold;
    font-size: 17px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    margin-bottom: 10px;
    -webkit-box-shadow: 0px 1px 1px 1px #bdbdbd;
    -moz-box-shadow: 0px 1px 1px 1px #bdbdbd;
    box-shadow: 0px 1px 1px 1px #bdbdbd;
}

div.instructions {
    font-weight: normal;
    font-size: 10pt;
    color: #C6C6C6;
    text-shadow: 0px 1px 1px #FAFAFA;
    filter: dropshadow(color=#fafafa, offx=0, offy=1);
}

div.restateHead img {
    height: 50px;
    width: 50px;
    float: left;
    margin-right: 15px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}

div.container {
    width: 600px;
    margin: 0px auto;
}

div.restateHead {
    font-weight: bold;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 24px;
    width: 340px;
    height: 52px;
    margin-left: auto;
    margin-top: 12px;
    margin-right: auto;
    margin-bottom: 15px;
}

li.fbShare {
    background-color: #3B5998;
}

ul.shareTypes {
    list-style-type: none;
    margin-top: 0;
    margin-right: auto;
    margin-bottom: 0;
    margin-left: auto;
    width: 340px;
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
 
<body onLoad="$('.tweetbox').hide();$('.tumblrBox').hide();"> 
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
  FB.init({
    appId  : '146470212065341',
    status : true, // check login status
    cookie : true, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
  });
</script>
	<script>
	var publish = {
	  method: 'feed',
	  message: '\"{$comment}\"- {$author}',
	  link: '{$sURL}',
	  picture: 'http://www.kahub.com/images/restateicnlg.png',
	  actions: [
	    { name: 'Read Story', link: '{$sURL}' }
	  ],
	  user_message_prompt: 'Restate {$author}s Comment:'
	};
	</script>
 
<div class="container">
 	<div class="restateHead"><img src="http://kahub.com/images/kahublogosmallfb.png"> kahub Restate<div class="instructions">Select where you want to share</div></div>
	<ul class="shareTypes">
		<li class="fbShare" onClick='FB.ui(publish);'>Share on Facebook</a></li>
		<li class="twtShare" onClick="$('.tweetbox').show();">Share on Twitter</li>
		<div class="tweetbox">
		<div id="tbox"></div>
		<script type="text/javascript">

		  twttr.anywhere(function (T) {

		    T("#tbox").tweetBox({
		      height: 100,
		      width: 400,
		      defaultContent: "\"{$comment}\"- {$author} {$sURL} via @kahubapp"
		    });

		  });

		</script>
		</div>
		<li onClick="$('.tumblrBox').show();" class="tbrShare">Share on Tumblr</li>
		<div class="tumblrBox">
		<iframe src="http://www.tumblr.com/share/link?url={$eURL}&name={$comment}&description={$comment}- {$author}" frameborder="0" width="500px" height="500px"></iframe>
        </div>
	</ul>
</div> 

 
 
</body> 
</html>
Content;

echo $content;
?>