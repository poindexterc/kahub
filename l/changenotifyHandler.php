<?php		
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/Notifications.php';
require_once '../AppCode/MasterPageScript.php';
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
$key =  mysql_real_escape_string($_GET['key']);
$verify =  mysql_real_escape_string($_GET['verify']);
$keyCheck = mysql_real_escape_string($_POST['keyVal']);
$veriCheck = mysql_real_escape_string($_POST['veriVal']);
if ($key != $keyCheck){
	header("Location: http://www.kahub.com/l/invalid.php");
}
if ($verify != $veriCheck){
	header("Location: http://www.kahub.com/l/invalid.php");
}


if ($key =$keyCheck){
	if ($verify = $veriCheck){
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '<head>';
		echo '<title>kahub</title>';
		echo '<style type="text/css">
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
		</style>	';
		echo		MasterPage::GetHeadScript();
		echo '<meta http-equiv="Refresh" content="5; URL=http://www.kahub.com/l/settings.php">' ;
		echo '	</head>';
		echo '<body>';
		
		
		

		$userID = $GLOBALS['user']->userID;

							$n1 = mysql_real_escape_string($_POST['1']);
						    $n2 = mysql_real_escape_string($_POST['2']);
							$n3 = mysql_real_escape_string($_POST['3']);
						    $n4 = mysql_real_escape_string($_POST['4']);
							$n5 = mysql_real_escape_string($_POST['5']);
						    $n6 = mysql_real_escape_string($_POST['6']);

							$DBConnection = Settings::ConnectDB();
							$db_selected = mysql_select_db($GLOBALS['databaseName'], $DBConnection) or die(mysql_error());
							$yay = false;
						    $arr = array('1'=>$n1, '2'=>$n2, '3'=>$n3, '4'=>$n4, '5'=>$n5, '6'=>$n6);
							foreach ($arr as $key=>$value){
								if ($value != NULL){
									$query = mysql_query("INSERT INTO admin5_connichiwah.tbl_unsubscribe VALUES (NULL, '$userID', '$value');") or die(mysql_error());
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
						if ($yay==true){
							echo '<div class="changeMessage"><div id="changeMessageHead">Nice! Your settings were sucessfully changed</div><div id="changeMessageBody">You will be redirected back in 5 seconds</div></div>';
						} elseif ($yay==false) {
							echo '<div class="changeMessage"><div id="changeMessageHead">Well, this is embarassing!</div><div id="changeMessageBody">Something went wrong, please try again</div></div>';
						} elseif ($yay==nq){
								echo '<div class="changeMessage"><div id="changeMessageHead">Sorry, what did you say?</div><div id="changeMessageBody">Sorry, I didn\'t get that. Please try again.</div></div>';
						} else {
							echo '<div class="changeMessage"><div id="changeMessageHead">Well, this is embarassing!</div><div id="changeMessageBody">Something went wrong, please try again</div></div>';
						}

		
	}
}
echo '</body>';
echo '</html>';
?>