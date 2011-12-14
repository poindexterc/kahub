var $myjquery = jQuery.noConflict();
//var sWebServiceURL = "http://localhost/connichiwah/webService/gen.php";
//var rootURL = "http://localhost/connichiwah/";
var sWebServiceURL = "http://www.connichiwah.com/webService/gen.php";
var rootURL = "http://www.connichiwah.com/";
var isRequesting = false;
$myjquery(document).ready(function(){
    AttachHelpHover();    
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
            if(offset < totlalResults)
            {
                $myjquery.ajax({
                    type: "POST",
                    url: sWebServiceURL + "?method=GetMoreStories",
                    data: "limit=" + limit + "&offset=" + offset,
                    success: function(data)
                    {
                        $myjquery("#latest-stories").append(data);
                        $myjquery("#offset").val(offset+limit);
                        
                        $myjquery(".more-message").html("");
                        $myjquery(".more-message ").hide();
                        $myjquery(".more").show();
                        
                        if(limit + offset >= totlalResults)
                        {
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
    
    AttachMessageDivEvents($myjquery("#message-div").html(), 'Alert');
    
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
    Delete_Cookie('ckSavePass', '/', 'www.connichiwah.com');
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
                        if(data.length >0) 
                        {					
		        		    $myjquery('#search-autoSuggestionsList').html("<ul>" + data + "</ul>");
		        		    $myjquery('#search-autoSuggestionsList').slideDown("slow");
		            	}
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
                            AttachMessageDivEvents(data, 'Alert')
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
        setTimeout("$myjquery('#search-autoSuggestionsList').slideUp();", 200);
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
                            AttachMessageDivEvents(data, 'Alert');
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
					                            '<input id = "description-' + cnt + '" type="text" value="What are they in to? (optional)" class="reg1-textfield" onblur="WaterMark(this, event, \'What are they in to? (optional)\');" onfocus="WaterMark(this, event, \'What are they in to? (optional)\');"/>' +		            
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
                    AttachMessageDivEvents(data, 'Alert');
                    setTimeout ( "GoToURL('" + rootURL + "member/Registration.php?action=2')", 2000 );                   
                }
            });

}

function AddFacebookFriends()
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
                    AttachMessageDivEvents(data, 'Alert');
                    setTimeout ( "GoToURL('" + rootURL + "member/Registration.php?action=1')", 2000 );                   
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
                //alert(data);
            }
        });
}

function LikeStory(storyid)
{
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
        		        $myjquery("#Like-Story-Link-" + storyid).removeAttr("href");
        		        $myjquery("#Like-Story-Link-" + storyid).html('<img class = "story-like-image" src = "' + rootURL + 'images/website/connichiwahloggedinhomef-10.jpg" alt = "" />');
        		    }
            	}
            }
        });
}

function GetStoryData(storyid)
{
    //alert("hi");
    $myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=GetStoryData",
            data: "storyid=" + storyid,
            success: function(data)
            {
                $myjquery(".dark-gray-heading").html("<a href = '" + $myjquery(data).find('url').text() + "'>" + $myjquery(data).find('stitle').text() + "</a>");
                var tags = $myjquery(data).find('tags').text().trim();
                $myjquery(".light-gray-box-img").attr("src", $myjquery(data).find('imgMember').text());
                $myjquery(".box-member-comment-text").html($myjquery(data).find('comment').text() + "<a class = 'box-member-comment-read-more' href = '" + $myjquery(data).find('url').text() + "'>read more...</a>");
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
            $myjquery("#flicker-images").append('<img src = "' +  src + '" alt = "" />');
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

function doSearch()
{
//    if($myjquery("#message-div").size() == 0)
//    {
//        // add message div
//        $myjquery("body").append('<div id = "message-div">Search Not Implemented yet</div>');
//        AttachMessageDivEvents()
//    }
//    else    
//    {
//        // replcace content of message div and show it
//        $myjquery("#message-div").html("Search Not Implemented yet");
//        AttachMessageDivEvents()
//    }
    
    return false;
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