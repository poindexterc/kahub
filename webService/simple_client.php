<?php

$echo = isset($_GET['input'])? $_GET['input'] : '';

print "<h2>Echo Web Service</h2>";
print "<form action='simple_client.php' method='GET'/>";
print "<input name='input' value='$echo'/><br/>";
print "<input type='Submit' name='submit' value='GO'/>";
print "</form>";
if($echo != ''){
	$client = new SoapClient("ConnichiwahAdministrationService.wsdl");//new SoapClient(null, array('location' => "http://localhost/connichiwah/test/ws/simple_server.php", 'uri' => "urn://tyler/req"));
	
	$result = $client->GetListOfBadgesToUpdate("12345");	
	print_r($result);
	//$result = $client->UpdateBadge("1234,12");
	//print_r($result);
}
?>
     