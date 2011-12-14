<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';

	require_once '../AppCode/MasterPageScript.php';
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	
	$type = $_GET['type'];
	if($type=="photo"){
		$active1="class='activesetting'";
	} else if ($type=="notify"){
		$active2="class='activesetting'";
	} else if($type=="othershyt"){
		$active3="class='activesetting'";
	}else if($type=="bg"){
		$active4="class='activesetting'";
	} else {
		$type ="photo";
		$active1="class='activesetting'";
	}
	if (isset($_POST['upload'])){
		$target_path = "upload/";

		/* Add the original filename to our target path.  
		Result is "uploads/filename.extension" */
		$target_path = $target_path . basename($_FILES['uploadedfile']['name']);
		$origImage = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
		// Original image
		$filename = $target_path;

		// Get dimensions of the original image
		list($current_width, $current_height) = getimagesize($filename);

		// The x and y coordinates on the original image where we
		// will begin cropping the image
		$left = $current_width/4;
		$top = 0;

		// This will be the final size of the image (e.g. how many pixels
		// left and down we will be going)
		$crop_width = 200;
		$crop_height = 200;
		$ratio = MIN( $crop_width / $current_width, $crop_height / $current_height );
		$width = $ratio * $current_width;
		$height = $ratio * $current_height;
		// Resample the image
		$canvas = imagecreatetruecolor($crop_width, $crop_height);
		$current_image = imagecreatefromjpeg($filename);
		if($current_width>200){
			imagecopyresized($canvas, $current_image, 0, 0, 0, 0, $width, $height, $current_width, $current_height);
			imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
		} else {
			imagecopy($canvas, $current_image, 0, 0, $left, $top, $current_width, $current_height);
		}
		imagejpeg($canvas, $filename, 70);
	} 
	

	Page::Page_Load();  
	
	echo '<!DOCTYPE html>';
	echo '<html>';
	echo '  <head>';
	echo '      <title>Settings | kahub</title>';
	echo        MasterPage::GetHeadScript();
	echo '          <script type="text/javascript" src="jquery.form.js"></script>
					<style type="text/css" media="screen">
					a{
					  color: #3E5681;
					  text-decoration: none !important;
					}
					li.activesetting a:hover {
						text-decoration: none;
					}

					li.activesetting {
						text-decoration: none;
					}

					a:hover li.activesetting {
						text-decoration: none;
					}

					a li.activesetting {
						text-decoration: none;
					}

					a:hover {
						text-decoration: none;
					}
					li form input {
                        margin-top: 0;
                        margin-right: auto;
                        margin-bottom: 10px;
                        margin-left: 70px;
                    }
				  </style>
				    <script type="text/javascript" >
                      $myjquery(document).ready(function() { 
                          $myjquery(\'#photoimg\').live(\'change\', function(){ 
                              $myjquery("#dropbox").html(\'\');
                            	$myjquery("#dropbox").html(\'<img src="loader.gif" alt="Uploading...."/>\');
                            	$myjquery("#imageform").ajaxForm({
                            		target: \'#dropbox\'
                            	}).submit();
                            });
                      }); 
                      </script>
				'; 
	echo '<link rel="stylesheet" type="text/css" href="../css/style-profile.css" />';
	echo '  </head>';
	echo '  <body>

		';
	echo            $LiteralHeader;
	echo '      <div class="container">';
	
	echo '          <div class="main wrapper">';
	$types='
	<ul class="typesOfSettings">
		<a href="http://www.kahub.com/l/settings.php?type=photo"><li '.$active1.'>Photo</li></a>
		<a href="http://www.kahub.com/l/settings.php?type=notify"><li '.$active2.'>Notifications</li></a>
		<a href="http://www.kahub.com/l/settings.php?type=bg"><li '.$active4.'>Change Background Image</li></a>
		<a href="http://www.kahub.com/l/settings.php?type=othershyt"><li '.$active3.'>Other tweedely bits</li></a>
	</ul>';
	echo $types;
	echo '  <div class="main-content getstarted settings">';
	$photo = '
	<div id="getStartedWrap">
		<ul class="getStarted">
			<li>
				<div class="topHeader">Drop in a photo of your good lookin\' self</div><br>
				<div class="droparea spot" data-width="200" data-height="200" data-type="jpg" data-crop="true" data-quality="70" id="dropbox" >'.$img.'
					<form enctype="multipart/form-data" action="upload.php" method="POST" style="opacity: 0">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
					<input name="uploadedfile" type="file"/><br />
					<input type="submit" value="Upload File" />
					</form></div>
					<form id="imageform" method="post" enctype="multipart/form-data" action=\'ajaximage.php\'>
                        <input type="file" name="photoimg" id="photoimg" />
					<li>
					</li>
					</form>
			</li>
		</ul>
	</div>';
	$changebg = '
	<div id="getStartedWrap">
		<ul class="getStarted">
			<li>
				<div class="topHeader">Change your background</div><br>
					<form enctype="multipart/form-data" action="/l/changebg.php" method="POST">
					<input name="uploadedfile" type="file"/><br />
					<input type="submit" name="upload" value="Upload File" />
					</form>
			</li>
		</ul>
	</div>';
$uKey = getKey();
$uVerify = getVerify();
$notify = '<p class="pt-8">Change your notification settings</p>
	<p class="pt-20">
	Please select the email notifications that you wish to unsubscribe from.
	</p>
	<div id = "message-div"></div>
	<div id = "email-data-container">
	<form method="post" action="changenotifyHandler.php?key='.$uKey.'&verify='.$uVerify.'" name="registerform" id="registerform" class="setting">
		<fieldset>
			<input name =\'keyVal\' id =\'keyVal\' value=\''.$uKey.'\' style="display:none"/><input name =\'veriVal\' id=\'veriVal\' value=\''.$uVerify.'\'  style="display:none"/>
				<li><input type="checkbox" name =\'1\' value=\'1\' id=\'1\'> Someone personally replies to a comment I made</input></li>
				<li><input type="checkbox" name =\'3\' value=\'3\' id=\'3\'> Someone accepts a friend request I made</input></li>
				<li><input type="checkbox" name = \'2\' value=\'2\' id=\'2\'> Someone sends me a friend request</input></li><br />
		</fieldset>
		<input type="submit" name="unsubscribe" id="unsubscribe" value="Unsubscribe from Selected" />
	</form>';
$other = <<<HTML
	<p>Deactivate my account (Temporary)</p>

        </br>
<div class='choosedeactivate'>
	<li><p><input type="radio" id='N' name='delete' value = 'N' onClick="if(document.getElementById('reason').style.display=='block') {document.getElementById('reason').style.display='none';}"> Taking a vacation from kahub, deactivate my account keeping my friends and account.</input></p></li>


        </br>
        <p>Delete my account (Permanent)</p>
        </br>

	<li><p><input type="radio" id='Y' name='delete' value = 'Y' onClick="if(document.getElementById('reason').style.display=='none') {document.getElementById('reason').style.display='block';}"> Yes, I would like to permanently delete my account.</input></p></li>
</div>


<div id="reason" style="display:none">
<h3>
Reason for leaving (required, select all that apply)
</h3>
<div>
<form method="post" action='verify.php?key={$uKey}&verify={$uVerify}' name="deactivate" id="deactivate">
<fieldset>
	<p>
<input name ='keyVal' id ='keyVal' value='{$uKey}' style="display:none"/><input name ='veriVal' id='veriVal' value='{$uVerify}'  style="display:none"/>

<li><input type="checkbox" name ='privacy' value='privacy' id='privacy' onClick="if(document.getElementById('helpboxa').style.display=='none') {document.getElementById('helpboxa').style.display='block';} else {document.getElementById('helpboxa').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> I have a privacy concern</input></li><div id="helpboxa" style="display:none">Did you know that you can change your privacy settings every time you comment. When you are ready to comment, simply click on the lock icon, and you can share with only one person (source). 
Our extention does not track your website browsing history. We only track which page you are currently on when you comment on something.</div>
<li><input type="checkbox" name ='novalue' value='novalue' id='novalue' onClick="if(document.getElementById('helpboxb').style.display=='none') {document.getElementById('helpboxb').style.display='block';} else {document.getElementById('helpboxb').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> I don't feel that connichiwah is valuable to me</input></li>
<div id="helpboxb" style="display:none">A lot of people make connichiwah valuable by adding more friends. The more that you and your friends use the service, the more you will get out of it. It's really easy to find new friends, just search using the search bar on the homepage. Or, if you want to find your friends that are alredy using connichiwah, just use our friend finder feature <a href="http://www.connichiwah.com/l/Registration.php?action=0"> right here</a> </div>

<li><input type="checkbox" name ='extensionannoying' value='extensionannoying' id='extensionannoying' onClick="if(document.getElementById('helpboxc').style.display=='none') {document.getElementById('helpboxc').style.display='block';} else {document.getElementById('helpboxc').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> I find the extension annoying</input></li>
<div id="helpboxc" style="display:none">We're sorry to hear that you find our extenstion annoying. But you can always uninstall it, and continue to use all of the features of connichiwah. </a> </div>
<li><input type="checkbox" name ='contentnotrel' value='contentnotrel' id='contentnotrel' onClick="if(document.getElementById('helpboxd').style.display=='none') {document.getElementById('helpboxd').style.display='block';} else {document.getElementById('helpboxd').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> The content is not relevent to me</input></li>
<div id="helpboxd" style="display:none"> You can get better content by simply trusting more people. To "Trust" someone, just click the Trust button directly under a persons profile picture on any site that they have commented on.</a> </div>
<li><input type="checkbox" name ='notenoughcontent' value='notenoughcontent' id='notenouhgcontent' onClick="if(document.getElementById('helpboxe').style.display=='none') {document.getElementById('helpboxe').style.display='block';} else {document.getElementById('helpboxe').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> There is not enough content</input></li>
<div id="helpboxe" style="display:none">A lot of people tell us that you can get more content by sharing more with your friends. To share something with your friends (if you have the extension installled), just highlight anything that you find interesting, type a comment, and click share.</a> </div>
<li><input type="checkbox" name ='slow' value='slow' id='slow' onClick="if(deactivate.disabled == true){deactivate.disabled = false;}"> The site is slow</input></li>
<li><input type="checkbox" name ='betterelseware' value='betterelseware' id='betterelseware' onClick="if(document.getElementById('helpboxf').style.display=='none') {document.getElementById('helpboxf').style.display='block';} else {document.getElementById('helpboxf').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> There are better alternatives out there</input></li>
<div id="helpboxf" style="display:none">kahub prides itself on a sophisticated algorithim called StoryRank. StoryRank generates a page based on over 100 different individual attributes personalized to you.</a> </div>
<li><input type="checkbox" name ='nofriends' value='nofriends' id='nofriends' onClick="if(document.getElementById('helpboxg').style.display=='none') {document.getElementById('helpboxg').style.display='block';} else {document.getElementById('helpboxg').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> Not enough friends on on connichiwah</input></li> 
<div id="helpboxg" style="display:none"> You can invite your friends to connichiwah easily. To find friends you already have made online, <a href="http://www.connichiwah.com/l/Registration.php?action=0">use our friend finder here</a> To get new friends to join connichiwah, <a href="http://www.connichiwah.com/l/Registration.php?action=1">you can invite them here</a> </div>
<li><input type="checkbox" name ='bored' value='bored' id='bored'onClick="if(document.getElementById('helpboxh').style.display=='none') {document.getElementById('helpboxh').style.display='block';} else {document.getElementById('helpboxh').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> I am just bored of connichiwah</input></li>
<div id="helpboxh" style="display:none">kahub is more interesting with friends. To find friends you already have made online, <a href="http://www.kahub.com/l/Registration.php?action=0"> use our friend finder here</a> To get new friends to join connichiwah, <a href="http://www.connichiwah.com/l/Registration.php?action=1">you can invite them here</a>  
	</p></div>

</fieldset> 
<input type="submit" name="deactivate" id="deactivate" value="Permanantly Deactivate Account" disabled ='true'/>
</form>

<br />
</div>
</div>
</div>
</div>
HTML;
	if($type=="photo"){
		echo $photo;
	} else if ($type=="notify"){
		echo $notify;
	} else if ($type=="othershyt"){
		echo $other;
	} else if($type=="bg"){
	    echo $changebg;
	}
	
	//Home Page Content Area Ends                   
	echo '              </div>';
	echo '          </div>';
	echo '      </div>';
	echo            MasterPage::GetFooter();
	echo '  </body>';
	echo '</html>';


class Page
{
	function Page_Load()
	{
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
					
			}
			mysql_close($DBConnection);
		}
		
		
	}
}
function getVerify(){
	$userID = $GLOBALS['user']->userID;
	$v6 = md5($userID).time();
	$verify = md5($v6);
	return $verify;
}

function getKey(){
	$rand = rand(0,100);
	$key = md5("{$rand}");
	return $key;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
		<title></title>
	</head>
	<body>
	</body>
</html>
