<?php
	require_once '../AppCode/ApplicationSettings.php';
	require_once '../AppCode/HelpingDBMethods.php';
	require_once '../AppCode/HelpingMethods.php';
	require_once '../AppCode/RequestQuery.php';
	require_once '../AppCode/MasterPageScript.php';
	$url = $_GET['rURL'];
	$uid = $_GET['user'];
	$ft = $_GET['ft'];
	if($url==""){
		header('Location:http://www.kahub.com/anyShare/random_loader.php?iter='.$iterf.'&user='.$uid);	
	}
	$imageID = HelpingDBMethods::GetMemberImageID($uid);
	$memberImage = HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail');
	$first = MemberDBMethods::GetFirstname($uid);
	$user = new flexibleAccess();
	$storyID = HelpingDBMethods::GetStoryID($url);
	$storyData = HelpingDBMethods::GetStoryData($storyID);
	$title = $storyData['s-title'];
	$iter = $_GET['iter'];
	$noAdd=1;
	$iterf = $iter+$noAdd;
	$storyText = HelpingDBMethods::GetStoryText($storyID);
	if($storyText==""){
		//header('Location:http://www.kahub.com/anyShare/random_loader.php?iter='.$iterf.'&user='.$uid);	
	}
	
	if($uid==""){
		$phrase = "Stay in the loop on kahub!";
	} else {
		$phrase = "Stay in the loop with <span class='name'>".$first."</span> on kahub!";
	}
	$browser = get_browser(null, true);
	$shortURL = file_get_contents('http://api.bitly.com/v3/shorten?login=poindexterc&apiKey=R_4d52b41dcfb52eb29aa7a81583017bc3&longUrl=http%3A%2F%2Fwww.kahub.com%2FanyShare%2Fxd_check.php%3Fuser%3D'.$uid.'%26rURL%3D'.urlencode($url).'&format=txt');
	
	function parse_url_domain ($rurl) { 
	$parsed = parse_url($url); 
	$hostname = $parsed['host']; 
	return $hostname; 
	} 

	$raw_url = parse_url($url); 
	$domain_only =str_replace ('www.','', $raw_url); 
	$domain =  $domain_only['host'];
	if($domain=="youtube.com"){
		require_once('youtube.php');
		$yt  = new YouTube();
		$vidid = $yt->getId($url);
		$storyText = $yt->generateEmbedded($vidid);
	}
	$ua = $_SERVER['HTTP_USER_AGENT'];
	echo '<html>
	  <head>
	<script type="text/javascript">
	  var _kmq = _kmq || [];
	  function _kms(u){
	    setTimeout(function(){
	      var s = document.createElement(\'script\'); var f = document.getElementsByTagName(\'script\')[0]; s.type = \'text/javascript\'; s.async = true;
	      s.src = u; f.parentNode.insertBefore(s, f);
	    }, 1);
	  }
		</script>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	    <title>kahub | '.$title.' </title>
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	    <link rel="stylesheet" type="text/css"  src ="http://www.kahub.com/extention/styles.css">
	    <link rel="stylesheet" type="text/css"  src ="http://www.kahub.com/extention/connichi_styles-frame.css">
		<script src="../extention/connichiwah-extention.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery-ui-1.8.14.custom.min.js" type="text/javascript" charset="utf-8"></script>
		<link type="text/css" href="css/custom-theme/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
		<link href=\'http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold\' rel=\'stylesheet\' type=\'text/css\'>
		<link href=\'http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic\' rel=\'stylesheet\' type=\'text/css\'>
		
		<style type="text/css">
			p.caption {
				font-family: \'Droid Serif\';
				color: #706e70;
				font-style: italic;
				font-size: 13px;
			}

			#story_content h2 {
				color: #363636;
				border-style: solid;
				border-color: #e6e6e6;
				border-top-width: 1px;
				border-bottom-width: 1px;
				border-right-width: 0;
				border-left-width: 0;
				padding-top: 5px;
				padding-bottom: 5px;
				font-size: 20px;
			}

			body {
				background-color: #F3F3F3;
			}

			div.story-whole {
				width: 800px;
				border-top-style: solid;
				border-right-style: solid;
				border-bottom-style: solid;
				border-left-style: solid;
				border-top-color: #e6e6e6;
				border-right-color: #e6e6e6;
				border-bottom-color: #e6e6e6;
				border-left-color: #e6e6e6;
				border-top-width: 1px;
				border-right-width: 1px;
				border-bottom-width: 1px;
				border-left-width: 1px;
				background-color: #fff;
				padding-top: 30px;
				padding-right: 30px;
				padding-bottom: 30px;
				padding-left: 30px;
				margin-top: 50;
				margin-right: auto;
				margin-bottom: 50px;
				margin-left: auto;
				color: #424242;
			}

			#story_content {
				font-family: \'Droid Serif\';
				line-height: 1.39;
			}

			div.story div {
				font-family: \'Droid Serif\';
			}

			div.title {
				font-family: \'Droid Serif\';
				font-size: 30px;
				font-weight: bold;
				color: #454545;
				margin-bottom: 20px;
				text-align: center;
				border-style: solid;
				border-color: #e0e0e0;
				border-top-width: 1px;
				border-right-width: 0;
				border-bottom-width: 1px;
				border-left-width: 0;
				padding-top: 10px;
				padding-bottom: 10px;
			}

			div.story div p {
				line-height: 140%;
			}
			
			div.warning {
				font-family: \'Droid Serif\';
				font-size: 12px;
				text-align: center;
				color: #b5b5b5;
				font-style: italic;
			}

			.next-story-scroll{
				margin-top: 50px;
				height: 500px;
				background-color: #fff;
			}
			div.prof-pic img {
			    width: 50px;
			    margin-right: 10px;
			}

			div.user {
			    width: 830px;
			    height: 400px;
			    background-color: #fff;
			    margin-top: 20px;
			    margin-right: auto;
			    margin-bottom: 0;
			    margin-left: auto;
			    padding: 20px;
			    font-family: \'Droid Serif\';
			}
			
			div.anylogo{
				width: 860px;
			}

			div.prof-pic {
			    float: left;
			}

			div.signup-onpage {
			    float: right;
			    margin-top: -110px;
			}

			div.signup-vid {
			    float: left;
			    margin-top: 20px;
			}

			span.name {
			    color: F15A24;
			    font-weight: bold;
			}

			div.name-cta {
			    float: left;
			    width: 400px;
			    font-size: 20px;
			}

			div.descrip {
			    font-size: 14px;
			    width: 400px;
			    margin-top: 70px;
			    border-style: solid;
			    border-color: #dedede;
			    border-top-width: 1px;
			    border-right-width: 0;
			    border-bottom-width: 1px;
			    border-left-width: 0;
			    padding-top: 10px;
			    padding-bottom: 10px;
			    text-align: center;
			}

			span.arrow {
			    font-style: normal;
			    font-weight: normal;
			}

			div.new-story-top {
			    width: 800px;
			    margin-top: 20px;
			    margin-right: auto;
			    margin-bottom: 0;
			    margin-left: auto;
			    font-family: \'Droid Sans\';
			    background-color: #fff;
			    padding-right: 30px;
			    padding-left: 30px;
			    padding-top: 10px;
			    padding-bottom: 10px;
			    text-align: center;
			    border-style: solid;
			    border-color: #d4d4d4;
			    border-width: 1px;
			    font-size: 24px;
			}

			div.new-story-top a {
			    text-decoration: none;
			    color: #474747;
			}

			div.new-story-top:hover {
			    background-color: FFFFCC;
			    cursor: pointer;
			}

			img {
			    float: left;
			    margin-right: 20px;
			    margin-bottom: 20px;
			}

			div.cite {
			    font-family: \'Droid Serif\';
			    color: #c7c7c7;
			    font-style: italic;
			    font-size: 14px;
			    text-align: right;
			    margin-bottom: 10px;
			}

			div.cite a {
			    color: #b80000;
			}

			div.story-whole {
			    font-family: \'Droid Serif\';
			}

			div.next-story-scroll {
			    margin-top: 0;
			    margin-right: auto;
			    margin-bottom: 0;
			    margin-left: auto;
			    width: 800px;
			    padding-top: 20px;
			    padding-right: 30px;
			    padding-bottom: 20px;
			    padding-left: 20px;
			    font-family: \'Droid Serif\';
			    text-align: center;
			    font-size: 30px;
			    font-weight: bold;
			    -moz-box-shadow: inset 0px 10px 10px rgba(107, 107, 107, 0.44);
			    box-shadow: inset 0px 5px 5px rgba(107, 107, 107, 0.44);
			    background-color: EAEAEA;
			    height: 700px;
			}

			div p a {
			    color: #b80000;
			    text-decoration: underline;
			}
			div.anylogo {
			    margin-right: auto;
			    margin-left: auto;
			    margin-bottom: 0;
			    padding-bottom: 60px;
			    margin-top: 20px;
			}

			div.anylogo img {
			    float: left;
			}
			
			.loader{
				bottom: 0;
			}
			
			div.loader img {
			    margin-top: 600px;
			    padding-left: 300px;
			}

			a.readabilityLink {
			    color: #B80000;
			}
			div.cite input {
			    width: 150px;
			    margin-right: 10px;
			    border-style: solid;
			    border-color: #d9d9d9;
			    border-width: 1px;
			}
			div.story-whole {
			    -webkit-font-smoothing: antialiased;
			}
			a.perror {
			    margin-left: 609px;
			    font-style: italic;
			    font-size: 12px;
			    color: #757575;
			    text-decoration: none;
			}	
			div.seocodary {
			    font-size: 12px;
			}	
			 a.button {
                  -webkit-animation-duration: 2s;
                  -webkit-animation-iteration-count: infinite !important; 
                  color: #fff !important;
                  background-color: #ff5c00 !important;
                  font: normal normal bold 50px Helvetica, Arial, sans-serif !important;
                  padding: 8px 13px 9px; float: left !important; 
                  margin-top: 10px !important;
                  -moz-border-radius: 5px !important; 
                  -webkit-border-radius: 5px !important;
                  -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
                  -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
                  text-shadow: 0 -1px 1px rgba(0,0,0,0.25) !important;
                  border-bottom: 1px solid rgba(0,0,0,0.25) !important;
                  cursor: pointer !important;
                  text-decoration: none;
                }
                .btnSignUp {
                    height: 86px;
                    margin-top: 90px;
                }

                div.signup-onpage {
                    float: left;
                    margin-left: 136px;
                }
                div.getStartedHighlight p {
                    text-align: center;
                }

                div.getStartedHighlight {
                    position: fixed;
                    bottom: 0;
                    height: 51px;
                    margin-left: 19%;
                    width: 870px;
                    background-color: #1f1f1f;
                    color: #ffffff;
                    font-family: \'Droid Sans\';
                    font-size: 19px;
                    background: -moz-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.39) 43%, rgba(0,0,0,0.9) 100%); /* FF3.6+ */
                    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(43%,rgba(0,0,0,0.39)), color-stop(100%,rgba(0,0,0,0.9))); /* Chrome,Safari4+ */
                    background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0.39) 43%,rgba(0,0,0,0.9) 100%); /* Chrome10+,Safari5.1+ */
                    background: -o-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0.39) 43%,rgba(0,0,0,0.9) 100%); /* Opera11.10+ */
                    background: -ms-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0.39) 43%,rgba(0,0,0,0.9) 100%); /* IE10+ */
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#00000000\', endColorstr=\'#e6000000\',GradientType=0 ); /* IE6-9 */
                    background: linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0.39) 43%,rgba(0,0,0,0.9) 100%); /* W3C */
                    -ms-filter: "progid:DXImageTransform.Microsoft.Blur(pixelRadius=2)";
        			filter: progid:DXImageTransform.Microsoft.Blur(pixelRadius=2);
                }
                
                div.getStartedHighlight p {
                    text-shadow: 1px 0px 1px #303030;
                    filter: dropshadow(color=#303030, offx=1, offy=0);
                    -webkit-font-smoothing: antialiased;
                }
            	
		</style>
	  </head>
		
	<body>';
	if(!$user->is_loaded())
	{
		echo '<div class="user"><div class="prof-pic"><img src="'.$memberImage.'"></div><div class="name-cta">'.$phrase.'</div><div class="descrip">Read <b>news</b> with friends. Discover <b>news</b> with the world. <div class="seocodary">Share as easy as <b> Highlight, Comment, Done.</b> Literally read news with friends. Follow your interests.</div></div> <div class="signup-vid"><iframe src="http://player.vimeo.com/video/26961578?byline=0&amp;color=ff9933" width="400" height="225" frameborder="0"></iframe></div><div class="signup-onpage"><div class="btnSignUp"><a class="button" href="http://www.kahub.com">Sign Up!</a></div></div></div>';
	} else {
		echo '<div class="anylogo"><a href="http://www.kahub.com"><img src="anysharelogomed.png"/></a></div>';
	}
	echo '<div class="new-story-top" onClick=location.href="http://www.kahub.com/anyShare/random_loader.php?iter='.$iterf.'&user='.$uid.'"><a href="http://www.kahub.com/anyShare/random_loader.php?iter='.$iterf.'&user='.$uid.'">New story &raquo;</a></div>';
	echo '<div class="story-whole"><div class="cite"><input value="'.$shortURL.'" />via <a href="'.$url.'" target="_blank">'.$domain.'</a></div>';
	echo "<a href='mailto:bugs@kahub.com?subject=".$domain."%20looks%20funny%20[anyShare]%20[Parse]&body=".$url.'    
	
	'.$ua."' class='perror'>Something looks strange? Tell us.</a>";
	echo $storyText;
	echo "<div class='warning'>kahub has no affiliation with ".$domain.". This clean, readable view is provided merely as a convenience, and should not imply any affiliation, endorsement, or partnership of ".$domain." with ipsumedia limited/kahub or with any of its subsidiaries.</div></div>";
	if($ft==1){
	    echo "<div class='getStartedHighlight'><p>Share with your friends by <b>highlighting</b> anything that you find interesting</p></div>";
	}
	echo" </body></html>";

?>
