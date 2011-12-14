<?php 
class Settings
{
	//private Static $_Server_State = 'local'; //'Remote'
	private static $_DBServerName = "localhost";
	private static $_SecretKey = 'dssdjfbjdsfkjsdngknklfdjgnvkjdfghdlsckbdiughb';
	// Settings For Development Server
	//private static $_DBName = "db_connichiwah";
	//private static $_UserName = "root";
	//private static $_DBPassword = "";
	//private static $_ROOTURL = 'http://localhost/connichiwah/';
	
	// Settings For Production Server
	private static $_DBName = "admin5_connichiwah";
	private static $_UserName = "root";
	private static $_DBPassword = "M2917712!dexter";
	private static $_ROOTURL = 'http://www.kahub.com/';
	
	function GetRootURL()
	{
		return Settings::$_ROOTURL;
	}
	
	function GetDatabaseName()
	{
		return Settings::$_DBName;
	}
	
	function ConnectDB()
	{
		$connection = mysql_pconnect(Settings::$_DBServerName, Settings::$_UserName, Settings::$_DBPassword)or die(mysql_error()); 	
		return $connection;
	}
	
	function isValidSecretKey($key, $type)
	{
		if($key == Settings::$_SecretKey)
		{
			return true;			
		}
		else
		{
			return false;
		}
	}	
}
?>