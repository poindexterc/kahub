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
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html xmlns="http://www.w3.org/1999/xhtml">';
	echo '	<head>';
	echo '		<title>Connichiwah : Home</title>';
	echo		MasterPage::GetHeadScript();
	echo '		<script type = "text/javascript">
					$myjquery(document).ready(function(){					
						$myjquery("#story-no-1").click();
						$myjquery(window).scroll(function() {
							//var bodyHeight = $myjquery("body").height();
							var windowHeight = $myjquery(window).height();
							var windowOffset = window.pageYOffset;
							if(windowOffset + windowHeight > $myjquery(".more").position().top)
							{
								//alert($myjquery(".more").position().top);
								$myjquery(".more").click();
							}        
						});
						
					});
				</script>';
	echo '	</head>';
	echo '	<body>';
	echo			$LiteralHeader;
	echo '		<div class="container">';
	
	echo '			<div class="main wrapper">
						<div class="side-bar"><li>';
	echo					$LiteralSideBarContent;
	echo '				</li></div>';	
	echo '				<div class="main-content">';
	//Home Page Content Area Starts
	echo					$LiteralContent;
	//Home Page Content Area Ends				    
	echo '				</div>';
	echo '			</div>';
	echo			MasterPage::GetFooter();
	echo '	    </div>';
	echo '	</body>';
	echo '</html>';
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
				$imageID = HelpingDBMethods::GetMemberImageID($userID);
				if($noOfFriends < 3 || $imageID == 0)
				{
					header('Location:' . Settings::GetRootURL() . 'member/incomplete_profile_landing_page.php');
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
		$offset = 0;
		$limit = 6;
		$totlalResults = 0;
		$LatestStories = HelpingDBMethods::GetLatestStories($offset, $limit, $userID, true, $totlalResults);
		
		$Top5Stories = Page::GetTop5Stories();		
		$GLOBALS['LiteralContent'] = <<<HTML
			<div class="pr-20">	
                <div class="dark-gray">
					<img class = "dark-gray-img" src = "" alt = "" id = "img-left" style = "display:none;" />
                    <h2 class = "dark-gray-heading">Loading...</h2>
                </div>
                
                <div class="light-gray">
					<div class = "flicker-images" id = "flicker-images">
						
					</div>
					<div class = "story-comment">
						<div class="light-gray-comment">
							<div class = "box-member-comment-text">
								Loading...
								<!--<a class = "box-member-comment-read-more">read more...</a>-->
							</div>
							<div class = "box-member-comment-text-footer"></div>							
						</div>
						
						<div class = "light-gray-box">
							<img alt="" src="{$rootURL}images/website/gray-box.jpg" class = "light-gray-box-img"/>
						</div>						
                    </div>
                </div>
                <div class="cl"></div>
                <div class="red-raad">
					<ul>
                    {$Top5Stories}
                    </ul>
                    <!--<img alt="" src="{$rootURL}images/website/box-38.jpg" class="box-1" onclick = "GetStoryTags(37)"/>
                    <img alt="" src="{$rootURL}images/website/box-38.jpg" class="box-2"/>
                    <img alt="" src="{$rootURL}images/website/box-38.jpg" class="box-3"/>
                    <img alt="" src="{$rootURL}images/website/box-44.jpg" class="box-4"/>
                    <img alt="" src="{$rootURL}images/website/box-52.jpg" class="box-5"/>-->
                    
                </div>
                
                 <div class="graf">
                    <h3>Latest</h3>
                    <input type = "hidden" id = "limit" value = "{$limit}" />
                    <input type = "hidden" id = "offset" value = "{$limit}" />
                    <input type = "hidden" id = "totlalResults" value = "{$totlalResults}" />
                    <ul id = "latest-stories">
						{$LatestStories}
                    </ul>
                 </div>
                
                <div class = "more-btn-div">
					<div class = "more-message"></div>
                    <img alt="" src="{$rootURL}images/website/get-more-stuf.jpg" class = "more" />
                </div>
            </div>
HTML;
	}
	
	function SetSideBarContent()
	{
		$GLOBALS['LiteralSideBarContent'] = SideBar::MemberProfileInformation();
	}
	
	function GetTop5Stories()
	{
		$MemberID = $GLOBALS['user']->userID;		
		$result = "";
		$Query = "SELECT DISTINCT s.StoryID 
				FROM tbl_friends a
				INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive AND a.MemberID_Passive = b.MemberID_Active
				INNER JOIN tbl_comments c ON a.MemberID_Active = c.MemberID
				INNER JOIN tbl_story s ON c.StoryID = s.StoryID
				WHERE (a.MemberID_Active = '$MemberID')
				ORDER BY s.DateTime, s.StoryID DESC LIMIT 0, 7";
		$QueryResult =  mysql_query($Query)or die(mysql_error());
		$QueryResult_Count = mysql_num_rows($QueryResult);
		$row = mysql_fetch_array($QueryResult);
		
		$storyArray = array();
		while( $row != false)
		{
			$StoryID = $row['StoryID'];
			$storyRank = StoryRanking::GetStoryCommulativeRank($StoryID, $MemberID);			
			$storyArray[$StoryID] = $storyRank;					
			$row = mysql_fetch_array($QueryResult);
		}
		if($QueryResult_Count < 5)
		{
			$limit_my_stories = 5 - $QueryResult_Count;
			$Query = "SELECT DISTINCT s.StoryID 
						FROM tbl_friends a
						INNER JOIN tbl_friends b ON a.MemberID_Active = b.MemberID_Passive
						AND a.MemberID_Passive = b.MemberID_Active
						INNER JOIN tbl_comments c ON b.MemberID_Active = c.MemberID
						INNER JOIN tbl_story s ON c.StoryID = s.StoryID
						WHERE (a.MemberID_Active = '$MemberID')
						ORDER BY s.DateTime, s.StoryID DESC LIMIT 0, $limit_my_stories";
			$QueryResult =  mysql_query($Query)or die(mysql_error());
			$row = mysql_fetch_array($QueryResult);
			while( $row != false)
			{
				$StoryID = $row['StoryID'];
				$storyRank = StoryRanking::GetStoryCommulativeRank($StoryID, $MemberID);			
				$storyArray[$StoryID] = $storyRank;					
				$row = mysql_fetch_array($QueryResult);
			}
		}
		//$storyArray = array(34=>1, 56=>4, 23=>6, 3=>7, 6=>77, 67=>56, 45=>54);
		arsort($storyArray, SORT_NUMERIC);
		$sArr = array_slice($storyArray,0,5, true);
		//echo $QueryResult_Count . '\n';
		//echo $limit_my_stories . '\n';
		//echo mysql_num_rows($QueryResult) . '\n';
		//print_r($storyArray);
		//print_r($sArr);
		$cnt = 1;
		foreach($sArr as $SID=>$rank)
		{
			$flickerImageURL = HelpingMethods::GetFlickerImage($SID);
			$linkClass = 'box-normal';
			$dotClass = 'dot-normal';
			if($cnt == 1)
			{
				//$linkClass = 'thumb-sel';
				//$dotClass = 'dot-click';
			}
			$result .= '<li class = "' . $linkClass . ' rail-box" id = "box-link-' . $SID . '">
							<a id = "story-no-' . $cnt . '" onclick = "javascript:GetStoryData(' . $SID . ')">
								<img id = "box-' . $SID . '" alt="" src="' . $flickerImageURL . '" class="thumb"/>
							</a>
							<span id="dot-' . $SID . '" class = "' . $dotClass . ' dot-box"></span>
						</li>';
			$cnt++;
		}
		
		return $result;
	}
	
	
}


?>