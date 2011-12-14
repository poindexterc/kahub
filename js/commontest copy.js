var $myjquery = jQuery.noConflict();
//var sWebServiceURL = "http://localhost/connichiwah/webService/gen.php";
//var rootURL = "http://localhost/connichiwah/";
var sWebServiceURL = "http://www.kahub.com/webService/gen.php";
var rootURL = "http://www.kahub.com/";
var isRequesting = false;
$myjquery(document).ready(function(){
    AttachHelpHover();
    $myjquery('ul.sf-menu').superfish(); 
    $myjquery('ul.sf-menu2').superfish(); 
    $myjquery('textarea').elastic();
	$myjquery('textarea').trigger('update');
    $myjquery("textarea").blur(function(){
        if($myjquery(this).val()==""){
            $myjquery(".commentsBox").hide();
        }
    });
    
    $myjquery(".more").click(function(){
        
        if(!isRequesting)
        {
            isRequesting = true;
            
            $myjquery(".more").hide();
            $myjquery(".more-message").html("Loading...");
            $myjquery(".more-message").show();
            
            var limit = parseInt($myjquery("#limit").val());
            var offset = parseInt($myjquery("#offset").val());
            var totlalResults = parseInt($myjquery("#totlalResults").val());
            console.log(offset);
            console.log(totlalResults);
            if(offset < totlalResults)
            {
                $myjquery.ajax({
                    type: "POST",
                    url: sWebServiceURL + "?method=GetMoreStories",
                    data: "limit=" + limit + "&offset=" + offset,
                    success: function(data)
                    {
                        _kmq.push(['record', 'Continuous Click']);
                        $myjquery("#latest-stories").append(data);
                        $myjquery('textarea').elastic();
                    	$myjquery('textarea').trigger('update');
                    	$myjquery("textarea").blur(function(){
                            if($myjquery(this).val()==""){
                                $myjquery(".commentsBox").hide();
                            }
                        });
                        $myjquery("#offset").val(offset+limit);
                        
                        $myjquery(".more-message").html("");
                        $myjquery(".more-message ").hide();
                        $myjquery(".more").show();
                        
                        if(limit + offset >= totlalResults)
                        {
                            _kmq.push(['record', 'No More Stories']);
                            $myjquery(".more").hide();
                            $myjquery(".more-message").html("No More Results");
                            $myjquery(".more-message").show();
                        }
                        isRequesting = false;
                    }
                });
            }
            else
            {
                $myjquery(".more").hide();
                $myjquery(".more-message").html("No More Results");
                $myjquery(".more-message").show();
            }
        }
    });
    
    AttachMessageDivEvents($myjquery("#message-div").html(), '');
    
    $myjquery(document).mouseup(function(){
        hideSearchSuggestionBox();
    });
    
});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function WaterMark(txt, evt, textName)				
{				
	if(txt.value.length == 0 && evt.type == "blur")				
	{
		txt.style.color = "gray";
		txt.value = textName;				
	}				
	if(txt.value == textName && evt.type == "focus")				
	{
		txt.style.color = "black";	
		txt.value="";
	}
}

function logout()
{
    Delete_Cookie('ckSavePass', '/', 'www.kahub.com');
    _kmq.push(['record', 'Logout']);
	document.logoutform.submit();
	
}
// this deletes the cookie when called
function Delete_Cookie( name, path, domain ) 
{
    if ( Get_Cookie( name ) ) document.cookie = name + "=" + ( ( path ) ? ";path=" + path : "") + ( ( domain ) ? ";domain=" + domain : "" ) + ";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

function Get_Cookie( name )
{
    var start = document.cookie.indexOf( name + "=" );
    var len = start + name.length + 1;
    if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) )
    {
        return null;
    }
    if ( start == -1 ) return null;
    var end = document.cookie.indexOf( ";", len );
    if ( end == -1 ) end = document.cookie.length;
    return unescape( document.cookie.substring( len, end ) );
}

function putInURLGetStarted(url){
    $myjquery("#url").val(unescape(url));
    _kmq.push(['record', 'Clicked Premade URLs']);
    $myjquery("#getStartedWrapBox").html("<span class='getStartedHeadWrap'><div class='encouragement'>Great Job!</div> <br /><i>Now, click <b>Share</b> </i><div class='protip'><b>PRO TIP:</b> Did you know that you don't have to copy links to share at all? If you have our extension installed, all you have to do to share is <b>Highlight</b> some text, type your <b>Comment</b>, and that's it, you're <b>Done!</b></div></span><div class='clear'></div>");
    $myjquery("#getStartedWrapBox").effect("highlight", {}, 500);
    $myjquery("#getStartedWrapBox").effect("highlight", {}, 500);
}

function showProgressGetStarted(){
    var type = $myjquery("#comment").html();
    var typed = type.length;
    if(typed<10){
        var size = "5%";
    } else if(typed<17) {
        size = "11%";
    } else if(typed<43){
        size = "28%";
    } else if (typed<62){
        size = "46%";
    } else if (typed<73){
        size = "63%";
    } else if(typed<120) {
        size = "82%";
    } else if(typed<170) {
        size = "93%";
    } else if(typed<240) {
        size = "110%";
    }
    if ($myjquery("#getStartedWrapBox").length){
        $myjquery("#getStartedWrapBox").html("<span class='getStartedHeadWrap'><div class='encouragement'>Post Quality Index</div><div id='PostQualityScore' style='background-color: #17AD14; height: 30px; width: "+size+"'>"+size+"</div></div></span><div class='clear'></div>");
    }
}
function GetUserNameSuggestions(inputString) 
{        
	if(inputString != null && inputString.length == 0) 
	{
		$myjquery('#autoSuggestionsList').hide();
	}
    else
    {            
		$myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=GetUserNameSuggestions",
                    data: "txt=" + inputString,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {	
		        		    $myjquery('#autoSuggestionsList').html("<ul>" + data + "</ul>");
		        		    $myjquery('#autoSuggestionsList').slideDown("slow");
		            	}
                    }
                });
	}
}

