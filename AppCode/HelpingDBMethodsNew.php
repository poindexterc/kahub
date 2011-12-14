<?php
require_once "HelpingMethods.php" ;
require_once 'ApplicationSettings.php' ;
require_once 'MemberDBMethods.php';
require_once "StoryRanking.php" ;
require_once 'URLKeyWordExtraction/URLKeyWordExtraction.php';
require_once 'BadgeMethods.php';
require_once 'Connichiwah.UI.php';
require_once 'Notifications.php';
class HelpingDBMethods
{	
	function SaveURL($url, $title)
	{
		$Query = "INSERT INTO tblurls (URLTitle, URL) VALUES  ('" . $title . "', '" . $url . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function GetAllComments($url)
	{
		$MemberID = $GLOBALS['user']->userID;	
		$result = "";
		$storyID = HelpingDBMethods::GetStoryID($url);
		if($storyID > 0)
		{
			$Query = "SELECT DISTINCT c.Comment_Associated_Text 
					FROM tbl_comments c
					INNER JOIN tbl_friends a ON c.MemberID = a.MemberID_Active OR c.MemberID = a.MemberID_Passive
					INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 		
					WHERE (c.StoryID = '$storyID') AND (a.MemberID_Active =  '$MemberID') ";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			while( $row != false)
			{
				$result .= HelpingMethods::strToHex($row['Comment_Associated_Text']);
				//$result .= $row['Comment_Associated_Text'];
				$row = mysql_fetch_array($QueryResult);
				if($row != false)
				{
					$result .= ',';
				}
			}
		}
		return $result;
	}
	
	function countNumberComments($storyID){
	    if($storyID>0){
	        $Query = "SELECT COUNT(StoryID) as Count from tbl_comments WHERE (StoryID='$storyID') AND (Comment_Text!='Promote') AND (Comment_Text!='Bump')";
	        $QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false){
			    $result = $row['Count'];
			} else {
			    $result = 0;
			}
	    }
	    return $result;
	}
	function GetReplyCount($commentID){
		$MemberID = $GLOBALS['user']->userID;	
		$result = "";
			$Query = "SELECT COUNT(CommentID) as Count FROM tbl_comments WHERE (Reply_To = '$commentID') AND (Comment_Text!='Bump')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			$count = $row['Count'];
			return $count;
	}
	function GetReply($commentID){
		$MemberID = $GLOBALS['user']->userID;	
		$result = "";
			$Query = "SELECT Reply_To FROM tbl_comments WHERE (CommentID = '$commentID') AND (Comment_Text!='Bump')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			$result = $row['Reply_To'];
			return $result;
	}
	function akismet_comment_check( $key, $data ) {
	    $request = 'blog='. urlencode($data['blog']) .
	               '&user_ip='. urlencode($data['user_ip']) .
	               '&user_agent='. urlencode($data['user_agent']) .
	               '&referrer='. urlencode($data['referrer']) .
	               '&permalink='. urlencode($data['permalink']) .
	               '&comment_type='. urlencode($data['comment_type']) .
	               '&comment_author='. urlencode($data['comment_author']) .
	               '&comment_author_email='. urlencode($data['comment_author_email']) .
	               '&comment_author_url='. urlencode($data['comment_author_url']) .
	               '&comment_content='. urlencode($data['comment_content']);
	    $host = $http_host = $key.'.rest.akismet.com';
	    $path = '/1.1/comment-check';
	    $port = 80;
	    $akismet_ua = "kahub Comments | Akismet/2.5.3";
	    $content_length = strlen( $request );
	    $http_request  = "POST $path HTTP/1.0\r\n";
	    $http_request .= "Host: $host\r\n";
	    $http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
	    $http_request .= "Content-Length: {$content_length}\r\n";
	    $http_request .= "User-Agent: {$akismet_ua}\r\n";
	    $http_request .= "\r\n";
	    $http_request .= $request;
	    $response = '';
	    if( false != ( $fs = @fsockopen( $http_host, $port, $errno, $errstr, 10 ) ) ) {

	        fwrite( $fs, $http_request );

	        while ( !feof( $fs ) )
	            $response .= fgets( $fs, 1160 ); // One TCP-IP packet
	        fclose( $fs );

	        $response = explode( "\r\n\r\n", $response, 2 );        
	    }
		return $response[1];

	}

	function spamCheck($data){
		$akismet = HelpingDBMethods::akismet_comment_check( 'e897a16a72e1', $data );
		$spamWordsArray= explode(",", "ahole,anus,ash0le,ash0les,asholes,ass,Ass Monkey,bassterds,bastard,bastards,bastardz,basterds,basterdz,Biatch,bitch,bitches,Blow Job,boffing,butthole,Carpet Muncher,cawk,cawks,Clit,cnts,cntz,cock,cockhead,cock-head,cocks,CockSucker,cock-sucker,crap,cum,cunt,cunts,cuntz,dick,dild0,dild0s,dildo,dildos,dilld0,dilld0s,dominatricks,dominatrics,dominatrix,dyke,enema,f u c k,f u c k e r,fag,fag1t,faget,fagg1t,faggit,faggot,fagit,fags,fagz,faig,faigs,fart,flipping the bird,fuck,fucker,fuckin,fucking,fucks,Fudge Packer,fuk,Fukah,Fuken,fuker,Fukin,Fukk,Fukkah,Fukken,Fukker,Fukkin,g00k,gay,gayboy,gaygirl,gays,gayz,God-damned,h00r,h0ar,h0re,hells,hoar,hoor,hoore,jackoff,jap,japs,jerk-off,jisim,jiss,jizm,jizz,knobz,kunt,kunts,kuntz,Lesbian,Lezzian,Lipshits,Lipshitz,massterbait,masstrbait,masstrbate,masterbaiter,masterbate,masterbates,Motha Fucker,Motha Fuker,Motha Fukkah,Motha Fukker,Mother Fucker,Mother Fukah,Mother Fuker,Mother Fukkah,Mother Fukker,mother-fucker,Mutha Fucker,Mutha Fukah,Mutha Fuker,Mutha Fukkah,Mutha Fukker,n1gr,nastt,nigger,nigur,niiger,niigr,orafis,orgasim,orgasm,orgasum,oriface,orifice,orifiss,packi,packie,packy,paki,pakie,paky,pecker,peeenus,peeenusss,peenus,peinus,pen1s,penas,penis,penis-breath,penus,penuus,Phuc,Phuck,Phuk,Phuker,Phukker,polac,polack,polak,Poonani,pr1c,pr1ck,pr1k,pusse,pussee,pussy,puuke,puuker,queer,queers,queerz,qweers,qweerz,qweir,recktum,rectum,retard,sadist,scank,schlong,screwing,semen,sex,sexy,Sh!t,sh1t,sh1ter,sh1ts,sh1tter,sh1tz,shit,shits,shitter,Shitty,Shity,shitz,Shyt,Shyte,Shytty,Shyty,skanck,skank,skankee,skankey,skanks,Skanky,slut,sluts,Slutty,slutz,son-of-a-bitch,tit,turd,va1jina,vag1na,vagiina,vagina,vaj1na,vajina,vullva,vulva,w0p,wh00r,wh0re,whore,xrated,xxx,b!+ch,bitch,blowjob,clit,arschloch,fuck,shit,ass,asshole,b!tch,b17ch,b1tch,bastard,bi+ch,boiolas,buceta,c0ck,cawk,chink,cipa,clits,cock,cum,cunt,dildo,dirsa,ejakulate,fatass,fcuk,fuk,fux0r,hoer,hore,jism,kawk,l3itch,l3i+ch,lesbian,masturbate,masterbat,masterbat3,mofo,nigga,nigger,nutsack,phuck,scrotum,sh!t,shi+,sh!+,slut,smut,teets,tits,boobs,b00bs,teez,testical,testicle,titt,w00se,jackoff,wank,whoar,whore,dyke,fuck,shit,@$$,amcik,andskota,arse,assrammer,ayir,bi7ch,bitch,bollock,breasts,butt-pirate,cabron,cazzo,chraa,chuj,Cock,cunt,d4mn,daygo,dego,dick,dike,dupa,dziwka,ejackulate,Ekrem,Ekto,enculer,faen,fag,fanculo,fanny,feces,feg,Felcher,ficken,fitt,Flikker,foreskin,Fotze,Fu(,fuk,futkretzn,gay,gook,guiena,h0r,h4x0r,hell,helvete,hoer,honkey,Huevon,hui,injun,jizz,kanker,kike,klootzak,kraut,knulle,kuk,kuksuger,Kurac,kurwa,kusi,kyrpa,lesbo,mamhoon,masturbat,merd,mibun,monkleigh,mouliewop,muie,mulkku,muschi,nazis,nepesaurio,nigger,orospu,paska,perse,picka,pierdol,pillu,pimmel,piss,pizda,poontsee,poop,porn,p0rn,pr0n,pula,pule,puta,puto,qahbeh,queef,rautenberg,schaffer,scheiss,schlampe,schmuck,screw,sh!t,sharmuta,sharmute,shipal,shiz,skrib");
		$dataArray = explode(" ", $data['comment_content']);
		foreach($dataArray as $item){
			if(in_array($item, $spamWordsArray)){
				$akismet= "true";
			}
		}

		return $akismet;
	}
	
	function GetReplies($commentID)
	{
		$MemberID = $GLOBALS['user']->userID;	
		$result = "";
		if($commentID > 0)
		{
			$Query = "SELECT * FROM tbl_comments WHERE (Reply_To = '$commentID') AND (Comment_Text!='Bump') ORDER BY Date_Time ASC";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			while( $row != false)
			{
				$isRestated = HelpingDBMethods::GetRestated($row['CommentID'], $MemberID);
				$imageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
				$name = MemberDBMethods::GetUserName($row['MemberID']);
				$commentData = HelpingDBMethods::GetCommentData($commentID);
				$storyData = HelpingDBMethods::GetStoryData($row['StoryID']);
				$urlhex = HelpingMethods::strToHex($storyData['s-url']);
				$replyCount = HelpingDBMethods::GetReplyCount($row['CommentID']);
				$restateCount = HelpingDBMethods::GetRestateCount($row['CommentID']);
				if($replyCount>1){
					$viewReplies = " &#183; <a href='http://www.kahub.com/l/comments.php?c=".$row['CommentID']."'> ".$replyCount." replies</a>";
				} else if ($replyCount==1) {
					$viewReplies = " &#183; <a href='http://www.kahub.com/l/comments.php?c=".$row['CommentID']."'> ".$replyCount." reply</a>";
				} else {
					$viewReplies = "";
				}
				if(!$isRestated){
						$restate = '&#183; <span class="restateLoad" onClick="restateShow('.$row['CommentID'].')"><a onClick="RestateComment('.$storyID.',\''.$urlhex.'\','.$row['CommentID'].','.$row['MemberID'].')" id="restate-Story-Link-'.$row['CommentID'].'">Restate</a> ('.$restateCount.')</span>';
				} else{
						$restate = '&#183; <span class="restated">Restated! ('.$restateCount.')</span>';
				}
				$replyText ='<a onClick="$myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-text-area-'.$row['CommentID'].'\').focus();" class="doComment">Reply</a> ';
				$commentsBox = '<div class="commentsBox" id="comments-box-'.$row['CommentID'].'"><textarea id="comments-text-area-'.$row['CommentID'].'"></textarea><span class="CommentShow" onClick="commentShow('.$row['CommentID'].')"><a onClick="inlineReply('.$row['StoryID'].',\''.$urlhex.'\','.$row['CommentID'].')" id="replytext">Reply</a></span></div>';
				$imgString = '<a href="http://www.kahub.com/l/profile.php?user='.$row['MemberID'].'"><img class = "comment-user-image" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/></a>';
				$result .= '<li class="replyInline">'.$imgString.'<a href="http://www.kahub.com/l/profile.php?user='.$row['MemberID'].'">'.$name.'</a><div class="commentText">'.$row['Comment_Text'].'</div><div class="commentsElse"><span class="comment">'.$replyText.'</span><span class="restate">'.$restate.' <span class="vreplies">'.$viewReplies.'</span></div>'.$commentsBox.'</li>';
				//$result .= $row['Comment_Associated_Text'];
				$row = mysql_fetch_array($QueryResult);
			}
		}
		return $result;
	}
	
