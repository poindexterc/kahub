/*
* Notify Bar - jQuery plugin
*
* Copyright (c) 2009-2010 Dmitri Smirnov
*
* Licensed under the MIT license:
* http://www.opensource.org/licenses/mit-license.php
*
* Version: 1.2.2
*
* Project home:
* http://www.dmitri.me/blog/notify-bar
*/
 
/**
* param Object
*/
jQuery.notifyBar = function(settings) {
  
  (function($) {
    
    var bar = notifyBarNS = {};
    notifyBarNS.shown = false;
     
    if( !settings) {
    settings = {};
    }
    // HTML inside bar
    notifyBarNS.html = settings.html || "Your message here";
     
    //How long bar will be delayed, doesn't count animation time.
    notifyBarNS.delay = settings.delay || 2000;
     
    //How long notifyBarNS bar will be slided up and down
    notifyBarNS.animationSpeed = settings.animationSpeed || 200;
     
    //Use own jquery object usually DIV, or use default
    notifyBarNS.jqObject = settings.jqObject;
     
    //Set up own class
    notifyBarNS.cls = settings.cls || "";
    
    //close button
    notifyBarNS.close = settings.close || false;
    
    if( notifyBarNS.jqObject) {
      bar = notifyBarNS.jqObject;
      notifyBarNS.html = bar.html();
    } else {
      bar = jQuery("<div></div>")
      .addClass("jquery-notify-bar")
      .addClass(notifyBarNS.cls)
      .attr("id", "__notifyBar");
    }
         
    bar.html(notifyBarNS.html).hide();
    var id = bar.attr("id");
    switch (notifyBarNS.animationSpeed) {
      case "slow":
      asTime = 600;
      break;
      case "normal":
      asTime = 400;
      break;
      case "fast":
      asTime = 200;
      break;
      default:
      asTime = notifyBarNS.animationSpeed;
    }
    if( bar != 'object'); {
      jQuery("body").prepend(bar);
    }
    
    // Style close button in CSS file
    if( notifyBarNS.close) {
      bar.append(jQuery("<a href='#' class='notify-bar-close'>&times;</a>"));
      jQuery(".notify-bar-close").click(function() {
        if( bar.attr("id") == "__notifyBar") {
          jQuery("#" + id).slideUp(asTime, function() { jQuery("#" + id).remove() });
        } else {
          jQuery("#" + id).slideUp(asTime);
        }
        return false;
      });
    }
    
  // Check if we've got any visible bars and if we have, slide them up before showing the new one
  if($('.jquery-notify-bar:visible').length > 0) {
    $('.jquery-notify-bar:visible').stop().slideUp(asTime, function() {
      bar.stop().slideDown(asTime);
    });
  } else {
    bar.slideDown(asTime);
  }
  
  // Allow the user to click on the bar to close it
  bar.click(function() {
    $(this).slideUp(asTime);
  })
     
  // If taken from DOM dot not remove just hide
  if( bar.attr("id") == "__notifyBar") {
    setTimeout("jQuery('#" + id + "').stop().slideUp(" + asTime +", function() {jQuery('#" + id + "').remove()});", notifyBarNS.delay + asTime);
  } else {
    setTimeout("jQuery('#" + id + "').stop().slideUp(" + asTime +", function() {jQuery('#" + id + "')});", notifyBarNS.delay + asTime);
  }

})(jQuery) };
// ColorBox v1.3.17.2 - a full featured, light-weight, customizable lightbox based on jQuery 1.3+
// Copyright (c) 2011 Jack Moore - jack@colorpowered.com
// Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
(function(a,b,c){function bc(b){if(!U){P=b,_(),y=a(P),Q=0,K.rel!=="nofollow"&&(y=a("."+g).filter(function(){var b=a.data(this,e).rel||this.rel;return b===K.rel}),Q=y.index(P),Q===-1&&(y=y.add(P),Q=y.length-1));if(!S){S=T=!0,r.show();if(K.returnFocus)try{P.blur(),a(P).one(l,function(){try{this.focus()}catch(a){}})}catch(c){}q.css({opacity:+K.opacity,cursor:K.overlayClose?"pointer":"auto"}).show(),K.w=Z(K.initialWidth,"x"),K.h=Z(K.initialHeight,"y"),X.position(),o&&z.bind("resize."+p+" scroll."+p,function(){q.css({width:z.width(),height:z.height(),top:z.scrollTop(),left:z.scrollLeft()})}).trigger("resize."+p),ba(h,K.onOpen),J.add(D).hide(),I.html(K.close).show()}X.load(!0)}}function bb(){var a,b=f+"Slideshow_",c="click."+f,d,e,g;K.slideshow&&y[1]?(d=function(){F.text(K.slideshowStop).unbind(c).bind(j,function(){if(Q<y.length-1||K.loop)a=setTimeout(X.next,K.slideshowSpeed)}).bind(i,function(){clearTimeout(a)}).one(c+" "+k,e),r.removeClass(b+"off").addClass(b+"on"),a=setTimeout(X.next,K.slideshowSpeed)},e=function(){clearTimeout(a),F.text(K.slideshowStart).unbind([j,i,k,c].join(" ")).one(c,d),r.removeClass(b+"on").addClass(b+"off")},K.slideshowAuto?d():e()):r.removeClass(b+"off "+b+"on")}function ba(b,c){c&&c.call(P),a.event.trigger(b)}function _(b){K=a.extend({},a.data(P,e));for(b in K)a.isFunction(K[b])&&b.substring(0,2)!=="on"&&(K[b]=K[b].call(P));K.rel=K.rel||P.rel||"nofollow",K.href=K.href||a(P).attr("href"),K.title=K.title||P.title,typeof K.href=="string"&&(K.href=a.trim(K.href))}function $(a){return K.photo||/\.(gif|png|jpg|jpeg|bmp)(?:\?([^#]*))?(?:#(\.*))?$/i.test(a)}function Z(a,b){return Math.round((/%/.test(a)?(b==="x"?z.width():z.height())/100:1)*parseInt(a,10))}function Y(c,d,e){e=b.createElement("div"),c&&(e.id=f+c),e.style.cssText=d||"";return a(e)}var d={transition:"elastic",speed:300,width:!1,initialWidth:"600",innerWidth:!1,maxWidth:!1,height:!1,initialHeight:"450",innerHeight:!1,maxHeight:!1,scalePhotos:!0,scrolling:!0,inline:!1,html:!1,iframe:!1,fastIframe:!0,photo:!1,href:!1,title:!1,rel:!1,opacity:.9,preloading:!0,current:"image {current} of {total}",previous:"previous",next:"next",close:"close",open:!1,returnFocus:!0,loop:!0,slideshow:!1,slideshowAuto:!0,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",onOpen:!1,onLoad:!1,onComplete:!1,onCleanup:!1,onClosed:!1,overlayClose:!0,escKey:!0,arrowKey:!0,top:!1,bottom:!1,left:!1,right:!1,fixed:!1,data:!1},e="colorbox",f="cbox",g=f+"Element",h=f+"_open",i=f+"_load",j=f+"_complete",k=f+"_cleanup",l=f+"_closed",m=f+"_purge",n=a.browser.msie&&!a.support.opacity,o=n&&a.browser.version<7,p=f+"_IE6",q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X;X=a.fn[e]=a[e]=function(b,c){var f=this;b=b||{};if(!f[0]){if(f.selector)return f;f=a("<a/>"),b.open=!0}c&&(b.onComplete=c),f.each(function(){a.data(this,e,a.extend({},a.data(this,e)||d,b)),a(this).addClass(g)}),(a.isFunction(b.open)&&b.open.call(f)||b.open)&&bc(f[0]);return f},X.init=function(){z=a(c),r=Y().attr({id:e,"class":n?f+(o?"IE6":"IE"):""}),q=Y("Overlay",o?"position:absolute":"").hide(),s=Y("Wrapper"),t=Y("Content").append(A=Y("LoadedContent","width:0; height:0; overflow:hidden"),C=Y("LoadingOverlay").add(Y("LoadingGraphic")),D=Y("Title"),E=Y("Current"),G=Y("Next"),H=Y("Previous"),F=Y("Slideshow").bind(h,bb),I=Y("Close")),s.append(Y().append(Y("TopLeft"),u=Y("TopCenter"),Y("TopRight")),Y(!1,"clear:left").append(v=Y("MiddleLeft"),t,w=Y("MiddleRight")),Y(!1,"clear:left").append(Y("BottomLeft"),x=Y("BottomCenter"),Y("BottomRight"))).children().children().css({"float":"left"}),B=Y(!1,"position:absolute; width:9999px; visibility:hidden; display:none"),a("body").prepend(q,r.append(s,B)),t.children().hover(function(){a(this).addClass("hover")},function(){a(this).removeClass("hover")}).addClass("hover"),L=u.height()+x.height()+t.outerHeight(!0)-t.height(),M=v.width()+w.width()+t.outerWidth(!0)-t.width(),N=A.outerHeight(!0),O=A.outerWidth(!0),r.css({"padding-bottom":L,"padding-right":M}).hide(),G.click(function(){X.next()}),H.click(function(){X.prev()}),I.click(function(){X.close()}),J=G.add(H).add(E).add(F),t.children().removeClass("hover"),q.click(function(){K.overlayClose&&X.close()}),a(b).bind("keydown."+f,function(a){var b=a.keyCode;S&&K.escKey&&b===27&&(a.preventDefault(),X.close()),S&&K.arrowKey&&y[1]&&(b===37?(a.preventDefault(),H.click()):b===39&&(a.preventDefault(),G.click()))})},X.remove=function(){r.add(q).remove(),a("."+g).removeData(e).removeClass(g)},X.position=function(a,c){function g(a){u[0].style.width=x[0].style.width=t[0].style.width=a.style.width,C[0].style.height=C[1].style.height=t[0].style.height=v[0].style.height=w[0].style.height=a.style.height}var d=0,e=0;z.unbind("resize."+f),r.hide(),K.fixed&&!o?r.css({position:"fixed"}):(d=z.scrollTop(),e=z.scrollLeft(),r.css({position:"absolute"})),K.right!==!1?e+=Math.max(z.width()-K.w-O-M-Z(K.right,"x"),0):K.left!==!1?e+=Z(K.left,"x"):e+=Math.round(Math.max(z.width()-K.w-O-M,0)/2),K.bottom!==!1?d+=Math.max(b.documentElement.clientHeight-K.h-N-L-Z(K.bottom,"y"),0):K.top!==!1?d+=Z(K.top,"y"):d+=Math.round(Math.max(b.documentElement.clientHeight-K.h-N-L,0)/2),r.show(),a=r.width()===K.w+O&&r.height()===K.h+N?0:a||0,s[0].style.width=s[0].style.height="9999px",r.dequeue().animate({width:K.w+O,height:K.h+N,top:d,left:e},{duration:a,complete:function(){g(this),T=!1,s[0].style.width=K.w+O+M+"px",s[0].style.height=K.h+N+L+"px",c&&c(),setTimeout(function(){z.bind("resize."+f,X.position)},1)},step:function(){g(this)}})},X.resize=function(a){if(S){a=a||{},a.width&&(K.w=Z(a.width,"x")-O-M),a.innerWidth&&(K.w=Z(a.innerWidth,"x")),A.css({width:K.w}),a.height&&(K.h=Z(a.height,"y")-N-L),a.innerHeight&&(K.h=Z(a.innerHeight,"y"));if(!a.innerHeight&&!a.height){var b=A.wrapInner("<div style='overflow:auto'></div>").children();K.h=b.height(),b.replaceWith(b.children())}A.css({height:K.h}),X.position(K.transition==="none"?0:K.speed)}},X.prep=function(b){function h(){K.h=K.h||A.height(),K.h=K.mh&&K.mh<K.h?K.mh:K.h;return K.h}function g(){K.w=K.w||A.width(),K.w=K.mw&&K.mw<K.w?K.mw:K.w;return K.w}if(!!S){var c,d=K.transition==="none"?0:K.speed;A.remove(),A=Y("LoadedContent").append(b),A.hide().appendTo(B.show()).css({width:g(),overflow:K.scrolling?"auto":"hidden"}).css({height:h()}).prependTo(t),B.hide(),a(R).css({"float":"none"}),o&&a("select").not(r.find("select")).filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one(k,function(){this.style.visibility="inherit"}),c=function(){function o(){n&&r[0].style.removeAttribute("filter")}var b,c,g,h,i=y.length,k,l;!S||(l=function(){clearTimeout(W),C.hide(),ba(j,K.onComplete)},n&&R&&A.fadeIn(100),D.html(K.title).add(A).show(),i>1?(typeof K.current=="string"&&E.html(K.current.replace("{current}",Q+1).replace("{total}",i)).show(),G[K.loop||Q<i-1?"show":"hide"]().html(K.next),H[K.loop||Q?"show":"hide"]().html(K.previous),b=Q?y[Q-1]:y[i-1],g=Q<i-1?y[Q+1]:y[0],K.slideshow&&F.show(),K.preloading&&(h=a.data(g,e).href||g.href,c=a.data(b,e).href||b.href,h=a.isFunction(h)?h.call(g):h,c=a.isFunction(c)?c.call(b):c,$(h)&&(a("<img/>")[0].src=h),$(c)&&(a("<img/>")[0].src=c))):J.hide(),K.iframe?(k=a("<iframe/>").addClass(f+"Iframe")[0],K.fastIframe?l():a(k).one("load",l),k.name=f+ +(new Date),k.src=K.href,K.scrolling||(k.scrolling="no"),n&&(k.frameBorder=0,k.allowTransparency="true"),a(k).appendTo(A).one(m,function(){k.src="//about:blank"})):l(),K.transition==="fade"?r.fadeTo(d,1,o):o())},K.transition==="fade"?r.fadeTo(d,0,function(){X.position(0,c)}):X.position(d,c)}},X.load=function(b){var c,d,e=X.prep;T=!0,R=!1,P=y[Q],b||_(),ba(m),ba(i,K.onLoad),K.h=K.height?Z(K.height,"y")-N-L:K.innerHeight&&Z(K.innerHeight,"y"),K.w=K.width?Z(K.width,"x")-O-M:K.innerWidth&&Z(K.innerWidth,"x"),K.mw=K.w,K.mh=K.h,K.maxWidth&&(K.mw=Z(K.maxWidth,"x")-O-M,K.mw=K.w&&K.w<K.mw?K.w:K.mw),K.maxHeight&&(K.mh=Z(K.maxHeight,"y")-N-L,K.mh=K.h&&K.h<K.mh?K.h:K.mh),c=K.href,W=setTimeout(function(){C.show()},100),K.inline?(Y().hide().insertBefore(a(c)[0]).one(m,function(){a(this).replaceWith(A.children())}),e(a(c))):K.iframe?e(" "):K.html?e(K.html):$(c)?(a(R=new Image).addClass(f+"Photo").error(function(){K.title=!1,e(Y("Error").text("This image could not be loaded"))}).load(function(){var a;R.onload=null,K.scalePhotos&&(d=function(){R.height-=R.height*a,R.width-=R.width*a},K.mw&&R.width>K.mw&&(a=(R.width-K.mw)/R.width,d()),K.mh&&R.height>K.mh&&(a=(R.height-K.mh)/R.height,d())),K.h&&(R.style.marginTop=Math.max(K.h-R.height,0)/2+"px"),y[1]&&(Q<y.length-1||K.loop)&&(R.style.cursor="pointer",R.onclick=function(){X.next()}),n&&(R.style.msInterpolationMode="bicubic"),setTimeout(function(){e(R)},1)}),setTimeout(function(){R.src=c},1)):c&&B.load(c,K.data,function(b,c,d){e(c==="error"?Y("Error").text("Request unsuccessful: "+d.statusText):a(this).contents())})},X.next=function(){!T&&y[1]&&(Q<y.length-1||K.loop)&&(Q=Q<y.length-1?Q+1:0,X.load())},X.prev=function(){!T&&y[1]&&(Q||K.loop)&&(Q=Q?Q-1:y.length-1,X.load())},X.close=function(){S&&!U&&(U=!0,S=!1,ba(k,K.onCleanup),z.unbind("."+f+" ."+p),q.fadeTo(200,0),r.stop().fadeTo(300,0,function(){r.add(q).css({opacity:1,cursor:"auto"}).hide(),ba(m),A.remove(),setTimeout(function(){U=!1,ba(l,K.onClosed)},1)}))},X.element=function(){return a(P)},X.settings=d,V=function(a){a.button!==0&&typeof a.button!="undefined"||a.ctrlKey||a.shiftKey||a.altKey||(a.preventDefault(),bc(this))},a.fn.delegate?a(b).delegate("."+g,"click",V):a("."+g).live("click",V),a(X.init)})(jQuery,document,this);
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
    $myjquery("a[rel='gallery']").colorbox({transition:"none"});
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
function isValidURL(url)
{
	var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	
	if(RegExp.test(url)){
		return true;
	}else{
		return false;
	}
}
function parse_linkPhoto ()
{
    console.log("photo");
    var url = $myjquery('#tagPhoto').text();
	
	if(!isValidURL($myjquery('#tagPhoto').val()))
	{
	    console.log(escape(url));
		//return false;
	}
	else
	{			
		$myjquery('#tagPhoto').hide();
		$myjquery('#magicPhoto').show();
		_kmq.push(['record', 'Clicked Share linkPhoto']);
		$myjquery.post("http://www.kahub.com/l/fetch.php?url="+escape($myjquery('#tagPhoto').val()), {}, function(response){
			$myjquery('#magicPhoto').hide();
			//Set Content
			$myjquery('#atc_titlePhoto').html(response.title);
			$myjquery('#atc_descPhoto').html(response.description);
			$myjquery('#storyIDPhoto').val(response.storyID);
			
			//Flip Viewable Content 
			$myjquery('#attach_contentPhoto').fadeIn('slow');
			$myjquery('#atc_loadingPhoto').hide();
			
			//Show first image
			
			// next image
			
			// prev image
		});
	}
};

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
function PostVideoHub(storyid)
{
	var comment = escape($myjquery('#commentVideo').val());
	console.log(comment);
    console.log("replystart");
	if(comment=="NULL"){
		$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Rebecca Black's fault.", close: true, delay: 5000 });
		return false;
	}
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=PostVideoHub",
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
						_kmq.push(['record', 'CommentVideoPublic']);
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
function PostPhotoHub(storyid)
{
	var comment = escape($myjquery('#commentPhoto').val());
	var image = escape($myjquery("#photopreview").attr("src"));
	console.log(comment);
    console.log("replystart");
	if(comment=="NULL"){
		$myjquery.notifyBar({ html: "Shoot! Something went wrong. It was most likely Rebecca Black's fault.", close: true, delay: 5000 });
		return false;
	}
	$myjquery.ajax(
        {
            type: "POST",
            url: sWebServiceURL + "?method=PostPhotoHub",
            data: "storyID=" + storyid + "&comment=" + escape(comment) + "&image=" +escape(image),
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
						_kmq.push(['record', 'CommentPhotoPublic']);
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
				$textarea.bind('keyup change cut', function(){
					update(); 
					if ($myjquery("#commentAreaPhoto").length){
					    $myjquery("#commentPhotoForm label").inFieldLabels();
					}
				});
				$textarea.bind('paste', function(){
					if ($myjquery("#commentPhotoForm").length){
					    $myjquery("#commentPhotoForm label").inFieldLabels();
					    setTimeout(function() {parse_linkPhoto()}, 300);
					    //return false;
					}
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
/*
 * jQuery UI Effects 1.8.14
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/
 */
jQuery.effects||function(f,j){function m(c){var a;if(c&&c.constructor==Array&&c.length==3)return c;if(a=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(c))return[parseInt(a[1],10),parseInt(a[2],10),parseInt(a[3],10)];if(a=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(c))return[parseFloat(a[1])*2.55,parseFloat(a[2])*2.55,parseFloat(a[3])*2.55];if(a=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(c))return[parseInt(a[1],
16),parseInt(a[2],16),parseInt(a[3],16)];if(a=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(c))return[parseInt(a[1]+a[1],16),parseInt(a[2]+a[2],16),parseInt(a[3]+a[3],16)];if(/rgba\(0, 0, 0, 0\)/.exec(c))return n.transparent;return n[f.trim(c).toLowerCase()]}function s(c,a){var b;do{b=f.curCSS(c,a);if(b!=""&&b!="transparent"||f.nodeName(c,"body"))break;a="backgroundColor"}while(c=c.parentNode);return m(b)}function o(){var c=document.defaultView?document.defaultView.getComputedStyle(this,null):this.currentStyle,
a={},b,d;if(c&&c.length&&c[0]&&c[c[0]])for(var e=c.length;e--;){b=c[e];if(typeof c[b]=="string"){d=b.replace(/\-(\w)/g,function(g,h){return h.toUpperCase()});a[d]=c[b]}}else for(b in c)if(typeof c[b]==="string")a[b]=c[b];return a}function p(c){var a,b;for(a in c){b=c[a];if(b==null||f.isFunction(b)||a in t||/scrollbar/.test(a)||!/color/i.test(a)&&isNaN(parseFloat(b)))delete c[a]}return c}function u(c,a){var b={_:0},d;for(d in a)if(c[d]!=a[d])b[d]=a[d];return b}function k(c,a,b,d){if(typeof c=="object"){d=
a;b=null;a=c;c=a.effect}if(f.isFunction(a)){d=a;b=null;a={}}if(typeof a=="number"||f.fx.speeds[a]){d=b;b=a;a={}}if(f.isFunction(b)){d=b;b=null}a=a||{};b=b||a.duration;b=f.fx.off?0:typeof b=="number"?b:b in f.fx.speeds?f.fx.speeds[b]:f.fx.speeds._default;d=d||a.complete;return[c,a,b,d]}function l(c){if(!c||typeof c==="number"||f.fx.speeds[c])return true;if(typeof c==="string"&&!f.effects[c])return true;return false}f.effects={};f.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor",
"borderTopColor","borderColor","color","outlineColor"],function(c,a){f.fx.step[a]=function(b){if(!b.colorInit){b.start=s(b.elem,a);b.end=m(b.end);b.colorInit=true}b.elem.style[a]="rgb("+Math.max(Math.min(parseInt(b.pos*(b.end[0]-b.start[0])+b.start[0],10),255),0)+","+Math.max(Math.min(parseInt(b.pos*(b.end[1]-b.start[1])+b.start[1],10),255),0)+","+Math.max(Math.min(parseInt(b.pos*(b.end[2]-b.start[2])+b.start[2],10),255),0)+")"}});var n={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,
0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,
211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]},q=["add","remove","toggle"],t={border:1,borderBottom:1,borderColor:1,borderLeft:1,borderRight:1,borderTop:1,borderWidth:1,margin:1,padding:1};f.effects.animateClass=function(c,a,b,
d){if(f.isFunction(b)){d=b;b=null}return this.queue(function(){var e=f(this),g=e.attr("style")||" ",h=p(o.call(this)),r,v=e.attr("class");f.each(q,function(w,i){c[i]&&e[i+"Class"](c[i])});r=p(o.call(this));e.attr("class",v);e.animate(u(h,r),{queue:false,duration:a,easing:b,complete:function(){f.each(q,function(w,i){c[i]&&e[i+"Class"](c[i])});if(typeof e.attr("style")=="object"){e.attr("style").cssText="";e.attr("style").cssText=g}else e.attr("style",g);d&&d.apply(this,arguments);f.dequeue(this)}})})};
f.fn.extend({_addClass:f.fn.addClass,addClass:function(c,a,b,d){return a?f.effects.animateClass.apply(this,[{add:c},a,b,d]):this._addClass(c)},_removeClass:f.fn.removeClass,removeClass:function(c,a,b,d){return a?f.effects.animateClass.apply(this,[{remove:c},a,b,d]):this._removeClass(c)},_toggleClass:f.fn.toggleClass,toggleClass:function(c,a,b,d,e){return typeof a=="boolean"||a===j?b?f.effects.animateClass.apply(this,[a?{add:c}:{remove:c},b,d,e]):this._toggleClass(c,a):f.effects.animateClass.apply(this,
[{toggle:c},a,b,d])},switchClass:function(c,a,b,d,e){return f.effects.animateClass.apply(this,[{add:a,remove:c},b,d,e])}});f.extend(f.effects,{version:"1.8.14",save:function(c,a){for(var b=0;b<a.length;b++)a[b]!==null&&c.data("ec.storage."+a[b],c[0].style[a[b]])},restore:function(c,a){for(var b=0;b<a.length;b++)a[b]!==null&&c.css(a[b],c.data("ec.storage."+a[b]))},setMode:function(c,a){if(a=="toggle")a=c.is(":hidden")?"show":"hide";return a},getBaseline:function(c,a){var b;switch(c[0]){case "top":b=
0;break;case "middle":b=0.5;break;case "bottom":b=1;break;default:b=c[0]/a.height}switch(c[1]){case "left":c=0;break;case "center":c=0.5;break;case "right":c=1;break;default:c=c[1]/a.width}return{x:c,y:b}},createWrapper:function(c){if(c.parent().is(".ui-effects-wrapper"))return c.parent();var a={width:c.outerWidth(true),height:c.outerHeight(true),"float":c.css("float")},b=f("<div></div>").addClass("ui-effects-wrapper").css({fontSize:"100%",background:"transparent",border:"none",margin:0,padding:0});
c.wrap(b);b=c.parent();if(c.css("position")=="static"){b.css({position:"relative"});c.css({position:"relative"})}else{f.extend(a,{position:c.css("position"),zIndex:c.css("z-index")});f.each(["top","left","bottom","right"],function(d,e){a[e]=c.css(e);if(isNaN(parseInt(a[e],10)))a[e]="auto"});c.css({position:"relative",top:0,left:0,right:"auto",bottom:"auto"})}return b.css(a).show()},removeWrapper:function(c){if(c.parent().is(".ui-effects-wrapper"))return c.parent().replaceWith(c);return c},setTransition:function(c,
a,b,d){d=d||{};f.each(a,function(e,g){unit=c.cssUnit(g);if(unit[0]>0)d[g]=unit[0]*b+unit[1]});return d}});f.fn.extend({effect:function(c){var a=k.apply(this,arguments),b={options:a[1],duration:a[2],callback:a[3]};a=b.options.mode;var d=f.effects[c];if(f.fx.off||!d)return a?this[a](b.duration,b.callback):this.each(function(){b.callback&&b.callback.call(this)});return d.call(this,b)},_show:f.fn.show,show:function(c){if(l(c))return this._show.apply(this,arguments);else{var a=k.apply(this,arguments);
a[1].mode="show";return this.effect.apply(this,a)}},_hide:f.fn.hide,hide:function(c){if(l(c))return this._hide.apply(this,arguments);else{var a=k.apply(this,arguments);a[1].mode="hide";return this.effect.apply(this,a)}},__toggle:f.fn.toggle,toggle:function(c){if(l(c)||typeof c==="boolean"||f.isFunction(c))return this.__toggle.apply(this,arguments);else{var a=k.apply(this,arguments);a[1].mode="toggle";return this.effect.apply(this,a)}},cssUnit:function(c){var a=this.css(c),b=[];f.each(["em","px","%",
"pt"],function(d,e){if(a.indexOf(e)>0)b=[parseFloat(a),e]});return b}});f.easing.jswing=f.easing.swing;f.extend(f.easing,{def:"easeOutQuad",swing:function(c,a,b,d,e){return f.easing[f.easing.def](c,a,b,d,e)},easeInQuad:function(c,a,b,d,e){return d*(a/=e)*a+b},easeOutQuad:function(c,a,b,d,e){return-d*(a/=e)*(a-2)+b},easeInOutQuad:function(c,a,b,d,e){if((a/=e/2)<1)return d/2*a*a+b;return-d/2*(--a*(a-2)-1)+b},easeInCubic:function(c,a,b,d,e){return d*(a/=e)*a*a+b},easeOutCubic:function(c,a,b,d,e){return d*
((a=a/e-1)*a*a+1)+b},easeInOutCubic:function(c,a,b,d,e){if((a/=e/2)<1)return d/2*a*a*a+b;return d/2*((a-=2)*a*a+2)+b},easeInQuart:function(c,a,b,d,e){return d*(a/=e)*a*a*a+b},easeOutQuart:function(c,a,b,d,e){return-d*((a=a/e-1)*a*a*a-1)+b},easeInOutQuart:function(c,a,b,d,e){if((a/=e/2)<1)return d/2*a*a*a*a+b;return-d/2*((a-=2)*a*a*a-2)+b},easeInQuint:function(c,a,b,d,e){return d*(a/=e)*a*a*a*a+b},easeOutQuint:function(c,a,b,d,e){return d*((a=a/e-1)*a*a*a*a+1)+b},easeInOutQuint:function(c,a,b,d,e){if((a/=
e/2)<1)return d/2*a*a*a*a*a+b;return d/2*((a-=2)*a*a*a*a+2)+b},easeInSine:function(c,a,b,d,e){return-d*Math.cos(a/e*(Math.PI/2))+d+b},easeOutSine:function(c,a,b,d,e){return d*Math.sin(a/e*(Math.PI/2))+b},easeInOutSine:function(c,a,b,d,e){return-d/2*(Math.cos(Math.PI*a/e)-1)+b},easeInExpo:function(c,a,b,d,e){return a==0?b:d*Math.pow(2,10*(a/e-1))+b},easeOutExpo:function(c,a,b,d,e){return a==e?b+d:d*(-Math.pow(2,-10*a/e)+1)+b},easeInOutExpo:function(c,a,b,d,e){if(a==0)return b;if(a==e)return b+d;if((a/=
e/2)<1)return d/2*Math.pow(2,10*(a-1))+b;return d/2*(-Math.pow(2,-10*--a)+2)+b},easeInCirc:function(c,a,b,d,e){return-d*(Math.sqrt(1-(a/=e)*a)-1)+b},easeOutCirc:function(c,a,b,d,e){return d*Math.sqrt(1-(a=a/e-1)*a)+b},easeInOutCirc:function(c,a,b,d,e){if((a/=e/2)<1)return-d/2*(Math.sqrt(1-a*a)-1)+b;return d/2*(Math.sqrt(1-(a-=2)*a)+1)+b},easeInElastic:function(c,a,b,d,e){c=1.70158;var g=0,h=d;if(a==0)return b;if((a/=e)==1)return b+d;g||(g=e*0.3);if(h<Math.abs(d)){h=d;c=g/4}else c=g/(2*Math.PI)*Math.asin(d/
h);return-(h*Math.pow(2,10*(a-=1))*Math.sin((a*e-c)*2*Math.PI/g))+b},easeOutElastic:function(c,a,b,d,e){c=1.70158;var g=0,h=d;if(a==0)return b;if((a/=e)==1)return b+d;g||(g=e*0.3);if(h<Math.abs(d)){h=d;c=g/4}else c=g/(2*Math.PI)*Math.asin(d/h);return h*Math.pow(2,-10*a)*Math.sin((a*e-c)*2*Math.PI/g)+d+b},easeInOutElastic:function(c,a,b,d,e){c=1.70158;var g=0,h=d;if(a==0)return b;if((a/=e/2)==2)return b+d;g||(g=e*0.3*1.5);if(h<Math.abs(d)){h=d;c=g/4}else c=g/(2*Math.PI)*Math.asin(d/h);if(a<1)return-0.5*
h*Math.pow(2,10*(a-=1))*Math.sin((a*e-c)*2*Math.PI/g)+b;return h*Math.pow(2,-10*(a-=1))*Math.sin((a*e-c)*2*Math.PI/g)*0.5+d+b},easeInBack:function(c,a,b,d,e,g){if(g==j)g=1.70158;return d*(a/=e)*a*((g+1)*a-g)+b},easeOutBack:function(c,a,b,d,e,g){if(g==j)g=1.70158;return d*((a=a/e-1)*a*((g+1)*a+g)+1)+b},easeInOutBack:function(c,a,b,d,e,g){if(g==j)g=1.70158;if((a/=e/2)<1)return d/2*a*a*(((g*=1.525)+1)*a-g)+b;return d/2*((a-=2)*a*(((g*=1.525)+1)*a+g)+2)+b},easeInBounce:function(c,a,b,d,e){return d-f.easing.easeOutBounce(c,
e-a,0,d,e)+b},easeOutBounce:function(c,a,b,d,e){return(a/=e)<1/2.75?d*7.5625*a*a+b:a<2/2.75?d*(7.5625*(a-=1.5/2.75)*a+0.75)+b:a<2.5/2.75?d*(7.5625*(a-=2.25/2.75)*a+0.9375)+b:d*(7.5625*(a-=2.625/2.75)*a+0.984375)+b},easeInOutBounce:function(c,a,b,d,e){if(a<e/2)return f.easing.easeInBounce(c,a*2,0,d,e)*0.5+b;return f.easing.easeOutBounce(c,a*2-e,0,d,e)*0.5+d*0.5+b}})}(jQuery);
;/*
 * jQuery UI Effects Highlight 1.8.14
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Highlight
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(b){b.effects.highlight=function(c){return this.queue(function(){var a=b(this),e=["backgroundImage","backgroundColor","opacity"],d=b.effects.setMode(a,c.options.mode||"show"),f={backgroundColor:a.css("backgroundColor")};if(d=="hide")f.opacity=0;b.effects.save(a,e);a.show().css({backgroundImage:"none",backgroundColor:c.options.color||"#ffff99"}).animate(f,{queue:false,duration:c.duration,easing:c.options.easing,complete:function(){d=="hide"&&a.hide();b.effects.restore(a,e);d=="show"&&!b.support.opacity&&
this.style.removeAttribute("filter");c.callback&&c.callback.apply(this,arguments);a.dequeue()}})})}})(jQuery);
;/*
 * jQuery UI Effects Pulsate 1.8.14
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Pulsate
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function(d){d.effects.pulsate=function(a){return this.queue(function(){var b=d(this),c=d.effects.setMode(b,a.options.mode||"show");times=(a.options.times||5)*2-1;duration=a.duration?a.duration/2:d.fx.speeds._default/2;isVisible=b.is(":visible");animateTo=0;if(!isVisible){b.css("opacity",0).show();animateTo=1}if(c=="hide"&&isVisible||c=="show"&&!isVisible)times--;for(c=0;c<times;c++){b.animate({opacity:animateTo},duration,a.options.easing);animateTo=(animateTo+1)%2}b.animate({opacity:animateTo},duration,
a.options.easing,function(){animateTo==0&&b.hide();a.callback&&a.callback.apply(this,arguments)});b.queue("fx",function(){b.dequeue()}).dequeue()})}})(jQuery);
;

/*
 * Superfish v1.4.8 - jQuery menu widget
 * Copyright (c) 2008 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 * CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
 */

;(function($){
	$.fn.superfish = function(op){

		var sf = $.fn.superfish,
			c = sf.c,
			$arrow = $(['<span class="',c.arrowClass,'"> &#187;</span>'].join('')),
			over = function(){
				var $$ = $(this), menu = getMenu($$);
				clearTimeout(menu.sfTimer);
				$$.showSuperfishUl().siblings().hideSuperfishUl();
			},
			out = function(){
				var $$ = $(this), menu = getMenu($$), o = sf.op;
				clearTimeout(menu.sfTimer);
				menu.sfTimer=setTimeout(function(){
					o.retainPath=($.inArray($$[0],o.$path)>-1);
					$$.hideSuperfishUl();
					if (o.$path.length && $$.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.$path);}
				},o.delay);	
			},
			getMenu = function($menu){
				var menu = $menu.parents(['ul.',c.menuClass,':first'].join(''))[0];
				sf.op = sf.o[menu.serial];
				return menu;
			},
			addArrow = function($a){ $a.addClass(c.anchorClass).append($arrow.clone()); };
			
		return this.each(function() {
			var s = this.serial = sf.o.length;
			var o = $.extend({},sf.defaults,op);
			o.$path = $('li.'+o.pathClass,this).slice(0,o.pathLevels).each(function(){
				$(this).addClass([o.hoverClass,c.bcClass].join(' '))
					.filter('li:has(ul)').removeClass(o.pathClass);
			});
			sf.o[s] = sf.op = o;
			
			$('li:has(ul)',this)[($.fn.hoverIntent && !o.disableHI) ? 'hoverIntent' : 'hover'](over,out).each(function() {
				if (o.autoArrows) addArrow( $('>a:first-child',this) );
			})
			.not('.'+c.bcClass)
				.hideSuperfishUl();
			
			var $a = $('a',this);
			$a.each(function(i){
				var $li = $a.eq(i).parents('li');
				$a.eq(i).focus(function(){over.call($li);}).blur(function(){out.call($li);});
			});
			o.onInit.call(this);
			
		}).each(function() {
			var menuClasses = [c.menuClass];
			if (sf.op.dropShadows  && !($.browser.msie && $.browser.version < 7)) menuClasses.push(c.shadowClass);
			$(this).addClass(menuClasses.join(' '));
		});
	};

	var sf = $.fn.superfish;
	sf.o = [];
	sf.op = {};
	sf.IE7fix = function(){
		var o = sf.op;
		if ($.browser.msie && $.browser.version > 6 && o.dropShadows && o.animation.opacity!=undefined)
			this.toggleClass(sf.c.shadowClass+'-off');
		};
	sf.c = {
		bcClass     : 'sf-breadcrumb',
		menuClass   : 'sf-js-enabled',
		anchorClass : 'sf-with-ul',
		arrowClass  : 'sf-sub-indicator',
		shadowClass : 'sf-shadow'
	};
	sf.defaults = {
		hoverClass	: 'sfHover',
		pathClass	: 'overideThisToUse',
		pathLevels	: 1,
		delay		: 800,
		animation	: {opacity:'show'},
		speed		: 'normal',
		autoArrows	: true,
		dropShadows : true,
		disableHI	: true,		// true disables hoverIntent detection
		onInit		: function(){}, // callback functions
		onBeforeShow: function(){},
		onShow		: function(){},
		onHide		: function(){}
	};
	$.fn.extend({
		hideSuperfishUl : function(){
			var o = sf.op,
				not = (o.retainPath===true) ? o.$path : '';
			o.retainPath = false;
			var $ul = $(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass)
					.find('>ul').hide().css('visibility','hidden');
			o.onHide.call($ul);
			return this;
		},
		showSuperfishUl : function(){
			var o = sf.op,
				sh = sf.c.shadowClass+'-off',
				$ul = this.addClass(o.hoverClass)
					.find('>ul:hidden').css('visibility','visible');
			sf.IE7fix.call($ul);
			o.onBeforeShow.call($ul);
			$ul.animate(o.animation,o.speed,function(){ sf.IE7fix.call($ul); o.onShow.call($ul); });
			return this;
		}
	});

})(jQuery);
/*!
 * jQuery HTML5 Uploader 1.0b
 *
 * http://www.igloolab.com/jquery-html5-uploader
 */
(function ($) {
    $.fn.html5Uploader = function (options) {
        var crlf = '\r\n';
        var boundary = "iloveigloo";
        var dashes = "--";
        var settings = {
            "name": "uploadedFile",
            "postUrl": "Upload.aspx",
            "onClientAbort": null,
            "onClientError": null,
            "onClientLoad": null,
            "onClientLoadEnd": null,
            "onClientLoadStart": null,
            "onClientProgress": null,
            "onServerAbort": null,
            "onServerError": null,
            "onServerLoad": null,
            "onServerLoadStart": null,
            "onServerProgress": null,
            "onServerReadyStateChange": null
        };
        if (options) {
            $.extend(settings, options);
        }
        return this.each(function (options) {
            var $this = $(this);
            if ($this.is("[type='file']")) {
                $this.bind("change", function () {
                    var files = this.files;
                    for (var i = 0; i < files.length; i++) {
                        fileHandler(files[i]);
                    }
                });
            } else {
                $this.bind("dragenter dragover", function () {
                    return false;
                }).bind("drop", function (e) {
                    var files = e.originalEvent.dataTransfer.files;
                    for (var i = 0; i < files.length; i++) {
                        fileHandler(files[i]);
                    }
                    return false;
                });
            }
        });

        function fileHandler(file) {
            var fileReader = new FileReader();
            fileReader.onabort = function (e) {
                if (settings.onClientAbort) {
                    settings.onClientAbort(e, file);
                }
            };
            fileReader.onerror = function (e) {
                if (settings.onClientError) {
                    settings.onClientError(e, file);
                }
            };
            fileReader.onload = function (e) {
                if (settings.onClientLoad) {
                    settings.onClientLoad(e, file);
                }
            };
            fileReader.onloadend = function (e) {
                if (settings.onClientLoadEnd) {
                    settings.onClientLoadEnd(e, file);
                }
            };
            fileReader.onloadstart = function (e) {
                if (settings.onClientLoadStart) {
                    settings.onClientLoadStart(e, file);
                }
				
            };
            fileReader.onprogress = function (e) {
                if (settings.onClientProgress) {
                    settings.onClientProgress(e, file);
                }
            };
            fileReader.readAsDataURL(file);
			
            var xmlHttpRequest = new XMLHttpRequest();
            xmlHttpRequest.upload.onabort = function (e) {
                if (settings.onServerAbort) {
                    settings.onServerAbort(e, file);
                }
            };
            xmlHttpRequest.upload.onerror = function (e) {
                if (settings.onServerError) {
                    settings.onServerError(e, file);
                }
            };
            xmlHttpRequest.upload.onload = function (e) {
                if (settings.onServerLoad) {
                    settings.onServerLoad(e, file);
                }
				console.log(file.fileName);
				
            };
            xmlHttpRequest.upload.onloadstart = function (e) {
                if (settings.onServerLoadStart) {
                    settings.onServerLoadStart(e, file);
                }
            };
            xmlHttpRequest.upload.onprogress = function (e) {
                if (settings.onServerProgress) {
                    settings.onServerProgress(e, file);
                }
            };
            xmlHttpRequest.onreadystatechange = function (e) {
                if (settings.onServerReadyStateChange) {
                    settings.onServerReadyStateChange(e, file);
                }
				window.location.href="http://www.kahub.com/l/getstarted.php";
				
            };
            xmlHttpRequest.open("POST", settings.postUrl, true);
            if (file.getAsBinary) {
                var data = dashes + boundary + crlf + "Content-Disposition: form-data;" + "name=\"" + settings.name + "\";" + "filename=\"" + unescape(encodeURIComponent(file.name)) + "\"" + crlf + "Content-Type: application/octet-stream" + crlf + crlf + file.getAsBinary() + crlf + dashes + boundary + dashes;
                xmlHttpRequest.setRequestHeader("Content-Type", "multipart/form-data;boundary=" + boundary);
                xmlHttpRequest.sendAsBinary(data);
            } else if (window.FormData) {
                var formData = new FormData();
                formData.append(settings.name, file);
                xmlHttpRequest.send(formData);
				console.log(formData);
            }
        }
    };
})(jQuery);