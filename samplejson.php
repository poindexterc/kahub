<?php

function getTags($title){ 
  $url1 = "http://query.yahooapis.com/v1/public/yql?q=select * from search.termextract where context=\"";
  $url2 = "\"&diagnostics=false";
  $full = $url1.$title.$url2;
  $xml = simplexml_load_file($full);
  $string = "";
	foreach ($xml->results->Result as $Result) {
      $string = $Result.' , '.$string;
	}
	echo $string;
} 

$story = $_GET["title"];

echo getTags($story); //Outputs 36
?>

