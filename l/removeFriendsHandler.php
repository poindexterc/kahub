<?php		
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/HelpingMethods.php';
require_once '../AppCode/RequestQuery.php';
require_once '../AppCode/Notifications.php';
require_once 'dbconn.php';
require_once '../AppCode/MasterPageScript.php';
$key =  mysql_real_escape_string($_GET['key']);
$verify =  mysql_real_escape_string($_GET['verify']);
$keyCheck = mysql_real_escape_string($_POST['keyVal']);
$veriCheck = mysql_real_escape_string($_POST['veriVal']);
if ($key != $keyCheck){
	
	header("Location: http://www.connichiwah.com/member/invalid.php");
}
if ($verify != $veriCheck){
	header("Location: http://www.connichiwah.com/member/invalid.php");
}

if ($key==$keyCheck){
	if ($verify==$veriCheck){
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml">';
		echo '<head>';
		echo '<title>connichiwah</title>';
		echo '<style type="text/css">
		body {
			margin:50px 0px; padding:0px;
			text-align:center;
			}
			.changeMessage{
				background-color: #333; /*ie*/
				background-color: rgba(9, 2, 2, .3);
				color: #FFF;
				height: 200px;
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
		echo '<meta http-equiv="Refresh" content="5; URL=http://www.connichiwah.com/member/settings.php">' ;
		echo '	</head>';
		echo '<body>';

		$userID = $GLOBALS['user']->userID;

		$selected_friend = $_POST['friend'];
		//echo '1';
		//echo $selected_friend;
		//echo '1';
		$friendQuery =  "SELECT * FROM tbl_friends WHERE FriendsID = '$selected_friend'";
		$friendResult = mysql_query($friendQuery) or die(mysql_error());
		$friendRow = mysql_fetch_array($friendResult);	
		$friendID = $friendRow['MemberID_Passive'];
		
		

							$mysql = mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
							$yay = false;

								if ($selected_friend != NULL){
									
									$query = mysql_query("DELETE FROM admin5_connichiwah.tbl_friends WHERE FriendsID = '$selected_friend'");
									if($query) {
										$yay = true;
									} else {
										$yay = false;
									echo '<br>';
									}
								} else {
									$yay = nq;
								}	
								
								if ($friendID!=NULL){
										$query = mysql_query("DELETE FROM admin5_connichiwah.tbl_friends WHERE MemberID_Passive = '$userID' AND MemberID_Active = '$friendID'");
										if($query) {
											$yay = true;
										} else {
											$yay = false;
										echo '<br>';
										}
									} else {

									}
								}
								
								if ($yay==true){
									echo '<div class="changeMessage"><div id="changeMessageHead">Nah nah nah nah, nah nah nah nah, hey hey hey, goodbye! </div><div id="changeMessageBody">You will be redirected back in 5 seconds</div></div>';
								} elseif ($yay==false) {
									echo '<div class="changeMessage"><div id="changeMessageHead">Well, this is embarassing!</div><div id="changeMessageBody">Something went wrong, please try again</div></div>';
								} elseif ($yay==nq){
										echo '<div class="changeMessage"><div id="changeMessageHead">Sorry, what did you say?</div><div id="changeMessageBody">Sorry, I didn\'t get that. Please try again.</div></div>';
								} else {
									echo '<div class="changeMessage"><div id="changeMessageHead">Well, this is embarassing!</div><div id="changeMessageBody">Something went wrong, please try again</div></div>';
								}
								
													
		
	}
echo '</body>';
echo '</html>';
				     
					
?>