<?php
require_once 'ApplicationSettings.php';
require_once 'HelpingMethods.php';
class MemberDBMethods
{	
	function isUserNameAvailable($username)
	{
		$result = false;
		$Query = "SELECT MemberID FROM tbl_member WHERE mUserName = '$username'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = false;
		}
		else
		{
			$result = true;
		}
		return $result;
	}
	
	function isEmailAvailable($email)
	{
		$result = false;
		$Query = "SELECT MemberID FROM tbl_member WHERE mEmail = '$email'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = 1;
		}
		else
		{
			$result = 0;
		}
		return $result;
	}
	function checkHandle($handle)
	{
		$result = false;
		$Query = "SELECT MemberID FROM tbl_person_hub WHERE handle = '$handle'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = 1;
		}
		else
		{
			$result = 0;
		}
		$vowels = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", " ", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "'", "+", "{", "}", "|", ";", ":", "<", ">", ",", ".", "?", "/", "`", "~");
        $handle = str_replace($vowels, '', $handle);
		$handleArray = split(" ", $handle);
		$spamWordsArray= explode(",", "ahole,anus,ash0le,ash0les,asholes,ass,Ass Monkey,bassterds,bastard,bastards,bastardz,basterds,basterdz,Biatch,bitch,bitches,Blow Job,boffing,butthole,Carpet Muncher,cawk,cawks,Clit,cnts,cntz,cock,cockhead,cock-head,cocks,CockSucker,cock-sucker,crap,cum,cunt,cunts,cuntz,dick,dild0,dild0s,dildo,dildos,dilld0,dilld0s,dominatricks,dominatrics,dominatrix,dyke,enema,f u c k,f u c k e r,fag,fag1t,faget,fagg1t,faggit,faggot,fagit,fags,fagz,faig,faigs,fart,flipping the bird,fuck,fucker,fuckin,fucking,fucks,Fudge Packer,fuk,Fukah,Fuken,fuker,Fukin,Fukk,Fukkah,Fukken,Fukker,Fukkin,g00k,gay,gayboy,gaygirl,gays,gayz,God-damned,h00r,h0ar,h0re,hells,hoar,hoor,hoore,jackoff,jap,japs,jerk-off,jisim,jiss,jizm,jizz,knobz,kunt,kunts,kuntz,Lesbian,Lezzian,Lipshits,Lipshitz,massterbait,masstrbait,masstrbate,masterbaiter,masterbate,masterbates,Motha Fucker,Motha Fuker,Motha Fukkah,Motha Fukker,Mother Fucker,Mother Fukah,Mother Fuker,Mother Fukkah,Mother Fukker,mother-fucker,Mutha Fucker,Mutha Fukah,Mutha Fuker,Mutha Fukkah,Mutha Fukker,n1gr,nastt,nigger,nigur,niiger,niigr,orafis,orgasim,orgasm,orgasum,oriface,orifice,orifiss,packi,packie,packy,paki,pakie,paky,pecker,peeenus,peeenusss,peenus,peinus,pen1s,penas,penis,penis-breath,penus,penuus,Phuc,Phuck,Phuk,Phuker,Phukker,polac,polack,polak,Poonani,pr1c,pr1ck,pr1k,pusse,pussee,pussy,puuke,puuker,queer,queers,queerz,qweers,qweerz,qweir,recktum,rectum,retard,sadist,scank,schlong,screwing,semen,sex,sexy,Sh!t,sh1t,sh1ter,sh1ts,sh1tter,sh1tz,shit,shits,shitter,Shitty,Shity,shitz,Shyt,Shyte,Shytty,Shyty,skanck,skank,skankee,skankey,skanks,Skanky,slut,sluts,Slutty,slutz,son-of-a-bitch,tit,turd,va1jina,vag1na,vagiina,vagina,vaj1na,vajina,vullva,vulva,w0p,wh00r,wh0re,whore,xrated,xxx,b!+ch,bitch,blowjob,clit,arschloch,fuck,shit,ass,asshole,b!tch,b17ch,b1tch,bastard,bi+ch,boiolas,buceta,c0ck,cawk,chink,cipa,clits,cock,cum,cunt,dildo,dirsa,ejakulate,fatass,fcuk,fuk,fux0r,hoer,hore,jism,kawk,l3itch,l3i+ch,lesbian,masturbate,masterbat,masterbat3,mofo,nigga,nigger,nutsack,phuck,scrotum,sh!t,shi+,sh!+,slut,smut,teets,tits,boobs,b00bs,teez,testical,testicle,titt,w00se,jackoff,wank,whoar,whore,dyke,fuck,shit,@$$,amcik,andskota,arse,assrammer,ayir,bi7ch,bitch,bollock,breasts,butt-pirate,cabron,cazzo,chraa,chuj,Cock,cunt,d4mn,daygo,dego,dick,dike,dupa,dziwka,ejackulate,Ekrem,Ekto,enculer,faen,fag,fanculo,fanny,feces,feg,Felcher,ficken,fitt,Flikker,foreskin,Fotze,Fu(,fuk,futkretzn,gay,gook,guiena,h0r,h4x0r,hell,helvete,hoer,honkey,Huevon,hui,injun,jizz,kanker,kike,klootzak,kraut,knulle,kuk,kuksuger,Kurac,kurwa,kusi,kyrpa,lesbo,mamhoon,masturbat,merd,mibun,monkleigh,mouliewop,muie,mulkku,muschi,nazis,nepesaurio,nigger,orospu,paska,perse,picka,pierdol,pillu,pimmel,piss,pizda,poontsee,poop,porn,p0rn,pr0n,pula,pule,puta,puto,qahbeh,queef,rautenberg,schaffer,scheiss,schlampe,schmuck,screw,sh!t,sharmuta,sharmute,shipal,shiz,skrib");
    	foreach($handleArray as $item){
    		if(in_array($item, $spamWordsArray)){
    			$result= 1;
    		}
    	}
    	if($result==0){
    	    $MemberID = $GLOBALS['user']->userID;
    	    $memcache = new Memcache;
        	$memcache->connect('localhost', 11211) or die ("Could not connect");
        	$key = "handleTemp";
        	$keyHandle2 = md5($MemberID);
        	$keyHandle = $key.$keyHandle2;
        	$resultCache = $memcache->set($keyHandle, $handle, false, 60);
    	}
		return $result;
	}
	function saveHandle($handle){
		$MemberID = $GLOBALS['user']->userID;
		$nHandle= strtolower($handle);
		$illegals = array(" ", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "'", "+", "{", "}", "|", ";", ":", "<", ">", ",", ".", "?", "/", "`", "~");
		$nHandle = str_replace($illegals, '', $nHandle);
		$hubID = MemberDBMethods::AddPersonalityHub($nHandle, "NULL", "NULL", "NULL", "NULL", "NULL");
		$hub = MemberDBMethods::AddPersonHub($nHandle, $MemberID, $hubID);
		return 1;
	}
	
	function AddMember($fn, $ln, $email, $password, $DOB, $sex)
	{
		$password = md5($password);
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_member (mFirst_Name, mLast_Name, mEmail, mPassword, mDOB, mSex) 
				VALUES ('" . $fn . "', '" . $ln . "', '" . $email . "', '" . $password . "', '" . $DOB . "', '" . $sex . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}

	function AddPersonHub($handle, $userID, $hubID)
	{
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_person_hub (MemberID, hubMemberID, handle) 
				VALUES (" . $userID . ", " . $hubID . ", '" . $handle . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function loginUser($MemberID)
	{
		$ip = $ip=$_SERVER['REMOTE_ADDR'];
		$Query = "INSERT INTO tbl_login (MemberID, IP) 
				VALUES (" . $MemberID . ", '" . $ip . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function AddMemberHub($fn, $ln, $email, $password, $DOB, $sex)
	{
		$password = md5($password);
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_member (mFirst_Name, mLast_Name, mEmail, mPassword, mDOB, isHub) 
				VALUES ('" . $fn . "', '" . $ln . "', '" . $email . "', '" . $password . "', '" . $DOB . "', '1')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function AddPersonalityHub($fn, $ln, $email, $password, $DOB, $sex)
	{
		$password = md5($password);
		$DateTime = gmdate("Y-m-d H-i-s");//date('Y-m-d H-i-s')
		$Query = "INSERT INTO tbl_member (mFirst_Name, mLast_Name, mEmail, mPassword, mDOB, isHub) 
				VALUES ('" . $fn . "', '" . $ln . "', '" . $email . "', '" . $password . "', '" . $DOB . "', '2')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	function addHub($hubName, $MemberID, $user)
	{
		$Query = "INSERT INTO tbl_hub (MemberID, MemberCreated, keyword) 
				VALUES ('" . $MemberID . "', '" . $user . "', '" . $hubName . "')";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return mysql_insert_id();
	}
	
	function GetUserName($memberID)
	{
		$isHub = MemberDBMethods::isHub($memberID);
		if($isHub!=2){
			$result = "";
			$Query = "SELECT mFirst_Name, mLast_Name FROM tbl_member WHERE MemberID = '$memberID'";	
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$result = $row['mFirst_Name'] . " " . $row['mLast_Name'];
			}
			else
			{
				$result = "";
			}
		} else{
			$hubData = HelpingDBMethods::GetHubInfoFromID($memberID);
			$memberID = $hubData['h-memberID'];
			$result = "";
			$Query = "SELECT mFirst_Name, mLast_Name FROM tbl_member WHERE MemberID = '$memberID'";	
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			if($row!=false)
			{
				$result = $row['mFirst_Name'] . " " . $row['mLast_Name'];
			}
			else
			{
				$result = $memberID;
			}
		}

		return $result;
	}
	function GetLastName($memberID)
	{
		$result = "";
		$Query = "SELECT mLast_Name FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['mLast_Name'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}
	function GetEmail($memberID)
	{
		$result = "";
		$Query = "SELECT mEmail FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['mEmail'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}
	function getID($email)
	{
		$result = "";
		$Query = "SELECT MemberID FROM tbl_member WHERE mEmail = '$email'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['MemberID'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}
	function getHubName($hubID)
	{
		$Query = "SELECT keyword FROM tbl_hub WHERE MemberID = '$hubID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['keyword'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}
	function GetFirstname($memberID)
	{
		$result = "";
		$Query = "SELECT mFirst_Name FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['mFirst_Name'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}
	
	function isHub($memberID)
	{
		$result = "";
		$Query = "SELECT isHub FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['isHub'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}
	
	function GetGender($memberID)
	{
		$result = "";
		$Query = "SELECT mSex FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['mSex'];
		}
		else
		{
			$result = "NULL";
		}
		return $result;
	}
	
	
	
	function GetUserEmail($memberID)
	{
		$result = "";
		$Query = "SELECT mEmail FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['mEmail'];
		}
		else
		{
			$result = "";
		}
		return $result;
	}
	
	function GetMemberIDByUserName($un)
	{
		$result = 0;
		$Query = "SELECT MemberID FROM tbl_member WHERE mEmail = '$un'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['MemberID'];
		}
		return $result;
	}
	
	function GetUserPassword($userID)
	{
		$result = "";
		$Query = "SELECT mPassword FROM tbl_member WHERE MemberID = '$userID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$result = $row['mPassword'];
		}
		return $result;
	}
	
	function UpdateMemberImage($userID, $ImageID)
	{
		$Query = "UPDATE tbl_member	SET ImageID = $ImageID	WHERE MemberID=$userID";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$hubData = HelpingDBMethods::GetHubInfoFromMemberID($userID);
		if($hubData['h-hubID']!=""){
		    $imageID = HelpingDBMethods::GetMemberImageID($userID);
    		MemberDBMethods::UpdateMemberImage($hubData['h-hubID'], $imageID);
		}
		return;
	}
	function UpdateMemberBG($userID, $ImageID)
	{
		$Query = "UPDATE tbl_person_hub	SET background = $ImageID	WHERE MemberID=$userID";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		return;
	}
	
	function isExistMemberByID($memberID)
	{
		$result = false;
		$Query = "SELECT COUNT(MemberID) FROM tbl_member WHERE MemberID = '$memberID'";	
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$row = mysql_fetch_array($QueryResult);
		if($row!=false)
		{
			$cnt = $row['COUNT(MemberID)'];
			if($cnt > 0)
			{
				$result = true;
			}
			else
			{
				$result = false;	
			}
		}
		else
		{
			$result = false;
		}
		return $result;
	}
}

?>