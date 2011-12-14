<?php 
$vari = $_GET['ref'];				 
require_once 'AppCode/ApplicationSettings.php';
require_once 'AppCode/access.class.php';
require_once 'AppCode/MemberDBMethods.php';
$email = $_GET['e'];
$name = $_GET['n'];
$reasons = $_GET['reasons'];
if($reasons!=""){
    $class = "block";
} else {
    $class = "none";
}
$page = <<<HTML
<html>
  <!DOCTYPE html>
  <head>
	<script type="text/javascript">
	  var _kmq = _kmq || [];
	  function _kms(u){
	    setTimeout(function(){
	      var s = document.createElement('script'); var f = document.getElementsByTagName('script')[0]; s.type = 'text/javascript'; s.async = true;
	      s.src = u; f.parentNode.insertBefore(s, f);
	    }, 1);
	  }
	  _kms('//i.kissmetrics.com/i.js');_kms('//doug1izaerwt3.cloudfront.net/ef708ff382fb288b639757b4f42f078092071778.1.js');
	  _kmq.push(['record', 'Visited Site']);
	</script>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>kahub - Read news with friends. Discover news with the world.</title>
        <link href='http://fonts.googleapis.com/css?family=Droid Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css">
		<meta name="description" content="Share news as easy as Highlight, Comment, Done. Literally read news with friends. Follow your interests.">
		<meta name="keywords" content="kahub, social, news, share, friends, read news with friends, connichiwah, digg, reddit, xydo">
		<meta property="og:title" content="kahub - Read news with friends. Discover news with the world."/>
	    <meta property="og:type" content="website"/>
	    <meta property="og:url" content="http://www.kahub.com?ref=fb"/>
	    <meta property="og:image" content="http://www.kahub.com/images/kahublogosmallfb.png"/>
	    <meta property="og:site_name" content="kahub"/>
	    <meta property="fb:app_id" content="146470212065341"/>
	    <meta property="og:description" content="Share news as easy as Highlight, Comment, Done. Literally read news with friends. Follow your interests."/>
        <style type="text/css" media="screen">
        html, body{
          margin: 0;
          padding: 0;
          outline: 0;
          font-size: 100%;    
          font-family: 'Droid Sans', Helvetica, sans-serif;
          background-color: #EAEAEA;
        }
        .page{
        margin: 634px auto 0 auto;
        z-index: 2;
        position: relative;
        background-color: #F3F3F3;
        -webkit-box-shadow: 0px -3px 3px rgba(0, 0, 0, .1);
        -moz-box-shadow: 0px -3px 3px rgba(0, 0, 0, .1);
        box-shadow: 0px -3px 3px rgba(0, 0, 0, .1);
        padding-top: 10px;
        border-top: 1px solid #999; 
        border-top: 1px solid rgba(153, 153, 153, 0.42);
        padding-bottom: 100px;
        }
        .header{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/topbg.png");
          padding: 50px 0  0;
          width: 100%;
          position: fixed;
          z-index: 1;
          top: 0;
          padding-bottom: 40px;
          height: 700px;
        }
        .world{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/worldimg.png");
          width: 500px;
          height: 137px;
          margin: 0 auto;
          position: relative;
          bottom: -110;
        }
        .plane{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/planeimg.png");
          width: 311px;
          height: 300px;
          position: absolute;
          top: 0;
          left: 90;
        }
        .login{
          position: absolute;
          top: 0;
          right: 10;
        }
        .kelli{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/blackwoman.png");
          width: 60px;
          height: 57px;
          position: relative;
          float: left;
          z-index: 100;
          bottom: -150;
          left: 100;
        }
        .will{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/whiteguy.png");
          width: 100px;
          height: 80px;
          position: relative;
          float: left;
          z-index: 100;
          bottom: -150;
          left: 150;
        }
        .sean{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/middleeasternguy.png");
          width: 60px;
          height: 72px;
          position: relative;
          float: left;
          z-index: 100;
          bottom: -80;
          left: 130;
        }
        .readDiscover{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/readdiscoverbg.png");
          width: 573px;
          height: 46px;
          z-index: 200;
          margin: 0 auto;
        }
        .logo{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/kahublogosite.png");
          width: 378px;
          height: 200px;
          z-index: 200;
          margin: 0 auto;
          margin-bottom: 25px;
          margin-top: -50px;
        }
        .peopleWrap{
          margin: 0 auto;
          width: 500px;
        }
        .topWrap{
          margin: 0 auto;
          width: 600px;
          
        }
        .descrip{
          width: 573px;
          height: 48px;
          z-index: 200;
          margin: 0 auto;
          font-size: 12px;
          text-align: center;
        }
        .signup{
          height: 68px;
          width: 873px;
          margin: 0 auto;
        }
        div.readDiscover {
            font-size: 22px;
            text-align: center;
            margin-bottom: -15px;
            padding-top: 8px;
        }
        div.readDiscover {
            padding-top: 16px;
            padding-left: 3px;
        }
        
        #peopleWrap{
          display: none;
        }
        #world{
          display: none;
        }
        ul.findOut li {
            webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            background-color: #ffffff;
            padding: 30px;
            margin-bottom: 43px;
            -webkit-box-shadow: rgba(0,0,0,0.3) 0 1px 3px;
            -moz-box-shadow: rgba(0,0,0,0.3) 0 1px 3px;
            box-shadow: rgba(0,0,0,0.3) 0 1px 3px;
            border-top-color: #E5E5E5;
            border-right-color: #DBDBDB;
            border-bottom-color: #D2D2D2;
            border-left-color: #DBDBDB;
            font-size: 24px;
            color: #828282;
        }

        ul.findOut li b {
            color: #3b3b3b;
            margin-right: 10px;
        }
        div.innerPage {
            width: 900px;
            margin: 0 auto;
        }
        li#video{
          padding-left: 52px;          
        }
        ul.findOut li:hover {
            cursor: pointer;
        }
        ul.findOut li {
            -webkit-font-smoothing: antialiased;
        }
        ul.findOut li:hover {
            background: #F3F3F3 url("http://www.kahub.com/images/website/overlay.png") repeat-x;
        }

        #video:hover {
            background: #fff;
            cursor: default;
        }
        ul.sweet li {
            font-size: 14px;
            margin-bottom: 10px;
            padding: 16px;
        }

        ul.sweet li:hover {
            background-color: #ffffff;
            cursor: default;
        }
        #sweetList{
          display: none;
        }

        a.large.dblue.button {
            text-align: center;
            height: 19px;
			background-color: #43807b;
			text-decoration: none;
        }
        input{
          height: 38px;
          top: 0;
          width: 200px;
          -moz-border-radius: 5px; 
          -webkit-border-radius: 5px;
          -webkit-box-shadow: inset 1px 1px 3px #B3B3B3;
          -moz-box-shadow: inset 1px 1px 3px #B3B3B3;
          box-shadow: inset 1px 1px 3px #B3B3B3;
          border: 1px solid #54BDB4;
          font-size: 17pt;
          padding-left: 10px;
          background: #fff;
          font-family: 'Droid Sans', arial, serif;
        }

        input:focus{
          -webkit-box-shadow: 0px 0px 8px rgba(82,168,236,0.5);
          -moz-box-shadow: 0px 0px 8px rgba(82,168,236,0.5);
          box-shadow: 0px 0px 8px rgba(82,168,236,0.5);
          border: 1px solid rgba(82,168,236,0.75);
          outline: 0;
        }
        label{
          padding: 5px;
          padding-top: 10px;
          padding-left: 10px;
          color: #4D4D4D;
          font-size: 14pt;
          font-family: 'Droid Sans', arial, serif;
        }
        #signup{
          opacity: 0;
        }
        #topWrap{
          opacity: 0;
        }
        div.signup li {
            float: left;
            margin-right: 32px;
        }
        input.large.orange.button {
            margin-top: 19px;
        }
        @-webkit-keyframes orangePulse {
        from { background-color: #F45100; -webkit-box-shadow: 0 0 7px #ff9514; }
        50% { background-color: #ff5c00; -webkit-box-shadow: 0 0 15px #ff5c00; }
        to { background-color: #F45100; -webkit-box-shadow: 0 0 7px #ff9514; }
        }

        @-moz-keyframes orangePulse {
        from { background-color: #ff5c00; -webkit-box-shadow: 0 0 7px #ff9514; }
        50% { background-color: #ff5c00; -webkit-box-shadow: 0 0 15px #ff5c00; }
        to { background-color: #ff5c00; -webkit-box-shadow: 0 0 7px #ff9514; }
        }


        input.button {
          -webkit-animation-duration: 2s;
          -webkit-animation-iteration-count: infinite !important; 
          color: #fff !important;
          background-color: #ff5c00 !important;
          font: normal normal bold 20px Helvetica, Arial, sans-serif !important;
          padding: 8px 13px 9px; float: left !important; 
          margin-top: 10px !important;
          -moz-border-radius: 5px !important; 
          -webkit-border-radius: 5px !important;
          -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
          -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
          text-shadow: 0 -1px 1px rgba(0,0,0,0.25) !important;
          border-bottom: 1px solid rgba(0,0,0,0.25) !important;
		  border-top: 0;
		  border-left: 0;
		  border-right: 0;
          cursor: pointer !important;
        }

        a.button {
          -webkit-animation-duration: 2s;
          -webkit-animation-iteration-count: infinite !important; 
          color: #fff !important;
          background-color: #ff5c00 !important;
          font: normal normal bold 20px Helvetica, Arial, sans-serif !important;
          padding: 8px 13px 9px; float: left !important; 
          margin-top: 10px !important;
          -moz-border-radius: 5px !important; 
          -webkit-border-radius: 5px !important;
          -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
          -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
          text-shadow: 0 -1px 1px rgba(0,0,0,0.25) !important;
          border-bottom: 1px solid rgba(0,0,0,0.25) !important;
          cursor: pointer !important;
        }
		

        input.large.orange.button {
            text-align: center !important;
			width: 100px;
        }
		input.large.orange.button {
		    margin-top: 17px;
		}


        div.pstrength-bar {
            border-style: solid;
            border-color: #ffffff;
            border-top-width: 0;
            border-bottom-width: 0;
            border-left-width: 0;
            border-right-width: 180px;
        }                
        input.undefined {
            background: transparent;
        }

        div.pstrength-bar {
            margin-top: -36px;
            padding-bottom: 27px;
            margin-left: 2px;
        }

        div.signup {
            width: 830px;
        }
        
        #highlight{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/highlightHomeimg.png");
          background-repeat: no-repeat;
        }
        #comment{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/commentimg.png");
          background-repeat: no-repeat;
          
        }
        #done{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/doneimg.png");
          background-repeat: no-repeat;
        }
        #diffList {
            padding-bottom: 220px;
        }

        #hcd {
            width: 800px;
        }

        #hcd p {
            text-align: center;
            font-family: Georgia;
            font-style: italic;
            margin-bottom: 11px;
        }

        #highlight {
            float: left;
            margin-right: 50px;
            margin-left: 70px;
            padding-top: 187px;
            padding-left: 43px;
            padding-right: 47px;
            font-family: Georgia;
            color: #474747;
        }

        #comment {
            float: left;
            margin-right: 50px;
            padding-top: 187px;
            padding-left: 43px;
            padding-right: 38px;
            font-family: Georgia;
            color: #4d4d4d;
        }

        #done {
            float: left;
            padding-top: 186px;
            padding-left: 59px;
            padding-right: 80px;
            font-style: italic;
            font-family: Georgia;
            color: #2eab28;
        }
        #obama{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/obamahome-01.png");
          background-repeat: no-repeat;
          float: right;
          width: 200px;
          height: 199px;
        }
        #readNewsbox{
          background-image: url("http://c681693.r93.cf2.rackcdn.com/readfriendshome-01.png");
          background-repeat: no-repeat;
          float: left;
          width: 300px;
          height: 299px;
        }
        #followInterests p {
            text-align: center;
            font-family: Georgia;
            font-style: italic;
            width: 800px;
        }

        #followText {
            margin-top: 60px;
            width: 600px;
            color: #424242;
            margin-left: 79px;
            margin-bottom: -60px;
        }

        #obama {
            margin-right: 33px;
            margin-left: 61px;
        }

        #diffList:hover {
            background-color: #ffffff;
            cursor: default;
        }

        span.hubHover {
            border-style: dotted;
            border-color: #dedede;
            border-left-width: 0;
            border-bottom-width: 2px;
            border-right-width: 0;
            border-top-width: 0;
        }

        span.hubHover:hover {
            cursor: pointer;
        }

        #hcd p {
            width: 800px;
        }

        #readNews p {
            width: 800px;
            font-family: Georgia;
            font-style: italic;
            text-align: center;
            margin-bottom: 33px;
            margin-top: 57px;
        }

        #readNews p b {
            margin-right: 0;
            color: #7d7d7d;
        }

        #readText {
            padding-top: 127px;
            color: #424242;
            margin-bottom: -36px;
        }

        #readNewsbox {
            margin-right: 21px;
        }

        div.readNewsinnerText {
            margin-top: 113px;
            font-size: 16px;
            margin-left: 133px;
            width: 118px;
        }

        #readBody {
            color: #6e6e6e;
        }
        #clear {
            height: 271px;
        }

        #diffList{
          display: none;
        }
		#copy {
		    font-size: 14px;
		}

		#footerTop {
		    margin-bottom: 10px;
		}

		#footerTop a {
		    color: #5872A7;
		    text-decoration: none;
		}

		#footerDescrip {
		    font-size: 21px;
		}

		.footer {
		    width: 800px;
		    text-align: center;
		    margin-right: auto;
		    margin-left: auto;
		    color: #D3D3D3;
		    text-shadow: 0px 1px 1px #fafafa;
		    filter: dropshadow(color=#fafafa, offx=0, offy=1);
		    margin-top: 0;
		    margin-bottom: 0;
		    margin-bottom: -62px;
		}
		div.descrip {
		    -webkit-font-smoothing: antialiased;
		}

		div.readDiscover {
		    -webkit-font-smoothing: antialiased;
		}
		div.descrip {
		    font-size: 11pt;
		    width: 680px;
		    margin-left: -35px;
		}
		
		#userName{
		    display: none;
		}
		
		#emailAddress{
		    display: none;
		}
		.well {
          background-color: #f5f5f5;
          margin-bottom: 20px;
          padding: 19px;
          min-height: 20px;
          border: 1px solid #eee;
          border: 1px solid rgba(0, 0, 0, 0.05);
          -webkit-border-radius: 4px;
          -moz-border-radius: 4px;
          border-radius: 4px;
          -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
          -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        }
        .modal-backdrop {
          background-color: rgba(0, 0, 0, 0.5);
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          z-index: 10;
          width: 100%;
          height: 100%;
        }
        .modal {
          position: fixed;
          top: 50%;
          left: 50%;
          z-index: 2000;
          width: 560px;
          margin: -280px 0 0 -250px;
          background-color: #ffffff;
          border: 1px solid #999;
          border: 1px solid rgba(0, 0, 0, 0.3);
          *border: 1px solid #999;
          /* IE6-7 */

          -webkit-border-radius: 6px;
          -moz-border-radius: 6px;
          border-radius: 6px;
          -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
          -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
          box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
          -webkit-background-clip: padding-box;
          -moz-background-clip: padding-box;
          background-clip: padding-box;
        }
        .modal .modal-header {
          border-bottom: 1px solid #eee;
          padding: 5px 20px;
        }
        .modal .modal-header .close {
          position: absolute;
          right: 10px;
          top: 10px;
          color: #999;
          line-height: 10px;
          font-size: 18px;
        }
        .modal .modal-body {
          padding: 20px;
        }
        .modal .modal-footer {
          background-color: #f5f5f5;
          padding: 14px 20px 15px;
          border-top: 1px solid #ddd;
          -webkit-border-radius: 0 0 6px 6px;
          -moz-border-radius: 0 0 6px 6px;
          border-radius: 0 0 6px 6px;
          -webkit-box-shadow: inset 0 1px 0 #ffffff;
          -moz-box-shadow: inset 0 1px 0 #ffffff;
          box-shadow: inset 0 1px 0 #ffffff;
          zoom: 1;
        }
        .modal .modal-footer:before, .modal .modal-footer:after {
          display: table;
          content: "";
        }
        .modal .modal-footer:after {
          clear: both;
        }
        .modal .modal-footer .btn {
          float: right;
          margin-left: 10px;
        }
        div.modal-header h3 {
            font-weight: bold;
        }

        a.close {
            text-decoration: none;
        }

        div.modal-header {
            background-color: #FAE5E3;
            color: #9D261D;
        }
        .btn.primary, .btn.danger {
          color: #fff;
        }
        .btn.primary:hover, .btn.danger:hover {
          color: #fff;
        }
        .btn.primary {
          background-color: #0064cd;
          background-repeat: repeat-x;
          background-image: -khtml-gradient(linear, left top, left bottom, from(#049cdb), to(#0064cd));
          background-image: -moz-linear-gradient(#049cdb, #0064cd);
          background-image: -ms-linear-gradient(#049cdb, #0064cd);
          background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #049cdb), color-stop(100%, #0064cd));
          background-image: -webkit-linear-gradient(#049cdb, #0064cd);
          background-image: -o-linear-gradient(#049cdb, #0064cd);
          background-image: linear-gradient(#049cdb, #0064cd);
          text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
          border-color: #0064cd #0064cd #003f81;
          border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        }
        .btn.large {
          font-size: 16px;
          line-height: 28px;
          -webkit-border-radius: 6px;
          -moz-border-radius: 6px;
          border-radius: 6px;
        }
        .btn.small {
          padding-right: 9px;
          padding-left: 9px;
          font-size: 11px;
        }

        a.btn.primary.large {
            padding-left: 10px;
            padding-right: 10px;
        }
        input.large.orange.button {
            margin-top: 20px !important;
        }

        
      </style>
  </head>
  <body onLoad="$('#video').hide();">
     <span>
         <div class="modal" id="modalWindow" style="position: relative; top: 100px; left: auto; margin: 0 auto; z-index: 12; display: {$class}">
                   <div class="modal-header">
                     <h3>Sorry about that!</h3>
                     <a class="close" onClick="$('#modalWindow').hide();">&times;</a>
                   </div>
                   <div class="modal-body">
                     <p>Your sign up could not be completed becasue {$reasons}</p>
                   </div>
                   <div class="modal-footer">
                     <a class="btn primary large" onClick="$('#modalWindow').hide();">Okay</a>
                   </div>
            </div>
    <div class="header"><div class="plane"></div><div class="login"><a class="large dblue button" href="/login.php">Login</a></div><div class="topWrap" id="topWrap"><div class="logo"></div><div class="readDiscover">Read <b>news</b> with friends. Discover <b>news</b> with the world.</div><div class="descrip">kahub is a <b>news source</b> which allows you and <b>your friends</b> to have interesting, meaningful discussions about the topics that interest you most. <b>It's what's new and hot among your friends.</b></div></div><div class="signup" id="signup"><form action="../l/verifier.php" method="post"><li>
			      <label for="name">Full name</label><br>
			      <input type="text" name="name" id="name" value="{$name}" onBlur="validateName($(this).val())">
			      <input type="text" name="userName" id="userName">
        		

    		</li>
    		<li>
      			<label for="email">Email</label><br>
      			<input type="text" name="email" id="email" value="{$email}">
      			<input type="text" name="emailAddress" id="emailAddress">
    		</li>
   		<li>
        			<label for="password">Password</label><br>
        			<input type="password" name="password" id="password">
      		</li>
		 <li>
          		<input type="submit" name="submit" class="large orange button" value="Sign Up">
        	</li></form></div><div class="peopleWrap" id="peopleWrap"><div class="kelli" id="kelli"></div><div class="will" id="will"></div><div class="sean" id="sean"></div></div><div class="world" id="world"></div></div>
    <div class="page">
    <div class="innerPage">
    <ul class="findOut">
    <li onClick="$('#video').toggle();"><b>What is kahub?</b> Watch a video.</li>
    <li id="video"><iframe src="http://player.vimeo.com/video/26961578?byline=0&amp;color=ff9933&amp;autoplay=0" width="800" height="450" frameborder="0"></iframe></li>
    <li onClick="$('#diffList').toggle();"><b>How's kahub different?</b> Here's a few ways.</li>
    <li id='diffList'><div id="different">
      <div id="hcd"><p>&mdash;Share as easy as&mdash;</p>
        <div id="highlight" onMouseOver="$(this).effect('bounce', { times:2, distance: 15 }, 400);">Highlight.</div><div id="comment"  onMouseOver="$(this).effect('bounce', { times:2, distance: 30 }, 400);">Comment.</div><div id="done"  onMouseOver="$(this).effect('bounce', { times:2, distance: 55 }, 400);">Done!</div>
      </div>
      <div id="clear"></div>
      <div id="readNews" onMouseOver="$('#readBody').typewriter();"><p>&mdash;Read news with friends, <b>literally.</b>&mdash;</p>
      <div id="readNewsbox"><div class="readNewsinnerText"><b>Your friend</b><span id="readBody"> Oy vey! Dios Mio!</span></div></div><div id="readText">Read your friends comments on any story, right where they left 'em.</div>
      </div>
      <div id="clear"></div>
      <div id="followInterests"><p>&mdash;Follow your interests&mdash;</p>
      <div id="obama"></div><div id="followText">Follow <span class="hubHover" id="topics" onMouseOver="switchImg(1);">topics</span>, <span class="hubHover" id="celebs"  onMouseOver="switchImg(2);">celebrities</span>, and <span class="hubHover" id="icons"  onMouseOver="switchImg(3);">icons</span> to get the latest updates about the stuff you love.</div>
      </div>
    </div>
    </li>
    <li onClick="$('#sweetList').toggle();"><b>Why's kahub sweet?</b> Here's 12 reasons.</li>
    <ul class="sweet" id="sweetList">
      <li><b>Footprints</b> <br> Footprints allows you to share news with friends as easy as Highlight, Comment, Done. It lets you comment directly on a story. Highlight some text, leave your comment, and send it to a friend, all of your friends, or even the whole world. It is that simple!</li>
      <li><b>Read news with friends, literally.</b><br> With footprints, for the first time ever, you can literally read news with friends. If you come across a story that a friend has footprinted on, you can read and reply to their comments right where they left 'em</li>
        <li><b>We play nice.</b><br> kahub isn't just <i>another</i> thing to update. We've integrated Twitter, Facebook, and Tumblr so you can update your friends wherever they are. Even if they aren't on kahub...yet.</li>
      <li><b>Topic Hubs</b><br> Ever wonder what's going on about a topic? Just search for it in kahub and we'll give you what the community thinks are the most important stories on that topic, along with a little description.</li>
      <li><b>Personality Hubs</b><br> Personality hubs let you into the world of your idols, icons, and heros. If they're on kahub, you can see what kind of stuff they've been looking at, along with what they think about it. You can even start chit-chatting with them about the days news.</li>
      <li><b>Share with the world!</b><br> You don't have to be a celebrity to get a following on kahub. In kahub, everyone gets a public hub where they can share stuff to the world. Who knows, you could be the next Robert Scoble!</li>
      <li><b>anyShare</b><br> anyShare gets rid of blinking, annoying ads, popups, and crappy designs so you can focus on what you're doing, reading news with friends. And the best part? It's on every story on kahub.</li>
      <li><b>Friends don't want to join? That's cool.</b><br> Stories on kahub are fully viewable, even if you don't have an account.</li>
      <li><b>On the go? So are we.</b><br> We've linked up with Instapaper, Pinboard, and Read it Later so wherever you go, however you like to read news, your friends can be there with you.</li>
      <li><b>We <3 your privacy.</b><br> Manage your privacy with one click. Every time.</li>
      <li><b>Secure.</b><br> kahub uses the latest SHA2 encryption, so you know your data's secure.</li>
        
      </ul>
    </ul>
    </div>
	<div class="footer">
		<div id="footerTop"><a href="http://kahub.spreadshirt.com">Shop</a> &#183; <a href="http://blog.kahub.com">Blog</a> &#183; <a href="http://www.twitter.com/kahubapp" target="_blank">Twitter</a> &#183; <a href="https://www.facebook.com/pages/Kahub/212752502077574" target="_blank">Facebook</a> &#183; <a href="/privacy">Privacy</a> &#183; <a href="/terms">Terms</a></div>
		<div id="footerDescrip">Read <b>news</b> with friends. Discover <b>news</b> with the world.</div>
		<div id="copy">&copy; 2011 ipsumedia limited</div>
	</div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/jQuery.dPassword.js"></script>
	  <script type="text/javascript" src="../js/jquery.pstrength-min.1.2.js"></script>
	  <script src="../jquery.infieldlabel.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="//c563784.r84.cf2.rackcdn.com/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
    <script src="http://c563784.r84.cf2.rackcdn.com/jquery.text-effects1.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">
    function switchImg(type){
      if(type==1){
        $('#obama').css("background-image", "url(http://c681693.r93.cf2.rackcdn.com/debthome-01.png)"); 
      }
      if(type==2){
        $('#obama').css("background-image", "url(http://c681693.r93.cf2.rackcdn.com/biebs-home.png)"); 
      }
      if(type==3){
         $('#obama').css("background-image", "url(http://c681693.r93.cf2.rackcdn.com/obamahome-01.png)"); 
      }
    }
    $(function(){ $('label').inFieldLabels(); });
    $('#topWrap').fadeTo('slow', 0);
    $('#signup').fadeTo('slow', 0);
    $('#signup').fadeTo('slow', 1, function(){
      $('#name').focus();
    });
    $('#topWrap').fadeTo('slow', 1);
      $(window).load(function(){
            $('#world').fadeIn(700);
            $('#peopleWrap').fadeIn(400, function(){
                setTimeout(function(){ 
                    $("#kelli").effect("bounce", { times:3, distance: 20 }, 400);
                  }, 200 );
                setTimeout(function(){ 
                    $("#sean").effect("bounce", { times:3, distance: 15 }, 400);
                  }, 200 );
                setTimeout(function(){ 
                    $("#will").effect("bounce", { times:3, distance: 40 }, 500);
                  }, 200 );
            });


          

        });
      $('#password').dPassword();
      $(function() {
      $('#password_password').pstrength();
      });
	function validateName(name){
		var nameGroup = name.split(' ');
		if(name.length==0){
			return;
		}
		if(nameGroup[0].length<3){
			alert("Please use your full name, not just initials");
		}
		if (nameGroup[1]==undefined){
			alert("Please use your full name, not just initials");
		}
		if (nameGroup[1].length<1){
			alert("Please use your full name, not just initials");
		}
	}
    </script>
    </span>
  </body>
  <script type="text/javascript">var _kiq = _kiq || [];</script>
  <script type="text/javascript" src="//s3.amazonaws.com/ki.js/23097/4Ah.js" async="true"></script>
    
</html>
HTML;
$user = new flexibleAccess();
if($user->is_loaded())
{
	header('Location:' . Settings::GetRootURL() . 'l/');	
}
else
{
    echo $page;
}
?>