function fill(memberID) 
{
    //selected_source_id = memberID;
    $myjquery("#member-id").val(memberID);
    var un = $myjquery("#user-name-suggestion-" + memberID).html();
    //selected_source_name = un;
	$myjquery('#txt-freind-name').val(un);
	hideSuggestionBox();
}

function hideSuggestionBox()
{
    setTimeout("$myjquery('#autoSuggestionsList').slideUp();", 200);
}


function GetSearchSuggestions(inputString) 
{        
	if(inputString != null && inputString.length == 0) 
	{
		$myjquery('#autoSuggestionsList').hide();
	}
    else
    {            
		$myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=GetSearchSuggestions",
                    data: "txt=" + inputString,
                    success: function(data)
                    {
                            _kmq.push(['record', 'Search']);
							if(inputString=="french army victories"){
									$myjquery('#search-autoSuggestionsList').html("<ul>" + data + "<li class='createhub'><div class='createHubSearch'>Did you mean <b>french army defeats</b>?</div></li></a></ul>");
							} else if(inputString=="ass") {
									$myjquery('#search-autoSuggestionsList').html("<ul>" + data + "<li class='createhub'><div class='createHubSearch'>'n titties. Ass, Ass 'n titties </div></li></a></ul>");
							} else if(inputString=="the black sheep is") {
											$myjquery('#search-autoSuggestionsList').html("<ul>" + data + "<li class='createhub'><div class='createHubSearch'>female</div></li></a></ul>");
							} else if(inputString=="booty cheeks") {
											$myjquery('#search-autoSuggestionsList').html("<ul>" + data + "<li class='createhub'><div class='createHubSearch'>Did you mean <b>Monil</b>?</div></li></a></ul>");
							} else {
								$myjquery('#search-autoSuggestionsList').html("<ul>" + data + "<a href='http://www.kahub.com/l/createHub?hName="+inputString+"'><li class='createhub'><div class='createHubSearch'>Create a topic hub for <b>"+inputString+"</b></a></div></li></a></ul>");
							}
		        		    $myjquery('#search-autoSuggestionsList').slideDown("fast");
                    }
                });
	}
}

function AddFriendFromSearch(memberID) 
{
    //$myjquery("#member-id").val(memberID);
    //var un = $myjquery("#user-name-suggestion-" + memberID).html();
	//$myjquery('#txt-freind-name').val(un);
	//hideSuggestionBox();
	
	var friendID = memberID;
    if(friendID > 0 )
    {
        $myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=AddFriend",
                    data: "friendID=" + friendID,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {
//                            $myjquery("#message-div").html(data);
                             $myjquery.notifyBar({html: data});
		            	}
                    }
                });
    }
}

function Followhub(memberID) 
{
    //$myjquery("#member-id").val(memberID);
    //var un = $myjquery("#user-name-suggestion-" + memberID).html();
	//$myjquery('#txt-freind-name').val(un);
	//hideSuggestionBox();
	
	var friendID = memberID;
    if(friendID > 0 )
    {
        $myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=followhub",
                    data: "friendID=" + friendID,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {
                            _kmq.push(['record', 'Follow Hub']);				
                            
//                            $myjquery("#message-div").html(data);
                            $myjquery.notifyBar({html: data});
		            	}
                    }
                });
    }
}
function FollowhubGetStarted(memberID) 
{
    //$myjquery("#member-id").val(memberID);
    //var un = $myjquery("#user-name-suggestion-" + memberID).html();
	//$myjquery('#txt-freind-name').val(un);
	//hideSuggestionBox();
	
	var friendID = memberID;
    if(friendID > 0 )
    {
        $myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=followhub",
                    data: "friendID=" + friendID,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {
                            _kmq.push(['record', 'Follow Hub Onboard']);				
//                            $myjquery("#message-div").html(data);
                            $myjquery.notifyBar({html: data});
                            $myjquery("#follow-"+memberID).html("<a class=\"follow phubpage following getstarted\">Following!</a>");
                            var handle = escape($myjquery('#handle').val());
                            $myjquery("#followCountInput").val("1");
                            var goodHandle = $myjquery("#goodHandle").val();
                            if(goodHandle==1){
                                $myjquery("#btnGetStarted").removeClass("inactive");
                            }
                            
		            	}
                    }
                });
    }
}
function unfollowHub(memberID) 
{
    //$myjquery("#member-id").val(memberID);
    //var un = $myjquery("#user-name-suggestion-" + memberID).html();
	//$myjquery('#txt-freind-name').val(un);
	//hideSuggestionBox();
	
	var friendID = memberID;
    if(friendID > 0 )
    {
        $myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=unfollowhub",
                    data: "friendID=" + friendID,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {
                            _kmq.push(['record', 'Unfollow Hub']);
//                            $myjquery("#message-div").html(data);
                            $myjquery.notifyBar({html: data});
		            	}
                    }
                });
    }
}

function NotificationStatus(nid)
{
    if(nid > 0 )
    {
        $myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=NotificationStatus",
                    data: "NID=" + nid,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {
                            _kmq.push(['record', 'ViewedNotification']);
                            _kmq.push(['record', 'Viewed notifyID '+nid]);
                            //AttachMessageDivEvents(data, 'Alert')
		            	}
                    }
                });
    }
}

function AcceptFriendRequest(memberID, nid)
{
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=AcceptFriendRequest",
            data: "memberID=" + memberID,
            success: function(data)
            {
                if(data.length >0) 
                {	
                    _kmq.push(['record', 'AcceptFriend']);				
        		    $myjquery('#c-' + nid).html('<div style = "padding-top:5px; color:Red; text-align:center;">' + data + '</div>');
            	}
            }
        });
}

