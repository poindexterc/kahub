<?php

require_once 'lib/Readability.inc.php';
// get latest Medialens alert 
// (change this URL to whatever you'd like to test)
$url = $_GET['rURL'];
$html = file_get_contents($url);

// Note: PHP Readability expects UTF-8 encoded content.
// If your content is not UTF-8 encoded, convert it 
// first before passing it to PHP Readability. 
// Both iconv() and mb_convert_encoding() can do this.

// If we've got Tidy, let's clean up input.
// This step is highly recommended - PHP's default HTML parser
// often does a terrible job and results in strange output.

if (function_exists('tidy_parse_string')) {
	$tidy = tidy_parse_string($html, array('indent'=>true), 'UTF8');
	$tidy->cleanRepair();
	$html = $tidy->value;
}
$Readability     = new Readability($html, $html_input_charset); // default charset is utf-8
$ReadabilityData = $Readability->getContent();
echo $ReadabilityData['title'];

?>