<?
require_once "AppCode/FBConnect/facebook.php";

$facebook = new Facebook($config);
$url = "https://graph.facebook.com/oauth/access_token";
$client_id = "223753464308640";
$client_secret = "2517e6c688f3b76a8a1035fea6f3e30a";
$token_url = "https://graph.facebook.com/oauth/access_token?client_id=$client_id&client_secret=$client_secret&type=client_cred"; 
$access_token = file_get_contents($token_url);
$arr= explode('=', $access_token);
$token = $arr[1];
$session = $facebook->getSession();


echo $token;
if(!empty($session) && ($authorize == null)){ 
    $attachment = array
	(
	'api_key'=>'f72a9f5c7b7efe2b2b1af397a9933959',
	'access_token'=>$token,
	'message' => 'message',
	'name' => 'name',
	'caption' => 'caption',
	'link' => 'http://localhost/',
	'description' => 'description',
	'picture' => 'http://localhost/image.jpg'
	);
	$result = $facebook->api('me/feed/','post',$attachment);
    }
     else {
echo "<script type='text/javascript'>top.location.href = '".$facebook->getLoginUrl(array('req_perms' => 'email,read_stream,publish_stream'))."';</script>";      
    }



?>