function IgnoreFriendRequest(memberID, nid)
{
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=IgnoreFriendRequest",
            data: "memberID=" + memberID,
            success: function(data)
            {
                if(data.length >0) 
                {	
                    _kmq.push(['record', 'IgnoreFriend']);				
        		    $myjquery('#c-' + nid).html('<div style = "padding-top:5px; color:Red; text-align:center;">' + data + '</div>');
            	}
            }
        });
}

function BragMyBadgeHTML(badgeid)
{
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=BragMyBadgeHTML",
            data: 'badgeid='+badgeid,
            success: function(data)
            {
                if(data.length >0) 
                {					
        		    AttachMessageDivEvents(data, 'Brag');
            	}
            }
        });
}

function hideSearchSuggestionBox()
{
    if($myjquery("#search-suggestions:hover").size() == 0)
    {
        setTimeout("$myjquery('#search-autoSuggestionsList').slideUp();", 140);
    }
    
}

function hideBragSuggestionBox()
{
    if($myjquery("#source-suggestions-container:hover").size() == 0)
    {
        setTimeout("$myjquery('#source-suggestions').slideUp();", 200);
    }
}

function GetBragSuggestions(val)
{
    if(val != null && val.length == 0) 
	{
		$myjquery('#source-suggestions').hide();
	}
    else
    {            
		$myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=GetBragSuggestions",
                    data: "txt=" + val,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {					
		        		    $myjquery('#source-suggestions').html("<ul>" + data + "</ul>");
		        		    $myjquery('#source-suggestions').slideDown("slow");
		            	}
                    }
                });
	}
}

function fillBragTo(name, id)
{
    $myjquery("#sid-brag").val(id);
	$myjquery('#input-brag-to').val(name);
	hideBragSuggestionBox();
}

function BragToMyFriend()
{
    var fid = $myjquery("#sid-brag").val();
	var bid = $myjquery('#badge-id').val();
	$myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=BragToMyFriend",
                    data: "fid=" + fid + "&bid=" + bid,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {					
		        		    AttachMessageDivEvents(data, 'Message');
		            	}
                    }
                });
}

function GetMoreBadges(offset, limit)
{
    //var limit = parseInt($myjquery("#limit").val());
    //var offset = parseInt($myjquery("#offset").val());
    $myjquery.ajax(
            {
                type: "POST",
                url: sWebServiceURL + "?method=GetMoreBadges",
                data: "limit=" + limit + "&offset=" + offset,
                success: function(data)
                {
                    $myjquery(".more-badges-btn").remove();
                    $myjquery(".badges-tab").append(data);
                }
            });
}


function GetPopUpLightBox(src, minwidth, minheight, type)
{
	var url = rootURL + "crop/GenerateThumbnail.php?imgurl="+src+"&x="+minwidth+"&y="+minheight+"&t="+type;
	var left = (screen.width/2)-(800/2);
    var top = (screen.height/2)-(600/2);
    
    //var targetWin = window.open(url, "Cr", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=800, height=600, top='+top+', left='+left);
    var targetWin = window.open(url, "Cr", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no');    
}


function AddFriend()
{
    var friendID = $myjquery("#member-id").val();
    if(friendID > 0 )
    {
        $myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=AddFriend",
                    data: "friendID=" + friendID,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {					
//		        		    $myjquery("#message-div").html(data); 
//                            var wwidth = $myjquery(window).width();
//		                    y = 200;
//		                    $myjquery("#message-div").css("top", y);
//	                        $myjquery("#message-div").css("left", (wwidth - $myjquery("#message-div").width())/2);
//                            $myjquery("#message-div").show();
                            AttachMessageDivEvents(data, '');
							$myjquery('#search-autoSuggestionsList').slideUp();
		            	}
                    }
                });
    }
}

function AddNewEmailRow()
{
    $myjquery("#plus-btn").remove();
    var cnt = parseInt($myjquery("#total-no-of-addresses").val()) + 1;
    
    $myjquery("#email-data-container").append(  '<input id = "email-id-' + cnt + '" type="text" value="Email Address (optional)" class="reg1-textfield" onblur="WaterMark(this, event, \'Email Address (optional)\');" onfocus="WaterMark(this, event, \'Email Address (optional)\');" onchange = "CheckEmail(this.value, \'Email Address\', \'ok-' + cnt + '\')"/>' +       
					                            '<input id = "description-' + cnt + '" type="text" value="What are they in to? (optional)" class="reg1-textfield" onblur="WaterMark(this, event, \'What are they in to? (optional)\'); hideIntoOptionBox(1);" onfocus="WaterMark(this, event, \'What are they in to? (optional)\');" onkeyup="GetOptionSuggestions(this.value, ' + cnt + ')"/>' +		            
					                            '<img id = "plus-btn" alt="" src="' + rootURL + 'images/website/plus-btn.jpg" class="middle" onclick = "AddNewEmailRow()"/>' +		            
					                            '<img alt="" id = "ok-' + cnt + '" src="' + rootURL + 'images/website/tick-btn-green.jpg" class="reg1-tick"/>');
    $myjquery("#total-no-of-addresses").val(cnt)
}


function AddMultipleFriends()
{
    var mdata = '';
    $myjquery(".email").each(function(){
        var emid = $myjquery(this).attr("id");
        emid = emid.replace("email-", "");
        var email = $myjquery(this).val();
        if(isValidEmailAddress(email))
        {
            var description = $myjquery("#description-" + emid).val();
            var emailHex = encodeToHex(email);
            var descHex = encodeToHex(description);
            mdata += emailHex + ':' + descHex + ','
        }
    });

    $myjquery.ajax(
            {
                type: "POST",
                url: sWebServiceURL + "?method=AddMultipleFriends",
                data: "data=" + mdata,
                success: function(data)
                {
//                    $myjquery("#message-div").html(data);                    
                    $myjquery.notifyBar({html: data});
                    setTimeout ( "GoToURL('" + rootURL + "member/Registration.php?action=2')", 2000 );                   
                }
            });

}

