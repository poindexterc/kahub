<?php
$url = $_GET['url'];
$string = file_get_contents($url);
// Regex that extracts the images (full tag)
$image_regex_src_url = '/<img[^>]*'.

'src=[\"|\'](.*)[\"|\']/Ui';

preg_match_all($image_regex, $string, $out, PREG_PATTERN_ORDER);

$img_tag_array = $out[0];

echo "<pre>"; print_r($img_tag_array); echo "</pre>";

// Regex for SRC Value
$image_regex_src_url = '/<img[^>]*'.

'src=[\"|\'](.*)[\"|\']/Ui';

preg_match_all($image_regex_src_url, $string, $out, PREG_PATTERN_ORDER);

$images_url_array = $out[1];

echo "<pre>"; print_r($images_url_array); echo "</pre>";

// Fetch Page Function

function FetchPage($path)
{
$file = fopen($path, "r"); 

if (!$file)
{
exit("The was a connection error!");
} 

$data = '';

while (!feof($file))
{
// Extract the data from the file / url

$data .= fgets($file, 1024);
}
return $data;
}

?>