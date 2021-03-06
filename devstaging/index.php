<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';

$user = new flexibleAccess();
if(!$user->is_loaded())
{
    header('Location:' . Settings::GetRootURL() . 'login.php'); 
}
else
{
    require_once '../AppCode/MasterPageScript.php';
    require_once '../AppCode/SideBarScript.php';
    require_once '../AppCode/StoryRanking.php';
    require_once '../AppCode/URLKeyWordExtraction/URLKeyWordExtraction.php';
    $LiteralMessage = "";
    $LiteralContent = "";
    $LiteralSideBarContent = '';
    $LiteralHeader = MasterPage::GetHeader();
    Page::Page_Load();
    $uid = $GLOBALS['user']->userID;    


    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    echo '<html xmlns="http://www.w3.org/1999/xhtml">';
    echo '  <head>';
    echo '      <title>kahub | Home</title>';
    echo        MasterPage::GetHeadScript();
    echo '      <link rel="alternate" type="application/rss+xml" title="Your Latest Stories Feed" href="http://www.kahub.com/l/rss.php?user='.$uid.'" /><script type="text/javascript" src="../js/jquery.idle-timer.js"></script> <script type="text/javascript"> _kmq.push([\'record\', \'ViewedLatestStories\']);</script> <script type=\'text/javascript\' src=\'../js/parseURL.js\'></script><script type=\'text/javascript\' src=\'../js/jquery.tinymce.js\'></script>
                
            
                
                <script type = "text/javascript">
                    $myjquery(document).ready(function(){
                        $myjquery("#story-no-1").click();
                        $myjquery(window).scroll(function() {
                            //var bodyHeight = $myjquery("body").height();
                            var windowHeight = $myjquery(window).height();
                            var windowOffset = window.pageYOffset;
                            if(windowOffset + windowHeight + 600 > $myjquery(".more").position().top)
                            {
                                //alert($myjquery(".more").position().top);
                                $myjquery(".more").click();
                            }
                            
                        });
                        
                    });
                    function externalLinks()
                    {
                      if (!document.getElementsByTagName) return;
                      var anchors = document.getElementsByTagName("a");
                      for (var i=0; i<anchors.length; i++)
                      {
                          var anchor = anchors[i];
                          if(anchor.getAttribute("href"))
                            anchor.target = "_blank";
                      }
                    }
                    
                    
                    function timeRefresh(){
                        javascript:location.reload(true);
                    }
                    
            
                    
                        (function($){

                            var timeout = 300000;

                            $(document).bind("idle.idleTimer", function(){
                                timeRefresh();
                                console.log("refreshStart");
                            });

                            $(document).bind("active.idleTimer", function(){
                                console.log("refreshClear");
                            });

                            $.idleTimer(timeout);

                            // correct the page


                        })(jQuery);
                    function changeIntrests(type){
                        if (type==1){
                            $myjquery(\'ul#latest-stories li\').each(function() {
                                if(!$myjquery(this).hasClass("Later")) {
                                    $myjquery(this).fadeOut(\'normal\').addClass(\'hidden\');
                                } else {
                                    $myjquery(this).fadeIn(\'slow\').removeClass(\'hidden\');
                                }
                        });
                        document.getElementById("interesting").style.color="#F15A24";
                        document.getElementById("latest").style.color="#3D3D3D";
                        
                        } else {
                                $myjquery(\'ul#latest-stories li\').each(function() {
                                    if(!$myjquery(this).hasClass("hidden")) {
                                        $myjquery(this).fadeIn(\'normal\').removeClass(\'hidden\');
                                    } else {
                                        $myjquery(this).fadeIn(\'slow\').removeClass(\'hidden\');
                                    }
                            });
                            document.getElementById("latest").style.color="#F15A24";
                            document.getElementById("interesting").style.color="#3D3D3D";
                                                    
                        }
                    }
                    
                    
                </script>
                ';
    echo "      <script type='text/javascript' src='../js/bridge/bridge.js'></script>
            <!--[if lt IE 9]>
              <script type='text/javascriptt src='../js/excanvas/excanvas.js'></script>
            <![endif]-->

            <script type='text/javascript' src='../js/spinners/spinners.js'></script>
            <script type='text/javascript' src='../js/tipped/tipped.js'></script>
            ";
    echo '  <link rel="stylesheet" type="text/css" href="../css/tipped.css" />';
            
    echo '  
       
            <script type="text/javascript" charset="utf-8">
        
        function getStoryInfo(storyID){             
        }   
        function readLater(storyID, url){
                console.log("liking");
                $myjquery("#story-"+storyID).html(\'<span class="Interesting" id="done">Added!</span>\');

                }
        function restateShow(storyID){
            console.log("restating");
            $myjquery("#restate-Story-Link-"+storyID).html(\'<span class="restated" id="done">Restated!</span>\');
            
        }
        function commentShow(commentID){
            console.log("commenting");
            var comment = $myjquery(\'#comments-text-area-\'+commentID).val();
            $myjquery("#comments-box-"+commentID).html(\'<div class="commentsDone" id="done">\'+comment+\'</div>\');
        }
        function promoteShow(storyID){
                console.log("promoting");
                var currPromo = document.getElementById("promo-num-"+storyID).innerHTML;
                var newPromo = parseInt(currPromo)+1;
                $myjquery("#promo-num-"+storyID).effect("highlight", {}, 3000);
                $myjquery("#promo-num-"+storyID).html("<span class=\'promo-num promotednum\'>"+newPromo+"</span>");
                $myjquery("#promote-story-link-"+storyID).html(\'<span class="promoted" id="done">Promoted!</span>\');

        }
        function showLoading(){
            $myjquery(\'#sb-top-content\').html("<img src=\'http://www.kahub.com/images/website/sideloader.gif\' style=\'padding-left: 29px; padding-top: 7px;\'>");
            
        }
        
        
        function commentHubShow(){
			console.log("commentinghub");
			var comment = $myjquery(\'#comment\').html();
			$myjquery(\'#commentArea\').html(\'<div class="commentsDonetop" id="done">\'+comment+\'</div>\');
		}
		
		function urlClick(){
			$myjquery(\'#help\').show();
		}
		function PostStoryInline(){
		    PostStoryHub($myjquery(\'#storyID\').val());
		}
		    $myjquery(function() {
                var charCount=0;
                $myjquery(\'textarea.comment\').tinymce({
                        // Location of TinyMCE script
                        script_url : \'../js/tiny_mce.js\',

                        // General options
                        theme : "advanced",
                        theme_advanced_buttons1 : "bold,italic,underline,|,cite,|,fontselect,fontsizeselect,fullscreen",
                        theme_advanced_buttons2 : "",
                        theme_advanced_buttons3 : "",
                        plugins : "xhtmlxtras,wordcount,lists,fullscreen",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_resizing : true,
                        auto_focus : "comment",
                        setup : function (ed) {
                                ed.onKeyPress.add(
                                    function (ed, evt) {
                                        if ($myjquery("#getStartedWrapBox").length){
                                            charCount++;
                        				    showProgressGetStarted();
                        				}
                                    }
                                );
                            }
                        });

            });
            </script>
        
        </head><body onLoad="$myjquery(\'#help\').hide(); $myjquery(\'#commentArea\').hide(); $myjquery(\'#commentArea\').hide();">';
    echo            $LiteralHeader;
    echo '      <div class="container">';
    
    echo '          <div class="main wrapper">
               
                        <div class="side-bar">';
    echo                            $LiteralSideBarContent;
    echo '<a class="subscriberss" id="addrss" href="http://www.kahub.com/l/rss.php?user='.$uid.'" target="_blank">Subscribe via RSS</a><br />';
    echo '<a class="subscriberss" id="addgoogle" href="http://fusion.google.com/add?source=atgs&feedurl=http%3A%2F%2Fwww.kahub.com%2Fl%2Frss.php%3Fuser%3D'.$uid.'" target="_blank">Add to Google Reader</a>';
    echo '              </div>';
    echo '              <div class="main-content">';
    echo '<div id="warning"><b>kahub is going through a pretty epic shift in strategy. More to be announced soon.</b></div>';
    //Home Page Content Area Starts
    
    echo                    $LiteralContent;
    //Home Page Content Area Ends                   
    echo '              </div>';
    echo '          </div>';
    echo '      </div>';
    echo            MasterPage::GetFooter();

}

class Page
{
    function Page_Load()
    {
        $DBConnection = Settings::ConnectDB();      
        if($DBConnection)
        {
            $db_selected = mysql_select_db($GLOBALS['databaseName'], $DBConnection) or die(mysql_error());
            if($db_selected)
            {
                $userID = $GLOBALS['user']->userID;
                $noOfFriends = HelpingDBMethods::GetNoOfFriends($userID);
                $totlalResults = HelpingDBMethods::totalResults($userID);
                $imageID = HelpingDBMethods::GetMemberImageID($userID);
                if($totlalResults < 1)
                {
                   // header('Location:' . Settings::GetRootURL() . 'l/incomplete_profile_landing_page.php');
                   Page::SetMainContentNoStories();
                   Page::SetSideBarContent();
                }
                else
                {                   
                    Page::SetMainContent();
                    Page::SetSideBarContent();  
                    //StoryRanking::SetStoryRanking();                  
                }   
            }
            mysql_close($DBConnection);
        }
        
        
    }
    
    function SetMainContent()
    {
        $rootURL = Settings::GetRootURL();
        $userID = $GLOBALS['user']->userID;
        $view = $_GET['viewtype'];
        $offset = 0;
        $limit = 30;
        
        $totlalResults = 0;
        if ($view=="i"){
            $LatestStories = HelpingDBMethods::GetLatestStoriesInteresting($offset, $limit, $userID, true, $totlalResults);
            $viewtype = 1;
            
        } else {
            $key = md5($userID);
            $keyStories2 = "storiesHome";
        	$keyStories = $key.$keyStories2;
        	$memcache = new Memcache;
        	$memcache->connect('localhost', 11211) or die ("Could not connect"); //connect to memcached server
        	$LatestStories = $memcache->get($keyStories);
        	if($LatestStories==null){
        	    $LatestStoriesCache = HelpingDBMethods::GetLatestStories($offset, $limit, $userID, true, $totlalResults);
        	    $memcache->set($keyStories, $LatestStoriesCache, false, 30);
        	} else {
        	    $totlalResults = HelpingDBMethods::totalResults($userID);
        	}
        	$LatestStories = $memcache->get($keyStories);
            $viewtype = 0;          
        }
        $noComments = HelpingDBMethods::GetNoComments($userID);
        $hasHub = HelpingDBMethods::hasHandle($userID);
            if(!$hasHub&&$userID<82){
                header('Location: http://www.kahub.com/l/getstarted.php'); 
            }
             
        if(!$hasHub){
            $h = '<div class="noHub"><a href="http://www.kahub.com/l/createphub.php">Before you can start using kahub, you have to set up your profile</a></div>';
        } else if($noComments==0) {
            $started = HelpingDBMethods::GetInterestsShared($userID);
            $h = "<div class='noComments getStarted step1' id='getStartedWrapBox'><div class='getStartedInner'><span class='getStartedHeadWrap'>&mdash;<i>Get started by Promoting your first story!</i>&mdash;</span><div class='furtherInstrcut'><br />When you promote a story, you share it to your friends Latest Stories feeds (if you promote just 1 story, you'll never see this popup again, ever.)</div>".$started."<a onClick='jQuery(\"#getStartedWrapBox\").hide()' class='closeModalDialog'>hide</a></div></div><div class='clear'></div>";
            $stepClass="step1";
        } else {
            $stepClass="normalUser";
        }
           
           
        
        $GLOBALS['LiteralContent'] = <<<HTML
            <div class="pr-20">
                <div class="easyWrap {$stepClass}" id="easyWrap">
                <div class="clr3"></div><div class="easyShare"><input type="text" name="url" size="40" id="url" value="http://"/>
    					<div id="magic"><b>Doing some super secret magic</b></div><input type="button" name="attach" value="Share" id="attach" />	<div id="help"><b>Did you know that you don't have to copy links to share at all?</b> If you have our <a href="http://www.kahub.com/download.html">extension installed</a>, next time just click the kahub button and <b>highlight</b>, type your <b>comment</b>, and you're <b>done!</b></div><div id="atc_bar">
    					<div id="loader">

    						<div id="atc_loading" style="display:none"><img src="load.gif" alt="Loading" /></div>
    						<div id="attach_content" style="display:none">
    							<div id="atc_info">
    								<label id="atc_title"></label>
    								<label id="atc_url"></label>
    								<input id="storyID" style="display: none"/>
    								<br clear="all" />
    								<label id="atc_desc"></label>
    								<div></div>
    								<br clear="all" />
    							</div>
    							<br clear="all" />
    						</div>
    					</div>
    					<div id="commentArea"><textarea id="comment" class="comment"></textarea><span onClick="commentHubShow();"><a onClick="PostStoryInline()" class="inlineReplynoExt" id="replytext">Post</a></span></div>

    					<br clear="all" />
    
    					</div>
    				</div>
                    {$h}
                    </div>
    			<div class="clr"></div>
    			<div class="clr"></div>
    			
                <div class="topheader">
                <span class="topheadermessage">
                Latest Stories
                </span> 
                <ul class="selection">
                <span class="filtermessage">Filter by Type:</span>
                <li id="latest" onclick="changeIntrests(0)">All Stories</li>
                <li id="interesting" onclick="window.location.href='http://www.kahub.com/l/?viewtype=i'">Read Later</li>
                </ul>
                </div>
                <div class="cl"></div>
                 <div class="graf">
                    <input type = "hidden" id = "limit" value = "{$limit}" />
                    <input type = "hidden" id = "offset" value = "{$limit}" />
                    <input type = "hidden" id = "viewtype" value = "{$viewtype}" />
                    <input type = "hidden" id = "totlalResults" value = "{$totlalResults}" />
                    <ul class="stories" id = "latest-stories">
                        {$LatestStories}
                    </ul>
                 </div>
                
                <div class = "more-btn-div">
                    <div class = "more-message"></div>
                    <p class = "more"> Older Stories </p>
                </div>
            </div>
HTML;
    }
    function SetMainContentNoStories()
    {
        $rootURL = Settings::GetRootURL();
        $userID = $GLOBALS['user']->userID;
        $view = $_GET['viewtype'];
        $offset = 0;
        $limit = 30;
        
        $totlalResults = 0;
        if ($view=="i"){
            $LatestStories = HelpingDBMethods::GetLatestStoriesInteresting($offset, $limit, $userID, true, $totlalResults);
            $viewtype = 1;
            
        } else {
            $key = md5($userID);
            $keyStories2 = "storiesHome";
        	$keyStories = $key.$keyStories2;
        	$memcache = new Memcache;
        	$memcache->connect('localhost', 11211) or die ("Could not connect"); //connect to memcached server
        	$LatestStories = $memcache->get($keyStories);
        	if($LatestStories==null){
        	    $LatestStoriesCache = HelpingDBMethods::GetLatestStories($offset, $limit, $userID, true, $totlalResults);
        	    $memcache->set($keyStories, $LatestStoriesCache, false, 30);
        	} else {
        	    $totlalResults = HelpingDBMethods::totalResults($userID);
        	}
        	$getStartHub = HelpingDBMethods::showFeatHubs();
            $viewtype = 0;          
        }
        $noComments = HelpingDBMethods::GetNoComments($userID);
        $hasHub = HelpingDBMethods::hasHandle($userID);
            if(!$hasHub&&$userID<82){
                header('Location: http://www.kahub.com/l/getstarted.php'); 
            }
             
        if(!$hasHub){
            $h = '<div class="noHub"><a href="http://www.kahub.com/l/createphub.php">Before you can start using kahub, you have to set up your profile</a></div>';
        }
           
           
        
        $GLOBALS['LiteralContent'] = <<<HTML
            <div class="pr-20">
                <div class="clr3"></div><div class="easyShare"><input type="text" name="url" size="40" id="url" value="http://"/>
    					<div id="magic"><b>Doing some super secret magic</b></div><input type="button" name="attach" value="Share" id="attach" />	<div id="help"><b>Did you know that you don't have to copy links to share at all?</b> If you have our extension installed, next time just click the kahub button and <b>highlight</b>, type your <b>comment</b>, and you're <b>done!</b></div><div id="atc_bar">
    					<div id="loader">

    						<div id="atc_loading" style="display:none"><img src="load.gif" alt="Loading" /></div>
    						<div id="attach_content" style="display:none">
    							<div id="atc_info">
    								<label id="atc_title"></label>
    								<label id="atc_url"></label>
    								<input id="storyID" style="display: none"/>
    								<br clear="all" />
    								<label id="atc_desc"></label>
    								<div></div>
    								<br clear="all" />
    							</div>
    							<br clear="all" />
    						</div>
    					</div>
    					<div id="commentArea"><textarea id="comment" class="comment"></textarea><span onClick="commentHubShow();"><a onClick="PostStoryInline()" class="inlineReplynoExt" id="replytext">Post</a></span></div>

    					<br clear="all" />
    
    					</div>
    				</div>
                    {$h}
                    
    			<div class="clr"></div>
    			<div class="clr"></div>
    			
                <div class="topheader">
                <span class="topheadermessage">
                Latest Stories
                </span>
                </div>
                <div class="cl"></div>
                 <div class="graf">
                    <input type = "hidden" id = "limit" value = "{$limit}" />
                    <input type = "hidden" id = "offset" value = "{$limit}" />
                    <input type = "hidden" id = "viewtype" value = "{$viewtype}" />
                    <input type = "hidden" id = "totlalResults" value = "{$totlalResults}" />
                    <ul class="stories" id = "latest-stories">
                        {$getStartHub}
                    </ul>
                 </div>
            
            </div>
HTML;
    }
    
    function SetSideBarContent()
    {
        $GLOBALS['LiteralSideBarContent'] = '<div class = "side-bar-wrap">
                                                ' . 
                                                    SideBar::MemberProfileInformation().
                                                '
                                                ' . SideBar::FacebookFriendsWidget() . '
                                             </div>';
    }
    
    
}


?>

    </body>
</html>