function AddMultipleFriendsHome()
{
    var mdata = '';
    $myjquery(".email").each(function(){
        var emid = $myjquery(this).attr("id");
        emid = emid.replace("email-", "");
        var email = $myjquery(this).val();
        if(isValidEmailAddress(email))
        {
            var description = "null";
            var emailHex = encodeToHex(email);
            var descHex = encodeToHex(description);
            mdata += emailHex + ':' + descHex + ','
        }
    });

    $myjquery.ajax(
            {
                type: "POST",
                url: sWebServiceURL + "?method=AddMultipleFriends",
                data: "data=" + mdata,
                success: function(data)
                {
//                    $myjquery("#message-div").html(data);                    
                    $myjquery.notifyBar({html: "You have requested to add some sources!"});
                    setTimeout ( "GoToURL('" + rootURL + "member/index.php')", 2000 );                   
                }
            });

}

function AddFacebookFriends(redirect)
{
    var mdata = '';
    $myjquery(".fb_user_friend").each(function(){
        if($myjquery(this).is(':checked'))
        {
            var emid = $myjquery(this).val();
            mdata += emid + ",";
        }
    });
    
    $myjquery.ajax(
            {
                type: "POST",
                url: sWebServiceURL + "?method=AddFacebookFriends",
                data: "data=" + mdata,
                success: function(data)
                {
//                    $myjquery("#message-div").html(data);                    
                    $myjquery.notifyBar({html: "You've requested to add some sources!"});
                    if(redirect)
                    {
                        setTimeout ( "GoToURL('" + rootURL + "member/Registration.php?action=1')", 2000 );     
                    }              
                }
            });
}

function GoToURL(newURL)
{
  window.location= newURL;
}

function notifications(type)
{
    $myjquery.ajax(
            {
                type: "POST",
                url: sWebServiceURL + "?method=GetNotifications",
                data: "type=" + type,
                success: function(data)
                {
                    if(data.length >0) 
                    {	
	        		    $myjquery('#sb-top-content').html(data);
	        		    AttachHelpHover();
	        		    //$myjquery('#autoSuggestionsList').slideDown("slow");
	            	}
                }
            });
    
}

function isValidEmailAddress(email)
{    
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if(reg.test(email) == false) 
    {
        return false;
    }
    else
    {
        return true;
    }
    
}

function CheckEmail(email, cText, imgid)
{
    if(isValidEmailAddress(email))
    {
        // show tick sign
        $myjquery("#" + imgid).attr("src", rootURL + "images/website/tick-btn-green.jpg");
        $myjquery("#" + imgid).show();
    }
    else if(email == cText || email == "")
    {
        $myjquery("#" + imgid).hide();
    }
    else
    {
        // show cross sign
        $myjquery("#" + imgid).attr("src", rootURL + "images/website/cross-btn-green.png");
        $myjquery("#" + imgid).show();
    }
}

function CheckPhotoSize()
{
    
    return true;
}

function StoryClick(sid)
{
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=StoryClick",
            data: "storyid=" + sid,
            success: function(data)
            {					
                _kmq.push(['record', 'ClickStory']);
            }
        });
}

function LikeStory(storyid, url)
{
	$myjquery("#Like-Story-Link-" + storyid).html('<img class = "story-like-image" src = "' + rootURL + 'images/website/likeloading.gif" alt = "" />');
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=LikeStory",
            data: "storyid=" + storyid,
            success: function(data)
            {
                if(data.length >0) 
                {					
        		    if(data == "liked")
        		    {
						var urld = decodeFromHex(url);
						_kmq.push(['record', 'FavStream']);
        		        $myjquery("#Like-Story-Link-" + storyid).removeAttr("href");
						$myjquery.notifyBar({ html: "Added to Favs Stream! <a onClick='window.open(\"http://www.kahub.com/l/readlater.php?url="+urld+"\",\"Favstream\", \"width=875,height=496,left=0,top=100,screenX=0,screenY=100\")'>Send to Instapaper/Read it Later</a>", close: true, delay: 10000 });
        		        $myjquery("#Like-Story-Link-" + storyid).html('<img class = "story-like-image" src = "' + rootURL + 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />');
        		    }
            	}
            } 

        });
}
function pinComment(commentID, hubID)
{
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=pinComment",
            data: "commentID=" + commentID + "&hubID=" + hubID,
            success: function(data)
            {
                if(data.length >0) 
                {					
					console.log(data);
        		    if(data == "pinned")
        		    {
						_kmq.push(['record', 'Pin']);
						$myjquery.notifyBar({ html: "Oh yea! Pinned!", close: true, delay: 5000 });
        		    } else{
						$myjquery.notifyBar({ html: "Crap! Something went wrong", close: true, delay: 5000 });
						
					}
            	}
            } 

        });
}
function unpinComment(commentID, hubID)
{
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=unpinComment",
            data: "commentID=" + commentID + "&hubID=" + hubID,
            success: function(data)
            {
                if(data.length >0) 
                {					
					console.log(data);
        		    if(data == "unpinned")
        		    {
        		        
						_kmq.push(['record', 'Unpin']);  
						$myjquery.notifyBar({ html: "Nah nah nah nah, nah nah nah nah, hey hey hey, unpinned!", close: true, delay: 5000 });
        		    } else{
						$myjquery.notifyBar({ html: "Crap! Something went wrong, its probably Pinsky's fault.", close: true, delay: 5000 });
						
					}
            	}
            } 

        });
}
function RestateComment(storyid, url, commentID, author)
{
    console.log("restatestart");
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=RestateComment",
            data: "commentID=" + commentID,
            success: function(data)
            {
				console.log("reswin1");
                if(data.length >0) 
                {	
					console.log("reswin2");
					console.log(data);
        		    if(data == "restated")
        		    {
						console.log("reswin3");
						var urld = decodeFromHex(url);
						console.log("restated");
						var comment = "hello";
						_kmq.push(['record', 'Restate']);
        		        $myjquery("#restate-Story-Link-" + storyid).removeAttr("href");
						$myjquery.notifyBar({ html: "Restated! <a onClick='window.open(\"http://www.kahub.com/l/restate.php?url="+urld+"&cID="+commentID+"&a="+author+"\",\"Favstream\", \"width=779,height=345,left=0,top=100,screenX=0,screenY=100\")'>Restate on Facebook/Twitter/Tumblr</a>", close: true, delay: 10000 });
        		        $myjquery("#Like-Story-Link-" + storyid).html('<img class = "story-like-image" src = "' + rootURL + 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />');
        		    }
            	}	else {
					$myjquery.notifyBar({ html: "Holy JS error, Batman! Something went wrong. It was most likely Larry's fault.", close: true, delay: 5000 });

				}
            }
        });
}
function PromoteStory(storyid, url)
{
    console.log("promostart");
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=PromoteStory",
            data: "storyID=" + storyid,
            success: function(data)
            {
				console.log("promowin1");
                if(data.length >0) 
                {	
					console.log("promowin2");
					console.log(data);
        		    if(data == "promoted")
        		    {
						console.log("promowin3");
						var urld = decodeFromHex(url);
						console.log("promoted");
        		        $myjquery("#promote-Story-Link-" + storyid).removeAttr("href");
        		         _kmq.push(['record', 'Promote']);
						$myjquery.notifyBar({ html: "Promoted! <a onClick='window.open(\"http://www.kahub.com/l/promote.php?sID="+storyid+"\",\"Favstream\", \"width=779,height=345,left=0,top=100,screenX=0,screenY=100\")'>Promote on Facebook/Twitter/Tumblr</a>", close: true, delay: 10000 });
        		        $myjquery("#Like-Story-Link-" + storyid).html('<img class = "story-like-image" src = "' + rootURL + 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />');
        		    }
            	} else{
					$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Boffs fault.", close: true, delay: 5000 });
					
				}
            }
        });
}
function PromoteStoryButton(storyid)
{
    console.log("promostart");
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=PromoteStory",
            data: "storyID=" + storyid,
            success: function(data)
            {
				console.log("promowin1");
                if(data.length >0) 
                {	
					console.log("promowin2");
					console.log(data);
        		    if(data == "promoted")
        		    {
						console.log("promowin3");
						console.log("promoted");
						_kmq.push(['record', 'PromoteBtn']);
        		        $myjquery("#promote-Story-Link-" + storyid).removeAttr("href");
        		        $myjquery("#Like-Story-Link-" + storyid).html('<img class = "story-like-image" src = "' + rootURL + 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />');
        		    }
            	} else{
					
				}
            }
        });
}


