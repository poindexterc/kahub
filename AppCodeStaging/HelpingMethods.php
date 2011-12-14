<?php
require_once 'ApplicationSettings.php';
require_once 'RequestQuery.php';
require_once 'HelpingDBMethods.php';
require_once 'CommentsMethods.php';
class HelpingMethods
{
	function ConvertDateToArray($DOB)
	{
		if($DOB != '' && $DOB != null && $DOB != 'null')
		{
			$DOB = date('M j Y', strtotime($DOB));
		}
		else
		{
			$DOB = date('M j Y');
		}
		$r = explode(' ', $DOB);		
		return array('month'=>$r[0], 'day'=>$r[1], 'year'=>$r[2]);
	}
			
	function GetDomain($url)
	{
		$url = parse_url($url);		
		return str_replace("www.","", $url['host']);		
	}
	
	function GetLimitedText($Text, $Limit)
	{
		$result = "";
		$Text = strip_tags($Text);
		if(strlen($Text) > $Limit)
		{
			$result = substr($Text, 0, $Limit) . ' ...';
		}
		else
		{
			$result = $Text;
		}
				
		return $result ;
	}
	
	function CleanString($string)
	{
		$t = preg_replace('/[^a-zA-Z0-9]/', ' ', $string);		
		$t = trim($t);
		$t = preg_replace('/ +/', ' ', $t);
		return $t;
	}
	
	function strToHex($string)
	{
		$hex='';
		for ($i=0; $i < strlen($string); $i++)
		{
			$myval = dechex(ord($string[$i]));
			while(strlen($myval) < 4)
			{
				$myval = '0' . $myval;	
			}
			$hex .= $myval;
		}
		return $hex;
	}
	
	function hexToStr($hex)
	{
		$string='';
		for ($i=0; $i < strlen($hex)-1; $i+=4)
		{
			$string .= chr(hexdec($hex[$i].$hex[$i+1].$hex[$i+2].$hex[$i+3]));
		}
		return $string;
	}
	
	function GetFlickerImage($StoryID)
	{
		$rootURL = Settings::GetRootURL();
		$imgURL = $rootURL . 'images/website/box-38.jpg';
		$tags = HelpingDBMethods::GetStoryTags($StoryID);
		$tagString = implode(",", $tags);
		if(strlen($tagString) > 0)
		{
			$url = 'http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=90485e931f687a9b9c2a66bf58a3861a&safe_search=1&content_type=1&sort=relevance&license=4&per_page=1&tag_mode=any&tags=' . $tagString . '';
			$imgURL = HelpingMethods::get_data($url);			
		}
		return $imgURL;
	}
	
	function get_data($url)
	{
		$imgURL = '';
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		$xmldata = stripslashes($data);
		if(strlen($xmldata) > 0)
		{
			$xml = simplexml_load_string($xmldata);
			
			foreach ($xml[0] as $tagName=>$atributes)
			{
				foreach ($atributes[0] as $p=>$a)
				{
					//echo $p . '=>' . $a['id'];
					$imgURL = 'http://farm' . $a['farm'] . '.static.flickr.com/' . $a['server'] . '/' .$a['id'] . '_' . $a['secret'] . '_s.jpg';
				}
			}
		}
		return $imgURL;
	}
}

?>