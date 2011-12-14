<?php
require_once '../AppCode/Connichiwah.UI.php';
$LiteralMessage = '';
$LiteralContent = '';
CommentService::Page_Load();
echo <<< HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Share</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="css/style.css" />
		<script type = 'text/javascript' src = 'http://localhost/connichiwah/service/js/jquery.js'></script>
		<script type = "text/javascript" src = 'http://localhost/connichiwah/service/js/main.js'></script>
		
	</head>
	<body>
		<form method = "post">
			<div class = "UI-Content">
				<div class = "UI-box-content-middle">
					{$LiteralContent}
				</div>
				<div class = "UI-box-footer-bottom"></div>
			</div>
		</form>
	</body>
</html>

HTML;


class CommentService
{
	function Page_Load()
	{
		if(isset($_GET['type']) && $_GET['type'] != "" && isset($_GET['url']) && $_GET['url'] != "")
		{
			$DBConnection = Settings::ConnectDB(); 		
			if($DBConnection)
			{
				$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
				if($db_selected)
				{

					$url = $_GET['url'];
					// new text selected ---- load share box
					if($_GET['type'] == "UI.Hoverbox.Share" && isset($_GET['text']) && $_GET['text'] != "")
					{
						
						$text_selected = $_GET['text'];
						// comments posted on new text
						if(isset($_POST['submit']) && $_POST['commentstext'] != "")
						{
							$Comments = $_POST['commentstext'];
							$storyID = HelpingDBMethods::GetStoryID($url);
							if($storyID == 0)
							{
								HelpingDBMethods::InsertStory('', $url);
								$storyID = HelpingDBMethods::GetStoryID($url);
							}
							$MemberID = 1;
							$ReplyTo = 0;
							HelpingDBMethods::PostComments($storyID, $text_selected, $Comments, $MemberID, $ReplyTo);
							$GLOBALS['LiteralContent'] = ConnichiwahUI::UIHoverboxComments($text_selected, $url);
						}
						//code to implement locking function
						elseif($_GET['type'] == "UI.Hoverbox.Share" && isset($_GET['text']) && $_GET['text'] != "" && isset($_GET['lock']) && $_GET['lock'] == 1)
						{
							//code to implement locking function
							$GLOBALS['LiteralContent'] = ConnichiwahUI::UIPrivacy($text_selected, $url);
						}
						// show source selection
						elseif($_GET['type'] == "UI.Hoverbox.Share" && isset($_GET['text']) && $_GET['text'] != "" && isset($_GET['lock']) && $_GET['lock'] == 2)
						{
							//code to implement locking function
							$GLOBALS['LiteralContent'] = ConnichiwahUI::UIPrivacySourceSelection($text_selected, $url);
						}
						// Text Selected, show UI.Hoverbox.Share
						else
						{
							$GLOBALS['LiteralContent'] = ConnichiwahUI::UIHoverboxShare($text_selected, $url);
						}
					}
					elseif($_GET['type'] == "UI.Face" && isset($_GET['text']) && $_GET['text'] != "")
					{
						$text_selected = $_GET['text'];
						$GLOBALS['LiteralContent'] = ConnichiwahUI::UIFace($text_selected, $url);						
					}
					elseif($_GET['type'] == "UI.Hoverbox.Comments" && isset($_GET['text']) && $_GET['text'] != "")
					{
						$text_selected = $_GET['text'];
						$GLOBALS['LiteralContent'] = ConnichiwahUI::UIHoverboxComments($text_selected, $url);				
					}
					elseif($_GET['type'] == "UI.Hoverbox.Reply" && isset($_GET['text']) && $_GET['text'] != "")
					{
						$text_selected = $_GET['text'];
						$CommentID = $_GET['commentid'];
						if(isset($_POST['submit']) && $_POST['commentstext'] != "")
						{
							$Comments = $_POST['commentstext'];
							$storyID = HelpingDBMethods::GetStoryID($url);
							$MemberID = 1;
							$ReplyTo = $CommentID;
							HelpingDBMethods::PostComments($storyID, $text_selected, $Comments, $MemberID, $ReplyTo);
							
							
							$GLOBALS['LiteralContent'] = ConnichiwahUI::UIHoverboxComments($text_selected, $url);	
						}
						else
						{
							$GLOBALS['LiteralContent'] = ConnichiwahUI::UIHoverboxReply($text_selected, $url, $CommentID);	
						}			
					}
					elseif($_GET['type'] == "All.Comments")
					{
						$GLOBALS['LiteralContent'] = HelpingDBMethods::GetAllComments($_GET['url']);
					}
					else
					{
						$GLOBALS['LiteralContent'] = "Invalid Aurgument : Type Not Found";
					}
				}
				mysql_close($DBConnection);
			}	
		}
		else
		{
			$GLOBALS['LiteralContent'] = "Invalid Aurgument : Type Required";
		}
	}
	
	function SaveURL($url, $title)
	{
		$response = "";
		$DBConnection = Settings::ConnectDB(); 		
		if($DBConnection)
		{
			$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
			if($db_selected)
			{
				$response = HelpingDBMethods::SaveURL($url, $title);
			}
			mysql_close($DBConnection);
		}
		return $response;
	}
}
?>