function inlineReply(storyid, url, commentID)
{
	var comment = escape($myjquery('#comments-text-area-'+commentID).val());
	console.log(comment);
	
    console.log("replystart");
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=inlineReply",
            data: "commentID=" + commentID + "&comment=" + escape(comment),
            success: function(data)
            {
				console.log("commentwin1");
                if(data.length >0) 
                {	
					console.log("commentwin2");
					console.log(data);
        		    if(data == "replied")
        		    {
						console.log("commentwin3");
						var urld = decodeFromHex(url);
						console.log("commented");
						_kmq.push(['record', 'Reply']);
        		        $myjquery("#reply-Story-Link-" + storyid).removeAttr("href");
						$myjquery.notifyBar({ html: "Yay! Comment Posted! <a onClick='window.open(\"http://www.kahub.com/l/social.php?c="+comment+"&cID="+commentID+"\",\"Favstream\", \"width=779,height=345,left=0,top=100,screenX=0,screenY=100\")'>Post to Facebook/Twitter/Tumblr</a>", close: true, delay: 10000 });
        		    } else{
						$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Charlie Sheen's fault.", close: true, delay: 5000 });
					}
            	} else{
					$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Boffs fault.", close: true, delay: 5000 });
					
				}
            }
        });
}
function PostStory(storyid, url, CommentID)
{
	var comment = escape($myjquery('#comments-text-area-'+CommentID).val());
	console.log(comment);
	
    console.log("replystart");
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=PostStory",
            data: "storyID=" + storyid + "&comment=" + escape(comment),
            success: function(data)
            {
				console.log("commentwin1");
                if(data.length >0) 
                {	
					console.log("commentwin2");
					console.log(comment);
        		    if(data == "commented")
        		    {
						console.log("commentwin3");
						var urld = decodeFromHex(url);
						console.log("commented");
						_kmq.push(['record', 'Comment']);
        		        $myjquery("#reply-Story-Link-" + storyid).removeAttr("href");
						$myjquery.notifyBar({ html: "Yay! Comment Posted! <a onClick='window.open(\"http://www.kahub.com/l/social.php?c="+comment+"&cID="+CommentID+"\",\"Favstream\", \"width=779,height=345,left=0,top=100,screenX=0,screenY=100\")'>Post to Facebook/Twitter/Tumblr</a>", close: true, delay: 10000 });
        		    } else{
					$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Charlie Sheen's fault.", close: true, delay: 5000 });
					}
            	} else{
					$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Boffs fault.", close: true, delay: 5000 });
					
				}
            }
        });
}
function checkUser()
{
	var handle = escape($myjquery('#handle').val());
	console.log(handle);
    console.log("handlestart");
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=checkUser",
            data: "handle=" + handle,
            success: function(data)
            {
				console.log("handlewin1");
                if(data.length >0) 
                {	
					console.log("handlewin2");
        		    if(data == 1)
        		    {
						$myjquery('#check').html("Handle already taken!");
						$myjquery("#btnGetStarted").addClass("inactive");
						$myjquery("#goodHandle").val("0");
						_kmq.push(['record', 'InvalidHandle']);
    					
        		    } else{
					    $myjquery('#check').html("Looks great!");
					    $myjquery("#goodHandle").val("1");
					    _kmq.push(['record', 'ValidHandle']);
					    var follow = $myjquery("#followCountInput").val();
					    if(follow==1){
					        $myjquery("#btnGetStarted").removeClass("inactive");
					        _kmq.push(['record', 'Properly Finished Oboard']);
					    }
					}
            	} else{
            	    _kmq.push(['record', 'Handle Error']);
					$myjquery('#check').html("Something went wrong!");
					$myjquery("#btnGetStarted").addClass("inactive");
					$myjquery("#goodHandle").val("0");
					
				}
            }
        });
}
function saveHandle()
{
	var handle = escape($myjquery('#handle').val());
	var goodHandle = $myjquery("#goodHandle").val();
	console.log(handle);
    console.log("saveHandleStart");
    if(handle.length>0&&goodHandle==1){
	    $myjquery.ajax(
            {
                type: "POST",
                url: sWebServiceURL + "?method=saveHandle",
                data: "handle=" + handle,
                success: function(data)
                {
				    console.log("savehandlewin1");
				    console.log(data);
                    if(data.length >0) 
                    {	
					    console.log("savehandlewin2");
        		        if(data == 1)
        		        {   
        		            _kmq.push(['record', 'GoodHandleOnboard']);
        		            window.location.href="http://www.kahub.com/l";
        		            $myjquery("#getStartedBtn").html("<a class=\"button getStarted\">Feching your stories...</a>");
        		            
        		       
        		        }else{
					        //window.location.href="http://www.kahub.com/l";
					        $myjquery("#getStartedBtn").html("<a class=\"button getStarted\">Not sure your username is ok.</a>");
					    }
            	    }else{
					    //window.location.href="http://www.kahub.com/l";
					    $myjquery("#getStartedBtn").html("<a class=\"button getStarted\">Something went terribly wrong!</a>");
				    }   
                }
            });
        } else {
            _kmq.push(['record', 'BadHandleOnboard']);
        } 
}
function PostStoryHub(storyid)
{
	var comment = escape($myjquery('#comment').html());
	console.log(comment);
    console.log("replystart");
	if(comment=="NULL"){
		$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Rebecca Black's fault.", close: true, delay: 5000 });
		return false;
	}
	if(comment.length<3){
	    return false;
	}
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=PostStoryHub",
            data: "storyID=" + storyid + "&comment=" + escape(comment),
            success: function(data)
            {
				console.log("commentwin1");
                if(data.length >0) 
                {	
					console.log("commentwin2");
					console.log(data);
        		    if(data == "commentedcommented")
        		    {
						console.log("commentwin3");
						console.log("commented");
						_kmq.push(['record', 'CommentPublic']);
        		        $myjquery("#reply-Story-Link-" + storyid).removeAttr("href");
						$myjquery.notifyBar({ html: "Yay! Comment Posted! <a onClick='window.open(\"http://www.kahub.com/l/social.php?c="+comment+"&sID="+storyid+"\",\"Favstream\", \"width=779,height=345,left=0,top=100,screenX=0,screenY=100\")'>Post to Facebook/Twitter/Tumblr</a>", close: true, delay: 10000 });
						
        		    } else{
					$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Charlie Sheen's fault.", close: true, delay: 5000 });
					}
            	} else{
					$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Boffs fault.", close: true, delay: 5000 });
					
				}
            }
        });
}

