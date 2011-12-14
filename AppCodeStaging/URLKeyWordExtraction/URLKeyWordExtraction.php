<?php
require_once 'class.multi-auto-keyword.php';
class URLKeyWordExtraction
{
	function GetTagKeyWords($url, $limit = 5)
	{
		//$url = 'http://sports.espn.go.com/mlb/news/story?id=5739358';
		$arr = URLKeyWordExtraction::GetKeyWords($url);
		$arr1 = array_diff($arr,array("edpick"));
		return array_slice($arr1,0,$limit);
	}
	
	
	function GetCategoryKeyWords($url)
	{
		//$url = 'http://sports.espn.go.com/mlb/news/story?id=5739358';
		$arr = URLKeyWordExtraction::GetKeyWords($url);
		$tech = 0;
		$sports = 0;
		$apple = 0;
		$politics = 0;
		$tv = 0;
		$skiing = 0;
		$gaming = 0;
		$poker = 0;
		$finance = 0;
		$photo = 0;
		$football = 0;
		$baseball = 0;
		$soccer = 0;
		$gossip = 0;
		$music = 0;
		$green = 0;
		$science = 0;
		$basketball = 0;
		$edu = 0;
		$movies = 0;
		$journalisim = 0;
		$biz = 0;
		$fashion = 0;
		foreach ($arr as $word) 
		{
			if ($word=='television') $tv = $tv + 5;
			elseif ($word=='NBC') $tv = $tv + 5;
			elseif ($word=='hulu') $tv = $tv + 5;
			elseif ($word=='shows') $tv = $tv + 3;
			elseif ($word=='season') $tv = $tv + 2;
			elseif ($word=='neilsen') $tv = $tv + 7;
			elseif ($word=='ski') $skiing = $skiing + 5;
			elseif ($word=='skiing') $skiing = $skiing + 7;
			elseif ($word=='k2') $skiing = $skiing + 5;
			elseif ($word=='snow') $skiing = $skiing + 3;
			elseif ($word=='powder') $skiing = $skiing + 3;
			elseif ($word=='gaming') $gaming = $gaming + 7;
			elseif ($word=='ps3') $gaming = $gaming + 5;
			elseif ($word=='xbox') $gaming = $gaming + 5;
			elseif ($word=='wow') $gaming = $gaming + 5;
			elseif ($word=='activision') $gaming = $gaming + 5;
			elseif ($word=='ea') $gaming = $gaming + 5;
			elseif ($word=='controller') $gaming = $gaming + 3;
			elseif ($word=='wii') $gaming = $gaming + 5;
			elseif ($word=='game') $gaming = $gaming + 3;
			elseif ($word=='werule') $gaming = $gaming + 5;
			elseif ($word=='ngmoco') $gaming = $gaming + 5;
			elseif ($word=='joystiq') $gaming = $gaming + 5;
			elseif ($word=='zanga') $gaming = $gaming + 5;
			elseif ($word=='poker') $poker = $poker + 7;
			elseif ($word=='ace') $poker = $poker + 5;
			elseif ($word=='flush') $poker = $poker + 2;
			elseif ($word=='finance') $finance = $finance + 7;
			elseif ($word=='economics') $finance = $finance + 5;
			elseif ($word=='economy') $finance = $finance + 3;
			elseif ($word=='accountant') $finance = $finance + 3;
			elseif ($word=='photography') $photo = $photo + 7;
			elseif ($word=='camera') $photo = $photo + 5;
			elseif ($word=='shutter') $photo = $photo + 5;
			elseif ($word=='canon') $photo = $photo + 3;
			elseif ($word=='apple') $apple = $apple + 4;
			elseif ($word=='football') $football = $football + 5;
			elseif ($word=='linebacker') $football = $football + 7;
			elseif ($word=='quarterback') $football = $football + 3;
			elseif ($word=='field') $football = $football + 2;
			elseif ($word=='eagles') $football = $football + 2;
			elseif ($word=='redskins') $football = $football + 5;
			elseif ($word=='baseball') $baseball = $baseball + 7;
			elseif ($word=='homerun') $baseball = $baseball + 5;
			elseif ($word=='pitcher') $baseball = $baseball + 4;
			elseif ($word=='base') $baseball = $baseball + 2;
			elseif ($word=='phillies') $baseball = $baseball + 4;
			elseif ($word=='soccer') $soccer = $soccer + 7;
			elseif ($word=='ball') $soccer = $soccer + 3;
			elseif ($word=='field') $soccer = $soccer + 2;
			elseif ($word=='goal') $soccer = $soccer + 3;
			elseif ($word=='celeb') $gossip = $gossip + 5;
			elseif ($word=='perez') $gossip = $gossip + 7;
			elseif ($word=='gossip') $gossip = $gossip + 5;
			elseif ($word=='paris') $gossip = $gossip + 2;
			elseif ($word=='tmz') $gossip = $gossip + 5;
			elseif ($word=='music') $music = $music + 7;
			elseif ($word=='album') $music = $music + 5;
			elseif ($word=='itunes') $music = $music + 3;
			elseif ($word=='record') $music = $music + 5;
			elseif ($word=='song') $music = $music + 7;
			elseif ($word=='track') $music = $music + 2;
			elseif ($word=='green') $green = $green = 5;
			elseif ($word=='enviornment') $green = $green = 5;
			elseif ($word=='eco-friendly') $green = $green = 5;
			elseif ($word=='coal') $green = $green = 2;
			elseif ($word=='epa') $green = $green = 5;
			elseif ($word=='science') $science = $science + 5;
			elseif ($word=='health') $science = $science + 5;
			elseif ($word=='lab') $science = $science + 3;
			elseif ($word=='obesity') $science = $science + 7;
			elseif ($word=='disease') $science = $science + 5;
			elseif ($word=='disabled') $science = $science + 5;
			elseif ($word=='virus') $science = $science + 5;
			elseif ($word=='hospital') $science = $science + 3;
			elseif ($word=='basketball') $basketball = $basketball + 5;
			elseif ($word=='hoop') $basketball = $basketball + 5;
			elseif ($word=='court') $basketball = $basketball + 3;
			elseif ($word=='air') $basketball = $basketball + 2;
			elseif ($word=='dribble') $basketball = $basketball + 7;
			elseif ($word=='education') $edu = $edu + 7;
			elseif ($word=='school') $edu = $edu + 5;
			elseif ($word=='college') $edu = $edu + 5;
			elseif ($word=='university') $edu = $edu + 5;
			elseif ($word=='class') $edu = $edu + 2;
			elseif ($word=='dean') $edu = $edu + 5;
			elseif ($word=='movie') $movies = $movies + 5;
			elseif ($word=='box office') $movies = $movies + 7;
			elseif ($word=='theater') $movies = $movies + 3;
			elseif ($word=='theatere') $movies = $movies + 2;
			elseif ($word=='actor') $movies = $movies + 4;
			elseif ($word=='actress') $movies = $movies + 4;
			elseif ($word=='film') $movies = $movies + 7;
			elseif ($word=='journalisim') $journalisim = $journalisim + 5;
			elseif ($word=='lead') $journalisim = $journalisim + 2;
			elseif ($word=='news') $journalisim = $journalisim + 3;
			elseif ($word=='story') $journalisim = $journalisim + 3;
			elseif ($word=='article') $journalisim = $journalisim + 3;
			elseif ($word=='writer') $journalisim = $journalisim + 5;
			elseif ($word=='business') $biz = $biz + 5;
			elseif ($word=='company') $biz = $biz + 5;
			elseif ($word=='quarter') $biz = $biz + 3;
			elseif ($word=='entrepenuer') $biz = $biz + 7;
			elseif ($word=='work') $biz = $biz + 2;
			elseif ($word=='fashion') $fashion = $fashion + 6;
			elseif ($word=='runway') $fashion = $fashion + 7;
			elseif ($word=='show') $fashion = $fashion + 3;
			elseif ($word=='clothes') $fashion = $fashion + 2;
			elseif ($word=='politics') $politics = $politics + 5;
			elseif ($word=='bill') $politics = $politics + 5;
			elseif ($word=='congress') $politics = $politics + 5;
			elseif ($word=='election') $politics = $politics + 3;
			elseif ($word=='campaign') $politics = $politics + 3;
			elseif ($word=='jerrymandering') $politics = $politics + 7;
			elseif ($word=='obama') $politics = $politics + 5;
			elseif ($word=='white house') $politics = $politics + 5;
			elseif ($word=='pelosi') $politics = $politics + 5;
			elseif ($word=='government') $politics = $politics + 2;
			elseif ($word=='dell') $tech = $tech + 3;
			elseif ($word=='ipad') $apple = $apple + 3;
			elseif ($word=='iphone') $apple = $apple + 3;
			elseif ($word=='ipod') $apple = $apple + 3;
			elseif ($word=='macbook') $apple = $apple + 7;
			elseif ($word=='android') $tech = $tech + 1;
			elseif ($word=='gadget') $tech = $tech + 3;
			elseif ($word=='technology') $tech = $tech + 5;
			elseif ($word=='engadget') $tech = $tech + 5;
			elseif ($word=='tech') $tech = $tech + 7;
			elseif ($word=='sports') $sports = $sports + 5;
		}
		$catarr = array("tech" => $tech, "sports" => $sports, "politics" => $politics, "apple" => $apple, "tv" => $tv, "photography" => $photo, "finance" =>$finance, "poker" => $poker, "tv" => $tv, "skiing" => $skiing, "gaming" => $gaming, "celeb gossip" => $gossip, "education" => $edu, "movies" => $movies, "business" => $biz, "baseball" => $baseball, "football" => $football, "soccer" => $soccer, "music" => $music, "green" =>$green, "journalisim" => $journalisim, "science" => $science);
		$maxnum = 0;
		foreach($catarr as $category)
		{
			if ($category > $maxnum) $maxnum = $category;
		}
		//return $catarr;
		$max = array_search($maxnum, $catarr);
		return $max;		
		//print_r($catarr);
		//print($max);
		
	}
	
	private function GetKeyWords($url)
	{
		$content = file_get_contents($url);
		$str = strip_tags($content);
		
		$text = $str;
		
		$params['content'] = $text;
		
		// 1-word keywords 
		$params['min_word_length'] = 4;  // min length of single words 
		$params['min_word_occur']  = 3;  // min occur of single words 
		
		// 2-word keyphrases 
		$params['min_2words_length']        = 4;  // min length of words for 2 word phrases; value 0 will DISABLE !!! 
		$params['min_2words_phrase_length'] = 10; // min length of 2 word phrases 
		$params['min_2words_phrase_occur']  = 3;  // min occur of 2 words phrase 
		
		// 3-word keyphrases 
		$params['min_3words_length']        = 4;  // min length of words for 3 word phrases; value 0 will DISABLE !!! 
		$params['min_3words_phrase_length'] = 12; // min length of 3 word phrases 
		$params['min_3words_phrase_occur']  = 2;  // min occur of 3 words phrase
		
		$keyword = new autokeyword($params);
		
		// REQUIRED
		$autoKeywords = $keyword->get_keywords();
		
		$list = $autoKeywords;
		$arr = explode(',',$list);
		
		return $arr;
	}
}
?>