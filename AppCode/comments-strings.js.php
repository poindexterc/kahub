<?php
require_once '../Appcode/HelpingDBMethods.php';
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
		var commentServiceURL = "http://localhost/connichiwah/service/comment-service.php";
		var webServiceURL = "http://localhost/connichiwah/webService/gen.php";
		
		var $myJQuery = jQuery.noConflict();
		var isAttacheAllowed = false;
		var isNav4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) == 4)
		var isNav4Min = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) >= 4)
		var isIE4Min = (navigator.appName.indexOf("Microsoft") != -1 && parseInt(navigator.appVersion) >= 4)
		var roughText = "' . $result . '";
		var myElements = roughText.split(",");
		    
		//$(document).ready(function(){
		//   $("a").click(function(event){
		//     alert("Thanks for visiting!");
		//   });
		// });
		
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
				// perform UI.CommentArea.Highlight and UI.Face functions
				$myJQuery("span.span-underline-commented-text").hover(function (e) 
				{	
									
					$myJQuery(this).css("background-color","Yellow");
					$myJQuery(this).css("border","none");
					// perform UI.Face function
					var comments = $myJQuery(this).html();
					//alert("x:" + e.pageX + ", Y:" + e.pageY );
					ApplyUI(comments, e.pageX, e.pageY, 2000, "UI.Face");
				}, function () 
				{
					// undo UI.CommentArea.Highlight and UI.Face functions
					$myJQuery(this).css("background-color","Transparent");
					$myJQuery(this).css("border-bottom","Solid 3px Yellow");
					//$myJQuery(".div-float-main").fadeOut(2000, function(){$myJQuery(".div-float-main").remove();});
				});
		        
				// perform UI.Hoverbox.Comments function
				$myJQuery("span.span-underline-commented-text").click(function(e)
				{            
					var comments = $myJQuery(this).html();
					ApplyUI(comments, e.pageX, e.pageY, 2000, "UI.Hoverbox.Comments");
				});
		        
			}
		});

		// Define Function Attached to Events
		function showSelection(x, y) 
		{
			var selectedText = "";
			if (isNav4Min) 
			{
				selectedText = document.getSelection();
			} 
			else if (isIE4Min) 
			{
				if (document.selection) 
				{
					selectedText = document.selection.createRange().text;
					alert(event.pageX);
					event.cancelBubble = true
				}
			}
			if (isNav4) 
			{
				selectedText = document.captureEvents(Event.MOUSEUP);
			}
		    
			// function to show this text
			// i.e hover function
			if(selectedText != "" && selectedText != " " )
			{
				ApplyUI(selectedText, x, y, 2000, "UI.Hoverbox.Share");
			}
		}

		function ApplyUI(text, x, y, timetofade, type)
		{
			var url = window.location.href; 
			var iframeURL = commentServiceURL + "?type="+type+"&text="+text+"&url="+url;
			var iframeTag = "<iframe src =\'" + iframeURL + "\' class = \'iframe-class\'><p>Your browser does not support iframes.</p></iframe>";
			$myJQuery(".div-float-main").remove();
			$myJQuery("body").append("<div class = \'div-float-main\' style = \'top:" + y +"; left:" + x + "; display:none; \'>" + iframeTag + "<div>");
			$myJQuery(".div-float-main").fadeIn(timetofade);
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
			highlightStartTag = "<font style=\'color:blue; background-color:yellow;\'>";
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
				// skip anything inside a <script> block
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

		function getCommentStrings()
		{
		      
			//alert("hello");
			//var iframeURL = commentServiceURL + "?type=All.Comments";
			//var iframeTag = "<iframe id = \'myframe\' src =\'" + iframeURL + "\' class = \'iframe-class\'><p>Your browser does not support iframes.</p></iframe>";
			//$myJQuery(".div-float-main").remove();
			//$myJQuery("body").append("<div class = \'div-float-main\' style = \'display:none;\'>" + iframeTag + "</div>");    
			//$myJQuery(".div-float-main").fadeIn(timetofade);
			//var iframe = document.getElementById("myframe");
			//var t = iframe.contentWindow.myFunction();
			//alert(t);
			$myJQuery.ajax({
			   type: "POST",
			   url: webServiceURL + "?method=getCommentStrings",
			   data: "",
			   success: function(msg){
				 alert( "Data Saved: " + msg);
			   }
			 });
		}

		function setcommentstring(roughText)
		{
			alert("now here");
			//alert(roughText);
		}

		function hello()
		{
			alert("hello tweetme");
			$myJQuery.getJSON("http://api.tweetmeme.com/url_info.jsonc?url=http://www.elistmania.com/juice/10_bizarre_beauty_treatments/&callback=?",
				function(data)
				{
					var TwitterCount = data.story.url_count;
					alert(TwitterCount);
				}
			);
		//    var method = \'hello\';
		//    data = "";    
		//    http_request = CreateXMLHttpRequest();          
		//    url = "http://sopider.com/DatabaseHelperService.php?method=hello";

		//    http_request.onreadystatechange = function()
		//    {     
		//        if (http_request.readyState == 4) 
		//        {
		//            if (http_request.status == 200) 
		//            {            
		//                var result = http_request.responseText;
		//                alert(result);
		//            } 
		//            else 
		//            {
		//                alert(\'There was a problem with the request.\' + http_request.status);
		//            }
		//        }
		//    };
		//    http_request.open(\'POST\', url, true);
		//    http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//    http_request.setRequestHeader("Content-length", data.length);
		//    http_request.setRequestHeader("Connection", "close");
		//    http_request.send(data);
		}
    
';

?>