function GetStoryData(storyid)
{
	$myjquery("#dark-gray-heading").html("<a href='#'>Loading Story...</a>");
	$myjquery(".dark-gray-img").html("<img src='http://www.kahub.com/l/placeholderImage.png'>");
	
    //alert("hi");
    $myjquery.ajax(
        {            
            type: "POST",
            url: sWebServiceURL + "?method=GetStoryData",
            data: "storyid=" + storyid,            
            success: function(data)
            {
                $myjquery("#dark-gray-heading").html("<a href = 'http://www.kahub.com/anyShare/index.php?ref=hero_headline&rand=0&rURL=" + $myjquery(data).find('url').text() + "' target='_blank'>" + $myjquery(data).find('stitle').text() + "</a>");
                var tags = $myjquery(data).find('tags').text().trim();
				var cat = $myjquery(data).find('categoryID').text();
				var title = $myjquery(data).find('stitle').text()
                $myjquery(".light-gray-box-img").attr("src", $myjquery(data).find('imgMember').text());
                $myjquery(".box-member-comment-text").html($myjquery(data).find('comment').text() + "<a class = 'box-member-comment-read-more' href = 'http://www.kahub.com/anyShare/index.php?ref=hero_read_more&rand=0&rURL=" + $myjquery(data).find('url').text() + "'  target='_blank'>read more...</a>");
                if(tags.length >0) 
                {
                    var src = $myjquery("#box-" + storyid).attr("src");
                    if(src.length>5)
                    {
                        var index = src.length - 5;
                        src = src.substr(0, index) + 'z' + src.substr(index + 1);
                    }
                    $myjquery("#img-left").attr("src", src);
                    $myjquery("#img-left").fadeIn("slow"); 
                    
                    
                    $myjquery(".rail-box").removeClass("thumb-sel");
                    $myjquery(".rail-box").removeClass("box-normal");                    
                    $myjquery(".rail-box").addClass("box-normal");
                    //$myjquery("#box-link-" + storyid).removeClass("box-normal");
                    $myjquery("#box-link-" + storyid).removeClass("box-normal"); 
                    $myjquery("#box-link-" + storyid).addClass("thumb-sel");
                    
                    //$myjquery(".dot-box").removeClass("dot-click");
                    //$myjquery(".dot-box").removeClass("dot-normal");                    
                    //$myjquery(".dot-box").addClass("dot-normal");
                    //$myjquery("#dot-" + storyid).removeClass("dot-normal"); 
                    //$myjquery("#dot-" + storyid).addClass("dot-click");                    				
        		    setIntervalFlickerImages(tags);        		    
            	}
				if(cat=="1 "){
					document.getElementById("dark-gray-heading").style.background = "#39B54A";
				} else if(cat=="2 ") {
					document.getElementById("dark-gray-heading").style.background = "#009245";
				} else if(cat=="3 ") {
					document.getElementById("dark-gray-heading").style.background = "#3FA9F5";
				} else if(cat=="4 ") {
					document.getElementById("dark-gray-heading").style.background = "#F15A24";
				} else if(cat=="5 ") {
					document.getElementById("dark-gray-heading").style.background = "#702C8D";
				} else if(cat=="6 ") {
					document.getElementById("dark-gray-heading").style.background = "#C1172C";
				} else if(cat=="7 ") {
					document.getElementById("dark-gray-heading").style.background = "#4D4D4D";
				} else if(cat=="8 ") {
					document.getElementById("dark-gray-heading").style.background = "#00A9A3";
				} else if(cat=="9 ") {
					document.getElementById("dark-gray-heading").style.background = "#C0311A";
				} else if(cat=="10 ") {
					document.getElementById("dark-gray-heading").style.background = "#0071B5";
				} else if(cat=="11 ") {
					document.getElementById("dark-gray-heading").style.background = "#39B54A";
				} else if(cat=="12 ") {
					document.getElementById("dark-gray-heading").style.background = "#00A055";
				} else if(cat=="13 ") {
					document.getElementById("dark-gray-heading").style.background = "#39B54A";
				} else if(cat=="14 ") {
					document.getElementById("dark-gray-heading").style.background = "#00A9A3";
				} else if(cat=="15 ") {
					document.getElementById("dark-gray-heading").style.background = "#FBB03B";
				} else if(cat=="16 ") {
					document.getElementById("dark-gray-heading").style.background = "#6DC065";
				} else if(cat=="17 ") {
					document.getElementById("dark-gray-heading").style.background = "#FF3333";
				} else if(cat=="18 ") {
					document.getElementById("dark-gray-heading").style.background = "#A967AA";
				} else if(cat=="19 ") {
					document.getElementById("dark-gray-heading").style.background = "#EC008C";
				} else if(cat=="20 ") {
					document.getElementById("dark-gray-heading").style.background = "#8C6239";
				} else if(cat=="21 ") {
					document.getElementById("dark-gray-heading").style.background = "#29ABE2";
				} else if(cat=="22 ") {
					document.getElementById("dark-gray-heading").style.background = "#42210B";
				} else if(cat=="23 ") {
					document.getElementById("dark-gray-heading").style.background = "#C1272D";
				} else if(cat=="24 ") {
					document.getElementById("dark-gray-heading").style.background = "#B55232";
				} else if(cat=="25 ") {
					document.getElementById("dark-gray-heading").style.background = "#02542B";
				} else {
					document.getElementById("dark-gray-heading").style.background = "#333";
				}
            }
        });
}

