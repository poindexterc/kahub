<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
include('../AppCode/image.thumbnail.php');
include_once "../AppCode/FBConnect/fbmain.php";
require_once '../AppCode/HelpingDBMethods.php';

$user = new flexibleAccess();

	require_once '../AppCode/MasterPageScript.php';
	

	$LiteralMessage = "";
	$LiteralContent = "";
       
	$privacy =  mysql_real_escape_string($_POST['privacy']);
	$novalue =  mysql_real_escape_string($_POST['novalue']);
	$extension =  mysql_real_escape_string($_POST['extensionannoying']);
	$contentnotrel =  mysql_real_escape_string($_POST['contentnotrel']);
	$nocontent =  mysql_real_escape_string($_POST['notenoughcontent']);
	$slow =  mysql_real_escape_string($_POST['slow']);
	$betterelse =  mysql_real_escape_string($_POST['betterelseware']);
	$nofriends =  mysql_real_escape_string($_POST['nofriends']);
	$bored =  mysql_real_escape_string($_POST['bored']);
	$key =  mysql_real_escape_string($_GET['key']);
	$verify =  mysql_real_escape_string($_GET['verify']);
	$keyCheck = mysql_real_escape_string($_POST['keyVal']);
	$veriCheck = mysql_real_escape_string($_POST['veriVal']);
	if ($key != $keyCheck){
		header("Location: http://www.connichiwah.com/member/invalid.php");
	}
	else if ($verify != $veriCheck){
		header("Location: http://www.connichiwah.com/member/invalid.php");
	} else {		
		$userID = $GLOBALS['user']->userID;
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '	<head>';
		echo '		<title>connichiwah | Deactivate Account</title>';
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
					body {
						margin:50px 0px; padding:0px;
						text-align:center;
						}
						.changeMessage{
							background-color: #333; /*ie*/
							background-color: rgba(9, 2, 2, .3);
							color: #FFF;
							height: 100px;
							width: 500px;
							margin:50px auto;
							padding: 15px;
							-moz-border-radius: 4px;
							border-radius: 4px;
							}
						#changeMessageHead{
							font-size: 30px;
							font-family: "AvenirLTStd85Heavy" , sans-serif;
						}

						#changeMessageBody{
							font-size: 11pt;
							font-family: "AvenirLTStd55Roman" , sans-serif;
						}
					</style>';
		echo '<link type="text/css" rel="stylesheet" href="' . $rootURL . 'member/privacycss.css"/> ';
		echo '	</head>';
		echo '	<body>';
			$yay = false;
		    $arr = array('1'=>$privacy, '2'=>$novalue, '3'=>$extension, '4'=>$contentnotrel, '5'=>$nocontent, '6'=>$slow, '7'=>$betterelse, '8'=>$nofriends, '9'=>$bored);
			foreach ($arr as $key=>$value){
				if ($value != NULL){
					$query = mysql_query("INSERT INTO admin5_connichiwah.tbl_leave VALUES (NULL, '$userID', '$key');");
					if($query) {
						$yay = true;
					} else {
					  $yay = false;
					echo '<br>';
					}
				} else {
					$yay = nq;
					
				}						

		     }
	
		echo '	
							<div class="header">
	    						<div class="reg-head">    							
	    							<h1><a href="#">Deactivate?</a></h1>
									<a href = "' . $rootURL . '"><img alt="" src="../images/website/form-logo.jpg" class="reg-logo"/></a>

									<div class="cl"></div>							
	    						</div>
							</div>



					<div class="container">';
		//echo			MasterPage::GetHeader();
		echo '			<div class="mainDiv">';	
		echo '				<!-- Content Page Code Starts -->


							<div class="main">
								<div class="reg1-main">	';
		if ($yay==true){
									//Home Page Content Area Starts
		echo "			
									<div id='pbody'><div class='headpriv'>Are you sure?</div><br> 
									<form method='post' action='deactivatenow.php?key={$key}&verify={$verify}'>
									<input type=textbox name=keyVal value={$key} style='display:none;'>
									<input type=textbox name=veriVal value={$verify} style='display:none;'>	
									
																	
									<div id='surebody'> Are you sure that you want to deactivate your account? <br> If you do, your friends will have no way to share stuff with you. <br> Know that this action is permanent and CANNOT BE UNDONE. <br> <input type='button' value ='No, I want to keep my account and my friends' name ='n' onClick=\"window.location='http://www.connichiwah.com/member'\"> <input type='submit' name='deactivate' id='deactivate' value='Yes, I wish to permanently delete my account.'/>
									</form>";
									
		}  elseif ($yay==false) {
		echo '<div class="changeMessage"><div id="changeMessageHead">Well, this is embarassing!</div><div id="changeMessageBody">Something went wrong, please try again</div></div>';
		} elseif ($yay==nq) {
		echo '<div class="changeMessage"><div id="changeMessageHead">Sorry, what did you say?</div><div id="changeMessageBody">Sorry, I didn\'t get that. Please try again.</div></div>';
		} else {
		echo '<div class="changeMessage"><div id="changeMessageHead">Well, this is embarassing!</div><div id="changeMessageBody">Something went wrong, please try again</div></div>';
		}
		
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

	

?>