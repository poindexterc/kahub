<?php
require_once '../AppCode/ApplicationSettings.php';
require_once '../AppCode/access.class.php';

$user = new flexibleAccess();
    require_once '../AppCode/MasterPageScript.php';
    require_once '../AppCode/SideBarScript.php';
    $currUser = $GLOBALS['user']->userID;
    header('Location: http://www.kahub.com/');     
    $LiteralMessage = "";
    $LiteralContent = "";
    $LiteralSideBarContent = '';
    $handle = $_GET['user'];
    $hubData = HelpingDBMethods::GetHubInfo($handle);
    $userNum = $hubData['h-hubID'];
    $name = MemberDBMethods::GetUsername($hubData['h-memberID']);
    $LiteralHeader = MasterPage::GetHeader();
    $isHub = MemberDBMethods::isHub($userNum);
    $noFollowers = HelpingDBMethods::GetNoOfFriends($userNum);
    $noFriends = HelpingDBMethods::GetNoOfFriends($hubData['h-memberID']);
    $follow = HelpingDBMethods::isMyFriend($currUser,$userNum);
    $pal = HelpingDBMethods::isMyFriend($currUser,$hubData['h-memberID']);
    if ($replyText!=""){
        $cid = $_POST['c-id'];
        HelpingDBMethods::UIHoverboxReplyPost($asscText, $curl, $cid, $replyText);
    }
    $imageID = HelpingDBMethods::GetMemberImageID($userNum);
    if($imageID==0){
        $imageID = HelpingDBMethods::GetMemberImageID($hubData['h-memberID']);
    }
    $backgroundID = HelpingDBMethods::GetBackgroundImageID($userNum);
    $backgroundURL = HelpingDBMethods::GetImageData($backgroundID, 'member', 'thumbnail');
    $imageURL = HelpingDBMethods::GetImageData($imageID, 'member', 'thumbnail');

    if($hubData['h-memberID']==$currUser){
        $myHub=true;
        $edit = "edit_area";
    } else {
        $myHub=false;
        $edit = "";
    }
    

    $interests = HelpingDBMethods::GetInterests($userNum);
    $rs1 = HelpingDBMethods::getNoRestate($userNum);
    $rs2 = HelpingDBMethods::getNoRestate($hubData['h-memberID']);
    $restate = $rs1+$rs2;
    if($noFriends>$noFollowers){
        $friends = HelpingDBMethods::GetFriendsNoName($hubData['h-memberID']);
    } else {
        $friends = HelpingDBMethods::GetFollowersNoName($userNum);
    }
    $noComments = HelpingDBMethods::GetNoComments($userNum);

    if($follow){
        $friend = true;
    } 
    if($pal){
        $friend = true;
        $latest = HelpingDBMethods::LatestStoryPersonHub($hubData['h-memberID'], $handle);
        $storiesArray = HelpingDBMethods::LatestStoriesHubArray($hubData['h-memberID']);
        $stories = HelpingDBMethods::GetLatestStoriesPersonHub($storiesArray, $hubData['h-memberID'], $handle);
        $unfollowID = $hubData['h-memberID'];
        $unfollowText ="&times; Unfriend";
    } else if($follow) {
        $latest = HelpingDBMethods::LatestStoryPersonHub($userNum, $handle);
        $storiesArray = HelpingDBMethods::LatestStoriesHubArray($userNum);
        $stories = HelpingDBMethods::GetLatestStoriesPersonHub($storiesArray, $userNum, $handle);
        $unfollowID = $userNum;
        $unfollowText ="&times; Unfollow";
    } else {
        $latest = HelpingDBMethods::LatestStoryPersonHub($userNum, $handle);
        $storiesArray = HelpingDBMethods::LatestStoriesHubArray($userNum);
        $stories = HelpingDBMethods::GetLatestStoriesPersonHub($storiesArray, $userNum, $handle);
    }
    
    
    if($hubData['h-memberID']==$currUser){
        $unfollowText = "";
        $ownership = "their own";
    } else {
        $ownership = "someone elses";
    }

    Page::Page_Load();  
    
    echo '<!DOCTYPE HTML>';
    echo '<html>';
    echo '  <head>';
    echo '      <title>'.$name.' (/'.$handle.') on kahub</title>';
    echo        MasterPage::GetHeadScript();
    echo '  <meta property="og:title" content="'.$name.' (/'.$handle.') on kahub"/>
            <meta property="og:url" content="http://www.kahub.com/'.$handle.'"/>
            <meta property="og:image" content="'.$imageURL.'"/>
            <meta property="og:site_name" content="kahub"/>
            <meta property="fb:app_id" content="146470212065341"/>
            <meta property="og:description" content="'.$name.' is on kahub. kahub is a super easy way to read news with friends, and discover news with the world as easy as Highlight, Comment, Done."/>
            <meta name="description" content="'.$name.' is on kahub. kahub is a super easy way to read news with friends, and discover news with the world as easy as Highlight, Comment, Done.">
    		<meta name="keywords" content="'.$name.', kahub, social, news, share, friends, read news with friends, connichiwah, digg, reddit, xydo" />
    		<script type="text/javascript"> _kmq.push([\'record\', \'Viewed Person Hub\']);</script>
    		<script type="text/javascript"> _kmq.push([\'record\', \'Viewed '.$ownership.' hub\']);</script>
    		<script type="text/javascript"> _kmq.push([\'record\', \'Viewed Person Hub '.$userNum.'\']);</script>
            <style type="text/css" media="screen">
                a{
                    color: #3E5681;
                    text-decoration: none;
                }
            </style>
                ';
    echo "<script type='text/javascript' src='../js/parseURL.js'></script>
        <script type='text/javascript' src='../js/jquery.tinymce.js'></script>";
    echo '  <link rel="stylesheet" type="text/css" href="../css/tipped.css" />
    <link rel="stylesheet" type="text/css" href="../css/style-profile.css" />
    <style type="text/css">
    ';
    if($backgroundURL!="http://www.kahub.com/images/website/photo-1.jpg"){
        echo 'body{
            background: url("'.$backgroundURL.'") !important;
        }    
        div.main-content {
                -webkit-box-shadow: 0px 0px 13px 3px #5c5c5c;
                -moz-box-shadow: 0px 0px 13px 3px #5c5c5c;
                box-shadow: 0px 0px 13px 3px #5c5c5c;
                background-color: rgba(255, 255, 255, .5);
                border-style: none !important;
                filter: blur(3px);
            }';
    }
    echo '</style>';
            
    echo '  </head>';
    echo '  <body onLoad="$myjquery(\'#help\').hide(); $myjquery(\'#commentArea\').hide();">

            <script type="text/javascript" charset="utf-8">

            function promoteShow(storyID){
                    console.log("promoting");
                    var currPromo = document.getElementById("promo-num-"+storyID).innerHTML;
                    var newPromo = parseInt(currPromo)+1;
                    $myjquery("#promo-num-"+storyID).effect("highlight", {}, 3000);
                    $myjquery("#promo-num-"+storyID).html("<span class=\'promo-num promotednum\'>"+newPromo+"</span>");
                    $myjquery("#promote-story-link-"+storyID).html(\'<span class="promoted" id="done">Promoted!</span>\');

            }
            function commentShow(commentID){
                console.log("commenting");
                var comment = $myjquery(\'#comments-text-area-\'+commentID).val();
                $myjquery("#comments-box-"+commentID).html(\'<div class="commentsDone" id="done">\'+comment+\'</div>\');
            }
            function commentHubShow(){
                console.log("commentinghub");
                var comment = $myjquery(\'#comment\').val();
                $myjquery(\'#commentArea\').html(\'<div class="commentsDone phub" id="done">\'+comment+\'</div>\');
            }
            
            function urlClick(){
                $myjquery(\'#help\').show();
            }
            $myjquery(function() {
            
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
                        auto_focus : "comment"
                        });

            });

            </script>
        ';
    echo            $LiteralHeader;
    echo '      <div class="container">';
    
    echo '          <div class="main wrapper">';
    echo '              <div class="main-content">';
    if($handle=="p"||$handle==""){
        echo "<div class='noMore'>This person has not setup thier hub yet.</div>";
    } else if ($handle == "INVALIDTOPIC"){
        echo "<div class='noMore'>We don't think this topic is ready for a topic hub quite yet.</div>";
    } else {
        echo '<div id="sideWrapperphub"><div class="profile-pic phub" data-width="200" data-height="200" data-type="jpg" data-crop="true" data-quality="70"><img alt="" src="'.$imageURL.'" /><a class="unfollow" onClick="unfollowHub('.$unfollowID.')">'.$unfollowText.'</a></div><br clear="all" />';
    //Home Page Content Area Starts
    echo "<div id='sideName'>";
    echo $name;
    echo '</div>';
    if ($friend!=true){
                    echo '<span class="addsource"><input type="button" value="    Follow" onclick="Followhub('.$userNum.');" class="btn-follow"><input type="button" value="    Friend" onclick="AddFriendFromSearch('.$hubData['h-memberID'].');" class="btn-add-prof"></span>
                    <div class="about"><div id="followdesc">Get all their public updates</div><div id="frienddesc">Get all their updates</div></div>';
    }
    echo '<div class="handle">';
    echo '/'.$handle;
    echo '</div>';
    echo '<div class="moreinfo">';
    echo '<div class="headline '.$edit.'" id="hedlineText">';
    echo $hubData['h-headline'];
    echo '</div>';
    echo '<div class="interests">';
    echo $interests;
    echo '</div>';
    echo '</div>';
    echo '</div>';
        echo '<div class="followerspic">';
        if($hubData['h-memberID']==$currUser){
              echo "<div class='changeProfBG'><a href='http://www.kahub.com/l/settings.php?type=bg'>Change your Hub's Look</a></div><br clear='all' />";
          }
        echo '<div class="followers"> <span class="followNum">'.$noFollowers.'</span> <a href="http://www.kahub.com/l/followers.php?user='.$handle.'">Followers</a> &#183; <span class="friendsNum">'.$noFriends.'</span> <a href="http://www.kahub.com/l/friends.php?user='.$handle.'">Friends</a> </span> &#183;<span class="restateCount">Restated <span class="noRestate">'.$restate.'</span> times</span> &#183; <span class="comments"><span class="noComments">'.$noComments.'</span> Comments</span>';
        echo '</div><div class="follower">';
        echo $friends;
        echo '</div></div>';
        
       
        if($stories!=""){
            echo "<div class='latestWrap'>";
            echo $latest;
            echo '</div>';
            echo '<div class="clr"></div><div class="profile-latest"></div>';
            echo '<div class="storiesLeft">';
            echo $stories;
            echo "</div>";
        } else {
            echo '<div class="noStories">';
            echo 'It doesn\'t look like there are any stories yet!';
            echo '</div>';
        }
        
        
    }

    
    //Home Page Content Area Ends                   
    echo '              </div>';
    echo '          </div>';
    echo '      </div>';
    echo            MasterPage::GetFooter();
    echo '  </body>';
    echo '</html>';


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
                $noOfFriends = HelpingDBMethods::GetNoOfFriends($userNum);
                $imageID = HelpingDBMethods::GetMemberImageID($userNum);
                
                                    
                    //Page::SetMainContent();
                    Page::SetSideBarContent();  
                    //StoryRanking::SetStoryRanking();                  
                    
            }
            mysql_close($DBConnection);
        }
        
        
    }
    
    
    function SetSideBarContent()
    {
        $GLOBALS['LiteralSideBarContent'] = '<div class = "side-bar-wrap">
                                                <span class = "side-bar-shadow">' . 
                                                    SideBar::MemberProfileInformation().
                                                '</span>
                                             </div>
                                             <div class = "side-bar-wrap" style = "margin-top:30px;">
                                                <span class = "side-bar-shadow">
                                                    ' . SideBar::FacebookFriendsWidget() . '
                                                </span>
                                             </div>';
    }
    
    
    
    
}


?>
