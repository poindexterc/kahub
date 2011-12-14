<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
include('../AppCode/image.thumbnail.php');
include_once "../AppCode/FBConnect/fbmain.php";
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/settingsDBHandler.php';


$user = new flexibleAccess();
if(!$user->is_loaded())
{
	header('Location:' . Settings::GetRootURL() . 'login.php');	
}
else
{
	require_once '../AppCode/MasterPageScript.php';
	

	Page::Page_Load();
       


	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>connichiwah | Settings</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type="text/javascript" src="' . $rootURL . 'js/si.files.js"></script>
				<script type="text/javascript">
					$myjquery(document).ready(function(){
						SI.Files.stylizeAll();
					});
				function showreasons(){
					$("#reason").show();
				}
			
				</script>
				<style type="text/css" title="text/css">
				/* <![CDATA[ */

				.SI-FILES-STYLIZED label.cabinet
				{
					width: 294px;
					height: 180px;
					background: url(../images/website/uploadphot-2.jpg) 0 0 no-repeat;
					display: block;
					overflow: hidden;
					cursor: pointer;
				}

				.SI-FILES-STYLIZED label.cabinet input.file
				{
					position: relative;
					height: 100%;
					width: auto;
					opacity: 0;
					-moz-opacity: 0;
					filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
				}

				/* ]]> */
				</style>';
	echo '<link type="text/css" rel="stylesheet" href="' . $rootURL . 'l/settingscss.css"/> ';
	echo '	</head>';
	echo '	<body>';
	echo '	
						<div class="header">
    						<div class="reg-head">    							
    							<h1><a href="' . $rootURL . 'l/settings.php">Settings</a></h1>
								<a href = "' . $rootURL . '"><img alt="" src="../images/website/form-logo.jpg" class="reg-logo"/></a>
				            
								<div class="cl"></div>							
    						</div>
						</div>
	
	
	
				<div class="container">';
	//echo			MasterPage::GetHeader();
	echo '			<div class="mainDiv">';	
	echo '				<!-- Content Page Code Starts -->
						
						
						<div class="main">
							<div class="reg1-main">	
								<ul class="steps wrapper">
					            
									<li class="step-1">
										<h2>Profile Pic</h2>
										<h3><a href="' . $rootURL . 'l/settings.php?action=1">Change your profile pic</a></h3>
									</li>
					                
									<li class="step-2">
										<h2>Notifications</h2>
										<h3><a href="' . $rootURL . 'l/settings.php?action=2">Tweak notifications</a></h3>
									</li>
					                
									<li class="step-3">
										<h2>Other</h2>
										<h3><a href="' . $rootURL . 'l/settings.php?action=3">Anything else...</a></h3>
									</li>
					            
								</ul>';
								//Home Page Content Area Starts
	echo						$LiteralContent;
								//Home Page Content Area Ends				    
	echo '						</div>    
							</div>	
							<!-- Content Page Code Ends --> ';
	echo '				<div class="clear" ></div>';
	echo '			</div>';
	echo			MasterPage::GetFooter();
	echo '	    </div>';
	echo '	</body>';
	echo '</html>';
}
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
				$StepNo = Page::GetStepNo();
				if(isset($_POST['btnUpload']))
				{
					$userID = $GLOBALS['user']->userID;
					$imageID = HelpingDBMethods::GetMemberImageID($userID);
					$messageImageCreation = "";
					$imageID = Page::SaveImageDataAndGetImageID($imageID, $messageImageCreation);
					
					$Query = "UPDATE  tbl_member SET ImageID = '$imageID' WHERE   (MemberID = '$userID')";
					$QueryResult =  mysql_query($Query)or die(mysql_error());
					
					if($messageImageCreation != "")
					{						
						//$imageSource = HelpingDBMethods::GetImageData($imageID, 'member'); 
						$GLOBALS['LiteralMessage'] = $messageImageCreation;// . '<input type = "button" onclick = "GetPopUpLightBox(\'' . $imageSource . '\', 125, 125, \'Thumbnail\')" value = "Please Create Thumbnail" />';
					}
					else
					{
						$GLOBALS['LiteralMessage'] = 'Image Uploaded Successfully';
						$StepNo = 3;
					}
				}
				
				if($StepNo == 0)
				{
					Page::FindFacebookFriends();				
				}
				if($StepNo == 1)
				{
					Page::UploadProfilePic();
				}
				elseif($StepNo == 2)
				{
					Page::ChangeNotify();
				}
				elseif($StepNo == 3)
				{
					Page::OtherSettings();
				}
				
				elseif($stepNo==4){
					$n1 = mysql_real_escape_string($_POST['1']);
				    $n2 = mysql_real_escape_string($_POST['2']);
					$n3 = mysql_real_escape_string($_POST['2']);
				    $n4 = mysql_real_escape_string($_POST['4']);
					$n5 = mysql_real_escape_string($_POST['5']);
				    $n6 = mysql_real_escape_string($_POST['6']);

				    $arr = array('1'=>$n1, '2'=>$n2, '3'=>$n3, '4'=>$n4, '5'=>$n5, '6'=>$n6);
					foreach ($arr as $key=>$value){
						$changenotifyquery = mysql_query("INSERT INTO 'admin5_connichiwah'.'tbl_unsubscribe' ('unsubIndex', 'MemberID', 'UnsubscribeType') VALUES (NULL, '$userID', '$key', '$value');");
					    if($changenotifyquery)
				        {
				        	echo "<h1>Success</h1>";
				        	echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
				        }
				        else
				        {
				     		echo "<h1>Error</h1>";
				        	echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
				        }    	
				     }
					}
				
				}				
			
			mysql_close($DBConnection);
		}
	}
	
	function FindFacebookFriends()
	{
		if ($GLOBALS['fbme'])
		{
			$uid    = $GLOBALS['fbme']['id'];
			//or you can use $uid = $fbme['id'];
			
			$fql    =   "SELECT first_name, last_name 
						 from user 
						 where uid in (SELECT uid2 from friend where uid1=" . $uid . ") AND is_app_user = 1";
						 //echo $fql;
			$param  =   array(
					'method'    => 'fql.query',
					'query'     => $fql,
					'callback'  => ''
					);
			$fqlResult   =   $GLOBALS['facebook']->api($param);
			if(count($fqlResult) > 0)
			{
				$rootURL = Settings::GetRootURL();
				$data = '';
				foreach($fqlResult as $friendUser)
				{
					$first_name = $friendUser['first_name'];
					$last_name = $friendUser['last_name'];
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE (mFirst_Name = '$first_name') AND (mLast_Name = '$last_name')";
					$QueryResult =  mysql_query($Query)or die(mysql_error());
					$row = mysql_fetch_array($QueryResult);
					while( $row != false)
					{
						$data = '<div style = "">
									<span><input type = "checkbox" class = "fb_user_friend" value = "' . $row['MemberID'] . '" />' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '</span>
								 </div>';
						$row = mysql_fetch_array($QueryResult);
					}
					
				}
				$GLOBALS['LiteralContent'] = <<<HTML
	            
				<p class="pt-8">connichiwah is built on trust.</p>
	            
				<p class="pt-20">
					Please Select your Facebook Friends to add them.
				</p>
				<div id = "message-div"></div>
				<div class = "friend-list-container">
					{$data}
	            </div>
				<input type="button" value="" class = "reg-submit" onclick = "AddFacebookFriends()"/>
HTML;
			}
			else
			{
				Page::UploadProfilePic();
			}
		}
		else
		{
			Page::UploadProfilePic();
		}
	}
	
	function ChangeNotify()
	{
		$rootURL = Settings::GetRootURL();
		$uKey = Page::getKey();
		$uVerify = Page::getVerify();
    
		$GLOBALS['LiteralContent'] = <<<HTML
	            
				<p class="pt-8">Change your notification settings</p>
	            
				<p class="pt-20">
					Please select the email notifications that you wish to unsubscribe from.
				</p>
	            
				<div id = "message-div"></div>
				<div id = "email-data-container">


					<form method="post" action="changenotifyHandler.php?key={$uKey}&verify={$uVerify}" name="registerform" id="registerform">
					<fieldset>
						<input name ='keyVal' id ='keyVal' value='{$uKey}' style="display:none"/><input name ='veriVal' id='veriVal' value='{$uVerify}'  style="display:none"/>
						<li><input type="checkbox" name ='1' value='1' id='1'> Someone personally replies to a comment I made</input></li>
						<li><input type="checkbox" name ='3' value='3' id='3'> Someone accepts a friend request I made</input></li>
				        <li><input type="checkbox" name ='4' value='4' id='4'> I recive a new badge</input></li>
						<li><input type="checkbox" name ='5' value='5' id='5'> Someone shared something with me personally</input></li>
						<li><input type="checkbox" name = '6' value='6' id='6'> Someone brags to me personally</input></li>
						<li><input type="checkbox" name = '2' value='2' id='2'> Someone sends me a friend request</input></li><br />
					</fieldset>
					<input type="submit" name="unsubscribe" id="unsubscribe" value="Unsubscribe from Selected" />
					
					</form>
			
HTML;
	}
	

	

	
	
	
	
	function OtherSettings()
	{
		$rootURL = Settings::GetRootURL();
		$userID = $GLOBALS['user']->userID;
		
    	$friends = settingsDBHandler::GetFriends($userID);
    	$trust = settingsDBHandler::GetTrust($userID);
		$uKey = Page::getKey();
		$uVerify = Page::getVerify();
		
		$GLOBALS['LiteralContent'] = <<<HTML
<div style="height: 70px"></div>
					<div class="accordion">
					        <div id="unfriend" class="section">
					                <h3>
					                        <a href="#unfriend">Edit friends</a>
					                </h3>
									
					                <div>
										<form method="post" action="removeFriendsHandler.php?key={$uKey}&verify={$uVerify}" name="removefriends" id="removefriends">
										<fieldset>
											<h4> Select the friend you would like to remove from your friends list</h4>

					                        <p>{$friends}</p>
											<input name ='keyVal' id ='keyVal' value='{$uKey}' style="display:none"/><input name ='veriVal' id='veriVal' value='{$uVerify}' style="display:none"/>
											</fieldset> <br>
											<input type="submit" name="remove" id="remove" value="Permenantly Remove Selected Friend" />
											</form>
					                </div>
					        </div>
					        <div id="untrust" class="section">
					                <h3>
					                        <a href="#untrust">Untrust Friends</a>
					                </h3>
					                <div>
					                        <form method="post" action="removeFriendsHandler.php" name="untrustfriends" id="untrustfriends">
											<fieldset>
												<h4> Select the friend you would like to untrust</h4>
						                        <p>{$trust}</p>
												</fieldset> 
												<input type="submit" name="remove" id="remove" value="Untrust Selected Friend" />
												</form>
					                </div>
					        </div>
							<div id="other" class="section">
					                <h3>
					                        <a href="#other">Other</a>
					                </h3>
					                <div>
							
					                        <p>Deactivate Account</p>
					                        
					                        
											
										<div class='choosedeactivate'>
											<li><p><input type="radio" id='N' name='delete' value = 'N' onClick="if(document.getElementById('reason').style.display=='block') {document.getElementById('reason').style.display='none';}"> No, I'd like to keep my account and my friends</input></p></li>
											<li><p><input type="radio" id='Y' name='delete' value = 'Y' onClick="if(document.getElementById('reason').style.display=='none') {document.getElementById('reason').style.display='block';}"> Yes, I would like to permanently deactivate my account</input></p></li>
					                </div>
					        </div>
					</div>

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
										<div id="helpboxf" style="display:none">Connichiwah prides itself on a sophisticated algorithim called StoryRank. StoryRank generates a page based on over 100 different individual attributes personalized to you.</a> </div>
										<li><input type="checkbox" name ='nofriends' value='nofriends' id='nofriends' onClick="if(document.getElementById('helpboxg').style.display=='none') {document.getElementById('helpboxg').style.display='block';} else {document.getElementById('helpboxg').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> Not enough friends on on connichiwah</input></li> 
										<div id="helpboxg" style="display:none"> You can invite your friends to connichiwah easily. To find friends you already have made online, <a href="http://www.connichiwah.com/l/Registration.php?action=0">use our friend finder here</a> To get new friends to join connichiwah, <a href="http://www.connichiwah.com/l/Registration.php?action=1">you can invite them here</a> </div>
										<li><input type="checkbox" name ='bored' value='bored' id='bored'onClick="if(document.getElementById('helpboxh').style.display=='none') {document.getElementById('helpboxh').style.display='block';} else {document.getElementById('helpboxh').style.display='none';} if(deactivate.disabled == true){deactivate.disabled = false;}"> I am just bored of connichiwah</input></li>
										<div id="helpboxh" style="display:none">Connichiwah is more interesting with friends. To find friends you already have made online, <a href="http://www.connichiwah.com/l/Registration.php?action=0"> use our friend finder here</a> To get new friends to join connichiwah, <a href="http://www.connichiwah.com/l/Registration.php?action=1">you can invite them here</a>  
											</p></div>
										
										</fieldset> 
										<input type="submit" name="deactivate" id="deactivate" value="Permanantly Deactivate Account" disabled ='true'/>
										</form>
										
										<br />
					                </div>

				</div>
				
				</form>
				
				<!--<a href="{$rootURL}l/Registration.php?action=2"><input type="button" value="" class = "reg-submit"/></a>
				<input type="button" value="" class = "reg-save" onclick = "AddMultipleFriends()"/>-->	

HTML;
	}
	
	
	
	function UploadProfilePic()
	{
		$rootURL = Settings::GetRootURL();
		$userID = $GLOBALS['user']->userID;
		$imageID = HelpingDBMethods::GetMemberImageID($userID);
		$memberImage = '';
		if($imageID == 0)
		{
			$memberImage = $rootURL . 'images/website/phot-2.jpg';
		}
		else
		{
			$memberImage = HelpingDBMethods::GetImageData($imageID, 'member');
		}
		$GLOBALS['LiteralContent'] = <<<HTML
	        <form method = "post" enctype="multipart/form-data" onSubmit = "return CheckPhotoSize()">    
				<h4 class="select-profile">Select your profile picture</h4>
				<div id = "message-div">{$GLOBALS['LiteralMessage']}</div>	           
				<img alt="" src="{$memberImage}" height = "180px" style = "float:left;"/>	           
				<label class="cabinet" style = "float:left; margin-left:5px;">
					<input type = "file" name = 'fileUpload' value = "" class="file"/>
				</label>
				<div class = "cl"></div>
				<div style = "margin-top:50px;">	            
				  <!--<a href="{$rootURL}l/Registration.php?action=3"><input type="button" value="" class = "reg-submit"/></a>-->
				  <input type="submit" value="" class = "reg-submit" name = "btnUpload"/>
				  <input type="button" value="" class = "reg-save" onclick = "GoToURL('{$rootURL}l/Registration.php?action=1')"/>
				  
				</div>
			</form>
HTML;
	}


	function GetStepNo()
	{
		$StepNo = 1;
		if(isset($_GET['action']) && $_GET['action'] >= 0)
		{
			$StepNo = $_GET['action'];	
		}
		else
		{
			$StepNo = 1;
		}	
		return $StepNo;
	}
	

	
	function SaveImageDataAndGetImageID($imageID, &$messageImageCreation)
	{
		$userID = $GLOBALS['user']->userID;
		
		$thumbnailWidth = 125;
		$thumbnailHeight = 125;
		
		$mediumWidth = 250;
		$mediumHeight = 250;
		
		$messageImageCreation = "";
		$toSavePath = "../images/members";
		$saveAs = $userID . '-' . time();
		
		if($_FILES['fileUpload']['error'] == 0)
		{
			if (($_FILES["fileUpload"]["type"] == "image/gif") || ($_FILES["fileUpload"]["type"] == "image/jpeg") || ($_FILES["fileUpload"]["type"] == "image/pjpeg"))
			{
				if($saveAs == "")
				{
					$saveAs = $_FILES['fileUpload']['name'];
				}
				else
				{
					$filename = $_FILES['fileUpload']['name'];
					$ext = substr($filename, strrpos($filename, '.') + 1);
					$saveAs .= "." . $ext;
				}
				
				$saveAs = preg_replace('/[^a-zA-Z0-9\.]/', ' ', $saveAs);
				$saveAs = preg_replace('/ +/', ' ', $saveAs);
				$saveAs = trim($saveAs);
				$saveAs = preg_replace('/ +/', '_', $saveAs);
				
				$target_path = $toSavePath . "/Original/" . $saveAs;
				$target_path_thumbnail = $toSavePath . "/Medium/" . $saveAs;
				move_uploaded_file($_FILES['fileUpload']['tmp_name'], $target_path);
				// standard saving
				$messageImageCreation = Page::GenerateThumbnail($target_path, $target_path, 1024, 1024, false);
				// Medium Size File saving
				$messageImageCreation = Page::GenerateThumbnail($target_path, $target_path_thumbnail, $mediumWidth, $mediumHeight, false);
				
				$target_path_thumbnail = $toSavePath . "/Thumbnail/" . $saveAs;
				$messageImageCreation = Page::GenerateThumbnail($target_path, $target_path_thumbnail, $thumbnailWidth, $thumbnailHeight, false);
				
				$dbSource = "images/members/Original/" . $saveAs;
				$imageID = HelpingDBMethods::SaveImageDataInDB($dbSource, $imageID);
			}
			else
			{
				//code to inform user that he have uploaded non image file
				$messageImageCreation = "Invalid Image File";
			}
		}		
		else
		{
			//$messageImageCreation = "No Image File Selected";
		}
		return $imageID;
	}
	


	
	function assign_rand_value($num)
	{
	// accepts 1 - 36
	  switch($num)
	  {
	    case "1":
	     $rand_value = "a";
	    break;
	    case "2":
	     $rand_value = "r";
	    break;
	    case "3":
	     $rand_value = "A";
	    break;
	    case "4":
	     $rand_value = "T";
	    break;
	    case "5":
	     $rand_value = "b";
	    break;
	    case "6":
	     $rand_value = "q";
	    break;
	    case "7":
	     $rand_value = "D";
	    break;
	    case "8":
	     $rand_value = "l";
	    break;
	    case "9":
	     $rand_value = "1";
	    break;
	    case "10":
	     $rand_value = "N";
	    break;
	    case "11":
	     $rand_value = "2";
	    break;
	    case "12":
	     $rand_value = "k";
	    break;
	    case "13":
	     $rand_value = "3";
	    break;
	    case "14":
	     $rand_value = "K";
	    break;
	    case "15":
	     $rand_value = "8";
	    break;
	    case "16":
	     $rand_value = "H";
	    break;
	    case "17":
	     $rand_value = "U";
	    break;
	    case "18":
	     $rand_value = "e";
	    break;
	    case "19":
	     $rand_value = "v";
	    break;
	    case "20":
	     $rand_value = "E";
	    break;
	    case "21":
	     $rand_value = "X";
	    break;
	    case "22":
	     $rand_value = "f";
	    break;
	    case "23":
	     $rand_value = "u";
	    break;
	    case "24":
	     $rand_value = "y";
	    break;
	    case "25":
	     $rand_value = "p";
	    break;
	    case "26":
	     $rand_value = "9";
	    break;
	    case "27":
	     $rand_value = "R";
	    break;
	    case "28":
	     $rand_value = "0";
	    break;
	    case "29":
	     $rand_value = "o";
	    break;
	    case "30":
	     $rand_value = "B";
	    break;
	    case "31":
	     $rand_value = "O";
	    break;
	    case "32":
	     $rand_value = "S";
	    break;
	    case "33":
	     $rand_value = "L";
	    break;
	    case "34":
	     $rand_value = "Y";
	    break;
	    case "35":
	     $rand_value = "i";
	    break;
	    case "36":
	     $rand_value = "z";
	    break;
	  }
	return $rand_value;
	}
	
	function get_rand_id($length)
	{
	  if($length>0) 
	  { 
	  $rand_id="";
	   for($i=1; $i<=$length; $i++)
	   {
	   mt_srand((double)microtime() * 1000000);
	   $num = mt_rand(1,36);
	   $rand_id .= Page::assign_rand_value($num);
	   }
	  }
	return $rand_id;
	}
	
	
	function getVerify(){
		$userID = $GLOBALS['user']->userID;
		$userQuery = "SELECT * FROM admin5_connichiwah.tbl_member WHERE MemberID = '$userID'";
		$userResult = mysql_query($userQuery) or die(mysql_error());
		$row = mysql_fetch_array($userResult);
		$LiteralMessage = "";
		$LiteralContent = "";
		$v1 = md5($row['mEmail']);
		$v2 = md5($v1);
		$v3 = md5($v2);
		$v4 = sha1($v3);
		$v5 = md5($v4);
		$v6 = md5($v4.$v3);
		$verify = md5($v6);
		return $verify;
	}
	
	function getKey(){
		$rand = Page::get_rand_id(100);
		$key = md5("$rand}");
		return $key;
	}
	
	function GenerateThumbnail($sourcePath, $targetPath, $width, $height, $isMustBeSquare)
	{
		$result = "";
		if(stristr($sourcePath, 'http://') === false && $isMustBeSquare == true) // if file is already uploaded - thumbnail creation Section
		{
			$info = getimagesize($sourcePath);
			if($info[0] == $info[1]) // compare width and height of uploaded image
			{
				$save_to_file = true;
				
				// Quality for JPEG and PNG.
				// 0 (worst quality, smaller file) to 100 (best quality, bigger file)
				// Note: PNG quality is only supported starting PHP 5.1.2
				$image_quality = 100;
				
				// resulting image type (1 = GIF, 2 = JPG, 3 = PNG)
				// enter code of the image type if you want override it
				// or set it to -1 to determine automatically
				$image_type = -1;
				
				// maximum thumb side size
				$max_x = $width;
				$max_y = $height;
				
				// cut image before resizing. Set to 0 to skip this.
				$cut_x = 0;
				$cut_y = 0;
				
				// Folder where source images are stored (thumbnails will be generated from these images).
				// MUST end with slash.
				$images_folder = $sourcePath;
				
				// Folder to save thumbnails, full path from the root folder, MUST end with slash.
				// Only needed if you save generated thumbnails on the server.
				// Sample for windows:     c:/wwwroot/thumbs/
				// Sample for unix/linux:  /home/site.com/htdocs/thumbs/
				$thumbs_folder = $targetPath;
				
				
				
				
				$img = new thumbnail_image;
				
				// initialize
				$img->max_x        = $max_x;
				$img->max_y        = $max_y;
				$img->cut_x        = $cut_x;
				$img->cut_y        = $cut_y;
				$img->quality      = $image_quality;
				$img->save_to_file = $save_to_file;
				$img->image_type   = $image_type;
				
				// generate thumbnail
				$img->GenerateThumbFile($sourcePath, $targetPath);
				$result = "";
			}
			else
			{
				$result = "Thumbnail Creation Failed, Since Image Was Not a Square ";
			}			
		}	
		else // if file is not already uploaded - Sve File From Web Section
		{
			$save_to_file = true;
			
			// Quality for JPEG and PNG.
			// 0 (worst quality, smaller file) to 100 (best quality, bigger file)
			// Note: PNG quality is only supported starting PHP 5.1.2
			$image_quality = 100;
			
			// resulting image type (1 = GIF, 2 = JPG, 3 = PNG)
			// enter code of the image type if you want override it
			// or set it to -1 to determine automatically
			$image_type = -1;
			
			// maximum thumb side size
			$max_x = $width;
			$max_y = $height;
			
			// cut image before resizing. Set to 0 to skip this.
			$cut_x = 0;
			$cut_y = 0;
			
			// Folder where source images are stored (thumbnails will be generated from these images).
			// MUST end with slash.
			$images_folder = $sourcePath;
			
			// Folder to save thumbnails, full path from the root folder, MUST end with slash.
			// Only needed if you save generated thumbnails on the server.
			// Sample for windows:     c:/wwwroot/thumbs/
			// Sample for unix/linux:  /home/site.com/htdocs/thumbs/
			$thumbs_folder = $targetPath;
			
			
			
			
			$img = new thumbnail_image;
			
			// initialize
			$img->max_x        = $max_x;
			$img->max_y        = $max_y;
			$img->cut_x        = $cut_x;
			$img->cut_y        = $cut_y;
			$img->quality      = $image_quality;
			$img->save_to_file = $save_to_file;
			$img->image_type   = $image_type;
			
			// generate thumbnail
			$img->GenerateThumbFile($sourcePath, $targetPath);
			$result = "";
		}	
		
		return $result;
	}
}

?>