	function GetStorySnippet($storyID, $chars){
		$result = HelpingMethods::GetLimitedText(HelpingDBMethods::GetStoryText($storyID), $chars);
		return $result;
	}
	function GetStoryID($url)
	{
		$result = 0;
		$Query = "SELECT StoryID FROM tbl_story WHERE (Story_URL  = '$url')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['StoryID'];
		}
		return $result;		
	}
	
	function GetStoryData($StoryID)
	{
		$result = '';
		$Query = "SELECT * FROM tbl_story WHERE (StoryID  = '$StoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['s-title'] = $row['Story_Title'];
			$result['s-url'] = $row['Story_URL'];
		}
		return $result;	
	}
	function GetStoryDataFromURL($storyURL)
	{
		$result = '';
		$Query = "SELECT * FROM tbl_story WHERE (Story_URL  = '$storyURL')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['s-title'] = $row['Story_Title'];
			$result['s-id'] = $row['StoryID'];
			$result['s-date'] = $row['DateTime'];
		}
		return $result;	
	}
	function GetDateFromURL($storyURL)
	{
		$result = '';
		$Query = "SELECT DateTime FROM tbl_story WHERE (Story_URL  = '$storyURL')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['DateTime'];
		}
		return $result;	
	}
	function GetStoryTitle($url)
	{
		$title = file_get_contents("http://www.kahub.com/anyShare/storyTitle.php?rURL=".$url);
		return $result;	
	}
	
	function GetMemberIDByComment($CommentID)
	{
		$result = 0;
		$Query = "SELECT MemberID FROM tbl_comments WHERE (CommentID  = '$CommentID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['MemberID'];
		}
		return $result;
	}
	
	function InsertStory($title, $url)
	{
		$Query = "INSERT INTO tbl_story (Story_Title, Story_URL) VALUES  ('" . $title . "', '" . $url . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function insertMemberViewed($StoryID, $MemberID){
		$Query = "INSERT INTO tbl_story_viewed (StoryID, MemberID) VALUES  ('" . $StoryID . "', '" . $MemberID . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function FacebookShare($MemberID, $txt, $title, $url){
		$url = "https://graph.facebook.com/me/feed";
		$access_token_url = "https://graph.facebook.com/oauth/access_token"; 
	  $parameters = "type=client_cred&client_id=" .  
	  $app_id . "&client_secret=31ec0b903044d95e4d0f2e0f0d3552fa";
	  $access_token = file_get_contents($access_token_url . "?" . $parameters);
		$ch = curl_init();
		$attachment = array(
		'access_token'	=>	$access_token,
		'message'	=>	$txt,
		'link' => $url
		);

		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
		$result= curl_exec($ch);

		curl_close ($ch);
	}
	
	
	function GetImageData($ImageID, $of = 'member', $type = 'Original')
	{
		$result = '';
		if($of == 'member')
		{
			$result = 'images/website/photo-1.jpg';
		}
		elseif($of == 'badge')
		{
			$result = 'images/website/circle.jpg';
		}
		elseif($of == 'story')
		{
			$result = 'images/website/circle.jpg';
		}
		else
		{
			$result = 'images/image_not_found.jpg';	
		}
		if($ImageID > 0)
		{
			$Query = "SELECT ImageSrc FROM tbl_images WHERE (ImageID  = $ImageID)";	
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$result = $row['ImageSrc'];
			}
			if($of == "member" && $type == 'thumbnail')
			{
				$result = str_replace("/Original/", "/Thumbnail/", $result);
			}
		}
		if(substr($result, 0, 7) == 'http://')
			return $result; 
		else
			return Settings::GetRootURL() . $result;
		
	}
	
	function SaveImageDataInDB($dbSource, $imageID)
	{
		if($imageID > 0)
		{
			//update image including source field
			$Query = "UPDATE  tbl_images 
					  SET       ImageSrc = '" . $dbSource . "'									 
					  WHERE   (ImageID = '" . $imageID . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			return $imageID;
		}		
		else
		{
			//insert image data
			$Query = "INSERT INTO tbl_images (ImageSrc)	VALUES ('" . $dbSource . "')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$imageID = mysql_insert_id();
			return $imageID;
		}
	}
	
	function PostComments($StoryID, $text_selected, $Comments, $MemberID, $ReplyTo)
	{
		$name = MemberDBMethods::GetUserName($MemberID);
		$email = MemberDBMethods::GetEmail($MemberID);
		$storyData = HelpingDBMethods::GetStoryData($StoryID);
		$data = array('blog' => 'http://www.kahub.com',
		              'user_ip' => $_SERVER['REMOTE_ADDR'],
		              'user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
		              'referrer' => 'http://www.google.com',
		              'permalink' => 'http://kahub.com/',
		              'comment_type' => 'comment',
		              'comment_author' => $name,
		              'comment_author_email' => $email,
		              'comment_author_url' => 'unkown',
		              'comment_content' => $Comments);
		$spam=HelpingDBMethods::spamCheck($data);
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		
		if($spam=="true"){
			$Query = "INSERT INTO tbl_comments (StoryID, Comment_Associated_Text, Comment_Text,  MemberID, Reply_To) 
					VALUES (" . $StoryID . ", '" . $text_selected . "', '" . mysql_real_escape_string(urldecode($Comments)) . "', " . $MemberID . ", " . $ReplyTo . ")";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$commentID = mysql_insert_id();
			HelpingDBMethods::submitSpam($StoryID, $MemberID, $commentID, $Comments);
		} else {
			$Query = "INSERT INTO tbl_comments (StoryID, Comment_Associated_Text, Comment_Text,  MemberID, Reply_To) 
					VALUES (" . $StoryID . ", '" . $text_selected . "', '" . mysql_real_escape_string(urldecode($Comments)) . "', " . $MemberID . ", " . $ReplyTo . ")";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
		return mysql_insert_id();
	}
	function publishStory($StoryID, $hubID)
	{
		$storyData = HelpingDBMethods::GetStoryData($StoryID);
		$domain = HelpingDBMethods::getDomain($storyData['s-url']); 
		$Query = "INSERT INTO tbl_story_published (StoryID, Story_Domain, hub) 
				VALUES (" . $StoryID . ", '" . $domain . "', " . $hubID . ")";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	function submitSpam($StoryID, $MemberID, $CommentID, $Comment)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$Query = "INSERT INTO tbl_spam (MemberID, CommentID, Comment, StoryID, IP) 
				VALUES (" . $MemberID . ", " . $CommentID . ", '" . $Comment . "', " . $StoryID . ", '" . $ip . "' )";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function UIHoverboxReplyPost($txt, $url, $CommentID, $Comments)
	{		
		$MemberID = $GLOBALS['user']->userID;
		$txt = HelpingMethods::hexToStr($txt);
		$txt = addslashes($txt);
		$url = HelpingMethods::hexToStr($url);
		$result = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{				
				$storyID = HelpingDBMethods::GetStoryID($url);
				$ReplyTo = $CommentID;
				$AddressedTo = HelpingDBMethods::GetMemberIDByComment($ReplyTo);
				$NewCommentID = HelpingDBMethods::PostComments($storyID, $txt, $Comments, $MemberID, $ReplyTo);
				$data = array("AddressedTo" => $AddressedTo, "ActionBy" => $MemberID, "StoryID" => $storyID, "CommentID" => $NewCommentID);
				Notifications::InsertNotification(1, $data);
				
				$result = ConnichiwahUI::UIHoverboxComments($txt, $url, $MemberID, 'last');
			}
			mysql_close($DBConnection);
		}
		return "{'mycomments':'" . $result . "'}";
	}
	
	function LikeComment($MemberID, $CommentID)
	{
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_like (MemberID, CommentID) 
				VALUES (" . $MemberID . ", " . $CommentID . ")";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	
	function isCommentLiked($CurrentMemberID, $CommentID)
	{
		$result = false; 
		$Query = "SELECT COUNT(LikeID) as Count FROM tbl_like WHERE (MemberID  = '$CurrentMemberID') AND (CommentID = '$CommentID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			//$result = $row['StoryID'];
			$count = $row['Count'];
			if($count > 0)
				$result = true;
		}
		return $result;
	}
	
	function isMemberTrusted($CurrentMemberID, $CommentorID, $CategoryID)
	{
		$result = false; 
		$Query = "SELECT COUNT(TrustID) AS Count FROM tbl_trust WHERE (MemberID  = '$CurrentMemberID') AND (FriendsID = '$CommentorID') AND (CategoryID = '$CategoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			//$result = $row['StoryID'];
			$count = $row['Count'];
			if($count > 0)
				$result = true;
			
		}
		
		return $result;
	}
	
	function TrustMember($MemberID, $FriendID, $CategoryID)
	{
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_trust (MemberID, FriendsID, CategoryID) 
				VALUES ($MemberID, $FriendID, $CategoryID)";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	
	function isMyFriend($MemberID, $friendID)
	{
		if ($MemberID!=$friendID){
		
			$result = false; 
			$Query = "SELECT COUNT(FriendsID) AS Count FROM tbl_friends WHERE (MemberID_Active  = '$MemberID') AND (MemberID_Passive  = '$friendID')";	
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$count = $row['Count'];
				if($count > 0)
					$result = true;
			}
		} else {
			$result=true;
		}
	return $result;
	}
	
	function AddFriend($MemberID, $FriendID)
	{
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_friends (MemberID_Active, MemberID_Passive, Date_Time) 
				VALUES ('" . $MemberID . "', '" . $FriendID . "', '$DateTime')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function followhub($MemberID, $FriendID)
	{
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_friends (MemberID_Active, MemberID_Passive, Date_Time) 
				VALUES ('" . $FriendID . "', '" . $MemberID . "', '$DateTime')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	
	function insertStoryText($storyBody, $url)
	{
		$storyID = HelpingDBMethods::GetStoryID($url);
		if($storyID==0){
			$title=HelpingDBMethods::GetStoryTitle($url);
			if($title==""){
				$title=$url;
			}
			HelpingDBMethods::InsertStory($title, $url);
		    $storyID = HelpingDBMethods::GetStoryID($url);
		}
			$storyBodyesc = mysql_real_escape_string($storyBody);
			$Query = "INSERT INTO tbl_story_text (StoryID, Story_URL, Story_Body) 
					VALUES ('" . $storyID . "', '" . $url . "', '$storyBodyesc')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	function insertStoryTextExtension($storyBody, $url, $title)
	{
		$storyID = HelpingDBMethods::GetStoryID($url);
		if($storyID==0){
			HelpingDBMethods::InsertStory($title, $url);
		    $storyID = HelpingDBMethods::GetStoryID($url);
		}
			$storyBodyesc = mysql_real_escape_string($storyBody);
			$Query = "INSERT INTO tbl_story_text (StoryID, Story_URL, Story_Body) 
					VALUES ('" . $storyID . "', '" . $url . "', '$storyBodyesc')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function GetMemberImageID($MemberID)
	{
		$result = 0; 
		$Query = "SELECT ImageID FROM tbl_member WHERE (MemberID  = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['ImageID'];
		}
		return $result;
	}
	function GetBackgroundImageID($MemberID)
	{
		$result = 0; 
		$Query = "SELECT background FROM tbl_person_hub WHERE (hubMemberID  = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['background'];
		}
		return $result;
	}
	
	function GetStoryText($storyID)
	{
		$result = 0; 
		$Query = "SELECT Story_Body FROM tbl_story_text WHERE (StoryID  = '$storyID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Story_Body'];
		}
		return $result;
	}
	
	function GetNoOfFriends($MemberID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(a.FriendsID) AS Count 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive
								AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active = '$MemberID') AND (m.isHub=0)";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	function getNoRestate($MemberID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(resID) AS Count 
					FROM tbl_comment_restate
					WHERE (AuthorID = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	
	function GetnoOfBadges($MemberID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(MBID) as Count FROM tbl_member_badge WHERE (MemberID = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	
	function GetNoOfTrustsMyFriendsHaveOnMe($MemberID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(Distinct CategoryID) as Count FROM tbl_trust WHERE (FriendsID = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	function GetFriendTrust($MemberID)
	{
		$Query = "SELECT Distinct CategoryID FROM tbl_trust WHERE (FriendsID = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while ($row!=false)
		{
			$catid = $row['CategoryID'];
			$result .= ', '.HelpingDBMethods::GetCategory($catid);
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function GetNoComments($MemberID){
		$Query = "SELECT COUNT(c.CommentID) as Count
					FROM tbl_member a
					INNER JOIN tbl_comments c ON a.MemberID = c.MemberID 
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					WHERE (a.MemberID = '$MemberID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$totalResults = mysql_result($QueryResult, 0, 0);
		return $totalResults;
	}
	
	function GetBadges($MemberID, $type = "search", $limit = 4, $offset = 0)
	{
		$result = '';
		$width = 41;
		if($type == 'search')
		{
			$width = 15;
		}
		elseif($type == "brag")
		{
			$width = 10;
		}
		elseif($type == "tab")
		{
			$width = 30;
		}
		
		elseif($type == "hover")
		{
			$width = 30;
		}
		elseif($type == "profile")
		{
			$width = 100;
		}
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT tbl_badge.ImageID, tbl_badge.Badge_Name, tbl_badge.Badge_Description, tbl_badge.BadgeID, tbl_member_badge.Date_Time
					FROM tbl_badge 
						INNER JOIN tbl_member_badge ON tbl_badge.BadgeID = tbl_member_badge.BadgeID		
					WHERE (MemberID = '$MemberID') 
					ORDER BY tbl_member_badge.Date_Time DESC LIMIT $offset, $limit";
			
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$resultCount = mysql_num_rows($QueryResult);
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'badge');
			$BadgeDesc = $row['Badge_Description'];
			if($type == 'tab')
			{
				$new_badge = '';
				if(strtotime($row['Date_Time'] . '+1 day') > time())
				{
					$new_badge = '<img style = "position:absolute; top:18px; left:20px;" src = "' . $rootURL . 'images/website/new-badge-tag.png" />';					
				} 
				$BadgeName = $row['Badge_Name'];
				$result .=  '<li class = "badge-tab-item">
								<img src = "' . $imageURL . '" alt = ""  style = "width:' . $width . 'px; padding:2px; float:left;"/>
								' . $new_badge . '
								<div style = "float:left; width:90px; padding:4px 0px; height:25px;">' . $BadgeName . '</div>
								<a style = "float:right; margin-top:2px;" href = "javascript:BragMyBadgeHTML(' . $row['BadgeID'] . ')"><img src = "' . $rootURL . 'images/website/brag-small.png" alt = "" /></a>
								<div class = "cl"></div>
							</li>';
			} else
				{
					$result .= '<img alt="" src="' . $imageURL . '" style = "width:' . $width . 'px; padding:2px;" />';
				}
			$row = mysql_fetch_array($QueryResult);
		}
		if($resultCount < $limit && $type != 'tab')
		{
			for($i = $resultCount; $i < $limit; $i++)
			{
				$BadgeName = $row['Badge_Name'];
				$result .= '<img alt="" src="' . $rootURL . 'images/website/badges/blank.png" style = "width:' . $width . 'px; padding:2px;" />';
			}
		}
		elseif($type == 'tab')
		{
			$Query = "SELECT COUNT(tbl_badge.BadgeID) AS Count
						FROM tbl_badge 
							INNER JOIN tbl_member_badge ON tbl_badge.BadgeID = tbl_member_badge.BadgeID		
						WHERE (MemberID = '$MemberID')";
			
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$total_badges = 0;
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$total_badges = $row['Count'];
			}
			if($total_badges > ($offset + $limit))
			{
				$result .= '<li class = "badge-tab-item more-badges-btn" style = "border:none;">
								<img src = "' . $rootURL . 'images/website/more-badges.png" style = "width:175px;" alt = "" onclick = "GetMoreBadges(' . ($offset + $limit) . ', ' . $limit . ')"/>							
							</li>';
			}
		}
		return $result;
		
	}
	
	
	function GetBadgesProfile($CurrentUser, $MemberID, $type = "search", $limit = 4, $offset = 0)
	{
		$result = '';
		$width = 41;
		if($type == 'search')
		{
			$width = 15;
		}
		elseif($type == "brag")
		{
			$width = 10;
		}
		elseif($type == "tab")
		{
			$width = 30;
		}
		
		elseif($type == "hover")
		{
			$width = 30;
		}
		elseif($type == "profile")
		{
			$width = 100;
		}
		elseif($type == "profilebadge")
			{
				$width = 50;
			}
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT tbl_badge.ImageID, tbl_badge.Badge_Name, tbl_badge.Badge_Description, tbl_badge.BadgeID, tbl_member_badge.Date_Time
					FROM tbl_badge 
						INNER JOIN tbl_member_badge ON tbl_badge.BadgeID = tbl_member_badge.BadgeID		
					WHERE (MemberID = '$MemberID') 
					ORDER BY tbl_member_badge.Date_Time DESC";
			
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$resultCount = mysql_num_rows($QueryResult);
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$badgeID = $row['BadgeID'];
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'badge');
			$numFriends = HelpingDBMethods::countFriendsBadge($CurrentUser, $badgeID);
			if ($numFriends==1){
				$verb = 'also has';
			} else if($numFriends==0){
				$verb = 'Noone else has';
			} else{
				$verb = 'also have';
			}
			$friendsbadges = HelpingDBMethods::GetFriendsBadges($CurrentUser, $badgeID);
			$hasbadge = HelpingDBMethods::hasBadge($CurrentUser, $badgeID);
			
			$BadgeDesc = $row['Badge_Description'];
			if($type == 'profilebadge')
			{
				$new_badge = '';

				$BadgeName = $row['Badge_Name'];
				
				$result .=  '<li class = "badge-tab-item">
								<img src = "' . $imageURL . '" alt = ""  style = "width:' . $width . 'px; padding:2px; float:left;"/>
								' . $new_badge . '
								<div style = "float:left; width:90px; padding:4px 0px;">' . $BadgeName . '</div>
								<span class="badgedescrip">'.$BadgeDesc.'</span>
								<span class="brag-badge"><input type="button" value="Brag :P" onclick="BragMyBadgeHTML(' . $row['BadgeID'] . ');" class="btn-brag-prof"></span>
								<div class = "cl"></div>
								<div class="friendsbadges">'.$friendsbadges.' '.$verb.' this badge</div>
								<div class = "cl"></div>
							</li>';
			} else
				{
					$result .= '<img alt="" src="' . $imageURL . '" style = "width:' . $width . 'px; padding:2px;" />';
				}
			$row = mysql_fetch_array($QueryResult);
		}
		if($resultCount < $limit  && $type != 'profilebadge')
		{
			for($i = $resultCount; $i < $limit; $i++)
			{
				$BadgeName = $row['Badge_Name'];
				$result .= '<img alt="" src="' . $rootURL . 'images/website/blankbadge.png" style = "width:' . $width . 'px; padding:2px;" />';
			}
		}
		elseif($type == 'tab')
		{
			$Query = "SELECT COUNT(tbl_badge.BadgeID) AS Count
						FROM tbl_badge 
							INNER JOIN tbl_member_badge ON tbl_badge.BadgeID = tbl_member_badge.BadgeID		
						WHERE (MemberID = '$MemberID')";
			
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$total_badges = 0;
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$total_badges = $row['Count'];
			}
			if($total_badges > ($offset + $limit))
			{
				$result .= '<li class = "badge-tab-item more-badges-btn" style = "border:none;">
								<img src = "' . $rootURL . 'images/website/more-badges.png" style = "width:175px;" alt = "" onclick = "GetMoreBadges(' . ($offset + $limit) . ', ' . $limit . ')"/>							
							</li>';
			}
		}
		return $result;
		
	}
	
	function GetBadgesFeatured($MemberID, $type = "search", $limit = 4, $offset = 0)
	{
		$first = MemberDBMethods::GetFirstname($MemberID);
		
		$result = '';
		$width = 41;
		if($type == 'search')
		{
			$width = 15;
		}
		elseif($type == "brag")
		{
			$width = 10;
		}
		elseif($type == "tab")
		{
			$width = 30;
		}
		
		elseif($type == "hover")
		{
			$width = 30;
		}
		elseif($type == "profile")
		{
			$width = 100;
		}
		elseif($type == "profilebadge")
			{
				$width = 50;
			}
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT tbl_badge.ImageID, tbl_badge.Badge_Name, tbl_badge.Badge_Description, tbl_badge.BadgeID, tbl_member_badge.Date_Time
					FROM tbl_badge 
						INNER JOIN tbl_member_badge ON tbl_badge.BadgeID = tbl_member_badge.BadgeID		
					WHERE (MemberID = '$MemberID') 
					ORDER BY tbl_member_badge.Date_Time DESC LIMIT 0,1";
			
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$resultCount = mysql_num_rows($QueryResult);
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'badge');
			$BadgeDesc = $row['Badge_Description'];
			if($type == 'profilebadge')
			{
				$new_badge = '';
				if(strtotime($row['Date_Time'] . '+1 day') > time())
				{
					$new_badge = '<img style = "position:absolute; top:18px; left:20px;" src = "' . $rootURL . 'images/website/new-badge-tag.png" />';					
				} 
				$BadgeName = $row['Badge_Name'];
				
				$result .=  '<li class = "badge-tab-item">
								<img src = "' . $imageURL . '" alt = ""  style = "width:' . $width . 'px; padding:2px; float:left;"/>
								' . $new_badge . '
								<div style = "float:left; width:90px; padding:4px 0px;">' . $BadgeName . '</div><span class="badgedescrip">'.$BadgeDesc.'</span>
								<a style = "float:right; margin-top:2px;" href = "javascript:BragMyBadgeHTML(' . $row['BadgeID'] . ')"><img src = "' . $rootURL . 'images/website/brag-small.png" alt = "" /></a>
								<div class = "cl"></div>
							</li>';
			} else
				{
					$BadgeName = $row['Badge_Name'];
					
					$result .= '<img alt="" src="' . $imageURL . '" style = "width:' . $width . 'px; padding:2px;" /><div class="featured-title">'.$first.'\'s Newest Badge</div><span class="badge-title-badges">'.$BadgeName .'</span> <div class="badge-descrip-badges">'.$BadgeDesc.'</div>';
				}
			$row = mysql_fetch_array($QueryResult);
		}
		if($resultCount < $limit  && $type != 'profilebadge')
		{
			for($i = $resultCount; $i < $limit; $i++)
			{
				$BadgeName = $row['Badge_Name'];
				$result .= '<img alt="" src="' . $rootURL . 'images/website/blankbadge.png" style = "width:' . $width . 'px; padding:2px;" />';
			}
		}
		elseif($type == 'tab')
		{
			$Query = "SELECT COUNT(tbl_badge.BadgeID) AS Count
						FROM tbl_badge 
							INNER JOIN tbl_member_badge ON tbl_badge.BadgeID = tbl_member_badge.BadgeID		
						WHERE (MemberID = '$MemberID')";
			
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$total_badges = 0;
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$total_badges = $row['Count'];
			}
			if($total_badges > ($offset + $limit))
			{
				$result .= '<li class = "badge-tab-item more-badges-btn" style = "border:none;">
								<img src = "' . $rootURL . 'images/website/more-badges.png" style = "width:175px;" alt = "" onclick = "GetMoreBadges(' . ($offset + $limit) . ', ' . $limit . ')"/>							
							</li>';
			}
		}
		return $result;
		
	}
	
	function GetRandomFriends($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID')
					LIMIT 0, 11";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$friend = $row['MemberID'];
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'member');
			$result .= '
		  <a href="http://www.kahub.com/l/profile.php?user='.$friend.'"><img alt="" src="' . $imageURL . '" title = "' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '" width = "35px" height = "36px"/></a>
		</span>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	
	function GetFriendsProfile($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') 
					ORDER BY a.FriendsID DESC
					
					LIMIT 0, 7";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$friend = $row['MemberID'];
			
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$result .= '<li>
		  <a href="http://www.kahub.com/l/profile.php?user='.$friend.'"><img alt="" src="' . $imageURL . '" title = "' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '"  width = "90px" height = "90px" onerror="this.src=\'http://www.kahub.com/images/website/photo-1.jpg\'"/><p>'. $row['mFirst_Name'] . ' ' . $row['mLast_Name'] .'</p></a><input type="button" value="Add" onclick="AddFriendFromSearch('.$row['MemberID'].');" class="btn-add"></li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	function GetInterests($MemberID)
	{
		$hubData = HelpingDBMethods::getHubInfoFromID($MemberID);
		$hubMaster = $hubData['h-memberID'];
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$hubMaster') AND (m.isHub=1)
					ORDER BY a.FriendsID DESC
					LIMIT 0, 5";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$friend = $row['MemberID'];
			$CurrentMemberID = $GLOBALS['user']->userID;
			$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friend);
			$isHisFriend = HelpingDBMethods::isMyFriend($friend, $CurrentMemberID);
			
			if($isMyFriend&&$isHisFriend){
				$follow = '<a class="follow phubpage following">Following!</a>';
			} else{
				$follow = '<a onclick="Followhub('.$row['MemberID'].');" class="follow phubpage">Follow</a>';
			}
			$result .= '<li class="followingTopic">
		  <a href="http://www.kahub.com/l/hub?user='.$friend.'"><p>'. $row['mFirst_Name'] . ' ' . $row['mLast_Name'] .'</p></a> '.$follow.'</li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		$result .= '<li class="followingTopic">
	  <a href="http://www.kahub.com/l/following.php?user='.$hubData['h-handle'].'"><p>View All</p></a></li>';
		return $result;
	}
	function GetInterestsSide($MemberID)
	{
		$result = ''; 
		$CurrentMemberID = $GLOBALS['user']->userID;
		$hubData = HelpingDBMethods::getHubDatafromMemberID($CurrentMemberID);
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$CurrentMemberID') AND (m.isHub=1)
					ORDER BY a.FriendsID DESC
					LIMIT 0, 5";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$result .= '<li class="sidebartopics topicsTitle"><p>Topics</p></li>';
		while($row!=false)
		{
			$friend = $row['MemberID'];
			$result .= '<li class="sidebartopics">
		  <a href="http://www.kahub.com/l/hub?user='.$friend.'"><p>'. $row['mFirst_Name'] . ' ' . $row['mLast_Name'] .'</p></a></li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		$result .= '<li class="sidebartopics">
	  <a href="http://www.kahub.com/l/following?user='.$hubData['h-handle'].'"><p>View All</p></a></li>';
		return $result;
	}
	function getFeaturedHub($cat){
		$result = "";
		$Query = "SELECT * from tbl_feat_hubs WHERE (Category='$cat') ORDER BY id ASC";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while ($row!=false){
		    $hub = MemberDBMethods::isHub($row['hubID']);
		    if($hub==1){
		        $name = MemberDBMethods::GetUsername($row['hubID']);
    			$wiki = HelpingDBMethods::wikiImg($name);
    		    if($wiki!=""){
    		        $wikiImg = str_replace($wiki[1]."px", "70px", $wiki[0]);
    		    } else {
    		        $wikiImg = "";
    		    }

    			if($wikiImg!=""){
    			    $image = '<div class="featImg"><img src='.$wikiImg.' alt="'.$name.'"></div><div class="namewphoto feat">'.$name."</div>";
    			}  else {
    			    $image = '<div class="nameFeat feat"><span class="featspacer">&mdash;</span>'. $name .'<span class="featspacer">&mdash;</span></div>';
    			}
    			$result .="<li class='hubli-".$cat."'><div class='featHubAbout'>".$image."</div><br /> <span id='follow-".$row['hubID']."'><a onclick='FollowhubGetStarted(".$row['hubID'].");' class='follow phubpage getstarted' id='feathub-".$row['hubID']."'>Follow</a></span></li>";
    			$row = mysql_fetch_array($QueryResult);
		    } else {
		        $hubInfo = HelpingDBMethods::getHubInfoFromMemberID($row['hubID']);
		        $name = MemberDBMethods::GetUsername($hubInfo['h-memberID']);
    			$imageID = HelpingDBMethods::GetMemberImageID($hubInfo['h-memberID']);
    			$imageURL = HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail');
    			$image = '<div class="featImg"><img src='.$imageURL.' alt="'.$name.'"></div><div class="namewphoto feat">'.$name."<div class='handlegetStarted'>".$hubInfo['h-headline']."</div></div>";
			    $result .="<li class='hubli-".$cat."'><div class='featHubAbout'>".$image."</div><br /> <span id='follow-".$row['hubID']."'><a onclick='FollowhubGetStarted(".$row['hubID'].");' class='follow phubpage getstarted'>Follow</a></span></li>";
			    $row = mysql_fetch_array($QueryResult);
		    }
		}
		return $result;
	}

	function showFeatHubs(){
		$result = "";
		$Query = "SELECT * from tbl_feat_cat ORDER BY CatID DESC";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while ($row!=false){
			$hubs = HelpingDBMethods::getFeaturedHub($row['CatID']);
			$result .= "<div class='featHubsWrapper feat-".$row['CatID']."'><i id='catNameFeat'>".$row['CatName']."</i>".$hubs."</div>";
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	function GetInterestsAll($MemberID)
	{
		$hubData = HelpingDBMethods::getHubInfoFromID($MemberID);
		$hubMaster = $hubData['h-memberID'];
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$hubMaster') AND (m.isHub=1)
					ORDER BY a.FriendsID DESC
					";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$friend = $row['MemberID'];
			$CurrentMemberID = $GLOBALS['user']->userID;
			$isMyFriend = HelpingDBMethods::isMyFriend($CurrentMemberID, $friend);
			$isHisFriend = HelpingDBMethods::isMyFriend($friend, $CurrentMemberID);
			
			if($isMyFriend&&$isHisFriend){
				$follow = '<a class="follow phubpage following">Following!</a>';
			} else{
				$follow = '<a onclick="Followhub('.$row['MemberID'].');" class="follow phubpage">Follow</a>';
			}
			$result .= '<li class="followingTopicphub">
		  <a href="http://www.kahub.com/l/hub?user='.$friend.'"><p>'. $row['mFirst_Name'] . ' ' . $row['mLast_Name'] .'</p></a> '.$follow.'</li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	function GetFollowersNoName($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') 
					ORDER BY a.FriendsID DESC
					
					LIMIT 0, 10";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$friend = $row['MemberID'];
			$hubData = HelpingDBMethods::getHubDatafromMemberID($row['MemberID']);
			$MemberID = $GLOBALS['user']->userID;
			$following = HelpingDBMethods::isMyFriend($MemberID,$hubData['h-hubID']);
			$pal = HelpingDBMethods::isMyFriend($MemberID,$hubData['h-memberID']);
			if(!$following&&!$pal&&$hubData['h-handle']!=""){
				$follow = '<a onclick="Followhub('.$hubData['h-hubID'].');">Follow</a>';
			} else if($hubData['h-handle']!="") {
				$follow = '';
			}
			
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$result .= '<li class="follower">
		  <a href="http://www.kahub.com/'.$hubData['h-handle'].'"><img alt="" src="' . $imageURL . '" title = "' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '"  width = "50px" height = "50px" onerror="this.src=\'http://www.kahub.com/images/website/photo-1.jpg\'"/></a><div></div>'.$follow.'</li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	function GetFriendsNoName($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') AND (m.isHub=0) 
					ORDER BY a.FriendsID DESC
					
					LIMIT 0, 10";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$hubData = HelpingDBMethods::getHubDatafromMemberID($row['MemberID']);
			$MemberID = $GLOBALS['user']->userID;
			$following = HelpingDBMethods::isMyFriend($MemberID,$hubData['h-hubID']);
			$pal = HelpingDBMethods::isMyFriend($MemberID,$hubData['h-memberID']);
			if(!$following&&!$pal&&$hubData['h-handle']!=""&&$hubData['h-handle']!="p"){
				$follow = '<a onclick="Followhub('.$hubData['h-hubID'].');">Follow</a>';
			} else if($hubData['h-handle']!=""&&$hubData['h-handle']!="p") {
				$follow = '';
			}
			
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$result .= '<li class="follower">
		  <a href="http://www.kahub.com/'.$hubData['h-handle'].'"><img alt="" src="' . $imageURL . '" title = "' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '"  width = "50px" height = "50px" onerror="this.src=\'http://www.kahub.com/images/website/photo-1.jpg\'"/></a><div></div>'.$follow.'</li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	function GetFriendsNoNameAll($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') AND (m.isHub=0) 
					ORDER BY a.FriendsID DESC
					
					";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$hubData = HelpingDBMethods::getHubDatafromMemberID($row['MemberID']);
			$MemberID = $GLOBALS['user']->userID;
			$following = HelpingDBMethods::isMyFriend($MemberID,$hubData['h-hubID']);
			$pal = HelpingDBMethods::isMyFriend($MemberID,$hubData['h-memberID']);
			if(!$following&&!$pal){
				$follow = '<a class="friendsPage btn-add-prof" onclick="AddFriendFromSearch('.$row['MemberID'].');">Add Friend</a>';
			} else {
				$follow = '';
			}
			
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$result .= '<li class="friendList">
		  <a href="http://www.kahub.com/'.$hubData['h-handle'].'"><img alt="" src="' . $imageURL . '" title = "' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '"  width = "50px" height = "50px" onerror="this.src=\'http://www.kahub.com/images/website/photo-1.jpg\'"/></a><div class="friendName"><a href="http://www.kahub.com/'.$hubData['h-handle'].'">' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '</div>'.$follow.'</li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	function hasBadge($MemberID, $BadgeID){
		
		$result = "false"; 
		$Query = "SELECT COUNT(MBID) AS Count FROM tbl_member_badge WHERE MemberID  = '$MemberID' AND BadgeID='$BadgeID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false){
			$count = $row['Count'];
			if($count > 0)
				$result = "true";
			}
		return $result;
	} 
	
	function getHubDatafromMemberID($MemberID){
		$result = array();
		$Query = "SELECT * FROM tbl_person_hub WHERE MemberID = '$MemberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['h-memberID'] = $row['MemberID'];
			$result['h-hubID'] = $row['hubMemberID'];
			$result['h-handle'] = $row['handle'];
			$result['h-background'] = $row['background'];
			$result['h-headline'] = $row['headline'];
			$result['h-twitter'] = $row['twitter'];
			$result['h-facebook'] = $row['facebook'];
			$result['h-gplus'] = $row['gplus'];
			$result['h-personal'] = $row['personal'];
		}
		else
		{
			$result="pass";
		}
		return $result;
	}
	
	function storytextInDB($StoryID){
		
		$result = "false"; 
		$Query = "SELECT COUNT(StoryID) AS Count FROM tbl_story_text WHERE StoryID  = '$StoryID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false){
			$count = $row['Count'];
			if($count > 0)
				$result = "true";
			}
		return $result;
	}
	
	function countFriendsBadge($MemberID, $Badge){
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') 
					ORDER BY a.FriendsID DESC";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$hasbadge=="false";
		$i = 0;
		while($row!=false)
		{
			$friend = $row['MemberID'];
			$hasbadge = HelpingDBMethods::hasBadge($friend, $Badge);
			
			if($hasbadge=="true"){
				$i++;
			}
			
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $i;
	}
	
	
	function GetFriendsBadges($MemberID, $Badge)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') 
					ORDER BY a.FriendsID DESC";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$num = HelpingDBMethods::countFriendsBadge($MemberID, $Badge);
		$hasbadge=="false";
		if ($num =="1"){
			$comma = ' ';
		} else {
			$comma = ', ';
		}
		
		$i = 0;
		while($row!=false)
		{
			$friend = $row['MemberID'];
			$hasbadge = HelpingDBMethods::hasBadge($friend, $Badge);
			if($hasbadge=="true"){
				$result .= '<a href="http://www.kahub.com/l/profile.php?user='.$friend.'">'.$row['mFirst_Name'].' '.$row['mLast_Name'].'</a>'.$comma;
			}
			
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	function GetFriendsProfilePage($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') 
					ORDER BY a.FriendsID DESC";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$ImageID = $row['ImageID'];
			$friend = $row['MemberID'];
			$badges = HelpingDBMethods::GetBadges($friend, "search", 8, 0);
			
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$result .= '<li>
		  <a href="http://www.kahub.com/l/profile.php?user='.$friend.'"><img alt="" src="' . $imageURL . '" title = "' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '"  width = "90px" height = "90px" onerror="this.src=\'http://www.kahub.com/images/website/photo-1.jpg\'"/><p>'. $row['mFirst_Name'] . ' ' . $row['mLast_Name'] .'</p></a><input type="button" value="Add" onclick="AddFriendFromSearch('.$row['MemberID'].');" class="btn-add"><span class="sources-badges"><a href="http://www.kahub.com/l/getBadges.php?user='.$friend.'">'.$badges.'</a></span></li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	
	function GetFriendsProfileLatest($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') 
					ORDER BY a.FriendsID DESC LIMIT 0,1";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$first = MemberDBMethods::GetFirstname($MemberID);
			
			$ImageID = $row['ImageID'];
			$friend = $row['MemberID'];
			$firstFriend = MemberDBMethods::GetFirstname($friend);
			
			$badges = HelpingDBMethods::GetBadges($friend, "search", 4, 0);
			
			$imageURL = HelpingDBMethods::GetImageData($ImageID, 'member', 'thumbnail');
			$result .= '<a href="http://www.kahub.com/l/profile.php?user='.$friend.'"><img alt="" src="' . $imageURL . '" title = "' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '"  width = "90px" height = "90px" onerror="this.src=\'http://www.kahub.com/images/website/photo-1.jpg\'"/><p></a><div class="feat-title">'.$first.'\'s Newest Source</div><a href="http://www.kahub.com/l/profile.php?user='.$friend.'"><div class="source-name">'. $row['mFirst_Name'] . ' ' . $row['mLast_Name'] .'</div></p></a><input type="button" value="Add '.$firstFriend.' as a source" onclick="AddFriendFromSearch('.$row['MemberID'].');" class="btn-add" id="feat"><span class="sources-badges-feat"><a href="http://www.kahub.com/l/getBadges.php?user='.$friend.'">'.$badges.'</a></span></li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	
	function totalResults($userID){
	    $Query = "SELECT COUNT(DISTINCT s.StoryID) AS Count
					FROM tbl_friends a
					INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
					INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					WHERE (a.MemberID_Active = '$userID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$totlalResults = mysql_result($QueryResult, 0, 0);
		return $totlalResults;
	}
	
	function GetLatestStories($offset, $limit, $userID, $getTotlaResults = false, &$totlalResults = null)
	{
		$rootURL = Settings::GetRootURL();
		if($getTotlaResults)
		{
			$Query = "SELECT COUNT(DISTINCT s.StoryID) AS Count
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID
						WHERE (a.MemberID_Active = '$userID')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$totlalResults = mysql_result($QueryResult, 0, 0);
		}
		$result = "";
		$Query = "SELECT DISTINCT s.StoryID, s.Story_Title, s.Story_URL, s.views, s.DateTime, s.ImageID, c.MemberID, c.Comment_Text, c.CommentID, c.Reply_To, c.Date_Time
					FROM tbl_friends a
					INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
					INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					WHERE (a.MemberID_Active = '$userID')
					ORDER BY c.Date_Time DESC LIMIT $offset, $limit";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row != false)
		{
			$storyRank = StoryRanking::GetStoryCommulativeRank($row['StoryID'], $userID);
			$rankClass = 'rank-1';
			if($storyRank < 8)
			{
				$rankClass = 'rank-1';
			}
			elseif($storyRank <= 22)
			{
				$rankClass = 'rank-2';
			}
			elseif($storyRank <= 37)
			{
				$rankClass = 'rank-3';
			}
			elseif($storyRank <= 52)
			{
				$rankClass = 'rank-4';				
			} 
			elseif($storyRank <= 67)
			{
				$rankClass = 'rank-5';
			}
			elseif($storyRank <= 82)
			{
				$rankClass = 'rank-6';
			}
			elseif($storyRank <= 97)
			{
				$rankClass = 'rank-7';
			}
			else
			{
				$rankClass = 'rank-7';
			}
			$hub = MemberDBMethods::isHub($row['MemberID']);
			$imageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
			$name = MemberDBMethods::GetUserName($row['MemberID']);
			$mid = $row['MemberID'];
			$storyID = $row['StoryID'];
			$date = $row['Date_Time'];
			$replyID = $row['Reply_To'];
			$replyMemberID = HelpingDBMethods::GetMemberIDByComment($replyID);
			
			$isLiked = HelpingDBMethods::GetIsStoryLiked($row['StoryID'], $userID);
			$isRestated = HelpingDBMethods::GetRestated($row['CommentID'], $userID);
			$thumbString = '<img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />';
			$comment = $row['Comment_Text'];
			$urlhex = HelpingMethods::strToHex($row['Story_URL']);
			if($comment=="Interesting"){
				$comType=2;
			} else if($comment=="Bump") {
				$comType=3;
			} else if($comment=="Promote") {
				$comType=4;
			} else {
				$comType=1;
			}
			$isBanned = HelpingDBMethods::isBanned($row['MemberID']);
			$isSpam = HelpingDBMethods::isSpam($row['CommentID']);
			
			if($isBanned==2&&$userID!=$row['MemberID']){
				$isBanned = "shadow";
			}
			if($isSpam=="spam"&&$userID!=$row['MemberID']){
				$isBanned = "shadow";
			}
			$isPromoted=HelpingDBMethods::GetPromoted($row['StoryID'], $userID);
			$promoCount = HelpingDBMethods::GetPromoteCount($row['StoryID']);
			if($row['Story_Title']==""){
				$row['Story_Title']=$row['Story_URL'];
			}
			
	
			$replyCount = HelpingDBMethods::GetReplyCount($row['CommentID']);
			
			if(!$isLiked)
			{
							$imgString = '<a href="http://www.kahub.com/l/profile.php?user='.$mid.'"><img class = "story-image" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/></a>';
				$thumbString = '<a id = "Like-Story-Link-' . $row['StoryID'] . '" href = "javascript:LikeStory(' . $row['StoryID'] . ')"><img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-11.jpg" alt = "" /></a>';
				$interesting = '<span class="Interesting" onclick="LikeStory('.$storyID.',\''.$urlhex.'\')" id="story-'.$storyID.'">+Fav Stream</span>';
				$later="noLater";
				
			} else {
							$imgString = '<a href="http://www.kahub.com/l/profile.php?user='.$mid.'"><img class = "story-image" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\'"/></a>';
				$interesting = '<span class="Interesting" id="done">Added!</span>';
				$later ="Later";
			}
			
			if($hub==1){
					$wikiDef = HelpingDBMethods::wikidefinition($name);
					$imgString = '<a href="http://www.kahub.com/l/profile.php?user='.$mid.'"><img class = "story-image" src = "' . $wikiDef[0] . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/></a>';
			}
			$restateCount = HelpingDBMethods::GetRestateCount($replyID);
	
			if(!$isRestated){
				$restate = '&#183; <span class="restateLoad" onClick="restateShow('.$storyID.')"><a onClick="RestateComment('.$storyID.',\''.$urlhex.'\','.$row['CommentID'].','.$mid.')" id="restate-Story-Link-'.$storyID.'">Restate</a> <span class="resCount">('.$restateCount.')</span></span>';
			} else{
				$restate = '&#183; <span class="restated">Restated! <span class="resCount">('.$restateCount.')</span></span>';
			}
			
			if($mid==$userID){
				$restate="&#183 <span class='myrestate'> Restated by <span class='resCount'>$restateCount</span></span>";
			}
			
			if(!$isPromoted){
				$promote = "<span class='promoteLoad' onClick='promoteShow(".$storyID.")'><a onClick='PromoteStory(".$storyID.", \"".$urlhex."\")' class='promolink' id='promote-story-link-".$storyID."'>Promote</a></span> (<span class='promo-num' id='promo-num-".$storyID."'>".$promoCount."</span>)";
			} else {
				$promote = '<span class="promoted">Promoted!</span> (<span class="promo-num">'.$promoCount.'</span>)';
			}
			
			if($replyCount==0&&$hub==2){
					$replyText ='<a onClick="$myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-text-area-'.$row['CommentID'].'\').focus();" class="doComment">Comment</a>';
					$reply="";
			} elseif($replyCount<4&&$hub==2){
					$reply=HelpingDBMethods::GetReplies($row['CommentID']);
					$replyText="";
			} elseif($hub==2) {
					$reply="<a href='http://www.kahub.com/l/comments?c=".$row['CommentID']."'><li>View ".$replyCount." replies</li></a>";
					$replyText="";
			} else{
					$replyText ='<a onClick="$myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-text-area-'.$row['CommentID'].'\').focus();" class="doComment">Comment</a>';
			}

			$commentsBox = '<div class="commentsBox" id="comments-box-'.$row['CommentID'].'"><textarea id="comments-text-area-'.$row['CommentID'].'"></textarea><span class="CommentShow" onClick="commentShow('.$row['CommentID'].')"><a onClick="inlineReply('.$storyID.',\''.$urlhex.'\','.$row['CommentID'].')" id="replytext">Reply</a></span></div>';
			$commentText ='<a onClick="$myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-text-area-'.$row['CommentID'].'\').focus();" class="doComment">Comment</a>';
			$hubComments = '<div class="commentsBox" id="comments-box-'.$row['CommentID'].'"><textarea id="comments-text-area-'.$row['CommentID'].'"></textarea><span class="CommentShow" onClick="commentShow('.$row['CommentID'].')"><a onClick="PostStory('.$storyID.',\''.$urlhex.'\', '.$row['CommentID'].')" id="replytext">Comment</a></span></div>';
			
			
			

			
			if($replyID!=0 && $hub==0 && $comType==1 &&$isBanned!="shadow"){
				$ReplyimageID = HelpingDBMethods::GetMemberImageID($replyMemberID);
				$replyname = MemberDBMethods::GetUserName($replyMemberID);
				$replyCommentText = HelpingDBMethods::GetCommentText($replyID);
				
				
				$result .= '<li class = "' . $rankClass . ' '.$later.'" onclick=getStoryInfo('.$storyID.')>'.$imgString . '<a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><h2 style = "padding-top:8px;" class = "heavy titles">' . HelpingMethods::GetLimitedText($row['Story_Title'], 70) . '</h2></a><div class="attrib"><span class="uname" ><a href="http://www.kahub.com/l/profile.php?user='.$mid.'">'.$name.'</a></span><span class="commentstart"> said <span class="comment">'.HelpingMethods::GetLimitedText($comment, 250).'</span></span></div><div class="reply"><span class="replyuname"><a href="http://www.kahub.com/l/profile.php?user='.$replyMemberID.'"><img src=' . HelpingDBMethods::GetImageData($ReplyimageID, 'member', 'thumbnail') . '>'.$replyname.'</a></span>: <span class="replycomment">"'.HelpingMethods::GetLimitedText($replyCommentText, 100).'"</span></div><div class="others"><span class="comment">'.$replyText.'</span> &#183; <span class="promote">'.$promote.'</span> &#183; <span class="restate">'.$restate.'</span> &#183; <span class=\'read\' onClick="readLater('.$storyID.')"> '.$interesting.'</span><span class="date"><a href="http://www.kahub.com/l/comments.php?c='.$row['CommentID'].'">'.HelpingDBMethods::time2str($date).'</a></span></div>'.$commentsBox.'</li><div class="clear"></div>
				';
			} else if($hub==0 && $comType==1 &&$isBanned!="shadow"){
				$result .= '<li class = "' . $rankClass . ' '.$later.'" onclick=getStoryInfo('.$storyID.')>'.$imgString . '<a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><h2 style = "padding-top:8px;" class = "heavy titles">' . HelpingMethods::GetLimitedText($row['Story_Title'], 70) . '</h2></a><div class="attrib"><span class="uname" ><a href="http://www.kahub.com/l/profile.php?user='.$mid.'">'.$name.'</a></span><span class="commentstart"> said <span class="comment">'.HelpingMethods::GetLimitedText($comment, 250).'</span></span></div><div class="others"><span class="comment">'.$replyText.'</span> &#183;<span class="promote">'.$promote.'</span> <span class="restate">'.$restate.'</span> &#183; <span class="read" onClick="readLater('.$storyID.')"> '.$interesting.'</span><span class="date"><a href="http://www.kahub.com/l/comments.php?c='.$row['CommentID'].'">'.HelpingDBMethods::time2str($date).'</a></span></div>'.$commentsBox.'</li><div class="clear"></div>
			';
			} else if($comType==3&&$isBanned!="shadow"){
				$ReplyimageID = HelpingDBMethods::GetMemberImageID($replyMemberID);
				$replyname = MemberDBMethods::GetUserName($replyMemberID);
				$replyCommentText = HelpingDBMethods::GetCommentText($replyID);
				if(!$isRestated){
    				$restate = '&#183; <span class="restateLoad" onClick="restateShow('.$storyID.')"><a onClick="RestateComment('.$storyID.',\''.$urlhex.'\','.$replyID.','.$replyMemberID.')" id="restate-Story-Link-'.$storyID.'">Restate</a> <span class="resCount">('.$restateCount.')</span></span>';
    			} else{
    				$restate = '&#183; <span class="restated">Restated! <span class="resCount">('.$restateCount.')</span></span>';
    			}
    			$restateBox = '<div class="commentsBox restateBox" id="comments-box-'.$replyID.'"><textarea id="comments-text-area-'.$replyID.'"></textarea><span class="CommentShow" onClick="commentShow('.$replyID.')"><a onClick="inlineReply('.$storyID.',\''.$urlhex.'\','.$replyID.')" class="restateReply" id="replytext">Reply</a></span></div>';
    			$restateCommentCTA ='<a onClick="$myjquery(\'#comments-box-'.$replyID.'\').show(); $myjquery(\'#comments-box-'.$replyID.'\').show(); $myjquery(\'#comments-text-area-'.$replyID.'\').focus();" class="doComment">Comment</a>';
				
				$result .= '<li class = "' . $rankClass . ' rs '.$later.'" onclick=getStoryInfo('.$storyID.')>'.$imgString . '<a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><h2 style = "padding-top:8px;" class = "heavy titles">' . HelpingMethods::GetLimitedText($row['Story_Title'], 70) . '</h2></a><div class="restateExplain"><a href="http://www.kahub.com/l/profile.php?user='.$mid.'">'.$name.'</a> restated <a href="http://www.kahub.com/l/profile.php?user='.$replyMemberID.'">'.$replyname.'\'s</a> comment:</div><div class="restatesmt"><span class="restateuname"><i class="rswrap"><a href="http://www.kahub.com/l/profile.php?user='.$replyMemberID.'"><img src=' . HelpingDBMethods::GetImageData($ReplyimageID, 'member', 'thumbnail') . '></i></a></span><span class="restatecomment">"'.HelpingMethods::GetLimitedText($replyCommentText, 400).'"</span></div><div class="rsclr"></div><div class="others"><span class="comment">'.$restateCommentCTA.'</span> &#183;<span class="promote">'.$promote.'</span> <span class="restate">'.$restate.'</span> &#183; <span class=\'read\' onClick="readLater('.$storyID.')"> '.$interesting.'</span><span class="date"><a href="http://www.kahub.com/l/comments.php?c='.$replyID.'">'.HelpingDBMethods::time2str($date).'</a></span></div>'.$restateBox.'</li><div class="clear"></div>
				';
			} else if($comType==2 &&$isBanned!="shadow"){
							$result .= '<li class = "inter 0 '.$later.'" onclick=getStoryInfo('.$storyID.')><div class="smstorytxt"><div class="NoSummaryText"><a href="http://www.kahub.com/l/profile.php?user='.$mid.'">'.$name.'</a> added <a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')">' . HelpingMethods::GetLimitedText($row['Story_Title'], 30) . '</a> to their favs stream.</div><div class="else"><span class="read small" onClick="readLater('.$storyID.')"> '.$interesting.'</span></div></div></li><div class="clear"></div>
				';
			} else if($comType==4&&$mid!=$userID&&$isBanned!="shadow"){
						$result .= '<li class = "promo 0 '.$later.'" onclick=getStoryInfo('.$storyID.')><div class="smstorytxt"><div class="NoSummaryText"><a href="http://www.kahub.com/l/profile.php?user='.$mid.'">'.$name.'</a> promoted <a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')">' . HelpingMethods::GetLimitedText($row['Story_Title'], 30) . '</a></div><div class="else"><span class="promote promostory">'.$promote.'</span></div></div></li><div class="clear"></div>
					';
			}else if($hub==2&&$mid!=$userID&&$isBanned!="shadow"){
					$hubInfo=HelpingDBMethods::getHubInfoFromID($mid);
					$storyText = HelpingMethods::GetLimitedText(HelpingDBMethods::GetStoryText($storyID), 150);
					$hubName = MemberDBMethods::GetUserName($hubInfo['h-memberID']);
					$noOfFriends = HelpingDBMethods::GetNoOfFriends($hubInfo['h-hubID']);
					if($noOfFriends==0){
						$noOfFriends="";
					} else {
						$noOfFriends="&#183; ".$noOfFriends." Followers";
					}
					
					
					if($replyCount<4&&$replyCount!=0){
						$addComment = '<li class="textarearereply phub" id="textareareply"><textarea id="tempphub" onClick="$myjquery(\'#textareareply\').hide(); $myjquery(\'#textareareplybox\').show(); $myjquery(\'#comments-box-'.$row['CommentID'].'\').show(); $myjquery(\'#comments-text-area-'.$row['CommentID'].'\').focus();">What do you think?</textarea></li>';
						$hubComments = '<li class="textarearereplybox phub" id="textareareplybox"><span class="commentsBox phub" id="comments-box-'.$row['CommentID'].'"><textarea id="comments-text-area-'.$row['CommentID'].'" class="replyininephub"></textarea><span class="CommentShow" onClick="commentShow('.$row['CommentID'].')"><a onClick="inlineReply('.$storyID.',\''.$urlhex.'\', '.$row['CommentID'].')" id="replytext" class="replyphub">Comment</a></span></span></li>';
					} else {
						$addComment = '';
						$hubComments = '';
					}

					$result .= '<li class = "' . $rankClass . ' '.$later.'" onclick=getStoryInfo('.$storyID.')>'.$imgString . '<div class="storyText phub"><a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><div class="storyTextTitle">'.HelpingMethods::GetLimitedText($row['Story_Title'], 70) .'</div>'.$storyText.'</a></div></a><div class="attrib phub"><div class="uname phub" ><a href="http://www.kahub.com/'.$hubInfo['h-handle'].'">'.$hubName.'</a><span class="handle phub"> (/'.$hubInfo['h-handle'].') </span> <span class="headlinephub">'.$hubInfo['h-headline'].'</span> &#183; <span class="noFollowers phub">'.$noOfFriends.'</span></div><span class="commentstart"><span class="comment">'.HelpingMethods::GetLimitedText($comment, 250).'</span></span></div><div class="others"><span class="comment">'.$replyText.'</span> &#183;<span class="promote">'.$promote.'</span> <span class="restate">'.$restate.'</span> &#183; <span class="read" onClick="readLater('.$storyID.')"> '.$interesting.'</span><span class="date"><a href="http://www.kahub.com/l/comments.php?c='.$row['CommentID'].'">'.HelpingDBMethods::time2str($date).'</a></span></div>'.$reply.$addComment.$hubComments.$commentsBox.'</li><div class="clear"></div>
							';
			}else if($mid!=$userID&&$isBanned!="shadow"){
				$storyText = HelpingMethods::GetLimitedText(HelpingDBMethods::GetStoryText($storyID), 200);
				if($storyText=="Looks like we couldn't find the content. :("){
					$result .= '<li class = "' . $rankClass . ' hubno '.$later.'" onclick=getStoryInfo('.$storyID.')><div class="noSummaryText"><a href="http://www.kahub.com/l/profile.php?user='.$mid.'">'.$name.'</a>  shared <a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')">' . HelpingMethods::GetLimitedText($row['Story_Title'], 30) . '</a></div><span class="others"><span class="comment">'.$commentText.'</span> &#183; <span class="promote">'.$promote.'</span> </span>'.$hubComments.'</li><div class="clear"></div></li>
					';
				} else {
								$result .= '<li class = "' . $rankClass . ' '.$later.'" onclick=getStoryInfo('.$storyID.')>'. $imgString . '<div class="storyText"><a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><div class="storyTextTitle">'.HelpingMethods::GetLimitedText($row['Story_Title'], 70) .'</div>'.$storyText.'</a></div><div class="others"><span class="comment">'.$commentText.'</span> &#183; <span class="promote">'.$promote.'</span> &#183; <span class="read" onClick="readLater('.$storyID.')"> '.$interesting.'</span><span class="date"><a href="http://www.kahub.com/l/comments.php?c='.$row['CommentID'].'">'.HelpingDBMethods::time2str($date).'</a></span></div>'.$hubComments.'</li><div class="clear"></div>
					';
				}
	

			}
			

			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	function GetLatestStoriesInteresting($offset, $limit, $userID, $getTotlaResults = false, &$totlalResults = null)
	{
		$rootURL = Settings::GetRootURL();
		if($getTotlaResults)
		{
			$Query = "SELECT COUNT(DISTINCT s.StoryID) AS Count
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID
						WHERE (a.MemberID_Active = '$userID')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$totlalResults = mysql_result($QueryResult, 0, 0);
		}
		$result = "";
		$Query = "SELECT DISTINCT s.StoryID, s.Story_Title, s.Story_URL, s.views, s.DateTime, s.ImageID, c.MemberID, c.Comment_Text, c.CommentID, c.Date_Time
					FROM tbl_friends a
					INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
					INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					WHERE (a.MemberID_Active = '$userID')
					ORDER BY s.DateTime DESC LIMIT $offset, $limit";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while( $row != false)
		{
			$storyRank = StoryRanking::GetStoryCommulativeRank($row['StoryID'], $userID);
			$rankClass = 'rank-1';
			if($storyRank < 8)
			{
				$rankClass = 'rank-1';
			}
			elseif($storyRank <= 22)
			{
				$rankClass = 'rank-2';
			}
			elseif($storyRank <= 37)
			{
				$rankClass = 'rank-3';
			}
			elseif($storyRank <= 52)
			{
				$rankClass = 'rank-4';				
			} 
			elseif($storyRank <= 67)
			{
				$rankClass = 'rank-5';
			}
			elseif($storyRank <= 82)
			{
				$rankClass = 'rank-6';
			}
			elseif($storyRank <= 97)
			{
				$rankClass = 'rank-7';
			}
			else
			{
				$rankClass = 'rank-7';
			}
			$imageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
			$name = MemberDBMethods::GetUserName($row['MemberID']);
			$mid = $row['MemberID'];
			$storyID = $row['StoryID'];
			$date = $row['Date_Time'];
			
			$isLiked = HelpingDBMethods::GetIsStoryLiked($row['StoryID'], $userID);
			$thumbString = '<img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />';
			$comment = $row['Comment_Text'];
			
			if($isLiked)
			{
				$thumbString = '<a id = "Like-Story-Link-' . $row['StoryID'] . '" href = "javascript:LikeStory(' . $row['StoryID'] . ')"><img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-11.jpg" alt = "" /></a>';
				$interesting = '<span class="Interesting" id="done">Added to Read Later!</span>';
				$imgString = '<img class = "story-image" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '" alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\'"/>';
				$result .= '<li class = "' . $rankClass . '" onclick=getStoryInfo('.$storyID.')>'. $imgString . '<a href = "http://www.kahub.com/anyShare/index.php?ref=latest_list&rand=0&rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><h2 style = "padding-top:8px;" class = "heavy">' . HelpingMethods::GetLimitedText($row['Story_Title'], 50) . '</h2></a><div class="attrib"><span class="uname"><a href="http://www.kahub.com/l/profile.php?user='.$mid.'">'.$name.' </a></span><span class="commentstart">said <span class="comment">'.HelpingMethods::GetLimitedText($comment, 100).'</span></span></div><div class="others"> '.$interesting.'<span class="date">'.HelpingDBMethods::time2str($date).'</span></div></li>';
				
			}  

			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function GetLatestStoriesProfile($offset, $limit, $userID, $getTotlaResults = false, &$totlalResults = null)
	{
		$rootURL = Settings::GetRootURL();
		if($getTotlaResults)
		{
			$Query = "SELECT COUNT(DISTINCT s.StoryID) AS Count
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID
						WHERE (a.MemberID_Active = '$userID')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$totlalResults = mysql_result($QueryResult, 0, 0);
		}
		$result = "";
		$Query = "SELECT DISTINCT s.StoryID, s.Story_Title, s.Story_URL, s.views, s.DateTime, s.ImageID, c.MemberID, c.Comment_Text, c.CommentID, c.Date_Time
					FROM tbl_friends a
					INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
					INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					WHERE (a.MemberID_Active = '$userID')
					ORDER BY s.DateTime DESC LIMIT $offset, $limit";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row != false)
		{
			$comment = $row['Comment_Text'];
			if ($comment!="Interesting"){
			$imageID = HelpingDBMethods::GetMemberImageID($row['MemberID']);
			$name = MemberDBMethods::GetUserName($row['MemberID']);
			$mid = $row['MemberID'];
			$storyID = $row['StoryID'];
			$isHub = MemberDBMethods::isHub($mid);
			
			$isLiked = HelpingDBMethods::GetIsStoryLiked($row['StoryID'], $userID);
			$thumbString = '<img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />';
			if(!$isLiked)
			{
				$thumbString = '<a id = "Like-Story-Link-' . $row['StoryID'] . '" href = "javascript:LikeStory(' . $row['StoryID'] . ')"><img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-11.jpg" alt = "" /></a>';
			}
			$imgString = '<img class = "story-image" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '" alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\'" style="width:55px; height: 55px"/>';
			if($isHub!=1){
				$result .= '<ul class="profile-stories"><li><a href="http://www.kahub.com/l/profile.php?user='.$row['MemberID'].'">'. $imgString . '<h7>'.$name.'</a>: "'.$row['Comment_Text'].'"</h7><a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><p style = "padding-top:8px;" class = "heavy">' . HelpingMethods::GetLimitedText($row['Story_Title'], 70) . '</h2></a></li></ul>';
			} else{
				$result .= '<ul class="profile-stories"><li><a href="http://www.kahub.com/l/profile.php?user='.$row['MemberID'].'">'. $imgString . '<h7>'.$name.' Hub</a></h7><a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><p style = "padding-top:8px;" class = "heavy">' . HelpingMethods::GetLimitedText($row['Story_Title'], 70) . '</h2></a></li></ul>';
			}
		}
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function LatestStoriesPersonArray($userID){
		$stories = array();
		$Query = "SELECT DISTINCT Story_URL FROM tbl_story WHERE (Story_Title LIKE '%$userID%')
					ORDER BY DateTime DESC LIMIT 0, 50";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$MemberID = $GLOBALS['user']->userID;
		while($row != false)
		{
			$stories[]=$row['Story_URL'];
			$row = mysql_fetch_array($QueryResult);
		}
		return $stories;
	}
	function LatestStoriesHubArray($userID){
		$stories = array();
		$pinned = HelpingDBMethods::hasPinnedComment($userID);
		if($pinned!=""){
			$pinStatement= 0;
		} else {
			$pinStatement=1;
		}
		$Query = "SELECT DISTINCT s.StoryID, s.Story_Title, s.Story_URL, s.views, s.DateTime, s.ImageID, c.MemberID, c.Comment_Text, c.CommentID, c.Date_Time
					FROM tbl_comments c
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					WHERE (c.MemberID = '$userID') AND (c.Comment_Text!='Promote')
					ORDER BY s.DateTime DESC LIMIT $pinStatement, 50";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$MemberID = $GLOBALS['user']->userID;
		while($row != false)
		{
			$stories[$row['StoryID']]=$row['CommentID'];
			$row = mysql_fetch_array($QueryResult);
		}
		return $stories;
	}
	function LatestStoryPersonHub($userID, $handle){
		$pinned = HelpingDBMethods::hasPinnedComment($userID);
		if($pinned!=""){
			$pinStatement= "(c.CommentID = ".$pinned.")";
		} else {
			$pinStatement="(Reply_To=0)";
		}
		$Query = "SELECT DISTINCT s.StoryID, s.Story_Title, s.Story_URL, s.views, s.DateTime, s.ImageID, c.MemberID, c.Comment_Text, c.CommentID, c.Date_Time
					FROM tbl_comments c
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					WHERE (c.MemberID = '$userID') AND (c.Comment_Text!='Promote')  AND $pinStatement
					ORDER BY c.Date_Time DESC LIMIT 0, 1";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$imageID = HelpingDBMethods::GetMemberImageID($userID);
			$hubData = HelpingDBMethods::GetHubInfo($handle);
			$name = MemberDBMethods::GetUsername($hubData['h-memberID']);
			if($imageID==0){
				$imageID = HelpingDBMethods::GetMemberImageID($hubData['h-memberID']);
			}
			$MemberID = $GLOBALS['user']->userID;	
			$storyID = $row['StoryID'];
			$isPromoted=HelpingDBMethods::GetPromoted($storyID, $MemberID);
			$hubData = HelpingDBMethods::getHubDatafromMemberID($userID);
			$promoCount = HelpingDBMethods::GetPromoteCount($storyID);
			$isLiked = HelpingDBMethods::GetIsStoryLiked($storyID, $MemberID);
			$urlhex = HelpingMethods::strToHex($row['Story_URL']);
			$commentID = $row['CommentID'];
			$isRestated = HelpingDBMethods::GetRestated($commentID, $MemberID);
			if($MemberID==$hubData['h-memberID']&&$pinned!=""){
				$pin = "<span class='pin unpin' id='unpin-".$commentID."'><a onClick='unpinComment(".$commentID.", ".$userID.")'>Unpin</a></span>";
			} else{
				$pin = "";
			}
			$replyText ='<a onClick="$myjquery(\'#comments-box-'.$commentID.'\').show(); $myjquery(\'#comments-box-'.$commentID.'\').show(); $myjquery(\'#comments-text-area-'.$commentID.'\').focus();" class="doComment">Comment</a>';
			$commentsBox = '<div class="commentsBox" id="comments-box-'.$commentID.'"><textarea id="comments-text-area-'.$commentID.'"></textarea><span class="CommentShow" onClick="commentShow('.$commentID.')"><a onClick="inlineReply('.$storyID.',\''.$urlhex.'\','.$commentID.')" id="replytext">Reply</a></span></div>';
		$imgString = '<a href="http://www.kahub.com/'.$hubData['h-handle'].'"><img class = "story-image phubimg" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/></a>';
		if(!$isLiked)
		{
			$interesting = '<span class="Interesting" onclick="LikeStory('.$storyID.',\''.$urlhex.'\')" id="story-'.$storyID.'">Add to Fav Stream</span>';

		} else {
			$interesting = '<span class="Interesting" id="done">Added!</span>';
		}
		if(!$isPromoted){
			$promote = "<span class='promoteLoad' onClick='promoteShow(".$storyID.")'><a onClick='PromoteStory(".$storyID.", \"".$urlhex."\")' class='promolinkhub' id='promote-story-link-".$storyID."'>Promote</a></span> (<span class='promo-numhub' id='promo-num-".$storyID."'>".$promoCount."</span>)";
		} else {
			$promote = '<span class="promoted hub">Promoted!</span> (<span class="promo-numhub" hub>'.$promoCount.'</span>)';
		}
			if(!$isRestated){
				$restate = '<span class="restateLoad" onClick="restateShow('.$storyID.')"><a onClick="RestateComment('.$storyID.',\''.$urlhex.'\','.$commentID.','.$userID.')" id="restate-Story-Link-'.$storyID.'" class="restate">Restate</a></span>';
			} else{
				$restate = '<span class="restated">Restated!</span>';
			}
		if($row != false)
		{
			$storyText = HelpingMethods::GetLimitedText(HelpingDBMethods::GetStoryText($row['StoryID']), 590);
			$p = 'onMouseOver="$myjquery(\'#unpin-'.$commentID.'\').show()" onMouseOut="$myjquery(\'#unpin-'.$commentID.'\').hide()"';
			$result = "<div class='lateststory' ".$p.">
			<div class='lateststorytitle'><a href='http://www.kahub.com/anyShare/xd_check?rURL=".$row['Story_URL']."'>".HelpingMethods::GetLimitedText($row['Story_Title'], 60)."</a> <span class='promotepHub'> ".$promote."</span></div>
			<div class='lateststorydescrip'>".$storyText."</div>
			<div class='lateststoryuname'><a href='http://www.kahub.com/".$hubData['h-handle']."'><span class='realName latest'>".$name."</span> <span class='handle latest'>(/".$handle.")</span></div>
			
			<div class='lateststorycomment'>".$imgString." ".$row['Comment_Text']." ".$pin."</div>
			<div class='latestelse'> <span class='comment'>".$replyText."</span> &#183; <span class='restate'>".$restate."</span> &#183; <span class='interesting'>".$interesting."</span></div>".$commentsBox."</div>";
		}
		return $result;
	}
	function GetLatestStoriesPersonHub($array, $mid, $handle)
	{
		$hubData = HelpingDBMethods::GetHubInfo($handle);
		$name = MemberDBMethods::GetUsername($hubData['h-memberID']);
		$MemberID = $GLOBALS['user']->userID;
		foreach ($array as $storyID => $commentID)
		{
			$comment = $commentID;
			if ($comment!="Interesting"){
			$storyData = HelpingDBMethods::GetStoryData($storyID);
			$isPromoted=HelpingDBMethods::GetPromoted($storyID, $MemberID);
			$promoCount = HelpingDBMethods::GetPromoteCount($storyID);
			$isLiked = HelpingDBMethods::GetIsStoryLiked($storyID, $MemberID);
			$urlhex = HelpingMethods::strToHex($storyData['s-url']);
			$imageID = HelpingDBMethods::GetMemberImageID($mid);
			if($imageID==0){
				$imageID = HelpingDBMethods::GetMemberImageID($hubData['h-memberID']);
			}
			$commentData = HelpingDBMethods::GetCommentData($commentID);
			$replyCount = HelpingDBMethods::GetReplyCount($commentID);
			$isRestated = HelpingDBMethods::GetRestated($commentID, $MemberID);
			if(!$isRestated){
				$restate = '<span class="restateLoad" onClick="restateShow('.$storyID.')"><a onClick="RestateComment('.$storyID.',\''.$urlhex.'\','.$commentID.','.$mid.')" id="restate-Story-Link-'.$storyID.'" class="restate">Restate</a></span>';
			} else{
				$restate = '<span class="restated">Restated!</span>';
			}
			$replyText ='<a onClick="$myjquery(\'#comments-box-'.$commentID.'\').show(); $myjquery(\'#comments-box-'.$commentID.'\').show(); $myjquery(\'#comments-text-area-'.$commentID.'\').focus();" class="doComment">Comment</a>';
			$commentsBox = '<div class="commentsBox" id="comments-box-'.$commentID.'"><textarea id="comments-text-area-'.$commentID.'"></textarea><span class="CommentShow" onClick="commentShow('.$commentID.')"><a onClick="inlineReply('.$storyID.',\''.$urlhex.'\','.$commentID.')" id="replytext">Reply</a></span></div>';
			if(!$isLiked)
			{
				$thumbString = '<a id = "Like-Story-Link-' . $storyID . '" href = "javascript:LikeStory(' . $storyID . ')"><img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-11.jpg" alt = "" /></a>';
			}
			if(!$isPromoted){
				$promote = "<span class='promoteLoad' onClick='promoteShow(".$storyID.")'><a onClick='PromoteStory(".$storyID.", \"".$urlhex."\")' class='promolink' id='promote-story-link-".$storyID."'>Promote</a></span> (<span class='promo-num' id='promo-num-".$storyID."'>".$promoCount."</span>)";
			} else {
				$promote = '<span class="promoted">Promoted!</span> (<span class="promo-num">'.$promoCount.'</span>)';
			}
			if($MemberID==$hubData['h-memberID']){
				$pin = "<span class='pin' id='pin-".$commentID."'><a onClick='pinComment(".$commentID.", ".$mid.")'>Pin</a></span>";
			} else{
				$pin = "";
			}
			if($promoCount>50){
				$storyText = HelpingMethods::GetLimitedText(HelpingDBMethods::GetStoryText($storyID), 250);
			} else {
				$storyText ="";
			}
			if($replyCount>0){
				$reply="<div class='repliesCount phub'><a href='http://www.kahub.com/l/comments?c=".$commentID."'>".$replyCount." replies</a></div>";
			} else{
				$reply ="";
			}
			$imgString = '<a href="http://www.kahub.com/l/phub.php?user='.$userID.'"><img class = "phublatest" src = "' . HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail') . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/></a>';
			if($commentData['c-text']!="Bump"&&$commentData['c-reply']==0){
				$result .= '<li onMouseOver="$myjquery(\'#pin-'.$commentID.'\').show()" onMouseOut="$myjquery(\'#pin-'.$commentID.'\').hide()" class="profile-stories phub"><a href = "http://www.kahub.com/anyShare/xd_check?rURL=' . $storyData['s-url'] . '" target = "_blank" onclick = "StoryClick(' . $storyID . ')"><p style = "padding-top:8px;" class = "heavy phub">' . HelpingMethods::GetLimitedText($storyData['s-title'], 70) . '</a><div class="storyText phubpage">'.$storyText.'</div><div class="name"><a href="http://www.kahub.com/l/phub.php?user='.$handle.'">'.$imgString.'</a><span class="realName"><a href="http://www.kahub.com/l/phub.php?user='.$handle.'">'.$name.'</a></span> <span class="handle">(/'.$handle.')</span></div><div class="comment">'.$commentData['c-text'].' '.$pin.'</div><div class="else hub"><span class="comment">'.$replyText.'</span> &#183; '.$restate.' <span class="promote">'.$promote.'</span></div>'.$reply.'<div class="repliesinlinephub">'.$commentsBox.'</li>';
			} else if($commentData['c-reply']!=0&&$commentData['c-text']!="Bump") {
				$replyData = HelpingDBMethods::GetCommentData($commentData['c-reply']);
				$replyID = $replyData['c-memberid'];
				$replyimageID = HelpingDBMethods::GetMemberImageID($replyID);
				$hubDataReply = HelpingDBMethods::GetHubInfoFromMemberID($replyID);
				$replyName = MemberDBMethods::GetUsername($replyID);
				$noFollowers = HelpingDBMethods::GetNoOfFriends($hubData['h-hubID']);
				if($replyimageID==0){
					$replyimageID = HelpingDBMethods::GetMemberImageID($hubDataReply['h-memberID']);
				}
				$following = HelpingDBMethods::isMyFriend($MemberID,$hubDataReply['h-hubID']);
				$pal = HelpingDBMethods::isMyFriend($MemberID,$hubDataReply['h-memberID']);
				if(!$following&&!$pal){
					$follow = ' &#183; <a onclick="Followhub('.$hubDataReply['h-hubID'].');" class="inlineFollow">Follow</a>';
				} else {
					$follow = '';
				}
				
				
				$replyimgString = '<a href="http://www.kahub.com/l/phub.php?user='.$hubDataReply['h-handle'].'"><img class = "phublatestreply" src = "' . HelpingDBMethods::GetImageData($replyimageID, 'member', 'thumbnail') . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/></a>';
				$result .= '<li onMouseOver="$myjquery(\'#pin-'.$commentID.'\').show()" onMouseOut="$myjquery(\'#pin-'.$commentID.'\').hide()" class="profile-stories phub"><a href = "http://www.kahub.com/anyShare/xd_check?rURL=' . $storyData['s-url'] . '" target = "_blank" onclick = "StoryClick(' . $storyID . ')"><p style = "padding-top:8px;" class = "heavy phub">' . HelpingMethods::GetLimitedText($storyData['s-title'], 70) . '</a><div class="storyText phubpage">'.$storyText.'</div><div class="name"><a href="http://www.kahub.com/l/phub.php?user='.$handle.'">'.$imgString.'</a><a href="http://www.kahub.com/l/phub.php?user='.$handle.'"><span class="realName">'.$name.'</span></a> <span class="handle">(/'.$handle.')</span></div><div class="comment">'.$commentData['c-text'].' '.$pin.'<div class="replyphub"><a href="http://www.kahub.com/'.$hubDataReply['h-handle'].'">'.$replyimgString.'</a><a href="http://www.kahub.com/'.$hubDataReply['h-handle'].'"><span class="realName">'.$replyName.'</span></a> <span class="handle">(/'.$hubDataReply['h-handle'].') &#183; '.$hubDataReply['h-headline'].' &#183; '.$noFollowers.' Followers</span><span class="followInline">'.$follow.'</span></div><div class="comment">'.$replyData['c-text'].'</div></div><div class="else hub"><span class="comment">'.$replyText.'</span> &#183; '.$restate.' <span class="promote">'.$promote.'</span></div>'.$reply.'<div class="repliesinlinephub">'.$commentsBox.'</li>';
			} else {
				$replyData = HelpingDBMethods::GetCommentData($commentData['c-reply']);
				$replyID = $replyData['c-memberid'];
				$replyimageID = HelpingDBMethods::GetMemberImageID($replyID);
				$hubDataReply = HelpingDBMethods::GetHubInfoFromMemberID($replyID);
				$replyName = MemberDBMethods::GetUsername($hubDataReply['h-memberID']);
				$noFollowers = HelpingDBMethods::GetNoOfFriends($hubData['h-hubID']);
				if($replyimageID==0){
					$replyimageID = HelpingDBMethods::GetMemberImageID($hubDataReply['h-memberID']);
				}
				$following = HelpingDBMethods::isMyFriend($MemberID,$hubDataReply['h-hubID']);
				$pal = HelpingDBMethods::isMyFriend($MemberID,$hubDataReply['h-memberID']);
				if(!$following&&!$pal){
					$follow = ' &#183; <a onclick="Followhub('.$hubDataReply['h-hubID'].');" class="inlineFollow">Follow</a>';
				} else {
					$follow = '';
				}
				$replyimgString = '<a href="http://www.kahub.com/l/phub.php?user='.$hubDataReply['h-handle'].'"><img class = "phublatestreply" src = "' . HelpingDBMethods::GetImageData($replyimageID, 'member', 'thumbnail') . '"  alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\' "/></a>';
				$result .= '<li onMouseOver="$myjquery(\'#pin-'.$commentID.'\').show()" onMouseOut="$myjquery(\'#pin-'.$commentID.'\').hide()" class="profile-stories phub"><a href = "http://www.kahub.com/anyShare/xd_check?rURL=' . $storyData['s-url'] . '" target = "_blank" onclick = "StoryClick(' . $storyID . ')"><p style = "padding-top:8px;" class = "heavy phub">' . HelpingMethods::GetLimitedText($storyData['s-title'], 70) . '</a><div class="storyText phubpage">'.$storyText.'</div><div class="name"><a href="http://www.kahub.com/l/phub.php?user='.$handle.'">'.$imgString.'</a><a href="http://www.kahub.com/l/phub.php?user='.$handle.'"><span class="realName">'.$name.'</span></a> <span class="handle">(/'.$handle.')</span></div><div class="comment"><div class="replyphub"><a href="http://www.kahub.com/'.$hubDataReply['h-handle'].'">'.$replyimgString.'</a><a href="http://www.kahub.com/'.$hubDataReply['h-handle'].'"><span class="realName">'.$replyName.'</span></a> <span class="handle">(/'.$hubDataReply['h-handle'].') &#183; '.$hubDataReply['h-headline'].' &#183; '.$noFollowers.' Followers</span><span class="followInline">'.$follow.'</span></div><div class="comment">'.$replyData['c-text'].'</div></div><div class="else hub"><span class="comment">'.$replyText.'</span> &#183; '.$restate.' <span class="promote">'.$promote.'</span></div>'.$reply.'<div class="repliesinlinephub">'.$commentsBox.'</li>';
			}

		}
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function GetLatestStoriesPerson($array)
	{
		$MemberID = $GLOBALS['user']->userID;	
		foreach ($array as $key => $storyURL)
		{
			$comment = $row['Comment_Text'];
			if ($comment!="Interesting"){
			$storyData = HelpingDBMethods::GetStoryDataFromURL($storyURL);
			$storyID = $storyData['s-id'];
			$isPromoted=HelpingDBMethods::GetPromoted($storyID, $MemberID);
			$promoCount = HelpingDBMethods::GetPromoteCount($storyID);
			$isLiked = HelpingDBMethods::GetIsStoryLiked($storyID, $MemberID);
			$urlhex = HelpingMethods::strToHex($row['Story_URL']);
			$commentText ='<a onClick="$myjquery(\'#comments-box-'.$storyID.'\').show(); $myjquery(\'#comments-box-'.$storyID.'\').show(); $myjquery(\'#comments-text-area-'.$storyID.'\').focus();" class="doComment">Comment</a>';
			$hubComments = '<div class="commentsBox" id="comments-box-'.$storyID.'"><textarea id="comments-text-area-'.$storyID.'"></textarea><span class="CommentShow" onClick="commentShow('.$storyID.')"><a onClick="PostStory('.$storyID.',\''.$urlhex.'\', '.$storyID.')" id="replytext">Comment</a></span></div>';
			$thumbString = '<img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />';
			if(!$isLiked)
			{
				$thumbString = '<a id = "Like-Story-Link-' . $storyID . '" href = "javascript:LikeStory(' . $storyID . ')"><img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-11.jpg" alt = "" /></a>';
			}
			if(!$isPromoted){
				$promote = "<span class='promoteLoad' onClick='promoteShow(".$storyID.")'><a onClick='PromoteStory(".$storyID.", \"".$urlhex."\")' class='promolink' id='promote-story-link-".$storyID."'>Promote</a></span> (<span class='promo-num' id='promo-num-".$storyID."'>".$promoCount."</span>)";
			} else {
				$promote = '<span class="promoted">Promoted!</span> (<span class="promo-num">'.$promoCount.'</span>)';
			}
			$result .= '<ul class="profile-stories"><li><a href = "http://www.kahub.com/anyShare/xd_check?rURL=' . $storyURL . '" target = "_blank" onclick = "StoryClick(' . $storyID . ')"><p style = "padding-top:8px;" class = "heavy">' . HelpingMethods::GetLimitedText($storyData['s-title'], 70) . '</a><div class="else hub"><span class="comment">'.$commentText.'</span> &#183; <span class="promote">'.$promote.'</span></div>'.$hubComments.'</li></ul>';
		}
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function showFeaturedStories($featuredArray){
		$currentIndex=1;
		$MemberID = $GLOBALS['user']->userID;	
		
		foreach ($featuredArray as $k => $v) {
			if($currentIndex<4){
				$currentIndex = $currentIndex+1;
				$storyText = HelpingMethods::GetLimitedText(HelpingDBMethods::GetStoryText($k), 300);
				$storyData = HelpingDBMethods::GetStoryData($k);
				$urlhex = HelpingMethods::strToHex($storyData['s-url']);
				$storyID= $k;
				$promoCount = HelpingDBMethods::GetPromoteCount($storyID);
				$isLiked = HelpingDBMethods::GetIsStoryLiked($storyID, $MemberID);
				$isPromoted=HelpingDBMethods::GetPromoted($storyID, $MemberID);
				$commentText ='<a onClick="$myjquery(\'#comments-box-'.$storyID.'\').show(); $myjquery(\'#comments-box-'.$storyID.'\').show(); $myjquery(\'#comments-text-area-'.$storyID.'\').focus();" class="doComment">Comment</a>';
				$hubComments = '<div class="commentsBox" id="comments-box-'.$storyID.'"><textarea id="comments-text-area-'.$storyID.'"></textarea><span class="CommentShow" onClick="commentShow('.$storyID.')"><a onClick="PostStory('.$storyID.',\''.$urlhex.'\', '.$storyID.')" id="replytext">Comment</a></span></div>';
				$thumbString = '<img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />';
				if(!$isLiked)
				{
					$interesting = '<span class="Interesting" onclick="LikeStory('.$storyID.',\''.$urlhex.'\')" id="story-'.$storyID.'">+Fav Stream</span>';

				} else {
					$interesting = '<span class="Interesting" id="done">Added!</span>';
				}
				if(!$isPromoted){
					$promote = "<span class='promoteLoad' onClick='promoteShow(".$storyID.")'><a onClick='PromoteStory(".$storyID.", \"".$urlhex."\")' class='promolink' id='promote-story-link-".$storyID."'>Promote</a></span> (<span class='promo-num' id='promo-num-".$storyID."'>".$promoCount."</span>)";
				} else {
					$promote = '<span class="promoted">Promoted!</span> (<span class="promo-num">'.$promoCount.'</span>)';
				}
				$result .= '<li class = onclick=getStoryInfo('.$storyID.')><div class="storyText"><a href = "http://www.kahub.com/anyShare/xd_check.php?rURL=' . $storyData['s-url'] . '" target = "_blank" onclick = "StoryClick(' . $k . ')"><div class="storyTextTitle">'.HelpingMethods::GetLimitedText($storyData['s-title'], 70) .'</div>'.$storyText.'</a></div><div class="others"><span class="comment">'.$commentText.'</span> &#183; <span class="promote">'.$promote.'</span> &#183; <span class="read" onClick="readLater('.$storyID.')"> '.$interesting.'</span><span class="date"'.HelpingDBMethods::time2str($date).'</span></div>'.$hubComments.'</li><div class="clear"></div>';
			}
		}
		return $result;
	}
	function GetStoriesForFeatured($userID)
	{
		$rootURL = Settings::GetRootURL();
		$result = "";
		$Query = "SELECT DISTINCT Story_URL FROM tbl_story WHERE (Story_Title LIKE '%$userID%')
					ORDER BY DateTime DESC LIMIT 0, 25";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$stories = array();
		while($row != false){
			$points = 7;
			$storyData = HelpingDBMethods::GetStoryDataFromURL($row['Story_URL']);
			$storyID = $storyData['s-id'];
			$date = HelpingDBMethods::GetDateFromURL($row['Story_URL']);
			$r = 0.85;
			$domain = HelpingDBMethods::getDomain($row['Story_URL']); 
			$publishCount = HelpingDBMethods::GetPublishCount($domain, $userID);
			$mostRecentPromotion = HelpingDBMethods::GetMostRecentPromotion($storyID);
			$since=HelpingDBMethods::getHoursSince($date);
			$sincePromo=HelpingDBMethods::getHoursSince($mostRecentPromotion);
			$promo = HelpingDBMethods::GetPromoteCount($storyID);
			$comments = HelpingDBMethods::countNumberComments($storyID);
			$promoCount = $promo+$comments;
			if($promoCount==0){
				$sincePromo=100;
			}
			$powerPoints = HelpingDBMethods::getPower($since+2, 1.25);
			$points = (((($promoCount - 1)/$powerPoints*2 - $sincePromo))*2-($publishCount*1.5)+($r*5));
			if($points<0){
				$points=0;
			}
			$stories[$storyID] = $points;		
			$row = mysql_fetch_array($QueryResult);
		}
		return $stories;
	}
	
	function pinComment($commentID, $hubID){
		$pinned = HelpingDBMethods::hasPinnedComment($hubID);
		$hub = mysql_real_escape_string($hubID);
		if($pinned!=""){
			$Query = "DELETE FROM tbl_person_featured_story WHERE hubID= $hub";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
		
		$Query2 = "INSERT INTO tbl_person_featured_story (hubID, commentID) 
				VALUES (" . $hub . ", " . $commentID . ")";
		$QueryResult2 =  mysql_query($Query2)or die(mysql_error());
	}
	function unpinComment($commentID, $hubID){
		$hub = mysql_real_escape_string($hubID);
		$Query = "DELETE FROM tbl_person_featured_story WHERE hubID= $hub";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	function unfollowhub($currentID, $hubID){
		$hub = mysql_real_escape_string($hubID);
		$Member = mysql_real_escape_string($currentID);
		$Query = "DELETE FROM tbl_friends WHERE MemberID_Active=$hub AND MemberID_Passive=$Member";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$Query = "DELETE FROM tbl_friends WHERE MemberID_Passive=$hub AND MemberID_Active=$Member";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	function hasPinnedComment($hubID){
		$hub = mysql_real_escape_string($hubID);
		$Query = "SELECT commentID FROM tbl_person_featured_story WHERE (hubID=$hub) LIMIT 0, 1";
		$QueryResult = mysql_query($Query);
		$row = mysql_fetch_array($QueryResult);
		return $row['commentID'];
	}
	
	function wikidefinition($s) {
		$url = "http://en.wikipedia.org/w/api.php?action=opensearch&search=".urlencode($s)."&format=xml&limit=1";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
		$page = curl_exec($ch);
		$xml = simplexml_load_string($page);
		if((string)$xml->Section->Item->Description) {
			return array((string)$xml->Section->Item->Image->attributes(), (string)$xml->Section->Item->Description, (string)$xml->Section->Item->Url, (string)$xml->Section->Item->Text, (string)$xml->Section->Item->Image->attributes()->width);
		} else {
			return "";
		}
	}
	function wikiImg($s) {
		$url = "http://en.wikipedia.org/w/api.php?action=opensearch&search=".urlencode($s)."&format=xml&limit=1";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
		$page = curl_exec($ch);
		$xml = simplexml_load_string($page);
		if($xml->Section->Item->Image->attributes()) {
			return array((string)$xml->Section->Item->Image->attributes(), (string)$xml->Section->Item->Image->attributes()->width);
		} else {
			return "";
		}
	}
	function duckDuckGo($s) {
		$url = "http://api.duckduckgo.com/?q=".urlencode($s)."&format=xml";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
		$page = curl_exec($ch);
		$xml = simplexml_load_string($page);
		if((string)$xml->Abstract) {
			return array((string)$xml->AbstractText, (string)$xml->Results->Result->FirstURL, (string)$xml->Results->Result->Text);
		} else {
			return "";
		}
	}
	
	function hasPublished($storyID, $hubID)
	{
		$result = "";
		$hub=MemberDBMethods::isHub($hubID);
		$Query = "SELECT id FROM tbl_story_published WHERE StoryID = '$storyID' AND hub = '$hubID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = "";
		}
		else if($hub==1)
		{
			HelpingDBMethods::PostComments($storyID, 'NULL', 'none', $hubID, 0);
			HelpingDBMethods::publishStory($storyID, $hubID);
		}
	}
	function isBanned($MemberID)
	{
		$result = "";
		$Query = "SELECT BanType FROM tbl_ban WHERE MemberID = '$MemberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['BanType'];
		}
		else
		{
			$result="pass";
		}
		return $result;
	}
	function isSpam($CommentID)
	{
		$result = "";
		$Query = "SELECT id FROM tbl_spam WHERE CommentID = '$CommentID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = "spam";
		}
		else
		{
			$result="pass";
		}
		return $result;
	}
	function getHubInfo($handle)
	{
		$result = array();
		$Query = "SELECT * FROM tbl_person_hub WHERE handle = '$handle'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['h-memberID'] = $row['MemberID'];
			$result['h-hubID'] = $row['hubMemberID'];
			$result['h-handle'] = $row['handle'];
			$result['h-background'] = $row['background'];
			$result['h-headline'] = $row['headline'];
			$result['h-twitter'] = $row['twitter'];
			$result['h-facebook'] = $row['facebook'];
			$result['h-gplus'] = $row['gplus'];
			$result['h-personal'] = $row['personal'];
		}
		else
		{
			$result="pass";
		}
		return $result;
	}
	function getHubInfoFromID($hubID)
	{
		$result = array();
		$Query = "SELECT * FROM tbl_person_hub WHERE hubMemberID = '$hubID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['h-memberID'] = $row['MemberID'];
			$result['h-hubID'] = $row['hubMemberID'];
			$result['h-handle'] = $row['handle'];
			$result['h-background'] = $row['background'];
			$result['h-headline'] = $row['headline'];
			$result['h-twitter'] = $row['twitter'];
			$result['h-facebook'] = $row['facebook'];
			$result['h-gplus'] = $row['gplus'];
			$result['h-personal'] = $row['personal'];
		}
		else
		{
			$result="pass";
		}
		return $result;
	}
	function getHubInfoFromMemberID($hubID)
	{
		$isHub = MemberDBMethods::isHub($hubID);
		if($isHub!=2){
			$result = array();
			$Query = "SELECT * FROM tbl_person_hub WHERE MemberID = '$hubID'";	
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$result['h-memberID'] = $row['MemberID'];
				$result['h-hubID'] = $row['hubMemberID'];
				$result['h-handle'] = $row['handle'];
				$result['h-background'] = $row['background'];
				$result['h-headline'] = $row['headline'];
				$result['h-twitter'] = $row['twitter'];
				$result['h-facebook'] = $row['facebook'];
				$result['h-gplus'] = $row['gplus'];
				$result['h-personal'] = $row['personal'];
			}
		} else{
			$result = array();
			$Query = "SELECT * FROM tbl_person_hub WHERE hubMemberID = '$hubID'";	
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$result['h-memberID'] = $row['MemberID'];
				$result['h-hubID'] = $row['hubMemberID'];
				$result['h-handle'] = $row['handle'];
				$result['h-background'] = $row['background'];
				$result['h-headline'] = $row['headline'];
				$result['h-twitter'] = $row['twitter'];
				$result['h-facebook'] = $row['facebook'];
				$result['h-gplus'] = $row['gplus'];
				$result['h-personal'] = $row['personal'];
			}
		}
		return $result;
	}
	function hasHandle($MemberID){
	    $Query = "SELECT * FROM tbl_person_hub WHERE MemberID = '$MemberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row==false){
		    $result=false;
		} else {
		    $result=true;
		}
		return $result;
	}
	function getCurrentHubID($userID)
	{
		$Query = "SELECT hubMemberID FROM tbl_person_hub WHERE MemberID = '$userID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['hubMemberID'];
		}
		else
		{
			$result="pass";
		}
		return $result;
	}
	function spamScore($MemberID)
	{
		$result = "";
		$Query = "SELECT COUNT(MemberID) as Count FROM tbl_spam WHERE MemberID = '$MemberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		else
		{
			$result= 0;
		}
		return $result;
	}
	
	function getPower($base, $number){
		$power = pow($base, $number);
		return $power;
	}
	function getHoursSince($date){
		$dates = strtotime($date);
		$since = 0;
		$diff = time() - $dates;
		if($diff < 7200) $since = 1;
		if($diff < 86400) $since = floor($diff / 3600);
		return $since;
	}
	
	function getDomain($url){
		$raw_url = parse_url($url); 
		$domain_only =str_replace ('www.','', $raw_url); 
		$domain =  $domain_only['host'];
		return $domain;
	}
	
	function time2str($ts)
		{
			if(!ctype_digit($ts))
				$ts = strtotime($ts);

			$diff = time() - $ts;
			if($diff == 0)
				return 'now';
			elseif($diff > 0)
			{
				$day_diff = floor($diff / 86400);
				if($day_diff == 0)
				{
					if($diff < 60) return 'just now';
					if($diff < 120) return '1 minute ago';
					if($diff < 3600) return floor($diff / 60) . ' minutes ago';
					if($diff < 7200) return '1 hour ago';
					if($diff < 86400) return floor($diff / 3600) . ' hours ago';
				}
				if($day_diff == 1) return 'Yesterday';
				if($day_diff < 7) return $day_diff . ' days ago';
				if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
				if($day_diff < 60) return 'last month';
				return date('F Y', $ts);
			}
			else
			{
				$diff = abs($diff);
				$day_diff = floor($diff / 86400);
				if($day_diff == 0)
				{
					if($diff < 120) return 'in a minute';
					if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
					if($diff < 7200) return 'in an hour';
					if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
				}
				if($day_diff == 1) return 'Tomorrow';
				if($day_diff < 4) return date('l', $ts);
				if($day_diff < 7 + (7 - date('w'))) return 'next week';
				if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
				if(date('n', $ts) == date('n') + 1) return 'next month';
				return date('F Y', $ts);
			}
		}
	function GetLatestStoriesAll($offset, $limit, $userID, $getTotlaResults = false, &$totlalResults = null)
	{
		$rootURL = Settings::GetRootURL();
		if($getTotlaResults)
		{
			$Query = "SELECT COUNT(DISTINCT s.StoryID) AS Count
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$totlalResults = mysql_result($QueryResult, 0, 0);
		}
		$result = "";
		$Query = "SELECT DISTINCT s.StoryID, s.Story_Title, s.Story_URL, s.views, s.DateTime, s.ImageID
					FROM tbl_friends a
					INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
					INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID OR a.MemberID_Passive = c.MemberID
					INNER JOIN tbl_story s ON c.StoryID = s.StoryID
					ORDER BY s.DateTime DESC LIMIT $offset, $limit";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while( $row != false)
		{
			$storyRank = StoryRanking::GetStoryCommulativeRank($row['StoryID'], $userID);
			$rankClass = 'rank-1';
			if($storyRank < 8)
			{
				$rankClass = 'rank-1';
			}
			elseif($storyRank <= 22)
			{
				$rankClass = 'rank-2';
			}
			elseif($storyRank <= 37)
			{
				$rankClass = 'rank-3';
			}
			elseif($storyRank <= 52)
			{
				$rankClass = 'rank-4';				
			} 
			elseif($storyRank <= 67)
			{
				$rankClass = 'rank-5';
			}
			elseif($storyRank <= 82)
			{
				$rankClass = 'rank-6';
			}
			elseif($storyRank <= 97)
			{
				$rankClass = 'rank-7';
			}
			else
			{
				$rankClass = 'rank-7';
			}
			$isLiked = HelpingDBMethods::GetIsStoryLiked($row['StoryID'], $userID);
			$thumbString = '<img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />';
			if(!$isLiked)
			{
				$thumbString = '<a id = "Like-Story-Link-' . $row['StoryID'] . '" href = "javascript:LikeStory(' . $row['StoryID'] . ')"><img class = "story-like-image" src = "' . $rootURL . 'images/website/connichiwahloggedinhomef-11.jpg" alt = "" /></a>';
			}
			$imgString = '<img class = "story-image" src = "' . HelpingDBMethods::GetImageData($row['ImageID'], 'story') . '" alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\'"/>';
			$result .= '<li class = "' . $rankClass . '">'. $imgString . $thumbString . '<a href = "' . $row['Story_URL'] . '" target = "_blank" onclick = "StoryClick(' . $row['StoryID'] . ')"><h2 style = "padding-top:8px;" class = "heavy">' . HelpingMethods::GetLimitedText($row['Story_Title'], 50) . '</h2></a></li>';
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function isInRestrictedDomain($domainName)
	{
		$result = 'false'; 
		$Query = "SELECT COUNT(DomainID) AS Count FROM tbl_restricted_domains WHERE (DomainURL  = '$domainName')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$count = $row['Count'];
			if($count > 0)
				$result = 'true';
		}
		return $result;
	}
	
	function GetFriendRequestCount($MemberID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(a.FriendsID) AS Count 
				FROM tbl_friends a
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive
				AND a.MemberID_Passive = b.MemberID_Active
				WHERE (a.MemberID_Passive = '$MemberID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	function GetPromoteCount($storyID)
	{
	    $memcache = new Memcache;
    	$memcache->connect('localhost', 11211) or die ("Could not connect");
    	$key = "promote";
    	$keyPromote2 = md5($storyID);
    	$keyPromote = $key.$keyPromote2;
    	$result = $memcache->get($keyPromote);
    	if($result == null) {
		    $result = 0; 
		    $Query = "SELECT COUNT(PromoID) AS Count 
				    FROM tbl_story_promote
				    WHERE (StoryID = '$storyID')";	
		        $QueryResult =  mysql_query($Query)or die(mysql_error());
		        $row = mysql_fetch_array($QueryResult);
		        if($row!=false)
		        {
			        $promote = $row['Count'];
		        }
		        $comments = HelpingDBMethods::countNumberComments($storyID);
		        $result = ($promote*2)+($comments*17)+rand(0,3);
		        if($promote==0&&$comments==0){
		            $result=rand(1,13);
		        }
		    $memcache->set($keyPromote, $result, false, 250);
		}
		$result = $memcache->get($keyPromote);
		return $result;
	}
	function GetRestateCount($commentID)
	{
		$result = 0; 
		$Query = "SELECT COUNT(resID) AS Count 
				FROM tbl_comment_restate
				WHERE (commentID = '$commentID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	function GetPublishCount($domain, $hub)
	{
		$result = 0; 
		$Query = "SELECT COUNT(id) AS Count 
				FROM tbl_story_published
				WHERE (Story_Domain = '$domain') AND (hub = '$hub')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Count'];
		}
		return $result;
	}
	
	function GetIsStoryLiked($StoryID, $userID)
	{
		$result = false; 
		$Query = "SELECT COUNT(LikeID) as Count FROM tbl_story_like WHERE (MemberID  = '$userID') AND (StoryID = '$StoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			//$result = $row['StoryID'];
			$count = $row['Count'];
			if($count > 0)
				$result = true;
		}
		return $result;
	}
	function GetRestated($commentID, $userID)
	{
		$result = false; 
		$Query = "SELECT COUNT(resID) as Count FROM tbl_comment_restate WHERE (MemberID  = '$userID') AND (commentID = '$commentID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			//$result = $row['StoryID'];
			$count = $row['Count'];
			if($count > 0)
				$result = true;
		}
		return $result;
	}
	function verifyResetCode($code, $email)
	{
		$result = false; 
		$Query = "SELECT COUNT(id) as Count FROM tbl_reset_pass WHERE (email  = '$email') AND (code = '$code') AND (used = 0)";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			//$result = $row['StoryID'];
			$count = $row['Count'];
			if($count > 0)
				$result = true;
		}
		return $result;
	}
	function GetPromoted($storyID, $userID)
	{
		$result = false; 
		$Query = "SELECT COUNT(PromoID) as Count FROM tbl_story_promote WHERE (MemberID  = '$userID') AND (storyID = '$storyID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			//$result = $row['StoryID'];
			$count = $row['Count'];
			if($count > 0)
				$result = true;
		}
		return $result;
	}
	function storyInDB($url)
	{
		$result = false; 
		$storyID = HelpingDBMethods::GetStoryID($url);
		
		$Query = "SELECT COUNT(id) as Count FROM tbl_story_text WHERE (StoryID  = '$storyID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			//$result = $row['StoryID'];
			$count = $row['Count'];
			if($count > 0)
				$result = true;
		}
		return $result;
	}
	
	
	function LikeStory($StoryID, $MemberID)
	{
		//$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_story_like (MemberID, StoryID) 
				VALUES (" . $MemberID . ", " . $StoryID . ")";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function restateStory($commentID, $MemberID)
	{
		$commentData = HelpingDBMethods::GetCommentData($commentID);
		//$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_comment_restate(commentID, MemberID, AuthorID, StoryID) 
				VALUES (" . $commentID . "," . $MemberID . ", " . $commentData['c-memberid'] . ", " . $commentData['c-StoryID'] . ")";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function promoteStory($storyID, $MemberID)
	{
		$storyData = HelpingDBMethods::GetStoryData($storyID);
		$parsed = parse_url($storyData['s-url']); 
		$hostname = $parsed['host'];
		//$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_story_promote(MemberID, StoryID, Domain) 
				VALUES (" . $MemberID . "," . $storyID . ", \"" . $hostname . "\")";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function resetPassInsert($email)
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$code=sha1(md5($email)+sha1($ip)+md5(time()));
		//$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_reset_pass(email, code, ip) VALUES (\"" . $email . "\",\"" . $code . "\", \"" . $ip . "\")";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return $code;
	}
	
	function resetPassword($email){
		require_once 'resetPassSend.php';
		$code = HelpingDBMethods::resetPassInsert($email);
		reset::resetPass($code, $email);
		return "reset";
	}
	
	
	
	function StoryClick($StoryID)
	{
		//$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "UPDATE tbl_story SET views = views + 1 WHERE StoryID='$StoryID'";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function newPassword($email, $password)
	{
		$password = md5($password);
		$id = MemberDBMethods::getID($email);
		//$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "UPDATE tbl_member SET mPassword='$password' WHERE MemberID=$id";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$Query2 = "DELETE FROM tbl_reset_pass WHERE email = mysql_real_escape_string('$email')";
		$QueryResult2 =  mysql_query($Query2)or die(mysql_error());
		
		
		
		return $id;
	}
	function GetStoryURL($StoryID)
	{
		$result = '';
		$Query = "SELECT Story_URL FROM tbl_story WHERE (StoryID  = '$StoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Story_URL'];
		}
		return $result;	
	}
	
	function InsertPrivacyLockOnComment($CommentID, $MemberIDShareWith)
	{
		$Query = "INSERT INTO tbl_comment_lock (CommentID, FriendID) VALUES  ('" . $CommentID . "', '" . $MemberIDShareWith . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function IgnoreFriendRequest($CurrentMemberID, $friendID)
	{
		$escMID = mysql_real_escape_string($CurrentMemberID);
		$escFriend = mysql_real_escape_string($friendID);
		$Query = "DELETE FROM tbl_friends WHERE MemberID_Active = $escFriend AND MemberID_Passive =$escMID";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function GetBadgeName($BadgeID)
	{
		$result = ''; 
		$Query = "SELECT Badge_Name FROM tbl_badge WHERE (BadgeID  = $BadgeID)";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Badge_Name'];
		}
		return $result;
	}
	
	function GetBadgeDescription($BadgeID)
	{
		$result = ''; 
		$Query = "SELECT Badge_Description FROM tbl_badge WHERE (BadgeID  = $BadgeID)";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Badge_Description'];
		}
		return $result;
	}
	
	function GetMyFriendsList($MemberID, $txt, $limit)
	{
		//$Query = "SELECT MemberID, mFirst_Name, mLast_Name 
		//			FROM tbl_member 
		//			WHERE (mFirst_Name LIKE '%$txt%') OR (mLast_Name LIKE '%$txt%') OR (mEmail  LIKE '%$txt%') 
		//			LIMIT 10";
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') AND ((m.mFirst_Name LIKE '%$txt%') OR (m.mLast_Name LIKE '%$txt%') OR (m.mEmail  LIKE '%$txt%'))
					LIMIT 0, $limit";
		$QueryResult = mysql_query($Query);
		return $QueryResult;
	}
	
	function UpdateStoryTags($storyID, $url)
	{
		$tags = URLKeyWordExtraction::GetTagKeyWords($url, 5);
		foreach($tags as $tag)
		{
			
			$tagID = HelpingDBMethods::GetTagID($tag);
			$Query = "SELECT COUNT(STID) AS Count FROM tbl_story_tags WHERE (StoryID  = '$storyID') AND (TagID = '$tagID')";	
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			$cnt = $row['Count'];
			if($cnt == 0)
			{
				$Query = "INSERT INTO tbl_story_tags (StoryID, TagID) VALUES  ('$storyID', '$tagID')";
				$QueryResult =  mysql_query($Query)or die(mysql_error());
			}			
		}
		
		
	}
	
	function GetStoryCategoryID($StoryID)
	{
		$result = 0;
		$Query = "SELECT CategoryID FROM tbl_story_categories WHERE (StoryID  = $StoryID)";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['CategoryID'];
		}
		return $result;
	}
	
	function UpdateStoryCategory($storyID, $url)
	{
		$category = URLKeyWordExtraction::GetCategoryKeyWords($url);
			
		$catID = HelpingDBMethods::GetCategoryID($category);
		$Query = "SELECT COUNT(SCID) AS Count FROM tbl_story_categories WHERE (StoryID  = '$storyID') AND (CategoryID = '$catID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		$cnt = $row['Count'];
		if($cnt == 0)
		{
			$Query = "INSERT INTO tbl_story_categories (StoryID, CategoryID) VALUES  ('$storyID', '$catID')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
		}
	}
	
	function UpdateStoryImage($StoryID)
	{
		$imgURL = HelpingMethods::GetFlickerImage($StoryID);
		$ImageID = 0;
		$Query = "SELECT ImageID FROM tbl_story WHERE (StoryID  = '$StoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$ImageID = $row['ImageID'];
		}
		$ImageID = HelpingDBMethods::SaveImageDataInDB($imgURL, $ImageID);
		$Query = "UPDATE tbl_story SET ImageID = '$ImageID' WHERE (StoryID  = '$StoryID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
	}
	
	function GetTagID($tag)
	{
		$result = 0;
		$tag = addslashes($tag);
		$Query = "SELECT TagID FROM tbl_tag WHERE (TagName  = '$tag')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['TagID'];
		}
		else
		{
			$Query = "INSERT INTO tbl_tag (TagName) VALUES  ('$tag')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$result = mysql_insert_id();
		}
		return $result;	
	}
	
	function GetCategoryID($category)
	{
		$result = 0;
		$Query = "SELECT CategoryID FROM tbl_category WHERE (CategoryName  = '$category')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['CategoryID'];
		}
		else
		{
			$Query = "INSERT INTO tbl_category (CategoryName) VALUES  ('$category')";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$result = mysql_insert_id();
		}
		return $result;	
	}
	
	function GetCategory($categoryID)
	{
	if ($categoryID!=0){
		$Query = "SELECT CategoryName FROM tbl_category WHERE (CategoryID  = '$categoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['CategoryName'];
		}
	} else{
		$result = "news";
	}
	return $result;
	}
	
	function GetStoryTags($StoryID)
	{
		$result = array(); 
		$Query = "SELECT tbl_tag.TagName FROM tbl_tag 
					INNER JOIN tbl_story_tags ON tbl_tag.TagID = tbl_story_tags.TagID
				  WHERE (tbl_story_tags.StoryID  = '$StoryID')";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
			$result[] = $row['TagName'];
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function GetImageTags($title){
	 $xml = file_get_contents("http://www.kahub.com/samplejson.php?title=".$title);
	 echo $title;
	 echo $xml;
	}
	
	
	function GetStorySingleComent($StoryID, $isStoryID = true)
	{
		$result = array();
		$result['c-id'] = 0;
		$result['c-text'] = '';
		$result['c-memberid'] = '';
		$result['c-a-t'] = '';		 
		$Query = "SELECT * FROM tbl_comments WHERE (StoryID  = '$StoryID') AND (Reply_To = 0) ORDER BY Date_Time DESC LIMIT 0, 1";
		if(!$isStoryID)
		{
			$Query = "SELECT * FROM tbl_comments WHERE (CommentID  = '$StoryID')";
		}	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['c-id'] = $row['CommentID'];
			$result['c-text'] = $row['Comment_Text'];
			$result['c-memberid'] = $row['MemberID'];
			$result['c-a-t'] = $row['Comment_Associated_Text'];
		}
		return $result;
	}
	
	function GetCommentCount($text_selected, $storyID)
	{
		$MemberID = $GLOBALS['user']->userID;
		$Query = "SELECT COUNT(DISTINCT c.CommentID)
				FROM tbl_comments c
				INNER JOIN tbl_friends a ON c.MemberID = a.MemberID_Active OR c.MemberID = a.MemberID_Passive
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 		
				WHERE (c.Comment_Associated_Text = '$text_selected') AND (c.StoryID = '$storyID') AND (a.MemberID_Active =  '$MemberID')
				";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$result = mysql_result($QueryResult, 0, 0);
		return $result;
	}
	
	function GetFriends($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
				FROM tbl_friends a
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
				INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
				WHERE (a.MemberID_Active =  '$MemberID')";
		//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);		
		while($row!=false)
		{
			$friendID = $row['MemberID'];
			$friendshipQuery = "SELECT * FROM tbl_friends WHERE MemberID_Active = '$MemberID'AND MemberID_Passive = '$friendID'";
			$friendResult = mysql_query($friendshipQuery) or die(mysql_error());
			$friendRow = mysql_fetch_array($friendResult);
			
			$result .= 	'<div style = "friend">
					<span><input type = "checkbox" class = "friend" value = "' . $friendRow['FriendsID'] . '" />' . $row['mFirst_Name'] . ' ' . $row['mLast_Name'] . '</span>
					</div>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	
	function GetTrust($MemberID){
		$Query = "SELECT * FROM tbl_trust WHERE FriendsID = '$MemberID'";
		$QueryResult = mysql_query($Query) or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false){
			$friendQuery = "SELECT * FROM tbl_member WHERE FriendsID = $MemberID";
			$friendResult = mysql_query($friendQuery);
			$friendRow = mysql_fetch_array($friendResult);
			while ($friendRow!=false){
				$result .= '<div style="trust">
						<span><li><input type="radio" class="trust" name="trust" value = "' . $row['TrustID'] . '" />' . $friendRow['mFirst_Name'] . ' ' . $friendRow['mLast_Name'] . '</li></span>
						</div>';
				$friendRow = mysql_fetch_array($friendResult);
			}
			$row = mysql_fetch_array($QueryResult);
		}
		return $result;
	}
	
	function mostRecentStory($MemberID){
		$Query = "SELECT DISTINCT s.StoryID, s.Story_URL, s.Story_Title
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive	AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON b.MemberID_Active = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID
						WHERE (a.MemberID_Active = '$MemberID')
						ORDER BY c.Date_Time DESC LIMIT 0, 1";	
		$QueryResult = mysql_query($Query);
		$row = mysql_fetch_array($QueryResult);
		if($row != false)
		{
			$title = $row['Story_Title'];
		} else {
			$title = "nostory";
		}
		
		return $title;
	}
	function mostRecentStoryID($MemberID){
		$Query = "SELECT DISTINCT StoryID FROM tbl_comments WHERE (MemberID = '$MemberID') ORDER BY Date_Time DESC LIMIT 0, 1";	
		$QueryResult = mysql_query($Query);
		$row = mysql_fetch_array($QueryResult);
		if($row != false)
		{
			$title = $row['StoryID'];
		} else {
			$title = "nostory";
		}
		
		return $title;
	}
	
	function GetInterestsShared($MemberID)
	{
		$result = ''; 
		$rootURL = Settings::GetRootURL();
		$Query = "SELECT m.* 
					FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active 
						INNER JOIN tbl_member m ON a.MemberID_Passive = m.MemberID
					WHERE (a.MemberID_Active =  '$MemberID') AND (m.isHub=1)
					ORDER BY a.FriendsID DESC
					LIMIT 0, 5";	
					//echo $Query;
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		while($row!=false)
		{
		    $story = HelpingDBMethods::mostRecentStoryID($row['MemberID']);
		    $storyData = HelpingDBMethods::GetStoryData($story);
			$result .= '<li class="latestSharedGetStarted"><a onClick="putInURLGetStarted(\''.urlencode($storyData['s-url']).'\')">'.$storyData['s-title'].'</a></li>';
			$row = mysql_fetch_array($QueryResult);
		}
		//echo $Query;
		return $result;
	}
	
	function mostRecentStoryAll(){
		$Query = "SELECT * FROM `tbl_story` ORDER BY `tbl_story`.`DateTime` DESC LIMIT 0, 3";
		$QueryResult = mysql_query($Query);
		$row = mysql_fetch_array($QueryResult);
		while($row!=false){
			$title = '<ul class="recents"><li>'.$row['Story_Title'].'</li></ul>';			
			$row = mysql_fetch_array($QueryResult);
		}
		return $title;
	}
	
	function mostRecentStories($MemberID){
		$Query = "SELECT DISTINCT s.StoryID
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive	AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON b.MemberID_Active = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID
						WHERE (a.MemberID_Active = '$MemberID')
						ORDER BY c.Date_Time DESC";	
		$QueryResult = mysql_query($Query);
		$row = mysql_fetch_array($QueryResult);
		if($row != false)
		{
			$id = $row['StoryID'];
			$storyArray[]=$id;
		} else {
			$id = "nostory";
		}
		
		return $storyArray;
	}
	


	
	function GetMostRecentStoryData($MemberID)
	{
		$result = array();
		$result['c-id'] = 0;
		$result['c-text'] = '';
		$result['c-memberid'] = '';
		$result['c-a-t'] = '';	
		$result['c-StoryID'] = '';		 
			 
		$Query = "SELECT * FROM tbl_comments WHERE (MemberID  = '$MemberID') AND (Reply_To = 0) ORDER BY Date_Time DESC LIMIT 0, 1";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['c-id'] = $row['CommentID'];
			$result['c-StoryID'] = $row['StoryID'];
			$result['c-text'] = $row['Comment_Text'];
			$result['c-memberid'] = $row['MemberID'];
			$result['c-a-t'] = $row['Comment_Associated_Text'];
		}
		return $result;
	}
	function GetMostRecentPromotion($storyID)
	{
		$result = array();
		$result['c-id'] = 0;
		$result['c-text'] = '';
		$result['c-memberid'] = '';
		$result['c-a-t'] = '';	
		$result['c-StoryID'] = '';		 
			 
		$Query = "SELECT date FROM tbl_story_promote WHERE (StoryID  = '$storyID') ORDER BY date DESC LIMIT 0, 1";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result=$row['date'];
		}
		return $result;
	}
	function GetCommentData($CommentID)
	{
		$result = array();
		$result['c-id'] = 0;
		$result['c-text'] = '';
		$result['c-memberid'] = '';
		$result['c-a-t'] = '';	
		$result['c-StoryID'] = '';		 
		$result['c-date'] = '';
		$result['c-reply'] = '';
			 
		$Query = "SELECT * FROM tbl_comments WHERE (CommentID  = '$CommentID')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result['c-id'] = $row['CommentID'];
			$result['c-StoryID'] = $row['StoryID'];
			$result['c-text'] = $row['Comment_Text'];
			$result['c-memberid'] = $row['MemberID'];
			$result['c-a-t'] = $row['Comment_Associated_Text'];
			$result['c-date'] = $row['Date_Time'];
			$result['c-reply'] = $row['Reply_To'];
		}
		return $result;
	}
	function GetCommentText($CommentID)
	{	 
			 
		$Query = "SELECT Comment_Text FROM tbl_comments WHERE (CommentID  = '$CommentID') LIMIT 0, 1";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['Comment_Text'];
		}
		return $result;
	}
	
	
	
	function TrustFriendOnCategories($MemberID, $friendID, $Cs)
	{
		$Categories = explode(',', $Cs);
		foreach($Categories as $category)
		{
			$category = addslashes($category);
			$cQueryResult = mysql_query("SELECT CategoryID FROM tbl_category WHERE CategoryName = '$category'");
			$crow = mysql_fetch_array($cQueryResult);
			if($crow != false)
			{
				$CID = $crow['CategoryID'];
				$is = HelpingDBMethods::isMemberTrusted($MemberID, $friendID, $CID);
				if(!$is)
				{
					HelpingDBMethods::TrustMember($MemberID, $friendID, $CID);
				}
			}
		}
	}
}
?>