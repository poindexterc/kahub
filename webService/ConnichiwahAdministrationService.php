<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/AdministrativeService_HelpingMethods.php';

function GetListOfBadgesToUpdate($Passkey) 
{
	if(Settings::isValidSecretKey($Passkey, 'AdminApplication'))
	{
		$result = '';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$result = AdministrativeService_HelpingMethods::GetListOfBadgesToUpdate();
			}
			mysql_close($DBConnection);
		}		
		return 	$result;
	}
	else
	{
		return 'In valid Key';
	}
} 

function UpdateBadge($PassArray)
{
	$data = explode(',', $PassArray);
	$Passkey = $data[0];
	$BadgeID = $data[1];
	if(Settings::isValidSecretKey($Passkey, 'AdminApplication') && $BadgeID > 0)
	{
		$result = 'Not Updated';
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$result = AdministrativeService_HelpingMethods::UpdateBadge($BadgeID);
			}
			mysql_close($DBConnection);
		}
		//$result = 'Updated';		
		return 	$result;
	}
	else
	{
		return 'In valid Key';
	}
}

ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache 
$server = new SoapServer("ConnichiwahAdministrationService.wsdl"); 
$server->addFunction(array("GetListOfBadgesToUpdate", "UpdateBadge"));
$server->handle(); 
?>