function setIntervalFlickerImages(tags)
{
    $myjquery("#flicker-images").html("");
    var  furl = "http://api.flickr.com/services/rest/";
    $myjquery.getJSON(furl + "?method=flickr.photos.search&callback=?", {
                api_key: '90485e931f687a9b9c2a66bf58a3861a', 
                format: 'json',
                tags: tags,
                safe_search: 1,
                content_type: 1,
                sort: 'relevance',
				is_getty: true,
                per_page: 55
            
            });
}

function jsonFlickrApi(data)
{
    $myjquery("#flicker-images").html("");
    $myjquery(data.photos.photo).each(function(index){
        if(index == 0)
        {
            var src = "http://farm" + this.farm +
                      ".static.flickr.com/" + this.server +
                      "/" + this.id +
                      "_" + this.secret +
                      "_z.jpg";
            //$myjquery("#img-left").attr("src", src);
            //$myjquery("#img-left").fadeIn("slow");
        }
        else
        {
            var src = "http://farm" + this.farm +
                      ".static.flickr.com/" + this.server +
                      "/" + this.id +
                      "_" + this.secret +
                      "_s.jpg";
            $myjquery("#flicker-images").append('<img src = "' +  src + '" alt = "" onerror="this.src=\'http://www.kahub.com/l/placeholderImageSmall.png\'"/>');
        }
        
    });
}

function AttachHelpHover()
{
    $myjquery(".help").hover(function(){
        x = $myjquery(this).offset().left;
		y = $myjquery(this).offset().top;
		var thisid = $myjquery(this).attr("alt");
		$myjquery("." + thisid + "-help").css("top", ($myjquery(this).offset().top)-$myjquery("." + thisid + "-help").height());
	    $myjquery("." + thisid + "-help").css("left", ($myjquery(this).offset().left)-13);
        $myjquery("." + thisid + "-help").show();
    }, 
    function(){
        var thisid = $myjquery(this).attr("alt");
        setTimeout(function(){$myjquery("." + thisid + "-help").hide();}, 1000);
    });
    
    $myjquery(".hide-help").click(function(){
        $myjquery(".help-box").hide();    
    });
}

