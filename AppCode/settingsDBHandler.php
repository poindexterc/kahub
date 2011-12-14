<?php 
require_once 'ApplicationSettings.php' ;
require_once "HelpingMethods.php" ;
require_once 'MemberDBMethods.php';


class settingsDBHandler
{
function GetFriends($MemberID)
{
	$result = ''; 
	$rootURL = Settings::GetRootURL();
	$Query = "SELECT m.* 
				FROM tbl_friends a
					INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
					INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
				WHERE (a.MemberID_Active =  '$MemberID')";
				//echo $Query;
	$QueryResult =  mysql_query($Query)or die(mysql_error());
	$row = mysql_fetch_array($QueryResult);		
	while($row!=false)
	{
		$friendID = $row['MemberID'];
		$friendshipQuery = "SELECT * FROM tbl_friends WHERE MemberID_Active = '$MemberID'AND MemberID_Passive = '$friendID'";
		$friendResult = mysql_query($friendshipQuery) or die(mysql_error());
		$friendRow = mysql_fetch_array($friendResult);

		$result .= 	'<div style = "friend">
						<span><input type = "checkbox" class = "friend"  name = "friend" value = "' . $friendRow['FriendsID'] . '" />' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '</span>
					 </div>';
		$row = mysql_fetch_array($QueryResult);
	}
	//echo $Query;
	return $result;
}

function GetTrust($MemberID){
	$Query = "SELECT * FROM tbl_trust WHERE MemberID = '$MemberID'";
	$QueryResult = mysql_query($Query) or die(mysql_error());
	$row = mysql_fetch_array($QueryResult);
	while($row!=false){
		$friendQuery = "SELECT * FROM tbl_member WHERE MemberID = $MemberID";
		$friendResult = mysql_query($friendQuery);
		$friendRow = mysql_fetch_array($friendResult);
		while ($friendRow!=false){
			$result .= '<div style="trust">
					<span><li><input type="radio" class="trust" name="trust" id ="trust" value = "' . $row['TrustID'] . '" />' . $friendRow['mFirst_Name'] . ' ' . $friendRow['mLast_Name'] . '</li></span>
				 </div>';
		$friendRow = mysql_fetch_array($friendResult);
		}
	$row = mysql_fetch_array($QueryResult);
	}
	return $result;
}
}
?>