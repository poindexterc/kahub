<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/BadgeMethods.php';
class AdministrativeService_HelpingMethods
{
	function GetListOfBadgesToUpdate()
	{
		$result = ''; 
		$Query = "SELECT * FROM tbl_badge_application";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			if(time() > strtotime($row['Last_Update'] . '+' . $row['Duration'] . ' ' . $row['duration_type']))
			{
				$result .= $row['BadgeID'];
			}
			$row = mysql_fetch_array($QueryResult);
			if($row != false)
			{
				$result .= ',';
			}
		}
		return $result;
	}
	
	function UpdateBadge($BadgeID)
	{
		$result = "Updated";
		BadgeMethods::UpdateBadge($BadgeID);
		return $result;		
	}
}
?>