function AttachMessageDivEvents(data, title)
{
    $myjquery("#message-div").remove();
    if($myjquery("#message-div").size() == 0)
    {
        // add message div
        $myjquery("body").append('<div id = "message-div"><div class = "message-div-head"><div class = "title">' + title + '</div><span class = "btn-cross-head">Close &#215;</div><div class = "cl" ></div><div class = "message-div-content"></div></div>');
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

function hideIntoOptionBox(bNo)
{
    if($myjquery("#into-autoSuggestionsList:hover").size() == 0)
    {
        setTimeout("$myjquery('#into-autoSuggestionsList').slideUp();", 200);
    }
}

function GetOptionSuggestions(val, bNo)
{
    if(val != null && val.length == 0) 
	{	
		$myjquery('#into-autoSuggestionsList').hide();
	}
    else
    {        
		$myjquery.ajax(
                {
                    type: "POST",
                    url: sWebServiceURL + "?method=GetCategorySuggestions",
                    data: "txt=" + val + "&bno=" + bNo,
                    success: function(data)
                    {
                        if(data.length >0) 
                        {
                            var top = 25;
                            if(bNo > 1)
                            {
                                top = 25 + (34 * (bNo - 1));
                            }
                            $myjquery('#into-autoSuggestionsList').css('top', top);					
		        		    $myjquery('#into-autoSuggestionsList').html("<ul>" + data + "</ul>");
		        		    $myjquery('#into-autoSuggestionsList').slideDown("slow");
		            	}
		            	else
		            	{
		            	    $myjquery('#into-autoSuggestionsList').slideUp('slow');
		            	}
                    }
                });
	}
}

function SetCategory(valu, bNo)
{
    $myjquery('#description-' + bNo).val(valu);
    $myjquery('#into-autoSuggestionsList').slideUp('slow');
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
$myjquery(function() {
	$myjquery("#dropbox").html5Uploader({
		name: "uploadedfile",
		postUrl: "upload.php"
		
	});
});
/**
*	@name							Elastic
*	@descripton						Elastic is jQuery plugin that grow and shrink your textareas automatically
*	@version						1.6.10
*	@requires						jQuery 1.2.6+
*
*	@author							Jan Jarfalk
*	@author-email					jan.jarfalk@unwrongest.com
*	@author-website					http://www.unwrongest.com
*
*	@licence						MIT License - http://www.opensource.org/licenses/mit-license.php
*/

(function(jQuery){ 
	jQuery.fn.extend({  
		elastic: function() {
		
			//	We will create a div clone of the textarea
			//	by copying these attributes from the textarea to the div.
			var mimics = [
				'paddingTop',
				'paddingRight',
				'paddingBottom',
				'paddingLeft',
				'fontSize',
				'lineHeight',
				'fontFamily',
				'width',
				'fontWeight',
				'border-top-width',
				'border-right-width',
				'border-bottom-width',
				'border-left-width',
				'borderTopStyle',
				'borderTopColor',
				'borderRightStyle',
				'borderRightColor',
				'borderBottomStyle',
				'borderBottomColor',
				'borderLeftStyle',
				'borderLeftColor'
				];
			
			return this.each( function() {
				
				// Elastic only works on textareas
				if ( this.type !== 'textarea' ) {
					return false;
				}
					
			var $textarea	= jQuery(this),
				$twin		= jQuery('<div />').css({'position': 'absolute','display':'none','word-wrap':'break-word'}),
				lineHeight	= parseInt($textarea.css('line-height'),10) || parseInt($textarea.css('font-size'),'10'),
				minheight	= parseInt($textarea.css('height'),10) || lineHeight*3,
				maxheight	= parseInt($textarea.css('max-height'),10) || Number.MAX_VALUE,
				goalheight	= 0;
				
				// Opera returns max-height of -1 if not set
				if (maxheight < 0) { maxheight = Number.MAX_VALUE; }
					
				// Append the twin to the DOM
				// We are going to meassure the height of this, not the textarea.
				$twin.appendTo($textarea.parent());
				
				// Copy the essential styles (mimics) from the textarea to the twin
				var i = mimics.length;
				while(i--){
					$twin.css(mimics[i].toString(),$textarea.css(mimics[i].toString()));
				}
				
				// Updates the width of the twin. (solution for textareas with widths in percent)
				function setTwinWidth(){
					curatedWidth = Math.floor(parseInt($textarea.width(),10));
					if($twin.width() !== curatedWidth){
						$twin.css({'width': curatedWidth + 'px'});
						
						// Update height of textarea
						update(true);
					}
				}
				
				// Sets a given height and overflow state on the textarea
				function setHeightAndOverflow(height, overflow){
				
					var curratedHeight = Math.floor(parseInt(height,10));
					if($textarea.height() !== curratedHeight){
						$textarea.css({'height': curratedHeight + 'px','overflow':overflow});
						
						// Fire the custom event resize
						$textarea.trigger('resize');
						
					}
				}
				
				// This function will update the height of the textarea if necessary 
				function update(forced) {
					
					// Get curated content from the textarea.
					var textareaContent = $textarea.val().replace(/&/g,'&amp;').replace(/ {2}/g, '&nbsp;').replace(/<|>/g, '&gt;').replace(/\n/g, '<br />');
					
					// Compare curated content with curated twin.
					var twinContent = $twin.html().replace(/<br>/ig,'<br />');
					
					if(forced || textareaContent+'&nbsp;' !== twinContent){
					
						// Add an extra white space so new rows are added when you are at the end of a row.
						$twin.html(textareaContent+'&nbsp;');
						
						// Change textarea height if twin plus the height of one line differs more than 3 pixel from textarea height
						if(Math.abs($twin.height() + lineHeight - $textarea.height()) > 3){
							
							var goalheight = $twin.height()+lineHeight;
							if(goalheight >= maxheight) {
								setHeightAndOverflow(maxheight,'auto');
							} else if(goalheight <= minheight) {
								setHeightAndOverflow(minheight,'hidden');
							} else {
								setHeightAndOverflow(goalheight,'hidden');
							}
							
						}
						
					}
					
				}
				
				// Hide scrollbars
				$textarea.css({'overflow':'hidden'});
				
				// Update textarea size on keyup, change, cut and paste
				$textarea.bind('keyup change cut paste', function(){
					update(); 
				});
				
				// Update width of twin if browser or textarea is resized (solution for textareas with widths in percent)
				$myjquery(window).bind('resize', setTwinWidth);
				$textarea.bind('resize', setTwinWidth);
				$textarea.bind('update', update);
				
				// Compact textarea on blur
				$textarea.bind('blur',function(){
					if($twin.height() < maxheight){
						if($twin.height() > minheight) {
							$textarea.height($twin.height());
						} else {
							$textarea.height(minheight);
						}
					}
				});
				
				// And this line is to catch the browser paste event
				$textarea.bind('input paste',function(e){ setTimeout( update, 250); });				
				
				// Run update once when elastic is initialized
				update();
				
			});
			
        } 
    }); 
})(jQuery);