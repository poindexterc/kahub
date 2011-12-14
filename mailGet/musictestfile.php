<?php
$song = $_GET['l'];
$musicURL = 'https://gdata.youtube.com/feeds/api/videos?q=pumped%20up%20kicks&start-index=1&max-results=1&v=2&alt=json&category=music';
$lyrics = json_decode(file_get_contents($musicURL), true);

print_r($lyrics['feed']['entry'][0]['title']['$t']);