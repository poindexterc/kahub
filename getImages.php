<?php

$html = file_get_contents('http://www.nytimes.com/2011/01/15/sports/football/15matthews.html?_r=1&hp');

$dom = new DOMDocument();

@$dom->loadHTML($html);

$xp = new DOMXPath($dom);

$imgs = $xp->evaluate("/html/body//img");


$urls = array();

for ($i = 0; $i < $imgs->length; $i++) {
	

$img = $imgs->item($i);
$imgSrc = $img->getAttribute('src');
if (preg_match("/\bAD\b/i", "$imgSrc")) {
	echo 'bad'; 
	
	echo $imgSrc;
	echo 'bad end<br>'; 
} else if (preg_match("/\badx\b/i", "$imgSrc")){ 
	echo 'bad'; 
	
	echo $imgSrc;
	echo 'bad end<br>';
} else {
	echo 'good'; 
	
	echo $imgSrc;
	echo 'good end<br>';
	$urls[] = $img->getAttribute('src');

}


?>

<html>

<body>

<?php 
	$minWidth = 315;
	$minHeight = 378;
		
	foreach ($urls as $url) { 
	$norm = htmlspecialchars($url);
	list($width, $height, $type, $attr) = getimagesize("$norm");
	if ($width>$minWidth){
		if($height>$minHeight){
	
?>
<img src="<?php echo htmlspecialchars($url) ?>" /><br />

<?php } else { 
	echo 'no height';
} 
} else {
	echo'no width';
}
}
}
?>

</body>

</html>



