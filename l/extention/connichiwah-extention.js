    var $myJQuery = jQuery.noConflict();
    //var WebServiceURL = "http://localhost/connichiwah/extention/webservice.php";
    //var rootURL = "http://localhost/connichiwah/";
    var WebServiceURL = "http://www.connichiwah.com/extention/webservice.php";
    var rootURL = "http://www.connichiwah.com/";
    var selected_text = '';
    var x = 500;
    var y = 500; 
    var isAttacheAllowed = false;
    var blocked = false;
    var isNav4 = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) == 4)
    var isNav4Min = (navigator.appName == "Netscape" && parseInt(navigator.appVersion) >= 4)
    var isIE4Min = (navigator.appName.indexOf("Microsoft") != -1 && parseInt(navigator.appVersion) >= 4)
    var roughText = "";
	  
    var myElements = new Array();
	var selected_source_id = 0;
	var selected_source_name = '';
	var my_preffered_share_method = 2 ; // 1 = share with source, 2 = shre with  my network
	
	//var ShareBoxLoaded = false;
	var privacyLockClick = false;  
	var isContainerFocused = false;
	
	$myJQuery(document).ready(function(){
        var url = window.location.href;
        url = encodeToHex(url);
        $myJQuery.getJSON(WebServiceURL + "?method=isInRestrictedDomain&callback=?", { url: url },  function(data){ 
	        var result = data.result;	        
	        if(result == "false")
	        {
	            blocked = false;		        
		    }
		    else
		    {
		        blocked = true;
		        //alert("Extention is not Attached, this site is not supported");
		    }
		});
		if(isNav4 || isNav4Min || isIE4Min)
        {
	        isAttacheAllowed = true;
        }
        // Attach Functions to Events
        
        $myJQuery("body").mouseup(function(e) {
	        // perform UI.Hoverbox.Share function

	        showSelection(e.pageX, e.pageY);

        });
        
        if(isAttacheAllowed && blocked == false)
        {
            // perform UI.CommentArea.Hidden function
	        GetComments();	
        }
	});	
	
	function attachEvents()
	{
		// perform UI.CommentArea.Highlight and UI.Face functions
		$myJQuery("span.span-underline-commented-text").hover(function (e) 
		{	
			$myJQuery(this).removeClass("span-underline-commented-text");
			$myJQuery(this).addClass("span-hover-commented-text");
			var comments = $myJQuery(this).html();
			x = $myJQuery(this).offset().left;
			y = $myJQuery(this).offset().top;
			ApplyUI(comments, x, y, 500, "UI.Face");

		}, function () 
		{
			// undo UI.CommentArea.Highlight and UI.Face functions
			
			$myJQuery(this).removeClass("span-hover-commented-text");
			$myJQuery(this).addClass("span-underline-commented-text");
			
			// auto hide incase user stay away from comment from more then a sec
			
			//UIFaceAutoHide(hideAfter, animationTime);
			hideFaceOnUnfocus();						
		});
        
		// perform UI.Hoverbox.Comments function
		$myJQuery("span.span-underline-commented-text").click(function(e)
		{            
			var comments = $myJQuery(this).html();
			x = $myJQuery(this).offset().left;
			y = $myJQuery(this).offset().top;
			ApplyUI(comments, x, y, 500, "UI.Hoverbox.Comments");
			
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
	    var txt = '';
	    var txt2 = new String(selectedText);
	    if(!isContainerFocused && txt2.length > 0)
	    {
	        txt = GetUniqueSelectedText(selectedText);
	    }
		
		var l = txt.length;
	    if(!isContainerFocused)
	    {
	        $myJQuery(".div-float-main").remove();
	    }

	    if(txt != "" && l > 20 && blocked == false)
	    {
            //privacyLockClick = true;
	        //ShareBoxLoaded = true;
		    ApplyUI(txt, x, y, 500, "UI.Hoverbox.Share");
			
	    }
	    else if(l > 0 && l < 20 && blocked == false)
	    {
	        //alert("Selected Text Length is less then 20 characters, " + l + " Characters Selected");
	        alert("Should Not Be Here");
	    }
	    elseif(l > 20 && blocked == true)
	    {
            // Show Message that extention is not supported
            alert("Not Supported");
            AttachMessageDivEvents('Extention is not Attached, This Site is Not Supported', 'Alert');
	    }	
	}

	function ApplyUI(text, x, y, timetofade, type)
	{
	    			
		if($myJQuery(".div-float-main").size() > 0)
		{
			$myJQuery(".div-float-main").slideUp(timetofade, function() {
				$myJQuery(".div-float-main").remove();
				if(type == "UI.Face")
				{
				    selected_text = text;
				    UIFace(text, x, y, timetofade, type);
				}
				else if(type == "UI.Hoverbox.Comments")
				{
				    selected_text = text;
				    UIHoverboxComments(text, x, y, timetofade, type);
				}
				else if(type == "UI.Hoverbox.Share")
			    {
			        selected_text = text.toString();
		            UIHoverboxShare(text, x, y, timetofade, type);
			    }
				else
				{
				    //InsertUiBox(text, x, y, timetofade, type);
				    alert("Must Not Be Here");
				}
			});
		}
        else
        {
		    if(type == "UI.Face")
		    {
		        selected_text = text;
		        UIFace(text, x, y, timetofade, type);
		    }
		    else if(type == "UI.Hoverbox.Comments")
		    {
		        selected_text = text;
		        UIHoverboxComments(text, x, y, timetofade, type);
		    }
		    else if(type == "UI.Hoverbox.Share")
		    {
		        selected_text = text.toString();
		        UIHoverboxShare(text, x, y, timetofade, type);
		    }
		    else
		    {
		        //InsertUiBox(text, x, y, timetofade, type);
		        alert("Must Not Be Here");
		    }
        }
	}
	
	function GetComments()
	{
	    var url = window.location.href;
	    url = (encodeToHex(url));
		$myJQuery.getJSON(WebServiceURL + "?method=GetComments&callback=?", { url: url },  function(data){
			roughText = data.comments;
			myElements = roughText.split(",");
			if(roughText != "")
			{
				hightlightCommentedText();
			}
			attachEvents();
		});
	}
	
	function UILogin()
	{
	    $myJQuery("body").append("<input type = 'hidden' id = 'login-state' name = 'login-state' value = 'false' />");
	    window.open (rootURL + "extention/login.php","mywindow","menubar=1,resizable=1,width=350,height=250"); 
	    //jQuery.popupWindow({ 
        //    windowURL:'http://code.google.com/p/swip/',
        //    centerBrowser:1, 
        //    windowName:'swip' 
        //    }); 
	}
	
	function UIHoverboxShare(text, mx, my, timetofade, type)
	{
	    var url = window.location.href;	
	    x = mx;
	    y = my; 
	    url = encodeToHex(url);
	    text = encodeToHex(text);     
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text},  function(data){
			var comments = data.mycomments;			
			ShowUIBox(comments, timetofade);
			// lock hover function settings
			$myJQuery(".lock-link").hover(function () 
	        {
	            var ps = '';
	            if(my_preffered_share_method == 1)
	            {
	                ps = selected_source_name;
	            }
	            else if(my_preffered_share_method == 2)
	            {
	                ps = "My Network";
	            }
	            else
	            {
	                ps = "Not Defined";
	            }	
		        $myJQuery(".UI-Privacy-lock-Hover").html("Share with : " + ps);
		        $myJQuery(".UI-Privacy-lock-Hover").css("top", ($myJQuery(this).offset().top)-27);
	            $myJQuery(".UI-Privacy-lock-Hover").css("left", ($myJQuery(this).offset().left)-6);
		        $myJQuery(".UI-Privacy-lock-Hover").show();
	        }, function () 
	        {
		        $myJQuery(".UI-Privacy-lock-Hover").hide();
	        });
	        
	        $myJQuery(".lock-link").click(function () 
	        {
	            privacyLockClick = true;
	        });	
		});
	}
	
	function UIPrivacy()
	{
	    privacyLockClick = true;
	    var type = 'UI.Privacy';
	    var text = selected_text;
	    var url = window.location.href;
	    url = encodeToHex(url);
	    text = encodeToHex(text);	
	    $myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text},  function(data){
		    $myJQuery(".div-float-main").remove(); 
			var comments = data.mycomments;			
			ShowUIBox(comments, 100);
						
		});
	}
	
	function UIPrivacySourceSelection()
	{
	    var type = 'UI.Privacy.SourceSelection';
	    var text = selected_text;
	    var url = window.location.href;
	    url = encodeToHex(url);
	    text = encodeToHex(text);	
	    $myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text},  function(data){
		    $myJQuery(".div-float-main").remove(); 
			var comments = data.mycomments;			
			ShowUIBox(comments, 100);			
		});
	}
	
	function GetUserNameSuggestions(inputString) 
    {        
		if(inputString != null && inputString.length == 0) 
		{
			$myJQuery('#autoSuggestionsList').hide();
		}
        else
        {            
			$myJQuery.getJSON(WebServiceURL + "?method=GetUserNameSuggestions&callback=?", {txt: inputString}, function(data){
				if(data.suggestions.length >0) {					
					$myJQuery('#autoSuggestionsList').html("<ul>" + data.suggestions + "</ul>");
					$myJQuery('#autoSuggestionsList').slideDown("slow");
				}
			});
		}
	}
	
	function fill(memberID) 
	{
	    selected_source_id = memberID;
	    var un = $myJQuery("#user-name-suggestion-" + memberID).html();
	    selected_source_name = un;
		$myJQuery('#txtSource').val(un);
		hideSuggestionBox();
	}
	
	function hideSuggestionBox()
	{
	    setTimeout("$myJQuery('#autoSuggestionsList').slideUp();", 200);
	}
	
	function SourceSelected(ss)
	{
	    my_preffered_share_method = ss;
	    var text = selected_text;
	    var nx = x;
	    var ny = y;
	    if(selected_source_id <= 0)
	    {
	        my_preffered_share_method = 2;
	    }
	    ApplyUI(text, nx, ny, 500, "UI.Hoverbox.Share")
	}		
	
	function UIFace(text, x, y, timetofade, type)// for ajax
	{
	    var url = window.location.href;
	    url = encodeToHex(url);
	    text = encodeToHex(text);
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text},  function(data){
			var images = data.faces;			
			ShowUIBox(images, timetofade);			
			// Set UI.Face.Hover Effects and Un Hover Efects
			$myJQuery("a.UI-Face-Image-Link").hover(function () 
	        {
	            var un = $myJQuery(this).attr("rel");	
		        //$myJQuery(this).append("<span class = 'UI-Face-Image-Link-UserName'>"+ un + "</span>");
		        $myJQuery("#UI-Face-Image-Link-UserName" + un).show();
	        }, function () 
	        {
		        //$myJQuery(".UI-Face-Image-Link-UserName").remove();
		        $myJQuery(".UI-Face-Image-Link-UserName").hide();
	        });	
	        
	        // Set UI.Face.Click Actions
	        $myJQuery("a.UI-Face-Image-Link").click(function(e)
		    {            
			    var text = selected_text;
	            ApplyUI(text, x, y, 500, "UI.Hoverbox.Comments");    			
		    });		
		});
	}
	
	function UIHoverboxComments(text, x, y, timetofade, type)
	{
	    var url = window.location.href;	
	    url = encodeToHex(url);
	    text = encodeToHex(text);       
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text},  function(data){
			var comments = data.mycomments;			
			ShowUIBox(comments, timetofade);			
		});
	}
	
	function UIHoverboxReply(commentID)
	{
	    var type = 'UI.Hoverbox.Reply';
	    var url = window.location.href;
	    var text = selected_text;	    
	    url = encodeToHex(url);
	    text = encodeToHex(text);  
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text, commentID: commentID},  function(data){ 
			var comments = data.mycomments;
			$myJQuery(".div-float-main").remove();			
			ShowUIBox(comments, 100);			
		});
	}
	
	function PostReply(CommentID)
	{
	    var type = 'UI.Hoverbox.Reply.Post';
	    var url = window.location.href;
	    var text = selected_text;
	    url = encodeToHex(url);
	    text = encodeToHex(text);
	    var mycomments = $myJQuery("#commentstext").val(); 
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text, commentID: CommentID, mycomments: mycomments},  function(data){ 
			var comments = data.mycomments;
			$myJQuery(".div-float-main").remove();			
			ShowUIBox(comments, 100);			
		});
	}
	
	function Share()
	{
	    var type = 'UI.Hoverbox.Share.Post';
	    var url = window.location.href;
	    var mtitle = document.title;
	    var text = selected_text;
	    url = encodeToHex(url);
	    mtitle = encodeToHex(mtitle)
	    text = encodeToHex(text);
	    var mycomments = $myJQuery("#commentstext").val();
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, title: mtitle, text: text, mycomments: mycomments, sharemode: my_preffered_share_method, sharewith: selected_source_id},  function(data){ 
			//var comments = data.mycomments;
			//ShowUIBox(comments, 100);
			$myJQuery(".div-float-main").remove();
			GetComments();			
		});
	}
	
	function UIHoverboxLike(CommentID)
	{
	    var type = 'UI.Hoverbox.Like';
	    var url = window.location.href;
	    var text = selected_text;
	    url = encodeToHex(url);
	    text = encodeToHex(text);
	    var mycomments = $myJQuery("#commentstext").val(); 
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text, commentID: CommentID},  function(data){ 
			var comments = data.result;
			$myJQuery("#like-" + CommentID).html('<img alt="" src="' + rootURL + 'extention/images/uni-ok-clicked.png" class="middle"/>');			
		});
	}
	
	function UIHoverboxTrust(memberID, CommentID)
	{
	    var type = 'UI.Hoverbox.Trust';
	    var url = window.location.href;
	    var text = selected_text;
	    url = encodeToHex(url);
	    text = encodeToHex(text);
	    var mycomments = $myJQuery("#commentstext").val(); 
		$myJQuery.getJSON(WebServiceURL + "?method=" + type + "&callback=?", { url: url, text: text, memberID: memberID},  function(data){ 
			var comments = data.result;
			$myJQuery("#trust-" + CommentID).html("Trusted");
		    $myJQuery("#trust-" + CommentID).removeClass("trust-btn");
		    $myJQuery("#trust-" + CommentID).addClass("trust-btn-disabled");			
		});
	}
	
	function ShowUIBox(data, timetofade)// for ajax
	{
	    var nx = x;
	    var ny = y;
	    $myJQuery("body").prepend("<div class = 'div-float-main' style = 'top:" + ny + "; left:" + nx + "; display:none; '>" +
		    "<div class = 'div-float-main-container'>" + 
		        "<div class = 'UI-box-content-middle'>" +
		            data +
		        "</div>" +
		    "</div>" +
			"<div class = 'UI-box-footer-bottom'></div>" +
		"<div>");
		$myJQuery(".div-float-main-container").show();
	    $myJQuery(".div-float-main").slideDown(timetofade);
	    var height = $myJQuery(".div-float-main-container").height();
	    $myJQuery(".div-float-main").css("top", (ny-(height+15)));
	    $myJQuery(".div-float-main").css("left", nx);

	    $myJQuery(".div-float-main").hover(function () 
        {
            isContainerFocused = true;
            //$myJQuery("#message-div").append("Set Container Focus True<br/>");
        }, function () 
        {
	        isContainerFocused = false;
	        hideFaceOnUnfocus();  
        });
	}
	
    function hideFaceOnUnfocus()
    {
        var animationTime = 500;
		var hideAfter = 1000;
		if($myJQuery(".UI-Faces-Only").size() > 0)
	    {	        
	        setTimeout(function() 
	        { 
	            if(!isContainerFocused)
	            {
	                $myJQuery('.div-float-main').fadeOut(animationTime);
	            }		            
	        }, hideAfter);
	    }
    }
	
	function hightlightCommentedText()
	{
		for(var i = 0; i < myElements.length; i++)
		{
			var highlightStartTag = "<span class = 'span-underline-commented-text'>";
			var highlightEndTag = "</span>";
			var str = decodeFromHex(myElements[i]);
			highlightSearchTerms(str, true, true, highlightStartTag, highlightEndTag)
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
		highlightStartTag = "<font style='color:blue; background-color:#FAE20D;'>";
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
	
	function GetUniqueSelectedText(selectedText)
	{
	    var range = selectedText.getRangeAt(0);
	    var d = '';
        if (range) 
        {
            var d = range.commonAncestorContainer.innerHTML ;//range.cloneContents();
            if(!d)
            {
                d = range.cloneContents();
                var div = document.createElement('div');
                div.appendChild(d);
                d=div.innerHTML;
            }
            if(d.length < 20)
            {
                d = range.commonAncestorContainer.parentElement.innerHTML;
            }
          }	    
		return d;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function encodeToHex(str)
	{
        var r="";
        var e=str.length;
        var c=0;
        var h;
        while(c<e){
            h=str.charCodeAt(c++).toString(16);
            while(h.length<4) h="0"+h;
            r+=h;
        }
        return r;
    }
    
    function decodeFromHex(str){
        var r='';
        var e=str.length;
        var s;
        while(e>=4)
        {
            s=e-4;
            r=String.fromCharCode("0x"+str.substring(s,e))+r;
            e=s;
        }
        return r;
    }
    
    function WaterMarkSource(txt, evt)
    {
	    var defaultText = "Type the name of a source";
	    if(txt.value.length == 0 && evt.type == "blur")
	    {
		    txt.style.color = "gray";
		    txt.value = defaultText;
	    }
	    if(txt.value == defaultText && evt.type == "focus")
	    {
		    txt.style.color = "black";
		    txt.value="";
	    }
    }
    
    function AttachMessageDivEvents(data, title)
    {
        $myjquery("#message-div").remove();
        if($myjquery("#message-div").size() == 0)
        {
            // add message div
            $myjquery("body").append('<div id = "message-div"><div class = "message-div-head"><div class = "title">' + title + '</div><img src = "' + rootURL + 'images/website/btn-cross.png" class = "btn-cross-head"/></div><div class = "cl" ></div><div class = "message-div-content"></div></div>');
        }
        $myjquery(".message-div-content").html(data);
        if($myjquery(".message-div-content").html() != "")
        {
            var wwidth = $myjquery(window).width();
            var y = 80;
            $myjquery("#message-div").css("top", y);
            $myjquery("#message-div").css("left", (wwidth - $myjquery("#message-div").width())/2);
            $myjquery("#message-div").show();
        }
        $myjquery(".btn-cross-head").click(function(){
            $myjquery("#message-div").hide();
        });
        $myjquery(document).mouseup(function(){
            if($myjquery("#message-div:hover").size() == 0)
            {
                $myjquery("#message-div").hide();
            }
        });
    }