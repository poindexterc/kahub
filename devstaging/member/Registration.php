<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
include '../AppCode/image.thumbnail.php';
include_once '../AppCode/FBConnect/fbmain.php';
$user = new flexibleAccess();
if(!$user->is_loaded())
{
	header('Location:' . Settings::GetRootURL() . 'login.php');	
}
else
{
	require_once '../AppCode/MasterPageScript.php';
	

	$LiteralMessage = "";
	$LiteralContent = "";
	Page::Page_Load();

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>Connichiwah : Registration</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type="text/javascript" src="' . $rootURL . 'js/si.files.js"></script>
				<script type="text/javascript">
					$myjquery(document).ready(function(){
						SI.Files.stylizeAll();
					});
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
	echo "	<script type = 'text/javascript'>
				\$myjquery(document).ready(function(){
					var nb = 'No Browser';
					var userAgent = navigator.userAgent.toString().toLowerCase();
					if ((userAgent.indexOf('safari') != -1) && !(userAgent.indexOf('chrome') != -1)) 
					{
						//alert('We should be on Safari only!');
						nb = 'Safari Web Browser';
						\$myjquery('#safari-extention-link').show();
					}
					else if((userAgent.indexOf('chrome') > -1))
					{
						//alert('We should be on Chrome only!');
						nb = 'Google Chrome';
						\$myjquery('#chrome-extention-link').show();
					}
					else if((userAgent.indexOf('mozilla') > -1)&& (userAgent.indexOf('firefox')!=-1) && !(userAgent.indexOf('chrome') != -1) && !(userAgent.indexOf('safari') != -1))
					{
						//&& (userAgent.indexOf('firefox')!=-1)
						//alert('We Should be on Fire Fox Only');
						nb = 'Mozila Fire Fox';
						\$myjquery('#firefox-extention-link').show();
					}
					else	
					{
						//alert('We Should be on Some Other Browser');
						\$myjquery('#div-browser-not-found').show();
						\$myjquery('#div-browser').hide();
					}
					
					\$myjquery('#name-of-browser').html(nb);
				});
			</script>";
	echo '	</head>';
	echo '	<body>';
	echo '		
						<div class="header">
    						<div class="reg-head">    							
    							<h1><a href="' . $rootURL . 'member/Registration.php">Getting Started</a></h1>
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
										<h2>Step 1</h2>
										<h3><a href="' . $rootURL . 'member/Registration.php?action=1">Find people to trust</a></h3>
									</li>
					                
									<li class="step-2">
										<h2>Step 2</h2>
										<h3><a href="' . $rootURL . 'member/Registration.php?action=2">Upload a profile pic</a></h3>
									</li>
					                
									<li class="step-3">
										<h2>Step 3</h2>
										<h3><a href="' . $rootURL . 'member/Registration.php?action=3">Get more social</a></h3>
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
					Page::FindFriends();
				}
				elseif($StepNo == 2)
				{
					Page::UploadProfilePic();
				}
				elseif($StepNo == 3)
				{
					Page::GetExtention();
				}				
			}
			mysql_close($DBConnection);
		}
	}
	
	function FindFacebookFriends()
	{
		$data = '';
		if ($GLOBALS['fbme'])
		{
			$uid    = $GLOBALS['fbme']['id'];
			//or you can use $uid = $fbme['id'];
			
			$fql    =   "SELECT first_name, last_name, pic_big
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
					$data .= '<table cellspacing = "5" cellpadding = "5" style = "">';
					$first_name = $friendUser['first_name'];
					$last_name = $friendUser['last_name'];
					$Query = "SELECT MemberID, mFirst_Name, mLast_Name FROM tbl_member WHERE (mFirst_Name = '$first_name') AND (mLast_Name = '$last_name')";
					$QueryResult =  mysql_query($Query)or die(mysql_error());
					$row = mysql_fetch_array($QueryResult);
					while( $row != false)
					{
						$data .= '<tr>
									<td>
										<input type = "checkbox" class = "fb_user_friend" value = "' . $row['MemberID'] . '" />
									</td>
									<td>
										<img src = " ' . $friendUser['pic_big'] . '" style = "height:50px;" />
									</td>
									<td>
										' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '
									</td>
								  </tr>';
						$row = mysql_fetch_array($QueryResult);
					}
					$data .= '</table>';
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
				Page::FindFriends();
			}
		}
		else
		{
			Page::FindFriends();
		}
	}
	
	function FindFriends()
	{
		$rootURL = Settings::GetRootURL();
    
		$GLOBALS['LiteralContent'] = <<<HTML
	            
				<p class="pt-8">connichiwah is built on trust.</p>
	            
				<p class="pt-20">
					Please enter the email addresses of the 5 friends tou trust the most.
				</p>
	            
				<p class="pb-20">
					If they are not already on connichiwah, we'll send them an invite.	
				</p>
				<div id = "message-div"></div>
				<div id = "email-data-container">
					<input type = "hidden" id = "total-no-of-addresses" value = "5" />
					<input id = "email-1" type="text" value="Email Address" class="reg1-textfield email" onblur="WaterMark(this, event, 'Email Address');" onfocus="WaterMark(this, event, 'Email Address');" onchange = "CheckEmail(this.value, 'Email Address', 'ok-1')"/>		            
					<input id = "description-1" type="text" value="What are they in to? (optional)" class="reg1-textfield desc" onblur="WaterMark(this, event, 'What are they in to? (optional)');" onfocus="WaterMark(this, event, 'What are they in to? (optional)');"/>		            
					<img id = "ok-1" alt="" src="{$rootURL}images/website/tick-btn-green.jpg" class="reg1-tick"/>
		            
					<input id = "email-2" type="text" value="Email Address" class="reg1-textfield email" onblur="WaterMark(this, event, 'Email Address');" onfocus="WaterMark(this, event, 'Email Address');" onchange = "CheckEmail(this.value, 'Email Address', 'ok-2')"/>		            
					<input id = "description-2" type="text" value="What are they in to? (optional)" class="reg1-textfield desc" onblur="WaterMark(this, event, 'What are they in to? (optional)');" onfocus="WaterMark(this, event, 'What are they in to? (optional)');"/>		            
					<img id = "ok-2" alt="" src="{$rootURL}images/website/tick-btn-green.jpg" class="reg1-tick"/>
		            
					<input id = "email-3" type="text" value="Email Address" class="reg1-textfield email" onblur="WaterMark(this, event, 'Email Address');" onfocus="WaterMark(this, event, 'Email Address');" onchange = "CheckEmail(this.value, 'Email Address', 'ok-3')"/>		            
					<input id = "description-3" type="text" value="What are they in to? (optional)" class="reg1-textfield desc" onblur="WaterMark(this, event, 'What are they in to? (optional)');" onfocus="WaterMark(this, event, 'What are they in to? (optional)');"/>		            
					<img id = "ok-3" alt="" src="{$rootURL}images/website/tick-btn-green.jpg" class="reg1-tick"/>
		            
					<input id = "email-4" type="text" value="Email Address (optional)" class="reg1-textfield email" onblur="WaterMark(this, event, 'Email Address (optional)');" onfocus="WaterMark(this, event, 'Email Address (optional)');" onchange = "CheckEmail(this.value, 'Email Address', 'ok-4')"/>		            
					<input id = "description-4" type="text" value="What are they in to? (optional)" class="reg1-textfield desc" onblur="WaterMark(this, event, 'What are they in to? (optional)');" onfocus="WaterMark(this, event, 'What are they in to? (optional)');"/>		            
					<img id = "ok-4" alt="" src="{$rootURL}images/website/tick-btn-green.jpg" class="reg1-tick"/>
		            
					<input id = "email-5" type="text" value="Email Address (optional)" class="reg1-textfield email" onblur="WaterMark(this, event, 'Email Address (optional)');" onfocus="WaterMark(this, event, 'Email Address (optional)');" onchange = "CheckEmail(this.value, 'Email Address', 'ok-5')"/>		            
					<input id = "description-5" type="text" value="What are they in to? (optional)" class="reg1-textfield desc" onblur="WaterMark(this, event, 'What are they in to? (optional)');" onfocus="WaterMark(this, event, 'What are they in to? (optional)');"/>		            
					
					<img id = "plus-btn" alt="" src="{$rootURL}images/website/plus-btn.jpg" class="middle" onclick = "AddNewEmailRow()"/>		            
					<img id = "ok-5" alt="" src="{$rootURL}images/website/tick-btn-green.jpg" class="reg1-tick"/>
	            </div>
				
				<!--<a href="{$rootURL}member/Registration.php?action=2"><input type="button" value="" class = "reg-submit"/></a>
				<input type="button" value="" class = "reg-save" onclick = "AddMultipleFriends()"/>-->	
				<input type="button" value="" class = "reg-submit" onclick = "AddMultipleFriends()"/>
				<input type="button" value="" class = "reg-save" onclick = "GoToURL('{$rootURL}member/Registration.php?action=0')"/>
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
				  <!--<a href="{$rootURL}member/Registration.php?action=3"><input type="button" value="" class = "reg-submit"/></a>-->
				  <input type="submit" value="" class = "reg-submit" name = "btnUpload"/>
				  <input type="button" value="" class = "reg-save" onclick = "GoToURL('{$rootURL}member/Registration.php?action=1')"/>
				  
				</div>
			</form>
HTML;
	}
	
	function GetExtention()
	{
		$rootURL = Settings::GetRootURL();
		$GLOBALS['LiteralContent'] = <<<HTML
			<div id = "div-browser">
			    <p class="pt-20 pb-20">
           			The connichiwah browser extension for <span id = "name-of-browser">NameOfBrowser</span><br />
					allows you to be social anywhere and anywhere.	
			    </p>
	            <span id = "chrome-extention-link" class = "hidden">
					<a href="{$rootURL}download/connichiwah-extention-chrome.rar">
						<img alt="" src="../images/website/get-it-now-342.jpg" />
					</a>
				</span>
	            <span id = "firefox-extention-link" class = "hidden">
					<a href="{$rootURL}download/connichiwah-extention-firefox.rar">
						<img alt="" src="../images/website/get-it-now-342.jpg" />
					</a>
				</span>
	            <span id = "safari-extention-link" class = "hidden">
					<a href="{$rootURL}download/connichiwah-extention-safari.rar">
						<img alt="" src="../images/website/get-it-now-342.jpg" />
					</a>
				</span>
			    
	            
				<p class="pt-8">
           			We respect your privacy. This extension will not provide connichiwah, or any of it's affilliates<br />
					any information about you at all. Not even your IP Address. 'Cause that's just not cool.	
			    </p>
	            
			    
			</div>
			<div id = "div-browser-not-found" class = "hidden">
				<p class="pt-20 pb-20">
           			Sorry, it does not seem that the browser you are using supports the extention.<br/>
           			<strong>Dont't worry, you can still use connichiwah</strong>, but will not be able to connect with your friends anywhere and everywhere.
           		</p>
           		<p>
           			<span>
						<a href="http://www.apple.com/safari/" target = "_blank">
							<img alt="" src="../images/website/download-safari.png" />
						</a>
					</span>
					<span>
						<a href="http://www.google.com/chrome/" target = "_blank">
							<img alt="" src="../images/website/download-chrome.png" />
						</a>
					</span>
					<span>
						<a href="http://www.mozilla.com/firefox/" target = "_blank">
							<img alt="" src="../images/website/download-firefox.png" />
						</a>
					</span>
				</p>	
			    
			</div>
			
			<a href="{$rootURL}"><input type="button" value="" class="reg3-submit"/></a>
HTML;
	}
	
	function GetStepNo()
	{
		$StepNo = 0;
		if(isset($_GET['action']) && $_GET['action'] >= 0)
		{
			$StepNo = $_GET['action'];	
		}
		else
		{
			$userID = $GLOBALS['user']->userID;
			$noOfFriends = HelpingDBMethods::GetNoOfFriends($userID);
			$imageID = HelpingDBMethods::GetMemberImageID($userID);
			if($noOfFriends < 3)
			{
				$StepNo = 0;
			}
			elseif($imageID == 0)
			{
				$StepNo = 2;
			}
			else
			{
				$StepNo = 3;
			}
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