<?php
require_once '../AppCode/HelpingDBMethods.php';
header('Content-Type: text/javascript');
$url = $_GET['url'];
$result = "";
$DBConnection = Settings::ConnectDB(); 		
if($DBConnection)
{
	$db_selected = mysql_select_db(Settings::GetDatabaseName(), $DBConnection) or die(mysql_error());
	if($db_selected)
	{
		
		$result = HelpingDBMethods::GetAllComments($url);
	}
	mysql_close($DBConnection);
}
echo '
		var commentServiceURL = "' . Settings::GetCommentServiceURL() . '";
		var $myJQuery = jQuery.noConflict();
		var isAttacheAllowed = false;
		var isNav4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) == 4)
		var isNav4Min = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) >= 4)
		var isIE4Min = (navigator.appName.indexOf("Microsoft") != -1 && parseInt(navigator.appVersion) >= 4)
		var roughText = "' . $result . '";
		var myElements = roughText.split(",");
		
		$myJQuery(document).ready(function(){
			// Set isAttacheAllowed
			var n = $myJQuery("object").length;
			//alert($myJQuery("script#Connichi-Wah-Extention").attr("src"));
			if(n==0)
			{
				isAttacheAllowed = true;
			}
			if(isNav4 || isNav4Min || isIE4Min)
			{
				isAttacheAllowed = true;
				// Attach Functions to Events
				$myJQuery("body").mouseup(function(e) {
					// perform UI.Hoverbox.Share function
					showSelection(e.pageX, e.pageY);
				});
				
				// perform UI.CommentArea.Hidden function
				if(roughText != "")
				{
					hightlightCommentedText();
				}
				attachEvents();
				gethello();
			}
		});
		
		function gethello()
		{
			//alert("here");
			$myJQuery.getJSON("http://localhost/connichiwah/service/webservice.php?method=hello&callback=?", function(data){
				
					alert("Message: " + data.message + ", Date / Time: " + data.datetime);
			});
		}
		
		function attachEvents()
		{
			// perform UI.CommentArea.Highlight and UI.Face functions
			$myJQuery("span.span-underline-commented-text").hover(function (e) 
			{	
				$myJQuery(this).removeClass("span-underline-commented-text");
				$myJQuery(this).addClass("span-hover-commented-text");
				var comments = $myJQuery(this).html();
				var x = $myJQuery(this).offset().left;
				var y = $myJQuery(this).offset().top;
				ApplyUI(comments, x, y, 500, "UI.Face");
				//ApplyUI(comments, e.pageX, e.pageY, 500, "UI.Face");
			}, function () 
			{
				// undo UI.CommentArea.Highlight and UI.Face functions
				
				$myJQuery(this).removeClass("span-hover-commented-text");
				$myJQuery(this).addClass("span-underline-commented-text");
			});
	        
			// perform UI.Hoverbox.Comments function
			$myJQuery("span.span-underline-commented-text").click(function(e)
			{            
				var comments = $myJQuery(this).html();
				var x = $myJQuery(this).offset().left;
				var y = $myJQuery(this).offset().top;
				ApplyUI(comments, x, y, 500, "UI.Hoverbox.Comments");
				//ApplyUI(comments, e.pageX, e.pageY, 500, "UI.Hoverbox.Comments");
				//alert($myJQuery("iframe.iframe-class").html());
			});
		}
		
		// Define Function Attached to Events
		function showSelection(x, y) 
		{
			var selectedText = "";
			if (isNav4Min) 
			{
				selectedText = document.getSelection();
				//alert("1");
			} 
			else if (isIE4Min) 
			{
				if (document.selection) 
				{
					alert("2");
					selectedText = document.selection.createRange().text;
					event.cancelBubble = true;
				}
			}
			if (isNav4) 
			{
				alert("3");
				selectedText = document.captureEvents(Event.MOUSEUP);
			}
		    selectedText = GetUniqueSelectedText(selectedText);
			// function to show this text
			// i.e hover function
			var txt = new String(selectedText);
			var l = txt.length;
			if(txt != "" && l > 20 )
			{
				////txt = escape(txt);
				////alert(txt);
				//roughText = txt;
				//myElements = roughText.split(",");
				//hightlightCommentedText();
				//attachEvents()
				ApplyUI(txt, x, y, 500, "UI.Hoverbox.Share");
				
			}
			else if(l > 0)
			{
				alert("Selected Text Length is less then 20 characters, " + l + " Characters Selected");
			}
		}

		function ApplyUI(text, x, y, timetofade, type)
		{			
			if($myJQuery(".div-float-main").size() > 0)
			{
				$myJQuery(".div-float-main").slideUp(timetofade, function() {
					$myJQuery(".div-float-main").remove();
					InsertUiBox(text, x, y, timetofade, type);
				});
			}
			else
			{
				InsertUiBox(text, x, y, timetofade, type);
			}
		}
		
		function InsertUiBox(text, x, y, timetofade, type)
		{
			var url = window.location.href; 
			var iframeURL = commentServiceURL + "?type="+type+"&text="+text+"&url="+url;
			var iframeTag = "<iframe src =\'" + iframeURL + "\' class = \'iframe-class\' scrolling=\'auto\' ><p>Your browser does not support iframes.</p></iframe>";
			//alert(x + ":" + y);
			$myJQuery("body").prepend("<div class = \'div-float-main\' style = \'top:" + (y-200) +"; left:" + x + "; display:none; \'>" + iframeTag + "<div>");
			$myJQuery(".div-float-main").slideDown(timetofade);
			$myJQuery(".div-float-main").css("top", (y-200));
			$myJQuery(".div-float-main").css("left", x);
		}

		function GetUniqueSelectedText(selectedText)
		{
			// Find No OF Occurence of Selected Text, Empty String And min Length Checks etc
			
			
			
			// Hightlight Unique Selected Text i.e apply css class span tags for highlighting
			//var docText = $myJQuery("body").html();
			//alert("in replace" + selectedText);
			
			//docText.replace(selectedText, "111111111111111111111111111111111");
			//$myJQuery("body").html(docText);
			
			return selectedText;
		}
		
		function hightlightCommentedText()
		{
			for(var i = 0; i < myElements.length; i++)
			{
				//alert(myElements[i]);
				var highlightStartTag = "<span class = \'span-underline-commented-text\'>";
				var highlightEndTag = "</span>";
				highlightSearchTerms(myElements[i], true, true, highlightStartTag, highlightEndTag)
			}    
		}

		/*
		 * This is the function that actually highlights a text string by
		 * adding HTML tags before and after all occurrences of the search
		 * term. You can pass your own tags if you\'d like, or if the
		 * highlightStartTag or highlightEndTag parameters are omitted or
		 * are empty strings then the default <font> tags will be used.
		 */
		function doHighlight(bodyText, searchTerm, highlightStartTag, highlightEndTag) 
		{
		  // the highlightStartTag and highlightEndTag parameters are optional
		  if ((!highlightStartTag) || (!highlightEndTag)) {
			highlightStartTag = "<font style=\'color:blue; background-color:#FAE20D;\'>";
			highlightEndTag = "</font>";
		  }
		  
		  // find all occurences of the search term in the given text,
		  // and add some "highlight" tags to them (we\'re not using a
		  // regular expression search, because we want to filter out
		  // matches that occur within HTML tags and script blocks, so
		  // we have to do a little extra validation)
		  var newText = "";
		  var i = -1;
		  var lcSearchTerm = searchTerm.toLowerCase();
		  var lcBodyText = bodyText.toLowerCase();
		    
		  while (bodyText.length > 0) {
			i = lcBodyText.indexOf(lcSearchTerm, i+1);
			if (i < 0) {
			  newText += bodyText;
			  bodyText = "";
			} else {
			  // skip anything inside an HTML tag
			  if (bodyText.lastIndexOf(">", i) >= bodyText.lastIndexOf("<", i)) {
				// skip anything inside a script block
				if (lcBodyText.lastIndexOf("/script>", i) >= lcBodyText.lastIndexOf("<script", i)) {
				  newText += bodyText.substring(0, i) + highlightStartTag + bodyText.substr(i, searchTerm.length) + highlightEndTag;
				  bodyText = bodyText.substr(i + searchTerm.length);
				  lcBodyText = bodyText.toLowerCase();
				  i = -1;
				}
			  }
			}
		  }
		  
		  return newText;
		}
		 
		 
		/*
		 * This is sort of a wrapper function to the doHighlight function.
		 * It takes the searchText that you pass, optionally splits it into
		 * separate words, and transforms the text on the current web page.
		 * Only the "searchText" parameter is required; all other parameters
		 * are optional and can be omitted.
		 */
		function highlightSearchTerms(searchText, treatAsPhrase, warnOnFailure, highlightStartTag, highlightEndTag)
		{
		  // if the treatAsPhrase parameter is true, then we should search for 
		  // the entire phrase that was entered; otherwise, we will split the
		  // search string so that each word is searched for and highlighted
		  // individually
		  if (treatAsPhrase) {
			searchArray = [searchText];
		  } else {
			searchArray = searchText.split(" ");
		  }
		  
		  if (!document.body || typeof(document.body.innerHTML) == "undefined") {
			if (warnOnFailure) {
			  alert("Sorry, for some reason the text of this page is unavailable. Searching will not work.");
			}
			return false;
		  }
		  
		  var bodyText = document.body.innerHTML;
		  for (var i = 0; i < searchArray.length; i++) {
			bodyText = doHighlight(bodyText, searchArray[i], highlightStartTag, highlightEndTag);
		  }
		  
		  document.body.innerHTML = bodyText;
		  return true;
		}
';

?>