<?php
$fakeEmail = $_POST['emailAddress'];
$fakeName = $_POST['userName'];
if($fakeName!=""||$fakeEmail!=""){
    header('Location:http://www.kahub.com/welcomehome.html');
}
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';
require_once '../AppCode/HelpingDBMethods.php';
require_once '../AppCode/MemberDBMethods.php';
require_once '../AppCode/MasterPageScript.php';
require_once '../AppCode/SideBarScript.php';
	
	$LiteralMessage = "";
	$LiteralContent = "";
	$LiteralSideBarContent = '';
	$LiteralHeader = MasterPage::GetHeader();
	

	$email = str_replace(' ', '', $_POST['email']);
	$fullName = $_POST['name'];
	$password = $_POST['password'];
	$nameArray = split(" ", $fullName);
	$no = 0;
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
	    $yes = 1;
	} else {
	    $no = "you entered an invalid email";
	    $noCheck = 1;
	}
	if($email==""){
	    $no = "you did not enter a email";
	    $noCheck = 1;
	}
	$emailPass = MemberDBMethods::isEmailAvailable($email);
    if($emailPass!=0){
        $no = "someone already signed up with that email";
        $noCheck = 1;
    }
	if($fullName==""){
	    $no = "you need to enter your name";
	    $noCheck = 1;
	}
	if($password==""){
	    $no = "you need to enter a password";
	    $noCheck = 1;
	}
	if($nameArray[1]==""){
	    $no = "you need to enter your full name, not just initials";
	    $noCheck = 1;
	}
	$spamWordsArray= explode(",", "ahole,anus,ash0le,ash0les,asholes,ass,Ass Monkey,bassterds,bastard,bastards,bastardz,basterds,basterdz,Biatch,bitch,bitches,Blow Job,boffing,butthole,Carpet Muncher,cawk,cawks,Clit,cnts,cntz,cock,cockhead,cock-head,cocks,CockSucker,cock-sucker,crap,cum,cunt,cunts,cuntz,dick,dild0,dild0s,dildo,dildos,dilld0,dilld0s,dominatricks,dominatrics,dominatrix,dyke,enema,f u c k,f u c k e r,fag,fag1t,faget,fagg1t,faggit,faggot,fagit,fags,fagz,faig,faigs,fart,flipping the bird,fuck,fucker,fuckin,fucking,fucks,Fudge Packer,fuk,Fukah,Fuken,fuker,Fukin,Fukk,Fukkah,Fukken,Fukker,Fukkin,g00k,gay,gayboy,gaygirl,gays,gayz,God-damned,h00r,h0ar,h0re,hells,hoar,hoor,hoore,jackoff,jap,japs,jerk-off,jisim,jiss,jizm,jizz,knobz,kunt,kunts,kuntz,Lesbian,Lezzian,Lipshits,Lipshitz,massterbait,masstrbait,masstrbate,masterbaiter,masterbate,masterbates,Motha Fucker,Motha Fuker,Motha Fukkah,Motha Fukker,Mother Fucker,Mother Fukah,Mother Fuker,Mother Fukkah,Mother Fukker,mother-fucker,Mutha Fucker,Mutha Fukah,Mutha Fuker,Mutha Fukkah,Mutha Fukker,n1gr,nastt,nigger,nigur,niiger,niigr,orafis,orgasim,orgasm,orgasum,oriface,orifice,orifiss,packi,packie,packy,paki,pakie,paky,pecker,peeenus,peeenusss,peenus,peinus,pen1s,penas,penis,penis-breath,penus,penuus,Phuc,Phuck,Phuk,Phuker,Phukker,polac,polack,polak,Poonani,pr1c,pr1ck,pr1k,pusse,pussee,pussy,puuke,puuker,queer,queers,queerz,qweers,qweerz,qweir,recktum,rectum,retard,sadist,scank,schlong,screwing,semen,sex,sexy,Sh!t,sh1t,sh1ter,sh1ts,sh1tter,sh1tz,shit,shits,shitter,Shitty,Shity,shitz,Shyt,Shyte,Shytty,Shyty,skanck,skank,skankee,skankey,skanks,Skanky,slut,sluts,Slutty,slutz,son-of-a-bitch,tit,turd,va1jina,vag1na,vagiina,vagina,vaj1na,vajina,vullva,vulva,w0p,wh00r,wh0re,whore,xrated,xxx,b!+ch,bitch,blowjob,clit,arschloch,fuck,shit,ass,asshole,b!tch,b17ch,b1tch,bastard,bi+ch,boiolas,buceta,c0ck,cawk,chink,cipa,clits,cock,cum,cunt,dildo,dirsa,ejakulate,fatass,fcuk,fuk,fux0r,hoer,hore,jism,kawk,l3itch,l3i+ch,lesbian,masturbate,masterbat,masterbat3,mofo,nigga,nigger,nutsack,phuck,scrotum,sh!t,shi+,sh!+,slut,smut,teets,tits,boobs,b00bs,teez,testical,testicle,titt,w00se,jackoff,wank,whoar,whore,dyke,fuck,shit,@$$,amcik,andskota,arse,assrammer,ayir,bi7ch,bitch,bollock,breasts,butt-pirate,cabron,cazzo,chraa,chuj,Cock,cunt,d4mn,daygo,dego,dick,dike,dupa,dziwka,ejackulate,Ekrem,Ekto,enculer,faen,fag,fanculo,fanny,feces,feg,Felcher,ficken,fitt,Flikker,foreskin,Fotze,Fu(,fuk,futkretzn,gay,gook,guiena,h0r,h4x0r,hell,helvete,hoer,honkey,Huevon,hui,injun,jizz,kanker,kike,klootzak,kraut,knulle,kuk,kuksuger,Kurac,kurwa,kusi,kyrpa,lesbo,mamhoon,masturbat,merd,mibun,monkleigh,mouliewop,muie,mulkku,muschi,nazis,nepesaurio,nigger,orospu,paska,perse,picka,pierdol,pillu,pimmel,piss,pizda,poontsee,poop,porn,p0rn,pr0n,pula,pule,puta,puto,qahbeh,queef,rautenberg,schaffer,scheiss,schlampe,schmuck,screw,sh!t,sharmuta,sharmute,shipal,shiz,skrib");
	
	foreach($nameArray as $item){
		if(in_array($item, $spamWordsArray)){
			$no= "you need to enter your real name.";
			$noCheck = 1;
		}
	}
	
	
	if($noCheck!=1){
		if(MemberDBMethods::isEmailAvailable($email)==0&&$no==0){
		    $lfirstName = substr(strtolower($nameArray[0]), 1);
		    $f = $nameArray[0];
		    $sfirstName = strtoupper($f[0]);
		    $firstName = $sfirstName.$lfirstName;
		    $llastName = substr($nameArray[1], 1);
		    $l = $nameArray[1];
		    $slastName = strtoupper($l[0]);
		    $lastName = $slastName.$llastName;
			MemberDBMethods::AddMember($firstName, $lastName, $email, $password, 0, 0);
			$GLOBALS['user']->login($email,$password, true);
			$MemberID = $GLOBALS['user']->userID;
			MemberDBMethods::loginUser($MemberID);
			header('Location:http://www.kahub.com/l/getstarted.php');
		} else {
		    header('Location:http://www.kahub.com?reasons='.$no.'&e='.$email.'&n='.$fullName);
		}
	} else {
	    header('Location:http://www.kahub.com?reasons='.$no.'&e='.$email.'&n='.$fullName);
	}
?>